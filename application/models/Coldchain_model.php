<?php
class Coldchain_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> library('breadcrumbs');
	}
	//============================ Constructor Function Ends ============================//
	//=================================================================================//
	//================ Supervisor Listing Function Starts ================//
	public function rev_health_facility_questionnaire_pak(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Health Facility Questionnaire', '/coldchain/rev_health_facility_questionnaire_pak');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by distcode";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//----------------------------------------------------------------------------------------------------//
	public function rev_health_facility_questionnaire_pak_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Questionnaires', '/Coldchain/rev_health_facility_questionnaire_pak_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_hf_questionnaire where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//================ Function for Saving New or Existing Questionnaire Record Starts Here =================//
	public function rev_health_facility_questionnaire_pak_save($rhfqpData){
		if($this -> input -> post ('edit')){
			//echo 'here <br><pre>';print_r($rhfqpData);echo '</pre>';exit();
			$id = $this -> input -> post ('id');
			$updateQuery = $this -> Common_model -> update_record('epi_hf_questionnaire',$rhfqpData,array('id'=>$id));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "Coldchain/rev_health_facility_questionnaire_pak_list";
				$message="Record Updated for Health Facility Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "Coldchain/rev_health_facility_questionnaire_pak_list";
				$message="Record Updated for Health Facility Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$result = $this -> Common_model -> insert_record('epi_hf_questionnaire', $rhfqpData);
			if($result != 0){
				$location = base_url(). "Coldchain/rev_health_facility_questionnaire_pak_list";
				$message="Record Saved Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Questionnaire Record Starts Here ===============//
	public function rev_health_facility_questionnaire_pak_edit($qcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Questionnaire', '/Coldchain/rev_health_facility_questionnaire_pak_list');
		$this->breadcrumbs->push('Update Questionnaire', '/Coldchain/rev_health_facility_questionnaire_pak_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$wc = getWC();//helper function
		$query="select *, facilityname(facode) as facilityname from epi_hf_questionnaire where id = '$qcode' ";
		$result=$this -> db -> query ($query);
		$data['qdata']=$result -> row_array();
		//echo '<pre>';print_r($data['qdata']);echo '</pre>';exit;
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result = $this -> db -> query($query);
		$data['resultDist'] = $result -> result_array();	
		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//================ Function to Show Page for Editing Existing Questionnaire Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Questionnaire Record Starts Here ==============//
	public function rev_health_facility_questionnaire_pak_view($code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Questionnaire', '/Coldchain/rev_health_facility_questionnaire_pak_list');
		$this->breadcrumbs->push('Questionnaire View', '/Coldchain/rev_health_facility_questionnaire_pak_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, districtname(distcode), tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from epi_hf_questionnaire where id='$code'"; 
		$result=$this -> db -> query ($query);
		$data['a']=$result -> row_array();
		//echo '<pre>';print_r($data['qdata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Refrigerator Listing Function Ends Here =============================//
	public function refrigerator_questionnaire(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Health Facility Questionnaire', '/coldchain/refrigerator_questionnaire');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by distcode";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
		//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Refrigerator Questionnaire Record Starts Here =================//
	public function refrigerator_questionnaire_save($refData){
		if($this -> input -> post ('edit')){
			//echo 'here <br><pre>';print_r($rhfqpData);echo '</pre>';exit();
			$id = $this -> input -> post ('id');
			$updateQuery = $this -> Common_model -> update_record('epi_refrigerator_questionnaire',$refData,array('id'=>$id));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "Refrigerator-Questionnaire/List";
				$message="Record Updated for Refrigerator Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "Refrigerator-Questionnaire/List";
				$message="Record Updated for Refrigerator Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			//print_r(refData);exit;
			$result = $this -> Common_model -> insert_record('epi_refrigerator_questionnaire', $refData);
			if($result != 0){
				$location = base_url(). "Refrigerator-Questionnaire/List";
				$message="Record Saved Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//---------------------------------------------------------------------------------------------------------//
	//================ Refrigerator Questionnaire Listing Function Starts ================//
	public function refrigerator_questionnaire_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Refrigerator Questionnaires', '/Coldchain/refrigerator_questionnaire_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_refrigerator_questionnaire where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Function to Show Page for Editing Existing Refrigerator Questionnaire Record Starts Here ===============//
	public function refrigerator_questionnaire_edit($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Refrigerator Questionnaire', '/Coldchain/refrigerator_questionnaire_list');
		$this->breadcrumbs->push('Update Refrigerator Questionnaire', '/Coldchain/refrigerator_questionnaire_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$wc = getWC();//helper function
		$query="select *, facilityname(facode) as facilityname from epi_refrigerator_questionnaire where id = '$rcode' ";
		$result=$this -> db -> query ($query);
		$data['rdata']=$result -> row_array();
		//echo '<pre>';print_r($data['rdata']);echo '</pre>';
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result = $this -> db -> query($query);
		$data['resultDist'] = $result -> result_array();	
		$query = "select quarter FROM epi_refrigerator_questionnaire WHERE id = '$rcode' ";
		$result = $this -> db -> query($query);
		$data['quarter'] = $result -> result_array();
		$query = "select year FROM epi_refrigerator_questionnaire WHERE id = '$rcode' ";
		$result = $this -> db -> query($query);
		$data['year'] = $result -> result_array();
		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		
		//echo '<pre>';print_r($data['resultFac']);echo '</pre>';exit;
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//================ Function to Show Page for Editing Existing Questionnaire Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Refrigerator Questionnaire Record Starts Here ==============//
	public function refrigerator_questionnaire_view($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Refrigerator Questionnaire', '/Coldchain/refrigerator_questionnaire_list');
		$this->breadcrumbs->push('Refrigerator Questionnaire View', '/Coldchain/refrigerator_questionnaire_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, districtname(distcode), tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from epi_refrigerator_questionnaire where id='$rcode'"; 
		$result=$this -> db -> query ($query);
		$data['a']=$result -> row_array();
		//echo '<pre>';print_r($data['rdata']);echo '</pre>';exit;
		return $data;
	}
	//=========================== Cold Room Function Starts Here ============================================//
	public function coldroom_questionnaire(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Cold Room Questionnaire', '/coldchain/coldroom_questionnaire');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by distcode";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//================ Cold Room Questionnaire Listing Function Starts ================//
	public function coldroom_questionnaire_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Room Questionnaires', '/Coldchain/coldroom_questionnaire_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_coldroom_questionnaire where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Function for Saving New or Existing Cold Room Questionnaire Record Starts Here =================//
	public function coldroom_questionnaire_save($refData){
		if($this -> input -> post ('edit')){
			$id = $this -> input -> post ('id');
			$updateQuery = $this -> Common_model -> update_record('epi_coldroom_questionnaire',$refData,array('id'=>$id));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "Coldroom-Questionnaire/List";
				$message="Record Updated for Cold Room Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "Coldroom-Questionnaire/List";
				$message="Record Updated for Cold Room Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$result = $this -> Common_model -> insert_record('epi_coldroom_questionnaire', $refData);
			if($result != 0){
				$location = base_url(). "Coldroom-Questionnaire/List";
				$message="Record Saved Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}	
	//================ Function to Show Page for Viewing Existing Cold Room Questionnaire Record Starts Here ==============//
	public function coldroom_questionnaire_view($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Room Questionnaire', '/Coldchain/coldroom_questionnaire_list');
		$this->breadcrumbs->push('Cold Room Questionnaire View', '/Coldchain/coldroom_questionnaire_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, districtname(distcode), tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from epi_coldroom_questionnaire where id='$rcode'"; 
		$result=$this -> db -> query ($query);
		$data['a']=$result -> row_array();
		//echo '<pre>';print_r($data['rdata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Editing Existing Cold Room Questionnaire Record Starts Here ===============//
	public function coldroom_questionnaire_edit($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Room Questionnaire', '/Coldchain/coldroom_questionnaire_list');
		$this->breadcrumbs->push('Update Cold Room Questionnaire', '/Coldchain/coldroom_questionnaire_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$wc = getWC();//helper function
		$query="select *, facilityname(facode) as facilityname from epi_coldroom_questionnaire where id = '$rcode' ";
		$result=$this -> db -> query ($query);
		$data['rdata']=$result -> row_array();
		//echo '<pre>';print_r($data['rdata']);echo '</pre>';
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result = $this -> db -> query($query);
		$data['resultDist'] = $result -> result_array();	
		$query = "select quarter FROM epi_coldroom_questionnaire where id = '$rcode' ";
		$result = $this -> db -> query($query);
		$data['resultQtr'] = $result -> result_array();
		$query = "select year FROM epi_coldroom_questionnaire where id = '$rcode' ";
		$result = $this -> db -> query($query);
		$data['resultyr'] = $result -> result_array();
		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		
		//echo '<pre>';print_r($data['resultFac']);echo '</pre>';exit;
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//====================================================================================================================//
	//====================================================================================================================//
	//=========================== Voltage Regulators/Stabilizers Function Starts Here ====================================//
	public function voltage_questionnaire(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Voltage Regulators/Stabilizers Questionnaire', '/coldchain/voltage_questionnaire');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by distcode";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//================ Voltage Regulators/Stabilizers Questionnaire Listing Function Starts ================//
	public function voltage_questionnaire_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Voltage Regulators/Stabilizers Questionnaires', '/Coldchain/voltage_questionnaire_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_voltage_questionnaire where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Function for Saving New or Existing Voltage Regulators/Stabilizers Questionnaire Record Starts Here =================//
	public function voltage_questionnaire_save($refData){
		if($this -> input -> post ('edit')){
			//echo 'here <br><pre>';print_r($rhfqpData);echo '</pre>';exit();
			$id = $this -> input -> post ('id');
			$updateQuery = $this -> Common_model -> update_record('epi_voltage_questionnaire',$refData,array('id'=>$id));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "Voltage-Questionnaire/List";
				$message="Record Updated for Voltage Regulators/Stabilizers Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "Voltage-Questionnaire/List";
				$message="Record Updated for Voltage Regulators/Stabilizers Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$result = $this -> Common_model -> insert_record('epi_voltage_questionnaire', $refData);
			if($result != 0){
				$location = base_url(). "Voltage-Questionnaire/List";
				$message="Record Saved Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function to Show Page for Viewing Existing Voltage Regulators/Stabilizers Questionnaire Record Starts Here ==============//
	public function voltage_questionnaire_view($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Voltage Regulators/Stabilizers Questionnaire', '/Coldchain/voltage_questionnaire_list');
		$this->breadcrumbs->push('Voltage Regulators/Stabilizers Questionnaire View', '/Coldchain/voltage_questionnaire_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, districtname(distcode), tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from epi_voltage_questionnaire where id='$rcode'"; 
		$result=$this -> db -> query ($query);
		$data['a']=$result -> row_array();
		//echo '<pre>';print_r($data['vdata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Editing Existing Voltage Regulators/Stabilizers Questionnaire Record Starts Here ===============//
	public function voltage_questionnaire_edit($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Voltage Regulators/Stabilizers Questionnaire', '/Coldchain/voltage_questionnaire_list');
		$this->breadcrumbs->push('Update Voltage Regulators/Stabilizers Questionnaire', '/Coldchain/voltage_questionnaire_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$wc = getWC();//helper function
		$query="select *, facilityname(facode) as facilityname from epi_voltage_questionnaire where id = '$rcode' ";
		$result=$this -> db -> query ($query);
		$data['vdata']=$result -> row_array();
		//echo '<pre>';print_r($data['vdata']);echo '</pre>';
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result = $this -> db -> query($query);
		$data['resultDist'] = $result -> result_array();	
		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		
		//echo '<pre>';print_r($data['resultFac']);echo '</pre>';exit;
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//======================================================================================================//
	//======================================================================================================//
	//=========================== Generators Function Starts Here ==========================================//
	public function generator_questionnaire(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Generators Questionnaire', '/coldchain/generator_questionnaire');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by distcode";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//================ Generators Questionnaire Listing Function Starts ================//
	public function generator_questionnaire_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Generators Questionnaires', '/Coldchain/generator_questionnaire_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from epi_generator_questionnaire where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Function for Saving New or Existing Generators Questionnaire Record Starts Here =================//
	public function generator_questionnaire_save($refData){
		if($this -> input -> post ('edit')){
			//echo 'here <br><pre>';print_r($rhfqpData);echo '</pre>';exit();
			$id = $this -> input -> post ('id');
			$updateQuery = $this -> Common_model -> update_record('epi_generator_questionnaire',$refData,array('id'=>$id));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "Generator-Questionnaire/List";
				$message="Record Updated for Generators Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "Generator-Questionnaire/List";
				$message="Record Updated for Generators Questionnaire with Code ".$id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$result = $this -> Common_model -> insert_record('epi_generator_questionnaire', $refData);
			if($result != 0){
				$location = base_url(). "Generator-Questionnaire/List";
				$message="Record Saved Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function to Show Page for Viewing Existing Generators Questionnaire Record Starts Here ==============//
	public function generator_questionnaire_view($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Generators Questionnaire', '/Coldchain/generator_questionnaire_list');
		$this->breadcrumbs->push('Generators Questionnaire View', '/Coldchain/generator_questionnaire_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, districtname(distcode), tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from epi_generator_questionnaire where id='$rcode'"; 
		$result=$this -> db -> query ($query);
		$data['a']=$result -> row_array();
		//echo '<pre>';print_r($data['gdata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Editing Existing Generators Questionnaire Record Starts Here ===============//
	public function generator_questionnaire_edit($rcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Generators Questionnaire', '/Coldchain/generator_questionnaire_list');
		$this->breadcrumbs->push('Update Generators Questionnaire', '/Coldchain/generator_questionnaire_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$wc = getWC();//helper function
		$query="select *, facilityname(facode) as facilityname from epi_generator_questionnaire where id = '$rcode' ";
		$result=$this -> db -> query ($query);
		$data['gdata']=$result -> row_array();
		//echo '<pre>';print_r($data['gdata']);echo '</pre>';
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result = $this -> db -> query($query);
		$data['resultDist'] = $result -> result_array();	
		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		
		//echo '<pre>';print_r($data['resultFac']);echo '</pre>';exit;
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();
		return $data;
	}
	//======================================================================================================//
	//================ Generators Questionnaire Listing Function Starts ================//
	public function transport_questionnaire_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Transport Questionnaires', '/Coldchain/transport_questionnaire_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function		
		$query = "Select  facode,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select id,date_submitted,facode,facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from transport_questionnaire_main where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//=============== Vaccine Carriers,Cold Box & Ice Packs Listing Function Starts ================//
	public function vacc_carriers_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Vaccine Carriers, Cold Box & Ice Packs', '/Coldchain/vacc_carriers_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select DISTINCT fatype from facilities where $wc and hf_type='e' order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select id,date_submitted,facode,facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from vacc_carriers_main where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//print_r($data['results']);exit;
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	
	/* Code by UZair */
	public function get_all_coldchain_assets_types($id=NULL){
		$wc ="";
		if($id!=NULL){
			$wc ="and parent_id='{$id}'";
		}
		/* $this -> db -> select('*');
		$this -> db -> where('status',1); 
		return $this -> db -> get('epi_cc_asset_types') -> result_array(); */
		$query = "select * from epi_cc_asset_types where status='1' $wc";
		//echo $query; exit;
		$results = $this -> db -> query($query);
		return $results -> result_array();
	}
	public function get_all_cc_makes(){
		$this -> db -> select('*');
		$this -> db -> where('status','1'); 
		return $this -> db -> get('epi_cc_makes') -> result_array();
	}
	public function get_all_makes_models(){
		$this -> db -> select('pk_id,model_name,makername(ccm_make_id) as make,assetname(asset_type_id) as asset_type');
		$this -> db -> where('status','1');
		return $this -> db -> get('epi_cc_models') -> result_array();
	}
	public function getModel($assetTypeId=NULL,$modelID=NULL)
	{
		$wc="";
		if($assetTypeId!=NULL)
		{
			$wc=" asset_type_id = '{$assetTypeId}'";
		}
		if($modelID!=NULL)
		{
			$wc=" pk_id = '{$modelID}'";
		}
		$query = "select pk_id, model_name, catalogue_id from epi_cc_models where  {$wc}";
		$results = $this -> db -> query($query);
		return $results -> result_array();
	}
	public function getMake($assetTypeId)
	{
		//$query = "select distinct mk.pk_id,make_name from epi_cc_makes mk join epi_cc_models md on md.ccm_make_id=mk.pk_id where md.asset_type_id='{$assetTypeId}'";
		
		$query = "select DISTINCT ON (makername(md.ccm_make_id)) makername(md.ccm_make_id) as make_name ,mk.pk_id,ccm_make_id from epi_cc_models md
				join epi_cc_makes mk on mk.pk_id=md.ccm_make_id
				where md.asset_type_id='{$assetTypeId}' and mk.make_name is not null and md.is_active='1'"; 
		$results = $this -> db -> query($query);
		return $results -> result_array();
	}
	public function getSearch($wc,$table = FALSe)
	{
		$tbleSElect="";
		$icpackcheck="";
		if($table == 'epi_ccm_vehicles')
		{
			$tbleSElect=",tble.fuel_type_id as fule_type";
		}
		elseif($table == 'epi_ccm_cold_rooms')
		{
			$tbleSElect=",tble.gross_capacity";
		}
		if($table == "icePack")
		{
			$select ="asset_id as id,history.warehouse_type_id,districtname(history.distcode) ,history.procode,history.distcode,tehsilname(history.tcode),history.tcode,facilityname(history.facode),history.facode,makername(md.ccm_make_id) as make_name,md.model_name,ccm.serial_no,history.date::date,ccm.status,md.gross_capacity_20,history.total_quantity,history.working_quantity";
		}
		else
		{
			$select ="asset_id as id,districtname(distcode) ,warehouse_type_id,ccm.procode,ccm.distcode,ccm.tcode,ccm.facode,tehsilname(tcode),facilityname(facode),makername(md.ccm_make_id) as make_name,md.model_name,ccm.serial_no,ccm.created_date::date,ccm.status,md.gross_capacity_20 {$tbleSElect} ";
		}
		$this->db->select("{$select}",FALSe);
		$this->db->from("epi_cc_coldchain_main ccm");
		if($table=="icePack")
		{
			$this->db->join("epi_cc_asset_status_history history","history.pk_id = ccm.ccm_status_history_id");
			$table = FALSe;
			$icpackcheck="icePack";
		}
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		if($table=="icePack")
		{
			$this->db->join("{$table} tble","tble.ccm_id = ccm.asset_id");
		}
		else
		{
			$this->db->join("epi_cc_asset_types assetTypes","assetTypes.pk_id = ccm.ccm_sub_asset_type_id");
		}
		if($icpackcheck == "icePack")
		{
			$inClause= array(0,$wc['history.warehouse_type_id']);
			unset($wc['history.warehouse_type_id']);
		}else{
			$inClause= array(0,$wc['warehouse_type_id']);
			unset($wc['warehouse_type_id']);
		}
		$this->db->where($wc);
		if($icpackcheck == "icePack")
		{
			$this->db->where_in('history.warehouse_type_id', $inClause);
		}else{
			$this->db->where_in('warehouse_type_id', $inClause);
		}
		 return $this->db->get()->result_array(); //echo $this->db->last_query();exit;
	}
	public function getRrefVaccData($recordID)///for refrigerator and vaccine carrie
	{
		$this->db->select("ccm.ccm_model_id,ccm_user_asset_id as asset_id,source_id ,ccm.quantity,ccm.status,catalogue_id,makername(md.ccm_make_id) as make_name,md.model_name,assetname(md.ccm_sub_asset_type_id),md.asset_type_id,cfc_free,asset_dimension_length as length,asset_dimension_width as width,asset_dimension_height as height,gross_capacity_20,gross_capacity_4,net_capacity_20,net_capacity_4,serial_no,ccm.working_since::date ,warehouse_type_id,ccm.procode,distcode,tcode,facode,uncode,storecode",FALSE);
		$this->db->from("epi_cc_coldchain_main ccm");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array(); //echo $this->db->last_query();
	}
	public function getColdroomData($recordID)
	{
		$this->db->select("ccm.ccm_model_id,source_id ,cr.cooling_system,cr.backup_generator,cr.temperature_recording_system,ccm.serial_no,ccm_user_asset_id as asset_id,ccm.status,catalogue_id,makername(md.ccm_make_id) as make_name,md.model_name,assetname(md.ccm_sub_asset_type_id),asset_dimension_length as length,asset_dimension_width as width,asset_dimension_height as height,gross_capacity,net_capacity,has_voltage,gas_type,ccm.working_since::date ,warehouse_type_id,ccm.procode,distcode,tcode,uncode,facode",FALSE);
		$this->db->from("epi_ccm_cold_rooms cr");
		$this->db->join("epi_cc_coldchain_main ccm","ccm.asset_id=cr.ccm_id");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array();// $this->db->last_query();
	}
	public function getGeneratorData($recordID)
	{
		$this->db->select("ccm.ccm_model_id,ccm_user_asset_id as asset_id,source_id ,gn.use_for,gn.power_source,md.asset_type_id,gn.power_rating,gn.automatic_start_mechanism,ccm.status,makername(md.ccm_make_id) as make_name,md.model_name,ccm.working_since::date,serial_no,(select (regexp_split_to_array(short_name, '-'))[2]) as shortnumber ,warehouse_type_id,ccm.procode,distcode,tcode,uncode,facode",FALSE);
		$this->db->from("epi_ccm_generators gn");
		$this->db->join("epi_cc_coldchain_main ccm","ccm.asset_id=gn.ccm_id");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array();//echo $this->db->last_query();exit;
	}
	public function getTransportData($recordID)
	{
		$this->db->select("md.ccm_make_id,assetname(md.ccm_sub_asset_type_id)as asset_name,ccm.ccm_sub_asset_type_id,ccm.ccm_model_id,ccm_user_asset_id as asset_id,source_id,registration_no,engine_no,chases_no,ccm.status,makername(md.ccm_make_id) as make_name,md.model_name,ccm.working_since::date,serial_no,registration_no,comments,fuel_type_id,vh.ccm_sub_asset_type_id as transport_type,used_for_epi,warehouse_type_id,ccm.procode,distcode,tcode,uncode,facode",FALSE);
		$this->db->from("epi_ccm_vehicles vh");
		$this->db->join("epi_cc_coldchain_main ccm","ccm.asset_id=vh.ccm_id");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array(); //echo $this->db->last_query();exit;
	}
	public function getVoltageRegulatorData($recordID)
	{
		$this->db->select("makername(md.ccm_make_id) as make_name,ccm.ccm_model_id,ccm.quantity,md.model_name,serial_no,md.input_voltage_range,md.output_voltage_range,md.frequency,product_price,ccm.working_since::date ,warehouse_type_id,ccm.procode,distcode,tcode,uncode,facode",FALSE);
		$this->db->from("epi_cc_coldchain_main ccm");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array(); //echo $this->db->last_query();exit;
	}
	public function allassets_list($per_page,$startpoint,$multiple_search)
	{
		$id=null;
		$wc = getWC();
		$data=array(); 
		$_currentdate  = date('Y-m-d');
		//print_r($id);exit;
		$assetsid= array('1');
		$status = 'ccm.status';
		$join ='';
		if($id != null && in_array($id,$assetsid))
		{
			$status ='history.status';
			$join = 'LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id ';
		}//print_r($multiple_search);exit;
		if($this->session->Tehsil){
			$tehsil=$this->session->Tehsil;
			$tcode="and ccm.tcode='$tehsil'";
		}else{
			$tcode='';
		}
		$procode = $this->session->Province;
		$query ="SELECT asset_id as id,warehousetypename(ccm.warehouse_type_id) as stroe_level,ccm.storecode,ccm.ccm_user_asset_id, 
				get_store_name(ccm.warehouse_type_id,CAST(storecode AS VARCHAR(9))) as storename,ccm.source_id,
				ccm.warehouse_type_id,ccm.procode,ccm.distcode,districtname(ccm.distcode) as district, 
				ccm.tcode, ccm.facode, tehsilname(ccm.tcode),facilityname(ccm.facode), 
				makername(md.ccm_make_id) as make_name,md.model_name, ccm.quantity,
				md.net_capacity_4, {$status} as status, ccm.created_date::date,  
				md.gross_capacity_20 as capacity,ccm.short_name
				FROM 
				epi_cc_coldchain_main ccm 
				JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id
				{$join}
				JOIN epi_cc_asset_types assetTypes ON assetTypes.pk_id = ccm.ccm_sub_asset_type_id 
				WHERE ccm.procode = '{$procode}' {$multiple_search} and asset_status ='Active' $tcode order by warehouse_type_id desc LIMIT {$per_page} OFFSET {$startpoint}";
		//echo $query; exit;
		$result = $this -> db -> query($query);
		$data['refrigerator_data'] = $result -> result_array();
		return $data;
	}
	public function coldchainlist($start,$length,$order,$dir,$multiple_search,$id=null)
	{
		$wc = getWC();
		$data=array(); 
		$_currentdate  = date('Y-m-d');
		//print_r($id);exit;
		$assetsid= array('1');
		$status = 'ccm.status';
		$join ='';
		if($id != null && in_array($id,$assetsid))
		{
			$status ='history.status';
			$join = 'LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id ';
		}//print_r($multiple_search);exit;
		if($this->session->Tehsil){
			$tehsil=$this->session->Tehsil;
			$tcode="and ccm.tcode='$tehsil'";
		}else{
			$tcode='';
		}
		$procode = $this->session->Province;
		$query ="SELECT asset_id as id,warehousetypename(ccm.warehouse_type_id) as stroe_level,ccm.storecode,ccm.ccm_user_asset_id, 
				get_store_name(ccm.warehouse_type_id,CAST(storecode AS VARCHAR(9))) as storename,ccm.source_id,
				ccm.warehouse_type_id,ccm.procode,ccm.distcode,districtname(ccm.distcode) as district, 
				ccm.tcode, ccm.facode, tehsilname(ccm.tcode),facilityname(ccm.facode), 
				makername(md.ccm_make_id) as make_name,md.model_name, ccm.quantity,
				md.net_capacity_4, {$status} as status, ccm.created_date::date,  
				md.gross_capacity_20 as capacity,ccm.short_name
				FROM 
				epi_cc_coldchain_main ccm 
				JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id
				{$join}
				JOIN epi_cc_asset_types assetTypes ON assetTypes.pk_id = ccm.ccm_sub_asset_type_id 
				WHERE ccm.procode = '{$procode}' {$multiple_search} and asset_status ='Active' $tcode {$order} LIMIT {$length} OFFSET {$start} ";
		//echo $query; exit;
		$result = $this -> db -> query($query);
		$data['data'] = $result -> result_array();
		return $data;
	}
	public function coldchaintotal($multiple_search,$id=null)
	{
		$wc = getWC();
		$data=array();
		$assetsid= array('1');
		$join ='';
		if($id != null && in_array($id,$assetsid))
		{
			$join = 'LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id ';
		}
		if($this->session->Tehsil){
			$tehsil=$this->session->Tehsil;
			$tcode="and ccm.tcode='$tehsil'";
		}else{
			$tcode='';
		}
		$procode = $this->session->Province; 
		$query ="select count(*) as num FROM 
			epi_cc_coldchain_main ccm 
			JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			$join
			JOIN epi_cc_asset_types assetTypes ON assetTypes.pk_id = ccm.ccm_sub_asset_type_id
			WHERE ccm.procode = '{$procode}' {$multiple_search} and asset_status ='Active' $tcode";
		//echo $query; exit;
		$query = $this->db->query($query);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}
}
?>