<?php
	ob_start();
	session_start();
	date_default_timezone_set('Asia/Karachi');
	$indicator=isset($_REQUEST['ind'])?$_REQUEST['ind']:"";
	$fmonth=isset($_REQUEST['fmonth'])?$_REQUEST['fmonth']:"";

	$year=substr($fmonth,0,4);
	$month=substr($fmonth,4,3);
	
	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions;
	if ($indicator==2710550606){
		$query="select distcode,districtname(distcode),sum(fac_mvrf_db.cri_r25_f17+fac_mvrf_db.cri_r26_f17) as tic ,round(getmonthlytarget_specificyearr(distcode::text,".$year.",".$month.",".$year.",".$month.")::numeric,0) as target, round(coalesce(((sum(coalesce(cri_r25_f17))+sum(coalesce(cri_r26_f17)))::numeric//(getmonthlytarget_specificyearr(distcode::text,".$year.",".$month.",".$year.",".$month.")::numeric)::numeric)*100,0)::numeric,2) as fic from fac_mvrf_db where fmonth BETWEEN '".$fmonth."' AND '".$fmonth."' group by distcode order by districtname(distcode)";
		$result=$dbf->queryDB("psql",$query,"% of Children 12-23 months Fully immunized");
		while($row=$dbf->returnDBarray("psql",$result)){
			$numerator=$row["tic"];
			$denominator=$row["target"];
			$indicatorvalue=$row["fic"];
			$series1[]=array("distcode"=>$row["distcode"], "indicatorvalue"=>$indicatorvalue, "numerator"=>$numerator, "denominator"=>$denominator);
		}
	} else if ($indicator==2710550295){
		$query="select distcode, districtname(distcode),sum(fac_mvrf_db.ttri_r9_f2+fac_mvrf_db.cri_r10_f2) as tiw, round(getmonthly_plwomen_target_specificyears(distcode::text,".$year.",".$month.",".$year.",".$month.")::numeric,0) as target, round(coalesce(((sum(coalesce(ttri_r9_f2))+sum(coalesce(cri_r10_f2)))::numeric//(getmonthly_plwomen_target_specificyears(distcode::text,".$year.",".$month.",".$year.",".$month.")::numeric)::numeric)*100,0)::numeric,2) as ttc from fac_mvrf_db where fmonth BETWEEN '".$fmonth."' AND '".$fmonth."' group by distcode order by districtname(distcode)";
		$result=$dbf->queryDB("psql",$query,"TT2 Coverage");
		while($row=$dbf->returnDBarray("psql",$result)){
			$numerator=$row["tiw"];
			$denominator=$row["target"];
			$indicatorvalue=$row["ttc"];
			$series1[]=array("distcode"=>$row["distcode"], "indicatorvalue"=>$indicatorvalue, "numerator"=>$numerator, "denominator"=>$denominator);
		}
	} else if ($indicator==2690520186){
		$query="select distcode, district, tot_due,tot_sub, round((tot_sub::float//tot_due)::numeric*100,0) as compliance from (select distcode , district, (select count(fac.facode) from facilities fac where fac.distcode = districts.distcode and fac.hf_type='e' ) AS tot_due, (select count(fac_mvrf_db.facode) from fac_mvrf_db join facilities fac on fac.facode = fac_mvrf_db.facode where fac_mvrf_db.fmonth = '".$fmonth."' and fac_mvrf_db.distcode = districts.distcode ) AS tot_sub from districts Order by distcode) as a";
		$result=$dbf->queryDB("psql",$query,"EPI MIS Compliance");
		while($row=$dbf->returnDBarray("psql",$result)){
			$numerator=$row["tot_due"];
			$denominator=$row["tot_sub"];
			$indicatorvalue=$row["compliance"];
			$series1[]=array("distcode"=>$row["distcode"], "indicatorvalue"=>$indicatorvalue, "numerator"=>$numerator, "denominator"=>$denominator);
		}
	}

	echo json_encode($series1);
?>