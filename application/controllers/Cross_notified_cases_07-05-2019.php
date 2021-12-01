<?php
class Cross_notified_cases extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
		$this -> load -> model ('Case_investigation_model');
		$this -> load -> model ('Common_model');
		$this -> load -> library('breadcrumbs');
		//$this->load->library('form_validation');
	}
	////////////////////////// FIRST Function ///////////////////////////////////////////////
	
	//------------------------------------ Case Investigation -----------------------------------------//
	//-------------------------------------------------------------------------------------------------//
	
	public function Cross_notified_cases_list(){
		if($this -> uri -> segment(3) != ''){
			$distcode = $this -> uri -> segment(3);
		}
		else{
			$distcode = $_SESSION['District'];
		}		
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){ 
			$page = 1;
		}
		
		//echo
		$mslCasesQuery = "SELECT fweek, count(*) AS msl_cases FROM case_investigation_db WHERE case_type = 'Msl' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY fweek ORDER BY fweek ASC";
		//exit();
		$result = $this-> db -> query($mslCasesQuery);
		$msquery = $result -> result_array();
		$data['mslCases'] = $msquery;

		//echo
		$mslCasesSUM = "SELECT count(*) AS msl_cases FROM case_investigation_db WHERE case_type = 'Msl' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
		//exit();
		$result = $this-> db -> query($mslCasesSUM);
		$msquery = $result -> result_array();
		$data['mslCasesSUM'] = $msquery;

		$diphCasesQuery = "SELECT fweek, case_type, count(*) AS diph_cases FROM case_investigation_db WHERE case_type = 'Diph' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY fweek, case_type ORDER BY fweek ASC";
		//exit();
		$result = $this-> db -> query($diphCasesQuery);
		$msquery = $result -> result_array();
		$data['diphCases'] = $msquery;

		$diphCasesSUM = "SELECT count(*) AS diph_cases FROM case_investigation_db WHERE case_type = 'Diph' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
		//exit();
		$result = $this-> db -> query($diphCasesSUM);
		$msquery = $result -> result_array();
		$data['diphCasesSUM'] = $msquery;		

		//echo 
		$afpCasesQuery = "SELECT distcode, year, fweek, count(*) AS afp_cases FROM afp_case_investigation WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode,year,fweek ORDER BY fweek ASC";
		//exit();
		$result = $this-> db -> query($afpCasesQuery);
		$afpquery = $result -> result_array();
		$data['afpCases'] = $afpquery;

		//echo 
		$afpCasesSUM = "SELECT count(*) AS afp_cases FROM afp_case_investigation WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
		//exit();
		$result = $this-> db -> query($afpCasesSUM);
		$afpquery = $result -> result_array();
		$data['afpCasesSUM'] = $afpquery;

		//echo 
		$nntCasesQuery = "SELECT distcode, year, fweek, count(*) AS nnt_cases FROM nnt_investigation_form WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode,year,fweek ORDER BY fweek ASC";
		//exit();
		$result = $this-> db -> query($nntCasesQuery);
		$nntquery = $result -> result_array();
		$data['nntCases'] = $nntquery;

		//echo 
		$nntCasesSUM = "SELECT count(*) AS nnt_cases FROM nnt_investigation_form WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
		//exit();
		$result = $this-> db -> query($nntCasesSUM);
		$nntquery = $result -> result_array();
		$data['nntCasesSUM'] = $nntquery;

		$mainCasesQuery = "SELECT fweek, count(*) AS other_cases FROM case_investigation_db WHERE case_type != 'Msl' AND case_type != 'Diph' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY fweek ORDER BY fweek ASC";
		//exit();
		$result = $this-> db -> query($mainCasesQuery);
		$mcquery = $result -> result_array();
		$data['mainCases'] = $mcquery;

		$mainCasesSUM = "SELECT count(*) AS other_cases FROM case_investigation_db WHERE case_type != 'Msl' AND case_type != 'Diph' AND approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
		//exit();
		$result = $this-> db -> query($mainCasesSUM);
		$mcquery = $result -> result_array();
		$data['mainCasesSUM'] = $mcquery;

		$mergedDataQuery = "SELECT a.distcode,a.fweek,a.cases,a.case_type,b.afp_cases, c.nnt_cases FROM 
								(SELECT case_type,distcode,fweek,count(*) AS cases FROM case_investigation_db WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode,fweek,case_type) AS a LEFT OUTER JOIN 
								(SELECT distcode,fweek,count(*) AS afp_cases FROM afp_case_investigation WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode,fweek) AS b on a.distcode = b.distcode LEFT OUTER JOIN
								(SELECT distcode,fweek,count(*) AS nnt_cases FROM nnt_investigation_form WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode,fweek) AS c on a.distcode = c.distcode ORDER BY a.fweek";
		//print_r($data['nntCases']);exit();
		$result = $this-> db -> query($mergedDataQuery);
		$mergedData = $result -> result_array();
		//$data['mergedQuery'] = $mergedData;
		$data['mergedQuery'] = array_merge($data['mslCases'],$data['diphCases'],$data['afpCases'],$data['nntCases'],$data['mainCases']);
		//print_r($data['mergedQuery']);exit();
		//print_r(array_merge($data['mainCases'],$data['afpCases']));exit();
		//$data['startpoint'] = $startpoint;
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['edit']="Yes";
		if($data != 0){
			$data['data']=$data;
			$data['fileToLoad'] = 'cross_notified_cases_list';
			$data['pageTitle']='Pending Cross Notified Cases | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		else{
			$data['message'] ="You must have rights to access this page.";
			$this -> load -> view ('message',$data);
		}
	}
}
?>