<?php
class Nonccmlocations_model extends CI_Model {
	public function getAllLocations($distcode,$warehouseTypeId){
		$this -> db -> select('*');
		if($distcode == NULL)
			$this -> db -> where(array('procode'=>$_SESSION["Province"], 'warehouse_type_id'=>'2'));
		else
			$this -> db -> where(array('procode'=>$_SESSION["Province"], 'warehouse_type_id'=>'4', 'distcode'=>$distcode));
		
		return $this -> db -> get('epi_non_ccm_locations') -> result_array();
	}
}
?>