<?php
class Compliances_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> model('Filter_model');
		$this -> load -> helper('epi_reports_helper');

	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	function HFMVRF($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		//$wc['is_vacc_fac'] = '1';
		unset($wc['year']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		$currYear = date('Y');
		$currMonth = date('m');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=healthFacilityMonthlyCompliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Timeliness","Completeness","Total");
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				if( ! (($year == $currYear) && ($i >= $currMonth)) )
				{
					$mon = sprintf("%02d", $i);
					$date = $year.'-'.$mon.'-'.'05';
					$date = date('Y-m-d',strtotime($date.'next month'));
					$asValueHead=$headNames[$i-1];
					$queryForYearlyData .= "CASE WHEN CAST((select facode  from fac_mvrf_db where fmonth = '$year-$mon' and facode = flcf1.facode) AS INTEGER) > 0 THEN 
											(CASE WHEN CAST((select facode from fac_mvrf_db where fmonth = '$year-$mon' and submitted_date<='$date' and facode = flcf1.facode) AS INTEGER) > 0 THEN 'timely' ELSE 'complete' END)
											ELSE 'notsubmitted' END AS $asValueHead, ";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select count(*) from facilities where distcode='".$data['distcode']."' and hf_type='e') as total$i,";
				}
				$i++;
			}
			$queryForYearlyData .= "(select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode and submitted_date>= '".$year."-02-01' and extract(day from submitted_date)<=5 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode) AS Completeness,";
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			$mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			$mmonnth = $mmonnth[1];
			$queryForYearlyData .= "{$mmonnth} AS total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
   
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			//print_r($result);exit;
			$str = $this->db->last_query();
			//echo $str;exit;
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
						//print_r($result);exit;				  
			foreach ($result as $key => $value) {
				$percentageTotalT = round(($value['timeliness']/$value['total'])*100);
				$percentageTotalC = round(($value['completeness']/$value['total'])*100);
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'].' ='.$percentageTotalT.'%';
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'].' ='.$percentageTotalC.'%';
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$percentageTotalTime = round(($value_arr['timeliness']/$value_arr['total'])*100);
				$percentageTotalComp = round(($value_arr['completeness']/$value_arr['total'])*100);			
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' ='.$percentageTotalTime.'%';
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					
					
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$percentageTimeLastT = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i].' ='.$percentageTimeLastT.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$percentageTimeLastC = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i].' ='.$percentageTimeLastC.'%';
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'].' ='.$percentageTotalComp.'%';
				unset($data['allDataTotal'][$index]['total']);
			}
			//print_r($data['allDataTotal']);exit;
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal'],NULL,'yes');
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			for ($ind = 1; $ind < 13; $ind++) {
				$i=$ind;
				$ind = sprintf("%02d", $ind);
				if(($year == $currYear) && ($ind >= $currMonth)){}else{		
					$headerArray[]=$topHead[$i-1];
					$monthlyPortion .= "(select count(fac.facode)  from facilities fac where fac.distcode = districts.distcode and fac.hf_type='e') AS  due$ind,
										(select count(fac_mvrf_db.facode)  from fac_mvrf_db join facilities fac on fac.facode = fac_mvrf_db.facode where fac_mvrf_db.fmonth = '$year-$ind' and fac_mvrf_db.distcode = districts.distcode ) AS  sub$ind,";
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
					$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				}
			}			
			$monthlyPortion .= "(Select CASE WHEN  count(fac.facode) IS NULL THEN 0 ELSE round((count(fac.facode))::numeric*".count($headerArray).",0) END from facilities fac where fac.distcode = districts.distcode and fac.hf_type='e') as totaldue,
								(Select count(fac_mvrf_db.facode)  from fac_mvrf_db join facilities fac on fac.facode = fac_mvrf_db.facode where fac_mvrf_db.distcode = districts.distcode and fac_mvrf_db.fmonth like '$year-%' ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			$headerArray[]="total";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '') . 'Order by district';
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			
			$data['allData'] = $result -> result_array();
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,$headerArray);
		}
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='Health Facility Monthly Report Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);						
		//print_r($dataReturned);exit;
		return $dataReturned;	
	}		
	function HF_Consumption_Requisition($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		//$wc['is_vacc_fac'] = '1';
		unset($wc['year']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		$currYear = date('Y');
		$currMonth = date('m');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HF_Consumption_Requisition_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Timeliness","Completeness","Total");
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				$mon = sprintf("%02d", $i);
				if(($year == $currYear) && ($i >= $currMonth))
				{
					//
				}
				else
				{	
					$date = $year.'-'.$mon.'-'.'05';
					$asValueHead=$headNames[$i-1];
					$queryForYearlyData .= "CASE WHEN CAST((select facode  from form_b_cr where fmonth = '$year-$mon' and facode = flcf1.facode) AS INTEGER) > 0 THEN 
											(CASE WHEN CAST((select facode from form_b_cr where fmonth = '$year-$mon' and date_submitted<='$date' and facode = flcf1.facode) AS INTEGER) > 0 THEN 'timely' ELSE 'complete' END)
											ELSE 'notsubmitted' END AS $asValueHead, ";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select count(*) from facilities where distcode='".$data['distcode']."' and hf_type='e') as total$i,";
				}
				$i++;
			}
			$queryForYearlyData .= "(select count(facode) from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode and date_submitted>= '".$year."-01-01' and extract(day from date_submitted)<=5 and extract(Month from date_submitted)::integer=substring(fmonth from 7 for 2)::integer) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode) AS Completeness,";
			$fmonth = date('Y-m');
			$mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			$mmonnth = $mmonnth[1];
			$queryForYearlyData .= "{$mmonnth} AS total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";
			
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			//echo $str;exit;
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();

			foreach ($result as $key => $value) {
				$percentageTotalT = round(($value['timeliness']/$value['total'])*100);
				$percentageTotalC = round(($value['completeness']/$value['total'])*100);
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'].' ='.$percentageTotalT.'%';
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'].' ='.$percentageTotalC.'%';
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$percentageTotalTime = round(($value_arr['timeliness']/$value_arr['total'])*100);
				$percentageTotalComp = round(($value_arr['completeness']/$value_arr['total'])*100);			
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' ='.$percentageTotalTime.'%';
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$percentageTimeLastT = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i].' ='.$percentageTimeLastT.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$percentageTimeLastC = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i].' ='.$percentageTimeLastC.'%';
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'].' ='.$percentageTotalComp.'%';
				unset($data['allDataTotal'][$index]['total']);
			}
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal'],NULL,'yes');
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			for ($ind = 1; $ind < 13; $ind++) {
				$i=$ind;
				$ind = sprintf("%02d", $ind);
				if(($year == $currYear) && ($ind >= $currMonth)){}else{	
					$headerArray[]=$topHead[$i-1];
					$monthlyPortion .= "(select count(fac.facode)  from facilities fac where fac.distcode = districts.distcode and fac.hf_type = 'e') AS  due$ind,
										(select count(form_b_cr.facode)  from form_b_cr join facilities fac on fac.facode = form_b_cr.facode where form_b_cr.fmonth = '$year-$ind' and form_b_cr.distcode = districts.distcode ) AS  sub$ind,";
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
					$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				}
			}
			$monthlyPortion .= "(Select CASE WHEN  count(fac.facode) IS NULL THEN 0 ELSE round((count(fac.facode))::numeric*".count($headerArray).",0) END from facilities fac where fac.distcode = districts.distcode and fac.hf_type = 'e') as totaldue,
								(Select count(form_b_cr.facode)  from form_b_cr join facilities fac on fac.facode = form_b_cr.facode where form_b_cr.distcode = districts.distcode and form_b_cr.fmonth like '$year-%' ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			$headerArray[]="total";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,$headerArray);
		}
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='HF Consumption & Requisition Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		$dataReturned['year'] = $data['year'];
		return $dataReturned;
	}
	// Do not delete this commented block.
	/* function Issue_Receipt($data,$title){
		$revisedCondition = array("form_date >=" => $data['datefrom'], "form_date <=" => $data['dateto']);
		$data = array_merge($data,$revisedCondition);
		unset($data['datefrom']);unset($data['dateto']);
		$this -> db -> select("form_date as \"Form Date\",facode as \"FLCF Code\", facilityname(facode) as \"Facility Name\" ");
		$this -> db -> where($data);
		$this -> db -> order_by("form_date desc");
		$result = $this -> db -> get("form_a2_vaccine_main") -> result_array();
		$dataReturned['htmlData'] = showListingReport($result);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['pageTitle'] = "Stock Issue & Receipt Voucher Report";
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		return $dataReturned;
	}
	function Demand_Consumption_Receipt($data,$title){
		echo "here";exit;
	} */
	function Measles_Compliance($data,$title){
		//echo "danish";exit;
		//print_r($data);exit;
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['week']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Measles_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$weeks = lastWeek($data['year'],true);
		//print_r($wc);exit;
		$week = isset($data['week'])?$data['week']:0;
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			if(array_key_exists("facode", $data) && $data['facode'] > 0)
				$wcc = " where facode='{$data['facode']}'";
			elseif(array_key_exists("uncode", $data) && $data['uncode'] > 0)
				$wcc = " where uncode='{$data['uncode']}'";
			elseif(array_key_exists("tcode", $data) && $data['tcode'] > 0)
				$wcc = " where tcode = '{$data['tcode']}'";
			else
				$wcc = " where distcode='{$data['distcode']}'";	
			/*$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=1;$w<=$weeks;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i <= $weeks; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " case_reported('$fweekk',flcf1.facode,'measle_case_investigation') AS $asValueHead, ";
				$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN '0' THEN 0 ELSE 1 END) as total$i,";
			}			
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from measle_case_investigation where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";
			//echo $queryForYearlyData;exit;
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facilityname(facode)');
			$result = $this-> db -> get("facilities flcf1")->result_array();			
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);*/
			$distcode = $data['distcode'];
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$ind = $weeks;
			$complianceTotalF = $week;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(measle_cases)  from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode') AS  due$ind,
									(select count(mes.facode)  from measle_case_investigation mes where mes.fweek = '$fweekk' and mes.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek like '$year-%' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(mes.facode)  from measle_case_investigation mes where mes.fweek like '$year-%' and mes.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			//facode like '$distcode%'
			$query = 'select facode as "Epi Center Code", fac_name as "Epi Center", ' . $outerPortion . ' from (' . $query . ') as a';
			//echo $query;exit;
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			if($week <= 0){
				foreach ($data['allData'] as $key => $value) 
				{
					foreach ($value as $key2 => $value2)
					{
						//$sum = 0;
						//echo $key2;exit;
						if($key2 == 'due'.$ind)
						{
							$data['allData'][$key][$key2] = $sum;
							$sum = 0;
						}
						elseif(substr($key2, 0,3) == 'due')
						{
							$sum += $value2;
						}
					}
				}	
			}				
			//for vertical total of all rows.
		if($week <= 0){
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//print_r($data['allDataTotal']);exit;
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
		}
		else{
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			//echo $queryForTotal;exit;
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			
		}
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then measle_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(mes.facode)  from measle_case_investigation mes where mes.fweek = '$fweekk' and mes.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(mes.facode)  from measle_case_investigation mes where mes.fweek like '$year-%' and mes.distcode = districts.distcode ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode, district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			//echo $query;exit;
			//echo $ind;exit;
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			//print_r($data['allData']);exit;
			$sum=0;
			if($week <= 0){
				foreach ($data['allData'] as $key => $value) 
				{
					foreach ($value as $key2 => $value2)
					{
						
						if($key2 == 'due'.$ind)
						{
							$data['allData'][$key][$key2] = $sum;
							$sum = 0;
						}
						elseif(substr($key2, 0,3) == 'due')
						{
							$sum += $value2;
						}
					}
					
				}	
			}
//print_r($data['allData']);exit;		
			//for vertical total of all rows.
			if($week <= 0){
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			}
			else{
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			//echo $queryForTotal;exit;
			$resultTotal = $this -> db -> query($queryForTotal);
			//print_r($resultTotal);exit;
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);

			}
		}
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'Measles Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);		
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function NNT_Compliance($data,$title){
		//print_r($data);exit;
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';			 
		unset($wc['year']);
		unset($wc['week']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=NNT_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$weeks = lastWeek($data['year'],true);
		$week = isset($data['week'])?$data['week']:0;
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			if(array_key_exists("facode", $data) && $data['facode'] > 0)
				$wcc = " where facode='{$data['facode']}'";
			elseif(array_key_exists("uncode", $data) && $data['uncode'] > 0)
				$wcc = " where uncode='{$data['uncode']}'";
			elseif(array_key_exists("tcode", $data) && $data['tcode'] > 0)
				$wcc = " where tcode = '{$data['tcode']}'";
			else
				$wcc = " where distcode='{$data['distcode']}'";
			$distcode = $data['distcode'];
			/*$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=1;$w<=$weeks;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i <= $weeks; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;				
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " case_reported('$fweekk',flcf1.facode,'nnt_investigation_form') AS $asValueHead, ";
				$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN '0' THEN 0 ELSE 1 END) as total$i,";
			}
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from nnt_investigation_form where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);
		*/
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode' ) AS  due$ind,
									(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek = '$fweekk' and nnt.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek like '$year-%' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek like '$year-%' and nnt.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			/*$query = 'select facode   , fac_name,  ' . $monthlyPortion . '  from facilities ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select facode, fac_name, ' . $outerPortion . ' from (' . $query . ') as a';
			*/
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			$query = 'select facode as "Epi Center Code", fac_name as "Epi Center", ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			foreach ($data['allData'] as $key => $value) 
			{
				foreach ($value as $key2 => $value2)
				{
					if($key2 == 'due'.$ind)
					{
						$data['allData'][$key][$key2] = $sum;
						$sum = 0;
					}
					elseif(substr($key2, 0,3) == 'due')
					{
						$sum += $value2;
					}
				}
			}
			//for vertical total of all rows.
			if($week <= 0){
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			}
			else{
				$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
				$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			}
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then nnt_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek = '$fweekk' and nnt.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek like '$year-%' and nnt.distcode = districts.distcode ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			if($week <= 0){
				foreach ($data['allData'] as $key => $value) 
				{
					foreach ($value as $key2 => $value2)
					{
						if($key2 == 'due'.$ind)
						{
							$data['allData'][$key][$key2] = $sum;
							$sum = 0;
						}
						elseif(substr($key2, 0,3) == 'due')
						{
							$sum += $value2;
						}
					}
				}
			}
			//for vertical total of all rows.
			if($week <= 0){
				$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
				$resultTotal = $this -> db -> query($queryForTotal);
				$data['allDataTotal'] = $resultTotal -> result_array();
				$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			}
			else{
				$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
				$resultTotal = $this -> db -> query($queryForTotal);
				$data['allDataTotal'] = $resultTotal -> result_array();
				$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);

			}
		}
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='NNT Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function AFP_Compliance($data,$title){
		//print_r($data);exit;
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['week']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=AFP_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$weeks = lastWeek($data['year'],true);
		$week = $data['week'];
	//	echo $weeks;exit;
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			if(array_key_exists("facode", $data) && $data['facode'] > 0)
				$wcc = " where facode='{$data['facode']}'";
			elseif(array_key_exists("uncode", $data) && $data['uncode'] > 0)
				$wcc = " where uncode='{$data['uncode']}'";
			elseif(array_key_exists("tcode", $data) && $data['tcode'] > 0)
				$wcc = " where tcode = '{$data['tcode']}'";
			else
				$wcc = " where distcode='{$data['distcode']}'";
			$distcode = $data['distcode'];
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$ind = $weeks;
			$complianceTotalF = $week;
			//$weeks = 1;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode'  ) AS  due$ind,
									(select count(afp.facode)  from afp_case_investigation afp where afp.fweek = '$fweekk' and afp.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			//$ind = 2;
			//echo $ind;exit;
			$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek like '$year-%' and facode = facilities.facode and distcode = '$distcode' ) as totaldue,
								(select count(afp.facode)  from afp_case_investigation afp where afp.fweek like '$year-%' and afp.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			/*$query = 'select facode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';*/
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			//facode like '$distcode%'
			$query = 'select facode as "Epi Center Code", fac_name as "Epi Center", ' . $outerPortion . ' from (' . $query . ') as a';
			//echo $query;exit;
			$result = $this -> db -> query($query);
			
			$data['allData'] = $result -> result_array();
			//print_r($data['allData']);
			$sum = 0;
			foreach ($data['allData'] as $key => $value) 
			{
				foreach ($value as $key2 => $value2)
				{
					if($key2 == 'due'.$ind)
					{
						$data['allData'][$key][$key2] = $sum;
						$sum = 0;
					}
					elseif(substr($key2, 0,3) == 'due')
					{
						$sum += $value2;
					}
				}
			}
			//for vertical total of all rows.
			if($week <= 0){
				$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
				$resultTotal = $this -> db -> query($queryForTotal);
				$data['allDataTotal'] = $resultTotal -> result_array();
				$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			}
			else{
				$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
				$resultTotal = $this -> db -> query($queryForTotal);
				$data['allDataTotal'] = $resultTotal -> result_array();
				$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			}
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = 1; $ind <= $weeks; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then afp_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(afp.facode)  from afp_case_investigation afp where afp.fweek = '$fweekk' and afp.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) as totaldue,
								(select count(afp.facode)  from afp_case_investigation afp where afp.fweek like '$year-%' and afp.distcode = districts.distcode ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			if($week <= 0){
				foreach ($data['allData'] as $key => $value) 
				{
					foreach ($value as $key2 => $value2)
					{
						if($key2 == 'due'.$ind)
						{
							$data['allData'][$key][$key2] = $sum;
							$sum = 0;
						}
						elseif(substr($key2, 0,3) == 'due')
						{
							$sum += $value2;
						}
					}
				}
			}
			//for vertical total of all rows.
			if($week <= 0){
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			}
			else
			{
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);

			}
		}
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='AFP Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	function AEFI_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=AEFI_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$weeks = lastWeek($data['year'],true);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=1;$w<=$weeks;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i <= $weeks; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= "  CASE WHEN CAST((select count(facode)  from aefi_rep where fweek = '$fweekk' and facode = flcf1.facode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS $asValueHead, ";
				$allTotalPortion .= "sum(" . $headNames[$i - 1] . ") as total$i,";
			}
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from aefi_rep where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facilityname(facode)');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			for ($ind = 1; $ind <= $weeks; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then aefi_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek = '$fweekk' and aefi.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum(aefi_cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek like '$year-%' and aefi.distcode = districts.distcode ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			foreach ($data['allData'] as $key => $value) 
			{
				foreach ($value as $key2 => $value2)
				{
					if($key2 == 'due'.$ind)
					{
						$data['allData'][$key][$key2] = $sum;
						$sum = 0;
					}
					elseif(substr($key2, 0,3) == 'due')
					{
						$sum += $value2;
					}
				}
			}
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
		}
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'AEFI Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}
	function Other_Disease_Compliance($data,$title){
		//echo "danish";exit;
		$wc = $data;
		$case_type = $data['case_type'];
		$cases = ($case_type == 'Childhood TB')?'tb_cases':(($case_type == 'Diarrhea')?'diarrhea_cases':(($case_type == 'Diphtheria')?'diphtheria_cases':(($case_type == 'Hepatitis')?'hepatits_cases':(($case_type == 'Meningitis')?'meningitis_cases':(($case_type == 'Pertussis')?'pertusis_cases':(($case_type == 'Pneumonia')?'pneumonia_cases':''))))));
		//echo $cases;exit;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['case_type']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Other_Disease_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
	//	print_r($wc);exit;
		$weeks = lastWeek($data['year'],true);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=1;$w<=$weeks;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i <= $weeks; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " other_case_reported('$fweekk',flcf1.facode,'$case_type') AS $asValueHead, ";
				$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN '0' THEN 0 ELSE 1 END) as total$i,";
			}
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from weekly_vpd where fweek like '$year-%' and case_type='$case_type' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal']);
		}else{
			
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			for ($ind = 1; $ind <= $weeks; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then $cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(other.facode)  from weekly_vpd other where other.fweek = '$fweekk' and case_type = '$case_type' and other.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum($cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(other.facode)  from weekly_vpd other where other.fweek like '$year-%' and case_type = '$case_type' and other.distcode = districts.distcode ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			
		           	$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			   
			$sum = 0;
			foreach ($data['allData'] as $key => $value) 
			{
				foreach ($value as $key2 => $value2)
				{
					if($key2 == 'due'.$ind)
					{
						$data['allData'][$key][$key2] = $sum;
						$sum = 0;
					}
					elseif(substr($key2, 0,3) == 'due')
					{
						$sum += $value2;
					}
				}
			}
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
		} 
		$data['case_type'] = $case_type;
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'Other Disease Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		//echo '<pre>';print_r($dataReturned);exit;
		return $dataReturned;
	}
	function Zero_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		unset($wc['year']);
		unset($wc['week']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Zero_Report_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$weeks = lastWeek($data['year'],true);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=1;$w<=$weeks;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Timeliness";
			$headNames[$w] = "Completeness";
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",districtname(distcode) as \"District\" ,";
			$i = 1;
			for ($i; $i <= $weeks; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;				
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " CASE WHEN CAST((select facode from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek = '$fweekk' and facode = flcf1.facode limit 1) AS INTEGER ) > 0 THEN 'timely' ELSE
					(CASE WHEN CAST((select facode from zero_report where report_submitted = '0' and fweek = '$fweekk' and facode = flcf1.facode limit 1) AS INTEGER ) > 0 THEN 'notsubmitted' ELSE 
					(CASE WHEN CAST((select facode from zero_report where report_submitted = '1' and submitted_date IS NULL and updated_date IS NOT NULL and fweek = '$fweekk' and facode = flcf1.facode limit 1) AS INTEGER ) > 0 THEN 'complete' ELSE 'notsubmitted' END) END) END AS $asValueHead, ";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select get_weekly_fstatus_ds('$year','$weeknumb',distcode)::INTEGER from districts where distcode='".$data['distcode']."') as total$i,";
											 
			}
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek like '$year-%' and facode = flcf1.facode and report_submitted = '1' and getfstatus_ds(fweek, facode) = 'F' and submitted_date IS NOT NULL) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek like '$year-%' and facode = flcf1.facode and report_submitted = '1' and getfstatus_ds(fweek, facode) = 'F') AS Completeness,";
			$queryForYearlyData .= "(select {$weeknumb}) AS Total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";

			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			//echo $str;exit;
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			foreach ($result as $key => $value) {
				$timelinessPercentage = ($value['total']>0)?round(($value['timeliness']/$value['total'])*100):0;
				$completenessPercentage = ($value['total']>0)?round(($value['completeness']/$value['total'])*100):0;
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'].' = '.$timelinessPercentage.'%';
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'].' = '.$completenessPercentage.'%';
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$totalTimelinessPercentage = round(($value_arr['timeliness']/$value_arr['total'])*100);
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' = '.$totalTimelinessPercentage.'%';
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$timely = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i].' = '.$timely.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$complete = round(($value/$value_arr['total'.$i])*100);
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i].' = '.$complete.'%';
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$totalCompletenessPercentage = round(($value_arr['completeness']/$value_arr['total'])*100);
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'].' = '.$totalCompletenessPercentage.'%';;
				unset($data['allDataTotal'][$index]['total']);
			}
			$result1 = getDistComplianceFMVRReportTable($result ,$data['allDataTotal'],NULL, TRUE);
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = ""; 
			//code by moon just to show zero zero instead of counts
			for ($ind = 1; $ind <= $weeks; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "0 AS  \"Timeliness$ind\",
									0 AS  \"Completeness$ind\",
									0 AS  \"Not Submitted$ind\",";
				$allouterPortion .= "0 AS  \"Timeliness$ind\",
									0 AS  \"Completeness$ind\",
									0 AS  \"Not Submitted$ind\",";
			}
			$monthlyPortion .= "0 AS  \"Total Timeliness$ind\",
								0 AS  \"Total Completeness$ind\",
								0 AS  \"Total Not Submitted$ind\"";
			$allouterPortion .= "0 as \"Total Timeliness$ind\",
								 0 as \"Total Completeness$ind\", 
								 0 as \"Total Not Submitted$ind\"";
			$query = "select districts.distcode , districts.district,   $monthlyPortion   from districts   ORDER BY districts.district";
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion;
			$resultTotal = $this -> db -> query($queryForTotal);
			$queryTotal = "";
			$monthlyPortion="";
			$allouterPortion="";
			for ($ind = 1; $ind <= $weeks; $ind++) {
			$ind = sprintf("%02d", $ind);
			$fweekk = $year."-".$ind;
			$q = "select sum(case when getfstatus_ds('$fweekk', facode)='F' then 1 else 0 end) as cnt from facilities where hf_type='e' and is_ds_fac='1'";
			$t_fac = $this->db->query($q)->row_array();
			$t_fac = $t_fac['cnt'];
			$monthlyPortion .= "(select round((count(zero_report.facode)::float//($t_fac))::numeric*100,1) from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek = '$fweekk' ) AS  \"Timeliness$ind\",
								(select round((count(zero_report.facode)::float//($t_fac))::numeric*100,1) from zero_report where report_submitted = '1' and fweek = '$fweekk'  ) AS  \"Completeness$ind\",
								(select round(((($t_fac) - (SELECT count(zero_report.facode) FROM zero_report where fweek = '$fweekk' ) + (SELECT count(zero_report.facode) FROM zero_report where report_submitted = '0' and fweek = '$fweekk' ))::integer//($t_fac))::numeric*100,1) ) AS  \"Not Submitted$ind\",";
			
		}
		$q = "select get_commulative_fstatus_ds(".$year.",".$weeks."::integer,'0') as cnt";
		$t_fac = $this->db->query($q)->row_array();
		$t_fac = $t_fac['cnt'];
		$monthlyPortion .= "(select round((count(facode)::float//(".$t_fac.")::numeric)::numeric*100,1) from zero_report 				where report_submitted = '1' and submitted_date IS NOT NULL and fweek like '$year-%'  ) AS 						\"Total Timeliness$ind\",
							(select round((count(facode)::float//(".$t_fac.")::numeric)::numeric*100,1) from zero_report where report_submitted = '1' and fweek like '$year-%'  ) AS  \"Total Completeness$ind\",
							(select round((( (".$t_fac.")::numeric - (SELECT count(zero_report.facode) FROM zero_report where fweek like '$year-%' ) + (SELECT count(zero_report.facode) FROM zero_report where report_submitted = '0' and fweek like '$year-%' ))::integer//".$t_fac."::numeric)::numeric*100,1) ) AS  \"Total Not Submitted$ind\"";
		$query = "select $monthlyPortion from facilities where facilities.hf_type='e' limit 1";
		$totalResult = $this -> db -> query($query);
		$data['allTotal'] = $totalResult->result_array();
			$result1 = getComplianceReportTable($data['allData'], $data['allTotal'],$weeks,'','','yes');
		}
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='Zero Report Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
} 