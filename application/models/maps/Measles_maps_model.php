<?php
class Measles_maps_model extends CI_Model {	
		
	function measlesSummary($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		$this -> db -> select("
			sum(case when case_epi_no IS NOT NULL then 1 else 0 end) as suspected,
			sum(case when case_epi_no IS NULL then 1 else 0 end) as crossnotified,
			sum(case when specimen_result = 'Positive Measles' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_measles, 
			sum(case when specimen_result = 'Positive Rubella' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_rubella, 
			sum(case when (specimen_result = 'Negative Measles' OR specimen_result = 'Negative Rubella') AND case_epi_no IS NOT NULL then 1 else 0 end) as negative, 
			sum(case when patient_gender = '1' AND case_epi_no IS NOT NULL then 1 else 0 end) as male, 
			sum(case when patient_gender = '0' AND case_epi_no IS NOT NULL then 1 else 0 end) as female, 
			sum(case when (specimen_result <> 'Positive Measles' AND specimen_result <> 'Positive Rubella' AND specimen_result <> 'Negative Measles' AND specimen_result <> 'Negative Rubella' OR specimen_result IS NULL) AND case_epi_no IS NOT NULL then 1 else 0 end) as resultawaited,
			sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as activecases,
			sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) as recovered, 
			sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as deaths ");
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where ('procode',$procode);
		if($distcode)
			$this -> db -> where('distcode', $distcode);
		$this -> db -> where('year', $year);
		$this -> db -> get('case_investigation_db') -> row();
		$innerQuery = $this -> db -> last_query();
		$this -> db -> select("*, coalesce((male//suspected)*100,0) perc_male, coalesce((female//suspected)*100,0) perc_female, coalesce((confirmed_measles//suspected)*100,0) perc_confirmed_measles, coalesce((confirmed_rubella//suspected)*100,0) perc_confirmed_rubella, coalesce((negative//suspected)*100,0) perc_negative, coalesce((resultawaited//suspected)*100,0) perc_resultawaited, coalesce((activecases//suspected)*100,0) perc_activecases, coalesce((recovered//suspected)*100,0) perc_recovered, coalesce((deaths//suspected)*100,0) perc_deaths");
		$this -> db -> from("($innerQuery) as a");
		$this -> db -> order_by('suspected','asc');
		return $this -> db -> get() -> row();
	}
	
	function districtWiseMeaslesSummary($distcode=NULL, $year=NULL){
		$procode = $this -> session -> Province;
		if($distcode){
			$this -> db -> select("
				uncode,unname(uncode) as district,
				sum(case when case_epi_no IS NOT NULL then 1 else 0 end) as suspected,
				sum(case when case_epi_no IS NULL then 1 else 0 end) as crossnotified,
				sum(case when specimen_result = 'Positive Measles' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_measles, 
				sum(case when specimen_result = 'Positive Rubella' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_rubella, 
				sum(case when (specimen_result = 'Negative Measles' OR specimen_result = 'Negative Rubella') AND case_epi_no IS NOT NULL then 1 else 0 end) as negative, 
				sum(case when patient_gender = '1' AND case_epi_no IS NOT NULL then 1 else 0 end) as male, 
				sum(case when patient_gender = '0' AND case_epi_no IS NOT NULL then 1 else 0 end) as female, 
				sum(case when (specimen_result <> 'Positive Measles' AND specimen_result <> 'Positive Rubella' AND specimen_result <> 'Negative Measles' AND specimen_result <> 'Negative Rubella' OR specimen_result IS NULL) AND case_epi_no IS NOT NULL then 1 else 0 end) as resultawaited, 
				sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as activecases,
				sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) as recovered, 
				sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as deaths ");
		}else{
			$this -> db -> select("
				distcode,districtname(distcode) as district,
				sum(case when case_epi_no IS NOT NULL then 1 else 0 end) as suspected,
				sum(case when case_epi_no IS NULL then 1 else 0 end) as crossnotified,
				sum(case when specimen_result = 'Positive Measles' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_measles, 
				sum(case when specimen_result = 'Positive Rubella' AND case_epi_no IS NOT NULL then 1 else 0 end) as confirmed_rubella, 
				sum(case when (specimen_result = 'Negative Measles' OR specimen_result = 'Negative Rubella') AND case_epi_no IS NOT NULL then 1 else 0 end) as negative, 
				sum(case when patient_gender = '1' AND case_epi_no IS NOT NULL then 1 else 0 end) as male, 
				sum(case when patient_gender = '0' AND case_epi_no IS NOT NULL then 1 else 0 end) as female, 
				sum(case when (specimen_result <> 'Positive Measles' AND specimen_result <> 'Positive Rubella' AND specimen_result <> 'Negative Measles' AND specimen_result <> 'Negative Rubella' OR specimen_result IS NULL) AND case_epi_no IS NOT NULL then 1 else 0 end) as resultawaited,
				sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' OR final_classification != 'Discarded Case') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as activecases,
				sum(case when (specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella') AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) as recovered, 
				sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as deaths ");
		}
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where ('procode',$procode);
		if($distcode){
			$this -> db -> where('distcode',$distcode);
			$this -> db -> group_by('uncode');
		}else{
			$this -> db -> group_by('distcode');
		}
		$this -> db -> where('year', $year);
		//$this -> db -> order_by('suspected','desc');
		$this -> db -> get('case_investigation_db') -> row();
		$innerQuery = $this -> db -> last_query();
		if($distcode){
			$this -> db -> select("unname(uc.uncode) as districtname, uc.uncode as districtcode, a.*, coalesce((male//suspected)*100,0) perc_male, coalesce((female//suspected)*100,0) perc_female, coalesce((confirmed_measles//suspected)*100,0) perc_confirmed_measles, coalesce((confirmed_rubella//suspected)*100,0) perc_confirmed_rubella, coalesce((negative//suspected)*100,0) perc_negative, coalesce((resultawaited//suspected)*100,0) perc_resultawaited, coalesce((activecases//suspected)*100,0) perc_activecases, coalesce((recovered//suspected)*100,0) perc_recovered, coalesce((deaths//suspected)*100,0) perc_deaths");
			$this -> db -> from("($innerQuery) as a");
			$this -> db -> join('unioncouncil uc','uc.uncode=a.uncode','right');
		}else{
			$this -> db -> select("dist.district as districtname, dist.distcode as districtcode, a.*, coalesce((male//suspected)*100,0) perc_male, coalesce((female//suspected)*100,0) perc_female, coalesce((confirmed_measles//suspected)*100,0) perc_confirmed_measles, coalesce((confirmed_rubella//suspected)*100,0) perc_confirmed_rubella, coalesce((negative//suspected)*100,0) perc_negative, coalesce((resultawaited//suspected)*100,0) perc_resultawaited, coalesce((activecases//suspected)*100,0) perc_activecases, coalesce((recovered//suspected)*100,0) perc_recovered, coalesce((deaths//suspected)*100,0) perc_deaths");
			$this -> db -> from("($innerQuery) as a");
			$this -> db -> join('districts dist','dist.distcode=a.distcode','right');
		}
		if($distcode){
			$this -> db -> where('uc.distcode',$distcode);
			$this -> db -> order_by('uc.un_name','asc');
		}else{
			$this -> db -> order_by('dist.district','asc');
		}
		return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklySuspectedCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		$this -> db -> select("fweek, count(*) as cnt");
		$this -> db -> from('case_investigation_db');
		$this -> db -> where(array('procode' => $procode));
		$this -> db -> where('case_epi_no IS NOT NULL');
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where('year', $year);
		if($distcode)
			$this -> db -> where('distcode',$distcode);
		$this -> db -> group_by('fweek');
		$this -> db -> order_by('fweek','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklyConfirmedCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		if($distcode)
			$distcodeVar = "and distcode= '$distcode' ";
		else
			$distcodeVar = '';
		$query = "SELECT fweek, count(*) as cnt from case_investigation_db where procode='$procode' and (specimen_result='Positive Measles' OR specimen_result='Positive Rubella') and case_epi_no IS NOT NULL and case_type='Msl' and year='$year' $distcodeVar group by fweek order by fweek asc";
		$result = $this -> db -> query($query);
		return $result -> result_array();
		// $this -> db -> select("fweek, count(*) as cnt");
		// $this -> db -> from('case_investigation_db');
		// $this -> db -> where(array('procode' => $procode,'specimen_result' => 'Positive Measles','year' => $year));
		// $this -> db -> or_where('specimen_result', 'Positive Measles');
		// $this -> db -> or_where('specimen_result', 'Positive Rubella');
		// //$this -> db -> or_where('final_classification !=', 'Discarded Case');
		// $this -> db -> where('case_epi_no IS NOT NULL');
		// $this -> db -> where('case_type', 'Msl');
		// //$this -> db -> where('year', $year);
		// if($distcode)
		// 	$this -> db -> where('distcode',$distcode);
		// $this -> db -> group_by('fweek');
		// $this -> db -> order_by('fweek','asc');
		//echo $this -> db -> last_query();exit();
		//return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklyDeathsCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		$this -> db -> select("fweek, count(*) as cnt");
		$this -> db -> from('case_investigation_db');
		$this -> db -> where(array('procode' => $procode, 'outcome' => 'Death'));
		$this -> db -> where('case_epi_no IS NOT NULL');
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where('year', $year);
		if($distcode)
			$this -> db -> where('distcode',$distcode);
		$this -> db -> group_by('fweek');
		$this -> db -> order_by('fweek','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklyRecoveredCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		if($distcode)
			$distcodeVar = "and distcode= '$distcode' ";
		else
			$distcodeVar = '';
		$query = "SELECT fweek, count(*) as cnt from case_investigation_db where procode='$procode' and outcome='Cured' and (specimen_result='Positive Measles' OR specimen_result='Positive Rubella') and case_epi_no IS NOT NULL and case_type='Msl' and year='$year' $distcodeVar group by fweek order by fweek asc";
		$result = $this -> db -> query($query);
		return $result -> result_array();

		// $this -> db -> select("fweek, count(*) as cnt");
		// $this -> db -> from('case_investigation_db');
		// $this -> db -> where(array('procode' => $procode, 'outcome' => 'Cured', 'specimen_result' => 'Positive Measles', 'year' => $year));
		// $this -> db -> or_where('specimen_result', 'Positive Rubella');
		// //$this -> db -> or_where('final_classification !=', 'Discarded Case');
		// $this -> db -> where('case_epi_no IS NOT NULL');
		// $this -> db -> where('case_type', 'Msl');
		// //$this -> db -> where('year', $year);
		// if($distcode)
		// 	$this -> db -> where('distcode',$distcode);
		// $this -> db -> group_by('fweek');
		// $this -> db -> order_by('fweek','asc');
		// return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklyMaleCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		$this -> db -> select("fweek, count(*) as cnt");
		$this -> db -> from('case_investigation_db');
		$this -> db -> where(array('procode' => $procode, 'patient_gender' => '1'));
		$this -> db -> where('case_epi_no IS NOT NULL');
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where('year', $year);
		if($distcode)
			$this -> db -> where('distcode',$distcode);
		$this -> db -> group_by('fweek');
		$this -> db -> order_by('fweek','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getMeaslesWeeklyFemaleCasesDetail($distcode=NULL, $year=NULL)
	{
		$procode = $this -> session -> Province;
		$this -> db -> select("fweek, count(*) as cnt");
		$this -> db -> from('case_investigation_db');
		$this -> db -> where(array('procode' => $procode, 'patient_gender' => '0'));
		$this -> db -> where('case_epi_no IS NOT NULL');
		$this -> db -> where('case_type', 'Msl');
		$this -> db -> where('year', $year);
		if($distcode)
			$this -> db -> where('distcode',$distcode);
		$this -> db -> group_by('fweek');
		$this -> db -> order_by('fweek','asc');
		return $this -> db -> get() -> result_array();
	}
	
	function getActiveCasesSeriesData($distcode=NULL, $year=NULL){
		$procode = $this -> session -> Province;
		if($distcode){
			$this -> db -> select("
				d2.uncode as code,unname(d2.uncode) as name, d2.path,
				sum(case when specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as value");
		}else{
			$this -> db -> select("
				d2.distcode as code,districtname(d2.distcode) as name, d2.path,
				sum(case when specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when specimen_result = 'Positive Measles' OR specimen_result = 'Positive Rubella' AND outcome = 'Cured' AND case_epi_no IS NOT NULL then 1 else 0 end) - sum(case when outcome = 'Death' AND case_epi_no IS NOT NULL then 1 else 0 end) as value");
		}
		$this -> db -> from('case_investigation_db measles');
		if($distcode)
			$this -> db -> join('uc_wise_maps_paths d2','measles.uncode=d2.uncode','right');
		else
			$this -> db -> join('districts_wise_maps_paths d2','measles.distcode=d2.distcode','right');
		$this -> db -> where ('d2.procode',$procode);
		$this -> db -> where('measles.case_type', 'Msl');
		$this -> db -> where('measles.year', $year);
		if($distcode){
			$this -> db -> where('d2.distcode',$distcode);
			$this -> db -> group_by('d2.uncode,d2.path');
		}else{
			$this -> db -> group_by('d2.distcode,d2.path');
		}		
		return $this -> db -> get() -> result();
	}

	function getSuspectedCasesSeriesData($distcode=NULL, $year=NULL){
		$procode = $this -> session -> Province;
		if($distcode){
			$this -> db -> select("
				d2.uncode as code,unname(d2.uncode) as name, d2.path,
				sum(case when case_epi_no IS NOT NULL then 1 else 0 end) as value");
		}else{
			$this -> db -> select("
				d2.distcode as code,districtname(d2.distcode) as name, d2.path,
				sum(case when case_epi_no IS NOT NULL then 1 else 0 end) as value");
		}

		$this -> db -> from('case_investigation_db measles');
		if($distcode)
			$this -> db -> join('uc_wise_maps_paths d2','measles.uncode=d2.uncode and measles.case_type=\'Msl\' and measles.year=\''.$year.'\' ','right');
		else
			$this -> db -> join('districts_wise_maps_paths d2','measles.distcode=d2.distcode and measles.case_type=\'Msl\' and measles.year=\''.$year.'\' ','right');
		$this -> db -> where(' d2.procode', $procode);		
		if($distcode){
			$this -> db -> where('d2.distcode',$distcode);
			$this -> db -> group_by('d2.uncode,d2.path');
		}else{
			$this -> db -> group_by('d2.distcode,d2.path');
		}
		return $this -> db -> get() -> result();
	}
}
?>