
<?php
		   
class System_setup extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('System_setup_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
							   
					   
																					  
				  
			 
   
				 
														  
												
					  
																		   
									 
																									  
													 
														
					  
				   
						 
												   
											   
														 
		  
																  
										   
   
  
																					 
																						 
																					 
							  
						
						 
													 
					  
				   
						 
												  
													
														 
		  
																  
										   
   
  
 
																									
																										 
																									
								
   
						
											  
					  
										  
																								   
																						 
																					 
																								  
																														 
																							
																							   
																											 
																						  
																								   
											  
  
										  
								
	
															   
					 
						   
													 
														
					   
														   
			
																	
											 
	 
		 
													   
					 
						   
													
														 
					   
														   
																											 
																						  
																								   
											  
  
										  
								
	
															   
					 
						   
													 
														
					   
														   
			
																	
											 
	 
		 
													   
					 
						   
													
														 
					   
														   
			
																	
											 
	 
	
  
	   
										 
																 
					
											   
																							   
																															 
																							   
																											 
																					  
																																			   
																															   
																								 
																							  
																																
																														  
																																
																											   
																													
																																		  
																															 
																																					  
																																			 
																																 
																																		  
																																			 
																							   
																													   
																							
																										
																													
																							
																									 
																									 
																										   
																													
																						 
																															
																										   
																																												 
																																										   
																																										
																																								  
																																																
																																														  
																																																
																																														  
																 
																																												 
																																										   
																							
															
												
																									   
																										  
																										 
		 
	 
			
																	
											 
	 
													 
																																			   
   
   
  
																										  
							   
						
									   
						   
															 
																
				   
						 
												   
													  
					 
														 
		  
																  
										   
   
  
																										
																											 
																										
							   
									   
															 
				   
						 
												   
														
														 
		  
																  
										   
   
  
	
  
	   
										 
																 
					
											   
																							   
																															 
																							   
																											 
																					  
																																			   
																															   
																								 
																							  
																																
																														  
																																
																											   
																													
																																		  
																															 
																																					  
																																			 
																																 
																																		  
																																			 
																							   
																													   
																							
																										
																													
																							
																									 
																									 
																										   
																													
																						 
																															
																										   
																																												 
																																										   
																																										
																																								  
																																																
																																														  
																																																
																																														  
																 
																																												 
																																										   
																							
															
												
																									   
																										  
																										 
		 
	 
   
																	  
		
						 
													 
																																			   
   
   
  
																										  
							   
						
									   
						   
															 
																
				   
						 
												   
													  
					 
														 
		  
																  
										   
   
  
																										
																											 
																										
							   
									   
															 
				   
						 
												   
														
														 
		  
																  
										   
   
  
 
	//--------------------------------------------------------------------//
	//================ Supervisor Listing Function Starts ================//
	public function supervisor_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "supervisordb ";
		$data = $this -> System_setup_model -> supervisor_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/supervisor_list';
			$data['pageTitle'] = 'EPI-MIS | List of Supervisors';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Supervisor Starts Here =======//	
	public function supervisor_add() {
		dataEntryValidator(0);
		//dataEntryValidator();
		$data = $this -> System_setup_model -> supervisor_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/supervisor_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Supervisor Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Supervisor Record Starts Here =================//
	public function supervisor_save() {		
		dataEntryValidator(0);
		$supervisorCode = $this -> input -> post ('supervisorcode');
		//echo $supervisorCode;exit;
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('supervisorname','Supervisor Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','trim|required|max_length[15]');$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');																							   
		$this->form_validation->set_rules('supervisor_type','Supervisor Type','trim|required|max_length[100]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|required|max_length[50]'); 
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		//print_r($_POST);exit;
		//$this->form_validation->set_rules('bankid','Bank Information','required|max_length[50]');		
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
			if($supervisorCode!='' && $edit!=''){
				$data = $this -> System_setup_model -> supervisor_edit($supervisorCode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/supervisor_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Supervisor Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> supervisor_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/supervisor_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Supervisor Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
		}
		else{
			if($this -> input -> post ('supervisorcode')){
				$supervisorData = array(
					'procode' => $this -> session -> Province,
					'supervisorcode' => ($this -> input -> post ('supervisorcode'))? $this -> input -> post ('supervisorcode') : Null,
					'supervisorname' => ($this -> input -> post ('supervisorname'))? $this -> input -> post ('supervisorname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : $this -> session -> District,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_resigned' => ($this -> input -> post ('date_resigned'))? date('Y-m-d', strtotime($this ->input -> post ('date_resigned'))) : Null,
					'date_transfered_to_hdpt' => ($this -> input -> post ('date_transfered_to_hdpt'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfered_to_hdpt'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'supervisor_type' => ($this -> input -> post ('supervisor_type'))? $this -> input -> post ('supervisor_type') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')?
					$this->input->post('previous_code'):Null,
					'newtcode' => ($this -> input -> post ('newtcode'))? $this -> input -> post ('newtcode') : Null,
					'newfacode' => ($this -> input -> post ('newfacode'))? $this -> input -> post ('newfacode') : Null,
					'newuncode' => ($this -> input -> post ('newuncode'))? $this -> input -> post ('newuncode') : Null);
					$supervisorDataNewData = array('new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					//'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					//'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					//'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					//'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,

                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					
				);
				$data = $this -> System_setup_model -> supervisor_save($supervisorData,$supervisorCode,$supervisorDataNewData);
		}else{
				echo $_POST; exit();
				$location = base_url(). "System_setup/supervisor_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Supervisor Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	} 
	//================ Function for Saving New or Existing Supervisor Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here ===============//
	public function supervisor_edit() {
		dataEntryValidator(0);
		$supervisorcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> supervisor_edit($supervisorcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/supervisor_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Supervisor Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Supervisor Record Starts Here ==============//
	public function supervisor_view() {
		$supervisorcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> supervisor_view($supervisorcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/supervisor_view';
			$data['pageTitle'] = 'EPI-MIS | Supervisor Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
		//=============================function  to store keeper listing start here ==============================//
	public function skdb_list(){		
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0)
		{
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "skdb ";
		$data = $this -> System_setup_model ->skdb_list($per_page,$startpoint);
		
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/skdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Store Keeper';
			$this -> load -> view('template/epi_template', $data);
			
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	//=============================function  to store keeper listing end here ==============================//
	//------------------------------------------------------------------------------------------------------//
	//===========================function to store keeper add start here===============================//
	
	public function skdb_add(){
		//print_r("here");exit;
		dataEntryValidator(0);
		$data = $this -> System_setup_model ->skdb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/skdb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Store Keeper Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//===========================function to store keeper add end here===============================//
	//--------------------------------------------------------------------------------------------------//
	
	//===========================function to store keeper edit start here===============================//
	
	public function skdb_edit(){
		dataEntryValidator(0);
		$skcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> skdb_edit($skcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/skdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Store Keeper Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	//===========================function to store keeper edit end here===============================//
	//--------------------------------------------------------------------------------------------------//
	//===========================function to store keeper view start here===============================//
	
	public function skdb_view(){
		$skcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model ->skdb_view($skcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/skdb_view';
			$data['pageTitle'] = 'EPI-MIS | Store Keeper Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//===========================function to store keeper aview end here===============================//
	//--------------------------------------------------------------------------------------------------//
	
	//================function to store keeper save_db  new and existing start here=======================//
	
	public function skdb_save(){
		dataEntryValidator(0);
		$skcode = $this -> input -> post ('skcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('skname','Store Keeper Name','trim|required|alpha_spaces');
		 $this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','trim|required|alpha_spaces|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($skcode!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model ->skdb_edit($skcode);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/skdb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Store Keeper Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model ->skdb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/skdb_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Store Keeper Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($skcode!=''){
				
				
				$skData = array(
					'procode' => $this -> session -> Province,
					'skcode' => ($this -> input -> post ('skcode'))? $this -> input -> post ('skcode') : Null,
					'skname' => ($this -> input -> post ('skname'))? $this -> input -> post ('skname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')?
					$this->input->post('previous_code'):Null,
					'newtcode' => ($this -> input -> post ('newtcode'))? $this -> input -> post ('newtcode') : Null,
					'newfacode' => ($this -> input -> post ('newfacode'))? $this -> input -> post ('newfacode') : Null,
					'newuncode' => ($this -> input -> post ('newuncode'))? $this -> input -> post ('newuncode') : Null
			         );
			$skcodeNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);
				
				//print_r($skcodeNewData);exit();
				$data = $this -> System_setup_model ->skdb_save($skData,$skcode,$skcodeNewData);
			}else{
				$location = base_url(). "System_setup/skdb_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Store Keeper Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	//================ Function to Show Page for Viewing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	  public function deodb_add(){
		  dataEntryValidator(0);
		  $data = $this -> System_setup_model -> deodb_add();
		  $data['edit']="Yes";
		  if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dodb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Data Entry Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		  
	}
	
	//===================Function for Data entry Operator-Add end here=====================================//
	//--------------------------------------------------------------------------------------------------------//
	
	//=================Function for data entry operator-Save Start Here======================================//
	public function deodb_save(){
		 dataEntryValidator(0);        
		$deocode = $this -> input -> post ('deocode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('deoname','Data Entry Name','trim|required|alpha_spaces');
		 $this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($deocode!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model ->deodb_edit($deocode);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/dodb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Data Entry Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model ->dodb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/dodb_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Data Entry  Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($deocode!=''){
				
				
				$deoData = array(
					'procode' => $this -> session -> Province,
					'deocode' => ($this -> input -> post ('deocode'))? $this -> input -> post ('deocode') : Null,
					'deoname' => ($this -> input -> post ('deoname'))? $this -> input -> post ('deoname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')?
					$this->input->post('previous_code'):Null,
					'newtcode' => ($this -> input -> post ('newtcode'))? $this -> input -> post ('newtcode') : Null,
					'newfacode' => ($this -> input -> post ('newfacode'))? $this -> input -> post ('newfacode') : Null,
					'newuncode' => ($this -> input -> post ('newuncode'))? $this -> input -> post ('newuncode') : Null
			         );
				
				//print_r($deoData);exit();
				$data = $this -> System_setup_model ->deodb_save($deoData,$deocode);
			}else{
				$location = base_url(). "System_setup/deodb_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Store Keeper Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
		}

	//=================Function for data entry operator-Save end Here======================================//
	//--------------------------------------------------------------------------------------------------------//
	//=============Function data entry operator Edit here==================================================//
	
	public function deodb_edit(){
        dataEntryValidator(0);
		$deocode = $this -> uri -> segment(3);
		//echo $deocode;exit();
		$data = $this -> System_setup_model -> deodb_edit($deocode);
		//print_r($data);exit;
		//exit();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dodb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Data Entry Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//=============Function data entry operator Edit here==================================================//
	//-----------------------------------------------------------------------------------------------------/
	//=================Function for Data Entry operator-List start Here =======================================//
  
  public  function deodb_list(){
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "deodb";
		$data = $this -> System_setup_model -> deodb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dodb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Data Entry Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
  }
  
	//===================Function for Data Entry operator-List end Here=====================================//
	//--------------------------------------------------------------------------------------------------------//
	
	//================Function for  Data Entry operator-View start Here=============================//
	
	public function deodb_view(){
		$docode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> deodb_view($docode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dodb_view';
			$data['pageTitle'] = 'EPI-MIS | Data Entry Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	//================Function for  Data Entry operator-View end Here=============================//
	//-----------------------------------------------------------------------------------------------//
	
	//================Function for Data Entry operator-Edit start Here--------------------------//
	
	
	//================Function for Data Entry operator-Edit end Here--------------------------//
	//----------------------------------------------------------------------------------------//
	//---------------------------------Data Entry Operator Panel END---------------------------------------//
	//----------------------------------------------------------------------------------------------------//

	//================ Technician Listing Function Starts Here ===============================================//
	public function technician_list() {
		
		//Code for Pagination 
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0){
			$page = 1;
		}
		// Set how many records do you want to display per page.
		$per_page = 15;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "techniciandb ";// Change `records` according to your table name.
				
		$data = $this -> System_setup_model -> technician_list($startpoint,$per_page);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if ($data != 0) {
			$data['data'] = $data;
			$data['edit'] = 'Yes';
			$data['fileToLoad'] = 'system_setup/technician_list';
			$data['pageTitle'] = 'EPI Technician-MIS | List of EPI Technician';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Technician Listing Function Ends Here ======================================//
	//---------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Adding New Technician Record Starts Here =========//
	public function technician_add() {
		dataEntryValidator(0);
	//	echo "dan";exit;
		$data = $this -> System_setup_model -> technician_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/technician_add';
			//$data['fileToLoad'] = 'Add_red_microplanning/red_map_add';
			$data['pageTitle'] = 'EPI Technician-MIS | Add New EPI Technician Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Saving New Technician Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	public function technician_save() {
		dataEntryValidator(0);
		$dsoCode = $this -> input -> post ('dsocode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('techniciancode','Technician Code','trim|required|numeric');
		$this->form_validation->set_rules('technicianname','Technician Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('husbandname','Husband Name','trim');
		$this->form_validation->set_rules('facode','Facility Name','trim|required|min_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[10]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|required|max_length[50]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('catch_area_pop','Catchment Area population ','numeric|trim|required|max_length[9]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$techniciancode=$this -> input -> post ('techniciancode');
		//echo $techniciancode;exit;
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
			if($techniciancode!='' && $edit!=''){
				//echo 'hereeeeeeee1221313';exit;
				//dataEntryValidator();
				//$supervisorcode = $this -> uri -> segment(3);
				$data = $this -> System_setup_model -> technician_edit($techniciancode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/technician_edit';
					$data['pageTitle'] = 'EPI Technician-MIS | Update Technician Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> technician_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/technician_add';
					$data['pageTitle'] = 'EPI Technician-MIS | Add New EPI Technician Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				}else{
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
			
			
		}
		else{
		
			if($this -> input -> post ('techniciancode')){
				if (!empty($_FILES["technician_picture"]["name"])) {
					//Get the file information
					$userfile_size = $_FILES["technician_picture"]["size"];
					$filename = basename($_FILES["technician_picture"]["name"]);
					$file_ext = substr($filename, strrpos($filename, ".") + 1);
					$max_file = 2000000;
					//Only process if the file is a JPG and below the allowed limit
					if((!empty($_FILES["technician_picture"])) && ($_FILES["technician_picture"]["error"] == 0)) {
						$error=0;
					}else{
					   $error= "Select a jpeg image for upload";
					}
					//Everything is ok, so we can upload the image.
					if (strlen($error)==0){
						if (isset($_FILES["technician_picture"]["name"])){
							$sImage = $this -> System_setup_model -> uploadImageFile();
						}
					}
					if (strlen($error) != 0){
						$script = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("'. $error . '");';
						$script .= 'history.go(-1);';
						$script .= '</script>';
						echo $script;
						exit();	
					}
				}
				$this->db->select('uncode');
				$this->db->where('facode',$this ->input -> post ('facode'));
				$uncodeResult = $this->db->get('facilities')->row();
				$uncode = $uncodeResult->uncode;
			//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
				$technicianCode = $this -> input -> post ('techniciancode');	
				$technicianData = array(
					'procode' => $this -> session -> Province,
					'techniciancode' => ($this ->input -> post ('techniciancode')) ? $this ->input -> post ('techniciancode') : Null ,
					'technicianname' => ($this ->input -> post ('technicianname')) ? $this ->input -> post ('technicianname') : Null ,
					'husbandname' => ($this ->input -> post ('husbandname')) ? $this ->input -> post ('husbandname') : Null ,
					'fathername' => ($this ->input -> post ('fathername')) ? $this ->input -> post ('fathername') : Null ,
					'bid' => ($this ->input -> post ('bankid')) ? $this ->input -> post ('bankid') : Null ,
					'bankaccountno' => ($this ->input -> post ('bankaccountno')) ?  $this ->input -> post ('bankaccountno') : Null ,
					'nic' => ($this ->input -> post ('nic')) ? $this ->input -> post ('nic') : $this ->input -> post ('nic') ,
					'date_of_birth' => ($this ->input -> post ('date_of_birth'))? date('Y-m-d', strtotime($this ->input -> post ('date_of_birth'))) : Null ,
					'distcode' => ($this ->input -> post ('distcode')) ? $this ->input -> post ('distcode') : Null ,
					'facode' => ($this ->input -> post ('facode')) ? $this ->input -> post ('facode') : Null ,
					'supervisorcode' => ($this ->input -> post ('supervisorcode')) ? $this ->input -> post ('supervisorcode') : Null ,
					'tcode' => ($this ->input -> post ('tcode')) ? $this ->input -> post ('tcode') : Null ,
					'uncode' => ($uncode) ? $uncode : Null ,
					'catch_area_pop' => ($this ->input -> post ('catch_area_pop')) ? : Null ,
					'catch_area_name' => ($this ->input -> post ('catch_area_name')) ? $this ->input -> post ('catch_area_name') : Null ,
					'permanent_address' => ($this ->input -> post ('permanent_address')) ? $this ->input -> post ('permanent_address') : Null ,
					'present_address' => ($this ->input -> post ('present_address')) ? $this ->input -> post ('present_address') : Null ,
					'lastqualification' => ($this ->input -> post ('lastqualification')) ? $this ->input -> post ('lastqualification') : Null ,
					'passingyear' => ($this ->input -> post ('passingyear')) ? $this ->input -> post ('passingyear') : Null ,
					'institutename' => ($this ->input -> post ('institutename')) ? $this ->input -> post ('institutename') : Null ,
					'date_joining' => ($this ->input -> post ('date_joining')) ? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null ,
					'place_of_joining' => ($this ->input -> post ('place_of_joining')) ? $this ->input -> post ('place_of_joining') : Null ,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_resigned' => ($this -> input -> post ('date_resigned'))? date('Y-m-d', strtotime($this ->input -> post ('date_resigned'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this ->input -> post ('status')) ? $this ->input -> post ('status') : Null ,
					'areatype' => ($this ->input -> post ('areatype')) ? $this ->input -> post ('areatype') : Null ,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					
					
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null			
				);
				$technicianNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,

                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);
				//print_r($technicianNewData);exit;
				$data = $this -> System_setup_model -> technician_save($technicianData,$technicianCode,$technicianNewData);
			}else{
				$location = base_url(). "System_setup/technician_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Supervisor Code Provided....");window.location="'.$location.'"</script>';
			}
		
		}
	}		
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Viewing Existing Technician Record Starts Here ======================//
	public function technician_view() {

		$techniciancode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> technician_view($techniciancode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/technician_view';
			$data['pageTitle'] = 'Technician-MIS | EPI Detail View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here =============//
	public function technician_edit() {
		dataEntryValidator(0);
		$techniancode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> technician_edit($techniancode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/technician_edit';
			$data['pageTitle'] = 'EPI-MIS | Update EPI Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here =============//
	//-----------------------------------------------------------------------------------------------------//
	//================ Function to Show Listing Page for Health Facility Starts Here ==========================//
	public function flcf_list() {
		//Code for Pagination 
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		//Set how many records do you want to display per page.
		$per_page = 15;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "facilities ";// Change `records` according to your table name.
		
		$data = $this -> System_setup_model -> flcf_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		
		$data['UserLevel']=$this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		//print_r($data);exit;
		//echo $this->db->last_query();exit;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/flcf_list';
			$data['pageTitle'] = 'EPI-MIS | List of FLCF of National Program FP & PHC';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Listing Page for Health Facility Ends Here ====================//
	//---------------------------------------------------------------------------------------------//
	//================ Function for Marking and Unmarking Health Facility Starts Here =================//
	public function mark_flcf() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> mark_flcf();
		if ($data != 0) {
				   
																
																
			redirect(base_url().'EPICenters/Mark');
			exit();
		} else {
			syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
			syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
			syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
		  
		  
																  
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function for Marking and Unmarking Health Facility Ends Here ==========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Showing Marking List to Mark/Unmark Health Facility Starts Here ===========//
	public function flcf_marker_list() {
		$data = $this -> System_setup_model -> flcf_marker_list();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/flcf_marker_list';
			$data['pageTitle'] = 'EPI-MIS | Mark FLCF Centers for EPI Program';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function for Showing Marking List to Mark/Unmark Health Facility Ends Here =============//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Adding New Facility or Editing Existing Health Facility Starts Here =======//
	
	public function flcf_add() {
		dataEntryValidator(0);
		$district	= $this -> session -> District;
		$query="select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result=$this->db->query($query);
		$data['district']=$result->result_array();
		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by facode";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		$query = "SELECT distinct fatype,display_order from facilities_types order by display_order asc";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tcode";
		$resultTeh=$this->db->query($query);
		$data['resultTeh']=$resultTeh->result_array();
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by uncode";
		$resultun=$this->db->query($query);
		$data['resultun']=$resultun->result_array();
		$data['data'] = $data;			
		if( ! $this->input->post('submit')){
			if($this -> input -> get('facode')){
				$facode = $this->input->get('facode');
				$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as unname from facilities WHERE facode = '$facode' ";
				$resultF =$this->db->query($query);
				$data['dataFacility'] = $resultF->row_array();	
				$data["edit"] = "Yes";
			}
			$data['fileToLoad'] = 'system_setup/flcf_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Health Facility';
			$this -> load -> view('template/epi_template', $data);
			
		}else{
			//////////////////////Checking Validation Rules////////////////////////////////////////////////
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			$this->form_validation->set_rules('fac_name','Facility Name','trim|required');
			$this->form_validation->set_rules('facode','Facility Code','trim|required|min_length[6]|max_length[6]');
			//$this->form_validation->set_rules('population','Population','trim|required|numeric|max_length[9]');
			$this->form_validation->set_rules('tcode','Tehsil','trim|required|numeric');
				
			if ($this->form_validation->run() === FALSE)
			{
				if($this->input->post('facode') && $this -> input -> post('edit')){
					$facode = $this->input->post('facode');
					$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as unname from facilities WHERE facode = '$facode' ";
					$resultF =$this->db->query($query);
					$data['dataFacility'] = $resultF->row_array();	
					$data["edit"] = "Yes";	
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/flcf_add';
					$data['pageTitle'] = 'EPI-MIS | Update New Health Facility';
					$this -> load -> view('template/epi_template', $data);						
				}else{
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/flcf_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Health Facility';
					$this -> load -> view('template/epi_template', $data);
				}
			}
			else{
				//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
				$flcfData = array(
					'fac_name' 	 =>  $this -> input -> post('fac_name'),       
					'facode' 	 =>  $this -> input -> post('facode'),
					'procode'	 =>  $this -> session -> Province,
					'distcode' 	 =>  $this -> input -> post('distcode'),
					'tcode' 	 =>  $this -> input -> post('tcode'),          
					'uncode' 	 =>  $this -> input -> post('uncode'),
					'areatype' 	 =>  $this -> input -> post('areatype'),       
					'fatype' 	 =>  $this -> input -> post('fatype'),
					'fac_address'  =>  $this -> input -> post('fac_address'),  
					//'catchment_area_pop' =>  $this -> input -> post('population'),
					'func_status'=>  'N',       'rep_status' =>  'N',          
					'hf_type'    =>  'e',
					'is_ds_fac'    =>  ($this -> input -> post('is_ds_fac') && $this -> input -> post('is_ds_fac')==1)?1:0,
					'is_vacc_fac'    =>  ($this -> input -> post('is_vacc_fac') && $this -> input -> post('is_vacc_fac')==1)?1:0,
					'facid'      =>  'LD'.$this -> input -> post('distcode').'-'.$this -> input -> post('facode')
				);
				$data = $this -> System_setup_model -> flcf_add($flcfData);
				if($this -> input -> get('facode')){
					$data["edit"] = "Yes";
				}
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/flcf_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Health Facility';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}

		}
	}
	public function flcf_view_excel(){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=EPI_Center_Details.xls");
		header("Pragma: no-cache");
		header("Expires: 0");   
		$years = $this->uri->segment(4);
		$facode  = $this->uri->segment(3);
		//print_r($facode); exit;
		$data = $this -> System_setup_model -> getMainIndicatorsData($facode,$years);
		//print_r($data); exit;
        $data1 = $this -> System_setup_model -> flcf_view($facode);
		$data2 = $this -> System_setup_model -> flcf_view_ajax($facode);
		//print_r($data1); exit;
		$data['data']=$data1;
		$data['data2']=$data2;
		//print_r($data); exit;
			if($data != 0){
				
				$data['fileToLoad'] = 'system_setup/flcf_view_excel';
				$data['pageTitle']='EPI-MIS | View Health Facility';
				$this->load->view('system_setup/flcf_view_excel',$data);
			}else{

				$data['message']="You must have rights to access this page.";
                $this->load->view("message",$data);
            }
		}
	public function flcf_view(){
		$years = $this->input->get_post('year');
		$ajax  = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):FALSe;
	    //$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		$facode  = ($this -> input -> get_post('facode'));
		//print_r($facode); exit;
		//print_r($data); exit;
		$data = $this -> System_setup_model -> getMainIndicatorsData($facode,$years);
		//print_r($data); exit;
		
		if($ajax)
		{
			$indicators = array_slice($data, 0, 14, true);
			$cardsviews = $this -> load -> view('system_setup/indicatorcardsflcf', $indicators, TRUE);
			$arr = array('cards' => $cardsviews);
			echo json_encode($arr);
			exit;
		}
        $data1 = $this -> System_setup_model -> flcf_view($facode);
		$data['data']=$data1;
		$data['data']['years']=$years;
		$data['data']['facode']=$facode;
		//print_r($data); exit;
			if($data != 0){
				
				$data['fileToLoad'] = 'system_setup/flcf_view';
				$data['pageTitle']='EPI-MIS | View Health Facility';
				$this->load->view('template/epi_template',$data);
			}else{

				$data['message']="You must have rights to access this page.";
                $this->load->view("message",$data);
            }
	}
	
	function flcf_view_ajax(){
		$facode  = ($this -> input -> get_post('facode'));
		$data['flcf_consumption'] = $this -> System_setup_model -> flcf_view_ajax($facode);
		if(empty($data['flcf_consumption'])){
			$flcf_consumption_ajax = "";
		}else{
		$flcf_consumption_ajax = $this->load->view('system_setup/ajax/flcf_view_consumption.php',$data,true);
		//print_r($data);
		}
		echo $flcf_consumption_ajax;
	}
	
	//================ Function for Adding New Facility or Editing Existing Health Facility Ends Here =======//
	//----------------------------------------------------------------------------------------------------//
	//================ Driver Listing Function Starts ================//
	public function driverdb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "driverdb ";
		$data = $this -> System_setup_model -> driverdb_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/driverdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Drivers';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Driver Listing Function Ends Here =============================//
	//---------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Adding New Driver Record Starts Here =========//
	public function driverdb_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> driverdb_add();
		if ($data != 0) {
			$data['data'] = $data;
			$data['edit'] = "Yes";
			$data['fileToLoad'] = 'system_setup/driverdb_add';
			$data['pageTitle'] = 'EPI Driver-MIS | Add New EPI Driver Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Saving New Driver Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	public function driverdb_save() {
		//start new code
		dataEntryValidator(0);
		$drivercode = $this -> input -> post ('drivercode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('drivername','Driver Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','trim|required|alpha_spaces|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$drivercode =  $this -> input -> post('drivercode');	
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($drivercode!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> driverdb_edit($drivercode);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/driverdb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Mechanic Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> driverdb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/driverdb_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Mechanic Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($drivercode!=''){
		//end
		
		//dataEntryValidator(0);
		
		//if($this -> input -> post ('drivercode')){
			
			/*$mylist=$this ->input -> post ('aslist');
			foreach($mylist as $row){
				$newlist[] = $row;
			}
			$allownlist=implode(',',$newlist);*/

			/*if($this ->input -> post ('deductionslist')){
				$deductionslist=$this ->input -> post ('deductionslist');
				foreach($deductionslist as $row){
					$new[] = $row;
				}
				$deulist=implode(',',$new);
			}*/
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit;
			//$drivercode = $this -> input -> post ('drivercode');
			//print_r($drivercode);exit;
			
			$driverData = array(
				'procode' => $this -> session -> Province,
				'drivercode' => ($this ->input -> post ('drivercode')) ? $this ->input -> post ('drivercode') : Null ,
				'drivername' => ($this ->input -> post ('drivername')) ? $this ->input -> post ('drivername') : Null ,
				'fathername' => ($this ->input -> post ('fathername')) ? $this ->input -> post ('fathername') : Null ,
				'bid' => ($this ->input -> post ('bankcode')) ? $this ->input -> post ('bankcode') : Null ,
				'bankaccount' => ($this ->input -> post ('bankaccount')) ?  $this ->input -> post ('bankaccount') : Null ,
				'nic' => ($this ->input -> post ('nic')) ? $this ->input -> post ('nic') : $this ->input -> post ('nic') ,
				'date_of_birth' => ($this ->input -> post ('date_of_birth'))? date('Y-m-d', strtotime($this ->input -> post ('date_of_birth'))) : Null ,
				'distcode' => ($this ->input -> post ('distcode')) ? $this ->input -> post ('distcode') : Null ,
				//'facode' => ($this ->input -> post ('facode')) ? $this ->input -> post ('facode') : Null ,
				'supervisorcode' => ($this ->input -> post ('supervisorcode')) ? $this ->input -> post ('supervisorcode') : Null ,
				//'tcode' => ($this ->input -> post ('tcode')) ? $this ->input -> post ('tcode') : Null ,
				//'uncode' => ($this ->input -> post ('uncode')) ? $this ->input -> post ('uncode') : Null ,
				//'officer_type' => ($this ->input -> post ('officer_type')) ? $this ->input -> post ('officer_type') : Null ,
				'permanent_address' => ($this ->input -> post ('permanent_address')) ? $this ->input -> post ('permanent_address') : Null ,
				'present_address' => ($this ->input -> post ('present_address')) ? $this ->input -> post ('present_address') : Null ,
				'lastqualification' => ($this ->input -> post ('lastqualification')) ? $this ->input -> post ('lastqualification') : Null ,
				'passingyear' => ($this ->input -> post ('passingyear')) ? $this ->input -> post ('passingyear') : Null ,
				'institutename' => ($this ->input -> post ('institutename')) ? $this ->input -> post ('institutename') : Null ,
				'date_joining' => ($this ->input -> post ('date_joining')) ? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null ,
				'place_of_joining' => ($this ->input -> post ('place_of_joining')) ? $this ->input -> post ('place_of_joining') : Null ,
				'date_termination' => ($this ->input -> post ('date_termination')) ? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null ,
				'status' => ($this ->input -> post ('status')) ? $this ->input -> post ('status') : Null ,
				'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
				'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				//'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				//'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				//'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'bankaccount' => ($this -> input -> post ('bankaccount'))? $this -> input -> post ('bankaccount') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				//'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				//'supervisor_type' => ($this -> input -> post ('supervisor_type'))? $this -> input -> post ('supervisor_type') : Null,
				'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
				'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
			);
			$drivercodeNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
					'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);    
			$data = $this -> System_setup_model -> driverdb_save($driverData,$drivercode,$drivercodeNewData);
			
		}else{
			$location = base_url(). "System_setup/driverdb_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Driver Code Provided....");window.location="'.$location.'"</script>';
			}
		}
	}
	//================ Function for Saving New or Existing Driver Record Starts Here ================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Driver Record Starts Here =============//
	public function driverdb_edit() {
		dataEntryValidator(0);
		$drivercode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> driverdb_edit($drivercode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/driverdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Driver Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here =============//
	//-------------------------------------------------------------------------------------------------------//
		//================ Function for Viewing Existing Driver Record Starts Here ======================//
	public function driverdb_view() {
		$drivercode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> driverdb_view($drivercode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/driverdb_view';
			$data['pageTitle'] = 'EPI-MIS | Driver Detail View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//----------------------------------------------------------------------------------------------------//
public function codb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "codb ";
		$data = $this -> System_setup_model -> codb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/codb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Computer Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Supervisor Starts Here =======//	
	public function codb_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> codb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/codb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Computer Operator Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Supervisor Record Starts Here =================//
	public function codb_save() {
		dataEntryValidator(0);
		$cocode = $this -> input -> post ('cocode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('coname','Computer Operator Name','trim|required|alpha_spaces');
		 $this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		
	$cocode =  $this -> input -> post('cocode');	
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($cocode!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> codb_edit($cocode);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/codb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Computer Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> codb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/codb_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Computer Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($cocode!=''){
			$coData = array(
					'procode' => $this -> session -> Province,
					'cocode' => ($this -> input -> post ('cocode'))? $this -> input -> post ('cocode') : Null,
					'coname' => ($this -> input -> post ('coname'))? $this -> input -> post ('coname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					//'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_resigned' => ($this -> input -> post ('date_resigned'))? date('Y-m-d', strtotime($this ->input -> post ('date_resigned'))) : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					//'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					//'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
					
				); 
			$coDataNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					//'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					//'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					//'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);
				//echo '<pre>';print_r($coDataNewData);echo '</pre>';exit();
				$data = $this -> System_setup_model -> codb_save($coData,$cocode,$coDataNewData);
			}else{
				$location = base_url(). "System_setup/codb_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Computer Operator Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	//================ Function for Saving New or Existing Computer Operator Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Computer Operator Record Starts Here ===============//
	public function codb_edit() {
        dataEntryValidator(0);
		$cocode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> codb_edit($cocode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/codb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Computer Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Computer Operator Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Computer Operator Record Starts Here ==============//
	public function codb_view() {
	//	echo "danish";exit;
		$cocode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> codb_view($cocode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/codb_view';
			$data['pageTitle'] = 'EPI-MIS | Computer Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Computer Operator Record Ends Here ================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Measles Focal Person Starts Here =======//	
	public function mfpdb_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> mfpdb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/mfpdb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Measles Focal Person Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Supervisor Record Starts Here =================//
	public function mfpdb_save() {
		dataEntryValidator(0);
		$mfpcode = $this -> input -> post ('mfpcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('mfpname','Measles Focal Person Name','trim|required|alpha_spaces');
		 $this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','trim|required|alpha_spaces|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		
	$mfpcode =  $this -> input -> post('mfpcode');	
		if ($this->form_validation->run() === FALSE)  
		{
			$edit =  $this -> input -> post('edit');
				if($mfpcode!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> mfpdb_edit($mfpcode);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/mfpdb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Measles Focal Person Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> mfpdb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/mfpdb_add';
						$data['pageTitle'] = 'EPI-MIS | Add Measles Focal Person Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($mfpcode!=''){
				/* $this->db->select('uncode');
				$this->db->where('facode',$this ->input -> post ('facode'));
				$uncodeResult = $this->db->get('facilities')->row();
				$uncode = $uncodeResult->uncode; */
				
				$mfpData = array(
					'procode' => $this -> session -> Province,
					'mfpcode' => ($this -> input -> post ('mfpcode'))? $this -> input -> post ('mfpcode') : Null,
					'mfpname' => ($this -> input -> post ('mfpname'))? $this -> input -> post ('mfpname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					//'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_resigned' => ($this -> input -> post ('date_resigned'))? date('Y-m-d', strtotime($this ->input -> post ('date_resigned'))) : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					//'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					//'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
					
				);
				
				
				$mfpDataNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					//'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					//'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					//'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					
				);
				//echo '<pre>';print_r($mfpData);echo '</pre>';exit();
				$data = $this -> System_setup_model -> mfpdb_save($mfpData,$mfpcode,$mfpDataNewData);
			}else{
				$location = base_url(). "System_setup/mfpdb_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Measles Focal Person Code Provided....");	window.location="'.$location.'"</script>';
			
			}
		}
	}
	//================ Function for Saving New or Existing Computer Measles Focal Person Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Measles Focal Person Record Starts Here ===============//
		public function mfpdb_edit() {
        dataEntryValidator(0);
		$mfpcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> mfpdb_edit($mfpcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/mfpdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Measles Focal Person Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Measles Focal Person Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Measles Focal Person Starts Here ==============//
	public function mfpdb_view() {
		$mfpcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> mfpdb_view($mfpcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/mfpdb_view';
			$data['pageTitle'] = 'EPI-MIS | Measles Focal Person Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for View Measles Focal Person  Ends Here =========================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for list Measles Focal Person Record Starts Here ==============//

public function mfpdb_list() {
	//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "mfpdb ";
		$data = $this -> System_setup_model -> mfpdb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/mfpdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Measles Focal Person';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//

	
	//--------------------------------------------------------------------------------------------------------//
	//================ District Surveillance Officer Listing Function Starts ================//
	public function dsodb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "dsodb ";
		$data = $this -> System_setup_model -> dsodb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dsodb_list';
			$data['pageTitle'] = 'EPI-MIS | List of District Surveillance Officer';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ District Surveillance Officer Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New District Surveillance Officer Starts Here =======//	
	public function dsodb_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> dsodb_add();
		//$data['edit']="Yes";
		$data['data'] = "";
		$data['fileToLoad'] = 'system_setup/dsodb_add';
		$data['pageTitle'] = 'EPI-MIS | Add New District Surveillance Officer Form';
		$this -> load -> view('template/epi_template', $data);
		
	}
	//================ Function to Show Page for Adding New District Surveillance Officer Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing District Surveillance Officer Record Starts Here =================//
	public function dsodb_save() {
		//print_r($_POST);exit();
		dataEntryValidator(0);
		$dsocode = $this -> input -> post ('dsocode');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('dsoname','District Surveillance Officer Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','trim|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','trim|max_length[14]|min_length[11]|numeric'); 
		$this->form_validation->set_rules('cellphone','Cellphone','trim|min_length[11]|max_length[14]|numeric');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','trim|max_length[15]');
		$this->form_validation->set_rules('present_address','Present Address','trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','trim|max_length[5]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|required|max_length[50]');
	if ($this->form_validation->run() === FALSE) 
	{
		$edit =  $this -> input -> post('edit');
			if($dsocode!='' && $edit!=''){
				$data = $this -> System_setup_model -> dsodb_edit($dsocode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/dsodb_edit';
					$data['pageTitle'] = 'EPI-MIS | Update District Surveillance Officer Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> dsodb_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/dsodb_add';
					$data['pageTitle'] = 'EPI-MIS | Add New District Surveillance Officer Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
		if($this -> input -> post ('dsocode')){
			$dsoData = array(
				'procode' => $this -> session -> Province,
				'dsocode' => ($this -> input -> post ('dsocode'))? $this -> input -> post ('dsocode') : Null,
				'dsoname' => ($this -> input -> post ('dsoname'))? $this -> input -> post ('dsoname') : Null,
				'fathername' => ($this -> input -> post('fathername'))? $this -> input -> post('fathername'): Null,
				'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
				'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
				'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
				'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
				'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
		 		'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
				'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
				'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
				'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
				'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
				'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
				'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
				'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
				'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
				'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'cellphone' => ($this -> input -> post ('cellphone'))? $this -> input -> post ('cellphone') : Null,
				'telephone' => ($this -> input -> post ('telephone'))? $this -> input -> post ('telephone') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
				'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
				'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
				'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
				'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
				'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
				'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
				'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
				'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
				'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
				'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
				
			); 
			$dsocodeNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,

                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					
				);
																		
			//echo '<pre>';print_r($dsoData);echo '</pre>';exit();
			$data = $this -> System_setup_model -> dsodb_save($dsoData,$dsocode,$dsocodeNewData);
		}else{
			$location = base_url(). "System_setup/dsodb_list/";
				echo '<script language="javascript" type="text/javascript">;	window.location="'.$location.'"</script>';
			}
		}
	}
	//================ Function for Saving New or Existing District Surveillance Officer Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing District Surveillance Officer Record Starts Here ===============//
	public function dsodb_edit() {
		dataEntryValidator(0);
		$dsocode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> dsodb_edit($dsocode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dsodb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update District Surveillance Officer Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing District Surveillance Officer Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing District Surveillance Officer Record Starts Here ==============//
	public function dsodb_view() {
		$dsocode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> dsodb_view($dsocode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/dsodb_view';
			$data['pageTitle'] = 'EPI-MIS | District Surveillance Officer Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing District Surveillance Officer Record Ends Here ================//
		//--------------------------------------------------------------------------------------------------------//
	//================ Cold Chain Technician Listing Function Starts ================//
	public function cctdb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cctdb ";
		$data = $this -> System_setup_model -> cctdb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cctdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Technician';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Cold Chain Technician Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Technician Starts Here =======//	
	public function cctdb_add() {
	    dataEntryValidator(0);
		$data = $this -> System_setup_model -> cctdb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cctdb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Technician Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Technician Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Technician Record Starts Here =================//
	public function cctdb_save() {
		dataEntryValidator(0);
		$cctCode = $this -> input -> post ('cctcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('cctname','Cold Chain Technician Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		
	$cctcode =  $this -> input -> post('cctcode');
	if ($this->form_validation->run() === FALSE) 
	{
		$edit =  $this -> input -> post('edit');
			if($cctcode!='' && $edit!=''){
				//echo 'hereeeeeeee1221313';exit;
				dataEntryValidator();
				//$supervisorcode = $this -> uri -> segment(3);
				$data = $this -> System_setup_model -> cctdb_edit($cctcode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/cctdb_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Technician Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> cctdb_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/cctdb_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Technician Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
			//echo 'innnn'.$supervisorcode;
		if($this -> input -> post ('cctcode')){
			

			
			$cctData = array(
				'procode' => $this -> session -> Province,
				'cctcode' => ($this -> input -> post ('cctcode'))? $this -> input -> post ('cctcode') : Null,
				'cctname' => ($this -> input -> post ('cctname'))? $this -> input -> post ('cctname') : Null,
				'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
				'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
				'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
				'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
				'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
				'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
		 		'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
				'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
				'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
				'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
				'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
				'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
				'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
				'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
				'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
				'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
				'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
				'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
				'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
				'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
				'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
				'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
				'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
				'epimis_training_start_date' => ($this -> input -> post ('epimis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_start_date'))) : Null,
				'epimis_training_end_date' => ($this -> input -> post ('epimis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_end_date'))) : Null
			);
			//echo '<pre>';print_r($cctData);echo '</pre>';exit();
			$data = $this -> System_setup_model -> cctdb_save($cctData,$cctCode);
		}else{
			$location = base_url(). "System_setup/cctdb_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Technician Code Provided....");	window.location="'.$location.'"</script>';
		}
		}
	}
	//================ Function for Saving New or Existing Cold Chain Technician Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Technician Record Starts Here ===============//
	public function cctdb_edit() {
		dataEntryValidator(0);
		$cctcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cctdb_edit($cctcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cctdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Technician Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Cold Chain Technician Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Technician Record Starts Here ==============//
	public function cctdb_view() {
		$cctcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cctdb_view($cctcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cctdb_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Technician Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Technician Record Ends Here ================//
			//--------------------------------------------------------------------------------------------------------//
	//================ Cold Chain Mechanic Listing Function Starts ================//
	public function ccmdb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccmdb ";
		$data = $this -> System_setup_model -> ccmdb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccmdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Mechanic';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Cold Chain Mechanic Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Mechanic Starts Here =======//	
	public function ccmdb_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> ccmdb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccmdb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Mechanic Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Mechanic Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Mechanic Record Starts Here =================//
	public function ccmdb_save() {
		dataEntryValidator(0);
		$ccmCode = $this -> input -> post ('ccmcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('ccmname','Cold Chain Mechanic Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		
	$ccmcode =  $this -> input -> post('ccmcode');
	if ($this->form_validation->run() === FALSE) 
	{
		$edit =  $this -> input -> post('edit');
			if($ccmcode!='' && $edit!=''){
				//echo 'hereeeeeeee1221313';exit;
				dataEntryValidator();
				//$supervisorcode = $this -> uri -> segment(3);
				$data = $this -> System_setup_model -> ccmdb_edit($ccmcode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccmdb_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Mechanic Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> ccmdb_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccmdb_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Mechanic Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
			//echo 'innnn'.$supervisorcode;
		if($this -> input -> post ('ccmcode')){
			

			
			$ccmData = array(
				'procode' => $this -> session -> Province,
				'ccmcode' => ($this -> input -> post ('ccmcode'))? $this -> input -> post ('ccmcode') : Null,
				'ccmname' => ($this -> input -> post ('ccmname'))? $this -> input -> post ('ccmname') : Null,
				'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
				'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
				'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
				'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
				'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
				'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
		 		'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
				'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
				'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
				'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
				'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
				'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
				'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
				'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
				'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
				'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
				'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
				'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
				'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
				'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
				'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
				'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
				'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
				'epimis_training_start_date' => ($this -> input -> post ('epimis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_start_date'))) : Null,
				'epimis_training_end_date' => ($this -> input -> post ('epimis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_end_date'))) : Null
			);
			//echo '<pre>';print_r($dsoData);echo '</pre>';exit();
			$data = $this -> System_setup_model -> ccmdb_save($ccmData,$ccmCode);
		}else{
			$location = base_url(). "System_setup/ccmdb_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Mechanic Code Provided....");	window.location="'.$location.'"</script>';
		}
		}
	}
	//================ Function for Saving New or Existing Cold Chain Mechanic Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Mechanic Record Starts Here ===============//
	public function ccmdb_edit() {
		dataEntryValidator(0);
		$ccmcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccmdb_edit($ccmcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccmdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Mechanic Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Cold Chain Mechanic Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Mechanic Record Starts Here ==============//
	public function ccmdb_view() {
		$ccmcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccmdb_view($ccmcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccmdb_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Mechanic Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Mechanic Record Ends Here ================//
				//--------------------------------------------------------------------------------------------------------//
	//================ Cold Chain Generator Operator Listing Function Starts ================//
	public function ccgdb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccgdb ";
		$data = $this -> System_setup_model -> ccgdb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccgdb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Generator Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Cold Chain Generator Operator Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Generator Operator Starts Here =======//	
	public function ccgdb_add() {
        dataEntryValidator(0);
		$data = $this -> System_setup_model -> ccgdb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccgdb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Generator Operator Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Generator Operator Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Generator Operator Record Starts Here =================//
	public function ccgdb_save() {
		dataEntryValidator(0);
		$ccgCode = $this -> input -> post ('ccgcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('ccgname','Cold Chain Generator Operator Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		
		
		
	$ccgcode =  $this -> input -> post('ccgcode');
	if ($this->form_validation->run() === FALSE) 
	{
		$edit =  $this -> input -> post('edit');
			if($ccgcode!='' && $edit!=''){
				//echo 'hereeeeeeee1221313';exit;
				dataEntryValidator();
				//$supervisorcode = $this -> uri -> segment(3);
				$data = $this -> System_setup_model -> ccgdb_edit($ccgcode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccgdb_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Generator Operator Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> ccgdb_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccgdb_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Generator Operator Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
			//echo 'innnn'.$supervisorcode;
		if($this -> input -> post ('ccgcode')){
			

			
			$ccgData = array(
				'procode' => $this -> session -> Province,
				'ccgcode' => ($this -> input -> post ('ccgcode'))? $this -> input -> post ('ccgcode') : Null,
				'ccgname' => ($this -> input -> post ('ccgname'))? $this -> input -> post ('ccgname') : Null,
				'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
				'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
				'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
				'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
				'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
				'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
		 		'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
				'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
				'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
				'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
				'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
				'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
				'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
				'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
				'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
				'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
				'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
				'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
				'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
				'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
				'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
				'epimis_training_start_date' => ($this -> input -> post ('epimis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_start_date'))) : Null,
				'epimis_training_end_date' => ($this -> input -> post ('epimis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_end_date'))) : Null
			);
			//echo '<pre>';print_r($dsoData);echo '</pre>';exit();
			$data = $this -> System_setup_model -> ccgdb_save($ccgData,$ccgCode);
		}else{
			$location = base_url(). "System_setup/ccgdb_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Generator Operator Code Provided....");	window.location="'.$location.'"</script>';
		}
		}
	}
	//================ Function for Saving New or Existing Cold Chain Generator Operator Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Generator Operator Record Starts Here ===============//
	public function ccgdb_edit() {
		dataEntryValidator(0);
		$ccgcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccgdb_edit($ccgcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccgdb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Generator Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Cold Chain Generator Operator Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Generator Operator Record Starts Here ==============//
	public function ccgdb_view() {
		$ccgcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccgdb_view($ccgcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccgdb_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Generator Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Generator Operator Record Ends Here ================//
					//--------------------------------------------------------------------------------------------------------//
	//================ Cold Chain Driver Listing Function Starts ================//
	public function ccddb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccddb ";
		$data = $this -> System_setup_model -> ccddb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccddb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Driver';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Cold Chain Driver Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Driver Starts Here =======//	
	public function ccddb_add() {
        dataEntryValidator(0);
		$data = $this -> System_setup_model -> ccddb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccddb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Driver Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Driver Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Driver Record Starts Here =================//
	public function ccddb_save() {
		dataEntryValidator(0);
		$ccdCode = $this -> input -> post ('ccdcode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('ccdname','Cold Chain Driver Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$ccdcode =  $this -> input -> post('ccdcode');
	        if ($this->form_validation->run() === FALSE) 
    {
		$edit =  $this -> input -> post('edit');
			if($ccdcode!='' && $edit!=''){
				//echo 'hereeeeeeee1221313';exit;
				dataEntryValidator();
				//$supervisorcode = $this -> uri -> segment(3);
				$data = $this -> System_setup_model -> ccddb_edit($ccdcode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccddb_edit';
					$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Driver Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> ccddb_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/ccddb_add';
					$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Driver Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
			//echo 'innnn'.$supervisorcode;
		if($this -> input -> post ('ccdcode')){
			

			
			$ccdData = array(
				'procode' => $this -> session -> Province,
				'ccdcode' => ($this -> input -> post ('ccdcode'))? $this -> input -> post ('ccdcode') : Null,
				'ccdname' => ($this -> input -> post ('ccdname'))? $this -> input -> post ('ccdname') : Null,
				'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
				'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
				'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
				'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
				'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
				'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
				'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
				'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
				'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
				'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
		 		'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
				'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
				'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
				'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
				'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
				'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
				'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
				'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
				'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
				'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
				'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
				'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
				'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
				'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
				'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
				'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
				'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
				'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
				'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
				'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
				'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
				'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
				'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
				'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
				'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
				'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
				'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
				'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
				'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
				'epimis_training_start_date' => ($this -> input -> post ('epimis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_start_date'))) : Null,
				'epimis_training_end_date' => ($this -> input -> post ('epimis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('epimis_training_end_date'))) : Null
			);
			//echo '<pre>';print_r($dsoData);echo '</pre>';exit();
			$data = $this -> System_setup_model -> ccddb_save($ccdData,$ccdCode);
		}else{
			$location = base_url(). "System_setup/ccddb_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Driver Code Provided....");	window.location="'.$location.'"</script>';
		}
		}
	}
	//================ Function for Saving New or Existing Cold Chain Driver Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Driver Record Starts Here ===============//
	public function ccddb_edit() {
		dataEntryValidator(0);
		$ccdcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccddb_edit($ccdcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccddb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Driver Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Cold Chain Driver Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Driver Record Starts Here ==============//
	public function ccddb_view() {
		$ccdcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccddb_view($ccdcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccddb_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Driver Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Driver Record Ends Here ================//
	//==================== Function to Show Page for Adding New CC Operator Starts Here =============================//	


	public function ccoperatordb_add() {
        dataEntryValidator(0);
		$data = $this -> System_setup_model -> ccoperatordb_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccoperatordb_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Computer Operator Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Adding New CC Operator Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Supervisor Record Starts Here =================//
	public function ccoperatordb_save() {
        dataEntryValidator(0);
		$c_id = $this -> input -> post ('c_id')? $this -> input -> post ('c_id'):NULL;
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		//$this->form_validation->set_rules('ccoperatorname','Cold Chain Operator Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		//$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		//$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		//$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		//$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		
		
		if ($c_id = $this -> input -> post ('c_id')) 
		{
			$edit =  $this -> input -> post('edit');
				if($c_id!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> ccoperatordb_edit($c_id);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/ccoperatordb_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> ccoperatordb_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/ccoperatordb_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				$coData = array(
					'procode' => $this -> session -> Province,
					//'ccoperatorcode' => ($this -> input -> post ('ccoperatorcode'))? $this -> input -> post ('ccoperatorcode') : Null,
					'ccoperatorname' => ($this -> input -> post ('ccoperatorname'))? $this -> input -> post ('ccoperatorname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null
					
				);
				//echo '<pre>';print_r($coData);echo '</pre>';exit();
				$data = $this -> System_setup_model -> ccoperatordb_save($coData,$c_id);
			
		}
	}
	//================ Function for Saving New or Existing Computer Operator Record Ends Here ========================//
	//----------------------------------------------------------------------------------------------------//
	public function ccoperatordb_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "supervisordb";
		$data = $this -> System_setup_model -> ccoperatordb_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccoperatordb_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Computer Operator Record Starts Here ===============//
	public function ccoperatordb_edit() {
		dataEntryValidator(0);
		$c_id = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> ccoperatordb_edit($c_id);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccoperatordb_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing Computer Operator Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Computer Operator Record Starts Here ==============//
	public function ccoperatordb_view() {
		$c_id = $this -> uri -> segment(3);
		//$c_id = $this -> input -> get('c_id');		
		$data = $this -> System_setup_model -> ccoperatordb_view($c_id);
		
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/ccoperatordb_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Viewing Existing Computer Operator Record Ends Here ================//
	//================ Medical Technician Listing Function Starts Here ===============================================//
	public function med_technician_edit() {
		dataEntryValidator(0);
		$c_id = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> med_technician_edit($c_id);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/med_technician_edit';
			$data['pageTitle'] = 'EPI-MIS | Update HF Incharge Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function med_technician_list() {
		//Code for Pagination 
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0){
			$page = 1;
		}
		// Set how many records do you want to display per page.
		$per_page = 15;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "med_techniciandb ";// Change `records` according to your table name.
				
		$data = $this -> System_setup_model -> med_technician_list($startpoint,$per_page);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if ($data != 0) {
			$data['edit'] = 'yes';
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/med_technician_list';
			$data['pageTitle'] = 'EPI-MIS | List of HF Incharges';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Medical Technician Listing Function Ends Here ======================================//
	//================ Function to Show Page for Adding New Medical Technician Record Starts Here =========//
	public function med_technician_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> med_technician_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/med_technician_add';
			$data['pageTitle'] = 'EPI-MIS | Add New HF Incharge Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Saving New Medical Technician Record Ends Here =================//
	//================ Function for Saving New or Existing Medical Technician Record Starts Here ================//
	public function med_technician_save() {
		dataEntryValidator(0);
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('technicianname','Technician Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('husbandname','Husband Name','trim|alpha_spaces');
		$this->form_validation->set_rules('facode','Facility Name','trim|required|min_length[6]');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|required|max_length[6]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|trim|required|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|trim|required|max_length[16]');
		$this->form_validation->set_rules('catch_area_pop','Catchment Area population ','numeric|trim|required|max_length[9]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$techniciancode=$this -> input -> post ('techniciancode');
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
			if($techniciancode!='' && $edit!=''){
				//dataEntryValidator();
				$data = $this -> System_setup_model -> med_technician_edit($techniciancode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/med_technician_edit';
					$data['pageTitle'] = 'EPI-MIS | Update HF Incharge Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> med_technician_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/med_technician_add';
					$data['pageTitle'] = 'EPI-MIS | Add New HF Incharge Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
			
			
		}
		else{
			if($this -> input -> post ('techniciancode')){
				if (!empty($_FILES["technician_picture"]["name"])) {
					//Get the file information
					$userfile_size = $_FILES["technician_picture"]["size"];
					$filename = basename($_FILES["technician_picture"]["name"]);
					$file_ext = substr($filename, strrpos($filename, ".") + 1);
					$max_file = 2000000;
					//Only process if the file is a JPG and below the allowed limit
					if((!empty($_FILES["technician_picture"])) && ($_FILES["technician_picture"]["error"] == 0)) {
						$error=0;
					}else{
					   $error= "Select a jpeg image for upload";
					}
					//Everything is ok, so we can upload the image.
					if (strlen($error)==0){
						if (isset($_FILES["technician_picture"]["name"])){
							$sImage = $this -> System_setup_model -> uploadImageFile();
						}
					}
					if (strlen($error) != 0){
						$script = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("'. $error . '");';
						$script .= 'history.go(-1);';
						$script .= '</script>';
						echo $script;
						exit();	
					}
				}
				
				$technicianCode = $this -> input -> post ('techniciancode');	
				$technicianData = array(
					'procode' => $this -> session -> Province,
					'techniciancode' => ($this ->input -> post ('techniciancode')) ? $this ->input -> post ('techniciancode') : Null ,
					'technicianname' => ($this ->input -> post ('technicianname')) ? $this ->input -> post ('technicianname') : Null ,
					'husbandname' => ($this ->input -> post ('husbandname')) ? $this ->input -> post ('husbandname') : Null ,
					'fathername' => ($this ->input -> post ('fathername')) ? $this ->input -> post ('fathername') : Null ,
					'bid' => ($this ->input -> post ('bankid')) ? $this ->input -> post ('bankid') : Null ,
					'bankaccountno' => ($this ->input -> post ('bankaccountno')) ?  $this ->input -> post ('bankaccountno') : Null ,
					'nic' => ($this ->input -> post ('nic')) ? $this ->input -> post ('nic') : $this ->input -> post ('nic') ,
					'date_of_birth' => ($this ->input -> post ('date_of_birth'))? date('Y-m-d', strtotime($this ->input -> post ('date_of_birth'))) : Null ,
					'distcode' => ($this ->input -> post ('distcode')) ? $this ->input -> post ('distcode') : Null ,
					'facode' => ($this ->input -> post ('facode')) ? $this ->input -> post ('facode') : Null ,
					'supervisorcode' => ($this ->input -> post ('supervisorcode')) ? $this ->input -> post ('supervisorcode') : Null ,
					'tcode' => ($this ->input -> post ('tcode')) ? $this ->input -> post ('tcode') : Null ,
					'uncode' => ($this ->input -> post ('uncode')) ? $this ->input -> post ('uncode') : Null ,
					'catch_area_pop' => ($this ->input -> post ('catch_area_pop')) ? : Null ,
					'catch_area_name' => ($this ->input -> post ('catch_area_name')) ? $this ->input -> post ('catch_area_name') : Null ,
					'permanent_address' => ($this ->input -> post ('permanent_address')) ? $this ->input -> post ('permanent_address') : Null ,
					'present_address' => ($this ->input -> post ('present_address')) ? $this ->input -> post ('present_address') : Null ,
					'lastqualification' => ($this ->input -> post ('lastqualification')) ? $this ->input -> post ('lastqualification') : Null ,
					'passingyear' => ($this ->input -> post ('passingyear')) ? $this ->input -> post ('passingyear') : Null ,
					'institutename' => ($this ->input -> post ('institutename')) ? $this ->input -> post ('institutename') : Null ,
					'date_joining' => ($this ->input -> post ('date_joining')) ? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null ,
					'place_of_joining' => ($this ->input -> post ('place_of_joining')) ? $this ->input -> post ('place_of_joining') : Null ,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this ->input -> post ('status')) ? $this ->input -> post ('status') : Null ,
					'areatype' => ($this ->input -> post ('areatype')) ? $this ->input -> post ('areatype') : Null ,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
						
				);
				$technicianCodeNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,

                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					 
				);
	
				
				//echo '<pre>';print_r($technicianData);echo '</pre>';exit();
				$data = $this -> System_setup_model -> med_technician_save($technicianData,$technicianCode,$technicianCodeNewData);
			}else{
				$location = base_url(). "System_setup/med_technician_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Supervisor Code Provided....");window.location="'.$location.'"</script>';
			}
		
		}
	}
	//================ Function for Saving New or Existing Medical Technician Record Starts Here ================//
	//================ Function for Viewing Existing Technician Record Starts Here ======================//
	public function med_technician_view() {

		$techniciancode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> med_technician_view($techniciancode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/med_technician_view';
			$data['pageTitle'] = 'EPI-MIS | HF Incharge Detail View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cc_mechanic_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> cc_mechanic_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_mechanic_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Mechanic Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cc_mechanic_save() {
		dataEntryValidator(0);
		$ccm_code = $this -> input -> post ('ccm_code');
	
		
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('ccm_name','Cold Chain Mechanic Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','trim|required|alpha_spaces|max_length[50]');
		$ccm_code =  $this -> input -> post('ccm_code');	
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($ccm_code!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> cc_mechanic_edit($ccm_code);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cc_mechanic_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Mechanic Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> cc_mechanic_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cc_mechanic_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Mechanic Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($ccm_code!=''){
				
				
				$ccmData = array(
					'procode' => $this -> session -> Province,
					'ccm_code' => ($this -> input -> post ('ccm_code'))? $this -> input -> post ('ccm_code') : Null,
					'ccm_name' => ($this -> input -> post ('ccm_name'))? $this -> input -> post ('ccm_name') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
				);
		$cc_mechanicNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					
				);
					//print_r($ccmData);exit;
				//echo '<pre>';print_r($coData);echo '</pre>';exit();
				$data = $this -> System_setup_model ->cc_mechanic_save($ccmData,$ccm_code,$cc_mechanicNewData);
			}else{
				$location = base_url(). "System_setup/cc_mechanic_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Mechanic Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	public function cc_mechanic_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cc_mechanic";
		$data = $this -> System_setup_model -> cc_mechanic_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_mechanic_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Mechanic';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cc_mechanic_view() {
		//echo 'tania!'; exit;
		$ccm_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cc_mechanic_view($ccm_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_mechanic_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Mechanic Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cc_mechanic_edit() {
        dataEntryValidator(0);
		$ccm_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cc_mechanic_edit($ccm_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_mechanic_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Mechanic Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function go_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> go_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/go_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Generator Operator Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function go_save() {
		dataEntryValidator(0);
		$go_code = $this -> input -> post ('go_code');										   
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('go_name','Generator operator Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','trim|required|alpha_spaces|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$go_code =  $this -> input -> post('go_code');	
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($go_code!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> go_edit($go_code);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/go_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Generator Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> go_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/go_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Generator Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($go_code!=''){
				
				
				$goData = array(
					'procode' => $this -> session -> Province,
					'go_code' => ($this -> input -> post ('go_code'))? $this -> input -> post ('go_code') : Null,
					'go_name' => ($this -> input -> post ('go_name'))? $this -> input -> post ('go_name') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
				);
			$go_NewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);
				//print_r($ccmData);exit;
				//echo '<pre>';print_r($coData);echo '</pre>';exit();
				$data = $this -> System_setup_model ->go_save($goData,$go_code,$go_NewData);
			}else{
				$location = base_url(). "System_setup/go_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Generator Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	public function go_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "go_db";
		$data = $this -> System_setup_model -> go_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/go_list';
			$data['pageTitle'] = 'EPI-MIS | List of Generator Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function go_view() {
	//	echo "danish";exit;
		$go_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> go_view($go_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/go_view';
			$data['pageTitle'] = 'EPI-MIS | Generator Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function go_edit() {
        dataEntryValidator(0);
		$go_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> go_edit($go_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/go_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Generator Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cco_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model -> cco_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cco_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Operator Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cco_save() {
		dataEntryValidator(0);
		$cco_code = $this -> input -> post ('cco_code');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('cco_name','Generator operator Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$cco_code =  $this -> input -> post('cco_code');	
		if ($this->form_validation->run() === FALSE) 
		{
			$edit =  $this -> input -> post('edit');
				if($cco_code!='' && $edit!=''){
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> cco_edit($cco_code);
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cco_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					$data = $this -> System_setup_model -> cco_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cco_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Operator Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($cco_code!=''){
				
				
				$ccoData = array(
					'procode' => $this -> session -> Province,
					'cco_code' => ($this -> input -> post ('cco_code'))? $this -> input -> post ('cco_code') : Null,
					'cco_name' => ($this -> input -> post ('cco_name'))? $this -> input -> post ('cco_name') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
				);
			$ccoNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
					
				);
					//print_r($ccmData);exit;
				//echo '<pre>';print_r($coData);echo '</pre>';exit();
				$data = $this -> System_setup_model ->cco_save($ccoData,$cco_code,$ccoNewData); 
			}else{
				$location = base_url(). "System_setup/cco_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain operator Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	public function cco_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cco_db";
		$data = $this -> System_setup_model -> cco_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cco_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Operator';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cco_view() {
		$cco_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cco_view($cco_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cco_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Operator Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cco_edit() {
        dataEntryValidator(0);
		$cco_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cco_edit($cco_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cco_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Operator Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Saving New Technician Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	public function cc_technician_add() {
		dataEntryValidator(0);
		$data = $this -> System_setup_model ->cc_technician_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_technician_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Technician Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function cc_technician_save() {
	//print_r($_POST);exit;	
		dataEntryValidator(0);
		$cc_techniciancode = $this -> input -> post ('cc_techniciancode');
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('cc_technicianname','CC Technician Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|alpha_spaces');
		//$this->form_validation->set_rules('present_address','Present Address','alpha_spaces|trim|max_length[100]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','numeric_spaces|required|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','alpha_spaces|trim|required|max_length[50]');
		$this->form_validation->set_message('alpha_spaces', 'The Name field may only contain alpha and spaces.');
		$this->form_validation->set_message('numeric_spaces', 'The field may only number');
		$cc_techniciancode =  $this -> input -> post('cc_techniciancode');	
		//print($cc_techniciancode);exit;
		if ($this->form_validation->run() === FALSE)
		{
			$edit =  $this -> input -> post('edit');
				
				if($cc_techniciancode!='' && $edit!=''){
					
					//echo 'hereeeeeeee1221313';exit;
					//dataEntryValidator();
					//$supervisorcode = $this -> uri -> segment(3);
					$data = $this -> System_setup_model -> cc_technician_edit($cc_techniciancode);
					if ($data != 0) {
						
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cc_technician_edit';
						$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Technician Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}else{
					//print($cc_techniciancode);exit;
					$data = $this -> System_setup_model -> cc_technician_add();
					if ($data != 0) {
						$data['data'] = $data;
						$data['fileToLoad'] = 'system_setup/cc_technician_add';
						$data['pageTitle'] = 'EPI-MIS | Add New Cold Chain Technician Form';
						$data['edit']='1';
						$this -> load -> view('template/epi_template', $data);
					} else {
						$data['message'] = "You must have rights to access this page.";
						$this -> load -> view("message", $data);
					}
				}
		}
		else{
				
			if($cc_techniciancode!=''){
				
				
				$cc_technicianData = array(
					'procode' => $this -> session -> Province,
					'cc_techniciancode' => ($this -> input -> post ('cc_techniciancode'))? $this -> input -> post ('cc_techniciancode') : Null,
					'cc_technicianname' => ($this -> input -> post ('cc_technicianname'))? $this -> input -> post ('cc_technicianname') : Null,
					'husbandname' => ($this -> input -> post ('husbandname'))? $this -> input -> post ('husbandname') : Null,
					'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null,
					'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'designation' => ($this -> input -> post ('designation'))? $this -> input -> post ('designation') : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'place_of_posting' => ($this -> input -> post ('place_of_posting'))? $this -> input -> post ('place_of_posting') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_from' => ($this -> input -> post ('date_from'))? date('Y-m-d', strtotime($this ->input -> post ('date_from'))) : Null,
					'date_to' => ($this -> input -> post ('date_to'))? date('Y-m-d', strtotime($this ->input -> post ('date_to'))) : Null,
					'reason' => ($this -> input -> post ('reason'))? $this -> input -> post ('reason') : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'area_type' => ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'city' => ($this -> input -> post ('city'))? $this -> input -> post ('city') : Null,
					'postalcode' => ($this -> input -> post ('postalcode'))? $this -> input -> post ('postalcode') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					'previous_code'=>$this->input->post('previous_code')? $this->input->post('previous_code'):Null
				);
			$cc_techniciancodeNewData = array(
					'new_distcode' => ($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : $this->session->District,
					'new_facode'=> ($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null,
					'new_tcode'=> ($this -> input -> post ('new_tcode'))? $this -> input -> post ('new_tcode') : Null,
					'new_uncode'=> ($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null,		
					'new_lhwcodel'=> ($this -> input -> post ('new_lhwcodel'))? $this -> input -> post ('new_lhwcodel') : Null,
					'new_lhwcode'=> ($this -> input -> post ('new_lhwcode'))? $this -> input -> post ('new_lhwcode') : Null,
					'previouse_code'=>($this -> input -> post ('previouse_code'))? $this -> input -> post ('previouse_code') : Null,
					'previous_code'=>($this -> input -> post ('previous_code'))? $this -> input -> post ('previous_code') : Null,
                    'post_type'=>($this -> input -> post ('post_type'))? $this -> input -> post ('post_type') : Null
				);
				//print($cc_technicianData);exit;
					//print_r($ccmData);exit;
				//echo '<pre>';print_r($coData);echo '</pre>';exit();
				$data = $this -> System_setup_model ->cc_technician_save($cc_technicianData,$cc_techniciancode,$cc_techniciancodeNewData);
			}else{
				
				$location = base_url(). "System_setup/cc_technician_add/";
					echo '<script language="javascript" type="text/javascript"> alert("No Cold Chain Technician Code Provided....");	window.location="'.$location.'"</script>';
			}
		}
	}
	public function cc_technician_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cc_techniciandb";
		$data = $this -> System_setup_model -> cc_technician_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_technician_list';
			$data['pageTitle'] = 'EPI-MIS | List of Cold Chain Technician';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here =============//
	public function cc_technician_view() {
		$cc_technician_code = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cc_technician_view($cc_technician_code);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_technician_view';
			$data['pageTitle'] = 'EPI-MIS | Cold Chain Technician Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	
	public function cc_technician_edit() {
        dataEntryValidator(0);
		$cc_techniciancode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> cc_technician_edit($cc_techniciancode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/cc_technician_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Cold Chain Technician Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//--------------------------------------------------------------------//
	//===============AddHR Listing Function Starts ==================//
	public function AddHR_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "hrdb";
		$data = $this -> System_setup_model -> addhr_list($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/AddHR_list';
			$data['pageTitle'] = 'EPI-MIS | List of HR';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Add HR Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New AddHR Starts Here =======//	
	public function AddHR_add() {
		dataEntryValidator(1);
		//dataEntryValidator();
		$data = $this -> System_setup_model -> AddHR_add();
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/AddHR_add';
			$data['pageTitle'] = 'EPI-MIS | Add New HR Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	
	//================ Function to Show Page for Adding New AddHR Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing AddHR Record Starts Here =================//
		public function AddHR_save() {
			
		dataEntryValidator(1);
		$hrCode = $this -> input -> post ('hrcode');
		//echo $hrCode;exit;
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('basicpay','Basic Pay','numeric|trim|max_length[6]');
		$this->form_validation->set_rules('hrname','HR Name','trim|required|alpha_spaces');
		$this->form_validation->set_rules('phone','Phone','numeric|trim|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('bankaccountno','Bank Account Number','numeric_spaces|required|trim|max_length[16]');
		$this->form_validation->set_rules('nic','CNIC','alpha_dash|trim|required|max_length[15]');
		$this->form_validation->set_rules('passingyear','Passing year','numeric|trim|max_length[4]');
		$this->form_validation->set_rules('branchcode','Branch Code','required|numeric_spaces|trim|max_length[8]');
		$this->form_validation->set_rules('branchname','Branch Name','required|max_length[50]');
        $this->form_validation->set_rules('bankid','Bank Information','required|max_length[50]');		
	if ($this->form_validation->run() === FALSE) 
	{
		$edit =  $this -> input -> post('edit');
			if($hrCode!='' && $edit!=''){
				
				$data = $this -> System_setup_model -> AddHR_edit($hrCode);
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/AddHR_edit';
					$data['pageTitle'] = 'EPI-MIS | Update AddHR Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}else{
				$data = $this -> System_setup_model -> AddHR_add();
				if ($data != 0) {
					$data['data'] = $data;
					$data['fileToLoad'] = 'system_setup/AddHR_add';
					$data['pageTitle'] = 'EPI-MIS | Add New AddHR Form';
					$data['edit']='1';
					$this -> load -> view('template/epi_template', $data);
				} else {
					$data['message'] = "You must have rights to access this page.";
					$this -> load -> view("message", $data);
				}
			}
	}
		else{
			if($this -> input -> post ('hrcode')){
				//print_r($this -> input -> post ('designation_type')); exit;
				$hrData = array(
					'procode' => $this -> session -> Province,
					'hrcode' => ($this -> input -> post ('hrcode'))? $this -> input -> post ('hrcode') : Null,
					'designation_type' => ($this -> input -> post ('designation_type'))? $this -> input -> post ('designation_type') : Null,
					'hrname' => ($this -> input -> post ('hrname'))? $this -> input -> post ('hrname') : Null,
					//'fathername' => ($this -> input -> post ('fathername'))? $this -> input -> post ('fathername') : Null,
					'nic' => ($this -> input -> post ('nic'))? $this -> input -> post ('nic') : Null,
					'date_of_birth' => ($this -> input -> post ('date_of_birth')) ? date('Y-m-d', strtotime($this -> input -> post ('date_of_birth'))) : Null,
					//'distcode' => ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : $this -> session -> District,
					//'facode' => ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null,
					//'tcode' => ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null,
					'permanent_address' => ($this -> input -> post ('permanent_address'))? $this -> input -> post ('permanent_address') : Null,
					'present_address' => ($this -> input -> post ('present_address'))? $this -> input -> post ('present_address') : Null,
					'lastqualification' => ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null,
					'passingyear' => ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null ,
					'institutename' => ($this -> input -> post ('institutename'))? $this -> input -> post ('institutename') : Null,
					'date_joining' => ($this -> input -> post ('date_joining'))? date('Y-m-d', strtotime($this ->input -> post ('date_joining'))) : Null,
					'place_of_joining' => ($this -> input -> post ('place_of_joining'))? $this -> input -> post ('place_of_joining') : Null,
					'date_termination' => ($this -> input -> post ('date_termination'))? date('Y-m-d', strtotime($this ->input -> post ('date_termination'))) : Null,
					'date_transfer' => ($this -> input -> post ('date_transfer'))? date('Y-m-d', strtotime($this ->input -> post ('date_transfer'))) : Null,
					'date_died' => ($this -> input -> post ('date_died'))? date('Y-m-d', strtotime($this ->input -> post ('date_died'))) : Null,
					'date_retired' => ($this -> input -> post ('date_retired'))? date('Y-m-d', strtotime($this ->input -> post ('date_retired'))) : Null,
					'date_resigned' => ($this -> input -> post ('date_resigned'))? date('Y-m-d', strtotime($this ->input -> post ('date_resigned'))) : Null,
					'status' => ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null,
					'marital_status' => ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null,
					'phone' => ($this -> input -> post ('phone'))? $this -> input -> post ('phone') : Null,
					'telephone' => ($this -> input -> post ('telephone'))? $this -> input -> post ('telephone') : Null,
					'bankaccountno' => ($this -> input -> post ('bankaccountno'))? $this -> input -> post ('bankaccountno') : Null,
					'bid' => ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null,
					'payscale' => ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null,
					'basicpay' => ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null,
					'branchcode' => ($this -> input -> post ('branchcode'))? $this -> input -> post ('branchcode') : Null,
					'employee_type' => ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null,
					'type' => ($this -> input -> post ('type'))? $this -> input -> post ('type') : Null,
					//'supervisor_type' => ($this -> input -> post ('supervisor_type'))? $this -> input -> post ('supervisor_type') : Null,
					'branchname' => ($this -> input -> post ('branchname'))? $this -> input -> post ('branchname') : Null,
					'basic_training_start_date' => ($this -> input -> post ('basic_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_start_date'))) : Null,
					'basic_training_end_date' => ($this -> input -> post ('basic_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('basic_training_end_date'))) : Null,
					'routine_epi_start_date' => ($this -> input -> post ('routine_epi_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_start_date'))) : Null,
					'routine_epi_end_date' => ($this -> input -> post ('routine_epi_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('routine_epi_end_date'))) : Null,
					'survilance_training_start_date' => ($this -> input -> post ('survilance_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_start_date'))) : Null,
					'survilance_training_end_date' => ($this -> input -> post ('survilance_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('survilance_training_end_date'))) : Null,
					'cold_chain_training_start_date' => ($this -> input -> post ('cold_chain_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_start_date'))) : Null,
					'cold_chain_training_end_date' => ($this -> input -> post ('cold_chain_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('cold_chain_training_end_date'))) : Null,
					'is_temp_saved' => $this -> input -> post ('is_temp_saved'),
					'vlmis_training_start_date' => ($this -> input -> post ('vlmis_training_start_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_start_date'))) : Null,
					'vlmis_training_end_date' => ($this -> input -> post ('vlmis_training_end_date'))? date('Y-m-d', strtotime($this ->input -> post ('vlmis_training_end_date'))) : Null,
					//'post_type'=>($this->input->post('post_type'))? $this->input->post('post_type'):Null,
					//'previous_code'=>$this->input->post('previous_code')?
					//$this->input->post('previous_code'):Null,
					//'newtcode' => ($this -> input -> post ('newtcode'))? $this -> input -> post ('newtcode') : Null,
					//'newfacode' => ($this -> input -> post ('newfacode'))? $this -> input -> post ('newfacode') : Null,
					//'newuncode' => ($this -> input -> post ('newuncode'))? $this -> input -> post ('newuncode') : Null
			    );
					
			
			$data = $this -> System_setup_model -> AddHR_save($hrData,$hrCode);
		}else{
			//echo $_POST; exit();
			$location = base_url(). "System_setup/AddHR_add/";
				echo '<script language="javascript" type="text/javascript"> alert("No AddHR Code Provided....");	window.location="'.$location.'"</script>';
		}
		}
	}
		//================ Function to Show Page for Editing Existing AddHR Record Starts Here ===============//
	public function AddHR_edit() {
		dataEntryValidator(1);
		$hrcode = $this -> uri -> segment(3);
		//print_r($hrcode); exit;
		$data = $this -> System_setup_model -> AddHR_edit($hrcode);
		//$data = $this -> System_setup_model -> dsodb_edit($dsocode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/AddHR_edit';
			$data['pageTitle'] = 'EPI-MIS | Update AddHR Form';
			$data['edit']='1';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Show Page for Editing Existing AddHR Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing AddHR Record Starts Here ==============//
	public function AddHR_view() {
		$hrcode = $this -> uri -> segment(3);
		$data = $this -> System_setup_model -> AddHR_view($hrcode);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'system_setup/AddHR_view';
			$data['pageTitle'] = 'EPI-MIS | AddHR Detailed View';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	
	
	
	
	
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing medical technician Record Starts Here =============//
	//================ Function to Show Page for Editing Existing medical technician Record Ends Here =============//
}
//End of System Setup Class