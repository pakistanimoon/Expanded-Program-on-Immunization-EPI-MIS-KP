<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
@ Author:       Raja Imran Qamer
@ Email:        rajaimranqamer@gmail.com
@ Class:		Stocks
@ Description:  This class used for stock related CRUD from APIs like cerv or inventory app
*/
class Stocks extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('app_api/api_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> helper('my_functions_helper');
		$this -> load -> model('API/app_api_model/Common_model','common');
		/* $this -> load -> model('Indicator_reports_model'); */
		$this->output->set_content_type('application/json');
	}
	public function info()
	{
		$token = $this -> input -> get('token');
		//$curr_wh_type = $this -> input -> get('curr_wh_type');
		$curr_wh_code = $this -> input -> get('curr_wh_code');
		if(isset($token) /* and $curr_wh_type>1 */ and $curr_wh_code>0)
		{
			//here check if token is valid or not, just uncomment below code
			/*$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}*/
			
			/* $userdata = array(
				'curr_wh_type' => $curr_wh_type,
				'curr_wh_code' => $curr_wh_code
			); */
			
			/* $enddate = date("Y-m-d H:i:s");
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$curr_wh_type."','".$curr_wh_code."',pk_id) as stock",array("activity_type_id"=>'1'),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc")); *///it fetches record from stock table
			
			$lastrep = $this->common->get_info("epi_consumption_master",NULL,NULL,"max(fmonth) as fmonth",array("facode"=>$curr_wh_code));
			$items = array();
			if(isset($lastrep->fmonth)){
				$items = $this->common->fetchall("epi_consumption_detail",array("table"=>"epi_consumption_master","tablecol"=>"pk_id","id"=>"main_id"),"epi_consumption_detail.item_id,get_product_name(epi_consumption_detail.item_id) as item,sum(closing_vials) as stock_vials,sum(closing_doses) as stock_doses,unitname(epi_consumption_detail.item_id) as unit",array("epi_consumption_master.facode"=>$curr_wh_code,"epi_consumption_master.fmonth"=>$lastrep->fmonth),"epi_consumption_detail.item_id",array("by"=>"epi_consumption_detail.item_id","type"=>"asc"));
			}
			
			//$wh_whrarr = array("epi_stock_batch.status !="=>'Finished',"epi_stock_batch.warehouse_type_id"=>$userdata["curr_wh_type"],"epi_stock_batch.code"=>$userdata["curr_wh_code"],"epi_stock_master.draft"=>0,"epi_stock_master.transaction_type_id"=>2);
			
			/* $pendingvouchers = $this->common->fetchall("epi_stock_master",array("table"=>"epi_stock_batch","tablecol"=>"batch_master_id","id"=>"pk_id"),"Count(DISTINCT epi_stock_master.transaction_number) as total",$wh_whrarr); */
			//$pendingvouchers = $this->common->fetchall("epi_stock_master",array("table"=>"epi_stock_batch","tablecol"=>"batch_master_id","id"=>"pk_id"),"DISTINCT ON (epi_stock_master.transaction_number) epi_stock_master.transaction_number",$wh_whrarr,NULL,array("by"=>"epi_stock_master.transaction_number","type"=>"ASC"));
			
			/* $data['report_indicator']="1";
			$data["report_type"]="2";
			$result = $this -> Indicator_reports_model -> gethfclosingdosesdata($data); */
			
			$userdata["lastrep"] = $lastrep;
			$userdata["currentstock"] = $items;
			$response = array('userdata' => $userdata ,'success' => "yes");
		}
		else
		{
			$response['success'] = "no";	
			$response['message'] = "Required Parameters are missing!";
		}
		return $this->output->set_output(json_encode($response));
	}
}