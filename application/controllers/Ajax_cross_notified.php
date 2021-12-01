<?php
class Ajax_cross_notified extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		//authentication(); 
		$this -> load -> model('Ajax_cross_notified_model');
	}	
	public function quickSearch(){
		$searchParam = $this->input->get('searchParam');		
		$facode = $this->input->get('facode'); 
		$distcode = $this->input->get('distcode');
		$fmonth = $this->input->get('ym');
		$fatype = $this->input->get('fatype');
		$data=$this -> Ajax_red_rec_model -> searchParam($facode,$distcode,$fmonth,$fatype,$searchParam);
		echo $data;
	}
	public function generateCode() {		
		$uncode = $this-> input-> get('uncode');	
		$data = $this-> Ajax_red_rec_model-> generateCode($uncode);
		echo $data;
	}
	public function getFacilities() {
		$data = $this -> Ajax_red_rec_model -> getFacilities();
		echo $data;
	}
	public function getFacTehsils() {		
		$data = $this -> Ajax_red_rec_model -> getFacTehsils();
		echo $data;
	}
	public function getUnC() {
		$tcode = ($this -> input -> post('tcode'))?$this -> input -> post('tcode'):$this -> uri -> segment(3);
		$data = $this -> Ajax_red_rec_model -> getUnC($tcode);
		echo $data;
	}
	public function getFacilitiesforForm2() {
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_red_rec_model-> getFacilitiesforForm2($year);
		echo $data;
	}
	public function getFacilitiesforForm3() {
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_red_rec_model-> getFacilitiesforForm3($year);
		echo $data;
	}
	public function getFacility_RecordForm2() {
		$year = $this-> input-> post('year');	
		$facode = $this-> input-> post('facode');	
		$data = $this-> Ajax_red_rec_model-> getFacility_RecordForm2($year,$facode);
		echo $data;
	}
	public function getFacilitiesTHS() {		
		$data = $this-> Ajax_red_rec_model-> getFacilitiesTHS();
		echo $data;
	}
	public function getAreaNameFacode() {		
		$data = $this-> Ajax_red_rec_model-> getAreaNameFacode();
		echo $data;
	}
	public function getHFOpeningBal(){
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');		
		$data=$this -> Ajax_red_rec_model -> getHFOpeningBal($month,$year,$facode);
		echo $data;
	}
	public function getHFRepOpeningBal(){
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$facode = $this->input->post('facode');		
		$data=$this -> Ajax_red_rec_model -> getHFRepOpeningBal($month,$year,$facode);
		echo $data;
	}	
	public function getcase_definition() {		
		$case_type = $this -> input -> post('case_type');		
		$data = $this -> Ajax_red_rec_model -> getcase_definition($case_type);
		echo $data;
	}
	public function validateMeasleNumber() { 
		$measleNumber = $this-> input-> post('measleNumber');
		$data = $this-> Ajax_red_rec_model-> validateMeasleNumber($measleNumber);
		echo $data; 
	}
	public function getMeasleNumber() {
		$year = $this-> input-> post('year');
		$epid_code = $this-> input-> post('epid_code');
		$data = $this-> Ajax_red_rec_model-> getMeasleNumber($year, $epid_code);  
		echo $data;
	}
	public function getCaseCode() {
		$short_name = $this-> input-> post('short_name');
		$data = $this-> Ajax_red_rec_model-> getCaseCode($short_name);  
		echo $data;
	}	
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
	public function getProvinces_options(){	
		$select = getProvinces_options();		
		echo $select;
	}
	
	public function getOtherProvinceDistricts() {
		$procode = $this-> input-> post('procode');		
		// $data = $this-> Ajax_cross_notified_model-> getOtherProvinceDistricts($procode);
		// echo $data;
		// echo $procode;
		$filepath = 'Ajax_cross_notified/FetchDistrictsToOtherRegions';
		$url = $this -> getSingleRegionUrl($procode);
		$dataDistricts = $this -> getAdministrativeUnits($url, $filepath, $procode);
		echo $dataDistricts;
				
	}
	public function getOtherProvinceTehsils() {
		$distcode = $this-> input-> post('distcode');
		$procode = substr($distcode,0,1);		
		//$procode = $this -> session -> Province;		
		// $data = $this-> Ajax_cross_notified_model-> getOtherProvinceDistricts($procode);
		// echo $data;
		// echo $procode;
		$filepath = 'Ajax_cross_notified/FetchTehsilsToOtherRegions';
		$url = $this -> getSingleRegionUrl($procode);
		$dataDistricts = $this -> getAdministrativeUnits($url, $filepath, $procode, $distcode);
		echo $dataDistricts;
				
	}
	public function getOtherProvinceUCs() {
		$tcode = $this-> input-> post('tcode');
		//$distcode =$this -> session -> District;
		$distcode = substr($tcode,0,3);
		$procode = substr($tcode,0,1);				
		//$procode = $this -> session -> Province;				
		// $data = $this-> Ajax_cross_notified_model-> getOtherProvinceDistricts($procode);
		// echo $data;
		// echo $procode;
		$filepath = 'Ajax_cross_notified/FetchUCsToOtherRegions';
		$url = $this -> getSingleRegionUrl($procode);
		$dataDistricts = $this -> getAdministrativeUnits($url, $filepath, $procode, $distcode, $tcode);
		echo $dataDistricts;
				
	}
	function getSingleRegionUrl($procode){
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
		$baseUrl = base_url();
		if($baseUrl == $liveUrl){
			switch($procode){
				case  "1":
					return "http://federal.epimis.pk/";
					break;
				case  "2":
					return "http://federal.epimis.pk/";
					break;
				case  "3":
					return "http://epimis.cres.pk/";
					break;
				case  "4":
					return "http://balochistan.epimis.pk/";
					break;
				case  "5":
					return "http://ajk.epimis.pk/";
					break;
				case  "6":
					return "http://gb.epimis.pk/";
					break;
				case  "7":
					return "http://islamabad.epimis.pk/";
					break;
				case  "8":
					return "http://fata.epimis.pk/";
					break;
				default:
					return NULL;
					break;
			}
		}
		else{
			switch($procode){
				case  "1":
					return "http://epifederal.pacemis.com/";
					break;
				case  "2":
					return "http://epifederal.pacemis.com/";
					break;
				case  "3":
					return "http://epikp.pacemis.com/";
					//return "http://epibeta.pacemis.com/";
					break;
				case  "4":
					return "http://epiblch.pacemis.com/";
					break;
				case  "5":
					return "http://epiajk.pacemis.com/";
					break;
				case  "6":
					return "http://epigb.pacemis.com/";
					break;
				case  "7":
					return "http://epiict.pacemis.com/";
					break;
				case  "8":
					return "http://epifata.pacemis.com/";
					break;
				default:
					return NULL;
					break;
			}
		}
	}
	function getAdministrativeUnits($url=NULL,$filepath=NULL,$procode=NULL,$distcode=NULL,$tcode=NULL)
	{		
		$data = array('procode' => $procode,'distcode' => $distcode,'tcode' => $tcode,);
		//post data mechanism
		$fields_string = "";
		foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		$fields_string = rtrim($fields_string, '&');
		//$filepath = 'API/Receiver/get_cc_assetType_counts';
		//url to post
		if($url===NULL)
			$url = "http://epimis.cres.pk/";
		$url .= $filepath;
		//curl options
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);		
		curl_setopt($ch,CURLOPT_POST, count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		$head = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);				
		curl_close($ch);
		//workout for data in response
		//$userData = json_decode($head, true);
		if(isset($head)){
			return $head;
		}else{
			return array();
		}
	}
	public function FetchDistrictsToOtherRegions() {
		$procode = $this-> input-> post('procode');		
		$data = $this -> Ajax_cross_notified_model -> FetchDistrictsToOtherRegions($procode);
		echo $data;
	}
	public function FetchTehsilsToOtherRegions() {
		$distcode = $this-> input-> post('distcode');	
		$data = $this -> Ajax_cross_notified_model -> FetchTehsilsToOtherRegions($distcode);
		echo $data;
	}
	public function FetchUCsToOtherRegions() {
		$tcode = $this-> input-> post('tcode');	
		$data = $this -> Ajax_cross_notified_model -> FetchUCsToOtherRegions($tcode);
		echo $data;
	}
	public function getLinked_EpidNumber(){
		$distcode = $this->input->post('distcode');
		$year = date('Y');
		$data=$this -> Ajax_cross_notified_model -> getLinked_EpidNumber($distcode,$year);
		//print_r($data);
		echo json_encode(array_column($data,"case_epi_no"),true);
	}
	public function getLinked_CaseInformation(){
		$linked_epid_number = $this -> input -> post('linked_epid_number');
		$data['LinkedCase'] = $this -> Ajax_cross_notified_model -> getLinked_CaseInformation($linked_epid_number);
		//print_r($data);
		echo json_encode($data['LinkedCase']);
	} 
}
?>