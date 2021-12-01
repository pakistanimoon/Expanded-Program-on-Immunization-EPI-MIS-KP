<?php

function authenticationbyimei($dbf, $username, $imei){
	
	$query = "SELECT techniciancode, iemi_no from techniciandb where techniciancode='".$username."' and iemi_no='".$imei."'";
	$result = $dbf->queryDB("psql",$query,"authentication");
	$row=$dbf->returnDBarray("psql", $result);
	$imei1 = $row['iemi_no'];

	if($imei == $imei1){
		return true;
	}else{
		return false;

	}	
}


function authentication($dbf, $username, $pass){
	$result = $dbf->queryDB("psql","SELECT techniciancode, password from techniciandb where techniciancode='".$username."' and password not like '!%'","authentication");
	$row=$dbf->returnDBarray("psql", $result);
	$pass1 = $row["password"];
	if(md5($pass) == $pass1){
		return true;
	}else{
		return false;
	}	
}


function loginresponsejson($dbf, $username){



		$query = "select techniciancode, technicianname, procode, provincename(procode) as province, distcode, districtname(distcode) as district, tcode, tehsilname(tcode) as tehsil, uncode, unname(uncode) as ucname, facode, facilityname(facode) as facilityname, phone as contactno from techniciandb where techniciancode='".$username."'";
		$result=$dbf->queryDB("psql",$query,"Cerv Data");
		$row=$dbf->returnDBarray("psql",$result);

		$series=array("success"=>"yes", "vaccinator_code"=>$row["techniciancode"], "vaccinator_name"=>$row["technicianname"], "uncode"=>$row["uncode"], "ucname"=>$row["ucname"], "procode"=>$row["procode"], "province"=>$row["province"], "distcode"=>$row["distcode"], "district"=>$row["district"], "tcode"=>$row["tcode"], "tehsil"=>$row["tehsil"], "facode"=>$row["facode"], "facilityname"=>$row["facilityname"], "contactno"=>$row["contactno"]);
		
		return $series;
}


function cervchildlist($dbf, $username){

		$query = "select child_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, nameofchild, cardno, gender, dateofbirth, housestreet, villagemohallah, fathername, mothername, fathercnic, contactno, latitude, longitude, year, bcg, hepb, opv0, opv1, opv2, opv3, penta1, penta2, penta3, pcv1, pcv2, pcv3, ipv, rota1, rota2, measles1, measles2, bcg_lat, bcg_long, hepb_lat, hepb_long, opv0_lat, opv0_long, opv1_lat, opv1_long, opv2_lat, opv2_long, opv3_lat, opv3_long, penta1_lat, penta1_long, penta2_lat, penta2_long, penta3_lat, penta3_long, pcv1_lat, pcv1_long, pcv2_lat, pcv2_long, pcv3_lat, pcv3_long, ipv_lat, ipv_long, rota1_lat, rota1_long, rota2_lat, rota2_long, measles1_lat, measles1_long, measles2_lat, measles2_long, fingerprint, bcg_facode, hepb_facode, opv0_facode, opv1_facode, opv2_facode, opv3_facode, penta1_facode, penta2_facode, penta3_facode, pcv1_facode, pcv2_facode, pcv3_facode, ipv_facode, rota1_facode, rota2_facode, measles1_facode, measles2_facode, isoutsitefacility, submitteddate from cerv_child_registration_test where techniciancode='".$username."'";
		$result=$dbf->queryDB("psql",$query,"Cerv Data");
		$i=0;
		while($row=$dbf->returnDBarray("psql",$result)){

			$series[$i]=array("vaccinator_code"=>$row["techniciancode"], "child_registration_no"=>$row["child_registration_no"], "imei"=>$row["imei"], "procode"=>$row["procode"], "distcode"=>$row["distcode"], "tcode"=>$row["tcode"], "uncode"=>$row["uncode"], "reg_facode"=>$row["reg_facode"], "nameofchild"=>$row["nameofchild"], "cardno"=>$row["cardno"], "gender"=>$row["gender"], "dateofbirth"=>$row["dateofbirth"], "housestreet"=>$row["housestreet"], "villagemohallah"=>$row["villagemohallah"], "fathername"=>$row["fathername"], "mothername"=>$row["mothername"], "fathercnic"=>$row["fathercnic"], "contactno"=>$row["contactno"], "latitude"=>$row["latitude"], "longitude"=>$row["longitude"], "year"=>$row["year"], "bcg"=>$row["bcg"], "hepb"=>$row["hepb"], "opv0"=>$row["opv0"], "opv1"=>$row["opv1"], "opv2"=>$row["opv2"], "opv3"=>$row["opv3"], "penta1"=>$row["penta1"], "penta2"=>$row["penta2"], "penta3"=>$row["penta3"], "pcv1"=>$row["pcv1"], "pcv2"=>$row["pcv2"], "pcv3"=>$row["pcv3"], "ipv"=>$row["ipv"], "rota1"=>$row["rota1"], "rota2"=>$row["rota2"], "measles1"=>$row["measles1"], "measles2"=>$row["measles2"], "bcg_lat"=>$row["bcg_lat"], "bcg_long"=>$row["bcg_long"], "hepb_lat"=>$row["hepb_lat"], "hepb_long"=>$row["hepb_long"], "opv0_lat"=>$row["opv0_lat"], "opv0_long"=>$row["opv0_long"], "opv1_lat"=>$row["opv1_lat"], "opv1_long"=>$row["opv1_long"], "opv2_lat"=>$row["opv2_lat"], "opv2_long"=>$row["opv2_long"], "opv3_lat"=>$row["opv3_lat"], "opv3_long"=>$row["opv3_long"], "penta1_lat"=>$row["penta1_lat"], "penta1_long"=>$row["penta1_long"], "penta2_lat"=>$row["penta2_lat"], "penta2_long"=>$row["penta2_long"], "penta3_lat"=>$row["penta3_lat"], "penta3_long"=>$row["penta3_long"], "pcv1_lat"=>$row["pcv1_lat"], "pcv1_long"=>$row["pcv1_long"], "pcv2_lat"=>$row["pcv2_lat"], "pcv2_long"=>$row["pcv2_long"], "pcv3_lat"=>$row["pcv3_lat"], "pcv3_long"=>$row["pcv3_long"], "ipv_lat"=>$row["ipv_lat"], "ipv_long"=>$row["ipv_long"], "rota1_lat"=>$row["rota1_lat"], "rota1_long"=>$row["rota1_long"], "rota2_lat"=>$row["rota2_lat"], "rota2_long"=>$row["rota2_long"], "measles1_lat"=>$row["measles1_lat"], "measles1_long"=>$row["measles1_long"], "measles2_lat"=>$row["measles2_lat"], "measles2_long"=>$row["measles2_long"], "fingerprint"=>$row["fingerprint"], "bcg_facode"=>$row["bcg_facode"], "hepb_facode"=>$row["hepb_facode"], "opv0_facode"=>$row["opv0_facode"], "opv1_facode"=>$row["opv1_facode"], "opv2_facode"=>$row["opv2_facode"], "opv3_facode"=>$row["opv3_facode"], "penta1_facode"=>$row["penta1_facode"], "penta2_facode"=>$row["penta2_facode"], "penta3_facode"=>$row["penta3_facode"], "pcv1_facode"=>$row["pcv1_facode"], "pcv2_facode"=>$row["pcv2_facode"], "pcv3_facode"=>$row["pcv3_facode"], "ipv_facode"=>$row["ipv_facode"], "rota1_facode"=>$row["rota1_facode"], "rota2_facode"=>$row["rota2_facode"], "measles1_facode"=>$row["measles1_facode"], "measles2_facode"=>$row["measles2_facode"], "isoutsitefacility"=>$row["isoutsitefacility"], "submitteddate"=>$row["submitteddate"]);
			removeEmptyValues($series[$i]);
			$i++;
		}
		return $series;
}



  function removeEmptyValues(array &$array){
    foreach ($array as $key => &$value) {
      if (is_array($value)) {
        $value = removeEmptyValues($value);
      }
      if (empty($value)) {
        unset($array[$key]);
      }
    }
    return $array;
  }



function updateimei($dbf, $username, $imeino){
	$dbf->queryDB("psql","UPDATE techniciandb set iemi_no='".$imeino."' where techniciancode='".$username."'","Cerv Data");
	return true;
}



function logit($dbf, $activity, $action, $data, $uncode, $ip, $imei_no, $source){
	
	$insertquery = "INSERT into sia_activitylog (activitydatetime, activity, action, username, information, ip, imeino, source) values ('".date("Y-m-d h:i:s")."', '".$activity."', '".$action."', '".$uncode."', '".$data."', '".$ip."', '".$imei_no."', '".$source."')"; 
	$dbf->queryDB("psql",$insertquery,"Logging the activity"); 
	return true;
	
}

function loginlog($dbf, $username, $attemptedresult, $data, $ip, $imei_no, $source, $reason, $response){
	
	$insertquery = "INSERT into cerv_loginlog (activitydatetime, username, attemptedresult, information, ip, imeino, source, reason, response) values ('".date("Y-m-d h:i:s")."', '".$username."', '".$attemptedresult."', '".$data."', '".$ip."', '".$imei_no."', '".$source."', '".$reason."', '".$response."')"; 
	
	$dbf->queryDB("psql",$insertquery,"Logging the Login activity"); 
	return true;
	
}



?>