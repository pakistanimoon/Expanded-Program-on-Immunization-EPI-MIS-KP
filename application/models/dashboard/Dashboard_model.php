<?php
class Dashboard_model extends CI_Model {

	public function getComplianceData($fmonth){
		if($this -> session -> District){
			$this -> db -> select('facilityname(facode) as facility, (select count(facode) from fac_mvrf_db fac where fac.facode=facilities.facode and fmonth = \''.$fmonth.'\' and distcode = \''. $this -> session -> District .'\') as cnt');
			$this -> db -> from('facilities');
			$this -> db -> where(array('hf_type'=>'e','distcode'=>$this->session->District));
			$this -> db -> order_by('fac_name');
		}else{
			$this -> db -> select('distcode,district,(select count(*) from facilities fac where fac.distcode = districts.distcode and fac.hf_type=\'e\') as due,(select count(*) from fac_mvrf_db fmvrf where fmvrf.distcode=districts.distcode and fmonth = \''.$fmonth.'\') as sub');
			$this -> db -> from('districts');
			$this -> db -> order_by('district');
		}
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function getComplianceDataDrillDownSeries($fmonth){
		if($this -> session -> District){}else{
			$this -> db -> select('districtname(distcode) as district,facilityname(facode) as facility, (select count(facode) from fac_mvrf_db fac where fac.facode=facilities.facode and fmonth = \''.$fmonth.'\') as cnt');
			$this -> db -> from('facilities');
			$this -> db -> where('hf_type','e');
			$this -> db -> order_by('district,fac_name');
			$result = $this -> db -> get() -> result();
			return $result;
		}
	}
	public function getVaccineCoverage($data, $selectQuery){
		$this -> db -> select($selectQuery);
		$this -> db -> group_by('code,name');
		if($this -> session -> District)
			$distcode = $this -> session -> District;
		else
			$distcode = $data['distcode'];
		if($this -> session -> District || $data['distcode']>0){
			$this -> db -> from('facilities');
			$this -> db -> where(array('hf_type' => 'e', 'distcode' => $distcode));
		}else{
			$this -> db -> from('districts');
		}
		$this -> db -> order_by('name');
		$result = $this -> db -> get() -> result();
		//echo $this->db->last_query();exit;
		return $result;
	}
	public function getVaccineCoverageMonth($data, $selectQuery){
		$this -> db -> select($selectQuery);
		$this -> db -> from ('fac_mvrf_db');
		$this -> db -> join ('facilities fac','fac_mvrf_db.facode=fac.facode');
		$this -> db -> like('fmonth',$data['year']);
		$this -> db -> where('hf_type','e');
		$this -> db -> where ('fac.facode',$data['distcode']);
		$this -> db -> group_by ('fmonth');
		$this -> db -> group_by ('fac.facode');
		$this -> db -> group_by ('fac.fac_name');
		$result = $this -> db -> get() -> result();
		//echo $this->db->last_query();exit;
		return $result;
	}
	public function getVaccinesDropout($data, $selectQuery){
		$this -> db -> select($selectQuery);
		$this -> db -> group_by('code,name');
		if($this -> session -> District){
			$this -> db -> from('facilities');
			$this -> db -> where(array('hf_type' => 'e', 'distcode' => $this -> session -> District));
		}else{
			$this -> db -> from('districts');
		}
		$this -> db -> order_by('name');
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function getCRComplianceData($fmonth){
		if($this -> session -> District){
			$this -> db -> select('facilityname(facode) as facility, (select count(facode) from form_b_cr fac where fac.facode=facilities.facode and fmonth = \''.$fmonth.'\' and distcode = \''. $this -> session -> District .'\') as cnt');
			$this -> db -> from('facilities');
			$this -> db -> where(array('hf_type'=>'e','distcode'=>$this->session->District));
			$this -> db -> order_by('fac_name');
		}else{
			$this -> db -> select('distcode,district,(select count(*) from facilities fac where fac.distcode = districts.distcode and fac.hf_type=\'e\') as due,(select count(*) from form_b_cr fmvrf where fmvrf.distcode=districts.distcode and fmonth = \''.$fmonth.'\') as sub');
			$this -> db -> from('districts');
			$this -> db -> order_by('district');
		}
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function getCRComplianceDataDrillDownSeries($fmonth){
		if($this -> session -> District){}else{
			$this -> db -> select('districtname(distcode) as district,facilityname(facode) as facility, (select count(facode) from form_b_cr fac where fac.facode=facilities.facode and fmonth = \''.$fmonth.'\') as cnt');
			$this -> db -> from('facilities');
			$this -> db -> where('hf_type','e');
			$this -> db -> order_by('district,fac_name');
			$result = $this -> db -> get() -> result();
			return $result;
		}
	}
	public function getMainIndicatorsData($year=null){
		if($this -> session -> District){
			$this -> db -> select('population as pop');
			$this -> db -> where('distcode',$this -> session -> District);
		}else{
			$this -> db -> select('sum(population::integer) as pop');
		}
		//print_r($year);exit;		
		if($year !=NULL)		
		{
			$this -> db -> where('year',$year);		
		}		
		else		
		{			
			$this -> db -> where('year',date('Y'));		
		}
		$result = $this -> db -> get('districts_population') -> row();
		//echo $this->db->last_query();exit;
		// --------------------------------------------------------------------------------------------- //
		$data['provincePopulation']		 = (isset($result->pop) && $result->pop > 0)?(int)$result->pop:0;
		$data['anuualTargetPopulation']  = round(($data['provincePopulation']*3.533)/100);
		$data['monthlyTargetPopulation'] = round($data['anuualTargetPopulation']/12);
		$data['annualSurvivingInfants']  = round(($data['anuualTargetPopulation']*94.2)/100);
		$data['monthlySurvivingInfants'] = round($data['annualSurvivingInfants']/12);
		$data['annualPregnantLactatingPlWomen'] = round($data['anuualTargetPopulation']*1.02);
		$data['monthlyPregnantLactatingPlWomen'] = round($data['annualPregnantLactatingPlWomen']/12);
		// --------------------------------------------------------------------------------------------- //
		$data['annualPnnMortality'] = round(($data['annualSurvivingInfants']*98.3)/100);
		$data['monthlyPnnMortality'] = round($data['annualPnnMortality']/12);
		$data['childrenLessThan5Years'] = round(($data['provincePopulation']*16)/100);
		$data['cbaLadies'] = round(($data['provincePopulation']*22)/100);
		$data['below15Years'] = round(($data['provincePopulation']*45)/100);
		// --------------------------------------------------------------------------------------------- //
		$this -> db -> select('sum(tot_lhw_involved_vacc) as tot_lhws');
		if($this -> session -> District){
			$this -> db -> where(array(
										'fmonth' => date('Y-m',strtotime('-1 month')),
										'distcode' => $this -> session -> District
									));
		}else{
			$this -> db -> where('fmonth',date('Y-m',strtotime('-1 month')));
		}
		
		$result = $this -> db -> get('fac_mvrf_db') -> row();
		$data['totalLHWs'] = (int)$result->tot_lhws;
		// --------------------------------------------------------------------------------------------- //
		$this -> db -> select('count(facode) as tot_reports');
		if($this -> session -> District){
			$this -> db -> where('distcode',$this -> session -> District);
		}else{}
		$this -> db -> like('fmonth',date('Y'),'after');
		$result = $this -> db -> get('fac_mvrf_db') -> row();
		$data['totalEpiVaccinationReports'] = (int)$result->tot_reports;
		// --------------------------------------------------------------------------------------------- //
		$query = "select district,
				(select count(*) from facilities where distcode=districts.distcode and hf_type='e') as tot_facilities,
				(select count(*) from supervisordb where distcode=districts.distcode and status='Active') as tot_supervisors,
				(select count(*) from techniciandb where distcode=districts.distcode and status='Active') as tot_technicians,
				(select count(*) from med_techniciandb where distcode=districts.distcode and status='Active') as tot_medtechnicians,
				(select count(*) from dsodb where distcode=districts.distcode and status='Active') as tot_dsos,
				(select count(*) from driverdb where distcode=districts.distcode and status='Active') as tot_drivers,
				(select count(*) from codb where distcode=districts.distcode and status='Active') as tot_cos
				from districts order by district";
		$query = $this -> db -> query($query);
		$data['tableInfo'] = $query->result_array();
		return $data;
	}
	public function getZeroComplianceData($fweek){
		if($this -> session -> District){
		}else{
			$this -> db -> select('distcode,district as name,(select count(facode) from facilities where hf_type=\'e\' and distcode=districts.distcode) as total, (select count(facode) from zero_report where report_submitted = \'1\' and submitted_date IS NOT NULL and fweek = \''.$fweek.'\' and distcode = districts.distcode ) as timely,(select count(facode) from zero_report where report_submitted = \'1\' and submitted_date IS NULL and updated_date IS NOT NULL and fweek = \''.$fweek.'\' and distcode = districts.distcode ) as complete');
			$this -> db -> from('districts');
			$this -> db -> order_by('district');
		}
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function getZeroComplianceDataDrillDownSeries($fweek){
		if($this -> session -> District){}else{
			$this -> db -> select('districtname(distcode) as district,facilityname(facode) as facility, (select count(facode) from fac_mvrf_db fac where fac.facode=facilities.facode and fmonth = \''.$fmonth.'\') as cnt');
			$this -> db -> from('facilities');
			$this -> db -> where('hf_type','e');
			$this -> db -> order_by('district,fac_name');
			$result = $this -> db -> get() -> result();
			return $result;
		}
	}
	public function getPopulationData(){
		$this -> db -> select('district as name,distcode as code, population as pop');
		$this -> db -> from('districts');
		$this -> db -> order_by('name');
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function getFacilitesPopulationData($code){
		$this -> db -> select('fac_name as name,facode as code, catchment_area_pop as pop');
		$this -> db -> from('facilities');
		$this -> db -> where(array('hf_type'=>'e','distcode'=>$code));
		$this -> db -> order_by('name');
		$result = $this -> db -> get() -> result();
		return $result;
	}
	public function sessionInfo($year,$month,$reportType,$session_type,$quarter){
		if($reportType == "yearly")
		{
			$wClause = " fmonth like '$year%' ";
		}else if($reportType == "quarterly"){
			switch($quarter){
				case 'Q1':
					$wClause = " fmonth >= '{$year}-01' and fmonth <= '{$year}-03' ";
					break;
				case 'Q2':
					$wClause = " fmonth >= '{$year}-04' and fmonth <= '{$year}-06' ";
					break;
				case 'Q3':
					$wClause = " fmonth >= '{$year}-07' and fmonth <= '{$year}-09' ";
					break;
				case 'Q4':
					$wClause = " fmonth >= '{$year}-10' and fmonth <= '{$year}-12' ";
					break;
			}
		}
		else
		{
			$fmonthC = $year."-".$month;
			$wClause = " fmonth = '$fmonthC' ";
		}
		$selct='';
		if($session_type == "Fixed"){
			$selct = "
						sum(fixed_vacc_planned) as planned,sum(fixed_vacc_held) as conducted,
						sum(fixed_vacc_held)*100/NULLIF(sum(fixed_vacc_planned),0) as perc ,
			";
		}
		else if ($session_type == "Outreach"){
			$selct = "
						sum(or_vacc_planned) as planned,sum(or_vacc_held) as conducted,
						sum(or_vacc_held)*100/NULLIF(sum(or_vacc_planned),0) as perc,
			";
		}
		else if($session_type == "LHW"){
			$selct = "
						sum(hh_vacc_planned) as planned,sum(hh_vacc_held) as conducted,
						sum(hh_vacc_held)*100/NULLIF(sum(hh_vacc_planned),0) as perc,
			";
		}
		else if($session_type == "ALL"){
			$selct = "
				sum(fixed_vacc_planned)+sum(or_vacc_planned)+sum(hh_vacc_planned) as planned,sum(fixed_vacc_held)+sum(or_vacc_held)+sum(hh_vacc_held) as conducted,
				sum(fixed_vacc_held+or_vacc_held+hh_vacc_held)*100/NULLIF(sum(fixed_vacc_planned+or_vacc_planned+hh_vacc_planned),0) as perc,
			";
		}else if($session_type == "Mobile"){
			$selct = "
						sum(mv_vacc_planned) as planned,sum(mv_vacc_held) as conducted,
						sum(mv_vacc_held)*100/NULLIF(sum(mv_vacc_planned),0) as perc  ,
			";
		}
		$queryForDist = "select $selct districtname(distcode) as name,distcode as code from fac_mvrf_db where $wClause group by distcode order by districtname(distcode) ASC";
		//echo $queryForDist;exit;
		$result = $this->db->query($queryForDist);
		$result = $result->result();
		return $result;
	}
	public function sessionInfoFac($year,$dist,$month,$reportType,$session_type,$quarter){
		if($reportType == "yearly")
		{
			$wClause = " fmonth like '$year%' ";
		}else if($reportType == "quarterly"){
			switch($quarter){
				case 'Q1':
					$wClause = " fmonth >= '{$year}-01' and fmonth <= '{$year}-03' ";
					break;
				case 'Q2':
					$wClause = " fmonth >= '{$year}-04' and fmonth <= '{$year}-06' ";
					break;
				case 'Q3':
					$wClause = " fmonth >= '{$year}-07' and fmonth <= '{$year}-09' ";
					break;
				case 'Q4':
					$wClause = " fmonth >= '{$year}-10' and fmonth <= '{$year}-12' ";
					break;
			}
		}
		else
		{
			$fmonthC = $year."-".$month;
			$wClause = " fmonth = '$fmonthC' ";
		}
		$selct='';
		if($session_type == "Fixed"){
			$selct = "
						sum(fixed_vacc_planned) as planned,sum(fixed_vacc_held) as conducted,
						sum(fixed_vacc_held)*100/NULLIF(sum(fixed_vacc_planned),0) as perc  ,
			";
		}
		else if ($session_type == "Outreach"){
			$selct = "
						sum(or_vacc_planned) as planned,sum(or_vacc_held) as conducted,
						sum(or_vacc_held)*100/NULLIF(sum(or_vacc_planned),0) as perc ,
			";
		}
		else if($session_type == "LHW"){
			$selct = "
						sum(hh_vacc_planned) as planned,sum(hh_vacc_held) as conducted,
						sum(hh_vacc_held)*100/NULLIF(sum(hh_vacc_planned),0) as perc ,
			";
		}
		else if($session_type == "ALL"){
			$selct = "
				sum(fixed_vacc_planned)+sum(or_vacc_planned)+sum(hh_vacc_planned) as planned,sum(fixed_vacc_held)+sum(or_vacc_held)+sum(hh_vacc_held) as conducted,
				sum(fixed_vacc_held+or_vacc_held+hh_vacc_held)*100/NULLIF(sum(fixed_vacc_planned+or_vacc_planned+hh_vacc_planned),0) as perc ,
			";
		}else if($session_type == "Mobile"){
			$selct = "
						sum(mv_vacc_planned) as planned,sum(mv_vacc_held) as conducted,
						sum(mv_vacc_held)*100/NULLIF(sum(mv_vacc_planned),0) as perc  ,
			";
		}
		$queryForDist = "select $selct facilityname(facode) as name,facode as code from fac_mvrf_db where $wClause and distcode='$dist' group by facode order by facilityname(facode) asc";
		//queryForMonth = "select fixed_vacc_planned as planned,fixed_vacc_held as conducted,facilities.fac_name as name,CASE WHEN fmonth = '2016-01' THEN 'JANUARY' WHEN fmonth = '2016-02' THEN 'FEBRUARY' WHEN fmonth = '2016-03' THEN 'MARCH' WHEN fmonth = '2016-04' THEN 'APRIL' WHEN fmonth = '2016-05' THEN 'MAY' WHEN fmonth = '2016-06' THEN 'JUNE' WHEN fmonth = '2016-07' THEN 'JULY' WHEN fmonth = '2016-08' THEN 'AUGUST' WHEN fmonth = '2016-09' THEN 'SEPTEMBER' WHEN fmonth = '2016-10' THEN 'OCTOBER' WHEN fmonth = '2016-11' THEN 'NOVEMBER' WHEN fmonth = '2016-12' THEN 'DECEMBER' END  as month from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where fmonth like '2016%' and facilities.facode='332086'";
		//echo $queryForDist;exit;
		$result = $this->db->query($queryForDist);
		$result = $result->result();
		return $result;
	}
	public function sessionInfoFacMonth($year,$code,$reportType,$session_type,$quarter){
		//set fmonth condition according to query
		if($reportType == "yearly")
		{
			$wClause = " fmonth like '$year%' ";
		}else if($reportType == "quarterly"){
			switch($quarter){
				case 'Q1':
					$wClause = " fmonth >= '{$year}-01' and fmonth <= '{$year}-03' ";
					break;
				case 'Q2':
					$wClause = " fmonth >= '{$year}-04' and fmonth <= '{$year}-06' ";
					break;
				case 'Q3':
					$wClause = " fmonth >= '{$year}-07' and fmonth <= '{$year}-09' ";
					break;
				case 'Q4':
					$wClause = " fmonth >= '{$year}-10' and fmonth <= '{$year}-12' ";
					break;
			}
		}
		else
		{
			$fmonthC = $year."-".$month;
			$wClause = " fmonth = '$fmonthC' ";
		}
		$queryForMonth = "";
		if($session_type == "Fixed")
			$queryForMonth = "select fixed_vacc_planned as planned,fixed_vacc_held as conducted,facilities.fac_name as name,facilities.facode as code,CASE WHEN fmonth = '$year-01' THEN 'JANUARY' WHEN fmonth = '$year-02' THEN 'FEBRUARY' WHEN fmonth = '$year-03' THEN 'MARCH' WHEN fmonth = '$year-04' THEN 'APRIL' WHEN fmonth = '$year-05' THEN 'MAY' WHEN fmonth = '$year-06' THEN 'JUNE' WHEN fmonth = '$year-07' THEN 'JULY' WHEN fmonth = '$year-08' THEN 'AUGUST' WHEN fmonth = '$year-09' THEN 'SEPTEMBER' WHEN fmonth = '$year-10' THEN 'OCTOBER' WHEN fmonth = '$year-11' THEN 'NOVEMBER' WHEN fmonth = '$year-12' THEN 'DECEMBER' END  as month from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where fmonth like '$year%' and facilities.facode='$code'";
		else if ($session_type == "Outreach")
			$queryForMonth = "select or_vacc_planned as planned,or_vacc_held as conducted,facilities.fac_name as name,facilities.facode as code,CASE WHEN fmonth = '$year-01' THEN 'JANUARY' WHEN fmonth = '$year-02' THEN 'FEBRUARY' WHEN fmonth = '$year-03' THEN 'MARCH' WHEN fmonth = '$year-04' THEN 'APRIL' WHEN fmonth = '$year-05' THEN 'MAY' WHEN fmonth = '$year-06' THEN 'JUNE' WHEN fmonth = '$year-07' THEN 'JULY' WHEN fmonth = '$year-08' THEN 'AUGUST' WHEN fmonth = '$year-09' THEN 'SEPTEMBER' WHEN fmonth = '$year-10' THEN 'OCTOBER' WHEN fmonth = '$year-11' THEN 'NOVEMBER' WHEN fmonth = '$year-12' THEN 'DECEMBER' END  as month from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where fmonth like '$year%' and facilities.facode='$code'";
		else if($session_type == "LHW")
			$queryForMonth = "select hh_vacc_planned as planned,hh_vacc_held as conducted,facilities.fac_name as name,facilities.facode as code,CASE WHEN fmonth = '$year-01' THEN 'JANUARY' WHEN fmonth = '$year-02' THEN 'FEBRUARY' WHEN fmonth = '$year-03' THEN 'MARCH' WHEN fmonth = '$year-04' THEN 'APRIL' WHEN fmonth = '$year-05' THEN 'MAY' WHEN fmonth = '$year-06' THEN 'JUNE' WHEN fmonth = '$year-07' THEN 'JULY' WHEN fmonth = '$year-08' THEN 'AUGUST' WHEN fmonth = '$year-09' THEN 'SEPTEMBER' WHEN fmonth = '$year-10' THEN 'OCTOBER' WHEN fmonth = '$year-11' THEN 'NOVEMBER' WHEN fmonth = '$year-12' THEN 'DECEMBER' END  as month from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where fmonth like '$year%' and facilities.facode='$code'";

		//$queryForDist = "select sum(fixed_vacc_planned) as planned,sum(fixed_vacc_held) as conducted,facilities.fac_name as name,facilities.facode as code from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where $wClause and facilities.distcode='$dist' group by facilities.fac_name,facilities.facode";
		//$queryForMonth = "select fixed_vacc_planned as planned,fixed_vacc_held as conducted,facilities.fac_name as name,facilities.facode as code,CASE WHEN fmonth = '$year-01' THEN 'JANUARY' WHEN fmonth = '$year-02' THEN 'FEBRUARY' WHEN fmonth = '$year-03' THEN 'MARCH' WHEN fmonth = '$year-04' THEN 'APRIL' WHEN fmonth = '$year-05' THEN 'MAY' WHEN fmonth = '$year-06' THEN 'JUNE' WHEN fmonth = '$year-07' THEN 'JULY' WHEN fmonth = '$year-08' THEN 'AUGUST' WHEN fmonth = '$year-09' THEN 'SEPTEMBER' WHEN fmonth = '$year-10' THEN 'OCTOBER' WHEN fmonth = '$year-11' THEN 'NOVEMBER' WHEN fmonth = '$year-12' THEN 'DECEMBER' END  as month from fac_mvrf_db join facilities on fac_mvrf_db.facode = facilities.facode where fmonth like '$year%' and facilities.facode='$code'";
		//echo $queryForMonth;exit;
		$result = $this->db->query($queryForMonth);
		$result = $result->result();
		return $result;
	}
	public function cold_room_capacity($whtype,$whcode)
	{
		//note: net capacity and gross capacity values are wrong, they must come from function in db
		$this->db->select("main.short_name as shortname,sub.gross_capacity,sub.net_capacity,get_stored_quantity_litters(main.asset_id,'".date("Y-m-d H:i:s")."','".$whtype."','".$whcode."') as stored");//getccmshortname(ccm_id)
		$this -> db -> from('epi_ccm_cold_rooms sub');
		$this -> db -> join('epi_cc_coldchain_main main',"main.asset_id = sub.ccm_id");
		$this->db->where('main.warehouse_type_id',$whtype);
		$this->db->where(get_warehouse_code_column($whtype),$whcode);
		//$this -> db -> group_by ('main.short_name,sub.gross_capacity,sub.net_capacity');
		$this -> db -> group_by ('main.asset_id,sub.gross_capacity,sub.net_capacity');
		$output = $this->db->get()->result_array();
		//echo $this->db->last_query();exit;
		return $output;
	}
	public function freezer_capacity($whtype,$whcode)
	{
		$this->db->select("main.short_name as shortname,sub.gross_capacity,sub.net_capacity");//getccmshortname(ccm_id)
		$this -> db -> from('epi_ccm_cold_rooms sub');
		$this -> db -> join('epi_cc_coldchain_main main',"main.asset_id = sub.ccm_id");
		$this->db->where('main.warehouse_type_id',$whtype);
		$this->db->where(get_warehouse_code_column($whtype),$whcode);
		$this -> db -> group_by ('main.short_name,sub.gross_capacity,sub.net_capacity');
		$output = $this->db->get()->result_array();
		//echo $this->db->last_query();exit;
		return $output;
	}
	public function capacity_by_vaccine($whtype,$whcode)
	{
		$this->db->select("ccm_id,getccmshortname(ccm_id) as shortname,get_product_name(item_pack_size_id) as itemname,quantity");
		$this -> db -> from('epi_stock_batch');
		$this->db->where('warehouse_type_id',$whtype);
		$this->db->where('code',$whcode);
		$this -> db -> where("ccm_id is NOT NULL");
		$this->db->group_by('ccm_id,item_pack_size_id,quantity');
		return $this->db->get()->result_array();
	}
	public function getAllHRData()
	{
		$UserLevel = $this -> session -> UserLevel;
		if($UserLevel==2){
			$procode = $this->session->Province;
			$wc[]= "post_procode = '".$procode."' ";
		}
		if($this->session->District){

			$wc[]= "post_distcode = '".$this->session->District."'";
        } 
	    if($this->session->Tehsil){
			$wc[]= "post_tcode = '".$this->session->Tehsil ."'";
		}
		$wc[]= "post_status = 'Active'";
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  '); 
		if($UserLevel==2){
			$query = 'SELECT post_hr_sub_type_id,COUNT(*) from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery '.$where.' group by post_hr_sub_type_id ';
		}else{
			$query = 'SELECT post_distcode,post_hr_sub_type_id,COUNT(*) from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery '.$where.' group by post_distcode,post_hr_sub_type_id ';
		}
		$result=$this->db->query($query);    
		$data=$result->result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;  
		return $data;
	}
	public function getAllHRDistrictData($type_id)
	{
		$UserLevel = $this -> session -> UserLevel;
		if($UserLevel==2){
			$procode = $this->session->Province;
			$wc[]= "post_procode = '".$procode."' ";
		}
		$wc[]= "post_hr_sub_type_id = '".$type_id."' ";
		$wc[]= "post_status = 'Active'";
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'  ');
		$query = 'SELECT districtname(post_distcode),post_distcode,post_hr_sub_type_id,COUNT(*) from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery  '.$where.' group by post_hr_sub_type_id,post_distcode';
		$result=$this->db->query($query);
		$data=$result->result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit; 
		return $data;
	}
}
?>