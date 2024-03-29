<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compliances extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Compliances_model');
		$this -> load -> helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
		$code = md5(date("Y-n-d"));
		if($this-> uri-> segment(5) != '' &&  $this-> uri-> segment(5) == $code){
			$provinceCode = $this->uri->segment(3); // procode during drilldown from Federal EPI
			$provinceName = get_Province_Name($provinceCode); // province name based on procode
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'utype' => 'Manager',
				'provincename' => $provinceName,
				'Province' => $provinceCode,
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
	}
	//============================ Constructor Function Ends ============================//
	public function compliancesFilters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		if($functionName == 'AEFI-Compliance')
		if ($functionName=='AEFI-Compliance') {
			$reportPeriod = array('cryearly','from_week','to_week');
			//$reportPeriod = array('cryearly','weekly');
		}else{
			$reportPeriod = array('cryearly');
		}
		//$reportPeriod = array('cryearly');
		else if($functionName == "Issue-Receipt" || $functionName == "Demand-Consumption-Receipt")
			$reportPeriod = array('dates');		
		else if($functionName == 'Measles-Compliance' || $functionName == 'Coronavirus-Compliance' || $functionName == 'NNT-Compliance' || $functionName == 'AFP-Compliance' || $functionName == 'Other-Compliance' || $functionName == 'Zero-Compliance')
			$reportPeriod = array('cryearly','from_week','to_week');
		else if ($functionName == 'HFMVRF' || $functionName == 'HF-Consumption-Requisition')
			$reportPeriod = array('month-from-to-previous');
			//$reportPeriod = array('cryearly');
		else
			$reportPeriod = NULL;
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Compliances/".$functionName;
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
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "HFMVRF":
				$title = "Health Facility Monthly Compliance Report";
				break;
			case "HF_Consumption_Requisition":
				$title = "HF Consumption & Requisition Compliance Report";
				break;
			case "Issue_Receipt":
				$title = "District Issue & Receipt Compliance Report";
				break;
			case "Demand_Consumption_Receipt":
				$title = "UC Demand, Consumption & Receipt Compliance Report";
				break;
			case "Zero_Compliance":
				$title = "Zero Reporting Weekly Compliance";
				break;
			case "Coronavirus_Compliance":
				$title = "Coronavirus Weekly Compliance Report";
				break;
			case "Measles_Compliance":
				$title = "Measles Weekly Compliance Report";
				break;
			case "NNT_Compliance":
				$title = "NNT Weekly Compliance Report";
				break;
			case "Other_Compliance":
				$title = "Other Diseases Weekly Compliance Report";
				break;
			case "AFP_Compliance":
				$title = "AFP Weekly Compliance Report";
				break;
			case "AEFI_Compliance":
				$title = "AEFI Weekly Compliance Report";
				break;
		}
		return $title;
	}
	function HFMVRF($distcode=NULL, $monthfrom=NULL, $monthto=NULL){
		//echo "danish";exit;
		//print_r($_POST); exit();
		if($distcode && $monthfrom && $monthto){
			$data = array("distcode"=>$distcode, "monthfrom"=>$monthfrom, "monthto"=>$monthto);
		}else{			
			$data = $this -> getPostedData();
		}
		//print_r($data);exit();
		if($this-> uri-> segment(5) != ''){
			$data['monthfrom'] = $monthfrom = $this-> uri-> segment(4);
			$data['monthto'] = $monthto = $this-> uri-> segment(5);
			if(strlen($data['distcode'])=='1'){
				unset($data['distcode']);
			}
		}	
		$dataHFMVRF['pageTitle']='Health Facility Monthly Report Compliance';
		$dataHFMVRF['data'] = $this -> Compliances_model -> HFMVRF($data,$dataHFMVRF['pageTitle']);
		$dataHFMVRF['fileToLoad'] = 'compliances/hfmvrf';		
		$this -> load -> view('template/reports_template',$dataHFMVRF);
	}
	function HF_Consumption_Requisition($distcode=NULL, $monthfrom=NULL, $monthto=NULL){
		if($distcode && $monthfrom && $monthto){
			$data = array("distcode"=>$distcode, "monthfrom"=>$monthfrom, "monthto"=>$monthto);
		}
		else{
			$data = $this -> getPostedData();
		}
		if($this-> uri-> segment(5) != ''){
			$data['monthfrom'] = $monthfrom = $this-> uri-> segment(4);
			$data['monthto'] = $monthto = $this-> uri-> segment(5);
			if(strlen($data['distcode'])=='1'){
				unset($data['distcode']);
			}
		}	
		$dataHFCRC['pageTitle']='HF Consumption & Requisition Compliance';
		$dataHFCRC['data'] = $this -> Compliances_model -> HF_Consumption_Requisition($data,$dataHFCRC['pageTitle']);
		$dataHFCRC['fileToLoad'] = 'compliances/hf_consumption_requisition';
		$this -> load -> view('template/reports_template',$dataHFCRC);
	}
	function Issue_Receipt(){
		$data = $this -> getPostedData();
		$dataDIR['pageTitle']='District Issue & Receipt Compliance';
		$dataDIR['data'] = $this -> Compliances_model -> Issue_Receipt($data,$dataDIR['pageTitle']);
		$dataDIR['fileToLoad'] = 'compliances/district_issue_receipt';
		$this -> load -> view('template/reports_template',$dataDIR);
	}
	function Demand_Consumption_Receipt(){
		$data = $this -> getPostedData();
		$dataUCDCR['pageTitle']='UC Demand, Consumption & Receipt Compliance';
		$dataUCDCR['data'] = $this -> Compliances_model -> Demand_Consumption_Receipt($data,$dataUCDCR['pageTitle']);
		$dataUCDCR['fileToLoad'] = 'compliances/demand_consumption_receipt';
		$this -> load -> view('template/reports_template',$dataUCDCR);
	}
	
	function Coronavirus_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year && $from_week && $to_week){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else{
			$data = $this -> getPostedData();
		}		
		$dataMWC['pageTitle']='Coronavirus Weekly Compliance';
		$dataMWC['data'] = $this -> Compliances_model -> Coronavirus_Compliance($data,$dataMWC['pageTitle']);
		$dataMWC['fileToLoad'] = 'compliances/coronavirus_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataMWC);
	}

	function Measles_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year && $from_week && $to_week){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else{
			$data = $this -> getPostedData();
		}		
		$dataMWC['pageTitle']='Measles Weekly Compliance';
		$dataMWC['data'] = $this -> Compliances_model -> Measles_Compliance($data,$dataMWC['pageTitle']);
		$dataMWC['fileToLoad'] = 'compliances/measles_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataMWC);
	}

	function NNT_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year && $from_week && $to_week){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else{
			$data = $this -> getPostedData();
		}
		$dataNNTWC['pageTitle']='NNT Weekly Compliance';
		$dataNNTWC['data'] = $this -> Compliances_model -> NNT_Compliance($data,$dataNNTWC['pageTitle']);
		$dataNNTWC['fileToLoad'] = 'compliances/nnt_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataNNTWC);
	}

	function AFP_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year && $from_week && $to_week){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else{
			$data = $this -> getPostedData();
		}		
		$dataAFPWC['pageTitle']='AFP Weekly Compliance';
		$dataAFPWC['data'] = $this -> Compliances_model -> AFP_Compliance($data,$dataAFPWC['pageTitle']);
		$dataAFPWC['fileToLoad'] = 'compliances/afp_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataAFPWC);
	}

	function Other_Compliance($distcode=NULL, $year=NULL, $case_type=NULL, $from_week=NULL, $to_week=NULL){
		//print_r($_POST); exit();
		if($distcode && $year){
			$data = array("distcode"=>$distcode, "year"=>$year, "case_type"=>$case_type, "from_week"=>$from_week, "to_week"=>$to_week );
		}else{
			$data = $this -> getPostedData();
		}			
		$dataODWC['pageTitle']='Other Diseases Weekly Compliance';
		$dataODWC['data'] = $this -> Compliances_model -> Other_Disease_Compliance($data,$dataODWC['pageTitle']);
		//print_r($dataODWC);exit;
		$dataODWC['fileToLoad'] = 'compliances/other_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataODWC);
	}

	function AEFI_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year && $from_week && $to_week){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}else{
			$data = $this -> getPostedData();
		}		
		$dataAEFIWC['pageTitle']='AEFI Weekly Compliance';
		$dataAEFIWC['data'] = $this -> Compliances_model -> AEFI_Compliance($data,$dataAEFIWC['pageTitle']);
		$dataAEFIWC['fileToLoad'] = 'compliances/aefi_investigation_compliance';
		$this -> load -> view('template/reports_template',$dataAEFIWC);
	}
	/* function Zero_Compliance($distcode=NULL, $year=NULL){
		if($distcode && $year){
			$data = array("distcode"=>$distcode, "year"=>$year);
		}else{
			$data = $this -> getPostedData();
		}		
		$dataZRFWC['pageTitle'] = 'Zero Reporting Weekly Compliance';
		$dataZRFWC['data'] = $this -> Compliances_model -> Zero_Compliance($data,$dataZRFWC['pageTitle']);
		$dataZRFWC['fileToLoad'] = 'compliances/zero_reporting_compliance';
		$this -> load -> view('template/reports_template',$dataZRFWC);
	} */
	function Zero_Compliance($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL){
		if($distcode && $year){
			$data = array("distcode"=>$distcode, "year"=>$year, "from_week"=>$from_week, "to_week"=>$to_week);
		}
		else{
			$data = $this -> getPostedData();
		}
		// if($this-> uri-> segment(5) != ''){
		// 	$data['procode'] = $procode = $this-> uri-> segment(3);
		// 	$data['year'] = $year = $this-> uri-> segment(4);
		// 	unset($data['distcode']);
		// }	
		$dataZRFWC['pageTitle'] = 'Zero Reporting Weekly Compliance';
		$dataZRFWC['data'] = $this -> Compliances_model -> Zero_Compliance($data,$dataZRFWC['pageTitle']);
		
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$dataZRFWC['data']["district_data"] = TRUE;
			$table = $dataZRFWC['data']["tableData"];
			$table = str_replace('<div id="parent" style="overflow: auto;">', "", $table);
			$table = str_replace('</div>', "", $table);
			$table = str_replace('<img style="width:20px;" title="Timely" src="http://epimis.kphealth.pk/includes/images/timely.png">', "&#x2609;", $table);
			$table = str_replace('<i class="fa fa-times"></i>', "&#10006;", $table);
			$this->session->set_userdata("moonzerocomp",$table);
		}else{
			$dataZRFWC['data']["district_data"] = FALSE;
		}
		//template_loader('compliances/zero_reporting_compliance', $dataZRFWC, array($this->_module), 'reports');
		
		$dataZRFWC['fileToLoad'] = 'compliances/zero_reporting_compliance';
		$this -> load -> view('template/reports_template',$dataZRFWC);
	}
	function Zero_Compliance_query($distcode=NULL, $year=NULL){
			
		if($distcode && $year){
			$data = array("distcode"=>$distcode, "year"=>$year);
		}else{
			$data = $this -> getPostedData();
		}	
		$dataZRFWC['pageTitle'] = 'Zero Reporting Weekly Compliance';
		$dataZRFWC['data'] = $this -> Compliances_model -> Zero_Compliance($data,$dataZRFWC['pageTitle']);
		
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$dataZRFWC['data']["district_data"] = TRUE;
			$table = $dataZRFWC['data']["tableData"];
			$table = str_replace('<div id="parent" style="overflow: auto;">', "", $table);
			$table = str_replace('</div>', "", $table);
			$table = str_replace('<img style="width:20px;" title="Timely" src="http://epimis.kphealth.pk/includes/images/timely.png">', "&#x2609;", $table);
			$table = str_replace('<i class="fa fa-times"></i>', "&#10006;", $table);
			$this->session->set_userdata("moonzerocomp",$table);
		}else{
			$dataZRFWC['data']["district_data"] = FALSE;
		}
		//template_loader('compliances/zero_reporting_compliance', $dataZRFWC, array($this->_module), 'reports');
		
		$dataZRFWC['fileToLoad'] = 'compliances/zero_reporting_compliance_query';
		$this -> load -> view('template/reports_template',$dataZRFWC);
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
	function export_excel()
	{
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=Zero_Compliance.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//$export_data = $this->input->post('export_data');
		$ajax = $this->input->post('ajax');
		if($ajax)
		{
			$export_data = $this->input->post('export_data');
			$this->session->set_userdata("moonzerocomp",$export_data);
			print_r($export_data);
			exit;
			//print_r($export_data);
		}
		else
		{
			//echo "else";exit;
			$table = $this->session->userdata("moonzerocomp");
			print_r($table);
		}
	}
} ?>