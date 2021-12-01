<?php
class CervReportsDaily extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('Cerv_reports_model_daily');
		
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('specific_date');
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."CervReportsDaily/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$customDropDown = array(
			array(
				'0' => 'Vaccinator', // Custom Drop Down Name Should be in this format
				'class' => 'vaccinator hide'
			)
		);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'cervReports/reports_filters';
		$data['pageTitle']='CERV Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "CERV_PVR":
				$title = "CERV | Permanent Vaccination Register";
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
	
	function CERV_PVR(){		
		$data = $this -> getPostedData();
		//print_r($data); exit;
		$dataPVR['data'] = $this -> Cerv_reports_model_daily -> CERV_PVR($data);
		$dataPVR['fileToLoad'] 	= 'cervReports/daily_vaccination_register_view';
		$dataPVR['pageTitle']	='CERV | Permanent Vaccination Register';
		$this->load->view('template/reports_template',$dataPVR);
	}
	
}