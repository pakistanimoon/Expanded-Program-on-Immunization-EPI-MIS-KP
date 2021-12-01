<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('app_api/api_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> helper('my_functions_helper');
		$this -> load -> model('API/app_api_model/Common_model','common');
		$this->output->set_content_type('application/json');
	}
		
	public function voucher_info()
	{
		//print_r('hi'); exit;
		$issuenum = $this -> input -> post('voucher_no');
		$curr_wh_type = $this -> input -> post('curr_wh_type');
		$curr_wh_code = $this -> input -> post('curr_wh_code');
		//print_r($issuenum); exit;
			if($issuenum){
				$whrarr = array("transaction_number"=>$issuenum,"draft"=>0,"transaction_type_id"=>2,"to_warehouse_type_id"=>$curr_wh_type,"to_warehouse_code"=>$curr_wh_code);
				$whrarrcount = array("transaction_number"=>$issuenum,"draft"=>0,"transaction_type_id"=>2,"to_warehouse_type_id"=>$curr_wh_type,"to_warehouse_code"=>$curr_wh_code,"epi_stock_batch.status !="=>"Finished");
				
				$countdrafts = $this->common->count_record("epi_stock_batch",$whrarrcount,array("table"=>"epi_stock_master","tablecol"=>"pk_id","id"=>"batch_master_id"));
				//print_r($countdrafts); exit; 
				if($countdrafts){
					$noncc_whrarr = $wh_whrarr = array(
						"warehouse_type_id"=>$curr_wh_type 
					);
					$noncc_whrarr["warehouse_code"] = $curr_wh_code;
					$data["nonccloctypes"] = $this->common->fetchall("epi_non_ccm_locations",NULL,"pk_id as id,location_name as name",$noncc_whrarr,NULL,array("by"=>"location_name","type"=>"asc"));
					//print_r($data); exit;
					$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21));
					//$wh_whrarr[get_warehouse_code_column($this->session->curr_wh_type)]=$this->session->curr_wh_code;
					$wh_whrarr["storecode"]=$curr_wh_code;
					$wh_whrarr["get_asset_status(epi_cc_coldchain_main.asset_id) !="]=3;
					$data["ccloctypes"] = $this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name || '('||COALESCE(serial_no, '') ||')' as name",$wh_whrarr,NULL,array("by"=>"asset_id","type"=>"desc"),NULL,$wh_whrarr_in);
					//nature column conditon add.for during stock  recieve only negative adjust type show
					$data["adjsttypes"] = $this->common->fetchall("epi_transaction_types",NULL,"pk_id as id,transaction_type_name as name,nature",array("is_adjustment"=>1,"nature"=>'0',"status"=>1),NULL,array("by"=>"transaction_type_name","type"=>"ASC"));
					
					$data["draftdata"]["master"] = $masterdata = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,$whrarr);
					$data["draftdata"]["batch"] = $this->common->fetchall("epi_stock_batch",array("table"=>"epi_item_pack_sizes","tablecol"=>"pk_id","id"=>"item_pack_size_id"),"epi_stock_batch.*,get_stackholder_activity_name(epi_item_pack_sizes.activity_type_id) as purpose,get_product_name(item_pack_size_id) as name,stackholdername(stakeholder_id) as manuf_name,epi_item_pack_sizes.item_category_id,epi_item_pack_sizes.number_of_doses",array("epi_stock_batch.batch_master_id"=>$masterdata->pk_id,"epi_stock_batch.status !="=>"Finished"),NULL,array("by"=>"pk_id","type"=>"desc"));
					$data["draftdata"]["detail"] = $this->common->fetchall("epi_stock_detail",array("table"=>"epi_stock_batch","tablecol"=>"pk_id","id"=>"stock_batch_id"),"epi_stock_detail.*,itemunitname(item_unit_id) as item_unit_name",array("stock_master_id"=>$masterdata->pk_id,"epi_stock_batch.status !="=>"Finished"),NULL,array("by"=>"pk_id","type"=>"desc"));
					//$ci = array('4','10');
					$vvm_pack_id = array_column($data["draftdata"]["batch"], "item_pack_size_id");
					//print_r($vvm_pack_id); exit;
					$data["vvmstages"] = $this->common->fetchall("vvm_stages",array("table"=>"epi_item_pack_sizes","tablecol"=>"vvm_stage_type","id"=>"type"),"vvm_stages.name as vvm_name,vvm_stages.value as id, epi_item_pack_sizes.pk_id as item_pack_size_id, get_product_name(epi_item_pack_sizes.pk_id) as name",NULL,NULL,array("by"=>"list_rank","type"=>"ASC"),NULL,array("columname"=>"epi_item_pack_sizes.pk_id","valuesarray"=>$vvm_pack_id));
				}else{
					$data['msg'] = "Voucher not found / does not belong to this store!";
				}
			}
			return $this->output->set_output(json_encode($data));
	}
	
	public function voucher_save(){
		//$array = $_POST;
		//print_r($_POST);
		//$type = gettype($array);
		//echo $type;
		//exit;
		/* echo json_encode($_POST);
		exit; */
		
		
		//$data = '{"students" : [{"roll_no":"1101","full_name":"John Smith","dayspresent":"1","totalclasses":"2","percent_att":"50","hasAttended":"P","att_date":"Fri Apr 05 2013 ","st_class":"1","st_section":"A"},{"roll_no":"1102","full_name":"Ram Puri","dayspresent":"4","totalclasses":"4","percent_att":"100","hasAttended":"A","att_date":"Fri Apr 05 2013 ","st_class":"1","st_section":"A"}]}';
		$_POST = json_decode(file_get_contents('php://input'),true);
		//$_POST = file_get_contents('php://input');
		//print_r($_POST); exit;
		//$array1 = json_decode($array); 
		//print_r($_POST);
		//$addit = json_decode($array['addit']);
		//print_r($addit);
		
		//exit;
		
		$username = $this->input->post("username");
		$userlevel = $this->input->post("userlevel");
		$usertype = $this->input->post("usertype");
		$allchecked = $this->input->post("addit");
		$searchednum = $this->input->post("voucher_no");
		$curr_wh_type = $this -> input -> post('curr_wh_type');
		$curr_wh_code = $this -> input -> post('curr_wh_code'); 
		//$location = $this -> input -> post('location');
		/* $username = $data['username'];
		//$userlevel =  $data['userlevel']; //$this->input->post("userlevel");
		//$usertype =  $data['usertype']; //$this->input->post("usertype");
		$allchecked =  $data['addit']; //json_decode($this->input->post("addit"));
		$searchednum =  $data['voucher_no']; //$this->input->post("voucher_no");
		$curr_wh_type =  $data['curr_wh_type']; //$this -> input -> post('curr_wh_type');
		$curr_wh_code =  $data['curr_wh_code']; //$this -> input -> post('curr_wh_code'); */ 
		
		//print_r($location); exit;
		
		$resultrowmaster = $this->common->get_info("epi_stock_master",NULL,NULL,NULL,array("transaction_number"=>$searchednum));
		foreach($allchecked as $key=>$index){
			//$index = $this -> input -> post('location')[$index];
			 //echo $index;
			$this->form_validation->set_rules("location[$index]", "Store Location ", 'trim|required|is_natural|greater_than[0]');
		//echo $index;
		}
		//exit;
		if ($this->form_validation->run() == FALSE)
		{
			//echo "hi"; echo validation_errors();  exit;
			//$this -> session -> set_flashdata('message',validation_errors());
			//$this->stock_receive_from_store($searchednum);
			$response = json_encode(array("success"=>"no", "Validation Error"=>"The Store Location  field is required"));
			return $this->output->set_output($response);
			exit;
		}
		elseif(($resultrowmaster->to_warehouse_type_id==$curr_wh_type) && ($resultrowmaster->to_warehouse_code==$curr_wh_code))
		{
			$saveAdjust=false;
			//echo $saveAdjust;exit;
			$this->db->trans_start();
			$recordnumber = count($allchecked);
			$date= $this->input->post("receive_date");
			$ym=date("ym", strtotime($date));
			
			$TranNo=check_Voucher_main($ym,'R');
			$data=$this->db->set("transaction_number","(select 'R' || '".$ym."' || to_char($TranNo,'fm0000'))",FALSE);
			//$this->db->set("transaction_number","(select 'R' || '".date("ym", strtotime($date))."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm0000'))",FALSE);
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
			//
			
			//print_r($allchecked);
			//print_r($_POST);
			//print_r($datatosave);
			//exit;
			$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
			$RecVoucher = $this->common->get_info("epi_stock_master",NULL,NULL,'transaction_number',array("pk_id"=>$recid));
			foreach($allchecked as $key=>$index){
				//print_r(isset($vvm_stage[$index])?$vvm_stage[$index]:"moon");continue;
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
				/* print_r($datatosavebatch);
				exit; */
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
				/* echo "hi"; 
				exit; */
				//print_r($datatosavedetail);
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
					$TranNo=check_Voucher_main($ym,'A');
					$data=$this->db->set("transaction_number","(select 'A' || '".$ym."' || to_char($TranNo,'fm0000'))",FALSE);
					//$this->db->set("transaction_number","(select 'A' || '".date("ym", strtotime($date))."' || to_char(nextval('stock_master_trans_num_seq'::regclass),'fm0000'))",FALSE);
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
					/* print_r($datatoadjust);
					exit; */
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
					/* print_r($datatoadjustbatch);
					exit; */
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
					/* print_r($datatoadjustdetail);
					exit; */
					$detailid = $this->common->insert_record("epi_stock_detail",$datatoadjustdetail);
					//set adjustment history
					$this->save_all_history($adjustid);
					createTransactionLog_api("StockAdjustment from Stock Receive Store","stock master id".$adjustid, $username, $userlevel, $usertype);
				}
		   /***-------------------END-----------------***/	
		}	
		
			//set history
			$masterpk = $recid;
			//print_r($masterpk);
			//exit;
			$this->save_all_history($masterpk);		
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				//$msg = "Some error exist, DB Query Fails.";
				$response = json_encode(array("success"=>"no", "household"=>"database Error"));
			}
			else{
				$Rec=$RecVoucher->transaction_number;
				//$msg = "Transaction Completed Successfully, Stocks Received, Transaction Number is <a target='_blank' href='".base_url()."voucher/$Rec'>".$Rec."</a>!!";
				//createTransactionLog("Stock Receive from Store", $subTitle." - Viewed, Issue No ($searchednum) Receive No ()");
				$response = json_encode(array("success"=>"yes", "Record id"=>$Rec));
				$searchednum = NULL;
			}
		}else{
			$msg = "You are not authorized to receive this voucher.";
			$response = json_encode(array("success"=>"no", "Message"=>$msg));
		}
		return $this->output->set_output($response);
		//echo $msg;exit;
		//$this -> session -> keep_flashdata('message',$msg);
		//$this -> session -> set_flashdata('message',$msg);
		//redirect(base_url().'StockReceivefromStore/'.$searchednum);
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
}
