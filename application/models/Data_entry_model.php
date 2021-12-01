<?php
class Data_entry_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> model('Widgetfunctions_model');
		$this -> load -> library('breadcrumbs');
		$this -> load -> helper('my_functions_helper');
		error_reporting(0);
		
	}
	//============================ Constructor Function Ends ============================//
	//-----------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for District Monthly EPI Reports Starts ======//
	public function dmr_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Monthly Reports', '/Data_entry/dmr_list');
		//////////////////////////////Adding BreadCrums////////////////////	
		$wc = getWC();
		$query="Select distinct fmonth from epidmr where $wc order by fmonth";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district";
		$resultDist=$this -> db -> query ($query);
		$data['resultDist'] = $resultDist -> result_array();
		$distcode = $this -> session -> District;
		if ($this -> session -> District == ""){
			return 0;
			exit();
		}
		$query="select distcode, districtname(distcode) as districtname, fmonth from epidmr where distcode='$distcode' order by fmonth, distcode desc  LIMIT {$per_page} OFFSET {$startpoint} ";
		$result=$this -> db -> query($query);
		$data['result'] = $result -> result_array();		
		return $data;		
	}
	//====== Function to Show Listing Page for District Monthly EPI Reports Ends =======//
	//----------------------------------------------------------------------------------//
	//====== Function to Show View Page for a District Monthly EPI Report Starts =======//
	public function dmr_view($distcode,$fmonth){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Monthly Reports', '/Data_entry/dmr_list');
		$this->breadcrumbs->push('View District Monthly Report', '/Data_entry/dmr_view');
		///////////////////////////////////////////////////////////////////
		$mainQuery = "select * from epidmr where distcode='$distcode' and fmonth='$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['resultData'] = $result->row_array();
				
		$query="Select distcode, district from districts where distcode='$distcode'";
		$result=$this->db->query($query);
		$data['districtname']=$result->row_array();		
		return $data;
	}
	//====== Function to Show View Page for a District Monthly EPI Report Ends =========//
	//----------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a District Monthly EPI Report Starts =======//
	public function dmr_edit($distcode,$fmonth){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Monthly Reports', '/Data_entry/dmr_list');
		$this->breadcrumbs->push('Update District Monthly Report', '/Data_entry/dmr_edit');
		///////////////////////////////////////////////////////////////////
		$mainQuery = "SELECT * FROM epidmr WHERE distcode = '$distcode'  AND fmonth = '$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['resultData'] = $result->row_array();
											
		$query="Select * from districts where distcode='$distcode' order by district";
		$result=$this->db->query($query);
		$data['districtname'] = $result->row_array();
		return $data;
	}
	//====== Function to Show Edit Page for a District Monthly EPI Report Ends ============//
	//-------------------------------------------------------------------------------------//
	//====== Function to Show Add Page for New District Monthly EPI Report Starts =========//
	public function dmr(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Monthly Reports', '/Data_entry/dmr_list');
		$this->breadcrumbs->push('Add New District Monthly Report', '/Data_entry/dmr');
		///////////////////////////////////////////////////////////////////
		$District = $this -> session -> District;
		$query="Select * from districts where distcode='$District' order by district";
		$result=$this->db->query($query);
		$data['result1']=$result->result_array();
		$query="select count(*) as tot_uc from unioncouncil where distcode='$District'";
		$result=$this->db->query($query);
		$data['tot_uc']=$result->row_array();
		$query="select count(*) as tot_epi_center from facilities where distcode='$District'";
		$result=$this->db->query($query);
		$data['tot_epi_center']=$result->row_array();
		$query="select population as dist_population from districts where distcode='$District'";
		$result=$this->db->query($query);
		$dist_population=$result->row_array();
		
		$data['dist_population']=$dist_population;
		$dist_population = $dist_population['dist_population'];
		$targeted_children = 3.5;
		$divided_by = 100;
		$percent = $dist_population / $divided_by;
		$target_children =  $percent * $targeted_children ;
		$monthly_births =  $target_children / 12  ;
		$surviving_infants = ($monthly_births / 100) * 92.2 ;
		$pregnent_ladies = $percent * 3.57 ;
		$data['target_children']=round($target_children);
		$data['monthly_births']=round($monthly_births);
		$data['surviving_infants']=round($surviving_infants);
		$data['pregnent_ladies']=round($pregnent_ladies);
		return $data;
	}
	//====== Function to Show Add Page for New District Monthly EPI Report Ends ===================//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Save New or Update Existing District Monthly EPI Report Starts ===========//
	public function dmr_save($data,$distcode,$fmonth){
		if(!$this -> input -> post('edit')){
			$checkquery = "select count(*) as cnt from epidmr where distcode='$distcode' and fmonth='$fmonth'";
			$checkresult=$this->db->query($checkquery);
			$checkrow=$checkresult->row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script  = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Month report already exist for this District and Month....");';
				$script .= 'history.go(-1);';
				$script .= '</script>';
				echo $script;
				exit();
			}
			$inserted_id = $this -> Common_model -> insert_record('epidmr', $data);
			createTransactionLog("Data Entry", "District Monthly Reports Added");
			$location = base_url(). "Data_entry/dmr_list";
		   	$script  = '<script language="javascript" type="text/javascript"> alert("Record Saved successfully...."); window.location="'.$location.'"</script>';
			echo $script;
			return $inserted_id;
 		}
		if($this -> input -> post('edit'))
		{
			$update = $this -> Common_model -> update_record('epidmr', $data,array('id'=>$data['id']));
			createTransactionLog("Data Entry", "District Monthly Reports Updated For".$data['id']);
			$location = base_url(). "Data_entry/dmr_list";
			$script  = '<script language="javascript" type="text/javascript"> alert("Record Updated successfully...."); window.location="'.$location.'"</script>';
			echo $script;
			return $update;
		}
	}
	//====== Function to Save New or Update Existing District Monthly EPI Report Ends =============//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Facility Monthly vaccination Reports Starts ============//
	public function fmvrf_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly Vaccination Reports', '/Data_entry/fmvrf_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//$distcode = $this -> session -> District;
		/* if ($distcode == ""){
			return 0;exit();
		} */
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name asc";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct fatype from facilities where $wc order by fatype";
		$resultFat = $this -> db -> query ($query);
		$data['resultFat'] = $resultFat -> result_array();
		
		$query="Select uncode, unname(uncode) from unioncouncil where $wc order by unname(uncode) asc";
		$resultUcs=$this -> db -> query($query);
		$data['resultUcs'] = $resultUcs -> result_array();
		
		$query="Select distinct vacc_name from flcf_vacc_mr where $wc order by vacc_name";
		$resultveccname=$this -> db -> query($query);
		$data['resultveccname'] = $resultveccname -> result_array();
	
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district asc";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select facode, vacc_name, facilityname(facode) as facilityname,unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype, fmonth from flcf_vacc_mr where $wc order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Facility Monthly vaccination Reports Ends ================//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a Facility Monthly vaccination Report Starts =======//
	public function fmvrf_edit($facode,$fmonth){
		$mainQuery = "SELECT * FROM flcf_vacc_mr WHERE facode = '$facode'  AND fmonth = '$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['fmvrf_info'] = $result->row_array();
		//print_r($data['fmvrf_info']);exit;
		$data['district']=get_District_Name($data['fmvrf_info']['distcode']);
		$data['tehsil']=get_Tehsil_Name($data['fmvrf_info']['tcode']);
		$data['facility']=get_Facility_Name($data['fmvrf_info']['facode']);
		return $data;
	}
	//====== Function to Show Edit Page for a Facility Monthly vaccination Report Ends ============//
	//-------------------------------------------------------------------------------------//
	//====== Function to Save New facility Monthly vaccination Report Starts ===========//
	public function fmvrf_save($data){
		/* $checkquery = "select count(*) as cnt from flcf_vacc_mr where distcode='".$data["facode"]."' and fmonth='".$data["fmonth"]."'";
		$checkresult=$this->db->query($checkquery);
		$checkrow=$checkresult->row_array();
		$recexist=(int)$checkrow['cnt'];
		if($recexist==1){
			$script  = '<script language="javascript" type="text/javascript">';
			$script .= 'alert("Facility Monthly report already exist for this Health Facility and Month....");';
			$script .= 'history.go(-1);';
			$script .= '</script>';
			echo $script;
			exit();
		} */
		//print_r($data);exit;
		$inserted_id = $this -> Common_model -> insert_record('flcf_vacc_mr', $data);
		createTransactionLog("Data Entry", "Facility Monthly vaccination Report Added");
		$this -> session -> set_flashdata('message','Record Saved Successfully....');
		redirect('Data_entry/fmvrf_list');
		return $inserted_id;
	}
	//====== Function to Save New facility Monthly vaccination Report Ends =============//
	//---------------------------------------------------------------------------------------------//	
	//====== Function to Update Existing facility Monthly vaccination Report Starts ===========//
	public function fmvrf_update($data,$where){
		$update = $this -> Common_model -> update_record('flcf_vacc_mr', $data,$where);
		createTransactionLog("Data Entry", "Facility Monthly vaccination Report Updated");
		$this -> session -> set_flashdata('message','Record Updated Successfully....');
		redirect('Data_entry/fmvrf_list');
		return $update;
	}
	//====== Function to Update Existing facility Monthly vaccination Report Ends =============//
	//---------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for AEFI Reports Starts ============//
	public function aefi_list($per_page,$startpoint){
		$wc = getWC();
		
		$query="SELECT distinct year from aefi_rep where $wc and year IS NOT NULL order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array(); 
		
		$query="SELECT distinct week from aefi_rep where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array();
		
		$query = "SELECT tcode, tehsil from tehsil where $wc order by tcode";
		$resulttehsil = $this -> db -> query ($query);
		$data['resulttehsil'] = $resulttehsil -> result_array();
		
		$query="SELECT uncode, un_name from unioncouncil where $wc order by uncode";
		$resultUc=$this -> db -> query($query);
		$data['resultUc'] = $resultUc -> result_array();

		$query="SELECT facode, fac_name from facilities where $wc and hf_type='e' order by fac_name asc";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		if($this->session->UserLevel == 2){
			$neWc = str_replace("procode", "province", $wc);
			$query="SELECT distcode, district from districts where $neWc order by district asc";
			$resultDist=$this -> db -> query($query);
			$data['resultDist'] = $resultDist -> result_array();
		}
        $query="SELECT id,casename,age,facilityname(facode) as facilityname,unname(uncode) as unioncouncil,tehsilname(tcode) as tehsilname,		
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
		vacc_name,vacc_vaccinator, is_temp_saved, fweek, rep_date from aefi_rep where $wc order by id desc, fweek desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for AEFI Reports Ends ================//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to get data of already entered reports of AEFI Starts =======//
	public function aefi_reports($id){
		$mainQuery = "SELECT * FROM aefi_rep WHERE id = '$id'";
		$result = $this->db->query($mainQuery);
		$data['aefi_info'] = $result->row_array();
		$data['un_name']=get_UC_Name($data['aefi_info']['uncode']);
		$data['tehsil']=get_Tehsil_Name($data['aefi_info']['tcode']);
		$data['facility']=get_Facility_Name($data['aefi_info']['facode']);
		
		return $data;
	}
	//====== Function to get data of already entered reports of AEFI Ends ============//
	//-------------------------------------------------------------------------------------//
	//====== Function to Save New AEFI Report Starts ===========//
	public function aefi_save($data){
		//print_r($data);exit;		
		$inserted_id = $this -> Common_model -> insert_record('aefi_rep', $data);
		createTransactionLog("Data Entry", "AEFI Report Added");
		//echo $this->db->last_query();exit;
		$location = base_url(). "AEFI-CIF/List";
		$message="Record Saved Successfully.......";
		$this -> session -> set_flashdata('message',$message);
		redirect($location);
		return $inserted_id;
	}
	//====== Function to Save New AEFI Report Ends =============//
	//---------------------------------------------------------------------------------------------//	
	//====== Function to Update Existing AEFI Report Starts ===========//
	public function aefi_update($data,$where){
		$update = $this -> Common_model -> update_record('aefi_rep', $data,$where);
		createTransactionLog("Data Entry", "AEFI Report Updated");
		$location = base_url(). "AEFI-CIF/List";
		$message="Record Updated Successfully......";
		$this -> session -> set_flashdata('message',$message);
		redirect($location);
		return $update;
	}
	//====== Function to Update Existing AEFI Report Ends =============//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Monthly Surveillance EPI Reports Starts ============//
	public function msr_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly Surveillance Reports', '/Data_entry/msr_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$distcode = $this -> session -> District;
		if ($distcode == ""){
			return 0;exit();
		}
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name asc";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct fatype from facilities where $wc order by fatype";
		$resultFat = $this -> db -> query ($query);
		$data['resultFat'] = $resultFat -> result_array();
		
		$query="Select distinct fmonth from msr where $wc order by fmonth";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district asc";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select facode, facilityname(facode) as facilityname, facilitytype(facode) as facilitytype, fmonth from msr where $wc order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Monthly Surveillance EPI Reports Ends ================//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show View Page for a Monthly Surveillance EPI Reports Starts ===============//
	public function msr_view($facode,$fmonth){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly Surveillance Reports', '/Data_entry/msr_list');
		$this->breadcrumbs->push('View Monthly Surveillance Report', '/Data_entry/msr_view');
		///////////////////////////////////////////////////////////////////
		$District = $this -> session -> District;
		$mainQuery = "select * from msr where facode='$facode' and fmonth='$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['resultData'] = $result->row_array();
		
		$query="Select distcode, district from districts where distcode='$District'";
		$result=$this->db->query($query);
		$data['districtname']=$result->row_array();
		
		$query="Select facode, fac_name from facilities where facode='$facode'";
		$result=$this->db->query($query);
		$data['resultFac'] = $result->row_array();
		return $data;
	}
	//====== Function to Show View Page for a Monthly Surveillance EPI Report Ends ===============//
	//--------------------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Report Starts =============//
	public function msr_edit($facode,$fmonth){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly Surveillance Reports', '/Data_entry/msr_list');
		$this->breadcrumbs->push('Update Monthly Surveillance Report', '/Data_entry/msr_edit');
		///////////////////////////////////////////////////////////////////
		$District = $this -> session -> District;
		$mainQuery = "SELECT * FROM msr WHERE facode = '$facode'  AND fmonth = '$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['resultData'] = $result->row_array();
		
		$query="Select facode, fac_name from facilities where facode='$facode'";
		$result=$this->db->query($query);
		$data['resultFac'] = $result->row_array();
						
		$query="Select * from districts where distcode='$District' order by district asc";
		$result=$this->db->query($query);
		$data['districtname'] = $result->row_array();
		return $data;
	}
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Report Ends ==============//
	//-------------------------------------------------------------------------------------------//
	//====== Function to Show Add Page for a Monthly Surveillance EPI Report Starts =============//
	public function msr(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly Surveillance Reports', '/Data_entry/msr_list');
		$this->breadcrumbs->push('Add New Monthly Surveillance Report', '/Data_entrymsr');
		///////////////////////////////////////////////////////////////////
		$District = $this -> session -> District;
		$query="Select district,distcode from districts where distcode='$District' order by district asc";
		$result=$this->db->query($query);
		$data['result1']=$result->result_array();

		$query="Select facode, fac_name from facilities where distcode='$District' and hf_type='e' order by fac_name asc";
		$result=$this -> db -> query($query);
		$data['resultFac']=$result -> result_array();		
		return $data;
	}
	//====== Function to Show Edit Page for a Monthly Surveillance EPI Report Ends ======================//
	//---------------------------------------------------------------------------------------------------//
	//====== Function to Save New or Update Existing Monthly Surveillance EPI Report Starts =============//
	public function msr_save($data,$facode,$distcode,$fmonth){
		$checkquery = "select count(*) as cnt from msr where facode='$facode' and distcode='$distcode' and fmonth='$fmonth'";
		$checkresult=$this->db->query($checkquery);
		$checkrow=$checkresult->row_array();
		$recexist=(int)$checkrow['cnt'];
		if(!$this -> input -> post('edit')){
			if($recexist > 0){
				$script  = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Month Surveillance report already exist for this Facility and Month....");';
				$script .= 'history.go(-1);';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$inserted_id = $this -> Common_model -> insert_record('msr', $data);
			$location = base_url(). "Data_entry/msr_list";
			$script  = '<script language="javascript" type="text/javascript"> alert("Record Saved successfully...."); window.location="'.$location.'"</script>';
			echo $script;
			return $inserted_id;
 		}
		if($this -> input -> post('edit'))
		{
			$update = $this -> Common_model -> update_record('msr', $data,array('id'=>$data['id']));
			$location = base_url(). "Data_entry/msr_list";
			$script  = '<script language="javascript" type="text/javascript"> alert("Record Updated successfully...."); window.location="'.$location.'"</script>';
			echo $script;
			return $update;
		}
	}
	//====== Function to Save New or Update Existing Monthly Surveillance EPI Report Ends =============//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Weekly VPD Surveillance EPI Reports Starts ============//
	/* public function weekly_vpd_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Weekly VPD Surveillance Reports', 'Disease-Surveillance/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$distcode = $this -> session -> District;
		if ($distcode == ""){
			return 0;exit();
		}
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by facode";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct case_type from weekly_vpd where $wc order by case_type";
		$resultCasetype = $this -> db -> query ($query);
		$data['resultCasetype'] = $resultCasetype -> result_array(); 
		
		$query="Select distinct year from weekly_vpd where $wc order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="Select distinct week from weekly_vpd where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array(); 
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by distcode";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select *, recid, facode, facilityname(facode) as facilityname, name_case,is_temp_saved ,facilitytype(facode) as facilitytype, case_type, fweek from weekly_vpd where $wc order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	} */
	public function weekly_vpd_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Weekly VPD Surveillance Reports', 'Disease-Surveillance/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$distcode = $this -> session -> District;
		if ($distcode == ""){
			return 0;exit();
		}
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct case_type from weekly_vpd where $wc order by case_type";
		$resultCasetype = $this -> db -> query ($query);
		$data['resultCasetype'] = $resultCasetype -> result_array(); 
		
		$query="Select distinct year from weekly_vpd where $wc order by year";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="Select distinct week from weekly_vpd where $wc order by week";
		$resultWeek=$this -> db -> query($query);
		$data['resultWeek'] = $resultWeek -> result_array(); 
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district asc";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select *, recid, cross_notified, approval_status, cross_notified_from_distcode, distcode, facode, facilityname(facode) as facilityname,unname(uncode) as unioncouncil, name_case,is_temp_saved ,facilitytype(facode) as facilitytype, case_type, fweek from weekly_vpd where $wc  OR cross_notified_from_distcode='". $this -> session -> District ."'  order by recid desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Weekly VPD Surveillance EPI Reports Ends =====================//
	//-------------------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Monthly epi vaccination management Reports Starts ============//
	public function manage_epi_vacc_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly epi vaccination management Reports', '/Data_entry/manage_epi_vacc_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//echo $wc;exit;
		//$distcode = $this -> session -> District;
		/* if ($distcode == ""){
			return 0;exit();
		} */
		$query="Select uncode, un_name from unioncouncil where $wc  order by un_name asc";
		$resultUn=$this -> db -> query($query);
		$data['resultUn'] = $resultUn -> result_array();
				
		$query="Select distinct fmonth from manage_epi_vacc where $wc order by fmonth";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district asc";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select uncode, unname(uncode) as unioncouncilname, fmonth from manage_epi_vacc where $wc order by fmonth, uncode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Monthly epi vaccination management Reports Ends ============//
	//-------------------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Monthly epi vaccination management Reports Starts ============//
	public function vacc_cons_req_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Monthly Vaccination Consumption & Requisition Reports', '/Data_entry/vacc_cons_req_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//echo $wc;exit;
		//$distcode = $this -> session -> District;
		/* if ($distcode == ""){
			return 0;exit();
		} */
		$query="Select facode, fac_name from facilities where $wc  order by uncode";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
				
		$query="Select distinct fmonth from vaccine_consumption where $wc order by fmonth";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by distcode";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select facode, facilityname(facode) as facilityname, fmonth from vaccine_consumption where $wc order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Monthly epi vaccination management Reports Ends ==============//
	//-------------------------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form A1 Starts =============================//
	public function form_A1_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Province to District (EPI Stock Issue & Receipt Voucher)', '/Province-Issue-Receipt/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$query="Select distcode, district from districts order by district"; 
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
		$wc = getWC();
		
		$query="select id, form_date, distcode, districtname(distcode) as dist_name,is_temp_saved , status from form_a1_vaccine_main where $wc order by form_date desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//======================== Function to Show Listing Page for Form A1 Ends ===============================//
	//-------------------------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form A2 Starts =============================//
	public function form_A2_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Stock Issue & Receipt Voucher', '/District-Issue-Receipt/List'); 
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="Select facode, fac_name from facilities where $wc  order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
        $query="select id, form_date, distcode, districtname(distcode) as dist_name, facode,is_temp_saved, facilityname(facode) as fac_name from form_a2_vaccine_main where $wc order by id desc  LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	
	public function	form_A2_edit($distcode,$id){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Form A-2-Provincial List', '/Data_entry/form_a2_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		
        $query="select form_a2_vaccine_main.*, districtname(form_a2_vaccine_main.distcode) as dist_name from form_a2_vaccine_main where form_date <> '1969-12-31' and form_a2_vaccine_main.id='$id' and distcode='$distcode' order by id   ";
        $result=$this -> db -> query ($query);
		$data['vaccine_main'] = $result -> result_array();
		
		$query="select form_a2_vaccine_main.id,form_a2_vaccine_columns.* from form_a2_vaccine_main left join form_a2_vaccine_columns on form_a2_vaccine_main.id= form_a2_vaccine_columns.main_id where form_date <> '1969-12-31'and form_a2_vaccine_main.id='$id' and form_a2_vaccine_main.distcode='$distcode' order by form_a2_vaccine_main.id ";
        $result=$this -> db -> query ($query);
		$data['vaccine_columns'] = $result -> result_array();
		
		$query="select form_a1_vaccine_titles.* from  form_a1_vaccine_titles order by id   ";
        exit;$result=$this -> db -> query ($query);
		$data['vaccine_titles'] = $result -> result_array();
		
		return $data;
	}
	//======================== Function to Show Listing Page for Form A2 Ends ===============================//
	//-------------------------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form A2_federal Starts ==============================//
	public function form_A1_fed_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Federal to Province (EPI Stock Issue & Receipt Voucher)', '/Federal-Issue-Receipt/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="select id, form_date from form_a1_fed_vaccine_main order by id desc  LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	public function	form_A1_fed_edit($id){

		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Form A-1-Provincial List', '/Data_entry/form_a1_fed_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		
        
		$query="select form_a1_fed_vaccine_main.id,form_a1_fed_vaccine_columns.* from form_a1_fed_vaccine_main left join form_a1_fed_vaccine_columns on form_a1_fed_vaccine_main.id= form_a1_fed_vaccine_columns.main_id where form_date <> '1969-12-31'and form_a1_fed_vaccine_main.id='$id' order by form_a1_vaccine_main.id ";
        $result=$this -> db -> query ($query);
		$data['vaccine_columns'] = $result -> result_array();
		
		$query="select form_a1_vaccine_titles.* from  form_a1_vaccine_titles order by id   ";
        $result=$this -> db -> query ($query);
		$data['vaccine_titles'] = $result -> result_array();
		
		return $data;

	}
	
	
	//======================== Function to Show Listing Page for Form A2_federal Ends ===============================//
	//-------------------------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form B Starts ==============================//
	public function form_B_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('HF Consumption and Requisition Form', '/HF-Consumption-Requisition/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();

		$distcode= $this->session->District;
		$query="Select facode, fac_name from facilities where $wc order by fac_name asc";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();

		$query="Select distinct substring(fmonth,1,4) as year from form_b_cr where $wc and fmonth IS NOT NULL order by year desc";
		$resultYear=$this -> db -> query($query);
		$data['resultYear'] = $resultYear -> result_array();
		
		$query="Select distinct substring(fmonth,6,7) as month from form_b_cr where $wc and fmonth IS NOT NULL order by month desc";
		$resultYear=$this -> db -> query($query);
		$data['resultMonth'] = $resultYear -> result_array();
		
        $query="select id, facode, facilityname(facode) as fac_name, fmonth ,is_temp_saved from form_b_cr where procode='".$_SESSION["Province"]."' and distcode='".$this -> session ->District."' order by fmonth desc,facilityname(facode) asc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//======================== Function to Show Listing Page for Form B Ends ================================//
	//-------------------------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form C Starts ==============================//
	public function form_C_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('UC Demand, Consumption & Receipt Form', '/UC-Demand-Consumption/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="Select uncode, un_name from unioncouncil where $wc order by un_name asc";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		
        $query="select id, uncode, unname(uncode) as uc, is_temp_saved, tehsilname(tcode) as tehsil, start_date, end_date from form_c_demand where $wc and start_date <> '1969-12-31' and end_date <> '1969-12-31' order by uncode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//======================== Function to Show Listing Page for Form C Ends ===============================//
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show Listing Page for Weekly IDS Surveilliance Reports Starts ============//
	public function ids_report_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Integrated Diseases Surveilliance Reports', '/Data_entry/weekly_vpd_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$distcode = $this -> session -> District;
		if ($distcode == ""){
			return 0;exit();
		}
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct fatype from facilities where $wc order by fatype";
		$resultFat = $this -> db -> query ($query);
		$data['resultFat'] = $resultFat -> result_array();
		
		$query="Select distinct fweek from ids_report_form where $wc order by fweek";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by distcode";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select *, facode, facilityname(facode) as facilityname,is_temp_saved, facilitytype(facode) as facilitytype, fweek from ids_report_form where $wc order by fweek, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//======== Function to Show Listing Page for Weekly VPD Surveillance EPI Reports Ends ==================//
	//------------------------------------------------------------------------------------------------------//
	//========== Function to Show Listing Page for Facility Monthly vaccination Reports Starts =============//
	public function fac_mvrf_list($per_page,$startpoint){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Facility Monthly Vaccination Reports', '/Data_entry/fac_mvrf_list');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		//print_r($wc);exit();
		
		$query="Select facode, fac_name from facilities where $wc and hf_type='e' order by fac_name asc";
		$resultFac=$this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query = "Select distinct fatype from facilities where $wc order by fatype";
		$resultFat = $this -> db -> query ($query);
		$data['resultFat'] = $resultFat -> result_array();
		
		$query="Select uncode, unname(uncode) from unioncouncil where $wc order by unname(uncode) asc";
		$resultUcs=$this -> db -> query($query);
		$data['resultUcs'] = $resultUcs -> result_array();
		
		$query="Select distinct vacc_name from fac_mvrf_db where $wc and vacc_name IS NOT NULL order by vacc_name";
		$resultveccname=$this -> db -> query($query);
		$data['resultveccname'] = $resultveccname -> result_array();
	
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="Select distcode, district from districts where $neWc order by district";
		$resultDist=$this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();
		
        $query="select facode, vacc_name, facilityname(facode) as facilityname,unname(uncode) as unioncouncil, facilitytype(facode) as facilitytype, fmonth from fac_mvrf_db where $wc order by fmonth, facode desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
	}
	//====== Function to Show Listing Page for Facility Monthly vaccination Reports Ends ================//	
	//-----------------------------------------------------------------------------------------------//
	//====== Function to Show Edit Page for a Facility Monthly vaccination Report Starts =======//
	public function fac_mvrf_edit($facode,$fmonth){
		$mainQuery = "SELECT * FROM fac_mvrf_db WHERE facode = '$facode'  AND fmonth = '$fmonth'";
		$result = $this->db->query($mainQuery);
		$data['fmvrf_info'] = $result->row_array();
		//print_r($data['fmvrf_info']);exit;
		$mainQuery_od = "SELECT * FROM fac_mvrf_od_db WHERE facode = '$facode'  AND fmonth = '$fmonth'";
		$result = $this->db->query($mainQuery_od);
		$data['fmvrf_info_od'] = $result->row_array();
		//print_r($data['fmvrf_info']);exit;
		$data['district']=get_District_Name($data['fmvrf_info']['distcode']);
		$data['tehsil']=get_Tehsil_Name($data['fmvrf_info']['tcode']);
		$data['unioncouncil']=get_UC_Name($data['fmvrf_info']['uncode']);
		$data['facility']=get_Facility_Name($data['fmvrf_info']['facode']);
		return $data;
	}
	//====== Function to Show Edit Page for a Facility Monthly vaccination Report Ends ============//
	//---------------------------------------------------------------------------------------------//	
	//====== Function to Update Existing facility Monthly vaccination Report Starts ===========//
		public function fac_mvrf_update($data,$where,$dataf){
		
			$od='od_';
			$cri='i_';
			foreach($data as $key =>$value){ 
			    $pos_od=(strpos($key,$od));
			    $pos_cri=(strpos($key,$cri));
			    if($pos_od === false){
					$cri_data[$key]=$value;
			   	}else{
					//does nothing
				}
			    if($pos_cri === false){
            		$od_data[$key]=$value;
				}
				else{
				  //does nothing	
				}
			}	
			if($cri_data != Null){
				$data=$cri_data;
				$update = $this -> Common_model -> update_record('fac_mvrf_db', $data,$where);	
				unset($where['id']);
			}
			if($od_data != Null){
				 $data=$od_data;
				$update = $this -> Common_model -> update_record('fac_mvrf_od_db', $data,$where);	
				unset($where['id']);
			}
			if(isset($where['fmonth'])){


				//$where['fmonth'] = date('Y-m', strtotime($where['fmonth']. ' first day of next month'));
				$this -> Common_model -> update_record('form_b_cr', $dataf, $where);
			}
			syncDataWithFederalEPIMIS('fac_mvrf_db',$where['fmonth']);
			syncDataWithFederalEPIMIS('fac_mvrf_od_db',$where['fmonth']);
			$this -> session -> set_flashdata('message','Record Updated Successfully....');
			redirect('FLCF-MVRF/List');
			return $update;
	}
	//====== Function to Update Existing facility Monthly vaccination Report Ends =============//
	//-----------------------------------------------------------------------------------------//
	//======================== Function to Show Listing Page for Form C new Starts ==============================//
	public function form_C_new_list($per_page,$startpoint){
		
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('UC Demand, Consumption & Receipt Form', '/UC-Demand-Consumption/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="Select uncode, un_name from unioncouncil where $wc order by un_name";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		
		$query="select group_id,campaign_type, start_date, end_date,distcode, districtname(distcode) as districtname, is_temp_saved from form_c_new_demand where $wc and start_date <> '1969-12-31' and end_date <> '1969-12-31' GROUP BY group_id,campaign_type ,start_date, end_date ,distcode, districtname(distcode),is_temp_saved order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
		
	}
	//======================== Function to Show Listing Page for Form C Ends ===============================//
	///////////////////////////////////Form C//////////////////////////////////////////////
	public function form_C_new(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('UC Demand, Consumption & Receipt Form', '/UC-Demand-Consumption/Add');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select uncode, un_name from unioncouncil where $wc order by un_name";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		return $data;
	}
	//////////////////////////////////////// Form A2 New Version ////////////////////////////////////////////
	public function form_A2_new(){
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Stock Issue & Receipt Voucher', '/District-Issue-Receipt/Add');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$dist= $this -> session -> District;

		$query="Select uncode, un_name from unioncouncil where $wc order by un_name asc";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		return $data;
	}
	////////////////////////////////////////Form A2 New version Ends ////////////////////////////////////////
	//======================== Function to Show Listing Page for Form C new Starts ==============================//
	public function form_A2_new_list($per_page,$startpoint){
		
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Stock Issue & Receipt Voucher', '/District-Issue-Receipt/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="Select uncode, un_name from unioncouncil where $wc order by un_name asc";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		
		$query="select group_id,campaign_type, form_date,distcode, districtname(distcode) as districtname, is_temp_saved from form_a2_new where $wc and form_date <> '1970-01-01' GROUP BY group_id,campaign_type ,form_date,distcode, districtname(distcode),is_temp_saved order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
		
	}
	public function asdtesting($bcg,$fmonth){
		
		//////////////////////////////Adding BreadCrums////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('District Stock Issue & Receipt Voucher', '/District-Issue-Receipt/List');
		//////////////////////////////Adding BreadCrums////////////////////
		$wc = getWC();
		$query="Select uncode, un_name from unioncouncil where $wc order by un_name asc";
		$resultUnc=$this -> db -> query($query);
		$data['resultUnC'] = $resultUnc -> result_array();
		
		$query="select group_id,campaign_type, form_date,distcode, districtname(distcode) as districtname, is_temp_saved from form_a2_new where $wc and form_date <> '1970-01-01' GROUP BY group_id,campaign_type ,form_date,distcode, districtname(distcode),is_temp_saved order by group_id desc LIMIT {$per_page} OFFSET {$startpoint}  ";
        $result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();
		return $data;
		
	}
	//======================= Function to Show Listing Page for Form C Ends ========================//
	//============================== Function for AEFI Vaccines Start ==============================//
	public function get_vaccinename(){
		$query = "SELECT pk_id, description from epi_items where item_category_id='1' and is_active='1' order by pk_id";
		$result = $this->db->query($query);
		$data['item_name'] = $result->result_array();
		return $data;
	}
}//End of Data Entry Model Class
?>