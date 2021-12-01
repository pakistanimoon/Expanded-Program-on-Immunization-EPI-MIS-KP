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
		if(isset($data['distcode']) > 0){
			$wc[] = " distcode = '".$data['distcode']."' ";
			$distcode=$data['distcode'];
		}
		if(isset($data['tcode']) > 0){
			$wc[] = " tcode = '".$data['tcode'] ."' ";
		}
		$year = $data['year'];
		$query="select uncode,un_name,(select sum(population::numeric) from facilities_population where year='$year' and uncode=unioncouncil.uncode) as hf_based_population,(select sum(population::numeric) from villages_population where year='$year' and uncode=unioncouncil.uncode) as village_based_population from unioncouncil 
		".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."";
		$result = $this-> db-> query($query);	
		$resultt['data'] = $result-> result_array(); 
		$resultt['distcode']=$distcode;
		$resultt['year']=$year;
		return $resultt;
	}
	function village_population_not_set($data){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Villages/Mohalla_not_set_population_report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		} 
		//Excel file code ENDS*******************
		$distcode = (isset($data['distcode'])?$data['distcode']:0);
		$year = $data['year'];
		$procode = $this -> session -> Province;
		//print_r($procode);exit;
		if(isset($distcode) AND $distcode > 0){
			$wc ="distcode='$distcode'";
		}else{
			$wc ="procode='$procode'";
		}
		$tcode=$this -> session -> Tehsil;
		 if(isset($tcode) AND $tcode > 0){
			$wc = "tcode = '". $tcode . "'";
		} 
		$query="select tcode, tehsil, count (*) as totalucs, sum(case when noofvillages > 0 then 1 else 0 end) as noofucwithvillagesadded,(case when villagespopulation > 0 then villagespopulation else 0 end) villagespopulation from 
		(select a.tcode, tehsilname(a.tcode) as tehsil, a.uncode, a.un_name, a.villagespopulation, coalesce(b.cnt, 0) as noofvillages from
		(select tcode, uncode,(select sum(population::integer) from villages_population where tcode=unioncouncil.tcode) as villagespopulation, un_name from unioncouncil where ".$wc.") as a left outer join
		(select uncode, count (*) as cnt from villages where ".$wc." group by uncode) as b on a.uncode=b.uncode order by a.uncode) as c group by tcode, tehsil,villagespopulation";
		$result = $this-> db-> query($query);	
		$resultt['data'] = $result-> result_array(); 
		$resultt['distcode']=$distcode;
		$resultt['year']=$year;
		//print_r($resultt);exit;
		return $resultt;
	}
	function village_population_not_set_uc($tcode,$year){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Villages/Mohalla_not_set_population_report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode=$this -> session -> District;
		$query="select a.tcode,(case when a.villagespopulation > 0 then a.villagespopulation else 0 end) villagespopulation, tehsilname(a.tcode) as tehsil, a.uncode, a.un_name, coalesce(b.cnt, 0) as noofvillages from
				(select tcode, uncode, (select sum(population::integer) from villages_population where uncode=unioncouncil.uncode) as villagespopulation, un_name from unioncouncil where tcode='$tcode') as a left outer join
				(select uncode, count(*) as cnt from villages where tcode='$tcode' group by uncode) as b on a.uncode=b.uncode order by a.uncode;";
		$result = $this-> db-> query($query);	
		$resultt['data'] = $result-> result_array(); 
		$resultt['tcode']=$tcode;
		$resultt['distcode']=$distcode;
		$resultt['year']=$year;
		//print_r($resultt);exit;
		return $resultt;
	}
//	modifaction in epikb (Manage HR)
// 
} 