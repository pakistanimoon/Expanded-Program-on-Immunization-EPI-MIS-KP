<?php
class Ajax_red_rec extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');		
		//authentication(); 
		$this -> load -> model('Ajax_red_rec_model');
		$this-> load-> model('red_microplan/Special_activities_model');
		$this-> load-> model('red_microplan/Situation_analysis_model');
		$this-> load-> model('red_microplan/Session_plan_model');
		$this-> load-> model('red_microplan/Red_strategy_model');
		$this-> load-> model('red_microplan/Facility_quarterplan_model');
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
	public function getFacility_RecordForm3() {
		$year = $this-> input-> post('year');	
		$facode = $this-> input-> post('facode');	
		$data = $this-> Ajax_red_rec_model-> getFacility_RecordForm3($year,$facode);
		echo $data;
	}
	public function form_a2_filter(){
		$facode = $this->input->get('facode');
		$data=$this -> Ajax_red_rec_model -> form_a2_filter($facode);
		echo $data;
	}	
	public function nnt_linelist_filter(){
		$uncode = $this->input->get('uncode');
		$data=$this -> Ajax_red_rec_model -> nnt_linelist_filter($uncode);
		echo $data;
	}	
	public function afp_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> afp_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function cross_notified_afp_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> cross_notified_afp_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function nnt_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$investigated_by = $this->input->get('investigated_by');
		$uncode = $this->input->get('uncode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week =$this->input->get('week');	  
		$data=$this -> Ajax_red_rec_model -> nnt_investigation_filter($distcode,$investigated_by,$uncode,$facode,$year,$week);		
		echo $data;
	}
	public function cross_notified_nnt_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$investigated_by = $this->input->get('investigated_by');
		$uncode = $this->input->get('uncode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week =$this->input->get('week');	  
		$data=$this -> Ajax_red_rec_model -> cross_notified_nnt_investigation_filter($distcode,$investigated_by,$uncode,$facode,$year,$week);		
		echo $data;
	}
	public function situation_analysis_filter(){
		$tcode = $this-> input-> get('tcode');
		$facode = $this-> input-> get('facode');
		$uncode = $this-> input-> get('uncode');
		$year = $this-> input-> get('year');  
		$data = $this-> Ajax_red_rec_model-> situation_analysis_filter($tcode, $facode, $uncode, $year);
		echo $data;
	}
	public function special_activities_filter(){
		$tcode = $this-> input-> get('tcode');
		$facode = $this-> input-> get('facode');
		$area_name = $this-> input-> get('area_name');
		$year = $this-> input-> get('year');  
		$data = $this-> Ajax_red_rec_model-> special_activities_filter($tcode, $facode, $area_name, $year);
		echo $data;
	}
	public function session_plan_filter(){
		$tcode = $this-> input-> get('tcode');
		$facode = $this-> input-> get('facode');
		$area_name = $this-> input-> get('area_name');
		$year = $this-> input-> get('year');  
		$data = $this-> Ajax_red_rec_model-> session_plan_filter($tcode, $facode, $area_name, $year);
		echo $data;
	}
	public function red_strategy_filter(){
		$tcode = $this-> input-> get('tcode');
		$uncode = $this-> input-> get('uncode');
		$facode = $this-> input-> get('facode');
		$year = $this-> input-> get('year');  
		$data = $this-> Ajax_red_rec_model-> red_strategy_filter($tcode, $uncode, $facode, $year);
		echo $data;
	}
	public function hf_quarterplan_filter(){
		$tcode = $this-> input-> get('tcode');
		$uncode = $this-> input-> get('uncode');
		$facode = $this-> input-> get('facode');
		$year = $this-> input-> get('year');
		$quarter = $this-> input-> get('quarter');  
		$data = $this-> Ajax_red_rec_model-> hf_quarterplan_filter($tcode, $uncode, $facode, $year, $quarter);
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
	public function form_a2_filter_new(){
		$campaign_type = $this->input->get('campaign_type');
		$data=$this -> Ajax_red_rec_model -> form_a2_filter_new($campaign_type);
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
	public function FetchDistrictsToOtherRegions() {
		//$procode = $this->uri->segment(3);		
		$data = $this -> Ajax_red_rec_model -> FetchDistrictsToOtherRegions();
		echo $data;
	}
	public function getOtherProvinceDistricts() {
		$procode = $this-> input-> post('procode');		
		// $data = $this-> Ajax_red_rec_model-> getOtherProvinceDistricts($procode);
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
			$url = "http://epimis.cres.pk/";
			
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
	public function generateEPI_case_code() {	
		$distcode = $this-> input-> post('distcode');		
		$case_type = $this-> input-> post('cases');
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_red_rec_model-> generateEPI_case_code($distcode,$case_type,$year);
		echo $data;
	}
	public function generateCoronavirus_case_number() {	
		$distcode = $this-> input-> post('distcode');
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_red_rec_model-> generateCoronavirus_case_number($distcode,$year);
		echo $data;
	}
	public function case_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> case_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function cross_notified_case_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> cross_notified_case_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	
	public function measles_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> measles_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function coronavirus_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> coronavirus_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function cross_notified_measles_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> cross_notified_measles_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	public function cross_notified_diphtheria_investigation_filter(){
		$distcode = $this->input->get('distcode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$data=$this -> Ajax_red_rec_model -> cross_notified_diphtheria_investigation_filter($distcode,$facode,$year,$week);
		echo $data;
	}
	//////////////////////////////////////red rac///////////////////////////////////////////
	public function situation_analysis_add()
	{	
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Situation_analysis_model-> situation_analysis_add($techniciancode,$year);
		
		$this-> load-> view('Add_red_microplanning/situation_analysis_add',$data);
        	
	}
	public function situation_analysis_edit()
	{	
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		
		$data['data'] = $this-> Situation_analysis_model->  situation_analysis_edit($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/situation_analysis_edit',$data);
        	
	}
	public function situation_analysis_view()
	{	
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);
		//print($techniciancode);
		//print($year);exit;
		$data['data'] = $this-> Situation_analysis_model->  situation_analysis_view($techniciancode,$year);
		//print_r($data);exit;
		$data['filter_view'] = $this-> uri -> segment(5);
		$this-> load-> view('Add_red_microplanning/situation_analysis_view',$data);
        	
	}
	
	public function special_activities_add(){ 
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Special_activities_model-> special_activities_add($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/special_activities_add',$data);
	}
	public function special_activities_edit()
	{	
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		
		$data['data'] = $this-> Special_activities_model->  special_activities_edit($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/special_activities_edit',$data);
        	
	}
	public function special_activities_view(){ 
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Special_activities_model-> special_activities_view($techniciancode,$year);
		//print_r($data);exit;
		$this-> load-> view('Add_red_microplanning/special_activities_view',$data);
	}
	public function session_plan_add(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Session_plan_model-> session_plan_add($techniciancode,$year);	
		$this-> load-> view('Add_red_microplanning/session_plan_add',$data);	
	}
	public function session_plan_edit()
	{	
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Session_plan_model->  session_plan_edit($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/session_plan_edit',$data);
        	
	}
	public function session_plan_view(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Session_plan_model-> session_plan_view($techniciancode,$year);	
		$this-> load-> view('Add_red_microplanning/session_plan_view',$data);	
	}
	public function red_strategy_add(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Red_strategy_model-> red_strategy_add($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/red_strategy_add');	
	}
	public function red_strategy_edit(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Red_strategy_model-> red_strategy_edit($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/red_strategy_edit',$data);	
	}
	public function red_strategy_view(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Red_strategy_model-> red_strategy_view($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/red_strategy_view',$data);	
	}
	public function hf_quarterplan_add(){
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Facility_quarterplan_model-> hf_quarterplan_add($techniciancode,$year);		
		$this-> load-> view('Add_red_microplanning/hf_quarterplan_add');	
	}
	public function superviosry_plan_filter(){
		$supervisor_type = $this-> input-> get('supervisor_type');
		$quarter = $this-> input-> get('quarter'); 
		$data = $this-> Ajax_red_rec_model-> superviosry_plan_filter($supervisor_type, $quarter);
		echo $data;
	}
	public function red_map_add(){		
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4); 
		$data['data'] = $this-> Situation_analysis_model-> red_map_add($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/red_map_add',$data);	
	}
	public function red_map_view()
	{
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Situation_analysis_model-> red_map_view($techniciancode,$year);	
		//print_r($data['data'])	;
		$this-> load-> view('Add_red_microplanning/red_map_view',$data);
	}
	public function red_map_edit()
	{
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Situation_analysis_model-> red_map_edit($techniciancode,$year);	
		//print_r($data['data'])	;
		$this-> load-> view('Add_red_microplanning/red_map_edit',$data);
	}
	public function getTechnicians() {
		$facode = $this-> input-> post('facode');	
		$data = $this-> Ajax_red_rec_model-> getTechnicians($facode);
		echo $data;
	}
	public function getTechredrec() {
		$facode = $this-> input-> post('facode');	
		$year = $this-> input-> post('year');	
		$data = $this-> Ajax_red_rec_model-> getTechredrec($facode,$year);
		echo $data;
	}
	public function checkTechnician_avalible() {
		$faicode = $this-> input-> post('faicode');	
		$techniciancode = $this-> input-> post('techniciancode');	
		$selectedyear = $this-> input-> post('selectedyear');	
		$data = $this-> Ajax_red_rec_model-> checkTechnician_avalible($faicode,$techniciancode,$selectedyear);
		echo $data;
	}
	public function checkTechnician_avalible_list() {
		$techniciancode = $this-> input-> post('techniciancode');	
		$year = $this-> input-> post('year');	
		$facode = $this-> input-> post('facode');	
		$quarter = $this-> input-> post('quarter');
		$data = $this-> Ajax_red_rec_model-> checkTechnician_avalible_list($techniciancode,$quarter,$facode,$year);
		echo $data;
	}
	public function checkQuarter_avalible_list() {
		$techniciancode = $this-> input-> post('techniciancode');	
		$year = $this-> input-> post('year');	
		$facode = $this-> input-> post('facode');	
		$quarter = $this-> input-> post('quarter');
		$data = $this-> Ajax_red_rec_model-> checkQuarter_avalible_list($techniciancode,$quarter,$facode,$year);
		echo $data;
	}
	public function getAreaAndSession() {
		$techniciancode = $this-> input-> post('techniciancode');
		$year = $this-> input-> post('year');
		//$year = $this-> input-> post('year');
		$quarter = $this-> input-> post('quarter');
		
		$data['var'] = $this-> Ajax_red_rec_model-> getAreaAndSession($techniciancode,$year,$quarter);
		
		//$data = $this-> Ajax_red_rec_model-> getAreaAndSession();
		  
		///$data =$techniciancode;
		print_r ($data);
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
	
	public function excel_situation_analysis_view(){	
		//if request is from excel
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Situation_analysis.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Situation_analysis_model->  situation_analysis_view($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/excel/excel_situation_analysis_view',$data);
        	
	} 
	public function excel_special_activities_view(){
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Special_Activities.xls");
		header("Pragma: no-cache");
		header("Expires: 0"); 
		$techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Special_activities_model-> special_activities_view($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/excel/excel_special_activities_view',$data);
	}
	public function excel_session_plan_view(){	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Session_Plan.xls");
		header("Pragma: no-cache");
		header("Expires: 0"); 	
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);	
		$data['data'] = $this-> Session_plan_model-> session_plan_view($techniciancode,$year);	
		$this-> load-> view('Add_red_microplanning/excel/excel_session_plan_view',$data);	
	}
	public function excel_red_strategy_view(){	
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=Red_Strategy.xls");
		header("Pragma: no-cache");
		header("Expires: 0");	
        $techniciancode = $this-> uri -> segment(3);
		$year = $this-> uri -> segment(4);		
		$data['data'] = $this-> Red_strategy_model-> red_strategy_view($techniciancode,$year);
		$this-> load-> view('Add_red_microplanning/excel/excel_red_strategy_view',$data);	
	}
	public function aefi_filter(){
		$tcode = $this->input->get('tcode');
		$uncode = $this->input->get('uncode');
		$facode = $this->input->get('facode');
		$year = $this->input->get('year');
		$week = $this->input->get('week');
		$complaints = $this->input->get('complaints');
		$data=$this -> Ajax_red_rec_model -> aefi_filter($tcode,$uncode,$facode,$year,$week,$complaints);
		echo $data;
	}
	public function checkPatientCNICNumber(){
		$cnic = $this->input->post('cnic');
		$data=$this -> Ajax_red_rec_model -> checkPatientCNICNumber($cnic);
		echo $data;
	}

	public function getVaccine_batchNumber(){
		$vacc_id = $this->input->post('vacc_id');
		$data = $this -> Ajax_red_rec_model -> getVaccine_batchNumber($vacc_id);
		echo $data;
	}

	public function get_vaccine_expirydate(){
		$batch_number = $this->input->post('batch_number');
		$data = $this -> Ajax_red_rec_model -> get_vaccine_expirydate($batch_number);
		echo $data;
	}
}
?>