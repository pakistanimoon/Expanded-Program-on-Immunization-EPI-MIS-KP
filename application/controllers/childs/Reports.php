<?php
//local
class Reports extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> model ('Child_model',"child");
		$this -> load -> library('reportfilters');
	}
	/*
	@ Author:        Muhammad Mata ur Rahman
	@ Email:         mata@pace-tech.com
	@ Function:      Child Registration
	@ Description:   This function will open Reports of Child Registration
	*/
	public function child_reg_filter(){
		$this -> load -> library('reportfilters');
		$reportPath = base_url()."Reports/ChildRegistration";
		$reportTitle = "Permanent Register";
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
	
	function child_reg(){
		$data['facode']=$this->input-> get_post('facode');
		$data['uncode']=$this->input-> get_post('uncode');
		$data['tcode']=$this->input-> get_post('tcode');
		$data['distcode']=$this->input-> get_post('distcode');
		$data['technician']=$this->input-> get_post('technician');
		$data['defaulters']=$this->input-> get_post('defaulters');
		//print_r($data['distcode']);exit;
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 100;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cerv_child_registration";
		$dataChild['pageTitle']='EPI-MIS | Permanent Vaccination Register';
		$dataChild['data'] = $this -> child -> Child_Registration($dataChild['pageTitle'],$data,$per_page,$startpoint);
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
		$wc .= 'procode is not NULL AND deleted_at IS NULL';
		if($data['defaulters'] == 1){
			$date = date('Y-m-d');
			$wc .= "
								AND 
								((opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								
								(opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day) OR
								(rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day) OR
								(pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day) OR
								(penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day) OR
								
								(opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day) OR
								(ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '101' day) OR
								(pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day) OR
								(penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day) OR
								
								(measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day) OR
								(measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day))
			";
		}
		//echo '<pre>';print_r($data);exit;
		$dataChild['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url, $wc);
		$dataChild['startpoint'] = ($page * $per_page) - $per_page;
		$dataChild['fileToLoad'] = 'cervReports/permanent_vaccination_register_view';
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
	function child_cardview(){ 
		//print_r($POST); exit; 
		$child_registration_no = $this->input->get_post('cardno');
		$data = $this -> child ->child_cardview($child_registration_no);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'childs/child_cardview';
			$data['pageTitle'] = 'EPI-MIS | Child Registration Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	function map_view(){		
		$data = $this -> uri->segment(3);
		$longitude = $this -> uri->segment(4);
		//print_r($longitude); exit; 
		$data = $this -> child -> map_view($data,$longitude); 
		$data['data'] = $data;
		$this->load->view('childs/map_view', $data);
	}
	function delete_child_record(){
		$recno = $this -> input -> get('recno');
		$result = $this -> child -> delete_child_record($recno);
		if($result === true){
			$this -> child -> updateSequence($recno);
			echo true;exit;
		}
		echo false;
	}
}
?>