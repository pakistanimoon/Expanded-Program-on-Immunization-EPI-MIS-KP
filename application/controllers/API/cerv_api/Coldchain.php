<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coldchain extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('app_api/api_helper');
		$this -> load -> helper('inventory_helper');
		$this -> load -> helper('my_functions_helper');
		$this -> load -> model('API/app_api_model/Common_model','common');
		$this->output->set_content_type('application/json');
	}
	public function info()
	{
		$token = $this -> input -> get('token');
		$curr_wh_type = $this -> input -> get('curr_wh_type');
		$curr_wh_code = $this -> input -> get('curr_wh_code');
		if(isset($token) and $curr_wh_type>1 and $curr_wh_code>0)
		{
			//here check if token is valid or not, just uncomment below code
			/*$validationResult = validateToken($userName, $token);
			if($validationResult == TRUE){}else{
				return $this->output->set_output(json_encode(array("success"=>"no","message"=>"Authentication Failed! Not a Valid Token")));
			}*/
			$wh_whrarr = array(
				'epi_cc_coldchain_main.warehouse_type_id' => $curr_wh_type,
				'epi_cc_coldchain_main.storecode ' => $curr_wh_code
			);
			
			$ccitems = $this->common->fetchall("epi_cc_asset_types",array("table"=>"epi_cc_coldchain_main","tablecol"=>"ccm_sub_asset_type_id","id"=>"pk_id"),"epi_cc_coldchain_main.asset_id,epi_cc_asset_types.asset_type_name,epi_cc_asset_types.short_name as type_short_name,epi_cc_coldchain_main.serial_no,get_asset_status(epi_cc_coldchain_main.asset_id) as status,epi_cc_coldchain_main.short_name as asset_short_name, get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as capacity,(floor(random()*(100+1))+10) as usage_percentage",$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.asset_id","type"=>"DESC"),NULL,array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1,21)));
			$userdata = $ccitems;
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
