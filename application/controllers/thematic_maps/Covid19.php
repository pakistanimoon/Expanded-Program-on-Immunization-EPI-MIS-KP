<?php
class Covid19 extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//authentication();
		$this -> load -> model('maps/maps_model','maps');
	}
	
	public function index($distcode=NULL){
		$data['distcode'] = $distcode;
		$data['typeWise'] = 'District';
		$data['subtitle'] = 'Khyber Pakhtunkhwa';
		if($distcode){
			$data['typeWise'] = 'UnionCouncil';
			$this -> load -> helper('epi_functions_helper');
			$data['subtitle'] = DistrictName($distcode);
		}
		$data['summary'] = $this -> maps -> covid19Summary($distcode);
		$data['serieses'] = $this -> getActiveCasesSeriesData($distcode);
		$data['districtSummary'] = $this -> maps -> districtWiseCovid19Summary($distcode);
		$data['weeklySuspected'] = $this -> maps -> getCovidWeeklySuspectedCasesDetail($distcode);
		$data['weeklyConfirmed'] = $this -> maps -> getCovidWeeklyConfirmedCasesDetail($distcode);
		$data['weeklyDeaths'] = $this -> maps -> getCovidWeeklyDeathsCasesDetail($distcode);
		$data['weeklyRecovered'] = $this -> maps -> getCovidWeeklyRecoveredCasesDetail($distcode);
		$data['weeklyMale'] = $this -> maps -> getCovidWeeklyMaleCasesDetail($distcode);
		$data['weeklyFemale'] = $this -> maps -> getCovidWeeklyFemaleCasesDetail($distcode);
		//echo $this -> db -> last_query();exit;
		$this -> load -> view('thematic_maps/parts_view/uccovid',$data);
	}
	
	public function getActiveCasesSeriesData($distcode){
		$activeCases = $this -> maps -> getActiveCasesSeriesData($distcode);
		//echo $this -> db -> last_query();exit;
		$serieses = $result = $dataSeries = array();
		$i=0;
		$typeWise = 'District';
		if($distcode)
			$typeWise = 'UnionCouncil';
		$serieses['name'] = "{$typeWise} Wise Covid19 Active Cases";
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