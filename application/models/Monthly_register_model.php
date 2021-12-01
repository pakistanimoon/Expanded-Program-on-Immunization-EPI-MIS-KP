<?php
class Monthly_register_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function monthly_report($data){
		//print_r($data); exit;
		$datefrom=$data['datefrom'];
		//$facode=$data['facode'];
		$query="select submitteddate, 
				sum(case when bcg::text like '2019-04%' or bcg_facode='701049' then 1 else 0 end) as bcg,
				sum(case when hepb::text like '2019-04%' or hepb_facode='701049' then 1 else 0 end) as hepb,
				sum(case when opv0::text like '2019-04%' or opv0_facode='701049' then 1 else 0 end) as opv0,
				sum(case when opv1::text like '2019-04%' or opv1_facode='701049' then 1 else 0 end) as opv1,
				sum(case when opv2::text like '2019-04%' or opv2_facode='701049' then 1 else 0 end) as opv2,
				sum(case when opv3::text like '2019-04%' or opv3_facode='701049' then 1 else 0 end) as opv3,
				sum(case when penta1::text like '2019-04%' or penta1_facode='701049' then 1 else 0 end) as penta1,
				sum(case when penta2::text like '2019-04%' or penta2_facode='701049' then 1 else 0 end) as penta2,
				sum(case when penta3::text like '2019-04%' or penta3_facode='701049' then 1 else 0 end) as penta3,
				sum(case when pcv1::text like '2019-04%' or pcv1_facode='701049' then 1 else 0 end) as pcv1,
				sum(case when pcv2::text like '2019-04%' or pcv2_facode='701049' then 1 else 0 end) as pcv2,
				sum(case when pcv3::text like '2019-04%' or pcv3_facode='701049' then 1 else 0 end) as pcv3,
				sum(case when ipv::text like '2019-04%' or ipv_facode='701049' then 1 else 0 end) as ipv,
				sum(case when rota1::text like '2019-04%' or rota1_facode='701049' then 1 else 0 end) as rota1,
				sum(case when rota2::text like '2019-04%' or rota2_facode='701049' then 1 else 0 end) as rota2,
				sum(case when measles1::text like '2019-04%' or measles1_facode='701049' then 1 else 0 end) as measles1,
				sum(case when measles2::text like '2019-04%' or measles2_facode='701049' then 1 else 0 end) as measles2
				from cerv_child_registration where submitteddate::text like '2019-04%' group by submitteddate order by submitteddate asc";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
	}
	//--------------------------------------------------------------------------------//	
}