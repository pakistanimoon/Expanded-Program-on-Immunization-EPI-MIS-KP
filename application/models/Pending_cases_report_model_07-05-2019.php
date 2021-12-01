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
	public function Pending_cases_report($neWc){
		$procode = $_SESSION['Province'];
		$query = "SELECT distcode, district from districts " . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '') . " order by distcode";
		$resultDist = $this -> db -> query($query);
		
		//////////////////////////////////Cases Query////////////////////////////////////
		//echo
		$mslCasesQuery = "(SELECT count(*) AS \"Measles Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Msl' AND approval_status='Pending' AND cidb.distcode = districts.distcode AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$mslCasesSUM = "(SELECT count(*) AS \"Measles Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Msl' AND approval_status='Pending' AND substring(cidb.distcode,1,1) = '$procode' AND cidb .cross_notified_from_distcode != cidb .distcode AND (substring(cidb.cross_notified_from_distcode,1,1) = '$procode' OR substring(cidb.cross_notified_from_distcode,1,1) != '$procode') AND (substring(cidb.rb_distcode,1,1) = '$procode' OR substring(cidb.rb_distcode,1,1) != '$procode') GROUP BY districts.procode";
		//exit();
		//echo
		$diphCasesQuery = "(SELECT count(*) AS \"Diphtheria Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Diph' AND approval_status='Pending' AND cidb.distcode = districts.distcode AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//echo
		$diphCasesSUM = "(SELECT count(*) AS \"Diphtheria Cases  \" FROM case_investigation_db cidb WHERE case_type = 'Diph' AND approval_status='Pending' AND substring(cidb.distcode,1,1) = '$procode' AND cidb .cross_notified_from_distcode != cidb .distcode AND (substring(cidb.cross_notified_from_distcode,1,1) = '$procode' OR substring(cidb.cross_notified_from_distcode,1,1) != '$procode') AND (substring(cidb.rb_distcode,1,1) = '$procode' OR substring(cidb.rb_distcode,1,1) != '$procode') GROUP BY districts.procode";
		//exit;
		//echo 
		$afpCasesQuery = "(SELECT count(*) AS \"AFP Cases  \" FROM afp_case_investigation afp WHERE approval_status='Pending' AND afp.distcode = districts.distcode AND (afp.cross_notified_from_distcode != districts.distcode OR afp.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		$afpCasesSUM = "(SELECT count(*) AS \"AFP Cases  \" FROM afp_case_investigation afp WHERE approval_status='Pending' AND substring(afp.distcode,1,1) = '$procode' AND afp .cross_notified_from_distcode != afp .distcode AND (substring(afp.cross_notified_from_distcode,1,1) = '$procode' OR substring(afp.cross_notified_from_distcode,1,1) != '$procode') AND (substring(afp.rb_distcode,1,1) = '$procode' OR substring(afp.rb_distcode,1,1) != '$procode') GROUP BY districts.procode";
		//echo 
		$nntCasesQuery = "(SELECT count(*) AS \"NNT Cases  \" FROM nnt_investigation_form nnt WHERE approval_status='Pending' AND nnt.distcode = districts.distcode AND (nnt.cross_notified_from_distcode != districts.distcode OR nnt.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		//echo
		$nntCasesSUM = "(SELECT count(*) AS \"NNT Cases  \" FROM nnt_investigation_form nnt WHERE approval_status='Pending' AND substring(nnt.distcode,1,1) = '$procode' AND nnt .cross_notified_from_distcode != nnt .distcode AND (substring(nnt.cross_notified_from_distcode,1,1) = '$procode' OR substring(nnt.cross_notified_from_distcode,1,1) != '$procode') AND (substring(nnt.rb_distcode,1,1) = '$procode' OR substring(nnt.rb_distcode,1,1) != '$procode') GROUP BY districts.procode";
		//exit();
		//echo
		$mainCasesQuery = "(SELECT count(*) AS \"Other Diseases  \" FROM case_investigation_db cidb WHERE (case_type != 'Msl' AND case_type != 'Diph') AND approval_status='Pending' AND cidb.distcode = districts.distcode AND (cidb.cross_notified_from_distcode != districts.distcode OR cidb.rb_distcode != districts.distcode) GROUP BY districts.distcode ORDER BY districts.district ASC";
		//exit();
		$mainCasesSUM = "(SELECT count(*) AS \"Other Diseases  \" FROM case_investigation_db cidb WHERE (case_type != 'Msl' AND case_type != 'Diph') AND approval_status='Pending' AND substring(cidb.distcode,1,1) = '$procode' AND cidb .cross_notified_from_distcode != cidb .distcode AND (substring(cidb.cross_notified_from_distcode,1,1) = '$procode' OR substring(cidb.cross_notified_from_distcode,1,1) != '$procode') AND (substring(cidb.rb_distcode,1,1) = '$procode' OR substring(cidb.rb_distcode,1,1) != '$procode') GROUP BY districts.procode";
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
		
		//$result = getListingReportTable($result,NULL,NULL,NULL,NULL,NULL,NULL,'yes');
		$result = getPendingCasesReportTable($result,$result1,NULL,NULL,NULL,NULL,NULL,'yes');
		$dataReturned['report_table'] = $result;
		$pageTitle = "Pending Cross Notified Cases Report";
		$dataReturned['subtitle'] = $pageTitle;
		$dataReturned['TopInfo'] = tableTopInfo($pageTitle);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//$dataReturned['data'] = $postedData;
		return $dataReturned;
		//exit();
		
	}	
}
//class Sanctionedposts_report_model ends