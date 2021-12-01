<?php 
class ThematicMapJordan extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() { 
		$this -> GovernorateMapData();
	}
	//----------------------------------------------------------//
	//================ GovernorateMapData function starts====================//
	public function GovernorateMapData(){
		
		$info['mapName'] = $info['barName'] = "Governorate Wise Thematic Map of Jordan";
		$info['subtittle'] = "Governorate";
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this -> getQuerySelection();
		$resultArray = $this -> getRankingSeriesData($result);
		$i=0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row['name'];
			$serieses['data'][$i]['id'] = $row['code'];
			$serieses['data'][$i]['path'] = $row['path'];
			$serieses['data'][$i]['value'] = rand(60,100);
			$i++;
		}
		//$dataSeries['data'] = $dataSeries;
		array_push($dataSeries,$serieses);
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($data['serieses']);exit;
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$viewData['data'] = $data;
		
		
		$viewData['fileToLoad'] = 'thematic_maps/governorate_thematic_map';
		$viewData['pageTitle'] = 'Jordan Dashboard | Governorate Map ';
		$this -> load -> view('thematic_template/thematic_template',$viewData);
	}
	
	public function getQuerySelection() 
	{
		$this -> db -> select('*');
		$this -> db -> from('jor_governorate');
		$result = $this -> db -> get() -> result();
		
		foreach($result as $key => $row){
			$serieses[$key]['name'] = $row -> govname;
			$serieses[$key]['code'] = $row -> govcode;
			$serieses[$key]['path'] = $row -> highchart_coordinates;
			$serieses[$key]['value'] = 0;
		}
		return $serieses;
	}

	public function getRankingSeriesData($resultdata){
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();
		$dataSeries1 = array();
		
		$i=0;
		$s['name'] = " ";
		$s['animation'] = true;
		$s['dataLabels']['enabled'] = true;
		$s['dataLabels']['align'] = "center";
		foreach($resultdata as $key => $row){
			$serieses[$i]['name'] = $row['name'];
			$serieses[$i]['id'] = $row['code'];
			$serieses[$i]['y'] = $i+1;
			$i++;
		}
		foreach ($serieses as $key => $value) {
				array_push($serieses1, $value['name']);
		}
		
		$s['data'] = $serieses;
		array_push($dataSeries,$s);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}
	
	/* function colorAxis(){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '70';
		$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
		$dataClasses['dataClasses'][0]["name"] = '0-70%';

		$dataClasses['dataClasses'][1]['from'] = '71';
		$dataClasses['dataClasses'][1]['to'] = '99';
		$dataClasses['dataClasses'][1]['color'] = '#EBB035';
		$dataClasses['dataClasses'][1]['name'] = '71-99%';

		$dataClasses['dataClasses'][2]['from'] = '100';
		$dataClasses['dataClasses'][2]['to'] = '1000';
		$dataClasses['dataClasses'][2]['color'] = '#0B7546';
		$dataClasses['dataClasses'][2]['name'] = '100%';

		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	} */
}
?>