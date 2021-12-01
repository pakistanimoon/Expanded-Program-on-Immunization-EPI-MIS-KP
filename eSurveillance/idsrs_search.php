<?php
 	$data = file_get_contents('php://input');
    $json = json_decode($data);
	//---------Database Connection Code Start-------------//
	//------------Database Info----------------//
	$host        = "host=localhost ";
	$port        = "port=5432 ";
	$dbname      = "dbname=epikp ";
	$credentials = "user=epikpuser password=EpiKP#987";
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		$result = array('Error' => 'Unable to open database.');
		echo json_encode($result);exit;
		exit;
	} else {
		$result = array('Success' => 'Opened database successfully');
	}
	//-------------- Database Connection Code Ends ---------------//
	//-------------- Get Data From Android Request ---------------//
	$epidNumber = $json->{'epidNo'};
	$imeiNumber = $json->{'imei'};
	$querySearchCase = "select name_case,gender,case_age,case_father_name,case_father_nic,case_cell,case_address,case_type,full_epid_no,case_date_onset,case_date_investigation,case_tot_vacc_received,case_date_last_dose_received,submitted_date,specieman_result,case_date_follow,complication_follow,death_follow from diseases_surveillance_mob where imei='$imeiNumber' and full_epid_no = '$epidNumber'";
	$resultSearchCase = pg_query($db, $querySearchCase);
	if(!$resultSearchCase){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>$err));exit;
		exit;
    }else{
		$rowResult = pg_fetch_all($resultSearchCase);
		echo json_encode($rowResult,JSON_FORCE_OBJECT);exit;
	}
?>