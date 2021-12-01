<?php
class Suggestion_model extends CI_Model {
	public function __construct()
	{
		//$this -> load -> model ('Common_model',"common");
		//nothing to do here yet
	}
	// public function get_latest_fmonth($facode)
	// {
	// 	$this -> db -> select('fmonth');
	// 	$this->  db -> where('facode',$facode);
	// 	$this->db->where('fmonth', "(select max(fmonth) from epi_consumption_master)",false);
	// 	$this -> db -> from('epi_consumption_master');
		
	// 	$data =$this -> db -> get() -> result_array();
	// 	//echo $this->db->last_query(); exit;
	// 	return $data[0]['fmonth'];
	// }
	public function get_existing_items($whcode)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as pk_id,epi_item_pack_sizes.item_id as item_id ,epi_items.list_order as rank, epi_items.description itemname, epi_item_pack_sizes.item_name, epi_item_pack_sizes.number_of_doses doses, epi_items.in_doses,0 as recdoses ,epi_item_pack_sizes.item_category_id");
		$whereCondition['epi_item_pack_sizes.status >'] = 0; 
		$this -> db -> where($whereCondition);
		$this -> db -> from('(SELECT * FROM epi_item_pack_sizes where pk_id in (SELECT MAX(pk_id) FROM epi_item_pack_sizes where activity_type_id=1 GROUP BY item_id)) as epi_item_pack_sizes', false);
		$this->db->join("epi_items","epi_items.pk_id = epi_item_pack_sizes.item_id","LEFT OUTER");
		$this->db->order_by('epi_item_pack_sizes.item_id');
		return $this -> db -> get() -> result_array();
	}
	public function suggestion_data_save($data)
	{
		$this->db->insert_batch('auto_req_cache', $data);
		return ($this->db->affected_rows() >= 1) ? true : false ;	
	}
	public function suggestion_data_history_save($history_data)
	{
		$this->db->insert_batch('auto_req_cache_history', $history_data);
		return ($this->db->affected_rows() >= 1) ? true : false ;	
	}
	public function del_store_data($storecode)
	{
		$this->db->where('wh_code', $storecode);
		$this->db->delete('auto_req_cache');
		return ($this->db->affected_rows() >= 1) ? true : false ;	
	}
	public function store_data($storecode)
	{
		$this -> db -> select('wh_level, wh_code, activity, item_id, suggested, available, requisition, rec_datetime');
		$this->db->where('wh_code', $storecode);
		$this -> db -> from('auto_req_cache');
		return $this -> db -> get() -> result_array();
	}
	public function fetch_req_data($storecode,$storetype){
		$data= array();
		if($storetype == 6){
			//$store_data = 	$this->suggestion->fetch_req_data($storecode, $storetype);
			//print_r('hi'); exit;
			$this -> db -> select("item_id, suggested, available, requisition, to_char(rec_datetime, 'YYYY-MM-DD HH24:MI') as rec_datetime");
			$this->db->where('wh_code', $storecode);
			$this -> db -> from('auto_req_cache');
			return $this -> db -> get() -> result_array();
		}else{
			//$store_data = 	$this->suggestion->fetch_req_data($storecode, $storetype);
			//echo "hi"; exit;
			$this -> db -> select("item_id, suggested, available, requisition, to_char(rec_datetime, 'YYYY-MM-DD HH24:MI') as rec_datetime");
			$this->db->where('wh_code', $storecode);
			$this->db->where('wh_level', '4');
			$this -> db -> from('auto_req_cache');
			$distbalance =  $this -> db -> get() -> result_array();

			$this -> db -> select("item_id, sum(available) as facbalance");
			$this->db->like('wh_code', $storecode , 'after'); 
			$this->db->where('wh_level', '6');
			$this -> db -> from('auto_req_cache');
			$this -> db -> group_by('item_id');
			$facbalance =  $this -> db -> get() -> result_array();
			//echo $this->db->last_query(); //exit;
			//print_r($data['facbalance']); exit;
			$data['balanceParts'] = array("facbalance"=>$facbalance,"distbalance"=>$distbalance);
			//print_r($data['balanceParts']);
			return $data;
		}
		
	}
}