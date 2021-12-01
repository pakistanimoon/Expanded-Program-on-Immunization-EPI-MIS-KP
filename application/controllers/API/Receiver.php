<?php
/*
	@ Author: 				Raja Imran Qamer
	@ Email:  				rajaimranqamer@gmail.com
	@ Class: 				Receiver
	@ Description:  		This class will be used to receive incoming API calls, verify them, and return needed information depending upon provided parameters.
	@						It will be used for receiving agent for federal epimis System
*/
class Receiver extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		//verify incoming call here
		$this->verifyRequest();
		$this -> load -> model('API/Receiver_model','rcvr_mdl');
		$this -> load -> model('Common_model','common');
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_equipments_count
		@ Description:  		This function will return counts of all coldchain equipments available, according to parameters
	*/
	public function get_cc_equipments_count(){
		$status = ($this -> input -> post('status'))?$this -> input -> post('status'):'Active';
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_equipments_count($status);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_capacity
		@ Description:  		This function will return capacity in litres of all coldchain equipments available, according to parameters
	*/
	public function get_cc_capacity(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'coldroom';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_capacity($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_assetType_counts
		@ Description:  		This function will return type wise Available Assets count, according to parameters
	*/
	public function get_cc_assetType_counts(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'coldroom';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_assetType_counts($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_levelWise_counts
		@ Description:  		This function will return Level wise Available Assets count, according to parameters
	*/
	public function get_cc_levelWise_counts(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'coldroom';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_levelWise_counts($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_wsWise_counts
		@ Description:  		This function will return Level wise Available Assets count, according to parameters
	*/
	public function get_cc_wsWise_counts(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'coldroom';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_wsWise_counts($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_ysWise_counts
		@ Description:  		This function will return Level wise Available Assets count, according to parameters
	*/
	public function get_cc_ysWise_counts(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'coldroom';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_cc_ysWise_counts($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_cc_hfFunAsset_counts
		@ Description:  		This function will return hf rate havinf at least one item of given category exist, according to parameters
	*/
	public function get_cc_hfFunAsset_counts(){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$typeId = $this -> getCCTypeId($type);
		$data["error"] = false;
		$data["result"] = 5;//$this->rcvr_mdl->get_cc_hfFunAsset_counts($typeId);
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_str_stock_in_hand
		@ Description:  		This function will return Level wise Available Assets count, according to parameters
	*/
	public function get_str_stock_in_hand(){
		
		$storecode =$this -> input -> post('storecode'); 
        $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');

		$whcode = $storecode;
	    //true for case when  provinces have one record in vlmisstores table and we use equal condition.
		//for Punjab its two for LHR & MULTAN. for that we use IN condition for vlmisstores code
		$pro_check=1;
		if($storecode==1)
		{
			$pro_check=0;
		}
		$enddate = date("Y-m-d H:i:s");
		if($whtype==6){		
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id,'$storecode','procode') as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}else{
			/* if($storecode=='1' || $storecode=='2'){
				$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id,'$storecode','procode') as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
			}else { */
				$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','$storecode',pk_id) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
			/* } */
		}
		$data["error"] = false;
		$data["result"] = $items;//$this->rcvr_mdl->get_str_stock_in_hand();
		//send response to client.
		echo json_encode($data);exit;
	}
	public function get_stock_ledger_data()
	{
		//print_r($_POST);
		$monthfrom =$this -> input -> post('monthfrom'); 
		$monthto =$this -> input -> post('monthto'); 
		$startdate = $monthfrom.'-01 00:00:00';
		$lastday = date('t',strtotime($monthto.'-01'));
					if($monthto >= date('Y-m'))
					{
						$enddate = date('Y-m-d H:i:s');
					}
					else
					{
						$enddate = $monthto.'-'.$lastday.' 23:59:59';
					}
		$whcode =$this -> input -> post('procode'); 
		$product =$this -> input -> post('prodcut');
		$purpose =$this -> input -> post('purpose'); 
		$query_vlmis_whcode="SELECT  warehouse_code::character varying from vlmisstores where code='".$whcode."'";
		$whcodearr = $this->db->query($query_vlmis_whcode)->result_array();
		$code=$whcodearr[0]['warehouse_code'];
		//print_r($whcodearr[0]['warehouse_code']);exit;	
		//$code=$whcodearrp[0]['warehouse_code'];
		$querytext="select it.item_name, b.quantity, it.number_of_doses, (b.quantity*it.number_of_doses) as t_quantity, cast(m.transaction_date as date) as transaction_date, m.transaction_number, tt.transaction_type_name, tt.nature, tt.is_adjustment, m.created_by, cast(m.created_date as date) as created_date, b.number, b.expiry_date,get_vlmisstore_name(b.warehouse_type_id,b.code) as case  from epi_stock_master_history m join epi_transaction_types tt on tt.pk_id=m.transaction_type_id join epi_stock_batch_history b on b.batch_master_id=m.master_id join epi_item_pack_sizes it on it.pk_id=b.item_pack_size_id  where (from_warehouse_code='$code'  or to_warehouse_code='$code') and m.transaction_date >= '".$startdate."' and m.transaction_date <= '".$enddate."' and it.pk_id=$product  order by m.transaction_date asc";//m.created_date
		$data["result"] = $this->db->query($querytext)->result_array();
		//echo $this->db->last_query(); ; exit;
		echo json_encode($data);exit;
	}
	/*For drilldown to district wise */
		public function get_stock_indicator_data_drilldown()
	{
		$monthfrom =$this -> input -> post('monthfrom'); 
		$monthto =$this -> input -> post('monthto'); 
		$indicator =$this -> input -> post('indicator'); 
		$column =$this -> input -> post('column'); 
		$closecolumn="";
		if($column!=null)
			$closecolumn=',sum(coalesce(closing_doses,0)) as "Closing Doses"';
		$startdate = $monthfrom.'-01 00:00:00';
		$lastday = date('t',strtotime($monthto.'-01'));
					if($monthto >= date('Y-m'))
					{
						$enddate = date('Y-m-d H:i:s');
					}
					else
					{
						$enddate = $monthto.'-'.$lastday.' 23:59:59';
					}
		$procode =$this -> input -> post('procode'); 
		$vacc_ind =$this -> input -> post('product');
		$vacc_ind=explode(",",$vacc_ind);
		if(isset($indicator) && $vacc_ind)
		{
			$indid = $indicator;
			$this -> db -> select("
				ind_name,
				numenator,
				denominator,
				result_text,
				mt,
				(select string_agg(formula_column||' as \"'||column_name||'\"',',') from indicator_column where indmain = $indid group by indmain) as allcolumns"
			);
			$this -> db -> where('indmain',$indid);
			$indicatorData = $this -> db -> get ('indicator_main') -> row();
			$name = $indicatorData->ind_name;
			$numenator = $indicatorData->numenator;
			$denominator = $indicatorData->denominator;
			$mt = $indicatorData->mt;
			$result_text = $indicatorData->result_text;
			//if(is_array($vacc_ind) && count($vacc_ind)>1){
				if($vacc_ind[0]=='all_vacc'){
				$allcolumns = '';
				$result_text = 'value';
			}else{
				$allcolumns = $indicatorData->allcolumns;
			}
			//check if district login or district selected then show facility level
			$usercolumns = "distcode as code,districtname(distcode) as name";
			$group = "distcode";
			$moonwc = array();
			/* if(isset($distcode)){
				$usercolumns = "facode as code,facilityname(facode) as name";
				$group = "facode";
				$moonwc["distcode"] = $distcode;
			} */
            /* if($tcode){
				$moonwc["tcode"] = $tcode;
			}
			if($uncode){
				$moonwc["uncode"] = $uncode;
			}
			if($facode){
				$moonwc["facode"] = $facode;
			} */
			$this -> db -> select($usercolumns.',item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this -> db -> where($moonwc);
			if($vacc_ind[0]!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");
			$this -> db -> group_by($group.",item_id");
			$this -> db -> order_by($group.",item_id");
			$resultData = $this -> db -> get () -> result_array();
			/* Total Query */
			$this -> db -> select('procode as code,provincename(procode) as name,item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"'.$closecolumn.'');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			//$this -> db -> where($moonwc);
			//echo $vacc_ind;exit;
			if($vacc_ind[0]!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			$this -> db -> where("procode",$procode);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");  
			$this -> db -> group_by("procode,item_id");
			$this -> db -> order_by("procode,item_id");
			$resultDataTotal = $this -> db -> get () -> result_array();
			$data['result'] =array_merge($resultData,$resultDataTotal);;
			//print_r($data);
			echo json_encode($data);exit;
		}	
	}
	//for use in thematic maps
	public function get_stock_indicator_data()
	{
		$monthfrom =$this -> input -> post('monthfrom'); 
		$monthto =$this -> input -> post('monthto'); 
		$indicator =$this -> input -> post('indicator'); 
		$column =$this -> input -> post('column'); 
		$closecolumn="";
		if($column!=null)
			$closecolumn=',sum(coalesce(closing_doses,0)) as "Closing Doses"';
		$startdate = $monthfrom.'-01 00:00:00';
		$lastday = date('t',strtotime($monthto.'-01'));
					if($monthto >= date('Y-m'))
					{
						$enddate = date('Y-m-d H:i:s');
					}
					else
					{
						$enddate = $monthto.'-'.$lastday.' 23:59:59';
					}
		$procode =$this -> input -> post('procode'); 
		$vacc_ind =$this -> input -> post('product');
		$vacc_ind=explode(",",$vacc_ind);
		if(isset($indicator) && $vacc_ind)
		{
			$indid = $indicator;
			$this -> db -> select("
				ind_name,
				numenator,
				denominator,
				result_text,
				mt,
				(select string_agg(formula_column||' as \"'||column_name||'\"',',') from indicator_column where indmain = $indid group by indmain) as allcolumns"
			);
			$this -> db -> where('indmain',$indid);
			$indicatorData = $this -> db -> get ('indicator_main') -> row();
			$name = $indicatorData->ind_name;
			$numenator = $indicatorData->numenator;
			$denominator = $indicatorData->denominator;
			$mt = $indicatorData->mt;
			$result_text = $indicatorData->result_text;
			if(is_array($vacc_ind) && count($vacc_ind)>1){
				$allcolumns = '';
				$result_text = 'value';
			}else{
				$allcolumns = $indicatorData->allcolumns;
			}
			//check if district login or district selected then show facility level
			$usercolumns = "distcode as code,districtname(distcode) as name";
			$group = "distcode";
			$moonwc = array();
			/* if(isset($distcode)){
				$usercolumns = "facode as code,facilityname(facode) as name";
				$group = "facode";
				$moonwc["distcode"] = $distcode;
			} */
            /* if($tcode){
				$moonwc["tcode"] = $tcode;
			}
			if($uncode){
				$moonwc["uncode"] = $uncode;
			}
			if($facode){
				$moonwc["facode"] = $facode;
			} */
			$this -> db -> select($usercolumns.',item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this -> db -> where($moonwc);
			if($vacc_ind[0]!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");
			$this -> db -> group_by($group.",item_id");
			$this -> db -> order_by($group.",item_id");
			$resultData = $this -> db -> get () -> result_array();
			/* Total Query */
			$this -> db -> select('procode as code,provincename(procode) as name,item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"'.$closecolumn.'');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			//$this -> db -> where($moonwc);
			//echo $vacc_ind;exit;
			if($vacc_ind[0]!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			$this -> db -> where("procode",$procode);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");  
			$this -> db -> group_by("procode,item_id");
			$this -> db -> order_by("procode,item_id");
			$resultDataTotal = $this -> db -> get () -> result_array();
			$data['result'] =array_merge($resultData,$resultDataTotal);;
			//print_r($data);
			echo json_encode($data);exit;
		}	
	}
	/*for provinces wise in federal report  */
	public function get_stock_indicator_data_NEW()
	{
		$monthfrom =$this -> input -> post('monthfrom'); 
		$monthto =$this -> input -> post('monthto'); 
		$indicator =$this -> input -> post('indicator'); 
		$column =$this -> input -> post('column'); 
		$closecolumn="";
		if($column!=null)
			$closecolumn=',sum(coalesce(closing_doses,0)) as "Closing Doses"';
		$startdate = $monthfrom.'-01 00:00:00';
		$lastday = date('t',strtotime($monthto.'-01'));
					if($monthto >= date('Y-m'))
					{
						$enddate = date('Y-m-d H:i:s');
					}
					else
					{
						$enddate = $monthto.'-'.$lastday.' 23:59:59';
					}
		$procode =$this -> input -> post('procode'); 
		$vacc_ind =$this -> input -> post('product');
		//$vacc_ind=explode(",",$vacc_ind);
		if(isset($indicator) && $vacc_ind)
		{
			$indid = $indicator;
			$this -> db -> select("
				ind_name,
				numenator,
				denominator,
				result_text,
				mt,
				(select string_agg(formula_column||' as \"'||column_name||'\"',',') from indicator_column where indmain = $indid group by indmain) as allcolumns"
			);
			$this -> db -> where('indmain',$indid);
			$indicatorData = $this -> db -> get ('indicator_main') -> row();
			$name = $indicatorData->ind_name;
			$numenator = $indicatorData->numenator;
			$denominator = $indicatorData->denominator;
			$mt = $indicatorData->mt;
			$result_text = $indicatorData->result_text;
			//if(is_array($vacc_ind) && count($vacc_ind)>1){
			if($vacc_ind=='all_vacc'){
				$allcolumns = '';
				$result_text = 'value';
			}else{
				$allcolumns = $indicatorData->allcolumns;
			}
			//check if district login or district selected then show facility level
			$usercolumns = "distcode as code,districtname(distcode) as name";
			$group = "distcode";
			$moonwc = array();
			/* if(isset($distcode)){
				$usercolumns = "facode as code,facilityname(facode) as name";
				$group = "facode";
				$moonwc["distcode"] = $distcode;
			} */
            /* if($tcode){
				$moonwc["tcode"] = $tcode;
			}
			if($uncode){
				$moonwc["uncode"] = $uncode;
			}
			if($facode){
				$moonwc["facode"] = $facode;
			} */
			$this -> db -> select($usercolumns.',item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			$this -> db -> where($moonwc);
			//vacc_ind
			if($vacc_ind==81)  //other regions 
				$vacc_ind=90;//for KP item id 
			if($vacc_ind==80)  //other regions 
				$vacc_ind=89;//for KP item id 
			if($vacc_ind!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			$this -> db -> where("procode",$procode);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");
			$this -> db -> group_by($group.",item_id");
			$this -> db -> order_by($group.",item_id");
			$resultData = $this -> db -> get () -> result_array();
			/* Total Query */
			$this -> db -> select('procode as code,provincename(procode) as name,item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"'.$closecolumn.'');
			$this -> db -> from("epi_consumption_master");
			$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
			if($vacc_ind!='all_vacc')
			$this -> db -> where_in("item_id",$vacc_ind);
			$this -> db -> where("procode",$procode);
			where_between('fmonth', "'".$monthfrom."'", "'".$monthto."'");  
			$this -> db -> group_by("procode,item_id");
			$this -> db -> order_by("item_id");
			$resultDataTotal = $this -> db -> get () -> result_array();
			//print_r($resultDataTotal);exit;
			$data['result'] =array_merge($resultData,$resultDataTotal);;
			//only send total for provinces 
			if($vacc_ind=='all_vacc')
			{
			$val=array_column($resultDataTotal,'value');
			$keys=array_column($resultDataTotal,'item_id');
			$res['result']=array_combine( $keys, $val);
			
			}
			else
			$res['result']=$resultDataTotal;;
			//print_r($res);exit;
			//print_r($res['result']);exit;
			
			echo json_encode($res);exit;
		}	
	}
	//for total balance
	public function get_str_stock_in_hand_close(){
		
		$storecode =$this -> input -> post('storecode'); 
        $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');

       //$whcode = $storecode;
	    //true for case when  provinces have one record in vlmisstores table and we use equal condition.
		//for Punjab its two for LHR & MULTAN. for that we use IN condition for vlmisstores code
		$pro_check=1;
		
		if($storecode==1)
		{
			$pro_check=0;
		}
		$enddate = date("Y-m-d H:i:s");
		if($whtype==6){
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}else{
			
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','$storecode',pk_id,$pro_check::boolean) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}	
		//
		$data["error"] = false;
		$data["result"] = $items;//$this->rcvr_mdl->get_str_stock_in_hand();
		//print_r($this->db->last_query());
		//print_r($data);exit;
		//send response to client.
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_str_stock_out_data
		@ Description:  		This function will return Level wise Stock out facilities count, according to parameters
	*/
	public function get_str_stock_out_data(){
        $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		//$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,(SELECT count(*) FROM form_b_cr where fmonth = '".$reportingmonth."') as submitted,get_pro_level_all_fac_stock_out(cr_table_row_numb,'".$reportingmonth."') as stockout",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		//$items = $this->rcvr_mdl->get_str_stock_out_data($reportingmonth,$itemCategory);
		$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth,$itemCategory);
		$data["error"] = false;
		$data["result"] = $items;
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				get_vacc_stock_out_data
		@ Description:  		This function will return province wise Stock out facilities count for one vaccine, according to parameters
	*/
	public function get_vacc_stock_out_data(){
		//print_r('ss');exit;
        $selecteditem	= ($this -> input -> post('itemid'))?$this -> input -> post('itemid'):'5';//default 2 for BCG
        $reportingmonth = ($this -> input -> post('fmonth'))?$this -> input -> post('fmonth'):date('Y-m', strtotime("first day of previous months", time()));//default 2 for BCG
		 $storecode	= ($this -> input -> post('storecode'))?$this -> input -> post('storecode'):'1';
		$items = $this->rcvr_mdl->get_vacc_stock_out_data($reportingmonth,$selecteditem,$storecode);		
		//$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth,$selecteditem);
		$data["error"] = false;
		$data["result"] = $items;
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				verifyRequest
		@ Description:  		This function will be used as validator of incoming requests, just update it for validation purposes.
	*/
	public function verifyRequest(){
		$clientcode = $this -> input -> post('hackerinfo');
		$code = $this -> input -> post('code');
		$servercode = md5('fedEp1m1$'.date("Y-m-d").'to'.$code.'regEp1m1$');
		if($servercode == $clientcode)
		{
			//do nothing, call is verified
		}else{
			$data["error"] = "UnAuthorised Access, Please check your authentication call.";
			//send response to client.
			echo json_encode($data);exit;
		}
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				getCCTypeId
		@ Description:  		This function will be used to return id of cold chin asset type, currently supporting only two.
	*/
	public function getCCTypeId($type){
		switch($type){
			case "refrigrator":
				return "1";
				break;
			case "coldroom":
				return "21";
				break;
			case "voltageregulator":
				return "23";
				break;
			case "generator":
				return "24";
				break;
			case "transport":
				return "25";
				break;
			case "vaccinecarrier":
				return "26";
				break;
			case "icepack":
				return "27";
				break;
			case "coldbox":
				return "33";
				break;
			default:
				return "1";
				break;
		}
	}
	/*
		@ Author: 				Raja Imran Qamer
		@ Email:  				rajaimranqamer@gmail.com
		@ Class: 				getCCTypeId
		@ Description:  		This function will be used to return id of cold chin asset type, currently supporting only two.
	*/
	public function getItemCategoryId($type){
		switch($type){
			case "vaccines":
				return "1";
				break;
			case "diluents":
				return "3";
				break;
			case "nonvaccines":
				return "2";
				break;
			default:
				return "1";
				break;
		}
	}
	public function get_comsumption_data()
	{
		$data['monthfrom'] =$this -> input -> post('monthfrom'); 
		$data['monthto'] =$this -> input -> post('monthto'); 
		$data['procode'] =$this -> input -> post('procode'); 
		$data["result"] = $this->rcvr_mdl->get_comsumption_data($data);
		echo json_encode($data);exit;
	}
	/*
		@ Author: 				zoahib
		@ Class: 				getCCTypeId
		@ Description:  		This function will be used to return Active Technician count and province population
	*/
	public function get_technicians_data(){
		$year = ($this -> input -> post('year'))?$this -> input -> post('year'):'2018';
		$data["error"] = false;
		$data["result"] = $this->rcvr_mdl->get_technicians_data($year);
		//send response to client.
		echo json_encode($data);exit;
	}
	//plz don't remove following code
	//commented old code, it was used to fetch current balance from inventory
	/*
	public function get_str_stock_in_hand(){
		
		$storecode =$this -> input -> post('storecode'); 
        $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');

       //$whcode = $storecode;
	    //true for case when  provinces have one record in vlmisstores table and we use equal condition.
		//for Punjab its two for LHR & MULTAN. for that we use IN condition for vlmisstores code
		$pro_check=1;
		if($storecode==1)
			{
				$pro_check=0;
			}
			//var_dump($pro_check);exit;
		$enddate = date("Y-m-d H:i:s");
		if($whtype==6){
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_pro_level_all_fac_closing_bal(pk_id) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}else{
			
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','$storecode',pk_id,$pro_check::boolean) as stock",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}	
		//
		$data["error"] = false;
		$data["result"] = $items;//$this->rcvr_mdl->get_str_stock_in_hand();
		//send response to client.
		echo json_encode($data);exit;
	}
	*/
}
?>