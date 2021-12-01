<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulletinreport extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Compliances_model');
		$this -> load -> helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
	//
	}
public function Bulleitinfillter(){
	//echo "result show soon";exit;
	$this -> load -> library('reportfilters');
	$functionName = $this -> uri -> segment (2);
	$functionName = str_replace("-", "_", $functionName);
	$reportPath = base_url()."Bulletin/";
	$reportTitle = 'Bulletin Filter';	
//	$reportTitle = $functionName;
	$reportPeriod = array('cryearly','weekly');
   $dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
	$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false);
	$dataHtml .= $this->reportfilters->filtersFooter();
	$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'bulletin_view/bulletinreport_filter_view';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	///print($reportTitle);exit;
	
}
/* 
function bulletin($distcode=NULL, $year=NULL){		
		$data = $this -> getPostedData();
        
       // print_r($data['week']);exit;
         //echo "danish";exit;
		/* if($distcode && $year){
			$data = array("distcode"=>$distcode, "year"=>$year);
		}else{			
			$data = $this -> getPostedData();
		}		
		$dataHFMVRF['pageTitle']='Health Facility Monthly Report Compliance';
		$dataHFMVRF['data'] = $this -> Compliances_model -> HFMVRF($data,$dataHFMVRF['pageTitle']);
		$dataHFMVRF['fileToLoad'] = 'compliances/hfmvrf';		
		$this -> load -> view('template/reports_template',$dataHFMVRF); */
	//}
	//============================ Constructor Function Ends ============================//
	/* public function compliancesFilters(){
		
		//print('test');exit;
		
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		if($functionName == 'HF-Consumption-Requisition' || $functionName == 'AEFI-Compliance' || $functionName == 'Other-Compliance' || $functionName == 'Zero-Compliance')
			$reportPeriod = array('cryearly');
		else if($functionName == "Issue-Receipt" || $functionName == "Demand-Consumption-Receipt")
			$reportPeriod = array('dates');
		else if($functionName == 'AFP-Compliance' || $functionName == 'NNT-Compliance' || $functionName == 'Measles-Compliance')
			$reportPeriod = array('cryearly','weekly');
		else if ($functionName == 'HFMVRF')
			$reportPeriod = array('yearly');
		else
			$reportPeriod = NULL;
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Bulletin/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$case_type = array('caseType');
		if($functionName == "Other_Compliance"){
			//$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,'',$case_type);
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,NULL,$case_type);
		}
		else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false);
		}
		//$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,'',$case_type);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	} */
	
}
?>