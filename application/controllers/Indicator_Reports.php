<?php
//KP
class Indicator_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Indicator_reports_model');
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
		authentication();
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','monthly_last');//'monthly'
		$functionName = $this -> uri -> segment (3);

		if($functionName == 'Vaccine'){
			//$reportPeriod = array('yearly','monthly_current');//'monthly'
			$reportPeriod = array('month-from-to-previous');
		}
//if($functionName == )
		//print_r($reportPeriod);exit;
		$reportPath = base_url()."Indicator-Report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,$indicators);
		$dataHtml .= $this->reportfilters->filtersFooter();
		//print_r($dataHtml);exit;
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'indicator_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function customizereportFilters(){
		//print_r($_POST);exit();		
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','monthly_last');//'monthly'
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Indicator-Report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($this->session->UserLevel==4){
			$dataHtml .= $this->reportfilters->createReportFilters(false,true,false,false,$reportPeriod,false,$indicators);
		}else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,$indicators);
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'indicator_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}

	function HFMVRF(){		
  
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		$data = $this -> getPostedData();
		$dataHFMVRF['data'] = $this -> Indicator_reports_model -> HFMVRF($data,$wc);
		$dataHFMVRF['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Indicator report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	}
	function Vaccine($distcode=NULL, $monthfrom=NULL, $monthto=NULL, $indicator=NULL, $vacc_ind=NULL)
	{
		if($distcode AND $monthfrom AND $monthto AND $indicator AND $vacc_ind)
		{
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'vacc_ind' => $vacc_ind);
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
			$data = $this -> getPostedData();
			unset($data['export_excel']);unset($data['_ga']);
			unset($data['_gid']);unset($data['ci_session']);
			unset($data['_gat']);
		}
		$dataHFMVRF['data'] = $this -> Indicator_reports_model -> Vaccine($data,$wc);
		$dataHFMVRF['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Vaccination Indicator report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	}
	function Disease($distcode=NULL, $year=NULL, $month=NULL, $indicator=NULL){
		//print_r($_POST);exit();
		if($distcode AND $year AND $month AND $indicator)
		{ 
			$data = array('distcode' => $distcode, 'year' => $year, 'month' => $month, 'indicator' => $indicator);
			if($month == 13)
			{
				unset($data['month']);
			}
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
			$data = $this -> getPostedData();
		}
		$dataHFMVRF['data'] = $this -> Indicator_reports_model -> Disease($data,$wc);
		$dataHFMVRF['fileToLoad'] = 'indicator_reports/disease_indicator_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Disease Surveillance Indicator report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	}
	function Disease_Drilldown(){
		$distcode = $this -> uri -> segment(3);
		$indicator = $this -> uri -> segment(4);
		$year = $this -> uri -> segment(5);
		if($this -> uri -> segment(6)){
			$month = $this -> uri -> segment(6);
		}
		else{
			$month = 13;
		}
		//echo $distcode; echo ' '; echo $indicator; echo ' '; echo $year; echo ' '; echo $month; echo ' ';		
		if($distcode AND $year AND $month AND $indicator)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'month' => $month, 'indicator' => $indicator);
			if($month == 13)
			{
				unset($data['month']);
			}
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
			$data = $this -> getPostedData();
		}

		$dataHFMVRF['data'] = $this -> Indicator_reports_model -> Disease($data,$wc);
		$dataHFMVRF['fileToLoad'] = 'indicator_reports/disease_indicator_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Disease Surveillance Indicator report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	}
	//======= Function to Create Filters for IDSRS Reports Starts Here ===========//
	function idsrsReportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('year','from_week','to_week');
		$functionName = $this -> uri -> segment (3);
		$functionName = str_replace("_", "-", $functionName);
//echo $functionName; exit;
		$reportPath = base_url()."Indicator-Report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$customDropDown = array(
				array(
					'0' => 'Indicator Type', // Custom Drop Down Name Should be in this format
					'Morbidity' => 'Morbidity',
					'Mortality' => 'Mortality',
				)
			);
		//$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,true,$reportPeriod,false,'');
		if($this->session->UserLevel==4){
			$dataHtml .= $this->reportfilters->createReportFilters(false,true,false,true,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,true,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}
		//$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,true,$reportPeriod,false,NULL,NULL,'No','No',NULL);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data; 

		$data['fileToLoad'] = 'indicator_reports/idsrs/idsrs_reports_filters';
		$data['pageTitle']='EPI-MIS Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
  
  
  
	}
	//========Function to create Priority Diseases Under Surveillance Reports==========//
	function priority_diseases($disease=NULL, $distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL, $indicator=NULL ){
		
		if($disease && $distcode && $year && $from_week && $to_week && $indicator ) {			
   
			$data = array("distcode"=>$distcode, "id" => $disease , "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week,"indicator_type"=>$indicator );
		}else if($disease && $year && $from_week && $to_week && $indicator) {			
   
			$data = array("id" => $disease , "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week, "indicator_type"=>$indicator);
		}else if($disease && $distcode && $year && $indicator){			
   
			$data = array("distcode"=>$distcode, "id" => $disease , "year"=>$year, "indicator_type"=>$indicator);
		}else if($disease && $year && $indicator) {			
   
			$data = array("id" => $disease , "year"=>$year, "indicator_type"=>$indicator);
		}
		else{			
   
			$data = $this -> getPostedData();
			//print_r($data);exit;
		}
		$data['procode'] = $_SESSION["Province"];
		if(isset($data['indicator_type']) && $data['indicator_type'] == "Mortality")
		{
			//print_r($data);exit;
			$data['data'] = $this -> Indicator_reports_model -> highest_morbidity($data);
			$data['edit'] = "Yes";
			if($data != 0){
				$data['fileToLoad'] = 'indicator_reports/idsrs/priority_diseases_view';
				$data['pageTitle']='EPI-MIS | IDSRS Indicator Report';
				$this->load->view('template/reports_template',$data);
			}else{
				$data['message']="You must have rights to access this page.";
				$this->load->view("message",$data);
			}
		}
		else{
				$data['data'] = $this -> Indicator_reports_model -> Priority_diseases($data);
				$data['edit'] = "Yes";
				if($data != 0){
					$data['fileToLoad'] = 'indicator_reports/idsrs/highest_morbidity_view';
					$data['pageTitle']='EPI-MIS | IDSRS Indicator Report';
					$this->load->view('template/reports_template',$data);
				}else{
					$data['message']="You must have rights to access this page.";
					$this->load->view("message",$data);
				}
			}
	}
																					  
	
 
	//========Function to create Priority Diseases Under Surveillance Reports==========//
	function morbidity($disease=NULL, $distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		
		if($disease && $distcode && $year && $from_week && $to_week) {
			
			$data = array("distcode"=>$distcode, "id" => $disease , "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else if($disease && $year && $from_week && $to_week) {
			
			$data = array("id" => $disease , "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else if($disease && $distcode && $year ){
			
			$data = array("distcode"=>$distcode, "id" => $disease , "year"=>$year);
		}else if($disease && $year ) {
			
			$data = array("id" => $disease , "year"=>$year);
		}
		else{
   
			$data = $this -> getPostedData();
		}
		$data['procode'] = $_SESSION["Province"];
		$data['data'] = $this -> Indicator_reports_model -> highest_morbidity($data);
		$data['edit'] = "Yes";
		if($data != 0){
			$data['fileToLoad'] = 'indicator_reports/idsrs/highest_morbidity_view';
			$data['pageTitle']='EPI-MIS | IDSRS Indicator Report';
			$this->load->view('template/reports_template',$data);
        }else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}
	//========Function to create Priority Diseases Under Surveillance Reports==========//
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "HFMVRF":
				$title = "Indicator Report";
				break;
			case "Disease":
				$title = "EPI Disease Surveillance Indicator Report";
				break;
			case "Vaccine":
				$title = "EPI Vaccine Indicator Report";
				break;
			case "morbidity":
				$title = "Diseases with High Rate of Mortality";
				break;
			case "priority-diseases":
				$title = "Diseases with High Rate of Morbidity";
				break;
		}
		return $title;
	}
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
	}
}
?>