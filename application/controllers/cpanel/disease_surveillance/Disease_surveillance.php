	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Disease_surveillance extends CI_Controller {

	//================ Constructor Function Starts ==================//
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this -> load -> model('cpanel/disease_surveillance/Disease_surveillance_model','ds_model');
	}
	//============================ Constructor Function Ends ============================//	

	//---------------------Diseases Functions Starts-----------------------------	
	public function diseases_list($id=null)
	{	//print_r("Good To GO"); exit;
		$data['data'] = "";
		$data['data'] = $this-> ds_model-> diseases_list();
		$data['fileToLoad'] = 'cpanel/disease_surveillance/diseases_list';
		$data['pageTitle'] = 'EPI-MIS | List of Diseases Case Types';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function disease_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[surveillance_cases_types.type_case_name]');
		$this->form_validation->set_rules('case_code', 'Case Code', 'required');
		$this->form_validation->set_rules('active', 'Active', 'required');
		$this->form_validation->set_rules('short_name', 'Short Name', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->diseases_list();
		}
		else
		{
			$data['type_case_name'] = $this->input->post("name");
			$data['type_short_code'] = $this->input->post("case_code");
			$data['pro'] = $this->input->post("active");
			$data['short_name'] = $this->input->post("short_name");
			$this-> ds_model-> disease_add($data);
			redirect('Disease_Surveillance/Diseases_List');
		}
	}
	
	public function disease_del($id)
	 {

	 	$this-> ds_model-> disease_del($id);
	 	redirect('Disease_Surveillance/Diseases_List');
	 	//echo "Done"; exit;
	 }

	public function disease_edit_get()
	{
	 	$id = $this -> input -> post('id');
	 	$data['DiseaseEditData'] = $this -> ds_model -> disease_edit_get($id);
	 	echo json_encode($data['DiseaseEditData']);
	}

	public function disease_edit()
	{
	 	$id = $this->input->post("hidden");
		$original_value = $this->db->query("select type_case_name from surveillance_cases_types where id =". $id)->row()->type_case_name;

		if($this->input->post('name1') != $original_value) {
			$this->form_validation->set_rules('name1', 'Type Case Name', 'trim|required|is_unique[surveillance_cases_types.type_case_name]');
			} 
		else 
		{
		  $this->form_validation->set_rules('name1', 'Type Case Name', 'trim|required');
			}		
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			$this->form_validation->set_rules('case_code1', 'Case Code', 'required');
			$this->form_validation->set_rules('active1', 'Pro Status', 'required');
			$this->form_validation->set_rules('short_name1', 'Short Name', 'required');
			
			
			if($this->form_validation->run() == false)
			{
				$this->diseases_list($id);
			}
			else
			{

				$data['type_case_name'] = $this->input->post("name1");
				$data['type_short_code'] = $this->input->post("case_code1");
				$data['pro'] = $this->input->post("active1");
				$data['short_name'] = $this->input->post("short_name1");
				$this-> ds_model-> disease_edit($id, $data);

				redirect('Disease_Surveillance/Diseases_List');

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
	 
}