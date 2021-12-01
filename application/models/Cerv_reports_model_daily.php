<?php
class Cerv_reports_model_daily extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function CERV_PVR($data){
		
		// $whereFmonth = " submitted_date::text BETWEEN '" . $data['datefrom'] . "-01' AND '" . date("Y-m-t", strtotime($data['dateto'])) . "'";		
		//$whereFmonth = " submitted_date::text BETWEEN '" . $data['datefrom'] . "' AND '" . date("Y-m-t", strtotime($data['dateto'])) . "'";		
		$whereFmonth = " submitted_date ='" . $data['datefrom'] . "' ";		
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
					facilityname(techniciandb.facode),epi_childreg.childcode, epi_childreg.name_of_child,
					epi_childreg.father_name||'/Pakistan' as fname,epi_childreg.address||','||epi_childreg.vcode as address,
					epi_childreg.date_of_birth,epi_childreg.bcg,epi_childreg.opv0,epi_childreg.opv1,epi_childreg.opv2,epi_childreg.opv3,
					epi_childreg.penta1,epi_childreg.penta2,epi_childreg.penta3,epi_childreg.pcv10_1,epi_childreg.pcv10_2,epi_childreg.pcv10_3,epi_childreg.ipv,
					epi_childreg.measles1,epi_childreg.measles2 
				FROM 
					epi_childreg 
				INNER JOIN techniciandb 
				ON 
					epi_childreg.iemi=techniciandb.iemi_no 
				WHERE {$whereCondition} {$whereFmonth} ";
		}
		else{
			$query = "
				SELECT 
					districtname(techniciandb.distcode),epi_childreg.childcode, epi_childreg.name_of_child,
					epi_childreg.father_name||'/Pakistan' as fname,epi_childreg.address||', '||villagename(epi_childreg.vcode) as address,
					epi_childreg.date_of_birth,epi_childreg.bcg,epi_childreg.opv0,epi_childreg.opv1,epi_childreg.opv2,epi_childreg.opv3,
					epi_childreg.penta1,epi_childreg.penta2,epi_childreg.penta3,epi_childreg.pcv10_1,epi_childreg.pcv10_2,epi_childreg.pcv10_3,epi_childreg.ipv,
					epi_childreg.measles1,epi_childreg.measles2 
				FROM 
					epi_childreg 
				INNER JOIN techniciandb 
				ON 
					epi_childreg.iemi=techniciandb.iemi_no 
				INNER JOIN districts
				ON 
					epi_childreg.distcode = districts.distcode WHERE {$whereFmonth}";
		}
		//echo $query;exit;
		$dataReturned['PVRresult'] = $this -> db -> query($query) -> result_array();
		$subTitle = "Daily Vaccination Register Report";
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