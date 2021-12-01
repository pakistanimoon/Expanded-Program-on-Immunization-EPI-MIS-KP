<?php
class SessionInformation extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> model('dashboard/dashboard_model','dashboard');
	}
	public function sessionInfo(){
		$year = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		$data['year']  = $year;
		$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
		$data['month'] = $month;
		$reportType = ($this -> input -> post('report_type'))?$this -> input -> post('report_type'):'yearly';
		$data['reportType'] = $reportType;
		$session_type = ($this->input->post('session_type'))?$this->input->post('session_type'):'Fixed';
		$data['vaccineBy'] = $session_type;
		$utype=$this -> session -> utype;
		if($utype == "DEO")
		{
			$dist = $this->session->District;
			$dataResult = $this->dashboard->sessionInfoFac($year,$dist,$month,$reportType,$session_type);
		}
		else
			$dataResult = $this->dashboard->sessionInfo($year,$month,$reportType,$session_type);
		$category = array();
		$serieses = array();
		$cat = array();
		$result = array();
		$i=0;
		//$serieses[0]['data']['name'] = "Planned";
		//$serieses[1]['data']['name'] = "Conducted";
		foreach($dataResult as $row){
			$category[$i] = $row-> name;//$row['Kpis_Value'];
			
			$serieses[0]['name'] = "Planned";
			$serieses[0]['data'][$i]['y'] = $row-> planned;//$row['Kpis_Value'];
			$serieses[0]['data'][$i]['distcode'] = $row->code;
			$serieses[1]['name'] = "Conducted";
			$serieses[1]['data'][$i]['y'] = $row-> conducted;
			$serieses[1]['data'][$i]['distcode'] = $row->code;
			$i++;
		}
		$result['data'] = $data;
		
		//print_r($serieses);exit;
		//$result['ser'] = json_encode($cat,JSON_NUMERIC_CHECK);
		//$result['distcode'] = json_encode($cat,JSON_NUMERIC_CHECK);
		$result['serieses'] = json_encode($serieses,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($category,JSON_NUMERIC_CHECK);
		$result['pageTitle']='EPI-MIS Dashboard';
		$result['fileToLoad'] = 'dashboard/sessionInfo';
		
		//print_r($result);exit;
		$this->load->view('template/epi_template',$result);
	}
	public function sessionInfoFac(){
		$year = ($this -> input -> post('year'))?($this -> input -> post('year')):date('Y');
		$dist = $this -> input -> post('dist')?$this -> input -> post('dist'):'';
		$session_type = ($this->input->post('session_type'))?$this->input->post('session_type'):'Fixed';
		//echo $dist;exit;
		$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
		$reportType = ($this -> input -> post('reportType'))?($this -> input -> post('reportType')):'yearly';
		$data['month'] = $month;
		$data['year']  = $year;
		$data['vaccineBy'] = $session_type;
		$dataResult = $this->dashboard->sessionInfoFac($year,$dist,$month,$reportType,$session_type);
		//print_r($dataResult);exit;
		$category = array();
		$serieses = array();
		$cat = array();
		$result = array();
		$i=0;
		//$serieses[0]['data']['name'] = "Planned";
		//$serieses[1]['data']['name'] = "Conducted";
		foreach($dataResult as $row){
			$category[$i] = $row-> name;//$row['Kpis_Value'];
			$serieses[0]['name'] = "Planned";
			$serieses[0]['data'][$i]['y'] = $row-> planned;//$row['Kpis_Value'];
			$serieses[0]['data'][$i]['code'] = $row->code;
			$serieses[1]['name'] = "Conducted";
			$serieses[1]['data'][$i]['y'] = $row-> conducted;
			$serieses[1]['data'][$i]['code'] = $row->code;
			$i++;
		}
		//print_r($serieses);exit;
		$result['data'] = $data;
		$result['serieses'] = $serieses;
		$result['category'] = $category;
		echo json_encode($result,JSON_NUMERIC_CHECK);
	}
	public function sessionInfoFacMonth(){
		$year = ($this -> input -> post('year'))?($this -> input -> post('year')):date('Y');
		$code = $this -> input -> post('facode')?$this -> input -> post('facode'):'';
		$session_type = $this->input->post('session_type');
		//echo $code;exit;
		//$month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
		$reportType = ($this -> input -> post('reportType'))?($this -> input -> post('reportType')):'yearly';
		//$data['month'] = $month;
		$data['year']  = $year;
		$data['facode'] = $code;
		$data['vaccineBy'] = $session_type;
		$dataResult = $this->dashboard->sessionInfoFacMonth($year,$code,$reportType,$session_type);
		//print_r($dataResult);exit;
		$category = array();
		$serieses = array();
		$cat = array();
		$result = array();
		$i=0;
		//$serieses[0]['data']['name'] = "Planned";
		//$serieses[1]['data']['name'] = "Conducted";
		foreach($dataResult as $row){
			$category[$i] = $row-> month;//$row['Kpis_Value'];
			$serieses[0]['name'] = "Planned";
			$serieses[0]['data'][$i]['y'] = $row-> planned;//$row['Kpis_Value'];
			$serieses[0]['data'][$i]['code'] = $row->code;
			$serieses[1]['name'] = "Conducted";
			$serieses[1]['data'][$i]['y'] = $row-> conducted;
			$serieses[1]['data'][$i]['code'] = $row->code;
			$i++;
		}
		//print_r($serieses);exit;
		$result['data'] = $data;
		$result['serieses'] = $serieses;
		$result['category'] = $category;
		echo json_encode($result,JSON_NUMERIC_CHECK);
	}
	
}
