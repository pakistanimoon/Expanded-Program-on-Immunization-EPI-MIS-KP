<?php
class AccessToHealthServices extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
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
		$this -> load -> model('maps/maps_model','maps');
	}
	
	public function index(){
		$data = ($this -> input -> get('code'))?$this -> getUriSegmentData():$this -> getPostedData();
		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');
		$monthQauarterYear = "";
		$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$data['monthfrom'] = $monthfrom = $monthfromarr[1];
		$data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$data['fmonthto'] = $fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$data['monthto'] = $monthto = $monthtoarr[1];
		$data['yearto'] = $yearto = $monthtoarr[0];

		$monthnamefrom = monthname($monthfrom); 	
		$monthnameto = monthname($monthto);

		if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
			$monthQauarterYear = " {$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
			//$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
		}
		else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
		{
			$monthQauarterYear = "{$monthnamefrom} {$yearfrom}" ;
			//$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
		} 
		else {
			$monthQauarterYear = "From {$monthnamefrom} {$yearfrom} To {$monthnameto} {$yearto} " ;
			//$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
		}

		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$districtName = get_District_Name($distcode);
			$data['heading']['mapName'] = $data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['colorAxis'] = $this -> colorAxis('uc');
		}
		else{
			$data['heading']['mapName'] = $data['heading']['barName'] = "District Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, {$monthQauarterYear}";
			$data['heading']['run'] = true;
			$data['colorAxis'] = $this -> colorAxis('dist');
		}
		$viewData['serieses'] = $this -> getSeriesData($data);
		$data['indicators'][] = $this -> getVaccinationByWiseData($data);
		//print_r($data['indicators']);exit();
		$data['indicators'][] = $this -> getIndicatorData($data);
		//print_r($data['indicators']);exit();
		$result = $this -> getRankingSeriesData($data);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		//print_r($result['serieses_ranking']);exit;
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['data'] = $data;
		if(isset($data['ajax']) && $data['ajax']){
			$this -> ajaxCall($data, $viewData);
		}
		$viewData['filterowbtn'] = 'AccessToHealthServices';
		$viewData['fileToLoad'] = 'thematic_maps/access_to_thematic_health_services';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);	
	}	
	
	// 2020-03-03  start
	public function thematic_child_coverage(){
		$data = ($this -> input -> get('code'))?$this -> getUriSegmentData():$this -> getPostedData();
		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');
		$monthQauarterYear = "";
		$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$data['monthfrom'] = $monthfrom = $monthfromarr[1];
		$data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$data['fmonthto'] = $fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$data['monthto'] = $monthto = $monthtoarr[1];
		$data['yearto'] = $yearto = $monthtoarr[0];

		$monthnamefrom = monthname($monthfrom); 	
		$monthnameto = monthname($monthto);

		if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
			$monthQauarterYear = " {$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
			//$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
		}
		else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
		{
			$monthQauarterYear = "{$monthnamefrom} {$yearfrom}" ;
			//$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
		} 
		else {
			$monthQauarterYear = "From {$monthnamefrom} {$yearfrom} To {$monthnameto} {$yearto} " ;
			//$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
		}
		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$districtName = get_District_Name($distcode);
			$data['heading']['mapName'] = $data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['colorAxis'] = $this -> colorAxis('uc');
		}
		else{
			$data['heading']['mapName'] = $data['heading']['barName'] = "District Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, {$monthQauarterYear}";
			$data['heading']['run'] = true;
			$data['colorAxis'] = $this -> colorAxis('dist');
		}
		//print_r($data);exit;
		$viewData['serieses'] = $this -> get_child_SeriesData($data);
		$data['indicators'][] = '';//$this -> getVaccinationByWiseData($data);
		//print_r($data['indicators']);exit();
		$data['indicators'][] = '';//$this -> getIndicatorData($data);
		//print_r($data['indicators']);exit();
		$result = $this -> get_child_RankingSeriesData($data);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		//print_r($result['serieses_ranking']);exit;
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['data'] = $data;
		if(isset($data['ajax']) && $data['ajax']){
			$this -> ajaxCall($data, $viewData);
		}
		$viewData['filterowbtn'] = 'AccessToHealthServices';
		$viewData['fileToLoad'] = 'cerv/thematic_maps/access_to_child_registration';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);	
	}
	public function get_child_SeriesData($data){
		$coverageData = $this -> get_child_CoverageQuerySelectPortion($data);
		$name = 'UC';
		$serieses = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Open Vial Wastage";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> openvial_wastagerate != "" && $row -> openvial_wastagerate > 0)?round($row -> openvial_wastagerate):0;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
	public function get_child_RankingSeriesData($data){
		$coverageData = $this -> get_child_CoverageQuerySelectPortion($data);
		$name = 'UC';
		$serieses = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();$serieses1 = array();
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses1[$i] = $row -> name;
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['y'] = ($row -> openvial_wastagerate != "")?round($row -> openvial_wastagerate):0;
			/* if($row -> openvial_wastagerate >= 95)
				$serieses['data'][$i]['color'] = "#50eb35 ";
			else if($row -> openvial_wastagerate <= 94.99 && $row -> openvial_wastagerate >= 90)
				$serieses['data'][$i]['color'] = "#3366ff";
			else if($row -> openvial_wastagerate <= 89.99 && $row -> openvial_wastagerate >= 80)
				$serieses['data'][$i]['color'] = "#FFFF00";
			else if($row -> openvial_wastagerate <= 79.99 && $row -> openvial_wastagerate >= 50)
				$serieses['data'][$i]['color'] = "#FF8C00";
			else if($row -> openvial_wastagerate < 50)
				$serieses['data'][$i]['color'] = "#DD1E2F"; */
			$i++;
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}
	public function get_child_CoverageQuerySelectPortion($data){
		$distcode = $this->session->District;
		$vaccineId = $data['vaccineId'];
		
		$vaccine_name = get_target_vacc_name($vaccineId);
		$where = " bcg IS NOT NULL and bcg >= '2019-09-01' AND bcg <= '2019-09-30'";
		 switch($vaccineId){
			case 2:
				$where = " hepb IS NOT NULL and hepb >= '2019-09-01' AND hepb <= '2019-09-30'";
				break;
			case 1:
			
			$where = "select sum(case when opv1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '2019-09-01' and uncode=ccr.uncode as mopv1,
					(select sum(case when opv1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '2019-09-30' and uncode=ccr.uncode) as fopv1,
					(select sum(case when opv1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '2019-09-30' and uncode=ccr.uncode) as topv1
				FROM 
					cerv_child_registration ccr 
				WHERE uncode like '365%' 
				GROUP BY uncode 
				ORDER BY uncode) as a";
				
			//$where = "select sum(case when opv0 IS NOT NULL and opv0 >= '2019-09-01' AND opv0 <= '2019-09-30' THEN 1 ELSE 0 END) from cerv_child_registration";
				break;
			
		}
		
		print_r($where); exit;
		
		//$vaccine_name = get_target_vacc_name($vaccineId);
		//$where = " bcg IS NOT NULL and bcg >= '2019-09-01' AND bcg <= '2019-09-30'";
		/* switch($vaccineId){
			case 2:
				$where = " hepb IS NOT NULL and hepb >= '2019-09-01' AND hepb <= '2019-09-30'";
				break;
			case 1:
				$where = "select sum(case when opv0 IS NOT NULL and opv0 >= '2019-09-01' AND opv0 <= '2019-09-30' THEN 1 ELSE 0 END) from cerv_child_registration";
				break;
		} */
		// OR (case when opv1 IS NOT NULL and opv1 >= '2019-09-01' AND opv1 <= '2019-09-30') OR (case when opv2 IS NOT NULL and opv2 >= '2019-09-01' AND opv2 <= '2019-09-30') OR (case when opv3 IS NOT NULL and opv3 >= '2019-09-01' AND opv3 <= '2019-09-30')" from 
		print_r($where); exit;
		
		//$fmonth = $year."-".$month;
		//$fmonth = $month;
		
		//(opv0 IS NOT NULL and opv0 >= '2019-09-01' AND opv0 <= '2019-09-30') or 
		
		$query = "select sum(case when opv0 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '2019-09-01' and uncode=ccr.uncode as mopv0,
					(select sum(case when opv0 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '2019-09-01' and uncode=ccr.uncode) as fopv0,
					(select sum(case when opv0 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '2019-09-01' and uncode=ccr.uncode) as topv0";
		
		print_r($query);exit;
		
		
		/* $distcode = $this->session->District;
		$vaccineId = $data['vaccineId'];
		//$vaccine_name = get_target_vacc_name($vaccineId);
		
		$where = " bcg IS NOT NULL and bcg >= '2019-09-01' AND bcg <= '2019-09-30'";
		switch($vaccineId){
			case 2:
				$where = " hepb IS NOT NULL and hepb >= '2019-09-01' AND hepb <= '2019-09-30'";
				break;
			case 3:
				$where = " (opv0 IS NOT NULL and opv0 >= '2019-09-01' AND opv0 <= '2019-09-30') OR (opv1 IS NOT NULL and opv1 >= '2019-09-01' AND opv1 <= '2019-09-30') OR (opv2 IS NOT NULL and opv2 >= '2019-09-01' AND opv2 <= '2019-09-30') OR (opv3 IS NOT NULL and opv3 >= '2019-09-01' AND opv3 <= '2019-09-30')";
				break;
			case 4:
				$where = " (penta1 IS NOT NULL and penta1 >= '2019-09-01' AND penta1 <= '2019-09-30') OR (penta2 IS NOT NULL and penta2 >= '2019-09-01' AND penta2 <= '2019-09-30') OR (penta3 IS NOT NULL and penta3 >= '2019-09-01' AND penta3 <= '2019-09-30')";
			case 5;
				$where = " (pcv1 IS NOT NULL and pcv1 >= '2019-09-01' AND pcv1 <= '2019-09-30') OR (pcv2 IS NOT NULL and pcv2 >= '2019-09-01' AND pcv2 <= '2019-09-30') OR (pcv3 IS NOT NULL and pcv3 >= '2019-09-01' AND pcv3 <= '2019-09-30')";
			case 6:
				$where = " ipv IS NOT NULL and ipv >= '2019-09-01' AND ipv <= '2019-09-30'";
			case 7: 
				$where = " (rota1 IS NOT NULL and rota1 >= '2019-09-01' AND rota1 <= '2019-09-30') OR (rota2 IS NOT NULL and rota2 >= '2019-09-01' AND rota2 <= '2019-09-30')";
			case 8:
				$where = " (measles1 IS NOT NULL and measles1 >= '2019-09-01' AND measles1 <= '2019-09-30') OR (measles2 IS NOT NULL and measles2 >= '2019-09-01' AND measles2 <= '2019-09-30')";
			default:
				$where = " bcg IS NOT NULL and bcg >= '2019-09-01' AND bcg <= '2019-09-30'";
				break;
		}
		$q = " 
				select 
						b.uncode as code,b.ucname as name,a.child_vaccinated,a.doses_used,a.vial_used,a.openvial_wastagerate,b.path as path 
				from 
						uc_wise_maps_paths b left join 
														(select 
																uwmp.uncode,unname(uwmp.uncode),
																count(*) as child_vaccinated,
																ceil(count(*)//20)*20 as doses_used,
																ceil(count(*)//20) as vial_used,
																((ceil(count(*)//20)*20)-count(*))*100//(ceil(count(*)//20)*20) as openvial_wastagerate, uwmp.path
														from 
																uc_wise_maps_paths uwmp, cerv_child_registration ccr
														where 
																uwmp.uncode=ccr.uncode and uwmp.distcode='{$distcode}' AND 
																{$where}
														group by 
																uwmp.uncode,uwmp.path
														order by 
																uncode asc) as a ON b.uncode=a.uncode where b.distcode='{$distcode}'";
		$result = $this -> db -> query($q) -> result();
		return $result; */
	}
		
	// 2020-03-03  End
	
	public function getPostedData(){
		//print_r($_POST); exit();
		$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';

		$data['fmonthfrom'] 		= ($this -> input -> post('fmonthfrom'))?$this -> input -> post('fmonthfrom'):date('Y-m',strtotime("first day of previous months"));
		$data['fmonthto']  		= ($this -> input -> post('fmonthto'))?$this -> input -> post('fmonthto'):date('Y-m',strtotime("first day of previous months"));
		$data['quarter'] 	= '';
		
		if($this -> session -> District){
			$data['in_out_coverage'] = ($this -> input -> post('in_out_coverage'))?$this -> input -> post('in_out_coverage'):'in_uc';
		}
		else{
			$data['in_out_coverage'] = ($this -> input -> post('in_out_coverage'))?$this -> input -> post('in_out_coverage'):'in_district';
		}
		$data['vaccineId']  = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):'1';
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('vaccineBy'))?$this -> input -> post('vaccineBy'):'total';
		return $data;
	}
	public function getUriSegmentData(){
		if( ! $this -> input -> get('code'))
			$data['id'] = $this -> uri -> segment(4);
		$data['vaccineId']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'1';
		$data['gender']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'Both';
		$data['vaccineBy']  = ($this -> uri -> segment(10))?$this -> uri -> segment(1):'total';
		if($this -> session -> District){
			$data['in_out_coverage'] = ($this -> input -> post('in_out_coverage'))?$this -> input -> post('in_out_coverage'):'in_uc';
		}
		else{
			$data['in_out_coverage'] = ($this -> input -> post('in_out_coverage'))?$this -> input -> post('in_out_coverage'):'in_district';
		}
		$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
		//if($data['reportType'] == 'monthly'){
		$data['fmonthfrom'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y-m',strtotime("first day of previous months"));
		$data['fmonthto']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y-m',strtotime("first day of previous months"));
		$data['year'] = '';
		$data['quarter'] = '';
		$data['biyear'] = '';
		
		return $data;
	}
	public function ajaxCall($data, $viewData){
		//print_r($data);
		$viewData['id'] = $this -> input -> post('map_id');
		$viewData['fmonth'] = $this -> input -> post('fmonth');
		$viewData['colorAxis'] = $this -> colorAxis();
		// $monthQauarterYear = "";
		// $data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		// $monthfromarr = explode('-',$fmonthfrom);
		// $data['monthfrom'] = $monthfrom = $monthfromarr[1];
		// $data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		// $data['fmonthto'] = $fmonthto = $data['fmonthto'];
		// $monthtoarr = explode('-',$fmonthto);
		// $data['monthto'] = $monthto = $monthtoarr[1];
		// $data['yearto'] = $yearto = $monthtoarr[0];

		// $monthnamefrom = monthname($monthfrom); 	
		// $monthnameto = monthname($monthto);

		// if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
		// 	$monthQauarterYear = " {$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
		// 	//$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
		// }
		// else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
		// {
		// 	$monthQauarterYear = "{$monthnamefrom} {$yearfrom}" ;
		// 	//$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
		// } 
		// else {
		// 	$monthQauarterYear = "From {$monthnamefrom} {$yearfrom} To {$monthnameto} {$yearto} " ;
		// 	//$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
		// }

		//print_r($data);exit;
		$vaccCount="";
		/* if($data['vaccineBy']=='Fixed')
		{
			$vaccCount="(Fixed)";
		}elseif($data['vaccineBy']=='Outreach')
		{
			$vaccCount="(Outreach)";
		}elseif($data['vaccineBy']=='Mobile')
		{
			$vaccCount="(Mobile)";
		}elseif($data['vaccineBy']=='LHW')
		{
			$vaccCount="(LHW)";
		} */
		$viewData['heading']['mapName'] = $data['heading']['mapName'].$vaccCount;
		$viewData['heading']['barName'] = $data['heading']['barName'].$vaccCount;
		$viewData['heading']['subtittle'] = $data['heading']['subtittle'];
		$viewData['heading']['run'] = $data['heading']['run'];
		$parameters['vaccineBy'] = $data['vaccineBy'];
		$viewData['ajax'] = TRUE;
		$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
		$viewData['id'] = $this -> input -> post('bar_id');
		if($data['vaccineBy'] =="total")
			$bar = $this -> load -> view('thematic_maps/parts_view/stackbar_graph', $viewData, TRUE);
		else
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
		$arr = array('map' => $map, 'bar' => $bar, 'otherParameters' => $parameters);
		echo json_encode($arr);
		exit();
	}
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			$data = $this -> getUriSegmentData();
			//$distcode = $data['id'];
			$districtName = $this->maps->districtName($data['id']);
			$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');
			$monthQauarterYear = "";
			$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
			$monthfromarr = explode('-',$fmonthfrom);
			$data['monthfrom'] = $monthfrom = $monthfromarr[1];
			$data['yearfrom'] = $yearfrom = $monthfromarr[0];
			
			$data['fmonthto'] = $fmonthto = $data['fmonthto'];
			$monthtoarr = explode('-',$fmonthto);
			$data['monthto'] = $monthto = $monthtoarr[1];
			$data['yearto'] = $yearto = $monthtoarr[0];

			$monthnamefrom = monthname($monthfrom); 	
			$monthnameto = monthname($monthto);

			if ($yearfrom == $yearto && $monthnamefrom != $monthnameto){
				$monthQauarterYear = " {$monthnamefrom} to {$monthnameto}, {$yearfrom}" ;
				//$data['hovermap'] = " Year: <b>{$yearfrom}, From {$monthnamefrom} to {$monthnameto}</b>";
			}
			else if ($yearfrom == $yearto && $monthnamefrom == $monthnameto)
			{
				$monthQauarterYear = "{$monthnamefrom} {$yearfrom}" ;
				//$data['hovermap'] = " Fmonth: <b>{$fmonthfrom}</b>";
			} 
			else {
				$monthQauarterYear = "From {$monthnamefrom} {$yearfrom} To {$monthnameto} {$yearto} " ;
				//$data['hovermap'] = "Start Fmonth: <b>{$fmonthfrom}</b><br>End Fmonth: <b>{$fmonthto}</b>";
			}
			//print_r($data); exit();
			$data['heading']['mapName'] = "UC Wise {$vaccinesArray[$data['vaccineId']-1]} Coverage, {$districtName}, {$monthQauarterYear}";
			$data['heading']['run'] = true;
			$viewData['serieses'] = $this -> getSeriesData($data);
			$data['colorAxis'] = $this -> colorAxis('uc');
			$data['indicators'][] = $this -> getVaccinationByWiseData($data);
			$data['indicators'][] = $this -> getIndicatorData($data);
			$result = $this -> getRankingSeriesData($data);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			$data['heading']['barName'] = "UC Wise {$vaccinesArray[$data['vaccineId']-1]} Coverage, {$districtName} {$monthQauarterYear}";
			$data['heading']['subtittle'] = $this -> session -> provincename;
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['ajax'] = (isset($data['ajax']) && $data['ajax'] == true)?TRUE:FALSE;
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'AccessToHealthServices';
			$viewData['fileToLoad'] = 'thematic_maps/access_to_thematic_health_services';
			$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
			$this->load->view('thematic_template/thematic_template',$viewData);
		}
		else{
		}		
	}
	
	public function getSeriesData($data){
		$selectQuery = (isset($data['ajax']) && $data['ajax'] == true)?$this -> getQuerySelectPortion($data):$this -> getCoverageQuerySelectPortion($data);
		$in_out_coverage = $data['in_out_coverage'];
		if($in_out_coverage == 'total_districts'){
			$parts = explode('-::-', $selectQuery);
			$selectQuery = $parts[0];
			$selectQuery1 = $parts[1];
		}
		$name = 'District';
		if($this -> session -> District || $this -> input -> post('id') || ($this -> uri -> segment(4) && strlen($this -> uri -> segment(4)) == 3))
		{
			$coverageData = $this -> maps -> getUCsVaccineCoverage($data, $selectQuery);
			$name = 'UC';
		}
		else
		{
			if($in_out_coverage == 'total_districts'){
				$coverageData = $this -> maps -> getVaccineCoverage($data, $selectQuery, '',$selectQuery1);
			}
			else{
				$coverageData = $this -> maps -> getVaccineCoverage($data, $selectQuery);
			}
		}
		$serieses = array();
		$dataSeries = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Coverage";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> sum != "" && $row -> sum > 0)?$row -> sum:0.1;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
	
	public function getRankingSeriesData($data){
		//print_r($data);exit();
		/* $selectQuery = (isset($data['ajax']) && $data['ajax'] == true)?$this -> getQuerySelectPortion($data):$this -> getCoverageQuerySelectPortion($data);
		$name = 'District';
		/* if($this -> session -> District || $this -> input -> post('id') || ($this -> uri -> segment(4) && strlen($this -> uri -> segment(4)) == 3)){
			$coverageData = $this -> maps -> getUCsVaccineCoverage($data, $selectQuery, 'yes');
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getVaccineCoverage($data, $selectQuery, 'yes');
		}  */
		$coverageData = $this -> setQueryPortion($data,'No');
		$serieses = array();
		$result = array();
		$serieses1 = array();
		$dataSeries1 = array();
		$i=0;
		$serieses['name'] = " Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			if(isset($data['ajax']) && $data['vaccineBy'] !="total"){
				$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['y'] = $row -> sum;
				if($row -> sum >= 95)
					$serieses['data'][$i]['color'] = "#50eb35 ";
				else if($row -> sum <= 94.99 && $row -> sum >= 90)
					$serieses['data'][$i]['color'] = "#3366ff";
				else if($row -> sum <= 89.99 && $row -> sum >= 80)
					$serieses['data'][$i]['color'] = "#FFFF00";
				else if($row -> sum <= 79.99 && $row -> sum >= 50)
					$serieses['data'][$i]['color'] = "#FF8C00";
				else if($row -> sum < 50)
					$serieses['data'][$i]['color'] = "#DD1E2F";
			}else{
				$total = ((int)$row -> fixd+(int)$row -> outrech+(int)$row -> mobile+(int)$row -> lhw);
				$dataSeries1[$i] = array($row -> name);
				//$fixd[$i]= (int)$row -> fixd;
				$fixd[$i]= (object)["y"=>(int)$row -> fixd,"id"=>$row -> code,"color" => "#0B7546"];
				$outrech[$i]= (object)["y"=>(int)$row -> outrech,"id"=>$row -> code,"color" => "#3366FF"];
				$mobile[$i]= (object)["y"=>(int)$row -> mobile,"id"=>$row -> code,"color" => "#EBB035"];
				$lhw[$i]= (object)["y"=>(int)$row -> lhw,"id"=>$row -> code,"color" => "#DD1E2F"];
			}
			$i++;
		}
		if(isset($data['ajax']) && $data['vaccineBy']!="total"){
			$dataSeries = array();
			array_push($dataSeries,$serieses);
			array_push($dataSeries1,$serieses1);
		}else{
			$dataSeries = array(
						array("name"=>"Fixed","data"=>$fixd,"index"=>"4","color" => "#0B7546"),
						array("name"=>"Outrech","data"=>$outrech,"index"=>"3","color" => "#3366FF"),
						array("name"=>"Mobile","data"=>$mobile,"index"=>"2","color" => "#EBB035"),
						array("name"=>"LHW","data"=>$lhw,"index"=>"1","color" => "#DD1E2F")
						);
		}
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
		return $result;
	}	
	
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	
	public function getCoverageQuerySelectPortion($data){
		$vaccineId = $data['vaccineId'];
		$in_out_coverage = $data['in_out_coverage'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$data['monthfrom'] = $monthfrom = $monthfromarr[1];
		$data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$data['fmonthto'] = $fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$data['monthto'] = $monthto = $monthtoarr[1];
		$data['yearto'] = $yearto = $monthtoarr[0];
		$denom = getDenominatorFromTo($vaccine_name,$yearfrom,$monthfrom,"Yes",$monthto,$yearto);
			
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,COALESCE((select ";
			$denom = str_replace("distcode","unioncouncil.uncode",$denom);
			$denom = str_replace("district","unioncouncil",$denom);
		}
		else{
			$q = " districts.distcode as code,districts.district as name,COALESCE((select ";
			$od = " districts.distcode as code,districts.district as name,COALESCE((select ";
			$denom = str_replace("distcode","districts.distcode",$denom);
		}
		
		$q .= "round((((";
		if($data['gender'] == "Male"){
			if($data['vaccineBy'] == "Fixed"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
					$od .= " sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
					$od .= " sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
					$od .= " sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
			}
			else{
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
			}
		}
		else if($data['gender'] == "Female"){
			if($data['vaccineBy'] == "Fixed"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
					$od .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
					$od .= " sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
					$od .= " sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
			else{
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
		}
		else{ // if male and female both data is required
			if($data['vaccineBy'] == "Fixed"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r2_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r5_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r2_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r5_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r7_f$vaccineId)+sum(od_r8_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r11_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
					$od .= " sum(od_r7_f$vaccineId)+sum(od_r8_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r11_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r13_f$vaccineId)+sum(od_r14_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r17_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
					$od .= " sum(od_r13_f$vaccineId)+sum(od_r14_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r17_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r19_f$vaccineId)+sum(od_r20_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r23_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r19_f$vaccineId)+sum(od_r20_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r23_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
			else{
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId)
							+sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId)
							+sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
		}
		if($in_out_coverage == 'in_uc' || $in_out_coverage == 'in_district'){
			if($data['gender'] == "Male"){
				$q .= ")*100/(((NULLIF($denom,0))*51)/100)))) ";
			}
			else if($data['gender'] == "Female"){
				$q .= ")*100/(((NULLIF($denom,0))*49)/100)))) ";
			}
			else{
				$q .= ")*100/NULLIF($denom,0)))) ";
			}
		}
		else{
			if($data['gender'] == "Male"){
				$q .= ")))) ";
			}
			else if($data['gender'] == "Female"){
				$q .= ")))) ";
			}
			else{
				$q .= ")))) ";
			}
		}
		
		if($data['in_out_coverage'] == 'out_district'){
			$q .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		elseif($data['in_out_coverage'] == 'total_districts'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
			$od .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		else{
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			if($data['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_od_db.distcode='".$code."' group by fac_mvrf_od_db.uncode),0) as sum ";
			}
			elseif($data['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
				$od .= " and fac_mvrf_od_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_od_db.distcode='".$code."' group by fac_mvrf_od_db.uncode),0) as sum ";
			}
			else{
				$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
			}
		}
		else{
			if($data['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.distcode=districts.distcode),0) as sum ";
			}
			elseif($data['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
				$od .= " and fac_mvrf_od_db.distcode=districts.distcode),0) as sum ";
			}
			else{
				$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
			}
		}
		if($data['in_out_coverage'] == 'total_districts'){
			return $q.'-::-'.$od;
			//return $od;
		}
		else{
			return $q;
		}
	}
	/* New function by Uzair for getting Vaccination-by wise Vaccines count  */
	public function getQuerySelectPortion($data){
		$vaccineId = $data['vaccineId'];
		$in_out_coverage = $data['in_out_coverage'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$od="";
		$data['month']=isset($data['month'])?$data['month']:NULL;
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,COALESCE((select ";
		}
		else{
			$q = " districts.distcode as code,districts.district as name,COALESCE((select ";
			$d = " districts.distcode as code,districts.district as name,COALESCE((select ";
		}
		$q .= "round((";
		if($data['gender'] == "Male"){
			if($data['vaccineBy'] == "Fixed"){
				//$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				//$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId) ";
					$od .= " sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				//$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId) ";
					$od .= " sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				//$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
					$od .= " sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
			}
			else{
				// $q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
				// 		+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
				// 		+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
				// 		+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}				
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				}
			}
		}else if($data['gender'] == "Female"){
			if($data['vaccineBy'] == "Fixed"){
				//$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
					$od .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				//$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
					$od .= " sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				//$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
					$od .= " sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				//$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
			else{
				// $q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
				// 		+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
				// 		+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
				// 		+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
		}
		else{ // if male and female both data is required
			if($data['vaccineBy'] == "Fixed"){
				//$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r2_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r5_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId)+sum(oui_r1_f$vaccineId)+sum(oui_r2_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r5_f$vaccineId)+sum(oui_r6_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r2_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r5_f$vaccineId)+sum(od_r6_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Outreach"){
				//$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r7_f$vaccineId)+sum(od_r8_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r11_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId)+sum(oui_r7_f$vaccineId)+sum(oui_r8_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r11_f$vaccineId)+sum(oui_r12_f$vaccineId) ";
					$od .= " sum(od_r7_f$vaccineId)+sum(od_r8_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r11_f$vaccineId)+sum(od_r12_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "Mobile"){
				//$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r13_f$vaccineId)+sum(od_r14_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r17_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId)+sum(oui_r13_f$vaccineId)+sum(oui_r14_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r17_f$vaccineId)+sum(oui_r18_f$vaccineId) ";
					$od .= " sum(od_r13_f$vaccineId)+sum(od_r14_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r17_f$vaccineId)+sum(od_r18_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				}
			}
			else if($data['vaccineBy'] == "LHW"){
				//$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r19_f$vaccineId)+sum(od_r20_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r23_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId)+sum(oui_r19_f$vaccineId)+sum(oui_r20_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r23_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r19_f$vaccineId)+sum(od_r20_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r23_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
			else{
				// $q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
				// 		+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
				// 		+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
				// 		+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
				// 		+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
				// 		+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
				// 		+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
				// 		+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($data['in_out_coverage'] == 'in_uc'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_uc'){
					$q .= " sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'out_district'){
					$q .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId)
							+sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				elseif($data['in_out_coverage'] == 'total_districts'){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId)
							+sum(oui_r1_f$vaccineId)+sum(oui_r3_f$vaccineId)+sum(oui_r5_f$vaccineId)
							+sum(oui_r7_f$vaccineId)+sum(oui_r9_f$vaccineId)+sum(oui_r11_f$vaccineId)
							+sum(oui_r13_f$vaccineId)+sum(oui_r15_f$vaccineId)+sum(oui_r17_f$vaccineId)
							+sum(oui_r19_f$vaccineId)+sum(oui_r21_f$vaccineId)+sum(oui_r23_f$vaccineId)
							+sum(oui_r2_f$vaccineId)+sum(oui_r4_f$vaccineId)+sum(oui_r6_f$vaccineId)
							+sum(oui_r8_f$vaccineId)+sum(oui_r10_f$vaccineId)+sum(oui_r12_f$vaccineId)
							+sum(oui_r14_f$vaccineId)+sum(oui_r16_f$vaccineId)+sum(oui_r18_f$vaccineId)
							+sum(oui_r20_f$vaccineId)+sum(oui_r22_f$vaccineId)+sum(oui_r24_f$vaccineId) ";
					$od .= " sum(od_r1_f$vaccineId)+sum(od_r3_f$vaccineId)+sum(od_r5_f$vaccineId)
							+sum(od_r7_f$vaccineId)+sum(od_r9_f$vaccineId)+sum(od_r11_f$vaccineId)
							+sum(od_r13_f$vaccineId)+sum(od_r15_f$vaccineId)+sum(od_r17_f$vaccineId)
							+sum(od_r19_f$vaccineId)+sum(od_r21_f$vaccineId)+sum(od_r23_f$vaccineId)
							+sum(od_r2_f$vaccineId)+sum(od_r4_f$vaccineId)+sum(od_r6_f$vaccineId)
							+sum(od_r8_f$vaccineId)+sum(od_r10_f$vaccineId)+sum(od_r12_f$vaccineId)
							+sum(od_r14_f$vaccineId)+sum(od_r16_f$vaccineId)+sum(od_r18_f$vaccineId)
							+sum(od_r20_f$vaccineId)+sum(od_r22_f$vaccineId)+sum(od_r24_f$vaccineId) ";
				}
				else{
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
							+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
							+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
							+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId)
							+sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
							+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
							+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
							+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				}
			}
		}
		if($data['gender'] == "Male"){
			$q .= ")) ";
			$od .= ")) ";
		}
		else if($data['gender'] == "Female"){
			$q .= ")) ";
			$od .= ")) ";
		}
		else{
			$q .= ")) ";
			$od .= ")) ";
		}
		//if($data['reportType'] == 'monthly'){
		if($data['in_out_coverage'] == 'out_district'){
			$q .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		elseif($data['in_out_coverage'] == 'total_districts'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
			$od .= " from fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		else{
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			if($data['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_od_db.distcode='".$code."' group by fac_mvrf_od_db.uncode),0) as sum ";
				
			}
			elseif($data['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
				$od .= " and fac_mvrf_od_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_od_db.distcode='".$code."' group by fac_mvrf_od_db.uncode),0) as sum ";
			}
			else{
				$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
			}
		}
		else{
			if($data['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.distcode=districts.distcode),0) as sum ";
			}
			elseif($data['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
				$od .= " and fac_mvrf_od_db.distcode=districts.distcode),0) as sum ";
			}
			else{
				$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
			}
		}
		if($data['in_out_coverage'] == 'total_districts'){
			return $q;
			return $od;
		}
		else{
			return $q;
		}
	}
	public function setQueryPortion($data,$series='No'){
		$vaccine_name = get_target_vacc_name($data['vaccineId']);
		$col = "cri";
		/* if($data['in_out_coverage'] =="out_district"){
			$col = "oui";
		} */
		$var='';
		$fixed = $outrech = $lhw = $mobile  = "";
		for ($i=1; $i<=24; $i++){
			if($i%2 != 0 && $data['gender']=="Male"){ ///for male
					if($i < 7){
					$fixed .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>6 && $i <13){
					$outrech .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>12 && $i <19){
					$mobile .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>18 && $i <25){
					$lhw .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}
			}else if($i%2 == 0 && $data['gender']=="Female"){ ///for female
				if($i < 7){
					$fixed .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>6 && $i <13){
					$outrech .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>12 && $i <19){
					$mobile .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}else if($i>18 && $i <25){
					$lhw .= "{$col}_r{$i}_f{$data['vaccineId']}+";
				}
			}else{
				if($data['gender']=="Both" || $data['gender']=="all"){
					if($i < 7){
						$fixed .= "{$col}_r{$i}_f{$data['vaccineId']}+";
					}else if($i>6 && $i <13){
						$outrech .= "{$col}_r{$i}_f{$data['vaccineId']}+";
					}else if($i>12 && $i <19){
						$mobile .= "{$col}_r{$i}_f{$data['vaccineId']}+";
					}else if($i>18 && $i <25){
						$lhw .= "{$col}_r{$i}_f{$data['vaccineId']}+";
					}
				}
			}
		}
		$data['fixed'] = rtrim($fixed,'+');
		$data['outrech'] = rtrim($outrech,'+');
		$data['mobile'] = rtrim($mobile,'+');
		$data['lhw'] = rtrim($lhw,'+');
		$selectpart = $this->getoutinData($data);
		$return = $this->maps->getSeriesedata($selectpart);
		return $return;
	}
	public function getoutinData($data,$series='No'){
		$vaccine_name = get_target_vacc_name($data['vaccineId']);
		$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$data['monthfrom'] = $monthfrom = $monthfromarr[1];
		$data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$data['fmonthto'] = $fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$data['monthto'] = $monthto = $monthtoarr[1];
		$data['yearto'] = $yearto = $monthtoarr[0];
	
		$denom = getDenominatorFromTo($vaccine_name,$yearfrom,$monthfrom,"Yes",$monthto,$yearto);
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$denom = str_replace("distcode","unioncouncil.uncode",$denom);
			if(strpos($denom, 'unioncouncil.uncode') == false){
				$denom = str_replace("uncode","unioncouncil.uncode",$denom);
			}
			$denom = str_replace("district","unioncouncil",$denom);
			$selectpartlevel = " unioncouncil.uncode as code,unioncouncil.un_name as name,";
			$table = "unioncouncil";
			$joinspart = " left join fac_mvrf_db  on unioncouncil.uncode=fac_mvrf_db.uncode
			";
			$groupbypart = " where unioncouncil.distcode='{$data['id']}' group by unioncouncil.uncode,unioncouncil.un_name";
		}
		else{
			$denom = str_replace("distcode","districts.distcode",$denom);
			$selectpartlevel = " districts.distcode as code,districts.district as name,";
			$table = "districts";
			$joinspart = " left join fac_mvrf_db on districts.distcode=fac_mvrf_db.distcode";
			$groupbypart = "group by districts.distcode,districts.district";
		}
		$formula = "*100/NULLIF($denom::numeric,0)";
		if(isset($data['ajax']) && $data['ajax']){
			$formula="";
		}
		if(isset($data['ajax']) && $data['ajax'] && $data['vaccineBy']!='total' && $series !="Yes" ){
			if($data['vaccineBy']=='Fixed'){
				$categorypart = $data['fixed'];
			}else if($data['vaccineBy']=='Outreach'){
				$categorypart = $data['outrech'];
			}else if($data['vaccineBy']=='Mobile'){
				$categorypart = $data['mobile'];
			}else if($data['vaccineBy']=='LHW'){
				$categorypart = $data['lhw'];
			}
			$selectpart=$categorypart;
			if($data['in_out_coverage']=='out_district'){
				$selectpart =  str_replace('cri','oui',$categorypart);
			}else if($data['in_out_coverage']=='total_districts'){
				$selectpart =  $categorypart."+".str_replace('cri','oui',$categorypart);
			}
			$query = "select {$selectpartlevel} coalesce(sum({$selectpart}),0) as sum
				from {$table} {$joinspart} 
				and fac_mvrf_db.fmonth >= '{$data['fmonthfrom']}' and fac_mvrf_db.fmonth <= '{$data['fmonthto']}' {$groupbypart} order by sum desc";
		}else{
			$selectpart = $data;
			if($data['in_out_coverage']=='out_district' || $data['in_out_coverage']=='out_uc'){
				$selectpart['fixed'] = str_replace('cri','oui',$data['fixed']);
				$selectpart['outrech'] = str_replace('cri','oui',$data['outrech']);
				$selectpart['mobile'] = str_replace('cri','oui',$data['mobile']);
				$selectpart['lhw'] = str_replace('cri','oui',$data['lhw']);
			}else if($data['in_out_coverage']=='total_districts' || $data['in_out_coverage']=='total_ucs'){
				$selectpart['fixed'] = $data['fixed']."+".str_replace('cri','oui',$data['fixed']);
				$selectpart['outrech'] = $data['outrech']."+".str_replace('cri','oui',$data['outrech']);
				$selectpart['mobile'] = $data['mobile']."+".str_replace('cri','oui',$data['mobile']);
				$selectpart['lhw'] = $data['lhw']."+".str_replace('cri','oui',$data['lhw']);
			}
			$innerquery= "select {$selectpartlevel} coalesce(round(sum({$selectpart['fixed']}) {$formula}),0) as fixd, coalesce(round(sum({$selectpart['outrech']}) {$formula}),0) as outrech,coalesce(round(sum({$selectpart['mobile']}) {$formula}),0) as mobile,coalesce(round(sum({$selectpart['lhw']}) {$formula}),0) as lhw 
			from {$table}
			{$joinspart}
			and fac_mvrf_db.fmonth >= '{$data['fmonthfrom']}' and fac_mvrf_db.fmonth <= '{$data['fmonthto']}' {$groupbypart} ";
			
			$query ="select code,name,coalesce(sum(fixd+outrech+mobile+lhw),0) as sume,fixd,outrech,mobile,lhw from ({$innerquery}) as b group by code,name,fixd,outrech,mobile,lhw order by sume desc
			";
		} //print_r($query);exit();
		return $query;
	}
	public function getIndicatorData($data){
		$data['fmonthfrom'] = $fmonthfrom = $data['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$data['monthfrom'] = $monthfrom = $monthfromarr[1];
		$data['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$data['fmonthto'] = $fmonthto = $data['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$data['monthto'] = $monthto = $monthtoarr[1];
		$data['yearto'] = $yearto = $monthtoarr[0];
		$vaccineId = $data['vaccineId'];
		$in_out_coverage = $data['in_out_coverage'];
		$vaccine_name = get_target_vacc_name($vaccineId);
	
		$denom = getDenominatorFromTo($vaccine_name,$yearfrom,$monthfrom,"Yes",$monthto,$yearto);
		if((isset($data['id']) && $data['id'] > 0) || $this -> session -> District){
			$q = "select ";
			$denom = str_replace("distcode","'".$data['id']."'",$denom);
			$denom = str_replace("uncode","'".$data['id']."'",$denom);
			$denom = str_replace("unioncouncil","district",$denom);
		}
		else{
			$q = " select ";
			$od = " select ";
			$denom = str_replace("distcode","{$this->session->Province}",$denom);
			$denom = str_replace("district","province",$denom);
		}
		//print_r($denom);exit;
		if($data['in_out_coverage'] == 'in_uc'){
			$q .= " sum(cri_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}
		elseif($data['in_out_coverage'] == 'out_uc'){
			$q .= " sum(oui_r25_f$vaccineId) as mVac , sum(oui_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}
		elseif($data['in_out_coverage'] == 'total_ucs' || $data['in_out_coverage'] == 'in_district'){
			$q .= " sum(cri_r25_f$vaccineId+oui_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId+oui_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}
		elseif($data['in_out_coverage'] == 'out_district'){
			$q .= " sum(od_r25_f$vaccineId) as mVac , sum(od_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}
		elseif($data['in_out_coverage'] == 'total_districts'){
			$q .= " sum(cri_r25_f$vaccineId+oui_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId+oui_r26_f$vaccineId) as fVac, round($denom,0) as target";
			$od .= " sum(od_r25_f$vaccineId) as mVac , sum(od_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}
		else{
			$q .= " sum(cri_r25_f$vaccineId+oui_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId+oui_r26_f$vaccineId) as fVac, round($denom,0) as target";
		}

		//if($data['reportType'] == 'monthly'){
		if($data['in_out_coverage'] == 'out_district'){
			$q .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "' ";
		}
		elseif($data['in_out_coverage'] == 'total_districts'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
			$od .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $data['fmonthto'] . "' ";
		}
		else{
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $data['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $data['fmonthto'] . "'";
		}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			if($data['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.distcode='".$code."' ";
			}
			elseif($data['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.distcode='".$code."' ";
				$od .= " and fac_mvrf_od_db.distcode='".$code."' ";
			}
			else{
				$q .= " and fac_mvrf_db.distcode='".$code."' ";
			}
		}
		else{
			if($data['in_out_coverage'] == 'out_district'){
				$q .= "";
				$od .= "";
			}
			else{
				$q .= "";
			}
		}		
		$result1 = $this -> maps -> getTargetAndCoverageData($data,$q);
		//print_r($q);exit();
		foreach ($result1 as $key => $value) {
			foreach ($value as $key1 => $value1) {
				$result[$key1] = $value1;
			}
		}
		return $result;
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
	
	public function colorAxis($map='dist'){		
		if(($this -> input -> post('ajax') && $this -> input -> post('ajax')==true) || $this -> input -> post('in_out_coverage') == 'out_uc' || $this -> input -> post('in_out_coverage') == 'total_ucs' || $this -> input -> post('in_out_coverage') == 'out_district' || $this -> input -> post('in_out_coverage') == 'total_districts'){
			$dataClasses['min'] = 1;
			$dataClasses['minColor'] = '#DD1E2F';
			$dataClasses['maxColor'] = '#0B7546';
			$dataClasses['max'] = ($map=='dist')?10000:1000;
			$dataClasses['type'] = 'logarithmic';
		}
		else{
			$dataClasses['dataClasses'][0]['from'] = '95';
			$dataClasses['dataClasses'][0]['to'] = '1000';
			$dataClasses['dataClasses'][0]['color'] = '#50eb35 ';
			$dataClasses['dataClasses'][0]['name'] = '>=95%';

			$dataClasses['dataClasses'][1]['from'] = '90';
			$dataClasses['dataClasses'][1]['to'] = '94.99';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '90-94%';

			$dataClasses['dataClasses'][2]['from'] = '80';
			$dataClasses['dataClasses'][2]['to'] = '89.99';
			$dataClasses['dataClasses'][2]['color'] = '#FFFF00';
			$dataClasses['dataClasses'][2]['name'] = '80-89%';

			$dataClasses['dataClasses'][3]['from'] = '50';
			$dataClasses['dataClasses'][3]['to'] = '79.99';
			$dataClasses['dataClasses'][3]['color'] = '#FF8C00';
			$dataClasses['dataClasses'][3]['name'] = '50-79%';
			
			$dataClasses['dataClasses'][4]["from"] = '0';
			$dataClasses['dataClasses'][4]["to"] = '49.99';
			$dataClasses['dataClasses'][4]["color"] = '#e3330d';
			$dataClasses['dataClasses'][4]["name"] = '< 50%';
		}
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	
	public function getVaccinationByWiseData($params){
		$vaccineId = $params['vaccineId'];
		$in_out_coverage = $params['in_out_coverage'];
		//echo $in_out_coverage;exit;
		//print_r($params);exit;
		$vaccine_name = get_target_vacc_name($vaccineId);
		$params['month']=isset($params['month'])?$params['month']:NULL;
		$vaccinationByArray = array('fixed','outreach','mobile','healthhouse','total');
		$q = "select ";$od = "select ";$i=1;
		foreach($vaccinationByArray as $key => $val){
			if($val=='total'){
				for($m=1;$m<=24;$m++){
					if($params['gender'] == "Male" && $m%2 != 0){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
							$od .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
					}
					else if($params['gender'] == "Female" && $m%2 == 0){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
							$od .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
					}
					else if($params['gender'] == 'Both' || $params['gender'] == 'All'){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
							$od .= "sum(od_r{$m}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
						}
					}
				}
			}
			else{
				for($i;$i<=24;$i++){
					if($params['gender'] == "Male" && $i%2 != 0){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
							$od .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
					}
					else if($params['gender'] == "Female" && $i%2 == 0){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
							$od .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
					}
					else if($params['gender'] == 'Both' || $params['gender'] == 'All'){
						if($params['in_out_coverage'] == 'in_uc'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_uc'){
							$q .= "sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_ucs' || $params['in_out_coverage'] == 'in_district'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'out_district'){
							$q .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						elseif($params['in_out_coverage'] == 'total_districts'){
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
							$od .= "sum(od_r{$i}_f{$vaccineId})+";
						}
						else{
							$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
						}
					}
					if($i%6==0){ break; }
				}
			}
			if($params['in_out_coverage'] == 'total_districts'){
				$q = rtrim($q,'+');
				$od = rtrim($od,'+');
				$q .= " as {$val}vaccination, ";
				$od .= " as {$val}vaccination, ";
			}
			else{
				$q = rtrim($q,'+');
				$q .= " as {$val}vaccination, ";
			}
			$i++;
		}
		$q = rtrim($q,', ');
		if($params['in_out_coverage'] == 'out_district'){
			$q .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $params['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $params['fmonthto'] . "'";
		}
		elseif($params['in_out_coverage'] == 'total_districts'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $params['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $params['fmonthto'] . "'";
			$od .= " from fac_mvrf_od_db where fac_mvrf_od_db.fmonth >= '" . $params['fmonthfrom'] . "' and fac_mvrf_od_db.fmonth <= '" . $params['fmonthto'] . "'";
		}
		else{
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $params['fmonthfrom'] . "' and fac_mvrf_db.fmonth <= '" . $params['fmonthto'] . "'";
		}
		
		if((isset($params['id']) && $params['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($params['id']) && $params['id']>0)
				$code = $params['id'];
			if($params['in_out_coverage'] == 'out_district'){
				$q .= " and fac_mvrf_od_db.distcode='".$code."' ";
			}
			elseif($params['in_out_coverage'] == 'total_districts'){
				$q .= " and fac_mvrf_db.distcode='".$code."' ";
				$od .= " and fac_mvrf_od_db.distcode='".$code."' ";
			}
			else{
				$q .= " and fac_mvrf_db.distcode='".$code."' ";
			}
		}
		else{
			if($params['in_out_coverage'] == 'total_districts'){
				$q .= "";
				$od .= "";
			}
			else{
				$q .= "";
			}			
		}
		$result = $this -> db -> query($q) -> result_array();
		return $result[0];
	}
	
	public function getUC_detailData(){
		//print_r($_POST);
		$newbornArrray = array('bcg','hepb','opv0');
		$surviningArrray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv1','rota1','rota2','measles1','fullyimmunized','measles2','dtp','tcv','ipv2');
		
		$parametersData['in_out_coverage'] = $in_out_coverage = $this -> input -> post('in_out_coverage');
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['procode'] = $procode = ($this -> input -> post('procode'))?$this -> input -> post('procode'):NULL;
		$parametersData['uncode'] = $uncode = ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):NULL;
		$parametersData['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):NULL;
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['fmonthfrom'] = $fmonthfrom = $this -> input -> post('fmonthfrom');
		$parametersData['fmonthto'] = $fmonthto = $this -> input -> post('fmonthto');
		
		$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $fmonthfrom . "' and fmonth <= '" . $fmonthto . "'";

		$viewData = $parametersData;
		/* Summary View Data */
		if(isset($parametersData['month'])){ $parametersData['month']=$parametersData['month'];}else{ $parametersData['month']="";}
			$summaryData = $this -> ucSummary($parametersData);
		if($services)
		{
			$summaryData['services'] = $services;
		}else{
			$summaryData['services'] = "outreach";
		}
		$summaryData['monthly_yearly_target'] = $coverageData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
		$viewData['summary'] = $this -> load -> view('thematic_maps/parts_view/ucsummary', $summaryData, TRUE);
		/* Coverage Tab data */
		$coverageData = $this -> ucCoverage($parametersData);
		/* set data array from summary data array to be used in coverage tab */
		$coverageData['sessionPlannedHeld'] = $summaryData['sessionPlannedHeld'];
		$coverageData['vaccinationNumbers'] = $summaryData['vaccinationNumbers'];
		$coverageData['vaccineId'] = $summaryData['vaccineId'];
		$coverageData['monthlyTarget'] = $summaryData['monthlyTarget'];
		$coverageData['productsNameArray'] = $summaryData['productsNameArray'];
		$coverageData['productsArray'] = $summaryData['productsArray'];
		$viewData['coverage'] = $this -> load -> view('thematic_maps/parts_view/uccoverage', $coverageData, TRUE);
		/* Consumption View Data */
		$consumptionData = $this -> ucConsumption($parametersData);
		$consumptionData['openvialWastageRate'] = $summaryData['openvialWastageRate'];
		$consumptionData['closedvialWastageRate'] = $summaryData['closedvialWastageRate'];
		$viewData['consumption'] = $this -> load -> view('thematic_maps/parts_view/ucconsumption', $consumptionData, TRUE);
		$dropoutData = $this -> ucDropout($parametersData);
		$viewData['dropout'] = $this -> load -> view('thematic_maps/parts_view/ucdropout', $dropoutData, TRUE);
		$surveillanceData = $this -> ucSurveillance($parametersData);
		$viewData['surveillance'] = $this -> load -> view('thematic_maps/parts_view/ucsurveillance', $surveillanceData, TRUE);
		//$covidData = $this -> ucCovid19();
		//$viewData['covid'] = $this -> load -> view('thematic_maps/parts_view/uccovid', $covidData, TRUE);
		$attendenceData = $this -> ucAttendence($parametersData);
		$viewData['attendence'] = $this -> load -> view('thematic_maps/parts_view/ucattendence', $attendenceData, TRUE);
		$viewData['activeClass'] ="coverage";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	
	public function ucSummary($parametersData){
		//print_r($parametersData);exit();
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];

		$data['productsArray'] = $productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv1',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2',19=>'dtp',20=>'tcv',21=>'ipv2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV-1',14=>'Rota-1',15=>'Rota-2',16=>'MR-I',17=>'Fully Immunized',18=>'MR-II',19=>'DTP','20'=>'TCV',21=>'IPV-2');
		$data['vaccineId'] = $vaccineId = $parametersData['vaccineId'];
		$data['sessionPlannedHeld'] = sessionPlannedHeld($parametersData['rangeCondition'],$parametersData['uncode'],'',$parametersData['distcode']);
		$data['vaccinationNumbers'] = vaccinationInNumbers($parametersData['rangeCondition'],$parametersData['uncode'],NULL,$parametersData['vaccineId'],NULL,$parametersData['distcode']);//print_r($data['vaccinationNumbers']);
		$data['totalVaccinationNumbers'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'both',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersMale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'male',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersFemale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'female',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$code="";
		$type="";
		if((isset($parametersData['procode']) && $parametersData['procode']!=null)){
			$code=$parametersData['procode'];
			$type="Province : Khyber Pakhtunkhwa";
			$type1=", Khyber Pakhtunkhwa";
		}
		if((isset($parametersData['uncode']) && $parametersData['uncode']!=null)){
			$code=$parametersData['uncode'];
			$type="Union council : ".get_UC_Name($code);
			$type1=", ".get_UC_Name($code);
		}
		if((isset($parametersData['distcode']) && $parametersData['distcode']!=null)){
			$code=$parametersData['distcode'];
			$type="District : ".get_District_Name($code);
			$type1=", ".get_District_Name($code);
		}
		$data['distYear']=" For ".$type." , Year : ".$parametersData['yearto'];
		$data['distYear1'] = $type1.", Year-".$parametersData['yearto'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['yearto'],$parametersData['vaccineId']);				
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['yearto'],$parametersData['month'],$productsArray[$vaccineId]);
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['procode']);//print_r($data['monthlyVaccinationTrendAllDisease']);exit;
		$data['monthlyVaccinationTrendForfullyimmunized'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],'17',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['procode']);
		$data['monthlyVaccinationTrendForTT'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],'TT1-TT2',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['procode']);
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'fixed',$parametersData['procode']);
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'or',$parametersData['procode']);
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'hh',$parametersData['procode']);
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1',$parametersData['procode']);
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3',$parametersData['procode']);
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2',$parametersData['procode']);
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2',$parametersData['procode']);
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1',$parametersData['procode']);
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2',$parametersData['procode']);
		/* $consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year'],$parametersData['procode']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year'],$parametersData['procode']);
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year'],$parametersData['procode']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year'],$parametersData['procode']); */
		//change consumption functions / table to  new format for KP 
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		/****change consumption***/
		//echo $consumptionVaccineID_dosespervial;exit;
		//$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','case_investigation_db',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],"Msl",NULL,$parametersData['procode']);
		$data['weeklyOutBreakAFP'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'afp_case_investigation',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,NULL,$parametersData['procode']);
		$data['weeklyOutBreakNNT'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'nnt_investigation_form',$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,NULL,$parametersData['procode']);
		return $data; 
	}
	
	public function ucCoverage($parametersData){
		//print_r($parametersData);
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];

		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'fixed',$parametersData['procode']);
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'or',$parametersData['procode']);
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'hh',$parametersData['procode']);
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['yearto'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['procode']);
		return $data;
	}
	
	public function ucConsumption($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['yearto'],$parametersData['procode']);
		return $data;
	}
	
	public function ucDropout($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];

		$data['penta1_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1',$parametersData['procode']);
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3',$parametersData['procode']);
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2',$parametersData['procode']);
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2',$parametersData['procode']);
		$data['rota1_rota2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'rota1-rota2',$parametersData['procode']);
		$data['bcg_measles1'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'bcg-measles1',$parametersData['procode']);
		$data['ipv1_ipv2'] = dropoutRateTrend($parametersData['yearto'],$parametersData['distcode'],$parametersData['uncode'],'ipv1-ipv2',$parametersData['procode']);
		return $data;
	}
	
	public function ucSurveillance($parametersData){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		
		$data['weeklyZeroReportsTrend'] = weeklyTrendforZeroReports($parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['procode']);
		$data['weeklyOutBreakAFP'] = $this ->getChartData("afp_case_investigation",$parametersData,"AFP","#f3e83a");
		$data['weeklyOutBreakNNT'] = $this ->getChartData("nnt_investigation_form",$parametersData,"NT","#8B0000");
		$data['weeklyOutBreakMeasles'] = $this ->getChartData("case_investigation_db",$parametersData,"Msl");
		$data['weeklyOutBreakDiphtheria'] = $this ->getChartData("case_investigation_db",$parametersData,"Diph","#00FF00");
		return $data;
	}

	public function ucCovid19(){
		$data['graph'] =$this->maps->getCoronaDetails();
		$data_json['graph'] =  json_encode($data,true);
		//$data['testing'] = "test from controller function";
		return $data_json;
	}
	
	public function ucAttendence($parametersData){
		$data = "";
		return $data;
	}
	public function getChartData($table,$parametersData,$caseType,$color=Null){
		$parametersData['fmonthfrom'] = $fmonthfrom = $parametersData['fmonthfrom'];
		$monthfromarr = explode('-',$fmonthfrom);
		$parametersData['monthfrom'] = $monthfrom = $monthfromarr[1];
		$parametersData['yearfrom'] = $yearfrom = $monthfromarr[0];
		
		$parametersData['fmonthto'] = $fmonthto = $parametersData['fmonthto'];
		$monthtoarr = explode('-',$fmonthto);
		$parametersData['monthto'] = $monthto = $monthtoarr[1];
		$parametersData['yearto'] = $yearto = $monthtoarr[0];
		if($caseType == "AFP" || $caseType == "NT")
			$type = NULL;
		else
			$type = $caseType;
		$result = $this -> maps -> weeklyTrendforOut_breakReports('bubble',$table,$parametersData['yearto'],$parametersData['distcode'],NULL,$parametersData['uncode'],$type,"object",$parametersData['procode']);
		//$result = json_decode(json_encode($result)); use if result not in array object
		$arrData = $dataSeries= array();
		$i=0;
		foreach ($result as $value) {
			$arrData[$i]['label'] = $value->fweek;
			$arrData[$i]['value'] = $value->DiseasesCount;
			$arrData[$i]['link'] = "JavaScript:drilldownfun('{$caseType}','{$value->code}','{$value->year}','{$value->week}')";
			$arrData[$i]['color'] = "{$color}";
			$i++;
		}
		if(!empty($arrData))
			$return = json_encode($arrData,JSON_NUMERIC_CHECK);
		else
			$return = "";
		return $return;
	}
}
?>