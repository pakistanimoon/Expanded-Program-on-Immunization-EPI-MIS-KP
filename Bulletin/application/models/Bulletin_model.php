<?php
class Bulletin_model extends CI_Model {
	public function ageWiseDistributionOfLabConfirmedCases($fweekfrom,$fweekto){
		$query = "
					SELECT below9months*100/NULLIF(total,0) as below9monthsperc,months9to23*100/NULLIF(total,0) as months9to23perc,month24to59*100/NULLIF(total,0) as month24to59perc,months60to119*100/NULLIF(total,0) as months60to119perc,greaterthan120months*100/NULLIF(total,0) as greaterthan120monthsperc,dontknow*100/NULLIF(total,0) as dontknowperc 
					FROM 
					(
						SELECT COUNT(*) AS total,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months < 9) AS below9months,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 9 AND age_months <= 23) AS months9to23,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 24 AND age_months <= 59) AS month24to59,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 60 AND age_months <= 119) AS months60to119,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 120) AS greaterthan120months,
							(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months IS NULL OR age_months < 0) AS dontknow
						FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}'
					) AS a
		";
		return $this -> db -> query($query) -> row();
	}
	public function ageWiseDistributionOfSuspectedAndLabResultCases($fweekfrom,$fweekto){
		$query = "
					SELECT COUNT(*) AS total,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months < 9) AS below9monthssc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months < 9 and specimen_result='Positive Measles') AS below9monthspm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months < 9 and specimen_result='Positive Rubella') AS below9monthspr,						  
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 9 AND age_months <= 23) AS months9to23sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 9 AND age_months <= 23) AS months9to23pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 9 AND age_months <= 23) AS months9to23pr,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 24 AND age_months <= 59) AS month24to59sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 24 AND age_months <= 59) AS month24to59pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 24 AND age_months <= 59) AS month24to59pr,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 60 AND age_months <= 119) AS months60to119sc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 60 AND age_months <= 119) AS months60to119pm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 60 AND age_months <= 119) AS months60to119pr,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 120) AS greaterthan120monthssc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 120) AS greaterthan120monthspm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months >= 120) AS greaterthan120monthspr,
						(SELECT COUNT(*) FROM case_investigation_db WHERE fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months IS NULL OR age_months < 0) AS dontknowsc,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Measles' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months IS NULL OR age_months < 0) AS dontknowpm,
						(SELECT COUNT(*) FROM case_investigation_db WHERE specimen_result='Positive Rubella' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}' and age_months IS NULL OR age_months < 0) AS dontknowpr
					FROM case_investigation_db 
					WHERE 
						specimen_result='Positive Measles' AND  fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}'
		";
		return $this -> db -> query($query) -> row_array();
	}
	public function measlesCasesReceivedDoseWiseCount($fweekfrom,$fweekto){
		$query = "
					SELECT 
						doses_received,COUNT(*) AS cnt 
					FROM 
						case_investigation_db 
					WHERE 
						case_type = 'Msl' AND fweek >= '{$fweekfrom}' AND fweek <= '{$fweekto}'
					GROUP BY 
						doses_received 
					ORDER BY 
						doses_received ASC
		";
		return $this -> db -> query($query) -> result_array();
	}
	public function highlight($data){
		$year=$data['year'];
		$datefrom = $data['datefrom'];
		$dateto = $data['dateto'];
		/* $datefrom=explode("-",$datefrom);
		$dateto=explode("-",$dateto); */
		$from_week = sprintf("%02d", $data['from_week']);
		$to_week = sprintf("%02d", $data['to_week']);
		 ///////total of measle_cases suspected row1 //////////
		$measlesuspected="
							SELECT
									sum(measle_cases) as totalmeasle 
								FROM 
									zero_report 
								WHERE
								fweek BETWEEN '{$year}-{$from_week}' AND '{$year}-{$to_week}' 
						";
		$result['measlesuspected']=$this -> db -> query($measlesuspected) -> result_array();
		/////////for column query vdip count //////////
		$from_weekvpid = sprintf("%02d", $data['from_week']);
		$to_weekvpid = sprintf("%02d", $data['to_week']);
		$CI = & get_instance();
		///////for query dropoutpenta3measles1 and dropoutpenta3measles2 /////////
		$startMonth = date('m',strtotime(getWeekDate($from_week,$year,'start')));
		$endMonth = date('m',strtotime(getWeekDate($from_week,$year,'end')));
		if($startMonth > $endMonth && $startMonth == '12')
		{
			$startMonth='01';
		}else{
			$startMonth= $startMonth;
		}
		///////for query Timeliness///////////// 
		$startMonthn = date('n',strtotime(getWeekDate($from_week,$year,'start')));
		$endMonthn = date('n',strtotime(getWeekDate($from_week,$year,'end')));
		if($startMonthn > $endMonthn && $startMonthn == '12')
		{
			$startMonthn='1';
		}else{
			$startMonthn= $startMonthn;
		}
		$sub = $tsub = $due = "";
		for($startMonthn;$startMonthn<=$endMonthn;$startMonthn++){
			$sub .= "subm".$startMonthn."+";
			$tsub .= "tsubm".$startMonthn."+";
			$due .= "duem".$startMonthn."+";
		}
		$sub = rtrim($sub,'+');
		$tsub = rtrim($tsub,'+');
		$due = rtrim($due,'+');
		///////////for query vdp analysis////////////////////
		$subw = $tsubw = $duew = "";
		for($from_week;$from_week<=$to_week;$from_week++){
			$subw .= "subwk".sprintf('%02d',$from_week)."+";
			$tsubw .= "tsubwk".sprintf('%02d',$from_week)."+";
			$duew .= "duewk".sprintf('%02d',$from_week)."+";
		}
		$subw = rtrim($subw,'+');
		$tsubw = rtrim($tsubw,'+');
		$duew = rtrim($duew,'+');
		///////////for query vdip count////////////////////
		 $mvpid = $fvpid = "";
		for($to_weekvpid;$from_weekvpid<=$to_week;$from_weekvpid++){
			$mvpid .= "mwk".sprintf('%02d',$from_week)."+";
			$fvpid .= "fwk".sprintf('%02d',$from_week)."+";
			//$duevpid .= "duewk".sprintf('%02d',$from_week)."+";
		}
		$mvpid = rtrim($mvpid,'+');
	 $fvpid = rtrim($fvpid,'+');
		//////for  Diphtheria cases row2 //////////
		  $diphtheria="
							SELECT 
								distcode,districtname(distcode) as district,
								SUM({$mvpid}) as maled,
								SUM({$fvpid}) as femaled,
								
								(SUM({$mvpid}) + SUM({$fvpid})) as total
								
							FROM 
								epidcount_db 
							WHERE	case_type='Diph' and year='$year'
							GROUP BY distcode ORDER BY distcode
						";
				$diphtheriapro="
			SELECT distcode,districtname(distcode) as district, sum(total) from (
								SELECT 
									distcode,districtname(distcode) as district,
									SUM({$mvpid}) as maled,
									SUM({$fvpid}) as femaled,
									
									(SUM({$mvpid}) + SUM({$fvpid})) as total
									
								FROM 
									epidcount_db 
								WHERE	case_type='Diph' and year='$year'
								GROUP BY distcode ORDER BY distcode) as a group by distcode
						";
		$result['diphtheriapro']=$this -> db -> query($diphtheriapro) -> result_array();
		$result['diphtheria']=$this -> db -> query($diphtheria) -> result_array();
		///////total of measle_cases suspected row3 //////////
		 $vpdanalysis = "
					SELECT 
						distcode,districtname(distcode) as district,
						SUM({$subw}) as submited,
						SUM({$duew}) as due, 
						(SUM({$subw})*100/NULLIF(SUM({$duew}),0)) as percentage
					FROM 
						zeroreportcompliance 
					WHERE  year='$year'
					GROUP BY distcode ORDER BY distcode
				
				";
		$result['vpdanalysis']=$this -> db -> query($vpdanalysis) -> result_array();
		/////// Timeliness >10 row4 //////////
		$timeliness = "
					SELECT 
						distcode,districtname(distcode) as district,
						SUM({$tsub})*100/NULLIF(SUM({$due}),0) as timeliness 
					FROM 
						vaccinationcompliance 
					WHERE  year='$year'	
					GROUP BY distcode ORDER BY distcode
				";
		//	print_r($timeliness);exit;
		$result['timeliness']=$this -> db -> query($timeliness) -> result_array();
		/////// dropoutpenta3measles1 nagitve row6 //////////
		$dropout = "
					SELECT 
						distcode,districtname(distcode) as district,
						ROUND((sumvaccinevacination(7,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(7,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta1to3,
						ROUND((sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta3tomeasle1,
						ROUND((sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(18,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta3tomeasle2,
						ROUND((sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(18,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as measle1to2
					FROM 
						districts 
					WHERE distcode NOT IN ('1','2','9') 
					ORDER BY distcode;
				";
		$result['dropout']=$this -> db -> query($dropout) -> result_array();
		/////// highdropout >10 row7 //////////
		$highdropout = "
					SELECT 
						distcode,districtname(distcode) as district,
						ROUND((sumvaccinevacination(7,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(7,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta1to3,
						ROUND((sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta3tomeasle1,
						ROUND((sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(18,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(9,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as penta3tomeasle2,
						ROUND((sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}')-sumvaccinevacination(18,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'))*100/NULLIF(sumvaccinevacination(16,distcode,'{$year}-{$startMonth}','{$year}-{$endMonth}'),0)) as measle1to2
					FROM 
						districts 
					WHERE distcode NOT IN ('1','2','9') 
					ORDER BY distcode;
				";
		$result['highdropout']=$this -> db -> query($highdropout) -> result_array();
		///////end  highdropout >10  row7 //////////
		return $result;
	}
}
?>