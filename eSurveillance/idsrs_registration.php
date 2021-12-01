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
	//---------Database Connection Code Ends--------------//
	//-------------- Get Data From Android Request ---------------//
	$imei = $json->{'cImei'};
	$name = $json->{'cName'};
	$fatherName = $json->{'cFatherName'};
	$fatherCnic = $json->{'cFatherCnic'};
	$fatherMobile = $json->{'cFatherMobile'};
	$address = $json->{'cAdress'};
	$gender = $json->{'cGender'};
	$ageMonths = $json->{'cAge'};
	$caseType = $json->{'cCaseType'};
	$dateOnset = $json->{'cDateOnSet'};
	$investigationDate = $json->{'cDateOfInvetigaion'};
	$totalVaccines = $json->{'cTotalVac'};
	$dateLastDose = $json->{'cDateOfLastDose'};
	//$dateLastDose = ($dateLastDose && $dateLastDose!="")?$dateLastDose:"NULL";
	
	$addressDistrict = $json->{'cDistrict'};
	$outCome = $json->{'cOutComes'};
	$specimenCollectionDate = $json->{'cDateSpecimenCol'};
	$specimenCollection = $json->{'cSpecimenCollection'};
	$dateFollowup = $json->{'cDateFollowUp'};
	$specimenResult = $json->{'cSpecimenResult'};
	
	$year = date('Y');
	$todayDate = date("Y-m-d");
	//--------- Code to Get EPI-Week Details from Database Starts Here----------//
	$queryEPIWeekInfo = "select epi_week_numb,date_from,date_to from epi_weeks where year='$year' and date_from <= '$todayDate' and date_to >= '$todayDate'";
	$resultEPIWeekInfo = pg_query($db, $queryEPIWeekInfo);
	if(!$resultEPIWeekInfo){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>$err));exit;
		exit;
    }else{
		$rowResult = pg_fetch_row($resultEPIWeekInfo);
		$epiWeekNumber = $rowResult[0];
		if($epiWeekNumber != ''){
			$epiWeekNumber = $rowResult[0];
			$epiDateFrom = $rowResult[1];
			$epiDateTo = $rowResult[2];
		}else{
			echo json_encode(array('error'=>'No data retured for the EPI Week'));exit;
		}
	}
	//--------- Code to Get EPI-Week Details from Database Ends Here----------//
	$epiWeek = $epiWeekNumber;
	$dateFrom = $epiDateFrom;
	$dateTo = $epiDateTo;
	//--------- Code to Get District Shortcode from Datebase Starts Here ---------//
	$queryTechnicianDetails = "select distcode,tcode,uncode,facode from techniciandb where iemi_no='$imei'";
	$resultTechnicianDetails = pg_query($db, $queryTechnicianDetails);
	if(!$resultTechnicianDetails){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>$err));
		exit;
    }else{
		$rowResult = pg_fetch_row($resultTechnicianDetails);
		$technicianDistrictCode = $rowResult[0];
		$technicianTehsilCode = $rowResult[1];
		$technicianUnCode = $rowResult[2];
		$technicianFacilityCode = $rowResult[3];
		if($technicianDistrictCode!=''){
			$queryDistrictShortCode = "select epid_code from districts where distcode='$technicianDistrictCode'";
			$resultDistrictShortCode = pg_query($db, $queryDistrictShortCode);
			if(!$resultDistrictShortCode){
				$err = pg_last_error($db);
				echo json_encode(array('error'=>$err));exit;
			}else{
				$rowResult = pg_fetch_row($resultDistrictShortCode);
				$districtShortCode = $rowResult[0];
			}
		}else{
			echo json_encode(array('error'=>'No Technician Exists with this IMEI Number!'));exit;
		}
	}
	//--------- Code to Get District Shortcode from Datebase Ends Here ---------//
	$shortCode = $districtShortCode;
	$caseShortCode = $caseType;
	//------------ Code to Get EPID-Number from Datebase Starts Here -----------//
	$queryEPIDNumber = "select max(epid_number) as epi_number from diseases_surveillance_mob where year='$year' AND case_type='$caseType' AND dist_shortcode='$shortCode'";
	$resultEPIDNumber = pg_query($db, $queryEPIDNumber);
	$rowResult = pg_fetch_row($resultEPIDNumber);
	$EpidCode = str_split(sprintf('%04u', ($rowResult[0] + 1)));
	$newCode="";
	foreach($EpidCode as $code){
		$newCode .= $code;
	}
	//------------ Code to Get EPID-Number from Datebase Ends Here -----------//
	$digitEpidNumber = $newCode;
	$fullEpidNumber = pg_escape_string('PAK/KPK/'.$shortCode.'/'.$year.'/'.$caseShortCode.'/'.$digitEpidNumber);
	if($caseType == 'AFP')
		$fullEpidNumber = pg_escape_string('PAK/KPK/'.$shortCode.'/'.$year.'/'.$digitEpidNumber);
	$submittedDate = date('Y-m-d');
	$distcode = $technicianDistrictCode;
	$tcode = $technicianTehsilCode;
	$uncode = $technicianUnCode;
	$facode = $technicianFacilityCode;
	$fweek = $year."-".sprintf("%02d", $epiWeek);
	//--------- Main Query for insertion of data in Database -------// 
	$queryMain = "INSERT INTO diseases_surveillance_mob(imei,year,epi_week,date_from,date_to,name_case,gender,case_age,case_father_name,case_father_nic,case_cell,case_address,case_type,full_epid_no,epid_number,case_date_onset,case_date_investigation,case_tot_vacc_received".(($dateLastDose && $dateLastDose!="")?",case_date_last_dose_received":"").",dist_shortcode,case_shortcode,submitted_date,distcode,tcode,uncode,facode,case_distcode,complication_follow,case_date_specieman,case_type_speceicman,case_date_follow,specieman_result,fweek) 
	             VALUES ('$imei','$year','$epiWeek','$dateFrom','$dateTo','$name','$gender','$ageMonths','$fatherName','$fatherCnic','$fatherMobile','$address','$caseType','$fullEpidNumber','$digitEpidNumber','$dateOnset','$investigationDate','$totalVaccines'".(($dateLastDose && $dateLastDose!="")?",'$dateLastDose'":"").",'$shortCode','$caseType','$submittedDate','$distcode','$tcode','$uncode','$facode','$addressDistrict','$outCome','$specimenCollectionDate','$specimenCollection','$dateFollowup','$specimenResult','$fweek') RETURNING full_epid_no";
	$insertedResult = pg_query($db, $queryMain);
	if(!$insertedResult){
		$err = pg_last_error($db);
		echo json_encode(array('error'=>$err));
		exit;
    }else{
		$rowResult = pg_fetch_row($insertedResult);
		//----------- If Everything goes ok then return newly inserted EPID-Number from database -----------//
		echo json_encode(array('EpidNumber'=>$rowResult[0]));
	}
?>