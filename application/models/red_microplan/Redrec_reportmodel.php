<?php
class Redrec_reportmodel extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	function redrec_Report($data){
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Red_Rec_Compilation.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		//Excel file code ENDS*******************
		$distcode = $data['distcode'];
		$quarter = $data['quarter'];
		$year = $data['year'];
		if($this->session->Tehsil){
			$tcode=$this->session->Tehsil;
			$wc = "and tcode = '$tcode' ";
		}else{
			$wc = "";
		}
		$query="select unname(uncode) as ucname,technicianname(techniciancode) as technicianname, case when session_type='Fixed' then facilityname(sitename_s) else sitename_s end  as sitename ,facode,* from hf_quarterplan_dates_db where distcode='$distcode' and quarter ='$quarter' and year='$year' $wc order by tcode,uncode,techniciancode,facode";
		$result = $this-> db-> query($query);	
		$data['data'] = $result-> result_array(); 
		$resultt['distcode']=$distcode;
		$resultt['quarter']=$quarter;
		$resultt['year']=$year;
		return $data;
	}	
} 
?>