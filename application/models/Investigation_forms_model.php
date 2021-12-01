<?php
class Investigation_forms_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		//$this -> load -> model('Widgetfunctions_model');
		$this -> load -> library('breadcrumbs');
	}
	//============================ Constructor Function Ends ============================//

	public function nnt_investigation(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('NNT Investigation List', '/NNT-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
		return $data;
	}
	
	public function nnt_investigation_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('NNT Investigation List', '/NNT-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="SELECT facode, fac_name from facilities where $wc order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="SELECT uncode, un_name from unioncouncil where $wc order by un_name";
		$resultUc=$this -> db -> query($query);
		$data['resultUc'] = $resultUc -> result_array();
		
		$query="SELECT distinct year from nnt_investigation_form where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="SELECT distinct week from nnt_investigation_form where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();
		
		$query="SELECT DISTINCT investigated_by from nnt_investigation_form where $wc order by investigated_by";
		$resultInvest_by=$this -> db -> query($query);
		$data['resultInvest_by'] = $resultInvest_by -> result_array();
		
        $query="SELECT id, cross_notified, approval_status, investigated_by, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, date_investigation, fweek, full_mother_name,is_temp_saved, date_notification from nnt_investigation_form where $wc OR cross_notified_from_distcode='". $this -> session -> District ."' order by fweek desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		//print_r($query);exit;
		// $query="select id,cross_notified,approval_status,cross_notified_from_distcode,distcode,tehsilname(tcode) as tehsil,facode,patient_name,is_temp_saved,fweek, case_epi_no, facilityname(facode) as fac_name, pvh_date from nnt_investigation_form where $wc OR cross_notified_from_distcode='". $this -> session -> District ."' order by id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
  		// $result=$this -> db -> query ($query);
		// $data['result'] = $result -> result_array();
		return $data;
	}
	
	public function aefi_investigation(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('AEFI Investigation List', '/Investigation_forms/aefi_investigation_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
		return $data;
	}

	public function aefi_investigation_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('AEFI Investigation List', '/Investigation_forms/aefi_investigation_list');  
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();

	    $query="select id, child_name, case_epi_no, date_investigation_started, is_temp_saved,vaccinated_by from aefi_case_investigation_form where $wc and date_reported <> '1969-12-3' order by id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
	    $result=$this -> db -> query ($query);
	    $data['result'] = $result -> result_array();
		return $data;
	}

	public function measles_case_investigation(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Measles Case Investigation List', '/Measles-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this->session->District;
		
		$query="Select distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
	
		return $data;
	}
	public function measles_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Measles Case Investigation List', '/Measles-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//print_r($wc);exit;
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="Select distinct year from measle_case_investigation where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="Select distinct week from measle_case_investigation where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();

        $query="select id,cross_notified,approval_status,cross_notified_from_distcode,distcode,tehsilname(tcode) as tehsil,facode,patient_name,is_temp_saved,fweek, case_epi_no, facilityname(facode) as fac_name, pvh_date from measle_case_investigation where $wc OR cross_notified_from_distcode='". $this -> session -> District ."' order by id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}	
	////////////////////////////////////////////////////AFP///////////////////////////////////////////
	public function afp_investigation(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('AFP Investigation List', '/AFP-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
				
		return $data;
	}
	public function afp_list($per_page,$startpoint){

		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('AFP Case Investigation List', '/AFP-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//print_r($wc);exit;
		$query="SELECT facode, fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();

		$query="SELECT distinct year from afp_case_investigation where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array(); 
		
		$query="SELECT distinct week from afp_case_investigation where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();
		
        $query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, patient_name, year, fweek, is_temp_saved, case_epi_no from afp_case_investigation where $wc OR (cross_notified_from_distcode ='". $this -> session -> District ."' OR rb_distcode='". $this -> session -> District ."') order by id desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		//print_r($query);exit;
		$result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		//print_r($data['result']);exit;
		return $data;

	}
	///////////////////////////////////Zero Reporting Form//////////////////////////////////////////////
	public function zero_reporting(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Zero Reporting Form', '/NNT-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="SELECT distcode, district from districts where distcode='$dist'";
		$resultUnc=$this -> db -> query($query);
		$data['resultdist'] = $resultUnc -> row_array();
		
		$query="SELECT facode, fac_name from facilities where $wc and hf_type='e' and is_ds_fac='1' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		return $data;
	}
	/////////////////////////////////////Zero Reporting List///////////////////////////////////////////
	public function zero_reporting_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Zero Reporting List', '/NNT-CIF/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="SELECT facode, fac_name from facilities where $wc order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="SELECT distinct year from zero_report where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="SELECT distinct week::int from zero_report where $wc order by week::int DESC";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();
		$query="SELECT group_id, year, week, datefrom, dateto, fweek, distcode, districtname(distcode) as districtname from zero_report where $wc GROUP BY group_id, year, week, datefrom, dateto, fweek, distcode, districtname(distcode) order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        //echo $query;exit;
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