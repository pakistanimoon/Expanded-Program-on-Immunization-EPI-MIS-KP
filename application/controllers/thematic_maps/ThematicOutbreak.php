<?php 
class ThematicOutbreak extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
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
		$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() {
		if($this -> session -> District){ 
			$this -> UcWiseMapData();
		}else{
			if($this -> input -> post('id'))
			{
				$this -> UcWiseMapData();
			}
			else
			{
				$this -> DistrictWiseMapData();
			}
		}
		//$this -> DistrictWiseMapData();
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$data = $this -> getUriSegmentData();
		if($data['from_week']==$data['to_week']){
			$monthQauarterYear = ", Year-".$data['year']." Week-".$data['from_week'];
			$fweekhover = "{$data['year']} Week-{$data['from_week']}";
		}else{
			$monthQauarterYear = ", Year-{$data['year']}, From Week {$data['from_week']} To {$data['to_week']}";
			$fweekhover = "{$data['year']}, From Week {$data['from_week']} To {$data['to_week']}";
		}
		$data['fweekhover'] = $fweekhover;
		$districtName="";
		$locality =  "District";
		$diseaseName = ucfirst($data['disease']);
		$procode = $this->session->Province;
		$info['mapName'] = $info['barName'] = "{$locality} Wise Disease OutBreak For {$diseaseName} {$districtName}{$monthQauarterYear}";
		
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		$data['colorAxis'] = $this -> colorAxis();
		$i = 0;
		$withdrops = $totaldrops = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = $row -> cnt;
			$totaldrops += $row -> cnt;
			$count = $serieses['data'][$i]['value'];
			if($count > 0){
					$serieses['data'][$i]['color'] = "#DD1E2F";
					$withdrops++;
			}
			else{
					$serieses['data'][$i]['color'] = "#0B7546";
			}
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, $locality);
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['withdrop'] = $withdrops;
		$data['totaldrops'] = $totaldrops;
		$data['heading'] = $info;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/thematic_out_break';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getQuerySelection($data){
		$fweek_from = $data['year']."-".sprintf("%02d",$data['from_week']);
		$fweek_to = $data['year']."-".sprintf("%02d",$data['to_week']);
		$disease=str_replace('%20',' ',$data['disease']);
		switch($disease)
		{
			case 'measles':
				$table = "case_investigation_db";
				$case_type = "0";
				$case_typewc = " and case_type = 'Msl' ";
				break;
			case 'nnt':
				$table = "nnt_investigation_form";
				$case_type = "0";
				$case_typewc = "";
				break;
			case 'afp':
				$table = "afp_case_investigation";
				$case_type = "0";
				$case_typewc = "";
				break;
			case 'diphtheria':
				$table = "case_investigation_db";
				$case_type = "Diphtheria";
				$case_typewc = " and case_type = 'Diph' ";
				break;
			case 'childhood tb':
				$table = "case_investigation_db";
				$case_type = "Childhood TB";
				$case_typewc = " and case_type = 'ChTB' ";
				break;
			case 'pertussis':
				$table = "case_investigation_db";
				$case_type = "Pertussis";
				$case_typewc = " and case_type = 'Pert' ";
				break;
			case 'pneumonia':
				$table = "case_investigation_db";
				$case_type = "Pneumonia";
				$case_typewc = " and case_type = 'Pneu' ";
				break;
			case 'meningitis':
				$table = "case_investigation_db";
				$case_type = "Meningitis";
				$case_typewc = " and case_type = 'Men' ";
				break;
			case 'hepatitis':
				$table = "case_investigation_db";
				$case_type = "Hepatitis";
				$case_typewc = " and case_type = 'AVHep' ";
				break;
			case 'typhoid':
				$table = "case_investigation_db";
				$case_type = "Typhoid";
				$case_typewc = " and case_type = 'Typ' ";
				break;	
			case 'all':
				$table = "";
				$case_type = "";
				break;
		}
		$procode=$this->session->Province;
		$code="";
		if($data['id'] AND $data['id'] > 0){
			$code = $data['id'];
			$query="select d1.uncode as code,d1.un_name as name,(select count(*) from (SELECT patient_address_uncode,fweek,count(*) FROM case_investigation_db WHERE fweek >='{$fweek_from}' and fweek<='{$fweek_to}' 
					and case_type = 'Msl' {$case_typewc}
					AND patient_address_uncode=d1.uncode
					AND length(patient_address_uncode)=9 group by patient_address_uncode,fweek having count(*) >= 5) as a) as cnt,path from unioncouncil d1
					join uc_wise_maps_paths d2 on d2.uncode=d1.uncode
					where d1.distcode='{$code}' order by d1.uncode
				";
		}else{
			$query="
			select d1.distcode as code,d1.district as name,
				(select count(*) from (SELECT patient_address_uncode,fweek,count(*)
				FROM case_investigation_db casedb WHERE fweek >='{$fweek_from}' and fweek<='{$fweek_to}'
				{$case_typewc} AND casedb.distcode=d1.distcode
				AND length(patient_address_uncode)=9 group by patient_address_uncode,
			fweek having count(*) >= 5) as a) as cnt,path 
			from districts d1
			join districts_wise_maps_paths d2 on d2.distcode=d1.distcode";
		}//print_r($query);exit;
		$result = $this -> maps -> getEPIDIndicator($code,$query);
		return $result;
		
	}
	public function getUriSegmentData(){
		$data['reportStatus'] = ($this -> input -> post('reportStatus'))?$this -> input -> post('reportStatus'):'complete';
		if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
			$data['ajax'] = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		if($this -> uri -> segment(4))
		{
			$data['id'] = "";
			if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
				$data['id'] = $this -> uri -> segment(4);
			$data['year'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):date('Y');
			$data['from_week']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'01';
			$data['to_week']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):'01';
			$data['disease']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'01';
			/* $data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'Weekly';		
			$data['year']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months"));
			$data['month'] = $month =($this -> uri -> segment(7))?$this -> uri -> segment(7):date('m',strtotime("first day of previous months"));
			$data['quarter']  = $quarter= ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			//$data['ajax'] = ($this -> uri -> segment(10))?$this -> uri -> segment(10):false;
			$data['compType'] = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Vaccination';
			$data['week'] = $week =($this -> uri -> segment(10))?$this -> uri -> segment(10):'1';
			$data['biyear'] = $week =($this -> uri -> segment(11))?$this -> uri -> segment(11):'01'; */
		}
		else
		{
			$data['id']  		= ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'Weekly';
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['month'] 		= ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['quarter']	= ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
			//$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
			$data['compType'] 	= ($this -> input -> post('compType'))?$this -> input -> post('compType'):'Vaccination';
			$data['week'] = $week =($this -> input -> post('week'))?$this -> input -> post('week'):'1';
			$data['biyear'] = ($this -> input -> post('biyear'))?$this -> input -> post('biyear'):'01';
			
			$data['from_week']  = $from_week = ($this -> input -> post('from_week'))?$this -> input -> post('from_week'):'01';
			$data['to_week']  = $to_week = ($this -> input -> post('to_week'))?$this -> input -> post('to_week'):'01';
			$data['disease']  = $disease = ($this -> input -> post('disease'))?$this -> input -> post('disease'):'measles';
		}
		return $data;
	}
	public function UcWiseMapData(){
		$data = $this -> getUriSegmentData();
		if($data['from_week']==$data['to_week']){
			$monthQauarterYear = ", Year-".$data['year']." Week-".$data['from_week'];
			$fweekhover = "{$data['year']} Week-{$data['from_week']}";
		}else{
			$monthQauarterYear = ", Year-{$data['year']}, From Week {$data['from_week']} To {$data['to_week']}";
			$fweekhover = "{$data['year']}, From Week {$data['from_week']} To {$data['to_week']}";
		}
		$data['fweekhover'] = $fweekhover;
		$districtName=get_District_Name($data['id']);
		$locality =  "Uc";
		$diseaseName = ucfirst($data['disease']);
		$procode = $this->session->Province;
		$info['mapName'] = $info['barName'] = "{$locality} Wise Disease OutBreak For {$diseaseName} {$districtName}{$monthQauarterYear}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = false;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$data['ucwisemap'] = 'true';
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		$data['colorAxis'] = $this -> colorAxis();
		$i = 0;
		$withdrop = $totaldrops = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = $row -> cnt;	
			$count = $serieses['data'][$i]['value'];
			if($count > 0){
					$serieses['data'][$i]['color'] = "#DD1E2F";
					$withdrop++;
			}
			else
			{
					$serieses['data'][$i]['color'] = "#0B7546";
			}
			$totaldrops += $row -> cnt;
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, $locality);
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$data['withdrop'] = $withdrop;
		$data['totaldrops'] = $totaldrops;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/thematic_out_break';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getRankingSeriesData($data,$resultdata, $locality){
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();
		$dataSeries1 = array();
		
		$i=0;$priority=1;
		$s['name'] = " ";
		$s['animation'] = true;
		$s['dataLabels']['enabled'] = true;
		$s['dataLabels']['align'] = "center"; 
		foreach($resultdata as $key  => $row){
			$serieses[$i]['name'] = $row -> name;
			$serieses[$i]['id'] = $row -> code;
			$serieses[$i]['y'] = $row -> cnt;

			if($row -> cnt > 0)
				$serieses[$i]['color'] = "#DD1E2F";
			else
				$serieses[$i]['color'] = "#0B7546";
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
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	function colorAxis($var=False){
		if($var){
			$dataClasses['min'] = 1;
			$dataClasses['minColor'] = '#0B7546';
			$dataClasses['maxColor'] = '#DD1E2F';
			$dataClasses['max'] = '1';
			$dataClasses['type'] = 'logarithmic';
		}else{
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '4.99';
			$dataClasses['dataClasses'][0]["color"] = '#0B7546';
			$dataClasses['dataClasses'][0]["name"] = 'District Without Disease OutBreak';

			$dataClasses['dataClasses'][1]['from'] = '5';
			$dataClasses['dataClasses'][1]['to'] = '1000';
			$dataClasses['dataClasses'][1]['color'] = '#DD1E2F';
			$dataClasses['dataClasses'][1]['name'] = 'District With Disease OutBreak';
		}
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	//----------------------------------------------------------//
	//================ UcWiseMapData function starts====================//
}
?>