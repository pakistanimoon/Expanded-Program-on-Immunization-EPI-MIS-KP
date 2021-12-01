<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr_management extends CI_Controller {
	
	//================ Constructor Function Starts ==================//
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this->load->helper(array('form', 'url'));
		$this -> load -> model('cpanel/hr_management/hr_management_model','hr_model');
		authentication();
	}
	//============================ Constructor Function Ends ============================//	

	//---------------------Level Functions Starts-----------------------------	
	public function level_list($id=null)
	{	
		$data['data'] = null;
		$data['data'] = $this-> hr_model-> level_list();
		if(!empty($data['data'])){
			foreach($data['data'] as $value) 
			$array[] = $value["code"];
			$data['selected'] = $array;
		}
		else
		{
			$data['selected'] = array("");
		}
		$data['fileToLoad'] = 'cpanel/hr_management/level_list';
		$data['pageTitle'] = 'EPI-MIS | List of Level of Users';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function level_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'name', 'trim|required|callback_alpha_space|is_unique[hr_levels.name]');
		$this->form_validation->set_rules('code', 'code', 'required');
		$this->form_validation->set_rules('active', 'active', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->level_list();
		}
		else
		{
			$data['name'] = $this->input->post("name");
			$data['code'] = $this->input->post("code");
			$data['is_active'] = $this->input->post("active");
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$this-> hr_model-> level_add($data);
			redirect('Hr_management/level_list');
		}
	}

	public function level_edit_get()
	{
		$id = $this -> input -> post('id');
		$data['levelEditData'] = $this -> hr_model -> level_edit_get($id);
		echo json_encode($data['levelEditData']);
	}

	public function level_edit()
	{
		$id = $this->input->post("hidden");
		
		$original_value = $this->db->query("select name from hr_levels where id =". $id)->row()->name;
		if($this->input->post('name1') != $original_value) {
			$this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space|is_unique[hr_levels.name]');
		} else {
			 $this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space');
		}		
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('code1', 'Code', 'required');
		$this->form_validation->set_rules('active1', 'Active', 'required');
		if($this->form_validation->run() == false)
		{
			$this->level_list($id);
		}
		else
		{
			$data['name'] = $this->input->post("name1");
			$data['code'] = $this->input->post("code1");
			$data['is_active'] = $this->input->post("active1");
			$this-> hr_model-> level_edit($id, $data);
			redirect('Hr_management/level_list');
		}
	}
	
	public function level_del($id)
	{
		$this-> hr_model-> level_del($id);
		redirect('Hr_management/level_list');
	}
	//---------------------Level Functions End-----------------------------
	//---------------------Type Functions Start----------------------------
	public function type_list($id=null)
	{
		$data['data'] = null;
		$data['data'] = $this-> hr_model-> type_list();
		$data['fileToLoad'] = 'cpanel/hr_management/type_list';
		$data['pageTitle'] = 'EPI-MIS | List of Types of Users';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function type_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'name', 'trim|required|callback_alpha_space|is_unique[hr_types.name]');
		$this->form_validation->set_rules('active', 'active', 'required');
		if($this->form_validation->run() == false)
		{
			$this->type_list();
		}
		else
		{
			$data['name'] = $this->input->post("name");
			$data['is_active'] = $this->input->post("active");
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$this-> hr_model-> type_add($data);
			redirect('Hr_management/type_list');
		}
	}
	
	public function type_edit_get()
	{
		$id = $this -> input -> post('id');
		$data['type_edit_data'] = $this -> hr_model -> type_edit_get($id);
		echo json_encode($data['type_edit_data']);
	}
	
	public function type_edit()
	{
		$id = $this->input->post("hidden");
		$original_value = $this->db->query("select name from hr_types where id =". $id)->row()->name;
        if($this->input->post('name1') != $original_value) {
            $this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space|is_unique[hr_types.name]');
        }
		else 
		{
             $this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space');
        }		
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('active1', 'Active', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->type_list($id);
		}
		else
		{
			$data['name'] = $this->input->post("name1");
			$data['is_active'] = $this->input->post("active1");
			$this-> hr_model-> type_edit($id, $data);
			redirect('Hr_management/type_list');
		}
	}
	
	public function type_del($id)
	{
		$this-> hr_model-> type_del($id);
		redirect('Hr_management/type_list');
	}
	//---------------------Type Functions End-----------------------------
	
	//---------------------Subtype Functions Starts-----------------------------
	public function subtype_list($id=null)
	{
		$data['data'] = null;
		$data['data'] = $this-> hr_model-> subtype_list();
		$data['type'] = $this-> hr_model-> get_type();
		if(!empty($data['data'])){
			foreach($data['data'] as $value) 
			$array[] = $value["type_id"];
			$data['selected'] = $array;
		}
		else
		{
			$data['selected'] = array("");
		}
		$data['fileToLoad'] = 'cpanel/hr_management/subtype_list';
		$data['pageTitle'] = 'EPI-MIS | List of Subtype of Users';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function subtype_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('title', 'Title', 'required|callback_alpha_space|is_unique[hr_sub_types.title]');
		$this->form_validation->set_rules('active', 'active', 'required');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('sup', 'Supportive Supervision', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->subtype_list();
		}
		else
		{
			$data['title'] = $this->input->post("title");
			$data['type_id'] = $this->input->post("code");
			$data['description'] = $this->input->post("desc");
			$data['hr_type_id'] = $this->input->post("type");
			$data['supportive_supervision'] = $this->input->post("sup");
			$data['is_active'] = $this->input->post("active");
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$this-> hr_model-> subtype_add($data);
			redirect('Hr_management/subtype_list');
		}
	
	}
	
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
	
	public function subtype_edit_get()
	{
		$id = $this -> input -> post('id');
		$data['subtype_edit_data'] = $this -> hr_model -> subtype_edit_get($id);
		echo json_encode($data['subtype_edit_data']);
	}
	
	public function subtype_edit()
	{
		$id = $this->input->post("hidden");
		$original_value = $this->db->query("select title from hr_sub_types where id =". $id)->row()->title;
        if($this->input->post('title1') != $original_value) {
            $this->form_validation->set_rules('title1', 'name', 'required|callback_alpha_space|is_unique[hr_sub_types.title]');
        }
		else 
		{
             $this->form_validation->set_rules('title1', 'name', 'required|callback_alpha_space');
        }	
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('active1', 'active', 'required');
		$this->form_validation->set_rules('code1', 'Code', 'required');
		$this->form_validation->set_rules('desc1', 'Description', 'required');
		$this->form_validation->set_rules('type1', 'Type', 'required');
		$this->form_validation->set_rules('sup1', 'Supportive Supervision', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->subtype_list($id);
		}
		else
		{
			$data['type_id'] = $this->input->post("code1");
			$data['title'] = $this->input->post("title1");
			$data['description'] = $this->input->post("desc1");
			$data['hr_type_id'] = $this->input->post("type1");
			$data['supportive_supervision'] = $this->input->post("sup1");
			$data['is_active'] = $this->input->post("active1");
			$this-> hr_model-> subtype_edit($id, $data);
			redirect('Hr_management/subtype_list');
		}
	}
	
	public function subtype_del($id)
	{
		$this-> hr_model-> subtype_del($id);
		redirect('Hr_management/subtype_list');
	}
	//---------------------Subtype Functions End-----------------------------
	
	//---------------------Training Functions starts-----------------------------
	public function training_list($id=null)
	{
		$data['data'] = null;
		$data['data'] = $this-> hr_model-> training_list();
		$data['fileToLoad'] = 'cpanel/hr_management/training_list';
		$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Users';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function training_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'required|callback_alpha_space|is_unique[training_types.name]');
		$this->form_validation->set_rules('active', 'active', 'required');
		$this->form_validation->set_rules('start_date', 'active', 'required');
		$this->form_validation->set_rules('end_date', 'active', 'required');
		$this->form_validation->set_rules('desc', 'Description', 'required');
		$this->form_validation->set_rules('venue', 'Venue', 'required|alpha|alpha_numeric_spaces');
		
		if($this->form_validation->run() == false)
		{
			$this->training_list();
		}
		else
		{
			$data['name'] = $this->input->post("name");
			$data['description'] = $this->input->post("desc");
			$data['start_date'] = $this->input->post("start_date");
			$data['end_date'] = $this->input->post("end_date");
			$data['venue'] = $this->input->post("venue");
			$data['is_active'] = $this->input->post("active");
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$this-> hr_model-> training_add($data);
			redirect('Hr_management/training_list');
		}
	}
	
	public function training_edit_get()
	{
		$id = $this -> input -> post('id');
		$data['training_edit_data'] = $this -> hr_model -> training_edit_get($id);
		echo json_encode($data['training_edit_data']);
	}
	
	public function training_edit()
	{
		$id = $this->input->post("hidden");
		$original_value = $this->db->query("select name from training_types where id =". $id)->row()->name;
        if($this->input->post('name1') != $original_value) {
            $this->form_validation->set_rules('name1', 'Name', 'required|callback_alpha_space|is_unique[training_types.name]');
        }
		else 
		{
            $this->form_validation->set_rules('name1', 'Name', 'required|callback_alpha_space');
        }	
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('active1', 'active', 'required');
		$this->form_validation->set_rules('start_date1', 'active', 'required');
		$this->form_validation->set_rules('end_date1', 'active', 'required');
		$this->form_validation->set_rules('desc1', 'Description', 'required');
		$this->form_validation->set_rules('venue1', 'Venue', 'required|alpha|alpha_numeric_spaces');
		
		if($this->form_validation->run() == false)
		{
			$this->training_list($id);
		}
		else
		{
			$data['name'] = $this->input->post("name1");
			$data['description'] = $this->input->post("desc1");
			$data['start_date'] = $this->input->post("start_date1");
			$data['end_date'] = $this->input->post("end_date1");
			$data['venue'] = $this->input->post("venue1");
			$data['is_active'] = $this->input->post("active1");
			$data['created_date'] = date('Y-m-d h:i:s');
			$data['created_by'] = $_SESSION['username'];
			$this-> hr_model-> training_edit($id, $data);
			redirect('Hr_management/training_list');
		}
	}
	
	public function training_del($id)
	{
		$this-> hr_model-> training_del($id);
		redirect('Hr_management/training_list');
	}
	//---------------------Training Functions End-----------------------------
}
