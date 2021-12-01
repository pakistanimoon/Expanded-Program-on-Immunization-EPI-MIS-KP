<?php 
class ThematicCompliance extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$code = md5(date("Y-n-d"));
		if(isset($_GET['code']) && $_GET['code'] == $code){
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'provincename' => 'KPK',
				'Province' => '3',
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() {
		if($this -> session -> District){ //echo "c"; exit();
			$this -> UcWiseMapData();
		}else{
			if($this -> input -> post('id'))
			{	//echo "a"; exit();
				$this -> UcWiseMapData();
			}
			else
			{	//echo "b"; exit();
				$this -> DistrictWiseMapData();
			}
			//$this -> UcWiseMapData();
		}
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$data = $this -> getUriSegmentData();
		//print_r($data);exit();
		if($this -> uri -> segment(6) != ''){
			//echo "abc"; exit();
			if($this -> uri -> segment(9) == 'ZeroReporting'){
				$data['year'] = $data['yearto'] = $year = $yearto = $this -> uri -> segment(8);
				$data['compType'] = $compType = $this -> uri -> segment(9);
				$data['from_week'] = $from_week = $this -> uri -> segment(10);
				$data['to_week'] = $to_week = $this -> uri -> segment(11);
			}
			else{
				$data['fmonthfrom'] = $fmonthfrom = $this -> uri -> segment(6);
				$monthfromarr = explode('-',$fmonthfrom);
				$data['monthfrom'] = $monthfrom = $monthfromarr[1];
				$data['yearfrom'] = $yearfrom = $monthfromarr[0];
				
				$data['fmonthto'] = $fmonthto = $this -> uri -> segment(7);
				$monthtoarr = explode('-',$fmonthto);
				$data['monthto'] = $monthto = $monthtoarr[1];
				$data['yearto'] = $yearto = $monthtoarr[0];
				$data['compType'] = $compType = $this -> uri -> segment(9);

				$monthnamefrom = monthname($monthfrom); 	
				$monthnameto = monthname($monthto);
			}
		}
		else{
			//echo "xyz"; exit();
			$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
			$monthfromarr = explode('-',$fmonthfrom);
			$data['monthfrom'] = $monthfrom = $monthfromarr[1];
			$data['yearfrom'] = $yearfrom = $monthfromarr[0];
			
			$data['fmonthto'] = $fmonthto = $data['fmonthto'];
			$monthtoarr = explode('-',$fmonthto);
			$data['monthto'] = $monthto = $monthtoarr[1];
			$data['yearto'] = $yearto = $monthtoarr[0];
			$data['year'] = $year = $data['year'];

			$data['from_week'] = $from_week = $data['from_week'];
			$data['to_week'] = $to_week = $data['to_week'];
			$data['compType'] = $compType = $data['compType'];
			$monthnamefrom = monthname($monthfrom); 	
			$monthnameto = monthname($monthto);
		}
		
		if($compType != 'ZeroReporting'){
			if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
				$yearMonthWeek = "{$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
				$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
			}
			else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
			{
				$yearMonthWeek = "{$monthnamefrom} {$yearfrom}" ;
				$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
			} 
			else {
				$yearMonthWeek = "From {$monthnamefrom} {$yearfrom} to {$monthnameto} {$yearto} " ;
				$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
			}
		}
		else{
			if($from_week<10)
				$from_week=sprintf("%02d", $from_week);
			if($to_week<10)
				$to_week=sprintf("%02d", $to_week);
			if($from_week == $to_week){
				$yearMonthWeek = " Week-{$from_week}, {$year}" ;
				$data['hovermap'] = " Year: <b>{$year}, Week-{$from_week}</b>";				
			}
			else{
				$yearMonthWeek = " Week-{$from_week} to Week-{$to_week}, {$year}" ;
				$data['hovermap'] = " Year: <b>{$year}, From Week-{$from_week} to Week-{$to_week}</b>";
			}			
		}
		$fmonth = $data['year'] . "-" . $data['month'];
		$districtName="";
		if($this->session->UserLevel==2)
		{
			$locality =  "District";
		}
		else
		{
			$distcode = $this-> session-> District;
			$locality = "Union Council";
			$districtName = DistrictName($distcode);			
		}
		$info['mapName'] = $info['barName'] = "{$locality} Wise {$data['compType']} Report Compliance, {$districtName} {$yearMonthWeek}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		//print_r($this->db->last_query());exit; 
		$data['colorAxis'] = $this -> colorAxis();		
		$indicators = $this -> maps -> getMainIndicatorsData(0,$data['yearto']);
		// if($compType == 'ZeroReporting'){
		// 	for($i=$from_week; $i<=$to_week; $i++){
		// 		$i = sprintf("%02d", $i);
		// 		$Nominator = "sub".$i;
		// 		$Denominator = "due".$i;
		// 	}
		// }
		// else{
			$Nominator = "sub";
			$Denominator = "due";
		//}
		
		if($data['reportStatus']=='timely')
		{
			$Nominator = "timely";
			//$Denominator = "sub";
		}
		$i = $totalDue = $totalSub = $totalComp = $totaltimely = $timelyness = 0;
		///// setting the timelyprct for zero report
		//print_r($result);exit();
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			if($data['compType'] != 'ZeroReporting'){
				$serieses['data'][$i]['fmonthfrom'] = $fmonthfrom;
				$serieses['data'][$i]['fmonthto'] = $fmonthto;
			}

			$serieses['data'][$i]['value'] = ($row -> $Denominator > 0)?(round(((($row -> $Nominator)*100)/$row -> $Denominator)))>100?100:round(((($row -> $Nominator)*100)/$row -> $Denominator)):'0';
			$serieses['data'][$i]['due'] = $row -> due;
			$serieses['data'][$i]['sub'] = $row -> sub;
			$serieses['data'][$i]['timely'] = $row -> timely;

			if($row -> sub > $row -> due)
				$serieses['data'][$i]['sub'] = $row -> due;
			if($row -> timely > $row -> sub)
				$serieses['data'][$i]['timely'] = $row -> sub;	
			$totalDue += $serieses['data'][$i]['due'];
			$totalSub += $serieses['data'][$i]['sub'];
			$totaltimely += $serieses['data'][$i]['timely'];
			
			$i++;
		}
		$totalComp = round(($totalSub/$totalDue)*100);
		$timelyness = ($totalSub >0)?round(($totaltimely/$totalDue)*100):0;
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data, $result, "District");
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		//print_r($data['serieses']); exit();
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['indicators'] = $indicators;//print_r($viewData['serieses']);exit;
		$data['totalDue'] = $totalDue;
		$data['totalSub'] = $totalSub;
		$data['totalComp'] = $totalComp;
		$data['timelyness'] = $timelyness;
		$data['heading'] = $info;
		$viewData['data'] = $data;
		if(isset($data['ajax'])){
			$viewData['id'] = $this -> input -> post('map_id');
			$viewData['fmonth'] = $this -> input -> post('fmonth');
			$viewData['colorAxis'] = $this -> colorAxis();
			$viewData['heading']['mapName'] = $data['heading']['mapName'];
			$viewData['heading']['barName'] = $data['heading']['barName'];
			$viewData['heading']['subtittle'] = $data['heading']['subtittle'];
			$viewData['heading']['run'] = $data['heading']['run'];
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar);
			echo json_encode($arr);
			exit;
		}
		$viewData['fileToLoad'] = 'thematic_maps/thematic_compliance';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getQuerySelection($data) 
	{
		//print_r($data); exit();
		$fmonthfrom = $data['fmonthfrom'];
		$fmonthto = $data['fmonthto'];
		$year_month_from = explode("-", $data['fmonthfrom']);
		$dd_start_year = $start_year = $year_month_from[0]; 
		$start_year1 = $year_month_from[0]; 
		$between_year = $start_year;
		$between_year1 = $start_year;
		//echo $data['fmonthfrom']; exit();
		$dd_start_month = $start_month = ltrim($year_month_from[1],'0');
		//echo $start_month; exit();
		$year_month_to = explode("-",$data['fmonthto']);
		$dd_end_year = $end_year = $year_month_to[0];
		$end_year1 = $year_month_to[0];
		//echo $year_month_to[1]; exit();
		$dd_end_month = $end_month = ltrim($year_month_to[1],'0');		
		$year = $start_year;
		$year = ($year>0)?$year:data('Y');
		$currYear = date('Y');
		$currMonth = date('m');
		// $monthfrom = $data['monthfrom'];
		// $monthto = $data['monthto'];
		$end_monthhs = $end_month;

		$compNameDate = $this -> getNameCompliance($data['compType'],$data['year']);
		$tbl = $compNameDate['tbl'];
		$submittedDate = $compNameDate['subDate'];
		$timelydate = isset($compNameDate['timelydate'])?$compNameDate['timelydate']:'10';
		if($data['compType']=="ZeroReporting")
		{		
			$result = $this -> getzeroReportingData($compNameDate,$data);
			//print_r($result);exit();
			return $result; exit();
		}
		$code = "";
		$query = "";
		$wc = "fac.distcode = d1.distcode";
		$wc1 = "tble.distcode=d1.distcode";
		
		if($this -> session -> District OR (isset($data['id']) && $data['id'] != "")){
			//echo "abc"; exit();
			$code = $data['id'];
			$wc = "fac.uncode = u1.uncode and fac.distcode = '{$code}'";
			$wc1 = "tble.uncode=u1.uncode and u1.distcode = '{$code}'";

			for($j=$start_year; $j <= $end_year; $j++)
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
					for($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$i=(int)$ind;						
						if($data['compType']=="Consumption" && $code==""){
							$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$start_year') as due{$i},
								(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$start_year') as timely{$i},
								(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$start_year') as sub{$i},";
						}
						else{
							$a= '';
							if($i<10)								
								$i="0{$i}";
								//$a = sprintf("%02d",($i));
							$query .= "	(SELECT SUM(case when getfstatus_vacc('{$start_year}-{$i}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e') as due{$i},
							(SELECT COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth = '{$start_year}-{$i}' and getfstatus_vacc('{$start_year}-{$i}',tble.facode)='F') as sub{$i},
				            (select COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth like '{$start_year}-{$i}' and getfstatus_vacc('{$start_year}-{$i}',tble.facode)='F' and {$submittedDate} <=date'{$start_year}-{$i}-{$timelydate}'+interval '1 month' and {$submittedDate} >=date'{$start_year}-{$i}-01'+interval '1 month') as timely{$i},";
						}
					}
				}
				else if($j == $end_year) // end year
				{
					for($ind = 1; $ind <= $end_monthhs; $ind++)
					{
						$i=(int)$ind;				
						if(($end_year == $currYear) && ($ind >= $currMonth))
						{

						}
						else{
							if($data['compType']=="Consumption" && $code==""){
								$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$end_year') as due{$i},
									(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$end_year') as timely{$i},
									(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$end_year') as sub{$i},";
							}
							else{
								if($i<10)
									$a="0{$i}";
								$query .= "	(SELECT SUM(case when getfstatus_vacc('{$end_year}-{$i}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e') as due{$i},
									(SELECT COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth = '{$end_year}-{$i}' and getfstatus_vacc('{$end_year}-{$i}',tble.facode)='F') as sub{$i},
				            		(select COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth like '{$end_year}-{$i}' and getfstatus_vacc('{$end_year}-{$i}',tble.facode)='F' and {$submittedDate} <=date'{$end_year}-{$i}-{$timelydate}'+interval '1 month' and {$submittedDate} >=date'{$end_year}-{$i}-01'+interval '1 month') as timely{$i},";
							}
						}
					}
				}
				else // between year
				{
					$between_year++;
					for($ind = 1; $ind < 13; $ind++)
					{
						$i=(int)$ind;
						if($data['compType']=="Consumption" && $code==""){
							$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$between_year') as due{$i},
								(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$between_year') as timely{$i},
								(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$between_year') as sub{$i},";
						}
						else{
							if($i<10)
								$a="0{$i}";
							$query .= "	(SELECT SUM(case when getfstatus_vacc('{$between_year}-{$i}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e') as due{$i},
								(SELECT COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth = '{$between_year}-{$i}' and getfstatus_vacc('{$between_year}-{$i}',tble.facode)='F') as sub{$i},
				            	(select COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth like '{$between_year}-{$i}' and getfstatus_vacc('{$between_year}-{$i}',tble.facode)='F' and {$submittedDate} <=date'{$between_year}-{$i}-{$timelydate}'+interval '1 month' and {$submittedDate} >=date'{$between_year}-{$i}-01'+interval '1 month') as timely{$i},";
						}
					}
				}
			}
			//echo $query; exit();
		}
		else
		{
			//echo "xyz"; exit();
			for($j=$start_year; $j <= $end_year; $j++)
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
					if(($end_year - $start_year) > 0){
						$end_month = 12;
					}
					for($ind = $start_month; $ind <= $end_month; $ind++)
					{
						$i=(int)$ind;
						if($data['compType']=="Consumption" && $code==""){
							$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$start_year') as due{$i},
								(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$start_year') as timely{$i},
								(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$start_year') as sub{$i},";
						}
						else{
							$query.="(select duem$i from vaccinationcompliance where vaccinationcompliance.distcode = d1.distcode and vaccinationcompliance.year='$start_year') as due{$i},
							(select tsubm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$start_year') as timely{$i},
							(select subm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$start_year') as sub{$i},";
						}
					}
				}
				else if($j == $end_year) // end year
				{
					for($ind = 1; $ind <= $end_monthhs; $ind++)
					{
						$i=(int)$ind;				
						if(($end_year == $currYear) && ($ind >= $currMonth))
						{

						}
						else{
							if($data['compType']=="Consumption" && $code==""){
								$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$end_year') as due{$i},
									(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$end_year') as timely{$i},
									(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$end_year') as sub{$i},";
							}
							else{
								$query.="(select duem$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$end_year') as due{$i},
									(select tsubm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$end_year') as timely{$i},
									(select subm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$end_year') as sub{$i},";
							}
						}
					}
				}
				else // between year
				{
					$between_year++;
					for($ind = 1; $ind < 13; $ind++)
					{
						$i=(int)$ind;
						if($data['compType']=="Consumption" && $code==""){
							$query.="(select duem$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$between_year') as due{$i},
								(select tsubm$i from consumptioncompliance where consumptioncompliance.distcode = d1.distcode and consumptioncompliance.year='$between_year') as timely{$i},
								(select subm$i from consumptioncompliance where consumptioncompliance.distcode= d1.distcode and consumptioncompliance.year='$between_year') as sub{$i},";
						}
						else{
							$query.="(select duem$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$between_year') as due{$i},
								(select tsubm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$between_year') as timely{$i},
								(select subm$i from vaccinationcompliance where vaccinationcompliance.distcode= d1.distcode and vaccinationcompliance.year='$between_year') as sub{$i},";
						}
					}
				}
			}
			//echo $query; exit();
			//$result1 = $this -> maps -> getdistrictWiseMapData($code,$query);			
		}
		$result1 = $this -> maps -> getdistrictWiseMapData($code,$query);	
		//print_r($result1); exit();
		$result = array();
		$u=0;
		//print_r($result1); exit();
		foreach($result1 as $row){
			$due = $sub = $timely = 0;
			$result[$u]['name'] = $row -> name;
			$result[$u]['code'] = $row -> code;
			$result[$u]['path'] = $row -> path;

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
					// if($end_year-$start_year > 0)
					// 	$end_month=12;			
					for($i=$start_month;$i<=$end_month;$i++)
					{
						//print_r($row -> {"due".$i}); exit();
						//print_r($row); exit();
						//$i = (int)$i;sprintf("%02d",($i));
						$due += $row -> {"due".$i};
						$sub += $row -> {"sub".$i};
						$timely += $row -> {"timely".$i};
						//echo $due; exit();
					}
				}
				//echo $due .= $row -> {"due".$i};exit();
				else if($l == $end_year) // end year
				{
					for($i=1; $i<=$end_monthhs; $i++)
					{
						$due += $row -> {"due".$i};
						$sub += $row -> {"sub".$i};
						$timely += $row -> {"timely".$i};
					}
				}
				else // between year
				{
					$between_year1++;
					for($i=1; $i<=12; $i++)
					{
						$due += $row -> {"due".$i};
						$sub += $row -> {"sub".$i};
						$timely += $row -> {"timely".$i};
					}
				}

				// $result[$u]['due'] = (isset($result[$u]['due'])?$result[$u]['due']:0)+(int)$due;
				// $result[$u]['sub'] = (isset($result[$u]['sub'])?$result[$u]['sub']:0)+(int)$sub;
				// $result[$u]['timely'] = (isset($result[$u]['timely'])?$result[$u]['timely']:0)+(int)$timely;
				$result[$u]['due'] = +(int)$due;
				$result[$u]['sub'] = +(int)$sub;
				$result[$u]['timely'] = +(int)$timely;
			}
			$u++;
			$result = json_decode(json_encode($result), FALSE);
		}
		//print_r($result);exit;
		return $result;
	}

	public function getzeroReportingData($comp, $data)
	{ 	//print_r($data);exit();
		$code = "";
		$year = $data['year'];
		$from_week = $data['from_week'];
		$to_week = $data['to_week'];
		$wc = "fac.distcode = d1.distcode";
		$wc1 = "tble.distcode=d1.distcode";
		$funcPara = "d1.distcode";
		$joins = "";
		$query="";
		if(isset($data['id']) && $data['id'] != "")
		{
			$code = $data['id'];
			$wc = "fac.uncode = u1.uncode and fac.distcode = '{$code}'";
			$wc1 = "uc.uncode=u1.uncode and u1.distcode = '{$code}'";
			$joins = "	join facilities fs on tble.facode=fs.facode join unioncouncil uc on fs.uncode=uc.uncode";
			$funcPara = "u1.uncode";
			if($this -> session -> UserLevel == 4){
				$code = $this->session->TehsilCode;
				$wc = "fac.uncode = u1.uncode and fac.tcode = '{$code}'";
				$wc1 = "uc.uncode=u1.uncode and u1.tcode = '{$code}'";
			}
		}
		if($this -> session -> District OR (isset($data['id']) && $data['id'] != "")){
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$i = sprintf("%02d", $ind);
				$query.="(select SUM(case when getfstatus_ds('{$year}-{$i}',fac.facode)='F' then 1 else 0 end)as cnt from facilities fac where {$wc} and fac.is_ds_fac='1' and fac.hf_type='e' ) as due{$i},
					(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and fweek ='{$year}-{$i}' and getfstatus_ds('{$year}-{$i}',tble.facode)='F'
						and week::numeric > 0) as sub{$i},
					(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and submitted_date is not null and fweek ='{$year}-{$i}' and getfstatus_ds('{$year}-{$i}',tble.facode)='F' and tble.submitted_date is not null and week::numeric > 0 ) as timely{$i},";
			}
		}
		else{
			for ($ind = $from_week; $ind <= $to_week; $ind++) {
				$i = sprintf("%02d", $ind);
				$query.="(select duewk$i from zeroreportcompliance where zeroreportcompliance.distcode= d1.distcode and zeroreportcompliance.year='$year') as due{$i},					
					(select subwk$i from zeroreportcompliance where zeroreportcompliance.distcode= d1.distcode and zeroreportcompliance.year='$year') as sub{$i},
					(select tsubwk$i from zeroreportcompliance where zeroreportcompliance.distcode= d1.distcode and zeroreportcompliance.year='$year') as timely{$i},";
			}
		}
		$result1 = $this -> maps -> getdistrictWiseMapData($code,$query);
		//print_r($result1);
		$result = array();
		$u=0;
       	$due = $sub = $timely = '';
		$totdue = $totsub = $tottimely = 0;
		foreach($result1 as $row){
			$result[$u]['name'] = $row -> name;
			$result[$u]['code'] = $row -> code;
			$result[$u]['path'] = $row -> path;
			for($i=$from_week; $i<=$to_week; $i++)
			{
				if($i < 10)
					$i=sprintf("%02d", $i);;
				$due = $row -> {"due".$i};
				$sub = $row -> {"sub".$i};
				$timely = $row -> {"timely".$i};
				
				$totdue = $totdue + $due;
				$totsub = $totsub + $sub;
				$tottimely = $tottimely + $timely;
			}//exit;
			$result[$u]['due'] = $totdue;
			$result[$u]['sub'] = $totsub;
			$result[$u]['timely'] = $tottimely;
			
			$totdue = $totsub = $tottimely = 0;
			$result = json_decode(json_encode($result), FALSE);
			$u++;
		}
		return $result;
	}

	public function getNameCompliance($comp=NULL, $year=NULL)
	{
		switch ($comp){
			case 'Vaccination':
				$return = array('tbl' => 'fac_mvrf_db','subDate' => 'submitted_date','timelydate' => '10');
				break;
			case 'Consumption':
				$return = array('tbl' => 'epi_consumption_master','subDate' => 'created_date','timelydate' => '10');
				break;
			case 'ZeroReporting':
				$return = array('tbl' => 'zero_report','subDate' => 'submitted_date');
				break;
			default :
				$return = array('tbl' => 'fac_mvrf_db','subDate' => 'submitted_date','timelydate' => '10');
		}
		return $return;
	}

	public function ajaxCall($data, $viewData){
			$viewData['id'] = $this -> input -> post('map_id');
			$viewData['fmonth'] = $this -> input -> post('fmonth');
			$viewData['colorAxis'] = $this -> colorAxis();
			$viewData['heading']['mapName'] = $data['heading']['mapName'];
			$viewData['heading']['barName'] = $data['heading']['barName'];
			$viewData['heading']['subtittle'] = $data['heading']['subtittle'];
			$viewData['heading']['run'] = $data['heading']['run'];
			$parameters['vaccineBy'] = $data['vaccineBy'];
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar, 'otherParameters' => $parameters);
			echo json_encode($arr);
			exit;
	}

	public function getUriSegmentData(){
		$data['reportStatus'] = ($this -> input -> post('reportStatus'))?$this -> input -> post('reportStatus'):'complete';
		if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
			$data['ajax'] = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		if($this -> uri -> segment(4))
		{
			//echo "abc"; exit();
			if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
				$data['id'] = $this -> uri -> segment(4);
			$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
			$data['fmonthfrom'] 	= ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y-m',strtotime("first day of previous months"));
			$data['fmonthto'] 		= ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y-m',strtotime("first day of previous months"));
			$data['year']  = $year = ($this -> uri -> segment(8))?$this -> uri -> segment(8):date('Y',strtotime("first day of previous months"));
			$data['month'] = $month =($this -> uri -> segment(11))?$this -> uri -> segment(11):date('m',strtotime("first day of previous months"));
			$data['quarter']  = '';//$quarter= ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			//$data['ajax'] = ($this -> uri -> segment(10))?$this -> uri -> segment(10):false;
			$data['compType'] = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Vaccination';
			$data['from_week'] = $week =($this -> uri -> segment(10))?$this -> uri -> segment(10):lastWeek($year);
			//$curr_year = date('Y');
			$data['to_week'] = $week =($this -> uri -> segment(11))?$this -> uri -> segment(11):lastWeek($year);
			$data['biyear'] = '';//$week =($this -> uri -> segment(11))?$this -> uri -> segment(11):'01';
		}
		else
		{
			//echo "xyz"; exit();
			//print_r($_POST); exit();
			$data['id']  		= ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$data['year']  		= $year = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['fmonthfrom'] 	= ($this -> input -> post('monthfrom'))?$this -> input -> post('monthfrom'):date('Y-m',strtotime("first day of previous months"));
			$data['fmonthto'] 		= ($this -> input -> post('monthto'))?$this -> input -> post('monthto'):date('Y-m',strtotime("first day of previous months"));
			$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
			$data['from_week']  = $from_week = ($this -> input -> post('from_week'))?$this -> input -> post('from_week'):lastWeek($year);
			$data['to_week']  = $to_week = ($this -> input -> post('to_week'))?$this -> input -> post('to_week'):lastWeek($year);
			//echo $from_week.' / '.$to_week;exit();
			// $data['quarter']	= ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
			$data['compType'] 	= ($this -> input -> post('compType'))?$this -> input -> post('compType'):'Vaccination';
			$data['month'] 		= ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			//$data['week'] = $week =($this -> input -> post('week'))?$this -> input -> post('week'):'1';
			// $data['biyear'] = ($this -> input -> post('biyear'))?$this -> input -> post('biyear'):'01';
		}
		if($data['reportType'] == 'monthly' && $data['compType'] !="ZeroReporting"){
			$data['quarter'] = '';
			$data['biyear'] = '';
			$data['week'] = '';
		}elseif($data['reportType'] == 'quarterly' && $data['compType'] !="ZeroReporting"){
			$data['month'] = '';
			$data['biyear'] = '';
			$data['week'] = '';
		}elseif($data['reportType'] == 'biyearly' && $data['compType'] !="ZeroReporting"){
			$data['month'] = '';
			$data['quarter'] = '';
			$data['week'] = '';
		}elseif($data['reportType'] == 'yearly' ){
			$data['month'] = '';
			$data['quarter'] = '';
			$data['biyear'] = '';
		}else{
			if($data['compType']=='ZeroReporting')
			{
				$data['quarter'] 	= '';
				$data['month'] 	= '';
				$data['biyear'] = '';
				$data['reportType'] = 'Weekly';
			}
		}
		return $data;
	}
	//----------------------------------------------------------//
	//================ UcWiseMapData function starts====================//
	public function UcWiseMapData() {
		$data = $this -> getUriSegmentData();//print_r($data);exit;

		$data['districtName'] = $districtName = $this -> maps ->DistrictName($data['id']);
		$info['district'] = $districtName;
		if($this -> uri -> segment(6) != ''){
			//echo "abc"; exit();
			if($this -> uri -> segment(9) != 'ZeroReporting'){
				$data['fmonthfrom'] = $fmonthfrom = $this -> uri -> segment(6);
				$monthfromarr = explode('-',$fmonthfrom);
				$data['monthfrom'] = $monthfrom = $monthfromarr[1];
				$data['yearfrom'] = $yearfrom = $monthfromarr[0];
				
				$data['fmonthto'] = $fmonthto = $this -> uri -> segment(7);
				$monthtoarr = explode('-',$fmonthto);
				$data['monthto'] = $monthto = $monthtoarr[1];
				$data['yearto'] = $yearto = $monthtoarr[0];
			}
			else{
				$data['year'] = $year = $this -> uri -> segment(8);
				$data['from_week'] = $from_week = $this -> uri -> segment(10);
				$data['to_week'] = $to_week = $this -> uri -> segment(11);
			}
		}
		else{
			//echo "xyz"; exit();
			$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
			$monthfromarr = explode('-',$fmonthfrom);
			$data['monthfrom'] = $monthfrom = $monthfromarr[1];
			$data['yearfrom'] = $yearfrom = $monthfromarr[0];
			
			$data['fmonthto'] = $fmonthto = $data['fmonthto'];
			$monthtoarr = explode('-',$fmonthto);
			$data['monthto'] = $monthto = $monthtoarr[1];
			$data['yearto'] = $yearto = $monthtoarr[0];

			$data['year'] = $year = $data['year'];
			$data['from_week'] = $from_week = $data['from_week'];
			$data['to_week'] = $to_week = $data['to_week'];
		}
		if(isset($monthfrom)){
			$monthnamefrom = monthname($monthfrom); 	
			$monthnameto = monthname($monthto);
		}

		if($data['compType'] != 'ZeroReporting' && $this -> uri -> segment(9) != 'ZeroReporting'){
			if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
				$yearMonthWeek = " {$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
				$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
			}
			else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
			{
				$yearMonthWeek = "{$monthnamefrom} {$yearfrom}" ;
				$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
			} 
			else {
				$yearMonthWeek = "From {$monthnamefrom} {$yearfrom} to {$monthnameto} {$yearto} " ;
				$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
			}
		}
		else{
			if($from_week<10)
				$from_week=sprintf("%02d", $from_week);
			if($to_week<10)
				$to_week=sprintf("%02d", $to_week);
			if($from_week == $to_week){
				$yearMonthWeek = " Week-{$from_week}, {$year}" ;
				$data['hovermap'] = " Year: <b>{$year}, Week-{$from_week}</b>";				
			}
			else{
				$yearMonthWeek = " Week-{$from_week} to Week-{$to_week}, {$year}" ;
				$data['hovermap'] = " Year: <b>{$year}, From Week-{$from_week} to Week-{$to_week}</b>";
			}
		}
		$result = $this ->getQuerySelection($data);
		
		$info['barName'] = $info['mapName'] = "UCs Wise {$data['compType']} Report Compliance, {$districtName}, {$yearMonthWeek}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = false;
		$data['ucwisemap'] = 'true';
		$data['colorAxis'] = $this -> colorAxis();		
		$year=$data['year'];
		$result1 = $this -> maps -> getMainIndicatorsData($data['id'],$year);
		$serieses = array();
		$dataSeries = array();
		$i = 0;
		$serieses['name'] = "UC Wise Compliance";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$Nominator = "sub";
		$Denominator = "due";
		if($data['reportStatus']=='timely')
		{
			$Nominator = "timely";
			//$Denominator = "sub";
		}
		$totalDue = $totalSub = $totalComp = $totaltimely = $timelyness = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			//$serieses['data'][$i]['fmonth'] = $fmonth;
			if($row -> $Denominator != 0)
				$serieses['data'][$i]['value'] = (round(((($row -> $Nominator)*100)/$row -> $Denominator),2))>100?100:round(((($row -> $Nominator)*100)/$row -> $Denominator),2);
			else
				$serieses['data'][$i]['value'] = 0;
			$serieses['data'][$i]['due'] = $row -> due;
			$serieses['data'][$i]['sub'] = $row -> sub;
			$serieses['data'][$i]['timely'] = $row -> timely;
			/* if($row -> sub > $row -> due)
				$serieses['data'][$i]['sub'] = $row -> due;  */
			$totalDue += $serieses['data'][$i]['due'];
			$totalSub += $serieses['data'][$i]['sub'];
			$totaltimely += $serieses['data'][$i]['timely'];
			$i++;
		}
		if($totalDue){
			$totalComp = ($totalDue > 0)?round(($totalSub/$totalDue)*100):0;
		}
		$timelyness = ($totalSub >0)?round(($totaltimely/$totalDue)*100):0;
		
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, "UC");
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat']= $resultArray['serieses_ranking_cat'];
		$data['totalDue'] = $totalDue;
		$data['totalSub'] = $totalSub;
		$data['totalComp'] = $totalComp;
		$data['timelyness'] = $timelyness;
		$data['indicators'] = $result1;
		$data['heading'] = $info;
		$viewData['data'] = $data;
		//print_r($viewData);
		//print_r($this->db->last_query());exit;
		if(isset($data['ajax']) && $data['ajax']){
			$viewData['id'] = $this -> input -> post('map_id');
			$viewData['fmonth'] = $this -> input -> post('fmonth');
			$viewData['colorAxis'] = $this -> colorAxis();
			$viewData['heading']['mapName'] = $data['heading']['mapName'];
			$viewData['heading']['barName'] = $data['heading']['barName'];
			$viewData['heading']['run'] = $data['heading']['run'];//print_r($viewData);exit;
			$viewData['heading']['subtittle'] = $data['heading']['subtittle'];
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar);
			echo json_encode($arr);
			exit();
		}
		else{
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'thematic_maps/thematic_compliance';
			$viewData['pageTitle']='EPI-MIS Dashboard | UC Wise Map';
			$this->load->view('thematic_template/thematic_template',$viewData);
		}		
	}

	public function getRankingSeriesData($data, $resultdata, $locality){
		$serieses = array();
		$serieses1 = array();
		$result = array();
		$dataSeries = array();
		$dataSeries1 = array();
		
		$i=0;
		//$s['name'] = $locality." Wise Compliance Ranking";print_r($s['name']);exit;
		$s['name'] = " ";
		$s['animation'] = true;
		$s['dataLabels']['enabled'] = true;
		$s['dataLabels']['align'] = "center"; 
		// $Nominator = "sub";
		// $Denominator = "due";//var_dump($data['ajax']);exit;
		$Nominator = "sub";
		$Denominator = "due";
		if($data['reportStatus']=='timely')
		{
			$Nominator = "timely";
			//$Denominator = "sub";
		}
		foreach($resultdata as $row){
			$serieses[$i]['name'] = $row -> name;
			$serieses[$i]['id'] = $row -> code;
			if($row -> $Denominator != 0)
				$serieses[$i]['y'] = (round(((($row -> $Nominator)*100)/$row -> $Denominator)))>100?100:round(((($row -> $Nominator)*100)/$row -> $Denominator));
			else
				$serieses[$i]['y'] = 0;

			$sum = $serieses[$i]['y'];
			if($sum >= 100){
				$serieses[$i]['color'] = "#0B7546";
			}
			else if($sum <= 99 && $sum >= 71){
				$serieses[$i]['color'] = "#EBB035";
			}
			else if($sum <= 70){
				$serieses[$i]['color'] = "#DD1E2F";
			}
			$i++;
		}

		$compliance = array();
		foreach ($serieses as $key => $value) {
				$compliance[$key] = $value['y'];
		}
		array_multisort($compliance, SORT_DESC, $serieses);
		foreach ($serieses as $key => $value) {
			array_push($serieses1, $value['name']);
		}
		
		$s['data'] = $serieses;
		array_push($dataSeries,$s);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}
	//----------------------------------------------------------//
	//================ getUcDetails function starts====================//
	public function getUcDetails() {
		$code = $this -> input -> post('id');
		$fmonth = $this -> input -> post('fmonth');
		$result['result'] = $this -> maps -> getUcDetails($code,$fmonth);
		$result['fmonth']=$fmonth;
		$result = $this -> load -> view('thematic_maps/facilitiesData_popup',$result,TRUE);
		echo $result;
	}

	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}

	public function monthFrom($year, $quarter){
		switch ($quarter){
			case "01":
				return "{$year}-01";
			case "02":
				return "{$year}-04";
			case "03":
				return "{$year}-07";
			case "04":
				return "{$year}-10";
		}
	}
	
	public function monthTo($year, $quarter){
		switch ($quarter){
			case "01":
				return "{$year}-03";
			case "02":
				return "{$year}-06";
			case "03":
				return "{$year}-09";
			case "04":
				return "{$year}-12";
		}
	}
	
	function colorAxis(){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '70';
		$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
		$dataClasses['dataClasses'][0]["name"] = '0-70%';

		$dataClasses['dataClasses'][1]['from'] = '71';
		$dataClasses['dataClasses'][1]['to'] = '99';
		$dataClasses['dataClasses'][1]['color'] = '#EBB035';
		$dataClasses['dataClasses'][1]['name'] = '71-99%';

		$dataClasses['dataClasses'][2]['from'] = '100';
		$dataClasses['dataClasses'][2]['to'] = '1000';
		$dataClasses['dataClasses'][2]['color'] = '#0B7546';
		$dataClasses['dataClasses'][2]['name'] = '100%';

		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
}
?>