<?php
class Reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> helper('my_functions_helper');
		$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');
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
		$datArray['districts'] = get_resultArray('district',$neWc1);	
		//$datArray['flcf'] = get_resultArray('flcf',$wc);
		if ($reportName == 'flcf_wise_vaccination') {
			$Caption = "Monthly Facility wise Vaccination Report";
			//$datArray['current-month-included'] = "";
			$datArray['months']= "";
		}
		if ($reportName == 'flcf_wise_vaccination_coverage') {
			$Caption = "Consolidated Facility Wise Vaccination Coverage of Children and Women";
		}
		if ($reportName == 'flcf_wise_vaccination_malefemale_coverage') {
			$Caption = "Consolidated Facility wise Vaccination Report";
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
		$datArray['listing_filters'] = $this -> Filter_model -> createListingFilter($datArray, $datArray, base_url() . 'Reports/' . str_replace(" ", "_", $reportName) , $UserLevel, $Caption);
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
	public function flcf_wise_vaccination_malefemale_coverage($code=NULL,$year=NULL){
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
		//print_r($wc);exit;
		$year = $data['year'];
		//$year = $this->input->get('year');		
		$criNames   = array(
			"BCG","HEP","OPV_O",
			"OPV_ON","OPV_TW","OPV_TH",
			"PEN_O","PEN_TW","PEN_TH",
			"PC_O","PC_TW","PC_TH",
			"IP_O",
			"MEA_O","MEA_TW"
		);
		$ttNames1 	= array("Total_TTPL1","Total_TTPL2","Total_TTPL3","Total_TTPL4","Total_TTPL5");
		$ttNames2 	= array("Total_TTNonPL1","Total_TTNonPL2","Total_TTNonPL3","Total_TTNonPL4","Total_TTNonPL5");
		//print_r($criNames);exit;
		if($data['distcode'] > 0){
			if($data["year"] && $data['month']){
				$subTitle = 'Facility-wise Monthly Vaccination of Children and Women(with Percentage)';
				$fmonthCondition = " and fmonth = '".$data['year']."-".$data['month']."' ";
				$tmp="round((getmonthly_newborn(facode,'facility')*51)/100) as \"New Borns Male\",
						round((getmonthly_newborn(facode,'facility')*49)/100) as \"New Borns FeMale\",
									round(((getsurvivinginfants(facode,'facility')/12)*51)/100) as \"Targeted_Male_Children\",
									round(((getsurvivinginfants(facode,'facility')/12)*49)/100) as \"Targeted_Female_Children\",
									round((getyearly_plwomen_target(facode,'facility')::integer/12)) as \"Targeted_Women\",";
				$newbornMale = "COALESCE( NULLIF(round((getmonthly_newborn(facode,'facility')*51)/100),0) , '1' )";
				$newbornFemale = "COALESCE( NULLIF(round((getmonthly_newborn(facode,'facility')*49)/100),0) , '1' )";
				$targetMaleChildren = "COALESCE( NULLIF(round(((getsurvivinginfants(facode,'facility')/12)*51)/100),0) , '1' )";
				$targetFeMaleChildren = "COALESCE( NULLIF(round(((getsurvivinginfants(facode,'facility')/12)*49)/100),0) , '1' )";
				$targetWomen = "COALESCE( NULLIF(round((getyearly_plwomen_target(facode,'facility')::integer/12)),0) , '1' )";
									
			}
			if(!$data['month'] && $data['year']){
				$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women(with Percentage)';
				$currMonth = date('m');
				$currMonth = $currMonth - 1;			
				$fmonthCondition = " and fmonth like '".$data['year']."-%' ";
				$tmp="round((getcommulative_newborn(facode,'facility',$currMonth)*51)/100) as \"New Borns Male\",
						round((getcommulative_newborn(facode,'facility',$currMonth)*49)/100) as \"New Borns FeMale\",
									round((((getsurvivinginfants(facode,'facility')/12)*$currMonth)*51)/100) as \"Targeted_Male_Children\",
									round((((getsurvivinginfants(facode,'facility')/12)*$currMonth)*49)/100) as \"Targeted_Female_Children\",
									round((getyearly_plwomen_target(facode,'facility')::integer/12)*$currMonth) as \"Targeted_Women\",";
				$newbornMale = "COALESCE( NULLIF(round((getcommulative_newborn(facode,'facility',$currMonth)*51)/100),0) , '1' )";
				$newbornFemale = "COALESCE( NULLIF(round((getcommulative_newborn(facode,'facility',$currMonth)*49)/100),0) , '1' )";
				$targetMaleChildren = "COALESCE( NULLIF(round((((getsurvivinginfants(facode,'facility')/12)*$currMonth)*51)/100),0) , '1' )";
				$targetFeMaleChildren = "COALESCE( NULLIF(round((((getsurvivinginfants(facode,'facility')/12)*$currMonth)*49)/100),0) , '1' )";
				$targetWomen = "COALESCE( NULLIF(round((getyearly_plwomen_target(facode,'facility')::integer/12)*$currMonth),0) , '1' )";
			}
		}
		else{
			if($data["year"] && $data['month']){
				$subTitle = 'Facility-wise Monthly Vaccination of Children and Women(with Percentage)';
				$fmonthCondition = " and fmonth = '".$data['year']."-".$data['month']."' ";
				$tmp="round((getmonthly_newborn(distcode,'district')*51)/100) as \"New Borns Male\",
						round((getmonthly_newborn(distcode,'district')*49)/100) as \"New Borns FeMale\",
									round(((getsurvivinginfants(distcode,'district')/12)*51)/100) as \"Targeted_Male_Children\",
									round(((getsurvivinginfants(distcode,'district')/12)*49)/100) as \"Targeted_Female_Children\",
									round((getyearly_plwomen_target(distcode,'district')::integer/12)) as \"Targeted_Women\",";
				$newbornMale = "COALESCE( NULLIF(round((getmonthly_newborn(distcode,'district')*51)/100),0) , '1' )";
				$newbornFemale = "COALESCE( NULLIF(round((getmonthly_newborn(distcode,'district')*49)/100),0) , '1' )";
				$targetMaleChildren = "COALESCE( NULLIF(round(((getsurvivinginfants(distcode,'district')/12)*51)/100),0) , '1' )";
				$targetFeMaleChildren = "COALESCE( NULLIF(round(((getsurvivinginfants(distcode,'district')/12)*49)/100),0) , '1' )";
				$targetWomen = "COALESCE( NULLIF(round((getyearly_plwomen_target(distcode,'district')::integer/12)),0) , '1' )";
									
			}
			if(!$data['month'] && $data['year']){
				$subTitle = 'Facility-wise Consolidated Vaccination of Children and Women(with Percentage)';
				$currMonth = date('m');
				$currMonth = $currMonth - 1;			
				$fmonthCondition = " and fmonth like '".$data['year']."-%' ";
				$tmp="round((getcommulative_newborn(distcode,'district',$currMonth)*51)/100) as \"New Borns Male\",
						round((getcommulative_newborn(distcode,'district',$currMonth)*49)/100) as \"New Borns FeMale\",
									round((((getsurvivinginfants(distcode,'district')/12)*$currMonth)*51)/100) as \"Targeted_Male_Children\",
									round((((getsurvivinginfants(distcode,'district')/12)*$currMonth)*49)/100) as \"Targeted_Female_Children\",
									round((getyearly_plwomen_target(distcode,'district')::integer/12)*$currMonth) as \"Targeted_Women\",";
				$newbornMale = "COALESCE( NULLIF(round((getcommulative_newborn(distcode,'district',$currMonth)*51)/100),0) , '1' )";
				$newbornFemale = "COALESCE( NULLIF(round((getcommulative_newborn(distcode,'district',$currMonth)*49)/100),0) , '1' )";
				$targetMaleChildren = "COALESCE( NULLIF(round((((getsurvivinginfants(distcode,'district')/12)*$currMonth)*51)/100),0) , '1' )";
				$targetFeMaleChildren = "COALESCE( NULLIF(round((((getsurvivinginfants(distcode,'district')/12)*$currMonth)*49)/100),0) , '1' )";
				$targetWomen = "COALESCE( NULLIF(round((getyearly_plwomen_target(distcode,'district')::integer/12)*$currMonth),0) , '1' )";
				
				
			}
		}
		//print_r($fmonthCondition);exit;
		//print_r($data['distcode']);exit;
		if($data['distcode'] > 0){
			//case when district selected or deo logged in
			$queryForYearlyData="select facode, facilityname(facode), $tmp ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i >=1 && $i <= 3){
					$queryForYearlyData .= "
					(select coalesce(sum(cri_r25_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition  group by fac_mvrf_db.facode ) as M$asValueCRI,
					(select round((coalesce(sum(cri_r25_f".$i."),0)*100)/$newbornMale) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as percM$asValueCRI,
					(select coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as F$asValueCRI,
					(select round((coalesce(sum(cri_r26_f".$i."),0)*100)/$newbornFemale) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percF$asValueCRI,
					";
				}else{
					$queryForYearlyData .= "
					(select coalesce(sum(cri_r25_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as M$asValueCRI,
					(select round((coalesce(sum(cri_r25_f".$i."),0)*100)/$targetMaleChildren) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percM$asValueCRI,
					(select coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as F$asValueCRI,
					(select round((coalesce(sum(cri_r26_f".$i."),0)*100)/$targetFeMaleChildren) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode) as percF$asValueCRI,";
				}
			}
			for($k=1;$k<=sizeof($ttNames1);$k++){
				
				$asValueTT1=$ttNames1[$k-1];
				if($k >=1 && $k<=2){
					$queryForYearlyData .= "
						(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PW$asValueTT1 ,
						(select round((coalesce(sum(ttri_r9_f".$k."),0)*100)/$targetWomen) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as PWperc$asValueTT1 ,";
				}
				else{
					$queryForYearlyData .= "
						(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition group by fac_mvrf_db.facode ) as $asValueTT1 ,";
				}
			}
			
			
			for($j=1;$j<=sizeof($ttNames2);$j++){
				$asValueTT2=$ttNames2[$j-1];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$j."),0)+coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.facode=flcf1.facode $fmonthCondition ) as $asValueTT2 ,";
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= " from facilities flcf1 where hf_type='e' ".((!empty($wc)) ? ' AND ' . implode(' AND ', $wc) : '' )." order by fac_name";
			//echo $queryForYearlyData;exit;
		}
		else
		{
			$queryForYearlyData="select distcode, districtname(distcode), $tmp ";
			for($i=1;$i<=sizeof($criNames);$i++){
				$asValueCRI=$criNames[$i-1];
				if($i >=1 && $i <= 3){
					$queryForYearlyData .= "
					(select coalesce(sum(cri_r25_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition  group by fac_mvrf_db.distcode ) as M$asValueCRI,
					(select round((coalesce(sum(cri_r25_f".$i."),0)*100)/$newbornMale) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as percM$asValueCRI,
					(select coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as F$asValueCRI,
					(select round((coalesce(sum(cri_r26_f".$i."),0)*100)/$newbornFemale) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percF$asValueCRI,
					";
				}else{
					$queryForYearlyData .= "
					(select coalesce(sum(cri_r25_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as M$asValueCRI,
					(select round((coalesce(sum(cri_r25_f".$i."),0)*100)/$targetMaleChildren) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percM$asValueCRI,
					(select coalesce(sum(cri_r26_f".$i."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as F$asValueCRI,
					(select round((coalesce(sum(cri_r26_f".$i."),0)*100)/$targetFeMaleChildren) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode) as percF$asValueCRI,";
				}
			}
			for($k=1;$k<=sizeof($ttNames1);$k++){
				
				$asValueTT1=$ttNames1[$k-1];
				if($k >=1 && $k<=2){
					$queryForYearlyData .= "
						(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PW$asValueTT1 ,
						(select round((coalesce(sum(ttri_r9_f".$k."),0)*100)/$targetWomen) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as PWperc$asValueTT1 ,";
				}
				else{
					$queryForYearlyData .= "
						(select coalesce(sum(ttri_r9_f".$k."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition group by fac_mvrf_db.distcode ) as $asValueTT1 ,";
				}
			}
			
			
			for($j=1;$j<=sizeof($ttNames2);$j++){
				$asValueTT2=$ttNames2[$j-1];
				$queryForYearlyData .= "(select coalesce(sum(ttri_r9_f".$j."),0)+coalesce(sum(ttri_r10_f".$j."),0) from fac_mvrf_db where fac_mvrf_db.distcode=dist.distcode $fmonthCondition ) as $asValueTT2 ,";
			}
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$queryForYearlyData .= " from districts dist";
			//echo $queryForYearlyData;exit;
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
		
		$result['TopInfo'] = tableTopInfo($subTitle, $data['distcode'], '', $data['year'],'','',$data['month']);
		$result['exportIcons']=exportIcons($_REQUEST);
		return $result;
	}
	//======= FLCF Wise Vaccination Coverage for Children and Women Report Function Ends Here ========//
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
			else if($employee_desg=="med_technician"){
				$code="technician"."code";
				$innerrowName = "Medical Technician";
				$subTitle ="Medical Technician Listing";				
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
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0 && ($data['employee_desg'] == 'technician' || $data['employee_desg'] == 'med_technician')){
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
			FROM '.$tablename.' '.$where.' GROUP BY '.$tablename.'.facode'; 
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
			FROM '.$tablename.' '.$where.' GROUP BY '.$tablename.'.distcode';
		}
		
		$result=$this->db->query($query);
		$allData = $result->result_array();		
		$data['employee_desg'] = $data['employee_desg'];
		$data['exportIcons'] = exportIcons($_REQUEST);
		$data['TopInfo'] = reportsTopInfo($title, $data);
		$data['htmlData'] = getListingReportTable($allData,'');
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

}
?>