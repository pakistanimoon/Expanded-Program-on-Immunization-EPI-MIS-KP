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
		$wc['is_vacc_fac'] = '1';
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
			//$totalNames   = array("Jan"=>'01',"Feb"=>'02',"Mar"=>'03',"Apr"=>'04',"May"=>'05',"Jun"=>'06',"Jul"=>'07',"Aug"=>'08',"Sep"=>'09',"Oct"=>'10',"Nov"=>'11',"Dec"=>'12');
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			for ($i; $i < 13; ) {
				if( ! (($year == $currYear) && ($i >= $currMonth)) )
				{
					$mon = sprintf("%02d", $i);
					$date = $year.'-'.$mon.'-'.'05';
					$date = date('Y-m-d',strtotime($date.'next month'));
					$asValueHead=$headNames[$i-1];
					// and getfstatus_vacc('$year-$mon', flcf1.facode)='F'
					// and getfstatus_vacc('$year-$mon', flcf1.facode)='F'
					$queryForYearlyData .= " CASE WHEN CAST((select facode  from fac_mvrf_db where fmonth = '$year-$mon' and facode = flcf1.facode and getfstatus_vacc('$year-$mon', flcf1.facode)='F') AS INTEGER) > 0 THEN 
						(CASE WHEN CAST((select facode from fac_mvrf_db where fmonth = '$year-$mon' and submitted_date<='$date' and facode = flcf1.facode and getfstatus_vacc('$year-$mon', flcf1.facode)='F') AS INTEGER) > 0 THEN 'timely' ELSE 'complete' END)
					 ELSE 'notsubmitted' END AS $asValueHead, ";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					//get_monthly_fstatus_vacc('$year-$mon',distcode)::INTEGER
					$allTotalPortion .= "(select get_monthly_fstatus_vacc('$year-$mon',distcode)::INTEGER where distcode='".$data['distcode']."') as total$i,";
				}
				$i++;
			}
			//$queryForYearlyData .= " (select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData .= "(select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode and submitted_date>= '".$year."-02-01' and extract(day from submitted_date)<=5 and extract(Month from submitted_date)-1::integer=substring(fmonth from 7 for 2)::integer) AS Timeliness,";
			// and getfstatus_vacc(fmonth, facode) = 'F'
			$queryForYearlyData .= "(select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode and getfstatus_vacc(fmonth, facode) = 'F') AS Completeness,";//|| '/' ||(select count(*) from facilities where facode=flcf1.facode) AS \"Timeliness\", 
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			//get_commulative_fstatus_vacc('$fmonth',flcf1.facode)::INTEGER
			$queryForYearlyData .= "(select get_commulative_fstatus_vacc('$fmonth',flcf1.facode)::INTEGER) AS Total,";
				//(select count(facode) from fac_mvrf_db where fmonth like '$year-%' and facode = flcf1.facode and getfstatus_vacc(fmonth, facode) = 'F')|| '/' ||(select count(*) from facilities where facode=flcf1.facode) AS \"Completeness\"";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
												
			
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			//$this -> db -> group_by('Timeliness, Completeness, flcf1.facode,flcf1.uncode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			//echo $this->db->last_query();;exit;
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			//echo $str."\n       ";exit;
			//echo $queryForTotal."\n       ";exit;
			foreach ($result as $key => $value) {
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'];
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'];
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			/*$sum = 0;
			foreach ($data['allDataTotal'] as $key => $value) {
				foreach ($value as $key2 => $value2) {
					if( ! ($key2 == 'total13'))
						$sum += $value2;
				}
			}*/
			//echo "<pre>";print_r($data['allDataTotal']);exit;
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'];
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i];
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i];
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'];
				unset($data['allDataTotal'][$index]['total']);
			}
			/*foreach ($result as $index => $array) {
				$i=1;
				foreach ($array as $key => $value) {
					unset($result[$index]["total{$i}"]);
					$i++;
				}
			}*/
			//echo "<pre>";print_r($result);exit;
			//$data['allDataTotal'][0]['total13'] = $sum;
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal'],NULL,TRUE);
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
					$monthlyPortion .= "(select count(fac.facode)  from facilities fac where fac.distcode = districts.distcode and getfstatus_vacc('$year-$ind', fac.facode)='F' and fac.hf_type='e' and fac.is_vacc_fac='1' ) AS  due$ind,
										(select count(fac_mvrf_db.facode)  from fac_mvrf_db join facilities fac on fac.facode = fac_mvrf_db.facode where fac_mvrf_db.fmonth = '$year-$ind' and fac_mvrf_db.distcode = districts.distcode ) AS  sub$ind,";
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
					$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				}
			}			
			$monthlyPortion .= "(Select CASE WHEN  count(fac.facode) IS NULL THEN 0 ELSE round((count(fac.facode))::numeric*".count($headerArray).",0) END from facilities fac where fac.distcode = districts.distcode and getfstatus_vacc('$year-$ind', fac.facode)='F' and fac.hf_type='e' and fac.is_vacc_fac='1') as totaldue,
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
		return $dataReturned;	
	}		
	function HF_Consumption_Requisition($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_vacc_fac'] = '1';
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
				if(($year == $currYear) && ($i > $currMonth))
				{
					//
				}
				else
				{	
					$date = $year.'-'.$mon.'-'.'05';
					$asValueHead=$headNames[$i-1];
					$queryForYearlyData .= " CASE WHEN CAST((select facode  from form_b_cr where fmonth = '$year-$mon' and facode = flcf1.facode and getfstatus_vacc('$year-$mon', flcf1.facode)='F') AS INTEGER) > 0 THEN 
						(CASE WHEN CAST((select facode from form_b_cr where fmonth = '$year-$mon' and date_submitted<='$date' and facode = flcf1.facode and getfstatus_vacc('$year-$mon', flcf1.facode)='F') AS INTEGER) > 0 THEN 'timely' ELSE 'complete' END)
					 ELSE 'notsubmitted' END AS $asValueHead, ";
					//$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN 'notsubmitted' THEN 0 ELSE 1 END) as total$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select get_monthly_fstatus_vacc('$year-$mon',distcode)::INTEGER from districts where distcode='".$data['distcode']."') as total$i,";
				}
				$i++;
				/*$mon = sprintf("%02d", $i);
				if(($year == $currYear) && ($i > $currMonth)){}else{	
					$asValueHead=$headNames[$i-1];
					$queryForYearlyData .= " CASE WHEN CAST((select facode  from form_b_cr where fmonth = '$year-$mon' and facode = flcf1.facode and getfstatus_vacc('$year-$mon', flcf1.facode)='F') AS INTEGER) > 0 THEN 1 ELSE 0 END AS $asValueHead, ";
					$allTotalPortion .= "sum(" . $headNames[$i - 1] . ") as total$i,";
				}
				$i++;*/
			}
			/*$asValueHead=$headNames[$i-1];
			$queryForYearlyData .= " (select count(facode)  from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";*/
			$queryForYearlyData .= "(select count(facode) from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode and date_submitted>= '".$year."-01-01' and extract(day from date_submitted)<=5 and extract(Month from date_submitted)::integer=substring(fmonth from 7 for 2)::integer) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from form_b_cr where fmonth like '$year-%' and facode = flcf1.facode and getfstatus_vacc(fmonth, facode) = 'F') AS Completeness,";
			$fmonth = date('Y-m');
			$queryForYearlyData .= "(select get_commulative_fstatus_vacc('$fmonth',flcf1.facode)::INTEGER) AS Total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";
			
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();

			foreach ($result as $key => $value) {
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'];
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'];
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			//print_r($result);exit;
			/*foreach ($data['allDataTotal'] as $key => $value) {
				$data['allDataTotal'][$key]['timeliness'] = $value['timeliness'].'/'.$value['total'];
				$data['allDataTotal'][$key]['completeness'] = $value['completeness'].'/'.$value['total'];
				unset($data['allDataTotal'][$key]['total']);
			}*/
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'];
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i];
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i];
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'];
				unset($data['allDataTotal'][$index]['total']);
			}
			/*$sum = 0;
			foreach ($data['allDataTotal'] as $key => $value) {
				foreach ($value as $key2 => $value2) {
					if( ! ($key2 == 'total13'))
						$sum += $value2;
				}
			}*/
			//echo "<pre>";print_r($data['allDataTotal']);exit;
			//$data['allDataTotal'][0]['total13'] = $sum;
			$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal'],NULL,TRUE);
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			for ($ind = 1; $ind < 13; $ind++) {
				$i=$ind;
				$ind = sprintf("%02d", $ind);
				if(($year == $currYear) && ($ind > $currMonth)){}else{	
					$headerArray[]=$topHead[$i-1];
					$monthlyPortion .= "(select count(fac.facode)  from facilities fac where fac.distcode = districts.distcode and getfstatus_vacc('$year-$ind', fac.facode)='F' and fac.hf_type = 'e' and fac.is_vacc_fac='1') AS  due$ind,
										(select count(form_b_cr.facode)  from form_b_cr join facilities fac on fac.facode = form_b_cr.facode where form_b_cr.fmonth = '$year-$ind' and form_b_cr.distcode = districts.distcode ) AS  sub$ind,";
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
					$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				}
			}
			$monthlyPortion .= "(Select CASE WHEN  count(fac.facode) IS NULL THEN 0 ELSE round((count(fac.facode))::numeric*".count($headerArray).",0) END from facilities fac where fac.distcode = districts.distcode and getfstatus_vacc('$year-$ind', fac.facode)='F' and fac.hf_type = 'e' and fac.is_vacc_fac='1') as totaldue,
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
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
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
				$queryForYearlyData .= " case_reported('$fweekk',flcf1.facode,'measle_case_investigation') AS $asValueHead, ";
				$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN '0' THEN 0 ELSE 1 END) as total$i,";
			}			
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from measle_case_investigation where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
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
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then measle_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(mes.facode)  from measle_case_investigation mes where mes.fweek = '$fweekk' and mes.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(mes.facode)  from measle_case_investigation mes where mes.fweek like '$year-%' and mes.distcode = districts.distcode ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
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
		$dataReturned['pageTitle']	= 'Measles Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);		
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function NNT_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';			 
		unset($wc['year']);
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
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			for ($ind = 1; $ind <= $weeks; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then nnt_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek = '$fweekk' and nnt.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek like '$year-%' and nnt.distcode = districts.distcode ) as totalsub";
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
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='NNT Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function AFP_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
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
				$queryForYearlyData .= " case_reported('$fweekk',flcf1.facode,'afp_case_investigation') AS $asValueHead, ";
				$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN '0' THEN 0 ELSE 1 END) as total$i,";
			}
			$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from afp_case_investigation where fweek like '$year-%' and facode = flcf1.facode) AS $asValueHead ";
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
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then afp_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(afp.facode)  from afp_case_investigation afp where afp.fweek = '$fweekk' and afp.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) as totaldue,
								(select count(afp.facode)  from afp_case_investigation afp where afp.fweek like '$year-%' and afp.distcode = districts.distcode ) as totalsub";
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
				//$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN 'notsubmitted' THEN 0 ELSE 1 END) as total$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select get_weekly_fstatus_ds('$year','$weeknumb',distcode)::INTEGER from districts where distcode='".$data['distcode']."') as total$i,";
											 
			}
			/*$asValueHead=$headNames[$i];
			$queryForYearlyData .= " (select count(facode)  from zero_report where fweek like '$year-%' and report_submitted = '1' and facode = flcf1.facode) AS $asValueHead ";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(total) as total$i ";*/
													
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek like '$year-%' and facode = flcf1.facode and report_submitted = '1' and submitted_date IS NOT NULL) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek like '$year-%' and facode = flcf1.facode and report_submitted = '1' and getfstatus_ds(fweek, facode) = 'F') AS Completeness,";

			$queryForYearlyData .= "(select get_commulative_fstatus_ds('$year','$weeknumb',flcf1.facode)::INTEGER) AS Total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";

			$this -> db -> select ($queryForYearlyData);
			//$this -> db -> where ("distcode",$data['distcode']);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			foreach ($result as $key => $value) {
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'];
				$result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'];
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			/*foreach ($data['allDataTotal'] as $key => $value) {
				$data['allDataTotal'][$key]['timeliness'] = $value['timeliness'].'/'.$value['total'];
				$data['allDataTotal'][$key]['completeness'] = $value['completeness'].'/'.$value['total'];
				unset($data['allDataTotal'][$key]['total']);
			}*/
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'];
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i];
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$i];
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$i]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'];
				unset($data['allDataTotal'][$index]['total']);
			}
			$result1 = getDistComplianceFMVRReportTable($result ,$data['allDataTotal'],NULL, TRUE);
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			/* for ($ind = 1; $ind <= $weeks; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select round((count(facode)::float//inntable.due01)::numeric*100,1) from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek = '$fweekk' and distcode = districts.distcode ) AS  \"Timeliness$ind\",
									(select round((count(facode)::float//inntable.due01)::numeric*100,1) from zero_report where report_submitted = '1' and fweek = '$fweekk' and distcode = districts.distcode ) AS  \"Completeness$ind\",
									(select round(((inntable.due01 - (SELECT count(facode) FROM zero_report where fweek = '$fweekk' and distcode = districts.distcode) + (SELECT count(facode) FROM zero_report where report_submitted = '0' and fweek = '$fweekk' and distcode = districts.distcode))::integer//inntable.due01)::numeric*100,1) ) AS  \"Not Submitted$ind\",";
				$allouterPortion .= "round(sum(\"Timeliness$ind\")/25,1) as \"Total Timeliness$ind\",round(sum(\"Completeness$ind\")/25,1) as \"Total Completeness$ind\", round(sum(\"Not Submitted$ind\")/25,1) as \"Total Not Submitted$ind\",";
			}
			$monthlyPortion .= "(select round((count(facode)::float//(select count(*)::numeric*".$weeks." from facilities where hf_type='e' and distcode = districts.distcode ))::numeric*100,1) from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek like '$year-%' and distcode = districts.distcode ) AS  \"Total Timeliness$ind\",
								(select round((count(facode)::float//(select count(*)::numeric*".$weeks." from facilities where hf_type='e' and distcode = districts.distcode ))::numeric*100,1) from zero_report where report_submitted = '1' and fweek like '$year-%' and distcode = districts.distcode ) AS  \"Total Completeness$ind\",
								(select round(((inntable.due01::numeric*".$weeks." - (SELECT count(facode) FROM zero_report where fweek like '$year-%' and distcode = districts.distcode) + (SELECT count(facode) FROM zero_report where report_submitted = '0' and fweek like '$year-%' and distcode = districts.distcode))::integer//inntable.due01::numeric*".$weeks.")::numeric*100,1) ) AS  \"Total Not Submitted$ind\"";
			$allouterPortion .= "round(sum(\"Total Timeliness$ind\")/25,1) as \"Total Timeliness$ind\",round(sum(\"Total Completeness$ind\")/25,1) as \"Total Completeness$ind\", round(sum(\"Total Not Submitted$ind\")/25,1) as \"Total Not Submitted$ind\""; */
			
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
			//echo $query;exit;
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			
			//for vertical total of all rows.
			//$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$queryForTotal = 'select ' . $allouterPortion;
			$resultTotal = $this -> db -> query($queryForTotal);
			//$data['allDataTotal'] = $resultTotal -> result_array();
			$queryTotal = "";
			$monthlyPortion="";
			$allouterPortion="";
			/* for ($i=1;$i<=$weeks;$i++)
			{
				$i=sprintf("%02d", $i);
				$fweek = $year."-".$i;	
				$queryTotal .= "(select (count(zero_report.facode)/count(facilities.facode))*100 from zero_report join facilities on zero_report.facode=facilities.facode where zero_report.submitted_date is not null and report_submitted='1' and fweek='$fweek') as \"Timeliness01\",(select (count(zero_report.facode)/count(facilities.facode))*100 from zero_report join facilities on zero_report.facode=facilities.facode where fweek='$fweek') as \"Completeness01\",
							(select round((((select count(facode) as cnt from facilities where hf_type='e' ) - (SELECT count(facode) FROM zero_report where fweek = '$fweek') + (SELECT count(facode) FROM zero_report where report_submitted = '0' and fweek = '$fweek' ))::integer//(select count(facode) as cnt from facilities where hf_type='e' ))::numeric*100,1) ) AS \"Not Submitted01\" ,";		
			}
			$queryTotal= rtrim($queryTotal,',');
			$finalQuery = "select $queryTotal";
			//echo $finalQuery;exit;
			$totalResult = $this -> db -> query($finalQuery); */
			for ($ind = 1; $ind <= $weeks; $ind++) {
			$ind = sprintf("%02d", $ind);
			$fweekk = $year."-".$ind;
			$q = "select sum(case when getfstatus_ds('$fweekk', facode)='F' then 1 else 0 end) as cnt from facilities where hf_type='e' and is_ds_fac='1'";
			$t_fac = $this->db->query($q)->row_array();
			$t_fac = $t_fac['cnt'];
			$monthlyPortion .= "(select round((count(zero_report.facode)::float//($t_fac))::numeric*100,1) from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek = '$fweekk' ) AS  \"Timeliness$ind\",
								(select round((count(zero_report.facode)::float//($t_fac))::numeric*100,1) from zero_report where report_submitted = '1' and fweek = '$fweekk'  ) AS  \"Completeness$ind\",
								(select round(((($t_fac) - (SELECT count(zero_report.facode) FROM zero_report where fweek = '$fweekk' ) + (SELECT count(zero_report.facode) FROM zero_report where report_submitted = '0' and fweek = '$fweekk' ))::integer//($t_fac))::numeric*100,1) ) AS  \"Not Submitted$ind\",";
			/* $allouterPortion .= "round(sum(\"Timeliness$ind\")/25,1) as \"Total Timeliness$ind\",round(sum(\"Completeness$ind\")/25,1) as \"Total Completeness$ind\", round(sum(\"Not Submitted$ind\")/25,1) as \"Total Not Submitted$ind\","; */
		}
		$q = "select get_commulative_fstatus_ds(".$year.",".$weeks."::integer,'0') as cnt";
		$t_fac = $this->db->query($q)->row_array();
		$t_fac = $t_fac['cnt'];
		//print_r($t_fac);exit;
		$monthlyPortion .= "(select round((count(facode)::float//(".$t_fac.")::numeric)::numeric*100,1) from zero_report 				where report_submitted = '1' and submitted_date IS NOT NULL and fweek like '$year-%'  ) AS 						\"Total Timeliness$ind\",
							(select round((count(facode)::float//(".$t_fac.")::numeric)::numeric*100,1) from zero_report where report_submitted = '1' and fweek like '$year-%'  ) AS  \"Total Completeness$ind\",
							(select round((( (".$t_fac.")::numeric - (SELECT count(zero_report.facode) FROM zero_report where fweek like '$year-%' ) + (SELECT count(zero_report.facode) FROM zero_report where report_submitted = '0' and fweek like '$year-%' ))::integer//".$t_fac."::numeric)::numeric*100,1) ) AS  \"Total Not Submitted$ind\"";
		/* $allouterPortion .= "round(sum(\"Total Timeliness$ind\")/25,1) as \"Total Timeliness$ind\",round(sum(\"Total Completeness$ind\")/25,1) as \"Total Completeness$ind\", round(sum(\"Total Not Submitted$ind\")/25,1) as \"Total Not Submitted$ind\""; */
		$query = "select $monthlyPortion from facilities where facilities.hf_type='e' limit 1";
		//echo $query;exit;
		$totalResult = $this -> db -> query($query);
		$data['allTotal'] = $totalResult->result_array();
			//print_r($data['allTotal']);exit;
			//print_r($query);exit;
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