<?php
class OpenVialWastageRate extends CI_Controller {

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
		$vaccinesArray = array('BCG','Hep B-Birth','OPV','PENTA','Pneumococcal','IPV','Rota','Measles');
		$monthQauarterYear = " From {$data['yearmonth_from']} to {$data['yearmonth_to']}";
		$data['id']  = $distcode = $this->session->District;
		$data['reportType']  = 'Periodic';
		$districtName = get_District_Name($distcode);
		$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Open Vial Wastage, ".$districtName." {$monthQauarterYear}";
		$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Open Vial Wastage, ".$districtName." {$monthQauarterYear}";
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
		$data['filter'] = 'OpenVialWastageRate'; 
		$viewData['data'] = $data;
		$viewData['filterRow'] = 'OpenVialWastageRate'; 
		$viewData['fileToLoad'] = 'cerv/thematic_maps/open_vial_wastage_rate';
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
			$serieses['data'][$i]['value'] = ($row -> openvial_wastagerate != "" && $row -> openvial_wastagerate > 0)?round($row -> openvial_wastagerate):0;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
	
	public function getRankingSeriesData($data){
		$coverageData = $this -> getCoverageQuerySelectPortion($data);
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
			$serieses['data'][$i]['y'] = ($row -> openvial_wastagerate != "")?round($row -> openvial_wastagerate):0;
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
		$yearMonthTo = $data['yearmonth_to'];
		$where = " bcg IS NOT NULL and bcg >= '{$yearMonthFrom}' AND bcg <= '{$yearMonthTo}'";
		switch($vaccineId){
			case 2:
				$where = " hepb IS NOT NULL and hepb >= '{$yearMonthFrom}' AND hepb <= '{$yearMonthTo}'";
				break;
			case 3:
				$where = " (opv0 IS NOT NULL and opv0 >= '{$yearMonthFrom}' AND opv0 <= '{$yearMonthTo}') OR (opv1 IS NOT NULL and opv1 >= '{$yearMonthFrom}' AND opv1 <= '{$yearMonthTo}') OR (opv2 IS NOT NULL and opv2 >= '{$yearMonthFrom}' AND opv2 <= '{$yearMonthTo}') OR (opv3 IS NOT NULL and opv3 >= '{$yearMonthFrom}' AND opv3 <= '{$yearMonthTo}')";
				break;
			case 4:
				$where = " (penta1 IS NOT NULL and penta1 >= '{$yearMonthFrom}' AND penta1 <= '{$yearMonthTo}') OR (penta2 IS NOT NULL and penta2 >= '{$yearMonthFrom}' AND penta2 <= '{$yearMonthTo}') OR (penta3 IS NOT NULL and penta3 >= '{$yearMonthFrom}' AND penta3 <= '{$yearMonthTo}')";
			case 5;
				$where = " (pcv1 IS NOT NULL and pcv1 >= '{$yearMonthFrom}' AND pcv1 <= '{$yearMonthTo}') OR (pcv2 IS NOT NULL and pcv2 >= '{$yearMonthFrom}' AND pcv2 <= '{$yearMonthTo}') OR (pcv3 IS NOT NULL and pcv3 >= '{$yearMonthFrom}' AND pcv3 <= '{$yearMonthTo}')";
			case 6:
				$where = " ipv IS NOT NULL and ipv >= '{$yearMonthFrom}' AND ipv <= '{$yearMonthTo}'";
			case 7: 
				$where = " (rota1 IS NOT NULL and rota1 >= '{$yearMonthFrom}' AND rota1 <= '{$yearMonthTo}') OR (rota2 IS NOT NULL and rota2 >= '{$yearMonthFrom}' AND rota2 <= '{$yearMonthTo}')";
			case 8:
				$where = " (measles1 IS NOT NULL and measles1 >= '{$yearMonthFrom}' AND measles1 <= '{$yearMonthTo}') OR (measles2 IS NOT NULL and measles2 >= '{$yearMonthFrom}' AND measles2 <= '{$yearMonthTo}')";
			default:
				$where = " bcg IS NOT NULL and bcg >= '{$yearMonthFrom}' AND bcg <= '{$yearMonthTo}'";
				break;
		}
		$q = " 
				select 
						b.uncode as code,b.ucname as name,a.child_vaccinated,a.doses_used,a.vial_used,a.openvial_wastagerate,b.path as path 
				from 
						uc_wise_maps_paths b left join 
														(select 
																uwmp.uncode,unname(uwmp.uncode),
																count(*) as child_vaccinated,
																ceil(count(*)//20)*20 as doses_used,
																ceil(count(*)//20) as vial_used,
																((ceil(count(*)//20)*20)-count(*))*100//(ceil(count(*)//20)*20) as openvial_wastagerate, uwmp.path
														from 
																uc_wise_maps_paths uwmp, cerv_child_registration ccr
														where 
																uwmp.uncode=ccr.uncode and uwmp.distcode='{$distcode}' AND 
																{$where}
														group by 
																uwmp.uncode,uwmp.path
														order by 
																uncode asc) as a ON b.uncode=a.uncode where b.distcode='{$distcode}'";
		$result = $this -> db -> query($q) -> result();
		//echo $this -> db -> last_query();exit;  
		return $result;
	}
	
	public function colorAxis($vaccineId){
		if($vaccineId == 1){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '30'; 
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-30%';

			$dataClasses['dataClasses'][1]['from'] = '31';
			$dataClasses['dataClasses'][1]['to'] = '40';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '31-40%';
			
			$dataClasses['dataClasses'][2]['from'] = '41';
			$dataClasses['dataClasses'][2]['to'] = '50';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '41-50%';

			$dataClasses['dataClasses'][3]['from'] = '51';
			//$dataClasses['dataClasses'][2]['to'] = '';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>50%';
		}else if($vaccineId == 2){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 3){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '10.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-10%';

			$dataClasses['dataClasses'][1]['from'] = '11';
			$dataClasses['dataClasses'][1]['to'] = '20.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '11-20%';

			$dataClasses['dataClasses'][2]['from'] = '20';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 4){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '1000';
			$dataClasses['dataClasses'][1]['color'] = '#e3330d';
			$dataClasses['dataClasses'][1]['name'] = '>5%';
		}else if($vaccineId == 5){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 6){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 7){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '10.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-10%';

			$dataClasses['dataClasses'][1]['from'] = '11';
			$dataClasses['dataClasses'][1]['to'] = '20.99';
			$dataClasses['dataClasses'][1]['color'] = '#31f8dd';
			$dataClasses['dataClasses'][1]['name'] = '11 to 20%';

			$dataClasses['dataClasses'][2]['from'] = '21';
			$dataClasses['dataClasses'][2]['to'] = '30.99';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '21 to 30%';

			$dataClasses['dataClasses'][3]['from'] = '31';
			$dataClasses['dataClasses'][3]['to'] = '1000';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '30 and above';
		}else if($vaccineId == 8){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '20.99';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '11-20%';
			
			$dataClasses['dataClasses'][3]['from'] = '20';
			$dataClasses['dataClasses'][3]['to'] = '1000';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>20%';
		}else{
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '30'; 
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-30%';

			$dataClasses['dataClasses'][1]['from'] = '31';
			$dataClasses['dataClasses'][1]['to'] = '40';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '31-40%';
			
			$dataClasses['dataClasses'][2]['from'] = '41';
			$dataClasses['dataClasses'][2]['to'] = '50';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '41-50%';

			$dataClasses['dataClasses'][3]['from'] = '51';
			//$dataClasses['dataClasses'][2]['to'] = '';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>50%';
		}
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
}
?>