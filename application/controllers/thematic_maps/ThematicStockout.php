<?php
class ThematicStockout extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		$code = md5(date("Y-n-d"));
		if(isset($_POST['code']) && $_POST['code'] == $code){
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
		$this -> load -> model('Stockout_model','stockout');
	}
	public function index(){
		$queryData = array();
		$wc = NULL;
		$ajax = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['procode'] = $procode = ($this -> session -> Province)?$this -> session -> Province:3;
		$data['month'] = $month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
		$data['year']  = $year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		$data['fmonth']= $fmonth = $year.'-'.$month;
		$data['vacc_ind']  = $vacc_ind = ($this -> input -> post('vacc_ind'))?$this -> input -> post('vacc_ind'):'5';
		$queryData = $data;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$data['vacName'] = $this -> getVaccineName($data);
		$data['colorAxis'] = $this -> colorAxis($vacc_ind);
		if($data['reportType']=='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}
		$data['heading']['mapName'] = "{$data['vacName']} Stockout Rate, {$monthQauarterYear} (w.r.t submitted Reports)";
		//For deo user and province level drilldown to deo level;
        if($this -> session -> District || $this -> input -> post('distcode')|| $this -> uri -> segment(4))
		{
			$data['id']  = $distcode = ($this -> uri -> segment(4))?$this -> uri -> segment(4):$this -> session -> District;
			if($distcode=='')
			{
				$distcode=$this -> input -> post('distcode');
			}
			$data['reportType']  =($this -> uri -> segment(5))?$this -> uri -> segment(5):$this -> input -> post('reportType');
			$data['month']  = $month = ($this -> uri -> segment(6))?$this -> uri -> segment(6):$this -> input -> post('month');
			$data['year']  = $year = ($this -> uri -> segment(7))?$this -> uri -> segment(7):$this -> input -> post('year');
			$data['vacc_ind']  = $vacc_ind  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):$this -> input -> post('vacc_ind');
			if($data['vacc_ind']=='')
			{
				$data['vacc_ind']=$vacc_ind='5';
			}
			if($data['month']=='')
			{
				$data['month']=$month=date('m',strtotime("first day of previous months"));
			}
			if($data['year']=='')
			{
				$data['year']=$year=date('Y',strtotime("first day of previous months"));
			}
			if($data['reportType']=='')
			{
				$data['reportType']='monthly';
			}
			if($data['reportType']=='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$year;
			}
			$data['fmonth']= $fmonth = $year.'-'.$month;
			$districtName = get_District_Name($distcode);
			$data['vacName'] = $this -> getVaccineName($data);
			$data['distcode']=$distcode;
			$data['colorAxis'] = $this -> colorAxis($vacc_ind);
			$data['heading']['mapName'] = "{$data['vacName']} Stockout Rate, {$districtName}, {$monthQauarterYear}";
			$data['heading']['barName'] = "{$data['vacName']} Stockout Rate, {$districtName},{$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true'; 
		}else{
			$distcode = NULL;
			$data['heading']['barName'] = "{$data['vacName']} Stockout Rate,{$monthQauarterYear}";
			$data['heading']['run'] = true;
		}
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$vaccdata = array();
		$dbdata = $this->stockout->get_vacc_stock_out_data($fmonth,$vacc_ind,$distcode);
		$result = $this->stockOutData($vacc_ind,$fmonth,$dbdata,$vaccdata);
		$viewData['serieses'] = $result['serieses'];
		$viewData['vacctbldata'] = $vaccdata;
		$viewData['data'] = $data; 
		$viewData['filterowbtn'] = 'ThematicStockout';
		$viewData['fileToLoad'] = 'thematic_maps/thematic_vaccine_stockout';
		$viewData['pageTitle']='EPI-MIS Dashboard | Vaccine Stockout Rate ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	function getVaccineName($data){
		$vacArray = getStockoutVaccines($data['vacc_ind'],false,true);
		if(isset($vacArray[0])){
			return $vacArray[0]["name"];
		}
		return "";
	}
	function colorAxis($vacc_id=NULL){
		$dataClasses = RankingWiseColour($vacc_id);
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	//================ stockOutData function starts====================//
	public function stockOutData($Selecteditemid,$fmonth,$dbdata,&$vaccdata){
		//get provincial level (District Stores) category wise stock out vaccine
        $vaccserieses = $result = $dataSeries = array();
		$vaccserieses = array(
			'name'		=> "Districts Wise Stockout Rate",
			'type'		=> 'map',
			'animation' => true,
			'dataLabels'=> array('enabled'=>true,'align'=>'center'),
			'data'		=> array()
		);
		if(!empty($dbdata)){
			foreach($dbdata as $key=>$oneseries){
				$vaccserieses['data'][$key] = array(
					'id'		=> $oneseries["code"],
					'name'		=> $oneseries["name"],
					'shortname'	=> $oneseries["name"],
					'path'		=> $oneseries["path"],
					'due'		=> (isset($oneseries["due"]) && $oneseries["due"]>0)?$oneseries["due"]:0,
					'submitted'	=> (isset($oneseries["submitted"]) && $oneseries["submitted"]>0)?$oneseries["submitted"]:0,
					'stockout'	=> (isset($oneseries["stockout"]) && $oneseries["stockout"]>0)?$oneseries["stockout"]:0,
					'value'		=> (isset($oneseries["submitted"]) && $oneseries["submitted"]>0)?round(($oneseries["stockout"]/$oneseries["submitted"])*100,2):0
				);
				if($vaccserieses['data'][$key]["submitted"]==0){
					$vaccserieses['data'][$key]["color"]='#808080';
				}
			}
		}else{
			//$showdefault = true;
		}
		
		
		/* $regionaldata = $this->stockout->get_vacc_stock_out_data($fmonth,$Selecteditemid,$distcode);
		
		foreach($regionaldata as $procode=>$oneregion){
			$showdefault = false;
            //loop through regions, run API, get stockout data
            if(isset($oneregion["weburl"])){
                $currRegData = array();
				$regionaldata["data"] = $currRegData = get_vacc_stock_out_data($oneregion["weburl"],$Selecteditemid,$fmonth,$procode);
				
            }else{
				$showdefault = true;				
			}
			if($showdefault){
				$vaccserieses['data'][$i] = array(
					'id'		=> $procode,
					'name'		=> $oneregion["name"],
					'shortname'	=> $oneregion["shortname"],
					'color'		=> '#808080',
					'path'		=> $oneregion["path"],
					'due'	=> 0,
					'submitted'	=> 0,
					'stockout'	=> 0,
					'value'		=> 0
				);
			}
			$i++;
		} */
		$vaccdata = $vaccserieses['data'];
		array_push($dataSeries,$vaccserieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		return $result;
	}
	/* public function getRankingSeriesData($data, $wc){
		/* $selectQuery = $this -> Vaccine($data, $wc);
		$name = 'Province';
		if($data['procode'] && $data['procode'] != NULL){
			$coverageData = $this -> maps -> getUCsVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
			$name = 'District';
		}
		else{
			$coverageData = $this -> maps -> getVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
		} *
		$serieses = $serieses1 = $result = $dataSeries = $dataSeries1 = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		if($coverageData){
			foreach($coverageData as $row)
			{
				if( ! in_array($row -> code,array(1,2,9))){
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
	} */
	/* public function getSeriesData($data){
		$name = 'Province';
		$selectQuery = $this -> Vaccine($data, $wc);
		//print_r($data);exit;
		$name = 'Province';
		if($data['procode'] && $data['procode'] != NULL){
			$coverageData = $this -> maps -> getUCsVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
			$name = 'District';
		}
		else{
			$coverageData = $this -> maps -> getVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
		}
		
		$serieses = array();
		$result = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Vaccine Stockout Rate";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($data as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			if($row -> code == 1 || $row -> code == 2 || $row -> code == 9)
				$serieses['data'][$i]['color'] = '#808080';
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
	 */
	/* public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			//$data['id'] = $this -> input -> post('id');
			$data = array();
			$data['distcode'] = $this -> uri -> segment(4);
			$data['month'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime("first day of previous months"));
			$data['year']  = $year = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
			$data['indicator']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'54';
			$data['vacc_ind']  = $vacc_ind = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'cr_r1_f6';
			$queryData = $data;
			$data['reportType']  = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
			$data['vacName'] =  $this -> getVaccineName($data);
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
			//$data['indicators'] = $this -> getIndicatorData($queryData, $wc);
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
	} */
	
	/* public function getVal($vaccID=null){
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
	} */
	/* public function getRankingSeriesData($data, $wc){
		$selectQuery = $this -> Vaccine($data, $wc);
		$name = 'Province';
		if($data['procode'] && $data['procode'] != NULL){
			$coverageData = $this -> maps -> getUCsVaccineIndicatorCoverge($data,$selectQuery[0],$selectQuery[1],$selectQuery[2]);
			$name = 'District';
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
			foreach($coverageData as $row)
			{
				if( ! in_array($row -> code,array(1,2,9))){
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
	} */
	
	/* public function getDistrictSeriesData($data){
		echo "Comming Soon";
	} */
	
	/* public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	} */
	
	/* function getQuerySelectPortion($arrayData, $fmonth, $level, $procode,$report_table=NULL, $whereData=NULL,$data=NULL,$forCards=false)
	{
		if((isset($data['procode']) && $data['procode'] != '')){
			$q = " dist.distcode as code,dist.district as name,(select ";
		}else{
			$q = " pro.procode as code, pro.province as name,(select ";
		}
		$month = NULL;
		if(isset($whereData['month'])){
			$month = $whereData['month'];
			unset($whereData['month']);
		}
		unset($whereData['procode']);
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
		//echo $formula;exit;
		$divstr=explode("/",$formula);
		//print_r($divstr);exit;
		$num=$divstr[0];
		$den=$divstr[1];
		$den = str_replace('-::-','/',$den);
		$num = getNominator($num);
		$divnumfields = str_replace('-::-','/',$num);
		$numerator = "sum(coalesce(".$divnumfields.",0))";
		//$divnumfields=preg_split("/[+-]+/", $num);//explode("+",$num);
		//print_r($divnumfields);exit;
		/* for($i=0;$i<count($divnumfields);$i++){
			$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
		}   
		$numerator=implode("+",$divnumfields); *
		$den = getDenominator($den,$year,$month);//$year will be sent once year functionality is implemented.
		
		$divnumfields=explode("+",$den);
		for($i=0;$i<count($divnumfields);$i++){
			if(in_array($den, $den_array)){
				$divnumfields[$i]= "coalesce(".$divnumfields[$i].",0)";
			}else{
				if(strstr($divnumfields[$i],'-'))
				{
					$minusExplode = explode('-',$divnumfields[$i]);
					for($j=0;$j<count($minusExplode);$j++){
						$minusarray[$j] = "sum(coalesce(".$minusExplode[$j].",0))";
					}
					$divnumfields[$i] = implode('-',$minusarray);
				}
				else
				{
					$divnumfields[$i]= "sum(coalesce(".$divnumfields[$i].",0))";
				}
			}
		}
		$denominator=implode("+",$divnumfields);//print_r($numerator."den".$denominator);exit;
		$table=$report_table;
		if($den!=""){
			$mul="*$multiple";
		}
		/* if($level=="district"){
			$table=$report_table;
		}
		if($level=="facility"){
			$table=$report_table;
		} *
		if($is_inverse=="1")
		{
			$orderType = "Asc";
		}else
		{
			$orderType = "Desc";
		}
		$wc="";
		$wc.=(($level=="district")?" and $table.distcode=dist.distcode and $table.procode='".$procode."' group by $table.distcode":"and procode=pro.procode");
		$qformula=($denominator=="")?$numerator:"(($numerator)::numeric//($denominator)::numeric)$mul";
		$q.=" round(coalesce($qformula,0)::numeric,0) from $table where $whereFmonth ".(!empty($whereNew) ? ' AND '.implode(" AND ", $whereNew) : '')." $wc )  as wastage_rate";
		if($forCards){
			return " round(coalesce($qformula,0)::numeric,0) ";
		}
		//echo $q.'-::-wastage_rate-::-'.$orderType;exit;
		return $q.'-::-wastage_rate-::-'.$orderType;
	} */
	/* function Vaccine($data,$wc,$forCards=false){
		$whereCondition = WC_replacement($wc);
		$newWc = $whereCondition[0];
		$newWc1 = $whereCondition[1];
		if($data['procode'] && $data['procode'] != NULL){
			unset($newWc1[1]);
		}
		$query = 'select * from indcat';
		/* if($data['indicator'])
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$data['indicator']);
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}
		//print_r($data);exit;
		$ind_name = $arrayData[0]["ind_name"]; *
		$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		$level = (isset($data['procode']) && $data['procode'] > 0)?"district":"province";
		$procode = (isset($data['procode']) && $data['procode']> 0)?$data['procode']:NULL;
		$report_table = "form_b_cr";
		if($forCards){
			return $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $procode, $report_table,$data,$data,true);
		}
		$queryArray = explode('-::-', $this->getQuerySelectPortion($arrayData,"$yearMonth", $level, $procode, $report_table,$data,$data));
		return $queryArray;
	}  */
	/* public function getIndicatorData($data,$wc){
		//print_r($data);exit;
		$data['indicator'] = '53';
		$s1 = $this -> Vaccine($data, $wc, true);
		$data['indicator'] = '54';
		$s2 = $this -> Vaccine($data, $wc, true);
		$data['indicator'] = '55';
		$s3 = $this -> Vaccine($data, $wc, true); //Vaccine usage (rate)
		$s3="100-".$s3;
		$reportType = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		$fmonth = $data['year'].'-'.$data['month'];
		if($reportType == 'monthly'){
			$query = $s1." as closedTotal, ".$s2." as openedTotal, ". $s3." as Total from form_b_cr where fmonth='".$fmonth."' "; 
		}
		elseif($reportType == 'yearly'){
			$query = $s1." as closedTotal, ".$s2." as openedTotal, ".$s3." as Total from form_b_cr where fmonth like '".$data['year']."-%' "; 
		}

		if((isset($data['procode']) && $data['procode'] != '')){
			$code = $data['procode'];
			if(isset($data['procode']) && $data['procode']>0)
				$code = $data['procode'];
			$query .= " and procode='".$code."' ";
		}else{
			$query .= "";
		}
		$query = str_replace('-::-', '*', $query);
		//echo $query;exit;
		$result1 = $this -> maps -> getVaccineIndicatorData($data,$query);
		foreach ($result1 as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$result[$key1] = $value1;
			}
		}
		//print_r($result);exit;
		return $result;
	} */
	/* public function getUC_detailData(){
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['procode'] = $procode = $this -> input -> post('procode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'yearly';
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		if($reportType == 'monthly' || $reportType ==''){
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
		$summaryData = $this -> ucSummary($parametersData);
		if($services)
		{
			$summaryData['services'] = $services;
		}else{
			$summaryData['services'] = "outreach";
		}
		$summaryData['monthly_yearly_target'] = $coverageData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
		$viewData['summary'] = $this -> load -> view('thematic_maps/parts_view/ucsummary', $summaryData, TRUE);
		$coverageData = $this -> ucCoverage($parametersData);
		$coverageData['sessionPlannedHeld'] = $summaryData['sessionPlannedHeld'];
		$coverageData['vaccinationNumbers'] = $summaryData['vaccinationNumbers'];
		$coverageData['vaccineId'] = $summaryData['vaccineId'];
		$coverageData['monthlyTarget'] = $summaryData['monthlyTarget'];
		$coverageData['productsNameArray'] = $summaryData['productsNameArray'];
		$coverageData['productsArray'] = $summaryData['productsArray'];
		$viewData['coverage'] = $this -> load -> view('thematic_maps/parts_view/uccoverage', $coverageData, TRUE);
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
	} */
	/* public function ucSummary($parametersData){
		$data['productsArray'] = $productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV',14=>'Rota-1',15=>'Rota-2',16=>'Measles-I',17=>'Fully Immunized',18=>'Measles-II');
		$data['vaccineId'] = $vaccineId = $parametersData['vaccineId'];
		$data['sessionPlannedHeld'] = sessionPlannedHeld($parametersData['rangeCondition'],$parametersData['distcode'],'',$parametersData['procode']);
		$data['vaccinationNumbers'] = vaccinationInNumbers($parametersData['rangeCondition'],$parametersData['distcode'],NULL,$parametersData['vaccineId'],NULL,$parametersData['procode']);//print_r($data['vaccinationNumbers']);
		$data['totalVaccinationNumbers'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'both',$parametersData['procode'],NULL,$parametersData['distcode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersMale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'male',$parametersData['procode'],NULL,$parametersData['distcode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersFemale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'female',$parametersData['procode'],NULL,$parametersData['distcode'],NULL,$parametersData['vaccineId']);
		$code="";
		$type="";
		if((isset($parametersData['distcode']) && $parametersData['distcode']!=null)){
			$code=$parametersData['distcode'];
			$type="District : ".get_District_Name($code);
			$type1=", ".get_District_Name($code);
		}
		if((isset($parametersData['procode']) && $parametersData['procode']!=null)){
			$code=$parametersData['procode'];
			$type="Province : ".$this -> maps -> ProvinceName($code);
			$type1=", ".$this -> maps -> ProvinceName($code);
		}
		$data['distYear'] =" For ".$type." , Year-".$parametersData['year'];
		$data['distYear1'] = $type1.", Year-".$parametersData['year'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,'province',$parametersData['year'],$parametersData['vaccineId']);
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['year'],$parametersData['month'],$productsArray[$vaccineId]);//print_r($data['monthlyTotTarget']);exit;
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['procode'],NULL,$parametersData['distcode']);
		$data['monthlyVaccinationTrendForfullyimmunized'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'17',$parametersData['procode'],NULL,$parametersData['distcode']);
		$data['monthlyVaccinationTrendForTT'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'TT1-TT2',$parametersData['procode'],NULL,$parametersData['distcode']);
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'hh');
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'tt1-tt2');
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		$data['weeklyOutBreakMeasles'] = array();//$this -> maps -> weeklyTrendforOut_breakReports(NULL,'case_investigation_db',$parametersData['year'],$parametersData['procode'],NULL,$parametersData['distcode']);
		$data['weeklyOutBreakAFP'] = array();//$this -> maps -> weeklyTrendforOut_breakReports(NULL,'afp_case_investigation',$parametersData['year'],$parametersData['procode'],NULL,$parametersData['distcode']);
		$data['weeklyOutBreakNNT'] = array();//$this -> maps -> weeklyTrendforOut_breakReports(NULL,'nnt_investigation_form',$parametersData['year'],$parametersData['procode'],NULL,$parametersData['distcode']);
		return $data; 
	} */
	
	/* public function ucCoverage($parametersData){
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'hh');
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['procode'],NULL,$parametersData['distcode']);
		return $data;
	} */
	
	/* public function ucConsumption($parametersData){
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['procode'],$parametersData['distcode'],$parametersData['year']);
		return $data;
	} */
	
	/* public function ucDropout($parametersData){
		
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'tt1-tt2');
		$data['rota1_rota2'] = dropoutRateTrend($parametersData['year'],$parametersData['procode'],$parametersData['distcode'],'rota1-rota2');
		return $data;
	} */
	
	/* public function ucSurveillance($parametersData){
		$data['weeklyZeroReportsTrend'] = array();//weeklyTrendforZeroReports($parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakAFP'] = array();//$this ->getChartData("afp_case_investigation",$parametersData,"AFP","#f3e83a");
		$data['weeklyOutBreakNNT'] = array();//$this ->getChartData("nnt_investigation_form",$parametersData,"NT","#8B0000");
		$data['weeklyOutBreakMeasles'] = array();//$this ->getChartData("case_investigation_db",$parametersData,"Msl");
		$data['weeklyOutBreakDiphtheria'] = array();//$this ->getChartData("case_investigation_db",$parametersData,"Diph","#00FF00");
		return $data;
	} */
	
	/* public function ucAttendence($parametersData){
		$data = "";
		return $data;
	} */
	/* public function getChartData($table,$parametersData,$caseType,$color=Null){
		if($caseType == "AFP" || $caseType == "NT")
			$type = NULL;
		else
			$type = $caseType;
		$result = $this -> maps -> weeklyTrendforOut_breakReports('bubble',$table,$parametersData['year'],$parametersData['procode'],NULL,$parametersData['distcode'],$type,"object");
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
	} */
	
	/* public function getActiveVaccinesOptions(){
		$indId = $this -> input -> post('indicatorid');
		echo getActiveVaccinesOptions(NULL,$indId);
	} */
}
?>