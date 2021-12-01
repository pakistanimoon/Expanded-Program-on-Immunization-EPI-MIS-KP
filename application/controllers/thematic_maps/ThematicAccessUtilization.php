<?php 
class ThematicAccessUtilization extends CI_Controller {
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
		}
	}
	//----------------------------------------------------------//
	//================ DistrictWiseMapData function starts====================//
	public function DistrictWiseMapData(){
		$data = $this -> getUriSegmentData();
		$fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$monthfrom = $monthfromarr[1];
		$yearfrom = $monthfromarr[0];
		
		$fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$monthto = $monthtoarr[1];
		$yearto = $monthtoarr[0];
		
		$monthnamefrom = monthname($monthfrom); 	
		$monthnameto = monthname($monthto);
		
		if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
			$yearMonth = " {$yearfrom} {$monthnamefrom} to {$monthnameto}" ;
			$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
		}
		else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
		{
			$yearMonth = "{$monthnamefrom} {$yearfrom}" ;
			$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
		} 
		else {
			$yearMonth = "From {$monthnamefrom} {$yearfrom}, To {$monthnameto} {$yearto} " ;
			$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
		}
		$districtName="";
		$locality =  "District";
		$procode = $this->session->Province;
		$info['mapName'] = $info['barName'] = "{$locality} Wise Access and Utilization, {$districtName} {$yearMonth}";
		$info['subtittle'] = $this -> session -> provincename;
		if(isset($data['id']) && $data['id'] > 0){
			$select = "select round(getmonthlytarget_specificyearrsurvivinginfants('{$data['id']}','district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric) as SurvInfTargets,
					sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}')::numeric/nullif(round(getmonthlytarget_specificyearrsurvivinginfants('{$data['id']}','district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
					round(((sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,'{$data['id']}','{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout";
		}else{
			$select = "select round(getmonthlytarget_specificyearrsurvivinginfants('{$procode}','province','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric) as SurvInfTargets,
					sumvaccinevacination(7,'{$procode}','{$fmonthfrom}','{$fmonthto}')::numeric/nullif(round(getmonthlytarget_specificyearrsurvivinginfants('{$procode}','province','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
					round(((sumvaccinevacination(7,'{$procode}','{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,'{$procode}','{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,'{$procode}','{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout";
		}
		$targets = $this -> maps -> getEPIDIndicator(NULL,$select,true);
		
		$info['run'] = true;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		$data['colorAxis'] = $this -> colorAxis();
		$i = $totpop = $tot_technician = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['coverage'] = (int)$row -> access;
			$serieses['data'][$i]['droupout'] = (int)$row -> utilization;
			$serieses['data'][$i]['value'] = $i;
			if($row -> access >= 80 && $row -> utilization < 10){
				$serieses['data'][$i]['value'] = 1;
			}elseif($row -> access >= 80 && $row -> utilization >= 10){
				$serieses['data'][$i]['value'] = 3;
			}elseif($row -> access < 80 && $row -> utilization < 10){
				$serieses['data'][$i]['value'] = 5;
			}elseif($row -> access < 80 && $row -> utilization >= 10){
				$serieses['data'][$i]['value'] = 7;
			}
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, $locality);
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$data['dropout']= $targets->dropout;
		$data['coverage']= $targets->coverage;
		$data['category'] = $this -> getCategory($targets->coverage,$targets->dropout);
		$data['bartooltip']= TRUE ;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/thematic_access_utilizaiton';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getQuerySelection($data){
		$fmonthfrom = $data['fmonthfrom'];
		$fmonthto = $data['fmonthto'];
		$date_from = explode("-",$fmonthfrom);
		$startyear = $date_from[0];
		$sm = $date_from[1];
		$date_to = explode("-",$fmonthto);
		$endyear = $date_to[0];
		$em = $date_to[1];
		$code = "";
		$procode=$this->session->Province;
		if($data['id'] AND $data['id'] > 0){
			$code = $data['id'];
			$query="select code,name,Access,utilization,
			sum(case when (Access >= 80) and (utilization < 10) then 1 else null end) as cat1,
			sum(case when (Access >= 80) and (utilization >= 10) then 1 else null end) as cat2,
			sum(case when (Access < 80) and (utilization < 10) then 1 else null end) as cat3,
			sum(case when (Access < 80) and (utilization >= 10) then 1 else null end) as cat4,path
			from (
				select fac.uncode as code,unname(fac.uncode) as name,
					COALESCE(round(((sumvaccinevacination(7,fac.uncode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac.uncode,'unioncouncil','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0),0) as Access,
					COALESCE(round(((sumvaccinevacination(7,fac.uncode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac.uncode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac.uncode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1),0) as utilization,
					path
					from fac_mvrf_db fac
					join uc_wise_maps_paths d1 on d1.uncode=fac.uncode 
					where fac.procode = '{$procode}' and fac.distcode='{$data['id']}' 
					group by fac.uncode,path order by fac.uncode
			) as a group by code,name,path,Access,utilization order by cat4,cat3,cat2,cat1";
		}else{
			$query="
			select code,name,Access,utilization,
			sum(case when (Access >= 80) and (utilization < 10) then 1 else null end) as cat1,
			sum(case when (Access >= 80) and (utilization >= 10) then 1 else null end) as cat2,
			sum(case when (Access < 80) and (utilization < 10) then 1 else null end) as cat3,
			sum(case when (Access < 80) and (utilization >= 10) then 1 else null end) as cat4,path
			from (
				select fac.distcode as code,districtname(fac.distcode) as name,
				COALESCE(round(((sumvaccinevacination(7,fac.distcode,'{$fmonthfrom}','{$fmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants(fac.distcode,'district','{$startyear}','{$sm}','{$endyear}','{$em}') :: float,0))*100):: numeric,0),0) as Access,
				COALESCE(round(((sumvaccinevacination(7,fac.distcode,'{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,fac.distcode,'{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac.distcode,'{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1),0) as utilization,
				path
				from fac_mvrf_db fac
				join districts_wise_maps_paths d1 on d1.distcode=fac.distcode 
				where fac.procode = '{$procode}' 
				group by fac.distcode,path order by fac.distcode
				) as a group by code,name,path,Access,utilization order by cat4,cat3,cat2,cat1";
		}
		$result = $this -> maps -> getEPIDIndicator($code,$query);
		return $result;
		
	}
	public function getUriSegmentData(){
		if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
			$data['ajax'] = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		if($this -> uri -> segment(4))
		{
			$data['id'] = "";
			if($this -> uri -> segment(4) && strlen($this -> uri -> segment(4))==3)
				$data['id'] = $this -> uri -> segment(4);
			$data['fmonthfrom'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):date('Y',strtotime("first day of previous months")).'-'.date('m',strtotime("first day of previous months"));		
			$data['fmonthto']  	= ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months")).'-'.date('m',strtotime("first day of previous months"));
		}
		else
		{
			$data['id']  		= ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$data['fmonthfrom'] = ($this->input->post('monthfrom'))?$this->input->post('monthfrom'):date('Y',strtotime("first day of previous months")).'-'.date('m',strtotime("first day of previous months"));
			$data['fmonthto'] 	= ($this->input->post('monthto'))?$this->input->post('monthto'):date('Y',strtotime("first day of previous months")).'-'.date('m',strtotime("first day of previous months"));
		}
		return $data;
	}
	public function UcWiseMapData(){
		$data = $this -> getUriSegmentData();
		$fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$monthfrom = $monthfromarr[1];
		$yearfrom = $monthfromarr[0];
		
		$fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$monthto = $monthtoarr[1];
		$yearto = $monthtoarr[0];
		
		$monthnamefrom = monthname($monthfrom); 	
		$monthnameto = monthname($monthto);
		
		if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
			$yearMonth = " {$yearfrom} {$monthnamefrom} to {$monthnameto}" ;
			$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
		}
		else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
		{
			$yearMonth = "{$monthnamefrom} {$yearfrom}" ;
			$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
		} 
		else {
			$yearMonth = "From {$monthnamefrom} {$yearfrom}, To {$monthnameto} {$yearto} " ;
			$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
		}
		
		$distcode = $this->session->District;
		$locality = "UCs";
		$data['districtName'] = $districtName =DistrictName($data['id']);
		$procode = $this->session->Province;
		$info['mapName'] = $info['barName'] = "{$locality} Wise Access and Utilization, {$districtName}, {$yearMonth}";
		$info['subtittle'] = $this -> session -> provincename;
		$select = "select round(getmonthlytarget_specificyearrsurvivinginfants('{$data['id']}','district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric) as SurvInfTargets,
					sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}')::numeric/nullif(round(getmonthlytarget_specificyearrsurvivinginfants('{$data['id']}','district','{$yearfrom}','{$monthfrom}','{$yearto}','{$monthto}'):: numeric),0)*100 as coverage,
					round(((sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}') :: numeric - sumvaccinevacination(9,'{$data['id']}','{$fmonthfrom}','{$fmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,'{$data['id']}','{$fmonthfrom}','{$fmonthto}'):: float,0) :: numeric)*100 ,1) as dropout";
		$targets = $this -> maps -> getEPIDIndicator(NULL,$select,true);
		
		$info['run'] = false;
		$serieses = $dataSeries = $indicators = array();
		$serieses['name'] = "";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		$result = $this ->getQuerySelection($data);
		$data['colorAxis'] = $this -> colorAxis();
		$i = $totpop = $tot_technician = 0;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['coverage'] = $row -> access;
			$serieses['data'][$i]['droupout'] = $row -> utilization;
			$serieses['data'][$i]['value'] = $i;
			if($row -> access >= 80 && $row ->utilization < 10){
				$serieses['data'][$i]['value'] = 1;
			}elseif($row -> access >= 80 && $row ->utilization >= 10){
				$serieses['data'][$i]['value'] = 3;
			}elseif($row -> access < 80 && $row ->utilization < 10){
				$serieses['data'][$i]['value'] = 5;
			}elseif($row -> access < 80 && $row ->utilization >= 10){
				$serieses['data'][$i]['value'] = 7;
			}
			$i++;
		}
		array_push($dataSeries,$serieses);
		$resultArray = $this -> getRankingSeriesData($data,$result, $locality);
		
		$data['serieses'] = $viewData['serieses'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$data['serieses_ranking'] = $viewData['serieses_ranking'] = $resultArray['serieses_ranking'];
		$data['serieses_ranking_cat'] = $viewData['serieses_ranking_cat'] = $resultArray['serieses_ranking_cat'];
		$data['heading'] = $info;
		$data['dropout']= $targets->dropout;
		$data['coverage']= $targets->coverage;
		$data['category'] = $this -> getCategory($targets->coverage,$targets->dropout);
		$data['bartooltip']= TRUE ;
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'thematic_maps/thematic_access_utilizaiton';
		$viewData['pageTitle']='EPI-MIS Dashboard | Province Map ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getRankingSeriesData($data,$resultdata, $locality){
		$serieses = $serieses1 = $result = $dataSeries = $dataSeries1 = array();
		$i=0;$priority=1;
		$s['name'] = $locality." Wise Priority";
		$s['animation'] = true;
		$s['dataLabels']['enabled'] = true;
		$s['dataLabels']['align'] = "center"; 
		$varrow = "poppertech";
		$vark="000";
		if($data['id']){
			$varrow = "tot_technician";
		}
		foreach($resultdata as $key  => $row){
			$serieses[$i]['name'] = $row -> name;
			$serieses[$i]['id'] = $row -> code;
			$serieses[$i]['y'] = $priority;
			$serieses[$i]['coverage'] = (int)$row -> access;
			$serieses[$i]['droupout'] = (int)$row -> utilization;

			$sum = $serieses[$i]['y'];
			if($row -> access >= 80 && $row ->utilization < 10){
				$serieses[$i]['color'] = "#0B7546";
			}elseif($row -> access >= 80 && $row ->utilization >= 10){
				$serieses[$i]['color'] = "#3366FF";
			}elseif($row -> access < 80 && $row ->utilization < 10){
				$serieses[$i]['color'] = "#EBB035";
			}elseif($row -> access < 80 && $row ->utilization >= 10){
				$serieses[$i]['color'] = "#DD1E2F";
			}
			$i++;
			$priority++;
		}

		$compliance = array();
		foreach ($serieses as $key => $value) {
				$compliance[$key] = $value['y'];
		}
		array_multisort($compliance, SORT_ASC, $serieses);
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
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	public function getCategory($access,$utilization){
		$return = "No data ";
		if($access >= 80 && $utilization < 10){
			$return = "First";
		}elseif($access >= 80 && $utilization >= 10){
			$return = "Second";
		}elseif($access < 80 && $utilization < 10){
			$return = "Third";
		}elseif($access < 80 && $utilization >= 10){
			$return = "Fourth";
		}
		return $return;
	}
	function colorAxis(){
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '1';
		$dataClasses['dataClasses'][0]["color"] = '#0B7546';
		$dataClasses['dataClasses'][0]["name"] = 'Category 1';

		$dataClasses['dataClasses'][1]['from'] = '2';
		$dataClasses['dataClasses'][1]['to'] = '3';
		$dataClasses['dataClasses'][1]['color'] = '#3366FF';
		$dataClasses['dataClasses'][1]['name'] = 'Category 2';
		
		$dataClasses['dataClasses'][2]['from'] = '4';
		$dataClasses['dataClasses'][2]['to'] = '5';
		$dataClasses['dataClasses'][2]['color'] = '#EBB035';
		$dataClasses['dataClasses'][2]['name'] = 'Category 3';

		$dataClasses['dataClasses'][3]['from'] = '6';
		$dataClasses['dataClasses'][3]['to'] = '7';
		$dataClasses['dataClasses'][3]['color'] = '#DD1E2F';
		$dataClasses['dataClasses'][3]['name'] = 'Category 4';

		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	//----------------------------------------------------------//
}
?>