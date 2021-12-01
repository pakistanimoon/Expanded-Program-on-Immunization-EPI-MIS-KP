<?php
class OutreachServices extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		//zing chart library used on this page
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		if($this -> session -> username == 'kp_kphis'){}else{
			authentication();
		}
		$this -> load -> model('dashboard/dashboard_model','dashboard');
	}
	
	public function index(){
		$data['reportType'] = ($this -> input -> post('report_type'))?$this -> input -> post('report_type'):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("-1 month"));
			$data['quarter'] = '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
			$data['quarter']  = ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
			$data['quarter'] = '';
		}else{
			$data = array();
		}
		
		if($this -> session -> District){
			$viewData = $this -> getProvincialSeriesData($data);//later it will use district function
		}else{
			$viewData = $this -> getProvincialSeriesData($data);
			//print_r($viewData);exit;
		}
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'dashboard/OutreachServices';
		$viewData['pageTitle']='EPI-MIS Dashboard | Outreach Services ';
		$this->load->view('template/epi_template',$viewData);
	}
	
	public function getProvincialSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		
		$coverageData = $this -> dashboard -> getVaccineCoverage($data, $selectQuery);
		//echo $this -> db -> last_query();exit;
		$totalPlanned = 0;$totalConducted = 0;$totalDropped = 0;
		$category = array();
		$serieses = array();$series2 = array();$series3 = array();
		$result = array();$result1 = array();$result2 = array();
		
		$i=0;
		//for series 1 of graph1
		$serieses["planned"]["text"] = "Sessions Planned";
		$serieses["planned"]["background-color"] = "#00baf0";
		$serieses["planned"]["description"] = "Total Outreach Sessions Planned";
		$serieses["planned"]["hover-state"] = array("background-color" => "#dadada");
		//for series 2 of graph1
		$serieses["conducted"]["text"] = "Sessions Conducted";
		$serieses["conducted"]["background-color"] = "#88C100";
		$serieses["conducted"]["description"] = "Outreach Sessions Conducted out of Total Planned";
		$serieses["conducted"]["hover-state"] = array("background-color" => "#FF9619");
		//for series 3 of graph1
		$serieses["dropout"]["text"] = "Sessions Dropout";
		$serieses["dropout"]["background-color"] = "#FF8A00";
		$serieses["dropout"]["description"] = "Outreach Sessions Dropout out of Total Planned";
		$serieses["dropout"]["hover-state"] = array("background-color" => "#91CE00");
		
		/* //for series 1 of graph2
		$series2["planned"]["text"] = "Sessions Planned";
		$series2["planned"]["background-color"] = "#00baf0";//"#FF8A00";
		$series2["planned"]["description"] = "Outreach Sessions Planned";
		$series2["planned"]["hover-state"] = array("background-color" => "#91CE00"); */
		//for series 2 of graph2
		$series2["conducted"]["text"] = "Sessions Conducted Rate";
		$series2["conducted"]["background-color"] = "#88C100";
		$series2["conducted"]["description"] = "Outreach Sessions Conducted Rate out of Total Planned";
		$series2["conducted"]["hover-state"] = array("background-color" => "#FF9619");
		
		/* //for series 1 of graph3
		$series3["planned"]["text"] = "Sessions Planned";
		$series3["planned"]["background-color"] = "#00baf0";//"#FF8A00";
		$series3["planned"]["description"] = "Outreach Sessions Planned";
		$series3["planned"]["hover-state"] = array("background-color" => "#91CE00"); */
		//for series 2 of graph3
		$series3["dropout"]["text"] = "Sessions Dropout Rate";
		$series3["dropout"]["background-color"] = "#FF8A00";
		$series3["dropout"]["description"] = "Outreach Sessions Dropout Rate out of Total Planned";
		$series3["dropout"]["hover-state"] = array("background-color" => "#91CE00");
		
		foreach($coverageData as $row){
			$category[$i] = $row -> name;
			
			//for graph1
			$serieses["planned"]["values"][] = ($row -> planned != "")?($row -> planned):0;
			$totalConducted += ($row -> conducted != "")?$row -> conducted:0;
			$serieses["conducted"]["values"][] = ($row -> conducted != "")?$row -> conducted:0;
			$dropped = ($row -> planned != "")?($row -> planned - $row -> conducted):0;
			$totalDropped += $dropped;
			$serieses["dropout"]["values"][] = $dropped;
			
			//for graph2
			//$series2["planned"]["values"][] = ($row -> planned != "")?($row -> planned):0;
			if($row -> planned == 0){
				$series2["conducted"]["values"][] = 0;
				$series3["dropout"]["values"][] = 0;
			}else{
				$series2["conducted"]["values"][] = (($row -> conducted != "")?(round(($row -> conducted/$row -> planned)*100,2)):0)."%";
				$series3["dropout"]["values"][] = (($row -> planned != "")?(round(($dropped/$row -> planned)*100,2)):0)."%";			
			}
			//for graph3
			//$series3["planned"]["values"][] = ($row -> planned != "")?($row -> planned):0;
			$i++;
		}
		$totalPlanned = $totalConducted + $totalDropped;
		//for graph1
		array_push($result,$serieses["planned"]);
		array_push($result,$serieses["conducted"]);
		array_push($result,$serieses["dropout"]);
		//for graph2
		//array_push($result1,$series2["planned"]);
		array_push($result1,$series2["conducted"]);
		//for graph3
		//array_push($result2,$series3["planned"]);
		array_push($result2,$series3["dropout"]);
		//for graph1
		$result['serieses'] = json_encode($result,JSON_NUMERIC_CHECK);
		//for graph2
		$result['condRate'] = json_encode($result1,JSON_NUMERIC_CHECK);
		//for graph3
		$result['dropRate'] = json_encode($result2,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($category,JSON_NUMERIC_CHECK);
		$result['totalPlanned'] = $totalPlanned;
		$result['totalConducted'] = $totalConducted;
		$result['totalDropped'] = $totalDropped;
		return $result;
	}
	
	public function getDistrictSeriesData($data){
		echo "Comming Soon";
	}
	
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	
	public function getQuerySelectPortion($data){
		if($this -> session -> District){
			$q = " facode as code,fac_name as name, ";
		}else{
			$q = " distcode as code,district as name, ";
		}	
		$from = " from fac_mvrf_db ";
		if($data['reportType'] == 'monthly'){
			$from .= " where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$from .= " where fmonth >= '" . $this->monthFrom($data['quarter']) . "' and fmonth <= '" . $this->monthTo($data['quarter']) . "'";
		}elseif($data['reportType'] == 'yearly'){
			$from .= " where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if($this -> session -> District){
			$from .= " and facode=facilities.facode ";
		}else{
			$from .= " and distcode=districts.distcode ";
		}
		$q .= "(select sum(or_vacc_held) $from) as conducted, (select sum(or_vacc_planned) $from) as planned ";
		//echo $q; exit;
		return $q;
	}
	
	public function monthFrom($quarter){
		switch ($quarter){
			case "01":
				return "2016-01";
			case "02":
				return "2016-04";
			case "03":
				return "2016-07";
			case "04":
				return "2016-10";
		}
	}
	
	public function monthTo($quarter){
		switch ($quarter){
			case "01":
				return "2016-03";
			case "02":
				return "2016-06";
			case "03":
				return "2016-09";
			case "04":
				return "2016-12";
		}
	}
}
