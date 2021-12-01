<?php
class ZeroReportingCompliance extends CI_Controller {

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
		$week = ($this -> input -> post('week'))?$this -> input -> post('week'):lastWeek();
		$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		$fweek = $year . "-" . $week;
		if($this -> session -> District){
			$data = $this -> getDistrictSeriesData($fweek);
		}else{
			$data = $this -> getProvincialSeriesData($fweek);
		}
		$data['data'] = $data;
		$data['fileToLoad'] = 'dashboard/zero';
		$data['pageTitle']='EPI-MIS | Zero Report Compliance';
		$this->load->view('template/epi_template',$data);
	}
	
	public function getDistrictSeriesData($fweek){
		
	}
	
	public function getProvincialSeriesData($fweek){
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getZeroComplianceData($fweek);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses4['name'] = "Total";
		$serieses1['name'] = "Timeliness";
		$serieses2['name'] = "Completeness";
		$serieses3['name'] = "Not Submitted";
		
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> name;
			$serieses4['data'][$i]['name'] = $row -> name;
			$serieses4['data'][$i]['y'] = $row -> total;
			$serieses4['data'][$i]['drilldown'] = $row -> name;
			$serieses1['data'][$i]['name'] = $row -> name;
			$serieses1['data'][$i]['y'] = $row -> timely;
			$serieses1['data'][$i]['drilldown'] = $row -> name;
			$serieses2['data'][$i]['name'] = $row -> name;
			$serieses2['data'][$i]['y'] = $row -> complete;
			$serieses2['data'][$i]['drilldown'] = $row -> name;
			$serieses3['data'][$i]['name'] = $row -> name;
			$serieses3['data'][$i]['y'] = (int)(($row -> total)-(($row->timely) + ($row->complete)));
			$serieses3['data'][$i]['drilldown'] = $row -> name;			
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses4);
		array_push($result,$serieses1);
		array_push($result,$serieses2);
		array_push($result,$serieses3);
		
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		$result['drilldownSeries'] = "";
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		// --------------------------------------------------------------------- //
		// -- Code to get Compliance Data Series Drilldown Series Starts Here -- //

		/* $drilldown = array();
		$lastDistrictValue = "";
		$drilldownSeriesData = $this -> dashboard -> getZeroComplianceDataDrillDownSeries($fweek);
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
		$result['drilldownSeries'] = json_encode($drilldown,JSON_NUMERIC_CHECK); */
		
		// -- Code to get Compliance Data Series Drilldown Series Ends Here -- //
		
		return $result;
	}
}