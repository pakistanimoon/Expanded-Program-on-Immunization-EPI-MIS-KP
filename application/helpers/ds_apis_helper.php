<?php
if( ! function_exists('app_authentication'))
{
	function app_authentication($username, $pass)
	{
		$CI = & get_instance();
		$CI -> db -> select('username, password');
		$CI -> db -> where(array('username' => $username, 'active' => '1', 'level' => '3'));
		$CI -> db -> not_like('username', '!%');
		$CI -> db -> not_like('password', '!%');
		$result = $CI -> db -> get('coronausers') -> row();
		$dbPassword = (isset($result -> password))?$result -> password:'';
		
		if(md5($pass) == $dbPassword){
			return true;
		}else{
			return false;
		}	
	}
}

if( ! function_exists('authentication'))
{
	function authentication($username, $pass)
	{
		$CI = & get_instance();
		$CI -> db -> select('fk_hr_code	, pin_no');
		$CI -> db -> where(array('fk_hr_code' => $username, 'active' => '0', 'app_type' => 'ds'));
		$CI -> db -> not_like('pin_no', '!%');
		$result = $CI -> db -> get('hr_app_users') -> row();
		$dbPassword = (isset($result -> pin_no))?$result -> pin_no:'';
		
		if(md5($pass) == $dbPassword){
			return true;
		}else{
			return false;
		}	
	}
}

if( ! function_exists('loginresponsejson'))
{
	function loginresponsejson($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('code, name, procode, provincename(procode) as province, distcode, districtname(distcode) as district, tcode, tehsilname(tcode) as tehsil, uncode, unname(uncode) as ucname, facode, facilityname(facode) as facilityname, phone as contactno');
		$CI -> db -> where(array('code' =>$username)); 
		$row = $CI -> db -> get('hr_db') -> row_array();

		$series=array("success"=>"yes", "vaccinator_code"=>$row["code"], "vaccinator_name"=>$row["name"], "uncode"=>$row["uncode"], "ucname"=>$row["ucname"], "procode"=>$row["procode"], "province"=>$row["province"], "distcode"=>$row["distcode"], "district"=>$row["district"], "tcode"=>$row["tcode"], "tehsil"=>$row["tehsil"], "facode"=>$row["facode"], "facilityname"=>$row["facilityname"], "contactno"=>$row["contactno"]);	
		return $series;
	}
}

if( ! function_exists('updateTechnicianModelNo'))
{
	function updateTechnicianModelNo($username,$model_no)
	{
		$CI = & get_instance();
		$CI -> db -> update('hr_app_users',array('model_no'=>$model_no),array('fk_hr_code'=>$username,'app_type' => 'ds'));
	}
}

if( ! function_exists('get_user_details'))
{
	function get_user_details($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('distcode, districtname(distcode) as district, procode, provincename(procode) as province, tcode, tehsilname(tcode) as tehsil, facode, facilityname(facode) as facility, utype, level');
		$CI -> db -> where(array('username' => $username, 'active' => '1', 'level' => '3'));
		$CI -> db -> not_like('username', '!%');
		$CI -> db -> not_like('password', '!%');
		$result = $CI -> db -> get('coronausers') -> row();
		return $result;
	}
}

if( ! function_exists('get_inserted_id'))
{
	function get_inserted_id($whereCondition)
	{
		$CI = & get_instance();
		$result = $CI -> db -> select('id')
					-> where($whereCondition)
					-> get('corona_case_investigation_form_db') -> row();
		return $result -> id;
	}
}

if( ! function_exists('update_model_no'))
{
	function update_model_no($username,$model_no)
	{
		$CI = & get_instance();
		$CI -> db -> update('coronausers',array('model_no'=>$model_no),array('username'=>$username));
	}
}

if( ! function_exists('loginlog'))
{
	function loginlog($username, $attemptedresult, $data, $ip, $source, $reason, $response)
	{
		$CI = & get_instance();
		$insertData['activitydatetime'] = date("Y-m-d h:i:s");
		$insertData['attemptedresult'] = $attemptedresult;
		$insertData['reason'] = $reason;
		$insertData['username'] = $username;
		$insertData['information'] = json_encode($data);
		$insertData['ip'] = $ip;
		$insertData['source'] = $source;
		$insertData['response'] = $response;
		
		$CI -> db -> insert('corona_loginlog',$insertData);
		return true;
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

if(!function_exists('get_epid_no')){
	function get_epid_no($distcode, $year){
		$CI = & get_instance();
		//$procode = substr($distcode,0,1);
		$procode = $CI -> session -> Province;
		$dCode = get_districts_dcode($distcode);
		$caseNumber = get_max_case_number($dCode, $year);
		$epidNo = "PAK/" . get_province_short_name($procode) ."/".$dCode."/".$year."/Covid/". $caseNumber;
		return $epidNo;
	}
}

if(!function_exists('get_province_short_name')){
	function get_province_short_name($procode){
		$CI = & get_instance();
		$query = "SELECT shortname from provinces where procode = '$procode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		return $result['shortname'];
	}
}

if(!function_exists('get_districts_dcode')){
	function get_districts_dcode($distcode){
		$CI = & get_instance();
		$query = "SELECT epid_code from districts where distcode='$distcode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		return $result['epid_code'];
	}
}

if(!function_exists('get_max_case_number')){
	function get_max_case_number($dCode, $year){
		$CI = & get_instance();
		$query = "SELECT max(case_number) as case_number from corona_case_investigation_form_db where year='$year' AND dcode='$dCode'";
		$result = $CI -> db -> query($query);
		$result = $result -> row_array();
		return sprintf('%06u', ($result['case_number'] + 1));
	}
}

if(!function_exists('validate_existing_record')){
	function validate_existing_record($fweek, $procode, $distcode, $dcode, $caseNumber){
		$CI = & get_instance();
		$whereCondition = array(
									'fweek' => $fweek,
									'procode' => $procode,
									'distcode' => $distcode,
									'dcode' => $dcode,
									'case_number' => $caseNumber
				);
		$result = $CI -> db -> select('count(*) as tot')
					-> from('corona_case_investigation_form_db')
					-> where($whereCondition)
					-> get() -> row();
		if($result -> tot > 0)
			return TRUE;
		return FALSE;
	}
}

if(!function_exists('get_epi_weeks_for_app')){
	function get_epi_weeks_for_app(){
		$CI = & get_instance();
		return $CI -> db -> select('*')
					-> from('epi_weeks')
					-> order_by('fweek','asc')
					-> get() -> result_array();
	}
}

if(!function_exists('get_all_corona_cases')){
	function get_all_corona_cases($distcode){
		$CI = & get_instance();
		return $CI -> db -> select('*')
					-> from('corona_case_investigation_form_db')
					-> where('distcode',$distcode)
					-> order_by('case_epi_no','asc')
					-> get() -> result_array();
	}
}
?>