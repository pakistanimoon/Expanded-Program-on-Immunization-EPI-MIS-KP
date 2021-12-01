<?php
 	$data = file_get_contents('php://input');
    $json = json_decode($data);
	$IEMI=$json->{'iemi'};
	$pin=$json->{'pin'};
	//---------Database Connection Code Start-------------//
	//------------Database Info----------------//
	$host        = "host=localhost ";
	$port        = "port=5432 ";
	$dbname      = "dbname=epikp ";
	$credentials = "user=epikpuser password=EpiKP#987";
	$db = pg_connect("$host $port $dbname $credentials");
	if(!$db){
		$result = array('Error' => 'Unable to open database.');
		echo json_encode($result);
		exit;
	} else {
		$result = array('Success' => 'Opened database successfully');
	}
	//---------Database Connection Code Ends--------------//
	$queryIEMI = "select exists(select * from techniciandb where iemi_no='$IEMI' and pin_no=$pin)";
	$resultIEMI = pg_query($db, $queryIEMI);
	if(!$resultIEMI){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>'Your Pin is incorrect!'));
		exit;
    }else{
		if($resultIEMI == TRUE){
			$queryRES = "select technicianname,'Khyber Pakhtunkhwa' as t_province, districtname(distcode) as t_district,tehsilname(tcode) as t_tehsil,unname(uncode) as t_unioncouncil, facilityname(facode) as t_facility, getepidcode(distcode) as t_distcode from techniciandb where iemi_no='$IEMI' and pin_no='$pin'";
			$result = pg_query($db, $queryRES);
			if(!$result){
				$err = pg_last_error($db);
				echo json_encode(array('error'=>$err));
				exit;
			}else{
				$rowResult = pg_fetch_row($result);
				$technician_name = $rowResult[0];
				if($technician_name != ''){
					echo json_encode(array(
						'technician_name' => $rowResult[0],
						't_province' => $rowResult[1],
						't_district' => $rowResult[2],
						't_tehsil' => $rowResult[3],
						't_unioncouncil' => $rowResult[4],
						't_facility' => $rowResult[5],
						't_distcode' => $rowResult[6],
						't_year' => date('Y')
					));
					exit;
				}else{
					$result = array('error'=>'No Data Exists against this IMEI Number');
				}	
			}
		}else{
			$result = array('error'=>'There is some error');
		}
    }
	echo json_encode($result);
?>