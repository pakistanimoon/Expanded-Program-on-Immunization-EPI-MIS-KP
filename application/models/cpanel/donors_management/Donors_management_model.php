<?php
class Donors_management_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() {
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> library('breadcrumbs');
		$this-> load-> model('Filter_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
		// $this-> load-> helper('cross_notify_functions_helper');
		error_reporting(0);
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function donors_list($per_page, $startpoint) {
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Donors', '/Donors_management/donors_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		
		if($UserLevel == 99){
			$query = "select id,name from epi_funding_source ORDER BY id DESC LIMIT {$per_page} OFFSET {$startpoint} "; 
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		// echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ User Listing Function Ends Here =============================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function donors_add() {
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
		// $district	= $this -> session -> District;
		// $District 	= $this -> session -> District;
		/////code for breadcrumsn
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Donors', '/Donors_management/donors_list');
		$this->breadcrumbs->push('Donors Form', '/Donors_management/donors_add');
		
		$query="SELECT * FROM epi_funding_source";
		$query=$this->db->query($query);
		$data['epi_funding_source']=$query->result_array();
		
		return $data;
	} 
	public function delete_by_id($pk_id)
	{
		$this-> db-> where('id', $pk_id);
		$this-> db-> delete('epi_funding_source');
	}
	public function donors_edit($pk_id)
	{
		$query = "select * from epi_funding_source where id='$pk_id'"; 
		//print_r($query); exit();
		$results = $this -> db -> query($query);
		$data['epi_funding_source'] = $results -> result_array();
		return $data;	
	}
}//End of System Setup Model Class