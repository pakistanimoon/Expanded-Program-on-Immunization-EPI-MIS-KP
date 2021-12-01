<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lookups_management extends CI_Controller {
	
	//================ Constructor Function Starts ==================//
	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('cpanel/lookups_management/lookups_management_model','lookups_model');
	}
	//============================ Constructor Function Ends ============================//	

	//---------------------lookups Functions Starts-----------------------------	
	 public function lookups_list($id=null)
	{	
		$data['data'] = null;
		$data['data'] = $this-> lookups_model-> lookup_list();
		if(!empty($data['data'])){
			foreach($data['data'] as $value) 
			$array[] = $value["id"];
			$data['selected'] = $array;
		}
		else
		{
			$data['selected'] = array("");
		}
		$data['fileToLoad'] = 'cpanel/lookups_management/lookup_list';
		$data['pageTitle'] = 'EPI-MIS | List of General Lookups';
		$data['editid']=$id;
		$this -> load -> view('template/epi_template', $data);
	}
	
	public function lookups_add()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|callback_alpha_space|is_unique[lookup_master.name]');
		$this->form_validation->set_rules('code', 'Code', 'required');
		$this->form_validation->set_rules('label', 'Label', 'required');
		
		if($this->form_validation->run() == false)
		{
			$this->lookups_list();
		}
		else
		{
			$data['name'] = $this->input->post("name");
			$data['id'] = $this->input->post("code");
			$data['label'] = $this->input->post("label");
			$data['created_date'] = date('Y-m-d');
			$data['created_by'] = $_SESSION['username'];
			$id = $this-> lookups_model-> lookup_add($data);
			
			$num = $this->input->post("hidden1");
			for($i=1; $i<=$num; $i++)
			{
				if(!empty($this->input->post("value".$i."")) || !empty($this->input->post("caption".$i."")))
				{
					$data1['value'] = $this->input->post("value".$i."");
					$data1['caption'] = $this->input->post("caption".$i."");
					$data1['master_id'] = $id[0]['id'];
					$data1['created_date'] = date('Y-m-d');
					$data1['created_by'] = $_SESSION['username'];
					if(!empty($this->input->post("is_active".$i.""))){
						$data1['is_active'] = ($this->input->post("is_active".$i.""));
					}else{
						$data1['is_active'] = 0;
					};
					$this-> lookups_model-> lookup_detail_add($data1);
				}
			}
			redirect('Lookups_management/lookups_list');
		}
	}
 
	public function lookups_edit_get()
	{
		$id = $this -> input -> post('id');
		$data['lookupEditData'] = $this-> lookups_model-> lookup_edit_get($id);
		echo json_encode($data['lookupEditData']);
	}

	public function lookups_edit()
	{
		$id = $this->input->post("hidden");
		
		$original_value = $this->db->query("select name from lookup_master where id =". $id)->row()->name;
		if($this->input->post('name1') != $original_value) {
			$this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space|is_unique[lookup_master.name]');
		} else {
			 $this->form_validation->set_rules('name1', 'name', 'trim|required|callback_alpha_space');
		}		
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('label1', 'Label', 'required');
		if($this->form_validation->run() == false)
		{
			$this->lookups_list($id);
		}
		else
		{
			$data1['name'] = $this->input->post("name1");
			$data1['label'] = $this->input->post("label1");
			$this-> lookups_model-> lookup_edit($id, $data1);
			$this-> lookups_model-> lookup_detail_del($id);
			
			$num = $this->input->post("hidden2") + 1;
			for($i=1; $i<$num; $i++)
			{
				if(!empty($this->input->post("value1".$i."")) || !empty($this->input->post("caption".$i."")))
				{
					$data2['value'] = $this->input->post("value".$i."");
					$data2['caption'] = $this->input->post("caption".$i."");
					$data2['master_id'] = $id;
					$data2['created_date'] = date('Y-m-d');
					$data2['created_by'] = $_SESSION['username'];
					if(!empty($this->input->post("is_active".$i.""))){
						$data2['is_active'] = ($this->input->post("is_active".$i.""));
					}else{
						$data2['is_active'] = 0;
					};
					//print_r($data); exit;
					$this-> lookups_model-> lookup_edit_detail($data2);
				}
			}
			redirect('Lookups_management/lookups_list');
		}
	}
	
	public function lookups_del($id)
	{
		$this-> lookups_model-> lookup_del($id);
		redirect('Lookups_management/lookups_list');
	}
	
	public function alpha_space($title)
	{
		if (! preg_match('/^[a-zA-Z\s_]+$/', $title)) 
		{
			$this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & spaces');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	//---------------------lookup Functions End-----------------------------
}
