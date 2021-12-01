<?php
class Measles extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//authentication();
		$this -> load -> model('maps/Measles_maps_model','maps');
	}
	
	public function index($distcode=NULL){
		$data['distcode'] = $distcode;
		$year = date('Y');
		$data['typeWise'] = 'District';
		$data['subtitle'] = 'Khyber Pakhtunkhwa';
		if($distcode){
			$data['typeWise'] = 'Union Council';
			$this -> load -> helper('epi_functions_helper');
			$data['subtitle'] = DistrictName($distcode);
		}
		$data['summary'] = $this -> maps -> measlesSummary($distcode, $year);
		$data['serieses'] = $this -> getSuspectedCasesSeriesData($distcode, $year);
		$data['districtSummary'] = $this -> maps -> districtWiseMeaslesSummary($distcode, $year);
		$data['weeklySuspected'] = $this -> maps -> getMeaslesWeeklySuspectedCasesDetail($distcode, $year);
		$data['weeklyConfirmed'] = $this -> maps -> getMeaslesWeeklyConfirmedCasesDetail($distcode, $year);
		$data['weeklyDeaths'] = $this -> maps -> getMeaslesWeeklyDeathsCasesDetail($distcode, $year);
		$data['weeklyRecovered'] = $this -> maps -> getMeaslesWeeklyRecoveredCasesDetail($distcode, $year);
		$data['weeklyMale'] = $this -> maps -> getMeaslesWeeklyMaleCasesDetail($distcode, $year);
		$data['weeklyFemale'] = $this -> maps -> getMeaslesWeeklyFemaleCasesDetail($distcode, $year);
		//echo $this -> db -> last_query();exit;
		$this -> load -> view('thematic_maps/parts_view/ucmeasles',$data);
	}
	
	public function getSuspectedCasesSeriesData($distcode){
		$year = date('Y');
		$activeCases = $this -> maps -> getSuspectedCasesSeriesData($distcode, $year);
		//echo $this -> db -> last_query();exit;
		$serieses = $result = $dataSeries = array();
		$i=0;
		$typeWise = 'District';
		if($distcode)
			$typeWise = 'Union Council';
		$serieses['name'] = "{$typeWise} Wise Measles Suspected Cases";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($activeCases as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> value > 0)?$row -> value:NULL;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
}
?>