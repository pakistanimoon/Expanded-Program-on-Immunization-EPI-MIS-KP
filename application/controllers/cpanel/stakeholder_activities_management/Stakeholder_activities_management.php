<?php
class Stakeholder_activities_management extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('cpanel/stakeholder_activities_management/Stakeholder_activities_management_model','stakeholder_activities_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ Activities Listing Function Starts ================//
	public function stakeholder_activities_list(){
		//print_r($_REQUEST); exit();
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epiusers";
		
		$data = $this -> stakeholder_activities_model -> stakeholder_activities_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/stakeholder_activities_management/stakeholder_activities_list';
			$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Activities';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Activities Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Activities Starts Here =======//	
	public function stakeholder_activities_add(){
		$data = $this -> stakeholder_activities_model ->stakeholder_activities_add();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/stakeholder_activities_management/stakeholder_activities_add';
			$data['pageTitle'] = 'EPI-MIS| Add New Activities Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Save Activities Starts Here =======//	
	public function stakeholder_activities_save(){
		//print_r($_POST); exit;
		$epi_stakeholder_activities = array(
			'activity' => ($this ->input -> post ('activity')) ? $this ->input -> post ('activity') : Null, 
			'status' => ($this ->input -> post ('status')) ? $this ->input -> post ('status') : 0,
			'created_by' => 'admin',
			'created_date' => date("Y-m-d H:i:s")
		);
		$item_id =$this -> Common_model -> insert_record('epi_stakeholder_activities',$epi_stakeholder_activities);
		$this -> session -> set_flashdata('message','You have successfully saved your record!'); 
		$location = base_url()."Stakeholder_activities_management/stakeholder_activities_list";
		redirect($location);
	}
	//================ Function to Save Activities Ends Here =========================//
	public function stakeholder_activities_del($pk_id){
		$this-> stakeholder_activities_model-> delete_by_id($pk_id);
		redirect('Stakeholder_activities_management/stakeholder_activities_list');
	}
	public function stakeholder_activities_edit(){
		$pk_id = $this -> uri -> segment(3);
		$data['data'] =$this->stakeholder_activities_model ->stakeholder_activities_edit($pk_id);
		$data['fileToLoad'] = 'cpanel/stakeholder_activities_management/stakeholder_activities_edit';
		$data['pageTitle'] = 'EPI-MIS| Edit Activities Form';
		$this->load->view('template/epi_template',$data);
	}
	//================ Function to Update Activities Starts Here =======//	
	public function stakeholder_activities_update(){
		//print_r($_POST); exit;
		$pk_id=$this->input->post('pk_id');
		$epi_stakeholder_activities = array(
			'activity' => ($this ->input -> post ('activity')) ? $this ->input -> post ('activity') : Null,
			'status' => ($this ->input -> post ('status')) ? $this ->input -> post ('status') : 0,
			'modified_date' => date("Y-m-d H:i:s")			
		);
		$this-> Common_model-> update_record('epi_stakeholder_activities',$epi_stakeholder_activities,array('pk_id'=>$pk_id));
		$this -> session -> set_flashdata('message','You have successfully Update your record!'); 
		$location = base_url()."Stakeholder_activities_management/stakeholder_activities_list";
		redirect($location);
	}
}
//End of Class