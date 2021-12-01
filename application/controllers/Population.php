<?php
class Population extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('epi_functions_helper'); 
		authentication();

		$this->load->model('Population_model');
		$this->load->library('breadcrumbs');
		$this->load->library('form_validation');
		$this->load->helper('my_functions_helper');

	}
	public function Villages()
	{	
		$data['fileToLoad'] = 'Population-village';
		$this->load->model('Population_model');
		$data['data']=$this->Population_model->getVillages();
		//print_r($data);exit;
		$data['pageTitle']='EPI-MIS | Village Population';
		$this->load->view('template/epi_template',$data);
	}
	public function Facilities()
	{
		$data['fileToLoad'] = 'Population-fac';
		//$this->load->model('Population_model');
		$data['data']=$this->Population_model->getFacilities();
		//print_r($data);exit;
		$data['pageTitle']='EPI-MIS | Facilities Population';
		$this->load->view('template/epi_template',$data);
	}

	public function Districts()
	{
		$data['fileToLoad'] = 'Population-dist';
		//$this->load->model('Population_model');
		$data['data']=$this->Population_model->getDistricts();
		$data['pageTitle']='EPI-MIS | Training';
		$this->load->view('template/epi_template',$data);
	}
	public function Tehsil()
	{
		$data['fileToLoad'] = 'Population-tehsil';
		//$this->load->model('Population_model');
		$data['data']=$this->Population_model->getTehsil();
		$data['pageTitle']='EPI-MIS | Training';
		$this->load->view('template/epi_template',$data);
	}
	public function UC()
	{
		$data['fileToLoad'] = 'Population-uc';
		//$this->load->model('Population_model');
		$data['data']=$this->Population_model->getUC();
		$data['pageTitle']='EPI-MIS | UC Population';
		$this->load->view('template/epi_template',$data);
	}
	
	public function addFacilities()
	{
		$distcode = $this->session->District;
		//$this->load->model('Population_model');
		$this->Population_model->setFacilities($_POST,$distcode);
		redirect('Population/Facilities');
	}
	
	public function addvillages()
	{	//echo '<pre>'; print_r($_POST);
		$tcodes = $this -> input-> post('tcodes');
		$uncodes = $this -> input-> post('uncodes');
		//$facode = $this -> input-> post('next');
		$facode = $this -> input-> post('facode');
		/* echo '<br>';
		echo '<pre>'; print_r($tcodes);exit; */
		$distcode = $this->session->District;
		$this->Population_model->setvillages($_POST,$distcode,$tcodes,$uncodes,$facode);
		redirect('Population/Villages');
		 /* $distcode = $this->session->District;
		 //$this->load->model('Population_model');
		 $this->Population_model->setvillages($_POST,$distcode);
		 redirect('Population/Villages'); */
	}
/* 	public function addDistricts()
	{
		 //$this->load->model('Population_model');
		 $this->Population_model->setDistricts($_POST);
		 redirect('Population/Districts');
	}
	public function addTehsil()
	{
		 //$this->load->model('Population_model');
		 $this->Population_model->setTehsil($_POST);
		 redirect('Population/Tehsil');
	}
	public function addUC()
	{
		$distcode = $this->session->District;
		//print_r($_POST);exit;
		 $this->Population_model->setUC($_POST,$distcode);
		 redirect('Population/UC');
	}*/
}
?>