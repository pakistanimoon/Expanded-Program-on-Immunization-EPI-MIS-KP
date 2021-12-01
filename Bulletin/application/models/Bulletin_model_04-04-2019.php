<?php
class Bulletin_model extends CI_Model {
	public function ageWiseDistributionOfLabConfirmedCases($fweek){
		$query = "
					SELECT below9months*100/NULLIF(total,0) as below9monthsperc,months9to23*100/NULLIF(total,0) as months9to23perc,month24to59*100/NULLIF(total,0) as month24to59perc,months60to119*100/NULLIF(total,0) as months60to119perc,greaterthan120months*100/NULLIF(total,0) as greaterthan120monthsperc,dontknow*100/NULLIF(total,0) as dontknowperc 
					FROM 
					(
						SELECT COUNT(*) AS total,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months < 9) AS below9months,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 9 AND age_months <= 23) AS months9to23,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 24 AND age_months <= 59) AS month24to59,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 60 AND age_months <= 119) AS months60to119,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 120) AS greaterthan120months,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months IS NULL OR age_months < 0) AS dontknow
						FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}'
					) AS a
		";
		return $this -> db -> query($query) -> row();
	}
	public function ageWiseDistributionOfSuspectedAndLabResultCases($fweek){
		$query = "
					SELECT COUNT(*) AS total,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months < 9) AS below9monthssc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months < 9 and specimen_result='Positive Measles') AS below9monthspm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months < 9 and specimen_result='Positive Rubella') AS below9monthspr,
						  
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months >= 9 AND age_months <= 23) AS months9to23sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 9 AND age_months <= 23) AS months9to23pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek = '{$fweek}' and age_months >= 9 AND age_months <= 23) AS months9to23pr,

						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months >= 24 AND age_months <= 59) AS month24to59sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 24 AND age_months <= 59) AS month24to59pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek = '{$fweek}' and age_months >= 24 AND age_months <= 59) AS month24to59pr,

						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months >= 60 AND age_months <= 119) AS months60to119sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 60 AND age_months <= 119) AS months60to119pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek = '{$fweek}' and age_months >= 60 AND age_months <= 119) AS months60to119pr,

						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months >= 120) AS greaterthan120monthssc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months >= 120) AS greaterthan120monthspm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek = '{$fweek}' and age_months >= 120) AS greaterthan120monthspr,

						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek = '{$fweek}' and age_months IS NULL OR age_months < 0) AS dontknowsc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek = '{$fweek}' and age_months IS NULL OR age_months < 0) AS dontknowpm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek = '{$fweek}' and age_months IS NULL OR age_months < 0) AS dontknowpr
					FROM case_investigation_db 
					WHERE 
						specimen_result='Positive Measles' AND fweek = '{$fweek}'
		";
		return $this -> db -> query($query) -> row_array();
	}
	public function measlesCasesReceivedDoseWiseCount($fweek){
		$query = "
					SELECT 
						doses_received,COUNT(*) AS cnt 
					FROM 
						case_investigation_db 
					WHERE 
						fweek='{$fweek}' 
					GROUP BY 
						doses_received 
					ORDER BY 
						doses_received ASC
		";
		return $this -> db -> query($query) -> result_array();
	}
}
?>