<?php
//class Login_model starts
class Login_model extends CI_Model {
	//================ Constructor function starts================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	//================ Constructor function ends==================//
	//================ Login function starts======================//
	function login($username, $password) {
		
		$password=md5($password);
		date_default_timezone_set("Asia/Karachi");
		$curr_date = date("Y-m-d");
		$system_info = $this -> Common_model -> browser();

		$ip = $_SERVER['REMOTE_ADDR'];
	/*	echo $username;
		echo $password;
		exit;*/
		$row = $this->db->select("*")->from("epiusers")->where(array('username' => $username, 'password' => $password))->get()->row_array();
		//echo $this->db->last_query();exit;
		if (count($row) > 0) {
			$_query1 = "insert into login_log (username, login_time, login_date, system_info, ip_address, success) values('" . $username . "', CURRENT_TIME at time zone 'PKT','$curr_date','$system_info' , '$ip','Yes')";
			$this -> db -> query($_query1);
			$this->db->set('active', 1)->where(array('username' => $username, 'password' => $password))->update('epiusers');
			$_query  = "select district from districts where distcode ='".$row['distcode']."'";
			$result = $this->db->query($_query);
			$result = $result->row_array();
			$row['loginfrom'] = $result['district'];
			$row['shortname'] = get_Province_ShortName($row['procode']);
			$row['liveURL'] = get_Region_Live_Url($row['procode']);
			$row['localURL'] = get_Region_Local_Url($row['procode']);
			//echo $row['shortname'];exit();
			return $row;
		} else {
			return 0;
		}
	}
	//================ Login function ends=======================//
		public function change_password() {
		$oldPassword = $_REQUEST['oldpassword'];
		$oldPassword = md5($oldPassword);
		$newPassword = $_REQUEST['newpassword'];
		$reNewpassword = $_REQUEST['repeatnewpassword'];
		$userName = $_REQUEST['username'];
		$query = "SELECT username,password FROM epiusers WHERE username='$userName' and password='$oldPassword'";
		$result = $this -> db -> query($query);
		$row = $result -> row_array();
		$passwordDb = $row['password'];
		//if($newPassword){}
		if ($oldPassword == $passwordDb) {
			if ($newPassword == $reNewpassword) {
				$newPassword = md5($newPassword);
				$reNewpassword = md5($reNewpassword);
				$sql = "UPDATE epiusers SET password='" . $newPassword . "' WHERE username='$userName'";
				$result = $this -> db -> query($sql);
				if ($result == true) {
					return "Password Updated!";
				} else {
					return "Error While Updating Password!";
				}
			} else {
				return "Confirm Password does not match!";
			}
		} else {
			return "You Entered Wrong Old Password";
		}
	}
}
//class Login_model ends