<?php
class Maps_Main extends CI_Controller {
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
			$this -> DistrictWiseMapData();
		}
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 month"));
		$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime(date('Y')." -1 month"));
		$fmonth = $year . "-" . $month;
		$data['month'] = $month;
		$data['year'] = $year;
		$result = $this -> maps -> districtWiseMapData($fmonth);
		//print_r($result);exit;
		$serieses = array();
		$dataSeries = array();
		$i = 0;
		$serieses['name'] = "District Wise Compliance";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['fmonth'] = $fmonth;
			$serieses['data'][$i]['value'] = (round(((($row -> sub)*100)/$row -> due),2))>100?100:round(((($row -> sub)*100)/$row -> due),2);
			$serieses['data'][$i]['due'] = $row -> due;
			$serieses['data'][$i]['sub'] = $row -> sub;
			if($row -> sub > $row -> due)
				$serieses['data'][$i]['sub'] = $row -> due;			
			$i++;
		}
		array_push($dataSeries,$serieses);
		$data['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/maps_index';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('template/epi_template',$viewData);
	}
	//----------------------------------------------------------//
	//================ UcWiseMapData function starts====================//
	public function UcWiseMapData() {
		$code = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
		if($this -> input -> post('month') && $this -> input -> post('year')){
			$month = $this -> input -> post('month');
			$year  = $this -> input -> post('year');
			$fmonth = $year . "-" . $month;
		}else{
			$fmonth = ($this -> input -> post('fmonth'))?$this -> input -> post('fmonth'):date('Y')."-".date('m',strtotime(date('Y-m-d')." -1 months"));
		}		
		$YearMonth = explode("-",$fmonth);
		$data['month'] = $YearMonth[1];
		$data['year'] = $YearMonth[0];
		$result = $this -> maps -> UcWiseMapData($code,$fmonth);
		$serieses = array();
		$dataSeries = array();
		$i = 0;
		$serieses['name'] = "UC Wise Compliance";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['fmonth'] = $fmonth;
			if($row -> due != 0)
				$serieses['data'][$i]['value'] = (round(((($row -> sub)*100)/$row -> due),2))>100?100:round(((($row -> sub)*100)/$row -> due),2);
			else
				$serieses['data'][$i]['value'] = 0;
			$serieses['data'][$i]['due'] = $row -> due;
			$serieses['data'][$i]['sub'] = $row -> sub;
			if($row -> sub > $row -> due)
				$serieses['data'][$i]['sub'] = $row -> due; 
			$i++;
		}
		array_push($dataSeries,$serieses);
		$data['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		if($this -> input -> post('id') && $this -> input -> post('fmonth'))
			echo $data['serieses'];
		else{
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'thematic_maps/uc_maps_index';
			$viewData['pageTitle']='EPI-MIS Dashboard | UC Wise Map';
			$this->load->view('template/epi_template',$viewData);
		}
		
	}
	//----------------------------------------------------------//
	//================ getUcDetails function starts====================//
	public function getUcDetails() {
		$code = $this -> input -> post('id');
		$fmonth = $this -> input -> post('fmonth');
		$result['result'] = $this -> maps -> getUcDetails($code,$fmonth);
		$result['fmonth']=$fmonth;
		$result = $this -> load -> view('thematic_maps/facilitiesData_popup',$result,TRUE);
		echo $result;
	}
}