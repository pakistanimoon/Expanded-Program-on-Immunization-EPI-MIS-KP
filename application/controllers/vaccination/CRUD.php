<?php
/*
            _V_A_C_C_I_N_A_T_I_O_N  
		 ______________________________
                                            
 .d8888b.  RIQ                       RIQ    
d88P  Y88b 8M8                       8M8    
Y88b.      8R8                       8R8    This is a main class for CRUD of vaccination module
 "IMRAN.   8A8888  .d88b.  8I888b.   8A8    written by Raja Imran Qamer and copytighted by 
    "Y88b. 8N8    d88""88b 8M8 "88b  8N8    Pace Technologies and Dept of EPi, ministry of health.
      "888 888    888  888 8R8  888  Y8P    if someone asked you to make some changes or rewrite. 
PACE  d88P Y88b.  Y88..88P 8A8 TECH         don't do directly without knowledge & taking help from 
 "Y8888P"   "PACE  "TECH"  8N888P"   RIQ    rajaimranqamer@gmail.com - 2019-12-31
                           888              Merged Forms, {Vaccination + Consumption}
                           888              
                           RIQ              

*/
class CRUD extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('cross_notify_functions_helper');
		if($this -> session -> UserAuth == 'Yes'){}else{
			authentication();
		}
		$this -> load -> model ('vaccination/Crud_model',"crud");
		$this -> load -> model ('Common_model',"common");
		$this -> load -> model ('Data_entry_model');
		$this -> load -> helper('inventory_helper');
	}
	//default function act as landing page for Vaccination and consumption CRUD
	public function index()
	{
		dataEntryValidator(0);
		$data=array();
		$this->getPaginationConf($data,"epi_consumption_master",50);
		$data['tabledata'] = $this -> crud -> consumption_list($data['per_page'],$data['startpoint']);
		$data['edit']="Yes";
		$this->templateCall($data,'vaccination/crud/list','Health Facility Vaccination & Consumption | EPI-MIS');
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
			$data["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
			$this->templateCall($data,'vaccination/crud/vacc_cr_form','Health Facility Monthly Vaccination & Consumption Form | EPI-MIS');
		}
		else
		{
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			$facode = $this -> input -> post('facode');
			/* $WCdata = array(
			'distcode' 	=> ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):'1',
			'tcode' 	=> ($this -> input -> post('tcode'))?$this -> input -> post('tcode'):'1',
			'uncode' 	=> ($this -> input -> post('uncode'))?$this -> input -> post('uncode'):'1',
			'facode' 	=> ($this -> input -> post('facode'))?$this -> input -> post('facode'):'1'
			); */
			/** For Edit report code Start here ***/
			$edit = $this -> input -> post('edit');
			$allproducts = $this->input->post("product");
			unset($allproducts["vaccinated"]);//remove vaccinated
			if($edit=="edit")
			{
				$reported_facode = $this -> input -> post('reported_facode');
				//$codeAuthentic = facilityAuthentication($WCdata);
				/* if($checkcodes !=TRUE){
					$this -> session -> set_flashdata('message','Please Select Respective and Authentic Facility!');
					redirect('/vaccination/edit/'.$fmonth."/".$reported_facode);exit;
				} */
				$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
				if($res==1){
					$this->session->set_flashdata('message',"Report Freezed You cannot Update it Now.");
					redirect( base_url().'vaccination');
				}
				$this->db->trans_start();
				$result=0;
				//$allproducts = $this->input->post("product");
				//first call vaccination save function to update data in fac_mvrf_db table
				$this->fac_mvrf_save();
				//now save consumption data
				foreach($allproducts as $itemid=>$onebatch){
					foreach($onebatch as $batchid=>$oneproduct){
						//print_r($oneproduct);
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
						//print_r($datatosavedetail);
						if($detail_id > 0 && $master_id >0 ){
							$this->common->update_record("epi_consumption_detail",$datatosavedetail,array('pk_id'=>$detail_id,'main_id'=>$master_id));
							//update updated_date in epi_consumption_master table
							$update = array("updated_date" => date("Y-m-d"));
							$this->common->update_record("epi_consumption_master",$update,array('pk_id'=>$master_id));
							$result=$this->db->affected_rows();
						}
						// FOr Adjustment is created
						if(isset($adjustnature) && $adjusted>0){
							//For Update  Adjustment Form Edit Form if adjust_id  >0 
							if($adjust_id >0 && $detail_id > 0 && $master_id >0 ){
									$datatosaveadjust = array(
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
				//exit;
				redirect( base_url().'vaccination');
			}
			/** For Edit report code  END here ***/
			/* $codeAuthentic = facilityAuthentication($WCdata);
			if($checkcodes !=TRUE){
				$this -> session -> set_flashdata('message','Please Select Respective and Authentic Facility!');
				redirect('/vaccination/add/');exit;
			} */
			$this->db->trans_start();
			//first call vaccination save function to save data in fac_mvrf_db table
			$this->fac_mvrf_save();
			//now save consumption data				
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
			//syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
			redirect( base_url().'vaccination');
		}
	}
	public function createDataShare()
	{
		dataEntryValidator(0);
		$this->form_validation->set_rules('facode','Health Facility','numeric|Required|greater_than[0]');
		$this->form_validation->set_rules('year','Year','numeric|Required|greater_than[2014]');
		$this->form_validation->set_rules('month','Month','numeric|Required|greater_than[0]|less_than[13]');
		if ($this->form_validation->run() === FALSE)
		{
			$outdata= array("success"=>"no","message"=>"Required fields does not exist or data not valid.");
			echo json_encode($outdata);
		}
		else
		{
			$fmonth = $this -> input -> post('year')."-".$this -> input -> post('month');
			$facode = $this -> input -> post('facode');
			$alldata = $this->input->post("datasharing");
			/* $codeAuthentic = facilityAuthentication($WCdata);
			if($checkcodes !=TRUE){
				$this -> session -> set_flashdata('message','Please Select Respective and Authentic Facility!');
				redirect('/vaccination/add/');exit;
			} */
			$antigen=$this->input->post("antigen");
			$item_id=$this->input->post("item_id");
			$countrycode=$this->input->post("countrycode");
			$procode=$this->input->post("procode");
			$distcode=$this->input->post("distcode");
			$tcode=$this->input->post("tcode");
			$uncode=$this->input->post("uncode");
			if($antigen==''){
				$antigen=NULL;
			}else{
				$antigen=$antigen;
			}
			$this->db->trans_start();
			$table = "monthly_outuc_coverage";
			$datatosave = array(
				"fmonth" => $fmonth,
				"from_facode" => $facode,
				"item_id" => $this->input->post("item_id"),
				"antigen" => $antigen,
				"uncode" => ($uncode==NULL)?0:$uncode,
				"countrycode" => $countrycode
			);
			$this->common->delete_record_multiple_colum($table,$datatosave);
			$datatosave["submitted_datetime"] = date("Y-m-d");
			$datatosave["updated_datetime"] = date("Y-m-d");
			//foreach($alldata["countrycode"] as $rowkey=>$countrycode){
			$datatosave["procode"] =($procode==NULL)?0:$procode;
			$datatosave["distcode"] = ($distcode==NULL)?0:$distcode;
			$datatosave["tcode"] = ($tcode==NULL)?0:$tcode;
			foreach($alldata["vaccinated"] as $colname=>$colvalue){
				//$datatosave[$colname] = (int)$colvalue[$rowkey];
				$datatosave[$colname] = (int)$colvalue[0];
			}
			$this->common->insert_record("monthly_outuc_coverage",$datatosave);					
			//}
			$data = $this -> crud -> total_get_monthly_outuc_coverage($facode,$fmonth,$distcode,$item_id,$antigen);
			echo json_encode($data);
			$this->db->trans_complete();
		}
	}			
	public function itemslist(){
		$activity = ($this->input->post("activity"))?$this->input->post("activity"):"routine";
		$fmonth = ($this->input->post("fmonth"))?$this->input->post("fmonth"):NULL;
		$whtype = "6";
		$edit = ($this->input->post("edit"))?$this->input->post("edit"):0;
		$whcode = $this->input->post("facode");
		$issueditems = $this-> crud -> get_issued_items($activity,$whtype,$whcode,$fmonth);
		$prevfmonth = date("Y-m",strtotime($fmonth.'-01'.' first day of previous month'));
		$fmonthparts = explode("-",$prevfmonth);
		$prevyear = $fmonthparts[0];
		$existingitems = $this-> crud -> get_existing_items($whcode,$prevfmonth);
		//edit
		if($edit=="1"){
			$ucvaccdata=$this-> common -> get_info("fac_mvrf_db",NULL,NULL,NULL,array("fmonth"=>$fmonth,"facode"=>$whcode));
			$odvaccdata=$this-> common -> get_info("fac_mvrf_od_db",NULL,NULL,NULL,array("fmonth"=>$fmonth,"facode"=>$whcode));
			//print_r($ucvaccdata);
			//print_r($odvaccdata);
			$editdata=$this-> crud -> consumption_edit($fmonth,$whcode,$view=false);
			$editdata = $this->moveToEndOfArray(6,$editdata);//6 for TT
			$this->convert_fac_mvrf_to_consumption_array($editdata,$ucvaccdata,$odvaccdata);
			//print_r($editdata);exit;
			$this->load->view('vaccination/crud/vacc_cr_edit_form_items',['cr_items'=>$editdata]);
		}
		else{
			$resultantarr = array();
			$this->moonfillarray($resultantarr,$issueditems);
			$this->moonfillarray($resultantarr,$existingitems);
			ksort($resultantarr,SORT_NUMERIC);
			//$key = array_search('6', array_map(function($v){return $v['item_id'];},$resultantarr));
			
			//to move TT at the end, we will format it's header there
			$resultantarr = $this->moveToEndOfArray(6,$resultantarr);//6 for TT
			/* $search = 6;
			$finalarray = $resultantarr;
			$found = array_filter($resultantarr,function($v,$k) use ($search,&$resultantarr){
				if($v['item_id'] == $search){
					unset($resultantarr[$k]);
					$resultantarr[$k] = $v;
					//echo ++$cnt;
					return true;
				}else{
					return false;
				}
			},ARRAY_FILTER_USE_BOTH); */
			//$moonsorted = uksort($resultantarr, $found);
			//array_multisort($resultantarr, $found);
			//$resultantarr = array_diff($resultantarr,$found);
			//print_r($resultantarr);
			//send this list to view and create a simple table for form
			$this->load->view('vaccination/crud/vacc_cr_form_items',['cr_items'=>$resultantarr]);
		}
	}
	function consumption_delete()
	{
		dataEntryValidator(0);
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
		if($res==1){
			$this->session->set_flashdata('message',"Report Freezed You cannot Delete it Now.");	
			redirect( base_url().'vaccination');
		}
		$this->db->trans_start();
			$result=$this->crud->consumption_delete($fmonth,$facode);
		$this->db->trans_complete();
		if($result=="true")
		{
			$this->session->set_flashdata('message',"Report Delete Successfully of $facode and month $fmonth");
			//testing for data send to federal.uncomment it for local(epimis1).
			//set it on live (CRES-KPK). 
			//syncDataWithFederalEPIMIS('form_b_cr',$fmonth);
		}
		else
		{
			$this->session->set_flashdata('message',"Eror during deletion of report.");	
		}
		redirect( base_url().'vaccination');
	}
	function consumption_edit()
	{
		dataEntryValidator(0);
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$res=freezeReport('epi_consumption_master',$facode,$fmonth,NUll,TRUE);
		if($res==1){
			$this->session->set_flashdata('message',"Report Freezed You cannot Delete it Now.");	
			redirect( base_url().'vaccination');
		}
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=false);
		$data['vacc_Result']=$this->common->get_info("fac_mvrf_db",NULL,NULL,"tc_male,tc_female,pw_monthly_target,tot_lhw_attached,tot_lhw_involved_vacc,fixed_vacc_planned,fixed_vacc_held,or_vacc_planned,or_vacc_held,mv_vacc_planned,mv_vacc_held,hh_vacc_planned,hh_vacc_held",array("fmonth"=>$fmonth,"facode"=>$facode));
		$data['edit']="true";
		$this->db->trans_complete();
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'vaccination');
		}
		else{
			$this->templateCall($data,'vaccination/crud/vacc_cr_form','Health Facility Monthly Consumption EDIT Form | EPI-MIS');
		}		
	}
	function consumption_view()
	{
		$fmonth=$this->uri->segment(3);
		$facode=$this->uri->segment(4);
		$this->db->trans_start();
		$data['formB_Result']=$this->crud->formb_consumption_edit($fmonth,$facode,$view=false);
		$data['vacc_Result']=$this->common->get_info("fac_mvrf_db",NULL,NULL,"tc_male,tc_female,pw_monthly_target,tot_lhw_attached,tot_lhw_involved_vacc,fixed_vacc_planned,fixed_vacc_held,or_vacc_planned,or_vacc_held,mv_vacc_planned,mv_vacc_held,hh_vacc_planned,hh_vacc_held",array("fmonth"=>$fmonth,"facode"=>$facode));
		/* $data['viewdata']=  */
		$editdata = $this-> crud -> consumption_edit($fmonth,$facode,$view=true);
		$this->db->trans_complete();
		//print_r($data);exit;
		if(empty($data['formB_Result']))
		{			
			$this->session->set_flashdata('message',"Invalid Argument Supplied.!");	
			redirect(base_url().'vaccination');
		}
		else
		{
			$ucvaccdata=$this-> common -> get_info("fac_mvrf_db",NULL,NULL,NULL,array("fmonth"=>$fmonth,"facode"=>$facode));
			$odvaccdata=$this-> common -> get_info("fac_mvrf_od_db",NULL,NULL,NULL,array("fmonth"=>$fmonth,"facode"=>$facode));
			//print_r($ucvaccdata);
			//print_r($odvaccdata);
			//$editdata=$this-> crud -> consumption_edit($fmonth,$whcode,$view=false);
			$editdata = $this->moveToEndOfArray(6,$editdata);//6 for TT
			$this->convert_fac_mvrf_to_consumption_array($editdata,$ucvaccdata,$odvaccdata);
			$data["cr_items"] = $editdata;
			$this->templateCall($data,'vaccination/crud/vacc_cr_view_form','Health Facility Monthly Consumption View Form | EPI-MIS');
		}
	}
	//this function will map new form data witl old fields and save into old table fac_mvrf_db table
	protected function fac_mvrf_save(){
		//dataEntryValidator(0);
		if($this -> input -> post('distcode') && $this -> input -> post('tcode') && $this -> input -> post('uncode') &&  $this -> input -> post('facode')){
			//$data = $this -> getPostedData();
			$prodmapp = array("2"=>array(1),"20"=>array(2),"15"=>array(3,4,5,6),"19"=>array(14,15),"17"=>array(13,21),"4"=>array(10,11,12),"3"=>array(7,8,9),"5"=>array(16,18),"6"=>array(1,2,3,4,5),"9999"=>array(17),"9998"=>array(19),"36"=>array(20));//columns name inside array
			$distcode = $this -> session -> District;
			$procode  = $this -> session -> Province;
			$facode   = $this -> input -> post('facode');
			$uncode   = $this -> input -> post('uncode');
			$tcode   = $this -> input -> post('tcode');
			$year = $this -> input -> post('year');
			$month = $this -> input -> post('month');
			$fmonth = $year."-".$month;
			$data=array(
				"facode" => $facode,
				"uncode" => $uncode,
				"tcode" => $tcode,
				"distcode" => $distcode,
				"procode" => $procode,
				"fmonth" => $fmonth,
				"tc_male" => $this->getValueOrZero($this -> input -> post('tc_male')),
				"tc_female" => $this->getValueOrZero($this -> input -> post('tc_female')),
				"pw_monthly_target" => $this->getValueOrZero($this -> input -> post('pw_monthly_target')),
				"tot_lhw_attached" => $this->getValueOrZero($this -> input -> post('tot_lhw_attached')),
				"tot_lhw_involved_vacc" => $this->getValueOrZero($this -> input -> post('tot_lhw_involved_vacc')),
				"fixed_vacc_planned" => $this->getValueOrZero($this -> input -> post('fixed_vacc_planned')),
				"fixed_vacc_held" => $this->getValueOrZero($this -> input -> post('fixed_vacc_held')),
				"or_vacc_planned" => $this->getValueOrZero($this -> input -> post('or_vacc_planned')),
				"or_vacc_held" => $this->getValueOrZero($this -> input -> post('or_vacc_held')),
				"mv_vacc_planned" => $this->getValueOrZero($this -> input -> post('mv_vacc_planned')),
				"mv_vacc_held" => $this->getValueOrZero($this -> input -> post('mv_vacc_held')),
				"hh_vacc_planned" => $this->getValueOrZero($this -> input -> post('hh_vacc_planned')),
				"hh_vacc_held" => $this->getValueOrZero($this -> input -> post('hh_vacc_held'))
			);
			$cri_data = $iu_data = $ou_data = $od_data = $odi_data = array();
			$vaccinated=$_POST["product"]["vaccinated"];//$_POST;
			foreach($vaccinated as $key=>$oneprod){
				foreach($oneprod as $ind => $onerow){
					if(isset($prodmapp[$key][$ind])){
						$colnum = $prodmapp[$key][$ind];
						if($key=="6"){
							$iu_data["ttri_r1_f".$colnum] = $this->getValueOrZero($onerow["iufp"]);
							$iu_data["ttri_r2_f".$colnum] = $this->getValueOrZero($onerow["iufnp"]);
							$iu_data["ttri_r3_f".$colnum] = $this->getValueOrZero($onerow["iuop"]);
							$iu_data["ttri_r4_f".$colnum] = $this->getValueOrZero($onerow["iuonp"]);
							$iu_data["ttri_r5_f".$colnum] = $this->getValueOrZero($onerow["iump"]);
							$iu_data["ttri_r6_f".$colnum] = $this->getValueOrZero($onerow["iumnp"]);
							$iu_data["ttri_r7_f".$colnum] = $this->getValueOrZero($onerow["iuhp"]);
							$iu_data["ttri_r8_f".$colnum] = $this->getValueOrZero($onerow["iuhnp"]);
							
							$ou_data["ttoui_r1_f".$colnum] = $this->getValueOrZero($onerow["oufp"]);
							$ou_data["ttoui_r2_f".$colnum] = $this->getValueOrZero($onerow["oufnp"]);
							$ou_data["ttoui_r3_f".$colnum] = $this->getValueOrZero($onerow["ouop"]);
							$ou_data["ttoui_r4_f".$colnum] = $this->getValueOrZero($onerow["ouonp"]);
							$ou_data["ttoui_r5_f".$colnum] = $this->getValueOrZero($onerow["oump"]);
							$ou_data["ttoui_r6_f".$colnum] = $this->getValueOrZero($onerow["oumnp"]);
							$ou_data["ttoui_r7_f".$colnum] = $this->getValueOrZero($onerow["ouhp"]);
							$ou_data["ttoui_r8_f".$colnum] = $this->getValueOrZero($onerow["ouhnp"]);
							
							$od_data["ttod_r1_f".$colnum] = $this->getValueOrZero($onerow["odfp"]);
							$od_data["ttod_r2_f".$colnum] = $this->getValueOrZero($onerow["odfnp"]);
							$od_data["ttod_r3_f".$colnum] = $this->getValueOrZero($onerow["odop"]);
							$od_data["ttod_r4_f".$colnum] = $this->getValueOrZero($onerow["odonp"]);
							$od_data["ttod_r5_f".$colnum] = $this->getValueOrZero($onerow["odmp"]);
							$od_data["ttod_r6_f".$colnum] = $this->getValueOrZero($onerow["odmnp"]);
							$od_data["ttod_r7_f".$colnum] = $this->getValueOrZero($onerow["odhp"]);
							$od_data["ttod_r8_f".$colnum] = $this->getValueOrZero($onerow["odhnp"]);
						}else if($key=="9999"){
							$iu_data["cri_r25_f".$colnum] = $this->getValueOrZero($onerow["iufm1"]);
							$iu_data["cri_r26_f".$colnum] = $this->getValueOrZero($onerow["iuff1"]);
							
							$ou_data["oui_r25_f".$colnum] = 0;
							$ou_data["oui_r26_f".$colnum] = 0;
							
							$od_data["od_r25_f".$colnum] = 0;
							$od_data["od_r26_f".$colnum] = 0;
							
						}else if($key=="9998"){
							$iu_data["cri_r25_f".$colnum] = $this->getValueOrZero($onerow["iufm1"]);
							$iu_data["cri_r26_f".$colnum] = $this->getValueOrZero($onerow["iuff1"]);	
						}else{
							$iu_data["cri_r1_f".$colnum] = $this->getValueOrZero($onerow["iufm1"]);
							$iu_data["cri_r2_f".$colnum] = $this->getValueOrZero($onerow["iuff1"]);
							$iu_data["cri_r3_f".$colnum] = $this->getValueOrZero($onerow["iufm2"]);
							$iu_data["cri_r4_f".$colnum] = $this->getValueOrZero($onerow["iuff2"]);
							$iu_data["cri_r5_f".$colnum] = $this->getValueOrZero($onerow["iufm3"]);
							$iu_data["cri_r6_f".$colnum] = $this->getValueOrZero($onerow["iuff3"]);
							$iu_data["cri_r7_f".$colnum] = $this->getValueOrZero($onerow["iuom1"]);
							$iu_data["cri_r8_f".$colnum] = $this->getValueOrZero($onerow["iuof1"]);
							$iu_data["cri_r9_f".$colnum] = $this->getValueOrZero($onerow["iuom2"]);
							$iu_data["cri_r10_f".$colnum] = $this->getValueOrZero($onerow["iuof2"]);
							$iu_data["cri_r11_f".$colnum] = $this->getValueOrZero($onerow["iuom3"]);
							$iu_data["cri_r12_f".$colnum] = $this->getValueOrZero($onerow["iuof3"]);
							$iu_data["cri_r13_f".$colnum] = $this->getValueOrZero($onerow["iumm1"]);
							$iu_data["cri_r14_f".$colnum] = $this->getValueOrZero($onerow["iumf1"]);
							$iu_data["cri_r15_f".$colnum] = $this->getValueOrZero($onerow["iumm2"]);
							$iu_data["cri_r16_f".$colnum] = $this->getValueOrZero($onerow["iumf2"]);
							$iu_data["cri_r17_f".$colnum] = $this->getValueOrZero($onerow["iumm3"]);
							$iu_data["cri_r18_f".$colnum] = $this->getValueOrZero($onerow["iumf3"]);
							$iu_data["cri_r19_f".$colnum] = $this->getValueOrZero($onerow["iuhm1"]);
							$iu_data["cri_r20_f".$colnum] = $this->getValueOrZero($onerow["iuhf1"]);
							$iu_data["cri_r21_f".$colnum] = $this->getValueOrZero($onerow["iuhm2"]);
							$iu_data["cri_r22_f".$colnum] = $this->getValueOrZero($onerow["iuhf2"]);
							$iu_data["cri_r23_f".$colnum] = $this->getValueOrZero($onerow["iuhm3"]);
							$iu_data["cri_r24_f".$colnum] = $this->getValueOrZero($onerow["iuhf3"]);
							$iu_data["cri_r27_f".$colnum] = $this->getValueOrZero($onerow["iutd1"]);
							$iu_data["cri_r28_f".$colnum] = $this->getValueOrZero($onerow["iudc1"]);
							$iu_data["cri_r29_f".$colnum] = $this->getValueOrZero($onerow["iutd2"]);
							$iu_data["cri_r30_f".$colnum] = $this->getValueOrZero($onerow["iudc2"]);
							$iu_data["cri_r31_f".$colnum] = $this->getValueOrZero($onerow["iutd3"]);
							$iu_data["cri_r32_f".$colnum] = $this->getValueOrZero($onerow["iudc3"]);						
							
							$ou_data["oui_r1_f".$colnum] = $this->getValueOrZero($onerow["oufm1"]);
							$ou_data["oui_r2_f".$colnum] = $this->getValueOrZero($onerow["ouff1"]);
							$ou_data["oui_r3_f".$colnum] = $this->getValueOrZero($onerow["oufm2"]);
							$ou_data["oui_r4_f".$colnum] = $this->getValueOrZero($onerow["ouff2"]);
							$ou_data["oui_r5_f".$colnum] = $this->getValueOrZero($onerow["oufm3"]);
							$ou_data["oui_r6_f".$colnum] = $this->getValueOrZero($onerow["ouff3"]);
							$ou_data["oui_r7_f".$colnum] = $this->getValueOrZero($onerow["ouom1"]);
							$ou_data["oui_r8_f".$colnum] = $this->getValueOrZero($onerow["ouof1"]);
							$ou_data["oui_r9_f".$colnum] = $this->getValueOrZero($onerow["ouom2"]);
							$ou_data["oui_r10_f".$colnum] = $this->getValueOrZero($onerow["ouof2"]);
							$ou_data["oui_r11_f".$colnum] = $this->getValueOrZero($onerow["ouom3"]);
							$ou_data["oui_r12_f".$colnum] = $this->getValueOrZero($onerow["ouof3"]);
							$ou_data["oui_r13_f".$colnum] = $this->getValueOrZero($onerow["oumm1"]);
							$ou_data["oui_r14_f".$colnum] = $this->getValueOrZero($onerow["oumf1"]);
							$ou_data["oui_r15_f".$colnum] = $this->getValueOrZero($onerow["oumm2"]);
							$ou_data["oui_r16_f".$colnum] = $this->getValueOrZero($onerow["oumf2"]);
							$ou_data["oui_r17_f".$colnum] = $this->getValueOrZero($onerow["oumm3"]);
							$ou_data["oui_r18_f".$colnum] = $this->getValueOrZero($onerow["oumf3"]);
							$ou_data["oui_r19_f".$colnum] = $this->getValueOrZero($onerow["ouhm1"]);
							$ou_data["oui_r20_f".$colnum] = $this->getValueOrZero($onerow["ouhf1"]);
							$ou_data["oui_r21_f".$colnum] = $this->getValueOrZero($onerow["ouhm2"]);
							$ou_data["oui_r22_f".$colnum] = $this->getValueOrZero($onerow["ouhf2"]);
							$ou_data["oui_r23_f".$colnum] = $this->getValueOrZero($onerow["ouhm3"]);
							$ou_data["oui_r24_f".$colnum] = $this->getValueOrZero($onerow["ouhf3"]);
							
							$od_data["od_r1_f".$colnum] = $this->getValueOrZero($onerow["odfm1"]);
							$od_data["od_r2_f".$colnum] = $this->getValueOrZero($onerow["odff1"]);
							$od_data["od_r3_f".$colnum] = $this->getValueOrZero($onerow["odfm2"]);
							$od_data["od_r4_f".$colnum] = $this->getValueOrZero($onerow["odff2"]);
							$od_data["od_r5_f".$colnum] = $this->getValueOrZero($onerow["odfm3"]);
							$od_data["od_r6_f".$colnum] = $this->getValueOrZero($onerow["odff3"]);
							$od_data["od_r7_f".$colnum] = $this->getValueOrZero($onerow["odom1"]);
							$od_data["od_r8_f".$colnum] = $this->getValueOrZero($onerow["odof1"]);
							$od_data["od_r9_f".$colnum] = $this->getValueOrZero($onerow["odom2"]);
							$od_data["od_r10_f".$colnum] = $this->getValueOrZero($onerow["odof2"]);
							$od_data["od_r11_f".$colnum] = $this->getValueOrZero($onerow["odom3"]);
							$od_data["od_r12_f".$colnum] = $this->getValueOrZero($onerow["odof3"]);
							$od_data["od_r13_f".$colnum] = $this->getValueOrZero($onerow["odmm1"]);
							$od_data["od_r14_f".$colnum] = $this->getValueOrZero($onerow["odmf1"]);
							$od_data["od_r15_f".$colnum] = $this->getValueOrZero($onerow["odmm2"]);
							$od_data["od_r16_f".$colnum] = $this->getValueOrZero($onerow["odmf2"]);
							$od_data["od_r17_f".$colnum] = $this->getValueOrZero($onerow["odmm3"]);
							$od_data["od_r18_f".$colnum] = $this->getValueOrZero($onerow["odmf3"]);
							$od_data["od_r19_f".$colnum] = $this->getValueOrZero($onerow["odhm1"]);
							$od_data["od_r20_f".$colnum] = $this->getValueOrZero($onerow["odhf1"]);
							$od_data["od_r21_f".$colnum] = $this->getValueOrZero($onerow["odhm2"]);
							$od_data["od_r22_f".$colnum] = $this->getValueOrZero($onerow["odhf2"]);
							$od_data["od_r23_f".$colnum] = $this->getValueOrZero($onerow["odhm3"]);
							$od_data["od_r24_f".$colnum] = $this->getValueOrZero($onerow["odhf3"]);
						}
					}
				}
			}
			//$cri_data = $data + $cri_data + $oui_data + $od_data;
			//$od_data = $data + $cri_data + $oui_data + $od_data;
			//custom fields			
			//$data["submitted_date"]=date("Y-m-d");
			$data["vacc_name"]=$this -> input -> post("prepare_by");
			$data["incharge_name"]=$this -> input -> post("incharge");
			$cri_data = $data + $iu_data + $ou_data;
			$odi_data = $data + $od_data;
		
		
		
		
			/* $od='od_';
			$cri='i_';
			foreach($data as $key =>$value){ 
			    $pos_od=(strpos($key,$od));
			    $pos_cri=(strpos($key,$cri));
			    if($pos_od === false){
					$cri_data[$key]=$value;
				}else{
					 //does nothing
				}
			    if($pos_cri === false){
					$od_data[$key]=$value;
				}else{
				  //does nothing	
				}
			} */
		    if($cri_data != Null){
				//$data=$cri_data;
				//$year = $this -> input -> post('year');
				//$month = $this -> input -> post('month');
				//$facode = $this -> input -> post('facode');
				//$data['fmonth'] = $year."-".$month;
				//$fmonth = $data['fmonth'];
				freezeReport('fac_mvrf_db',$facode,$fmonth);
				//$distcode=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
				if(!$this -> input -> post('edit') ){
					$whereClause=" facode='$facode' and distcode='$distcode' ";
					validateAlreadyInsertedRecord('fac_mvrf_db', $whereClause , "fmonth='$fmonth'");
				}
				//unset($data['year']);unset($data['month']);unset($data['hfcode']);
				//$wc = $data;
				if($cri_data["fmonth"])
				{
					if($this -> input -> post('edit') && $this -> input -> post('id'))
					{	
						$id = $this -> input -> post('id');//$data['id'];
						//unset($data['id']);unset($data['edit']);
						$data['editted_date'] = date('Y-m-d');
						$updated_id = $this -> Common_model -> update_record('fac_mvrf_db',$cri_data,array('facode' => $facode,'fmonth' => $fmonth));//array('id' => $id)
						//update allvaccinationsum
						$this->crud->update_all_vaccinations($fmonth,$facode);
					}
					else{
						$cri_data['submitted_date'] = date('Y-m-d');						
						$inserted_id = $this -> Common_model -> insert_record('fac_mvrf_db',$cri_data);
						//update allvaccinationsum
						$this->crud->update_all_vaccinations($fmonth,$facode);
					}
					//syncDataWithFederalEPIMIS('fac_mvrf_db',$fmonth );
				}
				else {
					$this -> session -> set_flashdata('message','Select Month For Facility Vaccine Monthly Reports to Proceed!');
					////redirect('Data_entry/fac_mvrf');
				}
			}
			if($odi_data != Null)
			{
				//$data=$odi_data;
				//$facode = $this -> input -> post('facode');
				//$data['fmonth'] = $year."-".$month;
				//$fmonth = $data['fmonth'];
				//$distcode=($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> session -> District;
				if(!$this -> input -> post('edit') ){
					$whereClause = " facode='$facode' and distcode='$distcode' ";
					validateAlreadyInsertedRecord('fac_mvrf_od_db', $whereClause , "fmonth='$fmonth'");
				} 
				//unset($data['year']);unset($data['month']);unset($data['hfcode']);
				//$wc = $data;
				if($odi_data["fmonth"])
				{
					if($this -> input -> post('edit') && $this -> input -> post('id'))
					{	
						$id = $this -> input -> post('id');//$data['id'];
						//unset($data['id']);unset($data['edit']);
						$data['editted_date'] = date('Y-m-d');
						$updated_id = $this -> Common_model -> update_record('fac_mvrf_od_db',$odi_data,array('facode' => $facode,'fmonth' => $fmonth));//array('id' => $id)
						//update allvaccinationsum
						$this->crud->update_all_vaccinations_od($fmonth,$facode);
						$this -> session -> set_flashdata('message','You have successfully updated your record!');
					}
					else{
						$odi_data['submitted_date'] = date('Y-m-d');
						//print_r('odi');exit;
						$inserted_id = $this -> Common_model -> insert_record('fac_mvrf_od_db',$odi_data);
						//update allvaccinationsum
						$this->crud->update_all_vaccinations_od($fmonth,$facode);
						$this -> session -> set_flashdata('message','You have successfully saved your record!');
					}
					//syncDataWithFederalEPIMIS('fac_mvrf_od_db',$fmonth );
					////redirect('FLCF-MVRF/List');
				}
				else {
					$this -> session -> set_flashdata('message','Select Month For Facility Vaccine Monthly Reports to Proceed!');
					////redirect('Data_entry/fac_mvrf');
				}
			}
		}else{
			$this -> session -> set_flashdata('message','Please Select Distrcit, Tehsil, UnionCouncil and Health Facility!');
			////redirect('Data_entry/fac_mvrf');
		}
		return true;
	}
	public function convert_fac_mvrf_to_consumption_array(&$consumptionarr,$cri_data,$odi_data){
		/* $cri_data =  $odi_data = */
		$iu_data = $ou_data = $od_data = array();
		//$vaccinated=$_POST["product"]["vaccinated"];
		$consumptionarr["product"]["vaccinated"] = array();
		$vaccinated = array_column($consumptionarr,'multiplier',"item_id");
		$vaccinated[9999] = 1;
		$vaccinated[9998] = 2;
		//print_r($vaccinated);exit;
		$prodmapp = array("2"=>array(1),"20"=>array(2),"15"=>array(3,4,5,6),"19"=>array(14,15),"17"=>array(13,21),"4"=>array(10,11,12),"3"=>array(7,8,9),"5"=>array(16,18),"6"=>array(1,2,3,4,5),"9999"=>array(17),"9998"=>array(19),"36"=>array(20));//columns name inside array
		foreach($vaccinated as $key=>$oneprod){
			for($ind = 0; $ind < $oneprod; $ind++){
				$onerow = array();
				if(isset($prodmapp[$key][$ind])){
					$colnum = $prodmapp[$key][$ind];
					if($key=="6"){
						$onerow["iufp"] =  $cri_data->{"ttri_r1_f".$colnum};
						$onerow["iufnp"] =  $cri_data->{"ttri_r2_f".$colnum};
						$onerow["iuop"] =  $cri_data->{"ttri_r3_f".$colnum};
						$onerow["iuonp"] =  $cri_data->{"ttri_r4_f".$colnum};
						$onerow["iump"] =  $cri_data->{"ttri_r5_f".$colnum};
						$onerow["iumnp"] =  $cri_data->{"ttri_r6_f".$colnum};
						$onerow["iuhp"] =  $cri_data->{"ttri_r7_f".$colnum};
						$onerow["iuhnp"] =  $cri_data->{"ttri_r8_f".$colnum};
						
						$onerow["oufp"] =  $cri_data->{"ttoui_r1_f".$colnum};
						$onerow["oufnp"] =  $cri_data->{"ttoui_r2_f".$colnum};
						$onerow["ouop"] =  $cri_data->{"ttoui_r3_f".$colnum};
						$onerow["ouonp"] =  $cri_data->{"ttoui_r4_f".$colnum};
						$onerow["oump"] =  $cri_data->{"ttoui_r5_f".$colnum};
						$onerow["oumnp"] =  $cri_data->{"ttoui_r6_f".$colnum};
						$onerow["ouhp"] =  $cri_data->{"ttoui_r7_f".$colnum};
						$onerow["ouhnp"] =  $cri_data->{"ttoui_r8_f".$colnum};
						
						$onerow["odfp"] =  $odi_data->{"ttod_r1_f".$colnum};
						$onerow["odfnp"] =  $odi_data->{"ttod_r2_f".$colnum};
						$onerow["odop"] =  $odi_data->{"ttod_r3_f".$colnum};
						$onerow["odonp"] =  $odi_data->{"ttod_r4_f".$colnum};
						$onerow["odmp"] =  $odi_data->{"ttod_r5_f".$colnum};
						$onerow["odmnp"] =  $odi_data->{"ttod_r6_f".$colnum};
						$onerow["odhp"] =  $odi_data->{"ttod_r7_f".$colnum};
						$onerow["odhnp"] =  $odi_data->{"ttod_r8_f".$colnum};
					}else if($key=="9999"){
						$onerow["iufm1"] =  $cri_data->{"cri_r25_f".$colnum}+$cri_data->{"oui_r25_f".$colnum}+$odi_data->{"od_r25_f".$colnum};
						$onerow["iuff1"] = $cri_data->{"cri_r26_f".$colnum}+$cri_data->{"oui_r26_f".$colnum}+$odi_data->{"od_r26_f".$colnum};
					}else if($key=="9998"){
						$onerow["iufm1"] =  $cri_data->{"cri_r25_f".$colnum};
						$onerow["iuff1"] =  $cri_data->{"cri_r26_f".$colnum};
					}else{
						$onerow["iufm1"] =  $cri_data->{"cri_r1_f".$colnum};
						$onerow["iuff1"] = $cri_data->{"cri_r2_f".$colnum};
						$onerow["iufm2"] = $cri_data->{"cri_r3_f".$colnum};
						$onerow["iuff2"] = $cri_data->{"cri_r4_f".$colnum};
						$onerow["iufm3"] = $cri_data->{"cri_r5_f".$colnum};
						$onerow["iuff3"] = $cri_data->{"cri_r6_f".$colnum};
						$onerow["iuom1"] = $cri_data->{"cri_r7_f".$colnum};
						$onerow["iuof1"] = $cri_data->{"cri_r8_f".$colnum};
						$onerow["iuom2"] = $cri_data->{"cri_r9_f".$colnum};
						$onerow["iuof2"] = $cri_data->{"cri_r10_f".$colnum};
						$onerow["iuom3"] = $cri_data->{"cri_r11_f".$colnum};
						$onerow["iuof3"] = $cri_data->{"cri_r12_f".$colnum};
						$onerow["iumm1"] = $cri_data->{"cri_r13_f".$colnum};
						$onerow["iumf1"] = $cri_data->{"cri_r14_f".$colnum};
						$onerow["iumm2"] = $cri_data->{"cri_r15_f".$colnum};
						$onerow["iumf2"] = $cri_data->{"cri_r16_f".$colnum};
						$onerow["iumm3"] = $cri_data->{"cri_r17_f".$colnum};
						$onerow["iumf3"] = $cri_data->{"cri_r18_f".$colnum};
						$onerow["iuhm1"] = $cri_data->{"cri_r19_f".$colnum};
						$onerow["iuhf1"] = $cri_data->{"cri_r20_f".$colnum};
						$onerow["iuhm2"] = $cri_data->{"cri_r21_f".$colnum};
						$onerow["iuhf2"] = $cri_data->{"cri_r22_f".$colnum};
						$onerow["iuhm3"] = $cri_data->{"cri_r23_f".$colnum};
						$onerow["iuhf3"] = $cri_data->{"cri_r24_f".$colnum};
						$onerow["iutd1"] = $cri_data->{"cri_r27_f".$colnum};
						$onerow["iudc1"] = $cri_data->{"cri_r28_f".$colnum};
						$onerow["iutd2"] = $cri_data->{"cri_r29_f".$colnum};
						$onerow["iudc2"] = $cri_data->{"cri_r30_f".$colnum};
						$onerow["iutd3"] = $cri_data->{"cri_r31_f".$colnum};
						$onerow["iudc3"] = $cri_data->{"cri_r32_f".$colnum};
						
						$onerow["oufm1"] = $cri_data->{"oui_r1_f".$colnum};
						$onerow["ouff1"] = $cri_data->{"oui_r2_f".$colnum};
						$onerow["oufm2"] = $cri_data->{"oui_r3_f".$colnum};
						$onerow["ouff2"] = $cri_data->{"oui_r4_f".$colnum};
						$onerow["oufm3"] = $cri_data->{"oui_r5_f".$colnum};
						$onerow["ouff3"] = $cri_data->{"oui_r6_f".$colnum};
						$onerow["ouom1"] = $cri_data->{"oui_r7_f".$colnum};
						$onerow["ouof1"] = $cri_data->{"oui_r8_f".$colnum};
						$onerow["ouom2"] = $cri_data->{"oui_r9_f".$colnum};
						$onerow["ouof2"] = $cri_data->{"oui_r10_f".$colnum};
						$onerow["ouom3"] = $cri_data->{"oui_r11_f".$colnum};
						$onerow["ouof3"] = $cri_data->{"oui_r12_f".$colnum};
						$onerow["oumm1"] = $cri_data->{"oui_r13_f".$colnum};
						$onerow["oumf1"] = $cri_data->{"oui_r14_f".$colnum};
						$onerow["oumm2"] = $cri_data->{"oui_r15_f".$colnum};
						$onerow["oumf2"] = $cri_data->{"oui_r16_f".$colnum};
						$onerow["oumm3"] = $cri_data->{"oui_r17_f".$colnum};
						$onerow["oumf3"] = $cri_data->{"oui_r18_f".$colnum};
						$onerow["ouhm1"] = $cri_data->{"oui_r19_f".$colnum};
						$onerow["ouhf1"] = $cri_data->{"oui_r20_f".$colnum};
						$onerow["ouhm2"] = $cri_data->{"oui_r21_f".$colnum};
						$onerow["ouhf2"] = $cri_data->{"oui_r22_f".$colnum};
						$onerow["ouhm3"] = $cri_data->{"oui_r23_f".$colnum};
						$onerow["ouhf3"] = $cri_data->{"oui_r24_f".$colnum};
						
						$onerow["odfm1"] = $odi_data->{"od_r1_f".$colnum};
						$onerow["odff1"] = $odi_data->{"od_r2_f".$colnum};
						$onerow["odfm2"] = $odi_data->{"od_r3_f".$colnum};
						$onerow["odff2"] = $odi_data->{"od_r4_f".$colnum};
						$onerow["odfm3"] = $odi_data->{"od_r5_f".$colnum};
						$onerow["odff3"] = $odi_data->{"od_r6_f".$colnum};
						$onerow["odom1"] = $odi_data->{"od_r7_f".$colnum};
						$onerow["odof1"] = $odi_data->{"od_r8_f".$colnum};
						$onerow["odom2"] = $odi_data->{"od_r9_f".$colnum};
						$onerow["odof2"] = $odi_data->{"od_r10_f".$colnum};
						$onerow["odom3"] = $odi_data->{"od_r11_f".$colnum};
						$onerow["odof3"] = $odi_data->{"od_r12_f".$colnum};
						$onerow["odmm1"] = $odi_data->{"od_r13_f".$colnum};
						$onerow["odmf1"] = $odi_data->{"od_r14_f".$colnum};
						$onerow["odmm2"] = $odi_data->{"od_r15_f".$colnum};
						$onerow["odmf2"] = $odi_data->{"od_r16_f".$colnum};
						$onerow["odmm3"] = $odi_data->{"od_r17_f".$colnum};
						$onerow["odmf3"] = $odi_data->{"od_r18_f".$colnum};
						$onerow["odhm1"] = $odi_data->{"od_r19_f".$colnum};
						$onerow["odhf1"] = $odi_data->{"od_r20_f".$colnum};
						$onerow["odhm2"] = $odi_data->{"od_r21_f".$colnum};
						$onerow["odhf2"] = $odi_data->{"od_r22_f".$colnum};
					}
					$consumptionarr["product"]["vaccinated"][$key][$ind] = $onerow;
				}
			}
		}
		//$cri_data = $data + $cri_data + $oui_data + $od_data;
		//$od_data = $data + $cri_data + $oui_data + $od_data;
		//custom fields			
		//$data["submitted_date"]=date("Y-m-d");
		//$data["vacc_name"]=$this -> input -> post("prepare_by");
		//$data["incharge_name"]=$this -> input -> post("incharge");
		//$cri_data = $data + $iu_data + $ou_data;
		//$odi_data = $data + $od_data;
	}
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
				$originalarr[$tempkey] = array(
					"itemid"=>$val["itemid"],
					"itemname"=>$val["itemname"],
					"item_name"=>$val["item_name"],
					"opening"=>$val["opening"],
					"recdoses"=>$val["recdoses"],
					"in_doses"=>$val["in_doses"],
					"item_category_id"=>$val["item_category_id"],
					"item_id"=>$val["item_id"],
					"multiplier"=>$val["multiplier"]
				);
			}
		}
	}
	private function getValueOrZero($value){
		if(isset($value) && $value>0){return $value;}else{return 0;}
	}
	private function moveToEndOfArray($search,$multiDArray){
		//to move TT at the end, we will format it's header there
		//$search = 6;
		//$finalarray = $resultantarr;
		array_filter($multiDArray,function($v,$k) use ($search,&$multiDArray){
			if($v['item_id'] == $search){
				unset($multiDArray[$k]);
				$multiDArray[$k] = $v;
				return true;
			}else{
				return false;
			}
		},ARRAY_FILTER_USE_BOTH);
		return $multiDArray;
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
	public function get_monthly_outuc_coverage() { 
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$countrycode = $this -> input-> post('countrycode');
		$uncode = $this -> input-> post('uncode');
		$data = $this -> crud -> get_monthly_outuc_coverage($facode,$fmonth,$countrycode,$uncode);
		//echo $data;  
		echo json_encode($data);  
	}
	public function view_monthly_outuc_coverage() { 
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$countrycode = $this -> input-> post('countrycode');
		$uncode = $this -> input-> post('uncode');
		$data = $this -> crud -> view_monthly_outuc_coverage($facode,$fmonth,$countrycode,$uncode);
		echo json_encode($data); 
	}  
	public function getDataShareUcList() { 
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$data = $this -> crud -> getDataShareUcList($facode,$fmonth);
		$dstblrow ='';
		foreach($data as $key => $val){
			$distcode=CrossProvince_DistrictName($val["distcode"],true);
			$tcode=CrossProvince_TehsilName($val["tcode"],true);
			$uncode=CrossProvince_UCName($val["uncode"],true);
			$dstblrow .= '<tr data-countrycode='.$val["countrycode"].' data-uncode='.$val["uncode"].'><td>'.$val["countryname"].'</td><td>'.$val["provincename"].'</td><td>'.$distcode.'</td><td>'.$tcode.'</td><td>'.$uncode.'</td><td><a id="#edit_outucdata" href="#" data-toggle="modal" data-target="#DataSharingModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default edit_outucdata" data-original-title="Edit"><i class="fa fa-pencil"></i></a></td></tr>';
		}
		echo $dstblrow;
	} 
	public function getDataShareUcList_view() { 

		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$data = $this -> crud -> getDataShareUcList($facode,$fmonth);
		$dstblrow ='';
		foreach($data as $key => $val){
			$distcode=CrossProvince_DistrictName($val["distcode"],true);
			$tcode=CrossProvince_TehsilName($val["tcode"],true);
			$uncode=CrossProvince_UCName($val["uncode"],true);
			$dstblrow .= '<tr data-countrycode='.$val["countrycode"].' data-uncode='.$val["uncode"].'><td>'.$val["countryname"].'</td><td>'.$val["provincename"].'</td><td>'.$distcode.'</td><td>'.$tcode.'</td><td>'.$uncode.'</td><td><a id="#view_outucdata" href="#" data-toggle="modal" data-target="#DataSharingModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default view_outucdata" data-original-title="View"><i class="fa fa-search"></i></a></td></tr>';
		}
		echo $dstblrow; 
	}
	public function delete_monthly_outuc()
	{
		$facode = $this -> input-> post('facode');
		$fmonth = $this -> input-> post('fmonth');
		$countrycode = $this -> input-> post('countrycode');
		$uncode = $this -> input-> post('uncode');
		$data=$this->crud->delete_monthly_outuc($fmonth,$facode,$countrycode,$uncode);
		//$data = $this -> crud -> get_monthly_outuc_coverage($facode,$fmonth,$countrycode,$uncode);
		echo json_encode($data,true); 
	}
}
?>