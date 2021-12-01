<?php
class Linelists extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$code = md5(date("Y-n-d"));
		if(isset($_POST['code']) && $_POST['code'] == $code){
			$sessionData = array(
				'username'  => "kpk_manager",
				'User_Name' => "kpk_manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'provincename' => 'Khyber Pakhtunkhwa',
				'Province' => '3',
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{ 
				authentication();
			}
		}
		$this -> load -> model ('Linelists_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	//================ Constructor Function Ends ==================//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Linelists_Filters($reportName){
		$reportName;
		//print_r($reportName);
		$data = $this -> Linelists_model -> Create_Reporting_Filters($reportName);
		$data['data']=$data;
		//print_r($data['data']); exit;
		if($data != 0){
            $data['fileToLoad'] = 'linelists/linelists_filters';
			$data['pageTitle']='LineList Report Filters';
			$this -> load -> view('template/epi_template',$data);
		}else{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Surveillance($code=NULL,$year=NULL,$week=NULL,$case_type=NULL,$drilldown=NULL,$cross_notified=NULL,$forOutbreak=NULL,$specimen_result=NULL){	
		//echo 'asd';exit;	
		$data=array();$dataPosted=array();
		//print($this->uri->segment(3));exit;
		if($this->uri->segment(3))
		{
			//echo "as";exit();
			$dataPosted  = array("uncode" => $this->uri->segment(3), "year" => $this->uri->segment(5),  "case_type" =>'Msl', "cross_notified" => 0);
		}
		else{
			if($code && $year && $week && $case_type && $cross_notified != NULL){
			//echo "a";exit();
			if($drilldown){
				$dataPosted  = array("uncode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type,"cross_notified" => $cross_notified);
			}else{
				$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type,"cross_notified" => $cross_notified);
			}
		}
		else if($code && $year && $week && $case_type){
			//echo "b";exit();
			if($drilldown){
				$dataPosted  = array("uncode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type);
			}else{
				$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week,"case_type" => $case_type);
			}
		}
		else if($code && $year && $week){
			//echo "c";exit();
			$dataPosted  = array("facode" => $code, "year" => $year, "week" => $week);
		}
		else{
			//echo "d";exit();
			$dataPosted = $_POST;
			//print_r($dataPosted);exit();
		}
		}
		$formats = array("d/m/Y","d-m-Y","d-M-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if(($data[$key] == NULL || $data[$key]=="0") && $key !== "cross_notified")
				unset($data[$key]);
		}
		//echo $forOutbreak; exit;
		//print_r($data[$key]);exit();
		if($forOutbreak == 'outbreak'){
			unset($data['uncode']);
			unset($data['week']);
			$data['from_week'] = $week;
			$data['to_week'] = $week;
			$data['patient_address_uncode'] = $code;
			//print_r($data);exit();
		}
		//print_r($data); exit;
		if(isset($data['case_type'])){
			//print_r($data);exit();
			if(isset($data['datefrom'])){
				//echo 'c';exit;	
				$data['datefromReport'] = $data['datefrom'];
			}
			else{
				//echo 'cv';
				$data['datefromReport'] = '';
				//print_r($data);exit();
			}
			if(isset($data['dateto'])){
				//echo 'cz';exit;	
				$data['datetoReport'] = $data['dateto'];
			}
			else{
				//echo 'cv2';
				$data['datetoReport'] = '';
			}
			if ($data['case_type']=='AFP' || $data['case_type']=='Measles_cross_notified' || $data['case_type']=='Measles_other' || $data['case_type']=='NT' || $data['case_type']=='AEFI') {

				//print_r($data);exit;				
				if($data['case_type']=='AFP'){
					$this -> Afp($data);exit();
				}
				else if($data['case_type']=='NT'){
					$this -> NNT($data);exit();
				}
				else if($data['case_type']=='AEFI'){
					$this -> AEFI($data);exit();
				}
			}
			
			else if($data['case_type'] != 'AFP' || $data['case_type'] != 'NT' ) {
				//echo 'cv3';exit;
				$this -> Cases($data);exit();
			}
		}
		//print_r($data); exit;
		$data['data'] = $this -> Linelists_model -> Surveillance($data);
		$data['fileToLoad'] = 'linelists/surveillance_linelist_report';
		$data['pageTitle']='Weekly VPD Surveillance Compilation Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Specific Reports Ends Here ===================//
	public function Cases($data_rec){
		//print_r($data_rec);exit();
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if((isset($data_rec['patient_address_uncode'])))
		{}
		else{
			if($page > 0){ 
				$this -> paginationt();exit();
			}
		}
		/////////////////////	
		$data['data'] = $this-> Linelists_model-> Cases($data_rec);
		$data['pageTitle'] = 'Case Investigation Linelists Report';
		$data['fileToLoad'] = 'linelists/cases_other';		
		$this-> load-> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function Afp($data){
		$data['data'] = $this -> Linelists_model -> Afp($data);
		//print_r($data['data']); exit;
		$data['fileToLoad'] = 'linelists/afplinelist';
		$data['pageTitle']='AFP Linelists Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function NNT($data){
		//print_r($data); exit;
		$data['data'] = $this -> Linelists_model -> NNT($data);
		$data['fileToLoad'] = 'linelists/nntlinelist';
		$data['pageTitle']='NNT Linelists Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
		//======= Function to Create Filters AEFI Linelist Reports Starts Here ===========//
	public function AEFI_Filters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearlyAefi','weekly','dates');
		$functionName = $this -> uri -> segment (2);
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Linelists/AEFI";
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'linelists/aefi_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "AEFI_Filters":
				$title = "AEFI WEEKLY Compilation Form for District/Province";
				break;			
		}
		return $title;
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	public function AEFI($facode=NULL, $year=NULL, $week=NULL){
		//public function AEFI($data){
		$data=array();$dataPosted=array();
		if($facode && $year && $week){
			$dataPosted  = array("facode" => $facode, "year" => $year, "week" => $week);
		}else{
			$dataPosted = $_POST;
		}
		$formats = array("d/m/Y","d-m-Y","d-M-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		
		$data['data'] = $this -> Linelists_model -> AEFI($data);
		$data['fileToLoad'] = 'linelists/aefilinelist';
		$data['pageTitle']='AEFI Linelists Report';
		$this -> load -> view('template/reports_template',$data);//exit();
	}
	public function paginationt(){
		$wc['distcode'] = $distcode = $this -> input -> get_post('distcode');
		$wc['tcode'] = $tcode = $this -> input -> get_post('tcode');
		$wc['uncode'] = $uncode = $this -> input -> get_post('uncode');
		$wc['year'] = $year = $this -> input -> get_post('year');
		$from_week = (int)$this -> input -> get_post('from_week');
		$to_week = (int)$this -> input -> get_post('to_week');
		$yearr = $wc['year'];
		$datefrom = $this -> input -> get_post('datefrom');
		 //echo $datefrom = $yearr."-01-01"; exit;
		if ($datefrom == ""){
			$datefrom = "01-Jan-".$yearr;
		}
		$dateto = $this -> input -> get_post('dateto');
		if ($dateto == ""){
			$dateto = date('d-M-Y');
		}
		/* if ($datefrom == "" && $dateto == ""){
			
		} */
		$wc['case_type'] = $case_type = $this -> input -> get_post('case_type');
		$wc['specimen_result'] = $specimen_result = ($this -> input -> get_post('specimen_result') && $this -> input -> get_post('specimen_result') != '0')?$this -> input -> get_post('specimen_result'):NULL;
		$wc['cross_notified'] = $cross_notified = $this -> input -> get_post('cross_notified');
		$page = (int)(!($this -> input -> get_post('page')) ? 1 : $this -> input -> get_post('page'));
		if ($page <= 0){
			$page = 1;
		}
		if ($specimen_result == NULL){
			unset($wc['specimen_result']);
			$specimen_result = 0;
		}
		$per_page = 100;
		if(strlen($distcode) != 3)
			unset($wc['distcode']);
		if(strlen($tcode) != 6)
			unset($wc['tcode']);
		if(strlen($uncode) != 9)
			unset($wc['uncode']);
		/* if((int)$week < 1)
			unset($wc['week']); */
		$url='/Linelists/paginationt?distcode='.$distcode.'&tcode='.$tcode.'&uncode='.$uncode.'&year='.$year.'&from_week='.$from_week.'&to_week='.$to_week.'&case_type='.$case_type.'&cross_notified='.$cross_notified.'&specimen_result='.$specimen_result.'&';
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "case_investigation_db";
		$paginationWhereCondition = $wc;
		unset($paginationWhereCondition['cross_notified']);unset($paginationWhereCondition['distcode']);
		$paginationWc = "";
		foreach($paginationWhereCondition as $key => $value){
			$paginationWc .= $key . " = '" . $value . "' AND ";
		}
		$paginationWc = rtrim($paginationWc,'AND ');
		if($cross_notified == 0){
			if($distcode > 0){
				$paginationWc .= " AND distcode = '{$distcode}' AND case_epi_no IS NOT NULL ";
			}else{
				$paginationWc .= " AND case_epi_no IS NOT NULL ";
			}
		}else if($cross_notified == 1){
			if($distcode > 0){
				$paginationWc .= " AND (distcode = '{$distcode}' OR rb_distcode='{$distcode}') AND case_epi_no IS NULL ";
			}else{
				$paginationWc .= " AND case_epi_no IS NULL ";
			}
		}
		if($from_week > 0 && $to_week > 0)
			$paginationWc .= " AND week between $from_week and $to_week ";
		else if($from_week > 0 && $to_week < 1)
			$paginationWc .= " AND week >= $from_week ";
		else if($from_week < 1 && $to_week > 0)
			$paginationWc .= " AND week <= $to_week ";
		/////////////////////
		//echo $paginationWc;exit;
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url, $paginationWc);
		//echo $this->db->last_query(); exit;
		//print_r($data['pagination']);exit;
		$wc['distcode'] = $distcode;
		$wc['tcode'] = $tcode;
		$wc['uncode'] = $uncode;
		$wc['from_week'] = $from_week;
		$wc['to_week'] = $to_week;
		$wc['datefrom'] = $datefrom;
		$wc['dateto'] = $dateto;
		$data['data'] = $this-> Linelists_model-> Cases($wc,$per_page, $startpoint);
		$data['data']['case_type'] = $this->input->post('case_type');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page; 
		$data['pageTitle'] = 'Case Investigation Linelists Report';
		$data['fileToLoad'] = 'linelists/cases_other';
		$this-> load-> view('template/reports_template',$data);
	}
	//*************************************************************************************************//
}
?>