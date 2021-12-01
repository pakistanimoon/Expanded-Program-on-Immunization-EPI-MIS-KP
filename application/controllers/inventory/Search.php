<?php
class Search extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('epi_reports_helper');
		authentication();
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Inventory_model',"invn");
		$this -> load -> model ('Common_model',"common");
	}
	/* 
	* Stock Receive Search
	*/
	public function stock_receive_search()
	{
		 if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Receive.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		} 
		$data['data'] =NULL;
		if($this -> input -> post('date_from') && $this -> input -> post('date_to'))
		{
			$data['data']['date_from'] = $this -> input -> post('date_from');
			$data['data']['date_to'] = $this -> input -> post('date_to');
			if($this -> input -> post('from_warehouse_type_id') && $this -> input -> post('from_warehouse_type_id') > 0)
				$data['data']['from_warehouse_type_id'] = $this -> input -> post('from_warehouse_type_id');
			if($this -> input -> post('activity') && $this -> input -> post('activity') > 0)
				$data['data']['activity']  = $this -> input -> post('activity');
			if($this -> input -> post('product') && $this -> input -> post('product') > 0)
				$data['data']['product'] = $this -> input -> post('product');
			if($this -> input -> post('search_type') && $this -> input -> post('search_type') != ''){
				$data['data']['search_type'] = $this -> input -> post('search_type');
				$data['data']['search_key'] = $this -> input -> post('search_key');
			}
			$posteddateto = date("Y-m-d",strtotime($this -> input -> post('date_to').' + 1 day'));
			$result=$this->invn->stockRecieve($this -> input -> post('date_from'),$posteddateto,$this -> input -> post('from_warehouse_type_id'),$this -> input -> post('activity'),$this -> input -> post('product'),$this -> input -> post('search_type'),$this -> input -> post('search_key'));
			$data['data']['searchResult']=$result['data']['search'];
			
		}
		//echo $this -> db -> last_query();exit;
		$data['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
		$data['fileToLoad'] = 'inventory_management/stock_receive_search';
		$data['pageTitle'] = 'EPI-MIS | Stock Receive - Search';
		$this->load->view('template/epi_template',$data);
	}
	/*Author		:		Omer Butt
	* Function 		:		Stock_Receive_Search_RecNo 
	* Description	:		This function will get list of products details that lies in current clicked Rec No. From tbl Column
	*/
	public	function Stock_Receive_Search_RecNo()
	{
		    $recNo=$this->uri->segment(2);
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['recNo'] =  $recNo;
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockRecieve($_REQUEST['date_from'],$posteddateto,$_REQUEST['from_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],$recNo);
			$data['data']['searchResult']=$result['data']['search'];
			$allproducts = array_column($data['data']['searchResult'], 'itemname');
			$uniqueprod = array_unique($allproducts);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_receive_search_recNo';
			$data['pageTitle'] = 'EPI-MIS | Stock Receive - Search RecNo';
			$this->load->view('template/reports_template',$data);	
	}
	/*Author		:		Omer Butt
	* Function 		:		Stock_Receive_Search_SummaryProd
	* Description	:		This function will get  products Wise Summary on base of parameters . 
	*/
	public	function Stock_Receive_Search_SummaryProd()
	{
		   
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['summaryType'] =  $_REQUEST['summaryType'];
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockRecieve($_REQUEST['date_from'],$posteddateto,$_REQUEST['from_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],NULL,$data['data']['summaryType']);
			$data['data']['searchResult']=$result['data']['search'];
			if($data['data']['summaryType']=="Product")
			{
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			//Loc Wise Summary
			else if ($data['data']['summaryType']=="Location")
			{
				
				foreach($data['data']['searchResult'] as $key=>$value)
				{
					$allproducts[]=get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']);	
				}
				
			}
			else{
			$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			$uniqueprod = array_unique($allproducts);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_receive_search_SummaryProd';
			$data['pageTitle'] = 'EPI-MIS | Stock Receive - Search SummaryProd';
			$this->load->view('template/reports_template',$data);	
	}
	/*Author		:		Omer Butt
	* Function 		:		Stock_Receive_Search_DetailProd
	* Description	:		This function will get  Stock Receive Wise Detail  on base of parameters . (None / Product/ Location Wise)
	*/
	public	function Stock_Receive_Search_DetailProd()
	{
		    if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Receive.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		}
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['groupBy'] =  $_REQUEST['groupBy'];
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockRecieve($_REQUEST['date_from'],$posteddateto,$_REQUEST['from_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],NULL,NULL,$data['data']['groupBy']);
			$data['data']['searchResult']=$result['data']['search'];
			if($data['data']['groupBy']=="Product")
			{
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			//Loc Wise Summary
			else if ($data['data']['groupBy']=="Location")
			{
				foreach($data['data']['searchResult'] as $key=>$value)
				{
					$allproducts[]=get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']);	
				}
			}
			//Detail :None
			else
			{
				// any one 
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			$uniqueprod = array_unique($allproducts);
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['fileToLoad'] = 'inventory_management/stock_receive_search_DetailProd';
			$data['pageTitle'] = 'EPI-MIS | Stock Receive - Search Detail Product';
			$this->load->view('template/reports_template',$data);	
	}
	/* 
	* Stock Issue Search
	*/
	public function stock_issue_search()
	{
		 if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Issue.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		} 
		$data['data'] =NULL;
		if($this -> input -> post('date_from') && $this -> input -> post('date_to'))
		{
			$data['data']['date_from'] = $this -> input -> post('date_from');
			$data['data']['date_to'] = $this -> input -> post('date_to');
			$posteddateto = date("Y-m-d",strtotime($this -> input -> post('date_to').' + 1 day'));
			if($this -> input -> post('to_warehouse_type_id') && $this -> input -> post('to_warehouse_type_id') > 0)
				$data['data']['to_warehouse_type_id'] = $this -> input -> post('to_warehouse_type_id');
			if($this -> input -> post('activity') && $this -> input -> post('activity') > 0)
				$data['data']['activity'] = $this -> input -> post('activity');
			if($this -> input -> post('product') && $this -> input -> post('product') > 0)
				$data['data']['product'] =  $this -> input -> post('product');
			if($this -> input -> post('search_type') && $this -> input -> post('search_type') != ''){
				$data['data']['search_type'] = $this -> input -> post('search_type');
				$data['data']['search_key'] = $this -> input -> post('search_key');
				
			}
			$result=$this->invn->stockIssue($this -> input -> post('date_from'),$posteddateto,$this -> input -> post('to_warehouse_type_id'),$this -> input -> post('activity'),$this -> input -> post('product'),$this -> input -> post('search_type'),$this -> input -> post('search_key'));
			$data['data']['searchResult']=$result['data']['issue'];
		}
		//print_r($this->db->last_query());exit;
		$data['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
		$data['fileToLoad'] = 'inventory_management/stock_issue_search';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search';
		$this->load->view('template/epi_template',$data);
	}
	public function stock_issue_dispatch_report()
	{
		$username = $this->session->userdata("username");
		$whrarr = array("transaction_number"=>'TEMP',"created_by"=>$username,"draft"=>1,"transaction_type_id"=>2);
		$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);
		if($countdrafts){
			$data['data']["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
			$data['data']["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("batch_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
			$data['data']["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",NULL,"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id),NULL,array("by"=>"pk_id","type"=>"desc"));
		}
			$allproducts = array_column($data['data']['draftdata']["batch"],'item_pack_size_id');
			$uniqueprod = array_unique($allproducts);
			$data['data']['uniqueProd']=$uniqueprod;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/stock_issue_dispatch_report';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue/Dispatch';
		$this->load->view('template/reports_template',$data);
	}
	public function stock_issue_dispatch_tranNo()
	{
			$tranNo=$_REQUEST['tno'];
			$data['data']['issueNo'] =  $tranNo;
			$this -> db -> select('master.pk_id,batch.pk_id,detail.pk_id,master.transaction_date,master.transaction_number,master.transaction_reference,get_product_name(batch.item_pack_size_id) itemname,(case when batch.ccm_id IS NOT NULL then getccmshortname (ccm_id) else noncclocationname(batch.non_ccm_id) end) as storelocation,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,get_epi_item_dose_per_vials(batch.item_pack_size_id) doses,batch.number,stackholdername(batch.stakeholder_id) as manufacturer,batch.quantity,itemunitname(detail.item_unit_id) as unit,batch.expiry_date,master.created_date,warehousetypename(CAST(master.from_warehouse_type_id AS INTEGER)) as recievedFrom,master.from_warehouse_type_id,master.from_warehouse_code,master.to_warehouse_type_id,master.to_warehouse_code');
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
			
			$data['fileToLoad'] = 'inventory_management/stock_issue_search_issueNo';
			$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search IssueNo';
			$this->load->view('template/reports_template',$data);
	}
	public function stock_issue_search_issueNo()
	{
			$issueNo=$this->uri->segment(2);
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['issueNo'] =  $issueNo;
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockIssue($_REQUEST['date_from'],$posteddateto,$_REQUEST['to_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],$issueNo);
			$data['data']['searchResult']=$result['data']['issue'];
			$allproducts = array_column($data['data']['searchResult'], 'itemname');
			$uniqueprod = array_unique($allproducts);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_issue_search_issueNo';
			$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search IssueNo';
			$this->load->view('template/reports_template',$data);	
	}
		public function stock_issue_search_SummaryProd()
	{
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['summaryType'] =  $_REQUEST['summaryType'];
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockIssue($_REQUEST['date_from'],$posteddateto,$_REQUEST['to_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],NULL,$data['data']['summaryType']);
			$data['data']['searchResult']=$result['data']['issue'];
			if($data['data']['summaryType']=="Product")
			{
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			//Loc Wise Summary
			else if ($data['data']['summaryType']=="Location")
			{
				
				foreach($data['data']['searchResult'] as $key=>$value)
				{
					$allproducts[]=get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']);	
				}
				
			}
			else{
			$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			$uniqueprod = array_unique($allproducts);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_issue_search_SummaryProd';
			$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search SummaryProd';
			$this->load->view('template/reports_template',$data);
	}
	
	function stock_issue_search_DetailProd(){
		    if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Receive.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		}
			$data['data']['date_from'] = $_REQUEST['date_from'];
			$data['data']['date_to'] =  $_REQUEST['date_to'];
			$data['data']['groupBy'] =  $_REQUEST['groupBy'];
			$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
			$result=$this->invn->stockIssue($_REQUEST['date_from'],$posteddateto,$_REQUEST['to_warehouse_type_id'],$_REQUEST['activity'],$_REQUEST['product'],$_REQUEST['search_type'],$_REQUEST['search_key'],NULL,NULL,$data['data']['groupBy']);
			$data['data']['searchResult']=$result['data']['issue'];
			if($data['data']['groupBy']=="Product")
			{
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			//Loc Wise Summary
			else if ($data['data']['groupBy']=="Location")
			{
				foreach($data['data']['searchResult'] as $key=>$value)
				{
					$allproducts[]=get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']);	
				}
			}
			//Detail :None
			else
			{
				// any one 
				$allproducts = array_column($data['data']['searchResult'], 'itemname');
			}
			$uniqueprod = array_unique($allproducts);
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['data']['uniqueProd']=$uniqueprod;
			$data['fileToLoad'] = 'inventory_management/stock_issue_search_DetailProd';
			$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search Detail Product';
			$this->load->view('template/reports_template',$data);	
	}
	/* 
	* Adjustment Search
	*/
	public function stock_adjustment_search()
	{
		 if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Adjustment.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		} 
		$data['data'] =NULL;
		$data['data']["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
		if($this -> input -> post('date_from') && $this -> input -> post('date_to'))
		{
			$data['data']['date_from'] = $this -> input -> post('date_from');
			$data['data']['date_to'] = $this -> input -> post('date_to');
			if($this -> input -> post('expiry') && $this -> input -> post('expiry') != NULL)
				$data['data']['expiry'] = $this -> input -> post('expiry');
			if($this -> input -> post('adjustment_type') && $this -> input -> post('adjustment_type') > 0)
				$data['data']['adjustment_type'] = $this -> input -> post('adjustment_type');
			if($this -> input -> post('adjustment_number') && $this -> input -> post('adjustment_number') != '')
				$data['data']['adjustment_number'] = $this -> input -> post('adjustment_number');
				if($this -> input -> post('batch') && $this -> input -> post('batch') != '')
				$data['data']['batch'] =  $this -> input -> post('batch');
			if($this -> input -> post('product') && $this -> input -> post('product') > 0)
				$data['data']['product'] =  $this -> input -> post('product');
			$posteddateto = date("Y-m-d",strtotime($this -> input -> post('date_to').' + 1 day'));
			$result=$this->invn->stock_adjustment($this -> input -> post('date_from'),$posteddateto,$this -> input -> post('expiry'),$this -> input -> post('adjustment_type'),$this -> input -> post('adjustment_number'),$this -> input -> post('batch'),$this -> input -> post('product'));
			$data['data']['searchResult']=$result['data']['adjustment'];
			
		}
		$data['fileToLoad'] = 'inventory_management/stock_adjustment_search';
		$data['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
		$data['pageTitle'] = 'EPI-MIS | Adjustment - Search';
		$this->load->view('template/epi_template',$data);
	}
	public function stock_adjustment_search_detail()
	{
		$data['data'] =NULL;
		$data['data']['date_from'] = $_REQUEST['date_from'];
		$data['data']['date_to'] =  $_REQUEST['date_to'];
		$expiry=$_REQUEST['expiry'];
		$batch=$_REQUEST['batch'];
		if($expiry=="undefined")
			$expiry="";
		if($batch=="null")
			$batch="";
		$data['data']["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
		$posteddateto = date("Y-m-d",strtotime($_REQUEST['date_to'].' + 1 day'));
		$result=$this->invn->stock_adjustment($_REQUEST['date_from'],$posteddateto,$expiry,$_REQUEST['adjustment_type'],$_REQUEST['adjustment_number'],$batch,$_REQUEST['product']);
		$data['data']['searchResult']=$result['data']['adjustment'];
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/stock_adjustment_search_detail';
		$data['pageTitle'] = 'EPI-MIS | Stock Adjustment - Search Detail';
		$this->load->view('template/reports_template',$data);	
	}
	public function stock_transfer_search($product=NULL,$date_from=NULL,$date_to=NULL)
	{
		 if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock_Transfer.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		} 	
		$data['data'] =NULL;
		if($this -> input -> post('date_from') && $this -> input -> post('date_to') )
		{
			$data['data']['date_from'] = $this -> input -> post('date_from');
			$data['data']['date_to'] = $this -> input -> post('date_to');
			if($this -> input -> post('product') && $this -> input -> post('product')!="")
			$data['data']['product'] =  $this -> input -> post('product');
			$posteddateto = date("Y-m-d",strtotime($this -> input -> post('date_to').' + 1 day'));
			//echo $posteddateto;exit;
			$result=$this->invn->stock_transfer($this -> input -> post('date_from'),$posteddateto,$this -> input -> post('product'));
			$data['data']['searchResult']=$result['data']['transfer'];
		}
		
			$data['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
			$data['fileToLoad'] = 'inventory_management/stock_transfer_search';
			$data['pageTitle'] = 'EPI-MIS | Stock Transfer Search';
			$this->load->view('template/epi_template',$data);
	}
	public function Stock_Transfer_Report()
	{
		$data['data'] =NULL;
		$data['data']['date_from'] =$date_from=$_REQUEST['date_from'];
		$data['data']['date_to'] = $date_to=$_REQUEST['date_to'];
		$data['data']['product'] =$product= $_REQUEST['product'];
		if($date_from && $date_to )
		{
			
			if($product && $product!="")
			$data['data']['product'] =  $product;
			$posteddateto = date("Y-m-d",strtotime($date_to.' + 1 day'));
			//echo $posteddateto;exit;
			$result=$this->invn->stock_transfer($date_from,$posteddateto,$product);
			$data['data']['searchResult']=$result['data']['transfer'];
		}
		
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_transfer_search_report';
			$data['pageTitle'] = 'EPI-MIS | Stock Transfer Search Report';
			$this->load->view('template/reports_template',$data);
	}
	
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      stock_batch_search
	@ Description:   Returns list of batches,status etc depending upon product id and other filter options posted
	*/
	public function stock_batch_search(){
		
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Batch_Management.xls");
			header("Pragma: no-cache");
			header("Expires: 0"); 
		} 
		$data['data']['priority'] = $priority = $this -> input -> post('priority');
		$data['data']['product'] = $product = $this -> input -> post('product');
		$data['data']['search_type'] = $searchtype = $this -> input -> post('search_type');
		$data['data']['search_key'] = $searchkey = $this -> input -> post('search_key');
		/* if($this -> input -> post('product') && $this -> input -> post('product') > 0){
			$data['data']['product'] = $product = $this -> input -> post('product');
		}
		if($this -> input -> post('search_type') && $this -> input -> post('search_type') != ''){
			$data['data']['search_type'] = $this -> input -> post('search_type');
			$data['data']['search_key'] = $this -> input -> post('search_key');
		} */
		
		$data['data']['searchResult'] = $this->invn->batchSearch($priority,$product,$searchtype,$searchkey);
		$data['exportIcons']=exportIcons($_REQUEST,NULL,'excel');
		$data['fileToLoad'] = 'inventory_management/stock_batch_management';
		$data['pageTitle'] = 'EPI-MIS | Stock Issue - Search';
		$this->load->view('template/epi_template',$data);
	}
	public function stock_batch_report()
	{
			$data['data']['product'] = $product=$_REQUEST['product'];
			$data['data']['search_key'] =$searchtype=  $_REQUEST['search_key'];
			$data['data']['search_type'] = $searchkey= $_REQUEST['search_type'];
			$data['data']['priority'] =  $priority=$_REQUEST['priority'];
			$data['data']['searchResult'] = $this->invn->batchSearch($priority,$product,$searchtype,$searchkey);
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_detail_report';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch - Search Detail';
			$this->load->view('template/reports_template',$data);
	}
	public function stock_batch_vacchine_summary()
	{
	//Vaccine Productstock_issue_dispatch_report
			$data['data']['searchResult'] = $this->invn->batch_summary('1');
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_Vaccine_summary';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch Vaccine Summary';
			$this->load->view('template/reports_template',$data);
	}
	public function stock_batch_wise_Summary()
	{
		$data['data']['searchResult'] = $this->invn->batch_wise_summary('1');
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/stock_batch_nbrwise_summary';
		$data['pageTitle'] = 'EPI-MIS | Stock Batch Vaccine Summary';
		$this->load->view('template/reports_template',$data);
		}
	public function stock_batch_manufacturer()
	{
		
			$data['data']['searchResult'] = $this->invn->batch_manufacturer();
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_Manufacturer';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch -Manufacturer';
			$this->load->view('template/reports_template',$data);
	}
	public function stock_receive() 
	{
		$data['data']['searchResult'] = $this->invn->recevie_vaccine();
		
		//print_r($data);exit;
		//$data['data']['exportIcons']  = exportIcons($_REQUEST);
		//$data['fileToLoad'] = ['inventory_management/stock_batch_Receive'];
	    $data['pageTitle'] = 'EPI-MIS | Stock Receive Report';
		$this->load->view('inventory_management/stock_batch_Receive',$data); 
	}
		public function stock_batch_Nonvacchine_summary()
	{
		//Non-Vaccine Product
			$data['data']['searchResult'] = $this->invn->batch_summary("'2','3'");
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_NonVaccine_summary';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch Non-Vaccine Summary';
			$this->load->view('template/reports_template',$data);
	}
			public function stock_batch_vacchine_priority()
	{
		
			$data['data']['searchResult'] = $this->invn->batch_priority('1');
			$allproducts= array_column($data['data']['searchResult'], 'itemname');
			$allpriority= array_column($data['data']['searchResult'], 'priority');
			$allactivitytype= array_column($data['data']['searchResult'], 'activity_type_id');
			$uniqueprod = array_unique($allproducts);
			$uniquepriority = array_unique($allpriority);
			$uniqueactivity = array_unique($allactivitytype);
			$data['data']['uniqueprod']=$uniqueprod;
			$data['data']['uniquepriority']=$uniquepriority;
			$data['data']['uniqueactivity']=$uniqueactivity;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_Vaccine_priority';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch Vaccine Priority Detail';
			$this->load->view('template/reports_template',$data);
	}
				public function stock_batch_nonvacchine_priority()
	{
		
			$data['data']['searchResult'] = $this->invn->batch_priority("'2','3'");
			$allproducts = array_column($data['data']['searchResult'], 'itemname');
			$allpriority = array_column($data['data']['searchResult'], 'priority');
			$uniqueprod = array_unique($allproducts);
			$uniquepriority = array_unique($allpriority);
			$data['data']['uniqueprod']=$uniqueprod;
			$data['data']['uniquepriority']=$uniquepriority;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = 'inventory_management/stock_batch_nonVaccine_priority';
			$data['pageTitle'] = 'EPI-MIS | Stock Batch Non-Vaccine Priority Detail';
			$this->load->view('template/reports_template',$data);
	}
}
?>