<?php
class Vouchers_model extends CI_Model {
	public function get_voucher_detail($masterid)
	{
		/* $statuswhr = '';
		if($status)
			$statuswhr = " and asset_status = '".$status."'";
		$query ="select 
			assets.asset_type_name,
			(
				select count(ccm.*) from epi_cc_coldchain_main ccm 
				LEFT JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id 
				LEFT JOIN epi_cc_asset_status_history history ON history.pk_id = ccm.ccm_status_history_id
				where ccm.ccm_sub_asset_type_id = ANY (assets.ids) $statuswhr
			) as available 
		FROM 
			(
				select 
					epi_cc_asset_types.asset_type_name,
					(
						select array_agg(inn.pk_id) as ids from epi_cc_asset_types inn where (inn.pk_id =  epi_cc_asset_types.pk_id OR inn.parent_id =  epi_cc_asset_types.pk_id)
					) as ids
				FROM epi_cc_asset_types
				where parent_id = 0
			) as assets";
		$query = $this->db->query($query); */
		
		$this->db->select("batch.pk_id as batchid,batch.number as batchnumber,batch.expiry_date,batch.quantity,batch.item_pack_size_id,batch.vvm_type_id,batch.stakeholder_id, stackholdername(batch.stakeholder_id) as manuf_name, get_product_name(item_pack_size_id) as itemname,itemunitname(detail.item_unit_id) as item_unit_name,ips.item_category_id,ips.number_of_doses as dosesinvial,detail.pk_id as detailid,detail.vvm_stage,get_stackholder_activity_name(ips.activity_type_id) as purpose");
		$this->db->from("epi_stock_batch batch");
		$this->db->join("epi_stock_detail detail","detail.stock_batch_id = batch.pk_id");
		$this->db->join("epi_item_pack_sizes ips","ips.pk_id = batch.item_pack_size_id");
		$this->db->where(array("batch.batch_master_id"=>$masterid,"batch.status != "=>'Finished'));
		return $this->db->get()->result_array();
	}
}
?>