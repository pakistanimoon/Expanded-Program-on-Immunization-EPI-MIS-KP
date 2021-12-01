<?php
class Charts extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Inventory_model',"invn");
		$this -> load -> model ('Common_model',"common");
		$this -> load -> model ('Inventory_reports_model',"invnrep");
		$this -> load -> library('dashboardfilters');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      vacc_prod_curr_stock
	@ Description:   This function will open Graph/Chart containing information about current stock available of all vaccines.
	*/
	public function vacc_prod_curr_stock()
	{		
		$whtype = $this->input->post('warehouse_level');
		$whcode = $this->input->post('warehouse_store');
		
		$enddate = date("Y-m-d H:i:s");
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$whcode."',pk_id) as stock",array("item_category_id"=>'1'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		$defcolors = array("#0075c2","#f2c500","#2fb66c","#f45b00","#b1bd61");
		$barcolors = array();
		$brgraphdata = array();$count=0;
		foreach($items as $key=>$onerow){
			$brgraphdata[$key]["label"] = $onerow["name"];
			$brgraphdata[$key]["value"] = $onerow["stock"];
			if(isset($barcolors[$onerow["activityid"]])){
				$brgraphdata[$key]["color"] = $barcolors[$onerow["activityid"]];
			}else{
				$brgraphdata[$key]["color"] = $defcolors[$count];
				$barcolors[$onerow["activityid"]] = $defcolors[$count];
				$count++;
			}
		}
		echo json_encode($brgraphdata, JSON_NUMERIC_CHECK);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      non_vacc_prod_curr_stock
	@ Description:   This function will open Graph/Chart containing information about current stock available of all vaccines.
	*/
	public function non_vacc_prod_curr_stock()
	{
		$whtype = $this->input->post('warehouse_level');
		$whcode = $this->input->post('warehouse_store');
		
		$enddate = date("Y-m-d H:i:s");
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$whcode."',pk_id) as stock",array("item_category_id"=>'2'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		//echo $this->db->last_query();
		$defcolors = array("#0075c2","#f2c500","#2fb66c","#f45b00","#b1bd61");
		$barcolors = array();
		$brgraphdata = array();$count=0;
		foreach($items as $key=>$onerow){
			$brgraphdata[$key]["label"] = $onerow["name"];
			$brgraphdata[$key]["value"] = $onerow["stock"];
			if(isset($barcolors[$onerow["activityid"]])){
				$brgraphdata[$key]["color"] = $barcolors[$onerow["activityid"]];
			}else{
				$brgraphdata[$key]["color"] = $defcolors[$count];
				$barcolors[$onerow["activityid"]] = $defcolors[$count];
				$count++;
			}
		}
		echo json_encode($brgraphdata, JSON_NUMERIC_CHECK);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      diluent_prod_curr_stock
	@ Description:   This function will open Graph/Chart containing information about current stock available of all Diluent.
	*/
	public function diluent_prod_curr_stock()
	{
		$whtype = $this->input->post('warehouse_level');
		$whcode = $this->input->post('warehouse_store');
		
		$enddate = date("Y-m-d H:i:s");
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$whcode."',pk_id) as stock",array("item_category_id"=>'3'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		$defcolors = array("#0075c2","#f2c500","#2fb66c","#f45b00","#b1bd61");
		$barcolors = array();
		$brgraphdata = array();$count=0;
		foreach($items as $key=>$onerow){
			$brgraphdata[$key]["label"] = $onerow["name"];
			$brgraphdata[$key]["value"] = $onerow["stock"];
			if(isset($barcolors[$onerow["activityid"]])){
				$brgraphdata[$key]["color"] = $barcolors[$onerow["activityid"]];
			}else{
				$brgraphdata[$key]["color"] = $defcolors[$count];
				$barcolors[$onerow["activityid"]] = $defcolors[$count];
				$count++;
			}
		}
		echo json_encode($brgraphdata, JSON_NUMERIC_CHECK);
	}

 	/*public function detail_vacc_distribution()
	{
		echo 'detail report';  exit; 
		$monthfrom	= $this->input->post('monthfrom');
		$monthto	= $this->input->post('monthto');
		$whtype		= $this->input->post('warehouse_level');
		$whcode		= $this->input->post('warehouse_store');
		$startdate = $monthfrom.'-01 00:00:00';
		$enddate = date("Y-m-t", strtotime($monthto.'-01')).' 11:59:59';
		$result=$this->invnrep->vaccine_distribution_detial($startdate,$enddate,$whtype,$whcode);
		print_r($result); exit;
		$distrcit=$this->common->fetchall('districts',null,'distcode,district',array('province'=>'3'));
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity",array("item_category_id"=>'1'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		$data['district']=$distrcit;
		$data['result']=$result;
		$data['items']=$items;
	} 
	
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      inventory_status
	@ Description:   This function will open Report containing information about Inventory status (Issue/receive/Pending transactions).
	*
	public function inventory_status($default='filter')
	{
		if($default==='filter'){
			//$whtype	 = $this->session->curr_wh_type; 
			$reportPeriod = array('cryearly','monthly_current');
			$extraNeededFilters = array("invnRepType","groupoptions"=>array(array('name' => 'invnRepType','value' => 'monthwise','checked' => TRUE,'label' => "Month Wise"),array('name' => 'invnRepType','value' => 'storewise','label' => "Store Wise")));
			$reportPath = base_url()."inventory_status_report";
			$reportTitle = "Inventory Status Report";
			$dataHtml = $this->dashboardfilters->filtersHeader($reportPath,$reportTitle);
			//$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,$whtype,NULL,FALSE,FALSE), "name","id");
			//$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			//$ucdropdown = array("0"=>"UC",""=>"select");
			$dataHtml .= $this->dashboardfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,$extraNeededFilters,"No","No",NULL);
			$dataHtml .= $this->dashboardfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			//$data['edit'] = "Yes";
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}else if($default=='preview'){
			$data['year'] 	 	 = $year		= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('year');
			$data['month'] 	 	 = $month		= ($this->input->post('month'))?$this->input->post('month'):NULL;
			$data['wh_type'] 	 = $whtype		= $this->session->curr_wh_type;//(null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
			$data['wh_code'] 	 = $whcode		= $this->session->curr_wh_code;//(null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
			$data['invnRepType'] = $invnRepType	= $this->input->post('invnRepType');
			$data["reportdata"] = $this->invnrep->getinvnStatusRep($year,$whtype,$whcode,$invnRepType,$month);
			$fileToLoad = 'inventory_management/reports/inventory_status';
			$template = 'template/reports_template';
			$title = 'Vaccine Distribution Report';
		}else if($default=='detail'){
			$month		= $this->input->post('month');
			$type		= $this->input->post('type');
			$whtype		= $this->input->post('wh_type_id');
			$whcode		= $this->input->post('wh_code');
			$detaildata = $this->invnrep->getinvnStatusDetail($month,$type,$whtype,$whcode);
			echo json_encode($detaildata);exit;
		}
		$data['data']=$data;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      yearly_status
	@ Description:   This function will open Graph/Chart containing information about Inventory yearly status (Issue/receive/Pending indicator wise).
	*/
	public function yearly_status($default='filter')
	{
		//for filters
		$reportPeriod = array('year');
		$reportPath = base_url("inventory/Charts/yearly_status");
		$reportTitle = "Stock Info";
		$dataHtml = $this->dashboardfilters->filtersHeader($reportPath,$reportTitle);
		$reporttypearr = array("0"=>"Indicator","1"=>"Issued","2"=>"Received","class"=>NULL);
		$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE,FALSE), "name","id");
		$ucdropdown = array("0"=>"UC",""=>"select");
		$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
		$dataHtml .= $this->dashboardfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array( $reporttypearr,$reportlevelarr,$ucdropdown,$reportstore));
		$dataHtml .= $this->dashboardfilters->filtersFooter();
		$viewData['listing_filters'] = $dataHtml;
		//for data
		if($this->input->server('REQUEST_METHOD') == 'POST'){
			unset($_REQUEST['export_excel']);
			$data['year'] 	 	 = $year		= $this->input->post('year');
			$data['indicator'] 	 = $indicator	= $this->input->post('indicator');
			$data['wh_type'] 	 = $whtype		= $this->input->post('warehouse_level');
			$data['wh_code'] 	 = $whcode		= $this->input->post('warehouse_store');
		}else{
			$data['year'] 	 	 = $year		= date("Y");
			$data['indicator'] 	 = $indicator	= "2";//Received
			$data['wh_type'] 	 = $whtype		= $this->session->curr_wh_type;
			$data['wh_code'] 	 = $whcode		= $this->session->curr_wh_code;
		}
		$data["reportdata"] = $this->invnrep->getYearlyStatusRep($year,$indicator,$whtype,$whcode);
		//for cards {Stock present in Cold rooms and ILRs}
		$wh_whrarr = array(
			"warehouse_type_id"=>$whtype,
			get_warehouse_code_column($whtype)=>$whcode
		);
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
		$data['ccminfo'] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d H:i:s")."','".$whtype."','".$whcode."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		
		$fileToLoad = 'thematic_maps/inventory/stock_info';
		$template = 'thematic_template/thematic_template';
		$title = 'EPI-MIS Dashboard | Stock Info Chart';
		$viewData['data']=$data;
		$viewData['heading']['chartName'] = "Stock Info Chart";
		/* $data['data']['exportIcons']=exportIcons($_REQUEST); */
		$viewData['fileToLoad'] = $fileToLoad;
		$viewData['pageTitle']=$title;
		$this -> load -> view($template,$viewData);;
	}
	/*public function expiry_rate_report($default='filter')
	{
		if($default==='filter'){
			$reportPeriod = array('month-from-to-previous');//array("month-from-to-previous","specific_date"); //array('month-from-to-previous');
			$reportPath = base_url()."expiry_rate_report";
			$reportTitle = "Expiry Rate Report";
			$dataHtml = $this->dashboardfilters->filtersHeader($reportPath,$reportTitle);
			$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE), "name","id");
			$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			$ucdropdown = array("0"=>"UC",""=>"select");
			$dataHtml .= $this->dashboardfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($reportlevelarr,$ucdropdown,$reportstore));
			$dataHtml .= $this->dashboardfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}else if($default=='preview'){
			$data['monthfrom'] 	 = $monthfrom	= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthfrom');
			$data['monthto']   	 = $monthto		= (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthto');
			$data['wh_type'] 	 = $whtype		= (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
			$data['wh_code'] 	 = $whcode		= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
			
			$startdate = $monthfrom.'-01 00:00:00';
			$enddate = date("Y-m-t", strtotime($monthto.'-01')).' 11:59:59';
		 	$tabledata = $this->invnrep->expiry_rate_report_data($whtype,$whcode,$startdate,$enddate);
			foreach($tabledata as $key => $row)
			{
					$splitted = explode(",",$row['data']);
					$sum = 0;
					foreach($splitted as $sid)
					{
						$sum = $sum + ($this->invnrep->expiry_rate_report_batch_data($sid));
					}
					$tabledata[$key]['expired']	= $sum;					
			}
			$data['data']['tabledata'] = $tabledata;
			$fileToLoad = 'inventory_management/reports/expiry_rate_report';
			$template = 'template/reports_template';
			$title = 'Expiry Rate Report';
		}
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
	}
	public function stock_movement_report($default='filter')
	{
			if($default==='filter'){
			$reportPeriod = array('year','monthly');
			$reportPath = base_url()."Stock_movement_report";
			$reportTitle = "Stock Movement Report";
			$dataHtml = $this->dashboardfilters->filtersHeader($reportPath,$reportTitle);
			$reporttypearr = array("0"=>"Indicator","1"=>"Issued","2"=>"Received","class"=>NULL);
			$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE), "name","id");
			 if($distcode = $this -> session -> District)
			 {
				 unset($reportlevelarr[6]);
			 }
			$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			//$reportfromslevel = array("0"=>"To Warehouse Level","2"=>"Provincial");
			$reportfromslevel = array("0"=>"To Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE), "name","id");
			if($distcode = $this -> session -> District)
			 {
				 unset($reportfromslevel[6]);
			 }
			$ucdropdown = array("0"=>"Union Council",""=>"select");
			//$provinces = array("0"=>"Province","3"=>"Khyber PakhtunKhwa");
			$reportfromsstore = array("0"=>"To Warehouse Store",""=>"--Select Store--");
			$dataHtml .= $this->dashboardfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array( $reporttypearr,$reportlevelarr,$reportstore,$reportfromslevel,$ucdropdown,$reportfromsstore));
			$dataHtml .= $this->dashboardfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$data['includeCurrentMonth']=true;
			//$data['edit'] = "Yes";
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
			}
			else if($default=='preview')
			{
			$data['to_wh_type'] 	 = $towhtype		= $this->input->post('to_warehouse_level');
			$data['to_wh_code'] 	 = $towhcode		= $this->input->post('to_warehouse_store');	
			$data['month'] 	 	 = $month		= (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('month');	
			$data['year'] 	 	 = $year		= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('year');
			$data['indicator'] 	 = $indicator	= (null !== $this->uri->segment(2)) ? $this->uri->segment(2) : $this->input->post('indicator');
			$data['wh_type'] 	 = $whtype		= (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
			$data['wh_code'] 	 = $whcode		= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
			$data["reportdata"] = $this->invnrep->getStockMovementReport($year,$indicator,$whtype,$whcode,$month,$towhtype,$towhcode);
			//print_r($data);exit;
			$fileToLoad = 'inventory_management/reports/stock_movement_report';
			$template = 'template/reports_template';
			$title = 'Vaccine Distribution Report';;
			}	
			$data['data']=$data;
			$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = $fileToLoad;
			$data['pageTitle']=$title;
			$this -> load -> view($template,$data);
		
	}

	public function stock_ledger($default='filter')
	{
		if($default==='filter'){
			$reportPeriod = array('month-from-to-current');
			$reportPath = base_url()."stock-ledger";
			$reportTitle = "Stock Ledger";
			$dataHtml = $this->dashboardfilters->filtersHeader($reportPath,$reportTitle);
			$reportlevelarr = array("0"=>"Product")+array_column ( get_products_by_activity(1,TRUE,NULL,FALSE), "name","id");
			$dataHtml .= $this->dashboardfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($reportlevelarr));
			$dataHtml .= $this->dashboardfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}
		else if($default=='preview')
		{
			$data['monthfrom'] 	 = $monthfrom	= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthfrom');
			$data['monthto']   	 = $monthto		= (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthto');
			$data['product'] 	 = $product	= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) :$this->input->post('product');
			//$data['wh_type'] 	 = $whtype		= (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
			//$data['wh_code'] 	 = $whcode		= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
			$whtype	 = $this->session->curr_wh_type; 
			$whcode	 = $this->session->curr_wh_code;
			$startdate = $monthfrom.'-01 00:00:00';//2018-05-01 00:00:00
			//$enddate = date("Y-m-t", strtotime($monthto.'-01')).' 11:59:59';
			//last of specific month :code updated: Omer butt
			$lastday = date('t',strtotime($monthto.'-01'));
			if($monthto >= date('Y-m'))
			{
				$enddate = date('Y-m-d H:i:s');
			}
			else
			{
				$enddate = $monthto.'-'.$lastday.' 23:59:59';
			}
			$openingbalance = $this->invnrep->opening_balance_for_stockledger($startdate,$whtype,$whcode,$product);
			$tabledata = $this->invnrep->stock_ledger_data($startdate,$enddate,$product,$whtype,$whcode);
			$closingbalance = $this->invnrep->closing_balance_for_stockledger($enddate,$whtype,$whcode,$product);
			//print_r($openingbalance); exit; 
			$doses = $this->invnrep->numberofdossesinproduct($product);
			$data['data']['tabledata'] = $tabledata;
			$data['data']['enddate'] = $enddate;
			$data['data']['startdate'] = $startdate;
			$data['data']['doses'] = $doses;
			$data['data']['openingbalance'] = $openingbalance;
			$data['data']['closingbalance'] = $closingbalance;
			$fileToLoad = 'inventory_management/reports/stock_ledger';
			$template = 'template/reports_template';
			$title = 'Stock Ledger';
		}
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      voucher_detail
	@ Description:   This function will open Report containing information about detail of items in a voucher.
	*
	public function voucher_detail($vouchernum)
	{		
		$data['data']['vouchernum'] =  $vouchernum;
		$data['data']['output'] = $this->invnrep->voucher_detail($vouchernum);
		$allproducts = array_column($data['data']['output'], 'itemname');
		$uniqueprod = array_unique($allproducts);
		$data['data']['uniqueProd']=$uniqueprod;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/reports/voucher_detail';
		$data['pageTitle'] = 'EPI-MIS | Voucher Detail';
		$this->load->view('template/reports_template',$data);	
	}*/	
}
?>