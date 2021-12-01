<?php
class Data_entry extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		if($this -> uri -> segment(1) == 'FLCF-MVRF1'){
			
		}else{
			authentication();
		}		
		$this -> load -> model ('Data_entry_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		$this->load->library('form_validation');
		$this -> load -> helper('my_functions_helper');
	}
	//============================ Constructor Function Ends ============================//
	//-----------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for District Monthly EPI Reports Starts ======//
	public function dmr_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0) {
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epidmr"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> dmr_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint']=$startpoint;
		
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/dmr_list';
			$data['pageTitle']='EPI-MIS | List of District Monthly Reports';
			$this->load->view('template/epi_template',$data);
		}else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Listing Page for District Monthly EPI Reports Ends =======//
	//----------------------------------------------------------------------------------//
	//====== Function to Show View Page for a District Monthly EPI Report Starts =======//
	public function dmr_view(){
		idataEntryValidator(0);
		$distcode = $this -> uri -> segment(3);
		$fmonth   = $this -> uri -> segment(4);
		
		$data = $this -> Data_entry_model -> dmr_view($distcode,$fmonth);
		$data['monthname'] = monthname(substr($fmonth,5));
		
		$data['year']=substr($fmonth,0,4);
		$data['month']=substr($fmonth,5);
		if($data != 0 && $data != '404'){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/dmr_view';
			$data['pageTitle']='EPI-MIS | District Monthly Report View';
			$this->load->view('template/epi_template',$data);
			
		}
		else if ($data == '404'){
			$data['message'] ="Your Session is expired! Please login Again .";
			$this -> load -> view ('message',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show View Page for a District Monthly EPI Report Ends =========//
	//----------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a District Monthly EPI Report Starts =======//
	public function dmr_edit(){
		dataEntryValidator(0);
		$distcode = $this -> uri -> segment(3);
		$fmonth   = $this -> uri -> segment(4);
		$data = $this -> Data_entry_model -> dmr_edit($distcode,$fmonth);
		$data['monthname'] = monthname(substr($fmonth,5));
		$data['year']=substr($fmonth,0,4);
		$data['month']=substr($fmonth,5);
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/dmr_edit_view';
			$data['pageTitle']='EPI-MIS | Update District Monthly Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Edit Page for a District Monthly EPI Report Ends ============//
	//-------------------------------------------------------------------------------------//
	//====== Function to Show Add Page for New District Monthly EPI Report Starts =========//
	public function dmr(){
		dataEntryValidator(0);
		$data = $this -> Data_entry_model -> dmr();
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/dmr';
			$data['pageTitle']='EPI-MIS | Add New District Monthly Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Add Page for New District Monthly EPI Report Ends ===================//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Save New or Update Existing District Monthly EPI Report Starts ===========//
	public function dmr_save(){	
	    dataEntryValidator(0);		
		$currentMon = date('m',strtotime('last month'));
		$currentYear = date('Y');	
		$month=$this -> input -> post('month');
		$year=$this -> input -> post('year');
		if($month > $currentMon || $year > $currentYear){
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Advance Month/Year Report cannot be added");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}	
		$fmonth   = $year."-".$month;
		$distcode = $this -> session -> District;
		$procode  = $this -> session -> Province;
		$data = array(			
			'distcode' => $distcode,
			'fmonth' => $fmonth,
			'procode' => $procode,
			'tot_uc' => $this -> input -> post('total_uc') ? $this -> input -> post('total_uc') : '0',
			'tot_epi_center' => $this -> input -> post('tot_epi_centers') ? $this -> input -> post('tot_epi_centers') : '0',
			'tot_population' => $this -> input -> post('tot_population') ? $this -> input -> post('tot_population') : '0' ,
			'fixed_planned' => $this -> input -> post('fixed_planned') ? $this -> input -> post('fixed_planned') : '0',
			'fixed_conducted' => $this -> input -> post('fixed_conducted') ? $this -> input -> post('fixed_conducted') : '0',
			'tot_target_children' => $this -> input -> post('tot_target_children') ? $this -> input -> post('tot_target_children') : '0',
			'mobile_planned' => $this -> input -> post('mobile_planned') ? $this -> input -> post('mobile_planned') : '0',
			'mobile_conducted' => $this -> input -> post('mobile_conducted') ? $this -> input -> post('mobile_conducted') : '0',
			'monthly_birth_target' => $this -> input -> post('monthly_birth_target') ? $this -> input -> post('monthly_birth_target') : '0',
			'outreach_planned' => $this -> input -> post('outreach_planned') ? $this -> input -> post('outreach_planned') : '0',
			'outreach_conducted' => $this -> input -> post('outreach_conducted') ? $this -> input -> post('outreach_conducted') : '0',
			'monthly_surviving_target' => $this -> input -> post('monthly_surviving_target') ? $this -> input -> post('monthly_surviving_target') : '0',
			'health_houses_planned' => $this -> input -> post('health_houses_planned') ? $this -> input -> post('health_houses_planned') : '0',
			'health_houses_conducted' => $this -> input -> post('health_houses_conducted') ? $this -> input -> post('health_houses_conducted') : '0',
			'monthly_pregnant_target' => $this -> input -> post('monthly_pregnant_target') ? $this -> input -> post('monthly_pregnant_target') : '0',
			'dsv_name' => $this -> input -> post('dsv_name') ? $this -> input -> post('dsv_name') : '',
			'cord_name' => $this -> input -> post('cord_name') ? $this -> input -> post('cord_name') : '0',
			'dho_name' => $this -> input -> post('dho_name') ? $this -> input -> post('dho_name') : '0',
			'polio_total' => $this -> input -> post('polio_total') ? $this -> input -> post('polio_total')  : '0',
			'bcg_total' => $this -> input -> post('bcg_total') ? $this -> input -> post('bcg_total')  : '0',
			'birth_hepb_total' => $this -> input -> post('birth_hepB_total') ? $this -> input -> post('birth_hepB_total')  : '0',
			'polio_1_total' => $this -> input -> post('polio_1_total') ? $this -> input -> post('polio_1_total')  : '0',
			'polio_2_total' => $this -> input -> post('polio_2_total') ? $this -> input -> post('polio_2_total')  : '0',
			'polio_3_total' => $this -> input -> post('polio_3_total') ? $this -> input -> post('polio_3_total')  : '0',
			'penta_1_total' => $this -> input -> post('penta_1_total') ? $this -> input -> post('penta_1_total')  : '0',
			'penta_2_total' => $this -> input -> post('penta_2_total') ? $this -> input -> post('penta_2_total')  : '0',
			'penta_3_total' => $this -> input -> post('penta_3_total') ? $this -> input -> post('penta_3_total')  : '0',
			'pcv_1_total' => $this -> input -> post('pcv_1_total') ? $this -> input -> post('pcv_1_total')  : '0',
			'pcv_2_total' => $this -> input -> post('pcv_2_total') ? $this -> input -> post('pcv_2_total')  : '0',
			'pcv_3_total' => $this -> input -> post('pcv_3_total') ? $this -> input -> post('pcv_3_total')  : '0',
			'measles_1_total' => $this -> input -> post('measles_1_total') ? $this -> input -> post('measles_1_total')  : '0',
			'measles_2_total' => $this -> input -> post('measles_2_total') ? $this -> input -> post('measles_2_total')  : '0'
		);
		if($this -> input -> post('recid')){
			$data['id']=$this -> input -> post('recid');
		}
		$inputsArray = array('fixed','outreach','mobile','healthhouse','pl','cba','all');
		for($row=1;$row<=14;$row++){
			for($column=1;$column<=4;$column++){
				$field="cv_r".$row."_f".$column;
				$data[$field]=$this -> input -> post($field) ? $this -> input -> post($field) : '0';
			}
		}
		for($row=1;$row<=10;$row++){
			for($column=1;$column<=4;$column++){
				$field="wv_r".$row."_f".$column;
				$data[$field]=$this -> input -> post($field) ? $this -> input -> post($field) : '0';
			}
		}
		for($i=1;$i<=5;$i++){
			for($j=0;$j<sizeof($inputsArray);$j++){
				$field="tt".$i."_".$inputsArray[$j]."_total";
				$data[$field]=$this -> input -> post($field) ? $this -> input -> post($field) : '0';
			}
		}
		$data = $this -> Data_entry_model -> dmr_save($data,$distcode,$fmonth);
		if($data != 0){
			$this -> load -> view ('data_entry/dmr_list',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Save New or Update Existing District Monthly EPI Report Ends =============//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Monthly Surveillance EPI Reports Starts ============//
	public function msr_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "msr"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> msr_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/msr_list';
			$data['pageTitle']='EPI-MIS | Monthly Surveillance Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Listing Page for Monthly Surveillance EPI Reports Ends ================//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show View Page for a Monthly Surveillance EPI Reports Starts ===============//
	public function msr_view(){
		dataEntryValidator(0);
		$facode=$this -> uri -> segment(3);
		$fmonth=$this -> uri -> segment(4);
		
		$data = $this -> Data_entry_model -> msr_view($facode,$fmonth);
		$data['monthname'] = monthname(substr($fmonth,5));
		
		$data['year']=substr($fmonth,0,4);
		$data['month']=substr($fmonth,5);
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/msr_view';
			$data['pageTitle']='EPI-MIS | Monthly Surveillance Report View';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show View Page for a Monthly Surveillance EPI Reports Ends ===============//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Reports Starts =============//
	public function msr_edit(){
		dataEntryValidator(0);
		$facode=$this -> uri -> segment(3);
		$fmonth=$this -> uri -> segment(4);

		$data = $this -> Data_entry_model -> msr_edit($facode,$fmonth);
		$data['monthname'] = monthname(substr($fmonth,5));
		
		$data['year']=substr($fmonth,0,4);
		$data['month']=substr($fmonth,5);
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/msr_edit';
			$data['pageTitle']='EPI-MIS | Update Monthly Surveillance Report';
			$this->load->view('template/epi_template',$data);		
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Report Ends ==============//
	//-------------------------------------------------------------------------------------------//
	//====== Function to Show Add Page for a Monthly Surveillance EPI Report Starts =============//
	public function msr(){
		dataEntryValidator(0);
		$data = $this -> Data_entry_model -> msr();
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/msr';
			$data['pageTitle']='EPI-MIS | Add New Monthly Surveillance Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Report Ends ======================//
	//---------------------------------------------------------------------------------------------------//
	//====== Function to Save New or Update Existing Monthly Surveillance EPI Report Starts =============//
	public function msr_save(){
		dataEntryValidator(0);
		$currentMon = date('m',strtotime('last month'));
		$currentYear = date('Y');	
		$month=$this -> input -> post('month');
		$year=$this -> input -> post('year');
		if($month > $currentMon || $year > $currentYear){
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Advance Month/Year Report cannot be added");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}	
		$fmonth   = $year."-".$month;
		$distcode = $this -> session -> District;
		$procode  = $this -> session -> Province;
		$facode   = $this -> input -> post('facode');
		$data = array(
			'distcode' => $distcode,
			'fmonth' => $fmonth,
			'procode' => $procode,
			'facode' => $this -> input -> post('facode') ? $this -> input -> post('facode') : '0',
			'epi_cord_name' => $this -> input -> post('epi_cord_name') ? $this -> input -> post('epi_cord_name') : '',
			'epi_demiologist_name' => $this -> input -> post('epi_demiologist_name') ? $this -> input -> post('epi_demiologist_name') : '' 
		);
		if($this -> input -> post('recid')){
			$data['id']=$this -> input -> post('recid');
		}
		for($row=1;$row<=9;$row++){
			for($column=1;$column<=9;$column++){
				$field="sr_r".$row."_f".$column;
				$data[$field]=$this -> input -> post($field) ? $this -> input -> post($field) : '0';
			}
		}
		$data = $this -> Data_entry_model -> msr_save($data,$facode,$distcode,$fmonth);
		if($data != 0){
			$this -> load -> view ('data_entry/msr_list',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//====== Function to Save New or Update Existing Monthly Surveillance EPI Report Ends ===============//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fmvrf_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "flcf_vacc_mr"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> fmvrf_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/fmvrf_list';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fmvrf_edit($facode,$fmonth){
		dataEntryValidator(0);
		$facode = $this -> uri -> segment(3);
		$fmonth = $this -> uri -> segment(4);
		dataEntryValidator();
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly vaccination Reports List', '/Data_entry/fmvrf_list');
		$this->breadcrumbs->push('Update Facility Monthly vaccination Report', '/Data_entry/fmvrf_edit');
		///////////////////////////////////////////////////////////////////
		$data = $this -> Data_entry_model -> fmvrf_edit($facode,$fmonth);
		$district = $this -> session -> District;
		if($data != 0){ 
						
			$data['data']=$data;
			$data['edit'] = "Yes";
			$data['fileToLoad'] = 'data_entry/fmvrf';
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$data['pageTitle']='EPI-MIS | Edit Facility Monthly Vaccination Report Form';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fmvrf_view(){
		dataEntryValidator(0);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly vaccination Reports List', '/Data_entry/fmvrf_list');
		$this->breadcrumbs->push('View Facility Monthly vaccination Report', '/Data_entry/fmvrf_view');
		///////////////////////////////////////////////////////////////////
		$facode=$this -> uri -> segment(3);
		$fmonth=$this -> uri -> segment(4);
		$data = $this -> Data_entry_model -> fmvrf_edit($facode,$fmonth);
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/fmvrf_view';
			$data['pageTitle']='EPI-MIS | View Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fmvrf(){
		    dataEntryValidator(0);
		    $district = $this -> session -> District;
			$data['data']="";
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$data['edit']="Yes";
			$data['fileToLoad'] = 'data_entry/fmvrf';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data);
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function alpha_spaces($str)
	{
		return (bool) preg_match('/^[a-z .,\-]+$/i',$str);
	}
	public function zero($str)
	{
		return (bool) preg_match('"0"',$str);
	}
	function select_validate($selectValue)
	{
	  if($selectValue == '0')
	    {
	        $this->form_validation->set_message('select_validate', 'Please select Health Facility Name');
	        return false;
	    }
	    else 
	    {
	        return true;
	    }
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fmvrf_save(){
		dataEntryValidator(0);
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		dataEntryValidator();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		//$this->form_validation->set_rules('facode','Health Facility Name:','trim|required|callback_select_validate');
		$this->form_validation->set_rules('tc_male','Monthly Target For Children 0-11 M','trim|numeric');
		$this->form_validation->set_rules('cri_r17_f1','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f2','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f7','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f8','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f9','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f10','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r17_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r13_f3','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f4','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f9','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f10','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r13_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r12_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r12_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r12_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r12_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r11_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r11_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r11_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r11_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r10_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r10_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r10_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r10_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r3_f3','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f4','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f9','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f10','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r3_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r2_f3','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f4','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f9','Vaccinator and House Hold of readonly' ,'trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f10','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r2_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		$this->form_validation->set_rules('cri_r1_f3','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f4','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f5','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f6','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f9','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f10','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f11','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		$this->form_validation->set_rules('cri_r1_f12','Vaccinator and House Hold of readonly','trim|required|callback_zero');
		
		if($this -> input -> post('month') ){
			if ($this->form_validation->run() === FALSE) 
			{
					
				$this->fmvrf();
			
			}
			else{
				$month=$this -> input -> post('month');
				$year=$this -> input -> post('year');
				$facode=$this -> input -> post('facode');
				validateAdvanceMonthYearSelection($month, $year, $facode);
				$fmonth   = $year."-".$month;
				if(!$this -> input -> post('recid')){
				validateAlreadyInsertedRecord('flcf_vacc_mr', "facode='$facode'", "fmonth='$fmonth'");
				}
		        $distcode = $this -> session -> District;
				$procode  = $this -> session -> Province;
				$facode   = $this -> input -> post('facode');
				unset($_POST["month"]);
				unset($_POST["year"]);
				unset($_POST["hfcode"]);
				$data=$_POST;
				//custom fields
				$data["facode"]=$facode;
				$data["distcode"]=$distcode;
				$data["procode"]=$procode;
				$data["fmonth"]=$fmonth;
				$data["submitted_date"]=date("Y-m-d");
				$data = $this -> Data_entry_model -> fmvrf_save($data);
				
				if($data != 0){
					$this -> load -> view ('data_entry/fmvrf_list',$data);
				}
				else{
					$data['message'] ="You must have rights to access this page."; 
					$this -> load -> view ('message',$data);
				  }
				}
			}
	else {
		$this -> session -> set_flashdata('message','Select Month For Facility Vaccine Monthly Reports to Proceed!');
		redirect('Data_entry/fmvrf');
		 }
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	
	public function fmvrf_update($id){
		dataEntryValidator(0);
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		dataEntryValidator();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('facode','Facility Name','trim|required|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('tc_male','Monthly Target For Children 0-11 M','trim|numeric');
		if ($this->form_validation->run() === FALSE) 
		{
			$facode = $this -> input -> post('facode');
			$fmonth = $this -> input -> post('old_fmonth');
			$data = $this -> Data_entry_model -> fmvrf_edit($facode,$fmonth);
			$data['id'] = $id;
			$data['edit']="Yes";
			$data['data']="";
			$data['fileToLoad'] = 'data_entry/fmvrf';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data);
		}
		else
		{
			
		
		$facode   = $this -> input -> post('facode');
		if(!($facode>0)){
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Health Facility cannot be empty, Kindly select any facility");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
		$distcode = $this -> session -> District;
		$procode  = $this -> session -> Province;
		$old_facode   = $this -> input -> post('old_facode');
		$old_fmonth   = $this -> input -> post('old_fmonth');
		unset($_POST["old_facode"]);
		unset($_POST["old_fmonth"]);
		unset($_POST["hfcode"]);
		$data=$_POST;
		//custom fields
		$data["submitted_date"]=date("Y-m-d");
		//where clause fields
		$where["id"]=$id;
		$where["facode"]=$old_facode;
		$where["fmonth"]=$old_fmonth;
		$data = $this -> Data_entry_model -> fmvrf_update($data,$where);
		
		if($data != 0){
			$this -> load -> view ('data_entry/fmvrf_list',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
		
		}
	}	
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//	
	public function aefi_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "aefi_rep"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> aefi_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/aefi_list';
			$data['pageTitle']='EPI-MIS | Adverse Events Following Immunisation (AEFI) Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function aefi_edit($id){
		dataEntryValidator(0);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Adverse Events Following Immunisation (AEFI) Reports List', '/Data_entry/aefi_list');
		$this->breadcrumbs->push('Update Adverse Events Following Immunisation (AEFI) Report', '/Data_entry/aefi_edit');
		///////////////////////////////////////////////////////////////////
		$data = $this -> Data_entry_model -> aefi_reports($id);
		$district = $this -> session -> District;
		if($data != 0){
			$data['data']=$data;
			$data['edit'] = "yes";
			$data['fileToLoad'] = 'data_entry/aefi'; 
			$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name";
			$resultUnC=$this -> db -> query ($query);
			$data['resultUnC']= $resultUnC -> result_array();
			$data['pageTitle']='EPI-MIS | Edit Adverse Events Following Immunisation (AEFI) Report Form';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function aefi_view($id){
		//dataEntryValidator(0);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Adverse Events Following Immunisation (AEFI) Reports List', '/Data_entry/aefi_list');
		///////////////////////////////////////////////////////////////////
		$data = $this -> Data_entry_model -> aefi_reports($id);
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/aefi_view';
			$data['pageTitle']='EPI-MIS | View Adverse Events Following Immunisation (AEFI) Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function aefi(){
	      	dataEntryValidator(0);
		    $district = $this -> session -> District;
			$data['data']="";
			$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name";
			$resultUnC=$this -> db -> query ($query);
			$data['resultUnC']= $resultUnC -> result_array();
			$data['item_name'] = $this -> Data_entry_model -> get_vaccinename();
			$data['years'] = getEpiWeekYearsOptions('',true); 
			$data['fileToLoad'] = 'data_entry/aefi';
			$data['edit'] = 'yes';
			$data['pageTitle']='EPI-MIS | Adverse Events Following Immunisation (AEFI) Report Form';
			$this->load->view('template/epi_template',$data);
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function aefi_save(){
		dataEntryValidator(0);
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('cellnumber','Cell Number','trim|numeric|max_length[14]|min_length[11]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|callback_alpha_spaces'); 
		$this->form_validation->set_rules('casename','Name of Case','trim|required|callback_alpha_spaces');
		//$this->form_validation->set_rules('mc_other','Others','trim|required|'); 
		
		
		if ($this->form_validation->run() === FALSE) 
		{
			$this->aefi();
		} else {
			
		
		if(!($this -> input -> post('casename'))){
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("case name cannot be empty, Kindly enter a name");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
		//old validation end
		$distcode = $this -> input -> post('distcode');
		$procode  = $this -> session -> Province;
		$uncode   = $this -> input -> post('uncode');
		$facode   = $this -> input -> post('facode');
		$data=$_POST;
		//custom fields
		$data["procode"]=$procode;
		$data["rep_date"]=date("Y-m-d");
		/* if($data["dob"]=="")
		{
			$data["dob"] = NULL;
		} */
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			}
		$num=$this->input->post("week");
		$data['week']=(sprintf("%02d",$num)); 
		$data['fweek'] = $this -> input -> post('year')."-".sprintf("%02d",$num);
		
		$data = $this -> Data_entry_model -> aefi_save($data);		
		//print_r($data);
		if($data != 0){
			$this -> load -> view ('data_entry/aefi_list',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function aefi_update($id){
		dataEntryValidator(0);
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('cellnumber','Cell Number','trim|required|numeric|min_length[11]|max_length[14]');
		$this->form_validation->set_rules('fathername','Father Name','trim|required|callback_alpha_spaces'); 
		$this->form_validation->set_rules('casename','Name of Case','trim|required|callback_alpha_spaces');
		//$this->form_validation->set_rules('mc_other','Others','trim|required|');
		
		if ($this->form_validation->run() === FALSE) 
		{
				$this->aefi_edit($id);	
				/*
				$data['id']= $id;
								$data['data']="";
								$data['edit']="yes";
								$data['fileToLoad'] = 'data_entry/aefi';
								$data['pageTitle']='EPI-MIS | Adverse Events Following Immunisation (AEFI) Report Form';
								$this->load->view('template/epi_template',$data);*/
				
			
	     } else {
		if(!($this -> input -> post('casename'))){
			$script = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("case name cannot be empty, Kindly enter a name");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		}
		$distcode = $this -> input -> post('distcode');
		$procode  = $this -> session -> Province;
		$tcode   = $this -> input -> post('tcode');
		$uncode   = $this -> input -> post('uncode');
		$facode   = $this -> input -> post('facode');
		$data=$_POST;
		//custom fields
		$data["procode"]=$procode;
		$data["rep_date"]=date("Y-m-d");
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
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
			}
		/* unset($data["dob"]);unset($data["vacc_date"]);unset($data["vacc_exp"]);
		unset($data["datefrom"]);unset($data["dateto"]);
		$data["dob"] = date("Y-m-d",strtotime($this -> input -> post('dob')));
		$data["vacc_date"] = date("Y-m-d",strtotime($this -> input -> post('vacc_date')));
		$data["vacc_exp"] = date("Y-m-d",strtotime($this -> input -> post('vacc_exp')));
		$data["datefrom"] = date("Y-m-d",strtotime($this -> input -> post('datefrom')));
		$data["dateto"] = date("Y-m-d",strtotime($this -> input -> post('dateto'))); */
		//where clause fields
		$where["id"]=$id;
		$data = $this -> Data_entry_model -> aefi_update($data,$where);		
		if($data != 0){
			$this -> load -> view ('data_entry/aefi_list',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}		
		}
	}
	//==============================        Comment Here          =======================================//
	public function aefi_delete(){
		dataEntryValidator(0);
		$id = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$query = "DELETE from aefi_rep where id=$id";
		//echo $query; exit();
		$this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully deleted your record!');
		redirect('AEFI-CIF/List');
	}
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function vacc_wastage(){
		    dataEntryValidator(0);
			$data['data']="";
			$data['fileToLoad'] = 'data_entry/vacc_wastage';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccine Wastage Reports';
			$this->load->view('template/epi_template',$data);
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function consolidated_uc(){
		if (($_SESSION['utype']=='Manager')){
					$location = base_url();
           		echo '<script language="javascript" type="text/javascript"> alert("You don`t have access on this page");	window.location="'.$location.'"</script>';
			    }
			$data['data']="";
			$data['fileToLoad'] = 'data_entry/consolidated-union-councel';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Reports';
			$this->load->view('template/epi_template',$data);
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//========== Function to open page for adding new weekly vpd surveilliance report Starts ============//
	public function weekly_vpd_add(){
		dataEntryValidator(0);
		$distcode = $this -> session -> District;
		$query = "select epid_code from districts where distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['distCode'] = $result['epid_code'];
		$data['years'] = getEpiWeekYearsOptions(0,true);
		$data['data']=$data;
		//$data['edit']="Yes";
		$data['fileToLoad'] = 'data_entry/weekly_vpd';
		$data['pageTitle']='EPI-MIS | Weekly VPD Surveillance Reports';
		$this->load->view('template/epi_template',$data);
	}
	//========== Function to open page for adding new weekly vpd surveilliance report Ends ==============//
	//---------------------------------------------------------------------------------------------------//
	//================== Function to save new weekly vpd surveilliance report Starts ====================//
	public function weekly_vpd_save(){
		dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && ($this -> input -> post('facode') || $this -> input -> post('cross_notified')) && $this -> input -> post('year')){
			$data=$_POST;
			$data['procode']=$_SESSION["Province"]; 	
			$data['distcode']=$this -> session -> District;
			// if($this -> input -> post('facode')){
			if($this->input->post('ontime')){
				$data['ontime']="1";
			}else{
				$data['ontime']="0";
			}
			// 	$facode = $this -> input -> post('facode');
			// 	$fweek = $this -> input -> post('year')."-".sprintf("%02d",$num);
			// 	if(!$this -> input -> post('recid')){
			// 		validateAlreadyInsertedRecord('weekly_vpd', "facode='$facode'", "fweek='$fweek'");
			// 	}
			//  $fweek = $this -> input -> post('year')."-".sprintf("%02d",$num);
	  		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y");
			foreach($_POST as $key => $value)
			{
				$data[$key] = (($value=='' OR is_array($value))?NULL:$value);
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
			}
			//$mylist = $this->input->post("case_representation");
			$mylist = $this->input->post("case_representation")?$this->input->post("case_representation"):'';
			/* foreach($mylist as $row){
				$newlist[] = $row;
			}
			$case_representation=implode(',',$newlist); */
			$case_representation=NULL;
			if(isset($mylist) && $mylist!=''){
				foreach($mylist as $row){
						$newlist[] = $row;
				}
				$case_representation=implode(',',$newlist);
			}
			$data['case_representation']=$case_representation;			
			$year = $this -> input -> post('year');
			$week = $this -> input -> post('week');
			if($week!=''){
				$data['week'] = sprintf("%02d",$week);
				$data['fweek'] = $year."-".sprintf("%02d",$week);
			}
			$data['procode'] = $_SESSION["Province"];
			$data["submitted_date"]=date("Y-m-d");
			//$data['fweek'] = $this -> input -> post('year')."-".sprintf("%02d",$week);
			//print_r($data);exit;
			if($this -> input -> post('cross_notified') && !($this -> input -> post('recid'))){	
				$data['cross_notified_from_distcode'] = $this -> session -> District;
				$data['approval_status'] = "Pending";
			}
			//echo '<pre>'; print_r($data); exit;	
			if($this -> input -> post('recid'))
			{	//echo '<pre>';print_r($data);exit();
				unset($data['edit']);

				$updated_id = $this -> Common_model -> update_record('weekly_vpd',$data,array('recid' => $this -> input -> post('recid') ));
				createTransactionLog("Data Entery", "Weekly VPD Updated");
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Disease-Surveillance/List');
			}else{
				$inserted_id = $this -> Common_model -> insert_record('weekly_vpd',$data);
				createTransactionLog("Data Entery", "New Weekly VPD Surveilliance Report Added ");
				$this -> session -> set_flashdata('message','Your Case has been successfully submitted');
				redirect('Disease-Surveillance/List');
			}
			/* $case_representation=implode(',',$newlist);
			$data['case_representation']=$case_representation;
			$num=$this->input->post("week");
			$data['week']=(sprintf("%02d",$num));
			$data['procode'] = $_SESSION["Province"];
			$data["submitted_date"]=date("Y-m-d");
			$data['fweek'] = $this -> input -> post('year')."-".sprintf("%02d",$num);
			if($this -> input -> post('recid'))
			{	
				$updated_id = $this -> Common_model -> update_record('weekly_vpd',$data,array('recid' => $this -> input -> post('recid'), 'facode' => $facode ));
				createTransactionLog("Data Entery", "Weekly VPD Updated");
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Disease-Surveillance/List');
			}else{
				$inserted_id = $this -> Common_model -> insert_record('weekly_vpd',$data);
				createTransactionLog("Data Entery", "New Weekly VPD Surveilliance Report Added ");
				$this -> session -> set_flashdata('message','Your Case has been successfully submitted');
				redirect('Disease-Surveillance/List');
			} */
		}else{
			$this -> session -> set_flashdata('message','Select District, Health Facility && UnionCouncil For Weekly VPD Surveilliance Report to Proceed!');
			redirect('Disease-Surveillance/Add');
		}
	}
	//=================== Function to save new weekly vpd surveilliance report Ends =====================//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to Approve existing weekly vpd surveilliance reports Starts ==============//
	public function weekly_vpd_Approve(){
		dataEntryValidator(0);
		if($this -> input -> post('facode')>0 ){
			$distcode = $this -> session -> District;
			// $query = "select facode from districts where distcode='$distcode'";
			// $result = $this -> db -> query($query);
			// $result = $result -> row_array();
			// $data['dcode'] = $result['epid_code'];
			// $data['case_epi_no'] = $this -> input -> post('case_epi_no');
			$data['facode'] = $this -> input -> post('facode');
			//$data['measles_number'] = $this -> input -> post('measles_number');
			$data['approval_status'] = "Approved";
			$updated_id = $this -> Common_model -> update_record('weekly_vpd',$data,array('recid' => $this->input->post('recid')));
			$this -> session -> set_flashdata('message','You have successfully approved cross notified case!');
			redirect('Disease-Surveillance/List');
		}else{
			$this -> session -> set_flashdata('message','You must select Health Facility!');
			redirect($this->session->flashdata('redirectToCurrent'));
		}
	}
	//=================== Function to Approve weekly vpd surveilliance report Ends =====================//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open list for existing weekly vpd surveilliance reports Starts ==============//
	
	public function weekly_vpd_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "weekly_vpd"; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Data_entry_model -> weekly_vpd_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/weekly_vpd_list';
			$data['pageTitle']='EPI-MIS | Weekly VPD Surveilliance Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//========= Function to open list for existing weekly vpd surveilliance reports Ends ================//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open edit page for existing weekly vpd surveilliance reports Starts =========//
	public function weekly_vpd_edit($recid){
		dataEntryValidator(0);
		$distcode = $this -> session -> District;
		$recid = $this -> uri -> segment(3);
		//dataEntryValidator();
		$data['years'] = getAllYearsOptions(true);
		
		$mainQuery = "SELECT * FROM weekly_vpd WHERE recid = '$recid'";
		$result = $this->db->query($mainQuery);
		$data['weeklyVPD'] = $result->row();
		/* if($data['weeklyVPD']->case_reported == 0){
			$distcode = $this -> session -> District;
			$query = "select epid_code from districts where distcode='$distcode'";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$data['distCode'] = $result['epid_code'];
		} */
		$data['district']=get_District_Name($data['weeklyVPD']->distcode);
		$data['tehsil']=get_Tehsil_Name($data['weeklyVPD']->tcode);
		$data['unioncouncil']=get_UC_Name($data['weeklyVPD']->uncode);
		$data['case_unioncouncil']=get_UC_Name($data['weeklyVPD']->case_uncode);
		$data['facility']=get_Facility_Name($data['weeklyVPD']->facode);
		$data['rbfacility']=get_Facility_Name($data['weeklyVPD']->rb_facode);
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;		
			$data['fileToLoad'] = 'data_entry/weekly_vpd';
			$data['pageTitle']='EPI-MIS | Weekly VPD Surveilliance Reports';
			$this->load->view('template/epi_template',$data);	
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//========= Function to open edit page for existing weekly vpd surveilliance reports Ends ===========//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open View page for existing weekly vpd surveilliance reports Starts =========//
	public function weekly_vpd_view(){
		dataEntryValidator(0);
		$data['weeklyVPD'] = $this -> Common_model -> get_info('weekly_vpd', '', '','*', array('recid' => $this -> uri -> segment(3)));
		//$data['weeklyVPD_cases'] = $this -> Common_model -> fetchall('weekly_vpd_cases', '','*', array('facode' => $this -> uri -> segment(3), 'fweek' => $this -> uri -> segment(4),'vpd_id'=>$data['weeklyVPD']->recid));
		$data['district']=get_District_Name($data['weeklyVPD']->distcode);
		$data['tehsil']=get_Tehsil_Name($data['weeklyVPD']->tcode);
		$data['unioncouncil']=get_UC_Name($data['weeklyVPD']->uncode);
		$data['case_unioncouncil']=get_UC_Name($data['weeklyVPD']->case_uncode);
		$data['facility']=get_Facility_Name($data['weeklyVPD']->facode);
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/weekly_vpd_view';
		$data['pageTitle']='EPI-MIS | Weekly VPD Surveilliance Reports';
		$this->load->view('template/epi_template',$data);
	}
	//========= Function to open View page for existing weekly vpd surveilliance reports Ends ===========//
	//---------------------------------------------------------------------------------------------------//
	//======== Function to open Add page for managing epi vaccines in rotine immunization Starts ========//
	public function manage_epi_vacc_add(){
		dataEntryValidator(0);
		$data['years'] = getAllYearsOptions(true);
		$data['months'] = getAllMonthsOptions(true);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('vaccine_titles', '','*');
		//print_r($data['vaccTitelsArray']);exit;
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/manage_epi_vacc';
		$data['pageTitle']='EPI-MIS | Management of EPI Vaccines in Routine Immunization';
		$this->load->view('template/epi_template',$data);
	}
	//======== Function to open Add page for managing epi vaccines in rotine immunization Ends ============//
	//-----------------------------------------------------------------------------------------------------//
	//======== Function to save new record for monthly epi vaccination management reports Starts ==========//
	public function manage_epi_vacc_save(){
		dataEntryValidator(0);
		if($this -> input -> post('month')){
		if( $this -> input -> post('distcode') && $this -> input -> post('uncode') && ($this -> input -> post('distcode') == $this -> session -> District))
		{
			$uncode = $this -> input -> post('uncode');
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			if(!$this -> input -> post('recid')){
				validateAlreadyInsertedRecord('manage_epi_vacc', "uncode='$uncode'", "fmonth='$fmonth'");
			}
			$data = array(
				'distcode' => $this -> session -> District,
				'uncode' => ($this -> input -> post('uncode'))? $this -> input -> post('uncode') : NULL,
				'month' => ($this -> input -> post('month'))? $this -> input -> post('month') : NULL,
				'year' => ($this -> input -> post('year'))? $this -> input -> post('year') : NULL,
				'fmonth' => $fmonth,
				'vaccinators_names' => ($this -> input -> post('vaccinators_names'))? $this -> input -> post('vaccinators_names') : 'Null',
				'uc_tot_pop' => ($this -> input -> post('uc_tot_pop'))? $this -> input -> post('uc_tot_pop') : '0',
				'uc_annual_pop_less_1year' => ($this -> input -> post('uc_annual_pop_less_1year'))? $this -> input -> post('uc_annual_pop_less_1year') : '0',
				'uc_monthly_pop_less_1year' => ($this -> input -> post('uc_monthly_pop_less_1year'))? $this -> input -> post('uc_monthly_pop_less_1year') : '0',
				'uc_annual_target_pop_women' => ($this -> input -> post('uc_annual_target_pop_women'))? $this -> input -> post('uc_annual_target_pop_women') : '0',
				'uc_monthly_target_pop_women' => ($this -> input -> post('uc_monthly_target_pop_women'))? $this -> input -> post('uc_monthly_target_pop_women') : '0',
				'vacc_code' => ($this -> input -> post('vacc_code'))? $this -> input -> post('vacc_code') : '0',
				'submitted_date' => date('Y-m-d'),
			);
			if($this -> input -> post('recid')){
				$updated_id = $this -> Common_model -> update_record('manage_epi_vacc',$data,array('recid' => $this -> input -> post('recid'),'fmonth' => $fmonth, 'uncode' => $uncode ));
				$this -> Common_model -> delete_record('manage_epi_vacc_items_record','',array('manage_vacc_id' => $this -> input -> post('recid')));
			}else{
				$inserted_id = $this -> Common_model -> insert_record('manage_epi_vacc',$data);	
			}
			$vaccTitles = array('0' => "BCG",'1' => "BCG_diluent",'2' => "tOPV",'3' => "Pentavalent",'4' => "Pneumococcal",'5' => "Measles",'6' => "Measles_diluent",'7' => "Tetanus_Toxoid",'8' => "AD_Syringes_005_ml",'9' => "AD_Syringes_05_ml",'10' => "Disposable_Reconstitution_Syringes_2ml",'11' => "Disposable_Reconstitution_Syringes_5ml",'12' => "Safety_Boxes");
			$j=0;
			foreach($vaccTitles as $k => $title){
				for($i=0;$i<3;$i++){
					if($this -> input -> post('recived_dur_month_quantity[' . $i .']['. $title .']') > 0 && $this -> input -> post('recived_dur_month_batch[' . $i .']['. $title .']') > 0)
					{
						$vaccinesDate = array(
							'opening_balance_quantity'   => ($this -> input -> post('opening_balance_quantity[' . $i .']['. $title .']'))?$this -> input -> post('opening_balance_quantity[' . $i .']['. $title .']'):'0',
							'recived_dur_month_date'     => ($this -> input -> post('recived_dur_month_date[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('recived_dur_month_date[' . $i .']['. $title .']'))):Null,
							'recived_dur_month_quantity' => ($this -> input -> post('recived_dur_month_quantity[' . $i .']['. $title .']'))?$this -> input -> post('recived_dur_month_quantity[' . $i .']['. $title .']'):'0',
							'recived_dur_month_batch'    => ($this -> input -> post('recived_dur_month_batch[' . $i .']['. $title .']'))?$this -> input -> post('recived_dur_month_batch[' . $i .']['. $title .']'):'0',
							'recived_dur_month_expiry'   => ($this -> input -> post('recived_dur_month_expiry[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('recived_dur_month_expiry[' . $i .']['. $title .']'))):Null,
							'utilized_during_month'      => ($this -> input -> post('utilized_during_month[' . $i .']['. $title .']'))?$this -> input -> post('utilized_during_month[' . $i .']['. $title .']'):'0',
							'end_balance_quantity'       => ($this -> input -> post('end_balance_quantity[' . $i .']['. $title .']'))?$this -> input -> post('end_balance_quantity[' . $i .']['. $title .']'):'0',
							'end_balance_expiry'         => ($this -> input -> post('end_balance_expiry[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('end_balance_expiry[' . $i .']['. $title .']'))):Null,
							'remarks'                    => ($this -> input -> post('remarks[' . $i .']['. $title .']'))?$this -> input -> post('remarks[' . $i .']['. $title .']'):'',
							'uncode'                     => ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):'0',
							'distcode'                   => ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'0',
							'fmonth'                     => $fmonth,
							'vaccine_id'                 => $k+1
						);
						$j++;
						if($this -> input -> post('recid')){
							$vaccinesDate['manage_vacc_id'] = $this -> input -> post('recid');
							$insert_id = $this -> Common_model -> insert_record('manage_epi_vacc_items_record',$vaccinesDate);
						}else{
							$vaccinesDate['manage_vacc_id'] = $inserted_id;
							$insert_id = $this -> Common_model -> insert_record('manage_epi_vacc_items_record',$vaccinesDate);	
						}
					}
				}
			}
			if($this -> input -> post('recid')){
				createTransactionLog("Data Entry", "Monthly Epi Vaccine Management Report Updated");
				$this -> session -> set_flashdata('message','Record Updated For Monthly Epi Vaccine Management Report');
			}else{
				createTransactionLog("Data Entry", "Monthly Epi Vaccine Management Report Added");
				$this -> session -> set_flashdata('message','New Record Inserted For Monthly Epi Vaccine Management Report');
			}
			redirect('Data_entry/manage_epi_vacc_list');
		}else{
			$this -> session -> set_flashdata('message','Select District and UnionCouncil For Monthly EPI Vaccince Management Report to Proceed!');
			redirect('Data_entry/manage_epi_vacc_add');
		}
		}
else{
			$this -> session -> set_flashdata('message','Select Month For Monthly EPI Vaccince Management Report to Proceed!');
			redirect('Data_entry/manage_epi_vacc_add');
}
	}
	//======== Function to save new record for monthly epi vaccination management reports Ends ============//
	//-----------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =========================================//
	public function manage_epi_vacc_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "manage_epi_vacc"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> manage_epi_vacc_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/manage_epi_vacc_list';
			$data['pageTitle']='EPI-MIS | Monthly EPI Vaccination Management Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function manage_epi_vacc_edit(){
		dataEntryValidator(0);
		$data['years'] = getAllYearsOptions(true);
		$data['months'] = getAllMonthsOptions(true);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('vaccine_titles', '','*');
		$data['vaccManagment'] = $this -> Common_model -> get_info('manage_epi_vacc', '', '','*', array('uncode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4)));
		$vaccManagmentDetail = $this -> Common_model -> fetchall('manage_epi_vacc_items_record', '','vaccine_id', array('uncode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4),'manage_vacc_id'=>$data['vaccManagment']->recid));
		$arr = array_column($vaccManagmentDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		//$dbtitles = array();
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('vaccine_titles', '', '','vacc_name', array('vacc_id' => $val));
			$data['titles'][$dbtitles[$ind]->vacc_name] = $this -> Common_model -> fetchall('manage_epi_vacc_items_record', '','*', array('vaccine_id' => $val,'manage_vacc_id'=>$data['vaccManagment']->recid));
			$ind++;
		}
		//print_r($data['titles']);exit;
		$data['district']=get_District_Name($data['vaccManagment']->distcode);
		$data['unioncouncil']=get_UC_Name($data['vaccManagment']->uncode);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('vaccine_titles', '','*');
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/manage_epi_vacc';
		$data['pageTitle']='EPI-MIS | Weekly VPD Surveilliance Reports';
		$this->load->view('template/epi_template',$data);	
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function manage_epi_vacc_view(){
		dataEntryValidator(0);
		$data['vaccManagment'] = $this -> Common_model -> get_info('manage_epi_vacc', '', '','*', array('uncode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4)));
		$vaccManagmentDetail = $this -> Common_model -> fetchall('manage_epi_vacc_items_record', '','vaccine_id', array('uncode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4),'manage_vacc_id'=>$data['vaccManagment']->recid));
		$arr = array_column($vaccManagmentDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		//$dbtitles = array();
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('vaccine_titles', '', '','vacc_name', array('vacc_id' => $val));
			$data['titles'][$dbtitles[$ind]->vacc_name] = $this -> Common_model -> fetchall('manage_epi_vacc_items_record', '','*', array('vaccine_id' => $val,'manage_vacc_id'=>$data['vaccManagment']->recid));
			$ind++;
		}
		//print_r($data['titles']);exit;
		$data['district']=get_District_Name($data['vaccManagment']->distcode);
		$data['unioncouncil']=get_UC_Name($data['vaccManagment']->uncode);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('vaccine_titles', '','*');
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/manage_epi_vacc_view';
		$data['pageTitle']='EPI-MIS | Weekly VPD Surveilliance Reports';
		$this->load->view('template/epi_template',$data);	
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function vacc_cons_req_add(){
		dataEntryValidator(0);
		$data['years'] = getAllYearsOptions(true);
		$data['months'] = getAllMonthsOptions(true);
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/vacc_cr_form';
		$data['pageTitle']='EPI-MIS | Monthly Consumption & Requisition Report';
		$this->load->view('template/epi_template',$data);
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function vacc_cons_req_save(){
		dataEntryValidator(0);
		if($this -> input -> post('month')){
		if($this -> input -> post('distcode') && $this -> input -> post('facode') && ($this -> input -> post('distcode') == $this -> session -> District))
		{
			$facode = $this -> input -> post('facode');
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			if(!$this -> input -> post('recid')){
				validateAlreadyInsertedRecord('vaccine_consumption', "facode='$facode'", "fmonth='$fmonth'");
			}
			$data = array(
				'distcode' => $this -> session -> District,
				'tcode' => ($this -> input -> post('tcode'))? $this -> input -> post('tcode') : NULL,
				'uncode' => ($this -> input -> post('uncode'))? $this -> input -> post('uncode') : NULL,
				'facode' => ($this -> input -> post('facode'))? $this -> input -> post('facode') : NULL,
				'procode' => $_SESSION["Province"],
				'month' => ($this -> input -> post('month'))? $this -> input -> post('month') : NULL,
				'year' => ($this -> input -> post('year'))? $this -> input -> post('year') : NULL,
				'fmonth' => $fmonth,
				'date_f' => ($this -> input -> post('date_f'))? date('Y-m-d',strtotime($this -> input -> post('date_f'))) : NULL,
				'prepared_by' => ($this -> input -> post('prepared_by'))? $this -> input -> post('prepared_by') : '',
				'facility_incharge' => ($this -> input -> post('facility_incharge'))? $this -> input -> post('facility_incharge') : '',
				'submitted_date' => date('Y-m-d'),
			);
			if($this -> input -> post('recid')){
				$updated_id = $this -> Common_model -> update_record('vaccine_consumption',$data,array('recid' => $this -> input -> post('recid'),'fmonth' => $fmonth, 'facode' => $facode ));
				$this -> Common_model -> delete_record('vaccine_consumption_details','',array('vacc_cons_id' => $this -> input -> post('recid')));
			}else{
				$inserted_id = $this -> Common_model -> insert_record('vaccine_consumption',$data);	
			}
			$vaccTitles = array('0' => "BCG",'1' => "DIL_BCG",'2' => "tOPV",'3' => "Pentavalent",'4' => "Pneumococcal",'5' => "Measles",'6' => "DIL_Measles",'7' => "TT_10",'8' => "TT_20",'9' => "HBV(Birth_Dose)",'10' => "IPV",'11' => "AD_Syringes_05_ml",'12' => "AD_Syringes_005_ml",'13' => "Recon_Syringes_2ml",'14' => "Recon_Syringes_5ml",'15' => "Safety_Boxes");
			$j=0;
			foreach($vaccTitles as $k => $title){
				for($i=0;$i<3;$i++){
					if($this -> input -> post('received_dur_month_batch[' . $i .']['. $title .']') > 0 && $this -> input -> post('received_dur_months_expiry[' . $i .']['. $title .']') > 0)
					{
						$vaccinesData = array(
							'opening_balance_batch'      => ($this -> input -> post('opening_balance_batch[' . $i .']['. $title .']'))?$this -> input -> post('opening_balance_batch[' . $i .']['. $title .']'):'0',
							'opening_balance_expiry'     => ($this -> input -> post('opening_balance_expiry[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('opening_balance_expiry[' . $i .']['. $title .']'))):Null,
							'opening_balance_doses' 	 => ($this -> input -> post('opening_balance_doses[' . $i .']['. $title .']'))?$this -> input -> post('opening_balance_doses[' . $i .']['. $title .']'):'0',
							'received_dur_month_batch'   => ($this -> input -> post('received_dur_month_batch[' . $i .']['. $title .']'))?$this -> input -> post('received_dur_month_batch[' . $i .']['. $title .']'):'0',
							'received_dur_months_expiry' => ($this -> input -> post('received_dur_months_expiry[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('received_dur_months_expiry[' . $i .']['. $title .']'))):Null,
							'received_dur_month_doses'   => ($this -> input -> post('received_dur_month_doses[' . $i .']['. $title .']'))?$this -> input -> post('received_dur_month_doses[' . $i .']['. $title .']'):'0',
							'childs_vaccinated'       	 => ($this -> input -> post('childs_vaccinated[' . $i .']['. $title .']'))?$this -> input -> post('childs_vaccinated[' . $i .']['. $title .']'):'0',
							'vials_used'         		 => ($this -> input -> post('vials_used[' . $i .']['. $title .']'))?$this -> input -> post('vials_used[' . $i .']['. $title .']'):'0',
							'un_usesable_vials'          => ($this -> input -> post('un_usesable_vials[' . $i .']['. $title .']'))?$this -> input -> post('un_usesable_vials[' . $i .']['. $title .']'):'',
							'closing_balance_batch'      => ($this -> input -> post('closing_balance_batch[' . $i .']['. $title .']'))?$this -> input -> post('closing_balance_batch[' . $i .']['. $title .']'):'0',
							'closing_balance_expiry'     => ($this -> input -> post('closing_balance_expiry[' . $i .']['. $title .']'))?date('Y-m-d',strtotime($this -> input -> post('closing_balance_expiry[' . $i .']['. $title .']'))):Null,
							'closing_balance_doses'      => ($this -> input -> post('closing_balance_doses[' . $i .']['. $title .']'))?$this -> input -> post('closing_balance_doses[' . $i .']['. $title .']'):'0',
							'stock_level'                => ($this -> input -> post('stock_level[' . $i .']['. $title .']'))?$this -> input -> post('stock_level[' . $i .']['. $title .']'):'0',
							'request_vials'      		 => ($this -> input -> post('request_vials[' . $i .']['. $title .']'))?$this -> input -> post('request_vials[' . $i .']['. $title .']'):'0',
							'replenishment_vials'        => ($this -> input -> post('replenishment_vials[' . $i .']['. $title .']'))?$this -> input -> post('replenishment_vials[' . $i .']['. $title .']'):'0',
							'fmonth'      				 => $fmonth,
							'distcode'      			 => ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'0',
							'facode'                 	 => ($this -> input -> post('facode'))?$this -> input -> post('facode'):'0',
							'vaccine_id'                 => $k+1,
						);
						//print_r($vaccinesData);exit;
						$j++;
						if($this -> input -> post('recid')){
							$vaccinesData['vacc_cons_id'] = $this -> input -> post('recid');
							$insert_id = $this -> Common_model -> insert_record('vaccine_consumption_details',$vaccinesData);
						}else{
							$vaccinesData['vacc_cons_id'] = $inserted_id;
							$insert_id = $this -> Common_model -> insert_record('vaccine_consumption_details',$vaccinesData);	
						}
					}
				}
			}
			if($this -> input -> post('recid')){
				createTransactionLog("Data Entry", " Vaccine Consumption Requisition Form Routine Immunization Report Updated".$this -> input -> post('recid') );
				$this -> session -> set_flashdata('message','Record Updated For Vaccine Consumption Requisition Form Routine Immunization Report');
			}else{
				createTransactionLog("Data Entry", "Vaccine Consumption Requisition Form Routine Immunization Report Added");
				$this -> session -> set_flashdata('message','New Record Inserted For Vaccine Consumption Requisition Form Routine Immunization Report');
			}
			redirect('Data_entry/vacc_cons_req_list');
		}else{
			$this -> session -> set_flashdata('message','Select District and Facility For Monthly EPI Vaccince Management Report to Proceed!');
			redirect('Data_entry/vacc_cons_req_add');
			}
		}
	else{
				$this -> session -> set_flashdata('message','Select Month For Monthly EPI Vaccince Management Report to Proceed!');
				redirect('Data_entry/vacc_cons_req_add');
		}

	}
	//======== Function to save new record for monthly epi vaccination management reports Ends ============//
	//-----------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =========================================//
	public function vacc_cons_req_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "vaccine_consumption"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> vacc_cons_req_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/vacc_cr_form_list';
			$data['pageTitle']='EPI-MIS | Monthly Vaccine Consumption Requisition Form Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function vacc_cons_req_edit(){
		dataEntryValidator(0);
		$data['years'] = getAllYearsOptions(true);
		$data['months'] = getAllMonthsOptions(true);
		$data['vaccConsumption'] = $this -> Common_model -> get_info('vaccine_consumption', '', '','*', array('facode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4)));
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('vaccine_consumption_details', '','vaccine_id', array('facode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4),'vacc_cons_id'=>$data['vaccConsumption']->recid));
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		//$dbtitles = array();
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('requisitionform_vaccine_titles', '', '','vacc_name', array('vacc_id' => $val));
			$data['titles'][$dbtitles[$ind]->vacc_name] = $this -> Common_model -> fetchall('vaccine_consumption_details', '','*', array('vaccine_id' => $val,'vacc_cons_id'=>$data['vaccConsumption']->recid));
			$ind++;
		}
		//print_r($data['titles']);exit;
		$data['district']=get_District_Name($data['vaccConsumption']->distcode);
		$data['facility']=get_Facility_Name($data['vaccConsumption']->facode);
		$data['tehsil']=get_Tehsil_Name($data['vaccConsumption']->tcode);
		$data['unioncouncil']=get_UC_Name($data['vaccConsumption']->uncode);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('requisitionform_vaccine_titles', '','*');
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/vacc_cr_form';
		$data['pageTitle']='EPI-MIS | Monthly Consumption & Requisition Report';
		$this->load->view('template/epi_template',$data);	
	} 
	public function vacc_cons_req_view(){
		$data['vaccConsumption'] = $this -> Common_model -> get_info('vaccine_consumption', '', '','*', array('facode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4)));
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('vaccine_consumption_details', '','vaccine_id', array('facode' => $this -> uri -> segment(3), 'fmonth' => $this -> uri -> segment(4),'vacc_cons_id'=>$data['vaccConsumption']->recid));
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		//$dbtitles = array();
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('requisitionform_vaccine_titles', '', '','vacc_name', array('vacc_id' => $val));
			$data['titles'][$dbtitles[$ind]->vacc_name] = $this -> Common_model -> fetchall('vaccine_consumption_details', '','*', array('vaccine_id' => $val,'vacc_cons_id'=>$data['vaccConsumption']->recid));
			$ind++;
		}
		//print_r($data['titles']);exit;
		$data['district']=get_District_Name($data['vaccConsumption']->distcode);
		$data['facility']=get_Facility_Name($data['vaccConsumption']->facode);
		$data['tehsil']=get_Tehsil_Name($data['vaccConsumption']->tcode);
		$data['unioncouncil']=get_UC_Name($data['vaccConsumption']->uncode);
		$data['vaccTitelsArray'] = $this -> Common_model -> fetchall('requisitionform_vaccine_titles', '','*');
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/vacc_cr_form_view';
		$data['pageTitle']='EPI-MIS | Monthly Consumption & Requisition Report';
		$this->load->view('template/epi_template',$data);	
	}
//-------------------------------------------------EPI NEW FORMS START HERE BELOW-------------------------------------------------------------//
		public function form_A1(){
		//dataEntryValidator(0);
		$query="Select * from form_a1_vaccine_titles where form_name='a1' order by id";
		$result = $this -> db ->query($query);
		$data['vaccine_titles'] = $result->result_array();
		//echo '<pre>';print_r($data['vaccine_titles']);exit;
		$query="Select district,distcode from districts order by district";
		$result = $this -> db ->query($query);
		$data['districts'] = $result->result_array();
		$data['edit']="Yes";
		$data['data']="";
		$data['fileToLoad'] = 'data_entry/form_a1';
		$data['pageTitle']='Form A-1(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function form_A1_Save(){
		//dataEntryValidator(0);
		//echo "danish";exit;
		//print_r($this->input->post()) ;exit;
				$manufacturer=$this->input->post('manufacturer');
				$issue_quantity_total_doses=$this->input->post('iq_totaldoses');
				$data['procode'] = $_SESSION["Province"];
				$data['distcode'] = ($this->input->post('distcode')) ? $this -> input -> post('distcode'):$this -> session -> District; 
				$data['is_temp_saved'] = $this -> input -> post('is_temp_saved'); 
				$data['form_date'] = ($this -> input -> post('form_date'))?date('Y-m-d',strtotime($this -> input -> post('form_date'))):NULL;
				if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){		
					$data['issued_by_name'] = ($this -> input -> post('issued_by_name'))?$this -> input -> post('issued_by_name'):NULL;
					$data['issued_by_desg'] = ($this -> input -> post('issued_by_desg'))?$this -> input -> post('issued_by_desg'):NULL;
					$data['issued_by_store'] = ($this -> input -> post('issued_by_store'))?$this -> input -> post('issued_by_store'):NULL;
					$data['issued_on'] = ($this -> input -> post('issued_on'))?date('Y-m-d',strtotime($this -> input -> post('issued_on'))):NULL;
					$data['status'] = 'Issued';
					
				}
				if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
					$data['receive_by'] = ($this -> input -> post('received_by_name'))?$this -> input -> post('received_by_name'):NULL;
					$data['received_by_desg'] = ($this -> input -> post('received_by_desg'))?$this -> input -> post('received_by_desg'):NULL;
					$data['received_by_store'] = ($this -> input -> post('received_by_store'))?$this -> input -> post('received_by_store'):NULL;
					$data['received_on'] = ($this -> input -> post('received_on'))?date('Y-m-d',strtotime($this -> input -> post('received_on'))):NULL;
					$data['status'] = 'Received';
				}
				if($this->input->post('id') && $this->input->post('edit')){
					//echo '<pre>';print_r($data);exit;
					$id= $this->input->post('id');					
					$updated_id = $this -> Common_model -> update_record('form_a1_vaccine_main',$data,array('id' => $id ,'distcode' => $data['distcode']));
					if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){	
						$this -> Common_model -> delete_record('form_a1_vaccine_columns','',array('main_id' => $id));
					}
					$data = "";
					$data['main_id'] = $id;
					//echo '<pre>';print_r($data);exit;
				}else{
					$inserted_id = $this -> Common_model -> insert_record('form_a1_vaccine_main',$data);
					$data = "";
					$data['main_id'] = $inserted_id;
				}
		if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){		
			foreach($issue_quantity_total_doses as $key => $code){
				//if($code != '')
				//{	
					//echo 'hree';exit;
					$data['manufacturer'] = $this -> input -> post('manufacturer['.$key.']');
					//$data['expiry_date'] = ($this -> input -> post('expirydate['.$key.']'))?date('Y-m-d',strtotime($this -> input -> post('expirydate['.$key.']'))):NULL;
					$data['expiry_date'] = ($this -> input -> post('expirydate['.$key.']'))?$this -> input -> post('expirydate['.$key.']'):NULL;
					$data['batch_no'] = $this -> input -> post('batch['.$key.']')?$this -> input -> post('batch['.$key.']'):NULL;
					$data['unit_cost'] = (is_numeric($this -> input -> post('unitcost['.$key.']')))?$this -> input -> post('unitcost['.$key.']'):0;
					$data['issue_quantity_vial_no'] = (is_numeric($this -> input -> post('iq_vialsno['.$key.']')))?$this -> input -> post('iq_vialsno['.$key.']'):0;
					$data['issue_quantity_total_doses'] = (is_numeric($this -> input -> post('iq_totaldoses['.$key.']')))?$this -> input -> post('iq_totaldoses['.$key.']'):0;
					$data['iq_vvmstage'] = (is_numeric($this -> input -> post('iq_vvmstage['.$key.']')))?$this -> input -> post('iq_vvmstage['.$key.']'):0;
					$data['vaccine_id'] = $this -> input -> post('vaccine_id['.$key.']');
					if($data['vaccine_id'] == '')
					{
						$data['vaccine_id'] == '41';
					}
					$cid=$this -> input -> post('column_id['.$key.']');
					/*if($this -> input -> post('edit') && $cid!='')
					{	$column_id = $cid;
						$updated_id = $this -> Common_model -> update_record('form_a1_vaccine_columns',$data, array("id" => $column_id));					
						$this -> session -> set_flashdata('message','You have successfully updated your record!');	
					}else{*/
					
						$inserted_id = $this -> Common_model -> insert_record('form_a1_vaccine_columns',$data);
						$this -> session -> set_flashdata('message','You have successfully saved your record!');
						//}
				//}
			}
		}
		if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){	
			$rq_vialsno=$this->input->post('rq_vialsno');
			//print_r($this->input->post());
			//print_r($rq_vialsno);exit;
			foreach($rq_vialsno as $key => $code){
				//echo $key;
				//echo "\n";
			//echo $this -> input -> post('rq_vialsno['.$key.']');
			//exit;
			//echo "\n";
			//echo $code;
			//echo "\n";
				if($code != '')
				{	
					$data['receive_quantity_vial_no'] = (is_numeric($this -> input -> post('rq_vialsno['.$key.']')))?$this -> input -> post('rq_vialsno['.$key.']'):0;
					$data['receive_quantity_total_doses	'] = (is_numeric($this -> input -> post('rq_totaldoses['.$key.']')))?$this -> input -> post('rq_totaldoses['.$key.']'):0;
					$data['rq_vvmstage'] = (is_numeric($this -> input -> post('rq_vvmstage['.$key.']')))?$this -> input -> post('rq_vvmstage['.$key.']'):0;
					$data['vaccine_id'] = $this -> input -> post('vaccine_id['.$key.']');
					if($data['vaccine_id'] == '')
					{
						$data['vaccine_id'] == '41';
					}
					$cid=$this -> input -> post('column_id['.$key.']');
					//echo $cid;
					if($this -> input -> post('edit') && $cid!=''){
						$column_id = $cid;
						//$column_id = $data['vaccine_id'] ;
					//	print_r($data);
						$updated_id = $this -> Common_model -> update_record('form_a1_vaccine_columns',$data, array("id" => $column_id));					
						$this -> session -> set_flashdata('message','You have successfully updated your record!');	
					}
				}
			}
			//exit;
			
		}
		//echo "Done";exit;
		redirect('Province-Issue-Receipt/List');
	}
	public function form_A1_list(){
		//dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " form_a1_vaccine_main "; // Change `records` according to your table name.
		if($this -> session -> Distrcit)
			$wc = " procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Data_entry_model -> form_A1_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_a1_list';
			$data['pageTitle']='Form A-1 List(Stock Issue & Receipt Voucher) | EPI-MIS'; 
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_A1_edit(){
		//dataEntryValidator(0);
		//echo "danish";exit;
		$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a1_vaccine_main', '', '','id', array('distcode' => $this -> uri -> segment(3), 'id' => $this -> uri -> segment(4)), array('by' => 'id','type' => 'asc'));
		//print_r($data['vaccConsumption']);exit;
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
		//print_r($vaccConsumptionDetail);exit;
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		//print_r($arr);exit;
		$newDetail = array_values(array_unique($arr));
		//print_r($newDetail);exit;
		//$newArr = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
		$newArr = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','41');
		$new = array_diff($newArr,$newDetail);
		$newDetail = array_merge_recursive($newDetail,$new);
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a1'), array('by' => 'id','type' => 'asc'));
			$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a1_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
			$ind++;
		}
	
		$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a1'),'', array('by' => 'id','type' => 'asc'));
		$data['sorted_array'] = $sorted_array;
		foreach($sorted_array as $key => $value){
			$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
		}
		$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
		$data['main_array'] = $vaccConsumptionDetail;
		$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
		$query="Select district,distcode from districts order by district";
		$result = $this -> db ->query($query);
		$data['districts'] = $result->result_array();
		$data['edit']="Yes";
		$data['data']=$data;
		//print_r($data);exit;
		$data['fileToLoad'] = 'data_entry/form_a1';
		$data['pageTitle']='Form A-1 Edit(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function form_A1_view(){
		//dataEntryValidator(0);
		//echo "test";exit;
		$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a1_vaccine_main', '', '','id', array('distcode' => $this -> uri -> segment(3), 'id' => $this -> uri -> segment(4)));
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		$newArr = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
		$new = array_diff($newArr,$newDetail);
		$newDetail = array_merge_recursive($newDetail,$new);
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a1'), array('by' => 'id','type' => 'asc'));
			$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a1_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
			$ind++;
		}
	
		$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a1'),'', array('by' => 'id','type' => 'asc'));
		$data['sorted_array'] = $sorted_array;
		foreach($sorted_array as $key => $value){
			$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
		}
		$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
		$data['main_array'] = $vaccConsumptionDetail;
		$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
		$query="Select district,distcode from districts order by district";
		$result = $this -> db ->query($query);
		$data['districts'] = $result->result_array();
		$data['edit']="Yes";
		$data['data']=$data;
		//print_r($data);exit;
		$data['fileToLoad'] = 'data_entry/form_a1_view';
		$data['pageTitle']='Form A-1 View(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}

    public function form_A1_fed(){
		//dataEntryValidator(0);
		$query="Select * from form_a1_vaccine_titles where form_name='a1' order by id";
		$result = $this -> db ->query($query);
		$data['vaccine_titles'] = $result->result_array();
		//echo '<pre>';print_r($data['vaccine_titles']);exit;
		
		$query="Select district,distcode from districts order by district";
				$result = $this -> db ->query($query);
		
		$data['districts'] = $result->result_array();
		
		$data['edit']="Yes";
		$data['data']="";
		$data['fileToLoad'] = 'data_entry/form_a1_fed';
		$data['pageTitle']='Form A-1 Federal(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	
	
	
	public function form_A1_fed_Save(){ 
           // dataEntryValidator(0);
			//custom fields
				$manufacturer= $this -> input -> post('manufacturer');
				$data['procode'] = $_SESSION["Province"];
				$data['supply_store'] = ($this -> input -> post('supply_store'))?$this -> input -> post('supply_store'):NULL;
				$data['form_date'] = ($this -> input -> post('form_date'))?date('Y-m-d',strtotime($this -> input -> post('form_date'))):NULL;
				$data['received_by'] = ($this -> input -> post('received_by_name'))?$this -> input -> post('received_by_name'):NULL;
				$data['received_by_desg'] = ($this -> input -> post('received_by_desg'))?$this -> input -> post('received_by_desg'):NULL;
				$data['received_by_store'] = ($this -> input -> post('received_by_store'))?$this -> input -> post('received_by_store'):NULL;
				$data['received_on'] = ($this -> input -> post('received_on'))?date('Y-m-d',strtotime($this -> input -> post('received_on'))):NULL;
				//echo '<pre>';print_r($data);exit;
				if($this->input->post('id') && $this->input->post('edit')){
					$id= $this->input->post('id');					
					$updated_id = $this -> Common_model -> update_record('form_a1_fed_vaccine_main',$data,array('id' => $id ));
					$this -> Common_model -> delete_record('form_a1_fed_vaccine_columns','',array('main_id' => $id));
					$data = "";
					$data['main_id'] = $id;
					//echo '<pre>';print_r($data);exit;
				}else{
					$inserted_id = $this -> Common_model -> insert_record('form_a1_fed_vaccine_main',$data);
					$data = "";
					$data['main_id'] = $inserted_id;
				}  
			
			foreach($manufacturer as $key => $code){ 
			
			
			if($code != '')
			{
			
				$data['manufacturer'] = $this -> input -> post('manufacturer['.$key.']');
				$data['expirydate'] = ($this -> input -> post('expirydate['.$key.']'))?$this -> input -> post('expirydate['.$key.']'):'';
				$data['batch_no'] = $this -> input -> post('batch['.$key.']')?$this -> input -> post('batch['.$key.']'):NULL;
				$data['unitcost'] = (is_numeric($this -> input -> post('unitcost['.$key.']')))?$this -> input -> post('unitcost['.$key.']'):0;
				$data['iq_vialsno'] = (is_numeric($this -> input -> post('iq_vialsno['.$key.']')))?$this -> input -> post('iq_vialsno['.$key.']'):0;
				$data['iq_totaldoses'] = (is_numeric($this -> input -> post('iq_totaldoses['.$key.']')))?$this -> input -> post('iq_totaldoses['.$key.']'):0;
				$data['iq_vvmstage'] = (is_numeric($this -> input -> post('iq_vvmstage['.$key.']')))?$this -> input -> post('iq_vvmstage['.$key.']'):0;
				$data['rq_vialsno'] = (is_numeric($this -> input -> post('rq_vialsno['.$key.']')))?$this -> input -> post('rq_vialsno['.$key.']'):0;
				$data['rq_totaldoses'] = (is_numeric($this -> input -> post('rq_totaldoses['.$key.']')))?$this -> input -> post('rq_totaldoses['.$key.']'):0;
				$data['rq_vvmstage'] = (is_numeric($this -> input -> post('rq_vvmstage['.$key.']')))?$this -> input -> post('rq_vvmstage['.$key.']'):0;
				$data['vaccine_id'] = $this -> input -> post('vaccine_id['.$key.']');
				
				    $inserted_id = $this -> Common_model -> insert_record('form_a1_fed_vaccine_columns',$data);
					$this -> session -> set_flashdata('message','You have successfully saved your record!');
				}
			}
		
		redirect('Federal-Issue-Receipt/List');	
		}
  		public function form_A1_fed_list(){
			    //dataEntryValidator(0);
				$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
				if ($page <= 0){ 
					$page = 1;
				}
				$per_page = 15 ; // Set how many records do you want to display per page.
				$startpoint = ($page * $per_page) - $per_page;		
				$statement = " form_a1_fed_vaccine_main "; // Change `records` according to your table name.
				$wc=" procode = '".$_SESSION["Province"]."'";
				$data = $this -> Data_entry_model -> form_A1_fed_list($per_page,$startpoint);
				$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
				$data['startpoint'] = $startpoint;
				$data['UserLevel'] = $this -> session -> UserLevel;
				$data['edit']="Yes";
				if($data != 0){
					$data['data']=$data;
					$data['fileToLoad'] = 'data_entry/form_a1_fed_list';
					$data['pageTitle']='Form A-1 List(Stock Issue & Receipt Voucher) | EPI-MIS';
					$this->load->view('template/epi_template',$data);
				}
				else{
					$data['message'] ="You must have rights to access this page.";
					$this -> load -> view ('message',$data);
				}
		}
		public function form_A1_fed_edit(){
			  //  dataEntryValidator(0);
				$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a1_fed_vaccine_main', '', '','id', array('id' => $this -> uri -> segment(3)), array('by' => 'id','type' => 'asc'));
				$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_fed_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
				$arr = array_column($vaccConsumptionDetail, "vaccine_id");
				$newDetail = array_values(array_unique($arr));
				$newArr = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
				$new = array_diff($newArr,$newDetail);
				$newDetail = array_merge_recursive($newDetail,$new);
				//print_r($newDetail);exit;
				$ind=0;
				foreach($newDetail as $val){
					$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a1'), array('by' => 'id','type' => 'asc'));
					$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a1_fed_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
					$ind++;
				}
			
				$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a1'),'', array('by' => 'id','type' => 'asc'));
				$data['sorted_array'] = $sorted_array;
				foreach($sorted_array as $key => $value){
					$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
				}
				$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
				$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_fed_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
				$data['formA_Result'] = $vaccConsumptionDetail;
				/*
				$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
						$query="Select district,distcode from districts order by distcode";
						$result = $this -> db ->query($query);
						$data['districts'] = $result->result_array();*/
				
				$data['edit']="Yes";
				$data['data']=$data;
				$data['fileToLoad'] = 'data_entry/form_a1_fed';
				$data['pageTitle']='Form A-1 Federal Edit(Stock Issue & Receipt Voucher) | EPI-MIS';
				$this->load->view('template/epi_template',$data);
	}
		public function form_A1_fed_view(){
			   // dataEntryValidator(0);
				$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a1_fed_vaccine_main', '', '','id', array('id' => $this -> uri -> segment(3)));
				$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_fed_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
				$arr = array_column($vaccConsumptionDetail, "vaccine_id");
				$newDetail = array_values(array_unique($arr));
				$newArr = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17');
				$new = array_diff($newArr,$newDetail);
				$newDetail = array_merge_recursive($newDetail,$new);
				$ind=0;
				foreach($newDetail as $val){
					$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a1'), array('by' => 'id','type' => 'asc'));
					$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a1_fed_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
					$ind++;
				}
			
				$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a1'),'', array('by' => 'id','type' => 'asc'));
				$data['sorted_array'] = $sorted_array;
				foreach($sorted_array as $key => $value){
					$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
				}
				$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
				$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a1_fed_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
				$data['main_array'] = $vaccConsumptionDetail;
				/*
				$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
								$query="Select district,distcode from districts order by distcode";
								$result = $this -> db ->query($query);
								$data['districts'] = $result->result_array();*/
				
				$data['edit']="Yes";
				$data['data']=$data;
				$data['fileToLoad'] = 'data_entry/form_a1_fed_view';
				$data['pageTitle']='Form A-1 Federal View(Stock Issue & Receipt Voucher) | EPI-MIS';
				$this->load->view('template/epi_template',$data);
	}
	public function form_A2(){
		dataEntryValidator(0);
		$query="Select * from form_a1_vaccine_titles where form_name='a2' order by id";
		$result = $this -> db ->query($query);
		$data['vaccine_titles'] = $result->result_array();
		//echo '<pre>';print_r($data['vaccine_titles']);exit;
		
		$query="Select district,distcode from districts order by district";
				$result = $this -> db ->query($query);
		
		$data['districts'] = $result->result_array();
		
		$data['edit']="Yes";
		$data['data']="";
		$data['fileToLoad'] = 'data_entry/form_a2';
		$data['pageTitle']='Form A-2(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function form_A2_Save(){ 	
        dataEntryValidator(0);
		$manufacturer= $this -> input -> post('manufacturer');
		$data['procode'] = $_SESSION["Province"];
		$data['distcode'] = ($this -> input -> post('distcode') == $this -> session -> District)?$this -> input -> post('distcode'):$this -> session -> District;
		$data['campaign_type'] = ($this -> input -> post('campaign_type'))?$this -> input -> post('campaign_type'):NULL;
		$data['facode'] = ($this -> input -> post('facode'))?$this -> input -> post('facode'):NULL;
		$data['form_date'] = ($this -> input -> post('form_date'))?date('Y-m-d',strtotime($this -> input -> post('form_date'))):NULL;
		$data['issued_by_name'] = ($this -> input -> post('issued_by_name'))?$this -> input -> post('issued_by_name'):NULL;
		$data['issued_by_desg'] = ($this -> input -> post('issued_by_desg'))?$this -> input -> post('issued_by_desg'):NULL;
		$data['issued_by_store'] = ($this -> input -> post('issued_by_store'))?$this -> input -> post('issued_by_store'):NULL;
		$data['issued_on'] = ($this -> input -> post('issued_on'))?date('Y-m-d',strtotime($this -> input -> post('issued_on'))):NULL;
		$data['receive_by'] = ($this -> input -> post('received_by_name'))?$this -> input -> post('received_by_name'):NULL;
		$data['received_by_desg'] = ($this -> input -> post('received_by_desg'))?$this -> input -> post('received_by_desg'):NULL;
		$data['received_by_store'] = ($this -> input -> post('received_by_store'))?$this -> input -> post('received_by_store'):NULL;
		$data['received_on'] = ($this -> input -> post('received_on'))?date('Y-m-d',strtotime($this -> input -> post('received_on'))):NULL;
		$data['is_temp_saved'] = $this -> input -> post('is_temp_saved');
		$this -> db -> select('tcode, uncode');
		$this -> db -> where("facode",$data['facode']);
		$res = $this -> db -> get('facilities') -> row();
		$data['tcode']  = $res -> tcode;
		$data['uncode'] = $res -> uncode;
		//print_r($data);exit;	
		if($this->input->post('id') && $this->input->post('edit')){
			$id= $this->input->post('id');			
					
			$updated_id = $this -> Common_model -> update_record('form_a2_vaccine_main',$data,array('id' => $id ,'distcode' => $data['distcode']));
			$this -> Common_model -> delete_record('form_a2_vaccine_columns','',array('main_id' => $id));
			$data = "";
			$data['main_id'] = $id;
		}else{
			$inserted_id = $this -> Common_model -> insert_record('form_a2_vaccine_main',$data);
			$data = "";
			$data['main_id'] = $inserted_id;
		} 
		foreach($manufacturer as $key => $code){ 
			if($code != '')
			{
				$data['manufacturer'] = $this -> input -> post('manufacturer['.$key.']');
				$data['expirydate'] = ($this -> input -> post('expirydate['.$key.']'))?date('Y-m-d',strtotime($this -> input -> post('expirydate['.$key.']'))):NULL;
				$data['batch_no'] = $this -> input -> post('batch['.$key.']')?$this -> input -> post('batch['.$key.']'):NULL;
				$data['iq_vialsno'] = (is_numeric($this -> input -> post('iq_vialsno['.$key.']')))?$this -> input -> post('iq_vialsno['.$key.']'):0;
				$data['iq_totaldoses'] = (is_numeric($this -> input -> post('iq_totaldoses['.$key.']')))?$this -> input -> post('iq_totaldoses['.$key.']'):0;
				$data['iq_vvmstage'] = (is_numeric($this -> input -> post('iq_vvmstage['.$key.']')))?$this -> input -> post('iq_vvmstage['.$key.']'):0;
				$data['rq_vialsno'] = (is_numeric($this -> input -> post('rq_vialsno['.$key.']')))?$this -> input -> post('rq_vialsno['.$key.']'):0;
				$data['rq_totaldoses'] = (is_numeric($this -> input -> post('rq_totaldoses['.$key.']')))?$this -> input -> post('rq_totaldoses['.$key.']'):0;
				$data['rq_vvmstage'] = (is_numeric($this -> input -> post('rq_vvmstage['.$key.']')))?$this -> input -> post('rq_vvmstage['.$key.']'):0;
				$data['vaccine_id'] = $this -> input -> post('vaccine_id['.$key.']');

				$inserted_id = $this -> Common_model -> insert_record('form_a2_vaccine_columns',$data);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
			}
		}
		redirect('District-Issue-Receipt/List');	
	}

	public function form_A2_list(){
		        dataEntryValidator(0);
				$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
				if ($page <= 0){ 
					$page = 1;
				}
				$per_page = 15 ; // Set how many records do you want to display per page.
				$startpoint = ($page * $per_page) - $per_page;		
				$statement = " form_a2_vaccine_main "; // Change `records` according to your table name.
				$wc=" procode = '".$_SESSION["Province"]."'";
				$data = $this -> Data_entry_model -> form_A2_list($per_page,$startpoint);
				$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
				$data['startpoint'] = $startpoint;
				$data['UserLevel'] = $this -> session -> UserLevel;
				$data['edit']="Yes";
				if($data != 0){
					$data['data']=$data;
					$data['fileToLoad'] = 'data_entry/form_a2_list';
					$data['pageTitle']='Form A-2 List(Stock Issue & Receipt Voucher) | EPI-MIS';
					$this->load->view('template/epi_template',$data);
				}
				else{
					$data['message'] ="You must have rights to access this page."; 
					$this -> load -> view ('message',$data);
				}
		}

	public function form_A2_edit(){
		dataEntryValidator(0);
		$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a2_vaccine_main', '', '','id', array('distcode' => $this -> uri -> segment(3), 'id' => $this -> uri -> segment(4)),'id');
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a2_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		$newArr = array('22','23','24','25','26','27','28','29','30','31');
		$new = array_diff($newArr,$newDetail);
		$newDetail = array_merge_recursive($newDetail,$new);
		//print_r($newDetail);exit;
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a2'), array('by' => 'id','type' => 'asc'));
			$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a2_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
			$ind++;
		}
		$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a2'),'', array('by' => 'id','type' => 'asc'));
		$data['sorted_array'] = $sorted_array;
		//print_r($data['sorted_array']);exit;
		foreach($sorted_array as $key => $value){
			$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
		}
		$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a2_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
		$data['formB_Result'] = $vaccConsumptionDetail;
		$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
		$query="Select district,distcode from districts order by district";
		$result = $this -> db ->query($query);
		$data['districts'] = $result->result_array();
		$data['facility']=get_Facility_Name($vaccConsumptionDetail['0']['facode']);
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/form_a2';
		$data['pageTitle']='Form A-2 Edit(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function form_A2_view(){
		dataEntryValidator(0);
		$data['vaccConsumption'] = $this -> Common_model -> get_info('form_a2_vaccine_main', '', '','id', array('distcode' => $this -> uri -> segment(3), 'id' => $this -> uri -> segment(4)),'id');
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a2_vaccine_columns', '','vaccine_id', array('main_id'=>$data['vaccConsumption']->id));
		$arr = array_column($vaccConsumptionDetail, "vaccine_id");
		$newDetail = array_values(array_unique($arr));
		$newArr = array('22','23','24','25','26','27','28','29','30','31');
		$new = array_diff($newArr,$newDetail);
		$newDetail = array_merge_recursive($newDetail,$new);
		//print_r($newDetail);exit;
		$ind=0;
		foreach($newDetail as $val){
			$dbtitles[] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $val,'form_name' => 'a2'), array('by' => 'id','type' => 'asc'));
			$data['titles'][$dbtitles[$ind]->vaccine_name] = $this -> Common_model -> fetchall('form_a2_vaccine_columns', '','*', array('vaccine_id' => $val,'main_id'=>$data['vaccConsumption']->id));
			$ind++;
		}
		$sorted_array=$this -> Common_model -> fetchall('form_a1_vaccine_titles', '','id,vaccine_name,doses_per_vial', array('form_name' => 'a2'),'', array('by' => 'id','type' => 'asc'));
		$data['sorted_array'] = $sorted_array;
		//print_r($data['sorted_array']);exit;
		foreach($sorted_array as $key => $value){
			$ordr[$value['vaccine_name']]  = $value['vaccine_name'];
		}
		$data['properOrderedArray'] = array_merge(array_flip($ordr), $data['titles']);
		$vaccConsumptionDetail = $this -> Common_model -> fetchall('form_a2_vaccine_main', '','*', array('id'=>$data['vaccConsumption']->id));
		$data['formB_Result'] = $vaccConsumptionDetail;
		$data['district']=get_District_Name($vaccConsumptionDetail['0']['distcode']);
		$query="Select district,distcode from districts order by district";
		$result = $this -> db ->query($query);
		$data['districts'] = $result->result_array();
		$data['facility']=get_Facility_Name($vaccConsumptionDetail['0']['facode']);
		$data['edit']="Yes";
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/form_a2_view';
		$data['pageTitle']='Form A-2 Edit(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	//--------------------------------------------------------------------------------------------------------------------//
	//-------------------------------------------------FORM B-------------------------------------------------------------//
	//--------------------------------------------------------------------------------------------------------------------//
	public function form_B(){
		dataEntryValidator(0);
		$data['data']="";
		$data['edit']="yes";
		$data['vaccinesDetails'] = $this -> Common_model -> fetchall('epi_item_pack_sizes','','pk_id,item_name,number_of_doses,list_rank,cr_table_row_numb', array('item_category_id<>'=>4,'activity_type_id'=>1),'',array('by'=>'list_rank','type'=>'asc'));
		//$data['includeCurrentMonth']="yes";
		$data['fileToLoad'] = 'data_entry/form_bp';
		$data['pageTitle']='Form B(EPI)  Consumption and Requisition Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function form_B_Save(){
		dataEntryValidator(0);
		$liveUrl = $this -> session -> liveURL;
		$localUrl = $this -> session -> localURL;
		$baseUrl = base_url();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
        for($i=1; $i<=19; $i++){ 
				$this->form_validation->set_rules('cr_r'.$i.'_f1','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));
				$this->form_validation->set_rules('cr_r'.$i.'_f2','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));
				$this->form_validation->set_rules('cr_r'.$i.'_f3','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));
				$this->form_validation->set_rules('cr_r'.$i.'_f4','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));
				$this->form_validation->set_rules('cr_r'.$i.'_f5','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));
				$this->form_validation->set_rules('cr_r'.$i.'_f6','Not use nagtive number ','numeric|greater_than[-1]',
								  array('greater_than' => 'No -Ve value'));										  
	    }   
	if ($this->form_validation->run() === FALSE) {
		
		$this->form_B();
	}
	else{
		if($this -> input -> post('month') && $this -> input -> post('year') && $this -> input -> post('distcode') && $this -> input -> post('facode')){
			$data=$_POST;
			//custom fields
			$data['procode']= $_SESSION["Province"];
			$data['fmonth'] = $this -> input -> post('year')."-".$this -> input -> post('month');
			$fmonth = $data['fmonth'];
			//validateAdvanceMonthYearSelection($this -> input -> post('month'),$this -> input -> post('year'));
			if(!$this -> input -> post('edit')){
				$facode = $this -> input -> post('facode');
				validateAlreadyInsertedRecord('form_b_cr', "facode='$facode'", "fmonth='$fmonth'");	
			}
			foreach($data as $key => $value)
			{
				if($value=='')
				{
					$data[$key] = '0';
				}
			}
			//$data['formdate']=date('Y-m-d',strtotime(($this -> input -> post('formdate'))?$this -> input -> post('formdate'):NULL));
			$data['date_submitted']=date('Y-m-d');			
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);unset($data['month']);unset($data['year']);
				$updated_id = $this -> Common_model -> update_record('form_b_cr',$data,array('id' => $id,'distcode' => $data['distcode'],'facode' => $data['facode'],'fmonth'=>$fmonth));
				//if($baseUrl == $liveUrl){
				syncDataWithFederalEPIMIS('form_b_cr',$fmonth );
				//}
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('HF-Consumption-Requisition/List');
			}
			else{
				unset($data['month']);unset($data['year']);
				$inserted_id = $this -> Common_model -> insert_record('form_b_cr',$data);
				//if($baseUrl == $liveUrl){
				syncDataWithFederalEPIMIS('form_b_cr',$fmonth );
				//}
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('HF-Consumption-Requisition/List');
			}
		}
		else{
			$this -> session -> set_flashdata('message','You must select District, Facility and input your date!');
			redirect('HF-Consumption-Requisition/Add');
		}
	}
}

	public function form_B_list(){
		dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;

		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " form_b_cr "; // Change `records` according to your table name.
		$wc=" procode = '".$_SESSION["Province"]."'";
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Data_entry_model -> form_B_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_b_list';
			$data['pageTitle']='Form B(EPI)  Consumption and Requisition Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_B_edit(){
		dataEntryValidator(0);
		$fmonth = $this -> uri -> segment(3);
		$facode   = $this -> uri -> segment(4);
		$table = 'form_b_cr';
		freezeReport($table,$facode,$fmonth);
		$monthYear = explode("-", $fmonth);
		$data['year'] = $monthYear[0];
		$data['month'] = $monthYear[1];
		$data['vaccinesDetails'] = $this -> Common_model -> fetchall('epi_item_pack_sizes','','pk_id,item_name,number_of_doses,list_rank,cr_table_row_numb', array('item_category_id<>'=>4,'activity_type_id'=>1),'',array('by'=>'list_rank','type'=>'asc'));
		$data['formB_Result'] = $this -> Common_model -> get_info('form_b_cr', '', '','*', array('fmonth' => $fmonth, 'facode' => $facode));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_bp';
			$data['pageTitle']='Form B(EPI)  Consumption and Requisition Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_B_view(){
		//dataEntryValidator(0);
		$fmonth = $this -> uri -> segment(3);
		$facode   = $this -> uri -> segment(4);
		$monthYear = explode("-", $fmonth);
		$data['year'] = $monthYear[0];
		$data['month'] = $monthYear[1];
		$data['a'] = $this -> Common_model -> get_info('form_b_cr', '', '','*', array('fmonth' => $fmonth, 'facode' => $facode));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_b_view';
			$data['pageTitle']='Form B(EPI)  Consumption and Requisition Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
//--------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------FORM C-------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------//
	public function form_C(){
		dataEntryValidator(0);
		$data['data']="";
		$data['fileToLoad'] = 'data_entry/form_c';
		$data['pageTitle']='Form C(EPI) Demand, Consumption & Receipt Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function form_C_Save(){
		dataEntryValidator(0);
		if($this -> input -> post('campaign_type') && $this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') && $this -> input -> post('start_date') && $this -> input -> post('end_date')){
			$data=$_POST;
			//custom fields
			$data['procode']=$_SESSION["Province"];
			foreach($data as $key => $value)
			{
				if($value=='')
				{
					$data[$key] = '0';
				}
				/*
				if (strpos($key, 'f3') !== false) {
					$data[$key]=date('Y-m-d',strtotime(($this -> input -> post($key))?$this -> input -> post($key):NULL));
				}*/
				
			}
			$data['start_date']=date('Y-m-d',strtotime(($this -> input -> post('start_date'))?$this -> input -> post('start_date'):NULL));
			$data['end_date']=date('Y-m-d',strtotime(($this -> input -> post('end_date'))?$this -> input -> post('end_date'):NULL));
			$data['reported_on']=date('Y-m-d',strtotime(($this -> input -> post('reported_on'))?$this -> input -> post('reported_on'):NULL));
			$data['received_on']=date('Y-m-d',strtotime(($this -> input -> post('received_on'))?$this -> input -> post('received_on'):NULL));
			$data['requested_on']=date('Y-m-d',strtotime(($this -> input -> post('requested_on'))?$this -> input -> post('requested_on'):NULL));
			//print_r($data);exit;
			if($this -> input -> post('edit') && $this -> input -> post('id'))
			{
				$id = $data['id'];
				unset($data['id']);unset($data['edit']);unset($data['province']);
				$updated_id = $this -> Common_model -> update_record('form_c_demand',$data,array('id' => $id,'distcode' => $data['distcode'],'tcode' => $data['tcode'],'uncode' => $data['uncode']));
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('UC-Demand-Consumption/List');
			}else{
				unset($data['province']);
				$inserted_id = $this -> Common_model -> insert_record('form_c_demand',$data);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('UC-Demand-Consumption/List');
			}
		}else{
			$this -> session -> set_flashdata('message','You must select all required fields to continue. <br> *Select Your District. <br> *Select Your Tehsil. <br> *Select Your UnionCouncil. <br> *Select your Start date. <br> *Select your End Date.');
			redirect('UC-Demand-Consumption/Add');
		}
	}

	public function form_C_list(){
		dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " form_c_demand "; // Change `records` according to your table name.
		$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Data_entry_model -> form_C_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc);
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c_list';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_C_edit(){
		dataEntryValidator(0);
		$uncode = $this -> uri -> segment(3);
		$id   = $this -> uri -> segment(4);
		$data['formC_Result'] = $this -> Common_model -> get_info('form_c_demand', '', '','*', array('id' => $id, 'uncode' => $uncode));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_C_view(){
		dataEntryValidator(0);
		$uncode = $this -> uri -> segment(3);
		$id   = $this -> uri -> segment(4);
		$data['a'] = $this -> Common_model -> get_info('form_c_demand', '', '','*', array('id' => $id, 'uncode' => $uncode));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c_view';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
		
	//-----------------------------------------------------------------------------------------------------------------//
	public function aefiWeeklyCompilationForm(){
		dataEntryValidator(0);
		$query = "select count(facode) as cnt from facilities where hf_type='e'";
		$result = $this -> db -> query($query);
		$data['flcf'] = $result -> row_array();
		$data['data']="";
		$data['fileToLoad'] = 'data_entry/aefi_weekly_compilation_form';
		$data['pageTitle']='AEFI Weekly Compilation Form For District | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function aefiWeeklyCompilationSave(){
		dataEntryValidator(0);
		$uncode = $this -> input -> post('uncode');
		foreach($uncode as $key => $code){
			$data = "";
			if($code != '')
			{
				///////////////////////////////////////////////Upper Portion/////////////////////////////////////////////
				$data['procode'] = $_SESSION["Province"];
				$data['distcode'] = ($this -> input -> post('distcode') == $this -> session -> District)?$this -> input -> post('distcode'):$this -> session -> District;
				$data['week'] = $this -> input -> post('epi_week_no');
				$data['datefrom'] = ($this -> input -> post('date_from'))?date('Y-m-d',strtotime($this -> input -> post('date_from'))):NULL;
				$data['dateto'] = ($this -> input -> post('date_to'))?date('Y-m-d',strtotime($this -> input -> post('date_to'))):NULL;
				$data['no_reporting_units'] = (is_numeric($this -> input -> post('no_reporting_units')))?$this -> input -> post('no_reporting_units'):0;
				$data['no_reported'] = (is_numeric($this -> input -> post('no_reported')))?$this -> input -> post('no_reported'):0;
				$data['no_reported_ontime'] = (is_numeric($this -> input -> post('no_reported_ontime')))?$this -> input -> post('no_reported_ontime'):0;
				$data['no_aefi_cases'] = (is_numeric($this -> input -> post('no_aefi_cases')))?$this -> input -> post('no_aefi_cases'):0;
				////////////////////////////////////////////////Loop Poertion///////////////////////////////////////////
				$data['uncode'] = $this -> input -> post('uncode['.$key.']');
				$data['tcode'] = $this -> input -> post('tcode['.$key.']');
				$data['gender'] = $this -> input -> post('gender['.$key.']');
				$data['dob'] = ($this -> input -> post('dob['.$key.']'))?date('Y-m-d',strtotime($this -> input -> post('dob['.$key.']'))):NULL;
				//date in mm/dd/yyyy format; or it can be in other formats as well
				//explode the date to get month, day and year
				$birthDate = explode("-", $data['dob']);
				//get age from date or birthdate
				$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
				$data['age'] = $age;
				$data['vacc_date'] = ($this -> input -> post('vacc_date['.$key.']'))?date('Y-m-d',strtotime($this -> input -> post('vacc_date['.$key.']'))):NULL;
				$data['date_aefi_onset'] = ($this -> input -> post('date_aefi_onset['.$key.']'))?date('Y-m-d',strtotime($this -> input -> post('date_aefi_onset['.$key.']'))):NULL;
				$data['vacc_name'] = $this -> input -> post('vacc_name['.$key.']');
				$data['aefi_cases'] = $this -> input -> post('aefi_cases['.$key.']');
				$data['mc_hospitalized'] = $this -> input -> post('mc_hospitalized['.$key.']');				
				$data['death'] = $this -> input -> post('death['.$key.']');
				///////////////////////////////////////////Lower Portion////////////////////////////////////////////////
				$data['rep_person'] = $this -> input -> post('rep_person');
				$data['rep_desg'] = $this -> input -> post('rep_desg');
				$data['rep_date'] = ($this -> input -> post('rep_date'))?date('Y-m-d',strtotime($this -> input -> post('rep_date'))):NULL;
				$data['submitted_by'] = $this -> input -> post('submitted_by');
				$data['submitted_desg'] = $this -> input -> post('submitted_desg');
				$data['submitted_date'] = date('Y-m-d');
				
				if($this -> input -> post('edit') && $this -> input -> post('groupId') >= 0)
				{
					$groupId = $this -> input -> post('groupId');
					$id = $this -> input -> post('idofeachrow['.$key.']');					
					$updated_id = $this -> Common_model -> update_record('nnt_cases_linelist',$data,array('linelist_group' => $groupId,'id'=>$id,'distcode' => $data['distcode']));
					$this -> session -> set_flashdata('message','You have successfully updated your record!');	
				}else{ 
					$inserted_id = $this -> Common_model -> insert_record('aefi_rep',$data);
					$this -> session -> set_flashdata('message','You have successfully saved your record!');
				}
			}
		}
		//echo "Done";exit;
		redirect('Data_entry/aefi_list');
	}
	public function aefiWeeklyCompilationEdit(){
		dataEntryValidator(0);
	    //========== Function to open page for adding new Integrated Disease surveilliance report Starts ============//
	}
		public function ids_reporting_add(){
		dataEntryValidator(0);
		$wc = getWC();//helper function
		$neWc = str_replace("procode", "province", $wc);
		
		$query="Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist']=$Dist_result -> result_array();
		
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		
		$query="Select facode, fac_name from facilities where $wc order by fac_name";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		
		$query="Select uncode, un_name from unioncouncil where $wc order by un_name";
		$resultFac=$this->db->query($query);
		$data['resultUC']=$resultFac->result_array();
		
		$query_sec="select * from ids_diseases_sec";
		$resultDisease=$this->db->query($query_sec);
		$data['resultsec']=$resultDisease->result_array();
		
		$data['years'] = getEpiWeekYearsOptions(0,true);
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/ids_reporting';
		$data['pageTitle']='IDSRS-MIS | Integrated Disease Surveillance Reporting Form';
		$this->load->view('template/epi_template',$data);
	}
	//========== Function to open page for adding new Integrated Disease surveilliance report Ends ==============//
	//-----------------------------------------------------------------------------------------------------------//
	//==========Funtion To Save the record of ids reporting form ================================================//
	public function ids_reporting_save(){
		dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('facode') && ($this -> input -> post('distcode') == $this -> session -> District)){
			$facode = $this -> input -> post('facode');
			
			$num=$this->input->post("epi_week");
			$data['epi_week']=(sprintf("%02d",$num));
			$fweek = $this -> input -> post('year')."-".sprintf("%02d",$num);
			
			//print_r($this -> input -> post('epi_week'));exit;
			if(!$this -> input -> post('id')){
				validateAlreadyInsertedRecord('ids_report_form', "facode='$facode'", "fweek='$fweek'");
			
			}
			
			//$data=array();
			$data['procode'] = $_SESSION["Province"];
	  		$formats = array("d-m-Y","m-d-Y");
	  		foreach($_POST as $key => $value)
	  		{
			   $data[$key] = ($value=='')?NULL:$value;//($value=='1')?1:(($value=='')?'0':$value);
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
	  		}
			//print_r($expression)
			foreach($data as $key => $value)
			{
				if($value=="")
				{
					$data[$key] = NULL;
				}
			}
			
			$data['fweek'] = $this -> input -> post('year')."-".sprintf("%02d",$num);
			//echo '<pre>';print_r($data);exit;
			if($this -> input -> post('id'))
			{
				//echo '<pre>';print_r($data);exit;
				$updated_id = $this -> Common_model -> update_record('ids_report_form',$data,array('id' => $this -> input -> post('id'),'fweek' => $fweek, 'facode' => $facode ));
				createTransactionLog("Data Entry", "IDS Surveilliance Report Updated");
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('Data_entry/ids_report_list');
			}else{
				//echo '<pre>';print_r($data);exit;
				$inserted_id = $this -> Common_model -> insert_record('ids_report_form',$data);
				createTransactionLog("Data Entry", "New IDS Surveilliance Report Added ");
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('Data_entry/ids_report_list');
			}
			
		}else{
			$this -> session -> set_flashdata('message','Select District and Health Facility For IDS Surveilliance Report to Proceed!');
			redirect('Data_entry/ids_report_list');
		}
		
	}
	//==========Funtion To Save the record of ids reporting form End ================================================//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open list for existing IDS Surveilliance Report Starts ==============//
	public function ids_report_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "ids_report_form"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> ids_report_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/ids_report_list';
			$data['pageTitle']='IDSRS-MIS | Integrated Disease Surveilliance Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//========= Function to open list for existing IDS Surveilliance Report Ends ================//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open edit page for existing IDS Surveilliance Report Starts =========//
	public function ids_report_edit($facode,$fweek){
		dataEntryValidator(0);
		$data['years'] = getAllYearsOptions(true);
		
		$mainQuery = "SELECT * FROM ids_report_form WHERE facode = '$facode'  AND fweek = '$fweek'";
		$result = $this->db->query($mainQuery);
		$data['idsReport'] = $result->row();
		//print_r($data['idsReport']);exit;
		$data['district']=get_District_Name($data['idsReport']->distcode);
		$data['tehsil']=get_Tehsil_Name($data['idsReport']->tcode);
		$data['unioncouncil']=get_UC_Name($data['idsReport']->uncode);
		$data['case_unioncouncil']=get_UC_Name($data['idsReport']->case_uncode);
		$data['facility']=get_Facility_Name($data['idsReport']->facode);
		$query_sec="select * from ids_diseases_sec";
		$resultDisease=$this->db->query($query_sec);
		$data['resultsec']=$resultDisease->result_array();
		$data['edit']="Yes";
		$data['data']=$data;
		
		$data['fileToLoad'] = 'data_entry/ids_reporting';
		$data['pageTitle']='IDSRS-MIS | Integrated Disease Surveilliance Reports';
		$this->load->view('template/epi_template',$data);	
	}
	//========= Function to open edit page for existing IDS Surveilliance Report Ends ===========//
	//---------------------------------------------------------------------------------------------------//
	//========= Function to open View page for existing IDS Surveilliance Report Starts =========//
	public function ids_report_view(){
		dataEntryValidator(0);
		$data['idsReport'] = $this -> Common_model -> get_info('ids_report_form', '', '','*', array('facode' => $this -> uri -> segment(3), 'fweek' => $this -> uri -> segment(4)));
		$query_sec="select * from ids_diseases_sec";
		$resultDisease=$this->db->query($query_sec);
		$data['resultsec']=$resultDisease->result_array();
		$data['district']=get_District_Name($data['idsReport']->distcode);
		$data['tehsil']=get_Tehsil_Name($data['idsReport']->tcode);
		$data['unioncouncil']=get_UC_Name($data['idsReport']->uncode);
		$data['case_unioncouncil']=get_UC_Name($data['idsReport']->case_uncode);
		$data['facility']=get_Facility_Name($data['idsReport']->facode);
		$data['data']=$data;
		$data['fileToLoad'] = 'data_entry/ids_reporting_view';
		$data['pageTitle']='IDSRS-MIS | Integrated Disease Surveilliance Reports';
		$this->load->view('template/epi_template',$data);
	}
	//========= Function to open View page for existing weekly vpd surveilliance reports Ends ===========//
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fac_mvrf(){
		dataEntryValidator(0);
		$data['data']=""; 
		//$data['includeCurrentMonth']="yes";
		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		$data['edit']="No";
		$data['fileToLoad'] = 'data_entry/fac_mvrf';
		$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Report';
		$this->load->view('template/epi_template',$data);
	}	
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//	
	public function fac_mvrf_list(){
		dataEntryValidator(0);
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 30; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = "fac_mvrf_db"; // Change `records` according to your table name.
		
		$data = $this -> Data_entry_model -> fac_mvrf_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?');
		
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/fac_mvrf_list';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Reports';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//	
	//==============================        Comment Here          =======================================//
	public function fac_mvrf_save(){
		dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') &&  $this -> input -> post('facode')){
			$data = $this -> getPostedData();
			$od='od_';
			$cri='i_';
			foreach($data as $key =>$value){ 
			    $pos_od=(strpos($key,$od));
			    $pos_cri=(strpos($key,$cri));
			     //print_r($key);exit;
				if($pos_od === false){
					$cri_data[$key]=$value;
				}else{
					 //does nothing
				}
			    if($pos_cri === false){
					$od_data[$key]=$value;
				}else{
				  //does nothing	
				}
			}
		    if($cri_data != Null){
				$data=$cri_data;
				$year = $this -> input -> post('year');
				$month = $this -> input -> post('month');
				$facode = $this -> input -> post('facode');
				$data['fmonth'] = $year."-".$month;
				$fmonth = $data['fmonth'];
				$dist=$this -> session -> District;
				if($dist!='328'){
					freezeReport('fac_mvrf_db',$facode,$fmonth);
				}
				$distcode=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
				if(!$this -> input -> post('edit') ){
					$whereClause=" facode='$facode' and distcode='$distcode' ";
					validateAlreadyInsertedRecord('fac_mvrf_db', $whereClause , "fmonth='$fmonth'");
				}
				unset($data['year']);unset($data['month']);unset($data['hfcode']);
				$wc = $data;
				if($data)
				{
					if($this -> input -> post('edit') && $this -> input -> post('id'))
					{	
						$id = $data['id'];
						unset($data['id']);unset($data['edit']);
						$data['editted_date'] = date('Y-m-d');
						$updated_id = $this -> Common_model -> update_record('fac_mvrf_db',$data,array('id' => $id));
						//$this -> session -> set_flashdata('message','You have successfully updated your record!');
						//redirect('FLCF-MVRF/List');
					}
					else{
						$data['submitted_date'] = date('Y-m-d');
						
						$inserted_id = $this -> Common_model -> insert_record('fac_mvrf_db',$data);
						//$this -> session -> set_flashdata('message','You have successfully saved your record!');
						//redirect('FLCF-MVRF/List');
					}
					syncDataWithFederalEPIMIS('fac_mvrf_db',$fmonth );
					syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
				
				}
				else {
					$this -> session -> set_flashdata('message','Select Month For Facility Vaccine Monthly Reports to Proceed!');
					redirect('Data_entry/fac_mvrf');
				}
			}
			if($od_data != Null)
			{
				$data=$od_data;
				$year = $this -> input -> post('year');
				$month = $this -> input -> post('month');
				$facode = $this -> input -> post('facode');
				$data['fmonth'] = $year."-".$month;
				$fmonth = $data['fmonth'];
				$distcode=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
				if(!$this -> input -> post('edit') ){
					$whereClause = " facode='$facode' and distcode='$distcode' ";
					validateAlreadyInsertedRecord('fac_mvrf_od_db', $whereClause , "fmonth='$fmonth'");
				} 
				unset($data['year']);unset($data['month']);unset($data['hfcode']);
				$wc = $data;
				if($data)
				{
					if($this -> input -> post('edit') && $this -> input -> post('id'))
					{	
						$id = $data['id'];
						unset($data['id']);unset($data['edit']);
						$data['editted_date'] = date('Y-m-d');
						$updated_id = $this -> Common_model -> update_record('fac_mvrf_od_db',$data,array('id' => $id));
						$this -> session -> set_flashdata('message','You have successfully updated your record!');
					}
					else{
						$data['submitted_date'] = date('Y-m-d');
						$inserted_id = $this -> Common_model -> insert_record('fac_mvrf_od_db',$data);
						$this -> session -> set_flashdata('message','You have successfully saved your record!');
					}
					syncDataWithFederalEPIMIS('fac_mvrf_od_db',$fmonth );
					redirect('FLCF-MVRF/List');
				}
				else {
					$this -> session -> set_flashdata('message','Select Month For Facility Vaccine Monthly Reports to Proceed!');
					redirect('Data_entry/fac_mvrf');
				}
			}
		}else{
			$this -> session -> set_flashdata('message','Please Select Distrcit, Tehsil, UnionCouncil and Health Facility!');
			redirect('Data_entry/fac_mvrf');
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fac_mvrf_edit($facode,$fmonth){
		dataEntryValidator(0);
		$facode = $this -> uri -> segment(3);
		$fmonth = $this -> uri -> segment(4);
		$table = 'fac_mvrf_db';
		freezeReport($table,$facode,$fmonth);
		//validateExistReport($table,$facode,$fmonth);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly vaccination Reports List', '/Data_entry/fac_mvrf_list');
		$this->breadcrumbs->push('Update Facility Monthly vaccination Report', '/Data_entry/fac_mvrf_edit');
		///////////////////////////////////////////////////////////////////
		$data = $this -> Data_entry_model -> fac_mvrf_edit($facode,$fmonth);
		$district = $this -> session -> District;
		if($data != 0){ 
			//echo '<pre>';print_r($data);echo '</pre>';exit();
						
			$data['data']=$data;
			$data['edit'] = "Yes";
			$data['fileToLoad'] = 'data_entry/fac_mvrf';
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Report Form';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//=================================      Comment Here        =======================================//
	//---------------------------------------------------------------------------------------------------//
	//=================================== Function to Update Data ======================================//	
	public function fac_mvrf_update($id){

		dataEntryValidator(0);
		//echo '<pre>';print_r($this->input->post());echo '</pre>';exit();
		//dataEntryValidator();
		$this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
		$this->form_validation->set_rules('facode','Facility Name','trim|required|min_length[6]|max_length[6]');
		$this->form_validation->set_rules('tc_male','Monthly Target For Children 0-11 M','trim|numeric');
		if ($this->form_validation->run() === FALSE) 
		{
			$facode = $this -> input -> post('facode');
			$fmonth = $this -> input -> post('old_fmonth');
			$data = $this -> Data_entry_model -> fac_mvrf_edit($facode,$fmonth);
			$data['id'] = $id;
			$data['edit']="Yes";
			$data['data']="";
			$data['fileToLoad'] = 'data_entry/fac_mvrf';
			$data['pageTitle']='EPI-MIS | Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data);
		}
		else
		{		
		
			$facode   = $this -> input -> post('facode');
			if(!($facode>0)){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Health Facility cannot be empty, Kindly select any facility");';
				$script .= 'history.go(-1);';
				$script .= '</script>';
				echo $script;
				exit();
			}
			$distcode = $this -> session -> District;
			$procode  = $this -> session -> Province;
			$old_facode   = $this -> input -> post('old_facode');
			$old_fmonth   = $this -> input -> post('old_fmonth');
			unset($_POST["old_facode"]);
			unset($_POST["old_fmonth"]);
			unset($_POST["hfcode"]);
			$data=$_POST;
			
			//custom fields
			$data["submitted_date"]=date("Y-m-d");
			$data["editted_date"]=date("Y-m-d");
			//where clause fields
			$where["id"]=$id;
			$where["facode"]=$old_facode;
			$where["fmonth"]=$old_fmonth;
			//////////////////////////cri,oui,od/////////////////////////////////
			$prefixarray = array ('cri','oui','od');
			$consumptionKeys = array(1,10,3,4,5,11,18,6);
			$k=0;
			$vaccinetotal=0;
			for($j=1; $j<=18; $j++){
				if($j==17){
					//does nothing
				}
				else{
					foreach($prefixarray as $key => $prefix){ 
						for($i=1; $i<=24; $i++){
								
							$keyprefix = $prefix.'_r'.$i.'_f'.$j;
							$vaccinetotal+=$data[$keyprefix];	
						} 
					}
                    if($j==3 || $j==4 || $j==5 || $j==7 || $j==8 || $j==11 || $j==10 || $j==14 || $j==16  )
					{}else{
						$dataf['cr_r'.$consumptionKeys[$k].'_f3']=$vaccinetotal;
						$k++;
						$vaccinetotal=0;
					}					
				}
			}
			//////////////////////////'ttri','ttoui','ttod'/////////////////////////////////
            $prefixarrayt = array('ttri','ttoui','ttod');
            foreach($prefixarrayt as $key => $prefixt)
            {
				for($f=1; $f<=5; $f++){
					for($r=1; $r<=8; $r++){
                        $keyprefixt=$prefixt.'_r'.$r.'_f'.$f;
                        $ttvaccinetotal+=$data[$keyprefixt];
					}
				}
                $dataf['cr_r9_f3']=$ttvaccinetotal;  
            }
			////////////////////////////fac_mvrf_update///////////////////////////////
			$data = $this -> Data_entry_model -> fac_mvrf_update($data,$where,$dataf);
			if($data != 0){
				$this -> load -> view ('data_entry/fac_mvrf_list',$data);
			}
			else{
				$data['message'] ="You must have rights to access this page.";
				$this -> load -> view ('message',$data);
			}
		
		}
	}
	//==============================        Comment Here          =======================================//
	//---------------------------------------------------------------------------------------------------//
	//==============================        Comment Here          =======================================//
	public function fac_mvrf_view(){
		//dataEntryValidator(0);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly vaccination Reports List', '/Data_entry/fac_mvrf_list');
		$this->breadcrumbs->push('View Facility Monthly vaccination Report', '/Data_entry/fac_mvrf_view');
		///////////////////////////////////////////////////////////////////
		$facode=$this -> uri -> segment(3);
		$fmonth=$this -> uri -> segment(4);
		$data = $this -> Data_entry_model -> fac_mvrf_edit($facode,$fmonth);
		//print_r($data);
		if($data != 0){			
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/fac_mvrf_view';
			$data['pageTitle']='EPI-MIS | View Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function fac_mvrf_view_for_dd(){
		//dataEntryValidator(0);
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly vaccination Reports List', '/Data_entry/fac_mvrf_list');
		$this->breadcrumbs->push('View Facility Monthly vaccination Report', '/Data_entry/fac_mvrf_view');
		///////////////////////////////////////////////////////////////////
		$facode=$this -> uri -> segment(3);
		$fmonth=$this -> uri -> segment(4);
		$data = $this -> Data_entry_model -> fac_mvrf_edit($facode,$fmonth);
		if($data != 0){			
			$data['data']=$data;
			$this->load->view('data_entry/fac_mvrf_view_for_dd',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	//==============================        Comment Here          =======================================//
	//===================================================================================================//
	//=================================== Function to Get Posted Data ===================================//
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			$data[$key] = (($value=='NaN')?0:$value); 
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
			if($data[$key] == NULL/* || $data[$key]=="0" */)
				unset($data[$key]);
		}
		return $data;
	}
	//--------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------FORM C-------------------------------------------------------------//
//--------------------------------------------------------------------------------------------------------------------//
	public function form_C_new(){
		dataEntryValidator(0);
		$data['data']=$this->Data_entry_model->form_C_new();
		$data['fileToLoad'] = 'data_entry/form_c_new';
		$data['pageTitle']='Form C(EPI) Demand, Consumption & Receipt Form | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function form_C_new_Save(){
		dataEntryValidator(0);
		if($this -> input -> post('campaign_type') && $this -> input -> post('distcode') && $this -> input -> post('start_date') && $this -> input -> post('end_date')){
			$dataARRY = array();
			$uncode= $this -> input -> post('uncode');
			$data['procode']=$_SESSION["Province"];
			$data['distcode']=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
			$data['is_temp_saved']=$this -> input -> post('is_temp_saved');
			
			if(!$this -> input -> post('edit')){
				$query = "Select max(group_id) as group_id from form_c_new_demand HAVING max(group_id) is not null ";
				$result = $this -> db -> query($query);
				if ($result -> num_rows() > 0) {
					$groupid = $result -> row_array();
					$newCode = $groupid['group_id'] + 1;
					if ($newCode != NULL) {
						$data['group_id'] = $newCode;
					} else {
						$data['group_id'] = '1';
					}
				} else {
			$data['group_id'] = '1';
				}
			}
			if($this -> input -> post('edit') && $this -> input -> post('group_id'))
			{
				$data['group_id'] = $this -> input -> post('group_id');
			}
			$data['campaign_type'] = $this -> input -> post('campaign_type');
			$data['vaccine_type'] = $this -> input -> post('vaccine_type');
			$data['requested_by_name'] = $this -> input -> post('requested_by_name');
			$data['requested_by_desg'] = $this -> input -> post('requested_by_desg');
			$data['requested_by_store'] = $this -> input -> post('requested_by_store');
			$data['requested_on']=date('Y-m-d',strtotime(($this -> input -> post('requested_on'))?$this -> input -> post('requested_on'):NULL)); 
			
			$data['received_by_name'] = $this -> input -> post('received_by_name');
			$data['received_by_desg'] = $this -> input -> post('received_by_desg');
			$data['received_by_store'] = $this -> input -> post('received_by_store');
			$data['received_on']=date('Y-m-d',strtotime(($this -> input -> post('received_on'))?$this -> input -> post('received_on'):NULL));
			
			
			$data['reported_by_name'] = $this -> input -> post('reported_by_name');
			$data['reported_by_desg'] = $this -> input -> post('reported_by_desg');
			$data['reported_by_store'] = $this -> input -> post('reported_by_store');
			$data['reported_on']=date('Y-m-d',strtotime(($this -> input -> post('reported_on'))?$this -> input -> post('reported_on'):NULL));
			
			$data['start_date']=date('Y-m-d',strtotime(($this -> input -> post('start_date'))?$this -> input -> post('start_date'):NULL));
			$data['end_date']=date('Y-m-d',strtotime(($this -> input -> post('end_date'))?$this -> input -> post('end_date'):NULL));
			
				
			$from_fyear = date('Y', strtotime($data['start_date']));
			$from_fmonth = date('m', strtotime($data['start_date']));
			$fmonth = sprintf("%02d", $from_fmonth);
			$data['from_fmonth'] = $from_fyear."-".$fmonth;
			
			$to_fyear = date('Y', strtotime($data['end_date']));
			$to_fmonth = date('m', strtotime($data['end_date']));
			$tofmonth = sprintf("%02d", $to_fmonth);
			$data['to_fmonth'] = $to_fyear."-".$tofmonth;
			foreach($uncode as $key => $code){ 
				if($code != '')
				{
					$data['uncode'] = $this -> input -> post('uncode['.$key.']');
					$data['report_submitted'] = $this -> input -> post('report_submitted['.$key.']');
					$data['othername'] = 0;
					$data['doses_per_vial'] = 0;
					$data['target'] = 0;
					$data['wastage_facter'] = 0;
					$data['required_doses'] = 0;
					$data['required_vials'] = 0;
					$data['opening_bal_vials'] = 0;
					$data['requested_vials'] = 0;
					$data['recieved_vials'] = 0;
					$data['child_vacc_dose'] = 0;
					$data['vials_used'] = 0;
					$data['vials_unused'] = 0;
					$data['closing_bal'] = 0;
					if($data['report_submitted'] == '1'){
						$data['doses_per_vial'] = (is_numeric($this -> input -> post('doses_per_vial['.$key.']')))?$this -> input -> post('doses_per_vial['.$key.']'):0;
						if($data['vaccine_type'] == '40'){
							$data['othername'] = (is_numeric($this -> input -> post('othername['.$key.']')))?$this -> input -> post('othername['.$key.']'):0;
							$data['doses_per_vial'] = 0;
						}
						
						$data['target'] = (is_numeric($this -> input -> post('target['.$key.']')))?$this -> input -> post('target['.$key.']'):0;
						$data['wastage_facter'] = (is_numeric($this -> input -> post('wastage_facter['.$key.']')))?$this -> input -> post('wastage_facter['.$key.']'):0;
						$data['required_doses'] = (is_numeric($this -> input -> post('required_doses['.$key.']')))?$this -> input -> post('required_doses['.$key.']'):0;
						$data['required_vials'] = (is_numeric($this -> input -> post('required_vials['.$key.']')))?$this -> input -> post('required_vials['.$key.']'):0;
						$data['opening_bal_vials'] = (is_numeric($this -> input -> post('opening_bal_vials['.$key.']')))?$this -> input -> post('opening_bal_vials['.$key.']'):0;
						$data['requested_vials'] = (is_numeric($this -> input -> post('requested_vials['.$key.']')))?$this -> input -> post('requested_vials['.$key.']'):0;
						$data['recieved_vials'] = (is_numeric($this -> input -> post('recieved_vials['.$key.']')))?$this -> input -> post('recieved_vials['.$key.']'):0;
						$data['child_vacc_dose'] = (is_numeric($this -> input -> post('child_vacc_dose['.$key.']')))?$this -> input -> post('child_vacc_dose['.$key.']'):0;
						$data['vials_used'] = (is_numeric($this -> input -> post('vials_used['.$key.']')))?$this -> input -> post('vials_used['.$key.']'):0;
						$data['vials_unused'] = (is_numeric($this -> input -> post('vials_unused['.$key.']')))?$this -> input -> post('vials_unused['.$key.']'):0;
						$data['closing_bal'] = (is_numeric($this -> input -> post('closing_bal['.$key.']')))?$this -> input -> post('closing_bal['.$key.']'):0;
					}
					
					$dataARRY[] = $data; 
					
					if($this -> input -> post('edit') && $this -> input -> post('group_id'))
					{	
						$id = $this -> input -> post('group_id');
						unset($data['edit']);
						//print_r($data);exit;
						$updated_id = $this -> Common_model -> update_record('form_c_new_demand',$data,array('group_id' => $id, 'uncode' => $data['uncode']));
					}
				}
			}
		
			if($this -> input -> post('edit') && $this -> input -> post('group_id'))
			{							
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('UC-Demand-Consumption/List');
			}
			//print_r($dataARRY);exit;
			if(!$this -> input -> post('edit'))
			{
				$inserted_id = $this -> Common_model -> insert_batch_record('form_c_new_demand',$dataARRY);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('UC-Demand-Consumption/List');	
			}
		}else{
			$this -> session -> set_flashdata('message','You must select all required fields to continue. <br> *Select Your District. <br> *Select Your Tehsil. <br> *Select Your UnionCouncil. <br> *Select your Start date. <br> *Select your End Date.');
			redirect('UC-Demand-Consumption/Add');
		}
	}

	public function form_C_new_list(){
		dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " form_c_new_demand "; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '".$_SESSION["Province"]."'";
		$data = $this -> Data_entry_model -> form_C_new_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc,"group_Id");
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c_new_list';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	public function form_C_new_edit(){
		dataEntryValidator(0);
		$group_id = $this -> uri -> segment(3);
		$data['formC_Result'] = $this -> Common_model -> fetchall('form_c_new_demand', '','*', array('group_id' => $group_id,'report_submitted'=>'0'));
		
		$data['district']=get_District_Name($data['formC_Result'][0]['distcode']);
		$data['uc']=get_UC_Name($data['formC_Result'][0]['uncode']);
		$data['start_date']=$data['formC_Result'][0]['start_date'];
		$data['end_date']=$data['formC_Result'][0]['end_date'];
		$data['requested_by_name']=$data['formC_Result'][0]['requested_by_name'];
		$data['requested_by_desg']=$data['formC_Result'][0]['requested_by_desg'];
		$data['requested_by_store']=$data['formC_Result'][0]['requested_by_store'];
		$data['requested_on']=$data['formC_Result'][0]['requested_on'];
		$data['received_by_name']=$data['formC_Result'][0]['received_by_name'];
		$data['received_by_desg']=$data['formC_Result'][0]['received_by_desg'];
		$data['received_by_store']=$data['formC_Result'][0]['received_by_store'];
		$data['received_on']=$data['formC_Result'][0]['received_on'];
		$data['reported_by_name']=$data['formC_Result'][0]['reported_by_name'];
		$data['reported_by_desg']=$data['formC_Result'][0]['reported_by_desg'];
		$data['reported_by_store']=$data['formC_Result'][0]['reported_by_store'];
		$data['reported_on']=$data['formC_Result'][0]['reported_on'];
		$data['group_id']=$data['formC_Result'][0]['group_id'];
		$data['vaccine_name'] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $data['formC_Result'][0]['vaccine_type']));
		$data['edit']="Yes"; 
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c_new';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
		
		
		
	}
	public function form_C_new_view(){
		dataEntryValidator(0);
		$group_id = $this -> uri -> segment(3);
		$data['a'] = $this -> Common_model -> fetchall('form_c_new_demand', '','*', array('group_id' => $group_id));
		$data['district']=get_District_Name($data['a'][0]['distcode']);
		$data['uc']=get_UC_Name($data['a'][0]['uncode']);
		$data['campaign_type']=$data['a'][0]['campaign_type'];
		$data['start_date']=$data['a'][0]['start_date'];
		$data['end_date']=$data['a'][0]['end_date'];
		$data['requested_by_name']=$data['a'][0]['requested_by_name'];
		$data['requested_by_desg']=$data['a'][0]['requested_by_desg'];
		$data['requested_by_store']=$data['a'][0]['requested_by_store'];
		$data['requested_on']=$data['a'][0]['requested_on'];
		$data['received_by_name']=$data['a'][0]['received_by_name'];
		$data['received_by_desg']=$data['a'][0]['received_by_desg'];
		$data['received_by_store']=$data['a'][0]['received_by_store'];
		$data['received_on']=$data['a'][0]['received_on'];
		$data['reported_by_name']=$data['a'][0]['reported_by_name'];
		$data['reported_by_desg']=$data['a'][0]['reported_by_desg'];
		$data['reported_by_store']=$data['a'][0]['reported_by_store'];
		$data['reported_on']=$data['a'][0]['reported_on'];
		$data['group_id']=$data['a'][0]['group_id'];
		$data['vaccine_name'] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $data['a'][0]['vaccine_type']));
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_c_new_view';
			$data['pageTitle']='Form-C (EPI)  Demand, Consumption & Receipt Form | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	
	}
	//-----------------------------------------------------------------------------------------------------------------//
	public function form_A2_new(){
		dataEntryValidator(0);
		$data['data']=$this->Data_entry_model->form_A2_new();
		$data['edit']="Yes";
		$data['fileToLoad'] = 'data_entry/form_a2_new';
		$data['pageTitle']='Form A-2(Stock Issue & Receipt Voucher) | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}	
	//-----------------------------------------------------------------------------------------------------------------//
	public function form_A2_new_Save(){
        dataEntryValidator(0);
		if($this -> input -> post('campaign_type') && $this -> input -> post('distcode') && $this -> input -> post('vaccine_type')){
			//print_r($this->input->post()); 
			$dataARRY = array();
			$uncode= $this -> input -> post('uncode');
			$data['procode']=$_SESSION["Province"];
			$data['distcode']=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
			$data['is_temp_saved']=$this -> input -> post('is_temp_saved');
			
			if(!$this -> input -> post('edit')){
				$query = "Select max(group_id) as group_id from form_a2_new HAVING max(group_id) is not null ";
				$result = $this -> db -> query($query);
				if ($result -> num_rows() > 0) {
					$groupid = $result -> row_array();
					$newCode = $groupid['group_id'] + 1;
					if ($newCode != NULL) {
						$data['group_id'] = $newCode;
					} else {
						$data['group_id'] = '1';
					}
				} else {
			$data['group_id'] = '1';
				}
			}
			if($this -> input -> post('edit') && $this -> input -> post('group_id'))
			{
				$data['group_id'] = $this -> input -> post('group_id');
			}
			$data['campaign_type'] = $this -> input -> post('campaign_type');
			$data['vaccine_type'] = $this -> input -> post('vaccine_type');
			$data['issued_by_name'] = ($this -> input -> post('issued_by_name'))?$this -> input -> post('issued_by_name'):NULL;
			$data['issued_by_desg'] = ($this -> input -> post('issued_by_desg'))?$this -> input -> post('issued_by_desg'):NULL;
			$data['issued_by_store'] = ($this -> input -> post('issued_by_store'))?$this -> input -> post('issued_by_store'):NULL;
			$data['issued_on'] = ($this -> input -> post('issued_on'))?date('Y-m-d',strtotime($this -> input -> post('issued_on'))):NULL;
			$data['receive_by'] = ($this -> input -> post('received_by_name'))?$this -> input -> post('received_by_name'):NULL;
			$data['received_by_desg'] = ($this -> input -> post('received_by_desg'))?$this -> input -> post('received_by_desg'):NULL;
			$data['received_by_store'] = ($this -> input -> post('received_by_store'))?$this -> input -> post('received_by_store'):NULL;
			$data['received_on'] = ($this -> input -> post('received_on'))?date('Y-m-d',strtotime($this -> input -> post('received_on'))):NULL;
			$data['form_date']=($this -> input -> post('form_date'))?date('Y-m-d',strtotime($this -> input -> post('form_date'))):NULL;
			

			//echo 'xx'.$fmonth; exit;
			//print_r($data);exit;
			
				foreach($uncode as $key => $code){ 
				if($code != '')
				{
					$data['uncode'] = $this -> input -> post('uncode['.$key.']');
					$data['report_submitted'] = $this -> input -> post('report_submitted['.$key.']');
					$data['othername'] = 0;
					$data['doses_per_vial'] = 0;
					$data['manufacturer'] = NULL;
					$data['expirydate'] = NULL;
					$data['batch_no'] = NULL;
					$data['iq_vialsno'] = 0;
					$data['iq_totaldoses'] = 0;
					$data['iq_vvmstage'] = $this -> input -> post('iq_vvmstage['.$key.']');
					$data['rq_vialsno'] = 0;
					$data['rq_totaldoses'] =0;
					$data['rq_vvmstage'] = $this -> input -> post('rq_vvmstage['.$key.']');
				
					if($data['report_submitted'] == '1'){
						$data['doses_per_vial'] = (is_numeric($this -> input -> post('doses_per_vial['.$key.']')))?$this -> input -> post('doses_per_vial['.$key.']'):0;
						if($data['vaccine_type'] == '40'){
							$data['othername'] = (is_numeric($this -> input -> post('othername['.$key.']')))?$this -> input -> post('othername['.$key.']'):0;
							$data['doses_per_vial'] = 0;
						}
						$data['manufacturer'] = ($this -> input -> post('manufacturer['.$key.']'))?$this -> input -> post('manufacturer['.$key.']'):0;
						$data['batch_no'] = ($this -> input -> post('batch_no['.$key.']'))?$this -> input -> post('batch_no['.$key.']'):NULL;
						$data['iq_vialsno'] = (is_numeric($this -> input -> post('iq_vialsno['.$key.']')))?$this -> input -> post('iq_vialsno['.$key.']'):0;
						$data['iq_totaldoses'] = (is_numeric($this -> input -> post('iq_totaldoses['.$key.']')))?$this -> input -> post('iq_totaldoses['.$key.']'):0;
						$data['rq_vialsno'] = (is_numeric($this -> input -> post('rq_vialsno['.$key.']')))?$this -> input -> post('rq_vialsno['.$key.']'):0;
						$data['rq_totaldoses'] = (is_numeric($this -> input -> post('rq_totaldoses['.$key.']')))?$this -> input -> post('rq_totaldoses['.$key.']'):0;
						$data['expirydate'] = ($this -> input -> post('expirydate['.$key.']'))?$this -> input -> post('expirydate['.$key.']'):0;
					}
					
					$dataARRY[] = $data; 
					if($this -> input -> post('edit') && $this -> input -> post('group_id'))
					{	
						$id = $this -> input -> post('group_id');
						unset($data['edit']);
						//print_r($data);exit;
						$updated_id = $this -> Common_model -> update_record('form_a2_new',$data,array('group_id' => $id, 'uncode' => $data['uncode']));
					}
				}
			}
		
			if($this -> input -> post('edit') && $this -> input -> post('group_id'))
			{							
				$this -> session -> set_flashdata('message','You have successfully updated your record!');
				redirect('District-Issue-Receipt/List');
			}
			//print_r($dataARRY);exit;
			if(!$this -> input -> post('edit'))
			{
				$inserted_id = $this -> Common_model -> insert_batch_record('form_a2_new',$dataARRY);
				$this -> session -> set_flashdata('message','You have successfully saved your record!');
				redirect('District-Issue-Receipt/List');
			}
		}else{
			$this -> session -> set_flashdata('message','You must select all required fields to continue. <br> *Select Your District. <br> *Select Your Tehsil. <br> *Select Your UnionCouncil. <br> *Select your Start date. <br> *Select your End Date.');
			redirect('District-Issue-Receipt/List');
		}
	}
	///////////////////////////////////////////////////Form A2 Save Function END//////////////////////////////////////////////////////
	////////////////////////////////////////////////////Form A2 Edit Function/////////////////////////////////////////////////////////
	public function form_A2_new_edit(){
		dataEntryValidator(0);
		$group_id = $this -> uri -> segment(3);
		//$data['formA2_Result'] = $this -> Common_model -> fetchall('form_a2_new', '','*', array('group_id' => $group_id,'report_submitted'=>'0'));
		$data['formA2_Result'] = $this -> Common_model -> fetchall('form_a2_new', '','*', array('group_id' => $group_id));
		$data['district']=get_District_Name($data['formA2_Result'][0]['distcode']);
		$data['uc']=get_UC_Name($data['formA2_Result'][0]['uncode']);
		$data['form_date']=$data['formA2_Result'][0]['form_date'];
		$data['vaccine_type']=$data['formA2_Result'][0]['vaccine_type'];
		$data['campaign_type']=$data['formA2_Result'][0]['campaign_type'];
		$data['issued_by_name'] = $data['formA2_Result'][0]['issued_by_name'];
		$data['issued_by_desg'] = $data['formA2_Result'][0]['issued_by_desg'];
		$data['issued_by_store'] = $data['formA2_Result'][0]['issued_by_store'];
		$data['issued_on'] = $data['formA2_Result'][0]['issued_on'];
		$data['receive_by'] = $data['formA2_Result'][0]['receive_by'];
		$data['received_by_desg'] = $data['formA2_Result'][0]['received_by_desg'];
		$data['received_by_store'] = $data['formA2_Result'][0]['received_by_store'];
		$data['received_on'] = $data['formA2_Result'][0]['received_on'];
		$data['group_id']=$data['formA2_Result'][0]['group_id'];
		$data['vaccine_name'] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $data['formA2_Result'][0]['vaccine_type']));
		$data['edit']="Yes"; 
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_a2_new';
			$data['pageTitle']='Form A-2(Stock Issue & Receipt Voucher) | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
		
		
		
	}
	/////////////////////////////////////////Function End ///////////////////////////////////////////////////////////////
	//////////////////////////////////////////Form A2 View Function Starts//////////////////////////////////////////////
		public function form_A2_new_view(){
			dataEntryValidator(0);
			$group_id = $this -> uri -> segment(3);
			$data['a2'] = $this -> Common_model -> fetchall('form_a2_new', '','*', array('group_id' => $group_id));
			
			$data['district']=get_District_Name($data['a2'][0]['distcode']);
			$data['uc']=get_UC_Name($data['a2'][0]['uncode']);
			$data['form_date']=$data['a2'][0]['form_date'];
			$data['vaccine_type']=$data['a2'][0]['vaccine_type'];
			$data['campaign_type']=$data['a2'][0]['campaign_type'];
			$data['issued_by_name'] = $data['a2'][0]['issued_by_name'];
			$data['issued_by_desg'] = $data['a2'][0]['issued_by_desg'];
			$data['issued_by_store'] = $data['a2'][0]['issued_by_store'];
			$data['issued_on'] = $data['a2'][0]['issued_on'];
			$data['receive_by'] = $data['a2'][0]['receive_by'];
			$data['received_by_desg'] = $data['a2'][0]['received_by_desg'];
			$data['received_by_store'] = $data['a2'][0]['received_by_store'];
			$data['received_on'] = $data['a2'][0]['received_on'];
			$data['group_id']=$data['a2'][0]['group_id'];
			$data['vaccine_name'] = $this -> Common_model -> get_info('form_a1_vaccine_titles', '', '','vaccine_name', array('id' => $data['a2'][0]['vaccine_type']));
			$data['edit']="Yes";
			if($data != 0){
				$data['data']=$data;
				$data['fileToLoad'] = 'data_entry/form_a2_new_view';
				$data['pageTitle']='Form A-2(Stock Issue & Receipt Voucher) | EPI-MIS';
				$this->load->view('template/epi_template',$data);
			}
			else{
				$data['message'] ="You must have rights to access this page.";
				$this -> load -> view ('message',$data);
			}
		
		}
	////////////////////////////////////////////Form A2 View Fucntions Ends///////////////////////////////////////////////////////////	
	////////////////////////////////////////////Form A2 List Function Starts//////////////////////////////////////////////////////////
	
	public function form_A2_new_list(){
		dataEntryValidator(0);
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		$per_page = 15 ; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;		
		$statement = " form_a2_new"; // Change `records` according to your table name.
		if($this -> session -> District)
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."' and form_date <> '1970-01-01'";
		else
			$wc=" procode = '".$_SESSION["Province"]."' and form_date <> '1970-01-01'";
		$data = $this -> Data_entry_model -> form_A2_new_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement,$per_page,$page,$url='?',$wc,"group_id");
		$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'data_entry/form_a2_new_list';
			$data['pageTitle']='Form A-2(Stock Issue & Receipt Voucher) | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
	
	//////////////////////////////////////////Form A2 List Functions Starts////////////////////////////////////////////////////////

}//End of Data Entry Controller Class
?>