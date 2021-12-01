<?php
class Ajax_calls extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Ajax_calls_model');
	}	
	public function getUnC() {
  		$tcode = $this -> input -> post('tcode');
  		$data = $this -> Ajax_calls_model -> getUnC($tcode);
  		echo $data;
 	}
 	public function getFacility() {
  		$uncode = $this -> input -> post('uncode');
  		$data = $this -> Ajax_calls_model -> getFacility($uncode);
  		echo $data;
 	}
 		public function getFacilityType() {
  		//$uncode = $this -> input -> post('uncode');
  		$data = $this -> Ajax_calls_model -> getFacilityType();
  		echo $data;
 	}
 	public function getFacilityuc() {
  		//$uncode = $this -> input -> post('uncode');
  		$distcode=$this-> session -> userdata('distcode');
  		$data = $this -> Ajax_calls_model -> getFacilityuc($distcode);
  		echo $data;
 	}
	public function getcardno()
	{
		$cardno = $this -> input -> post('cardno');
		$this->db->select('count(*) as cnt');
		$this->db->from('patients');
		$this->db->where('cardno',$cardno);
		$num_results = $this->db->get()->row();
		if($num_results->cnt > 0){
			echo 1;
		}else{
			echo 0;
		}

	}
	public function getnic()
	{
		$nic = $this -> input -> post('nic');
		$this->db->select('count(*) as cnt');
		$this->db->from('patients');
		$this->db->where('cnic_patient',$nic);
		$num_results = $this->db->get()->row();
		if($num_results->cnt > 0){
			echo 1;
		}else{
			echo 0;
		}

	}
	public function view_visit_data()
	{
		$cardno = $this-> input-> post('cardno');
		/*$this-> db-> select('tcode');
		//$this-> db-> select('tehsilname');
		$this-> db-> from('tehsil');
		$this-> db-> where('distcode',$this-> session -> userdata('distcode'));
		$data['tehsil'] = $this-> db-> get()-> result_array();*/

		/*$this->db->distinct();
		$this-> db-> select ('designation');
		$this-> db-> from ('patients');
		$this-> db-> where('distcode',$this-> session -> userdata('distcode'));
		$this->db->where('designation is NOT NULL', NULL, FALSE);
		$data['designation'] = $this-> db-> get()-> result_array();*/

		/*$this->db->distinct();
		$this-> db-> select ('facode');
		$this-> db-> select ('facilityname');
		$this->db->order_by("facilityname", "asc");
		$this-> db-> from ('facilities');
		$this-> db-> where('distcode',$this-> session -> userdata('distcode'));
		$this->db->where('facode is NOT NULL', NULL, FALSE);
		$data['facilities'] = $this-> db-> get()-> result_array();*/

		$this-> db-> select('*');
		$this-> db-> from('patients pat');
		$this->db->join('activitydetails act', ' pat.cardno = act.cardno');
		/*$this-> db-> where('act.distcode',$distcode);*/
		$this-> db-> where('act.cardno',$cardno);
		$data['add_visit'] = $this-> db-> get()-> result_array();

		echo $this->load->view('ajax_add_visit',$data,true);

		//echo json_encode($resultAR[0],true);

	}
	public function getMonths() {
  		$year = $this -> input -> post('year');
  		$selectedmonth = $this -> input -> post('month');
  		getAllMonthsOptions($selectedmonth,$year);
 	}
 	/*
	@ Author:        Nasir Israr
	@ Email:         nasir@pace-tech.com
	@ Function:      Get months
	@ Description:   Form dropdowns
	*/
 	public function getStockMonths(){		
		$year = $this-> input-> get('year');
		$data = $this-> Ajax_calls_model-> getAjaxMonthsOptions(false,$year);
		echo $data;		
	}
	public function getDistrictOpeningBal(){
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$distcode = $this->input->post('distcode');		
		$data=$this -> Ajax_calls_model -> getDistrictOpeningBal($month,$year,$distcode);
		echo $data;
	}
	public function getProvinceOpeningBal(){
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$data=$this -> Ajax_calls_model -> getProvinceOpeningBal($month,$year);
		echo $data;
	}
	public function dist_stock_filter(){
		$year = $this-> input-> get('year');
		$month = $this-> input-> get('month');  
		$data = $this-> Ajax_calls_model-> dist_stock_filter($year, $month);
		echo $data;
	}
	public function pro_stock_filter(){	
		$year = $this-> input-> get('year');
		$month = $this-> input-> get('month');  
		$data = $this-> Ajax_calls_model-> pro_stock_filter($year, $month);
		echo $data;
	}
	public function getMeasles_Case(){
		$distcode = $this-> input-> get('distcode');
		$data = $this-> Ajax_calls_model-> getMeasles_Case($distcode);
		echo $data;
	}
}
?>