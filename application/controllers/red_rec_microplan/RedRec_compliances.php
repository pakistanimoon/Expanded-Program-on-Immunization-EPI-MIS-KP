<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RedRec_compliances extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		
		$this -> load -> model('red_microplan/Redrec_compliances_model');
		$this -> load -> model('Common_model');
		
		$this -> load -> helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
	}
	//============================ Constructor Function Ends ============================//
	public function compliancesFilters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		$reportPeriod = array('cryearly');
		$allyears = $this->Common_model->fetchall("situation_analysis_db",NULL,"year as name",NULL,"year");
		$allyears = array_column($allyears,"name","name");
		$customDropDown = array(
			array('0'=>'Year','Year'=>$allyears)
		);

		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."red_rec_microplan/RedRec_compliances/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		//$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod);
		if($this -> session -> UserLevel==4){
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,NULL,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,NULL,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		//var_Dump($dataHtml);exit;
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/compliances_filter';
		$data['pageTitle']='EPI-MIS Compliance Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "HF_Quarterplan":
				$title = "HF Quarterly Compliance ";
				break;
			case "HF_Microplan":
				$title = "HF Micro plan Compliance";
				break;
			case "HF_Supervisoryplan":
				$title = "HF Supervisory planned";
				break;
			case "HF_Supervisoryvisit":
				$title = "HF Supervisory Planned/Conducted Visit";
				break;
		}
		return $title;
	}
	function HF_Quarterplan(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Quarterly_Due/Submit.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$data = $this -> getPostedData();
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_quarter_complainces($data);
		if($this->input->get_post('distcode'))
			$dist = $this->input->get_post('distcode');
		else 
			$dist = '';
		if($this->input->get_post('tcode')){
			$tcode = $this->input->get_post('tcode');
		}
		$year = $this->input->get_post('year');
		$data['distcode'] = $dist;
		$data['year'] = $year;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['data']['TopInfo'] = reportsTopInfo("HF Quarterly Due/Submit", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/Hf_quarter_compliance_view';
		$data['pageTitle']='HF Quarterly Due/Submit';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_quarter_tech_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Quarterly_Technician_Record.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $this->input->get('distcode');
		$tcode = $this->input->get('tcode');
		$year = $this->input->get('year');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_quarter_tech_compliance($distcode,$year,$tcode);
		$data['distcode'] = $distcode;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['data']['TopInfo'] = reportsTopInfo("HF Quarterly Technician Record", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_quarter_tech_compliance_view';
		$data['pageTitle']='HF Quarterly Technician Record';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_tech_compilation_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Technician_compilation.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$techniciancode = $this->input->get('techniciancode');
		$quarter = $this->input->get('quarter');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_tech_compilation_compliance($techniciancode,$quarter);
		$this-> load ->view('Add_red_microplanning/compliances/HF_quarter_tech_compilation_compliance_view',$data);
	}
	function RedRec_HF_microplan_uc_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_MicroPlan_Technician_Record.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $this->input->get('distcode');
		$tcode = $this->input->get('tcode');
		$year = $this->input->get('year');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_microplan_uc_compliance($distcode,$year,$tcode);
		$data['distcode'] = $distcode;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("HF Micro-Plan Union Council Record", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_microplan_uc_compliance_view';
		$data['pageTitle']='HF Micro-Plan Union Council Record';
		$this -> load -> view('template/reports_template',$data);
	}
	function HF_Microplan (){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_MicroPlan_Due/Submit.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$data = $this -> getPostedData();
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_microplan_complainces($data);
		if($this->input->get_post('distcode'))
			$dist = $this->input->get_post('distcode');
		else 
			$dist = '';
		if($this->input->get_post('tcode')){
			$tcode = $this->input->get_post('tcode');
		}	
		$year = $this->input->get_post('year');
		$data['distcode'] = $dist;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("HF Micro-Plan Due/Submit", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/Hf_microplan_compliance_view';
		$data['pageTitle']='HF Micro-Plan Due/Submit';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_microplan_tech_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_MicroPlan_Technician_Record.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$uncode = $this->input->get('uncode');
		$year = $this->input->get('year');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_microplan_tech_compliance($uncode,$year);
		$data['uncode'] = $uncode;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("HF Micro-Plan Technician Record", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_microplan_tech_compliance_view';
		$data['pageTitle']='HF Micro-Plan Technician Record';
		$this -> load -> view('template/reports_template',$data);
	}
	function HF_Supervisoryplan(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Supervisory_Planned.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$data = $this -> getPostedData();
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_supervisoryplan_complainces($data);
		if($this->input->get_post('distcode'))
			$dist = $this->input->get_post('distcode');
		else 
			$dist = '';
		if($this->input->get_post('tcode')){
			$tcode = $this->input->get_post('tcode');
		}
		$year = $this->input->get_post('year');
		$data['distcode'] = $dist;
		$data['year'] = $year;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['data']['TopInfo'] = reportsTopInfo("HF Supervisory Planned", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_Supervisoryplan_view';
		$data['pageTitle']='HF Supervisory-Plan Planed/conduct';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_supervisoryplan_tech_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Supervisory_Planned.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $this->input->get('distcode');
		$tcode = $this->input->get('tcode');
		$year = $this->input->get('year');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_supervisoryplan_tech_compliance($distcode,$year,$tcode);
		$data['distcode'] = $distcode;
		$data['year'] = $year;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['data']['TopInfo'] = reportsTopInfo("HF Supervisory Planned", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_Supervisoryplan_tech_compliance_view';
		$data['pageTitle']='HF Supervisory Plan Record';
		$this -> load -> view('template/reports_template',$data);
	}
	public function situation_analysis_view(){
		$techniciancode = $this-> uri -> segment(4);
		$year = $this-> uri -> segment(5);
		$data['data'] = $this-> Redrec_compliances_model-> situation_analysis_view($techniciancode,$year);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/situation_main_view';
		$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
		$this-> load-> view('template/epi_template',$data);
	}
	function HF_Supervisoryvisit(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Supervisory_Planned/Conduct_visit.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$data = $this -> getPostedData();
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_Supervisoryvisit_complainces($data);
		if($this->input->get_post('distcode'))
			$dist = $this->input->get_post('distcode');
		else 
			$dist = '';
		if($this->input->get_post('tcode')){
			$tcode = $this->input->get_post('tcode');
		}	
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$year = $this->input->get_post('year');
		$data['distcode'] = $dist;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("HF Supervisory Planned/Conduct visit ", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_Supervisoryvisit_view';
		$data['pageTitle']='HF Supervisory-visit Planed/conduct';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_supervisoryvisit_tech_compliance(){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Supervisory_Planned/Conduct_visit.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $this->input->get('distcode');
		$tcode = $this->input->get('tcode');
		$year = $this->input->get('year');
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_supervisoryvisit_tech_compliance($distcode,$year,$tcode);
		$data['distcode'] = $distcode;
		$data['year']= $year;
		if($this->session->Tehsil){
			$data['tcode'] = $tcode;
		}
		$data['data']['TopInfo'] = reportsTopInfo("HF Supervisory Planned/Conduct visit ", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/HF_Supervisoryvisit_tech_compliance_view';
		$data['pageTitle']='HF Supervisory visit Record';
		$this -> load -> view('template/reports_template',$data);
	}
	function RedRec_HF_supervisoryvisit_view(){
		$supervisorcode = $this->input->get('supervisorcode');
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$arr = array($year,$month);
		$fmonth = implode("-",$arr);
		$data['year']=$year;
		$data['month']=$month;
		$data['data'] = $this -> Redrec_compliances_model -> RedRec_HF_supervisoryvisit_view($supervisorcode,$fmonth);
		$data['fileToLoad'] = 'Add_red_microplanning/compliances/RedRec_HF_supervisoryvisit_view';
		$data['pageTitle']='Micro Plan | EPI-MIS';
		$this->load->view('template/epi_template',$data);
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
		$ajax = $this->input->post('ajax');
		if($ajax)
		{
			$export_data = $this->input->post('export_data');
			$this->session->set_userdata("moonzerocomp",$export_data);
			print_r($export_data);
			exit;
		}
		else
		{
			$table = $this->session->userdata("moonzerocomp");
			print_r($table);
		}
	}
} ?>