<?php
class Error_reports_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	public function error_reports($report_to_load=NULL)
	{
		$post_data['procode']=$_SESSION["Province"];
		$distcode = ($this -> session -> District)?$this -> session -> District:"";
		if($this -> session -> District){
			$post_data['distcode']=$distcode;
		}
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".$report_to_load.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if($report_to_load == 'tehsils-with-zero-population'){
			$query="SELECT 	tehsil.distcode AS \"District Code\",districtname(tehsil.distcode) AS \"District Name\",tehsil.tcode as \"Tehsil Code\",tehsil.tehsil as \"Tehsil Name\",
			(SELECT count(uncode) FROM unioncouncil WHERE tcode=tehsil.tcode) AS \"No of UC's\",
			(SELECT count(facode) FROM facilities WHERE hf_type='e' AND  tcode=tehsil.tcode) AS \"Attached Facilities\",
			pop.population
			FROM 
			tehsil             			left join tehsil_population pop on tehsil.tcode = pop.tcode
			WHERE 
			pop.year = '".date('Y')."' and (pop.population is null OR pop.population < 1) AND tehsil.distcode='{$distcode}' ORDER BY districtname(tehsil.distcode),tehsilname(tehsil.tcode) ASC";
			$subTitle = "Tehsils With Zero Population";
		}
		else if($report_to_load == 'ucs-with-zero-population'){
			$query="SELECT 	unioncouncil.distcode AS \"District Code\",districtname(unioncouncil.distcode) AS \"District Name\",unioncouncil.uncode as \"UC Code\",unioncouncil.un_name as \"UC Name\",
			(SELECT count(facode) FROM facilities WHERE hf_type='e' AND  uncode=unioncouncil.uncode) AS \"Attached Facilities\",
			pop.population 
			FROM 
			unioncouncil 
			left join unioncouncil_population pop on unioncouncil.uncode = pop.uncode					WHERE 
			pop.year = '".date('Y')."' and (pop.population is null OR pop.population::integer < 1) AND unioncouncil.distcode='{$distcode}' ORDER BY districtname(unioncouncil.distcode),un_name ASC";
			$subTitle = "Union Councils With Zero Population";
		}
		else if($report_to_load == 'facilities-with-zero-population'){					
			$query="SELECT facilities.distcode AS \"District Code\",districtname(facilities.distcode) AS \"District Name\",facilities.facode AS \"Facility Code\",facilities.fac_name AS \"Facility Name\",
			(SELECT COUNT(*)  from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_hr_sub_type_id='01' AND  post_status='Active' and post_distcode='{$distcode}' 
			AND post_facode=facilities.facode) AS \"Attached Technicians\",
			pop.population AS \"Population\"
			FROM 
			facilities left join facilities_population pop on facilities.facode = pop.facode
			WHERE   
			hf_type='e' AND pop.year = '".date('Y')."' and (pop.population is null OR pop.population::integer < 1) AND getfstatus_vacc('" . date('Y') . "-" . date('m',strtotime('first day of previous months')) . "',facilities.facode)='F' AND  facilities.distcode='{$distcode}' ORDER BY districtname(facilities.distcode),fac_name ASC";
			$subTitle = "Facilities With Zero Population";
		}
		else if($report_to_load == 'duplicate-technician-records'){
			$query = "SELECT distcode AS \"District Code\",districtname(distcode) AS \"District Name\",name as \"Technician Name\",nic as \"CNIC\",facilityname(facode) as \"Facility\",tehsilname(tcode) as \"Tehsil\",unname(uncode) as \"UC\",catch_area_name as \"Catchment Area Name\",date_of_birth as \"DOB\" FROM hr_db 
				where 
					nic in (SELECT nic FROM hr_db where distcode='{$distcode}' AND hr_sub_type_id='01' GROUP BY nic HAVING COUNT(nic) > 1 )  order by nic,distcode";
			$subTitle ="Duplicate Technician Records";
		}
		else if($report_to_load == 'facilities-with-zero-technicians'){
			$query = "SELECT 
			distcode AS \"District Code\",districtname(distcode) AS \"District Name\",facode AS \"Facility Code\",fac_name AS \"Facility Name\",'0' AS \"Attached Technicians\" 
			FROM 
			facilities 
			WHERE 
			facode NOT IN (SELECT DISTINCT post_facode from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery  where post_status='Active' and post_hr_sub_type_id='01' and post_distcode='{$distcode}') 
			AND 
			hf_type = 'e' AND is_vacc_fac='1' AND distcode='{$distcode}'
			ORDER BY 
			districtname(distcode), fac_name ASC";
			$subTitle = "Facilities with Zero Technicians";
		}
		else if($report_to_load == 'ucs-with-no-attached-facilities'){
			$query = "select uncode,un_name,tehsilname(tcode) as \"Tehsil\",
			districtname(distcode) as \"District\",
			'0' as \"# of Attached Facilities\",
			population from unioncouncil
			where uncode not in (select uncode from facilities where hf_type='e') AND distcode='{$distcode}' order by districtname(distcode),un_name";
			$subTitle = "UnionCouncils with NO attached Facilities";
		}
		$result = $this -> db -> query($query);
		$data['allDataTotal'] = $result->result_array();
		$data['subtitle'] = $subTitle;
		$data['TopInfo'] = tableTopInfo($subTitle,$distcode);
		$data['exportIcons'] = exportIcons($post_data);
		$data['report_table'] = getListingReportTable($data['allDataTotal'],'','','NO');
		return $data;
	}
}