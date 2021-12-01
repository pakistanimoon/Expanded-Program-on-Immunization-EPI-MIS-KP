<?php
class UtilizationOfServices extends CI_Controller {

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
			$currMon = date('m');
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
		}//exit;
		$data['vaccineId']  = ($this -> input -> post('vaccine'))?$this -> input -> post('vaccine'):'9';
		$data['gender']  = ($this -> input -> post('gender_wise'))?$this -> input -> post('gender_wise'):'Both';
		$data['vaccineBy']  = ($this -> input -> post('session_type'))?$this -> input -> post('session_type'):'All';
		if($data['vaccineId'] == 2){
			$data['vaccGivento']  = ($this -> input -> post('vaccGivento'))?$this -> input -> post('vaccGivento'):'Both';
		}
		if($this -> session -> District){
			$viewData = $this -> getProvincialSeriesData($data);
		}else{
			$viewData = $this -> getProvincialSeriesData($data);
		}
		$viewData['data'] = $data;
		$viewData['fileToLoad'] = 'dashboard/dropout';
		$viewData['pageTitle']='EPI-MIS Dashboard | Utilization of Services ';
		$this->load->view('template/epi_template',$viewData);
	}
	
	public function getProvincialSeriesData($data){
		$selectQuery = $this -> getQuerySelectPortion($data);
		//echo $selectQuery = $this -> getQuerySelectPortion($data);exit;
		$coverageData = $this -> dashboard -> getVaccinesDropout($data, $selectQuery);
		$category = array();
		$serieses = array();
		$result = array();
		$cat = array();
		
		$i=0;
		foreach($coverageData as $row){
			$category[$i] = $row -> name;
			$serieses['data'][$i]['name'] = $row -> name;
			if($row->second == 0 || $row->second == ''){
				$serieses['data'][$i]['y'] = 0;
			}else{
				$value = round((((int)$row->second -(int)$row->first)*100)/(int)$row->second,2);
				$serieses['data'][$i]['y'] = ($value < 0)?0:$value;
			}		
			$serieses['data'][$i]['drilldown'] = $row -> name;
			$i++;
		}
		
		array_push($cat,$category);
		array_push($result,$serieses);
		$result['serieses'] = json_encode($result,JSON_NUMERIC_CHECK);
		$result['category'] = json_encode($cat,JSON_NUMERIC_CHECK);
		
		//print_r($result);exit;
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
		$subPartOfQuery = $this -> subPartQuery($data);
		$vaccineId = $data['vaccineId'];
		if($this -> session -> District){
			$q = " facode as code,fac_name as name,(select ";
		}else{
			$q = " distcode as code,district as name,(select ";
		}
		if($data['gender'] == "Male" && $vaccineId != "2"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r5_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . " as  first, (select sum(cri_r1_f7)+sum(cri_r3_f7)+sum(cri_r5_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r3_f7)+sum(cri_r5_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f16)+sum(cri_r3_f16)+sum(cri_r5_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r11_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r9_f7)+sum(cri_r11_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r9_f7)+sum(cri_r11_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f16)+sum(cri_r9_f16)+sum(cri_r11_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r17_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r15_f7)+sum(cri_r17_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r15_f7)+sum(cri_r17_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f16)+sum(cri_r15_f16)+sum(cri_r17_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r23_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r21_f7)+sum(cri_r23_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r21_f7)+sum(cri_r23_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f16)+sum(cri_r21_f16)+sum(cri_r23_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else{
				$q .= " sum(cri_r25_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}
		}else if($data['gender'] == "Female" && $vaccineId != "2"){
			if($data['vaccineBy'] == "Fixed"){
				$q .= " sum(cri_r2_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f7)+sum(cri_r4_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f7)+sum(cri_r4_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r2_f16)+sum(cri_r4_f16)+sum(cri_r6_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Outreach"){
				$q .= " sum(cri_r8_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f7)+sum(cri_r10_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f7)+sum(cri_r10_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r8_f16)+sum(cri_r10_f16)+sum(cri_r12_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "Mobile"){
				$q .= " sum(cri_r14_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f7)+sum(cri_r16_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f7)+sum(cri_r16_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r14_f16)+sum(cri_r16_f16)+sum(cri_r18_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else if($data['vaccineBy'] == "LHW"){
				$q .= " sum(cri_r20_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f7)+sum(cri_r22_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f7)+sum(cri_r22_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r20_f16)+sum(cri_r22_f16)+sum(cri_r24_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}else{
				$q .= " sum(cri_r26_f$vaccineId) ";
				if($vaccineId == "16"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "9"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
				}else if($vaccineId == "18"){
					$q .= $subPartOfQuery . "as  first, (select sum(cri_r26_f16) " . $subPartOfQuery . " as second ";
				}else{}
			}
		}else{ // if male and female both data is required
			if($vaccineId == "2" && $data['vaccGivento']){
				if($data['vaccGivento'] == "Pregnant"){
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r1_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r1_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r3_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r3_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r5_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r5_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r7_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r7_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r9_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r9_f1) " . $subPartOfQuery . " as second ";
					}
				}
				else if($data['vaccGivento'] == "NonPregnant"){
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r2_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r2_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r4_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r4_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r6_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r6_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r8_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r8_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r10_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r10_f1) " . $subPartOfQuery . " as second ";
					}
				}
				else{
					if($data['vaccineBy'] == "Fixed"){
						$q .= " sum(ttri_r1_f$vaccineId)+sum(ttri_r2_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r1_f1)+sum(ttri_r2_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Outreach"){
						$q .= " sum(ttri_r3_f$vaccineId)+sum(ttri_r4_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r3_f1)+sum(ttri_r4_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "Mobile"){
						$q .= " sum(ttri_r5_f$vaccineId)+sum(ttri_r6_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r5_f1)+sum(ttri_r6_f1) " . $subPartOfQuery . " as second ";
					}
					else if($data['vaccineBy'] == "LHW"){
						$q .= " sum(ttri_r7_f$vaccineId)+sum(ttri_r8_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r7_f1)+sum(ttri_r8_f1) " . $subPartOfQuery . " as second ";
					}else{
						$q .= " sum(ttri_r9_f$vaccineId)+sum(ttri_r10_f$vaccineId) " . $subPartOfQuery . " as first, (select sum(ttri_r9_f1)+sum(ttri_r10_f1) " . $subPartOfQuery . " as second ";
					}
				}
			}else{
				if($data['vaccineBy'] == "Fixed"){
					$q .= " sum(cri_r1_f$vaccineId)+sum(cri_r2_f$vaccineId)+sum(cri_r3_f$vaccineId)+sum(cri_r4_f$vaccineId)+sum(cri_r5_f$vaccineId)+sum(cri_r6_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r2_f7)+sum(cri_r3_f7)+sum(cri_r4_f7)+sum(cri_r5_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f7)+sum(cri_r2_f7)+sum(cri_r3_f7)+sum(cri_r4_f7)+sum(cri_r5_f7)+sum(cri_r6_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r1_f16)+sum(cri_r2_f16)+sum(cri_r3_f16)+sum(cri_r4_f16)+sum(cri_r5_f16)+sum(cri_r6_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "Outreach"){
					$q .= " sum(cri_r7_f$vaccineId)+sum(cri_r8_f$vaccineId)+sum(cri_r9_f$vaccineId)+sum(cri_r10_f$vaccineId)+sum(cri_r11_f$vaccineId)+sum(cri_r12_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r8_f7)+sum(cri_r9_f7)+sum(cri_r10_f7)+sum(cri_r11_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f7)+sum(cri_r8_f7)+sum(cri_r9_f7)+sum(cri_r10_f7)+sum(cri_r11_f7)+sum(cri_r12_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r7_f16)+sum(cri_r8_f16)+sum(cri_r9_f16)+sum(cri_r10_f16)+sum(cri_r11_f16)+sum(cri_r12_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "Mobile"){
					$q .= " sum(cri_r13_f$vaccineId)+sum(cri_r14_f$vaccineId)+sum(cri_r15_f$vaccineId)+sum(cri_r16_f$vaccineId)+sum(cri_r17_f$vaccineId)+sum(cri_r18_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r14_f7)+sum(cri_r15_f7)+sum(cri_r16_f7)+sum(cri_r17_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f7)+sum(cri_r14_f7)+sum(cri_r15_f7)+sum(cri_r16_f7)+sum(cri_r17_f7)+sum(cri_r18_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r13_f16)+sum(cri_r14_f16)+sum(cri_r15_f16)+sum(cri_r16_f16)+sum(cri_r17_f16)+sum(cri_r18_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else if($data['vaccineBy'] == "LHW"){
					$q .= " sum(cri_r19_f$vaccineId)+sum(cri_r20_f$vaccineId)+sum(cri_r21_f$vaccineId)+sum(cri_r22_f$vaccineId)+sum(cri_r23_f$vaccineId)+sum(cri_r24_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r20_f7)+sum(cri_r21_f7)+sum(cri_r22_f7)+sum(cri_r23_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f7)+sum(cri_r20_f7)+sum(cri_r21_f7)+sum(cri_r22_f7)+sum(cri_r23_f7)+sum(cri_r24_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r19_f16)+sum(cri_r20_f16)+sum(cri_r21_f16)+sum(cri_r22_f16)+sum(cri_r23_f16)+sum(cri_r24_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}else{
					$q .= " sum(cri_r25_f$vaccineId)+sum(cri_r26_f$vaccineId) ";
					if($vaccineId == "16"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7)+sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "9"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f7)+sum(cri_r26_f7) " . $subPartOfQuery . " as second ";
					}else if($vaccineId == "18"){
						$q .= $subPartOfQuery . "as  first, (select sum(cri_r25_f16)+sum(cri_r26_f16) " . $subPartOfQuery . " as second ";
					}else{}
				}
			}
		}		
		return $q;
	}
	
	public function subPartQuery($data){
		if($data['reportType'] == 'monthly'){
			$q = " from fac_mvrf_db where fmonth = '" . $data['year']."-".$data['month'] . "'";
		}elseif($data['reportType'] == 'quarterly'){
			$q = " from fac_mvrf_db where fmonth >= '" . $this->monthFrom($data['quarter']) . "' and fmonth <= '" . $this->monthTo($data['quarter']) . "'";
		}elseif($data['reportType'] == 'yearly'){
			$q = " from fac_mvrf_db where fmonth like '" . $data['year']."-%" . "'";
		}else{}
		if($this -> session -> District){
			$q .= " and facode=facilities.facode) ";
		}else{
			$q .= " and distcode=districts.distcode) ";
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
}