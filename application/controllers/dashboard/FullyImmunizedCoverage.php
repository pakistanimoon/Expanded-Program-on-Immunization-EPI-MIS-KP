<?php
class FullyImmunizedCoverage extends CI_Controller {

	//================ Constructor function starts==================//
	public function __construct() {
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
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		}else{
			$data = array();
		}
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('session_type'))?$this -> input -> post('session_type'):'All';
		$data['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'';
		if($this -> session -> District || $data['distcode']>0){
			$viewData = $this -> getProvincialSeriesData($data);
		}else{
			$viewData = $this -> getProvincialSeriesData($data);
		}
		//print_r($viewData);exit;
		$headers = apache_request_headers();
		$is_ajax = (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
		if($is_ajax || $data['distcode']>0){
			$viewData1["serieses"] = json_decode($viewData["serieses"]);
			$viewData1["category"] = json_decode($viewData["category"]);
			echo json_encode($viewData1);
		}else{
			$viewData['data'] = $data;
			$viewData['fileToLoad'] = 'dashboard/fullyImmunizedCoverage';
			$viewData['pageTitle']='EPI-MIS Dashboard | Fully Immunized Coverage ';
			$this->load->view('template/epi_template',$viewData);
		}
	}
	
	public function getProvincialSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		//print_r($data);exit;
		$coverageData = $this -> dashboard -> getVaccineCoverage($data, $selectQuery);
		//print_r($coverageData);exit;
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$i=0;
		foreach($coverageData as $row){
			$category[$i] = $row -> name;
			$serieses['name'] = "Coverage";
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['y'] = ($row -> sum != "")?$row -> sum:0;
			$serieses['data'][$i]['drilldown'] = $row -> name;
			$serieses['data'][$i]['code'] = $row -> code;
			$i++;
		}
		
		array_push($cat,$category);
		array_push($result,$serieses);
		$output['serieses'] = json_encode($result,JSON_NUMERIC_CHECK);
		$output['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		//print_r($output);exit;
		
		return $output;
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
		$vaccineId = 17;
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$denom = getDenominator($vaccine_name,$data['year'],"01");
			$denom = "(".$denom."*3)";
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month']);
		if($this -> session -> District || $data['distcode']>0){
			$q = " facode as code,fac_name as name,(select ";
			$denom = str_replace("distcode","facilities.facode",$denom);
		}else{
			$q = " distcode as code,district as name,(select ";
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
			$q .= ")/((NULLIF($denom,0)*51)/100))*100),2) ";
		}else if($data['gender'] == "Female"){
			$q .= ")/((NULLIF($denom,0)*49)/100))*100),2) ";
		}else{
			$q .= ")/NULLIF($denom,0))*100),2) ";
		}
		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if($this -> session -> District || $data['distcode']>0){
			$q .= " and facode=facilities.facode group by facode) as sum ";
		}else{
			$q .= " and distcode=districts.distcode) as sum ";
		}
		return $q;
	}
	public function monthData(){
		$data['reportType'] = ($this -> input -> post('report_type'))?$this -> input -> post('report_type'):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('Y-m-d')." -1 months"));
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y',strtotime("-1 month"));
		}elseif($data['reportType'] == 'yearly'){
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
		}else{
			$data = array();
		}
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('session_type'))?$this -> input -> post('session_type'):'All';
		$data['distcode'] = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'';
		$viewData = $this -> getProvincialSeriesDataMonth($data);
		$viewData1["serieses"] = json_decode($viewData["serieses"]);
		$viewData1["category"] = json_decode($viewData["category"]);
		echo json_encode($viewData1);
	}
	public function getProvincialSeriesDataMonth($data){
		$selectQuery = $this -> getQuerySelectPortionMonth($data);
		//echo $selectQuery;exit;
		$coverageData = $this -> dashboard -> getVaccineCoverageMonth($data, $selectQuery);
		//print_r($coverageData);exit;
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$i=0;
		foreach($coverageData as $row){
			$category[$i] = $row -> month;
			$serieses['name'] = "Coverage";
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['y'] = ($row -> sum != "")?$row -> sum:0;
			//$serieses['data'][$i]['drilldown'] = $row -> name;
			$serieses['data'][$i]['code'] = $row -> code;
			$i++;
		}
		
		//array_push($cat,$category);
		//array_push($result,$serieses);
		$output['serieses'] = json_encode($serieses,JSON_NUMERIC_CHECK);
		$output['category'] = json_encode($category,JSON_NUMERIC_CHECK);
		
		//print_r($output);exit;
		
		return $output;
	}
		public function getQuerySelectPortionMonth($data){
		$vaccineId = 17;
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
			$denom = getDenominator($vaccine_name,$data['year'],"01");
			$denom = "(".$denom."*3)";
		}
		else
			$denom = "getmonthly_newborn(fac.facode, 'facility')::numeric";
		//echo $denom;exit;
		if($data['distcode']>0){
			$q = " fac.facode as code,fac.fac_name as name,CASE WHEN
					fmonth = '2017-01' THEN 'JANUARY'
					WHEN fmonth = '2017-02' THEN 'FEBRUARY' WHEN fmonth = '2017-03' THEN 'MARCH' WHEN fmonth = '2017-04' THEN 'APRIL' WHEN fmonth = '2017-05' THEN 'MAY' WHEN fmonth = '2017-06' THEN 'JUNE' WHEN fmonth = '2017-07' THEN 'JULY' WHEN fmonth = '2017-08' THEN 'AUGUST' WHEN fmonth = '2017-09' THEN 'SEPTEMBER' WHEN fmonth = '2017-10' THEN 'OCTOBER' WHEN fmonth = '2017-11' THEN 'NOVEMBER' WHEN fmonth = '2017-12' THEN 'DECEMBER' END as month, ";
			$denom = str_replace("distcode","fac.facode",$denom);
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
			$q .= ")/((NULLIF($denom,0)*51)/100))*100),2) as sum ";
		}else if($data['gender'] == "Female"){
			$q .= ")/((NULLIF($denom,0)*49)/100))*100),2) as sum ";
		}else{
			$q .= ")/NULLIF($denom,0))*100),2) as sum ";
		}
		return $q;
	}
}