<?php
if(!function_exists('getListingReportTable')){
	function getListingReportTable($allData,$listingFor,$allTotal=NULL,$sectionTotal = 'Yes'){
		//print_r("tmy");exit;
		if(!empty($allData)){
			$count = 0;
			$innerHead = '';
			$insiderow = '';
			$moon = array();
			$countALLRecords=0;
			$returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing" data-filter="#filter" data-filter-text-only="true">';
			foreach($allData as $key => $value)
			{
				$headerRow = '';
				if($value['total'] )
				{
					if($insiderow == '' || $insiderow != $value['insiderow']) 
					{
						$insiderow = $value['insiderow'];
						if(count($moon) > 0)
						{
							//for section total
							array_splice($moon, 0, 2);// change 3 to 2 
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
				$returnData .= '<tr class="DrillDownRow"><td';
				$returnData .= implode("</td><td ", array_map(function($v)/* use(&$class) */
				{
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
						$moon[$k] =  $moon[$k]+$v;
					}else{
						$moon[$k] =  $moon[$k];
					}
				}
			}
			if(count($moon) > 0 && $allTotal != 'NO' && $sectionTotal == 'NO')
			{
				//for section total
				array_splice($moon, 0, 2);
				$returnData .= "<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td style='font-weight:bold; background-color: #111;color: #FFF;'></td><td style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td><td class='text-center' class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
				$returnData .= implode("</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>",$moon);      
				$returnData .= "</td></tr>";
				$moon = array();
			} 
			//for last row total
			if($allTotal && $sectionTotal!='NO')
			{
				foreach($allTotal as $key => $value)
				{
					$endbody ="<tr style='font-weight:bold;'><td colspan=\"2\">District Aggregate:Total $listingFor: $countALLRecords</td><td>";
					$endbody .= implode("</td><td>",$value);
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
		}else{
			return $returnData = "<div class='alert alert-info' style='text-align:center; width:26%;border-color:#090909;margin-left:31%' role='alert'><label>Sorry! No Record Found</label></div>";
		}
    }
}
if(!function_exists('extract_indicator_query')){
function extract_indicator_query($arrayData, $fmonth, $level, $distcode,$report_table="flcfmr"){


    $formula        = $arrayData[0]["formula"];
    $ind_name       = $arrayData[0]["ind_name"];
    $num_text       = $arrayData[0]["numerator"];
    $den_text       = $arrayData[0]["denominator"];
    $multiple       = $arrayData[0]["multiple"];
    $ind_type       = $arrayData[0]["ind_type"];
    $is_inverse     = $arrayData[0]["is_inverse"];
    $result_text    = $arrayData[0]["result_text"];
    $description    = $arrayData[0]["description"];
    
    $divstr=explode("/",$formula);
    $num=$divstr[0];
    $den=$divstr[1];
    
    $divnumfields=explode("+",$num);
    for($i=0;$i<count($divnumfields);$i++){
        $divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
    }   
    $numerator=implode("+",$divnumfields);
    
    $divnumfields=explode("+",$den);
    for($i=0;$i<count($divnumfields);$i++){
        $divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
    }   
    $denominator=implode("+",$divnumfields);
    
    $table="";
    if($den!=""){
        $mul="*$multiple";
    }
    if($level=="district"){
        $hcode="distcode";
        $table=$report_table;//"flcfmr";
        $hname="districtname(distcode)";
    }
    if($level=="facility"){
        $hcode="facode";
        $table=$report_table;//"flcfmr";
        $hname="facilityname(facode)";
    }
    if($is_inverse=="1")
    {
        $orderType = "Asc";
    }else
    {
        $orderType = "Desc";
    }
    $wc="";
    $wc.=($level=="facility"?"and distcode='$distcode'":"");

    $qformula=($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul");
    $extratedquery="select $hcode, $hname, ($numerator::numeric) as \"$num_text\", ($denominator::numeric) as \"$den_text\", round(coalesce($qformula,0)::numeric,2) as \"$result_text\", '$ind_type' as unit from $table where fmonth='$fmonth' $wc group by $hcode order by \"$result_text\" $orderType";
    $tformula=($denominator==""?"sum(\"$num_text\")":"((sum(\"$num_text\"))::numeric//(sum(\"$den_text\"))::numeric)$mul");
    $extratedqueryTotal="select sum(\"$num_text\") as totalNum, sum(\"$den_text\") as totalDeNum, round(coalesce($tformula,0)::numeric,2) as totalAll, '$ind_type' as totalUnit from ($extratedquery) as a";
    return $extratedquery.'-::-'.$extratedqueryTotal.'-::-'.$description;
}
}

if(!function_exists('getComplianceReportTable')){
    function getComplianceReportTable($allData,$allTotal=NULL){ 

    $count = 0;
    $returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter tbl-lhwmr-compliance" data-filter="#filter" data-filter-text-only="true">
       ';
    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
            $months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
            $returnData .= "<thead>
            <tr style='background-color: #27A500;color: #FFF;'><th colspan='2' class='Heading text-center'></th><th colspan='3' class='Heading text-center'>";
                $returnData .= implode("</th><th class='text-center' colspan='3'>",array_map("ucwords",array_values($months)));
                $returnData .= "</th></tr>
                <tr class='info'><th>";
                    $counter = 1;
                    $returnData .= implode("</th><th class='text-center' style='padding: 3px;'>", array_map(function($v)use(&$counter){
                        if($counter++ > 2)
                            return ucwords(substr($v, 0, -2));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</th></tr></thead><tbody>";
                }       
                $count++;
                $body ="<tr><td>";
                $counter = 0;
                $code = '';
                $body .= implode("</td><td>", array_map(function($v)use(&$counter, &$code){
                        if($counter==0)
                            $code = $v;
                        if($counter++ < 2)
                            return '<p class="clickedReport" data-value="'.$code.'">'.$v.'</p>';
                        return $v;
                    },array_values($value)));
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td></td>','<td>0</td>',$body);
    }

    if($allTotal)
    {
        foreach($allTotal as $key => $value)
        {
            $endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'><td></td><td style='font-weight:bold;'>Total:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$value);
            $endbody .="</td></tr>";//<td>$sumResult</td>
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
        }
    }  

    return $returnData .= "</tbody></table>";
}

/*function getComplianceReportTable($allData,$allTotal=NULL){ 
    $count = 0;
    $returnData = ' <table class="table table-condensed table-bordered table-hover table-striped footable table-vcenter tbl-lhwmr-compliance" data-filter="#filter" data-filter-text-only="true">
            ';

    foreach($allData as $key => $value)
    {
        if($count == 0)
        {
            $months = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec','total');
            $returnData .= "<thead>
            <tr style='background-color: #27A500;color: #FFF;'><th colspan='2' class='Heading text-center'></th><th colspan='3' class='Heading text-center'>";
                $returnData .= implode("</th><th class='Heading text-center' colspan='3'>",array_map("ucwords",array_values($months)));
                $returnData .= "</th></tr>
                <tr class='info'><td class='text-center' style='padding: 3px;'>";
                    $counter = 1;
                    $returnData .= implode("</th><td class='text-center' style='padding: 3px;'>", array_map(function($v)use(&$counter){
                        if($counter++ > 2)
                            return ucwords(substr($v, 0, -2));
                        return ucwords($v);
                    },array_keys($value)));
                    $returnData .= "</td></tr></thead><div id='toUpdate'><tbody id='tbody'>";
                }       
                $count++;
                $body ="<tr><td>";

                
                $vlaCounter = 0;
                $nValue = $value;
                $code = $nValue['facode'];
                foreach ($value as $key => $val) {
                    //echo $val;
                    if($vlaCounter > 1)
                        break;
                    $nValue[$key] = '<a href ="lhwmr_compliance.php?code='.$code.'">'.$val.'</a>';
                    $vlaCounter++;
                    # code...
                }
                $value = $nValue;
                
                $counter = 0;
                $code = '';
                $body .= implode("</td><td>", array_map(function($v)use(&$counter, &$code){
                        if($counter==0)
                            $code = $v;
                        if($counter++ < 2)
                            return '<p class="clickedReport" data-value="'.$code.'">'.$v.'</p>';
                        return $v;
                    },array_values($value)));


                //$body .= implode("</td><td>",$value);
        $body .="</td></tr>";//<td>$sumResult</td>
        $returnData .= $body = str_replace('<td></td>','<td>0</td>',$body);
    }

    if($allTotal)
    {
        foreach($allTotal as $key => $value)
        {
            $endbody ="<tr class='total-row' style='background-color: #111;color: #FFF;'><td></td><td style='font-weight:bold;'>Total:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$value);
            $endbody .="</td></tr>";//<td>$sumResult</td>
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
        }
    }               
    return $returnData .= "</tbody></div></table>";
}*/
}

if(!function_exists('getComplianceFLCFReportTable')){
    function getComplianceFLCFReportTable($allData,$allTotal=NULL,$allTotalDue=NULL){
$count = 0;
    $returnData = '<table border="1" cellspacing="0" width="100%" align="center" style="text-align:center;" class="table table-bordered col-md-12 report-table">';
    //var_dump($allData);exit();
    foreach($allData as $key => $value)
    {
        
        if($count == 0)
        {
            $returnData .= "<thead>";
            $returnData .= "<tr style='background-color: #27A500;color: #FFF;' ><th class='text-center'>";
            $returnData .= implode("</th><th class='text-center'>", array_map('ucwords',array_keys($value)));
            $returnData .= "</th></tr></thead><tbody>";
            $count++;
        }           
        $body ="<tr><td class='text-center'>";
        $counter = 1;
        $code='';
        $body .= implode("</td><td class='text-center'>",array_map(function($v)use(&$counter,$value,&$code){
            if($counter==1)
                $code = $v;
            if($counter <= 2)
            {
                $counter++;
                return '<p class="Compliance" data-value="'.$code.'">'.$v.'</p>';
                return $v;
            }
            
            if($counter++ == count($value))
                return '<b>'.$v.'</b>';
            if($v==1)
            {
                return '<img width="20" class="mrClicked" height="20" data-value="'.$code.'" data-month="'.sprintf("%'.02d",$counter-3).'" src="../includes/images/'.$v.'.png" />';
            }else{
                return "<img width='20' height='20' src=\"../includes/images/".$v.".png\" />";
            }
            
        },array_values($value)));       
        $body .="</td></tr>";
        $returnData .= $body = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'>0</td>',$body);
    }

    if($allTotalDue)
    {
        $endbody ="<tr><td></td><td style='font-weight:bold;'>Total Due:</td>";
        for($ind = 1; $ind<13; $ind++)
        {
            $endbody .= "<td class='text-center'>".$allTotalDue."</td>";
            


        }
        $endbody .="<td class='text-center'>".($allTotalDue*12)."</td></tr>";
        $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);
    }   
    if($allTotal)
    {
        foreach($allTotal as $key => $value)
        {
            $endbody ="<tr style='font-weight:bold; background-color: #111;color: #FFF;'><td></td><td>Total Submitted:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$value);
            $endbody .="</td></tr>";
            $returnData .= $endbody = str_replace('<td class=\'text-center\'></td>','<td class=\'text-center\'></td>',$endbody);        
            
        }

    }

    if($allTotalDue){
        
        //print_r($allTotal);
        foreach($allTotal as $key => $value)
        {
            //echo $allTotalDue = $allTotalDue;
            $value13 = $value['total13'];
            $bcb = $allTotalDue*12;
            $value13 = number_format(((intval($value13)/intval($bcb))*100),2);
            $arr_mod = array_map( function($val) use ($allTotalDue) { 
                
                $abc = intval($val)/intval($allTotalDue);
                $perc = number_format($abc*100,2);
                
                return $perc;
            }, $value);
            //print_r($arr_mod);
            $arr_mod['total13'] = $value13;
            $endbody ="<tr style='font-weight:bold;' ><td></td><td>Percent Submitted:</td><td class='text-center'>";
            $endbody .= implode("</td><td class='text-center'>",$arr_mod);
            $endbody .="</td></tr>";
            $returnData .= $endbody;
        }

    }
    return $returnData .= "</tbody></table>";
 }
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
/* if(!function_exists('FacilityNameByuncode')){
    function FacilityNameByuncode($uncode="")
	{
        $CI=& get_instance();
		$output = '';
        $_query  = "select fac_name,facode from facilities where uncode = '$uncode'";
        $results=$CI->db->query($_query);
		
		$result1 = $results->result_array();
		foreach ($result1 as $onedist) { 
			//$selected = '';
			/* if(($uncode > 0)&&($uncode == $onedist["uncode"]))
			{ */
				//$selected = 'selected="selected"';
			//}
			//$isSelected = (isset($selected) && $selected==$onedist["facode"])?'selected="selected"':'';
			//$vaccname = trim($vaccines["item_name"]);
			//$output .= '<option value="cr_r'.$vaccines["cr_table_row_numb"].'_f6"  >'.$vaccname.'</option>';
		///
		
			/* $selected = '';
			if(($uncode > 0)&&($uncode == $onedist["uncode"]))
			{
				$selected = 'selected="selected"';
			} */
			//$output .= '<option value="'.$oneteh["uncode"].'" '.$selected.' >'.$oneteh["un_name"].'</option>';
		
		
		
		
		///
		
		
		
		
		
		
			/* $output .= '<option value="'.$onedist["facode"].'"  >'.$onedist["fac_name"].'</option>'; 
		}
			//return $output;
		if($isreturn)
				return $output;
			echo $output;
	} */
	
       /*  $rows=$results->row_array();

        return $rows['fac_name']; *
    //}
} */
 if(!function_exists('getFLCF_options')){
	function getFLCF_options($isreturn=false,$facode=NULL,$uncode=NULL){		
		$CI = & get_instance();
		$wc = getWC();
		/* if($uncode > 0){
			$uc_var = "and uncode='$uncode'";
		}
		else{
			$uc_var = "";
		 }*/
		$output = '<option value="" >-- Select Health Facility--</option>';
		//$query="SELECT fac_name, facode from facilities where $wc order by fac_name";
		$query="SELECT fac_name, facode from facilities where uncode='$uncode' order by fac_name";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $oneflcf) { 
			$selected = '';
			if(($facode > 0)&&($facode == $oneflcf["facode"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$oneflcf["facode"].'" '.$selected.' >'.$oneflcf["fac_name"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
} 
/* if(!function_exists('getFLCF_options')){
		function getFLCF_options($uncode="")
		{
			$CI=& get_instance();
			$output = '';
			$_query  = "select fac_name,facode from facilities where uncode = '$uncode'";
			$results=$CI->db->query($_query);
			
			$result1 = $results->result_array();
			foreach ($result1 as $onedist) { 
				
				$output .= '<option value="'.$onedist["facode"].'"  >'.$onedist["fac_name"].'</option>'; 
			}
				return $output;
		} 
	} */

if(!function_exists('createTransactionLog')){
	function createTransactionLog($module, $action) {
		//echo "moon";exit;
		$CI=& get_instance();
		$CI->load->library('user_agent');
		//transaction log
		date_default_timezone_set("Asia/Karachi");
		$dateTime = date("Y-m-d H:i:s");
		$system_info=$_SERVER['HTTP_USER_AGENT'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$_query1 = "insert into user_transaction_log (username, datetime,  ip_address, browser, module, action, userlevel, usertype) 
		values('$_SESSION[username]', '$dateTime','$ip','$system_info' , '$module', '$action', '$_SESSION[UserLevel]', '$_SESSION[utype]')";
		$result = $CI->db->query($_query1);
		return $result;
	}
}
if(!function_exists('array_2d_to_1d')){
	function array_2d_to_1d ($input_array) {
		$output_array = array();
		for ($i = 0; $i < count($input_array); $i++) {
		  for ($j = 0; $j < count($input_array[$i]); $j++) {
			$output_array[] = $input_array[$i][$j];
		  }
		}
		return $output_array;
	}
}
if(!function_exists('get_status_options')){
	function get_status_options($currentStatus,$distinguishStatusEdit = false){
	$options = ''; 
	switch ($currentStatus) {
		case 'Active': 
			if($distinguishStatusEdit){$options .= '<option value="Active">Active</option>';}
			$options .= '<option value="Terminated">Terminated</option>
				<option value="Transferred">Transferred</option>
				<option value="Retired">Retired</option>
				<option value="Resigned">Resigned</option>
				<option value="On Leave">On Leave</option>
				<option value="Died">Died</option>
				<option value="Posted">Temporary-Post</option>
				<option value="Contract Expired">Contract Expired</option>
				<option value="Shifted">Shifted</option>';
			break;
		case 'Terminated':
			if($distinguishStatusEdit){$options .= '<option value="Terminated">Terminated</option>';}
			//$options .= '<option value="Active">Active</option>';
			break;
		case 'On Leave':
			if($distinguishStatusEdit){$options .= '<option value="On Leave">On Leave</option>';}
			$options .= '<option value="Active">Active</option>';
			break;	
		/* case 'Transferred':  
			if($distinguishStatusEdit){$options .= '<option value="Transferred">Transferred</option>';}
			$options .= '<option value="Active">Active</option>';
			break; */
		case 'Retired':
			if($distinguishStatusEdit){$options .= '<option value="Retired">Retired</option>';}
			//echo '<option value="Reinstate">Reinstate</option>';
			break;
		case 'Posted': 
			if($distinguishStatusEdit){$options .= '<option value="Posted">Temporary-Post</option>';}
			echo '<option value="Post_Back">Post Back</option>';
			break;
		case 'Resigned':
			if($distinguishStatusEdit){$options .= '<option value="Resigned">Resigned</option>';}
			//echo '<option value="Reinstate">Reinstate</option>';
			break;
		case 'Died':
			if($distinguishStatusEdit){$options .= '<option value="Died">Died</option>';}
			break;
		case 'Contract Expired':
			if($distinguishStatusEdit){$options .= '<option value="Contract Expired">Contract Expired</option>';}
			break;
		case 'Shifted':
			if($distinguishStatusEdit){$options .= '<option value="Shifted">Shifted</option>';}
			break;	
		default:
			$options .= '<option value="Active">Active</option>'; 
			//echo '<option value="Transferred in">Transferred in</option>';
			break;
	}
	echo $options;
  }
}	
if(!function_exists('getSectionsStatusTableHR')){
	function getSectionsStatusTableHR($hrstatus){
		$CI = & get_instance();
		$UserLevel = $CI -> session -> UserLevel;
		$utype = $CI -> session -> utype;
        $count = 0;
        $returnData = '<table id="hr_status" border="1" cellspacing="0" align="center" style="text-align:center;" class="table table-bordered col-md-12 report-table">';
        $i=0;
		foreach($hrstatus as $key => $value)
        {
			
			//print_r($value['code']); 
			$i++;
			$id = $value['id'];
			$hrcode = $value['code'];
			$status_date = $value['status_date'];
			$pre_status = $value['pre_status'];
			$postStatus = $value['post_status'];
			$predistcode = $value['predistcode'];
			$postdistcode = $value['postdistcode'];
			unset($value['id']);
			unset($value['code']);  
			unset($value['pre_status']);  
			unset($value['status_date']);  
			unset($value['predistcode']);  
			unset($value['postdistcode']);  
			unset($value['level']);  
		    if($count == 0)
            {
                $logisticfp_report = array('S#','Status Histroy','Action');
                $returnData .= "<thead>
                <tr style='background-color: #008D4C;color: #FFF;'><th  class='text-center'>";
				$returnData .= implode("</th><th class='text-center' >",array_map("ucwords",array_values($logisticfp_report)));
				$returnData .= "</th></tr>";
				$returnData .= "<tr>";
				$counter = 1;
				$returnData .= "<tbody>";
			}       
			$count++;
			$body ="<tr id='main_tr'><td>".$i."</td><td>";
			$counter = 0;
			$code = '';
			$body .= implode("</td><td id='main_td'>", array_map(function($v)use(&$counter,$predistcode,$postdistcode,$pre_status,$status_date,&$code){
				if($counter==0)
					$code = $v;
				if($counter++ < 2)
					//return '<p class="clickedReport" data-value="'.$code.'">'.$v.'</p>';
					if($pre_status == "Transferred"){
							return'<p class="clickedReport" data-value="'.$code.'"> Transferred From '.$predistcode.' to '.$postdistcode.'</p>';
					}if($pre_status == "Post_Back"){
						return'<p class="clickedReport" data-value="'.$code.'"> Post Back in '.$postdistcode.'</p>';
					}
					if($pre_status == "Posted"){
							return'<p class="clickedReport" data-value="'.$code.'"> Posted as '.$predistcode.' at '.$postdistcode.'</p>';
					}
					$currentStatus = $v;
					switch ($currentStatus) {  
						case 'Active':
						return'<p class="clickedReport" data-value="'.$code.'"> New User Registered at '.$postdistcode.'</p>'; 
						break;
						/* case 'Transferred':
						return'<p class="clickedReport" data-value="'.$code.'"> Transferred From '.$predistcode.' to '.$postdistcode.'</p>';
						break; */
						case 'On Leave':
						return'<p class="clickedReport" data-value="'.$code.'"> On Leave'.$status_date.'</p>';
						break;
						/* case 'Posted':
						return'<p class="clickedReport" data-value="'.$code.'"> Posted at '.$postdistcode.'</p>';
						break; */
						/* case 'Post_Back':
						return'<p class="clickedReport" data-value="'.$code.'"> Post Back in '.$postdistcode.'</p>';
						break; */
						case 'Died':
						return'<p class="clickedReport" data-value="'.$code.'"> Died on '.$status_date.'</p>';
						break;
						case 'Terminated':
						return'<p class="clickedReport" data-value="'.$code.'"> Terminated on '.$status_date.'</p>';
						break;
						case 'Retired':
						return'<p class="clickedReport" data-value="'.$code.'"> Retired on '.$status_date.'</p>';
						break;
						case 'Resigned':
						return'<p class="clickedReport" data-value="'.$code.'"> Resigned on '.$status_date.'</p>'; 
						break;
						case 'Contract Expired':
						return'<p class="clickedReport" data-value="'.$code.'"> Contract Expired on '.$status_date.'</p>'; 
						break;
						case 'Shifted':
						return'<p class="clickedReport" data-value="'.$code.'"> Shifted to Another Program</p>'; 
						break;
						default:
						return'<p> Empty </p>';
					}
						
					return $v;
			},array_values($value)));
			
			
			$del = true;
			$url=base_url(); 
			$body .='</td><td>'; 
			if(!($del && $i == 1)){}elseif(($UserLevel == 2 || $UserLevel == 3) && $utype == 'Manager' || $utype == 'DEO'){ 
				$body .='<a id="del" href="'.$url.'Hr_management/hr_status_del/'.$hrcode.'/'.$status_date.'/'.$postStatus.'" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>';
			}
			$body .='</td></tr>';
			$returnData .= $body = str_replace('<td></td>','<td></td>',$body); 
        }
        return $returnData .= "</tbody></table>";
    

	}
}
/////////////////////// this function is for status history of HR Report View //////////////////
if(!function_exists('getSectionsStatus')){
    function getSectionsStatus($hrstatus){
        $CI = & get_instance();
        $UserLevel = $CI -> session -> UserLevel;
        $utype = $CI -> session -> utype;
        $count = 0;
        $returnData = '<table id="hr_status" cellspacing="0" align="center" style="text-align:center;" class="table table-bordered col-md-12 report-table">';
        //$i=0; // comment this to hide S# of status history
        foreach($hrstatus as $key => $value)
        {
            
            //print_r($value['code']); 
           // $i++;     // comment this to hide S#
            $id = $value['id'];
            $hrcode = $value['code'];
            $status_date = $value['status_date'];
            $pre_status = $value['pre_status'];
            $postStatus = $value['post_status'];
            $predistcode = $value['predistcode'];
            $postdistcode = $value['postdistcode'];
            unset($value['id']);
            unset($value['code']);  
            unset($value['pre_status']);  
            unset($value['status_date']);  
            unset($value['predistcode']);  
            unset($value['postdistcode']);  
            unset($value['level']);  
            if($count == 0)
            {
                $logisticfp_report = array('Status Histroy &nbsp;&nbsp;&nbsp;&nbsp;( top record is recent )');
               // print_r($logisticfp_report);exit();
                $returnData .= "<thead style='height: 30px;font-family:Arial'>
                <tr style='background-color: #008D4C;color: #FFF;'><th  class='text-center'>";
                $returnData .= implode("</th><th class='text-center' >",array_map("ucwords",array_values($logisticfp_report)));
                
                $returnData .= "</th></tr>";
                $returnData .= "<tr>";
                $counter = 1;
                $returnData .= "<tbody>";
                //print_r($returnData);exit();
            }       
            $count++;
            $body ="<tr id='main_tr'><td style='width: 17%'>"; //<-- to see S# put this before; .$i."</td><td>"
            $counter = 0;
            $code = '';
            $body .= implode("</td><td id='main_td'>", array_map(function($v)use(&$counter,$predistcode,$postdistcode,$pre_status,$status_date,&$code){
                if($counter==0)
                    $code = $v;
                if($counter++ < 2)
                    //return '<p class="clickedReport" data-value="'.$code.'">'.$v.'</p>';
                    if($pre_status == "Transferred"){
                    	//echo "aaa";exit();
                            return'<p class="clickedReport" data-value="'.$code.'"> Transferred From '.$predistcode.' to '.$postdistcode.' </p>';
                    }
                    if($pre_status == "Post_Back"){
                    	//echo "bbb";exit();
                        return'<p class="clickedReport" data-value="'.$code.'"> Post Back in '.$postdistcode.'</p>';
                    }
                    if($pre_status == "Posted"){
                    	//echo "ccc";exit();
                            return'<p class="clickedReport" data-value="'.$code.'"> Posted as '.$predistcode.' at '.$postdistcode.'</p>';
                    }
                    $currentStatus = $v;
                    switch ($currentStatus) {  
                    	//echo "ddd";exit();
                        case 'Active':
                        return'<p class="clickedReport" data-value="'.$code.'"> New User Registered at '.$postdistcode. ' </p>'; 
                        break;
                        /* case 'Transferred':
                        return'<p class="clickedReport" data-value="'.$code.'"> Transferred From '.$predistcode.' to '.$postdistcode.'</p>';
                        break; */
                        case 'On Leave':
                        return'<p class="clickedReport" data-value="'.$code.'"> On Leave'.$status_date.'</p>';
                        break;
                        /* case 'Posted':
                        return'<p class="clickedReport" data-value="'.$code.'"> Posted at '.$postdistcode.'</p>';
                        break; */
                        /* case 'Post_Back':
                        return'<p class="clickedReport" data-value="'.$code.'"> Post Back in '.$postdistcode.'</p>';
                        break; */
                        case 'Died':
                        return'<p class="clickedReport" data-value="'.$code.'"> Died on '.$status_date.'</p>';
                        break;
                        case 'Terminated':
                        return'<p class="clickedReport" data-value="'.$code.'"> Terminated on '.$status_date.'</p>';
                        break;
                        case 'Retired':
                        return'<p class="clickedReport" data-value="'.$code.'"> Retired on '.$status_date.'</p>';
                        break;
                        case 'Resigned':
                        return'<p class="clickedReport" data-value="'.$code.'"> Resigned on '.$status_date.'</p>'; 
                        break;
						case 'Contract Expired':
						return'<p class="clickedReport" data-value="'.$code.'"> Contract Expired on '.$status_date.'</p>'; 
						break;
						case 'Shifted':
						return'<p class="clickedReport" data-value="'.$code.'"> Shifted to Another Program</p>'; 
						break;
                        default:
                        return'<p> Empty </p>';
                    }
                        
                    return $v;
            },array_values($value)));
            
            
            $del = true;
            $url=base_url(); 
            $body .='</td><td>'; 
           /* if(!($del && $i == 1)){}elseif(($UserLevel == 2 || $UserLevel == 3) && $utype == 'Manager' || $utype == 'DEO'){ 
                $body .='<a id="del" href="'.$url.'Hr_management/hr_status_del/'.$hrcode.'/'.$status_date.'/'.$postStatus.'" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>';
            }*/
            $body .='</td></tr>';
            $returnData .= $body = str_replace('<td></td>','<td style="display: none;"></td>',$body); 
        }
        return $returnData .= "</tbody></table>";
    

    }
}
?>