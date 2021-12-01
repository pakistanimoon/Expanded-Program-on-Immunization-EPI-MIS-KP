<?php
//beta
class Hr_reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('my_functions_helper');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('indicator_functions_helper');
		$this-> load-> helper('my_functions_helper');
		$this -> load -> model('Common_model');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= HR Summary Report Report Function Starts Here ========//
	function HR_Summary_Report($data){
		//print_r($data);exit; 
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HR_Summary_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$types = array();
		$wa = array(); 
		$status=$data['status'];
		if(array_key_exists("distcode", $data)){
			if($status=="Transferred" ||$status=="Posted"){
				$wa[] = "pre_distcode = '".$data['distcode']."'";
				$distcode = $data['distcode'];
			}else{
				$wa[] = "post_distcode = '".$data['distcode']."'";
				$distcode = $data['distcode'];
			}
		}
		if(array_key_exists("tcode", $data)){
			if($status=="Transferred" ||$status=="Posted"){
				$wa[] = "pre_tcode = '".$data['tcode']."'";
			}else{
				$wa[] = "post_tcode = '".$data['tcode']."'";
			}	
		}
		if(array_key_exists("uncode", $data)){
			if($status=="Transferred" ||$status=="Posted"){
				$wa[] = "pre_uncode = '".$data['uncode']."'";
			}else{
				$wa[] = "post_uncode = '".$data['uncode']."'";
			}
		}
		if(array_key_exists("facode", $data)){
			if($status=="Transferred" ||$status=="Posted"){;
				$wa[] = "pre_facode = '".$data['facode']."'";
			}else{
				$wa[] = "post_facode = '".$data['facode']."'";
			}
		}
		if(isset($data['type_id']) > 0){
			$id = $types = $data['type_id'];
			$id=$data['type_id'];
			$type_id = "'".implode("','",$id)."'";
			if($status=="Transferred" ||$status=="Posted"){
				$wa[] = "pre_hr_sub_type_id IN ($type_id)";
			}else{
				$wa[] = "post_hr_sub_type_id IN ($type_id)";
			}
			
		} 
		if(array_key_exists("status", $data)){
			if($status=="Transferred" ||$status=="Posted"){
				$type="pre";
				$wa[] = "pre_status = '".$data['status']."'";
			}else{
				$type="post";
				$wa[] = "post_status = '".$data['status']."'";
			}
		}
		$UserLevel = $this -> session -> UserLevel;
		//$wa[]= "post_status = 'Active'"; 
		$wherea = ((!empty($wa))? 'where '.implode(" AND ",$wa):' where');
		if($UserLevel==2){
			if(isset($distcode)){
				$query ='select mooninner.*,Count(*) Over (Partition By "Type") As total
				from (select codee as "Code",name as "Name",getlevel_name('.$type.'_level) as "Level",getsubtypename('.$type.'_hr_sub_type_id) as "Type",nic as "CNIC",phone as "Phone"
				,employee_type as "Employment Type",facilityname('.$type.'_facode) as "Health Facility",unname('.$type.'_uncode) as "Union Council",tehsilname('.$type.'_tcode) as "Tehsil",
				'.$type.'_status as "Status",getsubtypename('.$type.'_hr_sub_type_id) AS insiderow from (select DISTINCT ON (code) code as codee,* 
				from hr_db_history order by code DESC, id DESC)subquery '.$wherea.' order by '.$type.'_hr_sub_type_id) mooninner';
			    //echo $query;exit;
				$result=$this->db->query($query);
				$allData=$result->result_array();
				$subTitle ="HR Listing";
				$innerrowName = "HR"; 
				$data['subtitle']=$subTitle;
				$data['distcode']=$data['distcode'];
				unset ($data['type_id']);
				$data['report_table']=getListingReportTable($allData,$innerrowName,'No','NO','NO','NO',NULL,'No');
				$data['TopInfo'] = reportsTopInfo($subTitle, $data);
				$data['exportIcons']=exportIcons($_REQUEST);
			}else{
				$query = 'SELECT '.$type.'_distcode AS "distcode",districtname('.$type.'_distcode) AS "district",'.$type.'_hr_sub_type_id,COUNT(*) from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery 
						'.$wherea.'  group by '.$type.'_distcode,'.$type.'_hr_sub_type_id ORDER BY '.$type.'_distcode,'.$type.'_hr_sub_type_id ';
				//echo $query;exit;
				$result = $this -> db -> query($query);
				$data['hrdata'] = $result -> result_array();
				if(isset($data['type_id']) && is_array($data['type_id']) && count($data['type_id'])>0){
					unset($data['type_id']);
				}
				$subTitle = "HR Summary Report";
				$data['exportIcons'] = exportIcons($_REQUEST);
				$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			}
		}else{
			$query ='select mooninner.*,Count(*) Over (Partition By "Type") As total
				from (select codee as "Code",name as "Name",getlevel_name('.$type.'_level) as "Level",getsubtypename('.$type.'_hr_sub_type_id) as "Type",nic as "CNIC",phone as "Phone"
				,employee_type as "Employment Type",facilityname('.$type.'_facode) as "Health Facility",unname('.$type.'_uncode) as "Union Council",tehsilname('.$type.'_tcode) as "Tehsil",
				'.$type.'_status as "Status",getsubtypename('.$type.'_hr_sub_type_id) AS insiderow from (select DISTINCT ON (code) code as codee,* 
				from hr_db_history order by code DESC, id DESC)subquery '.$wherea.' order by '.$type.'_hr_sub_type_id) mooninner';
			//echo $query;exit;
			$result=$this->db->query($query);
			$allData=$result->result_array();
			$subTitle ="HR Listing";
			$innerrowName = "HR"; 
			$data['subtitle']=$subTitle;
			$data['distcode']=$data['distcode'];
			unset ($data['type_id']);
			$data['report_table']=getListingReportTable($allData,$innerrowName,'No','NO','NO','NO',NULL,'No');
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
		}
		$data['moonhrtypes']=$types;
		$data['moonhrstatus']=$status;
		return $data;
		
	}
	//======= HR Summary Report Report Function Starts Here ========//
	function HR_Summary_Report_Detail($data){
		//print_r($data); exit();
		$status=$data['status'];
		$status = str_replace('%20', ' ', $status);
		if($this -> session -> Tehsil){
			if($status=="Transferred" ||$status=="Posted"){
				$wc[] = "pre_tcode = '". $this -> session -> Tehsil . "'";
			}else{
				$wc[] = "post_tcode = '". $this -> session -> Tehsil . "'";
			}	
		}else{
			if($status=="Transferred" ||$status=="Posted"){
				$wc[]= "pre_distcode = '".$data['code']."'";
			}else{
				$wc[]= "post_distcode = '".$data['code']."'";
			}
			
		}
		if(isset($data['tcode']) > 0){
			if($status=="Transferred" ||$status=="Posted"){
				$wc[]= "pre_tcode = '".$data['tcode'] ."' ";
			}else{
				$wc[]= "post_tcode = '".$data['tcode'] ."' ";
			}
		}
		if(isset($data['uncode']) > 0){
			if($status=="Transferred" ||$status=="Posted"){
				$wc[]= "pre_uncode = '".$data['uncode'] ."'";
			}else{	
				$wc[]= "post_uncode = '".$data['uncode'] ."'";
			}
		}
		if(isset($data['facode']) > 0){
			if($status=="Transferred" ||$status=="Posted"){
				$wc[]= "pre_facode = '".$data['facode'] ."'";
			}else{	
				$wc[]= "post_facode = '".$data['facode'] ."'";
			}
		}
		if(isset($data['type_id']) > 0){
			$type_id=$data['type_id'];
			$id = explode ("_", $type_id);  
			$type_id = "'".implode("','",$id)."'";
			if($status=="Transferred" ||$status=="Posted"){
				$wc[] = "pre_hr_sub_type_id IN ($type_id)";
			}else{
				$wc[] = "post_hr_sub_type_id IN ($type_id)";
			}
		} 
		if(isset($data['status']) > 0){
			if($status=="Transferred" ||$status=="Posted"){
				$type="pre";
				$wc[]= "pre_status = '".$status ."'";
			}else{
				$type="post";
				$wc[]= "post_status = '".$status ."'";
			}
		}
		//$wc[]= "post_status = 'Active'"; 
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		$query ='select mooninner.*,Count(*) Over (Partition By "Type") As total
				from (select codee as "Code",name as "Name",getlevel_name('.$type.'_level) as "Level",getsubtypename('.$type.'_hr_sub_type_id) as "Type",nic as "CNIC",phone as "Phone"
				,employee_type as "Employment Type",facilityname('.$type.'_facode) as "Health Facility",unname('.$type.'_uncode) as "Union Council",tehsilname('.$type.'_tcode) as "Tehsil",
				'.$type.'_status as "Status",getsubtypename('.$type.'_hr_sub_type_id) AS insiderow from (select DISTINCT ON (code) code as codee,* 
				from hr_db_history order by code DESC, id DESC)subquery '.$where.' order by '.$type.'_hr_sub_type_id) mooninner';
		//echo $query;exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="HR Listing";
		$innerrowName = "HR"; 
		$data['subtitle']=$subTitle;
		$data['distcode']=$data['code'];
		unset ($data['type_id']);
		$data['report_table']=getListingReportTable($allData,$innerrowName,'No','NO','NO','NO',NULL,'No');
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= Retired HR Report Function Starts Here ========//
	function Retired_HR_Report($data, $title){
		//print_r($data);exit;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Retired_HR_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}		
		//print_r($hr_type);exit();
		$tablename="hr_db";
		$code="code";
		$wc = array();
		if(array_key_exists("type_id", $data)){
			$wc[] = "hr_sub_type_id = '". $data['type_id'] . "'";
		}
		if(array_key_exists("distcode", $data)){
			$wc[] = "distcode = '". $data['distcode'] . "'";
		}
		$tcode=$this -> session -> Tehsil;
		 if(isset($tcode) AND $tcode > 0){
			$wc[] = "tcode = '". $tcode . "'";
		}
		//print_r($wc); exit;
		$nwc = $wc;		
		//print_r($wc);exit();
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		//$whereInner = ((!empty($nwc))? 'where '.implode(" AND ",$nwc):'  ');
		$whereand = ((!empty($wc))? 'where '.implode(" AND ",$wc):' where ');
		$whereand .= ((!empty($wc))? 'AND ':'');
		//$where; exit();		
		$age = 'SELECT age(date_of_birth) as age from '.$tablename.'';
		$result=$this->db->query($age);
		$agelimit = $result->result_array();
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$query = 'SELECT '.$tablename.'.code as "HR Code", '.$tablename.'.name AS "HR Name",getsubtypename('.$tablename.'.hr_sub_type_id) AS "HR Type", 
			to_char(date_of_birth, \'DD-MM-YYYY\') AS "Date of Birth",
			age(date_of_birth) AS "HR Age",
			\'60 years\' AS "Retirement Age",
			to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') AS "Retirement Date",
			case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end  AS "Days Remaining to Retirement"
			FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.code, '.$tablename.'.name, '.$tablename.'.hr_sub_type_id, '.$tablename.'.date_of_birth';
			//print_r($query); exit;
			$result=$this->db->query($query); 
			$allData = $result->result_array();	
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','','NO');
		}
		else{
			$query = 'SELECT '.$tablename.'.distcode, districtname('.$tablename.'.distcode) AS "District",  
			(select count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode and age(date_of_birth) >= \'58 years\' and age(date_of_birth) < \'60 years\') AS "Total Employees Approaching Retirement Age",
			(select count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode and age(date_of_birth) >= \'60 years\') AS "Total Retired Employees ( Age >= 60 years)"
			FROM '.$tablename.' '.$where.' GROUP BY '.$tablename.'.distcode ORDER BY '.$tablename.'.distcode';
			//print_r($query); exit;
			$result=$this->db->query($query);
			$allData = $result->result_array();
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','');
		}
		return $data;
	}
	//======= Trainings_HR_Report Function Starts Here ========//
	function Trainings_HR_Report($title){
		//print_r($data);exit;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Trainings_HR_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$wc = array();
		$data['distcode']=$this -> session -> District;	
		if(array_key_exists("distcode", $data)){
			$wc[] = "hrdist.distcode = '". $data['distcode'] . "'";
		}
		if($this -> session -> Tehsil){
			$data['tcode']=$this -> session -> Tehsil;			
			$wc[] = "hrdist.tcode = '". $data['tcode'] . "'";			
		}
		$UserLevel = $this -> session -> UserLevel;
		$NoTrainingAttened='';
		$NoTrainingAttened="'No Training Attended'";
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		if($UserLevel==4){
			/* $query = 'SELECT types.id,hr.distcode AS "Distcode",districtname(hr.distcode) AS "District",types.name AS "Training Name",count(training_id) AS "Peoples Training" 
			FROM hr_trainings train join training_types types on types.id=train.training_id join hr_db hr on 
			hr.code=train.hr_code '.$where.' GROUP BY types.id,types.name,hr.distcode order by types.name'; */
			$query = 'select traintypes.id,traintypes.id,hrdist.distcode AS "Distcode",hrdist.district AS "District",hrdist.tcode,traintypes.name  as "Training Name",COALESCE(traintypes.name, '.$NoTrainingAttened.')  as "Training Name",
			count(*) as "Peoples Trainings" from
			(select dist.distcode,districtname(dist.distcode) district,hr.code,hr.tcode from districts dist full join hr_db hr on hr.distcode = dist.distcode) hrdist
			Full JOIN
			(select types.id,train.hr_code,train.training_id,types.name from training_types types full join hr_trainings train on types.id=train.training_id) traintypes on hrdist.code = traintypes.hr_code
			'.$where.'
			group by hrdist.distcode,hrdist.district,traintypes.name,traintypes.id,hrdist.tcode
			order by hrdist.distcode,traintypes.name';
			//print_r($query); exit;
			$result=$this->db->query($query); 
			$allData = $result->result_array();	
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','','NO');
		}
		if($UserLevel==3){
			/* $query = 'SELECT types.id,hr.distcode AS "Distcode",districtname(hr.distcode) AS "District",types.name AS "Training Name",count(training_id) AS "Peoples Training" 
			FROM hr_trainings train join training_types types on types.id=train.training_id join hr_db hr on 
			hr.code=train.hr_code '.$where.' GROUP BY types.id,types.name,hr.distcode order by types.name'; */
			$query = 'select traintypes.id,traintypes.id,hrdist.distcode AS "Distcode",hrdist.district AS "District",traintypes.name  as "Training Name",COALESCE(traintypes.name, '.$NoTrainingAttened.')  as "Training Name",
			count(*) as "Peoples Trainings" from
			(select dist.distcode,districtname(dist.distcode) district,hr.code from districts dist full join hr_db hr on hr.distcode = dist.distcode) hrdist
			Full JOIN
			(select types.id,train.hr_code,train.training_id,types.name from training_types types full join hr_trainings train on types.id=train.training_id) traintypes on hrdist.code = traintypes.hr_code
			'.$where.'
			group by hrdist.distcode,hrdist.district,traintypes.name,traintypes.id
			order by hrdist.distcode,traintypes.name';
			//print_r($query); exit;
			$result=$this->db->query($query); 
			$allData = $result->result_array();	
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','','NO');
		}
		if($this -> session -> Provnice || $UserLevel==2){ 
			$query = 'select traintypes.id,traintypes.id,hrdist.distcode AS "Distcode",hrdist.district AS "District",traintypes.name  as "Training Name",COALESCE(traintypes.name, '.$NoTrainingAttened.')  as "Training Name",
			count(*) as "Peoples Trainings" from
			(select dist.distcode,districtname(dist.distcode) district,hr.code from districts dist full join hr_db hr on hr.distcode = dist.distcode) hrdist
			Full JOIN
			(select types.id,train.hr_code,train.training_id,types.name from training_types types full join hr_trainings train on types.id=train.training_id) traintypes on hrdist.code = traintypes.hr_code
			group by hrdist.distcode,hrdist.district,traintypes.name,traintypes.id
			order by hrdist.distcode,traintypes.name';
			//print_r($query); exit; 
			$result=$this->db->query($query); 
			$allData = $result->result_array();	
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','','NO');
		}
		return $data;
	}
	//======= Trainings_HR_Report_Detail Function Starts Here ========//
	function Trainings_HR_Report_Detail($data){
		//print_r($data); exit();
		$distcode=$data['code'];
		//print_r($distcode);exit();
		$trainingtypes=$data['trainingtypes'];
		if(isset($distcode) AND $distcode > 0){
			$wc[]= "hr.distcode = '".$distcode."'";
		}
		if(isset($trainingtypes)){
			$wc[] = "types.id = '".$trainingtypes. "'";
		}
		if($this -> session -> Tehsil){		
			$data['tcode']=$this -> session -> Tehsil;			
			$wc[] = "hr.tcode = '". $data['tcode'] . "'";			
		}
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		$whereas = ((!empty($wc))? 'where code not in (select hr_code from hr_trainings) AND '.implode(" AND ",$wc):'  ');
		if(isset($data['code']) AND $data['code'] > 0   AND $data['trainingtypes'] == ''){
			$query = 'SELECT hr.name as "HR Name",getsubtypename(hr.hr_sub_type_id) as "HR Type", 
			hr.code as "HR Code",  hr.fathername as "Father Name", hr.employee_type as "Employee Type"
			FROM hr_db hr '.$whereas.''; 
		}else{
			//echo "aaa";
			$query = 'SELECT hr.name as "HR Name",getsubtypename(hr.hr_sub_type_id) as "HR Type", 
			hr.code as "HR Code",  hr.fathername as "Father Name", hr.employee_type as "Employee Type" 
			FROM hr_trainings train join training_types types on types.id=train.training_id join hr_db hr on 
			hr.code=train.hr_code '.$where.'';
		}
		$result=$this->db->query($query);
		$allData=$result->result_array();
		//print_r($allData);exit();
		$subTitle ="HR Trainings List";
		$data['subtitle']=$subTitle;
		$data['distcode']=$data['code'];
		//print_r($data);exit();
		$data['report_table']=getListingReportTable($allData,'','','NO');
		//print_r($data['report_table']);exit();
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		//print_r($data);exit();
		//print_r($data['TopInfo']);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
		public function hr_view_status($id)
	{
		$result[]="";
		
		//print_r($data['htmlData']);exit();
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
		$q="select hr_db_history .id, hr_db_history .pre_status,districtname(hr_db_history .pre_distcode) as predistcode,districtname(hr_db_history .post_distcode) as postdistcode,hr_db_history .post_status,hr_db_history .status_date,hr_db_history .code,hr_db.level from hr_db_history inner join hr_db on hr_db_history .code=hr_db.code where hr_db_history .code='$id' order by hr_db_history .id DESC";
        //print_r($q); exit();
		$res = $this -> db -> query($q);
		$hrstatus = $res -> result_array();
		$result['htmlData'] = getSectionsStatus($hrstatus);
		//print_r($result); exit;
		return $result;
	}
}
?>	