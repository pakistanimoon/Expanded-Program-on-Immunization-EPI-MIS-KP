<?php
//kp local
class Ajax_calls extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		//authentication(); 
		$this -> load -> model('Ajax_calls_model');
	}
	public function getYears(){
		$year = $this -> input -> post('year'); 
		echo $years = getEpiWeekYearsOptions($year);
	}
	public function getEpiWeeksDates(){
		$epiweek = $this -> input -> post('epiweek');
		if($epiweek > 0){
			$year = $this -> input -> post('year');
			$query = "SELECT date_from, date_to from epi_weeks where year='$year' and epi_week_numb=$epiweek";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekDates = array(
				'startDate' => date("d-M-Y",strtotime($result->date_from)),
				'EndDate'   => date("d-M-Y",strtotime($result->date_to)),
				'year'=>$year
			);
			echo json_encode($weekDates);
		}else{
			echo 0;
		}
	}
	public function get_idsWeeks(){
		$date_from = ($this -> input -> post('date_from'))?date("Y-m-d",strtotime($this -> input -> post('date_from'))):NULL;
		$date_to = ($this -> input -> post('date_to'))?date("Y-m-d",strtotime($this -> input -> post('date_to'))):NULL;
		$dateYear = ($date_from != '')?explode("-",$date_from):(($date_to != '')?explode("-",$date_from):"");
		$dateYear = ($dateYear != '')?$dateYear[0]:'';
		$year = ($this -> input -> post('year'))?$this -> input -> post('year'):$dateYear;
		$data = $this -> Ajax_calls_model -> get_idsWeeks($date_from, $date_to, $year);
		echo $data;
	}
	/* public function getEpiWeeksDates(){
		date_default_timezone_set('Asia/Karachi');
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('epiweek');
		$startYearMonth = date("$year-01");
		$nextYear = date('Y', strtotime('+1 year',strtotime($startYearMonth)));
		$endYearMonth = date('Y-m-d',strtotime($nextYear.'-'.'01-01'));
		$start = date('Y-m-d',strtotime('first sunday', strtotime($startYearMonth)));
		$end = date('Y-m-d',strtotime('last saturday', strtotime($endYearMonth)));
		
		$i = 1;
		for($start;$start<$end;$start){
			$weekEnd = date('d-M-y',strtotime("$start +6 days"));
			if($i == $week){
				$weekDates = array(
					'startDate' => date('d-M-y',strtotime($start)),
					'EndDate' => $weekEnd,
					'year'=>$year
					
				);
				
				
				echo json_encode($weekDates);
				exit;
			}
			$start = date('Y-m-d',strtotime("$start +7 days"));
			$i++;
		}
	} */
	
	public function getEpiWeeks(){
		/* $current_date = date("Y-m-d");
		$year = $this -> input -> post('year');
		$query = "SELECT max(epi_week_numb) as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		$query = $this -> db -> query($query);
		$result = $query -> row();
		date_default_timezone_set('Asia/Karachi');
		$weekOptions='<option value="">--Select Week--</option>';
		for($i=1;$i<$result->num;$i++){//for($i=1;$i<=$result->num;$i++){
			$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
			//$isSelected = ($result->num==$i)?'selected="selected"':'';
			$month = sprintf("%02d",($i));
			$weekOptions .= '<option '.$isSelected.' value="'.$i.'">Week '.$month.'</option>';
		}
		echo $weekOptions; */
		//$current_date = date("Y-m-d");
		//$current_date = date("Y-m-d",strtotime(date("Y-m-d")." -7 days"));
		$current_date = date("Y-m-d");
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('week');
		$curr_year = getWeekYearAccordingToCurrentDate($current_date);
		if($year == $curr_year || $year == "" ){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($week)==$i+1)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if(($year+1) == $curr_year ){
			//weeks of previous year
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year' ";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($week)==$i+1)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}else if($year < $curr_year ){
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($week)==$i+1)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		/* else if($year < $curr_year ){
			$query = "select MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($week)==$i+1)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		} */
		else{
			$weekOptions= 1; 
			echo $weekOptions;
		}
	}
		
	/* public function getEpiWeeks(){
		$year = $this -> input -> post('year');
		date_default_timezone_set('Asia/Karachi');
		$startYearMonth = date("$year-01");
		$nextYear = date('Y', strtotime('+1 year',strtotime($startYearMonth)));
		$endYearMonth = date('Y-m-d',strtotime($nextYear.'-'.'01-01'));
		$start = date('Y-m-d',strtotime('first sunday', strtotime($startYearMonth)));
		$end = date('Y-m-d',strtotime('last saturday', strtotime($endYearMonth)));
		$i = 1;
		$weekOptions='<option value="">--Select Week--</option>';
		for($start;$start<$end;$start){
			$start = date('Y-m-d',strtotime("$start +7 days"));
			$weekOptions .= '<option value="'.($i).'">Week '.sprintf("%02d",($i)).'</option>';
			$i++;
		}
		echo $weekOptions;
	} */
	public function getcase_investWeeksDates(){
		$epiweek = $this -> input -> post('epiweek');
		$year = $this -> input -> post('year');
		$curr_year = date("Y");
		if ($year !="" && $epiweek != 0) {
			$wc = " where year ='$year' and epi_week_numb ='$epiweek'  ";
		}else{
			$year = $curr_year;
			$wc = " where year ='$year' and epi_week_numb ='$epiweek'  ";
		}
		
		$query = "SELECT date_from, date_to from epi_weeks $wc";
		$query = $this -> db -> query($query);
		$result = $query -> row();
		$weekDates = array(
			'startDate' => date("d-M-Y",strtotime($result->date_from)),
			'EndDate'   => date("d-M-Y",strtotime($result->date_to)),
			'year'=>$year
		);
		echo json_encode($weekDates);
	}
	public function getEpiWeeksWithoutAllOption(){
		$zero = $this->input->post('report');//param for specific zero report
		//echo $zero;exit;
		$current_day = date('l');//current day		
		$current_date = date("Y-m-d",strtotime('-1 week'));
		/* } */
		//$current_date = date("Y-m-d");
		$year = $this -> input -> post('year');
		$curr_year = date("Y");////date("Y")////,strtotime("-1 week")
		if($year == $curr_year || $year == "" ){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date'";
			////$query = "SELECT epi_week_numb as num from epi_weeks";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			////date_default_timezone_set('Asia/Karachi');
			//$weekOptions='<option value="0">--Select Week--</option>';
			$weekOptions='';			
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if(($year+1) == $curr_year ){
			//weeks of previous year
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			//$weekOptions='<option value="0">--Select Week--</option>';
			$weekOptions='';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if($year < $curr_year ){
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			//$weekOptions='<option value="0">--Select Week--</option>';
			$weekOptions='';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else{
			$weekOptions= 1; 
			echo $weekOptions;
		}
	}	
	public function getcase_investWeeks(){
		$zero = $this->input->post('report');//param for specific zero report
		//echo $zero;exit;
		$current_day = date('l');//current day
		/* //if zero report & day is saturday & time > 2:00 P.M current week will be enabled as requested by D.I.KHAN
		if($current_day=="Saturday" && $zero=="zero_report" && time() >= strtotime("14:00:00")){
			$current_date = date("Y-m-d");
		}
		else
		{ */
		$current_date = date("Y-m-d",strtotime('-1 week'));
		/* } */
		//$current_date = date("Y-m-d");
		$year = $this -> input -> post('year');
		$curr_year = date("Y");////date("Y")////,strtotime("-1 week")
		if($year == $curr_year || $year == "" ){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date'";
			////$query = "SELECT epi_week_numb as num from epi_weeks";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			////date_default_timezone_set('Asia/Karachi');
			$weekOptions='<option value="0">--Select Week--</option>';
			/* for($i=1;$i<$result->num;$i++){//for($i=1;$i<=$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				//$isSelected = ($result->num==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i));
				$weekOptions .= '<option '.$isSelected.' value="'.$i.'">Week '.$month.'</option>';
			} */
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if(($year+1) == $curr_year ){
			//weeks of previous year
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else{
			$weekOptions= 1; 
			echo $weekOptions;
		}
	}
	public function getcase_investWeeksforCurrentYear(){
		$current_date = date("Y-m-d");
		$year = $this -> input -> post('year');
		$curr_year = getWeekYearAccordingToCurrentDate($current_date);////date("Y")////

		if($year == $curr_year || $year == "" ){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date'";
			////$query = "SELECT epi_week_numb as num from epi_weeks";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			////date_default_timezone_set('Asia/Karachi');
			$weekOptions='<option value="0">--Select Week--</option>';
			/* for($i=1;$i<$result->num;$i++){//for($i=1;$i<=$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				//$isSelected = ($result->num==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i));
				$weekOptions .= '<option '.$isSelected.' value="'.$i.'">Week '.$month.'</option>';
			} */
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if(($year+1) == $curr_year ){
			//weeks of previous year
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else{
			$weekOptions= 1; 
			echo $weekOptions;
		}
	}
	public function getidsrsEpiWeeks(){
		$current_date = date("Y-m-d",strtotime("-1 week"));
		$year = $this -> input -> post('year');
		$curr_year = date("Y");

		if($year == $curr_year || $year == "" ){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option selected="selected" value="0">--Select Week--</option>';
			
			for($i=0;$i<$result->num;$i++){
				$isSelected = '';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else if(($year+1) == $curr_year ){
			//weeks of previous year
			$query = "SELECT MAX(epi_week_numb) as num from epi_weeks where year = '$year'";
			$query = $this -> db -> query($query);
			$result = $query -> row();
			$weekOptions='<option selected="selected" value="0">--Select Week--</option>';
			for($i=0;$i<$result->num;$i++){
				$isSelected = '';
				$month = sprintf("%02d",($i+1));
				$weekOptions .= '<option '.$isSelected.' value="'.($i+1).'">Week '.$month.'</option>';
			}
			echo $weekOptions;
		}
		else{
			$weekOptions= 1; 
			echo $weekOptions;
		}
	}
	public function getEpiFromTOWeeks(){
		//print_r($_POST);exit();
		$current_date = date("Y-m-d",strtotime(date("Y-m-d")." -7 days"));//to get data till last week
		$year = $this -> input -> post('year');
		$from_week = $this -> input -> post('from_week');
		$to_week = $this -> input -> post('to_week');
		$query = "SELECT date_from from epi_weeks where year='$year' and epi_week_numb=$from_week";
		$query = $this -> db -> query($query);
		$result = $query -> row();
		$date_from  = $result->date_from;
		$query = "SELECT epi_week_numb as num from epi_weeks where epi_week_numb >= '$from_week' and year='$year' and date_from BETWEEN '$date_from' and '$current_date' order by epi_week_numb";
		$query = $this -> db -> query($query);
		$result = $query -> result_array();
		date_default_timezone_set('Asia/Karachi');
		/* $to_week1="";
		if($to_week < 10){
			$to_week1="0".$to_week;
		} */
		$isSelected="";
		$weekOptions='<option value="">--Select Week--</option>';
		foreach($result as $row){			
			$month = sprintf("%02d",($row['num']));
			$isSelected = ($to_week==$row['num'])?'selected="selected"':''; 
			$weekOptions .= '<option '.$isSelected.' value="'.$row['num'].'">Week '.$month.'</option>';
			//$weekOptions .= '<option value="'.$row['num'].'">Week '.$month.'</option>';
		}
		echo $weekOptions;
	}
	// public function getEpiFromTOWeeks(){
	// 	$current_date = date("Y-m-d",strtotime(date("Y-m-d")." -7 days"));//to get data till last week
	// 	$year = $this -> input -> post('year');
	// 	$from_week = $this -> input -> post('from_week');
	// 	$to_week = $this -> input -> post('to_week');
	// 	$query = "SELECT date_from from epi_weeks where year='$year' and epi_week_numb=$from_week";
	// 	$query = $this -> db -> query($query);
	// 	$result = $query -> row();
	// 	$date_from  = $result->date_from;
	// 	$query = "SELECT epi_week_numb as num from epi_weeks where epi_week_numb >= '$from_week' and year='$year' and date_from BETWEEN '$date_from' and '$current_date'";
	// 	$query = $this -> db -> query($query);
	// 	$result = $query -> result_array();
	// 	date_default_timezone_set('Asia/Karachi');
	// 	/* $to_week1="";
	// 	if($to_week < 10){
	// 		$to_week1="0".$to_week;
	// 	} */
	// 	$isSelected="";
	// 	$weekOptions='<option value="">--Select Week--</option>';
	// 	foreach($result as $row){			
	// 		$month = sprintf("%02d",($row['num']));
	// 		$isSelected = ($to_week==$row['num'])?'selected="selected"':''; 
	// 		$weekOptions .= '<option '.$isSelected.' value="'.$row['num'].'">Week '.$month.'</option>';
	// 		//$weekOptions .= '<option value="'.$row['num'].'">Week '.$month.'</option>';
	// 	}
	// 	echo $weekOptions;
	// }
	public function change_password() {
		$data = $this -> Ajax_calls_model -> change_password();
		echo $data;
	}
	public function getAefiNumber() {
		$year = $this -> input -> post('year');
		$epid_code = $this -> input -> post('epid_code');
		$data = $this -> Ajax_calls_model -> getAefiNumber($year, $epid_code);
		echo $data;
	}
	public function validateAefiNumber() {
		$aefiNumber = $this -> input -> post('aefiNumber');
		$data = $this -> Ajax_calls_model -> validateAefiNumber($aefiNumber);
		echo $data; 
	}
	public function validateMeasleNumber() { 
		$measleNumber = $this -> input -> post('measleNumber');
		$data = $this -> Ajax_calls_model -> validateMeasleNumber($measleNumber);
		echo $data; 
	}
	public function getMeasleNumber() {
		$year = $this -> input -> post('year');
		$epid_code = $this -> input -> post('epid_code');
		$data = $this -> Ajax_calls_model -> getMeasleNumber($year, $epid_code);  
		echo $data;
	}
	
	public function getepi_number() {
		$year = $this -> input -> post('year');
		$case_type = $this -> input -> post('case_type');
		if($case_type==''){
			$case_type="Acute Flaccid Paralysis";
		}
		$short_code = $this -> input -> post('short_code');
		$data = $this -> Ajax_calls_model -> getepi_number($year, $case_type,$short_code);
		echo $data;
	}
	
	public function getcase_definition() {		
		$case_type = $this -> input -> post('case_type');
		if($case_type==''){
			$case_type="Acute Flaccid Paralysis";
		}
		$data = $this -> Ajax_calls_model -> getcase_definition($case_type);
		echo $data;
	}
	
	public function supervisor_filter() {
		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$uncode = $this -> uri -> segment(6);		
		$facode = $this -> uri -> segment(7);
		$fatype = $this -> uri -> segment(8);
		$supervisor_type = $this -> uri -> segment(9);
		$status = $this -> uri -> segment(10);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> supervisor_filter($page, $distcode, $tcode, $facode, $fatype, $uncode, $supervisor_type,$status);
		echo $data;
	}
	public function supervisor_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->supervisor_filter_cnic($cnic);
		echo $data;
	}
	public function checkNICNumber(){
		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkNICNumber($nic,$code);
		echo $data;
	}
	public function checktechNIC(){
		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checktechNIC($nic,$code);
		//echo $data;
		echo (empty($data))?0:json_encode($data);
	}
	public function checkcctechNIC(){
		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkcctechNIC($nic,$code);
		echo $data;
	}
	public function checkCoNIC(){
		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCoNIC($nic,$code);
		echo $data;
	}
	public function checkMfpNIC(){
		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkMfpNIC($nic,$code);
		echo $data;

	}
	public function checkgoNIC(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkgoNIC($nic,$code);
		echo $data;

	}
	public function checkccoNIC(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkccoNIC($nic,$code);
		echo $data;

	}
	public function checkCc_mechanic_NIC(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCoNIC($nic,$code);
		echo $data;
	}
	public function ccoperatordb_filter() {

		$page = $this -> uri -> segment(3);
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$data = $this -> Ajax_calls_model -> ccoperatordb_filter($page,$status,$distcode);
		echo $data;
	}
	public function ccoperatordb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->ccoperatordb_filter_cnic($cnic);
		echo $data;
	}
	
	public function codb_filter() {

		$page = $this -> uri -> segment(3);
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$data = $this -> Ajax_calls_model -> codb_filter($page,$status,$distcode);
		echo $data;
	}
	public function codb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->codb_filter_cnic($cnic);
		echo $data;
	}
	public function mfpdb_filter() {

		$page = $this -> uri -> segment(3);
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$data = $this -> Ajax_calls_model -> mfpdb_filter($page,$status,$distcode);
		echo $data;
	}
	public function mfpdb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->mfpdb_filter_cnic($cnic);
		echo $data;
	}
	public function getBranches() {	
	
		
		$data = $this -> Ajax_calls_model -> getBranches();	
		echo $data;	
	}
	public function getFacilityTechnicians(){
		$facode = $this -> input -> post('facode');
		$technicians = $this -> Ajax_calls_model -> getFacilityTechnicians($facode);
		$data = '<option value="">--Select Technician--</option>';
		if( ! empty($technicians)){
			foreach($technicians as $key => $technician){
				$data .= '<option value="'.$technician['techniciancode'].'">'.$technician['technicianname'].'</option>';
			}
		}
		echo $data;
	}

	public function technician_filter() {

		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$uncode = $this -> uri -> segment(6);
		$facode = $this -> uri -> segment(7);		
		$supervisorcode = $this -> uri -> segment(8);
		$fatype = $this -> uri -> segment(9); 
		$status = $this -> uri -> segment(10);
		$data = $this -> Ajax_calls_model -> technician_filter($page,$distcode, $tcode, $uncode, $facode, $supervisorcode, $fatype,$status);
		//print_r($data);exit;
		echo $data;
	}
	public function med_technician_filter() {
		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$facode = $this -> uri -> segment(6);
		$uncode = $this -> uri -> segment(7);
		$supervisorcode = $this -> uri -> segment(8);
		$status = $this -> uri -> segment(9);
		$fatype = $this -> uri -> segment(10);
		$data = $this -> Ajax_calls_model -> med_technician_filter($page,$distcode, $tcode, $facode, $uncode, $supervisorcode, $status,$fatype);
		echo $data;
	}
	
	public function technician_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->technician_filter_cnic($cnic);
		echo $data;
	}
	public function med_technician_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->med_technician_filter_cnic($cnic);
		echo $data;
	}
	public function driverdb_filter() {

		$page = $this -> uri -> segment(3);
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$data = $this -> Ajax_calls_model -> driverdb_filter($page,$status,$distcode);
		echo $data;
	}
	
	public function driverdb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->driverdb_filter_cnic($cnic);
		echo $data;
	}

	public function facility_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$fatype = $this -> uri -> segment(5);
		$distcode = $this -> uri -> segment(6);
		$data = $this -> Ajax_calls_model -> facility_filter($page, $tcode, $fatype,$distcode);
		echo $data;
	}

	public function getFacitityLhs() {

		$facode = $this -> uri -> segment(3);
		
		$data = $this -> Ajax_calls_model -> getFacitityLhs($facode);
		echo $data;
	}
	
	public function getFacilities() {
		$data = $this -> Ajax_calls_model -> getFacilities();
		echo $data;
	}
	public function getFacilitiesforYear() {
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_calls_model-> getFacilitiesforYear($year);
		echo $data;
	}
	public function getFacility_Record() {
		$year = $this-> input-> post('year');	
		$facode = $this-> input-> post('facode');	
		$data = $this-> Ajax_calls_model-> getFacility_Record($year,$facode);
		echo $data;
	}
	public function getIncharge() {
		$data = $this -> Ajax_calls_model -> getIncharge();
		echo $data;
	}
	public function getSupervisor() {
		$data = $this -> Ajax_calls_model -> getSupervisor();
		echo json_encode($data);
	}
	public function getVccname() {
		$data = $this -> Ajax_calls_model -> getVccname();
		echo $data;
	}
	public function getTargetChildern() {
		$data = $this -> Ajax_calls_model -> getTargetChildern();
		echo $data;
	}
	public function getTehsils() {
			
			$data = $this -> Ajax_calls_model -> getTehsils();	
			echo $data;	
		}
	public function getFacilitiesTHS() {
		
		$data = $this -> Ajax_calls_model -> getFacilitiesTHS();

		echo $data;
	}
	public function getFacilityLHW() {	
		
			$facode = $this -> input -> post('facode');	
			$tcode = $this -> input -> post('tcode');
			$data = $this -> Ajax_calls_model -> getFacilityLHW($facode,$tcode);	
			echo $data;	
	}
	
	public function getUnC() {

		$tcode = ($this -> input -> post('tcode'))?$this -> input -> post('tcode'):$this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model -> getUnC($tcode);
		echo $data;
	}
	public function getDistUnC() {

		$distcode = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model -> getDistUnC($distcode);
		echo $data;
	}
	
	public function getLhwData() {

		$techniciancode = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model -> getLhwData($techniciancode);
		echo $data;
	}
	
	public function checkCodes() {
		$supervisornewcode = $this->input->get('supervisornewcode'); 
		$supervisorcode = $this->input->get('supervisorcode');
		$techniciancode = $this->input->get('techniciancode');
		$facodew = $this->input->get('facodew');
		$facodecct = $this->input->get('facodecct');
		$facodem = $this->input->get('facodem');
		$distcodedriver = $this->input->get('distcodedriver');
		$distcodeas = $this->input->get('distcodeas');
		$distcodeco = $this->input->get('distcodeco');
		$distcodeccm = $this->input->get('distcodeccm');
		$distcodecco = $this->input->get('distcodecco');
		$distcodecct = $this->input->get('distcodecct');
		$distcodego = $this->input->get('distcodego');
		$chkdsocode = $this->input->get('chkdsocode');
		$dsocode = $this->input->get('dsocode');
		$chkcctcode = $this->input->get('chkcctcode');
		$cctcode = $this->input->get('cctcode');
		$chkccmcode = $this->input->get('chkccmcode');
		$ccmcode = $this->input->get('ccmcode');
		$chkccgcode = $this->input->get('chkccgcode');
		$ccgcode = $this->input->get('ccgcode');
		$chkccdcode = $this->input->get('chkccdcode');
		$ccdcode = $this->input->get('ccdcode');
		$deodcode = $this->input->get('distcodedeo');
		$skdcode = $this->input->get('distskcode');
		//$chkhrcode = $this->input->get('chkhrcode');
		$hrcode = $this->input->get('hrcode');
		$cocode = $this->input->get('cocode');
		$spcode = $this->input->get('spcode');
		$mfpcode = $this->input->get('distcodemfp');
		$data=$this -> Ajax_calls_model -> checkCodes($spcode,$cocode,$hrcode,$supervisornewcode,$supervisorcode,$techniciancode,$facodew,$distcodedriver,$distcodeas,$distcodeco,$distcodeccm,$distcodego,$distcodecco,$distcodecct,$facodecct,$chkdsocode,$dsocode,$chkcctcode,$cctcode, $chkccmcode,$ccmcode, $chkccgcode,$ccgcode, $chkccdcode,$ccdcode,$facodem,$deodcode,$skdcode,$mfpcode);
		echo $data;
	}	
		public function skdb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->skdb_filter_cnic($cnic);
		echo $data;
	}
		public function checkskNIC(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkskNIC($nic,$code,$dicode);
		echo $data;

	}
		public function skdb_filter() {

		$page = $this -> uri -> segment(3);
		
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$data = $this -> Ajax_calls_model ->skdb_filter($page,$status,$distcode);
		
		echo $data;
	}
		public function deodb_filter() {

		$page = $this -> uri -> segment(3);
		$status = $this -> uri -> segment(4);
		$distcode = $this -> uri -> segment(5);
		$name = $this -> uri -> segment(6);
		
		$data = $this -> Ajax_calls_model -> deodb_filter($page,$status,$distcode,$name);
		echo $data;
	}
	
	public function deodb_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->deodb_filter_cnic($cnic);
		echo $data;
	}
	public function checkdeoNIC(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkdeoNIC($nic,$code);
		echo $data;

	}
	public function generate_measles_case_code() {
		echo $case_epi_no = $this->input->get('case_epi_no');
		$data=$this -> Ajax_calls_model -> generate_measles_case_code($case_epi_no);
		echo $data;
	}
	public function generateCode() {
		
		
		$distcode = $this->input->get('distcode');
		
		$data=$this -> Ajax_calls_model -> generateCode($distcode);
		echo $data;
	}
	public function fmvrf_filter() {
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		//$fatype = $this->input->get('fatype');
		$techname = $this->input->get('vacc_name');
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> fmvrf_filter($facode,$distcode,$year,$month,$techname,$uncode);
		echo $data;
	}
	public function fac_mvrf_filter() {
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		//$fatype = $this->input->get('fatype');
		$techname = $this->input->get('vacc_name');
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> fac_mvrf_filter($facode,$distcode,$year,$month,$techname,$uncode);
		echo $data;
	}
	public function weekly_vpd_filter() {
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$case_type = $this->input->get('case_type');  
		
		$data=$this -> Ajax_calls_model -> weekly_vpd_filter($facode,$distcode,$year,$week,$case_type);
		echo $data;
	}
	public function lhwmr_filter() {
		
		$facode = $this->input->get('facode');
		$fmonth = $this->input->get('ym');
		
		$data=$this -> Ajax_calls_model -> lhwmr_filter($facode,$fmonth);
		echo $data;
	}
	public function dmr_filter() {
		
		$facode = $this -> input -> get('facode');
		
		$fmonth = $this -> input -> get('ym');
		
		$distcode =  $this -> input -> get('distcode');
		
		$data=$this -> Ajax_calls_model -> dmr_filter($facode,$fmonth,$distcode);
		echo $data;
	}
	
	public function mark_facility_filter(){

		$tcode = $this -> input -> get('tcode');

		$fatype = $this -> uri -> segment(4);

		$data=$this -> Ajax_calls_model -> mark_facility_filter($tcode,$fatype);

		echo $data;


	}
	public function getMonthswithCurrent()
	{
		getAllMonthsOptionsIncludingCurrent();
	}
	public function getMonths()
	{
		getAllMonthsOptions();
	}
	public function getMonths_aug2020()
	{	$years = $this -> input -> post('year');
		getAllMonthsOptions_aug2020(false,$years);
	}
	public function getReportingMonths()
	{
		getMonthsOptionsTillPrevious();
	}

	public function getMonthsHF()
	{

		$year = $this -> input -> post('year');
		if($year!=''){
			getAllMonthsOptionsIncludingCurrent(false,true);
		}
		else{
			$output = '<option value=""></option>';	
			echo $output;
		}
	}
	public function quickSearch(){

		$searchParam = $this->input->get('searchParam');
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		$fatype = $this->input->get('fatype');

		$data=$this -> Ajax_calls_model -> searchParam($facode,$distcode,$fmonth,$fatype,$searchParam);

		echo $data;
	}

	public function fastSearch(){

		$findParam = $this->input->get('findParam');
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		$fatype = $this->input->get('fatype');

		$data=$this -> Ajax_calls_model -> findParam($facode,$distcode,$fmonth,$fatype,$findParam);

		echo $data;
	}
	
	public function aefiSearch(){

		$searchParam = $this->input->post('searchParam');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$complaint = $this->input->post('complaints');
		$distcode = $this->input->post('distcode');
		$tcode = $this->input->post('tcode');
		$uncode = $this->input->post('uncode');
		$facode = $this->input->post('facode');

		echo $this -> Ajax_calls_model -> aefiSearch($distcode,$tcode,$uncode,$facode,$complaint,$searchParam,$year,$week); 
	}
	public function mangEpiVaccSearch(){

		$searchParam = $this->input->post('searchParam');
		
		$ym = $this->input->post('ym'); 
		$distcode = $this->input->post('distcode');
		$uncode = $this->input->post('uncode');

		echo $this -> Ajax_calls_model -> mangEpiVaccSearch($distcode,$ym,$uncode,$searchParam);
	}
	public function vaccCrFormSearch(){

		$searchParam = $this->input->post('searchParam');
		
		$ym = $this->input->post('ym'); 
		$distcode = $this->input->post('distcode');
		$facode = $this->input->post('facode');

		echo $this -> Ajax_calls_model -> vaccCrFormSearch($distcode,$ym,$facode,$searchParam);
	}
	public function weeklyVpdSearch(){

		$searchParam = $this->input->post('searchParam');
		
		$ym = $this->input->post('ym'); 
		$distcode = $this->input->post('distcode');
		$fatype = $this->input->post('fatype');
		$facode = $this->input->post('facode');

		echo $this -> Ajax_calls_model -> weeklyVpdSearch($distcode,$ym,$fatype,$facode,$searchParam);
	}
	public function getUnC_options($selectedUncode=0) {
		if(isset($_POST["distcode"]))
		{
			$distcode = $_POST["distcode"];
		}else{
			$distcode = NULL;
		}
		if(isset($_POST["tcode"]))
		{
			$tcode = $_POST["tcode"];
		}else{
			$tcode = NULL;
		}
		$data = getUCs(true,$tcode);

		foreach ($data as $one) { 
			$selected = '';
			if(($selectedUncode > 0) && ($selectedUncode == $one["uncode"]))
			{
				$selected = 'selected="selected"';
			}
			$output .= '<option value="'.$one["uncode"].'" '.$selected.' >'.$one["un_name"].'</option>';
		}
		//echo 
		echo $output;exit;
	}
	public function manageEpiVaccmr_filter() {
		
		$uncode = $this->input->get('uncode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		
		$data=$this -> Ajax_calls_model -> manageEpiVaccmr_filter($uncode,$distcode,$fmonth);
		echo $data;
	}
	public function vacc_cr_mr_filter() {
		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		
		$data=$this -> Ajax_calls_model -> vacc_cr_mr_filter($facode,$distcode,$fmonth);
		echo $data;
	}
	public function form_a1_filter(){
		//print_r($this->input->get());exit;
		$distcode = $this->input->get('distcode');
		$status = $this->input->get('status');
		$data=$this -> Ajax_calls_model -> form_a1_filter($distcode,$status);
		echo $data;
	}
	public function form_a1_fed_filter(){
		$datefrom = ($this -> input -> post('datefrom'))?date('Y-m-d',strtotime($this -> input -> post('datefrom'))):NULL;
		$dateto = ($this -> input -> post('dateto'))?date('Y-m-d',strtotime($this -> input -> post('dateto'))):NULL;
		
		$data=$this -> Ajax_calls_model -> form_a1_fed_filter($datefrom,$dateto); 
		echo $data;
	}
	public function form_a2_filter(){
		$facode = $this->input->get('facode');
		$data=$this -> Ajax_calls_model -> form_a2_filter($facode);
		echo $data;
	}
	public function form_b_filter(){
		
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$data=$this -> Ajax_calls_model -> form_b_filter($facode,$year, $month);
		echo $data;
	}
	public function form_b_consumption_filter(){
		
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$data=$this -> Ajax_calls_model -> form_b_consumption_filter($facode,$year, $month);
		echo $data;
	}
	public function form_b_adjustment_filter(){
		
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$data=$this -> Ajax_calls_model -> form_b_adjustment_filter($facode,$year, $month);
		echo $data;
	}
	public function consumption_vaccination_filter(){
		
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$data=$this -> Ajax_calls_model -> consumption_vaccination_filter($facode,$year, $month);
		echo $data;
	}
	public function form_c_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> form_c_filter($uncode);
		echo $data;
	}
	public function nnt_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> nnt_linelist_filter($uncode);
		echo $data;
	}
	public function measles_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> measles_linelist_filter($uncode);
		echo $data;
	}
	public function diphtheria_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> diphtheria_linelist_filter($uncode);
		echo $data;
	}
	public function pneumonia_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> pneumonia_linelist_filter($uncode);
		echo $data;
	}
	public function pertussis_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> pertussis_linelist_filter($uncode);
		echo $data;
	}
	public function childhood_tb_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> childhood_tb_linelist_filter($uncode);
		echo $data;
	}
	public function afp_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_calls_model -> afp_linelist_filter($uncode);
		echo $data;
	}
	public function measle_investigation_filter(){
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_calls_model -> measle_investigation_filter($facode,$year,$week);
		echo $data;
	}
	public function afp_investigation_filter(){
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_calls_model -> afp_investigation_filter($facode,$year,$week);
		echo $data;
	}
	public function nnt_investigation_filter(){
		$investigated_by = $this->input->get('investigated_by');
		$uncode = $this->input->get('uncode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week =$this->input->get('week');	  
		$data=$this -> Ajax_calls_model -> nnt_investigation_filter($investigated_by,$uncode,$facode,$year,$week);		
		echo $data;
	}
	public function zero_reporting_filter(){
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_calls_model -> zero_reporting_filter($year,$week);
		echo $data;
	}
	public function checkDsoNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkDsoNic($nic,$code);
		echo $data;

	}
	public function checkHrNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkHrNic($nic,$code);
		echo $data;

	}
	public function checkCCTNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCCTNic($nic,$code);
		echo $data;

	}
	public function checkCCMNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCCMNic($nic,$code);
		echo $data;

	}
	public function checkCCGNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCCGNic($nic,$code);
		echo $data;

	}
	public function checkCCDNic(){

		$nic = $this->input->post('nic');
		$code = $this->input->post('code');
		$data=$this -> Ajax_calls_model -> checkCCDNic($nic,$code);
		echo $data;

	}
	public function dso_filter() {

		$page = $this -> uri -> segment(3);
		$employee_type = $this -> uri -> segment(4);
		$status = $this -> uri -> segment(5);
		$facode = $this -> uri -> segment(6);
		$fatype = $this -> uri -> segment(7);
		$distcode = $this -> uri -> segment(8);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> dso_filter($page, $employee_type, $status, $facode,$fatype,$distcode);
		echo $data;
	}
	public function dso_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->dso_filter_cnic($cnic);
		echo $data;
	}
	public function cct_filter() {

		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$uncode = $this -> uri -> segment(6);
		$facode = $this -> uri -> segment(7);
		$fatype = $this -> uri -> segment(8);
		
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> cct_filter($page,$distcode,$tcode, $uncode, $facode,$fatype);
		echo $data;
	}
	public function cct_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->cct_filter_cnic($cnic);
		echo $data;
	}
	public function ccm_filter() {

		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$uncode = $this -> uri -> segment(6);
		$facode = $this -> uri -> segment(7);
		$fatype = $this -> uri -> segment(8);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> ccm_filter($page,$distcode,$tcode, $uncode, $facode,$fatype);
		echo $data;
	}
	public function ccm_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->ccm_filter_cnic($cnic);
		echo $data;
	}
	public function ccg_filter() {

		$page = $this -> uri -> segment(3);
		$distcode = $this -> uri -> segment(4);
		$tcode = $this -> uri -> segment(5);
		$uncode = $this -> uri -> segment(6);
		$facode = $this -> uri -> segment(7);
		$fatype = $this -> uri -> segment(8);		
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> ccg_filter($page, $distcode, $tcode, $uncode, $facode,$fatype);
		echo $data;
	}
	public function ccg_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->ccg_filter_cnic($cnic);
		echo $data;
	}
	public function ccd_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> ccd_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}
	public function ccd_filter_cnic(){
		$cnic = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model ->ccd_filter_cnic($cnic);
		echo $data;
	}

	public function rev_health_facility_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> rev_health_facility_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}

	public function refrigerator_questionnaire_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> refrigerator_questionnaire_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}
	public function vaccine_carriers_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> vaccine_carriers_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}

	public function coldroom_questionnaire_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> coldroom_questionnaire_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}

	public function voltage_questionnaire_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> voltage_questionnaire_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}

	public function generator_questionnaire_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> generator_questionnaire_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}

	public function transport_questionnaire_filter() {

		$page = $this -> uri -> segment(3);
		$tcode = $this -> uri -> segment(4);
		$facode = $this -> uri -> segment(5);
		$fatype = $this -> uri -> segment(6);
		$distcode = $this -> uri -> segment(7);
		//echo $page."-".$tcode."-".$facode;exit();
		$data = $this -> Ajax_calls_model -> transport_questionnaire_filter($page, $tcode, $facode,$fatype,$distcode);
		echo $data;
	}
	
	public function checkMonthHFform() {
		$year = $this -> input -> post('year');
		$month = $this -> input -> post('month');
		$facode = $this -> input -> post('facode');
		//$month = $month - 1;
		$data = $this -> Ajax_calls_model -> checkMonthHFform($facode, $month, $year);
		echo $data;
	}
	
	public function getHFOpeningBal(){

		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');
		
		$data=$this -> Ajax_calls_model -> getHFOpeningBal($month,$year,$facode);
		echo $data;
	}
	public function getHFRepOpeningBal(){

		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');
		
		$data=$this -> Ajax_calls_model -> getHFRepOpeningBal($month,$year,$facode);
		echo $data;
	}
	public function getHFChildVaccBal(){

		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');
		
		$data=$this -> Ajax_calls_model -> getHFChildVaccBal($month,$year,$facode);
		echo $data;
	}
	public function getAfpNumber() {
			$year = $this -> input -> post('year');
			$epid_code = $this -> input -> post('epid_code');
			$data = $this -> Ajax_calls_model -> getAfpNumber($year, $epid_code);  
			echo $data;
	}
	public function validateAfpNumber() { 
		$afpNumber = $this -> input -> post('afpNumber');
		$data = $this -> Ajax_calls_model -> validateAfpNumber($afpNumber);
		echo $data; 
	} 
	public function createReport(){
		$rep_title = $this->input->post('title'); 
		$fIds = $this->input->post('fIds');
		$lastsgment = $this->input->post('lastsgment');
		$reportid = $this->input->post('reportid');
		$tbl_select = $this->input->post('tbl_select');
		$data=$this -> Ajax_calls_model -> createReport($rep_title,$fIds,$lastsgment,$reportid,$tbl_select);
		echo $data;
    }
	public function getSecFields(){
		$sec = $this->input->post('sec');
		$lastsgment = $this->input->post('lastsgment');
		$data=$this -> Ajax_calls_model -> getSecFields($sec,$lastsgment);
		echo $data;
	}
	public function ids_report_filter() {
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fweek = $this->input->get('ym');
		$fatype = $this->input->get('fatype');
		$data=$this -> Ajax_calls_model -> ids_report_filter($facode,$distcode,$fweek,$fatype);
		echo $data;
	}
	public function idsreportSearch(){
		$searchParam = $this->input->post('searchParam');
		$ym = $this->input->post('ym'); 
		$distcode = $this->input->post('distcode');
		$fatype = $this->input->post('fatype');
		$facode = $this->input->post('facode');
		echo $this -> Ajax_calls_model -> idsreportSearch($distcode,$ym,$fatype,$facode,$searchParam);
	}
	public function getmonthlynewborn_target(){
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');
		$data=$this -> Ajax_calls_model -> getmonthlynewborn_target($year,$facode);
		echo $data;
	}
	
	public function check_week_zero_report(){

		$epiweek = $this -> input -> post('epiweek');
		$year = $this -> input -> post('year');
		$distcode = $this -> input -> post('distcode');
		$data=$this -> Ajax_calls_model -> check_week_zero_report($epiweek,$year,$distcode);
		echo $data;

	}
	public function getEPIVaccinationBalance(){
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');
		
		$data=$this -> Ajax_calls_model -> getEPIVaccinationBalance($month,$year,$facode);
		echo $data;
		
	}
	public function getdoses_per_vial(){
		$vaccine_type = $this->input->post('vaccine_type');
		$data=$this -> Ajax_calls_model -> getdoses_per_vial($vaccine_type);
		echo $data;
		
	}
	public function form_c_filter_new(){
		$campaign_type = $this->input->get('campaign_type');
		$data=$this -> Ajax_calls_model -> form_c_filter_new($campaign_type);
		echo $data;
	}
	public function validateExistRecord() { 
		$facode = $this -> input-> post('facode');
		$year = $this -> input-> post('year');
		$month = $this -> input-> post('month');
		$table = $this -> input ->post('table');
		$edit = $this->input->post('edit')?$this->input->post('edit'):0;
		//echo $edit;exit;
		$fmonth = $year."-".$month;
		freezeReport($table,$facode,$fmonth,TRUE);
		if($edit == '1')
			$month = Date("m", strtotime($year . "-" . $month . "-01" . " +1 month"));
		$monthPrevious = date("m", strtotime("first day of previous month"));
		//$table = 'fac_mvrf_db';
		$fmonthSelected   = $year."-".$month;
		$fmonthPrevious   = $year."-".$monthPrevious;
		//$fmonthSelected;
		//$fmonthPrevious;
		$data = $this -> Ajax_calls_model -> validateExistRecord($table,$facode,$fmonthSelected,$fmonthPrevious);
		echo $data;
	}
	public function check_compiled_datasource() { 
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$data = $this -> Ajax_calls_model -> check_compiled_datasource($facode,$fmonth); 
		echo $data;
	}
	public function update_is_compiled() { 
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$data = $this -> Ajax_calls_model -> update_is_compiled($facode,$fmonth); 
		echo $data;
	}
	public function form_a2_filter_new(){
		$campaign_type = $this->input->get('campaign_type');
		$data=$this -> Ajax_calls_model -> form_a2_filter_new($campaign_type);
		echo $data;
	}
	
	public function getDistricts_options(){
		//$distcode = ($this -> session -> District)?$this -> session -> District:(($this->input->post('distcode'))?$this->input->post('distcode'):'');
		if($this->input->post('distcode') == '0' ){
			$distcode = 0;
		}
		else{
			$distcode = ($this -> session -> District)?$this -> session -> District:(($this->input->post('distcode'))?$this->input->post('distcode'):'');
		}
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"patient_address_distcode\" id=\"patient_address_distcode\" >";
		}
		$select .= ($distcode > 0)?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}	
	public function getDistricts_optionsNNT(){
		$distcode = ($this->input->post('distcode'))?$this->input->post('distcode'):'';
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"nnt_distcode\" id=\"nnt_distcode\" >";
		}
		$select .= ($this->input->post('distcode'))?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}
	public function getDistricts_optionsAFP(){
		$distcode = ($this->input->post('distcode'))?$this->input->post('distcode'):'';
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"patient_address_distcode\" id=\"patient_address_distcode\" >";
		}
		$select .= ($this->input->post('distcode'))?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}
	public function getDistricts_optionsNNTX(){
		$distcode = ($this->input->post('distcode'))?$this->input->post('distcode'):'';
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"tr_distcode\" id=\"tr_distcode\" >";
		}
		$select .= ($this->input->post('distcode'))?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}
	public function getDistricts_optionsWVPD(){
		$distcode = ($this->input->post('distcode'))?$this->input->post('distcode'):'';
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"case_distcode\" id=\"case_distcode\" >";
		}
		$select .= ($this->input->post('distcode'))?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}
	public function user_filter() {
		$user = $this -> uri -> segment(3);
		$data = $this -> Ajax_calls_model -> user_filter ($user);
		//echo json_encode($data); exit;
		echo json_encode($data);
	}
	public function facode_validation(){
		$week=$this->input->post('week');
		$year=$this->input->post('year');
		$fweek = $year ."-". sprintf('%02d',$week);
		$facode=$this->input->post('facode');
		$disease=$this->input->post('disease');
		$data=$this->Ajax_calls_model->facode_validation($fweek,$disease,$facode);
		echo json_encode($data);		
	}
	public function moonzerorepcomp(){
		$year=$this->input->post('fyear');
		$distcode=$this->input->post('distcode');
		$data=$this->Ajax_calls_model->moonzerorepcomp($year,$distcode);
		echo $data = '<td style="color:black;">'.implode("</td><td style=\"color:black;\">",$data).'</td>';
		//echo json_encode($data);		
	}
	public function moonzerorepcomp_data(){
		$year=$this->input->post('fyear');
		$distcode=$this->input->post('distcode');
		$dataresult=$this->Ajax_calls_model->moonzerorepcomp_data($year,$distcode);
		$data="insert into zeroreportcompliance(";
		$data.=implode(", ", array_keys($dataresult));
		$data.=",distcode,year) values (";
		$data.=implode(", ", array_values($dataresult));
		$data.=",$distcode,$year);";
		echo $data;
		echo '<br>';
		//print_r($data);exit;
		//$data ='<td style="color:black;">'.$data.'</td>';
		//echo json_encode($data);		
	}
	public function flcf_dataTables(){
		$wc = getWC();
		$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns)){
      		foreach ($columns as $key => $value) {
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
				 
      			if($_SESSION['UserLevel']=='2'){
					$column = str_replace('district', 'distcode', $column);
      				$column = str_replace('districtname', 'distcode', $column);
      			}elseif ($_SESSION['UserLevel']=='3'){
      				$column = str_replace('tehsilname', 'tcode', $column);
					$column = str_replace('tehsil', 'tcode', $column);
				}if( ! empty($search_value)){
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}if(isset($search)){
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(fac_name) LIKE '$keyword%' OR 
      					lower(fatype) LIKE '$keyword%' OR 
      					facode LIKE '$keyword%' OR 
      					areatype LIKE '$keyword%' OR
						uncode LIKE '$keyword%' OR 
      					tcode LIKE '$keyword%' OR
						func_status LIKE '$keyword%' OR 
      					rep_status LIKE '$keyword%' OR 
      					is_vacc_fac LIKE '$keyword%' OR 
      					is_ds_fac LIKE '$keyword%' )";
	  	}else{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
		if(!empty($order)){
            foreach($order as $o){
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
				$columns_valid = array(
					"serial",
					"fac_name",
					"fatype",
					"facode",
					"areatype",
					"unioncouncil",
					"tcode",         
					"is_vacc_fac",
					"is_ds_fac",
					"total_technicians",
					
				);
		}else{
			$columns_valid = array(
					"serial",
					"fac_name",
					"fatype",
					"facode",
					"areatype",
					"unioncouncil",
					"tcode",
					"is_vacc_fac",
					"is_ds_fac",
					"total_technicians",
			);
		}

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by fac_name ";// "order by ".$columns_valid[$col].' '.$dir;
        }else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }
		$fmonth = date('Y-m');
		$curr_date = date('Y-m-d');
		$q = "SELECT epi_week_numb FROM epi_weeks WHERE date_from >='$curr_date' ORDER BY epi_week_numb LIMIT 1";
		$my_week = currentWeek(date('Y'), true); //$result->epi_week_numb;
		$result = $this ->db->query($q)->row();
		$fweek = date('Y').'-'.sprintf("%02d", $my_week);
		$query = "SELECT fac_name,fatype,facode,areatype,unname(uncode) as unioncouncil,tehsilname(tcode)as tehsil,catchment_area_pop,getfstatus_vacc('$fmonth',facode) as vacc_status,getfstatus_ds('$fweek',facode) as ds_status, is_vacc_fac,is_ds_fac,(select count(facode) from hr_db where hr_db.facode=facilities.facode and hr_sub_type_id='01') as total_technicians from facilities where hf_type='e' and $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
		$facilities = $this->db->query($query);
		$str = $this->db->last_query();
		$data = array();
        $i=$start+1;
        foreach($facilities->result() as $r) {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
	       		$data[] = array(
	                "serial" => $i,
	                "fac_name" => $r->fac_name,
	                "fatype" => $r->fatype,
	                "facode" => $r->facode,
	                "areatype" => $r->areatype,
					"unioncouncil" => $r->unioncouncil,
	                "tehsil" => $r->tehsil,
	                "vacc_status"  => $r->vacc_status,
					"ds_status" => $r->ds_status,
					"is_vacc_fac" => $r->is_vacc_fac,
					"is_ds_fac" => $r->is_ds_fac,
					"total_technicians" => $r->total_technicians
	               
	              
	            );
	     	}elseif (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='Manager') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "fac_name" => $r->fac_name,
	                "fatype" => $r->fatype,
	                "facode" => $r->facode,
	                "areatype" => $r->areatype,
					"unioncouncil" => $r->unioncouncil,
	                "tehsil" => $r->tehsil,
					"vacc_status"  => $r->vacc_status,
					"ds_status" => $r->ds_status,
					"is_vacc_fac" => $r->is_vacc_fac,
					"is_ds_fac" => $r->is_ds_fac,
					"total_technicians" => $r->total_technicians
	              
	            );
	     	}else{
	     		$data[] = array(
	                "serial" => $i,
	                "fac_name" => $r->fac_name,
	                "fatype" => $r->fatype,
	                "facode" => $r->facode,
	                "areatype" => $r->areatype,
					"unioncouncil" => $r->unioncouncil,
	                "tehsil" => $r->tehsil,
					"vacc_status"  => $r->vacc_status,
					"ds_status" => $r->ds_status,
					"is_vacc_fac" => $r->is_vacc_fac,
					"is_ds_fac" => $r->is_ds_fac,
					"total_technicians" => $r->total_technicians
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM facilities WHERE hf_type='e' and $wc $search $multiple_search";
		$total_facilities = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_facilities->num,
            "recordsFiltered" => $total_facilities->num,
            "data" => $data
        );
		echo json_encode($output);
        exit();
	}
	public function supervisor_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM supervisordb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_supervisor = $this->db->query($query)->row();
	  	//echo json_encode($total_supervisor);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
				//print_r($column); 
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
					//$column = 'status' $column);
      			}
				/* elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('status', 'status', $column);
      			} */
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(supervisorname) LIKE '$keyword%' OR 
      					lower(supervisor_type) LIKE '$keyword%' OR 
      					supervisorcode LIKE '$keyword%' OR 
      					phone LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
		//print_r($order);exit;
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
//echo $dir;exit;
        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
				$columns_valid = array(
					"serial",
					"supervisorname",
					"supervisor_type",
					"phone",
					"nic",
					"tehsilname",
					"status",
					"is_temp_saved",
				);
		}
		else{
			$columns_valid = array(
					"serial",
					"supervisorname",
					"supervisor_type",
					"phone",
					"nic",
					"districtname",
					"status",
					"is_temp_saved",
				);
		}

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }
//echo $order;exit;
    
        $query = "select supervisorname,supervisorcode,supervisor_type,phone,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,districtname(supervisordb.distcode) as districtname,tehsilname(supervisordb.tcode) as tehsilname,status from supervisordb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
       //echo $query;exit;
		$supervisors = $this->db->query($query);
		//$str = $this->db->last_query();
		//print_r($str); exit;
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($supervisors->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "supervisorname" => $r->supervisorname,
	                "supervisor_type" => $r->supervisor_type,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                "supervisorcode" => $r->supervisorcode,
	            );
	     	}
			elseif (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='Manager') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "supervisorname" => $r->supervisorname,
	                "supervisor_type" => $r->supervisor_type,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                "supervisorcode" => $r->supervisorcode,
					"districtname" => $r->districtname,
	            );
	     	}
			
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "supervisorname" => $r->supervisorname,
	                "supervisor_type" => $r->supervisor_type,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
					"supervisorcode" => $r->supervisorcode
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM supervisordb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_supervisor = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_supervisor->num,
            "recordsFiltered" => $total_supervisor->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
		//AddHR
	public function addhr_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM hrdb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_dsodb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			/* if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			} */
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      //	echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(hrname) LIKE '$keyword%' OR 
                        lower(designation_type) LIKE '$keyword%' OR 			
      					lower(employee_type) LIKE '$keyword%' OR 
      					hrcode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR 
      					phone LIKE '$keyword%' OR
						telephone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "serial",
            "designation_type",
			"nic",
			"telephone",
			"phone",
            "employee_type",
            "hrname",
            "status",
            "is_temp_saved",
        );

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select hrname,designation_type,hrcode,employee_type,
		CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,telephone,
		phone,status from hrdb 
		where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
       //echo $query;exit;
		$supervisors = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($supervisors->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "designation_type" => $r->designation_type,
	                "employee_type" => $r->employee_type,
	                "hrcode" => $r->hrcode,
	                "telephone" => $r->telephone,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "hrname" => $r->hrname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "hrname" => $r->hrname,
	                "employee_type" => $r->employee_type,
	                "hrcode" => $r->hrcode,
	                "telephone" => $r->telephone,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "designation_type" => $r->designation_type,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
			$query = "SELECT COUNT(*) AS num FROM hrdb WHERE $wc $search $multiple_search";
			//echo $query;exit;
	  		$total_hrdb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_hrdb->num,
            "recordsFiltered" => $total_hrdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	
	//EndAddHR

public function dso_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM dsodb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_dsodb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(dsoname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					dsocode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR 
      					phone LIKE '$keyword%' OR
						telephone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "serial",
            "dsoname",
			"nic",
			"telephone",
			"phone",
            "employee_type",
            "districtname",
            "status",
            "is_temp_saved",
        );

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select dsoname,dsocode,employee_type,
		CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,telephone,
		phone,districtname(dsodb.distcode) as districtname,status from dsodb 
		where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
       //echo $query;exit;
		$supervisors = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($supervisors->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "dsoname" => $r->dsoname,
	                "employee_type" => $r->employee_type,
	                "dsocode" => $r->dsocode,
	                "telephone" => $r->telephone,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "dsoname" => $r->dsoname,
	                "employee_type" => $r->employee_type,
	                "dsocode" => $r->dsocode,
	                "telephone" => $r->telephone,
	                "phone" => $r->phone,
	                "nic" => $r->nic,
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
			$query = "SELECT COUNT(*) AS num FROM dsodb WHERE $wc $search $multiple_search";
			//echo $query;exit;
	  		$total_dsodb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_dsodb->num,
            "recordsFiltered" => $total_dsodb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	public function co_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(coname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					cocode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "coname",
            "nic",
			"phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "cocode",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "coname",
			"nic",
			"phone",
			"employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "cocode",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select coname,cocode,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(codb.distcode) as districtname,tehsilname(codb.tcode) as tehsilname,status from codb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "coname" => $r->coname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cocode" => $r->cocode,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
				   "districtname" => $r->districtname,
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "coname" => $r->coname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cocode" => $r->cocode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_codb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_codb->num,
            "recordsFiltered" => $total_codb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function mfp_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(mfpname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					mfpcode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "mfpname",
            "nic",
			"phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "mfpcode",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "mfpname",
			"nic",
			"phone",
			"employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "mfpcode",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select mfpname,mfpcode,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(mfpdb.distcode) as districtname,tehsilname(mfpdb.tcode) as tehsilname,status from mfpdb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "mfpname" => $r->mfpname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "mfpcode" => $r->mfpcode,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
				   "districtname" => $r->districtname,
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "mfpname" => $r->mfpname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "mfpcode" => $r->mfpcode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM mfpdb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_mfpdb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_mfpdb->num,
            "recordsFiltered" => $total_mfpdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	

	public function do_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM deodb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_dodb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(deoname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					deocode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "serial",
            "deoname",
             "nic",
             "phone",
            "employee_type",
            
           
            "districtname",
            "status",
            "is_temp_saved",
            "deocode",
        );

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select deoname,deocode,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(deodb.distcode) as districtname,status from deodb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "deoname" => $r->deoname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "deocode" => $r->deocode,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "deoname" => $r->deoname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "deocode" => $r->deocode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM deodb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_deodb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_deodb->num,
            "recordsFiltered" => $total_deodb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	public function sk_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM skdb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_skdb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(skname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					skcode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
				$columns_valid = array(
					"serial",
					"skname",
					 "nic",
					 "phone",
					"employee_type",
					
				   
					"tehsilname",
					"status",
					"is_temp_saved",
					"skcode",
				);
		}else
		{
			$columns_valid = array(
					"serial",
					"skname",
					 "nic",
					 "phone",
					"employee_type",
					
				   
					"districtname",
					"status",
					"is_temp_saved",
					"skcode",
				);
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select skname,skcode,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(skdb.distcode) as districtname,tehsilname(skdb.tcode) as tehsilname,status from skdb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "skname" => $r->skname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "skcode" => $r->skcode,
	                "phone" => $r->phone,
	               
	                
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "skname" => $r->skname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "skcode" => $r->skcode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
        $query = "SELECT COUNT(*) AS num FROM skdb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_skdb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_skdb->num,
            "recordsFiltered" => $total_skdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	public function dr_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM driverdb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_driverdb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(drivername) LIKE '$keyword%' OR 
      					
      					drivercode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if(($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){
			$columns_valid = array(
				"serial",
				"drivername",
				"drivercode",
				"nic",
				"phone",
				"tehsilname",
				"status",
				"is_temp_saved",
				
			);
		}else
		{
			$columns_valid = array(
            "serial",
            "drivername",
			"nic",
			"phone",
            /*"employee_type",*/
			"drivercode",
			"districtname",
            "status",
            "is_temp_saved",
            
        );
		}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

          $query = "select drivername,drivercode,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(driverdb.distcode) as districtname,tehsilname(driverdb.distcode) as tehsilname,status from driverdb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$driver = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($driver->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "drivername" => $r->drivername,
	                "nic" => $r->nic,
	               /* "employee_type" => $r->employee_type,*/
	                "drivercode" => $r->drivercode,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                
	                "tehsilname" => $r->tehsilname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "drivername" => $r->drivername,
	                "nic" => $r->nic,
	                /*"employee_type" => $r->employee_type,*/
	                "drivercode" => $r->drivercode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
        $query = "SELECT COUNT(*) AS num FROM driverdb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_driverdb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_driverdb->num,
            "recordsFiltered" => $total_driverdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	public function tech_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM techniciandb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_techdb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
		//print_r($columns);exit;
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	$multiple_search = str_replace('facilitytype','facilitytype(techniciandb.facode)',$multiple_search);
      	//echo $multiple_search;exit;
		if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(technicianname) LIKE '$keyword%' OR 
      					
      					techniciancode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR 
						facilitytype(techniciandb.facode) LIKE '$keyword' OR
						phone LIKE '$keyword%')";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "serial",
            "technicianname",
             "fathername",
             "nic",
             "phone",
            "facilityname",
            "facilitytype",
            "districtname",
			"catch_area_pop",
			"status",
			"is_temp_saved",
			"techniciancode",
        );

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

          $query = "select technicianname,fathername,techniciancode,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,catch_area_pop,districtname(techniciandb.distcode) as districtname,facilityname(techniciandb.facode) as facilityname,facilitytype(techniciandb.facode) as facilitytype,status from techniciandb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
      // echo $query;exit;
		$driver = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($driver->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "technicianname" => $r->technicianname,
	                "fathername" => $r->fathername,
	               /* "employee_type" => $r->employee_type,*/
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                "catch_area_pop" => $r->catch_area_pop,
	                "facilityname" => $r->facilityname,
	                "facilitytype" => $r->facilitytype,
	                "districtname" => $r->districtname,
	                "techniciancode" => $r->techniciancode,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "technicianname" => $r->technicianname,
	                "fathername" => $r->fathername,
	                /*"employee_type" => $r->employee_type,*/
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "facilityname" => $r->facilityname,
	                 "facilitytype" => $r->facilitytype,
	                "districtname" => $r->districtname,
	                "catch_area_pop" => $r->catch_area_pop,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
					"techniciancode" => $r->techniciancode,
	            );
	     	}
            
            $i++;
        }
       $query = "SELECT COUNT(*) AS num FROM techniciandb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_techdb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_techdb->num,
            "recordsFiltered" => $total_techdb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}

	public function med_dataTables()
	{
		$wc = getWC();//helper function
		
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      //	echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('districtname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(technicianname) LIKE '$keyword%' OR 
      					distcode LIKE '$keyword%' OR
      					tcode LIKE '$keyword%' OR 
      					
      					facode LIKE '$keyword%' OR 
      					

      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }

        $columns_valid = array(
            "serial",
            "technicianname",
             "fathername",
             "nic",
             "phone",
			"supervisorname",
			"unioncouncil",
            "facilityname",
            "facilitytype",
            "districtname",
			"catch_area_pop",
			"status",
			"is_temp_saved",
			"techniciancode",
        );

        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

          $query = "select technicianname,fathername,techniciancode,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,catch_area_pop,phone,unname(med_techniciandb.uncode) as unioncouncil,supervisorname(med_techniciandb.supervisorcode) as supervisorname,districtname(med_techniciandb.distcode) as districtname,facilityname(med_techniciandb.facode) as facilityname,facilitytype(med_techniciandb.facode) as facilitytype,status from med_techniciandb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$driver = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($driver->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "technicianname" => $r->technicianname,
	                "fathername" => $r->fathername,
	               /* "employee_type" => $r->employee_type,*/
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	               "unioncouncil" => $r->unioncouncil,
	                "supervisorname" => $r->supervisorname,
	                "facilityname" => $r->facilityname,
	                "facilitytype" => $r->facilitytype,
	                "is_temp_saved" => $r->is_temp_saved,
	                "techniciancode" => $r->techniciancode,
	                "catch_area_pop" => $r->catch_area_pop,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
			elseif (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='Manager') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "technicianname" => $r->technicianname,
	                "fathername" => $r->fathername,
	               /* "employee_type" => $r->employee_type,*/
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	               "unioncouncil" => $r->unioncouncil,
	                "supervisorname" => $r->supervisorname,
	                "facilityname" => $r->facilityname,
	                "facilitytype" => $r->facilitytype,
					"districtname" => $r->districtname,
	                "is_temp_saved" => $r->is_temp_saved,
	                "techniciancode" => $r->techniciancode,
	                "catch_area_pop" => $r->catch_area_pop,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "technicianname" => $r->technicianname,
	                "fathername" => $r->fathername,
	                /*"employee_type" => $r->employee_type,*/
	                "nic" => $r->nic,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                "supervisorname" => $r->supervisorname,
	                "unioncouncil" => $r->unioncouncil,
	                "facilityname" => $r->facilityname,
	                 "facilitytype" => $r->facilitytype,
	                "districtname" => $r->districtname,
	                "techniciancode" => $r->techniciancode,
	                "catch_area_pop" => $r->catch_area_pop,
					"status" => $r->status,
					"is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
       $query = "SELECT COUNT(*) AS num FROM med_techniciandb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_meddb = $this->db->query($query)->row();
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_meddb->num,
            "recordsFiltered" => $total_meddb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function auto_asset()
	{
		$asset_id= $this->input->post('asset_type');
		$warehouse_id = $this->input->post('warehouse_id');
		$asset_name = $this->input->post('asset_name');
 		//query to get short name of the asset for asset auto id
		$assetidQ = "select short_name,pk_id from epi_cc_asset_types where pk_id= '$asset_id'";
		$result = $this->db->query($assetidQ)->result_array();
		$val = $result[0]['short_name'];
		//query for getting count of selected asset in selected warehouse
		$autoAssetId = "select count(asset_id) as count from epi_cc_coldchain_main where warehouse_id = {$warehouse_id} and ccm_asset_type_id = '$asset_id' ";
		//echo $autoAssetId;exit;
		$count = $this->db->query($autoAssetId)->result_array();
		$count = $count[0]['count'];
		//adding 1 to count i.e if 0 coldroom were present it will give 1
		$count = $count+1;
		//concatenating i.e CR-01 for 1st entry of coldroom
		//for generator,vehicle,icepack,vaccine carrier numeric asset auto id
		if($asset_id == '1' || $asset_id == '2' || $asset_id == '5'){
			if($count<10)
				$val = $val.'-0'.$count;
			else
				$val = $val.'-'.$count;
		}
		else
			$val = $val.$count;
		echo $val;
	}
	public function get_makers(){
		$assetTypeId = $this->input->post('asset_type');
		$makeQ = "select DISTINCT ccm_make_id,makername(ccm_make_id) as maker_name
					from epi_cc_models
					where ccm_asset_type_id = '$assetTypeId'";
		$allMakes = $this->db->query($makeQ)->result_array();
		$html = '<option value="">--Select--</option>';
		foreach($allMakes as $key => $val){
			$html .='<option value="'.$val['ccm_make_id'].'">'.$val['maker_name'].'</option>';
		}
		echo json_encode($html);
	}
	public function get_models(){
		$assetTypeId = $this->input->post('asset_type');
		$makerId = $this->input->post('makerid');
		$modelQ = "select pk_id,model_name
					from epi_cc_models
					where ccm_asset_type_id = '{$assetTypeId}' and ccm_make_id = '{$makerId}'";
		//echo $modelQ;exit;
		$model = $this->db->query($modelQ)->row();
		$html = '<option value="' . $model->pk_id . '">' . $model->model_name . '</option>';
		echo json_encode($html);
	}
	public function tempAdjustmentSave(){
		$recordArray = array(
			'adjustment_type'=>$this->input->post('adjustment_type'),
			'vacc_id'=>$this->input->post('vacc_id'),
			'adjustment_quantity'=>$this->input->post('adjustment_quantity'),
			'date'=>$this->input->post('date')
			);
		
		$this->Common_model -> insert_record('temp_adjusmtent',$recordArray);
		
	}
	public function getformId(){
		$id = $this->input->post('id');
		$formId = "select distinct max(form_id) as form_id from epi_stock_management";
		$formId = $this->db->query($formId)->result_array();
		print_r($formId[0]['form_id']);
	}
	public function getmodelData(){
		$id = $this->input->post('id');
		$mainId = $this->input->post('mainId');
		if($mainId==2){
			$mainId="9";
		}
		$modelqry = "select epi_cc_models.*,(select asset_type_name from epi_cc_asset_types where pk_id=epi_cc_models.ccm_sub_asset_type_id) as asset_sub_type_name ,epi_cc_asset_types.pk_id as assetsubtypeid,make_name,asset_type_name 
						from epi_cc_models 
					join epi_cc_makes on epi_cc_makes.pk_id=epi_cc_models.ccm_make_id
					join epi_cc_asset_types on epi_cc_asset_types.pk_id=epi_cc_models.asset_type_id 
					where epi_cc_models.pk_id='{$id}'";
		$result = $this->db->query($modelqry)->row_array();
		$varChecked1=$varChecked2=$varChecked3="";
		if($result['cfc_free']==2){
			$varChecked1='checked="checked"';
		}elseif($result['cfc_free']==1){
			$varChecked2="checked='checked'";
		}elseif($result['cfc_free']==0){
			$varChecked3="checked='checked'";
		}
		$data['cfc_free']='<div class="col-md-4"><label class="radio-inline radiopop"><input '.$varChecked1.' type="radio" name="cfc_free">NA</input></label></div><div class="col-md-4"><label class="radio-inline radiopop"><input disabled="disabled" '.$varChecked2.' type="radio" name="cfc_free">Yes</input></label></div><div class="col-md-4"><label class="radio-inline radiopop"><input disabled="disabled" '.$varChecked3.' type="radio" name="cfc_free">No</input></label></div>';
		$data['allData'] = $result;
		echo json_encode($data);
	}
	public function getModelsColdroom(){
		$id = $this->input->post('id');
		if($id=="Generic")
		{
			$wc = "where ccm_sub_asset_type_id='27' and is_active='1'";
		}
		else
		{
			$wc = "where ccm_make_id='{$id}' and is_active='1'";
		}
		$query="select pk_id,model_name from epi_cc_models {$wc}";
		$result = $this->db->query($query)->result_array();
		$return='<option value="">--Select--</option>';
		foreach($result as $values){
			$return .='<option value="'.$values['pk_id'].'">'.$values['model_name'].'</option>';
		}
		echo json_encode($return);
	}
	public function getTransportColdroom(){
		$id = $this->input->post('id');
        $wc = "where ccm_sub_asset_type_id='$id' and is_active='1'";
		$query="select pk_id,ccm_make_id,makername(ccm_make_id) as make_name from epi_cc_models {$wc}";
		//echo $query; exit;
		$result = $this->db->query($query)->result_array();
		$return='<option value="">--Select--</option>';
		foreach($result as $values){
			$return .='<option value="'.$values['ccm_make_id'].'">'.$values['make_name'].'</option>';
		}
		echo json_encode($return);
	}
	public function ccm_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(ccm_name) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					ccm_code LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "ccm_name",
             "nic",
			 "phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "ccm_code",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "ccm_name",
             "nic",
			 "phone",
            "employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "ccm_code",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select ccm_name,ccm_code,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(cc_mechanic.distcode) as districtname,tehsilname(cc_mechanic.tcode) as tehsilname,status from cc_mechanic where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "ccm_name" => $r->ccm_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "ccm_code" => $r->ccm_code,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                "districtname" => $r->districtname,
	                /* "tehsilname" => $r->tehsilname, */
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "ccm_name" => $r->ccm_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "ccm_code" => $r->ccm_code,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM cc_mechanic WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_codb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_codb->num,
            "recordsFiltered" => $total_codb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function go_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(go_name) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					go_code LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "go_name",
             "nic",
			 "phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "go_code",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "go_name",
             "nic",
			 "phone",
            "employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "go_code",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select go_name,go_code,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(go_db.distcode) as districtname,tehsilname(go_db.tcode) as tehsilname,status from go_db where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "go_name" => $r->go_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "go_code" => $r->go_code,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                "districtname" => $r->districtname,
	                /* "tehsilname" => $r->tehsilname, */
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "go_name" => $r->go_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "go_code" => $r->go_code,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM go_db WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_godb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_godb->num,
            "recordsFiltered" => $total_godb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function cco_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(cco_name) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					cco_code LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "cco_name",
             "nic",
			 "phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "cco_code",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "cco_name",
             "nic",
			 "phone",
            "employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "cco_code",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select cco_name,cco_code,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(cco_db.distcode) as districtname,tehsilname(cco_db.tcode) as tehsilname,status from cco_db where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "cco_name" => $r->cco_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cco_code" => $r->cco_code,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                "districtname" => $r->districtname,
	                /* "tehsilname" => $r->tehsilname, */
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "cco_name" => $r->cco_name,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cco_code" => $r->cco_code,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM cco_db WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_ccodb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_ccodb->num,
            "recordsFiltered" => $total_ccodb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	public function cc_tech_dataTables()
	{
		$wc = getWC();//helper function
		//$query = "SELECT COUNT(*) AS num FROM codb WHERE $wc";//$this->db->select("COUNT(*) as num")->get("supervisordb");
	  	//$total_codb = $this->db->query($query)->row();
	  	//echo json_encode($total_dsodb);exit;
	  	$draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $columns = $this->input->get("columns");
      	//echo json_encode($_GET);exit;
      	$multiple_search = "";
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($_SESSION['UserLevel']=='2')
      			{
      				$column = str_replace('districtname', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
      				$column = str_replace('tehsilname', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
      	//echo $multiple_search;exit;
      	if(isset($search))
      	{
  			$keyword = $search['value'];
      		$keyword = str_replace('_', ' ', $keyword);
      		$keyword = strtolower($keyword);
      		$search = " AND (lower(cc_technicianname) LIKE '$keyword%' OR 
      					lower(employee_type) LIKE '$keyword%' OR 
      					cc_techniciancode LIKE '$keyword%' OR 
      					nic LIKE '$keyword%' OR 
      					lower(status) LIKE '$keyword%' OR
						phone LIKE '$keyword%') ";
      		
      	}
      	else
      	{
      		$search = "";
      	}
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
        $columns_valid = array(
            "serial",
            "cc_technicianname",
             "nic",
			 "phone",
            "employee_type",
			"tehsilname",
            "status",
            "is_temp_saved",
            "cc_techniciancode",
        );
	}
	else{
			$columns_valid = array(
            "serial",
            "cc_technicianname",
             "nic",
			 "phone",
            "employee_type",
			"districtname",
            "status",
            "is_temp_saved",
            "cc_techniciancode",
        );
	}
        if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 1) {
            $order = " order by date_joining ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }

        $query = "select cc_technicianname,cc_techniciancode,employee_type,CASE WHEN is_temp_saved='0' THEN 'Not Submitted' ELSE 'Submitted' END as is_temp_saved,nic,phone,districtname(cc_techniciandb.distcode) as districtname,tehsilname(cc_techniciandb.tcode) as tehsilname,status from cc_techniciandb where $wc $search $multiple_search $order LIMIT {$length} OFFSET {$start}  ";
        //echo $query;exit;
		$operator = $this->db->query($query);
		//$supervisors = $this->db->get("supervisordb");//$this->books_model->get_books();
		
        $data = array();
        $i=$start+1;
        foreach($operator->result() as $r) 
        {
        	if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') )
			{
	       		$data[] = array(
	                "serial" => $i,
	                "cc_technicianname" => $r->cc_technicianname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cc_techniciancode" => $r->cc_techniciancode,
	                "phone" => $r->phone,
	               /* "cellphone" => $r->cellphone,*/
	                "districtname" => $r->districtname,
	                /* "tehsilname" => $r->tehsilname, */
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	                
	            );
	     	}
	     	else
	     	{
	     		$data[] = array(
	                "serial" => $i,
	                "cc_technicianname" => $r->cc_technicianname,
	                "nic" => $r->nic,
	                "employee_type" => $r->employee_type,
	                "cc_techniciancode" => $r->cc_techniciancode,
	                "phone" => $r->phone,
	                /*"cellphone" => $r->cellphone,*/
	                
	                "districtname" => $r->districtname,
	                "status" => $r->status,
	                "is_temp_saved" => $r->is_temp_saved,
	            );
	     	}
            
            $i++;
        }
		$query = "SELECT COUNT(*) AS num FROM cc_techniciandb WHERE $wc $search $multiple_search";
		//echo $query;exit;
	  	$total_cc_techniciandb = $this->db->query($query)->row();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_cc_techniciandb->num,
            "recordsFiltered" => $total_cc_techniciandb->num,
            "data" => $data
        );
        echo json_encode($output);
        exit();
	}
	
	//////////

	public function getcerv_villages() {
  		//$uncode = $this -> input -> post('uncode');
  		$facode = ($this -> input -> post('facode'))?$this -> input -> post('facode'):$this -> uri -> segment(3);
  		$data = $this -> Ajax_calls_model -> getcerv_villages($facode);
  		echo $data;
 	}
	/* 
	public function getfacilitiesby_uncode() {
  		//$uncode = $this -> input -> post('uncode');
  		$uncode = ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):$this -> uri -> segment(3);
  		$data = $this -> Ajax_calls_model -> getfacilitiesby_uncode($uncode);
  		echo $data;
 	} */
	
	
	////////////////////
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getVillages() {
  		//$uncode = $this -> input -> post('uncode');
  		$uncode = ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):$this -> uri -> segment(3);
  		$data = $this -> Ajax_calls_model -> getVillages($uncode);
  		echo $data;
 	}
	public function getred_rec_village() {
		$sessiontype = $this -> input -> post('sessiontype');
		$uncode = $this -> input -> post('uncode');
  		$data = $this -> Ajax_calls_model -> getred_rec_village($sessiontype,$uncode);
  		echo $data;
 	}
	public function getTargetPopulation() {
  		$vcode = $this -> input -> post('vcode');
  		$year = $this -> input -> post('year');
  		$data = $this -> Ajax_calls_model -> getTargetPopulation($vcode,$year);
  		echo $data;
 	}
	public function getProductReceivedBalanceForTheSelectedMonth() {
		$month = $this -> input -> post('month');
		$year = $this -> input -> post('year');
		$product_id = $this -> input -> post('product_id');
		$facode = $this -> input -> post('facode');
		$fmonth = $year . '-' . $month;
		$result = get_product_wise_facility_received_quantity_in_month($fmonth,$product_id,$facode,TRUE);
		echo $result;
	}
	public function getFunctionalFacilitiesForSelectedWeek(){
		$week = $this -> input -> post('week');
		$year = $this -> input -> post('year');
		$fweek = $year.'-'.$week;
		$query="Select facode, fac_name from facilities where getfstatus_ds('{$fweek}',facode)='F' and hf_type='e' and is_ds_fac='1' and distcode='{$this -> session -> District}' order by fac_name";
		$data['resultFac'] = $this -> db -> query($query) -> result_array();
		echo $this -> load -> view('investigation_forms/weeklyFunctionalFacilitiesRows',$data,TRUE);
	}
	public function tehsil_uc_wise_villages(){	
		$tcode = $this -> input -> post('tcode');
		$uncode = $this -> input -> post('uncode');
		$data['var']=$this->Ajax_calls_model->tehsil_uc_wise_villages($tcode,$uncode);
		print_r ($data);
	}
	public function checkfatherNIC(){
		$nic = $this->input->post('fathercnic');
		$data=$this -> Ajax_calls_model -> checkfatherNIC($nic);
		echo (empty($data))?0:json_encode($data);
	}
	public function checkchildmotherNIC(){
		$nic = $this->input->post('mothercnic');
		$data=$this -> Ajax_calls_model -> checkchildmotherNIC($nic);
		echo (empty($data))?0:json_encode($data);
	}
	public function CheckChlidRegistrationNo(){
		$child_registration_no = $this->input->post('child_registration_no');
		$data=$this -> Ajax_calls_model -> CheckChlidRegistrationNo($child_registration_no);
		echo (empty($data))?0:json_encode($data);
	}
	public function checkmotherNIC(){
		$nic = $this->input->post('mother_cnic');
		$data=$this -> Ajax_calls_model -> checkmotherNIC($nic);
		echo (empty($data))?0:json_encode($data); 
	}
	/* public function CheckmotherRegistrationNo(){
		$mother_registration_no = $this->input->post('mother_registration_no');
		$data=$this -> Ajax_calls_model -> CheckmotherRegistrationNo($mother_registration_no);
		echo (empty($data))?0:json_encode($data);
	} */
	public function CheckMotherRegistrationNo(){
		$mother_registration_no = $this->input->post('mother_registration_no');
		$data=$this -> Ajax_calls_model -> CheckMotherRegistrationNo($mother_registration_no);
		echo (empty($data))?0:json_encode($data);
	}
	public function child_list_filter(){
		$tcode = $this-> input-> get('tcode');
		$uncode = $this-> input-> get('uncode');
		$facode = $this-> input-> get('facode');
		$village = $this-> input-> get('village');
		$techniciancode = $this-> input-> get('techniciancode');
		$data = $this-> Ajax_calls_model-> child_list_filter($tcode,$uncode,$facode,$village,$techniciancode);
		echo $data;
	}
	public function get_Hr_sub_type_option() {
		$hr_sub_type_id = $this->input->post('hr_sub_type_id');
		$data = $this -> Ajax_calls_model -> get_Hr_sub_type_option($hr_sub_type_id);
		echo json_encode($data);
	}
	
	// Starts
	
/* 	
	public function child_card_number() {
  		//$recno = $this -> input -> post('uncode');
		//print_r($recno);exit;
  		$recno = ($this -> input -> post('recno'))?$this -> input -> post('recno'):$this -> uri -> segment(3);

  		$data = $this -> Ajax_calls_model -> child_card_number($recno);
  		echo $data;
 	} */
	 
	  
	public function child_card_number(){
		$recno = $this-> input-> get('recno');
		print_r($recno);exit;
		/* $tcode = $this-> input-> get('tcode');
		$uncode = $this-> input-> get('uncode');
		$village = $this-> input-> get('village'); */
		$data = $this-> Ajax_calls_model-> child_card_number($recno);
		echo $data;
	}
	
	//Ends
}
?>