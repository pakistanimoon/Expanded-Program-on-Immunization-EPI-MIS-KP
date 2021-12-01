<?php
class Ajax_cross_notified_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> helper('epi_functions_helper');
	}
	public function getFacilities() {
		$module = isset($_REQUEST['module']) ? $_REQUEST['module'] : "all";
		$fmonth = isset($_REQUEST['fmonth']) ? $_REQUEST['fmonth'] : date('Y-m');
		$sub_module = isset($_REQUEST['sub_module']) ? $_REQUEST['sub_module'] : date('Y-m');
		$wc = "";
		switch ($module) {
			case 'disease_surveillance':
				$wc = " hf_type='e' and is_ds_fac='1'";
				break;
			case 'vaccine':
				if($sub_module == 'Consumption')
				{
					$fmonth = date('Y-m', strtotime($fmonth.'first day of previous month'));
				}
				$wc = " hf_type='e' and getfstatus_vacc('$fmonth',facode::text)='F'";
				break;
			default:
				$wc = " hf_type='e'";
				break;
		}
		$query = "SELECT * from facilities where $wc ";
		if (isset($_REQUEST['distcode'])) {
			$distcode = $_REQUEST['distcode'];
			$query = "SELECT facode,fac_name from facilities where distcode = '$distcode' and $wc order by fac_name ASC";
		}
		if (isset($_REQUEST['tcode'])) {
			$tcode = $_REQUEST['tcode'];
			$query = "SELECT facode,fac_name from facilities where tcode = '$tcode' and $wc order by fac_name ASC";
		}
		if (isset($_REQUEST['uncode'])) {
			$uncode = $_REQUEST['uncode'];
			$query = "SELECT facode,fac_name from facilities where uncode = '$uncode' and $wc order by fac_name ASC";
		}
		
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="0">--Select--</option>';//<option value="">--Select Facility--</option>
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['fac_name'] . '</option>';
		}
		return $data;
	}
	public function generateCode($uncode) {
		if ($uncode > 0) {
			//$query = "Select max(vcode) as vcd from villages WHERE uncode like '$uncode%'";
			$query = "SELECT max(vcode) as vcd from villages WHERE uncode='$uncode'";
			$result = $this-> db-> query($query);
			$record = $result-> row_array();
			$max_vcode = $record['vcd'];
			if($max_vcode > 0) {
				$dict = $result -> row_array();
				$newCode = $dict['vcd'] + 1;
				$newCode2 = substr($newCode, 0, 12);
				if ($newCode2 != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			}
			else{
				echo $uncode.'001';
			}
		}
	}
	public function getFacTehsils() {
		$tcode = $this -> input -> post('tcode');
		$distcode = $this -> input -> post('distcode');
		$facode = $this -> input -> post('facode');
		$query = "SELECT * from facilities where  hf_type='e' ";
		if ($tcode && $tcode != "0") {
			$query = "SELECT * from facilities where tcode = '$tcode' and hf_type='e' ";
		}
		if ($distcode && $distcode != "0") {
			$query = "SELECT * from facilities where distcode = '$distcode' and hf_type='e' ";
		}
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""> </option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['fac_name'] . '</option>';
		}
		return $data;
	}
	public function getUnC($tcode) {
		$query = "SELECT uncode,un_name from unioncouncil where tcode = '$tcode' order by un_name ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $unc_data) {
			$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['un_name'] . '</option>';
		}
		return $data;
	}
	public function getFacilitiesforForm2($year) {
		$distcode = $_SESSION['District'];
		$query = "SELECT distinct facode, facilityname(facode) as facility from situation_analysis_db where distcode = '$distcode' and year = '$year'";		
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""></option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['facility'] . '</option>';
		}
		return $data;
	}	
	public function getFacility_RecordForm2($year,$facode){
		$query="SELECT area_name, category, priority, tcode as tcode, tehsilname(tcode) as th_name, uncode as uncode, unname(uncode) as uc_name FROM situation_analysis_db where year = '$year' and facode = '$facode' order by priority ASC";
		$resultAR=$this-> db-> query($query);
		$resultFLCF = $resultAR-> result_array();
		return json_encode($resultFLCF,true);
	}
	public function getFacilitiesforForm3($year) {
		$distcode = $_SESSION['District'];
		$query = "SELECT distinct facode, facilityname(facode) as facility from special_activities_db where distcode = '$distcode' and year = '$year'";		
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""></option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['facility'] . '</option>';
		}
		return $data;
	}
	public function getFacility_RecordForm3($year,$facode){
		$query="SELECT area_name, hard_to_reach,tcode as tcode, tehsilname(tcode) as th_name, uncode as uncode, unname(uncode) as uc_name FROM special_activities_db where year = '$year' and facode = '$facode' order by facode ASC";
		$resultAR=$this-> db-> query($query);
		$resultFLCF = $resultAR-> result_array();
		return json_encode($resultFLCF,true);
	}	
	
	public function getHFOpeningBal($month,$year,$facode){
		$datestring=$year.'-'.$month.'-13 first day of last month';
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
		//for column names
		$selectCols ="";
		for($i=1;$i<17;$i++)
		{
			$selectCols .= "cr_r".$i."_f6,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from form_b_cr where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		for($i=1;$i<17;$i++)
		{
			$key = "cr_r".$i."_f6";
			$toEncode[$key] = $result[$key];
		}
		return json_encode($toEncode);
	}
	
	public function getHFRepOpeningBal($month,$year,$facode){
		$datestring=$year.'-'.$month.'-13 first day of last month';
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
		//for column names
		$selectCols ="";
		for($i=1;$i<17;$i++)
		{
			$selectCols .= "cr_r".$i."_f9,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from form_b_cr where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		for($i=1;$i<17;$i++)
		{
			$key = "cr_r".$i."_f9";
			$toEncode[$key] = $result[$key];
		}
		return json_encode($toEncode);
	}
	//------- Form A2 Filter ------------------------------------------------//
	
	public function getcase_definition($case_type) {
		$query = "select id from surveillance_cases_types where short_name='$case_type'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$id=$result['id'];
		$query = "select id,case_type_definition from case_clinical_representation where case_type_id=$id";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//$data = '<option value="">--Select--</option>';//
		$data='';
		foreach ($result as $value) {
			$data .= '<option value="' . $value['id'] . '">' . $value['case_type_definition'] . '</option>';
		}
		return $data;
	}
	public function getMeasleNumber($year, $epid_code) { 
		$query = "select max(measles_number) as measles_number from measle_case_investigation where dcode='$epid_code' AND epid_year='$year'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$Measle = str_split(sprintf('%04u', ($result['measles_number'] + 1))); 
		return json_encode($Measle);
	}
	public function validateMeasleNumber($measleNumber) {
		$query = "select case_epi_no from measle_case_investigation where case_epi_no='$measleNumber'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$numberExist = $result['case_epi_no'];
		if ($numberExist == $measleNumber) { 
			return "1";
		}else{
			return "Correct";
		}
	}
	public function getCaseCode($short_name) { 
		$query = "SELECT short_name from surveillance_cases_types where short_name='$short_name'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$shortName = $result['short_name'];
		echo $shortName;
	}
	public function generateEPI_case_code($distcode,$case_type,$year) { 
		$query = "SELECT max(case_number) AS case_number FROM case_investigation_db WHERE case_type='$case_type' AND year='$year' AND distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$caseNum = str_split(sprintf('%04u', ($result['case_number'] + 1))); 
		return json_encode($caseNum);
	}	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function getOtherProvinceDistricts($procode) {
		$query = "SELECT distcode, district from otherprovincedistricts where procode = '$procode' order by district ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $dist_data) {
			$data .= '<option value="' . $dist_data['distcode'] . '">' . $dist_data['district'] . '</option>';
		}
		return $data;
	}
	public function FetchDistrictsToOtherRegions($procode) {
		$query = "SELECT distcode, district from districts where province = '$procode' order by district ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $dist_data) {
			$data .= '<option value="' . $dist_data['distcode'] . '">' . $dist_data['district'] . '</option>';
		}
		return $data;
	}
	public function FetchTehsilsToOtherRegions($distcode) {
		$query = "SELECT tcode, tehsil from tehsil where distcode = '$distcode' order by tehsil ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $teh_data) {
			$data .= '<option value="' . $teh_data['tcode'] . '">' . $teh_data['tehsil'] . '</option>';
		}
		return $data;
	}
	public function FetchUCsToOtherRegions($tcode) {
		$query = "SELECT uncode, un_name from unioncouncil where tcode = '$tcode' order by un_name ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $unc_data) {
			$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['un_name'] . '</option>';
		}
		return $data;
	}
	public function getLinked_EpidNumber($distcode,$year){
		$query = "SELECT case_epi_no from case_investigation_db where distcode = '$distcode' and case_type='Msl' order by year desc, case_number asc";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		//$result = $result-> row_array();
		return $result;
		//return json_encode($result);
	}
	public function getLinked_CaseInformation($linked_epid_number) {
		$distcode = $this-> session-> District;
		$query = "SELECT case_epi_no, patient_name, patient_fathername, case when patient_gender = '1' then 'Male' else 'Female' end as patient_gender, specimen_result, fweek, contact_numb, CONCAT(districtname(patient_address_distcode),' / ', tehsilname(patient_address_tcode), ' / ', unname(patient_address_uncode)) as uc, patient_address from case_investigation_db where lower(case_epi_no) = lower('$linked_epid_number') and case_type='Msl' and distcode = '$distcode' ";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		return $data['row'];		
	}
}
?>