<?php
class Hr_management_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() 
	{
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> model('Filter_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	
	//--------------HR Management Starts--------------------
	public function hr_list($per_page,$startpoint)
	{
		$wc = getWC();//helper function
		$procode = $_SESSION['Province'];
		$UserLevel = $_SESSION['UserLevel'];
		$district = $this -> session -> District;
		$query = "SELECT * from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC LIMIT {$per_page} OFFSET {$startpoint}) subquery  where post_status='Active' and post_distcode = '$district' and is_deleted='0'";
		$results = $this -> db -> query($query);
		$data['results'] = $results -> result_array(); 
		
		$query="SELECT distcode, district FROM districts order by district ASC"; 
		$result1=$this->db->query($query); 
		$data['districts']=$result1->result_array();
		$query="SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		$query="SELECT uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultun=$this->db->query($query);
		$data['resultun']=$resultun->result_array();
		$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this->db->query($query);
		$data['resultTeh']=$resultTeh->result_array();
		//echo $this->db->last_query();exit;
		return $data;
	}
	
	public function hr_add()
	{
		if ((in_array($_SESSION['UserLevel'], array('2','3','4'))) && $_SESSION['UserType'] == 'DEO')
		{
			if($_SESSION['UserLevel'] == '3' || $_SESSION['UserLevel'] == '4')
			{
				$district = $_SESSION['District'];
				$query="SELECT distcode, district FROM districts WHERE distcode='$district' order by district ASC";
				$result=$this->db->query($query);
				$data['result']=$result->result_array();
			}
			$query="SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
			$resultFac=$this->db->query($query);
			$data['resultFac']=$resultFac->result_array();
			$query="SELECT uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
			$resultun=$this->db->query($query);
			$data['resultun']=$resultun->result_array();
			$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
			$resultTeh=$this->db->query($query);
			$data['resultTeh']=$resultTeh->result_array(); 
			$query="SELECT name, id from training_types where is_active= '1' order by created_date ASC";
			$resulttraining=$this->db->query($query);
			$data['training_types']=$resulttraining->result_array();
		}
		else
		{
			$query="SELECT distcode, district FROM districts order by district ASC";
			$result=$this->db->query($query);
			$data['result']=$result->result_array();
		}
		return $data;
	}
	public function hr_save($data,$training)
	{
		//print_r($data); exit;
		$this->db->trans_start();
		$status=$data['status'];
		$status_date=$data['status_date'];
		unset($data['status'],$data['status_date']);
		$this->db->insert('hr_db',$data);
		$id = $this->db->insert_id();
		$last_code = $this->db->query("select code from hr_db where id='$id'")->row()->code;
		$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $data['hr_type_id'];
		$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $data['hr_sub_type_id'];
		$data['pre_procode']		= $data['post_procode']			= $data['procode'];
		$data['pre_distcode']		= $data['post_distcode']		= $data['distcode'];
		$data['pre_tcode']			= $data['post_tcode']			= $data['tcode'];
		$data['pre_uncode']			= $data['post_uncode']			= $data['uncode'];
		$data['pre_facode']			= $data['post_facode']			= $data['facode'];
		$data['pre_status']			= 'New';
		$data['post_status']		= $status;
		$data['status_date']		= $status_date;
		$data['pre_level']			= $data['post_level']			= $data['level'];
		unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status'],$data['level']);
		$this->db->insert('hr_db_history',$data); 
		//print_r($training); exit;
 		if($training)
		{
			foreach($training as $key => $train)
			{
				$train_data['hr_code'] 		= $last_code;
				$train_data['training_id']	 = $train;
				$train_data['created_date']	 = date('Y-m-d h:i:s');;
				$train_data['created_by']	 	= $_SESSION['username'];
				$this->db->insert('hr_trainings',$train_data);
			}
		}
		$this->db->trans_complete();
		return $last_code; 
	}
	public function hr_new_code()
	{
		$date = date('ym'); //echo $date; exit;
		if ($date)
		{
			$query = "(SELECT max(code) as code FROM hr_db where code like '$date%')";
			$result = $this -> db -> query($query);
			$hr_new_data = $result -> row_array();
			$newCode = $hr_new_data['code'];
			if ($newCode == NULL) 
			{
				return $date.'00001';
			} 
			else 
			{
				return $newCode + 1;
			}
			# code...
		}
	}
	public function hr_edit_get($id)
	{
		$result[]="";
		
		if((in_array($_SESSION['UserLevel'], array('2','3','4'))) && $_SESSION['UserType'] == 'DEO'  || $_SESSION['UserLevel']=='2')
		{
			if($_SESSION['UserLevel'] == '3' || $_SESSION['UserLevel'] == '4')
			{
				$district = $this -> session -> District;
				$query="SELECT distcode, district FROM districts order by district ASC";
				$result1=$this->db->query($query);
				$result['districts']=$result1->result_array();
			}
			$query="SELECT name, id from training_types where is_active= '1' order by created_date ASC";
			$resulttraining=$this->db->query($query);
			$result['training_types']=$resulttraining->result_array();
		}
		//print_r($result['result']); exit;
		$this->db->select('*');
		$this->db->from('hr_db');
		$this->db->order_by("created_date", "desc");
		$this->db->where("code",$id);
		$result['edit'] = $this->db-> get()-> row_array();
		
		$this->db->select('*');
		$this->db->from('bankinfo');
		$this->db->where("bankid",$result['edit']['bid']);
		$result['edit']['bankinfo'] = $this->db-> get()-> row_array();
		
		if($result['edit']['code']){
			$this->db->select('training_id');
			$this->db->from('hr_trainings');
			$this->db->order_by("created_date", "desc");
			$this->db->where("hr_code",$result['edit']['code']);
			$result['training'] = $this->db-> get()-> result_array();
		}
		//print_r($result); exit;
		return $result;
	}
	public function get_training($code)
	{
		$this->db->select('training_id');
		$this->db->from('hr_trainings');
		$this->db->order_by("created_date", "desc");
		$this->db->where("hr_code",$code);
		return $result = $this->db-> get()-> result_array();
	}
	public function hr_edit($code, $data, $training)
	{
		//print_r($data);  exit; //print_r($data); exit;
		//$old_code = $data['code'];
			$this->db->trans_start();
/* 			if($data['status'] == 'Transferred')
			{	
				$data['status'] 	= 'Active';
				$data['level']		= $data_transfer['level'];
				$data['distcode']	= $data_transfer['post_dist'];
				$data['tcode']		= $data_transfer['post_tcode'];
				$data['uncode']		= $data_transfer['post_uncode'];
				$data['facode']		= $data_transfer['post_facode'];
				//print_r($data); exit;
			}
			if($data_transfer['new_status'] == 'Posted')
			{
				$data['status']			= 'Posted';
				$data['hr_type_id'] 	= $data_transfer['posted_type'];
				$data['hr_sub_type_id'] = $data_transfer['posted_subtype'];
			}
			if($data_transfer['new_status'] == 'Post_Back')
			{
				$data_post = $this->db->query("SELECT pre_hr_type_id, pre_hr_sub_type_id FROM hr_db_history where code = '$old_code' ORDER BY created_date DESC LIMIT 1")->row_array();
				//print_r($data); exit;
				$data['status']			= 'Active';
				$data['hr_type_id'] 	= $data_post['pre_hr_type_id'];
				$data['hr_sub_type_id'] = $data_post['pre_hr_sub_type_id'];
				$data['status_date']	= date('Y-m-d');
			}
			if($data_transfer['new_status'] == 'On Leave')
			{
				//echo 'hii'; exit; 
				$data_insert['hr_code'] = $old_code;
				$data_insert['leave_start_date'] = $data_transfer['leave_start_date'];
				$data_insert['leave_end_date']	 = $data_transfer['leave_end_date'];
				$data_insert['reason']			 = $data_transfer['reason'];
				$data_insert['remarks']			 = $data_transfer['remarks'];
				$data_insert['approved_by']		 = $data_transfer['approved_by'];
				$data_insert['created_date']	 = date('Y-m-d h:i:s');
				$data_insert['created_by']		 = $_SESSION['username'];

				$this->db->insert('hr_leave',$data_insert);
			}
				//Updating Transferred Record 
				$this->db->where('id', $id);
				$this->db->update('hr_db',$data);
				if($data_transfer['new_status'] == 'Transferred')
				{
					$data['pre_status']     = 'Transferred' ;
					$data['post_status']	= 'Active' ;
					$data['pre_distcode']	= $data_transfer['pre_dist'];
					$data['post_distcode']	= $data_transfer['post_dist'];
					$data['pre_tcode']		= $data_transfer['pre_tcode'];
					$data['post_tcode']		= $data_transfer['post_tcode'];
					$data['pre_uncode']		= $data_transfer['pre_uncode'];
					$data['post_uncode']	= $data_transfer['post_uncode'];
					$data['pre_facode']		= $data_transfer['pre_facode'];
					$data['post_facode']	= $data_transfer['post_facode'];
					
					$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $data['hr_type_id'];
					$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $data['hr_sub_type_id'];
					$data['pre_procode']		= $data['post_procode']			= $data['procode'];
					unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status']);
					//print_r($data); exit;
				}
				if($data_transfer['new_status'] == 'Posted')
				{
					$data['pre_status']     		= 'Posted' ;
					$data['post_status']			= 'Active' ;
					$data['pre_hr_type_id']			= $data_transfer['pre_type'];
					$data['post_hr_type_id']		= $data_transfer['posted_type'];
					$data['pre_hr_sub_type_id']		= $data_transfer['pre_subtype'];
					$data['post_hr_sub_type_id']	= $data_transfer['posted_subtype'];
					
					$data['pre_distcode']		= $data['post_distcode']	= $data['distcode'];
					$data['pre_procode']		= $data['post_procode']		= $data['procode'];
					$data['pre_tcode']			= $data['post_tcode']		= $data['tcode'];
					$data['pre_uncode']			= $data['post_uncode']		= $data['uncode'];
					$data['pre_facode']			= $data['post_facode']		= $data['facode'];
					unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status']);
					//print_r($data); exit;
				}
				if($data_transfer['new_status'] == 'Post_Back')
				{
					$data['pre_status']			 = 'Posted' ;
					$data['post_status']		 = 'Post_Back' ;
					$data['pre_hr_type_id']		 = $data_transfer['pre_type'];
					$data['post_hr_type_id']	 = $data_post['pre_hr_type_id'];
					$data['pre_hr_sub_type_id']  = $data_transfer['pre_subtype'];
					$data['post_hr_sub_type_id'] = $data_post['pre_hr_sub_type_id'];
					
					$data['pre_distcode'] = $data['post_distcode'] = $data['distcode'];
					$data['pre_procode']  = $data['post_procode']  = $data['procode'];
					$data['pre_tcode']	  = $data['post_tcode']	   = $data['tcode'];
					$data['pre_uncode']	  = $data['post_uncode']   = $data['uncode'];
					$data['pre_facode']	  = $data['post_facode']   = $data['facode'];
					unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status']);
					//print_r($data); exit;
				}
				if($data_transfer['new_status'] == 'Transferred' || $data_transfer['new_status'] == 'Posted' || $data_transfer['new_status'] == 'Post_Back')
				{
					$this->db->insert('hr_db_history',$data);
				} */
				$this->db->where('code', $code);
				$this->db->update('hr_db',$data);
				unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status'],$data['level']);
				$this->db->where('code', $code);
				$this->db->update('hr_db_history',$data);
				//echo $this->db->last_query();exit;
				$this->db->where('hr_code', $code);
				$this->db->delete('hr_trainings');
			if($training) 
			{
				foreach($training as $train)
				{ 
					$train_data['hr_code'] 		 = ($data['code']) ? $data['code'] : $code ;
					$train_data['training_id']	 = $train; 
					$train_data['created_date']	 = date('Y-m-d h:i:s');;
					$train_data['created_by']	 = $_SESSION['username'];
					$this->db->insert('hr_trainings',$train_data);
				}
			}
			$this->db->trans_complete();
	}
	public function hr_del($code)
	{
		$this->db->trans_start();
			$code = $this->db->query("SELECT code FROM hr_db where code = '$code'")->row()->code;
			// echo $id; exit; 
			$data = array(
				'updated_date'=>date('Y-m-d h:i:s'),
				'is_deleted'=>"1"
			);
			$this->db->where('code', $code);
			$this->db->update('hr_db_history',$data); 
			
			/* $this->db->where('hr_code', $code);
			$this->db->delete('hr_trainings'); 
			
			$this->db->where('hr_code', $code);
			$this->db->delete('hr_leave');  */
			
			$this->db->where('code', $code);
			$this->db->update('hr_db',$data);
		$this->db->trans_complete();
	}
	public function hr_status_edit($hrcode){ 
		$utype=$_SESSION['utype'];
		//print_r($utype);
		$query="select *, facilityname(facode) as facilityname, districtname(distcode) as district, tehsilname(tcode), coalesce(unname(uncode),'') as unioncouncil  from hr_db where code = '$hrcode' ";
		//print_r($query); exit();  
		$result = $this -> db -> query($query);
		$data['hrdata'] = $result -> result_array();
		
		$query="select distcode, district FROM districts order by district";
		$resultDist = $this -> db -> query($query);
		$data['resultDist'] = $resultDist -> result_array();

		$querystatus1="select pre_status,post_status from hr_db_history where code = '$hrcode' order by id DESC LIMIT 1";
		$currentStatusResult = $this -> db -> query($querystatus1);
		$data['hrdata1'] = $currentStatusResult -> result_array();
		
		$q="select hr_db_history .id, hr_db_history .pre_status,districtname(hr_db_history .pre_distcode) as predistcode,districtname(hr_db_history .post_distcode) as postdistcode,hr_db_history .post_status,hr_db_history .status_date,hr_db_history .code,hr_db.level from hr_db_history inner join hr_db on hr_db_history .code=hr_db.code where hr_db_history .code='$hrcode' order by hr_db_history .id DESC";
        //print_r($q); exit();
		$res = $this -> db -> query($q);
		$hrstatus = $res -> result_array();
		
		$query="select count(*) from hr_db_history where code='$hrcode'";
        //print_r($q); exit();
		$res = $this -> db -> query($query);
		$hrstatus_counts = $res -> result_array();
		
		if($_SESSION['UserLevel'] == '3' || $_SESSION['UserLevel'] == '4')
		{
				$district = $this -> session -> District;
				$query="SELECT distcode, district FROM districts order by district ASC";
				$result1=$this->db->query($query);
				$data['districts']=$result1->result_array();
				//print_r($data['districts']);
		}
		$query="SELECT facode, fac_name from facilities where distcode='$district' and hf_type='e' order by fac_name ASC";
		$resultFac=$this->db->query($query);
		$data['resultFac']=$resultFac->result_array();
		$query="SELECT uncode, un_name from unioncouncil where distcode='$district' order by un_name ASC";
		$resultun=$this->db->query($query);
		$data['resultun']=$resultun->result_array();
		$query="SELECT tcode, tehsil from tehsil where distcode='$district' order by tehsil ASC";
		$resultTeh=$this->db->query($query);
		$data['resultTeh']=$resultTeh->result_array();
		$query = "select * from hr_db_history where code = '$hrcode' order by id DESC LIMIT 1";
		$result = $this -> db -> query($query);
		$data['resultArray'] = $result -> result_array();
		$data['htmlData'] = getSectionsStatusTableHR($hrstatus,$hrstatus_counts);
		return $data;
	}
	public function hr_status_save(){
		//echo '<pre>';print_r($this->input->post()); exit;  
		$old_code=$this->input->post("code");
		$id=$this->input->post("id");    
		$status_type=$this->input->post("status_type");
		$status_date=$this->input->post("date_termination");
		$hr_type_id=($this -> input -> post ('type'))? $this -> input -> post ('type') : Null;
		$hr_sub_type_id=($this -> input -> post ('sub_type'))? $this -> input -> post ('sub_type') : Null;
		$post_hr_type_id=($this -> input -> post ('temp_post'))? $this -> input -> post ('temp_post') : Null;
		$post_hr_sub_type_id=($this -> input -> post ('temp_sub_post'))? $this -> input -> post ('temp_sub_post') : Null;
		$date_from=($this -> input -> post ('date_from'))? $this -> input -> post ('date_from') : Null;
		$date_to=($this -> input -> post ('date_to'))? $this -> input -> post ('date_to') : Null;
		$procode=($this -> input -> post ('procode'))? $this -> input -> post ('procode') : Null;
		$distcode=($this -> input -> post ('distcode'))? $this -> input -> post ('distcode') : Null;
		$tcode=($this -> input -> post ('tcode'))? $this -> input -> post ('tcode') : Null;
		$uncode=($this -> input -> post ('uncode'))? $this -> input -> post ('uncode') : Null;
		$facode=($this -> input -> post ('facode'))? $this -> input -> post ('facode') : Null;
		$new_distcode=($this -> input -> post ('new_distcode'))? $this -> input -> post ('new_distcode') : Null;
		$new_tcode=($this -> input -> post ('new_tehcode'))? $this -> input -> post ('new_tehcode') : Null;
		$new_uncode=($this -> input -> post ('new_uncode'))? $this -> input -> post ('new_uncode') : Null;
		$new_facode=($this -> input -> post ('new_facode'))? $this -> input -> post ('new_facode') : Null;
		$pre_level=($this -> input -> post ('pre_level'))? $this -> input -> post ('pre_level') : Null;
		$post_level=($this -> input -> post ('new_level'))? $this -> input -> post ('new_level') : Null;
		$this->db->trans_start(); 
		$data_type = $this->db->query("SELECT * FROM hr_db where code = '$old_code' ORDER BY created_date DESC LIMIT 1")->row_array();
			$data['name']	            = $data_type['name']; 
			$data['fathername']	        = $data_type['fathername']; 
			$data['guardian_name']	    = $data_type['guardian_name']; 
			$data['nic']	            = $data_type['nic']; 
			$data['date_of_birth']	    = $data_type['date_of_birth']; 
			$data['catch_area_name']    = $data_type['catch_area_name']; 
			$data['permanent_address']	= $data_type['permanent_address'];
			$data['present_address']	= $data_type['present_address']; 
			$data['lastqualification']	= $data_type['lastqualification']; 
			$data['passingyear']	    = $data_type['passingyear']; 
			$data['institutename']	    = $data_type['institutename']; 
			$data['date_joining']	    = $data_type['date_joining']; 
			$data['place_of_joining	']	= $data_type['place_of_joining']; 
			$data['areatype']	        = $data_type['areatype']; 
			$data['phone']	            = $data_type['phone']; 
			$data['emergency_no']	    = $data_type['emergency_no']; 
			$data['gender']	            = $data_type['gender']; 
			$data['marital_status']	    = $data_type['marital_status']; 
			$data['bankaccountno']	    = $data_type['bankaccountno']; 
			$data['payscale']	        = $data_type['payscale']; 
			$data['bid']	            = $data_type['bid']; 
			$data['basicpay']	        = $data_type['basicpay']; 
			$data['allowances']	        = $data_type['allowances']; 
			$data['deductions']	        = $data_type['deductions']; 
			$data['branchcode']	        = $data_type['branchcode']; 
			$data['branchname']	        = $data_type['branchname']; 
			$data['employee_type']	    = $data_type['employee_type']; 
		if($this->input->post("status_type") == 'Active')
		{ 
			$status = $this->db->query("SELECT post_status FROM hr_db_history where code = '$old_code' ORDER BY created_date DESC LIMIT 1")->row_array();
			//print_r($status_type); exit(); 
			//echo'aaa'; exit();
			$data['code']           = $old_code;
			$data['pre_status']     = $status['post_status'];
			$data['post_status']	= $status_type ;
			$data['status_date']	= $status_date ;
			$data['pre_distcode']	= $distcode;
			$data['post_distcode']	= $distcode;
			$data['pre_tcode']		= $tcode;
			$data['post_tcode']		= $tcode;
			$data['pre_uncode']		= $uncode;
			$data['post_uncode']	= $uncode;
			$data['pre_facode']		= $facode;
			$data['post_facode']	= $facode;
			$data['pre_level']	        = $pre_level;
			$data['post_level']	        = $pre_level;
			$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $hr_type_id;
			$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $hr_sub_type_id;
			$data['pre_procode']		= $data['post_procode']			= $procode;
			$data['created_date']	    = date('Y-m-d h:i:s');
			$data['created_by']		    = $_SESSION['username'];
			$data['updated_date']       = date('Y-m-d h:i:s');
			$data['updated_by']         = $_SESSION['username'];
			//print_r($data); exit;
			$this->db->insert('hr_db_history',$data);
		}	
		if($this->input->post("status_type") == 'Terminated' || $this->input->post("status_type") == 'Retired' || $this->input->post("status_type") == 'Resigned' || $this->input->post("status_type") == 'Died' || $this->input->post("status_type") == 'Contract Expired' || $this->input->post("status_type") == 'Shifted')
		{ 
			//echo'aaa'; exit();
			$data['code']           = $old_code;
			$data['pre_status']     = 'Active' ;
			$data['post_status']	= $status_type ;
			$data['status_date']	= $status_date ;
			$data['pre_distcode']	= $distcode;
			$data['post_distcode']	= $distcode;
			$data['pre_tcode']		= $tcode;
			$data['post_tcode']		= $tcode;
			$data['pre_uncode']		= $uncode;
			$data['post_uncode']	= $uncode;
			$data['pre_facode']		= $facode;
			$data['post_facode']	= $facode;
			$data['pre_level']	        = $pre_level;
			$data['post_level']	        = $pre_level;
			$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $hr_type_id;
			$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $hr_sub_type_id;
			$data['pre_procode']		= $data['post_procode']			= $procode;
			$data['created_date']	    = date('Y-m-d h:i:s');
			$data['created_by']		    = $_SESSION['username'];
			$data['updated_date']       = date('Y-m-d h:i:s');
			$data['updated_by']         = $_SESSION['username'];
			//print_r($data); exit;
			$this->db->insert('hr_db_history',$data);
		}
		if($this->input->post("status_type") == 'Transferred')
		{  
	        //echo'aaa'; exit();
	        $data['code']           = $old_code;
			$data['post_level']		= $post_level;
			$data['pre_level']		= $pre_level;
			$data['pre_status']     = $status_type;
			$data['post_status']	= 'Active';
			$data['status_date']	= $status_date ;
			$data['pre_distcode']	= $distcode;
			$data['post_distcode']	= $new_distcode;
			$data['pre_tcode']		= $tcode;
			$data['post_tcode']		= $new_tcode;
			$data['pre_uncode']		= $uncode;
			$data['post_uncode']	= $new_uncode;
			$data['pre_facode']		= $facode;
			$data['post_facode']	= $new_facode; 
			$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $hr_type_id;
			$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $hr_sub_type_id;
			$data['pre_procode']		= $data['post_procode']			= $procode;
			$data['created_date']	    = date('Y-m-d h:i:s');
			$data['created_by']		    = $_SESSION['username'];
			$data['updated_date']       = date('Y-m-d h:i:s');
			$data['updated_by']         = $_SESSION['username'];
			$this->db->insert('hr_db_history',$data);
			//in hr_db insert
			$data_insert['level']	    = $post_level;
			$data_insert['distcode']	= $new_distcode;
			$data_insert['tcode']		= $new_tcode;
			$data_insert['uncode']		= $new_uncode;
			$data_insert['facode']		= $new_facode;
			$this->db->where('code', $old_code);
			$this->db->update('hr_db',$data_insert);
			//unset($data['hr_type_id'], $data['hr_sub_type_id'], $data['procode'], $data['distcode'], $data['tcode'], $data['uncode'], $data['facode'], $data['status']);
		    //print_r($data); exit;
			
		}
		if($this->input->post("status_type") == 'On Leave')
		{
			//echo 'hii'; exit; 
			$data_insert['hr_code']          = $old_code;
			$data_insert['leave_start_date'] = $date_from;
			$data_insert['leave_end_date']	 = $date_to;
			$data_insert['created_date']	 = date('Y-m-d h:i:s');
			$data_insert['created_by']		 = $_SESSION['username'];
			$this->db->insert('hr_leave',$data_insert);
			//insert in hr_db_histroy
			$data['code']           = $old_code;
			$data['pre_status']     = 'Active';
			$data['post_status']	= $status_type;
			$data['status_date']	= date('Y-m-d');
			$data['pre_distcode']	= $distcode;
			$data['post_distcode']	= $distcode;
			$data['pre_tcode']		= $tcode;
			$data['post_tcode']		= $tcode;
			$data['pre_uncode']		= $uncode;
			$data['post_uncode']	= $uncode;
			$data['pre_facode']		= $facode;
			$data['post_facode']	= $facode;
			$data['pre_level']		= $pre_level;
			$data['post_level']		= $pre_level;
			$data['pre_hr_type_id']		= $data['post_hr_type_id']		= $hr_type_id;
			$data['pre_hr_sub_type_id']	= $data['post_hr_sub_type_id']	= $hr_sub_type_id;
			$data['pre_procode']		= $data['post_procode']			= $procode;
			$data['created_date']	    = date('Y-m-d h:i:s');
			$data['created_by']		    = $_SESSION['username'];
			$data['updated_date']       = date('Y-m-d h:i:s');
			$data['updated_by']         = $_SESSION['username'];
			$this->db->insert('hr_db_history',$data);
		}
		if($this->input->post("status_type") == 'Posted')
		{
			//echo'aaa'; exit();
			$data['code']                   = $old_code;
			$data['pre_status']     		= $status_type;
			$data['post_status']			= 'Active';
			$data['status_date']	        = $status_date ;
			$data['pre_hr_type_id']			= $hr_type_id;
			$data['post_hr_type_id']		= $post_hr_type_id;
			$data['pre_hr_sub_type_id']		= $hr_sub_type_id;
			$data['post_hr_sub_type_id']	= $post_hr_sub_type_id;
			$data['pre_level']		        = $pre_level;
			$data['post_level']		        = $post_level;	
			$data['pre_distcode']		= $distcode;
			$data['post_distcode']	    = $new_distcode;
			$data['pre_procode']		= $data['post_procode'] = $procode;
			$data['pre_tcode']			= $tcode;
			$data['post_tcode']		    = $new_tcode;;
			$data['pre_uncode']			= $uncode;
			$data['post_uncode']		= $new_uncode;
			$data['pre_facode']			= $facode;
			$data['post_facode']		= $new_facode;
			$data['created_date']	    = date('Y-m-d h:i:s');
			$data['created_by']		    = $_SESSION['username'];
			$data['updated_date']       = date('Y-m-d h:i:s');
			$data['updated_by']         = $_SESSION['username'];
			$this->db->insert('hr_db_history',$data);
			//in hr_db insert
			$data_insert['level']		    = $post_level;	
			$data_insert['hr_type_id']	    = $post_hr_type_id;
			$data_insert['hr_sub_type_id']	= $post_hr_sub_type_id;
			$data_insert['distcode']	    = $new_distcode;
			$data_insert['tcode']		    = $new_tcode;
			$data_insert['uncode']		    = $new_uncode;
			$data_insert['facode']		    = $new_facode;
			$this->db->where('code', $old_code);
			$this->db->update('hr_db',$data_insert);
		}
		if($this->input->post("status_type") == 'Post_Back')
		{
			$data['code']                = $old_code;
			$data['pre_status']			 = $status_type;
			$data['post_status']		 = 'Active';
			$data['status_date']	     = $status_date ;
			$data['pre_hr_type_id']		 = $hr_type_id;
			$data['post_hr_type_id']	 = $post_hr_type_id;
			$data['pre_hr_sub_type_id']  = $hr_sub_type_id;
			$data['post_hr_sub_type_id'] = $post_hr_sub_type_id;
			$data['pre_procode']		 = $data['post_procode'] = $procode;
			$data['pre_level']		     = $pre_level;
			$data['post_level']		     = $pre_level;		
			$data['pre_distcode']		 = $distcode;
			$data['post_distcode']		 = $new_distcode;
			$data['pre_tcode']			 = $tcode;
			$data['post_tcode']			 = $new_tcode;
			$data['pre_uncode']			 = $uncode;
			$data['post_uncode']		 = $new_uncode;
			$data['pre_facode']			 = $facode;
			$data['post_facode']		 = $new_facode; 
			$data['created_date']	     = date('Y-m-d h:i:s');
			$data['created_by']		     = $_SESSION['username'];
			$data['updated_date']        = date('Y-m-d h:i:s');
			$data['updated_by']          = $_SESSION['username'];
			$this->db->insert('hr_db_history',$data);
			//in hr_db insert
			$data_insert['level']		    = $post_level;	
			$data_insert['hr_type_id']	    = $post_hr_type_id;
			$data_insert['hr_sub_type_id']	= $post_hr_sub_type_id;
			$data_insert['distcode']	    = $new_distcode;
			$data_insert['tcode']		    = $new_tcode;
			$data_insert['uncode']		    = $new_uncode;
			$data_insert['facode']		    = $new_facode;
			$this->db->where('code', $old_code);
			$this->db->update('hr_db',$data_insert);
		}
			$this->db->trans_complete();
			
			
	}
	public function hr_status_del(){
		//echo 'abc'; exit();
		$code = $this->uri->segment(3);
		$status_date = $this->uri->segment(4);
		$status = $this->uri->segment(5);
		$status=urldecode($status);
	    $query = "select * from hr_db_history where code = '$code' order by id DESC LIMIT 1";
		$result1 = $this -> db -> query($query);
		$hrdata = $result1 -> result_array();
		$status_type = $hrdata[0]['pre_status']; 
		$last_id = $hrdata[0]['id']; 
		$this->db->trans_start(); 
		if($status_type == 'Transferred' || $status_type == 'Posted' || $status_type == 'Post_Back') 
		{
			$data_type = $this->db->query("SELECT * FROM hr_db_history where code = '$code' ORDER BY created_date DESC LIMIT 1")->row_array();
			$data_insert['hr_type_id']	    = $data_type['pre_hr_type_id'];
			$data_insert['hr_sub_type_id']	= $data_type['pre_hr_sub_type_id'];
			$data_insert['level']	        = $data_type['pre_level'];
			$data_insert['distcode']		= $data_type['pre_distcode'];
			$data_insert['tcode']			= $data_type['pre_tcode'];
			$data_insert['uncode']			= $data_type['pre_uncode'];
			$data_insert['facode']			= $data_type['pre_facode']; 
			$this->db->where('code', $code);
			$this->db->update('hr_db',$data_insert);
			//echo $this->db->last_query(); exit; 
		} 
		$this->db->trans_complete();
		$query = "DELETE from hr_db_history where (code = '$code' and status_date = '$status_date' and post_status = '$status' and id = '$last_id')";
		//print_r($query); exit();
		$result = $this -> db -> query($query);
		if($result)
		{
			$location = base_url(). "Hr_management/hr_list";
			echo '<script language="javascript" type="text/javascript"> alert("Record Succesfully Deleted....");	window.location="'.$location.'"</script>';
		}
	}
}//End of HR Managmenet model
