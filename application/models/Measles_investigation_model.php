<?php
class Measles_investigation_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		//echo 'moon';exit;
		$this -> load -> model('Common_model');
		//$this -> load -> model('Widgetfunctions_model');
		$this -> load -> library('breadcrumbs');
	}
	//============================ Constructor Function Ends ============================//	

	public function measles_investigation(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Measles Investigation List', '/Measles_investigation/measles_investigation_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this->session->District;
		
		$query="SELECT distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
	
		return $data;
	}	
	public function measles_investigation_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Measles Investigation List', '/Measles_investigation/measles_investigation_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$pro_code = $_SESSION["Province"];
		//echo $pro_code;exit();
		//print_r($wc);exit;
		$query="SELECT distinct cross_notified_from_distcode, districtname(cross_notified_from_distcode) as cross_notified_from_distname from case_investigation_db where $wc and (cross_notified_from_distcode != '0' and cross_notified_from_distcode != '') order by cross_notified_from_distname";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		//print_r($data['resultDist']);exit();

		$query="SELECT facode, fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();

		$query="SELECT distinct year from case_investigation_db where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();

		$query="SELECT distinct week from case_investigation_db where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();

		$query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, other_pro_district, facilityname(facode) as fac_name, tehsilname(tcode) as tehsil, patient_name, is_temp_saved, fweek, year, case_number, case_epi_no, pvh_date from case_investigation_db where case_type = 'Msl' AND (distcode='". $this -> session -> District ."' OR cross_notified_from_distcode='". $this -> session -> District ."' OR rb_distcode='". $this -> session -> District ."') order by id desc, year desc, case_number desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		//exit();
		$result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}	
	
	public function checkForExcessiveReocord($facode,$disease,$fweek){
		if($disease=='malaria')
		{
			$table='measle_case_investigation';
			$column='measle_cases';
		}
		else if($disease=='nnt'){
			$table='nnt_investigation_form';
			$column='nnt_cases';
		}
		else if($disease == 'afp'){
			$table='afp_case_investigation';
			$column='afp_cases';
		}else{
			/* $diseaseArray = array(
				'ILI' => '',
				'SARI' => '',
				'AWD' => '',
				'DF' => '',
				'DHF' => '',
				'CCHF' => '',
				'Childhood TB' => '',
				'Diarrhea' => '',
				'Diphtheria' => '',
				'Hepatitis' => '',
				'Meningitis' => '',
				'Pertussis' => '',
				'Pneumonia' => 'pneumonia_great_five_cases',
				'Poliomyelitis' => '',
				'NT' => 'nnt_cases',
			);
			$column = $diseaseArray[$disease]; */
		}
		$district = $this -> session -> District;
		$tableCount = "SELECT count(*) from $table where (facode='$facode' OR rb_facode='$facode') AND (distcode='$district' OR rb_distcode='$district') AND fweek='$fweek'";
		$tableCountQuery=$this->db->query($tableCount)->row_array();
		$noOfRecordsInTable = $tableCountQuery['count'];
		
		$zeroReportCount = "SELECT $column as count from zero_report where report_submitted=1 and distcode='$district' and facode='$facode' and fweek='$fweek'";
		$zeroReportCountQuery=$this->db->query($zeroReportCount)->row_array();
		$noOfRecordsInZeroReport = $zeroReportCountQuery['count'];
		
		if($noOfRecordsInTable < $noOfRecordsInZeroReport)
			return 0;
		else
			return 1;
	}

}
?>