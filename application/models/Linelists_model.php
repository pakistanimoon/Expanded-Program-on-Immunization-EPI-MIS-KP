<?php
class Linelists_model extends CI_Model {
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
			}else if($this -> uri -> segment(4) == 'cases'){
				$datArray['case_type'] = "";
				$datArray['case_category'] = "";
				$datArray['lab_result'] = "";
				$datArray['lab_results'] = "";
				$Caption = "Case Surveillance Line List Report";
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
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() . 'Linelists/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
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
		$this -> db -> select('week,districtname(distcode) as district,facilityname(facode) as facility,case_type,patient_name as name_case,patient_fathername as case_father_name,patient_address as case_address,unname(patient_address_uncode) as case_unname,tehsilname(patient_address_tcode) as case_tehsil,districtname(patient_address_distcode) as case_district,age_months,patient_gender as gender,date_rash_onset,date_investigation,doses_received,last_dose_date,specimen_collection_date,clinical_representation,other_case_representation,id');
		$this -> db -> from('case_investigation_db');
		
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
		$wc .= " AND procode='". $this->session->Province ."' ";
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
		$this -> db -> from('case_investigation_db');
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
		$this -> db -> select('count(case_investigation_db.facode) as cnt');
		$this -> db -> from('case_investigation_db');
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
	public function Cases($wc,$per_page=NULL, $startpoint=NULL){
		//kp
		//print_r($wc); exit();
		//echo $wc['case_type'];
		$sessionProcode = $this -> session -> Province;
		$specimen_result = $this -> input -> get_post('specimen_result');
		//$case = $this -> input -> get_post('case_type');
		$case =$wc['case_type']; 
		//$patient_address_uncode =$wc['patient_address_uncode']; 
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$distcodePro =isset($wc['distcode']) ?  $wc['distcode'] : 'ALL' ;
		$tcode =isset($wc['tcode']) ?  $wc['tcode'] :NULL ;
		$uncode =isset($wc['uncode']) ?  $wc['uncode'] :NULL ;
		$patient_address_uncode =isset($wc['patient_address_uncode']) ?  $wc['patient_address_uncode'] : '' ;
		$datefromReport =isset($wc['datefrom']) ?  $wc['datefrom'] : '' ;
		$datetoReport = isset($wc['dateto']) ?  $wc['dateto'] : '' ;
		$data['week_from'] = $from_week = isset($wc['from_week']) ?  $wc['from_week'] : 1 ;
		$data['week_to'] = $to_week = isset($wc['to_week']) ?  $wc['to_week'] : lastWeek($year) ;
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		
		$lab_result = isset($specimen_result) ? $specimen_result : NULL ;
		$week = sprintf("%02d", $week);
		
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['specimen_result']);
		unset($wc['case_type']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		$cross_notified = $wc['cross_notified'];

		if(isset($wc['uncode']) && $wc['uncode'] > 0){
			$this -> db -> where("uncode = '{$wc['uncode']}'",NULL,FALSE);
			$distcode=$wc['uncode'];
			unset($wc['uncode']);
		}
		if(isset($wc['tcode']) && $wc['tcode'] > 0){
			$this -> db -> where("tcode = '{$wc['tcode']}'",NULL,FALSE);
			$distcode=$wc['tcode'];
			unset($wc['tcode']);
		}
		if(isset($wc['distcode']) && $wc['distcode'] > 0){
			$this -> db -> where("distcode = '{$wc['distcode']}'",NULL,FALSE);
			$distcode=$wc['distcode'];
			unset($wc['distcode']);
		}
		if($wc['cross_notified'] == 1)
		{
			$wc['cross_notified ='] = 1;		
			if(isset($from_week) && $from_week == "00" && $to_week == "00"){
				$wc = " year = '{$year}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
			else if (isset($from_week) && $from_week != "00" && $to_week == "00"){
				$wc = " fweek >= '{$f_from_week}' AND fweek <> '$year-00' AND year = '{$year}' AND procode = '{$sessionProcode}'";
			} 
			else if (isset($to_week) && $from_week == "00" && $to_week != "00"){
				$year_st = $year."-".'01' ;
				$wc = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
			else{
				$wc = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
			
		}
		
		elseif($wc['cross_notified'] == 0)
		{
			if(isset($from_week) && $from_week == "00" && $to_week == "00"){
				$wc = " year = '{$year}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
			else if (isset($from_week) && $from_week != "00" && $to_week == "00"){
				$wc = " fweek >= '{$f_from_week}' AND fweek <> '$year-00' AND year = '{$year}' AND procode = '{$sessionProcode}'";
			} 
			else if (isset($to_week) && $from_week == "00" && $to_week != "00"){
				$year_st = $year."-".'01' ;
				$wc = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
			else{
				$wc = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}' AND fweek <> '$year-00' AND procode = '{$sessionProcode}'"; 
			}
		}
		$wc .= " AND procode='". $this->session->Province ."' ";
		if($cross_notified == 0)
		{	//patient_address_uncode
			$this-> db-> select('*, districtname(distcode) as district, provincename(procode) as province, facilityname(facode) as facility,unname(patient_address_uncode) as patient_unname, tehsilname(patient_address_tcode) as patient_tehsil, districtname(patient_address_distcode) as patient_district,id');
		}
		elseif($cross_notified == 1)
		{			
			$this-> db-> select('*,districtname(distcode) as district, provincename(procode) as province, facilityname(rb_facode) as facility,unname(patient_address_uncode) as patient_unname, unname(rb_uncode) as rb_unname, tehsilname(patient_address_tcode) as patient_tehsil, tehsilname(rb_tcode) as rb_tehsil, districtname(patient_address_distcode) as patient_district, districtname(rb_distcode) as rb_district,id');
		}
		$this -> db -> from('case_investigation_db');
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
		//echo $patient_address_uncode;exit();
		if(isset($patient_address_uncode) && $patient_address_uncode > 0){
			$this->db->where("patient_address_uncode='$patient_address_uncode'",NULL,FALSE);
		}
		if(isset($uncode) && $uncode > 0){
			$this->db->where("uncode='$uncode'",NULL,FALSE);
		}
		if($cross_notified == 0)
		{
			$this->db->where('case_epi_no IS NOT NULL',NULL,FALSE);
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL AND approval_status=\'Pending\' ',NULL,FALSE);
		}
		if($case == 'Msl' ){
			if($lab_result == 'Positive Measles'){
				$this->db->where('specimen_result=\'Positive Measles\' AND case_type=\'Msl\' AND facode > \'0\' ',NULL,FALSE);
			}
			else if($lab_result == 'Positive Rubella'){
				$this->db->where('specimen_result=\'Positive Rubella\' AND case_type=\'Msl\' AND facode > \'0\' ',NULL,FALSE);
			}
			else if($lab_result == 'Negative Measles'){
				$this->db->where('specimen_result=\'Negative Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else if($lab_result == 'Negative Rubella'){
				$this->db->where('specimen_result=\'Negative Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else {
				$this->db->where('case_type=\'Msl\' ',NULL,FALSE);
			}
		}
		else {
			$this->db->where("case_type='$case'",NULL,FALSE);
			if($lab_result != NULL AND $lab_result != '0'){
				$this->db->where("specimen_result='$lab_result'",NULL,FALSE);
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
		$data['measles'] = $this -> db -> get() -> result_array();
		
		//echo $this -> db -> last_query();exit();
		if(!empty($data['measles'])) {
			foreach ($data['measles'] as $key => $value) {
				$clinicalrep = $data['measles'][$key]['clinical_representation'];
				$clinicalrep = str_replace(',', "','", $clinicalrep);
				$viewData = "SELECT array_to_string(array_agg(case_type_definition), ', ') as clinical_representation from case_clinical_representation where id in ('".$clinicalrep."')";
				$result = $this -> db -> query($viewData);
				$result = $result -> row_array();
				$data['measles'][$key]['clinical_representation'] = $result['clinical_representation'];
			}
		}		
		$dist="";
		if($distcodePro != 'ALL' && $distcodePro != '0' ){
			$data['districtName'] = DistrictName($distcodePro);
		}
		else{
			$data['districtName'] = 'ALL';
		}
		if(isset($uncode) && $uncode > 0){
			$data['ucName'] = get_UC_Name($uncode);
		}
		else{
			$data['ucName'] = 'ALL';
		}		
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
			header("Content-Disposition: attachment; filename=Cases_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('case_epi_no as case,count(case_epi_no) as no_of_cases');
		$this -> db -> from('case_investigation_db');
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
		$this -> db -> from('case_investigation_db');
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
		if(isset($tcode) && $tcode > 0){
			$this->db->where("tcode='$tcode'",NULL,FALSE);
		}
		if(isset($uncode) && $uncode > 0){
			$this->db->where("uncode='$uncode'",NULL,FALSE);
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
			if($lab_result == 'Positive Measles'){
				$this->db->where('specimen_result=\'Positive Measles\' AND case_type=\'Msl\' AND facode > \'0\' ',NULL,FALSE);
			}
			else if($lab_result == 'Positive Rubella'){
				$this->db->where('specimen_result=\'Positive Rubella\' AND case_type=\'Msl\' AND facode > \'0\' ',NULL,FALSE);
			}
			else if($lab_result == 'Negative Measles'){
				$this->db->where('specimen_result=\'Negative Measles\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else if($lab_result == 'Negative Rubella'){
				$this->db->where('specimen_result=\'Negative Rubella\' AND case_type=\'Msl\' ',NULL,FALSE);
			}else {
				$this->db->where('case_type=\'Msl\' ',NULL,FALSE);
			}
		}
		else {
			$this->db->where("case_type='$case'",NULL,FALSE);
			if($lab_result != NULL AND $lab_result != '0'){
				$this->db->where("specimen_result='$lab_result'",NULL,FALSE);
			}
		}
		if(isset($week) && $week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		//echo $this -> db -> last_query();exit();
		$data['ReportingFLCF'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		//echo print_r($data['ReportingFLCF']);exit();
		return $data;		
	}
	//************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function NNT($wc){
		unset($wc['case_type']);
		unset($wc['code']);
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$data['week_from'] = $from_week = isset($wc['from_week']) ?  $wc['from_week'] : 1 ;
		$data['week_to'] = $to_week = isset($wc['to_week']) ?  $wc['to_week'] : lastWeek($year) ;
		/* $week = sprintf("%02d", $week);
		$fweek = $year."-".$week ;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}	 */	
		$datefromReport =isset($wc['datefrom']) ?  $wc['datefrom'] : '' ;
		$datetoReport = isset($wc['dateto']) ?  $wc['dateto'] : '' ;
		$cross_notified = $wc['cross_notified'];
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['datefromReport']);
		unset($wc['datetoReport']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		unset($wc['_ga']);
		unset($wc['_gid']);
		unset($wc['_gat']);
		unset($wc['cross_notified']);
		$this -> db -> select('week, districtname(distcode) as district,facilityname(facode) as facility,address,full_mother_name,gender,head_full_name,baby_dob,house_hold_address,unname(nnt_uncode) as patient_unname
		,tehsilname(nnt_tcode) as patient_tehsil,districtname(nnt_distcode) as patient_district,doses_received,instrument_used,date_investigation,where_baby_delivered,cord_treated,nnt_confirmed,pregnancy_visits,date_notification,date_delivery,date_onset,diagnosed_by,submitted_date,year,bs_cry,bs_stop_sucking,bs_stiffness,bs_spasms,bs_days,id');
		$this -> db -> from('nnt_investigation_form');
		
		if($from_week == "00" && $to_week == "00"){
			$where = " year = '{$year}'"; 
		}
		else if ($from_week != "00" && $to_week == "00"){
			$where = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
		} 
		else if ($from_week == "00" && $to_week != "00"){
			$year_st = $year."-".'01' ;
			$where = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
		}
		else{
		$where = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
		}
		if($cross_notified == '0'){
			$this -> db -> where('(cross_notified IS NULL OR cross_notified = 0)');
		}else{
			$this -> db -> where('(cross_notified = 1)');
		}
		$this->db->where($where);
		
		$this -> db -> where($wc);
		
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
		}
		$this -> db -> order_by('facode','asc');
		$data['nnt'] = $this -> db -> get() -> result_array();
		$data['datefromReport'] = $datefromReport;
		$data['datetoReport'] = $datetoReport;
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
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' and is_ds_fac='1' $dist";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		//----------------------------------------------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('count(facode) as no_of_cases');
		$this -> db -> from('nnt_investigation_form');
		$this -> db -> where($wc);
		$this -> db -> group_by('facode');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		//----------Down Portion Data form MIS------------//
		$this -> db -> select('fullname as name, designation');
		$this -> db -> from('epiusers');
		$this -> db -> where('username', $this -> session -> username);
		$data['downPortion'] = $this -> db -> get() -> result_array();

		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=NNT_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		$this -> db -> select('count(*) as cnt');
		$this -> db -> from('nnt_investigation_form');
		if($cross_notified == '0'){
			$this -> db -> where('(cross_notified IS NULL OR cross_notified = 0)');
		}else{
			$this -> db -> where('(cross_notified = 1)');
		}
		$this -> db -> where($wc);
		$this -> db -> where($where);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;		
	}
	////////////////////////*********************************************/////////////////////////////////
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Afp($wc){
		//print_r($wc); exit;
		unset($wc['case_type']);
		unset($wc['code']);
		/* unset($wc['datefrom']);
		unset($wc['dateto']); */
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$data['week_from'] = $from_week = isset($wc['from_week']) ?  $wc['from_week'] : 1 ;
		$data['week_to'] = $to_week = isset($wc['to_week']) ?  $wc['to_week'] : lastWeek($year) ;
		/* $week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		} */
		$datefromReport =isset($wc['datefrom']) ?  $wc['datefrom'] : '' ;
		$datetoReport = isset($wc['dateto']) ?  $wc['dateto'] : '' ;
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		
		$cross_notified = $wc['cross_notified'];
		unset($wc['cross_notified']);
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['datefromReport']);
		unset($wc['datetoReport']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		unset($wc['_ga']);
		unset($wc['_gid']);
		unset($wc['_gat']);
		$this -> db -> select('week, case_epi_no, patient_name, patient_fathername, patient_gender as gender , age_months, patient_address, unname(patient_address_uncode), tehsilname(patient_address_tcode), districtname(patient_address_distcode) , case_date_onset, case_date_notification, case_date_investigation, fever_onset, rapid_progression , asymm_paralysis, doses_received, sia, date_collection_s1, date_sent_lab_s1, date_collection_s2,date_sent_lab_s2,condition_s1, final_result_s1, condition_s2, final_result_s2, date_follow_up,residual_paralysis,classification, final_diagnosis,id,facode');
		$this -> db -> from('afp_case_investigation');
		
		if($from_week == "00" && $to_week == "00"){
			$where = " year = '{$year}'"; 
		}
		else if ($from_week != "00" && $to_week == "00"){
			$where = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
		} 
		else if ($from_week == "00" && $to_week != "00"){
			$year_st = $year."-".'01' ;
			$where = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
		}
		else{
			$where = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
		}
		if($cross_notified == '0'){
			$this -> db -> where('(cross_notified IS NULL OR cross_notified = 0)');
		}else{
			$this -> db -> where('(cross_notified = 1)');
		}
		//print_r($wc); exit;
		$this->db->where($where);
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this -> db -> order_by('week','asc');
		}else{
			$this -> db -> order_by('case_epi_no','asc');
		}	
		$data['datefromReport'] = $datefromReport;
		$data['datetoReport'] = $datetoReport;
		//print_r($data); exit;
		$data['afp'] = $this -> db -> get() -> result_array();
		//print_r($data); exit;
		//echo $this->db->last_query(); exit;
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
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' and is_ds_fac='1' $dist";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		//----------------------------------------------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('count(case_epi_no) as no_of_cases');
		$this -> db -> from('afp_case_investigation');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_epi_no');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		//----------Down Portion Data form MIS------------//
		$this -> db -> select('fullname as name, designation');
		$this -> db -> from('epiusers');
		$this -> db -> where('username', $this -> session -> username);
		$data['downPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=AFP_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		unset($wc['export_excel']);
		$data['exportIcons']=exportIcons($_REQUEST);
		$this -> db -> select('count(facode) as cnt');
		$this -> db -> from('afp_case_investigation');
		if($cross_notified == '0'){
			$this -> db -> where('(cross_notified IS NULL OR cross_notified = 0)');
		}else{
			$this -> db -> where('(cross_notified = 1)');
		}
		$this -> db -> where($wc);
		$this -> db -> where($where);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		return $data;
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function AEFI($wc){
		$year = isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$data['week_from'] = $from_week = isset($wc['from_week']) ?  $wc['from_week'] : 1 ;
		$data['week_to'] = $to_week = isset($wc['to_week']) ?  $wc['to_week'] : lastWeek($year) ;
		//$week = sprintf("%02d", $week);
		$from_week = sprintf("%02d", $from_week);
		$f_from_week = $year."-".$from_week;
		$to_week = sprintf("%02d", $to_week);
	 	$f_to_week = $year."-".$to_week; 
		//$fweek = $year."-".$week;
		/* if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		} */
		
		unset($wc['year']);
		unset($wc['code']);
		//unset($wc['week']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		unset($wc['_ga']);
		unset($wc['_gid']);
		unset($wc['_gat']);
		
		unset($wc['case_type']);
		if(isset($wc['distcode']) && $wc['distcode'] > 0){
			$this -> db -> where("distcode = '{$wc['distcode']}' ",NULL,FALSE);
			$distcode=$wc['distcode'];
			unset($wc['distcode']);
			
			$wc= "distcode = '{$distcode}' ";
		}
			
		//print_r($wc);
		$this -> db -> select("districtname(distcode) as district,facilityname(facode) as facilityname,village,casename,gender,dob,age,vacc_date,unname(uncode) as unname,tehsilname(tcode) as tehsil,date_aefi_onset,mc_hospitalized,death,week,vacc_name,id,
			trim(trailing ', ' from  
			case when mc_bcg = 1 then 'BCG Lymphadenitis , ' else '' END || 
			case when mc_convulsion = 1 then 'Convulsion , ' else '' END || 
			case when mc_severe = 1 then 'Severe Local Reaction , ' else '' END || 
			case when mc_unconscious = 1 then 'Unconsciousness , ' else '' END || 
			case when mc_abscess = 1 then 'Injection site abscess , ' else '' END || 
			case when mc_respiratory = 1 then 'Respiratory Distress , ' else '' END || 
			case when mc_fever = 1 then 'Fever , ' else '' END || 
			case when mc_swelling = 1 then 'Swelling of body or face , ' else '' END || 
			case when mc_rash = 1 then 'Rash , ' else '' END || 
			case when mc_other = '' then '' else mc_other END
		) as complaints,
		");
		$this -> db -> from('aefi_rep');
		
		if($from_week == "00" && $to_week == "00"){
			$where = " year = '{$year}'"; 
		}
		else if ($from_week != "00" && $to_week == "00"){
			$where = " fweek >= '{$f_from_week}' AND year = '{$year}' ";
		} 
		else if ($from_week == "00" && $to_week != "00"){
			$year_st = $year."-".'01' ;
			$where = "fweek BETWEEN '{$year_st}' AND '{$f_to_week}'"; 
		}
		else{
			$where = "fweek BETWEEN '{$f_from_week}' AND '{$f_to_week}'"; 
		}
		$this->db->where($where);
		$this -> db -> where($wc);
	
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> order_by('uncode','asc');
		$data['aefi'] = $this -> db -> get() -> result_array();
		//echo $this->db-> last_query(); exit;	
		
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
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' and is_ds_fac='1' $dist";
		//$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' and distcode='$distcode'";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		 
		//echo $this->db-> last_query(); exit;
		//----------------------------------------------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('count(uncode) as no_of_cases');
		$this -> db -> from('aefi_rep');
		$this -> db -> where($wc);
		$this -> db -> group_by('uncode');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		
		//echo $this->db-> last_query(); exit;
		//--------------------------------------------//
		//----------Down Portion Data form MIS------------//
		$this -> db -> select('fullname as name, designation');
		$this -> db -> from('epiusers');
		$this -> db -> where('username', $this -> session -> username);
		$data['downPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=AEFI_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		$data['exportIcons']=exportIcons($_REQUEST);
		$this -> db -> select('count(*) as cnt');
		$this -> db -> from('aefi_rep');
		$this -> db -> where($wc);
		$this -> db -> where($where);
		$result = $this -> db -> get() -> row_array();
		$data['ReportingCenters'] = $result['cnt'];
		return $data;
	}
	////////////////////////*********************************************/////////////////////////////////
}
?>