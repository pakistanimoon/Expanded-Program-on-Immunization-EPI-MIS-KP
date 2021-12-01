<?php
/**************************************************************************/
/******************** This Class will automatically    ********************/
/******************** Calculate and suggest some       ********************/
/******************** values based upon given data     ********************/
/******************** Author: Raja Imran Qamer Gakhar  ********************/
/******************** Email: rajaimranqamer@gmail.com  ********************/
/**************************************************************************/
class Suggestion extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('epi_reports_helper');
		authentication();
		$this -> load -> helper('inventory_helper');
		$this -> load -> model ('Inventory_model',"invn");
		$this -> load -> model ('Suggestion_model',"suggestion");
		$this -> load -> model ('Common_model',"common");
	}
	/****************************************************/
	/********* This function will show list of all warehouses *********/
	/********* with last requisition date and update/refresh  *********/
	/****************************************************/
	function auto_req_cache()
	{
		$currwhtype = $this->session->curr_wh_type;
		$currwhcode = $this->session->curr_wh_code;
		if($currwhtype=="2"){
			$jointable = "districts";
			$joincol = "distcode";
			$selectcol = "distcode as code,district as name";
			$groupcol = "distcode,district";
			$whr = "wh_level = 4";
			$storetype = 4 ;
			$whrarr = array("procode"=>$currwhcode);
		}else if($currwhtype=="4"){
			$jointable = "facilities";
			$joincol = "facode";
			$selectcol = "facode as code,fac_name as name";
			$groupcol = "facode,fac_name";
			$whr = "wh_level = 6";
			$storetype = 6 ;
			$whrarr = array("distcode"=>$currwhcode,"is_vacc_fac"=>'1');
		}else {
			redirect(base_url().'Home', 'refresh');exit;
		}
		//fetch on active facilities/districts here and show in list
		$allwarehouses = $this->common->fetchall($jointable,array("table"=>"auto_req_cache","tablecol"=>"wh_code and ".$whr,"id"=>$joincol),$selectcol.",count(auto_req_cache.*) as totalitems,max(auto_req_cache.rec_datetime) as \"Record Date\"",$whrarr,$groupcol,array("by"=>"code","type"=>"desc"));
		$data['data']['allwarehouses'] = $allwarehouses;
		$data['data']['storetype'] = $storetype;
		$data['fileToLoad'] = 'inventory_management/requisition/requisition_list';
		$data['pageTitle'] = 'EPI-MIS | Requisition';
		$this->load->view('template/epi_template',$data);
	}
	function requisition_refresh()
	{
		$storecode = $this->input->post("storecode");
		$storetype = $this->input->post("storetype");
		$datetime = date('Y-m-d H:i:s');
		$curryear = date("Y",strtotime($datetime));
		$type = 'district';
		if($storetype==6){
			$type = 'facility';
		}
		$targets 		= $this->common->get_info("provinces",NULL,NULL,"							getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision as newborn,getmonthly_survivinginfantspop('".$storecode."','".$type."','".$curryear."')::double precision as surviving,getmonthly_plwomen_targetpop('".$storecode."','".$curryear."')::double precision as plwomen",array("procode"=>'3'));
		$newborn = $targets->newborn;
		$surviving = $targets->surviving;
		$plwomen = $targets->plwomen;
		//$prevfmonth = $this ->suggestion->get_latest_fmonth($storecode);
		$existingitems = $this->suggestion-> get_existing_items($storecode);
		foreach($existingitems as $eachitem){
			$doses		= ($eachitem['doses'])?$eachitem['doses']:1;
			$category	= ($eachitem['item_category_id'])?$eachitem['item_category_id']:1;
			$product	= $eachitem['pk_id'];
			$rownum		= 1 ;
			if($rownum>0){
				if($storetype==6){
					if($category==3){
						$required		= 0 ;
					} else {
						//Target*no of vaccination with this vaccine*wastage rate*period in months to fullfill minnimum stocklevel requirement.
						$itemdata 		= $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"
							(
								case 
									when item_id IN (2,8,9,20) then $newborn*multiplier*wastage_rate_allowed*1.5
									when item_id IN (15) then (
										($newborn*1*wastage_rate_allowed*1.5)
										+
										($surviving*(multiplier-1)*wastage_rate_allowed*1.5)
									)
									when item_id IN (3,4,5,7,17,19,21,22,23,24,26) then $surviving*multiplier*wastage_rate_allowed*1.5
									when item_id IN (6) then $plwomen*multiplier*wastage_rate_allowed*1.5 
									else 0 
								end
							) as minstockreq
						",array("pk_id" =>$product));
						$required		= $itemdata->minstockreq;
					}
					$detaildata 		= $this->common->get_info("epi_consumption_master",NULL,NULL,"sum(closing_vials) as balance",array("facode"=>$storecode,"item_id"=>$product),array("by"=>"fmonth","type"=>"Desc"),"fmonth",array("table"=>"epi_consumption_detail","id"=>"pk_id","tablecol"=>"main_id"));
					//$stockbalance	= isset($detaildata->balance)?$detaildata->balance:0;
					$availbalance		= isset($detaildata->balance)?$detaildata->balance:0;
				}else if($storetype==4){
					$currtimestamp 		= date("Y-m-d H:i:s",strtotime($datetime));
					if($category==3){
						$required		= 0;
					}else{
						//Target*no of vaccination with this vaccine*wastage rate*period in months to fullfill minnimum stocklevel requirement.
						$itemdata 		= $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"
							(
								case 
									when item_id IN (2,8,9,20) then $newborn*multiplier*wastage_rate_allowed*2
									when item_id IN (15) then (
										($newborn*1*wastage_rate_allowed*2)
										+
										($surviving*(multiplier-1)*wastage_rate_allowed*2)
									)
									when item_id IN (3,4,5,7,17,19,21,22,23,24,26) then $surviving*multiplier*wastage_rate_allowed*2
									when item_id IN (6) then $plwomen*multiplier*wastage_rate_allowed*2 
									else 0 
								end
							) as minstockreq
						",array("pk_id" =>$product));
						$required		= $itemdata->minstockreq;
					}
					$detaildata 	= $this->common->get_info("epi_consumption_master",NULL,NULL,"get_curr_stock_quantity ('".$currtimestamp."', '".$storetype."', '".$storecode."', ".$product.") as distbalance,
					sum(closing_vials) as balance",array("distcode"=>$storecode,"item_id"=>$product),array("by"=>"fmonth","type"=>"Desc"),"fmonth",array("table"=>"epi_consumption_detail","id"=>"pk_id","tablecol"=>"main_id"));
					$facbalance		= (isset($detaildata->balance) && $detaildata->balance >= 0)?$detaildata->balance:0;
					$distbalance	= (isset($detaildata->distbalance) && $detaildata->distbalance >= 0)?$detaildata->distbalance:0;
					$stockbalance	= $facbalance+$distbalance;
					$availbalance	= $distbalance;
					//$data['balanceParts'] = array("facbalance"=>$facbalance,"distbalance"=>$distbalance);
				}else{
					$stockbalance 	= 0;
					$availbalance 	= 0;
					$required		= 0;
					$requisition 	= 0;
				}
				//$balanceInDoses 	= $stockbalance*$doses;
				$balanceInDoses 	= $availbalance*$doses;
				$requisition 		= $required-$balanceInDoses;
				if($requisition<0){
					$requisition 	= 0;
				}
			}else{
				$stockbalance 	= 0;
				$$availbalance 	= 0;
				$required		= 0;
				$requisition 	= 0;
			}
			$data[] = array(
				"wh_level"=> $storetype,
				"wh_code"=> $storecode,
				"activity"=>1,
				"item_id"=>$product,
				"suggested"=>ceil($required/$doses),
				"available"=>$availbalance,
				"requisition"=>ceil($requisition/$doses),
				"rec_datetime"=>$datetime);
		}
		//echo json_encode($data,true); exit;
		$store_data = 	$this->suggestion->store_data($storecode);
		if($store_data){
			$data_insert_history = 	$this->suggestion->suggestion_data_history_save($store_data);
			if($data_insert_history){
				$del_data = $this->suggestion->del_store_data($storecode);
			}
		}
		$data_insert 	= 	$this->suggestion->suggestion_data_save($data);
		if($data_insert)
		{
			$currwhtype = $this->session->curr_wh_type;
			$currwhcode = $this->session->curr_wh_code;
			if($currwhtype=="2"){
				$jointable = "districts";
				$joincol = "distcode";
				$selectcol = "distcode as code,district as name";
				$groupcol = "distcode,district";
				$whr = "wh_level = 4";
				$storetype = 4 ;
				$whrarr = array("procode"=>$currwhcode,"wh_code"=>$storecode);
			}else if($currwhtype=="4"){
				$jointable = "facilities";
				$joincol = "facode";
				$selectcol = "facode as code,fac_name as name";
				$groupcol = "facode,fac_name";
				$whr = "wh_level = 6";
				$storetype = 6 ;
				$whrarr = array("distcode"=>$currwhcode, "facode"=>$storecode );
			}
			
			//fetch on active facilities/districts here and show in list
			$warehouse_row = $this->common->fetchall($jointable,array("table"=>"auto_req_cache","tablecol"=>"wh_code and ".$whr,"id"=>$joincol),$selectcol.",count(auto_req_cache.*) as totalitems,max(auto_req_cache.rec_datetime) as \"RecordDate\"",$whrarr,$groupcol,array("by"=>"code","type"=>"desc"));
			$warehouse_row[0]['storetype'] = $storetype;
		}
		echo json_encode($warehouse_row[0],true); exit;
	}
	/****************************************************/
	/********* This function will automatically *********/
	/********* Calculate Requisition of HF and  *********/
	/********* district for next 45 and 60 days *********/
	/********* respectively based upon given    *********/
	/********* Closing balance of previous      *********/
	/********* submitted report.                *********/
	/****************************************************/
	function autoProdRequisition()
	{
		$storecode	= $this->input->post("storecode");
		$storetype	= $this->input->post("storetype");
		$product	= $this->input->post("product");
		$rownum		= ($this->input->post("rownum"))?$this->input->post("rownum"):1;
		$doses		= ($this->input->post("doses"))?$this->input->post("doses"):1;
		$category	= ($this->input->post("category"))?$this->input->post("category"):1;
		$datetime	= ($this->input->post("trans_date_time"))?$this->input->post("trans_date_time"):1;
		if($rownum>0){
			if($storetype==6){
				$curryear 		= date("Y",strtotime($datetime));
				if($category==3){
					$required		= 0;
				}else{
					//Target*no of vaccination with this vaccine*wastage rate*period in months to fullfill minnimum stocklevel requirement.
					$itemdata 		= $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"
						(
							case 
								when item_id IN (2,8,9,20) then getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5
								when item_id IN (15) then (
									(getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*1*wastage_rate_allowed*1.5)
									+
									(getmonthly_survivinginfantspop('".$storecode."','facility','".$curryear."')::double precision*(multiplier-1)*wastage_rate_allowed*1.5)
								)
								when item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop('".$storecode."','facility','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5
								when item_id IN (6) then getmonthly_plwomen_targetpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*1.5 
								else 0 
							end
						) as minstockreq
					",array("pk_id" =>$product));
					$required		= $itemdata->minstockreq;
				}
				//$detaildata 	= $this->common->get_info("form_b_cr",NULL,NULL,"cr_r".$rownum."_f4 as vaccinated,cr_r".$rownum."_f6 as balance",array("facode"=>$storecode),array("by"=>"fmonth","type"=>"Desc"));
				$detaildata 	= $this->common->get_info("epi_consumption_master",NULL,NULL,"sum(closing_vials) as balance",array("facode"=>$storecode,"item_id"=>$product),array("by"=>"fmonth","type"=>"Desc"),"fmonth",array("table"=>"epi_consumption_detail","id"=>"pk_id","tablecol"=>"main_id"));
				$stockbalance	= $detaildata->balance;
				$availbalance	= $detaildata->balance;
			}else if($storetype==4){
				$currtimestamp 	= date("Y-m-d H:i:s",strtotime($datetime));
				$curryear 		= date("Y",strtotime($datetime));
				if($category==3){
					$required		= 0;
				}else{
					//Target*no of vaccination with this vaccine*wastage rate*period in months to fullfill minnimum stocklevel requirement.
					$itemdata 		= $this->common->get_info("epi_item_pack_sizes",NULL,NULL,"
						(
							case 
								when item_id IN (2,8,9,20) then getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*2
								when item_id IN (15) then (
									(getmonthlynewborn_targetpopulationpop('".$storecode."','".$curryear."')::double precision*1*wastage_rate_allowed*2)
									+
									(getmonthly_survivinginfantspop('".$storecode."','district','".$curryear."')::double precision*(multiplier-1)*wastage_rate_allowed*2)
								)
								when item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop('".$storecode."','district','".$curryear."')::double precision*multiplier*wastage_rate_allowed*2
								when item_id IN (6) then getmonthly_plwomen_targetpop('".$storecode."','".$curryear."')::double precision*multiplier*wastage_rate_allowed*2 
								else 0 
							end
						) as minstockreq
					",array("pk_id" =>$product));
					$required		= $itemdata->minstockreq;
				}
				$detaildata 	= $this->common->get_info("epi_consumption_master",NULL,NULL,"get_curr_stock_quantity ('".$currtimestamp."', '".$storetype."', '".$storecode."', ".$product.") as distbalance,
				sum(closing_vials) as balance",array("distcode"=>$storecode,"item_id"=>$product),array("by"=>"fmonth","type"=>"Desc"),"fmonth",array("table"=>"epi_consumption_detail","id"=>"pk_id","tablecol"=>"main_id"));
				$facbalance		= $detaildata->balance;
				$distbalance	= $detaildata->distbalance;
				$stockbalance	= $facbalance+$distbalance;
				$availbalance	= $distbalance;
				$data['balanceParts'] = array("facbalance"=>$facbalance,"distbalance"=>$distbalance);
			}else{
				$stockbalance 	= 0;
				$$availbalance 	= 0;
				$required		= 0;
				$requisition 	= 0;
			}
			//$balanceInDoses 	= $stockbalance*$doses;
			$balanceInDoses 	= $availbalance*$doses;
			$requisition 		= $required-$balanceInDoses;
			if($requisition<0){
				$requisition 	= 0;
			}
		}else{
			$stockbalance 	= 0;
			$$availbalance 	= 0;
			$required		= 0;
			$requisition 	= 0;
		}
		$data['balance']	= $stockbalance;
		$data['required']	= ceil($required/$doses);
		$data['requisition']= ceil($requisition/$doses);
		echo json_encode($data);
	}
	public function fetch_req_cache(){
		$storecode	= $this->input->post("storecode");
		$storetype	= $this->input->post("storetype");
		$store_data = 	$this->suggestion->fetch_req_data($storecode, $storetype);
		echo json_encode($store_data);
	}
}
?>