<?php
//class Login_model starts
class Login_model extends CI_Model {
	//================ Constructor function starts================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> model('API/app_api/Common_model');
	}
	//================ Constructor function ends==================//
	//================ Login function starts======================//
	function login($username, $password) 
	{
		$this -> db -> select('*');
		$this -> db -> where(array('username' => $username));
		$result = $this->db-> get('epiusers')-> row_array();
		//print_r($result); exit;
		$dbPassword = (isset($result['password']))?$result['password']:'';
		//print_r($dbPassword); exit;
		if(md5($password) == $dbPassword){
			return $result;
		}else{
			return 0;
		}	
	}
}
//class Login_model ends
