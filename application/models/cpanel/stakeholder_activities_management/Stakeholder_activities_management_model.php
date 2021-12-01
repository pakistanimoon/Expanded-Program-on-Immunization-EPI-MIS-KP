<?php
class Stakeholder_activities_management_model extends CI_Model {
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
	public function stakeholder_activities_list($per_page, $startpoint) {
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Activities', '/Stakeholder_activities_management/stakeholder_activities_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		
		if($UserLevel == 99){
			$query = "select * from epi_stakeholder_activities ORDER BY pk_id DESC LIMIT {$per_page} OFFSET {$startpoint} "; 
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		// echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ User Listing Function Ends Here =============================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function stakeholder_activities_add() {
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
		// $district	= $this -> session -> District;
		// $District 	= $this -> session -> District;
		/////code for breadcrumsn
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Activities', '/Stakeholder_activities_management/stakeholder_activities_list');
		$this->breadcrumbs->push('Activities Form', '/Stakeholder_activities_management/stakeholder_activities_add');
		
		$query="SELECT * FROM epi_stakeholder_activities";
		$query=$this->db->query($query);
		$data['epi_stakeholder_activities']=$query->result_array();
		
		return $data;
	} 
	public function delete_by_id($pk_id)
	{
		$this-> db-> where('pk_id', $pk_id);
		$this-> db-> delete('epi_stakeholder_activities');
	}
	public function stakeholder_activities_edit($pk_id)
	{
		$query = "select * from epi_stakeholder_activities where pk_id='$pk_id'"; 
		//print_r($query); exit();
		$results = $this -> db -> query($query);
		$data['epi_stakeholder_activities'] = $results -> result_array();
		return $data;	
	}
}//End of System Setup Model Class