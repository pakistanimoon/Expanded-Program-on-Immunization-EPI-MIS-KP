<?php
class Error_Reports extends CI_Controller {

	public function __construct() { 
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> model('Error_reports_model');
	}
	function index(){
		$report_to_load = $this -> uri -> segment(1);
		$page_title = ucwords(str_replace("-"," ",$report_to_load));
		$data['data'] = $this -> Error_reports_model -> error_reports($report_to_load);
		if($data != 0){
            $data['fileToLoad'] = 'error_reports/report_view';
			$data['pageTitle']='EPI-MIS | '.$page_title;
			$this->load->view('template/reports_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this->load->view("message",$data);
		}
	}	
}