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
		$statement = "epiusers";
		
		$data = $this -> User_management_model -> user_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		//print_r($data['pagination']);exit();
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
	public function user_add(){
		//print_r($_POST);exit();
		$data = $this -> User_management_model -> user_add();
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
}
//End of System Setup Class