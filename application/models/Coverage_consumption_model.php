<?php 
//kp
class Coverage_consumption_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('my_functions_helper');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('indicator_functions_helper');
		$this -> load -> model('Common_model');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Create_Reporting_Filters($reportName) {
		$data = posted_Values();
		$wc	  = getWC_Array($data['procode'],$this -> session -> District,$data['tcode']);
		$newWC= WC_replacement($wc);
		//print_r($newWC); exit;				  
		$neWc = $newWC[0];
		$neWc1 = $newWC[1];
		$UserLevel = $this -> session -> UserLevel;
		if($UserLevel==4){
			unset($neWc1[2]);
		}
		$Caption = "Report";
		$subTitle = "District Report";
		$datArray = NULL;
		$datArray['years'] = "";
		$link="Coverage_consumption";
		if($this -> session -> UserLevel==4){
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
		}else{
			$datArray['districts'] = get_resultArray('district',$neWc1);
		}
		if ($reportName == 'flcf_wise_vaccination') {
			$Caption = "Monthly Facility wise Vaccination Report";
			$datArray['vaccinationType'] = "";
			$datArray['typeWise'] = "";
			$datArray['months']= "";
		}
		if ($reportName == 'coverage_and_consumption') {
			$Caption = "Coverage and Consumption Report";			
			// $datArray['month-from-to'] = "";
			$datArray['years']= "";
			$datArray['months_aug2020']= "";
			// $datArray['in_out_coverage_dist'] = "";
			// $datArray['in_out_coverage_pro'] = "";
			// unset($datArray['years']);
		}
		
		//echo "<pre>"; print_r($datArray); exit;			 
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() .$link.'/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
		//echo "<pre>"; print_r($datArray); exit;					 
		return $datArray;
	}	
	//------------------------------------------------------------------------------------------------//			
	public function coverage_and_consumption($data){
		$data['year'] = $year = (isset($data['year']) AND $data['year'] !="")?$data['year']:date('Y');
		$data['month'] = $month = (isset($data['month']) AND $data['month'] !="")?$data['month']:'0';
		$data['fmonth'] = $fmonth = $year.'-'.$month;
		//echo $month; exit();
		if($month == 0){
			if($year == date('Y'))
				$monthVar = date('m')-1;
			else
				$monthVar = 12;
			$statusfmonthVar = $year.'-'.sprintf("%02d",($monthVar));
			$startMonth = 1;
		}
		else{
			$statusfmonthVar=$fmonth;
			$startMonth = (int)$month;
		}
		
		$procode = $this-> session-> Province;
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}
		else if(isset($data['tcode']) > 0){
			$wc = " tcode = '".$data['tcode']."' ";
		}
		else{
			$wc = " procode = '".$procode."' ";
		}
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Coverage_and_Consumption_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if(isset($data['distcode']) AND $data['distcode'] > 0){
			$fmonthVar = '';
			if($month == 0){
				$fmonthVar = "fmonth like '$year-%'";
			}
			else{
				$fmonthVar = "fmonth = '$fmonth'";
			}
			//echo $dueMonths; exit();
			$query="SELECT *, 
				bcg_from_consumption - bcg_from_coverage as bcg_difference,
				hepb_from_consumption - hepb_from_coverage as hepb_difference,
				opv_from_consumption - opv_from_coverage as opv_difference,
				penta_from_consumption - penta_from_coverage as penta_difference,
				pcv10_from_consumption - pcv10_from_coverage as pcv10_difference,
				ipv_from_consumption - ipv_from_coverage as ipv_difference,
				rota_from_consumption - rota_from_coverage as rota_difference,
				measles_from_consumption - measles_from_coverage as measles_difference
				from (select facode, fac_name, 
				(select get_commulative_fstatus_vacc1('$statusfmonthVar',facilities.facode,$startMonth)) as total_due_reports, 
				(select count(facode) from fac_mvrf_db where facode=facilities.facode and $fmonthVar) as coverage_submitted_reports, 
				(select count(facode) from epi_consumption_master where facode=facilities.facode and $fmonthVar) as consumption_submitted_reports, 
				COALESCE((select 
				sum(cri_r1_f1+cri_r2_f1+cri_r3_f1+cri_r4_f1+cri_r5_f1+cri_r6_f1+cri_r7_f1+cri_r8_f1+cri_r9_f1+cri_r10_f1+cri_r11_f1+cri_r12_f1+cri_r13_f1+cri_r14_f1+cri_r15_f1+cri_r16_f1+cri_r17_f1+cri_r18_f1+cri_r19_f1+cri_r20_f1+cri_r21_f1+cri_r22_f1+cri_r23_f1+cri_r24_f1) + 
				sum(oui_r1_f1+oui_r2_f1+oui_r3_f1+oui_r4_f1+oui_r5_f1+oui_r6_f1+oui_r7_f1+oui_r8_f1+oui_r9_f1+oui_r10_f1+oui_r11_f1+oui_r12_f1+oui_r13_f1+oui_r14_f1+oui_r15_f1+oui_r16_f1+oui_r17_f1+oui_r18_f1+oui_r19_f1+oui_r20_f1+oui_r21_f1+oui_r22_f1+oui_r23_f1+oui_r24_f1) + 
				(select sum(od_r1_f1+od_r2_f1+od_r3_f1+od_r4_f1+od_r5_f1+od_r6_f1+od_r7_f1+od_r8_f1+od_r9_f1+od_r10_f1+od_r11_f1+od_r12_f1+od_r13_f1+od_r14_f1+od_r15_f1+od_r16_f1+od_r17_f1+od_r18_f1+od_r19_f1+od_r20_f1+od_r21_f1+od_r22_f1+od_r23_f1+od_r24_f1) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as bcg_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 5),0) as bcg_from_consumption,
				COALESCE((select 
				sum(cri_r1_f2+cri_r2_f2+cri_r3_f2+cri_r4_f2+cri_r5_f2+cri_r6_f2+cri_r7_f2+cri_r8_f2+cri_r9_f2+cri_r10_f2+cri_r11_f2+cri_r12_f2+cri_r13_f2+cri_r14_f2+cri_r15_f2+cri_r16_f2+cri_r17_f2+cri_r18_f2+cri_r19_f2+cri_r20_f2+cri_r21_f2+cri_r22_f2+cri_r23_f2+cri_r24_f2) + 
				sum(oui_r1_f2+oui_r2_f2+oui_r3_f2+oui_r4_f2+oui_r5_f2+oui_r6_f2+oui_r7_f2+oui_r8_f2+oui_r9_f2+oui_r10_f2+oui_r11_f2+oui_r12_f2+oui_r13_f2+oui_r14_f2+oui_r15_f2+oui_r16_f2+oui_r17_f2+oui_r18_f2+oui_r19_f2+oui_r20_f2+oui_r21_f2+oui_r22_f2+oui_r23_f2+oui_r24_f2) + 
				(select sum(od_r1_f2+od_r2_f2+od_r3_f2+od_r4_f2+od_r5_f2+od_r6_f2+od_r7_f2+od_r8_f2+od_r9_f2+od_r10_f2+od_r11_f2+od_r12_f2+od_r13_f2+od_r14_f2+od_r15_f2+od_r16_f2+od_r17_f2+od_r18_f2+od_r19_f2+od_r20_f2+od_r21_f2+od_r22_f2+od_r23_f2+od_r24_f2) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as hepb_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 1),0) as hepb_from_consumption,
				COALESCE((select 
				sum(cri_r1_f3+cri_r2_f3+cri_r3_f3+cri_r4_f3+cri_r5_f3+cri_r6_f3+cri_r7_f3+cri_r8_f3+cri_r9_f3+cri_r10_f3+cri_r11_f3+cri_r12_f3+cri_r13_f3+cri_r14_f3+cri_r15_f3+cri_r16_f3+cri_r17_f3+cri_r18_f3+cri_r19_f3+cri_r20_f3+cri_r21_f3+cri_r22_f3+cri_r23_f3+cri_r24_f3+cri_r1_f4+cri_r2_f4+cri_r3_f4+cri_r4_f4+cri_r5_f4+cri_r6_f4+cri_r7_f4+cri_r8_f4+cri_r9_f4+cri_r10_f4+cri_r11_f4+cri_r12_f4+cri_r13_f4+cri_r14_f4+cri_r15_f4+cri_r16_f4+cri_r17_f4+cri_r18_f4+cri_r19_f4+cri_r20_f4+cri_r21_f4+cri_r22_f4+cri_r23_f4+cri_r24_f4+cri_r1_f5+cri_r2_f5+cri_r3_f5+cri_r4_f5+cri_r5_f5+cri_r6_f5+cri_r7_f5+cri_r8_f5+cri_r9_f5+cri_r10_f5+cri_r11_f5+cri_r12_f5+cri_r13_f5+cri_r14_f5+cri_r15_f5+cri_r16_f5+cri_r17_f5+cri_r18_f5+cri_r19_f5+cri_r20_f5+cri_r21_f5+cri_r22_f5+cri_r23_f5+cri_r24_f5+cri_r1_f6+cri_r2_f6+cri_r3_f6+cri_r4_f6+cri_r5_f6+cri_r6_f6+cri_r7_f6+cri_r8_f6+cri_r9_f6+cri_r10_f6+cri_r11_f6+cri_r12_f6+cri_r13_f6+cri_r14_f6+cri_r15_f6+cri_r16_f6+cri_r17_f6+cri_r18_f6+cri_r19_f6+cri_r20_f6+cri_r21_f6+cri_r22_f6+cri_r23_f6+cri_r24_f6) + 
				sum(oui_r1_f3+oui_r2_f3+oui_r3_f3+oui_r4_f3+oui_r5_f3+oui_r6_f3+oui_r7_f3+oui_r8_f3+oui_r9_f3+oui_r10_f3+oui_r11_f3+oui_r12_f3+oui_r13_f3+oui_r14_f3+oui_r15_f3+oui_r16_f3+oui_r17_f3+oui_r18_f3+oui_r19_f3+oui_r20_f3+oui_r21_f3+oui_r22_f3+oui_r23_f3+oui_r24_f3+oui_r1_f4+oui_r2_f4+oui_r3_f4+oui_r4_f4+oui_r5_f4+oui_r6_f4+oui_r7_f4+oui_r8_f4+oui_r9_f4+oui_r10_f4+oui_r11_f4+oui_r12_f4+oui_r13_f4+oui_r14_f4+oui_r15_f4+oui_r16_f4+oui_r17_f4+oui_r18_f4+oui_r19_f4+oui_r20_f4+oui_r21_f4+oui_r22_f4+oui_r23_f4+oui_r24_f4+oui_r1_f5+oui_r2_f5+oui_r3_f5+oui_r4_f5+oui_r5_f5+oui_r6_f5+oui_r7_f5+oui_r8_f5+oui_r9_f5+oui_r10_f5+oui_r11_f5+oui_r12_f5+oui_r13_f5+oui_r14_f5+oui_r15_f5+oui_r16_f5+oui_r17_f5+oui_r18_f5+oui_r19_f5+oui_r20_f5+oui_r21_f5+oui_r22_f5+oui_r23_f5+oui_r24_f5+oui_r1_f6+oui_r2_f6+oui_r3_f6+oui_r4_f6+oui_r5_f6+oui_r6_f6+oui_r7_f6+oui_r8_f6+oui_r9_f6+oui_r10_f6+oui_r11_f6+oui_r12_f6+oui_r13_f6+oui_r14_f6+oui_r15_f6+oui_r16_f6+oui_r17_f6+oui_r18_f6+oui_r19_f6+oui_r20_f6+oui_r21_f6+oui_r22_f6+oui_r23_f6+oui_r24_f6) + 
				(select sum(od_r1_f3+od_r2_f3+od_r3_f3+od_r4_f3+od_r5_f3+od_r6_f3+od_r7_f3+od_r8_f3+od_r9_f3+od_r10_f3+od_r11_f3+od_r12_f3+od_r13_f3+od_r14_f3+od_r15_f3+od_r16_f3+od_r17_f3+od_r18_f3+od_r19_f3+od_r20_f3+od_r21_f3+od_r22_f3+od_r23_f3+od_r24_f3+od_r1_f4+od_r2_f4+od_r3_f4+od_r4_f4+od_r5_f4+od_r6_f4+od_r7_f4+od_r8_f4+od_r9_f4+od_r10_f4+od_r11_f4+od_r12_f4+od_r13_f4+od_r14_f4+od_r15_f4+od_r16_f4+od_r17_f4+od_r18_f4+od_r19_f4+od_r20_f4+od_r21_f4+od_r22_f4+od_r23_f4+od_r24_f4+od_r1_f5+od_r2_f5+od_r3_f5+od_r4_f5+od_r5_f5+od_r6_f5+od_r7_f5+od_r8_f5+od_r9_f5+od_r10_f5+od_r11_f5+od_r12_f5+od_r13_f5+od_r14_f5+od_r15_f5+od_r16_f5+od_r17_f5+od_r18_f5+od_r19_f5+od_r20_f5+od_r21_f5+od_r22_f5+od_r23_f5+od_r24_f5+od_r1_f6+od_r2_f6+od_r3_f6+od_r4_f6+od_r5_f6+od_r6_f6+od_r7_f6+od_r8_f6+od_r9_f6+od_r10_f6+od_r11_f6+od_r12_f6+od_r13_f6+od_r14_f6+od_r15_f6+od_r16_f6+od_r17_f6+od_r18_f6+od_r19_f6+od_r20_f6+od_r21_f6+od_r22_f6+od_r23_f6+od_r24_f6) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as opv_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 2),0) as opv_from_consumption,
				COALESCE((select 
				sum(cri_r1_f7+cri_r2_f7+cri_r3_f7+cri_r4_f7+cri_r5_f7+cri_r6_f7+cri_r7_f7+cri_r8_f7+cri_r9_f7+cri_r10_f7+cri_r11_f7+cri_r12_f7+cri_r13_f7+cri_r14_f7+cri_r15_f7+cri_r16_f7+cri_r17_f7+cri_r18_f7+cri_r19_f7+cri_r20_f7+cri_r21_f7+cri_r22_f7+cri_r23_f7+cri_r24_f7+cri_r1_f8+cri_r2_f8+cri_r3_f8+cri_r4_f8+cri_r5_f8+cri_r6_f8+cri_r7_f8+cri_r8_f8+cri_r9_f8+cri_r10_f8+cri_r11_f8+cri_r12_f8+cri_r13_f8+cri_r14_f8+cri_r15_f8+cri_r16_f8+cri_r17_f8+cri_r18_f8+cri_r19_f8+cri_r20_f8+cri_r21_f8+cri_r22_f8+cri_r23_f8+cri_r24_f8+cri_r1_f9+cri_r2_f9+cri_r3_f9+cri_r4_f9+cri_r5_f9+cri_r6_f9+cri_r7_f9+cri_r8_f9+cri_r9_f9+cri_r10_f9+cri_r11_f9+cri_r12_f9+cri_r13_f9+cri_r14_f9+cri_r15_f9+cri_r16_f9+cri_r17_f9+cri_r18_f9+cri_r19_f9+cri_r20_f9+cri_r21_f9+cri_r22_f9+cri_r23_f9+cri_r24_f9) + 
				sum(oui_r1_f7+oui_r2_f7+oui_r3_f7+oui_r4_f7+oui_r5_f7+oui_r6_f7+oui_r7_f7+oui_r8_f7+oui_r9_f7+oui_r10_f7+oui_r11_f7+oui_r12_f7+oui_r13_f7+oui_r14_f7+oui_r15_f7+oui_r16_f7+oui_r17_f7+oui_r18_f7+oui_r19_f7+oui_r20_f7+oui_r21_f7+oui_r22_f7+oui_r23_f7+oui_r24_f7+oui_r1_f8+oui_r2_f8+oui_r3_f8+oui_r4_f8+oui_r5_f8+oui_r6_f8+oui_r7_f8+oui_r8_f8+oui_r9_f8+oui_r10_f8+oui_r11_f8+oui_r12_f8+oui_r13_f8+oui_r14_f8+oui_r15_f8+oui_r16_f8+oui_r17_f8+oui_r18_f8+oui_r19_f8+oui_r20_f8+oui_r21_f8+oui_r22_f8+oui_r23_f8+oui_r24_f8+oui_r1_f9+oui_r2_f9+oui_r3_f9+oui_r4_f9+oui_r5_f9+oui_r6_f9+oui_r7_f9+oui_r8_f9+oui_r9_f9+oui_r10_f9+oui_r11_f9+oui_r12_f9+oui_r13_f9+oui_r14_f9+oui_r15_f9+oui_r16_f9+oui_r17_f9+oui_r18_f9+oui_r19_f9+oui_r20_f9+oui_r21_f9+oui_r22_f9+oui_r23_f9+oui_r24_f9) + 
				(select sum(od_r1_f7+od_r2_f7+od_r3_f7+od_r4_f7+od_r5_f7+od_r6_f7+od_r7_f7+od_r8_f7+od_r9_f7+od_r10_f7+od_r11_f7+od_r12_f7+od_r13_f7+od_r14_f7+od_r15_f7+od_r16_f7+od_r17_f7+od_r18_f7+od_r19_f7+od_r20_f7+od_r21_f7+od_r22_f7+od_r23_f7+od_r24_f7+od_r1_f8+od_r2_f8+od_r3_f8+od_r4_f8+od_r5_f8+od_r6_f8+od_r7_f8+od_r8_f8+od_r9_f8+od_r10_f8+od_r11_f8+od_r12_f8+od_r13_f8+od_r14_f8+od_r15_f8+od_r16_f8+od_r17_f8+od_r18_f8+od_r19_f8+od_r20_f8+od_r21_f8+od_r22_f8+od_r23_f8+od_r24_f8+od_r1_f9+od_r2_f9+od_r3_f9+od_r4_f9+od_r5_f9+od_r6_f9+od_r7_f9+od_r8_f9+od_r9_f9+od_r10_f9+od_r11_f9+od_r12_f9+od_r13_f9+od_r14_f9+od_r15_f9+od_r16_f9+od_r17_f9+od_r18_f9+od_r19_f9+od_r20_f9+od_r21_f9+od_r22_f9+od_r23_f9+od_r24_f9) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as penta_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 7),0) as penta_from_consumption,
				COALESCE((select 
				sum(cri_r1_f10+cri_r2_f10+cri_r3_f10+cri_r4_f10+cri_r5_f10+cri_r6_f10+cri_r7_f10+cri_r8_f10+cri_r9_f10+cri_r10_f10+cri_r11_f10+cri_r12_f10+cri_r13_f10+cri_r14_f10+cri_r15_f10+cri_r16_f10+cri_r17_f10+cri_r18_f10+cri_r19_f10+cri_r20_f10+cri_r21_f10+cri_r22_f10+cri_r23_f10+cri_r24_f10+cri_r1_f11+cri_r2_f11+cri_r3_f11+cri_r4_f11+cri_r5_f11+cri_r6_f11+cri_r7_f11+cri_r8_f11+cri_r9_f11+cri_r10_f11+cri_r11_f11+cri_r12_f11+cri_r13_f11+cri_r14_f11+cri_r15_f11+cri_r16_f11+cri_r17_f11+cri_r18_f11+cri_r19_f11+cri_r20_f11+cri_r21_f11+cri_r22_f11+cri_r23_f11+cri_r24_f11+cri_r1_f12+cri_r2_f12+cri_r3_f12+cri_r4_f12+cri_r5_f12+cri_r6_f12+cri_r7_f12+cri_r8_f12+cri_r9_f12+cri_r10_f12+cri_r11_f12+cri_r12_f12+cri_r13_f12+cri_r14_f12+cri_r15_f12+cri_r16_f12+cri_r17_f12+cri_r18_f12+cri_r19_f12+cri_r20_f12+cri_r21_f12+cri_r22_f12+cri_r23_f12+cri_r24_f12) + 
				sum(oui_r1_f10+oui_r2_f10+oui_r3_f10+oui_r4_f10+oui_r5_f10+oui_r6_f10+oui_r7_f10+oui_r8_f10+oui_r9_f10+oui_r10_f10+oui_r11_f10+oui_r12_f10+oui_r13_f10+oui_r14_f10+oui_r15_f10+oui_r16_f10+oui_r17_f10+oui_r18_f10+oui_r19_f10+oui_r20_f10+oui_r21_f10+oui_r22_f10+oui_r23_f10+oui_r24_f10+oui_r1_f11+oui_r2_f11+oui_r3_f11+oui_r4_f11+oui_r5_f11+oui_r6_f11+oui_r7_f11+oui_r8_f11+oui_r9_f11+oui_r10_f11+oui_r11_f11+oui_r12_f11+oui_r13_f11+oui_r14_f11+oui_r15_f11+oui_r16_f11+oui_r17_f11+oui_r18_f11+oui_r19_f11+oui_r20_f11+oui_r21_f11+oui_r22_f11+oui_r23_f11+oui_r24_f11+oui_r1_f12+oui_r2_f12+oui_r3_f12+oui_r4_f12+oui_r5_f12+oui_r6_f12+oui_r7_f12+oui_r8_f12+oui_r9_f12+oui_r10_f12+oui_r11_f12+oui_r12_f12+oui_r13_f12+oui_r14_f12+oui_r15_f12+oui_r16_f12+oui_r17_f12+oui_r18_f12+oui_r19_f12+oui_r20_f12+oui_r21_f12+oui_r22_f12+oui_r23_f12+oui_r24_f12) + 
				(select sum(od_r1_f10+od_r2_f10+od_r3_f10+od_r4_f10+od_r5_f10+od_r6_f10+od_r7_f10+od_r8_f10+od_r9_f10+od_r10_f10+od_r11_f10+od_r12_f10+od_r13_f10+od_r14_f10+od_r15_f10+od_r16_f10+od_r17_f10+od_r18_f10+od_r19_f10+od_r20_f10+od_r21_f10+od_r22_f10+od_r23_f10+od_r24_f10+od_r1_f11+od_r2_f11+od_r3_f11+od_r4_f11+od_r5_f11+od_r6_f11+od_r7_f11+od_r8_f11+od_r9_f11+od_r10_f11+od_r11_f11+od_r12_f11+od_r13_f11+od_r14_f11+od_r15_f11+od_r16_f11+od_r17_f11+od_r18_f11+od_r19_f11+od_r20_f11+od_r21_f11+od_r22_f11+od_r23_f11+od_r24_f11+od_r1_f12+od_r2_f12+od_r3_f12+od_r4_f12+od_r5_f12+od_r6_f12+od_r7_f12+od_r8_f12+od_r9_f12+od_r10_f12+od_r11_f12+od_r12_f12+od_r13_f12+od_r14_f12+od_r15_f12+od_r16_f12+od_r17_f12+od_r18_f12+od_r19_f12+od_r20_f12+od_r21_f12+od_r22_f12+od_r23_f12+od_r24_f12) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as pcv10_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id in (8,90)),0) as pcv10_from_consumption,
				COALESCE((select 
				sum(cri_r1_f13+cri_r2_f13+cri_r3_f13+cri_r4_f13+cri_r5_f13+cri_r6_f13+cri_r7_f13+cri_r8_f13+cri_r9_f13+cri_r10_f13+cri_r11_f13+cri_r12_f13+cri_r13_f13+cri_r14_f13+cri_r15_f13+cri_r16_f13+cri_r17_f13+cri_r18_f13+cri_r19_f13+cri_r20_f13+cri_r21_f13+cri_r22_f13+cri_r23_f13+cri_r24_f13) + 
				sum(oui_r1_f13+oui_r2_f13+oui_r3_f13+oui_r4_f13+oui_r5_f13+oui_r6_f13+oui_r7_f13+oui_r8_f13+oui_r9_f13+oui_r10_f13+oui_r11_f13+oui_r12_f13+oui_r13_f13+oui_r14_f13+oui_r15_f13+oui_r16_f13+oui_r17_f13+oui_r18_f13+oui_r19_f13+oui_r20_f13+oui_r21_f13+oui_r22_f13+oui_r23_f13+oui_r24_f13) + 
				(select sum(od_r1_f13+od_r2_f13+od_r3_f13+od_r4_f13+od_r5_f13+od_r6_f13+od_r7_f13+od_r8_f13+od_r9_f13+od_r10_f13+od_r11_f13+od_r12_f13+od_r13_f13+od_r14_f13+od_r15_f13+od_r16_f13+od_r17_f13+od_r18_f13+od_r19_f13+od_r20_f13+od_r21_f13+od_r22_f13+od_r23_f13+od_r24_f13) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as ipv_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id in (3,4)),0) as ipv_from_consumption,
				COALESCE((select 
				sum(cri_r1_f14+cri_r2_f14+cri_r3_f14+cri_r4_f14+cri_r5_f14+cri_r6_f14+cri_r7_f14+cri_r8_f14+cri_r9_f14+cri_r10_f14+cri_r11_f14+cri_r12_f14+cri_r13_f14+cri_r14_f14+cri_r15_f14+cri_r16_f14+cri_r17_f14+cri_r18_f14+cri_r19_f14+cri_r20_f14+cri_r21_f14+cri_r22_f14+cri_r23_f14+cri_r24_f14+cri_r1_f15+cri_r2_f15+cri_r3_f15+cri_r4_f15+cri_r5_f15+cri_r6_f15+cri_r7_f15+cri_r8_f15+cri_r9_f15+cri_r10_f15+cri_r11_f15+cri_r12_f15+cri_r13_f15+cri_r14_f15+cri_r15_f15+cri_r16_f15+cri_r17_f15+cri_r18_f15+cri_r19_f15+cri_r20_f15+cri_r21_f15+cri_r22_f15+cri_r23_f15+cri_r24_f15) + 
				sum(oui_r1_f14+oui_r2_f14+oui_r3_f14+oui_r4_f14+oui_r5_f14+oui_r6_f14+oui_r7_f14+oui_r8_f14+oui_r9_f14+oui_r10_f14+oui_r11_f14+oui_r12_f14+oui_r13_f14+oui_r14_f14+oui_r15_f14+oui_r16_f14+oui_r17_f14+oui_r18_f14+oui_r19_f14+oui_r20_f14+oui_r21_f14+oui_r22_f14+oui_r23_f14+oui_r24_f14+oui_r1_f15+oui_r2_f15+oui_r3_f15+oui_r4_f15+oui_r5_f15+oui_r6_f15+oui_r7_f15+oui_r8_f15+oui_r9_f15+oui_r10_f15+oui_r11_f15+oui_r12_f15+oui_r13_f15+oui_r14_f15+oui_r15_f15+oui_r16_f15+oui_r17_f15+oui_r18_f15+oui_r19_f15+oui_r20_f15+oui_r21_f15+oui_r22_f15+oui_r23_f15+oui_r24_f15) + 
				(select sum(od_r1_f14+od_r2_f14+od_r3_f14+od_r4_f14+od_r5_f14+od_r6_f14+od_r7_f14+od_r8_f14+od_r9_f14+od_r10_f14+od_r11_f14+od_r12_f14+od_r13_f14+od_r14_f14+od_r15_f14+od_r16_f14+od_r17_f14+od_r18_f14+od_r19_f14+od_r20_f14+od_r21_f14+od_r22_f14+od_r23_f14+od_r24_f14+od_r1_f15+od_r2_f15+od_r3_f15+od_r4_f15+od_r5_f15+od_r6_f15+od_r7_f15+od_r8_f15+od_r9_f15+od_r10_f15+od_r11_f15+od_r12_f15+od_r13_f15+od_r14_f15+od_r15_f15+od_r16_f15+od_r17_f15+od_r18_f15+od_r19_f15+od_r20_f15+od_r21_f15+od_r22_f15+od_r23_f15+od_r24_f15) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as rota_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 12),0) as rota_from_consumption,
				COALESCE((select 
				sum(cri_r1_f16+cri_r2_f16+cri_r3_f16+cri_r4_f16+cri_r5_f16+cri_r6_f16+cri_r7_f16+cri_r8_f16+cri_r9_f16+cri_r10_f16+cri_r11_f16+cri_r12_f16+cri_r13_f16+cri_r14_f16+cri_r15_f16+cri_r16_f16+cri_r17_f16+cri_r18_f16+cri_r19_f16+cri_r20_f16+cri_r21_f16+cri_r22_f16+cri_r23_f16+cri_r24_f16+cri_r1_f18+cri_r2_f18+cri_r3_f18+cri_r4_f18+cri_r5_f18+cri_r6_f18+cri_r7_f18+cri_r8_f18+cri_r9_f18+cri_r10_f18+cri_r11_f18+cri_r12_f18+cri_r13_f18+cri_r14_f18+cri_r15_f18+cri_r16_f18+cri_r17_f18+cri_r18_f18+cri_r19_f18+cri_r20_f18+cri_r21_f18+cri_r22_f18+cri_r23_f18+cri_r24_f18) + 
				sum(oui_r1_f16+oui_r2_f16+oui_r3_f16+oui_r4_f16+oui_r5_f16+oui_r6_f16+oui_r7_f16+oui_r8_f16+oui_r9_f16+oui_r10_f16+oui_r11_f16+oui_r12_f16+oui_r13_f16+oui_r14_f16+oui_r15_f16+oui_r16_f16+oui_r17_f16+oui_r18_f16+oui_r19_f16+oui_r20_f16+oui_r21_f16+oui_r22_f16+oui_r23_f16+oui_r24_f16+oui_r1_f18+oui_r2_f18+oui_r3_f18+oui_r4_f18+oui_r5_f18+oui_r6_f18+oui_r7_f18+oui_r8_f18+oui_r9_f18+oui_r10_f18+oui_r11_f18+oui_r12_f18+oui_r13_f18+oui_r14_f18+oui_r15_f18+oui_r16_f18+oui_r17_f18+oui_r18_f18+oui_r19_f18+oui_r20_f18+oui_r21_f18+oui_r22_f18+oui_r23_f18+oui_r24_f18) + 
				(select sum(od_r1_f16+od_r2_f16+od_r3_f16+od_r4_f16+od_r5_f16+od_r6_f16+od_r7_f16+od_r8_f16+od_r9_f16+od_r10_f16+od_r11_f16+od_r12_f16+od_r13_f16+od_r14_f16+od_r15_f16+od_r16_f16+od_r17_f16+od_r18_f16+od_r19_f16+od_r20_f16+od_r21_f16+od_r22_f16+od_r23_f16+od_r24_f16+od_r1_f18+od_r2_f18+od_r3_f18+od_r4_f18+od_r5_f18+od_r6_f18+od_r7_f18+od_r8_f18+od_r9_f18+od_r10_f18+od_r11_f18+od_r12_f18+od_r13_f18+od_r14_f18+od_r15_f18+od_r16_f18+od_r17_f18+od_r18_f18+od_r19_f18+od_r20_f18+od_r21_f18+od_r22_f18+od_r23_f18+od_r24_f18) from fac_mvrf_od_db where facode=facilities.facode and $fmonthVar) as odbcg from fac_mvrf_db where facode = facilities.facode and $fmonthVar),0) as measles_from_coverage, 
				COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.facode = facilities.facode and mst.$fmonthVar and dtl.item_id = 9),0) as measles_from_consumption
				from facilities where $wc and hf_type='e' and is_vacc_fac='1' order by fac_name) as innerquery";

			//echo $query;exit();
			$result = $this->db->query($query);
			$result= $result->result();
			$returned_data['result'] = $result;
			$subTitle = "Coverage and Consumption Report";
			$returned_data['facilitywise'] = 'Yes';
			$returned_data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year'],'','',$data['month']);
			return $returned_data;
		}
		else{
			// echo $month; exit();
			$mto = '';
			$dueMonths = '';
			$sumMonths = '';
			$fmonthVar = '';
			if($year == date('Y') && $month == 0){
				//echo "abc"; exit();
				$mto = date('n')-1;
				for($i=1;$i<=$mto;$i++){
					$dueMonths .= "duem".$i."+";
					$sumMonths .= "subm".$i."+";
				}
				$dueMonths = rtrim($dueMonths,"+");
				$sumMonths = rtrim($sumMonths,"+");
				$fmonthVar = "fmonth like '$year-%'";
			}	
			elseif($year < date('Y') && $month == 0){
				//echo "xyz"; exit();
				$mto = 12;
				for($i=1;$i<=$mto;$i++){
					$dueMonths .= "duem".$i."+";
					$sumMonths .= "subm".$i."+";
				}
				$dueMonths = rtrim($dueMonths,"+");
				$sumMonths = rtrim($sumMonths,"+");
				$fmonthVar = "fmonth like '$year-%'";
			}
			else{
				//echo "klm"; exit();
				$i = (int)$month;
				//for($i=1;$i<=$mto;$i++){
					$dueMonths .= "duem".$i;
					$sumMonths .= "subm".$i;
				//}
				$dueMonths = rtrim($dueMonths,"+");
				$sumMonths = rtrim($sumMonths,"+");
				$fmonthVar = "fmonth = '$fmonth'";
			}
			//echo $dueMonths; exit();		
			$query="SELECT *, bcg_from_consumption - bcg_from_coverage as bcg_difference, 
					hepb_from_consumption - hepb_from_coverage as hepb_difference, 
					opv_from_consumption - opv_from_coverage as opv_difference, 
					penta_from_consumption - penta_from_coverage as penta_difference, 
					pcv10_from_consumption - pcv10_from_coverage as pcv10_difference, 
					ipv_from_consumption - ipv_from_coverage as ipv_difference, 
					rota_from_consumption - rota_from_coverage as rota_difference,
					measles_from_consumption - measles_from_coverage as measles_difference
					from (select distcode, district, 
				(select $dueMonths from vaccinationcompliance where distcode=districts.distcode and year='$year') as total_due_reports, 
				(select $sumMonths from vaccinationcompliance where distcode=districts.distcode and year='$year') as coverage_submitted_reports, 
				(select $sumMonths from consumptioncompliance where distcode=districts.distcode and year='$year') as consumption_submitted_reports, 
				COALESCE((select 
				sum(cri_r1_f1+cri_r2_f1+cri_r3_f1+cri_r4_f1+cri_r5_f1+cri_r6_f1+cri_r7_f1+cri_r8_f1+cri_r9_f1+cri_r10_f1+cri_r11_f1+cri_r12_f1+cri_r13_f1+cri_r14_f1+cri_r15_f1+cri_r16_f1+cri_r17_f1+cri_r18_f1+cri_r19_f1+cri_r20_f1+cri_r21_f1+cri_r22_f1+cri_r23_f1+cri_r24_f1) + 
				sum(oui_r1_f1+oui_r2_f1+oui_r3_f1+oui_r4_f1+oui_r5_f1+oui_r6_f1+oui_r7_f1+oui_r8_f1+oui_r9_f1+oui_r10_f1+oui_r11_f1+oui_r12_f1+oui_r13_f1+oui_r14_f1+oui_r15_f1+oui_r16_f1+oui_r17_f1+oui_r18_f1+oui_r19_f1+oui_r20_f1+oui_r21_f1+oui_r22_f1+oui_r23_f1+oui_r24_f1) + 
				(select sum(od_r1_f1+od_r2_f1+od_r3_f1+od_r4_f1+od_r5_f1+od_r6_f1+od_r7_f1+od_r8_f1+od_r9_f1+od_r10_f1+od_r11_f1+od_r12_f1+od_r13_f1+od_r14_f1+od_r15_f1+od_r16_f1+od_r17_f1+od_r18_f1+od_r19_f1+od_r20_f1+od_r21_f1+od_r22_f1+od_r23_f1+od_r24_f1) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odbcg
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as bcg_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 5),0) as bcg_from_consumption,
				COALESCE((select 
				sum(cri_r1_f2+cri_r2_f2+cri_r3_f2+cri_r4_f2+cri_r5_f2+cri_r6_f2+cri_r7_f2+cri_r8_f2+cri_r9_f2+cri_r10_f2+cri_r11_f2+cri_r12_f2+cri_r13_f2+cri_r14_f2+cri_r15_f2+cri_r16_f2+cri_r17_f2+cri_r18_f2+cri_r19_f2+cri_r20_f2+cri_r21_f2+cri_r22_f2+cri_r23_f2+cri_r24_f2) + 
				sum(oui_r1_f2+oui_r2_f2+oui_r3_f2+oui_r4_f2+oui_r5_f2+oui_r6_f2+oui_r7_f2+oui_r8_f2+oui_r9_f2+oui_r10_f2+oui_r11_f2+oui_r12_f2+oui_r13_f2+oui_r14_f2+oui_r15_f2+oui_r16_f2+oui_r17_f2+oui_r18_f2+oui_r19_f2+oui_r20_f2+oui_r21_f2+oui_r22_f2+oui_r23_f2+oui_r24_f2) + 
				(select sum(od_r1_f2+od_r2_f2+od_r3_f2+od_r4_f2+od_r5_f2+od_r6_f2+od_r7_f2+od_r8_f2+od_r9_f2+od_r10_f2+od_r11_f2+od_r12_f2+od_r13_f2+od_r14_f2+od_r15_f2+od_r16_f2+od_r17_f2+od_r18_f2+od_r19_f2+od_r20_f2+od_r21_f2+od_r22_f2+od_r23_f2+od_r24_f2) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odhepb
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as hepb_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 1),0) as hepb_from_consumption,
				COALESCE((select 
				sum(cri_r1_f3+cri_r2_f3+cri_r3_f3+cri_r4_f3+cri_r5_f3+cri_r6_f3+cri_r7_f3+cri_r8_f3+cri_r9_f3+cri_r10_f3+cri_r11_f3+cri_r12_f3+cri_r13_f3+cri_r14_f3+cri_r15_f3+cri_r16_f3+cri_r17_f3+cri_r18_f3+cri_r19_f3+cri_r20_f3+cri_r21_f3+cri_r22_f3+cri_r23_f3+cri_r24_f3+cri_r1_f4+cri_r2_f4+cri_r3_f4+cri_r4_f4+cri_r5_f4+cri_r6_f4+cri_r7_f4+cri_r8_f4+cri_r9_f4+cri_r10_f4+cri_r11_f4+cri_r12_f4+cri_r13_f4+cri_r14_f4+cri_r15_f4+cri_r16_f4+cri_r17_f4+cri_r18_f4+cri_r19_f4+cri_r20_f4+cri_r21_f4+cri_r22_f4+cri_r23_f4+cri_r24_f4+cri_r1_f5+cri_r2_f5+cri_r3_f5+cri_r4_f5+cri_r5_f5+cri_r6_f5+cri_r7_f5+cri_r8_f5+cri_r9_f5+cri_r10_f5+cri_r11_f5+cri_r12_f5+cri_r13_f5+cri_r14_f5+cri_r15_f5+cri_r16_f5+cri_r17_f5+cri_r18_f5+cri_r19_f5+cri_r20_f5+cri_r21_f5+cri_r22_f5+cri_r23_f5+cri_r24_f5+cri_r1_f6+cri_r2_f6+cri_r3_f6+cri_r4_f6+cri_r5_f6+cri_r6_f6+cri_r7_f6+cri_r8_f6+cri_r9_f6+cri_r10_f6+cri_r11_f6+cri_r12_f6+cri_r13_f6+cri_r14_f6+cri_r15_f6+cri_r16_f6+cri_r17_f6+cri_r18_f6+cri_r19_f6+cri_r20_f6+cri_r21_f6+cri_r22_f6+cri_r23_f6+cri_r24_f6) + 
				sum(oui_r1_f3+oui_r2_f3+oui_r3_f3+oui_r4_f3+oui_r5_f3+oui_r6_f3+oui_r7_f3+oui_r8_f3+oui_r9_f3+oui_r10_f3+oui_r11_f3+oui_r12_f3+oui_r13_f3+oui_r14_f3+oui_r15_f3+oui_r16_f3+oui_r17_f3+oui_r18_f3+oui_r19_f3+oui_r20_f3+oui_r21_f3+oui_r22_f3+oui_r23_f3+oui_r24_f3+oui_r1_f4+oui_r2_f4+oui_r3_f4+oui_r4_f4+oui_r5_f4+oui_r6_f4+oui_r7_f4+oui_r8_f4+oui_r9_f4+oui_r10_f4+oui_r11_f4+oui_r12_f4+oui_r13_f4+oui_r14_f4+oui_r15_f4+oui_r16_f4+oui_r17_f4+oui_r18_f4+oui_r19_f4+oui_r20_f4+oui_r21_f4+oui_r22_f4+oui_r23_f4+oui_r24_f4+oui_r1_f5+oui_r2_f5+oui_r3_f5+oui_r4_f5+oui_r5_f5+oui_r6_f5+oui_r7_f5+oui_r8_f5+oui_r9_f5+oui_r10_f5+oui_r11_f5+oui_r12_f5+oui_r13_f5+oui_r14_f5+oui_r15_f5+oui_r16_f5+oui_r17_f5+oui_r18_f5+oui_r19_f5+oui_r20_f5+oui_r21_f5+oui_r22_f5+oui_r23_f5+oui_r24_f5+oui_r1_f6+oui_r2_f6+oui_r3_f6+oui_r4_f6+oui_r5_f6+oui_r6_f6+oui_r7_f6+oui_r8_f6+oui_r9_f6+oui_r10_f6+oui_r11_f6+oui_r12_f6+oui_r13_f6+oui_r14_f6+oui_r15_f6+oui_r16_f6+oui_r17_f6+oui_r18_f6+oui_r19_f6+oui_r20_f6+oui_r21_f6+oui_r22_f6+oui_r23_f6+oui_r24_f6) + 
				(select sum(od_r1_f3+od_r2_f3+od_r3_f3+od_r4_f3+od_r5_f3+od_r6_f3+od_r7_f3+od_r8_f3+od_r9_f3+od_r10_f3+od_r11_f3+od_r12_f3+od_r13_f3+od_r14_f3+od_r15_f3+od_r16_f3+od_r17_f3+od_r18_f3+od_r19_f3+od_r20_f3+od_r21_f3+od_r22_f3+od_r23_f3+od_r24_f3+od_r1_f4+od_r2_f4+od_r3_f4+od_r4_f4+od_r5_f4+od_r6_f4+od_r7_f4+od_r8_f4+od_r9_f4+od_r10_f4+od_r11_f4+od_r12_f4+od_r13_f4+od_r14_f4+od_r15_f4+od_r16_f4+od_r17_f4+od_r18_f4+od_r19_f4+od_r20_f4+od_r21_f4+od_r22_f4+od_r23_f4+od_r24_f4+od_r1_f5+od_r2_f5+od_r3_f5+od_r4_f5+od_r5_f5+od_r6_f5+od_r7_f5+od_r8_f5+od_r9_f5+od_r10_f5+od_r11_f5+od_r12_f5+od_r13_f5+od_r14_f5+od_r15_f5+od_r16_f5+od_r17_f5+od_r18_f5+od_r19_f5+od_r20_f5+od_r21_f5+od_r22_f5+od_r23_f5+od_r24_f5+od_r1_f6+od_r2_f6+od_r3_f6+od_r4_f6+od_r5_f6+od_r6_f6+od_r7_f6+od_r8_f6+od_r9_f6+od_r10_f6+od_r11_f6+od_r12_f6+od_r13_f6+od_r14_f6+od_r15_f6+od_r16_f6+od_r17_f6+od_r18_f6+od_r19_f6+od_r20_f6+od_r21_f6+od_r22_f6+od_r23_f6+od_r24_f6) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odopv
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as opv_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 2),0) as opv_from_consumption,
				COALESCE((select 
				sum(cri_r1_f7+cri_r2_f7+cri_r3_f7+cri_r4_f7+cri_r5_f7+cri_r6_f7+cri_r7_f7+cri_r8_f7+cri_r9_f7+cri_r10_f7+cri_r11_f7+cri_r12_f7+cri_r13_f7+cri_r14_f7+cri_r15_f7+cri_r16_f7+cri_r17_f7+cri_r18_f7+cri_r19_f7+cri_r20_f7+cri_r21_f7+cri_r22_f7+cri_r23_f7+cri_r24_f7+cri_r1_f8+cri_r2_f8+cri_r3_f8+cri_r4_f8+cri_r5_f8+cri_r6_f8+cri_r7_f8+cri_r8_f8+cri_r9_f8+cri_r10_f8+cri_r11_f8+cri_r12_f8+cri_r13_f8+cri_r14_f8+cri_r15_f8+cri_r16_f8+cri_r17_f8+cri_r18_f8+cri_r19_f8+cri_r20_f8+cri_r21_f8+cri_r22_f8+cri_r23_f8+cri_r24_f8+cri_r1_f9+cri_r2_f9+cri_r3_f9+cri_r4_f9+cri_r5_f9+cri_r6_f9+cri_r7_f9+cri_r8_f9+cri_r9_f9+cri_r10_f9+cri_r11_f9+cri_r12_f9+cri_r13_f9+cri_r14_f9+cri_r15_f9+cri_r16_f9+cri_r17_f9+cri_r18_f9+cri_r19_f9+cri_r20_f9+cri_r21_f9+cri_r22_f9+cri_r23_f9+cri_r24_f9) + 
				sum(oui_r1_f7+oui_r2_f7+oui_r3_f7+oui_r4_f7+oui_r5_f7+oui_r6_f7+oui_r7_f7+oui_r8_f7+oui_r9_f7+oui_r10_f7+oui_r11_f7+oui_r12_f7+oui_r13_f7+oui_r14_f7+oui_r15_f7+oui_r16_f7+oui_r17_f7+oui_r18_f7+oui_r19_f7+oui_r20_f7+oui_r21_f7+oui_r22_f7+oui_r23_f7+oui_r24_f7+oui_r1_f8+oui_r2_f8+oui_r3_f8+oui_r4_f8+oui_r5_f8+oui_r6_f8+oui_r7_f8+oui_r8_f8+oui_r9_f8+oui_r10_f8+oui_r11_f8+oui_r12_f8+oui_r13_f8+oui_r14_f8+oui_r15_f8+oui_r16_f8+oui_r17_f8+oui_r18_f8+oui_r19_f8+oui_r20_f8+oui_r21_f8+oui_r22_f8+oui_r23_f8+oui_r24_f8+oui_r1_f9+oui_r2_f9+oui_r3_f9+oui_r4_f9+oui_r5_f9+oui_r6_f9+oui_r7_f9+oui_r8_f9+oui_r9_f9+oui_r10_f9+oui_r11_f9+oui_r12_f9+oui_r13_f9+oui_r14_f9+oui_r15_f9+oui_r16_f9+oui_r17_f9+oui_r18_f9+oui_r19_f9+oui_r20_f9+oui_r21_f9+oui_r22_f9+oui_r23_f9+oui_r24_f9) + 
				(select sum(od_r1_f7+od_r2_f7+od_r3_f7+od_r4_f7+od_r5_f7+od_r6_f7+od_r7_f7+od_r8_f7+od_r9_f7+od_r10_f7+od_r11_f7+od_r12_f7+od_r13_f7+od_r14_f7+od_r15_f7+od_r16_f7+od_r17_f7+od_r18_f7+od_r19_f7+od_r20_f7+od_r21_f7+od_r22_f7+od_r23_f7+od_r24_f7+od_r1_f8+od_r2_f8+od_r3_f8+od_r4_f8+od_r5_f8+od_r6_f8+od_r7_f8+od_r8_f8+od_r9_f8+od_r10_f8+od_r11_f8+od_r12_f8+od_r13_f8+od_r14_f8+od_r15_f8+od_r16_f8+od_r17_f8+od_r18_f8+od_r19_f8+od_r20_f8+od_r21_f8+od_r22_f8+od_r23_f8+od_r24_f8+od_r1_f9+od_r2_f9+od_r3_f9+od_r4_f9+od_r5_f9+od_r6_f9+od_r7_f9+od_r8_f9+od_r9_f9+od_r10_f9+od_r11_f9+od_r12_f9+od_r13_f9+od_r14_f9+od_r15_f9+od_r16_f9+od_r17_f9+od_r18_f9+od_r19_f9+od_r20_f9+od_r21_f9+od_r22_f9+od_r23_f9+od_r24_f9) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odpenta
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as penta_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 7),0) as penta_from_consumption,
				COALESCE((select 
				sum(cri_r1_f10+cri_r2_f10+cri_r3_f10+cri_r4_f10+cri_r5_f10+cri_r6_f10+cri_r7_f10+cri_r8_f10+cri_r9_f10+cri_r10_f10+cri_r11_f10+cri_r12_f10+cri_r13_f10+cri_r14_f10+cri_r15_f10+cri_r16_f10+cri_r17_f10+cri_r18_f10+cri_r19_f10+cri_r20_f10+cri_r21_f10+cri_r22_f10+cri_r23_f10+cri_r24_f10+cri_r1_f11+cri_r2_f11+cri_r3_f11+cri_r4_f11+cri_r5_f11+cri_r6_f11+cri_r7_f11+cri_r8_f11+cri_r9_f11+cri_r10_f11+cri_r11_f11+cri_r12_f11+cri_r13_f11+cri_r14_f11+cri_r15_f11+cri_r16_f11+cri_r17_f11+cri_r18_f11+cri_r19_f11+cri_r20_f11+cri_r21_f11+cri_r22_f11+cri_r23_f11+cri_r24_f11+cri_r1_f12+cri_r2_f12+cri_r3_f12+cri_r4_f12+cri_r5_f12+cri_r6_f12+cri_r7_f12+cri_r8_f12+cri_r9_f12+cri_r10_f12+cri_r11_f12+cri_r12_f12+cri_r13_f12+cri_r14_f12+cri_r15_f12+cri_r16_f12+cri_r17_f12+cri_r18_f12+cri_r19_f12+cri_r20_f12+cri_r21_f12+cri_r22_f12+cri_r23_f12+cri_r24_f12) + 
				sum(oui_r1_f10+oui_r2_f10+oui_r3_f10+oui_r4_f10+oui_r5_f10+oui_r6_f10+oui_r7_f10+oui_r8_f10+oui_r9_f10+oui_r10_f10+oui_r11_f10+oui_r12_f10+oui_r13_f10+oui_r14_f10+oui_r15_f10+oui_r16_f10+oui_r17_f10+oui_r18_f10+oui_r19_f10+oui_r20_f10+oui_r21_f10+oui_r22_f10+oui_r23_f10+oui_r24_f10+oui_r1_f11+oui_r2_f11+oui_r3_f11+oui_r4_f11+oui_r5_f11+oui_r6_f11+oui_r7_f11+oui_r8_f11+oui_r9_f11+oui_r10_f11+oui_r11_f11+oui_r12_f11+oui_r13_f11+oui_r14_f11+oui_r15_f11+oui_r16_f11+oui_r17_f11+oui_r18_f11+oui_r19_f11+oui_r20_f11+oui_r21_f11+oui_r22_f11+oui_r23_f11+oui_r24_f11+oui_r1_f12+oui_r2_f12+oui_r3_f12+oui_r4_f12+oui_r5_f12+oui_r6_f12+oui_r7_f12+oui_r8_f12+oui_r9_f12+oui_r10_f12+oui_r11_f12+oui_r12_f12+oui_r13_f12+oui_r14_f12+oui_r15_f12+oui_r16_f12+oui_r17_f12+oui_r18_f12+oui_r19_f12+oui_r20_f12+oui_r21_f12+oui_r22_f12+oui_r23_f12+oui_r24_f12) + 
				(select sum(od_r1_f10+od_r2_f10+od_r3_f10+od_r4_f10+od_r5_f10+od_r6_f10+od_r7_f10+od_r8_f10+od_r9_f10+od_r10_f10+od_r11_f10+od_r12_f10+od_r13_f10+od_r14_f10+od_r15_f10+od_r16_f10+od_r17_f10+od_r18_f10+od_r19_f10+od_r20_f10+od_r21_f10+od_r22_f10+od_r23_f10+od_r24_f10+od_r1_f11+od_r2_f11+od_r3_f11+od_r4_f11+od_r5_f11+od_r6_f11+od_r7_f11+od_r8_f11+od_r9_f11+od_r10_f11+od_r11_f11+od_r12_f11+od_r13_f11+od_r14_f11+od_r15_f11+od_r16_f11+od_r17_f11+od_r18_f11+od_r19_f11+od_r20_f11+od_r21_f11+od_r22_f11+od_r23_f11+od_r24_f11+od_r1_f12+od_r2_f12+od_r3_f12+od_r4_f12+od_r5_f12+od_r6_f12+od_r7_f12+od_r8_f12+od_r9_f12+od_r10_f12+od_r11_f12+od_r12_f12+od_r13_f12+od_r14_f12+od_r15_f12+od_r16_f12+od_r17_f12+od_r18_f12+od_r19_f12+od_r20_f12+od_r21_f12+od_r22_f12+od_r23_f12+od_r24_f12) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odpcv10
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as pcv10_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id in (8,90)),0) as pcv10_from_consumption,
				COALESCE((select 
				sum(cri_r1_f13+cri_r2_f13+cri_r3_f13+cri_r4_f13+cri_r5_f13+cri_r6_f13+cri_r7_f13+cri_r8_f13+cri_r9_f13+cri_r10_f13+cri_r11_f13+cri_r12_f13+cri_r13_f13+cri_r14_f13+cri_r15_f13+cri_r16_f13+cri_r17_f13+cri_r18_f13+cri_r19_f13+cri_r20_f13+cri_r21_f13+cri_r22_f13+cri_r23_f13+cri_r24_f13) + 
				sum(oui_r1_f13+oui_r2_f13+oui_r3_f13+oui_r4_f13+oui_r5_f13+oui_r6_f13+oui_r7_f13+oui_r8_f13+oui_r9_f13+oui_r10_f13+oui_r11_f13+oui_r12_f13+oui_r13_f13+oui_r14_f13+oui_r15_f13+oui_r16_f13+oui_r17_f13+oui_r18_f13+oui_r19_f13+oui_r20_f13+oui_r21_f13+oui_r22_f13+oui_r23_f13+oui_r24_f13) + 
				(select sum(od_r1_f13+od_r2_f13+od_r3_f13+od_r4_f13+od_r5_f13+od_r6_f13+od_r7_f13+od_r8_f13+od_r9_f13+od_r10_f13+od_r11_f13+od_r12_f13+od_r13_f13+od_r14_f13+od_r15_f13+od_r16_f13+od_r17_f13+od_r18_f13+od_r19_f13+od_r20_f13+od_r21_f13+od_r22_f13+od_r23_f13+od_r24_f13) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odipv
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as ipv_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id in (3,4)),0) as ipv_from_consumption,
				COALESCE((select 
				sum(cri_r1_f14+cri_r2_f14+cri_r3_f14+cri_r4_f14+cri_r5_f14+cri_r6_f14+cri_r7_f14+cri_r8_f14+cri_r9_f14+cri_r10_f14+cri_r11_f14+cri_r12_f14+cri_r13_f14+cri_r14_f14+cri_r15_f14+cri_r16_f14+cri_r17_f14+cri_r18_f14+cri_r19_f14+cri_r20_f14+cri_r21_f14+cri_r22_f14+cri_r23_f14+cri_r24_f14+cri_r1_f15+cri_r2_f15+cri_r3_f15+cri_r4_f15+cri_r5_f15+cri_r6_f15+cri_r7_f15+cri_r8_f15+cri_r9_f15+cri_r10_f15+cri_r11_f15+cri_r12_f15+cri_r13_f15+cri_r14_f15+cri_r15_f15+cri_r16_f15+cri_r17_f15+cri_r18_f15+cri_r19_f15+cri_r20_f15+cri_r21_f15+cri_r22_f15+cri_r23_f15+cri_r24_f15) + 
				sum(oui_r1_f14+oui_r2_f14+oui_r3_f14+oui_r4_f14+oui_r5_f14+oui_r6_f14+oui_r7_f14+oui_r8_f14+oui_r9_f14+oui_r10_f14+oui_r11_f14+oui_r12_f14+oui_r13_f14+oui_r14_f14+oui_r15_f14+oui_r16_f14+oui_r17_f14+oui_r18_f14+oui_r19_f14+oui_r20_f14+oui_r21_f14+oui_r22_f14+oui_r23_f14+oui_r24_f14+oui_r1_f15+oui_r2_f15+oui_r3_f15+oui_r4_f15+oui_r5_f15+oui_r6_f15+oui_r7_f15+oui_r8_f15+oui_r9_f15+oui_r10_f15+oui_r11_f15+oui_r12_f15+oui_r13_f15+oui_r14_f15+oui_r15_f15+oui_r16_f15+oui_r17_f15+oui_r18_f15+oui_r19_f15+oui_r20_f15+oui_r21_f15+oui_r22_f15+oui_r23_f15+oui_r24_f15) + 
				(select sum(od_r1_f14+od_r2_f14+od_r3_f14+od_r4_f14+od_r5_f14+od_r6_f14+od_r7_f14+od_r8_f14+od_r9_f14+od_r10_f14+od_r11_f14+od_r12_f14+od_r13_f14+od_r14_f14+od_r15_f14+od_r16_f14+od_r17_f14+od_r18_f14+od_r19_f14+od_r20_f14+od_r21_f14+od_r22_f14+od_r23_f14+od_r24_f14+od_r1_f15+od_r2_f15+od_r3_f15+od_r4_f15+od_r5_f15+od_r6_f15+od_r7_f15+od_r8_f15+od_r9_f15+od_r10_f15+od_r11_f15+od_r12_f15+od_r13_f15+od_r14_f15+od_r15_f15+od_r16_f15+od_r17_f15+od_r18_f15+od_r19_f15+od_r20_f15+od_r21_f15+od_r22_f15+od_r23_f15+od_r24_f15) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odrota
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as rota_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 12),0) as rota_from_consumption,
				COALESCE((select 
				sum(cri_r1_f16+cri_r2_f16+cri_r3_f16+cri_r4_f16+cri_r5_f16+cri_r6_f16+cri_r7_f16+cri_r8_f16+cri_r9_f16+cri_r10_f16+cri_r11_f16+cri_r12_f16+cri_r13_f16+cri_r14_f16+cri_r15_f16+cri_r16_f16+cri_r17_f16+cri_r18_f16+cri_r19_f16+cri_r20_f16+cri_r21_f16+cri_r22_f16+cri_r23_f16+cri_r24_f16+cri_r1_f18+cri_r2_f18+cri_r3_f18+cri_r4_f18+cri_r5_f18+cri_r6_f18+cri_r7_f18+cri_r8_f18+cri_r9_f18+cri_r10_f18+cri_r11_f18+cri_r12_f18+cri_r13_f18+cri_r14_f18+cri_r15_f18+cri_r16_f18+cri_r17_f18+cri_r18_f18+cri_r19_f18+cri_r20_f18+cri_r21_f18+cri_r22_f18+cri_r23_f18+cri_r24_f18) + 
				sum(oui_r1_f16+oui_r2_f16+oui_r3_f16+oui_r4_f16+oui_r5_f16+oui_r6_f16+oui_r7_f16+oui_r8_f16+oui_r9_f16+oui_r10_f16+oui_r11_f16+oui_r12_f16+oui_r13_f16+oui_r14_f16+oui_r15_f16+oui_r16_f16+oui_r17_f16+oui_r18_f16+oui_r19_f16+oui_r20_f16+oui_r21_f16+oui_r22_f16+oui_r23_f16+oui_r24_f16+oui_r1_f18+oui_r2_f18+oui_r3_f18+oui_r4_f18+oui_r5_f18+oui_r6_f18+oui_r7_f18+oui_r8_f18+oui_r9_f18+oui_r10_f18+oui_r11_f18+oui_r12_f18+oui_r13_f18+oui_r14_f18+oui_r15_f18+oui_r16_f18+oui_r17_f18+oui_r18_f18+oui_r19_f18+oui_r20_f18+oui_r21_f18+oui_r22_f18+oui_r23_f18+oui_r24_f18) + 
				(select sum(od_r1_f16+od_r2_f16+od_r3_f16+od_r4_f16+od_r5_f16+od_r6_f16+od_r7_f16+od_r8_f16+od_r9_f16+od_r10_f16+od_r11_f16+od_r12_f16+od_r13_f16+od_r14_f16+od_r15_f16+od_r16_f16+od_r17_f16+od_r18_f16+od_r19_f16+od_r20_f16+od_r21_f16+od_r22_f16+od_r23_f16+od_r24_f16+od_r1_f18+od_r2_f18+od_r3_f18+od_r4_f18+od_r5_f18+od_r6_f18+od_r7_f18+od_r8_f18+od_r9_f18+od_r10_f18+od_r11_f18+od_r12_f18+od_r13_f18+od_r14_f18+od_r15_f18+od_r16_f18+od_r17_f18+od_r18_f18+od_r19_f18+od_r20_f18+od_r21_f18+od_r22_f18+od_r23_f18+od_r24_f18) from fac_mvrf_od_db where distcode=districts.distcode and $fmonthVar and $wc) as odmeasles
				from fac_mvrf_db where distcode = districts.distcode and $fmonthVar and $wc),0) as measles_from_coverage, COALESCE((select sum(vaccinated) from epi_consumption_detail dtl join epi_consumption_master mst on dtl.main_id = mst.pk_id where mst.distcode = districts.distcode and mst.$fmonthVar and $wc and dtl.item_id = 9),0) as measles_from_consumption
				from districts order by district) as innerquery";
			//echo $query;exit();
			$result = $this->db->query($query);
			$result= $result->result();
			$returned_data['result'] = $result;
			$subTitle = "Coverage and Consumption Report";
			$returned_data['TopInfo'] = tableTopInfo($subTitle, '', '', $data['year'],'','',$data['month']);
			return $returned_data;
		}
	}
}
?>