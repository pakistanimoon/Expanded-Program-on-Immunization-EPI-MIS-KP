<?php
	header('Content-Type: application/json');
	date_default_timezone_set("Asia/Karachi");
 	include("databaseFunctions.php");
	$dbf = new DatabaseFunctions; 
 	include("mfunctions.php");

			 
	echo json_encode(cervchildlist1($dbf, '701049001'));
	//echo 

	
?>