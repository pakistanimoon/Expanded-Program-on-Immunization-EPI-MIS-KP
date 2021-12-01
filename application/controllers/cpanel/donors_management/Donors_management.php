<?php
class Donors_management extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('cpanel/donors_management/Donors_management_model','donors_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ Item Listing Function Starts ================//
	public function donors_list(){
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
		
		$data = $this -> donors_model -> donors_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/donors_management/donors_list';
			$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Donors';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ item Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New item Starts Here =======//	
	public function donors_add(){
		$data = $this -> donors_model ->donors_add();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/donors_management/donors_add';
			$data['pageTitle'] = 'EPI-MIS| Add New Donors Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Save Donors Starts Here =======//	
	public function donors_save(){
		//print_r($_POST); exit;
		$epi_funding_source = array(
			'name' => ($this ->input -> post ('name')) ? $this ->input -> post ('name') : Null 
		);
		$item_id =$this -> Common_model -> insert_record('epi_funding_source',$epi_funding_source);
		$this -> session -> set_flashdata('message','You have successfully saved your record!'); 
		$location = base_url()."Donors_management/donors_list";
		redirect($location);
	}
	//================ Function to Save Product Ends Here =========================//
	public function donors_del($pk_id){
		$this-> donors_model-> delete_by_id($pk_id);
		redirect('Donors_management/donors_list');
	}
	public function donors_edit(){
		$pk_id = $this -> uri -> segment(3);
		$data['data'] =$this->donors_model ->donors_edit($pk_id);
		$data['fileToLoad'] = 'cpanel/donors_management/donors_edit';
		$data['pageTitle'] = 'EPI-MIS| Edit Donors Form';
		$this->load->view('template/epi_template',$data);
	}
	//================ Function to Update Product Starts Here =======//	
	public function donors_update(){
		//print_r($_POST); exit;
		$id=$this->input->post('id');
		$epi_funding_source = array(
			'name' => ($this ->input -> post ('name')) ? $this ->input -> post ('name') : Null 
		);
		$this-> Common_model-> update_record('epi_funding_source',$epi_funding_source,array('id'=>$id));
		$this -> session -> set_flashdata('message','You have successfully Update your record!'); 
		$location = base_url()."Donors_management/donors_list";
		redirect($location);
	}
}
//End of Class