<?php  
//print_r($tabledata);  exit;
if(!empty($tabledata)) 
{
	$count = 0;
	$insidecode = '';
	$moon = array();
	$countALLRecords=0;
	$districtrow = $allitems = array_unique(array_column($tabledata,"item_id","item_id"));
	$totalitems = count($allitems);
	$districtrow = $defaultrow = array_fill_keys($districtrow, '');
	$returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
	foreach($tabledata as $key => $value)
	{
		if($count == 0)
		{
			$returnData .= "<thead><tr><th class='Heading text-center'>";
			if($totalitems>1){
				//only show total row
				$allnames = array_map("getVaccines_name",$allitems);
				$basecolumns = array_keys($value);
				array_splice($basecolumns, -2);
				$returnData .= implode("</th><th class='Heading text-center'>",array_map("ucwords",$basecolumns));
				$returnData .= "</th><th class='Heading text-center'>";
				$returnData .= implode("</th><th class='Heading text-center'>",array_map("ucwords",$allnames));
			}else{
				unset($value["item_id"]);
				$returnData .= implode("</th><th class='Heading text-center'>",array_map("ucwords",array_keys($value)));
			}			
			$returnData .= "</th></tr></thead><tbody>";
		}
		$count++;
		$class="";
		if($totalitems>1){
			if($insidecode!=$value["code"]){
				if($insidecode!=''){
					$returnData .= implode("</td><td ", array_map(function($v){
						if(is_numeric($v)){
							return "class='text-center'>".$v;
						}
						return ">".$v;
					},array_values($districtrow)));
					$districtrow = $defaultrow;
					$returnData .= "</td></tr>";
				}
				$returnData .= '<tr class="DrillDownRow"><td ';
				$returnData .= " class='text-center'>".$value["code"]."</td><td>".$value["name"]."</td><td ";
			}
			//$districtrow[$value["item_id"]] = array_slice( $value, -1, 1, TRUE );			
			$districtrow[$value["item_id"]] = $value["value"];			
			$insidecode=$value["code"];
		}else{
			unset($value["item_id"]);
			$returnData .= '<tr class="DrillDownRow"><td ';
			$returnData .= implode("</td><td ", array_map(function($v){
				if(is_numeric($v)){
					return "class='text-center'>".$v;
				}
				return ">".$v;
			},array_values($value)));
			$returnData .= "</td></tr>";
		}				
		foreach($value as $k => $v)
		{
			if(is_numeric($v))
			{
				$moon[$k] =  key_exists($k,$moon)?$moon[$k]+$v:$v;
			}
			else{
				$moon[$k] =  key_exists($k,$moon)?$moon[$k]:$v;
			}
		}
	}
	if($totalitems>1){
		$returnData .= implode("</td><td ", array_map(function($v){
			if(is_numeric($v)){
				return "class='text-center'>".$v;
			}
			return ">".$v;
		},array_values($districtrow)));
		$returnData .= "</td></tr>";
	}
	if(count($moon) > 0 /* && $allTotal != 'NO' && $sectionTotal != 'NO' && $indicator_report=='NO' || $otherReports=='YES' */)
	{
		/*if($otherReports=='YES')
		{
			$moon = array_splice($moon, 2);
		}
		else
		{ */
			$moon = array_splice($moon, 2);
			$dropout_arr = array('Penta1-Measle1 Dropout', 'Penta1-Penta3 Dropout', 'Measle1-Measle2 Dropout', 'TT1-TT2 Dropout',);
			$flipped_dropout = array_flip($dropout_arr);
			$last_key = key( array_slice( $moon, -1, 1, TRUE ) );
			/*$product = explode(' ', $last_key);
			$item = $product[1];*/
			//print_r($moon);exit;
			if(isset($moon['Total Vaccination']) && $indicator_report!='NO')
			{
				$moon[$last_key] = round($moon['Total Vaccination']/$moon['Target']*100);
				//$moon["$item Coverage (Male)"] = round($moon["$item Vaccination (Male)"]/$moon['Target (Male)']*100,2);  
				$value = round(current($moon)/next($moon)*100);
				next($moon);
				$moon[key($moon)] = $value;
				//$moon["$item Coverage (Female)"] = round($moon["$item Vaccination (Female)"]/$moon['Target (Female)']*100,2); 
				$value = round(next($moon)/next($moon)*100);
				next($moon);
				$moon[key($moon)] = $value;
				//print_r($moon);exit;
			}
			elseif(isset($moon[$last_key]) AND isset($flipped_dropout[$last_key]))
			{
				$space_separator = explode(' ', $last_key);
				$dash_separater = explode('-', $space_separator[0]);
				if($dash_separater[0] == 'Measle1')
				{
					$dash_separater[0] = 'Measle-1';
				}
				if($dash_separater[1] == 'Measle1')
				{
					$dash_separater[1] = 'Measle-1';
				}
				if($dash_separater[1] == 'Measle2')
				{
					$dash_separater[1] = 'Measle-2';
				}
				$moon[$last_key] = round(($moon[$dash_separater[0]]-$moon[$dash_separater[1]])/$moon[$dash_separater[0]]*100,2);  
			}
		//}
		/*$returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td style='font-weight:bold; background-color: #111;color: #FFF;'></td><td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
		$returnData .= implode("</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);
		$returnData .= "</td></tr>"; */
		$moon = array();
	} 
	//for last row total
	/* if($allTotal && $indicator_report!='NO')
	{
		//print_r($allTotal);exit;
		$colspan=2;
		$CI=& get_instance();
		if($CI->uri->segment(2)=="priority-diseases" || $CI->uri->segment(2)=="morbidity")
		{
			$colspan=1;
		}
		foreach($allTotal as $key => $value)
		{
		
			$endbody ="<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td class=\"text-center\" colspan=\"$colspan\">Total</td><td class=\"text-center\">";
			$endbody .= implode("</td><td class=\"text-center\">",$value);
			$endbody .="</td></tr>";
			$returnData .= $endbody;    
			//break;
		}
	}  */ 
	if($count == 0)
	{
		$returnData .= "<thead><tr><th> No Record Found </th></tr></thead><tbody>";
	}
	$returnData .= "</tbody></table>";
}
else
{
	$returnData = "<div class='alert alert-info' style='text-align:center; width:26%;border-color:#090909;margin-left:31%' role='alert'><label>Sorry! No Record Found</label></div>";
}
$returnData = str_replace('BOPV','bOPV',$returnData);
echo $returnData;
?>