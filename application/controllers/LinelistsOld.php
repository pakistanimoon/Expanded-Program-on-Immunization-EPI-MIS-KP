<?php
class Linelists extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
		$this -> load -> model ('Linelists_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	//================ Constructor Function Ends ==================//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Linelists_Filters($reportName){
		//$reportName;
		$data = $this -> Linelists_model -> Create_Reporting_Filters($reportName);
		$data['data']=$data;
		if($data != 0){
            $data['fileToLoad'] = 'linelists/linelists_filters';
			$data['pageTitle']='LineList Report Filters';
			$this -> load -> view('template/epi_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Surveillance($code=NULL,$year=NULL,$week=NULL,$case_type=NULL,$drilldown=NULL,$cross_notified=NULL){
	//	echo "danish";exit;
		$data=array();$dataPosted=array();
		if($code && $year && $week && $case_type){
			//echo "abc"; exit();
			if($drilldown){
				$dataPosted  = array("uncode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type);
			}else{
				$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type);
			}
		}
		else if($code && $year && $week && $case_type && $cross_notified){
			//echo "klm"; exit();
			if($drilldown){
				$dataPosted  = array("uncode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type,"cross_notified" => $cross_notified);
			}else{
				$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type,"cross_notified" => $cross_notified);
			}
		}else if($code && $year && $week){
			//echo "xyz"; exit();
			$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week);
		}else{
			//echo "xyz123"; exit();
			$dataPosted = $_POST;
			//print_r($dataPosted);
		}
	//print_r($dataPosted);exit;
		$formats = array("d/m/Y","d-m-Y","d-M-Y","Y-m-d","m-d-Y","d-M-y");
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
			if(($data[$key] == NULL || $data[$key]=="0") && $key !== "cross_notified")
				unset($data[$key]);
		}
		if(isset($data['case_type'])){
			if ($data['case_type']=='AFP' || $data['case_type']=='Measles_cross_notified' || $data['case_type']=='Measles_other' || $data['case_type']=='NT') {	
				if($data['case_type']=='AFP'){
					$this -> Afp($data);exit;
				}
				else if($data['case_type']=='Measles_cross_notified' || $data['case_type']=='Measles_other'){
					$this -> Measles($data);exit;
				}
				else if($data['case_type']=='NT'){
					$this -> NNT($data);exit;
				}					
			}
			else if($data['case_type'] != 'AFP' || $data['case_type'] != 'NT' || $data['case_type'] != 'Measles_cross_notified' || $data['case_type'] != 'Measles_other') {
				$this -> Cases($data);exit;
			}
		}
		//print_r($data);exit;
		$data['data'] = $this -> Linelists_model -> Surveillance($data);
		$data['fileToLoad'] = 'linelists/surveillance_linelist_report';
		$data['pageTitle']='Weekly VPD Surveillance Compilation Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Specific Reports Ends Here ===================//
	public function Cases($data_rec){
		//print_r($data_rec);exit;
		$data['data'] = $this-> Linelists_model-> Cases($data_rec);
		$data['pageTitle'] = 'Case Investigation Linelists Report';
		$data['fileToLoad'] = 'linelists/cases_other';		
		$this-> load-> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Specific Reports Ends Here ===================//
	public function Measles($data_rec){
		//print_r($data_rec);exit;
		$data['data'] = $this -> Linelists_model -> Measles($data_rec);
		$data['pageTitle']='Measles Linelists Report';
		if($data_rec['case_type']=='Measles_other')
		{
			$data['fileToLoad'] = 'linelists/measlelinelist_other';
		}
		elseif($data_rec['case_type']=='Measles_cross_notified')
		{
			$data['fileToLoad'] = 'linelists/measlelinelist';
		}
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Specific Reports Ends Here ===================//
	public function Afp($data){
		$data['data'] = $this -> Linelists_model -> Afp($data);
		$data['fileToLoad'] = 'linelists/afplinelist';
		$data['pageTitle']='AFP Linelists Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function NNT($data){
		$data['data'] = $this -> Linelists_model -> NNT($data);
		$data['fileToLoad'] = 'linelists/nntlinelist';
		$data['pageTitle']='NNT Linelists Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
		//======= Function to Create Filters AEFI Linelist Reports Starts Here ===========//
	public function AEFI_Filters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearlyAefi','weekly','dates');
		$functionName = $this -> uri -> segment (2);
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Linelists/AEFI";
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'linelists/aefi_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "AEFI_Filters":
				$title = "AEFI WEEKLY Compilation Form for District/Province";
				break;
			
		}
		return $title;
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function AEFI($facode=NULL, $year=NULL, $week=NULL){
		$data=array();$dataPosted=array();
		if($facode && $year && $week){
			$dataPosted  = array("facode" => $facode, "year" => $year, "week" => $week);
		}else{
			$dataPosted = $_POST;
		}
		$formats = array("d/m/Y","d-m-Y","d-M-Y","Y-m-d","m-d-Y","d-M-y");
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
		
		$data['data'] = $this -> Linelists_model -> AEFI($data);
		$data['fileToLoad'] = 'linelists/aefilinelist';
		$data['pageTitle']='AEFI Linelists Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
}
?>