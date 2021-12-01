<?php
class Item_management_model extends CI_Model {
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
	public function item_list($per_page, $startpoint) {
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Product', '/Item_management/item_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		
		if($UserLevel == 99){
			$query = "select item.pk_id,item.description,get_item_categories(item.item_category_id) as item_category_id,array_to_string(array_agg(size.number_of_doses order by size.number_of_doses),',') as number_of_doses  from epi_items item join epi_item_pack_sizes size on item.pk_id=size.item_id group by item.pk_id ORDER BY item.pk_id DESC LIMIT {$per_page} OFFSET {$startpoint} "; 
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		// echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ User Listing Function Ends Here =============================//
	//--------------------------------------------------------------------//
	//================ User Listing Function Starts ================//
	public function item_add() {
		$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';
		// $district	= $this -> session -> District;
		// $District 	= $this -> session -> District;
		/////code for breadcrumsn
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Item', '/Item_management/item_list');
		$this->breadcrumbs->push('Item Form', '/Item_management/item_add');
		
		$query="SELECT * FROM epi_item_categories where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_item_categories']=$query->result_array();
		
		$query="SELECT * FROM epi_item_units where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_item_units']=$query->result_array();
		
		$query="SELECT * FROM epi_stakeholder_activities where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_activities']=$query->result_array();
		
		$query="SELECT * FROM epi_item_pack_sizes ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_item_pack_sizes']=$query->result_array();
		
		return $data;
	} 
	public function get_listorder_items() {
		$query = "select max(list_order) from epi_items"; 
		$results = $this -> db -> query($query);
		$data['get_listorder_items'] = $results -> result_array();
		return $data;
	}
	public function delete_by_id($pk_id)
	{
		$this-> db-> where('item_id', $pk_id);
		$this-> db-> delete('epi_item_pack_sizes');	
		$this-> db-> where('pk_id', $pk_id);
		$this-> db-> delete('epi_items');	
	}
	public function item_edit($pk_id)
	{
		$query="SELECT * FROM epi_item_categories where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_item_categories']=$query->result_array();
		
		$query="SELECT * FROM epi_item_units where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_item_units']=$query->result_array();
		
		$query="SELECT * FROM epi_stakeholder_activities where status='1' ORDER BY pk_id";
		$query=$this->db->query($query);
		$data['epi_stakeholder_activities']=$query->result_array();
		
		$query = "select item.pk_id,item.description,item.item_category_id,item.is_active from epi_items item  where item.pk_id='$pk_id'"; 
		//print_r($query); exit();
		$results = $this -> db -> query($query);
		$data['epi_items_results'] = $results -> result_array();
		
		$query = "select size.pk_id,size.item_id,size.item_name,size.number_of_doses,size.item_unit_id,activity_type_id, 	size.vvm_stage_type,size.cr_table_row_numb from epi_item_pack_sizes size  where size.item_id='$pk_id'"; 
		//print_r($query); //exit();
		$results = $this -> db -> query($query);
		$data['pack_size_results'] = $results -> result_array();
		
		return $data;	
	}
	/* public function add_edit($id)
	{
		$query = "SELECT pk_id,cr_table_row_numb from epi_item_pack_sizes where item_id = '$id'";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	} */
}//End of System Setup Model Class