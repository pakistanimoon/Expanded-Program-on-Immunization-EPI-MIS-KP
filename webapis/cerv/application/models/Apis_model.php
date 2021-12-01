<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Apis_model class.
 *
 * @extends CI_Model
 */
class Apis_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	
	function getAllUcChilds($uncode)
	{
		$this -> db -> select('*');
		$this -> db -> where(array('to_uncode' => $uncode, 'status' => 0));
		$result = $this -> db -> get('cerv_shifted_childs_history') -> result_array();
		if( ! empty($result))
		{
			return $result;
		}else
		{
			return 0;
		}
	}
	
	function fetch_child_history_info($childRegistrationNo){
		$this -> db -> select('*');
		$this -> db -> where(array('from_child_registration_no' => $childRegistrationNo, 'status' => 0));
		$result = $this -> db -> get('cerv_shifted_childs_history') -> row_array();
		if( ! empty($result))
		{
			return $result;
		}else
		{
			return false;
		}
	}
	function checkChildRegistered($childRegistrationNo)
	{
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where(array('child_registration_no' => $childRegistrationNo));
		$this -> db -> where('deleted_at IS NULL');
		$result = $this -> db -> get('cerv_child_registration') -> row();
		if($result->cnt > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	function getTableColumns(){
		$this -> db -> select("string_agg(column_name::text, ', ') as columns");
		$this -> db -> where("table_schema = 'public' AND table_name = 'cerv_child_registration' AND column_name NOT IN ('recno', 'child_registration_no', 'cardno', 'reg_facode', 'year')");
		$result = $this -> db -> get('information_schema.columns',FALSE,NULL) -> row();
		return $result -> columns;
	}
	function replaceCardNo($query, $oldRegistrationNumber){
		$this -> db -> query($query);
		$this -> db -> update('cerv_child_registration', array('deleted_at' => date('Y-m-d h:i:s')), array('child_registration_no' => $oldRegistrationNumber));
		return true;
	}
	function checkChildRegisteredOutside($registeringFacilityCode,$cardNo,$dataofbirth){
		$this -> db -> select('child_registration_no,count(*) as cnt');
		$this -> db -> where(array('reg_facode' => $registeringFacilityCode, 'cardno' => $cardNo, 'dateofbirth' => $dataofbirth));
		$this -> db -> where('deleted_at IS NULL');
		$this -> db -> group_by('child_registration_no');
		$result = $this -> db -> get('cerv_child_registration') -> row();
		if($result->cnt > 0)
		{
			return $result -> child_registration_no;
		}else
		{
			return false;
		}
	}
	function updateChildRegistrationData($data,$childRegistrationNo){
		$this -> db -> update('cerv_child_registration',$data,array('child_registration_no' => $childRegistrationNo));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function updateSequence($childRegistrationNo){
		$this -> db -> query("UPDATE cerv_child_registration SET recno=nextval('child_registration_seq') where child_registration_no = '{$childRegistrationNo}'");
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function updateWomenSequence($womenRegistrationNo){
		$this -> db -> query("UPDATE cerv_mother_registration SET recno=nextval('mother_registration_seq') where mother_registration_no = '{$womenRegistrationNo}'");
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function saveNewRegisteredChildData($data){
		$this -> db -> insert('cerv_child_registration',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function saveNewRegisteredChildDatasuppport($data_support){
		$this -> db -> insert('cerv_support',$data_support);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function checkMotherRegistered($motherRegistrationNo)
	{
		$this -> db -> select('count(*) as cnt');
		$this -> db -> where('mother_registration_no',$motherRegistrationNo);
		$result = $this -> db -> get('cerv_mother_registration') -> row();
		if($result->cnt > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	function updateMotherRegistrationData($data,$motherRegistrationNo){
		$this -> db -> update('cerv_mother_registration',$data,array('mother_registration_no' => $motherRegistrationNo));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function saveNewRegisteredMotherData($data){
		$this -> db -> insert('cerv_mother_registration',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function saveTechnicianCheckinDetails($data){
		$this -> db -> insert('technician_checkin_details',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function updateTechnicianCheckinDetails($data,$workDate,$technicianCode){
		$this -> db -> update('technician_checkin_details',$data,array('work_date' => $workDate, 'techniciancode' => $technicianCode));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function searchChildrenData($where=NULL,$like=NULL){
		$this -> db -> select('child_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, nameofchild, cardno, gender, dateofbirth, fathername, mothername, fathercnic, contactno, latitude, longitude, year, bcg, hepb, opv0, opv1, opv2, opv3, penta1, penta2, penta3, pcv1, pcv2, pcv3, ipv, rota1, rota2, measles1, measles2, bcg_lat, bcg_long, hepb_lat, hepb_long, opv0_lat, opv0_long, opv1_lat, opv1_long, opv2_lat, opv2_long, opv3_lat, opv3_long, penta1_lat, penta1_long, penta2_lat, penta2_long, penta3_lat, penta3_long, pcv1_lat, pcv1_long, pcv2_lat, pcv2_long, pcv3_lat, pcv3_long, ipv_lat, ipv_long, rota1_lat, rota1_long, rota2_lat, rota2_long, measles1_lat, measles1_long, measles2_lat, measles2_long, fingerprint, bcg_facode, hepb_facode, opv0_facode, opv1_facode, opv2_facode, opv3_facode, penta1_facode, penta2_facode, penta3_facode, pcv1_facode, pcv2_facode, pcv3_facode, ipv_facode, rota1_facode, rota2_facode, measles1_facode, measles2_facode, isoutsitefacility, submitteddate, address');
		if($where)
			$this -> db -> where($where);
		else if($like)
			$this -> db -> like('LOWER(' .$like["key"]. ')', strtolower($like["value"]),'both');
		return $this -> db -> get('cerv_child_registration') -> result_array();
	}//, housestreet, villagemohallah
	function searchMotherData($where=NULL,$like=NULL){
		$this -> db -> select('mother_registration_no, imei, techniciancode, procode, distcode, tcode, uncode, reg_facode, mother_name, mother_age, cardno, husband_name, mother_cnic, contactno, latitude, longitude, year, tt1, tt2, tt3, tt4, tt5, tt1_lat, tt1_long, tt2_lat, tt2_long, tt3_lat, tt3_long, tt4_lat, tt4_long, tt5_lat, tt5_long, fingerprint, tt1_facode, tt2_facode, tt3_facode, tt4_facode, tt5_facode, is_outer_registered, submitted_date, address');// house, village,
		if($where)
			$this -> db -> where($where);
		else if($like)
			$this -> db -> like('LOWER(' .$like["key"]. ')', strtolower($like["value"]),'both');
		return $this -> db -> get('cerv_mother_registration') -> result_array();
	}
	function getVaccinesDetail(){
		$this -> db -> select('pk_id as item_id, item_name, description, number_of_doses, status, list_rank, multiplier, wastage_rate_allowed, activity_type_id, item_category_id');
		$this -> db -> where('cerv_item','1');
		return $this -> db -> get('epi_item_pack_sizes') -> result_array();
	}
	function savevaccinesDailyRegister($insertdata){
		//$this -> db -> insert_batch('vaccine_vials_daily_record',$insertdata);
		$this -> db -> insert('vaccine_vials_daily_record',$insertdata);
		//echo $this -> db -> last_query();exit();
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function checkmonthlyconsumption($fmonth,$facode)
	{
		//$this -> db -> select('count(*) as num');
		$this -> db -> where(array('fmonth' => $fmonth, 'facode' => $facode, 'is_compiled' => '0'));
		return $this -> db -> count_all_results('epi_consumption_master');
		/* $result = $this -> db -> get('epi_consumption_master') -> row();
		if($result->num > 0)
		{
			return 1;
		}else
		{
			return 0;
		} */
	}
	function consumptionmaster_detail_delete($fmonth,$facode)
	{
		$sql="DELETE FROM epi_consumption_detail USING epi_consumption_master
			WHERE epi_consumption_detail.main_id= epi_consumption_master.pk_id AND epi_consumption_master.facode='$facode' and  epi_consumption_master.fmonth='$fmonth'";
		$this->db->query($sql);
		$tbl1=$this->db->affected_rows();
		$result="false";
		if($tbl1 > 0)
		{
			$whereCondition['facode'] = $facode;
			$whereCondition['fmonth'] = $fmonth;
			$whereCondition['is_compiled'] = 0;
			$this->db->delete('epi_consumption_master',$whereCondition);
			$tbl1=$this->db->affected_rows();
			if($tbl1 > 0 )
				$result="true";
		}
		return $result;
	}
	function getvaccinesDailyRegister($fmonth,$facode){
		$query="SELECT fac.procode,fac.distcode,fac.tcode,fac.uncode,vac.facode,vac.batch_number,vac.item_id,vac.fmonth,sum(vac.used_vials) as used_vials,sum(vac.used_doses) as used_doses,sum(vac.unused_vials) as unused_vials,sum(vac.unused_doses) as unused_doses
			FROM vaccine_vials_daily_record vac join facilities fac on vac.facode=fac.facode where vac.fmonth='$fmonth' and vac.facode='$facode' group by vac.item_id,vac.fmonth,vac.batch_number,fac.procode,fac.distcode,fac.tcode,fac.uncode,vac.facode";
		$results = $this -> db -> query($query);
		$data = $results -> result_array();
		//print_r($data); exit();
		return $data;
	}
	function saveChildAEFIData($data){
		$this -> db -> insert('aefi_rep',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function saveWomenAEFIData($data){
		$this -> db -> insert('women_aefi_rep',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function consumption_master_save($data){
		$this -> db -> insert('epi_consumption_master',$data);
		$insert_id = $this->db->insert_id();
		if($this -> db -> affected_rows() > 0){
			//return true;
			return  $insert_id;
		}
		else{
			return false;
		}
	}
	function consumption_details_save($data){
		$this -> db -> insert('epi_consumption_detail',$data);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function week_get(){
		//$wc .= 'order by epi_week_numb asc';
		$this -> db -> select('*');
		$this -> db -> distinct();
		$this -> db -> where('date_from >= ','2020-01-01');
		$this -> db -> order_by('epi_week_numb asc');
		return $this -> db -> get('epi_weeks') -> result_array();
	}
	function techniciancode_get($technician){
		$this -> db -> select('*');
		$this -> db -> where('techniciancode',$technician);
		return $this -> db -> get('cerv_child_registration') -> result_array();
	}
	function updateChildRegistrationData2($data,$childRegistrationNo){
		$this -> db -> update('cerv_child_registration',$data,array('child_registration_no' => $childRegistrationNo));
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function case_investigation($insertData){
		$this -> db -> insert('case_investigation_db',$insertData);
		if($this -> db -> affected_rows() > 0)
			return true;
		else
			return false;
	}
	function check_case_investigation_reg($child_registration_no)
	{
		$this -> db -> select('child_registration_num as cnt');
		$this -> db -> where('child_registration_num',$child_registration_no);
		$result = $this -> db -> get('case_investigation_db') -> row();
		if(isset($result->cnt) > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}
	public function getCoverageData_monthly($fmonthfrom,$fmonthto,$uncode,$antigen,$year,$month)
	{
		 $query = "select sumvaccinevacination_male('$antigen','$uncode', '$fmonthfrom','$fmonthto') as male_vaccination, sumvaccinevacination_female('$antigen','$uncode', '$fmonthfrom','$fmonthto') as female_vaccination, sumvaccinevacination('$antigen','$uncode', '$fmonthfrom','$fmonthto') as total_vaccination, getmonthlytarget_specificyearr('$uncode', '$year', '$month', '$year', '$month', 'unioncouncil') as newborn_monthlypopulation, getmonthlytarget_specificyearrsurvivinginfants('$uncode', 'unioncouncil', '$year', '$month', '$year', '$month') as survivinginfants_monthlypopulation";
		$results = $this -> db -> query($query);
		$data = $results -> result_array();
		return $data;
	}
	 function uni_pop_model($frequency,$year,$month,$uncode)
		{
			if($frequency == 0){
				$query = "select round(getmonthlytarget_specificyearr('$uncode',$year, $month, $year, $month,'unioncouncil')::numeric,0)::float//30 as new_born,
				round(getmonthlytarget_specificyearrsurvivinginfants('$uncode','unioncouncil', $year, $month, $year, $month)::numeric,0)::float//30 as survivinginfants,
				round(getmonthly_plwomen_target_specificyears('$uncode',$year, $month, $year, $month, 'unioncouncil')::numeric,0)::float//30 as monthly_plwomen_target,
				getcbapop('$uncode','unioncouncil', '$year')::float//365  as cba_women,
				(getperiodicpopulation('$uncode', 'unioncouncil', $year, $month, $year, 12)*get_indicator_periodic_multiplier_dist_target('less5year', '$year', '365'))//100::float//365 as yearly_less5year,
				getpopulationpop('$uncode', 'unioncouncil', '$year') as total_population_unioncouncil";
			}
			if($frequency == 1){
			 	  $query = "select round(getmonthlytarget_specificyearr('$uncode',$year, $month, $year, $month,'unioncouncil')::numeric,0) as new_born,
							round(getmonthlytarget_specificyearrsurvivinginfants('$uncode','unioncouncil', $year, $month, $year, $month)::numeric,0) as survivinginfants,
							round(getmonthly_plwomen_target_specificyears('$uncode',$year, $month, $year, $month, 'unioncouncil')::numeric,0) as monthly_plwomen_target,
							getcbapop('$uncode','unioncouncil', '$year')::float//12  as cba_women,
							(getperiodicpopulation('$uncode', 'unioncouncil', $year, $month, $year, 12)*get_indicator_periodic_multiplier_dist_target('less5year', '$year', '365'))//100::float//12 as yearly_less5year,
							getpopulationpop('$uncode', 'unioncouncil', '$year') as total_population_unioncouncil";
			}
			if($frequency == 2){
					$query = "select round(getmonthlytarget_specificyearr('$uncode',$year, $month, $year, $month,'unioncouncil')::numeric,0)::float*12 as new_born,
					round(getmonthlytarget_specificyearrsurvivinginfants('$uncode','unioncouncil', $year, $month, $year, $month)::numeric,0)::float*12 as survivinginfants,
					round(getmonthly_plwomen_target_specificyears('$uncode',$year, $month, $year, $month, 'unioncouncil')::numeric,0)::float*12 as monthly_plwomen_target,
					getcbapop('$uncode','unioncouncil', '$year')  as cba_women,
					(getperiodicpopulation('$uncode', 'unioncouncil', $year, $month, $year, 12)*get_indicator_periodic_multiplier_dist_target('less5year', '$year', '365'))//100 as yearly_less5year,
					getpopulationpop('$uncode', 'unioncouncil', '$year') as total_population_unioncouncil";
		}
			$results = $this -> db -> query($query);
			$data = $results -> result_array();
			return $data;
	}
	function open_close_vial($uncode,$item_id,$year_month,$consumption_id)
	{
		$query = "select closedvials_wastagerate('$year_month','$uncode', $item_id, $consumption_id) as closedvials_wastagerate, openvial_wastagerate('$year_month','$uncode', $item_id, $consumption_id) as openvial_wastagerate";
		$results = $this -> db -> query($query);
		$data = $results -> result_array();
		return $data;
	}
	function fetch_aefi_rep_record($child_registration_no)
	{
		$query = "select child_registration_no from aefi_rep where child_registration_no = '$child_registration_no'";
		$results = $this -> db -> query($query);
		$data = $results -> result_array();
		return $data;
	}
	public function fetch_child_registration_info($childRegistrationNo){
		$this -> db -> select('distcode, tcode, uncode, reg_facode as facode');
		$this -> db -> from('cerv_child_registration');
		$this -> db -> where('child_registration_no', $childRegistrationNo);
		return $this -> db -> get() -> row_array();
	}
}
?>