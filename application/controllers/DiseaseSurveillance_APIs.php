<?php
class DiseaseSurveillance_APIs extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('ds_apis_helper');
		$this -> output -> set_content_type('application/json');
	}
	
	public function register_new_case()
	{
		$procode = $this -> input -> post('procode') ?? NULL;
		$distcode = $this -> input -> post('distcode') ?? NULL;
		$year = $this -> input -> post('year') ?? NULL;
		$week = $this -> input -> post('week') ?? NULL;
		$fweek = $year . '-' . sprintf('%02d',$week);
		
		if($procode && $distcode && $year && $week){}else{
			$response = json_encode(array("success" => FALSE, "message" => "Please send all required parameters!"));
			return $this -> output -> set_output($response);exit;
		}
		
		$this -> setPostedData();
		
		$dcode = get_districts_dcode($distcode);
		$caseNumber = get_max_case_number($dcode, $year);

		$investigationData = array(
							'week' => $week,
							'fweek' => $fweek,
							'year' => $year,
							'name' =>  $this -> input -> post('name') ?? NULL,
							'age_in_year' => $this -> input -> post('age_in_year') ?? 0,
							'gender' => $this -> input -> post('gender') ?? NULL,
							'occupation' => $this -> input -> post('occupation') ?? NULL,
							'nationality' => $this -> input -> post('occupation') ?? NULL,
							
							'procode' => $procode,
							'distcode' => $distcode,
							'tcode' => $this -> input -> post('tcode'),
							'uncode' => $this -> input -> post('uncode'),
							'facode' => $this -> input -> post('facode'),
							'village_muhallah' => $this -> input -> post('village_muhallah'),
							'country' => $this -> input -> post('country'),
							'city_state' => $this -> input -> post('city_state'),
							'telephone' => $this -> input -> post('telephone'),
							'mobile' => $this -> input -> post('mobile') ?? NULL,
							
							'have_travel_history' => $this -> input -> post('have_travel_history') ?? NULL,
							'have_travel_abroad' => $this -> input -> post('have_travel_abroad') ?? NULL,
							'have_travel_within_country' => $this -> input -> post('have_travel_within_country') ?? NULL,
							
							'country_1' => $this -> input -> post('country_1') ?? NULL,
							'country_2' => $this -> input -> post('country_2') ?? NULL,
							'country_3' => $this -> input -> post('country_3') ?? NULL,
							'country_4' => $this -> input -> post('country_4') ?? NULL,
							'country_5' => $this -> input -> post('country_5') ?? NULL,
							'country_6' => $this -> input -> post('country_6') ?? NULL,
							'country_7' => $this -> input -> post('country_7') ?? NULL,
							'country_8' => $this -> input -> post('country_8') ?? NULL,
							'country_9' => $this -> input -> post('country_9') ?? NULL,
							'country_10' => $this -> input -> post('country_10') ?? NULL,
							'country_11' => $this -> input -> post('country_11') ?? NULL,
							'country_12' => $this -> input -> post('country_12') ?? NULL,
							
							'visit_purpose' => $this -> input -> post('visit_purpose') ?? NULL,
							'stay_duration' => $this -> input -> post('stay_duration') ?? NULL,
							'address_during_stay' => $this -> input -> post('address_during_stay') ?? NULL,
							'influenza_vaccine' => $this -> input -> post('influenza_vaccine') ?? 0,
							'know_any_person_with_symptons' => $this -> input -> post('know_any_person_with_symptons') ?? 0,
							
							'is_fever' => $this -> input -> post('is_fever') ?? NULL,
							'is_cough' => $this -> input -> post('is_cough') ?? NULL,
							'difficulty_breathing' => $this -> input -> post('difficulty_breathing') ?? NULL,
							'chronic_ailment' => $this -> input -> post('chronic_ailment') ?? NULL,
							'chronic_ailment_desc' => $this -> input -> post('chronic_ailment_desc') ?? NULL,
							'any_other' => $this -> input -> post('any_other') ?? NULL,
							'temprature' => $this -> input -> post('temprature') ?? NULL,
							'bp_from' => $this -> input -> post('bp_from') ?? NULL,
							'bp_to' => $this -> input -> post('bp_to') ?? NULL,
							'pulse_rate' => $this -> input -> post('pulse_rate') ?? NULL,
							'chest_asculation' => $this -> input -> post('chest_asculation') ?? NULL,
							'retained_at_poe' => $this -> input -> post('retained_at_poe') ?? NULL,
							'no_of_days_retained' => $this -> input -> post('no_of_days_retained') ?? NULL,
							'shifted_for_isolation' => $this -> input -> post('shifted_for_isolation') ?? NULL,
							'days_admitted' => $this -> input -> post('days_admitted') ?? NULL,
							
							'sample_collected' => $this -> input -> post('sample_collected') ?? NULL,
							'sample_type' => $this -> input -> post('sample_type') ?? 0,
							
							'poe' => $this -> input -> post('poe') ?? 0,
							'interviewer_name' => $this -> input -> post('interviewer_name') ?? 0,
							'interviewer_designation' => $this -> input -> post('interviewer_designation') ?? 0,
							'interviewer_contact' => $this -> input -> post('interviewer_contact') ?? 0,
							
							'case_number' => $caseNumber,
							'case_epi_no' => get_epid_no($distcode, $year),
							'cross_notified' => $this -> input -> post('cross_notified') ?? 0,
							'cross_notified_from_distcode' => $this -> input -> post('cross_notified_from_distcode') ?? 0,
							'rb_procode' => $this -> input -> post('rb_procode') ?? 0,
							'rb_distcode' => $this -> input -> post('rb_distcode') ?? 0,
							'rb_tcode' => $this -> input -> post('rb_tcode') ?? 0,
							'rb_uncode' => $this -> input -> post('rb_uncode') ?? 0,
							'rb_facode' => $this -> input -> post('rb_facode') ?? 0,
							
							'patient_address_procode' => $this -> input -> post('patient_address_procode') ?? NULL,
							'patient_address_distcode' => $this -> input -> post('patient_address_distcode') ?? NULL,
							'patient_address_tcode' => $this -> input -> post('patient_address_tcode') ?? NULL,
							'patient_address_uncode' => $this -> input -> post('patient_address_uncode') ?? NULL,
							'patient_address' => $this -> input -> post('patient_address') ?? NULL,
							
							'case_type' => 'Covid',
							'dcode' => $dcode,
							//----------- Dates -------------//
							'datefrom' => $this -> input -> post('datefrom') ?? NULL,
							'dateto' => $this -> input -> post('dateto') ?? NULL,
							'date_of_shipment_to_nih' => $this -> input -> post('date_of_shipment_to_nih') ?? NULL,
							'interviewer_date' => $this -> input -> post('interviewer_date') ?? NULL,
							'date_of_onset' => $this -> input -> post('date_of_onset') ?? NULL,
							'date_of_notification' => $this -> input -> post('date_of_notification') ?? NULL,
							'date_of_investigation' => $this -> input -> post('date_of_investigation') ?? NULL,
							'date_of_quarantine' => $this -> input -> post('date_of_quarantine') ?? NULL,
							'date_of_collection' => $this -> input -> post('date_of_collection') ?? NULL,
							'date_reported' => $this -> input -> post('date_reported') ?? NULL,
							'pvh_date' => $this -> input -> post('pvh_date') ?? NULL,
							'techniciancode' => $this -> input -> post('techniciancode') ?? NULL,
		);
		
		if( ! $this -> input -> post('edit'))
			$investigationData['submitted_date'] = date('Y-m-d');
		$investigationData['editted_date'] = date('Y-m-d H:i:s');
		
		if($this -> input -> post('edit')){
			$caseNumber = $this -> input -> post('case_number');
			$investigationData['case_epi_no'] = $this -> input -> post('case_epi_no');
			$investigationData['case_number'] = $caseNumber;
			if(validate_existing_record($fweek, $procode, $distcode, $dcode, $caseNumber) === TRUE){
				$whereCondition = array(
									'fweek' => $fweek,
									'procode' => $procode,
									'distcode' => $distcode,
									'dcode' => $dcode,
									'case_number' => $caseNumber
				);
				unset($investigationData['procode']);unset($investigationData['distcode']);unset($investigationData['dcode']);
				unset($investigationData['case_number']);unset($investigationData['epi_case_no']);unset($investigationData['fweek']);
				unset($investigationData['year']);unset($investigationData['week']);unset($investigationData['epid_year']);
				$this -> db -> update('corona_case_investigation_form_db', $investigationData, $whereCondition);
				$response = json_encode(array("success" => TRUE, "message" => "Data Updated Successfully!", "epid_no" => $investigationData['case_epi_no']));
				$insertedId = get_inserted_id($whereCondition);
			}else{
				$this -> db -> insert('corona_case_investigation_form_db', $investigationData);
				$insertedId = $this->db->insert_id();
				$response = json_encode(array("success" => TRUE, "message" => "Data Inserted Successfully!", "epid_no" => $investigationData['case_epi_no']));
			}
		}else{
			$this -> db -> insert('corona_case_investigation_form_db', $investigationData);
			$insertedId = $this->db->insert_id();
			$response = json_encode(array("success" => TRUE, "message" => "Data Inserted Successfully!", "epid_no" => $investigationData['case_epi_no']));
		}
		
		if($this -> input -> post('have_travel_history') == 1){
			if($this -> input -> post('have_travel_abroad') == 1){
				$travelAbroadData = $this -> input -> post('travel_abroad_data');
				$travelAbroadData = json_decode($travelAbroadData);
				foreach($travelAbroadData as $aKey => $aVal){
					$abroadDataToInsert = array (
						'country' => $aVal->country,
						'departed_date' => $aVal->departed_date,
						'transit_site' => $aVal->transit_site,
						'case_id' => $insertedId
					);
					$this -> db -> insert('abroad_cases',$abroadDataToInsert);
				}
			}
			if($this -> input -> post('have_travel_within_country') == 1){
				$travelWithinData = json_decode($this -> input -> post('travel_within_data'));
				foreach($travelWithinData as $wKey => $wVal){
					$countryDataToInsert = array (
						'from_procode' => $wVal->from_procode,
						'from_distcode' => $wVal->from_distcode,
						'from_tcode' => $wVal->from_tcode,
						'from_uncode' => $wVal->from_uncode,
						'from_address' => $wVal->from_address,
						'date_from' => $wVal->date_from,
						'to_procode' => $wVal->to_procode,
						'to_distcode' => $wVal->to_distcode,
						'to_tcode' => $wVal->to_tcode,
						'to_uncode' => $wVal->to_uncode,
						'to_address' => $wVal->to_address,
						'date_to' => $wVal->date_to,
						'case_id' => $insertedId
					);
					$this -> db -> insert('country_visits',$countryDataToInsert);
				}
			}
		}
		
		return $this -> output -> set_output($response);
	}
	
	/* public function login(){
		$data = json_encode($this -> input -> post());
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$token = $this -> input -> post('token');
		$action = $this -> input -> post('action');
		$model_no = $this -> input -> post('model_no');

		if(app_authentication($username, $password)){
			$userDetails = get_user_details($username);
			$dataToReturn = array(
									"username" => $username,
									"level" => $userDetails -> level,
									"user_type" => $userDetails -> utype,
									"facode" => $userDetails -> facode??0,
									"facility" => $userDetails -> facility??NULL,
									"tcode" => $userDetails -> tcode??0,
									"tehsil" => $userDetails -> tehsil??NULL,
									"distcode" => $userDetails -> distcode??0,
									"district" => $userDetails -> district??NULL,
									"procode" => $userDetails -> procode??0,
									"province" => $userDetails -> province??NULL,
									"province_shortname" => get_province_short_name($userDetails -> procode),
									"epid_code" => get_districts_dcode($userDetails -> distcode)
			);
			$response = json_encode(array("success"=>TRUE,"message"=>"Authentication Successful!", "data" => $dataToReturn));
			loginlog($username, "Success", $data, $_SERVER['REMOTE_ADDR'], "Mobile", "", $response);
			if($model_no != '')
				update_model_no($username,$model_no);
		}else{
			$response = json_encode(array("success"=>FALSE,"message"=>"Authentication Failed!"));
			loginlog($username, "Failed", $data, $_SERVER['REMOTE_ADDR'], "Mobile", "Authentication Closed", $response);
		}
		return $this -> output -> set_output($response);
	} */
	
	public function login(){
		$data = json_encode($this -> input -> post());
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$model_no = $this -> input -> post('model_no');
		if(authentication($username, $password)){
			$response = json_encode(loginresponsejson($username));
			loginlog($username, "Success", $data, $_SERVER['REMOTE_ADDR'], "Mobile", "", $response);
			if($model_no != '')
				updateTechnicianModelNo($username,$model_no);
		}else{
			$response = json_encode(array("success"=>"no","message"=>"Authentication Failed!"));
			loginlog($username, "Failed", $data, $_SERVER['REMOTE_ADDR'], "Mobile", "Authentication Closed", $response);
		}
		return $this->output->set_output($response);
	}
	
	public function downsync_epiweeks(){
		$weeks = get_epi_weeks_for_app();
		$response = json_encode(array("success"=>TRUE,"message"=>"Data Fetching Successful!", "data" => $weeks));
		return $this -> output -> set_output($response);
	}
	
	public function downsync_corona_cases(){
		$distcode = $this -> input -> get('distcode');
		$cases = get_all_corona_cases($distcode);
		$response = json_encode(array("success"=>TRUE,"message"=>"Data Fetching Successful!", "data" => $cases));
		return $this -> output -> set_output($response);
	}
	
	function setPostedData(){
		$dataPosted = array();
		$dataPosted = $_POST;
		foreach($dataPosted as $key => $value)
		{
			$_POST[$key] = (($value=='')?NULL:$value);
			if($dataPosted[$key] == NULL || $dataPosted[$key]=="0")
				unset($_POST[$key]);
		}
	}
}
?>