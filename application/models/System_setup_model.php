<?php
class System_setup_model extends CI_Model {
	//================ Constructor Function Starts================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> library('breadcrumbs');
		$this->load->helper('my_functions_helper'); 
	}
	//================ Constructor Function Ends Here ====================//
		//--------------------------------------------------------------------//
	//================ AddHR Listing Function Starts ================//					
	public function addhr_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage AddHR', '/System_setup/AddHR_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		//$query = "SELECT facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		//$Fac_result = $this -> db -> query($query);
		//$data['resultFac'] = $Fac_result -> result_array();
		$query = "SELECT distinct employee_type from hrdb where $wc order by employee_type ASC";
		$Emp_result = $this -> db -> query($query);
		$data['Emp_result'] = $Emp_result -> result_array();
		//$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		//$Fac_result = $this -> db -> query($query);
		//$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		/* $query = "SELECT distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array(); */
		// Change `records` according to your table name.
		$query = "SELECT * from hrdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ AddHR Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
		//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New AddHR Starts Here =======//	
	public function AddHR_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage AddHR', '/System_setup/AddHR_list');
		$this->breadcrumbs->push('Add New AddHR', '/System_setup/AddHR_add');
		/////////////////////////////////////////////////////////////////
		//$query="SELECT distcode, district FROM districts order by district ASC";
			//$result=$this->db->query($query);
			//$data['result']=$result->result_array();			
			$query="SELECT * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
	}
	//================ Function to Show Page for Adding New AddHR Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
		//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing AddHR Record Starts Here =================//
	public function AddHR_save($hrData,$hrCode){
		//print_r($hrCode); exit;
		
	if($this -> input -> post ('edit')){
		//print_r('ass1'); exit;
		unset($hrData['designation_type']);
			$updateQuery = $this -> Common_model -> update_record('hrdb',$hrData,array('hrcode'=>$hrCode));
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("AddHR-DB", "AddHR Updated ".$hrCode);
				$location = base_url(). "AddHR/View/".$hrCode;
				$message="Record Updated for HR with Code".$hrCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("AddHR-DB", "AddHR Updated ".$hrCode);
				$location = base_url(). "HRList";
				$message="Record Updated for HR with Code ".$hrCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "SELECT count(*) as cnt from hrdb where hrcode='$hrCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("AddHR Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('hrdb', $hrData);
			if($result != 0){
				createTransactionLog("AddHR-DB", "AddHR Added ".$hrCode);
				$location = base_url(). "HRList";
				$message="Record Saved for New HR Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing AddHR Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing AddHR Record Starts Here ===============//
	public function AddHR_edit($hrcode){
		
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage AddHR', '/System_setup/AddHR_list');
		$this->breadcrumbs->push('Update AddHR', '/System_setup/AddHR_edit');
		///////////////////////////////////////////////////////////////////
		//$district = $this -> session -> District;
		$query="SELECT * from hrdb where hrcode = '$hrcode' ";
		$result=$this -> db -> query ($query);
		$data['hrdata']=$result -> row_array();
		//echo '<pre>';print_r($data['dsodata']);exit;
		$query="SELECT * from hrdb where hrcode = '$hrcode' ";
		$result=$this -> db -> query ($query);
		$data['hrdata']=$result -> row_array();

		$query = "SELECT hrcode, designation_type FROM hrdb  order by designation_type ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	
		//$query = "SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		//$resultFac = $this -> db -> query($query);
		//$data['resultFac'] = $resultFac -> result_array();		

		//$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		//$resultTeh=$this -> db -> query($query);
		//$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="SELECT * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
       
		return $data;
	}
	//================ Function to Show Page for Editing Existing AddHR Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing AddHR Record Starts Here ==============//
	public function AddHR_view($hrcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage AddHR', '/System_setup/AddHR_list');
		$this->breadcrumbs->push('AddHR View', '/System_setup/AddHR_view');
		/////////////////////////////////////////////////////////////////
		//$district = $this -> session -> District;
		$query="SELECT *  from hrdb where hrcode = '$hrcode' ";
		$query="SELECT hrdb.* ,bankinfo.bankcode as bcode,bankinfo.bankname as bank from hrdb  left join bankinfo  on  hrdb.bid= bankinfo.bankid where hrdb.hrcode='$hrcode'"; 

		$result=$this -> db -> query ($query);
		$data['hrdata']=$result -> row_array();
		//echo '<pre>';print_r($data['hrdata']);echo '</pre>';exit;
		return $data;
	}
	
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ Supervisor Listing Function Starts ================//
		public function supervisor_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Supervisor', '/System_setup/supervisor_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "SELECT facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "SELECT uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();
		$query = "SELECT tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		$query = "SELECT distinct supervisor_type from supervisordb where $wc order by supervisor_type ASC";
		$Sup_result = $this -> db -> query($query);
		$data['resultSuper_type'] = $Sup_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "SELECT distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		//$wc .=" AND status != 'Post Back' ";
		if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='Manager')){
			$wc .="AND is_temp_saved = '0'";
		}
		$query = "SELECT supervisorname,supervisorcode,supervisor_type,is_temp_saved,nic,districtname(supervisordb.distcode) as districtname,status from supervisordb where $wc  LIMIT {$per_page} OFFSET {$startpoint}";
		$results = $this -> db -> query($query);
		//$str = $this->db->last_query();
	//print_r($str); exit;
		$data['results'] = $results -> result_array();
		
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Supervisor Starts Here =======//	
	public function supervisor_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Supervisor', '/System_setup/supervisor_list');
		$this->breadcrumbs->push('Add New Supervisor', '/System_setup/supervisor_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;

		if($district != null){
			$query="SELECT distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();			
			$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="SELECT ar_id, title from arallowances where ar_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultAR']= $resultAR -> result_array();
			$query="SELECT * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			$query="SELECT d_id, title from ardeductions where d_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultARD']= $resultAR -> result_array();
			
		}else{
			$query="SELECT distcode, district FROM districts order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();

			$query="SELECT * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
		}
		return $data;
		
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Supervisor Record Starts Here =================//
	public function supervisor_save($supervisorData,$supervisorCode,$supervisorDataNewData){
		$temp=$supervisorDataNewData['post_type'];
		            /* New Uncode, Facode, Tcode */
			       //$faccode=$supervisorDataNewData['new_facode'];
		           //$tehcode=$supervisorDataNewData['new_tcode'];
		           //$unccode=$supervisorDataNewData['new_uncode'];
		                   /* END */
				//$temp=$supervisorData['post_type'];
	    $status=$supervisorData['status'];		
			unset($supervisorData['post_type']);
			unset($supervisorData['newfacode']);
			unset($supervisorData['newtcode']);
			unset($supervisorData['newuncode']);		   
		//previous code for epi technician
		$svtcode=$supervisorData['previous_code'];
		//$type=$supervisorData['supervisor_type'];
		if($this -> input -> post ('edit')){
			
			if($supervisorData['status']=='Active')
			 {
				$supervisorData['status']="Active"; 
			 }
			 if($supervisorData['status']=='post')
			 {
				$supervisorData['status']="Posted"; 
			 }
			//echo '<pre>';print_r($supervisorData);echo '</pre>';exit();
			$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorData,array('supervisorcode'=>$supervisorCode));
			if($supervisorData['status']=='Transfered')
			{
				$supervisorData['previous_code']=$supervisorCode;
				$supervisorData['supervisorcode']=$supervisorDataNewData['new_lhwcode'];
				$supervisorData['distcode']=$supervisorDataNewData['new_distcode'];
				//$supervisorData['uncode']=$supervisorDataNewData['new_uncode'];
				//$supervisorData['facode']=$supervisorDataNewData['new_facode'];
				//$supervisorData['tcode']=$supervisorDataNewData['new_tcode'];
				$supervisorData['status']='Active';
				//print_r($supervisorData);exit;
				$result = $this -> Common_model -> insert_record('supervisordb', $supervisorData);
			}
// Post-back in to that table by which recevie data.
// working by - Zeeshan Ahmad 
// Email      - zsa.kpk@gmail.com

	if($status=='Post Back')
		{
			/*For EPI Technician */
			if($temp=='EpiTechnician')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to EpiTechnician  Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For EPI Technician */
			else if($temp=='techniciandb')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to EPI Technician Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For EPI Technician */
			else if($temp=='cc_mechanic')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$technicianData,array('ccm_code'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Cold Chain Mechanic  Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For Generator operator */
			else if($temp=='go_db')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('go_db',$technicianData,array('go_code'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Generator Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For Generator operator */
			else if($temp=='cco_db')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('cco_db',$technicianData,array('cco_code'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Cold Chain Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For Generator operator */
			else if($temp=='dsodb')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('dsodb',$technicianData,array('dsocode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to District Surveillance Officer Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For Generator operator */
			else if($temp=='driverdb')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('driverdb',$technicianData,array('drivercode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Driver Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			/*For Measles Focal Person */
			else if($temp=='mfpdb')
			{
				$technicianData=array('status'=>'Active');						
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('mfpdb',$technicianData,array('mfpcode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Measles Focal Person Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
			}
			else if($temp=='codb') 
			{
				$codata=array('status'=>'Active');
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('codb',$codata,array('cocode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Computer Operator Successfully!";
				$this -> session -> set_flashdata('message',$message); 
				redirect($location);
				exit();
			}	
			else if($temp=='cc_techniciandb') 
			{
				$codata=array('status'=>'Active');
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$codata,array('cc_techniciancode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record posted back to Cold Chain Technician Successfully!";
				$this -> session -> set_flashdata('message',$message); 
				redirect($location);
				exit();
			}	
			/*For DataEntry Operator */
			else if($temp=='DataEntry')
			{
				/* $supervisorData['deoname']=$supervisorData['supervisorname'];
				$supervisorData['current_status']="Temporary-Post";
				/* Unset Data *
				//unset fields that are not necassary  for DEODB
				unset($supervisorData['supervisorname']);
				unset($supervisorData['techniciancode']);
				unset($supervisorData['supervisorcode']);
				unset($supervisorData['tcode']);
				unset($supervisorData['cold_chain_training_end_date']);
				unset($supervisorData['vlmis_training_end_date']);
				unset($supervisorData['vlmis_training_start_date']);
				unset($supervisorData['survilance_training_end_date']);unset($supervisorData['cold_chain_training_start_date']);
				unset($supervisorData['survilance_training_start_date']);
				unset($supervisorData['basic_training_end_date']);
				unset($supervisorData['routine_epi_start_date']);
				unset($supervisorData['routine_epi_end_date']);
				unset($supervisorData['routine_epi_end_date']);
				unset($supervisorData['basic_training_start_date']);
				unset($supervisorData['reason']);
				unset($supervisorData['supervisor_type']);
				unset($supervisorData['catch_area_pop']);
				unset($supervisorData['catch_area_name']);
				unset($supervisorData['areatype']);
				unset($supervisorData['status']);
				$supervisorData['status']="Active";
				//print_r($supervisorData);exit;
				//getting latest deocode from deodb 
				$this->db->where('distcode',$supervisorData['distcode']);
				$this->db->select('deocode');
				$this->db->order_by('deocode','desc');
				$this->db->limit('1');
				$query=$this->db->get('deodb');
				$deocode=0;
				foreach($query->result() as $row){
				$deocode=$row->deocode;
			}
			if($deocode!=null && $deocode!=0){
				//increment the code
				$deocode=$deocode+1;
				}
				else{
				//fisrt code
				$deocode=$supervisorData['distcode']."0001";
				}
				$supervisorData['deocode']=$deocode;

				//insert into deodb
				$result = $this -> Common_model -> insert_record('deodb', $supervisorData);
				//delete supervisor record
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); *
				$location = base_url()."SupervisorList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session ->set_flashdata('message',$message);
				redirect($location); */
			}
			else if($temp=='Storekeeper')
			{
				$codata=array('status'=>'Active');
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('skdb',$codata,array('skcode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record Posted As SkoreKeeper  Successfully";
				$this -> session -> set_flashdata('message',$message); 
				redirect($location);
				exit();
			}
			else if($temp=='med_techniciandb')
			{
				$codata=array('status'=>'Active');
				//replace status of epitech to active from tempost
				$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$codata,array('techniciancode'=>$svtcode));
				//delete temporary post from supervisordb
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record Posted As HF Incharges Successfully";
				$this -> session -> set_flashdata('message',$message); 
				redirect($location);
				exit(); 
			} 
			/*For Store-Keeper Operator */
			else if($temp=='Storekeeper_delete_it')
			{
				$supervisorData['skname']=$supervisorData['supervisorname'];
				$supervisorData['current_status']="Temporary-Post";

				/* Unset Data */
				//unset fields that are not necassary  for DEODB
				unset($supervisorData['supervisorname']);
				unset($supervisorData['techniciancode']);
				unset($supervisorData['supervisorcode']);
				unset($supervisorData['tcode']);
				unset($supervisorData['cold_chain_training_end_date']);
				unset($supervisorData['vlmis_training_end_date']);
				unset($supervisorData['vlmis_training_start_date']);
				unset($supervisorData['survilance_training_end_date']);unset($supervisorData['cold_chain_training_start_date']);
				unset($supervisorData['survilance_training_start_date']);
				unset($supervisorData['basic_training_end_date']);
				unset($supervisorData['routine_epi_start_date']);
				unset($supervisorData['routine_epi_end_date']);
				unset($supervisorData['routine_epi_end_date']);
				unset($supervisorData['basic_training_start_date']);
				unset($supervisorData['reason']);
				unset($supervisorData['supervisor_type']);
				unset($supervisorData['catch_area_pop']);
				unset($supervisorData['catch_area_name']);
				unset($supervisorData['areatype']);
				unset($supervisorData['status']);			
				$supervisorData['status']="Active";
				//print_r($supervisorData);exit;
				//getting latest deocode from deodb 
				$this->db->where('distcode',$supervisorData['distcode']);
				$this->db->select('skcode');
				$this->db->order_by('skcode','desc');
				$this->db->limit('1');
				$query=$this->db->get('skdb');
				$skcode=0;
				foreach($query->result() as $row){
				$skcode=$row->skcode;
			}
			if($skcode!=null && $skcode!=0){
				//increment the code
				$skcode=$skcode+1;
				}
				else{
				//fisrt code
				$skcode=$supervisorData['distcode']."0001";
				}
				$supervisorData['skcode']=$skcode;

				//insert into skdb
				$result = $this -> Common_model -> insert_record('skdb', $supervisorData);
				//need to be update recort not insert_record
				//delete supervisor record
				/* $this->db->where('supervisorcode',$supervisorCode);
				$this->db->delete('supervisordb'); */
				$location = base_url(). "SupervisorList";
				$message="Record Posted As SkoreKeeper  Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
			}
			/*For DSV  */
			else if($temp=='District Superintendent Vaccinator')
			{
				//updated Super Type To DSV
				$supervisorupdate=array('supervisor_type'=>$temp);
				//Update Query 
				$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
				$location = base_url(). "SupervisorList";
				$message="Record Posted As District Superintendent Vaccinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
				}
				/*For M&E  */
				else if($temp=='Monitoring and Evaluation Supervisor')
				{
				//updated Super Type To DSV
				$supervisorupdate=array('supervisor_type'=>$temp);
				//Update Query 
				$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
				$location = base_url(). "SupervisorList";
				$message="Record Posted As Monitoring & Evaluation Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
			}
			/*For DHC  */
			else if($temp=='District Health coordinator')
			{
				//updated Super Type To DSV
				$supervisorupdate=array('supervisor_type'=>$temp);
				//Update Query 
				$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
				$location = base_url(). "SupervisorList";
				$message="Record Posted As District Health coordinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
				}
				/*For FSV*/
				else if($temp=='Field Superintendent Vaccinator')
				{
				//updated Super Type To FSV
				$supervisorupdate=array('supervisor_type'=>$temp,'facode'=>$faccode,'tcode'=>$tehcode);
				//Update Query 
				$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
				$location = base_url(). "SupervisorList";
				$message="Record Posted As Field Superintendent Vaccinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
			}
			/*For TSV*/
			else if($temp=='Tehsil Superintendent Vaccinator')
			{
				//updated Super Type To TSV
				$supervisorupdate=array('supervisor_type'=>$temp,'tcode'=>$tehcode);
				//Update Query 
				$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
				$location = base_url(). "SupervisorList";
				$message="Record Posted As Tehsil Superintendent Vaccinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
			}
			else
			{

			}
		}

//                 End

		/* if($status=='post')
			{
				  /*For EPI Technician *
			        if($temp=='EpiTechnician')
			        {
						$technicianData=array('status'=>'Active');						
						//replace status of epitech to active from tempost
						$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$svtcode));
						//delete temporary post from supervisordb
						/* $this->db->where('supervisorcode',$supervisorCode);
						$this->db->delete('supervisordb'); *
						$location = base_url(). "SupervisorList";
						$message="Record posted back to EpiTechnician  Successfully!";
						$this -> session -> set_flashdata('message',$message);
						redirect($location);
						exit();
				    }

					else if($temp=='ComputerOperator')
			        {
						$codata=array('status'=>'Active');
						
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('codb',$codata,array('cocode'=>$svtcode));
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "SupervisorList";
				$message="Record posted back to Computer Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
				    }
					
					/*For DataEntry Operator *
			       else if($temp=='DataEntry')
					{
						$supervisorData['deoname']=$supervisorData['supervisorname'];
						$supervisorData['current_status']="Temporary-Post";
						/* Unset Data *
						//unset fields that are not necassary  for DEODB
						unset($supervisorData['supervisorname']);
						unset($supervisorData['techniciancode']);
						unset($supervisorData['supervisorcode']);
						unset($supervisorData['tcode']);
						unset($supervisorData['cold_chain_training_end_date']);
						unset($supervisorData['vlmis_training_end_date']);
						unset($supervisorData['vlmis_training_start_date']);
						unset($supervisorData['survilance_training_end_date']);unset($supervisorData['cold_chain_training_start_date']);
						unset($supervisorData['survilance_training_start_date']);
						unset($supervisorData['basic_training_end_date']);
						unset($supervisorData['routine_epi_start_date']);
						unset($supervisorData['routine_epi_end_date']);
						unset($supervisorData['routine_epi_end_date']);
						unset($supervisorData['basic_training_start_date']);
						unset($supervisorData['reason']);
						unset($supervisorData['supervisor_type']);
						unset($supervisorData['catch_area_pop']);
						unset($supervisorData['catch_area_name']);
						unset($supervisorData['areatype']);
						unset($supervisorData['status']);
						$supervisorData['status']="Active";
						//print_r($supervisorData);exit;
						//getting latest deocode from deodb 
						$this->db->where('distcode',$supervisorData['distcode']);
						$this->db->select('deocode');
						$this->db->order_by('deocode','desc');
						$this->db->limit('1');
						$query=$this->db->get('deodb');
						$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$supervisorData['distcode']."0001";
						}
						$supervisorData['deocode']=$deocode;

					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $supervisorData);
					//delete supervisor record
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
				     $location = base_url()."SupervisorList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session ->set_flashdata('message',$message);
				redirect($location);
				
					}
					/*For Store-Keeper Operator *
			       else if($temp=='Storekeeper')
					{
					$supervisorData['skname']=$supervisorData['supervisorname'];
					$supervisorData['current_status']="Temporary-Post";
		
						/* Unset Data *
						//unset fields that are not necassary  for DEODB
						unset($supervisorData['supervisorname']);
						unset($supervisorData['techniciancode']);
						unset($supervisorData['supervisorcode']);
						unset($supervisorData['tcode']);
						unset($supervisorData['cold_chain_training_end_date']);
						unset($supervisorData['vlmis_training_end_date']);
						unset($supervisorData['vlmis_training_start_date']);
						unset($supervisorData['survilance_training_end_date']);unset($supervisorData['cold_chain_training_start_date']);
						unset($supervisorData['survilance_training_start_date']);
						unset($supervisorData['basic_training_end_date']);
						unset($supervisorData['routine_epi_start_date']);
						unset($supervisorData['routine_epi_end_date']);
						unset($supervisorData['routine_epi_end_date']);
						unset($supervisorData['basic_training_start_date']);
						unset($supervisorData['reason']);
						unset($supervisorData['supervisor_type']);
						unset($supervisorData['catch_area_pop']);
						unset($supervisorData['catch_area_name']);
						unset($supervisorData['areatype']);
						unset($supervisorData['status']);			
						$supervisorData['status']="Active";
						//print_r($supervisorData);exit;
						//getting latest deocode from deodb 
						$this->db->where('distcode',$supervisorData['distcode']);
						$this->db->select('skcode');
						$this->db->order_by('skcode','desc');
						$this->db->limit('1');
						$query=$this->db->get('skdb');
						$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
						//increment the code
						$skcode=$skcode+1;
						}
						else{
							//fisrt code
							$skcode=$supervisorData['distcode']."0001";
						}
						$supervisorData['skcode']=$skcode;

					//insert into skdb
					$result = $this -> Common_model -> insert_record('skdb', $supervisorData);
					//delete supervisor record
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
				     $location = base_url(). "SupervisorList";
				$message="Record Posted As SkoreKeeper  Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
						
					}
					/*For DSV  *
			       else if($temp=='District Superintendent Vaccinator')
					{
						//updated Super Type To DSV
						$supervisorupdate=array('supervisor_type'=>$temp);
						//Update Query 
						$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
						$location = base_url(). "SupervisorList";
						$message="Record Posted As District Superintendent Vaccinator Successfully. ";
						$this -> session -> set_flashdata('message',$message);
						redirect($location);	
					}
					/*For M&E  *
			       else if($temp=='Monitoring and Evaluation Supervisor')
					{
						//updated Super Type To DSV
						$supervisorupdate=array('supervisor_type'=>$temp);
						//Update Query 
						$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
						$location = base_url(). "SupervisorList";
						$message="Record Posted As Monitoring & Evaluation Supervisor Successfully. ";
						$this -> session -> set_flashdata('message',$message);
						redirect($location);	
					}
					/*For DHC  *
			       else if($temp=='District Health coordinator')
					{
						//updated Super Type To DSV
						$supervisorupdate=array('supervisor_type'=>$temp);
						//Update Query 
						$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
						$location = base_url(). "SupervisorList";
						$message="Record Posted As District Health coordinator Successfully. ";
						$this -> session -> set_flashdata('message',$message);
						redirect($location);	
					}
					/*For FSV*
			       else if($temp=='Field Superintendent Vaccinator')
					{
					//updated Super Type To FSV
						$supervisorupdate=array('supervisor_type'=>$temp,'facode'=>$faccode,'tcode'=>$tehcode);
						//Update Query 
						$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
						$location = base_url(). "SupervisorList";
				$message="Record Posted As Field Superintendent Vaccinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
						
					}
					/*For TSV*
			       else if($temp=='Tehsil Superintendent Vaccinator')
					{
					//updated Super Type To TSV
						$supervisorupdate=array('supervisor_type'=>$temp,'tcode'=>$tehcode);
						//Update Query 
						$updateQuery = $this -> Common_model -> update_record('supervisordb',$supervisorupdate,array('supervisorcode'=>$supervisorCode));
						$location = base_url(). "SupervisorList";
				$message="Record Posted As Tehsil Superintendent Vaccinator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
					}
					else
					{
						
					}
			} */
			if($this -> db -> affected_rows() > 0)
				{
				createTransactionLog("Supervisor-DB", "Supervisor Updated ".$supervisorCode);
				$location = base_url(). "Supervisor/View/".$supervisorCode;
				$message="Record Updated for Supervisor with Code ".$supervisorCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				}
			else
				{
				createTransactionLog("Supervisor-DB", "Supervisor Updated ".$supervisorCode);
				$location = base_url(). "SupervisorList";
				$message="Record Updated for Supervisor with Code ".$supervisorCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				}
			}
			else
				{
					//echo '<pre>';print_r($supervisorData);echo '</pre>';exit();
					$checkquery = "select count(*) as cnt from supervisordb where supervisorcode='$supervisorCode'";
					$checkresult=$this -> db -> query ($checkquery);
					$checkrow=$checkresult -> row_array();
					$recexist=(int)$checkrow['cnt'];
				if($recexist==1)
					{	
					$script = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Supervisor Code already exists....")';
					$script .= 'history.go(-1)';
					$script .= '</script>';
					echo $script;
					exit();	
					}
					//echo '<pre>';print_r($supervisorData);echo '</pre>';
					//exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $supervisorData);
					//print_r($result);exit();
			if($result != 0)
					{
					createTransactionLog("Supervisor-DB", "Supervisor Added ".$supervisorCode);
					$location = base_url(). "SupervisorList";
					$message="Record Saved for New Supervisor Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					}
				}
			exit();
				}
	//================ Function for Saving New or Existing Supervisor Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here ===============//
	public function supervisor_edit($supervisorcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Supervisor', '/System_setup/supervisor_list');
		$this->breadcrumbs->push('Update Supervisor', '/System_setup/supervisor_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($this -> session -> UserLevel == '3') {
			$query="select *, districtname(distcode) as districtname, facilityname(facode) as facilityname,  tehsilname(tcode) as tehsilname from supervisordb where supervisorcode = '$supervisorcode' ";
			$result=$this -> db -> query ($query);
			$data['supervisordata']=$result -> row_array();
			
			$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result = $this -> db -> query($query);
			$data['result'] = $result -> result_array();	

			$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac = $this -> db -> query($query);
			$data['resultFac'] = $resultFac -> result_array();		

			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this -> db -> query($query);
			$data['resultTeh'] = $resultTeh -> result_array();
			
			$query="select ar_id, title from arallowances where ar_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultAR']= $resultAR -> result_array();

			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();

			$query="select d_id, title from ardeductions where d_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultARD']= $resultAR -> result_array();
			
			$query="select distcode, district FROM districts order by district ASC";
		    $result=$this -> db -> query ($query);
		    $data['dists'] = $result -> result_array();
		
		    $query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		    $resultUnC=$this -> db -> query ($query);
		    $data['resultUnC']= $resultUnC -> result_array();
		}

		else{
			$query="select *, districtname(distcode) as districtname from supervisordb where supervisorcode = '$supervisorcode' ";
			$result=$this -> db -> query ($query);
			$data['supervisordata']=$result -> row_array();
		
			$query = "select distcode, district FROM districts order by district ASC";
			$result = $this -> db -> query($query);
			$data['result'] = $result -> result_array();

			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
		}
		return $data;
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Supervisor Record Starts Here ==============//
	public function supervisor_view($supervisorcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		if (($_SESSION['UserLevel']!='4') && ($_SESSION['utype']=='Store')){
			$this->breadcrumbs->push('Manage Supervisor', '/System_setup/supervisor_list');
		}
		$this->breadcrumbs->push('Supervisor View', '/System_setup/supervisor_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select supervisordb.* , facilityname(supervisordb.facode) as facilityname, districtname(supervisordb.distcode), tehsilname(supervisordb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from supervisordb  left join bankinfo  on  supervisordb.bid= bankinfo.bankid where supervisordb.supervisorcode='$supervisorcode'"; 

		$result=$this -> db -> query ($query);
		$data['supervisordata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Supervisor_Details.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
	}
	//================ Function to Show Page for Viewing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
		public function skdb_save($skData,$skcode,$skcodeNewData){
			        /* Post Type FOr Posting  */
		$temp=$skcodeNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$skData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$skcodeNewData['new_facode'];
		$tehcode=$skcodeNewData['new_tcode'];
		$unccode=$skcodeNewData['new_uncode'];
		$tcode=$skData['skcode'];
		$status=$skData['status'];
		//uset data
		unset($skData['post_type']);	
		unset($skData['date_joining']);	
		unset($skData['newfacode']);	
		unset($skData['newuncode']);	
		unset($skData['newtcode']);	
		// end
		/* Getting FOR DSv ,TSV , FSV */
		/* $tahcode=$skData['newtcode'];
		$facode=$skData['newfacode'];
		$uncode=$skData['newuncode'];
		         /* Post Type FOr POSting TO :{DSV,FSV etc..} *
	    $temp=$skData['post_type'];
		  	//uset data
		  
		unset($skData['post_type']);
		unset($skData['newfacode']);
		unset($skData['newtcode']);
		unset($skData['newuncode']); 
	          /* Previous COde FOr EpiTechnician *
		$tcode=$skData['previous_code'];
		
		$status=$skData['status'];
		//previous code for epi technician
		$svtcode=$skData['previous_code']; */
		//print_r($skData);exit();
		
		$previous_table =$skData['previous_code'];
		
		if($this -> input -> post ('edit')){
			
			if($skData['status']=='Active')
			 {
				$skData['status']="Active"; 
				$skData['date_joining']=$doj;	
			 }
			 if($skData['status']=='post')
			 {
				$skData['status']="Posted"; 
			 }
			 //end
			/* if($skData['status']=='Active')
			 {
				$skData['status']="Active"; 
			 }
			 if($skData['status']=='post')
			 {
				$skData['status']="Posted"; 
			 } */
			
			$updateQuery = $this -> Common_model -> update_record('skdb',$skData,array('skcode'=>$skcode));
			
			if($status=='post')
			{       
		/* FOr Epi Technician */
		
		
		 $skData['previous_code']=$skcode;
         $skData['current_status']="Temporary-Post";	
		 
		// print_r($skData);exit;
		 
			        if($temp=='EpiTechnician')
			        {
						$technicianData=array('status'=>'Active');
						
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$tcode));
					/* $this->db->where('skcode',$skcode);
					$this->db->delete('skdb'); */
					$location = base_url(). "Store-keeper";
				$message="Record posted back to EpiTechnician  Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
				    }
					 /* FOr Data ENtry Operator */
					else if($temp=="DataEntry")
					{
						/* Here SKData use as a DEODB Data */
						/* $name=$skData['skname'];
						$skData['deoname']=$name;
						$skData['current_status']='Temporary-Post';
						$skData['stataus']='Active';
					   $name=$deoData['deoname'];
					 	/* Unset Data *
						unset($skData['skname']);
						unset($skData['skcode']);
						/* getting latest deocode from deodb *
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$skData['distcode']."0001";
						}
						//latest code
						$skData['deocode']=$deocode;
						//$skData['previous_table']="skdb";

					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $skData);
					//delete skdb record
					/* $this->db->where('skcode',$skcode);
					$this->db->delete('skdb'); *
				     $location = base_url()."Store-keeper";
				$message="Record Posted As Store Keeper Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
					
					}
					 /* FOr DSV */
					else if($temp=="District Superintendent Vaccinator")
					{
						$name=$skData['skname'];
						/* Unset Data */
						 /* Unset Data */
						unset($skData['skname']);
						unset($skData['skcode']);
						unset($skData['husbandname']);
						unset($skData['place_of_posting']);
						unset($skData['area_type']);
						unset($skData['postalcode']);
						/* SKDATA to dsv  */
					$dsv=$skData;
                     $dsv['supervisorname']=$name;
                     $dsv['supervisor_type']=$temp;
                     $dsv['current_status']="Temporary-Post";
					 $dsv['status']="Active";
					    /* For Supervisor Code */
                    	/* getting latest deocode from Supervisor-DB */
					$this->db->where('distcode',$dsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$dsv['distcode']."0001";
						}
						//latest code
						$dsv['supervisorcode']=$scode;
						$dsv['previous_table']="skdb";
                        /* END */
                       /* Insert into supervisorDB */   
					$result = $this -> Common_model -> insert_record('supervisordb',$dsv);
					//delete skdb record
					/* $this->db->where('skcode',$skcode);
					$this->db->delete('skdb'); */
				     $location = base_url()."Store-keeper";
				$message="Record Posted As DSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);						
						
					}
					 /* FOr TSV */
					else if($temp=="Tehsil Superintendent Vaccinator")
					{
					$name=$skData['skname'];
					/* 	Unset Data */
						unset($skData['skname']);
						unset($skData['skcode']);
						unset($skData['husbandname']);
						unset($skData['place_of_posting']);
						unset($skData['area_type']);
						unset($skData['postalcode']);
						/* $skData as a TSV */
					$tsv=$skData;
                     $tsv['supervisorname']=$name;
                     $tsv['supervisor_type']=$temp;
                     $tsv['current_status']="Temporary-Post";
					 $tsv['status']="Active";
					 $tsv['tcode']=$tahcode;
					    /* For Supervisor Code */
                    	/* getting latest deocode from Supervisor-DB */
					$this->db->where('distcode',$tsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$tsv['distcode']."0001";
						}
						//latest code
						$tsv['supervisorcode']=$scode;
						$tsv['previous_table']="skdb";
						
						//echo '<pre>'; print_r($tsv);exit;
						
						//previous_code
                        /* END */
                       /* Insert into supervisorDB */
					$result = $this -> Common_model -> insert_record('supervisordb',$tsv);
					
					//echo '<pre>'; print_r($result);exit;
					
					//delete skdb record
					/* $this->db->where('skcode',$skcode);
					$this->db->delete('skdb'); */
				     $location = base_url()."Store-keeper";
				$message="Record Posted As TSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);						
							
					}

					 /* FOr FSV */
					else if($temp=="Field Superintendent Vaccinator")
					{
					$name=$skData['skname'];
						/* Unset Data */
						unset($skData['skname']);
						unset($skData['skcode']);
						unset($skData['husbandname']);
						unset($skData['place_of_posting']);
						unset($skData['area_type']);
						unset($skData['postalcode']);
						
						/* SKData as a FSV */
					$fsv=$skData;
                     $fsv['supervisorname']=$name;
                     $fsv['supervisor_type']=$temp;
                     $fsv['current_status']="Temporary-Post";
					  $fsv['status']="Active";
					 $fsv['tcode']=$tahcode;
					 $fsv['facode']=$facode;
					    /* For Supervisor Code */
                    	/* getting latest deocode from Supervisor-DB */
					$this->db->where('distcode',$fsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$fsv['distcode']."0001";
						}
						//latest code
						$fsv['supervisorcode']=$scode;
						$fsv['previous_table']="skdb";
                        /* END */
                       /* Insert into supervisorDB */
					$result = $this -> Common_model -> insert_record('supervisordb',$fsv);
					//delete skdb record
					/* $this->db->where('skcode',$skcode);
					$this->db->delete('skdb'); */
				     $location = base_url()."Store-keeper";
				$message="Record Posted As FSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);						
							
					}
					
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$skData['dsoname']=$skData['skname'];
					//unset these values bcx these are for mfpdb Table
					unset($skData['skname']);
					unset($skData['status']);
					unset($skData['mfpcode']);
					unset($skData['husbandname']);
					unset($skData['reason']);
					unset($skData['facode']);
					unset($skData['date_resigned']);
					unset($skData['current_status']);
					unset($skData['techniciancode']);
					unset($skData['supervisorcode']);
					unset($skData['skcode']);
					unset($skData['place_of_posting']);
					unset($skData['area_type']);
					unset($skData['postalcode']);
					$skData['status']='Active';
					$skData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$skData['distcode']."0001";
				}
					$skData['dsocode']=$dsocode;
					//print_r($skData);exit();
					//insert into dsodb
					//$skData['tcode']=$tehcode;
					//$skData['facode']=$faccode;
					//$skData['uncode']=$unccode;
					$skData['previous_table']="skdb";
					$result = $this -> Common_model -> insert_record('dsodb', $skData);
					$location = base_url(). "Store-keeper";
					$message="Record Posted As District surveillance officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
					 
		
// Start - data send to Computer Operator
					 
			else if($temp=='codb')
				{
					$skData['coname']=$skData['skname'];
					//unset these values bcx these are for mfpdb Table
					unset($skData['skname']);
					unset($skData['status']);
					unset($skData['mfpcode']);
					unset($skData['husbandname']);
					unset($skData['reason']);
					unset($skData['facode']);
					unset($skData['date_resigned']);
					unset($skData['current_status']);
					unset($skData['techniciancode']);
					unset($skData['supervisorcode']);
					unset($skData['skcode']);
					unset($skData['place_of_posting']);
					unset($skData['area_type']);
					unset($skData['postalcode']);
					$skData['status']='Active';
					$skData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$skData['distcode']."0001";
				}
					$skData['cocode']=$cocode;
					//print_r($skData);exit();
					//insert into codb
					//$skData['tcode']=$tehcode;
					//$skData['facode']=$faccode;
					//$skData['uncode']=$unccode;
					$skData['previous_table']="skdb";
					$result = $this -> Common_model -> insert_record('codb', $skData);
					$location = base_url(). "Store-keeper";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	
// Start - data send to Measles Focal Person
					 
			else if($temp=='mfpdb')
				{
					$skData['mfpname']=$skData['skname'];
					//unset these values bcx these are for mfpdb Table
					unset($skData['skname']);
					unset($skData['status']);
					unset($skData['mfpcode']);
					unset($skData['husbandname']);
					unset($skData['reason']);
					unset($skData['facode']);
					unset($skData['date_resigned']);
					unset($skData['current_status']);
					unset($skData['techniciancode']);
					unset($skData['supervisorcode']);
					unset($skData['skcode']);
					unset($skData['place_of_posting']);
					unset($skData['area_type']);
					unset($skData['postalcode']);
					$skData['status']='Active';
					$skData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$skData['distcode']."0001";
				}
					$skData['mfpcode']=$mfpcode;
					//print_r($skData);exit();
					//insert into mfpdb
					//$skData['tcode']=$tehcode;
					//$skData['facode']=$faccode;
					//$skData['uncode']=$unccode;
					$skData['previous_table']="skdb";
					$result = $this -> Common_model -> insert_record('mfpdb', $skData);
					$location = base_url(). "Store-keeper";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
// Start - data send to  HF Incharges 
			
				
			else if($temp=='med_techniciandb')
				{
					$skData['technicianname']=$skData['skname'];
					//unset these values bcx these are for mfpdb Table
					unset($skData['skname']);
					unset($skData['status']);
					unset($skData['mfpcode']);
					unset($skData['husbandname']);
					unset($skData['reason']);
					//unset($skData['facode']);
					unset($skData['date_resigned']);
					unset($skData['current_status']);
					//unset($skData['techniciancode']);
					unset($skData['supervisorcode']);
					unset($skData['skcode']);
					unset($skData['place_of_posting']);
					unset($skData['area_type']);
					unset($skData['postalcode']);
					$skData['status']='Active';
					$skData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$skData['distcode']."0001";
				}
					$skData['techniciancode']=$techniciancode;
					//print_r($skData);exit();
					//insert into med_techniciandb
					//$skData['tcode']=$tehcode;
					$skData['facode']=$faccode;
					//$skData['uncode']=$unccode;
					$skData['previous_table']="skdb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $skData);
					$location = base_url(). "Store-keeper";
					$message="Record Posted As HF Incharges Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}

///
				
			/* else if($temp=='med_techniciandb')
				{
					$skData['technicianname']=$skData['skname'];
					//unset these values bcx these are for med_techniciandb Table
					unset($skData['skname']);
					unset($skData['status']);
					unset($skData['techniciancode']);
					unset($skData['husbandname']);
					unset($skData['reason']);
					//unset($skData['facode']);
					unset($skData['date_resigned']);
					unset($skData['current_status']);
					unset($skData['techniciancode']);
					unset($skData['supervisorcode']);
					unset($skData['skcode']);
					unset($skData['place_of_posting']);
					unset($skData['area_type']);
					unset($skData['postalcode']);
					unset($skData['postalcode']);
					$skData['status']='Active';
					$skData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$skData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$skData['distcode']."0001";
				}
					$skData['techniciancode']=$techniciancode;
					//echo "<pre>"; print_r($skData);exit();
					//insert into med_techniciandb
					//$skData['tcode']=$tehcode;
					//$skData['facode']=$faccode;
					//$skData['uncode']=$unccode;
					$skData['previous_table']="skdb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $skData);
					$location = base_url(). "Store-keeper";
					$message="Record Posted As  HF Incharges Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		  */
					
			else
					{
						
					}
					
			}
				if($status=='Post Back')
				{
				  if($temp=='techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('techniciandb',$dsofficer,array('techniciancode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Epi Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Store-keeper";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
							
			
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("Store Keeper-DB", "Store keeper Updated ".$skcode);
				$location = base_url(). "Store-keeper/View/".$skcode;
				$message="Record Updated for Store Keeper with Code ".$skcode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Store Keeper-DB", "Store Keeper Updated ".$skcode);
				$location = base_url(). "Store-keeper";
				$message="Record Updated for Store-keeper with Code ".$skcode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from skdb where skcode='$skcode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Store Keeper Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('skdb', $skData);
			if($result != 0){
				createTransactionLog("Store Keeper DB", "Store Keeper Added ".$skcode);
				$location = base_url(). "Store-keeper";
				$message="Record Saved for New Store Keeper Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//========================function for Store Keeper save new n existing end here===============//

	//--------------------------------------------------------------------------------------------------------//
	//========================function for Store Keeper edit start here===============//
	public function skdb_edit($skcode){
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Store Keeper', '/System_setup/skdb_list');
		$this->breadcrumbs->push('Update Store Keeper', '/System_setup/skdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(skdb.distcode), facilityname(facode) as facilityname from skdb where skcode = '$skcode' ";
		$result=$this -> db -> query ($query);
		$data['skdata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['skdata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//========================function for Store Keeper edit end here===============//

	//--------------------------------------------------------------------------------------------------------//
	//========================function for Store Keeper list start here===============//
	public function skdb_list($per_page,$startpoint){
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Store Keeper', '/System_setup/skdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from skdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//========================function for Store Keeper list end here===============//

	//--------------------------------------------------------------------------------------------------------//
	//========================function for Store Keeper view start here===============//
	public function skdb_view($skcode){
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Store Keeper', '/System_setup/skdb_list');
		$this->breadcrumbs->push('Store Keeper View', '/System_setup/skdb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select skdb.* , facilityname(skdb.facode) as facilityname, districtname(skdb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from skdb  left join bankinfo  on  skdb.bid= bankinfo.bankid where skdb.skcode='$skcode'"; 

		$result=$this -> db -> query ($query);
		$data['skdata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//========================function for Store Keeper view end here===============//

	//--------------------------------------------------------------------------------------------------------//
	//========================function for Store Keeper edit start here===============//
	public function skdb_add(){
	    $this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Store Keeper', '/System_setup/skdb_list');
		$this->breadcrumbs->push('Add New Store Keeper', '/System_setup/skdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;	
	}
	//========================function for Store Keeper edit end here===============//
	//=========================Data Entry Model Panel================================================//
	//==========================Function for data Entry -list start========================================//
	public function deodb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Data Entry Operator', '/DataEntry-Operator-List');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from deodb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
		
	}
	//==========================Function for data Entry -list end========================================//
	//--------------------------------------------------------------------------------------------------//
	
	//Function to Show Page for Adding New Data Entry Operator Start Here===============//
	
	public function deodb_add(){
				//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Data Entry Operator', '/DataEntry-Operator-List');
		$this->breadcrumbs->push('Add New Data Entry Operator', '/DataEntry-Operator/Add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;

		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();			
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select ar_id, title from arallowances where ar_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultAR']= $resultAR -> result_array();
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			$query="select d_id, title from ardeductions where d_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultARD']= $resultAR -> result_array();
			
		}else{
			$query="select distcode, district FROM districts order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();

			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
		}
		return $data;
		
	}
	  
    //Function to Show Page for Adding New Data Entry Operator end Here===============//kdb
    //-----------------------------------------------------------------------------------//
	
	//Function to Save the New & Existing Data Entry Form Data start Here----------------//
	public function deodb_save($deoData,$deocode){
		
		          /* Getting FOR DSv ,TSV , FSV */
		$tahcode=$deoData['newtcode'];
		$facode=$deoData['newfacode'];
		$uncode=$deoData['newuncode'];
		$epi_tcode=$deoData['previous_code'];
		
		         /* Post Type FOr POSting TO :{DSV,FSV etc..} */
	    $temp=$deoData['post_type'];
			//uset data
			unset($deoData['post_type']);
			unset($deoData['newfacode']);
			unset($deoData['newtcode']);
			unset($deoData['newuncode']);      
			/* Previous COde FOr EpiTechnician */
		$tcode=$deoData['previous_code'];
	    //print_r($tcode);exit;
		$status=$deoData['status'];
		
	     //print_r($skData);exit();
	if($this -> input -> post ('edit'))
	{
		
		if($deoData['status']=='Active')
			 {
				$deoData['status']="Active"; 
			 }
			 if($deoData['status']=='post')
			 {
				$deoData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('deodb',$deoData,array('deocode'=>$deocode));
			//for chnge status of epi technician
			if($status=='post')
			{
		   /* FOr EPI Technician DB */
			        if($temp=='EpiTechnician')
			        { 
						$technicianData=array('status'=>'Active');
					//replace status of epitech to active from tempost
					         //    print_r($epi_tcode);			
					$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$epi_tcode));

			//print_r($updateQuery);exit;
					/* $this->db->where('deocode',$deocode);
					$this->db->delete('deodb'); */
					$location = base_url(). "DataEntry-Operator-List";
				$message="Record posted back to EpiTechnician  Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit();
				    }
					 /* FOr SkDB  */
					else if($temp=="Storekeeper")
					{
						/* Use deoData As a SKDB */
						$name=$deoData['deoname'];
					 	/* Unset Data */
						unset($deoData['deoname']);
						unset($deoData['deocode']);
						$deoData['skname']=$name;
						$deoData['status']="Active";
						$deoData['current_status']="Temporary-Post";
						/* getting latest deocode from deodb */
					$this->db->where('distcode',$deoData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
						//increment the code
						$skcode=$skcode+1;
						}
						else{
							//fisrt code
							$skcode=$deoData['distcode']."0001";
						}
						//latest code
						$deoData['skcode']=$skcode;
						//$deoData['previous_table']="deodb";
					//insert into skdb
					$result = $this -> Common_model -> insert_record('skdb', $deoData);
					//delete deodb record
					/* $this->db->where('deocode',$deocode);
					$this->db->delete('deodb'); */
				     $location = base_url()."DataEntry-Operator-List";
				$message="Record Posted As  Store-Keeper Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
						
					}
					/* FOr DSV  */
					else if($temp=="District Superintendent Vaccinator")
					{
					$name=$deoData['deoname'];
					   /* Unset Data */
						unset($deoData['deoname']);
						unset($deoData['deocode']);
						unset($deoData['husbandname']);
						unset($deoData['place_of_posting']);
						unset($deoData['area_type']);
						unset($deoData['postalcode']);
						unset($deoData['place_of_posting']);
					    unset($deoData['area_type']);
						unset($deoData['postalcode']);
					  /* DeoData to DSV */
					$dsv=$deoData;
                     $dsv['supervisorname']=$name;
                     $dsv['supervisor_type']=$temp;
                     $dsv['current_status']="Temporary-Post";
					 $dsv['status']="Active";
					    /* For Supervisor Code */
                    	/* getting latest code from Supervisor-DB */
					$this->db->where('distcode',$dsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$dsv['distcode']."0001";
						}
						//latest code
						$dsv['supervisorcode']=$scode;
						$dsv['previous_table']="deodb";
                        /* END */
                       /* Insert into supervisorDB */
					$result = $this -> Common_model -> insert_record('supervisordb',$dsv);
					//delete deodb record
					/* $this->db->where('deocode',$deocode);
					$this->db->delete('deodb'); */
				     $location = base_url()."DataEntry-Operator-List";
				$message="Record Posted As DSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);				
					}
					/* FOr TSV  */
					else if($temp=="Tehsil Superintendent Vaccinator")
					{
					$name=$deoData['deoname'];
					/* Unset Data */
						 /* Unset Data */
						unset($deoData['deoname']);
						unset($deoData['deocode']);
						unset($deoData['husbandname']);
						unset($deoData['place_of_posting']);
						unset($deoData['area_type']);
						unset($deoData['postalcode']);
					$tsv=$deoData;
                     $tsv['supervisorname']=$name;
                     $tsv['supervisor_type']=$temp;
                     $tsv['current_status']="Temporary-Post";
					  $tsv['status']="Active";
					 $tsv['tcode']=$tahcode;
					    /* For Supervisor Code */
                    	/* getting latest code from Supervisor-DB */
					$this->db->where('distcode',$tsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$tsv['distcode']."0001";
						}
						//latest code
						$tsv['supervisorcode']=$scode;
						$tsv['previous_table']="deodb";
                        /* END */
                       /* Insert into supervisorDB */
					$result = $this -> Common_model -> insert_record('supervisordb',$tsv);
					//delete deodb record
					/* $this->db->where('deocode',$deocode);
					$this->db->delete('deodb'); */
				     $location = base_url()."DataEntry-Operator-List";
				$message="Record Posted As TSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
					}
					/* FOr FSV  */
					else if($temp=="Field Superintendent Vaccinator")
					{
					$name=$deoData['deoname'];
							 /* Unset Data */
						unset($deoData['deoname']);
						unset($deoData['deocode']);
						unset($deoData['husbandname']);
						unset($deoData['place_of_posting']);
						unset($deoData['area_type']);
						unset($deoData['postalcode']);
					$fsv=$deoData;
                     $fsv['supervisorname']=$name;
                     $fsv['supervisor_type']=$temp;
                     $fsv['current_status']="Temporary-Post";
					 $fsv['status']="Active";
					    /* For Supervisor Code */
                    	/* getting latest code from Supervisor-DB */
					$this->db->where('distcode',$fsv['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$scode=0;
				        foreach($query->result() as $row){
						$scode=$row->supervisorcode;
						}
						//end
						//check code exits
						if($scode!=null && $scode!=0){
						//increment the code
						$scode=$scode+1;
						}
						else{
							//fisrt code
							$scode=$fsv['distcode']."0001";
						}
						//latest code
						$fsv['supervisorcode']=$scode;
						$fsv['previous_table']="deodb";
                        /* END */
                       /* Insert into supervisorDB */
					$result = $this -> Common_model -> insert_record('supervisordb',$dsv);
					//delete deodb record
					/* $this->db->where('deocode',$deocode);
					$this->db->delete('deodb'); */
				     $location = base_url()."DataEntry-Operator-List";
				$message="Record Posted As FSV Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);	
					}
			}
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("Data Entry Added-DB", "Data Entry Updated ".$deocode);
				$location = base_url(). "DataEntry-Operator/View/".$deocode;
				$message="Record Updated for Data Entry with Code ".$deocode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Data Entry-DB", "Data Entry Updated ".$deocode);
				$location = base_url(). "DataEntry-Operator-List";
				$message="Record Updated for Data ENtry with Code ".$deocode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from deodb where deocode='$deocode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Data Entry Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			/* $result = $this -> Common_model -> insert_record('deodb', $deoData); */
			if($result != 0){
				createTransactionLog("Data Entry DB", "Data ENtry Added ".$deocode);
				$location = base_url(). "DataEntry-Operator-List";
				$message="Record Saved for New Data entry  Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//Function to Save the New & Existing Data Entry Form Data end Here----------------//
	//------------------------------------------------------------------------------------//
	
	//--------------------------Function for data entry view start ----------------------------------------//
	public function deodb_view($deocode){
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Data Entry Operator', 'DataEntry-Operator-List');
		$this->breadcrumbs->push('Data Entry Operator View', 'DataEntry-Operator/View/');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select deodb.* , facilityname(deodb.facode) as facilityname, districtname(deodb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from deodb  left join bankinfo  on  deodb.bid= bankinfo.bankid where deodb.deocode='$deocode'"; 

		$result=$this -> db -> query ($query);
		$data['deodata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
		
	}
    //--------------------------Function for data entry view end-------------------------------------------//
	//------------------------------------------------------------------------------------------------//	
	//==========================Function for data Entry -Edit start========================================//
	
	public function deodb_edit($deocode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Data Entry Operator', '/System_setup/deodb_list/');
		$this->breadcrumbs->push('Update Data Entry Operator', '/System_setup/dataentry_operator_edit/');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(deodb.distcode), facilityname(facode) as facilityname from deodb where deocode = '$deocode' ";
		$result=$this -> db -> query ($query);
		$data['deodata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['deodata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	
	//==========================Function for data Entry -Edit end========================================//
	//===============================END============================================================//
	//================ Technician Listing Function Starts Here ===============================================//
	public function technician_list($startpoint,$per_page) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage EPI Technician', '/System_setup/technician_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		
		$distcode=$this->session->District;
		$query = "Select facode, fac_name from facilities where  hf_type='e' AND $wc order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();

		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();

		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();

		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();

		$query = "Select uncode, un_name from unioncouncil where $wc order by uncode";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();

		$query = "select supervisorcode, supervisorname FROM supervisordb WHERE $wc order by supervisorname ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultSupervisor'] = $Dist_result -> result_array();
		
		if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){		
			$wc .= "AND is_temp_saved='0'";
		}
		if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') )
		{
			$query = "select *, supervisorname(supervisorcode) as supervisorname,is_temp_saved, facilitytype(facode) as facilitytype,districtname(distcode) as district, fathername, '' as under_one_year, catch_area_pop, status, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from techniciandb LIMIT {$per_page} OFFSET {$startpoint}  ";
		}
		else
		{
			$query = "select *, supervisorname(supervisorcode) as supervisorname,is_temp_saved, facilitytype(facode) as facilitytype,districtname(distcode) as district, fathername, '' as under_one_year, catch_area_pop, status, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from techniciandb where distcode = '$distcode' LIMIT {$per_page} OFFSET {$startpoint}  ";
		}
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
        return $data;
	}
	//================ Technician Listing Function Ends Here ======================================//
	//---------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Adding New Technician Record Starts Here =========//
	public function technician_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage EPI Technician', '/System_setup/technician_list');
		$this->breadcrumbs->push('Add New EPI Technician', '/System_setup/technician_add');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();		

		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac']= $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh']= $resultTeh -> result_array();		

		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();	

		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor']= $resultSupervisor -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

	
		return $data;
	}
	//================ Function to Show Page for Saving New Technician Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	public function technician_save($technicianData,$technicianCode,$technicianNewData){
		        /* Post Type FOr Posting  */
		$temp=$technicianNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$technicianData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$technicianNewData['new_facode'];
		$tehcode=$technicianNewData['new_tcode'];
		$unccode=$technicianNewData['new_uncode'];
		$tcode=$technicianData['techniciancode'];
		$status=$technicianData['status'];
		//uset data
		unset($technicianData['post_type']);	
		unset($technicianData['date_joining']);	
		unset($technicianData['newfacode']);	
		unset($technicianData['newuncode']);	
		unset($technicianData['newtcode']);	
		
		$previous_table =$technicianData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($technicianData['status']=='Active')
			 {
				$technicianData['status']="Active"; 
				$technicianData['date_joining']=$doj;	
			 }
			 if($technicianData['status']=='post')
			 {
				$technicianData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('techniciandb',$technicianData,array('techniciancode'=>$technicianCode));
			 if($technicianData['status']=='Transfered')
			{
				$technicianData['previouse_code']=$technicianCode;
				$technicianData['techniciancode']=$technicianNewData['new_lhwcode'];
				$technicianData['distcode']=$technicianNewData['new_distcode'];
				$technicianData['uncode']=$technicianNewData['new_uncode'];
				$technicianData['facode']=$technicianNewData['new_facode'];
				$technicianData['tcode']=$technicianNewData['new_tcode'];
				$technicianData['status']='Active';
				//print_r($technicianData);exit;
				$result = $this -> Common_model -> insert_record('techniciandb', $technicianData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $technicianData['previous_code']=$technicianCode;
         $technicianData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
				//unset these values bcx these are for techniciandb
				unset($technicianData['technicianname']);
				unset($technicianData['status']);
				unset($technicianData['techniciancode']);
				unset($technicianData['husbandname']);
				unset($technicianData['reason']);
				unset($technicianData['facode']);
		$technicianData['status']='Active';
		$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						} 
					
						$technicianData['supervisorcode']=$supervisorcode;
						$technicianData['tcode']=$tehcode;
						$technicianData['previous_table']="techniciandb";
					//print_r($technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
			$location = base_url(). "TechnicianList";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for techniciandb
				unset($technicianData['technicianname']);
				unset($technicianData['status']);
				unset($technicianData['techniciancode']);
				unset($technicianData['husbandname']);
				unset($technicianData['reason']);
				unset($technicianData['facode']);
				unset($technicianData['place_of_posting']);
				unset($technicianData['area_type']);
				unset($technicianData['postalcode']);
					  
			$technicianData['status']='Active';
			$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						}
					 $technicianData['supervisorcode']=$supervisorcode;
                     $technicianData['previous_table']="techniciandb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
					//print_r($result);exit();
			$location = base_url(). "TechnicianList";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
				/* Unset Data */
				//unset these values bcx these are for techniciandb
				unset($technicianData['technicianname']);
				unset($technicianData['status']);
				unset($technicianData['techniciancode']);
				unset($technicianData['husbandname']);
				unset($technicianData['reason']);
				unset($technicianData['facode']);
				unset($technicianData['place_of_posting']);
				unset($technicianData['area_type']);
				unset($technicianData['postalcode']);
			$technicianData['status']='Active';
			$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						}
						$technicianData['supervisorcode']=$supervisorcode;
                      //print_r($technicianData);exit();
					//insert into supervisordb
					$technicianData['tcode']=$tehcode;
					$technicianData['previous_table']="techniciandb";
				$technicianData['facode']=$faccode;
				$technicianData['uncode']=$unccode;
				$technicianData['previous_table']="techniciandb";
				//print_r($technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
			$location = base_url(). "TechnicianList";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $technicianData['skname']=$technicianData['technicianname'];
						//unset these values bcx these are for techniciandb
						unset($technicianData['technicianname']);
						unset($technicianData['status']);
						unset($technicianData['techniciancode']);
						unset($technicianData['husbandname']);
						unset($technicianData['reason']);
						unset($technicianData['basic_training_start_date']);
						unset($technicianData['supervisorcode']);
						unset($technicianData['tcode']);
						unset($technicianData['cold_chain_training_end_date']);
						unset($technicianData['vlmis_training_end_date']);
						unset($technicianData['tcode']);
						unset($technicianData['vlmis_training_start_date']);
						unset($technicianData['survilance_training_end_date']);
						unset($technicianData['tcode']);
						unset($technicianData['cold_chain_training_start_date']);
						unset($technicianData['survilance_training_start_date']);
						unset($technicianData['basic_training_end_date']);
						unset($technicianData['routine_epi_start_date']);
						unset($technicianData['routine_epi_end_date']);
						unset($technicianData['catch_area_pop']);
						unset($technicianData['catch_area_name']);
						unset($technicianData['areatype']);
						$technicianData['date_joining']=$doj;
						$technicianData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$technicianData['distcode']."0001";
						}
						$technicianData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $technicianData);
				$location = base_url(). "TechnicianList";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$technicianData['dsoname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['skcode']);
					unset($technicianData['place_of_posting']);
					unset($technicianData['area_type']);
					unset($technicianData['postalcode']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$technicianData['distcode']."0001";
				}
					$technicianData['dsocode']=$dsocode;
					//print_r($technicianData);exit();
					//insert into dsodb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="techniciandb";
					$result = $this -> Common_model -> insert_record('dsodb', $technicianData);
					$location = base_url(). "TechnicianList";
					$message="Record Posted As District surveillance oficer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to Computer Operator
					 
			else if($temp=='codb')
				{
					$technicianData['coname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['skcode']);
					unset($technicianData['place_of_posting']);
					unset($technicianData['area_type']);
					unset($technicianData['postalcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$technicianData['distcode']."0001";
				}
					$technicianData['cocode']=$cocode;
					//print_r($technicianData);exit();
					//insert into codb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="techniciandb";
					$result = $this -> Common_model -> insert_record('codb', $technicianData);
					$location = base_url(). "TechnicianList";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Measles Focal Person 
					 
			else if($temp=='mfpdb')
				{
					$technicianData['mfpname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['skcode']);
					unset($technicianData['place_of_posting']);
					unset($technicianData['area_type']);
					unset($technicianData['postalcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$technicianData['distcode']."0001";
				}
					$technicianData['mfpcode']=$mfpcode;
					//print_r($technicianData);exit();
					//insert into mfpcode
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="techniciandb";
					$result = $this -> Common_model -> insert_record('mfpdb', $technicianData);
					$location = base_url(). "TechnicianList";
					$message="Record Posted As Measles Focal Person  Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 

// Start - data send to HF Incahrge
					 
			else if($temp=='med_techniciandb')
				{
					$technicianData['technicianname']=$technicianData['technicianname'];
					//unset these values bcx these are for med_techniciandb Table
					//unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['skcode']);
					unset($technicianData['place_of_posting']);
					unset($technicianData['area_type']);
					unset($technicianData['postalcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$technicianData['distcode']."0001";
				}
					$technicianData['techniciancode']=$techniciancode;
					//print_r($technicianData);exit();
					//insert into med_techniciandb
					//$technicianData['tcode']=$tehcode;
					$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="techniciandb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $technicianData);
					$location = base_url(). "TechnicianList";
					$message="Record Posted As HF Incahrge Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
// Start - data send to Store Keeper 
					 
			 else if($temp=='skdb')
				{
					$technicianData['skname']=$technicianData['technicianname'];
					//unset these values bcx these are for skdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['skcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['place_of_posting']);
					unset($technicianData['area_type']);
					unset($technicianData['postalcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					unset($technicianData['techniciancode']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$technicianData['distcode']."0001";
				}
					$technicianData['skcode']=$skcode;
					//print_r($technicianData);exit();
					//insert into skdb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="techniciandb";
					$result = $this -> Common_model -> insert_record('skdb', $technicianData);
					$location = base_url(). "TechnicianList";
					$message="Record Posted As Store Keeper Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}  		 

				 //DataEntry Operator
				  else
				     {
						/* 
						//technician name to deoname (change columnname)
						$technicianData['deoname']=$technicianData['technicianname'];
						//previous_code
						$technicianData['previous_code']=$tcode;
						//unset fields that are not necassary  for SkDB
						/* Unset Data *
						//unset these values bcx these are for techniciandb
						unset($technicianData['technicianname']);
						unset($technicianData['status']);
						//unset($technicianData['newfacode']);
						//unset($technicianData['newtcode']);
						//unset($technicianData['newuncode']);
						//  unset($technicianData['techniciancode']);
						unset($technicianData['husbandname']);
						unset($technicianData['reason']);
						unset($technicianData['techniciancode']);
						unset($technicianData['basic_training_start_date']);
						unset($technicianData['supervisorcode']);
						unset($technicianData['tcode']);
						unset($technicianData['cold_chain_training_end_date']);
						unset($technicianData['vlmis_training_end_date']);
						unset($technicianData['tcode']);
						unset($technicianData['vlmis_training_start_date']);
						unset($technicianData['survilance_training_end_date']);
						unset($technicianData['tcode']);
						unset($technicianData['cold_chain_training_start_date']);
						unset($technicianData['survilance_training_start_date']);
						unset($technicianData['basic_training_end_date']);
						unset($technicianData['routine_epi_start_date']);
						unset($technicianData['routine_epi_end_date']);
						unset($technicianData['catch_area_pop']);
						unset($technicianData['catch_area_name']);
						unset($technicianData['areatype']);
						$technicianData['status']='Active';
						$technicianData['date_joining']=$doj;
						$technicianData['status']='Active';
						//end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$technicianData['distcode']."0001";
						}
						$technicianData['deocode']=$deocode;
					//print_r($technicianData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $technicianData);
				     $location = base_url(). "TechnicianList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			if($status=='Post Back')
				{
				  if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "TechnicianList";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "TechnicianList";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "TechnicianList";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "TechnicianList";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "TechnicianList";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
				if($this -> db -> affected_rows() > 0){
				createTransactionLog("Technician-DB", "Technician Updated ".$technicianCode);
				$location = base_url(). "System_setup/technician_view/".$technicianCode;
				$message="Record Updated for Tech with Code ".$technicianCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Technician-DB", "Technician Updated ".$technicianCode);
				$location = base_url(). "System_setup/technician_list";
				$message="Record Updated for Tech with Code ".$technicianCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
			//$location = base_url(). "System_setup/technician_view/".$technicianCode;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		}
		else{
			$checkquery = "select count(*) as cnt from techniciandb where techniciancode='$technicianCode'";
		    $checkresult= $this -> db -> query ($checkquery);
		    $checkrow= $checkresult -> row_array();
		    $recexist=(int)$checkrow['cnt'];
		    if($recexist==1){
		        $script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Technician Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();
			}
			$result = $this -> Common_model -> insert_record('techniciandb', $technicianData);
			if($result != 0){
				createTransactionLog("Technician-DB", "Technician Added ".$technicianCode);
				$location = base_url(). "System_setup/technician_list";
				$message="Record Saved for New Tech Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Viewing Existing Technician Record Starts Here ======================//
	public function technician_view($techniciancode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Technician', '/System_setup/technician_list');
		$this->breadcrumbs->push('Technician View', '/System_setup/technician_view');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		//$query="select *, supervisorname(supervisorcode) as supervisorname, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil  from techniciandb where techniciancode = '$techniciancode' ";
		$query="select techniciandb.* ,supervisorname(techniciandb.supervisorcode) as supervisorname, facilityname(techniciandb.facode) as facilityname, districtname(techniciandb.distcode), tehsilname(techniciandb.tcode), coalesce(unname(techniciandb.uncode),'') as unioncouncil, bankinfo.bankcode as bcode,bankinfo.bankname as bank from techniciandb  left join bankinfo  on  techniciandb.bid= bankinfo.bankid where techniciandb.techniciancode='$techniciancode'"; 

		$result= $this -> db -> query ($query);
		$data['techniciandata']= $result -> row_array();
		 $nic =$data['techniciandata']['nic'];

		 $query = "SELECT distcode,tcode,uncode,facode FROM techniciandb WHERE status='Active' and nic='".$nic."'";	
		 $query= $this->db->query($query);

		$data['nic']= $query -> row_array();
		//echo '<pre>';print_r($data);exit;
		 //echo $nic; exit;
		return $data;
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here =============//
	public function technician_edit($techniciancode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Technician', '/System_setup/technician_list');
		$this->breadcrumbs->push('Update Technician', '/System_setup/technician_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname, tehsilname(tcode) as tehsilname, districtname(distcode) as districtname from techniciandb where techniciancode = '$techniciancode' ";
		$result=$this -> db -> query ($query);
		$data['techniciandata']= $result -> row_array();
		
		$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();		
		$query="select distcode, district FROM districts order by district ASC";
		$result=$this -> db -> query ($query);
		$data['dists'] = $result -> result_array();
		

		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();
		
		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor'] = $resultSupervisor -> result_array();


		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		//echo '<pre>';print_r($data);exit;		
		return $data;
	}
	//========================= Function to Show Page for Viewing Facility Starts Here ====================//
	//-----------------------------------------------------------------------------------------------------//
	public function flcf_view($facode){
		
		//$facode=$this->input->get('facode');
			//////////////////////ADDING BREADCRUMS//////////////////////////
			$this->breadcrumbs->push('Home','/');
			$this->breadcrumbs->push('Manage EPI Center', '/System_setup/flcf_list');
			$this->breadcrumbs->push('EPI Center Facility View', '/System_setup/facility_view');
	
			///////////////////////////////////////////////////////////////////
			
		//$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$_SESSION['District'];
		$distcode=$this->input->get('distcode');
		$query="select *,districtname(distcode) as district,tehsilname(tcode),coalesce(unname(uncode),'') as unioncouncil, fac_address, is_vacc_fac from facilities  where facode='$facode'";
		//select technicianname  from techniciandb where status='Active',
		//select technicianname from med_techniciandb where status='Active'";
		$result=$this->db->query($query);
		$data['resultfac']=$result->row_array();
										  
		
		$query="SELECT * from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery  where post_status='Active' and post_hr_sub_type_id='01' and post_facode ='$facode'";
		$result=$this -> db -> query ($query);
		$data['epitechname'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		$query="select techniciancode,technicianname,fathername,nic,phone,status from med_techniciandb where status='Active' and facode='$facode'";
		$result=$this -> db -> query ($query);
		$data['hftechname'] = $result -> result_array();
		
		$query = "SELECT *,CASE WHEN status='F' THEN 'Functional' WHEN status='N' THEN 'Not Functional'  ELSE 'Closed' END  FROM facilities_status WHERE facode='$facode' ORDER BY id DESC";
		$result=$this -> db -> query ($query);
		$data['status_data'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
        $query="select source_id,makername(md.ccm_make_id) as make_name,ccm.working_since::date,md.model_name,ccs.asset_type_name,ccm.facode,ccm.status,ccm.ccm_sub_asset_type_id from epi_cc_coldchain_main ccm 
        join epi_cc_asset_types ccs ON ccm.ccm_sub_asset_type_id=ccs.pk_id 
        join epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
        where ccm.facode='$facode' and asset_status='Active'";
		$result=$this -> db -> query ($query);
		$data['working_status'] = $result -> result_array();
        //$str = $this->db->last_query();
		//print_r($str); exit;
						
		return $data;
	}
  												
  
	public function getMainIndicatorsData($facode,$years){
		if(isset($facode)){
			$this -> db -> select('population as pop');
			$this -> db -> where('facode',$facode);
		}
		/* if($this -> session -> District){
			$this -> db -> select('population as pop');
			$this -> db -> where('distcode',$this -> session -> District);
		} */else{
			$this -> db -> select('population as pop');
			$this -> db -> where('facode',$facode);
			//$this -> db -> select('sum(population::integer) as pop');
		}
		//print_r($facode);exit;		
		if($years!=Null)		
		{
			$this -> db -> where('year',$years);	
			//$this -> db -> where('facode',$facodes);
		}		
		else		
		{			
			$this -> db -> where('year',date('Y'));
			//$this -> db -> where('facode',$facodes);
		}
		$result = $this -> db -> get('facilities_population') -> row();
		//echo $this->db->last_query();exit;
		
		// --------------------------------------------------------------------------------------------- //
		$data['provincePopulation']		 = (isset($result->pop) && $result->pop > 0)?(int)$result->pop:0;
		//$data['anuualTargetPopulation']  = round(($data['provincePopulation']*3.533)/100);
		$data['anuualTargetPopulation']  = round(($data['provincePopulation']*get_indicator_periodic_multiplier('newborn',$years))/100);
		$data['monthlyTargetPopulation'] = round($data['anuualTargetPopulation']/12);
		//$data['annualSurvivingInfants']  = round(($data['anuualTargetPopulation']*94.2)/100);
		$data['annualSurvivingInfants']  = round(($data['anuualTargetPopulation']*get_indicator_periodic_multiplier('survivinginfant',$years))/100);
		$data['monthlySurvivingInfants'] = round($data['annualSurvivingInfants']/12);
		//$data['annualPregnantLactatingPlWomen'] = round($data['anuualTargetPopulation']*1.02);
		$data['annualPregnantLactatingPlWomen'] = round($data['anuualTargetPopulation']*get_indicator_periodic_multiplier('plwomen',$years));
		$data['monthlyPregnantLactatingPlWomen'] = round($data['annualPregnantLactatingPlWomen']/12);
		// --------------------------------------------------------------------------------------------- //
		$data['annualPnnMortality'] = round(($data['annualSurvivingInfants']*98.3)/100);
		$data['monthlyPnnMortality'] = round($data['annualPnnMortality']/12);
		//$data['childrenLessThan5Years'] = round(($data['provincePopulation']*16)/100);
		$data['childrenLessThan5Years'] = round(($data['provincePopulation']*get_indicator_periodic_multiplier('less5year',$years))/100);
	//	$data['cbaLadies'] = round(($data['provincePopulation']*22)/100);
		$data['cbaLadies'] = round(($data['provincePopulation']*get_indicator_periodic_multiplier('cba',$years))/100);
		//$data['below15Years'] = round(($data['provincePopulation']*45)/100);
		$data['below15Years'] = round(($data['provincePopulation']*get_indicator_periodic_multiplier('less15year',$years))/100);
		$data['totalPopulation'] = ($data['provincePopulation']);
		// --------------------------------------------------------------------------------------------- //
		$this -> db -> select('sum(tot_lhw_involved_vacc) as tot_lhws');
		/* if($this -> session -> District){
			$this -> db -> where(array(
										'fmonth' => date('Y-m',strtotime('-1 month')),
										'distcode' => $this -> session -> District
									
									));
		} */
		if(isset($facode)){
			$this -> db -> where(array(
										'fmonth' => date('Y-m',strtotime('-1 month')),
										'facode'=>$facode
									));
		}else{
			$this -> db -> where('fmonth',date('Y-m',strtotime('-1 month')));
		}
		
		$result = $this -> db -> get('fac_mvrf_db') -> row();
		$data['totalLHWs'] = (int)$result->tot_lhws;
		// --------------------------------------------------------------------------------------------- //
		$this -> db -> select('count(facode) as tot_reports');
		/* if($this -> session -> District){
			$this -> db -> where('distcode',$this -> session -> District);
		} */
		if(isset($facode)){
			$this -> db -> where('facode',$facode);
		}else{}
		$this -> db -> like('fmonth',date('Y'),'after');
		$result = $this -> db -> get('fac_mvrf_db') -> row();
		$data['totalEpiVaccinationReports'] = (int)$result->tot_reports;
																  
																																							 
							   
																																																					
																																															
																																															
																																																		 
																																															   
																																																				   
																																					  
									  
										
		return $data;
	}
	
	
 
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here =============//
	//-----------------------------------------------------------------------------------------------------//
	//================ Function to Show Listing Page for Health Facility Starts Here ======================//
	public function flcf_list($per_page,$startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage EPI Center', '/System_setup/flcf_list');
		/////////////////////////////////////////////////////////////////
		//$distcode = $this -> session -> District;
		$wc = getWC();//helper function
		/*
		if ($distcode == "") {
					return 0;
					exit();
				}*/
		
		
		
		if($_SESSION['UserLevel']=='2'){
			$neWc = str_replace("procode", "province", $wc);
			$query="SELECT distcode, district from districts where $neWc order by district ASC";
			$Dist_result = $this -> db -> query($query);
			$data['resultDist']=$Dist_result -> result_array();
		}
		//$wc .= " AND hf_type='e' ";
		
		$query = "SELECT tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
													 
		
		$wc .= " AND hf_type='e' ";
		
		$query = "SELECT distinct fatype from facilities where $wc order by fatype";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$fmonth = date('Y-m');
		$curr_date = date('Y-m-d');
		$my_week = currentWeek(date('Y'), true); //$result->epi_week_numb;
		$q = "SELECT epi_week_numb FROM epi_weeks WHERE date_from >='$curr_date' ORDER BY epi_week_numb";
		$result = $this ->db->query($q)->row();
		$fweek = date('Y').'-'.sprintf("%02d", $my_week);
		$query ="SELECT facilities.facode, facilities.fac_name,facilities.areatype, districtname(facilities.distcode) as district, tehsilname(facilities.tcode) as tehsil,unname(facilities.uncode) as unioncouncil, facilities.fatype, facilities.catchment_area_pop, getfstatus_vacc('$fmonth', facilities.facode) as vacc_status, getfstatus_ds('$fweek', facilities.facode) as ds_status, facilities.is_vacc_fac, facilities.is_ds_fac,
				(select count(facode) from hr_db where hr_db.facode=facilities.facode and hr_sub_type_id='01') as total_technicians				
			  	from facilities where $wc order by facilities.fac_name  LIMIT {$per_page} OFFSET {$startpoint}";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		return $data;
	}
	//================ Function to Show Listing Page for Health Facility Ends Here ====================//
	//---------------------------------------------------------------------------------------------//
	//================ Function for Marking and Unmarking Health Facility Starts Here =================//
	public function mark_flcf(){
		$distcode = $this -> session -> District;
		if ($distcode=="")
		{
			return 0;
			exit();
		}
		//changes made by Imran on 2019-04-08 to add apply hf_type = null only on those facilities which not exist in both tables.
		$vacc_flcf_query = "UPDATE facilities SET hf_type = NULL WHERE distcode='$distcode' AND facode NOT IN (SELECT DISTINCT facode FROM fac_mvrf_db WHERE distcode='$distcode') AND facode NOT IN (SELECT DISTINCT facode FROM zero_report WHERE distcode='$distcode')";
		$result = $this->db->query($vacc_flcf_query);
		//code by imran end here
		
		$vacc_flcf_query = "UPDATE facilities SET is_vacc_fac = '0' WHERE distcode='$distcode' AND facode NOT IN (SELECT DISTINCT facode FROM fac_mvrf_db WHERE distcode='$distcode')";
		$result = $this->db->query($vacc_flcf_query);
		
		$ds_flcf_query = "UPDATE facilities SET is_ds_fac = '0' WHERE distcode='$distcode' AND facode NOT IN (SELECT DISTINCT facode FROM zero_report WHERE distcode='$distcode')";
		$result2 = $this->db->query($ds_flcf_query);
		if($result AND $result2)
		{
			foreach($this->input->post('vacc_flcf_list') as $key)
			{
				$query = "UPDATE facilities SET hf_type = 'e', is_vacc_fac = '1' WHERE  distcode='$distcode' AND facode = '$key'";
				$result = $this->db->query($query);
			}
			foreach($this->input->post('ds_flcf_list') as $key)
			{
				$query = "UPDATE facilities SET hf_type = 'e', is_ds_fac = '1' WHERE  distcode='$distcode' AND facode = '$key'";
				$result = $this->db->query($query);
			}
			$this -> session -> set_flashdata('message','Facilities Marked/Unmarked Successfully!');
			return 1;
		}
		createTransactionLog("Facilities", "Facilities Mark/Un-Mark Updated ");
	}
	//================ Function for Marking and Unmarking Health Facility Ends Here ==========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Showing Marking List to Mark/Unmark Health Facility Starts Here ===========//
	public function flcf_marker_list(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage EPI Center', '/System_setup/FLCF_list');
		$this->breadcrumbs->push('Mark EPI Center For EPI', '/System_setup/flcf_marker_list');
		///////////////////////////////////////////////////////////////////
		$distcode=$this -> session -> District;
		if ($distcode==""){
			return 0;
			exit();
		}
		$query = "SELECT tcode, tehsil FROM tehsil WHERE distcode='$distcode' ORDER BY tehsil ASC";
		$data['resultTeh'] = $this->db->query($query)->result_array();
		
		$query = "SELECT distinct fatype FROM facilities WHERE distcode = '$distcode' ORDER BY fatype ASC";
		$data['resultFac'] = $this->db->query($query)->result_array();
		
		$query="SELECT facode,hf_type, is_vacc_fac, is_ds_fac, fac_name, districtname(distcode) AS district, tehsilname(tcode) AS tehsil, fatype, catchment_area_pop FROM facilities WHERE distcode='$distcode' ORDER BY facode ASC";
		$data['results'] = $this->db->query($query)->result_array();

		$vacc_flcf_query = "SELECT DISTINCT facode FROM fac_mvrf_db WHERE distcode='$distcode'";
		$data['vacc_flcf'] = $this->db->query($vacc_flcf_query)->result_array();
		$data['vacc_flcf'] = array_column($data['vacc_flcf'],"facode");
		
		$ds_flcf_query = "SELECT DISTINCT facode FROM zero_report WHERE distcode='$distcode'";
		$data['ds_flcf'] = $this->db->query($ds_flcf_query)->result_array();
		$data['ds_flcf'] = array_column($data['ds_flcf'],"facode");
															 
		return $data;
	}
	//================ Function for Showing Marking List to Mark/Unmark Health Facility Ends Here =============//
	//----------------------------------------------------------------------------------------------------// 
	//================ Function for Adding New Facility or Editing Existing Health Facility Starts Here =======//
	public function flcf_add($flcfData){
		if($this -> input -> get('facode')){
			//////////////////////ADDING BREADCRUMS//////////////////////////
			$this->breadcrumbs->push('Home','/');
			$this->breadcrumbs->push('Manage EPI Center', '/EPICentersList');
			$this->breadcrumbs->push('Update EPI Center', '/System_setup/flcf_edit');
			/////////////////////////////////////////////////////////////////
		}else{		
			//////////////////////ADDING BREADCRUMS//////////////////////////
			$this->breadcrumbs->push('Home','/');
			$this->breadcrumbs->push('Manage EPI Center', '/System_setup/FLCF_list');
			$this->breadcrumbs->push('Add New EPI Center', '/System_setup/flcf_add');
			/////////////////////////////////////////////////////////////////
		}
		$district	= $this -> session -> District;
		$query="SELECT distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result=$this->db->query($query);
		$data['district']=$result->result_array();
		$query="SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		$query = "SELECT fatype from facilities_types  order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();

		$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tcode, tehsil ASC";
		$resultTeh=$this->db->query($query);
		$data['resultTeh']=$resultTeh->result_array();
		$query="SELECT uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultun=$this->db->query($query);
		$data['resultun']=$resultun->result_array();
		//variables for insert query into facilities_population
		$facodee = $flcfData['facode'];
		//$population = $flcfData['catchment_area_pop'];
		$population = '0';
		$year = date('Y');
		if($this->input->get('facode')){
			$facode = $this->input->get('facode');
			$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as unname from facilities WHERE facode = '$facode' ";
			$resultF =$this->db->query($query);
			$data['dataFacility'] = $resultF->row_array();		
		}
		else if($this->input->post('submit')){
			if($this -> input -> post('edit')){
				$facode = $this -> input -> post('facode');
																	  
				unset($flcfData['is_ds_fac']);
				unset($flcfData['is_vacc_fac']);
				unset($flcfData['catchment_area_pop']);
				unset($flcfData['tcode']);
				unset($flcfData['uncode']);
				unset($flcfData['distcode']);
				$updateQuery = $this -> Common_model -> update_record('facilities',$flcfData,array('facode'=>$facode));
				createTransactionLog("Health Facility-DB", "Health Facility Updated ".$facode);				
				$location = base_url(). "System_setup/flcf_view?facode=$facode";
				$message="Record Updated Successfully with Code ".$facode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				
			}else{
				$facode = $this -> input -> post('facode');
				$query = "SELECT count(*) as num from facilities WHERE facode = '$facode' ";
				$resultN = $this->db->query($query);
				$checkFacility = $resultN->row_array();
				if($checkFacility['num'] > 0){
					$script = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Facode Code already exists....")';
					$script .= 'history.go(-1)';
					$script .= '</script>';
					echo $script;
					exit();
				}else{
					//print_r($flcfData);exit;
					$this->db->trans_begin();
					$result = $this -> Common_model -> insert_record('facilities', $flcfData);
					//$queryForpop = "insert into facilities_population (facode,year,population,created_date,distcode,tcode,uncode) values ('{$facodee}','{$year}','{$population}',now(),'{$district}','{$flcfData['tcode']}','{$flcfData['uncode']}')";
					//$this->db->query($queryForpop);
													  
					/* Facility Status Code Starts Here */
					$dateToday = date('Y-m-d');
					$currentMonth = date('Y-m');
					$monthYearTo = date('Y-m',strtotime('-1 month'));
					$query = "SELECT fweek FROM epi_weeks WHERE date_from <= '{$dateToday}' AND date_to >= '{$dateToday}'";
					$currentWeek = $this->db->query($query)->row();
					$queryPreviousWeek = "select fweek from epi_weeks where fweek < '{$currentWeek->fweek}' order by fweek desc limit 1";
					$previousWeek = $this->db->query($queryPreviousWeek)->row();
					$weekYearTo = $previousWeek->fweek;
															
					$queryNonFunctionalStatusofVaccination = "insert into facilities_status(id,facode,status,m_y_from,m_y_to,added_date,reason_vacc,reason_ds) 
													values ('{$facodee}-1','{$facodee}','N','2016-01','{$monthYearTo}','{$dateToday}','NC','NC');";
					$this->db->query($queryNonFunctionalStatusofVaccination);
					$queryNonFunctionalStatusofSurveillance = "insert into facilities_status(id,facode,status,w_y_from,w_y_to,added_date,reason_vacc,reason_ds) 
													values ('{$facodee}-2','{$facodee}','N','2016-01','{$weekYearTo}','{$dateToday}','NC','NC');";
					$this->db->query($queryNonFunctionalStatusofSurveillance);
					$queryFunctionalStatusofVaccination = "insert into facilities_status(id,facode,status,m_y_from,added_date,reason_vacc,reason_ds) 
													values ('{$facodee}-3','{$facodee}','F','{$currentMonth}','{$dateToday}','NC','NC');";
					$this->db->query($queryFunctionalStatusofVaccination);
					$queryFunctionalStatusofSurveillance = "insert into facilities_status(id,facode,status,w_y_from,added_date,reason_vacc,reason_ds) 
													values ('{$facodee}-4','{$facodee}','F','{$currentWeek->fweek}','{$dateToday}','NC','NC');";
					$this->db->query($queryFunctionalStatusofSurveillance);
																										  
	  
																															 
																																																																																			  
																																										
																											 
																																																										 
																								   
																										
	  
																															 
																																																																																			   
																																									  
																												
																																																																			   
																																								   
																										  
	   
	 
					/* Population Updation Code Start here */
					/* $this->db->delete('unioncouncil_population', array(
						'distcode'=> $district,
						'year'=>$year
					));
					$this->db->delete('tehsil_population', array(
						'distcode'=> $district,
						'year'=>$year
					));
					$this->db->delete('districts_population', array(
						'distcode'=> $district,
						'year'=>$year
					));
					
					$unioncouncilQuery = "insert into unioncouncil_population(distcode,uncode,tcode,population,year) select distcode,uncode,tcode,sum(population::integer),year from facilities_population where uncode like '$district%' and year = '$year' group by distcode,tcode,uncode,year";
					$this->db->query($unioncouncilQuery);
					$unioncouncilUpdateQuery= "update unioncouncil_population set distcode='$district' where uncode like '$distcode%'";
					$this->db->query($unioncouncilUpdateQuery);
					$tehsilQuery = "insert into tehsil_population(distcode,tcode,population,year) select distcode,tcode,sum(population::integer),year from unioncouncil_population where tcode like '$district%' and year = '$year' group by distcode,tcode,year";
					$this->db->query($tehsilQuery);
					$tehsilUpdateQuery = "update tehsil_population set distcode='$district' where tcode like '$district%'";
					$this->db->query($tehsilUpdateQuery);
					$districtQuery = "insert into districts_population (distcode,population,year) select distcode,sum(population::integer),year from tehsil_population where distcode = '$district' and year = '$year' group by distcode,year";
					$this->db->query($districtQuery); */
														 
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
					}
					else
					{
						$this->db->trans_commit();
					}
					if($result != 0){
						createTransactionLog("Health Facility-DB", "Health Facility Added ".$facode);
						$location = base_url(). "System_setup/flcf_list";
						$message="Record Saved Successfully......";
						$this -> session -> set_flashdata('message',$message);
						//test to check at level 3  of sync when ever user login from any district.
						syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
						syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
						syncComplianceDataWithFederalEPIMIS('zeroreportcompliance');
						redirect($location);
						
					}
					exit();
				}
			}
	
		}
		return $data;
	}
	//================ Function for Adding New Facility or Editing Existing Health Facility Ends Here =======//
	//--------------------------------------------------------------------------------------------------//
	//================ Function for Uploading Image File to Folder Starts Here =========================//
	function uploadImageFile() { 
    	$iWidth = 150 ;
        $iHeight = 200; // desired image result dimensions
        $iJpgQuality = 90;
        // if no errors and size less than 250kb
        if (! $_FILES['technician_picture']['error'] && $_FILES['technician_picture']['size'] < 1024 * 1024) {
            if (is_uploaded_file($_FILES['technician_picture']['tmp_name'])) {
                // new unique filename
                if($this -> input -> post('doCrop') && $this -> input -> post('doCrop') == 'No'){
                	//Do not crop, simply save the original Image.
                    $sTarFileName = base_url().'includes/technician_picture/technician_$' .$this -> input -> post('techniciancode').'.jpg';
                    move_uploaded_file($_FILES['technician_picture']['tmp_name'], $sTarFileName);
                    return $sTarFileName ;
                }else{
                    //Crop and Save Image
                    $sTempFileName = base_url().'includes/technician_picture/'.time().md5();
                    // move uploaded file into folder
                	move_uploaded_file($_FILES['technician_picture']['tmp_name'], $sTempFileName);
                    // change file permission to 644
                    @chmod($sTempFileName, 0644);
                    if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                        $aSize = getimagesize($sTempFileName); // try to obtain image info
                        if (!$aSize) {
                            @unlink($sTempFileName);
                            return;
                        }
                        //check for image type
                        switch($aSize[2]) {
                            case IMAGETYPE_JPEG:
                            	$sExt = '.jpg';
                            	// create a new image from file 
                            	$vImg = @imagecreatefromjpeg($sTempFileName);
                            break;
                            case IMAGETYPE_PNG:
                            	$sExt = '.png';
                                // create a new image from file 
                            	$vImg = @imagecreatefrompng($sTempFileName);
                            break;
                            default:
                            @unlink($sTempFileName);
                            return;
                        }
                        // create a new true color image
                        $vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
                        // copy and resize part of an image with resampling
                        imagecopyresampled($vDstImg, $vImg, 0, 0, (int)$_POST['x1'], (int)$_POST['y1'], $iWidth, $iHeight, (int)$_POST['w'], (int)$_POST['h']);
                        // define a result image filename
                        $sResultFileName = base_url().'includes/technician_picture/technician_$' .$this -> input -> post('techniciancode').$sExt;
                        //$newImgLoc =  '.jpg';
                        // output image to file
                        imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
                        @unlink($sTempFileName);
                        return $sResultFileName;
                    }
                }
            }
        }
    }
	//================ Function for Uploading Image File to Folder Starts Ends Here =======//
	//--------------------------------------------------------------------//
	//================ Driver Listing Function Starts ================//
	public function driverdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Drivers', '/System_setup/driverdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "select drivername,drivercode,nic,status, is_temp_saved,facilitytype(facode) as facilitytype, districtname(distcode) as district from driverdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Driver Listing Function Ends Here =============================//
	//---------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Adding New Driver Record Starts Here =========//
	public function driverdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage EPI Driver', '/System_setup/driverdb_list');
		$this->breadcrumbs->push('Add New EPI Driver', '/System_setup/driverdb_add');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		$query="select distcode, district FROM districts where distcode='$district' order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();		

		/*$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac']= $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh']= $resultTeh -> result_array();		

		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();	*/

		$query="select supervisorcode, supervisorname FROM supervisordb  order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor']= $resultSupervisor -> result_array();
		
		$query="select ar_id, title from arallowances where ar_id IS NOT NULL";
		$resultAR= $this -> db ->query($query);
		$data['resultAR']= $resultAR -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
//print_r($data['resultbank']);exit;
		$query="select d_id, title from ardeductions where d_id IS NOT NULL";
		$resultAR= $this -> db ->query($query);
		$data['resultARD']= $resultAR -> result_array();
		
		return $data;
	}
	//================ Function to Show Page for Saving New Driver Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Driver Record Starts Here ================//
	public function driverdb_save($driverData,$drivercode,$drivercodeNewData){
		
		       /* Post Type FOr Posting  */
		$temp=$drivercodeNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$driverData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$drivercodeNewData['new_facode'];
		$tehcode=$drivercodeNewData['new_tcode'];
		$unccode=$drivercodeNewData['new_uncode'];
		$tcode=$driverData['drivercode'];
		$status=$driverData['status'];
		//uset data
		unset($driverData['post_type']);	
		unset($driverData['date_joining']);	
		unset($driverData['newfacode']);	
		unset($driverData['newuncode']);	
		unset($driverData['newtcode']);	
		//unset($driverData['bankaccountno']);	
		//unset($driverData['employee_type']);	

		///new working starting 
		$previous_table = $driverData['previous_code'];
		
			if($this -> input -> post ('edit')){
                
			 if($driverData['status']=='Active')
			 {
				$driverData['status']="Active"; 
				$driverData['date_joining']=$doj;	
			 }
			 if($driverData['status']=='post')
			 {
				$driverData['status']="Posted"; 
			 }
			//if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('driverdb',$driverData,array('drivercode'=>$drivercode));
			
			/* $updateQuery = $this -> Common_model -> update_record('driverdb',$driverData,array('drivercode'=>$drivercode)); */
			 if($driverData['status']=='Transfered')
			{
				$driverData['previouse_code']=$drivercode;
				$driverData['drivercode']=$drivercodeNewData['new_lhwcode'];
				$driverData['distcode']=$drivercodeNewData['new_distcode'];
				$driverData['uncode']=$drivercodeNewData['new_uncode'];
				$driverData['facode']=$drivercodeNewData['new_facode'];
				$driverData['tcode']=$drivercodeNewData['new_tcode'];
				$driverData['status']='Active';
				print_r($driverData);exit;
				$result = $this -> Common_model -> insert_record('driverdb', $driverData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $driverData['previous_code']=$drivercode;
         $driverData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $driverData['supervisorname']=$driverData['drivername'];
			  $driverData['supervisor_type']=$temp;
				//unset these values bcx these are for driverdb
				unset($driverData['drivername']);
				unset($driverData['status']);
				unset($driverData['drivercode']);
				unset($driverData['husbandname']);
				unset($driverData['reason']);
				unset($driverData['facode']);
				unset($driverData['bankaccount']);
				$driverData['status']='Active';
				$driverData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$driverData['distcode']."0001";
						} 
					
						$driverData['supervisorcode']=$supervisorcode;
						$driverData['tcode']=$tehcode;
						$driverData['previous_table']="driverdb";
					//print_r($driverData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $driverData);
			$location = base_url(). "DriverList";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $driverData['supervisorname']=$driverData['drivername'];
			  $driverData['supervisor_type']=$temp;
				/* Unset Data  */
				//unset these values bcx these are for driverdb
				unset($driverData['drivername']);
				unset($driverData['status']);
				unset($driverData['drivercode']);
				unset($driverData['husbandname']);
				unset($driverData['reason']);
				unset($driverData['facode']);
				unset($driverData['place_of_posting']);
				unset($driverData['area_type']);
				unset($driverData['postalcode']);
				unset($driverData['bankaccount']);
				$driverData['status']='Active';
				$driverData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$driverData['distcode']."0001";
						}
					 $driverData['supervisorcode']=$supervisorcode;
                     $driverData['previous_table']="driverdb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $driverData);
					//print_r($result);exit();
			$location = base_url(). "DriverList";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $driverData['supervisorname']=$driverData['drivername'];
			  $driverData['supervisor_type']=$temp;
				/* Unset Data */
				//unset these values bcx these are for driverdb
				unset($driverData['drivername']);
				unset($driverData['status']);
				unset($driverData['drivercode']);
				unset($driverData['husbandname']);
				unset($driverData['reason']);
				unset($driverData['facode']);
				unset($driverData['place_of_posting']);
				unset($driverData['area_type']);
				unset($driverData['postalcode']);
				unset($driverData['bankaccount']);
				$driverData['status']='Active';
				$driverData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$driverData['distcode']."0001";
						}
						$driverData['supervisorcode']=$supervisorcode;
                      //print_r($driverData);exit();
					//insert into supervisordb
					$driverData['tcode']=$tehcode;
					$driverData['previous_table']="driverdb";
				$driverData['facode']=$faccode;
				$driverData['uncode']=$unccode;
				$driverData['previous_table']="driverdb";
				//print_r($driverData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $driverData);
			$location = base_url(). "DriverList";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						//stcode for storekeeper

						//technician name to skname (change columnname)
						$driverData['skname']=$driverData['drivername'];
						//unset these values bcx these are for driverdb
						unset($driverData['drivername']);
						unset($driverData['status']);
						unset($driverData['drivercode']);
						unset($driverData['husbandname']);
						unset($driverData['reason']);
						unset($driverData['basic_training_start_date']);
						unset($driverData['supervisorcode']);
						unset($driverData['tcode']);
						unset($driverData['cold_chain_training_end_date']);
						unset($driverData['vlmis_training_end_date']);
						unset($driverData['tcode']);
						unset($driverData['vlmis_training_start_date']);
						unset($driverData['survilance_training_end_date']);
						unset($driverData['tcode']);
						unset($driverData['cold_chain_training_start_date']);
						unset($driverData['survilance_training_start_date']);
						unset($driverData['basic_training_end_date']);
						unset($driverData['routine_epi_start_date']);
						unset($driverData['routine_epi_end_date']);
						unset($driverData['catch_area_pop']);
						unset($driverData['catch_area_name']);
						unset($driverData['areatype']);
						$driverData['date_joining']=$doj;
						$driverData['status']='Active';
						//getting latest skcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$driverData['distcode']."0001";
						}
						$driverData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $driverData);
				$location = base_url(). "DriverList";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
					 
		// Start - data send to District surveillance oficer 

			else if($temp=='dsodb')
				{
					$driverData['dsoname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['mfpcode']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$driverData['distcode']."0001";
				}
					$driverData['dsocode']=$dsocode;
					//print_r($driverData);exit();
					//insert into dsodb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('dsodb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As District Surveillance Officer Form Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to Computer Operator

			else if($temp=='codb')
				{
					$driverData['coname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['mfpcode']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$driverData['distcode']."0001";
				}
					$driverData['cocode']=$cocode;
					//print_r($driverData);exit();
					//insert into codb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('codb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					
		// Start - data send to Measles Focal Person 
		
			else if($temp=='mfpdb')
				{
					$driverData['mfpname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['mfpcode']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$driverData['distcode']."0001";
				}
					$driverData['mfpcode']=$mfpcode;
					//print_r($driverData);exit();
					//insert into mfpdb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('mfpdb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Measles Focal Person  Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to HF Incharges 
		
			else if($temp=='med_techniciandb')
				{
					$driverData['technicianname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['techniciancode']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$driverData['distcode']."0001";
				}
					$driverData['techniciancode']=$techniciancode;
					//print_r($driverData);exit();
					//insert into med_techniciandb
					//$driverData['tcode']=$tehcode;
					$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As HF Incharges  Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to Measles Focal Person 
		
			else if($temp=='mfpdb')
				{
					$driverData['mfpname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['mfpcode']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$driverData['distcode']."0001";
				}
					$driverData['mfpcode']=$mfpcode;
					//print_r($driverData);exit();
					//insert into mfpdb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('mfpdb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to HF Incharges 
		
			else if($temp=='med_techniciandb')
				{
					$driverData['technicianname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['techniciancode']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$driverData['distcode']."0001";
				}
					$driverData['techniciancode']=$techniciancode;
					//print_r($driverData);exit();
					//insert into med_techniciandb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As HF Incharges Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					
		// Start - data send to Store-Keeper
		
			else if($temp=='skdb')
				{
					$driverData['skname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['skcode']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$driverData['distcode']."0001";
				}
					$driverData['skcode']=$skcode;
					//print_r($driverData);exit();
					//insert into skdb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('skdb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Store-Keeper Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to EPI Technician 
		
			else if($temp=='techniciandb')
				{
					$driverData['technicianname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['techniciancode']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$driverData['distcode']."0001";
				}
					$driverData['techniciancode']=$techniciancode;
					//print_r($driverData);exit();
					//insert into techniciandb
					//$driverData['tcode']=$tehcode;
					$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('techniciandb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As EPI Technician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to Cold Chain Technician 
		
			else if($temp=='cc_techniciandb')
				{
					$driverData['cc_technicianname']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['cc_techniciancode']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest cc_techniciancode from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('cc_techniciancode');
					$this->db->order_by('cc_techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('cc_techniciandb');
					$cc_techniciancode=0;
					foreach($query->result() as $row){
					$cc_techniciancode=$row->cc_techniciancode;
				}
					//check code exits
			if($cc_techniciancode!=null && $cc_techniciancode!=0)
				{
					//increment the  cc_techniciancode
					$cc_techniciancode=$cc_techniciancode+1;
				}
			else
				{
					//fisrt code
					$cc_techniciancode=$driverData['distcode']."0001";
				}
					$driverData['cc_techniciancode']=$cc_techniciancode;
					//print_r($driverData);exit();
					//insert into cc_techniciandb
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('cc_techniciandb', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Cold Chain Technician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					 
		// Start - data send to Cold Chain Operator 
		
			else if($temp=='cco_db')
				{
					$driverData['cco_name']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['cco_code']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest cco_code from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('cco_code');
					$this->db->order_by('cco_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('cco_db');
					$cco_code=0;
					foreach($query->result() as $row){
					$cco_code=$row->cco_code;
				}
					//check code exits
			if($cco_code!=null && $cco_code!=0)
				{
					//increment the  cco_code
					$cco_code=$cco_code+1;
				}
			else
				{
					//fisrt code
					$cco_code=$driverData['distcode']."0001";
				}
					$driverData['cco_code']=$cco_code;
					//print_r($driverData);exit();
					//insert into cco_db
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('cco_db', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Cold Chain Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					 
		// Start - data send to Generator Operator 
		
			else if($temp=='go_db')
				{
					$driverData['go_name']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['go_code']);
					unset($driverData['husbandname']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest go_code from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('go_code');
					$this->db->order_by('go_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('go_db');
					$go_code=0;
					foreach($query->result() as $row){
					$go_code=$row->go_code;
				}
					//check code exits
			if($go_code!=null && $go_code!=0)
				{
					//increment the  go_code
					$go_code=$go_code+1;
				}
			else
				{
					//fisrt code
					$go_code=$driverData['distcode']."0001";
				}
					$driverData['go_code']=$go_code;
					//print_r($driverData);exit();
					//insert into go_db
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('go_db', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Generator operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		// Start - data send to Cold Chain Mechanic 
		
			else if($temp=='cc_mechanic')
				{
					$driverData['ccm_name']=$driverData['drivername'];
					//unset these values bcx these are for driverdb Table
					unset($driverData['drivername']);
					unset($driverData['status']);
					unset($driverData['ccm_code']);
					unset($driverData['husbandname']);
					unset($driverData['reason']);
					unset($driverData['facode']);
					unset($driverData['date_resigned']);
					unset($driverData['current_status']);
					unset($driverData['drivercode']);
					unset($driverData['bankaccount']);
					unset($driverData['supervisorcode']);
					$driverData['status']='Active';
					$driverData['date_joining']=$doj;
					//getting latest ccm_code from db 
					$this->db->where('distcode',$driverData['distcode']);
					$this->db->select('ccm_code');
					$this->db->order_by('ccm_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('cc_mechanic');
					$ccm_code=0;
					foreach($query->result() as $row){
					$ccm_code=$row->ccm_code;
				}
					//check code exits
			if($ccm_code!=null && $ccm_code!=0)
				{
					//increment the  ccm_code
					$ccm_code=$ccm_code+1;
				}
			else
				{
					//fisrt code
					$ccm_code=$driverData['distcode']."0001";
				}
					$driverData['ccm_code']=$ccm_code;
					//print_r($driverData);exit();
					//insert into cc_mechanic
					//$driverData['tcode']=$tehcode;
					//$driverData['facode']=$faccode;
					//$driverData['uncode']=$unccode;
					$driverData['previous_table']="driverdb";
					$result = $this -> Common_model -> insert_record('cc_mechanic', $driverData);
					$location = base_url(). "DriverList";
					$message="Record Posted As Cold Chain Mechanic Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					 
				 //DataEntry Operator
				  else
				     {
						/*
						//technician name to deoname (change columnname)
						$driverData['deoname']=$driverData['drivername'];
						//previous_code
						$driverData['previous_code']=$tcode;
						//unset fields that are not necassary  for SkDB
						/* Unset Data *
						//unset these values bcx these are for driverdb
						unset($driverData['drivername']);
						unset($driverData['status']);
						//unset($driverData['newfacode']);
						//unset($driverData['newtcode']);
						//unset($driverData['newuncode']);
						//  unset($driverData['drivercode']);
						unset($driverData['husbandname']);
						unset($driverData['reason']);
						unset($driverData['drivercode']);
						unset($driverData['basic_training_start_date']);
						unset($driverData['supervisorcode']);
						unset($driverData['tcode']);
						unset($driverData['cold_chain_training_end_date']);
						unset($driverData['vlmis_training_end_date']);
						unset($driverData['tcode']);
						unset($driverData['vlmis_training_start_date']);
						unset($driverData['survilance_training_end_date']);
						unset($driverData['tcode']);
						unset($driverData['cold_chain_training_start_date']);
						unset($driverData['survilance_training_start_date']);
						unset($driverData['basic_training_end_date']);
						unset($driverData['routine_epi_start_date']);
						unset($driverData['routine_epi_end_date']);
						unset($driverData['catch_area_pop']);
						unset($driverData['catch_area_name']);
						unset($driverData['bankaccount']);
						unset($driverData['areatype']);
						$driverData['status']='Active';
						$driverData['date_joining']=$doj;
						$driverData['status']='Active';
						//end

						//getting latest deocode from deodb 
						$this->db->where('distcode',$driverData['distcode']);
						$this->db->select('deocode');
						$this->db->order_by('deocode','desc');
						$this->db->limit('1');
						$query=$this->db->get('deodb');
						$deocode=0;
						foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else
						{
						//fisrt code
						$deocode=$driverData['distcode']."0001";
						}
						$driverData['deocode']=$deocode;
						//print_r($driverData);exit;
						//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $driverData);
				     $location = base_url(). "DriverList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			
			/* 	if($this -> db -> affected_rows() > 0){
				createTransactionLog("Technician-DB", "Technician Updated ".$drivercode);
				$location = base_url(). "System_setup/technician_view/".$drivercode;
				$message="Record Updated for Tech with Code ".$drivercode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Technician-DB", "Technician Updated ".$drivercode);
				$location = base_url(). "System_setup/technician_list";
				$message="Record Updated for Tech with Code ".$drivercode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			} */
			//$location = base_url(). "System_setup/technician_view/".$drivercode;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		//}
		
		///new working ending
		//if($this -> input -> post ('edit')){
		//	$updateQuery = $this -> Common_model -> update_record('driverdb',$driverData,array('drivercode'=>$drivercode));
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("Driver-DB", "Driver Updated ".$drivercode);
				$location = base_url(). "System_setup/driverdb_view/".$drivercode;
				$message="Record Updated for Driver with Code ".$drivercode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Driver-DB", "Driver Updated ".$drivercode);
				$location = base_url(). "System_setup/driverdb_list";
				$message="Record Updated for Driver with Code ".$drivercode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
			
		}
		else{
			$checkquery = "select count(*) as cnt from driverdb where drivercode='$drivercode'";
		    $checkresult= $this -> db -> query ($checkquery);
		    $checkrow= $checkresult -> row_array();
		    $recexist=(int)$checkrow['cnt'];
		    if($recexist==1){
		        $script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Driver Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();
			}
			$result = $this -> Common_model -> insert_record('driverdb', $driverData);
			if($result != 0){
				createTransactionLog("Driver-DB", "Driver Added ".$drivercode);
				$location = base_url(). "System_setup/driverdb_list";
				$message="Record Saved for New Driver Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Driver Record Starts Here =============//
	public function driverdb_edit($drivercode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Driver', '/System_setup/driverdb_list');
		$this->breadcrumbs->push('Update Driver', '/System_setup/driverdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname from driverdb where drivercode = '$drivercode' ";
		$result=$this -> db -> query ($query);
		$data['driverdata']= $result -> row_array();

		$query="select *, districtname(distcode) as districtname from driverdb where drivercode = '$drivercode' ";
		$result=$this -> db -> query ($query);
		$data['driverdata']=$result -> row_array();
		
		$query="select distcode, district FROM districts order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();		

		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();
		
		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor'] = $resultSupervisor -> result_array();
		
		$query="select ar_id, title from arallowances where ar_id IS NOT NULL";
		$resultAR= $this -> db ->query($query);
		$data['resultAR']= $resultAR -> result_array();

		/*$query="select * from bankdb where distcode='$district'";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();*/

		/* $query="select * from bankdb";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array(); */
		
		//$district_new=$data['codata']['distcode']; 
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		

		$query="select d_id, title from ardeductions where d_id IS NOT NULL";
		$resultAR= $this -> db ->query($query);
		$data['resultARD']= $resultAR -> result_array();
		//echo '<pre>';print_r($data);exit;		
		return $data;
	}	
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here =============//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Viewing Existing Driver Record Starts Here ======================//
	public function driverdb_view($drivercode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Driver', '/System_setup/driverdb_list');
		$this->breadcrumbs->push('Driver View', '/System_setup/driverdb_view');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		//$query="select *, supervisorname(supervisorcode) as supervisorname, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil  from techniciandb where techniciancode = '$techniciancode' ";
		$query="select driverdb.* ,supervisorname(driverdb.supervisorcode) as supervisorname, facilityname(driverdb.facode) as facilityname, districtname(driverdb.distcode), tehsilname(driverdb.tcode), coalesce(unname(driverdb.uncode),'') as unioncouncil, bankdb.branchcode as bcode,bankdb.bankname as bank, bankdb.branchname from driverdb  left join bankdb  on  driverdb.bid= bankdb.branchcode where driverdb.drivercode='$drivercode'"; 

		$result= $this -> db -> query ($query);
		$data['driverdata']= $result -> row_array();
		return $data;
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//--------------------------------------------------------------------//
	//================ Account Supervisor Listing Function Starts ================//
	public function asdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Account Supervisor', '/System_setup/asdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by facode";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tcode";
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
		// Change `records` according to your table name.
		$query = "select *,  districtname(distcode) as district from asdb where $wc order by asdb.ascode LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Supervisor Starts Here =======//	
	public function asdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Account Supervisor', '/System_setup/asdb_list');
		$this->breadcrumbs->push('Add New Account Supervisor', '/System_setup/asdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by distcode";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by facode";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tcode";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select ar_id, title from arallowances where ar_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultAR']= $resultAR -> result_array();
			$query="select * from bankdb";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			$query="select d_id, title from ardeductions where d_id IS NOT NULL";
			$resultAR= $this -> db ->query($query);
			$data['resultARD']= $resultAR -> result_array();
			return $data;
		}else{
			return 0;
		}
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	public function codb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Computer Operator', '/System_setup/codb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from codb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Supervisor Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Supervisor Starts Here =======//	
	public function codb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Computer Operator', '/System_setup/codb_list');
		$this->breadcrumbs->push('Add New Computer Operator', '/System_setup/codb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor']= $resultSupervisor -> result_array();
		
		return $data;
		
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Computer Operator Record Starts Here =================//
	public function codb_save($coData,$cocode,$coDataNewData){ 
		  /* Post Type FOr Posting  */
		$temp=$coDataNewData['post_type'];
		//print_r($co_code);exit;
		 $doj=$coData['date_joining'];
		        /* FOR DSV TSV FSV  */
		//$faccode=$coDataNewData['new_facode'];
		//$tehcode=$coDataNewData['new_tcode'];
		//$unccode=$coDataNewData['new_uncode'];
		$tcode=$coData['cocode'];
		$status=$coData['status'];
		//uset data
		unset($coData['post_type']);	
		unset($coData['date_joining']);	
		unset($coData['newfacode']);	
		unset($coData['newuncode']);	
		unset($coData['newtcode']);	
		unset($coData['date_resigned']);	
		$pre_code=$coData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($coData['status']=='Active')
			 {
				$coData['status']="Active"; 
				$coData['date_joining']=$doj;	
			 }
			 if($coData['status']=='post')
			 {
				$coData['status']="Posted"; 
			 }
		 
			$updateQuery = $this -> Common_model -> update_record('codb',$coData,array('cocode'=>$cocode));
			 if($coData['status']=='Transfered')
			{
				$coData['previouse_code']=$cocode;
				$coData['cocode']=$coDataNewData['new_lhwcode'];
				//print_r($coData['cocode']); exit;
				$coData['distcode']=$coDataNewData['new_distcode'];
				//$coData['uncode']=$coDataNewData['new_uncode'];
				//$coData['facode']=$coDataNewData['new_facode'];
				//$coData['tcode']=$coDataNewData['new_tcode'];
				$coData['status']='Active';
				//print_r($coData);exit;
				$result = $this -> Common_model -> insert_record('codb', $coData);
				
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $coData['previous_code']=$cocode;
         $coData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $coData['supervisorname']=$coData['coname'];
			  $coData['supervisor_type']=$temp;
				//unset these values bcx these are for codb
				unset($coData['coname']);
				unset($coData['status']);
				unset($coData['cocode']);
				unset($coData['husbandname']);
				unset($coData['reason']);
				unset($coData['facode']);
				$coData['status']='Active';
				$coData['date_joining']=$doj;
					//getting latest supervisorcode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$coData['distcode']."0001";
						}
					
						$coData['supervisorcode']=$supervisorcode;
						$coData['tcode']=$tehcode;
						$coData['previous_table']="codb";
					//print_r($coData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $coData);
			$location = base_url(). "Computer-Operator-List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
			  $coData['supervisorname']=$coData['coname'];
			  $coData['supervisor_type']=$temp;
				/* Unset Data  */
				//unset these values bcx these are for techniciandb
				unset($coData['coname']);
				unset($coData['status']);
				unset($coData['cocode']);
				unset($coData['husbandname']);
				unset($coData['reason']);
				unset($coData['facode']);
				unset($coData['place_of_posting']);
				unset($coData['area_type']);
				unset($coData['postalcode']);

				$coData['status']='Active';
				$coData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$coData['distcode']."0001";
						}
						$coData['supervisorcode']=$supervisorcode;
						$coData['previous_table']="codb";
                     
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $coData);
					//print_r($result);exit();
			$location = base_url(). "Computer-Operator-List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $coData['supervisorname']=$coData['coname'];
			  $coData['supervisor_type']=$temp;
				/* Unset Data */
				//unset these values bcx these are for techniciandb
				unset($coData['coname']);
				unset($coData['status']);
				unset($coData['cocode']);
				unset($coData['husbandname']);
				unset($coData['reason']);
				unset($coData['facode']);
				unset($coData['place_of_posting']);
				unset($coData['area_type']);
				unset($coData['postalcode']);
				$coData['status']='Active';
				$coData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$coData['distcode']."0001";
						}
						$coData['supervisorcode']=$supervisorcode;
                      //print_r($coData);exit();
					//insert into supervisordb
					$coData['tcode']=$tehcode;
				$coData['facode']=$faccode;
				$coData['uncode']=$unccode;
				$coData['previous_table']="codb";
				//print_r($coData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $coData);
			$location = base_url(). "Computer-Operator-List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			// Start - data send to District Surveillance Officer
			else if($temp=='dsodb'){
			//stcode for supervisor 
					$coData['dsoname']=$coData['coname'];
					unset($coData['coname']);
					unset($coData['status']);
					unset($coData['cocode']);
					unset($coData['husbandname']);
					unset($coData['reason']);
					unset($coData['facode']);
					unset($coData['date_resigned']);
					//  unset($coData['previous_code']);
					unset($coData['current_status']);
					$coData['status']='Active';
					$coData['date_joining']=$doj;
					//echo "<pre>";print_r($coData);exit;
					//getting latest dsocode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
			}
			//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					$dsocode=$dsocode+1;

				} 
			else
				{
					//fisrt code
					$dsocode=$coData['distcode']."0001";
				}
					$coData['dsocode']=$dsocode;
					// echo "<pre>"; print_r($coData);exit();
					//insert into dsodb
					//$coData['tcode']=$tehcode;
					//$coData['facode']=$faccode;
					//$coData['uncode']=$unccode;
					$coData['previous_table']="codb";
					//print_r($coData);exit();
					//echo "<pre>";print_r($coData);exit;
					$result = $this -> Common_model -> insert_record('dsodb', $coData);
					$location = base_url(). "Computer-Operator-List";
					$message="Record Posted As District Surveillance Officer Successfully. ";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);

			}
			// Start - data send to Computer Operator 
		/* 	else if($temp=='codb'){
			//stcode for supervisor 
					$coData['coname']=$coData['coname'];
					unset($coData['coname']);
					unset($coData['status']);
					unset($coData['cocode']);
					unset($coData['husbandname']);
					unset($coData['reason']);
					unset($coData['facode']);
					unset($coData['date_resigned']);
					//  unset($coData['previous_code']);
					unset($coData['current_status']);
					$coData['status']='Active';
					$coData['date_joining']=$doj;
					//echo "<pre>";print_r($coData);exit;
					//getting latest cocode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
			}
			//check code exits
			if($cocode!=null && $cocode!=0)
				{
					$cocode=$cocode+1;

				} 
			else
				{
					//fisrt code
					$cocode=$coData['distcode']."0001";
				}
					$coData['cocode']=$cocode;
					// echo "<pre>"; print_r($coData);exit();
					//insert into codb
					//$coData['tcode']=$tehcode;
					//$coData['facode']=$faccode;
					//$coData['uncode']=$unccode;
					$coData['previous_table']="codb";
					//print_r($coData);exit();
					//echo "<pre>";print_r($coData);exit;
					$result = $this -> Common_model -> insert_record('codb', $coData);
					$location = base_url(). "Computer-Operator-List";
					$message="Record Posted As Computer Operator Successfully. ";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);

			} */
			// Start - data send to Measles Focal Person  
			/* else if($temp=='mfpdb'){
			//stcode for supervisor 
					$coData['mfpname']=$coData['coname'];
					unset($coData['coname']);
					unset($coData['status']);
					unset($coData['mfpcode']);
					unset($coData['husbandname']);
					unset($coData['reason']);
					unset($coData['facode']);
					unset($coData['date_resigned']);
					//  unset($coData['previous_code']);
					unset($coData['current_status']);
					$coData['status']='Active';
					$coData['date_joining']=$doj;
					//echo "<pre>";print_r($coData);exit;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$coData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
			}
			//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					$mfpcode=$mfpcode+1;

				} 
			else
				{
					//fisrt code
					$mfpcode=$coData['distcode']."0001";
				}
					$coData['mfpcode']=$mfpcode;
					// echo "<pre>"; print_r($coData);exit();
					//insert into mfpdb
					//$coData['tcode']=$tehcode;
					//$coData['facode']=$faccode;
					//$coData['uncode']=$unccode;
					$coData['previous_table']="codb";
					//print_r($coData);exit();
					//echo "<pre>";print_r($coData);exit;
					$result = $this -> Common_model -> insert_record('mfpdb', $coData);
					$location = base_url(). "Computer-Operator-List";
					$message="Record Posted As Measles Focal Person Successfully. ";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);

			} */
			
				 //DataEntry Operator
				  else
				     {
						/* 
						//technician name to deoname (change columnname)
						$coData['deoname']=$coData['coname'];
						//previous_code
						$coData['previous_code']=$tcode;
						//unset fields that are not necassary  for SkDB
						/* Unset Data *
						//unset these values bcx these are for techniciandb
						unset($coData['coname']);
						unset($coData['status']);
						//unset($coData['newfacode']);
						//unset($coData['newtcode']);
						//unset($coData['newuncode']);
						//  unset($coData['cocode']);
						unset($coData['husbandname']);
						unset($coData['reason']);
						unset($coData['cocode']);
						unset($coData['basic_training_start_date']);
						unset($coData['supervisorcode']);
						unset($coData['tcode']);
						unset($coData['cold_chain_training_end_date']);
						unset($coData['vlmis_training_end_date']);
						unset($coData['tcode']);
						unset($coData['vlmis_training_start_date']);
						unset($coData['survilance_training_end_date']);
						unset($coData['tcode']);
						unset($coData['cold_chain_training_start_date']);
						unset($coData['survilance_training_start_date']);
						unset($coData['basic_training_end_date']);
						unset($coData['routine_epi_start_date']);
						unset($coData['routine_epi_end_date']);
						unset($coData['catch_area_pop']);
						unset($coData['catch_area_name']);
						unset($coData['areatype']);
						unset($coData['date_resigned']);
						$coData['status']='Active';
						$coData['date_joining']=$doj;
						$coData['status']='Active';
						//end

						//getting latest deocode from deodb 
						$this->db->where('distcode',$coData['distcode']);
						$this->db->select('deocode');
						$this->db->order_by('deocode','desc');
						$this->db->limit('1');
						$query=$this->db->get('deodb');
						$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$coData['distcode']."0001";
						}
						$coData['deocode']=$deocode;
					//print_r($coData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $coData);
				     $location = base_url(). "Computer-Operator-List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
				if($status=='Post Back')
				{
				 if($temp=='mfpdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$pre_code));
							//print_r($updateQuery);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Measles Focal Person Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='med_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$dsofficer,array('techniciancode'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to HF Incharge Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='skdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('skdb',$dsofficer,array('skcode'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Store-Keeper Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('techniciandb',$dsofficer,array('techniciancode'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Epi Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$pre_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Computer-Operator-List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
					/*For EPI Computer operator */
		/* 	if($temp=='codb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('codb',$dsofficer,array('cocode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Computer Operator Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				}
					/*For EPI mfpdb *
			else if($temp=='mfpdb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Measles Focal Person Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				} */
			}
				if($this -> db -> affected_rows() > 0){
				createTransactionLog("Computer Operator-DB", "Computer Operator Updated ".$cocode);
				$location = base_url(). "System_setup/codb_view/".$cocode;
				$message="Record Updated for Tech with Code ".$cocode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Computer Operator-DB", "Computer Operator Updated ".$cocode);
				$location = base_url(). "System_setup/codb_list";
				$message="Record Updated for Tech with Code ".$cocode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
			//$location = base_url(). "System_setup/codb_view/".$cocode;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		}
		else{
			$checkquery = "select count(*) as cnt from codb where cocode='$cocode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Computer Operator Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('codb', $coData);
			if($result != 0){
				createTransactionLog("Computer Operator-DB", "Computer Operator Added ".$cocode);
				$location = base_url(). "Computer-Operator-List";
				$message="Record Saved for New Computer Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Supervisor Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here ===============//
	public function codb_edit($cocode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Computer Operator', '/System_setup/codb_list');
		$this->breadcrumbs->push('Update Computer Operator', '/System_setup/codb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(codb.distcode), facilityname(facode) as facilityname from codb where cocode = '$cocode' ";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		//$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		//$resultSupervisor=$this -> db -> query ($query);
		//$data['resultSupervisor'] = $resultSupervisor -> result_array();
				
		$query="select distcode, district FROM districts order by district ASC";
		$result=$this -> db -> query ($query);
		$data['dists'] = $result -> result_array();
		
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Supervisor Record Starts Here ==============//
	public function codb_view($cocode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Computer Operator', '/System_setup/codb_list');
		$this->breadcrumbs->push('Computer Operator View', '/System_setup/codb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select codb.* , facilityname(codb.facode) as facilityname, districtname(codb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from codb  left join bankinfo  on  codb.bid= bankinfo.bankid where codb.cocode='$cocode'"; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Supervisor Record Ends Here ================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New  Measles Focal Person Ends Here =========================//
	public function mfpdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Measles Focal Person', '/System_setup/mfpdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from mfpdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================  Measles Focal Person Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New  Measles Focal Person Starts Here =======//	
	public function mfpdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage  Measles Focal Person', '/System_setup/mfpdb_list');
		$this->breadcrumbs->push('Add New  Measles Focal Person', '/System_setup/mfpdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor']= $resultSupervisor -> result_array();
		
		return $data;
		
	}
	//================ Function to Show Page for Adding New  Measles Focal Person Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing  Measles Focal Person Record Starts Here =================//
	
	public function mfpdb_save($mfpData,$mfpcode,$mfpDataNewData){ 
		  /* Post Type FOr Posting  */
		 //print_r($mfpData);exit;
		$temp=$mfpDataNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$mfpData['date_joining'];
		        /* FOR DSV TSV FSV  */
		//$faccode=$mfpDataNewData['new_facode'];
		//$tehcode=$mfpDataNewData['new_tcode'];
		//$unccode=$coDataNewData['new_uncode'];
		$tcode=$mfpData['mfpcode'];
		$status=$mfpData['status'];
		//uset data
		  unset($mfpData['post_type']);	
		   unset($mfpData['date_joining']);	
		  unset($mfpData['newfacode']);	
         unset($mfpData['newuncode']);	
        unset($mfpData['newtcode']);	
		
		//print_r($mfpData);exit;
		
		$mfp_code=$mfpData['previous_code'];
		
		
		
		if($this -> input -> post ('edit')){
                
			 if($mfpData['status']=='Active')
			 {
				$mfpData['status']="Active"; 
				$mfpData['date_joining']=$doj;	
			 }
			 if($mfpData['status']=='post')
			 {
				$mfpData['status']="Posted"; 
			 }
		 
			$updateQuery = $this -> Common_model -> update_record('mfpdb',$mfpData,array('mfpcode'=>$mfpcode));
			 if($mfpData['status']=='Transfered')
			{
				$mfpData['previouse_code']=$mfpcode;
				$mfpData['mfpcode']=$mfpDataNewData['new_lhwcode'];
				//print_r($mfpData['mfpcode']); exit;
				$mfpData['distcode']=$mfpDataNewData['new_distcode'];
				//$mfpData['uncode']=$mfpDataNewData['new_uncode'];
				//$mfpData['facode']=$mfpDataNewData['new_facode'];
				//$mfpData['tcode']=$mfpDataNewData['new_tcode'];
				$mfpData['status']='Active';
				//print_r($mfpData);exit;
				$result = $this -> Common_model -> insert_record('mfpdb', $mfpData);
				
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $mfpData['previous_code']=$mfpcode;
         $mfpData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $mfpData['supervisorname']=$mfpData['mfpname'];
			  $mfpData['supervisor_type']=$temp;
				//unset these values bcx these are for mfpdb
				unset($mfpData['mfpname']);
				unset($mfpData['status']);
				unset($mfpData['mfpcode']);
				unset($mfpData['husbandname']);
				unset($mfpData['reason']);
				unset($mfpData['facode']);
				$mfpData['status']='Active';
				$mfpData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$mfpData['distcode']."0001";
						}
					
						$mfpData['supervisorcode']=$supervisorcode;
						$mfpData['tcode']=$tehcode;
						$mfpData['previous_table']="mfpdb";
					//print_r($mfpData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $mfpData);
			$location = base_url(). "Measles-Focal-Person-List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $mfpData['supervisorname']=$mfpData['mfpname'];
			  $mfpData['supervisor_type']=$temp;
				/* Unset Data  */
				//unset these values bcx these are for techniciandb
				unset($mfpData['mfpname']);
				unset($mfpData['status']);
				unset($mfpData['mfpcode']);
				unset($mfpData['husbandname']);
				unset($mfpData['reason']);
				unset($mfpData['facode']);
				unset($mfpData['place_of_posting']);
				unset($mfpData['area_type']);
				unset($mfpData['postalcode']);

			$mfpData['status']='Active';
			$mfpData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$mfpData['distcode']."0001";
						}
						$mfpData['supervisorcode']=$supervisorcode;
						$mfpData['previous_table']="mfpdb";
                     
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $mfpData);
					//print_r($result);exit();
			$location = base_url(). "Measles-Focal-Person-List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $mfpData['supervisorname']=$mfpData['mfpname'];
			  $mfpData['supervisor_type']=$temp;
				/* Unset Data */
				//unset these values bcx these are for techniciandb
				unset($mfpData['mfpname']);
				unset($mfpData['status']);
				unset($mfpData['mfpcode']);
				unset($mfpData['husbandname']);
				unset($mfpData['reason']);
				unset($mfpData['facode']);

				$mfpData['status']='Active';
				$mfpData['date_joining']=$doj;
				//getting latest supervisorcode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$mfpData['distcode']."0001";
						}
						$mfpData['supervisorcode']=$supervisorcode;
                      //print_r($mfpData);exit();
					//insert into supervisordb
					$mfpData['tcode']=$tehcode;
				$mfpData['facode']=$faccode;
				$mfpData['uncode']=$unccode;
				$mfpData['previous_table']="mfpdb";
				//print_r($mfpData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $mfpData);
			$location = base_url(). "Measles-Focal-Person-List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						$mfpData['skname']=$mfpData['mfpname'];
						//unset these values bcx these are for techniciandb
						unset($mfpData['mfpname']);
						unset($mfpData['status']);
						unset($mfpData['mfpcode']);
						unset($mfpData['husbandname']);
						unset($mfpData['reason']);
						unset($mfpData['basic_training_start_date']);
						unset($mfpData['supervisorcode']);
						unset($mfpData['tcode']);
						unset($mfpData['cold_chain_training_end_date']);
						unset($mfpData['vlmis_training_end_date']);
						unset($mfpData['tcode']);
						unset($mfpData['vlmis_training_start_date']);
						unset($mfpData['survilance_training_end_date']);
						unset($mfpData['tcode']);
						unset($mfpData['cold_chain_training_start_date']);
						unset($mfpData['survilance_training_start_date']);
						unset($mfpData['basic_training_end_date']);
						unset($mfpData['routine_epi_start_date']);
						unset($mfpData['routine_epi_end_date']);
						unset($mfpData['catch_area_pop']);
						unset($mfpData['catch_area_name']);
						unset($mfpData['areatype']);
						$mfpData['date_joining']=$doj;
						$mfpData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$mfpData['distcode']."0001";
						}
						$mfpData['skcode']=$skcode;
						//$mfpData['previous_table']="mfpdb";

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $mfpData);
					//print_r($result);
					//exit;
				$location = base_url(). "Measles-Focal-Person-List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
				 //DataEntry Operator
				 
					 
// Start - data send to District surveillance oficer 

			else if($temp=='dsodb')
				{
					$mfpData['dsoname']=$mfpData['mfpname'];
					//unset these values bcx these are for mfpdb Table
					unset($mfpData['mfpname']);
					unset($mfpData['status']);
					unset($mfpData['mfpcode']);
					unset($mfpData['husbandname']);
					unset($mfpData['reason']);
					unset($mfpData['facode']);
					unset($mfpData['date_resigned']);
					unset($mfpData['current_status']);
					$mfpData['status']='Active';
					$mfpData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$mfpData['distcode']."0001";
				}
					$mfpData['dsocode']=$dsocode;
					//print_r($mfpData);exit();
					//insert into dsodb
					//$mfpData['tcode']=$tehcode;
					//$mfpData['facode']=$faccode;
					//$mfpData['uncode']=$unccode;
					$mfpData['previous_table']="mfpdb";
					$result = $this -> Common_model -> insert_record('dsodb', $mfpData);
					$location = base_url(). "Measles-Focal-Person-List";
					$message="Record Posted As District Surveillance Officer Form Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
		 
// Start - data send to Computer Operator

			else if($temp=='codb')
				{
					$mfpData['coname']=$mfpData['mfpname'];
					//unset these values bcx these are for mfpdb Table
					unset($mfpData['mfpname']);
					unset($mfpData['status']);
					unset($mfpData['mfpcode']);
					unset($mfpData['husbandname']);
					unset($mfpData['reason']);
					unset($mfpData['facode']);
					unset($mfpData['date_resigned']);
					unset($mfpData['current_status']);
					//unset($mfpData['cocode']);
					$mfpData['status']='Active';
					$mfpData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$mfpData['distcode']."0001";
				}
					$mfpData['cocode']=$cocode;
					//print_r($mfpData);exit();
					//insert into codb
					//$mfpData['tcode']=$tehcode;
					//$mfpData['facode']=$faccode;
					//$mfpData['uncode']=$unccode;
					$mfpData['previous_table']="mfpdb";
					$result = $this -> Common_model -> insert_record('codb', $mfpData);
					$location = base_url(). "Measles-Focal-Person-List";
					$message="Record Posted As Computer OperatorForm Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
	
// End - data send to District surveillance oficer 
 
			else
				     {
						/* 
						 //technician name to deoname (change columnname)
						 $mfpData['deoname']=$mfpData['mfpname'];
						 //previous_code
						 			 $mfpData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for techniciandb
              unset($mfpData['mfpname']);
			    unset($mfpData['status']);
				//unset($mfpData['newfacode']);
		//unset($mfpData['newtcode']);
		//unset($mfpData['newuncode']);
				//  unset($mfpData['mfpcode']);
				    unset($mfpData['husbandname']);
					  unset($mfpData['reason']);
					    unset($mfpData['mfpcode']);
					   unset($mfpData['basic_training_start_date']);
					   unset($mfpData['supervisorcode']);
					   unset($mfpData['tcode']);
					   unset($mfpData['cold_chain_training_end_date']);
					   unset($mfpData['vlmis_training_end_date']);
					   unset($mfpData['tcode']);
					   unset($mfpData['vlmis_training_start_date']);
					   unset($mfpData['survilance_training_end_date']);
					   unset($mfpData['tcode']);
					   unset($mfpData['cold_chain_training_start_date']);
					    unset($mfpData['survilance_training_start_date']);
						 unset($mfpData['basic_training_end_date']);
						  unset($mfpData['routine_epi_start_date']);
					unset($mfpData['routine_epi_end_date']);
					   unset($mfpData['catch_area_pop']);
						 unset($mfpData['catch_area_name']);
						  unset($mfpData['areatype']);
						  unset($mfpData['date_resigned']);
						$mfpData['status']='Active';
						$mfpData['date_joining']=$doj;
						$mfpData['status']='Active';
				        //end
				
					//getting latest deocode from deodb 
					$this->db->where('distcode',$mfpData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$mfpData['distcode']."0001";
						}
						$mfpData['deocode']=$deocode;
					//print_r($mfpData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $mfpData);
				     $location = base_url(). "Measles-Focal-Person-List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }				
				}
		
				if($status=='Post Back')
				{
				 if($temp=='med_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$dsofficer,array('techniciancode'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to HF Incharge Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='skdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('skdb',$dsofficer,array('skcode'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Store-Keeper Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('techniciandb',$dsofficer,array('techniciancode'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Epi Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$mfp_code));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Measles-Focal-Person-List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
						else {
							
						}
					/*For EPI Computer operator */
		/* 	if($temp=='codb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('codb',$dsofficer,array('cocode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Computer Operator Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				}
					/*For EPI mfpdb *
			else if($temp=='mfpdb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Measles Focal Person Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				} */
			}		
					if($this -> db -> affected_rows() > 0){
					createTransactionLog("Measles Focal Person-DB", "Measles Focal Person Updated ".$mfpcode);
					$location = base_url(). "System_setup/mfpdb_view/".$mfpcode;
					$message="Record Updated for Tech with Code ".$mfpcode;
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
			else
				{
					createTransactionLog("Measles Focal Person-DB", "Measles Focal Person Updated ".$mfpcode);
					$location = base_url(). "System_setup/mfpdb_list";
					$message="Record Updated for Tech with Code ".$mfpcode;
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
					//$location = base_url(). "System_setup/mfpdb_view/".$mfpcode;
					//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
				}
			else
				{
					$checkquery = "select count(*) as cnt from mfpdb where mfpcode='$mfpcode'";
					//print_r($checkquery);exit;
					$checkresult=$this -> db -> query ($checkquery);
					$checkrow=$checkresult -> row_array();
					$recexist=(int)$checkrow['cnt'];
					//print_r($recexist);exit();
			if($recexist==1)
				{
					$script = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Measles Focal Person Code already exists....")';
					$script .= 'history.go(-1)';
					$script .= '</script>';
					echo $script;
					exit();	
				}
					$result = $this -> Common_model -> insert_record('mfpdb', $mfpData);
			if($result != 0)
				{
					createTransactionLog("Measles Focal Person-DB", "Measles Focal Person Added ".$mfpcode);
					$location = base_url(). "Measles-Focal-Person-List";
					$message="Record Saved for New Measles Focal Person Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}
			}
			exit();
			}
	//================ Function for Saving New or Existing  Measles Focal Person Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing  Measles Focal Person Record Starts Here ===============//
	public function mfpdb_edit($mfpcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Measles Focal Person', '/System_setup/mfpdb_list');
		$this->breadcrumbs->push('Update Measles Focal Person', '/System_setup/mfpdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(mfpdb.distcode), facilityname(facode) as facilityname from mfpdb where mfpcode = '$mfpcode' ";
		$result=$this -> db -> query ($query);
		$data['mfpdata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['mfpdata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		//$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		//$resultSupervisor=$this -> db -> query ($query);
		//$data['resultSupervisor'] = $resultSupervisor -> result_array();
				
		$query="select distcode, district FROM districts order by district ASC";
		$result=$this -> db -> query ($query);
		$data['dists'] = $result -> result_array();
		
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing  Measles Focal Person Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing  Measles Focal Person Record Starts Here ==============//
	public function mfpdb_view($mfpcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Measles Focal Person', '/System_setup/mfpdb_list');
		$this->breadcrumbs->push('Measles Focal Person View', '/System_setup/mfpdb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select mfpdb.* , facilityname(mfpdb.facode) as facilityname, districtname(mfpdb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from mfpdb  left join bankinfo  on  mfpdb.bid= bankinfo.bankid where mfpdb.mfpcode='$mfpcode'"; 

		$result=$this -> db -> query ($query);
		$data['mfpdata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	
	//================ Function to Show Page for Viewing Existing  Measles Focal Person Record Ends Here ================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New District Surveillance Officer Starts Here =======//	
	public function dsodb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage District Surveillance Officer', '/System_setup/dsodb_list');
		$this->breadcrumbs->push('Add New District Surveillance Officer', '/System_setup/dsodb_add');
		/////////////////////////////////////////////////////////////////
		
			$query="select distcode, district FROM districts order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();			
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
		
	}
	//================ Function to Show Page for Adding New District Surveillance Officer Ends Here =========================//
	//--------------------------------------------------------------------------------------------------------//
	//================ District Surveillance Officer Listing Function Starts ================//
	public function dsodb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage District Surveillance Officer', '/System_setup/dsodb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select distinct employee_type from dsodb where $wc order by employee_type ASC";
		$Emp_result = $this -> db -> query($query);
		$data['Emp_result'] = $Emp_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from dsodb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ District Surveillance Officer Listing Function Ends Here =============================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing District Surveillance Officer Record Starts Here =================//
	public function dsodb_save($dsoData,$dsoCode,$dsocodeNewData){
		//print_r($dsoData);exit;
		//new code starting
		        /* Post Type FOr Posting  */
		$temp=$dsocodeNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$dsoData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$dsocodeNewData['new_facode'];
		$tehcode=$dsocodeNewData['new_tcode'];
		$unccode=$dsocodeNewData['new_uncode'];
		$tcode=$dsoData['dsocode'];
		$status=$dsoData['status'];
		//uset data
		  unset($dsoData['post_type']);	
		   unset($dsoData['date_joining']);	
		  unset($dsoData['newfacode']);	
         unset($dsoData['newuncode']);	
        unset($dsoData['newtcode']);	
		
	
	$dstcode=$dsoData['previous_code'];
	
	
		if($this -> input -> post ('edit')){
                
			 if($dsoData['status']=='Active')
			 {
				$dsoData['status']="Active"; 
				$dsoData['date_joining']=$doj;	
			 }
			 if($dsoData['status']=='post')
			 {
				$dsoData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('dsodb',$dsoData,array('dsocode'=>$dsoCode));
			
			
			 if($dsoData['status']=='Transfered')
			{
				$dsoData['previouse_code']=$dsoCode;
				$dsoData['dsocode']=$dsocodeNewData['new_lhwcode'];
				$dsoData['distcode']=$dsocodeNewData['new_distcode'];
				$dsoData['uncode']=$dsocodeNewData['new_uncode'];
				$dsoData['facode']=$dsocodeNewData['new_facode'];
				$dsoData['tcode']=$dsocodeNewData['new_tcode'];
				$dsoData['status']='Active';
				print_r($dsoData);exit;
				$result = $this -> Common_model -> insert_record('dsodb', $dsoData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $dsoData['previous_code']=$dsoCode;
         $dsoData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $dsoData['supervisorname']=$dsoData['dsoname'];
			  $dsoData['supervisor_type']=$temp;
			  //unset these values bcx these are for dsodb
                unset($dsoData['dsoname']);
			    unset($dsoData['status']);
				  unset($dsoData['dsocode']);
				    unset($dsoData['husbandname']);
					  unset($dsoData['reason']);
					  unset($dsoData['telephone']);
					    unset($dsoData['facode']);
		$dsoData['status']='Active';
		$dsoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$dsoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$dsoData['distcode']."0001";
						} 
					
						$dsoData['supervisorcode']=$supervisorcode;
						$dsoData['tcode']=$tehcode;
						$dsoData['previous_table']="dsodb";
					//print_r($dsoData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $dsoData);
			$location = base_url(). "DSOList";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $dsoData['supervisorname']=$dsoData['dsoname'];
			  $dsoData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for dsodb
              unset($dsoData['dsoname']);
			    unset($dsoData['status']);
				  unset($dsoData['dsocode']);
				    unset($dsoData['husbandname']);
					  unset($dsoData['reason']);
					  unset($dsoData['telephone']);
					    unset($dsoData['facode']);
					    unset($dsoData['place_of_posting']);
					    unset($dsoData['area_type']);
					  unset($dsoData['postalcode']);
			$dsoData['status']='Active';
			$dsoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$dsoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$dsoData['distcode']."0001";
						}
					 $dsoData['supervisorcode']=$supervisorcode;
                     $dsoData['previous_table']="dsodb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $dsoData);
					//print_r($result);exit();
			$location = base_url(). "DSOList";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $dsoData['supervisorname']=$dsoData['dsoname'];
			  $dsoData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for dsodb
              unset($dsoData['dsoname']);
			    unset($dsoData['status']);
				  unset($dsoData['dsocode']);
				    unset($dsoData['husbandname']);
					  unset($dsoData['reason']);
					  unset($dsoData['telephone']);
					    unset($dsoData['facode']);
			$dsoData['status']='Active';
			$dsoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$dsoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$dsoData['distcode']."0001";
						}
						$dsoData['supervisorcode']=$supervisorcode;
                      //print_r($dsoData);exit();
					//insert into supervisordb
					$dsoData['tcode']=$tehcode;
					$dsoData['previous_table']="dsodb";
				$dsoData['facode']=$faccode;
				$dsoData['uncode']=$unccode;
				$dsoData['previous_table']="dsodb";
				//print_r($dsoData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $dsoData);
			$location = base_url(). "DSOList";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $dsoData['skname']=$dsoData['dsoname'];
			  //unset these values bcx these are for dsodb
              unset($dsoData['dsoname']);
			    unset($dsoData['status']);
				  unset($dsoData['dsocode']);
				    unset($dsoData['husbandname']);
					  unset($dsoData['reason']);
					   unset($dsoData['basic_training_start_date']);
					   unset($dsoData['supervisorcode']);
					   unset($dsoData['tcode']);
					   unset($dsoData['cold_chain_training_end_date']);
					   unset($dsoData['vlmis_training_end_date']);
					   unset($dsoData['tcode']);
					   unset($dsoData['vlmis_training_start_date']);
					   unset($dsoData['survilance_training_end_date']);
					   unset($dsoData['tcode']);
					   unset($dsoData['cold_chain_training_start_date']);
					    unset($dsoData['survilance_training_start_date']);
						 unset($dsoData['basic_training_end_date']);
						  unset($dsoData['routine_epi_start_date']);
					unset($dsoData['routine_epi_end_date']);
					   unset($dsoData['catch_area_pop']);
						 unset($dsoData['catch_area_name']);
						  unset($dsoData['areatype']);
						  $dsoData['date_joining']=$doj;
		$dsoData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$dsoData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$dsoData['distcode']."0001";
						}
						$dsoData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $dsoData);
				$location = base_url(). "DSOList";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
				 //DataEntry Operator
				  else
				     {
						/* 
						 //technician name to deoname (change columnname)
						 $dsoData['deoname']=$dsoData['dsoname'];
						 //previous_code
						 			 $dsoData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for dsodb
              unset($dsoData['dsoname']);
			    unset($dsoData['status']);
				//unset($dsoData['newfacode']);
		//unset($dsoData['newtcode']);
		//unset($dsoData['newuncode']);
				//  unset($dsoData['dsocode']);
				    unset($dsoData['husbandname']);
					  unset($dsoData['reason']);
					    unset($dsoData['dsocode']);
					   unset($dsoData['basic_training_start_date']);
					   unset($dsoData['supervisorcode']);
					   unset($dsoData['tcode']);
					   unset($dsoData['cold_chain_training_end_date']);
					   unset($dsoData['vlmis_training_end_date']);
					   unset($dsoData['tcode']);
					   unset($dsoData['vlmis_training_start_date']);
					   unset($dsoData['survilance_training_end_date']);
					   unset($dsoData['tcode']);
					   unset($dsoData['cold_chain_training_start_date']);
					    unset($dsoData['survilance_training_start_date']);
						 unset($dsoData['basic_training_end_date']);
						  unset($dsoData['routine_epi_start_date']);
					unset($dsoData['routine_epi_end_date']);
					   unset($dsoData['catch_area_pop']);
						 unset($dsoData['catch_area_name']);
						  unset($dsoData['areatype']);
						$dsoData['status']='Active';
						$dsoData['date_joining']=$doj;
						$dsoData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$dsoData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$dsoData['distcode']."0001";
						}
						$dsoData['deocode']=$deocode;
//print_r($dsoData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $dsoData);
				     $location = base_url(). "DSOList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}

			if($status=='Post Back')
				{
				if($temp=='codb')
						{
						$dsofficer=array('status'=>'Active');	
						//replace status of epitech to active from tempost
						$updateQuery = $this -> Common_model -> update_record('codb',$dsofficer,array('cocode'=>$dstcode));
						//print_r($$temp);exit;
						//print_r($updateQuery);exit;
						//delete temporary post from supervisordb
						/* $this->db->where('supervisorcode',$supervisorCode);
						$this->db->delete('supervisordb'); */
						$location = base_url(). "DSOList";
						$message="Record posted back to Computer Operator Successfully!";
						$this -> session -> set_flashdata('message',$message);
						redirect($location);
						exit();
						}
					else if($temp=='mfpdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Measles Focal Person Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='med_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$dsofficer,array('techniciancode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to HF Incharge Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='skdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('skdb',$dsofficer,array('skcode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Store-Keeper Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('techniciandb',$dsofficer,array('techniciancode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Epi Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$dstcode));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "DSOList";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
					/*For EPI Computer operator */
		/* 	if($temp=='codb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('codb',$dsofficer,array('cocode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Computer Operator Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				}
					/*For EPI mfpdb *
			else if($temp=='mfpdb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Measles Focal Person Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				} */
			}
		 
		// new code ending
		
		
		
		/* if($this -> input -> post ('edit')){
			//echo "abc";exit();
			$updateQuery = $this -> Common_model -> update_record('dsodb',$dsoData,array('dsocode'=>$dsoCode));  */
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("District Surveillance Officer-DB", "District Surveillance Officer Updated ".$dsoCode);
				$location = base_url(). "DSO/View/".$dsoCode;
				$message="Record Updated for District Surveillance Officer with Code ".$dsoCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				
				createTransactionLog("District Surveillance Officer-DB", "District Surveillance Officer Updated ".$dsoCode);
				$location = base_url(). "DSOList";
				$message="Record Updated for District Surveillance Officer with Code ".$dsoCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		else{
			//echo "xyz";exit();
			$checkquery = "select count(*) as cnt from dsodb where dsocode='$dsoCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("District Surveillance Officer Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('dsodb', $dsoData);
			if($result != 0){
				createTransactionLog("District Surveillance Officer-DB", "District Surveillance Officer Added ".$dsoCode);
				$location = base_url(). "DSOList";
				$message="Record Saved for New District Surveillance Officer Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing District Surveillance Officer Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing District Surveillance Officer Record Starts Here ===============//
	public function dsodb_edit($dsocode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage District Surveillance Officer', '/System_setup/dsodb_list');
		$this->breadcrumbs->push('Update District Surveillance Officer', '/System_setup/dsodb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *, facilityname(facode) as facilityname from dsodb where dsocode = '$dsocode' ";
		$result=$this -> db -> query ($query);
		$data['dsodata']=$result -> row_array();
		//echo '<pre>';print_r($data['dsodata']);exit;
		$query="select *, districtname(distcode) as districtname from dsodb where dsocode = '$dsocode' ";
		$result=$this -> db -> query ($query);
		$data['dsodata']=$result -> row_array();

		$query = "select distcode, district FROM districts  order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing District Surveillance Officer Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing District Surveillance Officer Record Starts Here ==============//
	public function dsodb_view($dsocode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage District Surveillance Officer', '/System_setup/dsodb_list');
		$this->breadcrumbs->push('District Surveillance Officer View', '/System_setup/dsodb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select dsodb.* , facilityname(dsodb.facode) as facilityname, districtname(dsodb.distcode), tehsilname(dsodb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from dsodb  left join bankinfo  on  dsodb.bid= bankinfo.bankid where dsodb.dsocode='$dsocode'"; 

		$result=$this -> db -> query ($query);
		$data['dsodata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing District Surveillance Officer Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Cold Chain Technician Listing Function Starts ================//
	public function cctdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Technician', '/System_setup/cctdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cctdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Cold Chain Technician Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Technician Starts Here =======//	
	public function cctdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Technician', '/System_setup/cctdb_list');
		$this->breadcrumbs->push('Add New Cold Chain Technician', '/System_setup/cctdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
		}else{
			return 0;
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Technician Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Technician Record Starts Here =================//
	public function cctdb_save($cctData,$cctCode){
		if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('cctdb',$cctData,array('cctcode'=>$cctCode));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "CCT/View/".$cctCode;
				$message="Record Updated for Cold Chain Technician with Code ".$cctCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "CCTList";
				$message="Record Updated for Cold Chain Technician with Code ".$cctCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from cctdb where cctcode='$cctCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Technician Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('cctdb', $cctData);
			if($result != 0){
				$location = base_url(). "CCTList";
				$message="Record Saved for New Cold Chain Technician Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Cold Chain Technician Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Technician Record Starts Here ===============//
	public function cctdb_edit($cctcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Technician', '/System_setup/cctdb_list');
		$this->breadcrumbs->push('Update Cold Chain Technician', '/System_setup/cctdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *, facilityname(facode) as facilityname from cctdb where cctcode = '$cctcode' ";
		$result=$this -> db -> query ($query);
		$data['cctdata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Cold Chain Technician Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Technician Record Starts Here ==============//
	public function cctdb_view($cctcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Technician', '/System_setup/cctdb_list');
		$this->breadcrumbs->push('Cold Chain Technician View', '/System_setup/cctdb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select cctdb.* , facilityname(cctdb.facode) as facilityname, districtname(cctdb.distcode), tehsilname(cctdb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from cctdb  left join bankinfo  on  cctdb.bid= bankinfo.bankid where cctdb.cctcode='$cctcode'"; 

		$result=$this -> db -> query ($query);
		$data['cctdata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Technician Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
		//--------------------------------------------------------------------------------------------------------//
		//================ Cold Chain Mechanic Listing Function Starts ================//
	public function ccmdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Mechanic', '/System_setup/ccmdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype, fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccmdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Cold Chain Mechanic Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Mechanic Starts Here =======//	
	public function ccmdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/ccmdb_list');
		$this->breadcrumbs->push('Add New Cold Chain Mechanic', '/System_setup/ccmdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
		}else{
			return 0;
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Mechanic Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Mechanic Record Starts Here =================//
	public function ccmdb_save($ccmData,$ccmCode){
		if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('ccmdb',$ccmData,array('ccmcode'=>$ccmCode));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "CCM/View/".$ccmCode;
				$message="Record Updated for Cold Chain Mechanic with Code ".$ccmCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "CCMList";
				$message="Record Updated for Cold Chain Mechanic with Code ".$ccmCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from ccmdb where ccmcode='$ccmCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Mechanic Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('ccmdb', $ccmData);
			if($result != 0){
				$location = base_url(). "CCMList";
				$message="Record Saved for New Cold Chain Mechanic Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Cold Chain Mechanic Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Mechanic Record Starts Here ===============//
	public function ccmdb_edit($ccmcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/ccmdb_list');
		$this->breadcrumbs->push('Update Cold Chain Mechanic', '/System_setup/ccmdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *, facilityname(facode) as facilityname from ccmdb where ccmcode = '$ccmcode' ";
		$result=$this -> db -> query ($query);
		$data['ccmdata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Cold Chain Mechanic Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Mechanic Record Starts Here ==============//
	public function ccmdb_view($ccmcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/ccmdb_list');
		$this->breadcrumbs->push('Cold Chain Mechanic View', '/System_setup/ccmdb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select ccmdb.* , facilityname(ccmdb.facode) as facilityname, districtname(ccmdb.distcode), tehsilname(ccmdb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from ccmdb  left join bankinfo  on  ccmdb.bid= bankinfo.bankid where ccmdb.ccmcode='$ccmcode'"; 

		$result=$this -> db -> query ($query);
		$data['ccmdata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Mechanic Record Ends Here ================//
		//--------------------------------------------------------------------------------------------------------//
		//================ Cold Chain Generator Operator Listing Function Starts ================//
	public function ccgdb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Generator Operator', '/System_setup/ccgdb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccgdb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Cold Chain Generator Operator Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Generator Operator Starts Here =======//	
	public function ccgdb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Generator Operator', '/System_setup/ccgdb_list');
		$this->breadcrumbs->push('Add New Cold Chain Generator Operator', '/System_setup/ccgdb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
		}else{
			return 0;
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Generator Operator Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Generator Operator Record Starts Here =================//
	public function ccgdb_save($ccgData,$ccgCode,$ccgNewData){
		//echo 'complete but not testing yet';
		//echo 'asd';exit;
		
		// start new codding  
		
		$temp=$ccgNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$ccgData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$ccgNewData['new_facode'];
		$tehcode=$ccgNewData['new_tcode'];
		$unccode=$ccgNewData['new_uncode'];
		$tcode=$ccgData['ccgcode'];
		$status=$ccgData['status'];
		//uset data
		  unset($ccgData['post_type']);	
		   unset($ccgData['date_joining']);	
		  unset($ccgData['newfacode']);	
         unset($ccgData['newuncode']);	
        unset($ccgData['newtcode']);	
		
		if($this -> input -> post ('edit')){
                
			 if($ccgData['status']=='Active')
			 {
				$ccgData['status']="Active"; 
				$ccgData['date_joining']=$doj;	
			 }
			 if($ccgData['status']=='post')
			 {
				$ccgData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('ccgdb',$ccgData,array('ccgcode'=>$ccgCode));
			 if($ccgData['status']=='Transfered')
			{
				$ccgData['previouse_code']=$ccgCode;
				$ccgData['ccgcode']=$ccgNewData['new_lhwcode'];
				$ccgData['distcode']=$ccgNewData['new_distcode'];
				$ccgData['uncode']=$ccgNewData['new_uncode'];
				$ccgData['facode']=$ccgNewData['new_facode'];
				$ccgData['tcode']=$ccgNewData['new_tcode'];
				$ccgData['status']='Active';
				print_r($ccgData);exit;
				$result = $this -> Common_model -> insert_record('ccgdb', $ccgData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $ccgData['previous_code']=$ccgCode;
         $ccgData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $ccgData['supervisorname']=$ccgData['technicianname'];
			  $ccgData['supervisor_type']=$temp;
			  //unset these values bcx these are for ccgdb
                unset($ccgData['technicianname']);
			    unset($ccgData['status']);
				  unset($ccgData['ccgcode']);
				    unset($ccgData['husbandname']);
					  unset($ccgData['reason']);
					    unset($ccgData['facode']);
		$ccgData['status']='Active';
		$ccgData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccgData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccgData['distcode']."0001";
						} 
					
						$ccgData['supervisorcode']=$supervisorcode;
						$ccgData['tcode']=$tehcode;
						$ccgData['previous_table']="ccgdb";
					//print_r($ccgData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccgData);
			$location = base_url(). "DSOList";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $ccgData['supervisorname']=$ccgData['technicianname'];
			  $ccgData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for ccgdb
              unset($ccgData['technicianname']);
			    unset($ccgData['status']);
				  unset($ccgData['ccgcode']);
				    unset($ccgData['husbandname']);
					  unset($ccgData['reason']);
					    unset($ccgData['facode']);
					    unset($ccgData['place_of_posting']);
					    unset($ccgData['area_type']);
					  unset($ccgData['postalcode']);
			$ccgData['status']='Active';
			$ccgData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccgData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccgData['distcode']."0001";
						}
					 $ccgData['supervisorcode']=$supervisorcode;
                     $ccgData['previous_table']="ccgdb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $ccgData);
					//print_r($result);exit();
			$location = base_url(). "TechnicianList";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $ccgData['supervisorname']=$ccgData['technicianname'];
			  $ccgData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for ccgdb
              unset($ccgData['technicianname']);
			    unset($ccgData['status']);
				  unset($ccgData['ccgcode']);
				    unset($ccgData['husbandname']);
					  unset($ccgData['reason']);
					    unset($ccgData['facode']);
			$ccgData['status']='Active';
			$ccgData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccgData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccgData['distcode']."0001";
						}
						$ccgData['supervisorcode']=$supervisorcode;
                      //print_r($ccgData);exit();
					//insert into supervisordb
					$ccgData['tcode']=$tehcode;
					$ccgData['previous_table']="ccgdb";
				$ccgData['facode']=$faccode;
				$ccgData['uncode']=$unccode;
				$ccgData['previous_table']="ccgdb";
				//print_r($ccgData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccgData);
			$location = base_url(). "TechnicianList";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $ccgData['skname']=$ccgData['technicianname'];
			  //unset these values bcx these are for ccgdb
              unset($ccgData['technicianname']);
			    unset($ccgData['status']);
				  unset($ccgData['ccgcode']);
				    unset($ccgData['husbandname']);
					  unset($ccgData['reason']);
					   unset($ccgData['basic_training_start_date']);
					   unset($ccgData['supervisorcode']);
					   unset($ccgData['tcode']);
					   unset($ccgData['cold_chain_training_end_date']);
					   unset($ccgData['vlmis_training_end_date']);
					   unset($ccgData['tcode']);
					   unset($ccgData['vlmis_training_start_date']);
					   unset($ccgData['survilance_training_end_date']);
					   unset($ccgData['tcode']);
					   unset($ccgData['cold_chain_training_start_date']);
					    unset($ccgData['survilance_training_start_date']);
						 unset($ccgData['basic_training_end_date']);
						  unset($ccgData['routine_epi_start_date']);
					unset($ccgData['routine_epi_end_date']);
					   unset($ccgData['catch_area_pop']);
						 unset($ccgData['catch_area_name']);
						  unset($ccgData['areatype']);
						  $ccgData['date_joining']=$doj;
		$ccgData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$ccgData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$ccgData['distcode']."0001";
						}
						$ccgData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $ccgData);
				$location = base_url(). "TechnicianList";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
				 //DataEntry Operator
				  else
				     {
						/* 
						 //technician name to deoname (change columnname)
						 $ccgData['deoname']=$ccgData['technicianname'];
						 //previous_code
						 			 $ccgData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for ccgdb
              unset($ccgData['technicianname']);
			    unset($ccgData['status']);
				//unset($ccgData['newfacode']);
		//unset($ccgData['newtcode']);
		//unset($ccgData['newuncode']);
				//  unset($ccgData['ccgcode']);
				    unset($ccgData['husbandname']);
					  unset($ccgData['reason']);
					    unset($ccgData['ccgcode']);
					   unset($ccgData['basic_training_start_date']);
					   unset($ccgData['supervisorcode']);
					   unset($ccgData['tcode']);
					   unset($ccgData['cold_chain_training_end_date']);
					   unset($ccgData['vlmis_training_end_date']);
					   unset($ccgData['tcode']);
					   unset($ccgData['vlmis_training_start_date']);
					   unset($ccgData['survilance_training_end_date']);
					   unset($ccgData['tcode']);
					   unset($ccgData['cold_chain_training_start_date']);
					    unset($ccgData['survilance_training_start_date']);
						 unset($ccgData['basic_training_end_date']);
						  unset($ccgData['routine_epi_start_date']);
					unset($ccgData['routine_epi_end_date']);
					   unset($ccgData['catch_area_pop']);
						 unset($ccgData['catch_area_name']);
						  unset($ccgData['areatype']);
						$ccgData['status']='Active';
						$ccgData['date_joining']=$doj;
						$ccgData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$ccgData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$ccgData['distcode']."0001";
						}
						$technicianData['deocode']=$deocode;
//print_r($ccgData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $ccgData);
				     $location = base_url(). "TechnicianList";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			/* if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('ccgdb',$ccgData,array('ccgcode'=>$ccgCode)); */
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "CCG/View/".$ccgCode;
				$message="Record Updated for Cold Chain Generator Operator with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "CCGList";
				$message="Record Updated for Cold Chain Generator Operator with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				
			}
				
				/* if($this -> db -> affected_rows() > 0){
				createTransactionLog("Technician-DB", "Technician Updated ".$ccgCode);
				$location = base_url(). "System_setup/technician_view/".$ccgCode;
				$message="Record Updated for Tech with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Technician-DB", "Technician Updated ".$ccgCode);
				$location = base_url(). "System_setup/technician_list";
				$message="Record Updated for Tech with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			} */
			//$location = base_url(). "System_setup/technician_view/".$ccgCode;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		//}
		
		// start new codding  
		
		
	/* 	if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('ccgdb',$ccgData,array('ccgcode'=>$ccgCode));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "CCG/View/".$ccgCode;
				$message="Record Updated for Cold Chain Generator Operator with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "CCGList";
				$message="Record Updated for Cold Chain Generator Operator with Code ".$ccgCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			} */
		}else{
			$checkquery = "select count(*) as cnt from ccgdb where ccgcode='$ccgCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Generator Operator Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('ccgdb', $ccgData);
			if($result != 0){
				$location = base_url(). "CCGList";
				$message="Record Saved for New Cold Chain Generator Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Cold Chain Generator Operator Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Generator Operator Record Starts Here ===============//
	public function ccgdb_edit($ccgcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Generator Operator', '/System_setup/ccgdb_list');
		$this->breadcrumbs->push('Update Cold Chain Generator Operator', '/System_setup/ccgdb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *, facilityname(facode) as facilityname from ccgdb where ccgcode = '$ccgcode' ";
		$result=$this -> db -> query ($query);
		$data['ccgdata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Cold Chain Generator Operator Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Generator Operator Record Starts Here ==============//
	public function ccgdb_view($ccgcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Generator Operator', '/System_setup/ccgdb_list');
		$this->breadcrumbs->push('Cold Chain Generator Operator View', '/System_setup/ccgdb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select ccgdb.* , facilityname(ccgdb.facode) as facilityname, districtname(ccgdb.distcode), tehsilname(ccgdb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from ccgdb  left join bankinfo  on  ccgdb.bid= bankinfo.bankid where ccgdb.ccgcode='$ccgcode'"; 

		$result=$this -> db -> query ($query);
		$data['ccgdata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Generator Operator Record Ends Here ================//
		//--------------------------------------------------------------------------------------------------------//
		//================ Cold Chain Driver Listing Function Starts ================//
	public function ccddb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Driver', '/System_setup/ccddb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccddb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Cold Chain Driver Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New Cold Chain Driver Starts Here =======//	
	public function ccddb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Driver', '/System_setup/ccddb_list');
		$this->breadcrumbs->push('Add New Cold Chain Driver', '/System_setup/ccddb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		if($district != null){
			$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
			$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array();
			$query="select * from bankinfo";
			$resultAR= $this -> db ->query($query);
			$data['resultbank']= $resultAR -> result_array();
			return $data;
		}else{
			return 0;
		}
	}
	//================ Function to Show Page for Adding New Cold Chain Driver Ends Here =========================//
	//----------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Cold Chain Driver Record Starts Here =================//
	public function ccddb_save($ccdData,$ccdCode){
		if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('ccddb',$ccdData,array('ccdcode'=>$ccdCode));
			if($this -> db -> affected_rows() > 0){
				$location = base_url(). "CCD/View/".$ccdCode;
				$message="Record Updated for Cold Chain Driver with Code ".$ccdCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				$location = base_url(). "CCDList";
				$message="Record Updated for Cold Chain Driver with Code ".$ccdCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from ccddb where ccdcode='$ccdCode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Driver Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('ccddb', $ccdData);
			if($result != 0){
				$location = base_url(). "CCDList";
				$message="Record Saved for New Cold Chain Driver Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Cold Chain Driver Record Ends Here ========================//
	//---------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Cold Chain Driver Record Starts Here ===============//
	public function ccddb_edit($ccdcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Driver', '/System_setup/ccddb_list');
		$this->breadcrumbs->push('Update Cold Chain Driver', '/System_setup/ccddb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *, facilityname(facode) as facilityname from ccddb where ccdcode = '$ccdcode' ";
		$result=$this -> db -> query ($query);
		$data['ccddata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Cold Chain Driver Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Cold Chain Driver Record Starts Here ==============//
	public function ccddb_view($ccdcode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Driver', '/System_setup/ccddb_list');
		$this->breadcrumbs->push('Cold Chain Driver View', '/System_setup/ccddb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select ccddb.* , facilityname(ccddb.facode) as facilityname, districtname(ccddb.distcode), tehsilname(ccddb.tcode) , bankinfo.bankcode as bcode,bankinfo.bankname as bank from ccddb  left join bankinfo  on  ccddb.bid= bankinfo.bankid where ccddb.ccdcode='$ccdcode'"; 

		$result=$this -> db -> query ($query);
		$data['ccddata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Cold Chain Driver Record Ends Here ================//
	//================ Function to Show Page for Adding New CC Operator Starts Here =======//	
	public function ccoperatordb_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Operator', '/System_setup/codb_list');
		$this->breadcrumbs->push('Add New Cold Chain Operator', '/System_setup/codb_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;
		
	}
	//================ Function to Show Page for Adding New Supervisor Ends Here =========================//
	//================ Function for Saving New or Existing Computer Operator Record Starts Here =================//
	public function ccoperatordb_save($coData,$c_id){
		if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('ccoperatordb',$coData,array('c_id'=>$c_id));
			if($this -> db -> affected_rows() > 0){
				//createTransactionLog("Computer Operator-DB", "Computer Operator Updated ".$c_id);
				$location = base_url(). "System_setup/ccoperatordb_view".$c_id;
				$message="Record Updated for Cold Chain Operator with ID ".$c_id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				//createTransactionLog("CC Operator-DB", "CC Operator Updated ".$c_id);
				$location = base_url(). "System_setup/ccoperatordb_list";
				$message="Record Updated for Cold Chain Operator with ID ".$c_id;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		else{
			
			$result = $this -> Common_model -> insert_record('ccoperatordb', $coData);
			if($result != 0){
				//createTransactionLog("CC Operator-DB", "Computer Operator Added ".$c_id);
				$location = base_url(). "System_setup/ccoperatordb_list";
				$message="Record Saved for New Cold Chain Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Supervisor Record Ends Here ========================//

	public function ccoperatordb_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Operator', '/System_setup/ccoperatordb_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from ccoperatordb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}

	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here ===============//
	public function ccoperatordb_edit($c_id){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Operator', '/System_setup/ccoperatordb_list');
		$this->breadcrumbs->push('Update Cold Chain Operator', '/System_setup/ccoperatordb_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(ccoperatordb.distcode), facilityname(facode) as facilityname from ccoperatordb where c_id = $c_id";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//================ Function to Show Page for Editing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Viewing Existing Supervisor Record Starts Here ==============//
	public function ccoperatordb_view($c_id){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Operator', '/System_setup/ccoperatordb_list');
		$this->breadcrumbs->push('Cold Chain Operator View', '/System_setup/ccoperatordb_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//echo $c_id;exit();		
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";		
		$query="select ccoperatordb.* , facilityname(ccoperatordb.facode) as facilityname, districtname(ccoperatordb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from ccoperatordb  left join bankinfo  on  ccoperatordb.bid= bankinfo.bankid where ccoperatordb.c_id=".$c_id; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	//================ Function to Show Page for Viewing Existing Supervisor Record Ends Here ================//
	//--------------------------------------------------------------------------------------------------------//
	//================ Medical Technician Listing Function Starts Here ===============================================//
	public function med_technician_list($startpoint,$per_page) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage HF Incharge', '/Medical-TechnicianList');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fac_name from facilities where  hf_type='e' AND $wc order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();

		$query = "SELECT distinct fatype from facilities where $wc and fatype is not null order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();

		$query = "Select uncode, un_name from unioncouncil where $wc order by un_name ASC";
		$UC_result = $this -> db -> query($query);
		$data['resultUnC'] = $UC_result -> result_array();

		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();

		/*$query = "Select uncode, un_name from unioncouncil where $wc order by uncode";
		$Dist_result = $this -> db -> query($query);
		$data['resultUnC'] = $Dist_result -> result_array();*/

		$query = "select supervisorcode, supervisorname FROM supervisordb WHERE $wc order by supervisorname ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultSupervisor'] = $Dist_result -> result_array();
		
		if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){
			$wc .= " AND is_temp_saved = '0'";
		}
		
		$query = "select *, supervisorname(supervisorcode) as supervisorname,is_temp_saved, facilitytype(facode) as facilitytype, 'techniciancode', 'catch_area_pop','status', facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil from med_techniciandb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
        return $data;
	}
	//================ Medical Technician Listing Function Ends Here ======================================//
	//================ Function to Show Page for Adding New Medical Technician Record Starts Here =========//
	public function med_technician_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage HF Incharge', '/Medical-TechnicianList');
		$this->breadcrumbs->push('Add New HF Incahrge', '/Medical-Technician/Add');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		$query="select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();		

		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac']= $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh']= $resultTeh -> result_array();		

		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();	

		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorname ASC";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor']= $resultSupervisor -> result_array();
		
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

	
		return $data;
	}
	//================ Function to Show Page for Saving New Medical Technician Record Ends Here =================//
	//================ Function for Saving New or Existing Medical Technician Record Starts Here ================//
	public function med_technician_save($technicianData,$technicianCode,$technicianCodeNewData){
		/* if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$technicianData,array('techniciancode'=>$technicianCode)); */
			
			    /* Post Type FOr Posting  */
		$temp=$technicianCodeNewData['post_type'];
		//echo "<pre>"; print_r($technicianCodeNewData);exit;
		 $doj=$technicianData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$technicianCodeNewData['new_facode'];
		$tehcode=$technicianCodeNewData['new_tcode'];
		$unccode=$technicianCodeNewData['new_uncode'];
		$tcode=$technicianData['techniciancode'];
		$status=$technicianData['status'];
		//uset data
		  unset($technicianData['post_type']);	
		   unset($technicianData['date_joining']);	
		  unset($technicianData['newfacode']);	
         unset($technicianData['newuncode']);	
        unset($technicianData['newtcode']);	
		
		$previous_table =$technicianData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($technicianData['status']=='Active')
			 {
				$technicianData['status']="Active"; 
				$technicianData['date_joining']=$doj;	
			 }
			 if($technicianData['status']=='post')
			 {
				$technicianData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('med_techniciandb',$technicianData,array('techniciancode'=>$technicianCode));
			 if($technicianData['status']=='Transfered')
			{
				$technicianData['previouse_code']=$technicianCode;
				$technicianData['techniciancode']=$technicianCodeNewData['new_lhwcode'];
				$technicianData['distcode']=$technicianCodeNewData['new_distcode'];
				$technicianData['uncode']=$technicianCodeNewData['new_uncode'];
				$technicianData['facode']=$technicianCodeNewData['new_facode'];
				$technicianData['tcode']=$technicianCodeNewData['new_tcode'];
				$technicianData['status']='Active';
				print_r($technicianData);exit;
				$result = $this -> Common_model -> insert_record('med_techniciandb', $technicianData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $technicianData['previous_code']=$technicianCode;
         $technicianData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
			  //unset these values bcx these are for med_techniciandb
                unset($technicianData['technicianname']);
			    unset($technicianData['status']);
				  unset($technicianData['techniciancode']);
				    unset($technicianData['husbandname']);
					  unset($technicianData['reason']);
					    unset($technicianData['facode']);
		$technicianData['status']='Active';
		$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						} 
					
						$technicianData['supervisorcode']=$supervisorcode;
						$technicianData['tcode']=$tehcode;
						$technicianData['previous_table']="med_techniciandb";
					//print_r($technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
			$location = base_url(). "HF-Incharge/List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for med_techniciandb
              unset($technicianData['technicianname']);
			    unset($technicianData['status']);
				  unset($technicianData['techniciancode']);
				    unset($technicianData['husbandname']);
					  unset($technicianData['reason']);
					    unset($technicianData['facode']);
					    unset($technicianData['place_of_posting']);
					    unset($technicianData['area_type']);
					  unset($technicianData['postalcode']);
			$technicianData['status']='Active';
			$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						}
					 $technicianData['supervisorcode']=$supervisorcode;
                     $technicianData['previous_table']="med_techniciandb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
					//print_r($result);exit();
			$location = base_url(). "HF-Incharge/List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $technicianData['supervisorname']=$technicianData['technicianname'];
			  $technicianData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for med_techniciandb
              unset($technicianData['technicianname']);
			    unset($technicianData['status']);
				  unset($technicianData['techniciancode']);
				    unset($technicianData['husbandname']);
					  unset($technicianData['reason']);
					    unset($technicianData['facode']);
			$technicianData['status']='Active';
			$technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$technicianData['distcode']."0001";
						}
						$technicianData['supervisorcode']=$supervisorcode;
                      //print_r($technicianData);exit();
					//insert into supervisordb
					$technicianData['tcode']=$tehcode;
					$technicianData['previous_table']="med_techniciandb";
				$technicianData['facode']=$faccode;
				$technicianData['uncode']=$unccode;
				$technicianData['previous_table']="med_techniciandb";
				//print_r($technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $technicianData);
			$location = base_url(). "HF-Incharge/List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $technicianData['skname']=$technicianData['technicianname'];
			  //unset these values bcx these are for med_techniciandb
              unset($technicianData['technicianname']);
			    unset($technicianData['status']);
				  unset($technicianData['techniciancode']);
				    unset($technicianData['husbandname']);
					  unset($technicianData['reason']);
					   unset($technicianData['basic_training_start_date']);
					   unset($technicianData['supervisorcode']);
					   unset($technicianData['tcode']);
					   unset($technicianData['cold_chain_training_end_date']);
					   unset($technicianData['vlmis_training_end_date']);
					   unset($technicianData['tcode']);
					   unset($technicianData['vlmis_training_start_date']);
					   unset($technicianData['survilance_training_end_date']);
					   unset($technicianData['tcode']);
					   unset($technicianData['cold_chain_training_start_date']);
					    unset($technicianData['survilance_training_start_date']);
						 unset($technicianData['basic_training_end_date']);
						  unset($technicianData['routine_epi_start_date']);
					unset($technicianData['routine_epi_end_date']);
					   unset($technicianData['catch_area_pop']);
						 unset($technicianData['catch_area_name']);
						  unset($technicianData['areatype']);
						  $technicianData['date_joining']=$doj;
		$technicianData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$technicianData['distcode']."0001";
						}
						$technicianData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $technicianData);
				$location = base_url(). "HF-Incharge/List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$technicianData['dsoname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$technicianData['distcode']."0001";
				}
					$technicianData['dsocode']=$dsocode;
					//print_r($technicianData);exit();
					//insert into dsodb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="med_techniciandb";
					$result = $this -> Common_model -> insert_record('dsodb', $technicianData);
					$location = base_url(). "HF-Incharge/List";
					$message="Record Posted As District surveillance oficer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='codb')
				{
					$technicianData['coname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$technicianData['distcode']."0001";
				}
					$technicianData['cocode']=$cocode;
					//print_r($technicianData);exit();
					//insert into codb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="med_techniciandb";
					$result = $this -> Common_model -> insert_record('codb', $technicianData);
					$location = base_url(). "HF-Incharge/List";
					$message="Record Posted As District surveillance oficer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 				 
					
// Start - data send to Computer Opera
					 
			else if($temp=='mfpdb')
				{
					$technicianData['mfpname']=$technicianData['technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($technicianData['technicianname']);
					unset($technicianData['status']);
					unset($technicianData['mfpcode']);
					unset($technicianData['husbandname']);
					unset($technicianData['reason']);
					unset($technicianData['facode']);
					unset($technicianData['date_resigned']);
					unset($technicianData['current_status']);
					unset($technicianData['techniciancode']);
					unset($technicianData['supervisorcode']);
					unset($technicianData['catch_area_pop']);
					unset($technicianData['catch_area_name']);
					unset($technicianData['areatype']);
					$technicianData['status']='Active';
					$technicianData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$technicianData['distcode']."0001";
				}
					$technicianData['mfpcode']=$mfpcode;
					//print_r($technicianData);exit();
					//insert into mfpdb
					//$technicianData['tcode']=$tehcode;
					//$technicianData['facode']=$faccode;
					//$technicianData['uncode']=$unccode;
					$technicianData['previous_table']="med_techniciandb";
					$result = $this -> Common_model -> insert_record('mfpdb', $technicianData);
					$location = base_url(). "HF-Incharge/List";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 				 
					 
				 //DataEntry Operator
				  else
				     {
						 /* 
						
						 //technician name to deoname (change columnname)
						 $technicianData['deoname']=$technicianData['technicianname'];
						 //previous_code
						 			 $technicianData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for med_techniciandb
              unset($technicianData['technicianname']);
			    unset($technicianData['status']);
				//unset($technicianData['newfacode']);
		//unset($technicianData['newtcode']);
		//unset($technicianData['newuncode']);
				//  unset($technicianData['techniciancode']);
				    unset($technicianData['husbandname']);
					  unset($technicianData['reason']);
					    unset($technicianData['techniciancode']);
					   unset($technicianData['basic_training_start_date']);
					   unset($technicianData['supervisorcode']);
					   unset($technicianData['tcode']);
					   unset($technicianData['cold_chain_training_end_date']);
					   unset($technicianData['vlmis_training_end_date']);
					   unset($technicianData['tcode']);
					   unset($technicianData['vlmis_training_start_date']);
					   unset($technicianData['survilance_training_end_date']);
					   unset($technicianData['tcode']);
					   unset($technicianData['cold_chain_training_start_date']);
					    unset($technicianData['survilance_training_start_date']);
						 unset($technicianData['basic_training_end_date']);
						  unset($technicianData['routine_epi_start_date']);
					unset($technicianData['routine_epi_end_date']);
					   unset($technicianData['catch_area_pop']);
						 unset($technicianData['catch_area_name']);
						  unset($technicianData['areatype']);
						$technicianData['status']='Active';
						$technicianData['date_joining']=$doj;
						$technicianData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$technicianData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$technicianData['distcode']."0001";
						}
						$technicianData['deocode']=$deocode;
//print_r($technicianData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $technicianData);
				     $location = base_url(). "HF-Incharge/List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				     */ 
					 }
					 
			}
			
				if($status=='Post Back')
				{
				  if($temp=='skdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('skdb',$dsofficer,array('skcode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Store-Keeper Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('techniciandb',$dsofficer,array('techniciancode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Epi Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_techniciandb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$dsofficer,array('cc_techniciancode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Cold Chain Technician Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "HF-Incharge/List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
							}
					/*For EPI Computer operator */
		/* 	if($temp=='codb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('codb',$dsofficer,array('cocode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Computer Operator Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				}
					/*For EPI mfpdb *
			else if($temp=='mfpdb')
				{
					$dsofficer=array('status'=>'Active');	
					//replace status of epitech to active from tempost
					$updateQuery = $this -> Common_model -> update_record('mfpdb',$dsofficer,array('mfpcode'=>$dstcode));
					//print_r($$temp);exit;
					//print_r($updateQuery);exit;
					//delete temporary post from supervisordb
					/* $this->db->where('supervisorcode',$supervisorCode);
					$this->db->delete('supervisordb'); *
					$location = base_url(). "DSOList";
					$message="Record posted back to Measles Focal Person Successfully!";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
					exit();
				} */
		
			
			if($this -> db -> affected_rows() > 0){
				createTransactionLog("Medical-Technician-DB", "Medical Technician Updated ".$technicianCode);
				$location = base_url(). "System_setup/med_technician_view/".$technicianCode;
				$message="Record Updated for HF Incharge with Code ".$technicianCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Medical-Technician-DB", "Medical Technician Updated ".$technicianCode);
				$location = base_url(). "System_setup/med_technician_list";
				$message="Record Updated for Tech with Code ".$technicianCode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
			//$location = base_url(). "System_setup/technician_view/".$technicianCode;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		}
		else{
			$checkquery = "select count(*) as cnt from med_techniciandb where techniciancode='$technicianCode'";
		    $checkresult= $this -> db -> query ($checkquery);
		    $checkrow= $checkresult -> row_array();
		    $recexist=(int)$checkrow['cnt'];
		    if($recexist==1){
		        $script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("HF Incharge Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();
			}
			$result = $this -> Common_model -> insert_record('med_techniciandb', $technicianData);
			if($result != 0){
				createTransactionLog("Medical-Technician-DB", "Medical Technician Added ".$technicianCode);
				$location = base_url(). "System_setup/med_technician_list";
				$message="Record Saved for New HF Incharge Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	//================ Function for Saving New or Existing Medical Technician Record Starts Here ================//
	//================ Function for Viewing Existing Technician Record Starts Here ======================//
	public function med_technician_view($techniciancode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage HF Incahrge', '/Medical-TechnicianList');
		$this->breadcrumbs->push('HF Incharge View', '/System_setup/med_technician_view');
		///////////////////////////////////////////////////////////////////
		$district=$this -> session -> District;
		//$query="select *, supervisorname(supervisorcode) as supervisorname, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil  from techniciandb where techniciancode = '$techniciancode' ";
		$query="select med_techniciandb.* ,supervisorname(med_techniciandb.supervisorcode) as supervisorname, facilityname(med_techniciandb.facode) as facilityname, districtname(med_techniciandb.distcode), tehsilname(med_techniciandb.tcode), coalesce(unname(med_techniciandb.uncode),'') as unioncouncil, bankinfo.bankcode as bcode,bankinfo.bankname as bank from med_techniciandb  left join bankinfo  on  med_techniciandb.bid= bankinfo.bankid where med_techniciandb.techniciancode='$techniciancode'"; 

		$result= $this -> db -> query ($query);
		$data['techniciandata']= $result -> row_array();
		return $data;
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing medical technician Record Starts Here =============//
	public function med_technician_edit($techniciancode) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage HF Incharge', '/Medical-TechnicianList');
		$this->breadcrumbs->push('Update HF Incharge', '/System_setup/med_technician_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select * , facilityname(facode) as facilityname from med_techniciandb where techniciancode = '$techniciancode' ";
		$result=$this -> db -> query ($query);
		$data['techniciandata']= $result -> row_array();
		
		$query="select distcode, district FROM districts WHERE distcode='$district' order by distcode";
		$result=$this -> db -> query ($query);
		$data['result'] = $result -> result_array();		

		$query="Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by facode";
		$resultFac=$this -> db -> query ($query);
		$data['resultFac'] = $resultFac -> result_array();
		
		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tcode";
		$resultTeh=$this -> db -> query ($query);
		$data['resultTeh'] = $resultTeh -> result_array();
		
		$query="Select uncode, un_name from unioncouncil where distcode='$district' order by uncode";
		$resultUnC=$this -> db -> query ($query);
		$data['resultUnC']= $resultUnC -> result_array();
		
		$query="select supervisorcode, supervisorname FROM supervisordb WHERE distcode='$district' order by supervisorcode";
		$resultSupervisor=$this -> db -> query ($query);
		$data['resultSupervisor'] = $resultSupervisor -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		//echo '<pre>';print_r($data);exit;		
		return $data;
	}
	public function cc_mechanic_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/cc_mechanic_list');
		$this->breadcrumbs->push('Add New Cold Chain Mechanic', '/System_setup/cc_mechanic_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;
	}
	public function cc_mechanic_save($ccmData,$ccm_code,$cc_mechanicNewData){
		//print_r($ccmData);exit;
		/* if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$ccmData,array('ccm_code'=>$ccm_code)); */
			
			/* Post Type FOr Posting  */
		$temp=$cc_mechanicNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$ccmData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$cc_mechanicNewData['new_facode'];
		$tehcode=$cc_mechanicNewData['new_tcode'];
		$unccode=$cc_mechanicNewData['new_uncode'];
		$tcode=$ccmData['ccm_code'];
		$status=$ccmData['status'];
		//uset data
		  unset($ccmData['post_type']);	
		   unset($ccmData['date_joining']);	
		  unset($ccmData['newfacode']);	
         unset($ccmData['newuncode']);	
        unset($ccmData['newtcode']);	
		
		$previous_table = $ccmData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($ccmData['status']=='Active')
			 {
				$ccmData['status']="Active"; 
				$ccmData['date_joining']=$doj;	
			 }
			 if($ccmData['status']=='post')
			 {
				$ccmData['status']="Posted";  
			 }
			
			$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$ccmData,array('ccm_code'=>$ccm_code));
			 if($ccmData['status']=='Transfered')
			{
				$ccmData['previouse_code']=$ccm_code;
				$ccmData['ccm_code']=$cc_mechanicNewData['new_lhwcode'];
				$ccmData['distcode']=$cc_mechanicNewData['new_distcode'];
				$ccmData['uncode']=$cc_mechanicNewData['new_uncode'];
				$ccmData['facode']=$cc_mechanicNewData['new_facode'];
				$ccmData['tcode']=$cc_mechanicNewData['new_tcode'];
				$ccmData['status']='Active';
				print_r($ccmData);exit;
				$result = $this -> Common_model -> insert_record('cc_mechanic', $ccmData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $ccmData['previous_code']=$ccm_code;
         $ccmData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $ccmData['supervisorname']=$ccmData['ccm_name'];
			  $ccmData['supervisor_type']=$temp;
			  //unset these values bcx these are for cc_mechanic
                unset($ccmData['ccm_name']);
			    unset($ccmData['status']);
				  unset($ccmData['ccm_code']);
				    unset($ccmData['husbandname']);
					  unset($ccmData['reason']);
					    unset($ccmData['facode']);
					    unset($ccmData['place_of_posting']);
					    unset($ccmData['area_type']);
					    unset($ccmData['postalcode']);
		$ccmData['status']='Active';
		$ccmData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccmData['distcode']."0001";
						} 
					
						$ccmData['supervisorcode']=$supervisorcode;
						$ccmData['tcode']=$tehcode;
						$ccmData['previous_table']="cc_mechanic";
					//print_r($ccmData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccmData);
			$location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $ccmData['supervisorname']=$ccmData['ccm_name'];
			  $ccmData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for cc_mechanic
              unset($ccmData['ccm_name']);
			    unset($ccmData['status']);
				  unset($ccmData['ccm_code']);
				    unset($ccmData['husbandname']);
					  unset($ccmData['reason']);
					    unset($ccmData['facode']);
					    unset($ccmData['place_of_posting']);
					    unset($ccmData['area_type']);
					  unset($ccmData['postalcode']);
			$ccmData['status']='Active';
			$ccmData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccmData['distcode']."0001";
						}
					 $ccmData['supervisorcode']=$supervisorcode;
                     $ccmData['previous_table']="cc_mechanic";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $ccmData);
					//print_r($result);exit();
			$location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $ccmData['supervisorname']=$ccmData['ccm_name'];
			  $ccmData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for cc_mechanic
              unset($ccmData['ccm_name']);
			    unset($ccmData['status']);
				  unset($ccmData['ccm_code']);
				    unset($ccmData['husbandname']);
					  unset($ccmData['reason']);
					    unset($ccmData['facode']);
					    unset($ccmData['place_of_posting']);
					    unset($ccmData['area_type']);
					    unset($ccmData['postalcode']);
			$ccmData['status']='Active';
			$ccmData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccmData['distcode']."0001";
						}
						$ccmData['supervisorcode']=$supervisorcode;
                      //print_r($ccmData);exit();
					//insert into supervisordb
					$ccmData['tcode']=$tehcode;
					$ccmData['previous_table']="cc_mechanic";
				$ccmData['facode']=$faccode;
				$ccmData['uncode']=$unccode;
				$ccmData['previous_table']="cc_mechanic";
				//print_r($ccmData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccmData);
			$location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $ccmData['skname']=$ccmData['ccm_name'];
			  //unset these values bcx these are for cc_mechanic
              unset($ccmData['ccm_name']);
			    unset($ccmData['status']);
				  unset($ccmData['ccm_code']);
				    unset($ccmData['husbandname']);
					  unset($ccmData['reason']);
					   unset($ccmData['basic_training_start_date']);
					   unset($ccmData['supervisorcode']);
					   unset($ccmData['tcode']);
					   unset($ccmData['cold_chain_training_end_date']);
					   unset($ccmData['vlmis_training_end_date']);
					   unset($ccmData['tcode']);
					   unset($ccmData['vlmis_training_start_date']);
					   unset($ccmData['survilance_training_end_date']);
					   unset($ccmData['tcode']);
					   unset($ccmData['cold_chain_training_start_date']);
					    unset($ccmData['survilance_training_start_date']);
						 unset($ccmData['basic_training_end_date']);
						  unset($ccmData['routine_epi_start_date']);
					unset($ccmData['routine_epi_end_date']);
					   unset($ccmData['catch_area_pop']);
						 unset($ccmData['catch_area_name']);
						  unset($ccmData['areatype']);
						  $ccmData['date_joining']=$doj;
		$ccmData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$ccmData['distcode']."0001";
						}
						$ccmData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $ccmData);
				$location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
				 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$ccmData['dsoname']=$ccmData['ccm_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['mfpcode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['skcode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$ccmData['distcode']."0001";
				}
					$ccmData['dsocode']=$dsocode;
					//print_r($ccmData);exit();
					//insert into dsodb
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('dsodb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As District Surveillance Officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
								 
// Start - data send to Computer Operator
					 
			else if($temp=='codb')
				{
					$ccmData['coname']=$ccmData['ccm_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['mfpcode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['skcode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$ccmData['distcode']."0001";
				}
					$ccmData['cocode']=$cocode;
					//print_r($ccmData);exit();
					//insert into codb
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('codb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
								 
// Start - data send to Measles Focal Person 
					 
			else if($temp=='mfpdb')
				{
					$ccmData['mfpname']=$ccmData['ccm_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['mfpcode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['skcode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$ccmData['distcode']."0001";
				}
					$ccmData['mfpcode']=$mfpcode;
					//print_r($ccmData);exit();
					//insert into mfpdb
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('mfpdb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to HF Incharges 
					 
			else if($temp=='med_techniciandb')
				{
					$ccmData['technicianname']=$ccmData['ccm_name'];
					//unset these values bcx these are for med_techniciandb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['skcode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$ccmData['distcode']."0001";
				}
					$ccmData['techniciancode']=$techniciancode;
					//print_r($ccmData);exit();
					//insert into med_techniciandb
					//$ccmData['tcode']=$tehcode;
					$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As HF Incharges Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to HF Incharges 
					 
			else if($temp=='skdb')
				{
					$ccmData['skname']=$ccmData['ccm_name'];
					//unset these values bcx these are for skdb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['skcode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['skcode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$ccmData['distcode']."0001";
				}
					$ccmData['skcode']=$skcode;
					//print_r($ccmData);exit();
					//insert into skdb
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('skdb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As HF Incharges Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to EpiTechnician
					 
			else if($temp=='techniciandb')
				{
					$ccmData['technicianname']=$ccmData['ccm_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['techniciancode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$ccmData['distcode']."0001";
				}
					$ccmData['techniciancode']=$techniciancode;
					//print_r($ccmData);exit();
					//insert into techniciandb
					//$ccmData['tcode']=$tehcode;
					$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('techniciandb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As EpiTechnician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Cold Chain Technician 
					 
			else if($temp=='cc_techniciandb')
				{
					$ccmData['cc_technicianname']=$ccmData['ccm_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['cc_techniciancode']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest cc_techniciancode from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('cc_techniciancode');
					$this->db->order_by('cc_techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('cc_techniciandb');
					$cc_techniciancode=0;
					foreach($query->result() as $row){
					$cc_techniciancode=$row->cc_techniciancode;
				}
					//check code exits
			if($cc_techniciancode!=null && $cc_techniciancode!=0)
				{
					//increment the  cc_techniciancode
					$cc_techniciancode=$cc_techniciancode+1;
				}
			else
				{
					//fisrt code
					$cc_techniciancode=$ccmData['distcode']."0001";
				}
					$ccmData['cc_techniciancode']=$cc_techniciancode;
					//print_r($ccmData);exit();
					//insert into cc_techniciandb
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('cc_techniciandb', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As Cold Chain Technician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 

// Start - data send to Cold Chain Operator
					 
			else if($temp=='cco_db')
				{
					$ccmData['cco_name']=$ccmData['ccm_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['cco_code']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['cco_code']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['cco_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest cco_code from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('cco_code');
					$this->db->order_by('cco_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('cco_db');
					$cco_code=0;
					foreach($query->result() as $row){
					$cco_code=$row->cco_code;
				}
					//check code exits
			if($cco_code!=null && $cco_code!=0)
				{
					//increment the  cco_code
					$cco_code=$cco_code+1;
				}
			else
				{
					//fisrt code
					$cco_code=$ccmData['distcode']."0001";
				}
					$ccmData['cco_code']=$cco_code;
					//print_r($ccmData);exit();
					//insert into cco_db
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('cco_db', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As Cold Chain Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
					
// Start - data send to Generator Operator 
					 
			else if($temp=='go_db')
				{
					$ccmData['go_name']=$ccmData['ccm_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccmData['ccm_name']);
					unset($ccmData['status']);
					unset($ccmData['go_code']);
					unset($ccmData['husbandname']);
					unset($ccmData['reason']);
					unset($ccmData['facode']);
					unset($ccmData['date_resigned']);
					unset($ccmData['current_status']);
					unset($ccmData['go_code']);
					unset($ccmData['supervisorcode']);
					unset($ccmData['go_code']);
					unset($ccmData['place_of_posting']);
					unset($ccmData['area_type']);
					unset($ccmData['postalcode']);
					unset($ccmData['go_code']);
					unset($ccmData['ccm_code']);
					$ccmData['status']='Active';
					$ccmData['date_joining']=$doj;
					//getting latest go_code from db 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('go_code');
					$this->db->order_by('go_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('go_db');
					$go_code=0;
					foreach($query->result() as $row){
					$go_code=$row->go_code;
				}
					//check code exits
			if($go_code!=null && $go_code!=0)
				{
					//increment the  go_code
					$go_code=$go_code+1;
				}
			else
				{
					//fisrt code
					$go_code=$ccmData['distcode']."0001";
				}
					$ccmData['go_code']=$go_code;
					//print_r($ccmData);exit();
					//insert into go_db
					//$ccmData['tcode']=$tehcode;
					//$ccmData['facode']=$faccode;
					//$ccmData['uncode']=$unccode;
					$ccmData['previous_table']="cc_mechanic";
					$result = $this -> Common_model -> insert_record('go_db', $ccmData);
					$location = base_url(). "Cold-Chain-Mechanic/List";
					$message="Record Posted As Generator Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
					 
				 //DataEntry Operator
				  else
				     {
						/*  //technician name to deoname (change columnname)
						 $ccmData['deoname']=$ccmData['ccm_name'];
						 //previous_code
						 			 $ccmData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for cc_mechanic
              unset($ccmData['ccm_name']);
			    unset($ccmData['status']);
				//unset($ccmData['newfacode']);
		//unset($ccmData['newtcode']);
		//unset($ccmData['newuncode']);
				//  unset($ccmData['ccm_code']);
				    unset($ccmData['husbandname']);
					  unset($ccmData['reason']);
					    unset($ccmData['ccm_code']);
					   unset($ccmData['basic_training_start_date']);
					   unset($ccmData['supervisorcode']);
					   unset($ccmData['tcode']);
					   unset($ccmData['cold_chain_training_end_date']);
					   unset($ccmData['vlmis_training_end_date']);
					   unset($ccmData['tcode']);
					   unset($ccmData['vlmis_training_start_date']);
					   unset($ccmData['survilance_training_end_date']);
					   unset($ccmData['tcode']);
					   unset($ccmData['cold_chain_training_start_date']);
					    unset($ccmData['survilance_training_start_date']);
						 unset($ccmData['basic_training_end_date']);
						  unset($ccmData['routine_epi_start_date']);
					unset($ccmData['routine_epi_end_date']);
					   unset($ccmData['catch_area_pop']);
						 unset($ccmData['catch_area_name']);
						  unset($ccmData['areatype']);
						$ccmData['status']='Active';
						$ccmData['date_joining']=$doj;
						$ccmData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$ccmData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$ccmData['distcode']."0001";
						}
						$ccmData['deocode']=$deocode;
//print_r($ccmData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $ccmData);
				     $location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			
			if($status=='Post Back')
				{
				  if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
						//	print_r($updateQuery);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Mechanic/List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
			
			
			
			
			if($this -> db -> affected_rows() > 0){
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Mechanic/View/".$ccm_code;
				$message="Record Updated for Cold Chain Mechanic with Code ".$ccm_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Mechanic/List";
				$message="Record Updated for Cold Chain Mechanic with Code ".$ccm_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from cc_mechanic	where ccm_code='$ccm_code'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Mechanic Code already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('cc_mechanic', $ccmData);
			if($result != 0){
				//createTransactionLog("Cold Chain Mechanic", "Cold Chain Mechanic Added ".$ccm_code);
				$location = base_url()."Cold-Chain-Mechanic/List";
				$message="Record Saved for New Cold Chain Mechanic Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	public function cc_mechanic_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Computer Operator', '/System_setup/cc_mechanic_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cc_mechanic where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	public function cc_mechanic_view($ccm_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/cc_mechanic_list');
		$this->breadcrumbs->push('Cold Chain Mechanic View', '/System_setup/cc_mechanic_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select cc_mechanic.* , facilityname(cc_mechanic.facode) as facilityname, districtname(cc_mechanic.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from cc_mechanic  left join bankinfo  on  cc_mechanic.bid= bankinfo.bankid where cc_mechanic.ccm_code='$ccm_code'"; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	public function cc_mechanic_edit($ccm_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Mechanic', '/System_setup/cc_mechanic_list');
		$this->breadcrumbs->push('Update Cold Chain Mechanic', '/System_setup/cc_mechanic_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(cc_mechanic.distcode), facilityname(facode) as facilityname from cc_mechanic where ccm_code = '$ccm_code' ";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	public function go_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Generator Operator', '/System_setup/go_list');
		$this->breadcrumbs->push('Add New Generator Operator', '/System_setup/go_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;
		
	}
	public function go_save($goData,$go_code,$go_NewData){
	/* 	print_r($goData); echo '<br><br><br><br><br>';
		print_r($go_code); echo '<br><br><br><br><br>';
		print_r($go_NewData); echo '<br><br><br><br><br>';
		echo 'okyy';
exit;	 */	
		// new codding
		     /* Post Type FOr Posting  */
		$temp=$go_NewData['post_type'];
		//print_r($temp);exit;
		 $doj=$goData['date_joining'];
		 /* FOR DSV TSV FSV  */
		$faccode=$go_NewData['new_facode'];
		$tehcode=$go_NewData['new_tcode'];
		$unccode=$go_NewData['new_uncode'];
		$tcode=$goData['go_code'];
		$status=$goData['status'];
		//uset data
		  unset($goData['post_type']);	
		   unset($goData['date_joining']);	
		  unset($goData['newfacode']);	
         unset($goData['newuncode']);	
        unset($goData['newtcode']);	
	
	$previous_table = $goData['previous_code'];

		if($this -> input -> post ('edit')){
                
			 if($goData['status']=='Active')
			 {
				$goData['status']="Active"; 
				$goData['date_joining']=$doj;	
			 }
			 if($goData['status']=='post')
			 {
				$goData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('go_db',$goData,array('go_code'=>$go_code));
			
			 if($goData['status']=='Transfered')
			{
				$goData['previouse_code']=$go_code;
				$goData['go_code']=$go_NewData['new_lhwcode'];
				$goData['distcode']=$go_NewData['new_distcode'];
				$goData['uncode']=$go_NewData['new_uncode'];
				$goData['facode']=$go_NewData['new_facode'];
				$goData['tcode']=$go_NewData['new_tcode'];
				$goData['status']='Active';
				print_r($goData);exit;
				$result = $this -> Common_model -> insert_record('go_db', $goData);
			}	
    //



//


	
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $goData['previous_code']=$go_code;
         $goData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $goData['supervisorname']=$goData['go_name'];
			  $goData['supervisor_type']=$temp;
			  //unset these values bcx these are for techniciandb
                unset($goData['go_name']);
			    unset($goData['status']);
				  unset($goData['go_code']);
				    unset($goData['husbandname']);
					  unset($goData['reason']);
					    unset($goData['facode']);
					    unset($goData['place_of_posting']);
					    unset($goData['area_type']);
					    unset($goData['postalcode']);
		$goData['status']='Active';
		$goData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$goData['distcode']."0001";
						} 
					
						$goData['supervisorcode']=$supervisorcode;
						$goData['tcode']=$tehcode;
						$goData['previous_table']="go_db";
					//print_r($goData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $goData);
			$location = base_url(). "Generator-Operator/List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			
			
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $goData['supervisorname']=$goData['go_name'];
			  $goData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for techniciandb
              unset($goData['go_name']);
			    unset($goData['status']);
				  unset($goData['go_code']);
				    unset($goData['husbandname']);
					  unset($goData['reason']);
					    unset($goData['facode']);
					    unset($goData['place_of_posting']);
					    unset($goData['area_type']);
					    unset($goData['postalcode']);
			$goData['status']='Active';
			$goData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$goData['distcode']."0001";
						}
					 $goData['supervisorcode']=$supervisorcode;
                     $goData['previous_table']="go_db";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $goData);
					//print_r($result);exit();
			$location = base_url(). "Generator-Operator/List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $goData['supervisorname']=$goData['go_name'];
			  $goData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for techniciandb
              unset($goData['go_name']);
			    unset($goData['status']);
				  unset($goData['go_code']);
				    unset($goData['husbandname']);
					  unset($goData['reason']);
					    unset($goData['facode']);
					    unset($goData['place_of_posting']);
					    unset($goData['area_type']);
					    unset($goData['postalcode']);
			$goData['status']='Active';
			$goData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$goData['distcode']."0001";
						}
						$goData['supervisorcode']=$supervisorcode;
                      //print_r($goData);exit();
					//insert into supervisordb
					$goData['tcode']=$tehcode;
					$goData['previous_table']="go_db";
				$goData['facode']=$faccode;
				$goData['uncode']=$unccode;
				$goData['previous_table']="go_db";
				//print_r($goData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $goData);
			$location = base_url(). "Generator-Operator/List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $goData['skname']=$goData['go_name'];
			  //unset these values bcx these are for techniciandb
              unset($goData['go_name']);
			    unset($goData['status']);
				  unset($goData['go_code']);
				    unset($goData['husbandname']);
					  unset($goData['reason']);
					   unset($goData['basic_training_start_date']);
					   unset($goData['supervisorcode']);
					   unset($goData['tcode']);
					   unset($goData['cold_chain_training_end_date']);
					   unset($goData['vlmis_training_end_date']);
					   unset($goData['tcode']);
					   unset($goData['vlmis_training_start_date']);
					   unset($goData['survilance_training_end_date']);
					   unset($goData['tcode']);
					   unset($goData['cold_chain_training_start_date']);
					    unset($goData['survilance_training_start_date']);
						 unset($goData['basic_training_end_date']);
						  unset($goData['routine_epi_start_date']);
					unset($goData['routine_epi_end_date']);
					   unset($goData['catch_area_pop']);
						 unset($goData['catch_area_name']);
						  unset($goData['areatype']);
						  $goData['date_joining']=$doj;
		$goData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$goData['distcode']."0001";
						}
						$goData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $goData);
				$location = base_url(). "Generator-Operator/List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$goData['dsoname']=$goData['go_name'];
					//unset these values bcx these are for mfpdb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['mfpcode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['techniciancode']);
					unset($goData['supervisorcode']);
					unset($goData['skcode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$goData['distcode']."0001";
				}
					$goData['dsocode']=$dsocode;
					//print_r($goData);exit();
					//insert into dsodb
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('dsodb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As District Surveillance Officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Computer Operator
					 
			else if($temp=='codb')
				{
					$goData['coname']=$goData['go_name'];
					//unset these values bcx these are for mfpdb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['mfpcode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['techniciancode']);
					unset($goData['supervisorcode']);
					unset($goData['skcode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$goData['distcode']."0001";
				}
					$goData['cocode']=$cocode;
					//print_r($goData);exit();
					//insert into codb
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('codb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Measles Focal Person 
					 
			else if($temp=='mfpdb')
				{
					$goData['mfpname']=$goData['go_name'];
					//unset these values bcx these are for mfpdb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['mfpcode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['techniciancode']);
					unset($goData['supervisorcode']);
					unset($goData['skcode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$goData['distcode']."0001";
				}
					$goData['mfpcode']=$mfpcode;
					//print_r($goData);exit();
					//insert into mfpdb
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('mfpdb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to HF Incharge 
					 
			else if($temp=='med_techniciandb')
				{
					$goData['technicianname']=$goData['go_name'];
					//unset these values bcx these are for med_techniciandb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['techniciancode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['techniciancode']);
					unset($goData['supervisorcode']);
					unset($goData['skcode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$goData['distcode']."0001";
				}
					$goData['techniciancode']=$techniciancode;
					//print_r($goData);exit();
					//insert into med_techniciandb
					//$goData['tcode']=$tehcode;
					$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As HF Incharge Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to HF Incharge 
					 
			else if($temp=='skdb')
				{
					$goData['skname']=$goData['go_name'];
					//unset these values bcx these are for skdb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['skcode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['supervisorcode']);
					unset($goData['skcode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_skcode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$goData['distcode']."0001";
				}
					$goData['skcode']=$skcode;
					//print_r($goData);exit();
					//insert into skdb
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('skdb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As HF Incharge Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to EpiTechnician
					 
			else if($temp=='techniciandb')
				{
					$goData['technicianname']=$goData['go_name'];
					//unset these values bcx these are for techniciandb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['techniciancode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['supervisorcode']);
					unset($goData['techniciancode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$goData['distcode']."0001";
				}
					$goData['techniciancode']=$techniciancode;
					//print_r($goData);exit();
					//insert into techniciandb
					//$goData['tcode']=$tehcode;
					$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('techniciandb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As EpiTechnician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Cold Chain Technician
					 
			else if($temp=='cc_techniciandb')
				{
					$goData['cc_technicianname']=$goData['go_name'];
					//unset these values bcx these are for techniciandb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['cc_techniciancode']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['supervisorcode']);
					unset($goData['cc_techniciancode']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_cc_techniciancode']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest cc_techniciancode from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('cc_techniciancode');
					$this->db->order_by('cc_techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('cc_techniciandb');
					$cc_techniciancode=0;
					foreach($query->result() as $row){
					$cc_techniciancode=$row->cc_techniciancode;
				}
					//check code exits
			if($cc_techniciancode!=null && $cc_techniciancode!=0)
				{
					//increment the  cc_techniciancode
					$cc_techniciancode=$cc_techniciancode+1;
				}
			else
				{
					//fisrt code
					$cc_techniciancode=$goData['distcode']."0001";
				}
					$goData['cc_techniciancode']=$cc_techniciancode;
					//print_r($goData);exit();
					//insert into cc_techniciandb
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('cc_techniciandb', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As Cold Chain Technician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to Cold Chain Operator 
					 
			else if($temp=='cco_db')
				{
					$goData['cco_name']=$goData['go_name'];
					//unset these values bcx these are for techniciandb Table
					unset($goData['go_name']);
					unset($goData['status']);
					unset($goData['cco_code']);
					unset($goData['husbandname']);
					unset($goData['reason']);
					unset($goData['facode']);
					unset($goData['date_resigned']);
					unset($goData['current_status']);
					unset($goData['supervisorcode']);
					unset($goData['cco_code']);
					unset($goData['place_of_posting']);
					unset($goData['area_type']);
					unset($goData['postalcode']);
					unset($goData['cc_cco_code']);
					unset($goData['cco_code']);
					unset($goData['go_code']);
					$goData['status']='Active';
					$goData['date_joining']=$doj;
					//getting latest cco_code from db 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('cco_code');
					$this->db->order_by('cco_code','desc');
					$this->db->limit('1');
					$query=$this->db->get('cco_db');
					$cco_code=0;
					foreach($query->result() as $row){
					$cco_code=$row->cco_code;
				}
					//check code exits
			if($cco_code!=null && $cco_code!=0)
				{
					//increment the  cco_code
					$cco_code=$cco_code+1;
				}
			else
				{
					//fisrt code
					$cco_code=$goData['distcode']."0001";
				}
					$goData['cco_code']=$cco_code;
					//print_r($goData);exit();
					//insert into cco_db
					//$goData['tcode']=$tehcode;
					//$goData['facode']=$faccode;
					//$goData['uncode']=$unccode;
					$goData['previous_table']="go_db";
					$result = $this -> Common_model -> insert_record('cco_db', $goData);
					$location = base_url(). "Generator-Operator/List";
					$message="Record Posted As Cold Chain Operator  Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
				 //DataEntry Operator
				  else
				     {
						
						/*  //technician name to deoname (change columnname)
						 $goData['deoname']=$goData['go_name'];
						 //previous_code
						 			 $goData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for techniciandb
              unset($goData['go_name']);
			    unset($goData['status']);
				//unset($goData['newfacode']);
		//unset($goData['newtcode']);
		//unset($goData['newuncode']);
				//  unset($goData['go_code']);
				    unset($goData['husbandname']);
					  unset($goData['reason']);
					    unset($goData['go_code']);
					   unset($goData['basic_training_start_date']);
					   unset($goData['supervisorcode']);
					   unset($goData['tcode']);
					   unset($goData['cold_chain_training_end_date']);
					   unset($goData['vlmis_training_end_date']);
					   unset($goData['tcode']);
					   unset($goData['vlmis_training_start_date']);
					   unset($goData['survilance_training_end_date']);
					   unset($goData['tcode']);
					   unset($goData['cold_chain_training_start_date']);
					    unset($goData['survilance_training_start_date']);
						 unset($goData['basic_training_end_date']);
						  unset($goData['routine_epi_start_date']);
					unset($goData['routine_epi_end_date']);
					   unset($goData['catch_area_pop']);
						 unset($goData['catch_area_name']);
						  unset($goData['areatype']);
						$goData['status']='Active';
						$goData['date_joining']=$doj;
						$goData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$goData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$goData['distcode']."0001";
						}
						$goData['deocode']=$deocode;
//print_r($goData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $goData);
				     $location = base_url(). "Generator-Operator/List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			
			
			if($status=='Post Back')
				{
				  if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Generator-Operator/List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Generator-Operator/List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
			
				if($this -> db -> affected_rows() > 0){
				createTransactionLog("Technician-DB", "Technician Updated ".$go_code);
				$location = base_url(). "System_setup/Generator-Operator/View/".$go_code;
				$message="Record Updated for Tech with Code ".$go_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				createTransactionLog("Technician-DB", "Technician Updated ".$go_code);
				$location = base_url(). "System_setup/Generator-Operator/List";
				$message="Record Updated for Tech with Code ".$go_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
			//$location = base_url(). "System_setup/technician_view/".$go_code;
			//echo '<script language="javascript" type="text/javascript"> alert("Record Updated successfully....");	window.location="'.$location.'"</script>';
		}
	//edit old code	
		
	/* 	if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('go_db',$goData,array('go_code'=>$go_code));
			if($this -> db -> affected_rows() > 0){
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Generator-Operator/View/".$go_code;
				$message="Record Updated for Generator Operator with Code ".$go_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Generator-Operator/List";
				$message="Record Updated Generator Operator with Code ".$go_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		 */
		
		
		else{
			$checkquery = "select count(*) as cnt from go_db where go_code='$go_code'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Generator Operator already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			
			
			
		//// start codding
		
		
		
		
		//// end here
			
			
			
			
			
			
			
			$result = $this -> Common_model -> insert_record('go_db', $goData);
			if($result != 0){
				//createTransactionLog("Cold Chain Mechanic", "Cold Chain Mechanic Added ".$ccm_code);
				$location = base_url()."Generator-Operator/List";
				$message="Record Saved for New Generator-Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		exit();
	}
	public function go_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Generator Operator', '/System_setup/go_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from go_db where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	public function go_view($go_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Generator Operator', '/System_setup/go_list');
		$this->breadcrumbs->push('Generator Operator View', '/System_setup/go_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select go_db.* , facilityname(go_db.facode) as facilityname, districtname(go_db.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from go_db  left join bankinfo  on  go_db.bid= bankinfo.bankid where go_db.go_code='$go_code'"; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	public function go_edit($go_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Generator Operator', '/System_setup/go_list');
		$this->breadcrumbs->push('Update Generator Operator', '/System_setup/go_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(go_db.distcode), facilityname(facode) as facilityname from go_db where go_code = '$go_code' ";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	public function cco_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Operator', '/System_setup/cco_list');
		$this->breadcrumbs->push('Add New Cold Chain Operator', '/System_setup/cco_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;
		
	}
	public function cco_save($ccoData,$cco_code,$ccoNewData){
		//print_r($ccoData);exit;
		/* if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('cco_db',$ccoData,array('cco_code'=>$cco_code)); */
			
			        /* Post Type FOr Posting  */
		$temp=$ccoNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$ccoData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$ccoNewData['new_facode'];
		$tehcode=$ccoNewData['new_tcode'];
		$unccode=$ccoNewData['new_uncode'];
		$tcode=$ccoData['cco_code'];
		$status=$ccoData['status'];
		//uset data
		  unset($ccoData['post_type']);	
		   unset($ccoData['date_joining']);	
		  unset($ccoData['newfacode']);	
         unset($ccoData['newuncode']);	
        unset($ccoData['newtcode']);	
		
		$previous_table = $ccoData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($ccoData['status']=='Active')
			 {
				$ccoData['status']="Active"; 
				$ccoData['date_joining']=$doj;	
			 }
			 if($ccoData['status']=='post')
			 {
				$ccoData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('cco_db',$ccoData,array('cco_code'=>$cco_code));
			 if($ccoData['status']=='Transfered')
			{
				$ccoData['previouse_code']=$cco_code;
				$ccoData['cco_code']=$ccoNewData['new_lhwcode'];
				$ccoData['distcode']=$ccoNewData['new_distcode'];
				$ccoData['uncode']=$ccoNewData['new_uncode'];
				$ccoData['facode']=$ccoNewData['new_facode'];
				$ccoData['tcode']=$ccoNewData['new_tcode'];
				$ccoData['status']='Active';
				print_r($ccoData);exit;
				$result = $this -> Common_model -> insert_record('cco_db', $ccoData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $ccoData['previous_code']=$cco_code;
         $ccoData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $ccoData['supervisorname']=$ccoData['cco_name'];
			  $ccoData['supervisor_type']=$temp;
			  //unset these values bcx these are for cco_db
                unset($ccoData['cco_name']);
			    unset($ccoData['status']);
				  unset($ccoData['cco_code']);
				    unset($ccoData['husbandname']);
				    unset($ccoData['area_type']);
				    unset($ccoData['postalcode']);
				    unset($ccoData['place_of_posting']);
					  unset($ccoData['reason']);
					    unset($ccoData['facode']);
		$ccoData['status']='Active';
		$ccoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccoData['distcode']."0001";
						} 
					
						$ccoData['supervisorcode']=$supervisorcode;
						$ccoData['tcode']=$tehcode;
						$ccoData['previous_table']="cco_db";
					//print_r($ccoData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccoData);
			$location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $ccoData['supervisorname']=$ccoData['cco_name'];
			  $ccoData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for cco_db
              unset($ccoData['cco_name']);
			    unset($ccoData['status']);
				  unset($ccoData['cco_code']);
				    unset($ccoData['husbandname']);
					  unset($ccoData['reason']);
					    unset($ccoData['facode']);
					    unset($ccoData['place_of_posting']);
					    unset($ccoData['area_type']);
					  unset($ccoData['postalcode']);
			$ccoData['status']='Active';
			$ccoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccoData['distcode']."0001";
						}
					 $ccoData['supervisorcode']=$supervisorcode;
                     $ccoData['previous_table']="cco_db";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $ccoData);
					//print_r($result);exit();
			$location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $ccoData['supervisorname']=$ccoData['cco_name'];
			  $ccoData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for cco_db
              unset($ccoData['cco_name']);
			    unset($ccoData['status']);
				  unset($ccoData['cco_code']);
				    unset($ccoData['husbandname']);
					  unset($ccoData['reason']);
					    unset($ccoData['facode']);
					    unset($ccoData['place_of_posting']);
					    unset($ccoData['area_type']);
					    unset($ccoData['postalcode']);
			$ccoData['status']='Active';
			$ccoData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$ccoData['distcode']."0001";
						}
						$ccoData['supervisorcode']=$supervisorcode;
                      //print_r($ccoData);exit();
					//insert into supervisordb
					$ccoData['tcode']=$tehcode;
					$ccoData['previous_table']="cco_db";
				$ccoData['facode']=$faccode;
				$ccoData['uncode']=$unccode;
				$ccoData['previous_table']="cco_db";
				//print_r($ccoData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $ccoData);
			$location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $ccoData['skname']=$ccoData['cco_name'];
			  //unset these values bcx these are for cco_db
              unset($ccoData['cco_name']);
			    unset($ccoData['status']);
				  unset($ccoData['cco_code']);
				    unset($ccoData['husbandname']);
					  unset($ccoData['reason']);
					   unset($ccoData['basic_training_start_date']);
					   unset($ccoData['supervisorcode']);
					   unset($ccoData['tcode']);
					   unset($ccoData['cold_chain_training_end_date']);
					   unset($ccoData['vlmis_training_end_date']);
					   unset($ccoData['tcode']);
					   unset($ccoData['vlmis_training_start_date']);
					   unset($ccoData['survilance_training_end_date']);
					   unset($ccoData['tcode']);
					   unset($ccoData['cold_chain_training_start_date']);
					    unset($ccoData['survilance_training_start_date']);
						 unset($ccoData['basic_training_end_date']);
						  unset($ccoData['routine_epi_start_date']);
					unset($ccoData['routine_epi_end_date']);
					   unset($ccoData['catch_area_pop']);
						 unset($ccoData['catch_area_name']);
						  unset($ccoData['areatype']);
						  $ccoData['date_joining']=$doj;
		$ccoData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$ccoData['distcode']."0001";
						}
						$ccoData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $ccoData);
				$location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$ccoData['dsoname']=$ccoData['cco_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['mfpcode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['facode']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['skcode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$ccoData['distcode']."0001";
				}
					$ccoData['dsocode']=$dsocode;
					//print_r($ccoData);exit();
					//insert into dsodb
					//$ccoData['tcode']=$tehcode;
					//$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('dsodb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As District Surveillance Officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Computer Operator
					 
			else if($temp=='codb')
				{
					$ccoData['coname']=$ccoData['cco_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['mfpcode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['facode']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['skcode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$ccoData['distcode']."0001";
				}
					$ccoData['cocode']=$cocode;
					//print_r($ccoData);exit();
					//insert into codb
					//$ccoData['tcode']=$tehcode;
					//$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('codb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As District Surveillance Officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to Measles Focal Person 
			else if($temp=='mfpdb')
				{
					$ccoData['mfpname']=$ccoData['cco_name'];
					//unset these values bcx these are for mfpdb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['mfpcode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['facode']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['skcode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$ccoData['distcode']."0001";
				}
					$ccoData['mfpcode']=$mfpcode;
					//print_r($ccoData);exit();
					//insert into mfpdb
					//$ccoData['tcode']=$tehcode;
					//$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('mfpdb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}			 
// Start - data send to HF Incahrge
			else if($temp=='med_techniciandb')
				{
					$ccoData['technicianname']=$ccoData['cco_name'];
					//unset these values bcx these are for med_techniciandb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['skcode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$ccoData['distcode']."0001";
				}
					$ccoData['techniciancode']=$techniciancode;
					//print_r($ccoData);exit();
					//insert into med_techniciandb
					//$ccoData['tcode']=$tehcode;
					$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As HF Incahrge Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}			 
// Start - data send to Store-Keeper
			else if($temp=='skdb')
				{
					$ccoData['skname']=$ccoData['cco_name'];
					//unset these values bcx these are for skdb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['skcode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['facode']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['skcode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['skcode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_skcode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$ccoData['distcode']."0001";
				}
					$ccoData['skcode']=$skcode;
					//print_r($ccoData);exit();
					//insert into skdb
					//$ccoData['tcode']=$tehcode;
					//$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('skdb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As Store-Keeper Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}			 
// Start - data send to EpiTechnician
			else if($temp=='techniciandb')
				{
					$ccoData['technicianname']=$ccoData['cco_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['techniciancode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_skcode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$ccoData['distcode']."0001";
				}
					$ccoData['techniciancode']=$techniciancode;
					//print_r($ccoData);exit();
					//insert into techniciandb
					//$ccoData['tcode']=$tehcode;
					$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('techniciandb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As EpiTechnician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to  Cold Chain Technician 
			else if($temp=='cc_techniciandb')
				{
					$ccoData['cc_technicianname']=$ccoData['cco_name'];
					//unset these values bcx these are for techniciandb Table
					unset($ccoData['cco_name']);
					unset($ccoData['status']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['husbandname']);
					unset($ccoData['reason']);
					unset($ccoData['facode']);
					unset($ccoData['date_resigned']);
					unset($ccoData['current_status']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['supervisorcode']);
					unset($ccoData['cc_techniciancode']);
					unset($ccoData['place_of_posting']);
					unset($ccoData['area_type']);
					unset($ccoData['postalcode']);
					unset($ccoData['cc_skcode']);
					unset($ccoData['cco_code']);
					$ccoData['status']='Active';
					$ccoData['date_joining']=$doj;
					//getting latest cc_techniciancode from db 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('cc_techniciancode');
					$this->db->order_by('cc_techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('cc_techniciandb');
					$cc_techniciancode=0;
					foreach($query->result() as $row){
					$cc_techniciancode=$row->cc_techniciancode;
				}
					//check code exits
			if($cc_techniciancode!=null && $cc_techniciancode!=0)
				{
					//increment the  cc_techniciancode
					$cc_techniciancode=$cc_techniciancode+1;
				}
			else
				{
					//fisrt code
					$cc_techniciancode=$ccoData['distcode']."0001";
				}
					$ccoData['cc_techniciancode']=$cc_techniciancode;
					//print_r($ccoData);exit();
					//insert into cc_techniciandb
					//$ccoData['tcode']=$tehcode;
					//$ccoData['facode']=$faccode;
					//$ccoData['uncode']=$unccode;
					$ccoData['previous_table']="cco_db";
					$result = $this -> Common_model -> insert_record('cc_techniciandb', $ccoData);
					$location = base_url(). "Cold-Chain-Operator/List";
					$message="Record Posted As  Cold Chain Technician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
				 //DataEntry Operator
				  else
				     {
						
						/*  //technician name to deoname (change columnname)
						 $ccoData['deoname']=$ccoData['cco_name'];
						 //previous_code
						 			 $ccoData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for cco_db
              unset($ccoData['cco_name']);
			    unset($ccoData['status']);
				//unset($ccoData['newfacode']);
		//unset($ccoData['newtcode']);
		//unset($ccoData['newuncode']);
				//  unset($ccoData['cco_code']);
				    unset($ccoData['husbandname']);
					  unset($ccoData['reason']);
					    unset($ccoData['cco_code']);
					   unset($ccoData['basic_training_start_date']);
					   unset($ccoData['supervisorcode']);
					   unset($ccoData['tcode']);
					   unset($ccoData['cold_chain_training_end_date']);
					   unset($ccoData['vlmis_training_end_date']);
					   unset($ccoData['tcode']);
					   unset($ccoData['vlmis_training_start_date']);
					   unset($ccoData['survilance_training_end_date']);
					   unset($ccoData['tcode']);
					   unset($ccoData['cold_chain_training_start_date']);
					    unset($ccoData['survilance_training_start_date']);
						 unset($ccoData['basic_training_end_date']);
						  unset($ccoData['routine_epi_start_date']);
					unset($ccoData['routine_epi_end_date']);
					   unset($ccoData['catch_area_pop']);
						 unset($ccoData['catch_area_name']);
						  unset($ccoData['areatype']);
						$ccoData['status']='Active';
						$ccoData['date_joining']=$doj;
						$ccoData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$ccoData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$ccoData['distcode']."0001";
						}
						$ccoData['deocode']=$deocode;
//print_r($ccoData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $ccoData);
				     $location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}
			
			if($status=='Post Back')
				
				{
				  if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Operator/List";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Operator/List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Operator/List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
			if($this -> db -> affected_rows() > 0){
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Operator/View/".$cco_code;
				$message="Record Updated for Cold Chain Operator with Code ".$cco_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Operator/List";
				$message="Record Updated Cold Chain Operator with Code ".$cco_code;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from cco_db where cco_code='$cco_code'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Operator already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('cco_db', $ccoData);
			if($result != 0){
				createTransactionLog("Cold Chain Mechanic", "Cold Chain Mechanic Added ".$cco_code);
				$location = base_url()."Cold-Chain-Operator/List";
				$message="Record Saved for New Cold Chain Operator Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	public function cco_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Operator', '/System_setup/cco_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cco_db where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	public function cco_view($cco_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain  Operator', '/System_setup/cco_list');
		$this->breadcrumbs->push('Cold Chain  Operator View', '/System_setup/cco_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select cco_db.* , facilityname(cco_db.facode) as facilityname, districtname(cco_db.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from cco_db  left join bankinfo  on  cco_db.bid= bankinfo.bankid where cco_db.cco_code='$cco_code'"; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	public function cco_edit($cco_code){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Operator', '/System_setup/cco_list');
		$this->breadcrumbs->push('Update Cold Chain Operator', '/System_setup/cco_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(cco_db.distcode), facilityname(facode) as facilityname from cco_db where cco_code = '$cco_code' ";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	public function cc_technician_add(){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage CC Technician', '/System_setup/cc_technician_list');
		$this->breadcrumbs->push('Add New CC Technician', '/System_setup/cc_technician_add');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		
		$province=$_SESSION["Province"];
	
		$query="select distcode, district FROM districts";
		if($_SESSION['UserLevel']=='3'){
			$query .=" where distcode = '".$_SESSION['District']."'";
		}
		$query .=" order by district ASC";
		$result=$this -> db -> query ($query);
		$data['result']= $result -> result_array();
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();
		
		return $data;
		
	}
	//================ Function to Show Page for Saving New Technician Record Ends Here =================//
	//---------------------------------------------------------------------------------------------------//
	//================ Function for Saving New or Existing Technician Record Starts Here ================//
	public function cc_technician_save($cc_technicianData,$cc_techniciancode,$cc_techniciancodeNewData){
		//print_r($cc_technicianData);exit;
		/* if($this -> input -> post ('edit')){
			$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$cc_technicianData,array('cc_techniciancode'=>$cc_techniciancode)); */
		       /* Post Type FOr Posting  */
		$temp=$cc_techniciancodeNewData['post_type'];
		//print_r($temp);exit;
		 $doj=$cc_technicianData['date_joining'];
		        /* FOR DSV TSV FSV  */
		$faccode=$cc_techniciancodeNewData['new_facode'];
		$tehcode=$cc_techniciancodeNewData['new_tcode'];
		$unccode=$cc_techniciancodeNewData['new_uncode'];
		$tcode=$cc_technicianData['cc_techniciancode'];
		$status=$cc_technicianData['status'];
		//uset data 
		  unset($cc_technicianData['post_type']);	
		   unset($cc_technicianData['date_joining']);	
		  unset($cc_technicianData['newfacode']);	
         unset($cc_technicianData['newuncode']);	
        unset($cc_technicianData['newtcode']);	
		
		$previous_table = $cc_technicianData['previous_code'];
		
		if($this -> input -> post ('edit')){
                
			 if($cc_technicianData['status']=='Active') 
			 {
				$cc_technicianData['status']="Active"; 
				$cc_technicianData['date_joining']=$doj;	
			 }
			 if($cc_technicianData['status']=='post')
			 {
				$cc_technicianData['status']="Posted"; 
			 }
			
			$updateQuery = $this -> Common_model -> update_record('cc_techniciandb',$cc_technicianData,array('cc_techniciancode'=>$cc_techniciancode));
			 if($cc_technicianData['status']=='Transfered')
			{
				$cc_technicianData['previouse_code']=$cc_techniciancode;
				$cc_technicianData['cc_techniciancode']=$cc_techniciancodeNewData['new_lhwcode'];
				$cc_technicianData['distcode']=$cc_techniciancodeNewData['new_distcode'];
				$cc_technicianData['uncode']=$cc_techniciancodeNewData['new_uncode'];
				$cc_technicianData['facode']=$cc_techniciancodeNewData['new_facode'];
				$cc_technicianData['tcode']=$cc_techniciancodeNewData['new_tcode'];
				$cc_technicianData['status']='Active';
				print_r($cc_technicianData);exit;
				$result = $this -> Common_model -> insert_record('cc_techniciandb', $cc_technicianData);
			}	
            			
			if($status=='post')
			{
                /* Previous COde and Current Status  */
         $cc_technicianData['previous_code']=$cc_techniciancode;
         $cc_technicianData['current_status']="Temporary-Post";		 
		         /* Supervisor New Record Here  */ 
		    if($temp=='Tehsil Superintendent Vaccinator'){
			  $cc_technicianData['supervisorname']=$cc_technicianData['cc_technicianname'];
			  $cc_technicianData['supervisor_type']=$temp;
			  //unset these values bcx these are for cc_techniciandb
                unset($cc_technicianData['cc_technicianname']);
			    unset($cc_technicianData['status']);
				  unset($cc_technicianData['cc_techniciancode']);
				    unset($cc_technicianData['husbandname']);
					  unset($cc_technicianData['reason']);
					    unset($cc_technicianData['facode']);
					    unset($cc_technicianData['area_type']);
					    unset($cc_technicianData['place_of_posting']);
					    unset($cc_technicianData['postalcode']);
		$cc_technicianData['status']='Active';
		$cc_technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$cc_technicianData['distcode']."0001";
						} 
					
						$cc_technicianData['supervisorcode']=$supervisorcode;
						$cc_technicianData['tcode']=$tehcode;
						$cc_technicianData['previous_table']="cc_techniciandb";
					//print_r($cc_technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $cc_technicianData);
			$location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Posted As TSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				exit;
			
			}
			else if($temp=='District Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("DSV");
			  
			  $cc_technicianData['supervisorname']=$cc_technicianData['cc_technicianname'];
			  $cc_technicianData['supervisor_type']=$temp;
			       /* Unset Data  */
    //unset these values bcx these are for cc_techniciandb
              unset($cc_technicianData['cc_technicianname']);
			    unset($cc_technicianData['status']);
				  unset($cc_technicianData['cc_techniciancode']);
				    unset($cc_technicianData['husbandname']);
					  unset($cc_technicianData['reason']);
					    unset($cc_technicianData['facode']);
					    unset($cc_technicianData['place_of_posting']);
					    unset($cc_technicianData['area_type']);
					  unset($cc_technicianData['postalcode']);
			$cc_technicianData['status']='Active';
			$cc_technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$cc_technicianData['distcode']."0001";
						}
					 $cc_technicianData['supervisorcode']=$supervisorcode;
                     $cc_technicianData['previous_table']="cc_techniciandb";
					//insert into supervisordb
					$result = $this -> Common_model -> insert_record('supervisordb', $cc_technicianData);
					//print_r($result);exit();
			$location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Posted As DSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
			else if($temp=='Field Superintendent Vaccinator'){
				//stcode for supervisor 
				//print_r("FSV");exit();
			 
			  $cc_technicianData['supervisorname']=$cc_technicianData['cc_technicianname'];
			  $cc_technicianData['supervisor_type']=$temp;
			     /* Unset Data */
			  	 //unset these values bcx these are for cc_techniciandb
              unset($cc_technicianData['cc_technicianname']);
			    unset($cc_technicianData['status']);
				  unset($cc_technicianData['cc_techniciancode']);
				    unset($cc_technicianData['husbandname']);
					  unset($cc_technicianData['reason']);
					    unset($cc_technicianData['facode']);
					    unset($cc_technicianData['place_of_posting']);
					    unset($cc_technicianData['area_type']);
					    unset($cc_technicianData['postalcode']);
			$cc_technicianData['status']='Active';
			$cc_technicianData['date_joining']=$doj;
			//getting latest supervisorcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('supervisorcode');
					$this->db->order_by('supervisorcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('supervisordb');
					$supervisorcode=0;
				        foreach($query->result() as $row){
						$supervisorcode=$row->supervisorcode;
						}
						//check code exits
						if($supervisorcode!=null && $supervisorcode!=0){
							
							 //increment the  supervisorcode
							 $supervisorcode=$supervisorcode+1;
							
						}
						else{
							//fisrt code
							$supervisorcode=$cc_technicianData['distcode']."0001";
						}
						$cc_technicianData['supervisorcode']=$supervisorcode;
                      //print_r($cc_technicianData);exit();
					//insert into supervisordb
					$cc_technicianData['tcode']=$tehcode;
					$cc_technicianData['previous_table']="cc_techniciandb";
				$cc_technicianData['facode']=$faccode;
				$cc_technicianData['uncode']=$unccode;
				$cc_technicianData['previous_table']="cc_techniciandb";
				//print_r($cc_technicianData);exit();
					$result = $this -> Common_model -> insert_record('supervisordb', $cc_technicianData);
			$location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Posted As FSV To Supervisor Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			
			}
		else if($temp=='Storekeeper')
					 {
						 //stcode for storekeeper
						 
						 //technician name to skname (change columnname)
						 $cc_technicianData['skname']=$cc_technicianData['cc_technicianname'];
			  //unset these values bcx these are for cc_techniciandb
              unset($cc_technicianData['cc_technicianname']);
			    unset($cc_technicianData['status']);
				  unset($cc_technicianData['cc_techniciancode']);
				    unset($cc_technicianData['husbandname']);
					  unset($cc_technicianData['reason']);
					   unset($cc_technicianData['basic_training_start_date']);
					   unset($cc_technicianData['supervisorcode']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['cold_chain_training_end_date']);
					   unset($cc_technicianData['vlmis_training_end_date']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['vlmis_training_start_date']);
					   unset($cc_technicianData['survilance_training_end_date']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['cold_chain_training_start_date']);
					    unset($cc_technicianData['survilance_training_start_date']);
						 unset($cc_technicianData['basic_training_end_date']);
						  unset($cc_technicianData['routine_epi_start_date']);
					unset($cc_technicianData['routine_epi_end_date']);
					   unset($cc_technicianData['catch_area_pop']);
						 unset($cc_technicianData['catch_area_name']);
						  unset($cc_technicianData['areatype']);
						  $cc_technicianData['date_joining']=$doj;
		$cc_technicianData['status']='Active';
				    //getting latest skcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
				        foreach($query->result() as $row){
						$skcode=$row->skcode;
						}
						//end
						//check code exits
						if($skcode!=null && $skcode!=0){
							
							 //increment the  skcode
							 $skcode=$skcode+1;
							
						}
						else{
							//fisrt code
							$skcode=$cc_technicianData['distcode']."0001";
						}
						$cc_technicianData['skcode']=$skcode;

					//insert into skdb
					
					$result = $this -> Common_model -> insert_record('skdb', $cc_technicianData);
				$location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Posted As Store Keeper Successfully.  ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
				//exit();
				     }
					 
					 
					 
// Start - data send to District surveillance oficer 
					 
			else if($temp=='dsodb')
				{
					$cc_technicianData['dsoname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['mfpcode']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['facode']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest dsocode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('dsocode');
					$this->db->order_by('dsocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('dsodb');
					$dsocode=0;
					foreach($query->result() as $row){
					$dsocode=$row->dsocode;
				}
					//check code exits
			if($dsocode!=null && $dsocode!=0)
				{
					//increment the  dsocode
					$dsocode=$dsocode+1;
				}
			else
				{
					//fisrt code
					$dsocode=$cc_technicianData['distcode']."0001";
				}
					$cc_technicianData['dsocode']=$dsocode;
					//print_r($cc_technicianData);exit();
					//insert into dsodb
					//$cc_technicianData['tcode']=$tehcode;
					//$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('dsodb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As District Surveillance Officer Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
					 
// Start - data send to Computer operator
					 
			else if($temp=='codb')
				{
					$cc_technicianData['coname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['mfpcode']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['facode']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest cocode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('cocode');
					$this->db->order_by('cocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('codb');
					$cocode=0;
					foreach($query->result() as $row){
					$cocode=$row->cocode;
				}
					//check code exits
			if($cocode!=null && $cocode!=0)
				{
					//increment the  cocode
					$cocode=$cocode+1;
				}
			else
				{
					//fisrt code
					$cocode=$cc_technicianData['distcode']."0001";
				}
					$cc_technicianData['cocode']=$cocode;
					//print_r($cc_technicianData);exit();
					//insert into codb
					//$cc_technicianData['tcode']=$tehcode;
					//$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('codb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As Computer Operator Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to Measles Focal Person 
					 
			else if($temp=='mfpdb')
				{
					$cc_technicianData['mfpname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for mfpdb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['mfpcode']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['facode']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest mfpcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('mfpcode');
					$this->db->order_by('mfpcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('mfpdb');
					$mfpcode=0;
					foreach($query->result() as $row){
					$mfpcode=$row->mfpcode;
				}
					//check code exits
			if($mfpcode!=null && $mfpcode!=0)
				{
					//increment the  mfpcode
					$mfpcode=$mfpcode+1;
				}
			else
				{
					//fisrt code
					$mfpcode=$cc_technicianData['distcode']."0001";
				}
					$cc_technicianData['mfpcode']=$mfpcode;
					//print_r($cc_technicianData);exit();
					//insert into mfpdb
					//$cc_technicianData['tcode']=$tehcode;
					//$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('mfpdb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As Measles Focal Person Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}		 
// Start - data send to HF Incahrge
					 
			else if($temp=='med_techniciandb')
				{
					$cc_technicianData['technicianname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for med_techniciandb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('med_techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$cc_technicianData['distcode']."0001";
				}
					$cc_technicianData['techniciancode']=$techniciancode;
					//print_r($cc_technicianData);exit();
					//insert into med_techniciandb
					//$cc_technicianData['tcode']=$tehcode;
					$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('med_techniciandb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As HF Incahrge Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 
// Start - data send to storekeeper
					 
			else if($temp=='skdb')
				{
					$cc_technicianData['skname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for skdb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['facode']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['skcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest skcode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('skcode');
					$this->db->order_by('skcode','desc');
					$this->db->limit('1');
					$query=$this->db->get('skdb');
					$skcode=0;
					foreach($query->result() as $row){
					$skcode=$row->skcode;
				}
					//check code exits
			if($skcode!=null && $skcode!=0)
				{
					//increment the  skcode
					$skcode=$skcode+1;
				}
			else
				{
					//fisrt code
					$skcode=$cc_technicianData['distcode']."0001";
				}
					$cc_technicianData['skcode']=$skcode;
					//print_r($cc_technicianData);exit();
					//insert into skdb
					//$cc_technicianData['tcode']=$tehcode;
					//$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('skdb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As Storekeeper Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	
// Start - data send to EpiTechnician
					 
			else if($temp=='techniciandb')
				{
					$cc_technicianData['technicianname']=$cc_technicianData['cc_technicianname'];
					//unset these values bcx these are for techniciandb Table
					unset($cc_technicianData['cc_technicianname']);
					unset($cc_technicianData['status']);
					unset($cc_technicianData['husbandname']);
					unset($cc_technicianData['reason']);
					unset($cc_technicianData['facode']);
					unset($cc_technicianData['date_resigned']);
					unset($cc_technicianData['current_status']);
					unset($cc_technicianData['techniciancode']);
					unset($cc_technicianData['supervisorcode']);
					unset($cc_technicianData['place_of_posting']);
					unset($cc_technicianData['area_type']);
					unset($cc_technicianData['postalcode']);
					unset($cc_technicianData['cc_techniciancode']);
					$cc_technicianData['status']='Active';
					$cc_technicianData['date_joining']=$doj;
					//getting latest techniciancode from db 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('techniciancode');
					$this->db->order_by('techniciancode','desc');
					$this->db->limit('1');
					$query=$this->db->get('techniciandb');
					$techniciancode=0;
					foreach($query->result() as $row){
					$techniciancode=$row->techniciancode;
				}
					//check code exits
			if($techniciancode!=null && $techniciancode!=0)
				{
					//increment the  techniciancode
					$techniciancode=$techniciancode+1;
				}
			else
				{
					//fisrt code
					$techniciancode=$cc_technicianData['distcode']."0001";
				}
				//print_r($cc_technicianData);exit;
					$cc_technicianData['techniciancode']=$techniciancode;
					//print_r($cc_technicianData);exit();
					//insert into techniciandb
					//$cc_technicianData['tcode']=$tehcode;
					$cc_technicianData['facode']=$faccode;
					//$cc_technicianData['uncode']=$unccode;
					$cc_technicianData['previous_table']="cc_techniciandb";
					$result = $this -> Common_model -> insert_record('techniciandb', $cc_technicianData);
					$location = base_url(). "Cold-Chain-Technician/List";
					$message="Record Posted As EpiTechnician Successfully.";
					$this -> session -> set_flashdata('message',$message);
					redirect($location);
				}	 		 
					 
				 //DataEntry Operator
				  else
				     {
						
						/*  //technician name to deoname (change columnname)
						 $cc_technicianData['deoname']=$cc_technicianData['cc_technicianname'];
						 //previous_code
						 			 $cc_technicianData['previous_code']=$tcode;
						 //unset fields that are not necassary  for SkDB
		                  /* Unset Data *
			  //unset these values bcx these are for cc_techniciandb
              unset($cc_technicianData['cc_technicianname']);
			    unset($cc_technicianData['status']);
				//unset($cc_technicianData['newfacode']);
		//unset($cc_technicianData['newtcode']);
		//unset($cc_technicianData['newuncode']);
				//  unset($cc_technicianData['cc_techniciancode']);
				    unset($cc_technicianData['husbandname']);
					  unset($cc_technicianData['reason']);
					    unset($cc_technicianData['cc_techniciancode']);
					   unset($cc_technicianData['basic_training_start_date']);
					   unset($cc_technicianData['supervisorcode']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['cold_chain_training_end_date']);
					   unset($cc_technicianData['vlmis_training_end_date']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['vlmis_training_start_date']);
					   unset($cc_technicianData['survilance_training_end_date']);
					   unset($cc_technicianData['tcode']);
					   unset($cc_technicianData['cold_chain_training_start_date']);
					    unset($cc_technicianData['survilance_training_start_date']);
						 unset($cc_technicianData['basic_training_end_date']);
						  unset($cc_technicianData['routine_epi_start_date']);
					unset($cc_technicianData['routine_epi_end_date']);
					   unset($cc_technicianData['catch_area_pop']);
						 unset($cc_technicianData['catch_area_name']);
						  unset($cc_technicianData['areatype']);
						$cc_technicianData['status']='Active';
						$cc_technicianData['date_joining']=$doj;
						$cc_technicianData['status']='Active';
				        //end
						
					//getting latest deocode from deodb 
					$this->db->where('distcode',$cc_technicianData['distcode']);
					$this->db->select('deocode');
					$this->db->order_by('deocode','desc');
					$this->db->limit('1');
					$query=$this->db->get('deodb');
					$deocode=0;
				        foreach($query->result() as $row){
						$deocode=$row->deocode;
						}
						//end
						//check code exits
						if($deocode!=null && $deocode!=0){
						//increment the code
						$deocode=$deocode+1;
						}
						else{
							//fisrt code
							$deocode=$cc_technicianData['distcode']."0001";
						}
						$cc_technicianData['deocode']=$deocode;
//print_r($cc_technicianData);exit;
					//insert into deodb
					$result = $this -> Common_model -> insert_record('deodb', $cc_technicianData);
				     $location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Posted As DataEntry Operator Successfully. ";
				$this -> session -> set_flashdata('message',$message);
				redirect($location); */
				     }
					 
			}	
			
			if($status=='Post Back')
				{
				  if($temp=='cco_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cco_db',$dsofficer,array('cco_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Technician/List";
							$message="Record posted back to Cold Chain Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='go_db')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('go_db',$dsofficer,array('go_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Technician/List";
							$message="Record posted back to Generator Operator Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='cc_mechanic')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('cc_mechanic',$dsofficer,array('ccm_code'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Technician/List";
							$message="Record posted back to Cold Chain Mechanic Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
							}
					else if($temp=='driverdb')
							{
							$dsofficer=array('status'=>'Active');	
							//replace status of epitech to active from tempost
							$updateQuery = $this -> Common_model -> update_record('driverdb',$dsofficer,array('drivercode'=>$previous_table));
							//print_r($$temp);exit;
							//print_r($updateQuery);exit;
							//delete temporary post from supervisordb
							/* $this->db->where('supervisorcode',$supervisorCode);
							$this->db->delete('supervisordb'); */
							$location = base_url(). "Cold-Chain-Technician/List";
							$message="Record posted back to Driver Successfully!";
							$this -> session -> set_flashdata('message',$message);
							redirect($location);
							exit();
						}
				else 
				{
							
						}
				}
			
			if($this -> db -> affected_rows() > 0){
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Technician/View/".$cc_techniciancode;
				$message="Record Updated for Cold Chain Technician with Code ".$cc_techniciancode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}else{
				//createTransactionLog("Cold Chain Mechanic-DB", "Cold Chain Mechanic Updated ".$ccm_code);
				$location = base_url(). "Cold-Chain-Technician/List";
				$message="Record Updated Cold Chain Technician with Code ".$cc_techniciancode;
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}else{
			$checkquery = "select count(*) as cnt from cc_techniciandb where cc_techniciancode='$cc_techniciancode'";
			$checkresult=$this -> db -> query ($checkquery);
			$checkrow=$checkresult -> row_array();
			$recexist=(int)$checkrow['cnt'];
			if($recexist==1){
				$script = '<script language="javascript" type="text/javascript">';
				$script .= 'alert("Cold Chain Technician already exists....")';
				$script .= 'history.go(-1)';
				$script .= '</script>';
				echo $script;
				exit();	
			}
			$result = $this -> Common_model -> insert_record('cc_techniciandb', $cc_technicianData);
			if($result != 0){
				createTransactionLog("Cold Chain Technician", "Cold Chain Technician Added ".$cc_techniciancode);
				$location = base_url()."Cold-Chain-Technician/List";
				$message="Record Saved for New Cold Chain Technician Successfully!";
				$this -> session -> set_flashdata('message',$message);
				redirect($location);
			}
		}
		exit();
	}
	public function cc_technician_list($per_page, $startpoint) {
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this -> breadcrumbs -> push('Home', '/');
		$this -> breadcrumbs -> push('Manage Cold Chain Technician', '/System_setup/cc_technician_list');
		/////////////////////////////////////////////////////////////////
		$wc = getWC();//helper function
		$query = "Select facode, fatype ,fac_name from facilities where $wc and hf_type='e' order by fac_name ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac'] = $Fac_result -> result_array();
		$query = "Select tcode, tehsil from tehsil where $wc order by tehsil ASC";
		$Teh_result = $this -> db -> query($query);
		$data['resultTeh'] = $Teh_result -> result_array();
		$query = "SELECT distinct fatype from facilities where $wc order by fatype ASC";
		$Fac_result = $this -> db -> query($query);
		$data['resultFac_type'] = $Fac_result -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query = "Select distcode, district from districts where $neWc order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		// Change `records` according to your table name.
		$query = "select *, facilitytype(facode) as facilitytype,is_temp_saved,facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode) as tehsil from cc_techniciandb where $wc LIMIT {$per_page} OFFSET {$startpoint}  ";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array();
		//echo '<pre>';print_r($data['results']);exit();
		return $data;
	}
	//================ Function for Viewing Existing Technician Record Starts Here ==========================//
	//-------------------------------------------------------------------------------------------------------//
	//================ Function to Show Page for Editing Existing Supervisor Record Starts Here =============//
	
		public function cc_technician_view($cc_techniciancode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain  Technician', '/System_setup/cc_technician_list');
		$this->breadcrumbs->push('Cold Chain  Technician View', '/System_setup/cc_technician_view');
		/////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		//$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode)  from supervisordb where supervisorcode = '$supervisorcode' ";
		$query="select cc_techniciandb.* , facilityname(cc_techniciandb.facode) as facilityname, districtname(cc_techniciandb.distcode), bankinfo.bankcode as bcode,bankinfo.bankname as bank from cc_techniciandb  left join bankinfo  on  cc_techniciandb.bid= bankinfo.bankid where cc_techniciandb.cc_techniciancode='$cc_techniciancode'"; 

		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		return $data;
	}
	
	public function cc_technician_edit($cc_techniciancode){
		//////////////////////ADDING BREADCRUMS//////////////////////////
		$this->breadcrumbs->push('Home','/');
		$this->breadcrumbs->push('Manage Cold Chain Technician', '/System_setup/cc_technician_list');
		$this->breadcrumbs->push('Update Cold Chain Technician', '/System_setup/cc_technician_edit');
		///////////////////////////////////////////////////////////////////
		$district = $this -> session -> District;
		$query="select *,districtname(cc_techniciandb.distcode), facilityname(facode) as facilityname from cc_techniciandb where cc_techniciancode = '$cc_techniciancode' ";
		$result=$this -> db -> query ($query);
		$data['codata']=$result -> row_array();
		
		$query = "select distcode, district FROM districts WHERE distcode='$district' order by district ASC";
		$result = $this -> db -> query($query);
		$data['result'] = $result -> result_array();	

		$query = "Select facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac = $this -> db -> query($query);
		$data['resultFac'] = $resultFac -> result_array();		

		$query="Select tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this -> db -> query($query);
		$data['resultTeh'] = $resultTeh -> result_array();
	
		$district_new=$data['codata']['distcode'];
		$query="select * from bankinfo";
		$resultAR= $this -> db ->query($query);
		$data['resultbank']= $resultAR -> result_array();

		return $data;
	}
	//========================= Function to Show Page for Viewing Facility Starts Here ====================//
	//-----------------------------------------------------------------------------------------------------//
}//End of System Setup Model Class