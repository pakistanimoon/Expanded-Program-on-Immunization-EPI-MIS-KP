<?php 
if(!function_exists('getSingleRegionUrl')){
	function getSingleRegionUrl($procode){
		$CI = & get_instance();
		$liveUrl = $CI -> session -> liveURL;
		$localUrl = $CI -> session -> localURL;
		$baseUrl = base_url();
		if($baseUrl == $liveUrl){
			switch($procode){
				case  "1":
					return "http://federal.epimis.pk/";
					break;
				case  "2":
					return "http://federal.epimis.pk/";
					break;
				case  "3":
					return "http://epimis.cres.pk/";
					break;
				case  "4":
					return "http://balochistan.epimis.pk/";
					break;
				case  "5":
					return "http://ajk.epimis.pk/";
					break;
				case  "6":
					return "http://gb.epimis.pk/";
					break;
				case  "7":
					return "http://islamabad.epimis.pk/";
					break;
				case  "8":
					return "http://fata.epimis.pk/";
					break;
				default:
					return NULL;
					break;
			}
		}
		else{
			switch($procode){
				case  "1":
					return "http://epifederal.pacemis.com/";
					break;
				case  "2":
					return "http://epifederal.pacemis.com/";
					break;
				case  "3":
					return "http://epikp.pacemis.com/";
					//return "http://epibeta.pacemis.com/";
					break;
				case  "4":
					return "http://epiblch.pacemis.com/";
					break;
				case  "5":
					return "http://epiajk.pacemis.com/";
					break;
				case  "6":
					return "http://epigb.pacemis.com/";
					break;
				case  "7":
					return "http://epiict.pacemis.com/";
					break;
				case  "8":
					return "http://epifata.pacemis.com/";
					break;
				default:
					return NULL;
					break;
			}
		}
	}
}
if(!function_exists('getAdministrativeNames')){
	function getAdministrativeNames($url=NULL,$filepath=NULL,$procode=NULL,$distcode=NULL,$tcode=NULL,$uncode=NULL,$facode=NULL)
	{		
		$data = array('procode' => $procode,'distcode' => $distcode,'tcode' => $tcode,'uncode' => $uncode,'facode' => $facode);
		//$data = $Array;
		//post data mechanism
		$fields_string = "";
		foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string, '&');
		//$filepath = 'API/Receiver/get_cc_assetType_counts';
		//url to post
		if($url===NULL)
			$url = "http://epimis.cres.pk/";
		$url .= $filepath;
		//curl options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);		
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		$saveData = curl_exec($ch);
		//print_r($saveData);exit();
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);				
		curl_close($ch);
		//workout for data in response
		//$userData = json_decode($saveData, true);
		if(isset($saveData)){
			return $saveData;
		}else{
			return array();
		}
	}
}

if(!function_exists('CrossProvince_DistrictName')){
    function CrossProvince_DistrictName($distcode,$isreturn=false)
    {   
    	//echo $distcode;exit();
        $CI = & get_instance();
		$procode = substr($distcode,0,1);
        if($distcode == $CI -> session -> District){
        	//echo "abc";exit();	
	        $_query  = "SELECT district from districts where distcode = '$distcode'";
	        $results=$CI->db->query($_query);
	        $rows=$results->row_array();        
	        return $rows['district'];
	    }
        else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/DistNames';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode);
			//echo "safe";exit();
			if($isreturn)
			{
				return $dataMeasles;
			}
			else{
				echo $dataMeasles;
			}
		}
    }
}
if(!function_exists('getCrossProvince_DistrictsOptions')){
	function getCrossProvince_DistrictsOptions($isreturn=false,$distcode=NULL,$allDistricts=NULL){
		$CI = & get_instance();
		if($allDistricts=="Yes"){
			$wc = "province = '".$_SESSION["Province"]."'";
		}else if($allDistricts=="No"){
			$wc = "distcode = '$distcode'";
		}
		else{
			$wc = getWC();
		}
		$procode = substr($distcode, 0,1);
		if($distcode == $CI -> session -> District){
			$wc = str_replace("procode","province",$wc);
			$output = '';
			$query="SELECT district,distcode from districts where procode='$procode' order by district asc";
			$result = $CI -> db ->query($query);
			$result1 = $result->result_array();
			foreach ($result1 as $onedist) { 
				$selected = '';
				if(($distcode > 0)&&($distcode == $onedist["distcode"]))
				{
					$selected = 'selected="selected"';
				}
				$output .= '<option value="'.$onedist["distcode"].'" '.$selected.' >'.$onedist["district"].'</option>';
			}
			if($isreturn)
				return $output;
			echo $output;
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/DistOptions';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode);
			//echo "safe";exit();
			echo $dataMeasles;
		}
	}
}
if(!function_exists('CrossProvince_TehsilName')){
	function CrossProvince_TehsilName($tcode,$isreturn=false){
		$CI = & get_instance();
		$procode = substr($tcode,0,1);
		$distcode = substr($tcode,0,3);
		if($distcode == $CI -> session -> District){
			$query 		= "SELECT tehsil from tehsil where tcode = '$tcode'";
			$resultTeh = $CI -> db -> query($query) -> row_array();
			return $resultTeh['tehsil'];
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/TehsilNames';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode, $tcode);
			//echo "safe";exit();
			if($isreturn)
			{
				return $dataMeasles;
			}
			else{
				echo $dataMeasles;
			}
		}
	}
}
if(!function_exists('getCrossProvince_TehsilOptions')){
	function getCrossProvince_TehsilOptions($isreturn=false,$tcode=NULL,$distcode=NULL){
		//echo $tcode; exit();
		$CI = & get_instance();
		if($distcode){
			$wc = "distcode = '$distcode'";
		}else{
			$wc = getWC();
		}
		$procode = substr($tcode,0,1);
		$distcode = substr($tcode,0,3);
		if($distcode == $CI -> session -> District){		
			$output = '<option value="0" >-- Select Tehsil--</option>';
			$query="SELECT tehsil,tcode from tehsil where distcode='$distcode' order by tcode";
			$result = $CI -> db ->query($query);
			$result1 = $result->result_array();
			foreach ($result1 as $oneteh) { 
				$selected = '';
				if(($tcode > 0)&&($tcode == $oneteh["tcode"]))
				{
					$selected = 'selected="selected"';
				}
				$output .= '<option value="'.$oneteh["tcode"].'" '.$selected.' >'.$oneteh["tehsil"].'</option>';
			}
			if($isreturn)
				return $output;
			echo $output;
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/TehsilOptions';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode, $tcode);
			//echo "safe";exit();
			echo $dataMeasles;
		}
	}
}

if(!function_exists('CrossProvince_UCName')){
	function CrossProvince_UCName($uncode,$isreturn=false){
		$CI = & get_instance();
		$procode = substr($uncode,0,1);
		$distcode = substr($uncode,0,3);
		$tcode = substr($uncode,0,6);
		if($distcode == $CI -> session -> District){
			$query 		= "SELECT un_name from unioncouncil where uncode = '$uncode'";
			$resultUCs = $CI -> db -> query($query) -> row_array();
			return $resultUCs['un_name'];
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/UCNames';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode, $tcode, $uncode);
			//echo "safe";exit();
			if($isreturn)
			{
				return $dataMeasles;
			}
			else{
				echo $dataMeasles;
			}
		}
	}
}
if(!function_exists('getCrossProvince_UCsOptions')){
	function getCrossProvince_UCsOptions($isreturn=false,$uncode=NULL){
		$CI = & get_instance();
		$wc = getWC();
		$procode = substr($uncode,0,1);
		$distcode = substr($uncode,0,3);
		$tcode = substr($uncode,0,6);
		if($distcode == $CI -> session -> District){
			$output = '<option value="" >-- Select Union Council--</option>';
			$query="SELECT un_name,uncode from unioncouncil where tcode='$tcode' order by uncode";
			$result = $CI -> db ->query($query);
			$result1 = $result->result_array();
			foreach ($result1 as $oneteh) { 
				$selected = '';
				if(($uncode > 0)&&($uncode == $oneteh["uncode"]))
				{
					$selected = 'selected="selected"';
				}
				$output .= '<option value="'.$oneteh["uncode"].'" '.$selected.' >'.$oneteh["un_name"].'</option>';
			}
			if($isreturn)
				return $output;
			echo $output;
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/UCsOptions';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode, $tcode, $uncode);
			//echo "safe";exit();
			echo $dataMeasles;
		}
	}
}
if(!function_exists('CrossProvince_FacilityName')){
	function CrossProvince_FacilityName($facode,$isreturn=false){
		$CI = & get_instance();
		$procode = substr($facode,0,1);
		$distcode = substr($facode,0,3);
		if($distcode == $CI -> session -> District){
			$query 		= "SELECT fac_name from facilities where facode = '$facode'";
			$resultFacs = $CI -> db -> query($query) -> row_array();
			return $resultFacs['fac_name'];
		}
		else{
        	//echo "xyz";exit();
			$filepath = 'Measles_investigation/FacilityNames';
			$url =  getSingleRegionUrl($procode);
			$dataMeasles =  getAdministrativeNames($url, $filepath, $procode, $distcode, '', '', $facode);
			//echo "safe";exit();
			if($isreturn)
			{
				return $dataMeasles;
			}
			else{
				echo $dataMeasles;
			}			
		}	
	}
}

if(!function_exists('OtherProDistrictName')){
    function OtherProDistrictName($distcode="")
    {  
        $CI=& get_instance();
        //echo 'i m here';exit();
        $_query  = "SELECT district from otherprovincedistricts where distcode = '$distcode'";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();
        
        return $rows['district'];
    }
}

if(!function_exists('getEpid_no_casesInvestigation')){
	function getEpid_no_casesInvestigation($isreturn=false,$year,$case_type,$mNumber=NULL){
		$CI = & get_instance();
		$distcode = $CI -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		$dcode=$result['epid_code'];
		$query = "SELECT max(case_number) as case_number from case_investigation_db where year='$year' AND dcode='$dcode' AND case_type='$case_type'";
		$result = $CI -> db -> query($query);        
		$result = $result -> row_array();
		// $measleNumber = str_split(sprintf('%04u', ($result['case_number'] + 1)));
		// $output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".implode("",$measleNumber);
		$caseNumber = sprintf('%04u', ($result['case_number'] + 1));
		$output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".$caseNumber;
		if($mNumber != NULL)
			$output = $caseNumber;		
		if($isreturn)
			return $output;
		echo $output;		
	}
}

//function after 10/05/2016
if(!function_exists('getCasesType')){
	function getCasesType($isreturn=false,$caseType=NULL){
		$CI = & get_instance();
		if($caseType){
			$wc = " where type_short_code='$caseType' ";
		}else{
			$wc="";
		}
		$output = "";
		$query="Select type_case_name,type_short_code from surveillance_cases_types $wc";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $onecase ) { 
			$selected = '';
			if(($caseType > 0)&&($caseType == $onecase["type_short_code"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$onecase["type_short_code"].'" '.$selected.' >'.$onecase["type_case_name"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllCaseTypes')){
	function getAllCaseTypes($isreturn=false,$caseType=NULL){
		$CI = & get_instance();
		if($caseType){
			$wc = " where short_name='$caseType' AND short_name != 'Msl'";
		}else{
			$wc=" where short_name != 'Msl'";
		}
		$output = "";
		$query="SELECT type_case_name, type_short_code, short_name from surveillance_cases_types $wc";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $onecase ) { 
			$selected = '';
			if(($caseType > 0)&&($caseType == $onecase["short_name"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$onecase["short_name"].'" '.$selected.' >'.$onecase["type_case_name"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getMeaslesCaseTypes')){
	function getMeaslesCaseTypes($isreturn=false,$caseType=NULL){
		$CI = & get_instance();
		if($caseType){
			$wc = " where short_name='$caseType' AND short_name='Msl'";
		}else{
			$wc=" where short_name='Msl'";
		}
		$output = "";
		$query="SELECT type_case_name, type_short_code, short_name from surveillance_cases_types $wc";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $onecase ) { 
			$selected = '';
			if(($caseType > 0)&&($caseType == $onecase["short_name"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$onecase["short_name"].'" '.$selected.' >'.$onecase["type_case_name"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('get_CaseRepresentation_Value')){
	function get_CaseRepresentation_Value($representationId=NULL){
		$CI = & get_instance();
		$query 	= "Select case_type_definition from case_clinical_representation where id = $representationId ";
		$resultRep = $CI -> db -> query($query);
		if($resultRep -> num_rows() >0)
		{
			return $resultRep -> row()->case_type_definition;	
		}
		return "";	
	}
}
if(!function_exists('getEpiWeeks')){
	function getEpiWeeks($year=NULL){
		$CI = & get_instance();
		$year = ($year > 0)?$year:$this -> input -> post('year');
		$query = "select max(epi_week_numb) as num from epi_weeks where year='$year'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		return $result->num;
	}
}
?>