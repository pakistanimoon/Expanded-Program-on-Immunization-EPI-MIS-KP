<?php
class User_management_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() {
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> library('breadcrumbs');
		$this-> load-> model('Filter_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
		error_reporting(0);
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function user_list($per_page, $startpoint) {
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage EPI-MIS Users', '/User_management/user_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		$query="SELECT distcode, district from districts where procode = '$procode' order by district";
		$resultFac=$this -> db -> query($query);
		$data['resultDist'] = $resultFac -> result_array();

		$query="SELECT usertype, usertype_description FROM user_types_db ORDER BY id";
		$query=$this->db->query($query);
		$data['resultTypes']=$query->result_array();
		//print_r($data['resultTypes']);exit();
		$query="SELECT userlevel, userlevel_description FROM user_level_db ORDER BY userlevel";
		$query=$this->db->query($query);
		$data['resultLevel']=$query->result_array();
		//print_r($data['resultLevel']);exit();
		if($UserLevel == 99){
			$query = "SELECT username, utype, districtname(distcode) AS District, fullname, level, addeddate FROM epiusers ORDER BY addeddate DESC LIMIT {$per_page} OFFSET {$startpoint} ";
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ User Listing Function Ends Here =============================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function user_add($data=null) {
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
		// $district	= $this -> session -> District;
		// $District 	= $this -> session -> District;
		/////code for breadcrumsn
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Users', '/User_management/User_list');
		$this->breadcrumbs->push('User Form', '/User_management/User_add');
		///// code for getting districts
		$query="SELECT distcode, district FROM districts ORDER BY distcode";
		$query=$this->db->query($query);
		$data['resultDist']=$query->result_array();
		//print_r($data['resultDist']);exit();
		$query="SELECT usertype, usertype_description FROM user_types_db ORDER BY id";
		$query=$this->db->query($query);
		$data['resultTypes']=$query->result_array();
		//print_r($data['resultTypes']);exit();
		$query="SELECT userlevel, userlevel_description FROM user_level_db WHERE flag = 1 ORDER BY userlevel";
		$query=$this->db->query($query);
		$data['resultLevel']=$query->result_array();
		//print_r($data['resultLevel']);exit();		

		$query="SELECT tcode, tehsil from tehsil ORDER BY tcode";
		$query=$this->db->query($query);
		$data['resultTeh']=$query->result_array();
		if(isset($_REQUEST['user'])){			
			$username = $_REQUEST['user'];
			$query = "SELECT * FROM epiusers WHERE username = '$username' ";
			$resource = $this->db->query($query);
			$data['userInfo'] = $resource->result_array();
		}
		return $data;
	} 
	public function user_save($data){
		$this->db->insert('epiusers', $data);
	}
	public function user_update($data,$oldusername)
	{
		$this->db->where('username', $oldusername);
		$this->db->update('epiusers',$data);
	}
	//================ User Add Function End ================//
	//--------------------------------------------------------------------//
	//================ User Delete Function Starts ================//
	public function delete_by_id($username)
	{
		$this-> db-> where('username', $username);
		$this-> db-> delete('epiusers');	
	}
	//================ User Delete Function End ================//
	//--------------------------------------------------------------------//
	//================ User Log Function Starts ================//
	
	public function user_log(){
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$this -> session -> District;
		$UserLevel = $_SESSION['UserLevel'];

		//Excel file code is here*******************
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=User_Login_History.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//echo 
		$query = 'SELECT DISTINCT ON (username) login_log.username as "Username",
						 login_date as "Login Date",
						 login_log.login_time as "Login Time",
						 login_log.system_info as "Browser"
						 FROM "login_log" group by login_log.username, login_log.login_time, login_log.system_info, login_log.login_date Order By username, MAX(login_date) DESC'; 
		//exit();
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		$innerrowName = "EPI USERS";
		$subTitle =" User Login History <br /><small>(Click on Username to see the details)</small>";
		$data['report_table']=getListingReportTable($data['allData'],$innerrowName,'NO');
		$data['TopInfo']=tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("User Log", "Login log Viewed");
		return $data;
	}
	//================ User Delete Function End ================//
	//----------------------------------------------------------//
	//=============== User Detail Function Starts ==============//
	
	public function user_activities($username){
		$data = posted_Values();//posted values from last page
		$wc	  = getWC_Array($data['procode'],$this -> session -> District); // function to get wc array
		
		//Excel file code is here*******************
		if(isset($_REQUEST['export_excel']))
		{	
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=User_activities_log.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$UserLevel=$this->session->UserLevel;
		//main query to view report
		if($UserLevel == 99){			
			//echo 
			$query = 'SELECT 
				tlog.username as "User Name", 
				tlog.usertype as "User Type", 
				CASE WHEN tlog.userlevel=\'2\' THEN \'Province\' WHEN tlog.userlevel=\'3\' THEN \'District\' WHEN tlog.userlevel=\'4\' THEN \'Facility\' ELSE tlog.userlevel END as level,
				districtname(usr.distcode) as District,
				tlog.module,
				tlog.action,
				tlog.datetime as "Date and Time",
				tlog.ip_address as "IP Address",
				tlog.browser from user_transaction_log tlog,epiusers usr where tlog.username=usr.username AND tlog.username = \''.$username.'\' group by tlog.username,tlog.usertype,tlog.userlevel,usr.distcode,tlog.module ,tlog.action, tlog.datetime, tlog.ip_address, tlog.browser order by MAX(datetime) DESC ';
			//exit();
				
			$subTitle ="Activities Log of user: ".$username;
			$result=$this->db->query($query);
			$data['allData']=$result->result_array();
			$data['report_table']=getListingReportTable($data['allData'],'','NO');
			$data['TopInfo']=tableTopInfo($subTitle);
			$data['exportIcons']=exportIcons($_REQUEST);
			//create activity log
			createTransactionLog("User Log", "Activity log Viewed");
			return $data;
		}
	}
	//================ User Delete Function End ================//
	public function usersinfo(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Contact info', '/user_management/usersContact');
		$user =$this -> session -> username;
		$query="select * from epiusers where username='{$user}'";
		$result=$this->db->query($query);
		$data=$result->row_array();
		return $data;
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
}//End of System Setup Model Class