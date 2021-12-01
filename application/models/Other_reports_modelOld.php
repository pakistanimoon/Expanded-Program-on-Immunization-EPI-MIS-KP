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
								"measle_case_investigation" => "1",
								"afp_case_investigation" => "4",
								"nnt_investigation_form" => "2"
						);
			$table = "measle_case_investigation";
			$doses = "2";
			//$queryForYearlyData="'' as \"Disease\", ";
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
				//$query = 'select id  , name,  ' . $monthlyPortion . '  from vpd_diseases order by id ';
				$query = 'select ' . $outerPortion . ' from (' . $monthlyPortion . ') as a';
				//exit;
				$result = $this -> db -> query($query);
				$data['allData'][$j] = $result -> row_array();
				$j++;
				
			}
			//$data['allData'] = $disease;
			//echo $monthlyPortion;exit;
			/* $asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(facode)  from afp_case_investigation where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";
			$this -> db -> select ($monthlyPortion);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query(); */
			
			//$queryForTotal = 'select * from (' . $monthlyPortion . ') as b';
			//echo $queryForTotal;exit;
			//$resultTotal = $this -> db -> query($queryForTotal);
			//$data['allDataTotal'] = $resultTotal -> result_array();
			$dataReturned["htmlData"] = getComplianceReportTable($data['allData'],'','',"YES");
			//print_r($result1);exit;
		}else{
			
		}
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
		//print_r($wc);exit;
	}
	
	function EPID($data){
		$reportType = $data['report_type'];
		$dateFrom = $data['monthfrom'];
		$dateTo = $data['monthto'];
		if($reportType == 'wgender' OR $reportType == 'mgender'){
				$dataReturned['secondHeaderCount'] = 2;
				$dataReturned['secondHeaderArray'] = array('M','F');
		}else if($reportType == 'wage' OR $reportType == 'mage'){
			$dataReturned['secondHeaderCount'] = 5;
			$dataReturned['secondHeaderArray'] = array('<9M','9-23M','24-59M','60-119M','>=120M');
		}else{}
		$query = "SELECT distcode,districtname(distcode),";
		$disease = $data['disease'];
		switch($disease){
			case 'measles':
				$table = "measle_case_investigation";
				$case_type = "0";
				break;
			case 'nnt':
				$table = "nnt_investigation_form";
				$case_type = "0";
				break;
			case 'afp':
				$table = "afp_case_investigation";
				$case_type = "0";
				break;
			case 'diphtheria':
				$table = "weekly_vpd";
				$case_type = "Diphtheria";
				break;
			case 'childhood tb':
				$table = "weekly_vpd";
				$case_type = "Childhood TB";
				break;
			case 'pertussis':
				$table = "weekly_vpd";
				$case_type = "Pertussis";
				break;
			case 'pneumonia':
				$table = "weekly_vpd";
				$case_type = "Pneumonia";
				break;
			case 'meningitis':
				$table = "weekly_vpd";
				$case_type = "Meningitis";
				break;
			case 'hepatitis':
				$table = "weekly_vpd";
				$case_type = "Hepatitis";
				break;
			case 'all':
				$table = "";
				$case_type = "";
				break;
		}
		
		$case_type = ($case_type != '0')?" AND case_type = '{$case_type}' ":"";
		$gender = ($table == 'weekly_vpd')?'':'patient_';
		
		if($reportType == 'wgender' OR $reportType == 'wage'){
			$title = "Weekly Case Count";
			$this -> db -> select('epi_week_numb as numb,year');
			$this -> db -> from('epi_weeks');
			$this -> db -> where(array(
				'date_from >=' => $dateFrom.'-01',
				'date_from <=' => date("Y-m-t", strtotime($dateTo))//date($dateTo.'-t')
			));
			$this -> db -> order_by('year,epi_week_numb','ASC');
			$weeks = $this -> db -> get() -> result_array();
			foreach($weeks as $key => $val){
				$fweek = $val['year'].'-'.sprintf('%02d',$val['numb']);
				$dataReturned['firstHeaderArray'][] = 'Week-'.sprintf('%02d',$val['numb'])." ".$val['year'];
				if($reportType == 'wage'){
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"0-11M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"12-23M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"24-59M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"60-120M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \">120M{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"0-11M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"12-23M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"24-59M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"60-120M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 120 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 120 AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \">120M{$key}\",";
					}
				}else{
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '1' AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"Male{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '0' AND fweek = '{$fweek}' {$case_type} AND distcode=districts.distcode) as \"Female{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '1' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '1' AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"Male{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '0' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND fweek = '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '0' AND fweek = '{$fweek}' AND distcode=districts.distcode)) as \"Female{$key}\",";
					}
				}
			}
			if($reportType == 'wage'){
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total 0-11{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total 12-23{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total 24-59{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total 60-120{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total >120{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total 0-11{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total 12-23{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total 24-59{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total 60-120{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 120 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 120 AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total >120{$key}\" ,";
				}
			}else{
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '1' {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total Male{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '0' {$case_type} AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode) as \"Grand Total Female{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '1' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '1' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total Male{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '0' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '0' AND fweek >= '".$weeks[0]['year'].'-'.sprintf('%02d',$weeks[0]['numb'])."' AND fweek <= '{$fweek}' AND distcode=districts.distcode)) as \"Grand Total Female{$key}\" ,";
				}
			}
			$dataReturned['firstHeaderCount'] = sizeof($dataReturned['firstHeaderArray']);
		}
		if($reportType == 'mgender' OR $reportType == 'mage'){
			$title = "Monthly Case Count";
			$y1 = date('Y', strtotime($dateFrom));
			$y2 = date('Y', strtotime($dateTo));
			$m1 = date('m', strtotime($dateFrom));
			$m2 = date('m', strtotime($dateTo));
			$noOfMonthsSelected = (($y2 - $y1) * 12) + ($m2 - $m1) + 1;
			$dataReturned['firstHeaderCount'] = $noOfMonthsSelected;
			
			$start 		= (new DateTime($dateFrom))->modify('first day of this month');
			$end 		= (new DateTime($dateTo))->modify('first day of next month');
			$interval 	= DateInterval::createFromDateString('1 month');
			$period   	= new DatePeriod($start, $interval, $end); 

			foreach ($period as $key => $dt) {
				$dataReturned['firstHeaderArray'][] = $dt->format("M-Y");
				$startDate = $dt->format("Y-m");
				$weeksQuery = "select MIN(epi_week_numb),MAX(epi_week_numb) FROM epi_weeks WHERE date_from::TEXT LIKE '{$startDate}-%'";
				$minMaxWeeksForAMonth = $this -> db -> query($weeksQuery) -> row_array();
				$startWeek = $dt->format("Y").'-'.sprintf('%02d',$minMaxWeeksForAMonth['min']);
				$endWeek = $dt->format("Y").'-'.sprintf('%02d',$minMaxWeeksForAMonth['max']);
				if($key == 0){
					$firstWeek = $dt->format("Y").'-'.sprintf('%02d',$minMaxWeeksForAMonth['min']);
				}
				if($reportType == 'mage'){
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"0-11M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"12-23M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"24-59M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"60-120M{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \">120M{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 0 AND age_months < 9 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"0-11M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"12-23M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"24-59M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"60-120M{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 120 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 120 AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \">120M{$key}\",";
					}
				}else{
					if($disease != 'all'){
						$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '1' {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"Male{$key}\",
									(SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '0' {$case_type} AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode) as \"Female{$key}\",";
					}else{
						$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '1' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '1' AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"Male{$key}\",
									((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '0' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '0' AND (fweek BETWEEN   '{$startWeek}' AND  '{$endWeek}' ) AND distcode=districts.distcode)) as \"Female{$key}\",";
					}				
				}
			}
			if($reportType == 'mage'){
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE age_months >= 0 AND age_months < 9 {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total 0-11{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 9 AND age_months <= 23 {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total 12-23{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 24 AND age_months <= 59 {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total 24-59{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 60 AND age_months <= 119 {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total 60-120{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE age_months >= 120 {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total >120{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 0 AND age_months < 9 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 0 AND age_months < 9 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total 0-11{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 9 AND age_months <= 23 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 9 AND age_months <= 23 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total 12-23{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 24 AND age_months <= 59 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 24 AND age_months <= 59 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total 24-59{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 60 AND age_months <= 119 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 60 AND age_months <= 119 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total 60-120{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE age_months >= 120 AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE age_months >= 120 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE age_months >= 120 AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total >120{$key}\" ,";
				}
			}else{
				if($disease != 'all'){
					$query .= " (SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '1' {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total Male{$key}\" ,
								(SELECT COUNT(*) FROM {$table} WHERE {$gender}gender = '0' {$case_type} AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode) as \"Grand Total Female{$key}\" ,";
				}else{
					$query .= " ((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '1' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '1' AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '1' AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total Male{$key}\" ,
								((SELECT COUNT(*) FROM weekly_vpd WHERE gender = '0' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Pneumonia' OR case_type = 'Childhood TB' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM afp_case_investigation WHERE patient_gender = '0' AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)+(SELECT COUNT(*) FROM measle_case_investigation WHERE patient_gender = '0' AND fweek >= '{$firstWeek}' AND fweek <= '{$endWeek}' AND distcode=districts.distcode)) as \"Grand Total Female{$key}\" ,";
				}
			}
		}
		$query = rtrim($query,",");
		$query .= "FROM districts ORDER BY district";
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
		$reportType = $data['report_type'];
		$year = $data['year'];
		$distcode = isset($data['distcode'])?$data['distcode']:'';
		if(isset($data['week']) && $data['week']>0){
			$week = sprintf("%02d",$data['week']);
			$fweekCondition = " fweek = '{$year}-{$week}'";
		}else{
			$fweekCondition = " fweek LIKE '{$year}-%'";
		}
		if($reportType == 'wwise'){
			$title = "Weekly VPD Report";
			$query = "SELECT 'Week-'||trim(both ' ' from to_char(epi_week_numb,'00')) as \"Week Numb\",year,";
			if($distcode>0)
				$wc = "AND distcode='{$distcode}' AND fweek=epi_weeks.year||'-'||trim(both ' ' from to_char(epi_weeks.epi_week_numb,'00'))";
			else
				$wc = "AND fweek=epi_weeks.year||'-'||trim(both ' ' from to_char(epi_weeks.epi_week_numb,'00'))";
		}else if($reportType == 'mwise'){
			$title = "Monthly VPD Report";
			$measlesonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(MONTH FROM date_rash_onset),'00'))::numeric = TRIM(BOTH FROM to_char(epi_fmonths.id,'00'))::numeric ";
			$afponsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(MONTH FROM case_date_onset),'00'))::numeric = TRIM(BOTH FROM to_char(epi_fmonths.id,'00'))::numeric ";
			$nntonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(MONTH FROM date_onset),'00'))::numeric = TRIM(BOTH FROM to_char(epi_fmonths.id,'00'))::numeric ";
			$vpdonsetCondition = " AND TRIM(BOTH FROM to_char(EXTRACT(MONTH FROM case_date_onset),'00'))::numeric = TRIM(BOTH FROM to_char(epi_fmonths.id,'00'))::numeric ";
			$query = "SELECT shortname||'-".$year."' as \"Month Numb\",'".$year."' as year,";
			if($distcode>0)
				$wc = "AND distcode='{$distcode}'";
			else
				$wc = "";
		}else if($reportType == 'dwise'){
			$title = "District wise VPD Report";
			$query = "SELECT distcode as \"District Code\",districtname(distcode) as \"District Name\",";
			$wc = "AND distcode=districts.distcode";
		}else{
			$query = "SELECT facode as \"Facility Code\",facilityname(facode) as \"Facility Name\",";
			$wc = "AND facode=facilities.facode";
		}
		$query .= " (SELECT COUNT(*) FROM measle_case_investigation WHERE {$fweekCondition} {$wc} {$measlesonsetCondition} and fweek <> '{$year}-00') as measles,
					(SELECT COUNT(*) FROM afp_case_investigation WHERE {$fweekCondition} {$wc} {$afponsetCondition}) as \"AFP\",
					(SELECT COUNT(*) FROM nnt_investigation_form WHERE {$fweekCondition} {$wc} {$nntonsetCondition}) as \"NNT\",
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Diphtheria' {$wc} {$vpdonsetCondition}) as diphtheria,
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Pertussis' {$wc} {$vpdonsetCondition}) as pertussis,
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Childhood TB' {$wc} {$vpdonsetCondition}) as \"Childhood TB\",
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Pneumonia' {$wc} {$vpdonsetCondition}) as pneumonia,
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Meningitis' {$wc} {$vpdonsetCondition}) as meningitis,
					(SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND case_type = 'Hepatitis' {$wc} {$vpdonsetCondition}) as hepatitis,
					((SELECT COUNT(*) FROM measle_case_investigation WHERE {$fweekCondition} {$wc} {$measlesonsetCondition} and fweek <> '{$year}-00')+
					 (SELECT COUNT(*) FROM afp_case_investigation WHERE {$fweekCondition} {$wc} {$afponsetCondition})+
					 (SELECT COUNT(*) FROM nnt_investigation_form WHERE {$fweekCondition} {$wc} {$nntonsetCondition})+
					 (SELECT COUNT(*) FROM weekly_vpd WHERE {$fweekCondition} AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Childhood TB' OR case_type = 'Pneumonia' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') {$wc} {$vpdonsetCondition})
					) as \"Total VPDs Cases\" ";
		if($reportType == 'wwise'){
			$query .= " FROM epi_weeks WHERE {$fweekCondition} ORDER BY epi_week_numb ASC";
		}else if($reportType == 'mwise'){
			$query .= " FROM epi_fmonths ORDER BY id";
		}else if($reportType == 'dwise'){
			$query .= " FROM districts ORDER BY district";
		}else{
			$query .= " FROM facilities WHERE hf_type='e' AND distcode='{$distcode}' ORDER BY fac_name";
		}
		//echo $query;exit;
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
		$dataReturned['htmlData'] = getListingReportTable($dataReturned['totalResult'],'','','','','YES');
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['data'] = $data;
		return $dataReturned;
	}
	public function disease_outbreak($data)
	{
		$year = $data['year'];
		$disease = $data['disease'];
		$disease=str_replace('%20',' ',$disease);
		switch($disease)
		{
			case 'measles':
				$table = "measle_case_investigation";
				$case_type = "0";
				$case_typewc = "";
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
				$table = "weekly_vpd";
				$case_type = "Diphtheria";
				$case_typewc = " and case_type = 'Diphtheria' ";
				break;
			case 'childhood tb':
				$table = "weekly_vpd";
				$case_type = "Childhood TB";
				$case_typewc = " and case_type = 'Childhood TB' ";
				break;
			case 'pertussis':
				$table = "weekly_vpd";
				$case_type = "Pertussis";
				$case_typewc = " and case_type = 'Pertussis' ";
				break;
			case 'pneumonia':
				$table = "weekly_vpd";
				$case_type = "Pneumonia";
				$case_typewc = " and case_type = 'Pneumonia' ";
				break;
			case 'meningitis':
				$table = "weekly_vpd";
				$case_type = "Meningitis";
				$case_typewc = " and case_type = 'Meningitis' ";
				break;
			case 'hepatitis':
				$table = "weekly_vpd";
				$case_type = "Hepatitis";
				$case_typewc = " and case_type = 'Hepatitis' ";
				break;
			case 'all':
				$table = "";
				$case_type = "";
				break;
		}
		$rec_exist = FALSE;
		if(isset($data['distcode']) AND $data['distcode'] > 0)
		{
			$distcode = $data['distcode'];
			$query = "SELECT distinct fweek FROM $table WHERE year='$year' AND distcode='$distcode' ORDER BY fweek";
			$result = $this->db->query($query)->result_array();
			$w_portion = "SELECT uncode, unname(uncode) AS \"Union Council Name\", ";
			$t_portion = "SELECT ";
			foreach ($result as $key => $value) 
			{
				$week = substr($value['fweek'], 5);
				$w_portion .= "(SELECT SUM(cnt$key) FROM (SELECT CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as cnt$key FROM $table WHERE fweek='{$value['fweek']}' {$case_typewc} AND uncode=unioncouncil.uncode AND length(facode)=6 group by facode) as a$key) AS \"Week $week\",";
				$t_portion .= " sum(\"Week $week\") AS \"Total Week $week\",";
				$rec_exist = TRUE;
			}
			$w_portion = rtrim($w_portion, ',');
			$w_portion .= " FROM unioncouncil WHERE distcode='$distcode'";
		}
		else
		{
			$query = "SELECT distinct fweek FROM $table WHERE year='$year' ORDER BY fweek";
			$result = $this->db->query($query)->result_array();
			$w_portion = "SELECT distcode, districtname(distcode), ";
			$t_portion = "SELECT ";
			foreach ($result as $key => $value) 
			{
				$week = substr($value['fweek'], 5);
				$w_portion .= "(SELECT SUM(cnt$key) FROM (SELECT CASE WHEN count(*)>=5 THEN 1 ELSE 0 END as cnt$key FROM $table WHERE fweek='{$value['fweek']}' {$case_typewc} AND distcode=districts.distcode AND length(facode)=6 group by facode) as b$key) AS \"Week $week\",";
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
		//echo $t_portion;exit;
		if($rec_exist)
		{
			$result = $this->db->query($w_portion)->result_array();
			$result_total = $this->db->query($t_portion)->result_array();
		}
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=disease_outbreak.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$title = "Disease Outbreak Report";
		$dataReturned['htmlData'] = getListingReportTable($result,$result_total,'','','','YES');
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['data'] = $data;
		return $dataReturned;
	}
}
?>