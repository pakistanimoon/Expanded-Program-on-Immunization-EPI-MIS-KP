<?php
//class Sanctionedposts_report_model starts
class Sanctionedposts_report_model extends CI_Model {
	//================ Constructor function starts================//
	public function __construct() {
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> model('Filter_model');
		//$this-> load-> helper('my_functions_helper');
		//$this-> load-> helper('epi_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	//================ Constructor function ends==================//
	//================ sanctioned_posts_report function starts======================//
	public function sanctioned_posts_report($neWc){
		// $UserLevel=$_SESSION['UserLevel'];
		// $datArray['UserLevel']= $UserLevel;

		$query = "SELECT distcode, district from districts " . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '') . " order by distcode";
		$resultDist = $this -> db -> query($query);
		//(case when btch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(btch.non_ccm_id) end)
		//if(san.epi_coordinator is null)
		//////////////////////////////////Monthly Query////////////////////////////////////
		$monthlyPortion = " (select COALESCE(san.epi_coordinator,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS \"sanctionedEC\",
							(select COALESCE(san.epi_coordinator_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS  \"filledEC\",
							
							(select COALESCE(san.dso,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedSO\",
							(select COALESCE(san.dso_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledSO\",
							
							(select COALESCE(san.dsv,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS \"sanctionedDS\",
							(select COALESCE(san.dsv_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS  \"filledDS\",
							
							(select COALESCE(san.tsv,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS \"sanctionedTS\",
							(select COALESCE(san.tsv_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS  \"filledTS\",
							
							(select COALESCE(san.asv,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS \"sanctionedAS\",
							(select COALESCE(san.asv_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode ) AS  \"filledAS\",
							
							(select COALESCE(san.computer_operator,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedCO\",
							(select COALESCE(san.computer_operator_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledCO\",
							
							(select COALESCE(san.hf_incharge,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedHF\",
							(select COALESCE(san.hf_incharge_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledHF\",
							
							(select COALESCE(san.epi_tech,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedET\",
							(select COALESCE(san.epi_tech_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledET\",
							
							(select COALESCE(san.cc_technician,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedCT\",
							(select COALESCE(san.cc_technician_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledCT\",
							
							(select COALESCE(san.cc_operator,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedOP\",
							(select COALESCE(san.cc_operator_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledOP\",
							
							(select COALESCE(san.cc_mechanic,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedMC\",
							(select COALESCE(san.cc_mechanic_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledMC\",
							
							(select COALESCE(san.cc_generator,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedCG\",
							(select COALESCE(san.cc_generator_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledCG\",
							
							(select COALESCE(san.store_keeper,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedSK\",
							(select COALESCE(san.store_keeper_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledSK\",
							
							(select COALESCE(san.driver,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS \"sanctionedDR\",
							(select COALESCE(san.driver_fill,0) from sanctioned_posts_db san where san.distcode = districts.distcode) AS  \"filledDR\" 
		";
		//////////////////////////////////Outer Portion Query////////////////////////////////////
		$outerPortion  = "
						\"sanctionedEC\",\"filledEC\", \"sanctionedEC\" - \"filledEC\" as \"vaccantEC\",
						\"sanctionedSO\",\"filledSO\", \"sanctionedSO\" - \"filledSO\" as \"vaccantSO\",
						\"sanctionedDS\",\"filledDS\", \"sanctionedDS\" - \"filledDS\" as \"vaccantDS\",
						\"sanctionedTS\",\"filledTS\", \"sanctionedTS\" - \"filledTS\" as \"vaccantTS\",
						\"sanctionedAS\",\"filledAS\", \"sanctionedAS\" - \"filledAS\" as \"vaccantAS\",
						\"sanctionedCO\",\"filledCO\", \"sanctionedCO\" - \"filledCO\" as \"vaccantCO\",
						\"sanctionedHF\",\"filledHF\", \"sanctionedHF\" - \"filledHF\" as \"vaccantHF\",
						\"sanctionedET\",\"filledET\", \"sanctionedET\" - \"filledET\" as \"vaccantET\",
						\"sanctionedCT\",\"filledCT\", \"sanctionedCT\" - \"filledCT\" as \"vaccantCT\",
						\"sanctionedOP\",\"filledOP\", \"sanctionedOP\" - \"filledOP\" as \"vaccantOP\",
						\"sanctionedMC\",\"filledMC\", \"sanctionedMC\" - \"filledMC\" as \"vaccantMC\",
						\"sanctionedCG\",\"filledCG\", \"sanctionedCG\" - \"filledCG\" as \"vaccantCG\",
						\"sanctionedSK\",\"filledSK\", \"sanctionedSK\" - \"filledSK\" as \"vaccantSK\",
						\"sanctionedDR\",\"filledDR\", \"sanctionedDR\" - \"filledDR\" as \"vaccantDR\",
						\"sanctionedEC\"+\"sanctionedSO\"+\"sanctionedDS\"+\"sanctionedTS\"+\"sanctionedAS\"+\"sanctionedCO\"+\"sanctionedHF\"+\"sanctionedET\"+\"sanctionedCT\"+\"sanctionedOP\"+\"sanctionedMC\"+\"sanctionedCG\"+\"sanctionedSK\"+\"sanctionedDR\" as \"total Sanctioned\",
						\"filledEC\"+\"filledSO\"+\"filledDS\"+\"filledTS\"+\"filledAS\"+\"filledCO\"+\"filledHF\"+\"filledET\"+\"sanctionedCT\"+\"sanctionedOP\"+\"sanctionedMC\"+\"sanctionedCG\"+\"filledSK\"+\"filledDR\" as \"total Filled\",		
						(\"sanctionedEC\" - \"filledEC\")+(\"sanctionedSO\" - \"filledSO\")+(\"sanctionedDS\" - \"filledDS\")+(\"sanctionedTS\" - \"filledTS\")+(\"sanctionedAS\" - \"filledAS\")+(\"sanctionedCO\" - \"filledCO\")+(\"sanctionedHF\" - \"filledHF\")+(\"sanctionedET\" - \"filledET\")+(\"sanctionedCT\" - \"filledCT\")+(\"sanctionedOP\" - \"filledOP\")+(\"sanctionedMC\" - \"filledMC\")+(\"sanctionedCG\" - \"filledCG\")+(\"sanctionedSK\" - \"filledSK\")+(\"sanctionedDR\" - \"filledDR\") as \"total Vaccant\" 
		";
		//////////////////////////////////All Outer Portion Query//////////////////////////////////		
		$allouterPortion = "
						sum(\"sanctionedEC\") as \"total sanctionedEC\",sum(\"filledEC\") as \"total filledEC\", sum(\"vaccantEC\") as \"total vaccantEC\",
						sum(\"sanctionedSO\") as \"total sanctionedSO\",sum(\"filledSO\") as \"total filledSO\", sum(\"vaccantSO\") as \"total vaccantSO\",
						sum(\"sanctionedDS\") as \"total sanctionedDS\",sum(\"filledDS\") as \"total filledDS\", sum(\"vaccantDS\") as \"total vaccantDS\",
						sum(\"sanctionedTS\") as \"total sanctionedTS\",sum(\"filledTS\") as \"total filledTS\", sum(\"vaccantTS\") as \"total vaccantTS\",
						sum(\"sanctionedAS\") as \"total sanctionedAS\",sum(\"filledAS\") as \"total filledAS\", sum(\"vaccantAS\") as \"total vaccantAS\",
						sum(\"sanctionedCO\") as \"total sanctionedCO\",sum(\"filledCO\") as \"total filledCO\", sum(\"vaccantCO\") as \"total vaccantCO\",
						sum(\"sanctionedHF\") as \"total sanctionedHF\",sum(\"filledHF\") as \"total filledHF\", sum(\"vaccantHF\") as \"total vaccantHF\",
						sum(\"sanctionedET\") as \"total sanctionedET\",sum(\"filledET\") as \"total filledET\", sum(\"vaccantET\") as \"total vaccantET\",
						
						sum(\"sanctionedCT\") as \"total sanctionedCT\",sum(\"filledCT\") as \"total filledCT\", sum(\"vaccantCT\") as \"total vaccantCT\",
						sum(\"sanctionedOP\") as \"total sanctionedOP\",sum(\"filledOP\") as \"total filledOP\", sum(\"vaccantOP\") as \"total vaccantOP\",
						sum(\"sanctionedMC\") as \"total sanctionedMC\",sum(\"filledMC\") as \"total filledMC\", sum(\"vaccantMC\") as \"total vaccantMC\",
						sum(\"sanctionedCG\") as \"total sanctionedCG\",sum(\"filledCG\") as \"total filledCG\", sum(\"vaccantCG\") as \"total vaccantCG\",
						
						sum(\"sanctionedSK\") as \"total sanctionedSK\",sum(\"filledSK\") as \"total filledSK\", sum(\"vaccantSK\") as \"total vaccantSK\",
						sum(\"sanctionedDR\") as \"total sanctionedDR\",sum(\"filledDR\") as \"total filledDR\", sum(\"vaccantDR\") as \"total vaccantDR\",
						sum(\"total Sanctioned\") as \"total Sanctioned\",sum(\"total Filled\") as \"total Filled\", sum(\"total Vaccant\") as \"total Vaccant\"						
		";
		////////////////////////////////Query to get Results///////////////////////////////////////
		$query = 'SELECT distcode, district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : ''). " order by district";
		$query = 'SELECT distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
		$result = $this-> db-> query($query);
		$data['allData'] = $result-> result_array();
		//for vertical total of all rows.
		$queryForTotal = 'SELECT ' . $allouterPortion . ' from (' . $query . ') as b';
		$resultTotal = $this-> db-> query($queryForTotal);
		$data['allDataTotal']= $resultTotal-> result_array();
		$data['report_table'] = getReportTable($data['allData'],$data['allDataTotal'],NULL,NULL,array('EPI Coordinator','DSO','DSV','TSV','ASV','Computer Operator','HF Incharge','EPI Technician','Cold Chain Technician','Cold Chain Operator','Cold Chain Mechanic','Generator Operator','Store Keeper','Drivers','Total'));
		$subTitle = "Sanctioned Posts Report";
		$data['subtitle'] = $subTitle;
		$data['exportIcons'] = exportIcons($_REQUEST);
		$data['TopInfo'] = tableTopInfo($subTitle);
		if (empty($data['allData'])) {
   $data='0';
   return $data;
  }else{
   return $data;
  }
	}	
}
//class Sanctionedposts_report_model ends