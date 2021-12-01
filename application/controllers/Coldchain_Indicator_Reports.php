<?php
class Coldchain_Indicator_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this->load->model('Coldchain_reports_model');
		authentication();
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		//$reportPeriod = array('month-from-to');
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Coldchain_Indicator_Reports/".$functionName;
		//echo $reportPath;exit;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$reportPeriod=array('yearly');
		$quarter=array(0=>"Quarter",1=>"First",2=>"Second",3=>"Third",4=>"Fourth");
		$customDropdown=array($quarter);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,NULL,NULL,NULL,NULL,NULL,NULL,$customDropdown);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'indicator_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Indicator Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "Refrigerator_Report":
				$title = "ILR Indicator Report";
				break;
			case "Coldroom_Report":
				$title = "Coldroom Indicator Report";
				break;
			case "Generator_Report":
				$title = "Generator Indicator Report";
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
	
	function Refrigerator_Report(){		
		$data = $this -> getPostedData();
		$data['data'] = $this->Coldchain_reports_model->Refrigerator_Report($data); 
		$data['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$data['pageTitle'] = 'EPI-MIS Refrigerator Indicator Report';
		$this->load->view('template/reports_template',$data);
		//print_r($data);exit;
	}
	function Coldroom_Report(){		
		$data = $this -> getPostedData();
		$data['data'] = $this->Coldchain_reports_model->Coldroom_Report($data); 
		$data['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$data['pageTitle'] = 'EPI-MIS Coldroom Indicator Report';
		$this->load->view('template/reports_template',$data);
		//print_r($data);exit;
	}
	function Generator_Report(){		
		$data = $this -> getPostedData();
		$data['data'] = $this->Coldchain_reports_model->Generator_Report($data); 
		$data['fileToLoad'] = 'indicator_reports/indicator_report_view';
		$data['pageTitle'] = 'EPI-MIS Generator Indicator Report';
		$this->load->view('template/reports_template',$data);
		//print_r($data);exit;
	}
}