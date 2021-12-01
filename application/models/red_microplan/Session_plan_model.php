<?php class Session_plan_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}

	public function session_plan_list(){
		$distcode = $this -> session -> District;		
		$query = "SELECT *, tehsilname(tcode) as tehsil, facilityname(facode) as facility from session_plan_db where distcode='$distcode' order by year DESC, facode ASC";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		return $data['data'];	
	}
	
	public function session_plan_add($techniciancode,$year){		
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		//for ajk//$query = "SELECT *,(select population from villages_population where year='$year' and vcode=situation_analysis_db.area_name) pop, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}

	public function session_plan_edit($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		//for ajk//$query = "SELECT *,(select population from villages_population where year='$year' and vcode=situation_analysis_db.area_name) pop, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();		
		return $data['data'];	
	}
	
	public function session_plan_view($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] = $result->result_array();
		return $data['data'];	
	}	
}
