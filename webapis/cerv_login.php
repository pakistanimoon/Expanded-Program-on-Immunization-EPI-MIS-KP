<?php
	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions; 
	include("mfunctions.php");
	$data = file_get_contents('php://input');
	$json = json_decode($data);
	$username=$json->{'username'};
	$pass=$json->{'password'};
	$imeino=$json->{'imei_no'};
	$action=$json->{'action'};
  	if(authentication($dbf, $username, $pass)){
		updateimei($dbf, $username, $imeino);
		$response = json_encode(loginresponsejson($dbf, $username));
		loginlog($dbf, $username, "Success", $data, $_SERVER['REMOTE_ADDR'], $imeino, "Mobile", "", $response);
		echo $response;
	}else{
 		$response = json_encode(array("success"=>"no"));
		loginlog($dbf, $username, "Failed", $data, $_SERVER['REMOTE_ADDR'], $imeino, "Mobile", "Authentication Closed", $response);
		echo $response;		
	} 
?>
