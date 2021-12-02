<?php 
class ThematicCompliance extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
			if($this -> session -> username == 'kp_kphis'){}else{
				authentication();
			}
		$this -> load -> model('maps/Maps_model','maps');
	}
	//================ Constructor function ends=================//
	//----------------------------------------------------------//
	//================ Index function starts====================//
	public function index() {
		if($this -> session -> District){ 
			$this -> UcWiseMapData();
		}else{
			if($this -> input -> post('id'))
			{
				$this -> UcWiseMapData();
			}
			else
			{
				$this -> DistrictWiseMapData();
			}
			//$this -> UcWiseMapData();
		}
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$data = $this -> getUriSegmentData();//print_r($data);exit;
		$fmonth = $data['year'] . "-" . $data['month'];
		if($data['reportType']=='monthly')
		{
			$monthQauarterYear = monthname($data['month'])." ".$data['year'];
		}elseif($data['reportType']=='quarterly')
		{
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$data['year'];
		}
		elseif($data['reportType']=='Weekly')
		{
			$monthQauarterYear = "Week-".$data['week']." ".$data['year'];
			$result = $this ->getQuerySelection($data);
		}
		else
		{
			$monthQauarterYear = $data['year'];
		}
		$districtName="";
		if($this->session->UserLevel==2)
		{
			$locality =  "District";
		}
		else
		{
			$distcode = $this->session->District;
			$locality = "Union Council";
			$districtName = DistrictName($distcode);
			
		}
		$info['mapName'] = $info['barName'] = "{$locality} Wise {$data['compType']} Report Compliance, {$districtName} {$monthQauarterYear}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		$data['colorAxis'] = $this -> colorAxis();
		$indicators = $this -> maps -> getMainIndicatorsData();
		$Nominator = "sub";
		$Denominator = "due";
		if($data['reportStatus']=='timely')
		{
			$Nominator = "timely";
			//$Denominator = "sub";
		}
		$i = $totalDue = $totalSub = $totalComp = $totaltimely = $timelyness = 0;///// setting the timelyprct for zero report
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['fmonth'] = $fmonth;
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
		$resultArray = $this -> getRankingSeriesData($data,$result, "District");
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['indicators'] = $indicators;//print_r($viewData['serieses']);exit;
		$data['totalDue'] = $totalDue;
		$data['totalSub'] = $totalSub;
		$data['totalComp'] = $totalComp;
		$data['timelyness'] = $timelyness;
		$data['heading'] = $info;
		$viewData['data'] = $data;
		if($data['ajax']){
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
		$compNameDate = $this -> getNameCompliance($data['compType']);
		$tbl = $compNameDate['tbl'];
		$submittedDate = $compNameDate['subDate'];
		if($data['compType']=="ZeroReporting")
		{
			$result = $this -> getzeroReportingData($compNameDate,$data);
			return $result;exit;
		}
		$code = "";
		$wc = "fac.distcode = d1.distcode";
		$wc1 = "tble.distcode=d1.distcode";
		if(isset($data['id']) && $data['id'] != "")
		{
			$code = $data['id'];
			$wc = "fac.uncode = u1.uncode and fac.distcode = '{$code}'";
			$wc1 = "tble.uncode=u1.uncode and u1.distcode = '{$code}'";
			
		}
		if(isset($data['month']) &&  $data['month'] !="")
		{
			$fmonth = $data['year']."-".$data['month'];
			$query = "	(SELECT SUM(case when getfstatus_vacc('{$fmonth}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e') as due,
						(SELECT COUNT(tble.facode) from {$tbl} tble where {$wc1} and getfstatus_vacc('{$fmonth}',tble.facode)='F' and fmonth = '{$fmonth}') as sub,
						(SELECT COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth like '{$fmonth}' and getfstatus_vacc('{$fmonth}',tble.facode)='F' and {$submittedDate} <=date'{$fmonth}-05'+interval '1 month'  and {$submittedDate} >=date'{$fmonth}-01'+interval '1 month') as timely,";
			$result = $this -> maps -> getdistrictWiseMapData($code,$query);
		}
		else
		{
			if($data['quarter'] !="")
			{
				$fquarter = $this ->monthFrom($data['year'],$data['quarter']);
				$fmonth = explode('-',$fquarter);
				$month =  ltrim($fmonth[1], '0');;
				$fquarterto = $this ->monthTo($data['year'],$data['quarter']);
				$fmonthto = explode('-',$fquarterto);
				$monthto = $fmonthto[1];
			}
			else
			{
				$month = "1";
				$monthto = "12";
				if($data['year'] == date('Y'))
					$monthto = date('m',strtotime("first day of previous months"));
			}
			$query = "";
			for($i=$month;$i<=$monthto;$i++)
			{
				if($i<10)
					$i="0{$i}";
				$query .= "	(SELECT SUM(case when getfstatus_vacc('{$data['year']}-{$i}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e') as due{$i},
							(SELECT COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1}  and fmonth = '{$data['year']}-{$i}' and getfstatus_vacc('{$data['year']}-{$i}',tble.facode)='F') as sub{$i},
							(select COUNT(tble.facode) from {$tbl} tble join facilities on facilities.facode=tble.facode where {$wc1} and fmonth like '{$data['year']}-{$i}' and getfstatus_vacc('{$data['year']}-{$i}',tble.facode)='F' and {$submittedDate} <=date'{$data['year']}-{$i}-05'+interval '1 month'  and {$submittedDate} >=date'{$data['year']}-{$i}-01'+interval '1 month') as timely{$i},";
			}
			$result1 = $this -> maps -> getdistrictWiseMapData($code,$query);
			$result = array();
			$u=0;
			$due = $sub = $timely = $totdue = $totsub = $tottimely = '';
			foreach($result1 as $row){
				$result[$u]['name'] = $row -> name;
				$result[$u]['code'] = $row -> code;
				$result[$u]['path'] = $row -> path;
				for($i=$month; $i<=$monthto; $i++)
				{
					if($i < 10)
						$i="0{$i}";
					$due = "due{$i}";
					$sub = "sub{$i}";
					$timely = "timely{$i}";
					$totdue += $row -> $due;
					$totsub += $row -> $sub;
					$tottimely += $row -> $timely;
				}
				$result[$u]['due'] = $totdue;
				$result[$u]['sub'] = $totsub;
				$result[$u]['timely'] = $tottimely;
				$totdue = $totsub = $tottimely = '';
				$result = json_decode(json_encode($result), FALSE);
				$u++;
			}
		}
		return $result;
	}
	public function getzeroReportingData($comp,$data)
	{
		$code = "";
		$wc = "fac.distcode = d1.distcode";
		$wc1 = "tble.distcode=d1.distcode";
		$funcPara = "d1.distcode";
		$joins = "";
		if(isset($data['id']) && $data['id'] != "")
		{
			$code = $data['id'];
			$wc = "fac.uncode = u1.uncode and fac.distcode = '{$code}'";
			$wc1 = "uc.uncode=u1.uncode and u1.distcode = '{$code}'";
			$joins = "	join facilities fs on tble.facode=fs.facode join unioncouncil uc on fs.uncode=uc.uncode";
			$funcPara = "u1.uncode";
			
		}
		if(isset($data['year']) && $data['week'] != "all")
		{
			if($data['week'] < 10)
				$data['week'] = "0{$data['week']}";
			$query = "(select SUM(case when getfstatus_ds('{$data['year']}-{$data['week']}',fac.facode)='F' then 1 else 0 end)as cnt 
						from facilities fac where {$wc} and fac.is_ds_fac='1' and fac.hf_type='e' ) as due,
						(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and fweek ='{$data['year']}-{$data['week']}' and getfstatus_ds('{$data['year']}-{$data['week']}',tble.facode)='F'
						and week::numeric > 0) as sub,
						(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and submitted_date is not null and fweek ='{$data['year']}-{$data['week']}' and getfstatus_ds('{$data['year']}-{$data['week']}',tble.facode)='F'
						and tble.submitted_date is not null and week::numeric > 0 ) as timely,
						";
		}else{
			$query = "(select get_commulative_fstatus_ds('{$data['year']}','52',{$funcPara})) as due,
					(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and fweek like '{$data['year']}-%' 
					and week::numeric > 0) as sub,
					(select count(*) from zero_report tble {$joins} where {$wc1} and report_submitted='1' and submitted_date is not null and fweek like '{$data['year']}-%'
					and tble.submitted_date is not null and week::numeric > 0 ) as timely,
				";
		}
		
		$result1 = $this -> maps -> getdistrictWiseMapData($code,$query);
		return $result1;
	}
	public function getNameCompliance($comp=NULL)
	{
		switch ($comp){
			case 'Vaccination':
				$return = array('tbl' => 'fac_mvrf_db','subDate' => 'submitted_date');
				break;
			case 'Consumption':
				$return = array('tbl' => 'form_b_cr','subDate' => 'date_submitted');
				break;
			case 'ZeroReporting':
				$return = array('tbl' => 'zero_report','subDate' => 'submitted_date');
				break;
			default :
				$return = array('tbl' => 'fac_mvrf_db','subDate' => 'submitted_date');
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
		$data['ajax'] = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		if($this -> uri -> segment(4))
		{
			$data['id'] = $this -> uri -> segment(4);
			$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';		
			$data['year']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months"));
			$data['month'] = $month =($this -> uri -> segment(7))?$this -> uri -> segment(7):date('m',strtotime("first day of previous months"));
			$data['quarter']  = $quarter= ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			//$data['ajax'] = ($this -> uri -> segment(10))?$this -> uri -> segment(10):false;
			$data['compType'] = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Vaccination';
			$data['week'] = $week =($this -> uri -> segment(10))?$this -> uri -> segment(10):'1';		
		}
		else
		{
			$data['id']  		= ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['month'] 		= $month = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['quarter']	= $quarter = ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
			//$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
			$data['compType'] 	= ($this -> input -> post('compType'))?$this -> input -> post('compType'):'Vaccination';
			$data['week'] = $week =($this -> input -> post('week'))?$this -> input -> post('week'):'1';
		}
		if($data['reportType'] == 'monthly' && $data['compType'] !="ZeroReporting"){
			$data['month'] = $month;
			$data['quarter'] = '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['quarter']  = $quarter;
			$data['month'] = '';
		}elseif($data['reportType'] == 'yearly'){
			$data['month'] = '';
			$data['quarter'] = '';
		}else{
			if($data['compType']=='ZeroReporting')
			{
				$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
				$data['week']  = $week;
				$data['quarter'] 	= '';
				$data['month'] 	= '';
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
		if($data['reportType']=='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$data['year'];
			$result = $this ->getQuerySelection($data);
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$data['year'];
			$result = $this ->getQuerySelection($data);
		}elseif($data['reportType']=='Weekly'){
			$monthQauarterYear = "Week-".$data['week']." ".$data['year'];
			$result = $this ->getQuerySelection($data);
		}else{
			$monthQauarterYear = $data['year'];
			$result = $this ->getQuerySelection($data);
		}
		//print_r($result);exit;
		$info['barName'] = $info['mapName'] = "UCs Wise {$data['compType']} Report Compliance, {$districtName} {$monthQauarterYear}";
		$info['subtittle'] = $this -> session -> provincename;
		$info['run'] = false;
		$data['ucwisemap'] = 'true';
		$data['colorAxis'] = $this -> colorAxis();
		$result1 = $this -> maps -> getMainIndicatorsData($data['id']);
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
		//$viewData['data'] = $data;
		
		if($data['ajax']){
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
			exit;
		}
		else{
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'thematic_maps/thematic_compliance';
			$viewData['pageTitle']='EPI-MIS Dashboard | UC Wise Map';
			$this->load->view('thematic_template/thematic_template',$viewData);
		}
		
	}

	public function getRankingSeriesData($data,$resultdata, $locality){
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
		$Nominator = "sub";
		$Denominator = "due";//var_dump($data['ajax']);exit;
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
	public function monthFrom($year,$quarter){
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
	
	public function monthTo($year,$quarter){
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