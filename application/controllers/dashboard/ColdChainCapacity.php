<?php
class ColdChainCapacity extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('dashboard/dashboard_model','dashboard');
		$this -> load -> model ('Common_model',"common");
	}
	public function cold_chain_capacity()
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		//$data['data']['coldroom']=$this->dashboard->cold_room_capacity($whtype,$whcode);
		$wh_whrarr = array(
			"warehouse_type_id"=>$whtype,
			get_warehouse_code_column($whtype)=>$whcode
		);
		//for coldrooms
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(21));
		$data['data']['coldroom']=$this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d H:i:s")."','".$whtype."','".$whcode."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		//for freezers
		$wh_whrarr_in = array("columname"=>"epi_cc_asset_types.parent_id","valuesarray"=>array(1));
		$data['data']['freezer']=$this->common->fetchall("epi_cc_coldchain_main",array("table"=>"epi_cc_asset_types","tablecol"=>"pk_id","id"=>"ccm_sub_asset_type_id"),
		"epi_cc_coldchain_main.asset_id as id,epi_cc_coldchain_main.short_name as name,epi_cc_asset_types.asset_type_name assettype,get_capacity_litters(epi_cc_asset_types.parent_id,epi_cc_coldchain_main.asset_id,epi_cc_coldchain_main.ccm_model_id) as totcapacity,get_stored_quantity_litters(epi_cc_coldchain_main.asset_id,'".date("Y-m-d H:i:s")."','".$whtype."','".$whcode."') as stored,get_asset_status(epi_cc_coldchain_main.asset_id) as status",
		$wh_whrarr,NULL,array("by"=>"epi_cc_coldchain_main.short_name","type"=>"asc"),NULL,$wh_whrarr_in);
		//$data['data']['freezer']=$this->dashboard->freezer_capacity($whtype,$whcode);
		$template = 'template/epi_template';
		$data['fileToLoad'] = 'dashboard/cold_chain_capacity';
		$data['pageTitle']='Vaccine Distribution Report';
		$this -> load -> view($template,$data);
	}
	public function capacity_by_vaccine()
	{
		$whtype = $this -> session -> curr_wh_type;
		$whcode = $this -> session -> curr_wh_code;
		$data['data']['result']=$this->dashboard->capacity_by_vaccine($whtype,$whcode);
		$template = 'template/epi_template';
		$data['fileToLoad'] = 'dashboard/capacity_by_vaccine';
		$data['pageTitle']='Vaccine Distribution Report';
		$this -> load -> view($template,$data);
	}	
}