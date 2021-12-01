<?php 
class PopulationDensityMap extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
	}
	
	public function index()
	{
		$this -> GovernorateMapData();
	}
	
	public function GovernorateMapData()
	{
		$info['mapName'] = $info['barName'] = "Population Density Map";
		$info['subtittle'] = "District Wise Population Density Thematic Map of Jordan";
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this -> getQuerySelection();
		$data['colorAxis'] = $this -> colorAxis();
		$resultArray = $this -> getRankingSeriesData($result);
		
		$i=0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row['name'];
			$serieses['data'][$i]['id'] = $row['code'];
			$serieses['data'][$i]['path'] = $row['path'];
			$serieses['data'][$i]['value'] = $row['value'];
			$i++;
		}
		array_push($dataSeries,$serieses);
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$viewData['data'] = $data;
		
		$viewData['fileToLoad'] = 'thematic_maps/population_density_thematic_map';
		$viewData['pageTitle'] = 'Jordan Dashboard | Governorate Map ';
		$this -> load -> view('thematic_template/thematic_template',$viewData);
	}
	public function onClickDistrictWiseMapData(){
		if($this -> uri -> segment(4))
			$govcode = $this -> uri -> segment(4);
		$govName = GovernorateName($govcode);
		$info['mapName'] = $info['barName'] = "% of Infant by one Year of Age & Pregnant Women with TT2+ ( 2017 ) - {$govName}";		
		$info['subtittle'] = "District Wise Thematic Map of {$govName}";
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this -> getQuerySelection();
		$data['colorAxis'] = $this -> colorAxis();
		$resultArray = $this -> getRankingSeriesData($result);
		
		$i=0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row['name'];
			$serieses['data'][$i]['id'] = $row['code'];
			$serieses['data'][$i]['path'] = $row['path'];
			$serieses['data'][$i]['value'] = $row['value'];
			$i++;
		}
		array_push($dataSeries,$serieses);
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$viewData['data'] = $data;
		
		$viewData['fileToLoad'] = 'thematic_maps/governorate_thematic_map';
		$viewData['pageTitle'] = 'Jordan Dashboard | District Map ';
		$this -> load -> view('thematic_template/thematic_template',$viewData);
	}

	public function getQuerySelection() 
	{
		if($this -> uri -> segment(4)){
			$govcode = $this -> uri -> segment(4);
			$this -> db -> select('*');
			$this -> db -> from('jor_districts');
			//$this -> db -> where('govcode', $govcode);
			$result = $this -> db -> get() -> result();
			
			foreach($result as $key => $row){
				$serieses[$key]['name'] = $row -> distname;
				$serieses[$key]['code'] = $row -> distcode;
				$serieses[$key]['path'] = $row -> highchart_coordinates;
				$serieses[$key]['value'] = rand(68,100);
			}
		}
		else{
			$this -> db -> select('*');
			$this -> db -> from('jor_districts');
			$result = $this -> db -> get() -> result();
			
			foreach($result as $key => $row){
				$serieses[$key]['name'] = $row -> distname;
				$serieses[$key]['code'] = $row -> distcode;
				$serieses[$key]['path'] = $row -> highchart_coordinates;
				$serieses[$key]['value'] = rand(68,100);
			}
		}		
		return $serieses;
	}

	public function getRankingSeriesData($resultdata)
	{
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
			$serieses[$i]['y'] = $row['value'];
			if($row['value'] > 90){
				$serieses[$i]['color'] = "#0B7546";
			}
			else if($row['value'] <= 90 && $row['value'] >= 71){
				$serieses[$i]['color'] = "#EBB035";
			}
			else if($row['value'] <= 70){
				$serieses[$i]['color'] = "#DD1E2F";
			}
			$i++;
		}
		$compliance = array();
		foreach ($serieses as $key => $value) {
			$compliance[$key] = $value['y'];
		}
		array_multisort($compliance, SORT_DESC, $serieses);
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
	
	function colorAxis(){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '70';
		$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
		$dataClasses['dataClasses'][0]["name"] = '0-70%';

		$dataClasses['dataClasses'][1]['from'] = '71';
		$dataClasses['dataClasses'][1]['to'] = '90';
		$dataClasses['dataClasses'][1]['color'] = '#EBB035';
		$dataClasses['dataClasses'][1]['name'] = '71-90%';

		$dataClasses['dataClasses'][2]['from'] = '91';
		$dataClasses['dataClasses'][2]['to'] = '1000';
		$dataClasses['dataClasses'][2]['color'] = '#0B7546';
		$dataClasses['dataClasses'][2]['name'] = '> 90%';

		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
}
?>