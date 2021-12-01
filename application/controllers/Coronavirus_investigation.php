<?php
class Coronavirus_investigation extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		$this -> load -> helper('cross_notify_functions_helper');
		//echo CrossProvince_DistrictName(511);exit();
		//authentication();
		$this -> load -> helper('apis_helper');
		$this -> load -> model ('Coronavirus_investigation_model');
		//$this -> load -> model('Cross_notify_functions_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	//////////////////////////////////// FIRST Function ///////////////////////////////////////////////
	
	//---------------------------------- Coronavirus Investigation ---------------------------------------//
	//----------------------------------------------------------------------------------------------------//
	
	public function coronavirus_investigation_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " corona_case_investigation_form_db "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" case_type='Covid' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
			//$wc=" procode = '".$_SESSION["Province"]."' and case_type='Covid' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		else
			$wc=" procode = '".$_SESSION["Province"]."' and case_type='Covid'";
			//$wc=" ";
		$data = $this -> Coronavirus_investigation_model -> coronavirus_investigation_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		//print_r($data['pagination']);exit();
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/coronavirus_investigation_list';
			$data['pageTitle']='Coronavirus Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}

	public function coronavirus_investigation(){
		$data['data']=$this -> Coronavirus_investigation_model -> coronavirus_investigation(); 
		$distcode = $this -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		$year = date('Y');
		$data['years'] = getEpiWeekYearsOptions('',true);
		//$data['years'] = getAllYearsOptionsIncludingCurrent(true);
		$data['fileToLoad'] = 'investigation_forms/coronavirus_investigation_form';
		$data['pageTitle']='Coronavirus Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}

	public function coronavirus_investigation_save(){
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
				//$procode = $this-> input-> post('procode');
				$tcode = $this-> input-> post('patient_address_tcode');
				//$distcode = $this-> input-> post('patient_address_distcode');				
				$procode = substr($tcode, 0,1);
				$distcode = substr($tcode, 0,3);
				// $patient_address_procode = substr($tcode, 0,1);
				// $uncode = $this-> input-> post('patient_address_uncode');
				//$patient_address_procode = $this-> input-> post('procode');
				$patient_address_procode = $procode;
				$patient_address_distcode = $distcode;
				$patient_address_tcode = $this-> input-> post('patient_address_tcode');
				$patient_address_uncode = $uncode = $this-> input-> post('patient_address_uncode');
				$patient_address = $this-> input-> post('patient_address');
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
			    $patient_address = $this-> input-> post('patient_address');
				
				$query = "SELECT max(case_number) AS case_number FROM corona_case_investigation_form_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				//echo $result['case_number']; exit();
				$sixdigit_number = sprintf('%06u', ($result['case_number'] + 1)); 
				//$sixdigit_number = $a1.$a2.$a3.$a4;
				//echo $sixdigit_number; exit();
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
			// $thtcode = $this-> input-> post('th_tcode');
			// $thdistcode = substr($thtcode,0,3);
			//$epid_year = $this-> input-> post('epid_year');
			//interview detail//
			$interviewer_date = ($this-> input-> post('interviewer_date'))?date('Y-m-d', strtotime($this-> input-> post('interviewer_date'))):NULL;	
			$poe = $this-> input-> post('poe');
			$interviewer_name = $this-> input-> post('interviewer_name');
			$interviewer_designation = $this-> input-> post('interviewer_designation');
			$interviewer_contact = $this-> input-> post('interviewer_contact');
			//$epid_year = $this-> input-> post('year');
			//patient information//
			$name = $this-> input-> post('name');
			$gender = $this-> input-> post('gender');
			$age_in_year = ($this-> input-> post('age_in_year'))?$this-> input-> post('age_in_year'):0;
			$occupation = $this-> input-> post('occupation');
			$nationality = $this-> input-> post('nationality');
			$fathername = $this-> input-> post('fathername');
			$cnic = $this-> input-> post('cnic');
			$mobile = $this-> input-> post('mobile');
			$telephone = $this-> input-> post('telephone');			
			// $patient_address_procode = $_SESSION["Province"];
			$have_travel_history = ($this-> input-> post('have_travel_history'))?$this-> input-> post('have_travel_history'):0;
			$have_travel_within_country = ($this-> input-> post('have_travel_within_country'))?$this-> input-> post('have_travel_within_country'):0;
			$have_travel_abroad = ($this-> input-> post('have_travel_abroad'))?$this-> input-> post('have_travel_abroad'):0;			
			$country_1 = ($this-> input-> post('country_1'))?$this-> input-> post('country_1'):0;
			$country_2 = ($this-> input-> post('country_2'))?$this-> input-> post('country_2'):0;
			$country_3 = ($this-> input-> post('country_3'))?$this-> input-> post('country_3'):0;
			$country_4 = ($this-> input-> post('country_4'))?$this-> input-> post('country_4'):0;
			$country_5 = ($this-> input-> post('country_5'))?$this-> input-> post('country_5'):0;
			$country_6 = ($this-> input-> post('country_6'))?$this-> input-> post('country_6'):0;
			$country_7 = ($this-> input-> post('country_7'))?$this-> input-> post('country_7'):0;
			$country_8 = ($this-> input-> post('country_8'))?$this-> input-> post('country_8'):0;
			$country_9 = ($this-> input-> post('country_9'))?$this-> input-> post('country_9'):0;
			$country_10 = ($this-> input-> post('country_10'))?$this-> input-> post('country_10'):0;
			$country_11 = ($this-> input-> post('country_11'))?$this-> input-> post('country_11'):0;
			$country_12 = ($this-> input-> post('country_12'))?$this-> input-> post('country_12'):0;
			$country = $this-> input-> post('country');
			$city_state = $this-> input-> post('city_state');
    		$visit_purpose = $this-> input-> post('visit_purpose');
    		$stay_duration = $this-> input-> post('stay_duration');
    		$address_during_stay = $this-> input-> post('address_during_stay');
    		$influenza_vaccine = ($this-> input-> post('influenza_vaccine'))?$this-> input-> post('influenza_vaccine'):0;
			$know_any_person_with_symptons = ($this-> input-> post('know_any_person_with_symptons'))?$this-> input-> post('know_any_person_with_symptons'):0;
			//signs and symptoms//
			$is_fever = ($this-> input-> post('is_fever'))?$this-> input-> post('is_fever'):0;
			$is_cough = ($this-> input-> post('is_cough'))?$this-> input-> post('is_cough'):0;
			$difficulty_breathing = ($this-> input-> post('difficulty_breathing'))?$this-> input-> post('difficulty_breathing'):0;
			$chronic_ailment = ($this-> input-> post('chronic_ailment'))?$this-> input-> post('chronic_ailment'):0;
			$any_other = $this-> input-> post('any_other');
			$chronic_ailment_desc = $this-> input-> post('chronic_ailment_desc');
			//clinical screening//
			$temprature = ($this-> input-> post('temprature'))?$this-> input-> post('temprature'):0;
			$bp_from = ($this-> input-> post('bp_from'))?$this-> input-> post('bp_from'):0;
			$bp_to = ($this-> input-> post('bp_to'))?$this-> input-> post('bp_to'):0;
			$pulse_rate = ($this-> input-> post('pulse_rate'))?$this-> input-> post('pulse_rate'):0;
			$chest_asculation = ($this-> input-> post('chest_asculation'))?$this-> input-> post('chest_asculation'):0;
			$retained_at_poe = ($this-> input-> post('retained_at_poe'))?$this-> input-> post('retained_at_poe'):0;
			$no_of_days_retained = ($this-> input-> post('no_of_days_retained'))?$this-> input-> post('no_of_days_retained'):0;
			$shifted_for_isolation = ($this-> input-> post('shifted_for_isolation'))?$this-> input-> post('shifted_for_isolation'):0;
			$days_admitted = ($this-> input-> post('days_admitted'))?$this-> input-> post('days_admitted'):0;
			$sample_collected = ($this-> input-> post('sample_collected'))?$this-> input-> post('sample_collected'):0;
			$sample_type = $this-> input-> post('sample_type');
			$test_result = $this-> input-> post('test_result');
			$outcome = $this-> input-> post('outcome');  
			
			$rb_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):'';
			if($rb_distcode > 0){
				$rb_procode = substr($rb_distcode,0,1);
			}else{
				$rb_procode = '';
			}			
			$rb_tcode = $this-> input-> post('rb_tcode');
			$rb_uncode = $this-> input-> post('rb_uncode');
			$rb_facode = $this-> input-> post('rb_facode');
			$rb_faddress = $this-> input-> post('rb_faddress');
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
			$date_of_onset = ($this-> input-> post('date_of_onset'))?date('Y-m-d', strtotime($this-> input-> post('date_of_onset'))):NULL;
			$date_of_investigation = ($this-> input-> post('date_of_investigation'))?date('Y-m-d', strtotime($this-> input-> post('date_of_investigation'))):NULL;
			$date_of_quarantine = ($this-> input-> post('date_of_quarantine'))?date('Y-m-d', strtotime($this-> input-> post('date_of_quarantine'))):NULL;
			$date_of_notification = ($this-> input-> post('date_of_notification'))?date('Y-m-d', strtotime($this-> input-> post('date_of_notification'))):NULL;
			$date_reported = ($this-> input-> post('date_reported'))?date('Y-m-d', strtotime($this-> input-> post('date_reported'))):NULL;
			$date_of_collection = ($this-> input-> post('date_of_collection'))?date('Y-m-d', strtotime($this-> input-> post('date_of_collection'))):NULL;
			$date_of_shipment_to_nih = ($this-> input-> post('date_of_shipment_to_nih'))?date('Y-m-d', strtotime($this-> input-> post('date_of_shipment_to_nih'))):NULL;
			$date_of_death = ($this-> input-> post('date_of_death'))?date('Y-m-d', strtotime($this-> input-> post('date_of_death'))):NULL;
			$submitted_date = ($this-> input-> post('submitted_date'))?date('Y-m-d', strtotime($this-> input-> post('submitted_date'))):NULL;

			//----------------------------------- Array -------------------------------------//
			///////////////////////////////////////////////////////////////////////////////////	
		   	$query = "SELECT max(cn_id_from) AS cn_id_from FROM corona_case_investigation_form_db";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			//echo $result['case_number']; exit();
			//$cn_id_from = sprintf('%04u', ($result['cn_id_from'] + 1));
			$cn_id_from = $result['cn_id_from'] + 1; 
			/////////////////////////////////////////
			if(!$this -> input-> post('edit') && $this -> input -> post('cross_notified') != 1 && $this -> input -> post('distcode')){
				//echo "KLM1";exit();
				$case_number = $sixdigit_number;
				$case_epi_no = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/Covid/".$case_number;
				$cross_notified_from_distcode = '';
				$approval_status = NULL;
			}			
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') == 1 && $this -> input-> post('id') && $this -> input-> post('case_epi_no') != ''){
				//echo "ABC";exit();
				$id = $this -> input -> post('id');
				$editApproved = "SELECT facode, distcode, procode, patient_address_procode, case_epi_no, case_number, cross_notified_from_distcode, approval_status, submitted_date from corona_case_investigation_form_db where id = '$id'";
				$result = $this -> db -> query($editApproved);
				$result = $result -> row_array();
				$facode = $result['facode'];
				$distcode = $result['distcode'];
				$procode = $result['procode'];				
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];		
				$approval_status = $result['approval_status'];
				$submitted_date = $result['submitted_date'];
				$patient_address_procode = $result['patient_address_procode'];
				$cross_notified_from_distcode = $result['cross_notified_from_distcode'];
			}
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') != 1 && $this -> input-> post('id') && $this -> input-> post('case_epi_no') != ''){
				//echo "xyz";exit();
				$id = $this -> input -> post('id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, submitted_date from corona_case_investigation_form_db where id = '$id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];
				$submitted_date = $result['submitted_date'];
				$cross_notified_from_distcode = '';
				$approval_status = NULL;	
			}
			else{
				//echo "KLM3";exit();
				if($this -> input -> post('edit') && $this -> input -> post('id') && $this -> input-> post('case_epi_no') == ''){
					//echo "abc1";exit();
					$id = $this -> input -> post('id');
					$editNotApproved = "SELECT submitted_date from corona_case_investigation_form_db where id = '$id'";
					$result = $this -> db -> query($editNotApproved);
					$result = $result -> row_array();
					$submitted_date = $result['submitted_date'];
					$tcode = $this-> input-> post('patient_address_tcode');
			   		$uncode = $this-> input-> post('patient_address_uncode');
			   		if($tcode != ''){
						$distcode = substr($tcode, 0,3);
			   		}
			   		else{
			   			$distcode = $this-> input-> post('patient_address_distcode');
			   		}
					$rb_facode = $this-> input-> post('rb_facode');
					$cross_notified_from_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):$this -> session -> District;
					$approval_status= "Pending";
					$case_epi_no= NULL;
					$case_number= 0;
				}
				if(!$this -> input -> post('edit') && !$this -> input -> post('id') && $this -> input-> post('cross_notified') == 1){
					//echo "abc2";exit();
					// $tcode = $this-> input-> post('tcode');
					// $uncode = $this-> input-> post('uncode');
					// $distcode = substr($tcode, 0,3);
					// $patient_address_tcode = $this-> input-> post('patient_address_tcode');
					// $patient_address_uncode = $this-> input-> post('patient_address_uncode');
					// $patient_address_distcode = substr($patient_address_tcode, 0,3);

					$rb_facode = $this-> input-> post('rb_facode');					 
					$cross_notified_from_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):$this -> session -> District;
					$approval_status = "Pending";
					$case_epi_no = NULL;
					$case_number = 0;
				}
			}
			if($this-> input-> post('have_travel_within_country') == 1){
				$from_procode = $this-> input-> post('from_procode');
				$from_tcode = $this-> input-> post('from_tcode');
				$from_distcode = substr($from_tcode,0,3);
				//echo $from_distcode; exit();
				$from_uncode = $this-> input-> post('from_uncode');
				$from_address = $this-> input-> post('from_address');
				$to_procode = $this-> input-> post('to_procode');
				$to_distcode = $this-> input-> post('to_distcode');
				$to_tcode = $this-> input-> post('to_tcode');
				$to_uncode = $this-> input-> post('to_uncode');
				$to_address = $this-> input-> post('to_address');
				$date_from = ($this-> input-> post('date_from'))?date('Y-m-d', strtotime($this-> input-> post('date_from'))):NULL;
				$date_to = ($this-> input-> post('date_to'))?date('Y-m-d', strtotime($this-> input-> post('date_to'))):NULL;
			}
			if($this-> input-> post('have_travel_abroad') == 1){
			    $country = $this-> input-> post('country');				   
			    $transit_site = $this-> input-> post('transit_site');
			    $departed_date = ($this-> input-> post('departed_date'))?date('Y-m-d', strtotime($this-> input-> post('departed_date'))):NULL;
			}
			// if($labresult_tobesentto_district != ''){
			// 	$labresult_tobesentto = '';
			// } 
			////////////////////////////////////////
		   	$DataArray=array(
		   		//interview detail//
			   	'interviewer_date' => (isset($interviewer_date) AND $interviewer_date != '')?$interviewer_date:NULL,
			   	'poe' => $poe,
			   	'interviewer_name' => $interviewer_name,
			   	'interviewer_designation' => $interviewer_designation,
			   	'interviewer_contact' => $interviewer_contact,
			   	//area codes//
		   		'procode' => $procode,
				'distcode' => $distcode,
				'tcode' => $tcode,		   
			    'uncode' => $uncode,
			    'facode' => $facode,
			    'faddress' => $faddress,
			    //travel history//
				'have_travel_history' => $have_travel_history,
				'have_travel_within_country' => $have_travel_within_country,
				'have_travel_abroad' => $have_travel_abroad,				
				'country_1' => $country_1,
				'country_2' => $country_2,
				'country_3' => $country_3,
				'country_4' => $country_4,
				'country_5' => $country_5,
				'country_6' => $country_6,
				'country_7' => $country_7,
				'country_8' => $country_8,
				'country_9' => $country_9,
				'country_10' => $country_10,
				'country_11' => $country_11,
				'country_12' => $country_12,
				'country' => $country,
				'city_state' => $city_state,
	    		'visit_purpose' => $visit_purpose,
	    		'stay_duration' => $stay_duration,
	    		'address_during_stay' => $address_during_stay,
	    		'influenza_vaccine' => $influenza_vaccine,
				'know_any_person_with_symptons' => $know_any_person_with_symptons,
				//signs and symptoms
				'is_fever' => $is_fever,
				'is_cough' => $is_cough,
				'difficulty_breathing' => $difficulty_breathing,
				'chronic_ailment' => $chronic_ailment,
				'any_other' => $any_other,
				'chronic_ailment_desc' => $chronic_ailment_desc,
				//clinical screening//
				'temprature' => $temprature,
				'bp_from' => $bp_from,
				'bp_to' => $bp_to,
				'pulse_rate' => $pulse_rate,
				'chest_asculation' => $chest_asculation,
				'retained_at_poe' => $retained_at_poe,
				'no_of_days_retained' => $no_of_days_retained,
				'shifted_for_isolation' => $shifted_for_isolation,
				'days_admitted' => $days_admitted,
				'sample_collected' => $sample_collected,
				'sample_type' => $sample_type,
				'test_result' => $test_result,
				'outcome' => $outcome,

				'cross_notified_from_distcode' => $cross_notified_from_distcode,
				'cross_notified' => $cross_notified,
				'approval_status' => $approval_status,
				'year' => $year,
				'week' => $week,
				'fweek' => $fweek,
				'dcode' => $dcode,
				'case_epi_no' => $case_epi_no,
				'case_number' => $case_number,
				'name' =>  $name,
				'gender' => $gender,
				'occupation' => $occupation,
				'nationality' => $nationality,
				'fathername' => $fathername,
				'cnic' => $cnic,
				'mobile' => $mobile,
				'telephone' => $telephone,
				'age_in_year' => $age_in_year,
				'patient_address_procode' => $patient_address_procode,
				'patient_address_distcode' => $patient_address_distcode,
				'patient_address_tcode' => $patient_address_tcode,
				'patient_address_uncode' => $patient_address_uncode,
				'patient_address' => $patient_address,
				'village_muhallah' => $patient_address,
				'case_type' => $case_type,
				'rb_procode' => ($rb_procode)?$rb_procode:'',		  
				'rb_distcode' => ($rb_distcode)?$rb_distcode:'',
				'rb_tcode' => $rb_tcode,
				'rb_uncode' => $rb_uncode,
				'rb_facode' => $rb_facode,
				'rb_faddress' => $rb_faddress,			
				'is_temp_saved' => $is_temp_saved,
				'cn_id_from' => $cn_id_from,
				'cross_case_id' => $cross_case_id,
				//----------- Dates -------------//
				'datefrom' => (isset($datefrom) AND $datefrom != '')?$datefrom:NULL,		   
				'dateto' => (isset($dateto) AND $dateto != '')?$dateto:NULL,
				'pvh_date' => (isset($pvh_date) AND $pvh_date != '')?$pvh_date:NULL,	
				'date_of_onset' => (isset($date_of_onset) AND $date_of_onset != '')?$date_of_onset:NULL,
				'date_of_investigation' => (isset($date_of_investigation) AND $date_of_investigation != '')?$date_of_investigation:NULL,
				'date_of_quarantine' => (isset($date_of_quarantine) AND $date_of_quarantine != '')?$date_of_quarantine:NULL,
				'date_of_notification' => (isset($date_of_notification) AND $date_of_notification != '')?$date_of_notification:NULL,
				'date_reported' => (isset($date_reported) AND $date_reported != '')?$date_reported:NULL,
				'date_of_collection' => (isset($date_of_collection) AND $date_of_collection != '')?$date_of_collection:NULL,
				'date_of_shipment_to_nih' => (isset($date_of_shipment_to_nih) AND $date_of_shipment_to_nih != '')?$date_of_shipment_to_nih:NULL,
				'date_of_death' => (isset($date_of_death) AND $date_of_death != '')?$date_of_death:NULL,
				'submitted_date' => (isset($submitted_date) AND $submitted_date != '')?$submitted_date:NULL,
				'editted_date' => (isset($editted_date) AND $editted_date != '')?$editted_date:NULL			
			);			
			
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{	
				$DataArray['id'] = $id = $this -> input -> post('id'); 
				//print_r($DataArray);exit();
				$updated_id = $this -> Common_model -> update_record('corona_case_investigation_form_db',$DataArray,array('id' => $id));

				if($this-> input-> post('have_travel_within_country') == 1){
					$travelWithinCountry=array(
						'case_id' => $id,
						'from_procode' => $from_procode,
						'from_distcode' => $from_distcode, 
						'from_tcode' => $from_tcode,
						'from_uncode' => $from_uncode,
						'from_address' => $from_address,
						'to_procode' => $to_procode,
						'to_distcode' => $to_distcode,
						'to_tcode' => $to_tcode,
						'to_uncode' => $to_uncode,
						'to_address' => $to_address,
						'date_from' => (isset($date_from) AND $date_from != '')?$date_from:NULL,
						'date_to' => (isset($date_to) AND $date_to != '')?$date_to:NULL,
						'cn_id_from' => $cn_id_from,
						'cross_case_id' => $cross_case_id
					);
						
					$id = $this -> input -> post('id'); 
					$checkRecord = "SELECT case_id from country_visits where case_id = '$id'";
					$result = $this -> db -> query($checkRecord);
					$result = $result -> row_array();
					$checkID = $result['case_id'];

					if($checkID > 0){
						$updated_id = $this -> Common_model -> update_record('country_visits',$travelWithinCountry,array('case_id' => $id));
					}
					else {
						$inserted_id = $this -> Common_model -> insert_record('country_visits',$travelWithinCountry);
					}
				}				
				
				if($this-> input-> post('have_travel_abroad') == 1){
					$travelAbroad=array(
						'case_id' => $id,
					    'country' => $country,				   
					    'transit_site' => $transit_site,
					    'departed_date' => (isset($departed_date) AND $departed_date != '')?$departed_date:NULL,
					    'cn_id_from' => $cn_id_from,
						'cross_case_id' => $cross_case_id
					);
					
					$id = $this -> input -> post('id'); 
					$checkRecord = "SELECT case_id from abroad_cases where case_id = '$id'";
					$result = $this -> db -> query($checkRecord);
					$result = $result -> row_array();
					$checkID = $result['case_id'];
					
					if($checkID > 0){
						$updated_id = $this -> Common_model -> update_record('abroad_cases',$travelAbroad,array('case_id' => $id));
					}
					else {
						$inserted_id = $this -> Common_model -> insert_record('abroad_cases',$travelAbroad);
					}
				}

				if(($procode != $_SESSION["Province"]) || ($approval_status == 'Approved')){
					$DataArray['edit'] = $edit = $this -> input -> post('edit');
					$DataArray1 = array_merge($DataArray,$travelWithinCountry,$travelAbroad);
					$filepath = 'Coronavirus_investigation/coronavirus_investigation_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $DataArray1);
				}
				//if($baseUrl == $liveUrl){
				//syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				//$doses_received = ($doses_received > 2)?99:$doses_received;
				if($cross_notified != 1){
				//syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Coronavirus_investigation/coronavirus_investigation_list');
			}
			else{
				if($this -> input -> post('cross_notified') == 1 && !$this -> input -> post('cross_case_id')){
					//echo "a";exit();
					$rcode = $this -> session -> District;
					$DataArray['cross_case_id'] = $cross_case_id = $rcode.'-'.$distcode.'-'.$cn_id_from;
				}
				else if($this -> input -> post('cross_notified') == 1 && $this -> input -> post('cross_case_id')){
					//echo "b";exit();
					$DataArray['cross_case_id'] =$this -> input -> post('cross_case_id');
				}
				else{
					//echo "c";exit();
					$DataArray['cross_case_id'] = NULL;
				}				
				$inserted_id = $this -> Common_model -> insert_record('corona_case_investigation_form_db',$DataArray);
				$query = "SELECT max(id) AS id FROM corona_case_investigation_form_db";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				$DataArray['cn_id_to'] = $cn_id_to = $result['id'];
				if($this-> input-> post('have_travel_within_country') == 1){
					$travelWithinCountry=array(
						'case_id' => $result['id'],
						'from_procode' => $from_procode,
						'from_distcode' => (isset($from_distcode) AND strlen($from_distcode) == 3)?$from_distcode:NULL,
						'from_tcode' => $from_tcode,
						'from_uncode' => $from_uncode,
						'from_address' => $from_address,
						'to_procode' => $to_procode,
						'to_distcode' => $to_distcode,
						'to_tcode' => $to_tcode,
						'to_uncode' => $to_uncode,
						'to_address' => $to_address,
						'date_from' => (isset($date_from) AND $date_from != '')?$date_from:NULL,
						'date_to' => (isset($date_to) AND $date_to != '')?$date_to:NULL,
						'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);

					$inserted_id = $this -> Common_model -> insert_record('country_visits',$travelWithinCountry);					
				}				
				
				if($this-> input-> post('have_travel_abroad') == 1){
					$travelAbroad=array(
						'case_id' => $result['id'],
					    'country' => $country,				   
					    'transit_site' => $transit_site,
					    'departed_date' => (isset($departed_date) AND $departed_date != '')?$departed_date:NULL,
					    'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);

					$inserted_id = $this -> Common_model -> insert_record('abroad_cases',$travelAbroad);
				}
										
				if($procode != $_SESSION["Province"]){
					//echo "abcxyz"; exit();
					$DataArray1 = array_merge($DataArray,$travelWithinCountry,$travelAbroad);
					//print_r($DataArray1); exit();
					$filepath = 'Coronavirus_investigation/coronavirus_investigation_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);//echo "a"; exit();
					$dataMeasles = $this -> getDataToSave($url, $filepath, $DataArray1);//echo "b"; exit();
				}
				//if($baseUrl == $liveUrl){		
				// syncEpidCountDataWithFederalEPIMIS($year,$case_type,$distcode);
				// $doses_received = ($doses_received > 2)?99:$doses_received;
				// if($cross_notified != 1){
				// //echo'exit';exit;
				// syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				// //}
				// }
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('Coronavirus_investigation/coronavirus_investigation_list');				
			}
		}		
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('Coronavirus_investigation/coronavirus_investigation_list');
		}
	}
	
	public function coronavirusInvestigation_Approve(){
		//dataEntryValidator(0);
		//print_r($_POST);exit();
		/////parameter for sync by usama /////
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('week');
		$case_type = $this -> input -> post('case_type');
		$sdistcode = $this -> input -> post('distcode');
		$patient_gender = $this -> input -> post('gender');
		$doses_received = $this -> input -> post('doses_received');
		//////////end
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
			$updated_id = $this -> Common_model -> update_record('corona_case_investigation_form_db',$data,array('id' => $this-> input-> post('id')));
			//syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$sdistcode,$doses_received,$patient_gender);
			if($procode != $_SESSION["Province"]){
				$filepath = 'Coronavirus_investigation/coronavirusApprove_and_save'; 
				$url = $this -> getSingleRegionUrl($procode); 
				$dataMeasles = $this -> getDataToSave($url, $filepath,$data); 
			}
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Coronavirus_investigation/coronavirus_investigation_list');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}

	public function coronavirusApprove_and_save(){
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
			$updated_id = $this -> Common_model -> update_record('corona_case_investigation_form_db',$data,array('cross_case_id' => $this->input->post('cross_case_id')));			
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Coronavirus_investigation/coronavirus_investigation_list');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}	
	
	public function coronavirus_investigation_edit(){
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
		$data['coronavirus_Result'] = $this -> Common_model -> get_info('corona_case_investigation_form_db', '', '','*', array('id' => $id));
		$data['country_Visits'] = $this -> Common_model -> get_info('country_visits', '', '','*', array('case_id' => $id));
		$data['abroad_Cases'] = $this -> Common_model -> get_info('abroad_cases', '', '','*', array('case_id' => $id));		
		if($data['coronavirus_Result']->case_reported == 0){
			$case_type = $data['coronavirus_Result']->case_type;
			$query = "SELECT max(case_number) as case_number from corona_case_investigation_form_db where year='$year' AND dcode='$dcode'";
			$result = $this -> db -> query($query);        
			$result = $result -> row_array();
			$data['measleNumber'] = str_split(sprintf('%06u', ($result['case_number'] + 1)));
		}
		else{
			$data['measleNumber'] = str_split(sprintf('%06u', ($data['coronavirus_Result']->case_number)));	
		}
		//$data['coronavirus_Result'] = $this -> Common_model -> get_info('corona_case_investigation_form_db', '', '','*', array('id' => $id, 'facode' => $facode));
		$data['unioncouncil']=get_UC_Name($data['coronavirus_Result']->uncode);
		$data['facility']=get_Facility_Name($data['coronavirus_Result']->facode);
		$data['tehsil']=get_Tehsil_Name($data['coronavirus_Result']->tcode);
		$data['rbfacility']=get_Facility_Name($data['coronavirus_Result']->rb_facode);	
		//$data['rbuncode']=get_UC_Name($data['coronavirus_Result']->rb_uncode);
		$data['edit']="Yes";
		if($data != 0){			
			$data1['data']=$data;
			//print_r($data1['data']);exit();
			$data1['fileToLoad'] = 'investigation_forms/coronavirus_investigation_form_edit';
			$data1['pageTitle']='Coronavirus Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data1);
			//template_loader('investigation_forms/measles_case_investigation_form', $data, array($this->_module));
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}		
	
	public function coronavirus_investigation_view(){
		//echo "The view page is under development. It will be available to you soon. Thank you."; exit();
		$id = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$pcode = "SELECT procode from corona_case_investigation_form_db where id = $id";
		$result = $this -> db -> query($pcode);
		$result = $result -> row_array();
		$procode = $result["procode"];		
		$data['a'] = $this -> Common_model -> get_info('corona_case_investigation_form_db', '', '','*', array('id' => $id));
		$data['b'] = $this -> Common_model -> get_info('country_visits', '', '','*', array('case_id' => $id));
		$data['c'] = $this -> Common_model -> get_info('abroad_cases', '', '','*', array('case_id' => $id));
	
		$data['edit']="Yes";
		if($data != 0){
			$data1['data']=$data;
			//print_r($data1['data']);exit();
			$data1['fileToLoad'] = 'investigation_forms/coronavirus_investigation_form_view';
			$data1['pageTitle']='Coronavirus Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data1);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	
	public function coronavirus_investigation_receive_and_save(){
		//print_r($_POST);exit();		
		//dataEntryValidator(0);		
		if($this -> input -> post('cross_notified') && $this -> input -> post('year'))
		{
			$year = $this -> input -> post('year');
			$case_type = $this-> input-> post('case_type');
			if($this-> input-> post('rb_distcode'))
			{	//echo "ABC";exit();
				$procode = $this-> input-> post('procode');
				$distcode = $this-> input-> post('patient_address_distcode');
				if($this-> input-> post('procode')){
					$procode = $this-> input-> post('procode');
				}else{
					$procode = substr($distcode, 0,1);
				}				
				$patient_address_procode = substr($distcode, 0,1);							
				$tcode = $this-> input-> post('patient_address_tcode');
				$uncode = $this-> input-> post('patient_address_uncode');
				$patient_address_distcode = $this-> input-> post('patient_address_distcode');
				$patient_address_tcode = $this-> input-> post('patient_address_tcode');
				$patient_address_uncode = $this-> input-> post('patient_address_uncode');
				$patient_address = $this-> input-> post('patient_address');
			}
			if($this -> input -> post('distcode'))
			{	//echo "XYZ";exit();
				$procode = $this-> input-> post('procode');
				$distcode = $this -> input -> post('distcode');				
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$patient_address_procode = $this-> input-> post('patient_address_procode');
			    $patient_address_distcode = $this-> input-> post('patient_address_distcode');
			  	$patient_address_tcode = $this-> input-> post('patient_address_tcode');
			    $patient_address_uncode = $this-> input-> post('patient_address_uncode');
			    $patient_address = $this-> input-> post('patient_address');
				
				$query = "SELECT max(case_number) AS case_number FROM corona_case_investigation_form_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				//echo $result['case_number']; exit();
				$sixdigit_number = sprintf('%06u', ($result['case_number'] + 1)); 
				//$sixdigit_number = $a1.$a2.$a3.$a4;
				//echo $sixdigit_number; exit();
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
			// $thtcode = $this-> input-> post('th_tcode');
			// $thdistcode = substr($thtcode,0,3);
			//$epid_year = $this-> input-> post('epid_year');
			//interview detail//
			$interviewer_date = ($this-> input-> post('interviewer_date'))?date('Y-m-d', strtotime($this-> input-> post('interviewer_date'))):NULL;	
			$poe = $this-> input-> post('poe');
			$interviewer_name = $this-> input-> post('interviewer_name');
			$interviewer_designation = $this-> input-> post('interviewer_designation');
			$interviewer_contact = $this-> input-> post('interviewer_contact');
			//$epid_year = $this-> input-> post('year');
			//patient information//
			$name = $this-> input-> post('name');
			$gender = $this-> input-> post('gender');
			$age_in_year = ($this-> input-> post('age_in_year'))?$this-> input-> post('age_in_year'):0;
			$occupation = $this-> input-> post('occupation');
			$nationality = $this-> input-> post('nationality');
			$fathername = $this-> input-> post('fathername');
			$cnic = $this-> input-> post('cnic');
			$mobile = $this-> input-> post('mobile');
			$telephone = $this-> input-> post('telephone');			
			// $patient_address_procode = $_SESSION["Province"];
			$have_travel_history = ($this-> input-> post('have_travel_history'))?$this-> input-> post('have_travel_history'):0;
			$have_travel_within_country = ($this-> input-> post('have_travel_within_country'))?$this-> input-> post('have_travel_within_country'):0;
			$have_travel_abroad = ($this-> input-> post('have_travel_abroad'))?$this-> input-> post('have_travel_abroad'):0;			
			$country_1 = ($this-> input-> post('country_1'))?$this-> input-> post('country_1'):0;
			$country_2 = ($this-> input-> post('country_2'))?$this-> input-> post('country_2'):0;
			$country_3 = ($this-> input-> post('country_3'))?$this-> input-> post('country_3'):0;
			$country_4 = ($this-> input-> post('country_4'))?$this-> input-> post('country_4'):0;
			$country_5 = ($this-> input-> post('country_5'))?$this-> input-> post('country_5'):0;
			$country_6 = ($this-> input-> post('country_6'))?$this-> input-> post('country_6'):0;
			$country_7 = ($this-> input-> post('country_7'))?$this-> input-> post('country_7'):0;
			$country_8 = ($this-> input-> post('country_8'))?$this-> input-> post('country_8'):0;
			$country_9 = ($this-> input-> post('country_9'))?$this-> input-> post('country_9'):0;
			$country_10 = ($this-> input-> post('country_10'))?$this-> input-> post('country_10'):0;
			$country_11 = ($this-> input-> post('country_11'))?$this-> input-> post('country_11'):0;
			$country_12 = ($this-> input-> post('country_12'))?$this-> input-> post('country_12'):0;
			$country = $this-> input-> post('country');
			$city_state = $this-> input-> post('city_state');
    		$visit_purpose = $this-> input-> post('visit_purpose');
    		$stay_duration = $this-> input-> post('stay_duration');
    		$address_during_stay = $this-> input-> post('address_during_stay');
    		$influenza_vaccine = ($this-> input-> post('influenza_vaccine'))?$this-> input-> post('influenza_vaccine'):0;
			$know_any_person_with_symptons = ($this-> input-> post('know_any_person_with_symptons'))?$this-> input-> post('know_any_person_with_symptons'):0;
			//signs and symptoms//
			$is_fever = ($this-> input-> post('is_fever'))?$this-> input-> post('is_fever'):0;
			$is_cough = ($this-> input-> post('is_cough'))?$this-> input-> post('is_cough'):0;
			$difficulty_breathing = ($this-> input-> post('difficulty_breathing'))?$this-> input-> post('difficulty_breathing'):0;
			$chronic_ailment = ($this-> input-> post('chronic_ailment'))?$this-> input-> post('chronic_ailment'):0;
			$any_other = $this-> input-> post('any_other');
			$chronic_ailment_desc = $this-> input-> post('chronic_ailment_desc');
			//clinical screening//
			$temprature = ($this-> input-> post('temprature'))?$this-> input-> post('temprature'):0;
			$bp_from = ($this-> input-> post('bp_from'))?$this-> input-> post('bp_from'):0;
			$bp_to = ($this-> input-> post('bp_to'))?$this-> input-> post('bp_to'):0;
			$pulse_rate = ($this-> input-> post('pulse_rate'))?$this-> input-> post('pulse_rate'):0;
			$chest_asculation = ($this-> input-> post('chest_asculation'))?$this-> input-> post('chest_asculation'):0;
			$retained_at_poe = ($this-> input-> post('retained_at_poe'))?$this-> input-> post('retained_at_poe'):0;
			$no_of_days_retained = ($this-> input-> post('no_of_days_retained'))?$this-> input-> post('no_of_days_retained'):0;
			$shifted_for_isolation = ($this-> input-> post('shifted_for_isolation'))?$this-> input-> post('shifted_for_isolation'):0;
			$days_admitted = ($this-> input-> post('days_admitted'))?$this-> input-> post('days_admitted'):0;
			$sample_collected = ($this-> input-> post('sample_collected'))?$this-> input-> post('sample_collected'):0;
			$sample_type = $this-> input-> post('sample_type');
			$test_result = $this-> input-> post('test_result');
			$outcome = $this-> input-> post('outcome');  
			
			$rb_distcode = ($this-> input-> post('rb_distcode'))?$this-> input-> post('rb_distcode'):'';
			$rb_tcode = $this-> input-> post('rb_tcode');
			$rb_uncode = $this-> input-> post('rb_uncode');
			$rb_facode = $this-> input-> post('rb_facode');
			$rb_faddress = $this-> input-> post('rb_faddress');
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
			$date_of_onset = ($this-> input-> post('date_of_onset'))?date('Y-m-d', strtotime($this-> input-> post('date_of_onset'))):NULL;
			$date_of_investigation = ($this-> input-> post('date_of_investigation'))?date('Y-m-d', strtotime($this-> input-> post('date_of_investigation'))):NULL;
			$date_of_quarantine = ($this-> input-> post('date_of_quarantine'))?date('Y-m-d', strtotime($this-> input-> post('date_of_quarantine'))):NULL;
			$date_of_notification = ($this-> input-> post('date_of_notification'))?date('Y-m-d', strtotime($this-> input-> post('date_of_notification'))):NULL;
			$date_reported = ($this-> input-> post('date_reported'))?date('Y-m-d', strtotime($this-> input-> post('date_reported'))):NULL;
			$date_of_collection = ($this-> input-> post('date_of_collection'))?date('Y-m-d', strtotime($this-> input-> post('date_of_collection'))):NULL;
			$date_of_shipment_to_nih = ($this-> input-> post('date_of_shipment_to_nih'))?date('Y-m-d', strtotime($this-> input-> post('date_of_shipment_to_nih'))):NULL;
			$date_of_death = ($this-> input-> post('date_of_death'))?date('Y-m-d', strtotime($this-> input-> post('date_of_death'))):NULL;
			$submitted_date = ($this-> input-> post('submitted_date'))?date('Y-m-d', strtotime($this-> input-> post('submitted_date'))):NULL;

			//----------------------------------- Array -------------------------------------//
			///////////////////////////////////////////////////////////////////////////////////	
		 //   	$query = "SELECT max(cn_id_from) AS cn_id_from FROM corona_case_investigation_form_db";
			// $result = $this -> db -> query($query);
			// $result = $result -> row_array();
			// //echo $result['case_number']; exit();
			// //$cn_id_from = sprintf('%04u', ($result['cn_id_from'] + 1));
			// $cn_id_from = $result['cn_id_from'] + 1; 
			/////////////////////////////////////////
			if(!$this -> input-> post('edit') && $this -> input -> post('cross_notified') != 1 && $this -> input -> post('distcode')){
				//echo "KLM1";exit();
				$case_number = $sixdigit_number;
				$case_epi_no = "PAK/".$_SESSION["shortname"]."/".$dcode."/".$year."/Covid/".$case_number;
				$cross_notified_from_distcode = '';
				$approval_status = NULL;
			}			
			else if($this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1 && ($this -> input-> post('case_epi_no') != '' || $this -> input-> post('case_epi_no') != NULL)){
				//echo "ABC";exit();
				$cross_case_id = $this -> input -> post('cross_case_id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, submitted_date from corona_case_investigation_form_db where cross_case_id = '$cross_case_id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];	
				$result = $this -> db -> query($editNotApproved);
				$result = $result -> row_array();
				$submitted_date = $result['submitted_date'];
				$tcode = $this-> input-> post('patient_address_tcode');
				$uncode = $this-> input-> post('patient_address_uncode');
				$distcode = substr($tcode, 0,3);
				$rb_facode = $this-> input-> post('rb_facode');
				// $th_province = $this-> input-> post('th_province');
				// $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';
				// $th_tehsil = $this-> input-> post('th_tehsil');
				// $th_uc = $this-> input-> post('th_uc');				   
				$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
				$approval_status= "Approved";
			}
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') != 1 && $this -> input-> post('cross_case_id') && $this -> input-> post('case_epi_no') != ''){
				$cross_case_id = $this -> input -> post('cross_case_id');
				$editNotCrossNotified = "SELECT case_epi_no, case_number, submitted_date from corona_case_investigation_form_db where cross_case_id = '$cross_case_id'";
				$result = $this -> db -> query($editNotCrossNotified);
				$result = $result -> row_array();
				$case_epi_no = $result['case_epi_no'];
				$case_number = $result['case_number'];
				$submitted_date = $result['submitted_date'];
				$cross_notified_from_distcode = '';
				$approval_status = NULL;	
			}
			else{
				//echo "KLM3";exit();
				if($this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1 && $this -> input-> post('case_epi_no') == ''){
					//echo "abc";exit();
					$cross_case_id = $this -> input -> post('cross_case_id');
					$editNotApproved = "SELECT submitted_date from case_investigation_db where cross_case_id = '$cross_case_id'";
					$result = $this -> db -> query($editNotApproved);
					$result = $result -> row_array();
					$submitted_date = $result['submitted_date'];
					$tcode = $this-> input-> post('patient_address_tcode');
					$uncode = $this-> input-> post('patient_address_uncode');
					$distcode = substr($tcode, 0,3);
					$rb_facode = $this-> input-> post('rb_facode');
					// $th_province = $this-> input-> post('th_province');
					// $th_district = ($this-> input-> post('th_district'))?$this-> input-> post('th_district'):'';							   
					$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
					$approval_status= "Pending";
					$case_epi_no= NULL;
					$case_number= 0;
				}				
				if(!$this -> input -> post('edit') && $this -> input-> post('cross_notified') == 1){
					//echo "abc";exit();
					$tcode = $this-> input-> post('patient_address_tcode');
					$uncode = $this-> input-> post('patient_address_uncode');
					$distcode = substr($tcode, 0,3);
					$patient_address_tcode = $this-> input-> post('patient_address_tcode');
					$patient_address_uncode = $this-> input-> post('patient_address_uncode');
					$patient_address_distcode = substr($patient_address_tcode, 0,3);
					$rb_facode = $this-> input-> post('rb_facode');					
					$cross_notified_from_distcode = $this-> input-> post('rb_distcode');
					$approval_status = "Pending";
					$case_epi_no = NULL;
					$case_number = 0;
				}
			}
			if($this-> input-> post('have_travel_within_country') == 1){
				$from_procode = $this-> input-> post('from_procode');
				$from_tcode = $this-> input-> post('from_tcode');
				$from_distcode = substr($from_tcode,0,3);
				$from_uncode = $this-> input-> post('from_uncode');
				$from_address = $this-> input-> post('from_address');
				$to_procode = $this-> input-> post('to_procode');
				$to_distcode = $this-> input-> post('to_distcode');
				$to_tcode = $this-> input-> post('to_tcode');
				$to_uncode = $this-> input-> post('to_uncode');
				$to_address = $this-> input-> post('to_address');
				$date_from = ($this-> input-> post('date_from'))?date('Y-m-d', strtotime($this-> input-> post('date_from'))):NULL;
				$date_to = ($this-> input-> post('date_to'))?date('Y-m-d', strtotime($this-> input-> post('date_to'))):NULL;
			}
			if($this-> input-> post('have_travel_abroad') == 1){
			    $country = $this-> input-> post('country');				   
			    $transit_site = $this-> input-> post('transit_site');
			    $departed_date = ($this-> input-> post('departed_date'))?date('Y-m-d', strtotime($this-> input-> post('departed_date'))):NULL;
			}
			$cross_case_id = $this-> input-> post('cross_case_id');
			// if($labresult_tobesentto_district != ''){
			// 	$labresult_tobesentto = '';
			// } 
			////////////////////////////////////////
		   	$DataArray=array(
		   		//interview detail//
			   	'interviewer_date' => (isset($interviewer_date) AND $interviewer_date != '')?$interviewer_date:NULL,
			   	'poe' => $poe,
			   	'interviewer_name' => $interviewer_name,
			   	'interviewer_designation' => $interviewer_designation,
			   	'interviewer_contact' => $interviewer_contact,
			   	//area codes//
		   		'procode' => $procode,
				'distcode' => $distcode,
				'tcode' => $tcode,		   
			    'uncode' => $uncode,
			    'facode' => $facode,
			    'faddress' => $faddress,
			    //travel history//
				'have_travel_history' => $have_travel_history,
				'have_travel_within_country' => $have_travel_within_country,
				'have_travel_abroad' => $have_travel_abroad,				
				'country_1' => $country_1,
				'country_2' => $country_2,
				'country_3' => $country_3,
				'country_4' => $country_4,
				'country_5' => $country_5,
				'country_6' => $country_6,
				'country_7' => $country_7,
				'country_8' => $country_8,
				'country_9' => $country_9,
				'country_10' => $country_10,
				'country_11' => $country_11,
				'country_12' => $country_12,
				'country' => $country,
				'city_state' => $city_state,
	    		'visit_purpose' => $visit_purpose,
	    		'stay_duration' => $stay_duration,
	    		'address_during_stay' => $address_during_stay,
	    		'influenza_vaccine' => $influenza_vaccine,
				'know_any_person_with_symptons' => $know_any_person_with_symptons,
				//signs and symptoms
				'is_fever' => $is_fever,
				'is_cough' => $is_cough,
				'difficulty_breathing' => $difficulty_breathing,
				'chronic_ailment' => $chronic_ailment,
				'any_other' => $any_other,
				'chronic_ailment_desc' => $chronic_ailment_desc,
				//clinical screening//
				'temprature' => $temprature,
				'bp_from' => $bp_from,
				'bp_to' => $bp_to,
				'pulse_rate' => $pulse_rate,
				'chest_asculation' => $chest_asculation,
				'retained_at_poe' => $retained_at_poe,
				'no_of_days_retained' => $no_of_days_retained,
				'shifted_for_isolation' => $shifted_for_isolation,
				'days_admitted' => $days_admitted,
				'sample_collected' => $sample_collected,
				'sample_type' => $sample_type,
				'test_result' => $test_result,
				'outcome' => $outcome,

				'cross_notified_from_distcode' => $cross_notified_from_distcode,
				'cross_notified' => $cross_notified,
				'approval_status' => $approval_status,
				'year' => $year,
				'week' => $week,
				'fweek' => $fweek,
				'dcode' => $dcode,
				'case_epi_no' => $case_epi_no,
				'case_number' => $case_number,
				'name' =>  $name,
				'gender' => $gender,
				'occupation' => $occupation,
				'nationality' => $nationality,
				'fathername' => $fathername,
				'cnic' => $cnic,
				'mobile' => $mobile,
				'telephone' => $telephone,
				'age_in_year' => $age_in_year,
				'patient_address_procode' => $patient_address_procode,
				'patient_address_distcode' => $patient_address_distcode,
				'patient_address_tcode' => $patient_address_tcode,
				'patient_address_uncode' => $patient_address_uncode,
				'patient_address' => $patient_address,
				'village_muhallah' => $patient_address,
				'case_type' => $case_type,		  
				'rb_distcode' => ($rb_distcode)?$rb_distcode:'',
				'rb_tcode' => $rb_tcode,
				'rb_uncode' => $rb_uncode,
				'rb_facode' => $rb_facode,
				'rb_faddress' => $rb_faddress,			
				'is_temp_saved' => $is_temp_saved,
				'cn_id_from' => $cn_id_from,
				'cn_id_to' => $cn_id_to,
				'cross_case_id' => $cross_case_id,
				//----------- Dates -------------//
				'datefrom' => (isset($datefrom) AND $datefrom != '')?$datefrom:NULL,		   
				'dateto' => (isset($dateto) AND $dateto != '')?$dateto:NULL,
				'pvh_date' => (isset($pvh_date) AND $pvh_date != '')?$pvh_date:NULL,	
				'date_of_onset' => (isset($date_of_onset) AND $date_of_onset != '')?$date_of_onset:NULL,
				'date_of_investigation' => (isset($date_of_investigation) AND $date_of_investigation != '')?$date_of_investigation:NULL,
				'date_of_quarantine' => (isset($date_of_quarantine) AND $date_of_quarantine != '')?$date_of_quarantine:NULL,
				'date_of_notification' => (isset($date_of_notification) AND $date_of_notification != '')?$date_of_notification:NULL,
				'date_reported' => (isset($date_reported) AND $date_reported != '')?$date_reported:NULL,
				'date_of_collection' => (isset($date_of_collection) AND $date_of_collection != '')?$date_of_collection:NULL,
				'date_of_shipment_to_nih' => (isset($date_of_shipment_to_nih) AND $date_of_shipment_to_nih != '')?$date_of_shipment_to_nih:NULL,
				'date_of_death' => (isset($date_of_death) AND $date_of_death != '')?$date_of_death:NULL,
				'submitted_date' => (isset($submitted_date) AND $submitted_date != '')?$submitted_date:NULL,
				'editted_date' => (isset($editted_date) AND $editted_date != '')?$editted_date:NULL			
			);			
			
			if($this -> input -> post('edit') && $this -> input -> post('cross_case_id'))
			{
				$id = $this -> input -> post('id');
				$cross_case_id = $this -> input -> post('cross_case_id'); 
				//print_r($DataArray);exit();
				$updated_id = $this -> Common_model -> update_record('corona_case_investigation_form_db',$DataArray,array('cross_case_id' => $cross_case_id));
				$query = "SELECT id FROM corona_case_investigation_form_db where cross_case_id='$cross_case_id'";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				$DataArray['cn_id_to'] = $cn_id_to = $result['id'];
				if($this-> input-> post('have_travel_within_country') == 1){
					$travelWithinCountry=array(
						'case_id' => $result['id'],
						'from_procode' => $from_procode,
						'from_distcode' => $from_distcode, 
						'from_tcode' => $from_tcode,
						'from_uncode' => $from_uncode,
						'from_address' => $from_address,
						'to_procode' => $to_procode,
						'to_distcode' => $to_distcode,
						'to_tcode' => $to_tcode,
						'to_uncode' => $to_uncode,
						'to_address' => $to_address,
						'date_from' => (isset($date_from) AND $date_from != '')?$date_from:NULL,
						'date_to' => (isset($date_to) AND $date_to != '')?$date_to:NULL,
						'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);
						
					$cross_case_id = $this -> input -> post('cross_case_id'); 
					$checkRecord = "SELECT case_id from country_visits where cross_case_id = '$cross_case_id'";
					$result = $this -> db -> query($checkRecord);
					$result = $result -> row_array();
					$checkID = $result['case_id'];

					if($checkID > 0){
						$updated_id = $this -> Common_model -> update_record('country_visits',$travelWithinCountry,array('cross_case_id' => $cross_case_id));
					}
					else {
						$inserted_id = $this -> Common_model -> insert_record('country_visits',$travelWithinCountry);
					}
				}				
				
				if($this-> input-> post('have_travel_abroad') == 1){
					$travelAbroad=array(
						'case_id' => $result['case_id'],
					    'country' => $country,				   
					    'transit_site' => $transit_site,
					    'departed_date' => (isset($departed_date) AND $departed_date != '')?$departed_date:NULL,
					    'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);
					
					$cross_case_id = $this -> input -> post('cross_case_id'); 
					$checkRecord = "SELECT case_id from abroad_cases where cross_case_id = '$cross_case_id'";
					$result = $this -> db -> query($checkRecord);
					$result = $result -> row_array();
					$checkID = $result['case_id'];
					
					if($checkID > 0){
						$updated_id = $this -> Common_model -> update_record('abroad_cases',$travelAbroad,array('cross_case_id' => $cross_case_id));
					}
					else {
						$inserted_id = $this -> Common_model -> insert_record('abroad_cases',$travelAbroad);
					}
				}
				
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Coronavirus_investigation/coronavirus_investigation_list');
			}
			else{
				$inserted_id = $this -> Common_model -> insert_record('corona_case_investigation_form_db',$DataArray);
				$query = "SELECT max(id) AS id FROM corona_case_investigation_form_db";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				$DataArray['cn_id_to'] = $cn_id_to = $result['id'];
				if($this-> input-> post('have_travel_within_country') == 1){
					$travelWithinCountry=array(
						'case_id' => $result['id'],
						'from_procode' => $from_procode,
						'from_distcode' => $from_distcode, 
						'from_tcode' => $from_tcode,
						'from_uncode' => $from_uncode,
						'from_address' => $from_address,
						'to_procode' => $to_procode,
						'to_distcode' => $to_distcode,
						'to_tcode' => $to_tcode,
						'to_uncode' => $to_uncode,
						'to_address' => $to_address,
						'date_from' => (isset($date_from) AND $date_from != '')?$date_from:NULL,
						'date_to' => (isset($date_to) AND $date_to != '')?$date_to:NULL,
						'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);

					$inserted_id = $this -> Common_model -> insert_record('country_visits',$travelWithinCountry);					
				}				
				
				if($this-> input-> post('have_travel_abroad') == 1){
					$travelAbroad=array(
						'case_id' => $result['id'],
					    'country' => $country,				   
					    'transit_site' => $transit_site,
					    'departed_date' => (isset($departed_date) AND $departed_date != '')?$departed_date:NULL,
					    'cn_id_from' => $cn_id_from,
						'cn_id_to' => $cn_id_to,
						'cross_case_id' => $cross_case_id
					);

					$inserted_id = $this -> Common_model -> insert_record('abroad_cases',$travelAbroad);
				}
				
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('Coronavirus_investigation/coronavirus_investigation_list');				
			}
		}		
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('Coronavirus_investigation/coronavirus_investigation_list');
		}
	}

	function getSingleRegionUrl($procode)
	{
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

	public function DistNames()
	{
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

   	public function DistOptions()
   	{
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

    public function TehsilNames()
    {
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

	public function TehsilOptions()
	{
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
   	public function UCNames()
   	{
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
   	public function UCsOptions()
   	{
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

    public function FacilityNames()
    {
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