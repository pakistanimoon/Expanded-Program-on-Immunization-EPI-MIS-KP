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
	function getListingReportTable($allData,$listingFor,$allTotal=NULL,$sectionTotal = 'Yes',$indicator_report='NO',$otherReports='NO',$color=null, $showinnerTotal = 'Yes')
    {	
		if($color){
			$setcolor = 'style=background-color:#FF0000';
            //#ffc904 
		} 
		else{ 
			$setcolor='';
		} 
			
		if(!empty($allData)) 
        {
		
            $count = 0;
            $innerHead = '';
            $insiderow = '';
            $moon = array();
            $countALLRecords=0;
            $returnData = ' <table id="table1" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
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
                        if(count($moon) > 0 && $showinnerTotal=='Yes')
                        {   
                            //for section total
                            array_splice($moon, 0, 2);
                            $returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'>
                            <td style='font-weight:bold; background-color: #111;color: #FFF;'></td>
                            <td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td>
                            <td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
                            $returnData .= implode("</td>
                            <td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);      
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
                    $returnData .= "<thead><tr>
                    <th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>";                    
                    $returnData .= implode("</th>
                    <th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>",array_map("ucwords",array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
                $count++;
    			$class="";
                $returnData .= $headerRow;
               // $returnData .= "</td></tr>";
			   	$displayNone = ($id>0)?'<td style="text-align:center; border: 1px solid black; display:none;" class="text-center">'.$id.'</td>':'';
			    $returnData .= '<tr class="DrillDownRow">'.$displayNone;
				$i=0;
				foreach($value as $k => $v)
				{
					if(is_numeric($v))
                    {
    					if($v > 0)
    					{
    						if($i > 1)
    						    $returnData .="<td style='text-align:center; border: 1px solid black;' class='text-center' $setcolor>$v</td>";
    						else
    						    $returnData .="<td style='text-align:center; border: 1px solid black;' class='text-center' >$v</td>";			
    					}
    					else
    					{
    						$returnData .="<td style='text-align:center; border: 1px solid black;' class='text-center'>$v</td>";	
    					}
                    }
                    else{
								$returnData .="<td style='text-align:center; border: 1px solid black;' class='text-center'>$v</td>";	
                    }
					   $i++;
                }	
				$returnData .= "</tr>";
				foreach($value as $k => $v)
				{
					if(is_numeric($v))
                    {
						$moon[$k] = (key_exists($k,$moon) && is_numeric($k))?$moon[$k]+$v:$v;
						//$moon[$k] =  key_exists($k,$moon)?$moon[$k]+$v:$v;
                    }
                    else{
                        $moon[$k] =  key_exists($k,$moon)?$moon[$k]:$v;
                    }
                } 
				/* foreach($value as $k => $v)
				{
					if(is_numeric($v) and key_exists($k,$moon) and is_numeric($moon[$k]))
                    {
						$moon[$k] =  $moon[$k]+$v;
                    }
                    else{
                        $moon[$k] =  key_exists($k,$moon)?$moon[$k]:$v;
                    }
                } */
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
                $returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'>
                <td style='font-weight:bold; background-color: #111;color: #FFF;'></td>
                <td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td>
                <td class='text-center' style='font-weight:bold; background-color: #111; color: #FFF;'>";
                $returnData .= implode("</td>
                <td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);
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
    			
                    $endbody ="<tr style='font-weight:bold; background-color: #111;color: #FFF;'>
                    <td class=\"text-center\" colspan=\"$colspan\">Total</td>
                    <td class=\"text-center\">";
                    $endbody .= implode("</td>
                    <td style='text-align:center; border: 1px solid black;' class='text-center' class=\"text-center\">",$value);
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
function getDistComplianceFMVRReportTableFromTo($allData,$allTotal=NULL,$allTotalDue=NULL,$timelycomplete=NULL,$dd_start_year=NULL,$dd_start_month=NULL,$dd_end_year=NULL,$dd_end_month=NULL){
    $count = 0;
    $returnData = '<div id="parent"><table id="fixTable" class="table table-bordered table-hover">';
    foreach($allData as $key => $value)
    {
        //print_r($allData); exit();
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
        $moonmonth = $dd_start_month;
        $moonyear = $dd_start_year;       
        $body .= implode("</td><td class=''>",array_map(function($v)use(&$counter,$value,&$code,&$timelycomplete,&$dd_start_year,&$dd_start_month,&$dd_end_year,&$dd_end_month,&$moonmonth,&$moonyear){
            //$moonmonth = '';
            $start_year = $start_year1 = $dd_start_year;
            $start_month = $dd_start_month;
            $between_year = $between_year1 = $start_year;
            $end_year = $end_year1 = $dd_end_year;
            $end_month = $dd_end_month;
            $currYear = date('Y');
            $currMonth = date('m');
            //echo $yearfrom; echo ' / '; echo $yearto;
            if($counter==1)
                $code = $v;
            if($counter <= 3)
            {
                $counter++;
                return '<p class="Compliance" style="padding-top: 2px;color:black;" data-value="'.$code.'">'.$v.'</p>';
            }
            //if($counter == 4){$counter = $monthfrom;}
            
            $newvalueCounter = $counter++;
            //$counter = $counter + $start_month;
            if($moonmonth <= 12){
                // echo $moonmonth;
            }
            else {
                $modval = ($moonmonth%12);
                if($modval===0){
                    $moonmonth = 12;
                }
                else{
                    $moonmonth = $modval;
                }
                if($modval===1){
                    $moonyear = $moonyear+1;
                }
            }
            //echo $moonyear;
           
            if($newvalueCounter == count($value) || ($newvalueCounter == (count($value)-1) AND $timelycomplete=='yes')){
                //$parts = explode('::',$v);for animations
                //return '<b class="text-center" style="color:black;">'.$parts[0].'<div class="circle" data-percent="'.$parts[1].'"><strong></strong></div></b>';
                $moonreturnhtml = '<b class="text-center" style="color:black;">'.$v.'</b>';
            }
            else if($v>=1)
            {
                $moonreturnhtml = '<p class="mrClicked text-center" style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-fmonth="'.$moonyear.'-'.sprintf("%'.02d",$moonmonth).'">&#10004;</p>';
                //return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$moonmonth).'" src="../includes/images/'.$v.'.png" />';
            }
            else if($v=='zr')
            {
                $moonreturnhtml = '<p class="mrClicked text-center" style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-fmonth="'.$moonyear.'-'.sprintf("%'.02d",$moonmonth).'">ZR</p>';
                //return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$moonmonth).'" src="../includes/images/'.$v.'.png" />';
            }
            else if($v=='timely')
            {
                $moonreturnhtml = '<p class="mrClicked text-center" style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-fmonth="'.$moonyear.'-'.sprintf("%'.02d",$moonmonth).'"><img style="width:20px;" title="Timely" src="'.base_url().'includes/images/timely.png"></p>';
            }
            else if($v=='complete')
            {
                $moonreturnhtml = '<p class="mrClicked text-center" title="Complete" style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-fmonth="'.$moonyear.'-'.sprintf("%'.02d",$moonmonth).'">&#10004;</p>';
            }
            else if($v=='notsubmitted')
            {
                $moonreturnhtml = '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
            }
            else if($v=='notfunctional')
            {
                $moonreturnhtml = '<p class="text-center" title="Not Functional" style="color:brown;font-weight: bold;font-size: 16px;">NF</p>';
            }
            else{
                /*if($v=='1'){ $v="<p>&#10004;</p>"; }else{ $v="<p>&#xf00d;</p>"; }*/
                $moonreturnhtml = '<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
                //return "<img width='20' height='20' src=\"../includes/images/".$v.".png\" />";
            } 
            $moonmonth++;
            return $moonreturnhtml;
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
                $endbody ="<tr style='font-weight:bold;'><td></td><td style='color:black;'>Total Submitted:</td><td style='color:black;' class='text-center'>";
            }
            $endbody .= implode("</td><td style='color:black;' class='text-center'>",$value);
            $endbody .="</td></tr>";
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
        }
    }
    return $returnData .= "</tbody></table></div>";
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
            }
            else if($v=='zr')
            {
                return '<p class="mrClicked text-center"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'">ZR</p>';
			    //return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'" src="../includes/images/'.$v.'.png" />';
            }
            else if($v=='timely')
            {
                return '<p class="mrClicked text-center"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'"><img style="width:20px;" title="Timely" src="'.base_url().'includes/images/timely.png"></p>';
            }
            else if($v=='complete')
            {
                return '<p class="mrClicked text-center" title="Complete"  style="color:green;font-weight: bold;font-size: 16px;" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-4).'">&#10004;</p>';
            }
            else if($v=='notsubmitted')
            {
                return '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
            }
            else if($v=='notfunctional')
            {
                return '<p class="text-center" title="Not Functional" style="color:brown;font-weight: bold;font-size: 16px;">NF</p>';
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
if(!function_exists('getComplianceReportTableForDSCompliance')){
    function getComplianceReportTableForDSCompliance($allData,$allTotal=NULL,$weekFrom=NULL,$weekTo=NULL,$vaccination=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL,$zero=null){ 
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
                else if($weekFrom){
                    $months = array();
                    for ($ind = $weekFrom; $ind <= $weekTo; $ind++) {
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
                    if($headerNames){
                        $colspanValue = "4";
                        $firstColspan = "2";
                    }
                    else if($zero=='zero')
                    {
                        //For zero Report Compliances
                        $colspanValue = "5";
                        $firstColspan = "2";
                    }
                    else{
                        
                        $colspanValue = "3";
                        $firstColspan = "2";
                    }                   
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
if(!function_exists('getComplianceReportTable')){
    function getComplianceReportTable($allData,$allTotal=NULL,$weekly=NULL,$vaccination=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL,$zero=null){ 
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
					if($headerNames){
						$colspanValue = "4";
						$firstColspan = "2";
					}
					else if($zero=='zero')
					{
						//For zero Report Compliances
						$colspanValue = "5";
						$firstColspan = "2";
					}
					else{
						
						$colspanValue = "3";
						$firstColspan = "2";
					}
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
		$CI = & get_instance();
		$html = '
					<div class="row">
	    	   	  	<div class="col-xs-12" text-center">
	    	   	  		<h3 style="text-decoration: underline; width: 100%; text-align: center;">'. $subTitle .'</h3>
	    	   	  	</div>
           	 	 </div>
		';
		$html .= '
				<div class="row">
    	   	   	 <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Province:</h4>
    	   	   	 </div>
    	   	   	 <div class="col-xs-4" style="width:100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">'. $CI -> session -> provincename .'</h5>
			  
    	   	   	 </div>
    	   	   </div>';
		if ($distcode == ""){
			//$distcode = $_SESSION['District'];
		}
		if ($distcode != ""){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">District:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . DistrictName($distcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if ($tcode == "")
			//$tcode = $_SESSION['Tehsil'];
		if ($tcode > 0)
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">Tehsil:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . TehsilName($tcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($facode == "")
			//$facode = $_SESSION['Facility'];
		if ($facode > 0)
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . FacilityName($facode)  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($year > 0)
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">Year:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $year  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($quarter == "")
			//$facode = $_SESSION['Facility'];
		if ($quarter > 0)
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">Quarter:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $quarter  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($month > 0)
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Month:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . monthname($month)  . '</h5>
    	   	   	  </div>
    	   	   </div>';
     if ($type != ""){
			$html .= ' 
									<div class="row">
                                    <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Report by:</h4>
								 
    	   	   	  </div>
                        <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $type . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
		if ($logisticName != ""){
			$html .= ' 
									<div class="row">
    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Logistic:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $logisticName . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
			if ($ailmentName != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
			    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
			    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $ailmentName . '</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			if ($lhwcode != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
			    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
			    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">'.LHWName($lhwcode).'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
				if ($fmonthFrom != ""){
						$html .= ' 
												<div class="row">
                                                <div class="col-xs-1" style="width:100%; text-align: center;">
			    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Month From:</h4>
									 
			    	   	   	  </div>
                                    <div class="col-xs-4" style="width: 100%; text-align: center;">
			    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">'.$fmonthFrom.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			  	if ($fmonthTo != ""){
						$html .= ' 
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="width:100%; text-align: center;">
			    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Month To:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
			    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">'.$fmonthTo.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
		return $html;
}
function exportIcons($postVars=NULL,$pdf=NULL,$excelonly=NULL){
    //print_r($postVars);exit();
	$finalString = 
	'<div class="col-xs-2 text-right" style="margin-top:15px;">
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
		//send only excel btn html 
		if($excelonly=="excel"){
				$finalString .=
				
		'<input type="hidden" name="export_excel" value="export_excel" />
			<img class="handland" data-original-title="View in Excel" onclick="document.getElementById(\'export-form\').submit()" src="'.base_url().'includes/images/excel.png" style="height:32px;margin-left:500px;" alt="img-excel" data-toggle="tooltip" title="Excel" data-placement="bottom" />
			</form> </div>'	;
		}
		else{
			
		if($pdf==NULL){
			$finalString .= 
		'<input type="hidden" name="export_excel" value="export_excel" />
			<div class="row">
				<div class="col-xs-2" style="margin-right: 47px; margin-top: 11px;">
					<img class="handland" id="vampire" data-original-title="View in Excel" onclick="document.getElementById(\'export-form\').submit()" src="'.base_url().'includes/images/excel.png" style="height:32px;margin-right:-105px;" alt="img-excel" data-toggle="tooltip" title="Excel" data-placement="bottom" />
				</div>';
		}else{
					 
			$finalString .= '<input type="hidden" name="export_pdf" value="export_pdf" />
			<div class="row">
				<div class="col-xs-1" style="margin-right: -68px;margin-top: 11px;">
					<a class="handland" onclick="document.getElementById(\'export-form\').submit()"><img data-original-title="View in PDF" src="'.base_url().'includes/images/pdf.jpg" style="height:32px;" alt="img-excel" data-toggle="tooltip" title="View in PDF" data-placement="bottom" /></a>
				</div>';
		}
		$finalString .= 
				'<div class="col-xs-1 col-xs-offset-2" style="margin-right: -68px;margin-top: 11px;">
					<img class="handland" onclick="window.print();" src="'.base_url().'includes/images/print.png" style="height:34px;" alt="img-print" data-toggle="tooltip" data-original-title="Print" title="Print" data-placement="bottom" />
				</div>
				<div class="col-xs-1 col-xs-offset-4" style="margin-top: 11px;">
					<img class="handland" onclick="JavaScript:window.close();" src="'.base_url().'includes/images/close.png" style="height:34px;" alt="img-close" data-toggle="tooltip" data-original-title="Close" title="Close" data-placement="bottom" />
				</div>
			</div>
		</form>
	</div>
		';
		}
	return $finalString;
}
function exportIcons_forViewForms($postVars=NULL,$pdf=NULL,$excelonly=NULL){
    //print_r($postVars);exit();
    $finalString = 
    '<div class="col-xs-2 text-right" style="margin-top:15px;">
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
        //send only excel btn html 
        if($excelonly=="excel"){
                $finalString .=
                
        '<input type="hidden" name="export_excel" value="export_excel" /> 
            <img class="handland"  data-original-title="View in Excel" onclick="document.getElementById(\'export-form\').submit()" src="'.base_url().'includes/images/excel.png" style="height:32px;margin-left:500px;" alt="img-excel" data-toggle="tooltip" title="Excel" data-placement="bottom" />
            </form> </div>' ;
        }
        else{
            
            if($pdf==NULL){
                $finalString .= 
            '<input type="hidden" name="export_excel" value="export_excel" />
                <div class="row">
                    <div class="col-xs-2" style="margin-right: 47px; margin-top: 11px;">
                        <img class="handland" id="vampire" data-original-title="View in Excel" onclick="document.getElementById(\'export-form\').submit()" src="'.base_url().'includes/images/excel.png" style="height:32px;margin-right:-105px;" alt="img-excel" data-toggle="tooltip" title="Excel" data-placement="bottom" />
                    </div>';
            }
            else{
                $finalString .= '<input type="hidden" name="export_pdf" value="export_pdf" />
                <div class="row">
                    <div class="col-xs-1" style="margin-right: -68px;margin-top: 11px;">
                        <a class="handland" onclick="document.getElementById(\'export-form\').submit()"><img data-original-title="View in PDF" src="'.base_url().'includes/images/pdf.jpg" style="height:32px;" alt="img-pdf" data-toggle="tooltip" title="View in PDF" data-placement="bottom" /></a>
                    </div>';
            }
            $finalString .= 
                    '</div>
                </form>
            </div>';
        }
    return $finalString;
}
if(!function_exists('ProvinceName')){
    function ProvinceName($procode="")
    {  
        $CI=& get_instance();
        //echo 'i m here';exit();
        $_query  = "SELECT province from provinces where procode = '$procode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['province'];
    }
}
if(!function_exists('DistrictName')){
    function DistrictName($distcode="")
    {  
        $CI=& get_instance();
        //echo 'i m here';exit();
        $_query  = "SELECT district from districts where distcode = '$distcode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['district'];
    }
}
if(!function_exists('TehsilName')){
    function TehsilName($tcode="")
    {
        $CI=& get_instance();
        $_query  = "SELECT tehsil from tehsil where tcode = '$tcode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['tehsil'];
    }
}
if(!function_exists('UnName')){
    function UnName($uncode="")
    {
        $CI=& get_instance();
        $_query  = "SELECT un_name from unioncouncil where uncode = '$uncode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['un_name'];
    }
}
if(!function_exists('FacilityName')){
    function FacilityName($facode="")
    {   
        $CI=& get_instance();
        $_query  = "SELECT fac_name from facilities where facode = '$facode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['fac_name'];
    }
}
if(!function_exists('TechnicianName')){
    function TechnicianName($techniciancode="")
    {   
        $CI=& get_instance();
        $_query  = "SELECT name from hr_db where code = '$techniciancode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['name'];
    }
}
if(!function_exists('Assetname')){
    function Assetname($pk_id="")
    {   
        $CI=& get_instance();
        $_query  = "SELECT asset_type_name  from epi_cc_asset_types where pk_id = '$pk_id'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['asset_type_name'];
    }
}
if(!function_exists('Warehousetypename')){
    function Warehousetypename($pk_id="")
    {   
        $CI=& get_instance();
        $_query  = "SELECT warehouse_type_name from epi_cc_warehouse_types  where pk_id = '$pk_id'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        return $rows['warehouse_type_name'];
    }
}
function reportsTopInfo($subTitle,$data) {
      //  echo "<pre>"; print_r($data);exit();
		$html = '
				<div class="row">
					<div class="col-xs-12" style="margin-top: -30px;text-align:center">
						<h3 style="text-decoration: underline; position: relative; left: -36px;">'. $subTitle .'</h3>
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
    	   	   	  <div class="col-xs-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center;">Indicator:</h4>
					 
																				   
												  
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $data['mini_title'] . '</h5>
    	   	   </div>';
    	}
		//echo "<pre>";print_r($data);
        if (array_key_exists("procode",$data) && $data['procode'] != '' && $data['procode'] != '0' && (isset($data['distcode'])) && ($data['distcode'] == '' || $data['distcode'] == '0')){
        //if (array_key_exists("procode",$data) && $data['procode'] != '' && $data['procode'] != '0'){
			
			
			//echo $data['distcode']; exit();
			
            $html .= ' 
                        <div class="row">
                  <div class="col-xs-1" style="width: 100%; text-align: center;">
                    <h4 style="margin-top: 0px; font-size: 20px; font-weight: 900; text-align: center; width: 100%;">Province:</h4>
                  </div>
                  <div class="col-xs-4" style="width: 100%; text-align: center;">
                    <h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . ProvinceName($data['procode']) . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("distcode",$data) && $data['distcode'] != '' && $data['distcode'] != '0'){
			$html .= ' 
				<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%; white-space: nowrap;">
    	   	   		<h4 style="font-size: 16px;">District:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . DistrictName($data['distcode']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if (array_key_exists("tcode",$data) && $data['tcode'] != '' && $data['tcode'] != '0'){
			$html .= ' 
					<div class="row">
                    <div class="col-xs-1" style="width: 100%; text-align: center;">
                    <h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Tehsil:</h4>
    	   	   	  </div>
                        <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . TehsilName($data['tcode']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("uncode",$data) && $data['uncode'] != '' && $data['uncode'] != '0'){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="width: 100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Union Council:</h4>
    	   	   	  </div>
                        <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . UnName($data['uncode'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("facode",$data) && $data['facode'] != '' && $data['facode'] != '0'){
			$html .= ' 
					<div class="row">
    	   	   	  <div class="col-xs-1" style="width: 100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . FacilityName($data['facode'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("techniciancode",$data) && $data['techniciancode'] != '' && $data['techniciancode'] != '0'){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Technician:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . TechnicianName($data['techniciancode'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("year",$data) && $data['year'] != ''){
				$html .= ' <div class="row">
            <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%; white-space: nowrap;">
    	   	   		<h4 style="font-size: 16px;">Year:</h4>
    	   	   	  </div>
                         <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $data['year']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("case_type",$data) && $data['case_type'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="width: 100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Case Type:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $data['case_type']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("case_name",$data) && $data['case_name'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="width: 100%; text-align: center;">
    	   	   		<h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Disease Name:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style="width: 100%; text-align: center;">
    	   	   		<h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . $data['case_name']  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
        if (array_key_exists("month",$data) && $data['month'] != ''){
            $html .= ' <div class="row">
                   <div class="col-xs-1" style="width: 100%; text-align: center;">
                    <h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Month:</h4>
                  </div>
                  <div class="col-xs-4" style="width: 100%; text-align: center;">
                    <h5 style="width: 100%; font-weight: 600; margin-top: -5px;">' . monthname($data['month'])  . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("from_week",$data) && $data['from_week'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%; white-space: nowrap;">
    	   	   		<h5 style="font-size: 16px;">From Week:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5 style="">' . sprintf("%02d",$data['from_week'])  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("to_week",$data) && $data['to_week'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%; white-space: nowrap;">
    	   	   		<h5 style="font-size: 16px;">To Week:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . sprintf("%02d",$data['to_week']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
        if (array_key_exists("indicator",$data) && $data['indicator'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="width: 100%; text-align: center;">
                     <h4 style="margin-top: 0px;font-size: 20px; font-weight: 900;text-align: center; width: 100%;">Indicator:</h4>
                  </div>
                  <div class="col-xs-4" style="width: 100%; text-align: center;">
                    <h5>' . get_Indicator_Name($data['indicator']) . '</h5>
                  </div>
               </div>';
        }
		 if (array_key_exists("suveillance_indicator",$data) && $data['suveillance_indicator'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Indicator:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . get_SurveillanceIndicator_Name($data['suveillance_indicator']) . '</h5>
                  </div>
               </div>';
        }
		
		if (array_key_exists("vacc_ind",$data) && $data['vacc_ind'] != ''){
			if(is_array($data['vacc_ind'])){
				$allnames = array_map("getVaccines_name",$data['vacc_ind']);
				$vacc = implode(",",$allnames);
			}else{
				if($data['vacc_ind']== 'cr_r1_f6') $vacc = 'BCG';
				if($data['vacc_ind']== 'cr_r2_f6') $vacc = 'DIL BCG';
				if($data['vacc_ind']== 'cr_r3_f6') $vacc = 'bOPV';
				if($data['vacc_ind']== 'cr_r4_f6') $vacc = 'Pentavalent';
				if($data['vacc_ind']== 'cr_r5_f6') $vacc = 'Pneumococcal(PCV10)';
				if($data['vacc_ind']== 'cr_r6_f6') $vacc = 'Measles';
				if($data['vacc_ind']== 'cr_r7_f6') $vacc = 'DIL Measles';
				if($data['vacc_ind']== 'cr_r8_f6') $vacc = 'TT 10';
				if($data['vacc_ind']== 'cr_r9_f6') $vacc = 'TT 20';
				if($data['vacc_ind']== 'cr_r10_f6') $vacc = 'HBV (Birth dose)';
				if($data['vacc_ind']== 'cr_r11_f6') $vacc = 'IPV';
				if($data['vacc_ind']== 'cr_r12_f6') $vacc = 'AD Syringes 0.5 ml';
				if($data['vacc_ind']== 'cr_r13_f6') $vacc = 'AD Syringes 0.05 ml';
				if($data['vacc_ind']== 'cr_r14_f6') $vacc = 'Recon.Syringes (2 ml)';
				if($data['vacc_ind']== 'cr_r15_f6') $vacc = 'Recon. Syringes (5 ml)';
				if($data['vacc_ind']== 'cr_r16_f6') $vacc = 'Safety Boxes';
				if($data['vacc_ind']== 'cr_r17_f6') $vacc = 'Other';
				if($data['vacc_ind']== 'all_vacc') $vacc = 'All Vaccines';
			}
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Vaccine(s):</h4>
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
    	   	      <div class="col-xs-4" style="margin-top: -11px; margin-left: -110px;">
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
		//get Asset Type
		if (array_key_exists("asset_type",$data) && $data['asset_type'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Asset Type:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . Assetname($data['asset_type']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		//get Stroe Level
		if (array_key_exists("store_level",$data) && $data['store_level'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Store Level:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . Warehousetypename($data['store_level']). '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		//get Working Status
		if (array_key_exists("working_status",$data) && $data['working_status'] != ''){
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
                    <h4 style="font-size: 14px;">Working Status:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . getWorkingstatus($data['working_status'],TRUE) . '</h5>
                  </div>
               </div>';
        }
		if (array_key_exists("product",$data) && $data['product'] != ''){
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4 style="font-size: 14px;">Vaccine:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . getVaccines_name($data['product']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		}
		if (array_key_exists("type_id",$data) && $data['type_id'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 37%;">
    	   	   		<h4 style="font-size: 14px;">HR Type:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . get_subtype_name($data['type_id']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
		if (array_key_exists("trainingtypes",$data) && $data['trainingtypes'] != ''){
			$html .= ' 
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 37%;">
    	   	   		<h4 style="font-size: 14px;">Training Type:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . get_training_name($data['trainingtypes']) . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	}
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
				case '1':
					$reportType = "Aggregated Counts";
					break;
				case '2':
					$reportType = "Facilities List";
					break;
			}
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%; white-space: nowrap;">
                    <h4 style="font-size: 16px;">Report Type:</h4>
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
        if (array_key_exists("in_out_coverage",$data) && $data['in_out_coverage'] != ''){
            $in_out_coverage = $data['in_out_coverage'];
            switch($in_out_coverage){
                case 'in_uc':
                    $title = "Inside UC";
                    break;
                case 'out_uc':
                    $title = "Outside UC";
                    break;
                case 'total_ucs':
                    $title = "Inside UC + Outside UC";
                    break;
                case 'in_district':
                    $title = "Inside District";
                    break;
                case 'out_district':
                    $title = "Outside District";
                    break;
                case 'total_districts':
                    $title = "Inside District + Outside District";
                    break;
            }
            $html .= ' <div class="row">
                  <div class="col-xs-1" style="margin-top:-14px; margin-left: 37%;">
                    <h4 style="font-size: 14px;">Coverage:</h4>
                  </div>
                  <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
                    <h5>' . $title  . '</h5>
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
function reportsslimTopInfo($subTitle,$data) {
       // print_r($data);exit();
		$html = '
				<div class="row">
					<div class="col-xs-12" style="margin-top: -30px;text-align:center">
						<h3 style="text-decoration: underline;">'. $subTitle .'</h3>
					</div>
				</div>
		';
		$startnewdiv = '<div class="row">';
		$enddiv = '</div>';
		$appendedcounts = 0;
		if (array_key_exists("procode",$data) && $data['procode'] != '' && $data['procode'] != '0' && (isset($data['distcode'])) && ($data['distcode'] == '' || $data['distcode'] == '0')){			
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= '
                  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Province:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . ProvinceName($data['procode']) . '</h5>
                  </div>';
        }
		if (array_key_exists("distcode",$data) && $data['distcode'] != '' && $data['distcode'] != '0'){
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
						
    	   	   	  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">District:</h4>
    	   	   	  </div>
    	   	      <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . DistrictName($data['distcode']) . '</h5>
    	   	   	  </div>
    	   	   ';
    	}
		if (array_key_exists("tcode",$data) && $data['tcode'] != '' && $data['tcode'] != '0'){
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
						
                    <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Tehsil:</h4>
    	   	   	  </div>
                        <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . TehsilName($data['tcode']) . '</h5>
    	   	   	  </div>
    	   	   ';
		}
		if (array_key_exists("uncode",$data) && $data['uncode'] != '' && $data['uncode'] != '0'){
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
						
    	   	   	  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">UC:</h4>
    	   	   	  </div>
                        <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . UnName($data['uncode'])  . '</h5>
    	   	   	  </div>
    	   	   ';
		}
		if (array_key_exists("facode",$data) && $data['facode'] != '' && $data['facode'] != '0'){
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
						
    	   	   	  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . FacilityName($data['facode'])  . '</h5>
    	   	   	  </div>
    	   	   ';
		}
		if (array_key_exists("year",$data) && $data['year'] != ''){
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
            <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Year:</h4>
    	   	   	  </div>
                        <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $data['year']  . '</h5>
    	   	   	  </div>
    	   	   ';
		}
        if (array_key_exists("month",$data) && $data['month'] != ''){
            if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Month:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . monthname($data['month'])  . '</h5>
                  </div>
               ';
        }
        if (array_key_exists("monthfrom",$data) && $data['monthfrom'] != ''){
            if($appendedcounts==0){
                $html .= $startnewdiv;
            }
            if($appendedcounts==3){
                $html .= $enddiv.$startnewdiv;
                $appendedcounts = 1;
            }else{
                $appendedcounts++;
            }
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
                    <h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Period:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
                    <h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $data['monthfrom'] .' - ' .$data['monthto']  . '</h5>
                  </div>
               ';
        }
        if (array_key_exists("vaccination_type",$data) && $data['vaccination_type'] != ''){
            $vaccination_type = $data['vaccination_type'];
            switch($vaccination_type){
                case 'all':
                    $title = "All";
                    break;
                case 'fixed':
                    $title = "Fixed";
                    break;
                case 'outreach':
                    $title = "Outreach";
                    break;
                case 'mobile':
                    $title = "Mobile";
                    break;
                case 'lhw':
                    $title = "LHW";
                    break;
            }
            if($appendedcounts==0){
                $html .= $startnewdiv;
            }
            if($appendedcounts==3){
                $html .= $enddiv.$startnewdiv;
                $appendedcounts = 1;
            }else{
                $appendedcounts++;
            }
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
                    <h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Vaccination:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
                    <h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $title . '</h5>
                  </div>
               ';
        }
        if (array_key_exists("vacc_to",$data) && $data['vaccination_type'] != ''){
            $vaccination_type = $data['vacc_to'];
            switch($vaccination_type){
                case 'all':
                    $title = "All";
                    break;
                case 'total_children':
                    $title = "Total Children";
                    break;
                case 'gender':
                    $title = "Gender Wise";
            }
            if($appendedcounts==0){
                $html .= $startnewdiv;
            }
            if($appendedcounts==3){
                $html .= $enddiv.$startnewdiv;
                $appendedcounts = 1;
            }else{
                $appendedcounts++;
            }
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
                    <h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Vaccination To:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
                    <h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $title . '</h5>
                  </div>
               ';
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
            if($appendedcounts==0){
                $html .= $startnewdiv;
            }
            if($appendedcounts==3){
                $html .= $enddiv.$startnewdiv;
                $appendedcounts = 1;
            }else{
                $appendedcounts++;
            }
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
                    <h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Age Group:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
                    <h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $title . '</h5>
                  </div>
               ';
        }
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
				case '1':
					$reportType = "Aggregated Counts";
					break;
				case '2':
					$reportType = "Facilities List";
					break;
			}
            if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Report:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . $reportType  . '</h5>
                  </div>
              ';
        }
		if (array_key_exists("reportType",$data) && $data['reportType'] != ''){
			$reportType = $data['reportType'];
			if($appendedcounts==0){
				$html .= $startnewdiv;
			}
			if($appendedcounts==3){
				$html .= $enddiv.$startnewdiv;
				$appendedcounts = 1;
			}else{
				$appendedcounts++;
			}
            $html .= ' 
                  <div class="col-md-1" style="text-align: center;">
    	   	   		<h4 style="margin-top: 0px; font-size: 18px; font-weight: 900;text-align: center;">Report:</h4>
                  </div>
                  <div class="col-md-3" style="text-align: center;">
    	   	   		<h5 style="margin-top: 0px; font-size: 18px;text-align: center;">' . ucwords($reportType)  . '</h5>
                  </div>
               ';
		}
		if($appendedcounts!=0){
			$html .= $enddiv;
		}
		return $html;
}

if(!function_exists('getPendingCasesReportTable')){
    function getPendingCasesReportTable($allData,$allTotal=NULL,$weekly=NULL,$siaCompliance=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL,$siaCoverage=NULL,$siaTeams=NULL){ 
	
         $count = 0;
        // if($siaCoverage){
        //  $returnData = '<div><table id="fixTable" class="table table-bordered table-hover" data-filter="#filter" data-filter-text-only="true">
        //    ';
        // }
        // else{
        $returnData = '<div id="parent"><table id="fixTable" class="table table-bordered table-hover" data-filter="#filter" data-filter-text-only="true">';
        //$returnData = '';
        //}
        foreach($allData as $key => $value)
        {
            if($count == 0)
            {
                if($weekly){
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
                    }
                    // else if($siaCoverage){
                    //  $months = '';
                    // }
                    else{
                        $months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
                    }
                }
                if($siaCompliance){
                    $colspanValue = "1";
                    $firstColspan = "3";
                }
                else if($siaCoverage){
                    //echo "abc";exit();
                    $colspanValue = "3";
                    $firstColspan = "2";
                }
                else if($siaTeams){
                    //echo "yes";exit();
                    $colspanValue = "7";
                    $firstColspan = "2";
                }
                else{
                    //echo "xyz";exit();
                    $colspanValue = "3";
                    $firstColspan = "2";
                }
                // if($siaCoverage){
                //  $returnData .= '';
                // }
                if($siaTeams){
                    $returnData .= '';
                }
               /// removed a variable.. .
				 
                if($siaCoverage){
                    $returnData .= '';
                }
                else if($siaTeams){
                    $returnData .= '';
                }
                else{
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;' colspan='$colspanValue'>",array_map("ucwords",array_values($months)));
                }
                $returnData .= "</th></tr>
                <tr><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>";
                if($siaTeams){
                    $counter = 1;                   
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>", array_map(function($v)use(&$counter,$siaTeams,$percentHeader){
                        if($counter++ > 7){
                            if($percentHeader!=''){
                                return ucwords(substr($v, 0, -7))." % ";
                            }
                            return ucwords(substr($v, 0, -7));
                        }
                        if($siaTeams && $siaTeams=="YES")
                            return ucwords(substr($v, 0, -7));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
                else{
                    $counter = 1;                   
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>", array_map(function($v)use(&$counter,$siaCompliance,$percentHeader){
                        if($counter++ > 2){
                            if($percentHeader!=''){
                                return ucwords(substr($v, 0, -2))." % ";
                            }
                            return ucwords(substr($v, 0, -2));
                        }
                        if($siaCompliance && $siaCompliance=="YES")
                            return ucwords(substr($v, 0, -2));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
            }       
            $count++;
            $body ="<tr><td style='text-align:center; border: 1px solid black;' class='text-center'>";
            $counter = 0;
            $code = '';
            $body .= implode("</td><td style='text-align:center; color:black; border: 1px solid;'>", array_map(function($v)use(&$counter, &$code){
                    if($counter==0)
                        $code = $v;

                    if($counter++ < 2)
                        return '<p class="clickedReport text-center" style="padding-top: 2px;color:black;" data-value="'.$code.'">'.$v.'</p>';

                    return $v;
                },array_values($value)));
            $body .="</td></tr>";
            $returnData .= $body = str_replace("<td style='text-align:center; color:black; border: 1px solid;'></td>",'<td style="text-align:center; color:black; border: 1px solid;">0</td>',$body);
        }
        
        if($allTotal)
        {
            foreach($allTotal as $key => $value)
            {
                $endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'>
                <td></td><td style='font-weight:bold;color: #FFF;'>Total:</td><td style='color: #FFF;' class='text-center'>";
                if($percentHeader!=''){
                    $endbody .= implode("%</td><td class='text-center' style='text-align:center; color: #FFF;'>",$value);
                    $endbody .="%</td></tr>";
                }else{
                    $endbody .= implode("</td><td class='text-center' style='text-align:center; color: #FFF;'>",$value);
                    $endbody .="</td></tr>";
                }               
                $returnData .= $endbody = str_replace("<td class='text-center' style='text-align:center; color: #FFF;'></td>","<td class='text-center' style='text-align:center; color: #FFF;'>0</td>",$endbody);        
            }
        }
        return $returnData .= "</tbody></table></div>";
    }
}
function showListingReportInOUT($allData,$allTotal=NULL,$allTotalDue=NULL){       
    $count = 0;
    $returnData = '<div id="parent" style="overflow:scroll;"><table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-condensed tableuc table-vcenter row-border order-column tbl-listing">';
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
if(!function_exists('getInPlusOutDistrictReportTable')){ //getInPlusOutDistrictReportTable
    function getInPlusOutDistrictReportTable($allData,$allTotal=NULL,$weekly=NULL,$vaccination=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL, $age_wise=NULL){ 
        $count = 0;
        $returnData = '<div id="parent" style="overflow:scroll;"><table id="fixTable"  class="table table-bordered table-hover table-striped">
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
                    }
                    else{
                        if($age_wise == 'all'){
                            $months = array('BCG','Hep B','OPV-0','OPV-I','OPV-II','OPV-III','Penta-I','Penta-II','Penta-III','PCV10-I','PCV10-II','PCV10-III','IPV','Rota-I','Rota-II','Measles-I','Fully Immunized','Measles-II','TT PL I','TT PL II','TT PL III','TT PL IV','TT PL V','CBA I','CBA II','CBA III','CBA IV','CBA V');
                        }
                        else{
                            $months = array('BCG','Hep B','OPV-0','OPV-I','OPV-II','OPV-III','Penta-I','Penta-II','Penta-III','PCV10-I','PCV10-II','PCV10-III','IPV','Rota-I','Rota-II','Measles-I','Fully Immunized','Measles-II');
                        }
                    }
                }
                if($vaccination){
                    $colspanValue = "5";
                    $firstColspan = "1";
                }
                else{
                    $colspanValue = "1";
                    $firstColspan = "3";
                }
                $returnData .= "<thead>
                                    <tr><th colspan='$firstColspan'></th><th colspan='$colspanValue' class='text-center'>";
                //$returnData .= implode("</th><th colspan='$colspanValue' class='text-center'>",array_map("ucwords",array_values($months)));
                $returnData .= "</tr>
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
if(!function_exists('getReportTable')){
    function getReportTable($allData,$allTotal=NULL,$weekly=NULL,$siaCompliance=NULL,$headerNames=NULL,$percentHeader=NULL,$complianceTotalF=NULL,$siaCoverage=NULL,$siaTeams=NULL){ 
        $count = 0;
        // if($siaCoverage){
        //  $returnData = '<div><table id="fixTable" class="table table-bordered table-hover" data-filter="#filter" data-filter-text-only="true">
        //    ';
        // }
        // else{
        $returnData = '<div id="parent"><table id="fixTable" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
        //$returnData = '';
        //}
        foreach($allData as $key => $value)
        {
            if($count == 0)
            {
                if($weekly){
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
                    }
                    // else if($siaCoverage){
                    //  $months = '';
                    // }
                    else{
                        $months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
                    }
                }
                if($siaCompliance){
                    $colspanValue = "1";
                    $firstColspan = "3";
                }
                else if($siaCoverage){
                    //echo "abc";exit();
                    $colspanValue = "3";
                    $firstColspan = "2";
                }
                else if($siaTeams){
                    //echo "yes";exit();
                    $colspanValue = "7";
                    $firstColspan = "2";
                }
                else{
                    //echo "xyz";exit();
                    $colspanValue = "3";
                    $firstColspan = "2";
                }
                // if($siaCoverage){
                //  $returnData .= '';
                // }
                if($siaTeams){
                    $returnData .= '';
                }
                $returnData .= "<thead>
                                    <tr><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;' colspan='$firstColspan'></th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;' colspan='$colspanValue' class='text-center'>";
                if($siaCoverage){
                    $returnData .= '';
                }
                else if($siaTeams){
                    $returnData .= '';
                }
                else{
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;' colspan='$colspanValue' class='text-center'>",array_map("ucwords",array_values($months)));
                }
                $returnData .= "</th></tr>
                <tr><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>";
                if($siaTeams){
                    $counter = 1;                   
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>", array_map(function($v)use(&$counter,$siaTeams,$percentHeader){
                        if($counter++ > 7){
                            if($percentHeader!=''){
                                return ucwords(substr($v, 0, -7))." % ";
                            }
                            return ucwords(substr($v, 0, -7));
                        }
                        if($siaTeams && $siaTeams=="YES")
                            return ucwords(substr($v, 0, -7));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
                else{
                    $counter = 1;                   
                    $returnData .= implode("</th><th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>", array_map(function($v)use(&$counter,$siaCompliance,$percentHeader){
                        if($counter++ > 2){
                            if($percentHeader!=''){
                                return ucwords(substr($v, 0, -2))." % ";
                            }
                            return ucwords(substr($v, 0, -2));
                        }
                        if($siaCompliance && $siaCompliance=="YES")
                            return ucwords(substr($v, 0, -2));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }
            }       
            $count++;
            $body ="<tr><td style='text-align:center; border: 1px solid black;' class='text-center'>";
            $counter = 0;
            $code = '';
            $body .= implode("</td><td style='text-align:center; border: 1px solid black;' class='text-center' style='color:black;'>", array_map(function($v)use(&$counter, &$code){
                    if($counter==0)
                        $code = $v;

                    if($counter++ < 2)
                        return '<p class="clickedReport" style="padding-top: 2px;color:black;" data-value="'.$code.'">'.$v.'</p>';

                    return $v;
                },array_values($value)));
            $body .="</td></tr>";
            $returnData .= $body = str_replace("<td style='text-align:center; border: 1px solid black;' class='text-center' class='text-center''></td>",'<td style="color:black;">0</td>',$body);
        }
        
        if($allTotal)
        {
            foreach($allTotal as $key => $value)
            {
                $endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'><td></td><td class='text-center' style='color: #FFF; text-align:center;''>Total:</td><td class='text-center' style='color: #FFF; text-align:center;'>";
                if($percentHeader!=''){
                    $endbody .= implode("%</td><td class='text-center' style='color: #FFF; text-align:center;''>",$value);
                    $endbody .="%</td></tr>";
                }else{
                    $endbody .= implode("</td><td class='text-center' style='color: #FFF; text-align:center;''>",$value);
                    $endbody .="</td></tr>";
                }               
                $returnData .= $endbody = str_replace("<td class='text-center' style='color: #FFF; text-align:center;''></td>","<td class='text-center' style='color: #FFF; text-align:center;''>0</td>",$endbody);        
            }
        }
        return $returnData .= "</tbody></table></div>";
    }
}
if(!function_exists('getRegVaccines_options')){
	function getRegVaccines_options($isreturn=false,$activity=1,$returndata = FALSE,$catin=array(),$selected=NULL){
		/* $output='<option value="cr_r1_f6">BCG</option><option value="cr_r2_f6">DIL BCG</option><option value="cr_r3_f6">bOPV</option><option value="cr_r4_f6">Pentavalent-1</option><option value="cr_r5_f6">Pneumococcal-2(PCV10)</option><option value="cr_r25_f6">Pneumococcal-4(PCV10)</option><option value="cr_r6_f6">Measles-10</option><option value="cr_r8_f6">TT 10</option><option value="cr_r9_f6">TT 20</option><option value="cr_r7_f6">DIL-Measles-10</option><option value="cr_r24_f6">HBV</option><option value="cr_r10_f6">HBV-10</option><option value="cr_r20_f6">HBV-02</option><option value="cr_r11_f6">IPV-10</option><option value="cr_r19_f6">IPV-5</option><option value="cr_r18_f6">Rotarix</option><option value="cr_r23_f6">Dropper</option><option value="cr_r12_f6">AD Syringes 0.5 ml</option><option value="cr_r13_f6">AD Syringes 0.05 ml</option><option value="cr_r14_f6">Recon.Syringes (2 ml)</option><option value="cr_r15_f6">Recon. Syringes (5 ml)</option><option value="cr_r21_f6">Vitamin A Red Capsule</option><option value="cr_r22_f6">Vitamin A Blue Capsule</option><option value="cr_r16_f6">Safety Boxes</option><option value="cr_r17_f6">Other</option>';
			return  $output; */
				$CI = & get_instance();
		$output = "";
		$CI -> db -> select("eips.pk_id as itemid,eips.item_id,eips.cr_table_row_numb,epi_items.list_order as rank,item_name");
		$whereCondition['eips.activity_type_id'] = $activity; 
		$whereCondition['eips.status'] = 1;
		$CI -> db -> where($whereCondition);
		if(is_array($catin) && count($catin)>0){
			$CI->db->where_in('eips.item_category_id', $catin);
		}
		$CI -> db -> from("epi_item_pack_sizes eips");
		$CI -> db -> join("epi_items","eips.item_id = epi_items.pk_id","LEFT OUTER");
        $CI -> db -> order_by('eips.pk_id');
		$result1 = $CI -> db -> get() -> result_array();
		if($returndata)
			return $result1;
		//echo $selected;exit;
		foreach ($result1 as $vaccines) { 
			$isSelected = (isset($selected) && $selected==$vaccines["itemid"])?'selected="selected"':'';
			$vaccname = trim($vaccines["item_name"]);
			$output .= '<option value="cr_r'.$vaccines["cr_table_row_numb"].'_f6"  >'.$vaccname.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;	
		
	}
}

if(!function_exists('dueDoses')){
	function dueDoses($dose, $comparisonDate){
		$date = date('Y-m-d');
		$matchingdate = NULL;
		switch($dose){
			case 'opv1':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 43 days'));
				break;
			case 'opv2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'opv3':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'penta1':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 43 days'));
				break;
			case 'penta2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'penta3':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'pcv1':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 43 days'));
				break;
			case 'pcv2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'pcv3':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'rota1':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 43 days'));
				break;
			case 'rota2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'ipv':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 101 days'));
				break;
			case 'measles1':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' +9 month +1 day'));
				break;
			case 'measles2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' +1 year +3 month +1 day'));
				break;
		}
		$outputDate = NULL;
		if($date >= $matchingdate)
			$outputDate = $matchingdate;
		return $outputDate;
	}
}
if(!function_exists('dueDoses_women')){
	function dueDoses_women($dose, $comparisonDate){
		$date = date('Y-m-d');
		$matchingdate = NULL;
		switch($dose){
			case 'tt2':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 30 days'));
				break;
			case 'tt3':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 6 month'));
				break;
			case 'tt4':
				$matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 1 year'));
                break;
            case 'tt5':
                $matchingdate = date('Y-m-d', strtotime($comparisonDate. ' + 1 year'));
                break;
		}
		$outputDate = NULL;
		if($date >= $matchingdate)
			$outputDate = $matchingdate;
		return $outputDate;
	}
}
if(!function_exists('getvaccinereport')){
	function getvaccinereport($vaccine,$interval,$gender,$data)
	{
		$CI=& get_instance();
		$wa = array(); 
		$lastdateofmonth = date("t",strtotime($data['monthfrom']."-15"));
		if(array_key_exists("monthfrom", $data)){
			$wa[] = "{$vaccine} is not NULL and {$vaccine} >= '".$data['monthfrom'].'-01'."'";
		}
		if(array_key_exists("monthfrom", $data)){
			$wa[] = "{$vaccine} <= '".$data['monthfrom'].'-'.($lastdateofmonth)."'";
		}
		if(array_key_exists("distcode", $data)){
			$wa[] = "distcode = '".$data['distcode']."'";
		}
		if(array_key_exists("tcode", $data)){
			$wa[] = "tcode = '".$data['tcode']."'";
		}
		if(array_key_exists("uncode", $data)){
			$wa[] = "uncode = '".$data['uncode']."'";
		}
		$wa[] = "gender = '{$gender}' and '".$data['monthfrom'].'-'.($lastdateofmonth)."' < dateofbirth  + interval '{$interval}' and deleted_at IS NULL";
		
		$wherea = ((!empty($wa))? 'where '.implode(" AND ",$wa):' where');
		$query = "select count({$vaccine}) as noofchilds from cerv_child_registration ".$wherea;
		
        //echo $query;exit;

        //echo $this->db->last_query();exit;

		$results=$CI->db->query($query);
		
		//echo $this -> db -> last_query();exit;
		$rows=$results->row_array();
		
		return (isset($rows['noofchilds']))?$rows['noofchilds']:0;
		
		//return (isset($rows -> count))?$rows -> count:0;
	}
}	