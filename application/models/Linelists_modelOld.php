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
	
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Create_Reporting_Filters($reportName) {
		$data = posted_Values();//posted values from last page
		$wc	  = getWC_Array($data['procode'],$this -> session -> District,$data['facode']); // function to get wc array
		$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = $newWC[0];$neWc1 = $newWC[1];
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
			$query="Select distinct year from epi_weeks where year <= '".date("Y")."' order by year asc";
			$result = $this -> db ->query($query);
			$datArray['epiyears_select'] = $result->result_array();
			$datArray['epi_weeks_select'] = "";
			$datArray['epi_weekDates'] = "";
			if($this -> uri -> segment(4) == 'measles'){
				$datArray['measles'] = "";
				$Caption = "Measles Surveillance Line List Report";
			}else if($this -> uri -> segment(4) == 'cases'){
				$datArray['case_type'] = "";
				$datArray['case_category'] = "";
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
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		$this -> db -> select('week,districtname(distcode) as district,facilityname(facode) as facility,case_type,name_case,case_father_name,case_address,unname(case_uncode) as case_unname,tehsilname(case_tcode) as case_tehsil,districtname(case_distcode) as case_district,age_months,gender,case_date_onset,case_date_investigation,doses_received,case_date_last_dose_received,case_date_specieman,case_representation,recid');
		$this -> db -> from('weekly_vpd');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
		}else{
			$this -> db -> order_by('facilityname(facode)','asc');
		}		
		$data['web-surveillance'] = $this -> db -> get() -> result_array();
		// ----------------------------------------------------------------------------------------- //
		//----------Mobile Data Porting----------//
		/* $this -> db -> select('epi_week as week,districtname(distcode) as district,facilityname(facode) as facility,case_type,full_epid_no as epid_no,name_case,case_father_name,case_address,unname(case_uncode) as case_unname,tehsilname(case_tcode) as case_tehsil,districtname(case_distcode) as case_district,case_age as age_months,gender,case_date_onset,case_date_investigation,case_tot_vacc_received as doses_received,case_date_last_dose_received,case_date_specieman,case_representation,recid');
		$this -> db -> from('diseases_surveillance_mob');
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
		}else{
			$this -> db -> order_by('facilityname(facode)','asc');
		}
		$data['mob-surveillance'] = $this -> db -> get() -> result_array(); */
		//---------Merger Both Records from MIS and Mobile--------//
		//$data['surveillance']=array_merge($data['web-surveillance'],$data['mob-surveillance']);
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
		$this -> db -> from('weekly_vpd');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_type');
		$data['upperPortion1'] = $this -> db -> get() -> result_array();		
		//--------------------------------------------//
		//----------Uper Portion Data form Mob------------//
		/* $this -> db -> select('case_type as case,count(case_type) as no_of_cases');
		$this -> db -> from('diseases_surveillance_mob');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_type');
		$data['upperPortion2'] = $this -> db -> get() -> result_array(); */
		//---------Merger Both Records from MIS and Mobile--------//
		//$data['upperPortion']=array_merge($data['upperPortion1'],$data['upperPortion2']);
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
		$this -> db -> select('count(weekly_vpd.facode) as cnt');
		$this -> db -> from('weekly_vpd');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this->db->where('distcode is NOT NULL', NULL, FALSE);
		$result1 = $this -> db -> get() -> row_array();

		/* $this -> db -> select('count(facode) as cnt');
		$this -> db -> from('diseases_surveillance_mob');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this->db->where('distcode is NOT NULL', NULL, FALSE);
		$result2 = $this -> db -> get() -> row_array(); */

		//$data['ReportingFLCF']=$result1['cnt']+$result2['cnt'];
		$data['ReportingFLCF']=$result1['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
		
	}
	//************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Cases($wc){
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		unset($wc['ci_session']);
		if($wc['cross_notified'] == 1)
		{
			$wc['cross_notified ='] = 1;
			$wc['substring(fweek from 6 for 2) <>'] = '00';
		}
		elseif($wc['cross_notified'] == 0)
		{
			$wc['substring(fweek from 6 for 2) <>'] = '00';
			$wc['(cross_notified <>'] = 1;
		}
		$cross_notified = $wc['cross_notified'];
		unset($wc['cross_notified']);
		if($cross_notified == 0)
		{	
			$this-> db-> select('*, districtname(distcode) as district, provincename(procode) as province, facilityname(facode) as facility,unname(patient_address_uncode) as patient_unname, tehsilname(patient_address_tcode) as patient_tehsil, districtname(patient_address_distcode) as patient_district,id');
		}
		elseif($cross_notified == 1)
		{			
			$this-> db-> select('*,districtname(distcode) as district, provincename(procode) as province, facilityname(rb_facode) as facility,unname(patient_address_uncode) as patient_unname, unname(rb_uncode) as rb_unname, tehsilname(patient_address_tcode) as patient_tehsil, tehsilname(rb_tcode) as rb_tehsil, districtname(patient_address_distcode) as patient_district, districtname(rb_distcode) as rb_district,id');
		}
		$this -> db -> from('case_investigation_db');
		$this -> db -> where($wc);
		if($cross_notified == 0)
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
			if($cross_notified == 1){
				$this->db->order_by('approval_status','ASC');
			}
		}else{
			$this -> db -> order_by('facilityname(facode)','asc');
		}		
		//print_r($wc);exit;
		$data['measles'] = $this -> db -> get() -> result_array();
		//print_r($data['measles']);exit();
		//$symptoms = '';
		if(!empty($data['measles'])) {
			$clinicalrep = $data['measles'][0]['clinical_representation'];
			//echo $clinicalrep;exit();
			$clinicalrep = str_replace(',', "','", $clinicalrep);
			$viewData = "SELECT array_to_string(array_agg(case_type_definition), ', ') as clinical_representation from case_clinical_representation where id in ('".$clinicalrep."')";
			$result = $this -> db -> query($viewData);
			$result = $result -> row_array();
			$data['measles'][0]['clinical_representation'] = $result['clinical_representation'];
		}
		//print_r($data['measles'][0]['symptoms']);exit();
		//echo $this -> db -> last_query();exit;
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
		$queryFLCF = "SELECT count(facode) AS cnt FROM facilities WHERE hf_type='e' $dist";
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
			//echo "data";exit();
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
		$this -> db -> where($wc);
		if($cross_notified == 0)
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_epi_no');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		$this -> db -> select('count(*) as cnt');
		$this -> db -> from('case_investigation_db');
		$this -> db -> where($wc);
		if($cross_notified == 0)
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($cross_notified == 1){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;		
	}
	//************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Measles($wc){
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		if($wc['case_type'] == 'Measles_cross_notified')
		{
			$wc['cross_notified ='] = 1;
			$wc['substring(fweek from 6 for 2) <>'] = '00';
		}
		elseif($wc['case_type'] == 'Measles_other')
		{
			$wc['substring(fweek from 6 for 2) <>'] = '00';
			$wc['(cross_notified <>'] = 1;
		}
		$case_type = $wc['case_type'];
		unset($wc['case_type']);
		if($case_type == 'Measles_other')
		{
			$this -> db -> select('week,districtname(distcode) as district,facilityname(facode) as facility,facode,faddress,case_epi_no,patient_name,patient_gender,patient_fathername,patient_dob,patient_address,unname(patient_address_uncode) as patient_unname
			,tehsilname(patient_address_tcode) as patient_tehsil,districtname(patient_address_distcode) as patient_district,age_months 	,date_rash_onset, notification_date, doses_received,date_collection,last_dose_date,submitted_date,epid_year,specimen_result,clinical_representation,pvh_date,id');
		}
		elseif($case_type == 'Measles_cross_notified')
		{
			$this -> db -> select('week,districtname(distcode) as district,facilityname(rb_facode) as facility,facode,faddress,case_epi_no,patient_name,patient_gender,patient_fathername,patient_dob,patient_address,unname(patient_address_uncode) as patient_unname, unname(rb_uncode) as rb_unname
			,tehsilname(patient_address_tcode) as patient_tehsil, tehsilname(rb_tcode) as rb_tehsil,districtname(patient_address_distcode) as patient_district, districtname(rb_distcode) as rb_district,age_months ,date_rash_onset, notification_date, doses_received,date_collection,last_dose_date,submitted_date,epid_year,specimen_result,clinical_representation,pvh_date,id');
		}
		$this -> db -> from('measle_case_investigation');
		$this -> db -> where($wc);
		if($case_type == 'Measles_other')
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($case_type == 'Measles_cross_notified'){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
			if($case_type == 'Measles_cross_notified'){
				$this->db->order_by('approval_status','ASC');
			}
		}else{
			$this -> db -> order_by('facilityname(facode)','asc');
		}		
		//print_r($wc);exit;
		$data['measles'] = $this -> db -> get() -> result_array();
		//echo $this -> db -> last_query();exit;
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
		$queryFLCF = "SELECT count(facode) AS cnt FROM facilities WHERE hf_type='e' $dist";
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
			header("Content-Disposition: attachment; filename=Measles_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('case_epi_no as case,count(case_epi_no) as no_of_cases');
		$this -> db -> from('measle_case_investigation');
		$this -> db -> where($wc);
		if($case_type == 'Measles_other')
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($case_type == 'Measles_cross_notified'){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> group_by('case_epi_no');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		$this -> db -> select('count(*) as cnt');
		$this -> db -> from('measle_case_investigation');
		$this -> db -> where($wc);
		if($case_type == 'Measles_other')
		{
			$this->db->or_where('cross_notified is NULL OR case_epi_no IS NOT NULL)');
		}
		if($case_type == 'Measles_cross_notified'){
			$this->db->where('case_epi_no IS NULL',NULL,FALSE);
		}
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;		
	}
	//************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function NNT($wc){
		unset($wc['case_type']);
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		$this -> db -> select('week, districtname(distcode) as district,facilityname(facode) as facility,address,full_mother_name,gender,head_full_name,baby_dob,house_hold_address,unname(nnt_uncode) as patient_unname
		,tehsilname(nnt_tcode) as patient_tehsil,districtname(nnt_distcode) as patient_district,doses_received,instrument_used,date_investigation,where_baby_delivered,cord_treated,nnt_confirmed,pregnancy_visits,date_notification,date_delivery,date_onset,diagnosed_by,submitted_date,year,bs_cry,bs_stop_sucking,bs_stiffness,bs_spasms,bs_days,id');
		$this -> db -> from('nnt_investigation_form');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this->db->order_by('fweek','ASC');
		}
		$this -> db -> order_by('facode','asc');
		
		$data['nnt'] = $this -> db -> get() -> result_array();
		//echo $this -> db -> last_query();exit;
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
		$this -> db -> where($wc);
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
		unset($wc['case_type']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
		$this -> db -> select('week, case_epi_no, patient_name, patient_fathername, patient_gender as gender , age_months, patient_address, unname(patient_address_uncode), tehsilname(patient_address_tcode), districtname(patient_address_distcode) , case_date_onset, case_date_notification, case_date_investigation, fever_onset, rapid_progression , asymm_paralysis, doses_received, sia, date_collection_s1, date_sent_lab_s1, date_collection_s2,date_sent_lab_s2,condition_s1, final_result_s1, condition_s2, final_result_s2, date_follow_up,residual_paralysis,classification, final_diagnosis,id,facode');
		$this -> db -> from('afp_case_investigation');
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
			$this -> db -> order_by('week','asc');
		}else{
			$this -> db -> order_by('case_epi_no','asc');
		}	
		
		$data['afp'] = $this -> db -> get() -> result_array();
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
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		
		return $data;
		
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function AEFI($wc){
		$year =isset($wc['year']) ?  $wc['year'] : '' ;
		$week = isset($wc['week']) ?  $wc['week'] : '' ;
		$week = sprintf("%02d", $week);
		$fweek = $year."-".$week;
		if($year != '' && $week != '00')
		{
			$wc['fweek'] = $fweek;
		}
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($wc['export_excel']);
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
		$this -> db -> where($wc);
		if($week == "00"){
			$this->db->like('fweek',"$year-",'after');
		}
		$this -> db -> order_by('uncode','asc');
		
		$data['aefi'] = $this -> db -> get() -> result_array();
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
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('count(uncode) as no_of_cases');
		$this -> db -> from('aefi_rep');
		$this -> db -> where($wc);
		$this -> db -> group_by('uncode');
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
			header("Content-Disposition: attachment; filename=AEFI_LineLists_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		$data['exportIcons']=exportIcons($_REQUEST);
		$this -> db -> select('count(uncode) as cnt');
		$this -> db -> from('aefi_rep');
		$this -> db -> where($wc);
		$result = $this -> db -> get() -> row_array();
		$data['ReportingCenters'] = $result['cnt'];
		
		return $data;
		
	}
	////////////////////////*********************************************/////////////////////////////////
	
}
?>