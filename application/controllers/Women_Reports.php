<?php
class Women_Reports extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> model ('Women_model',"woman");
		$this -> load -> library('reportfilters');
	}
	
	public function WomenRegistrationFilter(){
		$this -> load -> library('reportfilters');
		$reportPath = base_url()."Women_Reports/WomenRegistration";
		$reportTitle = "Women Permanent Register";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$options = array(
						array(
							'type' => 'dropdown',
							0 => 'Technician',
							'class' => 'techniciancode',
							'00' => '--Select Technician--'
						),
						array(
							'type' => 'checkbox',
							0 => 'Defaulters',
							'class' => 'defaulter_childs'
						)
					);
		$customDropDown = $options;
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,false,false,NULL,NULL,NULL,NULL,NULL,$customDropDown);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	
	function WomenRegistration(){
		
		$data['facode']=$this->input-> get_post('facode');
		$data['uncode']=$this->input-> get_post('uncode');
		$data['tcode']=$this->input-> get_post('tcode');
		$data['distcode']=$this->input-> get_post('distcode');
		$data['technician']=$this->input-> get_post('technician');
		$data['defaulters']=$this->input-> get_post('defaulters');
		//print_r($data);exit;
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 100;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cerv_mother_registration";
		$dataChild['pageTitle']='EPI-MIS | Women Permanent Vaccination Register';
		$dataChild['data'] = $this -> woman -> Women_Registration($dataChild['pageTitle'],$data,$per_page,$startpoint);
		$url = '';
		if (isset($_SESSION['Province'])) {
			$wc = " procode = '" . $_SESSION['Province'] . "' AND ";
			$url .= "?procode=".$_SESSION['Province'].'&';
		}
		if($data['distcode'] > 0)
		{	
			$wc = "distcode= '".$data['distcode']."' AND ";
			$url .= "distcode=".$data['distcode'].'&';
		}
		if(isset($data['tcode']) AND $data['tcode'] > 0){
			$wc = "tcode= '".$data['tcode']."' AND ";
			$url .= "tcode=".$data['tcode'].'&';
		}
		if(isset($data['uncode']) AND $data['uncode'] > 0){
			$wc = "uncode= '".$data['uncode']."' AND ";
			$url .= "uncode=".$data['uncode'].'&';
		}
		if(isset($data['facode']) AND $data['facode'] > 0){
			$wc = "reg_facode= '".$data['facode']."' AND ";
			$url .= "facode=".$data['facode'].'&';
		}
		if(isset($data['technician']) AND $data['technician'] > 0){
			$wc = "techniciancode= '".$data['technician']."' AND ";
			$url .= "technician=".$data['technician'].'&';
		}
		if(isset($data['defaulters']) && $data['defaulters'] == 1){
			$url .= "defaulters=".$data['defaulters'].'&';
		}
		$wc .= 'procode is not NULL';
		if($data['defaulters'] == 1){
			//echo'yo';exit;
			$date = date('Y-m-d');
			$wc .= "
			AND ((tt1 is null and tt2 is null and tt3 is null and tt4 is null and tt5 is null) or
			(tt1 is not null and tt2 is null and tt3 is null and tt4 is null and tt5 is null  AND '{$date}'::date >= tt1) or
			(tt2 is not null and tt3 is null and tt4 is null and tt5 is null  AND '{$date}'::date >= tt1 + interval '30' day) or
			(tt3 is not null and tt4 is null and tt5 is null AND '{$date}'::date >= tt2 + interval '1 month'*6) or
			(tt4 is not null and tt5 is null AND '{$date}'::date >= tt3 + interval '1 year')					
			)";
		}
		//echo '<pre>';print_r($data);exit;
		$dataChild['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url, $wc);
	    //echo '<pre>';print_r($dataChild);exit;
		$dataChild['startpoint'] = ($page * $per_page) - $per_page;
		$dataChild['fileToLoad'] = 'cervReports/women_vaccination_register_view';
		$this -> load -> view('template/reports_template',$dataChild);
	}
	/* public function Pagination_list() {
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "hrdb";
		$data = $this -> System_setup_model -> pagination_new($per_page,$startpoint);
		//echo '<pre>';print_r($data);exit;
		$data['pagination'] = $this -> Child_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$data['edit']="Yes";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/Reports/Pagination_list';
			$data['pageTitle'] = 'EPI-MIS | Permanent Vaccination Register';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	} */	
	// function child_cardview(){ 
	// 	//print_r($POST); exit; 
	// 	$child_registration_no = $this->input->get_post('cardno');
	// 	$data = $this -> child ->child_cardview($child_registration_no);
	// 	if ($data != 0) {
	// 		$data['data'] = $data;
	// 		$data['fileToLoad'] = 'childs/child_cardview';
	// 		$data['pageTitle'] = 'EPI-MIS | Child Registration Form';
	// 		$this -> load -> view('template/epi_template', $data);
	// 	} else {
	// 		$data['message'] = "You must have rights to access this page.";
	// 		$this -> load -> view("message", $data);
	// 	}
	// }
	// function map_view(){		
	// 	$data = $this -> uri->segment(3);
	// 	$longitude = $this -> uri->segment(4);
	// 	//print_r($longitude); exit; 
	// 	$data = $this -> child -> map_view($data,$longitude); 
	// 	$data['data'] = $data;
	// 	$this->load->view('childs/map_view', $data);
	// }
	
}
?>