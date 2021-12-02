<?php
class ThematicCountEPID extends CI_Controller {

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
				'provincename' => 'KPK',
				'Province' => '3',
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
		if($this -> input -> get('code')){
			$ajax = false;
			$data['year']  = $year =($this -> uri -> segment(5))?$this -> uri -> segment(5):date('Y');
			//$data['week']  = $week = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'all';
			$data['from_week']  = $from_week = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'all';
			$data['to_week']  = $to_week = ($this -> uri -> segment(7))?$this -> uri -> segment(7):'all';
			$data['disease']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'all';
			//$data['gender']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Both';
		}else{
			$ajax = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
			$data['disease'] = ($this -> input -> post('disease'))?$this -> input -> post('disease'):'Msl';
			//$data['gender']  = ($this -> input -> post('gender'))?$this -> input -> post('gender'):'Both';
			$data['year']  = $year = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
			//$data['week']  = $week = ($this -> input -> post('week'))?$this -> input -> post('week'):'all';
			$data['from_week']  = $from_week = ($this -> input -> post('from_week'))?$this -> input -> post('from_week'):'all';
			$data['to_week']  = $to_week = ($this -> input -> post('to_week'))?$this -> input -> post('to_week'):'all';
			$data['investigationResult'] = $investigationResult = ($this -> input -> post('investigationResult'))?$this -> input -> post('investigationResult'):NULL;
		}
		if($this -> input -> post('gender') == '0' || $this -> uri -> segment(9) == '0'){
			$data['gender'] = '0';
		}
		elseif($this -> input -> post('gender') == '1' || $this -> uri -> segment(9) == '1'){
			$data['gender'] = '1';
		}
		else{
			$data['gender'] = 'Both';
		}
		$epimonth = date('m');
		if($epimonth > 01){
			$query="Select distinct year from epi_weeks where year <= '".date("Y")."' order by year asc";
		}
		else{
			$query="Select distinct year from epi_weeks where year < '".date("Y")."' order by year desc";
		}
		$result = $this -> db ->query($query);
		$datArray['epiyears_select'] = $result->result_array();
		$data['yearFilter'] = $this -> maps -> createListingFilter($datArray,$year);
		$investigationResultText = "";
		if(isset($data['investigationResult']) AND $data['investigationResult'] != ''){
			$investigationResultText = " for {$data['investigationResult']}";
		}
		if ($from_week == "all" && $to_week == "all")
			{
				$con = "For All Weeks"; 
			}
			else{
				$con = "From Week {$from_week} To Week {$to_week} " ;
			}
		//$data['heading']['mapName'] = "Suspected ".ucfirst($data['disease'])." Cases, Year-".$year." of Week ".$week;
		$data['colorAxis'] = $this -> colorAxis();
		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode=($this -> session -> District)?$this -> session -> District:$this -> input -> post('id');
			$data['district'] = $districtName = get_District_Name($distcode);
			$result = $this -> UcWiseMapData($data);
			$viewData['serieses'] = $result['serieses'];
			$result = $this -> getUCsRankingSeriesData($data);
			$data['indicators'] = $this -> getIndicatorData($data);
			
			$data['heading']['mapName'] = $data['heading']['barName'] = "Suspected ".ucfirst($data['disease'])." Cases, {$districtName} Year-{$year} {$con} {$investigationResultText}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
		}else{
			$result = $this -> getProvincialSeriesData($data);
			$viewData['serieses'] = $result['serieses'];
			$data['indicators'] = $this -> getIndicatorData($data);
			$result = $this -> getDistrictsRankingSeriesData($data);
			$data['heading']['mapName'] = $data['heading']['barName'] = "Suspected ".ucfirst($data['disease'])." Cases, Year-{$year} {$con} {$investigationResultText}";
			$data['heading']['run'] = true;
		}
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['filterowbtn'] = 'ThematicCountEPID';		
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];//print_r($viewData['serieses_ranking']);exit;
		$viewData['data'] = $data;
		//print_r($viewData);exit;
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
			$arr = array('map' => $map, 'bar' => $bar);
			echo json_encode($arr);
			exit;
		}
		$viewData['fileToLoad'] = 'thematic_maps/thematic_count_epid';
		$viewData['pageTitle']='EPI-MIS Dashboard | EPID Count ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}

	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			$data = array();
			$data['id'] = $this -> uri -> segment(4);
			$data['district'] = $districtName =get_District_Name($data['id']);
			$data['year']  = $year =($this -> uri -> segment(5))?$this -> uri -> segment(5):date('Y');
			//$data['week']  = $week = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'all';
			$data['from_week']  = $from_week = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'all';
			$data['to_week']  = $to_week = ($this -> uri -> segment(7))?$this -> uri -> segment(7):'all';
			$data['disease']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'all';
			$data['gender']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Both';
		}
		if ($from_week == "all" && $to_week == "all")
			{
				$con = "For All Weeks"; 
			}
			else{
				$con = "From Week {$from_week} To Week {$to_week} " ;
			}
		//print_r($data);exit;
		$data['colorAxis'] = $this -> colorAxis();
		$data['heading']['mapName'] = $data['heading']['barName'] = "Suspected ".ucfirst($data['disease'])." Cases, {$districtName} Year-{$year} {$con}";
		if($this -> session -> District || $this -> uri -> segment(4)){
			$epimonth = date('m');
			if($epimonth > 01){
				$query="Select distinct year from epi_weeks where year <= '".date("Y")."' order by year asc";
			}
			else{
				$query="Select distinct year from epi_weeks where year < '".date("Y")."' order by year desc";
			}			
			$result = $this -> db ->query($query);
			$datArray['epiyears_select'] = $result->result_array();
			$data['yearFilter'] = $this -> maps -> createListingFilter($datArray);
			$result = $this -> UcWiseMapData($data);
			$viewData['serieses'] = $result['serieses'];
			//$viewData['series1'] = $this->getUCsRankingSeriesData($data);
			$data['indicators'] = $this -> getIndicatorData($data);
			$result = $this -> getUCsRankingSeriesData($data);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			$data['heading']['subtittle'] = $this -> session -> provincename;
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'ThematicCountEPID';	
			$viewData['fileToLoad'] = 'thematic_maps/thematic_count_epid';
			$viewData['pageTitle']='EPI-MIS Dashboard | EPID Count ';
			$this->load->view('thematic_template/thematic_template',$viewData);
			//echo json_encode($viewData,JSON_NUMERIC_CHECK);
		}else{
		}		
	}
	
	public function getProvincialSeriesData($data){ 
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getEPIDCoverge($data, $selectQuery);
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
				$serieses['data'][$i]['value'] = $row -> total;
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
		$coverageData = $this -> maps -> getUCsEPIDCoverge($data, $selectQuery);
		$serieses = array();
		$result = array();
		$dataSeries = array();
		$data['colorAxis'] = $this -> colorAxis();
		$i=0;
		$serieses['name'] = "UC Wise EPID Count";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		if($coverageData){
			foreach($coverageData as $row){
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['path'] = $row -> path;
				$serieses['data'][$i]['value'] = $row -> total;
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
		$coverageData = $this -> maps -> getEPIDCoverge($data, $selectQuery);
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
				$serieses['data'][$i]['y'] = $row -> total;	
				$dropout = $serieses['data'][$i]['y'];
				if($dropout > 60)
					$serieses['data'][$i]['color'] = "#DD1E2F";
				else if($dropout <= 59.9 && $dropout > 40)
					$serieses['data'][$i]['color'] = "#EBB035";
				else if($dropout <= 40 && $dropout > 20)
					$serieses['data'][$i]['color'] = "#06A2CB";
				else if($dropout <= 20)
					$serieses['data'][$i]['color'] = "#0B7546";
				$i++;
			}
		
			$compliance = array();
			foreach ($serieses['data'] as $key => $value) {
					$compliance[$key] = $value['y'];
			}
			array_multisort($compliance, SORT_DESC, $serieses['data']);

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
		$coverageData = $this -> maps -> getUCsEPIDCoverge($data, $selectQuery);
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
				$serieses['data'][$i]['y'] = $row -> total;
				$dropout = $serieses['data'][$i]['y'];
				if($dropout >= 61)
					$serieses['data'][$i]['color'] = "#DD1E2F";
				else if($dropout <= 60.99 && $dropout > 41)
					$serieses['data'][$i]['color'] = "#EBB035";
				else if($dropout <= 40.99 && $dropout >= 21)
					$serieses['data'][$i]['color'] = "#06A2CB";
				else if($dropout <= 20.99)
					$serieses['data'][$i]['color'] = "#0B7546";
				$i++;
			}
			$compliance = array();
			foreach ($serieses['data'] as $key => $value) {
					$compliance[$key] = $value['y'];
			}
			array_multisort($compliance, SORT_DESC, $serieses['data']);

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
	
	public function getQuerySelectPortion($data, $indicators=false){
		//print_r($data); exit; 
		$disease = $data['disease'];
		$table = 'case_investigation_db';
		$case_type = $disease;
		//print_r($data); exit;
		$case_type = ($case_type != '0')?" AND case_type = '{$case_type}' ":"";
		$gender = ($table == 'weekly_vpd')?'':'patient_';
		//$fweek = $data['year'].'-'.sprintf('%02d',$data['week']);
		$from_week = $data['year'].'-'.sprintf('%02d',$data['from_week']);
		$to_week = $data['year'].'-'.sprintf('%02d',$data['to_week']);
		switch ($data['gender']) {
			case '0':
				$genderType = "{$gender}gender = '0'";
				$genderType2 = "gender = '0'";
				break;
			case '1':
				$genderType = "{$gender}gender = '1'";
				$genderType2 = "gender = '1'";
				break;
			default:
				$genderType = "({$gender}gender = '0' OR {$gender}gender = '1')";
				$genderType2 = "(gender = '0' OR gender = '1')";
				break;
		}
		$dataArray['disease'] = $disease;
		$dataArray['table'] = $table;
		$dataArray['case_type'] = $case_type;
		$dataArray['gender'] = $gender;
		//$dataArray['fweek'] = $fweek;
		$dataArray['from_week'] = $from_week;
		$dataArray['to_week'] = $to_week;

		$query = " districts.distcode,districtname(districts.distcode),";
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$query = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name , ";
			$part = " AND uncode=uc_wise_maps_paths.uncode";
		}else{
			$query = " districts.distcode as code,districts.district as name, ";
			$part = " AND distcode=districts.distcode";
		}
		//print_r($data['year']); exit;
		/* if($data['from_week']=="all" && $data['to_week']=="all"){
			$fweek =" and fweek like '{$data['year']}-%'";
		} */
	
		if($data['from_week'] != "all" && $data['to_week'] !="all")
		{
			$fweek =" and fweek >= '{$from_week}' AND fweek <= '{$to_week}'";
		}
		else if ($data['from_week']!="all"  && $data['to_week']=="all"){
			
			$fweek =" and fweek >= '{$from_week}' ";
		}else if ($data['from_week']=="all"  && $data['to_week'] !="all"){
			
			$fweek =" and fweek >= '{$to_week}' ";
		}
		else {
			$fweek =" and fweek like '{$data['year']}-%'";
		}
		
		
		$investigationResult = "";
		if(isset($data['investigationResult']) AND $data['investigationResult'] != ''){
			if($data['investigationResult']=="Awaiting Result")
				$investigationResult = " and specimen_result IS NULL ";
			else
				$investigationResult = " and specimen_result = '{$data['investigationResult']}' ";
		}
		//print_r($investigationResult);exit;
		if($disease != 'all'){
			$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$genderType} {$case_type} {$fweek} {$investigationResult} {$part}) as \"total\" ";
		}else{
			$query .= " ((SELECT COUNT(*) FROM case_investigation_db WHERE {$genderType}  {$fweek} {$investigationResult} {$part})+(SELECT COUNT(*) FROM afp_case_investigation WHERE {$genderType} {$fweek} {$investigationResult} {$part})+(SELECT COUNT(*) FROM nnt_investigation_form WHERE {$genderType} {$fweek} {$investigationResult} {$part})) as \"total\" ";
		}
		//	echo $query; exit;
		if($indicators){
			return $dataArray;
		}
		else{
			return $query;
		}
	}
	public function getIndicatorData($data){
		$dataArray = $this -> getQuerySelectPortion($data, true);
		$code = isset($data['id'])? "AND distcode='".$data['id']."'" : '';
		$disease = $dataArray['disease'];//print_r($data);exit;
		$table = $dataArray['table'];
		$case_type = $dataArray['case_type'];
		$gender = $dataArray['gender'];
		//$fweek = $dataArray['fweek'];
		$from_week = $dataArray['from_week'];
		$to_week = $dataArray['to_week'];
		$query = "SELECT ";
		/* if($data['week']=="all"){
			$fweek =" and fweek like '{$data['year']}-%'";
		}else{
			$fweek =" and fweek >= '{$fweek}' AND fweek <= '{$fweek}'";
		} */
		if($data['from_week'] != "all" && $data['to_week'] !="all")
		{
			$fweek =" and fweek >= '{$from_week}' AND fweek <= '{$to_week}'";
		}
		else if ($data['from_week']!="all"  && $data['to_week']=="all"){
			
			$fweek =" and fweek >= '{$from_week}' ";
		}else if ($data['from_week']=="all"  && $data['to_week'] !="all"){
			
			$fweek =" and fweek >= '{$to_week}' ";
		}
		else {
			$fweek =" and fweek like '{$data['year']}-%'";
		}
		$investigationResult=" ";
		if(isset($data['investigationResult']) AND $data['investigationResult'] != ''){
			if($data['investigationResult']=="Awaiting Result")
				$investigationResult = " and specimen_result IS NULL ";
			else
				$investigationResult = " and specimen_result = '{$data['investigationResult']}' ";
		}
		$subQuery = "{$case_type} {$fweek}";
		$subQuery2 = "case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') {$fweek} {$code}";
		if($disease != 'all'){
			$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '1' {$subQuery} {$investigationResult} {$code}) as \"mtotal\",
						(SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '0' {$subQuery} {$investigationResult} {$code}) as \"ftotal\", 
						(SELECT COUNT(*) FROM {$table} WHERE ({$gender}gender = '1' OR {$gender}gender = '0') {$code} {$subQuery} {$investigationResult}) as \"alltotal\" ";
		}else{
			$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '1' AND ( {$subQuery2} )+(SELECT COUNT(*) FROM afp_case_investigation WHERE {$gender}gender = '1' {$fweek} {$code})+(SELECT COUNT(*) FROM measle_case_investigation WHERE {$gender}gender = '1' {$fweek} {$investigationResult} {$code})) as \"mtotal\",
		((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '0' AND ( {$subQuery2} )+(SELECT COUNT(*) FROM afp_case_investigation WHERE {$gender}gender = '0' {$fweek} {$code})+(SELECT COUNT(*) FROM measle_case_investigation WHERE {$gender}gender = '0' {$fweek} {$investigationResult} {$code})) as \"ftotal\",
				((SELECT COUNT(*) FROM weekly_vpd WHERE (gender = '1' OR gender = '0') AND ( {$subQuery2} )+(SELECT COUNT(*) FROM afp_case_investigation WHERE ({$gender}gender = '1' OR {$gender}gender = '0') {$fweek} {$code})+(SELECT COUNT(*) FROM measle_case_investigation WHERE ({$gender}gender = '1' OR {$gender}gender = '0') {$fweek} {$investigationResult} {$code})) as \"alltotal\" ";
		}
		$query .= "FROM districts LIMIT 1";
		$result1 = $this -> maps -> getEPIDIndicator($data,$query);
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
	function colorAxis(){
		$dataClasses[0]['from'] = '0';
		$dataClasses[0]['to'] = '20.99';
		$dataClasses[0]['color'] = '#0B7546';
		$dataClasses[0]['name'] = '0 to 20';

		$dataClasses[1]['from'] = '21';
		$dataClasses[1]['to'] = '40.99';
		$dataClasses[1]['color'] = '#06A2CB';
		$dataClasses[1]['name'] = '21 to 40';

		$dataClasses[2]['from'] = '41';
		$dataClasses[2]['to'] = '60.99';
		$dataClasses[2]['color'] = '#EBB035';
		$dataClasses[2]['name'] = '41 to 60';

		$dataClasses[3]['from'] = '61';
		$dataClasses[3]['to'] = '1000';
		$dataClasses[3]['color'] = '#DD1E2F';
		$dataClasses[3]['name'] = '61 and above';
		$data['colorAxis'] = json_encode($dataClasses);
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
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
		}else{}
		if(isset($parametersData['vaccineId'])){}else{ $parametersData['vaccineId']=1;}//for now it is set stactic for bcg disease only-- zob
		$viewData = $parametersData;
		if(isset($parametersData['month'])){ $parametersData['month']=$parametersData['month'];}else{ $parametersData['month']="01";}
		/* Summary View Data */
		$summaryData = $this -> ucSummary($parametersData);//print_r($summaryData);exit;
		if($services)
		{
			$summaryData['services'] = $services;
		}else{
			$summaryData['services'] = "outreach";
		}
		$summaryData['monthly_yearly_target'] = $coverageData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
		$summaryData['yearlyTarget'] = $summaryData['monthlyTotTarget'];//print_r($summaryData['yearlyTarget']);exit;
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
		$viewData['activeClass'] ="summary";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	public function ucSummary($parametersData){
		$data['productsArray'] = $productsArray =  array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv1',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2',19=>'dtp',20=>'tcv',21=>'ipv2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV-1',14=>'Rota-1',15=>'Rota-2',16=>'MR-I',17=>'Fully Immunized',18=>'MR-II',19=>'DTP','20'=>'TCV',21=>'IPV-2');
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
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1');
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2');
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
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1');
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2');
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
	public function getAllSpecimenResultsOptions(){
		$diseaseId = $this -> input -> post('diseaseId');
		echo getAllSpecimenResults($diseaseId);
	}
}
?>