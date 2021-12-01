<?php
class Main_page extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		if($this -> session -> username == 'kp_kphis'){}else{
			authentication();
		}
		$this -> load -> model('dashboard/dashboard_model','dashboard');
	}
	public function index(){
		$data = $this -> dashboard -> getMainIndicatorsData();
		$data['data'] = $data;
		$data['fileToLoad'] = 'dashboard/index';
		$data['pageTitle']='EPI-MIS | Dashboard';
		$this->load->view('template/epi_template',$data);
	}
	
	public function FmvrfCompliace(){
		$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m');
		$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		$fmonth = $year . "-" . $month;
		if($this -> session -> District){
			$data = $this -> getDistrictSeriesData($fmonth);
		}else{
			$data = $this -> getProvincialSeriesData($fmonth);
		}
		$data['data'] = $data;
		$data['fileToLoad'] = 'dashboard/main';
		$data['pageTitle']='EPI-MIS | FMVRF Compliance';
		$this->load->view('template/epi_template',$data);
	}
	
	public function getDistrictSeriesData($fmonth){
		
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getComplianceData($fmonth);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Facilities Submitted Reports";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> facility;
			$serieses1['data'][$i]['name'] = $row -> facility;
			$serieses1['data'][$i]['y'] = $row -> cnt;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		
		return $result;
	}
	
	public function getProvincialSeriesData($fmonth){
		
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getComplianceData($fmonth);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Due";
		$serieses2['name'] = "Submitted";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> district;
			$serieses1['data'][$i]['name'] = $row -> district;
			$serieses1['data'][$i]['y'] = $row -> due;
			$serieses1['data'][$i]['drilldown'] = $row -> district;
			$serieses2['data'][$i]['name'] = $row -> district;
			$serieses2['data'][$i]['y'] = $row -> sub;
			$serieses2['data'][$i]['drilldown'] = $row -> district;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		array_push($result,$serieses2);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		$result['drilldownSeries'] = "";
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		// --------------------------------------------------------------------- //
		// -- Code to get Compliance Data Series Drilldown Series Starts Here -- //

		$drilldown = array();
		$lastDistrictValue = "";
		$drilldownSeriesData = $this -> dashboard -> getComplianceDataDrillDownSeries($fmonth);
		$k=0;$ind=0;
		foreach($drilldownSeriesData as $row){
			if($lastDistrictValue!="" && $lastDistrictValue!=$row -> district){
				$ind++;
				$k=0;
			}		
			$drilldownSeries[$ind]['id'] = $row -> district;
			$drilldownSeries[$ind]['name'] = "Submitted";
			$drilldownSeries[$ind]['data'][$k]= array($row -> facility,$row -> cnt);
			
			$lastDistrictValue = $row -> district;
			$k++;
		}
		array_push($drilldown,$drilldownSeries);
		$result['drilldownSeries'] = json_encode($drilldown,JSON_NUMERIC_CHECK);
		
		// -- Code to get Compliance Data Series Drilldown Series Ends Here -- //
		
		return $result;		
	}
}