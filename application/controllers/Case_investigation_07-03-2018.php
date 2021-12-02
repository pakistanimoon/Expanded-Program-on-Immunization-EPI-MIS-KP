<?php
class Case_investigation extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
		$this -> load -> model ('Case_investigation_model');
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
		$per_page = 30 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " case_investigation_db "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '3' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '3'";
			//$wc=" ";
		$data = $this -> Case_investigation_model -> case_investigation_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
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
		$data['years'] = getAllYearsOptionsIncludingCurrent(true);
		$data['fileToLoad'] = 'investigation_forms/case_investigation_form';
		$data['pageTitle']='Case Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function case_investigation_save(){
		//print_r($_POST);exit();
		//dataEntryValidator(0);
		//if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && ($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year'))
		if(($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year'))
		{
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
				$procode = 3;
				$distcode = $this -> session -> District;				
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$patient_address_procode = 3;
			   $patient_address_distcode = $this-> input-> post('patient_address_distcode');
			  	$patient_address_tcode = $this-> input-> post('patient_address_tcode');
			   $patient_address_uncode = $this-> input-> post('patient_address_uncode');
				$a1 = $this-> input-> post('a1');
				$a2 = $this-> input-> post('a2');
				$a3 = $this-> input-> post('a3');
				$a4 = $this-> input-> post('a4');
				$fourdigit_number = $a1.$a2.$a3.$a4;
			}
			if($this -> input -> post('edit')){				
				$editted_date = ($this-> input-> post('editted_date'))?date('Y-m-d', strtotime($this-> input-> post('editted_date'))):NULL;
			}
			$cross_notified = ($this-> input-> post('cross_notified'))?$this-> input-> post('cross_notified'):0;
		   $facode = $this-> input-> post('facode');
		   $faddress = $this-> input-> post('faddress');
		   $year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			if(!$this -> input -> post('edit') && $week < 10){
				$fweek = $year.'-0'.$week;
			}
			else{
				$fweek = $year.'-'.$week;
			}
		   $dcode = $this-> input-> post('dcode');
		   //$epid_year = $this-> input-> post('epid_year');
		  	$epid_year = $this-> input-> post('year');
		   $patient_name = $this-> input-> post('patient_name');
		   $patient_fathername = $this-> input-> post('patient_fathername');
		   $patient_gender = $this-> input-> post('patient_gender');
		   $contact_numb = $this-> input-> post('contact_numb');
		   $age_months = ($this-> input-> post('age_months'))?$this-> input-> post('age_months'):0;
		   // $patient_address_procode = 3;
		   $other_pro_district = $this-> input-> post('other_pro_district');
		   $other_pro_tehsil = $this-> input-> post('other_pro_tehsil');
		   $other_pro_uc = $this-> input-> post('other_pro_uc');
		   $patient_address = $this-> input-> post('patient_address');
		   $case_type = $this-> input-> post('case_type');		   
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
		   $th_distcode = $this-> input-> post('th_distcode');
		   $th_tcode = $this-> input-> post('th_tcode');
		   $th_uncode = $this-> input-> post('th_uncode');
		   $th_province = $this-> input-> post('th_province');
		   $th_district = $this-> input-> post('th_district');
		   $th_tehsil = $this-> input-> post('th_tehsil');
		   $th_uc = $this-> input-> post('th_uc');		   
		   $th_muhallah = $this-> input-> post('th_muhallah');
		   $type_specimen = $this-> input-> post('type_specimen');
		   $other_specimen = $this-> input-> post('other_specimen');
		   $labresult_tobesentto = $this-> input-> post('labresult_tobesentto');
		   $investigator_name = $this-> input-> post('investigator_name');
		   $investigator_designation = $this-> input-> post('investigator_designation');
		   $outcome = $this-> input-> post('outcome');
		   $complication = $this-> input-> post('complication');
		   $is_temp_saved = $this-> input-> post('is_temp_saved');
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
		   $symptomlist = $this-> input-> post('clinical_representation')?$this-> input-> post('clinical_representation'):'';
		   //$case_representation=NULL;
			if(isset($symptomlist) && $symptomlist!=''){
				foreach($symptomlist as $row){
					$newlist[] = $row;
				}
				$symptoms=implode(',',$newlist);
			}
			$clinical_representation=$symptoms;
			/////////////////////////////////////////
			if($this -> input -> post('cross_notified') != 1 && $this -> input -> post('distcode')){
				//echo "KLM1";exit();
				$case_number = $fourdigit_number;
				$case_epi_no = "PAK/KP/".$dcode."/".$year."/".$case_type."/".$case_number;
				$cross_notified_from_distcode = NULL;
				$approval_status = NULL;
			}
			// else if($this -> input -> post('edit') && $this -> input -> post('facode')){
			// 	echo "KLM2";exit();
			// 	//$cross_notified_from_distcode = NULL;
			// 	$cross_notified_from_distcode = $this -> session -> District;
			// }
			else if($this -> input-> post('edit') && $this -> input-> post('cross_notified') == 1 && $this -> input-> post('id') && $this -> input-> post('case_epi_no') != ''){
				//echo "ABC";exit();
				$id = $this -> input -> post('id');
				$editApproved = "SELECT facode, distcode, procode, patient_address_procode, case_epi_no, case_number, cross_notified_from_distcode, approval_status, submitted_date from case_investigation_db where id = '$id'";
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
			else{
				//echo "KLM3";exit();
				if($this -> input -> post('edit') && $this -> input -> post('id') && $this -> input-> post('case_epi_no') == ''){
					//echo "abc";exit();
					$cross_notified_from_distcode = $this -> session -> District;
					$approval_status= "Pending";
					$case_epi_no= NULL;
					$case_number= 0;
				}
				if(!$this -> input -> post('edit') && !$this -> input -> post('id')){
					//echo "abc";exit();
					$cross_notified_from_distcode = $this -> session -> District;
					$approval_status= "Pending";
				}
			} 
			////////////////////////////////////////

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
			   'other_pro_district' => $other_pro_district,
		   	'other_pro_tehsil' => $other_pro_tehsil,
		   	'other_pro_uc' => $other_pro_uc,
			   'rb_distcode' => $rb_distcode,
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
			   'investigator_name' => $investigator_name,
			   'investigator_designation' => $investigator_designation,
			   'outcome' => $outcome,
			   'complication' => $complication,
			   'is_temp_saved' => $is_temp_saved,
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
			   'editted_date' => (isset($editted_date) AND $editted_date != '')?$editted_date:NULL
			);

			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{	
				$id = $this -> input -> post('id'); 
				//print_r($DataArray);exit();
				$updated_id = $this -> Common_model -> update_record('case_investigation_db',$DataArray,array('id' => $id/*,'distcode' => $DataArray['distcode']*/));
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Case_investigation/case_investigation_list');
			}
			else{
				$inserted_id = $this -> Common_model -> insert_record('case_investigation_db',$DataArray);
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
		dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "SELECT epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['case_number'] = $this -> input -> post('case_number');
			$data['approval_status'] = "Approved";
			$updated_id = $this -> Common_model -> update_record('case_investigation_db',$data,array('id' => $this->input->post('id')));
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Case_investigation/case_investigation_list');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}	
	
	public function case_investigation_edit(){
		dataEntryValidator(0);
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
			//print_r($data);exit;
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
	
}
?>