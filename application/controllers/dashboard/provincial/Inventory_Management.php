<?php
class Inventory_Management extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('inventory_helper');
		authentication();
		$this -> load -> model('dashboard/dashboard_model','dashboard');
		$this -> load -> model('inventory_model','invn');
		$this -> load -> model('Common_model','common');
	}
	//Omer butt
	//Description:stock status by product wise  as OB, CB, Issue, Recieve 
	public function stock_status()
	{
		
		$data['data']['issue_warehouse']=$this->issued_To_Warehouse();
		$data['data']['vvm_stage_status']=$this->vvm_stage_status();
		$data['data']['vvm_sum']=array_sum(array_column($data['data']['vvm_stage_status'],'sum'));
		$data['data']['stock_status']=array_sum(array_column($data['data']['issue_warehouse'],'sum'));
		$data['fileToLoad'] = 'dashboard/inventory_dashboard';
		$data['pageTitle'] = 'EPI-MIS | Vaccine Distribution';
		$this->load->view('template/epi_template',$data);
	}
	public function issued_To_Warehouse()
	{
		
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$product=$this->input->post('product');
		$reportedmonth=$year."-".$month;
		$data=$this->invn->issue_To_Warehouse($reportedmonth,$product);
		//$this->common->get_info();
		return $data;
	}
	public function vvm_stage_status()
	{
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$product=$this->input->post('product');
		$reportedmonth=$year."-".$month;
		$data=$this->invn->vvm_stage_status($reportedmonth,$product);
		//$this->common->get_info();
		return $data;
	
	}
	
	
}