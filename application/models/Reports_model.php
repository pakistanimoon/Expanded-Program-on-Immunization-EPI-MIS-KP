<?php 
//kp
class Reports_model extends CI_Model {
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
		$link="Reports";
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
		if ($reportName == 'sessionInfoReport') {
			$Caption = "Sessions Planned/Conducted";
			$datArray['yearMonthWise']="";
			$datArray['quarterwise'] = ""; 
			$datArray['months'] = "";
			$datArray['years'] = "";
			$datArray['vaccinationTypeSession'] = "";
		}
		if ($reportName == 'vaccine_demand') {
			$this -> load -> library('reportfilters');		
			$reportPeriod = array("month-from-to-previous");
			$reportPath = base_url()."Reports/vaccine_demand";
			$reportTitle = "Vaccine Consumption Report";
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			$allvaccines = array_column(getVaccines_options(true,1,true),"item_name","itemid");
			$allvaccines['0'] = 'Product';
			/* $customDropDown1 = array(
				array(
					'0' => 'Indicator',
					'used_vials' => 'Vials Used',
					'used_doses' => 'Doses Used',
					'unused_vials' => 'Unusable Vials',
					'unused_doses' => 'Unusable Doses',
					'closing_vials' => 'Closing Vials',
					'closing_doses' => 'Closing Doses',
				),
				$allvaccines
			);  */
			$customDropDown1 = array(0=>'Indicator','used_vials' => 'Vials Used','used_doses' => 'Doses Used','unused_vials' => 'Unusable Vials','unused_doses' => 'Unusable Doses','closing_vials' => 'Closing Vials','closing_doses' => 'Closing Doses',);
			$options = array(0=>'TypeWise','facility'=>'Facility Wise','uc'=>'Union Council Wise','tehsil' => 'Tehsil Wise');
			if($this -> session -> UserLevel==4){
				$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($customDropDown1,$allvaccines));	
			}else{
				$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($customDropDown1,$allvaccines,$options));	
			}
			$dataHtml .= $this->reportfilters->filtersFooter();
			$datArray['listing_filters'] = $dataHtml;
			return $datArray;
		}
		if ($reportName == 'measle_coverage_dropout') {
			$Caption = "Measles Coverage Vs. Measles Cases";
			$datArray['period_wise'] = "";
			//$datArray['month-from-to'] = "";
			$datArray['typeWise'] = "";
		}
		if ($reportName == 'all_dropout') {
			$Caption = "Dropouts Report";
			$datArray['typeWise'] = "";
			$datArray['month-from-to'] = "";
			//$datArray['vacc_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'access_utilization') {
			$Caption = "Access Utilization Report";
			//$datArray['typeWise'] = "";
			$datArray['month-from-to'] = "";
			//$datArray['UC and HF'] = "";
			$datArray['acces_type'] = "";
			//$datArray['vacc_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'flcf_vacc_coverage_compliance') {
			$Caption = "Facility Wise Vaccination Coverage Compliance";
		}
		if ($reportName == 'aefi_compliance') {
			$Caption = "AEFI Report Compliance";
		}
		if ($reportName == 'NNTInvestigationCompliance') {
			$Caption = "NNT Case Investigation Report Compliance";
		}
		if ($reportName == 'MeaslesInvestigationCompliance') {
			$Caption = "Measles Case Investigation Report Compliance";
		}
		if ($reportName == 'nntLineList') {
			$Caption = "Line List of NNT Case Report";
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
			$query="Select un_name, uncode from unioncouncil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by uncode";
			$resultUnc=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUnc->result_array();
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'measlesLineList') {
			$Caption = "Measles Outbreak Investigation Line List Report";
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
			$query="Select un_name, uncode from unioncouncil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by uncode";
			$resultUnc=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUnc->result_array();
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'diptheriaLineList' || $reportName == 'pneumoniaLineList' || $reportName == 'pertussisLineList' || $reportName == 'afpLineList' || $reportName == 'childhoodTBLineList') {
			if($reportName == 'diptheriaLineList')
				$Caption = "Diptheria Outbreak Line List Report";
			if($reportName == 'pneumoniaLineList')
				$Caption = "Pneumonia Outbreak Line List Report";
			if($reportName == 'pertussisLineList')
				$Caption = "Pertussis Outbreak Line List Report";
			if($reportName == 'afpLineList')
				$Caption = "AFP Outbreak Line List Report";
			if($reportName == 'childhoodTBLineList')
				$Caption = "Childhood TB Outbreak Line List Report";
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
			$query="Select un_name, uncode from unioncouncil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by uncode";
			$resultUnc=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUnc->result_array();
			$datArray['months']= "";
		}
		if ($reportName == 'formA1Compliance') {
			$Caption = "Form A-I (EPI) Compliance Report";
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'formA2Compliance') {
			$Caption = "Form A-II (EPI) Compliance Report";
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'formBCompliance') {
			$Caption = "Form B (EPI) Compliance Report";
			//$datArray['fmonthsfrom'] = "";
			//$datArray['fmonthsto'] = "";
			//unset($datArray['years']);
		}
		if ($reportName == 'formCCompliance') {
			$Caption = "Form C (EPI) Compliance Report";
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		if ($reportName == 'Weekly_VPD_Compilation') {
			$Caption = "Weekly VPD Surveillance Compilation Report";
			$datArray['epi_weeks'] = "";
			$datArray['epi_weekDates'] = "";
		}
		if ($reportName == 'Weekly_AEFI_Compilation') {
			$Caption = "Weekly AEFI Compilation Report";
			$datArray['from_to'] = "";
			unset($datArray['years']);
		}
		//for surveillance report filters
		if ($reportName == 'Surveillance') {
			unset($datArray['years']);
			$Caption = "Disease Surveillance Compilation Report";
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tcode";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
			$query="Select un_name, uncode from unioncouncil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by uncode";
			$resultUnc=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUnc->result_array();
			$query="Select distinct year from epi_weeks order by year asc";
			$result = $this -> db ->query($query);
			$datArray['epiyears'] = $result->result_array();
			$datArray['epi_weeks'] = "";
			$datArray['epi_weekDates'] = "";
			$datArray['disease'] = "";
		}
		if ($reportName == 'retiredHRreport') {
			$Caption = "Retired HR Report";
		}
		if($reportName == 'coldchainAssets'){
			$Caption = "Cold Chain Assets";
			$link = "Colchain_reports";
		}
		//echo "<pre>"; print_r($datArray); exit;			 
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() .$link.'/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
		//echo "<pre>"; print_r($datArray); exit;					 
		return $datArray;
	}
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	//-----------------------------------------------------------------------------------------------//
	//======= FLCF Wise Vaccination for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination($code=NULL,$year=NULL){
		$data = posted_Values();//posted values from last page
		//print_r($data);exit();
		if(!$data["year"]){
			$data["year"] = $this -> input -> get("report_year");
		}
		if(!$data["distcode"]){
			$data["distcode"] = $this -> input -> get("distcode");
		}
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		//$rightTotalImmun = "";$rightTotalTT = "";
		$year = $data['year'];
		//$year = $this->input->get('year');		
		$criNames   = array("Total_BCG","Total_HepB","Total_OPV0","Total_OPV1","Total_OPV2","Total_OPV3","Total_Pentavalent1","Total_Pentavalent2","Total_Pentavalent3","Total_PCV10_1","Total_PCV10_2","Total_PCV10_3","Total_IPV","Total_Measles1","Total_Measles2");
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		if($data["year"] && $data['month']){
			$fmonthCondition = " and fmonth = '".$data['year']."-".$data['month']."' ";
		}
		if(!$data['month'] && $data['year']){
			$fmonthCondition = " and fmonth like '".$data['year']."-%' ";
		}
		if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$queryForYearlyData="select facode, facilityname(facode),unname(uncode),
								getsurvivinginfants(facode,'facility') as \"Targeted_MaleFemale_Children\",
								getyearly_plwomen_target(facode,'facility') as \"Targeted_Women\", ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i==14){
					$i=16;
				}
				if($i==15){
					$i=18;
				}
				$queryForYearlyData .= "(select coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where facode=flcf1.facode $fmonthCondition ) as $asValueCRI, ";
				if($i==16){
					$i=14;
				}
				if($i==18){
					$i=15;
				}
			}
			$m=1;
			for($k=0;$k<sizeof($ttNames1);$k++){
				$rep=sizeof($ttNames1)/2;
				$asValueTT1=$ttNames1[$k];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$m."),0) from fac_mvrf_db where facode=flcf1.facode $fmonthCondition ) as $asValueTT1 ,";
				//$rightTotalTT .= "$asValueTT+";
				$m++;
				if($m==$rep+1){
					$m=1;
				}
			}
			$n=1;
			for($j=0;$j<sizeof($ttNames2);$j++){
				$rep=sizeof($ttNames2)/2;
				$asValueTT2=$ttNames2[$j];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$n."),0) from fac_mvrf_db where facode=flcf1.facode $fmonthCondition ) as $asValueTT2 ,";
				//$rightTotalTT .= "$asValueTT+";
				$n++;
				if($n==$rep+1){
					$n=1;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from facilities flcf1 where hf_type='e' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by fac_name";
		}
		else
		{
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			//case when district not selected mean provincial user logged in
			$queryForYearlyData="select distcode, districtname(distcode),
								(select count(*) from unioncouncil where distcode = dist.distcode) as \"Total UC\",
								getsurvivinginfants(distcode,'district') as \"Targeted_MaleFemale_Children\",
								getyearly_plwomen_target(distcode,'district') as \"Targeted_Women\", ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i==14){
					$i=16;
				}
				if($i==15){
					$i=17;
				}
				$queryForYearlyData .= "(select coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where distcode=dist.distcode $fmonthCondition ) as $asValueCRI, ";
				//$rightTotalImmun .= "$asValueCRI+";
				if($i==16){
					$i=14;
				}
				if($i==17){
					$i=15;
				}
			}
			$m=1;
			for($k=0;$k<sizeof($ttNames1);$k++){
				$rep=sizeof($ttNames1)/2;
				$asValueTT1=$ttNames1[$k];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$m."),0) from fac_mvrf_db where distcode=dist.distcode $fmonthCondition ) as $asValueTT1 ,";
				//$rightTotalTT .= "$asValueTT+";
				$m++;
				if($m==$rep+1){
					$m=1;
				}
			}
			$n=1;
			for($j=0;$j<sizeof($ttNames2);$j++){
				$rep=sizeof($ttNames2)/2;
				$asValueTT2=$ttNames2[$j];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$n."),0) from fac_mvrf_db where distcode=dist.distcode $fmonthCondition ) as $asValueTT2 ,";
				//$rightTotalTT .= "$asValueTT+";
				$n++;
				if($n==$rep+1){
					$n=1;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by district";
		}
		//echo $queryForYearlyData;exit;
		//$rightTotalImmun = rtrim($rightTotalImmun,"+");
		//$rightTotalTT = rtrim($rightTotalTT,"+");
		//$queryForTotal = "select *,$rightTotalImmun as totalimmun,$rightTotalTT as totalTT from ($queryForYearlyData) as b";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		//$result = $this-> db -> query($queryForTotal) -> result_array();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//$result["year"] = $year;
		$subTitle = 'Facility Wise Vaccination of Children and Women';
		$result['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year'],'','',$data['month']);
		$result['exportIcons']=exportIcons($_REQUEST);
		return $result;
	}
	//======= FLCF Wise Vaccination Coverage for Children and Women Report Function Ends Here ========//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//======= (Male Female wise)FLCF Wise Vaccination for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination_malefemale_coverage($code=NULL,$year=NULL,$data=NULL)
	{
		if($this -> session -> federaluser == true){
			$fedDrilldown = $this -> session -> federaluser;
		}
		$start_year = substr($data['monthfrom'],0,4);
		$start_month = substr($data['monthfrom'],5,2);
		$end_year = substr($data['monthto'],0,4);
		$end_month = substr($data['monthto'],5,2);
		$in_out_coverage = $this-> input-> get_post('in_out_coverage');
		if(!isset($data["distcode"])){
			$data["distcode"] = $this-> input-> get_post("distcode");
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
			"MEA_O","FULLY_IMMUNIZED","MEA_TW","DTP_O","TCV_O","IP_TW"
		);
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		if($data['distcode'] > 0)
		{
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
					$tmp_new_borns_male = "round((getmonthlytarget_specificyearr(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric*51)/100) as \"New Borns Male\",";
					$tmp_new_borns_female = "round((getmonthlytarget_specificyearr(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric*49)/100) as \"New Borns FeMale\",";
					$tmp_new_borns_total = "round((getmonthlytarget_specificyearr(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric*100)/100) as \"Total New Borns\",";
					$tmp_target_male_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.tcode::text,'tehsil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100) as \"Targeted_Male_Children\",";
					$tmp_target_female_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.tcode::text,'tehsil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100) as \"Targeted_Female_Children\",";
					$tmp_target_total_child = "round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.tcode::text,'tehsil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*100)/100) as \"Total_Targeted_Children\",";
					$tmp_target_woman = "round((getmonthly_plwomen_target_specificyears(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric)) as \"Targeted_Women\",";
					$newbornMale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric*51)/100,2),0) , 0 )";
					$newbornFemale = "COALESCE( NULLIF(round((getmonthlytarget_specificyearr(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric*49)/100,2),0) , 0 )";
					$targetMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.tcode::text,'tehsil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*51)/100,2),0) , 0 )";
					$targetFeMaleChildren = "COALESCE( NULLIF(round(((getmonthlytarget_specificyearrsurvivinginfants(flcf1.tcode::text,'tehsil'::text,$start_year,$start_month,$end_year,$end_month)::numeric)*49)/100,2),0) , 0 )";
					$targetWomen = "COALESCE( NULLIF(round((getmonthly_plwomen_target_specificyears(flcf1.tcode::text,$start_year,$start_month,$end_year,$end_month,'tehsil')::numeric),2),0) , 0 )";
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
		$vacc_to = $this-> input-> get_post('vacc_to');
		$age_wise = $this-> input-> get_post('age_wise');
		
		if($vacc_to == 'total_children')
		{	
			$tmp = "$tmp_new_borns_total $tmp_target_total_child $tmp_target_woman";
		}
		elseif($vacc_to == 'gender')
		{
			$tmp = "$tmp_new_borns_male $tmp_new_borns_female $tmp_target_male_child $tmp_target_female_child $tmp_target_woman";
		}

		if($data['distcode'] > 0)
		{
			//case when district selected or deo logged in
			if($data['typeWise']=='uc')
			{
				if($in_out_coverage == 'out_uc'){
					$queryForYearlyData="SELECT flcf1.uncode, unname(flcf1.uncode), ";
				}
				else{
					$queryForYearlyData="SELECT flcf1.uncode, unname(flcf1.uncode), $tmp ";
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
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.uncode=flcf1.uncode $fmonthCondition group by fac_mvrf_db.uncode ) as PWperc$asValueTT1 ,";
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
			elseif($data['typeWise']=='tehsil')
			{
				if($in_out_coverage == 'out_uc'){
					$queryForYearlyData="SELECT flcf1.tcode, tehsilname(flcf1.tcode), ";
				}
				else{
					$queryForYearlyData="SELECT flcf1.tcode, tehsilname(flcf1.tcode), $tmp ";
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
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as M$asValueCRI,
								(select CASE WHEN $newbornMale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as F$asValueCRI,
								(select CASE WHEN $newbornFemale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornFemale,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percF$asValueCRI,
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as T$asValueCRI,
								(select CASE WHEN $newbornMale > 0 OR $newbornFemale > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as percT$asValueCRI,
								";
							}
							
						}
						else{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition  group by fac_mvrf_db.tcode ) as M$asValueCRI,
								(select CASE WHEN $newbornMale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornMale,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as F$asValueCRI,
								(select CASE WHEN $newbornFemale = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($newbornFemale,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percF$asValueCRI,
								";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as T$asValueCRI,
								(select CASE WHEN $newbornMale > 0 OR $newbornFemale > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($newbornFemale,0) + NULLIF($newbornMale,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as percT$asValueCRI,
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
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as M$asValueCRI,
								(select CASE WHEN $targetMaleChildren = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as F$asValueCRI,
								(select CASE WHEN $targetFeMaleChildren = 0 THEN 0 ELSE round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percF$asValueCRI,";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as T$asValueCRI,
								(select CASE WHEN $targetMaleChildren > 0 OR $targetFeMaleChildren > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percT$asValueCRI,";
							}
						}
						else
						{
							if($vacc_to == 'gender')
							{
								$queryForYearlyData .= "
								(select coalesce($m_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as M$asValueCRI,
								(select CASE WHEN $targetMaleChildren = 0 THEN 0 ELSE round((coalesce($m_cols,0)*100)/NULLIF($targetMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percM$asValueCRI,
								(select coalesce($f_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as F$asValueCRI,
								(select CASE WHEN $targetFeMaleChildren = 0 THEN 0 ELSE round((coalesce($f_cols,0)*100)/NULLIF($targetFeMaleChildren,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percF$asValueCRI,";
							}
							elseif($vacc_to == 'total_children')
							{
								$queryForYearlyData .= "
								(select coalesce($t_cols,0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as T$asValueCRI,
								(select CASE WHEN $targetMaleChildren > 0 OR $targetFeMaleChildren > 0 THEN round((coalesce($t_cols,0)*100)/(NULLIF($targetFeMaleChildren,0) + NULLIF($targetMaleChildren,0))) ELSE 0 END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode) as percT$asValueCRI,";
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
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as PWperc$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'out_uc'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as PW$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						for($k=1;$k<=sizeof($ttNames1);$k++)
						{
							$asValueTT1=$ttNames1[$k-1];
							if($k >=1 && $k<=2)
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as PWperc$asValueTT1 ,";
							}
							else
							{
								$queryForYearlyData .= "
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition group by fac_mvrf_db.tcode ) as $asValueTT1 ,";
							}
						}
						for($j=1;$j<=sizeof($ttNames2);$j++)
						{
							$asValueTT2=$ttNames2[$j-1];
							$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j.")+sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.tcode=flcf1.tcode $fmonthCondition ) as $asValueTT2 ,";
						}
					}
				}
				$queryForYearlyData = rtrim($queryForYearlyData,",");
				$queryForYearlyData .= " from tehsil flcf1 join fac_mvrf_db fac on flcf1.tcode=fac.tcode where flcf1.distcode ='$distcode' group by flcf1.tcode, tehsil order by tehsil";
			}
			else
			{
				if($in_out_coverage == 'out_uc'){
					$queryForYearlyData="SELECT flcf1.facode, facilityname(flcf1.facode), ";				
				}
				else{
					$queryForYearlyData="SELECT flcf1.facode, facilityname(flcf1.facode), $tmp ";
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
						if($in_out_coverage == 'in_uc' || $in_out_coverage == 'total_ucs'){
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
						if($in_out_coverage == 'in_uc' || $in_out_coverage == 'total_ucs'){
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
									(select coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PW$asValueTT1 ,
									(select CASE WHEN $targetWomen = 0 THEN 0 ELSE round((coalesce(sum(ttri_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) END from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PWperc$asValueTT1 ,";
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
			if($in_out_coverage == 'out_district'){
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
							$m_cols_in = "sum(cri_r1_f".$i.")+sum(cri_r3_f".$i.")+sum(cri_r5_f".$i.")+sum(cri_r7_f".$i.")+sum(cri_r9_f".$i.")+sum(cri_r11_f".$i.")+sum(cri_r13_f".$i.")+sum(cri_r15_f".$i.")+sum(cri_r17_f".$i.")+sum(cri_r19_f".$i.")+sum(cri_r21_f".$i.")+sum(cri_r23_f".$i.")";
							$m_cols_out = "sum(oui_r1_f".$i.")+sum(oui_r3_f".$i.")+sum(oui_r5_f".$i.")+sum(oui_r7_f".$i.")+sum(oui_r9_f".$i.")+sum(oui_r11_f".$i.")+sum(oui_r13_f".$i.")+sum(oui_r15_f".$i.")+sum(oui_r17_f".$i.")+sum(oui_r19_f".$i.")+sum(oui_r21_f".$i.")+sum(oui_r23_f".$i.")";
							$m_cols="$m_cols_in + $m_cols_out";
							$f_cols_in = "sum(cri_r2_f".$i.")+sum(cri_r4_f".$i.")+sum(cri_r6_f".$i.")+sum(cri_r8_f".$i.")+sum(cri_r10_f".$i.")+sum(cri_r12_f".$i.")+sum(cri_r14_f".$i.")+sum(cri_r16_f".$i.")+sum(cri_r18_f".$i.")+sum(cri_r20_f".$i.")+sum(cri_r22_f".$i.")+sum(cri_r24_f".$i.")";
							$f_cols_out = "sum(oui_r2_f".$i.")+sum(oui_r4_f".$i.")+sum(oui_r6_f".$i.")+sum(oui_r8_f".$i.")+sum(oui_r10_f".$i.")+sum(oui_r12_f".$i.")+sum(oui_r14_f".$i.")+sum(oui_r16_f".$i.")+sum(oui_r18_f".$i.")+sum(oui_r20_f".$i.")+sum(oui_r22_f".$i.")+sum(oui_r24_f".$i.")";
							$f_cols="$f_cols_in + $f_cols_out";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i.")+sum(od_r3_f".$i.")+sum(od_r5_f".$i.")+sum(od_r7_f".$i.")+sum(od_r9_f".$i.")+sum(od_r11_f".$i.")+sum(od_r13_f".$i.")+sum(od_r15_f".$i.")+sum(od_r17_f".$i.")+sum(od_r19_f".$i.")+sum(od_r21_f".$i.")+sum(od_r23_f".$i.")";
							$f_cols = "sum(od_r2_f".$i.")+sum(od_r4_f".$i.")+sum(od_r6_f".$i.")+sum(od_r8_f".$i.")+sum(od_r10_f".$i.")+sum(od_r12_f".$i.")+sum(od_r14_f".$i.")+sum(od_r16_f".$i.")+sum(od_r18_f".$i.")+sum(od_r20_f".$i.")+sum(od_r22_f".$i.")+sum(od_r24_f".$i.")";
							
						}						
						$t_cols = "$m_cols + $f_cols";
						//echo $t_cols;exit();
						$show_pl_cba = TRUE;
						break;
					case '0to11':
						if($in_out_coverage == 'in_district'){
							$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i.")";
							$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i.")";
							$m_cols="$m_cols_in + $m_cols_out";
							$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i.")";
							$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i.")";
							$f_cols="$f_cols_in + $f_cols_out";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i." + od_r7_f".$i." + od_r13_f".$i." + od_r19_f".$i.")";
							$f_cols = "sum(od_r2_f".$i." + od_r8_f".$i." + od_r14_f".$i." + od_r20_f".$i.")";
						}						
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case '12to23':
						if($in_out_coverage == 'in_district'){
							$m_cols_in = "sum(cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
							$m_cols_out = "sum(oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
							$m_cols="$m_cols_in + $m_cols_out";
							$f_cols_in = "sum(cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							$f_cols_out = "sum(oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							$f_cols="$f_cols_in + $f_cols_out";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r3_f".$i." + od_r9_f".$i." + od_r15_f".$i." + od_r21_f".$i.")";
							$f_cols = "sum(od_r4_f".$i." + od_r10_f".$i." + od_r16_f".$i." + od_r22_f".$i.")";
						}						
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case 'under2':
						if($in_out_coverage == 'in_district'){
							$m_cols_in = "sum(cri_r1_f".$i." + cri_r7_f".$i." + cri_r13_f".$i." + cri_r19_f".$i." + cri_r3_f".$i." + cri_r9_f".$i." + cri_r15_f".$i." + cri_r21_f".$i.")";
							$m_cols_out = "sum(oui_r1_f".$i." + oui_r7_f".$i." + oui_r13_f".$i." + oui_r19_f".$i." + oui_r3_f".$i." + oui_r9_f".$i." + oui_r15_f".$i." + oui_r21_f".$i.")";
							$m_cols="$m_cols_in + $m_cols_out";
							$f_cols_in = "sum(cri_r2_f".$i." + cri_r8_f".$i." + cri_r14_f".$i." + cri_r20_f".$i." + cri_r4_f".$i." + cri_r10_f".$i." + cri_r16_f".$i." + cri_r22_f".$i.")";
							$f_cols_out = "sum(oui_r2_f".$i." + oui_r8_f".$i." + oui_r14_f".$i." + oui_r20_f".$i." + oui_r4_f".$i." + oui_r10_f".$i." + oui_r16_f".$i." + oui_r22_f".$i.")";
							$f_cols="$f_cols_in + $f_cols_out";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r1_f".$i." + od_r7_f".$i." + od_r13_f".$i." + od_r19_f".$i." + od_r3_f".$i." + od_r9_f".$i." + od_r15_f".$i." + od_r21_f".$i.")";
							$f_cols = "sum(od_r2_f".$i." + od_r8_f".$i." + od_r14_f".$i." + od_r20_f".$i." + od_r4_f".$i." + od_r10_f".$i." + od_r16_f".$i." + od_r22_f".$i.")";
						}						
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					case 'above2':
						if($in_out_coverage == 'in_district'){
							$m_cols_in = "sum(cri_r5_f".$i." + cri_r11_f".$i." + cri_r17_f".$i." + cri_r23_f".$i.")";
							$m_cols_out = "sum(oui_r5_f".$i." + oui_r11_f".$i." + oui_r17_f".$i." + oui_r23_f".$i.")";
							$m_cols="$m_cols_in + $m_cols_out";
							$f_cols_in = "sum(cri_r6_f".$i." + cri_r12_f".$i." + cri_r18_f".$i." + cri_r24_f".$i.")";
							$f_cols_out = "sum(oui_r6_f".$i." + oui_r12_f".$i." + oui_r18_f".$i." + oui_r24_f".$i.")";
							$f_cols="$f_cols_in + $f_cols_out";
						}
						if($in_out_coverage == 'out_district'){
							$m_cols = "sum(od_r5_f".$i." + od_r11_f".$i." + od_r17_f".$i." + od_r23_f".$i.")";
							$f_cols = "sum(od_r6_f".$i." + od_r12_f".$i." + od_r18_f".$i." + od_r24_f".$i.")";
						}						
						$t_cols = "$m_cols + $f_cols";
						$show_pl_cba = FALSE;
						break;
					default:
						# code...
						break;
				}
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
			}
			if($show_pl_cba)
			{
				if($in_out_coverage == 'in_district'){
					for($k=1;$k<=sizeof($ttNames1);$k++)
					{
						$asValueTT1=$ttNames1[$k-1];
						if($k >=1 && $k<=2){
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PW$asValueTT1 ,
								(select round((coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0)*100)/NULLIF($targetWomen,0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PWperc$asValueTT1 ,";
						}
						else{
							$queryForYearlyData .= "
								(select round(coalesce(sum(ttri_r9_f".$k.")+sum(ttoui_r9_f".$k."),0)) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as $asValueTT1 ,";
						}
					}
					for($j=1;$j<=sizeof($ttNames2);$j++)
					{
						$asValueTT2=$ttNames2[$j-1];
						$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$j.")+sum(ttoui_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition ) as $asValueTT2 ,";
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
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			if(isset($fedDrilldown)){
				$queryForYearlyData .= " from districts dist order by dist_order";
			}
			else{
				$queryForYearlyData .= " from districts dist order by district";
			}
		}

		/* if(isset($fedDrilldown)){
			if($this -> input -> get_post('distcode') != '' && $this -> input -> get_post('in_out_coverage') == 'in_district'){
				$data['in_out_coverage'] = 'in_uc';
			}
		}
		else{
			if($this -> input -> get_post('distcode') != '' && $this -> input -> get_post('in_out_coverage') == 'in_district'){
				$data['in_out_coverage'] = 'in_uc';
			}
		} */
		$result = $this -> db -> query($queryForYearlyData) -> result_array();
		//echo $this -> db -> last_query();exit;
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
	public function typeWiseVaccination($code=NULL,$year=NULL, $data=NULL)
	{
		if(!isset($data["distcode"])){
			$data["distcode"] = $this -> input -> get_post("distcode");
		}
		if(!isset($data["tcode"])){
			$data["tcode"] = $this -> input -> get_post("tcode");
		}
		$data['procode']=$_SESSION["Province"];
		$wc	= getWC_Array($data['procode'],$data['distcode'],$data['tcode']); // function to get wc array		
		$criNames   = array(
			"BCG","HEP","OPV_O",
			"OPV_ON","OPV_TW","OPV_TH",
			"PEN_O","PEN_TW","PEN_TH",
			"PC_O","PC_TW","PC_TH",
			"IP_O","ROTA_ON","ROTA_TW",
			"MEA_O","FULLY_IMMUNIZED","MEA_TW","DTP_O","TCV_O","IP_TW"
		);
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		$sizeofCriNames = sizeof($criNames);
		$sizeofttNames1 = sizeof($ttNames1);
		$sizeofttNames2 = sizeof($ttNames2);
		$data['vaccination_type'] = $this -> input -> get_post('vaccination_type');
		$data['in_out_coverage'] = $in_out_coverage = $this-> input-> get_post('in_out_coverage');
		if($data['distcode'] > 0 || $data['tcode']){
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
				
				$queryStartPart = "SELECT uncode, unname(uncode), ";
				$queryEndPart = " from unioncouncil flcf1 where ".((!empty($wc)) ? '  ' . implode(' AND ', $wc) : '' )." order by un_name";
			}
			else if($data['typeWise']=='tehsil'){
				if($data["monthfrom"] && $data['monthto']){
					$subTitle = 'Facility-wise Monthly Vaccination of Children and Women';					
					$fmonthCondition = " and fmonth >= '".$data['monthfrom']."' and fmonth <= '".$data['monthto']."'";
				}
				if(!$data['monthfrom'] && $data['monthto']){
					$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women';
					$currMonth = ($data['year']<date('Y'))?12:date('m',strtotime("-1 month"));
					$fmonthCondition = " and fmonth like '".$data['monthfrom']."%' ";
				}

				$whereCondition = " fac_mvrf_db.tcode=flcf1.tcode";
				$groupBy = " group by fac_mvrf_db.tcode ";
				
				$queryStartPart = "SELECT tcode, tehsilname(tcode), ";
				$queryEndPart = " from tehsil flcf1 where ".((!empty($wc)) ? '  ' . implode(' AND ', $wc) : '' )." order by tehsil";
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
				
				$queryStartPart = "SELECT facode, facilityname(facode), ";
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
			$queryStartPart = "SELECT distcode, districtname(distcode), ";
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
		
		$vacc_to=$data['vacc_to'];
		$age_wise=$data['age_wise'];
		
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
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(cri_r1_f{$j} + cri_r3_f{$j} + cri_r5_f{$j} + cri_r7_f{$j} + cri_r9_f{$j} + cri_r11_f{$j} + cri_r13_f{$j} + cri_r15_f{$j} + cri_r17_f{$j} + cri_r19_f{$j} + cri_r21_f{$j} + cri_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(cri_r2_f{$j} + cri_r4_f{$j} + cri_r6_f{$j} + cri_r8_f{$j} + cri_r10_f{$j} + cri_r12_f{$j} + cri_r14_f{$j} + cri_r16_f{$j} + cri_r18_f{$j} + cri_r20_f{$j} + cri_r22_f{$j} + cri_r24_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j} + oui_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j} + oui_{$f3_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(oui_r1_f{$j} + oui_r3_f{$j} + oui_r5_f{$j} + oui_r7_f{$j} + oui_r9_f{$j} + oui_r11_f{$j} + oui_r13_f{$j} + oui_r15_f{$j} + oui_r17_f{$j} + oui_r19_f{$j} + oui_r21_f{$j} + oui_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(oui_r2_f{$j} + oui_r4_f{$j} + oui_r6_f{$j} + oui_r8_f{$j} + oui_r10_f{$j} + oui_r12_f{$j} + oui_r14_f{$j} + oui_r16_f{$j} + oui_r18_f{$j} + oui_r20_f{$j} + oui_r22_f{$j} + oui_r24_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m1_row}_f{$j} + cri_{$m2_row}_f{$j} + cri_{$m3_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m1_row}_f{$j} + oui_{$m2_row}_f{$j} + oui_{$m3_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f1_row}_f{$j} + cri_{$f2_row}_f{$j} + cri_{$f3_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f1_row}_f{$j} + oui_{$f2_row}_f{$j} + oui_{$f3_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
						
						/* for total vaccination column (updated on 30-04-2019) */
						/* inside UC columns for total vaccination for a dose */
						$m_total_sum_in = "coalesce(sum(cri_r1_f{$j} + cri_r3_f{$j} + cri_r5_f{$j} + cri_r7_f{$j} + cri_r9_f{$j} + cri_r11_f{$j} + cri_r13_f{$j} + cri_r15_f{$j} + cri_r17_f{$j} + cri_r19_f{$j} + cri_r21_f{$j} + cri_r23_f{$j}),0)";
						$f_total_sum_in = "coalesce(sum(cri_r2_f{$j} + cri_r4_f{$j} + cri_r6_f{$j} + cri_r8_f{$j} + cri_r10_f{$j} + cri_r12_f{$j} + cri_r14_f{$j} + cri_r16_f{$j} + cri_r18_f{$j} + cri_r20_f{$j} + cri_r22_f{$j} + cri_r24_f{$j}),0)";
						/* outside UC columns for total vaccination for a dose */
						$m_total_sum_out = "coalesce(sum(oui_r1_f{$j} + oui_r3_f{$j} + oui_r5_f{$j} + oui_r7_f{$j} + oui_r9_f{$j} + oui_r11_f{$j} + oui_r13_f{$j} + oui_r15_f{$j} + oui_r17_f{$j} + oui_r19_f{$j} + oui_r21_f{$j} + oui_r23_f{$j}),0)";
						$f_total_sum_out = "coalesce(sum(oui_r2_f{$j} + oui_r4_f{$j} + oui_r6_f{$j} + oui_r8_f{$j} + oui_r10_f{$j} + oui_r12_f{$j} + oui_r14_f{$j} + oui_r16_f{$j} + oui_r18_f{$j} + oui_r20_f{$j} + oui_r22_f{$j} + oui_r24_f{$j}),0)";
						/* concate column for male and female */
						$m_total_sum = "$m_total_sum_in + $m_total_sum_out";
						$f_total_sum = "$f_total_sum_in + $f_total_sum_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m1_row}_f{$j} + od_{$m2_row}_f{$j} + od_{$m3_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f1_row}_f{$j} + od_{$f2_row}_f{$j} + od_{$f3_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(od_r1_f{$j} + od_r3_f{$j} + od_r5_f{$j} + od_r7_f{$j} + od_r9_f{$j} + od_r11_f{$j} + od_r13_f{$j} + od_r15_f{$j} + od_r17_f{$j} + od_r19_f{$j} + od_r21_f{$j} + od_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(od_r2_f{$j} + od_r4_f{$j} + od_r6_f{$j} + od_r8_f{$j} + od_r10_f{$j} + od_r12_f{$j} + od_r14_f{$j} + od_r16_f{$j} + od_r18_f{$j} + od_r20_f{$j} + od_r22_f{$j} + od_r24_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$total_vacc_cols = "$m_total_sum + $f_total_sum";
					$show_pl_cba = TRUE;
					break;
				case '0to11':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(cri_r1_f{$j} + cri_r7_f{$j} + cri_r13_f{$j} + cri_r19_f{$j}),0)";
						$f_total_sum = "coalesce(sum(cri_r2_f{$j} + cri_r8_f{$j} + cri_r14_f{$j} + cri_r20_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(oui_r1_f{$j} + oui_r7_f{$j} + oui_r13_f{$j} + oui_r19_f{$j}),0)";
						$f_total_sum = "coalesce(sum(oui_r2_f{$j} + oui_r8_f{$j} + oui_r14_f{$j} + oui_r20_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
						
						$m_total_sum_in = "coalesce(sum(cri_r1_f{$j} + cri_r7_f{$j} + cri_r13_f{$j} + cri_r19_f{$j}),0)";
						$f_total_sum_in = "coalesce(sum(cri_r2_f{$j} + cri_r8_f{$j} + cri_r14_f{$j} + cri_r20_f{$j}),0)";
						$m_total_sum_out = "coalesce(sum(oui_r1_f{$j} + oui_r7_f{$j} + oui_r13_f{$j} + oui_r19_f{$j}),0)";
						$f_total_sum_out = "coalesce(sum(oui_r2_f{$j} + oui_r8_f{$j} + oui_r14_f{$j} + oui_r20_f{$j}),0)";
						
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "$m_total_sum_in + $m_total_sum_out";
						$f_total_sum = "$f_total_sum_in + $f_total_sum_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(od_r1_f{$j} + od_r7_f{$j} + od_r13_f{$j} + od_r19_f{$j}),0)";
						$f_total_sum = "coalesce(sum(od_r2_f{$j} + od_r8_f{$j} + od_r14_f{$j} + od_r20_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$total_vacc_cols = "$m_total_sum + $f_total_sum";
					$show_pl_cba = FALSE;
					break;
				case '12to23':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(cri_r3_f{$j} + cri_r9_f{$j} + cri_r15_f{$j} + cri_r21_f{$j}),0)";
						$f_total_sum = "coalesce(sum(cri_r4_f{$j} + cri_r10_f{$j} + cri_r16_f{$j} + cri_r22_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(oui_r3_f{$j} + oui_r9_f{$j} + oui_r15_f{$j} + oui_r21_f{$j}),0)";
						$f_total_sum = "coalesce(sum(oui_r4_f{$j} + oui_r10_f{$j} + oui_r16_f{$j} + oui_r22_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
						
						$m_total_sum_in = "coalesce(sum(cri_r3_f{$j} + cri_r9_f{$j} + cri_r15_f{$j} + cri_r21_f{$j}),0)";
						$f_total_sum_in = "coalesce(sum(cri_r4_f{$j} + cri_r10_f{$j} + cri_r16_f{$j} + cri_r22_f{$j}),0)";
						$m_total_sum_out = "coalesce(sum(oui_r3_f{$j} + oui_r9_f{$j} + oui_r15_f{$j} + oui_r21_f{$j}),0)";
						$f_total_sum_out = "coalesce(sum(oui_r4_f{$j} + oui_r10_f{$j} + oui_r16_f{$j} + oui_r22_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "$m_total_sum_in + $m_total_sum_out";
						$f_total_sum = "$f_total_sum_in + $f_total_sum_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(od_r3_f{$j} + od_r9_f{$j} + od_r15_f{$j} + od_r21_f{$j}),0)";
						$f_total_sum = "coalesce(sum(od_r4_f{$j} + od_r10_f{$j} + od_r16_f{$j} + od_r22_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$total_vacc_cols = "$m_total_sum + $f_total_sum";
					$show_pl_cba = FALSE;
					break;
				/* case 'under2':
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
					$t_cols = "$m_cols + $f_cols";
					$show_pl_cba = FALSE;
					break; */
				case 'above2':
					if($in_out_coverage == 'in_uc'){
						$m_cols = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(cri_r5_f{$j} + cri_r11_f{$j} + cri_r17_f{$j} + cri_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(cri_r6_f{$j} + cri_r12_f{$j} + cri_r18_f{$j} + cri_r24_f{$j}),0)";
					}
					if($in_out_coverage == 'out_uc'){
						$m_cols = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(oui_r5_f{$j} + oui_r11_f{$j} + oui_r17_f{$j} + oui_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(oui_r6_f{$j} + oui_r12_f{$j} + oui_r18_f{$j} + oui_r24_f{$j}),0)";
					}
					if($in_out_coverage == 'total_ucs' || $in_out_coverage == 'in_district'){
						$m_cols_in = "coalesce(sum(cri_{$m_row}_f{$j}),0)";
						$m_cols_out = "coalesce(sum(oui_{$m_row}_f{$j}),0)";
						$m_cols = "$m_cols_in + $m_cols_out";

						$f_cols_in = "coalesce(sum(cri_{$f_row}_f{$j}),0)";
						$f_cols_out = "coalesce(sum(oui_{$f_row}_f{$j}),0)";
						$f_cols = "$f_cols_in + $f_cols_out";
						
						$m_total_sum_in = "coalesce(sum(cri_r5_f{$j} + cri_r11_f{$j} + cri_r17_f{$j} + cri_r23_f{$j}),0)";
						$f_total_sum_in = "coalesce(sum(cri_r6_f{$j} + cri_r12_f{$j} + cri_r18_f{$j} + cri_r24_f{$j}),0)";
						$m_total_sum_out = "coalesce(sum(oui_r5_f{$j} + oui_r11_f{$j} + oui_r17_f{$j} + oui_r23_f{$j}),0)";
						$f_total_sum_out = "coalesce(sum(oui_r6_f{$j} + oui_r12_f{$j} + oui_r18_f{$j} + oui_r24_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "$m_total_sum_in + $m_total_sum_out";
						$f_total_sum = "$f_total_sum_in + $f_total_sum_out";
					}
					if($in_out_coverage == 'out_district'){
						$m_cols = "coalesce(sum(od_{$m_row}_f{$j}),0)";
						$f_cols = "coalesce(sum(od_{$f_row}_f{$j}),0)";
						/* for total vaccination column (updated on 30-04-2019) */
						$m_total_sum = "coalesce(sum(od_r5_f{$j} + od_r11_f{$j} + od_r17_f{$j} + od_r23_f{$j}),0)";
						$f_total_sum = "coalesce(sum(od_r6_f{$j} + od_r12_f{$j} + od_r18_f{$j} + od_r24_f{$j}),0)";
					}
					$t_cols = "$m_cols + $f_cols";
					$total_vacc_cols = "$m_total_sum + $f_total_sum";
					$show_pl_cba = FALSE;
					break;
				default:
					# code...
					break;
			}
			if($vacc_to == 'gender')
			{
				if($in_out_coverage == 'out_district'){
					$middleQuery .= "
						(select {$m_total_sum} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot_M{$asValueCRI},
						(select {$m_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as M{$asValueCRI},
						round((((select {$m_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$m_total_sum} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as MP{$asValueCRI},
						(select {$f_total_sum} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot_F{$asValueCRI},
						(select {$f_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as F{$asValueCRI},
						round((((select {$f_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$f_total_sum} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as FP{$asValueCRI},";
				}				
				else{
					$middleQuery .= "
						(select {$m_total_sum} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot_M{$asValueCRI},
						(select {$m_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as M{$asValueCRI},
						round((((select {$m_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$m_total_sum} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as MP{$asValueCRI},
						(select {$f_total_sum} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot_F{$asValueCRI},
						(select {$f_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as F{$asValueCRI},
						round((((select {$f_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$f_total_sum} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as FP{$asValueCRI},";
				}
			}
			elseif($vacc_to == 'total_children')
			{
				if($in_out_coverage == 'out_district'){
					$middleQuery .= "
						(select {$total_vacc_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot{$asValueCRI},
						(select {$t_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as T{$asValueCRI},
						round((((select {$t_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$total_vacc_cols} from fac_mvrf_od_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as P{$asValueCRI},";
				}
				else{
					$middleQuery .= "
						(select {$total_vacc_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as Tot{$asValueCRI},
						(select {$t_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy} ) as T{$asValueCRI},
						round((((select {$t_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy})//(select {$total_vacc_cols} from fac_mvrf_db where {$whereCondition} {$fmonthCondition} {$groupBy}))*100)::numeric,1) as P{$asValueCRI},";
				}
			}
		}
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
		$result['vaccinationtype'] = $data['vaccination_type'];
		return $result;
	}
	//======= New Report function starts here =======//
	public function hf_consumption_requisition($data)
	{
		/////////////new code By usama sher khan  start///////
		//code update by omer:for kpk new table format 
		$new_date_from = $data['monthfrom'];
		$new_date_to = $data['monthto'];
		$wc[]=null;
		if(isset($data['tcode']) && $data['tcode'] > 0){
			$wc[] = " tcode = '".$data['tcode']."' ";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0 && $data['uncode']!=''){
			$wc[] = " uncode = '".$data['uncode']."' ";
		}
		if(isset($data['facode']) && $data['facode'] > 0 && $data['facode']!=''){
			$wc[] = " facode = '".$data['facode']."' ";
		}
		if(isset($data['monthfrom']) && $data['monthfrom'] != ''){
			
			$wc1[] = " fmonth >= '$new_date_from' ";
		}
		if(isset($data['monthto']) && $data['monthto'] != ''){
			$wc1[] = " fmonth <= '$new_date_to' ";
		}
	   	if(isset($data['distcode']) && $data['distcode'] > 0)
		{
			$wc[] = " distcode = '".$data['distcode']."' ";
		}
		
		$whereCondition=((!empty($wc1)) ? implode(' AND ', $wc1) : '' );	
		$whereCondition.=((!empty($wc)) ? implode(' AND ', $wc) : '' );	
		//print_r($whereCondition);print_r($wc1);
			$this->db->select("epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,
					round(coalesce(sum(case when fmonth = '$new_date_from' then epi_consumption_detail.opening_doses Else 0 End),0),1) as opening,
					round(coalesce(sum(epi_consumption_detail.received_doses),0),1) as received,
					sum(coalesce(epi_consumption_detail.vaccinated,0)) as children_vaccinated, 
					sum(coalesce(epi_consumption_detail.used_doses,0)) as useddose, 
					sum(coalesce(epi_consumption_detail.used_vials,0)) as usedvials, 
					sum(coalesce(epi_consumption_detail.unused_doses,0)) as unuseddose,
					sum(coalesce(epi_consumption_detail.unused_vials,0)) as unusedvials");
					//sum(coalesce(case when fmonth = '$new_date_to' then epi_consumption_detail.closing_vials Else 0 End,0)) as closing ");
			$this->db->from('epi_consumption_master');
			$this->db->join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this->db->join("epi_item_pack_sizes ips","epi_consumption_detail.item_id = ips.pk_id");
			$this->db->where($whereCondition);
			$this->db->where('ips.item_category_id <> 4');
			$this->db->where('ips.activity_type_id=1');
			$this->db->where("epi_consumption_master.is_compiled",1);
			$this->db->group_by(' epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,ips.list_rank');
			$this->db->order_by('ips.list_rank');
			$result['consumption']=$this -> db -> get() -> result_array();
			if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Consumption_Requisition_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Consolidated Consumption and Requisition Report';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		$result['datefrom'] = $new_date_from;
		$result['dateto'] = $new_date_to;
		//print_r($result);exit;
		return $result; 
			//echo $this->db->last_query();exit;
			 
			/* $d = "select epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,
				round(coalesce(sum(case when fmonth='2019-01' then epi_consumption_detail.opening_doses else 0 end)/ips.number_of_doses,0),1) as opening,
				round(coalesce(sum(epi_consumption_detail.received_doses)/ips.number_of_doses,0),1) as received, 
				sum(epi_consumption_detail.used_vials) as used, 
				sum(epi_consumption_detail.unused_vials) as unused,
				sum(case when fmonth='2019-02' then epi_consumption_detail.closing_vials else 0 end) as closing 
				from epi_consumption_master 
				join epi_consumption_detail on epi_consumption_detail.main_id = epi_consumption_master.pk_id 
				join epi_item_pack_sizes ips on epi_consumption_detail.item_id = ips.pk_id 
				where fmonth between '2019-01' and '2019-02' and procode = '3' and ips.item_category_id <> 4 and ips.activity_type_id = 1 
				group by  epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,ips.list_rank
				order by ips.list_rank"; */
				//echo $d;exit;
			
	/* 	
	   ////////////////end////////////// 
	   $result = $this-> db -> query($queryForYearlyData) -> result_array();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Consumption_Requisition_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Consolidated Consumption and Requisition Report';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		$result['datefrom'] = $new_date_from;
		$result['dateto'] = $new_date_to;
		$result['Name'] = $items_doses;
		//print_r($result);exit;
		return $result; */
	}
	
	/* 
	//print_r($criNames1);exit;
	//print_r($criNames1[0]['item_name']);exit;
		$criNames=array("BCGOB","BCGR","BCGUSE","BCGUNUSE","BCGCB","BCGRIP",
					"DILBCGOB","DILBCGR","DILBCGUSE","DILBCGUNUSE","DILBCGCB","DILBCGRIP",
					"bOPVOB","bOPVR","bOPVUSE","bOPVUNUSE","bOPVCB","bOPVRIP",
					"pentavalentOB","pentavalentR","pentavalentUSE","pentavalentUNUSE","pentavalentCB","pentavalentRIP",
					"PneumococcalOB","PneumococcalR","PneumococcalUSE","PneumococcalUNUSE","PneumococcalCB","PneumococcalRIP",
					"MeaslesOB","MeaslesR","MeaslesUSE","MeaslesUNUSE","MeaslesCB","MeaslesRIP",
					"DILMeaslesOB","DILMeaslesR","DILMeaslesUSE","DILMeaslesUNUSE","DILMeaslesCB","DILMeaslesRIP",
					"TT10OB","TT10R","TT10USE","TT10UNUSE","TT10CB","TT10RIP",
					"TT20B","TT20R","TT20USE","TT20UNUSE","TT20CB","TT20RIP",
					"HBVOB","HBVR","HBVUSE","HBVUNUSE","HBVCB","HBVRIP",
					"IPVOB","IPVR","IPVUSE","IPVUNUSE","IPVCB","IPVRIP");
		//print_r($data);exit;
		$sizeCriNames=sizeof($criNames);
		//echo $sizeCriNames;exit;
		if(isset($data['distcode']) && $data['distcode'] > 0)
		{
			$queryForYearlyData="select ";		
			$counter=0;
			for($i=1;$i<=$sizeCriNames/6;$i++)
			{
				for($j=1;$j<=((sizeof($criNames)/11)+1);$j++)
				{
					
					if($counter < 66){
						($j==3)?$j++:'';
						$j=($j==7
						)?1:$j;
						$asValueCRI=$criNames[$counter];
						
				    //$asValueCRI=$criNames[$counter]['item_name'];
					//echo $asValueCRI;exit;
						$k=$j;
						if (strstr($asValueCRI,'OB'))
							$j=100;
						if($j == 1){
							
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where districts.distcode=form_b_cr.distcode and  fmonth = '$new_date_from' ".((!empty($wc)) ?  ' AND ' . implode(' AND ', $wc) : '' ).") as $asValueCRI,";
						
						
						}else If($j == 6){
							
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where districts.distcode=form_b_cr.distcode and  fmonth = '$new_date_to' ".((!empty($wc)) ?  ' AND ' . implode(' AND ', $wc) : '' ).") as $asValueCRI,";
						
						}
						else if ($j==100)
						{
							$j = 6;
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where districts.distcode=form_b_cr.distcode and  fmonth = '$new_dat_from' ".((!empty($wc)) ?  ' AND ' . implode(' AND ', $wc) : '' ).") as $asValueCRI,";
						}
						else{
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where districts.distcode=form_b_cr.distcode ".((!empty($wc)) ?  ' AND ' . implode(' AND ', $wc) : '' ).((!empty($wc1)) ?  ' AND ' . implode(' AND ', $wc1) : '' ).") as $asValueCRI,";
						}
						$j=$k;
					   //$i=($j==7)?$i++:$j;
                        if ($j==6){
							
							$i++; 
							}						
					}
					$counter++;
				}print_r($queryForYearlyData);
			}exit;
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData.=" from districts where distcode = '".$data['distcode']."'";
			//print_r($queryForYearlyData);
		}  */
		
		
		
		/* else
		{
			$queryForYearlyData="select ";			
			$counter=0;
			for($i=1;$i<=$sizeCriNames/6;$i++)
			{
				for($j=1;$j<=((sizeof($criNames)/11)+1);$j++)
				{ 
					if($counter < 66){
						($j==3)?$j++:'';
						$j=($j==7)?6:$j;
						$asValueCRI=$criNames[$counter];
						$k=$j;
						if (strstr($asValueCRI,'OB'))
							$j=100;
						if($j == 1){
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where form_b_cr.procode='".$_SESSION["Province"]."' and  fmonth = '$new_date_from' ) as $asValueCRI,";
						}else If($j == 6){
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where form_b_cr.procode='".$_SESSION["Province"]."' and  fmonth = '$new_date_to' ) as $asValueCRI,";
						}
						else if ($j==100)
						{
							$j=6;
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where form_b_cr.procode='".$_SESSION["Province"]."' and  fmonth = '$new_dat_from' ".((!empty($wc)) ?  ' AND ' . implode(' AND ', $wc) : '' ).") as $asValueCRI,";
						}
						else{
							$queryForYearlyData .= "
							(select sum(cr_r".$i."_f".$j.") from form_b_cr where form_b_cr.procode='".$_SESSION["Province"]."' ".((!empty($wc1)) ? ' AND ' . implode(' AND ', $wc1) : '' ).") as $asValueCRI,";
						}
						$j=$k;
					}
					$counter++;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData.=" from districts limit 1";
			
		} */
		
	//------------------ OLD Code for the report------------------------------//
	/* public function hf_consumption_requisition($data)
	{
		//posted values from last page		
		$date_from = explode("-",$data['monthfrom']); // split
		$new_date_from = $date_from[1]."-".$date_from[0];
		$date_to = explode("-",$data['monthto']); // split
		$new_date_to = $date_to[1]."-".$date_to[0];
		if(isset($data['distcode']) && $data['distcode'] > 0){
			$wc[] = " distcode = '".$data['distcode']."' ";
		}
		if(isset($data['tcode']) && $data['tcode'] > 0){
			$wc[] = " tcode = '".$data['tcode']."' ";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0 && $data['uncode']!=''){
			$wc[] = " uncode = '".$data['uncode']."' ";
		}
		if(isset($data['monthfrom']) && $data['monthfrom'] != ''){
			$wc1[] = " fmonth >= '$new_date_from' ";
		}
		if(isset($data['monthto']) && $data['monthto'] != ''){
			$wc1[] = " fmonth <= '$new_date_to' ";
		}
		$criNames=array("BCGOB","BCGR","BCGUSE","BCGUNUSE","BCGCB",
					"DILBCGOB","DILBCGR","DILBCGUSE","DILBCGUNUSE","DILBCGCB",
					"bOPVOB","bOPVR","bOPVUSE","bOPVUNUSE","bOPVCB",
					"pentavalentOB","pentavalentR","pentavalentUSE","pentavalentUNUSE","pentavalentCB",
					"PneumococcalOB","PneumococcalR","PneumococcalUSE","PneumococcalUNUSE","PneumococcalCB",
					"MeaslesOB","MeaslesR","MeaslesUSE","MeaslesUNUSE","MeaslesCB",
					"DILMeaslesOB","DILMeaslesR","DILMeaslesUSE","DILMeaslesUNUSE","DILMeaslesCB",
					"TT10OB","TT10R","TT10USE","TT10UNUSE","TT10CB",
					"TT20B","TT20R","TT20USE","TT20UNUSE","TT20CB",
					"HBVOB","HBVR","HBVUSE","HBVUNUSE","HBVCB",
					"IPVOB","IPVR","IPVUSE","IPVUNUSE","IPVCB");
		$sizeCriNames=sizeof($criNames);
		if(isset($data['distcode']) && $data['distcode'] > 0)
		{
			$queryForYearlyData="select facode,facilityname(facode),";		
			$counter=0;
			for($i=1;$i<=$sizeCriNames/5;$i++)
			{
				for($j=1;$j<=((sizeof($criNames)/11)+1);$j++)
				{
					if($counter < 55){
						($j==3)?$j++:'';
						$asValueCRI=$criNames[$counter];
						$queryForYearlyData .= "
						(select sum(cr_r".$i."_f".$j.") from form_b_cr where facilities.facode=form_b_cr.facode ".((!empty($wc1)) ?  ' AND ' . implode(' AND ', $wc1) : '' ).") as $asValueCRI,";
					}
					$counter++;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData.=" from facilities".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."";
		}
		else
		{
			$queryForYearlyData="select distcode,districtname(distcode),";			
			$counter=0;
			for($i=1;$i<=$sizeCriNames/5;$i++)
			{
				for($j=1;$j<=((sizeof($criNames)/11)+1);$j++)
				{
					if($counter < 55)
					{
						($j==3)?$j++:'';
						$asValueCRI=$criNames[$counter];
						$queryForYearlyData .= "
						(select sum(cr_r".$i."_f".$j.") from form_b_cr where districts.distcode=form_b_cr.distcode ".((!empty($wc1)) ? ' AND ' . implode(' AND ', $wc1) : '' ).") as $asValueCRI,";
					}
					$counter++;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData.=" from districts";
		}
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'HF consumption and Requisition Report';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		return $result;
	} */
	//-----------------------------------------------------------------------------------------------//
	//======= AEFI Compliance Report Function Starts Here =======//
	public function aefi_compliance($code=NULL,$year=NULL){
		$data = posted_Values();//posted values from last page
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["year"] = $year;
		}	
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$year = $data['year'];
		$mon = "";
		if(isset($data['uncode'])){
			$wc[] = "uncode = '".$data["uncode"]."'";
			$wc[] = "rep_date::text like '".$data["year"]."-%'";
			//case when uc selected or uc leve user logged in
			$queryForYearlyData = "select 'AEFI-' || id as \"Case Code\",casename as \"Name\",age as \"Age\",unname(uncode) as \"Union Council\",tehsilname(tcode) as \"Tehsil\",		
			trim(trailing ', ' from  
				case when mc_bcg = 1 then 'BCG Lymphadenitis , ' else '' END || 
				case when mc_convulsion = 1 then 'Convulsion , ' else '' END || 
				case when mc_severe = 1 then 'Severe Local Reaction , ' else '' END || 
				case when mc_unconscious = 1 then 'Unconsciousness , ' else '' END || 
				case when mc_abscess = 1 then 'Injection site abscess , ' else '' END || 
				case when mc_respiratory = 1 then 'Respiratory Distress , ' else '' END || 
				case when mc_fever = 1 then 'Fever , ' else '' END || 
				case when mc_swelling = 1 then 'Swelling of body or face , ' else '' END || 
				case when mc_rash = 1 then 'Rash , ' else '' END || 
				case when mc_other = '' then '' else mc_other END
			) as \"Complaints\",		
			vacc_name as \"Vaccines Received\",vacc_vaccinator as \"Vaccinator\", rep_date as \"Report Date\" from aefi_rep ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$result1 = showListingReport($result);
		}else if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select uc.uncode as \"Uncode\", unname(uc.uncode) as \"Union Council\" ,tehsilname(uc.tcode) as \"Tehsil\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from aefi_rep where rep_date::text like '$year-$mon-%' and uncode = uc.uncode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from aefi_rep where rep_date::text like '$year-%' and uncode = uc.uncode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from unioncouncil uc ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by uncode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select \' \' as tehsiltot, ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		else
		{
			//case when district not selected mean provincial user logged in
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select dist.distcode as \"Distcode\", districtname(dist.distcode) as \"District\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from aefi_rep where rep_date::text like '$year-$mon-%' and distcode = dist.distcode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from aefi_rep where rep_date::text like '$year-%' and distcode = dist.distcode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by distcode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Adverse_Event_Following_Immunization_compliance_report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Adverse Event Following Immunization Compliance Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= AEFI Compliance Report Function Ends Here ========//
	//======= UC/flcf wise Vaccination Coverage compliance Report Function Starts Here =======//
	public function flcf_vacc_coverage_compliance(){
		$data = posted_Values();//posted values from last page
		//print_r($data);exit;
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$year = $data['year'];
		$mon = "";
		if($data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " CASE WHEN CAST((select facode  from flcf_vacc_mr where fmonth = '$year-$mon' and facode = flcf1.facode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS $asValueHead, ";
				$allTotalPortion .= "sum(" . $headNames[$i - 1] . ") as total$i,";
				$i++;
				//$queryForYearlyData .= "(select coalesce(sum(cri_r".$i."_f13),0)+coalesce(sum(cri_r".$i."_f14),0) from flcf_vacc_mr where facode=flcf1.facode and fmonth like '$year-%' ) as $asValueHead, ";
				//$rightTotalImmun .= "$asValueHead+";
			}
			$asValueHead=$headNames[$i-1];
			$queryForYearlyData .= " (select count(facode)  from flcf_vacc_mr where fmonth like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from facilities flcf1 where hf_type='e' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by facode";
			$allTotalPortion .= "sum(total) as total$i ";
			//echo $queryForYearlyData;exit();
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);
		}
		else
		{
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			//case when district not selected mean provincial user logged in
			$includePercentPortion 	= "";
			$queryForYearlyData 	= "";
			$endTotalPortion 		= "";
			$queryForMonthlyData	= "select distcode, districtname(distcode) as district , ";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$queryForMonthlyData 	.= " (select count(facode) from facilities where distcode = dist.distcode and hf_type='e') AS due".$mon.", ";
				$queryForMonthlyData 	.= " (select count(facode) from flcf_vacc_mr where fmonth = '$year-$mon' and distcode = dist.distcode) AS sub".$mon.", ";
				$includePercentPortion 	.= "due$mon,sub$mon, round((sub$mon::float//due$mon)::numeric*100,0) as \"%$mon\",";
				$endTotalPortion 		.= "sum(due$mon) as totalDue$mon,sum(sub$mon) as totalSub$mon, round((sum(sub$mon)::float//sum(due$mon))::numeric*100,1) as TotalPerc$mon,";
				$i++;
			}
			$mon = sprintf("%02d", $i);
			$queryForMonthlyData 	.= " (select round(count(facode)::numeric*12,0) from facilities where distcode = dist.distcode and hf_type='e') AS due".$mon.", ";
			$queryForMonthlyData 	.= " (select count(facode) from flcf_vacc_mr where fmonth like '$year-%' and distcode = dist.distcode) AS sub".$mon;
			$includePercentPortion 	.= "due$mon,sub$mon, round((sub$mon::float//due$mon)::numeric*100,0) as \"%$mon\"";
			$endTotalPortion 		.= "sum(due$mon) as totalDue$mon,sum(sub$mon) as totalSub$mon, round((sum(sub$mon)::float//sum(due$mon))::numeric*100,1) as TotalPerc$mon";
			$queryForMonthlyData 	.= " from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by distcode";
			$queryForYearlyData 	.= 'select distcode  , district,  ' . $includePercentPortion. ' from (' . $queryForMonthlyData . ') as a';
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$result 			= $this-> db -> query($queryForYearlyData) -> result_array();
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $endTotalPortion . ' from (' . $queryForMonthlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal) -> row_array();
			$result1 			= getPROComplianceFMVRReportTable($result,$resultTotal);
		}
		//$queryForTotal = "select *,$rightTotalImmun as totalimmun,$rightTotalTT as totalTT from ($queryForYearlyData) as b";
		//$result = $this-> db -> query($queryForTotal) -> result_array();
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Compliance_for_Facility_Wise_Vaccination_Coverage_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Facility Wise Vaccination Coverage Compliance Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= UC wise Vaccination Coverage for Children and Women Report Function Ends Here ========//
	public function Weekly_VPD_Compilation($wc,$fweek){
		$query = "select sum(afp) as afp,sum(measles) as measles,sum(nt) as nnt,sum(diphtheria) as diptheria,sum(pertussis) as pertusis,sum(childhood_tb) as ch_tb  from weekly_vpd  ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and fweek LIKE '$fweek' ";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['upperPortion'] = $result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Weekly_VPD_Compilation_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e'";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		$queryFLCF = "select count(facode) as cnt from weekly_vpd   ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and fweek LIKE '$fweek' ";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['reportingFLCF'] = $result['cnt'];
		$query = "select * from weekly_vpd  ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and fweek LIKE '$fweek' ";
		$result = $this -> db -> query($query);
		$result = $result -> row_array();
		$data['downPortion'] = $result;
		$wc = str_replace("procode","weekly_vpd_cases.procode",$wc);
		$wc = str_replace("distcode","weekly_vpd_cases.distcode",$wc);
	    $query = "select weekly_vpd_cases.* , tehsilname(weekly_vpd.tcode) as t_name, facilityname(weekly_vpd.facode) as fac_name, unname(weekly_vpd.uncode) as un_name
		from weekly_vpd_cases left join weekly_vpd on weekly_vpd.recid= weekly_vpd_cases.vpd_id  ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and weekly_vpd_cases.fweek LIKE '$fweek' ";
		$result = $this -> db -> query($query);
		$data['tableResult'] = $result = $result -> result_array();
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	public function Weekly_AEFI_Compilation($wc,$dateFrom,$dateTo){
		$query = "select * from aefi_rep  ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and date_from >= '$dateFrom' and date_to <= '$dateTo'";
		$result = $this -> db -> query($query);
		$data['tableResult'] = $result = $result -> result_array();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Weekly_VPD_Compilation_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	public function formA1Compliance($dateFrom,$dateTo,$distcode){
		$query = "select form_date as \"Form Date\",distcode as \"Distcode\", districtname(distcode) as \"District\" from form_a1_stock where distcode='$distcode' and form_date >= '$dateFrom' and form_date <= '$dateTo' order by form_date desc";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data['htmlData'] = showListingReport($result);
		$data['exportIcons']=exportIcons($_REQUEST);
		$subTitle = "Form A-I Stock Issue & Receipt Voucher Report";
		$data['TopInfo'] = tableTopInfo($subTitle, $distcode);
		return $data;
	}
	public function formA2Compliance($dateFrom,$dateTo,$distcode){
		$query = "select form_date as \"Form Date\",facode as \"FLCF Code\", facilityname(facode) as \"Facility Name\" from form_a2_stock where distcode='$distcode' and form_date >= '$dateFrom' and form_date <= '$dateTo' order by form_date desc";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data['htmlData'] = showListingReport($result);
		$data['exportIcons']=exportIcons($_REQUEST);
		$subTitle = "Form A-II Stock Issue & Receipt Voucher Report";
		$data['TopInfo'] = tableTopInfo($subTitle, $distcode);
		return $data;
	}
	public function formCCompliance($dateFrom,$dateTo,$distcode){
		$query = "select campaign_type as \"Campaign Type\",start_date as \"Start Date\",end_date as \"End Date\",uncode as \"UC Code\", unname(uncode) as \"UC Name\" from form_c_demand where distcode='$distcode' and start_date >= '$dateFrom' and end_date <= '$dateTo' order by start_date desc";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data['htmlData'] = showListingReport($result);
		$data['exportIcons']=exportIcons($_REQUEST);
		$subTitle = "Form C Demand, Consumption & Receipt Report";
		$data['TopInfo'] = tableTopInfo($subTitle, $distcode);
		return $data;
	}
	public function formBCompliance(){
		$data = posted_Values();//posted values from last page
		//print_r($data);exit;
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$year = $data['year'];
		$mon = "";
		if($data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " CASE WHEN CAST((select facode  from form_b_cr where fmonth = '$year-$mon' and facode = flcf1.facode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS $asValueHead, ";
				$allTotalPortion .= "sum(" . $headNames[$i - 1] . ") as total$i,";
				$i++;
				//$queryForYearlyData .= "(select coalesce(sum(cri_r".$i."_f13),0)+coalesce(sum(cri_r".$i."_f14),0) from flcf_vacc_mr where facode=flcf1.facode and fmonth like '$year-%' ) as $asValueHead, ";
				//$rightTotalImmun .= "$asValueHead+";
			}
			$asValueHead=$headNames[$i-1];
			$queryForYearlyData .= " (select count(facode)  from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from facilities flcf1 where hf_type='e' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by facode";
			$allTotalPortion .= "sum(total) as total$i ";
			//echo $queryForYearlyData;exit();
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);
		}
		else
		{
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			//case when district not selected mean provincial user logged in
			$includePercentPortion 	= "";
			$queryForYearlyData 	= "";
			$endTotalPortion 		= "";
			$queryForMonthlyData	= "select distcode, districtname(distcode) as district , ";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$queryForMonthlyData 	.= " (select count(facode) from facilities where distcode = dist.distcode and hf_type='e') AS due".$mon.", ";
				$queryForMonthlyData 	.= " (select count(facode) from form_b_cr where fmonth = '$year-$mon' and distcode = dist.distcode) AS sub".$mon.", ";
				$includePercentPortion 	.= "due$mon,sub$mon, round((sub$mon::float//due$mon)::numeric*100,0) as \"%$mon\",";
				$endTotalPortion 		.= "sum(due$mon) as totalDue$mon,sum(sub$mon) as totalSub$mon, round((sum(sub$mon)::float//sum(due$mon))::numeric*100,1) as TotalPerc$mon,";
				$i++;
			}
			$mon = sprintf("%02d", $i);
			$queryForMonthlyData 	.= " (select round(count(facode)::numeric*12,0) from facilities where distcode = dist.distcode and hf_type='e') AS due".$mon.", ";
			$queryForMonthlyData 	.= " (select count(facode) from form_b_cr where fmonth like '$year-%' and distcode = dist.distcode) AS sub".$mon;
			$includePercentPortion 	.= "due$mon,sub$mon, round((sub$mon::float//due$mon)::numeric*100,0) as \"%$mon\"";
			$endTotalPortion 		.= "sum(due$mon) as totalDue$mon,sum(sub$mon) as totalSub$mon, round((sum(sub$mon)::float//sum(due$mon))::numeric*100,1) as TotalPerc$mon";
			$queryForMonthlyData 	.= " from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by distcode";
			$queryForYearlyData 	.= 'select distcode  , district,  ' . $includePercentPortion. ' from (' . $queryForMonthlyData . ') as a';
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$result 			= $this-> db -> query($queryForYearlyData) -> result_array();
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $endTotalPortion . ' from (' . $queryForMonthlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal) -> row_array();
			$result1 			= getPROComplianceFMVRReportTable($result,$resultTotal);
		}
		//$queryForTotal = "select *,$rightTotalImmun as totalimmun,$rightTotalTT as totalTT from ($queryForYearlyData) as b";
		//$result = $this-> db -> query($queryForTotal) -> result_array();
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Form_B_Compliance_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Form B (EPI) Compliance Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//-----------------------------------------------------------------------------------------------//
	//======= Measles Investigation Compliance Report Function Starts Here =======//
	public function MeaslesInvestigationCompliance($code=NULL,$year=NULL){
		$data = posted_Values();//posted values from last page
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["year"] = $year;
		}	
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$year = $data['year'];
		$mon = "";
		if(isset($data['uncode'])){
			$wc[] = "uncode = '".$data["uncode"]."'";
			$wc[] = "reported_by_date::text like '".$data["year"]."-%'";
			//case when uc selected or uc leve user logged in
			$queryForYearlyData = "select 'Investigation-' || id as \"Investigation ID\",facode as \"FLCF Code\", facilityname(facode) as \"FLCF Name\",case_epi_no as \"Case EPID No.\",patient_name as \"Patient Name\",patient_dob as \"Date of Birth\",unname(uncode) as \"Union Council\",tehsilname(tcode) as \"Tehsil\",		
			lab_test_date as \"Date of Lab Test\",		
			report_sent_by_date as \"Report Sent Date\",reported_by_name as \"Reported by Name\", reported_by_date as \"Report Date\" from measle_case_investigation ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$result1 = showListingReport($result);
		}else if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select uc.uncode as \"Uncode\", unname(uc.uncode) as \"Union Council\" ,tehsilname(uc.tcode) as \"Tehsil\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from measle_case_investigation where reported_by_date::text like '$year-$mon-%' and uncode = uc.uncode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from measle_case_investigation where reported_by_date::text like '$year-%' and uncode = uc.uncode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from unioncouncil uc ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by uncode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select \' \' as tehsiltot, ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		else
		{
			//case when district not selected mean provincial user logged in
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select dist.distcode as \"Distcode\", districtname(dist.distcode) as \"District\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from measle_case_investigation where reported_by_date::text like '$year-$mon-%' and distcode = dist.distcode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from measle_case_investigation where reported_by_date::text like '$year-%' and distcode = dist.distcode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by distcode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Measle_Case_Investigation_Compliance_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Measle Case Investigation Compliance Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= Measles Investigation Compliance Report Function Ends Here ========//
	//======= NNT Investigation Compliance Report Function Starts Here =======//
	public function NNTInvestigationCompliance($code=NULL,$year=NULL){
		$data = posted_Values();//posted values from last page
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["year"] = $year;
		}	
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		$year = $data['year'];
		$mon = "";
		if(isset($data['uncode'])){
			$wc[] = "uncode = '".$data["uncode"]."'";
			$wc[] = "date_notification::text like '".$data["year"]."-%'";
			//case when uc selected or uc leve user logged in
			$queryForYearlyData = "select 'Investigation-' || id as \"Investigation ID\",case_epi_no as \"Case EPID No.\",facode as \"FLCF Code\", facilityname(facode) as \"FLCF Name\",unname(uncode) as \"UC Name\",tehsilname(tcode) as \"Tehsil Name\",reported_from as \"Reported From\",investigated_by as \"Investigated by\"		
			from nnt_investigation_form ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$result1 = showListingReport($result);
		}else if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select uc.uncode as \"Uncode\", unname(uc.uncode) as \"Union Council\" ,tehsilname(uc.tcode) as \"Tehsil\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from nnt_investigation_form where date_notification::text like '$year-$mon-%' and uncode = uc.uncode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from nnt_investigation_form where date_notification::text like '$year-%' and uncode = uc.uncode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from unioncouncil uc ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by uncode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select \' \' as tehsiltot, ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		else
		{
			//case when district not selected mean provincial user logged in
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			$allTotalPortion="'' as tot,";
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Total");
			$queryForYearlyData="select dist.distcode as \"Distcode\", districtname(dist.distcode) as \"District\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				$asValueHead=$headNames[$i-1].$mon;
				$queryForYearlyData .= " (select count(*) from nnt_investigation_form where date_notification::text like '$year-$mon-%' and distcode = dist.distcode) AS $asValueHead, ";
				$allTotalPortion .= "sum(" .$asValueHead. ") as total$i,";
				$i++;
			}
			$asValueHead=$headNames[$i-1].$mon;
			$queryForYearlyData .= " (select count(*)  from nnt_investigation_form where date_notification::text like '$year-%' and distcode = dist.distcode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by distcode";
			$allTotalPortion .= "sum(" .$asValueHead. ") as total$i ";
			$result = $this-> db -> query($queryForYearlyData) -> result_array();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $queryForYearlyData . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();			
			$result1 = showCountsComplianceReport($result,$data['allDataTotal']);
		}
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=NNT_Case_Investigation_Compliance_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'NNT Case Investigation Compliance Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= Measles Line List Report Function Starts Here ========//
	public function measlesLineList($wc,$tcode,$uncode,$datefrom,$dateto){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		if($datefrom != ''){
			$wc[] = " reported_by_date >= '$datefrom' ";
		}
		if($dateto != ''){
			$wc[] = " reported_by_date <= '$dateto' ";
		}
		if($datefrom == '' && $datefrom == ''){
			$wc[] = " reported_by_date::text like '".date('Y')."-%'";
		}
		$queryForYearlyData = "select 'Investigation-' || id as \"Investigation ID\",facode as \"FLCF Code\", facilityname(facode) as \"FLCF Name\",patient_name || ' ' || patient_fathername  \"Name of Case & Father Name\",case_epi_no as \"Case EPID #\",COALESCE(age_years*12, 0)+COALESCE(age_months,0) as \"Age in Months\",patient_gender as \"Sex\",patient_address as \"Address of child House#/Street# etc\",doses_received as \"# of Measles vaccine doses received\",'' as \"Date of Last Measle Does\",
								date_rash_onset as \"Date of Rash Onset\",lab_specimen_type as \"Type of specimen\",lab_specimen_received_date as \"Date of specimen\",followup_date as \"Date of follow up\",outcome as \"Complication\",'' as \"Death Date\"
								from measle_case_investigation ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$result1 = showListingReport($result);
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Measles_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Measles Outbreak Investigation Line List Report';
		//echo $data['distcode'];exit;
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
		//======= Diptheria Line List Report Function Starts Here ========//
	public function diptheriaLineList($wc,$tcode,$uncode,$year,$month){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		$date_submitted = $year."-".$month;
		if($date_submitted != ''){
			$wc[] = " date_submitted::text like '".$year."-$month-%'";
		}
		$queryForYearlyData = "select districtname(distcode) as \"District\",
		tehsilname(tcode), unname(uncode),village_mahalla,date_investigation,
		investigation_by ,fname_father ,case_epi_no ,age_in_months ,gender,
		child_address,vacc_dose_no,date_last_dose,date_rash_onset,date_collection_blood,
		date_collection_throat,date_follow_up ,complication ,date_submitted,date_death
		from diphtheria_outbreak_linelist ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$data["tableData"]=$result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Diphtheria_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Diptheria Outbreak Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
		//======= Pneumonia Line List Report Function Starts Here ========//
	public function pneumoniaLineList($wc,$tcode,$uncode,$year,$month){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		$date_submitted = $year."-".$month;
		if($date_submitted != ''){
			$wc[] = " date_submitted::text like '".$year."-$month-%'";
		}
		$queryForYearlyData = "select districtname(distcode) as \"District\",
		tehsilname(tcode), unname(uncode),village_mahalla,date_investigation,
		investigation_by ,fname_father ,case_epi_no ,age_in_months ,gender,
		child_address,vacc_dose_no,date_last_dose,date_rash_onset,date_collection_blood,
		date_collection_throat,date_follow_up ,complication ,date_submitted,date_death
		from pneumonia_outbreak_linelist ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$data["tableData"]=$result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Pneumonia_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Pneumonia Outbreak Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= AFP Line List Report Function Starts Here ========//
	public function afpLineList($wc,$tcode,$uncode,$year,$month){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		$date_submitted = $year."-".$month;
		if($date_submitted != ''){
			$wc[] = " date_submitted::text like '".$year."-$month-%'";
		}
		$queryForYearlyData = "select districtname(distcode) as \"District\",
		tehsilname(tcode), unname(uncode),village_mahalla,date_investigation,
		investigation_by ,fname_father ,case_epi_no ,age_in_months ,gender,
		child_address,vacc_dose_no,date_last_dose,date_rash_onset,date_collection_blood,
		date_collection_throat,date_follow_up ,complication ,date_submitted,date_death
		from afp_outbreak_linelist ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$data["tableData"]=$result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=AFP_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'AFP Outbreak Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
		//======= Childhood TB Line List Report Function Starts Here ========//
	public function childhoodTBLineList($wc,$tcode,$uncode,$year,$month){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		$date_submitted = $year."-".$month;
		if($date_submitted != ''){
			$wc[] = " date_submitted::text like '".$year."-$month-%'";
		}
		$queryForYearlyData = "select districtname(distcode) as \"District\",
		tehsilname(tcode), unname(uncode),village_mahalla,date_investigation,
		investigation_by ,fname_father ,case_epi_no ,age_in_months ,gender,
		child_address,vacc_dose_no,date_last_dose,date_rash_onset,date_collection_blood,
		date_collection_throat,date_follow_up ,complication ,date_submitted,date_death
		from childhood_tb_outbreak_linelist ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$data["tableData"]=$result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=ChildhoodTB_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Childhood TB Outbreak Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= Pertussis Line List Report Function Starts Here ========//
	public function pertussisLineList($wc,$tcode,$uncode,$year,$month){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		$date_submitted = $year."-".$month;
		if($date_submitted != ''){
			$wc[] = " date_submitted::text like '".$year."-$month-%'";
		}
		$queryForYearlyData = "select districtname(distcode) as \"District\",
		tehsilname(tcode), unname(uncode),village_mahalla,date_investigation,
		investigation_by ,fname_father ,case_epi_no ,age_in_months ,gender,
		child_address,vacc_dose_no,date_last_dose,date_rash_onset,date_collection_blood,
		date_collection_throat,date_follow_up ,complication ,date_submitted,date_death
		from pertussis_outbreak_linelist ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$data["tableData"]=$result;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Pertussis_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Pertussis Outbreak Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= NNT Line List Report Function Starts Here ========//
	public function nntLineList($wc,$tcode,$uncode,$datefrom,$dateto){
		if($tcode > 0){
			$wc[] = " tcode = '$tcode' ";
		}
		if($uncode > 0){
			$wc[] = " uncode = '$uncode' ";
		}
		if($datefrom != ''){
			$wc[] = " date_notification >= '$datefrom' ";
		}
		if($dateto != ''){
			$wc[] = " date_notification <= '$dateto' ";
		}
		if($datefrom == '' && $datefrom == ''){
			$wc[] = " date_notification::text like '".date('Y')."-%'";
		}
		$queryForYearlyData = "select 'Investigation-' || id as \"Investigation ID\",reported_from as \"Reported From\",case_epi_no as \"Case EPID No.\",'' || ' ' || head_full_name as \"Name & Father's Name\" ,bs_days as \"Age in Days\",gender as \"Sex\",'' as \"Contact #\",house_hold_address as \"Village\" ,districtname(distcode) as \"District\",tehsilname(tcode) as \"Tehsil Name\",unname(uncode) as \"UC Name\",tt_doses_rec_by_mother as \"TT Doses to Mother\",signs_symptoms(id) as \"Signs & Symptons\",'' as \"Date of Onset\",date_notification as \"Date of Notification\",date_investigation as \"Date of Field Investigation\",'' as \"Diagnosed by\",'' as \"Outcome\",pregnancy_visits as \"Antenatal Visits by Mother\",baby_dob as \"Date of Delivery\",'' as \"Delivery Conducted by\",where_baby_delivered as \"Place of Delivery\",'' as \"Instrument used for Cord Cutting\",'' as \"Cord Clamping Material\"		
								from nnt_investigation_form ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." order by id";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		$result1 = showListingReport($result);
		$data["tableData"]=$result1;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=NNT_LineList_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'NNT Line List Report';
		$data['TopInfo'] = tableTopInfo($subTitle);
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= Surveillance Report Function Starts Here ========//
	public function Surveillance($wc){
		$this -> db -> select('districtname(distcode) as district,facilityname(facode) as facility,case_type,epid_no,name_case,case_father_name,case_address,unname(case_uncode) as case_unname,tehsilname(case_tcode) as case_tehsil,districtname(case_distcode) as case_district,case_age,gender,case_date_onset,case_date_investigation,case_tot_vacc_received,case_date_last_dose_received,case_date_specieman,case_representation');
		$this -> db -> from('weekly_vpd');
		$this -> db -> where($wc);
		$this -> db -> order_by('case_type','asc');
		$data['surveillance'] = $this -> db -> get() -> result_array();
		$dist="";
		if($this -> session -> District){
			$distcode = $this -> session -> District;
			$dist=" and distcode='$distcode'";
			$distcc = array('distcode'=>$distcode);
		}
		$queryFLCF = "select count(facode) as cnt from facilities where hf_type='e' $dist";
		$result = $this -> db -> query($queryFLCF);
		$result = $result -> row_array();
		$data['allReportingFLCF'] = $result['cnt'];
		//----------------------------------------------------------------------------------//
		//----------Uper Portion Data form MIS------------//
		$this -> db -> select('case_type as case,count(case_type) as no_of_cases');
		$this -> db -> from('weekly_vpd');
		$this -> db -> where($wc);
		$this -> db -> group_by('case_type');
		$data['upperPortion'] = $this -> db -> get() -> result_array();
		//--------------------------------------------//
		$this -> db -> select('count(facode) as cnt');
		$this -> db -> from('weekly_vpd');
		if($this -> session -> District)
			$this -> db -> where($distcc);
		$result = $this -> db -> get() -> row_array();
		$data['ReportingFLCF'] = $result['cnt'];
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//======= HR Summary Report Report Function Starts Here ========//
	function HR_Summary_Report($data, $title){
		//print_r($data);exit;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HR_Summary_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//$employee_desg  = $this ->input -> post('employee_desg')?$this ->input -> post ('employee_desg') :$_GET['employee_desg'];		
		$employee_desg  = $data['employee_desg'];
		//print_r($employee_desg);exit();
		$tablename=$employee_desg."db";
		$code=$employee_desg."code";
			if($employee_desg=="supervisor"){
				$innerrowName = "Supervisor";
				$subTitle ="Supervisor Listing";				
			}
			else if($employee_desg=="dso"){
				$innerrowName = "District Surveillance Officer";
				$subTitle ="District Surveillance Officer Listing";				
			}
			if($employee_desg=="co"){
				$innerrowName = "Computer Operator";
				$subTitle ="Computer Operator Listing";				
			}
			else if($employee_desg=="technician"){
				$innerrowName = "Technician";
				$subTitle ="EPI Technician Listing";				
			}
			else if($employee_desg=="deo"){
				$innerrowName = "DataEntry Operator";
				$subTitle ="DataEntry Operator Listing";				
			}
			else if($employee_desg=="sk"){
				$innerrowName = "Store Keeper";
				$subTitle ="Store keeper Listing";				
			}
			else if($employee_desg=="med_technician"){
				$code="technician"."code";
				$innerrowName = "HF Incharge";
				$subTitle ="HF Incharge Listing";				
			}
			else{
				$innerrowName = "Driver";
				$subTitle ="Driver Listing";				
			}
		$wc = array(); 
		if(array_key_exists("distcode", $data)){
			$wc[] = "distcode = '". $data['distcode'] . "'";
		}
		if(array_key_exists("tcode", $data)){
			$wc[] = "tcode = '". $data['tcode'] . "'";
		}
		if(array_key_exists("uncode", $data)){
			$wc[] = "uncode = '". $data['uncode'] . "'";
		}
		if(array_key_exists("facode", $data)){
			$wc[] = "facode = '". $data['facode'] . "'";
		}
		$nwc = $wc;
		//print_r($wc);exit();
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		$whereInner = ((!empty($nwc))? 'where '.implode(" AND ",$nwc):'  ');
		$whereand = ((!empty($wc))? 'where '.implode(" AND ",$wc):' where ');
		$whereand .= ((!empty($wc))? 'AND ':'');
		//echo $whereand; exit();
		//print_r($data);exit;
		//$UserLevel = $_SESSION['UserLevel'];
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0 && ($data['employee_desg'] == 'co')){
			$query = 'SELECT '.$tablename.'.facode as "Facility Code", facilityname('.$tablename.'.facode) AS "Facility Name", facilitytype('.$tablename.'.facode) AS "Facility Type", 
			(select count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode) AS "Total Employees",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND
			 e.status = \'Active\') AS "Active",			
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND
			 e.status = \'Terminated\') AS "Terminated",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND
			 e.status = \'Transfered\') AS "Transferred",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND
			 e.status = \'Died\') AS "Died",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND
			 e.status = \'Retired\') AS "Retired",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereInner.' AND e.facode='.$tablename.'.facode AND 
			 e.status <> \'Active\') AS "Total In-Active"			
			FROM '.$tablename.' '.$where.' and codb.facode is not NULL GROUP BY '.$tablename.'.facode'; 
			
			//echo $query;exit;
			
		}
		else{
			$query = 'SELECT '.$tablename.'.distcode, districtname('.$tablename.'.distcode) AS "District",
			(select count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode) AS "Total Employees",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND 
			 e.status = \'Active\') AS "Active",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND
			 e.status = \'Terminated\') AS "Terminated",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND
			 e.status = \'Transfered\') AS "Transferred",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND
			 e.status = \'Died\') AS "Died",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND
			 e.status = \'Retired\') AS "Retired",
			(select distinct count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode AND 
			 e.status <> \'Active\') AS "Total In-Active"			
			FROM '.$tablename.' '.$where.' GROUP BY '.$tablename.'.distcode ';
			
			///echo $query;exit;
		}
		$result=$this->db->query($query);
		$allData = $result->result_array();	
		$data['employee_desg'] = $data['employee_desg'];
		$data['exportIcons'] = exportIcons($_REQUEST);
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['htmlData'] = getListingReportTable($allData,'');
		return $data;
	}
	//======= Retired HR Report Function Starts Here ========//
	function Retired_HR_Report($data, $title){
		//print_r($data);exit;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Retired_HR_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}		
		$hr_type  = $data['hr_type'];
		//print_r($hr_type);exit();
		$tablename=$hr_type."db";
		$code=$hr_type."code";
		if($hr_type=="supervisor"){
			$innerrowName = "Supervisor";
			$subTitle ="Retired Supervisors";				
		}
		else if($hr_type=="dso"){
			$innerrowName = "District Surveillance Officer";
			$subTitle ="Retired District Surveillance Officers";				
		}
		if($hr_type=="co"){
			$innerrowName = "Computer Operator";
			$subTitle ="Retired Computer Operators";				
		}
		else if($hr_type=="technician"){
			$innerrowName = "Technician";
			$subTitle ="Retired EPI Technicians";				
		}
		else if($hr_type=="deo"){
			$innerrowName = "DataEntry Operator";
			$subTitle ="Retired DataEntry Operators";				
		}
		else if($hr_type=="sk"){				
			$innerrowName = "Store Keeper";
			$subTitle ="Retired Store keeper";				
		}
		else if($hr_type=="med_technician"){
			$code="technician"."code";
			$innerrowName = "HF Incharge";
			$subTitle ="Retired HF Incharge";				
		}
		else{
			$innerrowName = "Driver";
			$subTitle ="Retired Driver";				
		}
		$wc = array();
		if(array_key_exists("distcode", $data)){
			$wc[] = "distcode = '". $data['distcode'] . "'";
		}
        $tcode=$this -> session -> Tehsil;
		 if(isset($tcode) AND $tcode > 0){
			$wc[] = "tcode = '". $tcode . "'";
		}
        $nwc = $wc;		
		//print_r($wc);exit();
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		$whereInner = ((!empty($nwc))? 'where '.implode(" AND ",$nwc):'  ');
		$whereand = ((!empty($wc))? 'where '.implode(" AND ",$wc):' where ');
		$whereand .= ((!empty($wc))? 'AND ':'');
		//$where; exit();		
		$age = 'SELECT age(date_of_birth) as age from '.$tablename.'';
		$result=$this->db->query($age);
		$agelimit = $result->result_array();
      // $dob = '1970-02-01';
      // $dob_ex = explode("-",$dob);
      // $age_diff = date_diff(date_create($dob), date_create('today'))->y;
      // $year_of_retire = 50 - $age_diff;
      // $end = date('Y', strtotime('+'.$year_of_retire.'years'));
      // $date_of_retire = $end."-".$dob_ex[1]."-".$dob_ex[2];
      // $data['retiredate'] = $date_of_retire;
      // echo $date_of_retire;
		//print_r($agelimit);exit();
		// if(array_key_exists("distcode", $data) && $data['distcode'] > 0 && ($data['hr_type'] == 'technician' || $data['hr_type'] == 'med_technician')){
		// $ageyears = date("d-m-Y");
		// $gy = $ageyears + 60;
		// echo $gy;
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			if($data['hr_type'] == 'supervisor'){
				$query = 'SELECT '.$tablename.'.supervisorcode as "Supervisor Code", '.$tablename.'.supervisorname AS "Supervisor Name", '.$tablename.'.supervisor_type AS "Supervisor Type", 
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.supervisorcode='.$tablename.'.supervisorcode) AS "Date of Birth",
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.supervisorcode='.$tablename.'.supervisorcode) AS "Supervisor Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.supervisorcode='.$tablename.'.supervisorcode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.supervisorcode='.$tablename.'.supervisorcode) AS "Days Remaining to Retirement"
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.supervisorcode, '.$tablename.'.supervisorname, '.$tablename.'.supervisor_type';
			}
			if($data['hr_type'] == 'dso'){
				$query = 'SELECT '.$tablename.'.dsocode as "District Surveillance Officer Code", '.$tablename.'.dsoname AS "District Surveillance Officer Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.dsocode='.$tablename.'.dsocode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.dsocode='.$tablename.'.dsocode) AS "District Surveillance Officer Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.dsocode='.$tablename.'.dsocode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.dsocode='.$tablename.'.dsocode) AS "Days Remaining to Retirement"		
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.dsocode, '.$tablename.'.dsoname';
			}
			if($data['hr_type'] == 'co'){
				$query = 'SELECT '.$tablename.'.cocode as "Computer Operator Code", '.$tablename.'.coname AS "Computer Operator Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.cocode='.$tablename.'.cocode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.cocode='.$tablename.'.cocode) AS "Computer Operator Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.cocode='.$tablename.'.cocode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.cocode='.$tablename.'.cocode) AS "Days Remaining to Retirement"
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.cocode, '.$tablename.'.coname';
			}
			if($data['hr_type'] == 'med_technician'){
				$query = 'SELECT  '.$tablename.'.techniciancode as "HF Incharge Code", '.$tablename.'.technicianname AS "HF Incharge Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Date of Birth",  
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "HF Incharge Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Days Remaining to Retirement"		
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.techniciancode, '.$tablename.'.technicianname';
			}
			if($data['hr_type'] == 'technician'){
				$query = 'SELECT '.$tablename.'.techniciancode as "Technician Code", '.$tablename.'.technicianname AS "Technician Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Technician Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.techniciancode='.$tablename.'.techniciancode) AS "Days Remaining to Retirement"		
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.techniciancode, '.$tablename.'.technicianname';
			}
			if($data['hr_type'] == 'driver'){
				$query = 'SELECT '.$tablename.'.drivercode as "Driver Code", '.$tablename.'.drivername AS "Driver Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.drivercode='.$tablename.'.drivercode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.drivercode='.$tablename.'.drivercode) AS "Driver Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.drivercode='.$tablename.'.drivercode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.drivercode='.$tablename.'.drivercode) AS "Days Remaining to Retirement"	
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.drivercode, '.$tablename.'.drivername';
			}
			if($data['hr_type'] == 'deo'){
				$query = 'SELECT '.$tablename.'.deocode as "Data Entry Operator Code", '.$tablename.'.deoname AS "Data Entry Operator Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.deocode='.$tablename.'.deocode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.deocode='.$tablename.'.deocode) AS "Data Entry Operator Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.deocode='.$tablename.'.deocode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.deocode='.$tablename.'.deocode) AS "Days Remaining to Retirement"		
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.deocode, '.$tablename.'.deoname';
			}
			if($data['hr_type'] == 'sk'){
				$query = 'SELECT '.$tablename.'.skcode as "Store Keeper Code", '.$tablename.'.skname AS "Store Keeper Name",
				(select to_char(date_of_birth, \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.skcode='.$tablename.'.skcode) AS "Date of Birth", 
				(select age(date_of_birth) from '.$tablename.' e '.$whereInner.' AND e.skcode='.$tablename.'.skcode) AS "Store Keeper Age",
				\'60 years\' AS "Retirement Age",
				(select to_char(date(date_of_birth + interval \'60 year\'), \'DD-MM-YYYY\') from '.$tablename.' e '.$whereInner.' AND e.skcode='.$tablename.'.skcode) AS "Retirement Date",
				(select case when (date(date_of_birth + interval \'60 year\')::date - Now()::date) < 1 then 0 else date(date_of_birth + interval \'60 year\')::date - Now()::date end from '.$tablename.' e '.$whereInner.' AND e.skcode='.$tablename.'.skcode) AS "Days Remaining to Retirement"		
				FROM '.$tablename.' '.$where.' AND age(date_of_birth) >= \'58 years\' GROUP BY '.$tablename.'.skcode, '.$tablename.'.skname';
			}
			$result=$this->db->query($query);
			$allData = $result->result_array();		
			$data['hr_type'] = $data['hr_type'];
			$data['subtitle'] = $subTitle;
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','','NO');
		}
		else{
			$query = 'SELECT '.$tablename.'.distcode, districtname('.$tablename.'.distcode) AS "District",  
			(select count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode and age(date_of_birth) >= \'58 years\' and age(date_of_birth) < \'60 years\') AS "Total Employees Approaching Retirement Age",
			(select count(e.'.$code.') from '.$tablename.' e '.$whereand.'  e.distcode='.$tablename.'.distcode and age(date_of_birth) >= \'60 years\') AS "Total Retired Employees ( Age >= 60 years)"
			FROM '.$tablename.' '.$where.' GROUP BY '.$tablename.'.distcode ORDER BY '.$tablename.'.distcode';
			$result=$this->db->query($query);
			$allData = $result->result_array();		
			$data['hr_type'] = $data['hr_type'];
			$data['subtitle'] = $subTitle;
			$data['exportIcons'] = exportIcons($_REQUEST);
			$data['TopInfo'] = reportsTopInfo($title, $data);
			$data['htmlData'] = getListingReportTable($allData,'','');
		}
		return $data;
	}
	//======= FLCF Wise Vaccination Coverage for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination_coverage($code=NULL,$year=NULL){
		$data = posted_Values();//posted values from last page
		//print_r($data);exit();
		if(!$data["year"]){
			$data["year"] = $this -> input -> get("report_year");
		}
		if(!$data["distcode"]){
			$data["distcode"] = $this -> input -> get("distcode");
		}
		$wc	  = getWC_Array($data['procode'],$data['distcode']); // function to get wc array
		//$rightTotalImmun = "";$rightTotalTT = "";
		$year = $data['year'];
		//$year = $this->input->get('year');		
		$criNames   = array("Total_BCG","Total_HepB","Total_OPV0","Total_OPV1","Total_OPV2","Total_OPV3","Total_Pentavalent1","Total_Pentavalent2","Total_Pentavalent3","Total_PCV10_1","Total_PCV10_2","Total_PCV10_3","Total_IPV","Total_Measles1","Total_Measles2");
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$queryForYearlyData="select facode, facilityname(facode),unname(uncode),
								getnewborn(facode,'facility') as \"New Borns\",
								getsurvivinginfants(facode,'facility') as \"Targeted_MaleFemale_Children\",
								getyearly_plwomen_target(facode,'facility') as \"Targeted_Women\", ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i==14){
					$i=16;
				}
				if($i==15){
					$i=18;
				}
				$queryForYearlyData .= "(select coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year-%' ) as $asValueCRI,"; 
				if($i==13)
					continue;
				if($i==1 || $i==2 || $i==3)
					$queryForYearlyData .= "(select coalesce((coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) )*100,0)/getnewborn(fac_mvrf_db.facode,'facility')  from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year-%' GROUP BY fac_mvrf_db.facode ) as perc".$asValueCRI.", ";			
				else
					$queryForYearlyData .= "(select coalesce((coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) )*100,0)/coalesce(getsurvivinginfants(fac_mvrf_db.facode,'facility'),0)  from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year-%' GROUP BY fac_mvrf_db.facode ) as perc".$asValueCRI.", ";			
				if($i==16){
					$i=14;
				}
				if($i==18){
					$i=15;
				}
			}			
			$m=1;
			for($k=0;$k<sizeof($ttNames1);$k++){
				$rep=sizeof($ttNames1)/2;
				$asValueTT1=$ttNames1[$k];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$m."),0) from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year%' ) as $asValueTT1 ,";
				if($m==1 || $m==2 )
					$queryForYearlyData .= "(select round(coalesce(sum(ttri_r9_f".$m."),0)*100/coalesce(getyearly_plwomen_target(fac_mvrf_db.facode,'')::numeric,0)) from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year%' GROUP BY fac_mvrf_db.facode ) as ".$asValueTT1."perc ,";
				//$rightTotalTT .= "$asValueTT+";
				$m++;
				if($m==$rep+1){
					$m=1;
				}
			}
			$n=1;
			for($j=0;$j<sizeof($ttNames2);$j++){
				$rep=sizeof($ttNames2)/2;
				$asValueTT2=$ttNames2[$j];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$n."),0) from fac_mvrf_db where facode=flcf1.facode and fmonth like '$year%' ) as $asValueTT2 ,";
				//$rightTotalTT .= "$asValueTT+";
				$n++;
				if($n==$rep+1){
					$n=1;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from facilities flcf1 where hf_type='e' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by fac_name";
		}
		else
		{
			$newWC= WC_replacement($wc);//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
			$neWc = $newWC[0];
			//case when district not selected mean provincial user logged in
			$queryForYearlyData="select distcode, districtname(distcode),
								(select count(*) from unioncouncil where distcode = dist.distcode) as \"Total UC\",
								getnewborn(distcode,'district') as \"New Borns\",
								getsurvivinginfants(distcode,'district') as \"Targeted_MaleFemale_Children\",
								getyearly_plwomen_target(distcode,'district') as \"Targeted_Women\", ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i==14){
					$i=16;
				}
				if($i==15){
					$i=18;
				}
				$queryForYearlyData .= "(select coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year-%' ) as $asValueCRI, ";
				if($i==13)
					continue;
				if($i==1 || $i==2 || $i==3)
					$queryForYearlyData .= "(select coalesce((coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) )*100,0)/getnewborn(fac_mvrf_db.distcode,'district')  from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year-%' GROUP BY fac_mvrf_db.distcode ) as perc".$asValueCRI.", ";			
				else
					$queryForYearlyData .= "(select coalesce((coalesce(sum(cri_r25_f".$i."),0)+coalesce(sum(cri_r26_f".$i."),0) )*100,0)/coalesce(getsurvivinginfants(fac_mvrf_db.distcode,'district'),0)  from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year-%' GROUP BY fac_mvrf_db.distcode ) as perc".$asValueCRI.", ";
				//$rightTotalImmun .= "$asValueCRI+";
				if($i==16){
					$i=14;
				}
				if($i==18){
					$i=15;
				}
			}
			$m=1;
			for($k=0;$k<sizeof($ttNames1);$k++){
				$rep=sizeof($ttNames1)/2;
				$asValueTT1=$ttNames1[$k];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$m."),0) from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year%' ) as $asValueTT1 ,";
				if($m==1 || $m==2 )
					$queryForYearlyData .= "(select round(coalesce(sum(ttri_r9_f".$m."),0)*100/coalesce(getyearly_plwomen_target(fac_mvrf_db.distcode,'')::numeric,0)) from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year%' GROUP BY fac_mvrf_db.distcode ) as ".$asValueTT1."perc ,";
				//$rightTotalTT .= "$asValueTT+";
				$m++;
				if($m==$rep+1){
					$m=1;
				}
			}
			$n=1;
			for($j=0;$j<sizeof($ttNames2);$j++){
				$rep=sizeof($ttNames2)/2;
				$asValueTT2=$ttNames2[$j];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r10_f".$n."),0) from fac_mvrf_db where distcode=dist.distcode and fmonth like '$year%' ) as $asValueTT2 ,";
				//$rightTotalTT .= "$asValueTT+";
				$n++;
				if($n==$rep+1){
					$n=1;
				}
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= "from districts dist ".((!empty($neWc)) ? ' where ' . implode(' AND ', $neWc) : '' )." order by district";
		}
		//echo $queryForYearlyData;exit;
		//$rightTotalImmun = rtrim($rightTotalImmun,"+");
		//$rightTotalTT = rtrim($rightTotalTT,"+");
		//$queryForTotal = "select *,$rightTotalImmun as totalimmun,$rightTotalTT as totalTT from ($queryForYearlyData) as b";
		$result = $this-> db -> query($queryForYearlyData) -> result_array();
		//$result = $this-> db -> query($queryForTotal) -> result_array();
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Facility_Wise_Vaccination_Coverage_of_Childern_and_Women.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//$result["year"] = $year;
		$subTitle = 'Consolidated Facility Wise Vaccination Coverage of Children and Women';
		$result['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year']);
		$result['exportIcons']=exportIcons($_REQUEST);
		return $result;
	}
	//======= UC wise Vaccination Coverage for Children and Women Report Function Ends Here ========//
/**
	 *
	 *	District, UC or Facility wise Measle Coverage and dropout report
	 *
	 *	It May be viewed as month wise and quarter wise
	 *
	 *	@author Awais Iqbal
	 *  @updated by moon on 2019-03-08 according to new pattern
	 *	@param 	Array	$data   		Posted values and other Added data
	 *	@return Array 	$returned_data
	 *
	 */
	public function vaccine_demand($data)
	{
		//print_r($data);//exit;
		$tcode=$this -> session -> Tehsil;
		$column_name = $data['indicator'];
		unset($data['indicator']);
		$product = $data['product'];
		$fmonth = $data['monthfrom'];
		$th = date('M Y', strtotime($fmonth));
		 if(isset($tcode) AND $tcode > 0){
			 $wc[] = " facilities.tcode= '".$tcode."' ";
		 }
		//If data is required Facility wise
		if(isset($data['distcode']) AND $data['distcode'] > 0   AND $data['typewise'] == 'facility')
		{ 
			/* $m_portion = "SELECT facode, facilityname(facode),";
			$t_portion = "SELECT ";
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail
							join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
							WHERE fmonth='$fmonth' AND facode=facilities.facode AND item_id = $product) AS \"$th\",";
				$t_portion .= "sum(\"$th\") AS \"Total $th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
			$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail
							join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
							WHERE fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND facode=facilities.facode AND item_id = $product) AS \"all total\"";
			$t_portion .= "sum(\"all total\") AS \"Total\",";
			$m_portion .= " FROM facilities WHERE distcode='{$data['distcode']}' AND hf_type='e' AND is_vacc_fac=1 ORDER BY facode"; */
			
			
			$m_portion = '';
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "COALESCE(SUM(case when fmonth='$fmonth' then $column_name else 0 end), 0) AS \"$th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
		   $m_portion = "select facilities.facode, facilityname(facilities.facode),
			$m_portion
			COALESCE(SUM($column_name), 0) as \"Total\"
			from facilities FULL JOIN epi_consumption_master on facilities.facode = epi_consumption_master.facode 
			JOIN epi_consumption_detail on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
			WHERE facilities.distcode='{$data['distcode']}' AND hf_type='e' AND fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND item_id = $product and epi_consumption_master.is_compiled='1' 
			".((!empty($wc)) ? 'AND ' . implode(' AND ', $wc) : '' )."
			group by facilities.facode order by facilityname(facilities.facode)";  
			//in above query  AND is_vacc_fac='1' check remaining but if you are going to add it then it must be added into district query aswell.
		}
		//If data is required UC wise
		 elseif(isset($data['distcode']) AND $data['distcode'] > 0 AND $data['typewise'] == 'uc')
		{
			/* $m_portion = "SELECT uncode, unname(uncode),";
			$t_portion = "SELECT ";
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM form_b_cr 
								WHERE fmonth='$fmonth' AND form_b_cr.uncode=unioncouncil.uncode) AS \"$th\",";
				$t_portion .= "sum(\"$th\") AS \"Total $th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
			$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail
							join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
							WHERE fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND form_b_cr.uncode=unioncouncil.uncode) AS \"all total\"";
			$t_portion .= "sum(\"all total\") AS \"Total\",";
			$m_portion .= " FROM unioncouncil WHERE distcode='{$data['distcode']}' ORDER BY uncode"; */
			
			$m_portion = '';
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "COALESCE(SUM(case when fmonth='$fmonth' then $column_name else 0 end), 0) AS \"$th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
		   $m_portion = "select unioncouncil.uncode, unname(unioncouncil.uncode),
			$m_portion
			COALESCE(SUM($column_name), 0) as \"Total\"
			from unioncouncil FULL JOIN epi_consumption_master on unioncouncil.uncode = epi_consumption_master.uncode 
			JOIN epi_consumption_detail on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
			WHERE unioncouncil.distcode='{$data['distcode']}' AND fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND item_id = $product and  epi_consumption_master.is_compiled='1'
			".((!empty($wc)) ? 'AND ' . implode(' AND ', $wc) : '' )."
			group BY unioncouncil.uncode ORDER BY uncode";  
			
			
		} elseif(isset($data['distcode']) AND $data['distcode'] > 0 AND $data['typewise'] == 'tehsil')
		{
			/* $m_portion = "SELECT tcode, tehsilname(tcode),";
			$t_portion = "SELECT ";
			while ($fmonth <= $data['monthto']) 
			{ 
				$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM form_b_cr 
								WHERE fmonth='$fmonth' AND form_b_cr.tcode=tehsil.tcode) AS \"$th\",";
				$t_portion .= "sum(\"$th\") AS \"Total $th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
			$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail 
								WHERE fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND form_b_cr.tcode=tehsil.tcode) AS \"all total\"";
			$t_portion .= "sum(\"all total\") AS \"Total\",";
			$m_portion .= " FROM tehsil WHERE distcode='{$data['distcode']}' ORDER BY tcode"; */
			$m_portion = '';
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "COALESCE(SUM(case when fmonth='$fmonth' then $column_name else 0 end), 0) AS \"$th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
		   $m_portion = "select tehsil.tcode, tehsilname(tehsil.tcode),
			$m_portion
			COALESCE(SUM($column_name), 0) as \"Total\"
			from tehsil FULL JOIN epi_consumption_master on tehsil.tcode = epi_consumption_master.tcode 
			JOIN epi_consumption_detail on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
			WHERE tehsil.distcode='{$data['distcode']}' AND fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND item_id = $product and  epi_consumption_master.is_compiled='1'
			".((!empty($wc)) ? 'AND ' . implode(' AND ', $wc) : '' )."
			group BY tehsil.tcode ORDER BY tcode";  
		}
		//If data is required district wise
		else
		{
		    $m_portion = "SELECT distcode, districtname(distcode),";
			$t_portion = "SELECT ";
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail
								join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
								WHERE fmonth='$fmonth' AND distcode=districts.distcode AND item_id = $product and  epi_consumption_master.is_compiled='1') AS \"$th\",";
				$t_portion .= "sum(\"$th\") AS \"Total $th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
			$m_portion .= "(SELECT COALESCE(SUM($column_name), 0) FROM epi_consumption_detail
								join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
								WHERE fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND distcode=districts.distcode AND item_id = $product and  epi_consumption_master.is_compiled='1') AS \"all total\"";
			$t_portion .= "sum(\"all total\") AS \"Total\",";
			$m_portion .= " FROM districts ORDER BY distcode"; 			
			
			/* $m_portion = '';
			while ($fmonth <= $data['monthto']) 
			{
				$m_portion .= "COALESCE(SUM(case when fmonth='$fmonth' then $column_name else 0 end), 0) AS \"$th\",";
				$th = date('M Y', strtotime($fmonth. 'first day of next month'));
				$fmonth = date('Y-m', strtotime($fmonth. 'first day of next month'));
			}
			$moonquery = "select districts.distcode,districtname(districts.distcode),
			$m_portion
			COALESCE(SUM($column_name), 0) as \"Total\"
			from districts FULL JOIN epi_consumption_master on districts.distcode = epi_consumption_master.distcode 
			JOIN epi_consumption_detail on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
			WHERE fmonth BETWEEN '{$data['monthfrom']}' AND '{$data['monthto']}' AND item_id = $product 
			group by districts.distcode"; */
		}
		if($this->input->post('export_excel')) 
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Vaccine_Demand_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$data['allData'] = $this->db->query($m_portion)->result_array();
		//echo $this->db->last_query();
		$result['htmlData'] = getListingReportTable($data['allData'], ''/* , $data['allDataTotal'] */);
		$sub_title = "Vaccine Consumption Report";
		$result['subtitle'] = $sub_title;
		//$data['vacc_ind'] = array($product);
		$data['mini_title'] = get_consumption_detail_column_title($column_name);
		$result['TopInfo'] = reportsTopInfo($sub_title, $data);
		//echo "<pre>";print_r($data);exit;
		$result['exportIcons'] = exportIcons($_REQUEST);
		unset($data['allData']);
		unset($data['allDataTotal']);
		$data['indicator'] =$column_name; 
		$result['data'] = $data;
		//echo "<pre>";print_r($result['TopInfo']);exit;
		return $result;
		
	}
	public function all_dropout($data)
	{
		$query = "SELECT * FROM indicator_main WHERE indmain IN (24,25,26,27,68) ORDER BY indmain";
		$result = $this->db->query($query)->result_array();
		$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		$whereCondition = "";
		if(isset($data['distcode']) && $data['distcode'] > 0){
			$whereCondition.="distcode='".$data['distcode']."' and";
		}
		if(isset($data['tcode']) && $data['tcode'] > 0)
		{
			$whereCondition.=" tcode='".$data['tcode']."' and";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0)
		{
			$whereCondition.=" uncode='".$data['uncode']."' and";
		}
		if(isset($data['facode']) && $data['facode'] > 0)
		{
			$whereCondition.=" facode='".$data['facode']."' and";
		}
		$str = "";
		foreach ($result as $key => $value) 
		{
			//Numerator for Total
			$t_num = $value['numenator'];
			//Denominator for Total
			$t_den = $value['denominator'];
			$den = explode('+', $value['denominator']);
			//Denominator for Male
			$m_den = $den[0];
			//Denominator for Female
			$f_den = $den[1];
			$num = explode('+', $value['numenator']);
			//Numerator for Male 1
			$m1_num = $num[0];
			$num = explode('-', $num[1]);
			//Numerator for Female 1
			$f1_num = $num[0];
			//Numerator for Male 2
			$m2_num = $num[1];
			//Numerator for Female 2
			$f2_num = $num[2];
			//Calculation of Male dropout
			$str .= "ROUND((COALESCE(($m1_num - $m2_num) // NULLIF($m_den,0), 0)*100)::numeric) AS \"{$value['ind_name']} Male\","; 
			//Calculation of Female dropout
			$str .= "ROUND((COALESCE(($f1_num - $f2_num) // NULLIF($f_den,0), 0)*100)::numeric) AS \"{$value['ind_name']} Female\","; 
			//Calculation of Total dropout
			$str .= "ROUND((COALESCE(($t_num) // NULLIF($t_den,0), 0)*100)::numeric) AS \"{$value['ind_name']} Total\",";
		}
		$str = rtrim($str, ',');
		if(isset($data['distcode']) AND $data['distcode'] > 0 AND $data['type_wise'] == 'facility')
		{
			$query = "SELECT facode, facilityname(facode), $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth GROUP BY facode ORDER BY facilityname(facode)";
		}
		elseif(isset($data['distcode']) AND $data['distcode'] > 0 AND $data['type_wise'] == 'uc')
		{
			$query = "SELECT uncode, unname(uncode), $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth GROUP BY uncode ORDER BY unname(uncode)";
		}
        elseif(isset($data['tcode']) AND $data['tcode'] > 0 AND $data['type_wise'] == 'facility')
		{
			$query = "SELECT facode, facilityname(facode), $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth GROUP BY facode ORDER BY facilityname(facode)";
		}
		elseif(isset($data['tcode']) AND $data['tcode'] > 0 AND $data['type_wise'] == 'uc')
		{
		    $query = "SELECT uncode, unname(uncode), $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth GROUP BY uncode ORDER BY unname(uncode)";
		}
		else
		{
			$query = "SELECT distcode, districtname(distcode), $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth GROUP BY distcode ORDER BY districtname(distcode)";
		}
		$t_query = "SELECT $str FROM fac_mvrf_db WHERE $whereCondition $whereFmonth";
		$result = $this->db->query($query)->result_array();
		$result_total = $this->db->query($t_query)->result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		if($this->input->post('export_excel')) 
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Vaccine_Demand_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$sub_title = "Dropouts Report";
		$returned_data['subtitle'] = $sub_title;
		$returned_data['TopInfo'] = reportsTopInfo($sub_title, $data);
		$returned_data['exportIcons'] = exportIcons($_REQUEST);
		$returned_data['data'] = $data;
		$returned_data['result'] = $result;
		$returned_data['result_total'] = $result_total;
		return $returned_data;
	}	
	public function access_utilization($data){
		$fmonthfrom = (isset($data['monthfrom']) AND $data['monthfrom'] !="")?$data['monthfrom']:'2018-01';
		$fmonthto = (isset($data['monthto']) AND $data['monthto'] !="")?$data['monthto']:'2018-12';
		$date_from = explode("-",$fmonthfrom);
		$startyear = $date_from[0];
		$sm = $date_from[1];
		$date_to = explode("-",$fmonthto);
		$endyear = $date_to[0];
		$em = $date_to[1];

		$monthfromarr = explode('-',$fmonthfrom);
		$monthfrom = $monthfromarr[1];
		$yearfrom = $monthfromarr[0];
		
		$monthtoarr = explode('-',$fmonthto);
		$monthto = $monthtoarr[1];
		$yearto = $monthtoarr[0];
		$procode=$this->session->Province;
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else if(isset($data['tcode']) > 0){
			$wc = " tcode = '".$data['tcode']."' ";
		}
		else{
			$wc = " procode = '".$procode."' ";
		}
		if((isset($data['distcode']) AND $data['distcode'] > 0 )|| (isset($data['tcode']) AND $data['tcode'] > 0)){

			if($data["type_wise"]=="facility"){
				$query="SELECT *, 
				(SELECT
					SUM(case when getfstatus_vacc('{$fmonthto}', fac.facode)='F' then 1 else 0 end) as cnt 
					from facilities fac 
					where fac.facode = a.facode and a.distcode = '{$data['distcode']}' AND fac.is_vacc_fac='1' and fac.hf_type='e') as due, 
					(SELECT count(*) 
					FROM fac_mvrf_db 
					where fmonth = '{$fmonthto}' and facode = a.facode) as sub 
				from
					(select
						facode,facilityname(facode),distcode, round(utilization+measles1dropout) as priority,
						coverage, dropout,
						sum(case when (access >= 80) and (utilization < 10) then 1 else 0 end) as cat1, 
						sum(case when (access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2, 
						sum(case when (access < 80) and (utilization < 10) then 1 else 0 end) as cat3, 
						sum(case when (access < 80) and (utilization >= 10) then 1 else 0 end) as cat4 
					from
						(select facode,distcode, 
							round(((sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.facode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0) as access, 
							round(((sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as utilization,
							round(((sumvaccinevacination(9,fac_mvrf_db.facode,'2019-01','2019-09') :: numeric - sumvaccinevacination(16,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(9,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as measles1dropout,

							sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(round(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.distcode,'district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
							round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout
							
						from fac_mvrf_db where {$wc} and getfstatus_vacc('{$fmonthfrom}', fac_mvrf_db.facode)='F' group by distcode,facode order by distcode,facode) as a 
					group by facode, distcode, priority, coverage, dropout order by facilityname(facode) ) as a 
				order by priority desc";
				
				$total_query="SELECT *,
							(SELECT SUM(case when getfstatus_vacc('{$fmonthto}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where fac.distcode = a.distcode and a.distcode = '{$data['distcode']}' AND fac.is_vacc_fac='1' and fac.hf_type='e') as totdue,
							(SELECT count(*) FROM fac_mvrf_db where fmonth = '{$fmonthto}' and distcode = a.distcode) as totsub
								from (select distcode,districtname(distcode), count(facode) as totaluc,
									sum(case when (access >= 80) and (utilization < 10) then 1 else null end) as cat1,
									sum(case when (access >= 80) and (utilization >= 10) then 1 else null end) as cat2,
									sum(case when (access < 80) and (utilization < 10) then 1 else null end) as cat3,
									sum(case when (access < 80) and (utilization >= 10) then 1 else null end) as cat4
									from(select distcode,facode,
										round(((sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.facode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0) as access,
										round(((sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.facode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as utilization	 
									from fac_mvrf_db where {$wc} and getfstatus_vacc('{$fmonthfrom}', fac_mvrf_db.facode)='F'
									group by distcode,facode order by distcode,facode) as a group by distcode order by  districtname(distcode)) as a order by cat4 desc,cat3 desc,cat2 desc,cat1 asc";								
			}
			else	
			{
				$query="SELECT *, 
				(SELECT 
					SUM(case when getfstatus_vacc('{$fmonthto}', fac.facode)='F' then 1 else 0 end) as cnt 
					from facilities fac 
					where fac.uncode = a.uncode and a.distcode = '{$data['distcode']}' AND fac.is_vacc_fac='1' and fac.hf_type='e') as due, 
					(SELECT count(*) 
					FROM fac_mvrf_db 
					where fmonth = '{$fmonthto}' and uncode = a.uncode) as sub 
				From
					(select 
						uncode,unname(uncode),distcode, round(utilization+measles1dropout) as priority,
						coverage, dropout,
						sum(case when (access >= 80) and (utilization < 10) then 1 else 0 end) as cat1, 
						sum(case when (access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2, 
						sum(case when (access < 80) and (utilization < 10) then 1 else 0 end) as cat3, 
						sum(case when (access < 80) and (utilization >= 10) then 1 else 0 end) as cat4 
					from
					(select uncode,distcode, 
						round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.uncode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0) as access, 
						round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as utilization,
						round(((sumvaccinevacination(9,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(16,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(9,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as measles1dropout,

						sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(round(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.distcode,'district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
						round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout
						
					from fac_mvrf_db where {$wc} and getfstatus_vacc('{$fmonthfrom}', fac_mvrf_db.facode)='F' group by distcode,uncode order by distcode,uncode) as a 
				group by uncode, distcode, priority, coverage, dropout order by unname(uncode) ) as a 
				order by priority desc";
		
				$total_query="SELECT *,
					(SELECT SUM(case when getfstatus_vacc('{$fmonthto}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where fac.distcode = a.distcode and a.distcode = '{$data['distcode']}' AND fac.is_vacc_fac='1' and fac.hf_type='e') as totdue,
					(SELECT count(*) FROM fac_mvrf_db where fmonth = '{$fmonthto}' and distcode = a.distcode) as totsub
					from (select distcode,districtname(distcode), count(uncode) as totaluc,
						sum(case when (access >= 80) and (utilization < 10) then 1 else 0 end) as cat1,
						sum(case when (access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2,
						sum(case when (access < 80) and (utilization < 10) then 1 else 0 end) as cat3,
						sum(case when (access < 80) and (utilization >= 10) then 1 else 0 end) as cat4
						from(select distcode,uncode,
							round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.uncode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0) as access,
							round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as utilization	 
						from fac_mvrf_db where {$wc} and getfstatus_vacc('{$fmonthfrom}', fac_mvrf_db.facode)='F' 
						group by distcode,uncode order by distcode,uncode) as a group by distcode order by  districtname(distcode)) as a order by cat4 desc,cat3 desc,cat2 desc,cat1 asc";
			}		
			$total_query = $this->db->query($total_query)->result_array();
			$result = $this->db->query($query)->result_array();
			//echo $this->db->last_query();exit;
			$returned_data['result'] = $result;
			$returned_data['total_query'] = $total_query;
			return $returned_data;
		}
		else{			
			$query="SELECT *,
			(SELECT SUM(case when getfstatus_vacc('{$fmonthto}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where fac.distcode = a.distcode AND fac.is_vacc_fac='1' and fac.hf_type='e') as due,
			(SELECT count(*) FROM fac_mvrf_db where fmonth = '{$fmonthto}' and distcode = a.distcode) as sub
			from (select distcode,districtname(distcode), count(uncode) as totaluc,
					coverage, dropout,
					sum(case when (access >= 80) and (utilization < 10) then 1 else 0 end) as cat1,
					sum(case when (access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2,
					sum(case when (access < 80) and (utilization < 10) then 1 else 0 end) as cat3,
					sum(case when (access < 80) and (utilization >= 10) then 1 else 0 end) as cat4
					from(select distcode,uncode,
						round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.uncode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0) as access,
						round(((sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.uncode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as utilization,

						sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(round(getmonthlytarget_specificyearrsurvivinginfants(fac_mvrf_db.distcode,'district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
						round(((sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.distcode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout

					from fac_mvrf_db where {$wc} and distcode in (select distinct distcode from unioncouncil_population where year = '{$endyear}')
					group by distcode,uncode order by distcode,uncode) as a group by distcode, coverage, dropout order by  districtname(distcode)) as a order by cat4 desc,cat3 desc,cat2 desc,cat1 asc";
					//echo $query;exit();
					$result = $this->db->query($query);
					$result= $result->result();
					$returned_data['result'] = $result;
					return $returned_data;
		}
	}
	/**
	 *
	 *	District, UC or Facility wise Measle Coverage and dropout report
	 *
	 *	It May be viewed as month wise and quarter wise
	 *
	 *	@author Awais Iqbal
	 *
	 *	@param 	Array	$data   		Posted values and other Added data
	 *	@return Array 	$returned_data
	 *
	 */
	public function measle_coverage_dropout($data)
	{
		$year = isset($data['year']) ? $data['year'] : date('Y', strtotime('first day of previous month'));
		$period_wise = isset($data['period_wise']) ? $data['period_wise'] : 'monthly';
		$monthfrom = "01"; //isset($data['monthfrom']) ? $data['monthfrom'] : '01';
		$start_year = $year;
		$start_month = $monthfrom;
		$fmonthfrom = $data['monthfrom'] = $year.'-'.$data['monthfrom'];
		$monthto = isset($data['monthto']) ? $data['monthto'] : '';
		$end_year = $year;
		$end_month = $monthto;
		$fmonthto = $data['monthto'] = $year.'-'.$data['monthto'];
		$type_wise = isset($data['type_wise']) ? $data['type_wise'] : ''; 
		//echo $type_wise;exit();
		$query = "SELECT * FROM indicator_main WHERE indmain IN (16) ORDER BY indmain";
		$result = $this-> db-> query($query)-> result_array();
		$mt = 1;
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else if(isset($data['tcode']) > 0){
			$wc = " tcode = '".$data['tcode']."' ";
		}
		//If data is required Facility wise
		if((isset($data['distcode']) AND $data['distcode'] > 0) || (isset($data['tcode']) AND $data['tcode'] > 0) AND $type_wise == 'facility')
		{
			$m_portion = "SELECT facode, facilityname(facode) AS \"Facility Name\",";
			$code = 'facode';
			$condition = 'facode=facilities.facode';
			$type = 'fac';
			$wc = "WHERE hf_type='e' AND {$wc} GROUP BY facode ORDER BY facilityname(facode)";
			$table = "facilities";
		}
		//If data is required UC wise
		elseif((isset($data['distcode']) AND $data['distcode'] > 0) || (isset($data['tcode']) AND $data['tcode'] > 0) AND $type_wise == 'uc' )
		{
			$m_portion = "SELECT uncode, unname(uncode) AS \"Union Council Name\",";
			$code = 'uncode';
			$condition = 'uncode=unioncouncil.uncode';
			$type = 'uc';
			$wc = "WHERE {$wc} GROUP BY uncode ORDER BY unname(uncode)";
			$table = "unioncouncil";
		}
		//If data is required District wise
		else
		{
			$m_portion = "SELECT distcode, districtname(distcode) AS \"District Name\",";
			$code = 'distcode';
			$condition = 'distcode=districts.distcode';
			$type = 'district';
			$wc = "GROUP BY distcode ORDER BY districtname(distcode)";
			$table = "districts";
		}

		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Measles_Coverage_Vs_Measles_Cases_".$year.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		/*
		 *
		 *	Below are the main logic conditions that calculate 
		 *	coverage and dropout according to posted data values
		 *
		 */
		$t_portion = "SELECT ";
		$sub_query_total = "";
		/*
		 *	if user selected current year and the selected year has vaccination record then 
		 *	the operations performed on data are cummulative basis
		 */
		//if sselected period is monthly
		if($period_wise == 'monthly')
		{
			for ($i=1; $i <= $monthto; $i++) 
			{
				//echo $i; echo ",";
				$start_month = $end_month = sprintf('%02d',$i);
				$fmonthfrom = $year.'-'.sprintf('%02d',$i);
				$fmonthto = $year.'-'.sprintf('%02d',$i);
				$where_fmonth = "fmonth BETWEEN '$fmonthfrom' AND '$fmonthto'";
				$start_date = date('Y-m-01',strtotime($fmonthfrom.' this month'));
				$end_date = date('Y-m-t',strtotime($fmonthto.' this month'));
				//echo $start_date; echo " / "; echo $end_date; echo ", "; //exit();				
				//echo $start_month; echo " / "; echo $end_month; exit();
				foreach ($result as $key => $value) 
				{
					$numenator = check_replacements($value['numenator'],$year,$start_month,$year,$end_month,$type);
					$denominator = check_replacements($value['denominator'],$year,$start_month,$year,$end_month,$type);
					if($value['mt'])
					{
						$mt = $value['mt'];
					}
					$num = "coverage";
					$den = "coverage_den";
					/* if($key == 1)
					{
						$num = "dropout";
						$den = "dropout_den";
					} */
					$m_portion .= "COALESCE((SELECT ROUND( COALESCE( ($numenator) // NULLIF($denominator, 0), 0)::numeric * $mt) FROM fac_mvrf_db WHERE $where_fmonth AND $condition GROUP BY $code), 0) AS \"{$value['ind_name']} $i\", ";
					$sub_query_total .= "(SELECT ROUND($numenator, 2) FROM fac_mvrf_db WHERE $where_fmonth AND $condition) AS \"$num $i\", (SELECT ROUND($denominator, 2) FROM fac_mvrf_db WHERE $where_fmonth AND $condition GROUP BY $code) AS \"$den $i\",";
					$t_portion .= "ROUND( COALESCE( sum(\"$num $i\") // NULLIF(sum(\"$den $i\"), 0), 0)::numeric * $mt) AS \"Total {$value['ind_name']} $i\",";
				}
				$temp_str = "COALESCE((SELECT COUNT(*) FROM case_investigation_db WHERE pvh_date BETWEEN '$start_date'::date AND '$end_date'::date AND case_type='Msl' AND $condition GROUP BY $code),0) AS \"Cases $i\",";
				$m_portion .= $temp_str;
				$sub_query_total .= $temp_str;
				$t_portion .= "SUM(\"Cases $i\") AS \"Total Cases $i\",";
				//$month++;
				//echo PHP_EOL.$month.PHP_EOL;echo $year;
			}
			//exit;
		}
		//if sselected period is quarterly
		elseif($period_wise == 'quarterly')
		{	
			$currentYear = date('Y');
			if($year == $currentYear){
				$month = date('m');
			}
			else{
				$month = '12';
			}
			//$month = date('m');
			$quarter = $m1 = getQuater($month);			
			for ($i=1; $i <= $quarter; $i++) 
			{
				//echo $year; exit();
				//$i = sprintf("%02d", $i);
				if($i == 1){
					$monthfrom = '01';
					$monthto = '03';
					$fmonthfrom = $year.'-01';
					$fmonthto = $year.'-03';
				}
				if($i == 2){
					$monthfrom = '04';
					$monthto = '06';
					$fmonthfrom = $year.'-04';
					$fmonthto = $year.'-06';
				}
				if($i == 3){
					$monthfrom = '07';
					$monthto = '09';
					$fmonthfrom = $year.'-07';
					$fmonthto = $year.'-09';
				}
				if($i == 4){
					$monthfrom = '10';
					$monthto = '12';
					$fmonthfrom = $year.'-10';
					$fmonthto = $year.'-12';
				}

				$where_fmonth = "fmonth BETWEEN '$fmonthfrom' AND '$fmonthto'";
				$start_date = date('Y-m-01',strtotime($fmonthfrom.' this month'));
				$end_date = date('Y-m-t',strtotime($fmonthto.' this month'));
				foreach ($result as $key => $value) 
				{
					$numenator = check_replacements($value['numenator'],$year,$monthfrom,$year,$monthto,$type);
					$denominator = check_replacements($value['denominator'],$year,$monthfrom,$year,$monthto,$type);
					if($value['mt'])
					{
						$mt = $value['mt'];
					}
					$num = "coverage";
					$den = "coverage_den";
					if($key == 1)
					{
						$num = "dropout";
						$den = "dropout_den";
					}
					$m_portion .= "COALESCE((SELECT ROUND( COALESCE( ($numenator) // NULLIF($denominator, 0), 0)::numeric * $mt) FROM fac_mvrf_db WHERE $where_fmonth AND $condition GROUP BY $code), 0) AS \"{$value['ind_name']} $i\",";
					$sub_query_total .= "(SELECT ROUND($numenator, 2) FROM fac_mvrf_db WHERE $where_fmonth AND $condition) AS \"$num $i\", (SELECT ROUND($denominator, 2) FROM fac_mvrf_db WHERE $where_fmonth AND $condition GROUP BY $code) AS \"$den $i\",";
					$t_portion .= "ROUND( COALESCE( sum(\"$num $i\") // NULLIF(sum(\"$den $i\"), 0), 0)::numeric * $mt) AS \"Total {$value['ind_name']} $i\",";
				}
				$temp_str = "COALESCE((SELECT COUNT(*) FROM case_investigation_db WHERE pvh_date BETWEEN '$start_date'::date AND '$end_date'::date AND case_type='Msl' AND $condition GROUP BY $code),0) AS \"Cases $i\",";
				$m_portion .= $temp_str;
				$sub_query_total .= $temp_str;
				$t_portion .= "SUM(\"Cases $i\") AS \"Total Cases $i\",";
			}
			//exit;
		}		
		//echo $this->db->last_query(); exit;
		//For Yearly Total
		$where_fmonth = "fmonth BETWEEN '$fmonthfrom' AND '$fmonthto'";
		$start_date = date('Y-m-01',strtotime($fmonthfrom.' this month'));
		$end_date = date('Y-m-t',strtotime($fmonthto.' this month'));
		foreach ($result as $key => $value) 
		{
			$monthfrom = '01';
			$numenator = check_replacements($value['numenator'],$year,$monthfrom,$year,$monthto,$type);
			$denominator = check_replacements($value['denominator'],$year,$monthfrom,$year,$monthto,$type);
			if($value['mt'])
			{
				$mt = $value['mt'];
			}
			$num = "coverage";
			$den = "coverage_den";
			/* if($key == 1)
			{
				$num = "dropout";
				$den = "dropout_den";
			} */
			if($year == date('Y')){
				$data['monthfrom'] = $fmonthfrom = $year.'-01';
				$data['monthto'] = $fmonthto = date('Y-m', strtotime('first day of previous month'));
				$whereFmonth = "fmonth BETWEEN '$fmonthfrom' AND '$fmonthto'";			
			}
			else{
				$data['monthfrom'] = $fmonthfrom = $year.'-01';
				$data['monthto'] = $fmonthto = $year.'-12';
				$whereFmonth = "fmonth BETWEEN '$fmonthfrom' AND '$fmonthto'";	
			}
			$m_portion .= "COALESCE((SELECT ROUND( COALESCE( ($numenator) // NULLIF($denominator, 0), 0)::numeric * $mt) FROM fac_mvrf_db WHERE $whereFmonth AND $condition GROUP BY $code), 0) AS \"Yearly {$value['ind_name']} $i\",";
			$sub_query_total .= "(SELECT ROUND($numenator, 2) FROM fac_mvrf_db WHERE $whereFmonth AND $condition) AS \"$num $i\", (SELECT ROUND($denominator, 2) FROM fac_mvrf_db WHERE $whereFmonth AND $condition GROUP BY $code) AS \"$den $i\","; //exit();
			$t_portion .= "ROUND( COALESCE( sum(\"$num $i\") // NULLIF(sum(\"$den $i\"), 0), 0)::numeric * $mt) AS \"Total {$value['ind_name']} $i\","; //exit();
		}
		if($year == date('Y')){
			$start_date = $year.'-01-01';
			$end_date = date('Y-m-d');
			//echo $end_date; exit();			
		}
		else{
			$start_date = $year.'-01-01';
			$end_date = $year.'-12-31';	
		}
		$temp_str = "COALESCE((SELECT COUNT(*) FROM case_investigation_db WHERE pvh_date BETWEEN '$start_date'::date AND '$end_date'::date AND case_type='Msl' AND $condition GROUP BY $code),0) AS \"Yearly Cases $i\","; //exit();
		//echo $m_portion; exit();
		$m_portion .= $temp_str;
		$sub_query_total .= $temp_str;
		$t_portion .= "SUM(\"Yearly Cases $i\") AS \"Total Yearly Cases\",";
		$m_portion = rtrim($m_portion, ',');
		$m_portion .= " FROM $table $wc";		
		$t_portion = rtrim($t_portion, ',');
		$sub_query_total = rtrim($sub_query_total, ',');
		$t_query = $t_portion . " FROM (SELECT $sub_query_total FROM $table $wc) AS b";
		$result = $this->db->query($m_portion)->result_array();
		$result_total = $this->db->query($t_query)->result_array();
		//echo $this->db->last_query(); exit();
		$sub_title = "Measle Coverage Vs. Measles Cases";
		$returned_data['subtitle'] = $sub_title;
		$returned_data['TopInfo'] = reportsTopInfo($sub_title, $data);
		$returned_data['exportIcons'] = exportIcons($_REQUEST);
		$returned_data['data'] = $data;
		$returned_data['result'] = $result;
		$returned_data['result_total'] = $result_total;
		//echo "<pre>";print_r($returned_data);exit;
		return $returned_data;
	}

// new code zsk

//public function list_vaccination_children($data)
	//{
		
		//new code Start
		/* 
		$new_date_from = $data['monthfrom'];
		$new_date_to = $data['monthto'];
		$wc[]=null;
		if(isset($data['tcode']) && $data['tcode'] > 0){
			$wc[] = " tcode = '".$data['tcode']."' ";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0 && $data['uncode']!=''){
			$wc[] = " uncode = '".$data['uncode']."' ";
		}
		if(isset($data['facode']) && $data['facode'] > 0 && $data['facode']!=''){
			$wc[] = " facode = '".$data['facode']."' ";
		}
		if(isset($data['monthfrom']) && $data['monthfrom'] != ''){
			
			$wc1[] = " fmonth >= '$new_date_from' ";
		}
		if(isset($data['monthto']) && $data['monthto'] != ''){
			$wc1[] = " fmonth <= '$new_date_to' ";
		}
	   	if(isset($data['distcode']) && $data['distcode'] > 0)
		{
			$wc[] = " distcode = '".$data['distcode']."' ";
		}
		
		$whereCondition=((!empty($wc1)) ? implode(' AND ', $wc1) : '' );	
		$whereCondition.=((!empty($wc)) ? implode(' AND ', $wc) : '' );	
		//print_r($whereCondition);print_r($wc1);
		$this->db->select("cerv_child_registration.item_id,ips.item_name,ips.number_of_doses,
					round(coalesce(sum(case when fmonth = '$new_date_from' then cerv_child_registration.opening_doses Else 0 End),0),1) as opening,
					round(coalesce(sum(cerv_child_registration.received_doses),0),1) as received, 
					sum(coalesce(cerv_child_registration.used_doses,0)) as useddose, 
					sum(coalesce(cerv_child_registration.used_vials,0)) as usedvials, 
					sum(coalesce(cerv_child_registration.unused_doses,0)) as unuseddose,
					sum(coalesce(cerv_child_registration.unused_vials,0)) as unusedvials");
					//sum(coalesce(case when fmonth = '$new_date_to' then cerv_child_registration.closing_vials Else 0 End,0)) as closing ");
			$this->db->from('epi_consumption_master');
			$this->db->join("cerv_child_registration","cerv_child_registration.main_id = epi_consumption_master.pk_id");
			$this->db->join("epi_item_pack_sizes ips","cerv_child_registration.item_id = ips.pk_id");
			$this->db->where($whereCondition);
			$this->db->where('ips.item_category_id <> 4');
			$this->db->where('ips.activity_type_id=1');
			$this->db->group_by(' cerv_child_registration.item_id,ips.item_name,ips.number_of_doses,ips.list_rank');
			$this->db->order_by('ips.list_rank');
			$result['consumption']=$this -> db -> get() -> result_array();
			if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Consumption_Requisition_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Consolidated Consumption and Requisition Report';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		$result['datefrom'] = $new_date_from;
		$result['dateto'] = $new_date_to;
		//print_r($result);exit;
		return $result; */
		
		//new code End
		
		
	/* 	
		$new_date_from = $data['monthfrom'];
		$new_date_to = $data['monthto'];
		$this->db->select("* from cerv_child_registration Where recno = '10643' ");
		$result['consumption']=$this -> db -> get() -> result_array();
		//print_r($result);exit;
		//Excel file code ENDS*******************
		$subTitle = 'List Of Vaccination Children Reports';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		$result['datefrom'] = $new_date_from;
		$result['dateto'] = $new_date_to;
		//print_r($result);exit;
		return $result;   */
		//echo 'asd';exit;
		/////////////new code By usama sher khan  start///////
		//code update by omer:for kpk new table format 
		/* $new_date_from = $data['monthfrom'];
		$new_date_to = $data['monthto'];
		$wc[]=null;
		if(isset($data['tcode']) && $data['tcode'] > 0){
			$wc[] = " tcode = '".$data['tcode']."' ";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0 && $data['uncode']!=''){
			$wc[] = " uncode = '".$data['uncode']."' ";
		}
		if(isset($data['facode']) && $data['facode'] > 0 && $data['facode']!=''){
			$wc[] = " facode = '".$data['facode']."' ";
		}
		if(isset($data['monthfrom']) && $data['monthfrom'] != ''){
			
			$wc1[] = " fmonth >= '$new_date_from' ";
		}
		if(isset($data['monthto']) && $data['monthto'] != ''){
			$wc1[] = " fmonth <= '$new_date_to' ";
		}
	   	if(isset($data['distcode']) && $data['distcode'] > 0)
		{
			$wc[] = " distcode = '".$data['distcode']."' ";
		}
		
		$whereCondition=((!empty($wc1)) ? implode(' AND ', $wc1) : '' );	
		$whereCondition.=((!empty($wc)) ? implode(' AND ', $wc) : '' );	
		//print_r($whereCondition);print_r($wc1);
			$this->db->select("epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,
					round(coalesce(sum(case when fmonth = '$new_date_from' then epi_consumption_detail.opening_doses Else 0 End),0),1) as opening,
					round(coalesce(sum(epi_consumption_detail.received_doses),0),1) as received, 
					sum(coalesce(epi_consumption_detail.used_doses,0)) as useddose, 
					sum(coalesce(epi_consumption_detail.used_vials,0)) as usedvials, 
					sum(coalesce(epi_consumption_detail.unused_doses,0)) as unuseddose,
					sum(coalesce(epi_consumption_detail.unused_vials,0)) as unusedvials");
					//sum(coalesce(case when fmonth = '$new_date_to' then epi_consumption_detail.closing_vials Else 0 End,0)) as closing ");
			$this->db->from('epi_consumption_master');
			$this->db->join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this->db->join("epi_item_pack_sizes ips","epi_consumption_detail.item_id = ips.pk_id");
			$this->db->where($whereCondition);
			$this->db->where('ips.item_category_id <> 4');
			$this->db->where('ips.activity_type_id=1');
			$this->db->group_by(' epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,ips.list_rank');
			$this->db->order_by('ips.list_rank');
			$result['consumption']=$this -> db -> get() -> result_array();
			if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Consolidated_Consumption_Requisition_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		$subTitle = 'Consolidated Consumption and Requisition Report';
		$result['TopInfo'] = reportsTopInfo($subTitle, $data);
		$result['exportIcons']=exportIcons($_REQUEST);
		$result['monthfrom'] =  $data['monthfrom'];
		$result['monthto'] =  $data['monthto'];
		$result['datefrom'] = $new_date_from;
		$result['dateto'] = $new_date_to;
		//print_r($result);exit;
		return $result;  */
			
	//}
	
	
//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function list_vaccination_children($title,$data,$per_page,$startpoint){
		//$wc = $data;
		//	print_r($facode);exit; 
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=permanent_register.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//unset($wc['export_excel']);
		$facode = $data['facode'];
		$uncode = $data['uncode'];
		$distcode = $data['distcode'];
 	  	if (isset($_SESSION['Province'])) {
			$wc = "  procode = '" . $_SESSION['Province'] . "' ";
		}
		if($distcode > 0)
		{	
			$wc = "distcode= '".$data['distcode']."'";
		}
		if(isset($data['tcode']) AND $data['tcode'] > 0){
			$wc = "tcode= '".$data['tcode']."'";
		}
		if(isset($data['uncode']) AND $data['uncode'] > 0){
			$wc = "uncode= '".$data['uncode']."'";
		}
		if(isset($data['facode']) AND $data['facode'] > 0){
			$wc = "reg_facode= '".$data['facode']."'";
		}
		if(isset($data['technician']) AND $data['technician'] > 0){
			$wc = "techniciancode= '".$data['technician']."'";
		}
		$data['techniciancode'] = $data['technician'];
		//echo $wc;exit;
		$defaultersWc = ' AND
							deleted_at IS NULL';
		if($data['defaulters'] == 1){
			$date = date('Y-m-d');
			$defaultersWc = "
								AND
								deleted_at IS NULL
								AND 
								((opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								(penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
								
								(opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day) OR
								(rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day) OR
								(pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day) OR
								(penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day) OR
								
								(opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day) OR
								(ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '99' day) OR
								(pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day) OR
								(penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day) OR
								
								(measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day) OR
								(measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day))
			";
		}
		$query="select recno,child_registration_no,cardno as childcode, nameofchild as name_of_child, dateofbirth as date_of_birth,
		unname(uncode) as unioncouncil, contactno, villagename(villagemohallah) as villagemohallah,(case when gender='m' then 'Male' else 'Female' end) as \"Gender\", fathername as fname,
		address as address, bcg, hepb, opv0, opv1, penta1, pcv1 as pcv10_1, opv2, penta2,
		pcv2 as pcv10_2, opv3, penta3, pcv3 as pcv10_3, ipv, rota1, rota2, measles1, measles2 
		from cerv_child_registration where ".$wc." {$defaultersWc} order by cardno "; 
		if( ! $this -> input -> post('export_excel')){
			$query .= "LIMIT {$per_page} OFFSET {$startpoint}";
		}
		$result=$this->db->query($query);
        //$str = $this->db->last_query();
		//print_r($str); exit;
		$dataReturned["PVRresult"]=$result->result_array();
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$queryTotal = 'select count(*) as total from cerv_child_registration';
		$resultTotal=$this->db->query($queryTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		$dataReturned['pageTitle']='Children Registration';
		//$dataReturned['reportdate']=getListingReportTable($dataReturned["tableData"],'',$data['allDataTotal'],'');
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		$dataReturned["defaulters"]=$data['defaulters'];
		//$dataReturned['year'] = $data['year'];
		return $dataReturned;
	}	
}
?>