<?php class Facility_quarterplan_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	public function hf_quarterplan_list(){
		$distcode = $this -> session -> District;	
		//$data['distcode'] = $_SESSION['District'];
		$data['ulevel'] = $_SESSION['UserLevel'];
		$data['utype'] = $_SESSION['utype'];		
		$wc = "";
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (isset($_SESSION['Province'])) {
					$wc .= "  procode = '" . $_SESSION['Province'] . "' ";
				}
				break;
			case '3' :
				$UserLevel = 3;
				if (isset($_SESSION['Province']) && isset($_SESSION['District'])) {
					$wc .= "  procode = '" . $_SESSION['Province'] . "' AND distcode = '" . $_SESSION['District'] . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				if (isset($_SESSION['Province']) && isset($_SESSION['District']) && isset($_SESSION['facode'])) {
					$wc .= "distcode = '" . $_SESSION['District'] . "'AND facode = '" . $_SESSION['facode'] . "'  ";
				}
				break;
		}
		//print($wc);exit;
		$data['UserLevel'] = $UserLevel;	
		$query = "SELECT facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by facode";
		$Fac_result = $this-> db-> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "SELECT tcode, tehsil from tehsil where $wc order by tcode";
		$Teh_result = $this-> db-> query($query);
		$data['resultTeh'] = $Teh_result-> result_array();
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode)as facility , techniciancode  from hf_quarterplan_db where distcode='$distcode'  order by year DESC, quarter, facode ASC";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		return $data['data'];	
	}
	 public function hf_quarterplan_add($techniciancode,$year){		
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}
	public function hf_quarterplan_edit($facode,$year,$quarter,$techniciancode){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from hf_quarterplan_db where facode='$facode' and year='$year' and quarter='$quarter' and techniciancode='$techniciancode'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		$id=$data['data'][0]['pk_id'];
		foreach($data as $key => $val){
			
			$query = "SELECT * from hf_quarterplan_nm_db where ms_id='$id' ";
		    $result = $this-> db-> query($query);	
		    $data[$key]['datat2'] = $result-> result_array();
			$query = "SELECT * from hf_quarterplan_dates_db where ms_id='$id' ";
		    $result = $this-> db-> query($query);	
		    $data[$key]['datat3'] = $result-> result_array(); 
			
		}
		return $data;	
	}
	
	public function hf_quarterplan_view($facode,$year,$quarter,$techniciancode){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from hf_quarterplan_db where facode='$facode' and year='$year' and quarter='$quarter' and techniciancode='$techniciancode'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		$id=$data['data'][0]['pk_id'];
		foreach($data as $key => $val){
			$query = "SELECT * from hf_quarterplan_nm_db where ms_id='$id' ";
		    $result = $this-> db-> query($query);	
		    $data[$key]['datat2'] = $result-> result_array();
			$query = "SELECT * from hf_quarterplan_dates_db where ms_id='$id' ";
		    $result = $this-> db-> query($query);	
		    $data[$key]['datat3'] = $result-> result_array(); 
		 
		}
		//print_r($data);exit;
		
		return $data;	
	}	
}
