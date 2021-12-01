<?php
class Compliances_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');

	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	function HFMVRF($data,$title)
	{
		//print_r($data['monthto']);exit();
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_vacc_fac'] = '1';
		unset($wc['monthfrom']);
		unset($wc['monthto']);
		// unset($wc['year']);
		// unset($data['year']);
		$fmonth1 = $data['monthfrom'];
		$fmonth2 = $data['monthto'];
		$year_month_from = explode("-", $data['monthfrom']);
		$dd_start_year = $start_year = $year_month_from[0]; 
		$start_year1 = $year_month_from[0]; 
		$between_year = $start_year;
		$between_year1 = $start_year;
		$dd_start_month = $start_month = ltrim($year_month_from[1],'0');
		//echo $start_month; exit();
		$year_month_to = explode("-",$data['monthto']);
		$dd_end_year = $end_year = $year_month_to[0];
		$end_year1 = $year_month_to[0];
		//echo $year_month_to[1]; exit();
		$dd_end_month = $end_month = ltrim($year_month_to[1],'0');		
		$year = $start_year;
		$year = ($year>0)?$year:data('Y');
		$currYear = date('Y');
		$currMonth = date('m');
		$monthfrom = $data['monthfrom'];
		$monthto = $data['monthto'];
		$end_monthhs = $end_month;
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HealthFacilityMonthlyCompliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$topHead   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Timeliness","Completeness","Total");
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",unname(uncode) as \"Union Council\" ,";
			$i = 1;
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			// $mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			// $mmonnth = $mmonnth[1];			
			$col=1;
			$cummulativeTotal = "";
			for( $j=$start_year ; $j <= $end_year ; $j++)
			{
				/////// Set_start_monnth ////////
				if ($j == $start_year)
				{
					if($start_year == $end_year)
					{
					 	$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
						//$set_start_month=(13-$start_month)+1;
						$set_start_month=12;
					}
				}
				elseif($j == $end_year)
				{
					$set_start_month=$end_month;
				}
				////////set query by ///////
				if($j == $start_year) // start year
				{
					$topHead = array("Jan-{$start_year}", "Feb-{$start_year}", "Mar-{$start_year}", "Apr-{$start_year}", "May-{$start_year}", "Jun-{$start_year}", "Jul-{$start_year}", "Aug-{$start_year}", "Sep-{$start_year}", "Oct-{$start_year}", "Nov-{$start_year}", "Dec-{$start_year}");
					if(($end_year - $start_year) > 0){
						$end_month = 12;
					}
					for ($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$start_year+1:$start_year;
						//sprintf('%02d',date('m',strtotime('+1 month')));
						if(($start_year == $currYear) && ($ind >= $currMonth))
						{}
						else
						{
							$headerArray[]=$asValueHead=$topHead[$i-1];
							$queryForYearlyData .= "
							(CASE WHEN 
								getfstatus_vacc('$start_year-$mon', facode) = 'F'
								then
									(CASE WHEN
										exists(select 1 from fac_mvrf_db where fmonth = '$start_year-$mon' and facode = flcf1.facode) 
									THEN 
										(CASE WHEN 
											exists(select 1 from fac_mvrf_db where fmonth = '$start_year-$mon' and submitted_date<='$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode) 
										THEN 'timely' 
										ELSE 'complete' END) 
									ELSE 'notsubmitted' END) 
								ELSE 'notfunctional'
							END) AS \"$asValueHead\", ";

							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
							$allTotalPortion .= "(select get_monthly_fstatus_vacc('$start_year-$mon','{$data['distcode']}')) as total$j$i,";
						}
						$col++;
					}						
				}
				else if($j == $end_year) // end year
				{
					$topHead = array("Jan-{$end_year}", "Feb-{$end_year}", "Mar-{$end_year}", "Apr-{$end_year}", "May-{$end_year}", "Jun-{$end_year}", "Jul-{$end_year}", "Aug-{$end_year}", "Sep-{$end_year}", "Oct-{$end_year}", "Nov-{$end_year}", "Dec-{$end_year}");
					for ($ind = 1; $ind <= $end_monthhs ; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$end_year+1:$end_year;
						//sprintf('%02d',date('m',strtotime('+1 month')));
						if(($end_year == $currYear) && ($ind >= $currMonth))
						{ }
						else 
						{
							$headerArray[]=$asValueHead=$topHead[$i-1];
							$queryForYearlyData .= "
							(CASE WHEN 
								getfstatus_vacc('$end_year-$mon', facode) = 'F'
								then
									(CASE WHEN
										exists(select 1 from fac_mvrf_db where fmonth = '$end_year-$mon' and facode = flcf1.facode) 
									THEN 
										(CASE WHEN 
											exists(select 1 from fac_mvrf_db where fmonth = '$end_year-$mon' and submitted_date<='$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode) 
										THEN 'timely' 
										ELSE 'complete' END) 
									ELSE 'notsubmitted' END) 
								ELSE 'notfunctional'
							END) AS \"$asValueHead\", ";

							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
							$allTotalPortion .= "(select get_monthly_fstatus_vacc('$end_year-$mon','{$data['distcode']}')) as total$j$i,";
						}
						$col++;
					}					
				}
				else // between year
				{					
					$between_year++;
					$topHead = array("Jan-{$between_year}", "Feb-{$between_year}", "Mar-{$between_year}", "Apr-{$between_year}", "May-{$between_year}", "Jun-{$between_year}", "Jul-{$between_year}", "Aug-{$between_year}", "Sep-{$between_year}", "Oct-{$between_year}", "Nov-{$between_year}", "Dec-{$between_year}");

					for ($ind = 1; $ind < 13 ; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$between_year+1:$between_year;
						//sprintf('%02d',date('m',strtotime('+1 month')));
						$headerArray[]=$asValueHead=$topHead[$i-1];
						$queryForYearlyData .= "
						(CASE WHEN 
							getfstatus_vacc('$between_year-$mon', facode) = 'F'
							then
								(CASE WHEN
									exists(select 1 from fac_mvrf_db where fmonth = '$between_year-$mon' and facode = flcf1.facode) 
								THEN 
									(CASE WHEN 
										exists(select 1 from fac_mvrf_db where fmonth = '$between_year-$mon' and submitted_date<='$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode) 
									THEN 'timely' 
									ELSE 'complete' END) 
								ELSE 'notsubmitted' END) 
							ELSE 'notfunctional'
						END) AS \"$asValueHead\", ";
						
						$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
						$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
						$allTotalPortion .= "(select get_monthly_fstatus_vacc('$between_year-$mon','{$data['distcode']}')) as total$j$i,";						
						$col++;
					}					
				}
				$mmonnth = ($j==$end_year)?$year_month_to[1]:12;
				//for multiple years cummulative total
				$startm = $start_month;
				if($cummulativeTotal == ""){
					if($j==$start_year){
						$cummulativeTimeliness = " count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and submitted_date>= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from submitted_date)<=10 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer ";
						$cummulativeCompleteness = " count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal = "get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, {$startm})::integer";
					}
					else{
						$cummulativeTimeliness = " count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and submitted_date>= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from submitted_date)<=10 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer ";
						$cummulativeCompleteness = " count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal = "get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, 1)::integer";
					}
				}
				else{
					if($j==$start_year){
						$cummulativeTimeliness .= " + count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and submitted_date>= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from submitted_date)<=10 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer ";
						$cummulativeCompleteness = " + count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal .= " + get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, {$startm})::integer";
					}
					else{
						$cummulativeTimeliness = " + count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and submitted_date>= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from submitted_date)<=10 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer ";
						$cummulativeCompleteness = " + count(facode) from fac_mvrf_db where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal .= " + get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, 1)::integer";
					}
				}
			}
			$queryForYearlyData .= "(select $cummulativeTimeliness ) AS Timeliness,";
			$queryForYearlyData .= "(select $cummulativeCompleteness ) AS Completeness,";
			$queryForYearlyData .= " CASE WHEN $cummulativeTotal = 0 THEN NULL ELSE $cummulativeTotal END AS total,";

			$queryForYearlyData = rtrim($queryForYearlyData,",");
   
			$allTotalPortion .= "sum(Timeliness) as Timeliness, sum(Completeness) as Completeness, sum(Total) as Total ";
			//print_r($wc); exit();
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			//echo 
			$str = $this->db->last_query(); 
			//exit();
			//echo 
			$queryForTotal = 'SELECT ' . $allTotalPortion . ' from (' . $str . ') as b'; //exit();
			
			foreach ($result as $key => $value) {
				$percentageTotalT = ($value['total']>0)?round(($value['timeliness']/$value['total'])*100):0;
				$percentageTotalC = ($value['total']>0)?round(($value['completeness']/$value['total'])*100):0;
				$result[$key]['total timeliness'] = ($value['total']>0)?$value['timeliness'].'/'.$value['total'].' ='.$percentageTotalT.'%':'0%';
				$result[$key]['total completeness'] = ($value['total']>0)?$value['completeness'].'/'.$value['total'].' ='.$percentageTotalC.'%':'0%';
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			$resultTotal = $this -> db -> query($queryForTotal);
			//print_r($this->db->last_query());
			$data['allDataTotal'] = $resultTotal -> result_array();
			//print_r($data['allDataTotal']);
			$percentageTotalComp=0;
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				if($value_arr['timeliness'] > 0 && $value_arr['total'] && $value_arr['completeness'] > 0) {
					$percentageTotalTime = round(($value_arr['timeliness']/$value_arr['total'])*100);
					$percentageTotalComp = round(($value_arr['completeness']/$value_arr['total'])*100);			
					$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' ='.$percentageTotalTime.'%';
				}
				else {
					$data['allDataTotal'][$index]['timeliness'] ='0%';	
				}
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				//print_r($value_arr); exit();
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{	
						$indexpostfix = substr($key, 6);
						if($value_arr['total'.$indexpostfix] > 0){
							$percentageTimeLastT = round(($value/$value_arr['total'.$indexpostfix])*100);
						}
						else{
							$percentageTimeLastT = 0;
						}
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$indexpostfix].' ='.$percentageTimeLastT.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$indexpostfix = substr($key, 8);
						if($value_arr['total'.$indexpostfix] > 0){
							$percentageTimeLastC = round(($value/$value_arr['total'.$indexpostfix])*100);
						}
						else{
							$percentageTimeLastC = 0;
						}
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$indexpostfix].' ='.$percentageTimeLastC.'%';
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$indexpostfix]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				if($value_arr['total'] > 0 && $value_arr['completeness'] > 0) {
					$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'].' ='.$percentageTotalComp.'%';
				}
				else
				{
					$data['allDataTotal'][$index+1]['completeness'] ='0%';	
				}
				unset($data['allDataTotal'][$index]['total']);
			}
			//print_r($data['allDataTotal']);exit();
			//$result1 = getDistComplianceFMVRReportTableFromTo($result,$data['allDataTotal'],NULL,'yes',$fmonth1,$fmonth2);
			$result1 = getDistComplianceFMVRReportTableFromTo($result,$data['allDataTotal'],NULL,'yes',$dd_start_year,$dd_start_month,$dd_end_year,$dd_end_month);
		}
		else
		{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			$mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			$mmonnth = $mmonnth[1];
			///////apply db function logic//////
			$col = 1;			
			for( $j=$start_year ; $j <= $end_year ; $j++)
			{
				/////// Set_start_monnth ////////
				if ($j == $start_year)
				{
					if($start_year == $end_year)
					{
					 	$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
						//$set_start_month=(13-$start_month)+1;
						$set_start_month=12;
					}
				}
				elseif($j == $end_year)
				{
					$set_start_month=$end_month;
				}
				////////set query by ///////
				if($j == $start_year) // start year
				{
					//echo "start year"; exit();
					$topHead = array("jan-{$start_year}", "feb-{$start_year}", "mar-{$start_year}", "apr-{$start_year}", "may-{$start_year}", "jun-{$start_year}", "jul-{$start_year}", "aug-{$start_year}", "sep-{$start_year}", "oct-{$start_year}", "nov-{$start_year}", "dec-{$start_year}");
					//$end_monthhs = 0;					
					if(($end_year - $start_year) > 0){
						$end_month = 12;
					}
					for ($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);//sprintf('%02d',date('m',strtotime('+1 month')));
						//if(($start_year == $currYear) && ($ind >= $currMonth)){}else{
							$headerArray[]=$topHead[$i-1];
							$monthlyPortion .= "(select COALESCE(sum(duem{$i}),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) AS  due$col,
												(select COALESCE(sum(tsubm{$i}),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) AS  timelysub$col,
												(select COALESCE(sum(subm{$i}),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) AS  completesub$col,";
												//print_r($monthlyPortion);exit();
							$outerPortion .= "	due$col, 
												timelysub$col,
												completesub$col as sub$col,
												round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"totaltimely %$col\",
												round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"totalcomplete %$col\",";
							$allouterPortion .= "	sum(due$col) as totalDue$col, 
													sum(sub$col) as totalSub$col,
													round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
													round((sum(sub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						//}
						$col++;
					}	
				}
				else if($j == $end_year) // end year
				{
					//echo "end year"; exit(); 
					//echo $end_month; exit();
					$topHead = array("jan-{$end_year}", "feb-{$end_year}", "mar-{$end_year}", "apr-{$end_year}", "may-{$end_year}", "jun-{$end_year}", "jul-{$end_year}", "aug-{$end_year}", "sep-{$end_year}", "oct-{$end_year}", "nov-{$end_year}", "dec-{$end_year}");
					for ($ind = 1; $ind <= $end_monthhs; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);//sprintf('%02d',date('m',strtotime('+1 month')));
						if(($end_year == $currYear) && ($ind >= $currMonth))
						{

						}
						else
						{
							$headerArray[]=$topHead[$i-1];
							$monthlyPortion .= "COALESCE((select sum(duem{$i}) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode),0) AS  due$col,
												COALESCE((select sum(tsubm{$i}) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode),0) AS  timelysub$col,
												COALESCE((select sum(subm{$i}) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode),0) AS  completesub$col,";
							$outerPortion .= "	due$col,
												timelysub$col,
												completesub$col as sub$col,
												round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"totaltimely %$col\",
												round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"totalcomplete %$col\",";
					
							$allouterPortion .= "	sum(due$col) as totalDue$col, 
													sum(sub$col) as totalSub$col,
													round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
													round((sum(sub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						}
						$col++;
					}
				}
				else // between year
				{
					//echo "between year"; exit();
					$between_year++;
					$topHead = array("jan-{$between_year}", "feb-{$between_year}", "mar-{$between_year}", "apr-{$between_year}", "may-{$between_year}", "jun-{$between_year}", "jul-{$between_year}", "aug-{$between_year}", "sep-{$between_year}", "oct-{$between_year}", "nov-{$between_year}", "dec-{$between_year}");

					for ($ind = 1; $ind < 13 ; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);//sprintf('%02d',date('m',strtotime('+1 month')));
						
						$headerArray[]=$topHead[$i-1];
						$monthlyPortion .= "(select COALESCE(sum(duem{$i}),0) from vaccinationcompliance where year='{$between_year}' and distcode=districts.distcode) AS  due$col,
										(select COALESCE(sum(tsubm{$i}),0) from vaccinationcompliance where year='{$between_year}' and distcode=districts.distcode) AS  timelysub$col,
										(select COALESCE(sum(subm{$i}),0) from vaccinationcompliance where year='{$between_year}' and distcode=districts.distcode) AS  completesub$col,";
						$outerPortion .= "	due$col,
											timelysub$col,
											completesub$col as sub$col,
											round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"totaltimely %$col\",
											round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"totalcomplete %$col\",";
						$allouterPortion .= "	sum(due$col) as totalDue$col, 
												sum(sub$col) as totalSub$col,
												round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
												round((sum(sub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						
						$col++;
					}				
				}
			}
			////////////set condition////////////////////
			////////////set from here///////////////
			$smonthlyPortion='';
			$souterPortion='';
			$sallouterPortion='';
			$emonthlyPortion='';
			$eouterPortion='';
			$eallouterPortion='';
			$coll = 1;
			//$col = 1;
			for( $l=$start_year ; $l <= $end_year ; $l++)
			{
				if ($l == $start_year)
				{
					if($start_year == $end_year)
					{
			 			$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
				 		$set_start_month=12;
					}
				}
				elseif($l == $end_year)
				{					
					$set_start_month=$end_month;
				}
				if($end_year != $start_year)
				{
					$comma=',';
				}
				else
				{
					$comma='';
				}
				if($l == $start_year)
				{
					//echo'start';
					//echo '</br>';
					$curr_year=date("Y");
					$month= date('m', strtotime('first day of previous month'));
					$j=$end_month;
					//print_r($month);exit();
					//$j=12;
					$due="";$sub="";$timely="";
					/* if($year==$curr_year)
						$j=$month; */
					for($i=$start_month;$i<=$end_month;$i++)
					{
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					$monthlyPortion .= "(select COALESCE(sum($due),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) as totaldue$coll,
									(select COALESCE(sum($timely),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) as totaltimelysub$coll,
									(select COALESCE(sum($sub),0) from vaccinationcompliance where year='{$start_year}' and distcode=districts.distcode) as totalcompletesub$coll {$comma}";//add , 1
						//$coll++;
				}
				else if($l == $end_year)
				{
					$curr_year=date("Y");
					$month= date('m', strtotime('first day of previous month'));
					//print_r($curr_year);exit();
					$j=$end_month;
					//$j=12;
					$due="";$sub="";$timely="";
					//$set_start_month
					for($i=1;$i<=$end_monthhs;$i++)
					{
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					$monthlyPortion .= "(select COALESCE(sum($due),0) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode) as totaldue$coll,
								(select COALESCE(sum($timely),0) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode) as totaltimelysub$coll,
								(select COALESCE(sum($sub),0) from vaccinationcompliance where year='{$end_year}' and distcode=districts.distcode) as totalcompletesub$coll";	
				}
				else
				{
					//	echo'mid';			
					$between_year1++;					
					$curr_year=date("Y");
					$month= date('m', strtotime('first day of previous month'));
					//print_r($between_year);exit();
					$j=$end_month;
					//$j=12;
					$due="";$sub="";$timely="";
					for($i=1;$i<=12;$i++)
					{
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					///////// change here /////////////
					$between_year = $end_year - $start_year;
					$between_year = $between_year1;//($start_year+1);
					$monthlyPortion .= "(select COALESCE(sum($due),0) from vaccinationcompliance where year = '$between_year' and distcode=districts.distcode) as totaldue$coll,
						(select COALESCE(sum($timely),0) from vaccinationcompliance where year = '$between_year' and distcode=districts.distcode) as totaltimelysub$coll,
						(select COALESCE(sum($sub),0) from vaccinationcompliance where year = '$between_year' and distcode=districts.distcode) as totalcompletesub$coll,";
				}
				$coll++;
			}
			//echo $end_year1 . ' -> ' . $start_year1;
			$difference = $end_year1-$start_year1;
			//echo $difference; exit();			
			if($difference == 0)
			{
				$totaldue='totaldue1';
				$totalcompletesub='totalcompletesub1';
				$totaltimelysub='totaltimelysub1';
				$totaltimelysubplus='totaltimelysub1';
			}
			else if($difference == 1)
			{
				$totaldue='totaldue1 + totaldue2';
				$totalcompletesub='totalcompletesub1 + totalcompletesub2';
				$totaltimelysub='totaltimelysub1,totaltimelysub2';
				$totaltimelysubplus='totaltimelysub1 + totaltimelysub2';
			}
			else
			{
				$totalduemid="";$totalcompletesubmid="";
				$totaltimelysubmid="";$totaltimelysubplusmid="";
				for($i=1;$i<=$difference+1;$i++)
				{
					$totalduemid.=' totaldue'.$i.' +';
					$totalcompletesubmid.=' totalcompletesub'.$i.' +';
					$totaltimelysubmid.=' totaltimelysub'.$i.' ,';
					$totaltimelysubplusmid.=' totaltimelysub'.$i.' +';
					//$totaltimelysubplusmid.='COALESCE(tsubm'.$i.',0) +';
				}		
				$totalduemid=rtrim($totalduemid,'+');
				$totalcompletesubmid=rtrim($totalcompletesubmid,'+');
				$totaltimelysubmid=rtrim($totaltimelysubmid,',');
				$totaltimelysubplusmid=rtrim($totaltimelysubplusmid,'+');
			
				$totaldue='' .$totalduemid. '';
				$totalcompletesub='' .$totalcompletesubmid. '';
				$totaltimelysub='' .$totaltimelysubmid. '';
				$totaltimelysubplus='' .$totaltimelysubplusmid. '';
			}		
			//exit;
			$outerPortion .= "	({$totaldue}) as due99,
						({$totalcompletesub}) as sub99,
						{$totaltimelysub},
						round((({$totaltimelysubplus})::float//({$totaldue}))::numeric*100,0) || '%' as \"totaltimely%\",
						round((({$totalcompletesub})::float//({$totaldue}))::numeric*100,0) || '%' as \"totalcomplete%\" ";//add , 2
			$allouterPortion .= "	sum(due99) as totalDue99,
							sum(sub99) as totalSub99,
							round((sum({$totaltimelysubplus})::float//sum(due99))::numeric*100,1) as TotalTimelyPerc,
							round((sum(sub99)::float//sum(due99))::numeric*100,1) as TotalCompletePerc";
									
			//////////to here ///////////

			$headerArray[]="total";
			$query = 'select distcode, district,  ' . $monthlyPortion . '  from districts where distcode <> \'9\' order by district'; 
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$this -> db -> select('count(*) as num');
			$this -> db -> where(array('distcode <>'=>'9'));
			//echo $this->db->last_query();exit();
			$provinceCount = $this -> db -> get('districts') -> row();
			for($k=0;$k<$col;$k++)
			{
				for($count=0;$count<$provinceCount->num;$count++)
				{
					unset($data['allData'][$count]['timelysub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['completesub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['totaltimelysub']);
					unset($data['allData'][$count]['totaltimelysub1']);
					unset($data['allData'][$count]['totaltimelysub2']);
					unset($data['allData'][$count]['totaltimelysub3']);
					unset($data['allData'][$count]['totaltimelysub4']);
					unset($data['allData'][$count]['totalcompletesub']);
				}
			}
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,$headerArray);
		}
		//print_r($data);
		$dataReturned["tableData"] = $result1;
		$dataReturned["year"] = $year;
		$dataReturned["monthfrom"] = $monthfrom;
		$dataReturned["monthto"] = $monthto;
		$dataReturned['pageTitle'] ='Period Wise Compliance Report';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;	
	}	
	
	function HF_Consumption_Requisition($data,$title){
		//print_r($data['monthto']);exit();
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_vacc_fac'] = '1';
		unset($wc['monthfrom']);
		unset($wc['monthto']);
		// unset($wc['year']);
		// unset($data['year']);
		$fmonth1 = $data['monthfrom'];
		$fmonth2 = $data['monthto'];
		$year_month_from = explode("-", $data['monthfrom']);
		$dd_start_year = $start_year = $year_month_from[0]; 
		$start_year1 = $year_month_from[0]; 
		$between_year = $start_year;
		$between_year1 = $start_year;
		$dd_start_month = $start_month = ltrim($year_month_from[1],'0');
		//echo $start_month; exit();
		$year_month_to = explode("-",$data['monthto']);
		$dd_end_year = $end_year = $year_month_to[0];
		$end_year1 = $year_month_to[0];
		//echo $year_month_to[1]; exit();
		$dd_end_month = $end_month = ltrim($year_month_to[1],'0');		
		$year = $start_year;
		$year = ($year>0)?$year:data('Y');
		$currYear = date('Y');
		$currMonth = date('m');
		$monthfrom = $data['monthfrom'];
		$monthto = $data['monthto'];
		$end_monthhs = $end_month;

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
		$table = "epi_consumption_master";
		$datcol= "created_date";
		/* if($year > 0 && $year<2019){
			$table = "form_b_cr";
			$datcol= "date_submitted";
		} */
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames   = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Timeliness","Completeness","Total");
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\", unname(uncode) as \"Union Council\" ,";
			$i = 1;
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			$col=1;
			$cummulativeTotal = "";
			for( $j=$start_year ; $j <= $end_year ; $j++)
			{
				/////// Set_start_monnth ////////
				if ($j == $start_year)
				{
					if($start_year == $end_year)
					{
					 	$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
						//$set_start_month=(13-$start_month)+1;
						$set_start_month=12;
					}
				}
				elseif($j == $end_year)
				{
					$set_start_month=$end_month;
				}
				////////set query by ///////
				if($j == $start_year) // start year
				{
					$topHead = array("Jan-{$start_year}", "Feb-{$start_year}", "Mar-{$start_year}", "Apr-{$start_year}", "May-{$start_year}", "Jun-{$start_year}", "Jul-{$start_year}", "Aug-{$start_year}", "Sep-{$start_year}", "Oct-{$start_year}", "Nov-{$start_year}", "Dec-{$start_year}");
					if(($end_year - $start_year) > 0){
						$end_month = 12;
					}
					for ($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$start_year+1:$start_year;

						if(($start_year == $currYear) && ($i >= $currMonth))
						{
							
						}
						else
						{
							$headerArray[]=$asValueHead=$topHead[$i-1];
							//$asValueHead=$headNames[$i-1];
							$queryForYearlyData .= "
							(CASE WHEN 
								getfstatus_vacc('$start_year-$mon', facode) = 'F'
								then
									(CASE WHEN
										exists(select 1 from $table where fmonth = '$start_year-$mon' and facode = flcf1.facode and is_compiled='1') 
									THEN 
										(CASE WHEN 
											exists(select 1 from $table where fmonth = '$start_year-$mon' and $datcol <= '$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode and is_compiled='1') 
										THEN 'timely' 
										ELSE 'complete' END) 
									ELSE 'notsubmitted' END) 
								ELSE 'notfunctional'
							END) AS \"$asValueHead\", ";

							// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $topHead[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$j$i,";
							// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$j$i,";
							// $allTotalPortion .= "(select get_monthly_fstatus_vacc('$start_year-$mon','{$data['distcode']}')) as total$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
							$allTotalPortion .= "(select get_monthly_fstatus_vacc('$start_year-$mon','{$data['distcode']}')) as total$j$i,";
						}
						$col++;
					}
				}
				else if($j == $end_year) // end year
				{
					$topHead = array("Jan-{$end_year}", "Feb-{$end_year}", "Mar-{$end_year}", "Apr-{$end_year}", "May-{$end_year}", "Jun-{$end_year}", "Jul-{$end_year}", "Aug-{$end_year}", "Sep-{$end_year}", "Oct-{$end_year}", "Nov-{$end_year}", "Dec-{$end_year}");
					// if(($end_year - $start_year) > 0){
					// 	$end_month = 12;
					// }
					for ($ind = 1; $ind <= $end_monthhs; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$end_year+1:$end_year;
						
						if(($end_year == $currYear) && ($i >= $currMonth))
						{
							
						}
						else
						{
							$headerArray[]=$asValueHead=$topHead[$i-1];
							//$asValueHead=$headNames[$i-1];
							$queryForYearlyData .= "
							(CASE WHEN 
								getfstatus_vacc('$end_year-$mon', facode) = 'F'
								then
									(CASE WHEN
										exists(select 1 from $table where fmonth = '$end_year-$mon' and facode = flcf1.facode and is_compiled='1') 
									THEN 
										(CASE WHEN 
											exists(select 1 from $table where fmonth = '$end_year-$mon' and $datcol <= '$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode and is_compiled='1') 
										THEN 'timely' 
										ELSE 'complete' END) 
									ELSE 'notsubmitted' END) 
								ELSE 'notfunctional'
							END) AS \"$asValueHead\", ";

							// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $topHead[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$j$i,";
							// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$j$i,";
							// $allTotalPortion .= "(select get_monthly_fstatus_vacc('$start_year-$mon','{$data['distcode']}')) as total$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
							$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
							$allTotalPortion .= "(select get_monthly_fstatus_vacc('$end_year-$mon','{$data['distcode']}')) as total$j$i,";
						}
						$col++;
					}
				}
				else // between year
				{
					$between_year++;
					$topHead = array("Jan-{$between_year}", "Feb-{$between_year}", "Mar-{$between_year}", "Apr-{$between_year}", "May-{$between_year}", "Jun-{$between_year}", "Jul-{$between_year}", "Aug-{$between_year}", "Sep-{$between_year}", "Oct-{$between_year}", "Nov-{$between_year}", "Dec-{$between_year}");
					// if(($end_year - $start_year) > 0){
					// 	$end_month = 12;
					// }
					for ($ind = 1; $ind < 13 ; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$mon = $ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						$submittedYear = ($ind==12)?$between_year+1:$between_year;
						
						$headerArray[]=$asValueHead=$topHead[$i-1];
						//$asValueHead=$headNames[$i-1];
						$queryForYearlyData .= "
						(CASE WHEN 
							getfstatus_vacc('$between_year-$mon', facode) = 'F'
							then
								(CASE WHEN
									exists(select 1 from $table where fmonth = '$between_year-$mon' and facode = flcf1.facode and is_compiled='1') 
								THEN 
									(CASE WHEN 
										exists(select 1 from $table where fmonth = '$between_year-$mon' and $datcol <= '$submittedYear-$submittedDateMonth-10' and facode = flcf1.facode and is_compiled='1') 
									THEN 'timely' 
									ELSE 'complete' END) 
								ELSE 'notsubmitted' END) 
							ELSE 'notfunctional'
						END) AS \"$asValueHead\", ";

						// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $topHead[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$j$i,";
						// $allTotalPortion .= "sum(CASE (" . $topHead[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$j$i,";
						// $allTotalPortion .= "(select get_monthly_fstatus_vacc('$start_year-$mon','{$data['distcode']}')) as total$j$i,";
						$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely') THEN 1 ELSE 0 END) as timely$j$i,";
						$allTotalPortion .= "sum(CASE WHEN (\"" . $topHead[$i - 1] . "\" = 'timely' OR \"" . $topHead[$i - 1] . "\" = 'complete') THEN 1 ELSE 0 END) as complete$j$i,";
						$allTotalPortion .= "(select get_monthly_fstatus_vacc('$between_year-$mon','{$data['distcode']}')) as total$j$i,";
						//}
						$col++;
					}
				}
				$mmonnth = ($j==$end_year)?$year_month_to[1]:12;
				//for multiple years cummulative total
				$startm = $start_month;
				if($cummulativeTotal == ""){
					if($j==$start_year){
						$cummulativeTimeliness = " count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and $datcol >= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from $datcol)<=10 and extract(Month from $datcol - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer and is_compiled='1'";
						$cummulativeCompleteness = " count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal = "get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, {$startm})::integer";
					}
					else{
						$cummulativeTimeliness = " count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and $datcol >= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from $datcol)<=10 and extract(Month from $datcol - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer and is_compiled='1'";
						$cummulativeCompleteness = " count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal = "get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, 1)::integer";
					}
				}
				else{
					if($j==$start_year){
						$cummulativeTimeliness .= " + count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and $datcol >= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from $datcol)<=10 and extract(Month from $datcol - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer and is_compiled='1'";
						$cummulativeCompleteness = " + count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ";
						$cummulativeTotal .= " + get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, {$startm})::integer";
					}
					else{
						$cummulativeTimeliness = " + count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and $datcol >= TO_DATE(substring(fmonth from 1 for 4)||'-02-01','YYYY-MM-DD') and extract(day from $datcol)<=10 and extract(Month from $datcol - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer and is_compiled='1'";
						$cummulativeCompleteness = " + count(facode) from $table where fmonth between '$fmonth1' and '$fmonth2' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and is_compiled='1'";
						$cummulativeTotal .= " + get_commulative_fstatus_vacc1 ('{$j}-{$mmonnth}', flcf1.facode, 1)::integer";
					}
				}
			}

			// $queryForYearlyData .= "(select count(facode) from $table where fmonth like '$year-%' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' and $datcol >= '".$year."-02-01' and extract(day from $datcol)<=10 and extract(Month from $datcol - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer) AS Timeliness,";
			// $queryForYearlyData .= "(select count(facode) from $table where fmonth like '$year-%' and facode = flcf1.facode and getfstatus_vacc(fmonth,facode)='F' ) AS Completeness,";
			// $queryForYearlyData .= " CASE WHEN get_commulative_fstatus_vacc ('{$year}-{$mmonnth}', flcf1.facode)::integer = 0 THEN NULL ELSE get_commulative_fstatus_vacc ('{$year}-{$mmonnth}', flcf1.facode)::integer END AS total,";

			// $fmonth = date('Y-m', strtotime('first day of previous month'));
			// $mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			// $mmonnth = $mmonnth[1];
			
			$queryForYearlyData .= "(select $cummulativeTimeliness ) AS Timeliness,";
			$queryForYearlyData .= "(select $cummulativeCompleteness ) AS Completeness,";
			$queryForYearlyData .= " CASE WHEN $cummulativeTotal = 0 THEN NULL ELSE $cummulativeTotal END AS total,";

			$queryForYearlyData = rtrim($queryForYearlyData,",");

			$allTotalPortion .= "sum(Timeliness) as Timeliness, sum(Completeness) as Completeness, sum(Total) as Total ";
			
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			//echo $str;exit; 
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//print_r($data['allDataTotal']);
			$distcode=$data['distcode'];
			foreach ($result as $key => $value) {
				$percentageTotalT = ($value['total']>0)?round(($value['timeliness']/$value['total'])*100):0;
				$percentageTotalC = ($value['total']>0)?round(($value['completeness']/$value['total'])*100):0;
				$result[$key]['total timeliness'] = ($value['total']>0)?$value['timeliness'].'/'.$value['total'].' ='.$percentageTotalT.'%':'0%';
				$result[$key]['total completeness'] = ($value['total']>0)?$value['completeness'].'/'.$value['total'].' ='.$percentageTotalC.'%':'0%';
				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				if($value_arr['total'] > 0 ){
				$percentageTotalTime = round(($value_arr['timeliness']/$value_arr['total'])*100);
				$percentageTotalComp = round(($value_arr['completeness']/$value_arr['total'])*100);			
				$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' ='.$percentageTotalTime.'%';
				}
				else
				{
					$data['allDataTotal'][$index]['timeliness']=0;
					
				}
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = 1;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{	
						$indexpostfix = substr($key, 6);
						if($value_arr['total'.$indexpostfix] > 0){
							$percentageTimeLastT = round(($value/$value_arr['total'.$indexpostfix])*100);
						}
						else{
							$percentageTimeLastT = 0;
						}
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$indexpostfix].' ='.$percentageTimeLastT.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						$indexpostfix = substr($key, 8);
						if($value_arr['total'.$indexpostfix] > 0){
							$percentageTimeLastC = round(($value/$value_arr['total'.$indexpostfix])*100);
						}
						else{
							$percentageTimeLastC = 0;
						}
						$data['allDataTotal'][$index+1][$key] = $value.'/'.$value_arr['total'.$indexpostfix].' ='.$percentageTimeLastC.'%';
						unset($data['allDataTotal'][$index][$key]);
						unset($data['allDataTotal'][$index]['total'.$indexpostfix]);
						$i++;
					}
				}
				$data['allDataTotal'][$index+1]['timeliness'] = "";
				if($value_arr['total'] > 0) {
					$data['allDataTotal'][$index+1]['completeness'] = $value_arr['completeness'].'/'.$value_arr['total'].' ='.$percentageTotalComp.'%';
				}
				else
				{
					$data['allDataTotal'][$index+1]['completeness']	=0;
				}
				unset($data['allDataTotal'][$index]['total']);
			}
			//$result1 = getDistComplianceFMVRReportTable($result,$data['allDataTotal'],NULL,'yes');
			$result1 = getDistComplianceFMVRReportTableFromTo($result,$data['allDataTotal'],NULL,'yes',$dd_start_year,$dd_start_month,$dd_end_year,$dd_end_month);
		}
		else
		{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			$fmonth = date('Y-m', strtotime('first day of previous month'));
			$mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			$mmonnth = $mmonnth[1];

			$col = 1;
			for( $j=$start_year ; $j <= $end_year ; $j++)
			{
				/////// Set_start_monnth ////////
				if ($j == $start_year)
				{
					if($start_year == $end_year)
					{
					 	$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
						//$set_start_month=(13-$start_month)+1;
						$set_start_month=12;
					}
				}
				elseif($j == $end_year)
				{
					$set_start_month=$end_month;
				}
				////////set query by ///////
				if($j == $start_year) // start year
				{
					//echo "start year"; exit();
					$topHead = array("jan-{$start_year}", "feb-{$start_year}", "mar-{$start_year}", "apr-{$start_year}", "may-{$start_year}", "jun-{$start_year}", "jul-{$start_year}", "aug-{$start_year}", "sep-{$start_year}", "oct-{$start_year}", "nov-{$start_year}", "dec-{$start_year}");
					//$end_monthhs = 0;					
					if(($end_year - $start_year) > 0){
						$end_month = 12;
					}

					for ($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$col = sprintf("%02d", $col);
						$mon = sprintf("%02d", $ind);
						$date = $year.'-'.$mon.'-'.'10';
						$datefrom = $year.'-'.$mon.'-'.'01';
						$date = date('Y-m-d',strtotime($date.'next month'));
						$datefrom = date('Y-m-d',strtotime($datefrom.'next month'));
						$i=$ind;
						//echo $ind;exit;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						//sprintf('%02d',date('m',strtotime('+1 month')));
						//if(($year == $currYear) && ($ind >= $currMonth)){} else{
						$headerArray[]=$topHead[$i-1];
						$monthlyPortion.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$year') as due$col  ,
											(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$year')as timelysub$col,
											(select subm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$year') as completesub$col,";		
											
						$outerPortion .= "	due$col, timelysub$col, completesub$col as sub$col,completesub$col,
											round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"Timely %$col\",
											round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"Completely %$col\",";
				
						$allouterPortion .= "	sum(due$col) as totalDue$col,
												sum(sub$col) as totalSub$col,
												round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
												round((sum(completesub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						//}
						$col++;
					}
				}
				else if($j == $end_year) // end year
				{
					//echo "start year"; exit();
					$topHead = array("jan-{$end_year}", "feb-{$end_year}", "mar-{$end_year}", "apr-{$end_year}", "may-{$end_year}", "jun-{$end_year}", "jul-{$end_year}", "aug-{$end_year}", "sep-{$end_year}", "oct-{$end_year}", "nov-{$end_year}", "dec-{$end_year}");
					//$end_monthhs = 0;
					for ($ind = 1; $ind <= $end_monthhs; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);//
						//sprintf('%02d',date('m',strtotime('+1 month')));
						if(($end_year == $currYear) && ($ind >= $currMonth))
						{} 
						else
						{
							$headerArray[]=$topHead[$i-1];
							$monthlyPortion.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year') as due$col  ,
												(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year')as timelysub$col,
												(select subm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year') as completesub$col,";		
												
							$outerPortion .= "	due$col,timelysub$col,
												completesub$col as sub$col,completesub$col,
												round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"Timely %$col\",
												round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"Completely %$col\",";
					
							$allouterPortion .= "	sum(due$col) as totalDue$col,
													sum(sub$col) as totalSub$col,
													round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
													round((sum(completesub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						}
						$col++;
					}
				}
				else // between year
				{
					//echo "start year"; exit();
					$between_year++;
					$topHead = array("jan-{$between_year}", "feb-{$between_year}", "mar-{$between_year}", "apr-{$between_year}", "may-{$between_year}", "jun-{$between_year}", "jul-{$between_year}", "aug-{$between_year}", "sep-{$between_year}", "oct-{$between_year}", "nov-{$between_year}", "dec-{$between_year}");
					//$end_monthhs = 0;
					for ($ind = 1; $ind < 13; $ind++)
					{
						$col = sprintf("%02d", $col);
						$i=$ind;
						$ind = sprintf("%02d", $ind);
						$submittedDateMonth = ($ind==12)?'01':sprintf('%02d',$ind+1);
						//sprintf('%02d',date('m',strtotime('+1 month')));
	
						$headerArray[]=$topHead[$i-1];
						$monthlyPortion.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year') as due$col  ,
											(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year')as timelysub$col,
											(select subm$i from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year') as completesub$col,";		
											
						$outerPortion .= "	due$col,timelysub$col,
											completesub$col as sub$col,completesub$col,
											round((timelysub$col::float//due$col)::numeric*100,0) || '%' as \"Timely %$col\",
											round((completesub$col::float//due$col)::numeric*100,0) || '%' as \"Completely %$col\",";
				
						$allouterPortion .= "	sum(due$col) as totalDue$col,
												sum(sub$col) as totalSub$col,
												round((sum(timelysub$col)::float//sum(due$col))::numeric*100,1) as TotalTimelyPerc$col,
												round((sum(completesub$col)::float//sum(due$col))::numeric*100,1) as TotalCompletePerc$col,";
						$col++;
					}
				}
			}
			////////////set condition////////////////////
			////////////set from here///////////////
			$smonthlyPortion='';
			$souterPortion='';
			$sallouterPortion='';
			$emonthlyPortion='';
			$eouterPortion='';
			$eallouterPortion='';
			$coll = 1;
			//print_r($abc); exit();
			for($l=$start_year; $l <= $end_year; $l++)
			{
				if ($l == $start_year)
				{
					if($start_year == $end_year)
					{
			 			$set_start_month=($end_month - $start_month )+1;
					}
					else
					{
				 		$set_start_month=12;
					}
				}
				elseif($l == $end_year)
				{					
					$set_start_month=$end_month;
				}
				if($end_year != $start_year)
				{
					$comma=',';
				}
				else
				{
					$comma='';
				}
				if($l == $start_year) // start year
				{
					$curr_year=date("Y");
					$month=date("m",strtotime("-1 month"));
					$j=$end_month;
					//$j=12;
					$due="";$sub="";$timely="";
					// if($year==$curr_year)
					// $j=$month;
					for($i=$start_month;$i<=$end_month;$i++)
					{					
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					///cho '<pre>';print_r(rtrim($subquery,'+'));exit;
					$monthlyPortion.="(select $due from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$start_year') as totaldue$coll, (select $timely from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$start_year')as totaltimelysub$coll, (select $sub from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$start_year') as totalcompletesub$coll {$comma}";
				}			
				else if($l == $end_year) // end year
				{
					$curr_year=date("Y");
					$month= date('m', strtotime('first day of previous month'));
					//print_r($curr_year);exit();
					$j=$end_month;
					//$j=12;
					$due="";$sub="";$timely="";
					//$set_start_month
					for($i=1;$i<=$end_monthhs;$i++)
					{					
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					///cho '<pre>';print_r(rtrim($subquery,'+'));exit;
					$monthlyPortion.="(select $due from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year') as totaldue$coll, (select $timely from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year')as totaltimelysub$coll, (select $sub from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$end_year') as totalcompletesub$coll ";
				}
				else // between year
				{
					$between_year1++;
					$curr_year=date("Y");
					$month= date('m', strtotime('first day of previous month'));
					//print_r($curr_year);exit();
					$j=$end_month;
					//$j=12;
					$due="";$sub="";$timely="";
					//$set_start_month
					for($i=1;$i<=12;$i++)
					{					
						$due.='COALESCE(duem'.$i.',0) +';
						$sub.='COALESCE(subm'.$i.',0) +';
						$timely.='COALESCE(tsubm'.$i.',0) +';
					}
					$due=rtrim($due,'+');
					$sub=rtrim($sub,'+');
					$timely=rtrim($timely,'+');
					///cho '<pre>';print_r(rtrim($subquery,'+'));exit;
					$between_year = $end_year - $start_year;
					$between_year = $between_year1;//($start_year+1);
					$monthlyPortion.="(select $due from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year') as totaldue$coll, (select $timely from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year')as totaltimelysub$coll, (select $sub from consumptioncompliance where consumptioncompliance.distcode= districts.distcode and consumptioncompliance.year='$between_year') as totalcompletesub$coll,";
				}
				$coll++;
			}
			
			$difference = $end_year1-$start_year1;
			//echo $difference; exit();			
			if($difference == 0)
			{
				$totaldue='totaldue1';
				$totalcompletesub='totalcompletesub1';
				$totaltimelysub='totaltimelysub1';
				$totaltimelysubplus='totaltimelysub1';
			}
			else if($difference == 1)
			{
				$totaldue='totaldue1 + totaldue2';
				$totalcompletesub='totalcompletesub1 + totalcompletesub2';
				$totaltimelysub='totaltimelysub1,totaltimelysub2';
				$totaltimelysubplus='totaltimelysub1 + totaltimelysub2';
			}
			else
			{
				$totalduemid="";$totalcompletesubmid="";
				$totaltimelysubmid="";$totaltimelysubplusmid="";
				for($i=1;$i<=$difference+1;$i++)
				{
					$totalduemid.=' totaldue'.$i.' +';
					$totalcompletesubmid.=' totalcompletesub'.$i.' +';
					$totaltimelysubmid.=' totaltimelysub'.$i.' ,';
					$totaltimelysubplusmid.=' totaltimelysub'.$i.' +';
					//$totaltimelysubplusmid.='COALESCE(tsubm'.$i.',0) +';
				}		
				$totalduemid=rtrim($totalduemid,'+');
				$totalcompletesubmid=rtrim($totalcompletesubmid,'+');
				$totaltimelysubmid=rtrim($totaltimelysubmid,',');
				$totaltimelysubplusmid=rtrim($totaltimelysubplusmid,'+');
			
				$totaldue='' .$totalduemid. '';
				$totalcompletesub='' .$totalcompletesubmid. '';
				$totaltimelysub='' .$totaltimelysubmid. '';
				$totaltimelysubplus='' .$totaltimelysubplusmid. '';
			}			
			// print_r($monthlyPortion);exit;			
			// $outerPortion .= "	totaldue as due$ind,totalcompletesub as sub$ind,totaltimelysub,totalcompletesub,
			// 				round((totaltimelysub::float//totaldue)::numeric*100,0) || '%' as \"totaltimely %$ind\",
			// 				round((totalcompletesub::float//totaldue)::numeric*100,0) || '%' as \"totalcomplete %$ind\" ";
		
			// $allouterPortion .= "	sum(due$ind) as totalDue$ind,
			// 					sum(sub$ind) as totalSub$ind,
			// 					round((sum(totaltimelysub)::float//sum(due$ind))::numeric*100,1) as TotalTimelyPerc$ind,
			// 					round((sum(totalcompletesub)::float//sum(due$ind))::numeric*100,1) as TotalCompletePerc$ind";
			$outerPortion .= "	({$totaldue}) as due99,
						({$totalcompletesub}) as sub99,
						{$totaltimelysub},
						round((({$totaltimelysubplus})::float//({$totaldue}))::numeric*100,0) || '%' as \"totaltimely%\",
						round((({$totalcompletesub})::float//({$totaldue}))::numeric*100,0) || '%' as \"totalcomplete%\" ";//add , 2
			$allouterPortion .= "	sum(due99) as totalDue99,
							sum(sub99) as totalSub99,
							round((sum({$totaltimelysubplus})::float//sum(due99))::numeric*100,1) as TotalTimelyPerc,
							round((sum(sub99)::float//sum(due99))::numeric*100,1) as TotalCompletePerc";
		
			$headerArray[]="total";
			//print_r($monthlyPortion);exit;
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '') . 'Order by district';
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			//print_r($this->db->last_query());exit;
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			//print_r($queryForTotal);exit();
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//print_r($data['allDataTotal']);exit;
			$this -> db -> select('count(*) as num');
			$districtsCount = $this -> db -> get('districts') -> row();
			for($k=1; $k<$col; $k++)
			{
				for($count=0; $count<$districtsCount->num; $count++)
				{
					// unset($data['allData'][$count]['timelysub'.sprintf('%02d',$k)]);
					// unset($data['allData'][$count]['completesub'.sprintf('%02d',$k)]);
					// unset($data['allData'][$count]['totaltimelysub']);
					// unset($data['allData'][$count]['totalcompletesub']);
					unset($data['allData'][$count]['timelysub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['completesub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['totaltimelysub']);
					unset($data['allData'][$count]['totaltimelysub1']);
					unset($data['allData'][$count]['totaltimelysub2']);
					unset($data['allData'][$count]['totaltimelysub3']);
					unset($data['allData'][$count]['totaltimelysub4']);
					unset($data['allData'][$count]['totalcompletesub']);
				}
			}
			$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,$headerArray);
		}
		$dataReturned["tableData"]=$result1;
		$dataReturned["year"] = $year;
		$dataReturned["monthfrom"] = $monthfrom;
		$dataReturned["monthto"] = $monthto;
		$dataReturned['pageTitle']='HF Consumption & Requisition Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		//$dataReturned['year'] = $data['year'];
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

	function Coronavirus_Compliance($data,$title){
		//print_r($data); exit();
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['week']);
		unset($data['datefrom']);
		unset($data['dateto']);
		if(!isset($data['year'])){
			redirect('Compliance-Filter/Coronavirus-Compliance');
		}
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Coronavirus_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//print_r($wc); exit();
		unset($wc['export_excel']);
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
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
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(covid_cases)  from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode') AS  due$ind,
									(select count(covid.facode)  from corona_case_investigation_form_db covid where covid.case_type='Covid' AND covid.fweek = '$fweekk' and covid.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(covid_cases) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(covid.facode)  from corona_case_investigation_form_db covid where covid.case_type='Covid' AND covid.fweek between '$fweekFrom' and '$fweekTo' and covid.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			//if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = "SELECT facode, fac_name, $monthlyPortion from facilities $wcc";
			//echo 
			$query = 'SELECT facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			//exit();
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;			
			//echo 
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			//exit();
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				if(isset($week) && $week>0){
					$ind = $week;
				}
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then covid_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(covid.facode)  from corona_case_investigation_form_db covid where covid.case_type='Covid' AND covid.fweek = '$fweekk' and covid.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(covid_cases) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and distcode = districts.distcode ) AS  totaldue,
								(select count(covid.facode)  from corona_case_investigation_form_db covid where covid.case_type='Covid' AND covid.fweek between '$fweekFrom' and '$fweekTo' and covid.distcode = districts.distcode ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode, district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a order by district';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum=0;			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'Coronavirus Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);		
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}

	function Measles_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['week']);
		unset($data['datefrom']);
		unset($data['dateto']);
		if(!isset($data['year'])){
			redirect('Compliance-Filter/Measles-Compliance');
		}
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
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
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
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {								
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode') AS  due$ind,
									(select count(mes.facode) from case_investigation_db mes where mes.case_type='Msl' AND mes.fweek = '$fweekk' and mes.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(mes.facode)  from case_investigation_db mes where mes.case_type='Msl' AND mes.fweek between '$fweekFrom' and '$fweekTo' and mes.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			$query = 'select facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;		
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {				
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then measle_cases else 0 end) from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(mes.facode)  from case_investigation_db mes where mes.case_type='Msl' AND mes.fweek = '$fweekk' and mes.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(measle_cases) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and distcode = districts.distcode ) AS  totaldue,
								(select count(mes.facode)  from case_investigation_db mes where mes.case_type='Msl' AND mes.fweek between '$fweekFrom' and '$fweekTo' and mes.distcode = districts.distcode ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode, district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a order by district';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum=0;			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
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
		unset($wc['week']);
		unset($data['datefrom']);
		unset($data['dateto']);
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
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
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
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {				
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
			$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek between '$fweekFrom' and '$fweekTo' and nnt.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			/*$query = 'select facode   , fac_name,  ' . $monthlyPortion . '  from facilities ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select facode, fac_name, ' . $outerPortion . ' from (' . $query . ') as a';
			*/
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			$query = 'select facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;
			// foreach ($data['allData'] as $key => $value) 
			// {
			// 	foreach ($value as $key2 => $value2)
			// 	{
			// 		if($key2 == 'due'.$ind)
			// 		{
			// 			$data['allData'][$key][$key2] = $sum;
			// 			$sum = 0;
			// 		}
			// 		elseif(substr($key2, 0,3) == 'due')
			// 		{
			// 			$sum += $value2;
			// 		}
			// 	}
			// }
			//for vertical total of all rows.			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
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
			$monthlyPortion .= "(select sum(nnt_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo' and distcode = districts.distcode ) AS  totaldue,
								(select count(nnt.facode)  from nnt_investigation_form nnt where nnt.fweek between '$fweekFrom' and '$fweekTo' and nnt.distcode = districts.distcode ) as totalsub";
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
			// if($week <= 0){
			// 	foreach ($data['allData'] as $key => $value) 
			// 	{
			// 		foreach ($value as $key2 => $value2)
			// 		{
			// 			if($key2 == 'due'.$ind)
			// 			{
			// 				$data['allData'][$key][$key2] = $sum;
			// 				$sum = 0;
			// 			}
			// 			elseif(substr($key2, 0,3) == 'due')
			// 			{
			// 				$sum += $value2;
			// 			}
			// 		}
			// 	}
			// }
			//for vertical total of all rows.			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
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
		unset($data['datefrom']);
		unset($data['dateto']);
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
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
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
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$ind = $weeks;
			//$complianceTotalF = $week;
			//$weeks = 1;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {	
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;

				$monthlyPortion .= "(select sum(afp_cases) from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode'  ) AS  due$ind,
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
			$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo'  and facode = facilities.facode and distcode = '$distcode' ) as totaldue,
								(select count(afp.facode)  from afp_case_investigation afp where afp.fweek between '$fweekFrom' and '$fweekTo'  and afp.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			/*$query = 'select facode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';*/
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			//facode like '$distcode%'
			$query = 'select facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			//echo $query;exit;
			$result = $this -> db -> query($query);
			
			$data['allData'] = $result -> result_array();
			//print_r($data['allData']);
			$sum = 0;			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
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
			$monthlyPortion .= "(select sum(afp_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo'  and distcode = districts.distcode ) as totaldue,
								(select count(afp.facode)  from afp_case_investigation afp where afp.fweek between '$fweekFrom' and '$fweekTo'  and afp.distcode = districts.distcode ) as totalsub";
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
			
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
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
		unset($wc['week']);
		unset($data['datefrom']);
		unset($data['dateto']);
		$year = ($data['year']>0)?$data['year']:date('Y');
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=aefi_Weekly_Compliance.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		unset($wc['export_excel']);
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
		$week = isset($data['week'])?$data['week']:0;
		//echo $weeks;exit;
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
			//$complianceTotalF = $week;
			//$weeks = 1;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(aefi_cases)  from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode'  ) AS  due$ind,
									(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek = '$fweekk' and aefi.facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
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
			$monthlyPortion .= "(select sum(aefi_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) as totaldue,
								(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek between '$fweekFrom' and '$fweekTo' and aefi.facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			/*$query = 'select facode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';*/
			$query = "select facode, fac_name, $monthlyPortion from facilities $wcc";
			//facode like '$distcode%'
			$query = 'select facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			//echo $query;exit;
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			//print_r($data['allData']);
			$sum = 0;
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then aefi_cases else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek = '$fweekk' and aefi.distcode = districts.distcode ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum(aefi_cases)  from zero_report where fweek between '$fweekFrom' and '$fweekTo' and distcode = districts.distcode ) as totaldue,
								(select count(aefi.facode)  from aefi_rep aefi where aefi.fweek between '$fweekFrom' and '$fweekTo' and aefi.distcode = districts.distcode ) as totalsub";
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
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='aefi Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function Other_Disease_Compliance($data,$title){
		$wc = $data;
		$case_type = $data['case_type'];
		$cases = array(
						'AWD/Chol<5' => 'diarrhea_cases',
						'HepB<5' => 'hepatits_cases',
						'CL' => 'cl_cases',
						'Anth' => 'anthrax_cases',
						'VL' => 'vl_cases',
						'SARI' => 'sari_cases',
						'DF' => 'df_cases',
						'DHF' => 'dhf_cases',
						'CCHF' => 'cchf_cases_cases',
						'ChTB' => 'tb_cases',
						'Diph' => 'diphtheria_cases',
						'Men' => 'meningitis_cases',
						'Pert' => 'pertusis_cases',
						'Mal' => 'mal_cases',
						'Pneu' => 'pneumonia_cases',
						'DogBite' => 'dogbite_cases',
						'B Diar' => 'bd_cases',
						'AIDS' => 'aids_cases',
						'Typh' => 'tf_cases',
						'Scab' => 'scabies_cases',
						'AWD/Chol>5' => 'ad_cases',
						'AVHep' => 'avh_cases',
						'Other' => 'undis_cases'						
		);
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';				 
		unset($wc['year']);
		unset($wc['case_type']);
		unset($data['datefrom']);
		unset($data['dateto']);
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
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
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
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$complianceTotalF = $week;
			for ($ind = $from_week; $ind <= $to_week; $ind++) {								
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum({$cases[$case_type]}) from zero_report where fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode') AS  due$ind,
									(select count(facode) from case_investigation_db where case_type='$case_type' AND fweek = '$fweekk' and facode = facilities.facode and distcode = '$distcode' ) AS  sub$ind,";
				if($week > 0)
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\"";
				else
					$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind,";
				if($week > 0)
					break;
			}
			$monthlyPortion .= "(select sum({$cases[$case_type]}) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) AS  totaldue,
								(select count(facode)  from case_investigation_db where case_type='$case_type' AND fweek between '$fweekFrom' and '$fweekTo' and facode = facilities.facode and distcode = '$distcode' ) as totalsub";
			if($week <= 0)
				$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = "select facode  , fac_name,  $monthlyPortion   from facilities $wcc";
			$query = 'select facode as "EPI Center Code", fac_name as "EPI Center", ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();
			$sum = 0;		
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],NULL,NULL,NULL,NULL,$complianceTotalF);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		}
		else{
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then {$cases[$case_type]} else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(other.facode)  from case_investigation_db other where other.fweek = '$fweekk' and case_type = '$case_type' and other.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum({$cases[$case_type]})  from zero_report where fweek between '$fweekFrom' and '$fweekTo' and distcode = districts.distcode ) AS  totaldue,
								(select count(other.facode)  from case_investigation_db other where other.fweek between '$fweekFrom' and '$fweekTo' and case_type = '$case_type' and other.distcode = districts.distcode ) as totalsub";
			$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
			//month wise end
			//main query for flcf wise reporting
			$query = 'select distcode  , district,  ' . $monthlyPortion . '  from districts ' . ((!empty($neWc)) ? ' where ' . implode(" AND ", $neWc) : '');
			$query = 'select distcode, district, ' . $outerPortion . ' from (' . $query . ') as a';
			$result = $this -> db -> query($query);
			$data['allData'] = $result -> result_array();			   
			$sum = 0;
			//for vertical total of all rows.
			$queryForTotal = 'select ' . $allouterPortion . ' from (' . $query . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks);
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week);
		} 
		$dataReturned['case_type'] = $data['case_type'] = $case_type;
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'Other Disease Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function Other_Disease_ComplianceBackup($data,$title){
		$wc = $data;
		$case_type = $data['case_type'];
		$cases = array(
						'AWD/Chol<5' => 'diarrhea_cases',
						'HepB<5' => 'hepatits_cases',
						'CL' => 'cl_cases',
						'Anth' => 'anthrax_cases',
						'VL' => 'vl_cases',
						'SARI' => 'sari_cases',
						'DF' => 'df_cases',
						'DHF' => 'dhf_cases',
						'CCHF' => 'cchf_cases_cases',
						'ChTB' => 'tb_cases',
						'Diph' => 'diphtheria_cases',
						'Men' => 'meningitis_cases',
						'Pert' => 'pertusis_cases',
						'Mal' => 'mal_cases',
						'Pneu' => 'pneumonia_cases',
						'DogBite' => 'dogbite_cases',
						'B Diar' => 'db_cases',
						'AIDS' => 'aids_cases',
						'Typh' => 'tf_cases',
						'Scab' => 'scabies_cases',
						'AWD/Chol>5' => 'ad_cases',
						'AVHep' => 'avh_cases',
						'Other' => 'undis_cases'						
		);
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
			$queryForYearlyData .= " (select count(DISTINCT fweek)  from case_investigation_db where fweek like '$year-%' and case_type='$case_type' and facode = flcf1.facode) AS $asValueHead ";
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
				$monthlyPortion .= "(select sum(case when getfstatus_ds('$fweekk', facode)='F' then {$cases[$case_type]} else 0 end)  from zero_report where fweek = '$fweekk' and distcode = districts.distcode ) AS  due$ind,
									(select count(other.facode)  from case_investigation_db other where other.fweek = '$fweekk' and case_type = '$case_type' and other.distcode = districts.distcode ) AS  sub$ind,";
				$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
				$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
			}
			$monthlyPortion .= "(select sum({$cases[$case_type]})  from zero_report where fweek like '$year-%' and distcode = districts.distcode ) AS  totaldue,
								(select count(other.facode)  from case_investigation_db other where other.fweek like '$year-%' and case_type = '$case_type' and other.distcode = districts.distcode ) as totalsub";
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
		$dataReturned['case_type'] = $data['case_type'] = $case_type;
		$dataReturned["year"] = $year;
		$dataReturned["tableData"]	= $result1;
		$dataReturned['pageTitle']	= 'Other Disease Weekly Compliance';
		$dataReturned['TopInfo'] 	= reportsTopInfo($title, $data);
		$dataReturned['exportIcons']= exportIcons($_REQUEST);
		return $dataReturned;
	}

	function Zero_Compliance($data,$title){
		$wc = $data;
		$wc['hf_type'] = 'e';
		$wc['is_ds_fac'] = '1';
		unset($wc['year']);
		unset($wc['week']);
		unset($wc['from_week']);
		unset($wc['to_week']);
		unset($wc['datefrom']);
		unset($wc['dateto']);
		unset($data['datefrom']);
		unset($data['dateto']);
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
		$data['from_week'] = $from_week = isset($data['from_week'])?$data['from_week']:1;
		$data['to_week'] = $to_week = isset($data['to_week'])?$data['to_week']:lastWeek($data['year'],true);
		$fweekFrom = $year.'-'.$from_week = sprintf("%02d", $from_week);
		$fweekTo = $year.'-'.$to_week = sprintf("%02d", $to_week);
		//$weeks = lastWeek($data['year'],true);
		$week = isset($data['week'])?$data['week']:0;
		$totalWeeks = ($to_week - $from_week) + 1;
		if(array_key_exists("distcode", $data) && $data['distcode'] > 0){
			$allTotalPortion="'' as tot,";
			//case when district selected or deo logged in
			$headNames = array();
			for($w=$from_week;$w<=$to_week;$w++){
				$headNames[$w-1] = "Week".sprintf("%02d", $w);
			}
			$headNames[$w] = "Timeliness";
			$headNames[$w] = "Completeness";
			$headNames[$w] = "Total";
			$queryForYearlyData="facode as \"Facode\", facilityname(facode) as \"Facility\",districtname(distcode) as \"District\" ,";
			$i = $from_week;			
			for ($i; $i <= $to_week; $i++) {
				$weeknumb = sprintf("%02d", $i);
				$fweekk = $year."-".$weeknumb;				
				$asValueHead=$headNames[$i-1];
				$queryForYearlyData .= " 
					CASE WHEN CAST((select facode from zero_report where report_submitted = '1' and submitted_date IS NOT NULL and fweek = '$fweekk' and facode = flcf1.facode and getfstatus_ds('$fweekk',flcf1.facode)='F' limit 1) AS INTEGER ) > 0 THEN 'timely' ELSE
					(CASE WHEN CAST((select facode from zero_report where report_submitted = '0' and fweek = '$fweekk' and facode = flcf1.facode and getfstatus_ds('$fweekk',flcf1.facode)='F' limit 1) AS INTEGER ) > 0 THEN 'notsubmitted' ELSE 
					(CASE WHEN CAST((select facode from zero_report where report_submitted = '1' and submitted_date IS NULL and updated_date IS NOT NULL and fweek = '$fweekk' and facode = flcf1.facode and getfstatus_ds('$fweekk',flcf1.facode)='F' limit 1) AS INTEGER ) > 0 THEN 'complete' ELSE 'notsubmitted' END) END) END AS $asValueHead, ";
					
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE (CASE (" . $headNames[$i - 1] . ") WHEN ('complete') THEN 0 ELSE 1 END) END) as timely$i,";
					$allTotalPortion .= "sum(CASE (" . $headNames[$i - 1] . ") WHEN ('notsubmitted') THEN 0 ELSE 1 END) as complete$i,";
					$allTotalPortion .= "(select get_weekly_fstatus_ds('$year','$weeknumb',distcode)::INTEGER from districts where distcode='".$data['distcode']."') as total$i,";
			}
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = flcf1.facode and report_submitted = '1' and getfstatus_ds(fweek, facode) = 'F' and submitted_date IS NOT NULL) AS Timeliness,";
			$queryForYearlyData .= "(select count(facode) from zero_report where fweek between '$fweekFrom' and '$fweekTo' and facode = flcf1.facode and report_submitted = '1' and getfstatus_ds(fweek, facode) = 'F') AS Completeness,";
			$queryForYearlyData .= "(select get_commulative_fstatus_ds1('$year','$to_week',flcf1.facode,$from_week )::INTEGER) AS Total,";
			$queryForYearlyData = rtrim($queryForYearlyData,",");
			$allTotalPortion .= "sum(Timeliness) as Timeliness,sum(Completeness) as Completeness,sum(Total) as Total ";
			//echo $queryForYearlyData; exit();
			$this -> db -> select ($queryForYearlyData);
			$this -> db -> where ($wc);
			$this -> db -> order_by('facode');
			$result = $this-> db -> get("facilities flcf1")->result_array();
			$str = $this->db->last_query();
			//echo $str; exit();
			$queryForTotal = 'select ' . $allTotalPortion . ' from (' . $str . ') as b';
			$resultTotal = $this -> db -> query($queryForTotal);
			$data['allDataTotal'] = $resultTotal -> result_array();
			foreach ($result as $key => $value) {
				// $timelinessPercentage = ($value['total']>0)?round(($value['timeliness']/$value['total'])*100):0;
				// $completenessPercentage = ($value['total']>0)?round(($value['completeness']/$value['total'])*100):0;
				// $result[$key]['total timeliness'] = $value['timeliness'].'/'.$value['total'].' = '.$timelinessPercentage.'%';
				// $result[$key]['total completeness'] = $value['completeness'].'/'.$value['total'].' = '.$completenessPercentage.'%';

				$timelinessPercentage = ($value['total']>0)?round(($value['timeliness']/$totalWeeks)*100):0;
				$completenessPercentage = ($value['total']>0)?round(($value['completeness']/$totalWeeks)*100):0;
				$result[$key]['total timeliness'] = $value['timeliness'].'/'.$totalWeeks.' = '.$timelinessPercentage.'%';
				$result[$key]['total completeness'] = $value['completeness'].'/'.$totalWeeks.' = '.$completenessPercentage.'%';

				unset($result[$key]['timeliness']);
				unset($result[$key]['completeness']);
				unset($result[$key]['total']);
			}
			foreach ($data['allDataTotal'] as $index => $value_arr) {
				// $totalTimelinessPercentage = round(($value_arr['timeliness']/$value_arr['total'])*100);
				// $data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' = '.$totalTimelinessPercentage.'%';
				if($value_arr['timeliness'] > 0 && $value_arr['total'] && $value_arr['completeness'] > 0) {
					$percentageTotalTime = round(($value_arr['timeliness']/$value_arr['total'])*100);
					$percentageTotalComp = round(($value_arr['completeness']/$value_arr['total'])*100);			
					$data['allDataTotal'][$index]['timeliness'] = $value_arr['timeliness'].'/'.$value_arr['total'].' ='.$percentageTotalTime.'%';
				}
				else {
					$data['allDataTotal'][$index]['timeliness'] ='0%';	
				}
				
				$data['allDataTotal'][$index]['completeness'] = "";
				$data['allDataTotal'][$index+1]['tot'] = "";
				$i = $from_week;
				foreach ($value_arr as $key => $value) 
				{
					if(substr($key, 0, 6) == 'timely' AND $key != 'timeliness' )
					{	
						if($value_arr['total'.$i] > 0){
							$timely = round(($value/$value_arr['total'.$i])*100);
						}
						else{
							$timely = 0;
						}
						$data['allDataTotal'][$index][$key] = $value.'/'.$value_arr['total'.$i].' = '.$timely.'%';
					}
					if(substr($key, 0, 8) == 'complete' AND $key != 'completeness' )
					{
						if($value_arr['total'.$i] > 0){
							$complete = round(($value/$value_arr['total'.$i])*100);
						}
						else{
							$complete = 0;
						}
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
			//echo 	$this->db->last_query();exit;
			$result1 = getDistComplianceFMVRReportTable($result ,$data['allDataTotal'],NULL, TRUE);
		}
		else{
			//echo "as";exit;
			$monthlyPortion = "";
			$outerPortion = "";
			$allouterPortion = "";
			//$topHead = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
			/* $fmonth = date('Y-m', strtotime('first day of previous month'));
			$mmonnth = ($year==date('Y'))?explode("-",$fmonth):array('1'=>12);
			$mmonnth = $mmonnth[1]; */
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				//$i=$ind
				$fweekk = $year."-".$ind;
				//$headerArray[]=$topHead[$i-1];
				$monthlyPortion.="
					(select duewk$ind  from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year') as due$ind ,
					(select tsubwk$ind from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year')as timelysub$ind,
					(select subwk$ind  from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year') as completesub$ind,";		
									
				$outerPortion .= "
					due$ind,timelysub$ind,completesub$ind as sub$ind,completesub$ind,
					round((timelysub$ind::float//due$ind)::numeric*100,0) || '%' as \"Timely %$ind\",
					round((completesub$ind::float//due$ind)::numeric*100,0) || '%' as \"Completely %$ind\",round((due$ind-completesub$ind::float//due$ind)::numeric*100,0) || '%' as \"Not Submitted %$ind\",";
		
				$allouterPortion .= "
					sum(due$ind) as totalDue$ind,
					sum(sub$ind) as totalSub$ind,
					round((sum(timelysub$ind)::float//sum(due$ind))::numeric*100,1) as TimelyPerc$ind,
					round((sum(completesub$ind)::float//sum(due$ind))::numeric*100,1) as CompletePerc$ind,round((sum(due$ind)-sum(completesub$ind)::float//sum(due$ind))::numeric*100,1) as NotSubmittedPerc$ind,";						
			}
			//}
			
			$due="";$sub="";$timely="";
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$ind = sprintf("%02d", $ind);
				$fweekk = $year."-".$ind;
				$due.='COALESCE(duewk'.$ind.',0) +';
				$sub.='COALESCE(subwk'.$ind.',0) +';
				$timely.='COALESCE(tsubwk'.$ind.',0) +';
			}
			$due=rtrim($due,'+');
			$sub=rtrim($sub,'+');
			$timely=rtrim($timely,'+');
			$monthlyPortion.="
				(select $due  from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year'  ) as totaldue ,
				(select $timely  from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year')as totaltimelysub,
				(select $sub  from zeroreportcompliance where zeroreportcompliance.distcode= districts.distcode and zeroreportcompliance.year='$year') as totalcompletesub";				
			$outerPortion .= "	
				totaldue as due$ind,totalcompletesub as sub$ind,totaltimelysub,totalcompletesub, 
				round((totaltimelysub::float//totaldue)::numeric*100,0) || '%' as \"totaltimely %$ind\",
				round((totalcompletesub::float//totaldue)::numeric*100,0) || '%' as \"totalcomplete %$ind\",round((totaldue-totalcompletesub::float//totaldue)::numeric*100,0) || '%' as \"totalnotsubmitted %$ind\"  ";
			
			$allouterPortion .= "
				sum(due$ind) as totalDue$ind,
				sum(sub$ind) as totalSub$ind,
				round((sum(totaltimelysub)::float//sum(due$ind))::numeric*100,1) as TotalTimelyPerc$ind,
				round((sum(totalcompletesub)::float//sum(due$ind))::numeric*100,1) as TotalCompletePerc$ind,round((sum(due$ind)-sum(totalcompletesub)::float//sum(due$ind))::numeric*100,1) as TotalnotsubmittedPerc$ind";
				
			//$headerArray[]="total";
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
			$this -> db -> select('count(*) as num');
			$districtsCount = $this -> db -> get('districts') -> row();
			for($k=$from_week;$k<=$to_week;$k++){
				for($count=0;$count<$districtsCount->num;$count++){
					unset($data['allData'][$count]['timelysub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['completesub'.sprintf('%02d',$k)]);
					unset($data['allData'][$count]['totaltimelysub']);
					unset($data['allData'][$count]['totalcompletesub']);
				}
			}
										 
			$this -> db -> select('count(*) as num');
			$districtsCount = $this -> db -> get('districts') -> row();
			//print_r($data);exit;
			//}
			//$result1 = getComplianceReportTable($data['allData'], $data['allDataTotal'],$weeks,'','',null,null,'zero');
			$result1 = getComplianceReportTableForDSCompliance($data['allData'], $data['allDataTotal'],$from_week, $to_week,NULL,NULL,NULL,NULL,'zero');
		}
		$dataReturned["year"] = $year;
		$dataReturned["from_week"] = $from_week;
		$dataReturned["to_week"] = $to_week;
		$dataReturned["tableData"]=$result1;
		$dataReturned['pageTitle']='Zero Report Weekly Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons']=exportIcons($_REQUEST);
		return $dataReturned;
	}
	
	function Response_Compliance($data,$title){
		
		print_r($data);
		print_r($title);exit;
	}	
	function MSLResponse_Compliance($data,$title)
	{
		
		/* print_r($data);
		print_r($title); */
		
		$procode=$this->session->Province;
		//$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
		//print $wc; exit;
		$query = "select districtname(distcode) as District, date_of_activity as \"Date of Actvity\", unname(uncode) as \"Union Council\", villagename(vcode) as Village, COALESCE(reported_case_base_surveillance,0) as \"Reported through case based surveillance\",  active_search_case as \"Active search Cases\", epi_linked_case as \"Epi linked Cases\",
		sum(case when vaccines='BCG' then total_m_f else 0 end) as BCG, 
		sum(case when vaccines='OPV 0' then total_m_f else 0 end) as \"OPV 0\", 
		sum(case when vaccines='PCV 10' then total_m_f else 0 end) as \"PCV 10\", 
		sum(case when vaccines='Penta 1' then total_m_f else 0 end) as \"Penta 1\", 
		sum(case when vaccines='Penta 2' then total_m_f else 0 end) as \"Penta 2\", 
		sum(case when vaccines='Penta 3' then total_m_f else 0 end) as \"Penta 3\", 
		sum(case when vaccines='IPV' then total_m_f else 0 end) as IPV, 
		sum(case when vaccines='Measles I' then total_m_f else 0 end) as \"Measles I\", 
		sum(case when vaccines='Measles II' then total_m_f else 0 end) as \"Measles II\", 
		sum(case when vaccines='Msl Booster Dose' then total_m_f else 0 end) as \"Measles Booster Dose\", age_group_from as \"Age Group Form\", age_group_to as \"Age Group To\", blood_speciment_collected as \"No. of blood samples collected\", oral_swabs_collected as \"No. of Throat/ Oral Swabs Collected\", follow_up_visit as \"Folow up Visit\" from case_response_tbl where $wc
		group by  distcode, date_of_activity, uncode, vcode, reported_case_base_surveillance, active_search_case, epi_linked_case, age_group_from,blood_speciment_collected, age_group_to, oral_swabs_collected, follow_up_visit 
		order by distcode, date_of_activity " ;
		$result = $this -> db -> query($query);
		$dataReturned['allData'] = $result -> result_array();
		//print_r($data['allData']);exit;
		//$dataReturned["year"] = $data['year'];
		$dataReturned['pageTitle']='Measles Response Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//print_r($dataReturned); exit;
		return $dataReturned;
	}

function DeptheriaResponse_Compliance($data,$title)
	{
		
		/* print_r($data);
		print_r($title); */
		
		$procode=$this->session->Province;
		//$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
		//print $wc; exit;
		$query = "select districtname(distcode) as District, date_of_activity as \"Date of Actvity\", unname(uncode) as \"Union Council\", villagename(vcode) as \"Village\", reported_case_base_surveillance as \"Reported through case based surveillance\",  active_search_case as \"Active search Cases\", epi_linked_case as \"Epi linked Cases\",
		sum(case when vaccines='Penta 1' then total_m_f else 0 end) as \"Penta 1\", 
		sum(case when vaccines='Penta 2' then total_m_f else 0 end) as \"Penta 2\", 
		sum(case when vaccines='Penta 3' then total_m_f else 0 end) as \"Penta 3\", 
		sum(case when vaccines='TD/DtaP/Dt' then total_m_f else 0 end) as \"TD/DtaP/Dt\", 
		sum(case when vaccines='Penta Booster Dose' then total_m_f else 0 end) as \"Penta Booster Dose\", age_group_from as \"Age Group Form (Months)\", age_group_to as \"Age Group To (Months)\", oral_swabs_collected as \"No. of Throat Swabs Collected\", follow_up_visit as \"Folow up Visit\" from case_response_tbl where $wc
		group by  distcode, date_of_activity, uncode, vcode, reported_case_base_surveillance, active_search_case, epi_linked_case, age_group_from, age_group_to,  oral_swabs_collected, follow_up_visit order by distcode, date_of_activity" ;
		$result = $this -> db -> query($query);
		$dataReturned['allData'] = $result -> result_array();
		//print_r($dataReturned['allData']);exit;
		//$dataReturned["year"] = $data['year'];
		$dataReturned['pageTitle']='Measles Response Compliance';
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//print_r($dataReturned); exit;
		return $dataReturned;
	}
		
	//last_query($query);
} 