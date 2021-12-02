<?php
class FullyImmunizedCoverage extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('dashboard_functions_helper');
		if($this -> session -> username == 'kp_kphis'){}else{
			authentication();
		}
		$this -> load -> model('maps/maps_model','maps');
	}
	
	public function index(){
		$data = $this -> getPostedData();
		$data['colorAxis'] = $this -> colorAxis();
		$monthQauarterYear = "";
		$year = $data['year'];
		if($data['reportType']=='monthly'){
			//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
			$monthQauarterYear = monthname($data['month'])." ".$year;
		}elseif($data['reportType']=='quarterly'){
			$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
		}else{
			$monthQauarterYear = $year;
		}//print_r($monthQauarterYear);exit;
		//print_r($data);exit;
		if($this -> session -> District || $this -> input -> post('id')){
			$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$districtName = $this->maps->districtName($distcode);
			$data['heading']['mapName'] = "UC Wise Fully Immunized Coverage, {$districtName} {$monthQauarterYear}";
			$data['heading']['barName'] = "UC Wise Fully Immunized Coverage, {$districtName} {$monthQauarterYear}";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
		}else{
			$data['heading']['barName'] = "District Wise Fully Immunized Coverage {$monthQauarterYear}";
			$data['heading']['mapName'] = "District Wise Fully Immunized Coverage {$monthQauarterYear}";
			$data['heading']['run'] = true;
		}
		$data['heading']['subtittle'] = $this -> session -> provincename;
		//$result = $this -> getSeriesData($data);
		$viewData['serieses'] = $this -> getSeriesData($data);//print_r($viewData['serieses']);exit;
		$data['indicators'] = $this -> getIndicatorData($data);//print_r($data);exit;
		$result = $this -> getRankingSeriesData($data);//print_r($result);exit;
		$viewData['serieses_ranking'] = $result['serieses_ranking'];
		$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
		
		$viewData['data'] = $data;
		if($data['ajax']){
			$this -> ajaxCall($data, $viewData);
		}
		$viewData['filterowbtn'] = 'FullyImmunizedCoverage';
		$viewData['fileToLoad'] = 'thematic_maps/fully_thematic_immunized_coverage';
		$viewData['pageTitle']='EPI-MIS Dashboard | Fully Immunized Coverage ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}

	public function getPostedData(){
		$data['ajax'] = ($this -> input -> post('ajax'))?$this -> input -> post('ajax'):false;
		$data['vaccineId'] = ($this -> input -> post('vaccineId'))?$this -> input -> post('vaccineId'):'17';
		//$data['id'] = ($this -> input -> post('id'))?$this -> input -> post('id'):'';
		$data['reportType'] = ($this -> input -> post('reportType'))?$this -> input -> post('reportType'):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['quarter'] 	= '';
			$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime("first day of previous months"));
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		}elseif($data['reportType'] == 'quarterly'){
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
			$data['quarter']  = ($this -> input -> post('quarter'))?$this -> input -> post('quarter'):$this->currentQuarter();
		}elseif($data['reportType'] == 'yearly'){
			$data['quarter'] 	= '';
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("first day of previous months"));
		}else{
			$data = array();
		}
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('vaccineBy'))?$this -> input -> post('vaccineBy'):'All';
		return $data;
	}

	/* public function getUriSegmentData(){
		$data = array();
		$data['id'] = $this -> uri -> segment(4);
		$data['reportType']  = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'All';
		$data['month'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime(date('Y-m-d')." -1 months"));
		$data['year']  = ($this -> uri -> segment(7))?$this -> uri -> segment(7):date('Y');
		$data['vaccineId']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'17';
		$data['gender']  = ($this -> uri -> segment(10))?$this -> uri -> segment(10):'Both';
		$data['vaccineBy']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'All';
		$data['quarter']  = ($this -> uri -> segment(6))?$this -> uri -> segment(6):'01';
		
		
		return $data;
	} */
		public function getUriSegmentData(){
		$data['id'] = $this -> uri -> segment(4);
		$data['vaccineId']  = ($this -> uri -> segment(9))?$this -> uri -> segment(9):'1';
		$data['gender']  = ($this -> uri -> segment(10))?$this -> uri -> segment(10):'Both';
		$data['vaccineBy']  = ($this -> uri -> segment(11))?$this -> uri -> segment(11):'All';

		$data['reportType'] = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> uri -> segment(6))?$this -> uri -> segment(6):date('m',strtotime("first day of previous months"));
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
			$viewData['heading']['mapName'] = $data['heading']['mapName'];
			$viewData['heading']['barName'] = $data['heading']['barName'];
			$viewData['heading']['run'] = $data['heading']['run'];
			$map = $this -> load -> view('thematic_maps/parts_view/map', $viewData, TRUE);
			$viewData['id'] = $this -> input -> post('bar_id');
			$bar = $this -> load -> view('thematic_maps/parts_view/bar_graph', $viewData, TRUE);
			$arr = array('map' => $map, 'bar' => $bar);
			echo json_encode($arr);
			exit;
	}

	public function getSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$name = 'District';
		if($this -> session -> District || $this -> input -> post('id') || $this -> uri -> segment(4)){
			$coverageData = $this -> maps -> getUCsFullyImmunizedCoverge($data, $selectQuery);
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getFullyImmunizedCoverge($data, $selectQuery);
		}
		$serieses = $result = $dataSeries = array();
		$i=0;
		$serieses['name'] = $name." Wise Fully Immunized Coverage";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center";
		foreach($coverageData as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> sum != "")?$row -> sum:0;
			$i++;
		}
		array_push($dataSeries,$serieses);
		return json_encode($dataSeries,JSON_NUMERIC_CHECK);
	}
	
	public function onClickUcWiseMapData(){
		if($this -> uri -> segment(4)){
			$distcode = $data['id'] =$this -> uri -> segment(4);
			$data = $this -> getUriSegmentData();
			$districtName = $this->maps->districtName($distcode);
			$monthQauarterYear = "";
			$year = $data['year'];
			if($data['reportType']=='monthly'){
				//$monthQauarterYear = date('M',strtotime('3'))." ".$year;
				$monthQauarterYear = monthname($data['month'])." ".$year;
			}elseif($data['reportType']=='quarterly'){
				$monthQauarterYear = "Qtr-".$data['quarter']." ".$year;
			}else{
				$monthQauarterYear = $year;
			}//print_r($data);exit;
			$data['heading']['mapName'] = "UC Wise Fully Immunized Coverage, {$districtName} {$monthQauarterYear}";
			$data['heading']['barName'] = "UC Wise Fully Immunized Coverage, {$districtName} {$monthQauarterYear}";
			$data['heading']['subtittle'] = $this -> session -> provincename;
			//$data['heading']['mapName'] = "Fully Immunized Coverage";
			$data['colorAxis'] = $this -> colorAxis();
			$viewData['serieses'] = $this -> getSeriesData($data);
			$data['indicators'] = $this -> getIndicatorData($data);
			$result = $this -> getRankingSeriesData($data);
			$viewData['serieses_ranking'] = $result['serieses_ranking'];
			$viewData['serieses_ranking_cat'] = $result['serieses_ranking_cat'];
			//$data['heading']['barName'] = "Ranking of UCs";
			$data['heading']['run'] = false;
			$data['ucwisemap'] = 'true';
			$viewData['data'] = $data;
			$viewData['filterowbtn'] = 'FullyImmunizedCoverage';
			$viewData['fileToLoad'] = 'thematic_maps/fully_thematic_immunized_coverage';
			$viewData['pageTitle']='EPI-MIS Dashboard | Fully Immunized Coverage ';
			$this->load->view('thematic_template/thematic_template',$viewData);
			//echo json_encode($viewData,JSON_NUMERIC_CHECK);
		}
		else{
			/*  */
		}		
	}

	public function getRankingSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		$name = 'District';
		if($this -> session -> District || $this -> input -> post('id') || $this -> uri -> segment(4)){
			$coverageData = $this -> maps -> getUCsFullyImmunizedCoverge($data, $selectQuery);
			$name = 'UC';
		}
		else{
			$coverageData = $this -> maps -> getFullyImmunizedCoverge($data, $selectQuery);
		}
		$serieses = $serieses1 = $result = $dataSeries = $dataSeries1 = array();
		$i=0;
		$serieses['name'] = $name." Wise Ranking";
		$serieses['animation'] = true;
		$serieses['dataLabels']['enabled'] = true;
		$serieses['dataLabels']['align'] = "center"; 
		if($coverageData){
			foreach($coverageData as $row){
				//$serieses1[$i] = $row -> name;
				$serieses['data'][$i]['name'] = $row -> name;
				$serieses['data'][$i]['id'] = $row -> code;
				$serieses['data'][$i]['y'] = ($row -> sum != "")?$row -> sum:0;
				$immunize = $serieses['data'][$i]['y'];
				
				if($immunize >= 95)
					$serieses['data'][$i]['color'] = "#248E5F";
				else if($immunize <= 94.99 && $immunize >= 90)
					$serieses['data'][$i]['color'] = "#3366ff";
				else if($immunize <= 89.99 && $immunize >= 80)
					$serieses['data'][$i]['color'] = "#31f8dd";
				else if($immunize <= 79.99 && $immunize >= 50)
					$serieses['data'][$i]['color'] = "#FFC0CB";
				else if($immunize < 50)
					$serieses['data'][$i]['color'] = "#DD1E2F";
			$i++;
			}
			$compliance = array();
			foreach ($serieses['data'] as $key => $value) {
					$compliance[$key] = $value['y'];
			}
			array_multisort($compliance, SORT_DESC, $serieses['data']);

			foreach ($serieses['data'] as $key => $value) {
					array_push($serieses1, $value['name']);
			}
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$result['serieses_ranking'] = json_encode($dataSeries,JSON_NUMERIC_CHECK);
		$result['serieses_ranking_cat'] = json_encode($dataSeries1,JSON_NUMERIC_CHECK);
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
		$vaccineId = isset($data['vaccineId'])?$data['vaccineId']:'17';
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		$monthto = (isset($data['reportType']) && $data['reportType'] == 'yearly')?date('m',strtotime("first day of last month")):NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$quarterMonth = getQuaterMonths($data['quarter']);
			$monthfrom = $quarterMonth['monthfrom'];
			$monthto = $quarterMonth['monthto'];
			$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
			//$denom = "(".$denom."*3)";
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month'],"Yes",$monthto);
		if((isset($data['id']) && $data['id'] > 0) || $this -> session -> District){
			$q = " uc_wise_maps_paths.uncode as code,uc_wise_maps_paths.ucname as name,(select ";
			$denom = str_replace("distcode","unioncouncil.uncode",$denom);
			$denom = str_replace("district","unioncouncil",$denom);
		}else{
			$q = " districts.distcode as code, districts.district as name,(select ";
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
				$q .= " sum(cri_r25_f$vaccineId) ";
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
				$q .= " sum(cri_r26_f$vaccineId) ";
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
				$q .= " sum(cri_r25_f$vaccineId)+sum(cri_r26_f$vaccineId)";
			}
		}
		if($data['gender'] == "Male"){
			$q .= ")*100/((NULLIF($denom,0)*51)/100)))) ";
		}else if($data['gender'] == "Female"){
			$q .= ")*100/((NULLIF($denom,0)*49)/100)))) ";
		}else{
			$q .= ")*100/NULLIF($denom,0)))) ";
		}
		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fac_mvrf_db.fmonth >= '" . $this->monthFrom($data['year'],$data['quarter']) . "' and fac_mvrf_db.fmonth <= '" . $this->monthTo($data['year'],$data['quarter']) . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if((isset($data['id']) && $data['id'] != '') || $this -> session -> District){
			$code = $this -> session -> District;
			if(isset($data['id']) && $data['id']>0)
				$code = $data['id'];
			$q .= " and fac_mvrf_db.uncode=uc_wise_maps_paths.uncode and fac_mvrf_db.distcode='".$code."' group by fac_mvrf_db.uncode) as sum ";
		}else{
			$q .= " and distcode=districts.distcode) as sum ";
		}
		//echo $q;exit;
		return $q;
	}

	public function getIndicatorData($data){
		//print_r($data);
		$vaccineId = '17';
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		$monthto = (isset($data['reportType']) && $data['reportType'] == 'yearly')?date('m',strtotime("first day of last month")):NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$quarterMonth = getQuaterMonths($data['quarter']);
			$monthfrom = $quarterMonth['monthfrom'];
			$monthto = $quarterMonth['monthto'];
			$denom = getDenominator($vaccine_name,$data['year'],$monthfrom,"Yes",$monthto);
			//$denom = "(".$denom."*3)";
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month'],"Yes",$monthto);
		if((isset($data['id']) && $data['id'] > 0) || $this -> session -> District){
			$q = "select ";
			//echo $data['id'];exit;
			$denom = str_replace("distcode","'".$data['id']."'",$denom);
			$denom = str_replace("uncode","'".$data['id']."'",$denom);
			$denom = str_replace("unioncouncil","district",$denom);
		}else{
			$q = " select ";
			$denom = str_replace("distcode","'3'",$denom);
			$denom = str_replace("district","province",$denom);
		}
		//echo $denom;exit;
		$q .= " sum(cri_r25_f$vaccineId) as mVac , sum(cri_r26_f$vaccineId) as fVac, round($denom,0) as target";

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
		/* $dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '49.99';
		$dataClasses['dataClasses'][0]["color"] = '#DD1E2F';
		$dataClasses['dataClasses'][0]["name"] = '0 to 50';

		$dataClasses['dataClasses'][1]['from'] = '50';
		$dataClasses['dataClasses'][1]['to'] = '79.99';
		$dataClasses['dataClasses'][1]['color'] = '#EBB035';
		$dataClasses['dataClasses'][1]['name'] = '50 to 79';

		$dataClasses['dataClasses'][2]['from'] = '80';
		$dataClasses['dataClasses'][2]['to'] = '89.99';
		$dataClasses['dataClasses'][2]['color'] = '#289BB9';
		$dataClasses['dataClasses'][2]['name'] = '80 to 89';

		$dataClasses['dataClasses'][3]['from'] = '90';
		$dataClasses['dataClasses'][3]['to'] = '1000';
		$dataClasses['dataClasses'][3]['color'] = '#0B7546';
		$dataClasses['dataClasses'][3]['name'] = '90 and above'; */
		
		$dataClasses['dataClasses'][0]["from"] = '0';
		$dataClasses['dataClasses'][0]["to"] = '49.99';
		$dataClasses['dataClasses'][0]["color"] = '#e3330d';
		$dataClasses['dataClasses'][0]["name"] = '< 50%';

		$dataClasses['dataClasses'][1]['from'] = '50';
		$dataClasses['dataClasses'][1]['to'] = '79.99';
		$dataClasses['dataClasses'][1]['color'] = '#FFC0CB';
		$dataClasses['dataClasses'][1]['name'] = '50-79%';

		$dataClasses['dataClasses'][2]['from'] = '80';
		$dataClasses['dataClasses'][2]['to'] = '89.99';
		$dataClasses['dataClasses'][2]['color'] = '#31f8dd';
		$dataClasses['dataClasses'][2]['name'] = '80-89%';

		$dataClasses['dataClasses'][3]['from'] = '90';
		$dataClasses['dataClasses'][3]['to'] = '94.99';
		$dataClasses['dataClasses'][3]['color'] = '#3366ff';
		$dataClasses['dataClasses'][3]['name'] = '90-94%';
		
		$dataClasses['dataClasses'][4]['from'] = '95';
		$dataClasses['dataClasses'][4]['to'] = '1000';
		$dataClasses['dataClasses'][4]['color'] = '#248E5F';
		$dataClasses['dataClasses'][4]['name'] = '>=95%';
		
		/* $dataClasses[0]["from"] = '0';
		$dataClasses[0]["to"] = '40.99';
		$dataClasses[0]["color"] = '#DD1E2F';
		$dataClasses[0]["name"] = '0 to 40';

		$dataClasses[1]['from'] = '41';
		$dataClasses[1]['to'] = '60.99';
		$dataClasses[1]['color'] = '#EBB035';
		$dataClasses[1]['name'] = '41 to 60';

		$dataClasses[2]['from'] = '61';
		$dataClasses[2]['to'] = '80.99';
		$dataClasses[2]['color'] = '#06A2CB';
		$dataClasses[2]['name'] = '61 to 80';

		$dataClasses[3]['from'] = '81';
		$dataClasses[3]['to'] = '1000';
		$dataClasses[3]['color'] = '#0B7546';
		$dataClasses[3]['name'] = '81 and above'; */
		
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
	public function getUC_detailData(){
		$parametersData['services'] = $services = $this -> input -> post('services');
		$parametersData['uncode'] = $uncode = $this -> input -> post('uncode');
		$parametersData['distcode'] = $this -> input -> post('distcode');
		$parametersData['reportType'] = $reportType = $this -> input -> post('reportType');
		$parametersData['vaccineId'] = $vaccineId = $this -> input -> post('vaccineId');
		$parametersData['vaccineBy'] = $vaccineBy = $this -> input -> post('vaccineBy');
		$parametersData['year'] = $year = $this -> input -> post('year');
		if($reportType == 'monthly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth = '" . $this -> input -> post('year') . '-' . $this -> input -> post('month') . "'";			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else if($reportType == 'yearly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth like '" . $this -> input -> post('year') . "-%'";
		}else if($reportType == 'quarterly'){
			$parametersData['rangeCondition'] = $rangeCondition = " fmonth >= '" . $this->monthFrom($this -> input -> post('year'),$this -> input -> post('quarter')) . "' and fmonth <= '" . $this->monthTo($this -> input -> post('year'),$this -> input -> post('quarter')) . "'";
			$parametersData['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):"01";
		}else{}
		if(isset($parametersData['vaccineId'])){}else{ $parametersData['vaccineId']=1;}//for now it is set stactic for bcg disease only-- zob
		$viewData = $parametersData;		
		if(isset($parametersData['month'])){ $parametersData['month']=$parametersData['month'];}else{ $parametersData['month']="";}
		/* Summary View Data */
		$summaryData = $this -> ucSummary($parametersData);
		if($services)
		{
			$summaryData['services'] = $services;
		}else{
			$summaryData['services'] = "outreach";
		}
		$summaryData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
		$viewData['summary'] = $this -> load -> view('thematic_maps/parts_view/ucsummary', $summaryData, TRUE);
		$coverageData = $this -> ucCoverage($parametersData);
		/* set data array from summary data array to be used in coverage tab */ 
		$coverageData['sessionPlannedHeld'] = $summaryData['sessionPlannedHeld'];
		$coverageData['vaccinationNumbers'] = $summaryData['vaccinationNumbers'];
		$coverageData['vaccineId'] = $summaryData['vaccineId'];
		$coverageData['monthlyTarget'] = $summaryData['monthlyTarget'];
		$coverageData['productsNameArray'] = $summaryData['productsNameArray'];
		$coverageData['productsArray'] = $summaryData['productsArray'];
		$coverageData['monthly_yearly_target'] = $summaryData['monthlyTotTarget'];
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
		$viewData['activeClass'] ="summary";				//print_r($summaryData['monthlyTotTarget']);exit;
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
			$type="Union council : ".get_UC_Name($code);			$type1=", ".get_UC_Name($code);
		}
		if((isset($parametersData['distcode']) && $parametersData['distcode']!=null)){
			$code=$parametersData['distcode'];
			$type="District : ".get_District_Name($code);			$type1=", ".get_District_Name($code);
		}
		$data['distYear']=" For ".$type." , Year : ".$parametersData['year'];		
		$data['distYear1'] = $type1.", Year-".$parametersData['year'];
		$data['monthlyTotTarget'] = getmonthlyTotalTarget($code,$parametersData['year'],$parametersData['month'],$productsArray[$vaccineId]);
		$data['monthlyTarget'] = getMonthlyVaccineTarget($code,$type,$parametersData['year'],$parametersData['vaccineId']);
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
} ?>