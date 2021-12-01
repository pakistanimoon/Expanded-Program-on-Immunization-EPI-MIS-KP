<?php
if( ! function_exists('authentication'))
{
	function authentication($username, $pass)
	{
		$CI = & get_instance();
		$CI -> db -> select('username , password');
		$CI -> db -> where(array('username' => $username));
		$result = $CI->db-> get('epiusers')-> row();
		
		$dbPassword = (isset($result -> password))?$result -> password:'';
		if(md5($pass) == $dbPassword){
			return true;
		}else{
			return false;
		}	
	}
}
if(!function_exists('createTransactionLog_api')){
	function createTransactionLog_api($module, $action, $username, $userlevel, $usertype) {
		//echo "moon";exit;
		$CI=& get_instance();
		$CI->load->library('user_agent');
		//transaction log
		date_default_timezone_set("Asia/Karachi");
		$dateTime = date("Y-m-d H:i:s");
		$system_info=$_SERVER['HTTP_USER_AGENT'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$_query1 = "insert into user_transaction_log (username, datetime,  ip_address, browser, module, action, userlevel, usertype) 
		values('$username', '$dateTime','$ip','$system_info' , '$module', '$action', '$userlevel', '$usertype')";
		$result = $CI->db->query($_query1);
		return $result;
	}
}
if( ! function_exists('validateToken'))
{
	function validateToken($username,$token, $appType='cerv')
	{
		$CI = & get_instance();
		$result = $CI -> db -> select('login_token') -> from('hr_app_users') -> where(array('fk_hr_code'=>$username,'app_type'=>$appType)) -> get() -> row_array();
		if($result['login_token'] == $token)
			return true;
		return false;
	}
}
?>