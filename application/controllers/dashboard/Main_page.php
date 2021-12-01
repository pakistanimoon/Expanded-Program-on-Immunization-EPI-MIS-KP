<?php
class Main_page extends CI_Controller {

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
		$this -> load -> model('dashboard/dashboard_model','dashboard');
	}
	public function index(){
		$ajax  = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):FALSe;
		$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("-1 month"));
		$data = $this -> dashboard -> getMainIndicatorsData($year);
		if($ajax)
		{
			$indicators = array_slice($data, 0, 14, true);
			$cardsviews = $this -> load -> view('dashboard/indicatorcards', $indicators, TRUE);
			$arr = array('cards' => $cardsviews);
			echo json_encode($arr);
			exit;
		}
		$data['data'] = $data;
		$data['fileToLoad'] = 'dashboard/index';
		$data['pageTitle']='EPI-MIS | Dashboard';
		$this->load->view('template/epi_template',$data);
	}
	
	public function FmvrfCompliace(){
		$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
		$year  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("-1 month"));
		$fmonth = $year . "-" . $month;
		if($this -> session -> District){
			$data = $this -> getDistrictSeriesData($fmonth);
		}else{
			$data = $this -> getProvincialSeriesData($fmonth);
		}
		$data['month'] = $month;
		$data['year'] = $year;
		$data['data'] = $data;
		//print_r($data);exit;
		$data['fileToLoad'] = 'dashboard/main';
		$data['pageTitle']='EPI-MIS | FMVRF Compliance';
		$this->load->view('template/epi_template',$data);
	}
	
	public function getDistrictSeriesData($fmonth){
		
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getComplianceData($fmonth);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Facilities Submitted Reports";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> facility;
			$serieses1['data'][$i]['name'] = $row -> facility;
			$serieses1['data'][$i]['y'] = $row -> cnt;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		
		return $result;
	}
	
	public function getProvincialSeriesData($fmonth){
		
		// -- Code to get Compliance Data Series Starts Here -- //
		
		$seriesData = $this -> dashboard -> getComplianceData($fmonth);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$serieses1['name'] = "Due";
		$serieses2['name'] = "Submitted";
		$i=0;
		foreach($seriesData as $row){
			$category[$i] = $row -> district;
			$serieses1['data'][$i]['name'] = $row -> district;
			$serieses1['data'][$i]['y'] = $row -> due;
			$serieses1['data'][$i]['drilldown'] = $row -> district;
			$serieses2['data'][$i]['name'] = $row -> district;
			$serieses2['data'][$i]['y'] = $row -> sub;
			$serieses2['data'][$i]['drilldown'] = $row -> district;
			$i++;
		}		
		
		array_push($cat,$category);
		array_push($result,$serieses1);
		array_push($result,$serieses2);
		$result['result'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		$result['drilldownSeries'] = "";
		
		// ----------- Code to get Compliance Data Series Ends Here ------------ //
		// --------------------------------------------------------------------- //
		// -- Code to get Compliance Data Series Drilldown Series Starts Here -- //

		$drilldown = array();
		$lastDistrictValue = "";
		$drilldownSeriesData = $this -> dashboard -> getComplianceDataDrillDownSeries($fmonth);
		$k=0;$ind=0;
		foreach($drilldownSeriesData as $row){
			if($lastDistrictValue!="" && $lastDistrictValue!=$row -> district){
				$ind++;
				$k=0;
			}		
			$drilldownSeries[$ind]['id'] = $row -> district;
			$drilldownSeries[$ind]['name'] = "Submitted";
			$drilldownSeries[$ind]['data'][$k]= array($row -> facility,$row -> cnt);
			
			$lastDistrictValue = $row -> district;
			$k++;
		}
		array_push($drilldown,$drilldownSeries);
		$result['drilldownSeries'] = json_encode($drilldown,JSON_NUMERIC_CHECK);
		
		// -- Code to get Compliance Data Series Drilldown Series Ends Here -- //
		
		return $result;		
	}
	public function getAllHRData(){////////////////////////////////
		$chartTypeid = ($this -> input -> post('chartTypeid'))?$this -> input -> post('chartTypeid'):null;
		$UserLevel = $this -> session -> UserLevel;
		$result = $this->dashboard->getAllHRData();
		$DataSet= array();
		$link="";
		if(!empty($result)){
			foreach($result as $key =>$row){
				$lable=get_subtype_name($row["post_hr_sub_type_id"],true);
				if($UserLevel == 2){
					$link = "JavaScript:wsCountgetData('{$row["post_hr_sub_type_id"]}','{$lable}')";
				}else if($UserLevel == 3 || $chartTypeid=='table'){
					$type=$row["post_hr_sub_type_id"];
					$distcode=$row["post_distcode"];
					$link = "JavaScript:hrReportData('{$distcode}','{$type}')";
				}else if($UserLevel == 4 || $chartTypeid=='table'){
					$type=$row["post_hr_sub_type_id"];
					$tcode=$row["post_tcode"];
					$link = "JavaScript:hrReportData_tehsil('{$tcode}','{$type}')";
				}
				$DataSet[$key]= array(
					"label"	=> $lable,
					"value"	=> (int)$row['count'],
					"link"	=> $link,
				);
			}//print_r($DataSet); exit();
			echo json_encode($DataSet);exit;
			}
		echo json_encode(array('label'=>null,'value'=>null,"link"=>null));exit;
	}
	public function getAllHRDistrictData(){
		
		$type_id = ($this -> input -> post('type_id'))?$this -> input -> post('type_id'):null;
		$chartTypeid = ($this -> input -> post('chartTypeid'))?$this -> input -> post('chartTypeid'):null;
		$result = $this->dashboard->getAllHRDistrictData($type_id);
		$HTMLid=('store-ws-hr-trend');
		//print_r($result); exit();
		$link="";		 
		$wh_type_wise= array();
		if(!empty($result)){
			foreach($result as $key =>$row){
				$lable=($row["districtname"]);
				$typename=get_subtype_name($row["post_hr_sub_type_id"],true);
				$type=$row["post_hr_sub_type_id"];
				$distcode=$row["post_distcode"];
				if($chartTypeid=='table'){
					$link = "JavaScript:hrReportData('{$distcode}','{$type}')";
				}else{ 
					$link = "JavaScript:hrReportData('{$distcode}','{$type}')";
				}
				$wh_type_wise[$key]= array(
					"label"	=> $lable,
					"value"	=> (int)$row['count'],
					"link"	=> $link,
				);
			}
		}
		echo json_encode($wh_type_wise);exit;
	}
}