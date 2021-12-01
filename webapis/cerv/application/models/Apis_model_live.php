<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Apis_model class.
 * 
 * @extends CI_Model
 */
class Apis_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function checkChildRegistered($childRegistrationNo)
	{		
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where('child_registration_no',$childRegistrationNo);
		$result = $this -> db -> get('cerv_child_registration') -> row();
		if($result->cnt > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	function updateChildRegistrationData($data,$childRegistrationNo){
		$this -> db -> update('cerv_child_registration',$data,array('child_registration_no' => $childRegistrationNo));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function saveNewRegisteredChildData($data){
		$this -> db -> insert('cerv_child_registration',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function checkMotherRegistered($motherRegistrationNo)
	{		
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where('mother_registration_no',$motherRegistrationNo);
		$result = $this -> db -> get('cerv_mother_registration') -> row();
		if($result->cnt > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	
	function updateMotherRegistrationData($data,$motherRegistrationNo){
		$this -> db -> update('cerv_mother_registration',$data,array('mother_registration_no' => $motherRegistrationNo));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function saveNewRegisteredMotherData($data){
		$this -> db -> insert('cerv_mother_registration',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function saveTechnicianCheckinDetails($data){
		$this -> db -> insert('technician_checkin_details',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function updateTechnicianCheckinDetails($data,$workDate,$technicianCode){
		$this -> db -> update('technician_checkin_details',$data,array('work_date' => $workDate, 'techniciancode' => $technicianCode));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	
	function searchChildrenData($where=NULL,$like=NULL){
		$this -> db -> select('child_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, nameofchild, cardno, gender, dateofbirth, housestreet, villagemohallah, fathername, mothername, fathercnic, contactno, latitude, longitude, year, bcg, hepb, opv0, opv1, opv2, opv3, penta1, penta2, penta3, pcv1, pcv2, pcv3, ipv, rota1, rota2, measles1, measles2, bcg_lat, bcg_long, hepb_lat, hepb_long, opv0_lat, opv0_long, opv1_lat, opv1_long, opv2_lat, opv2_long, opv3_lat, opv3_long, penta1_lat, penta1_long, penta2_lat, penta2_long, penta3_lat, penta3_long, pcv1_lat, pcv1_long, pcv2_lat, pcv2_long, pcv3_lat, pcv3_long, ipv_lat, ipv_long, rota1_lat, rota1_long, rota2_lat, rota2_long, measles1_lat, measles1_long, measles2_lat, measles2_long, fingerprint, bcg_facode, hepb_facode, opv0_facode, opv1_facode, opv2_facode, opv3_facode, penta1_facode, penta2_facode, penta3_facode, pcv1_facode, pcv2_facode, pcv3_facode, ipv_facode, rota1_facode, rota2_facode, measles1_facode, measles2_facode, isoutsitefacility, submitteddate');
		if($where)
			$this -> db -> where($where);
		else if($like)
			$this -> db -> like('LOWER(' .$like["key"]. ')', strtolower($like["value"]),'both');
		return $this -> db -> get('cerv_child_registration') -> result_array();
	}
	
	function searchMotherData($where=NULL,$like=NULL){
		$this -> db -> select('mother_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, mother_name, mother_age, cardno, house, village, husband_name, mother_cnic, contactno, latitude, longitude, year, tt1, tt2, tt3, tt4, tt5, tt1_lat, tt1_long, tt2_lat, tt2_long, tt3_lat, tt3_long, tt4_lat, tt4_long, tt5_lat, tt5_long, fingerprint, tt1_facode, tt2_facode, tt3_facode, tt4_facode, tt5_facode, is_outer_registered, submitted_date');
		if($where)
			$this -> db -> where($where);
		else if($like)
			$this -> db -> like('LOWER(' .$like["key"]. ')', strtolower($like["value"]),'both');
		return $this -> db -> get('cerv_mother_registration') -> result_array();
	}
}
?>