<?php 
	class Population_report extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		
		$this -> load -> model('Compliances_model');
		$this -> load -> model('Population_reportmodel');
		$this -> load -> helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
		$this -> load -> model('Common_model');
		$this -> load -> model('Filter_model');
		$this->load->helper('my_functions_helper');
		$this -> load -> helper('epi_reports_helper');
	}
	public function population_Filters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		//print_r($functionName);exit;
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Population_report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($this -> session -> UserLevel == '4'){
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,$reportsperiod=array("yearly"),false,NULL,NULL,'No','No',NULL);
		}else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportsperiod=array("yearly"),false,NULL,NULL,'No','No',NULL);
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'Population_Reports_filter';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function vf_population_report(){
		$data = $this -> getPostedData();
		if(isset($data['distcode']))
			$dist = $data['distcode'];
		else 
		$dist = '';
		$year = $data['year'];
		$data['data'] = $this ->Population_reportmodel->vf_population_report($data);
		$data['distcode'] = $dist;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("HF and Village Population_Report", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Population_Reports_views';
		$data['pageTitle']='Village and HF Based population';
		$this -> load -> view('template/reports_template',$data);
	}
	
	function village_population_not_set(){
		//print_r('asd');exit;
		$year = $this->input->get_post('year');
		$data = $this -> getPostedData();
		if(isset($data['distcode']))
			$dist = $data['distcode'];
		//print_r($dist);exit;
		else 
		$dist = '';
		$year = $data['year'];
		//print_r($year);exit;
		$data['data'] = $this ->Population_reportmodel->village_population_not_set($data);
		$data['distcode'] = $dist;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("UC`s with no Village/Mohalla/Population", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'villages/reports/Village_Population_Not_Set_View';
		$data['pageTitle']='UC`s with no Village/Mohalla/Population';
		$this -> load -> view('template/reports_template',$data);
	}
	function village_population_not_set_uc(){
		$year = $this->input->get_post('year');
		$tcode = $this->input->get_post('tcode');
		$distcode=$this -> session -> District;
		//print_r($distcode);exit;
		/*print_r($year);exit; */
		$data['data'] = $this ->Population_reportmodel->village_population_not_set_uc($tcode,$year);
		$data['tcode'] = $tcode;
		$data['distcode'] = $distcode;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("UC`s with no Village/Mohalla/Population", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'villages/reports/Village_Population_Not_Set_Uc_View';
		$data['pageTitle']='Village/Mohalla Population Not Set ';
		$this -> load -> view('template/reports_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "vf_population_report":
			$title = "Village and HF Based population";
			break;
			case "village_population_not_set":
			$title = " UC`s with no Village/Mohalla/Population ";
			break;
		}
		return $title;
	}
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value){
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format){
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}else{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
	}
}