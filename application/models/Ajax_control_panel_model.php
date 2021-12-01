<?php
class Ajax_control_panel_model extends CI_Model {
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
	public function getTehsils() {
		$distcode = $this -> input -> post('distcode');
		$facode = $this -> input -> post('facode');
		if ($facode != '') {
			$query = "select * from facilities where facode = '$facode' order by fac_name asc";
			$result = $this -> db -> query($query);
			$result = $result -> row_array();
			$resultJson = array();
			$resultJson['tcode'] = $result['tcode'];
			$resultJson['uncode'] = $result['uncode'];
			$resultJson['catchM'] = $result['catchment_area_pop'];
			return json_encode($resultJson);
			exit();
		} else {
			$query = "select * from tehsil where distcode = '$distcode' order by tehsil asc ";
			////echo $query;exit();
			$result = $this -> db -> query($query);
			$result = $result -> result_array();
			//print_r($result);exit();
			$data = '<option value="0">--Select Tehsil--</option>';//
			foreach ($result as $fac_data) {
				$data .= '<option value="' . $fac_data['tcode'] . '">' . $fac_data['tehsil'] . '</option>';
			}
			return $data;
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
	public function searchParam($facode, $distcode, $fmonth, $fatype, $searchParam){
		echo "abc";exit();
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

		//print_r($query);exit;
		$query="SELECT tcode,uncode,facode,techniciancode,year, tehsilname(tcode) as tehsil, unname(uncode) as unioncouncil, facilityname(facode) as facility, technicianname(techniciancode) as technician, year from situation_analysis_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by year DESC, facode, priority ASC LIMIT {$per_page} OFFSET {$startpoint}";
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
								<a href="' . base_url() . 'red_rec_microplan/Situation_analysis/situation_analysis_view/' . $row['techniciancode'] . '/'. $row['year'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'red_rec_microplan/Situation_analysis/situation_analysis_edit/' . $row['techniciancode'] .'/'. $row['year'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
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
		$query="SELECT id ,cross_notified, approval_status, year, cross_notified_from_distcode, facode, uncode, tcode, distcode, procode, is_temp_saved, patient_name,fweek, case_epi_no, pvh_date from case_investigation_db " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
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
	public function users_list_filter($distcode,$level,$utype){
		$procode = isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
		if($this-> session-> District){
			$distcode = $this-> session-> District;
			$wc = getWC_Array($_SESSION["Province"], $distcode);
		}
		else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epiusers";

		if($distcode > 0){
			$wc[] = " distcode = '$distcode' ";
		}
		if($level != "0"){
			$wc[] = " level = '$level' ";
		}
				
		if($utype != "0"){
			$wc[] = " utype = '$utype' ";
		}
		//print_r($wc);exit();
		// Change `records` according to your table name.
		//echo		
		$query="SELECT username, utype, districtname(distcode) AS district, fullname, level, addeddate FROM epiusers " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by addeddate DESC LIMIT {$per_page} OFFSET {$startpoint}";
		//exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$i++;
			$link = (isset($row['username']) && $row['username'] != '')?$row['username']: '';			
			$tbody .= '<tr id="row_'.$row['username'].'" class="DrilledDown">
						   <td class="text-center">'.$i.'</td>
							<td class="text-left">'.$row['username'].'</td>
						   <td class="text-left">'.$row['utype'].'</td>
							<td class="text-left">'.$row['district'].'</td>
							<td class="text-left">'.$row['fullname'].'</td>
							<td class="text-left">'.get_UserLevel_Description($row['level']).'</td>		    
						   <td class="text-center">								
								<a href="' .base_url(). 'User_management/user_add?user='.$link.'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
								<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user(\''.$row['username'].'\');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
						  	</td>
		    			</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		//print_r($wc);exit();
		//$wc = getWC();
		$resultJson["paging"] = $this-> Common_model-> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson,true);
	}
	public function menu_list_filter($level, $utype){
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "user_roles";
		$wc = array(); 
		$wa = array();
		$wa[] = "menu.parent_id = '#'";
		if($level != "0"){
			$wc[] = " level = '$level' ";
			$wa[] = " level = '$level' ";
		}
				
		if($utype != "0"){
			$wc[] = " type = '$utype' ";
			$wa[] = " type = '$utype' ";
		}
		
		$wherea = ((!empty($wc))? 'where '.implode(" AND ",$wc):' ');
		$wh = ((!empty($wa))? 'where ' .implode(" AND ",$wa):' ');	

		$query="SELECT roles_menu.id as rol_id, menu.id, menu.menu_item, menu.menu_url, '#' as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu 
		INNER JOIN roles_menu ON roles_menu.menu_id=menu.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		{$wh}
		
		UNION ALL
		
		SELECT roles_menu.id as rol_id, b.id, b.menu_item, b.menu_url, a.menu_item as parent, user_level_db.userlevel_description, user_types_db.usertype
		FROM menu a
		INNER JOIN menu b on b.parent_id = a.id::text
		INNER JOIN roles_menu ON roles_menu.menu_id=b.id
		INNER JOIN user_roles ON roles_menu.role_id=user_roles.id 
		INNER JOIN user_types_db ON user_roles.type=user_types_db.id
		INNER JOIN user_level_db ON user_roles.level=user_level_db.userlevel
		{$wherea} order by rol_id LIMIT {$per_page} OFFSET {$startpoint}";
		//echo $query; exit();
 		$result = $this->db->query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = '';
		foreach ($result as $row) {
			$i++;
			$link = (isset($row['id']) && $row['id'] != '')?$row['id']: '';			 
			$tbody .= '<tr id="row_'.$row['id'].'" class="DrilledDown">
							<td class="text-center">'.$i.'</td>
							<td class="text-left">'.$row['menu_item'].'</td>
							<td class="text-left">'.$row['menu_url'].'</td>
							<td class="text-left">'.$row['parent'].'</td>
							<td class="text-left">'.$row['userlevel_description'].'</td>
							<td class="text-left">'.$row['usertype'].'</td>
							<td class="text-center">								
								<a href="' .base_url(). 'User_menu/menu?menu='.$link.'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
								<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user(\''.$row['id'].'\', \''.$row['rol_id'].'\');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
						  	</td>
		    			</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$this->load->model("User_menu_model");
		$resultJson["paging"] = $this->User_menu_model->pagination($statement,$per_page,$page,$url = "?");
		return json_encode($resultJson,true);
	}	
}
?>
