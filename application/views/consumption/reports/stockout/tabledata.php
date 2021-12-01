<?php 
if(!empty($tabledata)) 
{
	$count = 0;
	$insidecode = '';
	$moon = array();
	$countALLRecords=0;
	$districtrow = $allitems = array_unique(array_column($tabledata,"item_id","item_id"));
	$totalitems = count($allitems);
	$lessbuffrow = $districtrow = $defaultrow = array_fill_keys($districtrow, '');
	$returnData = ' <table id="stockouttable" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
	foreach($tabledata as $key => $value)
	{
		if($count == 0)
		{
			$basecolumns = array_keys($value);
			array_splice($basecolumns, 2);
			if($report_indicator=="1"){
				$allnames = array_map("get_item_name",$allitems);
				$merging = true;
				if($report_type=="1"){
					$basecolumns = array_keys($value);
					array_splice($basecolumns, 4);
				}
			}else{
				$allnames = array_map("getVaccines_name",$allitems);
				$merging = false;
			}
			$returnData .= "<thead><tr><th class='Heading text-center' ".(($merging)?'rowspan="2"':'').">";
			if($totalitems>1){
				$returnData .= implode("</th><th class='Heading text-center' ".(($merging)?'rowspan="2"':'').">",array_map("ucwords",$basecolumns));
				$returnData .= "</th><th class='Heading text-center' ".(($merging)?'colspan="2"':'').">";
				$returnData .= implode("</th><th class='Heading text-center' ".(($merging)?'colspan="2"':'').">",array_map("ucwords",$allnames));
			}else{
				unset($value["item_id"]);
				$returnData .= implode("</th><th class='Heading text-center'>",array_map("ucwords",array_keys($value)));
			}			
			$returnData .= "</th></tr>";
			if($merging){
				$returnData .= "<tr>";
				foreach($allnames as $onename){
					if(isset($report_type) && $report_type=="2"){
						$returnData .= "<th class='Heading text-center'>Stock</th><th class='Heading text-center' >Suggested</th>";
					}else{
						$returnData .= "<th class='Heading text-center'>Stockout</th><th class='Heading text-center' >Less Buffered</th>";
					}
				}
				//$returnData .= implode("</th><th class='Heading text-center' >",array_map(function($val){return '';},$allnames));
				$returnData .= "</tr>";
			}
			$returnData .= "</thead><tbody>";
		}
		$count++;
		$class="";
		if($totalitems>1){
			if($insidecode!=$value["code"]){
				if($insidecode!=''){
					array_walk($districtrow,function($v,$kk) use($merging,$lessbuffrow,&$returnData) {
						if(is_numeric($v)){
							$returnData .= "<td class='text-center'>".$v.(($merging)?'</td><td class="text-center">'.$lessbuffrow[$kk]:'')."</td>";
						}else{
							$returnData .=  "<td >".$v.(($merging)?'</td><td>'.$lessbuffrow[$kk]:'')."</td>";
						}
					});
					$districtrow = $defaultrow;
					$returnData .= "</tr>";
				}
				$returnData .= '<tr class="DrillDownRow"><td class="text-center">'.$value["code"].'</td><td>'.$value["name"].'</td>';
				if($report_indicator=="1" && $report_type=="1" && (strlen($value["code"])==3)){
					$returnData .= "<td class='text-center'>".$value["due"]."</td><td class='text-center'>".$value["submitted"]."</td>";
				}
			}
			$districtrow[$value["item_id"]] = $value["value"];
			if($merging){
				$lessbuffrow[$value["item_id"]] = $value["lessbuff"];
			}
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
		array_walk($districtrow,function($v,$kk) use($merging,$lessbuffrow,&$returnData) {
			if(is_numeric($v)){
				$returnData .= "<td class='text-center'>".$v.(($merging)?'</td><td class="text-center">'.$lessbuffrow[$kk]:'')."</td>";
			}else{
				$returnData .=  "<td >".$v.(($merging)?'</td><td>'.$lessbuffrow[$kk]:'')."</td>";
			}
		});
		$returnData .= "</tr>";
	}
	if(count($moon) > 0 )
	{		
		$moon = array_splice($moon, 2);
		$last_key = key( array_slice( $moon, -1, 1, TRUE ) );
		if(isset($moon['Total Vaccination']) && $indicator_report!='NO')
		{
			$moon[$last_key] = round($moon['Total Vaccination']/$moon['Target']*100);
			$value = round(current($moon)/next($moon)*100);
			next($moon);
			$moon[key($moon)] = $value;
			$value = round(next($moon)/next($moon)*100);
			next($moon);
			$moon[key($moon)] = $value;
		}
		$moon = array();
	}
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