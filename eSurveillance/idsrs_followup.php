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
	$dateFollowup = $json->{'dateFollowup'};
	$complicationFollowup = $json->{'complicationFollowup'};
	$deathFollowup = $json->{'deathFollowup'};
	$queryUpdateFollowup = "update diseases_surveillance_mob set case_date_follow='$dateFollowup',complication_follow='$complicationFollowup',death_follow='$deathFollowup' where full_epid_no='$epidNumber' ";
	$resultUpdateFollowup = pg_query($db, $queryUpdateFollowup);
	if(!$resultUpdateFollowup){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>$err));exit;
		exit;
    }else{
		$affectedRows = pg_affected_rows($resultUpdateFollowup);
		if($affectedRows > 0)
			echo json_encode(array('result' => 'Record Inserted'));exit;
		echo json_encode(array('result' => 'Any Error Ocurred'));exit;
	}
?>