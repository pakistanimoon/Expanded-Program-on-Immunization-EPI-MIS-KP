<?php
class Lookups_management_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() 
	{
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	
	//--------------Level Models Starts--------------------
	
	public function lookup_list()
	{
		$this->db->select('*');
		$this->db->from('lookup_master');
		$this->db->order_by("created_date", "desc");
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	public function lookup_add($data)
	{
		$this->db->insert('lookup_master',$data);
		$insert_id = $this->db->insert_id();
		$this->db->select('id');
		$this->db->from('lookup_master');
		$this->db->where('pk_id',$insert_id);
		$result = $this->db-> get()-> result_array();
		return  $result;
	}
	
	public function lookup_detail_add($data1)
	{
		$this->db->insert('lookup_detail',$data1);
	}
	
	public function lookup_edit_get($id)
	{
		$query = "SELECT m.id as id, m.name as name, m.label as label, d.value as value, d.caption as caption, d.is_active as active
				  FROM lookup_master as m 
				  left join lookup_detail as d on m.id = d.master_id where m.id = ".$id."";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	}
	
	public function lookup_edit($id, $data1)
	{
		$this->db->where('id', $id);
		$this->db->update('lookup_master',$data1);		
	}
	
	public function lookup_edit_detail($data2)
	{
		$this->db->insert('lookup_detail',$data2);		
	}
	
	public function lookup_detail_del($id){
		$this->db->where('master_id', $id);
		$this->db->delete('lookup_detail');		
	}
	
	public function lookup_del($id)
	{
		$this->db->where('master_id', $id);
		$this->db->delete('lookup_detail');
		
		$this->db->where('id', $id);
		$this->db->delete('lookup_master');
	}
	
	//--------------Level Models End--------------------
	
	//--------------Type Models Starts--------------------
	public function type_list()
	{
		$this->db->select('*');
		$this->db->from('hr_types');
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
