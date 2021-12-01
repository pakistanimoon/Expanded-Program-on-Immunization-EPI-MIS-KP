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
	
	$imeiNumber = $json->{'imei'};
	$facode = $json->{'facode'};
	$checkquery="select count(*) from facilities where facode='{$facode}' and imei='{$imeiNumber}'";
	$resulquery = pg_query($db, $checkquery);
	$rowResult = pg_fetch_row($resulquery);//print_r($rowResult[0]);exit;
	if($rowResult[0] >0){
		$diseasequery="SELECT disease_name as name,disease_short_name as short_name from ids_diseases";
		$resulDiseases = pg_fetch_all(pg_query($db, $diseasequery));
		echo json_encode(array("result"=>true,"data"=>$resulDiseases));
	}else{
		echo json_encode(array("result"=>false,"mesg"=>"Facility against this imei dose not exist!"));
	}
	
	
?>