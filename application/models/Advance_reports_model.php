<?php
class Advance_reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper.php');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function HFMVRF_Advance_Report($data,$title){
		//print_r($data);exit;
		$wc = $data;
		if($this -> input -> post('export_excel')){
		unset($wc['_ga']);
		unset($wc['_gid']);
		unset($wc['ci_session']);
		unset($wc['export_excel']);
		}
		//print_r($wc);exit;
		/*if($this -> input -> post('export_excel'))
		{
			//echo "danish";exit;
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}*/
		$reportId = $data['report_id'];
		$this -> db -> select('report_title');
		$this -> db -> where(array('report_id'=>$reportId,'module_id'=>'3'));
		$repTitleName = $this -> db -> get('adv_reports') -> row();
		$repTitleName   =  $repTitleName -> report_title;
	    
		$this -> db -> select('adv_report_fields.*,epifieldstitle.description');
		$this -> db -> where(array('report_id'=>$reportId,'epifieldstitle.module_id'=>'3'));
		$this -> db -> join('epifieldstitle', 'adv_report_fields.field_id = epifieldstitle.fid');
		$allRptFields = $this -> db -> get ('adv_report_fields') -> result_array();
		//echo $this->db->last_query();exit;
		     $fields = '';$fieldssum = '';
		foreach($allRptFields as $oneField)
		{
			$fields .= 'sum('.$oneField['field_id'].') as "'.$oneField['description'].'",';
		}
		$fields = rtrim($fields,',');
		
		$groupBy = '';
		// Change Fmonth syntax from 02-2015 to 2015-02
		$fmonthFrom = $data['monthfrom'];
		$fmonthFrom = explode('-',$fmonthFrom);
		$month = $fmonthFrom[0];
		$year = $fmonthFrom[1];
		$fmonthFrom = $year.'-'.$month;
		$fmonthTo = $data['monthto'];
		$fmonthTo = explode('-',$fmonthTo);
		$month = $fmonthTo[0];
		$year = $fmonthTo[1];
		$fmonthTo = $year.'-'.$month;
		// remove fmonthFrom and fmonthTo from wc and add new ones
		unset($wc['monthfrom']);unset($wc['monthto']);unset($wc['report_id']);
		$wc['fmonth <='] = $fmonthTo;
		$wc['fmonth >='] = $fmonthFrom;
		//if(!$this->session->District)
		unset($wc['typewise']);
	//print_r($wc);exit;
		$report_table = "fac_mvrf_db";
		
		//print_r($data['typewise']);exit;
		if(isset($data['distcode'])){
			/*if(isset($data['distcode']) && $data['distcode']<0)
			{
				echo "dist";exit;
				$this -> db -> select('distcode as "Distcode", districtname(distcode) as "District Name", '.$fields);
				$this -> db -> group_by('distcode');
			}*/
			if ($data['typewise']=='fac')
			{
				//echo "fac";exit;
				$this -> db -> select('facode as "Facode", facilityname(facode) as "Facility Name", '.$fields);
				$this -> db -> group_by('facode');
			}
			else
			{
				//echo "uc";exit;
				$this -> db -> select('uncode as "Uncode", unname(uncode) as "UnionCouncil Name", '.$fields);
				$this -> db -> group_by('uncode');
				$this -> db ->order_by('unname(uncode)');
			}
		}
		else
		{
				//echo "dist";exit;
				$this -> db -> select('distcode as "Distcode", districtname(distcode) as "District Name", '.$fields);
				$this -> db -> group_by('distcode');
		}
	/*	elseif()
		{
			$this -> db -> select('uncode as "Uncode", unname(uncode) as "UnionCouncil Name", '.$fields);
			$this -> db -> group_by('uncode');
			$this -> db ->order_by(unname(uncode));
		}*/
		//echo $this->db->last_query();exit;
		//print_r($wc);exit;
		$this -> db -> where($wc);
		//unset($wc['distcode']);
		//unset($wc['uncode']);
		$allData = $this -> db -> get ($report_table) -> result_array();
		if($this -> input -> post('export_excel'))
		{
			//echo "danish";exit;
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Advance Report for EPI Vaccination.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['htmlData'] = getListingReportTable($allData,'');
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['exportIcons']= exportIcons($_REQUEST);
		return $data;
	} 
	
	function HFCR_Advance_Report($data,$title){
		/* print_r(
		$this->db->limit('50')->get('form_b_cr')->result_array());exit; */
		$value=$data['product'];
		//print_r($value); exit;
		unset($data['product']); 
		$wc = $data;
		
		if($this -> input -> post('export_excel'))
		{
			//echo "danish";exit;
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Advance Report for Consumption and Requisition.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$reportId = $data['report_id'];
		$this -> db -> select('report_title');
		$this -> db -> where(array('report_id'=>$reportId,'module_id'=>'7'));
		$repTitleName = $this -> db -> get('adv_reports') -> row();
		$repTitleName   =  $repTitleName -> report_title;
		
		$this -> db -> select('adv_report_fields.*,epifieldstitle.description');
		$this -> db -> where(array('report_id'=>$reportId,'epifieldstitle.module_id'=>'7'));
		$this -> db -> join('epifieldstitle', 'adv_report_fields.field_id = epifieldstitle.fid');
		$allRptFields = $this -> db -> get ('adv_report_fields') -> result_array();
		$fields = '';$fieldssum = '';
		$f7="f7";
		$f8="f8";
		$f9="f9";
		foreach($allRptFields as $oneField)
		{
			if(strpos($oneField['field_id'],$f7)|| strpos($oneField['field_id'],$f8) || strpos($oneField['field_id'],$f9)){
				
				//
			}
			else
			{
				$fields .= 'sum('.$oneField['field_id'].') as "'.$oneField['description'].'",';
			}
		}
		$fields = rtrim($fields,',');
		
		$groupBy = '';
		// Change Fmonth syntax from 02-2015 to 2015-02
		$fmonthFrom = $data['monthfrom'];
		$fmonthFrom = explode('-',$fmonthFrom);
		$month = $fmonthFrom[0];
		$year = $fmonthFrom[1];
		$fmonthFrom = $year.'-'.$month;
		$fmonthTo = $data['monthto'];
		$fmonthTo = explode('-',$fmonthTo);
		$month = $fmonthTo[0];
		$year = $fmonthTo[1];
		$fmonthTo = $year.'-'.$month;
		// remove fmonthFrom and fmonthTo from wc and add new ones
		unset($wc['monthfrom']);unset($wc['monthto']);unset($wc['report_id']);
		$wc['fmonth <='] = $fmonthTo;
		$wc['fmonth >='] = $fmonthFrom;
		unset($wc['typewise']);
		$report_table = "epi_consumption_master"; 
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			if ($data['typewise']=='fac'){
			$this -> db -> select('facode as "Facode", facilityname(facode) as "Facility Name", '.$fields);
			$this -> db -> group_by('facode');
			$this -> db -> order_by('facode');
		}
		else{
				//echo "uc";exit;
				$this -> db -> select('uncode as "Uncode", unname(uncode) as "UnionCouncil Name", '.$fields);
				$this -> db -> group_by('uncode');
		    }
		}
		else{
			$this -> db -> select('distcode as "Distcode", districtname(distcode) as "District Name", '.$fields);
			$this -> db -> group_by('distcode');
		}
		
		$this -> db -> where($wc);
		$this->db->where("epi_consumption_master.is_compiled",1);
		$this -> db -> where("item_id",$value);
		$this -> db -> join('epi_consumption_detail','epi_consumption_detail.main_id=epi_consumption_master.pk_id','left');
		//$this -> db -> join('epi_item_pack_sizes','epi_item_pack_sizes.pk_id=epi_consumption_detail.item_id','left');
		$allData = $this -> db -> get ($report_table) -> result_array();
		$data['product']=$value;
		$data['htmlData'] = getListingReportTable($allData,'');
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['exportIcons']= exportIcons($_REQUEST);
		return $data;
	} 
	//HRAdvancereport
	function HR_Advance_Report($data,$title){
		//print_r($data); exit;
		/* print_r( allData
		$this->db->limit('50')->get('form_b_cr')->result_array());exit; */
		//$wc = $data;
		//$wc = $data['distcode'];
		$UserLevel = $this -> session -> UserLevel;
		if($UserLevel==2){
			$procode = $this->session->Province;
			$wc[]= "post_procode = '".$procode."' ";
		}
		if(isset($data['distcode']) > 0){

			$wc[]= "post_distcode = '".$data['distcode']."'";
        } 
	    if(isset($data['tcode']) > 0){
			$wc[]= "post_tcode = '".$data['tcode'] ."'";
		}
		if(isset($data['type_id']) > 0){
			$wc[]= "post_hr_sub_type_id = '".$data['type_id'] ."'";
		}
		//print_r($wc); exit;
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		//print_r($where); exit();
		if($this -> input -> post('export_excel'))
		{
			//echo "danish";exit;
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HR Custom Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$reportId = $data['report_id'];
		$this -> db -> select('report_title');
		$this -> db -> where(array('report_id'=>$reportId,'module_id'=>'1'));
		$repTitleName = $this -> db -> get('adv_reports') -> row();
		$repTitleName   =  $repTitleName -> report_title;
		
		$this -> db -> select('adv_report_fields.*,epifieldstitle.description');
		$this -> db -> where(array('report_id'=>$reportId,'epifieldstitle.module_id'=>'1'));
		$this -> db -> join('epifieldstitle', 'adv_report_fields.field_id = epifieldstitle.fid');
		$allRptFields = $this -> db -> get ('adv_report_fields') -> result_array();
		//beta
		//echo "<pre>"; print_r($allRptFields); exit;
		$fields = '';$fieldssum = '';
		$f7="f7";
		$f8="f8";
		$f9="f9";
		foreach($allRptFields as $oneField)
		{
		//	echo "<pre>"; print_r($oneField);
			if(strpos($oneField['field_id'],$f7)|| strpos($oneField['field_id'],$f8) || strpos($oneField['field_id'],$f9)){
				
				//
			}
			else
			{
				if($oneField['field_id']=='bid'){
				  
				$fields .= 'bankname(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else{
					$fields .= '('.$oneField['field_id'].') as "'.$oneField['description'].'",';
				}
			}
		}
		$fields = rtrim($fields,',');
		$report_table="hr_db_history";
		$name="name"; 
		
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0)
		{   
			$query = 'SELECT codee as "HR Code",'.$name.' as "HR Name",getsubtypename(post_hr_sub_type_id) as "HR Type", '.$fields.', post_status  as "Status"
			FROM(SELECT DISTINCT ON (code) code  as codee, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery
			'.$where.'';
		}
		if(isset($procode))
		{   
			if(isset($data['distcode']) > 0){
				$query = 'SELECT codee as "HR Code",'.$name.' as "HR Name",getsubtypename(post_hr_sub_type_id) as "HR Type", '.$fields.',post_status  as "Status"
				FROM(SELECT DISTINCT ON (code) code  as codee, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery
				'.$where.'';
			}else{
				$query = 'SELECT post_distcode as "Distcode",districtname(post_distcode) as "District Name",codee as "HR Code",'.$name.' as "HR Name",getsubtypename(post_hr_sub_type_id) as "HR Type", '.$fields.',post_status as "Status"
				FROM(SELECT DISTINCT ON (code) code  as codee, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery
				'.$where.'';
				}
		}

		/* else{
			$this -> db -> select('distcode as "Distcode", districtname(distcode) as "District Name", '.$fields);
			//$this -> db -> group_by('distcode');
		} */
		
		//$this -> db -> where($wc);
		
		//$allData = $this -> db -> get ($report_table) -> result_array();
		$result=$this->db->query($query);
		$allData=$result->result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;  
		//echo "<pre>"; print_r($allData);exit;
		$data['htmlData'] = getListingReportTable($allData,'','NO');
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['exportIcons']= exportIcons($_REQUEST);
		return $data;
	} 
	 
	
	//DSAdvanceReport
	function Disease_Surveillance_Advance_Report($data,$title){
		//print_r($data); exit;
		$wc = $data;
		/* $procode=$this->session->Province;
		if(isset($data['distcode']) > 0){
        $wc = " distcode = '".$data['distcode']."' ";
        }else{
        $wc = " procode = '".$procode."' ";
         }
		$wc = " year = '".$data['year']."' "; */
		if($this -> input -> post('export_excel'))
		{
			//echo "danish";exit;
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Disease Surveillance Custom Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$reportId = $data['report_id'];
		$this -> db -> select('report_title,tbl_select');
		$this -> db -> where(array('report_id'=>$reportId,'module_id'=>'5'));
		$repTitleName = $this -> db -> get('adv_reports') -> row();
		$repTitlename   =  $repTitleName -> report_title;
		$value =  $repTitleName -> tbl_select;
		//print_r($value); exit;
		//$str = $this->db->last_query();
		//print_r($str); exit;
		
		/* $this -> db -> select("array_to_string(array_agg(field_id),',') as fields");
		$this -> db -> where(array('report_id'=>$reportId,'module_id'=>'5'));
		$fields = $allRptFields = $this -> db -> get('adv_report_fields') -> row()->fields; */
		
		
		
		$this -> db -> select('adv_report_fields.field_id,epifieldstitle.description');
		$this -> db -> from('adv_report_fields');
		$this -> db -> join('epifieldstitle','adv_report_fields.field_id = epifieldstitle.fid and adv_report_fields.sec_id = epifieldstitle.secid');
		$this -> db -> where(array('report_id'=>$reportId,'epifieldstitle.module_id'=>'5'));
		$allRptFields = $this -> db -> get() -> result_array();
		
		
		
		$fields = '';$fieldssum = '';
		$f7="f7";
		$f8="f8";
		$f9="f9";
		foreach($allRptFields as $oneField)
		{
			if(strpos($oneField['field_id'],$f7)|| strpos($oneField['field_id'],$f8) || strpos($oneField['field_id'],$f9)){
				
				//
			}
			else{
				if($oneField['field_id']=='patient_address_tcode'){
				        $fields .= 'tehsilname(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='patient_address_uncode'){
						$fields .= 'unname(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='patient_address_distcode'){
						$fields .= 'districtname(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='patient_address_procode'){
						$fields .= 'provincename(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='patient_gender'){ 
						$fields .= 'gendername(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='gender'){ 
						$fields .= 'gendernames(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else if($oneField['field_id']=='labresult_tobesentto'){ 
						$fields .= 'districtname(('.$oneField['field_id'].')) as "'.$oneField['description'].'",';
				}
				else{
				        $fields .= '('.$oneField['field_id'].') as "'.$oneField['description'].'",';
				}
			}
		}
		$fields = rtrim($fields,',');
		unset($wc['from_week']);
		unset($wc['datefrom']);
		unset($wc['to_week']);
		unset($wc['dateto']);
		unset($wc['report_id']); 
		
		
		if($value=='Measles'){
		     $report_table = "case_investigation_db";
			 $name="patient_name";
		}
		else if($value=='NNT'){
		    $report_table="nnt_investigation_form";
			$name="full_mother_name";
		}
		else if($value=='AFP'){
			$report_table="afp_case_investigation";
			$name="patient_name";
	    }
	     else if($value=='AEFI'){
			$report_table="aefi_rep";
			$name="casename"; 
		}
		 
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0)
		{
			$this -> db -> select(''.$name.' as "Name", '.$fields);
		}
				if(isset($procode))
		{
			$this -> db -> select(''.$name.' as "Name", '.$fields);
		}

		/* else{
			$this -> db -> select('distcode as "Distcode", districtname(distcode) as "District Name", '.$fields);
			$this -> db -> group_by('distcode');
		} */
		
		$this -> db -> where($wc);
		$allData = $this -> db -> get ($report_table) -> result_array();
		//print_r($allData); exit;
	    $data['htmlData'] = getListingReportTable($allData,'','NO');
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['exportIcons']= exportIcons($_REQUEST);
		return $data;
	} 
	
	
	//Delete HRAdvancereport
	public function report_delete($id){
		$get=$this->db->delete('adv_reports', array('report_id' => $id)); 
		return $get;
	}
	public function reportdata_delete($id){
		$get=$this->db->delete('adv_report_fields', array('report_id' => $id)); 
		return $get;
	}
	//Edit HRAdvancereport
	//Get HRAdvancereport Data
	public function get_report_title($report_id){
		$this->db->select('report_id,report_title');
		$this->db->from('adv_reports');
		$this->db->where('report_id',$report_id);
		$result = $this->db->get()->result_array();
		//print_r($result); exit;
		return $result;
	}
	public function get_report_data($report_id){
		$this->db->select('report_id,field_id,sec_id,report_fields_id');
		$this->db->from('adv_report_fields');
		$this->db->where('report_id',$report_id);
		$result = $this->db->get()->result_array();
		//print_r($result); exit;
		return $result;
	}
	public function get_fields_elements($value){
		$this->db->select('description,secid');
		$this->db->from('epi_sections');
		$this->db->where('module_id','5');
		$this->db->where('parent_dd_value',$value);
		$result = $this->db->get()->result_array();
        $resultone='';
		$resultone .= '<option value="0">-- Select --</option>';
		foreach($result as $oneSec)
		 { 
		  $resultone .= '<option value="'.$oneSec["secid"].'">'.$oneSec["description"].'</option>';
		 }
		echo $resultone;
	}
	
	
	
}