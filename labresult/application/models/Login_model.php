<?php 
class Login_model extends CI_Model {	
	public function authenticate($username)
	{
		$this -> db -> select('*');
		$this -> db -> where('username',$username);
		return $result = $this -> db -> get('epiusers') -> row_array();
	}

}
?>