<?php
class Redrec_compliances_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
    function RedRec_HF_quarter_complainces ($data){
		$procode=$this->session->Province;
		$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
		$current_year = date('yy');
		if($year == $current_year)
		{
			$month = date('m');
		}else{
			$month='11';
		}
		$Allquarter="";
		  if($month >=1 && $month <=2){
		   $quarter='1';
		}elseif($month >=3 && $month <=5 ){
		   $quarter='2';
		}elseif($month >=6 && $month <=8 ){
		   $quarter='3';
		}elseif($month >=9 && $month <=11 ){
		   $quarter='4';
		}else {
			$quarter='1';
		}
		if($year > '2019'){
			for ($qurt = 1; $qurt <= $quarter; $qurt++) {
			// =1 $Allquarter .= "(select count(techniciancode) from hf_quarterplan_db where hf_quarterplan_db.distcode=techniciandb.distcode and quarter=$qurt and year='$year' AND techniciandb.status = 'Active') as submit$qurt,";
			//$Allquarter .= "(select count(b.techniciancode) from hr_db a right join hf_quarterplan_db b on b.techniciancode=a.code where b.distcode=hr_db.distcode  and b.quarter=$qurt and b.year='$year') as submit$qurt,";
			$Allquarter .= "(SELECT COUNT(DISTINCT techniciancode) FROM hf_quarterplan_db hfqd WHERE dist.distcode=hfqd.distcode AND hfqd.year='$year' AND hfqd.quarter=$qurt AND get_hr_status(techniciancode,'01') = 'Active') AS submit$qurt,";
			
			}
			$Allquarter = rtrim($Allquarter,",");
					/* $query="Select districtname(distcode) as district,distcode, count(code) as due,$Allquarter 
					from hr_db  where $wc group by distcode order by districtname(distcode) ASC";
					 */$query="SELECT dist.distcode,districtname(dist.distcode) as district,count(t.*) AS due,$Allquarter
								FROM districts dist 
									LEFT JOIN 
								(SELECT * FROM 
												(SELECT DISTINCT ON (code) code,* FROM hr_db_history  ORDER BY code DESC, id DESC) AS a WHERE  post_hr_sub_type_id='01'  AND  post_status='Active') AS t ON dist.distcode=t.post_distcode where $wc GROUP BY dist.distcode ORDER BY dist.distcode";
		}else{
			for ($qurt = 1; $qurt <= $quarter; $qurt++) {
			// =1 $Allquarter .= "(select count(techniciancode) from hf_quarterplan_db where hf_quarterplan_db.distcode=techniciandb.distcode and quarter=$qurt and year='$year' AND techniciandb.status = 'Active') as submit$qurt,";
			$Allquarter .= "(select count(b.techniciancode) from techniciandb a right join hf_quarterplan_db b on b.techniciancode=a.techniciancode where b.distcode=techniciandb.distcode  and b.quarter=$qurt and year='$year' and  a.status='Active') as submit$qurt,";
			
			}
			$Allquarter = rtrim($Allquarter,",");
					$query="Select districtname(distcode) as district,distcode, count(techniciancode) as due,$Allquarter 
					from techniciandb  where $wc AND techniciandb.status = 'Active' group by distcode,techniciandb.status order by districtname(distcode) ASC";
		
		}
		//exit;
		$result = $this->db->query($query);
		$result = $result->result();
		return $result;
	}
	function RedRec_HF_quarter_tech_compliance ($distcode,$year){
		$procode=$this->session->Province;
		$current_year = date('yy');
		if($year == $current_year)
		{
			$month = date('m');
		}else{
			$month='11';
		}
		$Allquarter="";
		$Allshedule="";
		$Allheld="";
		$Totalsite="";
		  if($month >=1 && $month <=2){
		   $quarter='1';
		}elseif($month >=3 && $month <=5 ){
		   $quarter='2';
		}elseif($month >=6 && $month <=8 ){
		   $quarter='3';
		}elseif($month >=9 && $month <=11 ){
		   $quarter='4';
		}else{
			$quarter='1';
		} 
		//$quarter='2';
		if($year > '2019'){
			for ($qurt = 1; $qurt <= $quarter; $qurt++) {
				//$Allquarter .= "(select quarter from hf_quarterplan_db where quarter=$qurt and year=$year and hr_db.code=hf_quarterplan_db.techniciancode) as Q$qurt,";
				$Allquarter .= "(select quarter from hf_quarterplan_db where quarter=$qurt and year=$year and same_code=hf_quarterplan_db.techniciancode) as Q$qurt,";
				$Allshedule .= "(select (count(area_dateschedule_m1)+count(area_dateschedule_m2)+count(area_dateschedule_m3)) from hf_quarterplan_dates_db where quarter=$qurt and year=$year and same_code=hf_quarterplan_dates_db.techniciancode) as schedule$qurt ,";
				$Allheld .= "(select (count(area_dateheld_m1)+count(area_dateheld_m2)+count(area_dateheld_m3)) from hf_quarterplan_dates_db where quarter=$qurt and year=$year and same_code=hf_quarterplan_dates_db.techniciancode) as held$qurt ,";
				$Totalsite .= "(select count(session_type)*3 from hf_quarterplan_dates_db where quarter=$qurt and year=$year and same_code=hf_quarterplan_dates_db.techniciancode) as totalsite$qurt,";
			}			
				$Allquarter = rtrim($Allquarter,",");
				$Allshedule = rtrim($Allshedule,",");
				$Allheld = rtrim($Allheld,",");
				$Totalsite = rtrim($Totalsite,",");
				//$query="select  distinct(code) as techniciancode ,hr_name(code) as technicianname,$Allquarter,$Allshedule,$Allheld,$Totalsite  from hr_db where distcode='$distcode'";
				
				$query="SELECT distinct(same_code) as techniciancode ,hr_name(same_code) as technicianname,$Allquarter,$Allshedule,$Allheld,$Totalsite FROM (SELECT DISTINCT ON (code) code, code as same_code,* FROM hr_db_history ORDER BY code DESC, id DESC) AS a WHERE post_hr_sub_type_id='01' AND post_status='Active' and post_distcode = '$distcode'";
		}else{
			for ($qurt = 1; $qurt <= $quarter; $qurt++) {
				$Allquarter .= "(select quarter from hf_quarterplan_db where quarter=$qurt and year=$year and techniciandb.techniciancode=hf_quarterplan_db.techniciancode) as Q$qurt,";
				$Allshedule .= "(select (count(area_dateschedule_m1)+count(area_dateschedule_m2)+count(area_dateschedule_m3)) from hf_quarterplan_dates_db where quarter=$qurt and year=$year and techniciandb.techniciancode=hf_quarterplan_dates_db.techniciancode) as schedule$qurt ,";
				$Allheld .= "(select (count(area_dateheld_m1)+count(area_dateheld_m2)+count(area_dateheld_m3)) from hf_quarterplan_dates_db where quarter=$qurt and year=$year and techniciandb.techniciancode=hf_quarterplan_dates_db.techniciancode) as held$qurt ,";
				$Totalsite .= "(select count(session_type)*3 from hf_quarterplan_dates_db where quarter=$qurt and year=$year and techniciandb.techniciancode=hf_quarterplan_dates_db.techniciancode) as totalsite$qurt,";
			}			
				$Allquarter = rtrim($Allquarter,",");
				$Allshedule = rtrim($Allshedule,",");
				$Allheld = rtrim($Allheld,",");
				$Totalsite = rtrim($Totalsite,",");
				$query="select  distinct(techniciancode) as techniciancode ,technicianname(techniciancode) as technicianname,$Allquarter,$Allshedule,$Allheld,$Totalsite  from techniciandb where distcode='$distcode' AND techniciandb.status = 'Active'";
		}
		$result = $this->db->query($query);
		$result = $result->result();		
		return $result;
		
	}	
	function RedRec_HF_tech_compilation_compliance ($techniciancode,$quarter){
		$query="select unname(uncode) as ucname ,case when (year > '2019') then hr_name(techniciancode) else technicianname(techniciancode) end as technicianname, coalesce(case when session_type='Fixed' then facilityname(sitename_s) else sitename_s end,' ') || '$$' || session_type || '$$' ||  
						COALESCE(area_dateheld_m1,'1970-01-01') || '$$' || COALESCE(area_dateheld_m2,'1970-01-01') || '$$' || COALESCE(area_dateheld_m3, '1970-01-01')  || '$$' ||
						COALESCE(area_dateschedule_m1,'1970-01-01') || '$$' || COALESCE(area_dateschedule_m2,'1970-01-01') || '$$' || COALESCE(area_dateschedule_m3, '1970-01-01')  as sitename,* 
						from hf_quarterplan_dates_db where techniciancode='$techniciancode' and quarter ='$quarter' order by tcode,uncode,techniciancode";
		$result = $this-> db-> query($query);
		$data['data'] = $result-> result_array(); 
		$query=" select distcode,uncode,case when (year > '2019') then hr_name(techniciancode) else technicianname(techniciancode) end as technicianname,year,quarter,facode from hf_quarterplan_db where techniciancode='$techniciancode' and quarter ='$quarter' ";		
		$result = $this-> db-> query($query);
		$data['result'] = $result-> result_array(); 		
		return $data;
	}
	function RedRec_HF_microplan_complainces ($data){
		$procode=$this->session->Province;
		$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."'  ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
			/* =2 $query="Select districtname(distcode) as district,distcode, count(techniciancode) as due,
		       (select count(distinct techniciancode) from situation_analysis_db where techniciandb.distcode=situation_analysis_db.distcode  and year='$year') as submit 
			    from techniciandb  where $wc AND techniciandb.status = 'Active' group by distcode order by districtname(distcode) ASC"; */
				if($year >'2019'){
					/* $query="Select districtname(distcode) as district,distcode, count(code) as due,
					(select count(distinct b.techniciancode) from hr_db a right join situation_analysis_db b on b.techniciancode=a.code where b.distcode=hr_db.distcode  and b.year='$year') as submit 
			        from hr_db  where $wc  group by distcode order by districtname(distcode) ASC"; */
					$query="SELECT dist.distcode,districtname(dist.distcode) as district,count(t.*) AS due
							,(SELECT COUNT(DISTINCT techniciancode) FROM situation_analysis_db sad WHERE dist.distcode=sad.distcode AND sad.year='$year' AND get_hr_status(techniciancode,'01') = 'Active') AS submit 
								FROM districts dist 
									LEFT JOIN 
								(SELECT * FROM 
												(SELECT DISTINCT ON (code) code,* FROM hr_db_history  ORDER BY code DESC, id DESC) AS a WHERE  post_hr_sub_type_id='01'  AND  post_status='Active') AS t ON dist.distcode=t.post_distcode where $wc GROUP BY dist.distcode ORDER BY dist.distcode";
				}else{
					$query="Select districtname(distcode) as district,distcode, count(techniciancode) as due,
					(select count(distinct b.techniciancode) from techniciandb a right join situation_analysis_db b on b.techniciancode=a.techniciancode where b.distcode=techniciandb.distcode  and b.year='$year' and  a.status='Active') as submit 
			        from techniciandb  where $wc AND techniciandb.status = 'Active' group by distcode order by districtname(distcode) ASC";
				}
				
		$result = $this->db->query($query);
		$result = $result->result();
		return $result;
	}
	/* function RedRec_HF_microplan_tech_compliance ($uncode,$year){
		$procode=$this->session->Province;
		if($year > '2019'){
			$query="select distinct(code) as techniciancode ,hr_name(code) as technicianname,
					(select distinct(techniciancode)  from situation_analysis_db where year='$year' and hr_db.code=situation_analysis_db.techniciancode) as submit from hr_db where uncode='$uncode'"; 
		}else{
			$query="select distinct(techniciancode) as techniciancode ,technicianname(techniciancode) as technicianname,
					(select distinct(techniciancode)  from situation_analysis_db where year='$year' and techniciandb.techniciancode=situation_analysis_db.techniciancode) as submit from techniciandb where uncode='$uncode'AND techniciandb.status = 'Active' "; 
		}
	    $result = $this->db->query($query);
		$result = $result->result();
		return $result;
	} */
	function RedRec_HF_microplan_uc_compliance ($distcode,$year){
		$procode=$this->session->Province;
	      /* =3 $query="Select unname(uncode) as unname,uncode, count(techniciancode) as due,
		       (select count(distinct techniciancode) from situation_analysis_db where techniciandb.uncode=situation_analysis_db.uncode  and year='$year' ) as submit 
			    from techniciandb  where distcode='$distcode'AND techniciandb.status = 'Active' group by uncode order by unname(uncode) ASC "; 
			 */
			 if($year > '2019'){
				 /*  $query="Select unname(uncode) as unname,uncode, count(code) as due,
					(select count(distinct a.code) from hr_db a right  join situation_analysis_db b on a.code=b.techniciancode where a.uncode = hr_db.uncode and b.year='$year') as submit 
					from hr_db  where distcode='$distcode' group by uncode,hr_db.uncode  order by unname(uncode) ASC "; 
				 */
				 $query="SELECT un.uncode,unname(un.uncode) as unname,count(t.*) AS due
						,(SELECT COUNT(DISTINCT techniciancode) FROM situation_analysis_db sad WHERE un.uncode=sad.uncode AND sad.year='$year' AND get_hr_status(techniciancode,'01') = 'Active') AS submit  
							FROM unioncouncil un 
								LEFT JOIN 
									(SELECT * FROM
										(SELECT DISTINCT ON (code) code,* FROM hr_db_history ORDER BY code DESC, id DESC) AS a 
											WHERE post_hr_sub_type_id='01' AND post_status='Active') AS t ON un.uncode=t.post_uncode where un.distcode ='$distcode' GROUP BY un.uncode ORDER BY un.uncode";
			  //echo $query;exit;
			 }else{
				 $query="Select unname(uncode) as unname,uncode, count(techniciancode) as due,
					(select count(distinct a.techniciancode) from techniciandb a right  join situation_analysis_db b on a.techniciancode=b.techniciancode where a.uncode = techniciandb.uncode and b.year='$year' and  a.status='Active') as submit 
					from techniciandb  where distcode='$distcode' AND techniciandb.status = 'Active' group by uncode,techniciandb.uncode  order by unname(uncode) ASC "; 
			 }
		$result = $this->db->query($query);
		$result = $result->result();
		return $result;
		
	}
function RedRec_HF_microplan_tech_compliance ($uncode,$year){
		$procode=$this->session->Province;
		if($year > '2019'){
			/* $query="select distinct(code) as techniciancode ,hr_name(code) as technicianname,
					(select distinct(techniciancode)  from situation_analysis_db where year='$year' and hr_db.code=situation_analysis_db.techniciancode) as submit from hr_db where uncode='$uncode'"; 
			 */
			 $query="SELECT same_code AS techniciancode ,hr_name(same_code) AS technicianname
						,(SELECT COUNT(DISTINCT techniciancode) FROM situation_analysis_db sad WHERE a.same_code=sad.techniciancode AND sad.year='$year' AND get_hr_status(techniciancode,'01') = 'Active') AS submit
							FROM (
								SELECT DISTINCT ON (code) code, code as same_code,* FROM hr_db_history ORDER BY code DESC, id DESC) AS a 
									WHERE post_hr_sub_type_id='01' AND post_status='Active' and post_uncode='$uncode'"; 
			
		}else{
			$query="select distinct(techniciancode) as techniciancode ,technicianname(techniciancode) as technicianname,
					(select distinct(techniciancode)  from situation_analysis_db where year='$year' and techniciandb.techniciancode=situation_analysis_db.techniciancode) as submit from techniciandb where uncode='$uncode'AND techniciandb.status = 'Active' "; 
		}
	    $result = $this->db->query($query);
		$result = $result->result();
		return $result;
		
	}
	public function situation_analysis_view($techniciancode,$year){	
		$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility from situation_analysis_db where techniciancode='$techniciancode' and year='$year'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
		return $data['data'];	
	}
	function RedRec_HF_supervisoryplan_complainces ($data){
		$procode=$this->session->Province;
		$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
		$current_year = date('yy');
		//print_r($year);exit;
		if($year == $current_year)
		{
			$currentmonth = date('m');
		}else{
			$currentmonth='12';
		}
		//print_r($curuntmonth);exit;
		//$curuntmonth = date('m');
		$Allmonth="";
		$Totalplan="";
		if($year > '2019'){
		   for($month=1; $month<=$currentmonth; $month++){
				if($month < 10){
					$month='0'.$month;
				}
			$Allmonth.="(select count (distinct supervisorcode) from supervisory_plan where fmonth='$year-$month' and dist.distcode=supervisory_plan.distcode ) as plan$month,";
			//$Allmonth.="(select count (distinct supervisorcode) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as plan$month,";
			//(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as conduct$month,
		   }
			/* $Totalplan="(select count(distinct supervisorcode) from supervisory_plan where fmonth like '$year-%' and districts.distcode=supervisory_plan.distcode ) as totalsupervisorsplan";
			$Totaldue="(select count(supervisorcode)*$currentmonth from supervisordb where districts.distcode=supervisordb.distcode and  status='Active' ) as totalsupervisorsdue ";
			*/
			$Totalplan="(select count(distinct supervisorcode) from supervisory_plan where fmonth between '$year-01' and '$year-$currentmonth' and supervisory_plan.distcode=dist.distcode ) as totalsupervisorsplan";
			$Totaldue="(count(t.*)*$currentmonth) as totalsupervisorsdue ";
			$Allmonth = rtrim($Allmonth,",");
			/* $query="select distcode,districtname(distcode) as district,(select count(supervisorcode) from supervisordb where districts.distcode=supervisordb.distcode and  status='Active' ) as totalsupervisor,$Allmonth,$Totaldue,$Totalplan
					from districts where $wc group by distcode order by districtname(distcode) ASC";
			*/
				$query="SELECT dist.distcode,districtname(dist.distcode) as district,count(t.*) AS totalsupervisor,$Allmonth,$Totaldue,$Totalplan
							FROM districts dist LEFT JOIN (SELECT * FROM (SELECT DISTINCT ON (code) code,* FROM hr_db_history ORDER BY code DESC, id DESC) AS a 
								WHERE post_hr_type_id='2' AND post_status='Active') AS t ON dist.distcode=t.post_distcode where $wc GROUP BY dist.distcode ORDER BY dist.distcode;";
			$result = $this->db->query($query);
			//echo $this->db->last_query();exit;
			$result = $result->result();
			return $result;
		}else{
			for($month=1; $month<=$currentmonth; $month++){
			if($month < 10){
				$month='0'.$month;
			}
				$Allmonth.="(select count (distinct supervisorcode) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as plan$month,";
				//(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as conduct$month,
			}
			$Totalplan="(select count(distinct supervisorcode) from supervisory_plan where fmonth like '$year-%' and districts.distcode=supervisory_plan.distcode ) as totalsupervisorsplan";
			$Totaldue="(select count(supervisorcode)*$currentmonth from supervisordb where districts.distcode=supervisordb.distcode and  status='Active' ) as totalsupervisorsdue "; 
			$Allmonth = rtrim($Allmonth,",");
			$query="select distcode,districtname(distcode) as district,(select count(supervisorcode) from supervisordb where districts.distcode=supervisordb.distcode and  status='Active' ) as totalsupervisor,$Allmonth,$Totaldue,$Totalplan
					from districts where $wc group by distcode order by districtname(distcode) ASC";
			$result = $this->db->query($query);
			$result = $result->result();
			return $result;
		}
		
	}
	function RedRec_HF_supervisoryplan_tech_compliance ($distcode,$year){
		$current_year = date('yy');
		if($year == $current_year)
		{
			$currentmonth = date('m');
		}else{
			$currentmonth='12';
		}
		$Allmonth="";
		if($year > '2019'){
			for($month=1; $month<=$currentmonth; $month++){
				if($month < 10){
					$month='0'.$month;
				}
				$Allmonth.="(select distinct(fmonth) from supervisory_plan where fmonth='$year-$month' and supervisory_plan.supervisorcode=same_code ) as plan$month,";
			}
			$Allmonth = rtrim($Allmonth,",");
			//$query="select distinct (supervisorcode) as supervisorname ,supervisor_type,$Allmonth from supervisordb supervisordb where distcode='$distcode' and status='Active' ";
			$query="SELECT hr_name(same_code) as supervisorname,get_hr_sub_type_description(post_hr_sub_type_id) as supervisor_type,$Allmonth FROM (SELECT DISTINCT ON (code) code, code as same_code,* FROM hr_db_history ORDER BY code DESC, id DESC) AS a WHERE post_hr_type_id='2' AND post_status='Active' and post_distcode = '$distcode'";
			$result = $this->db->query($query);
			$result = $result->result(); 
			return $result; 
			
		}else{
			for($month=1; $month<=$currentmonth; $month++){
				if($month < 10){
					$month='0'.$month;
				}
				$Allmonth.="(select distinct(fmonth) from supervisory_plan where fmonth='$year-$month' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as plan$month,";
			}
			$Allmonth = rtrim($Allmonth,",");
			$query="select distinct (supervisorcode) as supervisorname ,supervisor_type,$Allmonth from supervisordb supervisordb where distcode='$distcode' and status='Active' ";
			$result = $this->db->query($query);
			$result = $result->result(); 
			return $result; 
		}
		
	}
	function RedRec_HF_supervisoryvisit_complainces ($data){
		$procode=$this->session->Province;
		$year=$data['year'];
		if(isset($data['distcode']) > 0){
			$wc = " distcode = '".$data['distcode']."' ";
		}else{
			$wc = " procode = '".$procode."' ";
		}
		$curuntmonth = date('m');
		$Allmonthplan="";
		$Allmonthconduct="";
		$Allmonthpersent="";
		$Totalplanh   ="";   
		$Totalconducth="";
		$Totalpersenth="";
		for($month=1; $month<=$curuntmonth; $month++){
			if($month < 10){
				$month='0'.$month;
			}
			$Allmonthplan.="   (select count(planned_date) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as plan$month,";
			$Allmonthconduct.="(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as conduct$month,";
			$Allmonthpersent.="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth='$year-$month' and districts.distcode=supervisory_plan.distcode ) as persent$month,";
			//////////for last horizontal total ////////////
			$Totalplanh.="(select count(planned_date) from supervisory_plan where fmonth='$year-$month' and $wc ) as totalsupervisorsplanh$month,";
			$Totalconducth.="(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and $wc ) as totalsupervisorsconducth$month,";
			$Totalpersenth.="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth='$year-$month' and $wc ) as totalsupervisorspersenth$month,";
			///////////enf horizontal//////////
		}
			$Totalplan="(select count(planned_date) from supervisory_plan where fmonth like '$year-%' and districts.distcode=supervisory_plan.distcode ) as totalsupervisorsplan";
			$Totalconduct="(select count(conduct_date) from supervisory_plan where fmonth like '$year-%' and districts.distcode=supervisory_plan.distcode ) as totalsupervisorsconduct";
			$Totalpersent="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth like '$year-%' and districts.distcode=supervisory_plan.distcode ) as totalsupervisorspersent";
			//////////for last horizontal  Alltotal ////////////
			$Totalplanl="(select count(planned_date) from supervisory_plan where fmonth like '$year-%' and $wc ) as totalsupervisorsplanl";
			$Totalconductl="(select count(conduct_date) from supervisory_plan where fmonth like '$year-%' and $wc ) as totalsupervisorsconductl";
			$Totalpersentl="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth like '$year-%' and $wc ) as totalsupervisorspersentl";
			//////////end horizontal Alltotal ////////////
			$Allmonthplan = rtrim($Allmonthplan,",");
			$Allmonthconduct = rtrim($Allmonthconduct,",");
			$Allmonthpersent = rtrim($Allmonthpersent,",");
			$Totalplanh    = rtrim($Totalplanh,",");
			$Totalconducth = rtrim($Totalconducth,",");
			$Totalpersenth = rtrim($Totalpersenth,",");
			$query="select distcode,districtname(distcode) as district,(select count(supervisorcode) from supervisordb where districts.distcode=supervisordb.distcode and  status='Active' ) as totalsupervisor,(select count(supervisorcode) from supervisordb where $wc and  status='Active' ) as totalprosupervisor,$Allmonthplan,$Allmonthconduct,$Allmonthpersent,$Totalplan,$Totalconduct,$Totalpersent,$Totalplanh,$Totalconducth,$Totalpersenth,$Totalplanl,$Totalconductl,$Totalpersentl
					from districts where $wc group by distcode order by districtname(distcode) ASC";
			$result = $this->db->query($query);
			$result = $result->result();
		return $result;
	}
	function RedRec_HF_supervisoryvisit_tech_compliance ($distcode,$year){
		$distcode;
		$year;
		
		$curuntmonth = date('m');
		$Allmonthplan="";
		$Allmonthconduct="";
		$Allmonthpersent="";
		$Totalplanh   ="";   
		$Totalconducth="";
		$Totalpersenth="";
		for($month=1; $month<=$curuntmonth; $month++){
			if($month < 10){
				$month='0'.$month;
			}
			$Allmonthplan.="   (select count(planned_date) from supervisory_plan where fmonth='$year-$month' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as plan$month,";
			$Allmonthconduct.="(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as conduct$month,";
			$Allmonthpersent.="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth='$year-$month' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as persent$month,";
			//////////for last horizontal total ////////////
			$Totalplanh.="(select count(planned_date) from supervisory_plan where fmonth='$year-$month' and distcode='$distcode' ) as totalsupervisorsplanh$month,";
			$Totalconducth.="(select count(conduct_date) from supervisory_plan where fmonth='$year-$month' and distcode='$distcode' ) as totalsupervisorsconducth$month,";
			$Totalpersenth.="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth='$year-$month' and distcode='$distcode' ) as totalsupervisorspersenth$month,";
			///////////enf horizontal//////////
		}
			$Totalplan="(select count(planned_date) from supervisory_plan where fmonth like '$year-%' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as totalsupervisorsplan";
			$Totalconduct="(select count(conduct_date) from supervisory_plan where fmonth like '$year-%' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as totalsupervisorsconduct";
			$Totalpersent="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth like '$year-%' and supervisory_plan.supervisorcode=supervisordb.supervisorcode ) as totalsupervisorspersent";
			//////////for last horizontal  Alltotal ////////////
			$Totalplanl="(select count(planned_date) from supervisory_plan where fmonth like '$year-%' and distcode='$distcode' ) as totalsupervisorsplanl";
			$Totalconductl="(select count(conduct_date) from supervisory_plan where fmonth like '$year-%' and distcode='$distcode' ) as totalsupervisorsconductl";
			$Totalpersentl="(select  round((count(conduct_date)::float//count(planned_date))::numeric*100,0) as p from supervisory_plan where fmonth like '$year-%' and distcode='$distcode' ) as totalsupervisorspersentl";
			//////////end horizontal Alltotal ////////////
			$Allmonthplan = rtrim($Allmonthplan,",");
			$Allmonthconduct = rtrim($Allmonthconduct,",");
			$Allmonthpersent = rtrim($Allmonthpersent,",");
			$Totalplanh    = rtrim($Totalplanh,",");
			$Totalconducth = rtrim($Totalconducth,",");
			$Totalpersenth = rtrim($Totalpersenth,",");
			 $query="select distinct (supervisorcode) as supervisorname ,supervisor_type, $Allmonthplan,$Allmonthconduct,$Allmonthpersent,$Totalplan,$Totalconduct,$Totalpersent,$Totalplanh,$Totalconducth,$Totalpersenth,$Totalplanl,$Totalconductl,$Totalpersentl
					from supervisordb where distcode='$distcode' and status='Active' ";
			$result = $this->db->query($query);
			$result = $result->result();
		    return $result;
	}
	function RedRec_HF_supervisoryvisit_view($supervisorcode,$fmonth){
		$query = "select * from supervisory_plan where supervisorcode='$supervisorcode' and fmonth='$fmonth'";
		$result = $this->db->query($query);	
		$data['data'] =	$result->result_array();
		return $data['data'];
	}
}
