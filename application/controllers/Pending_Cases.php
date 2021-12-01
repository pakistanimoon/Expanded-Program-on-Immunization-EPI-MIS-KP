<?php
	class Pending_Cases extends CI_Controller {
		//================ Constructor function starts==================//
		public function __construct() {
			parent::__construct();

			$this -> load -> model('Pending_cases_report_model');
			$this -> load -> model('Common_model');
			$this -> load -> model('Filter_model');			
			$this -> load -> helper('my_functions_helper');
			$this -> load -> helper('epi_reports_helper');
			$this -> load -> helper('date');
			authentication();
		}
		//================ Constructor function ends ================//
		//-----------------------------------------------------------//

		function reportFilters(){
			$this -> load -> library('reportfilters');
			$reportPeriod = array('yearly','monthly');
			$functionName = $this -> uri -> segment (3);
			$reportPath = base_url()."CrossNotifiedCases/".$functionName; 
			$reportTitle = $this->reportTitle($functionName);
			$indicators = $functionName;
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			if($functionName == 'PendingCases'){
				$reportPeriod = array('year');
				$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,NULL);
			}
			else
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
				case "PendingCases":
					$title = "Pending Cross Notified Cases Report";
					break;
			}
			return $title;
		}
		//================ sanctionedpostsreport function starts ==========//
		public function Pending_cases_report($distcode=NULL, $year=NULL){
			//print_r($_POST);exit();
			$procode = $_SESSION["Province"];
			$data = "";
			if($year)
			{	
				$data = array('procode' => $procode, 'distcode' => $distcode, 'year' => $year);
			}
			else
			{
				$data = $this -> getPostedData();
			}
			//print_r($data);exit();
			if($this-> input-> post('distcode')){
				$distcode = $this-> input-> post('distcode');
				$year = $data['year'];
				redirect('Cross_notified_cases/Cross_notified_cases_list/'.$distcode.'/'.$year);
			}
			else{
				$data = $this-> Pending_cases_report_model-> Pending_cases_report($data);
			}			
			$data['data']=$data;
			//print_r($data);exit();
			if($data != 0){
			    $data['fileToLoad'] = 'reports/pending_cases_view';
				$data['pageTitle']='EPI-MIS | Pending Cases Report';
				$this->load->view('template/reports_template',$data);
			}
			else{
				$data['message']="You must have rights to access this page.";
				$this->load->view("message",$data);
			}
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
		//================ sanctionedPosts function ends ====================//	

	}
?>