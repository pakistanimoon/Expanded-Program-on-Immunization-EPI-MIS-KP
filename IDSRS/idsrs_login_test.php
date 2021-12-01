<?php
 	$data = file_get_contents('php://input');
    $json = json_decode($data);
	$facode = $json->{'facode'};
	$IMEI=$json->{'imei'};
	$pin=$json->{'pin'};
	$pinFacode=substr($facode,2);
	if($pinFacode!=$pin){
		$result = array('result' =>FALSE,'mesg' => 'Please Provide Correct PIN!');
		echo json_encode($result);exit;
	}
	//---------Database Connection Code Start-------------//
	//------------Database Info----------------//
	$host        = "host=216.97.233.45 ";
	$port        = "port=5432 ";
	$dbname      = "dbname=pacet3_epidb ";
	$credentials = "user=pacet3_epiuser password=EpiKP#786";//N0m1#987
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		$result = array('result'=>FALSE,'mesg' => 'Unable to open database.');
		echo json_encode($result);exit;
	} else {
		$result = array('result' => 'Opened database successfully');
	}
	//---------Database Connection Code Ends--------------//
	if(!empty($IMEI)){
		$distcode = substr($facode,0,3);
		//$queryIEMI = "select count(facode) from facilities where facode='{$facode}' and imei='{$IMEI}'";
		$queryIEMI = "select count(facode),epid_code from facilities join districts d on d.distcode=facilities.distcode where facode='{$facode}' and imei='{$IMEI}' group by epid_code";
		$resultIEMI = pg_query($db, $queryIEMI);
		$rowResult = pg_fetch_row($resultIEMI);//print_r($rowResult);exit;
		$queryUcs = "select uncode,un_name from unioncouncil where distcode='{$distcode}'";
		//$getUcs = pg_query($db, $queryUcs);
		//$getUcs = pg_fetch_array($getUcs);
		$getUcs = pg_fetch_all(pg_query($db, $queryUcs));
		if($rowResult[0] > 0){
			$epid_code=$rowResult[1];
			$result = array('result' => TRUE,"epid_code"=>$epid_code,'UCs'=>$getUcs);
		}else{
			$checkfacode = "select count(facode),epid_code from facilities join districts d on d.distcode=facilities.distcode where facode='{$facode}' group by epid_code";
			$checkfacode = pg_query($db, $checkfacode);
			$rowResult = pg_fetch_row($checkfacode);
			if($rowResult[0] > 0){
				$epid_code=$rowResult[1];
				$queryRegister = "update facilities set imei='{$IMEI}',pin='{$pin}' where facode='{$facode}'";
				$queryResult = pg_query($db, $queryRegister);
				if(!$queryResult){
					$err = pg_last_error($db);
					$result = array('result' => FALSE,'mesg'=>$err);
				}else{
					$result= array('result' => TRUE,"epid_code"=>$epid_code,'UCs'=>$getUcs,'mesg'=>'IMEI Register Successfully.');
				}
			}else{
				$result = array('result' => FALSE,'mesg'=> 'SORRY! This Facode does not Exist.');
			}
		}
	}else{
		$result = array('result' => FALSE,'mesg'=> 'SORRY! Provide IMEI.');
	}
	echo json_encode($result);
?>