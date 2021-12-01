<?php
//KP local
function dataEntryValidator($param){
	$CI = & get_instance();
	if($CI -> session -> utype=='Manager'){
		switch($param){
			case 1:
				break;
			case 0:
				$CI -> session -> set_flashdata('accessError','You dont have rights to access this page.');
				redirect(base_url());
				break;
			default:
				break;
		}
	}else if($CI -> session -> utype=='DEO'){
		
	}else{
		$CI -> session -> set_flashdata('accessError','You dont have rights to access this page.');
		redirect(base_url());
	}
} 
if(!function_exists('getWC')){
	function getWC(){
		$CI = & get_instance();
		$wc = "";
		switch ( $CI -> session -> UserLevel) {
			case '99' :
				$UserLevel = 99;
				$wc .= " procode = '" . $CI -> session -> Province . "' ";
				break;
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if ($CI -> session -> Province) {
					$wc .= " procode = '" . $CI -> session -> Province . "' ";
				}
				break;
			case '3' :
				$UserLevel = 3;
				if ($CI -> session -> Province && $CI -> session -> District) {
					$wc .= " procode = '" . $CI -> session -> Province . "' AND distcode = '" . $CI -> session -> District . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				if ($CI -> session -> Province && $CI -> session -> District && $CI -> session -> tcode) {
					$wc .= " procode = '" . $CI -> session -> Province . "' AND distcode = '" . $CI -> session -> District . "' AND tcode = '" . $CI -> session -> tcode . "'  ";
				}
				break;
		}
		return $wc;
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
if(!function_exists('posted_Values')){
	function posted_Values(){
		$CI = & get_instance();
		$data['year'] 		= $CI -> input -> post('report_year') ? $CI -> input -> post('report_year') : $CI -> input -> get('report_year');
		$data['month'] 		= $CI -> input -> post('report_month') ? $CI -> input -> post('report_month') : $CI -> input -> get('report_month');
		$data['epiWeek'] 	= $CI -> input -> post('epiWeek') ? $CI -> input -> post('epiWeek') : $CI -> input -> get('epiWeek');
		$data['procode']	= $CI -> session -> Province;
		$data['distcode'] 	= $CI -> input -> post('distcode') ? $CI -> input -> post('distcode') : $CI -> input -> get('distcode');
		$data['tcode'] 		= $CI -> input -> post('tcode') ? $CI -> input -> post('tcode') : $CI -> input -> get('tcode');
		$data['uncode']		= $CI -> input -> post('uncode') ? $CI -> input -> post('uncode') : $CI -> input -> get('uncode');
		$data['status']		= $CI -> input -> post('status') ? $CI -> input -> post('status') : $CI -> input -> get('status');
		$data['supervisor_type']= $CI -> input -> post('supervisor_type') ? $CI -> input -> post('supervisor_type') : $CI -> input -> get('supervisor_type');
		$data['facode'] 	= $CI -> input -> post('facode') ? $CI -> input -> post('facode') : $CI -> input -> get('facode');
		$data['fmonth'] 	= $CI -> input -> post('fmonth') ? $CI -> input -> post('fmonth') : $CI -> input -> get('fmonth');
		$data['fatype'] 	= $CI -> input -> post('fatype') ? $CI -> input -> post('fatype') : $CI -> input -> get('fatype');
		$data['datefrom'] 	= $CI -> input -> post('datefrom') ? date(("Y-m-d"),strtotime($CI -> input -> post('datefrom'))) : $CI -> input -> get('datefrom');
		$data['dateto'] 	= $CI -> input -> post('dateto') ? date(("Y-m-d"),strtotime($CI -> input -> post('dateto'))) : $CI -> input -> get('dateto');
		$data['fmonth_from']= $CI -> input -> post('fmonth_from') ? $CI -> input -> post('fmonth_from') : $CI -> input -> get('fmonth_from');
		$data['fmonth_to'] 	= $CI -> input -> post('fmonth_to') ? $CI -> input -> post('fmonth_to') : $CI -> input -> get('fmonth_to');
		$data['year']= $CI -> input -> post('year') ? $CI -> input -> post('year') : $CI -> input -> get('year');
		$data['month'] 	= $CI -> input -> post('month') ? $CI -> input -> post('month') : $CI -> input -> get('month');
		$data['typeWise'] = $CI -> input -> post('typeWise') ? $CI -> input -> post('typeWise') : $CI -> input -> get('typeWise');
		return $data;
	}
}
if(!function_exists('getEpiWeekOptions')){
	function getEpiWeekOptions($yearPassed=NULL,$week=NULL,$isreturn=false){
		$CI = & get_instance();
		$yearPassed = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d");
		$year = $yearPassed;
		$query = "SELECT max(epi_week_numb) as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		date_default_timezone_set('Asia/Karachi');
		$weekOptions='<option value="">--Select Week--</option>';
		for($i=1;$i<$result->num;$i++){//for($i=1;$i<=$result->num;$i++){
			if(! is_null($week)){
				$isSelected = (($result->num-1)==$week)?'selected="selected"':'';
			}else{
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
			}
			//$isSelected = ($result->num==$i)?'selected="selected"':'';
			$month = sprintf("%02d",($i));
			$weekOptions .= '<option '.$isSelected.' value="'.$i.'">Week '.$month.'</option>';
		}
		if($isreturn)
			return $weekOptions;
		echo $weekOptions;
		//echo $weekOptions;
	}
}
if(!function_exists('currentWeek')){
	function currentWeek($yearPassed=NULL,$isreturn=false){
		$CI = & get_instance();
		$yearPassed = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d");
		$year = $yearPassed;
		$query = "SELECT max(epi_week_numb) as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$currentWeek = $result->num;
		return sprintf("%02d",$currentWeek);
	}
}
if(!function_exists('lastWeek')){
	function lastWeek($yearPassed=NULL,$isreturn=false){
		$CI = & get_instance();
		$yearPassed = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d",strtotime("-1 week"));
		$year = $yearPassed;
		$current_year = date("Y");
		if($year == $current_year){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		}else{
			$query = "SELECT max(epi_week_numb) as num from epi_weeks where year='$year'";
		}
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$lastWeek = ($result->num);
		return sprintf("%02d",$lastWeek);
	}
}
if(!function_exists('lastWeekAccordingToCurrentDate')){
	function lastWeekAccordingToCurrentDate($yearPassed=NULL,$isreturn=false){
		$CI = & get_instance();
		$yearPassed = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d");
		$year = $yearPassed;
		$current_year = date("Y");
		if($year == $current_year){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		}else{
			$query = "SELECT max(epi_week_numb) as num from epi_weeks where year='$year'";
		}
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$lastWeekAccordingToCurrentDate = ($result->num);
		return sprintf("%02d",$lastWeekAccordingToCurrentDate);
	}
}
if(!function_exists('getEpiWeek')){
	function getEpiWeek(){
		date_default_timezone_set('Asia/Karachi');
		$year = "2014";
		$startYearMonth = date("$year-01");
		$nextYear = date('Y', strtotime('+1 year',strtotime($startYearMonth)));
		$endYearMonth = date('Y-m-d',strtotime($nextYear.'-'.'01-01'));
		$start = date('Y-m-d',strtotime('first sunday', strtotime($startYearMonth)));
		$end = date('Y-m-d',strtotime('last saturday', strtotime($endYearMonth)));
		echo $end."<br>";
		$i = 0;
		for($start;$start<$end;$start){
			echo date('d-M-y',strtotime($start))." <=> ";
			$weekEnd = date('d-M-y',strtotime("$start +6 days"));
			echo $weekEnd."<br>";
			$start = date('Y-m-d',strtotime("$start +7 days"));
			$i++;
		}
		echo $i;
		exit;
	}
}
if(!function_exists('getWC_Array')){
	function getWC_Array($procode=0,$distcode=0,$tcode=0,$alias=NULL){
		$CI = & get_instance();
		$wc = array();
		switch ($CI -> session -> UserLevel) {
			case '1' :
				# code...
				break;
			case '2' :
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "{$alias}procode = '" . $procode . "'";
					$wc[] = "{$alias}distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "{$alias}procode = '" . $procode . "'";
				}
				break;
			case '3' :
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "{$alias}procode = '" . $procode . "'";
					$wc[] = "{$alias}distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				if (($procode > 0) && ($distcode > 0) && ($tcode > 0)) {
					$wc[] = "{$alias}procode = '" . $procode . "'";
					$wc[] = "{$alias}distcode = '" . $distcode . "'";
					$wc[] = "{$alias}tcode = '" . $tcode . "'";
				}else{
					$wc[] = "{$alias}procode = '" . $CI -> session -> Province . "'";
					$wc[] = "{$alias}distcode = '" . $CI -> session -> distcode . "'";
					$wc[] = "{$alias}tcode = '" . $CI -> session -> tcode . "'";
				}
				break;
		}
		return $wc;
	}
}
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
if(!function_exists('monthname')){
	function monthname($month)
	{
		switch($month){
			case "01": return "January";
					break;
			case "02": return "February";
					break;
			case "03": return "March";
					break;
			case "04": return "April";
					break;
			case "05": return "May";
					break;
			case "06": return "June";
					break;
			case "07": return "July";
					break;
			case "08": return "August";
					break;
			case "09": return "September";
					break;
			case "10": return "October";
					break;
			case "11": return "November";
					break;
			case "12": return "December";				
		}
	}
}

if(!function_exists('get_target_vacc_name')){
	function get_target_vacc_name($vaccId)
	{
		switch($vaccId){
			case "1": return "bcg";
					break;
			case "2": return "hepb";
					break;
			case "3": return "opv0";
					break;
			case "4": return "opv1";
					break;
			case "5": return "opv2";
					break;
			case "6": return "opv3";
					break;
			case "7": return "penta1";
					break;
			case "8": return "penta2";
					break;
			case "9": return "penta3";
					break;
			case "10": return "pcv101";
					break;
			case "11": return "pcv102";
					break;
			case "12": return "pcv103";
					break;
			case "13": return "ipv1";
					break;
			case "14": return "rota1";
					break;
			case "15": return "rota2";
					break;
			case "16": return "measle1";
					break;
			case "17": return "fullyImmunized";//Fully Immunized
					break;
			case "18": return "measle2";
					break;
			case "19": return "dtp";
					break;		
			case "20": return "tcv";
					break;
			case "21": return "ipv2";
		}
	}
}

if(!function_exists('getAllYearsOptionsTill2018')){
	function getAllYearsOptionsTill2018($isreturn=false){
		$output = "";
		$years=2018;
		$output = '';
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}	
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllYearsOptions')){
	function getAllYearsOptions($isreturn=false){
		$output = "";
		$years=date('Y',strtotime("first day of previous month"));
		/* $years=date('Y'); */
		$output = '';
		/* $preyears=2010; */
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}	
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllYearsOptionsIncludingCurrent')){
	function getAllYearsOptionsIncludingCurrent($isreturn=false){		
		$output = "";
		$years=date('Y');
		$output = '';
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllYearsOptionsIncludingNext')){
	function getAllYearsOptionsIncludingNext($isreturn=false){		
		$output = "";
		$month = date('m');
		if($month > 10){
			$years =date('Y', strtotime('+1 year'));
		}else{
			$years=date('Y');
		}
		$output = '';
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getYearsOptions')){
	function getYearsOptions($isreturn=false){		
		$output = "";
		$years=date('Y',strtotime("-1 month"));
		$output = '';
		if($_SESSION["Province"]==3){
			$preyears=2016;
		}
		else{
			$preyears=2018;
		}
		$output .= '<option value="" selected="selected">--Select Year--</option>';
		for($x=$years;$x>=$preyears;$x--){
			$isSelected = (isset($_REQUEST["year"]) && $_REQUEST["year"]==$x)?'selected="selected"':'';
			if(validation_errors() != false) {
				$errorShow = set_select('year',$x); 
			}
			else {
				$errorShow = '';
			}
			$output .= '<option value="'.$x.'" '.$isSelected.' '.$errorShow.'>'.$x.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getEpiWeekYearsOptions')){
	function getEpiWeekYearsOptions($epiYear=NULL,$isreturn=false,$zero_report=false){
		$CI = & get_instance();
		$current_date = date('Y-m-d');
		if($zero_report == true)
			$epiYear = ($epiYear == NULL)?date('Y'):$epiYear;//date('Y')////,strtotime("-1 week")
		else
			$epiYear = ($epiYear == NULL)?getWeekYearAccordingToCurrentDate($current_date):$epiYear;//date('Y')////,strtotime("-1 week")
		$today = date('Y-m-d');
		$output = "";
		$query="SELECT distinct year from epi_weeks where (date_from <= '{$today}' and date_to >= '{$today}') OR date_to < '{$today}' order by year asc";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		$output .= '<option value="" selected="selected">--Select Year--</option>';
		foreach ($result1 as $oneyear) { 
			$selected = '';
			if(($epiYear > 0)&&($epiYear == $oneyear["year"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$oneyear["year"].'" '.$selected.' >'.$oneyear["year"].'</option>';
			/* if(date('Y',strtotime("-1 week")) == $oneyear["year"])
				break; */
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getWeekYearAccordingToCurrentDate')){
	function getWeekYearAccordingToCurrentDate($currentDate){
		//$currentDate = ($currentDate)?$currentDate:;
		$CI = & get_instance();
		$CI -> db -> select('year');
		$CI -> db -> where("date_from <= '{$currentDate}' and date_to >= '{$currentDate}'");
		$result = $CI -> db -> get('epi_weeks') -> row();
		return $result -> year;
	}
}
if(!function_exists('getAllMonthsOptions')){
	function getAllMonthsOptions($isreturn=false){		
		$output = "";
		//$currMon = date('m');
		
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:date('m',strtotime("first day of previous months"));//date('m') 
		$currMon = ($mnth=="13")?12:date('m',strtotime("first day of previous months"));
		$output .= '<option value="" selected="selected">--Select Month--</option>';
		if(validation_errors() != false) {
			foreach($months as $num => $monthitem){
				$month = sprintf("%02d", $num);
				$errorShow = set_select('month',$month);
				$output .= '<option value="'.$month.'" '.$errorShow.'>'.$monthitem.'</option>';
			}
		}
		else {
			$errorShow = '';
			foreach ($months as $num => $monthitem) { 
				//if($num > ($currMon-1))
				if($num > ($currMon))
				{}else{
					$isSelected = ($mnth==$num)?'selected="selected"':'';//($mnth-1)
					$month = sprintf("%02d", $num);
					$output .= '<option value="'.$month.'"  '.$errorShow.'>'.$monthitem.'</option>';								
				//	$output .= '<option value="'.$month.'" '.$isSelected.' '.$errorShow.'>'.$monthitem.'</option>';								
				}
			}
		}
		
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllMonthsOptions_aug2020')){
	function getAllMonthsOptions_aug2020($isreturn=false,$years=Null){	
		if(is_null($years) || $years==date('Y'))
			$currMon = 8;
		else
			$currMon = 12;
		$output = "";
		//$currMon = date('m');
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:date('m');
		$output .= '<option value="" selected="selected">--Select Month--</option>';
		if(validation_errors() != false) {
			foreach($months as $num => $monthitem){
				$month = sprintf("%02d", $num);
				$errorShow = set_select('month',$month); 
				$output .= '<option value="'.$month.'" '.$errorShow.'>'.$monthitem.'</option>';
			}
		}
		else {
			$errorShow = '';
			foreach ($months as $num => $monthitem) { 
				//if($num > ($currMon-1))
				if($num > ($currMon))
				{}else{ 
					$isSelected = ($mnth==$num)?'selected="selected"':'';//($mnth-1)
					$month = sprintf("%02d", $num); 
					$output .= '<option value="'.$month.'"  '.$errorShow.'>'.$monthitem.'</option>';								
				//	$output .= '<option value="'.$month.'" '.$isSelected.' '.$errorShow.'>'.$monthitem.'</option>';								
				}
			}
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllMonthsOptionsNew')){
	function getAllMonthsOptionsNew($isreturn=false,$year=null,$monthPar=NULL){		
		$output = "";
		if(!is_null($year) && $year==date('Y'))
			$currMon = date('m')-1;
		else
			$currMon = 12;
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:date('m');		
		if(validation_errors() != false) {
			foreach($months as $num => $monthitem){
				$month = sprintf("%02d", $num);
				$errorShow = set_select('month',$month);
				$output .= '<option value="'.$month.'" '.$errorShow.'>'.$monthitem.'</option>';
			}
		}
		else {
			$errorShow = '';
			foreach ($months as $num => $monthitem) { 
				if($num > ($currMon))
				{}else{
					if(!is_null($monthPar))
						$mnth = $monthPar;
					$isSelected = (($mnth)==$num)?'selected="selected"':'';
					$month = sprintf("%02d", $num);
					$output .= '<option value="'.$month.'" '.$isSelected.' '.$errorShow.'>'.$monthitem.'</option>';								
				}
			}
		}
		
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAllMonthsOptionsIncludingCurrent')){
	function getAllMonthsOptionsIncludingCurrent($isreturn=false,$listing=false){		
		$output = "";
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:date('m');
		$currMon = ($mnth=="13")?12:date('m');
		/* $currMon = date('m'); */
		//$output .= '<option value="" selected="selected">Select</option>';
		if(validation_errors() != false) {
			foreach($months as $num => $monthitem){
				$month = sprintf("%02d", $num);
				$errorShow = set_select('month',$month);
				$output .= '<option value="'.$month.'" '.$errorShow.'>'.$monthitem.'</option>';
			}
		}
		else {
			$errorShow = '';
			foreach ($months as $num => $monthitem) { 
				if($num > ($currMon))
				{}else{
					$isSelected = (($mnth)==$num && $listing==false)?'selected="selected"':'';
					$month = sprintf("%02d", $num);
					$output .= '<option value="'.$month.'" '.$isSelected.' '.$errorShow.'>'.$monthitem.'</option>';								
				}
			}
		}
		
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getDistricts_options')){
	function getDistricts_options($isreturn=false,$distcode=NULL,$allDistricts=NULL){
		$CI = & get_instance();
		if($allDistricts=="Yes"){
			$wc = "province = '".$_SESSION["Province"]."'";
		}else if($allDistricts=="No"){
			$wc = "distcode = '$distcode'";
		}
		else{
			$wc = getWC();
		}
		$wc = str_replace("procode","province",$wc);
		$output = '';
		$query="SELECT district,distcode from districts where $wc order by district asc";
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
}

if(!function_exists('getTehsils_options')){
	function getTehsils_options($isreturn=false,$tcode=NULL,$distcode=NULL){
		//echo $tcode; exit();
		$CI = & get_instance();
		if($distcode){
			$wc = "distcode = '$distcode'";
		}else{
			$wc = getWC();
		}		
		$output = '<option value="0" >-- Select Tehsil--</option>';
		$query="SELECT tehsil,tcode from tehsil where $wc order by tcode";
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
}
if(!function_exists('getVillage_options')){
	function getVillage_options($isreturn=false,$vcode=NULL,$uncode=NULL){
		$CI = & get_instance();
		/* if($distcode){
			$wc = "distcode = '$distcode'";
		}else{
			$wc = getWC();
		} */		
		$output = '<option value="0" >-- Select Village--</option>';
		$query="SELECT village,vcode from villages where uncode= '$uncode' order by uncode";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $oneteh) { 
			$selected = '';
			if(($uncode > 0)&&($vcode == $oneteh["vcode"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$oneteh["vcode"].'" '.$selected.' >'.$oneteh["village"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getFacilities_options')){
	function getFacilities_options($isreturn=false,$facode=NULL,$uncode=NULL,$module=NULL,$resultset = array()){
		$CI = & get_instance();
		$output = '<option value="" >--Select Facility--</option>';
		if(empty($resultset)){
			$wc = getWC();
			switch ($module) {
				case 'vaccine':
					$fmonth = date('Y-m', strtotime('first day of previous month'));
					$wc .= " AND getfstatus_vacc('$fmonth',facode::text)='F' ";
					break;
				case 'disease_surveillance':
					# code...
					break;
				default:
					# code...
					break;
			}
			$query="SELECT fac_name,facode from facilities where $wc and hf_type='e' order by facode";
			if($uncode != NULL)
				$query="SELECT fac_name,facode from facilities where uncode='$uncode' and hf_type='e' order by facode";
			$result = $CI -> db ->query($query);
			$result1 = $result->result_array();
		}else{
			$result1 = $resultset;
		}
		foreach ($result1 as $oneteh) { 
			$selected = '';
			if(($facode > 0)&&($facode == $oneteh["facode"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$oneteh["facode"].'" '.$selected.' >'.$oneteh["fac_name"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getEpid_no')){
	function getEpid_no($isreturn=false,$year,$mNumber=NULL){
		$CI = & get_instance();
		$distcode = $CI -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		$dcode=$result['epid_code'];
		$query = "SELECT max(measles_number) as measles_number from measle_case_investigation where year='$year' AND dcode='$dcode'";
		$result = $CI -> db -> query($query);        
		$result = $result -> row_array();
		$measleNumber = str_split(sprintf('%04u', ($result['measles_number'] + 1)));
		$output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/Msl/".implode("",$measleNumber);
		if($mNumber != NULL)
			$output = implode("",$measleNumber);
		
		if($isreturn)
			return $output;
		echo $output;		
	}
}
if(!function_exists('getEpid_no_coronavirusInvestigation')){
	function getEpid_no_coronavirusInvestigation($isreturn=false,$year,$case_type,$mNumber=NULL){
		$CI = & get_instance();
		$distcode = $CI -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		$dcode=$result['epid_code'];
		$query = "SELECT max(case_number) as case_number from corona_case_investigation_form_db where year='$year' AND dcode='$dcode' AND case_type='$case_type'";
		$result = $CI -> db -> query($query);        
		$result = $result -> row_array();
		// $measleNumber = str_split(sprintf('%04u', ($result['case_number'] + 1)));
		// $output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".implode("",$measleNumber);
		$caseNumber = sprintf('%06u', ($result['case_number'] + 1));
		$output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".$caseNumber;
		if($mNumber != NULL)
			$output = $caseNumber;		
		if($isreturn)
			return $output;
		echo $output;		
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
if(!function_exists('getEpid_no_afp')){
	function getEpid_no_afp($isreturn=false,$year,$mNumber=NULL){
		$CI = & get_instance();
		$distcode = $CI -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		$dcode=$result['epid_code'];
		$query = "SELECT max(afp_number) as measles_number from afp_case_investigation where year='$year' AND dcode='$dcode'";
		$result = $CI -> db -> query($query);        
		$result = $result -> row_array();
		$measleNumber = str_split(sprintf('%04u', ($result['measles_number'] + 1)));
		$output = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".implode("",$measleNumber);
		if($mNumber != NULL)
			$output = implode("",$measleNumber);
		
		if($isreturn)
			return $output;
		echo $output;		
	}
}
if(!function_exists('getFLCF_options')){
	function getFLCF_options($isreturn=false,$facode=NULL){
		
		$CI = & get_instance();
		$wc = getWC();
		$output = '<option value="" >-- Select Health Facility--</option>';
		$query="SELECT fac_name, facode from facilities where $wc order by fac_name";
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
if(!function_exists('getUCs_options')){
	function getUCs_options($isreturn=false,$uncode=NULL, $tcode=NULL){
		
		$CI = & get_instance();
		if($tcode){
			$wc = "tcode = '$tcode'";
		}else{
			$wc = getWC();
		}
		//$wc = getWC();
		$output = '<option value="" >-- Select Unioncouncil--</option>';
		$query="SELECT un_name,uncode from unioncouncil where $wc order by uncode";
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
}
if(!function_exists('getred_rec_village_options')){
	function getred_rec_village_options($session_type=NULL,$uncode=NULL,$area_name=NULL){
		$CI = & get_instance();
		$wc = getWC();
		//print_r($uncode);
		$output = '<option value="" >-- Select --</option>';
		$query="SELECT CASE WHEN session_type = 'Fixed' THEN sitename_s ELSE area_code END AS code,session_type FROM hf_quarterplan_dates_db 
				  WHERE $wc and  session_type = '$session_type' and uncode='$uncode' order by sitename_s ASC ";
		//print_r($query);
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
	
		foreach ($result1 as $rv_data) { 
			$selected = '';
			if(isset($area_name) && ($area_name == $rv_data["code"]))
			{
				$selected = 'selected="selected"';
			}
			if($rv_data['session_type']=='Fixed'){
				$output .= '<option value="' . $rv_data['code'] . '" '.$selected.' >' . get_Facility_Name($rv_data['code']) . '</option>';
			}else
					
			    $output .= '<option value="' . $rv_data['code'] . '" '.$selected.' >' . get_Village_Name($rv_data['code']) . '</option>';
		}
		//print_r($output); exit;
		echo $output;
		
	}
}
if(!function_exists('getDistricts')){
	function getDistricts($isreturn=false,$distcode=NULL){
		$CI = & get_instance();
		$wc = getWC();
		$wc = str_replace("procode","province",$wc);
		$output = "";
		//$District = $CI -> session -> District;
		$query="SELECT district,distcode from districts where $wc order by district";
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
}
if(!function_exists('getTehsils')){
	function getTehsils($isreturn=false,$tcode=NULL){
		$CI = & get_instance();
		$wc = getWC();
		$output = "";
		$query="SELECT tehsil,tcode from tehsil where $wc order by tcode";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $oneteh ) {
			if(validation_errors() != false){
				$errorshow = set_select('tcode',$oneteh["tcode"]);
				$output .='<option value="'.$oneteh["tcode"].'"'.$errorshow.'>'.$oneteh["tehsil"].'</option>';
			} 
			else { 
			$selected = '';
			if(($tcode > 0)&&($tcode == $oneteh["tcode"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$oneteh["tcode"].'" '.$selected.' >'.$oneteh["tehsil"].'</option>';
		}
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}

if(!function_exists('getUCs')){
	function getUCs($isreturn=false,$uncode=NULL,$tcode=NULL){
		$CI = & get_instance();
		if($tcode){
			$wc = "tcode = '$tcode'";
		}else{
			$wc = getWC();
		}
		$output = "";
		$query="SELECT un_name,uncode from unioncouncil where $wc order by uncode";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		$output = '<option value="0" >-- Select Unioncouncil--</option>';
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
}
if(!function_exists('getUcsforTehsil')){
	function getUcsforTehsil($distcode=NULL,$tcode=NULL){
		error_reporting(E_ALL);
		$CI = & get_instance();
		$wc = array();
		if($distcode)
		{
			$wc["distcode"]=$distcode;
		}
		if($tcode)
		{
			$wc["tcode"]=$tcode;
		}
		$CI -> db ->select("un_name,uncode");
		$CI -> db ->from("unioncouncil");
		$CI -> db ->where($wc);
		$CI -> db ->order_by("uncode");
		$result = $CI -> db ->get();
		//$result = $CI -> db ->query("Select facode,fac_name from facilities join facilities_types types on types.fatype = facilities.fatype where $wc");
		return $result->result_array();
	}
}
if(!function_exists('get_resultArray')){
	function get_resultArray($pram,$wc){
		$CI = & get_instance();
		if($pram == 'district'){
			$query 		= "SELECT distcode, district from districts " . ((!empty($wc)) ? ' where ' . implode(" AND ", $wc) : '') . " order by district";
			$resultDist = $CI -> db -> query($query);
			return $resultDist -> result_array();
		}
		if($pram == 'flcf'){
			$query = "SELECT facode, fac_name from facilities where  hf_type='e' " . (!empty($wc) ? ' AND ' . implode(" AND ", $wc) : '') . " order by fac_name";
			$resultFac = $CI -> db -> query($query);
			return $resultFac -> result_array();
		}		
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
if(!function_exists('getProvinces_options')){
	function getProvinces_options($isreturn=false, $procode=NULL, $allProvinces=NULL){
		$CI = & get_instance();		
		$output = '';
		$output .= '<option value="">-- Select Province --</option>';
		$query="SELECT province, procode from provinces order by procode asc";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $onepro) { 
			if($procode == $onepro["procode"]){
					$selected = 'selected';
			}else{
					$selected = 'yo';
			}
			
			$output .= '<option value="'.$onepro["procode"].'" '.$selected.' >'.$onepro["province"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('get_Indicator_Name')){
	function get_Indicator_Name($ind_id){
		$CI = & get_instance();
		//$query 		= "SELECT ind_name from indicator_main where indmain = '$ind_id' " ;
		$query 	   = "SELECT ind_name from indcat where indid = '$ind_id' ";
		$resultInd = $CI -> db -> query($query) -> row();
		return isset($resultInd->ind_name)?$resultInd->ind_name:'';	
	}
}
if(!function_exists('get_Province_Name')){
	function get_Province_Name($procode){
		$CI = & get_instance();
		$query 	   = "SELECT province from provinces where procode = '$procode' " ;
		$resultPro = $CI -> db -> query($query);
		return $resultPro -> row()->province;	
	}
}
if(!function_exists('get_Province_ShortName')){
	function get_Province_ShortName($procode){
		$CI = & get_instance();
		$query 	   = "SELECT shortname from provinces where procode = '$procode' " ;
		$resultPro = $CI -> db -> query($query);
		return $resultPro -> row()->shortname;	
	}
}
if(!function_exists('get_CaseType_Name')){
	function get_CaseType_Name($caseCode){
		$CI = & get_instance();
		$query 	= "SELECT type_case_name from surveillance_cases_types where short_name = '$caseCode' ";
		$resultCase = $CI -> db -> query($query);
		return $resultCase -> row()->type_case_name;	
	}
}
if(!function_exists('get_District_Name')){
	function get_District_Name($distcode){
		$CI = & get_instance();
		$query 		= "SELECT district from districts where distcode = '$distcode' " ;
		$resultDist = $CI -> db -> query($query);	
		if($resultDist -> num_rows() >0)
		{
			return $resultDist -> row()->district;	
		}
		return "";	
	}
}
if(!function_exists('get_Tehsil_Name')){
	function get_Tehsil_Name($tcode){
		$CI = & get_instance();
		$query 		= "SELECT tehsil from tehsil where tcode = '$tcode'";
		$resultTeh = $CI -> db -> query($query) -> row_array();
		return $resultTeh['tehsil'];
	}
}

if(!function_exists('get_UC_Name')){
	function get_UC_Name($uncode){
		$CI = & get_instance();
		$query 		= "SELECT un_name from unioncouncil where uncode = '$uncode'";
		$resultUC = $CI -> db -> query($query);
		if($resultUC -> num_rows() >0)
		{
			return $resultUC -> row()->un_name;	
		}
		return "";	
	}
}
if(!function_exists('get_Facility_Name')){
	function get_Facility_Name($facode){
		$CI = & get_instance();
		$query 		= "SELECT fac_name from facilities where facode = '$facode'";
		$result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->fac_name;
		}
		return "";	
	}
}
if(!function_exists('get_mergervillage_Name')){
	function get_mergervillage_Name($merger_group_id){
		$CI = & get_instance();
		$query 		= "SELECT mergername from village_merger where merger_group_id='$merger_group_id'";
		$resultUC = $CI -> db -> query($query);
		if($resultUC -> num_rows() >0)
		{
			return $resultUC -> row()->mergername;	
		}
		return "";	
	}
}
if(!function_exists('get_warehouse_Name')){
	function get_warehouse_Name($warehouse_id){
		$CI = & get_instance();
		$query 		= "SELECT warehouse_name from epi_cc_warehouse where pk_id = '$warehouse_id'";
	    $result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->warehouse_name;
		}
		return "";	
	}
}
if(!function_exists('get_supervisor_Name')){
	function get_supervisor_Name($supervisorcode){
		$CI = & get_instance();
		$query 		= "SELECT supervisorname from supervisordb where supervisorcode = '$supervisorcode'";
	    $result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->supervisorname;
		}
		return "";	
	}
}
if(!function_exists('get_supervisor_Name_hr_db')){
	function get_supervisor_Name_hr_db($supervisorcode){
		$CI = & get_instance();
		$query 		= "SELECT name from hr_db where hr_type_id = '2' and code = '$supervisorcode' ";
	    $result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->name; 
		}
		return "";	
	}
}
if(!function_exists('get_supervisor_Name_hr_desig')){
	function get_supervisor_Name_hr_desig($supervisorcode){
		$CI = & get_instance();
		$query 		= "SELECT description from hr_sub_types where type_id = '$supervisorcode'  ";
	    $result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->description; 
		}
		return "";	
	}
}
if(!function_exists('get_asset_Name')){
	function get_asset_Name($asset_id){
		$CI = & get_instance();
		$query 		= "SELECT asset_type_name from epi_cc_asset_types where pk_id = '$asset_id'";
	    $result = $CI -> db -> query($query);
		if($result -> num_rows() >0)
		{
			return $result -> row()->asset_type_name;
		}
		return "";	
	}
}
if(!function_exists('get_asset_parent_name')){
	function get_asset_parent_name($parent_id){
		$CI = & get_instance();
		$query     = "SELECT asset_type_name from epi_cc_asset_types where pk_id = '$parent_id'";
		$result = $CI->db->query($query);
		if($result->num_rows()>0)
		{
			return $result -> row()->asset_type_name;
		}
		return "";
	}
	
}
if(!function_exists('WC_replacement')){
	function WC_replacement($wc){
		$CI = & get_instance();
		$newWC = $wc;
		$newWC1= $wc;
		$replacements = array(0 => "province");
		$newWC[0]  = str_replace("procode", "province", $newWC[0]);
		$newWC1[0] = str_replace("procode", "province", $newWC1[0]);
		if ($CI -> input -> post('distcode')) {
			//unset($newWC1[1]);
		}
		return array($newWC,$newWC1);
	}
}
if (!function_exists('validateAdvanceMonthYearSelection')) {
	function validateAdvanceMonthYearSelection($month, $year) {
		date_default_timezone_set('Asia/Karachi');
		$currentMon = date('m', strtotime('last month')); 
		$currentYear = date('Y');

		if (($year >= $currentYear && $month > $currentMon) || $year > $currentYear) {
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Advance Month/Year Report cannot be added");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
	}

}
if (!function_exists('validateAlreadyInsertedRecord')) {
	function validateAlreadyInsertedRecord($table, $whereClause, $fweekORfmonth) {
		$CI = &get_instance();
		$checkquery = "SELECT count(*) as cnt from $table where $whereClause and $fweekORfmonth";
		//echo $checkquery;exit();
		$checkresult = $CI -> db -> query($checkquery);
		$checkrow = $checkresult -> row_array();
		$recexist = (int)$checkrow['cnt'];
		if ($recexist >= 1) {
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Report already exist for Selected Year and Month/Week....");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
	}

}
// function RetirementDate($date_of_birth="",$table="")
// {  
// 	$CI=& get_instance();
// 	//echo 'i m here';exit();
// 	$_query  = 'SELECT '.$date_of_birth.' from '.$table.'';
// 	$results=$CI->db->query($_query);
// 	$rows=$results->row_array();
// 	$dob = $rows['date_of_birth'];
// 	$dob_ex = explode("-",$dob);
// 	$age_diff = date_diff(date_create($dob), date_create('today'))->y;
// 	$year_of_retire = 50 - $age_diff;
// 	$end = date('Y', strtotime('+'.$year_of_retire.'years'));
// 	$date_of_retire = $end."-".$dob_ex[1]."-".$dob_ex[2];
// 	$data['retiredate'] = $date_of_retire;
    
//    return $date_of_retire;
// }
function str_insert($str, $search, $insert) {
	$index = strpos($str, $search);
	if($index === false) {
		return $str;
	}
	return substr_replace($str, $search.$insert, $index, strlen($search));
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
		$query="SELECT type_case_name,type_short_code from surveillance_cases_types $wc";
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
		$pcode = $CI -> session -> Province;
		if($pcode == '4'){
			$active = "and active=1 ";
		}
		else{
			$active = "";
		}
		if($caseType){
			$wc = " where short_name='$caseType' AND short_name != 'Msl' $active";
		}else{
			$wc=" where short_name != 'Msl' $active";
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

if(!function_exists('getCoronaCaseTypes')){
	function getCoronaCaseTypes($isreturn=false,$caseType=NULL){
		$CI = & get_instance();
		if($caseType){
			$wc = " where short_name='$caseType' AND short_name='Covid'";
		}else{
			$wc=" where short_name='Covid'";
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
		$query 	= "SELECT case_type_definition from case_clinical_representation where id = $representationId ";
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
		$query = "SELECT max(epi_week_numb) as num from epi_weeks where year='$year'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		return $result->num;
	}
}
if(!function_exists('getVaccines_options')){
	function getVaccines_options($isreturn=false,$activity=1,$returndata = FALSE,$catin=array(),$selected=NULL){
		$CI = & get_instance();
		$output = "";
		$CI -> db -> select("eips.pk_id as itemid,eips.item_id,epi_items.list_order as rank,item_name");
		$whereCondition['eips.activity_type_id'] = $activity;
		$whereCondition['eips.status'] = 1;
		$CI -> db -> where($whereCondition);
		if(is_array($catin) && count($catin)>0){
			$CI->db->where_in('eips.item_category_id', $catin);
		}
		$CI -> db -> from("epi_item_pack_sizes eips");
		$CI -> db -> join("epi_items","eips.item_id = epi_items.pk_id","LEFT OUTER");
        $CI -> db -> order_by('epi_items.list_order');
		$result1 = $CI -> db -> get() -> result_array();
		if($returndata)
			return $result1;
		//echo $selected;exit;
		foreach ($result1 as $vaccines) { 
			$isSelected = (isset($selected) && $selected==$vaccines["itemid"])?'selected="selected"':'';
			$vaccname = trim($vaccines["item_name"]);
			$output .= '<option value="'.$vaccines["itemid"].'" '.$isSelected.' >'.$vaccname.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getVaccines_name')){
	function getVaccines_name($vaccine){
		$CI = & get_instance();
		$query 		= "SELECT item_name from epi_item_pack_sizes where pk_id = '$vaccine'";
		$resultVaccine = $CI -> db -> query($query);
		return $resultVaccine -> row()->item_name;	
	}
}
/*Fucntion for getting form_b_cr table column "cr_table_row_numb" on base of pk_id */
if(!function_exists('getForm_b_cr_column')){
	function getForm_b_cr_column($vaccine){
		$CI = & get_instance();
		$query 		= "SELECT cr_table_row_numb from epi_item_pack_sizes where pk_id = '$vaccine'";
		$resultVaccine = $CI -> db -> query($query);
		return $resultVaccine -> row()->cr_table_row_numb;	
	}
}
if(!function_exists('extract_indicator_query')){
	function extract_indicator_query($arrayData, $fmonth, $level, $distcode,$report_table=NULL, $whereData=NULL){
		$tominus = " ";
		$month = NULL;
		$posted_data = $whereData;
		if(isset($whereData['distcode']))
			unset($whereData['distcode']);
		if(isset($whereData['month'])){
			$month = $whereData['month'];
			unset($whereData['month']);
		}
		$indicatorID=$whereData['indicator'];
		unset($whereData['year']);
		unset($whereData['indicator']);
		unset($whereData['vacc_ind']);
		//print_r($whereData);exit;
		$whereNew = array();
		foreach($whereData as $key => $val){
			$whereNew[] = $key. " = " . "'".$val."'";
		}
		//print_r($arrayData);exit;
		$formula        = $arrayData[0]["formula"];
		$ind_name       = $arrayData[0]["ind_name"];
		$num_text       = $arrayData[0]["numerator"];
		$den_text       = $arrayData[0]["denominator"];
		$multiple       = $arrayData[0]["multiple"];
		$ind_type       = $arrayData[0]["ind_type"];
		$is_inverse     = $arrayData[0]["is_inverse"];
		$result_text    = $arrayData[0]["result_text"];
		$description    = $arrayData[0]["description"];
		$rel_report     = $arrayData[0]["rel_report"];

		if(strlen($fmonth) < 10)
		{
			$yearMonth = explode("-",$fmonth);
			$year = $yearMonth[0];
			//$month = $yearMonth[1];
			//echo $month;exit();
			if(isset($yearMonth[1]) && ($yearMonth[1] != "" || $yearMonth[1] != 0)){
				if($indicatorID > 30 && $indicatorID <= 40)
				{
					$whereFmonth = " datefrom::text like '$fmonth-%'";
				}
				else{
					$whereFmonth = " fmonth = '$fmonth' ";
				}				
			}
			else{
				if($indicatorID > 30 && $indicatorID <= 40){
					$whereFmonth = " datefrom::text like '$year-%'";
				}
				else{
					$whereFmonth = " fmonth like '$year-%' ";
				}				
			}
		}
		else
		{
			$year ='2017';
			$whereFmonth = $fmonth;
		}		
		$CI = & get_instance();
		$den_array=array(
			"getmonthlynewborn_targetpopulation(facode,'')::numeric",
			"getyearlynewborn_targetpopulation(facode,'')::numeric",
			"getmonthlynewborn_targetpopulation(distcode,'')::numeric",
			"getyearlynewborn_targetpopulation(distcode,'')::numeric",
			"getmonthly_survivinginfants(facode,'facility')::numeric",
			"getsurvivinginfants(facode,'facility')::numeric",
			"getmonthly_survivinginfants(distcode,'district')::numeric",
			"getsurvivinginfants(distcode,'district')::numeric",
			"getmonthly_plwomen_target(facode,'')::numeric",
			"getyearly_plwomen_target(facode,'')::numeric",
			"getmonthly_plwomen_target(distcode,'')::numeric",
			"getyearly_plwomen_target(distcode,'')::numeric"
		);

		$table="";
		if($level=="district"){
			$hcode="distcode";
			$table=$report_table;
			$hname="districtname(distcode)";
		}
		if($level=="facility"){
			$hcode="facode";
			$table=$report_table;
			$hname="facilityname(facode)";
		}
		if($level=="unioncouncil"){
			$hcode="uncode";
			$table=$report_table;
			$hname="unname(uncode)";
		}
		if($rel_report != 3){ 
			if($is_inverse=="1")
			{				
				$orderType = "Asc";				
			}
			else
			{
				$orderType = "Desc";
			}
		}
		if($rel_report == 3){ 
			if($is_inverse=="1")
			{				
				$orderType = "Desc";				
			}
			else
			{
				$orderType = "Asc";
			}
		}
		$vacc_ind = (isset($posted_data['vacc_ind'])) ? $posted_data['vacc_ind'] : FALSE;
		if( ! ($vacc_ind == 'all_vacc'))
		{
			if($posted_data['indicator'] == '53' && $posted_data['vacc_ind']) {
				$formula = getClosedVialsWastageRate($posted_data['vacc_ind']);
				$tominus = " ";
			}
			if($posted_data['indicator'] == '54' && $posted_data['vacc_ind']) {
				$formula = getOpenedVialsWastageRate($posted_data['vacc_ind']);
				$tominus = " ";
			}
			if($posted_data['indicator'] == '55' && $posted_data['vacc_ind']) {
				$formula = getVaccineWastageRate($posted_data['vacc_ind']);
				$tominus = " 100 - ";
			}
			
			$divstr=explode("/",$formula);
			$num=$divstr[0];
			$den=$divstr[1];
			$num = str_replace("-::-","/",$num);
			$den = str_replace("-::-","/",$den);
			$num = getNominator($num); 
			$divnumfields=explode("+",$num);
			
			for($i=0;$i<count($divnumfields);$i++){
				if($indicatorID > 30 && $indicatorID <= 40){					
				}
				else{
					$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
				}
			}  
			$numerator=implode("+",$divnumfields);
			if(strlen($fmonth) < 10)
			{
				$den = getDenominator($den,$year,$month);//$year will be sent once year functionality is implemented.
			}
			//print_r($den);exit;
			$divnumfields=explode("+",$den);
			for($i=0;$i<count($divnumfields);$i++){
				if($indicatorID > 30 && $indicatorID <= 40){					
				}
				else{
					if(in_array($den, $den_array)){
						$divnumfields[$i]= "coalesce(".$divnumfields[$i].",0)";
					}else{
						$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
					}
				}				
			}   
			$denominator=implode("+",$divnumfields);
			
			if($den!=""){
				$mul="*$multiple";
			}
			//echo $indicatorID;exit();
			if($indicatorID == 31){
				$caseType = " AND case_type='Msl' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 35){
				$caseType = " AND case_type='Pert' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 36){
				$caseType = " AND case_type='Diph' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 37){
				$caseType = " AND case_type='HepB<5' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 38){
				$caseType = " AND case_type='ChTB' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 39){
				$caseType = " AND case_type='AWD/Chol<5' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID == 40){
				$caseType = " AND case_type='SARI' AND $hcode is not null AND $hcode <> '' ";
			}
			elseif($indicatorID > 31 && $indicatorID < 35){
				$caseType = " AND $hcode is not null AND $hcode <> '' ";
			}
			else{
				$caseType = "";
			}
			$wc="";
			$wc.=(($level=="facility" || $level=="unioncouncil")?"and distcode='$distcode'":"");
			
			$qformula=($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul");
			$extratedquery="SELECT $hcode, $hname, round(($denominator::numeric)) as \"$den_text\", ($numerator::numeric) as \"$num_text\", $tominus round(coalesce($qformula,0)::numeric,2) as \"$result_text\", '$ind_type' as unit from $table where $whereFmonth $wc ".(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." $caseType group by $hcode order by $hname $orderType";
			//exit();
			/*if(in_array($denominator, $den_array)){
				$tformula=($denominator==""?"sum(\"$num_text\")":"((sum(\"$num_text\"))::numeric//(\"$den_text\")::numeric)$mul");
			}else{*/
			$tformula=($denominator==""?"sum(\"$num_text\")":"((sum(\"$num_text\"))::numeric//(sum(\"$den_text\"))::numeric)$mul");
			//exit();
			/*}*/
			$extratedqueryTotal="SELECT sum(\"$den_text\") as totalDeNum, sum(\"$num_text\") as totalNum, round(coalesce($tformula,0)::numeric,2) as totalAll, '$ind_type' as totalUnit from ($extratedquery) as a";
			//exit();
		}
		//For All Vaccines
		else
		{
			$str1 = "";
			$str2 = "";
			$sum = "";
			$vac_array = array('1' => 'BCG', '2' => 'DIL BCG','3' => 'bOPV','4' => 'Pentavalent','5' => 'Pneumococcal(PCV10)','6' => 'Measles','7' => 'DIL Measles','8' => 'TT 10','9' => 'TT 20','10' => 'HBV (Birth dose)','11' => 'IPV','12' => 'AD Syringes 0.5 ml','13' => 'AD Syringes 0.05 ml','14' => 'Recon.Syringes (2 ml)','15' => 'Recon. Syringes (5 ml)','16' => 'Safety Boxes','17' => 'Other');
			for($j=1; $j<=17; $j++)
			{
				if($posted_data['indicator'] == '53' && $posted_data['vacc_ind']) {
					$formula = getClosedVialsWastageRate("cr_r{$j}_f6");
					$tominus = " ";
					$rate = "Closed Vial";
				}
				if($posted_data['indicator'] == '54' && $posted_data['vacc_ind']) {
					$formula = getOpenedVialsWastageRate("cr_r{$j}_f6");
					$tominus = " ";
					$rate = "Opened Vial";
				}
				if($posted_data['indicator'] == '55' && $posted_data['vacc_ind']) {
					$formula = getVaccineWastageRate("cr_r{$j}_f6");
					$tominus = " 100 - ";
					$rate = "Vaccine";
				}
				
				$divstr=explode("/",$formula);
				$num=$divstr[0];
				$den=$divstr[1];
				$num = str_replace("-::-","/",$num);
				$den = str_replace("-::-","/",$den);
				$num = getNominator($num); 
				$divnumfields=explode("+",$num);
				for($i=0;$i<count($divnumfields);$i++){
					$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
				}   
				$numerator=implode("+",$divnumfields);
				if(strlen($fmonth) < 10)
				{
					$den = getDenominator($den,$year,$month);//$year will be sent once year functionality is implemented.
				}
				$divnumfields=explode("+",$den);
				for($i=0;$i<count($divnumfields);$i++){
					if(in_array($den, $den_array)){
						$divnumfields[$i]= "coalesce(".$divnumfields[$i].",0)";
					}else{
						$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
					}
				}   
				if($den!="")
				{
					$mul="*$multiple";
				}
				$denominator=implode("+",$divnumfields);
				$result_text = $vac_array[$j];
				$qformula =($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul");

				$str1 .= "$tominus round(coalesce($qformula,0)::numeric,2) as \"$result_text\",";
				$str2 .= "$tominus round(coalesce($qformula,0)::numeric,2) as \"$result_text\", $numerator::numeric AS num{$j}, $denominator::numeric as denum{$j},";
				$sum .= " round( coalesce(sum(num{$j})/NULLIF(sum(denum{$j}),0), 0) * 100 , 2) AS  \"Total $result_text\",";
			}

			$str1 = rtrim($str1, ',');
			$str2 = rtrim($str2, ',');
			$sum = rtrim($sum, ',');
			$wc =(($level=="facility" || $level=="unioncouncil")?"and distcode='$distcode'":"");
			$part = ", '$ind_type' as unit from $table where $whereFmonth $wc ".(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." group by $hcode order by \"$result_text\" $orderType";
			$extratedquery="select $hcode, $hname, $str1 $part";
			$qfortotal="select $hcode, $hname, $str2 $part";
			//echo $extratedquery;exit;

			$description = $rate;
			$extratedqueryTotal = "SELECT $sum, '$ind_type' as unit FROM ($qfortotal) AS b";
		}
		//print_r($extratedqueryTotal);exit;
		return $extratedquery.'-::-'.$extratedqueryTotal.'-::-'.$description;
	}
}

if(!function_exists('getDenominatorFromTo')){
	function getDenominatorFromTo($den,$yearfrom=NULL,$monthfrom=NULL,$uncodeForUCsMaps=NULL,$monthto=NULL,$yearto=NULL){
		//print_r($_POST);exit();
		$CI = & get_instance();
		$m1 = (isset($m1))?$m1 :"1";
		// $monthto = ($monthto !=NULL)?$monthto :$month;
		// $yearto = ($toYear !=NULL)?$toYear :$year;
		$childhoodRoutineImmunizationArray = array('opv0','bcg','hepb');
		$survivingInfantsArray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv101','pcv102','pcv103','ipv1','rota1','rota2','measle1','measle2','fullyImmunized','dtp','tcv','ipv2');
		$TTRoutineImmunizationArray = array('tt1','tt2','tt3','tt4','tt5','live-birth');
		//print_r($den);exit;
		if(in_array($den,$childhoodRoutineImmunizationArray)){
			if ($CI -> session -> District || $CI->input->post("distcode") ) {
				if($uncodeForUCsMaps == "Yes")
					return $den = ($monthfrom)?"getmonthlytarget_specificyearr(uncode::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearr(uncode::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
					return $den = ($monthfrom)?"getmonthlytarget_specificyearr(facode::text,{$year},{$month},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearr(facode::text,{$year},01,{$yearto},{$monthto})::numeric";
			}else{
				if($CI -> input -> post("id")){
					//return $den = ($month)?"getmonthlynewborn_targetpopulation(uncode,'')::numeric":"getmonthlynewborn_targetpopulation(uncode,'')::numeric*$m1";
					//return $den = ($month)?"getmonthlynewborn_targetpopulation(distcode,'')::numeric":"getmonthlynewborn_targetpopulation(distcode,'')::numeric*$m1";
					if($monthfrom){
						$den = "getmonthlytarget_specificyearr(uncode::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric";
					}
					else{
						//$den="getmonthlynewborn_targetpopulation(uncode,'')::numeric*$m1";
						$den = "getmonthlytarget_specificyearr(uncode::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
					}
				}
				if($monthfrom){
					$den = "getmonthlytarget_specificyearr(distcode::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric";
				}
				else{
					/// for full year
					$den = "getmonthlytarget_specificyearr(distcode::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
				}
			}
		}
		
		if(in_array($den,$survivingInfantsArray)){
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				if($uncodeForUCsMaps == "Yes")
				{
					return $den = ($monthfrom)?"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
				}
				return $den = ($monthfrom)?"getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
			}else{
				if($CI -> input -> post("id")) //&& strlen($CI -> input -> post("id")) >3 will set this for fullyImmunized at uc level
				{
					return $den = ($monthfrom)?"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
				}
				return $den = ($monthfrom)?"getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
			}
		}
		if(in_array($den,$TTRoutineImmunizationArray)){
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				//return $den = ($month)?"getmonthly_plwomen_target(facode,'')::numeric":"getyearly_plwomen_target(facode,'')::numeric";
				return $den = ($monthfrom)?"getmonthly_plwomen_target_specificyears(facode::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthly_plwomen_target_specificyears(facode::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
			}else{
				return $den = ($monthfrom)?"getmonthly_plwomen_target_specificyears(distcode::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric":"getmonthly_plwomen_target_specificyears(distcode::text,{$yearfrom},01,{$yearto},{$monthto})::numeric";
			}
		}
		if(in_array($den,array('num_hf'))){
			$caseID = $CI->input->post("indicator");
			//print_r($_POST);exit();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				if (($caseID > 30 AND $caseID <= 40) || ($CI -> uri -> segment(4) > 30 AND $CI -> uri -> segment(4) <= 40)){
					return $den = "getfacility_count(uncode,'unioncouncil')::numeric";
				}
				else{
					return $den = "getfacility_count(facode,'facility')::numeric";
				}
			}
			else{
				return $den = "getfacility_count(distcode,'district')::numeric";
			}
		}
		return $den;
	}
}

if(!function_exists('getDenominator')){
	function getDenominator($den,$year=NULL,$month=NULL,$uncodeForUCsMaps=NULL,$monthto=NULL){
		//print_r($_POST);exit();
		$CI = & get_instance();
		$m1 = (isset($m1))?$m1 :"1";
		$monthto = ($monthto !=NULL)?$monthto :$month; 
		$childhoodRoutineImmunizationArray = array('opv0','bcg','hepb');
		$survivingInfantsArray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv101','pcv102','pcv103','ipv','rota1','rota2','measle1','measle2','fullyImmunized');
		$TTRoutineImmunizationArray = array('tt1','tt2','tt3','tt4','tt5','live-birth');
		//print_r($den);exit;
		if(in_array($den,$childhoodRoutineImmunizationArray)){
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				if($uncodeForUCsMaps == "Yes")
					return $den = ($month)?"getmonthlytarget_specificyearr(uncode::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearr(uncode::text,{$year},01,{$year},{$monthto})::numeric";
				return $den = ($month)?"getmonthlytarget_specificyearr(facode::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearr(facode::text,{$year},01,{$year},{$monthto})::numeric";
			}else{
				if($CI -> input -> post("id")){
					//return $den = ($month)?"getmonthlynewborn_targetpopulation(uncode,'')::numeric":"getmonthlynewborn_targetpopulation(uncode,'')::numeric*$m1";
					//return $den = ($month)?"getmonthlynewborn_targetpopulation(distcode,'')::numeric":"getmonthlynewborn_targetpopulation(distcode,'')::numeric*$m1";
					if($month){
						$den = "getmonthlytarget_specificyearr(uncode::text,{$year},{$month},{$year},{$monthto})::numeric";
					}
					else{
						//$den="getmonthlynewborn_targetpopulation(uncode,'')::numeric*$m1";
						$den = "getmonthlytarget_specificyearr(uncode::text,{$year},01,{$year},{$monthto})::numeric";
					}
				}
				if($month){
					$den = "getmonthlytarget_specificyearr(distcode::text,{$year},{$month},{$year},{$monthto})::numeric";
				}
				else{
					/// for full year
					$den = "getmonthlytarget_specificyearr(distcode::text,{$year},01,{$year},{$monthto})::numeric";
				}
			}
		}
		
		if(in_array($den,$survivingInfantsArray)){
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				if($uncodeForUCsMaps == "Yes")
				{
					return $den = ($month)?"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$year},01,{$year},{$monthto})::numeric";
				}
				return $den = ($month)?"getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,{$year},01,{$year},{$monthto})::numeric";
			}else{
				if($CI -> input -> post("id")) //&& strlen($CI -> input -> post("id")) >3 will set this for fullyImmunized at uc level
				{
					return $den = ($month)?"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(uncode::text,'unioncouncil'::text,{$year},01,{$year},{$monthto})::numeric";
				}
				return $den = ($month)?"getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},01,{$year},{$monthto})::numeric";
			}
		}
		if(in_array($den,$TTRoutineImmunizationArray)){
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				//return $den = ($month)?"getmonthly_plwomen_target(facode,'')::numeric":"getyearly_plwomen_target(facode,'')::numeric";
				return $den = ($month)?"getmonthly_plwomen_target_specificyears(facode::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthly_plwomen_target_specificyears(facode::text,{$year},01,{$year},{$monthto})::numeric";
			}else{
				return $den = ($month)?"getmonthly_plwomen_target_specificyears(distcode::text,{$year},{$month},{$year},{$monthto})::numeric":"getmonthly_plwomen_target_specificyears(distcode::text,{$year},01,{$year},{$monthto})::numeric";
			}
		}
		if(in_array($den,array('num_hf'))){
			$caseID = $CI->input->post("indicator");
			//print_r($_POST);exit();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				if (($caseID > 30 AND $caseID <= 40) || ($CI -> uri -> segment(4) > 30 AND $CI -> uri -> segment(4) <= 40)){
					return $den = "getfacility_count(uncode,'unioncouncil')::numeric";
				}
				else{
					return $den = "getfacility_count(facode,'facility')::numeric";
				}
			}
			else{
				return $den = "getfacility_count(distcode,'district')::numeric";
			}
		}
		return $den;
	}
}

if(!function_exists('getNominator')){
	function getNominator($nom,$year=NULL,$month=NULL){
		//print_r($_POST);exit();
		$CI = & get_instance();
		if($CI -> uri -> segment(5) > 0){
			$caseYear = $CI -> uri -> segment(5);
		}
		else{
			$caseYear = $CI->input->post("year");
		}

		if($CI -> uri -> segment(6) != '' && $CI -> uri -> segment(6) != '0'){
			$caseMonth = $CI -> uri -> segment(6);
		}
		else{
			$caseMonth = $CI->input->post("month");
		}		
		if($caseMonth != '' && $caseMonth != '0'){
			//echo "abc";exit();
			$caseFMonth = $caseYear.'-'.$caseMonth.'-%';
		}
		else{
			//echo "xyz";exit();
			$caseFMonth = $caseYear.'-%';
		}
		//echo $caseFMonth;
		$stock_out_rate = array('stock_out_rate');
		$hf_reports_recieved = array('hf_reports_recieved');
		$num_hf_msl = array('num_hf_msl');
		$num_hf_aefi = array('num_hf_aefi');
		$num_hf_nnt = array('num_hf_nnt');
		$num_hf_afp = array('num_hf_afp');		
		$num_hf_pert = array('num_hf_pert');
		$num_hf_diph = array('num_hf_diph');
		$num_hf_hepBless5 = array('num_hf_hepBless5');
		$num_hf_chtb = array('num_hf_chtb');
		$num_hf_awdless5 = array('num_hf_awdless5');
		$num_hf_sari = array('num_hf_sari');
		if(in_array($nom,$stock_out_rate)){
			$CI = & get_instance();
			$col= $CI->input->post('vacc_ind');
			$nom = getStock_outRate($col);
		}
		if(in_array($nom,$hf_reports_recieved)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode")) {
				$nom = "getfacility_reports_count(facode,'facility')::numeric";
			}else{
				$nom = "getfacility_reports_count(distcode,'district')::numeric";
			}
		}
		if(in_array($nom,$num_hf_msl)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','Msl','$caseFMonth')::numeric";
			}
			else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','Msl','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_pert)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','Pert','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','Pert','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_diph)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','Diph','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','Diph','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_hepBless5)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','HepB<5','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','HepB<5','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_chtb)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','ChTB','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','ChTB','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_awdless5)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','AWD/Chol<5','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','AWD/Chol<5','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_sari)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_msl_othercases_count(facode,'facility','Msl')::numeric";
				$nom = "getfacility_msl_othercases_count(uncode,'unioncouncil','SARI','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_msl_othercases_count(distcode,'district','SARI','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_aefi)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_aefi_count(facode,'facility')::numeric";
				$nom = "getfacility_aefi_count(uncode,'unioncouncil','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_aefi_count(distcode,'district','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_nnt)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_nnt_count(facode,'facility')::numeric";
				$nom = "getfacility_nnt_count(uncode,'unioncouncil','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_nnt_count(distcode,'district','$caseFMonth')::numeric";
			}
		}
		if(in_array($nom,$num_hf_afp)){
			$CI = & get_instance();
			if ($CI -> session -> District || $CI->input->post("distcode") || $CI -> uri -> segment(3)) {
				//$nom = "getfacility_afp_count(facode,'facility')::numeric";
				$nom = "getfacility_afp_count(uncode,'unioncouncil','$caseFMonth')::numeric";
			}else{
				$nom = "getfacility_afp_count(distcode,'district','$caseFMonth')::numeric";
			}
		}
		return $nom;
	}
}
if(!function_exists('getStock_outRate')){
	function getStock_outRate($col=NULL){
		
		$CI = & get_instance();
		$wc =	getWC();
		if($CI -> input -> post('uncode')){
			$uc = $CI -> input -> post('uncode');
			$wc .= " And uncode = '" . $uc . "' ";
		}
		$year= $CI->input->post('year');
		$month= $CI->input->post('month');
		if($year && $month)
			$fmonth= " And fmonth = '" . $year."-".$month . "' ";
		else $fmonth= " And fmonth LIKE '" . $year."-%' ";
		$query = "SELECT facode from facilities where $wc";
		$query = $CI -> db -> query($query);
		$result = $query -> result_array();
		
		if($query -> num_rows() > 0)
		{
			$stock_out=0;
			foreach($result as $row){
				$facode = $row['facode'];
				   $query = "SELECT $col as ad_syringe from form_b_cr where facode='$facode' $fmonth";
				$query = $CI -> db -> query($query);
				$result = $query -> row();
				if($query -> num_rows() > 0){
					if($result->ad_syringe == '0'){
						$stock_out++;
					}
				}	
			}
			$nom = $stock_out;
		}
		return $nom;
	}
}
if(!function_exists('getClosedVialsWastageRate')){
	function getClosedVialsWastageRate($formula){
		
			if ($formula == 'cr_r1_f6') {
				//$formula = "cr_r1_f1-::-20+cr_r1_f2-::-20-cr_r1_f4-cr_r1_f5/cr_r1_f1-::-20+cr_r1_f2-::-20";
				$formula = "cr_r1_f5/cr_r1_f1-::-20+cr_r1_f2-::-20-cr_r1_f6"; 
			}
			if ($formula == 'cr_r2_f6') {
				//$formula = "cr_r2_f1+cr_r2_f2-cr_r2_f4-cr_r2_f5/cr_r2_f1+cr_r2_f2";
				$formula = "cr_r2_f5/cr_r2_f1+cr_r2_f2-cr_r2_f6";
			}
			if ($formula == 'cr_r3_f6') {
				//$formula = "cr_r3_f1-::-20+cr_r3_f2-::-20-cr_r3_f4-cr_r3_f5/cr_r3_f1-::-20+cr_r3_f2-::-20";
				$formula = "cr_r3_f5/cr_r3_f1-::-20+cr_r3_f2-::-20-cr_r3_f6";
			}
			if ($formula == 'cr_r4_f6') {
				//$formula = "cr_r4_f1+cr_r4_f2-cr_r4_f4-cr_r4_f5/cr_r4_f1+cr_r4_f2";
				$formula = "cr_r4_f5/cr_r4_f1+cr_r4_f2-cr_r4_f6";
			}
			if ($formula == 'cr_r5_f6') {
				//$formula = "cr_r5_f1-::-02+cr_r5_f2-::-02-cr_r5_f4-cr_r5_f5/cr_r5_f1-::-02+cr_r5_f2-::-02";
				$formula = "cr_r5_f5/cr_r5_f1-::-02+cr_r5_f2-::-02-cr_r5_f6";
			}
			if ($formula == 'cr_r6_f6') {
				//$formula = "cr_r6_f1-::-10+cr_r6_f2-::-10-cr_r6_f4-cr_r6_f5/cr_r6_f1-::-10+cr_r6_f2-::-10";
				$formula = "cr_r6_f5/cr_r6_f1-::-10+cr_r6_f2-::-10-cr_r6_f6";
			}
			if ($formula == 'cr_r7_f6') {
				//$formula = "cr_r7_f1+cr_r7_f2-cr_r7_f4-cr_r7_f5/cr_r7_f1+cr_r7_f2";
				$formula = "cr_r7_f5/cr_r7_f1+cr_r7_f2-cr_r7_f6";
			}
			if ($formula == 'cr_r8_f6') {
				//$formula = "cr_r8_f1-::-10+cr_r8_f2-::-10-cr_r8_f4-cr_r8_f5/cr_r8_f1-::-10+cr_r8_f2-::-10";
				$formula = "cr_r8_f5/cr_r8_f1-::-10+cr_r8_f2-::-10-cr_r8_f6";
			}
			if ($formula == 'cr_r9_f6') {
				//$formula = "cr_r9_f1-::-20+cr_r9_f2-::-20-cr_r9_f4-cr_r9_f5/cr_r9_f1-::-20+cr_r9_f2-::-20";
				$formula = "cr_r9_f5/cr_r9_f1-::-20+cr_r9_f2-::-20-cr_r9_f6";
			}
			if ($formula == 'cr_r10_f6') {
				//$formula = "cr_r10_f1-::-10+cr_r10_f2-::-10-cr_r10_f4-cr_r10_f5/cr_r10_f1-::-10+cr_r10_f2-::-10";
				$formula = "cr_r10_f5/cr_r10_f1-::-10+cr_r10_f2-::-10-cr_r10_f6";
			}
			if ($formula == 'cr_r11_f6') {
				//$formula = "cr_r11_f1-::-10+cr_r11_f2-::-10-cr_r11_f4-cr_r11_f5/cr_r11_f1-::-10+cr_r11_f2-::-10";
				$formula = "cr_r11_f5/cr_r11_f1-::-10+cr_r11_f2-::-10-cr_r11_f6";
			}
			if ($formula == 'cr_r12_f6') {
				//$formula = "cr_r12_f1+cr_r12_f2-cr_r12_f4-cr_r12_f5/cr_r12_f1+cr_r12_f2";
				$formula = "cr_r12_f5/cr_r12_f1+cr_r12_f2-cr_r12_f6";
			}
			if ($formula == 'cr_r13_f6') {
				//$formula = "cr_r13_f1+cr_r13_f2-cr_r13_f4-cr_r13_f5/cr_r13_f1+cr_r13_f2";
				$formula = "cr_r13_f5/cr_r13_f1+cr_r13_f2-cr_r13_f6";
			}
			if ($formula == 'cr_r14_f6') {
				//$formula = "cr_r14_f1+cr_r14_f2-cr_r14_f4-cr_r14_f5/cr_r14_f1+cr_r14_f2";
				$formula = "cr_r14_f5/cr_r14_f1+cr_r14_f2-cr_r14_f6";
			}
			if ($formula == 'cr_r15_f6') {
				//$formula = "cr_r15_f1+cr_r15_f2-cr_r15_f4-cr_r15_f5/cr_r15_f1+cr_r15_f2";
				$formula = "cr_r15_f5/cr_r15_f1+cr_r15_f2-cr_r15_f6";
			}
			if ($formula == 'cr_r16_f6') {
				//$formula = "cr_r16_f1+cr_r16_f2-cr_r16_f4-cr_r16_f5/cr_r16_f1+cr_r16_f2";
				$formula = "cr_r16_f5/cr_r16_f1+cr_r16_f2-cr_r16_f6";
			}
			if ($formula == 'cr_r17_f6') {
				//$formula = "cr_r17_f1+cr_r17_f2-cr_r17_f4-cr_r17_f5/cr_r17_f1+cr_r17_f2";
				$formula = "cr_r17_f5/cr_r17_f1+cr_r17_f2-cr_r17_f6";
			}
			if ($formula == 'cr_r18_f6') {
				$formula = "cr_r18_f5/cr_r18_f1+cr_r18_f2-cr_r18_f6";
			}
			if ($formula == 'cr_r19_f6') {
				$formula = "cr_r19_f5/cr_r19_f1-::-05+cr_r19_f2-::-05-cr_r19_f6";
			}
			if ($formula == 'cr_r20_f6') {
				$formula = "cr_r20_f5/cr_r20_f1-::-02+cr_r20_f2-::-02-cr_r20_f6";
			}
			if ($formula == 'cr_r21_f6') {
				$formula = "cr_r21_f5/cr_r21_f1+cr_r21_f2-cr_r21_f6";
			}
			if ($formula == 'cr_r22_f6') {
				$formula = "cr_r22_f5/cr_r22_f1+cr_r22_f2-cr_r22_f6";
			}
			if ($formula == 'cr_r23_f6') {
				$formula = "cr_r23_f5/cr_r23_f1+cr_r23_f2-cr_r23_f6";
			}
		return $formula;
	}
}

if(!function_exists('getOpenedVialsWastageRate')){
	function getOpenedVialsWastageRate($formula){
		
			if ($formula == 'cr_r1_f6') {
				$formula = "(cr_r1_f4*20)-cr_r1_f3/(cr_r1_f4*20)"; 
			}
			if ($formula == 'cr_r2_f6') {
				$formula = "cr_r2_f4-cr_r2_f3/cr_r2_f4"; 
			}
			if ($formula == 'cr_r3_f6') {
				$formula = "(cr_r3_f4*20)-cr_r3_f3/(cr_r3_f4*20)"; 
			}
			if ($formula == 'cr_r4_f6') {
				$formula = "(cr_r4_f4*1)-cr_r4_f3/(cr_r4_f4*1)"; 
			}
			if ($formula == 'cr_r5_f6') {
				$formula = "(cr_r5_f4*2)-cr_r5_f3/(cr_r5_f4*2)"; 
			}
			if ($formula == 'cr_r6_f6') {
				$formula = "(cr_r6_f4*10)-cr_r6_f3/(cr_r6_f4*10)"; 
			}
			if ($formula == 'cr_r7_f6') {
				$formula = "cr_r7_f4-cr_r7_f3/cr_r7_f4"; 
			}
			if ($formula == 'cr_r8_f6') {
				$formula = "(cr_r8_f4*10)-cr_r8_f3/(cr_r8_f4*10)"; 
			}
			if ($formula == 'cr_r9_f6') {
				$formula = "(cr_r9_f4*20)-cr_r9_f3/(cr_r9_f4*20)"; 
			}
			if ($formula == 'cr_r10_f6') {
				$formula = "(cr_r10_f4*10)-cr_r10_f3/(cr_r10_f4*10)"; 
			}
			if ($formula == 'cr_r11_f6') {
				$formula = "(cr_r11_f4*10)-cr_r11_f3/(cr_r11_f4*10)"; 
			}
			if ($formula == 'cr_r12_f6') {
				$formula = "cr_r12_f4-cr_r12_f3/cr_r12_f4"; 
			}
			if ($formula == 'cr_r13_f6') {
				$formula = "cr_r13_f4-cr_r13_f3/cr_r13_f4"; 
			}
			if ($formula == 'cr_r14_f6') {
				$formula = "cr_r14_f4-cr_r14_f3/cr_r14_f4"; 
			}
			if ($formula == 'cr_r15_f6') {
				$formula = "cr_r15_f4-cr_r15_f3/cr_r15_f4"; 
			}
			if ($formula == 'cr_r16_f6') {
				$formula = "cr_r16_f4-cr_r16_f3/cr_r16_f4"; 
			}
			if ($formula == 'cr_r17_f6') {
				$formula = "cr_r17_f4-cr_r17_f3/cr_r17_f4"; 
			}
			if ($formula == 'cr_r18_f6') {
				$formula = "cr_r18_f4-cr_r18_f3/cr_r18_f4"; 
			}
			if ($formula == 'cr_r19_f6') {
				$formula = "(cr_r19_f4*5)-cr_r19_f3/(cr_r19_f4*5)"; 
			}
			if ($formula == 'cr_r20_f6') {
				$formula = "(cr_r20_f4*2)-cr_r20_f3/(cr_r20_f4*2)"; 
			}
			if ($formula == 'cr_r21_f6') {
				$formula = "cr_r21_f4-cr_r21_f3/cr_r21_f4"; 
			}
			if ($formula == 'cr_r22_f6') {
				$formula = "cr_r22_f4-cr_r22_f3/cr_r22_f4"; 
			}
			if ($formula == 'cr_r23_f6') {
				$formula = "cr_r23_f4-cr_r23_f3/cr_r23_f4"; 
			}
		return $formula;
	}
}
if(!function_exists('getVaccineWastageRate')){
	function getVaccineWastageRate($formula){
		
			if ($formula == 'cr_r1_f6') {
				$formula = "cr_r1_f3/cr_r1_f1+cr_r1_f2-cr_r1_f6*20"; 
			}
			if ($formula == 'cr_r2_f6') {
				$formula = "cr_r2_f3/cr_r2_f1+cr_r2_f2-cr_r2_f6";  
			}
			if ($formula == 'cr_r3_f6') {
				$formula = "cr_r3_f3/cr_r3_f1+cr_r3_f2-cr_r3_f6*20"; 
			}
			if ($formula == 'cr_r4_f6') {
				$formula = "cr_r4_f3/cr_r4_f1+cr_r4_f2-cr_r4_f6"; 
			}
			if ($formula == 'cr_r5_f6') {
				$formula = "cr_r5_f3/cr_r5_f1+cr_r5_f2-cr_r5_f6*2"; 
			}
			if ($formula == 'cr_r6_f6') {
				$formula = "cr_r6_f3/cr_r6_f1+cr_r6_f2-cr_r6_f6*10"; 
			}
			if ($formula == 'cr_r7_f6') {
				$formula = "cr_r7_f3/cr_r7_f1+cr_r7_f2-cr_r7_f6"; 
			}
			if ($formula == 'cr_r8_f6') {
				$formula = "cr_r8_f3/cr_r8_f1+cr_r8_f2-cr_r8_f6*10"; 
			}
			if ($formula == 'cr_r9_f6') {
				$formula = "cr_r9_f3/cr_r9_f1+cr_r9_f2-cr_r9_f6*20"; 
			}
			if ($formula == 'cr_r10_f6') {
				$formula = "cr_r10_f3/cr_r10_f1+cr_r10_f2-cr_r10_f6*10"; 
			}
			if ($formula == 'cr_r11_f6') {
				$formula = "cr_r11_f3/cr_r11_f1+cr_r11_f2-cr_r11_f6*10"; 
			}
			if ($formula == 'cr_r12_f6') {
				$formula = "cr_r12_f3/cr_r12_f1+cr_r12_f2-cr_r12_f6"; 
			}
			if ($formula == 'cr_r13_f6') {
				$formula = "cr_r13_f3/cr_r13_f1+cr_r13_f2-cr_r13_f6"; 
			}
			if ($formula == 'cr_r14_f6') {
				$formula = "cr_r14_f3/cr_r14_f1+cr_r14_f2-cr_r14_f6"; 
			}
			if ($formula == 'cr_r15_f6') {
				$formula = "cr_r15_f3/cr_r15_f1+cr_r15_f2-cr_r15_f6"; 
			}
			if ($formula == 'cr_r16_f6') {
				$formula = "cr_r16_f3/cr_r16_f1+cr_r16_f2-cr_r16_f6"; 
			}
			if ($formula == 'cr_r17_f6') {
				$formula = "cr_r17_f3/cr_r17_f1+cr_r17_f2-cr_r17_f6"; 
			}
			if ($formula == 'cr_r18_f6') {
				$formula = "cr_r18_f3/cr_r18_f1+cr_r18_f2-cr_r18_f6"; 
			}
			if ($formula == 'cr_r19_f6') {
				$formula = "cr_r19_f3/cr_r19_f1+cr_r19_f2-cr_r19_f6*5"; 
			}
			if ($formula == 'cr_r20_f6') {
				$formula = "cr_r20_f3/cr_r20_f1+cr_r20_f2-cr_r20_f6*2"; 
			}
			if ($formula == 'cr_r21_f6') {
				$formula = "cr_r21_f3/cr_r21_f1+cr_r21_f2-cr_r21_f6"; 
			}
			if ($formula == 'cr_r22_f6') {
				$formula = "cr_r22_f3/cr_r22_f1+cr_r22_f2-cr_r22_f6"; 
			}
			if ($formula == 'cr_r23_f6') {
				$formula = "cr_r23_f3/cr_r23_f1+cr_r23_f2-cr_r23_f6"; 
			}
		return $formula;
	}
}
if(!function_exists('freezeReport')){
	function freezeReport($table,$facode,$fmonth,$ajax=NULL,$return=NULL) {
		//$currentFmonth = date("Y-m",strtotime("first day of previous month"));
		$CI = & get_instance();
		$CI -> db -> select('MAX(fmonth) as fmonth');
		$CI -> db -> where('facode',$facode);
		$result = $CI -> db -> get($table) -> row();
		if($fmonth < $result->fmonth){
			if($ajax){
				echo 1;exit;
			}
			else if($return)
			{
				return 1;
			}
			else{
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Report Freezed!You can not Update Report Now");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
			}
		}
	}
}
/* if(!function_exists('validateExistReport')){
	function validateExistReport($table,$facode,$fmonth) { 
		//echo $facode;exit;
		$CI = & get_instance();
		$mon =  explode('-',$fmonth);
		$month = $mon[1];
		$year = $mon[0];
		// echo $month;
		$edit = 1;
		if($edit == '1')
			$month = Date("m", strtotime("2017-" . $month . "-01" . " +1 month"));//$month = strtotime("+1 month", $month);
		//echo $month;exit;
		$monthPrevious = date("m", strtotime("-1 months"));
		if($table == 'form_b_cr')
			$monthPrevious = $month;
		//$table = 'fac_mvrf_db';
		$fmonthSelected   = $year."-".$month;
		$fmonthPrevious   = $year."-".$monthPrevious;
		//echo $fmonthSelected;
		//echo $fmonthPrevious;
		$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$checkquery="";
		if(isset($fmonthPrevious)){
			if($fmonthSelected == $fmonthPrevious)
				$script = "No";
				$checkquery = "SELECT count(*) as cnt from $table where facode='$facode' and fmonth BETWEEN '$fmonthSelected' and '$fmonthPrevious' and distcode ='$distcode'";
		}
		else{
				$checkquery = "SELECT count(*) as cnt from $table where facode='$facode' and fmonth = '$fmonthSelected' and distcode ='$distcode'";
		}
		//echo $checkquery;exit;
		$checkresult = $CI -> db -> query($checkquery);
		$checkrow = $checkresult -> row_array();
		//print_r($checkrow);exit;
		$recexist = (int)$checkrow['cnt'];
		//echo $recexist;exit;
		if ($recexist >= 1) {
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Report Freezed!You can not Update Report Now");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
	}
} */
if(!function_exists('getSourceSupply')){
	function getSourceSupply($id=null,$text=FALSE){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select Source of Supply</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>None</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>EPI Program</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>USAID</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Testing Stakeholder</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>CCEOP</option>
				<option value="6" '.(($id==6)?'selected="selected"':'').'>NON-CCEOP</option>
				<option value="7" '.(($id==7)?'selected="selected"':'').'>JICA</option>
				<option value="8" '.(($id==8)?'selected="selected"':'').'>UNICEF</option>
				';
		if($text){
			switch($id)
			{
				case '1' :
					$return = "None";
					break;
				case '2' :
					$return = "EPI Program";
					break;
				case '3' :
					$return = "USAID";
					break;
				case '4' :
					$return = "Testing Stakeholder";
					break;
				case '5' :
					$return = "CCEOP";
					break;
				case '6' :
					$return = "NON-CCEOP";
					break;
				case '7' :
					$return = "JICA";
					break;
				case '8' :
					$return = "UNICEF";
					break;
				default:
					$return = "";
					break;
			}
		}
		return $return;
	}
}
if(!function_exists('getUtilization')){
	 function getUtilization($id=null){
		$return='
				<option value="" '.(($id=="")?'selected="selected"':'').'>Select </option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>In use</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Not in use and available for re-allocation</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Not in use and not available for re-allocation</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>In storage</option>
				';
		return $return;
	}
}
if(!function_exists('getWorkingstatus')){
	function getWorkingstatus($id=NULL,$text=FALSE){
		$return='
				<option value="" '.(($id=="")?'selected="selected"':'').'>Select working status</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Working well</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Working but needs maintenance</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Not working</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Working well &amp; fuel available</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>Working well but fuel not available</option>
				';
		if($text){
			switch($id)
			{
				case '1' :
					$return = "Working well";
					break;
				case '2' :
					$return = "Working but needs maintenance";
					break;
				case '3' :
					$return = "Not working";
					break;
				case '4' :
					$return = "Working well & fuel available";
					break;
				case '5' :
					$return = "Working well but fuel not available";
					break;
				default:
					$return = "Pass id";
					break;
			}
		}
		return $return;
	}
}
if(!function_exists('getReasons')){
	function getReasons($id=NULL){
		$return='
				<option value="" '.(($id=="")?'selected="selected"':'').'>Select</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'> Spare parts are not available for repair/maintenance</option>
                <option value="2" '.(($id==2)?'selected="selected"':'').'> Finance is not available for repair/maintenance</option>
                <option value="3" '.(($id==3)?'selected="selected"':'').'> Not in use because electricity or fuel is not available</option>
                <option value="4" '.(($id==4)?'selected="selected"':'').'> Equipment needs to be boarded off</option>
                <option value="5" '.(($id==5)?'selected="selected"':'').'> Waiting repair technician</option>
                <option value="6" '.(($id==6)?'selected="selected"':'').'> Waiting spare parts</option>
                <option value="7" '.(($id==7)?'selected="selected"':'').'> Awaiting finances</option>
                <option value="8" '.(($id==8)?'selected="selected"':'').'> Awaiting boarding off</option>
                <option value="9" '.(($id==9)?'selected="selected"':'').'> Unknown</option>
				';
		return $return;
	}
}
if(!function_exists('getTemperatureMonitor')){
	function getTemperatureMonitor($id=NULL){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Dial Thermometer</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>FridgeTag</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>No monitoring device</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Stem Thermometer</option>
				';
		return $return;
	}
}
if(!function_exists('getBackupGenerator')){
	 function getBackupGenerator($id=null){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>NO</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Yes- automatic startup</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Yes- manual startup</option>
				';
		return $return;
	}
}
if(!function_exists('getTemperatureRecordingSystem')){
	function getTemperatureRecordingSystem($id=null){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Not Provided</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Provided, not operating</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Provided, operating</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Unknown</option>
				';
		return $return;
	}
}
if(!function_exists('getTypeRecordingSystem')){
	function getTypeRecordingSystem($id=null){
		$return='
				<option value="" '.(($id=="")?'selected="selected"':'').'>Select</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Chart recorder (clockwork)</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Chart recorder (electric)</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Computer based recorder</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Electronic data logger</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>FridgeTags</option>
				<option value="6" '.(($id==6)?'selected="selected"':'').'>Manual</option>
				<option value="7" '.(($id==7)?'selected="selected"':'').'>Thermometers only</option>
				<option value="8" '.(($id==8)?'selected="selected"':'').'>Unknown</option>
				';
		return $return;
	}
}
if(!function_exists('getAllStores')){
	function getAllStores($id=null){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select Store</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>1</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>2</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>3</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>4</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>5</option>
				<option value="6" '.(($id==6)?'selected="selected"':'').'>6</option>
				';
		return $return;
	}
}
if(!function_exists('getAllRows')){
	function getAllRows($id=null){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select Row</option>
				<option value="A" '.(($id=='A')?'selected="selected"':'').'>A</option>
				<option value="B" '.(($id=='B')?'selected="selected"':'').'>B</option>
				<option value="C" '.(($id=='C')?'selected="selected"':'').'>C</option>
				<option value="D" '.(($id=='D')?'selected="selected"':'').'>D</option>
				<option value="E" '.(($id=='E')?'selected="selected"':'').'>E</option>
				<option value="F" '.(($id=='F')?'selected="selected"':'').'>F</option>
				<option value="G" '.(($id=='G')?'selected="selected"':'').'>G</option>
				<option value="H" '.(($id=='H')?'selected="selected"':'').'>H</option>
				';
		return $return;
	}
}
if(!function_exists('getAllRacks')){
	function getAllRacks($id=null){
		$CI = & get_instance();
		$CI -> db -> select('pk_id,rack_type');
		$result = $CI -> db -> get('epi_non_ccm_rack_information') -> result_array();
		$return .= '<option value="" selected="selected">Select Rack</option>';
	    foreach($result as $key => $val){
			$return .= "<option value=\"{$val['pk_id']}\" ".(($id==$val['pk_id'])?'selected="selected"':'').">{$val['rack_type']}</option>";
		}
		return $return;
	}
}
if(!function_exists('getAllShelfs')){
	function getAllShelfs($id=null){
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select Shelf</option>
				<option value="A" '.(($id=='A')?'selected="selected"':'').'>A</option>
				<option value="B" '.(($id=='B')?'selected="selected"':'').'>B</option>
				<option value="C" '.(($id=='C')?'selected="selected"':'').'>C</option>
				<option value="D" '.(($id=='D')?'selected="selected"':'').'>D</option>
				<option value="E" '.(($id=='E')?'selected="selected"':'').'>E</option>
				<option value="F" '.(($id=='F')?'selected="selected"':'').'>F</option>
				<option value="G" '.(($id=='G')?'selected="selected"':'').'>G</option>
				<option value="H" '.(($id=='H')?'selected="selected"':'').'>H</option>
				<option value="I" '.(($id=='I')?'selected="selected"':'').'>I</option>
				';
		return $return;
	}
}
if(!function_exists('getAllBins')){
	 function getAllBins($id=null){
	 $return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>Select Bin</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>1</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>2</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>3</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>4</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>5</option>
				<option value="6" '.(($id==6)?'selected="selected"':'').'>6</option>
				<option value="7" '.(($id==7)?'selected="selected"':'').'>7</option>
				<option value="8" '.(($id==8)?'selected="selected"':'').'>8</option>
				<option value="9" '.(($id==9)?'selected="selected"':'').'>9</option>
				';
		return $return;
	}
}
if(!function_exists('getPowerSource'))
{
	 function getPowerSource($id = NULL, $text=FALSE,$asset_id=NULL)
	 {
		
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>--Select--</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Diesel</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Solar</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Petrol</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Wind</option>
				<option value="5" '.(($id==5)?'selected="selected"':'').'>Water</option>
				<option value="6" '.(($id==6)?'selected="selected"':'').'>CNG</option>
				<option value="7" '.(($id==7)?'selected="selected"':'').'>Other</option>
				';
			//Refrigerator
			if($asset_id==1)
			{
				$return=' <option  value=""  '.(($id=="")?'selected="selected"':'').'>Select</option>
    <option value="8"  value=""  '.(($id==8)?'selected="selected"':'').'>Electricity</option>
    <option value="9"  value=""  '.(($id==9)?'selected="selected"':'').'>Electricity and Kerosene</option>
    <option value="6"  value=""  '.(($id==6)?'selected="selected"':'').'>CNG</option>
    <option value="10"  value="" '.(($id==10)?'selected="selected"':'').'>Kerosene</option>
    <option value="2"  value=""  '.(($id==2)?'selected="selected"':'').'>Solar</option>';
			}
			//Generator
			if ($asset_id==24)
			{	
					$return='<option value="" '.(($id=="")?'selected="selected"':'').'>Select</option>
					<option value="1" '.(($id==1)?'selected="selected"':'').'>Diesel</option>
					<option value="11" '.(($id==11)?'selected="selected"':'').'>Not applicable</option>
					<option value="3" '.(($id==3)?'selected="selected"':'').'>Petrol</option>';
			}
			//Transport
			if ($asset_id==25)
			{	
					$return='<option value="" '.(($id=="")?'selected="selected"':'').'>Select</option>
					<option value="1" '.(($id==1)?'selected="selected"':'').'>Diesel</option>
					<option value="11" '.(($id==11)?'selected="selected"':'').'>Not applicable</option>
					<option value="3" '.(($id==3)?'selected="selected"':'').'>Petrol</option>';
			}
		if($text){
			switch($id)
			{
				case '1' :
					$return = "Diesel";
					break;
				case '2' :
					$return = "Solar";
					break;
				case '3' :
					$return = "Petrol";
					break;
				case '4' :
					$return = "Wind";
					break;
				case '5' :
					$return = "Water";
					break;
				case '6' :
					$return = "CNG";
					break;
				case '7' :
					$return = "Other";
					break;
				default:
					$return = "None";
					break;
			}
		}
		return $return;
	}
}
if(!function_exists('getTransportType'))
{
	 function getTransportType($id = NULL, $text=FALSE)
	 {
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>--Select--</option>
				<option value="1" '.(($id==28)?'selected="selected"':'').'>Motorcycle</option>
				<option value="2" '.(($id==29)?'selected="selected"':'').'>Vehicle</option>
				<option value="3" '.(($id==30)?'selected="selected"':'').'>Refrigerator Van</option>
				<option value="5" '.(($id==31)?'selected="selected"':'').'>Boat</option>
				<option value="4" '.(($id==32)?'selected="selected"':'').'>Bicycle</option>
				';
		if($text){
			switch($id)
			{
				case '28' :
					$return = "Motorcycle";
					break;
				case '29' :
					$return = "Vehicle";
					break;
				case '30' :
					$return = "Refrigerator Van";
					break;
				case '31' :
					$return = "Boat";
					break;
				case '32' :
					$return = "Bicycle";
					break;
				default:
					$return = "None";
					break;
			}
		}
		return $return;
	}
}
if(!function_exists('getUseFor'))
{
	 function getUseFor($id = NULL)
	 {
		$return='
				<option value=""  '.(($id=="")?'selected="selected"':'').'>--Select--</option>
				<option value="1" '.(($id==1)?'selected="selected"':'').'>Cold Rooms</option>
				<option value="2" '.(($id==2)?'selected="selected"':'').'>Lighting</option>
				<option value="3" '.(($id==3)?'selected="selected"':'').'>Refrigerators or freezers</option>
				<option value="4" '.(($id==4)?'selected="selected"':'').'>Unknown</option>
				';
		return $return;
	 }
}
if(!function_exists('getQuaterMonth'))
{
	 function getQuaterMonths($qtr = NULL)
	 {
		switch($qtr){
				case "01":
					$monthrange = array('monthfrom' => '01','monthto' => '03');
					break;
				case "02":
					$monthrange = array('monthfrom' => '04','monthto' => '06');
					break;
				case "03":
					$monthrange = array('monthfrom' => '07','monthto' => '09');
					break;
				case "04":
					$monthrange = array('monthfrom' => '10','monthto' => '12');
					break;
				default:
					$monthrange = array('monthfrom' => '01','monthto' => '03');
					break;
			}
		return $monthrange;
	}
}
if(!function_exists('getQuater'))
{
	function getQuater($current_month = NULL)
	{
		//$current_month = date('m');
       
        if($current_month>=1 && $current_month<=3)
        {
          $quarter='1';
        }
        else  if($current_month>=4 && $current_month<=6)
        {
          $quarter='2';
        }
        else  if($current_month>=7 && $current_month<=9)
        {
          $quarter='3';
        }
        else  if($current_month>=10 && $current_month<=12)
        {
          $quarter='4';
        }
		return $quarter;
	}
}
if(!function_exists('getMonthQuater'))
{
	 function getMonthQuater($qtr = NULL)
	 {
		 //print_r($qtr); exit;
		switch($qtr){
				case "01":
					$month = array('monthm1' => '01','monthm2' => '02','monthm3' => '03');
					break;
				case "02":
					$month = array('monthm1' => '04','monthm2' => '05','monthm3' => '06');
					break;
				case "03":
					$month = array('monthm1' => '07','monthm2' => '08','monthm3' => '09');
					break;
				case "04":
					$month = array('monthm1' => '10','monthm2' => '11','monthm3' => '12');
					break;
				default:
					$month = array('monthm1' => '01','monthm2' => '02','monthm3' => '03');
					break;
			}
		return $month;
	}
}
if(!function_exists('getMonth'))
{
	function getMonth()
	{
		$subtract = "";
		if(date('m')=='03'){
			$subtract = " -3 Day";
		}
		$month = date('m',strtotime(date('Y-m-d')." -1 months{$subtract}"));
		return $month;
	}
}
if(!function_exists('getVaccinationReportsCountofFacility'))
{
	function getVaccinationReportsCountofFacility($facode,$isreturn=FALSE){
		$CI = & get_instance();
		$query = "SELECT count(*) as cnt from fac_mvrf_db where facode='{$facode}'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$output = $result -> cnt;
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getSurveillanceReportsCountofFacility'))
{
	function getSurveillanceReportsCountofFacility($facode,$isreturn=FALSE){
		$CI = & get_instance();
		$query = "SELECT count(*) as cnt from zero_report where facode='{$facode}'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$output = $result -> cnt;
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('get_Village_Name')){
	function get_Village_Name($vcode){
		$CI = & get_instance();
		$query 		= "SELECT village from villages where vcode = '$vcode'";
		$resultVLG = $CI -> db -> query($query);
		if($resultVLG -> num_rows() >0)
		{
			return $resultVLG -> row()->village;	
		}
		return "";	
	}
}
if(!function_exists('get_Technician_Name')){
	function get_Technician_Name($techniciancode){
		$CI = & get_instance();
		$query 		= "SELECT technicianname from techniciandb where techniciancode = '$techniciancode'";
		$resultTeh = $CI -> db -> query($query) -> row_array();
		return $resultTeh['technicianname'];
	}
}
if(!function_exists('get_Technician_options')){
	function get_Technician_options($isreturn=false, $techniciancode=NULL, $facode=NULL){
		$CI = & get_instance();	
		$output = '<option value="0" >-- Select technician--</option>';
		echo $query="SELECT techniciancode, technicianname from techniciandb where facode= '$facode' ";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		//print_r($result);exit;
		foreach ($result1 as $oneteh) {
			if($oneteh["techniciancode"] !='')
			{
				$selected = '';
				if(($techniciancode > 0)&&($techniciancode == $oneteh["techniciancode"]))
				{
					$selected = 'selected="selected"';
				}
				$output .= '<option value="'.$oneteh["techniciancode"].'" '.$selected.' >'.$oneteh["technicianname"].'</option>';
			}
		}
		echo $output;
	}
}
if(!function_exists('get_Technician_status')){
	function get_Technician_status($techniciancode){
		$CI = & get_instance();
		$code= substr($techniciancode, 0, 3); 
		$pcode = $CI -> session -> District;
		if($code!=$pcode){
			$resultTeh['status']='Active';
			return $resultTeh['status'];
		}else{
			$query 		= "SELECT status from techniciandb where techniciancode = '$techniciancode'";
			$resultTeh = $CI -> db -> query($query) -> row_array();
			return $resultTeh['status'];
		}
	}
}
if(!function_exists('get_product_wise_facility_received_quantity_in_month')){
	function get_product_wise_facility_received_quantity_in_month($fmonth,$product_id,$facode,$isreturn=FALSE){
		$CI = & get_instance();
		$fmonthWithLastDate = date('Y-m-t 11:59:59',strtotime($fmonth));
		$query 		= "
						SELECT 
								(SUM(esb.quantity)*eips.number_of_doses) as vials
						FROM
								epi_item_pack_sizes eips
						LEFT JOIN
								epi_stock_batch esb ON eips.pk_id = esb.item_pack_size_id
						LEFT JOIN
								epi_stock_master esm ON esb.batch_master_id = esm.pk_id 
						WHERE
								eips.item_category_id <> 4 AND eips.activity_type_id = 1 
								AND esm.transaction_date BETWEEN '{$fmonth}-01 00:00:01' AND '{$fmonthWithLastDate}' 
								AND esm.transaction_type_id = 2 AND esm.to_warehouse_type_id = 6 
								AND esm.to_warehouse_code = '{$facode}' AND esb.item_pack_size_id = {$product_id}
						GROUP BY eips.pk_id,esm.to_warehouse_code 
						ORDER BY eips.list_rank";
		$resultPWQ = $CI -> db -> query($query) -> row();
		if($isreturn)
			return (isset($resultPWQ -> vials))?$resultPWQ -> vials:0;
		echo (isset($resultPWQ -> vials) && $resultPWQ -> vials > 0)?$resultPWQ -> vials:0;
	}
}
if( ! function_exists('get_consumption_detail_column_title')){
	function get_consumption_detail_column_title($column_name){
		$output = "";
		switch($column_name){
			case "used_vials":
				$output = 'Used (Vials)';
				break;
			case "used_doses":
				$output = 'Used (Doses)';
				break;
			case "unused_vials":
				$output = 'Unused (Vials)';
				break;
			case "unused_doses":
				$output = 'Unused (Doses)';
				break;
			case "closing_vials":
				$output = 'Closing Balance (Vials)';
				break;
			case "closing_doses":
				$output = 'Closing Balance (Doses)';
				break;
			default:
				$output = '';
				break;
		}
		return $output;
	}
}
if( ! function_exists('get_warehouse_code_column')){
	function get_warehouse_code_column($warehouseTypeId){
		$output = "";
		switch($warehouseTypeId){
			case 0:
				$output = 'unallocated';
				break;
			case 2:
				$output = 'procode';
				break;
			case 3:
				$output = 'divcode';
				break;
			case 4:
				$output = 'distcode';
				break;
			case 5:
				$output = 'tcode';
				break;
			/* case 6:
				$output = 'uncode';
				break; */
			case 6:
				$output = 'facode';
				break;
		}
		return $output;
	}
}
if( ! function_exists('get_store_name')){
	function get_store_name($returnResult=FALSE,$storetype,$storecode){
		$CI = & get_instance();	
		$CI -> load -> model ('Common_model');$name='';	
		switch($storetype){
			case 0:
				$name = 'Unallocated';
				break;
			case 1:
				$name = 'Federal Vaccine Store';
				break;
			case 2:
				$dbdata = $CI->Common_model->get_info("provinces",NULL,NULL,"province || ' EPI Store' as name",array("procode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 3:
				echo '';
				break;
			case 4:
				$dbdata = $CI->Common_model->get_info("districts",NULL,NULL,"'District ' || district || ' Store' as name",array("distcode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 5:
				$dbdata = $CI->Common_model->get_info("tehsil",NULL,NULL,"'Tehsil ' || tehsil || ' Store' as name",array("tcode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 6:
				//$dbdata = $CI->common->get_info("unioncouncil",NULL,NULL,"'UC ' || un_name || ' Store' as name",array("uncode"=>$storecode));
				$dbdata = $CI->Common_model->get_info("facilities",NULL,NULL,"'Facility ' || fac_name || ' Store' as name",array("facode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 7:
				$name = get_funding_source_name(true,$storecode);
				break;
			default:
				echo '';
				break;
		}
		if($returnResult)
			return $name;
		else
			echo $name;
	}
}
/*** get 12 months on base of end month parameter */
if( ! function_exists('getMonthsFromEndMonth')){
	function getMonthsFromEndMonth($yearmonth)
	{
		for ($i =11; $i >=0; $i--) 
		{
			$months[] = date("Y-m", strtotime( $yearmonth.'-01'."-$i months "));
		}
		return $months;
	}
}
/*to get uccode on base of facode*/
if( ! function_exists('getUcCode')){
	function getUcCode($facode)
	{
		$CI=& get_instance();
		$query="SELECT uncode from facilities where facode='$facode'";
		$resultPWQ = $CI -> db -> query($query) -> row();
		return $resultPWQ->uncode;
	}
}
if( ! function_exists('getMaxMergerGroupId')){
	function getMaxMergerGroupId()
	{
		$CI = & get_instance();
		$CI -> db -> select('MAX(merger_group_id) as groupid');
		$CI -> db -> from('villages_population');
		$result = $CI -> db -> get() -> row();
		return $result -> groupid;
	}
}
if( ! function_exists('mergedVillage')){
	function mergedVillage($vcode,$year)
	{
		$CI = & get_instance();
		$CI -> db -> select('merged_village');
		$CI -> db -> from('villages_population');
		$CI -> db -> where(" vcode = '{$vcode}' and year = '{$year}' ");
		$result = $CI -> db -> get() -> row();
		return (isset($result -> merged_village))?$result -> merged_village:0;
	}
}
if( ! function_exists('mergedVillageGroupId')){
	function mergedVillageGroupId($vcode,$year)
	{
		$CI = & get_instance();
		$CI -> db -> select('merger_group_id');
		$CI -> db -> from('villages_population');
		$CI -> db -> where(" vcode = '{$vcode}' and year = '{$year}' ");
		$result = $CI -> db -> get() -> row();
		return (isset($result -> merger_group_id))?$result -> merger_group_id:0;
	}
}
if( ! function_exists('checkMergerGroupIdOccurance')){
	function checkMergerGroupIdOccurance($groupId)
	{
		$CI = & get_instance();
		$CI -> db -> select('count(merger_group_id) as cnt');
		$CI -> db -> from('villages_population');
		$CI -> db -> where(" merger_group_id = {$groupId} ");
		$result = $CI -> db -> get() -> row();
		return (isset($result -> cnt))?$result -> cnt:0;
	}
}
if( ! function_exists('get_surviving_infants')){
	function get_surviving_infants($population)
	{
		$CI = & get_instance();
		$population1 = (0.0353*$population);
		$survivingInfantspop= ceil(0.942*$population1);
		return $survivingInfantspop;
	}
} 
if(!function_exists('get_UserLevel_Description')){
	function get_UserLevel_Description($level){
		$CI = & get_instance();
		$query 	= "SELECT userlevel_description from user_level_db where userlevel = '$level' " ;
		$resultUserLevel = $CI -> db -> query($query);
		return $resultUserLevel -> row()-> userlevel_description;	
	}
}
////////////////Check Microplan technician config/////////////////////
if(!function_exists('get_Microplan_Technician_Config')){
	function get_Microplan_Technician_Config($facode,$plan_id){
		$CI = & get_instance();
		$query 	= "SELECT techniciancode from microplan_technician_config where plan_id = '$plan_id' and facode='$facode' " ;
		$techniciancode = $CI -> db -> query($query);
		return $techniciancode -> row()-> techniciancode;	
	}
}
if(!function_exists('getMicroplan_Technician_options')){
	function getMicroplan_Technician_options($facode=NULL){
		$CI = & get_instance();	
		$output = '<option value="0" >-- Select technician--</option>';
		$query="SELECT techniciancode,technicianname(techniciancode) as technician,plan_id from microplan_technician_config where facode= '$facode' order by facode";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		//print_r($result);exit;
		foreach ($result1 as $oneteh) {
			if($oneteh["techniciancode"] !='')
			{
				$selected = '';
				$output .= '<option value="'.$oneteh["techniciancode"].'" '.$selected.' >'.$oneteh["technician"].'</option>';
			}
		}
		echo $output;
	}
}
if(!function_exists('where_between')){
	function where_between($field, $min, $max){
		$CI = get_instance();
		return $CI->db->where("$field BETWEEN $min AND $max");
	}
}
if(!function_exists('get_nextyearweek')){
	function get_nextyearweek($year,$week,$getdata){
		$CI = get_instance();
		$CI ->db->select('* from(select fweek as curr_fmonth,lag(fweek) over (order by year asc, epi_week_numb asc) as prev_fmonth,lead(fweek) over (order by year asc, epi_week_numb asc) as next_fmonth
        from epi_weeks) x', FALSE);
		$CI -> db -> where("'$year-$week' IN (curr_fmonth)",NULL,FALSE);
        $result = $CI -> db -> get() -> result_array();
		//print_r($result);exit;
		return $result[0][$getdata]; 
		/* $query="select * from (
        select fweek as curr_fmonth,lag(fweek) over (order by year asc, epi_week_numb asc) as prev_fmonth,lead(fweek) over (order by year asc, epi_week_numb asc) as next_fmonth
        from epi_weeks) x
        where '$year-$week' IN (curr_fmonth)";
		$result = $CI->db->query($query);
		$result=$result -> result_array();
		//$str = $CI->db->last_query();
		//print_r($str); exit;	
		return $result[0][$getdata]; */
	}
}	
	if(!function_exists('finalClassification')){
		function finalClassification($isreturn=false,$id){
			$CI = & get_instance();
			$query = "SELECT specimen_result from case_investigation_db where id=$id";
			$result = $CI -> db -> query($query);        
			$result = $result -> row_array();
			$specimenResult = $result['specimen_result'];
			if($specimenResult == 'Positive Measles'){
				$output = 'Measles';
			}
			elseif($specimenResult == 'Positive Rubella'){
				$output = 'Rubella';
			}
			elseif($specimenResult == NULL){
				$output = '';
			}
			else{
				$output = 'Discarded';
			}
			if($isreturn)
				return $output;
			echo $output;	
		}
	}
	if(!function_exists('epiLinked')){
		function epiLinked($isreturn=false,$uncode,$fweek,$result){
			$CI = & get_instance();
			//echo			
			$query = "SELECT count(id) as cases from case_investigation_db where patient_address_uncode='$uncode' and fweek='$fweek' and case_type='Msl' and specimen_result='$result'"; 
			//exit();
			$result = $CI -> db -> query($query);        
			$result = $result -> row_array();
			$num_of_cases = $result['cases'];
			if($num_of_cases > 1){
				$output = 'Epi Linked';
			}		
			else{
				$output = '';
			}
			if($isreturn)
				return $output;
			echo $output;	
		}
	}
	if(!function_exists('get_Region_Live_Url')){
		function get_Region_Live_Url($procode){
			$CI = & get_instance();
			$query = "SELECT weburl from provinces where procode = '$procode' " ;
			$resultUrl = $CI -> db -> query($query);
			return $resultUrl -> row()->weburl;	
		}
	}
	if(!function_exists('get_Region_Local_Url')){
		function get_Region_Local_Url($procode){
			$CI = & get_instance();
			$query 		= "SELECT localurl from provinces where procode = '$procode' " ;
			$resultUrl = $CI -> db -> query($query);
			return $resultUrl -> row()->localurl;
		}
	}
    if(!function_exists('get_Supervisor_Designation')){
		function get_Supervisor_Designation(){
			$CI = & get_instance();
			$distcode=$CI-> session-> District;
			$wc ="distcode = '$distcode'";
			$output = '';
			$query="SELECT distinct supervisor_type from supervisordb where $wc";
			$result = $CI -> db ->query($query);
			$result1 = $result->result_array();
			//print_r($result1); exit;
			foreach ($result1 as $onedist) { 
				$selected = '';
				$output .= '<option value="'.$onedist["supervisor_type"].'" '.$selected.' >'.$onedist["supervisor_type"].'</option>';
			}
			echo $output;
		}
	}
	if(!function_exists('currentYearHalf')){
		function currentYearHalf($month=NULL){
			return ($month <= 6)?1:(($month > 6)?2:1);
		}
	}
	if(!function_exists('get_indicator_periodic_multiplier')){
		function get_indicator_periodic_multiplier($indicator,$year){
			$CI = &get_instance();
			$query=" SELECT formula_multiplier as multiplier from indicator_periodic_multiplier where indicator='$indicator' and  '$year' >= start_year and ( '$year' <=end_year or end_year='')";	
			$result = $CI -> db ->query($query);
			$result1 = $result->row();
			if(isset($result1 -> multiplier))
			{
				 $val=$result1 -> multiplier;
			}else{
				 $val=0;
			}
			return $val;
		}
	}
	if(!function_exists('get_indicator_periodic_multiplier_dist_target')){
		function get_indicator_periodic_multiplier_dist_target($indicator,$year,$code){
			//getMainIndicatorsData
			$CI = &get_instance();
			if(strlen($code)>=3)
			{
				$query=" SELECT formula_multiplier as multiplier from indicator_periodic_multiplier where code= substring('$code', 1, 3) and indicator='$indicator' and '$year' >= start_year and ('$year' <=end_year or end_year='')";	
			}
			else{
				$query=" SELECT formula_multiplier as multiplier from indicator_periodic_multiplier where code= substring('$code', 1, 1) and indicator='$indicator' and '$year' >= start_year and ('$year' <=end_year or end_year='')";	
			}
			//echo $query;
			$result = $CI -> db ->query($query);
			$result1 = $result->row();
			if(isset($result1 -> multiplier))
			{
				 $val=$result1 -> multiplier;
			}else{
				 $val=0;
			}
			return $val;
		}
	}
	//Get Level's Name(hr_levels)
	if(!function_exists('get_level_name')){
		function get_level_name($level="")
		{  
			$CI=& get_instance();
			$CI->db->select('name');
			$CI->db->from('hr_levels');
			$CI->db->where('code',$level);
			$result_array = $CI->db->get()->row_array();
			return $result_array['name'];
		}
	}
	//Get type's Name(hr_types)
	if(!function_exists('get_type_name')){
		function get_type_name($type="")
		{  
			$CI=& get_instance();
			$CI->db->select('name');
			$CI->db->from('hr_types');
			$CI->db->where('id',$type);
			$result_array = $CI->db->get()->row_array();
			return $result_array['name'];
		}
	}
	//Get Subtype's Name(hr_sub_types)
	if(!function_exists('get_subtype_name')){
		function get_subtype_name($subtype="")
		{  
			$CI=& get_instance();
			$CI->db->select('title');
			$CI->db->from('hr_sub_types');
			$CI->db->where('type_id',$subtype);
			$result_array = $CI->db->get()->row_array();
			return $result_array['title'];
		}
	}
	if(!function_exists('getVaccines_id')){
	function getVaccines_id($vaccine){
		$CI = & get_instance();
		$query 		= "SELECT cr_table_row_numb as itemid from epi_item_pack_sizes where pk_id='$vaccine'";
		$resultVaccine = $CI -> db -> query($query);
		return $resultVaccine -> row()->itemid;	
	}
}
	if(!function_exists('getDistrict_Coordinates')){
		function getDistrict_Coordinates($distcode){
			$CI = & get_instance();
			$query 		= "SELECT highchart_coordinates from districts where distcode = '$distcode'";
			$resultTeh = $CI -> db -> query($query) -> row_array();
			return $resultTeh['highchart_coordinates'];
		}
	}
	if(!function_exists('getMonthsEpiWeeks')){
	function getMonthsEpiWeeks($year=NULL,$month=NULL){
		//echo 'test';exit;
		$CI = & get_instance();
		$year = ($year > 0)?$year:$this -> input -> post('year');
		$month = ($month > 0)?$month:$this -> input -> post('month');
		//print_r($month );exit;
		$query = "SELECT max(epi_week_numb) as num from epi_weeks where year='$year' and month='$month'";
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		return $result->num;
	}
}
//form_bc_r form fields items 
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
if(!function_exists('get_Hr_Name')){
	function get_Hr_Name($code,$hr_sub_type_id){
		$CI = & get_instance();
		$query 		= "SELECT name from hr_db where code = '$code' and hr_sub_type_id='$hr_sub_type_id'";
		$resultTeh = $CI -> db -> query($query) -> row_array();
		return $resultTeh['name'];
	}
}
if(!function_exists('hr_name')){
	function hr_name($code){
		$CI = & get_instance();
		$query 		= "SELECT name from hr_db where code = '$code'";
		$resultTeh = $CI -> db -> query($query) -> row_array();
		return $resultTeh['name'];
	}
}
if(!function_exists('get_Hr_Sub_type')){
	function get_Hr_Sub_type($isreturn=false, $hr_type_id=NULL){
		$CI = & get_instance();		
		$output = '';
		$output .= '<option value="">-- Select --</option>';
		//$query="SELECT province, procode from provinces order by procode asc";
		$query = "select type_id,title from hr_sub_types where  hr_type_id='$hr_type_id'";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $type_id) { 
			if($hr_type_id == $type_id["type_id"]){
					$selected = 'selected';
			}else{
					$selected = '';
			}
			
			$output .= '<option value="'.$type_id["type_id"].'" '.$selected.' >'.$type_id["title"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('get_all_subtype_name')){
	function get_all_subtype_name($isreturn=false,$selected=NULL){
		$CI = & get_instance();
		$output = "";
		$CI -> db -> select("title,type_id");
		$CI -> db -> from("hr_sub_types");
        $CI -> db -> order_by('title');
		$result1 = $CI -> db -> get() -> result_array();
		//echo $selected;exit;
		foreach ($result1 as $type) { 
			$isSelected = (isset($selected) && $selected==$type["type_id"])?'selected="selected"':'';
			$title = trim($type["title"]);
			$output .= '<option value="'.$type["type_id"].'" '.$isSelected.' >'.$title.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('get_all_status')){
	function get_all_status($isreturn=false,$selected=NULL){
		$CI = & get_instance();
		$output = "";
		$CI -> db -> select("caption,value");
		$CI -> db -> from("lookup_master");
		$CI -> db -> join("lookup_detail  look","look.master_id= lookup_master.id");
		$CI -> db -> where("lookup_master.id=1");
		$result1 = $CI -> db -> get() -> result_array();
		foreach ($result1 as $type) { 
			$isSelected = (isset($selected) && $selected==$type["value"])?'selected="selected"':'';
			$title = trim($type["caption"]);
			$output .= '<option value="'.$type["value"].'" '.$isSelected.' >'.$title.'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getWithinCountryTravelHistory')){
	function getWithinCountryTravelHistory($isreturn=false,$id){
		$CI = & get_instance();
		$output = "";
		$CI -> db -> select("*, provincename(from_procode) as from_province, districtname(from_distcode) as from_district, tehsilname(from_tcode) as from_tehsil, unname(from_uncode) as from_uc, provincename(to_procode) as to_province, districtname(to_distcode) as to_district, tehsilname(to_tcode) as to_tehsil, unname(to_uncode) as to_uc");
		$CI -> db -> from("country_visits");
        $CI -> db -> where("case_id = $id");
         $CI -> db -> order_by('case_id');
		$result = $CI -> db -> get() -> result_array();
		//echo $id;exit();
		//print_r($result);exit();
		foreach ($result as $row) {	
			//$output .= '<td>'.$row["from_province"].','.$row["from_district"].','.$row["from_tehsil"].','.$row["from_uc"].','.$row["from_address"].'</td>';
			$output .= '<td>'.'UC-'.$row["from_uc"].', Tehsil-'.$row["from_tehsil"].', District-'.$row["from_district"].', '.$row["from_province"].'</td>';			
		}		
		//print_r($output);exit();
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getAbroadTravelHistory')){
	function getAbroadTravelHistory($isreturn=false,$id){
		$CI = & get_instance();
		$output = "";
		$CI -> db -> select("*");
		$CI -> db -> from("abroad_cases");
        $CI -> db -> where("case_id = $id");
		$result = $CI -> db -> get() -> result_array();
		//echo $id;exit();
		//print_r($result);exit();
		foreach ($result as $row) {	
			$output .= '<td>'.$row["country"].'</td>';
			$output .= '<td>'.$row["departed_date"].'</td>';
			$output .= '<td>'.$row["transit_site"].'</td>';
		}		
		//print_r($output);exit();
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getMonthsOptionsTillPrevious')){
	function getMonthsOptionsTillPrevious($isreturn=false,$listing=false){		
		$output = "";
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:date('m')-1;
		$currMon = ($mnth=="13")?12:date('m')-1;
		/* $currMon = date('m'); */
		//$output .= '<option value="" selected="selected">Select</option>';	
		if(validation_errors() != false) {
			foreach($months as $num => $monthitem){
				$month = sprintf("%02d", $num);
				$errorShow = set_select('month',$month);
				$output .= '<option value="'.$month.'" '.$errorShow.'>'.$monthitem.'</option>';
			}
		}
		else {
			$errorShow = '';
			foreach ($months as $num => $monthitem) { 
				if($num > ($currMon))
				{}else{
					$isSelected = (($mnth)==$num && $listing==false)?'selected="selected"':'';
					$month = sprintf("%02d", $num);
					$output .= '<option value="'.$month.'" '.$isSelected.' '.$errorShow.'>'.$monthitem.'</option>';								
				}
			}
		}
		
		if($isreturn)
			return $output;
		echo $output;
	}
}
if(!function_exists('getCategory')){
	function getCategory($access,$utilization){
		$return = "No data ";
		if($access >= 80 && $utilization < 10){
			$return = "Category 1";
		}
		elseif($access >= 80 && $utilization >= 10){
			$return = "Category 2";
		}
		elseif($access < 80 && $utilization < 10){
			$return = "Category 3";
		}
		elseif($access < 80 && $utilization >= 10){
			$return = "Category 4";
		}
		return $return;
	}
}

if(!function_exists('get_vaccineslist')){
	function get_vaccineslist($isreturn=false, $vacc_id=NULL){
		$CI = & get_instance();
		if($vacc_id1){
			$wc = " and pk_id='$vacc_id' ";
		}
		else{
			$wc="";
		}
		$output = "";
		$query="SELECT pk_id, description from epi_items where item_category_id='1' and is_active='1' $wc order by description";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $vaccine) {
			$selected = '';
			if(($vacc_id > 0) && ($vacc_id == $vaccine["pk_id"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$vaccine["pk_id"].'" '.$selected.'>'.$vaccine["description"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}	
}

if(!function_exists('getVaccineName')){
    function getVaccineName($vacc_id="")
    {
        $CI=& get_instance();
        $_query = "SELECT description from epi_items where item_category_id='1' and is_active='1' and pk_id=$vacc_id";
        $results=$CI->db->query($_query);
        $rows=$results->row_array();        
        return $rows['description'];
    }
}

if(!function_exists('get_batcheslist')){
	function get_batcheslist($isreturn=false, $batch_number=NULL){
		$CI = & get_instance();
		$distcode = $CI -> session -> District;
		$username = $CI -> session -> userdata("username");
		if($qbatch_number){
			$wc = " and number='$batch_number' ";
		}
		else{
			$wc="";
		}
		$output = "";
		$query = "SELECT DISTINCT number from epi_stock_batch where code ='$distcode' and created_by='$username' $wc order by number";
		$result = $CI -> db ->query($query);
		$result1 = $result->result_array();
		foreach ($result1 as $vaccine) { 
			$selected = '';
			if(($batch_number != '') && ($batch_number == $vaccine["number"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$vaccine["number"].'" '.$selected.'>'.$vaccine["number"].'</option>';
		}
		if($isreturn)
			return $output;
		echo $output;
	}	
}

?>