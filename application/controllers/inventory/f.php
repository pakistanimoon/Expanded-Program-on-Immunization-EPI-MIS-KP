<?php
class Reports extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Inventory_model',"invn");
		$this -> load -> model ('Common_model',"common");
		$this -> load -> model ('Inventory_reports_model',"invnrep");
		$this -> load -> library('reportfilters');
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      vaccine_distribution
	@ Description:   This function will open Report containing information about vaccine distribution.
	*/
	public function vaccine_distribution($default='filter')
	{		if($default==='filter'){			$reportPeriod = array('month-from-to-current');			$reportPath = base_url()."vaccine_distribution_report";			$reportTitle = "Vaccine Distribution Report";			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);			$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE), "name","id");			$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");			$ucdropdown = array("0"=>"UC",""=>"select");			$reporttypearr = array("0"=>"Report Type","1"=>"Summary"/*,"2"=>"Detail"*/,"class"=>NULL);			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($reportlevelarr,$ucdropdown,$reportstore,$reporttypearr));			$dataHtml .= $this->reportfilters->filtersFooter();			$data['listing_filters'] = $dataHtml;			//$data['edit'] = "Yes";			$fileToLoad = 'inventory_management/reports/reports_filters';			$template = 'template/epi_template';			$title = 'EPI-MIS Report Filters';		}else if($default=='preview')		{			if($this->input->post('monthfrom')==null)			{				$location = base_url(). "Reports/Vaccine-Distribution";				redirect($location);			}			else			{			$data['monthfrom'] 	 = $monthfrom	= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthfrom');			$data['monthto']   	 = $monthto		= (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthto');			$data['wh_type'] 	 = $whtype		= (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');			$data['wh_code'] 	 = $whcode		= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');			$data['report_type'] = $report_type	= (null !== $this->uri->segment(2)) ? $this->uri->segment(2) : $this->input->post('report_type');			if($report_type=="1"){				$startdate = $monthfrom.'-01 00:00:00';				$enddate = date("Y-m-t", strtotime($monthto.'-01')).' 11:59:59';				$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity",array("item_category_id"=>'1'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));								$prevbalance = $this->invnrep->getprevbalance($startdate,$whtype,$whcode);								$prevbalance = array_column($prevbalance,"balance","id");								$receivebalance = $this->invnrep->getintervalReceive($startdate,$enddate,$whtype,$whcode);								//print_r($this->db->last_query());exit;				$receivebalance = array_column($receivebalance,"balance","id");				//print_r($this->db->last_query());exit;								$issuebalance = $this->invnrep->getintervalIssue($startdate,$enddate,$whtype,$whcode);								$issuebalance = array_column($issuebalance,"balance","id");		// That file which is_Adjustment is show data which is 1 of the coloum is_Adjustment								$adjustment_post = $this->invnrep->getintervaladj_positive($startdate,$enddate,$whtype,$whcode);								$adjustment_post = array_column($adjustment_post,"balance","id");													$adjustment_negat = $this->invnrep->getintervaladj_negative($startdate,$enddate,$whtype,$whcode);								$adjustment_negat = array_column($adjustment_negat,"balance","id");									// end								$activityid = 0;$activityindex=-1;								foreach($items as $key=>$onerow){						 					$itemid = $onerow["id"];					$items[$key]['prevbalance'] = isset($prevbalance[$itemid])?$prevbalance[$itemid]:0;					$items[$key]['receivebalance'] = isset($receivebalance[$itemid])?$receivebalance[$itemid]:0;					$items[$key]['issuebalance'] = isset($issuebalance[$itemid])?$issuebalance[$itemid]:0;					$items[$key]['adjustment_post'] = isset($adjustment_post[$itemid])?$adjustment_post[$itemid]:0;					$items[$key]['adjustment_negat'] = isset($adjustment_negat[$itemid])?$adjustment_negat[$itemid]:0;					if($activityid != $onerow["activityid"]){						$activityindex++;						$data["purpose"][$activityindex]=array("id"=>$onerow["activityid"],"name"=>$onerow["activity"],"items"=>1);						$activityid = $onerow["activityid"];					}else{						$data["purpose"][$activityindex]["items"]++;					}				}				   				$data["reportdata"] = $items;				$fileToLoad = 'inventory_management/reports/vaccine_distribution';				$template = 'template/reports_template';				$title = 'Vaccine Distribution Report';				}else if($report_type=="2"){				$startdate = $monthfrom.'-01 00:00:00';				$enddate = date("Y-m-t", strtotime($monthto.'-01')).' 11:59:59';				$result=$this->invnrep->vaccine_distribution_detial($startdate,$enddate,$whtype,$whcode);				$distrcit=$this->common->fetchall('districts',null,'distcode,district',array('province'=>'3'));				$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity",array("item_category_id"=>'1'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));				$data['district']=$distrcit;				$data['result']=$result;				$data['items']=$items;			$fileToLoad = 'inventory_management/reports/vaccine_distribution_detial';			$template = 'template/reports_template';			$title = 'Vaccine Distribution Report';							}			}			}		if ($this -> input -> post('export_excel')) {			//if request is from excel			header("Content-type: application/octet-stream");			header("Content-Disposition: attachment; filename=Vaccine-Distribution-report.xls");			header("Pragma: no-cache");			header("Expires: 0");			//Excel Ending here		}		$data['data']=$data;		$data['data']['exportIcons']=exportIcons($_REQUEST);		$data['fileToLoad'] = $fileToLoad;		$data['pageTitle']=$title;		$this -> load -> view($template,$data);	}

 	public function detail_vacc_distribution()
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
	//$fileToLoad = 'inventory_management/reports/vaccine_distribution_detial';
	//$template = 'template/reports_template';
	//$title = 'Vaccine Distribution Report';
	} 
	
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      inventory_status
	@ Description:   This function will open Report containing information about Inventory status (Issue/receive/Pending transactions).
	*/
	public function inventory_status($default='filter')
	{
		//echo $default;
		if($default=='filter'){
			//$whtype	 = $this->session->curr_wh_type; 
			$reportPeriod = array('cryearly','month-from-to-current');
			//Peroiod From to Peroiod To 
			//$reportPeriod = array('month-from-to-current');
			$extraNeededFilters = array("invnRepType","groupoptions"=>array(array('name' => 'invnRepType','value' => 'monthwise','checked' => TRUE,'label' => "Month Wise"),array('name' => 'invnRepType','value' => 'storewise','label' => "Store Wise")));
			$reportPath = base_url()."inventory_status_report";
			$reportTitle = "Inventory Status Report";
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			//$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,$whtype,NULL,FALSE,FALSE), "name","id");
			//$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			//$ucdropdown = array("0"=>"UC",""=>"select");
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,$extraNeededFilters,"No","No",NULL/*,array($reportlevelarr,$ucdropdown ,$reportstore )*/);
			$dataHtml .= $this->reportfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			//$data['edit'] = "Yes";
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}else if($default=='preview' )
		{
				if($this->input->post('invnRepType')==null)
				{
				$location = base_url(). "Reports/Inventory-Status";
				redirect($location);
				
				}
				else
				{
				
					$data['year'] 	 	 = $year		= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('year');
					$data['monthfrom'] 	 	 = $monthfrom		= ($this->input->post('monthfrom'))?$this->input->post('monthfrom'):NULL;
					$data['monthto'] 	 	 = $monthto		= ($this->input->post('monthto'))?$this->input->post('monthto'):NULL;
					$data['wh_type'] 	 = $whtype		= $this->session->curr_wh_type;//(null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
					$data['wh_code'] 	 = $whcode		= $this->session->curr_wh_code;//(null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
					$data['invnRepType'] = $invnRepType	= $this->input->post('invnRepType');
					$data['distcode'] = $distcode	= $this->input->post('distcode');
					if($distcode>0)
					{
						$whtype =4;
						$whcode=$distcode;
						$data['wh_type']=$whtype;
						$data['wh_code']=$whcode;
					}
					$data["reportdata"] = $this->invnrep->getinvnStatusRep($year,$whtype,$whcode,$invnRepType,$monthfrom,$monthto,$distcode);
					$fileToLoad = 'inventory_management/reports/inventory_status';
					$template = 'template/reports_template';
					$title = 'Vaccine Distribution Report';
				}
		}
		else if($default=='detail'){ 
			$monthfrom		= ($this->input->post('monthfrom'))?$this->input->post('monthfrom'):NULL;
			$monthto		= ($this->input->post('monthto'))?$this->input->post('monthto'):NULL;
			$month			= ($this->input->post('month'))?$this->input->post('month'):NULL;
			$type			= $this->input->post('type');
			$whtype			= $this->input->post('wh_type_id');
			$whcode			= $this->input->post('wh_code');
			$distcode       = $this->input->post('distcode');
			
			//echo $type;
			//echo $whtype;
			//echo $distcode;exit;
			$detaildata 	= $this->invnrep->getinvnStatusDetail($monthfrom,$monthto,$type,$whtype,$whcode,$month,$distcode);
			echo json_encode($detaildata);exit;
		}
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Inventory-Status-report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data']=$data;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
			$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
	}
	/* public function template_vacc_dist()
	{
		return '
			{table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered calendar">{/table_open}
			{heading_row_start}<thead><tr>{/heading_row_start}
			{heading_title_cell}<th class="text-center" style="text-align:center" colspan="{colspan}"></th>{/heading_title_cell}
			{heading_row_end}</tr>{/heading_row_end}
			{week_row_start}<tr class="title-row">{/week_row_start}
			{week_day_cell}<td>{day}</td>{/week_day_cell}
			{week_row_end}</tr></thead><tbody>{/week_row_end}
			{cal_row_start}<tr class="calendar-row">{/cal_row_start}
			{cal_cell_start}<td class="calendar-day" data-id="{day}">{/cal_cell_start}
			{cal_cell_start_today}<td class="calendar-day today" data-id="{day}">{/cal_cell_start_today}
			{cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}
			{cal_cell_content}<div class="div-inner">
				<div class="day-number">
					<span>{day}</span>
				</div>
				<div class="plans_count">
					<span style="background-color:rgb(14, 110, 171);" class="badge success"><span> Visits Add/update </span>{content}[visits]</span>
				</div>
				<div class="plan_visits">
					<span style="background-color:rgb(14, 110, 171);" class="badge"><span> Patients Add/update </span>{content}[confirmed]</span>
				</div>
			</div>{/cal_cell_content}
			{cal_cell_content_today}<div class="div-inner highlight">
				<div class="day-number">
					<span>{day}</span>
				</div>
				<div class="plans_count">
					<span style="background-color:rgb(14, 110, 171);" class="badge success"><span>Visits Add/updates</span>{content}[visits]</span>
				</div>
				<div class="plan_visits">
					<span style="background-color:rgb(14, 110, 171);" class="badge"><span>Patients Add/update</span>{content}[confirmed]</span>
				</div>
			</div>{/cal_cell_content_today}
			{cal_cell_no_content}<div class="div-inner no-data"><div class="day-number"><span>{day}</span></div></div>{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="div-inner highlight no-data"><div class="day-number"><span class="badge current-date">{day}</span></div></div>{/cal_cell_no_content_today}
			{cal_cell_blank}&nbsp;{/cal_cell_blank}
			{cal_cell_other}{day}{/cal_cel_other}
			{cal_cell_end}</td>{/cal_cell_end}
			{cal_cell_end_today}</td>{/cal_cell_end_today}
			{cal_cell_end_other}</td>{/cal_cell_end_other}
			{cal_row_end}</tr>{/cal_row_end}
			{table_close}</tbody></table>{/table_close}
		';// title="Header" data-toggle="popover" data-placement="left" data-content="Content"
	}
	 */
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      yearly_status
	@ Description:   This function will open Report containing information about Inventory yearly status (Issue/receive/Pending indicator wise).
	*/
	public function yearly_status($default='filter')
	{
		if($default==='filter'){
			$reportPeriod = array('year');
			$reportPath = base_url()."yearly_status_report";
			$reportTitle = "Yearly Stock Status Report";
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			$reporttypearr = array("0"=>"Indicator","1"=>"Issued","2"=>"Received"/* ,"3"=>"Stock in hand" */,"class"=>NULL);
			$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE,FALSE), "name","id");
			$ucdropdown = array("0"=>"UC",""=>"select");
			$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array( $reporttypearr,$reportlevelarr,$ucdropdown,$reportstore));
			$dataHtml .= $this->reportfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			//$data['edit'] = "Yes";
			
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}else if($default=='preview'){
			if($this->input->post('year')==null)
				{
				$location = base_url(). "Reports/Yearly-Status";
				redirect($location);
				
				}
				else{
			$data['year'] 	 	 = $year		= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('year');
			$data['indicator'] 	 = $indicator	= (null !== $this->uri->segment(2)) ? $this->uri->segment(2) : $this->input->post('indicator');
			$data['wh_type'] 	 = $whtype		= (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('warehouse_level');
			$data['wh_code'] 	 = $whcode		= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('warehouse_store');
			$data["reportdata"] = $this->invnrep->getYearlyStatusRep($year,$indicator,$whtype,$whcode);
			
			$fileToLoad = 'inventory_management/reports/yearly_status';
			$template = 'template/reports_template';
			$title = 'Vaccine Distribution Report';
				}
		}/* else if($default=='detail'){
			$month		= $this->input->post('month');
			$type		= $this->input->post('type');
			$whtype		= $this->input->post('wh_type_id');
			$whcode		= $this->input->post('wh_code');
			$detaildata = $this->invnrep->getinvnStatusDetail($month,$type,$whtype,$whcode);
			echo json_encode($detaildata);exit;
		} */
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Yearly-Status-report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data']=$data;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
		
	}
	public function expiry_rate_report($default='filter')
	{
		if($default==='filter'){
			$reportPeriod = array('month-from-to-current');//array("month-from-to-previous","specific_date"); //array('month-from-to-previous');
			$reportPath = base_url()."expiry_rate_report";
			$reportTitle = "Expiry Rate Report";
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			$reportlevelarr = array("0"=>"Warehouse Level")+array_column ( get_warehouse_type_option(TRUE,NULL,NULL,FALSE,FALSE), "name","id");
			$reportstore = array("0"=>"Warehouse Store",""=>"--Select Store--");
			$ucdropdown = array("0"=>"UC",""=>"select");
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($reportlevelarr,$ucdropdown,$reportstore));
			$dataHtml .= $this->reportfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}else if($default=='preview'){
			if($this->input->post('monthfrom')==null)
			{
				$location = base_url(). "Reports/Expiry-Rate-Report";
				redirect($location);
			}
			else
			{
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
		}	
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Expiry-Rate-report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		$this -> load -> view($template,$data);
	}
	public function stock_movement_report($default='filter')
	{
		//echo "Comming Soon ! ";
			if($default==='filter'){
			$reportPeriod = array('year','monthly');
			$reportPath = base_url()."Stock_movement_report";
			$reportTitle = "Stock Movement Report";
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			$reporttypearr = array("0"=>"Indicator","1"=>"Issued","2"=>"Received"/* ,"3"=>"Stock in hand" */,"class"=>NULL);
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
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array( $reporttypearr,$reportlevelarr,$reportstore,$reportfromslevel,$ucdropdown,$reportfromsstore));
			$dataHtml .= $this->reportfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$data['includeCurrentMonth']=true;
			//$data['edit'] = "Yes";
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
			}
			else if($default=='preview')
			{
				if($this->input->post('year')==null)
				{
					$location = base_url(). "Reports/Stock-Movement-Report";
					redirect($location);
				}
				else
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
			}	
			if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Stock-Movement-report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
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
			$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
			$activity=array("0"=>"Purpose")+array_column ( get_purposes(TRUE,NULL,FALSE), "activity","pk_id");
			$reportlevelarr = array("0"=>"Product")+array_column ( get_products_by_activity(1,TRUE,NULL,FALSE), "name","id");
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,array($activity,$reportlevelarr));
			$dataHtml .= $this->reportfilters->filtersFooter();
			$data['listing_filters'] = $dataHtml;
			$fileToLoad = 'inventory_management/reports/reports_filters';
			$template = 'template/epi_template';
			$title = 'EPI-MIS Report Filters';
		}
		else if($default=='preview')
		{
					if($this->input->post('monthfrom')==null)
						{
							$location = base_url(). "Reports/Stock-Ledger";
							redirect($location);
						}
					else
					{
					$data['monthfrom'] 	 = $monthfrom	= (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthfrom');
					$data['monthto']   	 = $monthto		= (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthto');
					$data['product'] 	 = $product	= (null !== $this->uri->segment(4)) ? $this->uri->segment(4) :$this->input->post('product');
					$data['purpose'] 	 =$this->input->post('purpose');;
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
					//echo $enddate;exit;
					$openingbalance = $this->invnrep->opening_balance_for_stockledger($startdate,$whtype,$whcode,$product);
					
					//$openingbalance = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$startdate."','".$whtype."',$product) as stock",array("pk_id"=>$product),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
					$tabledata = $this->invnrep->stock_ledger_data($startdate,$enddate,$product,$whtype,$whcode);
					$closingbalance = $this->invnrep->closing_balance_for_stockledger($enddate,$whtype,$whcode,$product);
					/* $closingbalance=$this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."',$product) as stock",array("pk_id"=>$product),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc")); */
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
		}
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = $fileToLoad;
		$data['pageTitle']=$title;
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=stock-ledger-report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$this -> load -> view($template,$data);
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      voucher_detail
	@ Description:   This function will open Report containing information about detail of items in a voucher.
	*/
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
	}
		public function get_purpose_product()
	{
		$purpose=$_REQUEST['purpose'];
		$optionshtml=get_products_by_activity($purpose,FALSE,NULL,TRUE);
		echo $optionshtml;
	}
	/*
	@ Author:        Omer 
	@ Email:         omerbutt2521@gmail.com
	@ Function:      rec_voucher_detail
	@ Description:   This function will open Report containing information about detail of items in a recieve voucher.
	*/
	public function rec_voucher_detail($vouchernum)
	{		
		$data['data']['vouchernum'] =  $vouchernum;
		$data['data']['output'] = $this->invnrep->rec_voucher_detail($vouchernum);
		$allproducts = array_column($data['data']['output'], 'itemname');
		$uniqueprod = array_unique($allproducts);
		$data['data']['uniqueProd']=$uniqueprod;
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'inventory_management/reports/voucher_detail';
		$data['pageTitle'] = 'EPI-MIS | Voucher Detail';
		$this->load->view('template/reports_template',$data);	
	}	
}
?>