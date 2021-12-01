<?php
/*
 _C_O_N_S_U_M_P_T_I_O_N
	 __________________
	/''''''''''''''''''\
	[] Function: CRUD []
	|| Author: Moon   ||
	|| start:         ||
	||   24-01-2019   ||
	|| Update:        ||_______
	||   24-01-2019   ||      []
	|| **Pace Tech**  ||      ||
	[]________________[]______[]
	\**************************/
class CRUD extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		//authentication();
		if($this -> session -> UserAuth == 'Yes'){}else{
			authentication();
		}
		$this -> load -> model ('consumption/Crud_model',"crud");
		$this -> load -> model ('Common_model',"common");
		$this -> load -> helper('inventory_helper');
	}
	//default function act as landing page for consumption CRUD
	public function index()
	{		
		dataEntryValidator(0);
		$data=array();
		$this->getPaginationConf($data,"epi_consumption_master",50);
		$data['tabledata'] = $this -> crud -> consumption_list($data['per_page'],$data['startpoint']);
		$data['edit']="Yes";
		$this->templateCall($data,'consumption/crud/list','Health Facility Consumption (Monthly) | EPI-MIS');
	}
	public function create()
	{
		dataEntryValidator(0);
		$this->form_validation->set_rules('facode','Health Facility','numeric|Required|greater_than[0]');
		$this->form_validation->set_rules('year','Year','numeric|Required|greater_than[2014]');
		$this->form_validation->set_rules('month','Month','numeric|Required|greater_than[0]|less_than[13]');
		if ($this->form_validation->run() === FALSE)
		{
			//by default empty form will be open with basic info selection
			//$data['data']				= "";
			$data/* ['data'] */["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
			$this->templateCall($data,'consumption/crud/hf_cr_form','Health Facility Monthly Consumption Form | EPI-MIS');
		}
		else
		{
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			$facode = $this -> input -> post('facode');
			/** For Edit report code Start here ***/
			$edit = $this -> input -> post('edit');
			if($edit=="edit")
			{
				$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
				if($res==1){
					$this->session->set_flashdata('message',"Report Freezed You cannot Update it Now.");
					redirect( base_url().'consumption');
				}
				$this->db->trans_start();
				$result=0;
				$allproducts = $this->input->post("product");
				foreach($allproducts as $itemid=>$onebatch){
					foreach($onebatch as $batchid=>$oneproduct){
						$batchdoses = (isset($oneproduct["doses"]) && $oneproduct["doses"]>0)?$oneproduct["doses"]:1;
						$detail_id = (isset($oneproduct["detail_id"]) && $oneproduct["detail_id"]>0)?$oneproduct["detail_id"]:null;
						$master_id = (isset($oneproduct["master_id"]) && $oneproduct["master_id"]>0)?$oneproduct["master_id"]:null;
						$adjust_id = (isset($oneproduct["adjust_id"]) && $oneproduct["adjust_id"]>0)?$oneproduct["adjust_id"]:null;
						$ob = (isset($oneproduct["ob"]) && $oneproduct["ob"]>0)?$oneproduct["ob"]:0;
						$received = (isset($oneproduct["received"]) && $oneproduct["received"]>0)?$oneproduct["received"]:0;
						$vaccinated = (isset($oneproduct["vaccinated"]) && $oneproduct["vaccinated"]>0)?$oneproduct["vaccinated"]:0;
						$used = (isset($oneproduct["useddoses"]) && $oneproduct["useddoses"]>0)?$oneproduct["useddoses"]:0;
						$unused = (isset($oneproduct["unuseddoses"]) && $oneproduct["unuseddoses"]>0)?$oneproduct["unuseddoses"]:0;
						$adjusted = (isset($oneproduct["adjustdoses"]) && $oneproduct["adjustdoses"]>0)?$oneproduct["adjustdoses"]:0;
						$adjustnature = (isset($oneproduct["adjustnature"]) && $oneproduct["adjustnature"]>=0)?$oneproduct["adjustnature"]:null;
						$adjusttype = (isset($oneproduct["adjusttype"]) && $oneproduct["adjusttype"]>0)?$oneproduct["adjusttype"]:null;
						$closing = $ob+$received-$used-$unused;
						if(isset($adjustnature) && $adjusted>0){
							if($adjustnature==0){
								$closing = $closing-$adjusted;
							}else if($adjustnature==1){
								$closing = $closing+$adjusted;
							}
						}
						$closing = ($closing>0)?$closing:0;
						$datatosavedetail = array(
							//"main_id" => $recid,
							"item_id" => $itemid,
							"batch_number" => $batchid,
							"batch_doses" => $batchdoses,
							"opening_doses" => $ob,
							"received_doses" => $received,
							"vaccinated" => $vaccinated,
							"used_doses" => $used,
							"used_vials" => round($used/$batchdoses,2),//$oneproduct["usedvials"]
							"unused_doses" => $unused,
							"unused_vials" => round($unused/$batchdoses,2),
							"closing_doses" => $closing,
							"closing_vials" => round($closing/$batchdoses,2)
						);
						if($detail_id > 0 && $master_id >0 ){
							$this->common->update_record("epi_consumption_detail",$datatosavedetail,array('pk_id'=>$detail_id,'main_id'=>$master_id));
							//update updated_date in epi_consumption_master table
							$update = array("updated_date" => date("Y-m-d"));
							$this->common->update_record("epi_consumption_master",$update,array('pk_id'=>$master_id));
							$result=$this->db->affected_rows();
						}
						// FOr Adjustment is created
						if(isset($adjustnature) && $adjusted>0){
							//For Update  Adjustment Form Edit Form  if adjust_id  >0 
								if($adjust_id >0 && $detail_id > 0 && $master_id >0 ){
										$datatosaveadjust = array(
											//"detail_id" => $detail_id,
											//"main_id" => $master_id,
											"item_id" => $itemid,
											"batch_number" => $batchid,
											"adjustment_type" => $adjusttype,								
											"adjustment_quantity_doses" => $adjusted,
											"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
											"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
											"fmonth" => $fmonth,
											"procode" => $this -> session -> Province,
											"distcode" => $this -> session -> District,
											"tcode" => $this->input->post("tcode"),
											"uncode" => $this->input->post("uncode"),
											"facode" => $facode
										);
										$this->common->update_record("epi_consumption_adjustment",$datatosaveadjust,array('pk_id'=>$adjust_id,'detail_id'=>$detail_id,'main_id'=>$master_id));
										$result=$this->db->affected_rows();
								}
								//For NEW Adjustment From Edit Form if adjust_id is NULL  
								else
								{
									$datatosaveadjust = array(
										"detail_id" => $detail_id,
										"main_id" => $master_id,
										"item_id" => $itemid,
										"batch_number" => $batchid,
										"adjustment_type" => $adjusttype,								
										"adjustment_quantity_doses" => $adjusted,
										"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
										"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
										"fmonth" => $fmonth,
										"procode" => $this -> session -> Province,
										"distcode" => $this -> session -> District,
										"tcode" => $this->input->post("tcode"),
										"uncode" => $this->input->post("uncode"),
										"facode" => $facode
									);
									$this->common->insert_record("epi_consumption_adjustment",$datatosaveadjust);
									$result=$this->db->affected_rows();
								}
						}
						
					}
				}
				$this->db->trans_complete();
				if($result > 0)
				{
					$this->session->set_flashdata('message',"Report Updated Successfully of $facode and month $fmonth");
					//testing for sending data to federal DB. comment it after test at local.
					//*uncomment for live. 
					syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
					syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
				}
				else
				{
					$this->session->set_flashdata('message',"Error. Invalid arguments Supplied.!");
				}
				redirect( base_url().'consumption');
			}
			/** For Edit report code  END here ***/
			$this->db->trans_start();
			//check if report already added
			validateAlreadyInsertedRecord('epi_consumption_master', "facode='$facode'", "fmonth='$fmonth'");
			$datatosave = array(
				"fmonth" => $fmonth,
				"procode" => $this -> session -> Province,
				"distcode" => $this -> session -> District,
				"tcode" => $this->input->post("tcode"),
				"uncode" => $this->input->post("uncode"),
				"facode" => $facode,
				"prepared_by" => $this -> input -> post('prepare_by'),
				"hf_incharge" => ($this -> input -> post('inchargeid')>0)?$this -> input -> post('inchargeid'):NULL,
				"created_by" => $this->session->username,
				"created_date" => date("Y-m-d"),
				"updated_date" => date("Y-m-d")
			);
			$recid = $this->common->insert_record("epi_consumption_master",$datatosave,'consumption_master_id_seq');
			//here check if master saved then loop for detail saved
			if($recid>0){
				$allproducts = $this->input->post("product");
				foreach($allproducts as $itemid=>$onebatch){
					foreach($onebatch as $batchid=>$oneproduct){
						$batchdoses = (isset($oneproduct["doses"]) && $oneproduct["doses"]>0)?$oneproduct["doses"]:1;
						$ob = (isset($oneproduct["ob"]) && $oneproduct["ob"]>0)?$oneproduct["ob"]:0;
						$received = (isset($oneproduct["received"]) && $oneproduct["received"]>0)?$oneproduct["received"]:0;
						$vaccinated = (isset($oneproduct["vaccinated"]) && $oneproduct["vaccinated"]>0)?$oneproduct["vaccinated"]:0;
						$used = (isset($oneproduct["useddoses"]) && $oneproduct["useddoses"]>0)?$oneproduct["useddoses"]:0;
						$unused = (isset($oneproduct["unuseddoses"]) && $oneproduct["unuseddoses"]>0)?$oneproduct["unuseddoses"]:0;
						$adjusted = (isset($oneproduct["adjustdoses"]) && $oneproduct["adjustdoses"]>0)?$oneproduct["adjustdoses"]:0;
						$adjustnature = (isset($oneproduct["adjustnature"]) && $oneproduct["adjustnature"]>=0)?$oneproduct["adjustnature"]:null;
						$adjusttype = (isset($oneproduct["adjusttype"]) && $oneproduct["adjusttype"]>0)?$oneproduct["adjusttype"]:null;
						$closing = $ob+$received-$used-$unused;
						if($adjustnature>=0 && $adjusted>0){
							if($adjustnature==0){
								$closing = $closing-$adjusted;
							}else if($adjustnature==1){
								$closing = $closing+$adjusted;
							}
						}
						$closing = ($closing>0)?$closing:0;
						$datatosavedetail = array(
							"main_id" => $recid,
							"item_id" => $itemid,
							"batch_number" => $batchid,
							"batch_doses" => $batchdoses,
							"opening_doses" => $ob,
							"received_doses" => $received,
							"vaccinated" => $vaccinated,
							"used_doses" => $used,
							"used_vials" => round($used/$batchdoses,2),
							"unused_doses" => $unused,
							"unused_vials" => round($unused/$batchdoses,2),
							"closing_doses" => $closing,
							"closing_vials" => round($closing/$batchdoses,2)
						);
						$detailid = $this->common->insert_record("epi_consumption_detail",$datatosavedetail,'consumption_detail_id_seq');
						if(isset($adjustnature) && $adjusted>0){
							$datatosaveadjust = array(
								"detail_id" => $detailid,
								"main_id" => $recid,
								"item_id" => $itemid,
								"batch_number" => $batchid,
								"adjustment_type" => $adjusttype,								
								"adjustment_quantity_doses" => $adjusted,
								"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
								"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
								"fmonth" => $fmonth,
								"procode" => $this -> session -> Province,
								"distcode" => $this -> session -> District,
								"tcode" => $this->input->post("tcode"),
								"uncode" => $this->input->post("uncode"),
								"facode" => $facode
							);
							$this->common->insert_record("epi_consumption_adjustment",$datatosaveadjust);
						}
					}
				}
			}
			$this->db->trans_complete();
			//testing for sending data to federal DB. comment it after test at local.
			//*uncomment for live. 
			syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
			syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
			redirect( base_url().'consumption');
		}
	}			
	public function itemslist(){
		$activity = ($this->input->post("activity"))?$this->input->post("activity"):"routine";
		$fmonth = ($this->input->post("fmonth"))?$this->input->post("fmonth"):NULL;
		$whtype = "6";
		$edit = ($this->input->post("edit"))?$this->input->post("edit"):0;
		$whcode = $this->input->post("facode");
		$issueditems = $this-> crud -> get_issued_items($activity,$whtype,$whcode,$fmonth);
		//existing items mean items from previous month's closing balance
		$prevfmonth = date("Y-m",strtotime($fmonth.'-01'.' first day of previous month'));
		$fmonthparts = explode("-",$prevfmonth);
		$prevyear = $fmonthparts[0];
		$existingitems = $this-> crud -> get_existing_items($whcode,$prevfmonth);
		//edit
		if($edit=="1"){
			$editdata=$this-> crud -> consumption_edit($fmonth,$whcode,$view=false);
			$this->load->view('consumption/crud/consumption_edit_form_items',['cr_items'=>$editdata]);
		}
		else{
			$resultantarr = array();
			$this->moonfillarray($resultantarr,$issueditems);
			$this->moonfillarray($resultantarr,$existingitems);
			ksort($resultantarr,SORT_NUMERIC);
			//send this list to view and create a simple table for form
			$this->load->view('consumption/crud/consumption_form_items',['cr_items'=>$resultantarr]);
		}
	}
	/*** code by omer ***/
	function consumption_delete()
	{
		dataEntryValidator(0);
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
		if($res==1){
			$this->session->set_flashdata('message',"Report Freezed You cannot Delete it Now.");	
			redirect( base_url().'consumption');
		}
		$this->db->trans_start();
			$result=$this->crud->consumption_delete($fmonth,$facode);
		$this->db->trans_complete();
		if($result=="true")
		{
			$this->session->set_flashdata('message',"Report Delete Successfully of $facode and month $fmonth");
			//testing for data send to federal.uncomment it for local(epimis1).
			//set it on live (CRES-KPK). 
			syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
			syncComplianceDataWithFederalEPIMIS('consumptioncompliance');
		}
		else
		{
			$this->session->set_flashdata('message',"Eror during deletion of report.");	
		}
		redirect( base_url().'consumption');
	}
	function consumption_edit()
	{
		dataEntryValidator(0);
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
		if($res==1){
			$this->session->set_flashdata('message',"Report Freezed You cannot Delete it Now.");	
			redirect( base_url().'consumption');
		}
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=false);
		$data['edit']="true";
		$this->db->trans_complete();
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'consumption');
		}
		else{
			$this->templateCall($data,'consumption/crud/hf_cr_form','Health Facility Monthly Consumption EDIT Form | EPI-MIS');
		}
		
	}
	function consumption_view()
	{
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=true);
		$data['viewdata']=$this-> crud -> consumption_edit($fmonth,$facode,$view=true);
		$this->db->trans_complete();
		//print_r($data);exit;
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'consumption');
		}
		else
		{
			$this->templateCall($data,'consumption/crud/consumption_view_form','Health Facility Monthly Consumption View Form | EPI-MIS');
		}
	}
	//default function act as landing page for consumption Adjustment
	public function hfadjustment()
	{		
		dataEntryValidator(0);
		$data=array();
		$this->getPaginationConf($data,"epi_consumption_master",50);
		$data['tabledata'] = $this -> crud -> consumption_list($data['per_page'],$data['startpoint']);
		$data['edit']="Yes";
		$this->templateCall($data,'consumption/crud/adjustmentlist','Health Facility Stock Adjustment | EPI-MIS');
	}
	function hfadjustment_edit()
	{
		dataEntryValidator(0);
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
		if($res==1){
			$this->session->set_flashdata('message',"Report Freezed You cannot Delete it Now.");	
			redirect( base_url().'consumption');
		}
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=false);
		$data['edit']="true";
		$this->db->trans_complete();
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'consumption');
		}
		else{
			$this->templateCall($data,'consumption/crud/hf_adjustment_form','Health Facility Monthly Consumption Adjustment Form | EPI-MIS');
		}		
	}			
	public function hfadjustmentitemslist(){
		$fmonth = ($this->input->post("fmonth"))?$this->input->post("fmonth"):NULL;
		$edit = ($this->input->post("edit"))?$this->input->post("edit"):0;
		$whcode = $this->input->post("facode");
		//edit
		if($edit=="1"){
			$editdata=$this-> crud -> consumption_edit($fmonth,$whcode,$view=false);
			$this->load->view('consumption/crud/consumption_adjustment_form_items',['cr_items'=>$editdata]);
		}
		else{
			$activity = ($this->input->post("activity"))?$this->input->post("activity"):"routine";
			$whtype = "6";
			$issueditems = $this-> crud -> get_issued_items($activity,$whtype,$whcode,$fmonth);
			//existing items mean items from previous month's closing balance
			$prevfmonth = date("Y-m",strtotime($fmonth.'-01'.' first day of previous month'));
			$fmonthparts = explode("-",$prevfmonth);
			$prevyear = $fmonthparts[0];
			$existingitems = $this-> crud -> get_existing_items($whcode,$prevfmonth);
			$resultantarr = array();
			$this->moonfillarray($resultantarr,$issueditems);
			$this->moonfillarray($resultantarr,$existingitems);
			ksort($resultantarr,SORT_NUMERIC);
			//send this list to view and create a simple table for form
			$this->load->view('consumption/crud/consumption_form_items',['cr_items'=>$resultantarr]);
		}
	}
	public function saveadjustment()
	{
		dataEntryValidator(0);
		$this->form_validation->set_rules('facode','Health Facility','numeric|Required|greater_than[0]');
		$this->form_validation->set_rules('year','Year','numeric|Required|greater_than[2014]');
		$this->form_validation->set_rules('month','Month','numeric|Required|greater_than[0]|less_than[13]');
		if ($this->form_validation->run() === FALSE)
		{
			//by default empty form will be open with basic info selection
			//$data['data']				= "";
			$data/* ['data'] */["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
			$this->templateCall($data,'consumption/crud/hf_adjustment_form','Health Facility Stock Adjustment Form | EPI-MIS');
		}
		else
		{
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			$facode = $this -> input -> post('facode');
			/** For Edit report code Start here ***/
			$edit = $this -> input -> post('edit');
			if($edit=="edit")
			{
				$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
				if($res==1){
					$this->session->set_flashdata('message',"Report Freezed You cannot Update it Now.");
					redirect( base_url().'hfadjustment');
				}
				$this->db->trans_start();
				$result=0;
				$allproducts = $this->input->post("product");
				foreach($allproducts as $itemid=>$onebatch){
					foreach($onebatch as $batchid=>$oneproduct){
						$batchdoses = (isset($oneproduct["doses"]) && $oneproduct["doses"]>0)?$oneproduct["doses"]:1;
						$detail_id = (isset($oneproduct["detail_id"]) && $oneproduct["detail_id"]>0)?$oneproduct["detail_id"]:null;
						$master_id = (isset($oneproduct["master_id"]) && $oneproduct["master_id"]>0)?$oneproduct["master_id"]:null;
						$adjust_id = (isset($oneproduct["adjust_id"]) && $oneproduct["adjust_id"]>0)?$oneproduct["adjust_id"]:null;
						$ob = (isset($oneproduct["ob"]) && $oneproduct["ob"]>0)?$oneproduct["ob"]:0;
						$received = (isset($oneproduct["received"]) && $oneproduct["received"]>0)?$oneproduct["received"]:0;
						//$vaccinated = (isset($oneproduct["vaccinated"]) && $oneproduct["vaccinated"]>0)?$oneproduct["vaccinated"]:0;
						$used = (isset($oneproduct["useddoses"]) && $oneproduct["useddoses"]>0)?$oneproduct["useddoses"]:0;
						$unused = (isset($oneproduct["unuseddoses"]) && $oneproduct["unuseddoses"]>0)?$oneproduct["unuseddoses"]:0;
						$adjusted = (isset($oneproduct["adjustdoses"]) && $oneproduct["adjustdoses"]>0)?$oneproduct["adjustdoses"]:0;
						$adjustnature = (isset($oneproduct["adjustnature"]) && $oneproduct["adjustnature"]>=0)?$oneproduct["adjustnature"]:null;
						$adjusttype = (isset($oneproduct["adjusttype"]) && $oneproduct["adjusttype"]>0)?$oneproduct["adjusttype"]:null;
						$closing = $ob+$received-$used-$unused;
						if(isset($adjustnature) && $adjusted>0){
							if($adjustnature==0){
								$closing = $closing-$adjusted;
							}else if($adjustnature==1){
								$closing = $closing+$adjusted;
							}
						}
						$closing = ($closing>0)?$closing:0;
						$datatosavedetail = array(
							//"main_id" => $recid,
							"item_id" => $itemid,
							"batch_number" => $batchid,
							"batch_doses" => $batchdoses,
							"opening_doses" => $ob,
							"received_doses" => $received,
							//"vaccinated" => $vaccinated,
							"used_doses" => $used,
							"used_vials" => round($used/$batchdoses,2),//$oneproduct["usedvials"]
							"unused_doses" => $unused,
							"unused_vials" => round($unused/$batchdoses,2),
							"closing_doses" => $closing,
							"closing_vials" => round($closing/$batchdoses,2)
						);
						if($detail_id > 0 && $master_id >0 ){
							$this->common->update_record("epi_consumption_detail",$datatosavedetail,array('pk_id'=>$detail_id,'main_id'=>$master_id));
							//update updated_date in epi_consumption_master table
							$update = array("updated_date" => date("Y-m-d"));
							$this->common->update_record("epi_consumption_master",$update,array('pk_id'=>$master_id));
							$result=$this->db->affected_rows();
						}
						// FOr Adjustment is created
						if(isset($adjustnature) && $adjusted>0){
							//For Update  Adjustment Form Edit Form  if adjust_id  >0 
							if($adjust_id >0 && $detail_id > 0 && $master_id >0 ){
								$datatosaveadjust = array(
									//"detail_id" => $detail_id,
									//"main_id" => $master_id,
									"item_id" => $itemid,
									"batch_number" => $batchid,
									"adjustment_type" => $adjusttype,								
									"adjustment_quantity_doses" => $adjusted,
									"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
									"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
									"fmonth" => $fmonth,
									"procode" => $this -> session -> Province,
									"distcode" => $this -> session -> District,
									"tcode" => $this->input->post("tcode"),
									"uncode" => $this->input->post("uncode"),
									"facode" => $facode
								);
								$this->common->update_record("epi_consumption_adjustment",$datatosaveadjust,array('pk_id'=>$adjust_id,'detail_id'=>$detail_id,'main_id'=>$master_id));
								$result=$this->db->affected_rows();
							}
							//For NEW Adjustment From Edit Form if adjust_id is NULL  
							else
							{
								$datatosaveadjust = array(
									"detail_id" => $detail_id,
									"main_id" => $master_id,
									"item_id" => $itemid,
									"batch_number" => $batchid,
									"adjustment_type" => $adjusttype,								
									"adjustment_quantity_doses" => $adjusted,
									"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
									"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
									"fmonth" => $fmonth,
									"procode" => $this -> session -> Province,
									"distcode" => $this -> session -> District,
									"tcode" => $this->input->post("tcode"),
									"uncode" => $this->input->post("uncode"),
									"facode" => $facode
								);
								$this->common->insert_record("epi_consumption_adjustment",$datatosaveadjust);
								$result=$this->db->affected_rows();
							}
						}
						
					}
				}
				$this->db->trans_complete();
				if($result > 0)
				{
					$this->session->set_flashdata('message',"Report Updated Successfully of $facode and month $fmonth");
					//testing for sending data to federal DB. comment it after test at local.
					//*uncomment for live. 
					//syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
				}
				else
				{
					$this->session->set_flashdata('message',"Error. Invalid arguments Supplied.!");
				}
				redirect( base_url().'hfadjustment');
			}
			/** For Edit report code  END here ***/
			/*$this->db->trans_start();
			//check if report already added
			validateAlreadyInsertedRecord('epi_consumption_master', "facode='$facode'", "fmonth='$fmonth'");
			$datatosave = array(
				"fmonth" => $fmonth,
				"procode" => $this -> session -> Province,
				"distcode" => $this -> session -> District,
				"tcode" => $this->input->post("tcode"),
				"uncode" => $this->input->post("uncode"),
				"facode" => $facode,
				"prepared_by" => $this -> input -> post('prepare_by'),
				"hf_incharge" => ($this -> input -> post('inchargeid')>0)?$this -> input -> post('inchargeid'):NULL,
				"created_by" => $this->session->username,
				"created_date" => date("Y-m-d"),
				"updated_date" => date("Y-m-d")
			);
			$recid = $this->common->insert_record("epi_consumption_master",$datatosave,'consumption_master_id_seq');
			//here check if master saved then loop for detail saved
			if($recid>0){
				$allproducts = $this->input->post("product");
				foreach($allproducts as $itemid=>$onebatch){
					foreach($onebatch as $batchid=>$oneproduct){
						$batchdoses = (isset($oneproduct["doses"]) && $oneproduct["doses"]>0)?$oneproduct["doses"]:1;
						$ob = (isset($oneproduct["ob"]) && $oneproduct["ob"]>0)?$oneproduct["ob"]:0;
						$received = (isset($oneproduct["received"]) && $oneproduct["received"]>0)?$oneproduct["received"]:0;
						$vaccinated = (isset($oneproduct["vaccinated"]) && $oneproduct["vaccinated"]>0)?$oneproduct["vaccinated"]:0;
						$used = (isset($oneproduct["useddoses"]) && $oneproduct["useddoses"]>0)?$oneproduct["useddoses"]:0;
						$unused = (isset($oneproduct["unuseddoses"]) && $oneproduct["unuseddoses"]>0)?$oneproduct["unuseddoses"]:0;
						$adjusted = (isset($oneproduct["adjustdoses"]) && $oneproduct["adjustdoses"]>0)?$oneproduct["adjustdoses"]:0;
						$adjustnature = (isset($oneproduct["adjustnature"]) && $oneproduct["adjustnature"]>=0)?$oneproduct["adjustnature"]:null;
						$adjusttype = (isset($oneproduct["adjusttype"]) && $oneproduct["adjusttype"]>0)?$oneproduct["adjusttype"]:null;
						$closing = $ob+$received-$used-$unused;
						if($adjustnature>=0 && $adjusted>0){
							if($adjustnature==0){
								$closing = $closing-$adjusted;
							}else if($adjustnature==1){
								$closing = $closing+$adjusted;
							}
						}
						$closing = ($closing>0)?$closing:0;
						$datatosavedetail = array(
							"main_id" => $recid,
							"item_id" => $itemid,
							"batch_number" => $batchid,
							"batch_doses" => $batchdoses,
							"opening_doses" => $ob,
							"received_doses" => $received,
							"vaccinated" => $vaccinated,
							"used_doses" => $used,
							"used_vials" => round($used/$batchdoses,2),
							"unused_doses" => $unused,
							"unused_vials" => round($unused/$batchdoses,2),
							"closing_doses" => $closing,
							"closing_vials" => round($closing/$batchdoses,2)
						);
						$detailid = $this->common->insert_record("epi_consumption_detail",$datatosavedetail,'consumption_detail_id_seq');
						if(isset($adjustnature) && $adjusted>0){
							$datatosaveadjust = array(
								"detail_id" => $detailid,
								"main_id" => $recid,
								"item_id" => $itemid,
								"batch_number" => $batchid,
								"adjustment_type" => $adjusttype,								
								"adjustment_quantity_doses" => $adjusted,
								"adjustment_quantity_vials" => round($adjusted/$batchdoses,2),
								"comments" => (isset($oneproduct["adjustcomments"])?$oneproduct["adjustcomments"]:NULL),
								"fmonth" => $fmonth,
								"procode" => $this -> session -> Province,
								"distcode" => $this -> session -> District,
								"tcode" => $this->input->post("tcode"),
								"uncode" => $this->input->post("uncode"),
								"facode" => $facode
							);
							$this->common->insert_record("epi_consumption_adjustment",$datatosaveadjust);
						}
					}
				}
			}
			$this->db->trans_complete();*/
			//testing for sending data to federal DB. comment it after test at local.
			//*uncomment for live. 
			//syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
			redirect( base_url().'hfadjustment');
		}
	}
	function hfadjustment_view()
	{
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=true);
		$data['viewdata']=$this-> crud -> consumption_edit($fmonth,$facode,$view=true);
		$this->db->trans_complete();
		//print_r($data);exit;
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'consumption');
		}
		else
		{
			$this->templateCall($data,'consumption/crud/hfadjustment_view_form','Health Facility Stock Adjustment View Form | EPI-MIS');
		}
	}
	/*** code by omer end ***/
	//functions below this should be moved to parent class later
	public function getPaginationConf(&$data=array(),$tablename,$recperpage=30,$additionalwc=true){
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$data['per_page'] = $per_page = ($recperpage>0)?$recperpage:15 ;
		$data['startpoint'] = $startpoint = ($page * $per_page) - $per_page;
		$wc = '';
		if($additionalwc){
			$wc = " procode = '".$_SESSION["Province"]."'";
			if($this -> session -> District){
				$wc .= " and distcode = '".$this -> session -> District."'";
			}
		}
		$data['pagination'] = $this -> common -> pagination($tablename,$per_page,$page,'?',$wc);
	}
	public function templateCall($data=array(),$filepath,$title=""){
		$templatedata['data']=$data;
		$templatedata['fileToLoad'] = $filepath;
		$templatedata['pageTitle']=$title;
		$this->load->view('template/epi_template',$templatedata);
	}
	public function moonfillarray(&$originalarr,$arrtofill){
		foreach($arrtofill as $key=>$val){
			$tempkey = $val["rank"]."moon".$val["batch"]."moon".$val["doses"];
			if(isset($originalarr[$tempkey])){
				$originalarr[$tempkey]["opening"] = $originalarr[$tempkey]["opening"]+$val["opening"];
				$originalarr[$tempkey]["recdoses"] = $originalarr[$tempkey]["recdoses"]+$val["recdoses"];
			}else{
				$originalarr[$tempkey] = array("itemid"=>$val["itemid"],"itemname"=>$val["itemname"],"item_name"=>$val["item_name"],"opening"=>$val["opening"],"recdoses"=>$val["recdoses"],"in_doses"=>$val["in_doses"],"item_category_id"=>$val["item_category_id"]);
			}
		}
	}
	function importOldData($year,$month){		
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,
		epi_item_pack_sizes.number_of_doses as doses,
		cr_table_row_numb");
		$this->db->from("epi_item_pack_sizes");
		$this->db->join("epi_items","epi_items.pk_id = epi_item_pack_sizes.item_id");
        $this -> db -> where('cr_table_row_numb Is Not Null');
        $this -> db -> where('activity_type_id',1);
        $allitems = $this -> db -> get() -> result_array();
		$this -> db -> select("*",FALSE);
		$this -> db -> where("fmonth",$year.'-'.$month);
		$this -> db -> order_by("fmonth","ASC");
		$this -> db -> order_by("distcode","ASC");
		$this -> db -> order_by("id","ASC");
		$yearData = $this -> db -> get('form_b_cr') -> result_array();
		//print_r($yearData);exit;
		foreach($yearData as $key=>$oneitem){
			$this->db->trans_start();
			//check if report already added
			$datatosave = array(
				"fmonth" => $oneitem["fmonth"],
				"procode" => $oneitem["procode"],
				"distcode" => $oneitem["distcode"],
				"tcode" => $oneitem["tcode"],
				"uncode" => $oneitem["uncode"],
				"facode" => $oneitem["facode"],
				"prepared_by" => $oneitem["prepare_by"],
				"hf_incharge" => NULL,
				"created_by" => 'kpk'.$oneitem["distcode"].'_deo',
				"created_date" => $oneitem["date_submitted"],
				"updated_date" => NULL
			);
			$recid = $this->common->insert_record("epi_consumption_master",$datatosave,'consumption_master_id_seq');
			if($recid>0){
				foreach($allitems as $oneproduct){
					$row = $oneproduct["cr_table_row_numb"];
					$batchdoses = (isset($oneproduct["doses"]) && $oneproduct["doses"]>0)?$oneproduct["doses"]:1;
					$ob = (isset($oneitem['cr_r'.$row.'_f1']) && $oneitem['cr_r'.$row.'_f1']>0)?$oneitem['cr_r'.$row.'_f1']:0;
					$received = (isset($oneitem['cr_r'.$row.'_f2']) && $oneitem['cr_r'.$row.'_f2']>0)?$oneitem['cr_r'.$row.'_f2']:0;
					$vaccinated = (isset($oneitem['cr_r'.$row.'_f3']) && $oneitem['cr_r'.$row.'_f3']>0)?$oneitem['cr_r'.$row.'_f3']:0;
					$used = (isset($oneitem['cr_r'.$row.'_f4']) && $oneitem['cr_r'.$row.'_f4']>0)?$oneitem['cr_r'.$row.'_f4']:0;
					$unused = (isset($oneitem['cr_r'.$row.'_f5']) && $oneitem['cr_r'.$row.'_f5']>0)?$oneitem['cr_r'.$row.'_f5']:0;
					$closing = (isset($oneitem['cr_r'.$row.'_f6']) && $oneitem['cr_r'.$row.'_f6']>0)?$oneitem['cr_r'.$row.'_f6']:0;
					$datatosavedetail = array(
						"main_id" => $recid,
						"item_id" => $oneproduct["itemid"],
						"batch_number" => 'BB2019',
						"batch_doses" => $batchdoses,
						"opening_doses" => $ob,
						"received_doses" => $received,
						"vaccinated" => $vaccinated,
						"used_doses" => $used*$batchdoses,
						"used_vials" => $used,
						"unused_doses" => $unused*$batchdoses,
						"unused_vials" => $unused,
						"closing_doses" => $closing*$batchdoses,
						"closing_vials" => $closing
					);
					$detailid = $this->common->insert_record("epi_consumption_detail",$datatosavedetail,'consumption_detail_id_seq');
					echo "Master ID: ".$recid.", Detail ID: ".$detailid."<br>";
				}
			}
			$this->db->trans_complete();
		}
	}
}