<?php
	header('Content-Type: application/json');
	date_default_timezone_set("Asia/Karachi");
 	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions; 
 	include("mfunctions.php");

 	$data = file_get_contents('php://input');
	$json = json_decode($data);

	$username=$json->{'username'};
	$imei_no=$json->{'imei_no'};
	if(authenticationbyimei($dbf, $username, $imei_no)){
			 
		$response = json_encode(array("success"=>"yes", "data"=>cervchildlist($dbf, $username)));
		echo $response;		
		//	 logit($dbf, "Daily Report", "Time Expired", $data, $uncode, $_SERVER['REMOTE_ADDR'], $imei_no, "Mobile");
	}else{
		echo json_encode(array("success"=>"no"));		
	}  

	
?>