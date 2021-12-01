<?php
class Data_extraction_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function getCountries() {
		$this -> db -> select('*');
		$this -> db -> from('countries');
		$this -> db -> order_by('id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getCountryGovernorates($countryId) {
		$this -> db -> select('*');
		$this -> db -> from('country_governorates');
		$this -> db -> where('country_id',$countryId);
		$this -> db -> order_by('id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getGovernorateDistricts($governorateId) {
		$this -> db -> select('*');
		$this -> db -> from('governorate_districts');
		$this -> db -> where('governorate_id',$governorateId);
		$this -> db -> order_by('id','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getDistrictFacilities($districtId) {
		$this -> db -> select('*');
		$this -> db -> from('district_facilities');
		$this -> db -> where('district_id',$districtId);
		$this -> db -> order_by('id','asc');
		return $this -> db -> get() -> result_array();
	}
}
?>