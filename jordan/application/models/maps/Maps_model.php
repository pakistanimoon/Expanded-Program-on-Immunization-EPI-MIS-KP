<?php
class Maps_model extends CI_Model {
	
	
	function Priority_diseases($data){
		$id = $data['disease'];
		$query = "select * from idsrs_cases_types where id='$id' ";
		$result = $this->db->query($query);
		$arr = $result->row();
		return $arr;
	}
	function DistrictName($distcode="")
    {  
        //echo 'i m here';exit();
        $_query  = "select district from districts where distcode = '$distcode'";
        $results=$this->db->query($_query);
        $rows=$results->row_array();
        
        return $rows['district'];
    }
	function districtWiseMapData($fmonth="2016-01"){
		$query = "
					SELECT 
					d1.distcode as code,
					d1.district as name,
					(SELECT sum(case when getfstatus_vacc('{$fmonth}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where fac.distcode = d1.distcode and fac.hf_type='e') as due,
					(SELECT count(*) from fac_mvrf_db fmvrf where fmvrf.distcode=d1.distcode and fmonth = '{$fmonth}') as sub,
					(select count(*) from fac_mvrf_db fmvrf where fmonth like '{$fmonth}' and getfstatus_vacc('{$fmonth}',facode)='F' and  fmvrf.distcode=d1.distcode  and submitted_date <=date'{$fmonth}-05'+interval '1 month'  and submitted_date >=date'{$fmonth}-01'+interval '1 month') as timely,
					d2.path 
						FROM districts d1
							LEFT JOIN districts_wise_maps_paths d2 ON d1.distcode=d2.distcode";
		//echo $query;exit();
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	function getdistrictWiseMapData($code=NULL,$querySelection,$firstqueryselection=NULL,$lastqueryselection=NULL){
		if($code){
			$query = "
					SELECT 
					u2.uncode as code,
					u2.ucname as name,
					{$querySelection}
					u2.path 
					FROM unioncouncil u1
						  RIGHT JOIN uc_wise_maps_paths u2 ON u1.uncode=u2.uncode where u2.distcode='{$code}'";
		}
		else
		{
			$query = "
					{$firstqueryselection}
					SELECT 
					d1.distcode as code,
					d1.district as name,
					{$querySelection}
					d2.path 
						FROM districts d1
							LEFT JOIN districts_wise_maps_paths d2 ON d1.distcode=d2.distcode {$lastqueryselection}";
		}
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	function UcWiseMapData($code,$fmonth="2016-01"){
		$query = "
					SELECT 
						u2.uncode as code,
						u2.ucname as name,
						(SELECT sum(case when getfstatus_vacc('".$fmonth."', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where fac.uncode = u1.uncode and fac.hf_type='e' and fac.distcode = '".$code."') as due,
						(SELECT count(*) from fac_mvrf_db fmvrf where fmvrf.uncode=u1.uncode and fmvrf.fmonth = '".$fmonth."' and u1.distcode = '".$code."') as sub,
						u2.path 
						  FROM unioncouncil u1
						  RIGHT JOIN uc_wise_maps_paths u2 ON u1.uncode=u2.uncode where u2.distcode='".$code."'
				";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	function getUcDetails($code,$fmonth){
		$query = "
					SELECT 
						f1.facode as code,
						facilityname(f1.facode) as name,
						f1.catchment_area_pop as pop, 
						exists(select facode from fac_mvrf_db where facode=f1.facode and uncode='".$code."' and fmonth='".$fmonth."') as report_submitted 
							FROM facilities f1 
							WHERE f1.uncode='".$code."' 
							AND f1.hf_type='e'
				";
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getVaccineCoverage($data, $selectQuery,$order=NULL){
		$query = "
					SELECT 
					{$selectQuery}";
		if($order){}else{
			$query .= " ,d2.path ";
		}
			$query .= "
						FROM districts
							LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		if($order)
			$query .= " order by sum desc";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getUCsVaccineCoverage($data, $selectQuery,$order=NULL){
		$code = $this -> session -> District;
		if(isset($data['id']) && $data['id']>0)
			$code = $data['id'];
		$query = "
					SELECT 
					{$selectQuery}";
		if($order){}else{
			$query .= " ,uc_wise_maps_paths.path ";
		}
			$query .= "
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		if($order)
			$query .= " order by sum desc";//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getVaccinesDropout($data, $selectQuery,$order=NULL){
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,d2.path ";
		}
			$query .= "
						FROM districts
							LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		if($order)
			$query .= " order by second, first desc";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getUCsVaccineDropout($data, $selectQuery,$order=NULL){
		$code = $this -> session -> District;
		if(isset($data['id']) && $data['id']>0)
			$code = $data['id'];
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,uc_wise_maps_paths.path ";
		}
			$query .= "
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		if($order)
			$query .= " order by sum desc";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getFullyImmunizedCoverge($data, $selectQuery,$order=NULL){
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,d2.path ";
		}
			$query .= "
						FROM districts
							LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		if($order)
			$query .= " order by second, first desc";
		//echo $query;exit();
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getUCsFullyImmunizedCoverge($data, $selectQuery,$order=NULL){
		$code = $this -> session -> District;
		if(isset($data['id']) && $data['id']>0)
			$code = $data['id'];
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,uc_wise_maps_paths.path ";
		}
			$query .= "
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		if($order)
			$query .= " order by sum desc";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getVaccinatorToPopulationData($data, $selectQuery){
		$query = "
					SELECT 
					$selectQuery,
					d2.path
						FROM districts
						LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getUCsVaccinatorToPopulationData($data, $selectQuery){
		$code = $this -> session -> District;
		if(isset($data['id']) && $data['id']>0)
			$code = $data['id'];
		$query = "
				SELECT 
					$selectQuery,
					uc_wise_maps_paths.path 
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getTargetAndCoverageData($data, $selectQuery){
		$query = "select round(target*51/100) as mTarget, round(mVac*100/round(target*51/100)) as mCoverage,
					 round(target*49/100) as fTarget, round(fVac*100/round(target*49/100)) as fCoverage,
					 (round(target*51/100)+round(target*49/100)) as totalTarget, round((mVac+fVac)*100/(round(target*51/100)+round(target*49/100))) as totalCoverage from (".$selectQuery." ) as b";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getDropoutIndicator($data, $selectQuery){
		$vacId = $data['vaccineId'];
		$name = 'cri';
		$rowM = 'r25';
		$rowF = 'r26';
		switch ($vacId) {
			case '18':
				$firstCol = 'f16';
				$secondCol = 'f18';
				break;
			case '2':
				$firstCol = 'f1';
				$secondCol = 'f2';
				$name = 'ttri';
				$rowM = 'r9';
				$rowF = 'r10';
				break;
			case '16':
				$firstCol = 'f7';
				$secondCol = 'f16';
				break;
			default:
				$firstCol = 'f7';
				$secondCol = 'f9';
				break;
		}
		$query = "select round( ( sum( coalesce(${name}_${rowM}_${firstCol},0) ) - sum( coalesce(${name}_${rowM}_${secondCol},0) ) )::numeric * 100 / ( case when sum( coalesce(${name}_${rowM}_${firstCol},0) ) = 0 then 1 else sum( coalesce(${name}_${rowM}_${firstCol},0) ) END)::numeric ,2) as mdropout ,

			round( ( sum( coalesce(${name}_${rowF}_${firstCol},0) ) - sum( coalesce(${name}_${rowF}_${secondCol},0) ) )::numeric * 100 / ( case when sum( coalesce(${name}_${rowF}_${firstCol},0) ) = 0 then 1 else sum( coalesce(${name}_${rowF}_${firstCol},0) ) END)::numeric ,2) as fdropout,

			round( ( sum( coalesce(${name}_${rowM}_${firstCol},0) ) + sum( coalesce(${name}_${rowF}_${firstCol},0) ) - sum( coalesce(${name}_${rowM}_${secondCol},0) ) - sum( coalesce(${name}_${rowF}_${secondCol},0) ) )::numeric * 100 / ( case when (sum( coalesce(${name}_${rowM}_${firstCol},0) ) + sum( coalesce(${name}_${rowF}_${firstCol},0)) ) = 0 then 1 else (sum( coalesce(${name}_${rowM}_${firstCol},0) ) + sum( coalesce(${name}_${rowF}_${firstCol},0))) END)::numeric ,2) as totaldropout".$selectQuery;
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getMainIndicatorsData($distcode=0){
		$district = $this -> session -> District;
		if($distcode){
			$district = $distcode;
		}
		if($district){
			$this -> db -> select('population as pop');
			$this -> db -> where('distcode', $district);
		}else{
			$this -> db -> select('sum(population::integer) as pop');
		}
		$result = $this -> db -> get('districts') -> row();
		//echo $this-> db-> last_query(); exit;
		// --------------------------------------------------------------------------------------------- //
		$data['provincePopulation']		 = (int)$result->pop;
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
		$data['annualCbaLadies'] = round(($data['provincePopulation']*22)/100);
		$data['monthlyCbaLadies'] = round($data['annualCbaLadies']/12);
		$data['below15Years'] = round(($data['provincePopulation']*45)/100);
		// --------------------------------------------------------------------------------------------- //
		// --------------------------------------------------------------------------------------------- //
		//$query = "select district,(select count(*) from techniciandb where distcode=districts.distcode) as tot_technicians from districts order by district";
		if($district){
			$this -> db -> select('count(*) as tot_technicians');
			$this -> db -> where('distcode', $district);
		}else{
			$this -> db -> select('count(*) as tot_technicians');
		}
		$result = $this -> db -> get('techniciandb') -> row();
		// --------------------------------------------------------------------------------------------- //
		$data['tot_technicians'] = (int)$result->tot_technicians;
		//$query = $this -> db -> query($query);
		//print_r($query);exit;
		//$data['tot_technicians'] = $query->result_array();
		return $data;
	}

	public function getVaccineIndicatorCoverge($data, $selectQuery,$order=NULL,$orderType=NULL){
		//	echo $selectQuery; exit;
		$query = "
					SELECT 
					$selectQuery";
		if(!$order){}else{
			$query .= " ,d2.path ";
		}
			$query .= "
						FROM districts
							LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		if($order)
			$query .= " order by $order $orderType";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getUCsVaccineIndicatorCoverge($data, $selectQuery,$order=NULL,$orderType=NULL){
		$code = $this -> session -> District;
		if(isset($data['distcode']) && $data['distcode']>0)
			$code = $data['distcode'];
		$query = "
					SELECT 
					$selectQuery";
		if(!$order){}else{
			$query .= " ,uc_wise_maps_paths.path ";
		}
			$query .= "
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		if($order)
			$query .= " order by $order $orderType";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getVaccineIndicatorData($data, $selectQuery,$order=NULL,$orderType=NULL){
		$query = "
					SELECT 
					$selectQuery";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function createListingFilter($dataArray,$year=null){
		$finalString = '';
		if(array_key_exists("epiyears_select", $dataArray)){
			$finalString .= 
			'<div class="form-group">
					<select id="year" name="year" class="filter-status  form-control">';
						foreach ($dataArray['epiyears_select'] as $oneyear) {
							$isSelected = ($oneyear["year"]==$year)?'selected="selected"':'';
							$finalString .= '<option value="'.$oneyear["year"].'" '.$isSelected.'>'.$oneyear["year"].'</option>';
						}
						$finalString .= '</select>
			</div>';
		}
		else{
			$finalString = '';
		}
		return $finalString;
	}
	public function getEPIDCoverge($data, $selectQuery,$order=NULL,$orderType=NULL){
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,d2.path ";
		}
			$query .= "
						FROM districts
							LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode";
		if($order)
			$query .= " order by $order $orderType";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		//echo $this-> db-> last_query();exit;
		return $query -> result();
	}
	public function getUCsEPIDCoverge($data, $selectQuery,$order=NULL,$orderType=NULL){
		$code = $this -> session -> District;
		if(isset($data['id']) && $data['id']>0)
			$code = $data['id'];
		$query = "
					SELECT 
					$selectQuery";
		if($order){}else{
			$query .= " ,uc_wise_maps_paths.path ";
		}
			$query .= "
						FROM unioncouncil
						  RIGHT JOIN uc_wise_maps_paths ON unioncouncil.uncode=uc_wise_maps_paths.uncode where uc_wise_maps_paths.distcode='".$code."'";
		if($order)
			$query .= " order by $order $orderType";
		//echo $query;exit;
		$query = $this -> db -> query($query);
		return $query -> result();
	}
	public function getEPIDIndicator($data, $query,$result=false){
		//echo $query;exit;
		$query = $this -> db -> query($query);
		//echo  $this-> db-> last_query(); exit;
		if($result)
			return $query -> row();
		else
			return $query -> result();
	}
	function weeklyTrendforOut_breakReports($varChart=NULL,$table,$year,$distcode=NULL,$tcode=NULL,$uncode=NULL,$case_type=NULL,$resultType=NULL){
		$CI = & get_instance();
		$wc = $wc1 = "";
		$code="procode";				
		if($distcode){
			$code="distcode";
			$wc = " and m.distcode='{$distcode}'";
			$wc1 = " and distcode='{$distcode}'";
		}		
		if($uncode){
			$code="uncode";
			$wc = " and m.uncode='{$uncode}'";
			$wc1 = " and uncode='{$uncode}'";				
		}
		if($case_type){
			$case_type = " and case_type='{$case_type}'";
		}
		$currentWeekstartDate = date("Y-m-d",strtotime('monday this week'));
		if($varChart=="bubble"){
			//$case_type="";
			/* if($table=="weekly_vpd"){
				$case_type=" and case_type='Diphtheria'";
			} */
			$query ="
				SELECT year,{$code} as code,week,fweek,COUNT(facode) as \"DiseasesCount\"
					FROM 
					{$table}
				where fweek like '{$year}-%' {$wc1} {$case_type}
				group by fweek,week,code,year order by fweek";
				//echo $query;exit;
		}else{
			$query ="
				select e.year,e.epi_week_numb as week,e.fweek,(select count(m.facode) 
				from {$table} m 
				where m.fweek = e.fweek and  m.year='{$year}' {$wc}) as \"DiseasesCount\" 
					from epi_weeks e 
				where e.year='{$year}' and date_from <='{$currentWeekstartDate}' order by e.fweek";
		}
		if($resultType)
		{
			$result = $CI -> db -> query($query) -> result();
		}
		else
		{
			$result = $CI -> db -> query($query) -> result_array();
		}
		return $result;
	}
}
?>