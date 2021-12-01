<?php
class Vaccine_coverage_model extends CI_Model {
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
		$data = posted_Values();//posted values from last page
		$wc	  = getWC_Array($data['procode'],$this -> session -> District,$data['facode']); // function to get wc array
		$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is province.
		$neWc = $newWC[0];$neWc1 = $newWC[1];
		$UserLevel = $this -> session -> UserLevel;
		$Caption = "Report";
		$subTitle = "District Report";
		$datArray = NULL;
		$datArray['years'] = "";
		$link="Reports";
		$datArray['districts'] = get_resultArray('district',$neWc1);	
		//$datArray['flcf'] = get_resultArray('flcf',$wc);
		if ($reportName == 'flcf_wise_vaccination') {
			$Caption = "Monthly Facility wise Vaccination Report";
			//$datArray['current-month-included'] = "";
			$datArray['vaccinationType'] = "";
			$datArray['typeWise'] = "";
			$datArray['months']= "";
		}
		if ($reportName == 'flcf_wise_vaccination_coverage') {
			$Caption = "Consolidated Facility Wise Vaccination Coverage of Children and Women";
		}
		if ($reportName == 'flcf_wise_vaccination_malefemale_coverage') {
			$Caption = "Consolidated Facility wise Vaccination Report";
			$datArray['vaccinationType'] = "";
			$datArray['typeWise'] = "";
			$datArray['month-from-to'] = "";
			$datArray['in_out_coverage_dist'] = "";
			$datArray['in_out_coverage_pro'] = "";
			$datArray['vacc_to'] = "";
			$datArray['age_wise'] = "";
			unset($datArray['years']);
		}
		
		
		if ($reportName == 'flcf_vacc_coverage_compliance') {
			$Caption = "Facility Wise Vaccination Coverage Compliance";
		}		
		
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() .$link.'/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
		return $datArray;
	}
	//================================================================================================//
	function in_plus_out_districts($code=NULL,$year=NULL,$data=NULL){
		//print_r($data);exit();
		$start_year = substr($data['monthfrom'],0,4);
		$start_month = substr($data['monthfrom'],5,2);
		$end_year = substr($data['monthto'],0,4);
		$end_month = substr($data['monthto'],5,2);

		$in_out_coverage = $this-> input-> get_post('in_out_coverage');
		$vaccination_type = $this -> input -> get_post('vaccination_type');
		$vacc_to = $this-> input-> get_post('vacc_to');
		$age_wise = $this-> input-> get_post('age_wise');
		if(!isset($data["distcode"])){
			$data["distcode"] = $this-> input-> get("distcode");
		}
		$data['procode'] = $_SESSION["Province"];
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$distcode=$data['distcode'];
		$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
		$pageTitle = "District-wise Monthly Vaccination of Children and Women(with Percentage)";
		//print_r($headNames);exit();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}		
		// $categories=array();
		// $query = ''; $outer = '';$inner = '';$currentStock = ''; $AND = '';
		//echo '3rd';exit;
		if($vaccination_type == 'all'){	//done
			if($vacc_to == 'total_children' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM (select distcode, sum(cri_r1_f1 + cri_r3_f1 + cri_r5_f1 + cri_r7_f1 + cri_r9_f1 + cri_r11_f1 + cri_r13_f1 + cri_r15_f1 + cri_r17_f1 + cri_r19_f1 + cri_r21_f1 + cri_r23_f1 + oui_r1_f1 + oui_r3_f1 + oui_r5_f1 + oui_r7_f1 + oui_r9_f1 + oui_r11_f1 + oui_r13_f1 + oui_r15_f1 + oui_r17_f1 + oui_r19_f1 + oui_r21_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r4_f1 + cri_r6_f1 + cri_r8_f1 + cri_r10_f1 + cri_r12_f1 + cri_r14_f1 + cri_r16_f1 + cri_r18_f1 + cri_r20_f1 + cri_r22_f1 + cri_r24_f1 + oui_r2_f1 + oui_r4_f1 + oui_r6_f1 + oui_r8_f1 + oui_r10_f1 + oui_r12_f1 + oui_r14_f1 + oui_r16_f1 + oui_r18_f1 + oui_r20_f1 + oui_r22_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r3_f2 + cri_r5_f2 + cri_r7_f2 + cri_r9_f2 + cri_r11_f2 + cri_r13_f2 + cri_r15_f2 + cri_r17_f2 + cri_r19_f2 + cri_r21_f2 + cri_r23_f2 +oui_r1_f2 + oui_r3_f2 + oui_r5_f2 + oui_r7_f2 + oui_r9_f2 + oui_r11_f2 + oui_r13_f2 + oui_r15_f2 + oui_r17_f2 + oui_r19_f2 + oui_r21_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r4_f2 + cri_r6_f2 + cri_r8_f2 + cri_r10_f2 + cri_r12_f2 + cri_r14_f2 + cri_r16_f2 + cri_r18_f2 + cri_r20_f2 + cri_r22_f2 + cri_r24_f2 + oui_r2_f2 + oui_r4_f2 + oui_r6_f2 + oui_r8_f2 + oui_r10_f2 + oui_r12_f2 + oui_r14_f2 + oui_r16_f2 + oui_r18_f2 + oui_r20_f2 + oui_r22_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r1_f3 + cri_r3_f3 + cri_r5_f3 + cri_r7_f3 + cri_r9_f3 + cri_r11_f3 + cri_r13_f3 + cri_r15_f3 + cri_r17_f3 + cri_r19_f3 + cri_r21_f3 + cri_r23_f3 + oui_r1_f3 + oui_r3_f3 + oui_r5_f3 + oui_r7_f3 + oui_r9_f3 + oui_r11_f3 + oui_r13_f3 + oui_r15_f3 + oui_r17_f3 + oui_r19_f3 + oui_r21_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r4_f3 + cri_r6_f3 + cri_r8_f3 + cri_r10_f3 + cri_r12_f3 + cri_r14_f3 + cri_r16_f3 + cri_r18_f3 + cri_r20_f3 + cri_r22_f3 + cri_r24_f3 + oui_r2_f3 + oui_r4_f3 + oui_r6_f3 + oui_r8_f3 + oui_r10_f3 + oui_r12_f3 + oui_r14_f3 + oui_r16_f3 + oui_r18_f3 + oui_r20_f3 + oui_r22_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r3_f4 + cri_r5_f4 + cri_r7_f4 + cri_r9_f4 + cri_r11_f4 + cri_r13_f4 + cri_r15_f4 + cri_r17_f4 + cri_r19_f4 + cri_r21_f4 + cri_r23_f4 + oui_r1_f4 + oui_r3_f4 + oui_r5_f4 + oui_r7_f4 + oui_r9_f4 + oui_r11_f4 + oui_r13_f4 + oui_r15_f4 + oui_r17_f4 + oui_r19_f4 + oui_r21_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r2_f4 + cri_r4_f4 + cri_r6_f4 + cri_r8_f4 + cri_r10_f4 + cri_r12_f4 + cri_r14_f4 + cri_r16_f4 + cri_r18_f4 + cri_r20_f4 + cri_r22_f4 + cri_r24_f4 + oui_r2_f4 + oui_r4_f4 + oui_r6_f4 + oui_r8_f4 + oui_r10_f4 + oui_r12_f4 + oui_r14_f4 + oui_r16_f4 + oui_r18_f4 + oui_r20_f4 + oui_r22_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r3_f5 + cri_r5_f5 + cri_r7_f5 + cri_r9_f5 + cri_r11_f5 + cri_r13_f5 + cri_r15_f5 + cri_r17_f5 + cri_r19_f5 + cri_r21_f5 + cri_r23_f5 + oui_r1_f5 + oui_r3_f5 + oui_r5_f5 + oui_r7_f5 + oui_r9_f5 + oui_r11_f5 + oui_r13_f5 + oui_r15_f5 + oui_r17_f5 + oui_r19_f5 + oui_r21_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r4_f5 + cri_r6_f5 + cri_r8_f5 + cri_r10_f5 + cri_r12_f5 + cri_r14_f5 + cri_r16_f5 + cri_r18_f5 + cri_r20_f5 + cri_r22_f5 + cri_r24_f5 + oui_r2_f5 + oui_r4_f5 + oui_r6_f5 + oui_r8_f5 + oui_r10_f5 + oui_r12_f5 + oui_r14_f5 + oui_r16_f5 + oui_r18_f5 + oui_r20_f5 + oui_r22_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r3_f6 + cri_r5_f6 + cri_r7_f6 + cri_r9_f6 + cri_r11_f6 + cri_r13_f6 + cri_r15_f6 + cri_r17_f6 + cri_r19_f6 + cri_r21_f6 + cri_r23_f6 + oui_r1_f6 + oui_r3_f6 + oui_r5_f6 + oui_r7_f6 + oui_r9_f6 + oui_r11_f6 + oui_r13_f6 + oui_r15_f6 + oui_r17_f6 + oui_r19_f6 + oui_r21_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r4_f6 + cri_r6_f6 + cri_r8_f6 + cri_r10_f6 + cri_r12_f6 + cri_r14_f6 + cri_r16_f6 + cri_r18_f6 + cri_r20_f6 + cri_r22_f6 + cri_r24_f6 + oui_r2_f6 + oui_r4_f6 + oui_r6_f6 + oui_r8_f6 + oui_r10_f6 + oui_r12_f6 + oui_r14_f6 + oui_r16_f6 + oui_r18_f6 + oui_r20_f6 + oui_r22_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r3_f7 + cri_r5_f7 + cri_r7_f7 + cri_r9_f7 + cri_r11_f7 + cri_r13_f7 + cri_r15_f7 + cri_r17_f7 + cri_r19_f7 + cri_r21_f7 + cri_r23_f7 + oui_r1_f7 + oui_r3_f7 + oui_r5_f7 + oui_r7_f7 + oui_r9_f7 + oui_r11_f7 + oui_r13_f7 + oui_r15_f7 + oui_r17_f7 + oui_r19_f7 + oui_r21_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r4_f7 + cri_r6_f7 + cri_r8_f7 + cri_r10_f7 + cri_r12_f7 + cri_r14_f7 + cri_r16_f7 + cri_r18_f7 + cri_r20_f7 + cri_r22_f7 + cri_r24_f7 + oui_r2_f7 + oui_r4_f7 + oui_r6_f7 + oui_r8_f7 + oui_r10_f7 + oui_r12_f7 + oui_r14_f7 + oui_r16_f7 + oui_r18_f7 + oui_r20_f7 + oui_r22_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r3_f8 + cri_r5_f8 + cri_r7_f8 + cri_r9_f8 + cri_r11_f8 + cri_r13_f8 + cri_r15_f8 + cri_r17_f8 + cri_r19_f8 + cri_r21_f8 + cri_r23_f8 + oui_r1_f8 + oui_r3_f8 + oui_r5_f8 + oui_r7_f8 + oui_r9_f8 + oui_r11_f8 + oui_r13_f8 + oui_r15_f8 + oui_r17_f8 + oui_r19_f8 + oui_r21_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r4_f8 + cri_r6_f8 + cri_r8_f8 + cri_r10_f8 + cri_r12_f8 + cri_r14_f8 + cri_r16_f8 + cri_r18_f8 + cri_r20_f8 + cri_r22_f8 + cri_r24_f8 + oui_r2_f8 + oui_r4_f8 + oui_r6_f8 + oui_r8_f8 + oui_r10_f8 + oui_r12_f8 + oui_r14_f8 + oui_r16_f8 + oui_r18_f8 + oui_r20_f8 + oui_r22_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r3_f9 + cri_r5_f9 + cri_r7_f9 + cri_r9_f9 + cri_r11_f9 + cri_r13_f9 + cri_r15_f9 + cri_r17_f9 + cri_r19_f9 + cri_r21_f9 + cri_r23_f9 + oui_r1_f9 + oui_r3_f9 + oui_r5_f9 + oui_r7_f9 + oui_r9_f9 + oui_r11_f9 + oui_r13_f9 + oui_r15_f9 + oui_r17_f9 + oui_r19_f9 + oui_r21_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r4_f9 + cri_r6_f9 + cri_r8_f9 + cri_r10_f9 + cri_r12_f9 + cri_r14_f9 + cri_r16_f9 + cri_r18_f9 + cri_r20_f9 + cri_r22_f9 + cri_r24_f9 + oui_r2_f9 + oui_r4_f9 + oui_r6_f9 + oui_r8_f9 + oui_r10_f9 + oui_r12_f9 + oui_r14_f9 + oui_r16_f9 + oui_r18_f9 + oui_r20_f9 + oui_r22_f9 + oui_r24_f9) as f_cols_pentv3, sum(cri_r1_f10 + cri_r3_f10 + cri_r5_f10 + cri_r7_f10 + cri_r9_f10 + cri_r11_f10 + cri_r13_f10 + cri_r15_f10 + cri_r17_f10 + cri_r19_f10 + cri_r21_f10 + cri_r23_f10 + oui_r1_f10 + oui_r3_f10 + oui_r5_f10 + oui_r7_f10 + oui_r9_f10 + oui_r11_f10 + oui_r13_f10 + oui_r15_f10 + oui_r17_f10 + oui_r19_f10 + oui_r21_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r4_f10 + cri_r6_f10 + cri_r8_f10 + cri_r10_f10 + cri_r12_f10 + cri_r14_f10 + cri_r16_f10 + cri_r18_f10 + cri_r20_f10 + cri_r22_f10 + cri_r24_f10 + oui_r2_f10 + oui_r4_f10 + oui_r6_f10 + oui_r8_f10 + oui_r10_f10 + oui_r12_f10 + oui_r14_f10 + oui_r16_f10 + oui_r18_f10 + oui_r20_f10 + oui_r22_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r3_f11 + cri_r5_f11 + cri_r7_f11 + cri_r9_f11 + cri_r11_f11 + cri_r13_f11 + cri_r15_f11 + cri_r17_f11 + cri_r19_f11 + cri_r21_f11 + cri_r23_f11 + oui_r1_f11 + oui_r3_f11 + oui_r5_f11 + oui_r7_f11 + oui_r9_f11 + oui_r11_f11 + oui_r13_f11 + oui_r15_f11 + oui_r17_f11 + oui_r19_f11 + oui_r21_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r4_f11 + cri_r6_f11 + cri_r8_f11 + cri_r10_f11 + cri_r12_f11 + cri_r14_f11 + cri_r16_f11 + cri_r18_f11 + cri_r20_f11 + cri_r22_f11 + cri_r24_f11 + oui_r2_f11 + oui_r4_f11 + oui_r6_f11 + oui_r8_f11 + oui_r10_f11 + oui_r12_f11 + oui_r14_f11 + oui_r16_f11 + oui_r18_f11 + oui_r20_f11 + oui_r22_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r3_f12 + cri_r5_f12 + cri_r7_f12 + cri_r9_f12 + cri_r11_f12 + cri_r13_f12 + cri_r15_f12 + cri_r17_f12 + cri_r19_f12 + cri_r21_f12 + cri_r23_f12 + oui_r1_f12 + oui_r3_f12 + oui_r5_f12 + oui_r7_f12 + oui_r9_f12 + oui_r11_f12 + oui_r13_f12 + oui_r15_f12 + oui_r17_f12 + oui_r19_f12 + oui_r21_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r4_f12 + cri_r6_f12 + cri_r8_f12 + cri_r10_f12 + cri_r12_f12 + cri_r14_f12 + cri_r16_f12 + cri_r18_f12 + cri_r20_f12 + cri_r22_f12 + cri_r24_f12 + oui_r2_f12 + oui_r4_f12 + oui_r6_f12 + oui_r8_f12 + oui_r10_f12 + oui_r12_f12 + oui_r14_f12 + oui_r16_f12 + oui_r18_f12 + oui_r20_f12 + oui_r22_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r3_f13 + cri_r5_f13 + cri_r7_f13 + cri_r9_f13 + cri_r11_f13 + cri_r13_f13 + cri_r15_f13 + cri_r17_f13 + cri_r19_f13 + cri_r21_f13 + cri_r23_f13 + oui_r1_f13 + oui_r3_f13 + oui_r5_f13 + oui_r7_f13 + oui_r9_f13 + oui_r11_f13 + oui_r13_f13 + oui_r15_f13 + oui_r17_f13 + oui_r19_f13 + oui_r21_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r4_f13 + cri_r6_f13 + cri_r8_f13 + cri_r10_f13 + cri_r12_f13 + cri_r14_f13 + cri_r16_f13 + cri_r18_f13 + cri_r20_f13 + cri_r22_f13 + cri_r24_f13 + oui_r2_f13 + oui_r4_f13 + oui_r6_f13 + oui_r8_f13 + oui_r10_f13 + oui_r12_f13 + oui_r14_f13 + oui_r16_f13 + oui_r18_f13 + oui_r20_f13 + oui_r22_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r3_f14 + cri_r5_f14 + cri_r7_f14 + cri_r9_f14 + cri_r11_f14 + cri_r13_f14 + cri_r15_f14 + cri_r17_f14 + cri_r19_f14 + cri_r21_f14 + cri_r23_f14 + oui_r1_f14 + oui_r3_f14 + oui_r5_f14 + oui_r7_f14 + oui_r9_f14 + oui_r11_f14 + oui_r13_f14 + oui_r15_f14 + oui_r17_f14 + oui_r19_f14 + oui_r21_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r4_f14 + cri_r6_f14 + cri_r8_f14 + cri_r10_f14 + cri_r12_f14 + cri_r14_f14 + cri_r16_f14 + cri_r18_f14 + cri_r20_f14 + cri_r22_f14 + cri_r24_f14 + oui_r2_f14 + oui_r4_f14 + oui_r6_f14 + oui_r8_f14 + oui_r10_f14 + oui_r12_f14 + oui_r14_f14 + oui_r16_f14 + oui_r18_f14 + oui_r20_f14 + oui_r22_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r3_f15 + cri_r5_f15 + cri_r7_f15 + cri_r9_f15 + cri_r11_f15 + cri_r13_f15 + cri_r15_f15 + cri_r17_f15 + cri_r19_f15 + cri_r21_f15 + cri_r23_f15 + oui_r1_f15 + oui_r3_f15 + oui_r5_f15 + oui_r7_f15 + oui_r9_f15 + oui_r11_f15 + oui_r13_f15 + oui_r15_f15 + oui_r17_f15 + oui_r19_f15 + oui_r21_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r4_f15 + cri_r6_f15 + cri_r8_f15 + cri_r10_f15 + cri_r12_f15 + cri_r14_f15 + cri_r16_f15 + cri_r18_f15 + cri_r20_f15 + cri_r22_f15 + cri_r24_f15 + oui_r2_f15 + oui_r4_f15 + oui_r6_f15 + oui_r8_f15 + oui_r10_f15 + oui_r12_f15 + oui_r14_f15 + oui_r16_f15 + oui_r18_f15 + oui_r20_f15 + oui_r22_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r3_f16 + cri_r5_f16 + cri_r7_f16 + cri_r9_f16 + cri_r11_f16 + cri_r13_f16 + cri_r15_f16 + cri_r17_f16 + cri_r19_f16 + cri_r21_f16 + cri_r23_f16 + oui_r1_f16 + oui_r3_f16 + oui_r5_f16 + oui_r7_f16 + oui_r9_f16 + oui_r11_f16 + oui_r13_f16 + oui_r15_f16 + oui_r17_f16 + oui_r19_f16 + oui_r21_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r4_f16 + cri_r6_f16 + cri_r8_f16 + cri_r10_f16 + cri_r12_f16 + cri_r14_f16 + cri_r16_f16 + cri_r18_f16 + cri_r20_f16 + cri_r22_f16 + cri_r24_f16 + oui_r2_f16 + oui_r4_f16 + oui_r6_f16 + oui_r8_f16 + oui_r10_f16 + oui_r12_f16 + oui_r14_f16 + oui_r16_f16 + oui_r18_f16 + oui_r20_f16 + oui_r22_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 + cri_r7_f17 + cri_r9_f17 + cri_r11_f17 + cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r1_f17 + oui_r3_f17 + oui_r5_f17 + oui_r7_f17 + oui_r9_f17 + oui_r11_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 + cri_r8_f17 + cri_r10_f17 + cri_r12_f17 + cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r2_f17 + oui_r4_f17 + oui_r6_f17 + oui_r8_f17 + oui_r10_f17 + oui_r12_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r3_f18 + cri_r5_f18 + cri_r7_f18 + cri_r9_f18 + cri_r11_f18 + cri_r13_f18 + cri_r15_f18 + cri_r17_f18 + cri_r19_f18 + cri_r21_f18 + cri_r23_f18 +oui_r1_f18 + oui_r3_f18 + oui_r5_f18 + oui_r7_f18 + oui_r9_f18 + oui_r11_f18 + oui_r13_f18 + oui_r15_f18 + oui_r17_f18 + oui_r19_f18 + oui_r21_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r4_f18 + cri_r6_f18 + cri_r8_f18 + cri_r10_f18 + cri_r12_f18 + cri_r14_f18 + cri_r16_f18 + cri_r18_f18 + cri_r20_f18 + cri_r22_f18 + cri_r24_f18 + oui_r2_f18 + oui_r4_f18 + oui_r6_f18 + oui_r8_f18 + oui_r10_f18 + oui_r12_f18 + oui_r14_f18 + oui_r16_f18 + oui_r18_f18 + oui_r20_f18 + oui_r22_f18 + oui_r24_f18) as f_cols_measles2, sum(ttri_r9_f1 + ttoui_r9_f1) as in_tt1, sum(ttri_r9_f2 + ttoui_r9_f2) as in_tt2, sum(ttri_r9_f3 + ttoui_r9_f3) as in_tt3, sum(ttri_r9_f4 + ttoui_r9_f4) as in_tt4, sum(ttri_r9_f5 + ttoui_r9_f5) as in_tt5, sum(ttri_r10_f1 + ttoui_r10_f1) as in_cba1, sum(ttri_r10_f2 + ttoui_r10_f2) as in_cba2, sum(ttri_r10_f3 + ttoui_r10_f3) as in_cba3, sum(ttri_r10_f4 + ttoui_r10_f4) as in_cba4, sum(ttri_r10_f5 + ttoui_r10_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r1_f1 + od_r3_f1 + od_r5_f1 + od_r7_f1 + od_r9_f1 + od_r11_f1 + od_r13_f1 + od_r15_f1 + od_r17_f1 + od_r19_f1 + od_r21_f1 + od_r23_f1) as m_cols_bcg, sum(od_r2_f1 + od_r4_f1 + od_r6_f1 + od_r8_f1 + od_r10_f1 + od_r12_f1 + od_r14_f1 + od_r16_f1 + od_r18_f1 + od_r20_f1 + od_r22_f1 + od_r24_f1) as f_cols_bcg, sum(od_r1_f2 + od_r3_f2 + od_r5_f2 + od_r7_f2 + od_r9_f2 + od_r11_f2 + od_r13_f2 + od_r15_f2 + od_r17_f2 + od_r19_f2 + od_r21_f2 + od_r23_f2) as m_cols_hepb, sum(od_r2_f2 + od_r4_f2 + od_r6_f2 + od_r8_f2 + od_r10_f2 + od_r12_f2 + od_r14_f2 + od_r16_f2 + od_r18_f2 + od_r20_f2 + od_r22_f2 + od_r24_f2) as f_cols_hepb, sum(od_r1_f3 + od_r3_f3 + od_r5_f3 + od_r7_f3 + od_r9_f3 + od_r11_f3 + od_r13_f3 + od_r15_f3 + od_r17_f3 + od_r19_f3 + od_r21_f3 + od_r23_f3) as m_cols_opv0, sum(od_r2_f3 + od_r4_f3 + od_r6_f3 + od_r8_f3 + od_r10_f3 + od_r12_f3 + od_r14_f3 + od_r16_f3 + od_r18_f3 + od_r20_f3 + od_r22_f3 + od_r24_f3) as f_cols_opv0, sum(od_r1_f4 + od_r3_f4 + od_r5_f4 + od_r7_f4 + od_r9_f4 + od_r11_f4 + od_r13_f4 + od_r15_f4 + od_r17_f4 + od_r19_f4 + od_r21_f4 + od_r23_f4) as m_cols_opv1, sum(od_r2_f4 + od_r4_f4 + od_r6_f4 + od_r8_f4 + od_r10_f4 + od_r12_f4 + od_r14_f4 + od_r16_f4 + od_r18_f4 + od_r20_f4 + od_r22_f4 + od_r24_f4) as f_cols_opv1, sum(od_r1_f5 + od_r3_f5 + od_r5_f5 + od_r7_f5 + od_r9_f5 + od_r11_f5 + od_r13_f5 + od_r15_f5 + od_r17_f5 + od_r19_f5 + od_r21_f5 + od_r23_f5) as m_cols_opv2, sum(od_r2_f5 + od_r4_f5 + od_r6_f5 + od_r8_f5 + od_r10_f5 + od_r12_f5 + od_r14_f5 + od_r16_f5 + od_r18_f5 + od_r20_f5 + od_r22_f5 + od_r24_f5) as f_cols_opv2, sum(od_r1_f6 + od_r3_f6 + od_r5_f6 + od_r7_f6 + od_r9_f6 + od_r11_f6 + od_r13_f6 + od_r15_f6 + od_r17_f6 + od_r19_f6 + od_r21_f6 + od_r23_f6) as m_cols_opv3, sum(od_r2_f6 + od_r4_f6 + od_r6_f6 + od_r8_f6 + od_r10_f6 + od_r12_f6 + od_r14_f6 + od_r16_f6 + od_r18_f6 + od_r20_f6 + od_r22_f6 + od_r24_f6) as f_cols_opv3, sum(od_r1_f7 + od_r3_f7 + od_r5_f7 + od_r7_f7 + od_r9_f7 + od_r11_f7 + od_r13_f7 + od_r15_f7 + od_r17_f7 + od_r19_f7 + od_r21_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r4_f7 + od_r6_f7 + od_r8_f7 + od_r10_f7 + od_r12_f7 + od_r14_f7 + od_r16_f7 + od_r18_f7 + od_r20_f7 + od_r22_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r3_f8 + od_r5_f8 + od_r7_f8 + od_r9_f8 + od_r11_f8 + od_r13_f8 + od_r15_f8 + od_r17_f8 + od_r19_f8 + od_r21_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r4_f8 + od_r6_f8 + od_r8_f8 + od_r10_f8 + od_r12_f8 + od_r14_f8 + od_r16_f8 + od_r18_f8 + od_r20_f8 + od_r22_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r3_f9 + od_r5_f9 + od_r7_f9 + od_r9_f9 + od_r11_f9 + od_r13_f9 + od_r15_f9 + od_r17_f9 + od_r19_f9 + od_r21_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r4_f9 + od_r6_f9 + od_r8_f9 + od_r10_f9 + od_r12_f9 + od_r14_f9 + od_r16_f9 + od_r18_f9 + od_r20_f9 + od_r22_f9 + od_r24_f9) as f_cols_pentv3, sum(od_r1_f10 + od_r3_f10 + od_r5_f10 + od_r7_f10 + od_r9_f10 + od_r11_f10 + od_r13_f10 + od_r15_f10 + od_r17_f10 + od_r19_f10 + od_r21_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r4_f10 + od_r6_f10 + od_r8_f10 + od_r10_f10 + od_r12_f10 + od_r14_f10 + od_r16_f10 + od_r18_f10 + od_r20_f10 + od_r22_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r3_f11 + od_r5_f11 + od_r7_f11 + od_r9_f11 + od_r11_f11 + od_r13_f11 + od_r15_f11 + od_r17_f11 + od_r19_f11 + od_r21_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r4_f11 + od_r6_f11 + od_r8_f11 + od_r10_f11 + od_r12_f11 + od_r14_f11 + od_r16_f11 + od_r18_f11 + od_r20_f11 + od_r22_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r3_f12 + od_r5_f12 + od_r7_f12 + od_r9_f12 + od_r11_f12 + od_r13_f12 + od_r15_f12 + od_r17_f12 + od_r19_f12 + od_r21_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r4_f12 + od_r6_f12 + od_r8_f12 + od_r10_f12 + od_r12_f12 + od_r14_f12 + od_r16_f12 + od_r18_f12 + od_r20_f12 + od_r22_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r3_f13 + od_r5_f13 + od_r7_f13 + od_r9_f13 + od_r11_f13 + od_r13_f13 + od_r15_f13 + od_r17_f13 + od_r19_f13 + od_r21_f13 + od_r23_f13) as m_cols_ipv, sum(od_r2_f13 + od_r4_f13 + od_r6_f13 + od_r8_f13 + od_r10_f13 + od_r12_f13 + od_r14_f13 + od_r16_f13 + od_r18_f13 + od_r20_f13 + od_r22_f13 + od_r24_f13) as m_cols_ipv, sum(od_r1_f14 + od_r3_f14 + od_r5_f14 + od_r7_f14 + od_r9_f14 + od_r11_f14 + od_r13_f14 + od_r15_f14 + od_r17_f14 + od_r19_f14 + od_r21_f14 + od_r23_f14) as m_cols_rota1, sum(od_r2_f14 + od_r4_f14 + od_r6_f14 + od_r8_f14 + od_r10_f14 + od_r12_f14 + od_r14_f14 + od_r16_f14 + od_r18_f14 + od_r20_f14 + od_r22_f14 + od_r24_f14) as f_cols_rota1, sum(od_r1_f15 + od_r3_f15 + od_r5_f15 + od_r7_f15 + od_r9_f15 + od_r11_f15 + od_r13_f15 + od_r15_f15 + od_r17_f15 + od_r19_f15 + od_r21_f15 + od_r23_f15) as m_cols_rota2, sum(od_r2_f15 + od_r4_f15 + od_r6_f15 + od_r8_f15 + od_r10_f15 + od_r12_f15 + od_r14_f15 + od_r16_f15 + od_r18_f15 + od_r20_f15 + od_r22_f15 + od_r24_f15) as f_cols_rota2, sum(od_r1_f16 + od_r3_f16 + od_r5_f16 + od_r7_f16 + od_r9_f16 + od_r11_f16 + od_r13_f16 + od_r15_f16 + od_r17_f16 + od_r19_f16 + od_r21_f16 + od_r23_f16) as m_cols_measles1, sum(od_r2_f16 + od_r4_f16 + od_r6_f16 + od_r8_f16 + od_r10_f16 + od_r12_f16 + od_r14_f16 + od_r16_f16 + od_r18_f16 + od_r20_f16 + od_r22_f16 + od_r24_f16) as f_cols_measles1, sum(od_r1_f17 + od_r3_f17 + od_r5_f17 + od_r7_f17 + od_r9_f17 + od_r11_f17 + od_r13_f17 + od_r15_f17 + od_r17_f17 + od_r19_f17 + od_r21_f17 + od_r23_f17) as m_cols_fully, sum(od_r2_f17 + od_r4_f17 + od_r6_f17 + od_r8_f17 + od_r10_f17 + od_r12_f17 + od_r14_f17 + od_r16_f17 + od_r18_f17 + od_r20_f17 + od_r22_f17 + od_r24_f17) as f_cols_fully, sum(od_r1_f18 + od_r3_f18 + od_r5_f18 + od_r7_f18 + od_r9_f18 + od_r11_f18 + od_r13_f18 + od_r15_f18 + od_r17_f18 + od_r19_f18 + od_r21_f18 + od_r23_f18) as m_cols_measles2, sum(od_r2_f18 + od_r4_f18 + od_r6_f18 + od_r8_f18 + od_r10_f18 + od_r12_f18 + od_r14_f18 + od_r16_f18 + od_r18_f18 + od_r20_f18 + od_r22_f18 + od_r24_f18) as f_cols_measles2, sum(ttod_r9_f1) as in_tt1, sum(ttod_r9_f2) as in_tt2, sum(ttod_r9_f3) as in_tt3, sum(ttod_r9_f4) as in_tt4, sum(ttod_r9_f5) as in_tt5, sum(ttod_r10_f1) as in_cba1, sum(ttod_r10_f2) as in_cba2, sum(ttod_r10_f3) as in_cba3, sum(ttod_r10_f4) as in_cba4, sum(ttod_r10_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district ";					
			}	//done	
			if($vacc_to == 'total_children' && $age_wise == '0to11'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \" 
					FROM (select distcode, sum(cri_r1_f1 + cri_r7_f1 + cri_r13_f1 + cri_r19_f1 +oui_r1_f1 + oui_r7_f1 + oui_r13_f1 + oui_r19_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r8_f1 + cri_r14_f1 + cri_r20_f1 +oui_r2_f1 + oui_r8_f1 + oui_r14_f1 + oui_r20_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r7_f2 + cri_r13_f2 + cri_r19_f2 +oui_r1_f2 + oui_r7_f2 + oui_r13_f2 + oui_r19_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r8_f2 + cri_r14_f2 + cri_r20_f2 +oui_r2_f2 + oui_r8_f2 + oui_r14_f2 + oui_r20_f2 ) as f_cols_hepb, sum(cri_r1_f3 + cri_r7_f3 + cri_r13_f3 + cri_r19_f3 +oui_r1_f3 + oui_r7_f3 + oui_r13_f3 + oui_r19_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r8_f3 + cri_r14_f3 + cri_r20_f3 +oui_r2_f3 + oui_r8_f3 + oui_r14_f3 + oui_r20_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r7_f4 + cri_r13_f4 + cri_r19_f4 +oui_r1_f4 + oui_r7_f4 + oui_r13_f4 + oui_r19_f4 ) as m_cols_opv1, sum(cri_r2_f4 + cri_r8_f4 + cri_r14_f4 + cri_r20_f4 +oui_r2_f4 + oui_r8_f4 + oui_r14_f4 + oui_r20_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r7_f5 + cri_r13_f5 + cri_r19_f5 +oui_r1_f5 + oui_r7_f5 + oui_r13_f5 + oui_r19_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r8_f5 + cri_r14_f5 + cri_r20_f5 +oui_r2_f5 + oui_r8_f5 + oui_r14_f5 + oui_r20_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r7_f6 + cri_r13_f6 + cri_r19_f6 +oui_r1_f6 + oui_r7_f6 + oui_r13_f6 + oui_r19_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r8_f6 + cri_r14_f6 + cri_r20_f6 +oui_r2_f6 + oui_r8_f6 + oui_r14_f6 + oui_r20_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r7_f7 + cri_r13_f7 + cri_r19_f7 +oui_r1_f7 + oui_r7_f7 + oui_r13_f7 + oui_r19_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r8_f7 + cri_r14_f7 + cri_r20_f7 +oui_r2_f7 + oui_r8_f7 + oui_r14_f7 + oui_r20_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r7_f8 + cri_r13_f8 + cri_r19_f8 +oui_r1_f8 + oui_r7_f8 + oui_r13_f8 + oui_r19_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r8_f8 + cri_r14_f8 + cri_r20_f8 +oui_r2_f8 + oui_r8_f8 + oui_r14_f8 + oui_r20_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r7_f9 + cri_r13_f9 + cri_r19_f9 +oui_r1_f9 + oui_r7_f9 + oui_r13_f9 + oui_r19_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r8_f9 + cri_r14_f9 + cri_r20_f9 +oui_r2_f9 + oui_r8_f9 + oui_r14_f9 + oui_r20_f9) as f_cols_pentv3,sum(cri_r1_f10 + cri_r7_f10 + cri_r13_f10 + cri_r19_f10 +oui_r1_f10 + oui_r7_f10 + oui_r13_f10 + oui_r19_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r8_f10 + cri_r14_f10 + cri_r20_f10 +oui_r2_f10 + oui_r8_f10 + oui_r14_f10 + oui_r20_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r7_f11 + cri_r13_f11 + cri_r19_f11 +oui_r1_f11 + oui_r7_f11 + oui_r13_f11 + oui_r19_f11) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r8_f11 + cri_r14_f11 + cri_r20_f11 +oui_r2_f11 + oui_r8_f11 + oui_r14_f11 + oui_r20_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r7_f12 + cri_r13_f12 + cri_r19_f12 +oui_r1_f12 + oui_r7_f12 + oui_r13_f12 + oui_r19_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r8_f12 + cri_r14_f12 + cri_r20_f12 +oui_r2_f12 + oui_r8_f12 + oui_r14_f12 + oui_r20_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r7_f13 + cri_r13_f13 + cri_r19_f13 +oui_r1_f13 + oui_r7_f13 + oui_r13_f13 + oui_r19_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r8_f13 + cri_r14_f13 + cri_r20_f13 +oui_r2_f13 + oui_r8_f13 + oui_r14_f13 + oui_r20_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r7_f14 + cri_r13_f14 + cri_r19_f14 +oui_r1_f14 + oui_r7_f14 + oui_r13_f14 + oui_r19_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r8_f14 + cri_r14_f14 + cri_r20_f14 +oui_r2_f14 + oui_r8_f14 + oui_r14_f14 + oui_r20_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r7_f15 + cri_r13_f15 + cri_r19_f15 +oui_r1_f15 + oui_r7_f15 + oui_r13_f15 + oui_r19_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r8_f15 + cri_r14_f15 + cri_r20_f15 +oui_r2_f15 + oui_r8_f15 + oui_r14_f15 + oui_r20_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r7_f16 + cri_r13_f16 + cri_r19_f16 +oui_r1_f16 + oui_r7_f16 + oui_r13_f16 + oui_r19_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r8_f16 + cri_r14_f16 + cri_r20_f16 +oui_r2_f16 + oui_r8_f16 + oui_r14_f16 + oui_r20_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r7_f17 + cri_r13_f17 + cri_r19_f17 +oui_r1_f17 + oui_r7_f17 + oui_r13_f17 + oui_r19_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r8_f17 + cri_r14_f17 + cri_r20_f17 +oui_r2_f17 + oui_r8_f17 + oui_r14_f17 + oui_r20_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r7_f18 + cri_r13_f18 + cri_r19_f18 +oui_r1_f18 + oui_r7_f18 + oui_r13_f18 + oui_r19_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r8_f18 + cri_r14_f18 + cri_r20_f18 +oui_r2_f18 + oui_r8_f18 + oui_r14_f18 + oui_r20_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r1_f1 + od_r7_f1 + od_r13_f1 + od_r19_f1) as m_cols_bcg, sum(od_r2_f1 + od_r8_f1 + od_r14_f1 + od_r20_f1) as f_cols_bcg, sum(od_r1_f2 + od_r7_f2 + od_r13_f2 + od_r19_f2) as m_cols_hepb, sum(od_r2_f2 + od_r8_f2 + od_r14_f2 + od_r20_f2) as f_cols_hepb, sum(od_r1_f3 + od_r7_f3 + od_r13_f3 + od_r19_f3) as m_cols_opv0, sum(od_r2_f3 + od_r8_f3 + od_r14_f3 + od_r20_f3) as f_cols_opv0, sum(od_r1_f4 + od_r7_f4 + od_r13_f4 + od_r19_f4) as m_cols_opv1, sum(od_r2_f4 + od_r8_f4 + od_r14_f4 + od_r20_f4) as f_cols_opv1, sum(od_r1_f5 + od_r7_f5 + od_r13_f5 + od_r19_f5) as m_cols_opv2, sum(od_r2_f5 + od_r8_f5 + od_r14_f5 + od_r20_f5) as f_cols_opv2, sum(od_r1_f6 + od_r7_f6 + od_r13_f6 + od_r19_f6) as m_cols_opv3, sum(od_r2_f6 + od_r8_f6 + od_r14_f6 + od_r20_f6) as f_cols_opv3, sum(od_r1_f7 + od_r7_f7 + od_r13_f7 + od_r19_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r8_f7 + od_r14_f7 + od_r20_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r7_f8 + od_r13_f8 + od_r19_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r8_f8 + od_r14_f8 + od_r20_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r7_f9 + od_r13_f9 + od_r19_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r8_f9 + od_r14_f9 + od_r20_f9) as f_cols_pentv3,sum(od_r1_f10 + od_r7_f10 + od_r13_f10 + od_r19_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r8_f10 + od_r14_f10 + od_r20_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r7_f11 + od_r13_f11 + od_r19_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r8_f11 + od_r14_f11 + od_r20_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r7_f12 + od_r13_f12 + od_r19_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r8_f12 + od_r14_f12 + od_r20_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r7_f13 + od_r13_f13 + od_r19_f13) as m_cols_ipv, sum(od_r2_f13 + od_r8_f13 + od_r14_f13 + od_r20_f13) as f_cols_ipv, sum(od_r1_f14 + od_r7_f14 + od_r13_f14 + od_r19_f14) as m_cols_rota1, sum(od_r2_f14 + od_r8_f14 + od_r14_f14 + od_r20_f14) as f_cols_rota1, sum(od_r1_f15 + od_r7_f15 + od_r13_f15 + od_r19_f15) as m_cols_rota2, sum(od_r2_f15 + od_r8_f15 + od_r14_f15 + od_r20_f15) as f_cols_rota2, sum(od_r1_f16 + od_r7_f16 + od_r13_f16 + od_r19_f16) as m_cols_measles1, sum(od_r2_f16 + od_r8_f16 + od_r14_f16 + od_r20_f16) as f_cols_measles1, sum(od_r1_f17 + od_r7_f17 + od_r13_f17 + od_r19_f17) as m_cols_fully, sum(od_r2_f17 + od_r8_f17 + od_r14_f17 + od_r20_f17) as f_cols_fully, sum(od_r1_f18 + od_r7_f18 + od_r13_f18 + od_r19_f18) as m_cols_measles2, sum(od_r2_f18 + od_r8_f18 + od_r14_f18 + od_r20_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district ";					
			}//done
			if($vacc_to == 'total_children' && $age_wise == '12to23'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \"
					FROM (select distcode, sum(cri_r3_f1 + cri_r9_f1 + cri_r15_f1 + cri_r21_f1 +oui_r3_f1 + oui_r9_f1 + oui_r15_f1 + oui_r21_f1) as m_cols_bcg, sum(cri_r4_f1 + cri_r10_f1 + cri_r16_f1 + cri_r22_f1 +oui_r4_f1 + oui_r10_f1 + oui_r16_f1 + oui_r22_f1) as f_cols_bcg, sum(cri_r3_f2 + cri_r9_f2 + cri_r15_f2 + cri_r21_f2 + oui_r3_f2 + oui_r9_f2 + oui_r15_f2 + oui_r21_f2) as m_cols_hepb, sum(cri_r4_f2 + cri_r10_f2 + cri_r16_f2 + cri_r22_f2 +oui_r4_f2 + oui_r10_f2 + oui_r16_f2 + oui_r22_f2) as f_cols_hepb, sum(cri_r3_f3 + cri_r9_f3 + cri_r15_f3 + cri_r21_f3 +oui_r3_f3 + oui_r9_f3 + oui_r15_f3 + oui_r21_f3) as m_cols_opv0, sum(cri_r4_f3 + cri_r10_f3 + cri_r16_f3 + cri_r22_f3 +oui_r4_f3 + oui_r10_f3 + oui_r16_f3 + oui_r22_f3) as f_cols_opv0, sum(cri_r3_f4 + cri_r9_f4 + cri_r15_f4 + cri_r21_f4 +oui_r3_f4 + oui_r9_f4 + oui_r15_f4 + oui_r21_f4) as m_cols_opv1, sum(oui_r4_f4 + oui_r10_f4 + oui_r16_f4 + oui_r22_f4+cri_r4_f4 + cri_r10_f4 + cri_r16_f4 + cri_r22_f4) as f_cols_opv1, sum(cri_r3_f5 + cri_r9_f5 + cri_r15_f5 + cri_r21_f5 +oui_r3_f5 + oui_r9_f5 + oui_r15_f5 + oui_r21_f5) as m_cols_opv2, sum(cri_r4_f5 + cri_r10_f5 + cri_r16_f5 + cri_r22_f5+oui_r4_f5 + oui_r10_f5 + oui_r16_f5 + oui_r22_f5) as f_cols_opv2, sum(cri_r3_f6 + cri_r9_f6 + cri_r15_f6 + cri_r21_f6 +oui_r3_f6 + oui_r9_f6 + oui_r15_f6 + oui_r21_f6) as m_cols_opv3, sum(cri_r4_f6 + cri_r10_f6 + cri_r16_f6 + cri_r22_f6 +oui_r4_f6 + oui_r10_f6 + oui_r16_f6 + oui_r22_f6) as f_cols_opv3, sum(cri_r3_f7 + cri_r9_f7 + cri_r15_f7 + cri_r21_f7 +oui_r3_f7 + oui_r9_f7 + oui_r15_f7 + oui_r21_f7) as m_cols_pentv1, sum(cri_r4_f7 + cri_r10_f7 + cri_r16_f7 + cri_r22_f7 +oui_r4_f7 + oui_r10_f7 + oui_r16_f7 + oui_r22_f7) as f_cols_pentv1, sum(cri_r3_f8 + cri_r9_f8 + cri_r15_f8 + cri_r21_f8 +oui_r3_f8 + oui_r9_f8 + oui_r15_f8 + oui_r21_f8) as m_cols_pentv2, sum(cri_r4_f8 + cri_r10_f8 + cri_r16_f8 + cri_r22_f8 +oui_r4_f8 + oui_r10_f8 + oui_r16_f8 + oui_r22_f8) as f_cols_pentv2, sum(cri_r3_f9 + cri_r9_f9 + cri_r15_f9 + cri_r21_f9 +oui_r3_f9 + oui_r9_f9 + oui_r15_f9 + oui_r21_f9) as m_cols_pentv3, sum(cri_r4_f9 + cri_r10_f9 + cri_r16_f9 + cri_r22_f9 +oui_r4_f9 + oui_r10_f9 + oui_r16_f9 + oui_r22_f9) as f_cols_pentv3,sum(cri_r3_f10 + cri_r9_f10 + cri_r15_f10 + cri_r21_f10 +oui_r3_f10 + oui_r9_f10 + oui_r15_f10 + oui_r21_f10) as m_cols_pcv10_1, sum(cri_r4_f10 + cri_r10_f10 + cri_r16_f10 + cri_r22_f10 +oui_r4_f10 + oui_r10_f10 + oui_r16_f10 + oui_r22_f10) as f_cols_pcv10_1, sum(cri_r3_f11 + cri_r9_f11 + cri_r15_f11 + cri_r21_f11 +oui_r3_f11 + oui_r9_f11 + oui_r15_f11 + oui_r21_f11) as m_cols_pcv10_2, sum(cri_r4_f11 + cri_r10_f11 + cri_r16_f11 + cri_r22_f11 +oui_r4_f11 + oui_r10_f11 + oui_r16_f11 + oui_r22_f11) as f_cols_pcv10_2, sum(cri_r3_f12 + cri_r9_f12 + cri_r15_f12 + cri_r21_f12 +oui_r3_f12 + oui_r9_f12 + oui_r15_f12 + oui_r21_f12) as m_cols_pcv10_3, sum(cri_r4_f12 + cri_r10_f12 + cri_r16_f12 + cri_r22_f12 +oui_r4_f12 + oui_r10_f12 + oui_r16_f12 + oui_r22_f12) as f_cols_pcv10_3, sum(cri_r3_f13 + cri_r9_f13 + cri_r15_f13 + cri_r21_f13 +oui_r3_f13 + oui_r9_f13 + oui_r15_f13 + oui_r21_f13) as m_cols_ipv, sum(cri_r4_f13 + cri_r10_f13 + cri_r16_f13 + cri_r22_f13 +oui_r4_f13 + oui_r10_f13 + oui_r16_f13 + oui_r22_f13) as f_cols_ipv, sum(cri_r3_f14 + cri_r9_f14 + cri_r15_f14 + cri_r21_f14 +oui_r3_f14 + oui_r9_f14 + oui_r15_f14 + oui_r21_f14) as m_cols_rota1, sum(cri_r4_f14 + cri_r10_f14 + cri_r16_f14 + cri_r22_f14 +oui_r4_f14 + oui_r10_f14 + oui_r16_f14 + oui_r22_f14) as f_cols_rota1, sum(cri_r3_f15 + cri_r9_f15 + cri_r15_f15 + cri_r21_f15 +oui_r3_f15 + oui_r9_f15 + oui_r15_f15 + oui_r21_f15) as m_cols_rota2, sum(cri_r4_f15 + cri_r10_f15 + cri_r16_f15 + cri_r22_f15 +oui_r4_f15 + oui_r10_f15 + oui_r16_f15 + oui_r22_f15) as f_cols_rota2, sum(cri_r3_f16 + cri_r9_f16 + cri_r15_f16 + cri_r21_f16 +oui_r3_f16 + oui_r9_f16 + oui_r15_f16 + oui_r21_f16) as m_cols_measles1, sum(cri_r4_f16 + cri_r10_f16 + cri_r16_f16 + cri_r22_f16 +oui_r4_f16 + oui_r10_f16 + oui_r16_f16 + oui_r22_f16) as f_cols_measles1, sum(cri_r3_f17 + cri_r9_f17 + cri_r15_f17 + cri_r21_f17 + oui_r3_f17 + oui_r9_f17 + oui_r15_f17 + oui_r21_f17) as m_cols_fully, sum(cri_r4_f17 + cri_r10_f17 + cri_r16_f17 + cri_r22_f17 +oui_r4_f17 + oui_r10_f17 + oui_r16_f17 + oui_r22_f17) as f_cols_fully, sum(cri_r3_f18 + cri_r9_f18 + cri_r15_f18 + cri_r21_f18 +oui_r3_f18 + oui_r9_f18 + oui_r15_f18 + oui_r21_f18) as m_cols_measles2, sum(cri_r4_f18 + cri_r10_f18 + cri_r16_f18 + cri_r22_f18 +oui_r4_f18 + oui_r10_f18 + oui_r16_f18 + oui_r22_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r3_f1 + od_r9_f1 + od_r15_f1 + od_r21_f1) as m_cols_bcg, sum(od_r4_f1 + od_r10_f1 + od_r16_f1 + od_r22_f1) as f_cols_bcg, sum(od_r3_f2 + od_r9_f2 + od_r15_f2 + od_r21_f2) as m_cols_hepb, sum(od_r4_f2 + od_r10_f2 + od_r16_f2 + od_r22_f2) as f_cols_hepb, sum(od_r3_f3 + od_r9_f3 + od_r15_f3 + od_r21_f3) as m_cols_opv0, sum(od_r4_f3 + od_r10_f3 + od_r16_f3 + od_r22_f3) as f_cols_opv0, sum(od_r3_f4 + od_r9_f4 + od_r15_f4 + od_r21_f4) as m_cols_opv1, sum(od_r4_f4 + od_r10_f4 + od_r16_f4 + od_r22_f4) as f_cols_opv1, sum(od_r3_f5 + od_r9_f5 + od_r15_f5 + od_r21_f5) as m_cols_opv2, sum(od_r4_f5 + od_r10_f5 + od_r16_f5 + od_r22_f5) as f_cols_opv2, sum(od_r3_f6 + od_r9_f6 + od_r15_f6 + od_r21_f6) as m_cols_opv3, sum(od_r4_f6 + od_r10_f6 + od_r16_f6 + od_r22_f6) as f_cols_opv3, sum(od_r3_f7 + od_r9_f7 + od_r15_f7 + od_r21_f7) as m_cols_pentv1, sum(od_r4_f7 + od_r10_f7 + od_r16_f7 + od_r22_f7) as f_cols_pentv1, sum(od_r3_f8 + od_r9_f8 + od_r15_f8 + od_r21_f8) as m_cols_pentv2, sum(od_r4_f8 + od_r10_f8 + od_r16_f8 + od_r22_f8) as f_cols_pentv2, sum(od_r3_f9 + od_r9_f9 + od_r15_f9 + od_r21_f9) as m_cols_pentv3, sum(od_r4_f9 + od_r10_f9 + od_r16_f9 + od_r22_f9) as f_cols_pentv3,sum(od_r3_f10 + od_r9_f10 + od_r15_f10 + od_r21_f10) as m_cols_pcv10_1, sum(od_r4_f10 + od_r10_f10 + od_r16_f10 + od_r22_f10) as f_cols_pcv10_1, sum(od_r3_f11 + od_r9_f11 + od_r15_f11 + od_r21_f11) as m_cols_pcv10_2, sum(od_r4_f11 + od_r10_f11 + od_r16_f11 + od_r22_f11) as f_cols_pcv10_2, sum(od_r3_f12 + od_r9_f12 + od_r15_f12 + od_r21_f12) as m_cols_pcv10_3, sum(od_r4_f12 + od_r10_f12 + od_r16_f12 + od_r22_f12) as f_cols_pcv10_3, sum(od_r3_f13 + od_r9_f13 + od_r15_f13 + od_r21_f13) as m_cols_ipv, sum(od_r4_f13 + od_r10_f13 + od_r16_f13 + od_r22_f13) as f_cols_ipv, sum(od_r3_f14 + od_r9_f14 + od_r15_f14 + od_r21_f14) as m_cols_rota1, sum(od_r4_f14 + od_r10_f14 + od_r16_f14 + od_r22_f14) as f_cols_rota1, sum(od_r3_f15 + od_r9_f15 + od_r15_f15 + od_r21_f15) as m_cols_rota2, sum(od_r4_f15 + od_r10_f15 + od_r16_f15 + od_r22_f15) as f_cols_rota2, sum(od_r3_f16 + od_r9_f16 + od_r15_f16 + od_r21_f16) as m_cols_measles1, sum(od_r4_f16 + od_r10_f16 + od_r16_f16 + od_r22_f16) as f_cols_measles1, sum(od_r3_f17 + od_r9_f17 + od_r15_f17 + od_r21_f17) as m_cols_fully, sum(od_r4_f17 + od_r10_f17 + od_r16_f17 + od_r22_f17) as f_cols_fully, sum(od_r3_f18 + od_r9_f18 + od_r15_f18 + od_r21_f18) as m_cols_measles2, sum(od_r4_f18 + od_r10_f18 + od_r16_f18 + od_r22_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done
			if($vacc_to == 'total_children' && $age_wise == 'above2'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \"
					FROM (select distcode, sum(cri_r5_f1 + cri_r11_f1 + cri_r17_f1 + cri_r23_f1 +oui_r5_f1 + oui_r11_f1 + oui_r17_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r6_f1 + cri_r12_f1 + cri_r18_f1 + cri_r24_f1 +oui_r6_f1 + oui_r12_f1 + oui_r18_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r5_f2 + cri_r11_f2 + cri_r17_f2 + cri_r23_f2 +oui_r5_f2 + oui_r11_f2 + oui_r17_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r6_f2 + cri_r12_f2 + cri_r18_f2 + cri_r24_f2 +oui_r6_f2 + oui_r12_f2 + oui_r18_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r5_f3 + cri_r11_f3 + cri_r17_f3 + cri_r23_f3 +oui_r5_f3 + oui_r11_f3 + oui_r17_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r6_f3 + cri_r12_f3 + cri_r18_f3 + cri_r24_f3 +oui_r6_f3 + oui_r12_f3 + oui_r18_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r5_f4 + cri_r11_f4 + cri_r17_f4 + cri_r23_f4 +oui_r5_f4 + oui_r11_f4 + oui_r17_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r6_f4 + cri_r12_f4 + cri_r18_f4 + cri_r24_f4 +oui_r6_f4 + oui_r12_f4 + oui_r18_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r5_f5 + cri_r11_f5 + cri_r17_f5 + cri_r23_f5 +oui_r5_f5 + oui_r11_f5 + oui_r17_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r6_f5 + cri_r12_f5 + cri_r18_f5 + cri_r24_f5 +oui_r6_f5 + oui_r12_f5 + oui_r18_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r5_f6 + cri_r11_f6 + cri_r17_f6 + cri_r23_f6 +oui_r5_f6 + oui_r11_f6 + oui_r17_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r6_f6 + cri_r12_f6 + cri_r18_f6 + cri_r24_f6 +oui_r6_f6 + oui_r12_f6 + oui_r18_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r5_f7 + cri_r11_f7 + cri_r17_f7 + cri_r23_f7 +oui_r5_f7 + oui_r11_f7 + oui_r17_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r6_f7 + cri_r12_f7 + cri_r18_f7 + cri_r24_f7 +oui_r6_f7 + oui_r12_f7 + oui_r18_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r5_f8 + cri_r11_f8 + cri_r17_f8 + cri_r23_f8 +oui_r5_f8 + oui_r11_f8 + oui_r17_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r6_f8 + cri_r12_f8 + cri_r18_f8 + cri_r24_f8 +oui_r6_f8 + oui_r12_f8 + oui_r18_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r5_f9 + cri_r11_f9 + cri_r17_f9 + cri_r23_f9 +oui_r5_f9 + oui_r11_f9 + oui_r17_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r6_f9 + cri_r12_f9 + cri_r18_f9 + cri_r24_f9 +oui_r6_f9 + oui_r12_f9 + oui_r18_f9 + oui_r24_f9) as f_cols_pentv3,sum(cri_r5_f10 + cri_r11_f10 + cri_r17_f10 + cri_r23_f10 +oui_r5_f10 + oui_r11_f10 + oui_r17_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r6_f10 + cri_r12_f10 + cri_r18_f10 + cri_r24_f10 +oui_r6_f10 + oui_r12_f10 + oui_r18_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r5_f11 + cri_r11_f11 + cri_r17_f11 + cri_r23_f11 +oui_r5_f11 + oui_r11_f11 + oui_r17_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r6_f11 + cri_r12_f11 + cri_r18_f11 + cri_r24_f11 +oui_r6_f11 + oui_r12_f11 + oui_r18_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r5_f12 + cri_r11_f12 + cri_r17_f12 + cri_r23_f12 +oui_r5_f12 + oui_r11_f12 + oui_r17_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r6_f12 + cri_r12_f12 + cri_r18_f12 + cri_r24_f12 +oui_r6_f12 + oui_r12_f12 + oui_r18_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r5_f13 + cri_r11_f13 + cri_r17_f13 + cri_r23_f13 +oui_r5_f13 + oui_r11_f13 + oui_r17_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r6_f13 + cri_r12_f13 + cri_r18_f13 + cri_r24_f13 +oui_r6_f13 + oui_r12_f13 + oui_r18_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r5_f14 + cri_r11_f14 + cri_r17_f14 + cri_r23_f14 +oui_r5_f14 + oui_r11_f14 + oui_r17_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r6_f14 + cri_r12_f14 + cri_r18_f14 + cri_r24_f14 +oui_r6_f14 + oui_r12_f14 + oui_r18_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r5_f15 + cri_r11_f15 + cri_r17_f15 + cri_r23_f15 +oui_r5_f15 + oui_r11_f15 + oui_r17_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r6_f15 + cri_r12_f15 + cri_r18_f15 + cri_r24_f15 +oui_r6_f15 + oui_r12_f15 + oui_r18_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r5_f16 + cri_r11_f16 + cri_r17_f16 + cri_r23_f16 +oui_r5_f16 + oui_r11_f16 + oui_r17_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r6_f16 + cri_r12_f16 + cri_r18_f16 + cri_r24_f16 +oui_r6_f16 + oui_r12_f16 + oui_r18_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r5_f17 + cri_r11_f17 + cri_r17_f17 + cri_r23_f17 +oui_r5_f17 + oui_r11_f17 + oui_r17_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r6_f17 + cri_r12_f17 + cri_r18_f17 + cri_r24_f17 +oui_r6_f17 + oui_r12_f17 + oui_r18_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r5_f18 + cri_r11_f18 + cri_r17_f18 + cri_r23_f18 +oui_r5_f18 + oui_r11_f18 + oui_r17_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r6_f18 + cri_r12_f18 + cri_r18_f18 + cri_r24_f18 +oui_r6_f18 + oui_r12_f18 + oui_r18_f18 + oui_r24_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r5_f1 + od_r11_f1 + od_r17_f1 + od_r23_f1) as m_cols_bcg, sum(od_r6_f1 + od_r12_f1 + od_r18_f1 + od_r24_f1) as f_cols_bcg, sum(od_r5_f2 + od_r11_f2 + od_r17_f2 + od_r23_f2) as m_cols_hepb, sum(od_r6_f2 + od_r12_f2 + od_r18_f2 + od_r24_f2) as f_cols_hepb, sum(od_r5_f3 + od_r11_f3 + od_r17_f3 + od_r23_f3) as m_cols_opv0, sum(od_r6_f3 + od_r12_f3 + od_r18_f3 + od_r24_f3) as f_cols_opv0, sum(od_r5_f4 + od_r11_f4 + od_r17_f4 + od_r23_f4) as m_cols_opv1, sum(od_r6_f4 + od_r12_f4 + od_r18_f4 + od_r24_f4) as f_cols_opv1, sum(od_r5_f5 + od_r11_f5 + od_r17_f5 + od_r23_f5) as m_cols_opv2, sum(od_r6_f5 + od_r12_f5 + od_r18_f5 + od_r24_f5) as f_cols_opv2, sum(od_r5_f6 + od_r11_f6 + od_r17_f6 + od_r23_f6) as m_cols_opv3, sum(od_r6_f6 + od_r12_f6 + od_r18_f6 + od_r24_f6) as f_cols_opv3, sum(od_r5_f7 + od_r11_f7 + od_r17_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r6_f7 + od_r12_f7 + od_r18_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r5_f8 + od_r11_f8 + od_r17_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r6_f8 + od_r12_f8 + od_r18_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r5_f9 + od_r11_f9 + od_r17_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r6_f9 + od_r12_f9 + od_r18_f9 + od_r24_f9) as f_cols_pentv3,sum(od_r5_f10 + od_r11_f10 + od_r17_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r6_f10 + od_r12_f10 + od_r18_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r5_f11 + od_r11_f11 + od_r17_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r6_f11 + od_r12_f11 + od_r18_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r5_f12 + od_r11_f12 + od_r17_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r6_f12 + od_r12_f12 + od_r18_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r5_f13 + od_r11_f13 + od_r17_f13 + od_r23_f13) as m_cols_ipv, sum(od_r6_f13 + od_r12_f13 + od_r18_f13 + od_r24_f13) as f_cols_ipv, sum(od_r5_f14 + od_r11_f14 + od_r17_f14 + od_r23_f14) as m_cols_rota1, sum(od_r6_f14 + od_r12_f14 + od_r18_f14 + od_r24_f14) as f_cols_rota1, sum(od_r5_f15 + od_r11_f15 + od_r17_f15 + od_r23_f15) as m_cols_rota2, sum(od_r6_f15 + od_r12_f15 + od_r18_f15 + od_r24_f15) as f_cols_rota2, sum(od_r5_f16 + od_r11_f16 + od_r17_f16 + od_r23_f16) as m_cols_measles1, sum(od_r6_f16 + od_r12_f16 + od_r18_f16 + od_r24_f16) as f_cols_measles1, sum(od_r5_f17 + od_r11_f17 + od_r17_f17 + od_r23_f17) as m_cols_fully, sum(od_r6_f17 + od_r12_f17 + od_r18_f17 + od_r24_f17) as f_cols_fully, sum(od_r5_f18 + od_r11_f18 + od_r17_f18 + od_r23_f18) as m_cols_measles2, sum(od_r6_f18 + od_r12_f18 + od_r18_f18 + od_r24_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";					
			}//done
			if($vacc_to == 'gender' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
					FROM (select distcode, sum(cri_r1_f1 + cri_r3_f1 + cri_r5_f1 + cri_r7_f1 + cri_r9_f1 + cri_r11_f1 + cri_r13_f1 + cri_r15_f1 + cri_r17_f1 + cri_r19_f1 + cri_r21_f1 + cri_r23_f1 +oui_r1_f1 + oui_r3_f1 + oui_r5_f1 + oui_r7_f1 + oui_r9_f1 + oui_r11_f1 + oui_r13_f1 + oui_r15_f1 + oui_r17_f1 + oui_r19_f1 + oui_r21_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r4_f1 + cri_r6_f1 + cri_r8_f1 + cri_r10_f1 + cri_r12_f1 + cri_r14_f1 + cri_r16_f1 + cri_r18_f1 + cri_r20_f1 + cri_r22_f1 + cri_r24_f1 +oui_r2_f1 + oui_r4_f1 + oui_r6_f1 + oui_r8_f1 + oui_r10_f1 + oui_r12_f1 + oui_r14_f1 + oui_r16_f1 + oui_r18_f1 + oui_r20_f1 + oui_r22_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r3_f2 + cri_r5_f2 + cri_r7_f2 + cri_r9_f2 + cri_r11_f2 + cri_r13_f2 + cri_r15_f2 + cri_r17_f2 + cri_r19_f2 + cri_r21_f2 + cri_r23_f2 +oui_r1_f2 + oui_r3_f2 + oui_r5_f2 + oui_r7_f2 + oui_r9_f2 + oui_r11_f2 + oui_r13_f2 + oui_r15_f2 + oui_r17_f2 + oui_r19_f2 + oui_r21_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r4_f2 + cri_r6_f2 + cri_r8_f2 + cri_r10_f2 + cri_r12_f2 + cri_r14_f2 + cri_r16_f2 + cri_r18_f2 + cri_r20_f2 + cri_r22_f2 + cri_r24_f2 +oui_r2_f2 + oui_r4_f2 + oui_r6_f2 + oui_r8_f2 + oui_r10_f2 + oui_r12_f2 + oui_r14_f2 + oui_r16_f2 + oui_r18_f2 + oui_r20_f2 + oui_r22_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r1_f3 + cri_r3_f3 + cri_r5_f3 + cri_r7_f3 + cri_r9_f3 + cri_r11_f3 + cri_r13_f3 + cri_r15_f3 + cri_r17_f3 + cri_r19_f3 + cri_r21_f3 + cri_r23_f3 +oui_r1_f3 + oui_r3_f3 + oui_r5_f3 + oui_r7_f3 + oui_r9_f3 + oui_r11_f3 + oui_r13_f3 + oui_r15_f3 + oui_r17_f3 + oui_r19_f3 + oui_r21_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r4_f3 + cri_r6_f3 + cri_r8_f3 + cri_r10_f3 + cri_r12_f3 + cri_r14_f3 + cri_r16_f3 + cri_r18_f3 + cri_r20_f3 + cri_r22_f3 + cri_r24_f3 +oui_r2_f3 + oui_r4_f3 + oui_r6_f3 + oui_r8_f3 + oui_r10_f3 + oui_r12_f3 + oui_r14_f3 + oui_r16_f3 + oui_r18_f3 + oui_r20_f3 + oui_r22_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r3_f4 + cri_r5_f4 + cri_r7_f4 + cri_r9_f4 + cri_r11_f4 + cri_r13_f4 + cri_r15_f4 + cri_r17_f4 + cri_r19_f4 + cri_r21_f4 + cri_r23_f4 +oui_r1_f4 + oui_r3_f4 + oui_r5_f4 + oui_r7_f4 + oui_r9_f4 + oui_r11_f4 + oui_r13_f4 + oui_r15_f4 + oui_r17_f4 + oui_r19_f4 + oui_r21_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r2_f4 + cri_r4_f4 + cri_r6_f4 + cri_r8_f4 + cri_r10_f4 + cri_r12_f4 + cri_r14_f4 + cri_r16_f4 + cri_r18_f4 + cri_r20_f4 + cri_r22_f4 + cri_r24_f4+oui_r2_f4 + oui_r4_f4 + oui_r6_f4 + oui_r8_f4 + oui_r10_f4 + oui_r12_f4 + oui_r14_f4 + oui_r16_f4 + oui_r18_f4 + oui_r20_f4 + oui_r22_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r3_f5 + cri_r5_f5 + cri_r7_f5 + cri_r9_f5 + cri_r11_f5 + cri_r13_f5 + cri_r15_f5 + cri_r17_f5 + cri_r19_f5 + cri_r21_f5 + cri_r23_f5 +oui_r1_f5 + oui_r3_f5 + oui_r5_f5 + oui_r7_f5 + oui_r9_f5 + oui_r11_f5 + oui_r13_f5 + oui_r15_f5 + oui_r17_f5 + oui_r19_f5 + oui_r21_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r4_f5 + cri_r6_f5 + cri_r8_f5 + cri_r10_f5 + cri_r12_f5 + cri_r14_f5 + cri_r16_f5 + cri_r18_f5 + cri_r20_f5 + cri_r22_f5 + cri_r24_f5 +oui_r2_f5 + oui_r4_f5 + oui_r6_f5 + oui_r8_f5 + oui_r10_f5 + oui_r12_f5 + oui_r14_f5 + oui_r16_f5 + oui_r18_f5 + oui_r20_f5 + oui_r22_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r3_f6 + cri_r5_f6 + cri_r7_f6 + cri_r9_f6 + cri_r11_f6 + cri_r13_f6 + cri_r15_f6 + cri_r17_f6 + cri_r19_f6 + cri_r21_f6 + cri_r23_f6 +oui_r1_f6 + oui_r3_f6 + oui_r5_f6 + oui_r7_f6 + oui_r9_f6 + oui_r11_f6 + oui_r13_f6 + oui_r15_f6 + oui_r17_f6 + oui_r19_f6 + oui_r21_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r4_f6 + cri_r6_f6 + cri_r8_f6 + cri_r10_f6 + cri_r12_f6 + cri_r14_f6 + cri_r16_f6 + cri_r18_f6 + cri_r20_f6 + cri_r22_f6 + cri_r24_f6 +oui_r2_f6 + oui_r4_f6 + oui_r6_f6 + oui_r8_f6 + oui_r10_f6 + oui_r12_f6 + oui_r14_f6 + oui_r16_f6 + oui_r18_f6 + oui_r20_f6 + oui_r22_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r3_f7 + cri_r5_f7 + cri_r7_f7 + cri_r9_f7 + cri_r11_f7 + cri_r13_f7 + cri_r15_f7 + cri_r17_f7 + cri_r19_f7 + cri_r21_f7 + cri_r23_f7 +oui_r1_f7 + oui_r3_f7 + oui_r5_f7 + oui_r7_f7 + oui_r9_f7 + oui_r11_f7 + oui_r13_f7 + oui_r15_f7 + oui_r17_f7 + oui_r19_f7 + oui_r21_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r4_f7 + cri_r6_f7 + cri_r8_f7 + cri_r10_f7 + cri_r12_f7 + cri_r14_f7 + cri_r16_f7 + cri_r18_f7 + cri_r20_f7 + cri_r22_f7 + cri_r24_f7 +oui_r2_f7 + oui_r4_f7 + oui_r6_f7 + oui_r8_f7 + oui_r10_f7 + oui_r12_f7 + oui_r14_f7 + oui_r16_f7 + oui_r18_f7 + oui_r20_f7 + oui_r22_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r3_f8 + cri_r5_f8 + cri_r7_f8 + cri_r9_f8 + cri_r11_f8 + cri_r13_f8 + cri_r15_f8 + cri_r17_f8 + cri_r19_f8 + cri_r21_f8 + cri_r23_f8 +oui_r1_f8 + oui_r3_f8 + oui_r5_f8 + oui_r7_f8 + oui_r9_f8 + oui_r11_f8 + oui_r13_f8 + oui_r15_f8 + oui_r17_f8 + oui_r19_f8 + oui_r21_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r4_f8 + cri_r6_f8 + cri_r8_f8 + cri_r10_f8 + cri_r12_f8 + cri_r14_f8 + cri_r16_f8 + cri_r18_f8 + cri_r20_f8 + cri_r22_f8 + cri_r24_f8 +oui_r2_f8 + oui_r4_f8 + oui_r6_f8 + oui_r8_f8 + oui_r10_f8 + oui_r12_f8 + oui_r14_f8 + oui_r16_f8 + oui_r18_f8 + oui_r20_f8 + oui_r22_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r3_f9 + cri_r5_f9 + cri_r7_f9 + cri_r9_f9 + cri_r11_f9 + cri_r13_f9 + cri_r15_f9 + cri_r17_f9 + cri_r19_f9 + cri_r21_f9 + cri_r23_f9 +oui_r1_f9 + oui_r3_f9 + oui_r5_f9 + oui_r7_f9 + oui_r9_f9 + oui_r11_f9 + oui_r13_f9 + oui_r15_f9 + oui_r17_f9 + oui_r19_f9 + oui_r21_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r4_f9 + cri_r6_f9 + cri_r8_f9 + cri_r10_f9 + cri_r12_f9 + cri_r14_f9 + cri_r16_f9 + cri_r18_f9 + cri_r20_f9 + cri_r22_f9 + cri_r24_f9 +oui_r2_f9 + oui_r4_f9 + oui_r6_f9 + oui_r8_f9 + oui_r10_f9 + oui_r12_f9 + oui_r14_f9 + oui_r16_f9 + oui_r18_f9 + oui_r20_f9 + oui_r22_f9 + oui_r24_f9) as f_cols_pentv3, sum(cri_r1_f10 + cri_r3_f10 + cri_r5_f10 + cri_r7_f10 + cri_r9_f10 + cri_r11_f10 + cri_r13_f10 + cri_r15_f10 + cri_r17_f10 + cri_r19_f10 + cri_r21_f10 + cri_r23_f10 +oui_r1_f10 + oui_r3_f10 + oui_r5_f10 + oui_r7_f10 + oui_r9_f10 + oui_r11_f10 + oui_r13_f10 + oui_r15_f10 + oui_r17_f10 + oui_r19_f10 + oui_r21_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r4_f10 + cri_r6_f10 + cri_r8_f10 + cri_r10_f10 + cri_r12_f10 + cri_r14_f10 + cri_r16_f10 + cri_r18_f10 + cri_r20_f10 + cri_r22_f10 + cri_r24_f10 +oui_r2_f10 + oui_r4_f10 + oui_r6_f10 + oui_r8_f10 + oui_r10_f10 + oui_r12_f10 + oui_r14_f10 + oui_r16_f10 + oui_r18_f10 + oui_r20_f10 + oui_r22_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r3_f11 + cri_r5_f11 + cri_r7_f11 + cri_r9_f11 + cri_r11_f11 + cri_r13_f11 + cri_r15_f11 + cri_r17_f11 + cri_r19_f11 + cri_r21_f11 + cri_r23_f11 +oui_r1_f11 + oui_r3_f11 + oui_r5_f11 + oui_r7_f11 + oui_r9_f11 + oui_r11_f11 + oui_r13_f11 + oui_r15_f11 + oui_r17_f11 + oui_r19_f11 + oui_r21_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r4_f11 + cri_r6_f11 + cri_r8_f11 + cri_r10_f11 + cri_r12_f11 + cri_r14_f11 + cri_r16_f11 + cri_r18_f11 + cri_r20_f11 + cri_r22_f11 + cri_r24_f11 +oui_r2_f11 + oui_r4_f11 + oui_r6_f11 + oui_r8_f11 + oui_r10_f11 + oui_r12_f11 + oui_r14_f11 + oui_r16_f11 + oui_r18_f11 + oui_r20_f11 + oui_r22_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r3_f12 + cri_r5_f12 + cri_r7_f12 + cri_r9_f12 + cri_r11_f12 + cri_r13_f12 + cri_r15_f12 + cri_r17_f12 + cri_r19_f12 + cri_r21_f12 + cri_r23_f12 +oui_r1_f12 + oui_r3_f12 + oui_r5_f12 + oui_r7_f12 + oui_r9_f12 + oui_r11_f12 + oui_r13_f12 + oui_r15_f12 + oui_r17_f12 + oui_r19_f12 + oui_r21_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r4_f12 + cri_r6_f12 + cri_r8_f12 + cri_r10_f12 + cri_r12_f12 + cri_r14_f12 + cri_r16_f12 + cri_r18_f12 + cri_r20_f12 + cri_r22_f12 + cri_r24_f12 +oui_r2_f12 + oui_r4_f12 + oui_r6_f12 + oui_r8_f12 + oui_r10_f12 + oui_r12_f12 + oui_r14_f12 + oui_r16_f12 + oui_r18_f12 + oui_r20_f12 + oui_r22_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r3_f13 + cri_r5_f13 + cri_r7_f13 + cri_r9_f13 + cri_r11_f13 + cri_r13_f13 + cri_r15_f13 + cri_r17_f13 + cri_r19_f13 + cri_r21_f13 + cri_r23_f13 +oui_r1_f13 + oui_r3_f13 + oui_r5_f13 + oui_r7_f13 + oui_r9_f13 + oui_r11_f13 + oui_r13_f13 + oui_r15_f13 + oui_r17_f13 + oui_r19_f13 + oui_r21_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r4_f13 + cri_r6_f13 + cri_r8_f13 + cri_r10_f13 + cri_r12_f13 + cri_r14_f13 + cri_r16_f13 + cri_r18_f13 + cri_r20_f13 + cri_r22_f13 + cri_r24_f13 +oui_r2_f13 + oui_r4_f13 + oui_r6_f13 + oui_r8_f13 + oui_r10_f13 + oui_r12_f13 + oui_r14_f13 + oui_r16_f13 + oui_r18_f13 + oui_r20_f13 + oui_r22_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r3_f14 + cri_r5_f14 + cri_r7_f14 + cri_r9_f14 + cri_r11_f14 + cri_r13_f14 + cri_r15_f14 + cri_r17_f14 + cri_r19_f14 + cri_r21_f14 + cri_r23_f14 +oui_r1_f14 + oui_r3_f14 + oui_r5_f14 + oui_r7_f14 + oui_r9_f14 + oui_r11_f14 + oui_r13_f14 + oui_r15_f14 + oui_r17_f14 + oui_r19_f14 + oui_r21_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r4_f14 + cri_r6_f14 + cri_r8_f14 + cri_r10_f14 + cri_r12_f14 + cri_r14_f14 + cri_r16_f14 + cri_r18_f14 + cri_r20_f14 + cri_r22_f14 + cri_r24_f14 +oui_r2_f14 + oui_r4_f14 + oui_r6_f14 + oui_r8_f14 + oui_r10_f14 + oui_r12_f14 + oui_r14_f14 + oui_r16_f14 + oui_r18_f14 + oui_r20_f14 + oui_r22_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r3_f15 + cri_r5_f15 + cri_r7_f15 + cri_r9_f15 + cri_r11_f15 + cri_r13_f15 + cri_r15_f15 + cri_r17_f15 + cri_r19_f15 + cri_r21_f15 + cri_r23_f15 +oui_r1_f15 + oui_r3_f15 + oui_r5_f15 + oui_r7_f15 + oui_r9_f15 + oui_r11_f15 + oui_r13_f15 + oui_r15_f15 + oui_r17_f15 + oui_r19_f15 + oui_r21_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r4_f15 + cri_r6_f15 + cri_r8_f15 + cri_r10_f15 + cri_r12_f15 + cri_r14_f15 + cri_r16_f15 + cri_r18_f15 + cri_r20_f15 + cri_r22_f15 + cri_r24_f15 +oui_r2_f15 + oui_r4_f15 + oui_r6_f15 + oui_r8_f15 + oui_r10_f15 + oui_r12_f15 + oui_r14_f15 + oui_r16_f15 + oui_r18_f15 + oui_r20_f15 + oui_r22_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r3_f16 + cri_r5_f16 + cri_r7_f16 + cri_r9_f16 + cri_r11_f16 + cri_r13_f16 + cri_r15_f16 + cri_r17_f16 + cri_r19_f16 + cri_r21_f16 + cri_r23_f16 +oui_r1_f16 + oui_r3_f16 + oui_r5_f16 + oui_r7_f16 + oui_r9_f16 + oui_r11_f16 + oui_r13_f16 + oui_r15_f16 + oui_r17_f16 + oui_r19_f16 + oui_r21_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r4_f16 + cri_r6_f16 + cri_r8_f16 + cri_r10_f16 + cri_r12_f16 + cri_r14_f16 + cri_r16_f16 + cri_r18_f16 + cri_r20_f16 + cri_r22_f16 + cri_r24_f16 +oui_r2_f16 + oui_r4_f16 + oui_r6_f16 + oui_r8_f16 + oui_r10_f16 + oui_r12_f16 + oui_r14_f16 + oui_r16_f16 + oui_r18_f16 + oui_r20_f16 + oui_r22_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 + cri_r7_f17 + cri_r9_f17 + cri_r11_f17 + cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + cri_r19_f17 + cri_r21_f17 + cri_r23_f17 +oui_r1_f17 + oui_r3_f17 + oui_r5_f17 + oui_r7_f17 + oui_r9_f17 + oui_r11_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 + cri_r8_f17 + cri_r10_f17 + cri_r12_f17 + cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + cri_r20_f17 + cri_r22_f17 + cri_r24_f17 +oui_r2_f17 + oui_r4_f17 + oui_r6_f17 + oui_r8_f17 + oui_r10_f17 + oui_r12_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r3_f18 + cri_r5_f18 + cri_r7_f18 + cri_r9_f18 + cri_r11_f18 + cri_r13_f18 + cri_r15_f18 + cri_r17_f18 + cri_r19_f18 + cri_r21_f18 + cri_r23_f18 +oui_r1_f18 + oui_r3_f18 + oui_r5_f18 + oui_r7_f18 + oui_r9_f18 + oui_r11_f18 + oui_r13_f18 + oui_r15_f18 + oui_r17_f18 + oui_r19_f18 + oui_r21_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r4_f18 + cri_r6_f18 + cri_r8_f18 + cri_r10_f18 + cri_r12_f18 + cri_r14_f18 + cri_r16_f18 + cri_r18_f18 + cri_r20_f18 + cri_r22_f18 + cri_r24_f18 +oui_r2_f18 + oui_r4_f18 + oui_r6_f18 + oui_r8_f18 + oui_r10_f18 + oui_r12_f18 + oui_r14_f18 + oui_r16_f18 + oui_r18_f18 + oui_r20_f18 + oui_r22_f18 + oui_r24_f18) as f_cols_measles2, sum(ttri_r9_f1 + ttoui_r9_f1) as in_tt1, sum(ttri_r9_f2 + ttoui_r9_f2) as in_tt2, sum(ttri_r9_f3 + ttoui_r9_f3) as in_tt3, sum(ttri_r9_f4 +ttoui_r9_f4) as in_tt4, sum(ttri_r9_f5 +ttoui_r9_f5) as in_tt5, sum(ttri_r10_f1 +ttoui_r10_f1) as in_cba1, sum(ttri_r10_f2 +ttoui_r10_f2) as in_cba2, sum(ttri_r10_f3 +ttoui_r10_f3) as in_cba3, sum(ttri_r10_f4 +ttoui_r10_f4) as in_cba4, sum(ttri_r10_f5 +ttoui_r10_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL
					select distcode, sum(od_r1_f1 + od_r3_f1 + od_r5_f1 + od_r7_f1 + od_r9_f1 + od_r11_f1 + od_r13_f1 + od_r15_f1 + od_r17_f1 + od_r19_f1 + od_r21_f1 + od_r23_f1) as m_cols_bcg, sum(od_r2_f1 + od_r4_f1 + od_r6_f1 + od_r8_f1 + od_r10_f1 + od_r12_f1 + od_r14_f1 + od_r16_f1 + od_r18_f1 + od_r20_f1 + od_r22_f1 + od_r24_f1) as f_cols_bcg, sum(od_r1_f2 + od_r3_f2 + od_r5_f2 + od_r7_f2 + od_r9_f2 + od_r11_f2 + od_r13_f2 + od_r15_f2 + od_r17_f2 + od_r19_f2 + od_r21_f2 + od_r23_f2) as m_cols_hepb, sum(od_r2_f2 + od_r4_f2 + od_r6_f2 + od_r8_f2 + od_r10_f2 + od_r12_f2 + od_r14_f2 + od_r16_f2 + od_r18_f2 + od_r20_f2 + od_r22_f2 + od_r24_f2) as f_cols_hepb, sum(od_r1_f3 + od_r3_f3 + od_r5_f3 + od_r7_f3 + od_r9_f3 + od_r11_f3 + od_r13_f3 + od_r15_f3 + od_r17_f3 + od_r19_f3 + od_r21_f3 + od_r23_f3) as m_cols_opv0, sum(od_r2_f3 + od_r4_f3 + od_r6_f3 + od_r8_f3 + od_r10_f3 + od_r12_f3 + od_r14_f3 + od_r16_f3 + od_r18_f3 + od_r20_f3 + od_r22_f3 + od_r24_f3) as f_cols_opv0, sum(od_r1_f4 + od_r3_f4 + od_r5_f4 + od_r7_f4 + od_r9_f4 + od_r11_f4 + od_r13_f4 + od_r15_f4 + od_r17_f4 + od_r19_f4 + od_r21_f4 + od_r23_f4) as m_cols_opv1, sum(od_r2_f4 + od_r4_f4 + od_r6_f4 + od_r8_f4 + od_r10_f4 + od_r12_f4 + od_r14_f4 + od_r16_f4 + od_r18_f4 + od_r20_f4 + od_r22_f4 + od_r24_f4) as f_cols_opv1, sum(od_r1_f5 + od_r3_f5 + od_r5_f5 + od_r7_f5 + od_r9_f5 + od_r11_f5 + od_r13_f5 + od_r15_f5 + od_r17_f5 + od_r19_f5 + od_r21_f5 + od_r23_f5) as m_cols_opv2, sum(od_r2_f5 + od_r4_f5 + od_r6_f5 + od_r8_f5 + od_r10_f5 + od_r12_f5 + od_r14_f5 + od_r16_f5 + od_r18_f5 + od_r20_f5 + od_r22_f5 + od_r24_f5) as f_cols_opv2, sum(od_r1_f6 + od_r3_f6 + od_r5_f6 + od_r7_f6 + od_r9_f6 + od_r11_f6 + od_r13_f6 + od_r15_f6 + od_r17_f6 + od_r19_f6 + od_r21_f6 + od_r23_f6) as m_cols_opv3, sum(od_r2_f6 + od_r4_f6 + od_r6_f6 + od_r8_f6 + od_r10_f6 + od_r12_f6 + od_r14_f6 + od_r16_f6 + od_r18_f6 + od_r20_f6 + od_r22_f6 + od_r24_f6) as f_cols_opv3, sum(od_r1_f7 + od_r3_f7 + od_r5_f7 + od_r7_f7 + od_r9_f7 + od_r11_f7 + od_r13_f7 + od_r15_f7 + od_r17_f7 + od_r19_f7 + od_r21_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r4_f7 + od_r6_f7 + od_r8_f7 + od_r10_f7 + od_r12_f7 + od_r14_f7 + od_r16_f7 + od_r18_f7 + od_r20_f7 + od_r22_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r3_f8 + od_r5_f8 + od_r7_f8 + od_r9_f8 + od_r11_f8 + od_r13_f8 + od_r15_f8 + od_r17_f8 + od_r19_f8 + od_r21_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r4_f8 + od_r6_f8 + od_r8_f8 + od_r10_f8 + od_r12_f8 + od_r14_f8 + od_r16_f8 + od_r18_f8 + od_r20_f8 + od_r22_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r3_f9 + od_r5_f9 + od_r7_f9 + od_r9_f9 + od_r11_f9 + od_r13_f9 + od_r15_f9 + od_r17_f9 + od_r19_f9 + od_r21_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r4_f9 + od_r6_f9 + od_r8_f9 + od_r10_f9 + od_r12_f9 + od_r14_f9 + od_r16_f9 + od_r18_f9 + od_r20_f9 + od_r22_f9 + od_r24_f9) as f_cols_pentv3, sum(od_r1_f10 + od_r3_f10 + od_r5_f10 + od_r7_f10 + od_r9_f10 + od_r11_f10 + od_r13_f10 + od_r15_f10 + od_r17_f10 + od_r19_f10 + od_r21_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r4_f10 + od_r6_f10 + od_r8_f10 + od_r10_f10 + od_r12_f10 + od_r14_f10 + od_r16_f10 + od_r18_f10 + od_r20_f10 + od_r22_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r3_f11 + od_r5_f11 + od_r7_f11 + od_r9_f11 + od_r11_f11 + od_r13_f11 + od_r15_f11 + od_r17_f11 + od_r19_f11 + od_r21_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r4_f11 + od_r6_f11 + od_r8_f11 + od_r10_f11 + od_r12_f11 + od_r14_f11 + od_r16_f11 + od_r18_f11 + od_r20_f11 + od_r22_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r3_f12 + od_r5_f12 + od_r7_f12 + od_r9_f12 + od_r11_f12 + od_r13_f12 + od_r15_f12 + od_r17_f12 + od_r19_f12 + od_r21_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r4_f12 + od_r6_f12 + od_r8_f12 + od_r10_f12 + od_r12_f12 + od_r14_f12 + od_r16_f12 + od_r18_f12 + od_r20_f12 + od_r22_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r3_f13 + od_r5_f13 + od_r7_f13 + od_r9_f13 + od_r11_f13 + od_r13_f13 + od_r15_f13 + od_r17_f13 + od_r19_f13 + od_r21_f13 + od_r23_f13) as m_cols_ipv, sum(od_r2_f13 + od_r4_f13 + od_r6_f13 + od_r8_f13 + od_r10_f13 + od_r12_f13 + od_r14_f13 + od_r16_f13 + od_r18_f13 + od_r20_f13 + od_r22_f13 + od_r24_f13) as m_cols_ipv, sum(od_r1_f14 + od_r3_f14 + od_r5_f14 + od_r7_f14 + od_r9_f14 + od_r11_f14 + od_r13_f14 + od_r15_f14 + od_r17_f14 + od_r19_f14 + od_r21_f14 + od_r23_f14) as m_cols_rota1, sum(od_r2_f14 + od_r4_f14 + od_r6_f14 + od_r8_f14 + od_r10_f14 + od_r12_f14 + od_r14_f14 + od_r16_f14 + od_r18_f14 + od_r20_f14 + od_r22_f14 + od_r24_f14) as f_cols_rota1, sum(od_r1_f15 + od_r3_f15 + od_r5_f15 + od_r7_f15 + od_r9_f15 + od_r11_f15 + od_r13_f15 + od_r15_f15 + od_r17_f15 + od_r19_f15 + od_r21_f15 + od_r23_f15) as m_cols_rota2, sum(od_r2_f15 + od_r4_f15 + od_r6_f15 + od_r8_f15 + od_r10_f15 + od_r12_f15 + od_r14_f15 + od_r16_f15 + od_r18_f15 + od_r20_f15 + od_r22_f15 + od_r24_f15) as f_cols_rota2, sum(od_r1_f16 + od_r3_f16 + od_r5_f16 + od_r7_f16 + od_r9_f16 + od_r11_f16 + od_r13_f16 + od_r15_f16 + od_r17_f16 + od_r19_f16 + od_r21_f16 + od_r23_f16) as m_cols_measles1, sum(od_r2_f16 + od_r4_f16 + od_r6_f16 + od_r8_f16 + od_r10_f16 + od_r12_f16 + od_r14_f16 + od_r16_f16 + od_r18_f16 + od_r20_f16 + od_r22_f16 + od_r24_f16) as f_cols_measles1, sum(od_r1_f17 + od_r3_f17 + od_r5_f17 + od_r7_f17 + od_r9_f17 + od_r11_f17 + od_r13_f17 + od_r15_f17 + od_r17_f17 + od_r19_f17 + od_r21_f17 + od_r23_f17) as m_cols_fully, sum(od_r2_f17 + od_r4_f17 + od_r6_f17 + od_r8_f17 + od_r10_f17 + od_r12_f17 + od_r14_f17 + od_r16_f17 + od_r18_f17 + od_r20_f17 + od_r22_f17 + od_r24_f17) as f_cols_fully, sum(od_r1_f18 + od_r3_f18 + od_r5_f18 + od_r7_f18 + od_r9_f18 + od_r11_f18 + od_r13_f18 + od_r15_f18 + od_r17_f18 + od_r19_f18 + od_r21_f18 + od_r23_f18) as m_cols_measles2, sum(od_r2_f18 + od_r4_f18 + od_r6_f18 + od_r8_f18 + od_r10_f18 + od_r12_f18 + od_r14_f18 + od_r16_f18 + od_r18_f18 + od_r20_f18 + od_r22_f18 + od_r24_f18) as f_cols_measles2, sum(ttod_r9_f1) as in_tt1, sum(ttod_r9_f2) as in_tt2, sum(ttod_r9_f3) as in_tt3, sum(ttod_r9_f4) as in_tt4, sum(ttod_r9_f5) as in_tt5, sum(ttod_r10_f1) as in_cba1, sum(ttod_r10_f2) as in_cba2, sum(ttod_r10_f3) as in_cba3, sum(ttod_r10_f4) as in_cba4, sum(ttod_r10_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district ";
			}//done
			if($vacc_to == 'gender' && $age_wise == '0to11'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \" 
				FROM (select distcode, sum(cri_r1_f1 + cri_r7_f1 + cri_r13_f1 + cri_r19_f1 +oui_r1_f1 + oui_r7_f1 + oui_r13_f1 + oui_r19_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r8_f1 + cri_r14_f1 + cri_r20_f1 +oui_r2_f1 + oui_r8_f1 + oui_r14_f1 + oui_r20_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r7_f2 + cri_r13_f2 + cri_r19_f2 +oui_r1_f2 + oui_r7_f2 + oui_r13_f2 + oui_r19_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r8_f2 + cri_r14_f2 + cri_r20_f2 +oui_r2_f2 + oui_r8_f2 + oui_r14_f2 + oui_r20_f2) as f_cols_hepb, sum(cri_r1_f3 + cri_r7_f3 + cri_r13_f3 + cri_r19_f3 +oui_r1_f3 + oui_r7_f3 + oui_r13_f3 + oui_r19_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r8_f3 + cri_r14_f3 + cri_r20_f3 +oui_r2_f3 + oui_r8_f3 + oui_r14_f3 + oui_r20_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r7_f4 + cri_r13_f4 + cri_r19_f4 +oui_r1_f4 + oui_r7_f4 + oui_r13_f4 + oui_r19_f4) as m_cols_opv1, sum(cri_r2_f4 + cri_r8_f4 + cri_r14_f4 + cri_r20_f4 +oui_r2_f4 + oui_r8_f4 + oui_r14_f4 + oui_r20_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r7_f5 + cri_r13_f5 + cri_r19_f5 +oui_r1_f5 + oui_r7_f5 + oui_r13_f5 + oui_r19_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r8_f5 + cri_r14_f5 + cri_r20_f5 +oui_r2_f5 + oui_r8_f5 + oui_r14_f5 + oui_r20_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r7_f6 + cri_r13_f6 + cri_r19_f6 +oui_r1_f6 + oui_r7_f6 + oui_r13_f6 + oui_r19_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r8_f6 + cri_r14_f6 + cri_r20_f6 +oui_r2_f6 + oui_r8_f6 + oui_r14_f6 + oui_r20_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r7_f7 + cri_r13_f7 + cri_r19_f7 +oui_r1_f7 + oui_r7_f7 + oui_r13_f7 + oui_r19_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r8_f7 + cri_r14_f7 + cri_r20_f7 +oui_r2_f7 + oui_r8_f7 + oui_r14_f7 + oui_r20_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r7_f8 + cri_r13_f8 + cri_r19_f8 +oui_r1_f8 + oui_r7_f8 + oui_r13_f8 + oui_r19_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r8_f8 + cri_r14_f8 + cri_r20_f8 +oui_r2_f8 + oui_r8_f8 + oui_r14_f8 + oui_r20_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r7_f9 + cri_r13_f9 + cri_r19_f9 +oui_r1_f9 + oui_r7_f9 + oui_r13_f9 + oui_r19_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r8_f9 + cri_r14_f9 + cri_r20_f9 +oui_r2_f9 + oui_r8_f9 + oui_r14_f9 + oui_r20_f9) as f_cols_pentv3,sum(cri_r1_f10 + cri_r7_f10 + cri_r13_f10 + cri_r19_f10 +oui_r1_f10 + oui_r7_f10 + oui_r13_f10 + oui_r19_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r8_f10 + cri_r14_f10 + cri_r20_f10 +oui_r2_f10 + oui_r8_f10 + oui_r14_f10 + oui_r20_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r7_f11 + cri_r13_f11 + cri_r19_f11 +oui_r2_f10 + oui_r8_f10 + oui_r14_f10 + oui_r20_f10) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r8_f11 + cri_r14_f11 + cri_r20_f11 +oui_r2_f11 + oui_r8_f11 + oui_r14_f11 + oui_r20_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r7_f12 + cri_r13_f12 + cri_r19_f12 +oui_r1_f12 + oui_r7_f12 + oui_r13_f12 + oui_r19_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r8_f12 + cri_r14_f12 + cri_r20_f12 +oui_r2_f12 + oui_r8_f12 + oui_r14_f12 + oui_r20_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r7_f13 + cri_r13_f13 + cri_r19_f13 +oui_r1_f13 + oui_r7_f13 + oui_r13_f13 + oui_r19_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r8_f13 + cri_r14_f13 + cri_r20_f13 +oui_r2_f13 + oui_r8_f13 + oui_r14_f13 + oui_r20_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r7_f14 + cri_r13_f14 + cri_r19_f14 +oui_r1_f14 + oui_r7_f14 + oui_r13_f14 + oui_r19_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r8_f14 + cri_r14_f14 + cri_r20_f14 +oui_r2_f14 + oui_r8_f14 + oui_r14_f14 + oui_r20_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r7_f15 + cri_r13_f15 + cri_r19_f15 +oui_r1_f15 + oui_r7_f15 + oui_r13_f15 + oui_r19_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r8_f15 + cri_r14_f15 + cri_r20_f15 +oui_r2_f15 + oui_r8_f15 + oui_r14_f15 + oui_r20_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r7_f16 + cri_r13_f16 + cri_r19_f16 +oui_r1_f16 + oui_r7_f16 + oui_r13_f16 + oui_r19_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r8_f16 + cri_r14_f16 + cri_r20_f16 +oui_r2_f16 + oui_r8_f16 + oui_r14_f16 + oui_r20_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r7_f17 + cri_r13_f17 + cri_r19_f17 +oui_r1_f17 + oui_r7_f17 + oui_r13_f17 + oui_r19_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r8_f17 + cri_r14_f17 + cri_r20_f17 +oui_r2_f17 + oui_r8_f17 + oui_r14_f17 + oui_r20_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r7_f18 + cri_r13_f18 + cri_r19_f18 +(oui_r1_f18 + oui_r7_f18 + oui_r13_f18 + oui_r19_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r8_f18 + cri_r14_f18 + cri_r20_f18 +oui_r2_f18 + oui_r8_f18 + oui_r14_f18 + oui_r20_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r1_f1 + od_r7_f1 + od_r13_f1 + od_r19_f1) as m_cols_bcg, sum(od_r2_f1 + od_r8_f1 + od_r14_f1 + od_r20_f1) as f_cols_bcg, sum(od_r1_f2 + od_r7_f2 + od_r13_f2 + od_r19_f2) as m_cols_hepb, sum(od_r2_f2 + od_r8_f2 + od_r14_f2 + od_r20_f2) as f_cols_hepb, sum(od_r1_f3 + od_r7_f3 + od_r13_f3 + od_r19_f3) as m_cols_opv0, sum(od_r2_f3 + od_r8_f3 + od_r14_f3 + od_r20_f3) as f_cols_opv0, sum(od_r1_f4 + od_r7_f4 + od_r13_f4 + od_r19_f4) as m_cols_opv1, sum(od_r2_f4 + od_r8_f4 + od_r14_f4 + od_r20_f4) as f_cols_opv1, sum(od_r1_f5 + od_r7_f5 + od_r13_f5 + od_r19_f5) as m_cols_opv2, sum(od_r2_f5 + od_r8_f5 + od_r14_f5 + od_r20_f5) as f_cols_opv2, sum(od_r1_f6 + od_r7_f6 + od_r13_f6 + od_r19_f6) as m_cols_opv3, sum(od_r2_f6 + od_r8_f6 + od_r14_f6 + od_r20_f6) as f_cols_opv3, sum(od_r1_f7 + od_r7_f7 + od_r13_f7 + od_r19_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r8_f7 + od_r14_f7 + od_r20_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r7_f8 + od_r13_f8 + od_r19_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r8_f8 + od_r14_f8 + od_r20_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r7_f9 + od_r13_f9 + od_r19_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r8_f9 + od_r14_f9 + od_r20_f9) as f_cols_pentv3,sum(od_r1_f10 + od_r7_f10 + od_r13_f10 + od_r19_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r8_f10 + od_r14_f10 + od_r20_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r7_f11 + od_r13_f11 + od_r19_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r8_f11 + od_r14_f11 + od_r20_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r7_f12 + od_r13_f12 + od_r19_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r8_f12 + od_r14_f12 + od_r20_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r7_f13 + od_r13_f13 + od_r19_f13) as m_cols_ipv, sum(od_r2_f13 + od_r8_f13 + od_r14_f13 + od_r20_f13) as f_cols_ipv, sum(od_r1_f14 + od_r7_f14 + od_r13_f14 + od_r19_f14) as m_cols_rota1, sum(od_r2_f14 + od_r8_f14 + od_r14_f14 + od_r20_f14) as f_cols_rota1, sum(od_r1_f15 + od_r7_f15 + od_r13_f15 + od_r19_f15) as m_cols_rota2, sum(od_r2_f15 + od_r8_f15 + od_r14_f15 + od_r20_f15) as f_cols_rota2, sum(od_r1_f16 + od_r7_f16 + od_r13_f16 + od_r19_f16) as m_cols_measles1, sum(od_r2_f16 + od_r8_f16 + od_r14_f16 + od_r20_f16) as f_cols_measles1, sum(od_r1_f17 + od_r7_f17 + od_r13_f17 + od_r19_f17) as m_cols_fully, sum(od_r2_f17 + od_r8_f17 + od_r14_f17 + od_r20_f17) as f_cols_fully, sum(od_r1_f18 + od_r7_f18 + od_r13_f18 + od_r19_f18) as m_cols_measles2, sum(od_r2_f18 + od_r8_f18 + od_r14_f18 + od_r20_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district ";					
			}//remaining
			if($vacc_to == 'gender' && $age_wise == '12to23'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \"
					FROM (select distcode, sum(cri_r3_f1 + cri_r9_f1 + cri_r15_f1 + cri_r21_f1 +oui_r3_f1 + oui_r9_f1 + oui_r15_f1 + oui_r21_f1) as m_cols_bcg, sum(cri_r4_f1 + cri_r10_f1 + cri_r16_f1 + cri_r22_f1 +oui_r4_f1 + oui_r10_f1 + oui_r16_f1 + oui_r22_f1) as f_cols_bcg, sum(cri_r3_f2 + cri_r9_f2 + cri_r15_f2 + cri_r21_f2 +oui_r3_f2 + oui_r9_f2 + oui_r15_f2 + oui_r21_f2) as m_cols_hepb, sum(cri_r4_f2 + cri_r10_f2 + cri_r16_f2 + cri_r22_f2 +oui_r4_f2 + oui_r10_f2 + oui_r16_f2 + oui_r22_f2) as f_cols_hepb, sum(cri_r3_f3 + cri_r9_f3 + cri_r15_f3 + cri_r21_f3 +oui_r3_f3 + oui_r9_f3 + oui_r15_f3 + oui_r21_f3) as m_cols_opv0, sum(cri_r4_f3 + cri_r10_f3 + cri_r16_f3 + cri_r22_f3 +oui_r4_f3 + oui_r10_f3 + oui_r16_f3 + oui_r22_f3) as f_cols_opv0, sum(cri_r3_f4 + cri_r9_f4 + cri_r15_f4 + cri_r21_f4 +oui_r3_f4 + oui_r9_f4 + oui_r15_f4 + oui_r21_f4) as m_cols_opv1, sum(cri_r4_f4 + cri_r10_f4 + cri_r16_f4 + cri_r22_f4 +oui_r4_f4 + oui_r10_f4 + oui_r16_f4 + oui_r22_f4) as f_cols_opv1, sum(cri_r3_f5 + cri_r9_f5 + cri_r15_f5 + cri_r21_f5 +oui_r3_f5 + oui_r9_f5 + oui_r15_f5 + oui_r21_f5) as m_cols_opv2, sum(cri_r4_f5 + cri_r10_f5 + cri_r16_f5 + cri_r22_f5 +oui_r4_f5 + oui_r10_f5 + oui_r16_f5 + oui_r22_f5) as f_cols_opv2, sum(cri_r3_f6 + cri_r9_f6 + cri_r15_f6 + cri_r21_f6 +oui_r3_f6 + oui_r9_f6 + oui_r15_f6 + oui_r21_f6) as m_cols_opv3, sum(cri_r4_f6 + cri_r10_f6 + cri_r16_f6 + cri_r22_f6 +oui_r4_f6 + oui_r10_f6 + oui_r16_f6 + oui_r22_f6) as f_cols_opv3, sum(cri_r3_f7 + cri_r9_f7 + cri_r15_f7 + cri_r21_f7 +oui_r3_f7 + oui_r9_f7 + oui_r15_f7 + oui_r21_f7) as m_cols_pentv1, sum(cri_r4_f7 + cri_r10_f7 + cri_r16_f7 + cri_r22_f7 +oui_r4_f7 + oui_r10_f7 + oui_r16_f7 + oui_r22_f7) as f_cols_pentv1, sum(cri_r3_f8 + cri_r9_f8 + cri_r15_f8 + cri_r21_f8 +oui_r3_f8 + oui_r9_f8 + oui_r15_f8 + oui_r21_f8) as m_cols_pentv2, sum(cri_r4_f8 + cri_r10_f8 + cri_r16_f8 + cri_r22_f8 +oui_r4_f8 + oui_r10_f8 + oui_r16_f8 + oui_r22_f8) as f_cols_pentv2, sum(cri_r3_f9 + cri_r9_f9 + cri_r15_f9 + cri_r21_f9 +oui_r3_f9 + oui_r9_f9 + oui_r15_f9 + oui_r21_f9) as m_cols_pentv3, sum(cri_r4_f9 + cri_r10_f9 + cri_r16_f9 + cri_r22_f9 +oui_r4_f9 + oui_r10_f9 + oui_r16_f9 + oui_r22_f9) as f_cols_pentv3,sum(cri_r3_f10 + cri_r9_f10 + cri_r15_f10 + cri_r21_f10 +oui_r3_f10 + oui_r9_f10 + oui_r15_f10 + oui_r21_f10) as m_cols_pcv10_1, sum(cri_r4_f10 + cri_r10_f10 + cri_r16_f10 + cri_r22_f10 +oui_r4_f10 + oui_r10_f10 + oui_r16_f10 + oui_r22_f10) as f_cols_pcv10_1, sum(cri_r3_f11 + cri_r9_f11 + cri_r15_f11 + cri_r21_f11 +oui_r3_f11 + oui_r9_f11 + oui_r15_f11 + oui_r21_f11) as m_cols_pcv10_2, sum(cri_r4_f11 + cri_r10_f11 + cri_r16_f11 + cri_r22_f11 +oui_r4_f11 + oui_r10_f11 + oui_r16_f11 + oui_r22_f11) as f_cols_pcv10_2, sum(cri_r3_f12 + cri_r9_f12 + cri_r15_f12 + cri_r21_f12 +oui_r3_f12 + oui_r9_f12 + oui_r15_f12 + oui_r21_f12) as m_cols_pcv10_3, sum(cri_r4_f12 + cri_r10_f12 + cri_r16_f12 + cri_r22_f12 +oui_r4_f12 + oui_r10_f12 + oui_r16_f12 + oui_r22_f12) as f_cols_pcv10_3, sum(cri_r3_f13 + cri_r9_f13 + cri_r15_f13 + cri_r21_f13 +oui_r3_f13 + oui_r9_f13 + oui_r15_f13 + oui_r21_f13) as m_cols_ipv, sum(cri_r4_f13 + cri_r10_f13 + cri_r16_f13 + cri_r22_f13 +oui_r4_f13 + oui_r10_f13 + oui_r16_f13 + oui_r22_f13) as f_cols_ipv, sum(cri_r3_f14 + cri_r9_f14 + cri_r15_f14 + cri_r21_f14 +oui_r3_f14 + oui_r9_f14 + oui_r15_f14 + oui_r21_f14) as m_cols_rota1, sum(cri_r4_f14 + cri_r10_f14 + cri_r16_f14 + cri_r22_f14 +oui_r4_f14 + oui_r10_f14 + oui_r16_f14 + oui_r22_f14) as f_cols_rota1, sum(cri_r3_f15 + cri_r9_f15 + cri_r15_f15 + cri_r21_f15 +oui_r3_f15 + oui_r9_f15 + oui_r15_f15 + oui_r21_f15) as m_cols_rota2, sum(cri_r4_f15 + cri_r10_f15 + cri_r16_f15 + cri_r22_f15 +oui_r4_f15 + oui_r10_f15 + oui_r16_f15 + oui_r22_f15)  as f_cols_rota2, sum(cri_r3_f16 + cri_r9_f16 + cri_r15_f16 + cri_r21_f16 +oui_r3_f16 + oui_r9_f16 + oui_r15_f16 + oui_r21_f16) as m_cols_measles1, sum(cri_r4_f16 + cri_r10_f16 + cri_r16_f16 + cri_r22_f16 +oui_r4_f16 + oui_r10_f16 + oui_r16_f16 + oui_r22_f16) as f_cols_measles1, sum(cri_r3_f17 + cri_r9_f17 + cri_r15_f17 + cri_r21_f17 +oui_r3_f17 + oui_r9_f17 + oui_r15_f17 + oui_r21_f17) as m_cols_fully, sum(cri_r4_f17 + cri_r10_f17 + cri_r16_f17 + cri_r22_f17 +oui_r4_f17 + oui_r10_f17 + oui_r16_f17 + oui_r22_f17) as f_cols_fully, sum(cri_r3_f18 + cri_r9_f18 + cri_r15_f18 + cri_r21_f18 +oui_r3_f18 + oui_r9_f18 + oui_r15_f18 + oui_r21_f18) as m_cols_measles2, sum(cri_r4_f18 + cri_r10_f18 + cri_r16_f18 + cri_r22_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r3_f1 + od_r9_f1 + od_r15_f1 + od_r21_f1) as m_cols_bcg, sum(od_r4_f1 + od_r10_f1 + od_r16_f1 + od_r22_f1) as f_cols_bcg, sum(od_r3_f2 + od_r9_f2 + od_r15_f2 + od_r21_f2) as m_cols_hepb, sum(od_r4_f2 + od_r10_f2 + od_r16_f2 + od_r22_f2) as f_cols_hepb, sum(od_r3_f3 + od_r9_f3 + od_r15_f3 + od_r21_f3) as m_cols_opv0, sum(od_r4_f3 + od_r10_f3 + od_r16_f3 + od_r22_f3) as f_cols_opv0, sum(od_r3_f4 + od_r9_f4 + od_r15_f4 + od_r21_f4) as m_cols_opv1, sum(od_r4_f4 + od_r10_f4 + od_r16_f4 + od_r22_f4) as f_cols_opv1, sum(od_r3_f5 + od_r9_f5 + od_r15_f5 + od_r21_f5) as m_cols_opv2, sum(od_r4_f5 + od_r10_f5 + od_r16_f5 + od_r22_f5) as f_cols_opv2, sum(od_r3_f6 + od_r9_f6 + od_r15_f6 + od_r21_f6) as m_cols_opv3, sum(od_r4_f6 + od_r10_f6 + od_r16_f6 + od_r22_f6) as f_cols_opv3, sum(od_r3_f7 + od_r9_f7 + od_r15_f7 + od_r21_f7) as m_cols_pentv1, sum(od_r4_f7 + od_r10_f7 + od_r16_f7 + od_r22_f7) as f_cols_pentv1, sum(od_r3_f8 + od_r9_f8 + od_r15_f8 + od_r21_f8) as m_cols_pentv2, sum(od_r4_f8 + od_r10_f8 + od_r16_f8 + od_r22_f8) as f_cols_pentv2, sum(od_r3_f9 + od_r9_f9 + od_r15_f9 + od_r21_f9) as m_cols_pentv3, sum(od_r4_f9 + od_r10_f9 + od_r16_f9 + od_r22_f9) as f_cols_pentv3,sum(od_r3_f10 + od_r9_f10 + od_r15_f10 + od_r21_f10) as m_cols_pcv10_1, sum(od_r4_f10 + od_r10_f10 + od_r16_f10 + od_r22_f10) as f_cols_pcv10_1, sum(od_r3_f11 + od_r9_f11 + od_r15_f11 + od_r21_f11) as m_cols_pcv10_2, sum(od_r4_f11 + od_r10_f11 + od_r16_f11 + od_r22_f11) as f_cols_pcv10_2, sum(od_r3_f12 + od_r9_f12 + od_r15_f12 + od_r21_f12) as m_cols_pcv10_3, sum(od_r4_f12 + od_r10_f12 + od_r16_f12 + od_r22_f12) as f_cols_pcv10_3, sum(od_r3_f13 + od_r9_f13 + od_r15_f13 + od_r21_f13) as m_cols_ipv, sum(od_r4_f13 + od_r10_f13 + od_r16_f13 + od_r22_f13) as f_cols_ipv, sum(od_r3_f14 + od_r9_f14 + od_r15_f14 + od_r21_f14) as m_cols_rota1, sum(od_r4_f14 + od_r10_f14 + od_r16_f14 + od_r22_f14) as f_cols_rota1, sum(od_r3_f15 + od_r9_f15 + od_r15_f15 + od_r21_f15) as m_cols_rota2, sum(od_r4_f15 + od_r10_f15 + od_r16_f15 + od_r22_f15) as f_cols_rota2, sum(od_r3_f16 + od_r9_f16 + od_r15_f16 + od_r21_f16) as m_cols_measles1, sum(od_r4_f16 + od_r10_f16 + od_r16_f16 + od_r22_f16) as f_cols_measles1, sum(od_r3_f17 + od_r9_f17 + od_r15_f17 + od_r21_f17) as m_cols_fully, sum(od_r4_f17 + od_r10_f17 + od_r16_f17 + od_r22_f17) as f_cols_fully, sum(od_r3_f18 + od_r9_f18 + od_r15_f18 + od_r21_f18) as m_cols_measles2, sum(od_r4_f18 + od_r10_f18 + od_r16_f18 + od_r22_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done
			if($vacc_to == 'gender' && $age_wise == 'above2'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \"
					FROM (select distcode, sum(cri_r5_f1 + cri_r11_f1 + cri_r17_f1 + cri_r23_f1 +oui_r5_f1 + oui_r11_f1 + oui_r17_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r6_f1 + cri_r12_f1 + cri_r18_f1 + cri_r24_f1 +oui_r6_f1 + oui_r12_f1 + oui_r18_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r5_f2 + cri_r11_f2 + cri_r17_f2 + cri_r23_f2 +oui_r5_f2 + oui_r11_f2 + oui_r17_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r6_f2 + cri_r12_f2 + cri_r18_f2 + cri_r24_f2 +oui_r6_f2 + oui_r12_f2 + oui_r18_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r5_f3 + cri_r11_f3 + cri_r17_f3 + cri_r23_f3 +oui_r5_f3 + oui_r11_f3 + oui_r17_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r6_f3 + cri_r12_f3 + cri_r18_f3 + cri_r24_f3 +oui_r6_f3 + oui_r12_f3 + oui_r18_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r5_f4 + cri_r11_f4 + cri_r17_f4 + cri_r23_f4 +oui_r5_f4 + oui_r11_f4 + oui_r17_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r6_f4 + cri_r12_f4 + cri_r18_f4 + cri_r24_f4 +oui_r6_f4 + oui_r12_f4 + oui_r18_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r5_f5 + cri_r11_f5 + cri_r17_f5 + cri_r23_f5 +oui_r5_f5 + oui_r11_f5 + oui_r17_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r6_f5 + cri_r12_f5 + cri_r18_f5 + cri_r24_f5 +oui_r6_f5 + oui_r12_f5 + oui_r18_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r5_f6 + cri_r11_f6 + cri_r17_f6 + cri_r23_f6 +oui_r5_f6 + oui_r11_f6 + oui_r17_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r6_f6 + cri_r12_f6 + cri_r18_f6 + cri_r24_f6 +oui_r6_f6 + oui_r12_f6 + oui_r18_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r5_f7 + cri_r11_f7 + cri_r17_f7 + cri_r23_f7 +oui_r5_f7 + oui_r11_f7 + oui_r17_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r6_f7 + cri_r12_f7 + cri_r18_f7 + cri_r24_f7 +oui_r6_f7 + oui_r12_f7 + oui_r18_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r5_f8 + cri_r11_f8 + cri_r17_f8 + cri_r23_f8 +oui_r5_f8 + oui_r11_f8 + oui_r17_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r6_f8 + cri_r12_f8 + cri_r18_f8 + cri_r24_f8 +oui_r6_f8 + oui_r12_f8 + oui_r18_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r5_f9 + cri_r11_f9 + cri_r17_f9 + cri_r23_f9 +oui_r5_f9 + oui_r11_f9 + oui_r17_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r6_f9 + cri_r12_f9 + cri_r18_f9 + cri_r24_f9 +oui_r6_f9 + oui_r12_f9 + oui_r18_f9 + oui_r24_f9) as f_cols_pentv3,sum(cri_r5_f10 + cri_r11_f10 + cri_r17_f10 + cri_r23_f10 +oui_r5_f10 + oui_r11_f10 + oui_r17_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r6_f10 + cri_r12_f10 + cri_r18_f10 + cri_r24_f10 +oui_r6_f10 + oui_r12_f10 + oui_r18_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r5_f11 + cri_r11_f11 + cri_r17_f11 + cri_r23_f11 +oui_r5_f11 + oui_r11_f11 + oui_r17_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r6_f11 + cri_r12_f11 + cri_r18_f11 + cri_r24_f11 +oui_r6_f11 + oui_r12_f11 + oui_r18_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r5_f12 + cri_r11_f12 + cri_r17_f12 + cri_r23_f12 +oui_r5_f12 + oui_r11_f12 + oui_r17_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r6_f12 + cri_r12_f12 + cri_r18_f12 + cri_r24_f12 +oui_r6_f12 + oui_r12_f12 + oui_r18_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r5_f13 + cri_r11_f13 + cri_r17_f13 + cri_r23_f13 +oui_r5_f13 + oui_r11_f13 + oui_r17_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r6_f13 + cri_r12_f13 + cri_r18_f13 + cri_r24_f13 +oui_r6_f13 + oui_r12_f13 + oui_r18_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r5_f14 + cri_r11_f14 + cri_r17_f14 + cri_r23_f14 +oui_r5_f14 + oui_r11_f14 + oui_r17_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r6_f14 + cri_r12_f14 + cri_r18_f14 + cri_r24_f14 +oui_r6_f14 + oui_r12_f14 + oui_r18_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r5_f15 + cri_r11_f15 + cri_r17_f15 + cri_r23_f15 +oui_r5_f15 + oui_r11_f15 + oui_r17_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r6_f15 + cri_r12_f15 + cri_r18_f15 + cri_r24_f15 +oui_r6_f15 + oui_r12_f15 + oui_r18_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r5_f16 + cri_r11_f16 + cri_r17_f16 + cri_r23_f16 +oui_r5_f16 + oui_r11_f16 + oui_r17_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r6_f16 + cri_r12_f16 + cri_r18_f16 + cri_r24_f16 +oui_r6_f16 + oui_r12_f16 + oui_r18_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r5_f17 + cri_r11_f17 + cri_r17_f17 + cri_r23_f17 +oui_r5_f17 + oui_r11_f17 + oui_r17_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r6_f17 + cri_r12_f17 + cri_r18_f17 + cri_r24_f17 +oui_r6_f17 + oui_r12_f17 + oui_r18_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r5_f18 + cri_r11_f18 + cri_r17_f18 + cri_r23_f18 +oui_r5_f18 + oui_r11_f18 + oui_r17_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r6_f18 + cri_r12_f18 + cri_r18_f18 + cri_r24_f18 +oui_r6_f18 + oui_r12_f18 + oui_r18_f18 + oui_r24_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth}  GROUP BY distcode 
					UNION ALL 
					select distcode, sum(od_r5_f1 + od_r11_f1 + od_r17_f1 + od_r23_f1) as m_cols_bcg, sum(od_r6_f1 + od_r12_f1 + od_r18_f1 + od_r24_f1) as f_cols_bcg, sum(od_r5_f2 + od_r11_f2 + od_r17_f2 + od_r23_f2) as m_cols_hepb, sum(od_r6_f2 + od_r12_f2 + od_r18_f2 + od_r24_f2) as f_cols_hepb, sum(od_r5_f3 + od_r11_f3 + od_r17_f3 + od_r23_f3) as m_cols_opv0, sum(od_r6_f3 + od_r12_f3 + od_r18_f3 + od_r24_f3) as f_cols_opv0, sum(od_r5_f4 + od_r11_f4 + od_r17_f4 + od_r23_f4) as m_cols_opv1, sum(od_r6_f4 + od_r12_f4 + od_r18_f4 + od_r24_f4) as f_cols_opv1, sum(od_r5_f5 + od_r11_f5 + od_r17_f5 + od_r23_f5) as m_cols_opv2, sum(od_r6_f5 + od_r12_f5 + od_r18_f5 + od_r24_f5) as f_cols_opv2, sum(od_r5_f6 + od_r11_f6 + od_r17_f6 + od_r23_f6) as m_cols_opv3, sum(od_r6_f6 + od_r12_f6 + od_r18_f6 + od_r24_f6) as f_cols_opv3, sum(od_r5_f7 + od_r11_f7 + od_r17_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r6_f7 + od_r12_f7 + od_r18_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r5_f8 + od_r11_f8 + od_r17_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r6_f8 + od_r12_f8 + od_r18_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r5_f9 + od_r11_f9 + od_r17_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r6_f9 + od_r12_f9 + od_r18_f9 + od_r24_f9) as f_cols_pentv3,sum(od_r5_f10 + od_r11_f10 + od_r17_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r6_f10 + od_r12_f10 + od_r18_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r5_f11 + od_r11_f11 + od_r17_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r6_f11 + od_r12_f11 + od_r18_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r5_f12 + od_r11_f12 + od_r17_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r6_f12 + od_r12_f12 + od_r18_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r5_f13 + od_r11_f13 + od_r17_f13 + od_r23_f13) as m_cols_ipv, sum(od_r6_f13 + od_r12_f13 + od_r18_f13 + od_r24_f13) as f_cols_ipv, sum(od_r5_f14 + od_r11_f14 + od_r17_f14 + od_r23_f14) as m_cols_rota1, sum(od_r6_f14 + od_r12_f14 + od_r18_f14 + od_r24_f14) as f_cols_rota1, sum(od_r5_f15 + od_r11_f15 + od_r17_f15 + od_r23_f15) as m_cols_rota2, sum(od_r6_f15 + od_r12_f15 + od_r18_f15 + od_r24_f15) as f_cols_rota2, sum(od_r5_f16 + od_r11_f16 + od_r17_f16 + od_r23_f16) as m_cols_measles1, sum(od_r6_f16 + od_r12_f16 + od_r18_f16 + od_r24_f16) as f_cols_measles1, sum(od_r5_f17 + od_r11_f17 + od_r17_f17 + od_r23_f17) as m_cols_fully, sum(od_r6_f17 + od_r12_f17 + od_r18_f17 + od_r24_f17) as f_cols_fully, sum(od_r5_f18 + od_r11_f18 + od_r17_f18 + od_r23_f18) as m_cols_measles2, sum(od_r6_f18 + od_r12_f18 + od_r18_f18 + od_r24_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";					
			}
		}
		if($vaccination_type == 'fixed'){
			if($age_wise == '0to11'){
				$a = "r1";
				$b = "r2";
			}
			if($age_wise == '12to23'){
				$a = "r3";
				$b = "r4";
			}
			if($age_wise == 'above2'){
				$a = "r5";
				$b = "r6";
			}
			$x = 1; $y = 2;
			//done
			if($vacc_to == 'total_children' && $age_wise == 'all'){
				//echo 'robot';exit;
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r1_f1 + cri_r3_f1 + cri_r5_f1 +oui_r1_f1 + oui_r3_f1 + oui_r5_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r4_f1 + cri_r6_f1 +oui_r2_f1 + oui_r4_f1 + oui_r6_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r3_f2 + cri_r5_f2 +oui_r1_f2 + oui_r3_f2 + oui_r5_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r4_f2 + cri_r6_f2 +oui_r2_f2 + oui_r4_f2 + oui_r6_f2) as f_cols_hepb, sum(cri_r1_f3 + cri_r3_f3 + cri_r5_f3 +oui_r1_f3 + oui_r3_f3 + oui_r5_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r4_f3 + cri_r6_f3 +oui_r2_f3 + oui_r4_f3 + oui_r6_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r3_f4 + cri_r5_f4 +oui_r1_f4 + oui_r3_f4 + oui_r5_f4) as m_cols_opv1, sum(cri_r2_f4 + cri_r4_f4 + cri_r6_f4 +oui_r2_f4 + oui_r4_f4 + oui_r6_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r3_f5 + cri_r5_f5 +oui_r1_f5 + oui_r3_f5 + oui_r5_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r4_f5 + cri_r6_f5 +oui_r2_f5 + oui_r4_f5 + oui_r6_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r3_f6 + cri_r5_f6 +oui_r1_f6 + oui_r3_f6 + oui_r5_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r4_f6 + cri_r6_f6 +oui_r2_f6 + oui_r4_f6 + oui_r6_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r3_f7 + cri_r5_f7 +oui_r1_f7 + oui_r3_f7 + oui_r5_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r4_f7 + cri_r6_f7 +oui_r2_f7 + oui_r4_f7 + oui_r6_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r3_f8 + cri_r5_f8 +oui_r1_f8 + oui_r3_f8 + oui_r5_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r4_f8 + cri_r6_f8 +oui_r2_f8 + oui_r4_f8 + oui_r6_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r3_f9 + cri_r5_f9 +oui_r1_f9 + oui_r3_f9 + oui_r5_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r4_f9 + cri_r6_f9 +oui_r2_f9 + oui_r4_f9 + oui_r6_f9) as f_cols_pentv3, sum(cri_r1_f10 + cri_r3_f10 + cri_r5_f10 +oui_r1_f10 + oui_r3_f10 + oui_r5_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r4_f10 + cri_r6_f10 +oui_r2_f10 + oui_r4_f10 + oui_r6_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r3_f11 + cri_r5_f11 +oui_r1_f11 + oui_r3_f11 + oui_r5_f11) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r4_f11 + cri_r6_f11 +oui_r2_f11 + oui_r4_f11 + oui_r6_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r3_f12 + cri_r5_f12 +oui_r1_f12 + oui_r3_f12 + oui_r5_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r4_f12 + cri_r6_f12 +oui_r2_f12 + oui_r4_f12 + oui_r6_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r3_f13 + cri_r5_f13 +oui_r1_f13 + oui_r3_f13 + oui_r5_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r4_f13 + cri_r6_f13 +oui_r2_f13 + oui_r4_f13 + oui_r6_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r3_f14 + cri_r5_f14 +oui_r1_f14 + oui_r3_f14 + oui_r5_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r4_f14 + cri_r6_f14 +oui_r2_f14 + oui_r4_f14 + oui_r6_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r3_f15 + cri_r5_f15 +oui_r1_f15 + oui_r3_f15 + oui_r5_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r4_f15 + cri_r6_f15 +oui_r2_f15 + oui_r4_f15 + oui_r6_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r3_f16 + cri_r5_f16 +oui_r1_f16 + oui_r3_f16 + oui_r5_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r4_f16 + cri_r6_f16 +oui_r2_f16 + oui_r4_f16 + oui_r6_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 +oui_r1_f17 + oui_r3_f17 + oui_r5_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 +oui_r2_f17 + oui_r4_f17 + oui_r6_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r3_f18 + cri_r5_f18 +oui_r1_f18 + oui_r3_f18 + oui_r5_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r4_f18 + cri_r6_f18 +oui_r2_f18 + oui_r4_f18 + oui_r6_f18) as f_cols_measles2, sum(ttri_r1_f1 + ttoui_r1_f1) as in_tt1, sum(ttri_r1_f2 + ttoui_r1_f2) as in_tt2, sum(ttri_r1_f3 + ttoui_r1_f3) as in_tt3, sum(ttri_r1_f4 + ttoui_r1_f4) as in_tt4, sum(ttri_r1_f5 + ttoui_r1_f5) as in_tt5, sum(ttri_r2_f1 + ttoui_r2_f1) as in_cba1, sum(ttri_r2_f2 + ttoui_r2_f2) as in_cba2, sum(ttri_r2_f3 + ttoui_r2_f3) as in_cba3, sum(ttri_r2_f4 +ttoui_r2_f4) as in_cba4, sum(ttri_r2_f5 + ttoui_r2_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r1_f1 + od_r3_f1 + od_r5_f1) as m_cols_bcg, sum(od_r2_f1 + od_r4_f1 + od_r6_f1) as f_cols_bcg, sum(od_r1_f2 + od_r3_f2 + od_r5_f2) as m_cols_hepb, sum(od_r2_f2 + od_r4_f2 + od_r6_f2) as f_cols_hepb, sum(od_r1_f3 + od_r3_f3 + od_r5_f3) as m_cols_opv0, sum(od_r2_f3 + od_r4_f3 + od_r6_f3) as f_cols_opv0, sum(od_r1_f4 + od_r3_f4 + od_r5_f4) as m_cols_opv1, sum(od_r2_f4 + od_r4_f4 + od_r6_f4) as f_cols_opv1, sum(od_r1_f5 + od_r3_f5 + od_r5_f5) as m_cols_opv2, sum(od_r2_f5 + od_r4_f5 + od_r6_f5) as f_cols_opv2, sum(od_r1_f6 + od_r3_f6 + od_r5_f6) as m_cols_opv3, sum(od_r2_f6 + od_r4_f6 + od_r6_f6) as f_cols_opv3, sum(od_r1_f7 + od_r3_f7 + od_r5_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r4_f7 + od_r6_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r3_f8 + od_r5_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r4_f8 + od_r6_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r3_f9 + od_r5_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r4_f9 + od_r6_f9) as f_cols_pentv3, sum(od_r1_f10 + od_r3_f10 + od_r5_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r4_f10 + od_r6_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r3_f11 + od_r5_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r4_f11 + od_r6_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r3_f12 + od_r5_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r4_f12 + od_r6_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r3_f13 + od_r5_f13) as m_cols_ipv, sum(od_r2_f13 + od_r4_f13 + od_r6_f13) as f_cols_ipv, sum(od_r1_f14 + od_r3_f14 + od_r5_f14) as m_cols_rota1, sum(od_r2_f14 + od_r4_f14 + od_r6_f14) as f_cols_rota1, sum(od_r1_f15 + od_r3_f15 + od_r5_f15) as m_cols_rota2, sum(od_r2_f15 + od_r4_f15 + od_r6_f15) as f_cols_rota2, sum(od_r1_f16 + od_r3_f16 + od_r5_f16) as m_cols_measles1, sum(od_r2_f16 + od_r4_f16 + od_r6_f16) as f_cols_measles1, sum(od_r1_f17 + od_r3_f17 + od_r5_f17) as m_cols_fully, sum(od_r2_f17 + od_r4_f17 + od_r6_f17) as f_cols_fully, sum(od_r1_f18 + od_r3_f18 + od_r5_f18) as m_cols_measles2, sum(od_r2_f18 + od_r4_f18 + od_r6_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done		
			if($vacc_to == 'total_children' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 +oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 +oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 +oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 +oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 + oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 + oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 + oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 +oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 + oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 + oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 + oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 + oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 + oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 + oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 + oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 + oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 + oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 + oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 + oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 + oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 + oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 + oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 + oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 +oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 +oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 + oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 + oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 + oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 + oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 +oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 + oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 +oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 +oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 +oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 +oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 +oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done
			if($vacc_to == 'gender' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r1_f1 + cri_r3_f1 + cri_r5_f1 +oui_r1_f1 + oui_r3_f1 + oui_r5_f1) as m_cols_bcg, sum(cri_r2_f1 + cri_r4_f1 + cri_r6_f1 +oui_r2_f1 + oui_r4_f1 + oui_r6_f1) as f_cols_bcg, sum(cri_r1_f2 + cri_r3_f2 + cri_r5_f2 +oui_r1_f2 + oui_r3_f2 + oui_r5_f2) as m_cols_hepb, sum(cri_r2_f2 + cri_r4_f2 + cri_r6_f2 +oui_r2_f2 + oui_r4_f2 + oui_r6_f2) as f_cols_hepb, sum(cri_r1_f3 + cri_r3_f3 + cri_r5_f3 +oui_r1_f3 + oui_r3_f3 + oui_r5_f3) as m_cols_opv0, sum(cri_r2_f3 + cri_r4_f3 + cri_r6_f3 +oui_r2_f3 + oui_r4_f3 + oui_r6_f3) as f_cols_opv0, sum(cri_r1_f4 + cri_r3_f4 + cri_r5_f4 +oui_r1_f4 + oui_r3_f4 + oui_r5_f4) as m_cols_opv1, sum(cri_r2_f4 + cri_r4_f4 + cri_r6_f4 +oui_r2_f4 + oui_r4_f4 + oui_r6_f4) as f_cols_opv1, sum(cri_r1_f5 + cri_r3_f5 + cri_r5_f5 +oui_r1_f5 + oui_r3_f5 + oui_r5_f5) as m_cols_opv2, sum(cri_r2_f5 + cri_r4_f5 + cri_r6_f5 +oui_r2_f5 + oui_r4_f5 + oui_r6_f5) as f_cols_opv2, sum(cri_r1_f6 + cri_r3_f6 + cri_r5_f6 +oui_r1_f6 + oui_r3_f6 + oui_r5_f6) as m_cols_opv3, sum(cri_r2_f6 + cri_r4_f6 + cri_r6_f6 +oui_r2_f6 + oui_r4_f6 + oui_r6_f6) as f_cols_opv3, sum(cri_r1_f7 + cri_r3_f7 + cri_r5_f7 +oui_r1_f7 + oui_r3_f7 + oui_r5_f7) as m_cols_pentv1, sum(cri_r2_f7 + cri_r4_f7 + cri_r6_f7 +oui_r2_f7 + oui_r4_f7 + oui_r6_f7) as f_cols_pentv1, sum(cri_r1_f8 + cri_r3_f8 + cri_r5_f8 +oui_r1_f8 + oui_r3_f8 + oui_r5_f8) as m_cols_pentv2, sum(cri_r2_f8 + cri_r4_f8 + cri_r6_f8 +oui_r2_f8 + oui_r4_f8 + oui_r6_f8) as f_cols_pentv2, sum(cri_r1_f9 + cri_r3_f9 + cri_r5_f9 +oui_r1_f9 + oui_r3_f9 + oui_r5_f9) as m_cols_pentv3, sum(cri_r2_f9 + cri_r4_f9 + cri_r6_f9 +oui_r2_f9 + oui_r4_f9 + oui_r6_f9) as f_cols_pentv3, sum(cri_r1_f10 + cri_r3_f10 + cri_r5_f10 +oui_r1_f10 + oui_r3_f10 + oui_r5_f10) as m_cols_pcv10_1, sum(cri_r2_f10 + cri_r4_f10 + cri_r6_f10 +oui_r2_f10 + oui_r4_f10 + oui_r6_f10) as f_cols_pcv10_1, sum(cri_r1_f11 + cri_r3_f11 + cri_r5_f11 +oui_r1_f11 + oui_r3_f11 + oui_r5_f11) as m_cols_pcv10_2, sum(cri_r2_f11 + cri_r4_f11 + cri_r6_f11 +oui_r2_f11 + oui_r4_f11 + oui_r6_f11) as f_cols_pcv10_2, sum(cri_r1_f12 + cri_r3_f12 + cri_r5_f12 +oui_r1_f12 + oui_r3_f12 + oui_r5_f12) as m_cols_pcv10_3, sum(cri_r2_f12 + cri_r4_f12 + cri_r6_f12 +oui_r2_f12 + oui_r4_f12 + oui_r6_f12) as f_cols_pcv10_3, sum(cri_r1_f13 + cri_r3_f13 + cri_r5_f13 +oui_r1_f13 + oui_r3_f13 + oui_r5_f13) as m_cols_ipv, sum(cri_r2_f13 + cri_r4_f13 + cri_r6_f13 +oui_r2_f13 + oui_r4_f13 + oui_r6_f13) as f_cols_ipv, sum(cri_r1_f14 + cri_r3_f14 + cri_r5_f14 +oui_r1_f14 + oui_r3_f14 + oui_r5_f14) as m_cols_rota1, sum(cri_r2_f14 + cri_r4_f14 + cri_r6_f14 +oui_r2_f14 + oui_r4_f14 + oui_r6_f14) as f_cols_rota1, sum(cri_r1_f15 + cri_r3_f15 + cri_r5_f15 +oui_r1_f15 + oui_r3_f15 + oui_r5_f15) as m_cols_rota2, sum(cri_r2_f15 + cri_r4_f15 + cri_r6_f15 +oui_r2_f15 + oui_r4_f15 + oui_r6_f15) as f_cols_rota2, sum(cri_r1_f16 + cri_r3_f16 + cri_r5_f16 +oui_r1_f16 + oui_r3_f16 + oui_r5_f16) as m_cols_measles1, sum(cri_r2_f16 + cri_r4_f16 + cri_r6_f16 +oui_r2_f16 + oui_r4_f16 + oui_r6_f16) as f_cols_measles1, sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 +oui_r1_f17 + oui_r3_f17 + oui_r5_f17) as m_cols_fully, sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 +oui_r2_f17 + oui_r4_f17 + oui_r6_f17) as f_cols_fully, sum(cri_r1_f18 + cri_r3_f18 + cri_r5_f18 +oui_r1_f18 + oui_r3_f18 + oui_r5_f18) as m_cols_measles2, sum(cri_r2_f18 + cri_r4_f18 + cri_r6_f18 +oui_r2_f18 + oui_r4_f18 + oui_r6_f18) as f_cols_measles2, sum(ttri_r1_f1 + ttoui_r1_f1) as in_tt1, sum(ttri_r1_f2 +ttoui_r1_f2) as in_tt2, sum(ttri_r1_f3 +ttoui_r1_f3) as in_tt3, sum(ttri_r1_f4 +ttoui_r1_f4) as in_tt4, sum(ttri_r1_f5 +ttoui_r1_f5) as in_tt5, sum(ttri_r2_f1 + ttoui_r2_f1) as in_cba1, sum(ttri_r2_f2 + ttoui_r2_f2) as in_cba2, sum(ttri_r2_f3 +ttoui_r2_f3) as in_cba3, sum(ttri_r2_f4 +ttoui_r2_f4) as in_cba4, sum(ttri_r2_f5 +ttoui_r2_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode 
				UNION ALL 
				select distcode, sum(od_r1_f1 + od_r3_f1 + od_r5_f1) as m_cols_bcg, sum(od_r2_f1 + od_r4_f1 + od_r6_f1) as f_cols_bcg, sum(od_r1_f2 + od_r3_f2 + od_r5_f2) as m_cols_hepb, sum(od_r2_f2 + od_r4_f2 + od_r6_f2) as f_cols_hepb, sum(od_r1_f3 + od_r3_f3 + od_r5_f3) as m_cols_opv0, sum(od_r2_f3 + od_r4_f3 + od_r6_f3) as f_cols_opv0, sum(od_r1_f4 + od_r3_f4 + od_r5_f4) as m_cols_opv1, sum(od_r2_f4 + od_r4_f4 + od_r6_f4) as f_cols_opv1, sum(od_r1_f5 + od_r3_f5 + od_r5_f5) as m_cols_opv2, sum(od_r2_f5 + od_r4_f5 + od_r6_f5) as f_cols_opv2, sum(od_r1_f6 + od_r3_f6 + od_r5_f6) as m_cols_opv3, sum(od_r2_f6 + od_r4_f6 + od_r6_f6) as f_cols_opv3, sum(od_r1_f7 + od_r3_f7 + od_r5_f7) as m_cols_pentv1, sum(od_r2_f7 + od_r4_f7 + od_r6_f7) as f_cols_pentv1, sum(od_r1_f8 + od_r3_f8 + od_r5_f8) as m_cols_pentv2, sum(od_r2_f8 + od_r4_f8 + od_r6_f8) as f_cols_pentv2, sum(od_r1_f9 + od_r3_f9 + od_r5_f9) as m_cols_pentv3, sum(od_r2_f9 + od_r4_f9 + od_r6_f9) as f_cols_pentv3, sum(od_r1_f10 + od_r3_f10 + od_r5_f10) as m_cols_pcv10_1, sum(od_r2_f10 + od_r4_f10 + od_r6_f10) as f_cols_pcv10_1, sum(od_r1_f11 + od_r3_f11 + od_r5_f11) as m_cols_pcv10_2, sum(od_r2_f11 + od_r4_f11 + od_r6_f11) as f_cols_pcv10_2, sum(od_r1_f12 + od_r3_f12 + od_r5_f12) as m_cols_pcv10_3, sum(od_r2_f12 + od_r4_f12 + od_r6_f12) as f_cols_pcv10_3, sum(od_r1_f13 + od_r3_f13 + od_r5_f13) as m_cols_ipv, sum(od_r2_f13 + od_r4_f13 + od_r6_f13) as f_cols_ipv, sum(od_r1_f14 + od_r3_f14 + od_r5_f14) as m_cols_rota1, sum(od_r2_f14 + od_r4_f14 + od_r6_f14) as f_cols_rota1, sum(od_r1_f15 + od_r3_f15 + od_r5_f15) as m_cols_rota2, sum(od_r2_f15 + od_r4_f15 + od_r6_f15) as f_cols_rota2, sum(od_r1_f16 + od_r3_f16 + od_r5_f16) as m_cols_measles1, sum(od_r2_f16 + od_r4_f16 + od_r6_f16) as f_cols_measles1, sum(od_r1_f17 + od_r3_f17 + od_r5_f17) as m_cols_fully, sum(od_r2_f17 + od_r4_f17 + od_r6_f17) as f_cols_fully, sum(od_r1_f18 + od_r3_f18 + od_r5_f18) as m_cols_measles2, sum(od_r2_f18 + od_r4_f18 + od_r6_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done
			if($vacc_to == 'gender' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 + oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 + oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 + oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 + oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 + oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 + oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 + oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 +oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 +oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 +oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 +oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 +oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 +oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 +oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 +oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 +oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 +oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 +oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 +oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 +oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 +oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 +oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 +oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 +oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 +oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 +oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 +oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 +oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 +oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 +oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 +oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 +oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 +oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 +oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 +oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 +oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";				
			}
		}
		if($vaccination_type == 'outreach'){
			if($age_wise == '0to11'){
				$a = "r7";
				$b = "r8";
			}
			if($age_wise == '12to23'){
				$a = "r9";
				$b = "r10";
			}
			if($age_wise == 'above2'){
				$a = "r11";
				$b = "r12";
			}
			$x = 3; $y = 4;
			//done
			if($vacc_to == 'total_children' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r7_f1 + cri_r9_f1 + cri_r11_f1 +oui_r7_f1 + oui_r9_f1 + oui_r11_f1) as m_cols_bcg, sum(cri_r8_f1 + cri_r10_f1 + cri_r12_f1 +oui_r8_f1 + oui_r10_f1 + oui_r12_f1) as f_cols_bcg, sum(cri_r7_f2 + cri_r9_f2 + cri_r11_f2 +oui_r7_f2 + oui_r9_f2 + oui_r11_f2) as m_cols_hepb, sum(cri_r8_f2 + cri_r10_f2 + cri_r12_f2 +oui_r8_f2 + oui_r10_f2 + oui_r12_f2) as f_cols_hepb, sum(cri_r7_f3 + cri_r9_f3 + cri_r11_f3 +oui_r7_f3 + oui_r9_f3 + oui_r11_f3) as m_cols_opv0, sum(cri_r8_f3 + cri_r10_f3 + cri_r12_f3 +oui_r8_f3 + oui_r10_f3 + oui_r12_f3) as f_cols_opv0, sum(cri_r7_f4 + cri_r9_f4 + cri_r11_f4 +oui_r7_f4 + oui_r9_f4 + oui_r11_f4) as m_cols_opv1, sum(cri_r8_f4 + cri_r10_f4 + cri_r12_f4 +oui_r8_f4 + oui_r10_f4 + oui_r12_f4) as f_cols_opv1, sum(cri_r7_f5 + cri_r9_f5 + cri_r11_f5 +oui_r7_f5 + oui_r9_f5 + oui_r11_f5) as m_cols_opv2, sum(cri_r8_f5 + cri_r10_f5 + cri_r12_f5 +oui_r8_f5 + oui_r10_f5 + oui_r12_f5) as f_cols_opv2, sum(cri_r7_f6 + cri_r9_f6 + cri_r11_f6 +oui_r7_f6 + oui_r9_f6 + oui_r11_f6) as m_cols_opv3, sum(cri_r8_f6 + cri_r10_f6 + cri_r12_f6 +oui_r8_f6 + oui_r10_f6 + oui_r12_f6) as f_cols_opv3, sum(cri_r7_f7 + cri_r9_f7 + cri_r11_f7 +oui_r7_f7 + oui_r9_f7 + oui_r11_f7) as m_cols_pentv1, sum(cri_r8_f7 + cri_r10_f7 + cri_r12_f7 +oui_r8_f7 + oui_r10_f7 + oui_r12_f7) as f_cols_pentv1, sum(cri_r7_f8 + cri_r9_f8 + cri_r11_f8 +oui_r7_f8 + oui_r9_f8 + oui_r11_f8) as m_cols_pentv2, sum(cri_r8_f8 + cri_r10_f8 + cri_r12_f8 +oui_r8_f8 + oui_r10_f8 + oui_r12_f8) as f_cols_pentv2, sum(cri_r7_f9 + cri_r9_f9 + cri_r11_f9 +oui_r7_f9 + oui_r9_f9 + oui_r11_f9) as m_cols_pentv3, sum(cri_r8_f9 + cri_r10_f9 + cri_r12_f9 +oui_r8_f9 + oui_r10_f9 + oui_r12_f9) as f_cols_pentv3, sum(cri_r7_f10 + cri_r9_f10 + cri_r11_f10 +oui_r7_f10 + oui_r9_f10 + oui_r11_f10) as m_cols_pcv10_1, sum(cri_r8_f10 + cri_r10_f10 + cri_r12_f10 +oui_r8_f10 + oui_r10_f10 + oui_r12_f10) as f_cols_pcv10_1, sum(cri_r7_f11 + cri_r9_f11 + cri_r11_f11 +oui_r7_f11 + oui_r9_f11 + oui_r11_f11) as m_cols_pcv10_2, sum(cri_r8_f11 + cri_r10_f11 + cri_r12_f11 +oui_r8_f11 + oui_r10_f11 + oui_r12_f11) as f_cols_pcv10_2, sum(cri_r7_f12 + cri_r9_f12 + cri_r11_f12 +oui_r7_f12 + oui_r9_f12 + oui_r11_f12) as m_cols_pcv10_3, sum(cri_r8_f12 + cri_r10_f12 + cri_r12_f12 +oui_r8_f12 + oui_r10_f12 + oui_r12_f12) as f_cols_pcv10_3, sum(cri_r7_f13 + cri_r9_f13 + cri_r11_f13 +oui_r7_f13 + oui_r9_f13 + oui_r11_f13) as m_cols_ipv, sum(cri_r8_f13 + cri_r10_f13 + cri_r12_f13 +oui_r8_f13 + oui_r10_f13 + oui_r12_f13) as f_cols_ipv, sum(cri_r7_f14 + cri_r9_f14 + cri_r11_f14 +oui_r7_f14 + oui_r9_f14 + oui_r11_f14) as m_cols_rota1, sum(cri_r8_f14 + cri_r10_f14 + cri_r12_f14 +oui_r8_f14 + oui_r10_f14 + oui_r12_f14) as f_cols_rota1, sum(cri_r7_f15 + cri_r9_f15 + cri_r11_f15 +oui_r7_f15 + oui_r9_f15 + oui_r11_f15) as m_cols_rota2, sum(cri_r8_f15 + cri_r10_f15 + cri_r12_f15 +oui_r8_f15 + oui_r10_f15 + oui_r12_f15) as f_cols_rota2, sum(cri_r7_f16 + cri_r9_f16 + cri_r11_f16 +oui_r7_f16 + oui_r9_f16 + oui_r11_f16) as m_cols_measles1, sum(cri_r8_f16 + cri_r10_f16 + cri_r12_f16 +oui_r8_f16 + oui_r10_f16 + oui_r12_f16) as f_cols_measles1, sum(cri_r7_f17 + cri_r9_f17 + cri_r11_f17 +oui_r7_f17 + oui_r9_f17 + oui_r11_f17) as m_cols_fully, sum(cri_r8_f17 + cri_r10_f17 + cri_r12_f17 +oui_r8_f17 + oui_r10_f17 + oui_r12_f17) as f_cols_fully, sum(cri_r7_f18 + cri_r9_f18 + cri_r11_f18 +oui_r7_f18 + oui_r9_f18 + oui_r11_f18) as m_cols_measles2, sum(cri_r8_f18 + cri_r10_f18 + cri_r12_f18 +oui_r8_f18 + oui_r10_f18 + oui_r12_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 +ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 +ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 +ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 +ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 +ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 +ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 +ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 +ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 +ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 +ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r7_f1 + od_r9_f1 + od_r11_f1) as m_cols_bcg, sum(od_r8_f1 + od_r10_f1 + od_r12_f1) as f_cols_bcg, sum(od_r7_f2 + od_r9_f2 + od_r11_f2) as m_cols_hepb, sum(od_r8_f2 + od_r10_f2 + od_r12_f2) as f_cols_hepb, sum(od_r7_f3 + od_r9_f3 + od_r11_f3) as m_cols_opv0, sum(od_r8_f3 + od_r10_f3 + od_r12_f3) as f_cols_opv0, sum(od_r7_f4 + od_r9_f4 + od_r11_f4) as m_cols_opv1, sum(od_r8_f4 + od_r10_f4 + od_r12_f4) as f_cols_opv1, sum(od_r7_f5 + od_r9_f5 + od_r11_f5) as m_cols_opv2, sum(od_r8_f5 + od_r10_f5 + od_r12_f5) as f_cols_opv2, sum(od_r7_f6 + od_r9_f6 + od_r11_f6) as m_cols_opv3, sum(od_r8_f6 + od_r10_f6 + od_r12_f6) as f_cols_opv3, sum(od_r7_f7 + od_r9_f7 + od_r11_f7) as m_cols_pentv1, sum(od_r8_f7 + od_r10_f7 + od_r12_f7) as f_cols_pentv1, sum(od_r7_f8 + od_r9_f8 + od_r11_f8) as m_cols_pentv2, sum(od_r8_f8 + od_r10_f8 + od_r12_f8) as f_cols_pentv2, sum(od_r7_f9 + od_r9_f9 + od_r11_f9) as m_cols_pentv3, sum(od_r8_f9 + od_r10_f9 + od_r12_f9) as f_cols_pentv3, sum(od_r7_f10 + od_r9_f10 + od_r11_f10) as m_cols_pcv10_1, sum(od_r8_f10 + od_r10_f10 + od_r12_f10) as f_cols_pcv10_1, sum(od_r7_f11 + od_r9_f11 + od_r11_f11) as m_cols_pcv10_2, sum(od_r8_f11 + od_r10_f11 + od_r12_f11) as f_cols_pcv10_2, sum(od_r7_f12 + od_r9_f12 + od_r11_f12) as m_cols_pcv10_3, sum(od_r8_f12 + od_r10_f12 + od_r12_f12) as f_cols_pcv10_3, sum(od_r7_f13 + od_r9_f13 + od_r11_f13) as m_cols_ipv, sum(od_r8_f13 + od_r10_f13 + od_r12_f13) as f_cols_ipv, sum(od_r7_f14 + od_r9_f14 + od_r11_f14) as m_cols_rota1, sum(od_r8_f14 + od_r10_f14 + od_r12_f14) as f_cols_rota1, sum(od_r7_f15 + od_r9_f15 + od_r11_f15) as m_cols_rota2, sum(od_r8_f15 + od_r10_f15 + od_r12_f15) as f_cols_rota2, sum(od_r7_f16 + od_r9_f16 + od_r11_f16) as m_cols_measles1, sum(od_r8_f16 + od_r10_f16 + od_r12_f16) as f_cols_measles1, sum(od_r7_f17 + od_r9_f17 + od_r11_f17) as m_cols_fully, sum(od_r8_f17 + od_r10_f17 + od_r12_f17) as f_cols_fully, sum(od_r7_f18 + od_r9_f18 + od_r11_f18) as m_cols_measles2, sum(od_r8_f18 + od_r10_f18 + od_r12_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}		//done
			if($vacc_to == 'total_children' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 +oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 +oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 +oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 +oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 +oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 +oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 +oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 +oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 +oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 +oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 +cri_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 +cri_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 +oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 +oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 +oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 +oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 +oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 +oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 +oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 +oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 +oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 +oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 +oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 +oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 +oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 +oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 +oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 +oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 +oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 +oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 +oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 +oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 +oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 +oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 +oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 +oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}//done
			if($vacc_to == 'gender' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r7_f1 + cri_r9_f1 + cri_r11_f1 +oui_r7_f1 + oui_r9_f1 + oui_r11_f1) as m_cols_bcg, sum(cri_r8_f1 + cri_r10_f1 + cri_r12_f1 +oui_r8_f1 + oui_r10_f1 + oui_r12_f1) as f_cols_bcg, sum(cri_r7_f2 + cri_r9_f2 + cri_r11_f2 +oui_r7_f2 + oui_r9_f2 + oui_r11_f2) as m_cols_hepb, sum(cri_r8_f2 + cri_r10_f2 + cri_r12_f2 +oui_r8_f2 + oui_r10_f2 + oui_r12_f2) as f_cols_hepb, sum(cri_r7_f3 + cri_r9_f3 + cri_r11_f3 +oui_r7_f3 + oui_r9_f3 + oui_r11_f3) as m_cols_opv0, sum(cri_r8_f3 + cri_r10_f3 + cri_r12_f3 +oui_r8_f3 + oui_r10_f3 + oui_r12_f3) as f_cols_opv0, sum(cri_r7_f4 + cri_r9_f4 + cri_r11_f4 +oui_r7_f4 + oui_r9_f4 + oui_r11_f4) as m_cols_opv1, sum(cri_r8_f4 + cri_r10_f4 + cri_r12_f4 +oui_r8_f4 + oui_r10_f4 + oui_r12_f4) as f_cols_opv1, sum(cri_r7_f5 + cri_r9_f5 + cri_r11_f5 +oui_r7_f5 + oui_r9_f5 + oui_r11_f5) as m_cols_opv2, sum(cri_r8_f5 + cri_r10_f5 + cri_r12_f5 +oui_r8_f5 + oui_r10_f5 + oui_r12_f5) as f_cols_opv2, sum(cri_r7_f6 + cri_r9_f6 + cri_r11_f6 +oui_r7_f6 + oui_r9_f6 + oui_r11_f6) as m_cols_opv3, sum(cri_r8_f6 + cri_r10_f6 + cri_r12_f6 +oui_r8_f6 + oui_r10_f6 + oui_r12_f6) as f_cols_opv3, sum(cri_r7_f7 + cri_r9_f7 + cri_r11_f7 +oui_r7_f7 + oui_r9_f7 + oui_r11_f7) as m_cols_pentv1, sum(cri_r8_f7 + cri_r10_f7 + cri_r12_f7 +oui_r8_f7 + oui_r10_f7 + oui_r12_f7) as f_cols_pentv1, sum(cri_r7_f8 + cri_r9_f8 + cri_r11_f8 +oui_r7_f8 + oui_r9_f8 + oui_r11_f8) as m_cols_pentv2, sum(cri_r8_f8 + cri_r10_f8 + cri_r12_f8 +oui_r8_f8 + oui_r10_f8 + oui_r12_f8) as f_cols_pentv2, sum(cri_r7_f9 + cri_r9_f9 + cri_r11_f9 +oui_r7_f9 + oui_r9_f9 + oui_r11_f9) as m_cols_pentv3, sum(cri_r8_f9 + cri_r10_f9 + cri_r12_f9 +oui_r8_f9 + oui_r10_f9 + oui_r12_f9) as f_cols_pentv3, sum(cri_r7_f10 + cri_r9_f10 + cri_r11_f10 +oui_r7_f10 + oui_r9_f10 + oui_r11_f10) as m_cols_pcv10_1, sum(cri_r8_f10 + cri_r10_f10 + cri_r12_f10 +oui_r8_f10 + oui_r10_f10 + oui_r12_f10) as f_cols_pcv10_1, sum(cri_r7_f11 + cri_r9_f11 + cri_r11_f11 +oui_r7_f11 + oui_r9_f11 + oui_r11_f11) as m_cols_pcv10_2, sum(cri_r8_f11 + cri_r10_f11 + cri_r12_f11 +oui_r8_f11 + oui_r10_f11 + oui_r12_f11) as f_cols_pcv10_2, sum(cri_r7_f12 + cri_r9_f12 + cri_r11_f12 +oui_r7_f12 + oui_r9_f12 + oui_r11_f12) as m_cols_pcv10_3, sum(cri_r8_f12 + cri_r10_f12 + cri_r12_f12 +oui_r8_f12 + oui_r10_f12 + oui_r12_f12) as f_cols_pcv10_3, sum(cri_r7_f13 + cri_r9_f13 + cri_r11_f13 +oui_r7_f13 + oui_r9_f13 + oui_r11_f13) as m_cols_ipv, sum(cri_r8_f13 + cri_r10_f13 + cri_r12_f13 +oui_r8_f13 + oui_r10_f13 + oui_r12_f13) as f_cols_ipv, sum(cri_r7_f14 + cri_r9_f14 + cri_r11_f14 +oui_r7_f14 + oui_r9_f14 + oui_r11_f14) as m_cols_rota1, sum(cri_r8_f14 + cri_r10_f14 + cri_r12_f14 +oui_r7_f15 + oui_r9_f15 + oui_r11_f15) as f_cols_rota1, sum(cri_r7_f15 + cri_r9_f15 + cri_r11_f15 +oui_r7_f15 + oui_r9_f15 + oui_r11_f15) as m_cols_rota2, sum(cri_r8_f15 + cri_r10_f15 + cri_r12_f15 +oui_r8_f15 + oui_r10_f15 + oui_r12_f15) as f_cols_rota2, sum(cri_r7_f16 + cri_r9_f16 + cri_r11_f16 +oui_r7_f16 + oui_r9_f16 + oui_r11_f16) as m_cols_measles1, sum(cri_r8_f16 + cri_r10_f16 + cri_r12_f16 +oui_r8_f16 + oui_r10_f16 + oui_r12_f16) as f_cols_measles1, sum(cri_r7_f17 + cri_r9_f17 + cri_r11_f17 +oui_r7_f17 + oui_r9_f17 + oui_r11_f17) as m_cols_fully, sum(cri_r8_f17 + cri_r10_f17 + cri_r12_f17 +oui_r8_f17 + oui_r10_f17 + oui_r12_f17) as f_cols_fully, sum(cri_r7_f18 + cri_r9_f18 + cri_r11_f18 +oui_r7_f18 + oui_r9_f18 + oui_r11_f18) as m_cols_measles2, sum(cri_r8_f18 + cri_r10_f18 + cri_r12_f18 +oui_r8_f18 + oui_r10_f18 + oui_r12_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 +ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 +ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 +ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 +ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 +ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 +ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 +ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 +ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 +ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 +ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r7_f1 + od_r9_f1 + od_r11_f1) as m_cols_bcg, sum(od_r8_f1 + od_r10_f1 + od_r12_f1) as f_cols_bcg, sum(od_r7_f2 + od_r9_f2 + od_r11_f2) as m_cols_hepb, sum(od_r8_f2 + od_r10_f2 + od_r12_f2) as f_cols_hepb, sum(od_r7_f3 + od_r9_f3 + od_r11_f3) as m_cols_opv0, sum(od_r8_f3 + od_r10_f3 + od_r12_f3) as f_cols_opv0, sum(od_r7_f4 + od_r9_f4 + od_r11_f4) as m_cols_opv1, sum(od_r8_f4 + od_r10_f4 + od_r12_f4) as f_cols_opv1, sum(od_r7_f5 + od_r9_f5 + od_r11_f5) as m_cols_opv2, sum(od_r8_f5 + od_r10_f5 + od_r12_f5) as f_cols_opv2, sum(od_r7_f6 + od_r9_f6 + od_r11_f6) as m_cols_opv3, sum(od_r8_f6 + od_r10_f6 + od_r12_f6) as f_cols_opv3, sum(od_r7_f7 + od_r9_f7 + od_r11_f7) as m_cols_pentv1, sum(od_r8_f7 + od_r10_f7 + od_r12_f7) as f_cols_pentv1, sum(od_r7_f8 + od_r9_f8 + od_r11_f8) as m_cols_pentv2, sum(od_r8_f8 + od_r10_f8 + od_r12_f8) as f_cols_pentv2, sum(od_r7_f9 + od_r9_f9 + od_r11_f9) as m_cols_pentv3, sum(od_r8_f9 + od_r10_f9 + od_r12_f9) as f_cols_pentv3, sum(od_r7_f10 + od_r9_f10 + od_r11_f10) as m_cols_pcv10_1, sum(od_r8_f10 + od_r10_f10 + od_r12_f10) as f_cols_pcv10_1, sum(od_r7_f11 + od_r9_f11 + od_r11_f11) as m_cols_pcv10_2, sum(od_r8_f11 + od_r10_f11 + od_r12_f11) as f_cols_pcv10_2, sum(od_r7_f12 + od_r9_f12 + od_r11_f12) as m_cols_pcv10_3, sum(od_r8_f12 + od_r10_f12 + od_r12_f12) as f_cols_pcv10_3, sum(od_r7_f13 + od_r9_f13 + od_r11_f13) as m_cols_ipv, sum(od_r8_f13 + od_r10_f13 + od_r12_f13) as f_cols_ipv, sum(od_r7_f14 + od_r9_f14 + od_r11_f14) as m_cols_rota1, sum(od_r8_f14 + od_r10_f14 + od_r12_f14) as f_cols_rota1, sum(od_r7_f15 + od_r9_f15 + od_r11_f15) as m_cols_rota2, sum(od_r8_f15 + od_r10_f15 + od_r12_f15) as f_cols_rota2, sum(od_r7_f16 + od_r9_f16 + od_r11_f16) as m_cols_measles1, sum(od_r8_f16 + od_r10_f16 + od_r12_f16) as f_cols_measles1, sum(od_r7_f17 + od_r9_f17 + od_r11_f17) as m_cols_fully, sum(od_r8_f17 + od_r10_f17 + od_r12_f17) as f_cols_fully, sum(od_r7_f18 + od_r9_f18 + od_r11_f18) as m_cols_measles2, sum(od_r8_f18 + od_r10_f18 + od_r12_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";				
			}
			if($vacc_to == 'gender' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 +oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 +oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 +oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 +oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 +oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 +oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 +oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 +oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 +oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 +oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 +oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 +oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 +oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 +oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 +oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 +oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 +oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 +oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 +oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 +oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 +oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 +oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 +oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 +oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 +oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 +oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 +oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 +oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 +oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 +oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 +oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 +oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 +oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 +oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 +oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 +oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}
		}//done
		if($vaccination_type == 'mobile'){
			if($age_wise == '0to11'){
				$a = "r13";
				$b = "r14";
			}
			if($age_wise == '12to23'){
				$a = "r15";
				$b = "r16";
			}
			if($age_wise == 'above2'){
				$a = "r17";
				$b = "r18";
			}
			$x = 5; $y = 6;
			if($vacc_to == 'total_children' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r13_f1 + cri_r15_f1 + cri_r17_f1 +oui_r13_f1 + oui_r15_f1 + oui_r17_f1) as m_cols_bcg, sum(cri_r14_f1 + cri_r16_f1 + cri_r18_f1 +oui_r14_f1 + oui_r16_f1 + oui_r18_f1) as f_cols_bcg, sum(cri_r13_f2 + cri_r15_f2 + cri_r17_f2 +oui_r13_f2 + oui_r15_f2 + oui_r17_f2) as m_cols_hepb, sum(cri_r14_f2 + cri_r16_f2 + cri_r18_f2 +oui_r14_f2 + oui_r16_f2 + oui_r18_f2) as f_cols_hepb, sum(cri_r13_f3 + cri_r15_f3 + cri_r17_f3 +oui_r13_f3 + oui_r15_f3 + oui_r17_f3) as m_cols_opv0, sum(cri_r14_f3 + cri_r16_f3 + cri_r18_f3 +oui_r14_f3 + oui_r16_f3 + oui_r18_f3) as f_cols_opv0, sum(cri_r13_f4 + cri_r15_f4 + cri_r17_f4 +oui_r13_f4 + oui_r15_f4 + oui_r17_f4) as m_cols_opv1, sum(cri_r14_f4 + cri_r16_f4 + cri_r18_f4 +oui_r14_f4 + oui_r16_f4 + oui_r18_f4) as f_cols_opv1, sum(cri_r13_f5 + cri_r15_f5 + cri_r17_f5 +oui_r13_f5 + oui_r15_f5 + oui_r17_f5) as m_cols_opv2, sum(cri_r14_f5 + cri_r16_f5 + cri_r18_f5 +oui_r14_f5 + oui_r16_f5 + oui_r18_f5) as f_cols_opv2, sum(cri_r13_f6 + cri_r15_f6 + cri_r17_f6 +oui_r13_f6 + oui_r15_f6 + oui_r17_f6) as m_cols_opv3, sum(cri_r14_f6 + cri_r16_f6 + cri_r18_f6 +oui_r14_f6 + oui_r16_f6 + oui_r18_f6) as f_cols_opv3, sum(cri_r13_f7 + cri_r15_f7 + cri_r17_f7 +oui_r13_f7 + oui_r15_f7 + oui_r17_f7) as m_cols_pentv1, sum(cri_r14_f7 + cri_r16_f7 + cri_r18_f7 +oui_r14_f7 + oui_r16_f7 + oui_r18_f7) as f_cols_pentv1, sum(cri_r13_f8 + cri_r15_f8 + cri_r17_f8 +oui_r13_f8 + oui_r15_f8 + oui_r17_f8) as m_cols_pentv2, sum(cri_r14_f8 + cri_r16_f8 + cri_r18_f8 +oui_r14_f8 + oui_r16_f8 + oui_r18_f8) as f_cols_pentv2, sum(cri_r13_f9 + cri_r15_f9 + cri_r17_f9 +oui_r13_f9 + oui_r15_f9 + oui_r17_f9) as m_cols_pentv3, sum(cri_r14_f9 + cri_r16_f9 + cri_r18_f9 +oui_r14_f9 + oui_r16_f9 + oui_r18_f9) as f_cols_pentv3, sum(cri_r13_f10 + cri_r15_f10 + cri_r17_f10 +oui_r13_f10 + oui_r15_f10 + oui_r17_f10) as m_cols_pcv10_1, sum(cri_r14_f10 + cri_r16_f10 + cri_r18_f10 +oui_r14_f10 + oui_r16_f10 + oui_r18_f10) as f_cols_pcv10_1, sum(cri_r13_f11 + cri_r15_f11 + cri_r17_f11 +oui_r13_f11 + oui_r15_f11 + oui_r17_f11) as m_cols_pcv10_2, sum(cri_r14_f11 + cri_r16_f11 + cri_r18_f11 +oui_r14_f11 + oui_r16_f11 + oui_r18_f11) as f_cols_pcv10_2, sum(cri_r13_f12 + cri_r15_f12 + cri_r17_f12 +oui_r13_f12 + oui_r15_f12 + oui_r17_f12) as m_cols_pcv10_3, sum(cri_r14_f12 + cri_r16_f12 + cri_r18_f12 +oui_r14_f12 + oui_r16_f12 + oui_r18_f12) as f_cols_pcv10_3, sum(cri_r13_f13 + cri_r15_f13 + cri_r17_f13 +oui_r13_f13 + oui_r15_f13 + oui_r17_f13) as m_cols_ipv, sum(cri_r14_f13 + cri_r16_f13 + cri_r18_f13 +oui_r14_f13 + oui_r16_f13 + oui_r18_f13) as f_cols_ipv, sum(cri_r13_f14 + cri_r15_f14 + cri_r17_f14 +oui_r13_f14 + oui_r15_f14 + oui_r17_f14) as m_cols_rota1, sum(cri_r14_f14 + cri_r16_f14 + cri_r18_f14 +oui_r14_f14 + oui_r16_f14 + oui_r18_f14) as f_cols_rota1, sum(cri_r13_f15 + cri_r15_f15 + cri_r17_f15 +oui_r13_f15 + oui_r15_f15 + oui_r17_f15) as m_cols_rota2, sum(cri_r14_f15 + cri_r16_f15 + cri_r18_f15 +oui_r14_f15 + oui_r16_f15 + oui_r18_f15) as f_cols_rota2, sum(cri_r13_f16 + cri_r15_f16 + cri_r17_f16 +oui_r13_f16 + oui_r15_f16 + oui_r17_f16) as m_cols_measles1, sum(cri_r14_f16 + cri_r16_f16 + cri_r18_f16 +oui_r14_f16 + oui_r16_f16 + oui_r18_f16) as f_cols_measles1, sum(cri_r13_f17 + cri_r15_f17 + cri_r17_f17 +oui_r13_f17 + oui_r15_f17 + oui_r17_f17) as m_cols_fully, sum(cri_r14_f17 + cri_r16_f17 + cri_r18_f17 +oui_r14_f17 + oui_r16_f17 + oui_r18_f17) as f_cols_fully, sum(cri_r13_f18 + cri_r15_f18 + cri_r17_f18 +oui_r13_f18 + oui_r15_f18 + oui_r17_f18) as m_cols_measles2, sum(cri_r14_f18 + cri_r16_f18 + cri_r18_f18 +oui_r14_f18 + oui_r16_f18 + oui_r18_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 +ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 +ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 +ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 +ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 +ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 +ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 +ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 +ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 +ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 +ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r13_f1 + od_r15_f1 + od_r17_f1) as m_cols_bcg, sum(od_r14_f1 + od_r16_f1 + od_r18_f1) as f_cols_bcg, sum(od_r13_f2 + od_r15_f2 + od_r17_f2) as m_cols_hepb, sum(od_r14_f2 + od_r16_f2 + od_r18_f2) as f_cols_hepb, sum(od_r13_f3 + od_r15_f3 + od_r17_f3) as m_cols_opv0, sum(od_r14_f3 + od_r16_f3 + od_r18_f3) as f_cols_opv0, sum(od_r13_f4 + od_r15_f4 + od_r17_f4) as m_cols_opv1, sum(od_r14_f4 + od_r16_f4 + od_r18_f4) as f_cols_opv1, sum(od_r13_f5 + od_r15_f5 + od_r17_f5) as m_cols_opv2, sum(od_r14_f5 + od_r16_f5 + od_r18_f5) as f_cols_opv2, sum(od_r13_f6 + od_r15_f6 + od_r17_f6) as m_cols_opv3, sum(od_r14_f6 + od_r16_f6 + od_r18_f6) as f_cols_opv3, sum(od_r13_f7 + od_r15_f7 + od_r17_f7) as m_cols_pentv1, sum(od_r14_f7 + od_r16_f7 + od_r18_f7) as f_cols_pentv1, sum(od_r13_f8 + od_r15_f8 + od_r17_f8) as m_cols_pentv2, sum(od_r14_f8 + od_r16_f8 + od_r18_f8) as f_cols_pentv2, sum(od_r13_f9 + od_r15_f9 + od_r17_f9) as m_cols_pentv3, sum(od_r14_f9 + od_r16_f9 + od_r18_f9) as f_cols_pentv3, sum(od_r13_f10 + od_r15_f10 + od_r17_f10) as m_cols_pcv10_1, sum(od_r14_f10 + od_r16_f10 + od_r18_f10) as f_cols_pcv10_1, sum(od_r13_f11 + od_r15_f11 + od_r17_f11) as m_cols_pcv10_2, sum(od_r14_f11 + od_r16_f11 + od_r18_f11) as f_cols_pcv10_2, sum(od_r13_f12 + od_r15_f12 + od_r17_f12) as m_cols_pcv10_3, sum(od_r14_f12 + od_r16_f12 + od_r18_f12) as f_cols_pcv10_3, sum(od_r13_f13 + od_r15_f13 + od_r17_f13) as m_cols_ipv, sum(od_r14_f13 + od_r16_f13 + od_r18_f13) as f_cols_ipv, sum(od_r13_f14 + od_r15_f14 + od_r17_f14) as m_cols_rota1, sum(od_r14_f14 + od_r16_f14 + od_r18_f14) as f_cols_rota1, sum(od_r13_f15 + od_r15_f15 + od_r17_f15) as m_cols_rota2, sum(od_r14_f15 + od_r16_f15 + od_r18_f15) as f_cols_rota2, sum(od_r13_f16 + od_r15_f16 + od_r17_f16) as m_cols_measles1, sum(od_r14_f16 + od_r16_f16 + od_r18_f16) as f_cols_measles1, sum(od_r13_f17 + od_r15_f17 + od_r17_f17) as m_cols_fully, sum(od_r14_f17 + od_r16_f17 + od_r18_f17) as f_cols_fully, sum(od_r13_f18 + od_r15_f18 + od_r17_f18) as m_cols_measles2, sum(od_r14_f18 + od_r16_f18 + od_r18_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}		//done
			if($vacc_to == 'total_children' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 +oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 +oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 +oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 +oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 +oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 +oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 +oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 +oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 +oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 +oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 +oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 +oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 +oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 +oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 +oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 +oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 +oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 +oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 +oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 +oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 +oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 +oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 +oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 +oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 +oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 +oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 +oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 +oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 +oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 +oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 +oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 +oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 +oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 +oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 +oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 +oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";				
			}
			if($vacc_to == 'gender' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r13_f1 + cri_r15_f1 + cri_r17_f1 + oui_r13_f1 + oui_r15_f1 + oui_r17_f1) as m_cols_bcg, sum(cri_r14_f1 + cri_r16_f1 + cri_r18_f1 + oui_r14_f1 + oui_r16_f1 + oui_r18_f1) as f_cols_bcg, sum(cri_r13_f2 + cri_r15_f2 + cri_r17_f2 + oui_r13_f2 + oui_r15_f2 + oui_r17_f2) as m_cols_hepb, sum(cri_r14_f2 + cri_r16_f2 + cri_r18_f2 + oui_r14_f2 + oui_r16_f2 + oui_r18_f2) as f_cols_hepb, sum(cri_r13_f3 + cri_r15_f3 + cri_r17_f3 + oui_r13_f3 + oui_r15_f3 + oui_r17_f3) as m_cols_opv0, sum(cri_r14_f3 + cri_r16_f3 + cri_r18_f3 + oui_r14_f3 + oui_r16_f3 + oui_r18_f3) as f_cols_opv0, sum(cri_r13_f4 + cri_r15_f4 + cri_r17_f4 + oui_r13_f4 + oui_r15_f4 + oui_r17_f4) as m_cols_opv1, sum(cri_r14_f4 + cri_r16_f4 + cri_r18_f4 + oui_r14_f4 + oui_r16_f4 + oui_r18_f4) as f_cols_opv1, sum(cri_r13_f5 + cri_r15_f5 + cri_r17_f5 + oui_r13_f5 + oui_r15_f5 + oui_r17_f5) as m_cols_opv2, sum(cri_r14_f5 + cri_r16_f5 + cri_r18_f5 + oui_r14_f5 + oui_r16_f5 + oui_r18_f5) as f_cols_opv2, sum(cri_r13_f6 + cri_r15_f6 + cri_r17_f6 + oui_r13_f6 + oui_r15_f6 + oui_r17_f6) as m_cols_opv3, sum(cri_r14_f6 + cri_r16_f6 + cri_r18_f6 + oui_r14_f6 + oui_r16_f6 + oui_r18_f6) as f_cols_opv3, sum(cri_r13_f7 + cri_r15_f7 + cri_r17_f7 + oui_r13_f7 + oui_r15_f7 + oui_r17_f7) as m_cols_pentv1, sum(cri_r14_f7 + cri_r16_f7 + cri_r18_f7 + oui_r14_f7 + oui_r16_f7 + oui_r18_f7) as f_cols_pentv1, sum(cri_r13_f8 + cri_r15_f8 + cri_r17_f8 + oui_r13_f8 + oui_r15_f8 + oui_r17_f8) as m_cols_pentv2, sum(cri_r14_f8 + cri_r16_f8 + cri_r18_f8 + oui_r14_f8 + oui_r16_f8 + oui_r18_f8) as f_cols_pentv2, sum(cri_r13_f9 + cri_r15_f9 + cri_r17_f9 + oui_r13_f9 + oui_r15_f9 + oui_r17_f9) as m_cols_pentv3, sum(cri_r14_f9 + cri_r16_f9 + cri_r18_f9 + oui_r14_f9 + oui_r16_f9 + oui_r18_f9) as f_cols_pentv3, sum(cri_r13_f10 + cri_r15_f10 + cri_r17_f10 + oui_r13_f10 + oui_r15_f10 + oui_r17_f10) as m_cols_pcv10_1, sum(cri_r14_f10 + cri_r16_f10 + cri_r18_f10 + oui_r14_f10 + oui_r16_f10 + oui_r18_f10) as f_cols_pcv10_1, sum(cri_r13_f11 + cri_r15_f11 + cri_r17_f11 + oui_r13_f11 + oui_r15_f11 + oui_r17_f11) as m_cols_pcv10_2, sum(cri_r14_f11 + cri_r16_f11 + cri_r18_f11 + oui_r14_f11 + oui_r16_f11 + oui_r18_f11) as f_cols_pcv10_2, sum(cri_r13_f12 + cri_r15_f12 + cri_r17_f12 + oui_r13_f12 + oui_r15_f12 + oui_r17_f12) as m_cols_pcv10_3, sum(cri_r14_f12 + cri_r16_f12 + cri_r18_f12 + oui_r14_f12 + oui_r16_f12 + oui_r18_f12) as f_cols_pcv10_3, sum(cri_r13_f13 + cri_r15_f13 + cri_r17_f13 + oui_r13_f13 + oui_r15_f13 + oui_r17_f13) as m_cols_ipv, sum(cri_r14_f13 + cri_r16_f13 + cri_r18_f13 + oui_r14_f13 + oui_r16_f13 + oui_r18_f13) as f_cols_ipv, sum(cri_r13_f14 + cri_r15_f14 + cri_r17_f14 + oui_r13_f14 + oui_r15_f14 + oui_r17_f14) as m_cols_rota1, sum(cri_r14_f14 + cri_r16_f14 + cri_r18_f14 + oui_r14_f14 + oui_r16_f14 + oui_r18_f14) as f_cols_rota1, sum(cri_r13_f15 + cri_r15_f15 + cri_r17_f15 + oui_r13_f15 + oui_r15_f15 + oui_r17_f15) as m_cols_rota2, sum(cri_r14_f15 + cri_r16_f15 + cri_r18_f15 + oui_r14_f15 + oui_r16_f15 + oui_r18_f15) as f_cols_rota2, sum(cri_r13_f16 + cri_r15_f16 + cri_r17_f16 + oui_r13_f16 + oui_r15_f16 + oui_r17_f16) as m_cols_measles1, sum(cri_r14_f16 + cri_r16_f16 + cri_r18_f16 + oui_r14_f16 + oui_r16_f16 + oui_r18_f16) as f_cols_measles1, sum(cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17) as m_cols_fully, sum(cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17) as f_cols_fully, sum(cri_r13_f18 + cri_r15_f18 + cri_r17_f18 + oui_r13_f18 + oui_r15_f18 + oui_r17_f18) as m_cols_measles2, sum(cri_r14_f18 + cri_r16_f18 + cri_r18_f18 + oui_r14_f18 + oui_r16_f18 + oui_r18_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 + ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 + ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 + ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 + ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 + ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 + ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 + ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 + ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 + ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 + ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r13_f1 + od_r15_f1 + od_r17_f1) as m_cols_bcg, sum(od_r14_f1 + od_r16_f1 + od_r18_f1) as f_cols_bcg, sum(od_r13_f2 + od_r15_f2 + od_r17_f2) as m_cols_hepb, sum(od_r14_f2 + od_r16_f2 + od_r18_f2) as f_cols_hepb, sum(od_r13_f3 + od_r15_f3 + od_r17_f3) as m_cols_opv0, sum(od_r14_f3 + od_r16_f3 + od_r18_f3) as f_cols_opv0, sum(od_r13_f4 + od_r15_f4 + od_r17_f4) as m_cols_opv1, sum(od_r14_f4 + od_r16_f4 + od_r18_f4) as f_cols_opv1, sum(od_r13_f5 + od_r15_f5 + od_r17_f5) as m_cols_opv2, sum(od_r14_f5 + od_r16_f5 + od_r18_f5) as f_cols_opv2, sum(od_r13_f6 + od_r15_f6 + od_r17_f6) as m_cols_opv3, sum(od_r14_f6 + od_r16_f6 + od_r18_f6) as f_cols_opv3, sum(od_r13_f7 + od_r15_f7 + od_r17_f7) as m_cols_pentv1, sum(od_r14_f7 + od_r16_f7 + od_r18_f7) as f_cols_pentv1, sum(od_r13_f8 + od_r15_f8 + od_r17_f8) as m_cols_pentv2, sum(od_r14_f8 + od_r16_f8 + od_r18_f8) as f_cols_pentv2, sum(od_r13_f9 + od_r15_f9 + od_r17_f9) as m_cols_pentv3, sum(od_r14_f9 + od_r16_f9 + od_r18_f9) as f_cols_pentv3, sum(od_r13_f10 + od_r15_f10 + od_r17_f10) as m_cols_pcv10_1, sum(od_r14_f10 + od_r16_f10 + od_r18_f10) as f_cols_pcv10_1, sum(od_r13_f11 + od_r15_f11 + od_r17_f11) as m_cols_pcv10_2, sum(od_r14_f11 + od_r16_f11 + od_r18_f11) as f_cols_pcv10_2, sum(od_r13_f12 + od_r15_f12 + od_r17_f12) as m_cols_pcv10_3, sum(od_r14_f12 + od_r16_f12 + od_r18_f12) as f_cols_pcv10_3, sum(od_r13_f13 + od_r15_f13 + od_r17_f13) as m_cols_ipv, sum(od_r14_f13 + od_r16_f13 + od_r18_f13) as f_cols_ipv, sum(od_r13_f14 + od_r15_f14 + od_r17_f14) as m_cols_rota1, sum(od_r14_f14 + od_r16_f14 + od_r18_f14) as f_cols_rota1, sum(od_r13_f15 + od_r15_f15 + od_r17_f15) as m_cols_rota2, sum(od_r14_f15 + od_r16_f15 + od_r18_f15) as f_cols_rota2, sum(od_r13_f16 + od_r15_f16 + od_r17_f16) as m_cols_measles1, sum(od_r14_f16 + od_r16_f16 + od_r18_f16) as f_cols_measles1, sum(od_r13_f17 + od_r15_f17 + od_r17_f17) as m_cols_fully, sum(od_r14_f17 + od_r16_f17 + od_r18_f17) as f_cols_fully, sum(od_r13_f18 + od_r15_f18 + od_r17_f18) as m_cols_measles2, sum(od_r14_f18 + od_r16_f18 + od_r18_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";				
			}
			if($vacc_to == 'gender' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 + oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 + oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 + oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 + oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 + oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 + oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 + oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 + oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 + oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 + oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 + oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 + oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 + oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 + oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 + oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 + oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 + oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 + oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 + oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 + oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 + oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 + oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 + oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 + oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 + oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 + oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 + oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 + oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 + oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 + oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 + oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 + oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 + oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 + oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 + oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 + oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";				
			}
		}
		if($vaccination_type == 'lhw'){
			if($age_wise == '0to11'){
				$a = "r19";
				$b = "r20";
			}
			if($age_wise == '12to23'){
				$a = "r21";
				$b = "r22";
			}
			if($age_wise == 'above2'){
				$a = "r23";
				$b = "r24";
			}
			$x = 7; $y = 8;
			if($vacc_to == 'total_children' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r19_f1 + cri_r21_f1 + cri_r23_f1 + oui_r19_f1 + oui_r21_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r20_f1 + cri_r22_f1 + cri_r24_f1 + oui_r20_f1 + oui_r22_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r19_f2 + cri_r21_f2 + cri_r23_f2 + oui_r19_f2 + oui_r21_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r20_f2 + cri_r22_f2 + cri_r24_f2 + oui_r20_f2 + oui_r22_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r19_f3 + cri_r21_f3 + cri_r23_f3 + oui_r19_f3 + oui_r21_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r20_f3 + cri_r22_f3 + cri_r24_f3 + oui_r20_f3 + oui_r22_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r19_f4 + cri_r21_f4 + cri_r23_f4 + oui_r19_f4 + oui_r21_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r20_f4 + cri_r22_f4 + cri_r24_f4 + oui_r20_f4 + oui_r22_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r19_f5 + cri_r21_f5 + cri_r23_f5 + oui_r19_f5 + oui_r21_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r20_f5 + cri_r22_f5 + cri_r24_f5 + oui_r20_f5 + oui_r22_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r19_f6 + cri_r21_f6 + cri_r23_f6 + oui_r19_f6 + oui_r21_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r20_f6 + cri_r22_f6 + cri_r24_f6 + oui_r20_f6 + oui_r22_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r19_f7 + cri_r21_f7 + cri_r23_f7 + oui_r19_f7 + oui_r21_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r20_f7 + cri_r22_f7 + cri_r24_f7 + oui_r20_f7 + oui_r22_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r19_f8 + cri_r21_f8 + cri_r23_f8 + oui_r19_f8 + oui_r21_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r20_f8 + cri_r22_f8 + cri_r24_f8 + oui_r20_f8 + oui_r22_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r19_f9 + cri_r21_f9 + cri_r23_f9 + oui_r19_f9 + oui_r21_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r20_f9 + cri_r22_f9 + cri_r24_f9 + oui_r20_f9 + oui_r22_f9 + oui_r24_f9) as f_cols_pentv3, sum(cri_r19_f10 + cri_r21_f10 + cri_r23_f10 + oui_r19_f10 + oui_r21_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r20_f10 + cri_r22_f10 + cri_r24_f10 + oui_r20_f10 + oui_r22_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r19_f11 + cri_r21_f11 + cri_r23_f11 + oui_r19_f11 + oui_r21_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r20_f11 + cri_r22_f11 + cri_r24_f11 + oui_r20_f11 + oui_r22_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r19_f12 + cri_r21_f12 + cri_r23_f12 + oui_r19_f12 + oui_r21_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r20_f12 + cri_r22_f12 + cri_r24_f12 + oui_r20_f12 + oui_r22_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r19_f13 + cri_r21_f13 + cri_r23_f13 + oui_r19_f13 + oui_r21_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r20_f13 + cri_r22_f13 + cri_r24_f13 + oui_r20_f13 + oui_r22_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r19_f14 + cri_r21_f14 + cri_r23_f14 + oui_r19_f14 + oui_r21_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r20_f14 + cri_r22_f14 + cri_r24_f14 + oui_r20_f14 + oui_r22_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r19_f15 + cri_r21_f15 + cri_r23_f15 + oui_r19_f15 + oui_r21_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r20_f15 + cri_r22_f15 + cri_r24_f15 + oui_r20_f15 + oui_r22_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r19_f16 + cri_r21_f16 + cri_r23_f16 + oui_r19_f16 + oui_r21_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r20_f16 + cri_r22_f16 + cri_r24_f16 + oui_r20_f16 + oui_r22_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r19_f18 + cri_r21_f18 + cri_r23_f18 + oui_r19_f18 + oui_r21_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r20_f18 + cri_r22_f18 + cri_r24_f18 + oui_r20_f18 + oui_r22_f18 + oui_r24_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 + ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 + ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 + ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 + ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 + ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 + ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 + ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 + ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 + ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 + ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r19_f1 + od_r21_f1 + od_r23_f1) as m_cols_bcg, sum(od_r20_f1 + od_r22_f1 + od_r24_f1) as f_cols_bcg, sum(od_r19_f2 + od_r21_f2 + od_r23_f2) as m_cols_hepb, sum(od_r20_f2 + od_r22_f2 + od_r24_f2) as f_cols_hepb, sum(od_r19_f3 + od_r21_f3 + od_r23_f3) as m_cols_opv0, sum(od_r20_f3 + od_r22_f3 + od_r24_f3) as f_cols_opv0, sum(od_r19_f4 + od_r21_f4 + od_r23_f4) as m_cols_opv1, sum(od_r20_f4 + od_r22_f4 + od_r24_f4) as f_cols_opv1, sum(od_r19_f5 + od_r21_f5 + od_r23_f5) as m_cols_opv2, sum(od_r20_f5 + od_r22_f5 + od_r24_f5) as f_cols_opv2, sum(od_r19_f6 + od_r21_f6 + od_r23_f6) as m_cols_opv3, sum(od_r20_f6 + od_r22_f6 + od_r24_f6) as f_cols_opv3, sum(od_r19_f7 + od_r21_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r20_f7 + od_r22_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r19_f8 + od_r21_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r20_f8 + od_r22_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r19_f9 + od_r21_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r20_f9 + od_r22_f9 + od_r24_f9) as f_cols_pentv3, sum(od_r19_f10 + od_r21_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r20_f10 + od_r22_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r19_f11 + od_r21_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r20_f11 + od_r22_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r19_f12 + od_r21_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r20_f12 + od_r22_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r19_f13 + od_r21_f13 + od_r23_f13) as m_cols_ipv, sum(od_r20_f13 + od_r22_f13 + od_r24_f13) as f_cols_ipv, sum(od_r19_f14 + od_r21_f14 + od_r23_f14) as m_cols_rota1, sum(od_r20_f14 + od_r22_f14 + od_r24_f14) as f_cols_rota1, sum(od_r19_f15 + od_r21_f15 + od_r23_f15) as m_cols_rota2, sum(od_r20_f15 + od_r22_f15 + od_r24_f15) as f_cols_rota2, sum(od_r19_f16 + od_r21_f16 + od_r23_f16) as m_cols_measles1, sum(od_r20_f16 + od_r22_f16 + od_r24_f16) as f_cols_measles1, sum(od_r19_f17 + od_r21_f17 + od_r23_f17) as m_cols_fully, sum(od_r20_f17 + od_r22_f17 + od_r24_f17) as f_cols_fully, sum(od_r19_f18 + od_r21_f18 + od_r23_f18) as m_cols_measles2, sum(od_r20_f18 + od_r22_f18 + od_r24_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}		
			if($vacc_to == 'total_children' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg + f_cols_bcg) as \"BCG  \", sum(m_cols_hepb + f_cols_hepb) as \"HEP B  \", sum(m_cols_opv0 + f_cols_opv0) as \"OPV 0  \", sum(m_cols_opv1 + f_cols_opv1) as \"OPV I  \", sum(m_cols_opv2 + f_cols_opv2) as \"OPV II  \", sum(m_cols_opv3 + f_cols_opv3) as \"OPV III  \", sum(m_cols_pentv1 + f_cols_pentv1) as \"Penta I  \", sum(m_cols_pentv2 + f_cols_pentv2) as \"Penta II  \", sum(m_cols_pentv3 + f_cols_pentv3) as \"Penta III  \", sum(m_cols_pcv10_1 + f_cols_pcv10_1) as \"PCV10 I  \", sum(m_cols_pcv10_2 + f_cols_pcv10_2) as \"PCV10 II  \", sum(m_cols_pcv10_3 + f_cols_pcv10_3) as \"PCV10 III  \", sum(m_cols_ipv + f_cols_ipv) as \"IPV  \", sum(m_cols_rota1 + f_cols_rota1) as \"Rota I  \", sum(m_cols_rota2 + f_cols_rota2) as \"Rota II  \", sum(m_cols_measles1 + f_cols_measles1) as \"Measles I  \", sum(m_cols_fully + f_cols_fully) as \"Fully Immunized  \", sum(m_cols_measles2 + f_cols_measles2) as \"Measles II  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 + oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 + oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 + oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 + oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 + oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 + oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 + oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 + oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 + oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 + oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 + oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 + oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 + oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 + oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 + oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 + oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 + oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 + oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 + oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 + oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 + oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 + oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 + oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 + oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 + oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 + oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 + oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 + oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 + oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 + oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 + oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 + oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 + oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 + oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 + oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 + oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}
			if($vacc_to == 'gender' && $age_wise == 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \", sum(in_tt1) as \"TT PL I  \", sum(in_tt2) as \"TT PL II  \", sum(in_tt3) as \"TT PL III  \", sum(in_tt4) as \"TT PL IV  \", sum(in_tt5) as \"TT PL V  \", sum(in_cba1) as \"CBA I  \", sum(in_cba2) as \"CBA II  \", sum(in_cba3) as \"CBA III  \", sum(in_cba4) as \"CBA IV  \", sum(in_cba5) as \"CBA V  \" 
				FROM 
				(select distcode, sum(cri_r19_f1 + cri_r21_f1 + cri_r23_f1 + oui_r19_f1 + oui_r21_f1 + oui_r23_f1) as m_cols_bcg, sum(cri_r20_f1 + cri_r22_f1 + cri_r24_f1 + oui_r20_f1 + oui_r22_f1 + oui_r24_f1) as f_cols_bcg, sum(cri_r19_f2 + cri_r21_f2 + cri_r23_f2 + oui_r19_f2 + oui_r21_f2 + oui_r23_f2) as m_cols_hepb, sum(cri_r20_f2 + cri_r22_f2 + cri_r24_f2 + oui_r20_f2 + oui_r22_f2 + oui_r24_f2) as f_cols_hepb, sum(cri_r19_f3 + cri_r21_f3 + cri_r23_f3 + oui_r19_f3 + oui_r21_f3 + oui_r23_f3) as m_cols_opv0, sum(cri_r20_f3 + cri_r22_f3 + cri_r24_f3 + oui_r20_f3 + oui_r22_f3 + oui_r24_f3) as f_cols_opv0, sum(cri_r19_f4 + cri_r21_f4 + cri_r23_f4 + oui_r19_f4 + oui_r21_f4 + oui_r23_f4) as m_cols_opv1, sum(cri_r20_f4 + cri_r22_f4 + cri_r24_f4 + oui_r20_f4 + oui_r22_f4 + oui_r24_f4) as f_cols_opv1, sum(cri_r19_f5 + cri_r21_f5 + cri_r23_f5 + oui_r19_f5 + oui_r21_f5 + oui_r23_f5) as m_cols_opv2, sum(cri_r20_f5 + cri_r22_f5 + cri_r24_f5 + oui_r20_f5 + oui_r22_f5 + oui_r24_f5) as f_cols_opv2, sum(cri_r19_f6 + cri_r21_f6 + cri_r23_f6 + oui_r19_f6 + oui_r21_f6 + oui_r23_f6) as m_cols_opv3, sum(cri_r20_f6 + cri_r22_f6 + cri_r24_f6 + oui_r20_f6 + oui_r22_f6 + oui_r24_f6) as f_cols_opv3, sum(cri_r19_f7 + cri_r21_f7 + cri_r23_f7 + oui_r19_f7 + oui_r21_f7 + oui_r23_f7) as m_cols_pentv1, sum(cri_r20_f7 + cri_r22_f7 + cri_r24_f7 + oui_r20_f7 + oui_r22_f7 + oui_r24_f7) as f_cols_pentv1, sum(cri_r19_f8 + cri_r21_f8 + cri_r23_f8 + oui_r19_f8 + oui_r21_f8 + oui_r23_f8) as m_cols_pentv2, sum(cri_r20_f8 + cri_r22_f8 + cri_r24_f8 + oui_r20_f8 + oui_r22_f8 + oui_r24_f8) as f_cols_pentv2, sum(cri_r19_f9 + cri_r21_f9 + cri_r23_f9 + oui_r19_f9 + oui_r21_f9 + oui_r23_f9) as m_cols_pentv3, sum(cri_r20_f9 + cri_r22_f9 + cri_r24_f9 + oui_r20_f9 + oui_r22_f9 + oui_r24_f9) as f_cols_pentv3, sum(cri_r19_f10 + cri_r21_f10 + cri_r23_f10 + oui_r19_f10 + oui_r21_f10 + oui_r23_f10) as m_cols_pcv10_1, sum(cri_r20_f10 + cri_r22_f10 + cri_r24_f10 + oui_r20_f10 + oui_r22_f10 + oui_r24_f10) as f_cols_pcv10_1, sum(cri_r19_f11 + cri_r21_f11 + cri_r23_f11 + oui_r19_f11 + oui_r21_f11 + oui_r23_f11) as m_cols_pcv10_2, sum(cri_r20_f11 + cri_r22_f11 + cri_r24_f11 + oui_r20_f11 + oui_r22_f11 + oui_r24_f11) as f_cols_pcv10_2, sum(cri_r19_f12 + cri_r21_f12 + cri_r23_f12 + oui_r19_f12 + oui_r21_f12 + oui_r23_f12) as m_cols_pcv10_3, sum(cri_r20_f12 + cri_r22_f12 + cri_r24_f12 + oui_r20_f12 + oui_r22_f12 + oui_r24_f12) as f_cols_pcv10_3, sum(cri_r19_f13 + cri_r21_f13 + cri_r23_f13 + oui_r19_f13 + oui_r21_f13 + oui_r23_f13) as m_cols_ipv, sum(cri_r20_f13 + cri_r22_f13 + cri_r24_f13 + oui_r20_f13 + oui_r22_f13 + oui_r24_f13) as f_cols_ipv, sum(cri_r19_f14 + cri_r21_f14 + cri_r23_f14 + oui_r19_f14 + oui_r21_f14 + oui_r23_f14) as m_cols_rota1, sum(cri_r20_f14 + cri_r22_f14 + cri_r24_f14 + oui_r20_f14 + oui_r22_f14 + oui_r24_f14) as f_cols_rota1, sum(cri_r19_f15 + cri_r21_f15 + cri_r23_f15 + oui_r19_f15 + oui_r21_f15 + oui_r23_f15) as m_cols_rota2, sum(cri_r20_f15 + cri_r22_f15 + cri_r24_f15 + oui_r20_f15 + oui_r22_f15 + oui_r24_f15) as f_cols_rota2, sum(cri_r19_f16 + cri_r21_f16 + cri_r23_f16 + oui_r19_f16 + oui_r21_f16 + oui_r23_f16) as m_cols_measles1, sum(cri_r20_f16 + cri_r22_f16 + cri_r24_f16 + oui_r20_f16 + oui_r22_f16 + oui_r24_f16) as f_cols_measles1, sum(cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17) as m_cols_fully, sum(cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17) as f_cols_fully, sum(cri_r19_f18 + cri_r21_f18 + cri_r23_f18 + oui_r19_f18 + oui_r21_f18 + oui_r23_f18) as m_cols_measles2, sum(cri_r20_f18 + cri_r22_f18 + cri_r24_f18 + oui_r20_f18 + oui_r22_f18 + oui_r24_f18) as f_cols_measles2, sum(ttri_r{$x}_f1 + ttoui_r{$x}_f1) as in_tt1, sum(ttri_r{$x}_f2 + ttoui_r{$x}_f2) as in_tt2, sum(ttri_r{$x}_f3 + ttoui_r{$x}_f3) as in_tt3, sum(ttri_r{$x}_f4 + ttoui_r{$x}_f4) as in_tt4, sum(ttri_r{$x}_f5 + ttoui_r{$x}_f5) as in_tt5, sum(ttri_r{$y}_f1 + ttoui_r{$y}_f1) as in_cba1, sum(ttri_r{$y}_f2 + ttoui_r{$y}_f2) as in_cba2, sum(ttri_r{$y}_f3 + ttoui_r{$y}_f3) as in_cba3, sum(ttri_r{$y}_f4 + ttoui_r{$y}_f4) as in_cba4, sum(ttri_r{$y}_f5 + ttoui_r{$y}_f5) as in_cba5 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_r19_f1 + od_r21_f1 + od_r23_f1) as m_cols_bcg, sum(od_r20_f1 + od_r22_f1 + od_r24_f1) as f_cols_bcg, sum(od_r19_f2 + od_r21_f2 + od_r23_f2) as m_cols_hepb, sum(od_r20_f2 + od_r22_f2 + od_r24_f2) as f_cols_hepb, sum(od_r19_f3 + od_r21_f3 + od_r23_f3) as m_cols_opv0, sum(od_r20_f3 + od_r22_f3 + od_r24_f3) as f_cols_opv0, sum(od_r19_f4 + od_r21_f4 + od_r23_f4) as m_cols_opv1, sum(od_r20_f4 + od_r22_f4 + od_r24_f4) as f_cols_opv1, sum(od_r19_f5 + od_r21_f5 + od_r23_f5) as m_cols_opv2, sum(od_r20_f5 + od_r22_f5 + od_r24_f5) as f_cols_opv2, sum(od_r19_f6 + od_r21_f6 + od_r23_f6) as m_cols_opv3, sum(od_r20_f6 + od_r22_f6 + od_r24_f6) as f_cols_opv3, sum(od_r19_f7 + od_r21_f7 + od_r23_f7) as m_cols_pentv1, sum(od_r20_f7 + od_r22_f7 + od_r24_f7) as f_cols_pentv1, sum(od_r19_f8 + od_r21_f8 + od_r23_f8) as m_cols_pentv2, sum(od_r20_f8 + od_r22_f8 + od_r24_f8) as f_cols_pentv2, sum(od_r19_f9 + od_r21_f9 + od_r23_f9) as m_cols_pentv3, sum(od_r20_f9 + od_r22_f9 + od_r24_f9) as f_cols_pentv3, sum(od_r19_f10 + od_r21_f10 + od_r23_f10) as m_cols_pcv10_1, sum(od_r20_f10 + od_r22_f10 + od_r24_f10) as f_cols_pcv10_1, sum(od_r19_f11 + od_r21_f11 + od_r23_f11) as m_cols_pcv10_2, sum(od_r20_f11 + od_r22_f11 + od_r24_f11) as f_cols_pcv10_2, sum(od_r19_f12 + od_r21_f12 + od_r23_f12) as m_cols_pcv10_3, sum(od_r20_f12 + od_r22_f12 + od_r24_f12) as f_cols_pcv10_3, sum(od_r19_f13 + od_r21_f13 + od_r23_f13) as m_cols_ipv, sum(od_r20_f13 + od_r22_f13 + od_r24_f13) as f_cols_ipv, sum(od_r19_f14 + od_r21_f14 + od_r23_f14) as m_cols_rota1, sum(od_r20_f14 + od_r22_f14 + od_r24_f14) as f_cols_rota1, sum(od_r19_f15 + od_r21_f15 + od_r23_f15) as m_cols_rota2, sum(od_r20_f15 + od_r22_f15 + od_r24_f15) as f_cols_rota2, sum(od_r19_f16 + od_r21_f16 + od_r23_f16) as m_cols_measles1, sum(od_r20_f16 + od_r22_f16 + od_r24_f16) as f_cols_measles1, sum(od_r19_f17 + od_r21_f17 + od_r23_f17) as m_cols_fully, sum(od_r20_f17 + od_r22_f17 + od_r24_f17) as f_cols_fully, sum(od_r19_f18 + od_r21_f18 + od_r23_f18) as m_cols_measles2, sum(od_r20_f18 + od_r22_f18 + od_r24_f18) as f_cols_measles2, sum(ttod_r{$x}_f1) as in_tt1, sum(ttod_r{$x}_f2) as in_tt2, sum(ttod_r{$x}_f3) as in_tt3, sum(ttod_r{$x}_f4) as in_tt4, sum(ttod_r{$x}_f5) as in_tt5, sum(ttod_r{$y}_f1) as in_cba1, sum(ttod_r{$y}_f2) as in_cba2, sum(ttod_r{$y}_f3) as in_cba3, sum(ttod_r{$y}_f4) as in_cba4, sum(ttod_r{$y}_f5) as in_cba5 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}
			if($vacc_to == 'gender' && $age_wise != 'all'){
				$query = "SELECT distcode, districtname(distcode) as district, sum(m_cols_bcg) as \"BCG M  \",sum(f_cols_bcg) as \"BCG F  \", sum(m_cols_hepb) as \"HEP B M  \", sum(f_cols_hepb) as \"HEP B F  \", sum(m_cols_opv0) \"OPV 0 M  \", sum(f_cols_opv0) as \"OPV 0 F  \", sum(m_cols_opv1) as \"OPV I M  \", sum(f_cols_opv1) as \"OPV I F  \", sum(m_cols_opv2) as \"OPV II M  \", sum(f_cols_opv2) as \"OPV II F  \", sum(m_cols_opv3) as \"OPV III M  \", sum(f_cols_opv3) as \"OPV III F  \", sum(m_cols_pentv1) as \"Penta I M  \", sum(f_cols_pentv1) as \"Penta I F  \", sum(m_cols_pentv2) as \"Penta II M  \", sum(f_cols_pentv2) as \"Penta II F  \", sum(m_cols_pentv3) as \"Penta III M  \", sum(f_cols_pentv3) as \"Penta III F  \", sum(m_cols_pcv10_1) as \"PCV10 I M  \", sum(f_cols_pcv10_1) as \"PCV10 I F  \", sum(m_cols_pcv10_2) as \"PCV10 II M  \", sum(f_cols_pcv10_2) as \"PCV10 II F  \", sum(m_cols_pcv10_3) as \"PCV10 III M  \", sum(f_cols_pcv10_3) as \"PCV10 III F  \", sum(m_cols_ipv) as \"IPV M  \", sum(f_cols_ipv) as \"IPV F  \", sum(m_cols_rota1) as \"Rota I M  \", sum(f_cols_rota1) as \"Rota I F  \", sum(m_cols_rota2) as \"Rota II M  \", sum(f_cols_rota2) as \"Rota II F  \", sum(m_cols_measles1) as \"Measles I M  \", sum(f_cols_measles1) as \"Measles I F  \", sum(m_cols_fully) as \"Fully Immunized M  \", sum(f_cols_fully) as \"Fully Immunized F  \", sum(m_cols_measles2) as \"Measles II M  \", sum(f_cols_measles2) as \"Measles II F  \" 
					FROM 
				(select distcode, sum(cri_{$a}_f1 + oui_{$a}_f1) as m_cols_bcg, sum(cri_{$b}_f1 + oui_{$b}_f1) as f_cols_bcg, sum(cri_{$a}_f2 + oui_{$a}_f2) as m_cols_hepb, sum(cri_{$b}_f2 + oui_{$b}_f2) as f_cols_hepb, sum(cri_{$a}_f3 + oui_{$a}_f3) as m_cols_opv0, sum(cri_{$b}_f3 + oui_{$b}_f3) as f_cols_opv0, sum(cri_{$a}_f4 + oui_{$a}_f4) as m_cols_opv1, sum(cri_{$b}_f4 + oui_{$b}_f4) as f_cols_opv1, sum(cri_{$a}_f5 + oui_{$a}_f5) as m_cols_opv2, sum(cri_{$b}_f5 + oui_{$b}_f5) as f_cols_opv2, sum(cri_{$a}_f6 + oui_{$a}_f6) as m_cols_opv3, sum(cri_{$b}_f6 + oui_{$b}_f6) as f_cols_opv3, sum(cri_{$a}_f7 + oui_{$a}_f7) as m_cols_pentv1, sum(cri_{$b}_f7 + oui_{$b}_f7) as f_cols_pentv1, sum(cri_{$a}_f8 + oui_{$a}_f8) as m_cols_pentv2, sum(cri_{$b}_f8 + oui_{$b}_f8) as f_cols_pentv2, sum(cri_{$a}_f9 + oui_{$a}_f9) as m_cols_pentv3, sum(cri_{$b}_f9 + oui_{$b}_f9) as f_cols_pentv3, sum(cri_{$a}_f10 + oui_{$a}_f10) as m_cols_pcv10_1, sum(cri_{$b}_f10 + oui_{$b}_f10) as f_cols_pcv10_1, sum(cri_{$a}_f11 + oui_{$a}_f11) as m_cols_pcv10_2, sum(cri_{$b}_f11 + oui_{$b}_f11) as f_cols_pcv10_2, sum(cri_{$a}_f12 + oui_{$a}_f12) as m_cols_pcv10_3, sum(cri_{$b}_f12 + oui_{$b}_f12) as f_cols_pcv10_3, sum(cri_{$a}_f13 + oui_{$a}_f13) as m_cols_ipv, sum(cri_{$b}_f13 + oui_{$b}_f13) as f_cols_ipv, sum(cri_{$a}_f14 + oui_{$a}_f14) as m_cols_rota1, sum(cri_{$b}_f14 + oui_{$b}_f14) as f_cols_rota1, sum(cri_{$a}_f15 + oui_{$a}_f15) as m_cols_rota2, sum(cri_{$b}_f15 + oui_{$b}_f15) as f_cols_rota2, sum(cri_{$a}_f16 + oui_{$a}_f16) as m_cols_measles1, sum(cri_{$b}_f16 + oui_{$b}_f16) as f_cols_measles1, sum(cri_{$a}_f17 + oui_{$a}_f17) as m_cols_fully, sum(cri_{$b}_f17 + oui_{$b}_f17) as f_cols_fully, sum(cri_{$a}_f18 + oui_{$a}_f18) as m_cols_measles2, sum(cri_{$b}_f18 + oui_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_db WHERE {$whereFmonth} GROUP BY distcode UNION ALL 
				select distcode, sum(od_{$a}_f1) as m_cols_bcg, sum(od_{$b}_f1) as f_cols_bcg, sum(od_{$a}_f2) as m_cols_hepb, sum(od_{$b}_f2) as f_cols_hepb, sum(od_{$a}_f3) as m_cols_opv0, sum(od_{$b}_f3) as f_cols_opv0, sum(od_{$a}_f4) as m_cols_opv1, sum(od_{$b}_f4) as f_cols_opv1, sum(od_{$a}_f5) as m_cols_opv2, sum(od_{$b}_f5) as f_cols_opv2, sum(od_{$a}_f6) as m_cols_opv3, sum(od_{$b}_f6) as f_cols_opv3, sum(od_{$a}_f7) as m_cols_pentv1, sum(od_{$b}_f7) as f_cols_pentv1, sum(od_{$a}_f8) as m_cols_pentv2, sum(od_{$b}_f8) as f_cols_pentv2, sum(od_{$a}_f9) as m_cols_pentv3, sum(od_{$b}_f9) as f_cols_pentv3, sum(od_{$a}_f10) as m_cols_pcv10_1, sum(od_{$b}_f10) as f_cols_pcv10_1, sum(od_{$a}_f11) as m_cols_pcv10_2, sum(od_{$b}_f11) as f_cols_pcv10_2, sum(od_{$a}_f12) as m_cols_pcv10_3, sum(od_{$b}_f12) as f_cols_pcv10_3, sum(od_{$a}_f13) as m_cols_ipv, sum(od_{$b}_f13) as f_cols_ipv, sum(od_{$a}_f14) as m_cols_rota1, sum(od_{$b}_f14) as f_cols_rota1, sum(od_{$a}_f15) as m_cols_rota2, sum(od_{$b}_f15) as f_cols_rota2, sum(od_{$a}_f16) as m_cols_measles1, sum(od_{$b}_f16) as f_cols_measles1, sum(od_{$a}_f17) as m_cols_fully, sum(od_{$b}_f17) as f_cols_fully, sum(od_{$a}_f18) as m_cols_measles2, sum(od_{$b}_f18) as f_cols_measles2 FROM fac_mvrf_od_db WHERE {$whereFmonth} GROUP BY distcode) k GROUP BY distcode ORDER BY district";
			}
		}
		//print_r($query);exit();		
		$result = $this -> db -> query($query) -> result_array();
		//print_r($result);exit();
		$result['TopInfo'] = reportsTopInfo($pageTitle, $data);
		$result['exportIcons'] = exportIcons($_REQUEST);
		return $result;
	}
	//======= (Male Female wise)FLCF Wise Vaccination for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination_malefemale_coverage($code=NULL,$year=NULL,$data=NULL)
	{
		//print_r($_POST);exit();
		//echo $data['monthfrom'];exit();
		$start_year = substr($data['monthfrom'],0,4);
		$start_month = substr($data['monthfrom'],5,2);
		$end_year = substr($data['monthto'],0,4);
		$end_month = substr($data['monthto'],5,2);
		// echo $start_year;echo '-'; //echo $start_month; echo ',,,,,';
		// echo $end_year; //echo '-'; echo $end_month; 
		// exit();
		$in_out_coverage = $this-> input-> get_post('in_out_coverage');
		if(!isset($data["distcode"])){
			$data["distcode"] = $this-> input-> get("distcode");
		}
		$data['procode'] = $_SESSION["Province"];
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$distcode=$data['distcode'];
		$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		$criNames   = array(
			"BCG","HEP","OPV_O",
			"OPV_ON","OPV_TW","OPV_TH",
			"PEN_O","PEN_TW","PEN_TH",
			"PC_O","PC_TW","PC_TH",
			"IP_O","ROTA_ON","ROTA_TW",
			"MEA_O","FULLY_IMMUNIZED","MEA_TW"
		);
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		if($data['distcode'] > 0)
		{
			//echo "District";exit();
			if($data['typeWise']=='uc')
			{
				if($data["monthfrom"] && $data['monthto'])
				{
					$subTitle = 'Union Council-wise Monthly Vaccination of Children and Women(with Percentage)';
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
					$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
					$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
					$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
					$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.uncode::text,'unioncouncil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
					$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.uncode::text,'unioncouncil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
					$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.uncode::text,'unioncouncil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
					$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
					$newbornMale = "COALESCE( NULLIF(round(round((getmonthlytarget_specificyearr(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,0)),0) , 0 )";
					$newbornFemale = "COALESCE( NULLIF(round(round((getmonthlytarget_specificyearr(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,0)),0) , 0 )";
					$targetMaleChildren = "COALESCE( NULLIF(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.uncode::text,'unioncouncil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,0) , 0 )";
					$targetFeMaleChildren = "COALESCE( NULLIF(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.uncode::text,'unioncouncil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,0) , 0 )";
					$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(flcf1.uncode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , 0 )";
				}
			}
			else if($data['typeWise']=='tehsil')
			{
				if($data["monthfrom"] && $data['monthto'])
				{
					$subTitle = 'Tehsil-wise Monthly Vaccination of Children and Women(with Percentage)';
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
					$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
					$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
					$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
					$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
					$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
					$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
					$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
					$newbornMale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,2),0) , 0 )";
					$newbornFemale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,2),0) , 0 )";
					$targetMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,2),0) , 0 )";
					$targetFeMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,2),0) , 0 )";
					$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(facode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , 0 )";
				}
			}
			else
			{		
				if($data["monthfrom"] && $data['monthto'])
				{
					$vacc_to = $this->input->get_post('vacc_to');
					if($vacc_to == 'gender'){
						$subTitle = 'Facility-wise Monthly Vaccination of Children and Women(with Percentage)';
						$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
						$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
						$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
						$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
						$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
						$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
						$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
						$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
						$newbornMale = "COALESCE( NULLIF((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,0) , 0 )";
						$newbornFemale = "COALESCE( NULLIF((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,0) , 0 )";
						$targetMaleChildren = "COALESCE( NULLIF(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,0) , 0 )";
						$targetFeMaleChildren = "COALESCE( NULLIF(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,0) , 0 )";
						$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , 0 )";
					}	
					else{
						$subTitle = 'Facility-wise Monthly Vaccination of Children and Women(with Percentage)';
						$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
						$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
						$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
						$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
						$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
						$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
						$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
						$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
						$newbornMale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,2),0) , 0 )";
						$newbornFemale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,2),0) , 0 )";
						$targetMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,2),0) , 0 )";
						$targetFeMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.facode::text,'facility'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,2),0) , 0 )";
						$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(flcf1.facode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , 0 )";
					}					
				}
			}
		}
		else
		{
			if($data["monthfrom"] && $data['monthto'])
			{
				$subTitle = 'District-wise Monthly Vaccination of Children and Women(with Percentage)';
				if($in_out_coverage == 'total_districts'){
					//echo "klm";exit();
					$fmonthCondition = " a.fmonth >= '".$data['monthfrom']."' and a.fmonth <= '".$data['monthto']."'";
					//$fmonthCondition = " a.fmonth BETWEEN '".$data['monthfrom']."' AND '".$data['monthto']."'";
					$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
					$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
					$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
					$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(dist.distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
					$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(dist.distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
					$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(dist.distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
					$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
					$newbornMale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,2),0) , '1' )";
					$newbornFemale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,2),0) , '1' )";
					$targetMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(dist.distcode::text,'dist.district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,2),0) , '1' )";
					$targetFeMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(dist.distcode::text,'dist.district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,2),0) , '1' )";
					$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(dist.distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , '1' )";
				}
				else{
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
					$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100) as \"New Borns Male\",";
					$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100) as \"New Borns FeMale\",";
					$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*100)/100) as \"Total New Borns\",";
					$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
					$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
					$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
					$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric)) as \"Targeted_Women\",";
					$newbornMale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*51)/100,2),0) , '1' )";
					$newbornFemale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric*49)/100,2),0) , '1' )";
					$targetMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,2),0) , '1' )";
					$targetFeMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,2),0) , '1' )";
					$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(distcode::text,$start_year,$start_month,$end_year,$end_month)::numeric),2),0) , '1' )";
				}
			}
		}
		$vacc_to = $this-> input-> get_post('vacc_to');
		$age_wise = $this-> input-> get_post('age_wise');
		//$in_out_coverage = $this->input->get_post('in_out_coverage');
		//echo $in_out_coverage;exit();		
		if($vacc_to == 'total_children')
		{	
			$tmp = "$tmp_new_borns_total $tmp_target_total_child $tmp_target_woman";
		}
		elseif($vacc_to == 'gender')
		{
			$tmp = "$tmp_new_borns_male $tmp_new_borns_female $tmp_target_male_child $tmp_target_female_child $tmp_target_woman";
		}
		//print_r($tmp);exit();

		if($data['distcode'] > 0)
		{
			//case when district selected or deo logged in
			if($data['typeWise']=='uc')
			{
				if($in_out_coverage == 'in_uc'){
					$queryForYearlyData="SELECT flcf1.uncode, unname(flcf1.uncode), $tmp ";					
				}
				else{
					$queryForYearlyData="SELECT flcf1.uncode, unname(flcf1.uncode), ";
				}
				/* if($age_wise == '0to11')
				{
					array_pop($criNames);
				} */
				for($i=1;$i<=sizeof($criNames);$i++)
				{
					$asValueCRI=$criNames[$i-1];
					switch ($age_wise) 
					{
						case 'all':
							if($in_out_coverage == 'in_uc'){
								//echo "a";exit();
								$m_cols = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								//echo "b";exit();
								$m_cols = "sum(oui_r1_f".$i.")+sum(oui_r3_f".$i.")+sum(oui_r5_f".$i.")+sum(oui_r7_f".$i.")+sum(oui_r9_f".$i.")+sum(oui_r11_f".$i.")+sum(oui_r13_f".$i.")+sum(oui_r15_f".$i.")+sum(oui_r17_f".$i.")+sum(oui_r19_f".$i.")+sum(oui_r21_f".$i.")+sum(oui_r23_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i.")+sum(oui_r4_f".$i.")+sum(oui_r6_f".$i.")+sum(oui_r8_f".$i.")+sum(oui_r10_f".$i.")+sum(oui_r12_f".$i.")+sum(oui_r14_f".$i.")+sum(oui_r16_f".$i.")+sum(oui_r18_f".$i.")+sum(oui_r20_f".$i.")+sum(oui_r22_f".$i.")+sum(oui_r24_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								//echo "c";exit();
								$m_cols_in = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i.")+sum(oui_r3_f".$i.")+sum(oui_r5_f".$i.")+sum(oui_r7_f".$i.")+sum(oui_r9_f".$i.")+sum(oui_r11_f".$i.")+sum(oui_r13_f".$i.")+sum(oui_r15_f".$i.")+sum(oui_r17_f".$i.")+sum(oui_r19_f".$i.")+sum(oui_r21_f".$i.")+sum(oui_r23_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i.")+sum(oui_r4_f".$i.")+sum(oui_r6_f".$i.")+sum(oui_r8_f".$i.")+sum(oui_r10_f".$i.")+sum(oui_r12_f".$i.")+sum(oui_r14_f".$i.")+sum(oui_r16_f".$i.")+sum(oui_r18_f".$i.")+sum(oui_r20_f".$i.")+sum(oui_r22_f".$i.")+sum(oui_r24_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = TRUE;
							break;
						case '0to11':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case '12to23':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$f_cols = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$f_cols = "sum(oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$m_cols_out = "sum(oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
								$f_cols_out = "sum(oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case 'under2':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i." + oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i." + oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i." + oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i." + oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case 'above2':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
								$f_cols = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r5_f".$i." + oui_r11_f".$i." + oui_r17_f".$i." + oui_r23_f".$i.")";
								$f_cols = "sum(oui_r6_f".$i." + oui_r12_f".$i." + oui_r18_f".$i." + oui_r24_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
								$m_cols_out = "sum(oui_r5_f".$i." + oui_r11_f".$i." + oui_r17_f".$i." + oui_r23_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
								$f_cols_out = "sum(oui_r6_f".$i." + oui_r12_f".$i." + oui_r18_f".$i." + oui_r24_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						default:
							# code...
							break;
					}
					if($i >=1 && $i <= 3)
					{
						if($in_out_coverage == 'in_uc'){
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition  group by fac_mvrf_db.uncode ) as M$asValueCRI,
								(select CASE WHEN $newbornMale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as F$asValueCRI,
								(select CASE WHEN $newbornFemale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornFemale,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as percF$asValueCRI,
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition  group by fac_mvrf_db.uncode ) as T$asValueCRI,
								(select CASE WHEN $newbornMale > 0 OR $newbornFemale > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as percT$asValueCRI,
								";
							}
							
						}
						else{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition  group by fac_mvrf_db.uncode ) as M$asValueCRI,								
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as F$asValueCRI,								
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition  group by fac_mvrf_db.uncode ) as T$asValueCRI,
								";
							}
						}						
					}
					else
					{
						if($in_out_coverage == 'in_uc'){
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as M$asValueCRI,
								(select CASE WHEN $targetMaleChildren = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as F$asValueCRI,
								(select CASE WHEN $targetFeMaleChildren = 0 THEN 0 ELSE round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as percF$asValueCRI,";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as T$asValueCRI,
								(select CASE WHEN $targetMaleChildren > 0 OR $targetFeMaleChildren > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as percT$asValueCRI,";
							}							
						}
						else
						{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as M$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as F$asValueCRI,";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode) as T$asValueCRI,";
							}
						}
					}
				}
				if($show_pl_cba)
				{
					if($in_out_coverage == 'in_uc'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{							
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PWperc$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'out_uc'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{							
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PW$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PW$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j.")+sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
				}
				$queryForYearlyData = rtrim($queryForYearlyData,",");
				$queryForYearlyData .= " from unioncouncil flcf1 join fac_mvrf_db fac on flcf1.uncode=fac.uncode where flcf1.distcode ='$distcode' group by flcf1.uncode,un_name order by un_name";
			}
			else
			{
				if($in_out_coverage == 'in_uc'){
					$queryForYearlyData="SELECT flcf1.facode, facilityname(flcf1.facode), $tmp ";				
				}
				else{
					$queryForYearlyData="SELECT flcf1.facode, facilityname(flcf1.facode), ";
				}
				/* if($age_wise == '0to11')
				{
					array_pop($criNames);
				} */
				for($i=1;$i<=sizeof($criNames);$i++)
				{
					$asValueCRI=$criNames[$i-1];
					switch ($age_wise) 
					{
						case 'all':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r1_f".$i.")+sum(oui_r3_f".$i.")+sum(oui_r5_f".$i.")+sum(oui_r7_f".$i.")+sum(oui_r9_f".$i.")+sum(oui_r11_f".$i.")+sum(oui_r13_f".$i.")+sum(oui_r15_f".$i.")+sum(oui_r17_f".$i.")+sum(oui_r19_f".$i.")+sum(oui_r21_f".$i.")+sum(oui_r23_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i.")+sum(oui_r4_f".$i.")+sum(oui_r6_f".$i.")+sum(oui_r8_f".$i.")+sum(oui_r10_f".$i.")+sum(oui_r12_f".$i.")+sum(oui_r14_f".$i.")+sum(oui_r16_f".$i.")+sum(oui_r18_f".$i.")+sum(oui_r20_f".$i.")+sum(oui_r22_f".$i.")+sum(oui_r24_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i.")+sum(oui_r3_f".$i.")+sum(oui_r5_f".$i.")+sum(oui_r7_f".$i.")+sum(oui_r9_f".$i.")+sum(oui_r11_f".$i.")+sum(oui_r13_f".$i.")+sum(oui_r15_f".$i.")+sum(oui_r17_f".$i.")+sum(oui_r19_f".$i.")+sum(oui_r21_f".$i.")+sum(oui_r23_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i.")+sum(oui_r4_f".$i.")+sum(oui_r6_f".$i.")+sum(oui_r8_f".$i.")+sum(oui_r10_f".$i.")+sum(oui_r12_f".$i.")+sum(oui_r14_f".$i.")+sum(oui_r16_f".$i.")+sum(oui_r18_f".$i.")+sum(oui_r20_f".$i.")+sum(oui_r22_f".$i.")+sum(oui_r24_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = TRUE;
							break;
						case '0to11':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";								
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case '12to23':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$f_cols = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$f_cols = "sum(oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$m_cols_out = "sum(oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
								$f_cols_out = "sum(oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case 'under2':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i." + oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$f_cols = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i." + oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
								$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i." + oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
								$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i." + oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						case 'above2':
							if($in_out_coverage == 'in_uc'){
								$m_cols = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
								$f_cols = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
							}
							if($in_out_coverage == 'out_uc'){
								$m_cols = "sum(oui_r5_f".$i." + oui_r11_f".$i." + oui_r17_f".$i." + oui_r23_f".$i.")";
								$f_cols = "sum(oui_r6_f".$i." + oui_r12_f".$i." + oui_r18_f".$i." + oui_r24_f".$i.")";
							}
							if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
								$m_cols_in = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
								$m_cols_out = "sum(oui_r5_f".$i." + oui_r11_f".$i." + oui_r17_f".$i." + oui_r23_f".$i.")";
								$m_cols = "$m_cols_in + $m_cols_out";

								$f_cols_in = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
								$f_cols_out = "sum(oui_r6_f".$i." + oui_r12_f".$i." + oui_r18_f".$i." + oui_r24_f".$i.")";
								$f_cols = "$f_cols_in + $f_cols_out";
							}
							$t_cols = "$m_cols + $f_cols";
							$show_pl_cba = FALSE;
							break;
						default:
							# code...
							break;
					}
					if($i >=1 && $i <= 3)
					{
						if($in_out_coverage == 'in_uc'){
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition  group by fac_mvrf_db.facode ) as M$asValueCRI,
								(select CASE WHEN $newbornMale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as F$asValueCRI,
								(select CASE WHEN $newbornFemale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornFemale,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percF$asValueCRI,
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition  group by fac_mvrf_db.facode ) as T$asValueCRI,
								(select CASE WHEN $newbornMale > 0 OR $newbornFemale > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as percT$asValueCRI,
								";
							}							
						}
						else{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition  group by fac_mvrf_db.facode ) as M$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as F$asValueCRI,
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition  group by fac_mvrf_db.facode ) as T$asValueCRI,
								";
							}
						}
					}
					else
					{
						if($in_out_coverage == 'in_uc'){
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as M$asValueCRI,
								(select CASE WHEN $targetMaleChildren = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as F$asValueCRI,
								(select CASE WHEN $targetFeMaleChildren = 0 THEN 0 ELSE round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percF$asValueCRI,";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as T$asValueCRI,
								(select CASE WHEN $targetMaleChildren > 0 OR $targetFeMaleChildren > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percT$asValueCRI,";
							}							
						}
						else{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as M$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as F$asValueCRI, ";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as T$asValueCRI, ";
							}
						}
					}
				}
				if($show_pl_cba)
				{
					if($in_out_coverage == 'in_uc'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PWperc$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'out_uc'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PW$asValueTT1 , ";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as $asValueTT1 , ";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PW$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as $asValueTT1, ";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j.")+sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition ) as $asValueTT2, ";
						}
					}
				}
				$queryForYearlyData = rtrim($queryForYearlyData,", ");
				//print_r($queryForYearlyData);exit();
				$queryForYearlyData .= " from facilities flcf1 join fac_mvrf_db fac on flcf1.facode=fac.facode where flcf1.distcode='$distcode' and $whereFmonth group by flcf1.facode,fac_name order by fac_name";
			}
		}
		else
		{
			//echo "Province";exit();
			if($in_out_coverage == 'out_district' || $in_out_coverage == 'total_districts'){
				$queryForYearlyData="SELECT distcode, districtname(distcode), ";
			}
			else{
				$queryForYearlyData="SELECT distcode, districtname(distcode), $tmp ";
			}
			//print_r($queryForYearlyData);exit();
			/* if($age_wise == '0to11')
			{
				array_pop($criNames);
			} */
			for($i=1;$i<=sizeof($criNames);$i++)
			{
				$asValueCRI=$criNames[$i-1];
				switch ($age_wise) 
				{
					case 'all':
						if($in_out_coverage == 'in_district'){
							$m_cols = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
							$f_cols = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i.")+sum(od_r3_f".$i.")+sum(od_r5_f".$i.")+sum(od_r7_f".$i.")+sum(od_r9_f".$i.")+sum(od_r11_f".$i.")+sum(od_r13_f".$i.")+sum(od_r15_f".$i.")+sum(od_r17_f".$i.")+sum(od_r19_f".$i.")+sum(od_r21_f".$i.")+sum(od_r23_f".$i.")";
							$f_cols = "sum(od_r2_f".$i.")+sum(od_r4_f".$i.")+sum(od_r6_f".$i.")+sum(od_r8_f".$i.")+sum(od_r10_f".$i.")+sum(od_r12_f".$i.")+sum(od_r14_f".$i.")+sum(od_r16_f".$i.")+sum(od_r18_f".$i.")+sum(od_r20_f".$i.")+sum(od_r22_f".$i.")+sum(od_r24_f".$i.")";
						}
						if($in_out_coverage == 'total_districts'){
							//echo "To be implemented";exit();
							$m_cols = "sum(a.cri_r1_f".$i." + b.od_r1_f".$i.")+sum(a.cri_r3_f".$i." + b.od_r3_f".$i.")+sum(a.cri_r5_f".$i." + b.od_r5_f".$i.")+sum(a.cri_r7_f".$i." + b.od_r7_f".$i.")+sum(a.cri_r9_f".$i." + b.od_r9_f".$i.")+sum(a.cri_r11_f".$i." + b.od_r11_f".$i.")+sum(a.cri_r13_f".$i." + b.od_r13_f".$i.")+sum(a.cri_r15_f".$i." + b.od_r15_f".$i.")+sum(a.cri_r17_f".$i." + b.od_r17_f".$i.")+sum(a.cri_r19_f".$i." + b.od_r19_f".$i.")+sum(a.cri_r21_f".$i." + b.od_r21_f".$i.")+sum(a.cri_r23_f".$i." + b.od_r23_f".$i.")";

							$f_cols = "sum(a.cri_r2_f".$i." + b.od_r2_f".$i.")+sum(a.cri_r4_f".$i." + b.od_r4_f".$i.")+sum(a.cri_r6_f".$i." + b.od_r6_f".$i.")+sum(a.cri_r8_f".$i." + b.od_r8_f".$i.")+sum(a.cri_r10_f".$i." + b.od_r10_f".$i.")+sum(a.cri_r12_f".$i." + b.od_r12_f".$i.")+sum(a.cri_r14_f".$i." + b.od_r14_f".$i.")+sum(a.cri_r16_f".$i." + b.od_r16_f".$i.")+sum(a.cri_r18_f".$i." + b.od_r18_f".$i.")+sum(a.cri_r20_f".$i." + b.od_r20_f".$i.")+sum(a.cri_r22_f".$i." + b.od_r22_f".$i.")+sum(a.cri_r24_f".$i." + b.od_r24_f".$i.")";
							// $m_cols = "$m_indist + $m_outdist";
							// $f_cols = "$f_indist + $f_outdist";
						}
						$t_cols = "$m_cols + $f_cols";
						//echo $t_cols;exit();
						$show_pl_cba = TRUE;
						break;
					case '0to11':
						if($in_out_coverage == 'in_district'){
							$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
							$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i." + od_r7_f".$i." + od_r13_f".$i." + od_r19_f".$i.")";
							$f_cols = "sum(od_r2_f".$i." + od_r8_f".$i." + od_r14_f".$i." + od_r20_f".$i.")";
						}
						if($in_out_coverage == 'total_districts'){
							//echo "To be implemented";exit();
							$m_cols = "sum(a.cri_r1_f".$i." + a.cri_r7_f".$i." + a.cri_r13_f".$i." + a.cri_r19_f".$i." + b.od_r1_f".$i." + b.od_r7_f".$i." + b.od_r13_f".$i." + b.od_r19_f".$i.")";
							$f_cols = "sum(a.cri_r2_f".$i." + a.cri_r8_f".$i." + a.cri_r14_f".$i." + a.cri_r20_f".$i." + b.od_r2_f".$i." + b.od_r8_f".$i." + b.od_r14_f".$i." + b.od_r20_f".$i.")";
						}
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case '12to23':
						if($in_out_coverage == 'in_district'){
							$m_cols = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
							$f_cols = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r3_f".$i." + od_r9_f".$i." + od_r15_f".$i." + od_r21_f".$i.")";
							$f_cols = "sum(od_r4_f".$i." + od_r10_f".$i." + od_r16_f".$i." + od_r22_f".$i.")";
						}
						if($in_out_coverage == 'total_districts'){
							//echo "To be implemented";exit();
							$m_cols = "sum(a.cri_r3_f".$i." + a.cri_r9_f".$i." + a.cri_r15_f".$i." + a.cri_r21_f".$i." + b.od_r3_f".$i." + b.od_r9_f".$i." + b.od_r15_f".$i." + b.od_r21_f".$i.")";
							$f_cols = "sum(a.cri_r4_f".$i." + a.cri_r10_f".$i." + a.cri_r16_f".$i." + a.cri_r22_f".$i." + b.od_r4_f".$i." + b.od_r10_f".$i." + b.od_r16_f".$i." + b.od_r22_f".$i.")";
						}
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case 'under2':
						if($in_out_coverage == 'in_district'){
							$m_cols = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
							$f_cols = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i." + od_r7_f".$i." + od_r13_f".$i." + od_r19_f".$i." + od_r3_f".$i." + od_r9_f".$i." + od_r15_f".$i." + od_r21_f".$i.")";
							$f_cols = "sum(od_r2_f".$i." + od_r8_f".$i." + od_r14_f".$i." + od_r20_f".$i." + od_r4_f".$i." + od_r10_f".$i." + od_r16_f".$i." + od_r22_f".$i.")";
						}
						if($in_out_coverage == 'total_districts'){
							//echo "To be implemented";exit();
							$m_cols = "sum(a.cri_r1_f".$i." + a.cri_r7_f".$i." + a.cri_r13_f".$i." + a.cri_r19_f".$i." + a.cri_r3_f".$i." + a.cri_r9_f".$i." + a.cri_r15_f".$i." + a.cri_r21_f".$i." + b.od_r1_f".$i." + b.od_r7_f".$i." + b.od_r13_f".$i." + b.od_r19_f".$i." + b.od_r3_f".$i." + b.od_r9_f".$i." + b.od_r15_f".$i." + b.od_r21_f".$i.")";
							$f_cols = "sum(a.cri_r2_f".$i." + a.cri_r8_f".$i." + a.cri_r14_f".$i." + a.cri_r20_f".$i." + a.cri_r4_f".$i." + a.cri_r10_f".$i." + a.cri_r16_f".$i." + a.cri_r22_f".$i." + b.od_r2_f".$i." + b.od_r8_f".$i." + b.od_r14_f".$i." + b.od_r20_f".$i." + b.od_r4_f".$i." + b.od_r10_f".$i." + b.od_r16_f".$i." + b.od_r22_f".$i.")";
						}
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case 'above2':
						if($in_out_coverage == 'in_district'){
							$m_cols = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
							$f_cols = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r5_f".$i." + od_r11_f".$i." + od_r17_f".$i." + od_r23_f".$i.")";
							$f_cols = "sum(od_r6_f".$i." + od_r12_f".$i." + od_r18_f".$i." + od_r24_f".$i.")";
						}
						if($in_out_coverage == 'total_districts'){
							//echo "To be implemented";exit();
							$m_cols = "sum(a.cri_r5_f".$i." + a.cri_r11_f".$i." + a.cri_r17_f".$i." + a.cri_r23_f".$i." + b.od_r5_f".$i." + b.od_r11_f".$i." + b.od_r17_f".$i." + b.od_r23_f".$i.")";
							$f_cols = "sum(a.cri_r6_f".$i." + a.cri_r12_f".$i." + a.cri_r18_f".$i." + a.cri_r24_f".$i." + b.od_r6_f".$i." + b.od_r12_f".$i." + b.od_r18_f".$i." + b.od_r24_f".$i.")";
						}
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					default:
						# code...
						break;
				}
				//print_r($t_cols);exit();
				if($in_out_coverage == 'in_district'){
					if($i >=1 && $i <= 3)
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition  group by fac_mvrf_db.distcode ) as M$asValueCRI,
							(select round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as percM$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as F$asValueCRI,
							(select round((coalesce($f_cols,0)*100)/NULLIF($newbornFemale,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percF$asValueCRI,
							";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition  group by fac_mvrf_db.distcode ) as T$asValueCRI,
							(select round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as percT$asValueCRI,";
						}
					}
					else
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as M$asValueCRI,
							(select round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percM$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as F$asValueCRI,
							(select round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percF$asValueCRI,";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as T$asValueCRI,
							(select round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percT$asValueCRI,";
						}
					}
				}
				if($in_out_coverage == 'out_district'){
					if($i >=1 && $i <= 3)
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition  group by fac_mvrf_od_db.distcode ) as M$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode ) as F$asValueCRI,
							";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition  group by fac_mvrf_od_db.distcode ) as T$asValueCRI,";
						}
					}
					else
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode) as M$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode) as F$asValueCRI,";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode) as T$asValueCRI,";
						}
					}
				}
				if($in_out_coverage == 'total_districts'){
					if($i >=1 && $i <= 3)
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as M$asValueCRI,
							(select round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as percM$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as F$asValueCRI,
							(select round((coalesce($f_cols,0)*100)/NULLIF($newbornFemale,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as percF$asValueCRI,
							";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as T$asValueCRI,
							(select round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as percT$asValueCRI,";
						}
					}
					else
					{
						if($vacc_to == 'gender')
						{
							$queryForYearlyData .= "
							(select round(coalesce($m_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as M$asValueCRI,
							(select round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as percM$asValueCRI,
							(select round(coalesce($f_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as F$asValueCRI,
							(select round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as percF$asValueCRI,";
						}
						elseif($vacc_to == 'total_children')
						{
							$queryForYearlyData .= "
							(select round(coalesce($t_cols,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as T$asValueCRI,
							(select round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode) as percT$asValueCRI,";
						}
					}
				}
			}
			if($show_pl_cba)
			{
				if($in_out_coverage == 'in_district'){
					for($k=1;$k<=sizeof($ttNames1);$k++)
					{
						$asValueTT1=$ttNames1[$k-1];
						if($k >=1 && $k<=2){
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttri_r9_f".$k."),0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PW$asValueTT1 ,
								(select round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PWperc$asValueTT1 ,";
						}
						else{
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttri_r9_f".$k."),0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as $asValueTT1 ,";
						}
					}
					for($j=1;$j<=sizeof($ttNames2);$j++)
					{
						$asValueTT2=$ttNames2[$j-1];
						$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition ) as $asValueTT2 ,";
					}
				}
				if($in_out_coverage == 'out_district'){
					for($k=1;$k<=sizeof($ttNames1);$k++)
					{
						$asValueTT1=$ttNames1[$k-1];
						if($k >=1 && $k<=2){
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttod_r9_f".$k."),0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode ) as PW$asValueTT1 ,";
						}
						else{
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttod_r9_f".$k."),0)) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_od_db.distcode ) as $asValueTT1 ,";
						}
					}
					for($j=1;$j<=sizeof($ttNames2);$j++)
					{
						$asValueTT2=$ttNames2[$j-1];
						$queryForYearlyData .= "(select coalesce(sum(ttod_r10_f".$j."),0) from fac_mvrf_od_db where fac_mvrf_od_db.distcode=dist.distcode $fmonthCondition ) as $asValueTT2 ,";
					}
				}
				if($in_out_coverage == 'total_districts'){
					for($k=1;$k<=sizeof($ttNames1);$k++)
					{
						$asValueTT1=$ttNames1[$k-1];
						if($k >=1 && $k<=2){
							$queryForYearlyData .= "
								(select round(coalesce(sum(a.ttri_r9_f".$k." + b.ttod_r9_f".$k."),0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as PW$asValueTT1 ,
								(select round((coalesce(sum(a.ttri_r9_f".$k." + b.ttod_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as PWperc$asValueTT1 ,";
						}
						else{
							$queryForYearlyData .= "
								(select round(coalesce(sum(a.ttri_r9_f".$k." + b.ttod_r9_f".$k."),0)) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition group by a.distcode ) as $asValueTT1 ,";
						}
					}
					for($j=1;$j<=sizeof($ttNames2);$j++)
					{
						$asValueTT2=$ttNames2[$j-1];
						$queryForYearlyData .= "(select coalesce(sum(a.ttri_r10_f".$j." + b.ttod_r10_f".$j."),0) from fac_mvrf_db a JOIN fac_mvrf_od_db b ON a.facode=b.facode and a.fmonth=b.fmonth where $fmonthCondition ) as $asValueTT2 ,";
					}
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			// if($in_out_coverage == 'total_districts'){
			// 	$queryForYearlyData .= " from districts dist, fac_mvrf_od_db b order by dist.district";
			// }
			// else{
			$queryForYearlyData .= " from districts dist order by district";
			//}			
		}
		$result = $this -> db -> query($queryForYearlyData) -> result_array();
		//echo $this -> db -> last_query(); exit();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		return $result;
	}
	//======= FLCF Wise Vaccination Coverage for Children and Women Report Function Ends Here ========//
	//------------------------------------------------------------------------------------------------//
	public function typeWiseVaccination($code=NULL,$year=NULL, $data=NULL){
		//print_r($_POST);exit();		
		/*$data = posted_Values();//posted values from last page
		if(!$data["year"]){
			$data["year"] = $this -> input -> get("report_year");
		}*/
		if(!isset($data["distcode"])){
			$data["distcode"] = $this -> input -> get("distcode");
		}
		$data['procode']=$_SESSION["Province"];
		$wc	= getWC_Array($data['procode'],$data['distcode']); // function to get wc array		
		$criNames   = array(
			"BCG","HEP","OPV_O",
			"OPV_ON","OPV_TW","OPV_TH",
			"PEN_O","PEN_TW","PEN_TH",
			"PC_O","PC_TW","PC_TH",
			"IP_O","ROTA_ON","ROTA_TW",
			"MEA_O","FULLY_IMMUNIZED","MEA_TW"
		);
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		$sizeofCriNames = sizeof($criNames);
		$sizeofttNames1 = sizeof($ttNames1);
		$sizeofttNames2 = sizeof($ttNames2);
		$data['vaccination_type'] = $this -> input -> get_post('vaccination_type');
		$data['in_out_coverage'] = $in_out_coverage = $this-> input-> get_post('in_out_coverage');
		if($data['distcode'] > 0){
			if($data['typeWise']=='uc'){
				if($data["monthfrom"] && $data['monthto']){
					$subTitle = 'Facility-wise Monthly Vaccination of Children and Women';					
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
				}
				if(!$data['monthfrom'] && $data['monthto']){
					$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women';
					$currMonth = ($data['year']<date('Y'))?12:date('m',strtotime("-1 month"));
					$fmonthCondition = " and fmonth like '".$data['monthfrom']."%' ";
				}

				$whereCondition = " fac_mvrf_db.uncode=flcf1.uncode";
				$groupBy = " group by fac_mvrf_db.uncode ";
				
				$queryStartPart = "select uncode, unname(uncode), ";
				$queryEndPart = " from unioncouncil flcf1 where ".((!empty($wc)) ? '  ' . implode(' AND ', $wc) : '' )." order by un_name";
			}
			else{
				if($data["monthfrom"] && $data['monthto']){
					$subTitle = 'Facility-wise Monthly Vaccination of Children and Women';
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
				}
				if(!$data['monthfrom'] && $data['monthto']){
					$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women';
					$currMonth = ($data['year']<date('Y'))?12:date('m',strtotime("-1 month"));
					$fmonthCondition = " and fmonth like '".$data['monthfrom']."%' ";
				}
				
				$whereCondition = " fac_mvrf_db.facode=flcf1.facode and flcf1.is_vacc_fac='1'";
				$groupBy = " group by fac_mvrf_db.facode ";
				
				$queryStartPart = "select facode, facilityname(facode), ";
				$queryEndPart = " from facilities flcf1 where hf_type='e' and is_vacc_fac='1' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by fac_name";
			}
		}
		else{
			if($data["monthfrom"] && $data['monthto']){
				$subTitle = 'Facility-wise Monthly Vaccination of Children and Women';
				if($in_out_coverage == 'total_districts'){
					$fmonthCondition = " and b.fmonth >= '".$data['monthfrom']."' and b.fmonth <= '".$data['monthto']."'";
				}
				else{
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
				}
			}
			if(!$data['monthfrom'] && $data['monthto']){
				$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women';
				$currMonth = ($data['year']<date('Y'))?12:date('m',strtotime("-1 month"));
				$fmonthCondition = " and fmonth like '".$data['year']."%' ";
			}
			if($in_out_coverage == 'out_district'){
				$whereCondition = " fac_mvrf_od_db.distcode=dist.distcode";
				$groupBy = " group by fac_mvrf_od_db.distcode ";
			}
			elseif($in_out_coverage == 'total_districts'){
				$whereCondition = " b.distcode=dist.distcode";
				$groupBy = " group by b.distcode ";
			}
			else{
				$whereCondition = " fac_mvrf_db.distcode=dist.distcode";
				$groupBy = " group by fac_mvrf_db.distcode ";
			}
			// $whereCondition = " fac_mvrf_db.distcode=dist.distcode";
			// $groupBy = " group by fac_mvrf_db.distcode ";
			$queryStartPart = "select distcode, districtname(distcode), ";
			$queryEndPart = " from districts dist order by district";
		}
		$middleQuery = "";
		$vacc_type_m_rows = array(
						'0to11'  => array('fixed'=>'r1','outreach'=>'r7','mobile'=>'r13','lhw'=>'r19'),
						'12to23' => array('fixed'=>'r3','outreach'=>'r9','mobile'=>'r15','lhw'=>'r21'),
						'above2' => array('fixed'=>'r5','outreach'=>'r11','mobile'=>'r17','lhw'=>'r23'),
						);
		$vacc_type_f_rows = array(
						'0to11'  => array('fixed'=>'r2','outreach'=>'r8','mobile'=>'r14','lhw'=>'r20'),
						'12to23' => array('fixed'=>'r4','outreach'=>'r10','mobile'=>'r16','lhw'=>'r22'),
						'above2' => array('fixed'=>'r6','outreach'=>'r12','mobile'=>'r18','lhw'=>'r24'),
						);
		/* $vacc_to = $this->input->post('vacc_to');
		$age_wise = $this->input->post('age_wise'); */
		$vacc_to=$data['vacc_to'];
		$age_wise=$data['age_wise'];
		//print_r($criNames);exit;
		/* if($age_wise == '0to11')
		{
			array_pop($criNames);
		} */
		//print_r($criNames);exit;
		for($j=1;$j<=sizeof($criNames);$j++){
			$asValueCRI=$criNames[$j-1];
		
			if($age_wise != 'under2' AND $age_wise != 'all')
			{
				$m_row = $vacc_type_m_rows[$age_wise][$data['vaccination_type']];
				$f_row = $vacc_type_f_rows[$age_wise][$data['vaccination_type']];
			}
			switch ($age_wise) 
			{
				case 'all':
					$m1_row = $vacc_type_m_rows['0to11'][$data['vaccination_type']];
					$m2_row = $vacc_type_m_rows['12to23'][$data['vaccination_type']];
					$m3_row = $vacc_type_m_rows['above2'][$data['vaccination_type']];
					$f1_row = $vacc_type_f_rows['0to11'][$data['vaccination_type']];
					$f2_row = $vacc_type_f_rows['12to23'][$data['vaccination_type']];
					$f3_row = $vacc_type_f_rows['above2'][$data['vaccination_type']];
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m1_row}_f{$j} + cri_{$m2_row}_f{$j} + cri_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f1_row}_f{$j} + cri_{$f2_row}_f{$j} + cri_{$f3_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j} + oui_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j} + oui_{$f3_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m1_row}_f{$j} + cri_{$m2_row}_f{$j} + cri_{$m3_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j} + oui_{$m3_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f1_row}_f{$j} + cri_{$f2_row}_f{$j} + cri_{$f3_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j} + oui_{$f3_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m1_row}_f{$j} + od_{$m2_row}_f{$j} + od_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f1_row}_f{$j} + od_{$f2_row}_f{$j} + od_{$f3_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_districts'){
						$m_cols = "coalesce(sum(a.cri_{$m1_row}_f{$j} + a.cri_{$m2_row}_f{$j} + a.cri_{$m3_row}_f{$j} + b.od_{$m1_row}_f{$j} + b.od_{$m2_row}_f{$j} + b.od_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(a.cri_{$f1_row}_f{$j} + a.cri_{$f2_row}_f{$j} + a.cri_{$f3_row}_f{$j} + b.od_{$f1_row}_f{$j} + b.od_{$f2_row}_f{$j} + b.od_{$f3_row}_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = TRUE;
					break;
				case '0to11':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_districts'){
						$m_cols = "coalesce(sum(a.cri_{$m_row}_f{$j} + b.od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(a.cri_{$f_row}_f{$j} + b.od_{$f_row}_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = FALSE;
					break;
				case '12to23':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_districts'){
						$m_cols = "coalesce(sum(a.cri_{$m_row}_f{$j} + b.od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(a.cri_{$f_row}_f{$j} + b.od_{$f_row}_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = FALSE;
					break;
				case 'under2':
					$m1_row = $vacc_type_m_rows['0to11'][$data['vaccination_type']];
					$m2_row = $vacc_type_m_rows['12to23'][$data['vaccination_type']];
					$f1_row = $vacc_type_f_rows['0to11'][$data['vaccination_type']];
					$f2_row = $vacc_type_f_rows['12to23'][$data['vaccination_type']];
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m1_row}_f{$j} + cri_{$m2_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f1_row}_f{$j} + cri_{$f2_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m1_row}_f{$j} + cri_{$m2_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f1_row}_f{$j} + cri_{$f2_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m1_row}_f{$j} + od_{$m2_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f1_row}_f{$j} + od_{$f2_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_districts'){
						$m_cols = "coalesce(sum(a.cri_{$m1_row}_f{$j} + a.cri_{$m2_row}_f{$j} + b.od_{$m1_row}_f{$j} + b.od_{$m2_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(a.cri_{$f1_row}_f{$j} + a.cri_{$f2_row}_f{$j} + b.od_{$f1_row}_f{$j} + b.od_{$f2_row}_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = FALSE;
					break;
				case 'above2':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
					}
					if($in_out_coverage == 'total_districts'){
						$m_cols = "coalesce(sum(a.cri_{$m_row}_f{$j} + b.od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(a.cri_{$f_row}_f{$j} + b.od_{$f_row}_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = FALSE;
					break;
				default:
					# code...
					break;
			}
			// print_r($t_cols1);exit();
			if($vacc_to == 'gender')
			{
				if($in_out_coverage == 'out_district'){
					$middleQuery .= "
						(select {$m_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as M{$asValueCRI},
						(select {$f_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as F{$asValueCRI},";
				}
				elseif($in_out_coverage == 'total_districts'){
					$middleQuery .= "
						(select {$m_cols} from fac_mvrf_db a, fac_mvrf_od_db b where {$whereCondition} {$fmonthCondition} {$groupBy} ) as M{$asValueCRI},
						(select {$f_cols} from fac_mvrf_db a, fac_mvrf_od_db b where {$whereCondition} {$fmonthCondition} {$groupBy} ) as F{$asValueCRI},";
				}
				else{
					$middleQuery .= "
						(select {$m_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as M{$asValueCRI},
						(select {$f_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as F{$asValueCRI},";
				}
			}
			elseif($vacc_to == 'total_children')
			{
				if($in_out_coverage == 'out_district'){
					$middleQuery .= "
						(select {$t_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as T{$asValueCRI},";
				}
				elseif($in_out_coverage == 'total_districts'){
					$middleQuery .= "
						(select {$t_cols} from fac_mvrf_db a, fac_mvrf_od_db b where {$whereCondition} {$fmonthCondition} {$groupBy} ) as T{$asValueCRI},";
				}
				else{
					$middleQuery .= "
						(select {$t_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as T{$asValueCRI},";
				}
			}
		}
		//print_r($t_cols);exit();
		if($show_pl_cba)
		{
			if($in_out_coverage == 'in_uc'){
				for($k=1;$k<=$sizeofttNames1;$k++){
					$asValueTT1=$ttNames1[$k-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r1_f{$k}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r3_f{$k}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r5_f{$k}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r7_f{$k}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as PW{$asValueTT1} ,";
				}
				for($i=1;$i<=$sizeofttNames2;$i++){
					$asValueTT2=$ttNames2[$i-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r2_f{$i}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r4_f{$i}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r6_f{$i}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r8_f{$i}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTNonPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} ) as {$asValueTT2} ,";
				}
			}
			if($in_out_coverage == 'out_uc'){
				for($k=1;$k<=$sizeofttNames1;$k++){
					$asValueTT1=$ttNames1[$k-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttoui_r1_f{$k}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttoui_r3_f{$k}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttoui_r5_f{$k}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttoui_r7_f{$k}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as PW{$asValueTT1} ,";
				}
				for($i=1;$i<=$sizeofttNames2;$i++){
					$asValueTT2=$ttNames2[$i-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttoui_r2_f{$i}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttoui_r4_f{$i}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttoui_r6_f{$i}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttoui_r8_f{$i}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTNonPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} ) as {$asValueTT2} ,";
				}
			}
			if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
				for($k=1;$k<=$sizeofttNames1;$k++){
					$asValueTT1=$ttNames1[$k-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r1_f{$k})+sum(ttoui_r1_f{$k}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r3_f{$k})+sum(ttoui_r3_f{$k}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r5_f{$k})+sum(ttoui_r5_f{$k}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttri_r7_f{$k})+sum(ttoui_r7_f{$k}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as PW{$asValueTT1} ,";
				}
				for($i=1;$i<=$sizeofttNames2;$i++){
					$asValueTT2=$ttNames2[$i-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r2_f{$i})+sum(ttoui_r2_f{$i}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r4_f{$i})+sum(ttoui_r4_f{$i}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r6_f{$i})+sum(ttoui_r6_f{$i}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttri_r8_f{$i})+sum(ttoui_r8_f{$i}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTNonPL} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} ) as {$asValueTT2} ,";
				}
			}
			if($in_out_coverage == 'out_district'){
				for($k=1;$k<=$sizeofttNames1;$k++){
					$asValueTT1=$ttNames1[$k-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttod_r1_f{$k}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttod_r3_f{$k}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttod_r5_f{$k}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTPL = "coalesce(sum(ttod_r7_f{$k}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTPL} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as PW{$asValueTT1} ,";
				}
				for($i=1;$i<=$sizeofttNames2;$i++){
					$asValueTT2=$ttNames2[$i-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttod_r2_f{$i}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttod_r4_f{$i}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttod_r6_f{$i}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(ttod_r8_f{$i}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTNonPL} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} ) as {$asValueTT2} ,";
				}
			}
			if($in_out_coverage == 'total_districts'){
				for($k=1;$k<=$sizeofttNames1;$k++){
					$asValueTT1=$ttNames1[$k-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTPL = "coalesce(sum(a.ttri_r1_f{$k} + b.ttod_r1_f{$k}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTPL = "coalesce(sum(a.ttri_r3_f{$k} + b.ttod_r3_f{$k}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTPL = "coalesce(sum(a.ttri_r5_f{$k} + b.ttod_r5_f{$k}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTPL = "coalesce(sum(a.ttri_r7_f{$k} + b.ttod_r7_f{$k}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTPL} from fac_mvrf_db a, fac_mvrf_od_db b where {$whereCondition} {$fmonthCondition} {$groupBy} ) as PW{$asValueTT1} ,";
				}
				for($i=1;$i<=$sizeofttNames2;$i++){
					$asValueTT2=$ttNames2[$i-1];
					if($data['vaccination_type'] == 'fixed')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(a.ttri_r2_f{$k} + b.ttod_r2_f{$i}),0)";
					if($data['vaccination_type'] == 'outreach')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(a.ttri_r4_f{$k} + b.ttod_r4_f{$i}),0)";
					if($data['vaccination_type'] == 'mobile')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(a.ttri_r6_f{$k} + b.ttod_r6_f{$i}),0)";
					if($data['vaccination_type'] == 'lhw')
						$middleQuerySelectPartTTNonPL = "coalesce(sum(a.ttri_r8_f{$k} + b.ttod_r8_f{$i}),0)";
					$middleQuery .= "(select {$middleQuerySelectPartTTNonPL} from fac_mvrf_db a, fac_mvrf_od_db b where {$whereCondition} {$fmonthCondition} ) as {$asValueTT2} ,";
				}
			}
		}
		
		$middleQuery = rtrim($middleQuery,",");
		$wholeQuery = $queryStartPart.$middleQuery.$queryEndPart;
		
		$result = $this-> db -> query($wholeQuery) -> result_array();
		//echo $this -> db -> last_query(); exit();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons'] = exportIcons($_REQUEST);
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
}
?>