<?php
// kp local
class Ajax_calls_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
	}
	public function validateAefiNumber($aefiNumber){
		$query = "select case_epi_no from aefi_case_investigation_form where case_epi_no='$aefiNumber'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$numberExist = $result['case_epi_no'];
		if ($numberExist == $aefiNumber) { 
			return "Error";
		}else{
			return "Correct";
		}
	}
	public function getAefiNumber($year, $epid_code){
		$query = "select max(aefi_number) as aefi_number from aefi_case_investigation_form where year='$year' AND dcode='$epid_code'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$AEFI = str_split(sprintf('%04u', ($result['aefi_number'] + 1)));
		return json_encode($AEFI);
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
	public function getMeasleNumber($year, $epid_code) { 
		$query = "select max(measles_number) as measles_number from measle_case_investigation where dcode='$epid_code' AND epid_year='$year'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$Measle = str_split(sprintf('%04u', ($result['measles_number'] + 1))); 
		return json_encode($Measle);
	}
	
	public function getepi_number($year, $case_type,$short_code) {
		$query = "select max(epid_number) as epi_number from weekly_vpd where year='$year' AND case_type='$case_type' AND dist_shortcode='$short_code'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$AEFI = str_split(sprintf('%03u', ($result['epi_number'] + 1)));
		return json_encode($AEFI);
	}
	
	public function getcase_definition($case_type) {
		$query = "select id from surveillance_cases_types where type_short_code='$case_type'";
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
	
	
	public function supervisor_filter($page, $distcode, $tcode, $facode, $fatype, $uncode, $supervisor_type,$status) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($uncode != 0) {
			$wc[] = " uncode = '$uncode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		$supervisor_type= str_replace('_', ' ', $supervisor_type);
		if ($supervisor_type != "0") {			
			$wc[] = " supervisor_type = '$supervisor_type' ";
		}
			if ($status != "0" && $status != '' && $status=="Active") {
			$wc[] = "status = '$status' ";
		}
		else if($status=="Active-Temp"){
		$wc[]="status = 'Active' ";
		$wc[] = "current_status = 'Temporary-Post' ";
		}
		else if($status=="0"){
	
		}
		else{
		$wc[] = "status = '$status' ";	
		}			   
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "supervisordb";
		// if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){
		// 	$wc[] = "is_temp_saved = '0' ";
		// }
		// Change `records` according to your table name.
		$query = "SELECT supervisorname,districtname(supervisordb.distcode) as districtname,is_temp_saved,supervisorcode,supervisor_type,nic,status from supervisordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {

				$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ;
				$i++;
				$tbody .= '<tr>
	                              <td class="text-center">' . $i . '</td>                              
	                              <td class="text-left">' . $row["supervisorname"] . '</td>
	                              <td class="text-left">' . $row["supervisor_type"] . '</td>
	                              <td class="text-center">' . $row["supervisorcode"] . '</td>
	                              <td class="text-center">' . $row["nic"] . '</td> 
								  <td class="text-center">' . $row["districtname"] . '</td> 
	                              <td class="text-center">' . $row["status"] . '</td>';
								  if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){
									$tbody .= ' <td class="text-center">' . $is_temp_saved . '</td>';
								  }
								  if (($_SESSION['UserLevel']=='2') ){
									$tbody .= ' <td class="text-center">' . $is_temp_saved . '</td>';
								  }
	              					if (($_SESSION['UserLevel']=='3') && ($utype=='DEO')){
	                       				$tbody .= '      <td class="text-center">
	                                 	<div class="btn-group">';
	                               	// if(($this -> session -> UserLevel=='3' && ($row['supervisor_type']=="Tehsil Superintendent Vaccinator" || $row['supervisor_type']=="Field Superintendent Vaccinator") ) ){

	                                    $tbody .= '<a href="' . base_url() . 'Supervisor/View/' . $row["supervisorcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
	                                    <a href="' . base_url() . 'Supervisor/Edit/' . $row["supervisorcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
	                               //} 
	                                $tbody .= ' </div>
	                              </td>';
	                           }
							$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}		
		$resultJson["tbody"] = $tbody;
		// displaying 1paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
		public function supervisor_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic != '' ){
		   $wc[] = "nic like '%$nic%' OR supervisorname like '%$nic%' OR fathername like '%$nic%' OR supervisorcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "supervisordb ";
		/* if (($_SESSION['UserLevel']=='2') && ($utype=='Manager')){
			$wc[] = "is_temp_saved = '0' ";
		 } */
		// Change `records` according to your table name.
		
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, is_temp_saved,districtname(distcode) as district, tehsilname(tcode) as tehsil from supervisordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$is_temp_saved = $row['is_temp_saved']=='0'?'Submitted':'Not Submitted';
				$i++;
				$tbody .= '<tr>
	                              <td class="text-center">' . $i . '</td>
	                              <td class="text-center">' . $row["supervisorname"] . '</td>
	                              <td class="text-center">' . $row["supervisor_type"] . '</td>                             
	                              <td class="text-center">' . $row["supervisorcode"] . '</td>
	                              <td class="text-center">' . $row["nic"] . '</td>                              
	                               <td class="text-center">' . $row["status"] . '</td>';
								   if (($_SESSION['UserLevel']=='2') && ($utype=='Manager')){
										$tbody .= ' <td class="text-center">' .$is_temp_saved . '</td>';
								   }
	              if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') || ($_SESSION['UserLevel']=='2') && ($utype=='Manager')){
	                        $tbody .= '      <td class="text-center">
	                                 <div class="btn-group">';
	                                  if(($this -> session -> UserLevel=='3' && ($row['supervisor_type']=="Tehsil Superintendent Vaccinator" || $row['supervisor_type']=="Field Superintendent Vaccinator") ) || ($this -> session -> UserLevel=='2' && ($row['supervisor_type']!="Tehsil Superintendent Vaccinator" || $row['supervisor_type']!="Field Superintendent Vaccinator"))){

	                                    $tbody .= '<a href="' . base_url() . 'Supervisor/View/' . $row["supervisorcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
	                                    <a href="' . base_url() . 'Supervisor/Edit/' . $row["supervisorcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
	                               } 
	                                $tbody .= ' </div>
	                              </td>';
	                           }
							$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}	
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function getBranches() {
		$distcode = $this -> input -> post('distcode');
			$query = "select * from bankdb where distcode = '$distcode' ";
			////echo $query;exit();
			$result = $this -> db -> query($query);
			$result = $result -> result_array();
			//print_r($result);exit();
			$data = '<option value="">Select Bank</option>';
			foreach ($result as $b_data) {
				$data .= '<option value="' . $b_data['branchcode'] . '">' . $b_data['branchcode'] ."-". $b_data['bankname'] ."-".$b_data['branchname'] . '</option>';
			}
			return $data;
	}
	
	public function getFacilityTechnicians($facode){
		/* $this -> db -> select('techniciancode,technicianname');
		$this -> db -> where(array('facode'=>$facode,'status'=>'Active'));
		return $this -> db -> get('techniciandb') -> result_array(); */
        $query = "SELECT new as techniciancode,name as technicianname from (SELECT DISTINCT ON (code) code,code as new, * FROM hr_db_history ORDER BY code DESC, id DESC ) subquery where post_facode = '$facode' and  post_status='Active' and post_hr_sub_type_id='01'";
		$result = $this-> db-> query($query);
		return $result-> result_array();
	}
	public function technician_filter($page, $distcode, $tcode, $uncode, $facode, $supervisorcode, $fatype,$status) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		if($distcode > 0){}	else{
			if($this -> session -> District){
				$distcode = $this -> session -> District;
			}else{
				$distcode = 0;
			}
		}
		$distcode = $this -> session -> District;
		$wc = getWC_Array($_SESSION["Province"]);
		if($distcode != 0){
			$wc[]="distcode = '$distcode' ";
		}
		if ($tcode != 0) {
			$wc[] = "tcode = '$tcode' ";
		}
		if ($facode != 0) {
			$wc[] = "facode = '$facode' ";
		}
		if ($uncode != 0) {
			$wc[] = "uncode = '$uncode' ";
		}
		if ($supervisorcode != 0) {
			$wc[] = "supervisorcode = '$supervisorcode' ";
		}
		if ($status != '0') {
			$wc[] = "status = '$status' ";
		}
		if ($fatype != '0' ) { 
			$wc[] = "facilitytype(facode) = '$fatype' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "techniciandb ";
		
		/* if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){		
			$wc[] = "is_temp_saved = '0'";
		} */
		// Change `records` according to your table name.
		$query = "select *, supervisorname(supervisorcode) as supervisorname, is_temp_saved,facilitytype(facode) as facilitytype,districtname(distcode) as district, fathername, '' as under_one_year, catch_area_pop, status,  facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from techniciandb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//print_r($query);exit;
		$result = $this -> db -> query($query);
		$result = $result -> result_array(); 
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$is_temp_saved = $row["is_temp_saved"] == '0' ? 'Submitted' : 'Not Submitted';
				$i++;
				$tbody .= '<tr>
	                            <td class="text-center">' . $i . '</td>                            
								<td class="text-left">' . $row["technicianname"] . '</td>
								<td class="text-left">' . $row["fathername"] . '</td>
								<td class="text-center">' . $row["nic"] . '</td>													                          
							    <td class="text-left">' . $row["facilityname"] . '</td>
								<td class="text-center">' . $row["facilitytype"] . '</td>';
								if (($_SESSION['UserLevel']=='2') && ($this -> session -> utype=='Manager') ){
	                        $tbody .= '
									<td class="text-center">' . $row["district"] . '</td>';
								}
								
							$tbody .= '	<td class="text-center">' . $row["catch_area_pop"] . '</td>
								<td class="text-left">' . $row["status"] . '</td>';
								if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
	                        $tbody .= '
								<td class="text-center">' . $is_temp_saved . '</td>';
								}
	               if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
	                        $tbody .= '      <td class="text-center">
	                                 <div class="btn-group">
	                                    <a href="' . base_url() . 'Technician/View/' . $row["techniciancode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
										if($row['status']=='Active'){
											$tbody .= '<a href="' . base_url() . 'Technician/Edit/' . $row["techniciancode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
										}
	                                $tbody .= ' </div>
	                              </td>';
	                           }
							$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function med_technician_filter($page, $distcode, $tcode, $facode, $uncode, $supervisorcode, $status, $fatype) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		if($distcode > 0){}	else{
			if($this -> session -> District){
				$distcode = $this -> session -> District;
			}else{
				$distcode = 0;
			}
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode,$facode);
		if ($tcode != 0) {
			$wc[] = "tcode = '$tcode' ";
		}
		if ($facode != 0) {
			$wc[] = "facode = '$facode' ";
		}
		if ($uncode != 0) {
			$wc[] = "uncode = '$uncode' ";
		}
		if ($supervisorcode != "0") {
			$wc[] = "supervisorcode = '$supervisorcode' ";
		}
		if ($status != '0') {
			$wc[] = "status = '$status' ";
		}
		if ($fatype != '0') { 
			$wc[] = "facilitytype(facode) = '$fatype' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "med_techniciandb ";
		// Change `records` according to your table name.
		/* if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){
			$wc[] = "is_temp_saved = '0' ";	
		} */
		$query = "select *, supervisorname(supervisorcode) as supervisorname, is_temp_saved,facilitytype(facode) as facilitytype, '' as under_one_year, fathername, catch_area_pop, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from med_techniciandb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$is_temp_saved = $row["is_temp_saved"] == '0' ? 'Submitted' : 'Not Submitted';
				$i++;
				$tbody .= '<tr>
	                            <td class="text-center">' . $i . '</td>                            
								<td class="text-left">' . $row["technicianname"] . '</td>
								<td class="text-left">' . $row["fathername"] . '</td>
								<td class="text-center">' . $row["nic"] . '</td>
								<td class="text-center">' . $row["supervisorname"] . '</td>
								<td class="text-center">' . $row["unioncouncil"] . '</td>							
							    <td class="text-left">' . $row["facilityname"] . '</td>
								<td class="text-center">' . $row["facilitytype"] . '</td>';
								if (($_SESSION['UserLevel']=='2') && ($this -> session -> utype=='Manager') ){
	                        $tbody .= '
									<td class="text-center">' . $row["district"] . '</td>';
								}
								
							$tbody .= '
								<td class="text-center">' . $row["catch_area_pop"] . '</td>
								<td class="text-center">' . $row["status"] . '</td>';
								   if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
									$tbody .= '<td class="text-center">' . $is_temp_saved . '</td>';
								   }
	               if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
	                        $tbody .= '      <td class="text-center">
	                                 <div class="btn-group">
	                                    <a href="' . base_url() . 'Medical-Technician/View/' . $row["techniciancode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
										<a href="' . base_url() . 'Medical-Technician/Edit/' . $row["techniciancode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	                                 </div>
	                              </td>';
	                           }
							$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function technician_filter_cnic($cnic) {
		
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic != '' ){
		   $wc[] = "nic like '%$nic%' OR technicianname like '%$nic%' OR fathername like '%$nic%' OR techniciancode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "techniciandb ";
		// Change `records` according to your table name.
		//$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from supervisordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$query = "select *, supervisorname(supervisorcode) as supervisorname,is_temp_saved, fathername, facilitytype(facode) as facilitytype, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) from techniciandb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved']=='0'?'Submitted':'Not Submitted';
			$i++;
			$tbody .= '<tr>
                            <td class="text-center">' . $i . '</td>                            
							<td class="text-left">' . $row["technicianname"] . '</td>
							<td class="text-left">' . $row["fathername"] . '</td>
							<td class="text-center">' . $row["nic"] . '</td>	
							<td class="text-left">' . $row["facilityname"] . '</td>
							<td class="text-center">' . $row["facilitytype"] . '</td>
							 <td class="text-center">' . $row["facode"] . '</td>						
							<td class="text-center">' . $row["catch_area_pop"] . '</td>
							<td class="text-center">' . $row["status"] . '</td>
							<td class="text-center">' . $is_temp_saved . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Technician/View/' . $row["techniciancode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="' . base_url() . 'Technician/Edit/' . $row["techniciancode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function med_technician_filter_cnic($cnic) {
		
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District; 
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic != '' ){
		   $wc[] = "nic like '%$nic%' OR technicianname like '%$nic%' OR fathername like '%$nic%' OR techniciancode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "med_techniciandb ";
		// Change `records` according to your table name.
		//$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from supervisordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$query = "select *, supervisorname(supervisorcode) as supervisorname, is_temp_saved,facilitytype(facode) as facilitytype, '' as under_one_year, fathername, status, catch_area_pop, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from med_techniciandb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  LIMIT {$per_page} OFFSET {$startpoint} ";		
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
						<td class="text-left">' . $row["technicianname"] . '</td>
						<td class="text-left">' . $row["fathername"] . '</td>
						<td class="text-center">' . $row["nic"] . '</td>
						<td class="text-center">' . $row["supervisorname"] . '</td>
						<td class="text-center">' . $row["unioncouncil"] . '</td>							
					    <td class="text-left">' . $row["facilityname"] . '</td>
						<td class="text-center">' . $row["facilitytype"] . '</td>
						<td class="text-center">' . $row["catch_area_pop"] . '</td>
						<td class="text-center">' . $row["status"] . '</td>
						<td class="text-center">' . $is_temp_saved . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Medical-Technician/View/' . $row["techniciancode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="' . base_url() . 'Medical-Technician/Edit/' . $row["techniciancode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function driverdb_filter($page,$status,$distcode){
			$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
					$wc[] = "status='Active'";
				}
				break;
		}
		if ($status != "0") {
			$wc[] = "status = '$status' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "driverdb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from driverdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  ORDER BY driverdb.drivercode LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!= NULL){
			$i = $startpoint;
			$resultJson = array();
			$tbody = '';
			foreach ($result as $row) {
				$is_temp_saved = $row["is_temp_saved"] == '0' ? 'Submitted' : 'Not Submitted';
				$i++;
				$tbody .= '<tr>
                            <td class="text-center">' . $i . '</td>                            
							<td class="text-left">' . $row["drivername"] . '</td>
							<td class="text-center">' . $row["drivercode"] . '</td>
							<td class="text-center">' . $row["nic"] . '</td>							
							<td class="text-left">' . $row["district"] . '</td>
							<td class="text-center">' . $row["status"] . '</td>
							<td class="text-left">' . $is_temp_saved . '</td>';
							
               if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Driver/View/' . $row["drivercode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="' . base_url() . 'Driver/Edit/' . $row["drivercode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}

	/*public function driverdb_filter($page, $distcode, $tcode, $uncode, $facode, $supervisorcode, $status, $fatype) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		if($distcode > 0){}	else{
			if($this -> session -> District){
				$distcode = $this -> session -> District;
			}else{
				$distcode = 0;
			}
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode,$facode);
		if ($tcode != 0) {
			$wc[] = "tcode = '$tcode' ";
		}
		if ($facode != 0) {
			$wc[] = "facode = '$facode' ";
		}
		if ($uncode != 0) {
			$wc[] = "uncode = '$uncode' ";
		}
		if ($supervisorcode != 0) {
			$wc[] = "supervisorcode = '$supervisorcode' ";
		}
		if ($status != "0") {
			$wc[] = "status = '$status' ";
		}
		if ($fatype != "0") {
			$wc[] = "facilitytype(facode) = '$fatype' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "driverdb ";
		// Change `records` according to your table name.
		$query = "select drivername,drivercode,nic,status, facilitytype(facode) as facilitytype, districtname(distcode) as district from driverdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                            <td class="text-center">' . $i . '</td>                            
							<td class="text-left">' . $row["drivername"] . '</td>
							<td class="text-left">' . $row["drivercode"] . '</td>
							<td class="text-center">' . $row["nic"] . '</td>							
							<td class="text-center">' . $row["district"] . '</td>
							<td class="text-center">' . $row["status"] . '</td>';
               if (($_SESSION['UserLevel']=='2') && ($this -> session -> utype=='Manager') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Driver/View/' . $row["drivercode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="' . base_url() . 'Driver/Edit/' . $row["drivercode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}*/
	public function driverdb_filter_cnic($cnic) {

		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic != '' ){
		   $wc[] = "nic like '%$nic%' OR drivername like '%$nic%' OR fathername like '%$nic%' OR drivercode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "driverdb ";
		// Change `records` according to your table name.
		//$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from supervisordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$query = "select *, supervisorname(supervisorcode) as supervisorname, fathername, facilitytype(facode) as facilitytype, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) from driverdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  LIMIT {$per_page} OFFSET {$startpoint} ";
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
							<td class="text-left">' . $row["drivername"] . '</td>
							<td class="text-center">' . $row["drivercode"] . '</td>
							<td class="text-center">' . $row["nic"] . '</td>							
							<td class="text-left">' . $row["district"] . '</td>
							<td class="text-center">' . $row["status"] . '</td>
							<td class="text-left">' . $is_temp_saved . '</td>';
							
               if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Driver/View/' . $row["drivercode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="' . base_url() . 'Driver/Edit/' . $row["drivercode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function getFacitityLhs($facode) {
		$district = $_SESSION['District'];
		$query = "select * from supervisordb where facode = '$facode' ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""></option>';
		foreach ($result as $supervisordata) {
			$data .= '<option value="' . $supervisordata['supervisorcode'] . '">' . $supervisordata['supervisorname'] . '</option>';
		}
		return $data;
	}
	public function getFacilities() {
		$module = isset($_REQUEST['module']) ? $_REQUEST['module'] : "all";
		$fmonth = isset($_REQUEST['fmonth']) ? $_REQUEST['fmonth'] : date('Y-m', strtotime('first day of previous month'));
		$wc = "";
		switch ($module) {
			case 'disease_surveillance':
				$wc = " hf_type='e' and is_ds_fac='1'";
				break;
			case 'vaccine':
				$wc = " hf_type='e' and is_vacc_fac ='1' and getfstatus_vacc('$fmonth',facode::text)='F'";
				break;
			default:
				$wc = " hf_type='e'";
				break;
		}
		$query = "select * from facilities where $wc ";
		if (isset($_REQUEST['distcode'])) {
			$distcode = $_REQUEST['distcode'];
			$query = "select facode,fac_name from facilities where distcode = '$distcode' and $wc order by fac_name ASC";
		}
		if (isset($_REQUEST['tcode'])) {
			$tcode = $_REQUEST['tcode'];
			$query = "select facode,fac_name from facilities where tcode = '$tcode' and $wc order by fac_name ASC";
		}
		if (isset($_REQUEST['uncode'])) {
			$uncode = $_REQUEST['uncode'];
			$query = "select facode,fac_name from facilities where uncode = '$uncode' and $wc order by fac_name ASC";
		}
		
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="0">--Select--</option>';//<option value="">--Select Facility--</option>
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['fac_name'] . '</option>';
		}
		return $data;
	}
	public function getFacilitiesforYear($year) {
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
	public function getFacility_Record($year,$facode){
		$query="SELECT area_name, category, priority, tcode as tcode, tehsilname(tcode) as th_name, uncode as uncode, unname(uncode) as uc_name FROM situation_analysis_db where year = '$year' and facode = '$facode' order by priority ASC";
		$resultAR=$this-> db-> query($query);
		$resultFLCF = $resultAR-> result_array();
		
		// $resultJson = array();
		// $resultJson['area_name'] = $resultFLCF['area_name'];
		// $resultJson['category'] = $resultFLCF['category'];
		// $resultJson['tcode'] = $resultFLCF['tcode'];
		// $resultJson['th_name'] = $resultFLCF['th_name'];
		// $resultJson['uncode'] = $resultFLCF['uncode'];
		// $resultJson['uc_name'] = $resultFLCF['uc_name'];
		// return json_encode($resultJson);
		return json_encode($resultFLCF,true);
	}
	public function getIncharge() {
		$facode = $_REQUEST['facode'];
		$query = "select technicianname as incharge,catch_area_name as designation from med_techniciandb where facode='$facode' And status='Active'  ";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		return json_encode($result);
	}
	public function getSupervisor () {
		$supervisor_type = $_REQUEST['supervisor_type'];
		$distcode = $this->session->District;
		$query = "select supervisorcode as supervisorcode, supervisorname as supervisor  from supervisordb where  distcode='$distcode' And supervisor_type='$supervisor_type' AND status in ('Active','post') ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();	
	    $data = '<option value="">--Select--</option>';
		foreach ($result as $sup_data) {
			$data .= '<option value="' . $sup_data['supervisorcode'] . '">' . $sup_data['supervisor'] . '</option>';
		}
		return $data;
	}
	public function getVccname() {
		$facode = $_REQUEST['facode'];
		$query="select array_to_string(array_agg(technicianname), ', ') as technicianname FROM techniciandb where facode='$facode' AND status='Active'";
		//$query = "select array_agg(technicianname), techniciancode from techniciandb where  facode='$facode' ";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		//print_r($result);exit;
		return json_encode($result);
	}
	public function getTargetChildern() {
		$year = $_REQUEST['year'];
		$facode = $_REQUEST['facode'];
		//$query = "select population from facilities_population where  facode='$facode' AND year='$year' ";
		$query = "select population ,get_indicator_periodic_multiplier('newborn','$year') as newborn, get_indicator_periodic_multiplier('plwomen','$year') as plwomen from facilities_population where  facode='$facode' AND year='$year' ";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$total_population = $result['population'];
		$newborn = $result['newborn'];
		$plwomen = $result['plwomen'];
		//$Yearly_new_Born = ($total_population * 3.533 )/100;
		$Yearly_new_Born = ($total_population * $newborn )/100;
		$Monthly_new_Born = ($Yearly_new_Born)/12;
		//$Yearly_PregnantW = ($Yearly_new_Born * 1.02);
		$Yearly_PregnantW = ($Yearly_new_Born * $plwomen);
		$monthly_PregnantW = round($Yearly_PregnantW/12);
		$result['monthly_PregnantW'] = $monthly_PregnantW; 
		$Monthly_new_Born = round($Monthly_new_Born);
		$result['male'] = round(($Monthly_new_Born/100)*51);//as decided by epi team male ratio is 51%
		$result['female'] = round(($Monthly_new_Born/100)*49);//as decided by epi team female ratio is 49%
		return json_encode($result);
	}

	public function getTehsils() {
       if($this -> session -> UserLevel==4){
			$wc[] = "tcode ='".$this->session->Tehsil ."' ";
		}
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
			$query = "select * from tehsil where distcode = '$distcode'   ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )."  order by tehsil asc ";
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
	public function getFacilitiesTHS() {
		$tcode = $this -> input -> post('tcode');
		$distcode = $this -> input -> post('distcode');
		$facode = $this -> input -> post('facode');
		$query = "select * from facilities where  hf_type='e' ";
		if ($tcode && $tcode != "0") {
			$query = "select * from facilities where tcode = '$tcode' and hf_type='e' ";
		}
		if ($distcode && $distcode != "0") {
			$query = "select * from facilities where distcode = '$distcode' and hf_type='e' ";
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
		$query = "select uncode,un_name from unioncouncil where tcode = '$tcode' order by un_name ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $unc_data) {
			$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['un_name'] . '</option>';
		}
		return $data;
	}
	public function getDistUnC($disttcode) {
		$query = "select * from unioncouncil where disttcode = '$disttcode' ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""></option>';
		foreach ($result as $unc_data) {
			$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['un_name'] . '</option>';
		}
		return $data;
	}
	public function facility_filter($page, $tcode, $fatype, $distcode=NULL) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		if ($fatype != "0") {
			$wc[] = " fatype = '$fatype' ";
		}

		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($distcode != 0) {
			$wc[] = " distcode = '$distcode' ";
		}
		$wc[] = " hf_type = 'e' ";
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		$statement = "facilities";
		$fmonth = date('Y-m');
		$curr_date = date('Y-m-d');
		$q = "SELECT epi_week_numb FROM epi_weeks WHERE date_from <='$curr_date' ORDER BY epi_week_numb DESC LIMIT 1";
		$result = $this ->db->query($q)->row();
		$fweek = date('Y').'-'.sprintf("%02d", $result->epi_week_numb);
		// Change `records` according to your table name.
		$query = "SELECT *,fac_name, fatype, catchment_area_pop, getfstatus_vacc('$fmonth', facode) as vacc_status, getfstatus_ds('$fweek', facode) as ds_status, is_vacc_fac, is_ds_fac, unname(uncode) as unioncouncil, tehsilname(tcode) as tehsil,districtname(distcode) as district, (select count(facode) from techniciandb where techniciandb.facode=facilities.facode) as total_technicians, areatype  from facilities " . (empty($wc) ? ' WHERE ' : ' WHERE ' . implode(" AND ", $wc) ) . " order by facilities.fac_name LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$tick = '<span style="color: green;"><strong>&#10004</strong></span>';
        $cross = '<span style="color: red;"><strong>&#10006</strong></span>';
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			    $facode= $row['facode'];
			    $total_technicians= isset($row['total_technicians'])? $row['total_technicians']: '0';
			   	$supervisornames=isset($row['supervisor_names'])?$row['supervisor_names'] :'-' ;
             	$query="select sum(catch_area_pop) as catch_area_pop from techniciandb where facode='$facode'";
                      $catch=$this->db->query($query);
                      $catch_pop=$catch->row_array();
                      $catch_pop['catch_area_pop']=isset($catch_pop['catch_area_pop']) ? $catch_pop['catch_area_pop'] : '0';
				$i++;
				$tbody .= '<tr>
						   <td class="text-center">' . $i . '</td>
						   <td class="text-left">' . $row['fac_name'] . '</td>
						   <td class="text-left">' . $row['fatype'] . '</td>
						   <td class="text-center">' . $row['facode'] . '</td>
						   <td class="text-left">' . ucwords($row['areatype']) . '</td>
						   <td class="text-left">' . $row['unioncouncil'] . '</td>						   
						   <td class="text-left">' . $row['tehsil'] . '</td>
						   <td class="text-center">' . $row['ds_status'] . '<a href="' . base_url() . 'Status/View/' . $row["facode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
						   </td>
						   <td class="text-center">' . $row['vacc_status'] . '<a href="' . base_url() . 'Status/View/' . $row["facode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
						   </td>
						   <td class="text-center">' . ($row['is_ds_fac']? $tick: $cross) . '</td>
						   <td class="text-center">' . ($row['is_vacc_fac']? $tick: $cross) . '</td>
						   <td class="text-center">' . $total_technicians . '</td>';
						    if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){
						    $tbody .= '<td class="text-center" >
						        <a href="' . base_url() . 'System_setup/flcf_add?facode=' . $row["facode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
						        <a href="' . base_url() . 'System_setup/flcf_view?facode=' . $row["facode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
						        </td>';
		}
            $tbody .= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function mark_facility_filter($tcode,$fatype) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		$data['UserLevel'] = $UserLevel;
		if ($fatype != "0") {
			$wc[] = " fatype = '$fatype' ";
		}
		if ($tcode != '0') {
			$wc[] = " tcode = '$tcode' ";
		}
		$query = "SELECT *, tehsilname(tcode) as tehsil,districtname(distcode) as district , (select count(facode) from techniciandb where techniciandb.facode=facilities.facode) as total_technicians, (select array_to_string(array_agg(supervisorname), ',') from supervisordb where supervisordb.facode=facilities.facode) as supervisor_names from facilities " . (empty($wc) ? ' WHERE ' : ' WHERE ' . implode(" AND ", $wc));
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			if ($row['hf_type'] == 'e') {
				$checked = 'checked="checked"';
			} else {
				$checked = "";
			}
			 $total_technicians= isset($row['total_technicians'])? $row['total_technicians']: '0';
 			$facode= $row['facode'];
 			$supervisornames=isset($row['supervisor_names'])?$row['supervisor_names'] :'-' ;
             $query="select sum(catch_area_pop) as catch_area_pop from techniciandb where facode='$facode'";
                      $catch=$this->db->query($query);
                      $catch_pop=$catch->row_array();
                      $catch_pop['catch_area_pop']=isset($catch_pop['catch_area_pop']) ? $catch_pop['catch_area_pop'] : '0';
			$tbody .= '<tr>
		   <td class="text-center">' . $i . '</td>
		   <td class="text-center">' . $row['facode'] . '</td>
		   <td class="text-center">' . $row['fac_name'] . '</td>
		   <td class="text-center">' . $row['district'] . '</td>
		   <td class="text-center">' . $row['tehsil'] . '</td>
		   <td class="text-center">' . $row['fatype'] . '</td>
		   <td class="text-center">' . $row['catchment_area_pop'] . '</td>
		   <td class="text-center">' . $catch_pop['catch_area_pop'] .'</td>		   
		   <td class="text-center">' . $total_technicians . '</td>
		    <td class="text-center" >
		    <input type="checkbox" name="flcflist[]" value="' . $row["facode"] . '"' . $checked . '/>
		       </td>
            </tr>';
			}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		//$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function checkCodes($spcode,$cocode,$hrcode,$supervisornewcode, $supervisorcode, $techniciancode, $facodew, $distcodedriver, $distcodeas,$distcodeco,$distcodeccm,$distcodego,$distcodecco,$distcodecct,$facodecct,$chkdsocode,$dsocode,$chkcctcode,$cctcode,$chkccmcode,$ccmcode, $chkccgcode,$ccgcode, $chkccdcode,$ccdcode, $facodem,$deodcode,$skdcode,$mfpcode) {
		$district = $this -> session -> District;
		$distcode;
			//startdistrictcode
			if ($spcode > 0) {
			$query = "Select max(supervisorcode) as supervisorcode from supervisordb WHERE supervisorcode like '$spcode%'  HAVING max(supervisorcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);  exit;
			if ($result -> num_rows() > 0) {
				$supervisorDataNewData = $result -> row_array();
				$newCode = $supervisorDataNewData['supervisorcode'] + 1;
				//echo $newCode; exit;
				$newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
			# code...
		}
		//enddistrictcode
		//startdistrictcode
			if ($cocode > 0) {
			$query = "Select max(cocode) as cocode from codb WHERE cocode like '$cocode%' HAVING max(cocode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);  exit;
			if ($result -> num_rows() > 0) {
				$coDataNewData = $result -> row_array();
				$newCode = $coDataNewData['cocode'] + 1;
				//echo $newCode; exit;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
			# code...
		}
		//enddistrictcode
		if ($supervisorcode > 0) {
			$query = "Select * from supervisordb WHERE supervisorcode = '$supervisorcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($supervisornewcode > 0) {
			$query = "Select max(supervisorcode) as supervisor from supervisordb WHERE supervisorcode like '$supervisornewcode%'  HAVING max(supervisorcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$supervisordata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $supervisordata['supervisor'] + 1;
				$newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
			# code...
		}
		if ($techniciancode > 0) {
			$query = "Select * from techniciandb WHERE techniciancode = '$techniciancode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($facodew > 0) {
			//echo $facodew ;
			$query = "Select max(techniciancode) as technician from techniciandb WHERE techniciancode like '$facodew%' HAVING max(techniciancode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$techniciandata = $result -> row_array();
				$newCode = $techniciandata['technician'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
		}
if ($facodecct > 0) {
			//echo $facodew ;
			$query = "Select max(cc_techniciancode) as technician from cc_techniciandb WHERE cc_techniciancode like '$facodecct%' HAVING max(cc_techniciancode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$techniciandata = $result -> row_array();
				$newCode = $techniciandata['technician'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
		}
		if ($facodem > 0) {
			//echo $facodem ;
			$query = "Select max(techniciancode) as technician from med_techniciandb WHERE techniciancode like '$facodem%' HAVING max(techniciancode) is not null ";
			$result = $this -> db -> query($query);
			//print_r($result -> row_array());
			if ($result -> num_rows() > 0) {
				$techniciandata = $result -> row_array();
				$newCode = $techniciandata['technician'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			} 
		}
		if ($distcodedriver > 0) {
			//echo $facodew ;
			$query = "Select max(drivercode) as code from driverdb WHERE drivercode like '$distcodedriver%' HAVING max(drivercode) is not null  ";
			$result = $this -> db -> query($query);
			if ($result != NULL && $result -> num_rows() > 0)  {
				$driverdata = $result -> row_array();
				$newCode = $driverdata['code'] + 1;
				$newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
		}
		if ($distcodeas > 0) {
			//echo $facodew ;
			$query = "Select max(ascode) as code from asdb WHERE ascode like '$distcodeas%' HAVING max(ascode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$asdata = $result -> row_array();
				$newCode = $asdata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
		if ($distcodeco > 0) {
			//echo $facodew ;
			$query = "Select max(cocode) as code from codb WHERE cocode like '$distcodeco%' HAVING max(cocode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$codata = $result -> row_array();
				$newCode = $codata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
if ($distcodeccm > 0) {
			//echo $facodew ;
			$query = "Select max(ccm_code) as code from cc_mechanic WHERE ccm_code like '$distcodeccm%' HAVING max(ccm_code) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$codata = $result -> row_array();
				$newCode = $codata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
		if ($distcodego > 0) {
			//echo $facodew ;
			$query = "Select max(go_code) as code from go_db WHERE go_code like '$distcodego%' HAVING max(go_code) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$codata = $result -> row_array();
				$newCode = $codata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
		if ($distcodecco > 0) {
			//echo $facodew ;
			$query = "Select max(cco_code) as code from cco_db WHERE cco_code like '$distcodecco%' HAVING max(cco_code) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$codata = $result -> row_array();
				$newCode = $codata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
	if ($distcodecct > 0) {
			//echo $facodew ;
			$query = "Select max(cc_techniciancode) as code from cc_techniciandb WHERE cc_techniciancode like '$distcodecct%' HAVING max(cc_techniciancode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$codata = $result -> row_array();
				$newCode = $codata['code'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
		}
		
		if ($chkdsocode > 0) {
			$procode='3';
			$newhrcode=$procode.$chkdsocode;
			$query = "Select * from dsodb WHERE dsocode = '$newdsocode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($dsocode > 0) {
			$procode='3';
			$newdsocode=$procode.$dsocode;
			$query = "Select max(dsocode) as dsocode from dsodb WHERE dsocode like '$newdsocode%'  HAVING max(dsocode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$dsodata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $dsodata['dsocode'] + 1;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
			# code...
		}
/* 		//addhrcode
		if ($chkhrcode > 0) {
			$procode='3';
			$newhrcode=$procode.$chkhrcode;
			print_r($newhrcode); exit;
			$query = "Select * from hrdb WHERE hrcode = '$newhrcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		} */
		if ($hrcode > 0) {
			//$procode='3';
		/* 	$newhrcode=$procode.$hrcode; */
			$query = "Select max(hrcode) as hrcode from hrdb WHERE hrcode like '$hrcode%'  HAVING max(hrcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);  exit;
			if ($result -> num_rows() > 0) {
				$hrdata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $hrdata['hrcode'] + 1;
				//echo $newCode; exit;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
			# code...
		}
		//endaddhrcode
		
		
		if ($chkcctcode > 0) {
			$procode='3';
			$newcctcode=$procode.$chkcctcode;
			$query = "Select * from cctdb WHERE cctcode = '$newcctcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($cctcode > 0) {
			$procode='3';
			$newcctcode=$procode.$cctcode;
			$query = "Select max(cctcode) as cctcode from cctdb WHERE cctcode like '$newcctcode%'  HAVING max(cctcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$cctdata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $cctdata['cctcode'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
			# code...
		}
		if ($chkccmcode > 0) {
			$procode='3';
			$newccmcode=$procode.$chkccmcode;
			$query = "Select * from ccmdb WHERE ccmcode = '$newccmcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($ccmcode > 0) {
			$procode='3';
			$newccmcode=$procode.$ccmcode;
			$query = "Select max(ccmcode) as ccmcode from ccmdb WHERE ccmcode like '$newccmcode%'  HAVING max(ccmcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$ccmdata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $ccmdata['ccmcode'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
			# code...
		}
		if ($chkccgcode > 0) {
			$procode='3';
			$newccgcode=$procode.$chkccgcode;
			$query = "Select * from ccgdb WHERE ccgcode = '$newccgcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($ccgcode > 0) {
			$procode='3';
			$newccgcode=$procode.$ccgcode;
			$query = "Select max(ccgcode) as ccgcode from ccgdb WHERE ccgcode like '$newccgcode%'  HAVING max(ccgcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$ccgdata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $ccgdata['ccgcode'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
			# code...
		}
		if ($chkccdcode > 0) {
			$procode='3';
			$newccdcode=$procode.$chkccdcode;
			$query = "Select * from ccddb WHERE ccdcode = '$newccdcode'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				echo '1';
			} else {
				echo '0';
			}
		}
		if ($deodcode > 0) {
			//echo $facodew ;
			$query = "Select max(deocode) as code from deodb WHERE deocode like '$deodcode%' HAVING max(deocode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$deodata = $result -> row_array();
				$newCode = $deodata['code'] + 1;
				$newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
			
		}
		//skdata
		if ($skdcode > 0) {
			//echo $facodew ;
			$query = "Select max(skcode) as code from skdb WHERE skcode like '$skdcode%' HAVING max(skcode) is not null ";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$skdata = $result -> row_array();
				$newCode = $skdata['code'] + 1;
				$newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
			
		}
		//end
		if ($ccdcode > 0) {
			$procode='3';
			$newccdcode=$procode.$ccdcode;
			$query = "Select max(ccdcode) as ccdcode from ccddb WHERE ccdcode like '$newccdcode%'  HAVING max(ccdcode) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$ccddata = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $ccddata['ccdcode'] + 1;
				$newCode = substr($newCode, -3);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else {
				echo "001";
			}
			# code...
		}
		if ($mfpcode > 0) {
			$query = "Select max(mfpcode) as mfpcode from mfpdb WHERE mfpcode like '$mfpcode%'  HAVING max(mfpcode) is not null ";
			//echo $query; 
			$result = $this -> db -> query($query);
			//var_dump($result);  exit;
			if ($result -> num_rows() > 0) {
				$mfpDataNewData = $result -> row_array();
				$newCode = $mfpDataNewData['mfpcode'] + 1;
				//echo $newCode; exit;
				$newCode = substr($newCode, -2);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '01';
				}
			} else {
				echo "01";
			}
			# code...
		}
		//enddistrictcode
	}
	
	public function checkdeoNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM deodb WHERE nic='".$nic."' AND cocode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM deodb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function generateCode($distcode) {
		if ($distcode > 0) {
			$query = "Select max(facode) as fsc from facilities WHERE distcode like '$distcode%'";
			$result = $this -> db -> query($query);
			if ($result -> num_rows() > 0) {
				$dict = $result -> row_array();
				$newCode = $dict['fsc'] + 1;
				$newCode2 = substr($newCode, 0, 6);
				if ($newCode2 != NULL) {
					echo $newCode;
				} else {
					echo '001';
				}
			} else { //if no facility exists in database
				// $threedigits = "001";
				// $newCode = $distcode."-".$threedigits;
				echo "here001";
			}
		}
	}
	public function flcfmr_filter($facode, $distcode, $fmonth, $fatype) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		array_walk($wc, function(&$value, $key) {
			$value = "flcfmr." . $value;
		});
		if ($fmonth != "0") {
			$wc[] = "flcfmr.fmonth = '$fmonth' ";
		}
		if ($facode != 0) {
			$wc[] = " facilities.facode = '$facode' ";
		}
		if ($fatype != "0") {
			$wc[] = " facilities.fatype = '$fatype' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "flcfmr  ";
		// Change `records` according to your table name.
		$query = "select facilities.fatype as facilitytype, flcfmr.facode, facilityname(flcfmr.facode) as facilityname, fmonth from flcfmr,facilities  " . (empty($wc) ? ' WHERE ' : ' WHERE ' . implode(" AND ", $wc) . " AND ") . "  facilities.facode = flcfmr.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
		    <td class="text-center">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['facilitytype'] . '</td>
		    <td class="text-center">' . $row['fmonth'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/flcfmr_view/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/flcfmr_edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		      <a href="' . base_url() . 'Data_entry/flcfmr_delete/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	
	public function deodb_filter($page,$status,$distcode,$name){
	
	  $cnic= ltrim($name);
		$nic=str_ireplace("%20"," ",$cnic); 
			$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
					$wc[] = "status='Active'";
				}
				break;
		}
		if ($status != "0" && $status != '' && $status=="Active") {
			$wc[] = "status = '$status' ";
		}
		else if($status=="Active-Temp"){
		$wc[]="status = 'Active' ";
		$wc[] = "current_status = 'Temporary-Post' ";
		}
		else if($status=="0"){
	  //no where of status Columns
		}
		
		else{
		$wc[] = "status = '$status' ";	
		}
		if ($name != "") {
			$wc[] = "deoname = '$nic' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "deodb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from deodb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  ORDER BY deodb.deocode LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!= NULL){
			$i = $startpoint;
			$resultJson = array();
			$tbody = '';
			foreach ($result as $row) {
				$is_temp_saved = $row["is_temp_saved"] == '0' ? 'Submitted' : 'Not Submitted';
				$i++;
				$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["deoname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'DataEntry-Operator/View/' . $row["deocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'DataEntry-Operator/Edit/' . $row["deocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}		
		/* public function checkskNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM skdb WHERE nic='".$nic."' AND skcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM skdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	} */
	public function checkskNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM skdb WHERE nic='".$nic."' AND skcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM skdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
		//skdb
		public function skdb_filter_cnic($cnic){
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] //: $_SESSION['District'];
		$wc = array();
		//$distcode=$this->session->district;
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					
				}
				break;
		}
		if($nic != '' || $nic != 0 ){
		   $wc[] = "(nic like '%$nic%' OR skname like '%$nic%' OR fathername like '%$nic%' OR skcode like '%$nic%')";
		}
		//print_r($wc);exit();
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "skdb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from skdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by skdb.skcode";
	//print_r($query);exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);exit();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["skname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='2') && ($utype=='Manager') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'Store-keeper/View/' . $row["skcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'Store-keeper/Edit/' . $row["skcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		//print_r($resultJson);exit();
		// displaying paginaiton.
	$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		//print_r($resultJson['paging']);exit();
		return json_encode($resultJson);
		}
		
	//deodb
		public function deodb_filter_cnic($cnic){
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$distcode=$this->session->district;
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					
				}
				break;
		}
		if($nic != '' || $nic != 0 ){
		   $wc[] = "(nic like '%$nic%' OR deoname like '%$nic%' OR fathername like '%$nic%' OR deocode like '%$nic%') ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "deodb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from deodb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by deodb.deocode";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["deoname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='2') && ($utype=='Manager') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'DataEntry-Operator/View/' . $row["deocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'DataEntry-Operator/Edit/' . $row["deocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}
	
	public function lhwmr_filter($facode, $fmonth) {
		$procode = ($this -> input -> post('procode')) ? $this -> input -> post('procode') : $_SESSION['Province'];
		$distcode = ($this -> input -> post('distcode')) ? $this -> input -> post('distcode') : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($fmonth != "0") {
			$wc[] = "fmonth = '$fmonth' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "lhwmr ";
		// Change `records` according to your table name.
		$query = "select techniciancode, technicianname(techniciancode) as technicianname, facode, facilityname(facode) as facilityname, fmonth, unname(uncode) as unioncouncil from lhwmr  " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by fmonth desc, facode  LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		               <td class="text-center">' . $i . '</td>
		               <td class="text-center">' . $row['techniciancode'] . '</td>
		               <td class="text-center">' . $row['technicianname'] . '</td>
		               <td class="text-center">' . $row['facode'] . '</td>
		               <td class="text-center">' . $row['facilityname'] . '</td>
		               <td class="text-center">' . $row['unioncouncil'] . '</td>
		               <td class="text-center">' . $row['fmonth'] . '</td>
		               <td class="text-center">
		                     <a href="' . base_url() . 'Data_entry/lhwmr_view/' . $row['techniciancode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		                     <a href="' . base_url() . 'Data_entry/lhwmr_edit/' . $row['techniciancode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		                     <a href="' . base_url() . 'Data_entry/lhwmr_delete/' . $row['techniciancode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
		               </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function getLhwData($techniciancode) {
		$quer = "SELECT facode,tcode,uncode,catch_area_pop from techniciandb WHERE techniciancode = '$techniciancode'";
		$result = $this -> db -> query($quer);
		$techniciandata = $result -> row_array();
		$resultJson = array();
		$resultJson['tcode'] = $techniciandata['tcode'];
		$resultJson['uncode'] = $techniciandata['uncode'];
		$resultJson['facode'] = $techniciandata['facode'];
		$resultJson['catchM'] = $techniciandata['catch_area_pop'];
		return json_encode($resultJson);
	}
	public function getFacilityLHW($facode, $tcode) {
		$district = $_SESSION['District'];
		$query = "select * from techniciandb where facode = '$facode' ";
		if ($tcode != '') {
			$query = "select * from techniciandb where tcode = '$tcode' ";
		}
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value=""></option>';
		foreach ($result as $techniciandata) {
			$data .= '<option value="' . $techniciandata['techniciancode'] . '">' . $techniciandata['technicianname'] . ' - ' . $techniciandata['techniciancode'] . '</option>';
		}
		return $data;
	}
	public function dmr_filter($facode, $fmonth, $distcode) {
		$procode = ($this -> input -> post('procode')) ? $this -> input -> post('procode') : $_SESSION['Province'];
		$distcode = ($this -> input -> post('distcode')) ? $this -> input -> post('distcode') : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($fmonth != "0") {
			$wc[] = "fmonth = '$fmonth' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "dmr ";
		// Change `records` according to your table name.
		$query = "select distcode, districtname(distcode) as districtname, fmonth from dmr  " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by fmonth, distcode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		              <tr>
		              <td class="text-center">' . $i . '</td>
		              <td class="text-center">' . $row['distcode'] . '</td>
		              <td class="text-center">' . $row['districtname'] . '</td>
		              <td class="text-center">' . $row['fmonth'] . '</td>
		              <td class="text-center">
		                  <a href="' . base_url() . 'Data_entry/dmr_view/' . $row['distcode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		              </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		echo json_encode($resultJson);
	}
	public function change_password() {
		$oldPassword = $_REQUEST['oldpassword'];
		$oldPassword = md5($oldPassword);
		$newPassword = $_REQUEST['newpassword'];
		$reNewpassword = $_REQUEST['repeatnewpassword'];
		$userName = $_REQUEST['username'];
		$query = "SELECT username,password FROM epiusers WHERE username='$userName' and password='$oldPassword'";
		$result = $this -> db -> query($query);
		$row = $result -> row_array();
		$passwordDb = $row['password'];
		//if($newPassword){}
		if ($oldPassword == $passwordDb) {
			if ($newPassword == $reNewpassword) {
				$newPassword = md5($newPassword);
				$reNewpassword = md5($reNewpassword);
				$sql = "UPDATE epiusers SET password='" . $newPassword . "' WHERE username='$userName'";
				$result = $this -> db -> query($sql);
				if ($result == true) {
					return "Password Updated!";
				} else {
					return "Error While Updating Password!";
				}
			} else {
				return "Confirm Password does not match!";
			}
		} else {
			return "You Entered Wrong Old Password";
		}
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
		/* echo $statement;
    	 echo "<br>".$per_page;
         echo "<br>".$page;
         echo "<br>".$url."<br>";
         print_r($wc);
         exit();*/
		// displaying paginaiton.
        //$wc=str_replace('facilities', 'flcfmr', $wc);
		/*$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc)." AND  facilities.facode = flcfmr.facode");
		*/
		//$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc)." AND  facilities.facode = flcf_vacc_mr.facode");
		$w=implode(" AND ", $wc)." AND  facilities.facode = flcf_vacc_mr.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}	
	public function fmvrf_filter($facode, $distcode, $year,$month,$techname,$uncode) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "flcf_vacc_mr." . $value;
		});
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		if ($techname != "0") {
			$wc[] = " flcf_vacc_mr.vacc_name = '$techname' ";
		}
		if ($uncode != "0") {
			$wc[] = " flcf_vacc_mr.uncode = '$uncode' ";
		}
		if ($facode != 0) {
			$wc[] = " facilities.facode = '$facode' ";
		}
		//Code for Pagination Updated by zohaib
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "flcf_vacc_mr,facilities ";
		// Change `records` according to your table name.
		$query="select flcf_vacc_mr.vacc_name, flcf_vacc_mr.uncode, facilities.fatype as facilitytype, flcf_vacc_mr.facode, facilityname(flcf_vacc_mr.facode) as facilityname, fmonth from flcf_vacc_mr,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = flcf_vacc_mr.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>		    
		    <td class="text-left">' . $row['facilityname'] . '</td>
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
		/*echo $statement;
		echo '----'.$per_page;
		echo '----'.$page; 
		exit();*/
		$w=implode(" AND ", $wc)." AND  facilities.facode = flcf_vacc_mr.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	public function findParam($facode, $distcode, $fmonth, $fatype, $findParam){
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "fac_mvrf_db." . $value;
		});
		if (is_numeric($findParam)) { 
			$wc[] ="fac_mvrf_db.facode LIKE '%$findParam%'";
		}else{
		$findParam=ucwords($findParam);
		$wc[] =" facilityname(fac_mvrf_db.facode) LIKE '%$findParam%'";
	    }
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "fac_mvrf_db,facilities ";
		// Change `records` according to your table name.
		$query="select facilities.fatype as facilitytype, fac_mvrf_db.facode, fac_mvrf_db.vacc_name,fac_mvrf_db.uncode, facilityname(fac_mvrf_db.facode) as facilityname, fmonth from fac_mvrf_db,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = fac_mvrf_db.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$i++;
				$tbody .= '<tr>
			    <td class="text-center">' . $i . '</td>		   
			    <td class="text-left">' . $row['facilityname'] . '</td>
			    <td class="text-center">' . $row['facilitytype'] . '</td>
			    <td class="text-center">' . $row['facode'] . '</td>
				<td class="text-left">' . $row['vacc_name'] . '</td>
				<td class="text-left">' . get_UC_Name($row['uncode']) . '</td>
			    <td class="text-center">' . $row['fmonth'] . '</td>
			    <td class="text-center">
			      <a href="' . base_url() . 'FLCF-MVRF/View/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			      <a href="' . base_url() . 'FLCF-MVRF/Edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
			      
			  </td>
			            </tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc)." AND  facilities.facode = fac_mvrf_db.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	public function fac_mvrf_filter($facode, $distcode, $year,$month,$techname,$uncode) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "fac_mvrf_db." . $value;
		});
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		if ($techname != "0") {
			$wc[] = " fac_mvrf_db.vacc_name = '$techname' ";
		}
		if ($uncode != "0") {
			$wc[] = " fac_mvrf_db.uncode = '$uncode' ";
		}
		if ($facode != 0) {
			$wc[] = " facilities.facode = '$facode' ";
		}
		//Code for Pagination Updated by zohaib
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "fac_mvrf_db,facilities ";
		// Change `records` according to your table name.
		$query="select fac_mvrf_db.vacc_name, fac_mvrf_db.uncode, facilities.fatype as facilitytype, fac_mvrf_db.facode, facilityname(fac_mvrf_db.facode) as facilityname, fmonth from fac_mvrf_db,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = fac_mvrf_db.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$i++;
				$tbody .= '<tr>
			    <td class="text-center">' . $i . '</td>		    
			    <td class="text-left">' . $row['facilityname'] . '</td>
			    <td class="text-center">' . $row['facilitytype'] . '</td>
			    <td class="text-center">' . $row['facode'] . '</td>
				<td class="text-left">' . $row['vacc_name'] . '</td>
				<td class="text-left">' . get_UC_Name($row['uncode']) . '</td>
			    <td class="text-center">' . $row['fmonth'] . '</td>
			    <td class="text-center">
			      <a href="' . base_url() . 'FLCF-MVRF/View/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			      <a href="' . base_url() . 'FLCF-MVRF/Edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
			      
			  </td>
			            </tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		/*echo $statement;
		echo '----'.$per_page;
		echo '----'.$page; 
		exit();*/
		$w=implode(" AND ", $wc)." AND  facilities.facode = fac_mvrf_db.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	
	public function weekly_vpd_filter($facode, $distcode, $year, $week, $case_type) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "weekly_vpd." . $value;
		});
		if ($facode != 0) {
			$wc[] = " facilities.facode = '$facode' ";
		}
		if ($year != "0" && $year != NULL ) {
			$wc[] = "weekly_vpd.year = '$year' ";
		}
		if ($week != "0" && $week != NULL ) {
			$wc[] = "weekly_vpd.week = '$week' ";
		}
		if ($case_type != "0" && $case_type != NULL) {
			$wc[] = " weekly_vpd.case_type = '$case_type' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "weekly_vpd,facilities ";
		// Change `records` according to your table name.
		$query="select recid, facilities.fatype as facilitytype,name_case, weekly_vpd.facode, is_temp_saved,facilityname(weekly_vpd.facode) as facilityname, case_type, year, week, fweek from weekly_vpd,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = weekly_vpd.facode order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
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
			 }else if($row['approval_status'] == "Pending"){
			    $color = "background-color:#d81f1f80;";
			 }else{
			   $color = "";
			 }
			$tbody .= '<tr style="'.$color.'">
		    <td class="text-center">' . $i . '</td>	
			<td class="text-left">' . $row['name_case'] . '</td>			
		    <td class="text-left">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['facilitytype'] . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>';
		    if(isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0 && $row['cross_notified']==1 && $row['cross_notified_from_distcode'] == $this->session->District){
				$districtName = ($row['distcode']>0)?get_District_Name($row['distcode']):'';
			}else{
				$districtName = (isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0)?get_District_Name($row['cross_notified_from_distcode']):'';
			}
			$tbody .= '
			<td class="text-center">' . $districtName . '</td>
			<td class="text-left">' . $row['case_type'] . '</td>
			<td class="text-center">' . $row['fweek'] . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">		      
	 		<a href="' . base_url() . 'Disease-Surveillance/View/' . $row['recid'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
				if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)
				{	$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['recid']:$row['recid'];
					$tbody .= '<a href="' . base_url() . 'Disease-Surveillance/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
				}
		  	$tbody .= '</td>
		  </tr>';
		}
		$resultJson["tbody"] = $tbody;
		/*echo $statement;
		echo '----'.$per_page;
		echo '----'.$page; 
		exit();*/
		$w=implode(" AND ", $wc)." AND  facilities.facode = weekly_vpd.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	//AEFI Portion
	public function aefiSearch($distcode,$tcode,$uncode,$facode,$complaint,$searchParam,$year,$week){
		$distcode = isset($distcode) ? $distcode : $_SESSION['District'];
		$wc = array();
		if($distcode > 0)
		{
			$wc[] = "distcode = '$distcode'";
		}
		if($tcode > 0)
		{
			$wc[] = "tcode = '$tcode'";
		}
		if($uncode > 0)
		{
			$wc[] = "uncode = '$uncode'";
		}
		if($facode > 0)
		{
			$wc[] = "facode = '$facode'";
		}
		if($year != 0)
		{
			$wc[] = "year = '$year'";
		}
		if($week != 0)
		{
			$wc[] = "week = '$week'";
		}
		if($complaint!='')
		{
			$wc[] = "$complaint = 1";
		}
		if(strlen($searchParam)>0 && $searchParam !=' ')
		{
			$wc[] = "(casename like '%$searchParam%' OR vacc_name like '%$searchParam%' OR vacc_vaccinator like '%$searchParam%')";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "aefi_rep ";
		// Change `records` according to your table name.
		$query="select id,casename,age,facilityname(facode) as facilityname,unname(uncode) as unioncouncil,tehsilname(tcode) as tehsilname,		
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
		vacc_name,vacc_vaccinator, is_temp_saved ,fweek,rep_date from aefi_rep ".(empty($wc) ? '' : ' WHERE '. implode(' AND ', $wc))." order by id,uncode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved =  $row['is_temp_saved'] =='0' ? 'Submitted' : '';
			$i++;
			$tbody .= '<tr>
				<td class="text-center">' . $i . '</td>
				<td class="text-left">' . $row['casename'] . '</td>
				<td class="text-center">' . $row['age'] . '</td>
				<td class="text-left">' . $row['facilityname'] . '</td>
				<td class="text-left">' . $row['unioncouncil'] . '</td>
				<td class="text-left">' . $row['tehsilname'] . '</td>
				<td class="text-center">' . $row['complaints'] . '</td>
				<td class="text-left">' . $row['vacc_name'] . '</td>
				<td class="text-left">' . $row['vacc_vaccinator'] . '</td>
				<td class="text-left">' . $row['fweek'] . '</td>
				<td class="text-center">' . date("d-M-Y",strtotime($row['rep_date'])) . '</td>
				<td class="text-left">' . $is_temp_saved . '</td>
				<td class="text-center">
					<a href="' . base_url() . 'AEFI-CIF/View/' . $row['id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
					<a href="' . base_url() . 'AEFI-CIF/Edit/' . $row['id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
				</td>
			</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	//Vacc Consumption Requisition Portion
	public function mangEpiVaccSearch($distcode,$ym,$uncode,$searchParam){
		$distcode = isset($distcode) ? $distcode : $_SESSION['District'];
		$wc = array();
		if($distcode > 0)
		{
			$wc[] = "manage_epi_vacc.distcode = '$distcode'";
		}
		if($uncode > 0)
		{
			$wc[] = "manage_epi_vacc.uncode = '$uncode'";
		}
		if($ym > 0)
		{
			$wc[] = "manage_epi_vacc.fmonth = '$ym'";
		}
		if(strlen($searchParam)>0 && $searchParam !=' ')
		{
			$wc[] = "(unname(manage_epi_vacc.uncode) like '%$searchParam%' OR manage_epi_vacc.uncode like '%$searchParam%' OR manage_epi_vacc.fmonth like '%$searchParam%')";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "manage_epi_vacc,unioncouncil ";
		// Change `records` according to your table name.
		$query="select manage_epi_vacc.uncode, unname(manage_epi_vacc.uncode) as unioncouncilname, fmonth from manage_epi_vacc,unioncouncil ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   unioncouncil.uncode = manage_epi_vacc.uncode order by fmonth, uncode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;exit();
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
		    <td class="text-center">' . $row['unioncouncilname'] . '</td>
		    <td class="text-center">' . $row['fmonth'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/manage_epi_vacc_view/' . $row['uncode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/manage_epi_vacc_edit/' . $row['uncode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		    </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc)." AND  unioncouncil.uncode = manage_epi_vacc.uncode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	//Vacc Consumption Requisition Portion
	public function vaccCrFormSearch($distcode,$ym,$facode,$searchParam){
		$distcode = isset($distcode) ? $distcode : $_SESSION['District'];
		$wc = array();
		if($distcode > 0)
		{
			$wc[] = "vaccine_consumption.distcode = '$distcode'";
		}
		if($facode > 0)
		{
			$wc[] = "vaccine_consumption.facode = '$facode'";
		}
		if($ym > 0)
		{
			$wc[] = "vaccine_consumption.fmonth = '$ym'";
		}
		if(strlen($searchParam)>0 && $searchParam !=' ')
		{
			$wc[] = "(facilityname(vaccine_consumption.facode) like '%$searchParam%' OR vaccine_consumption.facode like '%$searchParam%' OR vaccine_consumption.fmonth like '%$searchParam%')";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "vaccine_consumption,facilities ";
		// Change `records` according to your table name.
		$query="select vaccine_consumption.facode, facilityname(vaccine_consumption.facode) as facilityname, fmonth from vaccine_consumption,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = vaccine_consumption.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
		    <td class="text-center">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['fmonth'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/vacc_cons_req_view/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/vacc_cons_req_edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		    </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc)." AND  facilities.facode = vaccine_consumption.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	//Weekly VPD Portion
	public function weeklyVpdSearch($distcode,$ym,$fatype,$facode,$searchParam){
		$distcode = isset($distcode) ? $distcode : $_SESSION['District'];
		$wc = array();
		if($distcode > 0)
		{
			$wc[] = "weekly_vpd.distcode = '$distcode'";
		}
		if($fatype > 0)
		{
			$wc[] = "facilities.fatype = '$fatype'";
		}
		if($facode > 0)
		{
			$wc[] = "weekly_vpd.facode = '$facode'";
		}
		if($ym > 0)
		{
			$wc[] = "weekly_vpd.fweek = '$ym'";
		}
		if(strlen($searchParam)>0 && $searchParam !=' ')
		{
			$wc[] = "(facilityname(weekly_vpd.facode) like '%$searchParam%' OR weekly_vpd.facode like '%$searchParam%' OR facilities.fatype like '%$searchParam%' OR weekly_vpd.fweek like '%$searchParam%' OR weekly_vpd.name_case like '%$searchParam%')";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "weekly_vpd,facilities ";
		// Change `records` according to your table name.
		$query="select facilities.fatype as facilitytype,is_temp_saved,weekly_vpd.facode, facilityname(weekly_vpd.facode) as facilityname, case_type, name_case,fweek from weekly_vpd,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = weekly_vpd.facode order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>	
			<td class="text-left">' . $row['name_case'] . '</td>			
		    <td class="text-left">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['facilitytype'] . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
			<td class="text-left">' . $row['case_type'] . '</td>
			<td class="text-center">' . $row['fweek'] . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Disease-Surveillance/View/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Disease-Surveillance/Edit/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		    </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc)." AND  facilities.facode = weekly_vpd.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	public function manageEpiVaccmr_filter($uncode, $distcode, $fmonth) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		array_walk($wc, function(&$value, $key) {
			$value = "manage_epi_vacc." . $value;
		});
		if ($fmonth != "0") {
			$wc[] = "manage_epi_vacc.fmonth = '$fmonth' ";
		}
		if ($uncode != 0) {
			$wc[] = " unioncouncil.uncode = '$uncode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "manage_epi_vacc,unioncouncil ";
		// Change `records` according to your table name.
		$query="select manage_epi_vacc.uncode, unname(manage_epi_vacc.uncode) as unioncouncilname, fmonth from manage_epi_vacc,unioncouncil  ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."  unioncouncil.uncode = manage_epi_vacc.uncode order by fmonth, uncode desc LIMIT {$per_page} OFFSET {$startpoint} ";
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
		    <td class="text-center">' . $row['unioncouncilname'] . '</td>
		    <td class="text-center">' . $row['fmonth'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/manage_epi_vacc_view/' . $row['uncode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/manage_epi_vacc_edit/' . $row['uncode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		/* echo $statement;
    	 echo "<br>".$per_page;
         echo "<br>".$page;
         echo "<br>".$url."<br>";
         print_r($wc);
         exit();*/
		// displaying paginaiton.
        //$wc=str_replace('facilities', 'flcfmr', $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc)." AND  unioncouncil.uncode = manage_epi_vacc.uncode");
		return json_encode($resultJson);
	}
	public function vacc_cr_mr_filter($facode, $distcode, $fmonth) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		array_walk($wc, function(&$value, $key) {
			$value = "vaccine_consumption." . $value;
		});
		if ($fmonth != "0") {
			$wc[] = "vaccine_consumption.fmonth = '$fmonth' ";
		}
		if ($facode != 0) {
			$wc[] = " vaccine_consumption.facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "vaccine_consumption,facilities ";
		// Change `records` according to your table name.
		$query="select vaccine_consumption.facode, facilityname(vaccine_consumption.facode) as facilityname, fmonth from vaccine_consumption,facilities  ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."  facilities.facode = vaccine_consumption.facode order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
		    <td class="text-center">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['fmonth'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/vacc_cons_req_view/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/vacc_cons_req_edit/' . $row['facode'] . '/' . $row['fmonth'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		/* echo $statement;
    	 echo "<br>".$per_page;
         echo "<br>".$page;
         echo "<br>".$url."<br>";
         print_r($wc);
         exit();*/
		// displaying paginaiton.
        //$wc=str_replace('facilities', 'flcfmr', $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc)." AND  facilities.facode = vaccine_consumption.facode");
		return json_encode($resultJson);
	}
public function codb_filter($page,$status,$distcode){
			$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
					$wc[] = "status='Active'";
				}
				break;
		}
		if ($status != "0") {
			$wc[] = "status = '$status' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "codb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from codb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  ORDER BY codb.cocode LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!= NULL){
			$i = $startpoint;
			$resultJson = array();
			$tbody = '';
			foreach ($result as $row) {
				$is_temp_saved = $row["is_temp_saved"] == '0' ? 'Submitted' : 'Not Submitted';
				$i++;
				$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["coname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'Computer-Operator/View/' . $row["cocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'Computer-Operator/Edit/' . $row["cocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}
	public function codb_filter_cnic($cnic){
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$distcode=$this->session->district;
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					
				}
				break;
		}
		if($nic != '' || $nic != 0 ){
		   $wc[] = "nic like '%$nic%' OR coname like '%$nic%' OR fathername like '%$nic%' OR cocode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "codb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from codb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by codb.cocode";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["coname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='2') && ($utype=='Manager') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'Computer-Operator/View/' . $row["cocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'Computer-Operator/Edit/' . $row["cocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}
	public function mfpdb_filter_cnic($cnic){
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$distcode=$this->session->district;
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					
				}
				break;
		}
		if($nic != '' || $nic != 0 ){
		   $wc[] = "nic like '%$nic%' OR mfpname like '%$nic%' OR fathername like '%$nic%' OR mfpcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "mfpdb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from mfpdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by mfpdb.mfpcode";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr class="DrilledDown">
	        <td class="text-center" >' . $i . '</td>
	        <td class="text-left" >' . $row["mfpname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>	        
	        <td class="text-left" >' . $row["employee_type"] . '</td>
	        <td class="text-left" >' . $row["district"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
			<td class="text-center" >' . $is_temp_saved . '</td>';
	          if (($_SESSION['UserLevel']=='2') && ($utype=='Manager') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'Measles-Focal-Person/View/' . $row["mfpcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'Measles-Focal-Person/Edit/' . $row["mfpcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}
		
		
	public function checkNICNumber($nic,$code){
		if($code!=''){
			$query = "SELECT nic FROM supervisordb WHERE nic='".$nic."' AND supervisorcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM supervisordb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
		if ($result==true)
		{
			$return = 'yes';
		}
		else
		{
			$return = 'no';
		}		 
		return $return;
	}
	public function checktechNIC($nic,$code){
		if($code!=''){
			$query = "SELECT nic FROM techniciandb WHERE nic='".$nic."' AND techniciancode!='".$code."'"; 
		}else{
			$query = "SELECT nic,phone,status,districtname(distcode) as district,tehsilname (tcode) as tcode,unname (uncode) as uncode,facilityname (facode) as facode,technicianname FROM techniciandb WHERE status='Active' and nic='".$nic."'";
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
		/*if ($result==true)
		{
				 //$return = 'yes';
				 echo json_encode($result) ;
		}
		else
		{
				 echo NULL;
		}*/
		 
			return $result;

	}
		public function checkcctechNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM cc_techniciandb WHERE nic='".$nic."' AND cc_techniciancode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM cc_techniciandb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkCoNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM codb WHERE nic='".$nic."' AND cocode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM codb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
		public function checkMfpNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM mfpdb WHERE nic='".$nic."' AND mfpcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM mfpdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkccoNIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM cco_db WHERE nic='".$nic."' AND cco_code!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM cco_db WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	// public function checkccoNIC($nic,$code){
	// 	if($code!=''){
	// 		$query = "SELECT nic FROM cco_db WHERE nic='".$nic."' AND cco_code!='".$code."'"; 
	// 	}else{
	// 		$query = "SELECT nic FROM cco_db WHERE nic='".$nic."'"; 
	// 	}
	// 	$query= $this->db->query($query);
	// 	$result = $query->row_array();
	// 	if ($result==true)
	// 	{
	// 		$return = 'yes';
	// 	}
	// 	else
	// 	{
	// 		$return = 'no';
	// 	}	 
	// 	return $return;
	// }

	public function checkCc_mechanic_NIC($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM cc_mechanic WHERE nic='".$nic."' AND cocode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM cc_mechanic WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function form_a1_filter($distcode,$status) {
		//Code for Pagination Updated by Nouman
		//$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		//$wc=getWC_Array($procode,$distcode,$facode);
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_a1_vaccine_main ";
		$this->session->District;
		$distcode= (isset($distcode)) ? $distcode : $this->session->District;
		if($distcode > 0 && $status!=''){
			 $wc = " where distcode='$distcode' and status='$status' and ";
			 $w = "distcode='$distcode' and status='$status'";
		}
		elseif($distcode > 0){
			 $wc = " where distcode='$distcode' and ";
			 $w = " distcode='$distcode'";
		}
		elseif($status!=''){
			 $wc = " where status='$status' and ";
			  $w = " status='$status'";
		}else{
			$wc = " where ";
			$w = "procode = '3'";
		}
		$query="select id, form_date, distcode, districtname(distcode) as dist_name, is_temp_saved,status from form_a1_vaccine_main $wc form_date <> '1969-12-31' order by form_date desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ;
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">Provincial</td>
		    <td class="text-center">' . $row['dist_name'] . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['form_date'])) . '</td>
			<td class="text-center">' . $row['status'] . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Province-Issue-Receipt/View/' . $row['distcode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Province-Issue-Receipt/Edit/' . $row['distcode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}

	public function form_a1_fed_filter($datefrom,$dateto) {
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_a1_fed_vaccine_main ";
		if ($datefrom !='' && $dateto == NULL){
			$wc = " where form_date >='$datefrom'";
		}
		elseif ($dateto !='' && $datefrom == NULL){
			$wc = " where form_date <='$dateto'";
		}
		elseif($datefrom !='' && $dateto!=''){
			 $wc = " where form_date >='$datefrom' and form_date <='$dateto'";
		}
		elseif($datefrom == NULL && $dateto== NULL){
			 $wc = "";
		}
		
		// Change `records` according to your table name.
		$query="select id, form_date from form_a1_fed_vaccine_main $wc order by id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">Federal</td>
            <td class="text-center">Provincial</td> 
		    <td class="text-center">' . date("d-M-Y",strtotime($row['form_date'])) . '</td>   
		    <td class="text-center">
		      <a href="' . base_url() . 'Federal-Issue-Receipt/View/' . $row['id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Federal-Issue-Receipt/Edit/' . $row['id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$w=" procode = '3'";
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
	//----------------------------------------FORM B FILTER--------------------------------------------------//
	public function form_b_filter($facode,$year, $month) {
		//Code for Pagination Updated by Nouman
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode);
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_b_cr";
		if ($year=='') 
			$month='';
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		$query="select id,facode, facilityname(facode) as fac_name, is_temp_saved,fmonth from form_b_cr ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc))."   order by fmonth desc,facilityname(facode) asc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '
			<tr>
				<td class="text-center">' . $i . '</td>		    
				<td class="text-left">' . $row['fac_name'] . '</td>
				<td class="text-center">' . $row['facode'] . '</td>
				<td class="text-center">' . $row['fmonth'] . '</td>
				<td class="text-center">' . $is_temp_saved . '</td>
				<td class="text-center">
					<a href="' . base_url() . 'HF-Consumption-Requisition/View/' . $row['fmonth'] . '/' . $row['facode'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
					<a href="' . base_url() . 'HF-Consumption-Requisition/Edit/' . $row['fmonth'] . '/' . $row['facode'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
				</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;
		// if($this -> session -> District)
		// 	$wc=" procode = '3' and distcode = '".$this -> session -> District."'";
		// else
		// 	$wc=" procode = '3'";
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
		//---------------------------------------- form_b_consumption_filter FILTER--------------------------------------------------//
	public function form_b_consumption_filter($facode,$year, $month) {
		//Code for Pagination Updated by Nouman
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode);
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 50;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement ="epi_consumption_master";
		if ($year=='') 
			$month='';
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		$wc[] = "is_compiled = '1'";
		$query="select pk_id as id, facode, facilityname(facode) as fac_name,unname(uncode) as uc,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date,data_source  from epi_consumption_master ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc))."   order by fmonth desc,facilityname(facode) asc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		$edit_del='';
		foreach ($result as $row) {
			$i++;
			//removing check of freeze for district swat, they want to reset their data...... work by moon 2019-02-17
			if($row['data_source']=='web'){
				$edit_del='<a href="'.base_url().'consumption/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a  data-toggle="tooltip" title="Delete" onclick ="consumptiondelcst(this)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></a>';
			}
			if($this -> session -> District==="346"){
				$res = false;
			}else{
				$res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
				if($res==1){
					$edit_del='';
				}
			}
			
		/* $res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
		if($res==1)
			$edit_del='';
		else
		{
			$edit_del='<a href="'.base_url().'consumption/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a onclick ="consumptiondelcst(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i title="Delete" class="fa fa-close"></i></a>' ;
			
		} */
			$tbody .= '<tr>
		<td class="text-center">'.$i.'</td>
		<td class="text-center facode">'.$row['facode'].'</td>
		<td class="text-left">'.$row['fac_name'].'</td>
		<td class="text-left">'.$row['uc'].'</td>
		<td class="text-left">'.$row['tehsil'].'</td>
		<td class="text-center fmonth">'.$row['fmonth'].'</td>							  
		<td class="text-center">'.$row['created_date'].'</td>
		<td class="text-center">'.$row['data_source'].'</td>
		<td class="text-center">
			<a href="'.base_url().'consumption/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			'.$edit_del.'
			
		</td>
	</tr>';
			/* $tbody .= '
			<tr>
				<td class="text-center">' . $i . '</td>
				<td class="text-center facode">' . $row['facode'] . '</td>				
				<td class="text-left">' . $row['fac_name'] . '</td>
				<td class="text-center">' . $row['uc'] . '</td>
				<td class="text-center">' . $row['tehsil'] . '</td>
				<td class="text-center fmonth">' . $row['fmonth'] . '</td>
				<td class="text-center">' . $row['created_date'] . '</td>
				<td class="text-center">
				<a href="'.base_url().'consumption/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
				'.$edit_del.'
				</td>
		    </tr>'; */
		}
		$resultJson["tbody"] = $tbody;
		// if($this -> session -> District)
		// 	$wc=" procode = '3' and distcode = '".$this -> session -> District."'";
		// else
		// 	$wc=" procode = '3'";
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	public function form_b_adjustment_filter($facode,$year, $month) {
		//Code for Pagination Updated by Nouman
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode);
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 50;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement ="epi_consumption_master";
		if ($year=='') 
			$month='';
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		$wc[] = "is_compiled = '1'";
		$query="select pk_id as id, facode, facilityname(facode) as fac_name,unname(uncode) as uc,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date,data_source  from epi_consumption_master ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc))."   order by fmonth desc,facilityname(facode) asc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		$edit_del='';
		foreach ($result as $row) {
			$i++;
			//removing check of freeze for district swat, they want to reset their data...... work by moon 2019-02-17
			if($row['data_source']=='web'){
				$edit_del='<a href="'.base_url().'hfadjustment/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
			}			
			$res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
			if($res==1){
				$edit_del='';
			}
			
			
		/* $res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
		if($res==1)
			$edit_del='';
		else
		{
			$edit_del='<a href="'.base_url().'consumption/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a onclick ="consumptiondelcst(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i title="Delete" class="fa fa-close"></i></a>' ;
			
		} */
			$tbody .= '<tr>
		<td class="text-center">'.$i.'</td>
		<td class="text-center facode">'.$row['facode'].'</td>
		<td class="text-left">'.$row['fac_name'].'</td>
		<td class="text-left">'.$row['uc'].'</td>
		<td class="text-left">'.$row['tehsil'].'</td>
		<td class="text-center fmonth">'.$row['fmonth'].'</td>							  
		<td class="text-center">'.$row['created_date'].'</td>
		<td class="text-center">'.$row['data_source'].'</td>
		<td class="text-center">
			<a href="'.base_url().'hfadjustment/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			'.$edit_del.'
			
		</td>
	</tr>';
			/* $tbody .= '
			<tr>
				<td class="text-center">' . $i . '</td>
				<td class="text-center facode">' . $row['facode'] . '</td>				
				<td class="text-left">' . $row['fac_name'] . '</td>
				<td class="text-center">' . $row['uc'] . '</td>
				<td class="text-center">' . $row['tehsil'] . '</td>
				<td class="text-center fmonth">' . $row['fmonth'] . '</td>
				<td class="text-center">' . $row['created_date'] . '</td>
				<td class="text-center">
				<a href="'.base_url().'consumption/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
				'.$edit_del.'
				</td>
		    </tr>'; */
		}
		$resultJson["tbody"] = $tbody;
		// if($this -> session -> District)
		// 	$wc=" procode = '3' and distcode = '".$this -> session -> District."'";
		// else
		// 	$wc=" procode = '3'";
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
			//---------------------------------------- consumption_vaccination_filter FILTER--------------------------------------------------//
	public function consumption_vaccination_filter($facode,$year, $month) {
		//Code for Pagination Updated by Nouman
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode);
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 50;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement ="epi_consumption_master";
		if ($year=='') 
			$month='';
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		if ($year != "0" || $year = '' ) {
			$wc[] = "fmonth like '$year%' ";
		}
		if ($month != "0" && $month != '' ) {
			$wc[] = "fmonth like '%$month'  ";
		}
		if($this -> session -> UserLevel==4){
			$tcode =$this -> session -> Tehsil;
			$wc[] = " tcode = '$tcode' ";
		}
		$wc[] = " is_compiled = '1' ";
		$query="select pk_id as id, facode, facilityname(facode) as fac_name,unname(uncode) as uc,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date,data_source from epi_consumption_master ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc))."   order by fmonth desc,facilityname(facode) asc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		$edit_del='';
		foreach ($result as $row) {
			$i++;
			
			
		$res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
		if($res==1)
			$edit_del='';
		else
		{
			if($row['data_source']=='web'){
				$edit_del='<a href="'.base_url().'vaccination/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a onclick ="consumptiondelcst(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i title="Delete" class="fa fa-close"></i></a>' ;
			}
		}
			$tbody .= '<tr>
		<td class="text-center">'.$i.'</td>
		<td class="text-center facode">'.$row['facode'].'</td>
		<td class="text-left">'.$row['fac_name'].'</td>
		<td class="text-left">'.$row['uc'].'</td>
		<td class="text-left">'.$row['tehsil'].'</td>
		<td class="text-center fmonth">'.$row['fmonth'].'</td>							  
		<td class="text-center">'.$row['created_date'].'</td>
		<td class="text-center">'.$row['data_source'].'</td>
		<td class="text-center">
			<a href="'.base_url().'vaccination/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			'.$edit_del.'
			
		</td>
	</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//----------------------------------------FORM C FILTER--------------------------------------------------//
	public function form_c_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "form_c_demand";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' and ";
		}else{
			$wc = ' where ';
		}
		// Change `records` according to your table name.
		$query="select id,uncode, unname(uncode) as uc,tehsilname(tcode) as tehsil,is_temp_saved,start_date,end_date  from form_c_demand $wc  start_date <> '1969-12-31' and end_date <> '1969-12-31' order by uncode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-left">' . $row['uc'] . '</td>
		    <td class="text-center">' . $row['uncode'] . '</td>
		    <td class="text-left">' . $row['tehsil'] . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['start_date'])) . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['end_date'])) . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'UC-Demand-Consumption/View/' . $row['uncode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'UC-Demand-Consumption/Edit/' . $row['uncode'] . '/' . $row['id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//----------------------------------------NNT LINE LIST FILTER--------------------------------------------------//
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
//----------------------------------------Measles LINE LIST FILTER--------------------------------------------------//
	public function measles_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "measles_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from measles_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/measles_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/measles_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
		//----------------------------------------Diphtheria LINE LIST FILTER--------------------------------------------------//
	public function diphtheria_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "diphtheria_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from diphtheria_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/diphtheria_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/diphtheria_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
		//----------------------------------------Pneumonia LINE LIST FILTER--------------------------------------------------//
	public function pneumonia_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "pneumonia_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from pneumonia_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/pneumonia_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/pneumonia_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
			//----------------------------------------Pertussis LINE LIST FILTER--------------------------------------------------//
	public function pertussis_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "pertussis_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from pertussis_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/pertussis_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/pertussis_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
				//----------------------------------------Childhood TB LINE LIST FILTER--------------------------------------------------//
	public function childhood_tb_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "childhood_tb_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from childhood_tb_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/childhood_tb_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/childhood_tb_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
				//----------------------------------------AFP LINE LIST FILTER--------------------------------------------------//
	public function afp_linelist_filter($uncode) {
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "afp_outbreak_linelist";
		if($uncode > 0){
			$wc = " where uncode = '$uncode' ";
		}else{
			$wc = ' ';
		}
		// Change `records` according to your table name.
		$query="select linelist_group,uncode, distcode,unname(uncode) as uc,tehsilname(tcode) as tehsil,case_epi_no,date_investigation  from afp_outbreak_linelist $wc  order by linelist_group desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
		    <td class="text-center">' . $row['date_investigation'] . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Linelists/afp_linelist_view/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Linelists/afp_linelist_edit/' . $row['distcode'] . '/' . $row['linelist_group'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
//----------------------------------------Measles LINE LIST FILTER--------------------------------------------------//
	public function measle_investigation_filter($facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
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
		$statement = "measle_case_investigation";
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
		$query="select id,cross_notified,approval_status,cross_notified_from_distcode,distcode, uncode, tehsilname(tcode) as tehsil, facode,is_temp_saved,patient_name,fweek,facilityname(facode) as fac_name, case_epi_no, pvh_date from measle_case_investigation " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
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
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$pvhDate = ($row['pvh_date'] != '')?date("d-M-Y",strtotime($row['pvh_date'])):'';
			$tbody .= '<tr style="'.$color.'">
			    <td class="text-center">' . $i . '</td>
				<td class="text-left">' . $row['patient_name'] . '</td>
			    <td class="text-left">' . $row['fac_name'] . '</td>
			    <td class="text-left">' . $row['tehsil'] . '</td>
			    <td class="text-center">' . $row['case_epi_no'] . '</td>
				<td class="text-center">' . $row['fweek'] . '</td>';			
			    if(isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0 && $row['cross_notified']==1 && $row['cross_notified_from_distcode'] == $this->session->District){
					$districtName = ($row['distcode']>0)?get_District_Name($row['distcode']):'';
				}else{
					$districtName = (isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0)?get_District_Name($row['cross_notified_from_distcode']):'';
				}

				$link = (isset($row['facode']) && $row['facode'] > 0)?$row['facode'].'/'.$row['id']:$row['id'];
			    $tbody .= '
				<td class="text-center">' . $districtName . '</td>
				<td class="text-center">' . $pvhDate . '</td>
				<td class="text-center">' . $is_temp_saved . '</td>			    
			    <td class="text-center">
					<a href="' . base_url() . 'Measles-CIF/View/'  . $link .  '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>';
					if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1)

					{	
						$tbody .= '<a href="' . base_url() . 'Measles-CIF/Edit/' . $link . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
					}
			  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;		
		//$wc = getWC(); this condition results in extra pages when specific filter is selected
		$wc = implode(" AND ", $wc);
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//------------------------------------------------------------------------------------------------------------------//
	//---------------------------------Measles LINE LIST FILTER------------------------------------------//
	public function afp_investigation_filter($facode,$year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			// $distcode = $this -> session -> District;
			// $wc = getWC_Array($_SESSION["Province"],$distcode);
			$procode = $_SESSION["Province"];
			$wc[] = " (distcode = '". $this -> session -> District ."' OR cross_notified_from_distcode = '". $this -> session -> District ."') ";
		}
		else{
			$wc = getWC_Array($_SESSION["Province"]);
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
		$query="SELECT id,cross_notified,approval_status,cross_notified_from_distcode,distcode, uncode, tehsilname(tcode) as tehsil,patient_name, fweek,facode,is_temp_saved, facilityname(facode) as fac_name, case_epi_no from afp_case_investigation " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
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
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color:rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$tbody .= '<tr style="'.$color.'">
			    <td class="text-center">' . $i . '</td>	
				<td class="text-left">' . $row['patient_name'] . '</td>				
			    <td class="text-left">' . $row['fac_name'] . '</td>
			    <td class="text-center">' . $row['facode'] . '</td>
			    <td class="text-left">' . $row['tehsil'] . '</td>';
			    if(isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0 && $row['cross_notified']==1 && $row['cross_notified_from_distcode'] == $this->session->District){
					$districtName = ($row['distcode']>0)?get_District_Name($row['distcode']):'';
				}else{
					$districtName = (isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0)?get_District_Name($row['cross_notified_from_distcode']):'';
				}
				$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];
				$tbody .= '
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
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	//---------------------------------------------------------------------------------------------------------//
	//----------------------------------------Measles LINE LIST FILTER--------------------------------------------------//
	public function nnt_investigation_filter($investigated_by,$uncode,$facode,$year,$week) {
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
		// Change `records` according to your table name. 
		/* $query="select id,cross_notified,approval_status,cross_notified_from_distcode,distcode, facode, date_investigation,full_mother_name,fweek,facilityname(facode) as facilityname,is_temp_saved, unname(uncode) as unioncouncil, investigated_by, date_notification from nnt_investigation_form " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "   order by id desc LIMIT {$per_page} OFFSET {$startpoint}  "; */
		/* $query="select id, cross_notified, approval_status, investigated_by, cross_notified_from_distcode, distcode, date_investigation,fweek,full_mother_name,is_temp_saved,facilityname(facode) as facilityname, unname(uncode) as unioncouncil, date_notification from nnt_investigation_form " . (empty($wc) ? '' : ' where (' . implode(" AND ", $wc)) . ") AND cross_notified_from_distcode='". $this -> session -> District ."' order by id desc LIMIT {$per_page} OFFSET {$startpoint} ";  */
		/*
		select id,cross_notified,approval_status,cross_notified_from_distcode,distcode,tehsilname(tcode) as tehsil,facode,patient_name,is_temp_saved,fweek, case_epi_no, facilityname(facode) as fac_name, pvh_date from nnt_investigation_form where $wc OR cross_notified_from_distcode='". $this -> session -> District ."' order by id desc LIMIT {$per_page} OFFSET {$startpoint} 
		*/
		//print_r($query);exit;
		$query="SELECT id,cross_notified,approval_status,cross_notified_from_distcode,distcode, facode, date_investigation,full_mother_name,fweek,facilityname(facode) as facilityname,is_temp_saved, unname(uncode) as unioncouncil, investigated_by, date_notification from nnt_investigation_form " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " OR (cross_notified_from_distcode='". $this -> session -> District ."' " . (empty($wc) ? '' : ' and ' . implode(" AND ", $wc)) . ")  order by id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query);exit;
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
			 }else if($row['approval_status'] == "Pending"){
				  $color = "background-color: rgba(219, 37, 37, 0.5);";
			 }else{
				 $color = "";
			 }
			$notifDate = ($row['date_notification'] != '')?date("d-M-Y",strtotime($row['date_notification'])):'';
			$investDate = ($row['date_investigation'] != '')?date("d-M-Y",strtotime($row['date_investigation'])):'';
			$tbody .= '<tr style="'.$color.'">
			    <td class="text-center">' . $i . '</td>	
				<td class="text-left">' . $row['full_mother_name'] . '</td>			
			    <td class="text-left">' . $row['facilityname'] . '</td>
			    <td class="text-left">' . $row['unioncouncil'] . '</td>
			    <td class="text-left">' . $row['investigated_by'] . '</td>
				<td class="text-left">' . $row['fweek'] . '</td>';
				if(isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0 && $row['cross_notified']==1 && $row['cross_notified_from_distcode'] == $this->session->District){
					$districtName = ($row['distcode']>0)?get_District_Name($row['distcode']):'';
				}else{
					$districtName = (isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0)?get_District_Name($row['cross_notified_from_distcode']):'';
				}
				$link = (isset($row['facode']) && $row['facode']!='')?$row['facode'].'/'.$row['id']:$row['id'];
			    $tbody .= '
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
	//---------------------------------------------------------------------------------------------------------//
	
	//----------------------------------------Zero reporting filter--------------------------------------------------//
	public function zero_reporting_filter($year,$week) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}
		else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		
		$query = "SELECT max(group_id) as max_group_id from zero_report " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " ";
		$result = $this -> db -> query($query);
		$max_group_id = $result ->row()->max_group_id;
		//print_r($data['max_group_id']); exit();
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "zero_report";
		if($year != '0'){
			$wc[] = " year = '$year' ";
		}
		if($week != '0'){
			$wc[] = " week = '$week' ";
		}
		// Change `records` according to your table name. 
		$query="SELECT group_id, year, week , datefrom , dateto , fweek ,distcode, districtname(distcode) as districtname from zero_report" . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " GROUP BY group_id, year, week, datefrom, dateto, fweek, distcode, districtname(distcode) order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">
				<input type="hidden" class="group_id" name="group_id" value="'.$row['group_id'].'">'.$i.'</td>	
			<td class="text-left">'.$row['districtname'].'</td>			
		    <td class="text-left year">'.$row['year'].'</td>
		    <td class="text-left week">'.$row['week'].'</td>
		    <td class="text-left">'.date("d-M-Y",strtotime($row['datefrom'])).'</td>
			<td class="text-left">'.date("d-M-Y",strtotime($row['dateto'])).'</td>
		    <td class="text-center">
				<a href="'.base_url().'Zero-Reporting/View/'.$row['fweek'].'/'.$row['group_id'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
				<a href="'.base_url().'Zero-Reporting/Edit/'.$row['fweek'].'/'.$row['group_id'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>';
				if($max_group_id == $row['group_id']){
					$tbody.= '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
				}			
		  	$tbody .= '</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		if($this -> session -> District)
			$wc=" procode = '3' and distcode = '".$this -> session -> District."'";
		else
			$wc=" procode = '3'";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc,"group_id");
		return json_encode($resultJson);
	}
	//---------------------------------------------------------------------------------------------------------//
	
	public function checkDsoNic($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM dsodb WHERE nic='".$nic."' AND dsocode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM dsodb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	//AddHR
	public function checkHrNic($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM hrdb WHERE nic='".$nic."' AND hrcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM hrdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkCCTNic($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM cctdb WHERE nic='".$nic."' AND cctcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM cctdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkCCMNic($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM ccmdb WHERE nic='".$nic."' AND ccmcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM ccmdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkCCGNic($nic,$code){


		if($code!=''){
			$query = "SELECT nic FROM ccgdb WHERE nic='".$nic."' AND ccgcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM ccgdb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	public function checkCCDNic($nic,$code){

		if($code!=''){
			$query = "SELECT nic FROM ccddb WHERE nic='".$nic."' AND ccdcode!='".$code."'"; 
		}else{
			$query = "SELECT nic FROM ccddb WHERE nic='".$nic."'"; 
		}
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				 {
					 $return = 'yes';
				}
				else
				{
					 $return = 'no';
				}
		 
			return $return;

	}
	
	public function dso_filter($page, $employee_type, $status, $facode,$fatype,$distcode) {
		$procode = '3';
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($employee_type != "0" && $employee_type != '') {
			$wc[] = " employee_type = '$employee_type' ";
		}
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		if ($status != "0" && $status != '') {
			$wc[] = "status = '$status' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "dsodb";
		// Change `records` according to your table name.
		$query = "select * , districtname(distcode) as district, tehsilname(tcode) as tehsil, telephone, cellphone from dsodb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		if($result!=NULL)
		{
			$i = $startpoint;
			$resultJson = array();
			$tbody = "";
			foreach ($result as $row) {
				$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ;
				$i++;
				$tbody .= '<tr>
	                              <td class="text-center">' . $i . '</td>                             
	                              <td class="text-left">' . $row["dsoname"] . '</td>
	                              <td class="text-center">' . $row["nic"] . '</td>
	                              <td class="text-center">' . $row["telephone"] . '</td>
	                              <td class="text-center">' . $row["cellphone"] . '</td>
	                              <td class="text-left">' . $row["employee_type"] . '</td>
	                              <td class="text-left">' . $row["district"] . '</td>                              
	                              <td class="text-center">' . $row["status"] . '</td>
								  <td class="text-center">' . $is_temp_saved . '</td>';
	              // this UserLevel 2 to changed UserLevel 3 by Mian Rizwan
	               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
	                        $tbody .= '      <td class="text-center">
	                                 <div class="btn-group">
	                                    <a href="' . base_url() . 'DSO/View/' . $row["dsocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
	                                    <a href="' . base_url() . 'DSO/Edit/' . $row["dsocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	                                 </div>
	                              </td>';
	                           }
							$tbody.= '</tr>';
			}
		}
		else{
			$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}	
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
		public function dso_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20"," ",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic !='' ){
		  $wc[] = "nic like '%$nic%' OR dsoname like '%$nic%' OR fathername like '%$nic%' OR dsocode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "dsodb ";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname,districtname(distcode) as district, tehsilname(tcode) as tehsil from dsodb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
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
                              <td class="text-left">' . $row["dsoname"] . '</td>
                              <td class="text-center">' . $row["nic"] . '</td>
                              <td class="text-center">' . $row["telephone"] . '</td>
                              <td class="text-center">' . $row["cellphone"] . '</td>
                              <td class="text-left">' . $row["employee_type"] . '</td>
                              <td class="text-left">' . $row["district"] . '</td>                              
                              <td class="text-center">' . $row["status"] . '</td>
							  <td class="text-center">' . $is_temp_saved . '</td>';
             // this UserLevel 2 to changed UserLevel 3 by Mian Rizwan
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'DSO/View/' . $row["dsocode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'DSO/Edit/' . $row["dsocode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	
	public function cct_filter($page,$distcode,$tcode, $uncode, $facode,$fatype) {
		$procode = '3';
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($uncode != 0) {
			$wc[] = " uncode = '$uncode' ";
		}
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cctdb";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cctdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["cctname"] . '</td>
                              <td class="text-center">' . $row["cctcode"] . '</td>
                              <td class="text-center">' . $row["nic"] . '</td>                              
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                              <td class="text-center">' . $row["facilitytype"] . '</td>
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCT/View/' . $row["cctcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCT/Edit/' . $row["cctcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function cct_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20","",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic !='' ){
		  $wc[] = "nic like '%$nic%' OR cctname like '%$nic%' OR fathername like '%$nic%' OR cctcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "cctdb ";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cctdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["cctname"] . '</td>
                              <td class="text-center">' . $row["cctcode"] . '</td>
                              <td class="text-center">' . $row["nic"] . '</td>                             
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facode"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                               <td class="text-center">' . $row["facilitytype"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCT/View/' . $row["cctcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCT/Edit/' . $row["cctcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccm_filter($page,$distcode,$tcode, $uncode, $facode,$fatype) {
		$procode = '3';
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($uncode != 0) {
			$wc[] = " uncode = '$uncode' ";
		}
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccmdb";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccmdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccmname"] . '</td>
                              <td class="text-center">' . $row["ccmcode"] . '</td>                              
                              <td class="text-center">' . $row["nic"] . '</td>                              
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                              <td class="text-center">' . $row["facilitytype"] . '</td>                            
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCM/View/' . $row["ccmcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCM/Edit/' . $row["ccmcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccm_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20","",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic !='' ){
		  $wc[] = "nic like '%$nic%' OR ccmname like '%$nic%' OR fathername like '%$nic%' OR ccmcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccmdb ";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccmdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccmname"] . '</td>
                              <td class="text-center">' . $row["ccmcode"] . '</td>                              
                              <td class="text-center">' . $row["nic"] . '</td>                              
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                              <td class="text-center">' . $row["facilitytype"] . '</td>                              
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCM/View/' . $row["ccmcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCM/Edit/' . $row["ccmcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	
		public function ccg_filter($page, $distcode, $tcode, $uncode, $facode, $fatype) {
		$procode = '3';
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($uncode != 0) {
			$wc[] = " uncode = '$uncode' ";
		}
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccgdb";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccgdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccgname"] . '</td>
                              <td class="text-center">' . $row["ccgcode"] . '</td>                             
                              <td class="text-center">' . $row["nic"] . '</td>                              
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                              <td class="text-center">' . $row["facilitytype"] . '</td>
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCG/View/' . $row["ccgcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCG/Edit/' . $row["ccgcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccg_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20","",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic !='' ){
		  $wc[] = "nic like '%$nic%' OR ccgname like '%$nic%' OR fathername like '%$nic%' OR ccgcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccgdb ";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccgdb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccgname"] . '</td>
                              <td class="text-center">' . $row["ccgcode"] . '</td>                             
                              <td class="text-center">' . $row["nic"] . '</td>                              
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                              <td class="text-center">' . $row["facilitytype"] . '</td>
                               <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCG/View/' . $row["ccgcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCG/Edit/' . $row["ccgcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccd_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = '3';
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccddb";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccddb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccdcode"] . '</td>
                              <td class="text-center">' . $row["ccdname"] . '</td>
                              <td class="text-center">' . $row["nic"] . '</td>
                              <td class="text-center">' . $row["district"] . '</td>
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facode"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                               <td class="text-center">' . $row["facilitytype"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCD/View/' . $row["ccdcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCD/Edit/' . $row["ccdcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccd_filter_cnic($cnic) {
			
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20","",$cnic); 
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
		}else{
			$distcode = 0;
		}
		$wc = getWC_Array($_SESSION["Province"],$distcode);
		if($nic !='' ){
		  $wc[] = "nic like '%$nic%' OR ccdname like '%$nic%' OR fathername like '%$nic%' OR ccdcode like '%$nic%' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccddb ";
		// Change `records` according to your table name.
		$query = "select * , facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccddb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>
                              <td class="text-center">' . $row["ccdcode"] . '</td>
                              <td class="text-center">' . $row["ccdname"] . '</td>
                              <td class="text-center">' . $row["nic"] . '</td>
                              <td class="text-center">' . $row["district"] . '</td>
                              <td class="text-center">' . $row["tehsil"] . '</td>
                              <td class="text-center">' . $row["facode"] . '</td>
                              <td class="text-center">' . $row["facilityname"] . '</td>
                               <td class="text-center">' . $row["facilitytype"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'CCD/View/' . $row["ccdcode"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'CCD/Edit/' . $row["ccdcode"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	
	public function generate_measles_case_code($case_epi_no){
			if ($case_epi_no > 0) {
			$query = "Select max(case_epi_no) as case_epi from measle_case_investigation  WHERE case_epi_no like '$case_epi_no%'  HAVING max(case_epi_no) is not null ";
			//echo $query;
			$result = $this -> db -> query($query);
			//var_dump($result);
			if ($result -> num_rows() > 0) {
				$case_epi_no = $result -> row_array();
				//var_dump($supervisordata);
				$newCode = $case_epi_no['case_epi'] + 1;
				echo $newCode = substr($newCode, -4);
				if ($newCode != NULL) {
					echo $newCode;
				} else {
					echo '0001';
				}
			} else {
				echo "0001";
			}
			# code...
		}
	}
	//----------------------------------------Cold Chain Operator FILTER--------------------------------------------------//

	public function ccoperatordb_filter($page, $distcode, $tcode, $facode, $uncode, $supervisorcode, $status, $fatype){
			$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
					$wc[] = "status='Active'";
				}
				break;
		}
		if ($status != "0") {
			$wc[] = "status = '$status' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccoperatordb";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from ccoperatordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  ORDER BY ccoperatordb.c_id LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		if($result!= NULL){
			$i = $startpoint;
			$resultJson = array();
			$tbody = '';
			foreach ($result as $row) {
				$i++;
				$tbody .= '<tr class="DrilledDown">
		        <td class="text-center" >' . $i . '</td>	        
		        <td class="text-center" >' . $row["ccoperatorname"] . '</td>	        
		        <td class="text-center" >' . $row["nic"] . '</td>
		        <td class="text-center" >' . $row["employee_type"] . '</td>
		        <td class="text-center" >' . $row["status"] . '</td>
		        <td class="text-center" >' . $row["district"] . '</td>';
		        // this UserLevel 2 to changed UserLevel 3 by Mian Rizwan
	          if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
	           $tbody .= ' <td class="text-center" >
		            <a href="' . base_url() . 'CC-Operator/View/' . $row["c_id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		            <a href="' . base_url() . 'CC-Operator/Edit/' . $row["c_id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	        		</td>';
	            } $tbody.= '</tr>';
			}
		}
		else{
		$tbody='';
			$tbody.= '<thead><tr><th><td class="text-center"> No Record Found</td> </th></tr></thead><tbody>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function ccoperatordb_filter_cnic($cnic){
		$cnic= ltrim($cnic);
		$nic=str_ireplace("%20","",$cnic); 
		$procode = '3';
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc = array();
		$distcode=$this->session->district;
		$utype= $_SESSION['utype'];
		switch ($_SESSION['UserLevel']) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION['District'];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION['District'];
				$facode = $_SESSION['facode'];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					
				}
				break;
		}
		if($nic !=0 ){
		  $wc[] = "nic like '%$nic%'";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ccoperatordb ";
		// Change `records` according to your table name.
		$query = "select *, districtname(distcode) as district from ccoperatordb " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . "  order by ccoperatordb.c_id";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr class="DrilledDown">
        	<td class="text-center" >' . $i . '</td>	        
	        <td class="text-center" >' . $row["ccoperatorname"] . '</td>
	        <td class="text-center" >' . $row["nic"] . '</td>
	        <td class="text-center" >' . $row["employee_type"] . '</td>
	        <td class="text-center" >' . $row["status"] . '</td>
	        <td class="text-center" >' . $row["district"] . '</td>';
          if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
           $tbody .= ' <td class="text-center" >
	            <a href="' . base_url() . 'CC-Operator/View/' . $row["c_id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
	            <a href="' . base_url() . 'CC-Operator/Edit/' . $row["c_id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
        		</td>';
            } $tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
		}

		public function rev_health_facility_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_hf_questionnaire";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_hf_questionnaire " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'HF-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'HF-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function refrigerator_questionnaire_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_refrigerator_questionnaire";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_refrigerator_questionnaire " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td classs="text-center">' . $row["equip_code"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Refrigerator-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Refrigerator-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}

	public function vaccine_carriers_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "vacc_carriers_main";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from vacc_carriers_main " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Vaccine-Carriers/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Vaccine-Carriers/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}

	public function coldroom_questionnaire_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_coldroom_questionnaire";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_coldroom_questionnaire " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td class="text-center">' . $row["equip_code"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Coldroom-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Coldroom-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}

	public function voltage_questionnaire_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_voltage_questionnaire";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_voltage_questionnaire " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td class="text-center">' . $row["equip_code"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Voltage-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Voltage-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function generator_questionnaire_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_generator_questionnaire";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_generator_questionnaire " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>
                              <td class="text-center">' . $row["equip_code"] . '</td>
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
               if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Generator-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Generator-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	public function transport_questionnaire_filter($page, $tcode, $facode, $fatype,$distcode) {
		$procode = isset($_REQUEST["procode"]) ? $_REQUEST["procode"] : $_SESSION["Province"];
		$utype= $_SESSION['utype'];
		//$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$wc = array();
		switch ($_SESSION["UserLevel"]) {
			case '1' :
				# code...
				break;
			case '2' :
				$UserLevel = 2;
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				} else if ($procode > 0) {
					$wc[] = "procode = '" . $procode . "'";
				}
				break;
			case '3' :
				$UserLevel = 3;
				$distcode = $_SESSION["District"];
				if (($procode > 0) && ($distcode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
				}
				break;
			case '4' :
				$UserLevel = 4;
				$distcode = $_SESSION["District"];
				$facode = $_SESSION["facode"];
				if (($procode > 0) && ($distcode > 0) && ($facode > 0)) {
					$wc[] = "procode = '" . $procode . "'";
					$wc[] = "distcode = '" . $distcode . "'";
					$wc[] = "facode = '" . $facode . "'";
				}
				break;
		}
		if ($tcode != 0) {
			$wc[] = " tcode = '$tcode' ";
		}
		
		if ($fatype != "0") {
			$wc[] = "  facilitytype(facode) = '$fatype' ";
		}
		if ($facode != 0) {
			$wc[] = " facode = '$facode' ";
		}

		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($page) ? 1 : $page);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "transport_questionnaire_main";
		// Change `records` according to your table name.
		$query = "SELECT * , unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype ,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from transport_questionnaire_main " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//print_r($result);
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;
			$tbody .= '<tr>
                              <td class="text-center">' . $i . '</td>                              
                              <td class="text-center">' . $row["date_submitted"] . '</td>                              
                              <td class="text-left">' . $row["tehsil"] . '</td>
                              <td class="text-left">' . $row["facilityname"] . '</td>
                              <td class="text-left">' . $row["facilitytype"] . '</td> 
                              <td class="text-center">' . $row["facode"] . '</td>';
              		if (($_SESSION['UserLevel']=='3') && ($utype=='DEO') ){
                        $tbody .= '      <td class="text-center">
                                 <div class="btn-group">
                                    <a href="' . base_url() . 'Transport-Questionnaire/View/' . $row["id"] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                    <a href="' . base_url() . 'Transport-Questionnaire/Edit/' . $row["id"] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                 </div>
                              </td>';
                           }
						$tbody.= '</tr>';
		}
		$resultJson["tbody"] = $tbody;
		// displaying paginaiton.
		$resultJson["paging"] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = "?", implode(" AND ", $wc));
		return json_encode($resultJson);
	}
	
	public function checkMonthHFform($facode, $month, $year){
	$month = sprintf("%02d",($month));
	$fmonth= $year."-".$month;
		if($fmonth!=0){
		$query = "SELECT fmonth,facode FROM flcf_vacc_mr WHERE facode='".$facode."' AND fmonth='".$fmonth."'"; 
		$query= $this->db->query($query);
		$result = $query->row_array();
			if ($result==true)
				{
					 $return = 'yes';
				}
				else
				{	
					$return = 'no';
				}
			return $return;
		}
	}
	public function getHFOpeningBal($month,$year,$facode){
		$fmonth = date('Y-m',strtotime($year . '-' . $month . '-01' . ' first day of previous month'));
		//for column names
		$selectCols ="";
		for($i=1;$i<=23;$i++)
		{
			$selectCols .= "cr_r".$i."_f6,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from form_b_cr where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		for($i=1;$i<=23;$i++)
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
		for($i=1;$i<=23;$i++)
		{
			$selectCols .= "cr_r".$i."_f6,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from form_b_cr where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		for($i=1;$i<=23;$i++)
		{
			$key = "cr_r".$i."_f6";
			$toEncode[$key] = $result[$key];
		}
		return json_encode($toEncode);
	}
	
	public function getHFChildVaccBal($month,$year,$facode){
		$datestring=$year.'-'.$month.'-13 first day of last month'; 
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
		//for column names
		$selectColsA ="";
		$selectColsB ="";
		$selectColsC ="";
		$selectColsD ="";
		for($i=1;$i<23;$i++)
		{
			$selectColsA .= "cri_r".$i."_f13,";
			$selectColsB .= "cri_r".$i."_f14,";
		}
		
		for($i=1;$i<6;$i++)
		{
			$selectColsC.= "ttri_r".$i."_f5,";
			$selectColsD.= "ttri_r".$i."_f6,";
		}
		$selectColsA = rtrim($selectColsA,",");
		$selectColsB = rtrim($selectColsB,",");
		$selectColsC = rtrim($selectColsC,",");
		$selectColsD = rtrim($selectColsD,",");
		$query="select $selectColsA , $selectColsB ,$selectColsC, $selectColsD  from flcf_vacc_mr where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		$BCG = $result['cri_r1_f13'] + $result['cri_r1_f14'];
		//echo 'XXX'.$BCG; exit;
		for($i=1;$i<23;$i++)
		{
			$keyA = "cri_r".$i."_f13";
			$keyB = "cri_r".$i."_f14";
			$toEncode[$keyA] = $result[$keyA];
			$toEncode[$keyB] = $result[$keyB];
		}
		for($i=1;$i<6;$i++)
		{
			$keyC = "ttri_r".$i."_f5";
			$keyD = "ttri_r".$i."_f6";
			$toEncode[$keyC] = $result[$keyC];
			$toEncode[$keyD] = $result[$keyD];
		}
		
		
		//echo '<XX>';print_r($toEncode);exit;
		return json_encode($toEncode);
	}
	public function getEPIVaccinationBalance($month,$year,$facode){
		//$datestring=$year.'-'.$month.'-13 first day of last month'; 
		$datestring=$year.'-'.$month; 
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
        //print_r($fmonth);exit;
		//for column names
		$selectColsA ="";
		$selectColsB ="";
		$selectColsC ="";
		$selectColsD ="";
		for($i=1;$i<19;$i++)
		{
			for($row=1;$row<=24;$row++){
				$selectColsA .= "cri_r".$row."_f".$i.",oui_r".$row."_f".$i.",";
			    $selectColsC .=  "od_r".$row."_f".$i.",";
			}
		}
		
		for($i=1;$i<=6;$i++)
		{
			for($row=1;$row<=8;$row++){
				$selectColsB.= "  ttri_r".$row."_f".$i.", ttoui_r".$row."_f".$i.",";
				$selectColsD .=  "ttod_r".$row."_f".$i.",";
			}
		}
		$selectColsA = rtrim($selectColsA,",");
		$selectColsB = rtrim($selectColsB,",");
		$selectColsC = rtrim($selectColsC,",");
		$selectColsD = rtrim($selectColsD,",");
		
		
		$query="select $selectColsA , $selectColsB  from fac_mvrf_db where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		$query="select $selectColsC , $selectColsD  from fac_mvrf_od_db where facode = '$facode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$resultod = $resultAR->row_array();
		
		for($i=1;$i<19;$i++)
		{
			$keyA = "cri_r1_f".$i;
			$keyB = "cri_r2_f".$i;
			$keyC = "cri_r3_f".$i;
			$keyD = "cri_r4_f".$i;
			$keyE = "cri_r5_f".$i;
			$keyF = "cri_r6_f".$i;
			$keyG = "cri_r7_f".$i;
			$keyH = "cri_r8_f".$i;
			$keyI = "cri_r9_f".$i;
			$keyJ = "cri_r10_f".$i;
			$keyK = "cri_r11_f".$i;
			$keyL = "cri_r12_f".$i;
			$keyM = "cri_r13_f".$i;
			$keyN = "cri_r14_f".$i;
			$keyO = "cri_r15_f".$i;
			$keyP = "cri_r16_f".$i;
			$keyQ = "cri_r17_f".$i;
			$keyR = "cri_r18_f".$i;
			$keyS = "cri_r19_f".$i;
			$keyT = "cri_r20_f".$i;
			$keyU = "cri_r21_f".$i;
			$keyV = "cri_r22_f".$i;
			$keyW = "cri_r23_f".$i;
			$keyX = "cri_r24_f".$i;
	///////////////////oui_r////////////////////////
	        $keyAo = "oui_r1_f".$i;
			$keyBo = "oui_r2_f".$i;
			$keyCo = "oui_r3_f".$i;
			$keyDo = "oui_r4_f".$i;
			$keyEo = "oui_r5_f".$i;
			$keyFo = "oui_r6_f".$i;
			$keyGo = "oui_r7_f".$i;
			$keyHo = "oui_r8_f".$i;
			$keyIo = "oui_r9_f".$i;
			$keyJo = "oui_r10_f".$i;
			$keyKo = "oui_r11_f".$i;
			$keyLo = "oui_r12_f".$i;
			$keyMo = "oui_r13_f".$i;
			$keyNo = "oui_r14_f".$i;
			$keyOo = "oui_r15_f".$i;
			$keyPo = "oui_r16_f".$i;
			$keyQo = "oui_r17_f".$i;
			$keyRo = "oui_r18_f".$i;
			$keySo = "oui_r19_f".$i;
			$keyTo = "oui_r20_f".$i;
			$keyUo = "oui_r21_f".$i;
			$keyVo = "oui_r22_f".$i;
			$keyWo = "oui_r23_f".$i;
			$keyXo = "oui_r24_f".$i;
		////////////////od/////////////////
		    $keyAd = "od_r1_f".$i;
			$keyBd = "od_r2_f".$i;
			$keyCd = "od_r3_f".$i;
			$keyDd = "od_r4_f".$i;
			$keyEd = "od_r5_f".$i;
			$keyFd = "od_r6_f".$i;
			$keyGd = "od_r7_f".$i;
			$keyHd = "od_r8_f".$i;
			$keyId = "od_r9_f".$i;
			$keyJd = "od_r10_f".$i;
			$keyKd = "od_r11_f".$i;
			$keyLd = "od_r12_f".$i;
			$keyMd = "od_r13_f".$i;
			$keyNd = "od_r14_f".$i;
			$keyOd = "od_r15_f".$i;
			$keyPd = "od_r16_f".$i;
			$keyQd = "od_r17_f".$i;
			$keyRd = "od_r18_f".$i;
			$keySd = "od_r19_f".$i;
			$keyTd = "od_r20_f".$i;
			$keyUd = "od_r21_f".$i;
			$keyVd = "od_r22_f".$i;
			$keyWd = "od_r23_f".$i;
			$keyXd = "od_r24_f".$i;
	
		
			$toEncode[$keyA] = $result[$keyA];
			$toEncode[$keyB] = $result[$keyB];
			$toEncode[$keyC] = $result[$keyC];
			$toEncode[$keyD] = $result[$keyD];
			$toEncode[$keyE] = $result[$keyE];
			$toEncode[$keyF] = $result[$keyF];
			$toEncode[$keyG] = $result[$keyG];
			$toEncode[$keyH] = $result[$keyH];
			$toEncode[$keyI] = $result[$keyI];
			$toEncode[$keyJ] = $result[$keyJ];
			$toEncode[$keyK] = $result[$keyK];
			$toEncode[$keyL] = $result[$keyL];
			$toEncode[$keyM] = $result[$keyM];
			$toEncode[$keyN] = $result[$keyN];
			$toEncode[$keyO] = $result[$keyO];
			$toEncode[$keyP] = $result[$keyP];
			$toEncode[$keyQ] = $result[$keyQ];
			$toEncode[$keyR] = $result[$keyR];
			$toEncode[$keyS] = $result[$keyS];
			$toEncode[$keyT] = $result[$keyT];
			$toEncode[$keyU] = $result[$keyU];
			$toEncode[$keyV] = $result[$keyV];
			$toEncode[$keyW] = $result[$keyW];
			$toEncode[$keyX] = $result[$keyX];
			////////////////oui////////////////////
			$toEncode[$keyAo] = $result[$keyAo];
			$toEncode[$keyBo] = $result[$keyBo];
			$toEncode[$keyCo] = $result[$keyCo];
			$toEncode[$keyDo] = $result[$keyDo];
			$toEncode[$keyEo] = $result[$keyEo];
			$toEncode[$keyFo] = $result[$keyFo];
			$toEncode[$keyGo] = $result[$keyGo];
			$toEncode[$keyHo] = $result[$keyHo];
			$toEncode[$keyIo] = $result[$keyIo];
			$toEncode[$keyJo] = $result[$keyJo];
			$toEncode[$keyKo] = $result[$keyKo];
			$toEncode[$keyLo] = $result[$keyLo];
			$toEncode[$keyMo] = $result[$keyMo];
			$toEncode[$keyNo] = $result[$keyNo];
			$toEncode[$keyOo] = $result[$keyOo];
			$toEncode[$keyPo] = $result[$keyPo];
			$toEncode[$keyQo] = $result[$keyQo];
			$toEncode[$keyRo] = $result[$keyRo];
			$toEncode[$keySo] = $result[$keySo];
			$toEncode[$keyTo] = $result[$keyTo];
			$toEncode[$keyUo] = $result[$keyUo];
			$toEncode[$keyVo] = $result[$keyVo];
			$toEncode[$keyWo] = $result[$keyWo];
			$toEncode[$keyXo] = $result[$keyXo];
			////////////////od////////////////
			$toEncode[$keyAd] = $resultod[$keyAd];
			$toEncode[$keyBd] = $resultod[$keyBd];
			$toEncode[$keyCd] = $resultod[$keyCd];
			$toEncode[$keyDd] = $resultod[$keyDd];
			$toEncode[$keyEd] = $resultod[$keyEd];
			$toEncode[$keyFd] = $resultod[$keyFd];
			$toEncode[$keyGd] = $resultod[$keyGd];
			$toEncode[$keyHd] = $resultod[$keyHd];
			$toEncode[$keyId] = $resultod[$keyId];
			$toEncode[$keyJd] = $resultod[$keyJd];
			$toEncode[$keyKd] = $resultod[$keyKd];
			$toEncode[$keyLd] = $resultod[$keyLd];
			$toEncode[$keyMd] = $resultod[$keyMd];
			$toEncode[$keyNd] = $resultod[$keyNd];
			$toEncode[$keyOd] = $resultod[$keyOd];
			$toEncode[$keyPd] = $resultod[$keyPd];
			$toEncode[$keyQd] = $resultod[$keyQd];
			$toEncode[$keyRd] = $resultod[$keyRd];
			$toEncode[$keySd] = $resultod[$keySd];
			$toEncode[$keyTd] = $resultod[$keyTd];
			$toEncode[$keyUd] = $resultod[$keyUd];
			$toEncode[$keyVd] = $resultod[$keyVd];
			$toEncode[$keyWd] = $resultod[$keyWd];
			$toEncode[$keyXd] = $resultod[$keyXd];
		}
		for($i=1;$i<=6;$i++)
		{
			$keyAA = "ttri_r1_f".$i;
			$keyAB = "ttri_r2_f".$i;
			$keyAC = "ttri_r3_f".$i;
			$keyAD = "ttri_r4_f".$i;
			$keyAE = "ttri_r5_f".$i;
			$keyAF = "ttri_r6_f".$i;
			$keyAG = "ttri_r7_f".$i;
			$keyAH = "ttri_r8_f".$i;
			///////////oui////////////
			$keyAAo = "ttoui_r1_f".$i;
			$keyABo = "ttoui_r2_f".$i;
			$keyACo = "ttoui_r3_f".$i;
			$keyADo = "ttoui_r4_f".$i;
			$keyAEo = "ttoui_r5_f".$i;
			$keyAFo = "ttoui_r6_f".$i;
			$keyAGo = "ttoui_r7_f".$i;
			$keyAHo = "ttoui_r8_f".$i;
			////////////od///////////
			$keyAAd = "ttod_r1_f".$i;
			$keyABd = "ttod_r2_f".$i;
			$keyACd = "ttod_r3_f".$i;
			$keyADd = "ttod_r4_f".$i;
			$keyAEd = "ttod_r5_f".$i;
			$keyAFd = "ttod_r6_f".$i;
			$keyAGd = "ttod_r7_f".$i;
			$keyAHd = "ttod_r8_f".$i;
			$toEncode[$keyAA] = $result[$keyAA];
			$toEncode[$keyAB] = $result[$keyAB];
			$toEncode[$keyAC] = $result[$keyAC];
			$toEncode[$keyAD] = $result[$keyAD];
			$toEncode[$keyAE] = $result[$keyAE];
			$toEncode[$keyAF] = $result[$keyAF];
			$toEncode[$keyAG] = $result[$keyAG];
			$toEncode[$keyAH] = $result[$keyAH];
			////////////////oui///////////////////
			$toEncode[$keyAAo] = $result[$keyAAo];
			$toEncode[$keyABo] = $result[$keyABo];
			$toEncode[$keyACo] = $result[$keyACo];
			$toEncode[$keyADo] = $result[$keyADo];
			$toEncode[$keyAEo] = $result[$keyAEo];
			$toEncode[$keyAFo] = $result[$keyAFo];
			$toEncode[$keyAGo] = $result[$keyAGo];
			$toEncode[$keyAHo] = $result[$keyAHo];
			/////////////////od///////////////////
			$toEncode[$keyAAd] = $resultod[$keyAAd];
			$toEncode[$keyABd] = $resultod[$keyABd];
			$toEncode[$keyACd] = $resultod[$keyACd];
			$toEncode[$keyADd] = $resultod[$keyADd];
			$toEncode[$keyAEd] = $resultod[$keyAEd];
			$toEncode[$keyAFd] = $resultod[$keyAFd];
			$toEncode[$keyAGd] = $resultod[$keyAGd];
			$toEncode[$keyAHd] = $resultod[$keyAHd];
			
		}
		return json_encode($toEncode);
	}
	public function getAfpNumber($year, $epid_code) { 
		$query = "select max(afp_number) as afp_number from afp_case_investigation where dcode='$epid_code' AND epid_year='$year'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$Afp = str_split(sprintf('%04u', ($result['afp_number'] + 1))); 
		return json_encode($Afp);
	}
	public function validateAfpNumber($afpNumber) {
		$query = "select case_epi_no from afp_case_investigation where case_epi_no='$afpNumber'";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$numberExist = $result['case_epi_no'];
		if ($numberExist == $afpNumber) { 
			return "1";
		}else{
			return "Correct";
		}
	}
	public function createReport($rep_title,$fIds,$lastsgment,$reportid,$tbl_select){
	$username=$this -> session -> username;
	if($reportid!=null){
		$get=$this->db->delete('adv_reports', array('report_id' => $reportid)); 
		$result=$this->db->delete('adv_report_fields', array('report_id' => $reportid)); 
	}
	if($lastsgment=="HFMVRF-Advance-Report" || $lastsgment=="HFMVRF-Advance-Report#"){ 
			$lastsgment = 3;
		} 
		if($lastsgment=="HFCR-Advance-Report" || $lastsgment=="HFCR-Advance-Report#"){
			$lastsgment = 7;
			} 
			if($lastsgment=="HR-Advance-Report" || $lastsgment=="HR-Advance-Report#"){
			$lastsgment = 1;
			} 
			 if($lastsgment=="Disease-Surveillance-Advance-Report" || $lastsgment=="Disease-Surveillance-Advance-Report#"){
			$lastsgment = 5;
			} 
	if($rep_title=="")
	{
		echo $msg = "Error: Report title cannot be null";
	}else{
		if($fIds=="")
		{
			echo $msg = "Error: There must b a field checked to create report";
		}else{
			//to add report title
			$insertquery = "INSERT INTO adv_reports (username, report_title, module_id,tbl_select) VALUES ('$username', '$rep_title', '$lastsgment','$tbl_select')";
			$result = $this->db->query($insertquery);
			
			$reportId = $this->db->insert_id();

			/*$result1 = $this->db->query("SELECT currval('adv_report_id')");
			$rptdata=$result1->result_array();
			$reportId = $rptdata["currval"];*/
			foreach ($fIds as $oneId)
			{	
				
				//$split_point = "-";
				$idx = strrpos($oneId, "-");
				$parts = array(substr($oneId, 0, $idx), substr($oneId, $idx+strlen("-")));
				$insertquery = "INSERT INTO adv_report_fields (report_id,sec_id,field_id,module_id) VALUES ('$reportId','$parts[0]','$parts[1]','$lastsgment')";
				$result = $this->db->query($insertquery);
			}
			//query to get already created advance report titles for advance report
			$finalString = '';
			$query="Select * from adv_reports where username='$username' and module_id = '$lastsgment' order by report_title";
			$resultAdv=$this->db->query($query);
			foreach($resultAdv->result_array() as $row){

				$finalString .= '<option value="'.$row['report_id'].'" >'.$row['report_title'].'</option>';
			}
			echo $finalString;	
			}
		}	 	
	}
	public function getSecFields($secId,$lastsgment){ 
		if($lastsgment=="HFMVRF-Advance-Report" || $lastsgment=="HFMVRF-Advance-Report#"){ 
			$lastsgment = 3;
		} 
		if($lastsgment=="HFCR-Advance-Report" || $lastsgment=="HFCR-Advance-Report#"){
			$lastsgment = 7;
			}  
			if($lastsgment=="HR-Advance-Report" || $lastsgment=="HR-Advance-Report#"){
			$lastsgment = 1;
		    }  
		     if($lastsgment=="Disease-Surveillance-Advance-Report" || $lastsgment=="Disease-Surveillance-Advance-Report#"){
			   $lastsgment = 5;
			   } 
	$query="select * from epifieldstitle where secid = '$secId' and module_id = '$lastsgment' order by recid ";
	$result=$this->db->query($query);
	//print_r($this->db->last_query()); exit;
	$dataArr=$result->result_array();
	
	$body="";
	foreach ($dataArr as $secdata) {

		$body .='<div class="row">
		
				<div class="col-md-9 col-sm-9 cmargin25">
		
					<label class="sec_field_label">'.$secdata["description"].'</label>
		
				</div>
		
				<div class="col-md-1 col-md-offset-1 col-sm-1 col-sm-offset-1">
		
					<input class="form-control" id="sec_fields" name="sec_fields" value="'.$secdata["fid"].'" type="checkbox">
		
				</div>
		
			</div>';
			
	}
			/* if($secId == "ttri"){
				$body .='<div class="row">
				<div class="col-md-3 col-md-offset-5 col-sm-3 col-sm-offset-3  cmargin5">
				<select class="sections-drop form-control" id="label" name="label">
				  <option value="">Select...</option>
				  <option value="TT-1">TT-1</option>
				  <option value="TT-2">TT-2</option>
				  <option value="TT-3">TT-3</option>
				  <option value="TT-4">TT-4</option>
				  <option value="Children Protected">Children Protected at Birth</option>
				</select>
			</div>
			</div>
			<div class="row"
			</div>';
			} */


	$body .='<div class="row">

		<div class="col-md-5 col-md-offset-5 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">

			<a class="btn btn-success" href="#" name="CriteriaAddBtn" id="CriteriaAddBtn" data-sec="'.$secId.'"><i class="fa fa-plus"></i> Add Criteria</a>

			<a class="btn btn-success" href="#" name="advReportAddBtn" id="advReportAddBtn" data-sec="'.$secId.'"><i class="fa fa-floppy-o "></i> Save Report</a>

			<a class="btn btn-success" href="#" data-dismiss="modal" name="closeReportAddBtn" id="closeReportAddBtn" data-sec="'.$secId.'"><i class="fa fa-times"></i> Cancel</a>

		</div>

	</div>';

	echo $body;

}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function ids_report_filter($facode, $distcode, $fweek, $fatype) {
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		$wc=getWC_Array($procode,$distcode,$facode);
		array_walk($wc, function(&$value, $key) {
			$value = "ids_report_form." . $value;
		});
		if ($fweek != "0") {
			$wc[] = "ids_report_form.fweek = '$fweek' ";
		}
		if ($facode != 0) {
			$wc[] = " facilities.facode = '$facode' ";
		}
		if ($fatype != "0") {
			$wc[] = " facilities.fatype = '$fatype' ";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ids_report_form,facilities ";
		// Change `records` according to your table name.
		$query="select facilities.fatype as facilitytype, ids_report_form.facode, is_temp_saved,facilityname(ids_report_form.facode) as facilityname, fweek from ids_report_form,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = ids_report_form.facode order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
		    <td class="text-center">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['facilitytype'] . '</td>
		    <td class="text-center">' . $row['fweek'] . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/ids_report_view/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/ids_report_edit/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		/*echo $statement;
		echo '----'.$per_page;
		echo '----'.$page; 
		exit();*/
		$w=implode(" AND ", $wc)." AND  facilities.facode = ids_report_form.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	
	//Weekly VPD Portion
	public function idsreportSearch($distcode,$ym,$fatype,$facode,$searchParam){
		$distcode = isset($distcode) ? $distcode : $_SESSION['District'];
		$wc = array();
		if($distcode > 0)
		{
			$wc[] = "ids_report_form.distcode = '$distcode'";
		}
		if($fatype > 0)
		{
			$wc[] = "facilities.fatype = '$fatype'";
		}
		if($facode > 0)
		{
			$wc[] = "ids_report_form.facode = '$facode'";
		}
		if($ym > 0)
		{
			$wc[] = "ids_report_form.fweek = '$ym'";
		}
		if(strlen($searchParam)>0 && $searchParam !=' ')
		{
			$wc[] = "(facilityname(ids_report_form.facode) like '%$searchParam%' OR ids_report_form.facode like '%$searchParam%' OR facilities.fatype like '%$searchParam%' OR ids_report_form.fweek like '%$searchParam%')";
		}
		//Code for Pagination Updated by Nouman
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "ids_report_form,facilities ";
		// Change `records` according to your table name.
		$query="select facilities.fatype as facilitytype, ids_report_form.facode,is_temp_saved,facilityname(ids_report_form.facode) as facilityname, fweek from ids_report_form,facilities ".(empty($wc) ? ' WHERE ' : ' WHERE '. implode(" AND ", $wc)." AND ")."   facilities.facode = ids_report_form.facode order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint} ";
		//echo $query;exit();
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : '';
			$i++;
			$tbody .= '<tr>
		    <td class="text-center">' . $i . '</td>
		    <td class="text-center">' . $row['facode'] . '</td>
		    <td class="text-center">' . $row['facilityname'] . '</td>
		    <td class="text-center">' . $row['facilitytype'] . '</td>
		    <td class="text-center">' . $row['fweek'] . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'Data_entry/ids_report_view/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'Data_entry/ids_report_edit/' . $row['facode'] . '/' . $row['fweek'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		    </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		$w=implode(" AND ", $wc)." AND  facilities.facode = ids_report_form.facode";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$w);
		return json_encode($resultJson);
	}
	public function get_idsWeeks($date_from, $date_to, $year) {   

		 if ($date_from !=''){
			$wc = " where date_to >='$date_from' and year = '$year' "; 
		} 
		if ($date_to !=''){
			$wc = " where date_to >='$date_to' and year = '$year' "; 
		}
		$query = "select epi_week_numb as num from epi_weeks $wc ";
		$query = $this -> db -> query($query);
		$result = $query -> row();
		date_default_timezone_set('Asia/Karachi');
		$weekOptions='<option value="0">--Select Week--</option>';
		for($i=1;$i<=$result->num;$i++){
			//$isSelected = (($result->num-1)==$i)?'selected="selected"':'';
			$isSelected = ($result->num==$i)?'selected="selected"':'';
			$month = sprintf("%02d",($i));
			$weekOptions .= '<option '.$isSelected.' value="'.$i.'">Week '.$month.'</option>';
		}
		echo $weekOptions;
	}
	
	public function getmonthlynewborn_target($year,$facode){
		
		$query="select getmonthlynewborn_targetpopulation('$facode','$year') ";
		$resultA=$this->db->query($query);
		$resultA = $resultA->row(); 
		//$toEncode[$getmonthlynewborn_targetpopulation] = $resultA;
		//$result = $resultA;
		
		$query="select getmonthly_survivinginfants('$facode','facility') ";
		$resultB=$this->db->query($query);
		$resultB = $resultB->row(); 
		//$toEncode[$getmonthly_survivinginfants] = $resultB;
		
		$query="select getmonthly_plwomen_target('$facode','$year') ";
		$resultC=$this->db->query($query);
		$resultC = $resultC->row(); 
		//$toEncode[$getmonthly_plwomen_target] = $resultC;
		
		
		$toEncode['getmonthlynewborn_targetpopulation'] = $resultA->getmonthlynewborn_targetpopulation;
		$toEncode['getmonthly_survivinginfants'] = $resultB->getmonthly_survivinginfants;
		$toEncode['getmonthly_plwomen_target'] = $resultC->getmonthly_plwomen_target;
		return json_encode($toEncode);
		//return json_encode($toEncode);
	}
	
	public function check_week_zero_report($epiweek,$year,$distcode){
		
		$wc = " where year ='$year' and week ='$epiweek' and distcode='$distcode' ";
		$query = "select year ,week ,distcode from zero_report $wc";
		$query = $this -> db -> query($query);
		$result = $query->row_array();
		if ($result==true)
		{
			$return = 'yes';
		}
		else
		{
			 $return = 'no';
		}
		 
			return $return;
	}
	
	public function getdoses_per_vial($vaccine_type){
		$wc = "select doses_per_vial from form_a1_vaccine_titles where id='$vaccine_type'";
		$result = $this -> db -> query($wc);
		$result = $result -> row_array();
		return json_encode($result);
	}
	//----------------------------------------FORM C FILTER--------------------------------------------------//
	public function form_c_filter_new($campaign_type) {
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
		$statement = "form_c_new_demand";
		if($campaign_type != ''){
			$wc[] = " campaign_type = '$campaign_type' ";
		}
		
		// Change `records` according to your table name.
		$query="select group_id,campaign_type, start_date, end_date,distcode, districtname(distcode) as districtname, is_temp_saved from form_c_new_demand" . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " and start_date <> '1969-12-31' and end_date <> '1969-12-31' GROUP BY group_id,campaign_type ,start_date, end_date ,distcode, districtname(distcode),is_temp_saved order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}   ";
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
		    <td class="text-center">' . date("d-M-Y",strtotime($row['start_date'])) . '</td>
		    <td class="text-center">' . date("d-M-Y",strtotime($row['end_date'])) . '</td>
			<td class="text-center">' . $is_temp_saved . '</td>
		    <td class="text-center">
		      <a href="' . base_url() . 'UC-Demand-Consumption/View/' . $row['group_id'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		      <a href="' . base_url() . 'UC-Demand-Consumption/Edit/' . $row['group_id'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		  </td>
		            </tr>';
		}
		$resultJson["tbody"] = $tbody;
		
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc,"group_id");
		return json_encode($resultJson);
	}
	public function validateExistRecord($table,$facode,$fmonthSelected,$fmonthPrevious=NULL) {
		$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$checkquery="";
		/* if(isset($fmonthPrevious)){
			if($fmonthSelected == $fmonthPrevious)
				$return = "No";
				$checkquery = "select count(*) as cnt from $table where facode='$facode' and fmonth BETWEEN '$fmonthSelected' and '$fmonthPrevious' and distcode ='$distcode'";
		}
		else{ */
		if($table=='epi_consumption_master'){
			$wc="and is_compiled='1'";
		}else{
			$wc='';
		}
		$checkquery = "select count(*) as cnt from $table where facode='$facode' and fmonth = '$fmonthSelected' and distcode ='$distcode' $wc";
		/* } */
		$checkresult = $this -> db -> query($checkquery);
		$checkrow = $checkresult -> row_array();
		$recexist = (int)$checkrow['cnt'];
		if ($recexist >=1) { 
			$return = "Yes";
		}else{
			$return = "No";
		}
		return $return;
	}
	public function check_compiled_datasource($facode,$fmonth) {
		$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$checkquery="";
		$checkquery = "select is_compiled,data_source from epi_consumption_master where facode='$facode' and fmonth = '$fmonth' and distcode ='$distcode'";
		$result = $this -> db -> query($checkquery);
		$result = $result -> row_array();
		return json_encode($result);
	}
	public function update_is_compiled($facode,$fmonth) {
		$distcode = isset($_REQUEST["distcode"]) ? $_REQUEST["distcode"] : $_SESSION["District"];
		$created_by = $this->session->username;
		$created_date = date("Y-m-d");
		$updated_date = date("Y-m-d");
		$sql = "UPDATE epi_consumption_master SET created_by='" . $created_by . "',created_date='" . $created_date . "',updated_date='" . $updated_date . "',is_compiled='1' where facode='$facode' and fmonth = '$fmonth' and distcode ='$distcode'";
		$result = $this -> db -> query($sql);
		if ($result == 1) {
			$return= "Yes";
		} else{
			$return = "No";
		}
		return $return;
	}
	//----------------------------------------FORM C FILTER--------------------------------------------------//
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
			$wc=" procode = '3' and distcode = '".$this -> session -> District."' and form_date <> '1970-01-01'";
		else
			$wc=" procode = '3' and form_date <> '1970-01-01'";
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc,"group_id");
		return json_encode($resultJson);
	}
	
	public function user_filter($user) {
		//return json_encode("abcs"); exit;

		if ($user != "0") {
					
		$wc=" utype = '$user'";
		$query = "SELECT username, utype, districtname(distcode) as districtname, fullname, level FROM epiusers where $wc" ;
	}else
	{
		$query = "SELECT username, utype, districtname(distcode) as districtname, fullname, level FROM epiusers" ;
		
	}

		//$wc=" utype = $user";
		
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		$statement = "epiusers";
		if ($page <= 0)
			$page = 1;
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			//$is_temp_saved = $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted';
			$i++;
			$tbody .= '<tr>
			    <td class="text-center">' . $i . '</td>
			    <td class="text-left">' . $row['username'] . '</td>
			    <td class="text-center">' . $row['utype'] . '</td>
			    <td class="text-center">' . $row['districtname'] . '</td>
			    <td class="text-center">' . $row['fullname'] . '</td>
			    <td class="text-center">' . $row['level'] . '</td>
			    <td class="text-center">
			      <a href="' . base_url() . 'User_management/user_add?user=' .$row['username'] . '" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
			      <a href="' . base_url() . 'User_management/delete_by_id?user=' . $row['username'] . '" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>
			  	</td>
		    </tr>';
		}
		$resultJson["tbody"] = $tbody; 
		
		//$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc,"");
		return json_encode($resultJson);
	}
	public function facode_validation($fweek,$disease,$facode){
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
		
		$tableCount = "select count(*) from $table where (facode='$facode' OR rb_facode='$facode') AND (distcode='$district' OR rb_distcode='$district') AND fweek='$fweek'";
		$tableCountQuery=$this->db->query($tableCount)->row_array();
		$noOfRecordsInTable = $tableCountQuery['count'];
		
		$zeroReportCount = "select $column as count from zero_report where report_submitted=1 and distcode='$district' and facode='$facode' and fweek='$fweek'";
		$zeroReportCountQuery=$this->db->query($zeroReportCount)->row_array();
		$noOfRecordsInZeroReport = $zeroReportCountQuery['count'];
		
		if($noOfRecordsInTable < $noOfRecordsInZeroReport)
			return 0;
		else
			return 1;
		
	}
	public function moonzerorepcomp($year,$distcode){
				$monthlyPortion = "";
		$outerPortion = "";
		$allouterPortion = "";
		$weeks = lastWeek($year,true);
		for ($ind = 1; $ind <= $weeks; $ind++) {
			$ind = sprintf("%02d", $ind);
			$fweekk = $year."-".$ind;
			$monthlyPortion .= "zeroreport_due('{$fweekk}',districts.distcode)::numeric  AS  \"Due$ind\",zeroreport_sub('{$fweekk}',districts.distcode)::numeric  AS  \"Sub$ind\",zeroreport_tsub('{$fweekk}',districts.distcode)::numeric  AS  \"Tsub$ind\",(select CASE WHEN round(zero_report_timely_submitted_rate('{$fweekk}',districts.distcode)::numeric,1) > 100 THEN 100 ELSE round(zero_report_timely_submitted_rate('{$fweekk}',districts.distcode)::numeric,1) END) AS  \"Timeliness$ind\",
								(select CASE WHEN round(zero_report_submitted_rate('{$fweekk}',districts.distcode)::numeric,1) > 100 THEN 100 ELSE round(zero_report_submitted_rate('{$fweekk}',districts.distcode)::numeric,1) END) AS \"Completeness$ind\",
								(select CASE WHEN round((100-zero_report_submitted_rate('{$fweekk}',districts.distcode))::numeric ,1) < 0 THEN 0 ELSE round((100-zero_report_submitted_rate('{$fweekk}',districts.distcode))::numeric ,1) END)  AS  \"Not Submitted$ind\",";
		}
		//commulative total sub this if for yearly commulative total sub & tsub
				$q = "select get_commulative_sub_ds(".$year.",".$weeks."::integer,'0') as cnt";
				$tsub = $this->db->query($q)->row_array();
				$tsub = $tsub['cnt'];
				//commulative total tsub
				$q = "select get_commulative_tsub_ds(".$year.",".$weeks."::integer,'0') as cnt";
				$ttsub = $this->db->query($q)->row_array();
				$ttsub = $ttsub['cnt'];
				//this is for district wise total commulative sub & tsub 
				$monthlyPortion .= "(select inntable.due01::numeric) As \"Due$ind\",(select  (select get_commulative_sub_ds(".$year.",".$weeks."::integer,districts.distcode) as cnt)::numeric ) AS \"Sub$ind\",(select  (select get_commulative_tsub_ds(".$year.",".$weeks."::integer,districts.distcode) as cnt)::numeric ) AS \"Tsub$ind\",(select  round((select get_commulative_tsub_ds(".$year.",".$weeks."::integer,districts.distcode) as cnt)::numeric/NULLIF(inntable.due01::numeric,0)::numeric*100,1) ) AS \"Total Timeliness$ind\",
									(select round((select get_commulative_sub_ds(".$year.",".$weeks."::integer,districts.distcode) as cnt)::numeric/NULLIF(inntable.due01::numeric,0)::numeric*100,1)  ) AS  \"Total Completeness$ind\",
									(select 100 - round((select get_commulative_sub_ds(".$year.",".$weeks."::integer,districts.distcode) as cnt)::numeric/NULLIF(inntable.due01::numeric,0)::numeric*100,1) ) AS  \"Total Not Submitted$ind\"";
		$query = "select $monthlyPortion from districts join (select distcode,get_commulative_fstatus_ds({$year},{$weeks},d1.distcode) as due01 from districts d1) as inntable ON inntable.distcode=districts.distcode where districts.distcode = '".$distcode."' ORDER BY districts.district";
		$result = $this -> db -> query($query);
		return $data['allData'] = $result -> row_array();
	}
		public function moonzerorepcomp_data($year,$distcode){
		$monthlyPortion = "";
		$outerPortion = "";
		$allouterPortion = "";
		$weeks = lastWeek($year,true);
		for ($ind = 1; $ind <= $weeks; $ind++) {
			$ind = sprintf("%02d", $ind);
			$fweekk = $year."-".$ind;
			$monthlyPortion .= "(select zeroreport_tsub('{$fweekk}',districts.distcode)) AS  \"tsubwk$ind\",
								(select zeroreport_sub('{$fweekk}',districts.distcode)) AS \"subwk$ind\",
								(select zeroreport_due('{$fweekk}',districts.distcode)) AS \"duewk$ind\",";
		}
/* 		$monthlyPortion .= "(select CASE WHEN round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) > 100 THEN 100 ELSE round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) END from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek like '$year-%' and week::numeric > 0 and distcode = districts.distcode ) AS  \"Total Timeliness$ind\",
							(select CASE WHEN round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) > 100 THEN 100 ELSE round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) END from zero_report where report_submitted = '1' and fweek like '$year-%' and week::numeric > 0 and distcode = districts.distcode ) AS  \"Total Completeness$ind\",
							(select CASE WHEN 100-round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) < 0 THEN 0 ELSE 100-round((count(facode)::float//(inntable.due01::numeric))::numeric*100,1) END from zero_report where report_submitted = '1' and fweek like '$year-%' and week::numeric > 0 and distcode = districts.distcode ) AS  \"Total Not Submitted$ind\""; */
						$monthlyPortion=rtrim($monthlyPortion,',');		
		$query = "select $monthlyPortion from districts join (select distcode,get_commulative_fstatus_ds({$year},{$weeks},d1.distcode) as due01 from districts d1) as inntable ON inntable.distcode=districts.distcode where districts.distcode = '".$distcode."' ORDER BY districts.district";
		$result = $this -> db -> query($query);
		return $data['allData'] = $result -> row_array();
		
	}
	public function getfacilitiesby_uncode($uncode) {
		$query = "SELECT fac_name,facode from facilities where uncode = '$uncode' order by facode ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['fac_name'] . '</option>';
		}
		return $data;
	}
	
	public function getVillages($uncode) {
		$query = "SELECT village,vcode from villages where uncode = '$uncode' order by village ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['vcode'] . '">' . $fac_data['village'] . '</option>';
		}
		return $data;
	}
	
	public function getcerv_villages($facode) {
		$query = "SELECT village,vcode from cerv_villages where facode = '$facode' order by village ASC ";
		//print_r($query);exit;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['vcode'] . '">' . $fac_data['village'] . '</option>';
		}
		return $data;
	}
	
	public function getred_rec_village($sessiontype,$uncode) {
		$distcode = $this -> session -> District;
		//print_r($uncode); exit;
		$query = "SELECT CASE WHEN session_type = 'Fixed' THEN sitename_s ELSE area_code END AS code,
		            session_type FROM hf_quarterplan_dates_db WHERE distcode='$distcode' and  session_type = '$sessiontype' and uncode='$uncode' order by sitename_s ASC " ;
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $rv_data) {
			if($rv_data['session_type']=='Fixed'){
				$data .= '<option value="' . $rv_data['code'] . '">' . get_Facility_Name($rv_data['code']) . '</option>';
			}else
			$data .= '<option value="' . $rv_data['code'] . '">' . get_Village_Name($rv_data['code']) . '</option>';
		}
		//print_r($data); exit;
		return $data;
	}
	public function getTargetPopulation($vcode,$year) {
		$query = "SELECT population,get_indicator_periodic_multiplier('survivinginfants','$year') as survivinginfants, get_indicator_periodic_multiplier('newborn','$year') as newborn from villages_population where vcode = '$vcode' and year='$year'";
		//$query = "SELECT population from villages_population where vcode = '$vcode' and year='$year'";
		$result = $this -> db -> query($query);
		$result= $result -> row();
		//print_r($result);exit;
		return json_encode($result);
	}
	public function tehsil_uc_wise_villages($tcode,$uncode) {
		$wc='';
		if($tcode > 0 ){
			$wc="AND tcode='$tcode'";	
		}if($uncode > 0 ){
			$wc="AND tcode='$tcode' AND uncode='$uncode'";
		}
		
		$query=$this->db->query("select vcode, distcode,unname(uncode) as unioncouncil, uncode, tcode, facode, village,added_date,
				(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y")-1)."') as previous,
				(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y"))."') as current,
				(select population from villages_population where vcode=villages.vcode and year='".(string)(date("Y")+1)."') as next
				from villages where distcode='".$_SESSION['District']."' $wc order by unioncouncil");
				
			$data['row'] =$query->result_array();
			$var =  $this-> load-> view('Population-village-row',$data);
	}
	public function checkfatherNIC($nic){
		$query = "SELECT fathercnic from cerv_child_registration where fathercnic='".$nic."'";
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;

	}
	public function checkchildmotherNIC($nic){
		$query = "SELECT mothercnic from cerv_child_registration where mothercnic='".$nic."'";
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;

	}
	/* public function CheckChlidRegistrationNo($child_registration_no){
		$query = "SELECT * from cerv_child_registration where child_registration_no='".$child_registration_no."'";
		$query= $this->db->query($query);
		$data['data'] = $query->row_array(); 
		if($data['data']['child_registration_no'] != ''){
			
			$var =  $this-> load-> view('childs/Child_migrate_record',$data);
		}else{
			echo"<h5>Child Not fount <h5>";
		}
		//$data='';
		//$var =  $this-> load-> view('childs/Child_migrate_record',$data);
		//return $result;
	} */
	
	public function CheckChlidRegistrationNo($child_registration_no){
		$query = "SELECT recno,child_registration_no from cerv_child_registration where child_registration_no='".$child_registration_no."'";
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;
	}  
	
	public function CheckMotherRegistrationNo($mother_registration_no){
		$query = "SELECT recno,mother_registration_no from cerv_mother_registration where mother_registration_no='".$mother_registration_no."'";
		
		
		//print_r($query);exit;
		
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;
	}
	
	public function checkmotherNIC($nic){
		$query = "SELECT mother_cnic from cerv_mother_registration where mother_cnic='".$nic."'";
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;
	}
	/* public function CheckmotherRegistrationNo($child_registration_no){
		$query = "SELECT mother_registration_no from cerv_mother_registration where mother_registration_no='".$child_registration_no."'";
		$query= $this->db->query($query);
		$result = $query->row_array();
		return $result;
	} */
	public function get_Hr_sub_type_option($hr_sub_type_id) {
		//$supervisor_type = $_REQUEST['supervisor_type'];
		$distcode = $this->session->District;
		//$query = "select code as supervisorcode, name as supervisor  from hr_db where  distcode='$distcode' And hr_sub_type_id='$hr_sub_type_id'";
		$query = "SELECT new as supervisorcode,name as supervisor from (SELECT DISTINCT ON (code) code,code as new, * FROM hr_db_history ORDER BY code DESC, id DESC ) subquery where post_status='Active' and  post_distcode='$distcode' And post_hr_sub_type_id='$hr_sub_type_id' ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();	
	    $data = '<option value="">--Select--</option>';
		foreach ($result as $sup_data) {
			$data .= '<option value="' . $sup_data['supervisorcode'] . '">' . $sup_data['supervisor'] . '</option>';
		}
		return $data;
	}
	//-----------------------------------------------------------------------------------------------//
	//--------------------- Situation Analysis Filter -----------------------------------------------//
	public function child_list_filter($tcode,$uncode,$facode,$village,$techniciancode){
		$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		}
		//print_r($_GET["page"]);exit;
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 200;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "situation_analysis_db";
		/* if($recno != ''){
			$wc[] = " recno = '$recno' ";
		} */
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode != ''){
			$wc[] = " uncode = '$uncode' ";
		}
		if($facode != ''){
			$wc[] = " reg_facode = '$facode' ";
		}
		if($village != ''){
			$wc[] = " villagemohallah = '$village' ";
		}
		if($techniciancode != ''){
			$wc[] = " techniciancode = '$techniciancode' ";
		}
		/* if($techniciancode != ''){
			$wc[] = " techniciancode = '$techniciancode' ";  technicianname(techniciancode) as technician,
		} *//* 
		if($village > 0){
			$wc[] = " villagemohallah = '$village' ";
		} */

		$query="SELECT recno,cardno,nameofchild,dateofbirth,fathername,tehsilname(tcode) as tehsil, unname(uncode) as unioncouncil, villagemohallah from cerv_child_registration " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " group by recno,cardno,nameofchild,fathername,dateofbirth,tcode,uncode,villagemohallah,year order by year DESC, villagemohallah ASC LIMIT {$per_page} OFFSET {$startpoint}";
		//print_r($query);exit;
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td class="text-left">' . $row['cardno'] . '</td>			
							<td class="text-center">' . $row['nameofchild'] . '</td>
							<td class="text-center">' . $row['dateofbirth'] . '</td>
							<td class="text-center">' . $row['fathername'] . '</td>
							<td class="text-center">' . $row['tehsil'] . '</td>
							<td class="text-left">' . $row['unioncouncil'] . '</td>
							<td class="text-left">' . get_Village_Name($row['villagemohallah']) . '</td>
							<td class="text-center">
								<a data-original-title="edit"  data-toggle="tooltip" class="btn btn-xs btn-default edit" href="' . base_url() . 'Reports/ChildRegistrationEdit/'. $row['recno'] .' " data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fas fa-edit text-white"></i></a>
								<a href="' . base_url() . 'Reports/ChildRegistrationView/'. $row['recno'] .' " data-original-title="View" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	}
	// start 
	
	
	 public function child_card_number($cardno) {
		$query = "SELECT cardno from cerv_child_registration where cardno = '$cardno'";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['cardno'] . '">' . $fac_data['cardno'] . '</option>';
		}  
		return $data;
	} 
	
	/* public function child_list_filter($recno){
		 $procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : $_SESSION['Province'];
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$wc = getWC_Array($_SESSION["Province"],$distcode);
		}else{
			$wc = getWC_Array($_SESSION["Province"]);
		} 
		print_r($_GET["page"]);exit;
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0)
			$page = 1;
		$per_page = 15;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "situation_analysis_db";
		 if($recno != ''){
			$wc[] = " recno = '$recno' ";
		} 
		if($tcode != ''){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode != ''){
			$wc[] = " uncode = '$uncode' ";
		}
		if($village > 0){
			$wc[] = " villagemohallah = '$village' ";
		}

		$query="SELECT recno,cardno,nameofchild,dateofbirth,fathername,tehsilname(tcode) as tehsil, unname(uncode) as unioncouncil,villagemohallah from cerv_child_registration " . (empty($wc) ? '' : ' where ' . implode(" AND ", $wc)) . " group by recno,cardno,nameofchild,fathername,dateofbirth,tcode,uncode,villagemohallah,year order by year DESC, villagemohallah ASC LIMIT {$per_page} OFFSET {$startpoint}";
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		$i = $startpoint;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td class="text-center">' . $i . '</td>	
							<td class="text-left">' . $row['cardno'] . '</td>			
							<td class="text-center">' . $row['nameofchild'] . '</td>
							<td class="text-center">' . $row['dateofbirth'] . '</td>
							<td class="text-center">' . $row['fathername'] . '</td>
							<td class="text-center">' . $row['tehsil'] . '</td>
							<td class="text-left">' . $row['unioncouncil'] . '</td>
							<td class="text-left">' . get_Village_Name($row['villagemohallah']) . '</td>
							<td class="text-center">
								<a href="' . base_url() . 'Reports/ChildRegistrationEdit/'. $row['recno'] .' " data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		$wc = implode(" AND ", $wc);
		$wc = getWC();
		$resultJson["paging"] = $this -> Common_model -> pagination($statement,$per_page,$page,$url = "?",$wc);
		return json_encode($resultJson);
	} */
	
	
	//End
}
?>