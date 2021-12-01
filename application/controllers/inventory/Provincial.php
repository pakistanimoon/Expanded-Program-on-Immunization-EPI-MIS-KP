<?php
class Provincial extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Inventory_model',"invn");
		$this -> load -> model ('Common_model',"common");
		$this -> load -> helper('my_functions_helper');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_receive_from_supplier
	@ Description:   This function will open form to receive stock from supplier and make transactions accordingly
	*/
	public function stock_receive_from_supplier()
	{
		$subTitle ="(Vaccine Managment) Stock Receive from Supplier";
		$data['subtitle']=$subTitle;
		$vvms = $this->common->fetchall("epi_vvm_types",NULL,"pk_id as id,vvm_type_name as name",array("status"=>1),NULL,array("by"=>"list_rank","type"=>"asc"));
		$wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code
		);
		$data['data']["nonccloctypes"] = $this->common->fetchall("epi_non_ccm_locations",NULL,"pk_id as id,location_name as name",$wh_whrarr,NULL,array("by"=>"location_name","type"=>"asc"));
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name || ' ('||COALESCE(serial_no, '') ||')' as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"),NULL,$wh_whrarr_in);
		//echo $this->db->last_query();exit;
		$data['data']["vvmshtml"] = get_options_html($vvms,true);
		$username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>1);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		if($countdrafts){
			$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
			$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
			$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
		}
		createTransactionLog("Stock Receive from Supplier", $subTitle." - Viewed");
		//print_r($data);exit;
		$data['fileToLoad'] = 'inventory_management/stock_receive_from_supplier';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive (Supplier)';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      stock_receive_from_supplierReport
	@ Description:   This function will get report of stock stock_receive_from_supplier
	*/
	public function stock_receive_from_supplierReport()
	{
		$vvms = $this->common->fetchall("epi_vvm_types",NULL,"pk_id as id,vvm_type_name as name",array("status"=>1),NULL,array("by"=>"list_rank","type"=>"asc"));
		$wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code
		);
		$data['data']["nonccloctypes"] = $this->common->fetchall("epi_non_ccm_locations",NULL,"pk_id as id,location_name as name",$wh_whrarr,NULL,array("by"=>"location_name","type"=>"asc"));
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"),NULL,$wh_whrarr_in);
		//echo $this->db->last_query();exit;
		$data['data']["vvmshtml"] = get_options_html($vvms,true);
		$username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>1);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		if($countdrafts){
			$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
			$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
			$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
		}
		//print_r($data);exit;
		$allproducts = array_column($data['data']['draftdata']["batch"],'item_pack_size_id');
		$uniqueprod = array_unique($allproducts);
		$data['data']['uniqueProd']=$uniqueprod;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/stock_receive_from_supplier_report';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive (Supplier) Report ';
		$this->load->view('template/reports_template',$data);;
	}
	public function stock_receive_from_supplierRecNo()
	{
		$tranNo=$_REQUEST['tno'];
		$data['data']['recNo'] =  $tranNo;
		$this -> db -> select('master.pk_id,batch.pk_id,detail.pk_id,master.transaction_date,master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) itemname,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,batch.expiry_date,master.created_date,warehousetypename(CAST(master.from_warehouse_type_id AS INTEGER)) as recievedFrom,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as Storelocation,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
		$whereCondition['master.transaction_type_id'] = 1;
		$whereCondition['master.to_warehouse_type_id'] = $this -> session -> curr_wh_type;
		$whereCondition['master.to_warehouse_code'] = $this -> session -> curr_wh_code;
		$whereCondition['master.transaction_number'] = $tranNo;
		$this -> db -> where($whereCondition);
		$this -> db -> from('epi_stock_master_history master');
		$this -> db -> join('epi_stock_batch_history batch','master.master_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail_history detail','batch.batch_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['data']['searchResult'] = $this -> db -> get() -> result_array();
		$allproducts = array_column($data['data']['searchResult'], 'itemname');
		$uniqueprod = array_unique($allproducts);
		$data['data']['uniqueProd']=$uniqueprod;
		$data['fileToLoad'] = 'inventory_management/stock_receive_search_recNo';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive - Search RecNo';
		$this->load->view('template/reports_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_issue
	@ Description:   This function will open list of recent issued stock from store
	*/
	public function stock_issue()
	{
		$subTitle ="(Vaccine Managment) Stock Issue/Dispatch";
		$data['subtitle']=$subTitle;
		$page =  $this->input->post('page');
		$limit = $this->input->post('limit');
		$offset = $this->input->post('offset');
		$currwhtype = $this->session->curr_wh_type;
		$currwhcode = $this->session->curr_wh_code;
		$ajax_data="";
		if($limit == ""){
			$data['data']['issuedvouchers'] = $this->invn->get_issued_vouchers_list($currwhtype,$currwhcode,100,50,0);
			$data['fileToLoad'] = 'inventory_management/stock_issue_list';
			$data['pageTitle'] = 'EPI-MIS | Stock Issue/Dispatch';
			$this->load->view('template/epi_template',$data);
		}else if($limit >= 0){
			$data['issuedvouchers'] = $this->invn->get_issued_vouchers_list($currwhtype,$currwhcode,$limit,$offset,$page);
			$ajax_data = $this->load->view('inventory_management/ajax/issued_stock.php',$data,true);
		}
		echo $ajax_data;
		createTransactionLog("Stock Issue/Dispatch", $subTitle." - Viewed");

		//please don't remove below commented code till full functional of new inven stock issue mechanism
		/* $username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		if($countdrafts){
			$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
			$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
			$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
		}
		$data['data']["provinces"] = $this->common->fetchall("provinces",NULL,"pro_id as id,province as name",NULL,NULL,array("by"=>"province","type"=>"asc"));
		$data['fileToLoad'] = 'inventory_management/stock_issue';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue/Dispatch';
		$this->load->view('template/epi_template',$data); */
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_issue_bulk
	@ Description:   This function will open form to issue stock from store and make transactions accordingly
	*/
	public function stock_issue_bulk()
	{
		$subTitle = "(Vaccine Management) Stock Issue/Dispatch";
		$data['subtitle']=$subTitle;
		$currwhtype = $this->session->curr_wh_type;
		$currwhcode = $this->session->curr_wh_code;
		if($currwhtype=="4" OR $currwhtype=="2"){
			$selectedprocode = array("pro_id"=>$this -> session -> Province);
		}else{
			$selectedprocode = NULL;
		}
		$data['data']["provinces"] = $this->common->fetchall("provinces",NULL,"pro_id as id,province as name",$selectedprocode,NULL,array("by"=>"province","type"=>"asc"));
		$username = $this->session->userdata("username");
		$whrarr = array(/* "transaction_number"=>'TEMP', */"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		//echo $this->db->last_query();
		if($countdrafts){
			$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
			$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
			$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
		}
		$data['data']['vaccinesDetails'] = $this -> common -> fetchall('epi_item_pack_sizes','','pk_id,item_name,item_unit_id,itemunitname(item_unit_id) as unitname,item_category_id,number_of_doses,list_rank,cr_table_row_numb', array('item_category_id<>'=>4,'activity_type_id'=>1),'',array('by'=>'list_rank','type'=>'asc'));
        createTransactionLog("Stock issue/Dispatch", $subTitle. " - Edit Viewed");
		$data['fileToLoad'] = 'inventory_management/stock_issue_bulk';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue/Dispatch';
		//print_r($data);
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_issue_bulk_items
	@ Description:   This function will get html table having items and batches details
	*/
	public function stock_issue_bulk_items()
	{
		$activity = $this->input->post("activity");
		$data['vaccinesDetails'] = $this -> common -> fetchall('epi_item_pack_sizes','','pk_id,item_name,item_unit_id,itemunitname(item_unit_id) as unitname,item_category_id,number_of_doses,list_rank,cr_table_row_numb', array('item_category_id<>'=>4,'activity_type_id'=>$activity),'',array('by'=>'list_rank','type'=>'asc'));
		$data['towhtype'] = $this->input->post("whtype");
		$data['towhcode'] = $this->input->post("whcode");
		foreach($data['vaccinesDetails'] as $key=> $onevacc){
			$productid = $onevacc["pk_id"];
			$stockissue = true;
			$createoptions = true;
			$withzeroquantity = false;
			$transdate = ($this->input->post("transdate"))?date("Y-m-d H:i:s",strtotime($this->input->post("transdate"))):date("Y-m-d H:i:s");
			$resultarr = array();
			if($productid>0){
				$mnfctrdatafromdb = $this->invn->get_invn_priority_details($productid,$withzeroquantity,$transdate,$stockissue);
				if($mnfctrdatafromdb and $createoptions){
					$data['vaccinesDetails'][$key]["mnfctrhtml"] = get_options_html($mnfctrdatafromdb,true,array("batchexp"=>"expirydate","activity"=>"activity","masterid"=>"masterid","location"=>"locinfo"));
				}else{
					$data['vaccinesDetails'][$key]["mnfctrhtml"] = $mnfctrdatafromdb;
				}
			}
		}
		$this->load->view('inventory_management/ajax/stock_issue_bulk_items',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_receive_from_store
	@ Description:   This function will open form to receive stock from store and make transactions accordingly
	*/
	public function stock_receive_from_store($issuenum=NULL)
	{
		$subTitle ="(Vaccine Management) Stock Receive from Store";
		$data['subtitle']=$subTitle;
		if($issuenum){}else if($this->input->post("stock_issue_num")){
			$issuenum = $this->input->post("stock_issue_num");
		}
		if($issuenum){
			$whrarr = array("transaction_number"=>$issuenum,"draft"=>0,"transaction_type_id"=>2,"to_warehouse_type_id"=>$this->session->curr_wh_type,"to_warehouse_code"=>$this->session->curr_wh_code);
			$whrarrcount = array("transaction_number"=>$issuenum,"draft"=>0,"transaction_type_id"=>2,"to_warehouse_type_id"=>$this->session->curr_wh_type,"to_warehouse_code"=>$this->session->curr_wh_code,"epi_stock_batch.status !="=>"Finished");
			$countdrafts = $this->common->count_record("epi_stock_batch",$whrarrcount,array("table"=>"epi_stock_master","tablecol"=>"pk_id","id"=>"batch_master_id"));
			if($countdrafts){
				$wh_whrarr = array(
					"warehouse_type_id"=>$this->session->curr_wh_type
				);
				$noncc_whrarr["warehouse_code"] = $this->session->curr_wh_code;
				$data['data']["nonccloctypes"] = $this->common->fetchall("epi_non_ccm_locations",NULL,"pk_id as id,location_name as name",$noncc_whrarr,NULL,array("by"=>"location_name","type"=>"asc"));
				$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
                $wh_whrarr["storecode"]=$this->session->curr_wh_code;
				$wh_whrarr["get_asset_status(epi_cc_coldchain_main.asset_id) !="]=3;
				$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name || '('||COALESCE(serial_no, '') ||')' as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"),NULL,$wh_whrarr_in);
				//$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",NULL,"asset_id as id,short_name as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"));
				//$data['data']["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name",array("is_adjustment"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
				//nature column conditon add.for during stock  recieve only negative adjust type show
				$data['data']["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"nature"=>'0',"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
				$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
				$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("epi_stock_batch.batch_master_id"=>$masterdata->pk_id,"epi_stock_batch.status !="=>"Finished"),NULL,array("by"=>"pk_id","type"=>"desc"));
				$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",array("table"=>"epi_stock_batch","tablecol"=>"pk_id","id"=>"stock_batch_id"),"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id,"epi_stock_batch.status !="=>"Finished"),NULL,array("by"=>"pk_id","type"=>"desc"));
			}else{
				$data['data']['msg'] = "Voucher not found / does not belong to this store!";
			}
		}else{
			$data['data'] =NULL;
		}
		$data['data']['issue_num'] = $issuenum;
		//echo '<pre>';print_r($data['data']);exit;
		$data['fileToLoad'] = 'inventory_management/stock_receive_from_store';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive (Supplier)';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_vvm_management
	@ Description:   This function will open form to update current vvm stage of batch and make transactions accordingly
	*/
	public function stock_vvm_management()
	{
		$subTitle ="(Vaccine Managment) VVM Management";
		$data['subtitle']=$subTitle;
		$data['data'] = "";
		$data['fileToLoad'] = 'inventory_management/stock_vvm_management';
		$data['pageTitle'] = 'EPI-MIS | VVm Stage Management';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_transfer_search
	@ Description:   This function will open form to search transferred stock
	*/
	public function stock_transfer()
	{
		$subTitle ="(Vaccine Managment) Purpose Transfer";
		$data['subtitle']=$subTitle;
		$data['data'] = "";
		$data['fileToLoad'] = 'inventory_management/stock_transfer';
		$data['pageTitle'] = 'EPI-MIS | Stock Transfer';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_transfer_save
	@ Description:   This function will save purpose transfer data into db
	*/
	public function stock_transfer_save()
	{
		$username = $this->session->userdata("username");
		$this->form_validation->set_rules('product', 'Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('batch','Batch Number','trim|required');
		$this->form_validation->set_rules('transfer_date','Transfer Date','trim|required|valid_date[Y-m-d]');
		$this->form_validation->set_rules('activity', 'Purpose', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('toproduct', 'Transfer to Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]');
		if ($this->form_validation->run() == FALSE)
		{
			$this->stock_transfer();
		}
		else
		{
			$this->db->trans_start();
			//For Change Purpose -ve
			$batchpk = $this->input->post("batch");
			$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$batchpk));
			$masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,"*",array("pk_id"=>$batchdata->batch_master_id));
			$recordnumber = 1;
			$this->db->set("transaction_number","(select 'A' || '".date("ym")."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
			$datatosave = array(
				"transaction_date" => $this->input->post("transfer_date"),
				"transaction_counter" => $recordnumber,
				"transaction_reference" => '',
				"draft" => 0,
				"comments" => $this->input->post("comments"),
				"transaction_type_id" => 14,//Change Purpose -ve
				"from_warehouse_type_id" => $masterdata->from_warehouse_type_id,
				"from_warehouse_code" => $masterdata->from_warehouse_code,
				"to_warehouse_type_id" => $this->session->curr_wh_type,
				"to_warehouse_code" => $this->session->curr_wh_code,
				"stakeholder_activity_id" => $masterdata->stakeholder_activity_id,//for Change Purpose -ve keep activity same as old
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$newmasterrecid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			$datatosavebatch = array(
				"number" => $batchdata->number,
				"batch_master_id" => $newmasterrecid,
				"expiry_date" => $batchdata->expiry_date,
				"quantity" => $this->input->post("quantity"),
				"unit_price" => $batchdata->unit_price,
				"production_date" => $batchdata->production_date,
				"last_update" => date("Y-m-d H:i:s"),
				"item_pack_size_id" => $batchdata->item_pack_size_id,//for -ve change keep product same as old
				"status" => 'Finished',//for -ve make it finish so that it can be adjusted into next positive
				"vvm_type_id" => $batchdata->vvm_type_id,
				"stakeholder_id" => $batchdata->stakeholder_id,
				"warehouse_type_id" => $this->session->curr_wh_type,
				"code" => $this->session->curr_wh_code,
				"ccm_id" => $batchdata->ccm_id,
				"non_ccm_id" => $batchdata->non_ccm_id,
				"parent_pk_id" => $batchpk,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$newbatchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch,'stock_batch_id_seq');
			$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
			$datatosavedetail = array(
				"quantity" => $this->input->post("quantity"),
				"vvm_stage" => $detaildata->vvm_stage ,
				"is_received" => 0,
				"stock_master_id" => $newmasterrecid,
				"stock_batch_id" => $newbatchid,
				"adjustment_type" => 14,
				"item_unit_id" => $detaildata->item_unit_id,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
			$newquantity = ($batchdata->quantity)-($this->input->post("quantity"));
			//update quantity in old batch
			$datatoupdatebatch = array(
				"quantity" => $newquantity,
				"last_update" => date("Y-m-d H:i:s")
			);
			if($newquantity<1){
				$datatoupdatebatch["status"] = 'Finished';
			}
			$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$batchpk));
			//set history
			$this->save_all_history($newmasterrecid);
			//For Change Purpose +ve
			$this->db->set("transaction_number","(select 'A' || '".date("ym")."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
			$datatosave["transaction_type_id"] = 13;
			$datatosave["stakeholder_activity_id"] = $this->input->post("activity");
			$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			$datatosavebatch["batch_master_id"] = $recid;
			$datatosavebatch["item_pack_size_id"] = $this->input->post("toproduct");
			$datatosavebatch["status"] = 'Stacked';
			$datatosavebatch["parent_pk_id"] = $newbatchid;
			$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch,'stock_batch_id_seq');
			$datatosavedetail["stock_master_id"] = $recid;
			$datatosavedetail["stock_batch_id"] = $batchid;
			$datatosavedetail["adjustment_type"] = 13;
			$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
			//set history
			$this->save_all_history($recid);
			//Change purpose +ve completed
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$msg = "Some error exist, DB Query Fails.";
			}
			else{
				$msg = "Stock transferred to new activity successfully.";
				createTransactionLog("Purpose Transfer", $subTitle." - Stock transferred to new activity successfully. ");
			}
		}
		$this -> session -> set_flashdata('message',$msg);
		redirect(base_url("stockTransfer"));
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_adjustment_search
	@ Description:   This function will open form to search stock adjustments
	*
	public function stock_adjustment_search()
	{
		$data['data'] = "";
		$data['fileToLoad'] = 'inventory_management/stock_adjustment_search';
		$data['pageTitle'] = 'EPI-MIS | Adjustment Search';
		$this->load->view('template/epi_template',$data);
	}*/
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_adjustment
	@ Description:   This function will open form to make stock adjustments
	*/
	public function stock_adjustment()
	{
		$subTitle = "(Vaccine Management) Add Adjustment";
		$data['subtitle']=$subTitle;
		$data['data'] = NULL;
		$vvms = $this->common->fetchall("epi_vvm_types",NULL,"pk_id as id,vvm_type_name as name",array("status"=>1),NULL,array("by"=>"list_rank","type"=>"asc"));
		$data['data']["vvmshtml"] = get_options_html($vvms,true);
		$data['data']["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
		$wh_whrarr = array(
			"warehouse_type_id"=>$this->session->curr_wh_type,
			get_warehouse_code_column($this->session->curr_wh_type)=>$this->session->curr_wh_code
		);
		$data['data']["nonccloctypes"] = $this->common->fetchall("epi_non_ccm_locations",NULL,"pk_id as id,location_name as name",$wh_whrarr,NULL,array("by"=>"location_name","type"=>"asc"));
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"),NULL,$wh_whrarr_in);
		//$data['data']["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",NULL,"asset_id as id,short_name as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"));
		$data['fileToLoad'] = 'inventory_management/stock_adjustment';
		$data['pageTitle'] = 'EPI-MIS | Adjustsment Management';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_issue_search
	@ Description:   This function will open form to search issued stock
	*
	public function stock_issue_search()
	{
		$data['data'] = "";
		$data['fileToLoad'] = 'inventory_management/stock_issue_search';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue/Dispatch Search';
		$this->load->view('template/epi_template',$data);
	}*/
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_batch_management
	@ Description:   This function will open form to to manage batches and their priorities
	*/
	public function stock_batch_management()
	{
		$subTitle ="(Vaccine Managment) Batch Management";
		$data['subtitle']=$subTitle;
		$data['data']['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
		$data['fileToLoad'] = 'inventory_management/stock_batch_management';
		$data['pageTitle'] = 'EPI-MIS | Batch Management';
		$this->load->view('template/epi_template',$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_receive_search
	@ Description:   This function will open form to search received stock
	*
	public function stock_receive_search()
	{
		$data['data'] = "";
		$data['fileToLoad'] = 'inventory_management/stock_receive_search';
		$data['pageTitle'] = 'EPI-MIS | Batch Management';
		$this->load->view('template/epi_template',$data);
	}*/
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      set_invn_supp_receive
	@ Description:   This function will save stock receive from supplier information into database and make transactions accordingly
	*/
	public function set_invn_supp_receive(){
		$subTitle = "(Vaccine Management) Stock Receive From Supplier";
		$data['subtitle']=$subTitle;
		$username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>1);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		if($countdrafts){}else{
			$this->form_validation->set_rules('from_warehouse', 'Received From (Funding Source)', 'trim|required|is_natural|greater_than[0]');
			$this->form_validation->set_rules('activity', 'Purpose', 'trim|required|is_natural|greater_than[0]');
			$this->form_validation->set_rules('trans_date_time','Received Time','trim|required|valid_date[Y-m-d H:i:s]');
		}
		$this->form_validation->set_rules('product', 'Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('manufacturer', 'Manufacturer', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('batch_numb','Batch Number','trim|required');
		$this->form_validation->set_rules('production_date','Production Date','trim|required|valid_date[Y-m-d]');
		$this->form_validation->set_rules('expiry_date','Expiry Date','trim|required|valid_date[Y-m-d]');
		$this->form_validation->set_rules('unit_price','Unit Price (PKR)','trim|required|decimal|greater_than[0.00]');
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('vvm_type','VVM Type','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('location','Placement Location','trim|required');
		if ($this->form_validation->run() == FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = strip_tags(validation_errors());
			$response["data"] = array();
		}
		else
		{
			$this->db->trans_start();
			if($countdrafts){
				//draft already exist, update counter and add items in batch
				$resultrow = $this->common->get_info("epi_stock_master",NULL,NULL,"pk_id as id,transaction_counter",$whrarr,array("by"=>"pk_id","type"=>"desc"));
				$recordnumber = ($resultrow->transaction_counter+1);
				$datatoupdate = array(
					"transaction_counter" => $recordnumber,
					"updated_date" => date("Y-m-d H:i:s")
				);
				$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
				$recid = $resultrow->id;
			}else{
				//create draft
				$recordnumber = 1;
				$datatosave = array(
					"transaction_date" => $this->input->post("trans_date_time"),
					"transaction_number" => 'TEMP',
					"transaction_counter" => $recordnumber,
					"transaction_reference" => $this->input->post("trans_ref"),
					"draft" => 1,
					"comments" => "",
					"transaction_type_id" => 1, // Receive
					"from_warehouse_type_id" => 7, //Funding Source
					"from_warehouse_code" => $this->input->post("from_warehouse"),
					"to_warehouse_type_id" => $this->session->curr_wh_type,//2, //Provincial
					"to_warehouse_code" => $this->session->curr_wh_code,//$_SESSION["Province"], //For Province KP
					"stakeholder_activity_id" => $this->input->post("activity"),
					"created_by" => $username,
					"created_date" => date("Y-m-d H:i:s")
				);
				$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			}
			$datatosavebatch = array(
				"number" => $this->input->post("batch_numb"),//$recordnumber,
				"batch_master_id" => $recid,
				"expiry_date" => $this->input->post("expiry_date"),
				"quantity" => $this->input->post("quantity"),
				"unit_price" => $this->input->post("unit_price"),
				"production_date" => $this->input->post("production_date"),
				"last_update" => date("Y-m-d H:i:s"),
				"item_pack_size_id" => $this->input->post("product"),
				"status" => 'Stacked',
				"vvm_type_id" => $this->input->post("vvm_type"),
				"stakeholder_id" => $this->input->post("manufacturer"),
				$this->input->post("location_type") => $this->input->post("location"),
				"warehouse_type_id" => $this->session->curr_wh_type,//2, //Provincial
				"code" => $this->session->curr_wh_code, //For Province KP
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
			$datatosavedetail = array(
				"quantity" => $this->input->post("quantity"),
				"vvm_stage" => $this->input->post("vvm_stage"),
				"is_received" => 1,
				"stock_master_id" => $recid,
				"stock_batch_id" => $batchid,
				"item_unit_id" => $this->input->post("item_unit_id"),
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$response["result"] = "false";
				$response["msg"] = "Some error exist, DB Query Fails.";
				$response["data"] = array();
			}
			else{
				$username = $this->session->userdata("username");
				$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>1);
				$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
				if($countdrafts){
					$data["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
					$data["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
					$data["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
				}
				$response["data"] = $this->load->view("inventory_management/ajax/stock_receive_from_supplier_list.php",$data);
			}
		}
		echo json_encode($response,true);
		createTransactionLog("Stock Receive From Supplier", $subTitle. " - Add Stock Receive ");
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_invn_supp_receive
	@ Description:   This function will update stock receive from supplier information and set draft 0 into database
	*/
	public function save_invn_supp_receive(){
		$subTitle = "(Vaccine Management) Stock Receive From Supplier";
		$data['subtitle']=$subTitle;
		$username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>1);
		$resultrow = $this->common->get_info("epi_stock_master",NULL,NULL,"pk_id as id,to_char(transaction_date,'YYMM') as tdate",$whrarr);
		if(isset($resultrow) && ($resultrow->id >0)){
			$date=$resultrow->tdate;
			$this->db->trans_start();
			//draft already exist, update draft then items will be available for stock issuance nd usage
			$this->db->set("transaction_number","(select 'R' || '".$date."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
			$datatoupdate = array(
				"comments" => $this->input->post("comments"),
				"draft" => 0,
				"updated_date" => date("Y-m-d H:i:s")
			);
			$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
			//set history
			$masterpk = $resultrow->id;
			$this->save_all_history($masterpk);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$msg = "Some error exist, DB Query Fails.";
			}
			else{
				$rowdata = $this->common->get_info("epi_stock_master",NULL,NULL,"transaction_number",array("pk_id"=>$masterpk));
				$trans_number=$rowdata->transaction_number;
				$msg = "Transaction Completed Successfully, Stocks received, Transaction Number is <a target='_blank' href='".base_url()."stockReceiveFromSupplierRecNo?tno=".$trans_number."'>".$trans_number."</a>!!";
			}
		}
		else{
			$msg = "There is nothing in receive list, Please check and try again!!!";
		}
		createTransactionLog("Add Stock Save Button", $subTitle. " - Add Stock Button after Save result (Stock Receive From SupplierRec No ($trans_number))");
		$this -> session -> set_flashdata('message',$msg);
		redirect('StockReceivefromSupplier');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      del_invn_supp
	@ Description:   This function will delete stock batch and detail record
	*/
	public function del_invn_supp(){
		$batchid = $this->input->post("batch");
		$masterid = $this->input->post("master");
		$this->db->trans_start();
			$this->common->delete_record_multiple_colum("epi_stock_detail",array("stock_batch_id"=>$batchid,"stock_master_id" => $masterid));
			$this->common->delete_record_multiple_colum("epi_stock_batch",array("pk_id"=>$batchid,"batch_master_id" => $masterid));
			//count remaining records of batch for master
			$totalrecords = $this->common->count_record("epi_stock_batch",array("batch_master_id"=>$masterid));
			if($totalrecords>0){
				//update count in master table
				$datatoupdate = array(
					"transaction_counter" => $totalrecords,
					"updated_date" => date("Y-m-d H:i:s")
				);
				$this->common->update_record("epi_stock_master",$datatoupdate,array("pk_id"=> $masterid));
			}else{
				$this->common->delete_record_multiple_colum("epi_stock_master",array("pk_id"=> $masterid));
			}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = "Some error exist, Record(s) cannot be deleted.";
			$response["data"] = array();
		}
		else{
			$response["result"] = "true";
			$response["msg"] = "Record Deleted Sucessfully!!";
			$response["data"] = array();
		}
		echo json_encode($response,true);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_invn_store_receive
	@ Description:   This function will save stock receive from store data to db
	*/
	public function save_invn_store_receive(){
		$subTitle ="(Vaccine Managment) Stock Receive (Store)";
		$data['subtitle']=$subTitle;
		$msg = "";
		$username = ($this->session->userdata("username"))?$this->session->userdata("username"):$this -> input -> post('curr_wh_code');
		$allchecked = $this->input->post("addit");
		$searchednum = $this->input->post("searchedissuenum");
		$resultrowmaster = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,array("transaction_number"=>$searchednum));
		$unfinishedbatches = $this->common->count_record("epi_stock_batch",array("batch_master_id"=>$resultrowmaster->pk_id,"status !="=>"Finished"));
		if($unfinishedbatches > 0){
			foreach($allchecked as $key=>$index){
				$this->form_validation->set_rules("location[$index]", "Store Location ", 'trim|required|is_natural|greater_than[0]');
			}
			$curr_wh_code = (isset($this->session->curr_wh_code))?$this->session->curr_wh_code:$this->input->post('curr_wh_code');
			$curr_wh_type = (isset($this->session->curr_wh_type))?$this->session->curr_wh_type:$this->input->post('curr_wh_type');
			if ($this->form_validation->run() == FALSE)
			{
				if($this -> input -> post('token')){
					$this->output->set_content_type('application/json');
					return $this->output->set_output(json_encode(array('success'=>false, 'message'=>validation_errors())));exit;
				}
				//echo validation_errors();exit;
				$this -> session -> set_flashdata('message',validation_errors());
				$this->stock_receive_from_store($searchednum);
			}
			else if(($resultrowmaster->to_warehouse_type_id==$curr_wh_type) && ($resultrowmaster->to_warehouse_code==$curr_wh_code))
			{
				$saveAdjust=false;
				//echo $saveAdjust;exit;
				$this->db->trans_start();
				$recordnumber = count($allchecked);
				$date= $this->input->post("receive_date");
				//to_char(transaction_date,'YYMM');
				$this->db->set("transaction_number","(select 'R' || '".date("ym", strtotime($date))."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
				$datatosave = array(
					"transaction_date" => $this->input->post("receive_date"),
					"transaction_counter" => $recordnumber,
					"transaction_reference" => $this->input->post("receive_ref"),
					"draft" => 0,
					"comments" => $this->input->post("receive_remarks"),
					"transaction_type_id" => 1, // Receive
					"from_warehouse_type_id" => $resultrowmaster->from_warehouse_type_id,
					"from_warehouse_code" => $resultrowmaster->from_warehouse_code,
					"to_warehouse_type_id" => $resultrowmaster->to_warehouse_type_id,
					"to_warehouse_code" => $resultrowmaster->to_warehouse_code,
					"stakeholder_activity_id" => $resultrowmaster->stakeholder_activity_id,
					"created_by" => $username,
					"created_date" => date("Y-m-d H:i:s")
				);
				$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
				foreach($allchecked as $key=>$index){
					$batchpk = $this->input->post("batchid")[$index];
					$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$batchpk));
					if($this->input->post("transactionnature")[$index] !=""){
						$saveAdjust=true;
					$newquantity = ($this->input->post("transactionnature")[$index]=="1")?($batchdata->quantity)+(isset($this->input->post("vials")[$index])?$this->input->post("vials")[$index]:0):($batchdata->quantity)-(isset($this->input->post("vials")[$index])?$this->input->post("vials")[$index]:0);
					}
					else
					{
						$saveAdjust=false;
						$newquantity=$batchdata->quantity;
					}
					//echo $this->input->post("transactionnature")[$index] ;//echo $saveAdjust;exit;
					$datatosavebatch = array(
						"number" => $batchdata->number,
						"batch_master_id" => $recid,
						"expiry_date" => $batchdata->expiry_date,
						"quantity" =>$newquantity,
						"unit_price" => $batchdata->unit_price,
						"production_date" => $batchdata->production_date,
						"last_update" => date("Y-m-d H:i:s"),
						"item_pack_size_id" => $batchdata->item_pack_size_id,
						"status" => 'Stacked',
						"vvm_type_id" => $batchdata->vvm_type_id,
						"stakeholder_id" => $batchdata->stakeholder_id,
						$this->input->post("location_type")[$index] => $this->input->post("location")[$index],
						"warehouse_type_id" => $curr_wh_type,
						"code" => $curr_wh_code,
						"created_by" => $username,
						"created_date" => date("Y-m-d H:i:s"),
						"parent_pk_id" => $batchpk
					);
					$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
					$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
					$vvm_stage = $this->input->post("vvm_stage");
					$reason = $this->input->post("reason");
					$datatosavedetail = array(
						"quantity" => $datatosavebatch["quantity"],
						"vvm_stage" => isset($vvm_stage[$index])?$vvm_stage[$index]:$detaildata->vvm_stage,
						"is_received" => 1,
						"adjustment_type" => (isset($reason[$index]) && $reason[$index]!='')?$reason[$index]:((isset($detaildata->adjustment_type) && $detaildata->adjustment_type!='')?$detaildata->adjustment_type:NULL),
						"stock_master_id" => $recid,
						"stock_batch_id" => $batchid,
						"item_unit_id" => $detaildata->item_unit_id,
						"created_by" => $username,
						"created_date" => date("Y-m-d H:i:s")
					);
					$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
					//update quantity in old batch and detail
					$datatoupdatebatch = array(
						"status" => 'Finished',
						"last_update" => date("Y-m-d H:i:s")
					);
					$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$batchpk));
					//echo "yes.";/working on it
					/***For saving Adjustment record ***/
					if($saveAdjust)
					{
						$date= $this->input->post("receive_date");
						//to_char(transaction_date,'YYMM');
						$this->db->set("transaction_number","(select 'A' || '".date("ym", strtotime($date))."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
						$datatoadjust = array(
							"transaction_date" => $this->input->post("receive_date"),
							"transaction_counter" => 1,
							"transaction_reference" => $this->input->post("receive_ref"),
							"draft" => 0,
							"comments" => $this->input->post("receive_remarks"),
							"transaction_type_id" => $reason[$index], // Adjustment
							"from_warehouse_type_id" => $resultrowmaster->from_warehouse_type_id,
							"from_warehouse_code" => $resultrowmaster->from_warehouse_code,
							"to_warehouse_type_id" => $resultrowmaster->to_warehouse_type_id,
							"to_warehouse_code" => $resultrowmaster->to_warehouse_code,
							"stakeholder_activity_id" => $resultrowmaster->stakeholder_activity_id,
							"created_by" => $username,
							"created_date" => date("Y-m-d H:i:s")
							);
							//adjustemnt master id
						$adjustid = $this->common->insert_record("epi_stock_master",$datatoadjust,'stock_master_id_seq');
						// echo "ehre";
						//$batchpk = $this->input->post("batchid")[$index];
						//$adjustQty=round((isset($this->input->post("vials")[$index]));
						$adjustQty=isset($this->input->post("vials")[$index])?$this->input->post("vials")[$index]:0;
						$datatoadjustbatch = array(
						"number" => $batchdata->number,
						"batch_master_id" => $adjustid,
						"expiry_date" => $batchdata->expiry_date,
						"quantity" =>round($adjustQty),
						"unit_price" => $batchdata->unit_price,
						"production_date" => $batchdata->production_date,
						"last_update" => date("Y-m-d H:i:s"),
						"item_pack_size_id" => $batchdata->item_pack_size_id,
						"status" =>$status=($this->input->post("transactionnature")[$index]=="1")?'Stacked':'Finished',
						"vvm_type_id" => $batchdata->vvm_type_id,
						"stakeholder_id" => $batchdata->stakeholder_id,
						$this->input->post("location_type")[$index] => $this->input->post("location")[$index],
						"warehouse_type_id" => $curr_wh_type,
						"code" => $curr_wh_code,
						"created_by" => $username,
						"created_date" => date("Y-m-d H:i:s"),
						"parent_pk_id" => $batchid
						);
						$adjustbatchid = $this->common->insert_record("epi_stock_batch",$datatoadjustbatch);
						//print_r($datatoadjustbatch);echo "--";echo '<br>';
						$vvm_stage = $this->input->post("vvm_stage");
						$reason = $this->input->post("reason");
						$datatoadjustdetail = array(
							"quantity" => $datatoadjustbatch["quantity"],
							"vvm_stage" => isset($vvm_stage[$index])?$vvm_stage[$index]:$detaildata->vvm_stage,
							"is_received" => 0,//chk adjustment type conditon test
							"adjustment_type" => (isset($reason[$index]) && $reason[$index]!='')?$reason[$index]:((isset($detaildata->adjustment_type) && $detaildata->adjustment_type!='')?$detaildata->adjustment_type:NULL),
							"stock_master_id" =>$adjustid,
							"stock_batch_id" => $adjustbatchid,
							"item_unit_id" => $detaildata->item_unit_id,
							"rec_adjustment" =>1, //for adjustment during receive
							"created_by" => $username,
							"created_date" => date("Y-m-d H:i:s")
						);
						$detailid = $this->common->insert_record("epi_stock_detail",$datatoadjustdetail);
						//set adjustment history
						$this->save_all_history($adjustid);
						if($this -> input -> post('token')){
							createTransactionLog("StockAdjustment from Stock Receive Store","stock master id".$adjustid, $username, '6', 'DEO');
						}else{
							createTransactionLog("StockAdjustment from Stock Receive Store","stock master id".$adjustid);
						}
					}
					/***-------------------END-----------------***/
				}
				//set history
				$masterpk = $recid;
				$this->save_all_history($masterpk);
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					$msg = "Some error exist, DB Query Fails.";
				}
				else{
					$msg = "Stock received Successfully.";
					if($this -> input -> post('token')){
							createTransactionLog("Stock Receive from Store", $subTitle." - Viewed, Issue No ($searchednum) Receive No ()", $username, '6', 'DEO');
					}else{
						createTransactionLog("Stock Receive from Store", $subTitle." - Viewed, Issue No ($searchednum) Receive No ()");
					}
					if($this -> input -> post('token')){
						$this->output->set_content_type('application/json');
						return $this->output->set_output(json_encode(array('success'=>true, 'message'=>'Voucher Received Successfully')));exit;
					}
					$searchednum = NULL;
				}
			}else{
				$msg = "You are not authorized to receive this voucher.";
			}
			//echo $msg;exit;
			//$this -> session -> keep_flashdata('message',$msg);
			if($this -> input -> post('token')){
				$this->output->set_content_type('application/json');
				return $this->output->set_output(json_encode(array('success'=>true, 'message'=>$msg)));exit;
			}
			$this -> session -> set_flashdata('message',$msg);
			redirect(base_url().'StockReceivefromStore/'.$searchednum);
		}else{
			if($this -> input -> post('token')){
				$this->output->set_content_type('application/json');
				return $this->output->set_output(json_encode(array('success'=>true, 'message'=>'Stock Already Received Successfully.')));exit;
			}else{
				$this -> session -> set_flashdata('message',"Stock Already Received Successfully.");
				redirect(base_url().'StockReceivefromStore/'.$searchednum);
			}
		}
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      set_invn_supp_issue
	@ Description:   This function will save stock issue information into database and make transactions accordingly
	*/
	public function set_invn_supp_issue(){
		$username = $this->session->userdata("username");
		$whrarr = array(/* "transaction_number"=>'TEMP', */"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		$activity=$this->input->post('activity');
		if($countdrafts){}else{
			$this->form_validation->set_rules('code', 'Store Location', 'trim|required|is_natural|greater_than[0]');
			$this->form_validation->set_rules('activity', 'Purpose', 'trim|required|is_natural|greater_than[0]');
			if($activity==1){
				$this->form_validation->set_rules('trans_date_time','Issue Time','trim|required|valid_date[Y-m-d H:i:s]|callback_is_consumption_filled');
			}
			else{
				$this->form_validation->set_rules('trans_date_time','Issue Time','trim|required|valid_date[Y-m-d H:i:s]');
			}
		}
		$this->form_validation->set_rules('product', 'Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('batch', 'Manufacturer |Batch | Quantity | Priority','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]');
		if ($this->form_validation->run() == FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = strip_tags(validation_errors());
			$response["data"] = array();
		}
		else
		{
			$this->db->trans_start();
			$batchpk = $this->input->post("batch");
			$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$batchpk));
			$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
			if($countdrafts){
				//draft already exist, update counter and add items in batch
				$resultrow = $this->common->get_info("epi_stock_master",NULL,NULL,"pk_id as id,transaction_counter,to_warehouse_type_id,to_warehouse_code",$whrarr,array("by"=>"pk_id","type"=>"desc"));
				$recordnumber = ($resultrow->transaction_counter+1);
				$datatoupdate = array(
					"transaction_counter" => $recordnumber,
					"updated_date" => date("Y-m-d H:i:s")
				);
				$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
				$recid = $resultrow->id;
				$towhtype = $resultrow->to_warehouse_type_id;
				$towhcode = $resultrow->to_warehouse_code;
			}else{
				$towhtype = $this->input->post("to_warehouse_type_id");
				$towhcode = $this->input->post("code");
				//create draft
				$recordnumber = 1;
				$datatosave = array(
					"transaction_date" => $this->input->post("trans_date_time"),
					"transaction_number" => 'TEMP',
					"transaction_counter" => $recordnumber,
					"transaction_reference" => $this->input->post("trans_ref"),
					"draft" => 1,
					"comments" => "",
					"transaction_type_id" => 2, // Issue
					"from_warehouse_type_id" => $this->session->curr_wh_type,
					"from_warehouse_code" => $this->session->curr_wh_code,
					"to_warehouse_type_id" => $towhtype,
					"to_warehouse_code" => $towhcode,
					"stakeholder_activity_id" => $this->input->post("activity"),
					"created_by" => $username,
					"created_date" => date("Y-m-d H:i:s")
				);
				$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			}
			$datatosavebatch = array(
				"number" => $batchdata->number,
				"batch_master_id" => $recid,
				"expiry_date" => $batchdata->expiry_date,
				"quantity" => $this->input->post("quantity"),
				"unit_price" => $batchdata->unit_price,
				"production_date" => $batchdata->production_date,
				"last_update" => date("Y-m-d H:i:s"),
				"item_pack_size_id" => $batchdata->item_pack_size_id,
				"status" => 'Stacked',
				"vvm_type_id" => $batchdata->vvm_type_id,
				"stakeholder_id" => $batchdata->stakeholder_id,
				"warehouse_type_id" => $towhtype,
				"code" => $towhcode,
				"parent_pk_id" => $batchpk,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
			$datatosavedetail = array(
				"quantity" => $this->input->post("quantity"),
				"vvm_stage" => $detaildata->vvm_stage,
				"is_received" => 0,
				"stock_master_id" => $recid,
				"stock_batch_id" => $batchid,
				"item_unit_id" => $detaildata->item_unit_id,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
			//update quantity in old batch and detail
			$updateQty=($batchdata->quantity)-($this->input->post("quantity"));
			$datatoupdatebatch = array(
				"quantity" => $updateQty,
				"last_update" => date("Y-m-d H:i:s")
			);
			if($updateQty < 1 )
				$datatoupdatebatch['status']='Finished';
			$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$batchpk));
			$datatoupdatedetail = array(
				"quantity" => ($detaildata->quantity)-($this->input->post("quantity"))
			);
			$this->common->update_record("epi_stock_detail",$datatoupdatedetail,array("stock_batch_id"=>$batchpk));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$response["result"] = "false";
				$response["msg"] = "Some error exist, DB Query Fails.";
				$response["data"] = array();
			}
			else{
				$username = $this->session->userdata("username");
				$whrarr = array(/* "transaction_number"=>'TEMP', */"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
				$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
				if($countdrafts){
					$data["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
					$data["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
					$data["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
				}
				$response["data"] = $this->load->view("inventory_management/ajax/stock_issue_list.php",$data);
			}
		}
		echo json_encode($response,true);
	}
	public function is_consumption_filled($transdate)
	{
		$whtype = $this->input->post("to_warehouse_type_id");
		$whcode = $this->input->post("code");
		if ($whtype==6)
		{
			//check if consumption of advance month filled or not
			$fmonth = substr($transdate,0,7);
			$totrep = $this->common->count_record("epi_consumption_master",array("fmonth >="=>$fmonth,"facode"=>$whcode));
			if($totrep>0){
				$this->form_validation->set_message('is_consumption_filled', 'Consumption report already exist for respective month against this facility, please change your transaction date.');
				return FALSE;
			}else
			{
				return TRUE;
			}
		}
		else
		{
			return TRUE;
		}
	}
	public function less_than_equal_to()
	{
		$qty = $this->input->post("quantity");
		$available = $this->input->post("available_quantity");
		if($qty <= $available )
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('less_than_equal_to', 'Quantity to Adjust must be less than Available Quantity.');
			return false;
		}
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_invn_supp_issue
	@ Description:   This function will update stock issue from supplier information and set draft 0 into database
	*/	
	public function save_invn_supp_issue(){
		$subTitle = "(Vaccine Management) Stock Issue/Dispatch";
		$data['subtitle']=$subTitle;
		/* $batchid = $this->input->post("batch");
		$masterid = $this->input->post("master");
		$batchnum = $this->input->post("batchnum"); */
		$username = $this->session->userdata("username");
		$whrarr = array(/* "transaction_number"=>'TEMP', */"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
		$resultrow = $this->common->get_info("epi_stock_master",NULL,NULL,"transaction_number,to_char(transaction_date,'YYMM') as tdate,pk_id as id",$whrarr);
		$date=$resultrow->tdate;
		if(isset($resultrow) && ($resultrow->id >0)){
			$this->db->trans_start();
			//draft already exist with id TEMP, update draft then items will be available for receiving from store
			if($resultrow->transaction_number=='TEMP'){
			$row=$this->db->query("SELECT nextval('stock_master_trans_num_seq'::regclass) as val")->row();
			//incremntend value by
			$maxval=$row->val;
			$datemaxnumber=$this->db->query("SELECT max(transaction_number) as number FROM epi_stock_master where transaction_number like 'I$date%' ")->row();
			$transno=$datemaxnumber->number;
			$transno=substr($transno,5);
			/* IF IF max(tranNo) is greater/equal than latest sequence value (maxval) */
			if($transno >= $maxval && $transno!='999999')
			{
				$transno=$transno+1;
			}
			else
			{
				/*using incremented sequence value. */
				$transno=$maxval;
			}
			//fucntion call to check whether incremented value match or not
			$transno=str_pad ($transno ,6,0,STR_PAD_LEFT) ;
			$voucher='I'.$date."".$transno;
			for($i=1;$i<=999999;$i++){
				$newtransno=check_Voucher_No($voucher);
				if($newtransno==true){
					$row=$this->db->query("SELECT nextval('stock_master_trans_num_seq'::regclass) as val")->row();
					$maxval=$row->val;
					$maxval=str_pad ($maxval ,6,0,STR_PAD_LEFT) ;
					$tno='I'.$date.''.$maxval;
					$voucher=$tno;
				}
				else{
					//if no match then break the loop
					break;
				}
			}
			$TranNo=substr($voucher,5);
			$data=$this->db->set("transaction_number","(select 'I' || '".$date."' || to_char($TranNo,'fm000000'))",FALSE);
		}
			$datatoupdate = array(
				"comments" => $this->input->post("comments"),
				"draft" => 0,
				"updated_date" => date("Y-m-d H:i:s")
			);
			$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
			//set history
			$masterpk = $resultrow->id;
			$this->save_all_history($masterpk);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$msg = "Some error exist, DB Query Fails.";
			}
			else{
				$rowdata = $this->common->get_info("epi_stock_master",NULL,NULL,"transaction_number",array("pk_id"=>$masterpk));
				$trans_number=$rowdata->transaction_number;
				$msg = "Transaction Completed Successfully, Stocks Issued, Transaction Number is <a target='_blank' href='".base_url()."stockIssueDispatchTransNo?tno=".$trans_number."'>".$trans_number."</a>!!";
			}
		}
		else{
			$msg = "There is nothing in Issue list, Please check and try again!!!";
		}
		//createTransactionLog("Stock Issue/Dispatch Save File", $subTitle. " - Save data of Issue/Dispatch After Deleted any file, Stocks Issued,Batch Id ($batchid) Master Id ($masterid) Batch Number ($batchnum) Transaction Number is ($trans_number)");
		createTransactionLog("Stock Issue/Dispatch Save File", $subTitle. " - Save data of Issue/Dispatch After Deleted any file, Stocks Issued, Transaction Number is ($trans_number)");
		$this -> session -> set_flashdata('message',$msg);
		redirect('StockIssue');
	}
	/*
	@ Author:        Omer Butt
	@ Email:         omerbutt2521@gmail.com
	@ Function:      chckfac_issue_db
	@ Description:   This function will chck in DB whether facode data already entered in form_b_cr table with selected month
					 and facode
	*/
	public function chckfac_issue_db()
	{
		$uccode=$_REQUEST['uccode'];
		$facode=$_REQUEST['facode'];
		$date=$_REQUEST['tdate'];
		$result=$this->invn->chckfac_issue_db($uccode,$facode,$date);
		echo json_encode($result);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      del_invn_issue
	@ Description:   This function will delete batch entity
	*/
	public function del_invn_issue(){
		$subTitle = "(Vaccine Management) Stock issue/Dispatch";
		$data['subtitle']=$subTitle;
		$batchid = $this->input->post("batch");
		$masterid = $this->input->post("master");
		$batchnum = $this->input->post("batchnum");
		$quantitytoupdate = $this->common->get_info("epi_stock_batch",NULL,NULL,"quantity,parent_pk_id",array("pk_id"=>$batchid,"batch_master_id" => $masterid));
		$parentbatch = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$quantitytoupdate->parent_pk_id));
		$this->db->trans_start();
			//update quantity in old batch and detail
			$newquantity = ($parentbatch->quantity)+($quantitytoupdate->quantity);
			$datatoupdatebatch = array(
				"quantity" => $newquantity,
				"last_update" => date("Y-m-d H:i:s"),
				"status"     =>"Stacked"
			);
			$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$quantitytoupdate->parent_pk_id));
			$datatoupdatedetail = array(
				"quantity" => $newquantity
			);
			$this->common->update_record("epi_stock_detail",$datatoupdatedetail,array("stock_batch_id"=>$quantitytoupdate->parent_pk_id));
			//function to save delete record in system
			$array_ids=array('master_id'=>$masterid,'batch_id'=>$batchid);
			$this->Save_delete_record_hsitory($array_ids);
			$this->common->delete_record_multiple_colum("epi_stock_detail",array("stock_batch_id"=>$batchid,"stock_master_id" => $masterid));
			$this->common->delete_record_multiple_colum("epi_stock_batch",array("pk_id"=>$batchid,"batch_master_id" => $masterid));
			//count remaining records of batch for master
			$totalrecords = $this->common->count_record("epi_stock_batch",array("batch_master_id"=>$masterid));
			if($totalrecords>0){
				//update count in master table
				$datatoupdate = array(
					"transaction_counter" => $totalrecords,
					"updated_date" => date("Y-m-d H:i:s")
				);
				$this->common->update_record("epi_stock_master",$datatoupdate,array("pk_id"=> $masterid));
			}else{
				$this->common->delete_record_multiple_colum("epi_stock_master",array("pk_id"=> $masterid));
			}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = "Some error exist, Record(s) cannot be deleted.";
			$response["data"] = array();
		}
		else{
			$response["result"] = "true";
			$response["msg"] = "Record Deleted Sucessfully!!";
			$response["data"] = array();
		}
		createTransactionLog("Stock Issue/Dispatch Deleted", $subTitle. " - Deleted Batch Id ($batchid) Master Id ($masterid) Batch Number ($batchnum)");
		echo json_encode($response,true);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      edit_invn_issue
	@ Description:   This function will allow user to edit voucher/items those are not completely received by other end yet.
	*/
	public function edit_invn_issue($masterid){
		$subTitle = "(Vaccine Management) Stock Issue/Dispatch";
		$data['subtitle']=$subTitle;
		$masterid = (int)($masterid)?$masterid:$this->input->Request("master");
		$currwhtype = $this->session->curr_wh_type;
		$currwhcode = $this->session->curr_wh_code;
		$username = $this->session->userdata("username");
		//check if user can edit this voucher or not? is it belongs to user? is it editable?
		$voucherdetail = $this->invn->get_issued_voucher_status($masterid);
		if(isset($voucherdetail) && ($voucherdetail->from_warehouse_type_id == $currwhtype) && ($voucherdetail->from_warehouse_code == $currwhcode)){
			//check if voucher is editable?
			if($voucherdetail->voucherstat =='Dispatched' || $voucherdetail->voucherstat =='Partially Received'){
				//check if anyother voucher for same user is in draft or not
				$totindraft = $this->common->count_record("epi_stock_master",array("created_by"=>$username,"draft"=>1,"from_warehouse_type_id"=>$currwhtype,"from_warehouse_code"=>$currwhcode));
				if($totindraft){
					//show error message that there is already a voucher in process please complete it first
					$msg = 'There is some other voucher in process, Please <a href="'.base_url("invnissue").'" >complete or cancel it first</a> only then you can edit other voucher.';
				}else{
					//move voucher to draft again and redirect to issue page.
					$this->db->trans_start();
					$username = $this->session->userdata("username");
					$whrarr = array("pk_id"=>$masterid,"created_by"=>$username,"draft"=>0);
					$datatoupdate = array(
						"draft" => 1,
						"updated_date" => date("Y-m-d H:i:s")
					);
					$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
					//delete history of previous drafted
					$this->del_all_history($masterid);
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$msg = "Some error exist, DB Query Fails.";
					}
					else{
						redirect('invnissue');
						//break;
					}
				}
			}else{
				$msg = "This Voucher is not dispatched or received on other end you cannot edit it.";
			}
		}else{
			//message wrong voucher
			$msg = "You have entered wrong voucher number, Please try again.";
		}
		createTransactionLog("Stock Issue Edited", $subTitle. " - Stock Issue Edited Voucher list, Master Pk_id ($masterid)");
		//redirect back to list page
		$this -> session -> set_flashdata('message',$msg);
		$this->stock_issue();
		//redirect('StockIssue');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_invn_stock_adjust
	@ Description:   This function will save adjustment information into database and make transactions accordingly
	*/
	public function save_invn_stock_adjust(){
		$subTitle = "(Vaccine Management) Add Adjustment";
		$data['subtitle']=$subTitle;
		$username = $this->session->userdata("username");
		$today = date("Y-m-d");
		$this->form_validation->set_rules('adjust_date','Adjustment Date',"trim|required|valid_date[Y-m-d]|lessEqualTo_date[".$today."]");
		$this->form_validation->set_rules('type','Adjustment Type','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('product', 'Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('batch','Manufacturer | Batch | Quantity | VVM Stage','trim|required|is_natural|greater_than[0]');
		$type = $this->input->post("transactionnature");
		$available = $this->input->post("available_quantity");
		$this->form_validation->set_rules('available_quantity','Available Quantity','trim|required|is_natural');//|greater_than[0]
		if($type==1)
		{
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]');
		}
		//For neagtive adjustment |less_than_equal_to['.$available.']
		else
		{
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]|callback_less_than_equal_to');
		}
		if ($this->form_validation->run() == FALSE)
		{
			$this->stock_adjustment();
		}
		else
		{
			$this->db->trans_start();
			$masterpk = $this->input->post("masterid");
			
			if(isset($masterpk) && $masterpk>0){
				$masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,"*",array("pk_id"=>$masterpk));
				$fromwhtype = $masterdata->from_warehouse_type_id;
				$fromwhcode = $masterdata->from_warehouse_code;
				$activity = $masterdata->stakeholder_activity_id;
				$updatebatch = false;
				
			}else{
				$fromwhtype = $this->session->curr_wh_type;
				$fromwhcode = $this->session->curr_wh_code;
				$activity = $this->input->post("activity");
				$updatebatch = true;
			}
			//print_r($updatebatch);exit;
			$date=date("ym", strtotime($this->input->post("adjust_date")));
			$recordnumber = 1;
			$this->db->set("transaction_number","(select 'A' || '".$date."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm000000'))",FALSE);
			$datatosave = array(
				"transaction_date" => $this->input->post("adjust_date"),
				"transaction_counter" => $recordnumber,
				"transaction_reference" => $this->input->post("ref"),
				"draft" => 0,
				"comments" => $this->input->post("comments"),
				"transaction_type_id" => $this->input->post("type"),
				"from_warehouse_type_id" => $fromwhtype,
				"from_warehouse_code" => $fromwhcode,
				"to_warehouse_type_id" => $this->session->curr_wh_type,
				"to_warehouse_code" => $this->session->curr_wh_code,
				"stakeholder_activity_id" => $activity,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			$batchpk = $this->input->post("batch");
			$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$batchpk));
			$datatosavebatch = array(
				"number" => $batchdata->number,
				"batch_master_id" =>$recid,
				"expiry_date" => $batchdata->expiry_date,
				"quantity" => $this->input->post("quantity"),
				"unit_price" => $batchdata->unit_price,
				"production_date" => $batchdata->production_date,
				"last_update" => date("Y-m-d H:i:s"),
				"item_pack_size_id" => $batchdata->item_pack_size_id,
				"status" => $newquantity = ($this->input->post("transactionnature")=="1")?'Stacked':'Finished',
				"vvm_type_id" => $batchdata->vvm_type_id,
				"stakeholder_id" => $batchdata->stakeholder_id,
				"warehouse_type_id" => $this->session->curr_wh_type,
				"code" => $this->session->curr_wh_code,
				"ccm_id" => $batchdata->ccm_id,
				"non_ccm_id" => $batchdata->non_ccm_id,
				"parent_pk_id" => ($updatebatch)?NULL:$batchpk,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			
			if($updatebatch){
				$datatosavebatch[$this->input->post("location_type")] = $this->input->post("location");
				$this->common->update_record("epi_stock_batch",$datatosavebatch,array("pk_id"=>$batchpk));
				//print_r($this->db->last_query());;
				$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
				$vvm_stage = $detaildata->vvm_stage;
				$item_unit_id = $detaildata->item_unit_id;
				$batchid = $batchpk;
			}else{
				
				$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
			}
			$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
			if(!empty($detaildata)){
				$vvm_stage = $detaildata->vvm_stage;
				$item_unit_id = $detaildata->item_unit_id;
			}else{
				$vvm_stage = $this->input->post("vvm_stage");
				$item_unit_id = $this->input->post("item_unit_id");
			}
			$datatosavedetail = array(
				"quantity" => $this->input->post("quantity"),
				"vvm_stage" => $vvm_stage ,
				"is_received" => 0,
				"stock_master_id" => $recid,
				"stock_batch_id" => $batchid,
				"adjustment_type" => $this->input->post("type"),
				"item_unit_id" => $item_unit_id,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
			$newquantity = ($this->input->post("transactionnature")=="1")?($batchdata->quantity):($batchdata->quantity)-($this->input->post("quantity"));
			if($updatebatch==0){
			//update quantity in old batch
			$datatoupdatebatch = array(
				"quantity" => $newquantity,
				"last_update" => date("Y-m-d H:i:s")
			);
			if($newquantity < 1)
				$datatoupdatebatch['status']='Finished';
			$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$batchpk));
			}
			
			//set history
			$masterpk = $recid;
			$this->save_all_history($masterpk);
			
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$msg = "Some error exist, DB Query Fails.";
			}
			else{
				$rowdata = $this->common->get_info("epi_stock_master",NULL,NULL,"transaction_number",array("pk_id"=>$recid));
				$msg="Adjustment has been saved successfully! Your adjustment number is ".$rowdata->transaction_number;
			}
			createTransactionLog("Add Adjustment Save", $subTitle. " - Save Detail of Add Adjustment, ($msg)");
			$this -> session -> set_flashdata('message',$msg);
			redirect(base_url("stockAdjustment"));
		}
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_stock_adjust_batch
	@ Description:   This function will save new batch posted from adjustment form into database and make transactions accordingly
	*/
	public function save_stock_adjust_batch(){
		$username = $this->session->userdata("username");
		$this->form_validation->set_rules('product', 'Product', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('batch_numb','Batch Number','trim|required');
		$this->form_validation->set_rules('production_date','Production Date','trim|required|valid_date[Y-m-d]');
		$this->form_validation->set_rules('expiry_date','Expiry Date','trim|required|valid_date[Y-m-d]');
		$this->form_validation->set_rules('manufacturer', 'Manufacturer', 'trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('vvm_type','VVM Type','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('unit_price','Unit Price (PKR)','trim|required|decimal|greater_than[0.00]');
		if ($this->form_validation->run() == FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = strip_tags(validation_errors());
			$response["data"] = array();
		}
		else
		{
			$this->db->trans_start();
			$datatosavebatch = array(
				"number" => $this->input->post("batch_numb"),
				"batch_master_id" => NULL,
				"expiry_date" => $this->input->post("expiry_date"),
				"quantity" => 0,
				"unit_price" => $this->input->post("unit_price"),
				"production_date" => $this->input->post("production_date"),
				"last_update" => date("Y-m-d H:i:s"),
				"item_pack_size_id" => $this->input->post("product"),
				"status" => 'Running',
				"vvm_type_id" => $this->input->post("vvm_type"),
				"stakeholder_id" => $this->input->post("manufacturer"),
				"warehouse_type_id" => $this->session->curr_wh_type,
				"code" => $this->session->curr_wh_code,
				"created_by" => $username,
				"created_date" => date("Y-m-d H:i:s")
			);
			$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$response["result"] = "false";
				$response["msg"] = "Some error exist, DB Query Fails.";
				$response["data"] = array();
			}
			else{
				$response["result"] = "true";
				$response["msg"] = "New Batch Added.";
				$response["batch_id"]=$batchid;
				$response["product"]=$this->input->post("product");
				$response["data"] = array();
			}
		}
		echo json_encode($response,true);
	}
	public function get_batch_Adjustment_detail()
	{
		$batchid=$_REQUEST['batch_id'];
		$data=$this->invn->get_batch_Adjustment_detail($batchid);
		echo json_encode($data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      del_invn_adjustment
	@ Description:   This function will delete batch Adjustment entity
	*/
	public function del_invn_adjustment(){
		$subTitle ="(Vaccine Managment) Adjustment - Search, Delete Adjustment";
		$data['subtitle']=$subTitle;
		$batchid = $this->input->post("batch");
		$masterid = $this->input->post("master");
		$adjusmentnum = $this->input->post("adjusmentnum");
		$this->db->trans_start();
		$transactioninfo = $this->common->get_info("epi_stock_master",NULL,NULL,"epi_transaction_types.nature",array("epi_stock_master.pk_id"=>$masterid),NULL,NULL,array("table"=>"epi_transaction_types","tablecol"=>"pk_id","id"=>"transaction_type_id"));
		$quantitytoupdate = $this->common->get_info("epi_stock_batch",NULL,NULL,"quantity,parent_pk_id",array("pk_id"=>$batchid,"batch_master_id" => $masterid));
		//epi_stock_detial data to check whether this adjustment  is during rec or not
		$checkadjustment = $this->common->get_info("epi_stock_detail",NULL,NULL,"rec_adjustment",array("stock_batch_id"=>$batchid,"stock_master_id" => $masterid));
		//here for call save delete_record_hsitory func for save del record in DB.
		$array_ids=array('master_id'=>$masterid,'batch_id'=>$batchid);
		$this->Save_delete_record_hsitory($array_ids);
		if(isset($quantitytoupdate->parent_pk_id)){
			$parentbatch = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$quantitytoupdate->parent_pk_id));
			$nature = $transactioninfo->nature;
			//update quantity in old batch and detail
			if($nature==0){
				$newquantity = ($parentbatch->quantity)+($quantitytoupdate->quantity);
			}else{
				$newquantity = ($parentbatch->quantity)/* -($quantitytoupdate->quantity) */;
			}
			$datatoupdatebatch = array(
				"quantity" => $newquantity,
				"last_update" => date("Y-m-d H:i:s"),
				"status"=>'Stacked'
			);
			$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$quantitytoupdate->parent_pk_id));
			$datatoupdatedetail = array(
				"quantity" => $newquantity
			);
			$this->common->update_record("epi_stock_detail",$datatoupdatedetail,array("stock_batch_id"=>$quantitytoupdate->parent_pk_id));
			if($checkadjustment->rec_adjustment==1)
			{
				//working here to update batch history and detail table QTy on base of batch_id=parent_pk_id
				$datatoupdatebatchhistory = array( "last_update" => date("Y-m-d H:i:s"));
				$this->db->set('quantity', 'quantity+'.$quantitytoupdate->quantity,FALSE);
				$this->db->where('batch_id',$quantitytoupdate->parent_pk_id);
				$this->db->update('epi_stock_batch_history',$datatoupdatebatchhistory);
				//fro detail history
				$this->db->set('quantity', 'quantity+'.$quantitytoupdate->quantity,FALSE);
				$this->db->where('stock_batch_id',$quantitytoupdate->parent_pk_id);
				$this->db->update('epi_stock_detail_history');
				$response["adjmsg"]="This Will Add Stock in  Received Voucher and in current Stock of that Vaccine.As It's Adjusted While Receiving Voucher.! ";
			}
		}
		$this->common->delete_record_multiple_colum("epi_stock_detail",array("stock_batch_id"=>$batchid,"stock_master_id" => $masterid));
		$this->common->delete_record_multiple_colum("epi_stock_batch",array("pk_id"=>$batchid,"batch_master_id" => $masterid));
		//count remaining records of batch for master
		$totalrecords = $this->common->count_record("epi_stock_batch",array("batch_master_id"=>$masterid));
		if($totalrecords>0){
			//update count in master table
			$datatoupdate = array(
				"transaction_counter" => $totalrecords,
				"updated_date" => date("Y-m-d H:i:s")
			);
			$this->common->update_record("epi_stock_master",$datatoupdate,array("pk_id"=> $masterid));
			$this->common->update_record("epi_stock_master_history",$datatoupdate,array("master_id"=> $masterid));
			//delete history of adjustments for this batch and its details only.
			$this->del_all_history(NULL,$batchid);
		}else{
			$this->common->delete_record_multiple_colum("epi_stock_master",array("pk_id"=> $masterid));
			//delete history of adjustments for this master
			$this->del_all_history($masterid);
		}
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE)
		{
			$response["result"] = "false";
			$response["msg"] = "Some error exist, Record(s) cannot be deleted.";
			$response["data"] = array();
		}
		else{
			$response["result"] = "true";
			$response["msg"] = "Record Deleted Sucessfully!!";
			$response["data"] = array();
		}
		//}
		echo json_encode($response,true);
		createTransactionLog("Search Adjustment", $subTitle." -  After search data Deleted Data, Batchid($batchid),Masterid($masterid),Adjustment Number($adjusmentnum)");
	}
	public function get_batch_detail()
	{
		$product=$_REQUEST['product'];
		$transdate=$_REQUEST['transdate'];
		$nature=$_REQUEST['nature'];
		$data=$this->invn->get_batch_detail($product,$transdate,$nature);
		//print_r($data);exit;
		if($data){
				$resultarr["mnfctrhtml"] = get_options_html($data,true,array("batchexp"=>"expirydate","activity"=>"activity","masterid"=>"masterid","location"=>"locinfo"));
			}else{
				$resultarr["mnfctrhtml"] = $data;
			}
		
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_vvm_update
	@ Description:   This function will update vvm stage of a batch into database and make transactions accordingly
	*/
	public function stock_vvm_update(){
		$username = $this->session->userdata("username");
		$this->form_validation->set_rules('vvm_stage','VVM Stage','trim|required|is_natural|greater_than[0]');
		$this->form_validation->set_rules('quantity','Quantity','trim|required|is_natural|greater_than[0]');
		if ($this->form_validation->run() == FALSE)
		{
			$this->stock_vvm_management();
		}
		else
		{
			$batchpk = $this->input->post("batch");
			$batchdata = $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("pk_id"=>$batchpk));
			if($batchdata){
				$newquantity = ($batchdata->quantity - $this->input->post("quantity"));
				if($newquantity>=0){
					$this->db->trans_start();
					$datatosavebatch = array(
						"number" => $batchdata->number,
						"batch_master_id" => $batchdata->batch_master_id,
						"expiry_date" => $batchdata->expiry_date,
						"quantity" => $this->input->post("quantity"),
						"status" => 'Stacked',
						"unit_price" => $batchdata->unit_price,
						"production_date" => $batchdata->production_date,
						"last_update" => date("Y-m-d H:i:s"),
						"item_pack_size_id" => $batchdata->item_pack_size_id,
						"vvm_type_id" => $batchdata->vvm_type_id,
						"stakeholder_id" => $batchdata->stakeholder_id,
						"warehouse_type_id" => $batchdata->warehouse_type_id,
						"code" => $batchdata->code,
						"created_by" => $username,
						"created_date" => date("Y-m-d H:i:s"),
						"ccm_id" => $batchdata->ccm_id,
						"non_ccm_id" => $batchdata->non_ccm_id,
						"parent_pk_id" => $batchpk,
					);
					$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
					$detaildata = $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_batch_id"=>$batchpk));
					$datatosavedetail = array(
						"quantity" => $this->input->post("quantity"),
						"temporary" => $detaildata->temporary,
						"vvm_stage" => $this->input->post("vvm_stage"),
						"is_received" => $detaildata->is_received,
						"adjustment_type" => $detaildata->adjustment_type,
						"stock_master_id" => $detaildata->stock_master_id,
						"stock_batch_id" => $batchid,
						"item_unit_id" => $detaildata->item_unit_id,
						"created_by" => $username,
						"created_date" => date("Y-m-d H:i:s")
					);
					$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
					//update quantity in old batch
					$datatoupdatebatch = array(
						"quantity" => $newquantity,
						"last_update" => date("Y-m-d H:i:s")
					);
					$this->common->update_record("epi_stock_batch",$datatoupdatebatch,array("pk_id"=>$batchpk));
					$datatoupdatedetail = array(
						"quantity" => $newquantity
					);
					$this->common->update_record("epi_stock_detail",$datatoupdatedetail,array("stock_batch_id"=>$batchpk));
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE)
					{
						$msg = "Some error exist, DB Query Fails.";
					}
					else{
						$msg = "VVM Stage of provided quantity has been changed successfully!";
						createTransactionLog("VVM Management", $subTitle." - ($msg)");
					}
				}else{
					$msg = "Quantity not Available!!";
				}
			}else{
				$msg = "Batch Does Not Exist!!";
			}
		}
		$this -> session -> set_flashdata('message',$msg);
		redirect(base_url("vvmManagement"));
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_store_locations
	@ Description:   Returns Warehouse locations depending upon warehouse type and procode if posted.
	*/
	public function get_store_locations(){
		$to_warehouse_type_id = $this->input->post("to_warehouse_type_id");
		$warehouse_procode = $this->input->post("warehouse_procode");
		$html = '';
		switch($to_warehouse_type_id){
			case 1:
				$html = '<option value="1" >Federal Vaccine Store</option>';
				break;
			case 2:
				$provinces = $this->common->fetchall("provinces",NULL,"procode as id,province || ' EPI Store' as name",array("procode"=>$warehouse_procode),NULL,array("by"=>"province","type"=>"asc"));
				$html = get_options_html($provinces,true);
				break;
			case 3:
				echo '';
				break;
			case 4:
				$sessionwhtype = $this->session->curr_wh_type;
				$whr["province"] = $warehouse_procode;
				if($sessionwhtype==4){
					$whr["distcode"] = $this->session->District;
				}
				/* if($sessionwhtype==5){
					$whr["distcode"] = $this->session->District;
				} */
				$districts= $this->common->fetchall("districts",NULL,"distcode as id,'District ' || district || ' Store' as name",$whr/* array("province"=>$warehouse_procode) */,NULL,array("by"=>"district","type"=>"asc"));
				$html = get_options_html($districts,true);
				break;
			case 5:
				echo '';
				break;
			case 6:
				$sessionwhtype = $this->session->curr_wh_type;
				$whr["procode"] = $warehouse_procode;
				if($sessionwhtype==4){
					$whr["distcode"] = $this->session->curr_wh_code;
				}
				if($sessionwhtype==5){
					$whr["tcode"] = $this->session->curr_wh_code;
				}
				$unioncouncils= $this->common->fetchall("unioncouncil",NULL,"uncode as id,'UC ' || un_name || ' Store' as name",$whr,NULL,array("by"=>"un_name","type"=>"asc"));
				$html = get_options_html($unioncouncils,true);
				break;
			case 7:
				$html = get_funding_sources(true);
				break;
			default:
				echo '';
				break;
		}
		$resultarr["optionshtml"] = $html;
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_products
	@ Description:   Returns Products(item_name) from epi_item_pack_sizes depending upon activity type id posted
	*/
	public function get_invn_products(){
		$activityid = $this->input->post("activity");
		$createoptions = ($this->input->post("createoptions"))?$this->input->post("createoptions"):false;
		$resultarr = array();
		if($activityid>0){
			$datafromdb = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,item_category_id,item_unit_id,itemunitname(item_unit_id) as unitname,cr_table_row_numb as rownum,number_of_doses",array("activity_type_id"=>$activityid,"item_category_id !="=>4),NULL,array("by"=>"list_rank","type"=>"ASC"));
			if($datafromdb and $createoptions){
				//function call to create options
				$resultarr["optionshtml"] = get_options_html($datafromdb,true,array("categoryid"=>"item_category_id","unitid"=>"item_unit_id","unittitle"=>"unitname","formrownum"=>"rownum","doses"=>"number_of_doses"));//
			}else{
				$resultarr = $datafromdb;
			}
		}
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_related_products
	@ Description:   Returns Products(item_name) from epi_item_pack_sizes depending upon activity type id and product to check same group item
	*/
	public function get_invn_related_products(){
		$subTitle ="(Vaccine Managment) Purpose Transfer";
		$data['subtitle']=$subTitle;
		$activityid = $this->input->post("activity");
		$byproduct = $this->input->post("product");
		$createoptions = ($this->input->post("createoptions"))?$this->input->post("createoptions"):false;
		$resultarr = array();
		if($activityid>0){
			$datafromdb = $this->invn->get_related_products($activityid,$byproduct);
			if($datafromdb and $createoptions){
				//function call to create options
				$resultarr["optionshtml"] = get_options_html($datafromdb,true,array("categoryid"=>"item_category_id","unitid"=>"item_unit_id","unittitle"=>"unitname"));
			}else{
				$resultarr = $datafromdb;
			}
		}
		createTransactionLog("Purpose Transfer", $subTitle." - Update purpose File");
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_manufacturer
	@ Description:   Returns Manufacturer Name from epi_stakeholder_item_pack_sizes and epi_stakeholders depending upon product id posted
	*/
	public function get_invn_manufacturer(){
		$productid = $this->input->post("product");
		$createoptions = ($this->input->post("createoptions"))?$this->input->post("createoptions"):false;
		$resultarr = array();
		if($productid>0){
			$datafromdb = $this->common->fetchall("epi_stakeholder_item_pack_sizes",array("table"=>"epi_stakeholders","id"=>"stakeholder_id","tablecol"=>"pk_id"),
			"epi_stakeholders.pk_id as id,epi_stakeholders.stakeholder_name as name",array("epi_stakeholder_item_pack_sizes.item_pack_size_id"=>$productid),
			NULL,array("by"=>"stakeholder_name","type"=>"asc"));
			if($datafromdb and $createoptions){
				//function call to create options
				$resultarr["optionshtml"] = get_options_html($datafromdb,true);
			}else{
				$resultarr = $datafromdb;
			}
		}
		
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_priority_details
	@ Description:   Returns Manufacturer | Batch | Quantity | Priority from epi_stock_batch depending upon product id posted and user loggedin, sort by priority
	*/
	public function get_invn_priority_details(){
		$productid = $this->input->post("product");
		$stockissue = ($this->input->post("stockissue"))?$this->input->post("stockissue"):false;
		$createoptions = ($this->input->post("createoptions"))?$this->input->post("createoptions"):false;
		$withzeroquantity = ($this->input->post("withzeroquantity"))?$this->input->post("withzeroquantity"):false;
		$tdate=$this->input->post("transdate");
		$tdate.=" 23:59:59";
		$transdate = ($this->input->post("transdate"))?$tdate:date("Y-m-d H:i:s");
		//echo $tdate;exit;
		$resultarr = array();
		if($productid>0){
			$mnfctrdatafromdb = $this->invn->get_invn_priority_details($productid,$withzeroquantity,$transdate,$stockissue);
			if($mnfctrdatafromdb and $createoptions){
				$resultarr["mnfctrhtml"] = get_options_html($mnfctrdatafromdb,true,array("batchexp"=>"expirydate","activity"=>"activity","masterid"=>"masterid","location"=>"locinfo"));
			}else{
				$resultarr["mnfctrhtml"] = $mnfctrdatafromdb;
			}
		}
		//print_r($this->db->last_query());exit;
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      get_invn_vvmStage
	@ Description:   Returns vvm Stages of product depending upon product id posted
	*/
	public function get_invn_vvmStage(){
		$subTitle ="(Vaccine Managment) VVM Management";
		$data['subtitle']=$subTitle;
		$productid = $this->input->post("product");
		$createoptions = ($this->input->post("createoptions"))?$this->input->post("createoptions"):false;
		$resultarr = $datafromdb = array();
		if($productid>0){
			/* $numbersforproducts = array(1,5,7,8,9,11,13,27,29,35);
			$usedforproducts = array(2,3,4,12,22,23,24,25,26,30,31,32,33,34);
			if(in_array($productid,$numbersforproducts)){
				$datafromdb = array(
					array("id"=>1,"name"=>1),
					array("id"=>2,"name"=>2),
					array("id"=>3,"name"=>3),
					array("id"=>4,"name"=>4)
				);
			}else if(in_array($productid,$usedforproducts)){
				$datafromdb = array(
					array("id"=>1,"name"=>"Usable"),
					array("id"=>3,"name"=>"Unusable")
				);
			} */
			$datafromdb = $this->common->fetchall("vvm_stages",array("table"=>"epi_item_pack_sizes","tablecol"=>"vvm_stage_type","id"=>"type"),"vvm_stages.name as name,vvm_stages.value as id",array("epi_item_pack_sizes.pk_id"=>$productid),NULL,array("by"=>"list_rank","type"=>"ASC"));
			if(isset($datafromdb) and $createoptions){
				//function call to create options
				$resultarr["optionshtml"] = get_options_html($datafromdb,true);
			}else{
				$resultarr = $datafromdb;
			}
		}
		createTransactionLog("VVM Management", $subTitle." - Update VVm Stage, Product Id ($productid)");
		echo json_encode($resultarr);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_all_history
	@ Description:   This function inserts history data into all 3 tables depending upon master id in parameter.
	*/
	public function save_all_history($masterid){
		$rowdata = $this->common->get_info("epi_stock_master",NULL,NULL,"*",array("pk_id"=>$masterid));
		//create history for master,batch nd detail
		//into master history tables
		$masterhistory =(array) $rowdata;
		unset($masterhistory["pk_id"]);
		$masterhistory["master_id"] = $masterid;
		$this->common->insert_record("epi_stock_master_history",$masterhistory);
		//into batch history tables
		$batchdata = $this->common->fetchall("epi_stock_batch",NULL,"*",array("batch_master_id"=>$masterid));
		foreach($batchdata as $onebatch){
			$onebatch["batch_id"] = $onebatch["pk_id"];unset($onebatch["pk_id"]);
			$this->common->insert_record("epi_stock_batch_history",$onebatch);
		}
		//into detail history tables
		$detaildata = $this->common->fetchall("epi_stock_detail",NULL,"*",array("stock_master_id"=>$masterid));
		foreach($detaildata as $onedetail){
			$onedetail["detail_id"] = $onedetail["pk_id"];unset($onedetail["pk_id"]);
			$this->common->insert_record("epi_stock_detail_history",$onedetail);
		}
		//end
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      del_all_history
	@ Description:   This function delete history data from all 3 tables depending upon master id in parameter.
	*/
	public function del_all_history($masterid,$batchid=NULL){
		//delete history for master,batch nd detail
		if($batchid){
			//delete from batch history tables
			$this->common->delete_record("epi_stock_batch_history", $batchid, "pk_id");
			//idelete from detail history tables
			$this->common->delete_record("epi_stock_detail_history", $batchid, "stock_batch_id");
			//end
		}else{
			//from master history tables
			$this->common->delete_record("epi_stock_master_history", $masterid, "master_id");
			//delete from batch history tables
			$this->common->delete_record("epi_stock_batch_history", $masterid, "batch_master_id");
			//idelete from detail history tables
			$this->common->delete_record("epi_stock_detail_history", $masterid, "stock_master_id");
			//end
		}
	}
	public function get_fac_store_locations(){
		$warehouse_uccode = $this->input->post("warehouse_uccode");
		$html = '';
		if($warehouse_uccode){
			$sessionwhtype = $this->session->curr_wh_type;
			$whr["uncode"] = $warehouse_uccode;
			if($sessionwhtype==4){
				$whr["distcode"] = $this->session->curr_wh_code;
			}
			$whr["hf_type"] ='e';
			$facilities= $this->common->fetchall("facilities",NULL,"facode as id,'Facility ' || fac_name || ' Store' as name",$whr,NULL,array("by"=>"fac_name","type"=>"asc"));
			//print_r($this->db->last_query());exit;
			$html = get_options_html($facilities,true);
		}
		//print_r($this->db->last_query());exit;
		$resultarr["optionshtml"] = $html;
		echo json_encode($resultarr);
	}
	public function get_batch_location()
	{
		$batch_id=$_REQUEST['batch_id'];
		$data=$this->invn->get_batch_location($batch_id);
		echo json_encode($data);
	}
	/**	Function to save each delete record history in DB	**/
	public function Save_delete_record_hsitory($arrays_id)
	{
			//code for maintain deleted voucher batch record
			//master record
			$masterdata= $this->common->get_info("epi_stock_master",NULL,NULL,NULL,array("pk_id"=> $arrays_id['master_id']));
			$delmasterdata= $this->common->get_info("delete_epi_stock_master",NULL,NULL,NULL,array("pk_id"=> $arrays_id['master_id']));
			if(empty($delmasterdata))
			{
			$masterdata->created_date=date("Y-m-d H:i:s");
			$masterdata->updated_date=date("Y-m-d H:i:s");
			unset($masterdata->transaction_counter);
			$this->db->set('transaction_counter',1);
			$a=$this->db->insert('delete_epi_stock_master',$masterdata);
			}else
			{
				unset($masterdata->transaction_counter);
				//setting here transaction_counter
				$this->db->set('transaction_counter',"transaction_counter+1",FALSE);
				$this->db->where('pk_id',$arrays_id['master_id']);
				$masterdataupdate=array('updated_date'=>date("Y-m-d H:i:s"));
				$this->db->update('delete_epi_stock_master',$masterdataupdate);
			}
			$batchdata= $this->common->get_info("epi_stock_batch",NULL,NULL,NULL,array("batch_master_id"=> $arrays_id['master_id'],'pk_id'=>$arrays_id['batch_id']));
			$batchdata->created_date=date("Y-m-d H:i:s");
			$this->db->insert('delete_epi_stock_batch',$batchdata);
			$detaildata= $this->common->get_info("epi_stock_detail",NULL,NULL,NULL,array("stock_master_id"=> $arrays_id['master_id'],'stock_batch_id'=>$arrays_id['batch_id']));
			$detaildata->created_date=date("Y-m-d H:i:s");
			$this->db->insert('delete_epi_stock_detail',$detaildata);
			//end/
	}
	public function stock_receive_from_supplier_list(){
		$transac_id_type=1;
		$data['data']['supplierStock'] =$this -> invn -> get_received_stock_list_for_supplier($transac_id_type);
		//print_r($data['data']['supplierStock']);exit;
		$data['fileToLoad'] = 'inventory_management/stock_receive_from_supplier_list';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive List (Supplier)';
		$this->load->view('template/epi_template',$data);
	}
}
?>