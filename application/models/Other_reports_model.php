<?php
class Other_reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');

	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	function MSR($data){
		$title = "Surveillance Report";
		$wc = $data;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=monthly_surveillance_report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if(isset($data['month'])){
			$whereCondition = " AND datefrom::text like '".$data["year"]."-".$data["month"]."-%'";
		}else{
			$whereCondition = " AND datefrom::text like '".$data["year"]."-%'";
		}
		unset($wc['year']);unset($wc['month']);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array("FullyVaccinated","UnVaccinated");
			$tableNames = array(
								"case_investigation_db" => "1",
								"afp_case_investigation" => "4",
								"nnt_investigation_form" => "2"
						);
			$table = "case_investigation_db";
			$doses = "2";
			$disease = array("Measle","AFP","NNT");
			$j = 0;
			$ind = 1;
			foreach ($tableNames as $table => $doses) {
				$ind = sprintf("%02d", $ind);
				$monthlyPortion = "";
				$outerPortion = "";
				$monthlyPortion .= "Select (select '".$disease[$j]."' ) AS \"disease".$ind."\" , ";
				$outerPortion .= " \"disease".$ind."\", ";
				for ($i=1; $i < sizeof($headNames) ; $i++) {
					$monthlyPortion .= "(select count(*) from $table where $table.age_months >= 0 and $table.age_months <= 11 and $table.doses_received >= '$doses'  and $table.distcode='".$data['distcode']."' $whereCondition) AS \"0-11 Months$ind\" ,
										(select count(*) from $table where $table.age_months >= 12 and $table.age_months <= 48 and $table.doses_received >= '$doses' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"1-4 Years$ind\" ,
										(select count(*) from $table where $table.age_months >= 49 and $table.age_months <= 108 and $table.doses_received >= '$doses' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"5-9 Years$ind\" ,
										(select count(*) from $table where $table.age_months >= 109 and $table.age_months <= 168 and $table.doses_received >= '$doses' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"10-14 Years$ind\" ,
										(select count(*) from $table where $table.age_months >= 169 and $table.doses_received >= '$doses' and $table.distcode='".$data['distcode']."' $whereCondition) AS  \">14 Years$ind\" ,";
					$ind1 = sprintf("%02d", ($ind+1));
					$monthlyPortion .= "(select count(*) from $table where $table.age_months >= 0 and $table.age_months <= 11 and $table.doses_received = '0'  and $table.distcode='".$data['distcode']."' $whereCondition) AS \"0-11 Months$ind1\" ,
										(select count(*) from $table where $table.age_months >= 12 and $table.age_months <= 48 and $table.doses_received = '0' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"1-4 Years$ind1\" ,
										(select count(*) from $table where $table.age_months >= 49 and $table.age_months <= 108 and $table.doses_received = '0' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"5-9 Years$ind1\" ,
										(select count(*) from $table where $table.age_months >= 109 and $table.age_months <= 168 and $table.doses_received = '0' and $table.distcode='".$data['distcode']."' $whereCondition) AS \"10-14 Years$ind1\" ,
										(select count(*) from $table where $table.age_months >= 169 and $table.doses_received = '0' and $table.distcode='".$data['distcode']."' $whereCondition) AS \">14 Years$ind1\" ,";
										
					$outerPortion .=" 	\"0-11 Months$ind\" , \"1-4 Years$ind\" , \"5-9 Years$ind\" , \"10-14 Years$ind\" , \">14 Years$ind\" ,
										\"0-11 Months$ind1\" , \"1-4 Years$ind1\" , \"5-9 Years$ind1\" , \"10-14 Years$ind1\" , \">14 Years$ind1\" ,";
					$ind++;
				}
				$monthlyPortion = rtrim($monthlyPortion,",");
				$outerPortion = rtrim($outerPortion,",");
				$query = 'select ' . $outerPortion . ' from (' . $monthlyPortion . ') as a';
				$result = $this -> db -> query($query);
				$data['allData'][$j] = $result -> row_array();
				$j++;
				
			}
			$dataReturned["htmlData"] = getComplianceReportTable($data['allData'],'','',"YES");
		}else{}
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function EPID($data){
		//print_r($data);exit();
		// if($this -> session -> federaluser == true){
		// 	$fedDrilldown = $this -> session -> federaluser;
		// }
		$reportType = $data['report_type'];
		$year = $data['year'];
		$distcode = isset($data['distcode'])?$data['distcode']:'';
		$procode=$this->session->Province;
		$wc_pro = " AND procode = '".$procode."' AND facode != '' " ;
		if(isset($data['from_week']) && isset($data['to_week'])){
			//echo "a";exit();
			$year = $data['year'];
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$to = $year."-".sprintf("%02d",$data['to_week']);
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' "; 
		} 
		else if(isset($data['from_week'])){ 
			//echo "b";exit();
			$year = $data['year'];
			$cryear = date('Y');
			$query = "SELECT max(epi_week_numb) as max_week from epi_weeks where year='{$year}'";
			$result_max_week = $this -> db -> query($query);
			$max_week_num = $result_max_week -> row()-> max_week;
			if($year == $cryear){
				$max_week_num = lastWeek($year);
			}
			$data['to_week'] = 	$max_week_num;
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$to = $year."-".sprintf("%02d",$max_week_num);			
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year' "; 
		}
		else if(isset($data['to_week'])){ 
			//echo "c";exit();
			$data['from_week'] = '01';
			$year = $data['year'];
			$from = $year."-01";
			$to = $year."-".sprintf("%02d",$data['to_week']);
			//$wc = "fweek <= '$to' ";
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year'"; 
		}
		else{
			//echo "d";exit();
			$year = $data['year'];
			$cryear = date('Y');
			$query = "SELECT max(epi_week_numb) as max_week from epi_weeks where year='{$year}'";
			$result_max_week = $this -> db -> query($query);
			$max_week_num = $result_max_week -> row()-> max_week;
			if($year == $cryear){
				$max_week_num = lastWeek($year);
			}
			$data['from_week'] = '01';
			$data['to_week'] = 	$max_week_num;	
			//echo $max_week_num; exit();			
			$from = $year."-01";
			$to = $year."-".sprintf("%02d",$max_week_num);
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year'";
			//$fweekCondition = "year = '$year'"; 
		}
		$currentweek = currentWeek($year);
		//$currentweek = lastWeek($year);		 
		if($currentweek == '00')
		{
			$wc_c = "";
		}
		else{
			$wc_c = "and epi_week_numb <= '$currentweek'" ;
		}

		//$dateFrom = $data['monthfrom'];
		//$dateTo = $data['monthto'];
		if($reportType == 'gender_wise'){
			$dataReturned['secondHeaderCount'] = 2;
			$dataReturned['secondHeaderArray'] = array('M','F');
		}else if($reportType == 'age_wise'){
			$dataReturned['secondHeaderCount'] = 7;
			$dataReturned['secondHeaderArray'] = array('<9M','9-23M','24-59M','60-119M','>=120M');
			$dataReturned['secondHeaderArray'] = array('<9M','9-23M','24-59M','60-119M','120-180M','>180M','Unknown');
		}else{}
		$query = "SELECT distcode,districtname(distcode),";
		$disease = $data['disease'];
		switch($disease){
			case 'measles' || 'Msl':
				$table = "case_investigation_db";
				$case_type = "Msl";
				break;
			case 'nnt' || 'Nnt':
				$table = "nnt_investigation_form";
				$case_type = "0";
				break;
			case 'afp' || 'Afp':
				$table = "afp_case_investigation";
				$case_type = "0";
				break;
			case 'diphtheria' || 'Diph':
				$table = "case_investigation_db";
				$case_type = "Diph";
				break;
			case 'childhood tb' || 'ChTB':
				$table = "case_investigation_db";
				$case_type = "ChTB";
				break;
			case 'pertussis' || 'Pert':
				$table = "case_investigation_db";
				$case_type = "Pert";
				break;
			case 'pneumonia' || 'Pneu':
				$table = "case_investigation_db";
				$case_type = "Pneu";
				break;
			case 'meningitis' || 'Men':
				$table = "case_investigation_db";
				$case_type = "Men";
				break;
			case 'hepatitis' || 'HepB<5':
				$table = "case_investigation_db";
				$case_type = "AVHep";
				break;
			case 'all':
				$table = "";
				$case_type = "";
				break;
		}
		
		$case_type = ($case_type != '0')?" AND case_type = '{$case_type}' ":"";
		$gender = 'patient_';
		
		if($reportType == 'gender_wise' OR $reportType == 'age_wise'){
			if($reportType == "gender_wise"){				
				$title = "Gender Wise Case Count";
				$data['report_type'] = "Gender Wise";
			}
			else{
				$title = "Age Wise Case Count";
				$data['report_type'] = "Age Wise";
			}
			$this -> db -> select('epi_week_numb as numb,year');
			$this -> db -> from('epi_weeks');
			$this -> db -> where("$fweekCondition");
			$this -> db -> order_by('year,epi_week_numb','ASC');
			$weeks = $this -> db -> get() -> result_array();
			foreach($weeks as $key => $val){
				$fweek = $val['year'].'-'.sprintf('%02d',$val['numb']);
				$dataReturned['firstHeaderArray'][] = 'Week-'.sprintf('%02d',$val['numb'])." ".$val['year'];
				if($reportType == 'age_wise'){
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"0-11M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"12-23M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"24-59M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"60-120M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 AND age_months <=180 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \">120-180M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE age_months > 180 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \">180M{$key}\",
							(SELECT COUNT(*) FROM {$table} WHERE coalesce(age_months,'-1') = -1 AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \">Unknown{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 0 AND age_months < 9 AND case_type = 'Msl' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"0-11M{$key}\",
									((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 9 AND age_months <= 23 AND case_type = 'Msl' AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"12-23M{$key}\",
									((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 24 AND age_months <= 59 AND case_type = 'Msl' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"24-59M{$key}\",
									((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 60 AND age_months <= 119 AND case_type = 'Msl' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"60-120M{$key}\",
									((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 120 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 120 AND case_type = 'Msl' AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \">120M{$key}\",";
					}
				}else{
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE patient_gender = '1' AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"Male{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE patient_gender = '0' AND fweek = '{$fweek}' {$case_type} {$wc_pro} AND distcode=districts.distcode) as \"Female{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '1' AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '1' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Male{$key}\",
									((SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '0' AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '0' AND fweek = '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Female{$key}\",";
					}
				}
			}
			if($reportType == 'age_wise'){
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total 0-11{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total 12-23{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total 24-59{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total 60-120{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 AND age_months <= 180 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total >120-180M{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE age_months > 180 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total >180M{$key}\" ,
							(SELECT COUNT(*) FROM {$table} WHERE coalesce(age_months,'-1') = -1 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total >Unknown{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 0 AND age_months < 9 AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total 0-11{$key}\" ,
						((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 9 AND age_months <= 23 AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total 12-23{$key}\" ,
						((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 24 AND age_months <= 59 AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total 24-59{$key}\" ,
						((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 60 AND age_months <= 119 AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total 60-120{$key}\" ,
						((SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 120 AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE age_months >= 120 AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total >120{$key}\" ,";
				}
			}else{
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE patient_gender = '1' {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total Male{$key}\" ,
					(SELECT COUNT(*) FROM {$table} WHERE patient_gender = '0' {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode) as \"Grand Total Female{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '1' AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '1' AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total Male{$key}\" ,
					((SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '0' AND (case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'Pneu' OR case_type = 'ChTB' OR case_type = 'Men' OR case_type = 'AVHep') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)+(SELECT COUNT(*) FROM case_investigation_db WHERE patient_gender = '0' AND case_type = 'Msl' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' {$wc_pro} AND distcode=districts.distcode)) as \"Grand Total Female{$key}\" ,";
				}
			}
			$dataReturned['firstHeaderCount'] = sizeof($dataReturned['firstHeaderArray']);
		}
		
		$query = rtrim($query,",");
		$query .= "FROM districts ORDER BY district";
		// if(isset($fedDrilldown)){
		// 	$query .= " FROM districts ORDER BY dist_order";
		// }
		// else{
		// 	$query .= " FROM districts ORDER BY district";
		// }
		unset($data['case_type']);
		$dataReturned['totalResult'] = $this -> db -> query($query) -> result_array();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPID_Count_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['reportType'] = $data['report_type'];
		return $dataReturned;
	}
	
	function VPD($data){
		//print_r($data);exit();
		// if($this -> session -> federaluser == true){
		// 	$fedDrilldown = $this -> session -> federaluser;
		// }
		$measlesonsetCondition = $afponsetCondition = $nntonsetCondition = $coronavirusonsetCondition = $vpdonsetCondition = "";
		$reportType = $data['report_type'];
		$year = $data['year'];
		$distcode = isset($data['distcode'])?$data['distcode']:'';
		$procode = $this-> session-> Province;
		$wc_pro = " AND procode = '".$procode."' AND facode != '' " ;
		/* if(isset($data['week']) && $data['week']>0){
			$week = sprintf("%02d",$data['week']);
			$fweekCondition = " fweek = '{$year}-{$week}'";
		}else{
			$fweekCondition = " fweek LIKE '{$year}-%'";
		} */
		if(isset($data['from_week']) && isset($data['to_week'])){
			//echo "a";exit();
			$year = $data['year'];
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$to = $year."-".sprintf("%02d",$data['to_week']);
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' "; 
		} 
		else if (isset($data['from_week'])){ 
			//echo "b";exit();
			$year = $data['year'];
			$cryear = date('Y');
			$query = "SELECT max(epi_week_numb) as max_week from epi_weeks where year='{$year}'";
			$result_max_week = $this -> db -> query($query);
			$max_week_num = $result_max_week -> row()->max_week;
			if($year == $cryear){
				$max_week_num = lastWeekAccordingToCurrentDate($year);
			}
			$data['to_week'] = 	$max_week_num;
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$to = $year."-".sprintf("%02d",$max_week_num);			
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year' ";  
		}
		else if (isset($data['to_week'])){ 
			//echo "c";exit();
			$data['from_week'] = '01';
			$year = $data['year'];
			$from = $year."-01";
			$to = $year."-".sprintf("%02d",$data['to_week']);
			//$wc = "fweek <= '$to' ";
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year'"; 
		}
		else{
			//echo "d";exit();
			$year = $data['year'];
			$cryear = date('Y');
			$query = "SELECT max(epi_week_numb) as max_week from epi_weeks where year='{$year}'";
			$result_max_week = $this -> db -> query($query);
			$max_week_num = $result_max_week -> row()->max_week;
			if($year == $cryear){
				$max_week_num = lastWeekAccordingToCurrentDate($year);
			}
			$data['from_week'] = '01';
			$data['to_week'] = 	$max_week_num;	
			//echo $max_week_num; exit();			
			$from = $year."-01";
			$to = $year."-".sprintf("%02d",$max_week_num);
			$fweekCondition = "fweek >= '$from' and fweek <= '$to' and year = '$year'";
			//$fweekCondition = "year = '$year'"; 
		}
		$currentweek = currentWeek($year);
		//$currentweek = lastWeek($year);		 
		if ($currentweek == '00')
		{
			$wc_c = "";
		}
		else {
			$wc_c = "and epi_week_numb <= '$currentweek'" ;
		}
		//echo $wc_c ; exit;
		if($reportType == 'wwise'){
			$title = "Weekly VPD Report";
			$query = "SELECT 'Week-'||trim(both ' ' from to_char(epi_week_numb,'00')) as \"Week Numb\",year,";
			// $measlesonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";			
			// $afponsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM case_date_onset),'0000')) = '{$year}' ";
			// $nntonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_onset),'0000')) = '{$year}' ";
			// $vpdonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";
			$measlesonsetCondition = " AND year = '{$year}'";			
			$afponsetCondition = " AND year = '{$year}' ";
			$nntonsetCondition = " AND year = '{$year}' ";
			$coronavirusonsetCondition = " AND year = '{$year}'";
			$vpdonsetCondition = " AND year = '{$year}' ";
			if($distcode>0)
				$wc = " AND distcode='{$distcode}' AND fweek=epi_weeks.year||'-'||trim(both ' ' from to_char(epi_weeks.epi_week_numb,'00'))";
			else
				$wc = " AND fweek=epi_weeks.year||'-'||trim(both ' ' from to_char(epi_weeks.epi_week_numb,'00'))";
		}
		else if($reportType == 'dwise'){
			$title = "District wise VPD Report";
			$query = "SELECT distcode as \"District Code\",districtname(distcode) as \"District Name\",";
			$wc = "AND distcode=districts.distcode ";
			//$measlesonsetCondition = "AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";			
			//$afponsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM case_date_onset),'0000')) = '{$year}' ";
			//$nntonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_onset),'0000')) = '{$year}' ";
			//$vpdonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";
			$measlesonsetCondition = " AND year = '{$year}'";
			$afponsetCondition = " AND year = '{$year}' ";
			$nntonsetCondition = " AND year = '{$year}' ";
			$coronavirusonsetCondition = " AND year = '{$year}'";
			$vpdonsetCondition = " AND year = '{$year}' ";
		}
		else{            			
		    $title = "Facility VPD Report";			 
			$query = "SELECT facode as \"Facility Code\",facilityname(facode) as \"Facility Name\",";
			$wc = "AND facode=facilities.facode";
			// $measlesonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";			
			// $afponsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM case_date_onset),'0000')) = '{$year}' ";
			// $nntonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_onset),'0000')) = '{$year}' ";
			// $vpdonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(YEAR FROM date_rash_onset),'0000')) = '{$year}' ";
			$measlesonsetCondition = " AND year = '{$year}'";
			$afponsetCondition = " AND year = '{$year}' ";
			$nntonsetCondition = " AND year = '{$year}' ";
			$coronavirusonsetCondition = " AND year = '{$year}'";
			$vpdonsetCondition = " AND year = '{$year}' ";
		}
		$query .= " (SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'Msl' {$wc} {$wc_pro}{$measlesonsetCondition} and fweek <> '{$year}-00') as measles,
					(SELECT COUNT(*) FROM afp_case_investigation WHERE {$fweekCondition}{$wc} {$wc_pro} {$afponsetCondition} and fweek <> '{$year}-00') as \"AFP\",
					(SELECT COUNT(*) FROM nnt_investigation_form WHERE {$fweekCondition}{$wc}{$wc_pro} {$nntonsetCondition} and fweek <> '{$year}-00') as \"NNT\",
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'Diph' {$wc} {$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as diphtheria,
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'Pert' {$wc} {$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as pertussis,
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'ChTB' {$wc}{$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as \"Childhood TB\",
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'Pneu' {$wc} {$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as pneumonia,
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'Men' {$wc} {$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as meningitis,
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} AND case_type = 'AVHep' {$wc} {$wc_pro} {$vpdonsetCondition} and fweek <> '{$year}-00') as hepatitis,
					(SELECT COUNT(*) FROM corona_case_investigation_form_db WHERE {$fweekCondition} AND case_type = 'Covid' {$wc} {$wc_pro} {$coronavirusonsetCondition} and fweek <> '{$year}-00') as coronavirus,
					((SELECT COUNT(*) FROM afp_case_investigation WHERE {$fweekCondition} {$wc} {$wc_pro} {$afponsetCondition} and fweek <> '{$year}-00') +
					(SELECT COUNT(*) FROM nnt_investigation_form WHERE {$fweekCondition} {$wc}{$wc_pro} {$nntonsetCondition} and fweek <> '{$year}-00') +
					(SELECT COUNT(*) FROM corona_case_investigation_form_db WHERE {$fweekCondition} AND case_type = 'Covid' {$wc} {$wc_pro} {$coronavirusonsetCondition} and fweek <> '{$year}-00') +
					(SELECT COUNT(*) FROM case_investigation_db WHERE {$fweekCondition} {$wc} {$wc_pro} AND (case_type = 'Msl' OR case_type = 'Diph' OR case_type = 'Pert' OR case_type = 'ChTB' OR case_type = 'Pneu' OR case_type = 'Men' OR case_type = 'AVHep') {$wc} {$vpdonsetCondition} and fweek <> '{$year}-00') 
					) as \"Total VPDs Cases\" ";
		if($reportType == 'wwise'){
			$query .= " FROM epi_weeks where {$fweekCondition} {$wc_c} ORDER BY epi_week_numb ASC";
		}
		else if($reportType == 'dwise'){
			//$query .= " FROM districts ORDER BY district";
			// if(isset($fedDrilldown)){
			// 	$query .= " FROM districts ORDER BY dist_order";
			// }
			// else{
			$query .= " FROM districts ORDER BY district";
			//}
		}
		else{
			$query .= " FROM facilities WHERE hf_type='e' AND distcode='{$distcode}' ORDER BY fac_name";
		}
		//echo $query; exit();
		$dataReturned['totalResult'] = $this -> db -> query($query) -> result_array();
		//echo $this->db->last_query(); exit();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPID_Count_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['htmlData'] = getListingReportTable($dataReturned['totalResult'],'','','','','YES');
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['data'] = $data;
		return $dataReturned;
	}
	
	public function disease_outbreak($data)
	{	
		//print_r($data); 
		$disease = $data['disease'];
		//echo ($data['from_week']); exit;
		if(isset($data['from_week']) && isset($data['to_week'])){
			//echo "a";exit();
			$year = $data['year'];
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$to = $year."-".sprintf("%02d",$data['to_week']);
			$wc = "fweek >= '$from' and fweek <= '$to' "; 
		} 
		else if (isset($data['from_week'])){ 
			//echo "b";exit();
			$year = $data['year'];
			$from = $year."-".sprintf("%02d",$data['from_week']);
			$wc = "fweek >= '$from' and year = '$year' "; 
		}
		else if (isset($data['to_week'])){ 
			//echo "c";exit();
			$year = $data['year'];
			$from = $year."-01";
			$to = $year."-".sprintf("%02d",$data['to_week']);
			//$wc = "fweek <= '$to' ";
			$wc = "fweek >= '$from' and fweek <= '$to' and year = '$year'"; 
		}
		else {
			//echo "d";exit();
			$year = $data['year'];
			$wc = "year = '$year'";
		}
		
		$currentweek = lastWeek($year); 
		if ($currentweek == '00')
		{
			$wc_c = "";
		}
		else {
			$wc_c = " and epi_week_numb <= '$currentweek'" ;
		}
		//echo $wc_c; exit;
		//echo $from, $to ;
		//echo $wc ; exit;
		$disease=str_replace('%20',' ',$disease);
		switch($disease)
		{
			case 'measles':
				$table = "case_investigation_db";
				$case_type = "0";
				$case_typewc = " and case_type = 'Msl' ";
				break;
			case 'nnt':
				$table = "nnt_investigation_form";
				$case_type = "0";
				$case_typewc = "";
				break;
			case 'afp':
				$table = "afp_case_investigation";
				$case_type = "0";
				$case_typewc = "";
				break;
			case 'diphtheria':
				$table = "case_investigation_db";
				$case_type = "Diphtheria";
				$case_typewc = " and case_type = 'Diph' ";
				break;
			case 'childhood tb':
				$table = "case_investigation_db";
				$case_type = "Childhood TB";
				$case_typewc = " and case_type = 'ChTB' ";
				break;
			case 'pertussis':
				$table = "case_investigation_db";
				$case_type = "Pertussis";
				$case_typewc = " and case_type = 'Pert' ";
				break;
			case 'pneumonia':
				$table = "case_investigation_db";
				$case_type = "Pneumonia";
				$case_typewc = " and case_type = 'Pneu' ";
				break;
			case 'meningitis':
				$table = "case_investigation_db";
				$case_type = "Meningitis";
				$case_typewc = " and case_type = 'Men' ";
				break;
			case 'hepatitis':
				$table = "case_investigation_db";
				$case_type = "Hepatitis";
				$case_typewc = " and case_type = 'AVHep' ";
				break;
			case 'all':
				$table = "";
				$case_type = "";
				break;
		}
		//echo $year ; 
		$rec_exist = FALSE;
		if(isset($data['distcode']) AND $data['distcode'] > 0)
		{
			if(!isset($data['uncode'])){
				$tehsilWC = "";
				if(isset($data['tcode']) AND $data['tcode'] > 0)
					$tehsilWC = " AND tcode = '{$data['tcode']}' ";
				$distcode = $data['distcode'];
				//$query = "SELECT distinct fweek FROM {$table} WHERE {$wc} and distcode='{$distcode}' {$tehsilWC} {$case_typewc} ORDER BY fweek";
				$query = "SELECT distinct fweek FROM epi_weeks WHERE {$wc} {$wc_c} ORDER BY fweek";
				//echo $query;exit();
				$result = $this->db->query($query)->result_array();
				$w_portion = "SELECT uncode, unname(uncode) AS \"Union Council Name\", ";
				$t_portion = "SELECT ";
				foreach ($result as $key => $value) 
				{
					$week = substr($value['fweek'], 5);
					//echo $week;exit();
					if($week == '00'){						
					}
					else{
						$w_portion .= "(SELECT cnt$key FROM (SELECT CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as cnt$key FROM $table WHERE fweek='{$value['fweek']}' AND patient_address_uncode=unioncouncil.uncode AND length(patient_address_uncode)=9 group by patient_address_uncode) as a$key) AS \"Week $week\",";
						//exit();
	            		//print_r($w_portion);exit();
						$t_portion .= " sum(\"Week $week\") AS \"Total Week $week\",";
						$rec_exist = TRUE;
					}
				}
				$w_portion = rtrim($w_portion, ',');
				$w_portion .= " FROM unioncouncil WHERE distcode='$distcode' {$tehsilWC} ";//exit;
				//$w_portion .= " FROM $table WHERE distcode='$distcode' {$tehsilWC} ";//exit;
				//print_r($w_portion);exit();
			}
		}
		else if(isset($data['uncode']) AND $data['uncode'] > 0)
		{
			$tehsilWC = "";
			if(isset($data['tcode']) AND $data['tcode'] > 0)
				$tehsilWC = " AND tcode = '{$data['tcode']}' ";
			$uncode = $data['uncode'];
			$query = "SELECT distinct fweek FROM epi_weeks WHERE {$wc} {$wc_c} and uncode='{$uncode}' {$tehsilWC} {$case_typewc} ORDER BY fweek";
			$result = $this->db->query($query)->result_array();
			$w_portion = "SELECT vcode, villagename(vcode) AS \"Village Name\", ";
			$t_portion = "SELECT ";
			foreach ($result as $key => $value) 
			{
				$week = substr($value['fweek'], 5);
				$w_portion .= "(SELECT cnt$key FROM (SELECT CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as cnt$key FROM $table WHERE fweek='{$value['fweek']}' {$case_typewc} AND patient_address_uncode=unioncouncil.uncode AND length(patient_address_uncode)=9 group by patient_address_uncode) as a$key) AS \"Week $week\",";
               //print_r($w_portion);break;
				$t_portion .= " sum(\"Week $week\") AS \"Total Week $week\",";
				$rec_exist = TRUE;
			}
			$w_portion = rtrim($w_portion, ',');
            //echo $w_portion;exit();
			$w_portion .= " FROM villages WHERE uncode='$uncode' {$tehsilWC} ";//exit;
		}
		else
		{
			//$query = "SELECT distinct fweek FROM $table WHERE {$wc} {$case_typewc} ORDER BY fweek";
			$query = "SELECT distinct fweek FROM epi_weeks WHERE {$wc} {$wc_c} ORDER BY fweek";
			//echo $query; exit();
			$result = $this->db->query($query)->result_array();
			$w_portion = "SELECT distcode, districtname(distcode), ";
			$t_portion = "SELECT ";
			foreach ($result as $key => $value) 
			{
				$week = substr($value['fweek'], 5);
				$w_portion .= "(SELECT SUM(cnt$key) FROM (SELECT CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as cnt$key FROM $table WHERE fweek='{$value['fweek']}' {$case_typewc} AND distcode=districts.distcode AND length(patient_address_uncode)=9 group by patient_address_uncode) as b$key) AS \"Week $week\",";
				$t_portion .= " sum(\"Week $week\") AS \"Total Week $week\",";
				$rec_exist = TRUE;
			}
			$w_portion = rtrim($w_portion, ',');
			$w_portion .= " FROM districts";
		}
		$t_portion = rtrim($t_portion, ',');
		$t_portion .= " FROM ($w_portion) AS b";
		$result = array();
		$result_total = array();
		if($rec_exist)
		{
			$result = $this->db->query($w_portion)->result_array();
			//echo $this->db->last_query(); exit();
			$result_total = $this->db->query($t_portion)->result_array();
		}
		//echo $this->db->last_query(); exit();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Disease_Outbreak.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$title = "Disease Outbreak Report";
		// $dataReturned['htmlData'] = getListingReportTable($result,$result_total,'','','','YES');
		$dataReturned['htmlData'] = getListingReportTable($result,$result_total,'','','','YES',TRUE);
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['data'] = $data;
		//print_r($dataReturned['data']); exit;
		return $dataReturned;
	}
	function OutbreakResponse($data,$title)
	{
		// print_r($data);
		$monthfrom = $data['monthfrom']; 		   
		$monthto = $data['monthto']; 		   
		/*echo isset($data['distcode']);exit;   */
		$procode=$this->session->Province;
		//$year=$data['year'];

		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' and disease = '".$data['disease']."' and date_of_activity BETWEEN '".$monthfrom."' and '".$monthto."' ";
			$data1 = array($data['distcode'], $data['disease']);
			$dataReturned['distcode'] = $data['distcode'];
		}
		else{
			$wc = " procode = '".$procode."' and disease = '".$data['disease']."' ";
			$data1 = array("procode" => $procode , $data['disease']);
			$dataReturned['distcode'] = "";
		}
		//print_r($wc);
		
		$query = "SELECT distcode, district , COALESCE(sum(reported_case_base_surveillance),0) as \"Reported through case based surveillance\",  COALESCE(sum(active_search_case),0) as \"Active search Cases\", COALESCE(sum(epi_linked_case),0) as \"Epi linked Cases\", sum(\"BCG\") as bcg, sum(\"OPV 0\") as opv0, sum(\"PCV 10\") as pcv10, sum(\"Penta 1\") as penta1, sum(\"Penta 2\") as penta2, sum(\"Penta 3\") as penta3, sum(\"IPV\") as ipv, sum(\"Measles I\") as measles1, sum(\"Measles II\") as measles2, sum(\"TCV\") as tcv,sum(\"Measles Booster Dose\") as \"Measles Booster Dose\",sum(\"Penta Booster Dose\") as \"Penta Booster Dose\",sum(\"TD/DtaP/Dt\") as \"TD/DtaP/Dt\", sum(\"Age Group Form (Months)\") as \"Age Group Form (Months)\", sum(\"Age Group To (Months)\") as \"Age Group To (Months)\", sum(\"No. of blood samples collected\") as \"No. of blood samples collected\", sum(\"No. of Throat/ Oral Swabs Collected\") as \"No. of Throat/ Oral Swabs Collected\" from (select distcode, districtname(distcode) as district, date_of_activity as \"Date of Actvity\", unname(uncode) as \"Union Council\", villagename(vcode) as \"Village\", reported_case_base_surveillance ,  active_search_case , epi_linked_case ,
			sum(case when vaccines='BCG' then total_m_f else 0 end) as \"BCG\", 
			sum(case when vaccines='OPV 0' then total_m_f else 0 end) as \"OPV 0\", 
			sum(case when vaccines='PCV 10' then total_m_f else 0 end) as \"PCV 10\", 
			sum(case when vaccines='Penta 1' then total_m_f else 0 end) as \"Penta 1\", 
			sum(case when vaccines='Penta 2' then total_m_f else 0 end) as \"Penta 2\", 
			sum(case when vaccines='Penta 3' then total_m_f else 0 end) as \"Penta 3\", 
			sum(case when vaccines='IPV' then total_m_f else 0 end) as \"IPV\", 
			sum(case when vaccines='TCV' then total_m_f else 0 end) as \"TCV\",
			sum(case when vaccines='Measles I' then total_m_f else 0 end) as \"Measles I\", 
			sum(case when vaccines='Measles II' then total_m_f else 0 end) as \"Measles II\", 
			sum(case when vaccines='Msl Booster Dose' then total_m_f else 0 end) as \"Measles Booster Dose\",
			sum(case when vaccines='Penta Booster Dose' then total_m_f else 0 end) as \"Penta Booster Dose\", 
			sum(case when vaccines='TD/DtaP/Dt' then total_m_f else 0 end) as \"TD/DtaP/Dt\",
				age_group_from as \"Age Group Form (Months)\", age_group_to as \"Age Group To (Months)\", blood_speciment_collected as \"No. of blood samples collected\", oral_swabs_collected as \"No. of Throat/ Oral Swabs Collected\", follow_up_visit as \"Folow up Visit\" from case_response_tbl where $wc group by distcode, date_of_activity, uncode, vcode, reported_case_base_surveillance, active_search_case, epi_linked_case, age_group_from, age_group_to, blood_speciment_collected, oral_swabs_collected, follow_up_visit order by distcode, date_of_activity) as a group by district, distcode" ;
		$result = $this -> db -> query($query);
		$dataReturned['allData'] = $result -> result_array();
		//print_r($dataReturned['allData']); exit();
		//echo $this-> db-> last_query(); exit();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Disease_Outbreak_Response.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//print_r($dataReturned['allData']);exit;
		//$dataReturned["year"] = $data['year'];

		//$dataReturned['year'] = $data['year'];
		$dataReturned['monthfrom'] = $monthfrom;
		$dataReturned['monthto'] = $monthto ;
		$dataReturned['disease'] = $data['disease'];
		$dataReturned['pageTitle']='Measles Response Compliance';
		//print_r($data1); exit;
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data1);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//print_r($dataReturned); exit;
		return $dataReturned;
	}
	public function OutbreakResponseMeasles($data,$title){
		$procode=$this->session->Province;
		//print_r($data); exit;
		$monthfrom = $data['monthfrom']; 		   
		$monthto = $data['monthto'];
		if(isset($data['distcode']) != ""){
			$wc = " distcode = '".$data['distcode']."' and disease = '".$data['disease']."' and date_of_activity BETWEEN '".$monthfrom."' and '".$monthto."' ";
			$data1 = array($data['distcode'], $data['disease']);
		}else{
			$wc = " procode = '".$procode."' and disease = '".$data['disease']."' ";
			$data1 = array("procode" => $procode, $data['disease']);
		}
		//echo $wc; exit;
		/* $query ="select districtname(distcode) as District, 
				date_of_activity as \"Date of Actvity\", 
				unname(uncode) as \"Union Council\", 
				villagename(vcode) as Village, 
				COALESCE(reported_case_base_surveillance,0) as \"Reported through case based surveillance\",  
				COALESCE(active_search_case,0) as \"Active search Cases\", COALESCE(epi_linked_case,0) as \"Epi linked Cases\",
				sum(case when vaccines='BCG' then total_m_f else 0 end) as \"BCG\", 
				sum(case when vaccines='OPV 0' then total_m_f else 0 end) as \"OPV 0\", 
				sum(case when vaccines='PCV 10' then total_m_f else 0 end) as \"PCV 10\", 
				sum(case when vaccines='Penta 1' then total_m_f else 0 end) as \"Penta 1\", 
				sum(case when vaccines='Penta 2' then total_m_f else 0 end) as \"Penta 2\", 
				sum(case when vaccines='Penta 3' then total_m_f else 0 end) as \"Penta 3\", 
				sum(case when vaccines='TD/DtaP/Dt' then total_m_f else 0 end) as \"TD/DtaP/Dt\",
				sum(case when vaccines='IPV' then total_m_f else 0 end) as \"IPV\", 
				sum(case when vaccines='Measles I' then total_m_f else 0 end) as \"Measles I\", 
				sum(case when vaccines='Measles II' then total_m_f else 0 end) as \"Measles II\", 
				sum(case when vaccines='Msl Booster Dose' then total_m_f else 0 end) as \"Measles Booster Dose\", 
				sum(case when vaccines='Penta Booster Dose' then total_m_f else 0 end) as \"Penta Booster Dose\",
				COALESCE(age_group_from,0) as \"Age Group Form (Months)\", 
				COALESCE(age_group_to,0) as \"Age Group To (Months)\", 
				blood_speciment_collected as \"No. of blood samples collected\", 
				oral_swabs_collected as \"No. of Throat/ Oral Swabs Collected\", 
				follow_up_visit as \"Folow up Visit\" 
				from case_response_tbl 
				where $wc 
				group by distcode, date_of_activity, uncode, vcode, reported_case_base_surveillance, active_search_case, epi_linked_case, age_group_from, age_group_to, blood_speciment_collected, oral_swabs_collected, follow_up_visit 
				order by distcode, date_of_activity"; */
		$query = "select districtname(distcode) as \"District\", date_of_activity as \"Date of Actvity\", unname(uncode) as \"Union Council\", villagename(vcode) as \"Village\", COALESCE(reported_case_base_surveillance,0) as \"Reported through case based surveillance\", COALESCE(active_search_case,0) as \"Active search Cases\", COALESCE(epi_linked_case,0) as \"Epi linked Cases\",
				sum(case when vaccines='BCG' then total_m_f else 0 end) as \"BCG\", 
				sum(case when vaccines='OPV 0' then total_m_f else 0 end) as \"OPV 0\", 
				sum(case when vaccines='PCV 10' then total_m_f else 0 end) as \"PCV 10\", 
				sum(case when vaccines='Penta 1' then total_m_f else 0 end) as \"Penta 1\", 
				sum(case when vaccines='Penta 2' then total_m_f else 0 end) as \"Penta 2\", 
				sum(case when vaccines='Penta 3' then total_m_f else 0 end) as \"Penta 3\", 
				sum(case when vaccines='TD/DtaP/Dt' then total_m_f else 0 end) as \"TD/DtaP/Dt\",
				sum(case when vaccines='IPV' then total_m_f else 0 end) as \"IPV\", 
				sum(case when vaccines='Measles I' then total_m_f else 0 end) as \"Measles I\", 
				sum(case when vaccines='Measles II' then total_m_f else 0 end) as \"Measles II\", 
				sum(case when vaccines='TCV' then total_m_f else 0 end) as \"TCV\", 							
				sum(case when vaccines='Msl Booster Dose' then total_m_f else 0 end) as \"Measles Booster Dose\",
				sum(case when vaccines='Penta Booster Dose' then total_m_f else 0 end) as \"Penta Booster Dose\", COALESCE(age_group_from,0) as \"Age Group Form (Months)\", COALESCE(age_group_to,0) as \"Age Group To (Months)\", blood_speciment_collected as \"No. of blood samples collected\", oral_swabs_collected as \"No. of Throat/ Oral Swabs Collected\", follow_up_visit as \"Folow up Visit\" from case_response_tbl where $wc group by distcode, date_of_activity, uncode, vcode, reported_case_base_surveillance, active_search_case, epi_linked_case, age_group_from, age_group_to, blood_speciment_collected, oral_swabs_collected, follow_up_visit order by distcode, date_of_activity" ;
		$result = $this -> db -> query($query);
		$dataReturned['allData'] = $result -> result_array();
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Disease_Outbreak_Response.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['pageTitle']='Measles Response Compliance';
//print_r($dataReturned['allData']); exit;
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data1);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//print_r($dataReturned); exit;
		return $dataReturned;
}
public function outbreak_report_list($distcode,$date_of_activity_from,$date_of_activity_to)
	{
		$this-> db-> select('vaccines');
		$this->db->select_sum('0_11_m_m');
		$this->db->select_sum('0_11_m_f');
		$this->db->select_sum('12_23_m_m');
		$this->db->select_sum('12_23_m_f');
		$this->db->select_sum('years_m');
		$this->db->select_sum('years_f');
		$this->db->select_sum('total_m');
		$this->db->select_sum('total_f');
		$this->db->select_sum('total_m_f');		
		$this-> db-> from('case_response_tbl');		
		if($distcode > 0 ){
			$this-> db-> where('distcode',$distcode);
			/* if($tcode > 0)
			$this-> db-> where('tcode',$tcode);
			if($uncode> 0 )
			$this-> db-> where('uncode',$uncode);
			if($vcode > 0)
			$this-> db-> where('vcode',$vcode); */
		}
	   	if($date_of_activity_from >0)
	   	$this-> db-> where("date_of_activity>=",$date_of_activity_from);
		if($date_of_activity_to >0)
		$this->db->where("date_of_activity<=",$date_of_activity_to);
		/* if($age_group_from > 0)
		$this-> db-> where('age_group_from>=',$age_group_from);
		if($age_group_to > 0)
		$this-> db-> where('age_group_to<=',$age_group_to); */
		$this->db->group_by('vaccines');		
		$data['outbreak_report'] = $this-> db-> get()-> result_array();
		//print_r($this->db->last_query()); exit;
		//print_r($data); exit;
		return $data;
	}
}
?>