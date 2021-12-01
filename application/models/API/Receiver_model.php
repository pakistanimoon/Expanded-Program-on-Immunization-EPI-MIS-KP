<?php
class Receiver_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		//$this -> load -> model ('Common_model',"common");
	}
	//============================ Constructor Function Ends ============================//
	
	
	public function get_cc_equipments_count($status=NULL)
	{
		$statuswhr = '';
		if($status)
			$statuswhr = " and asset_status = '".$status."'";
		$query ="select 
			assets.asset_type_name,
			(
				select count(ccm.*) from epi_cc_coldchain_main ccm 
				LEFT JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
				LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
				where ccm.ccm_sub_asset_type_id = ANY (assets.ids) $statuswhr
			) as available 
		FROM 
			(
				select 
					epi_cc_asset_types.asset_type_name,
					(
						select array_agg(inn.pk_id) as ids from epi_cc_asset_types inn where (inn.pk_id =  epi_cc_asset_types.pk_id OR inn.parent_id =  epi_cc_asset_types.pk_id)
					) as ids
				FROM epi_cc_asset_types
				where parent_id = 0
			) as assets";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_capacity($typeId=NULL)
	{
		$query ="
			select 
				sum(get_capacity_litters($typeId,ccm.asset_id,ccm.ccm_model_id)) as capacity 
			from 
				epi_cc_coldchain_main ccm 
			LEFT JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where inn.parent_id = $typeId
				) 
				and asset_status = 'Active'";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_assetType_counts($typeId=NULL)
	{
		$query ="select 
			assets.asset_type_name,
			(
				select count(ccm.*) from epi_cc_coldchain_main ccm 
				LEFT JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
				LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
				where ccm.ccm_sub_asset_type_id = assets.assetid and asset_status = 'Active'
			) as available 
		FROM 
			(
				select 
					epi_cc_asset_types.pk_id as assetid,
					epi_cc_asset_types.asset_type_name
				FROM epi_cc_asset_types
				where parent_id = $typeId
			) as assets";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_levelWise_counts($typeId=NULL)
	{
		$query ="
			select 
				(case when ccm.warehouse_type_id=0 then 'UnAllocated' else warehousetypename(ccm.warehouse_type_id)||' Stores'  end) as level,
				count(ccm.*) as available
			from 
				epi_cc_coldchain_main ccm 
			LEFT JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where inn.parent_id = $typeId OR (inn.pk_id = $typeId and parent_id = 0)
				) 
				and asset_status = 'Active'
			group by 
				ccm.warehouse_type_id";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_wsWise_counts($typeId=NULL)
	{
		$query ="
			select 
				ccm.status as workingstatus,
				count(ccm.*) as available
			from 
				epi_cc_coldchain_main ccm 
			LEFT JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where inn.parent_id = $typeId OR (inn.pk_id = $typeId and parent_id = 0)
				) 
				and asset_status = 'Active'
			group by 
				ccm.status";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_ysWise_counts($typeId=NULL)
	{
		$query ="
			select 
				coalesce(to_char(ccm.working_since,'YYYY'),'NULL') as yearsupply,
				count(ccm.*) as available
			from 
				epi_cc_coldchain_main ccm 
			LEFT JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where inn.parent_id = $typeId OR (inn.pk_id = $typeId and parent_id = 0)
				) 
				and asset_status = 'Active'
			group by 
				to_char(ccm.working_since,'YYYY')
			order by 
				to_char(ccm.working_since,'YYYY')";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function get_cc_hfFunAsset_counts($typeId=NULL)
	{
		$query ="
			select 
				count(Distinct ccm.facode) as available
			from 
				epi_cc_coldchain_main ccm 
			LEFT JOIN 
				epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
			LEFT JOIN 
				epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
			where 
				ccm.warehouse_type_id = 6 and
				ccm.facode is NOT NULL and
				ccm.ccm_sub_asset_type_id IN (
					select inn.pk_id as ids from epi_cc_asset_types inn where inn.parent_id = $typeId OR (inn.pk_id = $typeId and parent_id = 0)
				) 
				and asset_status = 'Active'
			";
		$query = $this->db->query($query);
		return $query->row()->available;
	}



	public function get_items_stock_out_data($fmonth,$items,$storecode='3')
	{
		$parts = explode("-",$fmonth);
		if(isset($parts[0]) && isset($parts[1])){
			$curryear = $year = $parts[0];
			$distwhere = '';
			$distcode=$this->session->District;
			if($distcode){
				$distwhere .= " and distcode = '$distcode'";
			}
			if($storecode){
				$mastercolumnname = $this->getMasterColumnName($storecode);
				$distwhere .= " and $mastercolumnname = '$storecode'";
			}
			$duemonthnum = 'duem'.ltrim($parts[1], '0');
			$submonthnum = 'subm'.ltrim($parts[1], '0');
			$queryduesub ="SELECT sum($duemonthnum) as due,sum($submonthnum) as sub FROM consumptioncompliance where year = '".$year."' $distwhere group by year";
			$queryobj = $this->db->query($queryduesub);
			$result = $queryobj->row();
			$vaccitems = implode("','",$items);
			$query ="
			select 
				epi_items.pk_id as id,
				epi_items.description as name,
				'".$result->due."' as due,
				count(facode) as submitted,
				sum(case when balance = 0 then 1 else 0 end) as stockout, 
				sum( case when (balance>0 and balance<required) then 1 else 0 end) as lessbuffer,
				sum( case when balance>required then 1 else 0 end) as greaterbuffer 
				from epi_items
				FULL JOIN (
					select 
						facode,
						sizes.item_id,
						sum(closing_doses) as balance,
						(select 
							case when sizes.item_id IN (2,8,9,20) 
								then getmonthlynewborn_targetpopulationpop(facode,'".$curryear."')::double precision*multiplier*wastage_rate_allowed*0.5
							when sizes.item_id IN (15) 
								then (
									(getmonthlynewborn_targetpopulationpop(facode,'".$curryear."')::double precision*1*wastage_rate_allowed*0.5)
									+
									(getmonthly_survivinginfantspop(facode,'facility','".$curryear."')::double precision*(multiplier-1)*wastage_rate_allowed*0.5)
								)
							when sizes.item_id IN (3,4,5,7,17,19,21,22,23,24,26) 
								then getmonthly_survivinginfantspop(facode,'facility','".$curryear."')::double precision*multiplier*wastage_rate_allowed*0.5
							when sizes.item_id IN (6) 
								then getmonthly_plwomen_targetpop(facode,'".$curryear."')::double precision*multiplier*wastage_rate_allowed*0.5 
							else 0 end
						) as required 
					from epi_consumption_detail detail 
					join epi_consumption_master master on master.pk_id = detail.main_id 
					join epi_item_pack_sizes sizes on sizes.pk_id = detail.item_id
					where fmonth = '$fmonth' 
					group by facode,sizes.item_id,sizes.multiplier,sizes.wastage_rate_allowed order by facode,item_id
				) as subqry on epi_items.pk_id = subqry.item_id
				join epi_item_pack_sizes on epi_item_pack_sizes.item_id = epi_items.pk_id
				where epi_item_pack_sizes.cr_table_row_numb is not NULL
				and epi_items.pk_id IN ('".$vaccitems."') 
				group by epi_items.pk_id,epi_items.description
				order by epi_items.item_category_id,epi_items.pk_id asc";
			$query = $this->db->query($query);
			return $query->result_array();
		}
		return array();
		//cr_table_row_numb blunder should be removed from above table
	}
	public function get_str_stock_out_data_new($fmonth,$itemCategory)
	{
		$parts = explode("-",$fmonth);
		if(isset($parts[0]) && isset($parts[1])){
			$year = $parts[0];
			$distwhere = '';
			$distcode=$this->session->District;
			if($distcode){
				$distwhere = " and distcode = '$distcode'";
			}
			$duemonthnum = 'duem'.ltrim($parts[1], '0');
			$submonthnum = 'subm'.ltrim($parts[1], '0');
			$queryduesub ="SELECT sum($duemonthnum) as due,sum($submonthnum) as sub FROM consumptioncompliance where year = '".$year."' $distwhere group by year";
			$queryobj = $this->db->query($queryduesub);
			$result = $queryobj->row();
			$query ="
			select 
			epi_items.pk_id as id,
			epi_items.description as name,
			'".$result->due."' as due,
			'".$result->sub."' as submitted,
			array_agg('epi_consumption_detail.item_id='||epi_item_pack_sizes.pk_id) as agg_items_id,
			(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where item_id in (
						select pk_id from epi_item_pack_sizes where item_id = epi_items.pk_id
					)
					and fmonth = '$fmonth' 
					$distwhere 
					group by fmonth,main_id having sum(closing_doses) = 0
				) as innerq
			) as stockout 
			from epi_items 
			join epi_item_pack_sizes on item_id = epi_items.pk_id
            where epi_item_pack_sizes.cr_table_row_numb is not NULL 
			and epi_items.item_category_id = $itemCategory 
			group by epi_items.pk_id 
			order by epi_items.pk_id asc";
			$query = $this->db->query($query);
			return $query->result_array();
		}
		return array();
		//<1
		//cr_table_row_numb blunder should be removed from above table
	}
	//Stock Out for Vlmis Data for Punjb and SIndh as well 
	public function get_vacc_stock_out_data($fmonth,$itemId,$storecode)
	{
		$parts = explode("-",$fmonth);
		if(isset($parts[0]) && isset($parts[1])){
			$query ="select pk_id  from epi_item_pack_sizes where cr_table_row_numb is not NULL and epi_item_pack_sizes.item_id = $itemId";
			$itemsidarr = $this->db->query($query)->result_array();
			//print_r($itemsidarr);
			$where='epi_consumption_detail.item_id  IN (';
			foreach($itemsidarr as $key=>$value)
			{
				$where.= $value['pk_id'].",";
				
			}
			$where=rtrim($where,',');
			$where.=")";
			$year = $parts[0];
			$duemonthnum = 'duem'.ltrim($parts[1], '0');
			$submonthnum = 'subm'.ltrim($parts[1], '0');
			$queryduesub ="SELECT sum($duemonthnum) as due,sum($submonthnum) as sub FROM consumptioncompliance where year = '".$year."' and procode='$storecode' group by year";
			$queryobj = $this->db->query($queryduesub);
			$result = $queryobj->row();
			$query ="
			select 
			$itemId as id,
			item_name as name,
			'".$result->due."' as due,
			'".$result->sub."' as submitted,			
			(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id where $where and fmonth = '$fmonth' and procode='$storecode' group by procode,fmonth,main_id having sum(closing_doses) < 1
				) as innerq
			) as stockout 
			from epi_item_pack_sizes 
			where cr_table_row_numb is not NULL and pk_id = $itemId";
			$query = $this->db->query($query);
			return $query->result_array();
			//print_r($whrr);exit;
		}
		return array();
	}
	public function get_comsumption_data($data)
	{
		$monthfrom=$data['monthfrom'];
		$monthto=$data['monthto'];
		$procode=$data['procode'];
		$this->db->select("epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,
					round(coalesce(sum(epi_consumption_detail.opening_doses),0)) as opening,
					round(coalesce(sum(epi_consumption_detail.received_doses),0)) as received, 
					round(sum(coalesce(epi_consumption_detail.used_vials,0))) as used, 
					round(sum(coalesce(epi_consumption_detail.unused_vials,0))) as unused,
					round(sum(coalesce(epi_consumption_detail.closing_vials,0))) as closing ");
			$this->db->from('epi_consumption_master');
			$this->db->join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this->db->join("epi_item_pack_sizes ips","epi_consumption_detail.item_id = ips.pk_id");
			$this->db->where('fmonth >= ',$monthfrom);
			$this->db->where('fmonth <= ',$monthto);
			$this->db->where('procode',$procode);
			$this->db->where('ips.item_category_id <> 4');
			$this->db->where('ips.activity_type_id=1');
			$this->db->group_by(' epi_consumption_detail.item_id,ips.item_name,ips.number_of_doses,ips.list_rank');
			$this->db->order_by('ips.list_rank');
			return $this -> db -> get() -> result_array();
	}
	public function get_technicians_data($year)
	{
		$query = "select tot_technician,(SELECT round(((sum(duem1+duem2+duem3+duem4+duem5+duem6+duem7+duem8+duem9+duem10+duem11+duem12))//12)::numeric,0) FROM consumptioncompliance ccp where year = '{$year}') as centers,pop,round(((pop::numeric)//tot_technician::numeric)::numeric,0) as technicianratio 
					from (
						select count(techniciancode) as tot_technician,
						(select sum(population) from districts_population where year='{$year}') as pop 
						from techniciandb where status='Active'
					) as tbl";
		$query = $this->db->query($query);
		return $query->row();
	}
/* 	public function get_HF_stockOut_Rate_Requisition()
	{
		$curryear='2019';
		$currmonth = date('Y-m', strtotime('-1 month', time()));
		$category=1;
		$storecode='311097';//
		
		$data['itemdata']  = $this->common->fetchall("epi_item_pack_sizes",NULL,"
						(
							case 
								when item_id IN (2,8,9,20) then getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5
								when item_id IN (15) then (
									(getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*1*wastage_rate_allowed*1.5)
									+
									(getmonthly_survivinginfantspop('".$storecode."','facility','".$curryear."')::double precision*(multiplier-1)*wastage_rate_allowed*1.5)
								)
								when item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop('".$storecode."','facility','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5
								when item_id IN (6) then getmonthly_plwomen_targetpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5 
								else 0 
							end
						) as minstockreq,pk_id as item_pack_size_id,get_product_name(pk_id) as item_name,number_of_doses
					",array("item_category_id" =>$category),'pk_id',array('by'=>'pk_id','type'=>'asc'));
					//For getting stock issue of particular facility and  curr month-1
					$this->db->SELECT("batch.quantity,item_pack_size_id");
					$this -> db -> where("to_char(master.transaction_date,'YYYY-MM')",$currmonth);
					//Issue
					$this -> db -> where("master.transaction_type_id",2);
					$this -> db -> where("master.to_warehouse_code",$storecode);
					$this -> db -> from('epi_stock_master_history master');
					$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
					$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
					$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
					$data['issue'] = $this -> db -> get() -> result_array();
					
			return $data;
	} */
	//Stock > Required Stock 
	public function get_HF_stockOut_Rate_Requisition($fmonth,$itemCategory)
	{
		$parts = explode("-",$fmonth);
		if(isset($parts[0]) && isset($parts[1])){
			$year = $parts[0];
			$distwhere = '';
			$distcode=$this->session->District;
			if($distcode){
				$distwhere = " and distcode = '$distcode'";
			}
			$duemonthnum = 'duem'.ltrim($parts[1], '0');
			$submonthnum = 'subm'.ltrim($parts[1], '0');
			$queryduesub ="SELECT sum($duemonthnum) as due,sum($submonthnum) as sub FROM consumptioncompliance where year = '".$year."' $distwhere group by year";
			$queryobj = $this->db->query($queryduesub);
			$result = $queryobj->row();
			
			$query ="
			select 
			epi_items.pk_id as id,
			epi_items.description as name,
			'".$result->due."' as due,
			'".$result->sub."' as submitted,
			array_agg('epi_consumption_detail.item_id='||epi_item_pack_sizes.pk_id) as agg_items_id,
			(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where item_id in ( select pk_id from epi_item_pack_sizes where item_id = epi_items.pk_id ) $distwhere and fmonth = '$fmonth' group by fmonth,main_id,facode  having sum(received_doses) > ( case when epi_item_pack_sizes.item_id IN (1,2,8,9,20) then getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (15) then ( (getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*1*epi_item_pack_sizes.wastage_rate_allowed*1.5) + (getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*(epi_item_pack_sizes.multiplier-1)*epi_item_pack_sizes.wastage_rate_allowed*1.5) ) when epi_item_pack_sizes.item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (6) then getmonthly_plwomen_targetpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 else 0 end ) ) as innerq ) as stockoutgreater,
					(
					select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where item_id in ( select pk_id from epi_item_pack_sizes where item_id = epi_items.pk_id ) $distwhere and fmonth = '$fmonth' group by fmonth,main_id,facode  having sum(received_doses) < ( case when epi_item_pack_sizes.item_id IN (1,2,8,9,20) then getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (15) then ( (getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*1*epi_item_pack_sizes.wastage_rate_allowed*1.5) + (getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*(epi_item_pack_sizes.multiplier-1)*epi_item_pack_sizes.wastage_rate_allowed*1.5) ) when epi_item_pack_sizes.item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (6) then getmonthly_plwomen_targetpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 else 0 end ) ) as innerq ) as stockoutless	
					from epi_items join epi_item_pack_sizes on item_id = epi_items.pk_id where epi_item_pack_sizes.cr_table_row_numb is not NULL and epi_items.item_category_id = $itemCategory group by epi_items.pk_id,epi_item_pack_sizes.item_id,epi_item_pack_sizes.multiplier,epi_item_pack_sizes.wastage_rate_allowed order by epi_items.pk_id asc";
			$query = $this->db->query($query);
			//print_r($this->db->last_query());exit;
			return $query->result_array();
			//print_r($query->result_array());
			
		}
		return array();
		//cr_table_row_numb blunder should be removed from above table
	}
}
?>