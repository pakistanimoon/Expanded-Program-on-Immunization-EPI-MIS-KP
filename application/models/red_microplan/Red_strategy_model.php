<?php class Red_strategy_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}

	public function red_strategy_list(){
		$distcode = $this -> session -> District;		
		$query = "SELECT *, tehsilname(tcode) as tehsil, facilityname(facode) as facility,unname(uncode) as uc_name from red_strategy_db where distcode='$distcode' order by year DESC, facode ASC";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		return $data['data'];	
	}
	
	 public function red_strategy_add($techniciancode,$year){		
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	} 

	public function red_strategy_edit($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();		
		return $data['data'];	
	}
	
	public function red_strategy_view($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] = $result->result_array();
		return $data['data'];	
	}	
}
