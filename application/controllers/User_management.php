<?php
class User_management extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('User_management_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function user_list(){
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epiusers ";
		
		$data = $this -> User_management_model -> user_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'user_management/user_list';
			$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Users';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ User Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New User Starts Here =======//	
	public function user_add($data=NULL){
		$data = $this -> User_management_model -> user_add($data);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'user_management/user_add';
			$data['pageTitle'] = 'EPI-MIS | Add New Users Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function user_save()
	{
		if(isset($_REQUEST['AddUser']))
		{
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			$this->form_validation->set_rules('procode', 'procode', 'required');
			$this->form_validation->set_rules('utype', 'utype', 'required');
			$this->form_validation->set_rules('level', 'Level', 'required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_alphanumeric_space|is_unique[epiusers.username]');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|callback_alpha_space');
			$this->form_validation->set_rules('active', 'Active', 'required');
			if($this->form_validation->run() == false)
			{
				$this->user_add();
			}
			else
			{
				$data['procode']	= $_REQUEST['procode'];
				$data['distcode'] 	= (isset($_REQUEST['distcode']) && $_REQUEST['distcode']> 0)?$_REQUEST['distcode']:'';
				$data['tcode'] 		= (isset($_REQUEST['tcode']) && $_REQUEST['tcode']> 0)?$_REQUEST['tcode']:'';
				$data['uncode']	= (isset($_REQUEST['uncode']) && $_REQUEST['uncode']> 0)?$_REQUEST['uncode']:'';
				$data['facode'] 	= (isset($_REQUEST['facode']) && $_REQUEST['facode']> 0)?$_REQUEST['facode']:'';
				$data['utype'] 		= $_REQUEST['utype'];
				$data['level'] 		= $_REQUEST['level'];
				$data['username'] 	= $_REQUEST['username'];
				$data['password']	= md5($_REQUEST['password']);
				$data['fullname'] 	= $_REQUEST['fullname'];
				$data['active'] 	= $_REQUEST['active'];
				$data['addeddate'] 	= date('Y-m-d');			
				if($level == 1)
				{
					$procode = '';
				}
				else
				{
					$procode = $_SESSION['Province'];
				}
				$location = base_url(). "User_management/user_list";
				$this-> User_management_model-> user_save($data);
				redirect($location);
			}
		}
		if(isset($_REQUEST['UpdateUser'])){
			//echo "xyz"; exit();
			$old = $_REQUEST['oldusername'];
			$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
			$this->form_validation->set_rules('procode', 'procode', 'required');
			$this->form_validation->set_rules('utype', 'utype', 'required');
			$this->form_validation->set_rules('level', 'Level', 'required');
			$original_value = $this->db->query("select username from epiusers where username =". "'$old'")->row()->username;
			if($this->input->post('username') != $original_value) {
				$this->form_validation->set_rules('username', 'Username', 'trim|required|callback_alphanumeric_space|is_unique[epiusers.username');
			}
			else 
			{
				 $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_alphanumeric_space');
			}
			$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|callback_alpha_space');
			$this->form_validation->set_rules('active', 'Active', 'required');
			if($this->form_validation->run() == false)
			{
				$query = "SELECT * FROM epiusers WHERE username = '$old' ";
				$resource = $this->db->query($query);
				$data['userInfo'] = $resource->result_array();
				$this->user_add($data);
			}
			else
			{
				$procode = $_REQUEST['procode'];
				$distcode = (isset($_REQUEST['distcode']) && $_REQUEST['distcode']> 0)?$_REQUEST['distcode']:'';
				$tcode = (isset($_REQUEST['tcode']) && $_REQUEST['tcode']> 0)?$_REQUEST['tcode']:'';
				$uncode = (isset($_REQUEST['uncode']) && $_REQUEST['uncode']> 0)?$_REQUEST['uncode']:'';
				$facode = (isset($_REQUEST['facode']) && $_REQUEST['facode']> 0)?$_REQUEST['facode']:'';
				$data['utype'] = $_REQUEST['utype'];
				$data['level'] = $_REQUEST['level'];
				$data['username'] = $_REQUEST['username'];
				$oldusername = $_REQUEST['oldusername'];
				$data['password'] = md5($_REQUEST['password']);
				$data['fullname'] = $_REQUEST['fullname'];
				$data['active'] = $_REQUEST['active'];
				$username = $_REQUEST['username'];
				if($level == 1){
					$procode = '';
				}
				else{
					$procode = $_SESSION['Province'];
				}
				$error = 0;
				if(($utype == 'Admin' && $distcode > 0) || ($utype == 'Manager' && $distcode > 0) ){				
					$error = 1;
					$location = base_url(). "User_management/user_add?user=".$oldusername;
					$message="District user cannot be Admin OR Manager";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit;

				}
				if($error == 0){				
					$this-> User_management_model-> user_update($data,$oldusername);
					createTransactionLog("Users-DB", "User Updated ".$username);
					$location = base_url(). "User_management/user_list";
					$message="User Record Updated";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit;					
				}
				else{				
					$location = base_url(). "User_management/user_list";
					$message="Problem With Updating Record";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit;
				}
			}
		}
	}
	//================ Function to Show Page for Adding New User Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function to Delete User Starts Here =======//	
	public function delete_by_id($username){
		$this-> User_management_model-> delete_by_id($username);
		echo "Done"; exit;
	}
	//================ Function to Delete User Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function to View User Starts Here =======//	
	public function user_log(){
		$data['data'] = $this-> User_management_model-> user_log();
		if($data != 0){
			$data['fileToLoad'] = 'user_management/user_log';
			$data['pageTitle']='EPI-MIS | User Login History';
			$this->load->view('template/reports_template',$data);
		}
		else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//================ Function to Delete User Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function to User Activities Starts Here =======//	
	public function user_activities(){
		$username=$this->uri->segment(3);
		$data = $this -> User_management_model -> user_activities($username);
		//echo $username; exit;
		if($data != 0){
			$data['fileToLoad'] = 'user_management/user_activities';
			$data['pageTitle']='EPI-MIS | User Activities History';
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//================ Function to Show Page for Activities Ends Here =========================//
	public function usersContact(){
		if(isset($_REQUEST['edit'])){
			$name = $this -> input -> post('name');
			$designation = $this -> input -> post('designation');
			$department = $this -> input -> post('department');
			$cell = $this -> input -> post('cell_no');
			$email = $this -> input -> post('email');
			$this->db->set('name', $name);
			$this->db->set('designation', $designation);
			$this->db->set('department', $department);
			$this->db->set('cell_no', $cell);
			$this->db->set('email', $email);
			$this->db->where('username', $this -> session -> username);
			$this->db->update('epiusers');
			$this -> session -> set_flashdata('message', 'User Contact Information Updated!');
			$data = $this -> User_management_model -> usersinfo();
			$data['data'] = $data;
			$data['fileToLoad'] = 'user_management/contactForm';
			$this -> load -> view('template/epi_template', $data);
		}
		else{
			$data = $this -> User_management_model -> usersinfo();
			if($data != 0) {
				$data['data'] = $data;
				$data['fileToLoad'] = 'user_management/contactForm';
				$data['pageTitle'] = 'EPI-MIS | User Contact Information';
				$this -> load -> view('template/epi_template', $data);
			}
			else{
				$data['message'] = "You must have rights to access this page.";
				$this -> load -> view("message", $data);
			}
		}
	}
	//---------------------Function for Validation Name---------------------------
	public function alpha_space($title)
	{
		if (! preg_match('/^[a-zA-Z\s]+$/', $title)) 
		{
			$this->form_validation->set_message('alpha_space', 'The %s field may only contain alpha characters & spaces');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	public function alphanumeric_space($title)
	{
		if (! preg_match('/^[a-zA-Z0-9_]+$/', $title)) 
		{
			$this->form_validation->set_message('alphanumeric_space', 'The %s field may only contain alphanumeric characters & underscore');
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
	//--------------------Name Validations ends---------------
}
//End of System Setup Class