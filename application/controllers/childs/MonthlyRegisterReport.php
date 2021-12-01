<?php
class MonthlyRegisterReport extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');		
		authentication();
		$this -> load -> model('Monthly_register_model');
		
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('specific_date');//print_r('kk'); exit;
		$functionName = $this -> uri -> segment (2);
		$reportPath = base_url()."childs/MonthlyRegisterReport/monthly_report";
		//$reportTitle = $this->reportTitle($functionName);
		$reportTitle = "Monthly Register Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,NULL,NULL,'No','No',NULL);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Monthly Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	
	  function daily_report(){		
		$data = $this -> getPostedData();
	    //print_r($data); exit;
		$dataPVR['data'] = $this -> Monthly_register_model -> monthly_report($data);
		$dataPVR['fileToLoad'] 	= 'childs/monthly_register_view';
		$dataPVR['pageTitle']	='EPI-MIS | Monthly Vaccination Register Report';
		$this->load->view('template/reports_template',$dataPVR);
	}  
	 function monthly_report(){
		$data = $this -> getPostedData();
	    //print_r($data); exit;
		$dataPVR['data'] = $this -> Monthly_register_model -> monthly_report($data);//print_r($dataPVR); exit;
		$dataPVR['fileToLoad'] 	= 'childs/Monthly_register_view';
		$dataPVR['pageTitle']	='EPI-MIS | Monthly Vaccination Register Report';
		$this->load->view('template/reports_template',$dataPVR);
	} 
/*	function getMonth(){
			$next_month_ts = strtotime('2019-04 +1 month');
			$prev_month_ts = strtotime('2019-04 -1 month');

			$next_month = date('Y-m', $next_month_ts);
			$prev_month = date('Y-m', $prev_month_ts);
			$nmonth = $next_month;
			$pmonth = $prev_month;
	}	*/
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y","mm-yyyy","yyyy-mm");
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