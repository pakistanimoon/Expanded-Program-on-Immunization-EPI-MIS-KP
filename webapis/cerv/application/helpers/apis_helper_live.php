<?php
if( ! function_exists('authentication'))
{
	function authentication($username, $pass)
	{
		$CI = & get_instance();
		$CI -> db -> select('techniciancode, password');
		$CI -> db -> where(array('techniciancode' => $username, 'status' => 'Active'));
		$CI -> db -> not_like('password', '!%');
		$result = $CI -> db -> get('techniciandb') -> row();
		$dbPassword = (isset($result -> password))?$result -> password:'';
		
		if(md5($pass) == $dbPassword){
			return true;
		}else{
			return false;
		}	
	}
}

if( ! function_exists('authenticationbyimei'))
{
	function authenticationbyimei($username, $imei)
	{
		$CI = & get_instance();
		$CI -> db -> select('techniciancode, iemi_no');
		$CI -> db -> where(array('techniciancode' =>$username, 'iemi_no' => $imei));
		$result = $CI -> db -> get('techniciandb') -> row();
		$dbimei = (isset($result -> iemi_no))?$result -> iemi_no:'';

		if($imei == $dbimei){
			return true;
		}else{
			return false;

		}	
	}
}

if( ! function_exists('loginresponsejson'))
{
	function loginresponsejson($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('techniciancode, technicianname, procode, provincename(procode) as province, distcode, districtname(distcode) as district, tcode, tehsilname(tcode) as tehsil, uncode, unname(uncode) as ucname, facode, facilityname(facode) as facilityname, phone as contactno');
		$CI -> db -> where(array('techniciancode' =>$username));
		$row = $CI -> db -> get('techniciandb') -> row_array();

		$series=array("success"=>"yes", "vaccinator_code"=>$row["techniciancode"], "vaccinator_name"=>$row["technicianname"], "uncode"=>$row["uncode"], "ucname"=>$row["ucname"], "procode"=>$row["procode"], "province"=>$row["province"], "distcode"=>$row["distcode"], "district"=>$row["district"], "tcode"=>$row["tcode"], "tehsil"=>$row["tehsil"], "facode"=>$row["facode"], "facilityname"=>$row["facilityname"], "contactno"=>$row["contactno"]);	
		return $series;
	}
}

if( ! function_exists('cervchildlist'))
{
	function cervchildlist($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('provincename(procode) province,districtname(distcode) district,tehsilname(tcode) tehsil, unname(uncode) unioncouncil,facilityname(reg_facode) facility,child_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, nameofchild, cardno, gender, dateofbirth, fathername, mothername, fathercnic, contactno, latitude, longitude, year, bcg, hepb, opv0, opv1, opv2, opv3, penta1, penta2, penta3, pcv1, pcv2, pcv3, ipv, rota1, rota2, measles1, measles2, bcg_lat, bcg_long, hepb_lat, hepb_long, opv0_lat, opv0_long, opv1_lat, opv1_long, opv2_lat, opv2_long, opv3_lat, opv3_long, penta1_lat, penta1_long, penta2_lat, penta2_long, penta3_lat, penta3_long, pcv1_lat, pcv1_long, pcv2_lat, pcv2_long, pcv3_lat, pcv3_long, ipv_lat, ipv_long, rota1_lat, rota1_long, rota2_lat, rota2_long, measles1_lat, measles1_long, measles2_lat, measles2_long, fingerprint, bcg_facode, hepb_facode, opv0_facode, opv1_facode, opv2_facode, opv3_facode, penta1_facode, penta2_facode, penta3_facode, pcv1_facode, pcv2_facode, pcv3_facode, ipv_facode, rota1_facode, rota2_facode, measles1_facode, measles2_facode, bcg_mode, hepb_mode, opv0_mode, opv1_mode, opv2_mode, opv3_mode, penta1_mode, penta2_mode, penta3_mode, pcv1_mode, pcv2_mode, pcv3_mode, ipv_mode, rota1_mode, rota2_mode, measles1_mode, measles2_mode, bcg_techniciancode, hepb_techniciancode, opv0_techniciancode, opv1_techniciancode, opv2_techniciancode, opv3_techniciancode, penta1_techniciancode, penta2_techniciancode, penta3_techniciancode, pcv1_techniciancode, pcv2_techniciancode, pcv3_techniciancode, ipv_techniciancode, rota1_techniciancode, rota2_techniciancode, measles1_techniciancode, measles2_techniciancode, isoutsitefacility, submitteddate'); // housestreet, villagemohallah,(removed)
		$CI -> db -> where(array('techniciancode' =>$username));
		$result = $CI -> db -> get('cerv_child_registration') -> result_array();
		$i = 0;
		$series = array();
		foreach($result as $key => $row){

			$series[$i]=array("Province"=>$row["province"], "District"=>$row["district"], "Tehsil"=>$row["tehsil"], "UnionCouncil"=>$row["unioncouncil"], "facility"=>$row["facility"], "vaccinator_code"=>$row["techniciancode"], "child_registration_no"=>$row["child_registration_no"], "imei"=>$row["imei"], "procode"=>$row["procode"], "distcode"=>$row["distcode"], "tcode"=>$row["tcode"], "uncode"=>$row["uncode"], "reg_facode"=>$row["reg_facode"], "nameofchild"=>$row["nameofchild"], "cardno"=>$row["cardno"], "gender"=>$row["gender"], "dateofbirth"=>$row["dateofbirth"],  "fathername"=>$row["fathername"], "mothername"=>$row["mothername"], "fathercnic"=>$row["fathercnic"], "contactno"=>$row["contactno"], "latitude"=>$row["latitude"], "longitude"=>$row["longitude"], "year"=>$row["year"], "bcg"=>$row["bcg"], "hepb"=>$row["hepb"], "opv0"=>$row["opv0"], "opv1"=>$row["opv1"], "opv2"=>$row["opv2"], "opv3"=>$row["opv3"], "penta1"=>$row["penta1"], "penta2"=>$row["penta2"], "penta3"=>$row["penta3"], "pcv1"=>$row["pcv1"], "pcv2"=>$row["pcv2"], "pcv3"=>$row["pcv3"], "ipv"=>$row["ipv"], "rota1"=>$row["rota1"], "rota2"=>$row["rota2"], "measles1"=>$row["measles1"], "measles2"=>$row["measles2"], "bcg_lat"=>$row["bcg_lat"], "bcg_long"=>$row["bcg_long"], "hepb_lat"=>$row["hepb_lat"], "hepb_long"=>$row["hepb_long"], "opv0_lat"=>$row["opv0_lat"], "opv0_long"=>$row["opv0_long"], "opv1_lat"=>$row["opv1_lat"], "opv1_long"=>$row["opv1_long"], "opv2_lat"=>$row["opv2_lat"], "opv2_long"=>$row["opv2_long"], "opv3_lat"=>$row["opv3_lat"], "opv3_long"=>$row["opv3_long"], "penta1_lat"=>$row["penta1_lat"], "penta1_long"=>$row["penta1_long"], "penta2_lat"=>$row["penta2_lat"], "penta2_long"=>$row["penta2_long"], "penta3_lat"=>$row["penta3_lat"], "penta3_long"=>$row["penta3_long"], "pcv1_lat"=>$row["pcv1_lat"], "pcv1_long"=>$row["pcv1_long"], "pcv2_lat"=>$row["pcv2_lat"], "pcv2_long"=>$row["pcv2_long"], "pcv3_lat"=>$row["pcv3_lat"], "pcv3_long"=>$row["pcv3_long"], "ipv_lat"=>$row["ipv_lat"], "ipv_long"=>$row["ipv_long"], "rota1_lat"=>$row["rota1_lat"], "rota1_long"=>$row["rota1_long"], "rota2_lat"=>$row["rota2_lat"], "rota2_long"=>$row["rota2_long"], "measles1_lat"=>$row["measles1_lat"], "measles1_long"=>$row["measles1_long"], "measles2_lat"=>$row["measles2_lat"], "measles2_long"=>$row["measles2_long"], "fingerprint"=>$row["fingerprint"], "bcg_facode"=>$row["bcg_facode"], "hepb_facode"=>$row["hepb_facode"], "opv0_facode"=>$row["opv0_facode"], "opv1_facode"=>$row["opv1_facode"], "opv2_facode"=>$row["opv2_facode"], "opv3_facode"=>$row["opv3_facode"], "penta1_facode"=>$row["penta1_facode"], "penta2_facode"=>$row["penta2_facode"], "penta3_facode"=>$row["penta3_facode"], "pcv1_facode"=>$row["pcv1_facode"], "pcv2_facode"=>$row["pcv2_facode"], "pcv3_facode"=>$row["pcv3_facode"], "ipv_facode"=>$row["ipv_facode"], "rota1_facode"=>$row["rota1_facode"], "rota2_facode"=>$row["rota2_facode"], "measles1_facode"=>$row["measles1_facode"], "measles2_facode"=>$row["measles2_facode"],  "bcg_mode"=>$row["bcg_mode"], "hepb_mode"=>$row["hepb_mode"], "opv0_mode"=>$row["opv0_mode"], "opv1_mode"=>$row["opv1_mode"], "opv2_mode"=>$row["opv2_mode"], "opv3_mode"=>$row["opv3_mode"], "penta1_mode"=>$row["penta1_mode"], "penta2_mode"=>$row["penta2_mode"], "penta3_mode"=>$row["penta3_mode"], "pcv1_mode"=>$row["pcv1_mode"], "pcv2_mode"=>$row["pcv2_mode"], "pcv3_mode"=>$row["pcv3_mode"], "ipv_mode"=>$row["ipv_mode"], "rota1_mode"=>$row["rota1_mode"], "rota2_mode"=>$row["rota2_mode"], "measles1_mode"=>$row["measles1_mode"], "measles2_mode"=>$row["measles2_mode"], "bcg_techniciancode"=>$row["bcg_techniciancode"], "hepb_techniciancode"=>$row["hepb_techniciancode"], "opv0_techniciancode"=>$row["opv0_techniciancode"], "opv1_techniciancode"=>$row["opv1_techniciancode"], "opv2_techniciancode"=>$row["opv2_techniciancode"], "opv3_techniciancode"=>$row["opv3_techniciancode"], "penta1_techniciancode"=>$row["penta1_techniciancode"], "penta2_techniciancode"=>$row["penta2_techniciancode"], "penta3_techniciancode"=>$row["penta3_techniciancode"], "pcv1_techniciancode"=>$row["pcv1_techniciancode"], "pcv2_techniciancode"=>$row["pcv2_techniciancode"], "pcv3_techniciancode"=>$row["pcv3_techniciancode"], "ipv_techniciancode"=>$row["ipv_techniciancode"], "rota1_techniciancode"=>$row["rota1_techniciancode"], "rota2_techniciancode"=>$row["rota2_techniciancode"], "measles1_techniciancode"=>$row["measles1_techniciancode"], "measles2_techniciancode"=>$row["measles2_techniciancode"], "isoutsitefacility"=>$row["isoutsitefacility"], "submitteddate"=>$row["submitteddate"]); //"housestreet"=>$row["housestreet"], "villagemohallah"=>$row["villagemohallah"](removed)
			//removeEmptyValues($series[$i]);
			$i++;
		}
		return $series;
	}
}

if( ! function_exists('cervmotherlist'))
{
	function cervmotherlist($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('provincename(procode) province,districtname(distcode) district,tehsilname(tcode) tehsil, unname(uncode) unioncouncil,facilityname(reg_facode) facility,mother_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, mother_name, mother_age, cardno, house, village, husband_name, mother_cnic, contactno, latitude, longitude, year, tt1, tt2, tt3, tt4, tt5, tt1_lat, tt1_long, tt2_lat, tt2_long, tt3_lat, tt3_long, tt4_lat, tt4_long, tt5_lat, tt5_long, fingerprint, tt1_facode, tt2_facode, tt3_facode, tt4_facode, tt5_facode, is_outer_registered, submitted_date');
		$CI -> db -> where(array('techniciancode' =>$username));
		$result = $CI -> db -> get('cerv_mother_registration') -> result_array();
		$i = 0;
		$series = array();
		foreach($result as $key => $row){

			$series[$i]=array("province"=>$row["province"], "district"=>$row["district"], "tehsil"=>$row["tehsil"], "unioncouncil"=>$row["unioncouncil"], "facility"=>$row["facility"], "mother_age"=>$row["mother_age"], "vaccinator_code"=>$row["techniciancode"], "mother_registration_no"=>$row["mother_registration_no"], "imei"=>$row["imei"], "procode"=>$row["procode"], "distcode"=>$row["distcode"], "tcode"=>$row["tcode"], "uncode"=>$row["uncode"], "reg_facode"=>$row["reg_facode"], "mother_name"=>$row["mother_name"], "cardno"=>$row["cardno"], "house"=>$row["house"], "village"=>$row["village"], "husband_name"=>$row["husband_name"], "mother_cnic"=>$row["mother_cnic"], "contactno"=>$row["contactno"], "latitude"=>$row["latitude"], "longitude"=>$row["longitude"], "year"=>$row["year"], "tt1"=>$row["tt1"], "tt2"=>$row["tt2"], "tt3"=>$row["tt3"], "tt4"=>$row["tt4"], "tt5"=>$row["tt5"], "tt1_lat"=>$row["tt1_lat"], "tt1_long"=>$row["tt1_long"], "tt2_lat"=>$row["tt2_lat"], "tt2_long"=>$row["tt2_long"], "tt3_lat"=>$row["tt3_lat"], "tt3_long"=>$row["tt3_long"], "tt4_lat"=>$row["tt4_lat"], "tt4_long"=>$row["tt4_long"], "tt5_lat"=>$row["tt5_lat"], "tt5_long"=>$row["tt5_long"], "fingerprint"=>$row["fingerprint"], "tt1_facode"=>$row["tt1_facode"], "tt2_facode"=>$row["tt2_facode"], "tt3_facode"=>$row["tt3_facode"], "tt4_facode"=>$row["tt4_facode"], "tt5_facode"=>$row["tt5_facode"], "is_outer_registered"=>$row["is_outer_registered"], "submitteddate"=>$row["submitted_date"]);
			//removeEmptyValues($series[$i]);
			$i++;
		}
		return $series;
	}
}

if( ! function_exists('removeEmptyValues'))
{
	function removeEmptyValues(array &$array)
	{
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
}

if( ! function_exists('updateimei'))
{
	function updateimei($username, $imeino)
	{
		$CI = & get_instance();	
		$data['iemi_no'] = $imeino;
		$CI -> db -> where('techniciancode',$username);
		$CI -> db -> update('techniciandb',$data);
		return true;
	}
}

if( ! function_exists('logit'))
{
	function logit($activity, $action, $data, $uncode, $ip, $imei_no, $source)
	{
		$CI = & get_instance();	
		$insertData['activitydatetime'] = date("Y-m-d h:i:s");
		$insertData['activity'] = date("Y-m-d h:i:s");
		$insertData['action'] = $activity;
		$insertData['username'] = $uncode;
		$insertData['information'] = json_encode($data);
		$insertData['ip'] = $ip;
		$insertData['imeino'] = $imei_no;
		$insertData['source'] = $source;
		$CI -> db -> insert('sia_activitylog',$insertData);
		return true;
	}
}

if( ! function_exists('loginlog'))
{
	function loginlog($username, $attemptedresult, $data, $ip, $imei_no, $source, $reason, $response)
	{
		$CI = & get_instance();
		$insertData['activitydatetime'] = date("Y-m-d h:i:s");
		$insertData['attemptedresult'] = $attemptedresult;
		$insertData['reason'] = $reason;
		$insertData['username'] = $username;
		$insertData['information'] = json_encode($data);
		$insertData['ip'] = $ip;
		$insertData['imeino'] = $imei_no;
		$insertData['source'] = $source;
		$insertData['response'] = $response;
		
		$CI -> db -> insert('cerv_loginlog',$insertData);
		return true;
	}
}

if( ! function_exists('updateTechnicianModelNo'))
{
	function updateTechnicianModelNo($username,$model_no)
	{
		$CI = & get_instance();
		$CI -> db -> update('techniciandb',array('model_no'=>$model_no),array('techniciancode'=>$username));
	}
}

if( ! function_exists('getMaxCardNoforChild'))
{
	function getMaxCardNoforChild($techniciancode)
	{
		$CI = & get_instance();
		$CI -> db -> select('max(cardno::numeric) newcardno');
		//$CI -> db -> select('max(cardno::numeric) newcardno');
		$CI -> db -> where('techniciancode',$techniciancode);
		$CI -> db -> where('CHAR_LENGTH(cardno) <','6');//added by moon for temp solution
		$result = $CI -> db -> get('cerv_child_registration') -> row();
		return (isset($result -> newcardno) && $result -> newcardno > 0)?$result -> newcardno:0;
	}
}

if( ! function_exists('getMaxCardNoforMother'))
{
	function getMaxCardNoforMother($techniciancode)
	{
		$CI = & get_instance();
		$CI -> db -> select('max(cardno::numeric) newcardno');
		$CI -> db -> where('techniciancode',$techniciancode);
		$result = $CI -> db -> get('cerv_mother_registration') -> row();
		return (isset($result -> newcardno) && $result -> newcardno > 0)?$result -> newcardno:0;
	}
}

if( ! function_exists('searchMotherAgainstCnic'))
{
	function searchMotherAgainstCnic($cnic)
	{
		$CI = & get_instance();
		$CI -> db -> select('cardno, mother_registration_no, mother_name, mother_age, husband_name, mother_cnic, contactno');
		$CI -> db -> where('mother_cnic',$cnic);
		$result = $CI -> db -> get('cerv_mother_registration') -> row_array();
		return ( ! empty($result))?$result:array();
	}
}
?>