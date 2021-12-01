<?php
class Hr_management_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() 
	{
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	
	//--------------Level Models Starts--------------------
	
	public function level_list()
	{
		$this->db->select('*');
		$this->db->from('hr_levels');
		$this->db->order_by("created_date", "desc");
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function level_add($data)
	{
		$this->db->insert('hr_levels',$data);
	}
	
	public function level_edit_get($id)
	{
		$query = "SELECT * from hr_levels where id = '$id'";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	}
	
	public function level_edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('hr_levels',$data);		
	}
	
	public function level_del($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('hr_levels');
	}
	
	//--------------Level Models End--------------------
	
	//--------------Type Models Starts--------------------
	public function type_list()
	{
		$this->db->select('*');
		$this->db->from('hr_types');
		$this->db->order_by("created_date", "desc");
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function type_add($data)
	{
		$this-> db-> insert('hr_types',$data);
	}
	
	public function type_edit_get($id)
	{
		$query = "SELECT * from hr_types where id = '$id'";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	}
	
	public function type_edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('hr_types',$data);		
	}
	
	public function type_del($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('hr_types');
	}
	//--------------Type Models End--------------------
	
	//--------------Subtype Models Starts--------------------
	public function subtype_list()
	{
		$this->db->select('*');
		$this->db->from('hr_sub_types');
		$this->db->order_by("created_date", "desc");
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function get_type()
	{
		$this->db->select('id, name');
		$this->db->from('hr_types');
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function subtype_add($data)
	{
		$this-> db-> insert('hr_sub_types',$data);
	}
	
	public function subtype_edit_get($id)
	{
		$query = "SELECT * from hr_sub_types where id = '$id'";
		$result = $this-> db-> query($query);
		$data = $result-> result_array();
		return $data;		
	}
	
	public function subtype_edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('hr_sub_types',$data);		
	}
	
	public function subtype_del($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('hr_sub_types');
	}
	//--------------Subtype Models End--------------------
	
	//--------------Training Models Starts--------------------
	
	public function training_list()
	{
		$this->db->select('*');
		$this->db->from('training_types');
		$this->db->order_by("created_date", "desc");
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function training_add($data)
	{
		$this-> db-> insert('training_types',$data);
	}
	
	public function training_edit_get($id)
	{
		$query = "SELECT * from training_types where id = '$id'";
		$result = $this-> db-> query($query);
		$data = $result-> result_array();
		return $data;		
	}
	
	public function training_edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('training_types',$data);		
	}
	
	public function training_del($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('training_types');
	}
	//--------------Training Models End--------------------
}//End of level list model
