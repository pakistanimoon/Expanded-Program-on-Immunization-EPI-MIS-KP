<?php
class Disease_surveillance_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() 
	{
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> model('Filter_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	
	//--------------Disease Models Starts--------------------
	
	public function diseases_list()
	{
		$this->db->select('*');
		$this->db->from('surveillance_cases_types');
		$this->db->order_by('id','DESC');
		$result = $this->db-> get()-> result_array();
		return $result;
	}
	
	// public function level_add($data)
	// {
	// 	$this->db->insert('hr_levels',$data);
	// }
	
	public function disease_add($data)
	{
		$this->db->insert('surveillance_cases_types',$data);
	}
	
	public function disease_edit_get($id)
	{
		$query = "SELECT * from surveillance_cases_types where id = '$id'";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	}
	
	public function disease_edit($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('surveillance_cases_types',$data);		
	}
	
	public function disease_del($id)
	{  

		$this->db->where('id', $id);
		$this->db->delete('surveillance_cases_types');
	}
}			
	