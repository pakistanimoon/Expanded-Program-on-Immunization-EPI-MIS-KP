<?php
	class Apis extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Data_extraction_model','apis');
	}
	
	public function store_ou(){
		$string = file_get_contents("http://epikp.pacemis.com/jordan/assets/ou.json");
		$json_a = json_decode($string, true);
		echo "Province ID {$json_a['id']}, Province Name {$json_a['text']};<br>";
		$country = array(
							'id' => $json_a['id'],
							'name' => $json_a['text']
						);
		//$this -> db -> insert('countries',$country);
		foreach($json_a['nodes'] as $governoratekey => $governoratevalue){
			echo "Governorate ID {$governoratevalue['id']}, Governorate Name {$governoratevalue['text']};<br>";
			$governorates = array(
							'country_id' => $json_a['id'],
							'id' => $governoratevalue['id'],
							'name' => $governoratevalue['text']
						);
			//$this -> db -> insert('country_governorates',$governorates);
			foreach($governoratevalue['nodes'] as $districtkey => $districtvalue){
				echo "    District ID {$districtvalue['id']}, District Name {$districtvalue['text']};<br>";
				$districts = array(
							'country_id' => $json_a['id'],
							'governorate_id' => $governoratevalue['id'],
							'id' => $districtvalue['id'],
							'name' => $districtvalue['text']
						);
				//$this -> db -> insert('governorate_districts',$districts);
				foreach($districtvalue['nodes'] as $facilitykey => $facilityvalue){
					echo "        Facility ID {$facilityvalue['id']}, Facility Name {$facilityvalue['text']};<br>";
					$facilities = array(
							'country_id' => $json_a['id'],
							'governorate_id' => $governoratevalue['id'],
							'district_id' => $districtvalue['id'],
							'id' => $facilityvalue['id'],
							'name' => $facilityvalue['text']
						);
					//$this -> db -> insert('district_facilities',$facilities);
				}
			}
		}
	}
	
	public function demographics_age_wise(){
		//Get Country
		$countriesData = $this -> apis -> getCountries();
		foreach($countriesData as $ckey => $country){
			$countryId = $country['id'];
			$countryName = $country['name'];
			$governoratesData = $this -> apis -> getCountryGovernorates($countryId);
			foreach($governoratesData as $gkey => $governorate){
				$governorateId = $governorate['id'];
				$governorateName = $governorate['name'];
				echo "<strong>Governorate ID : {$governorateId}, Governorate Name : {$governorateName}; </strong>";
				$districtsData = $this -> apis -> getGovernorateDistricts($governorateId);
				foreach($districtsData as $dkey => $district){
					$districtId = $district['id'];
					$districtName = $district['name'];
					echo "<strong>District ID : {$districtId}, District Name : {$districtName};</strong><br>";
					$facilitiesData = $this -> apis -> getDistrictFacilities($districtId);
					foreach($facilitiesData as $fkey => $facility){
						echo $facilityId = $facility['id'];
						echo $facilityName = ' - ' . $facility['name'].'<br>';
					}
					echo "<hr>";
				}
			}
		}
	}
}
?>