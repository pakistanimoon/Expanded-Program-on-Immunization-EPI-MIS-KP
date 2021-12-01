<?php 
if(!function_exists('authentication')){
	function authentication()
	{
		$CI = & get_instance();
		if ($CI -> session -> UserAuth != "Yes"){
			$CI -> session -> set_flashdata('message', 'You are not authorized to access this page! Please Login again!');
			redirect(base_url()); 
		}else if($CI -> session -> expire >= time()){
			$timeout1 = $CI -> session -> expire - time();
			$reset_time = round((3600 - $timeout1));
  			$CI -> session -> expire = time() + (60 * 120); 
		}else{
			$CI -> session -> set_flashdata('message', 'You are not authorized to access this page! Please Login again!');
			redirect(base_url()); 
		}
	}
}
if(!function_exists('getListingReportTable')){
     function getListingReportTable($allData,$listingFor,$allTotal=NULL,$sectionTotal = 'Yes',$indicator_report='NO',$otherReports='NO')
    {
        if(!empty($allData)) 
        { 
            $count = 0;
            $innerHead = '';
            $insiderow = '';
            $moon = array();
            $countALLRecords=0;
            $returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
            foreach($allData as $key => $value)
            {
                $id = 0;
    			$headerRow = '';
    			if (array_key_exists('id', $value)) 
                {
    				$id = $value["id"];
    				unset($value["id"]);
    			}
                if(isset($value['total']))
                {
                    if($insiderow == '' || $insiderow != $value['insiderow'])
                    {
                        $insiderow = $value['insiderow'];
                        if(count($moon) > 0)
                        {   
                            //for section total
                            array_splice($moon, 0, 2);
                            $returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td style='font-weight:bold; background-color: #111;color: #FFF;'></td><td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
                            $returnData .= implode("</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);      
                            $returnData .= "</td></tr>";
                            $moon = array();
                        } 
                        $headerRow = "<tr><td style='font-weight:bold' colspan='".(count($value)-2)."'><b>$insiderow (Total $listingFor: ".$value['total'].")</td></tr>";
                        $countALLRecords+=$value['total'];
						}
                    unset($value['insiderow']);
                    unset($value['total']);
                }
                if($count == 0)
                {
                    $returnData .= "<thead><tr><th class='Heading text-center'>";
                    $returnData .= implode("</th><th class='Heading text-center'>",array_map("ucwords",array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
                $count++;
    			$class="";
                $returnData .= $headerRow;
    			$displayNone = ($id>0)?'<td style="display:none;">'.$id.'</td>':'';
                $returnData .= '<tr class="DrillDownRow">'.$displayNone.'<td ';
                $returnData .= implode("</td><td ", array_map(function($v)/* use(&$class) */{
                            if(is_numeric($v)){
    							return "class='text-center'>".$v;
    						}
                            return ">".$v;
                        },array_values($value)));
                $returnData .= "</td></tr>";
                
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
            if(count($moon) > 0 && $allTotal != 'NO' && $sectionTotal != 'NO' && $indicator_report=='NO' || $otherReports=='YES')
            {
    			if($otherReports=='YES')
                {
    				$moon = array_splice($moon, 2);
                }
    			else
                {
    				$moon = array_splice($moon, 2);
                    //end($array);         // move the internal pointer to the end of the array
                    //$key = key($array);  // fetches the key of the element pointed to by the internal pointer
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
                }
                $returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td style='font-weight:bold; background-color: #111;color: #FFF;'></td><td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
                $returnData .= implode("</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);
                $returnData .= "</td></tr>";
                $moon = array();
            } 
            //for last row total
            if($allTotal && $indicator_report!='NO')
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
            }  
            if($count == 0)
            {
                $returnData .= "<thead><tr><th> No Record Found </th></tr></thead><tbody>";
            }
            return $returnData .= "</tbody></table>";
        }
        else
        {
            return $returnData = "<div class='alert alert-info' style='text-align:center; width:26%;border-color:#090909;margin-left:31%' role='alert'><label>Sorry! No Record Found</label></div>";
        }
    }
}
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}
function getDistComplianceFMVRReportTable($allData,$allTotal=NULL,$allTotalDue=NULL,$timelycomplete=NULL){
    $count = 0;
    $returnData = '<div id="parent"><table id="fixTable" class="table table-bordered table-hover">';
	foreach($allData as $key => $value)
    {
        if($count == 0)
        {
            $returnData .= "<thead>";
            $returnData .= "<tr style='background-color: #15681E;color: #FFF;' ><th class='text-center'>";
            $returnData .= implode("</th><th class='text-center'>", array_map('ucwords',array_keys($value)));
            $returnData .= "</th></tr></thead><tbody id=\"tbody tablebody\">";
            $count++;
        }           
        $body ="<tr><td class=''>";
        $counter = 1;$code='';
        $body .= implode("</td><td class=''>",array_map(function($v)use(&$counter,$value,&$code,&$timelycomplete){
            if($counter==1)
                $code = $v;
            if($counter <= 3)
            {
                $counter++;
                return '<p class="Compliance" style="padding-top: 2px;color:black;" data-value="'.$code.'">'.$v.'</p>';
            }
			$newvalueCounter = $counter++;
            if($newvalueCounter == count($value) || ($newvalueCounter == (count($value)-1) AND $timelycomplete=='yes')){
              //  $parts = explode('::',$v);for animations
				//return '<b class="text-center" style="color:black;">'.$parts[0].'<div class="circle" data-percent="'.$parts[1].'"><strong></strong></div></b>';
				return '<b class="text-center" style="color:black;">'.$v.'</b>';
			}
			if($v>=1)
            {
				return '<p class="mrClicked text-center"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'">&#10004;</p>';
			    //return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'" src="../includes/images/'.$v.'.png" />';
            }else if($v=='zr')
            {
                return '<p class="mrClicked text-center"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'">ZR</p>';
			    //return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'" src="../includes/images/'.$v.'.png" />';
            }else if($v=='timely')
            {
                return '<p class="mrClicked text-center"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'"><img style="width:20px;" title="Timely" src="'.base_url().'includes/images/timely.png"></p>';
            }else if($v=='complete')
            {
                return '<p class="mrClicked text-center" title="Complete"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'">&#10004;</p>';
            }else if($v=='notsubmitted')
            {
                return '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
            }
			else{
            	/*if($v=='1'){ $v="<p>&#10004;</p>"; }else{ $v="<p>&#xf00d;</p>"; }*/
            	return '<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
                //return "<img width='20' height='20' src=\"../includes/images/".$v.".png\" />";
            } 
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td class=\'tduc\'></td>','<td style="color:black;" class=\'tduc\'>0</td>',$body);
    }
    /* if($allTotalDue)
    {
        $endbody ="<tr><td></td><td style='font-weight:bold;'>Total Due:</td>";
        for($ind = 1; $ind<13; $ind++)
        {
            $endbody .= "<td class='text-center'>".$allTotalDue."</td>";
        }
        $endbody .="<td class='text-center'>".($allTotalDue*12)."</td></tr>";
        $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);
    } */   
    if($allTotal)
    {
		if($timelycomplete){
			$titleArray=array('Total Timeliness','Total Completeness');
		}
        foreach($allTotal as $key => $value)
        {
			if($timelycomplete){
				$endbody ="<tr style='font-weight:bold;'><td></td><td style='color:black;'>".$titleArray[$key].":</td><td style='color:black;' class='text-center'>";
			}else{
				$endbody ="<tr style='font-weight:bold;'><td></td><td style='color:black;'>Total Submited:</td><td style='color:black;' class='text-center'>";
			}
            $endbody .= implode("</td><td style='color:black;' class='text-center'>",$value);
            $endbody .="</td></tr>";
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
        }
    }
    return $returnData .= "</tbody></table></div>";
}
function getProComplianceFMVRReportTable($allData,$allTotal=NULL,$allTotalDue=NULL){       
    $count = 0;
    $returnData = '<table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-condensed tableuc table-vcenter row-border order-column">';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
            $returnData .= "<thead>";
			$returnData .= "<tr style='background-color: #15681E;color: #FFF;' ><th class='text-center' colspan=2></th><th class='text-center' colspan=3>";
            $returnData .= implode("</th><th class='text-center' colspan=3>", array_map('ucwords',array_values($headNames)));
            $returnData .= "</th></tr>";
            $returnData .= "<tr ><th class='text-center'>";
			$counter = 1;
            $returnData .= implode("</th><th class='text-center'>", array_map(function($v)use(&$counter){
							if($counter++ > 2)
								return ucwords(substr($v, 0, -2));
							return ucwords($v);
						},array_keys($value)));
            $returnData .= "</th></tr></thead><tbody>";
            $count++;
        }           
        $body ="<tr><td class='tduc'>";
        $counter = 1;$code='';
        $body .= implode("</td><td class='tduc'>",array_map(function($v)use(&$counter,$value,&$code){
            if($counter==1)
                $code = $v;
            if($counter <= 3)
            {
                $counter++;
                return '<p class="Compliance" data-value="'.$code.'">'.$v.'</p>';
            }
            if($counter++ == count($value))
                return '<b>'.$v.'</b>';
			return $v;
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td class=\'tduc\'></td>','<td class=\'tduc\'>0</td>',$body);
    }  
    if($allTotal)
    {
        $endbody ="<tr style='font-weight:bold;'><td></td><td>Total :</td><td class='text-center'>";
        $endbody .= implode("</td><td class='text-center'>",$allTotal);
        $endbody .="</td></tr>";
        $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
    }
    return $returnData .= "</tbody></table>";
}
function showCountsComplianceReport($allData,$allTotal=NULL,$allTotalDue=NULL){       
    $count = 0;
    $returnData = '<table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-condensed tableuc table-vcenter row-border order-column">';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
			//$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
            $returnData .= "<thead>";
			//$returnData .= "<tr style='background-color: #15681E;color: #FFF;' ><th class='text-center' colspan=2></th><th class='text-center' colspan=3>";
            //$returnData .= implode("</th><th class='text-center' colspan=3>", array_map('ucwords',array_values($headNames)));
            //$returnData .= "</th></tr>";
            $returnData .= "<tr style='background-color: #15681E;color: #FFF;' ><th class='text-center'>";
			$counter = 1;
            $returnData .= implode("</th><th class='text-center'>", array_map(function($v)use(&$counter){
							if($counter++ > 2)
								return ucwords(substr($v, 0, -2));
							return ucwords($v);
						},array_keys($value)));
            $returnData .= "</th></tr></thead><tbody>";
            $count++;
        }           
        $body ="<tr class=\"mrClicked\"><td class='tduc'>";
        $counter = 1;//$code='';
        $body .= implode("</td><td class='tduc'>",array_map(function($v)use(&$counter,$value/* ,&$code */){
            /* if($counter==1)
                $code = $v;
            if($counter <= 2)
            {
                $counter++;
                return '<p class="Compliance" data-value="'.$code.'">'.$v.'</p>';
            } */
            if($counter++ == count($value))
                return '<b>'.$v.'</b>';
			return $v;
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td class=\'tduc\'></td>','<td class=\'tduc\'>0</td>',$body);
    }  
    if($allTotal && $count>0)
    {
        $endbody ="<tr style='font-weight:bold;'><td></td><td>Total :";
        $endbody .= implode("</td><td class='text-center'>",$allTotal[0]);
        $endbody .="</td></tr>";
        $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
    }
	if($count==0)
    {
        $endbody ="<tr style='font-weight:bold;'><td>No Record Found.</td></tr>";
        $returnData .= $endbody;        
    }
    return $returnData .= "</tbody></table>";
}
function showListingReport($allData,$allTotal=NULL,$allTotalDue=NULL){       
    $count = 0;
    $returnData = '<table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-condensed tableuc table-vcenter row-border order-column tbl-listing">';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
			$returnData .= "<thead>";
			$returnData .= "<tr><th class='text-center'>";
			$counter = 1;
            $returnData .= implode("</th><th class='text-center'>",array_keys($value));
            $returnData .= "</th></tr></thead><tbody>";
            $count++;
        }           
        $body ="<tr class=\"mrClicked\"><td class='tduc'>";
        $counter = 1;
        $body .= implode("</td><td class='tduc'>",array_map(function($v)use(&$counter,$value){
            if($counter++ == count($value))
                return '<b>'.$v.'</b>';
			return $v;
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body;
    }  
    if($allTotal && $count>0)
    {
        $endbody ="<tr style='font-weight:bold;'><td></td><td>Total :";
        $endbody .= implode("</td><td class='text-center'>",$allTotal[0]);
        $endbody .="</td></tr>";
        $returnData .= $endbody;        
    }
	if($count==0)
    {
        $endbody ="<tr style='font-weight:bold;'><td>No Record Found.</td></tr>";
        $returnData .= $endbody;        
    }
    return $returnData .= "</tbody></table>";
}
if(!function_exists('getComplianceReportTable')){
    function getComplianceReportTable($allData,$allTotal=NULL,$weekly=NULL,$vaccination=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL){ 
		$count = 0;
		$returnData = '<div id="parent"><table id="fixTable" class="table table-bordered table-hover" data-filter="#filter" data-filter-text-only="true">
		   ';
		foreach($allData as $key => $value)
		{
			if($count == 0)
			{
				if($vaccination){
					$months = array('Fully-Vaccinated','Un-Vaccinated');
				}
				else if($weekly){
						$months = array();
					for ($ind = 1; $ind <= $weekly; $ind++) {
						$ind = sprintf("%02d", $ind);
						$months[] = "Week ".$ind;
					}
					$months[] = "Total";
				}
				else if($complianceTotalF){
						$months = array();
						$ind = $complianceTotalF;
						$ind = sprintf("%02d", $ind);
						$months[] = "Week ".$ind;
				}
				else{
					if($headerNames){
						$months = $headerNames;
					}else{
						$months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
					}
				}
				if($vaccination){
					$colspanValue = "5";
					$firstColspan = "1";
				}
				else{
					$colspanValue = "5";
					$firstColspan = "2";
				}
				$returnData .= "<thead>
				<tr><th colspan='$firstColspan'></th><th colspan='$colspanValue' class='text-center'>";
					$returnData .= implode("</th><th colspan='$colspanValue' class='text-center'>",array_map("ucwords",array_values($months)));
					$returnData .= "</th></tr>
					<tr><th>";
						$counter = 1;
						
						$returnData .= implode("</th><th>", array_map(function($v)use(&$counter,$vaccination,$percentHeader){
							if($counter++ > 2){
								if($percentHeader!=''){
									return ucwords(substr($v, 0, -2))." % ";
								}
								return ucwords(substr($v, 0, -2));
							}
							if($vaccination && $vaccination=="YES")
								return ucwords(substr($v, 0, -2));
							return ucwords($v);
						},array_keys($value)));
						$returnData .= "</th></tr></thead><tbody>";
					}       
					$count++;
					$body ="<tr><td>";
					$counter = 0;
					$code = '';
					$body .= implode("</td><td style='color:black;'>", array_map(function($v)use(&$counter, &$code){
							if($counter==0)
								$code = $v;
							if($counter++ < 2)
								return '<p class="clickedReport" style="padding-top: 2px;color:black;" data-value="'.$code.'">'.$v.'</p>';
							return $v;
						},array_values($value)));
			$body .="</td></tr>";
			$returnData .= $body = str_replace("<td style='color:black;'></td>",'<td style="color:black;">0</td>',$body);
		}
		if($allTotal)
		{
			foreach($allTotal as $key => $value)
			{
				$endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'><td></td><td style='font-weight:bold;color: #FFF;'>Total:</td><td style='color: #FFF;' class='text-center'>";
				if($percentHeader!=''){
					$endbody .= implode("%</td><td class='text-center' style='color: #FFF;'>",$value);
					$endbody .="%</td></tr>";//<td>$sumResult</td>
				}else{
					$endbody .= implode("</td><td class='text-center' style='color: #FFF;'>",$value);
					$endbody .="</td></tr>";//<td>$sumResult</td>
				}				
				$returnData .= $endbody = str_replace("<td class='text-center' style='color: #FFF;'></td>","<td class='text-center' style='color: #FFF;'>0</td>",$endbody);        
			}
		}
		return $returnData .= "</tbody></table></div>";
	}
}
function tableTopInfo($subTitle = "", $distcode = "", $facode = "", $year = "", $type = "", $ind_name = "", $month = "", $advRepTitle = "", $fmonthFrom = "", $fmonthTo = "", $ailmentName = "", $logisticName = "" , $lhwcode="",$tcode="",$quarter="") {
		// echo  $subTitle.'<br>'.$distcode.'<br>'.$facode.'<br>'.$year;exit();
		$html = '
					<div class="row">
	    	   	  	<div class="col-xs-12" style="margin-top: -30px;text-align:center">
	    	   	  		<h3 style="text-decoration: underline;">'. $subTitle .'</h3>
	    	   	  	</div>
           	 	 </div>
		';
		$html .= '
				<div class="row">
    	   	   	 <div class="col-xs-1" style="margin-top: -13px; margin-left: 38.4%;">
    	   	   		<h4>Province:</h4>
    	   	   	 </div>
    	   	   	 <div class="col-xs-4" style="margin-top:-12px;margin-left: 15px;">
    	   	   		<h5>Khyber Pakhtunkhwa</h5>
    	   	   	 </div>
    	   	   </div>';
		if ($distcode == ""){
			//$distcode = $_SESSION['District'];
		}
		if ($distcode != ""){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>District:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . DistrictName($distcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if ($tcode == "")
			//$tcode = $_SESSION['Tehsil'];
		if ($tcode > 0)
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Tehsil:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . TehsilName($tcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($facode == "")
			//$facode = $_SESSION['Facility'];
		if ($facode > 0)
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . FacilityName($facode)  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($year > 0)
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Year:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $year  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($quarter == "")
			//$facode = $_SESSION['Facility'];
		if ($quarter > 0)
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Quarter:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $quarter  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($month > 0)
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Month:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . monthname($month)  . '</h5>
    	   	   	  </div>
    	   	   </div>';
     if ($type != ""){
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Report by:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: -98px;">
    	   	   		<h5>' . $type . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
		if ($logisticName != ""){
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
    	   	   		<h4>Logistic:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $logisticName . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
			if ($ailmentName != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
			    	   	   		<h4>Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>' . $ailmentName . '</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			if ($lhwcode != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
			    	   	   		<h4>Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>'.LHWName($lhwcode).'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
				if ($fmonthFrom != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 38.4%;">
			    	   	   		<h4>Month From:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style="margin-top: -11px; margin-left: -99px;">
			    	   	   		<h5>'.$fmonthFrom.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			  	if ($fmonthTo != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38.4%;">
			    	   	   		<h4>Month To:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>'.$fmonthTo.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
		return $html;
}
function exportIcons($postVars=NULL,$pdf=NULL){
            //print_r($postVars);exit();
			$finalString = 
			'
		<div class="col-xs-2 text-right" style="margin-top:15px;">
			<form method="post" id="export-form" action="">';
			foreach ($postVars as $key => $value) {
				if($key == 'submit')
					continue;
				if(is_array($value)){
					$name=$key."[]";
					foreach ($value as $key1 => $value1) {
						$finalString .= '<input type="hidden" name="'.$name.'" value="'.$value1.'" />';							
					}
				}else{
					$value = ($value == '' || $value == '/')?'':$value;
					$finalString .= '<input type="hidden" name="'.$key.'" value="'.$value.'" />';
				}									
			}
			if($pdf==NULL){
				$finalString .= 
			'<input type="hidden" name="export_excel" value="export_excel" />
				<div class="row">
					<div class="col-xs-2" style="margin-right: 47px; margin-top: 11px;">
						<img data-original-title="View in Excel" onclick="document.getElementById(\'export-form\').submit()" src="'.base_url().'includes/images/excel.png" style="height:32px;margin-right:-105px;" alt="img-excel" data-toggle="tooltip" title="" data-placement="bottom" />
					</div>';
			}else{
				$finalString .= '<input type="hidden" name="export_pdf" value="export_pdf" />
				<div class="row">
					<div class="col-xs-1" style="margin-right: -68px;margin-top: 11px;">
						<a onclick="document.getElementById(\'export-form\').submit()"><img data-original-title="View in PDF" src="'.base_url().'includes/images/pdf.jpg" style="height:32px;" alt="img-excel" data-toggle="tooltip" title="" data-placement="bottom" /></a>
					</div>';
			}
			$finalString .= 
					'<div class="col-xs-1 col-xs-offset-2" style="margin-right: -68px;margin-top: 11px;">
						<img onclick="window.print();" src="'.base_url().'includes/images/print.png" style="height:34px;" alt="img-print" data-toggle="tooltip" data-original-title="Print" title="" data-placement="bottom" />
					</div>
					<div class="col-xs-1 col-xs-offset-4" style="margin-top: 11px;">
						<img onclick="JavaScript:window.close();" src="'.base_url().'includes/images/close.png" style="height:34px;" alt="img-close" data-toggle="tooltip" data-original-title="Close" title="" data-placement="bottom" />
					</div>
				</div>
			</form>
		</div>
			';
		return $finalString;
}
if(!function_exists('DistrictName')){
    function DistrictName($distcode="")
    {  
        $CI=& get_instance();
        //echo 'i m here';exit();
        $_query  = "select district from districts where distcode = '$distcode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['district'];
    }
}
if(!function_exists('TehsilName')){
    function TehsilName($tcode="")
    {
        $CI=& get_instance();
        $_query  = "select tehsil from tehsil where tcode = '$tcode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['tehsil'];
    }
}
if(!function_exists('UnName')){
    function UnName($uncode="")
    {
        $CI=& get_instance();
        $_query  = "select un_name from unioncouncil where uncode = '$uncode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['un_name'];
    }
}
if(!function_exists('FacilityName')){
    function FacilityName($facode="")
    {   
        $CI=& get_instance();
        $_query  = "select fac_name from facilities where facode = '$facode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['fac_name'];
    }
}
function reportsTopInfo($subTitle,$data) {
		$html = '
				<div class="row">
					<div class="col-xs-12" style="margin-top: -30px;text-align:center">
						<h3 style="text-decoration: underline;">'. $subTitle .'</h3>
					</div>
				</div>
		';
		/*$html .= '
				<div class="row">
    	   	   	 <div class="col-xs-1" style="margin-top: -13px; margin-left: 39%;">
    	   	   		<h4>Province:</h4>
    	   	   	 </div>
    	   	   	 <div class="col-xs-4" style="margin-top:-12px;margin-left: 15px;">
    	   	   		<h5>Khyber Pakhtunkhwa</h5>
    	   	   	 </div>
    	   	   </div>';*/
		if (array_key_exists("mini_title",$data) && $data['mini_title'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Indicator:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $data['mini_title'] . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if (array_key_exists("distcode",$data) && $data['distcode'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 38%;">
    	   	   		<h4 style="font-size: 14px;">District:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . DistrictName($data['distcode']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if (array_key_exists("tcode",$data) && $data['tcode'] != ''){
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Tehsil:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . TehsilName($data['tcode']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("uncode",$data) && $data['uncode'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Union Council:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-2" style="margin-top: -11px; margin-left: -89px;">
    	   	   		<h5>' . UnName($data['uncode'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("facode",$data) && $data['facode'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . FacilityName($data['facode'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("year",$data) && $data['year'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Year:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $data['year']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("case_type",$data) && $data['case_type'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Case Type:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $data['case_type']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("case_name",$data) && $data['case_name'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Disease Name:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $data['case_name']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
        if (array_key_exists("month",$data) && $data['month'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Month:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . monthname($data['month'])  . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("from_week",$data) && $data['from_week'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h5 style="font-size: 14px;">From Week:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . sprintf("%02d",$data['from_week'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("to_week",$data) && $data['to_week'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h5 style="font-size: 14px;">To Week:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . sprintf("%02d",$data['to_week']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		 
		if (array_key_exists("vacc_ind",$data) && $data['vacc_ind'] != ''){
			if($data['vacc_ind']== 'cr_r1_f6') $vacc = 'BCG';if($data['vacc_ind']== 'cr_r2_f6') $vacc = 'DIL BCG';if($data['vacc_ind']== 'cr_r3_f6') $vacc = 'bOPV';
			if($data['vacc_ind']== 'cr_r4_f6') $vacc = 'Pentavalent';if($data['vacc_ind']== 'cr_r5_f6') $vacc = 'Pneumococcal(PCV10)';if($data['vacc_ind']== 'cr_r6_f6') $vacc = 'Measles';if($data['vacc_ind']== 'cr_r7_f6') $vacc = 'DIL Measles';if($data['vacc_ind']== 'cr_r8_f6') $vacc = 'TT 10';if($data['vacc_ind']== 'cr_r9_f6') $vacc = 'TT 20';
			if($data['vacc_ind']== 'cr_r10_f6') $vacc = 'HBV (Birth dose)';if($data['vacc_ind']== 'cr_r11_f6') $vacc = 'IPV';if($data['vacc_ind']== 'cr_r12_f6') $vacc = 'AD Syringes 0.5 ml';if($data['vacc_ind']== 'cr_r13_f6') $vacc = 'AD Syringes 0.05 ml';if($data['vacc_ind']== 'cr_r14_f6') $vacc = 'Recon.Syringes (2 ml)';if($data['vacc_ind']== 'cr_r15_f6') $vacc = 'Recon. Syringes (5 ml)';if($data['vacc_ind']== 'cr_r16_f6') $vacc = 'Safety Boxes';if($data['vacc_ind']== 'cr_r17_f6') $vacc = 'Other';if($data['vacc_ind']== 'all_vacc') $vacc = 'All Vaccines';
			
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Vaccine:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $vacc  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("waste_rate",$data) && $data['waste_rate'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Wastage Rate:</h4>
                  </div>
                  <div class="col-xs-4" style="margin-top: -11px; margin-left: -92px;">
                    <h5>' . $data['waste_rate']  . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("monthfrom",$data) && $data['monthfrom'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 37%;">
    	   	   		<h4 style="font-size: 14px;">Period:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="margin-top: -11px; margin-left: -92px;">
    	   	   		<h5>' . $data['monthfrom'] .' - ' .$data['monthto']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		/*if (array_key_exists("monthto",$data) && $data['monthto'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Month To:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="margin-top: -11px; margin-left: -92px;">
    	   	   		<h5>' . $data['monthto']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}*/
        if (array_key_exists("employee_desg",$data) && $data['employee_desg'] != ''){
            if($data['employee_desg']=='supervisor'){
                $data['employee_desg']='Supervisor';
            }
            elseif($data['employee_desg']=='dso'){
                $data['employee_desg']='District Surveillance Officer';
            }
            elseif($data['employee_desg']=='co'){
                $data['employee_desg']='Computer Operator';
            }
            elseif($data['employee_desg']=='technician'){
                $data['employee_desg']='EPI Technician';
            }
			 elseif($data['employee_desg']=='med_technician'){
                $data['employee_desg']='Medical Technician';
            }
			elseif($data['employee_desg']=='deo'){
                $data['employee_desg']='DataEntry Operator';
            }
			elseif($data['employee_desg']=='sk'){
                $data['employee_desg']='Store Keeper';
            }
            else{
                $data['employee_desg']='Driver';
            }
            $html .= ' <div class="row">
                  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Employee Type:</h4>
                  </div>
                  <div class="col-xs-4" style="margin-top: -11px; margin-left: -73px;">
                    <h5>' . ($data['employee_desg'])  . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("disease",$data) && $data['disease'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Disease:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . ucwords($data['disease'])  . '</h5>
                  </div>
               </div>';
        }
		/* if (array_key_exists("vaccination_type",$data) && $data['vaccination_type'] != ''){
			$result = ($data['vaccination_type'] != 'lhw')?"Vaccinator (".ucwords($data['vaccination_type']).")":"Health House("  .strtoupper($data['vaccination_type']).")";
            $html .= ' <div class="row">
                  <div class="col-xs-2" style="margin-top:-14px; margin-left: 34%;">
                    <h4>Vaccination by:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $result . '</h5>
                  </div>
               </div>';
        } */
		if (array_key_exists("report_type",$data) && $data['report_type'] != ''){
			$reportType = $data['report_type'];
			switch($reportType){
				case 'wage':
					$reportType = "Weekly Age Wise Report";
					break;
				case 'mage':
					$reportType = "Monthly Age Wise Report";
					break;
				case 'wgender':
					$reportType = "Weekly Gender Wise Report";
					break;
				case 'mgender':
					$reportType = "Monthly Gender Wise Report";
					break;
				case 'wwise':
					$reportType = "Week Wise VPDs Report";
					break;
				case 'mwise':
					$reportType = "Month Wise";
					break;
				case 'dwise':
					$reportType = "District Wise VPDs Report";
					break;
				case 'fwise':
					$reportType = "Facility Wise VPDs Report";
					break;
			}
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Report Type:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $reportType  . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("reportType",$data) && $data['reportType'] != ''){
			$reportType = $data['reportType'];
			$html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Report:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . ucwords($reportType)  . '</h5>
                  </div>
               </div>';
		}
		if (array_key_exists("session_type",$data) && $data['session_type'] != ''){
			$session_type = $data['session_type'];
			$html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Sessions:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $session_type  . '</h5>
                  </div>
               </div>';
		}
		if (array_key_exists("quarter",$data) && $data['quarter'] != ''){
			$quarter = $data['quarter'];
			$html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Quarter:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . ucwords($quarter)  . '</h5>
                  </div>
               </div>';
		}
		if (array_key_exists("age_wise",$data) && $data['age_wise'] != ''){
			$age_wise = $data['age_wise'];
			switch($age_wise){
				case '0to11':
					$title = "0-11 Months";
					break;
				case '12to23':
					$title = "12-23 Months";
					break;
				case 'above2':
					$title = "Above 2 Years";
					break;
				case 'all':
					$title = "All";
					break;
			}
			$html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 37%;">
                    <h4 style="font-size: 14px;">Age Group:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $title  . '</h5>
                  </div>
               </div>';
		}
		if (array_key_exists("vaccination_type",$data) && $data['vaccination_type'] != ''){
			$vaccination_type = $data['vaccination_type'];
			switch($vaccination_type){
				case 'all':
					$title = "All Strategies";
					break;
				case 'fixed':
					$title = "Fixed Strategy";
					break;
				case 'outreach':
					$title = "Outreach Strategy";
					break;
				case 'mobile':
					$title = "Mobile Strategy";
					break;
				case 'lhw':
					$title = "LHW";
					break;
			}
			$html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 37%;">
                    <h4 style="font-size: 14px;">Vacc Type:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $title  . '</h5>
                  </div>
               </div>';
		}
		return $html;
}