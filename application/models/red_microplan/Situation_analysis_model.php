<?php class Situation_analysis_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	public function  situation_analysis_add($techniciancode,$year){
   
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where year='$year' and techniciancode='$techniciancode' order by priority asc";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}
	public function situation_analysis_list(){
		$distcode = $this -> session -> District;
		$procode = $this -> session -> Province;
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
				if (isset($_SESSION['Province']) && isset($_SESSION['District']) && isset($_SESSION['tcode'])) {
					$wc .= "distcode = '" . $_SESSION['District'] . "'AND tcode = '" . $_SESSION['tcode'] . "'  ";
				}
				break;
		
		}
		//print_r($wc);exit;
		$data['UserLevel'] = $UserLevel;	
		$query = "SELECT facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by facode";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();

		$query = "SELECT tcode, tehsil from tehsil where $wc order by tcode";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$this->db->select('situation_analysis_db.techniciancode,tehsilname(situation_analysis_db.tcode) as tehsil,facilityname(situation_analysis_db.facode) as facility, hr_name(situation_analysis_db.techniciancode) as technician, unname(situation_analysis_db.uncode) as uc_name, situation_analysis_db.year');
		/* if(isset($_SESSION['District'])){
			$this->db->where('distcode',$distcode);
		}
		else{
			$this->db->where('procode',$procode);
		} */
		//$status='Active';
		$this->db->from('hr_db');
		$this->db->join('situation_analysis_db ', 'hr_db.code = situation_analysis_db.techniciancode', 'right');
		$this->db->where('situation_analysis_db.distcode',$distcode);
		$this->db->where('hr_db.uncode =situation_analysis_db.uncode');
		$this->db->group_by('situation_analysis_db.techniciancode,situation_analysis_db.tcode,situation_analysis_db.uncode,situation_analysis_db.facode,situation_analysis_db.year');
		$this->db->order_by('situation_analysis_db.facode', 'ASC');		
		$hr_data = $this-> db-> get()-> result_array();
		//echo $this->db->last_query(); 	 exit;
		$this->db->select('situation_analysis_db.techniciancode,tehsilname(situation_analysis_db.tcode) as tehsil,facilityname(situation_analysis_db.facode) as facility, technicianname (situation_analysis_db.techniciancode) as technician, unname(situation_analysis_db.uncode) as uc_name, situation_analysis_db.year');
		$status='Active';
		$this->db->from('techniciandb');
		$this->db->join('situation_analysis_db ', 'techniciandb.techniciancode = situation_analysis_db.techniciancode', 'right');
		$this->db->where('situation_analysis_db.distcode',$distcode);
		$this->db->where('techniciandb.uncode =situation_analysis_db.uncode');
		//$this->db->where('techniciandb.status=', $status  );
		$this->db->group_by('situation_analysis_db.techniciancode,situation_analysis_db.tcode,situation_analysis_db.uncode,situation_analysis_db.facode,situation_analysis_db.year');
		$this->db->order_by('situation_analysis_db.facode', 'ASC');		
		$technician_data = $this-> db-> get()-> result_array();
		$data['data'] = array_merge($hr_data,$technician_data);
		
		//echo $this->db->last_query(); 	 exit;
		//print_r($data); exit;
		//////////////
	/* 	$this->db->select('techniciancode,tehsilname(tcode) as tehsil,facilityname(facode) as facility, technicianname (techniciancode) as technician, unname(uncode) as uc_name, year');
		
		
		$this->db->where('distcode',$distcode);
		$this->db->from('situation_analysis_db');
		$this->db->group_by('techniciancode,tcode,uncode,facode,year');
		$this->db->order_by('facode', 'ASC');		
		$data['data'] = $this-> db-> get()-> result_array();
		//echo $this->db->last_query(); 	 exit;
		print_r($data); exit; */
		////////////////
	/*	$query = "SELECT techniciancode, tehsilname(tcode) as tehsil, facilityname(facode) as facility, technicianname (techniciancode) as technician, unname(uncode) as uc_name, year from situation_analysis_db where distcode='$distcode'  DESC, facode, priority ASC";			
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();*/
		/*$this->db->select('techniciancode, tehsilname(tcode) as tehsil, facilityname(facode) as facility, technicianname (techniciancode) as technician, unname(uncode) as uc_name, year');R
		$this->db->where('distcode', $distcode);
			//$this->db->group_by('facode'); 
			//$this->db->order_by('total', 'desc'); 
			$this->db->get('situation_analysis_db');
			$data['data'] = $this-> db-> get()-> result_array();*/
		return $data['data'];	
	}
	public function situation_analysis_edit($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data['data'];	
	}
	
	public function situation_analysis_view($techniciancode,$year){	
	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
	
		return $data['data'];	
	}
	public function situation_analysis_save($addDataArray)
	{
		$data = $this->db-> insert('situation_analysis_db',$addDataArray);
		return $data;
	}
    public function  red_map_add($techniciancode,$year){
		
		
		
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where year='$year' and techniciancode='$techniciancode' order by priority asc";
		$result = $this-> db-> query($query);	
		$data['data'] =	$result-> result_array();
		return $data; 
	}
	public function red_map_upload($red_map,$techniciancode,$year)
	{
		
		//$this->db-> insert('situation_analysis_db',$red_map);
		$this-> Common_model-> update_record('situation_analysis_db',$red_map,array('techniciancode'=>$techniciancode,'year'=>$year));
		return TRUE;
	}
	public function red_map_view($techniciancode,$year)
	{	
		$query = "SELECT red_map, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
		return $data['data'];	
	}
	public function red_map_edit($techniciancode,$year)
	{	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
		return $data['data'];	
	}	
}
