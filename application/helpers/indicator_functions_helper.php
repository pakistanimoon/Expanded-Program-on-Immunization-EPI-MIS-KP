<?php
if(!function_exists('extract_query')){
	function extract_query($arrayData,$whereFmonth,$data,$wherecondition,$arrayDataC=NULL,$table){
		$CI 			= & get_instance();
		$indmain        = $arrayData["indmain"];
		$ind_name       = $arrayData["ind_name"];
		$numOne	        = $arrayData["numenator"];
		$denTwo	        = $arrayData["denominator"];
		$module_id      = $arrayData["module_id"];
		$result_text    = $arrayData["result_text"];
		$multiplier    = $arrayData["mt"];
		$str = "";
		$totalquery="";
		/* Calculate that how much months have been selected to generate a report */
		$y1 = date('Y', strtotime($data['monthfrom']));
		$y2 = date('Y', strtotime($data['monthto']));
		$m1 = date('m', strtotime($data['monthfrom']));
		$m2 = date('m', strtotime($data['monthto']));
		$noOfMonthsSelected = (($y2 - $y1) * 12) + ($m2 - $m1) + 1;
		/* Check if a string is involved in numenator or denominator to be replace with a formula */
		$numerator = check_replacements($numOne,$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
		$denominator = check_replacements($denTwo,$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
		/* Make query for columns to be shown in indicator table */
		if( ! ($indmain == '63'))
		{
			foreach($arrayDataC as $key => $val)
			{
				$replaced_formula = check_replacements($val['formula_column'],$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
				if($replaced_formula == $val['formula_column'])
				{
					$formula_column = explode("+",$val['formula_column']);
					$str.= "sum(";
					$formula_size = sizeof($formula_column);
					for($i=0;$i<$formula_size;$i++)
					{
						$str .= $val['table_name'].".".$formula_column[$i]."+";
					}
					$str = rtrim($str,"+");
					$str.= ") as \"".$val['column_name']."\" ,";
					$col_name = $val['column_name'];
					//condition checks if selected value is not dropout
					$condition = ($col_name == 'Measle-1' OR $col_name == 'Measle-2' OR $col_name == 'Penta1' OR $col_name == 'Penta3' OR $col_name == 'TT1' OR $col_name == 'TT2') ? FALSE : TRUE ;
					if($formula_size == 1 AND $condition)
					{
						$last_index = end($arrayDataC);
						$replaced_formula = check_replacements($last_index['formula_column'],$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
						if($key == 0)
						{
							$gender = "Male";
							$gender_multiplier = 51;
						}
						elseif($key == 1)
						{
							$gender = "Female";
							$gender_multiplier = 49;
						}
						$ind_name = rtrim($ind_name);
						$coverge_name = "Total ".$col_name;
						$target_name = "Target ".$col_name;
						if(substr($ind_name, 0,2) != "TT")
						{
							$coverge_name = "$ind_name ($gender)";
							$target_name = "Target ($gender)";
						}
						$str .= "round($replaced_formula * $gender_multiplier / 100, 0) AS \"$target_name\",";
						$qformula=($denominator==""?$numerator:"(( sum($formula_column[0]) )::numeric//($denominator)::numeric * $gender_multiplier / 100)");
						if($multiplier!="")
							$qformula.="*".$multiplier;
						$str .= "round(coalesce($qformula,0)::numeric) as \"$coverge_name%\",";
					}
				}
				else
				{
					$str .= "round(".$replaced_formula.",0) as \"Target\", ";
				}
			}
			$str = (sizeof($arrayDataC)>1)?$str:"";
			$qformula=($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)");
			if($multiplier!="")
				$qformula.="*".$multiplier;
			//getpopulationpop for total pop add in query by usama 											  
			switch($data['reportPeriodnew'])
			{
				case 'district':
					$firstquery="select distcode,districtname(distcode)as district,getpopulationpop(distcode,'district','$y1') as \"total Population\",getperiodicpopulation(distcode,'district',$y1,$m1,$y2,$m2) as \"preiodic Population\", $str round(coalesce($qformula,0)::numeric) as \"$result_text\" from $table where $wherecondition $whereFmonth group by distcode order by districtname(distcode)";
					break;
				case 'tehsil':
					$firstquery="select districtname(distcode) as district,tehsilname(tcode)as tehsil,getpopulationpop(tcode,'tehsil','$y1') as \"total Population\",getperiodicpopulation(tcode,'tehsil',$y1,$m1,$y2,$m2) as \"preiodic Population\",$str round(coalesce($qformula,0)::numeric) as \"$result_text\" from $table where $wherecondition $whereFmonth group by distcode,tcode order by distcode,tehsilname(tcode)";
					break;
				case 'uc':
					$firstquery="select districtname(distcode) as district,tehsilname(tcode) as tehsil,unname(uncode) as \"UC\",getpopulationpop(uncode,'unioncouncil','$y1') as \"total Population\",getperiodicpopulation(uncode,'unioncouncil',$y1,$m1,$y2,$m2) as \"preiodic Population\", $str round(coalesce($qformula,0)::numeric) as \"$result_text\" from $table where $wherecondition $whereFmonth group by distcode,tcode,uncode order by distcode,tehsilname(tcode),unname(uncode)";
					break;
				case 'fac':
					$firstquery="select districtname(distcode) as district,tehsilname(tcode) as tehsil,unname(uncode) as \"UC\",facilityname(facode) as \"EPI Center\",getpopulationpop(facode,'facility','$y1') as \"total Population\",getperiodicpopulation(facode,'facility',$y1,$m1,$y2,$m2) as \"preiodic Population\",$str round(coalesce($qformula,0)::numeric) as \"$result_text\" from $table where $wherecondition $whereFmonth group by distcode,tcode,uncode,facode order by distcode,tehsilname(tcode),unname(uncode),facilityname(facode)";
					break;
			}
		}
		else
		{
			$q = "SELECT result_text FROM indicator_main WHERE (result_text LIKE '%Coverage' OR result_text LIKE 'Fully Immunized' OR result_text LIKE '%Dropout') AND indmain <> '63' ORDER BY indmain ASC";
			$result_array = $CI->db->query($q)->result_array();
			$tot_str = "";
			foreach($arrayDataC as $key => $val)
			{
				$indcol = $val['indcol'];
				$result_text = $result_array[$key]['result_text'];
				$numerator = check_replacements($val['formula_column'],$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
				$denominator = check_replacements($val['column_name'],$y1,$m1,$y2,$m2,$data['reportPeriodnew']);
				$qformula = ($denominator==""?$numerator:"(($numerator)::numeric//($denominator)::numeric)");
				if($multiplier!="")
					$qformula .="*".$multiplier;
				$str .= $val['formula_column']." AS \"Total Vaccination{$indcol}\", round($denominator,0) AS Target{$indcol}, round(coalesce($qformula,0)::numeric) as \"$result_text\",";
				$tot_str .= "round( sum(\"Total Vaccination{$indcol}\") / sum(Target{$indcol}) *100) as \"$result_text\",";
			}
			$str = rtrim($str, ',');
			$tot_str = rtrim($tot_str, ',');
			switch($data['reportPeriodnew'])
			{
				case 'district':
					$firstquery="select distcode,districtname(distcode),getperiodicpopulation(distcode,'district',$y1,$m1,$y2,$m2) as population, $str from $table where $wherecondition $whereFmonth group by distcode order by districtname(distcode)";
					$totalquery="select $tot_str from ({$firstquery}) as b";
					break;
				case 'tehsil':
					$firstquery="select tcode,tehsilname(tcode),getperiodicpopulation(tcode,'tehsil',$y1,$m1,$y2,$m2) as population, $str from $table where $wherecondition $whereFmonth group by tcode order by tehsilname(tcode)";
					$totalquery="select $tot_str from ({$firstquery}) as b";
					break;
				case 'uc':
					$firstquery="select uncode,unname(uncode),getperiodicpopulation(uncode,'unioncouncil',$y1,$m1,$y2,$m2) as population, $str from $table where $wherecondition $whereFmonth group by uncode order by unname(uncode)";
					$totalquery="select $tot_str from ({$firstquery}) as b";
					break;
				case 'fac':
					$firstquery="select facode,facilityname(facode),getperiodicpopulation(facode,'facility',$y1,$m1,$y2,$m2) as population, $str from $table where $wherecondition $whereFmonth group by facode order by facilityname(facode)";
					$totalquery="select $tot_str from ({$firstquery}) as b";
					break;
			}
		}
		if($totalquery!=""){
			return $firstquery.'-::-'.$totalquery;
		
		}
		else{
			return $firstquery;		
		}
	}
}
if(!function_exists('check_replacements')){
	function check_replacements($str,$y1,$m1,$y2,$m2,$typeWise){
		switch($typeWise)
		{
			case 'district':
				$code='distcode';
				$type='district';
				break;
			case 'tehsil':
				$code='tcode';
				$type='tehsil';
				break;
			case 'uc':
				$code='uncode';
				$type='unioncouncil';
				break;			
			case 'fac':
				$code='facode';
				$type='facility';
				break;			
		}
		$arrayToCheckForReplacedString = array(
			'opv0' => "getmonthlytarget_specificyearr($code::text,$y1,$m1,$y2,$m2)::numeric",
			'bcg'  => "getmonthlytarget_specificyearr($code::text,$y1,$m1,$y2,$m2)::numeric",
			'hepb' => "getmonthlytarget_specificyearr($code::text,$y1,$m1,$y2,$m2)::numeric",
			'ipv'  => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'opv1' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'opv2' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'opv3' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'penta1' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'penta2' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'penta3' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'pcv10-1' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'pcv10-2' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'pcv10-3' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'rota-1' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'rota-2' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'measle-1' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'measle-2' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric",
			'tt1' => "getmonthly_plwomen_target_specificyears($code::text,$y1,$m1,$y2,$m2)::numeric",
			'tt2' => "getmonthly_plwomen_target_specificyears($code::text,$y1,$m1,$y2,$m2)::numeric",
			'tt3' => "getmonthly_plwomen_target_specificyears($code::text,$y1,$m1,$y2,$m2)::numeric",
			'tt4' => "getmonthly_plwomen_target_specificyears($code::text,$y1,$m1,$y2,$m2)::numeric",
			'tt5' => "getmonthly_plwomen_target_specificyears($code::text,$y1,$m1,$y2,$m2)::numeric",
			'tt6' => "getmonthlytarget_specificyearr($code::text,$y1,$m1,$y2,$m2)::numeric",
			'live-birth' => '',
			'fullyImmunized' => "getmonthlytarget_specificyearrsurvivinginfants($code::text,'$type',$y1,$m1,$y2,$m2)::numeric"
		);
		$stringToReplace = "";$stringToReplaceWith = "";
		foreach($arrayToCheckForReplacedString as $key => $val){
			if (strpos($str, $key) !== false) {
				$stringToReplace = $key;
				$stringToReplaceWith = $val;
				break;
			}
		}
		$finalStr=str_replace($stringToReplace,$stringToReplaceWith,$str);
		return $finalStr;
	}
}
?>