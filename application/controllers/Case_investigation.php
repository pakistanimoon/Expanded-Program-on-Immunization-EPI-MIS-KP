<?php
class Case_investigation extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
		//echo CrossProvince_DistrictName(511);exit();		
		//authentication();
		$this -> load -> helper('apis_helper');
		$this -> load -> model ('Case_investigation_model');
		//$this -> load -> model('Cross_notify_functions_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	////////////////////////// FIRST Function ///////////////////////////////////////////////
	
	//------------------------------------ Case Investigation -----------------------------------------//
	//-------------------------------------------------------------------------------------------------//
	
	public function case_investigation_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " case_investigation_db "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and case_type!='Msl' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."')";
		else
			$wc=" procode = '".$_SESSION["Province"]."' and case_type!='Msl'";
			//$wc=" ";
		$data = $this -> Case_investigation_model -> case_investigation_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		//print_r($data['pagination']);exit();
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/case_investigation_list';
			$data['pageTitle']='Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}

	public function case_investigation(){
		$data['data']=$this -> Case_investigation_model -> case_investigation(); 
		$distcode = $this -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		$year = date('Y');
		$data['years'] = getEpiWeekYearsOptions('',true);
		//$data['years'] = getAllYearsOptionsIncludingCurrent(true);
		$data['fileToLoad'] = 'investigation_forms/case_investigation_form';
		$data['pageTitle']='Case Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function case_investigation_save(){
		//print_r($_POST);exit();
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
		$baseUrl = base_url();
		//dataEntryValidator(0);
		if(($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year'))
		{
			$year = $this -> input -> post('year');
			$case_type = $this-> input-> post('case_type');
			if($this-> input-> post('rb_distcode'))
			{	//echo "ABC";exit();
				$procode = $this-> input-> post('procode');
			   $distcode = $this-> input-> post('patient_address_distcode');
			   $tcode = $this-> input-> post('patient_address_tcode');
			   $uncode = $this-> input-> post('patient_address_uncode');
				$patient_address_procode = $this-> input-> post('procode');
			   $patient_address_distcode = $this-> input-> post('patient_address_distcode');
			   $patient_address_tcode = $this-> input-> post('patient_address_tcode');
			   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
			}
			if($this -> input -> post('distcode'))
			{	//echo "XYZ";exit();
				$procode = $_SESSION["Province"];
				$distcode = $this -> session -> District;				
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$patient_address_procode = $_SESSION["Province"];
			   $patient_address_distcode = $this-> input-> post('patient_address_distcode');
			  	$patient_address_tcode = $this-> input-> post('patient_address_tcode');
			   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
				
				$query = "SELECT max(case_number) AS case_number FROM case_investigation_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				//echo $result['case_number']; exit();
				$fourdigit_number = sprintf('%04u', ($result['case_number'] + 1)); 
				//$fourdigit_number = $a1.$a2.$a3.$a4;
				//echo $fourdigit_number; exit();
			}
			if($this -> input -> post('edit')){				
				$editted_date = date('Y-m-d');
				$cross_case_id = $this-> input-> post('cross_case_id');
			}
			else{
				$cross_case_id = NULL;
			}
			$cross_notified = ($this-> input-> post('cross_notified'))?$this-> input-> post('cross_notified'):0;
		   $facode = $this-> input-> post('facode');
		   $faddress = $this-> input-> post('faddress');
		   //$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			if(!$this -> input -> post('edit') && $week < 10){
				$fweek = $year.'-0'.$week;
			}
			else{
				$fweek = $year.'-'.$week;
			}
		   $dcode = $this-> input-> post('dcode');
		   $thtcode = $this-> input-> post('th_tcode');
		   $thdistcode = substr($thtcode,0,3);
		   //$epid_year = $this-> input-> post('epid_year');
		  	$epid_year = $this-> input-> post('year');
		   $patient_name = $this-> input-> post('patient_name');
		   $patient_fathername = $this-> input-> post('patient_fathername');
		   $patient_gender = $this-> input-> post('patient_gender');
		   $contact_numb = $this-> input-> post('contact_numb');
		   $age_months = ($this-> input-> post('age_months'))?$this-> input-> post('age_months'):0;
		   // $patient_address_procode = $_SESSION["Province"];
		   $other_pro_district = $this-> input-> post('other_pro_district');
		   $other_pro_tehsil = $this-> input-> post('other_pro_tehsil');
		   $other_pro_uc = $this-> input-> post('other_pro_uc');
		   $patient_address = $this-> input-> post('patient_address');
		   //$case_type = $this-> input-> post('case_type');		   
		   $other_case_representation = $this-> input-> post('other_case_representation');
		   $complications = $this-> input-> post('complications');
		   $other_complication = $this-> input-> post('other_complication');
		   $doses_received = ($this-> input-> post('doses_received'))?$this-> input-> post('doses_received'):0;
			$rb_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):'';
			$rb_tcode = $this-> input-> post('rb_tcode');
			$rb_uncode = $this-> input-> post('rb_uncode');
			$rb_facode = $this-> input-> post('rb_facode');
			$rb_faddress = $this-> input-> post('rb_faddress');
		   $travel_history = $this-> input-> post('travel_history');
		   $th_procode = $this-> input-> post('th_procode');
		   $th_distcode = ($this-> input-> post('th_distcode'))?$this-> input-> post('th_distcode'):$thdistcode;
		   $th_tcode = $this-> input-> post('th_tcode');
		   $th_uncode = $this-> input-> post('th_uncode');
		   $th_province = $this-> input-> post('th_province');
		   $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
		   $th_tehsil = $this-> input-> post('th_tehsil');
		   $th_uc = $this-> input-> post('th_uc');		   
		   $th_muhallah = $this-> input-> post('th_muhallah');
		   $type_specimen = $this-> input-> post('type_specimen');
		   $other_specimen = $this-> input-> post('other_specimen');
		   $labresult_tobesentto = ($this-> input-> post('labresult_tobesentto'))?$this-> input-> post('labresult_tobesentto'):'';
		   $labresult_tobesentto_district = ($this-> input-> post('labresult_tobesentto_district'))?$this-> input-> post('labresult_tobesentto_district'):'';
		   $investigator_name = $this-> input-> post('investigator_name');
		   $investigator_designation = $this-> input-> post('investigator_designation');
		   $outcome = $this-> input-> post('outcome');
		   $complication = $this-> input-> post('complication');
		   $is_temp_saved = $this-> input-> post('is_temp_saved');
		   ////////----------------------- Lab Data--------------------------////////////	   
		   $quantity_adequate = (($this->input->post('quantity_adequate') != '')?$this->input->post('quantity_adequate'):NULL);
		   $cold_chain_ok = (($this->input->post('cold_chain_ok') != '')?$this->input->post('cold_chain_ok'):NULL);
		   $leakage_broken = (($this->input->post('leakage_broken') != '')?$this->input->post('leakage_broken'):NULL);
		   $test_possible = (($this->input->post('test_possible') != '')?$this->input->post('test_possible'):NULL);
			$specimen_received_by = (($this->input->post('specimen_received_by') != '')?$this->input->post('specimen_received_by'):NULL);
			$received_by_designation = (($this->input->post('received_by_designation') != '')?$this->input->post('received_by_designation'):NULL);
			$lab_id_number = (($this->input->post('lab_id_number') != '')?$this->input->post('lab_id_number'):NULL);			
			$type_of_test = (($this->input->post('type_of_test') != '')?$this->input->post('type_of_test'):NULL);
			$specimen_result = (($this->input->post('specimen_result') != '')?$this->input->post('specimen_result'):NULL);
			$other_specimen_result = (($this->input->post('other_specimen_result') != '')?$this->input->post('other_specimen_result'):NULL);
			$other_specimen_lab = (($this->input->post('other_specimen_lab') != '')?$this->input->post('other_specimen_lab'):NULL);
			$comments = (($this->input->post('comments') != '')?$this->input->post('comments'):NULL);
			$report_sent_by = (($this->input->post('report_sent_by') != '')?$this->input->post('report_sent_by'):NULL);	
			$sent_by_designation = (($this->input->post('sent_by_designation') != '')?$this->input->post('sent_by_designation'):NULL);
			$report_submit_status = 1;
			//--------------------------------Lab Dates -------------------------------//		   
			$specimen_received_date = ($this-> input-> post('specimen_received_date'))?date('Y-m-d', strtotime($this-> input-> post('specimen_received_date'))):NULL;
			$lab_testdone_date = ($this-> input-> post('lab_testdone_date'))?date('Y-m-d', strtotime($this-> input-> post('lab_testdone_date'))):NULL;		   
			$lab_report_sent_date = ($this-> input-> post('lab_report_sent_date'))?date('Y-m-d', strtotime($this-> input-> post('lab_report_sent_date'))):NULL;		   		   
			$result_saved_date = date('Y-m-d');
		   //--------------------------------- Dates ---------------------------------//
			/////////////////////////////////////////////////////////////////////////////					
		   $datefrom = ($this-> input-> post('datefrom'))?date('Y-m-d', strtotime($this-> input-> post('datefrom'))):NULL;		   
		   $dateto = ($this-> input-> post('dateto'))?date('Y-m-d', strtotime($this-> input-> post('dateto'))):NULL;
		   $pvh_date = ($this-> input-> post('pvh_date'))?date('Y-m-d', strtotime($this-> input-> post('pvh_date'))):NULL;
		   $patient_dob = ($this-> input-> post('patient_dob'))?date('Y-m-d', strtotime($this-> input-> post('patient_dob'))):NULL;
		   $date_rash_onset = ($this-> input-> post('date_rash_onset'))?date('Y-m-d', strtotime($this-> input-> post('date_rash_onset'))):NULL;
		   $notification_date = ($this-> input-> post('notification_date'))?date('Y-m-d', strtotime($this-> input-> post('notification_date'))):NULL;
		   $date_investigation = ($this-> input-> post('date_investigation'))?date('Y-m-d', strtotime($this-> input-> post('date_investigation'))):NULL;
		   $last_dose_date = ($this-> input-> post('last_dose_date'))?date('Y-m-d', strtotime($this-> input-> post('last_dose_date'))):NULL;
		   $date_collection = ($this-> input-> post('date_collection'))?date('Y-m-d', strtotime($this-> input-> post('date_collection'))):NULL;
		   $date_sent_lab = ($this-> input-> post('date_sent_lab'))?date('Y-m-d', strtotime($this-> input-> post('date_sent_lab'))):NULL;
		   $followup_date = ($this-> input-> post('followup_date'))?date('Y-m-d', strtotime($this-> input-> post('followup_date'))):NULL;
		   $death_date = ($this-> input-> post('death_date'))?date('Y-m-d', strtotime($this-> input-> post('death_date'))):NULL;
		   $submitted_date = ($this-> input-> post('submitted_date'))?date('Y-m-d', strtotime($this-> input-> post('submitted_date'))):NULL;
			//--------------------------------- Array ---------------------------------//
			/////////////////////////////////////////////////////////////////////////////	
		   //$clinical_representation = $this-> input-> post('clinical_representation');
		   $symptomlist = ($this-> input-> post('clinical_representation'))?$this-> input-> post('clinical_representation'):0;
		   //$case_representation=NULL;
			if(isset($symptomlist) && $symptomlist!=''){
				foreach($symptomlist as $row){
					$newlist[] = $row;
				}
				$symptoms=implode(',',$newlist);
			}
			$clinical_representation=$symptoms;
			//$clinical_representation=$symptomlist;
			if($this -> input-> post('edit') && $_SESSION["Province"] != $this-> input-> post('procode')){
		   	$clinical_representation = ($this-> input-> post('clinical_representation'))?$this-> input-> post('clinical_representation'):0;
		   }
			$query = "SELECT max(cn_id_from) AS cn_id_from FROM case_investigation_db";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			//echo $result['case_number']; exit();
			//$cn_id_from = sprintf('%04u', ($result['cn_id_from'] + 1));
			$cn_id_from = $result['cn_id_from'] + 1;
			/////////////////////////////////////////
			if(!$this -> input-> post('edit') && $this -> input -> post('cross_notified') != 1 && $this -> input -> post('distcode')){
				//echo "KLM1";exit();
				$case_number = $fourdigit_number;
				$case_epi_no = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".$case_number;
				$cross_notified_from_distcode = '';
				$approval_status = NULL;
			}
		
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') == 1 && $this -> input-> post('id') && $this -> input-> post('case_epi_no') != ''){
				//echo "ABC";exit();
				$id = $this -> input -> post('id');
				$editApproved = "SELECT facode, distcode, procode, patient_address_procode, clinical_representation, case_epi_no, case_number, cross_notified_from_distcode, approval_status, submitted_date from case_investigation_db where id = '$id'";
				$result = $this -> db -> query($editApproved);
				$result = $result -> row_array();
				$facode = $result['facode'];
				$distcode = $result['distcode'];
				$procode = $result['procode'];				
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];	
				$clinical_representation = $result['clinical_representation'];			
				$approval_status = $result['approval_status'];
				$submitted_date = $result['submitted_date'];
				$patient_address_procode = $result['patient_address_procode'];
				$cross_notified_from_distcode = $result['cross_notified_from_distcode'];
			}
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') != 1 && $this -> input-> post('id') && $this -> input-> post('case_epi_no') != ''){
				//echo "xyz";exit();
				$id = $this -> input -> post('id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, clinical_representation, submitted_date from case_investigation_db where id = '$id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];						
				$clinical_representation = $result['clinical_representation'];
				$submitted_date = $result['submitted_date'];
				$cross_notified_from_distcode = '';
				$approval_status = NULL;	
			}
			else{
				//echo "KLM3";exit();
				if($this -> input -> post('edit') && $this -> input -> post('id') && $this -> input-> post('case_epi_no') == ''){
					//echo "abc";exit();
					$id = $this -> input -> post('id');
					$editNotApproved = "SELECT clinical_representation, submitted_date from case_investigation_db where id = '$id'";
					$result = $this -> db -> query($editNotApproved);
					$result = $result -> row_array();					
					$clinical_representation = $result['clinical_representation'];
					$submitted_date = $result['submitted_date'];
					$tcode = $this-> input-> post('patient_address_tcode');
		   		$uncode = $this-> input-> post('patient_address_uncode');
		   		if($tcode != ''){
						$distcode = substr($tcode, 0,3);
		   		}
		   		else{
		   			$distcode = $this-> input-> post('patient_address_distcode');
		   		}
		   		$th_procode = $this-> input-> post('th_procode');
		   		$th_tcode = $this-> input-> post('th_tcode');
		   		$thdistcode = substr($th_tcode, 0,3);
				   $th_uncode = $this-> input-> post('th_uncode');
				   $th_distcode = ($this-> input-> post('th_distcode'))?$this-> input-> post('th_distcode'):$thdistcode;
				   $rb_facode = $this-> input-> post('rb_facode');
				   $th_province = $this-> input-> post('th_province');
				   $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
				   $th_tehsil = $this-> input-> post('th_tehsil');
				   $th_uc = $this-> input-> post('th_uc');		
					$cross_notified_from_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):$this -> session -> District;
					$approval_status= "Pending";
					$case_epi_no= NULL;
					$case_number= 0;
				}
				if(!$this -> input -> post('edit') && !$this -> input -> post('id') && $this -> input-> post('cross_notified') == 1){
					//echo "abc2";exit();
					$tcode = $this-> input-> post('patient_address_tcode');
			   	$uncode = $this-> input-> post('patient_address_uncode');
					$distcode = substr($tcode, 0,3);
					$patient_address_tcode = $this-> input-> post('patient_address_tcode');
				   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
				   $patient_address_distcode = substr($patient_address_tcode, 0,3);
				   
				   $rb_facode = $this-> input-> post('rb_facode');
				   $th_province = $this-> input-> post('th_province');
				   $th_district = $this-> input-> post('th_district');
				   $th_tehsil = $this-> input-> post('th_tehsil');
				   $th_uc = $this-> input-> post('th_uc');		   
					$cross_notified_from_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):$this -> session -> District;
					$approval_status = "Pending";
					$case_epi_no = NULL;
					$case_number = 0;
				}
			}

			if($labresult_tobesentto_district != ''){
				$labresult_tobesentto = '';
			}
			if($th_distcode == 'FALSE' || $th_distcode == NULL){
				$th_distcode = '';
			}
			//////////////////////////////////////////
		   $DataArray=array(
		   	'procode' => $procode,
				'distcode' => $distcode,
				'tcode' => $tcode,		   
			   'uncode' => $uncode,
			   'facode' => $facode,
			   'faddress' => $faddress,
			   'cross_notified_from_distcode' => $cross_notified_from_distcode,
			   'cross_notified' => $cross_notified,
			   'approval_status' => $approval_status,
			   'year' => $year,
				'week' => $week,
				'fweek' => $fweek,
			   'dcode' => $dcode,
			   'epid_year' => $epid_year,
			   'case_epi_no' => $case_epi_no,
			   'case_number' => $case_number,
			   'patient_name' =>  $patient_name,
			   'patient_fathername' => $patient_fathername,
			   'patient_gender' => $patient_gender,
			   'contact_numb' => $contact_numb,
			   'age_months' => $age_months,
			   'patient_address_procode' => $patient_address_procode,
			   'patient_address_distcode' => $patient_address_distcode,
			   'patient_address_tcode' => $patient_address_tcode,
			   'patient_address_uncode' => $patient_address_uncode,
			   'patient_address' => $patient_address,
			   'case_type' => $case_type,	
			   'clinical_representation' => $clinical_representation,	   
			   'other_case_representation' => $other_case_representation,
			   'complications' => $complications,
			   'other_complication' => $other_complication,
			   'doses_received' => $doses_received,
			   'rb_distcode' => ($rb_distcode)?$rb_distcode:'',
				'rb_tcode' => $rb_tcode,
				'rb_uncode' => $rb_uncode,
				'rb_facode' => $rb_facode,
				'rb_faddress' => $rb_faddress,
			   'travel_history' => $travel_history,
			   'th_procode' => $th_procode,
			   'th_distcode' => $th_distcode,
			   'th_tcode' => $th_tcode,
			   'th_uncode' => $th_uncode,
			   'th_province' => $th_province,
			   'th_district' => $th_district,
			   'th_tehsil' => $th_tehsil,
			   'th_uc' => $th_uc,
			   'th_muhallah' => $th_muhallah,
			   'type_specimen' => $type_specimen,
			   'other_specimen' => $other_specimen,
			   'labresult_tobesentto' => $labresult_tobesentto,
			   'labresult_tobesentto_district' => $labresult_tobesentto_district,
			   'investigator_name' => $investigator_name,
			   'investigator_designation' => $investigator_designation,
			   'outcome' => $outcome,
			   'complication' => $complication,
			   'is_temp_saved' => $is_temp_saved,
			   'cn_id_from' => $cn_id_from,
			   'cross_case_id' => $cross_case_id,
			   //----------- Dates -------------//
			   'datefrom' => (isset($datefrom) AND $datefrom != '')?$datefrom:NULL,		   
			   'dateto' => (isset($dateto) AND $dateto != '')?$dateto:NULL,
			   'pvh_date' => (isset($pvh_date) AND $pvh_date != '')?$pvh_date:NULL,			   
			   'patient_dob' => (isset($patient_dob) AND $patient_dob != '')?$patient_dob:NULL,	
			   'date_rash_onset' => (isset($date_rash_onset) AND $date_rash_onset != '')?$date_rash_onset:NULL,
			   'notification_date' => (isset($notification_date) AND $notification_date != '')?$notification_date:NULL,
			   'date_investigation' => (isset($date_investigation) AND $date_investigation != '')?$date_investigation:NULL,
			   'date_collection' => (isset($date_collection) AND $date_collection != '')?$date_collection:NULL,
			   'last_dose_date' => (isset($last_dose_date) AND $last_dose_date != '')?$last_dose_date:NULL,
			   'date_sent_lab' => (isset($date_sent_lab) AND $date_sent_lab != '')?$date_sent_lab:NULL,
			   'followup_date' => (isset($followup_date) AND $followup_date != '')?$followup_date:NULL,
			   'death_date' => (isset($death_date) AND $death_date != '')?$death_date:NULL,
			   'submitted_date' => (isset($submitted_date) AND $submitted_date != '')?$submitted_date:NULL,
			   'editted_date' => (isset($editted_date) AND $editted_date != '')?$editted_date:NULL,
			   //----------- Lab Data -------------//
			   'quantity_adequate' => $quantity_adequate,
			   'cold_chain_ok' => $cold_chain_ok,
			   'leakage_broken' => $leakage_broken,
			   'test_possible' => $test_possible,
				'specimen_received_by' => $specimen_received_by,
				'received_by_designation' => $received_by_designation,
				'lab_id_number' => $lab_id_number,
				'type_of_test' => $type_of_test,
				'specimen_result' => $specimen_result,
				'other_specimen_result' => $other_specimen_result,
				'other_specimen_lab' => $other_specimen_lab, 
				'comments' => $comments,
				'report_sent_by' => $report_sent_by, 
				'sent_by_designation' => $sent_by_designation,
				'report_submit_status' => $report_submit_status,
			   //----------- Lab Dates ------------//
			   'specimen_received_date' => (isset($specimen_received_date) AND $specimen_received_date != '')?$specimen_received_date:NULL,	
				'lab_testdone_date' => (isset($lab_testdone_date) AND $lab_testdone_date != '')?$lab_testdone_date:NULL,	
				'lab_report_sent_date' => (isset($lab_report_sent_date) AND $lab_report_sent_date != '')?$lab_report_sent_date:NULL,	 		   		   
				'result_saved_date' => (isset($result_saved_date) AND $result_saved_date != '')?$result_saved_date:NULL 
			);

			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{	
				$DataArray['id'] = $id = $this -> input -> post('id'); 
				//print_r($DataArray);exit();
				$updated_id = $this -> Common_model -> update_record('case_investigation_db',$DataArray,array('id' => $id/*,'distcode' => $DataArray['distcode']*/));
				if(($procode != $_SESSION["Province"]) || ($approval_status == 'Approved')){
					$DataArray['edit'] = $edit = $this -> input -> post('edit');
					$filepath = 'Case_investigation/case_investigation_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $DataArray);
				}
				//if($baseUrl == $liveUrl){
				syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				$doses_received = ($doses_received > 2)?99:$doses_received;
				if($cross_notified != 1){
				
				syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Case_investigation/case_investigation_list');
			}
			else{
				if($this -> input -> post('cross_notified') == 1 && !$this -> input -> post('cross_case_id')){
					//echo "a";exit();
					$rcode = $this -> session -> District;
					$DataArray['cross_case_id'] = $cross_case_id = $rcode.'-'.$distcode.'-'.$cn_id_from;
				}
				else if($this -> input -> post('cross_notified') == 1 && $this -> input -> post('cross_case_id')){
					//echo "b";exit();
					$DataArray['cross_case_id'] = $this -> input -> post('cross_case_id');
				}
				else{
					//echo "c";exit();
					$DataArray['cross_case_id'] = NULL;
				}
				$inserted_id = $this -> Common_model -> insert_record('case_investigation_db',$DataArray);
				$query = "SELECT max(id) AS id FROM case_investigation_db";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				//echo $result['case_number']; exit();
				//$cn_id_from = sprintf('%04u', ($result['cn_id_from'] + 1));
				$DataArray['cn_id_to'] = $cn_id_to = $result['id'];
				if($procode != $_SESSION["Province"]){
					$filepath = 'Case_investigation/case_investigation_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $DataArray);
				}
				//if($baseUrl == $liveUrl){
				syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				$doses_received = ($doses_received > 2)?99:$doses_received;
				if($cross_notified != 1){
				syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('Case_investigation/case_investigation_list');				
			}
		}		
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('Case_investigation/case_investigation_list');
		}
	}
	
	public function caseInvestigation_Approve(){
		/////parameter for sync by usama /////
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('week');
		$case_type = $this -> input -> post('case_type');
		$sdistcode = $this -> input -> post('distcode');
		$patient_gender = $this -> input -> post('gender');
		$doses_received = $this -> input -> post('doses_received');
		//////////end
		//dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "SELECT epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['patient_address_uncode'] = $this -> input -> post('uncode');
			$data['patient_address_tcode'] = $this -> input -> post('tcode');
			$data['case_number'] = $this -> input -> post('case_number');
			$data['cross_case_id'] = $this -> input -> post('cross_case_id');
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('case_investigation_db',$data,array('id' => $this->input->post('id')));
			syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$sdistcode,$doses_received,$patient_gender);
			if($procode != $_SESSION["Province"]){
				$filepath = 'Case_investigation/caseApprove_and_save'; 
				$url = $this -> getSingleRegionUrl($procode); 
				$dataMeasles = $this -> getDataToSave($url, $filepath,$data); 
			}
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Case_investigation/case_investigation_list');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}	
	public function caseApprove_and_save(){
		//dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "SELECT epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['patient_address_uncode'] = $this -> input -> post('uncode');
			$data['patient_address_tcode'] = $this -> input -> post('tcode');
			$data['case_number'] = $this -> input -> post('case_number');
			//$data['cross_case_id'] = $this -> input -> post('cross_case_id');
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('case_investigation_db',$data,array('cross_case_id' => $this->input->post('cross_case_id')));			
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Case_investigation/case_investigation_list');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}	
	public function case_investigation_edit(){
		//dataEntryValidator(0);
		//$facode = $this -> uri -> segment(3);
		$distcode = $this -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		//$year = date('Y');
		$id = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$data['measles_Result'] = $this -> Common_model -> get_info('case_investigation_db', '', '','*', array('id' => $id));
		$clinicalrep = $data['measles_Result']->clinical_representation;
		$clinicalrep = str_replace(',', "','", $clinicalrep);
		$viewData = "SELECT array_to_string(array_agg(case_type_definition), ', ') as symptoms from case_clinical_representation where id in ('".$clinicalrep."')";
		$result = $this -> db -> query($viewData);
		$result = $result -> row_array();
		$data['measles_Result']->symptoms = $result["symptoms"];

		if($data['measles_Result']->case_reported == 0){
			$case_type = $data['measles_Result']->case_type;
			$query = "SELECT max(case_number) as case_number from case_investigation_db where year='$year' AND dcode='$dcode' AND case_type='$case_type'";
			$result = $this -> db -> query($query);        
			$result = $result -> row_array();
			$data['measleNumber'] = str_split(sprintf('%04u', ($result['case_number'] + 1)));
		}
		else{
			$data['measleNumber'] = str_split(sprintf('%04u', ($data['measles_Result']->case_number)));	
		}
		//$data['measles_Result'] = $this -> Common_model -> get_info('case_investigation_db', '', '','*', array('id' => $id, 'facode' => $facode));
		$data['unioncouncil']=get_UC_Name($data['measles_Result']->uncode);
		$data['facility']=get_Facility_Name($data['measles_Result']->facode);
		$data['tehsil']=get_Tehsil_Name($data['measles_Result']->tcode);
		$data['rbfacility']=get_Facility_Name($data['measles_Result']->rb_facode);
		
		//$data['rbuncode']=get_UC_Name($data['measles_Result']->rb_uncode);
		$data['edit']="Yes";
		if($data != 0){			
			$data1['data']=$data;
			//print_r($data1['data']);exit();
			$data1['fileToLoad'] = 'investigation_forms/case_investigation_form_edit';
			$data1['pageTitle']='Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data1);
			//template_loader('investigation_forms/measles_case_investigation_form', $data, array($this->_module));
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}		
	
	public function case_investigation_view(){
		$id = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$data['a'] = $this -> Common_model -> get_info('case_investigation_db', '', '','*', array('id' => $id));
		$clinicalrep = $data['a']->clinical_representation;
		$clinicalrep = str_replace(',', "','", $clinicalrep);
		$viewData = "SELECT array_to_string(array_agg(case_type_definition), ', ') as symptoms from case_clinical_representation where id in ('".$clinicalrep."')";
		$result = $this -> db -> query($viewData);
		$result = $result -> row_array();
		$data['a']->symptoms = $result["symptoms"];
		//print_r($data);exit;
		// $viewData = $result;
		// $query = "SELECT clinical_representation from case_investigation_db where id='$id'";
		// $result = $this -> db -> query($query);        
		// $result = $result -> row_array();
		// $data['clinical_representation'] = $result['clinical_representation'];
		$data['edit']="Yes";
		if($data != 0){
			$data1['data']=$data;
			//print_r($data1['data']);exit();
			$data1['fileToLoad'] = 'investigation_forms/case_investigation_form_view';
			$data1['pageTitle']='Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data1);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	
	///////////////////////////////////AFP Approve/////////////////////////////////////////////////////////////////////////
	public function afp_Approve(){
		dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "select epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['afp_number'] = $this -> input -> post('afp_number');
			$data['approval_status'] = "Approved";
			$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('id' => $this->input->post('id')));
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('AFP-CIF/List');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}

	public function case_investigation_receive_and_save(){
		//print_r($_POST);exit();
		//dataEntryValidator(0);
		//if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && ($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year'))
		if($this -> input -> post('cross_notified') && $this -> input -> post('year'))
		{
			$year = $this -> input -> post('year');
			$case_type = $this-> input-> post('case_type');
			if($this-> input-> post('rb_distcode'))
			{	//echo "ABC";exit();
				$procode = $this-> input-> post('procode');
			   $distcode = $this-> input-> post('patient_address_distcode');
			   $tcode = $this-> input-> post('patient_address_tcode');
			   $uncode = $this-> input-> post('patient_address_uncode');
				$patient_address_procode = $this-> input-> post('procode');
			   $patient_address_distcode = $this-> input-> post('other_pro_district');
			   $patient_address_tcode = $this-> input-> post('other_pro_tehsil');
			   $patient_address_uncode = $this-> input-> post('other_pro_uc');
			}
			if($this -> input -> post('distcode'))
			{	//echo "XYZ";exit();
				$procode = $this-> input-> post('procode');
				$distcode = $this -> input -> post('distcode');				
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$patient_address_procode = $this-> input-> post('procode');
			   $patient_address_distcode = $this-> input-> post('patient_address_distcode');
			  	$patient_address_tcode = $this-> input-> post('patient_address_tcode');
			   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
				
				$query = "SELECT max(case_number) AS case_number FROM case_investigation_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				//echo $result['case_number']; exit();
				$fourdigit_number = sprintf('%04u', ($result['case_number'] + 1)); 
				//$fourdigit_number = $a1.$a2.$a3.$a4;
				//echo $fourdigit_number; exit();
			}
			if($this -> input -> post('edit')){				
				$editted_date = date('Y-m-d');				
			}
			$cross_notified = ($this-> input-> post('cross_notified'))?$this-> input-> post('cross_notified'):0;
		   $facode = $this-> input-> post('facode');
		   $faddress = $this-> input-> post('faddress');
		   //$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			if(!$this -> input -> post('edit') && $week < 10){
				$fweek = $year.'-0'.$week;
			}
			else{
				$fweek = $year.'-'.$week;
			}
		   $dcode = $this-> input-> post('dcode');
		   $thtcode = $this-> input-> post('th_tcode');
		   $thdistcode = substr($thtcode,0,3);
		   $dcode = (($this->input->post('dcode') != '')?$this->input->post('dcode'):$this-> input-> post('patient_address_distcode'));
		   //$epid_year = $this-> input-> post('epid_year');
		  	$epid_year = $this-> input-> post('year');
		   $patient_name = $this-> input-> post('patient_name');
		   $patient_fathername = $this-> input-> post('patient_fathername');
		   $patient_gender = $this-> input-> post('patient_gender');
		   $contact_numb = $this-> input-> post('contact_numb');
		   $age_months = ($this-> input-> post('age_months'))?$this-> input-> post('age_months'):0;
		   // $patient_address_procode = $_SESSION["Province"];		  
		   $patient_address = $this-> input-> post('patient_address');
		   //$case_type = $this-> input-> post('case_type');		   
		   $other_case_representation = $this-> input-> post('other_case_representation');
		   $complications = $this-> input-> post('complications');
		   $other_complication = $this-> input-> post('other_complication');
		   $doses_received = ($this-> input-> post('doses_received'))?$this-> input-> post('doses_received'):0;
			$rb_distcode = $this-> input-> post('rb_distcode');
			$rb_tcode = $this-> input-> post('rb_tcode');
			$rb_uncode = $this-> input-> post('rb_uncode');
			$rb_facode = $this-> input-> post('rb_facode');
			$rb_faddress = $this-> input-> post('rb_faddress');
		   $travel_history = $this-> input-> post('travel_history');
		   $th_procode = $this-> input-> post('th_procode');
		   $th_distcode = ($this-> input-> post('th_distcode'))?$this-> input-> post('th_distcode'):$thdistcode;
		   $th_tcode = $this-> input-> post('th_tcode');
		   $th_uncode = $this-> input-> post('th_uncode');
		   $th_province = $this-> input-> post('th_province');
		   $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
		   $th_tehsil = $this-> input-> post('th_tehsil');
		   $th_uc = $this-> input-> post('th_uc');		   
		   $th_muhallah = $this-> input-> post('th_muhallah');
		   $type_specimen = $this-> input-> post('type_specimen');
		   $other_specimen = $this-> input-> post('other_specimen');
		   $labresult_tobesentto = ($this-> input-> post('labresult_tobesentto'))?$this-> input-> post('labresult_tobesentto'):'';
		   $labresult_tobesentto_district = ($this-> input-> post('labresult_tobesentto_district'))?$this-> input-> post('labresult_tobesentto_district'):'';
		   $investigator_name = $this-> input-> post('investigator_name');
		   $investigator_designation = $this-> input-> post('investigator_designation');
		   $outcome = $this-> input-> post('outcome');
		   $complication = $this-> input-> post('complication');
		   $is_temp_saved = $this-> input-> post('is_temp_saved');
		   $cn_id_from = $this-> input-> post('cn_id_from');
		   $cn_id_to = $this-> input-> post('cn_id_to');
		   $cross_case_id = $this-> input-> post('cross_case_id');
		   ////////----------------------- Lab Data--------------------------////////////	   
		   $quantity_adequate = (($this->input->post('quantity_adequate') != '')?$this->input->post('quantity_adequate'):NULL);
		   $cold_chain_ok = (($this->input->post('cold_chain_ok') != '')?$this->input->post('cold_chain_ok'):NULL);
		   $leakage_broken = (($this->input->post('leakage_broken') != '')?$this->input->post('leakage_broken'):NULL);
		   $test_possible = (($this->input->post('test_possible') != '')?$this->input->post('test_possible'):NULL);
			$specimen_received_by = (($this->input->post('specimen_received_by') != '')?$this->input->post('specimen_received_by'):NULL);
			$received_by_designation = (($this->input->post('received_by_designation') != '')?$this->input->post('received_by_designation'):NULL);
			$lab_id_number = (($this->input->post('lab_id_number') != '')?$this->input->post('lab_id_number'):NULL);			
			$type_of_test = (($this->input->post('type_of_test') != '')?$this->input->post('type_of_test'):NULL);
			$specimen_result = (($this->input->post('specimen_result') != '')?$this->input->post('specimen_result'):NULL);
			$other_specimen_result = (($this->input->post('other_specimen_result') != '')?$this->input->post('other_specimen_result'):NULL);
			$other_specimen_lab = (($this->input->post('other_specimen_lab') != '')?$this->input->post('other_specimen_lab'):NULL);
			$comments = (($this->input->post('comments') != '')?$this->input->post('comments'):NULL);
			$report_sent_by = (($this->input->post('report_sent_by') != '')?$this->input->post('report_sent_by'):NULL);	
			$sent_by_designation = (($this->input->post('sent_by_designation') != '')?$this->input->post('sent_by_designation'):NULL);
			$report_submit_status = 1;
			//--------------------------------Lab Dates -------------------------------//		   
			$specimen_received_date = ($this-> input-> post('specimen_received_date'))?date('Y-m-d', strtotime($this-> input-> post('specimen_received_date'))):NULL;
			$lab_testdone_date = ($this-> input-> post('lab_testdone_date'))?date('Y-m-d', strtotime($this-> input-> post('lab_testdone_date'))):NULL;		   
			$lab_report_sent_date = ($this-> input-> post('lab_report_sent_date'))?date('Y-m-d', strtotime($this-> input-> post('lab_report_sent_date'))):NULL;		   		   
			$result_saved_date = date('Y-m-d');
		   //--------------------------------- Dates ---------------------------------//
			/////////////////////////////////////////////////////////////////////////////					
		   $datefrom = ($this-> input-> post('datefrom'))?date('Y-m-d', strtotime($this-> input-> post('datefrom'))):NULL;		   
		   $dateto = ($this-> input-> post('dateto'))?date('Y-m-d', strtotime($this-> input-> post('dateto'))):NULL;
		   $pvh_date = ($this-> input-> post('pvh_date'))?date('Y-m-d', strtotime($this-> input-> post('pvh_date'))):NULL;
		   $patient_dob = ($this-> input-> post('patient_dob'))?date('Y-m-d', strtotime($this-> input-> post('patient_dob'))):NULL;
		   $date_rash_onset = ($this-> input-> post('date_rash_onset'))?date('Y-m-d', strtotime($this-> input-> post('date_rash_onset'))):NULL;
		   $notification_date = ($this-> input-> post('notification_date'))?date('Y-m-d', strtotime($this-> input-> post('notification_date'))):NULL;
		   $date_investigation = ($this-> input-> post('date_investigation'))?date('Y-m-d', strtotime($this-> input-> post('date_investigation'))):NULL;
		   $last_dose_date = ($this-> input-> post('last_dose_date'))?date('Y-m-d', strtotime($this-> input-> post('last_dose_date'))):NULL;
		   $date_collection = ($this-> input-> post('date_collection'))?date('Y-m-d', strtotime($this-> input-> post('date_collection'))):NULL;
		   $date_sent_lab = ($this-> input-> post('date_sent_lab'))?date('Y-m-d', strtotime($this-> input-> post('date_sent_lab'))):NULL;
		   $followup_date = ($this-> input-> post('followup_date'))?date('Y-m-d', strtotime($this-> input-> post('followup_date'))):NULL;
		   $death_date = ($this-> input-> post('death_date'))?date('Y-m-d', strtotime($this-> input-> post('death_date'))):NULL;
		   $submitted_date = ($this-> input-> post('submitted_date'))?date('Y-m-d', strtotime($this-> input-> post('submitted_date'))):NULL;
			//--------------------------------- Array ---------------------------------//
			/////////////////////////////////////////////////////////////////////////////	
		 
			if(!$this -> input-> post('edit') && $this -> input -> post('cross_notified') != 1 && $this -> input -> post('distcode')){
				//echo "KLM1";exit();
				$case_number = $fourdigit_number;
				$case_epi_no = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/".$case_type."/".$case_number;
				$cross_notified_from_distcode = '';
				$approval_status = NULL;
			}		
			else if($this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1 && ($this -> input-> post('case_epi_no') != '' || $this -> input-> post('case_epi_no') != NULL)){
				//echo "abc";exit();
				$cross_case_id = $this -> input -> post('cross_case_id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, clinical_representation, submitted_date from case_investigation_db where cross_case_id = '$cross_case_id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];	
				$result = $this -> db -> query($editNotApproved);
				$result = $result -> row_array();					
				$clinical_representation = $result['clinical_representation'];
				$submitted_date = $result['submitted_date'];
				$tcode = $this-> input-> post('patient_address_tcode');
		   	$uncode = $this-> input-> post('patient_address_uncode');
				$distcode = substr($tcode, 0,3);
			   $rb_facode = $this-> input-> post('rb_facode');
			   $th_province = $this-> input-> post('th_province');
			   $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
			   $th_tehsil = $this-> input-> post('th_tehsil');
			   $th_uc = $this-> input-> post('th_uc');				   
				$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
				$approval_status= "Approved";
				// $case_epi_no= NULL;
				// $case_number= 0;
			}
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') != 1 && $this -> input-> post('cross_case_id') && $this -> input-> post('case_epi_no') != ''){
				$cross_case_id = $this -> input -> post('cross_case_id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, clinical_representation, submitted_date from case_investigation_db where cross_case_id = '$cross_case_id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];						
				$clinical_representation = $result['clinical_representation'];
				$submitted_date = $result['submitted_date'];
				$cross_notified_from_distcode = '';
				$approval_status = NULL;	
			}
			else{
				//echo "KLM3";exit();
				if($this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1 && $this -> input-> post('case_epi_no') == ''){
					//echo "abc";exit();
					$cross_case_id = $this -> input -> post('cross_case_id');
					$editNotApproved = "SELECT clinical_representation, submitted_date from case_investigation_db where cross_case_id = '$cross_case_id'";
					$result = $this -> db -> query($editNotApproved);
					$result = $result -> row_array();					
					$clinical_representation = $result['clinical_representation'];
					$submitted_date = $result['submitted_date'];
					$tcode = $this-> input-> post('patient_address_tcode');
		   		$uncode = $this-> input-> post('patient_address_uncode');
		   		$distcode = substr($tcode, 0,3);
		   		$th_procode = $this-> input-> post('th_procode');
		   		$th_tcode = $this-> input-> post('th_tcode');
		   		$thdistcode = substr($th_tcode, 0,3);
				   $th_uncode = $this-> input-> post('th_uncode');
				   $th_distcode = ($this-> input-> post('th_distcode'))?$this-> input-> post('th_distcode'):$thdistcode;
				   $rb_facode = $this-> input-> post('rb_facode');
				   $th_province = $this-> input-> post('th_province');
				   $th_district = $this-> input-> post('th_district');
				   $th_tehsil = $this-> input-> post('th_tehsil');
				   $th_uc = $this-> input-> post('th_uc');		
					$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
					$approval_status= "Pending";
					$case_epi_no= NULL;
					$case_number= 0;
				}
				if(!$this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1){
					//echo "abc2";exit();
					$tcode = $this-> input-> post('patient_address_tcode');
			   	$uncode = $this-> input-> post('patient_address_uncode');
					$distcode = substr($tcode, 0,3);
					$patient_address_tcode = $this-> input-> post('patient_address_tcode');
				   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
				   $patient_address_distcode = substr($patient_address_tcode, 0,3);
				   $rb_facode = $this-> input-> post('rb_facode');
				   $th_province = $this-> input-> post('th_province');
				   $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
				   $th_tehsil = $this-> input-> post('th_tehsil');
				   $th_uc = $this-> input-> post('th_uc');		   
					$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
					$approval_status = "Pending";
					$case_epi_no = NULL;
					$case_number = 0;
				}
			}

			$clinical_representation = ($this-> input-> post('clinical_representation'))?$this-> input-> post('clinical_representation'):0;
		   
			if($labresult_tobesentto_district != ''){
				$labresult_tobesentto = '';
			}
			if($th_distcode == 'FALSE' || $th_distcode == NULL){
				$th_distcode = '';
			}
			//////////////////////////////////////////
		   $DataArray=array(
		   	'procode' => $procode,
				'distcode' => $distcode,
				'tcode' => $tcode,		   
			   'uncode' => $uncode,
			   'facode' => $facode,
			   'faddress' => $faddress,
			   'cross_notified_from_distcode' => $cross_notified_from_distcode,
			   'cross_notified' => $cross_notified,
			   'approval_status' => $approval_status,
			   'year' => $year,
				'week' => $week,
				'fweek' => $fweek,
			   'dcode' => $dcode,
			   'epid_year' => $epid_year,
			   'case_epi_no' => $case_epi_no,
			   'case_number' => $case_number,
			   'patient_name' =>  $patient_name,
			   'patient_fathername' => $patient_fathername,
			   'patient_gender' => $patient_gender,
			   'contact_numb' => $contact_numb,
			   'age_months' => $age_months,
			   'patient_address_procode' => $patient_address_procode,
			   'patient_address_distcode' => $patient_address_distcode,
			   'patient_address_tcode' => $patient_address_tcode,
			   'patient_address_uncode' => $patient_address_uncode,
			   'patient_address' => $patient_address,
			   'case_type' => $case_type,	
			   'clinical_representation' => $clinical_representation,	   
			   'other_case_representation' => $other_case_representation,
			   'complications' => $complications,
			   'other_complication' => $other_complication,
			   'doses_received' => $doses_received,
			   'rb_distcode' => ($rb_distcode)?$rb_distcode:'',
				'rb_tcode' => $rb_tcode,
				'rb_uncode' => $rb_uncode,
				'rb_facode' => $rb_facode,
				'rb_faddress' => $rb_faddress,
			   'travel_history' => $travel_history,
			   'th_procode' => $th_procode,
			   'th_distcode' => $th_distcode,
			   'th_tcode' => $th_tcode,
			   'th_uncode' => $th_uncode,
			   'th_province' => $th_province,
			   'th_district' => $th_district,
			   'th_tehsil' => $th_tehsil,
			   'th_uc' => $th_uc,
			   'th_muhallah' => $th_muhallah,
			   'type_specimen' => $type_specimen,
			   'other_specimen' => $other_specimen,
			   'labresult_tobesentto' => $labresult_tobesentto,
			   'labresult_tobesentto_district' => $labresult_tobesentto_district,
			   'investigator_name' => $investigator_name,
			   'investigator_designation' => $investigator_designation,
			   'outcome' => $outcome,
			   'complication' => $complication,
			   'is_temp_saved' => $is_temp_saved,
			   'cn_id_from' => $cn_id_from,
			   'cn_id_to' => $cn_id_to,
			   'cross_case_id' => $cross_case_id,
			   //----------- Dates -------------//
			   'datefrom' => (isset($datefrom) AND $datefrom != '')?$datefrom:NULL,		   
			   'dateto' => (isset($dateto) AND $dateto != '')?$dateto:NULL,
			   'pvh_date' => (isset($pvh_date) AND $pvh_date != '')?$pvh_date:NULL,			   
			   'patient_dob' => (isset($patient_dob) AND $patient_dob != '')?$patient_dob:NULL,	
			   'date_rash_onset' => (isset($date_rash_onset) AND $date_rash_onset != '')?$date_rash_onset:NULL,
			   'notification_date' => (isset($notification_date) AND $notification_date != '')?$notification_date:NULL,
			   'date_investigation' => (isset($date_investigation) AND $date_investigation != '')?$date_investigation:NULL,
			   'date_collection' => (isset($date_collection) AND $date_collection != '')?$date_collection:NULL,
			   'last_dose_date' => (isset($last_dose_date) AND $last_dose_date != '')?$last_dose_date:NULL,
			   'date_sent_lab' => (isset($date_sent_lab) AND $date_sent_lab != '')?$date_sent_lab:NULL,
			   'followup_date' => (isset($followup_date) AND $followup_date != '')?$followup_date:NULL,
			   'death_date' => (isset($death_date) AND $death_date != '')?$death_date:NULL,
			   'submitted_date' => (isset($submitted_date) AND $submitted_date != '')?$submitted_date:NULL,
			   'editted_date' => (isset($editted_date) AND $editted_date != '')?$editted_date:NULL,
			   //----------- Lab Data -------------//
			   'quantity_adequate' => $quantity_adequate,
			   'cold_chain_ok' => $cold_chain_ok,
			   'leakage_broken' => $leakage_broken,
			   'test_possible' => $test_possible,
				'specimen_received_by' => $specimen_received_by,
				'received_by_designation' => $received_by_designation,
				'lab_id_number' => $lab_id_number,
				'type_of_test' => $type_of_test,
				'specimen_result' => $specimen_result,
				'other_specimen_result' => $other_specimen_result,
				'other_specimen_lab' => $other_specimen_lab, 
				'comments' => $comments,
				'report_sent_by' => $report_sent_by, 
				'sent_by_designation' => $sent_by_designation,
				'report_submit_status' => $report_submit_status,
			   //----------- Lab Dates ------------//
			   'specimen_received_date' => (isset($specimen_received_date) AND $specimen_received_date != '')?$specimen_received_date:NULL,	
				'lab_testdone_date' => (isset($lab_testdone_date) AND $lab_testdone_date != '')?$lab_testdone_date:NULL,	
				'lab_report_sent_date' => (isset($lab_report_sent_date) AND $lab_report_sent_date != '')?$lab_report_sent_date:NULL,	 		   		   
				'result_saved_date' => (isset($result_saved_date) AND $result_saved_date != '')?$result_saved_date:NULL 
			);

			if($this -> input -> post('edit') && $this -> input -> post('cross_case_id'))
			{	
				// $DataArray['edit'] = $edit = $this -> input -> post('edit');
				// unset()
				$cross_case_id = $this -> input -> post('cross_case_id'); 
				//print_r($DataArray);exit();
				$updated_id = $this -> Common_model -> update_record('case_investigation_db',$DataArray,array('cross_case_id' => $cross_case_id));
				//syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Case_investigation/case_investigation_list');
			}
			else{
				//print_r($DataArray);exit();
				$inserted_id = $this -> Common_model -> insert_record('case_investigation_db',$DataArray);
				//syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('Case_investigation/case_investigation_list');				
			}
		}		
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('Case_investigation/case_investigation_list');
		}
	}

	function getSingleRegionUrl($procode){
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
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
	function getDataToSave($url=NULL,$filepath=NULL,$Array=NULL)
	{		
		//$data = array('procode' => $procode,'distcode' => $distcode,'tcode' => $tcode,);
		$data = $Array;
		//print_r($data);exit();
		//post data mechanism
		//$fields_string = http_build_query($data);
		$fields_string = '';
		foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string, '&');
		//$filepath = 'API/Receiver/get_cc_assetType_counts';
		//print_r($fields_string);exit();
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
		//print_r($httpCode);exit();			
		curl_close($ch);
		//workout for data in response
		//$userData = json_decode($saveData, true);
		if(isset($saveData)){
			return $saveData;
		}else{
			return array();
		}
	}
	public function DistNames(){
		$distcode = $this-> input-> post('distcode'); 
		$Districtname = $this -> CrossProvince_DistrictName($distcode);
		echo $Districtname;
	}
	
	function CrossProvince_DistrictName($distcode)
   {      
		$_query = "SELECT district from districts where distcode = '$distcode'";
		$results = $this-> db-> query($_query);
		$rows = $results->row_array();        
		return $rows['district'];	    
   }
   public function DistOptions(){
		$distcode = $this-> input-> post('distcode'); 
		$Districtname = $this -> getCrossProvince_DistrictsOptions(false,$distcode);
		echo $Districtname;
	}
	
	function getCrossProvince_DistrictsOptions($isreturn=false,$distcode=NULL,$allDistricts=NULL)
    { 
    	$procode = substr($distcode, 0,1);        
      $output = '<option value="" >-- Select District --</option>';
		$query="SELECT district,distcode from districts where province = '$procode' order by district asc";
		$result = $this -> db ->query($query);
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
    public function TehsilNames(){
		$tcode = $this-> input-> post('tcode'); 
		$TehsilName = $this -> CrossProvince_TehsilName($tcode);
		echo $TehsilName;
	}	

   function CrossProvince_TehsilName($tcode)
   {        
		$_query = "SELECT tehsil from tehsil where tcode = '$tcode'";
		$results = $this-> db-> query($_query);
		$rows = $results->row_array();        
		return $rows['tehsil'];	    
   }

	public function TehsilOptions(){
		$tcode = $this-> input-> post('tcode'); 
		$TehsilName = $this -> getCrossProvince_TehsilOptions(false,$tcode);
		echo $TehsilName;
	}	

	function getCrossProvince_TehsilOptions($isreturn=false,$tcode=NULL,$distcode=NULL)
	{       
		$procode = substr($tcode,0,1);
		$distcode = substr($tcode,0,3);
		$output = '<option value="" >-- Select Tehsil --</option>';
		$query="SELECT tehsil,tcode from tehsil where distcode = '$distcode' order by tcode";
		$result = $this -> db ->query($query);
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
   public function UCNames(){
		$uncode = $this-> input-> post('uncode'); 
		$UCName = $this -> CrossProvince_UCName($uncode);
		echo $UCName;
	}
    
   function CrossProvince_UCName($uncode)
   {     
		$_query = "SELECT un_name from unioncouncil where uncode = '$uncode'";
		$results = $this-> db-> query($_query);
		$rows = $results->row_array();        
		return $rows['un_name'];	    
   }
   public function UCsOptions(){
		$uncode = $this-> input-> post('uncode'); 
		$UCName = $this -> getCrossProvince_UCsOptions(false,$uncode);
		echo $UCName;
	}
    
   function getCrossProvince_UCsOptions($isreturn=false,$uncode=NULL)
   {  
      $procode = substr($uncode,0,1);
		$distcode = substr($uncode,0,3);
		$tcode = substr($uncode,0,6);
		$output = '<option value="" >-- Select Unioncouncil --</option>';
		$query="SELECT un_name,uncode from unioncouncil where tcode = '$tcode' order by uncode";
		$result = $this -> db ->query($query);
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
    public function FacilityNames(){
		$facode = $this-> input-> post('facode');
		$FacilityName = $this -> CrossProvince_FacilityName($facode);
		echo $FacilityName;
	}
	function CrossProvince_FacilityName($facode)
   {           
		$_query = "SELECT fac_name from facilities where facode = '$facode'";
		$results = $this-> db-> query($_query);
		$rows = $results->row_array();        
		return $rows['fac_name'];	    
   }
	
}
?>