<?php
class Maps_Main extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		//$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() {
		$data['month'] = 9;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'maps/maps_index';
		$viewData['pageTitle']='EPI-MIS Dashboard | UC Map ';
		$this->load->view('template/epi_template',$viewData);
	}
}