<?php
 	

	echo json_encode($_FILE);
	echo json_encode($_REQUEST);
	echo json_encode($_POST);
	echo json_encode($_GET);

	$data = file_get_contents('php://input');
    $json = json_decode($data);
	
	
	$json =  (object)['status'=>"yes"];
	echo json_encode($json);
	//$json =  array('status'=>"yes");
	//$json =(object)$json;
	//or
	//echo json_encode($json,JSON_FORCE_OBJECT);
?>