<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Apis_model','apis');
		//$this -> load -> helper('apis_helper');
		//$this -> load -> library('notifications');
		$this->output->set_content_type('application/json');
	}
	public function Esure_measles_case_investigation()
	{
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
		$reg_facode = $this -> input -> post ('facode');
		//$cardno = $this -> input -> post ('child_registration_num');
		$insertData['procode'] = $this -> input -> post('procode');
		$insertData['distcode'] = $distcode = $this -> input -> post('distcode');
		$insertData['tcode'] = $this -> input -> post('tcode');
		$insertData['uncode'] = $this -> input -> post('uncode');
		$insertData['facode'] = $this -> input -> post('facode');
		$insertData['faddress'] = $this -> input -> post('faddress');
		$insertData['year'] = $year = $this -> input -> post('year');
		$insertData['week'] = $this -> input -> post('week');
		$insertData['fweek'] = $this -> input -> post('fweek');
		$insertData['pvh_date'] = $this -> input -> post('pvh_date'); 
		 $insertData['case_type'] = $case_type = 'Msl';
		$insertData['patient_name'] = $this -> input -> post('patient_name');
		$insertData['patient_gender'] = $this -> input -> post('patient_gender');
		$insertData['patient_fathername'] = $this -> input -> post('patient_fathername');
		$insertData['contact_numb'] = $this -> input -> post('contact_numb');
		$insertData['patient_dob'] = $this -> input -> post('patient_dob'); 
		$insertData['age_months'] = $this -> input -> post('age_months');
		$insertData['patient_address_procode'] =  $distcode_patient_address = $this -> input -> post('patient_address_procode');
		$insertData['patient_address_distcode'] = $this -> input -> post('patient_address_distcode');
		$insertData['patient_address_tcode'] = $this -> input -> post('patient_address_tcode');
		$insertData['patient_address_uncode'] = $this -> input -> post('patient_address_uncode');
		$insertData['clinical_representation'] = $this -> input -> post('clinical_representation');
		$insertData['complications'] = $this -> input -> post('complications');
		$insertData['date_rash_onset'] = $this -> input -> post('date_rash_onset');
		$insertData['notification_date'] = $this -> input -> post('notification_date');
		$insertData['date_investigation'] = $this -> input -> post('date_investigation');
		$insertData['doses_received'] = $this -> input -> post('doses_received');
		$insertData['last_dose_date'] = $this -> input -> post('last_dose_date');
		$insertData['travel_history'] = $this -> input -> post('travel_history');
		$insertData['th_procode'] = $this -> input -> post('th_procode');
		$insertData['th_distcode'] = $this -> input -> post('th_distcode');
		$insertData['th_tcode'] = $this -> input -> post('th_tcode');
		$insertData['th_uncode'] = $this -> input -> post('th_uncode');
		$insertData['th_muhallah'] = $this -> input -> post('th_muhallah');
		$insertData['th_province'] = $this -> input -> post('th_province');
		$insertData['th_district'] = $this -> input -> post('th_district');
		$insertData['th_tehsil'] = $this -> input -> post('th_tehsil');
		$insertData['th_uc'] = $this -> input -> post('th_uc');
		$insertData['th_muhallah'] = $this -> input -> post('th_muhallah');
		$insertData['type_specimen'] = $this -> input -> post('type_specimen');
		$insertData['date_collection'] = $this -> input -> post('date_collection');
		$insertData['date_sent_lab'] = $this -> input -> post('date_sent_lab');
		$insertData['labresult_tobesentto'] = $this -> input -> post('labresult_tobesentto');
		$insertData['investigator_name'] = $this -> input -> post('investigator_name');
		$insertData['investigator_designation'] = $this -> input -> post('investigator_designation');
		$insertData['epid_year'] = $this -> input -> post('epid_year');
		$insertData['submitted_date'] = $this -> input -> post('submitted_date');
		$insertData['editted_date'] = $this -> input -> post('editted_date');
		$insertData['clinical_competible'] = $this -> input -> post('clinical_competible');
		$insertData['specimen_quantity_adequate'] = $this -> input -> post('specimen_quantity_adequate');
		$insertData['final_classification'] = $this -> input -> post('final_classification');
		$insertData['specimen_collected'] = $this -> input -> post('specimen_collected');
		$insertData['case_reported'] = $this -> input -> post('case_reported');
		$insertData['is_temp_saved'] = $this -> input -> post('is_temp_saved'); 
		
		// new coloumn added by uzair abbasi - incase of cross notefied
		$insertData['rb_distcode'] = $this -> input -> post('rb_distcode'); 
		$insertData['rb_tcode'] = $this -> input -> post('rb_tcode'); 
		$insertData['rb_uncode'] = $this -> input -> post('rb_uncode'); 
		$insertData['rb_facode'] = $this -> input -> post('rb_facode'); 
		$insertData['rb_faddress'] = $this -> input -> post('rb_faddress'); 
		
		$query = "SELECT epid_code AS dcode FROM districts WHERE distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$dcode = $result['dcode'];
		$insertData['dcode'] = $dcode; 
		$query = "SELECT max(case_number) AS case_number FROM case_investigation_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$fourdigit_number = sprintf('%04u', ($result['case_number'] + 1));
		$case_number = $fourdigit_number; 
	//	$case_epi_no = "PAK/KP/".$dcode."/".$year."/".$case_type."/".$case_number;
		//$insertData['case_epi_no'] = $case_epi_no;
		//$insertData['case_number'] = $case_number; 
		/* $childAlreadyRegistered = $this -> apis -> check_case_investigation_reg($cardno);
		$insertData['child_registration_num'] = $childAlreadyRegistered; */
		// $test = $insertData['child_registration_num'];
		/* if($test > 0){
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"child Registration Number Already Inserted, Kindly give some other number.")));
			}
			 else{
				$insertData['child_registration_num'] = $cardno;
			}  */
			$insert = $this -> apis -> Esure_case_investigation($insertData);
			
			//echo $this->db->last_query();exit;
			
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	
	public function zero_report_api()
	{
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
			$insertData['id'] = $this -> input -> post('id');
			$insertData['facode'] = $this -> input -> post('facode');
			$insertData['distcode'] = $this -> input -> post('distcode');
			$insertData['fweek'] = $this -> input -> post('fweek');
			$insertData['year'] = $this -> input -> post('year');
			$insertData['week'] = $this -> input -> post('week');
			$insertData['datefrom'] = $this -> input -> post('datefrom');
			$insertData['dateto'] = $this -> input -> post('dateto');
			$insertData['report_submitted'] = $this -> input -> post('report_submitted');
			$insertData['tb_cases'] = $this -> input -> post('tb_cases');
			$insertData['tb_deaths'] = $this -> input -> post('tb_deaths');
			$insertData['pertusis_cases'] = $this -> input -> post('pertusis_cases');
			$insertData['pertusis_deaths'] = $this -> input -> post('pertusis_deaths');
			$insertData['diphtheria_cases'] = $this -> input -> post('diphtheria_cases');
			$insertData['diphtheria_deaths'] = $this -> input -> post('diphtheria_deaths');
			$insertData['measle_cases'] = $this -> input -> post('measle_cases');
			$insertData['measle_deaths'] = $this -> input -> post('measle_deaths');
			$insertData['hepatits_cases'] = $this -> input -> post('hepatits_cases');
			$insertData['hepatits_deaths'] = $this -> input -> post('hepatits_deaths');
			$insertData['undis_cases'] = $this -> input -> post('undis_cases');
			$insertData['undis_deaths'] = $this -> input -> post('undis_deaths');
			$insertData['meningitis_cases'] = $this -> input -> post('meningitis_cases');
			$insertData['meningitis_deaths'] = $this -> input -> post('meningitis_deaths');
			$insertData['vl_cases'] = $this -> input -> post('vl_cases');
			$insertData['vl_deaths'] = $this -> input -> post('vl_deaths');
			$insertData['nnt_cases'] = $this -> input -> post('nnt_cases');
			$insertData['nnt_deaths'] = $this -> input -> post('nnt_deaths');
			$insertData['afp_cases'] = $this -> input -> post('afp_cases');
			$insertData['afp_deaths'] = $this -> input -> post('afp_deaths');
			$insertData['psy_cases'] = $this -> input -> post('psy_cases');
			$insertData['psy_deaths'] = $this -> input -> post('psy_deaths');
			$insertData['avh_cases'] = $this -> input -> post('avh_cases');
			$insertData['avh_deaths'] = $this -> input -> post('avh_deaths');
			$insertData['df_cases'] = $this -> input -> post('df_cases');
			$insertData['df_deaths'] = $this -> input -> post('df_deaths');
			$insertData['dhf_cases'] = $this -> input -> post('dhf_cases');
			$insertData['dhf_deaths'] = $this -> input -> post('dhf_deaths');
			$insertData['cchf_cases'] = $this -> input -> post('cchf_cases');
			$insertData['cchf_deaths'] = $this -> input -> post('cchf_deaths');
			$insertData['cl_cases'] = $this -> input -> post('cl_cases');
			$insertData['cl_deaths'] = $this -> input -> post('cl_deaths');
			$insertData['diarrhea_great_five_cases'] = $this -> input -> post('diarrhea_great_five_cases');
			$insertData['diarrhea_great_five_deaths'] = $this -> input -> post('diarrhea_great_five_deaths');
			$insertData['diarrhea_cases'] = $this -> input -> post('diarrhea_cases');
			$insertData['diarrhea_deaths'] = $this -> input -> post('diarrhea_deaths');
			$insertData['bd_cases'] = $this -> input -> post('bd_cases');
			$insertData['bd_deaths'] = $this -> input -> post('bd_deaths');
			$insertData['ad_cases'] = $this -> input -> post('ad_cases');
			$insertData['ad_deaths'] = $this -> input -> post('ad_deaths');
			$insertData['tf_cases'] = $this -> input -> post('tf_cases');
			$insertData['tf_deaths'] = $this -> input -> post('tf_deaths');
			$insertData['urti_cases'] = $this -> input -> post('urti_cases');
			$insertData['urti_deaths'] = $this -> input -> post('urti_deaths');
			$insertData['pneumonia_cases'] = $this -> input -> post('pneumonia_cases');
			$insertData['pneumonia_deaths'] = $this -> input -> post('pneumonia_deaths');
			$insertData['pneumonia_great_five_cases'] = $this -> input -> post('pneumonia_great_five_cases');
			$insertData['pneumonia_great_five_deaths'] = $this -> input -> post('pneumonia_great_five_deaths');
			$insertData['sari_cases'] = $this -> input -> post('sari_cases');
			$insertData['sari_deaths'] = $this -> input -> post('sari_deaths');
			$insertData['submitted_date'] = $this -> input -> post('submitted_date');
			$insertData['updated_date'] = $this -> input -> post('updated_date');
			$insert = $this -> apis -> zero_report_api($insertData);
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	
	public function AEFI_report_api()
	{
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
			//$insertData['id'] = $this -> input -> post('id');
			$insertData['casename'] = $this -> input -> post('casename');
			$insertData['gender'] = $this -> input -> post('gender');
			$insertData['dob'] = $this -> input -> post('dob');
			$insertData['age'] = $this -> input -> post('age');
			$insertData['years'] = $this -> input -> post('years');
			$insertData['months'] = $this -> input -> post('months');
			$insertData['weeks'] = $this -> input -> post('weeks');
			$insertData['fathername'] = $this -> input -> post('fathername');
			$insertData['husbandname'] = $this -> input -> post('husbandname');
			$insertData['cellnumber'] = $this -> input -> post('cellnumber');
			$insertData['village'] = $this -> input -> post('village');
			$insertData['procode'] = $this -> input -> post('procode');
			$insertData['distcode'] = $this -> input -> post('distcode');
			$insertData['tcode'] = $this -> input -> post('tcode');
			$insertData['uncode'] = $this -> input -> post('uncode');
			$insertData['facode'] = $this -> input -> post('facode');
			$insertData['year'] = $this -> input -> post('year');
			$insertData['week'] = $this -> input -> post('week');
			$insertData['datefrom'] = $this -> input -> post('datefrom');
			$insertData['dateto'] = $this -> input -> post('dateto');
			$insertData['mc_bcg'] = $this -> input -> post('mc_bcg');
			$insertData['mc_severe'] = $this -> input -> post('mc_severe');
			$insertData['mc_abscess'] = $this -> input -> post('mc_abscess');
			$insertData['mc_fever'] = $this -> input -> post('mc_fever');
			$insertData['mc_rash'] = $this -> input -> post('mc_rash');
			$insertData['mc_convulsion'] = $this -> input -> post('mc_convulsion');
			$insertData['mc_unconscious'] = $this -> input -> post('mc_unconscious');
			$insertData['mc_respiratory'] = $this -> input -> post('mc_respiratory');
			$insertData['mc_swelling'] = $this -> input -> post('mc_swelling');
			$insertData['mc_other'] = $this -> input -> post('mc_other');                  // spelling change on APP
			$insertData['mc_treatment'] = $this -> input -> post('mc_treatment');
			$insertData['mc_hospitalized'] = $this -> input -> post('mc_hospitalized');    // spelling change on APP
			$insertData['mc_hosp_address'] = $this -> input -> post('mc_hosp_address');
			$insertData['vacc_date'] = $this -> input -> post('vacc_date');
			$insertData['vacc_name'] = $this -> input -> post('vacc_name');
			$insertData['vacc_manufacturer'] = $this -> input -> post('vacc_manufacturer');
			$insertData['vacc_exp'] = $this -> input -> post('vacc_exp');
			$insertData['vacc_center'] = $this -> input -> post('vacc_center');
			$insertData['vacc_vaccinator'] = $this -> input -> post('vacc_vaccinator');
			$insertData['rep_person'] = $this -> input -> post('rep_person');
			$insertData['rep_desg'] = $this -> input -> post('rep_desg');
			$insertData['fweek'] = $this -> input -> post('fweek');
			$insertData['submitted_date'] = $this -> input -> post('submitted_date');
			$insertData['editted_date'] = $this -> input -> post('editted_date');
			$insertData['is_temp_saved'] = $this -> input -> post('is_temp_saved');

			$insert = $this -> apis -> AEFI_report_api($insertData);
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	
		public function AFP_report_api()
	{ 
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
				$insertData['id'] = $this -> input -> post('id');
				$insertData['facode'] = $this -> input -> post('facode');
				$insertData['faddress'] = $this -> input -> post('faddress');
				$insertData['uncode'] = $this -> input -> post('uncode');
				$insertData['tcode'] = $this -> input -> post('tcode');
				$insertData['distcode'] = $this -> input -> post('distcode');
				$insertData['procode'] = $this -> input -> post('procode');
				$insertData['year'] = $this -> input -> post('year');
				$insertData['week'] = $this -> input -> post('week');
				$insertData['datefrom'] = $this -> input -> post('datefrom');         // spelling change on APP
				$insertData['dateto'] = $this -> input -> post('dateto');             // spelling change on APP
				$insertData['case_reported'] = $this -> input -> post('case_reported');
				$insertData['epid_year'] = $this -> input -> post('epid_year');
				$insertData['afp_number'] = $this -> input -> post('afp_number');
				$insertData['dcode'] = $this -> input -> post('dcode');
				$insertData['patient_gender'] = $this -> input -> post('patient_gender');
				$insertData['patient_fathername'] = $this -> input -> post('patient_fathername');
				$insertData['patient_dob'] = $this -> input -> post('patient_dob');
				$insertData['age_months'] = $this -> input -> post('age_months');
				$insertData['patient_address'] = $this -> input -> post('patient_address');
				$insertData['patient_address_uncode'] = $this -> input -> post('patient_address_uncode');
				$insertData['patient_address_tcode'] = $this -> input -> post('patient_address_tcode');
				$insertData['patient_address_distcode'] = $this -> input -> post('patient_address_distcode');
				$insertData['case_date_investigation'] = $this -> input -> post('case_date_investigation');
				$insertData['case_date_notification'] = $this -> input -> post('case_date_notification');
				$insertData['case_date_onset'] = $this -> input -> post('case_date_onset');
				$insertData['fever_onset'] = $this -> input -> post('fever_onset');
				$insertData['rapid_progression'] = $this -> input -> post('rapid_progression');
				$insertData['asymm_paralysis'] = $this -> input -> post('asymm_paralysis');
				$insertData['sia'] = $this -> input -> post('sia');
				$insertData['date_collection_s1'] = $this -> input -> post('date_collection_s1');
				$insertData['date_collection_s2'] = $this -> input -> post('date_collection_s2');
				$insertData['date_sent_lab_s1'] = $this -> input -> post('date_sent_lab_s1');
				$insertData['date_sent_lab_s2'] = $this -> input -> post('date_sent_lab_s2');
				$insertData['condition_s1'] = $this -> input -> post('condition_s1');
				$insertData['condition_s2'] = $this -> input -> post('condition_s2');
				$insertData['final_result_s1'] = $this -> input -> post('final_result_s1');
				$insertData['final_result_s2'] = $this -> input -> post('final_result_s2');
				$insertData['date_follow_up'] = $this -> input -> post('date_follow_up');
				$insertData['classification'] = $this -> input -> post('classification');
				$insertData['final_diagnosis'] = $this -> input -> post('final_diagnosis');
				$insertData['residual_paralysis'] = $this -> input -> post('residual_paralysis');
				$insertData['patient_name'] = $this -> input -> post('patient_name');
				$insertData['case_epi_no'] = $this -> input -> post('case_epi_no');
				$insertData['fweek'] = $this -> input -> post('fweek');
				$insertData['submitted_date'] = $this -> input -> post('submitted_date');
				$insertData['editted_date'] = $this -> input -> post('editted_date');
				$insertData['clinical_representation'] = $this -> input -> post('clinical_representation');
				$insertData['doses_received'] = $this -> input -> post('doses_received');
				$insertData['is_temp_saved'] = $this -> input -> post('is_temp_saved');
				$insertData['cross_notified'] = $this -> input -> post('cross_notified');
				$insertData['cross_notified_from_distcode'] = $this -> input -> post('cross_notified_from_distcode');
				$insertData['rb_distcode'] = $this -> input -> post('rb_distcode');
				$insertData['rb_tcode'] = $this -> input -> post('rb_tcode');
				$insertData['rb_uncode'] = $this -> input -> post('rb_uncode');
				$insertData['rb_facode'] = $this -> input -> post('rb_facode');
				$insertData['rb_faddress'] = $this -> input -> post('rb_faddress');
				$insertData['approval_status'] = $this -> input -> post('approval_status');
				$insertData['patient_address_procode'] = $this -> input -> post('patient_address_procode');
				$insertData['cn_id_from'] = $this -> input -> post('cn_id_from');
				$insertData['cn_id_to'] = $this -> input -> post('cn_id_to');
				$insertData['cross_case_id'] = $this -> input -> post('cross_case_id');
				$insertData['contact_numb'] = $this -> input -> post('contact_numb');

			

			$insert = $this -> apis -> AFP_report_api($insertData);
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
		public function CoronaInvestigation_report_api()
	{
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
				
				$insertData['id'] = $this -> input -> post('id');
				$insertData['year'] = $this -> input -> post('year');
				$insertData['week'] = $this -> input -> post('week');
				$insertData['fweek'] = $this -> input -> post('fweek');
				$insertData['date_submitted'] = $this -> input -> post('date_submitted');
				$insertData['name'] = $this -> input -> post('name');
				$insertData['age_in_year'] = $this -> input -> post('age_in_year');
				$insertData['gender'] = $this -> input -> post('gender');
				$insertData['occupation'] = $this -> input -> post('occupation');
				$insertData['nationality'] = $this -> input -> post('nationality');
				$insertData['procode'] = $this -> input -> post('procode');
				$insertData['distcode'] = $this -> input -> post('distcode');
				$insertData['tcode'] = $this -> input -> post('tcode');
				$insertData['uncode'] = $this -> input -> post('uncode');
				$insertData['village_muhallah'] = $this -> input -> post('village_muhallah');
				$insertData['country'] = $this -> input -> post('country');
				$insertData['city_state'] = $this -> input -> post('city_state');
				$insertData['telephone'] = $this -> input -> post('telephone');
				$insertData['mobile'] = $this -> input -> post('mobile');
				$insertData['have_travel_history'] = $this -> input -> post('have_travel_history');
				$insertData['have_travel_abroad'] = $this -> input -> post('have_travel_abroad');
				$insertData['have_travel_within_country'] = $this -> input -> post('have_travel_within_country');
				$insertData['country_1'] = $this -> input -> post('country_1');
				$insertData['country_2'] = $this -> input -> post('country_2');
				$insertData['country_3'] = $this -> input -> post('country_3');
				$insertData['country_4'] = $this -> input -> post('country_4');
				$insertData['country_5'] = $this -> input -> post('country_5');
				$insertData['country_6'] = $this -> input -> post('country_6');
				$insertData['country_7'] = $this -> input -> post('country_7');
				$insertData['country_8'] = $this -> input -> post('country_8');
				$insertData['country_9'] = $this -> input -> post('country_9');
				$insertData['country_10'] = $this -> input -> post('country_10');
				$insertData['country_11'] = $this -> input -> post('country_11');
				$insertData['country_12'] = $this -> input -> post('country_12');
				$insertData['visit_purpose'] = $this -> input -> post('visit_purpose');
				$insertData['stay_duration'] = $this -> input -> post('stay_duration');
				$insertData['address_during_stay'] = $this -> input -> post('address_during_stay');
				$insertData['influenza_vaccine'] = $this -> input -> post('influenza_vaccine');
				$insertData['know_any_person_with_symptons'] = $this -> input -> post('know_any_person_with_symptons');
				$insertData['date_of_onset'] = $this -> input -> post('date_of_onset');
				$insertData['date_of_investigation'] = $this -> input -> post('date_of_investigation');
				$insertData['date_of_quarantine'] = $this -> input -> post('date_of_quarantine');
				$insertData['date_of_notification'] = $this -> input -> post('date_of_notification');
				$insertData['date_reported'] = $this -> input -> post('date_reported');
				$insertData['is_fever'] = $this -> input -> post('is_fever');
				$insertData['is_cough'] = $this -> input -> post('is_cough');
				$insertData['difficulty_breathing'] = $this -> input -> post('difficulty_breathing');
				$insertData['chronic_ailment'] = $this -> input -> post('chronic_ailment');
				$insertData['chronic_ailment_desc'] = $this -> input -> post('chronic_ailment_desc');
				$insertData['any_other'] = $this -> input -> post('any_other');
				$insertData['temprature'] = $this -> input -> post('temprature');
				$insertData['bp_from'] = $this -> input -> post('bp_from');
				$insertData['pulse_rate'] = $this -> input -> post('pulse_rate');
				$insertData['chest_asculation'] = $this -> input -> post('chest_asculation');
				$insertData['retained_at_poe'] = $this -> input -> post('retained_at_poe');
				$insertData['no_of_days_retained'] = $this -> input -> post('no_of_days_retained');
				$insertData['shifted_for_isolation'] = $this -> input -> post('shifted_for_isolation');
				$insertData['days_admitted'] = $this -> input -> post('days_admitted');
				$insertData['sample_collected'] = $this -> input -> post('sample_collected');
				$insertData['date_of_collection'] = $this -> input -> post('date_of_collection');
				$insertData['sample_type'] = $this -> input -> post('sample_type');
				$insertData['date_of_shipment_to_nih'] = $this -> input -> post('date_of_shipment_to_nih');
				$insertData['interviewer_date'] = $this -> input -> post('interviewer_date');
				$insertData['poe'] = $this -> input -> post('poe');
				$insertData['interviewer_name'] = $this -> input -> post('interviewer_name');
				$insertData['interviewer_designation'] = $this -> input -> post('interviewer_designation');
				$insertData['interviewer_contact'] = $this -> input -> post('interviewer_contact');
				$insertData['case_epi_no'] = $this -> input -> post('case_epi_no');
				$insertData['case_number'] = $this -> input -> post('case_number');
				$insertData['bp_to'] = $this -> input -> post('bp_to');
				$insertData['facode'] = $this -> input -> post('facode');


			

			$insert = $this -> apis -> CoronaInvestigation_report_api($insertData);
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
		public function NNT_report_api()
	{
		/*  $token = $this -> input -> post('validate_token');
		$userName = $this -> input -> post('username');
		if($token != NULL && $userName != NULL){
			$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}
		}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Provide a Valid Token and Username")));
		}  */
				$insertData['active_sur_visit'] = $this -> input -> post('active_sur_visit');
				$insertData['approval_status'] = $this -> input -> post(approval_status);
				$insertData['b_death_date'] = $this -> input -> post('b_death_date');
				$insertData['bs_cry'] = $this -> input -> post('bs_cry');						 // spelling change on APP
				$insertData['baby_dob'] = $this -> input -> post('baby_dob');
				$insertData['bs_case_confirmed'] = $this -> input -> post('bs_case_confirmed');
				$insertData['bs_days'] = $this -> input -> post('bs_days');
				$insertData['bs_normal_birth'] = $this -> input -> post('bs_normal_birth');
				$insertData['bs_spasms'] = $this -> input -> post('bs_spasms');
				$insertData['bs_stiffness'] = $this -> input -> post('bs_stiffness');
				$insertData['bs_stop_sucking'] = $this -> input -> post('bs_stop_sucking');
				$insertData['card_date1'] = $this -> input -> post('card_date1');
				$insertData['card_date2'] = $this -> input -> post('card_date2');
				$insertData['card_date3'] = $this -> input -> post('card_date3');
				$insertData['card_date4'] = $this -> input -> post('card_date4');
				$insertData['card_date5'] = $this -> input -> post('card_date5');
				$insertData['case_reported'] = $this -> input -> post('case_reported');
				$insertData['cases'] = $this -> input -> post('cases');
				$insertData['cord_treated'] = $this -> input -> post('cord_treated');
				$insertData['date_admission'] = $this -> input -> post('date_admission');
				$insertData['date_delivery'] = $this -> input -> post('date_delivery');
				$insertData['date_investigation'] = $this -> input -> post('date_investigation');
				$insertData['date_notification'] = $this -> input -> post('date_notification');
				$insertData['date_notification_level'] = $this -> input -> post('date_notification_level');
				$insertData['date_onset'] = $this -> input -> post('date_onset');
				$insertData['datefrom'] = $this -> input -> post('datefrom');
				$insertData['dateto'] = $this -> input -> post('dateto');
				$insertData['deaths'] = $this -> input -> post('deaths');
				$insertData['diagnosed_by'] = $this -> input -> post('diagnosed_by');
				$insertData['distcode'] = $this -> input -> post('distcode');
				$insertData['doses_received'] = $this -> input -> post('doses_received');
				$insertData['editted_date'] = $this -> input -> post('editted_date');
				$insertData['ethnic_group'] = $this -> input -> post('ethnic_group');
				$insertData['facode'] = $this -> input -> post('facode');
				$insertData['facode1'] = $this -> input -> post('facode1');
				$insertData['facode2'] = $this -> input -> post('facode2');
				$insertData['facode3'] = $this -> input -> post('facode3');
				$insertData['rb_faddress'] = $this -> input -> post('rb_faddress');						 // spelling change on APP
				$insertData['full_mother_name'] = $this -> input -> post('full_mother_name');
				$insertData['gender'] = $this -> input -> post('gender');
				$insertData['head_full_name'] = $this -> input -> post('head_full_name');
				$insertData['house_hold_address'] = $this -> input -> post('house_hold_address');
				$insertData['id'] = $this -> input -> post('id');
				$insertData['identified_weekly_data'] = $this -> input -> post('identified_weekly_data');
				$insertData['informed_by_call'] = $this -> input -> post('informed_by_call');
				$insertData['instrument_used'] = $this -> input -> post('instrument_used');
				$insertData['investigated_by'] = $this -> input -> post('investigated_by');
				$insertData['m_death_date'] = $this -> input -> post('m_death_date');
				$insertData['med_record_number'] = $this -> input -> post('med_record_number');
				$insertData['mode_reporting'] = $this -> input -> post('mode_reporting');
				$insertData['n_facode'] = $this -> input -> post('n_facode');
				$insertData['nnt_distcode'] = $this -> input -> post('nnt_distcode');
				$insertData['nnt_facode'] = $this -> input -> post('nnt_facode');
				$insertData['nnt_tcode'] = $this -> input -> post('nnt_tcode');
				$insertData['nnt_uncode'] = $this -> input -> post('nnt_uncode');
				$insertData['place_investigation'] = $this -> input -> post('place_investigation');
				$insertData['pregnancy_visits'] = $this -> input -> post('pregnancy_visits');				 // spelling change on APP
				$insertData['procode'] = $this -> input -> post('procode');
				$insertData['rb_facode'] = $this -> input -> post('rb_facode');
				$insertData['rb_faddress'] = $this -> input -> post('rb_faddress');
				$insertData['rb_tcode'] = $this -> input -> post('rb_tcode');
				$insertData['rb_uncode'] = $this -> input -> post('rb_uncode');
				$insertData['reported_by'] = $this -> input -> post('reported_by');
				$insertData['reported_from'] = $this -> input -> post('reported_from');
				$insertData['submitted_date'] = $this -> input -> post('submitted_date');
				$insertData['tcode'] = $this -> input -> post('tcode'); 
				$insertData['tr_baby_died'] = $this -> input -> post('tr_baby_died');
				$insertData['tr_cared'] = $this -> input -> post('tr_cared');
				$insertData['tr_distcode'] = $this -> input -> post('tr_distcode');
				$insertData['tr_mother_died'] = $this -> input -> post('tr_mother_died');					 // spelling change on APP
				$insertData['uncode'] = $this -> input -> post('uncode');
				$insertData['week'] = $this -> input -> post('week');
				$insertData['where_baby_delivered'] = $this -> input -> post('where_baby_delivered');
				$insertData['year'] = $this -> input -> post('year');


			$insert = $this -> apis -> NNT_report_api($insertData);
			if($insert){
				return $this->output->set_output(json_encode(array("success"=>"yes","message"=>"Data Inserted Successfully!")));
			}else{
			return $this->output->set_output(json_encode(array("success"=>"no","message"=>"There was some error inserting the data.")));
		}
	}
	
}
?>