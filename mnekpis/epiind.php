<?php
ob_start();
session_start();
include("databaseFunctions.php");
$dbf = new DatabaseFunctions;

$ind=isset($_REQUEST['ind'])?$_REQUEST['ind']:'del';
$fmonth=isset($_REQUEST['fmonth'])?$_REQUEST['fmonth']:'';
$distcode=isset($_REQUEST['distcode'])?$_REQUEST['distcode']:'';

		switch($ind){
			case 'imz' : $title="Percentage of Children 12-23 months immunized (Received Measle-II)";
							$query1="select facode, facilityname(facode) as facility, coalesce(round((((coalesce(cri_r25_f18,0)+coalesce(cri_r26_f18,0))/NULLIF(getmonthly_survivinginfants(facode,'facility')::numeric,0))*100),0),0) as imz from fac_mvrf_db where fmonth = '$fmonth' and distcode='$distcode'";
						break;
		        case 'tt2' : $title="Percentage of Pregnant Women received TT2 vaccine";
							$query1="select facode, facilityname(facode) as facility, coalesce(round(((ttri_r9_f2/NULLIF(getmonthly_plwomen_target(facode,'')::numeric,0))*100),0),0) as tt2 from fac_mvrf_db where fmonth = '$fmonth' and distcode='$distcode'";
						break;
		}
		
//echo $query1;
		$result=$dbf->queryDB("psql",$query1,"Forms");

	$strXML = "<chart caption='$title' showFCMenuItem='0'>";

	while($row=$dbf->returnDBarray("psql",$result)){
			$color = "0AA800";	

		$strXML .= "<set label='".$row['facility']."' value='".$row[$ind]."'   color='$color' link='javascript:openmr(\"".$row['facode']."\", \"$fmonth\")'/>";
    }
	// concatenate all XML elements and close chart element to finalize chart XML
	$strXML .= "</chart>";
	header('Content-type: text/xml'); 
	print $strXML;


?>