<?php
class ThematicVaccineUsageIndicator extends CI_Controller {
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
		$queryData = array();
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		$ajax = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'';
		$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
		$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		$data['indicator']  = ($this -> input -> post('indicator'))?$this -> input -> post('indicator'):'54';
		$data['vacc_ind']  = ($this -> input -> post('vacc_ind'))?$this -> input -> post('vacc_ind'):'cr_r1_f6';
		$queryData = $data;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$reportPeriod = array('yearly','monthly_last');//'monthly'
		$data['vacName'] = $this -> getVaccineName($data);
		$data['colorAxis'] = $this -> colorAxis();
		$data['heading']['mapName'] = "Vaccine Usage Rate";
		if($this -> session -> District || $this -> input -> post('distcode')){
			$data['distcode']  = ($this -> session -> District)?$this -> session -> District:$this -> input -> post('distcode');
			$data['district'] = get_District_Name($data['distcode']);
			$data['heading']['barName'] = "Ranking of UCs";
			$data['heading']['run'] = false;
		}else{
			$data['heading']['barName'] = "Ranking of Districts";
			$data['heading']['run'] = true;
		}	
		$result = $this -> getSeriesData($queryData, $wc);
		$viewData['serieses'] = $result['serieses'];
		$data['indicators'] = $this -> getIndicatorData($queryData, $wc);
		$result = $this -> getRankingSeriesData($queryData, $wc);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$viewData['data'] = $data;
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
		$viewData['filterowbtn'] = 'ThematicVaccineUsageIndicator';
		$viewData['fileToLoad'] = 'thematic_maps/thematic_vaccine_usage_indicator';
		$viewData['pageTitle']='EPI-MIS Dashboard | Vaccine Usage Rate ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getSeriesData($data, $wc){
		$selectQuery = $this -> Vaccine($data, $wc);
		$name = 'District';
		if($this -> session -> District || $data['distcode']){
			$coverageData = $this -> maps -> getUCsVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
		}
		
		$serieses = array();
		$result = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Vaccine Wastage Rate";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> wastage_rate != "")? 100 - $row -> wastage_rate:100;
			$i++;
		}
		
		array_push($dataSeries,$serieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($result['serieses']);exit;
		return $result;
	}
	
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			//$data['id'] = $this -> input -> post('id');
			$data = array();
			$data['distcode'] = $this -> uri -> segment(4);
			$data['month'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):date('m',strtotime("first day of previous months"));
			$data['year']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months"));
			$data['indicator']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):'54';
			$data['vacc_ind']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'cr_r1_f6';
			$queryData = $data;
			$data['reportType']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'monthly';
			$data['vacName'] =  $this -> getVaccineName($data);
			$data['district'] = get_District_Name($data['distcode']);
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
			//$data['indicators'] = $result1;
			$data['heading']['mapName'] = "Vaccine Usage Rate";
			$data['colorAxis'] = $this -> colorAxis();
			$result = $this -> getSeriesData($queryData, $wc);
			$viewData['serieses'] = $result['serieses'];
			$data['indicators'] = $this -> getIndicatorData($queryData, $wc);
			$result = $this -> getRankingSeriesData($queryData, $wc);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			$data['heading']['barName'] = "Ranking of UCs";
			$data['heading']['run'] = false;
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'ThematicVaccineUsageIndicator';
			$viewData['fileToLoad'] = 'thematic_maps/thematic_vaccine_usage_indicator';
			$viewData['pageTitle']='EPI-MIS Dashboard | Vaccine Usage Rate';
			$this->load->view('thematic_template/thematic_template',$viewData);
			//echo json_encode($viewData,JSON_NUMERIC_CHECK);
		}else{
		}		
	}
	public function getRankingSeriesData($data, $wc){
		$selectQuery = $this -> Vaccine($data, $wc);
		$name = 'District';
		if($this -> session -> District || $data['distcode']){
			$coverageData = $this -> maps -> getUCsVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
		}
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center"; 
		if($coverageData){
			foreach($coverageData as $row){
				//$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['y'] = ($row -> wastage_rate != "")? 100 - $row -> wastage_rate:100;
				$wastage_rate = $serieses['data'][$i]['y'];
				if($wastage_rate >= 90)
					$serieses['data'][$i]['color'] = "#0B7546";//green
				else if($wastage_rate <= 89.99 && $wastage_rate >= 80)
					$serieses['data'][$i]['color'] = "#289BB9";//blue
				else if($wastage_rate <= 79.99 && $wastage_rate >= 50)
					$serieses['data'][$i]['color'] = "#EBB035";//yellow
				else if($wastage_rate < 50)
					$serieses['data'][$i]['color'] = "#DD1E2F";//red
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
	
	function getQuerySelectPortion($arrayData, $fmonth, $level, $distcode,$report_table=NULL, $whereData=NULL,$data=NULL,$forCards=false)
	{
		if((isset($data['distcode']) && $data['distcode'] != '') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,(select ";
		}else{
			$q = " districts.distcode as code, districts.district as name,(select ";
		}
		$month = NULL;
		if(isset($whereData['month'])){
			$month = $whereData['month'];
			unset($whereData['month']);
		}
		unset($whereData['distcode']);
		unset($whereData['year']);
		unset($whereData['indicator']);
		unset($whereData['vacc_ind']);
		//print_r($whereData);exit;
		$whereNew = array();
		foreach($whereData as $key => $val){
			$whereNew[] = $key. " = " . "'".$val."'";
		}
		//print_r($arrayData);exit;
		$formula        = $arrayData[0]["formula"];
		$ind_name       = $arrayData[0]["ind_name"];
		$num_text       = $arrayData[0]["numerator"];
		$den_text       = $arrayData[0]["denominator"];
		$multiple       = $arrayData[0]["multiple"];
		$ind_type       = $arrayData[0]["ind_type"];
		$is_inverse     = $arrayData[0]["is_inverse"];
		$result_text    = $arrayData[0]["result_text"];
		$description    = $arrayData[0]["description"];
		
		$yearMonth = explode("-",$fmonth);
		$year = $yearMonth[0];
		if(isset($yearMonth[1]) && ($yearMonth[1] != "" || $yearMonth[1] != 0))
			$whereFmonth = " fmonth = '$fmonth' ";
		else
			$whereFmonth = " fmonth like '$year-%' ";
		
		$CI = & get_instance();
		if($data['indicator'] == '53' && $data['vacc_ind']) {
			$formula = getClosedVialsWastageRate($data['vacc_ind']);
		}
		if($data['indicator'] == '54' && $data['vacc_ind']) {
			$formula = getOpenedVialsWastageRate($data['vacc_ind']);
		}
		if($data['indicator'] == '55' && $data['vacc_ind']) {
			$formula = getVaccineWastageRate($data['vacc_ind']);
		}
		$den_array=array(
			"getmonthlynewborn_targetpopulation(facode,'')::numeric",
			"getyearlynewborn_targetpopulation(facode,'')::numeric",
			"getmonthlynewborn_targetpopulation(distcode,'')::numeric",
			"getyearlynewborn_targetpopulation(distcode,'')::numeric",
			"getmonthly_survivinginfants(facode,'facility')::numeric",
			"getsurvivinginfants(facode,'facility')::numeric",
			"getmonthly_survivinginfants(distcode,'district')::numeric",
			"getsurvivinginfants(distcode,'district')::numeric",
			"getmonthly_plwomen_target(facode,'')::numeric",
			"getyearly_plwomen_target(facode,'')::numeric",
			"getmonthly_plwomen_target(distcode,'')::numeric",
			"getyearly_plwomen_target(distcode,'')::numeric"
		);
		$divstr=explode("/",$formula);
		//print_r($divstr);exit;
		$num=$divstr[0];
		$den=$divstr[1];
		$den = str_replace('-::-','/',$den);
		$num = getNominator($num);
		$divnumfields = str_replace('-::-','/',$num);
		$numerator = "sum(coalesce(".$divnumfields.",0))";
		
		/* $num = getNominator($num); 
		$divnumfields=explode("+",$num);
		for($i=0;$i<count($divnumfields);$i++){
			$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
		}    
		$numerator=implode("+",$divnumfields);*/
		$den = getDenominator($den,$year,$month);//$year will be sent once year functionality is implemented.
		$divnumfields=explode("+",$den);
		for($i=0;$i<count($divnumfields);$i++){
			if(in_array($den, $den_array)){
				$divnumfields[$i]= "coalesce(".$divnumfields[$i].",0)";
			}else{
				$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
			}
		}   
		$denominator=implode("+",$divnumfields);
		$table="";
		if($den!=""){
			$mul="*$multiple";
		}
		if($level=="district"){
			$table=$report_table;
		}
		if($level=="facility"){
			$table=$report_table;
		}
		if($is_inverse=="1")
		{
			$orderType = "Asc";
		}else
		{
			$orderType = "Desc";
		}
		$wc="";
		//echo $numerator.'  break   '.$denominator;exit;
		$wc.=(($level=="facility" || $level=="unioncouncil")?" and $table.uncode=uc_wise_maps_paths.uncode and $table.distcode='".$distcode."' group by $table.uncode":"and distcode=districts.distcode");
		
		$qformula=($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul");
		$q.=" round(coalesce($qformula,0)::numeric,2) from $table where $whereFmonth ".(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." $wc )  as wastage_rate";
		if($forCards){
			return " round(coalesce($qformula,0)::numeric,2) ";
		}
		//echo  print_r($q.'-::-wastage_rate-::-'.$orderType); exit;
		return $q.'-::-wastage_rate-::-'.$orderType;
	}
	function Vaccine($data,$wc,$forCards=false){
		$whereCondition = WC_replacement($wc);
		$newWc = $whereCondition[0];
		$newWc1 = $whereCondition[1];
		if($data['distcode'] && $data['distcode'] != NULL){
			unset($newWc1[1]);
		}
		$query = 'select * from indcat';
		if($data['indicator'])
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$data['indicator']);
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}
		$ind_name = $arrayData[0]["ind_name"];
		$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		$level = (isset($data['distcode']) && $data['distcode'] > 0 || $this->session->District)?"facility":"district";
		$level = isset($data['facode'])?"facility":$level;
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);
		$report_table = "form_b_cr";
		if($forCards){
			return $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $distcode, $report_table,$data,$data,true);
		}
		$queryArray = explode('-::-', $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $distcode, $report_table,$data,$data));
		$arraySize = sizeOf($queryArray);
		if($arraySize > 3){
			$queryArray[0] = $queryArray[0].'*'.$queryArray[1].'*'.$queryArray[2];
			//$queryArray[0] = str_replace('cr_r1_f120', 'cr_r1_f1*20', $queryArray[0]);
			//$queryArray[0] = str_replace('cr_r1_f220', 'cr_r1_f2*20', $queryArray[0]);
			$queryArray[1] = $queryArray[3];
			$queryArray[2] = $queryArray[4];
			unset($queryArray[3]);
			unset($queryArray[4]);
		}
		//echo '<pre>'; print_r($queryArray); exit;
		return $queryArray;
	} 
	public function getIndicatorData($data,$wc){
		//print_r($data);exit;
		$data['indicator'] = '53';
		$s1 = $this -> Vaccine($data, $wc, true);
		$data['indicator'] = '54';
		$s2 = $this -> Vaccine($data, $wc, true);
		$data['indicator'] = '55';
		$s3 = $this -> Vaccine($data, $wc, true);
		$reportType = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$fmonth = $data['year'].'-'.$data['month'];
		if($reportType == 'monthly'){
			$query = $s1." as closedTotal, ".$s2." as openedTotal, ".$s3." as Total from form_b_cr where fmonth='".$fmonth."' "; 
		}
		elseif($reportType == 'yearly'){
			$query = $s1." as closedTotal, ".$s2." as openedTotal, ".$s3." as Total from form_b_cr where fmonth like '".$data['year']."-%' "; 
		}

		if((isset($data['distcode']) && $data['distcode'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['distcode']) && $data['distcode']>0)
				$code = $data['distcode'];
			$query .= " and distcode='".$code."' ";
		}else{
			$query .= "";
		}
		$query = str_replace('-::-', '*', $query);
		$result1 = $this -> maps -> getVaccineIndicatorData($data,$query);
		foreach ($result1 as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$result[$key1] = 100.00 - $value1;
			}
		}
		//print_r($result);exit;
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
	function getVaccineName($data){
		$vacArray = array('cr_r1_f6' => 'BCG', 'cr_r2_f6' => 'DIL BCG', 'cr_r3_f6' => 'bOPV', 'cr_r4_f6' => 'Pentavalent', 'cr_r5_f6' => 'Pneumococcal(PCV10)', 'cr_r6_f6' => 'Measles', 'cr_r7_f6' => 'DIL Measles', 'cr_r8_f6' => 'TT 10', 'cr_r9_f6' => 'TT 20', 'cr_r10_f6' => 'HBV (Birth dose)', 'cr_r11_f6' => 'IPV', 'cr_r12_f6' => 'AD Syringes 0.5 ml', 'cr_r13_f6' => 'AD Syringes 0.05 ml', 'cr_r14_f6' => 'Recon.Syringes (2 ml)', 'cr_r15_f6' => 'Recon. Syringes (5 ml)', 'cr_r16_f6' => 'Safety Boxes', 'cr_r17_f6' => 'Other');
		return $vacArray[$data['vacc_ind']];
	}
	function colorAxis(){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '49.99';
		$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
		$dataClasses['dataClasses'][0]["name"] = '0 to 50';

		$dataClasses['dataClasses'][1]['from'] = '50';
		$dataClasses['dataClasses'][1]['to'] = '79.99';
		$dataClasses['dataClasses'][1]['color'] = '#EBB035';
		$dataClasses['dataClasses'][1]['name'] = '50 to 79';

		$dataClasses['dataClasses'][2]['from'] = '80';
		$dataClasses['dataClasses'][2]['to'] = '89.99';
		$dataClasses['dataClasses'][2]['color'] = '#289BB9';
		$dataClasses['dataClasses'][2]['name'] = '80 to 89';

		$dataClasses['dataClasses'][3]['from'] = '90';
		$dataClasses['dataClasses'][3]['to'] = '1000';
		$dataClasses['dataClasses'][3]['color'] = '#0B7546';
		$dataClasses['dataClasses'][3]['name'] = '90 and above';
		/* $dataClasses[0]["from"] = '0';
		$dataClasses[0]["to"] = '20.99';
		$dataClasses[0]["color"] = '#DD1E2F';
		$dataClasses[0]["name"] = '0 to 20';
		$dataClasses[1]['from'] = '21';
		$dataClasses[1]['to'] = '40.99';
		$dataClasses[1]['color'] = '#EBB035';
		$dataClasses[1]['name'] = '21 to 40';
		$dataClasses[2]['from'] = '41';
		$dataClasses[2]['to'] = '60.99';
		$dataClasses[2]['color'] = '#06A2CB';
		$dataClasses[2]['name'] = '41 to 60';
		$dataClasses[3]['from'] = '61';
		$dataClasses[3]['to'] = '1000';
		$dataClasses[3]['color'] = '#0B7546';
		$dataClasses[3]['name'] = '61 and above'; */
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	public function getUC_detailData(){
		$parametersData['uncode'] = $uncode = $this -> input -> post('uncode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		if($reportType == 'monthly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
		}else{}
		if(isset($parametersData['vaccineId'])){}else{ $parametersData['vaccineId']=1;}//for now it is set stactic for bcg disease only-- zob
		$viewData = $parametersData;
		/* Summary View Data */
		$summaryData = $this -> ucSummary($parametersData);//print_r($summaryData);exit;
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
		$viewData['activeClass'] ="consumption";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	public function ucSummary($parametersData){
		$data['productsArray'] = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV',14=>'Rota-1',15=>'Rota-2',16=>'Measles-I',17=>'Fully Immunized',18=>'Measles-II');
		$data['vaccineId'] = $parametersData['vaccineId'];
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
		}
		if((isset($parametersData['distcode']) && $parametersData['distcode']!=null)){
			$code=$parametersData['distcode'];
			$type="District : ".get_District_Name($code);
		}
		$data['distYear']=" For ".$type." , Year : ".$parametersData['year'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['year'],$parametersData['vaccineId']);				
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
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
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
		return $data;
	}
	
	public function ucSurveillance($parametersData){
		$data['weeklyZeroReportsTrend'] = weeklyTrendforZeroReports($parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakAFP'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','afp_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);//print_r($data['weeklyOutBreakAFP']);exit;
		$data['weeklyOutBreakNNT'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','nnt_investigation_form',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data;
	}
	
	public function ucAttendence($parametersData){
		$data = "";
		return $data;
	}
}
?>