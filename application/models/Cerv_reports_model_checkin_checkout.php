<?php
class Cerv_reports_model_checkin_checkout extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function CERV_PVR($data){
		//echo "junaid";exit;
		// $whereFmonth = " submitted_date::text BETWEEN '" . $data['datefrom'] . "-01' AND '" . date("Y-m-t", strtotime($data['dateto'])) . "'";		
		//$whereFmonth = " submitted_date::text BETWEEN '" . $data['datefrom'] . "' AND '" . date("Y-m-t", strtotime($data['dateto'])) . "'";		
		$whereFmonth = " CAST(checkin_date AS TEXT) LIKE  '" . $data['monthfrom'] . "%' ";		
		$whereCondition = "";
		if(isset($data['distcode']) && $data['distcode'] > 0){
			$whereCondition.="epi_childreg.distcode='".$data['distcode']."' and";
			$distcode = $data['distcode'];
		}
		if(isset($data['tcode']) && $data['tcode'] > 0)
		{
			$whereCondition.=" epi_childreg.tcode='".$data['tcode']."' and";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0)
		{
			$whereCondition.=" epi_childreg.uncode='".$data['uncode']."' and";
		}
		if(isset($data['vaccinator']) && $data['vaccinator'] > 0){
			$this -> db -> select('iemi_no,technicianname');
			$this -> db -> where('techniciancode',$data['vaccinator']);
			$technian = $this -> db -> get('techniciandb') -> row_array();
			$technianIEMI = $technian['iemi_no'];
			$data['vaccinatorname'] = $technian['technicianname'];
			$whereCondition.=" epi_childreg.iemi='".$technianIEMI."' and";
		}
		//$whereCondition = rtrim($whereCondition,"and");
		if(isset($data['distcode']) && $data['distcode'] > 0){
			$query = "
				SELECT 
					facilityname(techniciandb.facode),vacc_attend.vacc_code,vacc_attend.latitude,
				 vacc_attend.longitude,vacc_attend.checkin_date,vacc_attend.checkout_date,vacc_attend.checkin_time, 
				 vacc_attend.checkout_time, techniciandb.technicianname FROM vacc_attend  INNER JOIN techniciandb ON 
				 vacc_attend.vacc_code=techniciandb.techniciancode 
				 WHERE {$whereFmonth}";
		}
		else{
			$query = "
				 SELECT districtname(techniciandb.distcode),vacc_attend.vacc_code,vacc_attend.latitude,
				 vacc_attend.longitude,vacc_attend.checkin_date,vacc_attend.checkout_date,vacc_attend.checkin_time, 
				 vacc_attend.checkout_time, techniciandb.technicianname FROM vacc_attend  INNER JOIN techniciandb ON 
				 vacc_attend.vacc_code=techniciandb.techniciancode 
				 WHERE {$whereFmonth}";
		}
		//echo $query;exit;
		$dataReturned['PVRresult'] = $this -> db -> query($query) -> result_array();
		$subTitle = "Monthly CheckIn-Checout Report";
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