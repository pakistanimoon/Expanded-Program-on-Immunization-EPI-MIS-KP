<?php
class Outbreak_response_list_report extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Outbreak_response_list_report_model','outbreak_model');
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
	}	
	public function outbreak_response_list_report()
	{   
		$distcode=$this -> session -> District;
		$data = $this -> outbreak_model -> outbreak_response_list_report($distcode);
		//print_r($data); exit;
		$data['data'] = "";
		$data['fileToLoad'] = 'reports/outbreak_response_list_report';
		$data['pageTitle']	= 'Outbreak Response List Report | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function outbreak_report()
	{   
		
				$distcode = (($this->input->post('distcode') != '')?$this->input->post('distcode'):NULL);
				$tcode = (($this->input->post('tcode') != '')?$this->input->post('tcode'):NULL);			
				$uncode = (($this->input->post('uncode') != '')?$this->input->post('uncode'):NULL);			
				$vcode = (($this->input->post('vcode') != '')?$this->input->post('vcode'):NULL);			
				$date_of_activity_from = (($this->input->post('date_of_activity') != '')?$this->input->post('date_of_activity'):NULL);			
				$date_of_activity_to = (($this->input->post('date_of_activity_to') != '')?$this->input->post('date_of_activity_to'):NULL);
				$age_group_from = (($this->input->post('age_group_from') != '')?$this->input->post('age_group_from'):NULL);
				$age_group_to = (($this->input->post('age_group_to') != '')?$this->input->post('age_group_to'):NULL);		 
		
		$data = $this -> outbreak_model -> outbreak_report($distcode,$tcode,$uncode,$vcode,$date_of_activity_from,$date_of_activity_to,$age_group_from,$age_group_to);
		//print_r($data); exit;
		
		$data['argu'] = array($distcode,$tcode,$uncode,$vcode,$date_of_activity_from,$date_of_activity_to,$age_group_from,$age_group_to);
		//print_r($argu); exit;
	
		/*$data['data'] = "";
		$data['fileToLoad'] = 'reports/outbreak_report';
		$data['pageTitle']	= 'Outbreak Response List Report | EPI-MIS';*/
		$this->load->view('reports/outbreak_report',$data);
	}
}
?>