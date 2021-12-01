<?php
class Stockout_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
	}
	//============================ Constructor Function Ends ============================//
	public function get_vacc_stock_out_data($fmonth,$itemId,$distcode=NULL)
	{
		$parts = explode("-",$fmonth);
		if(isset($parts[0]) && isset($parts[1])){
			$query ="select array_agg('epi_consumption_detail.item_id='||pk_id) ids from epi_item_pack_sizes where cr_table_row_numb is not NULL and epi_item_pack_sizes.item_id = $itemId";
			$query = $this->db->query($query);
			$itemsidarr = $query->row()->ids;
			if($itemsidarr){
				$year = $parts[0];
				$monthnum = 'duem'.ltrim($parts[1], '0');
				$selectcolumns = "distcode as code,district as name";
				$table = "districts_wise_maps_paths tbl";					
				$duepart = "(SELECT sum($monthnum) FROM consumptioncompliance where year = '".$year."' and distcode = tbl.distcode)";
				$subcode = " and distcode = tbl.distcode";
				$stockout = "get_pro_level_all_fac_stock_out_new('$itemsidarr','$fmonth','distcode',tbl.distcode)";
				if($distcode){
					$wc = "fac.uncode = tbl.uncode and tbl.distcode = '{$distcode}'";
					$selectcolumns = "uncode as code,ucname as name";
					$table = "uc_wise_maps_paths tbl where tbl.distcode='$distcode'";
					$duepart = "(SELECT SUM(case when getfstatus_vacc('{$fmonth}', fac.facode)='F' then 1 else 0 end) as cnt from facilities fac where {$wc} AND fac.is_vacc_fac='1' and fac.hf_type='e')";
					$subcode = " and uncode = tbl.uncode";
					$stockout = "get_pro_level_all_fac_stock_out_new('$itemsidarr','$fmonth','uncode',tbl.uncode)";
				}
				$query ="
				select 
				$selectcolumns,
				path,
				$duepart as due,
				(SELECT count(*) FROM epi_consumption_master where fmonth = '".$fmonth."' $subcode) as submitted,
				$stockout as stockout 
				from $table";
				$query = $this->db->query($query);
				return $query->result_array();
			}
			return array();
		}
		return array();
	}
}
?>