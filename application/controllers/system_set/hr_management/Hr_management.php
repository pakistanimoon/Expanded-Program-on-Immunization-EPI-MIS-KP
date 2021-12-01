<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_management extends CI_Controller {
	
	//================ Constructor Function Starts ==================//
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('lookups_helper');
		$this->load->library('form_validation');
		$this -> load -> model('system_setup/hr_management/hr_management_model','hr_model');
		$this -> load -> model('Common_model');
		authentication();
	}
	//============================ Constructor Function Ends ============================//	

	//---------------------HR Functions Starts-----------------------------	
	public function hr_list()
	{	//Code for Pagination
		$data['data'] = null;
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 5;
		//echo $per_page;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "hr_db ";
		$data['data'] 		= $this-> hr_model->hr_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		//print_r($data['pagination']);exit();		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] 	= $this -> session -> UserLevel;
		$data['fileToLoad'] = 'system_setup/hr_management/hr_list';
		$data['pageTitle']	= 'EPI-MIS | List of HR';
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function hr_add($data = NULL)
	{	
		$data['$data'] 		= null;
		$data['data'] 		= $this -> hr_model -> hr_add();
		$data['fileToLoad'] = 'system_setup/hr_management/hr_add';
		$data['pageTitle'] 	= 'EPI-MIS | Add New HR Form';
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function hr_save()
	{	
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('level', 'Level', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('sub_type', 'Subtype', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('name', 'name', 'trim|required|callback_alpha_space');
		$this->form_validation->set_rules('father_name', 'Father\'s Name', 'trim|required|callback_alpha_space');
		$this->form_validation->set_rules('guardian_name', 'Guardian\'s Name', 'trim|required|callback_alpha_space');
		//$this->form_validation->set_rules('code', 'code', 'required');
		$this->form_validation->set_rules('father_name', 'Father name', 'required');
		$this->form_validation->set_rules('nic', 'nic', 'required|is_unique[hr_db.nic]');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|is_unique[hr_db.phone]');
		$this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
		$this->form_validation->set_rules('passingyear', 'passing Year', 'required');
		$this->form_validation->set_rules('date_joining', 'Joining Date', 'required');
		$this->form_validation->set_rules('place_of_joining', 'Joining Place', 'required');
		//$this->form_validation->set_rules('area_type', 'Area Type', 'required');
		//$this->form_validation->set_rules('status_date', 'Status Date', 'required');
		//$this->form_validation->set_rules('status_reason', 'Status Reason', 'required');
		$this->form_validation->set_rules('institutename', 'Institute Name', 'required');
		$this->form_validation->set_rules('branchcode', 'Branch Code', 'required');
		$this->form_validation->set_rules('branchname', 'Branch Name', 'required');
		$this->form_validation->set_rules('bankaccountno', 'Bank Account Number', 'required|is_unique[hr_db.bankaccountno]');
		$this->form_validation->set_rules('payscale', 'Payscale', 'required');
		$this->form_validation->set_rules('basicpay', 'Basic Pay', 'required');
		$this->form_validation->set_rules('allowances', 'Allowances', 'required');
		$this->form_validation->set_rules('deductions', 'Deductions', 'required');
		
		
		if($this->form_validation->run() == false)
		{ 
			$data['selectlevel'] = ($this -> input -> post ('level'))? $this -> input -> post ('level') : Null;
			$data['selecttype'] = ($this -> input -> post ('type'))? $this -> input -> post ('type') : Null;
			$data['select_subtype'] = ($this -> input -> post ('sub_type'))? $this -> input -> post ('sub_type') : Null;
			$data['select_gendere'] = ($this -> input -> post ('gender'))? $this -> input -> post ('gender') : Null;
			$data['select_marital'] = ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null;
			$data['select_qualify'] = ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null;
			$data['select_employee'] = ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null;
			$data['select_status'] = ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null;
			$data['select_bank'] = ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null;
			$data['select_pay'] = ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null;
			$data['select_area_type'] = ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null;
			$data['tcode'] = ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null;
			$data['uncode'] = ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null;
			$data['facode'] = ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null;
			$data['training'] = ($this -> input -> post ('training'))? $this -> input -> post ('training') : Null;
			//print_r($data);exit();
			$this->hr_add($data);
		} 
		else
		{
			//print_r($_POST);exit();
			//$code = $this->input->post("code");
			//echo $hrnewcode; exit;
			$data['hr_type_id'] = $this->input->post("type");
			$data['hr_sub_type_id'] = $this->input->post("sub_type");
			$data['gender'] = $this->input->post("gender");
			$data['level'] = $this->input->post("level");
			$data['name'] = $this->input->post("name");
			$data['fathername'] = $this->input->post("father_name");
			$data['guardian_name'] = $this->input->post("guardian_name");
			$data['nic'] = $this->input->post("nic");
			$data['date_of_birth'] = date('Y-m-d', strtotime($this-> input-> post('date_of_birth')));
			$data['procode'] = $this -> session -> Province;
			$data['distcode'] = ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null;
			$data['tcode'] = ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null;
			$data['uncode'] = ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null;
			$data['facode'] = ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null;
			$data['marital_status'] = $this->input->post("marital_status");
			$data['phone'] = $this->input->post("phone");
			$data['emergency_no'] = $this->input->post("emergency_no");
			$data['permanent_address'] = $this->input->post("permanent_address");
			$data['present_address'] = $this->input->post("present_address");
			$data['lastqualification'] = $this->input->post("lastqualification");
			$data['passingyear'] = ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null;
			$data['institutename'] = $this->input->post("institutename");
			$data['date_joining'] = date('Y-m-d', strtotime($this-> input-> post('date_joining')));
			$data['place_of_joining'] = $this->input->post("place_of_joining");
			$data['areatype'] = $this->input->post("area_type");
			$data['status'] = $this->input->post("status");
			$data['status_date'] = date('Y-m-d');
			$data['status_reason'] = $this->input->post("status_reason");
			$data['bid'] = $this->input->post("bankid");
			$data['branchcode'] = $this->input->post("branchcode");
			$data['branchname'] = $this->input->post("branchname");
			$data['bankaccountno'] = $this->input->post("bankaccountno");
			$data['employee_type'] = $this->input->post("employee_type");
			$data['payscale'] = ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null;
			$data['basicpay'] = ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null;
			$data['allowances'] = ($this -> input -> post ('allowances'))? $this -> input -> post ('allowances') : Null;
			$data['deductions'] = ($this -> input -> post ('deductions'))? $this -> input -> post ('deductions') : Null;
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$data['updated_date'] = date('Y-m-d h:i:s');
			$data['updated_by'] = $_SESSION['username'];
			$data['code'] = $this -> hr_model -> hr_new_code();
			//echo $data['code']; exit;
			if(! empty(($_POST['training'])))
			{
				foreach($_POST['training'] as $trainings)
				{
					$training[] = $trainings;
				}
			}else{
				$training = "";
			}
			$code = $this-> hr_model-> hr_save($data,$training);
			redirect(base_url()."Hr_management/hr_view/".$code);
		}
	}
	public function hr_edit_get()
	{
		$id = ($this->uri->segment(3)) ?($this->uri->segment(3)):$this->input->post("code"); 
		$data['data'] = null;
		$data['total_data'] = $this->hr_model->hr_edit_get($id);
		if($_SESSION['UserLevel'] == '3' || $_SESSION['UserLevel'] == '4')
		{
			$data['districts'] = $data['total_data']['districts'];
		}
		$data['data'] = $data['total_data']['edit'];
		$data['training_types'] = $data['total_data']['training_types'];
		$data['trainings'] = array_column($data['total_data']['training'],'training_id');
		//print_r($data['trainings']); exit;
		$data['select_gender'] = ($data['data']['gender'])? $data['data']['gender'] : $this -> input -> post ('gender');
		$data['select_marital'] = ($data['data']['marital_status'])? $data['data']['marital_status'] : $this -> input -> post ('marital_status');
		$data['select_qualify'] = ($data['data']['lastqualification'])? $data['data']['lastqualification'] :$this -> input -> post ('lastqualification');
		$data['select_employee'] = ($data['data']['employee_type'])? $data['data']['employee_type'] : $this -> input -> post ('employee_type');
		$data['select_area_type'] = ($data['data']['areatype'])? $data['data']['areatype'] : $this -> input -> post ('areatype');
		//$data['select_status'] = ($data['data']['status'])? $data['data']['status'] : $this -> input -> post ('status');
		$data['select_bank'] = ($data['data']['bid'])? $data['data']['bid'] : $this -> input -> post ('bankid');
		$data['select_pay'] = ($data['data']['payscale'])? $data['data']['payscale'] : $this -> input -> post ('payscale');
		$data['fileToLoad'] = 'system_setup/hr_management/hr_edit';
		$data['pageTitle'] = 'EPI-MIS | Edit HR Form';
		$this -> load -> view('template/epi_template', $data);
	}
	public function hr_edit()
	{	
		$id = $this->input->post("id");
		$code = $this->input->post("code");
		$unique_val = $this->db->query("select nic,phone,bankaccountno from hr_db where id =". $id)->row();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'name', 'trim|required|callback_alpha_space');
		$this->form_validation->set_rules('father_name', 'Father Name', 'trim|required|callback_alpha_space');
		$this->form_validation->set_rules('guardian_name', 'Guardian\'s Name', 'trim|required|callback_alpha_space');
		if($this->input->post('nic') != $unique_val->nic)
		{
			$this->form_validation->set_rules('nic', 'CNIC', 'required|is_unique[hr_db.nic]');
		}else
		{
			$this->form_validation->set_rules('nic', 'CNIC', 'required');
		}
		if($this->input->post('phone') != $unique_val->phone)
		{
			$this->form_validation->set_rules('phone', 'Phone Number', 'required|is_unique[hr_db.phone]');
		}else
		{
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
		}
		$this->form_validation->set_rules('permanent_address', 'Permanent Address', 'required');
		$this->form_validation->set_rules('passingyear', 'passing Year', 'required');
		$this->form_validation->set_rules('date_joining', 'Joining Date', 'required');
		$this->form_validation->set_rules('place_of_joining', 'Joining Place', 'required');
		//$this->form_validation->set_rules('area_type', 'Area Type', 'required');
		//$this->form_validation->set_rules('status_date', 'Status Date', 'required');
		//$this->form_validation->set_rules('status_reason', 'Status Reason', 'required');
		$this->form_validation->set_rules('institutename', 'Institute Name', 'required');
		$this->form_validation->set_rules('branchcode', 'Branch Code', 'required');
		$this->form_validation->set_rules('branchname', 'Branch Name', 'required');
		if($this->input->post('bankaccountno') != $unique_val->bankaccountno)
		{
			$this->form_validation->set_rules('bankaccountno', 'Bank Account Number', 'required|is_unique[hr_db.bankaccountno]');
		}else
		{
			$this->form_validation->set_rules('bankaccountno', 'Bank Account Number', 'required');
		}
		$this->form_validation->set_rules('payscale', 'Payscale', 'required');
		$this->form_validation->set_rules('basicpay', 'Basic Pay', 'required');
		$this->form_validation->set_rules('allowances', 'Allowances', 'required');
		$this->form_validation->set_rules('deductions', 'Deductions', 'required');
		
		
		if($this->form_validation->run() == false)
		{
			//print_r($_POST);exit();
			$data['code'] 			= $this->input->post("code");
			$data['selectlevel']	 = ($this -> input -> post ('level'))? $this -> input -> post ('level') : Null;
			$data['selecttype'] 	 = ($this -> input -> post ('type'))? $this -> input -> post ('type') : Null;
			$data['select_subtype']  = ($this -> input -> post ('sub_type'))? $this -> input -> post ('sub_type') : Null;
			$data['select_gender']  = ($this -> input -> post ('gender'))? $this -> input -> post ('gender') : Null;
			$data['select_marital']  = ($this -> input -> post ('marital_status'))? $this -> input -> post ('marital_status') : Null;
			$data['select_qualify']  = ($this -> input -> post ('lastqualification'))? $this -> input -> post ('lastqualification') : Null;
			$data['select_employee'] = ($this -> input -> post ('employee_type'))? $this -> input -> post ('employee_type') : Null;
			//$data['select_status']	 = ($this -> input -> post ('status'))? $this -> input -> post ('status') : Null;
			$data['select_bank']	 = ($this -> input -> post ('bankid'))? $this -> input -> post ('bankid') : Null;
			$data['select_pay']		 = ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null;
			$data['select_area_type'] = ($this -> input -> post ('area_type'))? $this -> input -> post ('area_type') : Null;
			$this->hr_edit_get($data);
		}
		else
		{
			//print_r($_POST);exit();
			$id = $this->input->post("id");
			$data['name'] = $this->input->post("name");
			$data['code'] = $this->input->post("hr_code");
			$data['level'] = $this->input->post("level");
			$data['hr_type_id'] = $this->input->post("type");
			$data['hr_sub_type_id'] = $this->input->post("sub_type");
			$data['gender'] = $this->input->post("gender");
			$data['fathername'] = $this->input->post("father_name");
			$data['guardian_name'] = $this->input->post("guardian_name");
			$data['nic'] = $this->input->post("nic");
			$data['date_of_birth'] = date('Y-m-d', strtotime($this-> input-> post('date_of_birth')));
			$data['procode'] = $this -> session -> Province;
			$data['distcode'] = ($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : $this -> session -> District;
			$data['tcode'] = ($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null;
			$data['uncode'] = ($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null;
			$data['facode'] = ($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null;
			$data['marital_status'] = $this->input->post("marital_status");
			$data['phone'] = $this->input->post("phone");
			$data['emergency_no'] = $this->input->post("emergency_no");
			$data['permanent_address'] = $this->input->post("permanent_address");
			$data['present_address'] = $this->input->post("present_address");
			$data['lastqualification'] = $this->input->post("lastqualification");
			$data['passingyear'] = ($this -> input -> post ('passingyear'))? $this -> input -> post ('passingyear') : Null;
			$data['institutename'] = $this->input->post("institutename");
			$data['date_joining'] = date('Y-m-d', strtotime($this-> input-> post('date_joining')));
			$data['place_of_joining'] = $this->input->post("place_of_joining");
			$data['areatype'] = $this->input->post("area_type");
			//$data['status'] = $this->input->post("new_status");
			//$data['status_date'] = ($this-> input-> post('hidden_date')) ? date('Y-m-d', strtotime($this-> input-> post('hidden_date'))) : date('Y-m-d');
			//$data['status_date'] = ($data['status'] == 'Transferred') ? date('Y-m-d', strtotime($this-> input-> post('old_date'))) : ((! empty($data['status']) && $data['status'] != 'Transferred') ? date('Y-m-d', strtotime($this-> input-> post('hidden_date'))) : date('Y-m-d'));
			$data['status_reason'] = $this->input->post("reason");
			$data['bid'] = $this->input->post("bankid");
			$data['branchcode'] = $this->input->post("branchcode");
			$data['branchname'] = $this->input->post("branchname");
			$data['bankaccountno'] = $this->input->post("bankaccountno");
			$data['employee_type'] = $this->input->post("employee_type");
			$data['payscale'] = ($this -> input -> post ('payscale'))? $this -> input -> post ('payscale') : Null;
			$data['basicpay'] = ($this -> input -> post ('basicpay'))? $this -> input -> post ('basicpay') : Null;
			$data['allowances'] = ($this -> input -> post ('allowances'))? $this -> input -> post ('allowances') : Null;
			$data['deductions'] = ($this -> input -> post ('deductions'))? $this -> input -> post ('deductions') : Null;
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$data['updated_date'] = date('Y-m-d h:i:s');
			$data['updated_by'] = $_SESSION['username'];
			if(! empty(($_POST['training'])))
			{
				foreach($_POST['training'] as $trainings)
				{
					$training[] = $trainings;
				}
			}else{
				$training = "";
			}
			//For Transfer
			/* $data_transfer = NULL;
			if($this->input->post("new_status") == 'Transferred')
			{
				$data_transfer['level'] 	= ($this -> input -> post ('new_level')) ? $this -> input -> post ('new_level') : Null;
				$data_transfer['new_status'] = ($this -> input -> post ('new_status')) ? $this -> input -> post ('new_status') : Null;
				$data_transfer['post_dist']  = ($this -> input -> post ('new_distcode')) ? $this -> input -> post ('new_distcode') : Null;
				$data_transfer['pre_dist']	 = ($this -> input -> post ('distcode')) ? $this -> input -> post ('distcode') : Null;
				$data_transfer['pre_tcode']  = ($this -> input -> post ('tcode')) ? $this -> input -> post ('tcode') : Null;
				$data_transfer['post_tcode']  = ($this -> input -> post ('new_tehcode')) ? $this -> input -> post ('new_tehcode') : Null;
				$data_transfer['pre_uncode'] = ($this -> input -> post ('uncode')) ? $this -> input -> post ('uncode') : Null;
				$data_transfer['post_uncode']  = ($this -> input -> post ('new_uncode')) ? $this -> input -> post ('new_uncode') : Null;
				$data_transfer['pre_facode'] = ($this -> input -> post ('facode')) ? $this -> input -> post ('facode') : Null;
				$data_transfer['post_facode']  = ($this -> input -> post ('new_facode')) ? $this -> input -> post ('new_facode') : Null;
				//$data_transfer['date_transfer'] = ($this-> input-> post('date_transfer')) ? date('Y-m-d', strtotime($this-> input-> post('date_transfer'))) : date('Y-m-d');
				//print_r($data_transfer); exit;
			}
			if($this->input->post("new_status") == 'On Leave')
			{
				//echo "hi"; exit;
				$data_transfer['new_status']		= ($this -> input -> post ('new_status')) ? $this -> input -> post ('new_status') : Null;
				$data_transfer['reason']			= ($this -> input -> post ('leave_reason')) ? $this -> input -> post ('leave_reason') : Null;
				$data_transfer['leave_start_date']  = ($this -> input -> post ('date_from')) ? date('Y-m-d', strtotime($this -> input -> post ('date_from'))) : Null;
				$data_transfer['leave_end_date']	= ($this -> input -> post ('date_to')) ? date('Y-m-d', strtotime($this -> input -> post ('date_to'))) : Null;
				$data_transfer['remarks'] 			= ($this -> input -> post ('remarks')) ? $this -> input -> post ('remarks') : Null;
				$data_transfer['approved_by'] 		= ($this -> input -> post ('approved')) ? $this -> input -> post ('approved') : Null;
				//print_r($data_leave); exit;
			}
			if($this->input->post("new_status") == 'Posted')
			{
				$data_transfer['new_status']	 = ($this -> input -> post ('new_status')) ? $this -> input -> post ('new_status') : Null;
				$data_transfer['pre_type']		 = ($this -> input -> post ('type')) ? $this -> input -> post ('type') : Null;
				$data_transfer['posted_type']	 = ($this -> input -> post ('temp_post')) ? $this -> input -> post ('temp_post') : Null;
				$data_transfer['pre_subtype']	 = ($this -> input -> post ('sub_type')) ? $this -> input -> post ('sub_type') : Null;
				$data_transfer['posted_subtype'] = ($this -> input -> post ('temp_sub_post')) ? $this -> input -> post ('temp_sub_post') : Null;
				//print_r($data_transfer); exit;
			}
			if($this->input->post("new_status") == 'Post_Back')
			{
				$data_transfer['new_status']		 = ($this -> input -> post ('new_status')) ? $this -> input -> post ('new_status') : Null;
				$data_transfer['pre_type']			 = ($this -> input -> post ('type')) ? $this -> input -> post ('type') : Null;
				$data_transfer['pre_subtype']		 = ($this -> input -> post ('sub_type')) ? $this -> input -> post ('sub_type') : Null;
				$data_transfer['posted_status_date'] = date('Y-m-d');
				//print_r($data_transfer); exit;
			} */
			$this-> hr_model-> hr_edit($code ,$data, $training);
			redirect('Hr_management/hr_list');
		}
	}
	public function get_training()
	{
		$code = $this->uri->segment(3); 
		$result = $this-> hr_model-> get_training($code);
		$training = array_column($result ,'training_id');
		echo json_encode($training);
	}
	public function hr_del()
	{
		//echo $id; exit;
		$code = $this->uri->segment(3);
		$this-> hr_model-> hr_del($code);
		redirect('Hr_management/hr_list');
	}
	public function hr_view()
	{
		$id = $this->uri->segment(3); 
		//echo $id; exit;
		$data['$data'] = null;
		$data['data'] = $this->hr_model->hr_edit_get($id);
		$data['fileToLoad'] = 'system_setup/hr_management/hr_view';
		$data['pageTitle'] = 'EPI-MIS | View HR Form';
		$this -> load -> view('template/epi_template', $data);
	}
	//---------------------HR Functions Ends-----------------------------	
	//---------------------Function for Validation Name---------------------------
	public function alpha_space($title)
	{
		if (! preg_match('/^[a-zA-Z\s]+$/', $title)) 
		{
			$this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & spaces');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	public function hr_status_edit() { 
	    $hrcode = $this->uri->segment(3);
		//echo $hrcode; exit; 
		$data['data'] = $this -> hr_model -> hr_status_edit($hrcode);
		//print_r($data['data']);
		$data['fileToLoad'] = 'system_setup/hr_management/hr_status_edit'; 
		$data['pageTitle']='EPI-MIS |Update HR Status Form';
		$this -> load -> view('template/epi_template', $data);
		
	}
	public function hr_status_save(){
		$data = $this -> hr_model -> hr_status_save();
		//print_r($data); exit();
		$location = base_url(). "Hr_management/hr_list";
		echo '<script language="javascript" type="text/javascript"> alert("Record Succesfully Updated....");	window.location="'.$location.'"</script>';
	}
	public function hr_status_del() { 
		$data = $this -> hr_model -> hr_status_del();
	}
	//--------------------Name Validations ends---------------
}
