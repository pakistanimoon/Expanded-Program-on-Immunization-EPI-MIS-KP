<?php
class Case_response_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	public function add_case($distcode)
	{	$this-> db-> select('tcode,tehsil');
		$this-> db-> from('tehsil');
		$this-> db-> where('distcode',$distcode);
		/*
		$this-> db-> select('uncode,un_name');
		$this-> db-> from('unioncouncil');
		$this-> db-> where('distcode',$distcode);*/
		$data['tehsil'] = $this-> db-> get()-> result_array();
		$this-> db-> select ('vacc_id,name');
		$this-> db-> from ('epi_vacc_products_details');
		$data['epi_vacc_products_details'] = $this-> db-> get()-> result_array();
		return $data;
	}	
	public function save_case_response($save_case_response)
	{		
		$this->db->insert('case_response_tbl',$save_case_response);
		 //echo $this->db->last_query();exit();
		return TRUE;		
	}
		public function case_list($start,$length,$order,$dir,$multiple_search)
	{	$wc = getWC();
		$distcode =$this -> session -> District;
		/*$post_data['cardno1']=$cardno1;
		$post_data['nic1']=$nic1;
		$post_data['mobile']=$mobile;*/
		$post_data['distcode']=$distcode;
		/*$wc=array();
		if($post_data['cardno1']!=""){
		$wc[] = "cardno like '" . $post_data['cardno1'] . "%'";
		}
		if($post_data['distcode'] > 0){
		$wc[] = "distcode = '" . $post_data['distcode'] . "'";
		}*/
		/*if($post_data['nic1']!=""){
		$wc[] = "cnic_patient like '" . $post_data['nic1'] . "%'";
		}*/
		/*if($post_data['mobile']!=""){
		$wc[] = "mobile_patient like '" . $post_data['mobile'] . "%'";
		}
		if($post_data['distcode'] > 0){
			$wc['and distcode ='] = $post_data['distcode'];
		}*/
		//print_r($multiple_search);exit;
		$space="  ";
		$query ="select tehsilname(tcode)as tehsil,districtname(distcode) as district,vcode,unname(uncode)as unioncouncil,disease,date_of_activity from case_response_tbl where {$wc} {$multiple_search} GROUP BY vcode,distcode,tcode,uncode,disease,date_of_activity {$order} LIMIT {$length} OFFSET {$start} ";
		//echo $query; exit;
		return $this->db->query($query);
	}
		public function case_get_total($multiple_search)
	{
		$wc = getWC();
		//$distcode =$this -> session -> District;
		/*$post_data['cardno1']=$cardno1;
		$post_data['nic1']=$nic1;
		$post_data['mobile']=$mobile;*/
		//$post_data['distcode']=$distcode;
		//$wc=array();
		/*if($post_data['cardno1']!=""){
		$wc[] = "cardno = '" . $post_data['cardno1'] . "'";
		}
		if($post_data['nic1']!=""){
		$wc[] = "cnic_patient = '" . $post_data['nic1'] . "'";
		}
		if($post_data['mobile']!=""){
		$wc[] = "mobile_patient = '" . $post_data['mobile'] . "'";
		}
		if($post_data['distcode'] > 0){
		$wc[] = "distcode = '" . $post_data['distcode'] . "'";
		}*/
		$query ="select count(*) as num  from (select count(*) as num  from case_response_tbl where {$wc} {$multiple_search} GROUP BY vcode,distcode,tcode,uncode,disease,date_of_activity) as d ";
		$query = $this->db->query($query);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}
		public function case_view($vcode,$activitydate)
	{
		$this-> db-> select('*');
		$this-> db-> from('case_response_tbl');
		$this-> db-> where('vcode',$vcode);
		$this-> db-> where('date_of_activity',$activitydate);
		$data['case_view'] = $this-> db-> get()-> result_array();
		return $data;
	}
		public function case_edit($vcode,$activitydate)
	{	$distcode=$this -> session -> District;
		$this-> db-> select('tcode,tehsil');
		$this-> db-> from('tehsil');
		$this-> db-> where('distcode',$distcode);
		/*
		$this-> db-> select('uncode,un_name');
		$this-> db-> from('unioncouncil');
		$this-> db-> where('distcode',$distcode);*/
		$data['tehsil'] = $this-> db-> get()-> result_array();
		$this-> db-> select ('vacc_id,name');
		$this-> db-> from ('epi_vacc_products_details');
		$data['epi_vacc_products_details'] = $this-> db-> get()-> result_array();
		$this-> db-> select('*');
		$this-> db-> from('case_response_tbl');
		$this-> db-> where('vcode',$vcode);
		$this-> db-> where('date_of_activity',$activitydate);
		$data['case_edit'] = $this-> db-> get()-> result_array();
		return $data;
	}
	public function edit_case_response($date_of_activity,$uncode,$distcode,$edit_case_response)
	{		
		$this->db->where('date_of_activity', $date_of_activity);
		$this->db->where('uncode', $uncode);
		$this->db->where('distcode', $distcode);
		$this->db->delete('case_response_tbl');		
		$this->db->insert_batch('case_response_tbl', $edit_case_response);
		 //echo $this->db->last_query();exit();
		return TRUE;		
	}
	public function response($date_of_activity,$uncode,$vcode)
	{
		$this-> db-> select('date_of_activity,uncode,vcode');
		$this-> db-> from('case_response_tbl');
		$this-> db-> where('date_of_activity',$date_of_activity);
		$this-> db-> where('uncode',$uncode);
		$this-> db-> where('vcode',$vcode);		
		$data['add'] = $this-> db-> get()-> result_array();
		return $data;
	}

}