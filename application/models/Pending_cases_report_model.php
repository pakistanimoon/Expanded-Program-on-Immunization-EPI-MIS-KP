<?php
//class Pending_cases_report_model starts
class Pending_cases_report_model extends CI_Model {
	//================ Constructor function starts================//
	public function __construct() {
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> model('Filter_model');
		$this-> load-> helper('epi_reports_helper');
	}
	//================ Constructor function ends==================//
	//================ Pending_cases_report function starts======================//
	public function Pending_cases_report($data){
		//print_r($data);exit();
		$year = $data['year'];
		//echo $year; exit();
		$procode = $_SESSION['Province'];
		//$wc_pro = " AND procode = '".$procode."' AND fweek >= '$year-01' AND fweek <= '$year-53'" ;
		$wc_pro = " AND procode = '".$procode."' AND year = '$year'" ;
		$query = "SELECT distcode, district from districts " . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '') . " order by distcode";
		//echo $query; exit();
		$resultDist = $this -> db -> query($query);
		
		//////////////////////////////////Cases Query////////////////////////////////////
		//echo
		$mslCasesQuery = "(SELECT count(*) AS \"Measles Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Msl' AND approval_status='Pending' {$wc_pro} AND cidb.distcode = districts.distcode AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$mslCasesSUM = "(SELECT count(*) AS \"Measles Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Msl' AND approval_status='Pending' {$wc_pro} AND substring(cidb.distcode,1,1) = '$procode' AND cidb.cross_notified_from_distcode != cidb.distcode AND (cidb.cross_notified_from_distcode != cidb.distcode AND cidb.rb_distcode != cidb.distcode) GROUP BY districts.procode";
		//exit();
		//echo
		$diphCasesQuery = "(SELECT count(*) AS \"Diphtheria Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Diph' AND approval_status='Pending' {$wc_pro} AND cidb.distcode = districts.distcode AND substring(cidb.distcode,1,1) = '$procode' AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo		
		$diphCasesSUM = "(SELECT count(*) AS \"Diphtheria Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Diph' AND approval_status='Pending' {$wc_pro} AND substring(cidb.distcode,1,1) = '$procode' AND cidb.cross_notified_from_distcode != cidb.distcode AND (cidb.cross_notified_from_distcode != cidb.distcode AND cidb.rb_distcode != cidb.distcode) GROUP BY districts.procode";
		//
		//exit();
		//echo 
		$afpCasesQuery = "(SELECT count(*) AS \"AFP Cases  \" FROM afp_case_investigation afp WHERE approval_status='Pending' {$wc_pro} AND afp.distcode = districts.distcode AND (afp.cross_notified_from_distcode != districts.distcode OR afp.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$afpCasesSUM = "(SELECT count(*) AS \"AFP Cases  \" FROM afp_case_investigation afp WHERE approval_status='Pending' {$wc_pro} AND substring(afp.distcode,1,1) = '$procode' AND afp.cross_notified_from_distcode != afp.distcode AND (afp.cross_notified_from_distcode != afp.distcode AND afp.rb_distcode != afp.distcode) GROUP BY districts.procode";
		//exit();
		//echo 
		$nntCasesQuery = "(SELECT count(*) AS \"NNT Cases  \" FROM nnt_investigation_form nnt WHERE approval_status='Pending' {$wc_pro} AND nnt.distcode = districts.distcode AND (nnt.cross_notified_from_distcode != districts.distcode OR nnt.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$nntCasesSUM = "(SELECT count(*) AS \"NNT Cases  \" FROM nnt_investigation_form nnt WHERE approval_status='Pending' {$wc_pro} AND substring(nnt.distcode,1,1) = '$procode' AND nnt.cross_notified_from_distcode != nnt.distcode AND (nnt.cross_notified_from_distcode != nnt.distcode AND nnt.rb_distcode != nnt.distcode) GROUP BY districts.procode";
		//exit();
		//echo
		$mainCasesQuery = "(SELECT count(*) AS \"Other Diseases  \" FROM case_investigation_db cidb WHERE (case_type != 'Msl' AND case_type != 'Diph') AND approval_status='Pending' {$wc_pro} AND cidb.distcode = districts.distcode AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$mainCasesSUM = "(SELECT count(*) AS \"Other Diseases  \" FROM case_investigation_db cidb WHERE (case_type != 'Msl' AND case_type != 'Diph') AND approval_status='Pending' {$wc_pro} AND substring(cidb.distcode,1,1) = '$procode' AND cidb.cross_notified_from_distcode != cidb.distcode AND (cidb.cross_notified_from_distcode != cidb.distcode AND cidb.rb_distcode != cidb.distcode) GROUP BY districts.procode";
		//exit();
		//$data['mergedQuery'] = array_merge($mslCasesQuery,$diphCasesQuery,$afpCasesQuery,$nntCasesQuery,$mainCasesQuery);
		////////////////////////////////Query to get Results///////////////////////////////////////
		//echo 
		$query = 'SELECT distcode, district,  ' . $mslCasesQuery . ' ),'. $diphCasesQuery . ' ),'. $afpCasesQuery . ' ),'. $nntCasesQuery . ' ),'. $mainCasesQuery . ' ) from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : ''). " order by district";
		//exit();
		$result = $this -> db -> query($query) -> result_array();
		
		//echo 
		$query1 = 'SELECT ' . $mslCasesSUM . ' ),'. $diphCasesSUM . ' ),'. $afpCasesSUM . ' ),'. $nntCasesSUM . ' ),'. $mainCasesSUM . ' ) from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : ''). " group by procode";
		//exit();
		$result1 = $this -> db -> query($query1) -> result_array();
		//print_r($result1);
		//$result = getListingReportTable($result,NULL,NULL,NULL,NULL,NULL,NULL,'yes');
		$result = getPendingCasesReportTable($result,$result1,NULL,NULL,NULL,NULL,NULL,'yes');
		$dataReturned['report_table'] = $result;
		$pageTitle = "Pending Cross Notified Cases Report";
		$dataReturned['subtitle'] = $pageTitle;
		$dataReturned['TopInfo'] = tableTopInfo($pageTitle,'','',$year);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['year'] = $year;
		return $dataReturned;
		//exit();
		
	}	
}
//class Sanctionedposts_report_model ends