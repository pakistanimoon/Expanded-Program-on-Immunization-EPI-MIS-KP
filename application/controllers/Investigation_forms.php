<?php
//KP
class Investigation_forms extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		$this -> load -> helper('cross_notify_functions_helper');
		//authentication();
		$this -> load -> model ('Investigation_forms_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	////////////////////////// FIRST Function ///////////////////////////////////////////////

	public function nnt_investigation(){
		$data['data']=$this -> Investigation_forms_model -> nnt_investigation();
		$wc = getWC();
		/*
		$data['year']=$year = substr(strip_tags($number), 0,2);
				$year = date('Y');
				$data['month']=$month;
				$data['year']=$year = substr(strip_tags($number), 0,2);
				$data['month']=$month = substr($number, 0,2);*/
		$data['years'] = getEpiWeekYearsOptions('',true);
		$distcode = $this -> session -> District;
		$data['fileToLoad'] = 'investigation_forms/nnt_investigation_form';
		$data['pageTitle']='NNT Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function nnt_investigation_Save(){
		//print_r($_POST);exit();
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
		$baseUrl = base_url();	
     	//dataEntryValidator(0);
		/////////By usama for federal sync
		$doses_received= $this -> input -> post('doses_received');
		$patient_gender= $this -> input -> post('gender');
		$case_type = 'Nnt';
		if($patient_gender == 'Male'){
			$gender = 1;
		}else{
			$gender = 0;
		}
		if($doses_received > 2 ){
			$doses_received = 99;
		}else{
			$doses_received = $this -> input -> post('doses_received');
		}
		/////End//
		if(($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year')){			
			$data=$_POST;
			//$data['procode']=$_SESSION["Province"];
			//$data['distcode']=$this -> session -> District;			
			$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			$data['week'] = sprintf("%02d",$week);
			$data['fweek'] = $year."-".sprintf("%02d",$week);
			//$data['patient_address_procode']=$_SESSION["Province"];
			if($this -> input -> post('cross_notified') == 1){
				$data['procode'] = $procode = $this -> input -> post('procode');
				$data['nnt_procode'] = $this -> input -> post('procode');
				$data['distcode'] = $this -> input -> post('nnt_distcode');
				$data['tcode'] = $this -> input -> post('nnt_tcode');
				$data['uncode'] = $this -> input -> post('nnt_uncode');				
			}
			if(!$this -> input -> post('cross_notified')){
				$data['procode'] = $procode = $_SESSION["Province"];
				
			}
			else{
				if(!$this -> input -> post('edit') && !$this -> input -> post('id'))
				{
					$data['procode'] = $procode = $this -> input -> post('procode');
					$data['cross_notified_from_distcode'] = $this -> session -> District;
					$data['approval_status'] = "Pending";					
				}
			}
			$query = "SELECT max(cn_id_from) AS cn_id_from FROM nnt_investigation_form";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$cn_id_from = $result['cn_id_from'] + 1; 
			//echo '<pre>'; print_r($data); exit;	
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{ 
				//echo "a"; exit();
				//print_r($data);exit();
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				// $query = "SELECT approval_status FROM nnt_investigation_form where id=$id";
				// $result = $this -> db -> query($query);
				// $result = $result -> row_array();
				// $data['approval_status'] = $approval_status = $result['approval_status'];

				$updated_id = $this -> Common_model -> update_record('nnt_investigation_form',$data,array('id' => $id));
				if(($procode != $_SESSION["Province"]) || ($approval_status == 'Approved')){
					//echo "b"; exit();
					$data['edit'] = $edit = $this -> input -> post('edit');
					$filepath = 'Investigation_forms/nnt_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $data);
				}
				if($this -> input -> post('cross_notified') != 1){
					syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$gender);
				}
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('NNT-CIF/List');
			}
			else{
				if($this -> input -> post('cross_notified') == 1 && !$this -> input -> post('cross_case_id')){
					//echo "a";exit();
					$rcode = $this -> session -> District;
					$distcode = $this -> input -> post('nnt_distcode');
					$data['cross_case_id'] = $cross_case_id = $rcode.'-'.$distcode.'-'.$cn_id_from;
				}
				else if($this -> input -> post('cross_notified') == 1 && $this -> input -> post('cross_case_id')){
					//echo "b";exit();
					$data['cross_case_id'] =$this -> input -> post('cross_case_id');
				}
				else{
					//echo "c";exit();
					$data['cross_case_id'] = NULL;
				}				
				$inserted_id = $this -> Common_model -> insert_record('nnt_investigation_form',$data);
				$query = "SELECT max(id) AS id FROM nnt_investigation_form";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				$data['cn_id_to'] = $cn_id_to = $result['id'];
				if($procode != $_SESSION["Province"]){
					$filepath = 'Investigation_forms/nnt_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode); //echo "a";exit();
					$dataMeasles = $this -> getDataToSave($url, $filepath, $data); //echo "b";exit();
				}
				if($this -> input -> post('cross_notified') != 1){
					//echo'test'; exit;
					syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('NNT-CIF/List');				
			}
		}
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council and Facility!!');
			redirect('NNT-CIF/Add');
		}
	}
	public function nnt_receive_and_save(){
		//print_r($_POST);exit();	
     	//dataEntryValidator(0);
		if($this -> input -> post('cross_notified') && $this -> input -> post('year')){			
			$data=$_POST;	
			$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			$data['week'] = sprintf("%02d",$week);
			$data['fweek'] = $year."-".sprintf("%02d",$week);
			//$data['patient_address_procode']=$_SESSION["Province"];
			if($this -> input -> post('cross_notified') == 1){
				$data['procode'] = $procode = $this -> input -> post('procode');
				$data['nnt_procode'] = $this -> input -> post('procode');
				$data['distcode'] = $this -> input -> post('nnt_distcode');
				$data['tcode'] = $this -> input -> post('nnt_tcode');
				$data['uncode'] = $this -> input -> post('nnt_uncode');				
			}
			if(!$this -> input -> post('cross_notified')){
				$data['procode'] = $procode = $_SESSION["Province"];				
			}
			else{
				if(!$this -> input -> post('edit') && !$this -> input -> post('id'))
				{
					//$data['procode'] = $procode = $this -> input -> post('procode');
					$data['cross_notified_from_distcode'] = $this -> input -> post('rb_distcode');
					$data['approval_status'] = "Pending";					
				}
			}
			$query = "SELECT max(cn_id_from) AS cn_id_from FROM nnt_investigation_form";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$cn_id_from = $result['cn_id_from'] + 1; 
			//echo '<pre>'; print_r($data); exit;	
			if($this -> input -> post('edit') && $this -> input -> post('cross_case_id'))
			{ 
				//$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				$cross_case_id = $this -> input -> post('cross_case_id');
				//$updated_id = $this -> Common_model -> update_record('nnt_investigation_form',$data,array('id' => $id));
				$updated_id = $this -> Common_model -> update_record('nnt_investigation_form',$data,array('cross_case_id' => $cross_case_id));
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('NNT-CIF/List');
			}
			else{				
				$inserted_id = $this -> Common_model -> insert_record('nnt_investigation_form',$data);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('NNT-CIF/List');				
			}
		}
		else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council and Facility!!');
			redirect('NNT-CIF/Add');
		}
	}
	public function nnt_Approve(){
		//print_r($_POST);exit();
		//dataEntryValidator(0);
		/////parameter for sync by usama /////
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('week');
		$case_type = 'Nnt';
		$sdistcode = $this -> input -> post('distcode');
		$patient_gender = $this -> input -> post('gender');
		$doses_received = $this -> input -> post('doses_received');
		if($patient_gender == 'Male'){
			$gender = '1';
		}else{
			$gender = '0';
		}
		if($doses_received > 2 ){
			$doses_received = 99;
		}else{
			$doses_received = $this -> input -> post('doses_received');
		}
		//////////end
		if($this -> input -> post('facode')>0 ){
			$distcode = $this -> session -> District;
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['nnt_uncode'] = $this -> input -> post('uncode');
			$data['nnt_tcode'] = $this -> input -> post('tcode');
			$data['cross_case_id'] = $this -> input -> post('cross_case_id');
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('nnt_investigation_form',$data,array('id' => $this-> input-> post('id')));
			syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$sdistcode,$doses_received,$gender);
			if($procode != $_SESSION["Province"]){
				$filepath = 'Investigation_forms/nntApprove_and_save'; 
				$url = $this -> getSingleRegionUrl($procode); 
				$dataMeasles = $this -> getDataToSave($url, $filepath,$data); 
			}
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('NNT-CIF/List');
		}
		else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	public function nntApprove_and_save(){
		//dataEntryValidator(0);
		if($this -> input -> post('facode')>0){
			$distcode = $this -> session -> District;
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['nnt_uncode'] = $this -> input -> post('uncode');
			$data['nnt_tcode'] = $this -> input -> post('tcode');
			$data['cross_case_id'] = $this -> input -> post('cross_case_id');
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('nnt_investigation_form',$data,array('cross_case_id' => $this-> input-> post('cross_case_id')));			
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('NNT-CIF/List');
		}
		else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	public function nnt_investigation_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " nnt_investigation_form "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Investigation_forms_model -> nnt_investigation_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/nnt_investigation_list';
			$data['pageTitle']='NNT Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function nnt_investigation_edit(){
		//dataEntryValidator(0);
		$distcode = $this -> session -> District;
		$query = "select distcode from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['distcode'];
		$id = ($this -> uri -> segment(4) != '')?$this -> uri -> segment(4):$this -> uri -> segment(3);
		$data['nntForm_Result'] = $this -> Common_model -> get_info('nnt_investigation_form', '', '','*', array('id' => $id));		
		$data['tehsil']=get_Tehsil_Name($data['nntForm_Result']->tcode);
		$data['unioncouncil']=get_UC_Name($data['nntForm_Result']->uncode);
		$data['facility']=get_Facility_Name($data['nntForm_Result']->facode);
		$data['nnt_facility']=get_Facility_Name($data['nntForm_Result']->nnt_facode);
		$data['rbfacility']=get_Facility_Name($data['nntForm_Result']->rb_facode);
		// $data['placeInvestigation_facility']=get_Facility_Name($data['nntForm_Result']->place_investigation_facode);
		// $data['facode1']=get_Facility_Name($data['nntForm_Result']->facode1);
		// $data['facode2']=get_Facility_Name($data['nntForm_Result']->facode2);
		// $data['facode3']=get_Facility_Name($data['nntForm_Result']->facode3);
		//print_r($data);exit;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/nnt_investigation_form';
			$data['pageTitle']='NNT Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function nnt_investigation_view(){
		//dataEntryValidator(0);
		//$id   = $this -> uri -> segment(3);
		//$data['a'] = $this -> Common_model -> get_info('nnt_investigation_form', '', '','*', array('id' => $id));
		if($this -> uri -> segment(4) != ''){
			$facode = $this -> uri -> segment(3);
			$id   = $this -> uri -> segment(4);
			$data['a'] = $this -> Common_model -> get_info('nnt_investigation_form', '', '','*', array('id' => $id, 'facode' => $facode));
		}
		else{
			$id   = $this -> uri -> segment(3);
			$data['a'] = $this -> Common_model -> get_info('nnt_investigation_form', '', '','*', array('id' => $id));
		}
		//print_r($data['a']);exit();
		/*$data['unioncouncil']=get_UC_Name($data['a']->nnt_uncode);
		$data['facility']=get_Facility_Name($data['a']->nnt_facode);
		$data['tehsil']=get_Tehsil_Name($data['a']->nnt_tcode);
		$data['distcode']=get_District_Name($data['a']->nnt_distcode);*/
		//print_r($data['a']);exit();
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/nnt_investigation_form_view';
			$data['pageTitle']='NNT Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page."; 
			$this -> load -> view ('message',$data);
		}
	}
	//-----------------------------AEFI Case Investigation-------------------------------//
	//-----------------------------------------------------------------------------------//	
	public function aefi_investigation(){
		//$data['data']=$this -> Investigation_forms_model -> aefi_investigation();
		$distcode = $this -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code']; 	
		$dcode=$result['epid_code'];
		$year = date('Y');
		$query = "SELECT max(aefi_number) as aefi_number from aefi_case_investigation_form where year='$year' AND dcode='$dcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['aefiNumber'] = str_split(sprintf('%04u', ($result['aefi_number'] + 1)));
		$data['fileToLoad'] = 'investigation_forms/aefi_investigation_form';	
		$data['pageTitle']='AEFI Investigation Form | EPI-MIS';		
		$data['data'] = $data;
		$this->load->view('template/epi_template',$data);	
	}
	public function aefi_investigation_Save(){
		dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && $this -> input -> post('facode') && $this -> input -> post('year')){
		
		/*
		$data=$_POST;
				
				foreach($data as $key => $value)
				{
					if($value=='')
					{
						$data[$key] = NULL;
					}
					/*
					if (strpos($key, 'f3') !== false) {
						$data[$key]=date('Y-m-d',strtotime(($this -> input -> post($key))?$this -> input -> post($key):NULL));
					}
					
				} 
				$data['date_reported']=($this -> input -> post('date_reported'))?date('Y-m-d',strtotime($this -> input -> post('date_reported'))):NULL;
				$data['date_investigation_started']=($this -> input -> post('date_investigation_started'))?date('Y-m-d',strtotime($this -> input -> post('date_investigation_started'))):NULL;
				$data['dob']=($this -> input -> post('dob'))?date('Y-m-d',strtotime($this -> input -> post('dob'))):NULL;
				$data['datetime_vaccination']=($this -> input -> post('datetime_vaccination'))?date('Y-m-d',strtotime($this -> input -> post('datetime_vaccination'))):NULL;
				$data['date_onset']=($this -> input -> post('date_onset'))?date('Y-m-d',strtotime($this -> input -> post('date_onset'))):NULL;
				$data['date_hospitalization']=($this -> input -> post('date_hospitalization'))?date('Y-m-d',strtotime($this -> input -> post('date_hospitalization'))):NULL;
				$data['date_death']=($this -> input -> post('date_death'))?date('Y-m-d',strtotime($this -> input -> post('date_death'))):NULL;
				$data['date_investigation_completed']=($this -> input -> post('date_investigation_completed'))?date('Y-m-d',strtotime($this -> input -> post('date_investigation_completed'))):NULL;
		*/
		$data=array();
  		$formats = array("d-m-Y","m-d-Y");
  		foreach($_POST as $key => $value)
  		{
		   $data[$key] = ($value=='')?NULL:$value;//($value=='1')?1:(($value=='')?'0':$value);
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
		$data['procode']=$_SESSION["Province"];
		$data['pe_f1']=($this -> input -> post('pe_f1'))?$this -> input -> post('pe_f1'):0;
		$data['pe_f2']=($this -> input -> post('pe_f2'))?$this -> input -> post('pe_f2'):0;
		$data['pe_f3']=($this -> input -> post('pe_f3'))?$this -> input -> post('pe_f3'):0; 
		$data['pe_f4']=($this -> input -> post('pe_f4'))?$this -> input -> post('pe_f4'):0;
		$data['pe_f5']=($this -> input -> post('pe_f5'))?$this -> input -> post('pe_f5'):0;
		$data['pe_f6']=($this -> input -> post('pe_f6'))?$this -> input -> post('pe_f6'):0;
		$data['vcr_f1']=($this -> input -> post('vcr_f1'))?$this -> input -> post('vcr_f1'):0;
		$data['vcr_f2']=($this -> input -> post('vcr_f2'))?$this -> input -> post('vcr_f2'):0;
		$data['vcr_f3']=($this -> input -> post('vcr_f3'))?$this -> input -> post('vcr_f3'):0;
		$data['coincidental']=($this -> input -> post('coincidental'))?$this -> input -> post('coincidental'):0;
		$data['inj_reaction']=($this -> input -> post('inj_reaction'))?$this -> input -> post('inj_reaction'):0;
		$data['unknown']=($this -> input -> post('unknown'))?$this -> input -> post('unknown'):0;
		$data['pulse']=($this -> input -> post('pulse'))?$this -> input -> post('pulse'):0;
		$data['temp']=($this -> input -> post('temp'))?$this -> input -> post('temp'):0;
		$data['bp']=($this -> input -> post('bp'))?$this -> input -> post('bp'):0;
		$data['heart_rate']=($this -> input -> post('heart_rate'))?$this -> input -> post('heart_rate'):0;
		$data['resp_rate']=($this -> input -> post('resp_rate'))?$this -> input -> post('resp_rate'):0;
		$data['time_onset'] = ($this -> input -> post('time_onset'))?date('H:i',strtotime($this -> input -> post('time_onset'))):NULL;
		$data['time_hospitalization'] = ($this -> input -> post('time_hospitalization'))?date('H:i',strtotime($this -> input -> post('time_hospitalization'))):NULL;
		$data['time_death'] = ($this -> input -> post('time_death'))?date('H:i',strtotime($this -> input -> post('time_death'))):NULL;
		$data['dcode']=(is_numeric($this -> input -> post('dcode')))?$this -> input -> post('dcode'):0;
		$data['year']=(is_numeric($this -> input -> post('year')))?$this -> input -> post('year'):0;
		////////////////////////////////////AEFI NUMBER//////////////////////////////////////////////////////////
		$data['case_epi_no'] = "PAK/".$_SESSION["shortname"]."/".$this -> input -> post('dcode')."/".$this -> input -> post('year')."/AEFI/".$this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');
		$data['aefi_number'] = $this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');
		unset($data['a1']);unset($data['a2']);unset($data['a3']);unset($data['a4']);
		if($this -> input -> post('edit') && $this -> input -> post('id'))
			{
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				$updated_id = $this -> Common_model -> update_record('aefi_case_investigation_form',$data,array('id' => $id));
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('AEFI-CIF/List');
			}else{
				$inserted_id = $this -> Common_model -> insert_record('aefi_case_investigation_form',$data);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('AEFI-CIF/List');
			}
		}else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('AEFI-CIF/Add');
		}
	}
	public function aefi_investigation_list(){
		dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " aefi_case_investigation_form "; // Change `records` according to your table name.
		//$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Investigation_forms_model -> aefi_investigation_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/aefi_investigation_list';
			$data['pageTitle']='AEFI Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function aefi_investigation_edit(){
		dataEntryValidator(0);
		$distcode = $this -> session -> District;
		$query = "select distcode from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['distcode'];
		$id   = $this -> uri -> segment(3);
		$data['aefiForm_Result'] = $this -> Common_model -> get_info('aefi_case_investigation_form', '', '','*', array('id' => $id));
		$data['aefiNumber'] = str_split(sprintf('%04u', ($data['aefiForm_Result']->aefi_number)));	
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/aefi_investigation_form';
			$data['pageTitle']='AEFI Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page."; 
			$this -> load -> view ('message',$data);
		}
	}
	public function aefi_investigation_view(){
		$id   = $this -> uri -> segment(3);
		$data['a'] = $this -> Common_model -> get_info('aefi_case_investigation_form', '', '','*', array('id' => $id));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/aefi_investigation_form_view';
			$data['pageTitle']='AEFI Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}

	//-----------------------------Measles Case Investigation---------------------------------//
	//----------------------------------------------------------------------------------------//
	public function measles_case_investigation(){
		$data['data']=$this -> Investigation_forms_model -> measles_case_investigation(); 
		$distcode = $this -> session -> District;
		$query = "select epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		$year = date('Y');
		$query = "select max(measles_number) as measles_number from measle_case_investigation where year='$year' AND dcode='$dcode'";
		$result = $this -> db -> query($query);        
		$result = $result -> row_array();
		$data['measleNumber'] = str_split(sprintf('%04u', ($result['measles_number'] + 1)));
		$data['years'] = getEpiWeekYearsOptions('',true);
		//$data['years'] = getAllYearsOptionsIncludingCurrent(true);
		$data['fileToLoad'] = 'investigation_forms/measles_case_investigation_form';
		$data['pageTitle']='Measles Case Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function measles_Save(){
		dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && ($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year'))
		{
			$data=$_POST;
			$data['procode']=$_SESSION["Province"];
			$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
			{
				$data[$key] = (($value=='')?NULL:(($value == 'on')?1:$value));
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
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			$data['epid_year'] = $year;
			$data['week'] = sprintf("%02d",$week);
			$data['fweek'] = $year."-".sprintf("%02d",$week);
			$data['patient_address_procode']=$_SESSION["Province"];
			if(!$this -> input -> post('cross_notified')){
				$data['case_epi_no'] = "PAK/".$_SESSION["shortname"]."/".$this -> input -> post('dcode')."/".$this -> input -> post('year')."/Msl/".$this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');			
				$data['measles_number'] = $this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');
			}else{
				if(!$this -> input -> post('edit') && !$this -> input -> post('id')){
					$data['cross_notified_from_distcode'] = $this -> session -> District;
					$data['approval_status'] = "Pending";
				}
			} 
			unset($data['a1']);unset($data['a2']);unset($data['a3']);unset($data['a4']);
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{	
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				$updated_id = $this -> Common_model -> update_record('measle_case_investigation',$data,array('id' => $id,'distcode' => $data['distcode']));
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Measles-CIF/List');
			}else{
				/* $facode=($this -> input -> post('cross_notified'))?$this->input->post('rb_facode'):$this->input->post('facode');
				$resultOfCount = $this -> Investigation_forms_model -> checkForExcessiveReocord($facode,'malaria',$data['fweek']);
				if($resultOfCount != 1)
				{ */
					$inserted_id = $this -> Common_model -> insert_record('measle_case_investigation',$data);
					$this -> session -> set_flashdata('message','You have successfully saved your record!');
					redirect('Measles-CIF/List');
				/* }
				else
				{
					$this -> session -> set_flashdata('message','Sorry...You are entering excessive records!');
					redirect('Measles-CIF/List');
				} */
			}
		}else{
				$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
				redirect('Measles-CIF/Add');
			}
	}
	public function measles_Approve(){
		dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "select epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['measles_number'] = $this -> input -> post('measles_number');
			$data['approval_status'] = "Approved";
			$updated_id = $this -> Common_model -> update_record('measle_case_investigation',$data,array('id' => $this->input->post('id')));
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Measles-CIF/List');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	public function measles_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " measle_case_investigation "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Investigation_forms_model -> measles_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/measles_case_investigation_list';
			$data['pageTitle']='Measles Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function measles_edit(){
		dataEntryValidator(0);
		//$facode = $this -> uri -> segment(3);
		$distcode = $this -> session -> District;
		$query = "select epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		$year = date('Y');
		
		$id   = ($this -> uri -> segment(4) != '')?$this -> uri -> segment(4):$this -> uri -> segment(3);
		$data['measles_Result'] = $this -> Common_model -> get_info('measle_case_investigation', '', '','*', array('id' => $id));
		if($data['measles_Result']->case_reported == 0){
			$query = "select max(measles_number) as measles_number from measle_case_investigation where epid_year='$year' AND dcode='$dcode'";
			$result = $this -> db -> query($query);        
			$result = $result -> row_array();
			$data['measleNumber'] = str_split(sprintf('%04u', ($result['measles_number'] + 1)));
		}else
			$data['measleNumber'] = str_split(sprintf('%04u', ($data['measles_Result']->measles_number)));	
		//$data['measles_Result'] = $this -> Common_model -> get_info('measle_case_investigation', '', '','*', array('id' => $id, 'facode' => $facode));
		$data['unioncouncil']=get_UC_Name($data['measles_Result']->uncode);
		$data['facility']=get_Facility_Name($data['measles_Result']->facode);
		$data['tehsil']=get_Tehsil_Name($data['measles_Result']->tcode);
		$data['rbfacility']=get_Facility_Name($data['measles_Result']->rb_facode);
		//$data['rbuncode']=get_UC_Name($data['measles_Result']->rb_uncode);
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			//print_r($data);exit;
			$data['fileToLoad'] = 'investigation_forms/measles_case_investigation_form';
			$data['pageTitle']='Measles Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
			//template_loader('investigation_forms/measles_case_investigation_form', $data, array($this->_module));
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function measles_view(){
		if($this -> uri -> segment(4) != ''){
			$facode = $this -> uri -> segment(3);
			$id   = $this -> uri -> segment(4);
			$data['a'] = $this -> Common_model -> get_info('measle_case_investigation', '', '','*', array('id' => $id, 'facode' => $facode));
		}else{
			$id   = $this -> uri -> segment(3);
			$data['a'] = $this -> Common_model -> get_info('measle_case_investigation', '', '','*', array('id' => $id));
		}	
		
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/measles_case_investigation_form_view';
			$data['pageTitle']='Measles Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//-------------------------------AFP Case Investigation---------------------------------//
	public function afp_investigation(){
		$data['data']=$this -> Investigation_forms_model -> afp_investigation();
		$distcode = $this -> session -> District;
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$dcode=$result['epid_code'];
		$current_date = date('Y-m-d');
		$year = getWeekYearAccordingToCurrentDate($current_date);
		$query = "SELECT max(afp_number) as afp_number from afp_case_investigation where epid_year='$year' AND dcode='$dcode'";
		$result = $this -> db -> query($query);        
		$result = $result -> row_array();
		$data['afpNumber'] = str_split(sprintf('%04u', ($result['afp_number'] + 1)));
		$data['years'] = getEpiWeekYearsOptions('',true);
		//$data['years'] = getAllYearsOptionsIncludingCurrent(true);
		$distcode = $this -> session -> District;
		$data['fileToLoad'] = 'investigation_forms/afp_investigation_form';
		$data['pageTitle']='AFP Investigation Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	///////////////////////////////////AFP Forms Save/////////////////////////////////////////////////////////////////////////
	public function afp_Save(){
		//\print_r($_POST);exit();
		/////////By usama for federal sync
		$doses_received= $this -> input -> post('doses_received');
		$patient_gender= $this -> input -> post('patient_gender');
		$distcode = $this -> input -> post('distcode');
		$case_type = 'Afp';
		if($doses_received > 2 ){
			$doses_received = 99;
		}else{
			$doses_received = $this -> input -> post('doses_received');
		}
		/////End//
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
		$baseUrl = base_url();
		//dataEntryValidator(0);
		if(($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year')){
			$data=$_POST;			
			$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			$data['epid_year'] = $year;
			$data['week'] = sprintf("%02d",$week);
			$data['fweek'] = $year."-".sprintf("%02d",$week);
			if($this -> input -> post('cross_notified') == 1){
				$data['procode'] = $procode = $this -> input -> post('procode');
				$data['patient_address_procode'] = $this -> input -> post('procode');
				$data['distcode'] = $this -> input -> post('patient_address_distcode');
				$data['tcode'] = $this -> input -> post('patient_address_tcode');
				$data['uncode'] = $this -> input -> post('patient_address_uncode');				
			}
			
			if(!$this -> input -> post('cross_notified')){
				$data['procode'] = $procode = $_SESSION["Province"];
				$data['case_epi_no'] = "PAK/".$_SESSION["shortname"]."/".$this -> input -> post('dcode')."/".$this -> input -> post('year')."/".$this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');			
				$data['afp_number'] = $this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');
			}
			else{
				if(!$this -> input -> post('edit') && !$this -> input -> post('id')){
					$data['procode'] = $procode = $this -> input -> post('procode');
					$data['cross_notified_from_distcode'] = $this -> session -> District;
					$data['approval_status'] = "Pending";
				}
			}
			$query = "SELECT max(cn_id_from) AS cn_id_from FROM afp_case_investigation";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$cn_id_from = $result['cn_id_from'] + 1; 

			unset($data['a1']);unset($data['a2']);unset($data['a3']);unset($data['a4']);
			//echo '<pre>';print_r($data);exit;
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				//$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('id' => $id,'distcode' => $data['distcode'],'facode' => $data['facode']));
				$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('id' => $id));
				if(($procode != $_SESSION["Province"]) || ($approval_status == 'Approved')){
					$data['edit'] = $edit = $this -> input -> post('edit');
					$filepath = 'Investigation_forms/afp_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $data);
				}
				if($this -> input -> post('cross_notified') != 1){
				syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('AFP-CIF/List');
			}
			else{
				if($this -> input -> post('cross_notified') == 1 && !$this -> input -> post('cross_case_id')){
					//echo "a";exit();
					$rcode = $this -> session -> District;
					$distcode = $this -> input -> post('patient_address_distcode');
					$data['cross_case_id'] = $cross_case_id = $rcode.'-'.$distcode.'-'.$cn_id_from;
				}
				else if($this -> input -> post('cross_notified') == 1 && $this -> input -> post('cross_case_id')){
					//echo "b";exit();
					$data['cross_case_id'] = $this -> input -> post('cross_case_id');
				}
				else{
					//echo "c";exit();
					$data['cross_case_id'] = NULL;
				}
				$data['cross_notified'] = ($this-> input-> post('cross_notified'))?$this-> input-> post('cross_notified'):0;
				$inserted_id = $this -> Common_model -> insert_record('afp_case_investigation',$data);
				$query = "SELECT max(id) AS id FROM afp_case_investigation";
				$result = $this -> db -> query($query);
				$result = $result -> row_array();
				$data['cn_id_to'] = $cn_id_to = $result['id'];			
				if($procode != $_SESSION["Province"]){
					$filepath = 'Investigation_forms/afp_receive_and_save';
					$url = $this -> getSingleRegionUrl($procode);
					$dataMeasles = $this -> getDataToSave($url, $filepath, $data);
				}
				if($this -> input -> post('cross_notified') != 1){
					syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$distcode,$doses_received,$patient_gender);
				//}
				}
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('AFP-CIF/List');				
			}
		}else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('AFP-CIF/Add');
		}
	}
	public function afp_receive_and_save(){
		//print_r($_POST);exit();
		//dataEntryValidator(0);
		if($this -> input -> post('cross_notified') && $this -> input -> post('year')){
			$data=$_POST;			
			$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			$data['epid_year'] = $year;
			$data['week'] = sprintf("%02d",$week);
			$data['fweek'] = $year."-".sprintf("%02d",$week);
			if($this -> input -> post('cross_notified') == 1){
				$data['procode'] = $this -> input -> post('procode');
				$data['patient_address_procode'] = $this -> input -> post('procode');
				$data['distcode'] = $this -> input -> post('patient_address_distcode');
				$data['tcode'] = $this -> input -> post('patient_address_tcode');
				$data['uncode'] = $this -> input -> post('patient_address_uncode');				
			}
			
			if(!$this -> input -> post('cross_notified')){
				$data['procode']=$_SESSION["Province"];
				$data['case_epi_no'] = "PAK/".$_SESSION["shortname"]."/".$this -> input -> post('dcode')."/".$this -> input -> post('year')."/".$this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');			
				$data['afp_number'] = $this -> input -> post('a1').$this -> input -> post('a2').$this -> input -> post('a3').$this -> input -> post('a4');
			}
			else{
				if(!$this -> input -> post('edit') && !$this -> input -> post('id')){
					$data['cross_notified_from_distcode'] = $this -> input -> post('rb_distcode');
					$data['approval_status'] = "Pending";
				}
			}
			$query = "SELECT max(cn_id_from) AS cn_id_from FROM afp_case_investigation";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$cn_id_from = $result['cn_id_from'] + 1; 

			unset($data['a1']);unset($data['a2']);unset($data['a3']);unset($data['a4']);
			//echo '<pre>';print_r($data);exit;
			if($this -> input -> post('edit') && $this -> input -> post('cross_case_id'))
			{
				//$id = $data['id'];
				unset($data['id']);unset($data['edit']);
				$cross_case_id = $this -> input -> post('cross_case_id'); 
				//$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('id' => $id,'distcode' => $data['distcode'],'facode' => $data['facode']));
				$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('cross_case_id' => $cross_case_id));
			
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('AFP-CIF/List');
			}
			else{				
				$inserted_id = $this -> Common_model -> insert_record('afp_case_investigation',$data);				
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('AFP-CIF/List');				
			}
		}else{
			$this -> session -> set_flashdata('message','You must select District, Tehsil, Union Council, Health Facility and Year!');
			redirect('AFP-CIF/Add');
		}
	}
	public function afp_Approve(){
		//print_r($_POST);exit();
		//dataEntryValidator(0);
		/////parameter for sync by usama /////
		$year = $this -> input -> post('year');
		$week = $this -> input -> post('week');
		$case_type = 'Afp';
		$sdistcode = $this -> input -> post('distcode');
		$patient_gender = $this -> input -> post('gender');
		$doses_received = $this -> input -> post('doses_received');
		if($doses_received > 2 ){
			$doses_received = 99;
		}else{
			$doses_received = $this -> input -> post('doses_received');
		}
		
		/////end
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "select epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['patient_address_uncode'] = $this -> input -> post('uncode');
			$data['patient_address_tcode'] = $this -> input -> post('tcode');
			$data['afp_number'] = $this -> input -> post('afp_number');
			$data['cross_case_id'] = $this -> input -> post('cross_case_id');			
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('id' => $this->input->post('id')));
			syncCaseEpidCountMasterDataWithFederalEPIMIS($year,$week,$case_type,$sdistcode,$doses_received,$patient_gender);
			if($procode != $_SESSION["Province"]){
				$filepath = 'Investigation_forms/afpApprove_and_save'; 
				$url = $this -> getSingleRegionUrl($procode); 
				$dataMeasles = $this -> getDataToSave($url, $filepath,$data); 
			}
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('AFP-CIF/List');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	public function afpApprove_and_save(){
		//dataEntryValidator(0);
		if($this -> input -> post('facode')>0 && $this -> input -> post('case_epi_no')){
			$distcode = $this -> session -> District;
			$query = "select epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['dcode'] = $result['epid_code'];
			$data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			$data['uncode'] = $this -> input -> post('uncode');
			$data['tcode'] = $this -> input -> post('tcode');
			$data['patient_address_uncode'] = $this -> input -> post('uncode');
			$data['patient_address_tcode'] = $this -> input -> post('tcode');
			$data['afp_number'] = $this -> input -> post('afp_number');
			//$data['cross_case_id'] = $this -> input -> post('cross_case_id');			
			$data['approval_status'] = "Approved";
			$procode = $this -> input -> post('procode');
			$updated_id = $this -> Common_model -> update_record('afp_case_investigation',$data,array('cross_case_id' => $this-> input-> post('cross_case_id')));
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('AFP-CIF/List');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	////////////////////////////////////////////AFP List////////////////////////////////////////////////////////
	public function afp_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " afp_case_investigation "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."' OR cross_notified_from_distcode='". $this -> session -> District ."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Investigation_forms_model -> afp_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		if($this -> session -> District){
			$wcd = " procode='".$_SESSION["Province"]."' and ((distcode='".$this -> session -> District."' and cross_notified=0) OR (cross_notified_from_distcode='".$this -> session -> District."' and approval_status='Pending') OR (distcode='".$this -> session -> District."' and approval_status='Approved'))";
		}
		else{
			$wcd = " procode='".$_SESSION["Province"]."'";
		}
		$query = "SELECT max(id) as max_id from afp_case_investigation where $wcd";
		//echo $query; exit();
		$resultGroupid = $this -> db -> query($query);
		$data['max_id'] = $resultGroupid -> result_array();
		//print_r($data['max_gid']); exit();
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/afp_case_investigation_list';
			$data['pageTitle']='AFP Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function afp_investigation_edit(){
		dataEntryValidator(0);
		//$facode = $this -> uri -> segment(3);
		$distcode = $this -> session -> District;
		$query = "select epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];		
		$dcode=$result['epid_code'];
		$year = date('Y');
		
		$id   = ($this -> uri -> segment(4) != '')?$this -> uri -> segment(4):$this -> uri -> segment(3);
		$data['afp_Result'] = $this -> Common_model -> get_info('afp_case_investigation', '', '','*', array('id' => $id));
		//print_r($data['afp_Result']);exit();
		if($data['afp_Result']->case_reported == 0){
			$query = "select max(afp_number) as afp_number from afp_case_investigation where epid_year='$year' AND dcode='$dcode'";
			$result = $this -> db -> query($query);        
			$result = $result -> row_array();
			$data['afpNumber'] = str_split(sprintf('%04u', ($result['afp_number'] + 1)));
		}else
			$data['afpNumber'] = str_split(sprintf('%04u', ($data['afp_Result']->afp_number)));	
		//$data['measles_Result'] = $this -> Common_model -> get_info('measle_case_investigation', '', '','*', array('id' => $id, 'facode' => $facode));
		$data['unioncouncil']=get_UC_Name($data['afp_Result']->uncode);
		$data['facility']=get_Facility_Name($data['afp_Result']->facode);
		$data['tehsil']=get_Tehsil_Name($data['afp_Result']->tcode);
		$data['rbfacility']=get_Facility_Name($data['afp_Result']->rb_facode);
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			//print_r($data);exit;
			$data['fileToLoad'] = 'investigation_forms/afp_investigation_form';
			$data['pageTitle']='AFP Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}			
	}
	public function afp_investigation_view(){
		//echo "danish";exit;
		if($this -> uri -> segment(4) != ''){
			$facode = $this -> uri -> segment(3);
			$id   = $this -> uri -> segment(4);
			$data['a'] = $this -> Common_model -> get_info('afp_case_investigation', '', '','*', array('id' => $id, 'facode' => $facode));
		}else{
			$id   = $this -> uri -> segment(3);
			$data['a'] = $this -> Common_model -> get_info('afp_case_investigation', '', '','*', array('id' => $id));
		}			
		// $facode = $this -> uri -> segment(3);
		// $id   = $this -> uri -> segment(4);
		// $data['a'] = $this -> Common_model -> get_info('afp_case_investigation', '', '','*', array('id' => $id, 'facode' => $facode));
		$data['edit']="Yes";
		//print_r($data);exit;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/afp_case_investigation_form_view';
			$data['pageTitle']='AFP Case Investigation Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function afp_investigation_delete(){
		dataEntryValidator(0);
		$id = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);		
		$query = "DELETE from afp_case_investigation where procode='".$_SESSION["Province"]."' and year='$year' and id=$id";
		//echo $query; exit();
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully deleted your record!');
		redirect('AFP-CIF/List');
	}
	///////////////////////////////Zero Reporting Form//////////////////////////////////////////////
	public function zero_reporting(){
		$data['data']=$this -> Investigation_forms_model -> zero_reporting();
		$wc = getWC();
		$data['years'] = getEpiWeekYearsOptions('',true,true);
		$distcode = $this -> session -> District;
		//print_r($data);exit;
		$data['fileToLoad'] = 'investigation_forms/zero_reporting_form';
		$data['pageTitle']='Zero Reporting Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	//////////////////////////////END/////////////////////////////////////////////////////////////
	/////////////////////////////ZERO Reporting Form SAVE/////////////////////////////////////////
	public function zero_reporting_list(){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " zero_report "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Investigation_forms_model -> zero_reporting_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc,"group_id");

		$query = "SELECT max(group_id) as max_group_id from zero_report where $wc";
		$resultGroupid = $this -> db -> query($query);
		$data['max_group_id'] = $resultGroupid -> result_array();
		//print_r($data['max_gid']); exit();

		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/zero_reporting_list';
			$data['pageTitle']='Zero Reporting List | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	////////////////////////////////////////END/////////////////////////////////////////////////////
	public function zero_reporting_save(){
		//print_r($_POST);exit;
		dataEntryValidator(0);
		$dataARRY = array();
		$facode= $this -> input -> post('facode');
		$data['procode']=$_SESSION["Province"];
		$data['distcode'] = $distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
		$data['is_temp_saved']=$this -> input -> post('is_temp_saved');
		$data['year'] = $this -> input -> post('year');
		$data['week'] = $this -> input -> post('week');
		$weeknumb = sprintf("%02d", $data['week']);
		$fweek = $data['fweek'] = $data['year']."-".$weeknumb;
		$year = $data['year'];
		$week = $data['week'];
		$wc = " where year ='$year' and epi_week_numb ='$week'  ";
		$query = "select date_from, date_to from epi_weeks $wc";
		$query = $this -> db -> query($query);
		$result = $query -> row();
		
		$data['datefrom'] = $result->date_from;
		$data['dateto'] = $result->date_to;
		$current_date = date('Y-m-d');
		
		$date = date_create($result->date_to);
		date_add($date, date_interval_create_from_date_string('1 days'));
		$tempDate = date_format($date, 'Y-m-d');
		$day = date('D', strtotime( $tempDate));
		
		if(!$this -> input -> post('edit')){
			$query = "Select max(group_id) as group_id from zero_report  HAVING max(group_id) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$groupid = $result -> row_array();
				$newCode = $groupid['group_id'] + 1;
				if ($newCode != NULL) {
					$data['group_id'] = $newCode;
				} else {
					$data['group_id'] = '1';
				}
			} else {
				$data['group_id'] = '1';
			}
		}
		
		if($this -> input -> post('edit') && $this -> input -> post('group_id'))
		{
			$data['group_id'] = $this -> input -> post('group_id');
		}
		foreach($facode as $key => $code){ 
			if($code != '')
			{
				$data['facode'] = $this -> input -> post('facode['.$key.']');
				$data['report_submitted'] = $this -> input -> post('report_submitted['.$key.']');
				$data['aefi_cases'] = 0;
				$data['aefi_deaths'] = 0;
				$data['measle_cases'] = 0;
				$data['measle_deaths'] = 0;
				$data['afp_cases'] = 0;
				$data['afp_deaths'] = 0;
				$data['tb_cases'] = 0;
				$data['tb_deaths'] = 0;
				$data['diarrhea_cases'] = 0;
				$data['diarrhea_deaths'] = 0;
				$data['diphtheria_cases'] = 0;
				$data['diphtheria_deaths'] = 0;
				$data['hepatits_cases'] = 0;
				$data['hepatits_deaths'] = 0;
				$data['meningitis_cases'] =0;
				$data['meningitis_deaths'] = 0;
				$data['nnt_cases'] = 0;
				$data['nnt_deaths'] = 0;
				$data['pertusis_cases'] = 0;
				$data['pertusis_deaths'] = 0;
				$data['pneumonia_cases'] = 0;
				$data['pneumonia_deaths'] = 0;
				//$data['pneumonia_great_five_cases'] = 0;
				//$data['pneumonia_great_five_deaths'] = 0;
				//$data['urti_cases'] = 0;
				//$data['urti_deaths'] = 0;
				//$data['diarrhea_great_five_cases'] = 0;
				//$data['diarrhea_great_five_deaths'] = 0;
				$data['bd_cases'] = 0;
				$data['bd_deaths'] = 0;
				$data['ad_cases'] = 0;
				$data['ad_deaths'] =0;
				$data['tf_cases'] = 0;
				$data['tf_deaths'] = 0;
				$data['avh_cases'] = 0;
				$data['avh_deaths'] = 0;
				$data['dhf_cases'] = 0;
				$data['dhf_deaths'] = 0;
				$data['df_cases'] = 0;
				$data['df_deaths'] =0;
				$data['cchf_cases'] = 0;
				$data['cchf_deaths'] = 0;
				$data['cl_cases'] = 0;
				$data['cl_deaths'] = 0;
				$data['vl_cases'] = 0;
				$data['vl_deaths'] = 0;
				$data['mal_cases'] = 0;
				$data['mal_deaths'] = 0;
				//$data['puo_cases'] = 0;
				//$data['puo_deaths'] = 0;
				//$data['psy_cases'] = 0;
				//$data['psy_deaths'] = 0;
				$data['undis_cases'] = 0;
				$data['undis_deaths'] = 0;				
				$data['sari_cases'] = 0;
				$data['sari_deaths'] = 0;
				$data['anthrax_cases'] = 0;
				$data['anthrax_deaths'] = 0;
				$data['dogbite_cases'] = 0;
				$data['dogbite_deaths'] = 0;
				$data['aids_cases'] = 0;
				$data['aids_deaths'] = 0;
				$data['scabies_cases'] = 0;
				$data['scabies_deaths'] = 0;
				$data['submitted_date'] = NULL;
				$data['updated_date'] = NULL;
				$data['covid_cases'] = 0;
				$data['covid_deaths'] = 0;
				if($data['report_submitted'] == '1'){
					$data['aefi_cases'] 				= (is_numeric($this -> input -> post('aefi_cases['.$key.']')))?$this -> input -> post('aefi_cases['.$key.']'):0;
					$data['aefi_deaths'] 				= (is_numeric($this -> input -> post('aefi_deaths['.$key.']')))?$this -> input -> post('aefi_deaths['.$key.']'):0;
					$data['measle_cases'] 				= (is_numeric($this -> input -> post('measle_cases['.$key.']')))?$this -> input -> post('measle_cases['.$key.']'):0;
					$data['measle_deaths'] 				= (is_numeric($this -> input -> post('measle_deaths['.$key.']')))?$this -> input -> post('measle_deaths['.$key.']'):0;
					$data['afp_cases'] 					= (is_numeric($this -> input -> post('afp_cases['.$key.']')))?$this -> input -> post('afp_cases['.$key.']'):0;
					$data['afp_deaths'] 				= (is_numeric($this -> input -> post('afp_deaths['.$key.']')))?$this -> input -> post('afp_deaths['.$key.']'):0;
					$data['tb_cases'] 					= (is_numeric($this -> input -> post('tb_cases['.$key.']')))?$this -> input -> post('tb_cases['.$key.']'):0;
					$data['tb_deaths'] 					= (is_numeric($this -> input -> post('tb_deaths['.$key.']')))?$this -> input -> post('tb_deaths['.$key.']'):0;
					$data['diarrhea_cases'] 			= (is_numeric($this -> input -> post('diarrhea_cases['.$key.']')))?$this -> input -> post('diarrhea_cases['.$key.']'):0;
					$data['diarrhea_deaths'] 			= (is_numeric($this -> input -> post('diarrhea_deaths['.$key.']')))?$this -> input -> post('diarrhea_deaths['.$key.']'):0;
					$data['diphtheria_cases'] 			= (is_numeric($this -> input -> post('diphtheria_cases['.$key.']')))?$this -> input -> post('diphtheria_cases['.$key.']'):0;
					$data['diphtheria_deaths'] 			= (is_numeric($this -> input -> post('diphtheria_deaths['.$key.']')))?$this -> input -> post('diphtheria_deaths['.$key.']'):0;
					$data['hepatits_cases'] 			= (is_numeric($this -> input -> post('hepatits_cases['.$key.']')))?$this -> input -> post('hepatits_cases['.$key.']'):0;
					$data['hepatits_deaths'] 			= (is_numeric($this -> input -> post('hepatits_deaths['.$key.']')))?$this -> input -> post('hepatits_deaths['.$key.']'):0;
					$data['meningitis_cases'] 			= (is_numeric($this -> input -> post('meningitis_cases['.$key.']')))?$this -> input -> post('meningitis_cases['.$key.']'):0;
					$data['meningitis_deaths'] 			= (is_numeric($this -> input -> post('meningitis_deaths['.$key.']')))?$this -> input -> post('meningitis_deaths['.$key.']'):0;
					$data['nnt_cases'] 					= (is_numeric($this -> input -> post('nnt_cases['.$key.']')))?$this -> input -> post('nnt_cases['.$key.']'):0;
					$data['nnt_deaths'] 				= (is_numeric($this -> input -> post('nnt_deaths['.$key.']')))?$this -> input -> post('nnt_deaths['.$key.']'):0;
					$data['pertusis_cases'] 			= (is_numeric($this -> input -> post('pertusis_cases['.$key.']')))?$this -> input -> post('pertusis_cases['.$key.']'):0;
					$data['pertusis_deaths'] 			= (is_numeric($this -> input -> post('pertusis_deaths['.$key.']')))?$this -> input -> post('pertusis_deaths['.$key.']'):0;
					$data['pneumonia_cases'] 			= (is_numeric($this -> input -> post('pneumonia_cases['.$key.']')))?$this -> input -> post('pneumonia_cases['.$key.']'):0;
					$data['pneumonia_deaths'] 			= (is_numeric($this -> input -> post('pneumonia_deaths['.$key.']')))?$this -> input -> post('pneumonia_deaths['.$key.']'):0;
					//$data['puo_cases'] 					= (is_numeric($this -> input -> post('puo_cases['.$key.']')))?$this -> input -> post('puo_cases['.$key.']'):0;
					//$data['puo_deaths'] 				= (is_numeric($this -> input -> post('puo_deaths['.$key.']')))?$this -> input -> post('puo_deaths['.$key.']'):0;
					//$data['psy_cases'] 					= (is_numeric($this -> input -> post('psy_cases['.$key.']')))?$this -> input -> post('psy_cases['.$key.']'):0;
					//$data['psy_deaths'] 				= (is_numeric($this -> input -> post('psy_deaths['.$key.']')))?$this -> input -> post('psy_deaths['.$key.']'):0;
					$data['undis_cases'] 				= (is_numeric($this -> input -> post('undis_cases['.$key.']')))?$this -> input -> post('undis_cases['.$key.']'):0;
					$data['undis_deaths'] 				= (is_numeric($this -> input -> post('undis_deaths['.$key.']')))?$this -> input -> post('undis_deaths['.$key.']'):0;
					$data['sari_cases'] 				= (is_numeric($this -> input -> post('sari_cases['.$key.']')))?$this -> input -> post('sari_cases['.$key.']'):0;
					$data['sari_deaths'] 				= (is_numeric($this -> input -> post('sari_deaths['.$key.']')))?$this -> input -> post('sari_deaths['.$key.']'):0;
					$data['df_cases'] 					= (is_numeric($this -> input -> post('df_cases['.$key.']')))?$this -> input -> post('df_cases['.$key.']'):0;
					$data['df_deaths'] 					= (is_numeric($this -> input -> post('df_deaths['.$key.']')))?$this -> input -> post('df_deaths['.$key.']'):0;
					$data['cchf_cases'] 				= (is_numeric($this -> input -> post('cchf_cases['.$key.']')))?$this -> input -> post('cchf_cases['.$key.']'):0;
					$data['cchf_deaths'] 				= (is_numeric($this -> input -> post('cchf_deaths['.$key.']')))?$this -> input -> post('cchf_deaths['.$key.']'):0;
					$data['cl_cases'] 					= (is_numeric($this -> input -> post('cl_cases['.$key.']')))?$this -> input -> post('cl_cases['.$key.']'):0;
					$data['cl_deaths'] 					= (is_numeric($this -> input -> post('cl_deaths['.$key.']')))?$this -> input -> post('cl_deaths['.$key.']'):0;
					$data['vl_cases'] 					= (is_numeric($this -> input -> post('vl_cases['.$key.']')))?$this -> input -> post('vl_cases['.$key.']'):0;
					$data['vl_deaths'] 					= (is_numeric($this -> input -> post('vl_deaths['.$key.']')))?$this -> input -> post('vl_deaths['.$key.']'):0;
					$data['mal_cases'] 					= (is_numeric($this -> input -> post('mal_cases['.$key.']')))?$this -> input -> post('mal_cases['.$key.']'):0;
					$data['mal_deaths'] 				= (is_numeric($this -> input -> post('mal_deaths['.$key.']')))?$this -> input -> post('mal_deaths['.$key.']'):0;
					//$data['pneumonia_great_five_cases'] = (is_numeric($this -> input -> post('pneumonia_great_five_cases['.$key.']')))?$this -> input -> post('pneumonia_great_five_cases['.$key.']'):0;
					//$data['pneumonia_great_five_deaths']= (is_numeric($this -> input -> post('pneumonia_great_five_deaths['.$key.']')))?$this -> input -> post('pneumonia_great_five_deaths['.$key.']'):0;
					//$data['urti_cases'] 				= (is_numeric($this -> input -> post('urti_cases['.$key.']')))?$this -> input -> post('urti_cases['.$key.']'):0;
					//$data['urti_deaths'] 				= (is_numeric($this -> input -> post('urti_deaths['.$key.']')))?$this -> input -> post('urti_deaths['.$key.']'):0;
					//$data['diarrhea_great_five_cases'] 	= (is_numeric($this -> input -> post('diarrhea_great_five_cases['.$key.']')))?$this -> input -> post('diarrhea_great_five_cases['.$key.']'):0;
					//$data['diarrhea_great_five_deaths'] = (is_numeric($this -> input -> post('diarrhea_great_five_deaths['.$key.']')))?$this -> input -> post('diarrhea_great_five_deaths['.$key.']'):0;
					$data['bd_cases'] 					= (is_numeric($this -> input -> post('bd_cases['.$key.']')))?$this -> input -> post('bd_cases['.$key.']'):0;
					$data['bd_deaths'] 					= (is_numeric($this -> input -> post('bd_deaths['.$key.']')))?$this -> input -> post('bd_deaths['.$key.']'):0;
					$data['ad_cases'] 					= (is_numeric($this -> input -> post('ad_cases['.$key.']')))?$this -> input -> post('ad_cases['.$key.']'):0;
					$data['ad_deaths'] 					= (is_numeric($this -> input -> post('ad_deaths['.$key.']')))?$this -> input -> post('ad_deaths['.$key.']'):0;
					$data['tf_cases'] 					= (is_numeric($this -> input -> post('tf_cases['.$key.']')))?$this -> input -> post('tf_cases['.$key.']'):0;
					$data['tf_deaths'] 					= (is_numeric($this -> input -> post('tf_deaths['.$key.']')))?$this -> input -> post('tf_deaths['.$key.']'):0;
					$data['avh_cases'] 					= (is_numeric($this -> input -> post('avh_cases['.$key.']')))?$this -> input -> post('avh_cases['.$key.']'):0;
					$data['avh_deaths'] 				= (is_numeric($this -> input -> post('avh_deaths['.$key.']')))?$this -> input -> post('avh_deaths['.$key.']'):0;
					$data['dhf_cases'] 					= (is_numeric($this -> input -> post('dhf_cases['.$key.']')))?$this -> input -> post('dhf_cases['.$key.']'):0;
					$data['dhf_deaths'] 				= (is_numeric($this -> input -> post('dhf_deaths['.$key.']')))?$this -> input -> post('dhf_deaths['.$key.']'):0;
					$data['anthrax_cases'] 				= (is_numeric($this -> input -> post('anthrax_cases['.$key.']')))?$this -> input -> post('anthrax_cases['.$key.']'):0;
					$data['anthrax_deaths'] 			= (is_numeric($this -> input -> post('anthrax_deaths['.$key.']')))?$this -> input -> post('anthrax_deaths['.$key.']'):0;
					$data['dogbite_cases'] 				= (is_numeric($this -> input -> post('dogbite_cases['.$key.']')))?$this -> input -> post('dogbite_cases['.$key.']'):0;
					$data['dogbite_deaths'] 			= (is_numeric($this -> input -> post('dogbite_deaths['.$key.']')))?$this -> input -> post('dogbite_deaths['.$key.']'):0;
					$data['aids_cases'] 				= (is_numeric($this -> input -> post('aids_cases['.$key.']')))?$this -> input -> post('aids_cases['.$key.']'):0;
					$data['aids_deaths'] 				= (is_numeric($this -> input -> post('aids_deaths['.$key.']')))?$this -> input -> post('aids_deaths['.$key.']'):0;
					$data['scabies_cases'] 				= (is_numeric($this -> input -> post('scabies_cases['.$key.']')))?$this -> input -> post('scabies_cases['.$key.']'):0;
					$data['scabies_deaths'] 			= (is_numeric($this -> input -> post('scabies_deaths['.$key.']')))?$this -> input -> post('scabies_deaths['.$key.']'):0;
					$data['covid_cases'] 				= (is_numeric($this -> input -> post('covid_cases['.$key.']')))?$this -> input -> post('covid_cases['.$key.']'):0;
					$data['covid_deaths'] 				= (is_numeric($this -> input -> post('covid_deaths['.$key.']')))?$this -> input -> post('covid_deaths['.$key.']'):0;
				}
				if($data['report_submitted'] == '1'){
					if($tempDate == $current_date){
						$data['submitted_date'] = $current_date ;
					}else{
						$data['updated_date'] = $current_date ;
					}
				}
				$dataARRY[] = $data;
			}
		}
		if($this -> input -> post('edit') && $this -> input -> post('group_id'))
		{
			$id = $this -> input -> post('group_id');
			unset($data['edit']);
			foreach($dataARRY as $onearr){
				$this->db->where(array('facode' => $onearr['facode'], 'fweek' => $onearr['fweek']));        
				$this->db->delete('zero_report');
				$this -> Common_model -> insert_record('zero_report',$onearr);
			}
			syncDataWithFederalEPIMIS('zero_report', $fweek, 'weekly', $distcode);
			syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
			$this -> session -> set_flashdata('message','You have successfully updated your record!');
			redirect('Zero-Reporting');
		}
		if(!$this -> input -> post('edit'))
		{			
			foreach($dataARRY as $onearr){
				$this -> Common_model -> insert_record('zero_report',$onearr);
				syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
			}
			syncDataWithFederalEPIMIS('zero_report', $fweek, 'weekly', $distcode);
			$this -> session -> set_flashdata('message','You have successfully saved your record!');
			redirect('Zero-Reporting');	
		}
	}		
	///////////////////////////////////////////Zero Reporting View////////////////////////////////////////
	public function zero_reporting_view(){
		$fweek = $this -> uri -> segment(3);
		$group_id = $this -> uri -> segment(4);
		$data['zero_report'] = $this -> Common_model -> fetchall('zero_report', '','*', array('group_id' => $group_id,'fweek'=>$fweek));
		$data['district']=get_District_Name($data['zero_report'][0]['distcode']);
		$data['facility']=get_Facility_Name($data['zero_report'][0]['facode']);
		$data['year']=$data['zero_report'][0]['year'];
		$data['week']=$data['zero_report'][0]['week'];
		$data['datefrom']=$data['zero_report'][0]['datefrom'];
		$data['dateto']=$data['zero_report'][0]['dateto'];
		$data['fweek']=$data['zero_report'][0]['fweek'];
		$data['group_id']=$data['zero_report'][0]['group_id'];
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/zero_reporting_form_view';
			$data['pageTitle']='Zero Reporting Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	/////////////////////////////////////////////Zero Reporting Edit///////////////////////////////////////////////
	public function zero_reporting_edit(){
		dataEntryValidator(0);
		$current_date = date('Y-m-d');
		$fweek = $this -> uri -> segment(3);
		$group_id   = $this -> uri -> segment(4);
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
		$data['zero_report_header'] = $this -> Common_model -> fetchall('zero_report', '','', array('group_id' => $group_id,'fweek'=>$fweek));
		$data['datefrom']=$data['zero_report_header'][0]['datefrom'];
		$data['dateto']=$data['zero_report_header'][0]['dateto'];
		$dueMonday = date('Y-m-d', strtotime($data['dateto']. ' + 1 days'));
		if($current_date > $dueMonday){
			$data['zero_report'] = $this -> Common_model -> fetchall('zero_report', '','', array('group_id' => $group_id,'fweek'=>$fweek,'report_submitted'=>'0'));
		}
		else{
			$data['zero_report'] = $this -> Common_model -> fetchall('zero_report', '','', array('group_id' => $group_id,'fweek'=>$fweek));
		}
		$data['district']=get_District_Name($data['zero_report_header'][0]['distcode']);
		$data['facility']=get_Facility_Name($data['zero_report_header'][0]['facode']);
		$data['year']=$data['zero_report_header'][0]['year'];
		$data['week']=$data['zero_report_header'][0]['week'];
		$data['fweek']=$data['zero_report_header'][0]['fweek'];
		$data['group_id']=$data['zero_report_header'][0]['group_id'];
		$data['edit']="Yes";
		
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'investigation_forms/zero_reporting_form';
			$data['pageTitle']='Zero Reporting Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function zero_report_delete(){
		dataEntryValidator(0);
		$fweek = $this -> uri -> segment(3);
		$group_id = $this -> uri -> segment(4);
		//echo $fweek; echo " / "; echo $group_id;
		if($this -> session -> District){
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		}
		else{
			$wc=" procode = '".$_SESSION["Province"]."'";
		}
		$query = "DELETE from zero_report where $wc and fweek='$fweek' and group_id=$group_id";
		//echo $query; exit();
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully deleted your record!');
		redirect('Zero-Reporting');
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
		$query="SELECT district,distcode from districts where procode = '$procode' order by district asc";
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

 //   public function FacilityOptions(){
	// 	$facode = $this-> input-> post('facode');
	// 	$FacilityName = $this -> getCrossProvince_FacilitiesOptions(false,$facode);
	// 	echo $FacilityName;
	// }
	// function getCrossProvince_FacilitiesOptions($isreturn=false,$facode=NULL,$uncode=NULL){
	// 	$procode = substr($facode,0,1);
	// 	$distcode = substr($facode,0,3);
	// 	$tcode = substr($uncode,0,6);
	// 	$output = '<option value="" >--Select Facility--</option>'; 
	// 	$query="SELECT fac_name,facode from facilities where distcode = '$distcode' and hf_type='e' order by facode";
	// 	if($uncode != NULL){
	// 		$query = "SELECT fac_name, facode from facilities where uncode = '$uncode' and hf_type = 'e' order by facode";
	// 	}
	// 	else if($tcode != NULL){
	// 		$query = "SELECT fac_name, facode from facilities where tcode = '$tcode' and hf_type = 'e' order by facode";
	// 	}
	// 	else{
	// 		$query = "SELECT fac_name, facode from facilities where distcode = '$distcode' and hf_type = 'e' order by facode";
	// 	}
	// 	$result = $this -> db ->query($query);
	// 	$result1 = $result->result_array();
	// 	foreach ($result1 as $oneteh) { 
	// 		$selected = '';
	// 		if(($facode > 0)&&($facode == $oneteh["facode"]))
	// 		{
	// 			$selected = 'selected="selected"';
	// 		}
	// 		$output .= '<option value="'.$oneteh["facode"].'" '.$selected.' >'.$oneteh["fac_name"].'</option>';
	// 	}
	// 	if($isreturn)
	// 		return $output;
	// 	echo $output;
	// }
	
}
?>