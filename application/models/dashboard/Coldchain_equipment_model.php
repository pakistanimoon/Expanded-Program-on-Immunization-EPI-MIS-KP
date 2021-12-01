<?php
class Coldchain_equipment_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> model('Common_model');
	}
	/*public function get_cc_equipments_count($status=null,$distcode=null){
		$statuswhr = '';
		$name = "districtname(distcode) as name";
		$code = 'distcode';
		if($status)
			$statuswhr = " and ccm.asset_status = '".$status."'";
		if($distcode)
		{
			$statuswhr .= " and left(cast(ccm.storecode as text) ,'3') = '".$distcode."'";
			$name = "unname(uncode) as name";
			$code = 'uncode';
		}
			
			$query = "select {$code} as code,{$name},
					count(case types.parent_id when 1 then 1 end) as refrigerator,
					count(case types.parent_id when 21 then 1 end) as coldroom,
					count(case ccm_sub_asset_type_id when 23 then 1 end) as voltage_regulator,
					count(case ccm_sub_asset_type_id when 24 then 1 end) as generator,
					count(case types.parent_id when 25 then 1 end) as transport,
					count(case ccm_sub_asset_type_id when 26 then 1 end) as vaccine_carrier,
					count(case ccm_sub_asset_type_id when 27 then 1 end) as ic_pack,
					count(case ccm_sub_asset_type_id when 33 then 1 end) as cold_box
					from epi_cc_coldchain_main ccm
					right join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
					 where storecode is not null   {$statuswhr} group by {$code}";
		 }else{
			$query = "select  left(cast(ccm.storecode as text) ,'3') as code,districtname(left(cast(ccm.storecode as text) ,'3')) as name,ccm.warehouse_type_id as wh_type_code, 
					count(case types.parent_id when 1 then 1 end) as refrigerator, 
					count(case types.parent_id when 21 then 1 end) as coldroom, 
					count(case ccm_sub_asset_type_id when 23 then 1 end) as voltage_regulator, 
					count(case ccm_sub_asset_type_id when 24 then 1 end) as generator, 
					count(case types.parent_id when 25 then 1 end) as transport, 
					count(case ccm_sub_asset_type_id when 26 then 1 end) as vaccine_carrier,
					 count(case ccm_sub_asset_type_id when 27 then 1 end) as ic_pack, 
					 count(case ccm_sub_asset_type_id when 33 then 1 end) as cold_box 
					 from epi_cc_coldchain_main ccm 
					 right join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
					 where storecode is not null   and ccm.asset_status = 'Active' 
					 group by left(cast(ccm.storecode as text) ,'3'),ccm.warehouse_type_id 
					 order by left(cast(ccm.storecode as text) ,'3'),warehouse_type_id";
		} 
		//print_r($query);exit;
		$query = $this->db->query($query);
		return $query->result_array();
	}*/
	public function get_cc_equipments_count_provincial($status =NULL, $distcode =NULL){
		/* $statuswhr = '';
		if($status)
			$statuswhr = " and ccm.asset_status = '".$status."'";
		if($distcode)
		{
			$select = "ccm.uncode as code, unname(ccm.uncode) as name,";
			$statuswhr .= " and ccm.uncode is not null and ccm.distcode = '".$distcode."'";
			$groupBy = " ccm.uncode,ccm.warehouse_type_id ";
			$orderdBy = " warehouse_type_id";
		}
		else
		{
			$select = "ccm.distcode,left(cast(ccm.storecode as text) ,'3') as code,districtname(left(cast(ccm.storecode as text) ,'3')) as name,";
			$statuswhr .= " and ccm.distcode is not null ";
			$groupBy = " left(cast(ccm.storecode as text) ,'3'),ccm.distcode,ccm.warehouse_type_id";
			$orderdBy = " left(cast(ccm.storecode as text) ,'3') ,warehouse_type_id";
		}
		$this->db->select("{$select} ccm.warehouse_type_id as wh_type_code, 
			count(case types.parent_id when 1 then 1 end) as refrigerator, 
			count(case types.parent_id when 21 then 1 end) as cold_room, 
			count(case ccm_sub_asset_type_id when 23 then 1 end) as voltage_regulator, 
			count(case ccm_sub_asset_type_id when 24 then 1 end) as generator, 
			count(case types.parent_id when 25 then 1 end) as transport, 
			count(case ccm_sub_asset_type_id when 26 then 1 end) as vaccine_carrier,
			count(case ccm_sub_asset_type_id when 27 then 1 end) as ice_pack, 
			count(case ccm_sub_asset_type_id when 33 then 1 end) as cold_box",FALSE);
		$this->db->from("epi_cc_coldchain_main ccm");
		$this->db->join("epi_cc_asset_types types","types.pk_id = ccm.ccm_sub_asset_type_id");
		$this->db->where("storecode is not null  {$statuswhr}");
		
		$this->db->group_by("{$groupBy}");
		$this->db->order_by("{$orderdBy}");
		$result = $this->db->get()->result_array();//echo $this->db->last_query();exit; */
		$wcinn = "storecode is not null";
		$wcout = "";
		$alias = "dist";
		$code ="distcode";
		$table = "districts ";
		$dbfunc = "districtname";
		if($status){
				$wcinn .= " and ccm.asset_status='{$status}'";
		}
		if($distcode){
			$wcinn .= " and ccm.distcode='{$distcode}'";
			$wcout = "where un.distcode='{$distcode}'";
			$alias = "un";
			$code ="uncode";
			$table = "unioncouncil ";
			$dbfunc = "unname";
		}
		$query = "SELECT {$alias}.{$code} as code, {$dbfunc}({$alias}.{$code}) as name,
					wh_type_code,refrigerator,cold_room,voltage_regulator,generator,transport,vaccine_carrier,ice_pack,cold_box
					 from {$table} {$alias} full join ( select ccm.{$code},
							ccm.warehouse_type_id as wh_type_code, 
							count(case types.parent_id when 1 then 1 end) as refrigerator, 
							count(case types.parent_id when 21 then 1 end) as cold_room, 
							count(case ccm_sub_asset_type_id when 23 then 1 end) as voltage_regulator, 
							count(case ccm_sub_asset_type_id when 24 then 1 end) as generator, 
							count(case types.parent_id when 25 then 1 end) as transport, 
							count(case ccm_sub_asset_type_id when 26 then 1 end) as vaccine_carrier, 
							count(case ccm_sub_asset_type_id when 27 then 1 end) as ice_pack, 
							count(case ccm_sub_asset_type_id when 33 then 1 end) as cold_box 
							FROM epi_cc_coldchain_main ccm 
							JOIN epi_cc_asset_types types ON types.pk_id = ccm.ccm_sub_asset_type_id 
							WHERE {$wcinn} and ccm.{$code} is not null  
							GROUP BY ccm.{$code}, ccm.warehouse_type_id 
						) as tbl on tbl.{$code}={$alias}.{$code}
					{$wcout}
					group by {$alias}.{$code},wh_type_code,refrigerator,cold_room,voltage_regulator,generator,transport,vaccine_carrier,ice_pack,cold_box
					order by {$alias}.{$code}";//echo $query;exit;
		$query = $this->db->query($query);
		$return = $query->result_array();
		returN $return;
	}
	public function get_cc_equipments_provincial_store($code,$status)
	{
		$statuswhr = "";
		if($code)
			$statuswhr = " ccm.storecode = '".$code."' and";
		if($status)
			$statuswhr .= " ccm.asset_status = '".$status."'";
		$this->db->select("ccm.warehouse_type_id as wh_type_code,left(cast(ccm.storecode as text), '3') as code,
			count(case types.parent_id when 1 then 1 end) as refrigerator, 
			count(case types.parent_id when 21 then 1 end) as cold_room, 
			count(case ccm_sub_asset_type_id when 23 then 1 end) as voltage_regulator, 
			count(case ccm_sub_asset_type_id when 24 then 1 end) as generator, 
			count(case types.parent_id when 25 then 1 end) as transport, 
			count(case ccm_sub_asset_type_id when 26 then 1 end) as vaccine_carrier, 
			count(case ccm_sub_asset_type_id when 27 then 1 end) as ice_pack, 
			count(case ccm_sub_asset_type_id when 33 then 1 end) as cold_box ",FALSE);
		$this->db->from("epi_cc_coldchain_main ccm");
		$this->db->join("epi_cc_asset_types types","types.pk_id = ccm.ccm_sub_asset_type_id");
		$this->db->where("{$statuswhr}");
		$this->db->group_by("ccm.warehouse_type_id ,left(cast(ccm.storecode as text), '3')");
		$this->db->order_by("warehouse_type_id");
		$return = $this->db->get()->result_array();//echo $this->db->last_query();exit;
		returN $return;
	}
	public function get_cc_wsWise_counts($typeId='1',$distcode = NULL,$level=FALSE,$assetstatus='1',$type=NULL)
	{
		/* $query ="
			select dist.distcode as code,districtname(dist.distcode) as name,working_well,
			w_need_maintenance,w_not,w_well_f_available,w_well_f_not_available
			from districts dist full join (
			select ccm.distcode, count(case ccm.status when 1 then 1 end) as working_well,
			count(case ccm.status when 2 then 1 end) as w_need_maintenance,
			count(case ccm.status when 3 then 1 end) as w_not,
			count(case ccm.status when 4 then 1 end) as w_well_f_available,
			count(case ccm.status when 5 then 1 end) as w_well_f_not_available
			from epi_cc_coldchain_main ccm 
			join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
			where assets.parent_id=21 and ccm.distcode is not null group by ccm.distcode
			) as tble on tble.distcode=dist.distcode
			group by dist.distcode,working_well,w_need_maintenance,w_not,w_well_f_available,w_well_f_not_available
			order by dist.distcode
			"; */
		//$wc = "length(left(cast(ccm.storecode as text), '3'))='3' and ccm.asset_status = 'Active' and ccm.distcode is not null and ccm.storecode is not null";
		$wc = "";
		$wc1 = "";
		if($typeId=='23' || $typeId=='26' || $typeId=='33' || $typeId=='24')
			{ 
				$wc1 = "inn.pk_id = '{$typeId}'";
				$nameId = "pk_id ";
			}
			else 
			{
				$wc1 = "inn.parent_id = '{$typeId}'";
				$nameId = "parent_id ";
			}
		if($distcode != NULL)
		{
			 $wc = " and ccm.distcode = '{$distcode}' ";
		}
		if($level)
		{
			$wc .= " and ccm.distcode is not null and ccm.storecode is not null";
			$this->db->select("ccm.warehouse_type_id as wh_type_code,
			left(cast(ccm.storecode as text), '3') as code, 
			count(case types.{$nameId} when {$typeId} then case ccm.status when {$assetstatus} then 1 end end) as {$type} ",FALSE);
			$this->db->from("epi_cc_coldchain_main ccm");
			$this->db->join("epi_cc_asset_types types","types.pk_id = ccm.ccm_sub_asset_type_id");
			$this->db->where("ccm.asset_status = 'Active' {$wc} and ccm.status is not null");
			$this->db->group_by("ccm.warehouse_type_id ,left(cast(ccm.storecode as text), '3')");
			$this->db->order_by("warehouse_type_id");
			//echo $this->db->last_query();exit; 
			$return = $this->db->get()->result_array(); 
		//	echo $this->db->last_query();exit;
		}
		else
			
			
		{
			 $wc .= " and asset_status = 'Active'";
			
			$query ="
			select 
				ccm.status as workingstatus,
				count(ccm.*) as available
			from 
				epi_cc_coldchain_main ccm 
			JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where {$wc1}
				)
				{$wc} and ccm.status is not null
			group by 
				ccm.status"; //print_r($query);exit;
			$query = $this->db->query($query);
			$return = $query->result_array();
		}
		return $return;
	}
	public function getdistrictWisewsData($typeId='1',$wh_type_code,$w_status,$distcode=NULL)
	{
		if($typeId=='23' || $typeId=='24' || $typeId=='26' || $typeId=='33' )
		{
			$wc = "types.pk_id='{$typeId}'";
		}
		else 
		{
			$wc = "types.parent_id='{$typeId}'";
		}
		if($distcode !=NULL){
			if($wh_type_code=="5"){
				$query ="
				select tcode as code , tehsilname(tcode) as name , count(*) 
				from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id = ccm.ccm_sub_asset_type_id
			where {$wc} and ccm.warehouse_type_id='{$wh_type_code}' and ccm.distcode='{$distcode}' and ccm.status='{$w_status}' and asset_status='Active'
				group by tcode order by tcode
			";
			}
			else
			{
				$query ="
					select un.uncode as code , unname(un.uncode) as name , count
					from unioncouncil un full join (
					select ccm.uncode ,count(*)
					from epi_cc_coldchain_main ccm
					join epi_cc_asset_types types on types.pk_id = ccm.ccm_sub_asset_type_id
					where ccm.warehouse_type_id='{$wh_type_code}' and  {$wc} and ccm.distcode='{$distcode}' and ccm.status='{$w_status}' and asset_status='Active'
					group by ccm.uncode ) as tbl on tbl.uncode=un.uncode 
					where un.distcode='{$distcode}'
					group by un.uncode,count
					order by un.uncode
				";
			}
		}
		else
		{
			$query = "select dist.distcode as code,districtname(dist.distcode) as name,count
				from districts dist full join (
					select ccm.distcode, count(*) as count
					from epi_cc_coldchain_main ccm 
					join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
					where ccm.warehouse_type_id='{$wh_type_code}' and ccm.status='{$w_status}' and {$wc} and ccm.distcode is not null group by ccm.distcode
					) as tble on tble.distcode=dist.distcode
				group by dist.distcode,tble.count
				order by dist.distcode
			";
			//print_r($query);exit;  
		}
		$query = $this->db->query($query);
		$return = $query->result_array();
		return $return;
	}
	public function get_cc_assetType_counts($typeId='1',$level=FALSE,$asset_typeID='13',$distcode=NULL)
	{
		$wc="";
		$wc1 = "";
		if($typeId=='23' || $typeId=='26'|| $typeId=='33')
			{ 
				$wc1 = "pk_id = '{$typeId}'";
				$nameId = "pk_id ";
			}
			else 
			{
				$wc1 = "parent_id = '{$typeId}'";
				$nameId = "parent_id ";
			}
		if($distcode)
			$wc = " and ccm.distcode ='{$distcode}'";
		if($level)
		{
			$this->db->select("ccm.warehouse_type_id as wh_type_code, left(cast(ccm.storecode as text), '3') as code, count(*) as count",FALSE);
			$this->db->from("epi_cc_coldchain_main ccm");
			$this->db->join("epi_cc_asset_types types","types.pk_id = ccm.ccm_sub_asset_type_id");
			$this->db->where("ccm.ccm_sub_asset_type_id='{$asset_typeID}' and types.{$nameId}='{$typeId}' and length(left(cast(ccm.storecode as text), '3')) = '3' and ccm.asset_status = 'Active' {$wc} and ccm.storecode is not null");
			$this->db->group_by("ccm.warehouse_type_id ,left(cast(ccm.storecode as text), '3')");
			$this->db->order_by("warehouse_type_id");
			//echo $this->db->last_query(); exit; 
			$return = $this->db->get()->result_array(); //echo $this->db->last_query();exit; 
		}
		else
		{
			$query ="
				select 
				assets.asset_type_name,assetid,
				(
					select count(ccm.*) from epi_cc_coldchain_main ccm 
					JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
					LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
					where ccm.ccm_sub_asset_type_id = assets.assetid and asset_status = 'Active' {$wc}
				) as available 
			FROM 
				(
					select 
						epi_cc_asset_types.pk_id as assetid,
						epi_cc_asset_types.asset_type_name
					FROM epi_cc_asset_types
					where {$wc1}
				) as assets"; //echo $query;exit;
			$query = $this->db->query($query);
			$return = $query->result_array();
		}
		return $return;
	}
	public function getdistrictATWdata($distcode=NULL,$typeId,$wh_type_code,$asset_typeID=NULL)
	{
		$wc = "ccm.warehouse_type_id='{$wh_type_code}'  and assets.parent_id='{$typeId}' and ccm.asset_status = 'Active' and ccm.distcode is not null ";
		if($asset_typeID != NULL)
		{
			$wc .= " and ccm.ccm_sub_asset_type_id='{$asset_typeID}'";
		}
		$wc1 = "";
		if($distcode){
			
			if($wh_type_code==6){
				$wc1=" where un.distcode='{$distcode}'";
			$query ="
					select un.uncode as code,unname(un.uncode) as name,count
					from unioncouncil un full join (
						select ccm.uncode, count(*) as count
						from epi_cc_coldchain_main ccm 
						join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
						where {$wc}
						group by ccm.uncode) as tble on tble.uncode=un.uncode
						{$wc1}
					group by un.uncode,count
					order by un.uncode
				";
			}else{
				$wc1=" where teh.distcode='{$distcode}'";
				$query ="
					select teh.tcode as code,tehsilname(teh.tcode) as name,count
					from tehsil teh full join (
						select ccm.tcode, count(*) as count
						from epi_cc_coldchain_main ccm 
						join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
						where {$wc}
						group by ccm.tcode) as tble on tble.tcode=teh.tcode
						{$wc1}
					group by teh.tcode,count
					order by teh.tcode
				";
			}
		}else{
			$query ="
					select dist.distcode as code,districtname(dist.distcode) as name,count
					from districts dist full join (
						select ccm.distcode, count(*) as count
						from epi_cc_coldchain_main ccm 
						join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
						where {$wc}
						group by ccm.distcode) as tble on tble.distcode=dist.distcode
					group by dist.distcode,tble.count
					order by dist.distcode
				";//print_r($query);exit;
		}
		$query = $this->db->query($query); 
		return $return = $query->result_array();
	}
	public function get_cc_ysWise_counts($typeId='1',$level=FALSE,$year=NULL,$distcode=NULL)
	{ 
		$wc1="";
		$wc = "";
		if($typeId=='23' || $typeId=='26' || $typeId=='24' || $typeId=='33'){
			$wc .=" types.pk_id='{$typeId}'";
			$wc2 = "inn.pk_id = {$typeId}";
		}else{
			$wc .=" types.parent_id='{$typeId}'";
			$wc2 = "inn.parent_id = {$typeId}";
		}
		if($distcode)
			$wc .=" and ccm.distcode='{$distcode}'";
		if($level)
		{ 
			if($year !='NULL')
				$wc .= " and to_char(ccm.working_since,'YYYY')='{$year}'";
			else
				$wc .= " and ccm.working_since is not null";
			$this->db->select("ccm.warehouse_type_id as wh_type_code, left(cast(ccm.storecode as text), '3') as code, count(*) as count",FALSE);
			$this->db->from("epi_cc_coldchain_main ccm");
			$this->db->join("epi_cc_asset_types types","types.pk_id = ccm.ccm_sub_asset_type_id");
			$this->db->where("{$wc}  and length(left(cast(ccm.storecode as text), '3')) = '3' and ccm.asset_status = 'Active' {$wc1} and ccm.storecode is not null");
			$this->db->group_by("ccm.warehouse_type_id ,left(cast(ccm.storecode as text), '3')");
			$this->db->order_by("warehouse_type_id");
			$return = $this->db->get()->result_array();//echo $this->db->last_query();exit;
		}
		else
		{
			$query ="
				select 
					coalesce(to_char(ccm.working_since,'YYYY'),'NULL') as yearsupply,
					count(ccm.*) as available
				from 
					epi_cc_coldchain_main ccm 
				JOIN 
					epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
				LEFT JOIN 
					epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
				where 
					ccm.ccm_sub_asset_type_id IN (
						select inn.pk_id as ids from epi_cc_asset_types inn where {$wc2}
					) 
					and asset_status = 'Active' {$wc1} and ccm.working_since is not null
				group by 
					to_char(ccm.working_since,'YYYY')
				order by 
					to_char(ccm.working_since,'YYYY')";//echo $query;exit;
			$query = $this->db->query($query);
			$return = $query->result_array();
		}
		return $return;
	}
	public function getdistrictYWdata($distcode=NULL,$typeId,$wh_type_code,$yearWise=NULL)
	{
		/* $wc = "ccm.warehouse_type_id='{$wh_type_code}'  and assets.parent_id='{$typeId}' and length(left(cast(ccm.storecode as text), '3')) = '3' 
					and ccm.asset_status = 'Active' and ccm.distcode is not null and ccm.storecode is not null"; */
		if($typeId =="23" || $typeId =="24"|| $typeId =="26"|| $typeId =="33"){
			$typeId = "assets.pk_id='{$typeId}'";
		}else{
			$typeId = "assets.parent_id='{$typeId}'";
		}
		$wc = "{$typeId} and ccm.warehouse_type_id='{$wh_type_code}' and ccm.asset_status = 'Active' and ccm.distcode is not null ";
		if($yearWise != 'NULL')
		{
			$wc .= " and to_char(ccm.working_since,'YYYY')='{$yearWise}'";
		}else{
			$wc .= " and ccm.working_since is null";
		}
		if($distcode != NULL)
		{
			if($wh_type_code==6){
				$query ="
					select un.uncode as code,unname(un.uncode) as name,count
					from unioncouncil un full join (
						select ccm.uncode, count(*) as count
						from epi_cc_coldchain_main ccm 
						join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
						where {$wc}
						group by ccm.uncode) as tble on tble.uncode=un.uncode
					where un.distcode = '{$distcode}'
					group by un.uncode,tble.count
					order by un.uncode
				";//print_r($query);exit;
			}
			else
			{
				$query ="
					select teh.tcode as code,tehsilname(teh.tcode) as name,count
					from tehsil teh full join (
						select ccm.tcode, count(*) as count
						from epi_cc_coldchain_main ccm 
						join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
						where {$wc}
						group by ccm.tcode) as tble on tble.tcode=teh.tcode
					where teh.distcode = '{$distcode}'
					group by teh.tcode,tble.count
					order by teh.tcode
				";
			}
		}
		else
		{
			$query ="
				select dist.distcode as code,districtname(dist.distcode) as name,count
				from districts dist full join (
					select ccm.distcode, count(*) as count
					from epi_cc_coldchain_main ccm 
					join epi_cc_asset_types assets on assets.pk_id=ccm.ccm_sub_asset_type_id
					where {$wc}
					group by ccm.distcode) as tble on tble.distcode=dist.distcode
				group by dist.distcode,tble.count
				order by dist.distcode
			";
		}
		//print_r($query);exit;
		$query = $this->db->query($query);
		return $return = $query->result_array();
	}
	public function mapsData()
	{
		$query = "
			SELECT districts.distcode as code,
			districts.district as name,
			(
			select count(*) from epi_cc_coldchain_main ccm
			join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
			where ccm.distcode is not null and storecode is not null and types.parent_id='1' and ccm.distcode=districts.distcode
			) as sum ,d2.path FROM districts LEFT JOIN districts_wise_maps_paths d2 ON districts.distcode=d2.distcode
		";
		$query = $this -> db -> query($query);
		return $query -> result();
	}
}
?>