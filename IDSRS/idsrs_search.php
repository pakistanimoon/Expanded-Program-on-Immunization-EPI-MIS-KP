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
	$epidNumber = $json->{'epidNo'};
	$imeiNumber = $json->{'imei'};
	$querySearchCase = "select name_case,gender,case_age,case_father_name,case_father_nic,case_cell,case_address,case_type,full_epid_no,case_date_onset,case_date_investigation,case_tot_vacc_received,case_date_last_dose_received,submitted_date,specieman_result,case_date_follow,complication_follow,death_follow from diseases_surveillance_mob where imei='$imeiNumber' and full_epid_no = '$epidNumber'";
	$resultSearchCase = pg_query($db, $querySearchCase);
	if(!$resultSearchCase){
		$err = pg_last_error($db);
		echo json_encode(array('result' => FALSE,'mesg'=>$err));
    }else{
		$rowResult = pg_fetch_array($resultSearchCase,null,PGSQL_ASSOC);
		//echo json_encode($rowResult,JSON_FORCE_OBJECT);exit;
		echo json_encode(array('result'=>TRUE,'data'=>array($rowResult)));
	}
?>