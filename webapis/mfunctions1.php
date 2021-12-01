<?php

function authenticationbyimei($dbf, $ucode, $imei){
	$query = "SELECT uncode, imei_no from sia_app_users where uncode='".$ucode."' and active='1' and password not like '!%'";
	$result = $dbf->queryDB("psql",$query,"authentication");
	$row=$dbf->returnDBarray("psql", $result);
	$imei1 = $row['imei_no'];
	if($imei == $imei1){
		return true;
	}else{
		return false;

	}	
}

function authentication($dbf, $username, $pass){
	$result = $dbf->queryDB("psql","SELECT uncode, password from sia_app_users where username='".$username."' and active='1' and level='6'  and password not like '!%'","authentication");
	$row=$dbf->returnDBarray("psql", $result);
	$pass1 = $row["password"];
	if(md5($pass) == $pass1){
		return true;
	}else{
		return false;
	}	
}

function getutype($dbf, $username){
	$result = $dbf->queryDB("psql","SELECT utype from sia_app_users where username='".$username."'","authentication");
	$row=$dbf->returnDBarray("psql", $result);
	return $row["utype"];	
}

function getlevel($dbf, $username){
	$result = $dbf->queryDB("psql","SELECT level from sia_app_users where username='".$username."'","authentication");
	$row=$dbf->returnDBarray("psql", $result);
	return $row["level"];	
}

function loginresponsejson($dbf, $username){
		$query = "SELECT procode, provincename(procode) as province, distcode, districtname(distcode) as district, tcode, tehsilname(tcode) as tehsil, uncode, unname(uncode) as ucname from sia_app_users where username='".$username."'";
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		$row=$dbf->returnDBarray("psql",$result);

		$compaigndata = getcompaign($dbf);
		$teamconf = getteamconfiguration($dbf, $row["uncode"], $compaigndata["compaignid"]);

		$series=array("success"=>"yes", "uncode"=>$row["uncode"], "ucname"=>$row["ucname"], "procode"=>$row["procode"], "province"=>$row["province"], "distcode"=>$row["distcode"], "district"=>$row["district"], "tcode"=>$row["tcode"], "tehsil"=>$row["tehsil"], "compaignid"=>$compaigndata["compaignid"], "noofdays"=>$compaigndata["noofdays"], "compaign_startdate"=>$compaigndata["startdate"], "compaign_enddate"=>$compaigndata["enddate"], "no_ucmo"=>$teamconf["no_ucmo"], "ucmo_data"=>$teamconf["ucmo_data"]);
		
		return $series;
} 

function recatchresponsejson($dbf, $compaignid, $uncode){
		$query = "SELECT compaignid, uncode, ucmo_code, activitydate, vaccinated_less5, vaccinated_gt5, totalvialused, aefi_vac_reaction, aefi_prg_error, aefi_coincidental, aefi_inj_reaction, aefi_unknown from sia_recatch where uncode='".$uncode."' and compaignid=".$compaignid;
		
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		
		while($row=$dbf->returnDBarray("psql",$result)){

			$recatchdata[]=array("ucmo_code"=>$row["ucmo_code"], "activitydate"=>$row["activitydate"], "vaccinated_less5"=>$row["vaccinated_less5"], "vaccinated_gt5"=>$row["vaccinated_gt5"], "totalvialused"=>$row["totalvialused"], "aefi_vac_reaction"=>$row["aefi_vac_reaction"], "aefi_prg_error"=>$row["aefi_prg_error"], "aefi_coincidental"=>$row["aefi_coincidental"], "aefi_inj_reaction"=>$row["aefi_inj_reaction"], "aefi_unknown"=>$row["aefi_unknown"]);
		}
		
		$series = array("success"=>"yes", "compaignid"=>"$compaignid", "uncode"=>"$uncode", "recatchdata"=>$recatchdata);
		
		return $series;
}

function getcompaign($dbf){
		$query = "SELECT compaignid, no_of_days, startdate, enddate from sia_compaign where active='1'";
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		$row=$dbf->returnDBarray("psql",$result);
		$compaigndata = array("compaignid"=>$row["compaignid"], "noofdays"=>$row["no_of_days"], "startdate"=>$row["startdate"], "enddate"=>$row["enddate"]);
		return $compaigndata;
}

function get_no_ucmo($dbf, $uncode, $compaignid){
	$query="SELECT no_ucmo from sia_ucmo_conf where uncode='".$uncode."' and compaignid=".$compaignid;
	$result=$dbf->queryDB("psql",$query,"SIA Data");
	$row=$dbf->returnDBarray("psql",$result);
	return $row['no_ucmo'];
}


function set_ucmo_team_conf($dbf, $uncode, $compaignid, $no_ucmo, $ucmo_data, $ip, $imei_no, $source){
	
	$result=$dbf->queryDB("psql","SELECT procode, distcode, tcode from unioncouncil where uncode='".$uncode."'","Province, District and Tehsile codes of UC");
	
	$row=$dbf->returnDBarray("psql",$result);
	$procode=$row["procode"];
	$distcode=$row["distcode"]; 
	$tcode=$row["tcode"];

	$updatequery="UPDATE sia_ucmo_conf set no_ucmo=".$no_ucmo." where uncode='".$uncode."' and compaignid=".$compaignid;
	$dbf->queryDB("psql",$updatequery,"Set No of UCMO against UC");

	$deletequery1="DELETE from sia_uc_team_configuration where uncode='".$uncode."' and compaignid=".$compaignid;
	$dbf->queryDB("psql",$deletequery1, "Deleting UCMO Team Configuration");

	$deletequery2="DELETE from sia_teamcomposition where uncode='".$uncode."' and compaignid=".$compaignid;
	$dbf->queryDB("psql",$deletequery2, "Deleting UCMO Team Configuration");

	$deletequery3="DELETE from sia_uc_dailyactivitysummary where uncode='".$uncode."' and compaignid=".$compaignid;
	$dbf->queryDB("psql",$deletequery3, "Deleting UCMO Team Configuration");

	$deletequery4="DELETE from sia_dailyteamwiseactivity where uncode='".$uncode."' and compaignid=".$compaignid;
	$dbf->queryDB("psql",$deletequery4, "Deleting UCMO Team Configuration");
	
	foreach($ucmo_data as $x){
		$no_fixedteams = (int)$x->{'no_fixedteams'};
		$no_mobileteams = (int)$x->{'no_mobileteams'};
		$no_outreachteams = (int)$x->{'no_outreachteams'};
		$teamno=0;
		$insertquery1="INSERT into sia_uc_team_configuration (compaignid, uncode, ucmo_code, ucmo_name, no_fixedteams, no_mobileteams, no_outreachteams, procode, distcode, tcode, updateddatetime, updatedby, ip, imei_no, source) values (".$compaignid.", '".$uncode."', ".$x->{'ucmo_code'}.", '".$x->{'ucmo_name'}."', ".$no_fixedteams.", ".$no_mobileteams.", ".$no_outreachteams.", '".$procode."', '".$distcode."', '".$tcode."', '".date("Y-m-d h:i:s")."', '".$uncode."', '".$ip."', '".$imei_no."', '".$source."')";
		
		// Inserting UCMO Team Configuration record in table sia_uc_team_configuration
		$dbf->queryDB("psql",$insertquery1, "Inserting UCMO wise Team Configuration");
		
		// Inserting UCMO Fixed Team details record in table sia_teamcomposition 	
		for($i=0; $i<$no_fixedteams; $i++){
					$teamno++;
					$insertquery2="INSERT into sia_teamcomposition (compaignid, uncode, ucmo_code, teamno, teamtype, updateddatetime, updatedby, ip) values (".$compaignid.", '".$uncode."', ".$x->{'ucmo_code'}.", ".$teamno.", 'fixed', '".date("Y-m-d h:i:s")."', '".$uncode."', '".$ip."')";
					$dbf->queryDB("psql",$insertquery2, "Inserting UCMO wise Team Configuration");
		}


		// Inserting UCMO Outreach Team details record in table sia_teamcomposition 	
		for($i=0; $i<$no_outreachteams; $i++){
					$teamno++;
					$insertquery4="INSERT into sia_teamcomposition (compaignid, uncode, ucmo_code, teamno, teamtype, updateddatetime, updatedby, ip) values (".$compaignid.", '".$uncode."', ".$x->{'ucmo_code'}.", ".$teamno.", 'outreach', '".date("Y-m-d h:i:s")."', '".$uncode."', '".$ip."')";
					$dbf->queryDB("psql",$insertquery4, "Inserting UCMO wise Team Configuration");
		}

		// Inserting UCMO Mobile Team details record in table sia_teamcomposition 	
		for($i=0; $i<$no_mobileteams; $i++){
					$teamno++;
					$insertquery3="INSERT into sia_teamcomposition (compaignid, uncode, ucmo_code, teamno, teamtype, updateddatetime, updatedby, ip) values (".$compaignid.", '".$uncode."', ".$x->{'ucmo_code'}.", ".$teamno.", 'mobile', '".date("Y-m-d h:i:s")."', '".$uncode."', '".$ip."')";
					$dbf->queryDB("psql",$insertquery3, "Inserting UCMO wise Team Configuration");
		}
		
	}
	return true;
}

function getteamconfiguration($dbf, $uncode, $compaignid){
		$ucmo_data="";
		$no_ucmo = get_no_ucmo($dbf, $uncode, $compaignid);
		$query = "SELECT ucmo_code, ucmo_name, no_fixedteams, no_mobileteams, no_outreachteams from sia_uc_team_configuration where uncode='".$uncode."' and compaignid=".$compaignid;
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		while($row=$dbf->returnDBarray("psql",$result)){
			$ucmo_code = $row["ucmo_code"];
			$ucmo_name = $row["ucmo_name"];
			$no_fixedteams = $row["no_fixedteams"];
			$no_mobileteams = $row["no_mobileteams"];
			$no_outreachteams = $row["no_outreachteams"];
			$ucmoactivitydata = getucmodata($dbf, $uncode, $compaignid, $ucmo_code);
			$ucmo_data[]=array("ucmo_code"=>$ucmo_code, "ucmo_name"=>$ucmo_name, "no_fixedteams"=>$no_fixedteams, "no_mobileteams"=>$no_mobileteams, "no_outreachteams"=>$no_outreachteams, "dailydata"=>$ucmoactivitydata);
		}
		
		$ucmo_conf = array("no_ucmo"=>$no_ucmo, "ucmo_data"=>$ucmo_data);	
		return $ucmo_conf;
}

function getucmodata($dbf, $uncode, $compaignid, $ucmo_code){
		$data="";
		$query = "SELECT dayno, dailytarget, totalvialreceived, currentstock from sia_uc_dailyactivitysummary where uncode='".$uncode."' and ucmo_code=".$ucmo_code." and compaignid=".$compaignid;
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		while($row=$dbf->returnDBarray("psql",$result)){
			$dayno = $row["dayno"];
			$dailytarget = $row["dailytarget"];
			$totalvialreceived = $row["totalvialreceived"];
			$currentstock = $row["currentstock"];
			$teamdata = getucmoteamdata($dbf, $uncode, $compaignid, $ucmo_code, $dayno);
			$data[]=array("dayno"=>$dayno, "dailytarget"=>$dailytarget, "totalvialreceived"=>$totalvialreceived, "currentstock"=>$currentstock, "teamdata"=>$teamdata);
		}
		
			
		return $data;
}

function getucmoteamdata($dbf, $uncode, $compaignid, $ucmo_code, $dayno){
		$teamdata="";
		$query = "SELECT teamno, vaccinated_less5, vaccinated_gt5, totalvialused, aefi_vac_reaction, aefi_prg_error, aefi_coincidental, aefi_inj_reaction, aefi_unknown, dailyteamtarget from sia_dailyteamwiseactivity where uncode='".$uncode."' and compaignid=".$compaignid." and ucmo_code=".$ucmo_code." and dayno=".$dayno;
		$result=$dbf->queryDB("psql",$query,"SIA Data");
		while($row=$dbf->returnDBarray("psql",$result)){
			$teamno = $row["teamno"];
			$vaccinated_less5 = $row["vaccinated_less5"];
			$vaccinated_gt5 = $row["vaccinated_gt5"];
			$totalvialused = $row["totalvialused"];
			$aefi_vac_reaction = $row["aefi_vac_reaction"];
			$aefi_prg_error = $row["aefi_prg_error"];
			$aefi_coincidental = $row["aefi_coincidental"];
			$aefi_inj_reaction = $row["aefi_inj_reaction"];
			$aefi_unknown = $row["aefi_unknown"];
			$dailyteamtarget = $row["dailyteamtarget"];
			$teamdata[]=array("teamno"=>$teamno, "vaccinated_less5"=>$vaccinated_less5, "vaccinated_gt5"=>$vaccinated_gt5, "totalvialused"=>$totalvialused, "aefi_vac_reaction"=>$aefi_vac_reaction, "aefi_prg_error"=>$aefi_prg_error, "aefi_coincidental"=>$aefi_coincidental, "aefi_inj_reaction"=>$aefi_inj_reaction, "aefi_unknown"=>$aefi_unknown, "dailyteamtarget"=>$dailyteamtarget);
		}
		
			
		return $teamdata;
}

function updateimei($dbf, $username, $imeino){
	$dbf->queryDB("psql","UPDATE sia_app_users set imei_no='".$imeino."' where username='".$username."'","SIA Data");
	return true;
}

 function set_team_configuration($dbf, $uncode, $compaignid, $imeino, $no_fixedteams, $no_mobileteams, $no_outreachteams, $ip){
	$updatequery = "UPDATE sia_uc_team_configuration set no_fixedteams=".$no_fixedteams.", no_mobileteams=".$no_mobileteams.", no_outreachteams=".$no_outreachteams.", imeino='".$imeino."', updatedby='".$uncode."', updateddatetime='".date("Y-m-d h:i:s")."', ip='".$ip."' where compaignid=".$compaignid." and uncode='".$uncode."'";
	$dbf->queryDB("psql",$updatequery,"Team configuration Update");
	
	 $query = "SELECT no_fixedteams, no_mobileteams, no_outreachteams from sia_uc_team_configuration where uncode='".$uncode."' and compaignid='".$compaignid."'";
	
	$result=$dbf->queryDB("psql",$query,"Get Team Configuration");
	$row=$dbf->returnDBarray("psql",$result);
	$no_fixedteams1=(int)$row['no_fixedteams'];
	$no_mobileteams1=(int)$row['no_mobileteams'];
	$no_outreachteams1=(int)$row['no_outreachteams'];
	$no_of_teams=$no_fixedteams+$no_mobileteams+$no_outreachteams;
	
	if($no_fixedteams==$no_fixedteams1 && $no_mobileteams==$no_mobileteams1 && $no_outreachteams==$no_outreachteams1){
		$series=array("success"=>"yes", "no_of_teams"=>"$no_of_teams");
	}else{
		$series=array("success"=>"no");
	}
	
	$deleteteamquery = "DELETE from sia_teamcomposition where uncode='".$uncode."'";
	$dbf->queryDB("psql",$deleteteamquery,"Delete from Team composition");
	
	//Adding Teams in Team composition table
	
	$teamno=0;
	for($i=0; $i<$no_fixedteams;$i++){
		$teamno++;
		$teaminsertquery = "INSERT into sia_teamcomposition (compaignid, uncode, teamno, teamtype, updatedby, updateddatetime, ip) values (".$compaignid.", '".$uncode."', ".$teamno.", 'fixed', '".$uncode."', '".date("Y-m-d h:i:s")."', '".$ip."')";
		$dbf->queryDB("psql",$teaminsertquery,"Delete from Team composition");
	}


	for($i=0; $i<$no_outreachteams;$i++){  
		$teamno++;
		$teaminsertquery = "INSERT into sia_teamcomposition (compaignid, uncode, teamno, teamtype, updatedby, updateddatetime, ip) values (".$compaignid.", '".$uncode."', ".$teamno.", 'outreach', '".$uncode."', '".date("Y-m-d h:i:s")."', '".$ip."')";
		$dbf->queryDB("psql",$teaminsertquery,"Delete from Team composition");
	}
 
	for($i=0; $i<$no_mobileteams;$i++){
		$teamno++;
		$teaminsertquery = "INSERT into sia_teamcomposition (compaignid, uncode, teamno, teamtype, updatedby, updateddatetime, ip) values (".$compaignid.", '".$uncode."', ".$teamno.", 'mobile', '".$uncode."', '".date("Y-m-d h:i:s")."', '".$ip."')";
		$dbf->queryDB("psql",$teaminsertquery,"Delete from Team composition");
	}
	
	return $series; 

} 

function deleteexistingdaydata($dbf, $compaignid, $uncode, $ucmocode, $dayno){
	$dbf->queryDB("psql","DELETE from sia_uc_dailyactivitysummary where compaignid=".$compaignid." and uncode='".$uncode."' and dayno=".$dayno." and ucmo_code=".$ucmocode,"Delete existing Data");
	$dbf->queryDB("psql","DELETE from sia_dailyteamwiseactivity where compaignid=".$compaignid." and uncode='".$uncode."' and dayno=".$dayno." and ucmo_code=".$ucmocode,"Delete existing Data");	
}

function updatedailysummary($dbf, $compaignid, $uncode, $dayno, $ucmocode, $activitydate, $dailytarget, $totalvialreceived, $currentstock, $agg_totalvialused, $agg_vaccinated_less5, $agg_vaccinated_gt5, $agg_aefi_vac_reaction, $agg_aefi_prg_error, $agg_aefi_coincidental, $agg_aefi_inj_reaction, $agg_aefi_unknown, $updatedby, $ip, $imei_no, $source){
	
	$result=$dbf->queryDB("psql","SELECT procode, distcode, tcode from unioncouncil where uncode='".$uncode."'","Daily Summary Data");
	
	$row=$dbf->returnDBarray("psql",$result);
	$procode=$row["procode"];
	$distcode=$row["distcode"];
	$tcode=$row["tcode"];
	
	$insertquery = "INSERT into sia_uc_dailyactivitysummary (compaignid, uncode, dayno, ucmo_code, activitydate, dailytarget, totalvialreceived, currentstock, totalvialused, vaccinated_less5, vaccinated_gt5, aefi_vac_reaction, aefi_prg_error, aefi_coincidental, aefi_inj_reaction, aefi_unknown, procode, distcode, tcode, updatedby, updateddatetime, ip, imei_no, source) values (".$compaignid.", '".$uncode."', ".$dayno.", ".$ucmocode.", '".$activitydate."', ".$dailytarget.", ".$totalvialreceived.", ".$currentstock.", ".$agg_totalvialused.", ".$agg_vaccinated_less5.", ".$agg_vaccinated_gt5.", ".$agg_aefi_vac_reaction.", ".$agg_aefi_prg_error.", ".$agg_aefi_coincidental.", ".$agg_aefi_inj_reaction.", ".$agg_aefi_unknown.", '".$procode."', '".$distcode."', '".$tcode."', '".$updatedby."', '".date("Y-m-d h:i:s")."', '".$ip."', '".$imei_no."', '".$source."')";
	
	$dbf->queryDB("psql",$insertquery,"Daily Summary Data");
	return true;
}

function deleteexistingrecatch($dbf, $compaignid, $uncode, $ucmocode, $activitydate){
	//echo "DELETE from sia_recatch where compaignid=".$compaignid." and uncode='".$uncode."' and activitydate='".$activitydate."' and ucmo_code=".$ucmocode;
	$dbf->queryDB("psql","DELETE from sia_recatch where compaignid=".$compaignid." and uncode='".$uncode."' and activitydate='".$activitydate."' and ucmo_code=".$ucmocode,"Delete existing Data");
}

function insertrecatch($dbf, $compaignid, $uncode, $ucmocode, $activitydate, $totalvialused, $vaccinated_less5, 	$vaccinated_gt5, $aefi_vac_reaction, $aefi_prg_error, $aefi_coincidental, $aefi_inj_reaction, $aefi_unknown, $updatedby, $ip, $imei_no, $source){

	
	$result=$dbf->queryDB("psql","SELECT procode, distcode, tcode from unioncouncil where uncode='".$uncode."'","Daily Summary Data");
	
	$row=$dbf->returnDBarray("psql",$result);
	$procode=$row["procode"];
	$distcode=$row["distcode"];
	$tcode=$row["tcode"];
	
	$insertquery = "INSERT into sia_recatch (compaignid, uncode, ucmo_code, activitydate, totalvialused, vaccinated_less5, vaccinated_gt5, aefi_vac_reaction, aefi_prg_error, aefi_coincidental, aefi_inj_reaction, aefi_unknown, procode, distcode, tcode, updatedby, updateddatetime, ip, imei_no, source) values (".$compaignid.", '".$uncode."', ".$ucmocode.", '".$activitydate."', ".$totalvialused.", ".$vaccinated_less5.", ".$vaccinated_gt5.", ".$aefi_vac_reaction.", ".$aefi_prg_error.", ".$aefi_coincidental.", ".$aefi_inj_reaction.", ".$aefi_unknown.", '".$procode."', '".$distcode."', '".$tcode."', '".$updatedby."', '".date("Y-m-d h:i:s")."', '".$ip."', '".$imei_no."', '".$source."')";
	
	$dbf->queryDB("psql",$insertquery,"Daily Summary Data");
	return true;
}

function updatedailyteamwise($dbf, $compaignid, $uncode, $dayno, $ucmocode, $teamno, $activitydate, $vaccinated_less5, $vaccinated_gt5, $totalvialused, $aefi_vac_reaction, $aefi_prg_error, $aefi_coincidental, $aefi_inj_reaction, $aefi_unknown, $dailyteamtarget, $updatedby, $ip, $imei_no){

	$insertquery = "INSERT into sia_dailyteamwiseactivity (compaignid, uncode, dayno, ucmo_code, teamno, activitydate, vaccinated_less5, vaccinated_gt5, totalvialused, aefi_vac_reaction, aefi_prg_error, aefi_coincidental, aefi_inj_reaction, aefi_unknown, dailyteamtarget, updateddatetime, updatedby, ip, imei_no) values (".$compaignid.", '".$uncode."', ".$dayno.", ".$ucmocode.", ".$teamno.", '".$activitydate."', ".$vaccinated_less5.", ".$vaccinated_gt5.", ".$totalvialused.", ".$aefi_vac_reaction.", ".$aefi_prg_error.", ".$aefi_coincidental.", ".$aefi_inj_reaction.", '".$aefi_unknown."', '".$dailyteamtarget."', '".date("Y-m-d h:i:s")."', '".$updatedby."', '".$ip."', '".$imei_no."')";
	
	$dbf->queryDB("psql",$insertquery,"Daily teamwise Data"); 
	return true;
}  


function logit($dbf, $activity, $action, $data, $uncode, $ip, $imei_no, $source){
	
	$insertquery = "INSERT into sia_activitylog (activitydatetime, activity, action, username, information, ip, imeino, source) values ('".date("Y-m-d h:i:s")."', '".$activity."', '".$action."', '".$uncode."', '".$data."', '".$ip."', '".$imei_no."', '".$source."')"; 
	
	$dbf->queryDB("psql",$insertquery,"Logging the activity"); 
	return true;
	
}

function loginlog($dbf, $username, $attemptedresult, $data, $ip, $imei_no, $source, $reason, $response){
	
	$insertquery = "INSERT into sia_loginlog (activitydatetime, username, attemptedresult, information, ip, imeino, source, reason, response) values ('".date("Y-m-d h:i:s")."', '".$username."', '".$attemptedresult."', '".$data."', '".$ip."', '".$imei_no."', '".$source."', '".$reason."', '".$response."')"; 
	
	$dbf->queryDB("psql",$insertquery,"Logging the Login activity"); 
	return true;
	
}

function getdatefromday($dayno){
	$ndate="";
	switch($dayno){
		case '1' : $ndate = '2018-10-15';
					break;
		case '2' : $ndate = '2018-10-16';
					break;
		case '3' : $ndate = '2018-10-17';
					break;
		case '4' : $ndate = '2018-10-18';
					break;
		case '5' : $ndate = '2018-10-19';
					break;
		case '6' : $ndate = '2018-10-20';
					break;
		case '7' : $ndate = '2018-10-21';
					break;
		case '8' : $ndate = '2018-10-22';
					break;
		case '9' : $ndate = '2018-10-23';
					break;
		case '10' : $ndate = '2018-10-24';
					break;
		case '11' : $ndate = '2018-10-25';
					break;
		case '12' : $ndate = '2018-10-26';
	}
	return $ndate;
}

?>