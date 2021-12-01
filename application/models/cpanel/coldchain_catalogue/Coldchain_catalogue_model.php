<?php
class Coldchain_catalogue_model extends CI_Model {
	//================ Constructor Function Starts ================//
	public function __construct() 
	{
		parent::__construct();
		$this-> load-> model('Common_model');
		$this-> load-> helper('my_functions_helper');
		$this-> load-> helper('epi_reports_helper');
	}
	
	//--------------Level Models Starts--------------------
	public function allassets_list($per_page,$startpoint,$multiple_search)
	{
		$query ="select epi_cc_models.pk_id,make_name,model_name,catalogue_id,
		assetname(ccm_sub_asset_type_id) as assetname,is_active from epi_cc_models join epi_cc_makes
		on epi_cc_models.ccm_make_id=epi_cc_makes.pk_id  where {$multiple_search} order by assetname   
		LIMIT {$per_page} OFFSET {$startpoint}";
		//echo $query; exit;
		$result = $this -> db -> query($query);
		$data['refrigerator_data'] = $result -> result_array();
		return $data;
	}
	public function coldchainlist($start,$length,$order,$dir,$multiple_search,$id=null)
	{
		$query ="select epi_cc_models.pk_id,make_name,model_name,catalogue_id,
		assetname(ccm_sub_asset_type_id),is_active from epi_cc_models join epi_cc_makes
		on epi_cc_models.ccm_make_id=epi_cc_makes.pk_id  where {$multiple_search} {$order} LIMIT {$length} OFFSET {$start}";
		//echo $query; exit;
		$result = $this -> db -> query($query);
		$data['data'] = $result -> result_array();
		return $data;
	}
	public function coldchaintotal($multiple_search,$id=null)
	{
		$query ="select count(*) AS num from epi_cc_models join epi_cc_makes
		on epi_cc_models.ccm_make_id=epi_cc_makes.pk_id  where {$multiple_search}";
		//echo $query; exit;
		$query = $this->db->query($query);
		$result = $query->row();
		if(isset($result)) return $result->num;
		return 0;
	}
	public function get_all_coldchain_assets_types($id=NULL){
		$wc ="";
		if($id!=NULL){
			$wc ="and parent_id='{$id}'";
		}
		$query = "select * from epi_cc_asset_types where status='1' $wc";
		$results = $this -> db -> query($query);
		return $results -> result_array();
	}
	public function getRrefVaccData($recordID)///for refrigerator and vaccine carrie
	{
		$this->db->select("epi_cc_models.pk_id,ccm_make_id,make_name, model_name, catalogue_id, assetname(ccm_sub_asset_type_id), asset_type_id,is_pqs,asset_dimension_length,asset_dimension_width,asset_dimension_height,gross_capacity_4,gross_capacity_20,net_capacity_4,net_capacity_20,cfc_free,gas_type,product_price,power_source,
		internal_dimension_length,internal_dimension_width,internal_dimension_height,nominal_voltage,continous_power,frequency,input_voltage_range,output_voltage_range,no_of_phases,asset_dimension_length,asset_dimension_width,asset_dimension_height,storage_dimension_length,storage_dimension_width,storage_dimension_height,cold_life",FALSE);
		$this->db->from("epi_cc_models");
		$this->db->join("epi_cc_makes","epi_cc_models.ccm_make_id = epi_cc_makes.pk_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array(); //echo $this->db->last_query(); exit();
	}
	public function status_update($id,$status) {
		$query="update epi_cc_models SET is_active = '$status' WHERE pk_id ='$id'";
		//print_r($query); exit();
		$result = $this-> db-> query($query);	 
		return $result; 
	}
	//--------------Training Models End--------------------
}//End of level list model
