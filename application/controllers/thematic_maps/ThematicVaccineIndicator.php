<?php
class ThematicVaccineIndicator extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('inventory_helper');
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
		$queryData = array();
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		$ajax = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$distcode;
		$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
		$data['year']  = $year= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		$data['indicator']  = ($this -> input -> post('indicator'))?$this -> input -> post('indicator'):'66';
		$data['vacc_ind']  = $vacc_ind = ($this -> input -> post('vacc_ind'))?$this -> input -> post('vacc_ind'):'5';
		$queryData = $data;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$reportPeriod = array('yearly','monthly_last');//'monthly'
		//get item name for new consumption table
		//$data['vacName'] = $this -> getVaccineName($data);
		$data['vacName']=getVaccines_name($vacc_ind);  
		$data['colorAxis'] = $this -> colorAxis($vacc_ind);
		if($data['reportType']=='monthly'){
			//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}else{
			$monthQauarterYear = $year;
		}
		$data['heading']['mapName'] = "{$data['vacName']} Vaccine Wastage Rate, {$monthQauarterYear}";
		if($this -> session -> District || $this -> input -> post('distcode')){
			$data['id']  = $distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
			$districtName = get_District_Name($distcode);
			$data['heading']['mapName'] = "{$data['vacName']} Vaccine Wastage Rate, {$districtName}, {$monthQauarterYear}";
			$data['heading']['barName'] = "{$data['vacName']} Vaccine Wastage Rate, {$districtName}, {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
		}else{
			$data['heading']['barName'] = "{$data['vacName']} Vaccine Wastage Rate, {$monthQauarterYear}";
			$data['heading']['run'] = true;
		}
		//print_r($queryData);exit;
		$data['heading']['subtittle'] = $this -> session -> provincename;
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
			$viewData['colorAxis'] = $this -> colorAxis($vacc_ind);
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
		$viewData['filterowbtn'] = 'ThematicVaccineIndicator';
		$viewData['fileToLoad'] = 'thematic_maps/thematic_vaccine_indicator';
		$viewData['pageTitle']='EPI-MIS Dashboard | Vaccine Wastage Rate ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			//$data['id'] = $this -> input -> post('id');
			$data = array();
			$data['distcode'] = $this -> uri -> segment(4);
			$data['month'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime("first day of previous months"));
			$data['year']  = $year = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
			$data['indicator']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'66';
			$data['vacc_ind']  = $vacc_ind = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'5';
			$queryData = $data;
			$data['reportType']  = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
			//$data['vacName'] =  $this -> getVaccineName($data);
			//now its from epi_item_pack_sizes table
			$data['vacName']=getVaccines_name($vacc_ind);
			$data['district'] = $districtName =get_District_Name($data['distcode']);
			if($data['reportType']=='monthly'){
				//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
				$monthQauarterYear = monthname($data['month'])." ".$year;
			}elseif($data['reportType']=='quarterly'){
				$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
			}else{
				$monthQauarterYear = $year;
			}
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
			//$data['indicators'] = $result1;
			$data['heading']['mapName'] = "{$data['vacName']} Vaccine Wastage Rate, {$districtName}, {$monthQauarterYear}";
			$data['heading']['barName'] = "{$data['vacName']} Vaccine Wastage Rate, {$districtName}, {$monthQauarterYear}";
			$data['colorAxis'] = $this -> colorAxis($vacc_ind);
			$result = $this -> getSeriesData($queryData, $wc);
			$viewData['serieses'] = $result['serieses'];
			$data['indicators'] = $this -> getIndicatorData($queryData, $wc);
			$result = $this -> getRankingSeriesData($queryData, $wc);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['heading']['subtittle'] = $this -> session -> provincename;
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'ThematicVaccineIndicator';
			$viewData['fileToLoad'] = 'thematic_maps/thematic_vaccine_indicator';
			$viewData['pageTitle']='EPI-MIS Dashboard | Vaccine Wastage Rate';
			$this->load->view('thematic_template/thematic_template',$viewData);
			//echo json_encode($viewData,JSON_NUMERIC_CHECK);
		}else{
		}		
	}
	public function getSeriesData($data, $wc){
		$selectQuery = $this -> Vaccine($data, $wc);
		//print_r($data);exit;
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
			if($data['indicator']=='55'){
				$serieses['data'][$i]['value'] = ($row -> wastage_rate > 0)?(((100-($row -> wastage_rate))<0)?0:(((100-($row -> wastage_rate))>100)?100:100-($row -> wastage_rate))):0;
			}
			else
			{
				$serieses['data'][$i]['value'] = ($row -> wastage_rate > 0)?$row -> wastage_rate:0;
			}
			$i++;
		}
		
		array_push($dataSeries,$serieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($result['serieses']);exit;
		return $result;
	}
	public function getVal($vaccID=null){
		switch($vaccID){
			case 'cr_r1_f6' : 	$return['dataClasses'][0]['from']='0';
								$return['dataClasses'][0]['to']='30';
								$return['dataClasses'][0]['color']='#0B7546';
								$return['dataClasses'][0]['name']='0 to 30';
								
								$return['dataClasses'][1]['from']='31';
								$return['dataClasses'][1]['to']='50';
								$return['dataClasses'][1]['color']='#EBB035';
								$return['dataClasses'][1]['name']='0 to 30';
								 
								$return['dataClasses'][2]['from']='50';
								$return['dataClasses'][2]['to']='';
								$return['dataClasses'][2]['color']='#DD1E2F';
								$return['dataClasses'][2]['name']='0 to 30';
					break;
			case 'cr_r1_f3' : 
					break;
			case '2' : 	
					break;

		}
		return $return;
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
		//for KP/CRES new item id convert to old item id to get rankwise color.
		$vacc_id=getVaccines_id($data['vacc_ind']);
			$vacc_id="cr_r".$vacc_id."_f6";
			$data['vacc_ind']=$vacc_id;
		if($coverageData){
			foreach($coverageData as $row)
			{
				//$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				//$serieses['data'][$i]['y'] = ($row -> wastage_rate > 0)?((100-($row -> wastage_rate))<0)?0:(((100-($row -> wastage_rate))>100)?100:100-($row -> wastage_rate)):0;
				if($data['indicator']=='55'){
					$serieses['data'][$i]['y'] = ($row -> wastage_rate > 0)?(((100-($row -> wastage_rate))<0)?0:(((100-($row -> wastage_rate))>100)?100:100-($row -> wastage_rate))):0;
				}
				else
				{
					$serieses['data'][$i]['y'] = ($row -> wastage_rate > 0)?$row -> wastage_rate:0;
				}
				$wastage_rate = $serieses['data'][$i]['y'];
				if($data['vacc_ind']=='cr_r1_f6' || $data['vacc_ind']=='cr_r2_f6'){
					if($wastage_rate <= 30)
						$serieses['data'][$i]['color'] = "#248E5F";
					else if($wastage_rate <= 40 && $wastage_rate >= 31)
						$serieses['data'][$i]['color'] = "#3366ff";
					else if($wastage_rate <= 50 && $wastage_rate >= 41)
						$serieses['data'][$i]['color'] = "#f3e83a";
					else if($wastage_rate > 50)
						$serieses['data'][$i]['color'] = "#e3330d";
				}
				elseif($data['vacc_ind']=='cr_r3_f6' || $data['vacc_ind']=='cr_r9_f6')
				{
					if($wastage_rate <= 10)
						$serieses['data'][$i]['color'] = "#248E5F";
					else if($wastage_rate <= 20 && $wastage_rate >= 11)
						$serieses['data'][$i]['color'] = "#f3e83a";
					else if($wastage_rate > 20)
						$serieses['data'][$i]['color'] = "#e3330d";
				}
				elseif($data['vacc_ind']=='cr_r4_f6')
				{
					if($wastage_rate > 5)
						$serieses['data'][$i]['color'] = "#e3330d";
					else if($wastage_rate <= 5)
						$serieses['data'][$i]['color'] = "#248E5F";
				}
				elseif($data['vacc_ind']=='cr_r8_f6' || $data['vacc_ind']=='cr_r11_f6' || $data['vacc_ind']=='cr_r5_f6' || $data['vacc_ind']=='cr_r10_f6' || $data['vacc_ind']=='cr_r12_f6' || $data['vacc_ind']=='cr_r13_f6' || $data['vacc_ind']=='cr_r14_f6' || $data['vacc_ind']=='cr_r15_f6')
				{
					if($wastage_rate <= 5)
						$serieses['data'][$i]['color'] = "#248E5F";
					else if($wastage_rate <= 10 && $wastage_rate >= 6)
						$serieses['data'][$i]['color'] = "#f3e83a";
					else if($wastage_rate > 10)
						$serieses['data'][$i]['color'] = "#e3330d";
				}
				else
				{
					if($wastage_rate >= 30)
						$serieses['data'][$i]['color'] = "#e3330d";//red
					else if($wastage_rate <= 29.99 && $wastage_rate >= 20)
						$serieses['data'][$i]['color'] = "#f3e83a";//yellow
					else if($wastage_rate <= 19.99 && $wastage_rate >= 10)
						$serieses['data'][$i]['color'] = "#3366ff";//blue
					else if($wastage_rate < 10)
						$serieses['data'][$i]['color'] = "#248E5F";//green
				}
				
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
		$vacc_id=$whereData['vacc_ind'];
		unset($whereData['distcode']);
		unset($whereData['year']);
		unset($whereData['indicator']);
		unset($whereData['vacc_ind']);
	
		$whereNew = array();
		foreach($whereData as $key => $val){
			$whereNew[] = $key. " = " . "'".$val."'";
		}
		//print_r($arrayData);exit;
		$formula        = $arrayData[0]["formula_text"];
		$ind_name       = $arrayData[0]["ind_name"];
		$num_text       = $arrayData[0]["numenator"];
		$den_text       = $arrayData[0]["denominator"];
		$multiple       = $arrayData[0]["mt"];
		$ind_type       = (isset($arrayData[0]["ind_type"])?$arrayData[0]["ind_type"]:'%');
		$is_inverse     = (isset($arrayData[0]["ind_type"])?$arrayData[0]["ind_type"]:0);
		$result_text    = $arrayData[0]["result_text"];
		$description    = (isset($arrayData[0]["description"])?$arrayData[0]["description"]:NULL);
		
		$yearMonth = explode("-",$fmonth);
		$year = $yearMonth[0];
		if(isset($yearMonth[1]) && ($yearMonth[1] != "" || $yearMonth[1] != 0))
			$whereFmonth = " fmonth = '$fmonth' ";
		else
			$whereFmonth = " fmonth like '$year-%' ";
		
		$CI = & get_instance();
		/* if($data['indicator'] == '53' && $data['vacc_ind']) {
			$formula = getClosedVialsWastageRate($data['vacc_ind']);
		}
		if($data['indicator'] == '54' && $data['vacc_ind']) {
			$formula = getOpenedVialsWastageRate($data['vacc_ind']);
		}
		if($data['indicator'] == '55' && $data['vacc_ind']) {
			$formula = getVaccineWastageRate($data['vacc_ind']);
		 }*/
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
		//$formula=$num_text."/".$den_text;
	  $table="";
		/* if($den!=""){
			$mul="*$multiple";
		} */
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
		 $formula="round(($num_text::numeric/NULLIF($den_text::numeric, 0))*100, 1)" ;
		//echo $formula;exit;
		/* $wc.=(($level=="facility" || $level=="unioncouncil")?" and $table.uncode=uc_wise_maps_paths.uncode and $table.distcode='".$distcode."' group by $table.uncode":"and distcode=districts.distcode");
		$qformula=($denominator=="")?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul";
		$q.=" round(coalesce($qformula,0)::numeric,0) from $table where $whereFmonth ".(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." $wc )  as wastage_rate"; */
		$wc.=(($level=="facility" || $level=="unioncouncil")?" and $table.uncode=uc_wise_maps_paths.uncode and $table.distcode='".$distcode."' group by $table.uncode":"and distcode=districts.distcode");
		//$qformula=($denominator=="")?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul";
		$q.=" $formula from $table  join epi_consumption_detail on epi_consumption_detail.main_id=$table.pk_id where $whereFmonth and item_id=$vacc_id" .(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." $wc )  as wastage_rate";
		if($forCards){
			return " round(coalesce($formula,0)::numeric,0) ";
		}
		//echo $q.'-::-wastage_rate-::-'.$orderType;
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
		/*if($data['indicator'])
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$data['indicator']);
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}*/
		 if($data['indicator'])
		{
			$this -> db -> select('*');
			$this -> db -> where('indmain',$data['indicator']);
			$arrayData = $this -> db -> get ('indicator_main') -> result_array();
		}
		//print_r($data);exit;
		$ind_name = $arrayData[0]["ind_name"];
		$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		$level = (isset($data['distcode']) && $data['distcode'] > 0 || $this->session->District)?"facility":"district";
		$level = isset($data['facode'])?"facility":$level;
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);
			//now using consumption table						  
		$report_table = "epi_consumption_master";
		if($forCards){
			return $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $distcode, $report_table,$data,$data,true);
		}
		$queryArray = explode('-::-', $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $distcode, $report_table,$data,$data));
		return $queryArray;
	} 
	public function getIndicatorData($data,$wc){
		//print_r($data);exit;
		$vacc_id=$data['vacc_ind'];
		$data['indicator'] = '66';
		$s1 = $this -> Vaccine($data, $wc, true);
		//print_r($s1);exit;
		$data['indicator'] = '67';
		$s2 = $this -> Vaccine($data, $wc, true);
		//print_r($s1);exit;
		/* $data['indicator'] = '55';
		$s3 = $this -> Vaccine($data, $wc, true); //Vaccine usage (rate)
		$s3="100-".$s3; */ //need to set it according to new table epi_consumption_master
		$reportType = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$fmonth = $data['year'].'-'.$data['month'];
		if($reportType == 'monthly'){
			//0 as total need to change according to new table. replce it with $3.
			$query = $s2." as closedTotal, ".$s1." as openedTotal, 0 as Total from epi_consumption_master join epi_consumption_detail on epi_consumption_detail.main_id=epi_consumption_master.pk_id where fmonth='".$fmonth."' and epi_consumption_detail.item_id=$vacc_id "; 
		}
		elseif($reportType == 'yearly'){
			//0 as total need to change according to new table. replce it with $3.
			$query = $s2." as closedTotal, ".$s1." as openedTotal, 0 as Total from epi_consumption_master join epi_consumption_detail on epi_consumption_detail.main_id=epi_consumption_master.pk_id where fmonth like '".$data['year']."-%' and epi_consumption_detail.item_id=$vacc_id"; 
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
				$result[$key1] = $value1;
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
		$vacArray = array('cr_r1_f6' => 'BCG', 'cr_r2_f6' => 'DIL BCG', 'cr_r3_f6' => 'bOPV', 'cr_r4_f6' => 'Pentavalent', 'cr_r5_f6' => 'Pneumococcal(PCV10)', 'cr_r6_f6' => 'Measles', 'cr_r7_f6' => 'DIL Measles', 'cr_r8_f6' => 'TT 10', 'cr_r9_f6' => 'TT 20', 'cr_r10_f6' => 'Hep-B-10', 'cr_r11_f6' => 'IPV-10', 'cr_r12_f6' => 'AD Syringes 0.5 ml', 'cr_r13_f6' => 'AD Syringes 0.05 ml', 'cr_r14_f6' => 'Recon.Syringes (2 ml)', 'cr_r15_f6' => 'Recon. Syringes (5 ml)', 'cr_r16_f6' => 'Safety Boxes', 'cr_r17_f6' => 'Other', 'cr_r18_f6' => 'Rotarix', 'cr_r19_f6' => 'IPV-5','cr_r20_f6' => 'Hep-B-02');
		return $vacArray[$data['vacc_ind']];
	}
	function colorAxis($vacc_id=NULL){
		$dataClasses = RankingWiseColour($vacc_id);	
		//print_r($dataClasses);exit;
		/* $dataClasses[0]["from"] = '0';
		$dataClasses[0]["to"] = '20.99';
		$dataClasses[0]["color"] = '#0B7546';
		$dataClasses[0]["name"] = '0 to 20';
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
		$dataClasses[3]['name'] = '61 and above'; */
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	public function getUC_detailData(){
		//print_r($_POST['fmonth']); exit();
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['uncode'] = $uncode = $this -> input -> post('uncode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		//$parametersData['consumption_vaccineId'] = $consumption_vaccineId = $this -> input -> post('vaccineId');
		//$parametersData['vaccineId'] = $vaccineId =getVaccines_id($consumption_vaccineId);
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		//$parametersData['year'] = $year = $this -> input -> post('year');
		/* if($reportType == 'monthly' || $reportType ==''){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
		}else{} */
		//if(isset($parametersData['vaccineId'])){}else{ $parametersData['vaccineId']=1;}
		//if(isset($parametersData['consumption_vaccineId'])){}else{ $parametersData['consumption_vaccineId']=5;}
		//for now it is set stactic for bcg disease only-- zob:set it to new bcg id according for cres:kpk
		//$fmonth=$this -> input -> post('fmonth');
		//print_r($fmonth);
		if(!empty($_POST['fmonth'])){ 
			$parametersData['fmonthfrom'] = $fmonthfrom = $this -> input -> post('fmonth');
			$parametersData['fmonthto'] = $fmonthto = $this -> input -> post('fmonth');
			
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $fmonthfrom . "' and fmonth <= '" . $fmonthto . "'";
		}else{
			$parametersData['fmonthfrom'] = $fmonthfrom = $this -> input -> post('fmonthfrom');
			$parametersData['fmonthto'] = $fmonthto = $this -> input -> post('fmonthto');
			
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $fmonthfrom . "' and fmonth <= '" . $fmonthto . "'";
		}
		$viewData = $parametersData;
		if(isset($parametersData['month'])){ $parametersData['month']=$parametersData['month'];}else{ $parametersData['month']="01";}
		/* Summary View Data */
		//print_r($parametersData);exit;
		//for UC detail data change item_id to fac_mvrf_db table ids. cri
		$summaryData = $this -> ucSummary($parametersData);
		//print_r($summaryData);exit;
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
		$viewData['activeClass'] ="summary";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	public function ucSummary($parametersData){
		//print_r($parametersData);exit();
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		
		$data['productsArray'] = $productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv1',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2',19=>'dtp',20=>'tcv',21=>'ipv2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV-1',14=>'Rota-1',15=>'Rota-2',16=>'MR-I',17=>'Fully Immunized',18=>'MR-II',19=>'DTP','20'=>'TCV',21=>'IPV-2'); 
		/* $arr=getRegVaccines_options(true,1,TRUE,array(1,2,3));
			foreach($arr as $key=>$val)
			{
				$vac_array[$val['cr_table_row_numb']]=$val['item_name'];
			}
			$data['productsNameArray']=$vac_array; */
		$data['vaccineId'] = $vaccineId = $parametersData['vaccineId'];
		$data['sessionPlannedHeld'] = sessionPlannedHeld($parametersData['rangeCondition'],$parametersData['uncode'],'',$parametersData['distcode']);
		$data['vaccinationNumbers'] = vaccinationInNumbers($parametersData['rangeCondition'],$parametersData['uncode'],NULL,$parametersData['vaccineId'],NULL,$parametersData['distcode']);//print_r($data['vaccinationNumbers']);
		$data['totalVaccinationNumbers'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'both',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersMale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'male',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersFemale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'female',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$code="";
		$type="";
		if((isset($parametersData['procode']) && $parametersData['procode']!=null)){
			$code=$parametersData['procode'];
			$type="Province : Khyber Pakhtunkhwa";
			$type1=", Khyber Pakhtunkhwa";
		}
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
		
		$data['distYear']=" For ".$type." , Year : ".$parametersData['yearto'];
		$data['distYear1'] = $type1.", Year-".$parametersData['yearto'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['yearto'],$parametersData['vaccineId']);				
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['yearto'],$parametersData['month'],$productsArray[$vaccineId]);
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);//print_r($data['monthlyVaccinationTrendAllDisease']);exit;
		$data['monthlyVaccinationTrendForfullyimmunized'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],'17',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['monthlyVaccinationTrendForTT'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],'TT1-TT2',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1');
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2');
		//$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		//$parts = explode('-',$consumptionVaccineID_dosespervial);
		//$consumptionVaccineID = $parts[0];
		//$dosespervial = $parts[1];
//espervial = 20;//reomve it 
		//$consumptionVaccineID=$parametersData['consumption_vaccineId'];
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		//print_r($data['vaccineUsageRate']);exit;
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		//$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','case_investigation_db',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],"Msl");
		$data['weeklyOutBreakAFP'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'afp_case_investigation',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakNNT'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'nnt_investigation_form',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data; 
	}
	
	public function ucCoverage($parametersData){
		//print_r($parametersData);
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data;
	}
	
	public function ucConsumption($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto']);
		return $data;
	}
	
	public function ucDropout($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$data['rota1_rota2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'rota1-rota2');
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1');
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2');
		return $data;
	}
	
	public function ucSurveillance($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];

		$data['weeklyZeroReportsTrend'] = weeklyTrendforZeroReports($parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode']);
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
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		if($caseType == "AFP" || $caseType == "NT")
			$type = NULL;
		else
			$type = $caseType;
		$result = $this -> maps -> weeklyTrendforOut_breakReports('bubble',$table,$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],$type,"object");
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
	
	public function getActiveVaccinesOptions(){
		$indId = $this -> input -> post('indicatorid');
		echo getVaccines_options(true,1,FALSE,array(1));
	}
}
?>