<?php 
class Villages_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this->load->helper('my_functions_helper');
	}
	
	public function village_list(){
		$wc = getWC();
		//$distcode = $this -> session -> District;
		$query = "SELECT  tcode,tehsilname(tcode) as tehsil from villages where $wc group by tcode";
		$Tehsil_result = $this -> db -> query($query);
		$data['resultTehsil'] = $Tehsil_result -> result_array();
		$query = "SELECT  uncode,unname(uncode) as un_name from villages where $wc group by uncode";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();
		return $data;
	}
	public function village_edit($uncode){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode)as unioncouncil,facilityname(facode) as facility from villages where uncode='$uncode'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		//print_r($data);exit;
		return $data['data'];	
	}
	public function village_view($uncode){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode)as unioncouncil,facilityname(facode) as facility from villages where uncode='$uncode'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		//$checkresult= $this -> VillageExistinMicroplan($vcode);
		/* if($checkresult !='' AND $checkresult > 0){
			//echo'yes';exit;
		$data['checkresult'] = $result-> result_array();
		} */
		//print_r($data);exit;
		return $data['data'];	
	}
	public function deleted_villages($vcode){	
		$checkresult= $this -> VillageExistinMicroplan($vcode);
		if($checkresult !='' AND $checkresult > 0){
			//echo'yes';exit;
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Micro plan of this Village submited \n\t So this village is not delete!");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}else{
			$mergercode= $this -> checkVillageMergeExist($vcode);
			if($mergercode !='' AND $mergercode > 0){
				//print_r($mergercode);exit;
				$querymerger = "delete from village_merger where merger_group_id='$mergercode'";
				$result = $this-> db-> query($querymerger);
				$query = "delete from villages where vcode='$vcode'";
				$result = $this-> db-> query($query);	
				$querypop = "delete from villages_population where vcode='$vcode'";
				$result = $this-> db-> query($querypop);	  
				
			}else{
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Merger of this Village Exist \n\t So this village is not delete!");';
				$script .= 'history.go(-1);';
				$script .= '</script>';
				echo $script;
				exit();
				}
		}
	}
		//Print_r($checkresult);exit;
		/* $query = "delete *, tehsilname(tcode) as tehsil, unname(uncode)as unioncouncil from villages where vcode='$vcode'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		print_r($data);exit;
		return $data['data'];	 */
	//}
	public function VillageExistinMicroplan($vcode){
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where('area_name',$vcode);
		$result = $this -> db -> get('situation_analysis_db') -> row();
		return $result -> cnt;
	}
	public function validateExistingVcode($vcode){
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where('vcode',$vcode);
		$result = $this -> db -> get('villages') -> row();
		return $result -> cnt;
	}
	public function checkVillageMergeExist($vcode){
		$this -> db -> select('merged_village,merger_group_id');
		$this -> db -> where('vcode',$vcode);
		$result = $this -> db -> get('villages_population') -> result_array();
		//print_r($result);
		if($result[0]['merged_village'] == 0){
			return $result[0]['merger_group_id'];
		}else{
			return 1;
		} 
		
	}
	public function getNewVcodeForUc($uncode){
		if ($uncode > 0) {
			$query = "SELECT max(vcode) as vcd from villages WHERE uncode='$uncode'";
			$result = $this -> db -> query($query);
			$record = $result-> row_array();
			$max_vcode = $record['vcd'];
			if($max_vcode > 0) {
				$dict = $result -> row_array();
				$newCode = $dict['vcd'] + 1;
				$newCode2 = substr($newCode, 0, 12);
				return $newCode;
			}
			else{
				return $uncode.'001';
			}
		}
	}
	public function hf_quarterplan_list(){
		$distcode = $this -> session -> District;	
		$data['distcode'] = $_SESSION['District'];
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
		$data['UserLevel'] = $UserLevel;	
		$query = "SELECT facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by facode";
		$Fac_result = $this-> db-> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "SELECT tcode, tehsil from tehsil where $wc order by tcode";
		$Teh_result = $this-> db-> query($query);
		$data['resultTeh'] = $Teh_result-> result_array();
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from hf_quarterplan_db where distcode='$distcode' order by year DESC, quarter, facode ASC";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		return $data['data'];	
	}
	public function hf_quarterplan_edit($facode,$year,$quarter){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from hf_quarterplan_db where facode='$facode' and year='$year' and quarter='$quarter'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array();
		return $data['data'];	
	}
	public function hf_quarterplan_view($facode,$year,$quarter){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from hf_quarterplan_db where facode='$facode' and year='$year' and quarter='$quarter'";
		$result = $this-> db-> query($query);	
		$data['data'] = $result->result_array();
		return $data['data'];	
	}
	public function ajax_village_save($ajax_village_save,$ajax_village_populatin_save,$tcode,$uncode,$distcode,$vcode,$year)
	{
		//print_r($ajax_village_save);exit;
		$this->db->insert('villages',$ajax_village_save);
		$this->db->insert('villages_population',$ajax_village_populatin_save);
		$this->db-> select('villagename(vcode),vcode');
		$this->db-> from('villages_population');
		$this->db-> where('distcode',$distcode);
		//$this->db-> where('tcode',$tcode);
		$this->db-> where('uncode',$uncode);
		$this->db-> where('year',$year);
		//$this->db-> where('vcode',$vcode);
		$result = $this-> db-> get()-> result_array();
		$data = '<option value="">Select</option>';
		foreach ($result as $value) {
			$data .= '<option value="' . $value['vcode'] . '">' . $value['village'] . '</option>';
		}
		return $data;		
	}
	public function village_get_record($uncode){
		$wc = getWC();
		$query="select village,facilityname(villages.facode) as facode,postal_address,
				(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y"))."') as current_population
				 from villages where $wc and uncode='$uncode'";	
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		return json_encode($result);
	}
}
?>
