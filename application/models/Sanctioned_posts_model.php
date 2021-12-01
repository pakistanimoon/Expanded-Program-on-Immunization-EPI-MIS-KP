<?php
//class Sanctioned_posts_model starts
class Sanctioned_posts_model extends CI_Model {
	//================ Constructor function starts================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	//================ Constructor function ends==================//
	//================ Login function starts======================//
	public function sanctioned_Posts(){
		$District = $this -> session -> District;
		$query="SELECT district, distcode from districts order by distcode";
		$result=$this->db->query($query);
		$data['districtsdata']=$result->result_array();		
		return $data;
	}	
}
//class Login_model ends