<?php
class Placement extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> model ('Common_model',"common");
		$this -> load -> model ('Inventory_reports_model',"invnrep");
		$this -> load -> library('reportfilters');
		$this -> load -> model('Inventory_model',"invn");
		$this -> load -> model('Nonccmlocations_model','locations');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      ccm_loc_status
	@ Description:   This function will Show all CCM Locations and there status.
	*/
	public function ccm_loc_status()
	{
		$wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code
		);
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		//$data['data']['ccminfo'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		//"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d")." 23:59:59','".$this->session->curr_wh_type."','".$this->session->curr_wh_code."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$data['data']['ccminfo'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d H:i:s")."','".$this->session->curr_wh_type."','".$this->session->curr_wh_code."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		//print_r($this->db->last_query());exit;
		$template = 'template/epi_template';
		$data['fileToLoad'] = 'inventory_management/capacity/ccm_locations';
		$data['pageTitle']='Vaccine Distribution Report';
		$this -> load -> view($template,$data);
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      dry_store_status
	@ Description:   This function will Show all Dry store and there status.
	*/
	public function dry_store_status()
	{
		$area=$this->input->post('area');
		$level=$this->input->post('level');
		$data['data']=array();
		/* if($area > 0 && $level !="" )
		{
			
		} */
		$where = array(
			"warehouse_type_id" => $this->session->curr_wh_type,
			"warehouse_code" => $this->session->curr_wh_code
		);
		if($area){
			$where["store"] = $area;
		}
		if($level){
			$where["row"] = $level;
		}
		$data['data']['searchResult'] = $this->common->fetchall("epi_non_ccm_locations",NULL,NULL,$where);
		//print_r($data);exit;
		$template = 'template/epi_template';
		$data['fileToLoad'] = 'inventory_management/capacity/dry_store_status';
		$data['pageTitle']='Vaccine Distribution Report';
		$this -> load -> view($template,$data);
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      stock_in_bin
	@ Description:   This function will Show all Product Detail under specific Bin/Location.
	*/
	public function stock_in_bin()
	{
		 /* $id=$_REQUEST['id'];
		  $where = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			"code"=>$this->session->curr_wh_code,
			"non_ccm_id"=>$id,
		);
		$data['data']['bin']=$id;
		$data['data']['result']=$this->common->fetchall("epi_stock_batch",NULL,"*,get_product_name(item_pack_size_id) as itemname",$where);
		$template = 'template/epi_template';
		$data['fileToLoad'] = 'inventory_management/capacity/stock_in_bin';
		$data['pageTitle']='Vaccine Distribution Report';
		$this -> load -> view($template,$data); */
		//
		/* $wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code
		);
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		 *///non ccm_id location on base of row and rack
		 $distcode = ($this -> session -> District)?$this -> session -> District:NULL;
		$warehouseTypeId = ($this -> session -> District)?4:2;
		$data['data']['allLocations'] = $this -> locations -> getAllLocations($distcode,$warehouseTypeId);
		
		//print_r($data['data']['non_ccm_id']);exit;
		//$data['data']['ccminfo'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		//"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype",
		//$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		 $data['data']['bin']=$non_ccm_id=$_REQUEST['id'];
		 $data['data']['result']=$this->invn->stock_in_bin($non_ccm_id);
		 $template = 'template/epi_template';
		 $data['fileToLoad'] = 'inventory_management/capacity/stock_in_bin';
		 $data['pageTitle']='Vaccine Distribution Report';
		 $this -> load -> view($template,$data);
	   
		
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      stock_in_bin_vaccine
	@ Description:   This function will Show all Product Detail under specific Bin/Location.
	*/
	function stock_in_bin_vaccine()
	{
		
		 $wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code,
			
		);
		$wh_whrarr["get_asset_status(epi_cc_coldchain_main.asset_id) !="]=3;
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['data']['ccminfo'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		 $data['data']['ccm_id']=$ccm_id=$_REQUEST['ccm_id'];
		 //
		$wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code,
			"epi_cc_coldchain_main.asset_id"=>$ccm_id
		);
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['data']['ccminfograph'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d H:i:s")."','".$this->session->curr_wh_type."','".$this->session->curr_wh_code."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		//exit;
		 //
		$template = 'template/epi_template';
		$data['data']['result']=$this->invn->stock_in_bin_vaccine($ccm_id);
		//For High chart group by product data.
		$data['data']['graphresult']=$this->invn->stock_in_bin_vaccine_chart($ccm_id);
		 $template = 'template/epi_template';
		 $data['fileToLoad'] = 'inventory_management/capacity/stock_in_bin_vaccine';
		 $data['pageTitle']='Vaccine Distribution Report';
		 $this -> load -> view($template,$data);
	   
	}
		function transfer_Stock()
	{
		$batch_id=$_POST['batch_id'];
		$ccm_id=$_POST['location'];
		//ccm_id transfer from
		$transfer_from=$_POST['transfer_from'];
		$qty_add=$_POST['qtyadd'];
		$qty=$_POST['qty'];
		// Case: when all qty avialable equal to qty add then only update ccm_id in tables
		//batch and batch_history
		/*
		First:
		update batch table with batch_id and remaing qty ,
		update that branch in branch history
		2nd:
		add new batch data with qtyadd withe new ccm_id
		update batch_history, add in batch_detial and batch_history
		*/
		$whrarr=array('pk_id'=>$batch_id);
		$whrarrdetail=array('stock_batch_id'=>$batch_id);
		$data['data']['batch'] = (array)$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,$whrarr);
		$data['data']['detail'] = (array)$batchdata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,$whrarrdetail);
		//echo '<pre>';print_r($data);echo '</pre>';exit;
		/**** CHeck IF Qty add and Qty Available are Equal ***/
		if($qty==$qty_add)
		{
		$data['batch']['update']=array('quantity'=>$qty_add,'ccm_id'=>$ccm_id);
		$data['detail']['update']=array('quantity'=>$qty_add);
		$this->common->update_record("epi_stock_batch",$data['batch']["update"],$whrarr);
		/**Batch History**/
		$data['batch_history']=array('quantity'=>$qty_add,'ccm_id'=>$ccm_id);
		$whrarrhistory=array('batch_id'=>$batch_id);
		$this->common->update_record("epi_stock_batch_history",$data['batch_history'],$whrarrhistory);
		$this -> session -> set_flashdata('message', 'Stock Transferred Successfully . !');
		redirect(base_url()."stock-in-bin-vaccine?ccm_id=$transfer_from");
		
		}
		else
		{
			
			/* Update Batch */
		$data['batch']['update']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_batch",$data['batch']["update"],$whrarr);
			/* Add Batch */
		$data['data']['batch']['ccm_id']=$ccm_id;
		$data['data']['batch']['quantity']=$qty_add;
		unset($data['data']['batch']['pk_id']);
		//print_r($data['data']["batch"]);
		$new_batch_id=$this->common->insert_record("epi_stock_batch",$data['data']["batch"]);
			/* Detail Update */
		//$whrarr=array('stock_batch_id'=>$batch_id);
		$data['detail']['update']=array('quantity'=>$qty-$qty_add);	
		$this->common->update_record("epi_stock_detail",$data['detail']["update"],$whrarrdetail);
			/* Detail Add */	
		$data['data']['detail']['quantity']=$qty_add;
		$data['data']['detail']['stock_batch_id']=$new_batch_id;
		unset($data['data']['detail']['pk_id']);	
		$new_detail_id=$this->common->insert_record("epi_stock_detail",$data['data']["detail"]);
		/* Batch History */
		$whrarrhistory=array('batch_id'=>$batch_id);
		//update only Qty
		$data['batch_history']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_batch_history",$data['batch_history'],$whrarrhistory);
		//add batch history
		$data['data']['batch']['batch_id']=$new_batch_id;
		$idbatch=$this->common->insert_record("epi_stock_batch_history",$data['data']['batch']);
		/* Detail History */
		$whrarrdetailhistory=array('stock_batch_id'=>$batch_id);
		//update only Qty
		$data['detail_history']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_detail_history",$data['detail_history'],$whrarrdetailhistory);
		//add detail history
		$data['data']['detail']['detail_id']=$new_detail_id;
		$iddetail=$this->common->insert_record("epi_stock_detail_history",$data['data']['detail']);
		$this -> session -> set_flashdata('message', 'Stock Transferred Successfully . !');
		redirect(base_url()."stock-in-bin-vaccine?ccm_id=$transfer_from"); 
		
		
		}
	}
	function batch_information()
	{
		$batch_number=$_REQUEST['batch_number'];
		$data['data']['result']=$this->invn->batch_information($batch_number);
		echo json_encode($data);
	}
	function drystorebatch_information()
	{
		$batch_number=$_REQUEST['batch_number'];
		$data['data']['result']=$this->invn->drystorebatch_information($batch_number);
		echo json_encode($data);
	}
	function dry_store_transfer_Stock()
	{
		$batch_id=$_POST['batch_id'];
		$non_ccm_id=$_POST['location'];
		//ccm_id transfer from
		$transfer_from=$_POST['transfer_from'];
		$qty_add=$_POST['qtyadd'];
		$qty=$_POST['qty'];
		$whrarr=array('pk_id'=>$batch_id);
		$whrarrdetail=array('stock_batch_id'=>$batch_id);
		$data['data']['batch'] = (array)$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,$whrarr);
		$data['data']['detail'] = (array)$batchdata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,$whrarrdetail);
		//echo '<pre>';print_r($data);echo '</pre>';exit;
		if($qty==$qty_add)
		{
		$data['batch']['update']=array('quantity'=>$qty_add,'non_ccm_id'=>$non_ccm_id);
		$data['detail']['update']=array('quantity'=>$qty_add);
		$this->common->update_record("epi_stock_batch",$data['batch']["update"],$whrarr);
		//Batch History
		$data['batch_history']=array('quantity'=>$qty_add,'non_ccm_id'=>$non_ccm_id);
		$whrarrhistory=array('batch_id'=>$batch_id);
		$this->common->update_record("epi_stock_batch_history",$data['batch_history'],$whrarrhistory);
		$this -> session -> set_flashdata('message', 'Stock Transferred Successfully . !');
		redirect(base_url()."stock-in-bin?id=$transfer_from"); 
		
		}
		else
		{
			/* Update Batch */
		$data['batch']['update']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_batch",$data['batch']["update"],$whrarr);
			/* Add Batch */
		$data['data']['batch']['non_ccm_id']=$non_ccm_id;
		$data['data']['batch']['quantity']=$qty_add;
		unset($data['data']['batch']['pk_id']);
		//print_r($data['data']["batch"]);
		$new_batch_id=$this->common->insert_record("epi_stock_batch",$data['data']["batch"]);
		/* Detail Update */
		//$whrarr=array('stock_batch_id'=>$batch_id);
		$data['detail']['update']=array('quantity'=>$qty-$qty_add);	
		$this->common->update_record("epi_stock_detail",$data['detail']["update"],$whrarrdetail);
			/* Detail Add */	
		$data['data']['detail']['quantity']=$qty_add;
		$data['data']['detail']['stock_batch_id']=$new_batch_id;
		unset($data['data']['detail']['pk_id']);	
		$new_detail_id=$this->common->insert_record("epi_stock_detail",$data['data']["detail"]);
		/* Batch History */
		$whrarrhistory=array('batch_id'=>$batch_id);
		//update only Qty
		$data['batch_history']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_batch_history",$data['batch_history'],$whrarrhistory);
		//add batch history
		$data['data']['batch']['batch_id']=$new_batch_id;
		$idbatch=$this->common->insert_record("epi_stock_batch_history",$data['data']['batch']);
		/* Detail History */
		$whrarrdetailhistory=array('stock_batch_id'=>$batch_id);
		//update only Qty
		$data['detail_history']=array('quantity'=>$qty-$qty_add);
		$this->common->update_record("epi_stock_detail_history",$data['detail_history'],$whrarrdetailhistory);
		//add detail history
		$data['data']['detail']['detail_id']=$new_detail_id;
		$iddetail=$this->common->insert_record("epi_stock_detail_history",$data['data']['detail']);
		$this -> session -> set_flashdata('message', 'Stock Transferred Successfully . !');
		redirect(base_url()."stock-in-bin?id=$transfer_from"); 
		}
		
	}
}
?>