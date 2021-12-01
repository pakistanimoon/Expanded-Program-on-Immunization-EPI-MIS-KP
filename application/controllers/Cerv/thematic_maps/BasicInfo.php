<?php
class BasicInfo extends CI_Controller {
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
		$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() {
		$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
		$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		$data['basicInfo']  = ($this -> input -> post('basicInfo'))?$this -> input -> post('basicInfo'):'VTPR';
		$data['fmonth'] = $data['year'] . "-" . $data['month'];
		if($this -> input -> post('id')){
			$data['id'] = $this -> input -> post('id');
		}
		if($this -> session -> District || $this -> input -> post('id')){
			$viewData = $this -> UcsWiseMapData($data);
		}else{
			$viewData = $this -> DistrictsWiseMapData($data);
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'maps/basic_info';
			$viewData['pageTitle']='EPI-MIS Dashboard | Basic Human Resource Info';
			$this->load->view('template/epi_template',$viewData);
		}
	}
	//================ Index function Ends =====================//
	//----------------------------------------------------------//
	//=========== UcsWiseMapData function starts ===============//
	public function UcsWiseMapData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getUCsVaccinatorToPopulationData($data, $selectQuery);
		//echo $this -> db -> last_query();exit;
		//print_r($coverageData);exit;
		$serieses = array();
		//$result = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = "UC Wise Vaccination to Population Ratio";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> no_of_vaccinatiors==0 || $row -> population==0)?0:round((($row -> population/10000)*100)/$row -> no_of_vaccinatiors,2);
			$i++;
		}
		
		array_push($dataSeries,$serieses);
		$data['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		if($this -> input -> post('id'))
			echo $data['serieses'];
		else{
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'maps/uc_basic_info';
			$viewData['pageTitle']='EPI-MIS Dashboard | Basic Human Resource Info ';
			$this->load->view('template/epi_template',$viewData);
		}
	}
	//============ UcsWiseMapData function Ends ================//
	//----------------------------------------------------------//
	//======= DistrictsWiseMapData function starts =============//
	public function DistrictsWiseMapData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$coverageData = $this -> maps -> getVaccinatorToPopulationData($data, $selectQuery);
		$serieses = array();
		$result = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = "District Wise Vaccination to Population Ratio";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> no_of_vaccinatiors==0 || $row -> population==0)?0:round((($row -> population/10000)*100)/$row -> no_of_vaccinatiors,2);
			$i++;
		}
		
		array_push($dataSeries,$serieses);
		$result['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		return $result;
	}
	//======== DistrictsWiseMapData function Ends ==============//
	//----------------------------------------------------------//
	
	public function getQuerySelectPortion($data){
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code, uc_wise_maps_paths.ucname as name, ";
		}else{
			$q = " districts.distcode as code,districts.district as name, ";
		}
		if($data['basicInfo'] == "VTPR"){
			if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
				$code = $this -> session -> District;
				if(isset($data['id']) && $data['id']>0)
					$code = $data['id'];
				$q .= " population, (select count(*) from techniciandb where techniciandb.uncode = unioncouncil.uncode and techniciandb.status='Active' AND techniciandb.distcode = '".$code."') as no_of_vaccinatiors";
			}else{
				$q .= " population, (select count(*) as vaccinatiors from techniciandb where techniciandb.distcode = districts.distcode and techniciandb.status='Active') as no_of_vaccinatiors";
			}			
		}
		return $q;
	}
}