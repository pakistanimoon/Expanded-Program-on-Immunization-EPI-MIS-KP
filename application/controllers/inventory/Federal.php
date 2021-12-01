<?php
class Federal extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model ('Common_model','common');
		$this -> load -> model ('Inventory_reports_model',"invnrep");
	}
	public function fetch_fed_issuance(){
		$moondatatosave = array();
		for($i=0;$i<2;$i++){
			if($i===0){
				$year = date('Y', strtotime(date('Y-m')." -1 month"));
				$month = date('m', strtotime(date('Y-m')." -1 month"));
			}else{
				$year = date('Y');
				$month = date('m');
			}
			$url = 'http://v.lmis.gov.pk/api/epi-mis/issuance?year='.$year.'&month='.$month;
			$curlobjmoon = curl_init();
			curl_setopt($curlobjmoon, CURLOPT_HEADER, 0);
			curl_setopt($curlobjmoon, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curlobjmoon, CURLOPT_URL, $url);
			$data = curl_exec($curlobjmoon);
			curl_close($curlobjmoon);
			$outputData = json_decode($data, true);
			$todaydate = date("Y-m-d");		
			foreach($outputData as $onearr){
				$transactionNumber = $onearr["transactionNumber"].'-fed';
				/*$transactionNumber = $onearr["transactionNumber"];
				//check if transaction number exist or not.
				$totalrec = $this->common->get_info("epi_stock_master_fed_fetch",NULL,NULL,"fetch_date,transaction_number",array("fed_transaction_number"=>$transactionNumber));
				if($totalrec){
					if($totalrec->fetch_date==$todaydate){
						//batch of same transaction number whose master already exist
						$transactionNumber = $totalrec->transaction_number;
					}else{
						continue;
					}
				}*/
				$totalrec = $this->common->count_record("epi_stock_master",array("transaction_number"=>$transactionNumber));
				if($totalrec){
					continue;
				}else{
					$moondatatosave[] = $onearr;
				}
			}
		}
		if($moondatatosave === array()){
			echo 'No New Voucher To Fetch.';
		}else{
			$newfetchedvouchers = array();
			foreach($moondatatosave as $onearr){
				$transactionNumber = $onearr["transactionNumber"].'-fed';
				$newid = false;
				$toskiparr = array("25","26","31","35","38","42","51");
				$toreparr = array("28"=>"23","40"=>"4","43"=>"2","49"=>"3","50"=>"1","54"=>"48","55"=>"50","27"=>"88","70"=>"91","75"=>"92");
				if(in_array($onearr["itemID"],$toskiparr)){continue;}
				if(in_array($onearr["itemID"],array_keys($toreparr))){$newid = $toreparr[$onearr["itemID"]];}
				//check if transaction number exist or not.
				$username = 'imran';
				$whrarr = array("transaction_number"=>$transactionNumber,"created_by"=>$username,"transaction_type_id"=>2);
				$countdrafts = $this->common->count_record("epi_stock_master",$whrarr);		
				$this->db->trans_start();
				if($countdrafts){
					//draft already exist, update counter and add items in batch
					$resultrow = $this->common->get_info("epi_stock_master",NULL,NULL,"pk_id as id,transaction_counter,stakeholder_activity_id",$whrarr,array("by"=>"pk_id","type"=>"desc"));
					$recordnumber = ($resultrow->transaction_counter+1);
					$datatoupdate = array(
						"transaction_counter" => $recordnumber
					);
					$this->common->update_record("epi_stock_master",$datatoupdate,$whrarr);
					$recid = $resultrow->id;
					$purposeid = $resultrow->stakeholder_activity_id;
				}else{
					//this record is new fetch and insert into master table and generate transaction number	
					$recordnumber = 1;//later it will be updated
					$purposeid = $this->get_fed_purpose_id($onearr["Purpose"]);
					$datatosave = array(
						"transaction_date" => $onearr["transactionDateTime"],
						"transaction_number" => $transactionNumber,//later it will be changed according to our protocol for dynamic behaviour
						"transaction_counter" => $recordnumber,
						"transaction_reference" => '',
						"draft" => 0,
						"comments" => "",
						"transaction_type_id" => 2, // Issue
						"from_warehouse_type_id" => 1, //Federal
						"from_warehouse_code" => 1, //Federal
						"to_warehouse_type_id" => 2, //Provincial
						"to_warehouse_code" => $_SESSION["Province"], //For Province KP
						"stakeholder_activity_id" => $purposeid,
						"created_by" => 'imran',
						"created_date" => date("Y-m-d H:i:s")
					);
					$recid = $this->common->insert_record("epi_stock_master",$datatosave,'stock_master_id_seq');
					$newfetchedvouchers[] = $transactionNumber;
				}
				$manufacturer = $this->get_manufacturer_id($onearr["manufacturer"]);
				$stckholder_item_id = ($newid)?$newid:$this->get_stackholder_item_id($purposeid,$onearr["itemName"]);
				$vvm_type_id = $this->get_vvm_type_id($onearr["vvmTypeName"]);
				$vvm_stage_id = $this->get_vvm_stage_id($onearr["vvmStage"]);
				$item_unit_id = $this->get_item_unit_id($onearr["itemUnitName"]);
				$datatosavebatch = array(
					"number" => $onearr["batchNumber"],
					"batch_master_id" => $recid,
					"expiry_date" => $onearr["expiryDate"],
					"quantity" => $onearr["issuedQty"],
					"unit_price" => $onearr["unitPrice"],
					"production_date" => $onearr["productionDate"],
					"last_update" => date("Y-m-d H:i:s"),
					"stakeholder_id" => $manufacturer,
					"item_pack_size_id" => $stckholder_item_id,//here
					"status" => 'Stacked',
					"vvm_type_id" => $vvm_type_id,
					"warehouse_type_id" => 2, //Provincial
					"code" => $_SESSION["Province"], //For Province KP
					"created_by" => 'imran',
					"created_date" => date("Y-m-d H:i:s")
				);
				$batchid = $this->common->insert_record("epi_stock_batch",$datatosavebatch);
				$datatosavedetail = array(
					"quantity" => $onearr["issuedQty"],
					"vvm_stage" => $vvm_stage_id,
					"is_received" => 0,
					"stock_master_id" => $recid,
					"stock_batch_id" => $batchid,
					"item_unit_id" => $item_unit_id,
					"created_by" => $username,
					"created_date" => date("Y-m-d H:i:s")
				);
				$detailid = $this->common->insert_record("epi_stock_detail",$datatosavedetail);
				$masterpk = $recid;
				$arr_ids=array('master_id'=>$masterpk,'batch_id'=>$batchid,'detail_id'=>$detailid);
				$this->save_all_history($arr_ids,$countdrafts);
				$this->db->trans_complete();
			}
			echo 'New Vouchers fetched Successfully ('.(implode(",",$newfetchedvouchers)).')';
		}
	}	
	public function get_fed_purpose_id($purposename){ 
		$purposeid = $this->common->get_info("epi_stakeholder_activities",NULL,NULL,"pk_id as id",array("activity"=>$purposename));
		return (isset($purposeid->id))?$purposeid->id:NULL; 
	}
	public function get_manufacturer_id($stakeholdername){
		$stckholderdata = $this->common->get_info("epi_stakeholders",NULL,NULL,"pk_id as id",array("stakeholder_name"=>$stakeholdername));
		return (isset($stckholderdata->id))?$stckholderdata->id:NULL;
	}
	public function get_stackholder_item_id($activity_id,$itemname){
		$stckholderdata = $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"pk_id as id",array("item_name"=>$itemname,"activity_type_id"=>$activity_id));
		return (isset($stckholderdata->id))?$stckholderdata->id:NULL;
	}
	public function get_vvm_type_id($vvmtype){
		$vvmdata = $this->common->get_info("epi_vvm_types",NULL,NULL,"pk_id as id",array("vvm_type_name"=>$vvmtype));
		return (isset($vvmdata->id))?$vvmdata->id:NULL;
	}
	public function get_vvm_stage_id($vvmstage){
		$vvmdata = $this->common->get_info("vvm_stages",NULL,NULL,"value as id",array("name"=>$vvmstage));
		return (isset($vvmdata->id))?$vvmdata->id:NULL;
	}
	public function get_item_unit_id($itemunit){
		$itemdata = $this->common->get_info("epi_item_units",NULL,NULL,"pk_id as id",array("item_unit_name"=>$itemunit));
		return (isset($itemdata->id))?$itemdata->id:0;
	}
	/* public function get_number_of_doses($stckholder_item_id){
		$dosesdata = $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"number_of_doses as id",array("pk_id"=>$stckholder_item_id));
		return (isset($dosesdata->id))?$dosesdata->id:NULL;
	} */
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_all_history
	@ Description:   This function inserts history data into all 3 tables depending upon master id in parameter.
	*/
	public function save_all_history($array_ids,$countdrafts){
		$rowdata = $this->common->get_info("epi_stock_master",NULL,NULL,"*",array("pk_id"=>$array_ids['master_id']));
		//create history for master,batch nd detail
		//into master history tables
		$masterhistory =(array) $rowdata;
		unset($masterhistory["pk_id"]);
		$masterhistory["master_id"] = $array_ids['master_id'];
		if($countdrafts){
			
			//setting transactionNumber remaining in master history.
			//setting here transaction_counter
				$this->db->set('transaction_counter',"transaction_counter+1",FALSE);
				$this->db->where('master_id',$array_ids['master_id']);
				$this->db->update('epi_stock_master_history');
			
		}
		else{
			$this->common->insert_record("epi_stock_master_history",$masterhistory);
		}
		//into batch history tables
		$batchdata = $this->common->fetchall("epi_stock_batch",NULL,"*",array("batch_master_id"=>$array_ids['master_id'],'pk_id'=>$array_ids['batch_id']));
		foreach($batchdata as $onebatch){
			$onebatch["batch_id"] = $onebatch["pk_id"];unset($onebatch["pk_id"]);
			$this->common->insert_record("epi_stock_batch_history",$onebatch);
		}		
		//into detail history tables
		$detaildata = $this->common->fetchall("epi_stock_detail",NULL,"*",array("stock_master_id"=>$array_ids['master_id'],'pk_id'=>$array_ids['detail_id']));
		foreach($detaildata as $onedetail){
			$onedetail["detail_id"] = $onedetail["pk_id"];unset($onedetail["pk_id"]);
			$this->common->insert_record("epi_stock_detail_history",$onedetail);
		}
		//end
	}
	/*
	@ Author:        Raja Imran Qamer
	@ Email:         rajaimranqamer@gmail.com
	@ Function:      save_all_history
	@ Description:   This function will fetch history of already fetched voucher from federal.
	*/
	public function fetch_fed_voucher_history(){
		$data["data"]["fetchedrec"] = $this->common->fetchall("epi_stock_master",NULL,NULL,"transaction_number like 'I%-fed'",NULL,array("by"=>"transaction_number","type"=>"DESC"),NULL,NULL,100);
		//$data["data"]["fetchedrec"] = $this->common->fetchall("epi_stock_master",NULL,NULL,"transaction_number like 'I%-fed' or transaction_number like 'R%' and from_warehouse_type_id='1' and to_warehouse_type_id='2' and to_warehouse_code='3'",NULL,array("by"=>"transaction_number","type"=>"DESC"),NULL,NULL,100);
		//print_r($rowdata);exit;
		// echo $this->db->last_query(); exit;
		$wh_whrarr = array("epi_stock_batch.status !="=>'Finished',"epi_stock_batch.warehouse_type_id"=>$this->session->curr_wh_type,"epi_stock_batch.code"=>$this->session->curr_wh_code,"epi_stock_master.draft"=>0,"epi_stock_master.transaction_type_id"=>2);
		$data['data']['vouchers'] = $this->common->fetchall("epi_stock_master",array("table"=>"epi_stock_batch","tablecol"=>"batch_master_id","id"=>"pk_id"),"DISTINCT ON (epi_stock_master.transaction_number) epi_stock_master.transaction_number",$wh_whrarr,NULL,array("by"=>"epi_stock_master.transaction_number","type"=>"ASC"));
		$data['fileToLoad'] = 'inventory_management/stock_received_from_fed';
		$data['pageTitle'] = 'EPI-MIS | Stock Fetched (Federal)';
		$this->load->view('template/epi_template',$data);
	}
	public function delete_fetch_fed_issuance(){
		$vouchernum = $this -> input -> post('id');
		$data['output'] = $this->invnrep->voucher_detail_productwise($vouchernum);
		$result=$this->load->view('inventory_management/stock_received_from_fed_delete',$data,true);
		echo $result;
	}
	public function delete_product(){
		$voucher_number = $this->input->post("voucher_number"); 
		$master_id = $this->input->post("master_id"); 
		$batch_id = $this->input->post("batch_id"); 
		$detail_id = $this->input->post("detail_id"); 
		$data['master_id'] = $this->invnrep->master_id_delete($voucher_number,$master_id);
		$data['batch_id'] = $this->invnrep->batch_id_delete($batch_id,$master_id);
		$data['detail_id'] = $this->invnrep->detail_id_delete($detail_id,$master_id);
		echo json_encode($data,true);
	}
}
?>