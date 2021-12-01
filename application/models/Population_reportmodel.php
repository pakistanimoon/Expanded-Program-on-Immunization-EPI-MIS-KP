<?php
class Population_reportmodel extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	function vf_population_report($data){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Villages_and_HF_based_Population.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $data['distcode'];
		$year = $data['year'];
		$query="select uncode,un_name,(select sum(population::numeric) from facilities_population where year='$year' and uncode=unioncouncil.uncode) as hf_based_population,(select sum(population::numeric) from villages_population where year='$year' and uncode=unioncouncil.uncode) as village_based_population from unioncouncil where distcode='$distcode'";
		$result = $this-> db-> query($query);	
		$resultt['data'] = $result-> result_array(); 
		$resultt['distcode']=$distcode;
		$resultt['year']=$year;
		return $resultt;
	}	
} 