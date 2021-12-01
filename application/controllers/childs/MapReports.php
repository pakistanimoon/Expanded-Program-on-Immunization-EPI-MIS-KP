<?php
class MapReports extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');

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

	function map_view(){		
		$data = $this -> uri->segment(3);
		$longitude = $this -> uri->segment(4);
		//print_r($longitude); exit; 
		$data = $this -> child -> map_view($data,$longitude); 
		$data['data'] = $data;
		$this->load->view('childs/map_view', $data);
	}
	
}
?>