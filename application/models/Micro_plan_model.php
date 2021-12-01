<?php
//live
 class Micro_plan_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('epi_reports_helper');
	}
	public function supervisory_plan_edit($supervisorcode,$quarter,$fmonth){
		$fmonths=getMonthQuater($quarter);
		//print_r($fmonths); exit;
		$month1=$fmonths['monthm1'];
		$month2=$fmonths['monthm2'];
		$month3=$fmonths['monthm3'];
		$query = "select fmonth from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter'";
		$result = $this->db->query($query);	
		$data =	$result->result_array();
		$year= substr($data[0]['fmonth'],0,4); 
		$fmonth1=$year.'-'.$month1;
		$fmonth2=$year.'-'.$month2;
		$fmonth3=$year.'-'.$month3;
		//print_r($fmonth3); exit;
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,planned_date,is_conducted,remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth1'";
		$result = $this->db->query($query);	
		$data['m1'] =	$result->result_array();
		//return $data['m1'];
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,planned_date,is_conducted,remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth2'";
		$result = $this->db->query($query);	
		$data['m2'] =	$result->result_array();
		//return $data['m2'];
		//print_r($str); exit;
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,planned_date,is_conducted,remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth3'";
		$result = $this->db->query($query);	
		$data['m3'] =	$result->result_array();
		//return $data['m3'];
		return $data;
	}
	public function supervisory_plan_conducted($supervisorcode,$quarter,$fmonth){	
        $fmonths=getMonthQuater($quarter);
		//print_r($fmonths); exit;
		$month1=$fmonths['monthm1'];
		$month2=$fmonths['monthm2'];
		$month3=$fmonths['monthm3'];
		$query = "select fmonth from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter'";
		$result = $this->db->query($query);	
		$data =	$result->result_array();
		$year= substr($data[0]['fmonth'],0,4);
		$fmonth1=$year.'-'.$month1;
		$fmonth2=$year.'-'.$month2;
		$fmonth3=$year.'-'.$month3;
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,conduct_date,is_conducted,conduct_remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth1'";
		$result = $this->db->query($query);	
		$data['m1'] =	$result->result_array();
		//return $data['m1'];
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,conduct_date,is_conducted,conduct_remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth2'";
		$result = $this->db->query($query);	
		$data['m2'] =	$result->result_array();
		$query = "select id,supervisorcode,uncode,designation,fmonth,session_type,site_name,facode,conduct_date,is_conducted,conduct_remarks,submitted_date,area_name,quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth3'";
		$result = $this->db->query($query);	
		$data['m3'] =	$result->result_array();
		//return $data['m3'];
		return $data;		
	}
	public function supervisory_plan(){	
	    $distcode = $this-> session->District;
		$query = "select substring(fmonth,1,4) as year,supervisorcode,designation,quarter,status,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where distcode='$distcode' group by substring(supervisory_plan.fmonth,1,4),supervisorcode,quarter,designation,status order by supervisorcode asc";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$query = "SELECT distinct designation from supervisory_plan order by designation ASC";
		$Sup_result = $this -> db -> query($query);
		$data['resultSuper_type'] = $Sup_result -> result_array();
		return $data;	
	}
	public function supervisory_plan_view($supervisorcode,$quarter){	
		$fmonths=getMonthQuater($quarter);
		//print_r($fmonths); exit;
		$month1=$fmonths['monthm1'];
		$month2=$fmonths['monthm2'];
		$month3=$fmonths['monthm3'];
		$query = "select fmonth from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter'";
		$result = $this->db->query($query);	
		$data =	$result->result_array();
		$year= substr($data[0]['fmonth'],0,4); 
		$fmonth1=$year.'-'.$month1;
		$fmonth2=$year.'-'.$month2;
		$fmonth3=$year.'-'.$month3;
		//print_r($fmonth3); exit();
		//--------------------------------------------//
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Supervisory_Micro_Plan.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//--------------------------------------------//
		$query = "select *,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth1'";
		$result = $this->db->query($query);	
		$data['m1'] =	$result->result_array();
		//return $data['m1'];
		$query = "select *,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth2'";
		$result = $this->db->query($query);	
		$data['m2'] =	$result->result_array();
		//return $data['m2'];
		//print_r($str); exit;
		$query = "select *,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where supervisorcode='$supervisorcode' and quarter='$quarter' and fmonth='$fmonth3'";
		$result = $this->db->query($query);	
		$data['m3'] =	$result->result_array();
		//return $data['m3'];
		$data['exportIcons']=exportIcons_forViewForms($_REQUEST);
		return $data;	
	}
	
}