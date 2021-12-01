<?php
class AccessToHealthServices extends CI_Controller {

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
		$data['vaccineId']  = ($this -> input -> post('vaccine'))?$this -> input -> post('vaccine'):'1';
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('session_type'))?$this -> input -> post('session_type'):'All';
		//print_r($data);
		if($this -> session -> District){
			$viewData = $this -> getProvincialSeriesData($data);
		}else{
			//$data['distcode']  = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'';
			$viewData = $this -> getProvincialSeriesData($data);
		}
		$viewData['data'] = $data;
	//print_r($viewData);
		$viewData['fileToLoad'] = 'dashboard/coverage';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('template/epi_template',$viewData);
	}
	
	public function getProvincialSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		//echo $selectQuery;exit;
		$coverageData = $this -> dashboard -> getVaccineCoverage($data, $selectQuery);
		
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array(); 
		
		$i=0;
		foreach($coverageData as $row){
			$category[$i] = $row -> name;
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['y'] = ($row -> sum != "")?$row -> sum:0;
			$serieses['data'][$i]['drilldown'] = $row -> name;
			$i++;
		}
		
		array_push($cat,$category);
		array_push($result,$serieses);
		$result['serieses'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		
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
		//print_r($data);exit;
		$vaccineId = $data['vaccineId'];
		$vaccine_name = get_target_vacc_name($vaccineId);
		$data['month']=isset($data['month'])?$data['month']:NULL;
		if(isset($data['quarter']) && $data['quarter']>0){
		   	     $denom = getDenominator($vaccine_name,$data['year'],"01");
			$denom = "(".$denom."*3)";
		}
		else
			$denom = getDenominator($vaccine_name,$data['year'],$data['month']);
		
		if($this -> session -> District){
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
				$q .= " sum(cri_r25_f$vaccineId)+sum(cri_r26_f$vaccineId) ";
			}
		}
		if($data['gender'] == "Male"){
			$q .= ")/(((NULLIF($denom,0))*51)/100))*100),2) ";
		}else if($data['gender'] == "Female"){
			$q .= ")/(((NULLIF($denom,0))*49)/100))*100),2) ";
		}else{
			$q .= ")/NULLIF($denom,0))*100),2) ";
		}
		if($data['reportType'] == 'monthly'){
			$q .= " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q .= " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['quarter']) . "' and fmonth <= '" . $this->monthTo($data['quarter']) . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q .= " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if($this -> session -> District){
			$q .= " and facode=facilities.facode group by facode) as sum ";
		}else{
			$q .= " and distcode=districts.distcode) as sum ";
		}
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
	
	public function moon_zing_test(){
		$data['reportType'] = ($this -> input -> post('report_type'))?$this -> input -> post('report_type'):'monthly';
		if($data['reportType'] == 'monthly'){
			$data['month'] = ($this -> input -> post('month'))?$this -> input -> post('month'):date('m',strtotime(date('m')." -1 month"));
			$data['year']  = ($this -> input -> post('year'))?$this -> input -> post('year'):date('Y');
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
			$viewData = $this -> getDistrictSeriesData($data);
		}else{
			$viewData = $this -> getProvincialSeriesData($data);
		}
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'dashboard/moon_zing_test';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('template/epi_template',$viewData);
	}
}
