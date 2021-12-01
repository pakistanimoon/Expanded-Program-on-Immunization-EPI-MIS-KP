<?php
class Indicator extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Indicator_reports_model');
		$this -> load -> helper('epi_functions_helper');
		authentication();
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function index(){
		$this -> load -> library('reportfilters');
		//$reportPeriod = array('yearly','monthly_last');
		//$functionName = $this -> uri -> segment (3);

		//if($functionName == 'Vaccine'){
			$reportPeriod = array('month-from-to-previous');
		//}
		//$reportPath = base_url()."Indicator-Report/".$functionName;
		$reportPath = base_url()."consumption/reports/indicator/preview";
		$reportTitle = 'Consumption Indicator Report';
		$indicators = 'Vaccine';//$functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,$indicators);
		//print_r($dataHtml);exit;
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		//$data['edit'] = "Yes";
		$data['fileToLoad'] = 'consumption/reports/indicator/filters';
		$data['pageTitle']='Consumption Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	/* function customizereportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','monthly_last');//'monthly'
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Indicator-Report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,$indicators);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'indicator_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
	} */

	/* function HFMVRF(){		
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		$data = $this -> getPostedData();
		$dataHFMVRF['data'] = $this -> Indicator_reports_model -> HFMVRF($data,$wc);
		$dataHFMVRF['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Indicator report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	} */
	function preview($distcode=NULL, $monthfrom=NULL, $monthto=NULL, $indicator=NULL, $vacc_ind=NULL)
	{
		$wc = array();
		if($distcode AND $monthfrom AND $monthto AND $indicator AND $vacc_ind)
		{
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'vacc_ind' => $vacc_ind);
			//$wc = getWC_Array($_SESSION["Province"],$distcode);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			//$wc = getWC_Array($_SESSION["Province"],$distcode);
			$data = $this -> getPostedData();
			unset($data['export_excel']);
			unset($data['_ga']);
			unset($data['_gid']);
			unset($data['ci_session']);
			unset($data['_gat']);
		}
		if($this -> input -> post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPI_Vaccine_Indicator_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$result = $this -> Indicator_reports_model -> consumptionIndicator($data);
		if(isset($data['vacc_ind']) && is_array($data['vacc_ind']) && count($data['vacc_ind'])>1){
			unset($data['vacc_ind']);
		}
		$title = "Consumption Indicator Report";
		$dataToReturn['data']['result'] = $result;
		$dataToReturn['data']['exportIcons'] = exportIcons($_REQUEST);
		$dataToReturn['data']['TopInfo'] = reportsTopInfo($title, $data);	
		$dataToReturn['data']['subtitle'] = $title;
		$dataToReturn['fileToLoad'] = 'consumption/reports/indicator/preview';
		$dataToReturn['pageTitle']='EPI-MIS | Consumption Indicator Report';
		$this->load->view('template/reports_template',$dataToReturn);
	}
	/* function Disease($distcode=NULL, $year=NULL, $month=NULL, $indicator=NULL){
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
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,true,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
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
		}
		//print_r($data);exit;
		$data['procode'] = $_SESSION["Province"];
		//echo $data['indicator']; exit;
		if($data['indicator_type'] == "Mortality")
		{
			$data['data'] = $this -> Indicator_reports_model -> highest_morbidity($data);
			//echo '<pre>'; print_r($data['data']); exit;
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
	} */
	//========Function to create Priority Diseases Under Surveillance Reports==========//
	function getPostedData(){
		$data=array();
		//$dataPosted=array();
		//$dataPosted = $_POST;
		$dataPosted = $this->input->post();
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			if(strpos("date",$key)!==FALSE){
				foreach ($formats as $format)
				{
					$date = DateTime::createFromFormat($format, $data[$key]);
					if ($date == false || !(date_format($date,$format) == $data[$key]) ){}else{
						$data[$key] = date("Y-m-d",strtotime($data[$key]));
					}
				}
			}
			if($data[$key] == NULL || $data[$key]=="0"){
				unset($data[$key]);
			}
		}
		return $data;
	}
}
?>