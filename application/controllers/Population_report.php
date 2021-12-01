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
		$functionName = str_replace("_Filters", "_Report", $functionName);
		$reportPath = base_url()."Population_report/vf_population_report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportsperiod=array("cryearly"),false,NULL,NULL,'No','No',NULL);
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
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "Population_Report":
			$title = "Village and HF Based population";
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