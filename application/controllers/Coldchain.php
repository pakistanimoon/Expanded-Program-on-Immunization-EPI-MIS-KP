<?php
class Coldchain extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		authentication(); 
		$this -> load -> model ('Coldchain_model');
		$this -> load -> model ('Common_model'); 
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation'); 
	}
	//================ Constructor Function Ends ==================//
		//--------------------------------------------------------------------//
	//================rev_health_facility_questionnaire_pak Function===============///
	public function rev_health_facility_questionnaire_pak(){
		
		//dataEntryValidator();
		//echo 'here';exit;
		$data = $this -> Coldchain_model -> rev_health_facility_questionnaire_pak();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/rev_health_facility_questionnaire_pak';
			$data['pageTitle']='Health Facility Questionnaire | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	
	//================rev_health_facility_questionnaire_pak Lisitng Function===============///
	public function rev_health_facility_questionnaire_pak_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_hf_questionnaire ";
		$data = $this -> Coldchain_model -> rev_health_facility_questionnaire_pak_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/rev_health_facility_questionnaire_pak_list';
			$data['pageTitle'] = 'EPI-MIS | List of Health Facility Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	
	//================rev_health_facility_questionnaire_pak Save Function===============///
	public function rev_health_facility_questionnaire_pak_save(){
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
		$type_of_services_list = $this->input->post('type_of_services') ? $this->input->post('type_of_services')  : NULL; 
		if($type_of_services_list!=''){
				
				foreach($type_of_services_list as $row){
					$new1[] = $row;
				}
				$type_of_services_list_new=implode(',',$new1);
			}
		$waste_disposal = $this->input->post('waste_disposal') ? $this->input->post('waste_disposal')  : NULL;
		if($waste_disposal!=''){
				
				foreach($waste_disposal as $row){
					$new2[] = $row;
				}
				$waste_disposal_list=implode(',',$new2);
			}
		$solar_energy = $this->input->post('solar_energy') ? $this->input->post('solar_energy')  : NULL;
			if($solar_energy!=''){
				
				foreach($solar_energy as $row){
					$new3[] = $row;
				}
				$solar_energy_list=implode(',',$new3);
			}
		$rhfqpData = array(
				'procode' => ($this -> session -> Province)? $this -> session -> Province : $this -> session -> Province,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
				'fatype' => ($this -> input -> post ('fatype'))? $this -> input -> post ('fatype') : Null,
				'other_fatype' => ($this -> input -> post ('other_fatype'))? $this -> input -> post ('other_fatype') : Null,
				'tot_pop' => ($this -> input -> post ('tot_pop'))? $this -> input -> post ('tot_pop') : Null,
				'live_births' => ($this -> input -> post ('live_births'))? $this -> input -> post ('live_births') : Null,
				'resupply_interval' => ($this -> input -> post ('resupply_interval'))? $this -> input -> post ('resupply_interval') : Null,
				'no_preg_women' => ($this -> input -> post ('no_preg_women'))? $this -> input -> post ('no_preg_women') : Null,
				'no_child_bearing_age' => ($this -> input -> post ('no_child_bearing_age'))? $this -> input -> post ('no_child_bearing_age') : Null,
				'vaccine_storage' => ($this -> input -> post ('vaccine_storage'))? $this -> input -> post ('vaccine_storage') : Null,
				'type_of_services' => $type_of_services_list_new,
				'epi_vaccinators' => ($this -> input -> post ('epi_vaccinators'))? $this -> input -> post ('epi_vaccinators') : Null,
				'epi_lhvs' => ($this -> input -> post ('epi_lhvs'))? $this -> input -> post ('epi_lhvs') : Null,
				'epi_dispensers' => ($this -> input -> post ('epi_dispensers'))? $this -> input -> post ('epi_dispensers') : Null,
				'epi_lhss' => ($this -> input -> post ('epi_lhss'))? $this -> input -> post ('epi_lhss') : Null,
				'epi_store_keepers' => ($this -> input -> post ('epi_store_keepers'))? $this -> input -> post ('epi_store_keepers') : Null,
				'epi_lhws' => ($this -> input -> post ('epi_lhws'))? $this -> input -> post ('epi_lhws') : Null,
				'epi_dsv' => ($this -> input -> post ('epi_dsv'))? $this -> input -> post ('epi_dsv') : Null,
				'epi_technicians_cc' => ($this -> input -> post ('epi_technicians_cc'))? $this -> input -> post ('epi_technicians_cc') : Null,
				'epi_asv' => ($this -> input -> post ('epi_asv'))? $this -> input -> post ('epi_asv') : Null,
				'epi_others' => ($this -> input -> post ('epi_others'))? $this -> input -> post ('epi_others') : Null,
				'trained_vaccinators' => ($this -> input -> post ('trained_vaccinators'))? $this -> input -> post ('trained_vaccinators') : Null,
				'trained_lhvs' => ($this -> input -> post ('trained_lhvs'))? $this -> input -> post ('trained_lhvs') : Null,
				'trained_dispensers' => ($this -> input -> post ('trained_dispensers'))? $this -> input -> post ('trained_dispensers') : Null,
				'trained_lhss' => ($this -> input -> post ('trained_lhss'))? $this -> input -> post ('trained_lhss') : Null,
				'trained_store_keepers' => ($this -> input -> post ('trained_store_keepers'))? $this -> input -> post ('trained_store_keepers') : Null,
				'trained_lhws' => ($this -> input -> post ('trained_lhws'))? $this -> input -> post ('trained_lhws') : Null,
				'trained_dsv' => ($this -> input -> post ('trained_dsv'))? $this -> input -> post ('trained_dsv') : Null,
				'trained_technician_cc' => ($this -> input -> post ('trained_technician_cc'))? $this -> input -> post ('trained_technician_cc') : Null,
				'trained_asv' => ($this -> input -> post ('trained_asv'))? $this -> input -> post ('trained_asv') : Null,
				'trained_others' => ($this -> input -> post ('trained_others'))? $this -> input -> post ('trained_others') : Null,
				'reserve_stock' => ($this -> input -> post ('reserve_stock'))? $this -> input -> post ('reserve_stock') : Null,
				'routine_immune_req' => ($this -> input -> post ('routine_immune_req'))? $this -> input -> post ('routine_immune_req') : Null,
				'snid_req' => ($this -> input -> post ('snid_req'))? $this -> input -> post ('snid_req') : Null,
				'distance_vss' => ($this -> input -> post ('distance_vss'))? $this -> input -> post ('distance_vss') : Null,
				'mode_vacc_supply' => ($this -> input -> post ('mode_vacc_supply'))? $this -> input -> post ('mode_vacc_supply') : Null,
				'waste_disposal' => $waste_disposal_list,
				'solar_energy' => $solar_energy_list,
				'stock_out_3_months' => ($this -> input -> post ('stock_out_3_months'))? $this -> input -> post ('stock_out_3_months') : Null,
				'grid_elec_available' => ($this -> input -> post ('grid_elec_available'))? $this -> input -> post ('grid_elec_available') : Null,
				'pr_name' => ($this -> input -> post ('pr_name'))? $this -> input -> post ('pr_name') : Null,
				'cctl_name' => ($this -> input -> post ('cctl_name'))? $this -> input -> post ('cctl_name') : Null,
				'pr_desg' => ($this -> input -> post ('pr_desg'))? $this -> input -> post ('pr_desg') : Null,
				'cctl_desg' => ($this -> input -> post ('cctl_desg'))? $this -> input -> post ('cctl_desg') : Null,
				'pr_mob' => ($this -> input -> post ('pr_mob'))? $this -> input -> post ('pr_mob') : Null,
				'cctl_mob' => ($this -> input -> post ('cctl_mob'))? $this -> input -> post ('cctl_mob') : Null,
				'pr_email' => ($this -> input -> post ('pr_email'))? $this -> input -> post ('pr_email') : Null,
				'cctl_email' => ($this -> input -> post ('cctl_email'))? $this -> input -> post ('cctl_email') : Null,
				'pr_date' => ($this -> input -> post ('pr_date'))? date('Y-m-d', strtotime($this ->input -> post ('pr_date'))) : Null,
				'cctl_date' => ($this -> input -> post ('cctl_date'))? date('Y-m-d', strtotime($this ->input -> post ('cctl_date'))) : Null,
				'dc_name' => ($this -> input -> post ('dc_name'))? $this -> input -> post ('dc_name') : Null,
				'dc_desg' => ($this -> input -> post ('dc_desg'))? $this -> input -> post ('dc_desg') : Null,
				'dc_email' => ($this -> input -> post ('dc_email'))? $this -> input -> post ('dc_email') : Null,
				'dc_mob' => ($this -> input -> post ('dc_mob'))? $this -> input -> post ('dc_mob') : Null,
				'date_submitted' => ($this -> input -> post ('date_submitted'))? date('Y-m-d', strtotime($this ->input -> post ('date_submitted'))) : Null,
				'dc_date' => ($this -> input -> post ('dc_date'))? date('Y-m-d', strtotime($this ->input -> post ('dc_date'))) : Null
			);
			//echo '<pre>';print_r($rhfqpData);echo '</pre>';exit();
			$data = $this -> Coldchain_model -> rev_health_facility_questionnaire_pak_save($rhfqpData);
		
	}
	
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Questionnaire Record Starts Here ===============//
	public function rev_health_facility_questionnaire_pak_edit() {
		//dataEntryValidator();
		$qcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> rev_health_facility_questionnaire_pak_edit($qcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/rev_health_facility_questionnaire_pak';
			$data['pageTitle'] = 'EPI-MIS | Health Facility Questionnaire Update Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	//================ Function to Show Page for Editing Existing Questionnaire Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Questionnaire Record Starts Here ==============//
	public function rev_health_facility_questionnaire_pak_view() {
		$code = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> rev_health_facility_questionnaire_pak_view($code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/rev_health_facility_questionnaire_pak_view';
			$data['pageTitle'] = 'EPI-MIS | Health Facility Questionnaire Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================================================================================================//
	//================================================================================================//
	//============================Refrigerator_questionnaire Function=================================//
	public function refrigerator_questionnaire(){
		
		//dataEntryValidator();
		//echo 'here';exit;
		$data = $this -> Coldchain_model -> refrigerator_questionnaire();
		$data['edit']="Yes";
		$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/refrigerator_questionnaire';
			$data['pageTitle']='Refrigerator Questionnaire | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
		//================refrigerator_questionnaire Save Function===============///
	public function refrigerator_questionnaire_save(){
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
		$equip_not_working_reason = $this->input->post('equip_not_working_reason') ? $this->input->post('equip_not_working_reason')  : NULL; 
		if($equip_not_working_reason!=''){
				
				foreach($equip_not_working_reason as $row){
					$new1[] = $row;
				}
				$equip_not_working_reason_list=implode(',',$new1);
			}
		$temp_monitored = $this->input->post('temp_monitored') ? $this->input->post('temp_monitored')  : NULL;
		if($temp_monitored!=''){
				
				foreach($temp_monitored as $row){
					$new2[] = $row;
				}
				$temp_monitored_list=implode(',',$new2);
			}
				$equip_1 = ($this -> input -> post ('equip_1'))? $this -> input -> post ('equip_1') : Null;
				$equip_2 = ($this -> input -> post ('equip_2'))? $this -> input -> post ('equip_2') : Null;
				$equip_3 = ($this -> input -> post ('equip_3'))? $this -> input -> post ('equip_3') : Null;
				$equip_4 = ($this -> input -> post ('equip_4'))? $this -> input -> post ('equip_4') : Null;
				$equip_code = '3-'.$equip_1.'-'.$equip_2.'-'.$equip_3.'-'.$equip_4;
				$equip_found= ($this -> input -> post ('equip_found'))? $this -> input -> post ('equip_found') : Null;
				
				if($equip_found=='No'){
					$model_name = ($this -> input -> post ('model_name'))? $this -> input -> post ('model_name') : Null;
					$manufacturer = ($this -> input -> post ('manufacturer'))? $this -> input -> post ('manufacturer') : Null;
					$cfc_sticker = ($this -> input -> post ('cfc_sticker'))? $this -> input -> post ('cfc_sticker') : Null;
					$refrigerator_type = ($this -> input -> post ('refrigerator_type'))? $this -> input -> post ('refrigerator_type') : Null;
					$plus_length = ($this -> input -> post ('plus_length'))? $this -> input -> post ('plus_length') : Null;
					$plus_width = ($this -> input -> post ('plus_width'))? $this -> input -> post ('plus_width') : Null;
					$plus_height = ($this -> input -> post ('plus_height'))? $this -> input -> post ('plus_height') : Null;
					$minus_length = ($this -> input -> post ('minus_length'))? $this -> input -> post ('minus_length') : Null;
					$minus_width = ($this -> input -> post ('minus_width'))? $this -> input -> post ('minus_width') : Null;
					$minus_height  =  ($this -> input -> post ('minus_height'))? $this -> input -> post ('minus_height') : Null;
				}
				else{
					$model_name =Null;
					$manufacturer =Null;
					$cfc_sticker =Null;
					$refrigerator_type =Null;
					$plus_length =Null;
					$plus_width =Null;
					$plus_height =Null;
					$minus_length =Null;
					$minus_width = Null;
					$minus_height  = Null;
				}
if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}
				
		$refData = array(
				'procode' => ($this -> session -> Province)? $this -> session -> Province : $this -> session -> Province,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
				'year' => ($this -> input -> post ('year'))? $this -> input -> post ('year') : Null,
				'quarter' => ($this -> input -> post ('quarter'))? $this -> input -> post ('quarter') : Null,
				'fquarter' => isset($fquarter)?$fquarter: NULL,
				'equip_rec' => ($this -> input -> post ('equip_rec'))? $this -> input -> post ('equip_rec') : Null,
				'rec_of' => ($this -> input -> post ('rec_of'))? $this -> input -> post ('rec_of') : Null,
				'equip_code' => $equip_code,
				'catalogue_id' => ($this -> input -> post ('catalogue_id'))? $this -> input -> post ('catalogue_id') : Null,
				'serial_number' => ($this -> input -> post ('serial_number'))? $this -> input -> post ('serial_number') : Null,
				'equip_not_working_reason' => $equip_not_working_reason_list,
				'temp_monitored' => $temp_monitored_list,
				'equip_found' => $equip_found,
				'year_first_use' => ($this -> input -> post ('year_first_use'))? $this -> input -> post ('year_first_use') : Null,
				'working_status' => ($this -> input -> post ('working_status'))? $this -> input -> post ('working_status') : Null,
				'equip_utilisation' => ($this -> input -> post ('equip_utilisation'))? $this -> input -> post ('equip_utilisation') : Null,
				'no_temp_alarms_above' => ($this -> input -> post ('no_temp_alarms_above'))? $this -> input -> post ('no_temp_alarms_above') : Null,
				'no_temp_alarms_below' => ($this -> input -> post ('no_temp_alarms_below'))? $this -> input -> post ('no_temp_alarms_below') : Null,
			
				'model_name' => $model_name,
				'manufacturer' => $manufacturer,
				'cfc_sticker' => $cfc_sticker,
				'refrigerator_type' => $refrigerator_type,
				'plus_length' => $plus_length,
				'plus_width' => $plus_width,
				'plus_height' => $plus_height,
				'minus_length' => $minus_length,
				'minus_width' => $minus_width,
				'minus_height' =>$minus_height,
				
				
				'plus_gross' => ($this -> input -> post ('plus_gross'))? $this -> input -> post ('plus_gross') : Null,
				'plus_net' => ($this -> input -> post ('plus_net'))? $this -> input -> post ('plus_net') : Null,
				'minus_gross' => ($this -> input -> post ('minus_gross'))? $this -> input -> post ('minus_gross') : Null,
				'minus_net' => ($this -> input -> post ('minus_net'))? $this -> input -> post ('minus_net') : Null,
				'pr_name' => ($this -> input -> post ('pr_name'))? $this -> input -> post ('pr_name') : Null,
				'pr_desg' => ($this -> input -> post ('pr_desg'))? $this -> input -> post ('pr_desg') : Null,
				'pr_mob' => ($this -> input -> post ('pr_mob'))? $this -> input -> post ('pr_mob') : Null,
				'pr_email' => ($this -> input -> post ('pr_email'))? $this -> input -> post ('pr_email') : Null,
				'cctl_name' => ($this -> input -> post ('cctl_name'))? $this -> input -> post ('cctl_name') : Null,
				'cctl_mob' => ($this -> input -> post ('cctl_mob'))? $this -> input -> post ('cctl_mob') : Null,
				'cctl_date' => ($this -> input -> post ('cctl_date'))? date('Y-m-d', strtotime($this ->input -> post ('cctl_date'))) : Null,
				'dc_name' => ($this -> input -> post ('dc_name'))? $this -> input -> post ('dc_name') : Null,
				'dc_desg' => ($this -> input -> post ('dc_desg'))? $this -> input -> post ('dc_desg') : Null,
				'dc_email' => ($this -> input -> post ('dc_email'))? $this -> input -> post ('dc_email') : Null,
				'dc_mob' => ($this -> input -> post ('dc_mob'))? $this -> input -> post ('dc_mob') : Null,
				'date_submitted' => ($this -> input -> post ('date_submitted'))? date('Y-m-d', strtotime($this ->input -> post ('date_submitted'))) : Null,
				'dc_date' => ($this -> input -> post ('dc_date'))? date('Y-m-d', strtotime($this ->input -> post ('dc_date'))) : Null
			);
			//echo '<pre>';print_r($refData);echo '</pre>';exit();
			$data = $this -> Coldchain_model -> refrigerator_questionnaire_save($refData);
		
	}
	
	//---------------------------------------------------------------------------------------------------------//
		//================Refrigerator_questionnaire_pak Lisitng Function===============///
	public function refrigerator_questionnaire_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_hf_questionnaire ";
		$data = $this -> Coldchain_model -> refrigerator_questionnaire_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/refrigerator_questionnaire_list';
			$data['pageTitle'] = 'EPI-MIS | List of Refrigerator Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Refrigerator Questionnaire Record Starts Here ===============//
	public function refrigerator_questionnaire_edit() {
		//dataEntryValidator();
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> refrigerator_questionnaire_edit($rcode);
		$quarterOp='<option value="">Select</option>';
		$val=$data['quarter'][0]['quarter'];
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsQ']=$quarterOp;
		
		$yearOp='<option value="">Select</option>';
		$val=$data['year'][0]['year'];
		//print_r($val);exit;
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/refrigerator_questionnaire';
			$data['pageTitle'] = 'EPI-MIS | Refrigerator Questionnaire Update Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	//================ Function to Show Page for Editing Existing Refrigerator Questionnaire Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Refrigerator Questionnaire Record Starts Here ==============//
	public function refrigerator_questionnaire_view() {
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> refrigerator_questionnaire_view($rcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/refrigerator_questionnaire_view';
			$data['pageTitle'] = 'EPI-MIS | Refrigerator Questionnaire Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//====================================================================================//
	//====================================================================================//
	//======================= Cold Room Questionnaire Function =========================///
	public function coldroom_questionnaire(){
		
		//dataEntryValidator();
		//echo 'here';exit;
		$data = $this -> Coldchain_model -> coldroom_questionnaire();
		$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/coldroom_questionnaire';
			$data['pageTitle']='Cold Room Questionnaire | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================Cold Room Questionnaire Lisitng Function===============///
	public function coldroom_questionnaire_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_coldroom_questionnaire";
		$data = $this -> Coldchain_model -> coldroom_questionnaire_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/coldroom_questionnaire_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Room Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================Cold Room Questionnaire Save Function===============///
	public function coldroom_questionnaire_save(){
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
		$type_record_system =$this -> input -> post('type_record_system') ;
		if($type_record_system!=''){

			foreach($type_record_system as $row){
				$new1[] = $row;
			}
			
			         $type_record_system_list=implode(',',$new1);
					
		}
		
			$equip_1 = ($this -> input -> post ('equip_1'))? $this -> input -> post ('equip_1') : Null;
			$equip_2 = ($this -> input -> post ('equip_2'))? $this -> input -> post ('equip_2') : Null;
			$equip_3 = ($this -> input -> post ('equip_3'))? $this -> input -> post ('equip_3') : Null;
			$equip_4 = ($this -> input -> post ('equip_4'))? $this -> input -> post ('equip_4') : Null;
			$equip_code = '3-'.$equip_1.'-'.$equip_2.'-'.$equip_3.'-'.$equip_4;
			if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}		
		$refData = array(
				'procode' => ($this -> session -> Province)? $this -> session -> Province : $this -> session -> Province,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
				'year' => ($this -> input -> post ('year'))? $this -> input -> post ('year') : Null,
				'quarter' => ($this -> input -> post ('quarter'))? $this -> input -> post ('quarter') : Null,
				'fquarter' => isset($fquarter)?$fquarter: NULL,
				'equip_rec' => ($this -> input -> post ('equip_rec'))? $this -> input -> post ('equip_rec') : Null,
				'rec_of' => ($this -> input -> post ('rec_of'))? $this -> input -> post ('rec_of') : Null,
				'equip_code' => $equip_code,
				'type_room' => ($this -> input -> post ('type_room'))? $this -> input -> post ('type_room') : Null,
				'model' => ($this -> input -> post ('model'))? $this -> input -> post ('model') : Null,							
				'manufacturer' => ($this -> input -> post ('manufacturer'))? $this -> input -> post ('manufacturer') : Null,
				'year_supply' => ($this -> input -> post ('year_supply'))? $this -> input -> post ('year_supply') : Null,
				'working_status' => ($this -> input -> post ('working_status'))? $this -> input -> post ('working_status') : Null,
				'no_phases' => ($this -> input -> post ('no_phases'))? $this -> input -> post ('no_phases') : Null,
				'voltage_stabilizer' => ($this -> input -> post ('voltage_stabilizer'))? $this -> input -> post ('voltage_stabilizer') : Null,			
				'temp_record_system' => ($this -> input -> post ('temp_record_system'))? $this -> input -> post ('temp_record_system') : Null,
				'type_record_system' => $type_record_system_list,
				'plus_length' => ($this -> input -> post ('plus_length'))? $this -> input -> post ('plus_length') : Null,
				'plus_width' => ($this -> input -> post ('plus_width'))? $this -> input -> post ('plus_width') : Null,
				'plus_height' => ($this -> input -> post ('plus_height'))? $this -> input -> post ('plus_height') : Null,
				'minus_length' => ($this -> input -> post ('minus_length'))? $this -> input -> post ('minus_length') : Null,
				'minus_width' => ($this -> input -> post ('minus_width'))? $this -> input -> post ('minus_width') : Null,
				'minus_height' => ($this -> input -> post ('minus_height'))? $this -> input -> post ('minus_height') : Null,
				'plus_gross_volume' => ($this -> input -> post ('plus_gross_volume'))? $this -> input -> post ('plus_gross_volume') : Null,
				'minus_gross_volume' => ($this -> input -> post ('minus_gross_volume'))? $this -> input -> post ('minus_gross_volume') : Null,
				'plus_net_volume' => ($this -> input -> post ('plus_net_volume'))? $this -> input -> post ('plus_net_volume') : Null,
				'minus_net_volume' => ($this -> input -> post ('minus_net_volume'))? $this -> input -> post ('minus_net_volume') : Null,
				'no_cooling_systems' => ($this -> input -> post ('no_cooling_systems'))? $this -> input -> post ('no_cooling_systems') : Null,
				'refrigerant_gas_type' => ($this -> input -> post ('refrigerant_gas_type'))? $this -> input -> post ('refrigerant_gas_type') : Null,
				'backup_generator' => ($this -> input -> post ('backup_generator'))? $this -> input -> post ('backup_generator') : Null,			
				'cctl_name' => ($this -> input -> post ('cctl_name'))? $this -> input -> post ('cctl_name') : Null,
				'cctl_desg' => ($this -> input -> post ('cctl_desg'))? $this -> input -> post ('cctl_desg') : Null,
				'cctl_mob' => ($this -> input -> post ('cctl_mob'))? $this -> input -> post ('cctl_mob') : Null,
				'cctl_email' => ($this -> input -> post ('cctl_email'))? $this -> input -> post ('cctl_email') : Null,
				'cctl_date' => ($this -> input -> post ('cctl_date'))? date('Y-m-d', strtotime($this ->input -> post ('cctl_date'))) : Null,
				'dc_name' => ($this -> input -> post ('dc_name'))? $this -> input -> post ('dc_name') : Null,
				'dc_desg' => ($this -> input -> post ('dc_desg'))? $this -> input -> post ('dc_desg') : Null,				
				'dc_mob' => ($this -> input -> post ('dc_mob'))? $this -> input -> post ('dc_mob') : Null,
				'dc_email' => ($this -> input -> post ('dc_email'))? $this -> input -> post ('dc_email') : Null,
				'dc_date' => ($this -> input -> post ('dc_date'))? date('Y-m-d', strtotime($this ->input -> post ('dc_date'))) : Null,
				'date_submitted' => ($this -> input -> post ('date_submitted'))? date('Y-m-d', strtotime($this ->input -> post ('date_submitted'))) : Null
				
			);
			//echo '<pre>';print_r($refData);echo '</pre>';exit();
			$data = $this -> Coldchain_model -> coldroom_questionnaire_save($refData);		
	}	

	//================ Function to Show Page for Viewing Existing Cold Room Questionnaire Record Starts Here ==============//
	public function coldroom_questionnaire_view() {
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> coldroom_questionnaire_view($rcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/coldroom_questionnaire_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Room Questionnaire Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================ Function to Show Page for Editing Existing Cold Room Questionnaire Record Starts Here ===============//
	public function coldroom_questionnaire_edit() {
		//dataEntryValidator();
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> coldroom_questionnaire_edit($rcode);
		$quarterOp='<option value="">Select</option>';
		$val=$data['rdata']['quarter'];
		
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsQ']=$quarterOp;
		
		$yearOp='<option value="">Select</option>';
		$val=$data['rdata']['year'];
		//print_r($val);exit;
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/coldroom_questionnaire';
			$data['pageTitle'] = 'EPI-MIS | Cold Room Questionnaire Update Form';
			$data['edit']='1';
			
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}		
	}
	//======================================================================================================//
	//======================================================================================================//
	//======================= Voltage Regulator/Stabilizers Questionnaire Function =========================//
	public function voltage_questionnaire(){
		
		//dataEntryValidator();
		//echo 'here';exit;
		$data = $this -> Coldchain_model -> voltage_questionnaire();
		$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/voltage_questionnaire';
			$data['pageTitle']='Voltage Regulators/Stabilizers Questionnaire | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================ Voltage Regulator/Stabilizers Questionnaire Lisitng Function===============///
	public function voltage_questionnaire_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_voltage_questionnaire";
		$data = $this -> Coldchain_model -> voltage_questionnaire_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/voltage_questionnaire_list';
			$data['pageTitle'] = 'EPI-MIS | List of Voltage Regulators/Stabilizers Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================Voltage Regulator/Stabilizers Questionnaire Save Function===============///
	public function voltage_questionnaire_save(){
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
				
			$equip_1 = ($this -> input -> post ('equip_1'))? $this -> input -> post ('equip_1') : Null;
			$equip_2 = ($this -> input -> post ('equip_2'))? $this -> input -> post ('equip_2') : Null;
			$equip_3 = ($this -> input -> post ('equip_3'))? $this -> input -> post ('equip_3') : Null;
			$equip_4 = ($this -> input -> post ('equip_4'))? $this -> input -> post ('equip_4') : Null;
			$equip_code = '3-'.$equip_1.'-'.$equip_2.'-'.$equip_3.'-'.$equip_4;
				if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}
		$refData = array(
				'procode' => ($this -> session -> Province)? $this -> session -> Province : $this -> session -> Province,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
'year' => ($this -> input -> post ('year'))? $this -> input -> post ('year') : Null,
				'quarter' => ($this -> input -> post ('quarter'))? $this -> input -> post ('quarter') : Null,
				'fquarter' => isset($fquarter)?$fquarter: NULL,
				'equip_rec' => ($this -> input -> post ('equip_rec'))? $this -> input -> post ('equip_rec') : Null,
				'rec_of' => ($this -> input -> post ('rec_of'))? $this -> input -> post ('rec_of') : Null,
				'equip_code' => $equip_code,
				'catalogue_id' => ($this -> input -> post ('catalogue_id'))? $this -> input -> post ('catalogue_id') : Null,
				'manufacturer' => ($this -> input -> post ('manufacturer'))? $this -> input -> post ('manufacturer') : Null,
				'model' => ($this -> input -> post ('model'))? $this -> input -> post ('model') : Null,
				'quantity_present' => ($this -> input -> post ('quantity_present'))? $this -> input -> post ('quantity_present') : Null,
				'quantity_not_working' => ($this -> input -> post ('quantity_not_working'))? $this -> input -> post ('quantity_not_working') : Null,
				'pr_name' => ($this -> input -> post ('pr_name'))? $this -> input -> post ('pr_name') : Null,
				'pr_desg' => ($this -> input -> post ('pr_desg'))? $this -> input -> post ('pr_desg') : Null,
				'pr_mob' => ($this -> input -> post ('pr_mob'))? $this -> input -> post ('pr_mob') : Null,
				'pr_email' => ($this -> input -> post ('pr_email'))? $this -> input -> post ('pr_email') : Null,								
				'cctl_name' => ($this -> input -> post ('cctl_name'))? $this -> input -> post ('cctl_name') : Null,
				'cctl_desg' => ($this -> input -> post ('cctl_desg'))? $this -> input -> post ('cctl_desg') : Null,
				'cctl_mob' => ($this -> input -> post ('cctl_mob'))? $this -> input -> post ('cctl_mob') : Null,
				'cctl_email' => ($this -> input -> post ('cctl_email'))? $this -> input -> post ('cctl_email') : Null,				
				'dc_name' => ($this -> input -> post ('dc_name'))? $this -> input -> post ('dc_name') : Null,
				'dc_desg' => ($this -> input -> post ('dc_desg'))? $this -> input -> post ('dc_desg') : Null,				
				'dc_mob' => ($this -> input -> post ('dc_mob'))? $this -> input -> post ('dc_mob') : Null,
				'dc_email' => ($this -> input -> post ('dc_email'))? $this -> input -> post ('dc_email') : Null,
				'dc_date' => ($this -> input -> post ('dc_date'))? date('Y-m-d', strtotime($this ->input -> post ('dc_date'))) : Null,
				'date_submitted' => ($this -> input -> post ('date_submitted'))? date('Y-m-d', strtotime($this ->input -> post ('date_submitted'))) : Null
				
			);
			//echo '<pre>';print_r($refData);echo '</pre>';exit();
			$data = $this -> Coldchain_model -> voltage_questionnaire_save($refData);		
	}

	//================ Function to Show Page for Viewing Existing Voltage Regulator/Stabilizers Questionnaire Record Starts Here ==============//
	public function voltage_questionnaire_view() {
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> voltage_questionnaire_view($rcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/voltage_questionnaire_view';
			$data['pageTitle'] = 'EPI-MIS | Voltage Regulator/Stabilizers Questionnaire Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================ Function to Show Page for Editing Existing Voltage Regulator/Stabilizers Questionnaire Record Starts Here ===============//
	public function voltage_questionnaire_edit() {
		//dataEntryValidator();
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> voltage_questionnaire_edit($rcode);
		//print_r($data);exit;
		$quarterOp='<option value="">Select</option>';
		$val=$data['vdata']['quarter'];
		
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsQ']=$quarterOp;
		
		$yearOp='<option value="">Select</option>';
		$val=$data['vdata']['year'];
		//print_r($val);exit;
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/voltage_questionnaire';
			$data['pageTitle'] = 'EPI-MIS | Voltage Regulator/Stabilizers Questionnaire Update Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}		
	}
	//===================================================================================================//
	//===================================================================================================//
	//============================== Generators Questionnaire Function =================================///
	public function generator_questionnaire(){
		
		//dataEntryValidator();
		//echo 'here';exit;
		$data = $this -> Coldchain_model -> generator_questionnaire();
$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/generator_questionnaire';
			$data['pageTitle']='Generators Questionnaire | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//=================================== Generators Questionnaire Lisitng Function=======================///
	public function generator_questionnaire_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_generator_questionnaire";
		$data = $this -> Coldchain_model -> generator_questionnaire_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/generator_questionnaire_list';
			$data['pageTitle'] = 'EPI-MIS | List of Generators Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//============================Generators Questionnaire Save Function===================================///
	public function generator_questionnaire_save(){
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
		$used_for = ($this->input->post('used_for') )? $this -> input -> post('used_for')  : NULL; 
		if($used_for!=''){

			foreach($used_for as $row){
				$new1[] = $row;
			}
			$used_for=implode(',',$new1);
		}
		
			$equip_1 = ($this -> input -> post ('equip_1'))? $this -> input -> post ('equip_1') : Null;
			$equip_2 = ($this -> input -> post ('equip_2'))? $this -> input -> post ('equip_2') : Null;
			$equip_3 = ($this -> input -> post ('equip_3'))? $this -> input -> post ('equip_3') : Null;
			$equip_4 = ($this -> input -> post ('equip_4'))? $this -> input -> post ('equip_4') : Null;
			$equip_code = '3-'.$equip_1.'-'.$equip_2.'-'.$equip_3.'-'.$equip_4;
if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}
				
		$refData = array(
				'procode' => ($this -> session -> Province)? $this -> session -> Province : $this -> session -> Province,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'uncode' => ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null,
'year' => ($this -> input -> post ('year'))? $this -> input -> post ('year') : Null,
				'quarter' => ($this -> input -> post ('quarter'))? $this -> input -> post ('quarter') : Null,
				'fquarter' => isset($fquarter)?$fquarter: NULL,
				
				'equip_rec' => ($this -> input -> post ('equip_rec'))? $this -> input -> post ('equip_rec') : Null,
				'rec_of' => ($this -> input -> post ('rec_of'))? $this -> input -> post ('rec_of') : Null,
				'equip_code' => $equip_code,				
				'model' => ($this -> input -> post ('model'))? $this -> input -> post ('model') : Null,							
				'manufacturer' => ($this -> input -> post ('manufacturer'))? $this -> input -> post ('manufacturer') : Null,
				'serial_number' => ($this -> input -> post ('serial_number'))? $this -> input -> post ('serial_number') : Null,
				'no_phases' => ($this -> input -> post ('no_phases'))? $this -> input -> post ('no_phases') : Null,
				'power_rating' => ($this -> input -> post ('power_rating'))? $this -> input -> post ('power_rating') : Null,			
				'power_source' => ($this -> input -> post ('power_source'))? $this -> input -> post ('power_source') : Null,
				'auto_start_mechanism' => ($this -> input -> post ('auto_start_mechanism'))? $this -> input -> post ('auto_start_mechanism') : Null,
				'used_for' => $used_for,
				'year_supply' => ($this -> input -> post ('year_supply'))? $this -> input -> post ('year_supply') : Null,
				'source_supply' => ($this -> input -> post ('source_supply'))? $this -> input -> post ('source_supply') : Null,
				'working_status' => ($this -> input -> post ('working_status'))? $this -> input -> post ('working_status') : Null,				
				'equip_utilization' => ($this -> input -> post ('equip_utilization'))? $this -> input -> post ('equip_utilization') : Null,				
				'pr_name' => ($this -> input -> post ('pr_name'))? $this -> input -> post ('pr_name') : Null,
				'pr_desg' => ($this -> input -> post ('pr_desg'))? $this -> input -> post ('pr_desg') : Null,
				'pr_mob' => ($this -> input -> post ('pr_mob'))? $this -> input -> post ('pr_mob') : Null,
				'pr_email' => ($this -> input -> post ('pr_email'))? $this -> input -> post ('pr_email') : Null,								
				'cctl_name' => ($this -> input -> post ('cctl_name'))? $this -> input -> post ('cctl_name') : Null,
				'cctl_desg' => ($this -> input -> post ('cctl_desg'))? $this -> input -> post ('cctl_desg') : Null,
				'cctl_mob' => ($this -> input -> post ('cctl_mob'))? $this -> input -> post ('cctl_mob') : Null,
				'cctl_email' => ($this -> input -> post ('cctl_email'))? $this -> input -> post ('cctl_email') : Null,				
				'dc_name' => ($this -> input -> post ('dc_name'))? $this -> input -> post ('dc_name') : Null,
				'dc_desg' => ($this -> input -> post ('dc_desg'))? $this -> input -> post ('dc_desg') : Null,				
				'dc_mob' => ($this -> input -> post ('dc_mob'))? $this -> input -> post ('dc_mob') : Null,
				'dc_email' => ($this -> input -> post ('dc_email'))? $this -> input -> post ('dc_email') : Null,
				'dc_date' => ($this -> input -> post ('dc_date'))? date('Y-m-d', strtotime($this ->input -> post ('dc_date'))) : Null,
				'date_submitted' => ($this -> input -> post ('date_submitted'))? date('Y-m-d', strtotime($this ->input -> post ('date_submitted'))) : Null
				
			);
			//echo '<pre>';print_r($refData);echo '</pre>';exit();
			$data = $this -> Coldchain_model -> generator_questionnaire_save($refData);		
	}
	//================ Function to Show Page for Viewing Existing Generators Questionnaire Record Starts Here ==============//
	public function generator_questionnaire_view() {
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> generator_questionnaire_view($rcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/generator_questionnaire_view';
			$data['pageTitle'] = 'EPI-MIS | Generators Questionnaire Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	//================ Function to Show Page for Editing Existing Generators Questionnaire Record Starts Here ===============//
	public function generator_questionnaire_edit() {
		//dataEntryValidator();
		$rcode = $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> generator_questionnaire_edit($rcode);
		//print_r($data);exit;
		$quarterOp='<option value="">Select</option>';
		$val=$data['gdata']['quarter'];
		
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsQ']=$quarterOp;
		
		$yearOp='<option value="">Select</option>';
		$val=$data['gdata']['year'];
		//print_r($val);exit;
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;

		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/generator_questionnaire';
			$data['pageTitle'] = 'EPI-MIS | Generators Questionnaire Update Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}		
	}
	//================================================================================================================//
	//================================================================================================================//		
	//============================== Generators Questionnaire Function ===============================================//
	public function transport_questionnaire(){
		$data['fileToLoad'] = 'coldchain/transport_questionnaire';
$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		$data['pageTitle']='Transport Questionnaire | EPI-MIS';
		$data['data']=$data;
		$this->load->view('template/epi_template',$data);
	}
	public function transport_questionnaire_save(){
		$id=0;
		if($this -> input -> post('edit')){
			$id = $this -> input -> post('id');
		}
if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$removeKeys = array('model', 'make','transport_type','year_manufacture','tot_number','not_working','reasons_not_working','percentage_used','fuel_type');
		foreach($removeKeys as $key) {
		   unset($dataPosted[$key]);
		}
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
		}
		$data["procode"] = $this -> session -> Province;
$data["year"]=$this->input->post('year');
		$data["quarter"]=$this->input->post('quarter');
		$data["fquarter"]=$fquarter;
		$data["date_submitted"]=date("Y-m-d");
		unset($data['edit']);
		if($id>0)
		{
			$data = $this -> Common_model -> update_record("transport_questionnaire_main",$data,array("id" => $id));
			$this -> Common_model -> delete_record("transport_questionnaire_cols",$id,"main_id");
			$this -> session -> set_flashdata('message','Record Updated Successfully!');
		}else
		{
			$id = $this -> Common_model -> insert_record("transport_questionnaire_main",$data);
			$this -> session -> set_flashdata('message','Record Inserted Successfully!');			
		}
		foreach($_POST['transport_type'] as $s_key => $s_val)
		{
			if(!empty($_POST['transport_type'][$s_key])){
				$detail[] = array(
					'model' => $_POST['model'][$s_key],
					'make' => $_POST['make'][$s_key],
					'transport_type' => $_POST['transport_type'][$s_key],
					'year_manufacture' => $_POST['year_manufacture'][$s_key],
					'tot_number' => $_POST['tot_number'][$s_key],
					'not_working' => $_POST['not_working'][$s_key],
					'reasons_not_working' => $_POST['reasons_not_working'][$s_key],
					'percentage_used' => ($this -> input -> post("percentage_used[$s_key]"))?$this -> input -> post("percentage_used[$s_key]"):NULL,
					'fuel_type' => $_POST['fuel_type'][$s_key],
					'main_id' => $id
				);
			}
		}
		$this -> Common_model -> insert_batch_record("transport_questionnaire_cols",$detail);
		$location = base_url(). "Transport-Questionnaire/List";
		redirect($location);
	}
	//=================================== Transport Questionnaire Lisitng Function=======================///
	public function transport_questionnaire_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "transport_questionnaire_main";
		$data = $this -> Coldchain_model -> transport_questionnaire_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/transport_questionnaire_list';
			$data['pageTitle'] = 'EPI-MIS | List of Transport Questionnaires';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Transport Questionnaire Record Starts Here ===============//
	public function transport_questionnaire_edit() {
		//dataEntryValidator();
		$id = $this -> uri -> segment(3);
		$data["gdata"] = $this -> Common_model -> get_info("transport_questionnaire_main",$id,"id");  
		$data["gdataDetail"] = $this -> Common_model -> fetchall("transport_questionnaire_cols",'','',array('main_id' => $id));  
		$val=$data["gdata"]->year;
		$yearOp='<option value="">Select</option>';
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		$val=$data["gdata"]->quarter;
		$quarterOp='<option value="">Select</option>';
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		
		}
		$data['optionsQ']=$quarterOp;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/transport_questionnaire';
			$data['pageTitle'] = 'EPI-MIS | Transport Questionnaire Update Form';
			$data['edit']='Yes';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}		
	}
	//================ Function to Show Page for Viewing Existing Transport Questionnaire Record Starts Here ===============//
	public function transport_questionnaire_view() {
		//dataEntryValidator();
		$id = $this -> uri -> segment(3);
		$data["gdata"] = $this -> Common_model -> get_info("transport_questionnaire_main",$id,"id");  
		$data["gdataDetail"] = $this -> Common_model -> fetchall("transport_questionnaire_cols",'','',array('main_id' => $id));  
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/transport_questionnaire_view';
			$data['pageTitle'] = 'EPI-MIS | Transport Questionnaire Update Form';
			$data['edit']='Yes';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}		
	}
	//================================================================================================================//	
	//==================Functions Start for Vaccine Carriers, Cold Boxes & Ice Packs=======================//
	public function vacc_carriers(){
		//echo "danish";exit;
		$data['optionsY']=$this->yearOption('year');
		$data['optionsQ']=$this->yearOption('quarter');
		$data['fileToLoad'] = 'coldchain/vacc_carriers_cold_box'; 
		$data['pageTitle']='Vaccine Carriers,Cold Box & Ice Packs | EPI-MIS';				
		$data['data']=$data;
		$this->load->view('template/epi_template',$data);	
	}
	//==================Functions Start for Vaccine Carriers, Cold Boxes & Ice Packs Save=======================//
	public function vacc_carriers_save(){
		//echo "danish";exit;
		$id=0;
		if($this -> input -> post('edit')){
			$id = $this -> input -> post('id');
		}
		if($this->input->post('year') && $this->input->post('quarter'))
				{
					$year = $this->input->post('year');
					$quarter = $this->input->post('quarter');
					$fquarter= $year."-".$quarter;
				}
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$removeKeys = array('catalogue_id', 'cb_vc','tot_vacc','quntt_not_working','dimension_length','dimension_width','dimension_height','eq_code_r1_f1','eq_code_r1_f2','eq_code_r1_f3','eq_code_r1_f4','eq_code_r1_f5');
		foreach($removeKeys as $key) {
		   unset($dataPosted[$key]);
		}
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
		}
		$data["procode"] = $this -> session -> Province;
		$data["year"]=$this->input->post('year');
		$data["quarter"]=$this->input->post('quarter');
		$data["fquarter"]=$fquarter;
		$data["date_submitted"]=date("Y-m-d");
		unset($data['edit']);
		//print_r($data);exit;
		if($id>0)
		{
			$data = $this -> Common_model -> update_record("vacc_carriers_main",$data,array("id" => $id));
			$this -> Common_model -> delete_record("vacc_carriers_cols",$id,"main_id");
			$this -> session -> set_flashdata('message','Record Updated Successfully!');
		}else
		{
			$id = $this -> Common_model -> insert_record("vacc_carriers_main",$data);
			$this -> session -> set_flashdata('message','Record Inserted Successfully!');			
		}
		$detail = array();
		foreach($_POST['catalogue_id'] as $s_key => $s_val)
		{
			if($_POST['catalogue_id'][$s_key] != ''){
				$detail[] = array(
					'catalogue_id' => isset($_POST['catalogue_id'][$s_key])?$_POST['catalogue_id'][$s_key]:NULL,
					'cb_vc' => isset($_POST['cb_vc'][$s_key])?$_POST['cb_vc'][$s_key]:NULL,
					'tot_vacc' => isset($_POST['tot_vacc'][$s_key])?$_POST['tot_vacc'][$s_key]:NULL,
					'quntt_not_working' => isset($_POST['quntt_not_working'][$s_key])?$_POST['quntt_not_working'][$s_key]:NULL,
					'dimension_length' => isset($_POST['dimension_length'][$s_key])?$_POST['dimension_length'][$s_key]:NULL,
					'dimension_width' => isset($_POST['dimension_width'][$s_key])?$_POST['dimension_width'][$s_key]:NULL,
					'dimension_height' => isset($_POST['dimension_height'][$s_key])?$_POST['dimension_height'][$s_key]:NULL,
					'eq_code_r1_f1' => isset($_POST['eq_code_r1_f1'][$s_key])?$_POST['eq_code_r1_f1'][$s_key]:NULL,
					'eq_code_r1_f2' => isset($_POST['eq_code_r1_f2'][$s_key])?$_POST['eq_code_r1_f2'][$s_key]:NULL,
					'eq_code_r1_f3' => isset($_POST['eq_code_r1_f3'][$s_key])?$_POST['eq_code_r1_f3'][$s_key]:NULL,
					'eq_code_r1_f4' => isset($_POST['eq_code_r1_f4'][$s_key])?$_POST['eq_code_r1_f4'][$s_key]:NULL,
					'eq_code_r1_f5' => isset($_POST['eq_code_r1_f5'][$s_key])?$_POST['eq_code_r1_f5'][$s_key]:NULL,
					'main_id' => $id
				);
			}
		}
		//print_r($detail);exit;
		if( ! empty($detail)){
			$this -> Common_model -> insert_batch_record("vacc_carriers_cols",$detail);
		}		
		$location = base_url(). "Vaccine-Carriers/List";
		redirect($location);
	}
	
	//===================================Lisitng Function for Vaccine Carriers, Cold Boxes & Ice Packs =======================///
	public function vacc_carriers_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "vacc_carriers_main";  
		$data = $this -> Coldchain_model -> vacc_carriers_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/vacc_carriers_cold_box_list';
			$data['pageTitle'] = 'EPI-MIS | List of Vaccine Carriers,Cold Box & Ice Packs';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Transport Questionnaire Record Starts Here ===============//
	public function vacc_carriers_edit() {
		//dataEntryValidator();
		$id = $this -> uri -> segment(3);
		$data["gdata"] = $this -> Common_model -> get_info("vacc_carriers_main",$id,"id");  
		$data["gdataDetail"] = $this -> Common_model -> fetchall("vacc_carriers_cols",'','',array('main_id' => $id));  
		$val=$data["gdata"]->year;
		$yearOp='<option value="">Select</option>';
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		$val=$data["gdata"]->quarter;
		$quarterOp='<option value="">Select</option>';
		for($i=1;$i<5;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$quarterOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		
		}
		$data['optionsQ']=$quarterOp;
		
		//print_r($data["gdata"]->year);exit;
		
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/vacc_carriers_cold_box';
			$data['pageTitle'] = 'EPI-MIS | Vaccine Carriers,Cold Box & Ice Packs Update Form';
			$data['edit']='Yes';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Transport Questionnaire Record Starts Here ===============//
	public function vacc_carriers_view() {
		//dataEntryValidator();
		$id = $this -> uri -> segment(3);
		$data["gdata"] = $this -> Common_model -> get_info("vacc_carriers_main",$id,"id");  
		$data["gdataDetail"] = $this -> Common_model -> fetchall("vacc_carriers_cols",'','',array('main_id' => $id));  
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/vacc_carriers_cold_box_view';
			$data['pageTitle'] = 'EPI-MIS | Vaccine Carriers,Cold Box & Ice Packs View Form';
			$data['edit']='Yes';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}

	public function yearOption($option){
		if($option=='year'){
			$yearOp='<option value="">Select</option>';
			for($i=2016;$i<2019;$i++)
			{
				$yearOp.='<option value="'.$i.'">'.$i.'</option>';
			}
			return $yearOp;
		}
		else
		{
			$quarterOp='<option value="">Select</option>';
			for($i=1;$i<5;$i++)
			{
				$quarterOp.='<option value="'.$i.'">'.$i.'</option>';
			}
			return $quarterOp;
		}
	}
	public function coldchain_main()
	{
		$dat = array();
		$data['data'] = $dat;
		//only warehouses for that district can be selected whose deo is logged in
	    $distcode = $this->session->District;
		if($distcode > 0){
			$warehouseQ = "select pk_id,warehouse_name from epi_cc_warehouse where distcode = '$distcode' AND warehouse_type_id='4'";
			$data['warehouseQ']=$this->db->query($warehouseQ)->result_array();
		}
		else{
			$warehouseQ = "select pk_id,warehouse_name from epi_cc_warehouse where warehouse_type_id='2'";
			$data['warehouseQ']=$this->db->query($warehouseQ)->result_array();
		}
		$assetTypeQ="select pk_id,asset_type_name from epi_cc_asset_types where status = 1";
		$data['assetTypeQ'] = $this->db->query($assetTypeQ)->result_array();
		$data['fileToLoad'] = 'coldchain/coldchain_main';
		$data['pageTitle'] = 'Cold Chain Main';
		$this->load->view('template/epi_template',$data);
	}
	public function coldchain_main_save()
	{
		if( ! $this->input->post('edit') && ! $this->input->post('id'))
		{
			$data = array(
				'auto_asset_id'	=>	$this->input->post('auto_asset_id'),
				'serial_no'		=>	$this->input->post('sr_no'),
				'estimate_life'	=>	$this->input->post('expected_life'),
				'working_since'	=>	$this->input->post('working_since'),
				'quantity'		=>	$this->input->post('quantity'),
				'manufacturer_year'	=>	$this->input->post('manufacturing_years'),
				'status'		=>	$this->input->post('status'),
				'ccm_sub_asset_type_id'	=>	$this->input->post('asset_type'),				
				'warehouse_type_id'	=>	$this->input->post('warehouse_type_id'),
				'reasons'		=>	$this->input->post('reason'),
				'utilizations'	=>	$this->input->post('utilization'),
				'model' 		=>	$this->input->post('model'),
				'maker' 		=>	$this->input->post('maker')
			);
			$modeltab = array(
				'model_name'=>$this->input->post('model')
			);
			$statustab = array(
				'warehouse_type_id'	=>	$this->input->post('warehouse_type_id'),
				'ccm_id'		=>	$this->input->post('asset_type'),
				'assets_type_id'=>	$this->input->post('auto_asset_id'),
				'status'		=>	$this->input->post('status'),
				'reasons'		=>	$this->input->post('reason'),
				'utilizations'	=>	$this->input->post('utilization'),
				'total_quantity'=>	$this->input->post('quantity'),
				'model'			=>	$this->input->post('model')
			);
			$this->db->insert('epi_cc_asset_status_history',$statustab);
			$this->db->insert('epi_cc_coldchain_main', $data);
		}
		else {
			$id = $this->input->post('id');
			$data = array(
				'serial_no'=>$this->input->post('sr_no'),
				'estimate_life'=>$this->input->post('expected_life'),
				'manufacturer_year'=>$this->input->post('manufacturing_years')
			);
			$this -> Common_model -> update_record('epi_cc_coldchain_main',$data,array('asset_id' => $id));
		}
		redirect('Coldchain/coldchain_main_list');
	}
	public function coldchain_main_list(){
		$queryData = "select a.warehouse_name,b.asset_type_name,c.ccm_id as asset_id,c.quantity,CASE WHEN c.status=1 THEN 'Working' WHEN c.status=3 THEN 'Not Working' WHEN c.status=2 THEN 'Maintenance Needed' WHEN c.status=5 THEN 'Working well but fuel not available' WHEN c.status=4 THEN 'Working well  fuel available' END as status from epi_cc_warehouse a  join epi_cc_coldchain_main c on c.warehouse_type_id= a.pk_id join epi_cc_asset_types b on c.ccm_sub_asset_type_id = b.pk_id";
		$result = $this->db->query($queryData)->result_array();
		$data['data'] = $result;
		$data['fileToLoad'] = 'coldchain/asset_form_list';
		$data['pageTitle'] = 'EPI-MIS | List of Assets';
		$this -> load -> view('template/epi_template', $data);
	}
	public function coldchain_main_view(){
		$ccm_id = $this->uri->segment(3);
		$queryData = "select a.warehouse_name,b.asset_type_name,c.serial_no,c.manufacturer_year,c.estimate_life,c.auto_asset_id,c.quantity,CASE WHEN c.status=1 THEN 'Working' WHEN c.status=2 THEN 'Not Working' WHEN c.status=1 THEN 'Working but Needs Maintenance' END as status from epi_cc_warehouse a  join epi_cc_coldchain_main c on c.warehouse_type_id= a.pk_id join epi_cc_asset_types b on c.ccm_sub_asset_type_id = b.pk_id where c.ccm_id = '$ccm_id' ";
		$data['data'] = $this->db->query($queryData)->result_array();
		//print_r($data['data']);exit;
		$data['fileToLoad'] = 'coldchain/coldchain_main_view';
		$data['pageTitle'] = 'Coldchain Main View';
		$this->load->view('template/epi_template',$data);
		
	}
	public function coldchain_main_edit(){
		$data['data'] = array();
		$ccm_id = $this->uri->segment(3);
		$queryData = "select a.warehouse_name,b.asset_type_name,c.serial_no,c.manufacturer_year,c.estimate_life,c.auto_asset_id,c.quantity,CASE WHEN c.status=1 THEN 'Working' WHEN c.status=2 THEN 'Not Working' WHEN c.status=3 THEN 'Working but Needs Maintenance' END as status from epi_cc_warehouse a  join epi_cc_coldchain_main c on c.warehouse_type_id= a.pk_id join epi_cc_asset_types b on c.ccm_sub_asset_type_id = b.pk_id where c.asset_id = '$asset_id' ";
		$data['result'] = $this->db->query($queryData)->result_array();
		$data["gdata"] = $this -> Common_model -> get_info("epi_cc_coldchain_main",$ccm_id,"ccm_id");  
		$data['edit']="Yes";
		$data['id'] = $ccm_id;
		
		$val=$data["gdata"]->manufacturer_year;
		$yearOp='<option value="">Select</option>';
		for($i=2016;$i<2019;$i++)
		{
			if($i == $val)
			{
				$selected = 'selected="selected"';
			}
			else
			{
				$selected = '';
			}
			$yearOp.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		$data['optionsY']=$yearOp;
		
		
		
		//print_r($data['data']);exit;
		$data['fileToLoad'] = 'coldchain/coldchain_main';
		$data['pageTitle'] = 'Coldchain Main';
		$this->load->view('template/epi_template',$data);
	}
	/* Code by Uzair for Cold Chain Make and Model  */
	public function coldchain_make_model()
	{
		$data['all_make_models'] = $this -> Coldchain_model -> get_all_makes_models();
		$data['all_cc_makes'] = $this -> Coldchain_model -> get_all_cc_makes();
		$data['all_assets_types'] = $this -> Coldchain_model -> get_all_coldchain_assets_types();
		$data['data'] = $data;
		$data['fileToLoad'] = 'coldchain/coldchain_make_model';
		$data['pageTitle'] = 'Cold Chain Assests Make & Model';
		$this->load->view('template/epi_template',$data);
	}
	public function add_new_cc_make()
	{
		$dataToInsert['make_name'] = $this -> input -> post('make_name');
		$insertedId = $this -> Common_model -> insert_record('epi_cc_makes',$dataToInsert);
		echo $insertedId;
	}
	public function add_new_cc_model()
	{
		$dataToInsert['ccm_make_id'] = $this -> input -> post('make_id');
		$dataToInsert['ccm_sub_asset_type_id'] = $asset_type_id = $this -> input -> post('asset_type_id');
		$result = $this -> Common_model -> get_info('epi_cc_asset_types',$asset_type_id,'pk_id');
		$dataToUpdate['model_name'] = $dataToInsert['model_name'] = $this -> input -> post('model');
		if($result->parent_id==0)
			$dataToInsert['asset_type_id'] = $result->pk_id;
		else
			$dataToInsert['asset_type_id'] = $result->parent_id;
		$id = $this -> input -> post('update');
		if($id > 0){
			$this -> Common_model -> update_record('epi_cc_models',$dataToUpdate,array('pk_id' => $id));
			$this -> session -> set_flashdata('message','Model Updated Successfully!');
			echo $this -> db -> affected_rows();
		}else{
			$insertedId = $this -> Common_model -> insert_record('epi_cc_models',$dataToInsert);
			$this -> session -> set_flashdata('message','Your Suggested Make and Model Inserted Successfully!');
			echo $insertedId;
		}
	}
	public function fetch_cc_model_by_id()
	{
		$id = $this -> input -> post('id');
		$result = $this -> Common_model -> get_info('epi_cc_models',$id,'pk_id');
		echo json_encode($result);
	}
	public function check_for_unique_make_name(){
		$makeName = $this -> input -> post('make_name');
		$result = $this -> Common_model -> get_info('epi_cc_makes',$makeName,'make_name','count(*) as num');
		if($result->num > 0){
			echo 1;
		}else{
			echo 0;
		}
	}
	public function check_for_unique_model_name_for_the_make(){
		$makeId = $this -> input -> post('make_id');
		$model = $this -> input -> post('model');
		$result = $this -> Common_model -> get_info('epi_cc_models','','','count(*) as num',array('ccm_make_id' => $makeId,'model_name' => $model));
		if($result->num > 0){
			echo 1;
		}else{
			echo 0;
		}
	}
	public function epi_cc_make_mode_delete(){
		
	}
	
	public function refrigerator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"1"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.parent_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_refrigerator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function coldroom_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"21"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.parent_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_coldroom';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function voltageregulator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"23"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.pk_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_voltageregulator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function generator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"24"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and ccm.ccm_sub_asset_type_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_gnerator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function transport_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"25"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.parent_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_transport';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function vaccinecarriers_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"26"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.pk_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_vaccinecarriers';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function icepack_add(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"27"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_icepack';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function coldbox_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"33"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_coldchain_main ";
		$multiple_search = "";
		$multiple_search .="and assetTypes.pk_id = ".$data['uri']."";
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}
		$data['refrigerator_data'] = $this -> Coldchain_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_assets_coldbox';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function refrigerator_add(){
		
		$result = "";
		//$assets = ($this->input->post('asset'))?$this->input->post('asset'):'';
		$data['offset']="No";
		//$assets = explode('-',$assets);
		//$assetsID = $assets[0];
		//print_r($assetsID); exit;
		//$assetsName = lcfirst(preg_replace('/\s+/', '', $assets[1]));
		//$data = array();
		$assetsID = 1;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		//$result = $this -> load -> view('coldchain/add_forms/add_refrigerator', $data, TRUE);
		//print_r($result); exit;
		//echo $result;
		
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_refrigerator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function coldroom_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 21;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_coldRoom';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function voltageregulator_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 23;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_voltageRegulator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function generator_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 24;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_generator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function transport_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 25;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_transport';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function vaccineCarriers_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 26;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_vaccineCarriers';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function coldBox_add(){
		
		$result = "";
		$data['offset']="No";
		$assetsID = 33;
		$username = $this->session->User_Name;
		$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
		$result = $this->db->query($query)->row();
		$data['varMax'] = $result->maxcnt+1;
		$data['commonSections'] = $this -> load -> view('coldchain/add_forms/commonSections', $data, TRUE);
		$data['asset_type_id'] = $assetsID;
		$wc = "asset_type_id=".$assetsID." and catalogue_id is not null and is_active='1'";
		$data['makedata'] = $this->Coldchain_model->getMake($assetsID);
		$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/add_coldBox';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function refrigeratorModalSave()
	{
		$data=array();
		$makesData=array();//set data and insert to epi_cc_makes table 
		$modelData=array();//set data and insert to epi_cc_models table
		if($this->input->post('catalogue_id') !="" || $this->input->post('make_name') !="" || $this->input->post('model_name') !="" || $this->input->post('ccm_sub_asset_type_id') !="")
		{
			foreach($_POST as $key => $value)
			{
				$modelData[$key] = ($value=='')?NULL:$value;
			}
			if($modelData['is_pqs']==0){
				unset($modelData['asset_dimension_length'],$modelData['asset_dimension_width'],$modelData['asset_dimension_height'],$modelData['gross_capacity_4'],$modelData['gross_capacity_20'],$modelData['net_capacity_4'],$modelData['net_capacity_20']);
			}
			$makesData['make_name'] = $modelData['make_name'];
			$makesData['created_by'] = $modelData['created_by'] = $this->session->username;
			$this->db->trans_start();
			$makeid=$this-> Common_model -> insert_record('epi_cc_makes',$makesData);
			$asset_type_id = $modelData['ccm_sub_asset_type_id'];
			//print_r($makeid);exit;
			$modelData['ccm_make_id'] = $makeid;
			$result = $this -> Common_model -> get_info('epi_cc_asset_types',$asset_type_id,'pk_id');
			$modelData['asset_type_id'] = $parent_id = $result->parent_id;
			$modelData['catalogue_id'] = $modelData['catalogue_id']."-".$modelData['make_name']."-".$modelData['model_name'];
			unset($modelData['make_name'],$modelData['asset_id']);
			//print_r($modelData);exit;
			$this-> Common_model ->insert_record('epi_cc_models',$modelData);
			//$range="pk_id,catalogue_id";
			//$where=array("asset_type_id"=>$parent_id);
			$wc="asset_type_id='{$parent_id}' and catalogue_id is not null";
			//$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
			$this->db->trans_complete();
			$varOption ="<option value=''>--Select--</option>";
			foreach($data['dataModel'] as $value){
				$varOption .= '<option value="'.$value['pk_id'].'">'.$value["catalogue_id"].'</option>';
			}
			echo $varOption;
		}
		else
		{
			echo "required";
		}
	}
	public function main_refrigeratorSave()
	{
		if($this->input->post('source_id')!="" && $this->input->post('utilizations')!="" && $this->input->post('ccm_model_id')!="")
		{
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$dataStatus=array();//set data and insert to epi_cc_asset_status_history table 
			$dataColdchainmain=array();//set data and insert to epi_cc_coldchain_main table
			foreach($_POST as $key => $value)
			{
				if($key == "working_since" && $value > (date('Y-m-d H:i:s')))
				{
					//print_r($value); exit;
					$value = date('Y-m-d H:i:s');
				}
				 if($key == "manufacturer_year")
				{
					//print_r($value); exit;
					$value = date('Y', strtotime($this->input->post('manufacturer_year')));
				} 
				$dataStatus[$key] = ($value=='')?NULL:$value;
			}
			if($dataStatus['placed_at-0']==0){
				$dataStatus['warehouse_type_id'] = 0;
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['tcode'],$dataStatus['facode']);
			}
			$dataColdchainmain = $dataStatus;
			if($this->session->UserLevel==2)
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			else if($this->session->UserLevel==4 && $this->session->utype=='Store')
			{
				$dataColdchainmain['storecode'] = $this->session->Tehsil;
			}
			else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			}
			//print_r($dataColdchainmain);exit;
			$dataStatus['procode'] = $this -> session -> Province;
			$dataStatus['assets_type_id'] = $assetTypeId=$dataStatus['ccm_sub_asset_type_id'];
			unset($dataStatus['ccm_model_id'],$dataStatus['ccm_sub_asset_type_id'],$dataStatus['placed_at-0'],$dataColdchainmain['placed_at-0'],$dataStatus['working_since'],$dataStatus['ccm_user_asset_id'],$dataStatus['source_id'],$dataStatus['ccm_temperature'],$dataStatus['ccm_voltage'],$dataStatus['cfc_free'],$dataStatus['serial_no'],$dataStatus['Capacity'],$dataStatus['manufacturer_year']);
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			if($status_history_id >0)
			{
				$wc = "";
				if($dataStatus['warehouse_type_id']=='0'){
					if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
					{
						$dataColdchainmain['storecode'] = $this->session->District;
					}
					else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
					{
						$dataColdchainmain['storecode'] = $this->session->Province;
					}
					$wc = " warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				}elseif($dataStatus['warehouse_type_id'] == '2'){
					$wc = " warehouse_type_id='2' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $this->session->Province;
					unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '4'){
					$wc = " warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
					unset($dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '5'){
					$wc = " warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
					unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '6'){
					$wc = " warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
				}//print_r($wc);exit;
				$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
				$MaxShortName = $this->db->query($queryShortName)->row();
				if($MaxShortName->maxval!=''){
					$code = $MaxShortName->maxval+1;
					$Shortname = $MaxShortName->name."-".$code;
					$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
				}else{
					$Ref = array(5,6,7,8,16,17,18,19);
					$FR = array(2,3,4,5,10,11,12);
					$sdd = array(14,15);
					$ilr = array(13);
					if(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$Ref)){
						$dataColdchainmain['short_name'] = 'REF-1';
					}elseif(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$FR)){
						$dataColdchainmain['short_name'] = 'FR-1';
					}elseif(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$sdd)){
						$dataColdchainmain['short_name'] = 'SSD-1';
					}elseif($dataColdchainmain['ccm_sub_asset_type_id']=='13'){
						$dataColdchainmain['short_name'] = 'ILR-1';
					}
					
				}
				///auto-asset-id start
				$query="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
				$result = $this->db->query($query)->row();
				$varMax = $result->maxcnt+1;
				///auto-asset-id end
				$dataColdchainmain['created_by'] = $this->session->User_Name;
				//$dataColdchainmain['auto_asset_id_increment'] = $varMax;
				//$dataColdchainmain['short_name'] = 'Ref';
				$dataColdchainmain['auto_asset_id'] = $distcode.$assetTypeId.$varMax;
				$dataColdchainmain['ccm_status_history_id'] = $status_history_id;
				$dataColdchainmain['procode'] = $this->session->Province;
				//$dataColdchainmain['created_date'] = date('Y-m-d', strtotime($dataColdchainmain['date']));
				unset($dataColdchainmain['date'],$dataColdchainmain['utilizations'],$dataColdchainmain['reasons'],$dataColdchainmain['cfc_free'],$dataColdchainmain['Capacity']);
				//print_r($dataColdchainmain);exit;
				$dataColdchainmain['asset_status']="Active";
				$mainid=$this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
				if($mainid>0)
					$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$mainid),array('pk_id'=>$status_history_id));
				$this->db->trans_complete();
			}
			else
			{
				
			}
			$this -> session -> set_flashdata('message','Refrigerator Record Inserted Successfully!');
			//redirect('Coldchain/coldChain_AssetsAdd');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/refrigerator_list/1');
	}
	public function coldroomSave()
	{
		if($this->input->post('source_id')!="" && $this->input->post('utilizations')!="")
		{
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$status = ($this->input->post('status')!='')?$this->input->post('status'):0;
			$username = $this->session->User_Name;
			$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			//set data and insert to epi_cc_asset_status_history table
			$dataStatus = array (
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> $status,
				'reasons' 			=> ($this->input->post('reasons')!='')?$this->input->post('reasons'):0,
				'utilizations'		=> ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0,
				'assets_type_id'	=> $ccm_sub_asset_type_id,
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 			=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'			=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL

			);
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			//--model table data
			$getAssetId = $this -> Common_model -> get_info('epi_cc_asset_types',$ccm_sub_asset_type_id,'pk_id');
			$modelID = $this->input->post('ccm_model_id');
			/* $model_name = $this -> Coldchain_model -> getModel('',$modelID);
			$model_name = $model_name[0]['model_name'];
			 $datModel = array(
				'asset_type_id' => $getAssetId->parent_id,
				'asset_dimension_length'	=> $this->input->post('asset_dimension_length'),
				'asset_dimension_width'		=> $this->input->post('asset_dimension_width'),
				'asset_dimension_height' 	=> $this->input->post('asset_dimension_height'),
				'ccm_sub_asset_type_id' 	=> $ccm_sub_asset_type_id,
				'gas_type' 					=> $this->input->post('gas_type'),
				'ccm_make_id' 				=> $this->input->post('make_name'),
				'model_name' 				=> $model_name,
				'created_by' 				=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$datModel); */
			//--coldchain main table data
			$increment = $this->input->post('increment');
			$auto_asset_id = $distcode.$ccm_sub_asset_type_id.$increment;
			$dataColdchainmain = array(
				'warehouse_type_id' 		=> $warehouse_type_id,
				//'auto_asset_id_increment' 	=> $increment,
				'ccm_sub_asset_type_id'   	=> $ccm_sub_asset_type_id,
				'ccm_status_history_id'   	=> $status_history_id,
				'status' 					=> $status,
				'working_since'   			=> $this->input->post('working_since'),
				'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
				'ccm_model_id'				=> $modelID,
				'source_id'					=> ($this->input->post('source_id') !="")?$this->input->post('source_id'):NULL,
				'auto_asset_id'   			=> $auto_asset_id,
				'serial_no'   				=> ($this->input->post('serial_no') !="")?$this->input->post('serial_no'):NULL,
				'created_by'   				=> $username,
				'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> $distcode,
				'tcode' 					=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 					=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'					=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL,
				'asset_status' 				=> "Active"
			);
			$wc = "";
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
				{
					$dataColdchainmain['storecode'] = $this->session->Tehsil;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = " and warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id =='2'){
				$wc = "and warehouse_type_id='2' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id =='4'){
				$wc = "and warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id =='5'){
				$wc = "and warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id =='6'){
				$wc = "and warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where short_name like 'CR-%' $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataColdchainmain['short_name'] = 'CR-1';
				
			}
			$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
			
			//--cold room table data
			$dataColdroom = array(
				'net_capacity' 					=> $this->input->post('net_capacity'),
				'gross_capacity' 				=> $this->input->post('gross_capacity'),
				'has_voltage' 					=> $this->input->post('has_voltage'),
				'cooling_system' 				=> ($this->input->post('cooling_system')!="")?$this->input->post('cooling_system'):'0',
				'backup_generator' 				=> $this->input->post('backup_generator'),
				'type_recording_system' 		=> $this->input->post('type_recording_system'),
				'temperature_recording_system' 	=> $this->input->post('temperature_recording_system'),
				'ccm_sub_asset_type_id' 		=> $ccm_sub_asset_type_id,
				'ccm_id' 						=> $coldchainMainId,
				'created_by' 					=> $username
			);
			$this-> Common_model -> insert_record('epi_ccm_cold_rooms',$dataColdroom);
			$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
			$this->db->trans_complete();
			$this -> session -> set_flashdata('message','Cold Room Record Inserted Successfully!');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/coldroom_list/21');
	}
	public function coldroomModalSave()
	{
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('net_capacity')!='' && $this->input->post('gross_capacity')!='')
		{
			$assetTypeId = $this->input->post('ccm_sub_asset_type_id');
			$username = $this->session->User_Name;
			
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$catalogue_id = $this->input->post('catalogue_id');
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$catalogue_id = $catalogue_id."-".$dataMake['make_name']."-".$model_name;
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $makeID,
				
				'internal_dimension_length' => (! is_null($this->input->post('asset_dimension_length')))?$this->input->post('asset_dimension_length'):0,
				'internal_dimension_width' 	=> (! is_null($this->input->post('asset_dimension_width')))?$this->input->post('asset_dimension_width'):0,
				'internal_dimension_height' => (! is_null($this->input->post('asset_dimension_height')))?$this->input->post('asset_dimension_height'):0,
				'gross_capacity_20' 		=> $this->input->post('gross_capacity'),
				'net_capacity_20' 			=> $this->input->post('net_capacity'),
				'gas_type' 					=> (! is_null($this->input->post('gas_type')))?$this->input->post('gas_type'):'R12',
				'product_price' 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):0,
				'catalogue_id' 				=> $catalogue_id,
				'ccm_sub_asset_type_id'		=> (! is_null($this->input->post('ccm_sub_asset_type_id')))?$this->input->post('ccm_sub_asset_type_id'):9,
				'asset_type_id'				=> '21',
				'created_by' 				=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			
			$wc="asset_type_id='21' and catalogue_id is not null";
			//$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
			$this->db->trans_complete();
			$varOption ="<option value=''>--Select--</option>";
			foreach($data['dataModel'] as $value){
				$varOption .= '<option value="'.$value['pk_id'].'">'.$value["catalogue_id"].'</option>';
			}
			echo $varOption;
		}
		else
		{
			echo "required";
		}
	}
	public function voltageRegulatorModalSave()
	{
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('nominal_voltage')!='')
		{
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$username = $this->session->User_Name;
			$increment = $this->input->post('increment');
			$assetTypeId = $this->input->post('asset_type_id');
			$auto_asset_id = $distcode.$assetTypeId.$increment;
			
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			
			if($makeID!="")
			{
				$catalogue_id = $this->input->post('catalogue_id');
				$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
				$catalogue_id = $catalogue_id."-".$dataMake['make_name']."-".$model_name;
				$dataModel = array( 						///data for model table
					'model_name' 	=> $model_name,
					'ccm_make_id' 	=> $makeID,
					
					'nominal_voltage' => (! is_null($this->input->post('nominal_voltage')))?$this->input->post('nominal_voltage'):0,
					'continous_power' => (! is_null($this->input->post('continous_power')))?$this->input->post('continous_power'):0,
					'frequency' => (! is_null($this->input->post('frequency')))?$this->input->post('frequency'):NULL,
					'input_voltage_range' => (! is_null($this->input->post('input_voltage_range')))?$this->input->post('input_voltage_range'):NULL,
					'output_voltage_range' => (! is_null($this->input->post('output_voltage_range')))?$this->input->post('output_voltage_range'):NULL,
					
					'product_price' => (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
					'catalogue_id' 	=> $catalogue_id,
					'ccm_sub_asset_type_id'	=> $assetTypeId, // same as asset type id becaues no sub time exist at valtage
					'asset_type_id'	=> $assetTypeId,
					'created_by' 	=> $username
				);
				$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			}
			/* if($modelID!="")
			{
				$dataColdchainmain = array(				///data for colchainmain table
					'auto_asset_id'			 	=> $auto_asset_id,
					'created_by' 				=> $username,
					//'auto_asset_id_increment' 	=> $increment,
					'ccm_model_id' 				=> $modelID,
					'procode' 					=> $this -> session -> Province,
					'quantity' 					=> (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL,
					'distcode' 					=> ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL,
					'tcode' 					=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
					'uncode' 					=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
					'facode'					=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL
				);
				$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
			}
			$dataVoltageRegulator = array( 			///data for epi_cc_voltage_regulator table
				'nominal_voltage'		=> (! is_null($this->input->post('nominal_voltage')))?$this->input->post('nominal_voltage'):NULL,
				'continous_power'      	=> (! is_null($this->input->post('continous_power')))?$this->input->post('continous_power'):NULL,
				'frequency'           	=> (! is_null($this->input->post('frequency')))?$this->input->post('frequency'):NULL,
				'input_voltage_range'  	=> (! is_null($this->input->post('input_voltage_range')))?$this->input->post('input_voltage_range'):NULL,
				'output_voltage_range'	=> (! is_null($this->input->post('output_voltage_range')))?$this->input->post('output_voltage_range'):NULL,
				'ccm_id' 			   	=> $coldchainMainId,
				'created_by'           	=> $username
			);
			$this-> Common_model -> insert_record('epi_ccm_voltage_regulators',$dataVoltageRegulator); */
			
			$data['dataModel'] = $this->Coldchain_model->getModel($assetTypeId);
			$this->db->trans_complete();
			$varOption ="<option value=''>--Select Asset--</option>";
			foreach($data['dataModel'] as $value){
				$varOption .="<option value='".$value['pk_id']."'>".$value['catalogue_id']."</option>";
			}
			echo $varOption;
		}
		else
		{
			echo "required";
		}
	}
	public function mainVoltageRegulatorSave()
	{
		if($this->input->post('Catelogue_id') !="0")
		{
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$modelID = (! is_null($this->input->post('Catelogue_id')))?$this->input->post('Catelogue_id'):NULL;
			$status = ($this->input->post('status')!='')?$this->input->post('status'):0;
			$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');
			$quantity = (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL;
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			// dataStatus
			$dataStatus = array (
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> $status,
				'reasons' 			=> ($this->input->post('reasons')!='')?$this->input->post('reasons'):0,
				//'utilizations'		=> ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0,
				'assets_type_id'	=> $ccm_sub_asset_type_id,
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 			=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'			=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL

			); //print_r($dataStatus); exit;
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$tcode	= ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
			$uncode	= ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
			$facode	= ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
			$increment = $this->input->post('increment');
			$assetTypeId = $this->input->post('asset_type_id');
			$auto_asset_id = $distcode.$assetTypeId.$increment;
			$dataColdchainmain = array(				///data for colchainmain table
				'auto_asset_id'			 	=> $auto_asset_id,
				'warehouse_type_id'         => $warehouse_type_id,
				'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
														   
							 
                'ccm_status_history_id'   	=> $status_history_id,
                'status' 					=> $status,
				'created_by' 				=> $this->session->User_Name,
				//'auto_asset_id_increment' 	=> $increment,
				'ccm_model_id' 				=> $modelID,
				'ccm_sub_asset_type_id'		=> $assetTypeId,
																
																						   
                'working_since'   			=> $this->input->post('working_since'),
				'procode' 					=> $this -> session -> Province,
				'quantity' 					=> (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL,
				'distcode' 					=> ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL,
				'tcode' 					=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 					=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'					=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL,
				'asset_status' => "Active"
			);
			$wc = "";
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
				{
					$dataColdchainmain['storecode'] = $this->session->Tehsil;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = " and warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id == '2'){
				$wc = "and warehouse_type_id='2' and  	ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id == '4'){
				$wc = "and warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($dwarehouse_type_id =='5'){
				$wc = "and warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$wc = "and warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where short_name like 'AVR-%' $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataColdchainmain['short_name'] = 'AVR-1';
				
			}
			$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
			$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
			$this->db->trans_complete();
            $this -> session -> set_flashdata('message','Voltage Regulator Record Inserted Successfully!');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/voltageregulator_list/23');
	}
	public function vaccineCarrierSave($ajax=FALSE)
	{
		if($ajax)
		{
			$username = $this->session->User_Name;
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			if($catalogue_id !="" && $make_name !="" && $model_name !="")
			{
				$dataMake = array(
					'make_name'	 => $make_name,
					'created_by' => $username
				);
				$this->db->trans_start();
				$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
				$asset_type_id	= (! is_null($this->input->post('asset_type_id')))?$this->input->post('asset_type_id'):NULL;
				$catalogueId = $catalogue_id."-".$make_name."-".$model_name;
				$catalogueId = $catalogue_id;
				$dataModel = array(
					'catalogue_id'	 			=> $catalogueId,
					'model_name'	 			=> $model_name,
					'ccm_sub_asset_type_id'		=> $asset_type_id,
					'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length_popup')))?$this->input->post('asset_dimension_length_popup'):NULL,
					'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width_popup')))?$this->input->post('asset_dimension_width_popup'):NULL,
					'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height_popup')))?$this->input->post('asset_dimension_height_popup'):NULL,
					'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length_popup')))?$this->input->post('internal_dimension_length_popup'):NULL,
					'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width_popup')))?$this->input->post('internal_dimension_width_popup'):NULL,
					'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height_popup')))?$this->input->post('internal_dimension_height_popup'):NULL,
					'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length_popup')))?$this->input->post('storage_dimension_length_popup'):NULL,
					'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width_popup')))?$this->input->post('storage_dimension_width_popup'):NULL,
					'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height_popup')))?$this->input->post('storage_dimension_height_popup'):NULL,
					'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
					'net_capacity_4'	 		=> (! is_null($this->input->post('net_capacity_4')))?$this->input->post('net_capacity_4'):NULL,
					'cold_life'	 				=> (! is_null($this->input->post('text')))?$this->input->post('text'):NULL,
					'asset_type_id'				=> $asset_type_id,
					'ccm_make_id'	 			=> $makeID,
					'created_by'	 			=> $username
				);
				$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
				$this->db->trans_complete();
				$range="pk_id,catalogue_id";
				$where=array("asset_type_id"=>$asset_type_id);
				$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
				$varOption ="<option value='0'>--Select--</option>";
				foreach($data['dataModel'] as $value){
					$varOption .="<option value='".$value['pk_id']."'>".$value['catalogue_id']."</option>";
				}
				echo $varOption;
			}
			else
			{
				echo "required";
			}
		}
		else
		{
			if($this->input->post('quantity') !="" && $this->input->post('ccm_model_id') != "")
			{
				$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
				$assetTypeId = $this->input->post('asset_type_id');
				$status = ($this->input->post('status')!='')?$this->input->post('status'):0;
				$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
				$dataStatus = array (
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> $status,
				'reasons' 			=> ($this->input->post('reasons')!='')?$this->input->post('reasons'):0,
				//'utilizations'		=> ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0,
				'assets_type_id'	=> $assetTypeId,
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 			=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'			=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL

			); //print_r($dataStatus); exit; 
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
				$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
				$tcode	= ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
				$uncode	= ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
				$facode	= ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
				$increment = $this->input->post('increment');
				$auto_asset_id = $distcode.$assetTypeId.$increment;
				$dataColdchainmain = array (
					'quantity' 					=> (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL,
					'ccm_model_id' 				=> $this->input->post('ccm_model_id'),
					'auto_asset_id' 			=> $auto_asset_id,
                    'ccm_status_history_id'		=> $status_history_id,
					'ccm_sub_asset_type_id' 	=> $assetTypeId,
					//'auto_asset_id_increment'	=> $increment,
					'warehouse_type_id' 		=> $warehouse_type_id,
                    'status' 					=> $status,
					'working_since'   			=> $this->input->post('working_since'),
					'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
					'procode' 					=> $this -> session -> Province,
					'distcode' 					=> $distcode,
					'tcode' 					=> $tcode,
					'uncode' 					=> $uncode,
					'facode' 					=> $facode,
					'created_by'	 			=> $this->session->User_Name,
					'asset_status' => "Active"
				);
				$wc = "";
				if($warehouse_type_id=='0'){
					if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
					{
						$dataColdchainmain['storecode'] = $this->session->District;
					}
					else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
					{
						$dataColdchainmain['storecode'] = $this->session->Tehsil;
					}
					else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
					{
						$dataColdchainmain['storecode'] = $this->session->Province;
					}
					$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
					unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
				}elseif($warehouse_type_id=='2'){
					$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataColdchainmain['storecode'] = $this->session->Province;
					unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
				}elseif($warehouse_type_id=='4'){
					$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
					unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
				}elseif($warehouse_type_id=='5'){
					$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
					unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
				}elseif($warehouse_type_id=='6'){
					$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
				}
				$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
				$MaxShortName = $this->db->query($queryShortName)->row();
				if($MaxShortName->maxval!=''){
					$code = $MaxShortName->maxval+1;
					$Shortname = $MaxShortName->name."-".$code;
					$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
				}else{
					$dataColdchainmain['short_name'] = 'AVCR-1';
					
				}
				/* if($this->session->UserLevel==2)
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				} */
				$coldchainMainId =$this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain);
                $this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
				$this->db->trans_complete();
                $this -> session -> set_flashdata('message','Vaccine Carriers Record Inserted Successfully!');
			}
			else
			{
				$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			}
			redirect('Coldchain/vaccinecarriers_list/26');
		}
	}
	public function generatorsSave()
	{
		if($this->input->post('source_id') !="" && $this->input->post('utilizations') !="" && $this->input->post('make_name') !="")
		{
			$username = $this->session->User_Name;
			$assetTypeId = $this->input->post('asset_type_id');
			//$distcode = $this -> session -> District;
			$increment = $this->input->post('increment');
			$source_id = $this->input->post('source_id');
			$ccm_model_id = $this->input->post('ccm_model_id');
			$reasons = ($this->input->post('reasons')!='')?$this->input->post('reasons'):'0';
			$utilizations = ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0;
			$power_source = $this->input->post('power_source');
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$tcode = ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
			$uncode = ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
			$facode = ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
			
			$auto_asset_id = $distcode.$assetTypeId.$increment;
			$dataStatus = array(
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				'reasons' 			=> $reasons,
				'utilizations' 		=> $utilizations,
				//'date' 				=> $this->input->post('date'),
				'assets_type_id' 	=> $assetTypeId,
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> $tcode,
				'uncode' 			=> $uncode,
				'facode'			=> $facode
			);
			//print_r($dataStatus); exit;
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			$dataColdchainmain = array(			///data for colchainmain table
				'auto_asset_id'			 	=> $auto_asset_id,
				'created_by' 				=> $username,
				'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				'source_id' 				=> $source_id,
				//'auto_asset_id_increment' 	=> $increment,
				'ccm_model_id' 				=> $ccm_model_id,
				'ccm_sub_asset_type_id' 	=> $assetTypeId,
				'serial_no' 				=> $this->input->post('serial_no'),
				'working_since' 			=> $this->input->post('working_since'),
				'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
				'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
				'ccm_status_history_id' 	=> $status_history_id,
				'warehouse_type_id' 		=> $warehouse_type_id,
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> $distcode,
				'tcode' 					=> $tcode,
				'uncode' 					=> $uncode,
				'facode'					=> $facode,
				'asset_status' => "Active"
			);
			//$wc = "";
            $wc = "asset_status='Active' and";
			$dataPost['warehouse_type_id'] = $warehouse_type_id;
			$dataPost['ccm_status_history_id'] = $status_history_id;
            if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
				{
					$dataColdchainmain['storecode'] = $this->session->Tehsil;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='2'){
				$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='4'){
				$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='5'){
				$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataColdchainmain['short_name'] = 'GEN-6000000';
				
			}
            $dataPost['procode']= $this -> session -> Province;
		    $dataPost['asset_status']="Active"; 
			/* if($this->session->UserLevel==2)
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			} */
			$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
			$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
			$dataGenerator = array(
				'power_rating' 				=> $this->input->post('power_rating'),
				'automatic_start_mechanism' => $this->input->post('automatic_start'),
				'use_for' 					=> $this->input->post('use_for'),
				'power_source' 				=> $power_source,
				'ccm_id' 					=> $coldchainMainId,
				'created_by' 				=> $username
			);
			$this-> Common_model -> insert_record('epi_ccm_generators',$dataGenerator);
			$this->db->trans_complete();
			$this -> session -> set_flashdata('message','Generator Record Inserted Successfully!');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/generator_list/24');
	}
	public function transportSave()
	{
		if($this->input->post('source_id') !="" && $this->input->post('utilizations') !="" && $this->input->post('ccm_sub_asset_type_id') !="" && $this->input->post('manufacturer_year') !="")
		{
			$username = $this->session->User_Name;
			$assetTypeId = $this->input->post('asset_type_id');
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$tcode = ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
			$uncode = ($this->input->post('uncode') != 0)?$this->input->post('uncode') :NULL;
			$facode = ($this->input->post('facode') != 0)?$this->input->post('facode'):NULL;
			$increment = $this->input->post('increment');
			$auto_asset_id = $distcode.$assetTypeId.$increment;
			//$ccm_model_id = $this->input->post('modelID');
			$ccm_model_id = $this->input->post('ccm_model_id');
			$reasons = ($this->input->post('reasons')!='')?$this->input->post('reasons'):0;
			$utilizations = ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0;
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			$subAssetTypeId = $this->input->post('ccm_sub_asset_type_id');
			$dataStatus = array(
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				'reasons' 			=> $reasons,
				'utilizations' 		=> $utilizations,
				//'date' 				=> $this->input->post('date'),
				'procode' 			=> $this -> session -> Province,
				'assets_type_id' 	=> $assetTypeId,
				'distcode' 			=> $distcode,
				'tcode' 			=> $tcode,
				'uncode' 			=> $uncode,
				'facode'			=> $facode
			);
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			$this->db->trans_start();
			$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			
			$dataColdchainmain = array(			///data for colchainmain table
				'warehouse_type_id' 		=> $warehouse_type_id,
				'auto_asset_id'			 	=> $auto_asset_id,
				'source_id'			 		=> $this->input->post('source_id'),
				'created_by' 				=> $username,
				'status' 					=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				//'auto_asset_id_increment' => $increment,
				'ccm_model_id' 				=> $ccm_model_id,
				'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
				'ccm_sub_asset_type_id' 	=> $subAssetTypeId,
				'working_since' 			=> $this->input->post('working_since'),
				'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
				'ccm_status_history_id' 	=> $status_history_id,
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> $distcode,
				'tcode' 					=> $tcode,
				'uncode' 					=> $uncode,
				'facode'					=> $facode,
				'asset_status' => "Active"
			);
			$dataColdchainmain['storecode'] = $distcode;
			$wc = "";
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
				{
					$dataColdchainmain['storecode'] = $this->session->Tehsil;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='2'){
				$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='4'){
				$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
				$dataColdchainmain['storecode'] = $distcode;
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='5'){
				$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
				$dataColdchainmain['storecode'] = $tcode;
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
				$dataColdchainmain['storecode'] = $facode;
			}
			$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				/* $dataColdchainmain['short_name'] = 'Vehicles-6000000';
				if($subAssetTypeId = 28){
					$dataColdchainmain['short_name'] = 'Motorcycle-7000000';
				}elseif($subAssetTypeId = 29){
					$dataColdchainmain['short_name'] = 'Vehicles-7000000';
				}elseif($subAssetTypeId = 30){
					$dataColdchainmain['short_name'] = 'Van-7000000';
				}elseif($subAssetTypeId = 31){
					$dataColdchainmain['short_name'] = 'Boat-7000000';
				}elseif($subAssetTypeId = 32){
					$dataColdchainmain['short_name'] = 'Bicycle-7000000';
				} */
				$dataColdchainmain['short_name'] = 'Vehicles-7000000';
			}
			/* if($this->session->UserLevel==2)
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			} */
			$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
			$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
			
			$dataModelupdate = array(
				'ccm_sub_asset_type_id'	=> $subAssetTypeId,
				'utilizations' 			=> $utilizations,
				'reasons' 				=> $reasons,
				'created_by' 			=> $username
			);
			$this-> Common_model -> update_record('epi_cc_models',$dataModelupdate,array('pk_id'=>$ccm_model_id));
			$dataTransport = array(
				'registration_no' 		=> $this->input->post('registration_no'),
				'engine_no' 		    => $this->input->post('engine_no'),
				'chases_no' 		    => $this->input->post('chases_no'),
				'used_for_epi' 			=> $this->input->post('used_for_epi'),
				'comments' 				=> $this->input->post('comments'),
				'ccm_id' 				=> $coldchainMainId,
				'ccm_sub_asset_type_id' => $subAssetTypeId,
				'fuel_type_id' 			=> $this->input->post('fuel_type_id'),
				'created_by' 			=> $username
			);
			if($dataTransport['used_for_epi']==''){
				unset($dataTransport['used_for_epi']);
			}
			$status_history_id = $this-> Common_model -> insert_record('epi_ccm_vehicles',$dataTransport);
			$this->db->trans_complete();
			$this -> session -> set_flashdata('message','Transport Record Inserted Successfully!');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/transport_list/25');
	}
	public function icePackSave()
	{
		/* if($this->input->post('warehouse_type_id') !="0")
		{ */
			
			$username = $this->session->User_Name;
			//$assetTypeId = $this->input->post('asset_type_id');
			$distcode = $this -> session -> District;
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');
			$increment = $this->input->post('increment');
			
			//$auto_asset_id = $distcode.$assetTypeId.$increment;
			$dataStatus = array(
				'warehouse_type_id' 		=> $warehouse_type_id,
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> ($this->input->post('distcode') != 0)?$distcode:NULL,
				'tcode' 					=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 					=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'					=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL
			);
			$dataColdchainmain = array(		///data for colchainmain table
				'warehouse_type_id' 		=> $warehouse_type_id,
				//'auto_asset_id'			 	=> $auto_asset_id,
				'created_by' 				=> $username,
				'auto_asset_id_increment' 	=> $increment,
				'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
				'ccm_sub_asset_type_id' 	=> $ccm_sub_asset_type_id,
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> ($this->input->post('distcode') != 0)?$distcode:NULL,
				'tcode' 					=> ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL,
				'uncode' 					=> ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL,
				'facode'					=> ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL,
				'short_name' 				=> 'AICP',
				'ccm_sub_asset_type_id' 	=> '27', 
				'asset_status' => "Active"
			);
			//Delete Mechanism start
			$edit =  $this -> input -> post('edit');
			if($edit==1){
				$storeId = $warehouse_type_id;
				if($storeId==4)
					$distcode = $this -> session -> District;
				else
					$distcode = $this -> input -> post('distcode');
					$tcode = $this -> input -> post('tcode');
					$uncode = $this -> input -> post('uncode');
					$facode = $this -> input -> post('facode');
				$wc = "and warehouse_type_id='{$storeId}' and ccm_sub_asset_type_id='27'";
				$wa = "warehouse_type_id='{$storeId}' and assets_type_id='27'";
				if($storeId=='4'){
					$wc = " and warehouse_type_id='4' and distcode='{$distcode}' and ccm_sub_asset_type_id='27'";
					$wa = "warehouse_type_id='4' and distcode='{$distcode}' and assets_type_id='27'";
				}elseif($storeId=='5'){
					$wc = " and warehouse_type_id='5' and tcode='{$tcode}' and ccm_sub_asset_type_id='27'";
					$wa = " warehouse_type_id='5' and tcode='{$tcode}' and assets_type_id='27'";
				}elseif($storeId=='6'){
					$wc = " and warehouse_type_id='6' and facode='{$facode}' and ccm_sub_asset_type_id='27'";
					$wa = "warehouse_type_id='6' and facode='{$facode}' and assets_type_id='27'";
				}elseif($storeId=='2'){
					$wc = " and warehouse_type_id='2' and ccm_sub_asset_type_id='27'";
					$wa = "warehouse_type_id='2' and assets_type_id='27'";
				} 
				$query1 = "Delete from epi_cc_coldchain_main where short_name like '%AICP%' {$wc}";
				//print_r($query); exit();
				$result1 = $this -> db ->query($query1);
				$query2 = "Delete from epi_cc_asset_status_history  where {$wa}";
				//print_r($query); exit();
				$result2 = $this -> db ->query($query2);
				
			}
			//Delete Mechanism End
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='2'){
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='4'){
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='5'){
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			$this->db->trans_start();
			$quantity = "";
			for($i=2; $i<=9; $i++)
			{
				$quantityName = "{$i}quantity";
				$quantity = $this->input->post($quantityName);
				if($quantity !="")
				{
					$query ="select max(auto_asset_id_increment) as maxcnt from epi_cc_coldchain_main";
					$result = $this->db->query($query)->row();
					$increment = $result->maxcnt+1;
					$arrayHistory = array('working_quantity' => $quantity,'total_quantity' => $quantity,'assets_type_id'=>'27');
					$dataStatus = $dataStatus + $arrayHistory;
					$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
					$model_name = "0.{$i}";
					//$modelId = $this-> Common_model -> get_info('epi_cc_models',NULL,NULL,'pk_id',array('model_name'=>$model_name));
					$arrayColdchain = array('quantity' => $quantity,'ccm_status_history_id' => $status_history_id,'auto_asset_id_increment'=>$increment);
					$dataColdchainmain = $dataColdchainmain  + $arrayColdchain;
					$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain);
					unset($dataColdchainmain['quantity'],$dataColdchainmain['ccm_status_history_id'],$dataColdchainmain['ccm_model_id'],$dataColdchainmain['auto_asset_id_increment'],$dataStatus['working_quantity'],$dataStatus['total_quantity']);
					$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
				}
			}//exit;
			$this->db->trans_complete();
			$this -> session -> set_flashdata('message','Ice Pack Record Inserted Successfully!');
		/* }
		else
		{
			$this -> session -> set_flashdata('message','SORRY: Select the Required Fields!');
		} */
		redirect('Coldchain/icepack_add/27');
	}
	public function coldboxSave($ajaxReq=FALSE){
		$username = $this->session->User_Name;
		foreach($_POST as $key => $value)
		{
			$dataPost[$key] = $value;
			if($value === '') 
			{ 
				unset($dataPost[$key]);
			}
		}//print_r($dataPost);exit;
		if($ajaxReq)
		{
			if($dataPost['catalogue_id'] !="" && $dataPost['make_name'] !="" && $dataPost['model_name'] !="")
			{
				$this->db->trans_start();
				//$dataMake = array('make_name' => $dataPost['make_name'],'created_by' => $username);
				$makeID = $this-> Common_model -> insert_record('epi_cc_makes',array('make_name' => $dataPost['make_name'],'created_by' => $username));
				$dataPost['ccm_make_id'] = $makeID;
				$dataPost['created_by'] = $username;
				//$dataPost['catalogue_id'] = $dataPost['catalogue_id']."-".$dataPost['make_name']."-".$dataPost['model_name'];
				$dataPost['catalogue_id'] = $dataPost['catalogue_id'];
				unset($dataPost['make_name']);
				$this-> Common_model -> insert_record('epi_cc_models',$dataPost);
				$this->db->trans_complete();
				$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,'pk_id,catalogue_id',array("asset_type_id"=>$dataPost['asset_type_id']),NULL,array('by'=>'pk_id','type'=>'ASC'));
				$varOption ="<option value='0'>--Select--</option>";
				foreach($data['dataModel'] as $value){
					$varOption .="<option value='".$value['pk_id']."'>".$value['catalogue_id']."</option>";
				}
				echo $varOption;
			}
			else
			{
				echo "required";
			}
		}
		else
		{
			$procode = $this -> session -> Province;
			$distcode = (isset($dataPost['distcode']))?$dataPost['distcode']:NULL;
			$assetTypeId = $dataPost['ccm_sub_asset_type_id'] = $dataPost['asset_type_id'];
			//$reasons = (isset($dataPost['reasons']))?$dataPost['reasons']:0;

			//$status = ($this->input->post('status')!='')?$this->input->post('status'):0;
			$auto_asset_id = $distcode.$assetTypeId;
			$dataPost['asset_type_id'] = $auto_asset_id;

			//$warehouse_type_id = ($dataPost['placed_at-0']==1)?$this->input->post('warehouse_type_id'):0;
			if($dataPost['quantity'] !="" && $dataPost['ccm_model_id'] != "")
			{
			$distcode = (isset($dataPost['distcode']))?$dataPost['distcode']:NULL;
			//$assetTypeId = $dataPost['ccm_sub_asset_type_id'] = $dataPost['asset_type_id'];
			$reasons = (isset($dataPost['reasons']))?$dataPost['reasons']:0;
			$status = ($this->input->post('status')!='')?$this->input->post('status'):0;
			$warehouse_type_id = ($dataPost['placed_at-0']==1)?$this->input->post('warehouse_type_id'):0;
				$dataStatus = array(
					'warehouse_type_id' => $warehouse_type_id,
					'status' 			=> (isset($dataPost['status']))?$dataPost['status']:0,
					'reasons' 			=> $reasons,

					'procode' 			=> $procode,
					'assets_type_id' 	=> $assetTypeId,
					//'total_quantity' 	=> $dataPost['quantity'],
					//'working_quantity' 	=> $dataPost['quantity'],
					'distcode' 			=> $distcode,
					'tcode' 			=> (isset($dataPost['tcode']))?$dataPost['tcode']:NULL,
					'uncode' 			=> (isset($dataPost['uncode']))?$dataPost['uncode']:NULL,
					'facode'			=> (isset($dataPost['facode']))?$dataPost['facode']:NULL

				); //print_r($dataStatus); exit; 
				if($warehouse_type_id==0){
					unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
				}
				$this->db->trans_start();
				$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
				
				$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
				$tcode	= ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
				$uncode	= ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
				$facode	= ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
				$increment = $this->input->post('increment');
				$auto_asset_id = $distcode.$assetTypeId.$increment;
				//echo ($auto_asset_id); exit;
				$dataColdchainmain = array (
					'quantity' 					=> (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL,
					'ccm_model_id' 				=> $this->input->post('ccm_model_id'),
					'auto_asset_id' 			=> $auto_asset_id,
					'ccm_status_history_id'		=> $status_history_id,	
					'ccm_sub_asset_type_id' 	=> $assetTypeId,
					//'auto_asset_id_increment'	=> $increment,
					'warehouse_type_id' 		=> $warehouse_type_id,
					'status' 					=> $status,
					'working_since'   			=> $this->input->post('working_since'),
					'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
					'procode' 					=> $this -> session -> Province,
					'distcode' 					=> $distcode,
					'tcode' 					=> $tcode,
					'uncode' 					=> $uncode,
					'facode' 					=> $facode,
					'created_by'	 			=> $this->session->User_Name,
					'asset_status' => "Active"
				); //print_r($dataColdchainmain); exit;
				$wc = "asset_status='Active' and";
				$dataPost['warehouse_type_id'] = $warehouse_type_id;
				$dataPost['manufacturer_year'] = date('Y', strtotime($this->input->post('manufacturer_year')));
				$dataPost['ccm_status_history_id'] = $status_history_id;
				if($warehouse_type_id=='0'){
					if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
					{
						$dataPost['storecode'] = $this->session->District;
					}
					else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
					{
						$dataColdchainmain['storecode'] = $this->session->Tehsil;
					}
					else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
					{
						$dataPost['storecode'] = $this->session->Province;
					}
					$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$assetTypeId}' and storecode='{$dataPost['storecode']}'";
					unset($dataPost['distcode'],$dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
				}else if($warehouse_type_id=='2'){
					$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataPost['storecode'] = $this->session->Province;
					unset($dataPost['distcode'],$dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
				}elseif($warehouse_type_id =='4'){
					$wc = " warehouse_type_id='4' and distcode='{$dataPost['distcode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataPost['storecode'] = $dataPost['distcode'];
					unset($dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
				}elseif($warehouse_type_id =='5'){
					$wc = " warehouse_type_id='5' and tcode='{$dataPost['tcode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataPost['storecode'] = $dataPost['tcode'];
					unset($dataPost['uncode'],$dataPost['facode']);
				}elseif($warehouse_type_id =='6'){
					$wc = " warehouse_type_id='6' and facode='{$dataPost['facode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
					$dataPost['storecode'] = $dataPost['facode'];
				}
				//$check="select from epi_cc_coldchain_main where $wc";
				$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
				$MaxShortName = $this->db->query($queryShortName)->row();
				$dataPost['created_by'] = $username;
				if($MaxShortName->maxval!=''){
					$code = $MaxShortName->maxval+1;
					$Shortname = $MaxShortName->name."-".$code;
					$dataPost['short_name'] = $Shortname;//print_r($Shortname);
				}else{
					$dataPost['short_name'] = 'CB-1';
					
				}




				$dataPost['procode']= $this -> session -> Province;
				$dataPost['asset_status']="Active"; 
				/* $coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataPost,'epi_coldchain_main_seq_id');
				 if($status_history_id > 0)

				{ */
					unset($dataPost['asset_type_id']);
					unset($dataPost['placed_at-0']);
					unset($dataPost['Capacity']);
					unset($dataPost['reasons']); 
					//print_r($dataPost);exit;
					$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataPost,'epi_coldchain_main_seq_id');
				 	//echo $coldchainMainId; exit;
					$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
					$this->db->trans_complete();
					$this -> session -> set_flashdata('message','Cold Box Record Inserted Successfully!');

				//}
				/* else
				{
					$this -> session -> set_flashdata('message','SORRY! Asset History occurs issue.');
				}  */

			} 
			else
			{
				$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			}
			$location = base_url(). "Coldchain/coldbox_list/33";
			redirect($location);
		}
	}
	public function getICePacks() {
  		$storeId = $this -> input -> post('storeId');
		if($storeId==4)
			$distcode = $this -> session -> District;
		else
			$distcode = $this -> input -> post('distcode');
		$tcode = $this -> input -> post('tcode');
		$uncode = $this -> input -> post('uncode');
		$facode = $this -> input -> post('facode');
		$wc = "and history.warehouse_type_id='{$storeId}'";
		if($storeId=='4'){
			$wc = " and history.warehouse_type_id='4' and history.distcode='{$distcode}'";
		}elseif($storeId=='5'){
			$wc = " and history.warehouse_type_id='5' and history.tcode='{$tcode}'";
		}elseif($storeId=='6'){
			$wc = " and history.warehouse_type_id='6' and history.facode='{$facode}'";
		}elseif($storeId=='2'){
			$wc = " and history.warehouse_type_id='2'";
		}
		$query = "
			SELECT history.working_quantity as quantity from epi_cc_coldchain_main ccm join epi_cc_asset_status_history history on history.ccm_id=ccm.asset_id where short_name like '%AICP%' {$wc} order by ccm.ccm_model_id
		";
		$result = $this -> db ->query($query);
		$result = $result -> result_array();
		$resulttot = FALSE;
		$i=0;
		if(!empty($result)){
			foreach($result as $key => $array){
				foreach($array as $val){
					$resulttot[$i] = $val;
					$i++;
				}
			}
			$resulttot = json_encode($resulttot);
		}
		echo $resulttot;
 	}
	public function coldchainSearch(){
		$UserLevel = $this->session->UserLevel;
		$assetsName = ($this -> uri -> segment(3))?$this -> uri -> segment(3):1;
		$data['id'] = $assetsID = ($this -> uri -> segment(4))?$this -> uri -> segment(4):1;
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("parent_id"=>"0","ccm_equipment_type_id"=>1),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$data['assetTypesPassiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("parent_id"=>"0","ccm_equipment_type_id"=>2),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types($assetsID);
		$data['makesData'] = $this->Coldchain_model -> getMake($assetsID);
		$data['search'] = TRUE;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/search_assets';
			$data['pageTitle']='Search Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function getSearchData()
	{
		$wc = array();
		$assets = ($this -> input -> post('assets')!="")?$this -> input -> post('assets'):1;
		$assets = explode('-',$assets);
		$assetsID = $assets[0];
		$assetsName = lcfirst(preg_replace('/\s+/', '', $assets[1]));//print_r($assetsName);exit;
		$subAssetID = $this -> input -> post('ccm_sub_asset_type_id');
		$AssetID = $this -> input -> post('ccm_asset_type_id');
		$_status = $this -> input -> post('status');
		$_noCoolSystem = $this -> input -> post('cooling_system');
		$_userAssetID = $this -> input -> post('ccm_user_asset_id');
		$_fuel_type_id = $this -> input -> post('fuel_type_id');
		$_modelID = $this -> input -> post('ccm_model_id');
		$_sourceSupply = $this -> input -> post('source_id');
		$_registration_no = $this -> input -> post('registration_no');
		
		$_catalogueID = $this -> input -> post('catalogue_id');
		$_makeID = $this -> input -> post('ccm_make_id');
		$_grossCFrom = $this -> input -> post('gross_capcity_from');
		$_grossCTo 	= $this -> input -> post('gross_capcity_to');
		$_workFrom 	= ($this ->input -> post ('working_from')!="")?date('Y-m-d', strtotime($this ->input -> post ('working_from'))):NULL;
		$_workTo 	= ($this ->input -> post ('working_to')!="")?date('Y-m-d', strtotime($this ->input -> post ('working_to'))):NULL;
		
		$_WareHouseID 	= ($this -> input -> post('warehouse_type_id')!='0')?$this -> input -> post('warehouse_type_id'):0;
		$distcode 		= ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):($this->session->UserLevel=="3")?$this -> session->District:'';
		$tcode 			= $this -> input -> post('tcode');
		$uncode 		= $this -> input -> post('uncode');
		$facode 		= $this -> input -> post('facode');
		$procode 		= $this->session-> Province;
		$wc['ccm.parent_id'] = $assetsID;
		if( $this->session->UserLevel == "2" )
			$_WareHouseID = 2;
		if($_WareHouseID=="0"){
			$wc['warehouse_type_id'] = 2;
		}
		else
		{
			$wc['warehouse_type_id'] = $_WareHouseID;
			if($distcode!="")
				$wc['ccm.distcode'] = $distcode;
		}
		if($_WareHouseID ==2 || $_WareHouseID==0)
		{
			$wc['ccm.procode'] = $procode;
		}elseif($_WareHouseID =='4'){
			if($distcode!="")
				$wc['ccm.distcode'] = $distcode;
		}elseif($_WareHouseID =='5'){
			if($tcode!="")
				$wc['ccm.tcode'] = $tcode;
		}elseif($_WareHouseID =='6'){
			if($uncode!="")
				$wc['ccm.uncode'] = $uncode;
			if($facode !="")
				$wc['ccm.facode'] = $facode;
		}
		if($_catalogueID!="")
			$wc['md.catalogue_id'] = $_catalogueID;
		if($_makeID!="")
			$wc['md.ccm_make_id'] = $_makeID;
		if($_grossCFrom!="" && $_grossCTo !="")
		{
			if($assetsName == "coldRoom")
			{
				$wc['tble.gross_capacity >='] = $_grossCFrom;
				$wc['tble.gross_capacity <='] = $_grossCTo;
			}
			else{
				$wc['md.gross_capacity_20 >='] = $_grossCFrom;
				$wc['md.gross_capacity_20 <='] = $_grossCTo;
			}
		}
		if($_workFrom!="" && $_workTo !="")
		{
			if($assetsName == "coldRoom")
			{
				$wc['tble.created_date >='] = $_workFrom;
				$wc['tble.created_date <='] = $_workTo;
			}
			else
			{
				$wc['ccm.created_date >='] = $_workFrom;
				$wc['ccm.created_date <='] = $_workTo;
			}
		}		
		if($subAssetID!="")
			$wc['ccm.ccm_sub_asset_type_id'] = $subAssetID;
		if($_modelID !="")
			$wc['ccm.ccm_model_id'] = $_modelID;
		if($_userAssetID !="")
			$wc['ccm_user_asset_id'] = $_userAssetID;
		if($_status)
			$wc['ccm.status'] = $_status;
		if($_noCoolSystem!="")
			$wc['tble.cooling_system'] = $_noCoolSystem;
		if($_sourceSupply!="")
			$wc['ccm.source_id'] = $_sourceSupply;
		if($_fuel_type_id!="")
			$wc['tble.fuel_type_id'] = $_fuel_type_id;
		if($_registration_no!="")
			$wc['tble.registration_no'] = $_registration_no;
		$tbl="";
        unset($wc['ccm.parent_id']);
		$defaultlink = "refrigeratorView";
		$shortName = "REF";
		if($assetsName == "coldRoom")
		{
			$tbl = "";
			unset($wc['ccm.parent_id']);
			$defaultlink = "coldroomView";
			$shortName='CR';
            $wc['assetTypes.parent_id'] = $assetsID;
			
		}elseif($assetsName == "generator")
		{
			$tbl = "epi_ccm_generators";
			unset($wc['ccm.parent_id']);
			$defaultlink = "generatorView";
			$shortName='GEN';
		}
		elseif($assetsName == "transport")
		{
			$tbl = "";
			unset($wc['ccm.parent_id']);
			$defaultlink = "transportView";
			$shortName='Vehicles';
            $wc['assetTypes.parent_id'] = $assetsID;
		}
		elseif($assetsName == "voltageRegulator")
		{
			$tbl = "";
			unset($wc['ccm.parent_id']);
			$defaultlink = "voltageRegulatorView";
			$shortName='AVR';
			$wc['assetTypes.pk_id'] = $assetsID;
		}
		elseif($assetsName == "vaccineCarriers")
		{
			$tbl = "";
			unset($wc['ccm.parent_id']);
			$defaultlink = "vaccineCarriersView";
			$shortName = "AVCR";
			$wc['assetTypes.pk_id'] = $assetsID;
		}
		elseif($assetsName == "icePack")
		{
			$tbl = "";
			unset($wc['ccm.parent_id'],$wc['md.ccm_make_id'],$wc['ccm.ccm_sub_asset_type_id'],$wc['warehouse_type_id']);
			$defaultlink = "icePackView";
			$shortName = "AICP";
			$wc['assetTypes.pk_id'] = $assetsID;
			if($_WareHouseID!=NULL)
				$wc['history.warehouse_type_id'] = $_WareHouseID;
		}
		elseif($assetsName == "coldBox")
		{
			$tbl = "";
			unset($wc['ccm.parent_id']);
			$wc['assetTypes.pk_id'] = $assetsID;
			$defaultlink = "coldBox";
			$shortName='CB';
		}
		$data = $this -> Coldchain_model -> getSearch($wc,$tbl);
		//print_r($data);exit;
		$tbody='';
		$storename = "";
		if(!empty($data)){
			$i=0;
			foreach ($data as $row) { 
				$i++;
				if (array_key_exists('warehouse_type_id', $row) && $row['warehouse_type_id']!='' && $row['warehouse_type_id']!=0)
				{
					$code = $row[get_warehouse_code_column($row['warehouse_type_id'])];
					if($code !="" && $row['warehouse_type_id']==6){
						$code = $row['facode'];
					}
					elseif($code != "" && $row['warehouse_type_id']==5)
					{
						$code = $row['tcode'];
					}elseif($code != "" && $row['warehouse_type_id']==4)
					{
						$code = $row['distcode'];
					}
					//if($code=='Unallocated'){ print_r($row['warehouse_type_id']);exit;}
					$storename = get_store_name(TRUE,$row['warehouse_type_id'],$code);
				}
				else
				{
					$storename="Unallocated";
				}
				$tbody .= '<tr>
						<td class="text-center">' . $i . '</td>';
						if($this->session->UserLevel == 3)
						{
							$tbody .= 	'<td class="text-center">' . $row['districtname'] . '</td>
										<td class="text-center">' . $row['facilityname'] . '</td>';
						}
						$tbody .= 	'<td class="text-center">' . $storename . '</td>';
						if($assetsName == "icePack")
							$tbody .= '<td class="text-center">Generic</td>';
						else
							$tbody .= '<td class="text-center">' . $row['make_name'] . '</td>';
						$tbody .= '<td class="text-center">' . $row['model_name'] . '</td>';
						if($assetsName=="generator")
						{
							$tbody .= '<td class="text-center">' . $row['serial_no'] . '</td>';
						}
						if($assetsName=="transport")
						{
							//$tbody .= '<td class="text-center">' . getPowerSource($row['fule_type'],TRUE) . '</td>';
						}
						else
						{
							if($assetsName=="coldRoom")
							{
								//$tbody .= '<td class="text-center">' . $row['gross_capacity'] . '</td>';
							}
							else
							{
								if($assetsName!="voltageRegulator"){
									if($assetsName!="icePack"){
										if($assetsName!="vaccineCarriers"){
											$tbody .= '<td class="text-center">' . $row['gross_capacity_20'] . '</td>';
										}
									}
								}
							}
						}
						if($assetsName!="voltageRegulator"){
							if($assetsName!="icePack"){
								if($assetsName!="vaccineCarriers"){
									$tbody .= '<td class="text-center">' . getWorkingstatus($row['status'],TRUE) . '</td>';
								}
							}
						}
						if($assetsName=="icePack"){
							$tbody .= '<td class="text-center">' . $row['working_quantity'] . '</td><td class="text-center">' . $row['total_quantity'] . '</td><td class="text-center">' . $row['date'] . '</td></tr>';
						}else{
							$tbody .= '<td class="text-center">' . date("d-m-Y", strtotime($row['created_date'])). '</td>
							<td class="text-center"> <a href="' . base_url() . 'Coldchain/'.$defaultlink.'/' . $row["id"] . '" target="_blank" data-toggle="tooltip" title="View" class="btn btn-xs btn-default" ><i class="fa fa-search"></i></a></td>
							</tr>';
						}
			}
		}else
		{
			$tbody='<td colspan="9" class="text-center">Sorry! No Record Found</td>';
		}
		$resultJson["tbody"] = $tbody;
		echo json_encode($resultJson);
	}
	public function refrigeratorView()
	{
		$CI = & get_instance();	//print_r($CI);exit;
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;//print_r($LoadData);exit;
			$data['fileToLoad'] = 'coldchain/add_forms/refrigerator_view';
			$data['pageTitle']='Refrigerator View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	/*Refrigerator Edit */
	//function for edit coldchain-regrigerator form
	function refrigeratorEdit()
	{
			$rcode['ccm.asset_id']=$asset_id= $this -> uri -> segment(3);
			//$coldchain_id= $this -> uri -> segment(4);
			$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
			//print_r($data);exit;
			$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
			//For Refrigerator
			$wc="asset_type_id='1' and catalogue_id is not null and is_active='1'";
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
			$data['data'] =$data;//print_r($LoadData);exit;
			$data['assetid']=$asset_id;
			//$data['coldchain_id']=$coldchain_id;
			$data['fileToLoad'] = 'coldchain/add_forms/refrigerator_edit';
			$data['pageTitle']='Refrigerator Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
	}
	/*Refrigerator Update Function */
	public function refrigeratorUpdate()
	{
		//echo '<pre>';print_r($_POST);
		$dataStatus=$_POST;
		$dataColdchainmain=$_POST;
		$wc = "";
				if($dataStatus['warehouse_type_id']=='0'){
					if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
					{
						$dataColdchainmain['storecode'] = $this->session->District;
					}
					else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
					{
						$dataColdchainmain['storecode'] = $this->session->Province;
					}
					$wc = " warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
					$dataColdchainmain['distcode']=NULL;
					$dataColdchainmain['tcode']=NULL;
					$dataColdchainmain['uncode']=NULL;
					$dataColdchainmain['facode']=NULL;
				}elseif($dataStatus['warehouse_type_id'] == '2'){
					$wc = " warehouse_type_id='2' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $this->session->Province;
					unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '4'){
					$wc = " warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
					unset($dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '5'){
					$wc = " warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
					unset($dataColdchainmain['tcode'],$dataColdchainmain['facode']);
				}elseif($dataStatus['warehouse_type_id'] == '6'){
					$wc = " warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
					$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
				}//print_r($wc);exit;
				/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
				$MaxShortName = $this->db->query($queryShortName)->row();
				if($MaxShortName->maxval!=''){
					$code = $MaxShortName->maxval+1;
					$Shortname = $MaxShortName->name."-".$code;
					$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
				}else{
					$Ref = array(5,6,7,8,16,17,18,19);
					$FR = array(2,3,4,5,10,11,12);
					$sdd = array(14,15);
					$ilr = array(13);
					if(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$Ref)){
						$dataColdchainmain['short_name'] = 'REF-1';
					}elseif(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$FR)){
						$dataColdchainmain['short_name'] = 'FR-1';
					}elseif(in_array($dataColdchainmain['ccm_sub_asset_type_id'],$sdd)){
						$dataColdchainmain['short_name'] = 'SSD-1';
					}elseif($dataColdchainmain['ccm_sub_asset_type_id']=='13'){
						$dataColdchainmain['short_name'] = 'ILR-1';
					}
				} */
				unset($dataColdchainmain['asset_id']);unset($dataColdchainmain['placed_at-0']);unset($dataColdchainmain['Capacity'],$dataColdchainmain['cfc_free']);
				$result=$this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$dataStatus['asset_id']));
				if($result > 0)
				{
					$this -> session -> set_flashdata('message','Record Update Successfully. !');
					$location = base_url(). "Coldchain/refrigerator_list/1";
					redirect($location);
				}
				
		
	}
	public function coldroomView()
	{
		$CI = & get_instance();	//print_r($CI);exit;
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getColdroomData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;//print_r($LoadData);exit;
			$data['fileToLoad'] = 'coldchain/add_forms/coldroom_view';
			$data['pageTitle']='Coldroom View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function coldroomEdit()
	{
		$CI = & get_instance();	//print_r($CI);exit;
		$rcode['ccm.asset_id']=$asset_id= $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getColdroomData($rcode);
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types(21);
		//print_r($data);exit;	print_r($data);exit;
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		$wc="asset_type_id='21' and catalogue_id is not null and is_active='1'";
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
			$data['assetid']=$asset_id;
		
		if ($data != 0) {
			$data['data'] = $data;//print_r($LoadData);exit;
			$data['fileToLoad'] = 'coldchain/add_forms/coldroom_edit';
			$data['pageTitle']='Coldroom Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function coldroomUpdate()
	{
		//print_r($_POST);
		$dataColdchainmain=$_POST;
		$warehouse_type_id=$dataColdchainmain['warehouse_type_id'];
		$assetid=$dataColdchainmain['asset_id'];
		$wc = "";
	if($warehouse_type_id=='0'){
		if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
		{
			$dataColdchainmain['storecode'] = $this->session->District;
		}
        else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
		{
			$dataColdchainmain['storecode'] = $this->session->Tehsil;
		}
        else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
		{
			$dataColdchainmain['storecode'] = $this->session->Province;
		}
		$wc = " and warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
		$dataColdchainmain['distcode']=NULL;
		$dataColdchainmain['tcode']=NULL;
		$dataColdchainmain['uncode']=NULL;
		$dataColdchainmain['facode']=NULL;
		//unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
	}elseif($warehouse_type_id =='2'){
		$wc = "and warehouse_type_id='2' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
		$dataColdchainmain['storecode'] = $this->session->Province;
		unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
	}elseif($warehouse_type_id =='4'){
		$wc = "and warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
		$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
		unset($dataColdchainmain['tcode'],$dataColdchainmain['tcode'],$dataColdchainmain['facode']);
	}elseif($warehouse_type_id =='5'){
		$wc = "and warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
		$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
		unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
	}elseif($warehouse_type_id =='6'){
		$wc = "and warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
		$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
	}
	/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where short_name like 'CR-%' $wc) as a";
	$MaxShortName = $this->db->query($queryShortName)->row();
	if($MaxShortName->maxval!=''){
		$code = $MaxShortName->maxval+1;
		$Shortname = $MaxShortName->name."-".$code;
		$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
	}else{
		$dataColdchainmain['short_name'] = 'CR-1';
		
	} */
	unset($dataColdchainmain['asset_id'],$dataColdchainmain['ccm_user_asset_id'],$dataColdchainmain['asset_id']);unset($dataColdchainmain['placed_at-0']);unset($dataColdchainmain['Capacity']);unset($dataColdchainmain['gross_capacity']);;unset($dataColdchainmain['net_capacity']);
	//print_r($dataColdchainmain);
	$result=$this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$assetid));
		if($result > 0)
		{
			$this -> session -> set_flashdata('message','Record Update Successfully. !');
			$location = base_url(). "Coldchain/coldroom_list/21";
			redirect($location);
		}
	}
	public function generatorView()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getGeneratorData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/generator_view';
			$data['pageTitle']='Generator View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function generatorEdit()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getGeneratorData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
        $wc="asset_type_id='24' and is_active='1'"; 
		$query ="select pk_id,model_name,ccm_make_id,makername(ccm_make_id) as make_name from epi_cc_models where {$wc} order by pk_id ASC";
		//print_r($query); exit(); 
		$data['dataModel'] = $this->db->query($query)->result_array();
        $data["assetid"]=$assetid;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/generator_Edit';
			$data['pageTitle']='Generator Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function generatorUpdate()
	{
		if($this->input->post('source_id') !="")
		{
			//$username = $this->session->User_Name;
			$assetTypeId = $assetid=$this->input->post('asset_id');
			//$distcode = $this -> session -> District;
			//$increment = $this->input->post('increment');
			$source_id = $this->input->post('source_id');
			$ccm_model_id = $this->input->post('ccm_model_id');
			//$reasons = ($this->input->post('reasons')!='')?$this->input->post('reasons'):'0';
			//$utilizations = ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0;
			//$power_source = $this->input->post('power_source');
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$tcode = ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
			$uncode = ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
			$facode = ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
			
			//$auto_asset_id = $distcode.$assetTypeId.$increment;
			$dataStatus = array(
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
			//	'reasons' 			=> $reasons,
				//'utilizations' 		=> $utilizations,
				'date' 				=> $this->input->post('date'),
				'assets_type_id' 	=> $assetTypeId,
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> $tcode,
				'uncode' 			=> $uncode,
				'facode'			=> $facode
			);
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			//$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			$dataColdchainmain = array(			///data for colchainmain table
				//'auto_asset_id'			 	=> $auto_asset_id,
				//'created_by' 				=> $username,
				//'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				'source_id' 				=> $source_id,
				//'auto_asset_id_increment' 	=> $increment,
				'ccm_model_id' 				=> $ccm_model_id,
			//	'ccm_sub_asset_type_id' 	=> $assetTypeId,
				'serial_no' 				=> $this->input->post('serial_no'),
			//	'working_since' 			=> $this->input->post('working_since'),
				'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
				//'ccm_status_history_id' 	=> $status_history_id,
				'warehouse_type_id' 		=> $warehouse_type_id,
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> $distcode,
				'tcode' 					=> $tcode,
				'uncode' 					=> $uncode,
				'facode'					=> $facode,
				//'asset_status' => "Active"
			);
			$wc = "";
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
                else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
				{
				$dataColdchainmain['storecode'] = $this->session->Tehsil;
				}
                else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$assetTypeId}' and storecode='{$dataColdchainmain['storecode']}'";
				$dataColdchainmain['distcode']=NULL;
				$dataColdchainmain['tcode']=NULL;
				$dataColdchainmain['uncode']=NULL;
				$dataColdchainmain['facode']=NULL;
				//unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='2'){
				$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='4'){
				$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='5'){
				$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataColdchainmain['short_name'] = 'GEN-6000000';
				
			} */
			/* if($this->session->UserLevel==2)
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			} */
			//$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain,'epi_coldchain_main_seq_id');
		//	$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$coldchainMainId),array('pk_id'=>$status_history_id));
			/* $dataGenerator = array(
				'power_rating' 				=> $this->input->post('power_rating'),
				'automatic_start_mechanism' => $this->input->post('automatic_start'),
				'use_for' 					=> $this->input->post('use_for'),
				'power_source' 				=> $power_source,
				'ccm_id' 					=> $coldchainMainId,
				'created_by' 				=> $username
			); */
		//	$this-> Common_model -> insert_record('epi_ccm_generators',$dataGenerator);
		//	print_r($dataColdchainmain);exit;
			$result=$this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$assetid));
            	$dataGenerator = array(
				'power_rating' 				=> $this->input->post('power_rating'),
				'automatic_start_mechanism' => $this->input->post('automatic_start_mechanism'),
				'use_for' 					=> $this->input->post('use_for'),
				'power_source' 				=> $this->input->post('power_source'),
				//'ccm_id' 					=> $coldchainMainId,
				'created_by' 				=> $username
			);
			$status_history_id =$this->db->update('epi_ccm_generators',$dataGenerator,array('ccm_id'=>$assetid));
            if($result > 0)
				{
					$this -> session -> set_flashdata('message','Record Update Successfully. !');
					$location = base_url(). "Coldchain/generator_list/24";
					redirect($location);
				}
			$this -> session -> set_flashdata('message','Generator Record Updated Successfully!');
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/generator_list/24');
	}
	public function transportView()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getTransportData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/transport_view';
			$data['pageTitle']='Transport View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//Work on it . . .
	public function transportEdit()
	{
		//echo "here";exit;
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$asset_id= $this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getTransportData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		$data['assets_sub_types'] = $this->Coldchain_model -> get_all_coldchain_assets_types(25);
        $wc="asset_type_id='25' and is_active='1'"; 
		$query ="select pk_id,model_name,ccm_make_id,makername(ccm_make_id) as make_name from epi_cc_models where {$wc} order by pk_id ASC";
		//print_r($query); exit(); 
		$data['dataModel'] = $this->db->query($query)->result_array();
		//data["assetid"]=$assetid;
        $data['assetid']=$asset_id;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/transport_edit';
			$data['pageTitle']='Transport Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function transportUpdate()
	{
		$username = $this->session->User_Name;
		$assetid=$this->input->post('asset_id');
		$assetTypeId = $this->input->post('asset_type_id');
		$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
		$tcode = ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
		$uncode = ($this->input->post('uncode') != 0)?$this->input->post('uncode') :NULL;
		$facode = ($this->input->post('facode') != 0)?$this->input->post('facode'):NULL;
		//$increment = $this->input->post('increment');
		//$auto_asset_id = $distcode.$assetTypeId.$increment;
		$ccm_model_id = $this->input->post('ccm_model_id');
		//$reasons = ($this->input->post('reasons')!='')?$this->input->post('reasons'):0;
		//$utilizations = ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0;
		$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
		$subAssetTypeId = $this->input->post('ccm_sub_asset_type_id');
		/* $dataStatus = array(
			'warehouse_type_id' => $warehouse_type_id,
			'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
			'reasons' 			=> $reasons,
			'utilizations' 		=> $utilizations,
			'date' 				=> $this->input->post('date'),
			'procode' 			=> $this -> session -> Province,
			'assets_type_id' 	=> $assetTypeId,
			'distcode' 			=> $distcode,
			'tcode' 			=> $tcode,
			'uncode' 			=> $uncode,
			'facode'			=> $facode
		);
		if($warehouse_type_id==0){
			unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
		}
		$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
		 */
		$dataColdchainmain = array(			///data for colchainmain table
			'warehouse_type_id' 		=> $warehouse_type_id,
			//'auto_asset_id'			 	=> $auto_asset_id,
			'source_id'			 		=> $this->input->post('source_id'),
		//	'created_by' 				=> $username,
		//	'status' 					=> ($this->input->post('status')!='')?$this->input->post('status'):0,
			//'auto_asset_id_increment' => $increment,
			'ccm_model_id' 				=> $ccm_model_id,
			'ccm_user_asset_id' 		=> $this->input->post('ccm_user_asset_id'),
			'ccm_sub_asset_type_id' 	=> $subAssetTypeId,
			//'manufacturer_year' 		=> date('Y', strtotime($this->input->post('manufacturer_year'))),
			//'ccm_status_history_id' 	=> $status_history_id,
			'procode' 					=> $this -> session -> Province,
			'distcode' 					=> $distcode,
			'tcode' 					=> $tcode,
			'uncode' 					=> $uncode,
			'facode'					=> $facode,
			
		);
		$dataColdchainmain['storecode'] = $distcode;
		$wc = "";
		if($warehouse_type_id=='0'){
			if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			}
            else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
			{
				$dataColdchainmain['storecode'] = $this->session->Tehsil;
			}
            else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
			$dataColdchainmain['distcode']=NULL;
			$dataColdchainmain['tcode']=NULL;
			$dataColdchainmain['uncode']=NULL;
			$dataColdchainmain['facode']=NULL;
			//unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id=='2'){
			$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
			$dataColdchainmain['storecode'] = $this->session->Province;
			unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id=='4'){
			$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
			$dataColdchainmain['storecode'] = $distcode;
			unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id=='5'){
			$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
			$dataColdchainmain['storecode'] = $tcode;
			unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id=='6'){
			$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$subAssetTypeId}'";
			$dataColdchainmain['storecode'] = $facode;
		}
		/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
		$MaxShortName = $this->db->query($queryShortName)->row();
		if($MaxShortName->maxval!=''){
			$code = $MaxShortName->maxval+1;
			$Shortname = $MaxShortName->name."-".$code;
			$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
		}else{
			/* $dataColdchainmain['short_name'] = 'Vehicles-6000000';
			if($subAssetTypeId = 28){
				$dataColdchainmain['short_name'] = 'Motorcycle-7000000';
			}elseif($subAssetTypeId = 29){
				$dataColdchainmain['short_name'] = 'Vehicles-7000000';
			}elseif($subAssetTypeId = 30){
				$dataColdchainmain['short_name'] = 'Van-7000000';
			}elseif($subAssetTypeId = 31){
				$dataColdchainmain['short_name'] = 'Boat-7000000';
			}elseif($subAssetTypeId = 32){
				$dataColdchainmain['short_name'] = 'Bicycle-7000000';
			} 
			$dataColdchainmain['short_name'] = 'Vehicles-7000000';
		} 
		/* if($this->session->UserLevel==2)
		{
			$dataColdchainmain['storecode'] = $this->session->Province;
		}
		else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
		{
			$dataColdchainmain['storecode'] = $this->session->District;
		} */
		//print_r($dataColdchainmain);exit;
		$result = $this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$assetid));
        		$dataTransport = array(
				'registration_no' 		=> $this->input->post('registration_no'),
				'engine_no' 		    => $this->input->post('engine_no'),
				'chases_no' 		    => $this->input->post('chases_no'),
				'used_for_epi' 			=> $this->input->post('used_for_epi'),
				//'used_for_epi' 			=> (! is_null($this->input->post('used_for_epi')))?$this->input->post('used_for_epi'):NULL,
				'comments' 				=> $this->input->post('comments'),
				//'ccm_id' 				=> $coldchainMainId,
				'ccm_sub_asset_type_id' => $subAssetTypeId,
				'fuel_type_id' 			=> $this->input->post('fuel_type_id'),
				'created_by' 			=> $username
		);
		if($dataTransport['used_for_epi']==''){
				unset($dataTransport['used_for_epi']);
		}
			//print_r($dataTransport); exit;
		$status_history_id = $this->db->update('epi_ccm_vehicles',$dataTransport,array('ccm_id'=>$assetid));
		if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/transport_list/25";
				redirect($location);
			}
			
	}
	public function vaccineCarriersView()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/vaccineCarriers_view';
			$data['pageTitle']='Vaccine Carriers View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function vaccineCarriersEdit(){
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		$data['assetid']=$assetid;
		//For Vaccine Carriers
			$wc="asset_type_id='26' and catalogue_id is not null and is_active='1'";
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/vaccineCarriers_Edit';
			$data['pageTitle']='Vaccine Carriers Edit| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	// Work on it . . .
	public function vaccineCarriersUpdate()
	{
		/* if($ajax)
		{
			$username = $this->session->User_Name;
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			if($catalogue_id !="" && $make_name !="" && $model_name !="")
			{
				$dataMake = array(
					'make_name'	 => $make_name,
					'created_by' => $username
				);
				$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
				$asset_type_id	= (! is_null($this->input->post('asset_type_id')))?$this->input->post('asset_type_id'):NULL;
				$catalogueId = $catalogue_id."-".$make_name."-".$model_name;
				$catalogueId = $catalogue_id;
				$dataModel = array(
					'catalogue_id'	 			=> $catalogueId,
					'model_name'	 			=> $model_name,
					'ccm_sub_asset_type_id'		=> $asset_type_id,
					'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length_popup')))?$this->input->post('asset_dimension_length_popup'):NULL,
					'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width_popup')))?$this->input->post('asset_dimension_width_popup'):NULL,
					'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height_popup')))?$this->input->post('asset_dimension_height_popup'):NULL,
					'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length_popup')))?$this->input->post('internal_dimension_length_popup'):NULL,
					'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width_popup')))?$this->input->post('internal_dimension_width_popup'):NULL,
					'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height_popup')))?$this->input->post('internal_dimension_height_popup'):NULL,
					'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length_popup')))?$this->input->post('storage_dimension_length_popup'):NULL,
					'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width_popup')))?$this->input->post('storage_dimension_width_popup'):NULL,
					'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height_popup')))?$this->input->post('storage_dimension_height_popup'):NULL,
					'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
					'net_capacity_4'	 		=> (! is_null($this->input->post('net_capacity_4')))?$this->input->post('net_capacity_4'):NULL,
					'cold_life'	 				=> (! is_null($this->input->post('text')))?$this->input->post('text'):NULL,
					'asset_type_id'				=> $asset_type_id,
					'ccm_make_id'	 			=> $makeID,
					'created_by'	 			=> $username
				);
			//	$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
				$range="pk_id,catalogue_id";
				$where=array("asset_type_id"=>$asset_type_id);
				$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
				$varOption ="<option value='0'>--Select--</option>";
				foreach($data['dataModel'] as $value){
					$varOption .="<option value='".$value['pk_id']."'>".$value['catalogue_id']."</option>";
				}
				echo $varOption;
			}
			else
			{
				echo "required";
			}
		} */
		/* else
		{ */
		if($this->input->post('quantity') !="" && $this->input->post('ccm_model_id') != "")
		{
			$assetTypeId =$assetid=$this->input->post('asset_id');
			$warehouse_type_id = ($this->input->post('placed_at-0')==1)?$this->input->post('warehouse_type_id'):0;
			$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
			$tcode	= ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
			$uncode	= ($this->input->post('uncode') != 0)?$this->input->post('uncode'):NULL;
			$facode	= ( $this->input->post('facode')!= 0)?$this->input->post('facode'):NULL;
			$increment = $this->input->post('increment');
		//	$auto_asset_id = $distcode.$assetTypeId.$increment;
			$dataColdchainmain = array (
				'quantity' 					=> (! is_null($this->input->post('quantity')))?$this->input->post('quantity'):NULL,
				'ccm_model_id' 				=> $this->input->post('ccm_model_id'),
				//'auto_asset_id' 			=> $auto_asset_id,
				'ccm_sub_asset_type_id' 	=>26,
				//'auto_asset_id_increment'	=> $increment,
				'warehouse_type_id' 		=> $warehouse_type_id,
				'working_since'   			=> $this->input->post('working_since'), 
				'procode' 					=> $this -> session -> Province,
				'distcode' 					=> $distcode,
				'tcode' 					=> $tcode,
				'uncode' 					=> $uncode,
				'facode' 					=> $facode,
			//	'created_by'	 			=> $this->session->User_Name,
				//'asset_status' => "Active"
			);
			/* $wc = "";
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataColdchainmain['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataColdchainmain['storecode'] = $this->session->Province;
				}
				$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='2'){
				$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $this->session->Province;
				unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='4'){
				$wc = " warehouse_type_id='4' and distcode='{$distcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
				unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='5'){
				$wc = " warehouse_type_id='5' and tcode='{$tcode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
				unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
			}elseif($warehouse_type_id=='6'){
				$wc = " warehouse_type_id='6' and facode='{$facode}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
			}
			$queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataColdchainmain['short_name'] = 'AVCR-1';
				
			} */
			/* if($this->session->UserLevel==2)
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			else if($this->session->UserLevel==3 && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			} */
			//$this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataColdchainmain);
			
			//print_r($dataColdchainmain);exit;
			$result=$this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$assetid));
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/vaccinecarriers_list/26";
				redirect($location);
			}
			
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
		}
		redirect('Coldchain/vaccinecarriers_list/26');
	//}	
	}
	public function voltageRegulatorView()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getVoltageRegulatorData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/voltageRegulator_view';
			$data['pageTitle']='Voltage Regulator View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function voltageRegulatorEdit()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$asset_id=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getVoltageRegulatorData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		$wc="asset_type_id='23' and catalogue_id is not null and is_active='1'";
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
			$data['assetid']=$asset_id;
			$data['asset_type_id'] = 23;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/voltageRegulator_Edit';
			$data['pageTitle']='Voltage Regulator Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function voltageRegulatorUpdate()
	{
		//print_r($_POST);exit;
		$dataColdchainmain=$_POST;
		$warehouse_type_id=$dataColdchainmain['warehouse_type_id'];
		$assetid=$dataColdchainmain['asset_id'];
		$wc = "";
		if($warehouse_type_id=='0'){
			if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
			{
				$dataColdchainmain['storecode'] = $this->session->District;
			}
            else if($this->session->UserLevel=='4' && $this->session->utype=='Store')
			{
				$dataColdchainmain['storecode'] = $this->session->Tehsil;
			}
			else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
			{
				$dataColdchainmain['storecode'] = $this->session->Province;
			}
			$wc = " and warehouse_type_id='0' and ccm_sub_asset_type_id='{$dataColdchainmain['ccm_sub_asset_type_id']}' and storecode='{$dataColdchainmain['storecode']}'";
			$dataColdchainmain['distcode']=NULL;
			$dataColdchainmain['tcode']=NULL;
			$dataColdchainmain['uncode']=NULL;
			$dataColdchainmain['facode']=NULL;
			//unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id == '2'){
			$wc = "and warehouse_type_id='2' and  	ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
			$dataColdchainmain['storecode'] = $this->session->Province;
			unset($dataColdchainmain['distcode'],$dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id == '4'){
			$wc = "and warehouse_type_id='4' and distcode='{$dataColdchainmain['distcode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
			$dataColdchainmain['storecode'] = $dataColdchainmain['distcode'];
			unset($dataColdchainmain['tcode'],$dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($dwarehouse_type_id =='5'){
			$wc = "and warehouse_type_id='5' and tcode='{$dataColdchainmain['tcode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
			$dataColdchainmain['storecode'] = $dataColdchainmain['tcode'];
			unset($dataColdchainmain['uncode'],$dataColdchainmain['facode']);
		}elseif($warehouse_type_id=='6'){
			$wc = "and warehouse_type_id='6' and facode='{$dataColdchainmain['facode']}' and ccm_sub_asset_type_id 	='{$dataColdchainmain['ccm_sub_asset_type_id']}'";
			$dataColdchainmain['storecode'] = $dataColdchainmain['facode'];
		}
		/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where short_name like 'AVR-%' $wc) as a";
		$MaxShortName = $this->db->query($queryShortName)->row();
		if($MaxShortName->maxval!=''){
			$code = $MaxShortName->maxval+1;
			$Shortname = $MaxShortName->name."-".$code;
			$dataColdchainmain['short_name'] = $Shortname;//print_r($Shortname);
		}else{
			$dataColdchainmain['short_name'] = 'AVR-1';
			
		} */
		unset($dataColdchainmain['asset_id'],$dataColdchainmain['ccm_user_asset_id'],$dataColdchainmain['asset_id']);unset($dataColdchainmain['placed_at-0']);unset($dataColdchainmain['Capacity']);unset($dataColdchainmain['gross_capacity']);;unset($dataColdchainmain['net_capacity']);
		//print_r($dataColdchainmain);exit;
		$result=$this->db->update("epi_cc_coldchain_main",$dataColdchainmain,array('asset_id'=>$assetid));
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/voltageregulator_list/23";
				redirect($location);
			}
	}
	public function coldBoxView()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/coldBox_view';
			$data['pageTitle']='Cold Box View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function coldBoxEdit()
	{
		$CI = & get_instance();
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> Coldchain_model -> getRrefVaccData($rcode);
		$data['storename']= "Unallocated";
		//For Vaccine Carriers
			$wc="asset_type_id='33' and catalogue_id is not null and is_active='1'";
			$query ="select pk_id,catalogue_id from epi_cc_models where {$wc} order by pk_id ASC";
			$data['dataModel'] = $this->db->query($query)->result_array();
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		$data["assetid"]=$assetid;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'coldchain/add_forms/coldBox_Edit';
			$data['pageTitle']='Cold Box Edit | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function coldBoxUpdate()
	{
		foreach($_POST as $key => $value)
		{
			$dataPost[$key] = $value;
			if($value === '') 
			{ 
				unset($dataPost[$key]);
			}
		}
		$procode = $this -> session -> Province;
		$assetTypeId =33;
		$distcode = (isset($dataPost['distcode']))?$dataPost['distcode']:NULL;
		$assetid= $dataPost['asset_id'];
		//$reasons = (isset($dataPost['reasons']))?$dataPost['reasons']:0;
		//$utilizations = (isset($dataPost['utilizations']))?$dataPost['utilizations']:0;
		//$auto_asset_id = $distcode.$assetTypeId;
		//$dataPost['auto_asset_id'] = $auto_asset_id;
		$warehouse_type_id = ($dataPost['placed_at-0']==1)?$this->input->post('warehouse_type_id'):0;
		if($dataPost['quantity'] !="" && $dataPost['ccm_model_id'] != "")
		{
			$dataStatus = array(
				'warehouse_type_id' => $warehouse_type_id,
				'status' 			=> (isset($dataPost['status']))?$dataPost['status']:0,
				//'reasons' 			=> $reasons,
				//'utilizations' 		=> $utilizations,
				'procode' 			=> $procode,
				//'assets_type_id' 	=> $assetTypeId,
				'total_quantity' 	=> $dataPost['quantity'],
				'working_quantity' 	=> $dataPost['quantity'],
				'distcode' 			=> $distcode,
				'tcode' 			=> (isset($dataPost['tcode']))?$dataPost['tcode']:NULL,
				'uncode' 			=> (isset($dataPost['uncode']))?$dataPost['uncode']:NULL,
				'facode'			=> (isset($dataPost['facode']))?$dataPost['facode']:NULL
			);
			if($warehouse_type_id==0){
				unset($dataStatus['distcode'],$dataStatus['tcode'],$dataStatus['uncode'],$dataStatus['facode']);
			}
			//$status_history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$dataStatus);
			$wc = "asset_status='Active' and";
			$dataPost['warehouse_type_id'] = $warehouse_type_id;
			if($warehouse_type_id=='0'){
				if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
				{
					$dataPost['storecode'] = $this->session->District;
				}
				else if($this->session->UserLevel=='2' && $this->session->utype=='Manager')
				{
					$dataPost['storecode'] = $this->session->Province;
				}
				$wc = "warehouse_type_id='0' and ccm_sub_asset_type_id='{$assetTypeId}' and storecode='{$dataPost['storecode']}'";
				$dataColdchainmain['distcode']=NULL;
				$dataColdchainmain['tcode']=NULL;
				$dataColdchainmain['uncode']=NULL;
				$dataColdchainmain['facode']=NULL;
				//unset($dataPost['distcode'],$dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
			}else if($warehouse_type_id=='2'){
				$wc = " warehouse_type_id='2' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataPost['storecode'] = $this->session->Province;
				unset($dataPost['distcode'],$dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
			}elseif($warehouse_type_id =='4'){
				$wc = " warehouse_type_id='4' and distcode='{$dataPost['distcode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataPost['storecode'] = $dataPost['distcode'];
				unset($dataPost['tcode'],$dataPost['uncode'],$dataPost['facode']);
			}elseif($warehouse_type_id =='5'){
				$wc = " warehouse_type_id='5' and tcode='{$dataPost['tcode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataPost['storecode'] = $dataPost['tcode'];
				unset($dataPost['uncode'],$dataPost['facode']);
			}elseif($warehouse_type_id =='6'){
				$wc = " warehouse_type_id='6' and facode='{$dataPost['facode']}' and  ccm_sub_asset_type_id='{$assetTypeId}'";
				$dataPost['storecode'] = $dataPost['facode'];
			}
			//$check="select from epi_cc_coldchain_main where $wc";
			/* $queryShortName="select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where $wc) as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			$dataPost['created_by'] = $username;
			if($MaxShortName->maxval!=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name."-".$code;
				$dataPost['short_name'] = $Shortname;//print_r($Shortname);
			}else{
				$dataPost['short_name'] = 'CB-1';
				
			} */
			//unset($dataPost['date'],$dataPost['placed_at-0'],$dataPost['asset_type_id'],$dataPost['Capacity'],$dataPost['reasons'],$dataPost['utilizations']);//print_r('Try next time!');exit;
			unset($dataPost['date'],$dataPost['placed_at-0'],$dataPost['asset_id'],$dataPost['Capacity']);//print_r('Try next time!');exit;
			//$dataPost['ccm_status_history_id'] = $status_history_id;
			
			$dataPost['procode']= $this -> session -> Province;
			$result=$this->db->update("epi_cc_coldchain_main",$dataPost,array('asset_id'=>$assetid));
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/coldbox_list/33";
				redirect($location);
			}
		//	print_r($dataPost);
		//	$dataPost['asset_status']="Active";
		//$coldchainMainId = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataPost,'epi_coldchain_main_seq_id');
	}
	}
	public function getWC_clause_array($array)
	{
		$i=0;
		foreach($array as $key => $val){
			$wc[$i] = "{$key} = '{$val}'";
			$i++;
		}
		return $wc;
	}
	public function transfer()
	{
		$data = $_POST;//print_r($data);exit;
		if((($data['warehouse_type_id'] == '4' && $data['distcode'] != NULL) || ($data['warehouse_type_id'] == '5' && $this->input->post('tcode') != '0' && $this->input->post('tcode') != '') || ($data['warehouse_type_id'] == '6' && $this->input->post('facode') != '0' && $this->input->post('facode') != '') || ($data['warehouse_type_id'] == '2')) && $data['asset_id'] !="")
		{
			$assets = explode('-',$data['asset_id']);
			unset($data['asset_id']);
			$old_ccm_id = $assets[0]; 
			$formcheck = $assets[1]; 
			$assetid = $assets[2];
			$assets_no_history = array(23,26,27,33);
			$dataCCmain = $this -> Common_model -> get_info('epi_cc_coldchain_main','','','*',array('asset_id' => $old_ccm_id));
			$old_history_id = $dataCCmain->ccm_status_history_id;
			$ccm_sub_asset_type_id = $dataCCmain->ccm_sub_asset_type_id;
			
			
			if($data['warehouse_type_id'] == '2'){
				$storecode = $this->session->Province;
			}elseif($data['warehouse_type_id'] == '4'){
				$storecode = $data['distcode'];
			}elseif($data['warehouse_type_id'] == '5'){
				$storecode = $data['tcode'];
			}elseif($data['warehouse_type_id'] == '6'){
				$storecode = $data['facode'];
			}
			$data['storecode'] = $storecode;
			$transaction_data = array(
				'username' => $this->session->User_Name,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				'browser' => $this -> Common_model -> browser(),
				'module' => 'Cold Chain',
				'action' => 'Coldchain Asset Transfered',
				'userlevel' => $this->session->UserLevel,
				'datetime' => date('Y-m-d h:m:s'),
				'usertype' => $this->session->UserType
			);
			
			///check for transferFrom and TrnasferTo
			if($data['warehouse_type_id'] == $dataCCmain->warehouse_type_id && $data['storecode']==$dataCCmain->storecode)
			{ 
				$output = "Sorry! Did not Transfer at Same Store";
				echo $output;exit;
			}
			
			$wc = $this->getWC_clause_array($data);
			$wc[]="ccm_sub_asset_type_id='{$ccm_sub_asset_type_id}' and asset_status = 'Active'";
			$queryShortName = "select max(numbarr[1]) as name,MAX(numbarr[2]::numeric) as maxval from (select regexp_split_to_array(short_name, '-') as numbarr from epi_cc_coldchain_main where ".implode(" and ",$wc).") as a";
			$MaxShortName = $this->db->query($queryShortName)->row();
			if($MaxShortName->maxval !=''){
				$code = $MaxShortName->maxval+1;
				$Shortname = $MaxShortName->name ."-".$code;
			}
			else
			{
				$Ref = array(5,6,7,8,16,17,18,19);
				$FR = array(2,3,4,5,10,11,12);
				$sdd = array(14,15);
				$ilr = array(13);
				$CR = array(9,21,22);
				$transport = array(25,28,29,30,31,32);
				if(in_array($ccm_sub_asset_type_id,$Ref)){
					$Shortname = 'REF-1';
				}elseif(in_array($ccm_sub_asset_type_id,$FR)){
					$Shortname = 'FR-1';
				}elseif(in_array($ccm_sub_asset_type_id,$sdd)){
					$Shortname = 'SSD-1';
				}elseif($ccm_sub_asset_type_id=='13'){
					$Shortname = 'ILR-1';
				}elseif(in_array($ccm_sub_asset_type_id,$CR)){
					$Shortname = 'CR-1';
				}elseif($ccm_sub_asset_type_id == '23'){
					$Shortname = 'AVR-1';
				}elseif($ccm_sub_asset_type_id =='26'){
					$Shortname = 'AVCR-1';
				}elseif($ccm_sub_asset_type_id == '24'){
					$Shortname = 'GEN-6000000';
				}elseif(in_array($ccm_sub_asset_type_id,$transport)){
					$Shortname = 'Vehicles-7000000';
				}elseif($ccm_sub_asset_type_id == '33'){
					$Shortname = 'CB-1';
				}
			}
			$data['short_name'] = $Shortname;//print_r($Shortname);
			$this->db->trans_start();
			$history_id = 0;
			if(!in_array($ccm_sub_asset_type_id,$assets_no_history)){
				$getdatahistory = $this -> Common_model -> get_info('epi_cc_asset_status_history','','','*',array('pk_id' => $dataCCmain->ccm_status_history_id));
				
				$datahistory = json_decode(json_encode($getdatahistory), True);
				unset($datahistory['pk_id'],$datahistory['distcode'],$datahistory['tcode'],$datahistory['uncode'],$datahistory['facode']);
				$datahistory_insert = $data + $datahistory;
				unset($datahistory_insert['short_name'],$datahistory_insert['storecode']);
				//print_r($datahistory_insert);exit;
				
				$history_id = $this-> Common_model -> insert_record('epi_cc_asset_status_history',$datahistory_insert);
				$dataCCmain->ccm_status_history_id = $history_id;
			}
			$ccm_id = 0;
			$updateQuery = 0;
			if($formcheck == "Transfer")
			{
				//print_r('transfer');exit;
				if($assetid == "21"){
					$tble = "epi_ccm_cold_rooms";
				}elseif($assetid == "24"){
					$tble = "epi_ccm_generators";
				}elseif($assetid == "25"){
					$tble = "epi_ccm_vehicles";
				}else{
					$tble = "";
				}
				
				$dataCCmain = json_decode(json_encode($dataCCmain), True);
				$asset_id = $dataCCmain['asset_id'];
				unset($dataCCmain['asset_id'],$dataCCmain['auto_asset_id_increment'],$dataCCmain['short_name'],$dataCCmain['storecode'],
					$dataCCmain['distcode'],$dataCCmain['tcode'],$dataCCmain['uncode'],$dataCCmain['facode']
				);
				$dataCCmain_insert = $data + $dataCCmain;
				$dataCCmain_insert['created_by'] = $this->session->User_Name;
				$dataCCmain_insert['parent_id'] = $old_ccm_id;
				//print_r($dataCCmain_insert);exit;
				
				$ccm_id = $this-> Common_model -> insert_record('epi_cc_coldchain_main',$dataCCmain_insert,'epi_coldchain_main_seq_id');
				
				if($history_id > 0){
					$datahistory_insert['ccm_id'] =  $ccm_id;
					$this-> Common_model -> update_record('epi_cc_asset_status_history',array('ccm_id'=>$ccm_id),array('pk_id'=>$history_id));
				}
				if($tble !=""){
					$data_third = $this -> Common_model -> get_info($tble,'','','*',array('ccm_id' => $asset_id));
					$data_third_insert = json_decode(json_encode($data_third), True);
					$data_third_insert['ccm_id'] = $ccm_id;
					unset($data_third_insert['pk_id']);
					$this-> Common_model -> insert_record($tble,$data_third_insert);
				}
				$this -> Common_model -> update_record('epi_cc_coldchain_main',array('asset_status'=>"Transfer"),array('asset_id'=>$old_ccm_id));
				//print_r($datahistory_insert);exit;
				$output = "Assets Transfer to Store Successfully";
			}
			elseif($formcheck == "Allocate")
			{
				//$data['asset_status'] = "Active";
				$updateQuery = $this -> Common_model -> update_record('epi_cc_coldchain_main',$data,array('asset_id'=>$old_ccm_id));
				if(!in_array($ccm_sub_asset_type_id,$assets_no_history)){
					unset($data['storecode'],$data['short_name']);
					$this -> Common_model -> update_record('epi_cc_asset_status_history',$data,array('pk_id'=>$old_history_id));
				}
				$transaction_data['action'] = 'Coldchain Asset Allocated';
				$output = "Assets Alocate to Store Successfully";
			}else{
				$output = "required";
			}
			//transaction log for coldchain assets
			if($ccm_id > 0 || $updateQuery == "")
			{
				$this-> Common_model -> insert_record('user_transaction_log',$transaction_data,'transac_log_seq');
			}
			$this->db->trans_complete();
		}
		else
		{
			$output = "required";
		}
		echo $output;
	}
	public function transferTo()
	{
		$assets = ($this -> input -> post('asset')!="")?$this -> input -> post('asset'):"refrigerator-1";
		$assets = explode('-',$assets);
		$assetsID = $assets[0];
		$assetsName = lcfirst(preg_replace('/\s+/', '', $assets[1]));
	}
	public function coldchain_list()
	{
		//$assetnaid = $this->input->get("assetnameid");
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$search = $this->input->get("search");
		$columns = $this->input->get("columns");
		$multiple_search = "";
		$distcodetest=null;
		//print_r($search);exit;
		if(!empty($search['value'])){
		$assets = explode('-',$search['value']);
		$distcodetest =(isset($assets[2]))?$assets[2]:NULL;
		}
      	if(isset($columns) AND is_array($columns))
      	{
      		foreach ($columns as $key => $value) 
      		{
      			$search_value = $value['search']['value'];
      			$search_value = str_replace('_', ' ', $search_value);
      			$column = $value['data'];
      			if($this -> session -> UserLevel=='2')
      			{
					//for district dropdown 
					//$multiple_search .=" and storecode='{$this -> session -> Province}'";
					if($columns[1]['search']['value'] !="" && $distcodetest !=""){
						if(($columns[1]['search']['value']==4 || $columns[1]['search']['value']==5 || $columns[1]['search']['value']==6) && $distcodetest !=""){
						//$multiple_search .="and ccm.distcode ='{$distcodetest}'";
						}
					}else{
					
						//$multiple_search .=" and CAST(storecode AS VARCHAR(3)) like '{$this -> session -> Province}%'";
						$distcode="";
						$warehouseType= "0,2";
						$column = str_replace('district', 'distcode', $column);
					}
					//
					
      			}
      			elseif ($this -> session -> UserLevel=='3') 
      			{
					$warehouseType= "0,4,5,6";
					$distcode=$this -> session -> District;
      				$column = str_replace('tehsil', 'tcode', $column);
      			}
                elseif ($this -> session -> UserLevel=='4') 
      			{
					$warehouseType= "0,5,6";
					$distcode=$this -> session -> District;
					$tcode=$this -> session -> Tehsil;
      				$column = str_replace('tehsil', 'tcode', $column);
      			}
                if( ! empty($search_value))
      			{
					if($column=='status'){
						$alias='history';
					}else{
						$alias='ccm';
					}
					$multiple_search .= " AND ";
					$multiple_search .= "{$alias}.{$column}='$search_value'";
					
      			}
      		}
      	}
		if(!empty($search['value'])){
			$assets = explode('-',$search['value']);
			$assetsID = $assets[0];
			
			if($assetsID=="23")
			{
				$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
			}else if($assetsID=="24")
			{
				$multiple_search .="and ccm.ccm_sub_asset_type_id = '{$assetsID}'";
			}else if($assetsID=="25")
			{
				$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
			}
			else if($assetsID=="26")
			{
				$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
			}
			else if($assetsID=="27")
			{
				$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
			}
			else if($assetsID=="33")
			{
				$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
			}
			else if($assetsID=="1"){
				$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
			}
			else if($assetsID=="21"){
				$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
			}
		}else{
			$assetsID = "1";
			$multiple_search .="and assetTypes.parent_id = '1'";
		}
		//print_r($this->session);
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}else{
			//$multiple_search .=" and storecode='{$this -> session -> Province}'";
			if($columns[1]['search']['value']==4 && $this->session->UserLevel=='2' && $distcodetest > 0){
			$multiple_search .="and CAST(storecode AS VARCHAR(3)) = '{$distcodetest}'";
			}
			else{
		
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$this -> session -> Province}'";
			}
			
		}
		$col = 0;
        $dir = "";
		//print_r($multiple_search);exit;
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
		if( $this->session->UserLevel == '3' && $this->session->utype == 'DEO' )
		{
			$columns_valid = array(
				"serial",
				"warehouse_type_id",
				"ccm_make_id",
				"ccm_model_id",
				"quantity",
				"net_capacity_20",
				"status",
				"short_name",
                "storecode",
				"ccm_user_asset_id",
				"warehouse_type_name",
				"source_id",				
				//"created_date"
			);
		}
		else
		{
			$columns_valid = array(
				"serial",
				"distcode",
				"warehouse_type_id",
				"ccm_make_id",
				"ccm_model_id",
				"quantity",
				"net_capacity_20",
				"status",
				"short_name",
				"storecode",
				"ccm_user_asset_id",
				"warehouse_type_name",
				"source_id",
				//"created_date"
			);
		}
		 if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 5) {
            $order = " order by created_date ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }
		//print_r($multiple_search);exit;
		$datalist = $this -> Coldchain_model -> coldchainlist($start,$length,$order,$dir,$multiple_search,$assetsID);
		$formeditlink="refrigeratorEdit";
		$formlink = "refrigeratorView";
		if(!empty($search['value'])){
			if($assetsID=="1"){
				$formlink = "refrigeratorView";
				$formeditlink = "refrigeratorEdit";
			}else if($assetsID=="21"){
				$formlink = "coldroomView";
				$formeditlink = "coldroomEdit";
			}else if($assetsID=="23"){
				$formlink = "voltageRegulatorView";
				$formeditlink = "voltageRegulatorEdit";
			}else if($assetsID=="24"){
				$formlink = "generatorView";
				$formeditlink = "generatorEdit";
			}else if($assetsID=="25"){
				$formlink = "transportView";
				$formeditlink = "transportEdit";
			}else if($assetsID=="26"){
				$formlink = "vaccineCarriersView";
				$formeditlink = "vaccineCarriersEdit";
			}else if($assetsID=="27"){
				$formlink = "refrigeratorView";
				$formeditlink = "refrigeratorEdit";
			}else if($assetsID=="33"){
				$formlink = "coldBoxView";
				$formeditlink = "coldBoxEdit";
			}else{
				$formlink = "refrigeratorView";
				$formeditlink = "refrigeratorEdit";
				
			}
		} 
		//print_r($formlink);exit;
		$data=array();
		$i=$start+1;
		foreach($datalist['data'] as $r)
		{
			if($this->session->UserLevel=='3' && $this->session->utype=='DEO'){
				$data[] = array(
					"serial" => $i,
					"id" => $r['id'],
					"ccm_user_asset_id" => $r['ccm_user_asset_id'],
					"warehouse_type_name" =>$r['stroe_level'],
					"storecode" =>$r['storecode'],
					"warehouse_type_id" =>$r['storename'],
					"ccm_make_id" => $r['make_name'],	
					"ccm_model_id" =>$r['model_name'],
					"quantity" =>$r['quantity'],
					"net_capacity_20" => $r['capacity'],
					"source_id" => getSourceSupply($r['source_id'],TRUE),
					"status" => getWorkingstatus($r['status'],TRUE),
					"short_name" => $r['short_name'],
					//"created_date" => $r['created_date'],
					"formlink" => $formlink,
					"formeditlink"=>$formeditlink,
					"storetype" =>$r['warehouse_type_id']
					//"used_by_stock" =>$r['used_by_stock']
					
				);
			}
			else
			{
				$data[] = array(
					"serial" => $i,
					"id" => $r['id'],
					"ccm_user_asset_id" => $r['ccm_user_asset_id'],
					"warehouse_type_name" =>$r['stroe_level'],
					"storecode" =>$r['storecode'],
					"district" => $r['district'],
					"warehouse_type_id" =>$r['storename'],
					"ccm_make_id" => $r['make_name'],	
					"ccm_model_id" =>$r['model_name'],
					"quantity" =>$r['quantity'],
					"net_capacity_20" => $r['capacity'],
					"source_id" => getSourceSupply($r['source_id'],TRUE),
					"status" => getWorkingstatus($r['status'],TRUE),
					"short_name" => $r['short_name'],
					//"created_date" => $r['created_date'],
					"formlink" => $formlink,
					"formeditlink"=>$formeditlink,	
					"storetype" =>$r['warehouse_type_id']
					//"used_by_stock" =>$r['used_by_stock']
					
				);
			}
			$i++;
		}
		//print_r($data);exit;
		$patient_total = $this->Coldchain_model->coldchaintotal($multiple_search,$assetsID);   
		$output = array(
			"draw" => $draw,
			"recordsTotal" =>$patient_total,
			"recordsFiltered" => $patient_total,
			"data" => $data
		);
		echo json_encode($output);
	}
	/*	Author 			:	Omer Butt
		Description		:	Function To show store Location on Transfer click Modal 
	*/
	public function transferModal()
	{
		$data['offset']="Yes";
		$assetid = $this->input->get("assetid");
		$assetsID = $this->input->get("assetsID");
		$coldcahin_name = $this->input->get("coldcahin_name");
		$_currentdate  = date('Y-m-d');
		$distcode=$this -> session -> District;
		$tcode=$this -> session -> Tehsil;
		$multiple_search="";
		if($assetsID=="23")
		{
			$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
		}else if($assetsID=="24")
		{
			$multiple_search .="and ccm.ccm_sub_asset_type_id = '{$assetsID}'";
		}else if($assetsID=="25")
		{
			$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
		}
		else if($assetsID=="26")
		{
			$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
		}
		else if($assetsID=="27")
		{
			$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
		}
		else if($assetsID=="33")
		{
			$multiple_search .="and assetTypes.pk_id = '{$assetsID}'";
		}
		else if($assetsID=="1"){
			$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
		}
		else if($assetsID=="21"){
			$multiple_search .="and assetTypes.parent_id = '{$assetsID}'";
		}
		if($this->session->District && $this->session->utype=='DEO'){
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$distcode}'";
	    }elseif($this->session->Tehsil){
			$multiple_search .=" and CAST(ccm.storecode AS VARCHAR(6)) = '{$tcode}'";
		}else{
			$multiple_search .=" and CAST(storecode AS VARCHAR(3)) = '{$this -> session -> Province}'";	
		}
		//print_r($assetid); exit; 
		if($this->session->Tehsil){
			$tehsil=$this->session->Tehsil;
			$tcode="and ccm.tcode='$tehsil'";
		}else{
			$tcode='';
		}
		$procode = $this->session->Province;
		$get_usedstock = "SELECT get_stored_quantity_litters('{$assetid}','{$_currentdate}',cast(ccm.warehouse_type_id as varchar(15)),cast(storecode as varchar(15))) as used_by_stock 
		FROM epi_cc_coldchain_main ccm JOIN epi_cc_asset_types assetTypes ON assetTypes.pk_id = ccm.ccm_sub_asset_type_id  WHERE ccm.procode = '{$procode}' {$multiple_search} and asset_status ='Active' and asset_id=$assetid $tcode";
		$usedstock = $this -> db -> query($get_usedstock);
		$used_by_stock =	$usedstock -> row_array();
		if($used_by_stock['used_by_stock']>0){
			$assetname = rtrim($coldcahin_name,"_list");
			$location = base_url(). "Coldchain/$coldcahin_name/$assetsID";
			echo '<script language="javascript" type="text/javascript"> alert("You cannot Transfer Asset because stock exists on this '.$assetname.'.");	window.location="'.$location.'"</script>';
		}else{ 
			$coldChainQuery = "SELECT ccm.asset_id,warehousetypename(ccm.warehouse_type_id) as stroe_level,get_store_name(ccm.warehouse_type_id,CAST(storecode AS VARCHAR(9))) as storename,ccm.ccm_user_asset_id,makername(md.ccm_make_id) as make_name,ccm.ccm_sub_asset_type_id
			FROM epi_cc_coldchain_main ccm
			JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 		
			where asset_id=$assetid";
			$coldChainResult = $this -> db -> query($coldChainQuery);
			$data['data'] =	$coldChainResult -> result_array();
			//print_r($coldChainQuery); exit;
			$data['transferModal'] = $this -> load -> view('coldchain/add_forms/storesSection', $data,true);
			echo $data['transferModal'];
		}
	}
	public function statusModal()
	{
		//$data1['offset']="Yes";
		$assetid = $this->input->post("assetid");
		$coldChainQuery = "SELECT ccm.asset_id,ccm.status,ccm.warehouse_type_id,ccm.procode,ccm.distcode,ccm.tcode,ccm.uncode,ccm.facode,ccm.ccm_sub_asset_type_id,history.assets_type_id,history.ccm_id
		FROM epi_cc_coldchain_main ccm join
        epi_cc_asset_status_history	history ON history.pk_id = ccm.ccm_status_history_id
		where ccm.asset_id=$assetid";
		//echo $coldChainQuery; exit; 
		$coldChainResult = $this -> db -> query($coldChainQuery);
		$data['data'] =	$coldChainResult -> result_array();	
		$data['statusModal'] = $this -> load -> view('coldchain/add_forms/storesStatus',$data,true);

		echo $data['statusModal'];
	}
	public function status(){
		//$update_array = array();

		if($this->input->post('status') !="" && $this->input->post('utilizations') !="" && $this->input->post('reasons') !="" && $this->input->post('status_date') !="")
		{ 
		$asset_id = $this->input->post('asset_id');  
		$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');  
		$reasons = ($this->input->post('reasons')!='')?$this->input->post('reasons'):0;
		$utilizations = ($this->input->post('utilizations')!='')?$this->input->post('utilizations'):0;
		$warehouse_type_id = $this->input->post('warehouse_type_id');
		$distcode = ($this->input->post('distcode') != 0)?$this->input->post('distcode'):NULL;
		$tcode = ($this->input->post('tcode') != 0)?$this->input->post('tcode'):NULL;
		$uncode = ($this->input->post('uncode') != 0)?$this->input->post('uncode') :NULL;
		$facode = ($this->input->post('facode') != 0)?$this->input->post('facode'):NULL;
	    $update_array = array( 
		        'warehouse_type_id' => $warehouse_type_id,
		        'status' 			=> ($this->input->post('status')!='')?$this->input->post('status'):0,
				'assets_type_id' 	=> $ccm_sub_asset_type_id,
				'reasons' 	        => $reasons,
				'utilizations' 	    => $utilizations,
				'ccm_id' 	        => $asset_id,
				'status_date' 	    =>  $this->input->post('status_date'),

				'description' 	    =>  $this->input->post('description'),
				'procode' 			=> $this -> session -> Province,
				'distcode' 			=> $distcode,
				'tcode' 			=> $tcode,
				'uncode' 			=> $uncode,
				'facode'			=> $facode
			);
		//print_r($update_array); exit();
		$history_id=$this -> Common_model -> insert_record('epi_cc_asset_status_history',$update_array);

		$coldChainData['status']=($_POST['status']);
		$coldChainData['asset_id']=($_POST['asset_id']); 
		$this -> Common_model -> update_record('epi_cc_coldchain_main',array('status'=>$coldChainData['status'],'ccm_status_history_id'=>$history_id),array('asset_id'=>$coldChainData['asset_id']));
		$output = "Successfully Status Updated";
		}else
		{ 
			$output = "Please Fill out this fields";
		}
		echo $output;
	}
	public function addmake(){
		$update_array = array();
		$dataToInsert= array();
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
		//print_r($dataToInsert); exit; 
		$update_array['make_name']=($_POST['make_name']);
		//$this -> Common_model -> insert_record('epi_cc_makes',$update_array);
		$pk_id =$this -> Common_model -> insert_record('epi_cc_makes',$update_array);
		//print_r($pk_id); 
		$id['ccm_sub_asset_type_id']=($_POST['subid']);
		$asset_type_id=$id['ccm_sub_asset_type_id'];
		$dataToInsert['ccm_make_id'] = $pk_id;
		$dataToInsert['model_name']=($_POST['model_name']);
		$dataToInsert['ccm_sub_asset_type_id']=($_POST['subid']);
		$dataToInsert['asset_type_id']=($_POST['parent_id']);
		$this -> Common_model -> insert_record('epi_cc_models',$dataToInsert);
		$wc="asset_type_id='$asset_type_id' and ccm_make_id is not null";
		//$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
		$query ="select pk_id,ccm_make_id,makername(ccm_make_id) as make_name from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$this->db->trans_complete();
		$return='<option value="">--Select--</option>';
		foreach($data['dataModel'] as $values){
			$return .='<option value="'.$values['ccm_make_id'].'">'.$values['make_name'].'</option>';
		}
		echo $return;
		}
		else
		{
			echo "required";
		}
	}
	public function addmodal(){
		$update_array = array();
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
		$update_array['model_name']=($_POST['model_name']);
		$update_array['ccm_make_id']=($_POST['make']);
		$update_array['ccm_sub_asset_type_id']=($_POST['parent_id']);  
		$update_array['asset_type_id']=($_POST['parent_id']);
		$make_id=$update_array['ccm_make_id'];
		$this -> Common_model -> insert_record('epi_cc_models',$update_array);
		$wc="ccm_make_id='$make_id' and ccm_make_id is not null";
		//$data['dataModel'] = $this-> Common_model -> fetchall('epi_cc_models',NULL,$range,$where,NULL,array('by'=>'pk_id','type'=>'ASC'));
		$query ="select pk_id,ccm_make_id,model_name from epi_cc_models where {$wc} order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$this->db->trans_complete();
		$return='<option value="">--Select--</option>';
		foreach($data['dataModel'] as $values){
			$return .='<option value="'.$values['pk_id'].'">'.$values['model_name'].'</option>';
		}
		echo $return;
		}
		else
		{
			echo "required";
		}
	}
	public function getmodelname(){
		$makeid=$this->input->get('make_name');
		$query ="select pk_id,ccm_make_id,model_name from epi_cc_models where ccm_make_id='{$makeid}' order by pk_id ASC";
		$data['dataModel'] = $this->db->query($query)->result_array();
		$this->db->trans_complete();
		$return='<option value="">--Select--</option>';
		foreach($data['dataModel'] as $values){
			$return .='<option value="'.$values['pk_id'].'">'.$values['model_name'].'</option>';
		}
		echo $return;
	}
	public function getmakename(){
		$id=$this->input->get('ccm_sub_asset_type_id');
	    $wc = "where ccm_sub_asset_type_id='$id'";
		$query="select pk_id,ccm_make_id,makername(ccm_make_id) as make_name from epi_cc_models {$wc}";
		//echo $query; exit;
		$result = $this->db->query($query)->result_array();
		$this->db->trans_complete();
		$return='<option value="">--Select--</option>';
		foreach($result as $values){
			$return .='<option value="'.$values['ccm_make_id'].'">'.$values['make_name'].'</option>';
		}
		echo $return;
		
	}
}
?>