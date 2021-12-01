<?php
class AccessToHealthServices extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		authentication();
		$this -> load -> model('maps/maps_model','maps');
	}
	
	public function index(){
		$data = $this -> getPostedData();
		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
		$monthQauarterYear = "";
		$year = $data['year'];
		if($data['reportType']=='monthly'){
			//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}else{
			$monthQauarterYear = $year;
		}
		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$districtName = get_District_Name($distcode);
			$data['heading']['mapName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
			$data['heading']['barName'] = "UC Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, ".$districtName." {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$data['colorAxis'] = $this -> colorAxis('uc');
		}else{
			$data['heading']['mapName'] = "District Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, {$monthQauarterYear}";
			$data['heading']['barName'] = "District Wise ".$vaccinesArray[$data['vaccineId']-1]." Coverage, {$monthQauarterYear}";
			$data['heading']['run'] = true;
			$data['colorAxis'] = $this -> colorAxis('dist');
		}
		$viewData['serieses'] = $this -> getSeriesData($data);
		$data['indicators'][] = $this -> getVaccinationByWiseData($data);
		$data['indicators'][] = $this -> getIndicatorData($data);
		$result = $this -> getRankingSeriesData($data);
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		$data['heading']['subtittle'] = $this -> session -> provincename;
		$viewData['data'] = $data;
		if($data['ajax']){
			$this -> ajaxCall($data, $viewData);
		}
		$viewData['filterowbtn'] = 'AccessToHealthServices';
		$viewData['fileToLoad'] = 'thematic_maps/access_to_thematic_health_services';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);	
	}
	public function getPostedData(){
		 
		$data['ajax'] 		= ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		if($data['reportType'] == 'monthly'){ 
			$data['month'] 		= ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] 	= '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter']	= ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  		= ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter'] 	= '';
		}else{
			$data = array();
		}
		$data['vaccineId']  = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):'1';
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('vaccineBy'))?$this -> input -> post('vaccineBy'):'All';
		return $data;
	}
	public function getUriSegmentData(){
		$data['id'] = $this -> uri -> segment(4);
		$data['vaccineId']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'1';
		$data['gender']  = ($this -> uri -> segment(10))?$this -> uri -> segment(10):'Both';
		$data['vaccineBy']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'All';

		$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime(date('Y-m-d')." -1 months"));
			$data['year']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
			$data['quarter'] = '';
		}elseif($data['reportType'] == 'quarterly'){
			$data['year']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('Y',strtotime("first day of previous months"));
			$data['quarter']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):$this->currentQuarter();
			$data['vaccineId']  = ($this -> uri -> segment(8))?$this -> uri -> segment(8):'1';
			$data['vaccineBy']  = ($this -> uri -> segment(10))?$this -> uri -> segment(10):'All';
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y',strtotime("first day of previous months"));
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
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar, 'otherParameters' => $parameters);
			echo json_encode($arr);
			exit;
	}
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
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
			$viewData['fileToLoad'] = 'thematic_maps/access_to_thematic_health_services';
			$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
			$this->load->view('thematic_template/thematic_template',$viewData);
		}else{
		}		
	}
	
	public function getSeriesData($data){
		$selectQuery = (isset($data['ajax']) && $data['ajax'] == true)?$this -> getQuerySelectPortion($data):$this -> getCoverageQuerySelectPortion($data);
		$name = 'District';
		if($this -> session -> District || $this -> input -> post('id') || $this -> uri -> segment(4))
		{
			$coverageData = $this -> maps -> getUCsVaccineCoverage($data, $selectQuery);
			$name = 'UC';
		}
		else
		{
			$coverageData = $this -> maps -> getVaccineCoverage($data, $selectQuery);
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
		$selectQuery = (isset($data['ajax']) && $data['ajax'] == true)?$this -> getQuerySelectPortion($data):$this -> getCoverageQuerySelectPortion($data);
		$name = 'District';
		if($this -> session -> District || $this -> input -> post('id') || $this -> uri -> segment(4)){
			$coverageData = $this -> maps -> getUCsVaccineCoverage($data, $selectQuery, 'yes');
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getVaccineCoverage($data, $selectQuery, 'yes');
		}
		$serieses = array();
		$result = array();
		$dataSeries = array();$dataSeries1 = array();$serieses1 = array();
		
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center"; 
		//print_r($coverageData);exit;
		foreach($coverageData as $row){
			$serieses1[$i] = $row -> name;
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['y'] = ($row -> sum != "")?$row -> sum:0;
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
		$vaccineId = $data['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		$monthto = (isset($data['reportType']) && $data['reportType'] == 'yearly')?date('m',strtotime("first day of last month")):NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$quarterMonth = getQuaterMonths($data['quarter']);
			$monthfrom = $quarterMonth['monthfrom'];
			$monthto = $quarterMonth['monthto'];
			//$denom = getDenominator($vaccine_name,$data['year'],"01","Yes");
			$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
			//$denom = "(".$denom."*3)";
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month'],"Yes",$monthto);
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,COALESCE((select ";
			$denom = str_replace("distcode","unioncouncil.uncode",$denom);
			$denom = str_replace("district","unioncouncil",$denom);
		}else{
			$q = " districts.distcode as code,districts.district as name,COALESCE((select ";
			$denom = str_replace("distcode","districts.distcode",$denom);
		}
		$q .= "round((((";
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
			$q .= ")*100/(((NULLIF($denom,0))*51)/100)))) ";
		}else if($data['gender'] == "Female"){
			$q .= ")*100/(((NULLIF($denom,0))*49)/100)))) ";
		}else{
			$q .= ")*100/NULLIF($denom,0)))) ";
		}
		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
		}else{
			$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
		}
		return $q;
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
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] > '0') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode),0) as sum ";
		}else{
			$q .= " and fac_mvrf_db.distcode=districts.distcode),0) as sum ";
		}
		return $q;
	}
	public function getIndicatorData($data){
		$vaccineId = $data['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		$monthto = (isset($data['reportType']) && $data['reportType'] == 'yearly')?date('m',strtotime("first day of last month")):NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$quarterMonth = getQuaterMonths($data['quarter']);
			$monthfrom = $quarterMonth['monthfrom'];
			$monthto = $quarterMonth['monthto'];
			//$denom = getDenominator($vaccine_name,$data['year'],"01","Yes");
			$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
			//$denom = "(".$denom."*3)";
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
			$denom = str_replace("distcode","'3'",$denom);
			$denom = str_replace("district","province",$denom);
		}
		//print_r($denom);exit;
		$q .= " sum(cri_r25_f$vaccineId+oui_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId+oui_r26_f$vaccineId) as fVac, round($denom,0) as target";

		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
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
	
	public function colorAxis($map='dist'){
		if($this -> input -> post('ajax') && $this -> input -> post('ajax')==true){
			$dataClasses['min'] = 1;
			$dataClasses['minColor'] = '#DD1E2F';
			$dataClasses['maxColor'] = '#0B7546';
			$dataClasses['max'] = ($map=='dist')?10000:1000;
			$dataClasses['type'] = 'logarithmic';
		}else{
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
		$parametersData['uncode'] = $uncode = $this -> input -> post('uncode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		if($reportType == 'monthly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
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
		$attendenceData = $this -> ucAttendence($parametersData);
		$viewData['attendence'] = $this -> load -> view('thematic_maps/parts_view/ucattendence', $attendenceData, TRUE);
		$viewData['activeClass'] ="coverage";
		$result = $this -> load -> view('thematic_maps/parts_view/ucdetaildata', $viewData, TRUE);
		echo $result;
	}
	
	public function ucSummary($parametersData){
		$data['productsArray'] = $productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2');
		$data['productsNameArray'] = array(1=>'BCG',2=>'Hep-B',3=>'OPV-0',4=>'OPV-1',5=>'OPV-2',6=>'OPV-3',7=>'PENTA-1',8=>'PENTA-2',9=>'PENTA-3',10=>'PCV10-1',11=>'PCV10-2',12=>'PCV10-3',13=>'IPV',14=>'Rota-1',15=>'Rota-2',16=>'Measles-I',17=>'Fully Immunized',18=>'Measles-II');
		$data['vaccineId'] = $vaccineId = $parametersData['vaccineId'];
		$data['sessionPlannedHeld'] = sessionPlannedHeld($parametersData['rangeCondition'],$parametersData['uncode'],'',$parametersData['distcode']);
		$data['vaccinationNumbers'] = vaccinationInNumbers($parametersData['rangeCondition'],$parametersData['uncode'],NULL,$parametersData['vaccineId'],NULL,$parametersData['distcode']);//print_r($data['vaccinationNumbers']);
		$data['totalVaccinationNumbers'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'both',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersMale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'male',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$data['totalVaccinationNumbersFemale'] = totalVaccinationInNumbers($parametersData['rangeCondition'],'female',$parametersData['distcode'],NULL,$parametersData['uncode'],NULL,$parametersData['vaccineId']);
		$code="";
		$type="";
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
		$data['distYear']=" For ".$type." , Year : ".$parametersData['year'];
		$data['distYear1'] = $type1.", Year-".$parametersData['year'];
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['year'],$parametersData['vaccineId']);				
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['year'],$parametersData['month'],$productsArray[$vaccineId]);
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);//print_r($data['monthlyVaccinationTrendAllDisease']);exit;
		$data['monthlyVaccinationTrendForfullyimmunized'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'17',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['monthlyVaccinationTrendForTT'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],'TT1-TT2',$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['openvialWastageRate'] = monthlyOpenVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['closedvialWastageRate'] = monthlyClosedVial_wastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		//$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'measle_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakMeasles'] = $this -> maps -> weeklyTrendforOut_breakReports('bubble','case_investigation_db',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode'],"Msl");
		$data['weeklyOutBreakAFP'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'afp_case_investigation',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakNNT'] = $this -> maps -> weeklyTrendforOut_breakReports(NULL,'nnt_investigation_form',$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data; 
	}
	
	public function ucCoverage($parametersData){
		$data['fixedSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'fixed');
		$data['outreachSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'or');
		$data['healthhouseSessionsDropout'] = sessionDropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'hh');
		$data['monthlyVaccinationTrendAllDisease'] = monthlyVaccinationAndCoverageTrendfor_a_Vaccine($parametersData['year'],NULL,$parametersData['distcode'],NULL,$parametersData['uncode']);
		return $data;
	}
	
	public function ucConsumption($parametersData){
		$consumptionVaccineID_dosespervial = getConsumptionVaccineId_bySendingEPI_VaccinationID($parametersData['vaccineId']);
		$parts = explode('-',$consumptionVaccineID_dosespervial);
		$consumptionVaccineID = $parts[0];
		$dosespervial = $parts[1];
		$data['vaccineWastageRate'] = monthlyVaccineWastageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		$data['vaccineUsageRate'] = monthlyVaccineUsageRateTrend($consumptionVaccineID,$dosespervial,$parametersData['distcode'],$parametersData['uncode'],$parametersData['year']);
		return $data;
	}
	
	public function ucDropout($parametersData){
		$data['penta1_measles1'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-measles1');
		$data['penta1_penta3'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'penta1-penta3');
		$data['measles1_measles2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'measles1-measles2');
		$data['tt1_tt2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'tt1-tt2');
		$data['rota1_rota2'] = dropoutRateTrend($parametersData['year'],$parametersData['distcode'],$parametersData['uncode'],'rota1-rota2');
		return $data;
	}
	
	public function ucSurveillance($parametersData){
		$data['weeklyZeroReportsTrend'] = weeklyTrendforZeroReports($parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode']);
		$data['weeklyOutBreakAFP'] = $this ->getChartData("afp_case_investigation",$parametersData,"AFP","#f3e83a");
		$data['weeklyOutBreakNNT'] = $this ->getChartData("nnt_investigation_form",$parametersData,"NT","#8B0000");
		$data['weeklyOutBreakMeasles'] = $this ->getChartData("case_investigation_db",$parametersData,"Msl");
		$data['weeklyOutBreakDiphtheria'] = $this ->getChartData("case_investigation_db",$parametersData,"Diph","#00FF00");
		return $data;
	}
	
	public function ucAttendence($parametersData){
		$data = "";
		return $data;
	}
	public function getChartData($table,$parametersData,$caseType,$color=Null){
		if($caseType == "AFP" || $caseType == "NT")
			$type = NULL;
		else
			$type = $caseType;
		$result = $this -> maps -> weeklyTrendforOut_breakReports('bubble',$table,$parametersData['year'],$parametersData['distcode'],NULL,$parametersData['uncode'],$type,"object");
		//$result = json_decode(json_encode($result)); use if result not in array object
		$arrData = $dataSeries= array();
		$i=0;
		foreach ($result as $value) {
			$arrData[$i]['lable'] = $value->fweek;
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