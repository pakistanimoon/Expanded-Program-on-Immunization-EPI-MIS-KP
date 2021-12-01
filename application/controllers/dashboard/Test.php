<?php
class Test extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		//zing chart library used on this page
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('dashboard/dashboard_model','dashboard');
	}
	
	public function index(){
		$data['data'] = $this -> getDistrictSeriesData();
		//print_r($data);exit;
		$data['fileToLoad'] = 'dashboard/test';
		$data['pageTitle']='EPI-MIS | Population';
		$this->load->view('template/epi_template',$data);
	}
	public function getDistrictSeriesData(){
		
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getPopulationData();
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Districts Population";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> name;
			$serieses1['data'][$i]['name'] = $row -> name;
			$serieses1['data'][$i]['y'] = $row -> pop;
			$serieses1['data'][$i]['id'] = $row -> code;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		
		return $result;
	}
	public function getFacilitiesPopulation(){
		$code = $this -> input -> post('id');
		$seriesData = $this -> dashboard -> getFacilitesPopulationData($code);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Facilities Population";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> name;
			$serieses1['data'][$i]['name'] = $row -> name;
			$serieses1['data'][$i]['y'] = $row -> pop;
			$serieses1['data'][$i]['id'] = $row -> code;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		
		echo json_encode($result,JSON_NUMERIC_CHECK);
	}
}