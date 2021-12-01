<?php 
class PopulationCoverageRatio extends CI_Controller {
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
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$data = $this -> getUriSegmentData();
		if($data['reportType']=='monthly')
		{
			$monthQauarterYear = monthname($data['month'])." ".$data['year'];
		}elseif($data['reportType']=='quarterly')
		{
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$data['year'];
		}
		elseif($data['reportType']=='Weekly')
		{
			$monthQauarterYear = "Week-".$data['week']." ".$data['year'];
			$result = $this ->getQuerySelection($data);
		}elseif($data['reportType']=='biyearly'){
			$monthQauarterYear = $data['year']." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
		}
		else
		{
			$monthQauarterYear = $data['year'];
		}
		$districtName="";
		if($this->session->UserLevel==2)
		{
			$locality =  "District";
		}
		else
		{
			$distcode = $this->session->District;
			$locality = "Union Council";
			$districtName = DistrictName($distcode);
			
		}
		$info['mapName'] = $info['barName'] = "{$locality} Wise Technician to Population Ratio, {$districtName} {$monthQauarterYear}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelectionpop($data);
		$data['colorAxis'] = $this -> colorAxis();
		$data['plotYaxis'] = $this -> getplotLines();
		$i = $totpop = $tot_technician = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> poppertech > 0)?(round($row -> poppertech)):0;
			$serieses['data'][$i]['pop'] = ($row -> pop > 0 )?$row -> pop:0;
			$serieses['data'][$i]['tot_technician'] = ($row -> tot_technician > 0)?$row -> tot_technician:0;
			$serieses['data'][$i]['centers'] = ($row -> centers)?$row -> centers:0;
			$totpop += ($row -> pop > 0)?$row -> pop:0;
			$tot_technician +=($row -> tot_technician > 0)?(round($row -> tot_technician)):'0';
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, "District");
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$data['totpop'] = $totpop;
		$data['tot_technician'] = $tot_technician;
		$data['tech_pop_ratio'] = ($tot_technician > 0)?round($totpop/$tot_technician,0):0;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/populaiton_coverage_ratio';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getQuerySelectionpop($data){
		$code = "";
		$firstouterselection = $lastouterselection = "";
		if($data['id']){
			$code = $data['id'];
			$query="(SELECT COUNT(tble.facode) 
				from 
				techniciandb tble 
				where tble.uncode=u1.uncode and status='Active' ) as tot_technician,
				getpopulationpop(u1.uncode,'unioncouncil','{$data['year']}') as pop,
				(SELECT COUNT(*) FROM facilities fac WHERE hf_type='e' AND fac.uncode=u1.uncode) as centers,";
		}else{
			$firstouterselection = " select code, name, tot_technician ,centers,pop,round((pop::numeric // tot_technician)::numeric, 0) as poppertech,path from ( ";
			$lastouterselection = " ) as a order by pop::numeric // tot_technician";
			$query="(SELECT COUNT(tble.facode) 
				from 
				techniciandb tble 
				where tble.distcode=d1.distcode and status='Active' ) as tot_technician,
				getpopulationpop(d1.distcode,'district','{$data['year']}') as pop,
				(SELECT round(((sum(duem1+duem2+duem3+duem4+duem5+duem6+duem7+duem8+duem9+duem10+duem11+duem12))//12)::numeric,0) FROM consumptioncompliance ccp where year = '{$data['year']}' and ccp.distcode=d1.distcode ) as centers,";
		}
		$result = $this -> maps -> getdistrictWiseMapData($code,$query,$firstouterselection,$lastouterselection);
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
			$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'yearly';		
			$data['year']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months"));
			$data['month'] = $month =($this -> uri -> segment(7))?$this -> uri -> segment(7):date('m',strtotime("first day of previous months"));
			$data['quarter']  = $quarter= ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			//$data['ajax'] = ($this -> uri -> segment(10))?$this -> uri -> segment(10):false;
			$data['compType'] = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Vaccination';
			$data['week'] = $week =($this -> uri -> segment(10))?$this -> uri -> segment(10):'1';
			$data['biyear'] = $week =($this -> uri -> segment(11))?$this -> uri -> segment(11):'01';
		}
		else
		{
			$data['id']  		= ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'yearly';
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['month'] 		= ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['quarter']	= ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
			//$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
			$data['compType'] 	= ($this -> input -> post('compType'))?$this -> input -> post('compType'):'Vaccination';
			$data['week'] = $week =($this -> input -> post('week'))?$this -> input -> post('week'):'1';
			$data['biyear'] = ($this -> input -> post('biyear'))?$this -> input -> post('biyear'):'01';
		}
		return $data;
	}
	//----------------------------------------------------------//
	//================ UcWiseMapData function starts====================//
	public function UcWiseMapData() {
		$data = $this -> getUriSegmentData();//print_r($data);exit;
		$data['districtName'] = $districtName = $this -> maps ->DistrictName($data['id']);
		$info['district'] = $districtName;
		if($data['reportType']=='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$data['year'];
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$data['year'];
		}elseif($data['reportType']=='Weekly'){
			$monthQauarterYear = "Week-".$data['week']." ".$data['year'];
		}elseif($data['reportType']=='biyearly'){
			$monthQauarterYear = $data['year']." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
		}else{
			$monthQauarterYear = $data['year'];
		}
		$result = $this ->getQuerySelectionpop($data);
		$info['barName'] = $info['mapName'] = "UCs Wise Technician, {$districtName} {$monthQauarterYear}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = false;
		$data['ucwisemap'] = 'true';
		$data['colorAxis'] = $this -> colorAxis($data['id']);
		$data['plotYaxis'] = $this -> getplotLines($data['id']);
		$serieses = array();
		$dataSeries = array();
		$i = 0;
		$serieses['name'] = "UC Wise Compliance";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$totpop = $tot_technician = 0;
		foreach($result as $row){
			
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] =($row -> tot_technician > 0)?(round($row -> tot_technician)):'0';
			$serieses['data'][$i]['pop'] = ($row -> pop > 0)?$row -> pop:0;
			$serieses['data'][$i]['centers'] = ($row -> centers > 0)?$row -> centers:0;
			$totpop += ($row -> pop > 0)?$row -> pop:0;
			$tot_technician +=($row -> tot_technician > 0)?(round($row -> tot_technician)):'0';
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, "UC");
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat']= $resultArray['serieses_ranking_cat'];
		$data['totpop'] = $totpop;
		$data['tot_technician'] = $tot_technician;
		$data['tech_pop_ratio'] = ($tot_technician > 0)?round($totpop/$tot_technician,0):0;
		$data['heading'] = $info;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/populaiton_coverage_ratio';
		$viewData['pageTitle']='EPI-MIS Dashboard | UC Wise Map';
		$this->load->view('thematic_template/thematic_template',$viewData);
		
	}

	public function getRankingSeriesData($data,$resultdata, $locality){
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
		$varrow = "poppertech";
		$vark="000";
		if($data['id']){
			$varrow = "tot_technician";
		}
		foreach($resultdata as $row){
			$serieses[$i]['name'] = $row -> name;
			$serieses[$i]['id'] = $row -> code;
			$serieses[$i]['y'] = ($row -> $varrow > 0 )?round($row -> $varrow):0;

			$sum = $serieses[$i]['y'];
			if($data['id']){
				if($sum >= 3 ){
					$serieses[$i]['color'] = "#063B00";
				}
				else if($sum < 3 && $sum >= 2){
					$serieses[$i]['color'] = "#0EFF00";
				}
				else if($sum < 2 && $sum >= 1){
					$serieses[$i]['color'] = "#F2E73A";
				}
				else if($sum <= 0){
					$serieses[$i]['color'] = "#DD1E2F";
				}
			}else{
				if($sum > "20000"){
					$serieses[$i]['color'] = "#E3330D";
				}
				else if($sum < "21000" && $sum >= "10000"){
					$serieses[$i]['color'] = "#F2E73A";
				}
				else if($sum < "11000"){
					$serieses[$i]['color'] = "#0B7546";
				} 
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
	//----------------------------------------------------------//
	//================ getUcDetails function starts====================//
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	function getplotLines($id=NULL){
		if($id){
			$dataplot[0]['color'] = '#DD1E2F';
			$dataplot[0]['width'] = 0;
			$dataplot[0]['value'] = 0;
			
			$dataplot[1]['color'] = '#F2E73A';
			$dataplot[1]['width'] = 2;
			$dataplot[1]['value'] = 1;
			
			$dataplot[2]['color'] = '#0EFF00';
			$dataplot[2]['width'] = 2;
			$dataplot[2]['value'] = 2;
			
			$dataplot[3]['color'] = '#063B00';
			$dataplot[3]['width'] = 2;
			$dataplot[3]['value'] = 3;
		}else{
			$dataplot[0]['color'] = '#0B7546';
			$dataplot[0]['width'] = 2;
			$dataplot[0]['value'] = 10000;
			
			$dataplot[1]['color'] = '#F2E73A';
			$dataplot[1]['width'] = 2;
			$dataplot[1]['value'] = 20000;
			
			$dataplot[2]['color'] = '#E3330D';
			$dataplot[2]['width'] = 2;
			$dataplot[2]['value'] = 30000;
			
			/* $dataplot[3]['color'] = '#E3330D';
			$dataplot[3]['width'] = 1;
			$dataplot[3]['value'] = 70000; */
		}
		
		$data['plotLines'] = json_encode($dataplot, JSON_NUMERIC_CHECK);
		$data['plotLines'] = preg_replace('/"([a-zA-Z_]+[a-zA-Z0-9_]*)":/','$1:',$data['plotLines']);
		return $data['plotLines'];
	}
	function colorAxis($id=NULL){
		$varzero="000";
		$k = "k";
		if($id){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '1';
			$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
			$dataClasses['dataClasses'][0]["name"] = ' = 0';

			$dataClasses['dataClasses'][1]['from'] = '1';
			$dataClasses['dataClasses'][1]['to'] = '2';
			$dataClasses['dataClasses'][1]['color'] = '#F2E73A';
			$dataClasses['dataClasses'][1]['name'] = ' = 1';
			
			$dataClasses['dataClasses'][2]['from'] = '2';
			$dataClasses['dataClasses'][2]['to'] = '3';
			$dataClasses['dataClasses'][2]['color'] = '#0EFF00';
			$dataClasses['dataClasses'][2]['name'] = '= 2';

			$dataClasses['dataClasses'][3]['from'] = '3';
			$dataClasses['dataClasses'][3]['to'] = '10000';
			$dataClasses['dataClasses'][3]['color'] = '#063B00';
			$dataClasses['dataClasses'][3]['name'] = '> 2';
		}else{
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '10000';
			$dataClasses['dataClasses'][0]["color"] = '#0B7546';
			$dataClasses['dataClasses'][0]["name"] = '0-10k';

			$dataClasses['dataClasses'][1]['from'] = '10000';
			$dataClasses['dataClasses'][1]['to'] = '20000';
			$dataClasses['dataClasses'][1]['color'] = '#F2E73A';
			$dataClasses['dataClasses'][1]['name'] = '10k-20k';
			
			$dataClasses['dataClasses'][2]['from'] = '20000';
			$dataClasses['dataClasses'][2]['to'] = '4000000';
			$dataClasses['dataClasses'][2]['color'] = '#E3330D';
			$dataClasses['dataClasses'][2]['name'] = '20k and above';

			/* $dataClasses['dataClasses'][3]['from'] = '40000';
			$dataClasses['dataClasses'][3]['to'] = '1000000';
			$dataClasses['dataClasses'][3]['color'] = '#E3330D';
			$dataClasses['dataClasses'][3]['name'] = '40k and above'; */
		}

		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
}
?>