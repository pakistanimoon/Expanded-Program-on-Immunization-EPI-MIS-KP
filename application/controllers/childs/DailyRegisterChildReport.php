<?php
class DailyRegisterChildReport extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
		authentication();
		$this -> load -> model('Daily_register_model'); 
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
			$this -> load -> library('reportfilters');
			$reportPeriod = array('specific_month');
			$functionName = $this -> uri -> segment (2);
			if($functionName == "DataEntry"){
				$reportPeriod = array('specific_date');
				$reportPath = base_url()."childs/DailyRegisterChildReport/dataentry_report";										 
				$reportTitle = "Data Entry Report";
				$customDropDown = array(
					array(
						'0' => 'Report Type', // Custom Drop Down Name Should be in this format
						'class' => 'total',
						'1' => 'Day Wise',
						'2' => 'Total',
					)
				);
				$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
				$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown,'No',false);
				$dataHtml .= $this->reportfilters->filtersFooter();
				$data['listing_filters'] = $dataHtml;
				//print_r($data);exit;
				$data['data']=$data;
				$data['edit'] = "Yes";
				$data['fileToLoad'] = 'reports/reports_filters';
				$data['pageTitle']='EPI-MIS Daily Report Filters';
				$this -> load -> view('template/epi_template',$data);
			}else{
				//print_r($functionName);exit;
				$reportPath = base_url()."childs/DailyRegisterChildReport/monthly_report";
				$reportTitle = "Daily Register Report";
				$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
				$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,true,NULL,NULL,'No','No',NULL,NULL,'No',true);
				$dataHtml .= $this->reportfilters->filtersFooter();
				$data['listing_filters'] = $dataHtml;
				$data['data']=$data;
				$data['edit'] = "Yes";
				$data['fileToLoad'] = 'reports/reports_filters';
				$data['pageTitle']='EPI-MIS Daily Report Filters';
				$this -> load -> view('template/epi_template',$data);
			}
	}
	public function monthly_report(){
		$data= $this-> getPostedData();
		if(isset($data['reportType']) && $data['reportType'] == '0'){
			$data= $this-> getPostedData();
			$data['data'] = $this -> Daily_register_model -> monthly_report($data);
			$data['fileToLoad'] 	= 'childs/Monthly_register_view';
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);
		}
		elseif(isset($data['reportType']) && $data['reportType'] == 'flcf'){
			$data= $this-> getPostedData();
			$data['data'] = $this -> Daily_register_model -> monthly_report_facility_wise($data);
			$data['fileToLoad'] 	= 'childs/Monthly_register_view_facility_wise';
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);
		}
		elseif(isset($data['reportType']) && $data['reportType'] == 'techniciancode'){
			$data= $this-> getPostedData();
			if($data['techniciancode'] > 0){
				$data['data'] = $this -> Daily_register_model -> monthly_report($data);
				$data['fileToLoad'] 	= 'childs/Monthly_register_view';
			}else{
				$data['data'] = $this -> Daily_register_model -> monthly_report_technician_wise($data);
				$data['fileToLoad'] 	= 'childs/Monthly_register_view_technician_wise';
			}
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);      
		}
		elseif(isset($data['reportType']) && $data['reportType'] == 'singledate_technicianwise'){
			$data= $this-> getPostedData();
			$data['data'] = $this -> Daily_register_model -> selected_date_technician_wise($data);
			$data['fileToLoad'] 	= 'childs/Monthly_register_view_technician_wise_selected_date';
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);      
		}
		elseif(isset($data['reportType']) && $data['reportType'] == 'uc'){
			$data= $this-> getPostedData();
			$data['data'] = $this -> Daily_register_model -> monthly_report_unioncouncil_wise($data);
			$data['fileToLoad'] 	= 'childs/Monthly_union_council_view';
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);
		}
		else{
			$data= $this-> getPostedData();
			$data['data'] = $this -> Daily_register_model -> daily_report($data);
			$data['fileToLoad'] 	= 'childs/daily_registe_vaccination_childr_view';
			$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
			$this->load->view('template/reports_template',$data);
		}
	}
	public function dataentry_report(){
		$data= $this-> getPostedData();
		$data['data'] = $this -> Daily_register_model -> dataentry_report($data);
		$data['fileToLoad'] 	= 'childs/daily_dataentry_view';
		$data['pageTitle']	='EPI-MIS | Daily Vaccination Register Report';
		$this->load->view('template/reports_template',$data);
		//print_r($data);exit;
	}
	public function getPostedData(){ 
			$data=array();$dataPosted=array();
			//$dataPosted = $_POST;
			If($_POST != null){
			$dataPosted = $_POST;
			}else{
				$dataPosted = $_GET;
			}
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
				$data[$key] = 0;
		}
			return $data;
	}	
}
?>