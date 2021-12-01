<?php
class FullyImmunizedCoverage extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct(); 
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		authentication();
		$this -> load -> model('cerv/maps_model','maps');
	}
	
	public function index(){ 
		$data = $this -> getPostedData();
		$vaccinesArray = array('Fully Immunized Coverage');
		$monthQauarterYear = " From {$data['yearmonth_from']} to {$data['yearmonth_to']}";
		$data['id']  = $distcode = $this->session->District;
		$data['reportType']  = 'Periodic';
		$districtName = get_District_Name($distcode);
		$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
		$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
		$data['heading']['run'] = false;
		$data['ucwisemap'] = 'true';
		$data['colorAxis'] = $this -> colorAxis($data['vaccineId']);
		$viewData['serieses'] = $this -> getSeriesData($data);
		$data['indicators'][] = '';
		$data['indicators'][] = '';
		$result = $this -> getRankingSeriesData($data);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$data['filter'] = 'Coverage'; 
		$viewData['data'] = $data;
		$viewData['filterRow'] = 'Coverage'; 
		$viewData['fileToLoad'] = 'cerv/thematic_maps/fully_immunized_coverage';
		$viewData['pageTitle']='CERV Dashboard | Open Vial Wastage Rate ';
		$this->load->view('cerv/thematic_template/thematic_template',$viewData);
	}

	public function getPostedData()
	{
		$data['yearmonth_from'] = ($this -> input -> post('yearmonth_from'))?date('Y-m-01',strtotime($this -> input -> post('yearmonth_from'))):date('Y-m-01');
		$data['yearmonth_to'] = ($this -> input -> post('yearmonth_to'))?date('Y-m-t',strtotime($this -> input -> post('yearmonth_to'))):date('Y-m-t');
		$data['vaccineId'] = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):1;
		return $data;
	}
	
	public function getSeriesData($data){
		$coverageData = $this -> getCoverageQuerySelectPortion($data);
		$name = 'UC';
		$serieses = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Open Vial Wastage";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> coverage != "" && $row -> coverage > 0)?round($row -> coverage):0;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
	
	public function getRankingSeriesData($data){
		$coverageData = $this -> getCoverageQuerySelectPortion($data);
		// echo $this -> db -> last_query();
		$name = 'UC';
		$serieses = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();$serieses1 = array();
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses1[$i] = $row -> name;
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['y'] = ($row -> coverage != "")?round($row -> coverage):0;
			$i++;
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}
	
	
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	
	public function getCoverageQuerySelectPortion($data){
		$distcode = $this->session->District;
		$vaccineId = $data['vaccineId'];
		$yearMonthFrom = $data['yearmonth_from'];
		$year_month_from = explode("-",$yearMonthFrom);
		$yearMonthTo = $data['yearmonth_to'];
		$startYear = $year_month_from[0];
		$startMonth = $year_month_from[1];
		$year_month_to = explode("-",$yearMonthTo);
		$endYear = $year_month_to[0];
		$endMonth = $year_month_to[1];
		//fully_immunized
		$targetFormula = "getmonthlytarget_specificyearrsurvivinginfants(ccr.uncode,'unioncouncil',{$startYear},{$startMonth},{$endYear},{$endMonth})";
		$where = " bcg IS NOT NULL AND opv1 IS NOT NULL AND penta1 IS NOT NULL AND pcv1 IS NOT NULL AND measles1 IS NOT NULL AND measles1 >= '{$yearMonthFrom}' AND measles1 <= '{$yearMonthTo}'";
		$q = " 
				select 
						b.uncode as code,b.ucname as name,a.child_vaccinated,a.target,(a.child_vaccinated//a.target::numeric)*100 as coverage,b.path as path 
				from 
						uc_wise_maps_paths b left join 
														(
															select 
																ccr.uncode,unname(ccr.uncode), count(*) as child_vaccinated, 
																{$targetFormula} as target 
															from 
																cerv_child_registration ccr 
															where 
																ccr.distcode='{$distcode}' 
																AND {$where} 
															group by 
																ccr.uncode 
															order by 
																ccr.uncode asc
														) as a ON b.uncode=a.uncode where b.distcode='{$distcode}'";
		$result = $this -> db -> query($q) -> result();
		//echo $this -> db -> last_query();exit;  
		return $result;
	}
	
	public function colorAxis($vaccineId){
		$dataClasses['dataClasses'][0]['from'] = '95';
		$dataClasses['dataClasses'][0]['to'] = '1000';
		$dataClasses['dataClasses'][0]['color'] = '#50eb35 ';
		$dataClasses['dataClasses'][0]['name'] = '>=95%';

		$dataClasses['dataClasses'][1]['from'] = '90';
		$dataClasses['dataClasses'][1]['to'] = '94.99';
		$dataClasses['dataClasses'][1]['color'] = '#3366ff';
		$dataClasses['dataClasses'][1]['name'] = '90-94%';

		$dataClasses['dataClasses'][2]['from'] = '80';
		$dataClasses['dataClasses'][2]['to'] = '89.99';
		$dataClasses['dataClasses'][2]['color'] = '#FFFF00';
		$dataClasses['dataClasses'][2]['name'] = '80-89%';

		$dataClasses['dataClasses'][3]['from'] = '50';
		$dataClasses['dataClasses'][3]['to'] = '79.99';
		$dataClasses['dataClasses'][3]['color'] = '#FF8C00';
		$dataClasses['dataClasses'][3]['name'] = '50-79%';
		
		$dataClasses['dataClasses'][4]["from"] = '0';
		$dataClasses['dataClasses'][4]["to"] = '49.99';
		$dataClasses['dataClasses'][4]["color"] = '#e3330d';
		$dataClasses['dataClasses'][4]["name"] = '< 50%';
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK); 
		return $data['colorAxis'];
	}
}
?>