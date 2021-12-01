<?php
class Inventory_types_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	public function campaign_save($type,$name,$id){

        if ($id>0)
		{
			//echo($id);exit;
		$query = "UPDATE campaign_purpose SET type='$type' where id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		
		$query = "insert into campaign_purpose (type) values ('$type')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
		}
    }
	public function campaign_edit($id){
		
        $query = "select id,type from campaign_purpose where id= '$id' ";		
        $result = $this->db->query($query)->result_array();
		return $result;
	}
	public function manufacturer_save($type,$name,$id){
		if ($id>0)
		{
			//echo($id);exit;
		$query = "UPDATE epi_manufacturer SET name='$name' where id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		$query = "insert into epi_manufacturer (name) values ('$type')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
		}
	}
	public function manufacturer_edit($id){
	
        $query = "select id,name from epi_manufacturer where id= '$id' ";		
        $result = $this->db->query($query)->result_array();
        return $result;
	}
	public function warehouse_save($type,$name,$distcode,$id){
		if ($id>0)
		{
			//echo($id);exit;
		$query = "UPDATE epi_cc_warehouse SET warehouse_name='$type' where pk_id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		$query = "insert into epi_cc_warehouse (warehouse_name,distcode) values ('$type','$distcode')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
	}
	
	}public function warehouse_edit($id){
		
        $query = "select pk_id,warehouse_name,distcode from epi_cc_warehouse where pk_id= '$id' ";		
        $result = $this->db->query($query)->result_array();
		return $result;
	}
	public function adjustment_save($type,$name,$id){
		if ($id>0)
		{
			//echo($id);exit;
		$query = "UPDATE adjustment_type SET type='$type' where id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		$query = "insert into adjustment_type (type) values ('$type')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
	}
	}
	public function adjustment_edit($id){
		
        $query = "select id,type from adjustment_type where id= '$id' ";		
        $result = $this->db->query($query)->result_array();
        return $result;
	}
	public function location_save($type,$name,$warehouse,$serial,$asset_id){
		$query = "insert into epi_cc_coldchain_main (asset_name,warehouse_id,serial_no,asset_id) values ('$type','$warehouse','$serial','$asset_id')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
	}
	public function save_cc_asset($type,$shortname ,$name,$id,$equipment_type_id,$parent_id){
        if ($id>0)
		{
		$query = "UPDATE epi_cc_asset_types SET asset_type_name='$type',parent_id=$parent_id, short_name='$shortname', ccm_equipment_type_id={$equipment_type_id} where pk_id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		$query = "insert into epi_cc_asset_types (asset_type_name,short_name,ccm_equipment_type_id,parent_id) values ('$type','$shortname',{$equipment_type_id},$parent_id)";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
		}
	}
	public function cc_asset_edit($id){
		
        $query = "select pk_id,asset_type_name,short_name,ccm_equipment_type_id,parent_id from epi_cc_asset_types where pk_id= '$id' ";		
        $result = $this->db->query($query)->row_array();
        return $result;
	}
	public function update_status_history($type,$shortname ,$name,$id){
        if ($id>0)
		{
			//echo($id);exit;
		$query = "UPDATE epi_cc_asset_types SET asset_type_name='$type', short_name='$shortname' where pk_id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
		
		$query = "insert into epi_cc_asset_types (asset_type_name,short_name) values ('$type','$shortname')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your record!');
		}
	}
	public function manage_warehouse_save($type,$name,$status,$id){
		
		if ($id>0)
		{
		$query = "UPDATE epi_cc_warehouse_types SET warehouse_type_name='$type',status='$status'  where pk_id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
			
		$query = "insert into epi_cc_warehouse_types (warehouse_type_name,status) values ('$type','$status')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your !');
	}
		}
	public function manage_warehouse_edit($id){
		
        $query = "select pk_id,warehouse_type_name,status from epi_cc_warehouse_types where pk_id= '$id' ";		
        $result = $this->db->query($query)->row_array();
		return $result;
	}
	public function stakeholder_save($stakeholder,$name,$parent_id,$id){
		
		if ($id>0)
		{
		$query = "UPDATE epi_stakeholder SET stakeholder_name='$stakeholder',parent_id='$parent_id'  where pk_id= '$id'";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		}			
		else{
			
		$query = "insert into epi_stakeholder (stakeholder_name,parent_id) values ('$stakeholder','$parent_id')";
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully saved your !');
	}
		}
	public function stakeholder_edit($id){
		
        $query = "select pk_id,stakeholder_name,parent_id from epi_stakeholder where pk_id= '$id' ";		
        $result = $this->db->query($query)->row_array();
		return $result;
	}
	
}