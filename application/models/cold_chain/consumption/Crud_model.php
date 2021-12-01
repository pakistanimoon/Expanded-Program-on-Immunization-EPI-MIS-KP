<?php
class Crud_model extends CI_Model {
	public function __construct()
	{
		//$this -> load -> model ('Common_model',"common");
		//nothing to do here yet
	}
	public function consumption_list($limit=0,$start=0){
		$this->db->select("pk_id as id, facode, facilityname(facode) as fac_name,unname(uncode) as uc,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date ");
		$this->db->from("epi_consumption_master");
		$this->db->where("procode",$this -> session ->Province);
		$this->db->where("distcode",$this -> session ->District);
		$this->db->order_by("fmonth","desc");
		$this->db->order_by("facode", "asc");
		$this->db->limit($limit,$start);
        return  $this -> db -> get() -> result_array();
		//echo $this->db->last_query();
	}
	public function get_issued_items($activity,$whtype,$whcode,$fmonth)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,epi_item_pack_sizes.number_of_doses doses,batch.number as batch,0 as opening,(sum(batch.quantity)*epi_item_pack_sizes.number_of_doses) as recdoses,epi_items.in_doses,epi_item_pack_sizes.item_category_id");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.warehouse_type_id'] = $whtype;
		$whereCondition['batch.code'] = $whcode;
		$whereCondition['epi_item_pack_sizes.activity_type_id'] = $activity;
		$this -> db -> where($whereCondition);
		$this -> db -> like('(master.transaction_date)::text',$fmonth);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->join("epi_items","epi_item_pack_sizes.item_id = epi_items.pk_id","LEFT OUTER");
        $this -> db -> order_by('batch.number','asc');
		$this -> db -> group_by('epi_item_pack_sizes.pk_id,epi_items.list_order,batch.number,epi_items.description,epi_item_pack_sizes.number_of_doses,epi_items.in_doses,epi_item_pack_sizes.item_category_id');
		return $this -> db -> get() -> result_array();
		
	}
	public function get_existing_items($whcode,$fmonth)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,epi_item_pack_sizes.number_of_doses doses,detail.batch_number as batch,detail.closing_doses as opening,0 as recdoses,epi_items.in_doses,epi_item_pack_sizes.item_category_id");
		$whereCondition['master.facode'] = $whcode;
		$whereCondition['master.fmonth'] = $fmonth;
		$whereCondition['detail.closing_doses >'] = 0;
		$whereCondition['epi_item_pack_sizes.status >'] = 0; 
		$this -> db -> where('epi_item_pack_sizes.cr_table_row_numb Is Not Null');
		$this -> db -> where($whereCondition);
		$this -> db -> order_by('detail.batch_number','asc');
		$this -> db -> from('epi_consumption_master master');
		$this -> db -> join('epi_consumption_detail detail','master.pk_id = detail.main_id','left');
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = detail.item_id","LEFT OUTER");
		$this->db->join("epi_items","epi_item_pack_sizes.item_id = epi_items.pk_id","LEFT OUTER");
        return $this -> db -> get() -> result_array(); 
		//echo $this->db->last_query();
	}
	public function get_existing_items_oldtbl($activity,$whcode,$fmonth)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,string_agg(('cr_r'||cr_table_row_numb||'_f6*'||number_of_doses)::text, '+') as openbalformula,epi_items.list_order as rank,epi_items.description itemname,item_name,epi_item_pack_sizes.number_of_doses as doses,'BB2019' as batch,0 as opening,0 as recdoses,epi_items.in_doses,epi_item_pack_sizes.item_category_id");
		$this->db->from("epi_item_pack_sizes");
		$this->db->join("epi_items","epi_items.pk_id = epi_item_pack_sizes.item_id");
        $this -> db -> where('cr_table_row_numb Is Not Null');
        $this -> db -> where('activity_type_id',$activity);
        $this -> db -> group_by('epi_item_pack_sizes.pk_id,epi_items.list_order,epi_items.description,epi_items.in_doses');
		$allitems = $this -> db -> get() -> result_array();
		foreach($allitems as $key=>$oneitem){
			$this -> db -> select("$oneitem[openbalformula] as openingbal",FALSE);
			$whereCondition['facode'] = $whcode;
			$whereCondition['fmonth'] = $fmonth;
			$this -> db -> where($whereCondition);
			$openbal = $this -> db -> get('form_b_cr') -> row();
			if(isset($openbal->openingbal) && ($openbal->openingbal)>0){
				//set opening balance and unset formula
				$oneitem["opening"] = $openbal->openingbal;
				unset($oneitem["openbalformula"]);
				$allitems[$key] = $oneitem;
			}else{
				//unset whole record
				unset($allitems[$key]);
			}
		}
		return $allitems;
	}
	public function consumption_delete($fmonth,$facode)
	{
		$distcode=$this->session->District;
		$sql="DELETE FROM epi_consumption_detail USING epi_consumption_master 
			WHERE epi_consumption_detail.main_id= epi_consumption_master.pk_id AND epi_consumption_master.distcode='$distcode' AND epi_consumption_master.facode='$facode' and  epi_consumption_master.fmonth='$fmonth'";
		$this->db->query($sql);
		$tbl1=$this->db->affected_rows();
		$result="false";
		if($tbl1 > 0)
		{
			$whereCondition['distcode'] = $distcode;
			$whereCondition['facode'] = $facode;
			$whereCondition['fmonth'] = $fmonth;
			$this->db->delete('epi_consumption_adjustment',$whereCondition);
			$this->db->delete('epi_consumption_master',$whereCondition);
			$tbl1=$this->db->affected_rows();
			if($tbl1 > 0 )
				$result="true";
		}
		return $result;
	}
	public function consumption_edit($fmonth,$facode,$view)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,epi_item_pack_sizes.number_of_doses doses,detail.batch_number as batch,detail.opening_doses as opening,detail.closing_doses as closing_doses,detail.closing_vials as closing_vials,received_doses as recdoses,master.pk_id,detail.pk_id as detail_id,adjust.pk_id as adjust_id,detail.unused_vials,detail.unused_doses,detail.used_doses,detail.used_vials,detail.vaccinated,epi_items.in_doses,epi_item_pack_sizes.item_category_id,adjust.adjustment_quantity_vials,adjust.adjustment_quantity_doses,adjust.adjustment_type,get_epi_transaction_type_nature(adjust.adjustment_type) as nature,adjust.comments"); 
		$distcode=$this->session->District;
		if($view==false)
		{
			$whereCondition['master.distcode'] = $distcode;
		}	
		$whereCondition['master.fmonth'] = $fmonth;
		$whereCondition['master.facode'] = $facode;
		$this -> db -> where('(detail.opening_doses > 0 or detail.received_doses >0)');//here change condition and let umar know
		$this -> db -> where($whereCondition);
		$this -> db -> order_by('epi_items.list_order','asc');
		$this -> db -> from('epi_consumption_master master');
		$this -> db -> join('epi_consumption_detail detail','master.pk_id = detail.main_id','left');
		$this->db->join("epi_consumption_adjustment adjust","adjust.detail_id = detail.pk_id","LEFT OUTER");
		$this->db->join("epi_item_pack_sizes","epi_item_pack_sizes.pk_id = detail.item_id","LEFT OUTER");
		$this->db->join("epi_items","epi_item_pack_sizes.item_id = epi_items.pk_id","LEFT OUTER");
        return $this -> db -> get() -> result_array();
		//print_r($this->db->last_query());exit;
	}
	public function formb_consumption_edit($fmonth,$facode,$view)
	{
		$this->db->select("pk_id as id, facode,distcode,facilityname(facode) as fac_name,uncode,unname(uncode) as uc,tcode,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date,hf_incharge ");
		$this->db->from("epi_consumption_master");
		$this->db->where("procode",$this -> session ->Province);
		if($view==false)
		{
		$this->db->where("distcode",$this -> session ->District);
		}
		$whereCondition['facode'] = $facode;
		$whereCondition['fmonth'] = $fmonth;
		$this->db->Where($whereCondition);
		return  $this -> db -> get() ->row(); 
	}
}