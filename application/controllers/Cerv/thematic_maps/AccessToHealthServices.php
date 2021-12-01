<?php
class AccessToHealthServices extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		authentication();
		$this -> load -> model('cerv/maps_model','maps');
	}
	
	public function index(){
		$data = $this -> getPostedData();
		//print_r($data);
		$vaccinesArray = array('BCG','Hep B-Birth','OPV','PENTA','Pneumococcal','IPV','Rota','Measles');
		$monthQauarterYear = "";
		$year = $data['year'];
		if($data['reportType']=='monthly'){
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}elseif($data['reportType']=='biyearly'){
			$monthQauarterYear = $year." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
		}else{
			$monthQauarterYear = $year;
		}
		$data['id']  = $distcode = $this->session->District;//($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
		//$data['id']  = $distcode = '702';//($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
		$districtName = get_District_Name($distcode);
		$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Open Vial Wastage, ".$districtName." {$monthQauarterYear}";
		$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Open Vial Wastage, ".$districtName." {$monthQauarterYear}";
		$data['heading']['run'] = false;
		$data['ucwisemap'] = 'true';
		$data['colorAxis'] = $this -> colorAxis($data['vaccineId']);
		$viewData['serieses'] = $this -> getSeriesData($data);
		$data['indicators'][] = '';//$this -> getVaccinationByWiseData($data);
		$data['indicators'][] = '';//$this -> getIndicatorData($data);
		$result = $this -> getRankingSeriesData($data);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['data'] = $data;
		if(isset($data['ajax']) && $data['ajax']){
			$this -> ajaxCall($data, $viewData);
		}
		$viewData['filterowbtn'] = 'AccessToHealthServices';
		$viewData['fileToLoad'] = 'cerv/thematic_maps/access_to_thematic_health_services';
		$viewData['pageTitle']='CERV Dashboard | Access to Health Services ';
		$this->load->view('cerv/thematic_template/thematic_template',$viewData);	
	}
	public function getPostedData(){
		 
		//$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		if($data['reportType'] == 'monthly'){ 
			$data['month'] 		= ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] 	= '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['biyear'] = '';
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter']	= ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] 	= '';
			$data['biyear'] = '';
		}elseif($data['reportType'] == 'biyearly'){
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['biyear']  = ($this -> input -> post('biyear')=="1" || $this -> input -> post('biyear')=="2")?$this -> input -> post('biyear'):1;
			$data['quarter'] 	= '';
		}else{
			$data = array();
		}
		$data['vaccineId']  = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):'1';
		//$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		//$data['vaccineBy']  = ($this -> input -> post('vaccineBy'))?$this -> input -> post('vaccineBy'):'All';
		return $data;
	}
	public function getUriSegmentData(){
		if( ! $this -> input -> get('code'))
			$data['id'] = $this -> uri -> segment(5);
		$data['vaccineId']  = ($this -> uri -> segment(10))?$this -> uri -> segment(10):'1';
		$data['gender']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'Both';
		$data['vaccineBy']  = ($this -> uri -> segment(12))?$this -> uri -> segment(12):'All';

		$data['reportType'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('m',strtotime(date('Y-m-d')." -1 months"));
			$data['year']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):date('Y',strtotime("first day of previous months"));
			$data['quarter'] = '';
			$data['biyear'] = '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['year']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
			$data['quarter']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):$this->currentQuarter();
			$data['vaccineId']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'1';
			$data['vaccineBy']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'All';
			$data['biyear'] = '';
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):date('Y',strtotime("first day of previous months"));
			$data['quarter'] = '';
			$data['biyear'] = '';
		}elseif($data['reportType'] == 'biyearly'){
			$data['year']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):date('Y',strtotime("first day of previous months"));
			$data['biyear']  = ($this -> uri -> segment(13)=="01" || $this -> uri -> segment(13)=="02")?$this -> uri -> segment(13):01;
			$data['quarter'] = '';
		}else{
			$data = array();
		}
		return $data;
	}
	public function ajaxCall($data, $viewData){
			$viewData['id'] = $this -> input -> post('map_id');
			$viewData['fmonth'] = $this -> input -> post('fmonth');
			$viewData['colorAxis'] = $this -> colorAxis();
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
			$map = $this -> load -> view('cerv/thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('cerv/thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar, 'otherParameters' => $parameters);
			echo json_encode($arr);
			exit;
	}
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(5)){
			$data = $this -> getUriSegmentData();
			//$distcode = $data['id'];
			$districtName = $this->maps->districtName($data['id']);
			$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
			$monthQauarterYear = "";
			$year = $data['year'];
			if($data['reportType']=='monthly'){
				//$monthQauarterYear = date('M',strtotime($data['month']))." ".$year;
				$monthQauarterYear = monthname($data['month'])." ".$year;
			}elseif($data['reportType']=='quarterly'){
				$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
			}elseif($data['reportType']=='biyearly'){
				$monthQauarterYear = $year." ".(($data['biyear']==1)?'1st':'2nd')." Half ";
			}else{
				$monthQauarterYear = $year;
			}
			$data['heading']['mapName'] = "UC Wise {$vaccinesArray[$data['vaccineId']-1]} Coverage, {$districtName} {$monthQauarterYear}";
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
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'AccessToHealthServices';
			$viewData['fileToLoad'] = 'cerv/thematic_maps/access_to_thematic_health_services';
			$viewData['pageTitle']='CERV Dashboard | Access to Health Services ';
			$this->load->view('cerv/thematic_template/thematic_template',$viewData);
		}else{
		}		
	}
	
	public function getSeriesData($data){
		$coverageData = $this -> getCoverageQuerySelectPortion($data);
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
	
	public function getRankingSeriesData($data){
		$coverageData = $this -> getCoverageQuerySelectPortion($data);
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
	
	
	public function currentQuarter(){
		$curMonth = date("m", time());
		$curQuarter = ceil($curMonth/3);
		return $curQuarter;
	}
	
	public function getCoverageQuerySelectPortion($data){
		$distcode = $this->session->District;
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
		return $result;
	}
	/* New function by Uzair for getting Vaccination-by wise Vaccines count  */
	public function getQuerySelectPortion($data){
		$vaccineId = $data['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,COALESCE((select ";
		}else{
			$q = " districts.distcode as code,districts.district as name,COALESCE((select ";
		}
		$q .= "round((";
		if($data['gender'] == "Male"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
			}else{
				$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId)
						+sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId)
						+sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId)
						+sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
			}
		}else if($data['gender'] == "Female"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
			}else{
				$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId)
						+sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId)
						+sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId)
						+sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
			}
		}else{ // if male and female both data is required
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
			}else{
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
		if($data['gender'] == "Male"){
			$q .= ")) ";
		}else if($data['gender'] == "Female"){
			$q .= ")) ";
		}else{
			$q .= ")) ";
		}
		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'biyearly'){
			if($data['biyear']=='01' || $data['biyear']=='1')
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],'01') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],'02') . "'";
			else if($data['biyear']=='02' || $data['biyear']=='2')
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],'03') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],'04') . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
		}else{
			$q .= " and fac_mvrf_db.distcode=districts.distcode and districts.procode='{$_SESSION['Province']}'),0) as sum ";
		}
		return $q;
	}
	public function getIndicatorData($data){
		$vaccineId = $data['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		$monthto = (isset($data['reportType']) && $data['reportType'] == 'yearly')?(($data['year'] == date('Y'))?date('m',strtotime("first day of last month")):12):NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$quarterMonth = getQuaterMonths($data['quarter']);
			$monthfrom = $quarterMonth['monthfrom'];
			$monthto = $quarterMonth['monthto'];
			//$denom = getDenominator($vaccine_name,$data['year'],"01","Yes");
			$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
			//$denom = "(".$denom."*3)";
		}else if( isset($data['biyear']) && ($data['biyear']=='01' || $data['biyear']=='1')){
				$monthfrom = '01';
				$monthto = '06';
				$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
		}else if( isset($data['biyear']) && ($data['biyear']=='02' || $data['biyear']=='2')){
				$monthfrom = '07';
				$monthto = '12';
				$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month'],"Yes",$monthto);
		if((isset($data['id']) && $data['id'] > 0) || $this -> session -> District){
			$q = "select ";
			$denom = str_replace("distcode","'".$data['id']."'",$denom);
			$denom = str_replace("uncode","'".$data['id']."'",$denom);
			$denom = str_replace("unioncouncil","district",$denom);
		}else{
			$q = " select ";
			$denom = str_replace("distcode","{$this->session->Province}",$denom);
			$denom = str_replace("district","province",$denom);
		}
		//print_r($denom);exit;
		$q .= " sum(cri_r25_f$vaccineId+oui_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId+oui_r26_f$vaccineId) as fVac, round($denom,0) as target";

		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'biyearly'){
			if($data['biyear']=='01' || $data['biyear']=='1')
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],'01') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],'02') . "'";
			else if($data['biyear']=='02' || $data['biyear']=='2')
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],'03') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],'04') . "'";
				
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.distcode='".$code."' ";
		}else{
			$q .= "";
		}
		$result1 = $this -> maps -> getTargetAndCoverageData($data,$q);
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
	
	public function colorAxis($vaccineId){
		if($vaccineId == 1){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '30'; 
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-30%';

			$dataClasses['dataClasses'][1]['from'] = '31';
			$dataClasses['dataClasses'][1]['to'] = '40';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '31-40%';
			
			$dataClasses['dataClasses'][2]['from'] = '41';
			$dataClasses['dataClasses'][2]['to'] = '50';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '41-50%';

			$dataClasses['dataClasses'][3]['from'] = '51';
			//$dataClasses['dataClasses'][2]['to'] = '';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>50%';
		}else if($vaccineId == 2){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 3){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '10.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-10%';

			$dataClasses['dataClasses'][1]['from'] = '11';
			$dataClasses['dataClasses'][1]['to'] = '20.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '11-20%';

			$dataClasses['dataClasses'][2]['from'] = '20';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 4){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '1000';
			$dataClasses['dataClasses'][1]['color'] = '#e3330d';
			$dataClasses['dataClasses'][1]['name'] = '>5%';
		}else if($vaccineId == 5){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 6){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '1000';
			$dataClasses['dataClasses'][2]['color'] = '#e3330d';
			$dataClasses['dataClasses'][2]['name'] = '>20%';
		}else if($vaccineId == 7){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '10.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-10%';

			$dataClasses['dataClasses'][1]['from'] = '11';
			$dataClasses['dataClasses'][1]['to'] = '20.99';
			$dataClasses['dataClasses'][1]['color'] = '#31f8dd';
			$dataClasses['dataClasses'][1]['name'] = '11 to 20%';

			$dataClasses['dataClasses'][2]['from'] = '21';
			$dataClasses['dataClasses'][2]['to'] = '30.99';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '21 to 30%';

			$dataClasses['dataClasses'][3]['from'] = '31';
			$dataClasses['dataClasses'][3]['to'] = '1000';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '30 and above';
		}else if($vaccineId == 8){
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '5.99';
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-5%';

			$dataClasses['dataClasses'][1]['from'] = '6';
			$dataClasses['dataClasses'][1]['to'] = '10.99';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '6-10%';

			$dataClasses['dataClasses'][2]['from'] = '11';
			$dataClasses['dataClasses'][2]['to'] = '20.99';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '11-20%';
			
			$dataClasses['dataClasses'][3]['from'] = '20';
			$dataClasses['dataClasses'][3]['to'] = '1000';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>20%';
		}else{
			$dataClasses['dataClasses'][0]["from"] = '0';
			$dataClasses['dataClasses'][0]["to"] = '30'; 
			$dataClasses['dataClasses'][0]["color"] = '#248E5F';
			$dataClasses['dataClasses'][0]["name"] = '0-30%';

			$dataClasses['dataClasses'][1]['from'] = '31';
			$dataClasses['dataClasses'][1]['to'] = '40';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '31-40%';
			
			$dataClasses['dataClasses'][2]['from'] = '41';
			$dataClasses['dataClasses'][2]['to'] = '50';
			$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
			$dataClasses['dataClasses'][2]['name'] = '41-50%';

			$dataClasses['dataClasses'][3]['from'] = '51';
			//$dataClasses['dataClasses'][2]['to'] = '';
			$dataClasses['dataClasses'][3]['color'] = '#e3330d';
			$dataClasses['dataClasses'][3]['name'] = '>50%';
		}
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	
	/* Code by Uzair for new changes in thematic maps module started on 27-10-2017 */
	public function getVaccinationByWiseData($params){
		$vaccineId = $params['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$params['month']=isset($params['month'])?$params['month']:NULL;
		$vaccinationByArray = array('fixed','outreach','mobile','healthhouse','total');
		$q = "select ";$i=1;
		foreach($vaccinationByArray as $key => $val){
			if($val=='total'){
				for($m=1;$m<=24;$m++){
					if($params['gender'] == "Male" && $m%2 != 0)
						$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
					else if($params['gender'] == "Female" && $m%2 == 0)
						$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
					else if($params['gender'] == 'Both' || $params['gender'] == 'All')
						$q .= "sum(cri_r{$m}_f{$vaccineId})+sum(oui_r{$m}_f{$vaccineId})+";
				}
			}else{
				for($i;$i<=24;$i++){
					if($params['gender'] == "Male" && $i%2 != 0)
						$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
					else if($params['gender'] == "Female" && $i%2 == 0)
						$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
					else if($params['gender'] == 'Both' || $params['gender'] == 'All')
						$q .= "sum(cri_r{$i}_f{$vaccineId})+sum(oui_r{$i}_f{$vaccineId})+";
					if($i%6==0){ break; }
				}
			}
			$q = rtrim($q,'+');
			$q .= " as {$val}vaccination, ";
			$i++;
		}
		$q = rtrim($q,', ');
		if($params['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth = '" . $params['year']."-".$params['month'] . "'";
		}elseif($params['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($params['year'],$params['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($params['year'],$params['quarter']) . "'";
		}elseif($params['reportType'] == 'biyearly'){
			if($params['biyear']=='01' || $params['biyear']=='1'){
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($params['year'],'01') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($params['year'],'02') . "'";
			}
			else
				$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($params['year'],'03') . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($params['year'],'04') . "'";
		}elseif($params['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth like '" . $params['year']."-%" . "'";
		}else{}
		if((isset($params['id']) && $params['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($params['id']) && $params['id']>0)
				$code = $params['id'];
			$q .= " and fac_mvrf_db.distcode='".$code."' ";
		}else{
			$q .= "";
		}
		$result = $this -> db -> query($q) -> result_array();
		return $result[0];
	}
	
	public function getUC_detailData(){
		$newbornArrray = array('bcg','hepb','opv0');
		$surviningArrray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv','rota1','rota2','measles1','fullyimmunized','measles2');
		
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['procode'] = $procode = ($this -> input -> post('procode'))?$this -> input -> post('procode'):NULL;
		$parametersData['uncode'] = $uncode = ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):NULL;
		$parametersData['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):NULL;
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		$parametersData['biyear'] = $biyear = $this -> input -> post('biyear');
		if($reportType == 'monthly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
		}else if($reportType == 'biyearly'){
			if($this -> input -> post('biyear')=='01' || $this -> input -> post('biyear')=='1')
				$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),'01') . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),'02') . "'";
			else if($this -> input -> post('biyear')=='02' || $this -> input -> post('biyear')=='2')
				$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),'03') . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),'04') . "'";
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else{}
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
		$viewData['summary'] = $this -> load -> view('cerv/thematic_maps/parts_view/ucsummary', $summaryData, TRUE);
		/* Coverage Tab data */
		$coverageData = $this -> ucCoverage($parametersData);
		/* set data array from summary data array to be used in coverage tab */
		$coverageData['sessionPlannedHeld'] = $summaryData['sessionPlannedHeld'];
		$coverageData['vaccinationNumbers'] = $summaryData['vaccinationNumbers'];
		$coverageData['vaccineId'] = $summaryData['vaccineId'];
		$coverageData['monthlyTarget'] = $summaryData['monthlyTarget'];
		$coverageData['productsNameArray'] = $summaryData['productsNameArray'];
		$coverageData['productsArray'] = $summaryData['productsArray'];
		$viewData['coverage'] = $this -> load -> view('cerv/thematic_maps/parts_view/uccoverage', $coverageData, TRUE);
		/* Consumption View Data */
		$consumptionData = $this -> ucConsumption($parametersData);
		$consumptionData['openvialWastageRate'] = $summaryData['openvialWastageRate'];
		$consumptionData['closedvialWastageRate'] = $summaryData['closedvialWastageRate'];
		$viewData['consumption'] = $this -> load -> view('cerv/thematic_maps/parts_view/ucconsumption', $consumptionData, TRUE);
		$dropoutData = $this -> ucDropout($parametersData);
		$viewData['dropout'] = $this -> load -> view('cerv/thematic_maps/parts_view/ucdropout', $dropoutData, TRUE);
		$surveillanceData = $this -> ucSurveillance($parametersData);
		$viewData['surveillance'] = $this -> load -> view('cerv/thematic_maps/parts_view/ucsurveillance', $surveillanceData, TRUE);
		$attendenceData = $this -> ucAttendence($parametersData);
		$viewData['attendence'] = $this -> load -> view('cerv/thematic_maps/parts_view/ucattendence', $attendenceData, TRUE);
		$viewData['activeClass'] ="coverage";
		$result = $this -> load -> view('cerv/thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
}
?>