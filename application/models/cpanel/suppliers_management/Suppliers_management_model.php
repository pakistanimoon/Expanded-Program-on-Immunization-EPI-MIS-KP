<?php
class Suppliers_management_model extends CI_Model {
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
	public function suppliers_list($per_page, $startpoint) {
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Suppliers', '/Suppliers_management/suppliers_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		
		if($UserLevel == 99){
			$query = "SELECT pk_id,stakeholder_name,get_stakeholder_type(stakeholder_type_id),get_stakeholder_sectors(stakeholder_sector_id),get_activity_name(stakeholder_activity_id)  FROM epi_stakeholders ORDER BY pk_id DESC LIMIT {$per_page} OFFSET {$startpoint} "; 
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		// echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ User Listing Function Ends Here =============================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function suppliers_add() {
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
		// $district	= $this -> session -> District;
		// $District 	= $this -> session -> District;
		/////code for breadcrumsn
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Suppliers', '/Suppliers_management/suppliers_list');
		$this->breadcrumbs->push('Suppliers Form', '/Suppliers_management/suppliers_add');
		
		$query="SELECT * FROM epi_stakeholder_types where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_types']=$query->result_array();
		
		$query="SELECT * FROM epi_stakeholder_sectors where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_sectors']=$query->result_array();
		
		$query="SELECT * FROM epi_geo_levels where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_geo_levels']=$query->result_array();
		
		$query="SELECT pk_id,item_name || ' | ' || get_stackholder_activity_name(activity_type_id) as item_name  FROM epi_item_pack_sizes where status='1' ORDER BY item_name";
		$query=$this->db->query($query);
		$data['epi_item_pack_sizes']=$query->result_array();
		
		return $data;
	} 
	public function get_listrank_suppliers() {
		$query = "select max(list_rank) from epi_stakeholders"; 
		//print_r($query); //exit();
		$results = $this -> db -> query($query);
		$data['get_listrank_suppliers'] = $results -> result_array();
		return $data;
	}
	public function delete_by_id($pk_id)
	{
		$this-> db-> where('pk_id', $pk_id);
		$this-> db-> delete('epi_stakeholders');
		$this-> db-> where('stakeholder_id', $pk_id);
		$this-> db-> delete('epi_stakeholder_item_pack_sizes');
	}
	public function suppliers_edit($pk_id)
	{
		$query="SELECT * FROM epi_stakeholder_types where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_types']=$query->result_array();
		
		$query="SELECT * FROM epi_stakeholder_sectors where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_sectors']=$query->result_array();
		
		$query="SELECT * FROM epi_geo_levels where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_geo_levels']=$query->result_array();
		
		$query = "select * from epi_stakeholders  where pk_id='$pk_id'"; 
		//print_r($query); exit();
		$results = $this -> db -> query($query);
		$data['epi_stakeholders'] = $results -> result_array();
		
		$query="SELECT pk_id,item_name || ' | ' || get_stackholder_activity_name(activity_type_id) as item_name FROM epi_item_pack_sizes where status='1' ORDER BY item_name";
		$query=$this->db->query($query);
		$data['epi_item_pack_sizes']=$query->result_array();
		
		$query = "select * from epi_stakeholder_item_pack_sizes  where stakeholder_id='$pk_id'"; 
		//print_r($query); exit();
		$results = $this -> db -> query($query);
		$data['epi_stakeholder_item_pack_sizes'] = $results -> result_array();
		
		return $data;	
	}
}//End of System Setup Model Class