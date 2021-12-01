<?php
//local
class Cerv_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function datewise_latlong($date){
		$this -> db -> select('latitude,longitude');
		$this -> db -> from('cerv_child_registration');
		$this -> db -> where(array('addeddatetime'=>$date));
		$this -> db -> where('latitude IS NOT NULL and deleted_at IS NULL');
		$this -> db -> group_by('latitude,longitude');
		return $this -> db -> get() -> result_array();
	}
	
	public function latlong_vaccination($lat,$long,$date){
		$this -> db -> select('technicianname(techniciancode) as vaccinator,districtname(distcode) as district,*');
		$this -> db -> from('cerv_child_registration');
		$this -> db -> where(array('addeddatetime'=>$date,'latitude'=>$lat,'longitude'=>$long));
		$this -> db -> where('deleted_at IS Null');
		return $this -> db -> get() -> result_array();
	}
	
	public function uc_coverage($year,$month){
		$fmonth = $year."-".$month;
		$query = "
			SELECT 
				uncode,unname,
				COALESCE(mnewborntarget,0) as mnewborntarget,COALESCE(fnewborntarget,0) as fnewborntarget,COALESCE(tnewborntarget,0) as tnewborntarget,
				COALESCE(msurvivinginfantstarget,0) as msurvivinginfantstarget,COALESCE(fsurvivinginfantstarget,0) as fsurvivinginfantstarget,COALESCE(tsurvivinginfantstarget,0) as tsurvivinginfantstarget,
				COALESCE(mbcg,0) as mbcg,COALESCE(round(mbcg/mnewborntarget*100),0) as mbcgperc,
				COALESCE(fbcg,0) as fbcg,COALESCE(round(fbcg/fnewborntarget*100),0) as fbcgperc,
				COALESCE(tbcg,0) as tbcg,COALESCE(round(tbcg/tnewborntarget*100),0) as tbcgperc,
				
				COALESCE(mhepb,0) as mhepb,COALESCE(round(mhepb/mnewborntarget*100),0) as mhepbperc,
				COALESCE(fhepb,0) as fhepb,COALESCE(round(fhepb/fnewborntarget*100),0) as fhepbperc,
				COALESCE(thepb,0) as thepb,COALESCE(round(thepb/tnewborntarget*100),0) as thepbperc,
				
				COALESCE(mopv0,0) as mopv0,COALESCE(round(mopv0/mnewborntarget*100),0) as mopv0perc,
				COALESCE(fopv0,0) as fopv0,COALESCE(round(fopv0/fnewborntarget*100),0) as fopv0perc,
				COALESCE(topv0,0) as topv0,COALESCE(round(topv0/tnewborntarget*100),0) as topv0perc,
				
				COALESCE(mopv1,0) as mopv1,COALESCE(round(mopv1/msurvivinginfantstarget*100),0) as mopv1perc,
				COALESCE(fopv1,0) as fopv1,COALESCE(round(fopv1/fsurvivinginfantstarget*100),0) as fopv1perc,
				COALESCE(topv1,0) as topv1,COALESCE(round(topv1/tsurvivinginfantstarget*100),0) as topv1perc,
				
				COALESCE(mopv2,0) as mopv2,COALESCE(round(mopv2/msurvivinginfantstarget*100),0) as mopv2perc,
				COALESCE(fopv2,0) as fopv2,COALESCE(round(fopv2/fsurvivinginfantstarget*100),0) as fopv2perc,
				COALESCE(topv2,0) as topv2,COALESCE(round(topv2/tsurvivinginfantstarget*100),0) as topv2perc,
				
				COALESCE(mopv3,0) as mopv3,COALESCE(round(mopv3/msurvivinginfantstarget*100),0) as mopv3perc,
				COALESCE(fopv3,0) as fopv3,COALESCE(round(fopv3/fsurvivinginfantstarget*100),0) as fopv3perc,
				COALESCE(topv3,0) as topv3,COALESCE(round(topv3/tsurvivinginfantstarget*100),0) as topv3perc,
				
				COALESCE(mpenta1,0) as mpenta1,COALESCE(round(mpenta1/msurvivinginfantstarget*100),0) as mpenta1perc,
				COALESCE(fpenta1,0) as fpenta1,COALESCE(round(fpenta1/fsurvivinginfantstarget*100),0) as fpenta1perc,
				COALESCE(tpenta1,0) as tpenta1,COALESCE(round(tpenta1/tsurvivinginfantstarget*100),0) as tpenta1perc,
				
				COALESCE(mpenta2,0) as mpenta2,COALESCE(round(mpenta2/msurvivinginfantstarget*100),0) as mpenta2perc,
				COALESCE(fpenta2,0) as fpenta2,COALESCE(round(fpenta2/fsurvivinginfantstarget*100),0) as fpenta2perc,
				COALESCE(tpenta2,0) as tpenta2,COALESCE(round(tpenta2/tsurvivinginfantstarget*100),0) as tpenta2perc,
				
				COALESCE(mpenta3,0) as mpenta3,COALESCE(round(mpenta3/msurvivinginfantstarget*100),0) as mpenta3perc,
				COALESCE(fpenta3,0) as fpenta3,COALESCE(round(fpenta3/fsurvivinginfantstarget*100),0) as fpenta3perc,
				COALESCE(tpenta3,0) as tpenta3,COALESCE(round(tpenta3/tsurvivinginfantstarget*100),0) as tpenta3perc,
				
				COALESCE(mpcv1,0) as mpcv1,COALESCE(round(mpcv1/msurvivinginfantstarget*100),0) as mpcv1perc,
				COALESCE(fpcv1,0) as fpcv1,COALESCE(round(fpcv1/fsurvivinginfantstarget*100),0) as fpcv1perc,
				COALESCE(tpcv1,0) as tpcv1,COALESCE(round(tpcv1/tsurvivinginfantstarget*100),0) as tpcv1perc,
				
				COALESCE(mpcv2,0) as mpcv2,COALESCE(round(mpcv2/msurvivinginfantstarget*100),0) as mpcv2perc,
				COALESCE(fpcv2,0) as fpcv2,COALESCE(round(fpcv2/fsurvivinginfantstarget*100),0) as fpcv2perc,
				COALESCE(tpcv2,0) as tpcv2,COALESCE(round(tpcv2/tsurvivinginfantstarget*100),0) as tpcv2perc,
				
				COALESCE(mpcv3,0) as mpcv3,COALESCE(round(mpcv3/msurvivinginfantstarget*100),0) as mpcv3perc,
				COALESCE(fpcv3,0) as fpcv3,COALESCE(round(fpcv3/fsurvivinginfantstarget*100),0) as fpcv3perc,
				COALESCE(tpcv3,0) as tpcv3,COALESCE(round(tpcv3/tsurvivinginfantstarget*100),0) as tpcv3perc,
				
				COALESCE(mipv,0) as mipv,COALESCE(round(mipv/msurvivinginfantstarget*100),0) as mipvperc,
				COALESCE(fipv,0) as fipv,COALESCE(round(fipv/fsurvivinginfantstarget*100),0) as fipvperc,
				COALESCE(tipv,0) as tipv,COALESCE(round(tipv/tsurvivinginfantstarget*100),0) as tipvperc,
				
				COALESCE(mrota1,0) as mrota1,COALESCE(round(mrota1/msurvivinginfantstarget*100),0) as mrota1perc,
				COALESCE(frota1,0) as frota1,COALESCE(round(frota1/fsurvivinginfantstarget*100),0) as frota1perc,
				COALESCE(trota1,0) as trota1,COALESCE(round(trota1/tsurvivinginfantstarget*100),0) as trota1perc,
				
				COALESCE(mrota2,0) as mrota2,COALESCE(round(mrota2/msurvivinginfantstarget*100),0) as mrota2perc,
				COALESCE(frota2,0) as frota2,COALESCE(round(frota2/fsurvivinginfantstarget*100),0) as frota2perc,
				COALESCE(trota2,0) as trota2,COALESCE(round(trota2/tsurvivinginfantstarget*100),0) as trota2perc,
				
				COALESCE(mmeasles1,0) as mmeasles1,COALESCE(round(mmeasles1/msurvivinginfantstarget*100),0) as mmeasles1perc,
				COALESCE(fmeasles1,0) as fmeasles1,COALESCE(round(fmeasles1/fsurvivinginfantstarget*100),0) as fmeasles1perc,
				COALESCE(tmeasles1,0) as tmeasles1,COALESCE(round(tmeasles1/tsurvivinginfantstarget*100),0) as tmeasles1perc,
				
				COALESCE(mmeasles2,0) as mmeasles2,COALESCE(round(mmeasles2/msurvivinginfantstarget*100),0) as mmeasles2perc,
				COALESCE(fmeasles2,0) as fmeasles2,COALESCE(round(fmeasles2/fsurvivinginfantstarget*100),0) as fmeasles2perc,
				COALESCE(tmeasles2,0) as tmeasles2,COALESCE(round(tmeasles2/tsurvivinginfantstarget*100),0) as tmeasles2perc
			FROM 
				(SELECT 
					uncode,unname(uncode) as unname,
					round((getmonthlytarget_specificyearr(uncode,{$year},{$month},{$year},{$month})::numeric)*51/100) as mnewborntarget,
					round((getmonthlytarget_specificyearr(uncode,{$year},{$month},{$year},{$month})::numeric)*49/100) as fnewborntarget,
					round(getmonthlytarget_specificyearr(uncode,{$year},{$month},{$year},{$month})::numeric) as tnewborntarget,
					round((getmonthlytarget_specificyearrsurvivinginfants(uncode,'unioncouncil',{$year},{$month},{$year},{$month})::numeric)*51/100) as msurvivinginfantstarget,
					round((getmonthlytarget_specificyearrsurvivinginfants(uncode,'unioncouncil',{$year},{$month},{$year},{$month})::numeric)*49/100) as fsurvivinginfantstarget,
					round(getmonthlytarget_specificyearrsurvivinginfants(uncode,'unioncouncil',{$year},{$month},{$year},{$month})::numeric) as tsurvivinginfantstarget,
					
					(select sum(case when bcg IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where bcg::text like '{$fmonth}-%' and uncode=ccr.uncode) as mbcg,
					(select sum(case when bcg IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where bcg::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fbcg,
					(select sum(case when bcg IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where bcg::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tbcg,
					
					(select sum(case when hepb IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where hepb::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mhepb,
					(select sum(case when hepb IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where hepb::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fhepb,
					(select sum(case when hepb IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where hepb::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as thepb,
					
					(select sum(case when opv0 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mopv0,
					(select sum(case when opv0 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fopv0,
					(select sum(case when opv0 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv0::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as topv0,
					
					(select sum(case when opv1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mopv1,
					(select sum(case when opv1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fopv1,
					(select sum(case when opv1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as topv1,
					
					(select sum(case when opv2 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mopv2,
					(select sum(case when opv2 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fopv2,
					(select sum(case when opv2 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as topv2,
					
					(select sum(case when opv3 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where opv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mopv3,
					(select sum(case when opv3 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where opv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fopv3,
					(select sum(case when opv3 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where opv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as topv3,
					
					(select sum(case when penta1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where penta1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpenta1,
					(select sum(case when penta1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where penta1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpenta1,
					(select sum(case when penta1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where penta1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpenta1,
					
					(select sum(case when penta2 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where penta2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpenta2,
					(select sum(case when penta2 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where penta2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpenta2,
					(select sum(case when penta2 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where penta2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpenta2,
					
					(select sum(case when penta3 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where penta3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpenta3,
					(select sum(case when penta3 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where penta3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpenta3,
					(select sum(case when penta3 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where penta3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpenta3,
					
					(select sum(case when pcv1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where pcv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpcv1,
					(select sum(case when pcv1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where pcv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpcv1,
					(select sum(case when pcv1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where pcv1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpcv1,
					
					(select sum(case when pcv2 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where pcv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpcv2,
					(select sum(case when pcv2 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where pcv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpcv2,
					(select sum(case when pcv2 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where pcv2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpcv2,
					
					(select sum(case when pcv3 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where pcv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mpcv3,
					(select sum(case when pcv3 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where pcv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fpcv3,
					(select sum(case when pcv3 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where pcv3::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tpcv3,
					
					(select sum(case when ipv IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where ipv::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mipv,
					(select sum(case when ipv IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where ipv::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fipv,
					(select sum(case when ipv IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where ipv::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tipv,
					
					(select sum(case when rota1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where rota1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mrota1,
					(select sum(case when rota1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where rota1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as frota1,
					(select sum(case when rota1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where rota1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as trota1,
					
					(select sum(case when rota2 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where rota2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mrota2,
					(select sum(case when rota2 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where rota2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as frota2,
					(select sum(case when rota2 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where rota2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as trota2,
					
					(select sum(case when measles1 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where measles1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mmeasles1,
					(select sum(case when measles1 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where measles1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fmeasles1,
					(select sum(case when measles1 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where measles1::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tmeasles1,
					
					(select sum(case when measles2 IS NOT NULL AND gender = 'm' THEN 1 ELSE 0 END) from cerv_child_registration where measles2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as mmeasles2,
					(select sum(case when measles2 IS NOT NULL AND gender = 'f' THEN 1 ELSE 0 END) from cerv_child_registration where measles2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as fmeasles2,
					(select sum(case when measles2 IS NOT NULL THEN 1 ELSE 0 END) from cerv_child_registration where measles2::text like '{$fmonth}-%' and uncode=ccr.uncode AND deleted_at IS NULL) as tmeasles2
				FROM 
					cerv_child_registration ccr 
				WHERE uncode like '365%' AND deleted_at IS NULL
				GROUP BY uncode 
				ORDER BY uncode) as a
		";
		return $this -> db -> query($query) -> result_array();
	}
	
	public function to_date_defaulters($date){
		$query = "
			SELECT 
					uncode,unname(uncode) as unname,
					(select COALESCE(sum(case when opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as opv1,
					(select COALESCE(sum(case when rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as rota1,
					(select COALESCE(sum(case when pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as pcv1,
					(select COALESCE(sum(case when penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as penta1,
					
					(select COALESCE(sum(case when opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as opv2,
					(select COALESCE(sum(case when rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as rota2,
					(select COALESCE(sum(case when pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as pcv2,
					(select COALESCE(sum(case when penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as penta2,
					
					(select COALESCE(sum(case when opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as opv3,
					(select COALESCE(sum(case when ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '101' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as ipv,
					(select COALESCE(sum(case when pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as pcv3,
					(select COALESCE(sum(case when penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as penta3,
					
					(select COALESCE(sum(case when measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as measles1,
					(select COALESCE(sum(case when measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day THEN 1 ELSE 0 END),0) from cerv_child_registration where uncode=ccr.uncode AND deleted_at IS NULL) as measles2
				FROM 
					unioncouncil ccr
				WHERE distcode in ('365') 
				GROUP BY uncode 
				ORDER BY uncode
		";
		return $this -> db -> query($query) -> result_array();
	}
	
	public function to_date_defaulters_list($uncode){
		$date = date('Y-m-d');
		$query = "
					Select technicianname(techniciancode) vaccinator,districtname(distcode) as district,unname(uncode) as unioncouncil,* from cerv_child_registration 
							WHERE procode = '".$_SESSION['Province']."' AND uncode='".$uncode."' AND 
							((opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							
							(opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day) OR
							(rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day) OR
							(pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day) OR
							(penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day) OR
							
							(opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day) OR
							(ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '101' day) OR
							(pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day) OR
							(penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day) OR
							
							(measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day) OR
							(measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day))
		";
		return $this -> db -> query($query) -> result_array();
	}
	
	public function attendence($firstDate,$lastDate){
		$distcode =$this->session->District;
		$query = "SELECT ";
		$i=1;
		while($firstDate <= $lastDate)
		{
			$query .= "
				(select case when count(*)>0 then 1 else 0 end from technician_checkin_details where techniciancode=tech.techniciancode and work_date::text='".date('Y-m-d',$firstDate)."') as day{$i},'".date('Y-m-d',$firstDate)."' as checkdate{$i},
			";
			$firstDate = strtotime("+1 day",$firstDate);
			$i++;
		}
		/* $query .= "
			techniciancode,technicianname(techniciancode) as technician,unname(uncode) as uc FROM techniciandb tech where distcode in ('701','702') and techniciancode in ('701049001','702003001','702004001','702009003','702009004','702010001','702013001','702013002') and status='Active' order by techniciancode asc
		"; */
		/* $query .= "
			techniciancode,technicianname(techniciancode) as technician,unname(uncode) as uc FROM techniciandb tech where distcode in ('{$distcode}') and techniciancode like ('{$distcode}%') and status='Active' order by techniciancode asc
		"; */
		
		$query .= "
			techniciancode, name as technician, uc from (SELECT DISTINCT ON (code) code as techniciancode,name,unname(post_uncode) as uc,post_distcode,post_hr_sub_type_id,post_status FROM hr_db_history ORDER BY code DESC, id DESC) as tech where post_distcode in ('{$distcode}') and post_hr_sub_type_id='01' and post_status='Active'
		";
		//exit;
		return $this -> db -> query($query) -> result_array();
	}
	
	public function uc_wise_to_date_defaulters_count(){
		$procode = $this->session->Province;
		$distcode = $this->session->District;
		$date = date('Y-m-d');
		$query = "
					Select uncode as code,ucname as name,path,(select count(*) from cerv_child_registration where uncode=uwmp.uncode AND deleted_at IS Null AND
							((opv1 IS NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(rota1 IS NULL AND rota2 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(pcv1 IS NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							(penta1 IS NULL AND penta2 IS NULL AND penta3 IS NULL AND '{$date}'::date >= dateofbirth + interval '44' day) OR
							
							(opv1 IS NOT NULL AND opv2 IS NULL AND opv3 IS NULL AND '{$date}'::date >= opv1 + interval '30' day) OR
							(rota1 is NOT NULL AND rota2 IS NULL AND '{$date}'::date >= rota1 + interval '30' day) OR
							(pcv1 IS NOT NULL AND pcv2 IS NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv1 + interval '30' day) OR
							(penta1 IS NOT NULL AND penta2 IS NULL AND penta3 is NULL AND '{$date}'::date >= penta1 + interval '30' day) OR
							
							(opv2 IS NOT NULL AND opv3 IS NULL AND '{$date}'::date >= opv2 + interval '30' day) OR
							(ipv IS NULL AND '{$date}'::date >= dateofbirth + interval '101' day) OR
							(pcv2 IS NOT NULL AND pcv3 IS NULL AND '{$date}'::date >= pcv2 + interval '30' day) OR
							(penta2 IS NOT NULL AND penta3 IS NULL AND '{$date}'::date >= penta2 + interval '30' day) OR
							
							(measles1 IS NULL AND measles2 IS NULL AND '{$date}'::date >= dateofbirth + interval '1 month'*9 + interval '1' day) OR
							(measles1 IS NOT NULL AND measles2 IS NULL AND '{$date}'::date >= measles1 + interval '30' day AND '{$date}'::date >= dateofbirth + interval '1 year' + interval '1 month'*3 + interval '1' day))) as cnt from uc_wise_maps_paths uwmp 
							WHERE procode = '{$procode}' and distcode='{$distcode}';
		";
		return $this -> db -> query($query) -> result();
	}
	
	public function getkmldata($uncode){
		if(strlen($uncode) > 3 ){
			$query = "
					Select districtname(distcode) as district,uncode as code,ucname as name,geo_paths from uc_wise_maps_paths where uncode='".$uncode."' ";
					return $this -> db -> query($query) -> row_array();
		}else{
			$query = "
					Select districtname(distcode) as district,uncode as code,ucname as name,geo_paths from uc_wise_maps_paths where uncode='".$uncode."' ";
					return $this -> db -> query($query) -> row_array();
		}
		/* $query = "
					Select districtname(distcode) as district,uncode as code,ucname as name,geo_paths from uc_wise_maps_paths where uncode='".$uncode."' ";
					return $this -> db -> query($query) -> row_array(); */
		
	}
}
?>