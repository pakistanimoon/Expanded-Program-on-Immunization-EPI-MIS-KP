<?php
class Ajax_red_rec_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
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
	public function searchParam($facode, $distcode, $fmonth, $fatype, $searchParam){
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "flcf_vacc_mr." . $value;
		});
		if (is_numeric($searchParam)) { 
			$wc[] ="flcf_vacc_mr.facode LIKE '%$searchParam%'";
		}else{
		$searchParam=ucwords($searchParam);
		$wc[] =" facilityname(flcf_vacc_mr.facode) LIKE '%$searchParam%'";
	    }
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "flcf_vacc_mr,facilities ";
		// Change `records` according to your table name.
		$query="select facilities.fatype as facilitytype, flcf_vacc_mr.facode, flcf_vacc_mr.vacc_name,flcf_vacc_mr.uncode, facilityname(flcf_vacc_mr.facode) as facilityname, fmonth from flcf_vacc_mr,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = flcf_vacc_mr.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>		   
							<td class="text-center">' . $row['facilityname'] . '</td>
							<td class="text-center">' . $row['facilitytype'] . '</td>
							<td class="text-center">' . $row['facode'] . '</td>
							<td class="text-center">' . $row['vacc_name'] . '</td>
							<td class="text-center">' . get_UC_Name($row['uncode']) . '</td>
							<td class="text-center">' . $row['fmonth'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'HFMVRF/View/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'HFMVRF/Edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$w=implode(" AND ", $wc)." AND  facilities.facode = flcf_vacc_mr.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}	

	public function form_a2_filter($facode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_a2_vaccine_main ";
		if($facode > 0){
			$wc = " where facode = '$facode' ";
		}else{
			$wc = " ";
		}
		// Change `records` according to your table name.
		$query="select id,distcode,districtname(distcode) as dist_name,is_temp_saved,facode, facilityname(facode) as fac_name, form_date from form_a2_vaccine_main $wc order by form_date desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-left">' . $row['dist_name'] . '</td>
		    <td class="text-left">' . $row['fac_name'] . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['form_date'])) . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'District-Issue-Receipt/View/' . $row['facode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'District-Issue-Receipt/Edit/' . $row['facode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		    </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//-----------------------------------NNT LINE LIST FILTER----------------------------------------//
	public function nnt_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "nnt_cases_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,reported_from  from nnt_cases_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['uncode'] . '</td>
		    <td class="text-center">' . $row['uc'] . '</td>
		    <td class="text-center">' . $row['tehsil'] . '</td>
		    <td class="text-center">' . $row['case_epi_no'] . '</td>
		    <td class="text-center">' . $row['reported_from'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/nnt_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/nnt_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//-----------------------------------------------------------------------------------------------//
	//--------------------- Situation Analysis Filter -----------------------------------------------//
	public function situation_analysis_filter($tcode,$facode,$uncode,$year) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "situation_analysis_db";
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($uncode != ''){
			$wc[] = " uncode = '$uncode' ";
		}
		if($year > 0){
			$wc[] = " year = '$year' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($query);exit;
		$query="SELECT tcode,uncode,facode,techniciancode,year, tehsilname(tcode) as tehsil, unname(uncode) as unioncouncil, facilityname(facode) as facility, (case when (year ='2019' OR year ='2018')  then technicianname(techniciancode) else hr_name(techniciancode) end) as technician, year from situation_analysis_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " group by techniciancode,tcode,uncode,facode,year order by year DESC, facode ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//$query="SELECT tcode,uncode,facode,techniciancode,year, tehsilname(tcode) as tehsil, unname(uncode) as unioncouncil, facilityname(facode) as facility, technicianname(techniciancode) as technician, year from situation_analysis_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode, priority ASC LIMIT {$per_page} OFFSET {$startpoint}";
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td class="text-left">' . $row['tehsil'] . '</td>			
							<td class="text-center">' . $row['unioncouncil'] . '</td>
							<td class="text-center">' . $row['facility'] . '</td>
							<td class="text-center">' . $row['technician'] . '</td>
							<td class="text-left">' . $row['year'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'red_rec_microplan/Situation_analysis/situation_analysis_view/' . $row['techniciancode'] . '/'. $row['year'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
								if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
									$tbody .= '<a href="' . base_url() . 'red_rec_microplan/Situation_analysis/situation_analysis_edit/' . $row['techniciancode'] .'/'. $row['year'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
								}
							$tbody .= '</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- Situation Analysis Filter End -----------------------------//
	public function special_activities_filter($tcode,$facode,$area_name,$year) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "special_activities_db";
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($facode != ''){
			$wc[] = " facode = '$facode' ";
		}
		if($area_name != ''){
			$wc[] = " area_name = '$area_name' ";
		}
		if($year > 0){
			$wc[] = " year = '$year' ";
		}

		//print_r($query);exit;
		$query="SELECT area_name, category, hard_to_reach, reached_last_year, year, tcode, facode, facilityname(facode) as facility, tehsilname(tcode) as tehsil from special_activities_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td class="text-left">' . $row['area_name'] . '</td>			
							<td class="text-center">' . $row['category'] . '</td>
							<td class="text-center">' . $row['hard_to_reach'] . '</td>
							<td class="text-center">' . $row['reached_last_year'] . '</td>
							<td class="text-center">' . $row['year'] . '</td>
							<td class="text-left">' . $row['tehsil'] . '</td>
							<td class="text-left">' . $row['facility'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'red_rec_microplan/Special_activities/special_activities_view/' . $row['facode'] . '/'. $row['year'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'red_rec_microplan/Special_activities/special_activities_edit/' . $row['facode'] .'/'. $row['year'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- Special Activities Filter End -----------------------------//
	public function session_plan_filter($tcode,$facode,$area_name,$year) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "session_plan_db";
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($facode != ''){
			$wc[] = " facode = '$facode' ";
		}
		if($area_name != ''){
			$wc[] = " area_name = '$area_name' ";
		}
		if($year > 0){
			$wc[] = " year = '$year' ";
		}

		//print_r($query);exit;
		$query="SELECT area_name, total_population, target_population, session_type, hard_to_reach, hard_to_reach_population, year, tcode, facode, facilityname(facode) as facility, tehsilname(tcode) as tehsil from session_plan_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td class="text-left">' . $row['area_name'] . '</td>			
							<td class="text-center">' . $row['total_population'] . '</td>
							<td class="text-center">' . $row['target_population'] . '</td>
							<td class="text-center">' . $row['session_type'] . '</td>
							<td class="text-center">' . $row['hard_to_reach'] . '</td>
							<td class="text-center">' . $row['hard_to_reach_population'] . '</td>
							<td class="text-center">' . $row['year'] . '</td>
							<td class="text-left">' . $row['tehsil'] . '</td>
							<td class="text-left">' . $row['facility'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'red_rec_microplan/Session_plan/session_plan_view/' . $row['facode'] . '/'. $row['year'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'red_rec_microplan/Session_plan/session_plan_edit/' . $row['facode'] .'/'. $row['year'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- Session Plan Filter End -----------------------------//
	public function red_strategy_filter($tcode, $uncode, $facode, $year) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "red_strategy_db";
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode != ''){
			$wc[] = " uncode = '$uncode' ";
		}
		if($facode != ''){
			$wc[] = " facode = '$facode' ";
		}		
		if($year > 0){
			$wc[] = " year = '$year' ";
		}

		//print_r($query);exit;
		$query="SELECT tcode, uncode, facode, facilityname(facode) as facility, unname(uncode) as uc_name, tehsilname(tcode) as tehsil, submitted_date, year from red_strategy_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td>' . $row['facility'] . '</td>			
							<td class="text-center">' . $row['facode'] . '</td>
							<td>' . $row['uc_name'] . '</td>
							<td>' . $row['tehsil'] . '</td>
							<td class="text-center">' . date('d-m-Y', strtotime($row['submitted_date'])) . '</td>
							<td class="text-center">' . $row['year'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'red_rec_microplan/Red_strategy/red_strategy_view/' . $row['facode'] . '/'. $row['year'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'red_rec_microplan/Red_strategy/red_strategy_edit/' . $row['facode'] .'/'. $row['year'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- Red Strategy Filter End -----------------------------//
	public function hf_quarterplan_filter($tcode, $uncode, $facode, $year, $quarter) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "red_strategy_db";
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode != ''){
			$wc[] = " uncode = '$uncode' ";
		}
		if($facode != ''){
			$wc[] = " facode = '$facode' ";
		}		
		if($year > 0){
			$wc[] = " year = '$year' ";
		}
		if($quarter > 0){
			$wc[] = " quarter = '$quarter' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($query);exit;
		$query="SELECT tcode, uncode, facode, facilityname(facode) as facility,(case when (year ='2019' OR year ='2018')  then technicianname(techniciancode) else hr_name(techniciancode) end) as technician,techniciancode, unname(uncode) as uc_name, tehsilname(tcode) as tehsil, submitted_date, year, quarter from hf_quarterplan_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td>' . $row['facility'] . '</td>			
							<td class="text-center">' . $row['technician'] . '</td>
							<td>' . $row['uc_name'] . '</td>
							<td>' . $row['tehsil'] . '</td>
							<td class="text-center">' . date('d-m-Y', strtotime($row['submitted_date'])) . '</td>
							<td class="text-center">' . $row['year'] . '</td>
							<td class="text-center">' . $row['quarter'] . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'red_rec_microplan/Facility_quarterplan/hf_quarterplan_view/' . $row['facode'] . '/'. $row['year'].'/'. $row['quarter'].'/'. $row['techniciancode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
								if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
									$tbody .= '<a href="' . base_url() . 'red_rec_microplan/Facility_quarterplan/hf_quarterplan_edit/' . $row['facode'] .'/'. $row['year'].'/'. $row['quarter'].'/'. $row['techniciancode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
								}
							$tbody .= '</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- HF Quarterplan Filter End -----------------------------//
	
	//--------------- supervisory_plan Filter start -----------------------------//
	public function superviosry_plan_filter($supervisor_type, $quarter) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];		
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "supervisory_plan";
		$distcode = $this -> session -> District;
		if($supervisor_type != ''){
			$wc[] = " designation = '$supervisor_type' and distcode='$distcode' ";
		}else{
			$wc[] = "distcode='$distcode' ";
		}
		if($quarter != ''){
			$wc[] = " quarter = '$quarter' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($query);exit;
		$query="SELECT supervisorcode,designation,quarter,status,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "group by supervisorcode,quarter,designation,status order by supervisorcode asc   LIMIT {$per_page} OFFSET {$startpoint}";
		//$str = $this->db->last_query();
		//print_r($str); exit;
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td>' . get_supervisor_Name($row['supervisorcode']) . '</td>			
							<td class="text-center">' . $row['designation'] . '</td>
							<td>' . $row['case'] . '</td>
							
							<td class="text-center">';
									
							  if($row['status'] == 1) { 
									$tbody .='
										<a href="'.base_url().'micro_plan/Micro_plan_controller/supervisory_plan_view/' . $row['supervisorcode'] . '/'. $row['quarter'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'; 
										if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
											$tbody .='<a href="'.base_url().'micro_plan/Micro_plan_controller/supervisory_plan_conducted/' . $row['supervisorcode'] . '/'. $row['quarter'].'" data-toggle="tooltip" title="Conducted" class="btn btn-xs btn-default"><i class="fa fa-calendar-check-o" aria-hidden="true" style="background:#057140; font-size:20px; color:white;"></i></a>';
										}
									 } else {  
									$tbody .='   <a href="'.base_url().'micro_plan/Micro_plan_controller/supervisory_plan_view/' . $row['supervisorcode'] . '/'. $row['quarter'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
										if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
											$tbody .='<a href="'.base_url().'micro_plan/Micro_plan_controller/supervisory_plan_edit/' . $row['supervisorcode'] . '/'. $row['quarter'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
											<a href="'.base_url().'micro_plan/Micro_plan_controller/supervisory_plan_conducted/' . $row['supervisorcode'] . '/'. $row['quarter'].'" data-toggle="tooltip" title="Conducted" class="btn btn-xs btn-default"><i class="fa fa-calendar-check-o" aria-hidden="true" style="background:#057140; font-size:20px; color:white;"></i></a>';
								     } } 
                            $tbody .= '</td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//--------------- supervisory_plan Filter End -----------------------------//

	public function getFacilitiesTHS() {
		$tcode = $this-> input-> post('tcode');
		$distcode = $this-> input-> post('distcode');
		$facode = $this-> input-> post('facode');
		$query = "SELECT distinct facode, facilityname(facode) as fac_name from situation_analysis_db";
		if ($tcode && $tcode != "0") {
			//$query = "SELECT * from facilities where tcode = '$tcode' and hf_type='e' order by facode ASC";
			$query = "SELECT distinct facode, facilityname(facode) as fac_name from situation_analysis_db where tcode = '$tcode' order by facode ASC";
		}
		if ($distcode && $distcode != "0") {
			//$query = "SELECT * from facilities where distcode = '$distcode' and hf_type='e' order by facode ASC";
			$query = "SELECT distinct facode, facilityname(facode) as fac_name from situation_analysis_db where distcode = '$distcode' order by facode ASC";
		}
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="0"></option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['fac_name'] . '</option>';
		}
		return $data;
	}
	public function getAreaNameFacode() {
		$tcode = $this-> input-> post('tcode');
		$distcode = $this-> input-> post('distcode');
		$facode = $this-> input-> post('facode');
		$area_name = $this-> input-> post('area_name');
		$query = "SELECT * from situation_analysis_db";
		if ($facode && $facode != "0") {
			$query = "SELECT area_name from situation_analysis_db where facode = '$facode' order by area_name ASC";
		}
		if ($tcode && $tcode != "0") {
			$query = "SELECT area_name from situation_analysis_db where tcode = '$tcode' order by area_name ASC";
		}
		if ($distcode && $distcode != "0") {
			$query = "SELECT area_name from situation_analysis_db where distcode = '$distcode' order by area_name ASC";
		}
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="0"></option>';
		foreach ($result as $area_data) {
			$data .= '<option value="' . $area_data['area_name'] . '">' . $area_data['area_name'] . '</option>';
		}
		return $data;
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
	//------------------------ Form A2 Filter -------------------------------------------//
	public function form_a2_filter_new($campaign_type) {
		//Code for Pagination Updated by Nouman
	
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_a2_new";
		if($campaign_type != ''){
			$wc[] = " campaign_type = '$campaign_type' ";
		}
		
		// Change `records` according to your table name.
		$query="select group_id,campaign_type, form_date,distcode, districtname(distcode) as districtname, is_temp_saved from form_a2_new" . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " and form_date <> '1970-01-01' GROUP BY group_id,campaign_type ,form_date ,distcode, districtname(distcode),is_temp_saved order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}   ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-left">' . $row['districtname'] . '</td>
		    <td class="text-center">' . $row['campaign_type'] . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['form_date'])) . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'District-Issue-Receipt/View/' . $row['group_id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'District-Issue-Receipt/Edit/' . $row['group_id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		if($this -> session -> District)
			//$wc=" procode = '3' and distcode = '".$this -> session -> District."' and form_date <> '1970-01-01'";
			$wc=" procode = '".$_SESSION["Province"]."' and distcode = '".$this -> session -> District."' and form_date <> '1970-01-01'";
		else
			//$wc=" procode = '3' and form_date <> '1970-01-01'";
			$wc=" procode = '".$_SESSION["Province"]."' and form_date <> '1970-01-01'";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc,"group_id");
		return json_encode($resultJson);
	}
	public function getcase_definition($case_type) {
		$query = "SELECT id from surveillance_cases_types where short_name='$case_type'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$id=$result['id'];
		$query = "SELECT id, case_type_definition from case_clinical_representation where case_type_id=$id order by id";
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
		$query = "SELECT max(measles_number) as measles_number from measle_case_investigation where dcode='$epid_code' AND epid_year='$year'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$Measle = str_split(sprintf('%04u', ($result['measles_number'] + 1))); 
		return json_encode($Measle);
	}
	public function validateMeasleNumber($measleNumber) {
		$query = "SELECT case_epi_no from measle_case_investigation where case_epi_no='$measleNumber'";
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
	public function generateCoronavirus_case_number($distcode,$year) { 
		$query = "SELECT max(case_number) AS case_number FROM corona_case_investigation_form_db WHERE year='$year' AND distcode='$distcode'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$caseNum = str_split(sprintf('%06u', ($result['case_number'] + 1))); 
		return json_encode($caseNum);
	}
	public function case_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == $this -> session -> District && $districtCondition > 0 && $districtCondition != ''){
		 	$wc[] = " case_type != 'Msl' and (distcode = '$distcode' and  (cross_notified = 0 OR cross_notified IS NULL))";
		}
		else if($districtCondition == 'by_dist'){
			$wc[] = " case_type != 'Msl' and (distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'from_dist'){
			$wc[] = " case_type != 'Msl' and (distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'pending_dist'){
			$wc[] = " case_type != 'Msl' and ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR (substring(cross_notified_from_distcode, 1,1) != '".$pro_code."' AND approval_status = 'Pending' AND distcode IS NOT NULL)";
		}
		else if($districtCondition == 'other_prov_dist'){
			$wc[] = " case_type != 'Msl' and (distcode != '' OR distcode IS NOT NULL) AND (cross_notified_from_distcode = '".$this -> session -> District."' AND procode != '".$pro_code."' AND approval_status = 'Pending')";
		}
		if($this -> session -> District){
			// $distcode = $this -> session -> District;
			// $wc = getWC_Array($_SESSION["Province"],$distcode);
			$wc[] = " case_type != 'Msl' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		}else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " case_type != 'Msl'";
		}
		if($this -> session -> District){
			$wcd[] = " procode='".$_SESSION["Province"]."' and case_type != 'Msl' and ((distcode='".$this -> session -> District."' and cross_notified=0) OR (cross_notified_from_distcode='".$this -> session -> District."' and approval_status='Pending') OR (distcode='".$this -> session -> District."' and approval_status='Approved'))";
		}
		else{
			$wcd[] = " procode='".$_SESSION["Province"]."'";
		}
		$query = "SELECT max(id) as max_id from case_investigation_db " . (empty($wcd) ? '' : ' where ' . implode(" AND ", $wcd)) . " ";
		$result = $this -> db -> query($query);
		$max_id = $result ->row()->max_id;
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo
		$query="SELECT id, cross_notified, approval_status, year, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name,fweek, case_number, case_epi_no, case_type, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc, year desc, case_number desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#8FEBAD;";
			}else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#EBD38F;";
			}
			else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				$color = "background-color:#33ACFF;";
			}
			else if($row['approval_status'] == "Pending"){
				$color = "background-color:rgba(219, 37, 37, 0.5);";
			}else{
				$color = "";
			}
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
				$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];

			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$caseName = ((($row['case_type']) && $row['case_type']!= NULL && $row['case_type']!= '')?get_CaseType_Name($row['case_type']): '');
			$tbody .= '<tr style="'.$color.'">
				<td class="text-center">
					<input type="hidden" class="id" name="id" value="'.$row['id'].'">
					<input type="hidden" class="year" name="year" value="'.$row['year'].'">
					<input type="hidden" class="case_type" name="case_type" value="'.$row['case_type'].'">'.$i.'</td>
				<td class="text-left">'.$row['patient_name'].'</td>
				<td class="text-left">'.$facilityname.'</td>
				<td class="text-left">'.$tehsilname.'</td>
				<td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$caseName.'</td>
				<td class="text-center">'.$pvhDate.'</td>
				<td class="text-center">
					<a href="' . base_url() . 'Case_investigation/case_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
						if($row['year'] >= "2018"){
							if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
							{	
								$tbody .= '<a href="' . base_url() . 'Case_investigation/case_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
							}
						}
					}
					if($max_id==$row['id']){
						$tbody .= '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;
		//$wc = getWC(); this condition results in extra pages when specific filter is selected
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function cross_notified_case_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";				
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){			
			$yearWk = "week = '".$weekk."' AND ";			
		}
		else{
			$yearWk = '';
		}
		if($districtCondition == 'pending_dist'){			
			$wc[] = " case_type != 'Msl' and case_type != 'Diph' and distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending' ";
		}
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " case_type != 'Msl' and case_type != 'Diph'";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo
		$query="SELECT id, cross_notified, approval_status, year, case_epi_no, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name, fweek, case_type, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }
			 else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$caseName = ((($row['case_type']) && $row['case_type']!= NULL && $row['case_type']!= '')?get_CaseType_Name($row['case_type']): '');
			$tbody .= '<tr style="'.$color.'">
			   <td class="text-center">'.$i.'</td>
				<td class="text-left">'.$row['patient_name'].'</td>
			   <td class="text-left">'.$facilityname.'</td>
			   <td class="text-left">'.$tehsilname.'</td>
			   <td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$caseName.'</td>
				<td class="text-center">'.$pvhDate.'</td>			    
			   <td class="text-center">
					<a href="' . base_url() . 'Case_investigation/case_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if($row['year'] >= "2018"){
						if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
						{	
							$tbody .= '<a href="' . base_url() . 'Case_investigation/case_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
						} 
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC(); this condition results in extra pages when specific filter is selected
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function measles_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == $this -> session -> District && $districtCondition > 0 && $districtCondition != ''){
		 	$wc[] = " case_type = 'Msl' and (distcode = '$distcode' and  (cross_notified = 0 OR cross_notified IS NULL))";
		}
		else if($districtCondition == 'by_dist'){
			$wc[] = " case_type = 'Msl' and (distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'from_dist'){
			$wc[] = " case_type = 'Msl' and (distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'pending_dist'){
			$wc[] = " case_type = 'Msl' and ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR (substring(cross_notified_from_distcode, 1,1) != '".$pro_code."' AND approval_status = 'Pending' AND distcode IS NOT NULL)";
		}
		else if($districtCondition == 'other_prov_dist'){
			$wc[] = " case_type = 'Msl' and (distcode != '' OR distcode IS NOT NULL) AND (cross_notified_from_distcode = '".$this -> session -> District."' AND procode != '".$pro_code."' AND approval_status = 'Pending')";
		}
		else if($this -> session -> District){
			// $distcode = $this -> session -> District;
			// $wc = getWC_Array($_SESSION["Province"],$distcode);
			$wc[] = " case_type = 'Msl' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		}else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " case_type = 'Msl'";
		}
		/*if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = "distcode = '$distcode' ";
		}*/
		if($this -> session -> District){
			$wcd[] = " procode='".$_SESSION["Province"]."' and case_type = 'Msl' and ((distcode='".$this -> session -> District."' and cross_notified=0) OR (cross_notified_from_distcode='".$this -> session -> District."' and approval_status='Pending') OR (distcode='".$this -> session -> District."' and approval_status='Approved'))";
		}
		else{
			$wcd[] = " procode='".$_SESSION["Province"]."'";
		}
		$query = "SELECT max(id) as max_id from case_investigation_db " . (empty($wcd) ? '' : ' where ' . implode(" AND ", $wcd)) . " ";
		$result = $this -> db -> query($query);
		$max_id = $result ->row()->max_id;
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";

		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo 
		$query="SELECT id, cross_notified, approval_status, year, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name, fweek, case_epi_no, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc, year desc, case_number desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#8FEBAD;";
			}
			else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#EBD38F;";			
			}
			else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				$color = "background-color:#33ACFF;";
			}
			else if($row['approval_status'] == "Pending"){
				$color = "background-color:rgba(219, 37, 37, 0.5);";
			}
			else{
				$color = "";
			}
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
				$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];

			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$tbody .= '<tr style="'.$color.'">
				<td class="text-center">
					<input type="hidden" class="id" name="id" value="'.$row['id'].'">
					<input type="hidden" class="year" name="year" value="'.$row['year'].'">'.$i.'</td>
				<td class="text-left">'.$row['patient_name'].'</td>
				<td class="text-left">'.$facilityname.'</td>
				<td class="text-left">'.$tehsilname.'</td>
				<td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$pvhDate.'</td>
				<td class="text-center">'.$is_temp_saved.'</td>			    
				<td class="text-center">
					<a href="' . base_url() . 'Measles_investigation/measles_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
						if($row['year'] >= "2018"){
							if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
							{	
								$tbody .= '<a href="' . base_url() . 'Measles_investigation/measles_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
							}
						}
					}
					if($max_id==$row['id']){
						$tbody .= '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
				//$wc = getWC(); this condition results in extra pages when specific filter is selected
				//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson,true);
	}
	public function coronavirus_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == $this -> session -> District && $districtCondition > 0 && $districtCondition != ''){
		 	$wc[] = " case_type = 'Covid' and (distcode = '$distcode' and  (cross_notified = 0 OR cross_notified IS NULL))";
		}
		else if($districtCondition == 'by_dist'){
			$wc[] = " case_type = 'Covid' and (distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'from_dist'){
			$wc[] = " case_type = 'Covid' and (distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'pending_dist'){
			$wc[] = " case_type = 'Covid' and ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR (substring(cross_notified_from_distcode, 1,1) != '".$pro_code."' AND approval_status = 'Pending' AND distcode IS NOT NULL)";
		}
		else if($districtCondition == 'other_prov_dist'){
			$wc[] = " case_type = 'Covid' and (distcode != '' OR distcode IS NOT NULL) AND (cross_notified_from_distcode = '".$this -> session -> District."' AND procode != '".$pro_code."' AND approval_status = 'Pending')";
		}
		else if($this -> session -> District){
			// $distcode = $this -> session -> District;
			// $wc = getWC_Array($_SESSION["Province"],$distcode);
			$wc[] = " case_type = 'Covid' and (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		}else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " case_type = 'Covid'";
		}
		/*if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = "distcode = '$distcode' ";
		}*/
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "corona_case_investigation_form_db";

		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo 
		$query="SELECT id, cross_notified, approval_status, year, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, name, age_in_year, fweek, case_number, case_epi_no, pvh_date from corona_case_investigation_form_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by case_number desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";			
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];

			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$ucname = ((($row['uncode']) && $row['uncode']!= NULL && $row['uncode']!= '')?CrossProvince_UCName($row['uncode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$tbody .= '<tr style="'.$color.'">
				<td class="text-center">'.$i.'</td>
				<td class="text-left">'.$row['name'].'</td>
				<td class="text-left">'.$row['age_in_year'].'</td>
				<td class="text-left">'.$facilityname.'</td>
				<td class="text-left">'.$ucname.'</td>
				<td class="text-left">'.$tehsilname.'</td>
				<td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$pvhDate.'</td>						    
				<td class="text-center">
					<a href="' . base_url() . 'Coronavirus_investigation/coronavirus_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
					if($row['year'] >= "2018"){
						if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
						{	
							$tbody .= '<a href="' . base_url() . 'Coronavirus_investigation/coronavirus_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
						} 
					}
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
				//$wc = getWC(); this condition results in extra pages when specific filter is selected
				//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson,true);
	}
	public function cross_notified_measles_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		if($districtCondition == 'pending_dist'){
			$wc[] = " case_type = 'Msl' and distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending'";
		}
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " case_type = 'Msl'";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";

		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo 
		$query="SELECT id, cross_notified, approval_status, year, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name,fweek, case_epi_no, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";			
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');

			$tbody .= '<tr style="'.$color.'">
				<td class="text-center">'.$i.'</td>
				<td class="text-left">'.$row['patient_name'].'</td>
				<td class="text-left">'.$facilityname.'</td>
				<td class="text-left">'.$tehsilname.'</td>
				<td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$pvhDate.'</td>
				<td class="text-center">'.$is_temp_saved.'</td>				    
				<td class="text-center">
					<a href="' . base_url() . 'Measles_investigation/measles_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if($row['year'] >= "2018"){
						if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
						{	
							$tbody .= '<a href="' . base_url() . 'Measles_investigation/measles_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
						} 
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC(); this condition results in extra pages when specific filter is selected
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function cross_notified_diphtheria_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";				
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){			
			$yearWk = "week = '".$weekk."' AND ";			
		}
		else{
			$yearWk = '';
		}
		if($districtCondition == 'pending_dist'){			
			$wc[] = " case_type = 'Diph' and distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending' ";
		}
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = "case_type = 'Diph'";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
				
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo
		$query="SELECT id, cross_notified, approval_status, year, case_epi_no, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name, fweek, case_type, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }
			 else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['year']) && $row['year'] > 0)?$row['id'].'/'.$row['year']:$row['id'];
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$caseName = ((($row['case_type']) && $row['case_type']!= NULL && $row['case_type']!= '')?get_CaseType_Name($row['case_type']): '');
			$tbody .= '<tr style="'.$color.'">
			   <td class="text-center">'.$i.'</td>
				<td class="text-left">'.$row['patient_name'].'</td>
			   <td class="text-left">'.$facilityname.'</td>
			   <td class="text-left">'.$tehsilname.'</td>
			   <td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$caseName.'</td>
				<td class="text-center">'.$pvhDate.'</td>			    
			   <td class="text-center">
					<a href="' . base_url() . 'Case_investigation/case_investigation_view/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if($row['year'] >= "2018"){
						if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
						{	
							$tbody .= '<a href="' . base_url() . 'Case_investigation/case_investigation_edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
						} 
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC(); this condition results in extra pages when specific filter is selected
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//------------------------------Measles LINE LIST FILTER---------------------------------------//
	public function afp_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == $this -> session -> District && $districtCondition > 0 && $districtCondition != ''){
		 	$wc[] = " (distcode = '$distcode' and (cross_notified = 0 OR cross_notified IS NULL))";
		}
		else if($districtCondition == 'by_dist'){
			$wc[] = " (distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'from_dist'){
			$wc[] = " (distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Approved')";
		}
		else if($districtCondition == 'pending_dist'){
			//$wc[] = " ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '')";
			$wc[] = " ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR (substring(cross_notified_from_distcode, 1,1) != '".$pro_code."' AND approval_status = 'Pending' AND distcode IS NOT NULL)";
		}
		else if($districtCondition == 'other_prov_dist'){
			$wc[] = " (cross_notified_from_distcode = '".$this -> session -> District."' AND (distcode != '' OR distcode IS NOT NULL) AND procode != '".$pro_code."' AND approval_status = 'Pending')";
		}
		else if($this -> session -> District){
			// $distcode = $this -> session -> District;
			// $wc = getWC_Array($_SESSION["Province"],$distcode);
			$wc[] = " (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		}else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " ";
		}
		/*if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = "distcode = '$distcode' ";
		}*/
		if($this -> session -> District){
			$wcd[] = " procode='".$_SESSION["Province"]."' and ((distcode='".$this -> session -> District."' and cross_notified=0) OR (cross_notified_from_distcode='".$this -> session -> District."' and approval_status='Pending') OR (distcode='".$this -> session -> District."' and approval_status='Approved'))";
		}
		else{
			$wcd[] = " procode='".$_SESSION["Province"]."'";
		}
		//echo 
		$query = "SELECT max(id) as max_id from afp_case_investigation " . (empty($wcd) ? '' : ' where ' . implode(" AND ", $wcd)) . " "; 
		//exit();
		$result = $this -> db -> query($query);
		$max_id = $result ->row()->max_id;
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "afp_case_investigation";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
				
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//OR cross_notified_from_distcode='". $this -> session -> District ."'
		// Change `records` according to your table name.
		//echo
		$query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, patient_name, year, fweek, is_temp_saved, case_epi_no from afp_case_investigation " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		
		//print_r($query);exit;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '' ;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#8FEBAD;";
			}
			else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				$color = "background-color:#EBD38F;";
			}
			else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				$color = "background-color:#33ACFF;";
			}
			else if($row['approval_status'] == "Pending"){
				$color = "background-color:rgba(219, 37, 37, 0.5);";
			}
			else{
				$color = "";
			}
			if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
				$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			}
			else {
				$districtName =  ''; 
			}
			$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$tbody .= '<tr style="'.$color.'">
			    <td class="text-center">
			    	<input type="hidden" class="id" name="id" value="'.$row['id'].'">
					<input type="hidden" class="year" name="year" value="'.$row['year'].'">'.$i.'</td>	
				<td class="text-left">'.$row['patient_name'].'</td>				
				<td class="text-left">'.$facilityname.'</td>
				<td class="text-center">'.$row['facode'].'</td>
				<td class="text-left">'.$tehsilname.'</td>			    
				<td class="text-center">'.$districtName.'</td>
				<td class="text-center">'.$row['case_epi_no'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.$is_temp_saved.'</td>			    		    
				<td class="text-center">
			    	<a href="'.base_url().'AFP-CIF/View/'.$link.'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){
						if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
						{
							$tbody .= '<a href="' . base_url() . 'AFP-CIF/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
						}
					}
					if($max_id==$row['id']){
						$tbody .= '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC();
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);		
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function cross_notified_afp_investigation_filter($distcode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];		
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == 'pending_dist'){			
			$wc[] = " distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending'";
		}		
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " ";
		}
		
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "afp_case_investigation";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
				
		if($year!="0"){
			$wc[] = " year = '$year' ";
		}
		if($week!="0"){
			$wc[] = " week = '$week' ";
		}
		//OR cross_notified_from_distcode='". $this -> session -> District ."'
		// Change `records` according to your table name.
		$query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, patient_name, fweek, is_temp_saved, case_epi_no from afp_case_investigation " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		
		//print_r($query);exit;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '' ;
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			 if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$tbody .= '<tr style="'.$color.'">
					<td class="text-center">' . $i . '</td>	
					<td class="text-left">' . $row['patient_name'] . '</td>				
					<td class="text-left">'.$facilityname.'</td>
					<td class="text-center">' . $row['facode'] . '</td>
					<td class="text-left">'.$tehsilname.'</td>			    
					<td class="text-center">' . $districtName . '</td>
					<td class="text-center">' . $row['case_epi_no'] . '</td>
					<td class="text-center">' . $row['fweek'] . '</td>
					<td class="text-center">' . $is_temp_saved . '</td>			    		    
					<td class="text-center">
			      <a href="' . base_url() . 'AFP-CIF/View/' . $link . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
					{	
						$tbody .= '<a href="' . base_url() . 'AFP-CIF/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';

					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC();
		//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////
	public function nnt_investigation_filter($distcode,$investigated_by,$uncode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];		
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == $this -> session -> District && $districtCondition > 0 && $districtCondition != ''){
		 	$wc[] = " (distcode = '$distcode' and cross_notified IS NULL)";
		}
		else if($districtCondition == 'by_dist'){
			$wc[] = " distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND approval_status = 'Approved' ";
		}
		else if($districtCondition == 'from_dist'){
			$wc[] = " distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Approved' ";
		}
		else if($districtCondition == 'pending_dist'){			
			$wc[] = " ($yearWk distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR ($yearWk distcode != '".$this -> session -> District."' AND (cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."') AND procode = '".$pro_code."' AND approval_status = 'Pending' AND facode IS NULL AND distcode IS NOT NULL AND distcode != '') OR (substring(cross_notified_from_distcode, 1,1) != '".$pro_code."' AND approval_status = 'Pending' AND distcode IS NOT NULL)";
		}
		else if($districtCondition == 'other_prov_dist'){
			$wc[] = " (cross_notified_from_distcode = '".$this -> session -> District."' AND (distcode != '' OR distcode IS NOT NULL) AND procode != '".$pro_code."' AND approval_status = 'Pending')";
		}
		else if($this -> session -> District){
			$wc[] = " (distcode = '".$this -> session -> District."' OR cross_notified_from_distcode = '".$this -> session -> District."' OR rb_distcode = '".$this -> session -> District."')";
		}
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " ";
		}

		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "nnt_investigation_form";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		if($investigated_by!=NULL){
			$wc[] = " investigated_by = '$investigated_by' ";
			}
		if($year != '0'){
			$wc[] = " year = '$year' ";
		}
		if($week != '0'){
			$wc[] = " week = '$week' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($query);exit;
		//echo
		$query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, date_investigation, full_mother_name, fweek,is_temp_saved, investigated_by, date_notification from nnt_investigation_form " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " OR (cross_notified_from_distcode='". $this -> session -> District ."' " . (empty($wc) ? '' : ' and ' . implode(" AND ", $wc)) . ")  order by fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query);
		//exit();
		$result = $this -> db -> query($query);
		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";
			 }else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color: rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			 if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$notifDate = ($row['date_notification'] != '')?date("d-M-Y",strtotime($row['date_notification'])):'';
			$investDate = ($row['date_investigation'] != '')?date("d-M-Y",strtotime($row['date_investigation'])):'';
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$unioncouncilname = ((($row['uncode']) && $row['uncode']!= NULL && $row['uncode']!= '')?CrossProvince_UCName($row['uncode'],true):'');
			$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];
			$tbody .= '<tr style="'.$color.'">
			    <td class="text-center">' . $i . '</td>	
				<td class="text-left">' . $row['full_mother_name'] . '</td>			
			    <td class="text-left">'.$facilityname.'</td>
			   <td class="text-left">'.$unioncouncilname.'</td>
			    <td class="text-left">' . $row['investigated_by'] . '</td>
				<td class="text-left">' . $row['fweek'] . '</td>
			    <td class="text-center">' . $districtName . '</td>
			    <td class="text-center">' . $notifDate . '</td>
			    <td class="text-center">' . $investDate . '</td>
				<td class="text-center">' . $is_temp_saved . '</td>
			    <td class="text-center">
		      	<a href="' . base_url() . 'NNT-CIF/View/' . $link . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
				if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){	
					if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
					{
						$tbody .= '<a href="' . base_url() . 'NNT-CIF/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';

					}
				}	
			  	$tbody .= '</td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		//$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function cross_notified_nnt_investigation_filter($distcode,$investigated_by,$uncode,$facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$districtCondition = $distcode;
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		//echo $districtCondition;exit();
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($districtCondition == 'pending_dist'){
			$wc[] = " distcode = '".$this -> session -> District."' AND (cross_notified_from_distcode != '".$this -> session -> District."' OR rb_distcode != '".$this -> session -> District."') AND approval_status = 'Pending'";
		}
		
		else{
			//$wc = getWC_Array($_SESSION["Province"]);
			$wc[] = " ";
		}

		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "nnt_investigation_form";
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		if($investigated_by!=NULL){
			$wc[] = " investigated_by = '$investigated_by' ";
			}
		if($year != '0'){
			$wc[] = " year = '$year' ";
		}
		if($week != '0'){
			$wc[] = " week = '$week' ";
		}
		//print_r($query);exit;
		//echo
		$query="SELECT id, cross_notified, approval_status, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, date_investigation, full_mother_name, fweek, is_temp_saved, investigated_by, date_notification from nnt_investigation_form " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " OR (cross_notified_from_distcode='". $this -> session -> District ."' " . (empty($wc) ? '' : ' and ' . implode(" AND ", $wc)) . ")  order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query);
		//exit();
		$result = $this -> db -> query($query);
		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#8FEBAD;";
			 }else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
				 $color = "background-color:#EBD38F;";
			 }
			 else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
				  $color = "background-color:#33ACFF;";
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color: rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			 if(isset($row['cross_notified']) && $row['cross_notified'] == '0') {  
				$districtName = ''; 
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){
				$districtName = CrossProvince_DistrictName($row['distcode'],true);
			}
			else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ 
				$districtName = CrossProvince_DistrictName($row['cross_notified_from_distcode'],true);
			}
			else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { 
						$districtName = CrossProvince_DistrictName($row['distcode'],true); 
			} else {
				$districtName =  ''; 
			}
			$notifDate = ($row['date_notification'] != '')?date("d-M-Y",strtotime($row['date_notification'])):'';
			$investDate = ($row['date_investigation'] != '')?date("d-M-Y",strtotime($row['date_investigation'])):'';
			$facilityname = ((($row['facode']) && $row['facode']!= NULL && $row['facode']!= '')?CrossProvince_FacilityName($row['facode'],true): '');
			$tehsilname = ((($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= '')?CrossProvince_TehsilName($row['tcode'],true):'');
			$unioncouncilname = ((($row['uncode']) && $row['uncode']!= NULL && $row['uncode']!= '')?CrossProvince_UCName($row['uncode'],true):'');
			$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];

			$tbody .= '<tr style="'.$color.'">
					<td class="text-center">' . $i . '</td>	
					<td class="text-left">' . $row['full_mother_name'] . '</td>			
					<td class="text-left">'.$facilityname.'</td>
					<td class="text-left">'.$unioncouncilname.'</td>
					<td class="text-left">' . $row['investigated_by'] . '</td>
					<td class="text-left">' . $row['fweek'] . '</td>
					<td class="text-center">' . $districtName . '</td>
					<td class="text-center">' . $notifDate . '</td>
					<td class="text-center">' . $investDate . '</td>
					<td class="text-center">' . $is_temp_saved . '</td>
					<td class="text-center">
		      	<a href="' . base_url() . 'NNT-CIF/View/' . $link . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
					{
						$tbody .= '<a href="' . base_url() . 'NNT-CIF/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';

					}
			  	$tbody .= '</td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		//$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
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
	public function getTechnicians($facode) {
		//$query = "SELECT techniciancode,technicianname from techniciandb where facode = '$facode' and status='Active' order by technicianname ASC ";
		//$query = "SELECT distinct(code) as techniciancode,name as technicianname   from hr_db_history_new where post_facode = '$facode'  order by technicianname ASC ";
		$query = "SELECT new as techniciancode,name as technicianname from (SELECT DISTINCT ON (code) code,code as new, * FROM hr_db_history ORDER BY code DESC, id DESC ) subquery where post_facode = '$facode' and  post_status='Active' and post_hr_sub_type_id='01'";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		//echo $this->db->last_query();exit;
		$data = '<option value="">--Select--</option>';
		foreach ($result as $tech_data) {
			$data .= '<option value="' . $tech_data['techniciancode'] . '">' . $tech_data['technicianname'] . '</option>';
		}
		return $data;
	}
	public function getTechredrec($facode,$year) {
		$query = "SELECT DISTINCT techniciancode, (case when (year='2019' OR year='2018') then technicianname(techniciancode) else hr_name(techniciancode) end) as technicianname from situation_analysis_db where facode = '$facode' and year='$year' order by technicianname ASC ";
		$result = $this-> db-> query($query);
		$result = $result-> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $tech_data) {
			$data .= '<option value="' . $tech_data['techniciancode'] . '">' . $tech_data['technicianname'] . '</option>';
		}
		return $data;
	}
	public function getAreaAndSession($techniciancode,$year,$quarter) {
		$query = "SELECT * ,(case when (year='2019' OR year='2018') then technicianname(techniciancode) else hr_name(techniciancode) end) as technicianname ,area_name, f3_actual_sessions_plan,f3_session_type,facode from situation_analysis_db where techniciancode = '$techniciancode' and year='$year' order by area_name ASC ";
		$result = $this-> db-> query($query);
		$data['row'] = $result-> result_array();
		$data['quarter'] =$quarter;
		//print_r($data['row']); exit;
		$var =  $this-> load-> view('Add_red_microplanning/hf_quaterplan_row',$data);		
	}
	public function checkTechnician_avalible($faicode,$techniciancode,$selectedYear=NULL) {
		$checkquery = "SELECT count(*) as recordnum from situation_analysis_db where techniciancode='$techniciancode' and facode = '$faicode' ";
		if($selectedYear){
			$checkquery .= " and year = '$selectedYear'";
		}
		$result = $this-> db->query($checkquery);
		$record = $result-> row_array();
		//print_r($record); exit;
		$num_of_records = $record['recordnum'];
		if($num_of_records > 0){
			//$location = base_url().'red_rec_microplan/Situation_analysis/situation_analysis_list';
			//$script  = '<script language="javascript" type="text/javascript">';
			//$script .= 'alert("Cannot save data because data already exists for this Facility and Year!");';
			//$script .= 'window.location="'. $location . '"';
			//$script .= '</script>';
			return json_encode("yes");
			//echo "1";		
			exit();
		}
		else{
			return json_encode("no");
		}
	}
	public function checkTechnician_avalible_list($techniciancode,$quarter,$facode,$year) {
		//echo'test'; exit;
		$checkquery = "SELECT count(*) as recordnum from hf_quarterplan_db where techniciancode='$techniciancode' AND facode = '$facode' AND quarter = '$quarter' AND year = '$year'";
	    $result = $this-> db->query($checkquery);
		$record = $result-> row_array();
		$num_of_records = $record['recordnum'];
		//$str = $this->db->last_query();
		//print_r($str); exit;
		if($num_of_records > 0){
			return json_encode("yes");
			//echo "1";		
			exit();
		}
		else{
			return json_encode("no");
		}
	}
	public function checkQuarter_avalible_list($techniciancode,$quarter,$facode,$year) {
		//echo'test'; exit;
		$checkquery = "SELECT count(*) as recordnum from hf_quarterplan_db where techniciancode='$techniciancode' AND facode = '$facode' AND quarter = '$quarter' AND year = '$year'";
	    $result = $this-> db->query($checkquery);
		$record = $result-> row_array();
		$num_of_records = $record['recordnum'];
		//$str = $this->db->last_query();
		//print_r($str); exit;
		if($num_of_records > 0){
			return json_encode("yes");
			//echo "1";		
			exit();
		}
		else{
			return json_encode("no");
		}
	}
	public function aefi_filter($tcode,$uncode,$facode,$year,$week,$complaints) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$pro_code = $_SESSION['Province'];
		$yearr = $year;
		$weekk = $week;
		if(($yearr > 0) && ($weekk > 0)){
			$yearWk = "year = '".$yearr."' AND week = '".$weekk."' AND ";
		}
		else if(($yearr > 0) && ($weekk == 0)){
			$yearWk = "year = '".$yearr."' AND ";
		}
		else if(($yearr == 0) && ($weekk > 0)){
			$yearWk = "week = '".$weekk."' AND ";
		}
		else{
			$yearWk = '';
		}
		
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "aefi_rep";
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		if($facode > 0){
			$wc[] = " facode = '$facode' ";
		}
		if($year != "0"){
			$wc[] = " year = '$year' ";
		}				
		if($week != "0"){
			$wc[] = " week = '$week' ";
		}
		if($complaints != ""){
			$wc[] = " complaints = '$complaints' ";
		}
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc[] = "distcode = '$distcode' ";
		}
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc[] = "tcode = '$tcode' ";
		}
		//print_r($wc);exit;
		// Change `records` according to your table name.
		//echo 
		$query="SELECT id,year,casename,age,facilityname(facode) as facilityname,unname(uncode) as unioncouncil,tehsilname(tcode) as tehsilname,		
		trim(trailing ', ' from  
			case when mc_bcg = 1 then 'BCG Lymphadenitis , ' else '' END || 
			case when mc_convulsion = 1 then 'Convulsion , ' else '' END || 
			case when mc_severe = 1 then 'Severe Local Reaction , ' else '' END || 
			case when mc_unconscious = 1 then 'Unconsciousness , ' else '' END || 
			case when mc_abscess = 1 then 'Injection site abscess , ' else '' END || 
			case when mc_respiratory = 1 then 'Respiratory Distress , ' else '' END || 
			case when mc_fever = 1 then 'Fever , ' else '' END || 
			case when mc_swelling = 1 then 'Swelling of body or face , ' else '' END || 
			case when mc_rash = 1 then 'Rash , ' else '' END || 
			case when mc_other IS NULL then '' else mc_other END
		) as complaints,		
		vacc_name, vacc_vaccinator, is_temp_saved, fweek, rep_date from aefi_rep " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;				
			$tbody .= '<tr>
			    <td class="text-center">
			    	<input type="hidden" class="id" name="id" value="'.$row['id'].'">'.$i.'</td>
				<td class="text-left">'.$row['casename'].'</td>
			    <td class="text-left">'.$row['facilityname'].'</td>
			    <td class="text-left">'.$row['unioncouncil'].'</td>
				<td class="text-left">'.$row['tehsilname'].'</td>
				<td class="text-left">'.$row['complaints'].'</td>';
				if($row['vacc_name']>=1 && $row['vacc_name']<=10000){
					$tbody .= '<td class="text-center">'.getVaccineName($row['vacc_name']).'</td>';
				}
				else{
					$tbody .= '<td class="text-center">'.$row['vacc_name'].'</td>';
				}
				$tbody .= '<td class="text-left">'.$row['vacc_vaccinator'].'</td>
				<td class="text-center">'.$row['fweek'].'</td>
				<td class="text-center">'.date("d-M-Y",strtotime($row['rep_date'])).'</td>
			    <td class="text-center">
					<a href="' . base_url() . 'AEFI-CIF/View/'. $row['id'] .'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
				if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
					if($row['year'] >= "2018"){
						$tbody .= '<a href="' . base_url() . 'AEFI-CIF/Edit/'. $row['id'] .'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
					}
				}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
				//$wc = getWC(); this condition results in extra pages when specific filter is selected
				//print_r($wc);exit();
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson,true);
	}
	public function checkPatientCNICNumber($cnic){
		$query = "SELECT cnic FROM corona_case_investigation_form_db WHERE cnic='".$cnic."'"; 
		$query= $this->db->query($query);
		$result = $query->row_array();
		if ($result==true)
		{
			$return = 'Yes';
		}
		else
		{
			$return = 'No';
		}
		return $return;
	}
	public function getUcMergedVillagesList($uncode,$year){
		$this -> db -> select('*');
		$this -> db -> from('village_merger');
		$this -> db -> where(array('uncode'=>$uncode,'year'=>$year));
		$this -> db -> where("merger_group_id IN (select merger_group_id from villages_population where uncode='{$uncode}' and year = '{$year}' and merged_village = 1)",NULL,FALSE);
		return $this -> db -> get() -> result_array();
	}
	public function getUcVillages($uncode,$year){
		$this -> db -> select('*,villagename(vcode) as village');
		$this -> db -> from('villages_population');
		$this -> db -> where(array('uncode'=>$uncode,'year'=>$year,'merged_village'=>0));
		return $this -> db -> get() -> result_array();
	}
	
	public function getVaccine_batchNumber($vacc_id) {
		$district = $this -> session -> District;
		$username = $this->session->userdata("username");
		$query = "SELECT array_to_string(array_agg(pk_id),''',''') as pk_id from epi_item_pack_sizes where item_id='$vacc_id'";
		$result = $this-> db-> query($query);
		$item_pack_id = $result->row_array();
		$item_id =$item_pack_id['pk_id'];
		$query = "SELECT DISTINCT number from epi_stock_batch where item_pack_size_id in ('$item_id') and code ='$district' and created_by='$username' order by number";
		//print_r($query); exit();
		$result = $this-> db-> query($query);
		$result = $result-> result_array(); 
		//print_r($result); exit();
		$data = '<option value="">--- Select ---</option>';
		foreach ($result as $vacc_data) {
			$data .= '<option value="'.$vacc_data['number'].'">'.$vacc_data['number'].'</option>';
		}
		//$data['all_batchenumber_data'] = $result->result_array();
		return $data;
	}

	public function get_vaccine_expirydate($batch_number) { 
		$district = $this -> session -> District;
		$username = $this->session->userdata("username");
		$query = "SELECT expiry_date from epi_stock_batch where number='$batch_number' and code ='$district' and created_by='$username'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$expiryDate = $result['expiry_date'];
		echo date("d-m-Y",strtotime(date($expiryDate)));
	}
}
?>