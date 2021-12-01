<?php
//local
class Daily_register_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function daily_report($data){
		$monthdate=$data['monthdate'];
		$wc = "";
		if (!isset($data['reportType']) ) {
			/* form daily_report for technician dirlldown  */
			if(isset($data['techniciancode']) && $data['techniciancode']!=0 && $data['distcode']==0){
				$wc = "and procode= '" . $_SESSION['Province'] . "'and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode']!=0 && $data['distcode']!=0){
				$wc = "and distcode= '".$data['distcode']."'and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode']!=0 && $data['distcode']!=0 && $data['tcode']!=0){
				$wc = "and distcode= '".$data['distcode']."'and tcode= '".$data['tcode']."'and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode']!=0 && $data['distcode']!=0 && $data['tcode']!=0 && $data['uncode']!=0){
				$wc = "and distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and  techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode']!=0 && $data['distcode']!=0 && $data['tcode']!=0 && $data['uncode']!=0 && $data['facode']!=0){
				$wc = "and distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' and  techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			/* form daily_report for facility dirlldown*/
			if(isset($data['facode']) && $data['facode']!=0 && $data['distcode']==0){
				$wc = "and procode= '" . $_SESSION['Province'] . "' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode']!=0 && $data['distcode']!=0 && $data['techniciancode'] =='') {
				$wc = "and distcode= '".$data['distcode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode']!=0 && $data['distcode']!=0 && $data['tcode']!=0 && $data['techniciancode'] ==''){
				$wc = "and distcode= '".$data['distcode']."'and tcode= '".$data['tcode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode']!=0 && $data['distcode']!=0 && $data['tcode']!=0 && $data['uncode']!=0 && $data['techniciancode'] ==''){
				$wc = "and distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and  reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			/* form daily_report for facility dirlldown*/
			if(isset($data['uncode']) && $data['uncode']!=0 && $data['distcode']==0){
				$wc = "and procode= '" . $_SESSION['Province'] . "' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			if(isset($data['uncode']) && $data['uncode']!=0 && $data['distcode']!=0 && $data['techniciancode'] =='') {
				$wc = "and distcode= '".$data['distcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			if(isset($data['uncode']) && $data['uncode']!=0 && $data['distcode']!=0 && $data['tcode']!=0 && $data['techniciancode'] ==''){
				$wc = "and distcode= '".$data['distcode']."'and tcode= '".$data['tcode']."'and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			/* No type wise drilldown */
			if($data['uncode']==0 && $data['facode']==0 && $data['techniciancode']==0){
				$wc = "and procode= '" . $_SESSION['Province'] ."' AND deleted_at IS NULL";
			}
			if($data['uncode']==0 && $data['facode']==0 && $data['techniciancode']==0 && $data['distcode'] > 0) {
				$wc = "and distcode= '".$data['distcode']."' AND deleted_at IS NULL";
			}
			if($data['uncode']==0 && $data['facode']==0 && $data['techniciancode']==0 && $data['distcode'] > 0 && $data['tcode'] > 0){
				$wc = "and distcode= '".$data['distcode']."'and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
			}
		}	
		$childQuery="select * from cerv_child_registration 
						where (bcg='$monthdate' or hepb='$monthdate' or hepb='$monthdate' or opv0='$monthdate' or opv1='$monthdate' or opv2='$monthdate' or opv3='$monthdate' or penta1='$monthdate' or penta2='$monthdate' 
						or penta3='$monthdate' or pcv1='$monthdate' or pcv2='$monthdate' or pcv3='$monthdate' or ipv='$monthdate' or rota1='$monthdate' or rota2='$monthdate' or measles1='$monthdate' or measles2='$monthdate') {$wc}";
		$childDailyResult = $this -> db -> query($childQuery) -> result_array();
		$womenQuery="select '' as opv3,'' as penta3,'' as pcv3,'' as ipv,* from cerv_mother_registration 
						where (tt1='$monthdate' or tt2='$monthdate' or tt3='$monthdate' or tt4='$monthdate' or tt5='$monthdate') {$wc}";
		$womenDailyResult = $this -> db -> query($womenQuery) -> result_array();
		$dataReturned['Dailyresult'] = array_merge($childDailyResult,$womenDailyResult);
		$subTitle = "Daily Vaccination Register Report";
		if($this -> input -> post('export_excel')){
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['selectedDate'] = $monthdate;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
	
	}
	
	//--------------------------------------------------------------------------------------//
	public function monthly_report($data){
		/* where condition according to filter  */
		$fmonth=$data['monthfrom'];
		if($data['reportType'] == 0){
			if(isset($data['reportType']) && $data['reportType'] == 0) {
				$wc = "where procode = '" . $_SESSION['Province'] . "' AND deleted_at IS NULL";
			}
			if(isset($data['distcode']) && $data['distcode']!=''){
				$wc = "where distcode= '".$data['distcode']."' AND deleted_at IS NULL";
			}
			if(isset($data['tcode']) && $data['tcode'] !='' && $data['distcode'] !=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
			}
			if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
		}	
		/* form facility wise view drilldown  to month view*/
		if(isset($data['drilldownType']) && $data['drilldownType'] == 'flcf'){
			if(isset($data['facode']) && $data['facode'] !='' && $data['distcode']!='' && $data['tcode']!='' && $data['uncode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode'] !='' && $data['distcode']!='' && $data['tcode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
			if(isset($data['facode']) && $data['facode'] !=''){
				$wc = "where procode = '" . $_SESSION['Province'] . "' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
			}
		}
		/* form technician wise view drilldown  to month view*/
		if((isset($data['drilldownType']) && $data['drilldownType'] == 'techniciancode') OR $data['reportType'] == 'techniciancode'){
			if(isset($data['techniciancode']) && $data['techniciancode'] !='' && $data['distcode']!='' && $data['tcode']!='' && $data['uncode']!='' && $data['facode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode'] !='' && $data['distcode']!='' && $data['tcode']!='' && $data['uncode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode']) && $data['techniciancode'] !='' && $data['distcode']!='' && $data['tcode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
			if(isset($data['techniciancode'])  && $data['techniciancode'] !=''){
				$wc = "where procode = '" . $_SESSION['Province'] . "' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
			}
		}
		/* form uc wise view drilldown  to month view*/
		if(isset($data['drilldownType']) && $data['drilldownType'] == 'uc'){
			if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode']!='' && $data['tcode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			if(isset($data['uncode'])  && $data['uncode'] !='' && $data['distcode']!=''){
				$wc = "where distcode= '".$data['distcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
			if(isset($data['uncode'])  && $data['uncode'] !='' ){
				$wc = "where procode = '" . $_SESSION['Province'] . "' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
			}
		}
		/* for months start and end  */
		$monthdate_start=''.$fmonth.''.'-01';
		$monthdate_end=date("Y-m-t", strtotime($monthdate_start));
		$query="select a.monthdate, 
					sum(case when bcg=a.monthdate then 1 else 0 end) as bcgcount,
					sum(case when hepb=a.monthdate then 1 else 0 end) as hepbcount,
					sum(case when opv0=a.monthdate then 1 else 0 end) as opv0count,
					sum(case when opv1=a.monthdate then 1 else 0 end) as opv1count,
					sum(case when opv2=a.monthdate then 1 else 0 end) as opv2count,
					sum(case when opv3=a.monthdate then 1 else 0 end) as opv3count,
					sum(case when penta1=a.monthdate then 1 else 0 end) as penta1count,
					sum(case when penta2=a.monthdate then 1 else 0 end) as penta2count,
					sum(case when penta3=a.monthdate then 1 else 0 end) as penta3count,
					sum(case when pcv1=a.monthdate then 1 else 0 end) as pcv1count,
					sum(case when pcv2=a.monthdate then 1 else 0 end) as pcv2count,
					sum(case when pcv3=a.monthdate then 1 else 0 end) as pcv3count,
					sum(case when ipv=a.monthdate then 1 else 0 end) as ipvcount,
					sum(case when rota1=a.monthdate then 1 else 0 end) as rota1count,
					sum(case when rota2=a.monthdate then 1 else 0 end) as rota2count,
					sum(case when measles1=a.monthdate then 1 else 0 end) as measles1count,
					sum(case when measles2=a.monthdate then 1 else 0 end) as measles2count, 
					sum(case when (bcg=a.monthdate OR hepb=a.monthdate OR opv0=a.monthdate OR 
					opv1=a.monthdate OR opv2=a.monthdate OR opv3=a.monthdate OR penta1=a.monthdate OR 
					penta2=a.monthdate OR penta3=a.monthdate OR pcv1=a.monthdate OR pcv2=a.monthdate OR 
					pcv3=a.monthdate OR ipv=a.monthdate OR rota1=a.monthdate OR rota2=a.monthdate OR 
					measles1=a.monthdate OR measles2=a.monthdate) then 1 else 0 end) as total_children_vaccinated
						from cerv_child_registration, 
							(select 
								date(generate_series((date '{$monthdate_start}')::date,(date '{$monthdate_end}')::date,interval '1 day')) as monthdate
							) as a {$wc} group  by a.monthdate order by a.monthdate";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array();
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		unset($data['monthfrom']);
		/* End */
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$data['fmonth']= $fmonth;
		$dataReturned['data']=$data;
		return $dataReturned;
	}
	function monthly_report_facility_wise($data){
		/* where condition according to filter  */
		$fmonth=$data['monthfrom'];
		if(isset($data['reportType']) && $data['reportType'] == 'flcf') {
			$wc = "where procode = '" . $_SESSION['Province'] ."' AND deleted_at IS NULL";
		}
		if(isset($data['distcode']) && $data['distcode']!=''){
			$wc = "where distcode= '".$data['distcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['tcode']) && $data['tcode'] !='' && $data['distcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
		}
		if(isset($data['facode']) && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
		}
		/* for months start and end  */
		$monthdate_start=''.$fmonth.''.'-01';
		$monthdate_end=date("Y-m-t", strtotime($monthdate_start));
		$query="select reg_facode,facilityname(reg_facode) as facilityname, 
					sum(case when bcg=a.monthdate then 1 else 0 end) as bcgcount,
					sum(case when hepb=a.monthdate then 1 else 0 end) as hepbcount,
					sum(case when opv0=a.monthdate then 1 else 0 end) as opv0count,
					sum(case when opv1=a.monthdate then 1 else 0 end) as opv1count,
					sum(case when opv2=a.monthdate then 1 else 0 end) as opv2count,
					sum(case when opv3=a.monthdate then 1 else 0 end) as opv3count,
					sum(case when penta1=a.monthdate then 1 else 0 end) as penta1count,
					sum(case when penta2=a.monthdate then 1 else 0 end) as penta2count,
					sum(case when penta3=a.monthdate then 1 else 0 end) as penta3count,
					sum(case when pcv1=a.monthdate then 1 else 0 end) as pcv1count,
					sum(case when pcv2=a.monthdate then 1 else 0 end) as pcv2count,
					sum(case when pcv3=a.monthdate then 1 else 0 end) as pcv3count,
					sum(case when ipv=a.monthdate then 1 else 0 end) as ipvcount,
					sum(case when rota1=a.monthdate then 1 else 0 end) as rota1count,
					sum(case when rota2=a.monthdate then 1 else 0 end) as rota2count,
					sum(case when measles1=a.monthdate then 1 else 0 end) as measles1count,
					sum(case when measles2=a.monthdate then 1 else 0 end) as measles2count, 
					sum(case when (bcg=a.monthdate OR hepb=a.monthdate OR opv0=a.monthdate OR 
					opv1=a.monthdate OR opv2=a.monthdate OR opv3=a.monthdate OR penta1=a.monthdate OR 
					penta2=a.monthdate OR penta3=a.monthdate OR pcv1=a.monthdate OR pcv2=a.monthdate OR 
					pcv3=a.monthdate OR ipv=a.monthdate OR rota1=a.monthdate OR rota2=a.monthdate OR 
					measles1=a.monthdate OR measles2=a.monthdate) then 1 else 0 end) as total_children_vaccinated
						from cerv_child_registration, 
					        (select 
								date(generate_series((date '{$monthdate_start}')::date,(date '{$monthdate_end}')::date,interval '1 day')) as monthdate
							) as a {$wc} group  by reg_facode order by reg_facode";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array();
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		unset($data['monthfrom']);
		/* End */
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$data['fmonth']= $fmonth;
		$dataReturned['data']=$data;
		return $dataReturned;
	}
	public function monthly_report_technician_wise($data){
		/* where condition according to filter  */
		$fmonth=$data['monthfrom'];
		if(isset($data['reportType']) && $data['reportType'] == 'techniciancode') {
			$wc = "where procode = '" . $_SESSION['Province'] ."' AND deleted_at IS NULL";
		}
		if(isset($data['distcode']) && $data['distcode']!=''){
			$wc = "where distcode= '".$data['distcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['tcode']) && $data['tcode'] !='' && $data['distcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
		}
		if(isset($data['facode']) && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
		}
		if(isset($data['techniciancode']) && $data['techniciancode'] !='' && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
		}
		/* for months start and end  */
		$monthdate_start=''.$fmonth.''.'-01';
		$monthdate_end=date("Y-m-t", strtotime($monthdate_start));
		$query="select techniciancode,hr_name(techniciancode) as technicianname, 
					sum(case when bcg=a.monthdate then 1 else 0 end) as bcgcount,
					sum(case when hepb=a.monthdate then 1 else 0 end) as hepbcount,
					sum(case when opv0=a.monthdate then 1 else 0 end) as opv0count,
					sum(case when opv1=a.monthdate then 1 else 0 end) as opv1count,
					sum(case when opv2=a.monthdate then 1 else 0 end) as opv2count,
					sum(case when opv3=a.monthdate then 1 else 0 end) as opv3count,
					sum(case when penta1=a.monthdate then 1 else 0 end) as penta1count,
					sum(case when penta2=a.monthdate then 1 else 0 end) as penta2count,
					sum(case when penta3=a.monthdate then 1 else 0 end) as penta3count,
					sum(case when pcv1=a.monthdate then 1 else 0 end) as pcv1count,
					sum(case when pcv2=a.monthdate then 1 else 0 end) as pcv2count,
					sum(case when pcv3=a.monthdate then 1 else 0 end) as pcv3count,
					sum(case when ipv=a.monthdate then 1 else 0 end) as ipvcount,
					sum(case when rota1=a.monthdate then 1 else 0 end) as rota1count,
					sum(case when rota2=a.monthdate then 1 else 0 end) as rota2count,
					sum(case when measles1=a.monthdate then 1 else 0 end) as measles1count,
					sum(case when measles2=a.monthdate then 1 else 0 end) as measles2count, 
					sum(case when (bcg=a.monthdate OR hepb=a.monthdate OR opv0=a.monthdate OR 
					opv1=a.monthdate OR opv2=a.monthdate OR opv3=a.monthdate OR penta1=a.monthdate OR 
					penta2=a.monthdate OR penta3=a.monthdate OR pcv1=a.monthdate OR pcv2=a.monthdate OR 
					pcv3=a.monthdate OR ipv=a.monthdate OR rota1=a.monthdate OR rota2=a.monthdate OR 
					measles1=a.monthdate OR measles2=a.monthdate) then 1 else 0 end) as total_children_vaccinated
						from cerv_child_registration, 
					        (select 
								date(generate_series((date '{$monthdate_start}')::date,(date '{$monthdate_end}')::date,interval '1 day')) as monthdate
							) as a {$wc} group  by techniciancode order by techniciancode";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array();
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		unset($data['monthfrom']);
		/* End */
		$dataReturned['fmonth'] = $fmonth;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
	}
	public function selected_date_technician_wise($data){
		/* where condition according to filter  */
		$selecteddate=$data['monthdate'];
		if(isset($data['reportType']) && $data['reportType'] == 'techniciancode') {
			$wc = "where procode = '" . $_SESSION['Province']."' AND deleted_at IS NULL";
		}
		if(isset($data['distcode']) && $data['distcode']!=''){
			$wc = "where distcode= '".$data['distcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['tcode']) && $data['tcode'] !='' && $data['distcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
		}
		if(isset($data['facode']) && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' AND deleted_at IS NULL";
		}
		if(isset($data['techniciancode']) && $data['techniciancode'] !='' && $data['facode'] !='' && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' and reg_facode= '".$data['facode']."' and techniciancode= '".$data['techniciancode']."' AND deleted_at IS NULL";
		}
		
		$query="select techniciancode,hr_name(techniciancode) as technicianname, 
					sum(case when bcg='{$selecteddate}' then 1 else 0 end) as bcgcount,
					sum(case when hepb='{$selecteddate}' then 1 else 0 end) as hepbcount,
					sum(case when opv0='{$selecteddate}' then 1 else 0 end) as opv0count,
					sum(case when opv1='{$selecteddate}' then 1 else 0 end) as opv1count,
					sum(case when opv2='{$selecteddate}' then 1 else 0 end) as opv2count,
					sum(case when opv3='{$selecteddate}' then 1 else 0 end) as opv3count,
					sum(case when penta1='{$selecteddate}' then 1 else 0 end) as penta1count,
					sum(case when penta2='{$selecteddate}' then 1 else 0 end) as penta2count,
					sum(case when penta3='{$selecteddate}' then 1 else 0 end) as penta3count,
					sum(case when pcv1='{$selecteddate}' then 1 else 0 end) as pcv1count,
					sum(case when pcv2='{$selecteddate}' then 1 else 0 end) as pcv2count,
					sum(case when pcv3='{$selecteddate}' then 1 else 0 end) as pcv3count,
					sum(case when ipv='{$selecteddate}' then 1 else 0 end) as ipvcount,
					sum(case when rota1='{$selecteddate}' then 1 else 0 end) as rota1count,
					sum(case when rota2='{$selecteddate}' then 1 else 0 end) as rota2count,
					sum(case when measles1='{$selecteddate}' then 1 else 0 end) as measles1count,
					sum(case when measles2='{$selecteddate}' then 1 else 0 end) as measles2count, 
					sum(case when (bcg='{$selecteddate}' OR hepb='{$selecteddate}' OR opv0='{$selecteddate}' OR 
					opv1='{$selecteddate}' OR opv2='{$selecteddate}' OR opv3='{$selecteddate}' OR penta1='{$selecteddate}' OR 
					penta2='{$selecteddate}' OR penta3='{$selecteddate}' OR pcv1='{$selecteddate}' OR pcv2='{$selecteddate}' OR 
					pcv3='{$selecteddate}' OR ipv='{$selecteddate}' OR rota1='{$selecteddate}' OR rota2='{$selecteddate}' OR 
					measles1='{$selecteddate}' OR measles2='{$selecteddate}') then 1 else 0 end) as total_children_vaccinated
						from cerv_child_registration 
						{$wc} group  by techniciancode order by techniciancode";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array();
		//echo $this -> db -> last_query();exit;
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		unset($data['monthfrom']);
		/* End */
		$dataReturned['selecteddate'] = $selecteddate;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
	}
	function monthly_report_unioncouncil_wise($data){
		
		$fmonth= $data['monthfrom'];
		if(isset($data['reportType']) && $data['reportType'] == 'uc') {
			$wc = "where procode = '" . $_SESSION['Province'] ."' AND deleted_at IS NULL";
		}
		if(isset($data['distcode']) && $data['distcode']!=''){
			$wc = "where distcode= '".$data['distcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['tcode']) && $data['tcode'] !='' && $data['distcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' AND deleted_at IS NULL";
		}
		if(isset($data['uncode']) && $data['uncode'] !='' && $data['distcode'] !='' && $data['tcode'] !=''){
			$wc = "where distcode= '".$data['distcode']."' and tcode= '".$data['tcode']."' and uncode= '".$data['uncode']."' AND deleted_at IS NULL";
		}
		$monthdate_start=''.$fmonth.''.'-01';
		$monthdate_end=date("Y-m-t", strtotime($monthdate_start));
		$query="select uncode,unname(uncode) as ucname ,
				sum(case when bcg=a.monthdate then 1 else 0 end) as bcgcount,
				sum(case when hepb=a.monthdate then 1 else 0 end) as hepbcount,
				sum(case when opv0=a.monthdate then 1 else 0 end) as opv0count,
				sum(case when opv1=a.monthdate then 1 else 0 end) as opv1count,
				sum(case when opv2=a.monthdate then 1 else 0 end) as opv2count,
				sum(case when opv3=a.monthdate then 1 else 0 end) as opv3count,
				sum(case when penta1=a.monthdate then 1 else 0 end) as penta1count,
				sum(case when penta2=a.monthdate then 1 else 0 end) as penta2count,
				sum(case when penta3=a.monthdate then 1 else 0 end) as penta3count,
				sum(case when pcv1=a.monthdate then 1 else 0 end) as pcv1count,
				sum(case when pcv2=a.monthdate then 1 else 0 end) as pcv2count,
				sum(case when pcv3=a.monthdate then 1 else 0 end) as pcv3count,
				sum(case when ipv=a.monthdate then 1 else 0 end) as ipvcount,
				sum(case when rota1=a.monthdate then 1 else 0 end) as rota1count,
				sum(case when rota2=a.monthdate then 1 else 0 end) as rota2count,
				sum(case when measles1=a.monthdate then 1 else 0 end) as measles1count,
				sum(case when measles2=a.monthdate then 1 else 0 end) as measles2count, 
					sum(case when (bcg=a.monthdate OR hepb=a.monthdate OR opv0=a.monthdate OR 
					opv1=a.monthdate OR opv2=a.monthdate OR opv3=a.monthdate OR penta1=a.monthdate OR 
					penta2=a.monthdate OR penta3=a.monthdate OR pcv1=a.monthdate OR pcv2=a.monthdate OR 
					pcv3=a.monthdate OR ipv=a.monthdate OR rota1=a.monthdate OR rota2=a.monthdate OR 
					measles1=a.monthdate OR measles2=a.monthdate) then 1 else 0 end) as total_children_vaccinated
					from cerv_child_registration, 
				        (select 
							date(generate_series((date '{$monthdate_start}')::date,(date '{$monthdate_end}')::date,interval '1 day')) as monthdate
						) as a {$wc} group  by uncode order by uncode";
		$dataReturned['Monthlyresult'] = $this -> db -> query($query) -> result_array(); 
		$subTitle = "Monthly Vaccination Register Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$dataReturned['fmonth']=$fmonth;
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		unset($data['monthfrom']);
		/* End */
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
	}	
	function dataentry_report($data){
		/* if($data['datefrom'] == 0){
			$date = date('yy-m-d');
		}else{
			$date =$data['datefrom'];                        
		} */
		$datefrom=$data['datefrom'];
		$dateto=$data['dateto'];
		//print_r($datefrom);  //exit;
		if($data['datefrom'] == 0){
			$query="select uncode,unname(uncode),count(*) 
					from cerv_child_registration where and deleted_at IS NULL
						group by uncode having count(*) > 0 order by uncode";
		}else{
			/*$query="select uncode,unname(uncode),submitteddate from cerv_child_registration   
		where submitteddate BETWEEN '$datefrom' AND '$dateto' group by uncode,unname(uncode),submitteddate order by unname(uncode),submitteddate limit 5000 ";  */
		
		$query="select uncode \"UC Code\", unname(uncode) \"UC Name\",
			(select count(*) as count from cerv_child_registration where submitteddate = '$datefrom' and uncode=cerv.uncode AND deleted_at IS NULL) as \"$datefrom\"
			 from cerv_child_registration cerv where deleted_at IS NULL  group by uncode,unname(uncode) order by uncode";
		}
		$dataReturned['Monthlentry'] = $this -> db -> query($query) -> result_array(); 
		$subTitle = "Data Entry Record # UC wise";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//$dataReturned['date']=$date;
		/* for table top info */
		if($data['distcode']=='')
		$data['procode'] = $this->session->Province;
		//unset($data['datefrom']);
		unset($data['report_type']);
		/* End */
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		return $dataReturned;
		//print_r($data['Monthlentry']);exit;
	}
}
?>