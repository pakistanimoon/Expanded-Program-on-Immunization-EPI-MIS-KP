<?php
class UtilizationOfServices extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		$code = md5(date("Y-n-d"));
		if(isset($_GET['code']) && $_GET['code'] == $code){
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'provincename' => 'Islamabad',
				'Province' => '7',
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		$this -> load -> model('maps/maps_model','maps');
	}
	
	public function index(){
		$ajax = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$data['year']  = $year = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		$monthQauarterYear = "";
		if($data['reportType'] == 'monthly'){
			$currMon = date('m');
			$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			//$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] = '';
			$data['biyear'] = '';
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType'] == 'quarterly'){
			//$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter']  = ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
			$data['biyear'] = '';
			$data['month'] = '';
		}elseif($data['reportType'] == 'biyearly'){
			$data['biyear']  = ($this -> input -> post('biyear'))?$this -> input -> post('biyear'):01;
			$monthQauarterYear = $year." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
			//$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] = '';
			$data['month'] = '';
		}elseif($data['reportType'] == 'yearly'){
			//$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['month'] = '';
			$data['quarter'] = '';
			$data['biyear'] = '';
			$monthQauarterYear = $year;
		}else{
			$data = array();
		}//exit;
		//print_r($data);exit;
		$data['vaccineId']  = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):'9';
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('vaccineBy'))?$this -> input -> post('vaccineBy'):'All';
		if($data['vaccineId'] == 2){
			$data['vaccGivento']  = ($this -> input -> post('vaccGivento'))?$this -> input -> post('vaccGivento'):'Both';
		}
		//print_r($data);exit;
		$vaccinesArray = array('9' => 'Penta 1 - Penta 3', '18' => 'Measles 1 - Measles 2', '2' => 'TT 1 - TT 2', '16' => 'Penta 1 - Measles 1');
		$data['heading']['mapName'] = $vaccinesArray[$data['vaccineId']]." Dropout";
		//$monthQauarterYear = "";
		//$year = $data['year'];
		/* if($data['reportType']=='monthly'){
			//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType']=='biyearly'){
			$monthQauarterYear = $year." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}else{
			$monthQauarterYear = $year;
		} *///print_r($monthQauarterYear);exit;
		//$data['colorAxis'] = $this -> colorAxis();
		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$districtName = $this->maps->districtName($distcode);
			$result = $this -> UcWiseMapData($data);
			$viewData['serieses'] = $result['serieses'];
			$result = $this -> getUCsRankingSeriesData($data);
			$data['indicators'] = $this -> getIndicatorData($data);
			$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, ".$districtName." {$monthQauarterYear}";
			$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, ".$districtName." {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['colorAxis'] = $this -> colorAxis('uc');
		}else{
			$result = $this -> getProvincialSeriesData($data);
			$data['id']  = $this -> input -> post('id');
			$viewData['serieses'] = $result['serieses'];
			$data['indicators'] = $this -> getIndicatorData($data);
			$result = $this -> getDistrictsRankingSeriesData($data);
			$distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):($this->session->District)?$this->session->District:'';
			$districtName = $this->maps->districtName($distcode);
			$provicialdistlevel = "";
			if($data['id']!=""){
				$provicialdistlevel = $districtName.", ";
			}
			$data['heading']['barName'] = "District Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, {$provicialdistlevel} {$monthQauarterYear}";
			$data['heading']['mapName'] = "District Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, {$provicialdistlevel} {$monthQauarterYear}";
			$data['heading']['run'] = true;
			$data['colorAxis'] = $this -> colorAxis('dist');
		}
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$viewData['data'] = $data;
		//print_r($viewData['serieses']);exit;
		if($ajax){
			$viewData['id'] = $this -> input -> post('map_id');
			$viewData['fmonth'] = $this -> input -> post('fmonth');
			$viewData['colorAxis'] = $this -> colorAxis();
			$viewData['heading']['mapName'] = $data['heading']['mapName'];
			$viewData['heading']['barName'] = $data['heading']['barName'];
			$viewData['heading']['run'] = $data['heading']['run'];
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar); //print_r($viewData);exit;
			echo json_encode($arr);
			exit;
		}
		$viewData['filterowbtn'] = 'UtilizationOfServices';
		$viewData['fileToLoad'] = 'thematic_maps/utilization_of_thematic_services';
		$viewData['pageTitle']='EPI-MIS Dashboard | Utilization of Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}

	public function onClickUcWiseMapData(){
		
		//print_r($this -> uri -> segment(10));exit;
		if($this -> uri -> segment(4)){
			//$data['id'] = $this -> input -> post('id');
			$data = array();
			$data['id'] 		 = $this -> uri -> segment(4);
			$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
			$data['month'] 		= ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime("first day of previous months"));
			$data['year']  		= ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
			$data['quarter']  	= ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			$data['vaccineId']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'1';
			$data['gender']  	= ($this -> uri -> segment(10))?$this -> uri -> segment(10):'Both';
			$data['vaccineBy']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'All';
			$data['biyear']  	= ($this -> uri -> segment(12))?$this -> uri -> segment(12):'01';
			$districtName = $this->maps->districtName($data['id']);
			
			if($data['reportType'] == 'monthly'){
				$data['quarter'] = '';
				$data['biyear'] = '';
			}elseif($data['reportType'] == 'quarterly'){
				$data['month'] = '';
				$data['biyear'] = '';
			}elseif($data['reportType'] == 'biyearly'){
				$data['quarter'] = '';
				$data['month'] = '';
			}elseif($data['reportType'] == 'yearly'){
				$data['quarter'] = '';
				$data['month'] = '';
				$data['biyear'] = '';
			}else{
				$data = array();
			}
			if($data['vaccineId'] == 2){
				$data['vaccGivento']  = ($this -> input -> post('vaccGivento'))?$this -> input -> post('vaccGivento'):'Both';
			}
		}
		
		$monthQauarterYear = "";
		$year = $data['year'];
		if($data['reportType'] =='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType'] =='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}elseif($data['reportType'] =='biyearly'){
			$monthQauarterYear = $year." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
		}else{
			$monthQauarterYear = $year;
		}
		$data['colorAxis'] = $this -> colorAxis();
		$result1 = $this -> maps -> getMainIndicatorsData();
		$data['indicators'] = $result1;
		if($data['vaccineId']=='1'){
			$data['vaccineId']= "9";
		}
		$vaccinesArray = array('9' => 'Penta 1 - Penta 3', '18' => 'Measles 1 - Measles 2', '2' => 'TT 1 - TT 2', '16' => 'Penta 1 - Measles 1');
		$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, ".$districtName." {$monthQauarterYear}";
		$data['heading']['subtittle'] = $this -> session -> provincename;
		if($this -> session -> District || $this -> uri -> segment(4)){
			$result = $this -> UcWiseMapData($data);
			$viewData['serieses'] = $result['serieses'];
			//$viewData['series1'] = $this->getUCsRankingSeriesData($data);
			$data['indicators'] = $this -> getIndicatorData($data);
			$result = $this -> getUCsRankingSeriesData($data);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']]." Dropout Rate, ".$districtName." {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$viewData['data'] = $data;
			$data['ucwisemap'] = 'true';
			$viewData['filterowbtn'] = 'UtilizationOfServices';
			$viewData['fileToLoad'] = 'thematic_maps/utilization_of_thematic_services';
			$viewData['pageTitle']='EPI-MIS Dashboard | Utilization of Services ';
			$this->load->view('thematic_template/thematic_template',$viewData);
			//echo json_encode($viewData,JSON_NUMERIC_CHECK);
		}else{
		}		
	}
	
	public function getProvincialSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getVaccinesDropout($data, $selectQuery);
		$serieses = array();
		$result = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = "District Wise Dropout";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		if($coverageData){
			foreach($coverageData as $row){
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['path'] = $row -> path;
				if($row->second == 0 || $row->second == ''){
					$serieses['data'][$i]['value'] = 0;
				}else{
					$value = round((((int)$row->second -(int)$row->first)*100)/(int)$row->second);
					$serieses['data'][$i]['value'] = ($value < 0)?0:$value;
				}
				$i++;
			}
		}
		array_push($dataSeries,$serieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($result['serieses']);exit;
		return $result;
	}
	
	public function UcWiseMapData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getUCsVaccineDropout($data, $selectQuery);
		$serieses = array();
		$result = array();
		$dataSeries = array();
		$data['colorAxis'] = $this -> colorAxis();
		$i=0;
		$serieses['name'] = "UC Wise Dropout";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		if($coverageData){
			foreach($coverageData as $row){
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['path'] = $row -> path;
				if($row->second == 0 || $row->second == ''){
					$serieses['data'][$i]['value'] = 0;
				}else{
					$value = round((((int)$row->second -(int)$row->first)*100)/(int)$row->second);
					$serieses['data'][$i]['value'] = ($value < 0)?0:$value;
				}
				$i++;
			}
		}
		array_push($dataSeries,$serieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($result['serieses']);exit;
		return $result;
	}

	public function getDistrictsRankingSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getVaccinesDropout($data, $selectQuery);
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();
		
		$i=0;
		$serieses['name'] = "District Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center"; 
		if($coverageData){
			foreach($coverageData as $row){
				//$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				if($row->second == 0 || $row->second == ''){
					$serieses['data'][$i]['y'] = 0;
				}else{
					$value = round((((int)$row->second -(int)$row->first)*100)/(int)$row->second);
					$serieses['data'][$i]['y'] = ($value < 0)?0:$value;
				}	
				$dropout = $serieses['data'][$i]['y'];
				if($dropout >= 11)
					$serieses['data'][$i]['color'] = "#fa1e2e";//red color 
				else 
					$serieses['data'][$i]['color'] = "#2cdc2a";//green color
				$i++;
			}
			$compliance = array();
			foreach ($serieses['data'] as $key => $value) {
					$compliance[$key] = $value['y'];
			}
			
			array_multisort($compliance, SORT_ASC, $serieses['data']);

			foreach ($serieses['data'] as $key => $value) {
					array_push($serieses1, $value['name']);
			}
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}

	public function getUCsRankingSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getUCsVaccineDropout($data, $selectQuery);
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();
		
		$i=0;
		$serieses['name'] = "UC Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center"; 
		if($coverageData){
			foreach($coverageData as $row){
				//$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				if($row->second == 0 || $row->second == ''){
					$serieses['data'][$i]['y'] = 0;
				}else{
					$value = round((((int)$row->second -(int)$row->first)*100)/(int)$row->second);
					$serieses['data'][$i]['y'] = ($value < 0)?0:$value;
				}	
				$dropout = $serieses['data'][$i]['y'];
				if($dropout >= 11)
					$serieses['data'][$i]['color'] = "#fa1e2e";//red color 
				else
					$serieses['data'][$i]['color'] = "#2cdc2a";//green color
				$i++;
			}
			$compliance = array();
			foreach ($serieses['data'] as $key => $value) {
					$compliance[$key] = $value['y'];
			}
			array_multisort($compliance, SORT_ASC, $serieses['data']);

			foreach ($serieses['data'] as $key => $value) {
					array_push($serieses1, $value['name']);
			}
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}
	
	public function getDistrictSeriesData($data){
		echo "Comming Soon";
	}
	
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	
	public function getQuerySelectPortion($data){
		$subPartOfQuery = $this -> subPartQuery($data);
		$vaccineId = $data['vaccineId'];
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name ,(select ";
		}else{
			$q = " districts.distcode as code,districts.district as name, (select ";
		}
		if($data['gender'] == "Male" && $vaccineId != "2"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . " as  first, (select sum(cri_r1_f7)+sum(cri_r3_f7)+sum(cri_r5_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r3_f7)+sum(cri_r5_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f16)+sum(cri_r3_f16)+sum(cri_r5_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r9_f7)+sum(cri_r11_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r9_f7)+sum(cri_r11_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f16)+sum(cri_r9_f16)+sum(cri_r11_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r15_f7)+sum(cri_r17_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r15_f7)+sum(cri_r17_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f16)+sum(cri_r15_f16)+sum(cri_r17_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r21_f7)+sum(cri_r23_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r21_f7)+sum(cri_r23_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f16)+sum(cri_r21_f16)+sum(cri_r23_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else{
				$q .= " sum(cri_r25_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}
		}else if($data['gender'] == "Female" && $vaccineId != "2"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f7)+sum(cri_r4_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f7)+sum(cri_r4_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f16)+sum(cri_r4_f16)+sum(cri_r6_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f7)+sum(cri_r10_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f7)+sum(cri_r10_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f16)+sum(cri_r10_f16)+sum(cri_r12_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f7)+sum(cri_r16_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f7)+sum(cri_r16_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f16)+sum(cri_r16_f16)+sum(cri_r18_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f7)+sum(cri_r22_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f7)+sum(cri_r22_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f16)+sum(cri_r22_f16)+sum(cri_r24_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else{
				$q .= " sum(cri_r26_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}
		}else{ // if male and female both data is required
			if($vaccineId == "2" && $data['vaccGivento']){
				if($data['vaccGivento'] == "Pregnant"){
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r1_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r1_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r3_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r3_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r5_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r5_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r7_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r7_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r9_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r9_f1) " . $subPartOfQuery . " as second ";
					}
				}
				else if($data['vaccGivento'] == "NonPregnant"){
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r2_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r2_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r4_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r4_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r6_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r6_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r8_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r8_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r10_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r10_f1) " . $subPartOfQuery . " as second ";
					}
				}
				else{
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r1_f$vaccineId)+sum(ttri_r2_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r1_f1)+sum(ttri_r2_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r3_f$vaccineId)+sum(ttri_r4_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r3_f1)+sum(ttri_r4_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r5_f$vaccineId)+sum(ttri_r6_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r5_f1)+sum(ttri_r6_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r7_f$vaccineId)+sum(ttri_r8_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r7_f1)+sum(ttri_r8_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r9_f$vaccineId)+sum(ttri_r10_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r9_f1)+sum(ttri_r10_f1) " . $subPartOfQuery . " as second ";
					}
				}
			}else{
				if($data['vaccineBy'] == "Fixed"){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r2_f7)+sum(cri_r3_f7)+sum(cri_r4_f7)+sum(cri_r5_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r2_f7)+sum(cri_r3_f7)+sum(cri_r4_f7)+sum(cri_r5_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f16)+sum(cri_r2_f16)+sum(cri_r3_f16)+sum(cri_r4_f16)+sum(cri_r5_f16)+sum(cri_r6_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "Outreach"){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r8_f7)+sum(cri_r9_f7)+sum(cri_r10_f7)+sum(cri_r11_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r8_f7)+sum(cri_r9_f7)+sum(cri_r10_f7)+sum(cri_r11_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f16)+sum(cri_r8_f16)+sum(cri_r9_f16)+sum(cri_r10_f16)+sum(cri_r11_f16)+sum(cri_r12_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "Mobile"){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r14_f7)+sum(cri_r15_f7)+sum(cri_r16_f7)+sum(cri_r17_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r14_f7)+sum(cri_r15_f7)+sum(cri_r16_f7)+sum(cri_r17_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f16)+sum(cri_r14_f16)+sum(cri_r15_f16)+sum(cri_r16_f16)+sum(cri_r17_f16)+sum(cri_r18_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "LHW"){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r20_f7)+sum(cri_r21_f7)+sum(cri_r22_f7)+sum(cri_r23_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r20_f7)+sum(cri_r21_f7)+sum(cri_r22_f7)+sum(cri_r23_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f16)+sum(cri_r20_f16)+sum(cri_r21_f16)+sum(cri_r22_f16)+sum(cri_r23_f16)+sum(cri_r24_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else{
					$q .= " sum(cri_r25_f$vaccineId)+sum(cri_r26_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7)+sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7)+sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f16)+sum(cri_r26_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}
			}
		}		
		return $q;
	}
	
	public function subPartQuery($data){
		if($data['reportType'] == 'monthly'){
			$q = " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'biyearly'){
			if($data['biyear']=='01' || $data['biyear']=='1')
				$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],'01') . "' and fmonth <= '" . $this->monthTo($data['year'],'02') . "'";
			else if($data['biyear']=='02' || $data['biyear']=='2')
				$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],'03') . "' and fmonth <= '" . $this->monthTo($data['year'],'04') . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q = " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode) ";
		}else{
			$q .= " and fac_mvrf_db.distcode=districts.distcode) ";
		}
		return $q;
	}

	public function getIndicatorData($data){
		$subPartOfQuery = $this -> subPartQuery($data);
		$vaccineId = $data['vaccineId']; 

		if($data['reportType'] == 'monthly'){
			$q = " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'biyearly'){
			if($data['biyear']=='01' || $data['biyear']=='1')
				$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],'01') . "' and fmonth <= '" . $this->monthTo($data['year'],'02') . "'";
			else if($data['biyear']=='02' || $data['biyear']=='2')
				$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['year'],'03') . "' and fmonth <= '" . $this->monthTo($data['year'],'04') . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q = " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.distcode='".$code."' ";
		}else{
			$q .= "";
		}

		$result1 = $this -> maps -> getDropoutIndicator($data,$q);
		foreach ($result1 as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$result[$key1] = $value1;
			}
		}
		return $result;
	}
	
	public function monthFrom($year,$quarter){
		switch ($quarter){
			case "01":
				return "{$year}-01";
			case "02":
				return "{$year}-04";
			case "03":
				return "{$year}-07";
			case "04":
				return "{$year}-10";
		}
	}
	
	public function monthTo($year,$quarter){
		switch ($quarter){
			case "01":
				return "{$year}-03";
			case "02":
				return "{$year}-06";
			case "03":
				return "{$year}-09";
			case "04":
				return "{$year}-12";
		}
	}
	
	public function colorAxis($map='dist'){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '10.99';
		$dataClasses['dataClasses'][0]["color"] = '#2cdc2a';
		$dataClasses['dataClasses'][0]["name"] = '0-10%';

		$dataClasses['dataClasses'][1]['from'] = '10.99';
		$dataClasses['dataClasses'][1]['to'] = '1000';
		$dataClasses['dataClasses'][1]['color'] = '#fa1e2e ';
		$dataClasses['dataClasses'][1]['name'] = '>10%';
		
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	public function getUC_detailData(){
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['uncode'] = $uncode = $this -> input -> post('uncode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		if($reportType == 'monthly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
		}else if($reportType == 'biyearly'){
			if($this -> input -> post('biyear')=='01' || $this -> input -> post('biyear')=='1')
				$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),'01') . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),'02') . "'";
			else if($this -> input -> post('biyear')=='02' || $this -> input -> post('biyear')=='2')
				$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),'03') . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),'04') . "'";
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
		}else{}
		if(isset($parametersData['vaccineId'])){}else{ $parametersData['vaccineId']=1;}//for now it is set stactic for bcg disease only-- zob
		$viewData = $parametersData;
		/* Summary View Data */
		if(isset($parametersData['month'])){ $parametersData['month']=$parametersData['month'];}else{ $parametersData['month']="01";}
		$summaryData = $this -> ucSummary($parametersData);//print_r($summaryData);exit;
		if($services)
		{
			$summaryData['services'] = $services;
		}else{
			$summaryData['services'] = "outreach";
		}
		$summaryData['monthly_yearly_target'] = $coverageData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
		$viewData['summary'] = $this -> load -> view('thematic_maps/parts_view/ucsummary', $summaryData, TRUE);
		/* Coverage Tab data */
		$coverageData = $this -> ucCoverage($parametersData);
		/* set data array from summary data array to be used in coverage tab */
		$coverageData['sessionPlannedHeld'] = $summaryData['sessionPlannedHeld'];
		$coverageData['vaccinationNumbers'] = $summaryData['vaccinationNumbers'];
		$coverageData['vaccineId'] = $summaryData['vaccineId'];
		$coverageData['monthlyTarget'] = $summaryData['monthlyTarget'];
		$coverageData['productsNameArray'] = $summaryData['productsNameArray'];
		$coverageData['productsArray'] = $summaryData['productsArray'];
		$viewData['coverage'] = $this -> load -> view('thematic_maps/parts_view/uccoverage', $coverageData, TRUE);
		/* Consumption View Data */
		$consumptionData = $this -> ucConsumption($parametersData);
		$consumptionData['openvialWastageRate'] = $summaryData['openvialWastageRate'];
		$consumptionData['closedvialWastageRate'] = $summaryData['closedvialWastageRate'];
		$viewData['consumption'] = $this -> load -> view('thematic_maps/parts_view/ucconsumption', $consumptionData, TRUE);
		$dropoutData = $this -> ucDropout($parametersData);
		$viewData['dropout'] = $this -> load -> view('thematic_maps/parts_view/ucdropout', $dropoutData, TRUE);
		$surveillanceData = $this -> ucSurveillance($parametersData);
		$viewData['surveillance'] = $this -> load -> view('thematic_maps/parts_view/ucsurveillance', $surveillanceData, TRUE);
		$attendenceData = $this -> ucAttendence($parametersData);
		$viewData['attendence'] = $this -> load -> view('thematic_maps/parts_view/ucattendence', $attendenceData, TRUE);
		$viewData['activeClass'] ="dropout";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	public function ucSummary($parametersData){
		$data['productsArray'] = $productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV',14=>'Rota-1',15=>'Rota-2',16=>'Measles-I',17=>'Fully Immunized',18=>'Measles-II');
		$data['vaccineId'] = $vaccineId = $parametersData['vaccineId'];
		$data['sessionPlannedHeld'] = sessionPlannedHeld($parametersData['rangeCondition'],$parametersData['uncode'],'',$parametersData['distcode']);
		$data['vaccinationNumbers'] = vaccinationInNumbers($parametersData['rangeCondition'],$parametersData['uncode'],NULL,$parametersData['vaccineId'],NULL,$parametersData['distcode']);//print_r($data['vaccinationNumbers']);
		$data['totalVaccinationNumbers'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'both',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersMale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'male',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersFemale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'female',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$code="";
		$type="";
		if((isset($parametersData['uncode']) && $parametersData['uncode']!=null)){
			$code=$parametersData['uncode'];
			$type="Union council : ".get_UC_Name($code);
			$type1=", ".get_UC_Name($code);
		}
		if((isset($parametersData['distcode']) && $parametersData['distcode']!=null)){
			$code=$parametersData['distcode'];
			$type="District : ".get_District_Name($code);
			$type1=", ".get_District_Name($code);
		}
		$data['distYear']=" For ".$type." , Year : ".$parametersData['year'];
		$data['distYear1'] = $type1.", Year-".$parametersData['year'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['year'],$parametersData['vaccineId']);				
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['year'],$parametersData['month'],$productsArray[$vaccineId]);
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);//print_r($data['monthlyVaccinationTrendAllDisease']);exit;
		$data['monthlyVaccinationTrendForfullyimmunized'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'17',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['monthlyVaccinationTrendForTT'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'TT1-TT2',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		//$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','case_investigation_db',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode'],"Msl");
		$data['weeklyOutBreakAFP'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'afp_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakNNT'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'nnt_investigation_form',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data; 
	}
	
	public function ucCoverage($parametersData){
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data;
	}
	
	public function ucConsumption($parametersData){
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		return $data;
	}
	
	public function ucDropout($parametersData){
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$data['rota1_rota2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'rota1-rota2');
		return $data;
	}
	
	public function ucSurveillance($parametersData){
		$data['weeklyZeroReportsTrend'] = weeklyTrendforZeroReports($parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakAFP'] = $this ->getChartData("afp_case_investigation",$parametersData,"AFP","#f3e83a");
		$data['weeklyOutBreakNNT'] = $this ->getChartData("nnt_investigation_form",$parametersData,"NT","#8B0000");
		$data['weeklyOutBreakMeasles'] = $this ->getChartData("case_investigation_db",$parametersData,"Msl");
		$data['weeklyOutBreakDiphtheria'] = $this ->getChartData("case_investigation_db",$parametersData,"Diph","#00FF00");
		return $data;
	}
	
	public function ucAttendence($parametersData){
		$data = "";
		return $data;
	}
	public function getChartData($table,$parametersData,$caseType,$color=Null){
		if($caseType == "AFP" || $caseType == "NT")
			$type = NULL;
		else
			$type = $caseType;
		$result = $this -> maps -> weeklyTrendforOut_breakReports('bubble',$table,$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode'],$type,"object");
		//$result = json_decode(json_encode($result)); use if result not in array object
		$arrData = $dataSeries= array();
		$i=0;
		foreach ($result as $value) {
			$arrData[$i]['label'] = $value->fweek;
			$arrData[$i]['value'] = $value->DiseasesCount;
			$arrData[$i]['link'] = "JavaScript:drilldownfun('{$caseType}','{$value->code}','{$value->year}','{$value->week}')";
			$arrData[$i]['color'] = "{$color}";
			$i++;
		}
		if(!empty($arrData))
			$return = json_encode($arrData,JSON_NUMERIC_CHECK);
		else
			$return = "";
		return $return;
	}
}
?>