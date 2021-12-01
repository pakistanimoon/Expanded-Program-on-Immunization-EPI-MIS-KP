<?php class Special_activities_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	public function special_activities_list(){
		$distcode = $this -> session -> District;	
		$query = "SELECT *, tehsilname(tcode) as tehsil, facilityname(facode) as facility from special_activities_db where distcode='$distcode' order by year DESC, facode ASC";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}
	public function special_activities_add($techniciancode,$year){
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year' order by priority asc";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}
	
	public function special_activities_edit($techniciancode,$year){
			////////////////for abc //////
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		////////////////for defg //////
		/* $query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from special_activities_db where facode='$facode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data2'] =	$result-> result_array(); */
		
		return $data['data'];	
	}
	
	public function special_activities_view($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
		return $data['data'];	
	}
	
}
