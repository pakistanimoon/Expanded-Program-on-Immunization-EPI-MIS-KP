<?php
class Indicator_Reports_New extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('indicator_functions_helper');
		$this -> load -> model('Indicator_reports_new_model');
		
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('month-from-to-previous');
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Indicator_Reports_New/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,$indicators,NULL,NULL,'',"Yes");
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
			case "HFMVRF":
				$title = "EPI Vaccination Indicator Report";
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
	
	function HFMVRF($distcode=NULL, $monthfrom=NULL, $monthto=NULL, $indicator=NULL, $reportPeriodnew=NULL,$facode=NULL,$tcode=NULL,$uncode=NULL)
	{
		//print_r($_POST);
		if($distcode AND $monthfrom AND $monthto AND $indicator AND $reportPeriodnew)
		{
			//print_r($tcode);
			//echo'agg'; 
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'reportPeriodnew' => $reportPeriodnew);
		if($tcode > 0){
			//echo'pani'; 	
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'reportPeriodnew' => $reportPeriodnew,'tcode'=>$tcode);
		}
	    if($tcode > 0 && $uncode > 0 ){
			//echo'pani'; 	
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'reportPeriodnew' => $reportPeriodnew,'tcode'=>$tcode,'uncode'=>$uncode);
		}
	    if($tcode > 0 && $uncode > 0 && $facode > 0){
			//echo'pani'; 	
			$data = array('distcode' => $distcode, 'monthfrom' => $monthfrom, 'monthto' => $monthto, 'indicator' => $indicator, 'reportPeriodnew' => $reportPeriodnew,'tcode'=>$tcode,'uncode'=>$uncode,'facode'=>$facode);
		}  
		//print_r($data); exit;
		}else{
			$data = $this -> getPostedData();
				//print_r($data);
		}
		$dataHFNAMR['data'] = $this -> Indicator_reports_new_model -> HFMVRF($data/* ,$wc */);
		$indicatorTitle = $dataHFNAMR["data"]["indicatorTitle"];
		if($this -> input -> post('export_excel'))
		{
		   //if request is from excel
		   header("Content-type: application/octet-stream");
		   header("Content-Disposition: attachment; filename=".(str_replace(" ","_",$indicatorTitle).(isset($data['monthfrom']))?$data['monthfrom']:''."_to_".(isset($data['monthto']))?$data['monthto']:'').".xls");
		   header("Pragma: no-cache");
		   header("Expires: 0");
		   //Excel Ending here
		}
		$dataHFNAMR['fileToLoad'] = 'indicator_reports/vacc_indicator_report_view';
		$dataHFNAMR['pageTitle']='EPI-MIS | EPI Vaccination Indicator report';
		$this->load->view('template/reports_template',$dataHFNAMR);
	}
	
}