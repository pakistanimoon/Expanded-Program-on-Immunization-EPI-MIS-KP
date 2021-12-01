<?php
class Other_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('other_reports_model');
		$this -> load -> helper('epi_functions_helper');
		authentication();
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','monthly');
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Surveillance/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($functionName == 'EPID'){
			$customDropDown = array(
				array(
					'0' => 'Disease', // Custom Drop Down Name Should be in this format
					'all' => 'All Diseases',
					'measles' => 'Measles',
					'afp' => 'Acute Flacid Pralysis',
					//'nnt' => 'NNT',
					'diphtheria' => 'Diphtheria',
					'pertussis' => 'Pertussis',
					'pneumonia' => 'Pneumonia',
					'childhood tb' => 'Childhood TB',
					'meningitis' => 'Meningitis',
					'hepatitis' => 'Hepatitis'
				),
				array(
					'0' => 'Report Type', // Custom Drop Down Name Should be in this format
					'wgender' => 'Weekly Gender Wise',
					'mgender' => 'Monthly Gender Wise',
					'wage' => 'Weekly Age Wise',
					'mage' => 'Monthly Age Wise'
				)
			);
			$reportPeriod = array('month-from-to');
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}elseif($functionName == 'OUTBREAK'){
			$customDropDown = array(
				array(
					'0' => 'Disease', // Custom Drop Down Name Should be in this format
					'measles' => 'Measles',
					'afp' => 'Acute Flacid Pralysis',
					//'nnt' => 'NNT',
					'diphtheria' => 'Diphtheria',
					'pertussis' => 'Pertussis',
					'pneumonia' => 'Pneumonia',
					'childhood tb' => 'Childhood TB',
					'meningitis' => 'Meningitis',
					'hepatitis' => 'Hepatitis'
				)
			);
			$reportPeriod = array('cryearly');
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}
		else if($functionName == 'VPD'){
			$customDropDown = array(
				array(
					'0' => 'Report Type', // Custom Drop Down Name Should be in this format
					'wwise' => 'Week Wise',
					'mwise' => 'Month Wise',
					'dwise' => 'District Wise',
					'fwise' => 'Facility Wise'
				)
			);
			$reportPeriod = array('cryearly','weekly','dates');
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}else
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'other_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Monthly Surveillance Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "MSR":
				$title = "Monthly Surveillance Report";
				break;
			case "EPID":
				$title = "Age/Gender Wise Count of EPID";
				break;
			case "VPD":
				$title = "Weekly/Monthly/District Wise VPD";
				break;
			case "OUTBREAK":
				$title = "Disease Outbreak Report";
				break;
		}
		return $title;
	}
	function disease_outbreak($distcode=NULL, $year=NULL, $disease=NULL)
	{
		if($distcode AND $year AND $disease)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'disease' => $disease);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}
		$dataMSR['data'] = $this->other_reports_model->disease_outbreak($data);
	//	print_r($dataMSR);exit;
		$dataMSR['fileToLoad'] = 'other_reports/outbreak_report';
		$dataMSR['pageTitle']='EPI-MIS | Age/Gender Wise Count of EPID';
		$this->load->view('template/reports_template',$dataMSR);
		//template_loader('other_reports/outbreak_report', $dataMSR, array($this->_module), 'reports');
	}
	function MSR(){
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$data = $this -> getPostedData();
		$dataMSR['data'] = $this -> other_reports_model -> MSR($data);
		$dataMSR['fileToLoad'] = 'other_reports/surveillance_report_view';
		$dataMSR['pageTitle']='EPI-MIS | Monthly Surveillance Report';
		$this->load->view('template/reports_template',$dataMSR);
	}
	function EPID_Count(){
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$data = $this -> getPostedData();
		$dataMSR['data'] = $this -> other_reports_model -> EPID($data);
		$dataMSR['fileToLoad'] = 'other_reports/epid_count_report_view';
		$dataMSR['pageTitle']='EPI-MIS | Age/Gender Wise Case Count';
		$this->load->view('template/reports_template',$dataMSR);
	}
	function VPD_Count($distcode=NULL, $year=NULL, $report_type=NULL, $week=NULL)
	{ 
		if($distcode AND $year AND $report_type)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'report_type' => $report_type);
			if($week AND $week > 0){
				$data['week'] = $week;
			}
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}
		$dataMSR['data'] = $this->other_reports_model->VPD($data);
		//echo '<pre>'; print_r($dataMSR); exit;
		$dataMSR['fileToLoad'] = 'other_reports/vpd_count_report_view';
		$dataMSR['pageTitle']='EPI-MIS | Weekly/Monthly/District Wise VPD';
		$this->load->view('template/reports_template',$dataMSR);
		//template_loader('other_reports/vpd_count_report_view', $dataMSR, array($this->_module), 'reports');
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