<?php
//KP
class Coronalinelist_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> library('breadcrumbs');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
	}
	//============================ Constructor Function Ends ============================//
	//========= Function to Create Filters for Sepecific Reports Starts Here ============//
	public function Create_Reporting_Filters($reportName) {
		$data = posted_Values();//posted values from last page
		$wc	= getWC_Array($data['procode'],$this -> session -> District,$data['facode']); // function to get wc array
		$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = $newWC[0];
		$neWc1 = $newWC[1];
        unset($neWc1[2]);
		$UserLevel = $this -> session -> UserLevel;
		$Caption = "Report";
		$subTitle = "District Report";
		$datArray = NULL;
		$datArray['years'] = "";
		$datArray['districts'] = get_resultArray('district',$neWc1);
		//for surveillance report filters
		if ($reportName == 'Surveillance') {
			unset($datArray['years']);
			$Caption = "Disease Surveillance Compilation Report";
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
			$query="Select un_name, uncode from unioncouncil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by uncode";
			$resultUnc=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUnc->result_array();
			$query="Select 'Week '|| epi_week_numb, epi_week_numb  from epi_weeks where year = '".date("Y")."' order by epi_week_numb asc";
			$week_result = $this -> db ->query($query);
			//$query="Select distinct year from epi_weeks where year <= '".date("Y")."' order by year asc";
			$currentYear = getWeekYearAccordingToCurrentDate(date('Y-m-d'));
			//$WeekNumber = current_week($currentYear,true);
			//if($WeekNumber > 01){
			$query="Select distinct year from epi_weeks where year <= '".$currentYear."' order by year asc";
			/* }
			else{
				$query="Select distinct year from epi_weeks where year < '".date("Y")."' order by year asc";
			} */
			$result = $this -> db ->query($query);
			$datArray['epiyears_select'] = $result->result_array();
			//$datArray['epi_weeks_select'] = "";
			$datArray['epi_week_from_to'] = $week_result->result_array();
			$datArray['epi_weekDates'] = "";
			if($this -> uri -> segment(4) == 'measles'){
				$datArray['measles'] = "";
				//$datArray['lab_result'] = "";
				$Caption = "Measles Surveillance Line List Report";
			}else if($this -> uri -> segment(4) == 'corona'){
				$datArray['coronavirus'] = "";
				//$datArray['case_type'] = "";
				$datArray['case_category'] = "";
				$datArray['test_result'] = "";
				//$datArray['lab_results'] = "";
				$Caption = "Coronavirus Surveillance Line List Report";
			}else if($this -> uri -> segment(4) == 'afp'){
				$datArray['afp'] = "";
				$Caption = "AFP Surveillance Line List Report";
			}else if($this -> uri -> segment(4) == 'nnt'){
				$datArray['nnt'] = "";
				$Caption = "NNT Surveillance Line List Report";
			}
			else
				$datArray['disease'] = "";
		}
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() . 'CoronaLinelist/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
		return $datArray;
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Surveillance($wc){
		//print_r($wc);exit();
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		
		$data['week_from']=$from_week = isset($wc['from_week']) ?  $wc['from_week'] : '' ;
		$data['week_to']=$to_week = isset($wc['to_week']) ?  $wc['to_week'] : '' ;
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		
		/* $fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		} */ 
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		//$this -> db -> select('week,districtname(distcode) as district,facilityname(facode) as facility,case_type,patient_name as name_case,patient_fathername as case_father_name,patient_address as case_address,unname(patient_address_uncode) as case_unname,tehsilname(patient_address_tcode) as case_tehsil,districtname(patient_address_distcode) as case_district,age_months,patient_gender as gender,date_rash_onset,date_investigation,doses_received,last_dose_date,specimen_collection_date,clinical_representation,other_case_representation,id');
		
		$this-> db-> select('*, districtname(distcode) as district, provincename(procode) as province, facilityname(facode) as facility,unname(patient_address_uncode) as patient_unname, tehsilname(patient_address_tcode) as patient_tehsil, districtname(patient_address_distcode) as patient_district,id');	
		
		$this -> db -> from('corona_case_investigation_form_db');
		
		if($from_week == "00" && $to_week == "00"){
			$wc = " year = '{$year}'"; 
		}
		else if ($from_week != "00" && $to_week == "00"){
			$wc = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
		} 
		else if ($from_week == "00" && $to_week != "00"){
			$year_st = $year."-".'01' ;
			$wc = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
		}
		else{
		$wc = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
		}
		
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
		}else{
			$this -> db -> order_by('facilityname(facode)','asc');
		}		
		$data['web-surveillance'] = $this -> db -> get() -> result_array();
		// ----------------------------------------------------------------------------------------- //
		$data['surveillance'] = $data['web-surveillance'];
		// ----------------------------------------------------------------------------------------- //
		$dist="";
		$data['districtName'] = 'ALL';
		if($this -> session -> District || (isset($wc['distcode']) && $wc['distcode'] > 0)){
			$distcode = ($this -> session -> District)?$this -> session -> District:$wc['distcode'];
			$dist=" and distcode='$distcode'";
			$distcc = array('distcode'=>$distcode);
			$this -> db -> select('district');
			$this -> db -> where($distcc);
			$distResult = $this -> db -> get('districts') -> row_array();
			$data['districtName'] = $distResult['district'];
		}
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' $dist";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		//----------------------------------------------------------------------------------//
		//----------Down Portion Data form MIS------------//
		$this -> db -> select('fullname as name, designation');
		$this -> db -> from('epiusers');
		$this -> db -> where('username', $this -> session -> username);
		$data['downPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('case_type as case,count(case_type) as no_of_cases');
		$this -> db -> from('corona_case_investigation_form_db');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_type');
		$data['upperPortion1'] = $this -> db -> get() -> result_array();		
		//--------------------------------------------//
		$data['upperPortion']=$data['upperPortion1'];
		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		$this -> db -> select('count(corona_case_investigation_form_db.facode) as cnt');
		$this -> db -> from('corona_case_investigation_form_db');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this->db->where('distcode is NOT NULL', NULL, FALSE);
		$result1 = $this -> db -> get() -> row_array();
		$data['ReportingFLCF']=$result1['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Corona($wc,$per_page=NULL, $startpoint=NULL){
		//print_r($wc); exit();
		//echo $wc['case_type'];
		$test_result = $this -> input -> get_post('test_result');
		//$case = $this -> input -> get_post('case_type');
		$case =$wc['case_type']; 
		//$patient_address_uncode =$wc['patient_address_uncode']; 
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$distcodePro =isset($wc['distcode']) ?  $wc['distcode'] : 'ALL' ;
        $data['tcode'] = (isset($wc['tcode']))?$wc['tcode']:NULL;
		$data['uncode'] = (isset($wc['uncode']))?$wc['uncode']:NULL;
		$patient_address_uncode =isset($wc['patient_address_uncode']) ?  $wc['patient_address_uncode'] : '' ;
		$datefromReport =isset($wc['datefrom']) ?  $wc['datefrom'] : '' ;
		$datetoReport = isset($wc['dateto']) ?  $wc['dateto'] : '' ;
		$data['week_from'] = $from_week = isset($wc['from_week']) ?  $wc['from_week'] : 1 ;
		$data['week_to'] = $to_week = isset($wc['to_week']) ?  $wc['to_week'] : lastWeek($year) ;
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		
		$lab_result = isset($test_result) ? $test_result : NULL ;
		$week = sprintf("%02d", $week);
		
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['test_result']);
		unset($wc['case_type']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		$cross_notified = $wc['cross_notified'];
		if(isset($wc['distcode']) && $wc['distcode'] > 0){
				$this -> db -> where("distcode = '{$wc['distcode']}'",NULL,FALSE);
				$distcode=$wc['distcode'];
				unset($wc['distcode']);
		}
        if(isset($wc['tcode']) && $wc['tcode'] > 0){
			$this -> db -> where("tcode = '{$wc['tcode']}'",NULL,FALSE);
			$tcode=$wc['tcode'];
			unset($wc['tcode']);
		}
        if(isset($wc['uncode']) && $wc['uncode'] > 0){
			$this -> db -> where("uncode = '{$wc['uncode']}'",NULL,FALSE);
			$uncode=$wc['uncode'];
			unset($wc['uncode']);
		}
		if($wc['cross_notified'] == 1)
		{
			$wc['cross_notified ='] = 1;		
			if(isset($from_week) && $from_week == "00" && $to_week == "00"){
				$wc = " year = '{$year}'"; 
			}
			else if (isset($from_week) && $from_week != "00" && $to_week == "00"){
				$wc = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
			} 
			else if (isset($to_week) && $from_week == "00" && $to_week != "00"){
				$year_st = $year."-".'01' ;
				$wc = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
			}
			else{
				$wc = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
			}
			
		}
		
		elseif($wc['cross_notified'] == 0)
		{
			if(isset($from_week) && $from_week == "00" && $to_week == "00"){
				$wc = " year = '{$year}'"; 
			}
			else if (isset($from_week) && $from_week != "00" && $to_week == "00"){
				$wc = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
			} 
			else if (isset($to_week) && $from_week == "00" && $to_week != "00"){
				$year_st = $year."-".'01' ;
				$wc = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
			}
			else{
				$wc = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
			}
		}
		$wc .= " AND procode='". $this->session->Province ."' ";
		if($cross_notified == 0)
		{
			$this-> db-> select('*, districtname(distcode) as district, provincename(procode) as province, facilityname(facode) as facility,unname(patient_address_uncode) as patient_unname, tehsilname(patient_address_tcode) as patient_tehsil, districtname(patient_address_distcode) as patient_district,id');
		}
		elseif($cross_notified == 1)
		{			
			$this-> db-> select('*,districtname(distcode) as district, provincename(procode) as province, facilityname(rb_facode) as facility,unname(patient_address_uncode) as patient_unname, unname(rb_uncode) as rb_unname, tehsilname(patient_address_tcode) as patient_tehsil, tehsilname(rb_tcode) as rb_tehsil, districtname(patient_address_distcode) as patient_district, districtname(rb_distcode) as rb_district,id');
		}
		$this -> db -> from('corona_case_investigation_form_db');
		$this -> db -> where($wc);

		if( ! isset($wc['patient_address_uncode']) AND ! $this -> input -> post('export_excel')){
			if($per_page){}else{
				$per_page=100;
			}if($startpoint){}else{
				$startpoint=0;
			}
			$this->db->limit($per_page);
			$this->db->offset($startpoint);
		}else{
			$this->db->offset(0);
		}
		if(isset($patient_address_uncode) && $patient_address_uncode > 0){
			$this->db->where("patient_address_uncode='$patient_address_uncode'",NULL,FALSE);
		}
		if($cross_notified == 0)
		{
			$this->db->where('case_epi_no IS NOT NULL',NULL,FALSE);
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL AND approval_status=\'Pending\' ',NULL,FALSE);
		}
		if($case == 'Msl' ){
			if($lab_result == 'Postive Measles'){
				$this->db->where('test_result=\'Positive Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}
			else if($lab_result == 'Postive Rubella'){
				$this->db->where('test_result=\'Positive Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}
			else if($lab_result == 'Negative Measles'){
				$this->db->where('test_result=\'Negative Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else if($lab_result == 'Negative Rubella'){
				$this->db->where('test_result=\'Negative Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else {
				$this->db->where('case_type=\'Msl\' ',NULL,FALSE);
			}
		}
		else {
			$this->db->where("case_type='$case'",NULL,FALSE);
			if($lab_result != NULL AND $lab_result != '0'){
				$this->db->where("test_result='$lab_result'",NULL,FALSE);
			}
		}
		if(isset($wc['week']) && $week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek,case_number,districtname(distcode),facilityname(facode)','ASC');
			if($cross_notified == 1){
				$this->db->order_by('approval_status','ASC');
			}
		}
		else{
			$this -> db -> order_by('fweek,case_number,districtname(distcode),facilityname(facode)','asc');
		}
		$data['corona'] = $this -> db -> get() -> result_array();
			
		$dist="";
		if($distcodePro != 'ALL' && $distcodePro != '0' ){
			$data['districtName'] = DistrictName($distcodePro);
		}
		else{
			$data['districtName'] = 'ALL';
		}
		$data['ucName'] = 'ALL';
		$data['year'] = $year;
		$data['week'] = $week;
		$data['datefromReport'] = $datefromReport;
		$data['datetoReport'] = $datetoReport;
		if($this -> session -> District || (isset($wc['distcode']) && $wc['distcode'] > 0)){
			$distcode = ($this -> session -> District)?$this -> session -> District:$wc['distcode'];
			$dist=" and distcode='$distcode'";
			$distcc = array('distcode'=>$distcode);
			$this -> db -> select('district');
			$this -> db -> where($distcc);
			$distResult = $this -> db -> get('districts') -> row_array();
			$data['districtName'] = $distResult['district'];
		}
		if(isset($wc['uncode']) && $wc['uncode'] > 0){
			$uncode = $wc['uncode'];
			$dist=" and uncode='$uncode'";
			$uncodecc = array('uncode'=>$uncode);
			$this -> db -> select('un_name');
			$this -> db -> where($uncodecc);
			$distResult = $this -> db -> get('unioncouncil') -> row_array();
			$data['ucName'] = $distResult['un_name'];
		}
		if($this-> uri-> segment(3) != ''){
			$uncode = $this-> uri-> segment(3);
			$data['pa_uncode'] = $uncode;
		}
		$queryFLCF = "SELECT count(facode) AS cnt FROM facilities WHERE hf_type='e' and is_ds_fac='1' $dist";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		//----------------------------------------------------------------------------------//
		//----------Down Portion Data form MIS------------//
		$this -> db -> select('fullname as name, designation');
		$this -> db -> from('epiusers');
		$this -> db -> where('username', $this -> session -> username);
		$data['downPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Coronavirus_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('case_epi_no as case,count(case_epi_no) as no_of_cases');
		$this -> db -> from('corona_case_investigation_form_db');
		if($cross_notified == 0)
		{
			$this->db->where('case_epi_no IS NOT NULL',NULL,FALSE);
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL AND approval_status=\'Pending\' ',NULL,FALSE);
		}
		if(isset($week) && $week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_epi_no');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		$this -> db -> select('count(*) as cnt');
		$this -> db -> from('corona_case_investigation_form_db');
		if($cross_notified == 1)
		{
			if(isset($distcode) && $distcode > 0){
				$this -> db -> where("(distcode = '{$distcode}' OR rb_distcode='{$distcode}')",NULL,FALSE);
			}
		}
		$this -> db -> where($wc);
		//echo $patient_address_uncode;exit();
		if(isset($patient_address_uncode) && $patient_address_uncode > 0){
			$this->db->where("patient_address_uncode='$patient_address_uncode'",NULL,FALSE);
		}
		if($cross_notified == 0)
		{
			if(isset($distcode) && $distcode > 0){
				$this -> db -> where("(distcode = '{$distcode}')",NULL,FALSE);
			}
			$this->db->where('case_epi_no IS NOT NULL',NULL,FALSE);
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL AND approval_status=\'Pending\' ',NULL,FALSE);
		}
		if($case == 'Msl' ){
			if($lab_result == 'Postive Measles'){
				$this->db->where('test_result=\'Positive Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}
			else if($lab_result == 'Postive Rubella'){
				$this->db->where('test_result=\'Positive Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}
			else if($lab_result == 'Negative Measles'){
				$this->db->where('test_result=\'Negative Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else if($lab_result == 'Negative Rubella'){
				$this->db->where('test_result=\'Negative Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else {
				$this->db->where('case_type=\'Msl\' ',NULL,FALSE);
			}
		}
		else {
			$this->db->where("case_type='$case'",NULL,FALSE);
			if($lab_result != NULL AND $lab_result != '0'){
				$this->db->where("test_result='$lab_result'",NULL,FALSE);
			}
		}
		if(isset($week) && $week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		//echo $this -> db -> last_query();exit();
		$data['ReportedCases'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;		
	}
	//************************************************************************************//
	
}
?>