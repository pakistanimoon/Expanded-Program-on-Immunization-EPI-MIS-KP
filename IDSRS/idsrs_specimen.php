<?php
 	$data = file_get_contents('php://input');
    $json = json_decode($data);
	//---------Database Connection Code Start-------------//
	//------------Database Info----------------//
	$host        = "host=216.97.233.45 ";
	$port        = "port=5432 ";
	$dbname      = "dbname=pacet3_epidb ";
	$credentials = "user=pacet3_epiuser password=EpiKP#786";//N0m1#987
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		$result = array('result' => FALSE,'mesg' => 'Unable to open database.');
		echo json_encode($result);exit;
	} else {
		$result = array('Success' => 'Opened database successfully');
	}
	//-------------- Database Connection Code Ends ---------------//
	//-------------- Get Data From Android Request ---------------//
	$epidNumber = strtoupper($json->{'epidNo'});
	$specimenResult = $json->{'specimen_result'};
	$queryUpdateSpecimen = "update diseases_surveillance_mob set specieman_result='$specimenResult' where full_epid_no='$epidNumber' ";
	$resultUpdateSpecimen = pg_query($db, $queryUpdateSpecimen);
	if(!$resultUpdateSpecimen){
		$err = pg_last_error($db);
		echo json_encode(array('result'=>FALSE,'mesg'=>$err));
    }else{
		$affectedRows = pg_affected_rows($resultUpdateSpecimen);
		if($affectedRows > 0)
			echo json_encode(array('result'=>TRUE,'mesg' => 'Record Updated'));
		else
			echo json_encode(array('result'=>FALSE,'mesg'=> 'Record not Found!'));
	}
?>