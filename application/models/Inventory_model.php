<?php
class Inventory_model extends CI_Model {
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_priority_details
	@ Description:   Returns Manufacturer | Batch | Quantity | Priority from epi_stock_batch depending upon product id posted and user loggedin, sort by priority
	*/
	public function get_invn_priority_details($productid,$withzeroquantity=false,$transdate=false,$issue_stock=false){
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
        $this->db->select("btch.pk_id as id,btch.batch_master_id as masterid,
		trimandappend(stackholdername(btch.stakeholder_id),10,'...') || ' | ' || btch. number || ' | ' || btch.quantity || ' | ' || getpriority(btch.expiry_date,dtl.vvm_stage) as name,
		btch.expiry_date as expirydate,(case when btch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(btch.non_ccm_id) end) || ' | ' || coalesce(vvm_stages.name,'') as locinfo,get_stackholder_activity_name(mstr.stakeholder_activity_id) as activity");
        $this->db->from("epi_stock_batch btch");
        $this->db->join("epi_stock_master mstr","mstr.pk_id = btch.batch_master_id");
        $this->db->join("epi_stock_detail dtl","dtl.stock_batch_id = btch.pk_id","left outer");//(case when (dtl.vvm_stage = '1' OR dtl.vvm_stage = '2') then 'Usable' else 'Unusable' end)
        $this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = btch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = dtl.vvm_stage","LEFT OUTER");
        $this->db->join("epi_transaction_types","epi_transaction_types.pk_id = mstr.transaction_type_id");
        $this->db->where("btch.item_pack_size_id",$productid);
        $this->db->where("btch.warehouse_type_id",$whtype);
        $this->db->where("epi_transaction_types.nature",'1');
        $this->db->where("btch.code",$whcode);
		//$this -> db -> where("dtl.vvm_stage NOT In ('3','4')");
		/* if($issue_stock){
			$this -> db -> where("btch.expiry_date >=",date('Y-m-d'));
		} */
        $this->db->where("btch.status !=",'Finished');
        $this->db->where("mstr.draft",'0');
		//to get only those batches whose quantity is greater than 0 and date is less than provided date in parameter
		if($withzeroquantity){}else{
			$this->db->where("btch.quantity >",0);
        }
		if($transdate)
		{			
			if($issue_stock)
			{
				$this -> db -> where("btch.expiry_date >",substr($transdate,0,10));
			}
			$this->db->where("mstr.transaction_date<=",$transdate);
		}
		else
		{
			if($issue_stock){
				$this -> db -> where("btch.expiry_date >",date('Y-m-d'));
			}
			$this->db->where("mstr.transaction_date<=",date('Y-m-d'));
		}
		
		//end
		$this->db->order_by("btch.pk_id","ASC");
		$result = $this->db->get()->result_array();
	    return $result; 
    }
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_related_products
	@ Description:   Returns Products(item_name) from epi_item_pack_sizes depending upon activity type id and product to check same group item
	*/
	public function get_related_products($activity,$productid){
		$this->db->select("first.pk_id as id,first.item_name as name,first.item_category_id,first.item_unit_id,itemunitname(first.item_unit_id) as unitname");
        $this->db->from("epi_item_pack_sizes first");
        $this->db->join("epi_item_pack_sizes second","second.item_id = first.item_id");
        $this->db->where("first.activity_type_id",$activity);
        $this->db->where("second.pk_id",$productid);
		$this->db->order_by("first.item_name","ASC");
		return $result = $this->db->get()->result_array();
    }
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_loc_vvm_details
	@ Description:   Returns location | vvm stage from epi_stock_batch depending upon product id posted and user loggedin
	*/
	/* public function get_invn_loc_vvm_details($productid){
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
        $this->db->select("btch.pk_id as id,(case when btch.ccm_id IS NOT NULL then ccm_id::text else noncclocationname(btch.non_ccm_id) end) || ' | ' || (case when dtl.vvm_stage = '1' OR dtl.vvm_stage = '2' then 'Usable' else 'Unusable' end) as name");
        $this->db->from("epi_stock_batch btch");
        $this->db->join("epi_stock_detail dtl","dtl.stock_batch_id = btch.pk_id");
        $this->db->where("btch.item_pack_size_id",$productid);
        $this->db->where("btch.warehouse_type_id",$whtype);
        $this->db->where("btch.code",$whcode);
        $this->db->order_by("btch.pk_id","ASC");
		return $result = $this->db->get()->result_array();
    } */
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      stockRecieve
	@ Description:   return stock receive data on base of parameters  ,Summary Report Data , Detail Report Data 
	*/
	function stockRecieve($datefrom,$dateto,$from_warehouse_type_id,$activity,$product,$search_type,$search_key,$recNo=NULL,$summaryType=NULL,$groupBy=NULL)
	{			
		$this -> db -> select('master.pk_id,batch.pk_id,detail.pk_id,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) itemname,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as Storelocation,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,master.created_date,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		$whereCondition['master.transaction_type_id'] = 1;
		//draft zero condition Stock master
		$whereCondition['master.draft'] =0;
		if(($from_warehouse_type_id) && $from_warehouse_type_id > 0){
			$data['data']['from_warehouse_type_id'] = $whereCondition['master.from_warehouse_type_id'] = $from_warehouse_type_id;
		}
		$whereCondition['master.to_warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['master.to_warehouse_code'] = $this -> session -> curr_wh_code;
		if(($activity) && $activity > 0){
			$data['data']['activity'] = $whereCondition['master.stakeholder_activity_id'] = $activity;
		}
		if(($product) && $product > 0){
			$data['data']['product'] = $whereCondition['batch.item_pack_size_id'] = $product;
		}
		if(($search_type) && $search_type != ''){
			$data['data']['search_type'] = $search_type;
			$data['data']['search_key'] = $search_key;
			if($search_type == 'receiptnumber')
				$whereCondition['master.transaction_number'] = $search_key;
			else if($search_type == 'receivereference')
				$whereCondition['master.transaction_reference'] = $search_key;
			else if($search_type == 'batchnumber')
				$whereCondition['batch.number'] = $search_key;
		}
		//IF Ref No Report :
		if($recNo){
			$whereCondition['master.transaction_number'] = $recNo;
		}
		//Summary Type Report Prod / Loc Wise
		if($summaryType)
		{
			if($summaryType=="Product")
			{
				$this -> db -> order_by('batch.item_pack_size_id','asc');
			}	//sort Loc wise 
			if ($summaryType=="Location")
			{
				$this -> db -> order_by('master.to_warehouse_type_id','asc');	
			}
		}
		//IF Detail Type Report Prod / Loc Wise
		if($groupBy)
		{
			if($groupBy=="Product")
			{
				$this -> db -> order_by('batch.item_pack_size_id','asc');
			}//sort Loc wise 
			else if ($groupBy=="Location")
			{
				$this -> db -> order_by('master.to_warehouse_type_id','asc');	
			}
			// none
			else
			{
				//no sort needed.
			}
		}
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		 $this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		
		$data['data']['search'] = $this -> db -> get() -> result_array();
		return $data;
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      stockIssue
	@ Description:   return stock issue  data on base of parameters  ,issue no report, Summary Report Data , Detail Report Data 
	*/
	function stockIssue($datefrom,$dateto,$to_warehouse_type_id,$activity,$product,$search_type,$search_key,$issueNo=NULL,$summaryType=NULL,$groupBy=NULL)
	{		
		$this -> db -> select('master.pk_id,batch.pk_id,detail.pk_id,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) itemname,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as Storelocation,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,CAST(master.created_date as DATE),master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		$whereCondition['master.transaction_type_id'] = 2;
		if(($to_warehouse_type_id) && $to_warehouse_type_id > 0)
			$data['data']['to_warehouse_type_id']=$whereCondition['master.to_warehouse_type_id'] = $to_warehouse_type_id;
		$whereCondition['master.from_warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['master.from_warehouse_code'] = $this -> session -> curr_wh_code;
		if(($activity) && $activity > 0)
			$data['data']['activity']=$whereCondition['master.stakeholder_activity_id'] = $activity;
		if(($product) && $product > 0)
			$data['data']['product']=$whereCondition['batch.item_pack_size_id'] = $product;
		if($search_type && $search_type != ''){
			$data['data']['search_type'] = $search_type;
			$data['data']['search_key'] = $search_key;
			if($search_type == 'receiptnumber')
				$whereCondition['master.transaction_number'] = $search_key;
			else if(($search_type) == 'receivereference')
				$whereCondition['master.transaction_reference'] = $search_key;
			else if($search_type == 'batchnumber')
				$whereCondition['batch.number'] = $search_key;
		}
		//IF Issue No Report :
		if($issueNo){
			$whereCondition['master.transaction_number'] = $issueNo;
		}
		//Summary Type Report Prod / Loc Wise
		if($summaryType)
		{
			if($summaryType=="Product")
			{
				$this -> db -> order_by('batch.item_pack_size_id','asc');
			}	//sort Loc wise 
			if ($summaryType=="Location")
			{
				$this -> db -> order_by('master.to_warehouse_type_id','asc');	
			}
		}
		//IF Detail Type Report Prod / Loc Wise
		if($groupBy)
		{
			if($groupBy=="Product")
			{
				$this -> db -> order_by('batch.item_pack_size_id','asc');
			}//sort Loc wise 
			else if ($groupBy=="Location")
			{
				$this -> db -> order_by('master.to_warehouse_type_id','asc');	
			}
			// none
			else
			{
				//no sort needed.
			}
		}
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$data['data']['issue'] = $this -> db -> get() -> result_array();
		//print_r($this->db->last_query());exit;
		return $data;
	}
	public function stock_adjustment($datefrom,$dateto,$expiry_date,$adjustment_type,$adjustment_number,$batch,$product)
	{
		$this -> db -> select('batch.pk_id,batch.batch_id,types.nature,batch.batch_master_id,batch.status,detail.pk_id,master.comments,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,get_product_name(batch.item_pack_size_id) itemname,adjustmentname(master.transaction_type_id) as transaction_type_id,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,detail.item_unit_id,batch.expiry_date,batch.ccm_id,batch.non_ccm_id,master.created_date,master.to_warehouse_type_id,master.to_warehouse_code');
		$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		/* Expiry Date where clause */
		if(($expiry_date) && $expiry_date != NULL)
			$data['data']['expiry'] = $whereCondition['batch.expiry_date'] = $expiry_date;
		/* Adjustment type where clause */
		if(($adjustment_type) && $adjustment_type > 0)
			$data['data']['adjustment_type'] = $whereCondition['master.transaction_type_id'] = $adjustment_type;
		/* Adjustment Number where clause */
		if(($adjustment_number) && $adjustment_number != ''){
			$data['data']['adjustment_number'] = $whereCondition['master.transaction_number'] = $adjustment_number;
		}else{
			$this -> db -> where("master.transaction_type_id NOT IN (1,2)", NULL, FALSE);
		}
		/* Batch Number where clause */
		if(($batch) && $batch != '')
			$data['data']['batch'] = $whereCondition['batch.pk_id'] = $batch;
		/* Logged In Warehouse Conditions */
		$whereCondition['master.to_warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['master.to_warehouse_code'] = $this -> session -> curr_wh_code;
		/* Selected Product Where Condition */
		if(($product) && $product > 0)
			$data['data']['product'] = $whereCondition['batch.item_pack_size_id'] = $product;
		
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$this -> db -> join('epi_transaction_types types','types.pk_id = master.transaction_type_id');
		$data['data']['adjustment'] = $this -> db -> get() -> result_array();
		
		return $data;
	}
	public function stock_transfer($datefrom,$dateto,$product)
	{
		$this -> db -> select('master.pk_id,master.master_id,master.transaction_type_id,batch.pk_id,detail.pk_id,detail.stock_batch_id,adjustmentname(master.transaction_type_id) as adjustment_type,CAST(master.transaction_date AS DATE),master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,CAST(master.created_date as DATE),master.to_warehouse_type_id,master.to_warehouse_code');
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		$this -> db -> where("master.transaction_date BETWEEN '{$datefrom}' AND '{$dateto}'", NULL, FALSE);
		$this -> db -> where("master.transaction_type_id  IN (13,14)", NULL, FALSE);
		$this->db->where("batch.warehouse_type_id",$whtype);
		$this->db->where("batch.code","$whcode");
		if(($product) && $product!=""){
			$data['data']['product']=$whereCondition['batch.item_pack_size_id'] = $product;
		$this -> db -> where($whereCondition);
		}
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$data['data']['transfer'] = $this -> db -> get() -> result_array();
		return $data;
	}
	public function batchSearch($priority=NULL,$product=NULL,$searchtype=NULL,$searchkey=NULL){
		$this -> db -> select("batch.pk_id,get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,getpriority(batch.expiry_date,detail.vvm_stage) as priority, batch.number as batch,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,batch.expiry_date,coalesce(vvm_stages.name,'') as vvmstage,batch.ccm_id,batch.non_ccm_id");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		if(($product) && $product!=""){
			$whereCondition['batch.item_pack_size_id'] = $product;
		}
		if((($searchtype) && $searchtype != '') && (isset($searchkey) && $searchkey != '')){
			if($searchtype == 'exponbefore' and (isDate($searchkey)))
				$this -> db -> where("batch.expiry_date <=", $searchkey);
			else if($searchtype == 'exponafter' and (isDate($searchkey)))
				$this -> db -> where("batch.expiry_date >=", $searchkey);
			else if($searchtype == 'batchnumber')
				$whereCondition['batch.number'] = $searchkey;
		}
		if((isset($priority) && $priority>0 && $priority<7)){
			if($priority>0 and $priority<4){
				$this -> db -> where("getpriority(batch.expiry_date,detail.vvm_stage)", 'P'.$priority);
			} else if($priority==5){
				$this -> db -> where("batch.expiry_date <=", date("Y-m-d"));
			} 
			 else if($priority==4){
				$this -> db -> where("batch.status", 'Finished');
			}
			else {
				$this -> db -> where("detail.vvm_stage NOT In ('1','2')", NULL, FALSE);
			}
		}else{
			$priority = 0;
		}
		$this -> db -> where($whereCondition);
		if($priority!=4){
			
			$this -> db -> where("batch.status != ", 'Finished');
		}		
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//echo $this->db->last_query();
		return $this -> db -> get() -> result_array();
	}
	public function batch_summary($type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,COUNT(distinct batch.number) as batch,sum(batch.quantity) as quantity,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.status!=']='Finished';
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> where("batch.quantity > 0");
		$this -> db -> from('epi_stock_master master');
		$this->db->where("tt.nature",'1');
		$this->db->where("master.to_warehouse_type_id",'2');
		$this->db->where("master.to_warehouse_code",'3');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        //$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//$this->db->group_by('batch.number');
		$this->db->order_by('batch.item_pack_size_id','asc');
		$this->db->group_by('batch.item_pack_size_id,epi_item_pack_sizes.activity_type_id');
//	echo $this->db->last_query();
		//print_r($this->db->last_query());
		return   $this -> db -> get() -> result_array();
	//echo "<pre>";	print_r($this->db->last_query());
	}
	public function product_summary_report($distcode, $purpose, $type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,COUNT(distinct batch.number) as batch,sum(batch.quantity) as quantity,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.status!=']='Finished';
		
		//$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$curr_warehoue  = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("epi_item_pack_sizes.activity_type_id  IN ({$purpose})", NULL, FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> where("batch.quantity > 0");
		$this -> db -> from('epi_stock_master master');
		$this->db->where("tt.nature",'1');
		//change according to session
		if($distcode != '0')
		{
		$this->db->where("master.to_warehouse_type_id",'4');
		$this->db->where("master.to_warehouse_code = '$distcode'");
		}
		else
		{
		$this->db->where("master.to_warehouse_type_id",'2');
		$this->db->where("master.to_warehouse_code = '$curr_warehoue'");
		}
		$this -> db -> where("batch.expiry_date >",date('Y-m-d'));
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		
		$this->db->join("epi_transaction_types tt","tt.pk_id = master.transaction_type_id");
		
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        //$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//$this->db->group_by('batch.number');
		$this->db->order_by('batch.item_pack_size_id','asc');
		$this->db->group_by('batch.item_pack_size_id,epi_item_pack_sizes.activity_type_id');
//	echo $this->db->last_query();
		//print_r($this->db->last_query());
		//echo $this->db->last_query(); exit;
		return $this -> db -> get() -> result_array();
		//echo $this->db->last_query(); exit;
	//echo "<pre>";	print_r($this->db->last_query());
	} 
	public function batch_wise_summary($type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,batch.number as batch,stackholdername(batch.stakeholder_id) as manufacturer,sum(batch.quantity) as quantity,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,batch.expiry_date as exp_date,batch.vvm_type_id as vvm_type,vvm_stages.name as vvm_name,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as placment,getpriority(batch.expiry_date,detail.vvm_stage) as priority,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose"); 
		$whereCondition['master.draft'] =0;
		//$whereCondition['batch.status!']='Finished';
		
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//$this->db->group_by('batch.number');
		$this->db->order_by('batch.item_pack_size_id','asc');
		$this->db->group_by('batch.number,epi_item_pack_sizes.activity_type_id,batch.item_pack_size_id,batch.stakeholder_id,batch.expiry_date,batch.vvm_type_id,vvm_stages.name,batch.ccm_id,batch.non_ccm_id,detail.vvm_stage');
//	echo $this->db->last_query();
		//print_r($this->db->last_query());
		return $this -> db -> get() -> result_array();
//echo "<pre>";	print_r($this->db->last_query());
	}
		public function batch_summary_report($distcode, $purpose, $type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,batch.number as batch,stackholdername(batch.stakeholder_id) as manufacturer,sum(batch.quantity) as quantity,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,batch.expiry_date as exp_date,batch.vvm_type_id as vvm_type,vvm_stages.name as vvm_name,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as placment,getpriority(batch.expiry_date,detail.vvm_stage) as priority"); 
		$whereCondition['master.draft'] =0;
		//$whereCondition['batch.status!']='Finished';
		
		//$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$curr_warehoue = $this -> session -> curr_wh_code;
		if($distcode != '0')
		{
		$this->db->where("master.to_warehouse_type_id",'4');
		$this->db->where("master.to_warehouse_code = '$distcode'");
		}
		else
		{
		$this->db->where("master.to_warehouse_type_id",'2');
		$this->db->where("master.to_warehouse_code = '$curr_warehoue'");
		}
		//$this -> db -> where($whereCondition);
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("epi_item_pack_sizes.activity_type_id  IN ({$purpose})", NULL, FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> where("batch.expiry_date >",date('Y-m-d'));
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//$this->db->group_by('batch.number');
		$this->db->order_by('batch.item_pack_size_id','asc');
		$this->db->group_by('batch.number,epi_item_pack_sizes.activity_type_id,batch.item_pack_size_id,batch.stakeholder_id,batch.expiry_date,batch.vvm_type_id,vvm_stages.name,batch.ccm_id,batch.non_ccm_id,detail.vvm_stage');
//	echo $this->db->last_query();
		//print_r($this->db->last_query());
		return $this -> db -> get() -> result_array();
//echo "<pre>";	print_r($this->db->last_query());
	}
	public function batch_nonwise_summary($type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,batch.number as batch,stackholdername(batch.stakeholder_id) as manufacturer,sum(batch.quantity) as quantity,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,batch.expiry_date as exp_date,batch.vvm_type_id as vvm_type,vvm_stages.name as vvm_name,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as placment,getpriority(batch.expiry_date,detail.vvm_stage) as priority"); 
		$whereCondition['master.draft'] =0;
		//$whereCondition['batch.status!']='Finished';
		
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		//$this->db->group_by('batch.number');
		$this->db->order_by('batch.item_pack_size_id','asc');
		$this->db->group_by('batch.number,epi_item_pack_sizes.activity_type_id,batch.item_pack_size_id,batch.stakeholder_id,batch.expiry_date,batch.vvm_type_id,vvm_stages.name,batch.ccm_id,batch.non_ccm_id,detail.vvm_stage');
//	echo $this->db->last_query();
		//print_r($this->db->last_query());
		return $this -> db -> get() -> result_array();
//echo "<pre>";	print_r($this->db->last_query());
	}
	public function batch_manufacturer() 
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses, Count(distinct batch.number) as batch,stackholdername(batch.stakeholder_id) as manufacturer,sum(batch.quantity) as quantity");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> order_by('batch.item_pack_size_id','asc');
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		$this->db->group_by('batch.stakeholder_id,batch.item_pack_size_id');
		//echo $this->db->last_query();
		return $this -> db -> get() -> result_array();
		//echo $this->db->last_query();
	}
	public function manufacturer_summary_report($distcode, $purpose, $type) 
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses, Count(distinct batch.number) as batch,stackholdername(batch.stakeholder_id) as manufacturer,sum(batch.quantity) as quantity");
		$whereCondition['master.draft'] =0;
		//$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$curr_warehoue = $this -> session -> curr_wh_code;
		//$this -> db -> where($whereCondition);
		if($distcode != '0')
		{
		$this->db->where("master.to_warehouse_type_id",'4');
		$this->db->where("master.to_warehouse_code = '$distcode'");
		}
		else
		{
		$this->db->where("master.to_warehouse_type_id",'2');
		$this->db->where("master.to_warehouse_code = '$curr_warehoue'");
		}
		$this -> db -> where("batch.status!='Finished'");
		$this -> db -> where("batch.expiry_date >",date('Y-m-d'));
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("epi_item_pack_sizes.activity_type_id  IN ({$purpose})", NULL, FALSE);
		$this -> db -> order_by('batch.item_pack_size_id','asc');
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		$this->db->group_by('batch.stakeholder_id,batch.item_pack_size_id');
		//echo $this->db->last_query();
		return $this -> db -> get() -> result_array();
		//echo $this->db->last_query();
	}
	
	public function recevie_vaccine()
	{	
	
	// this code is used for issue(data) from fedural to provience
	
		/* //$f_wharehouse_id =  $this->session->userdata("curr_wh_type");
		$f_wharehouse_code = $this->session->userdata("curr_wh_code");
		$f_wharehouse_id =  $this->session->curr_wh_type;
		$this->db->select('master.pk_id as mid,get_product_name(batch.item_pack_size_id) itemname,*');
		$this->db->from('epi_stock_master master');
		$this->db->where("master.from_warehouse_code='$f_wharehouse_code'");
		//this where used for, which issue(data) we send to provience by fedural
		$this ->db->where("master.from_warehouse_type_id='$f_wharehouse_id'");
		//this where used for, which issue(data) we send to District by provience
		//$this -> db -> where("master.from_warehouse_type_id='2'");
		//$this->db->where("master.transaction_type_id='2'");
		$this->db->where("master.transaction_type_id='2'");
		$this->db->join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		 return $this -> db -> get() -> result_array();
		// print_r($this->db->last_query());exit;
		 */


	// this code is used for issue(data) from provience to distinct

	 
		$f_wharehouse_code = $this->session->userdata("curr_wh_code");
		$f_wharehouse_id =  $this->session->curr_wh_type;
		$this->db->select('master.pk_id as mid,get_product_name(batch.item_pack_size_id) itemname,*');
		$this->db->from('epi_stock_master master');
		$this->db->where("master.to_warehouse_code='$f_wharehouse_code'");
		$this->db->where("master.to_warehouse_type_id='$f_wharehouse_id'");
		$this->db->where("master.transaction_type_id='1'");
		$this->db->join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		return  $this -> db -> get() -> result_array();
		//print_r($this->db->last_query());exit;
	// return $this -> db -> get() -> result_array();
	}
	
	public function get_issued_vouchers_list($fromwhtype,$fromwhcode,$limit,$offset,$page)
	{
		$offset = 50*$page;
		$username = $this->session->userdata("username");
		$this -> db -> select("
		master.*,count(*) OVER() AS full_count ,
		get_store_name(to_warehouse_type_id,to_warehouse_code) as store,
		get_stackholder_activity_name(stakeholder_activity_id) as activity,
		Case 
		when draft = 1 then 'In Process' 
		when draft = 0 then(
			Case when master.to_warehouse_type_id=6 then (
				case when (
					select count(*) from epi_consumption_master where facode = master.to_warehouse_code and fmonth = substring(master.transaction_date::text,0,8) and is_compiled='1'
					)>0 then 'Received'
				else 'Dispatched' End
			)
			when master.transaction_counter = viewtbl.totfinish then 'Received'
			when master.transaction_counter > viewtbl.totfinish then 'Partially Received'
			when viewtbl.totfinish = '0' then 'Dispatched'
			else 'Dispatched' End
		)
		else 'Dispatched' 
		end as voucherstat");
		//form_b_cr
		$this -> db -> where("
			(transaction_number like 'I%' OR transaction_number like 'TEMP') and 
			from_warehouse_type_id = $fromwhtype and 
			from_warehouse_code = '".$fromwhcode."' and
			created_by = '".$username."'
		");
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join("(select batch_master_id,count(*) as totfinish from epi_stock_batch where status = 'Finished' group by batch_master_id) as viewtbl","viewtbl.batch_master_id = master.pk_id","LEFT OUTER");
		//$this->db->order_by('transaction_number',"DESC");
		$this->db->order_by('master.created_date',"DESC");
		//$this->db->limit("200");
		$this->db->limit($limit,$offset);
		return $this -> db -> get() -> result_array();
	}
	public function get_issued_voucher_status($vouchernum)
	{
		$this -> db -> select("
		master.from_warehouse_type_id,
		master.from_warehouse_code,
		Case 
		when draft = 1 then 'In Process' 
		when draft = 0 then(
			Case 
			when master.to_warehouse_type_id=6 then (
				case when (
					select count(*) from epi_consumption_master where facode = master.to_warehouse_code and fmonth = substring(master.transaction_date::text,0,8) and is_compiled='1'
					)>0 then 'Received'
				else 'Dispatched' End
			)
			when master.transaction_counter = viewtbl.totfinish then 'Received'
			when master.transaction_counter > viewtbl.totfinish then 'Partially Received'
			when viewtbl.totfinish = '0' then 'Dispatched'
			else 'Dispatched' End
		)
		else 'Dispatched' 
		end as voucherstat");
		$this -> db -> where("
			pk_id = '".$vouchernum."'
		");
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join("(select batch_master_id,count(*) as totfinish from epi_stock_batch where status = 'Finished' group by batch_master_id) as viewtbl","viewtbl.batch_master_id = master.pk_id","LEFT OUTER");
		return $this -> db -> get() -> row();
	}
	public function batch_priority($type)
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,getpriority(batch.expiry_date,detail.vvm_stage) as priority, COUNT(distinct batch.number) as batch,sum(batch.quantity),get_activity_name(epi_item_pack_sizes.activity_type_id) as activity_type_id");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['batch.code'] = $this -> session -> curr_wh_code;
		$this -> db -> where($whereCondition);
		//$this -> db -> order_by('batch.expiry_date','asc');
		//$this -> db -> order_by('batch.item_pack_size_id','asc');
		$this -> db -> order_by('epi_item_pack_sizes.activity_type_id','asc');
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->group_by('getpriority(batch.expiry_date,detail.vvm_stage),batch.item_pack_size_id,epi_item_pack_sizes.activity_type_id');
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		
		//echo $this->db->last_query();
		return $this -> db -> get() -> result_array();
	}
	public function priority_summary_report($distcode, $purpose, $type) 
	{
		$this -> db -> select("get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,getpriority(batch.expiry_date,detail.vvm_stage) as priority, COUNT(distinct batch.number) as batch,sum(batch.quantity),get_activity_name(epi_item_pack_sizes.activity_type_id) as activity_type_id");
		$whereCondition['master.draft'] =0;
		//$whereCondition['batch.warehouse_type_id'] = $this -> session -> curr_wh_type;
		$curr_warehoue = $this -> session -> curr_wh_code;
		if($distcode != '0')
		{
		$this->db->where("master.to_warehouse_type_id",'4');
		$this->db->where("master.to_warehouse_code = '$distcode'");
		}
		else
		{
		$this->db->where("master.to_warehouse_type_id",'2');
		$this->db->where("master.to_warehouse_code = '$curr_warehoue'");
		}
		//$this -> db -> where($whereCondition);
		//$this -> db -> order_by('batch.expiry_date','asc');
		//$this -> db -> order_by('batch.item_pack_size_id','asc');
		$this -> db -> where("batch.expiry_date >",date('Y-m-d'));		
		$this -> db -> order_by('epi_item_pack_sizes.activity_type_id','asc');
		$this -> db -> where("epi_item_pack_sizes.item_category_id  IN ({$type})", NULL, FALSE);
		$this -> db -> where("epi_item_pack_sizes.activity_type_id  IN ({$purpose})", NULL, FALSE);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->group_by('getpriority(batch.expiry_date,detail.vvm_stage),batch.item_pack_size_id,epi_item_pack_sizes.activity_type_id');
        $this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		
		//echo $this->db->last_query();
		return $this -> db -> get() -> result_array();
	}
	public function chckfac_issue_db($uccode,$facode,$date)
	{
		$date=date($date);
		$fmonth=substr($date,0,7);
		$query="select id,facode,fmonth from epi_consumption_master where fmonth='$fmonth' and facode='$facode' and is_compiled='1'";//form_b_cr
		return $result=$this -> db ->query($query)->result_array();
	}
	public function get_batch_Adjustment_detail($batchid)
	{
		$this -> db -> select("trimandappend(stackholdername(btch.stakeholder_id), 10, '...') || ' | ' || btch. number || ' | ' || btch.quantity as name");
		$whereCondition['pk_id'] = $batchid;
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_batch  btch');
		return $this -> db -> get() -> result_array();
	}
	public function get_batch_detail($productid,$transdate,$nature)
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		if($nature==1){
			$wherecondition ="and epi_stock_batch.expiry_date > '$transdate'";
		}else{
			$wherecondition ='';
		}
		$query="SELECT epi_stock_batch.expiry_date as expirydate,epi_stock_batch.batch_master_id as masterid,get_stackholder_activity_name(epi_stock_master.stakeholder_activity_id) as activity,epi_stock_batch.pk_id as id,trimandappend(stackholdername(epi_stock_batch.stakeholder_id), 10, '...') || ' | ' || epi_stock_batch. number || ' | ' || epi_stock_batch.quantity as name,(case when epi_stock_batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(epi_stock_batch.non_ccm_id) end) || ' | ' || coalesce(vvm_stages.name,'') as locinfo FROM epi_stock_batch LEFT OUTER JOIN epi_stock_master ON epi_stock_master.pk_id= epi_stock_batch.batch_master_id
			LEFT OUTER JOIN epi_stock_detail dtl ON dtl.stock_batch_id= epi_stock_batch.pk_id
			LEFT OUTER JOIN epi_item_pack_sizes ON epi_item_pack_sizes.pk_id= epi_stock_batch.item_pack_size_id
			LEFT OUTER JOIN vvm_stages ON  vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = dtl.vvm_stage where (epi_stock_master.draft is NULL or epi_stock_master.draft='0') and (epi_stock_batch.code='$whcode' and epi_stock_batch.warehouse_type_id='$whtype' and epi_stock_batch.item_pack_size_id='$productid' and epi_stock_batch.status!='Finished' ) AND (epi_stock_master.transaction_number like 'A%' or epi_stock_master.transaction_number like 'R%' or epi_stock_master.transaction_number is null) $wherecondition";
		return $result=$this->db->query($query)->result_array();
		/* 
		$this -> db -> select("btch.pk_id as id,trimandappend(stackholdername(btch.stakeholder_id), 10, '...') || ' | ' || btch. number || ' | ' || btch.quantity as name");
		$this->db->where("btch.item_pack_size_id",$productid);
		$this->db->where("btch.warehouse_type_id",$whtype);
		$this->db->where("btch.code",$whcode);
        $this->db->where("btch.status !=",'Finished');
		$this->db->where("epi_stock_master.draft",'0');
		$this -> db -> from('epi_stock_batch  btch');
		$this->db->order_by("btch.pk_id","ASC");
		$this->db->join("epi_stock_master","epi_stock_master.pk_id = btch.batch_master_id","LEFT OUTER"); */
		/*  = $this->db->get()->result_array(); */
	}
	public function get_batch_location($batch_id)
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		$query="SELECT epi_stock_batch.pk_id as id,trimandappend(stackholdername(epi_stock_batch.stakeholder_id), 10, '...') || ' | ' || epi_stock_batch. number || ' | ' || epi_stock_batch.quantity as name ,(case when epi_stock_batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(epi_stock_batch.non_ccm_id) end) || ' | ' || coalesce(vvm_stages.name,'') as locinfo
			FROM epi_stock_batch LEFT OUTER JOIN epi_stock_master ON epi_stock_master.pk_id= epi_stock_batch.batch_master_id
			LEFT OUTER JOIN epi_stock_detail dtl ON dtl.stock_batch_id= epi_stock_batch.pk_id
			LEFT OUTER JOIN epi_item_pack_sizes ON epi_item_pack_sizes.pk_id= epi_stock_batch.item_pack_size_id
			LEFT OUTER JOIN vvm_stages ON  vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = dtl.vvm_stage
			where (epi_stock_master.draft is NULL or epi_stock_master.draft='0') and (epi_stock_batch.code='$whcode' and epi_stock_batch.warehouse_type_id='$whtype' and epi_stock_batch.item_pack_size_id='5' and epi_stock_batch.status!='Finished' and epi_stock_batch.pk_id=$batch_id)";
		return $result=$this->db->query($query)->result_array();
	}
	public function issue_To_Warehouse($reportedmonth,$product)
	{
			$this -> db -> select('master.to_warehouse_code as code,get_store_name(master.to_warehouse_type_id,master.to_warehouse_code) as warehousename,batch.number as batchname,sum(batch.quantity) as sum');
			$this -> db -> where("to_char(master.transaction_date,'YYYY-MM') ='".$reportedmonth."'");
			$whtype = $this -> session -> curr_wh_type;
			$this->db->where('master.from_warehouse_type_id',$whtype);
			//test this condition may be updated 
			//$this->db->where('master.to_warehouse_type_id','4');
			$this->db->where('batch.item_pack_size_id',$product);
			$this -> db -> from('epi_stock_master_history master');
			$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
			$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		    $this->db->group_by("master.to_warehouse_code,master.to_warehouse_type_id,batch.number,batch.quantity");
			$data= $this -> db -> get() -> result_array();
			return $data;
	}
	public function vvm_stage_status($reportedmonth,$product)
	{		$this -> db -> select('sum(batch.quantity) as sum,batch.number');
			$this -> db -> where("to_char(master.transaction_date,'YYYY-MM') ='".$reportedmonth."'");
			$whtype = $this -> session -> curr_wh_type;
			//$this->db->where('master.from_warehouse_type_id',$whtype);
			//test this condition may be updated 
			$this->db->where('detail.vvm_stage is not NULL');
			$this->db->where('batch.item_pack_size_id',$product);
			$this -> db -> from('epi_stock_master_history master');
			$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
			$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		    $this->db->group_by("batch.number");
			$data= $this -> db -> get() -> result_array();
			return $data;
		
	}
	//Non ccm id
	public function stock_in_bin($non_ccm_id)
	{
		//echo $ccm_id;
			$this -> db -> select('batch.pk_id,batch.item_pack_size_id as id,get_product_name(batch.item_pack_size_id) itemname, get_epi_item_dose_per_vials(batch.item_pack_size_id) doses, "batch"."number" as "batch", "batch"."quantity", "batch"."expiry_date"');
			$this -> db -> where("batch.non_ccm_id",$non_ccm_id);
			$whereCondition['master.draft'] =0;
			$this -> db -> where($whereCondition);
			//$this -> db -> where("vvm_stages.name is not null");
			$this -> db -> from('epi_stock_master master');
			$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
			$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
			$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
			
			//$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
			$this->db->group_by("batch.pk_id,batch.number,batch.item_pack_size_id,batch.expiry_date,batch.stakeholder_id,batch.quantity");
			$data= $this -> db -> get() -> result_array();
			//print_r($this->db->last_query());exit;
			return $data;
	}
	public function stock_in_bin_vaccine($ccm_id)
	{
		$this -> db -> select('batch.pk_id,batch.item_pack_size_id as id,get_product_name(batch.item_pack_size_id) itemname, get_epi_item_dose_per_vials(batch.item_pack_size_id) doses, "batch"."number" as "batch",sum("batch"."quantity") as quantity, "batch"."expiry_date","vvm_stages"."name"');
		$this -> db -> where("batch.ccm_id",$ccm_id);
		$this -> db -> where("batch.quantity > 0");
		$this->db->where("batch.status !=",'Finished');
		$whereCondition['master.draft'] =0;
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		$this->db->group_by("batch.number,batch.pk_id,detail.vvm_stage,vvm_stages.name,batch.item_pack_size_id,batch.expiry_date,batch.stakeholder_id,detail.quantity");
		$this->db->order_by("batch.item_pack_size_id","asc");
		$data= $this -> db -> get() -> result_array();
		return $data; 
	}
	//for highchart report group by product 
	public function stock_in_bin_vaccine_chart($ccm_id)
	{
		$code=$this->session->curr_wh_code;
		$type=$this->session->curr_wh_type;
		$this -> db -> select("batch.item_pack_size_id as id,get_product_name(batch.item_pack_size_id) itemname,get_stored_quantity_litters(main.asset_id,'".date("Y-m-d H:i:s")."','".$type."','".$code."') as stored,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,sum(batch.quantity) as quantity");
		$this -> db -> where("batch.ccm_id",$ccm_id);
		$whereCondition['master.draft'] =0;
		$this -> db -> where($whereCondition);
		$this -> db -> where("main.asset_id",$ccm_id);
		$this -> db -> where("vvm_stages.name is not null");
		$this -> db -> from('epi_cc_coldchain_main main');
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this -> db -> where("batch.quantity > 0");
		$this->db->where("batch.status !=",'Finished');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		$this->db->group_by("batch.item_pack_size_id,main.asset_id");
		$this->db->order_by("batch.item_pack_size_id","asc");
		$data= $this -> db -> get() -> result_array();
		return $data; 
	}
	public function batch_information($batch_number)
	{			
		$this -> db -> select('"batch"."number" as "batch", "vvm_stages"."name","batch"."quantity",getccmshortname(batch.ccm_id) as shortname');
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.number'] =$batch_number;
		$this -> db -> where($whereCondition);
		$this -> db -> where("vvm_stages.name is not null");
		$this -> db -> where("batch.ccm_id is not null");
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->join("vvm_stages","vvm_stages.type = epi_item_pack_sizes.vvm_stage_type and vvm_stages.value = detail.vvm_stage","LEFT OUTER");
		$data= $this -> db -> get() -> result_array();
		return $data; 
	}
	//dry store batch information
	public function drystorebatch_information($batch_number)
	{			
		$this -> db -> select('"batch"."number" as "batch","batch"."quantity",noncclocationname(batch.non_ccm_id) as shortname');
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.number'] =$batch_number;
		$this -> db -> where($whereCondition);
		$this -> db -> where("batch.non_ccm_id is not null");
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$data= $this -> db -> get() -> result_array();
		return $data; 

	}
	public function get_received_stock_list($transac_id_type)
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		$this -> db -> select('transaction_date,transaction_number,transaction_counter,created_by,created_date');
		
		$this->  db -> where('transaction_type_id',$transac_id_type);
		$this -> db -> where('to_warehouse_code',$whcode);
		$this -> db -> where('to_warehouse_type_id',$whtype);
		$this -> db -> order_by('created_date','DESC');
		$this -> db -> from('epi_stock_master_history');

		$data =$this -> db -> get() -> result_array();
		
		return $data;
	}
	public function get_received_stock_list_for_supplier($transac_id_type)
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		$this -> db -> select('transaction_date,transaction_number,transaction_counter,created_by,created_date');
		
		$this->  db -> where('transaction_type_id',$transac_id_type);
		$this -> db -> where('to_warehouse_code',$whcode);
		$this -> db -> where('to_warehouse_type_id',$whtype);
		$this -> db -> where('from_warehouse_type_id','7');
		$this -> db -> order_by('created_date','DESC');
		$this -> db -> from('epi_stock_master_history');

		$data =$this -> db -> get() -> result_array();
		
		return $data;
	}

	
}