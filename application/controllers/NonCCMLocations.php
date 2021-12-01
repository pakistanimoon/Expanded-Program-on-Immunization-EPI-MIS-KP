<?php
class NonCCMLocations extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('Nonccmlocations_model','locations');
	}
	
	function manage_location(){
		$distcode = ($this -> session -> District)?$this -> session -> District:NULL;
		$warehouseTypeId = ($this -> session -> District)?4:2;
		$data['allLocations'] = $this -> locations -> getAllLocations($distcode,$warehouseTypeId);
		$data['data'] = $data;
		$data['fileToLoad'] = 'non_ccm/manage_location';
		$data['pageTitle']='EPI-MIS | Manage Dry Locations';
		$this->load->view('template/epi_template',$data);
	}
	
	function save_location(){
		$store = $this -> input -> post('nonccm_stores');
		$row = $this -> input -> post('nonccm_rows');
		$rack = $this -> input -> post('nonccm_racks');
		$shelf = $this -> input -> post('nonccm_shelfs');
		$bin = $this -> input -> post('nonccm_bins');
		$nonCcmLocationArray = array(
			'location_name' => $store.$row.$rack.$shelf.$bin,
			'warehouse_type_id' => $this -> input -> post('warehouse_type'),
			'procode' => $_SESSION["Province"],
			'distcode' => ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):NULL,
			'rack_information_id' => $rack,
			'store' => $store,
			'row' => $row,
			'rack' => $rack,
			'shelf' => $shelf,
			'bin' => $bin
		);
		$this -> db -> insert('epi_non_ccm_locations',$nonCcmLocationArray);
		$this -> session -> set_flashdata('message','Location Added Successfully!');
		redirect(base_url().'NonCCMLocations/manage_location');
	}
	
	function delete_location(){
		$locationId = $this -> uri -> segment(3);
		$this -> db -> delete('epi_non_ccm_locations',array('pk_id'=>$locationId));
		$this -> session -> set_flashdata('message','Location Deleted Successfully!');
		redirect(base_url().'NonCCMLocations/manage_location');
	}
}
?>