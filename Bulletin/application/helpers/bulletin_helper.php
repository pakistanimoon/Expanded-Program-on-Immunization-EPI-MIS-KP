<?php
if(!function_exists('noOfDistricts_SubmittedZeroReportInA_Week')){		
	function noOfDistricts_SubmittedZeroReportInA_Week($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "SELECT COUNT(distcode) AS cnt FROM districts WHERE distcode IN (SELECT DISTINCT distcode FROM zero_report WHERE fweek >= '{$fweekfrom}' and fweek <= '{$fweekto}')";
		$result = $CI -> db -> query($query) -> row();
		return $result -> cnt;
	}
}
if(!function_exists('currentWeek')){
	function currentWeek($yearPassed=NULL){
		date_default_timezone_set ('Asia/Karachi');
		$CI = & get_instance();
		$year = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d");
		$query = "SELECT fweek AS num FROM epi_weeks WHERE date_from <= '{$current_date}' AND date_to >= '{$current_date}' AND year='{$year}'";
		$result = $CI -> db -> query($query) -> row();
		return $result->num;
	}
}
if(!function_exists('weekDates')){
	function weekDates($weekno){       
		date_default_timezone_set ('Asia/Karachi');
		$CI = & get_instance();
    	$query = "SELECT date_from,date_to FROM epi_weeks WHERE fweek = '{$weekno}'"; 
		$result = $CI -> db -> query($query) -> row();
		return date('D,M Y',strtotime($result -> date_from)).' - '.date('D,M Y',strtotime($result -> date_to)); 
	}
}
if(!function_exists('functionalFacilitiesInaWeek')){
	function functionalFacilitiesInaWeek($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "SELECT COUNT(facode) AS cnt FROM facilities WHERE getfstatus_ds('{$fweekto}',facode)='F' AND is_ds_fac='1' AND hf_type='e'";
		$result = $CI -> db -> query($query) -> row();
		return $result -> cnt;
	}
}
if(!function_exists('noOfFacilitiesWithZeroReportSubmittedInaWeek')){
	function noOfFacilitiesWithZeroReportSubmittedInaWeek($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "SELECT COUNT(DISTINCT facode) AS cnt FROM zero_report WHERE getfstatus_ds('{$fweekto}',facode)='F' AND fweek = '{$fweekto}' AND report_submitted='1'";
		$result = $CI -> db -> query($query) -> row();
		return $result -> cnt;
	}
}
if(!function_exists('totalSubmittedReportsInPeriod')){
	function totalSubmittedZeroReportsInPeriod($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$parts1 = explode('-', $fweekfrom);
		$wk1 = $parts1[1];
		$parts2 = explode('-', $fweekto);
		$wk2 = $parts2[1];
		$totWeeks = ($wk2 - $wk1) + 1;
		//echo $totWeeks;exit();
		$count = 0;
		for($i=$wk1; $i <= $wk2; $i++) {
			$epidweek = 0;
			$epidweek = sprintf('%02u', ($i));
			$fweek = $year.'-'.$epidweek;
			//echo $fweek;
			$query = "SELECT COUNT(facode) AS cnt FROM zero_report WHERE getfstatus_ds('{$fweek}',facode)='F' AND fweek = '{$fweek}' AND report_submitted='1'";
			$result = $CI -> db -> query($query) -> row();
			$count += $result -> cnt;
		}
		return $result -> cnt;
	}
}
if(!function_exists('functionalFacilitiesInPeriod')){
	function functionalFacilitiesInPeriod($year,$fweekfrom,$fweekto){
		//echo $fweekfrom; echo "-----"; echo $fweekto; exit();
		$CI = & get_instance();
		$parts1 = explode('-', $fweekfrom);
		$wk1 = $parts1[1];
		$parts2 = explode('-', $fweekto);
		$wk2 = $parts2[1];
		$totWeeks = ($wk2 - $wk1) + 1;
		//echo $totWeeks;exit();
		$count = 0;
		for($i=$wk1; $i <= $wk2; $i++) {
			$epidweek = 0;
			$epidweek = sprintf('%02u', ($i));
			$fweek = $year.'-'.$epidweek;
			//echo $fweek;
			$query = "SELECT COUNT(facode) AS cnt FROM facilities WHERE getfstatus_ds('{$fweek}',facode)='F' AND is_ds_fac='1' AND hf_type='e'";
			$result = $CI -> db -> query($query) -> row();
			$count += $result -> cnt;
		}
		return $count;
	}
}
if (!function_exists('totalCompletenessOfaPeriod')){
	function totalCompletenessOfaPeriod($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$parts1 = explode('-', $fweekfrom);
		$wk1 = $parts1[1];
		$parts2 = explode('-', $fweekto);
		$wk2 = $parts2[1];
		$totWeeks = ($wk2 - $wk1) + 1;
		//echo $totWeeks;exit();
		$total_completeness = 0;
		$reporting_facilities = 0;
		$tot_facilities = 0;
		for($i=$wk1; $i <= $wk2; $i++) {
			$epidweek = 0;
			$epidweek = sprintf('%02u', ($i));
			$fweek = $year.'-'.$epidweek;
			//echo $epidweek;
			$query = "SELECT COUNT(facode) AS reporting_facilities FROM zero_report WHERE fweek = '{$fweek}' AND getfstatus_ds('{$fweek}',facode)='F' AND report_submitted = '1'"; //exit();
			$result = $CI -> db -> query($query) -> row();
			$reporting_facilities += $result -> reporting_facilities; //exit();
			
			$query1 = "SELECT COUNT(facode) AS tot_facilities FROM facilities WHERE is_ds_fac='1' AND getfstatus_ds('{$fweek}',facode)='F' AND hf_type='e' "; //exit();
			$result1 = $CI -> db -> query($query1) -> row();
			$tot_facilities += $result1 -> tot_facilities;
		}
		$total_completeness = round($reporting_facilities*100/$tot_facilities,1);
		return $total_completeness;
	}
}
if (!function_exists('totalTimelinessOfaPeriod')){
	function totalTimelinessOfaPeriod($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$parts1 = explode('-', $fweekfrom);
		$wk1 = $parts1[1];
		$parts2 = explode('-', $fweekto);
		$wk2 = $parts2[1];
		$totWeeks = ($wk2 - $wk1) + 1;
		//echo $totWeeks;exit();
		$total_timeliness = 0;
		$reporting_facilities = 0;
		$tot_facilities = 0;
		for($i=$wk1; $i <= $wk2; $i++) {
			$epidweek = 0;
			$epidweek = sprintf('%02u', ($i));
			$fweek = $year.'-'.$epidweek;
			$query = "SELECT COUNT(facode) AS reporting_facilities FROM zero_report WHERE fweek = '{$fweek}' AND getfstatus_ds('{$fweek}',facode)='F' AND report_submitted = '1' AND submitted_date IS NOT NULL"; //exit();
			$result = $CI -> db -> query($query) -> row();
			$reporting_facilities += $result -> reporting_facilities; //exit();
			
			$query1 = "SELECT COUNT(facode) AS tot_facilities FROM facilities WHERE is_ds_fac='1' AND getfstatus_ds('{$fweek}',facode)='F' AND hf_type='e' "; //exit();
			$result1 = $CI -> db -> query($query1) -> row();
			$tot_facilities += $result1 -> tot_facilities;
		}
		$total_timeliness = round($reporting_facilities*100/$tot_facilities,1);
		return $total_timeliness;
	}
}
if(!function_exists('outbreakMeaslesUnioncouncils')){
	function outbreakMeaslesUnioncouncils($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "SELECT uncode,unname(uncode) as uc,districtname(distcode),fweek,COUNT(specimen_result) AS total_cases FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' GROUP BY uncode,fweek,distcode HAVING COUNT(specimen_result) >= 5 ORDER BY uncode";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
if(!function_exists('totalSuspectedMeaslesCases')){
	function totalSuspectedMeaslesCases($year){
		$CI = & get_instance();
		$query = "SELECT SUM(measle_cases) as cnt FROM zero_report WHERE fweek LIKE '{$year}-%'";
		$result = $CI -> db -> query($query) -> row();
		return $result -> cnt;
	}
}
if (!function_exists('totalCompletenessOfaWeek')){
	function totalCompletenessOfaWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT ROUND(reporting_facilities*100/tot_facilities) AS completeness 
						FROM
							(
								SELECT COUNT(DISTINCT facode) AS tot_facilities,
									(SELECT COUNT(DISTINCT facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek >= '{$fweekto}' AND getfstatus_ds(facode,'')='F' AND report_submitted = '1') AS reporting_facilities 
								FROM facilities 
								WHERE is_ds_fac='1' AND getfstatus_ds('{$fweekto}',facode)='F' AND hf_type='e'
							) AS a";
		$result = $CI -> db -> query($query) -> row();
		return $result -> completeness;
	}
}
if (!function_exists('totalTimelinessOfaWeek')){
	function totalTimelinessOfaWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT ROUND(reporting_facilities*100/tot_facilities) AS timeliness 
						FROM
							(
								SELECT COUNT(facode) AS tot_facilities,
									(SELECT COUNT(DISTINCT facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek<= '{$fweekto}' AND getfstatus_ds(facode,'')='F' AND report_submitted = '1' AND submitted_date IS NOT NULL) AS reporting_facilities 
								FROM facilities 
								WHERE is_ds_fac='1' AND getfstatus_ds('{$fweekto}',facode)='F' AND hf_type='e'
							) AS a";
		$result = $CI -> db -> query($query) -> row();
		return $result -> timeliness;
	}
}

if (!function_exists('percentageOfDistrictsAchived100PercComplianceInaWeek')){
	function percentageOfDistrictsAchived100PercComplianceInaWeek($year,$fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT COUNT(b.*)*100/25 AS percentage
						FROM 
							(
								SELECT ROUND(a.reporting_facilities*100/ (CASE WHEN a.tot_facilities > 0 THEN a.tot_facilities ELSE 1 END)) AS completeness 
								FROM 
									(
										SELECT 
											distcode,(SELECT COUNT(facode) FROM facilities fac WHERE is_ds_fac='1' AND getfstatus_ds(facode,'')='F' AND fac.distcode=districts.distcode) AS tot_facilities,
											(SELECT COUNT(DISTINCT facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND getfstatus_ds('{$fweekto}',facode)='F' AND report_submitted = '1' AND zero_report.distcode=districts.distcode) AS reporting_facilities  
										FROM districts 
									) AS a
							) AS b WHERE b.completeness::integer >= 100";
		$result = $CI -> db -> query($query) -> row();
		return $result -> percentage;
	}
}
if (!function_exists('percentageOfDistrictsAchived80PercComplianceInaWeek')){ 
	function percentageOfDistrictsAchived80PercComplianceInaWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT COUNT(b.*) as cnt,COUNT(b.*)*100/25 AS percentage
						FROM 
							(
								SELECT ROUND(a.reporting_facilities*100/(CASE WHEN a.tot_facilities > 0 THEN a.tot_facilities ELSE 1 END)) AS completeness 
								FROM 
									(
										SELECT 
											distcode,(SELECT COUNT(facode) FROM facilities fac WHERE is_ds_fac='1' AND getfstatus_ds(facode,'')='F' AND fac.distcode=districts.distcode) AS tot_facilities,
											(SELECT COUNT(DISTINCT facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND getfstatus_ds('{$fweekto}',facode)='F' AND report_submitted = '1' AND zero_report.distcode=districts.distcode) AS reporting_facilities  
										FROM districts 
									) AS a
							) AS b WHERE b.completeness::integer >= 80";
		return $result = $CI -> db -> query($query) -> row();
	}
}
if(!function_exists('commulativeTimelinessAndCompletenessForaWeek')){
	function commulativeTimelinessAndCompletenessForaWeek($weekno){
		$CI = & get_instance();
		$query = "
					SELECT 
						ROUND(SUM(reporting_facilities_completeness)*100/SUM(tot_facilities)) AS commulative_completeness,
						ROUND(SUM(reporting_facilities_timeliness)*100/SUM(tot_facilities)) AS commulative_timeliness
					FROM 
						(
							SELECT
								distcode,
								(SELECT COUNT(facode) FROM facilities fac WHERE is_ds_fac='1' AND getfstatus_ds('{$weekno}',facode)='F' AND fac.distcode=districts.distcode AND hf_type='e') AS tot_facilities,
								(SELECT COUNT(facode) FROM zero_report WHERE fweek = '{$weekno}' AND getfstatus_ds('{$weekno}',facode)='F' AND report_submitted = '1' AND zero_report.distcode=districts.distcode) AS reporting_facilities_completeness,
								(SELECT COUNT(facode) FROM zero_report WHERE fweek = '{$weekno}' AND getfstatus_ds('{$weekno}',facode)='F' AND report_submitted = '1' AND submitted_date IS NOT NULL AND zero_report.distcode=districts.distcode) AS reporting_facilities_timeliness  
							FROM districts 
						) AS a";
		return $result = $CI -> db -> query($query) -> row();
	}
}
if(!function_exists('districtWiseCommulativeTimelinessAndCompletenessForaWeek')){
	function districtWiseCommulativeTimelinessAndCompletenessForaWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT
						distcode,districtname(distcode) as district,
						CASE WHEN ROUND(reporting_facilities_completeness*100/(CASE WHEN tot_facilities > 0 THEN tot_facilities ELSE 1 END)) > 100 THEN 100 ELSE ROUND(reporting_facilities_completeness*100/(CASE WHEN tot_facilities > 0 THEN tot_facilities ELSE 1 END)) END AS commulative_completeness,
						CASE WHEN ROUND(reporting_facilities_timeliness*100/(CASE WHEN tot_facilities > 0 THEN tot_facilities ELSE 1 END)) > 100 THEN 100 ELSE ROUND(reporting_facilities_timeliness*100/(CASE WHEN tot_facilities > 0 THEN tot_facilities ELSE 1 END)) END AS commulative_timeliness
						FROM
						(
							SELECT
								distcode,
								(SELECT COUNT(facode) FROM facilities fac WHERE is_ds_fac='1' AND getfstatus_ds('{$fweekto}',facode)='F' AND fac.distcode=districts.distcode AND hf_type='e') AS tot_facilities,
								(SELECT COUNT(facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND getfstatus_ds('{$fweekto}',facode)='F' AND report_submitted = '1' AND zero_report.distcode=districts.distcode) AS reporting_facilities_completeness,
								(SELECT COUNT(facode) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND getfstatus_ds('{$fweekto}',facode)='F' AND report_submitted = '1' AND submitted_date IS NOT NULL AND zero_report.distcode=districts.distcode) AS reporting_facilities_timeliness  
							FROM districts 
						) AS a";
		return $result = $CI -> db -> query($query) -> result_array();
	}
}
if(!function_exists('tbCasesDetailsInaWeek')){
	function tbCasesDetailsInaWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT facilityname(facode),(SELECT unname(uncode) FROM facilities WHERE facode=zero_report.facode),districtname(distcode),tb_cases FROM zero_report WHERE tb_cases>0 and fweek >= '{$fweekfrom}' and fweek <= '{$fweekto}'";
		return $result = $CI -> db -> query($query) -> result_array();
	}
}
if(!function_exists('districtNotSubmittedTheirReportInSelectWeek')){
	function districtNotSubmittedTheirReportInSelectWeek($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT 
						ARRAY_TO_STRING(ARRAY_AGG(district),', ') AS districts 
						FROM 
							districts 
						WHERE 
							distcode NOT IN (
												SELECT DISTINCT distcode FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}'
											)";
		$result = $CI -> db -> query($query) -> row();
		return $result -> districts;
	}
}
if(!function_exists('getPreviousWeek')){
	function getPreviousWeek($fweekto){
		$CI = & get_instance();
		$query = "
					SELECT 
						fweek 
					FROM 
						epi_weeks 
					WHERE 
						fweek = (
									SELECT MAX(fweek) FROM epi_weeks WHERE fweek < '{$fweekto}'
								)";
		$result = $CI -> db -> query($query) -> row();
		return $result -> fweek;
	}
}
if (!function_exists('districtsWithComplianceGreaterThan80AndLessThan100')){
	function districtsWithComplianceGreaterThan80AndLessThan100($fweekfrom,$fweekto,$condition){
		$CI = & get_instance();
		$query = "
					SELECT array_to_string(array_agg(districtname(distcode)),',') AS districts
						FROM 
							(
								SELECT distcode,ROUND(a.reporting_facilities*100/(CASE WHEN a.tot_facilities > 0 THEN a.tot_facilities ELSE 1 END)) AS completeness 
								FROM 
									(
										SELECT 
											distcode,(SELECT sum(case when getfstatus_ds('{$fweekto}',facode) = 'F' then 1 else 0 end) FROM facilities fac WHERE is_ds_fac='1' AND hf_type='e' AND fac.distcode=districts.distcode) AS tot_facilities,
											(SELECT sum(case when getfstatus_ds('{$fweekto}',facode) = 'F' then 1 else 0 end) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND report_submitted = '1' AND zero_report.distcode=districts.distcode) AS reporting_facilities  
										FROM districts 
									) AS a
							) AS b ";
		if($condition == 1)
			$query .= "WHERE b.completeness::integer < 100 AND b.completeness::integer > 80";
		if($condition == 2)
			$query .= "WHERE b.completeness::integer < 80";
		$result = $CI -> db -> query($query) -> row();
		return $result -> districts;
	}
}
if (!function_exists('districtsWithTimelinessGreaterThan80AndLessThan100')){
	function districtsWithTimelinessGreaterThan80AndLessThan100($fweekfrom,$fweekto,$condition){
		$CI = & get_instance();
		$query = "
					SELECT array_to_string(array_agg(districtname(distcode)),',') AS districts
						FROM 
							(
								SELECT distcode,ROUND(a.reporting_facilities*100/a.tot_facilities) AS timeliness 
								FROM 
									(
										SELECT 
											distcode,(SELECT sum(case when getfstatus_ds('{$fweekto}',facode) = 'F' then 1 else 0 end) FROM facilities fac WHERE is_ds_fac='1' AND hf_type='e' AND fac.distcode=districts.distcode) AS tot_facilities,
											(SELECT sum(case when getfstatus_ds('{$fweekto}',facode) = 'F' then 1 else 0 end) FROM zero_report WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND report_submitted = '1' AND submitted_date IS NOT NULL AND zero_report.distcode=districts.distcode) AS reporting_facilities  
										FROM districts 
									) AS a
							) AS b ";
		if($condition == 1)
			$query .= "WHERE b.timeliness::integer < 100 AND b.timeliness::integer > 80";
		if($condition == 2)
			$query .= "WHERE b.timeliness::integer < 80";
		$result = $CI -> db -> query($query) -> row();
		return $result -> districts;
	}
}
if(!function_exists('countOfVPDs')){
	function countOfVPDs($fweekfrom,$fweekto){
		$CI = & get_instance();
		$query = "
					SELECT 
						districtname(distcode) as DistrictName, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Msl' AND distcode=districts.distcode and fweek NOT LIKE  '%-00') as measles, 
						(SELECT COUNT(*) FROM afp_case_investigation WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND distcode=districts.distcode) as AFP, 
						(SELECT COUNT(*) FROM nnt_investigation_form WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND distcode=districts.distcode) as NNT, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Diphtheria' AND distcode=districts.distcode) as diphtheria, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Pertussis' AND distcode=districts.distcode) as pertussis, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Childhood TB' AND distcode=districts.distcode) as ChildhoodTB, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Pneumonia' AND distcode=districts.distcode) as pneumonia, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Meningitis' AND distcode=districts.distcode) as meningitis, 
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND case_type = 'Hepatitis' AND distcode=districts.distcode) as hepatitis, 
						(
							(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND distcode=districts.distcode and fweek <> '2017-00')+ 
							(SELECT COUNT(*) FROM afp_case_investigation WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND distcode=districts.distcode)+ 
							(SELECT COUNT(*) FROM nnt_investigation_form WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND distcode=districts.distcode)+ 
							(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' AND (case_type = 'Diphtheria' OR case_type = 'Pertussis' OR case_type = 'Childhood TB' OR case_type = 'Pneumonia' OR case_type = 'Meningitis' OR case_type = 'Hepatitis') AND distcode=districts.distcode) 
						) as TotalVPDsCases 
					FROM 
						districts 
					ORDER BY district";
		$result = $CI -> db -> query($query) -> result_array();
		$html='';
		foreach($result as $key => $value){
			$html .= "
						<tr>
							<td>{$value['districtname']}</td>
							<td>{$value['measles']}</td>
							<td>{$value['afp']}</td>
							<td>{$value['nnt']}</td>
							<td>{$value['diphtheria']}</td>
							<td>{$value['pertussis']}</td>
							<td>{$value['childhoodtb']}</td>
							<td>{$value['pneumonia']}</td>
							<td>{$value['meningitis']}</td>
							<td>{$value['hepatitis']}</td>
							<td>{$value['totalvpdscases']}</td>						
						</tr>";
		}
		return $html;
	}
}
if(!function_exists('getWeekDate')){
	function getWeekDate($week,$year,$startend){
		$CI = & get_instance();
		$fweek = $year.'-'.sprintf('%02d',$week);
		//print_r($fweek);exit;
		switch($startend){
			case 'start':
				$CI -> db -> select('date_from as sdate');
				break;
			case 'end':
				$CI -> db -> select('date_to as sdate');
				break;
		}
		$CI -> db -> from('epi_weeks');
		$CI -> db -> where('fweek',$fweek);
		$result = $CI -> db -> get() -> row();
		return $result -> sdate;
	}
}

if(!function_exists('lastWeek')){
	function lastWeek($yearPassed=NULL,$isreturn=false){
		$CI = & get_instance();
		$yearPassed = ($yearPassed)?$yearPassed:date('Y');
		$current_date = date("Y-m-d",strtotime("-1 week"));
		$year = $yearPassed;
		$current_year = date("Y");
		if($year == $current_year){
			$query = "SELECT epi_week_numb as num from epi_weeks where date_from <= '$current_date' and date_to >= '$current_date' and year='$year'";
		}else{
			$query = "SELECT max(epi_week_numb) as num from epi_weeks where year='$year'";
		}
		$query = $CI -> db -> query($query);
		$result = $query -> row();
		$lastWeek = ($result->num);
		return sprintf("%02d",$lastWeek);
	}
}

?>