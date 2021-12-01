<?php
class Ajax_calls_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}

// public function getunioncouncil($tcode)
// {
// 	$this-> db-> select('*');
// 	$this-> db-> where('tcode',$tcode);
// 	$this-> db-> from('unioncouncil');
//  return	$result = $this->db->get()->result_array();
		
// }
	public function getUnC($tcode) {
		$query = "SELECT uncode,unname from unioncouncil where tcode = '$tcode' order by unname ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $unc_data) {
			$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['unname'] . '</option>';
		}
		return $data;
	}
	public function getFacility($uncode) {
		$query = "SELECT facode,facilityname from facilities where uncode = '$uncode' order by facilityname ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			$data .= '<option value="' . $fac_data['facode'] . '">' . $fac_data['facilityname'] . '</option>';
		}
		return $data;
	}
	public function getFacilityType() {
		$query = "SELECT DISTINCT  fatype from facilities  order by fatype ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $fac_data) {
			if ($fac_data['fatype']!="") {
				# code...
				$data .= '<option value="' . $fac_data['fatype'] . '">' . $fac_data['fatype'] . '</option>';
			}
			
		}
		return $data;
	}
	public function getFacilityuc($distcode) {

		 $query = "SELECT DISTINCT uncode, unioncouncil(uncode) as unname from facilities where distcode = '$distcode' order by uncode ASC ";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		$data = '<option value="">--Select--</option>';
		foreach ($result as $unc_data) {
			if ($unc_data['uncode']!="") {
				$data .= '<option value="' . $unc_data['uncode'] . '">' . $unc_data['unname'] . '</option>';
			}
			
		}
		return $data;
	}

	public function dashbord($wc) {
		
		// echo $year;
		// echo $month;
		//return $data;
		$query = "select a.distcode, a.districtname as label, b.disbursedamount as y from district a inner join
  (select distcode, sum(disbursedamount) as disbursedamount from activitydetails $wc group by distcode) as b 
  on a.distcode=b.distcode where a.projectstatus=1 order by b.disbursedamount desc";
		//print_r($query);exit;
		$result=$this -> db -> query ($query);
		$data=$result -> result_array();
		//echo '<pre>';print_r($data['supervisordata']);echo '</pre>';exit;
		//print_r($data);
		return $data;
	}
	/*
	@ Author:        Nasir Israr
	@ Email:         nasir@pace-tech.com
	@ Function:      Get months
	@ Description:   Form dropdowns
	*/
	public function getAjaxMonthsOptions($isreturn=false,$selectedYear=NULL){
		$months = array("01" => 'January', "02" => 'February', "03" => 'March', "04" => 'April', "05" => 'May', "06" => 'June', "07" => 'July', "08" => 'August', "09" => 'September', "10" => 'October', "11" => 'November', "12" => 'December');
		$mnth = isset($_REQUEST["month"])?$_REQUEST["month"]:'';
		$currMyear = date("Y");
		$output = '';
		$prevMyear = $selectedYear;//date("Y", strtotime( date( 'Y-m-01' )." -1 months"));
		if($currMyear==$prevMyear && ($selectedYear==NULL || $selectedYear==$currMyear))
		{
			for ($i = 12; $i >= 1; $i--) {
				$currM = date("m");
				if($i>=$currM)
				{}
				else{
					$isSelected = ($mnth==$i)?'selected="selected"':'';
					$month = sprintf("%02d", $i);
					$output .= '<option value="'.$month.'" '.$isSelected.' >'.$months[$month].'</option>';
				}
			}
		}
		else if($currMyear > $prevMyear)
		{
			$output .= '<option value="">-- Select --</option>';
			for ($i = 12; $i >= 1; $i--) {
				//$num = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
				$isSelected = ($mnth==$i)?'selected="selected"':'';
				$month = sprintf("%02d", $i);
				$output .= '<option value="'.$month.'" '.$isSelected.' >'.$months[$month].'</option>';
			}
		}	
		if($isreturn)
			return $output;
		echo $output;
	}

	public function getDistrictOpeningBal($month,$year,$distcode){
		$datestring=$year.'-'.$month.'-13 first day of last month';
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
		//for column names
		$selectCols ="";
		for($i=1;$i<8;$i++)
		{
			$selectCols .= "lg_r".$i."_f6,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from dist_stock_db where distcode = '$distcode' and fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		//echo .'XX'.$month.'BB'.$year.'CC'.$facode;exit();
		//print_r($result);exit();
		for($i=1;$i<8;$i++)
		{
			$key = "lg_r".$i."_f6";
			$toEncode[$key] = $result[$key];
		}
		return json_encode($toEncode);
	}
	public function getProvinceOpeningBal($month,$year){
		$datestring=$year.'-'.$month.'-13 first day of last month';
		$dt=date_create($datestring);
		$fmonth = $dt->format('Y-m');
		//for column names
		$selectCols ="";
		for($i=1;$i<8;$i++)
		{
			$selectCols .= "lg_r".$i."_f6,";
		}
		$selectCols = rtrim($selectCols,",");
		$query="select $selectCols from pro_stock_db where fmonth = '$fmonth' ";
		$resultAR=$this->db->query($query);
		$result = $resultAR->row_array();
		//echo .'XX'.$month.'BB'.$year.'CC'.$facode;exit();
		//print_r($result);exit();
		for($i=1;$i<8;$i++)
		{
			$key = "lg_r".$i."_f6";
			$toEncode[$key] = $result[$key];
		}
		return json_encode($toEncode);
	}
	public function dist_stock_filter($year, $month) {
		//$procode = isset($_REQUEST['procode']) ? $_REQUEST['procode'] : 3;
		//$distcode = isset($_REQUEST['distcode']) ? $_REQUEST['distcode'] : $_SESSION['District'];
		if($this-> session-> userdata('distcode')){
			$distcode = $this-> session-> userdata('distcode');
		}
		$wc = '';
		if ($year > 0) {
			$wc .= "and year = '{$year}'";
		}
		if($month > 0){			
			$wc .= " and month = '{$month}'";
		}		
		//print_r($query);exit;
		// "SELECT year, month, distcode, districtname(distcode) as district from dist_stock_db where distcode = '$distcode' order by year desc";
		$query="SELECT year, month, distcode, submitted_date, districtname(distcode) as district from dist_stock_db where distcode='{$distcode}' $wc order by year DESC";		
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = 1;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td style="text-align: center;">' . $i . '</td>	
							<td>' . $row['district'] . '</td>			
							<td style="text-align: center;">' . $row['year'] . '</td>
							<td style="text-align: center;">' . $row['month'] . '</td>
							<td style="text-align: center;">' . date('d-m-Y', strtotime($row['submitted_date'])) . '</td>
							<td>							
								<a href="' . base_url() . 'Stock_reports/dist_stockreport_view/' . $row['distcode'] . '/'. $row['year'].'/'. $row['month'].'" data-toggle="tooltip" title="View" class="btn view-btn"><i class="fa fa-search"></i></a>
								<a href="' . base_url() . 'Stock_reports/dist_stockreport_edit/' . $row['distcode'] .'/'. $row['year'].'/'. $row['month'].'" data-toggle="tooltip" title="Edit" class="btn edit-btn"><i class="fa fa-pencil"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;		
		return json_encode($resultJson);
	}

	public function pro_stock_filter($year, $month) {	
		$wc = '';
		if ($year > 0) {
			$wc .= "where year = '{$year}'";
		}
		if($month > 0){
			if ($wc==''){
				$wc .= "where month = '{$month}'";
			}
			else{
				$wc .= " and month = '{$month}'";
			}					
		}		
		$query="SELECT year, month, submitted_date from pro_stock_db $wc order by year DESC ";
		//echo $query="SELECT year, month, submitted_date from pro_stock_db $wc order by year DESC "; exit();
		//print_r($query); exit();
		$result = $this -> db -> query($query);		
		$result = $result -> result_array();
		//print_r($result);exit;
		$i = 1;
		$resultJson = array();
		$tbody = "";
		foreach ($result as $row) {
			$i++;	
		
			$tbody .= '<tr>
							<td style="text-align: center;">' . $i . '</td>	
							<td>' . "Khyber Pakhtunkhwa" . '</td>			
							<td style="text-align: center;">' . $row['year'] . '</td>
							<td style="text-align: center;">' . $row['month'] . '</td>
							<td style="text-align: center;">' . date('d-m-Y', strtotime($row['submitted_date'])) . '</td>
							<td>							
								<a href="' . base_url() . 'Stock_reports/pro_stockreport_view/' . $row['year'].'/'. $row['month'].'" data-toggle="tooltip" title="View" class="btn view-btn"><i class="fa fa-search" aria-hidden="true"></i></a>
								<a href="' . base_url() . 'Stock_reports/pro_stockreport_edit/' . $row['year'].'/'. $row['month'].'" data-toggle="tooltip" title="Edit" class="btn edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
							</td>
						</tr>';
		}
		$resultJson["tbody"] = $tbody;
		return json_encode($resultJson);
	}
		public function getMeasles_Case($distcode) {
				
		$this-> db-> select ('id,case_epi_no,case_type,report_submit_status,patient_name,patient_fathername,specimen_received_date,quantity_adequate,cold_chain_ok,specimen_received_by,received_by_designation,lab_id_number,lab_testdone_date,type_of_test,specimen_result,comments,lab_report_sent_date,report_sent_by,sent_by_designation,result_saved_date');
		$this-> db-> from ('case_investigation_db');
		$this->db->where('report_submit_status', 0);
		$this->db->where('distcode', $distcode);
		$data['district'] = $this-> db-> get()-> result_array();
		//return $data;
		return json_encode($data);
	}

}
?>