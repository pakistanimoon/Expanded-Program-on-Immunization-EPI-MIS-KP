<?php
class Outbreak_response_list_report_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');

	}
	public function outbreak_response_list_report($distcode)
	{
		$query = "select tcode from tehsil where distcode = '$distcode' order by tehsil asc ";
			////echo $query;exit();
			$result = $this -> db -> query($query);
			$data = $result -> result_array();
			//print_r($result);exit();
			
			return $data;
	}
	public function outbreak_report($distcode,$tcode,$uncode,$vcode,$date_of_activity_from,$date_of_activity_to,$age_group_from,$age_group_to)
	{
		$this-> db-> select('vaccines');
		$this->db->select_sum('0_11_m_m');
		$this->db->select_sum('0_11_m_f');
		$this->db->select_sum('12_23_m_m');
		$this->db->select_sum('12_23_m_f');
		$this->db->select_sum('years_m');
		$this->db->select_sum('years_f');
		$this->db->select_sum('total_m');
		$this->db->select_sum('total_f');
		$this->db->select_sum('total_m_f');		
		$this-> db-> from('case_response_tbl');		
		if($distcode > 0 ){
			$this-> db-> where('distcode',$distcode);
			if($tcode > 0)
			$this-> db-> where('tcode',$tcode);
			if($uncode> 0 )
			$this-> db-> where('uncode',$uncode);
			if($vcode > 0)
			$this-> db-> where('vcode',$vcode);
		}
	   	if($date_of_activity_from >0)
	   	$this-> db-> where("date_of_activity>=",$date_of_activity_from);
		if($date_of_activity_to >0)
		$this->db->where("date_of_activity<=",$date_of_activity_to);
		if($age_group_from > 0)
		$this-> db-> where('age_group_from>=',$age_group_from);
		if($age_group_to > 0)
		$this-> db-> where('age_group_to<=',$age_group_to);
		$this->db->group_by('vaccines');		
		$data['outbreak_report'] = $this-> db-> get()-> result_array();
		//print_r($this->db->last_query()); exit;
		//print_r($data['outbreak_report']); exit;
		return $data;
	}
}