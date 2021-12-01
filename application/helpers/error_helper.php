<?php

if(!function_exists('error_notif')){
	function error_notif($distcode){
		$CI = & get_instance();
		
		$query = "Select * from
					(select count(*) FZP from facilities left join facilities_population pop on facilities.facode = pop.facode where facilities.distcode='$distcode' and hf_type='e' AND pop.year = '".date('Y')."' and (pop.population is null OR pop.population::integer < 1) AND getfstatus_vacc('" . date('Y') . "-" . date('m',strtotime('first day of previous months')) . "',facilities.facode)='F') as FZP,

					(select count(*) TZP from tehsil left join tehsil_population pop on tehsil.tcode = pop.tcode where tehsil.distcode='$distcode' and pop.year = '".date('Y')."' and (pop.population is null OR pop.population < 1) ) as TZP,

					(select count(*) UZP from unioncouncil left join unioncouncil_population pop on unioncouncil.uncode = pop.uncode where pop.year = '".date('Y')."' and (pop.population is null OR pop.population::integer < 1) AND unioncouncil.distcode='$distcode' )as UZP,

					(select count(*) FZT from facilities where facode NOT IN ( SELECT DISTINCT post_facode from (SELECT DISTINCT ON (code) code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery  where post_status='Active' and post_hr_sub_type_id='01' and post_distcode='$distcode') and distcode='$distcode' and hf_type = 'e' and is_vacc_fac = '1') as FZT,

					(select count(*) UCNAF from unioncouncil  where uncode not in (select uncode from facilities where hf_type='e') and distcode='$distcode') as UCNAF,

					(select count(*) DTR from hr_db where nic in (SELECT nic FROM hr_db where distcode='$distcode' AND hr_sub_type_id='01' GROUP BY nic HAVING COUNT(nic) > 1 ) and distcode='$distcode') as DTR
		       ";
		$result = $CI -> db -> query($query);
		$result1 = $result->result_array();
		$labeledArray = array(
							'fzp' => array(
								'name'=>'Active Facilities With Zero Population',
								'link'=>'facilities-with-zero-population'
							),
							'tzp' => array(
								'name'=>'Tehsils With Zero Population',
								'link'=>'tehsils-with-zero-population'
							),
							'uzp' => array(
								'name'=>'Unioncouncils With Zero Population',
								'link'=>'ucs-with-zero-population'
							),
							'fzt' => array(
								'name'=>'Facilities With Zero Technician',
								'link'=>'facilities-with-zero-technicians'
							),
							'ucnaf' => array(
								'name'=>'Unioncouncils with no attached facilities',
								'link'=>'ucs-with-no-attached-facilities'
							),
							'dtr' => array(
								'name'=>'Duplicate Technician Records',
								'link'=>'duplicate-technician-records'
							)		
		);
		
		$html="";$count=0;
        
		if($result1[0]['fzp'] > 0 || $result1[0]['tzp'] > 0 || $result1[0]['uzp'] > 0 || $result1[0]['fzt'] > 0 || $result1[0]['ucnaf'] > 0 || $result1[0]['dtr'] > 0 )
		{
			
			foreach($result1[0] as $key => $value){
				if($value > 0)
				{
					$count++;
					$html.='<li class="user-footer">
						<a href="'.base_url().$labeledArray[$key]['link'].'" class="anchor-uk" target="_blank">'.$labeledArray[$key]['name'].'</a>
					 </li>';
				}
			}
			return '
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell blinking"></i><span>'.$count.'</span></a>
					<ul class="dropdown-menu">'.$html.'</ul>';	
	    }
		else
		{
			return "";
		}
	}
}

?>