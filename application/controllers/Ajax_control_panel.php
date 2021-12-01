<?php
class Ajax_control_panel extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');		
		//authentication(); 
		$this -> load -> model('Ajax_control_panel_model');
	}	
	public function quickSearch(){
		$searchParam = $this->input->get('searchParam');		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		$fatype = $this->input->get('fatype');
		$data=$this -> Ajax_control_panel_model -> searchParam($facode,$distcode,$fmonth,$fatype,$searchParam);
		echo $data;
	}
	public function generateCode() {		
		$uncode = $this-> input-> get('uncode');	
		$data = $this-> Ajax_control_panel_model-> generateCode($uncode);
		echo $data;
	}
	public function getTehsils() {
		$data = $this -> Ajax_control_panel_model -> getTehsils();	
		echo $data;	
	}
	public function getFacilities() {
		$data = $this -> Ajax_control_panel_model -> getFacilities();
		echo $data;
	}
	public function getFacTehsils() {		
		$data = $this -> Ajax_control_panel_model -> getFacTehsils();
		echo $data;
	}
	public function getUnC() {
		$tcode = ($this -> input -> post('tcode'))?$this -> input -> post('tcode'):$this -> uri -> segment(3);
		$data = $this -> Ajax_control_panel_model -> getUnC($tcode);
		echo $data;
	}	
	
	// public function getDistricts_options(){
	// 	$distcode = ($this -> session -> District)?$this -> session -> District:(($this->input->post('distcode'))?$this->input->post('distcode'):'');
	// 	if(!$this->input->post('distcode')){
	// 		$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
	// 		$select .= "<option value=''>--Select District--</option>";	
	// 	}else{
	// 		$select = "<select class=\"form-control\" name=\"patient_address_distcode\" id=\"patient_address_distcode\" >";
	// 	}
	// 	$select .= ($distcode > 0)?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
	// 	$select .= "</select>";
	// 	echo $select;
	// }
	public function getDistricts_options(){
		//$distcode = ($this -> session -> District)?$this -> session -> District:(($this->input->post('distcode'))?$this->input->post('distcode'):'');
		$distcode = ($this->input->post('distcode'))?$this->input->post('distcode'):'';
		if(!$this->input->post('distcode')){
			$select = "<select class=\"form-control\" name=\"distcode\" id=\"distcode\" >";
			$select .= "<option value=''>--Select District--</option>";	
		}else{
			$select = "<select class=\"form-control\" name=\"patient_address_distcode\" id=\"patient_address_distcode\" >";
		}
		$select .= ($this->input->post('distcode'))?getDistricts_options(true,$distcode,'No'):getDistricts_options(true,$distcode,'Yes');
		$select .= "</select>";
		echo $select;
	}

	public function getOtherProvinceDistricts() {
		$procode = $this-> input-> post('procode');		
		// $data = $this-> Ajax_control_panel_model-> getOtherProvinceDistricts($procode);
		// echo $data;
		//echo $procode;
		$filepath = 'Ajax_red_rec/FetchDistrictsToOtherRegions';
		if($procode == '1'){
			$url = "";
		}
		if($procode == '2'){
			$url = "";
		}
		if($procode == '3'){
			//$url = "http://epimis.cres.pk/";
			$url = "http://epimis1.pacetec.net/";
		}
		if($procode == '4'){
			$url = "http://balochistan.epimis.pk/";
		}
		if($procode == '5'){
			//echo "abc";
			$url = "http://ajk.epimis.pk/";
		}
		if($procode == '6'){
			$url = "http://gb.epimis.pk/";
		}
		if($procode == '7'){
			$url = "http://islamabad.epimis.pk/";
		}
		if($procode == '8'){
			$url = "http://fata.epimis.pk/";
		}
		$url .= $filepath;
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$dataDistricts = curl_exec($ch);
		curl_close($ch);
		echo $dataDistricts;
		//$data['Districts'] = json_decode($dataDistricts,true);
		//print_r($data['Districts']);
		//echo $data['Districts'];
		
	}
	public function getProvinces_options(){	
		$select = getProvinces_options();		
		echo $select;
	}
	
	public function measles_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_control_panel_model -> measles_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function cross_notified_measles_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_control_panel_model -> cross_notified_measles_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}		
	public function red_map_upload(){
		if(!empty($_FILES)){
			$temp = $_FILES['file']['tmp_name'];
			$dir_separator = DIRECTORY_SEPARATOR;
			$folder = "uploads";
			$destination_path = FCPATH.$dir_separator.$folder.$dir_separator;
			$target_path = $destination_path.$_FILES['file']['name'];
			//print_r($target_path);
			move_uploaded_file($temp, $target_path);
		}
	}
	
	public function users_list_filter(){
		//print_r($_POST); exit();
		$distcode = $this-> input-> get('distcode');
		$level = $this-> input-> get('level');
		$utype = $this-> input-> get('utype');
		$data = $this-> Ajax_control_panel_model-> users_list_filter($distcode,$level,$utype);
		echo $data;
	}
	public function menu_list_filter()
	{
		$level = $this->input->get('level');
		$utype = $this->input->get('utype');
		$data = $this->Ajax_control_panel_model->menu_list_filter($level, $utype);
		echo $data;
	}
	
}
?>