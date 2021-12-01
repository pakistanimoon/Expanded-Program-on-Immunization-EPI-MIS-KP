<?php
class Crud_model extends CI_Model {
	public function __construct()
	{
		$this -> load -> helper('cross_notify_functions_helper');
	}
	public function consumption_list($limit=0,$start=0){
		$this->db->select("pk_id as id, facode, facilityname(facode) as fac_name,unname(uncode) as uc,tehsilname(tcode) as tehsil, fmonth,prepared_by,created_date,data_source");
		$this->db->from("epi_consumption_master");
		$this->db->where("procode",$this -> session ->Province);
		$this->db->where("distcode",$this -> session ->District);
		if($this -> session -> UserLevel==4){
			$this->db->where("tcode",$this -> session ->Tehsil);
		}
		$this->db->where("is_compiled",1);
		$this->db->order_by("fmonth","desc");
		$this->db->order_by("facode", "asc");
		$this->db->limit($limit,$start);
        return  $this -> db -> get() -> result_array();
		//echo $this->db->last_query();
	}
	public function get_issued_items($activity,$whtype,$whcode,$fmonth)
	{
		$this -> db -> select("sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,sizes.number_of_doses doses,batch.number as batch,0 as opening,(sum(batch.quantity)*sizes.number_of_doses) as recdoses,epi_items.in_doses,sizes.item_category_id,sizes.item_id,sizes.multiplier");
		$whereCondition['master.draft'] =0;
		$whereCondition['batch.warehouse_type_id'] = $whtype;
		$whereCondition['batch.code'] = $whcode;
		$whereCondition['sizes.activity_type_id'] = $activity;
		$this -> db -> where($whereCondition);
		$this -> db -> like('(master.transaction_date)::text',$fmonth);
		$this -> db -> from('epi_stock_master master');
		$this -> db -> join('epi_stock_batch batch','master.pk_id = batch.batch_master_id','left');
		$this -> db -> join('epi_stock_detail detail','batch.pk_id = detail.stock_batch_id','left');
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = batch.item_pack_size_id","LEFT OUTER");
		$this->db->join("epi_items","sizes.item_id = epi_items.pk_id","LEFT OUTER");
        $this -> db -> order_by('batch.number','asc');
		$this -> db -> group_by('sizes.pk_id,epi_items.list_order,batch.number,epi_items.description,sizes.number_of_doses,epi_items.in_doses,sizes.item_category_id');
		return $this -> db -> get() -> result_array();
		
	}
	public function get_existing_items($whcode,$fmonth)
	{
		$this -> db -> select("sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,sizes.number_of_doses doses,detail.batch_number as batch,detail.closing_doses as opening,0 as recdoses,epi_items.in_doses,sizes.item_category_id,sizes.item_id,sizes.multiplier");
		$whereCondition['master.facode'] = $whcode;
		$whereCondition['master.fmonth'] = $fmonth;
		$whereCondition['master.is_compiled'] = 1;
		$whereCondition['detail.closing_doses >'] = 0;
		$whereCondition['sizes.status >'] = 0; 
		$this -> db -> where('sizes.cr_table_row_numb Is Not Null');
		$this -> db -> where($whereCondition);
		$this -> db -> order_by('detail.batch_number','asc');
		$this -> db -> from('epi_consumption_master master');
		$this -> db -> join('epi_consumption_detail detail','master.pk_id = detail.main_id','left');
		$this->db->join("epi_item_pack_sizes sizes","sizes.pk_id = detail.item_id","LEFT OUTER");
		$this->db->join("epi_items","sizes.item_id = epi_items.pk_id","LEFT OUTER");
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
		$result="false";
		$this->db->trans_start();
		$sql="DELETE FROM epi_consumption_detail USING epi_consumption_master 
			WHERE epi_consumption_detail.main_id= epi_consumption_master.pk_id AND epi_consumption_master.distcode='$distcode' AND epi_consumption_master.facode='$facode' and  epi_consumption_master.fmonth='$fmonth'";
		$this->db->query($sql);
		//$tbl1=$this->db->affected_rows();
		//$result="false";
		//if($tbl1 > 0)
		//{
			$whereCondition['distcode'] = $distcode;
			$whereCondition['facode'] = $facode;
			$whereCondition['fmonth'] = $fmonth;
			$this->db->delete('epi_consumption_adjustment',$whereCondition);
			$this->db->delete('epi_consumption_master',$whereCondition);
			$this->db->delete('fac_mvrf_db',$whereCondition);
			$this->db->delete('fac_mvrf_od_db',$whereCondition);
			//$tbl1=$this->db->affected_rows();
			//if($tbl1 > 0 )
				$result="true";
		//}
		$this->db->where('fmonth', $fmonth);
		$this->db->where('from_facode', $facode);
		$this->db->delete('monthly_outuc_coverage');
		$this->db->trans_complete();
		return $result;
	}
	public function consumption_edit($fmonth,$facode,$view)
	{
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,epi_items.list_order as rank,epi_items.description itemname,item_name,epi_item_pack_sizes.number_of_doses doses,detail.batch_number as batch,detail.opening_doses as opening,detail.closing_doses as closing_doses,detail.closing_vials as closing_vials,received_doses as recdoses,master.pk_id,detail.pk_id as detail_id,adjust.pk_id as adjust_id,detail.unused_vials,detail.unused_doses,detail.used_doses,detail.used_vials,detail.vaccinated,epi_items.in_doses,epi_item_pack_sizes.item_category_id,adjust.adjustment_quantity_vials,adjust.adjustment_quantity_doses,adjust.adjustment_type,get_epi_transaction_type_nature(adjust.adjustment_type) as nature,adjust.comments,epi_item_pack_sizes.item_id,(case when epi_item_pack_sizes.item_category_id = 1 then epi_item_pack_sizes.multiplier else 1 end) as multiplier"); 
		$distcode=$this->session->District;
		if($view==false)
		{
			$whereCondition['master.distcode'] = $distcode;
		}	
		$whereCondition['master.fmonth'] = $fmonth;
		$whereCondition['master.facode'] = $facode;
		$whereCondition['master.is_compiled'] = 1;
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
		$this->db->where("is_compiled",1);
		if($view==false)
		{
		$this->db->where("distcode",$this -> session ->District);
		}
		$whereCondition['facode'] = $facode;
		$whereCondition['fmonth'] = $fmonth;
		$this->db->Where($whereCondition);
		return  $this -> db -> get() ->row(); 
	}
	public function update_all_vaccinations($fmonth,$facode)
	{  
		$query1="update fac_mvrf_db set ttri_r9_f1 = ttri_r1_f1+ttri_r3_f1+ttri_r5_f1+ttri_r7_f1,ttri_r10_f1 = ttri_r2_f1+ttri_r4_f1+ttri_r6_f1+ttri_r8_f1,ttri_r9_f2 = ttri_r1_f2+ttri_r3_f2+ttri_r5_f2+ttri_r7_f2,ttri_r10_f2 = ttri_r2_f2+ttri_r4_f2+ttri_r6_f2+ttri_r8_f2,ttri_r9_f3 = ttri_r1_f3+ttri_r3_f3+ttri_r5_f3+ttri_r7_f3,ttri_r10_f3 = ttri_r2_f3+ttri_r4_f3+ttri_r6_f3+ttri_r8_f3,ttri_r9_f4 = ttri_r1_f4+ttri_r3_f4+ttri_r5_f4+ttri_r7_f4,ttri_r10_f4 = ttri_r2_f4+ttri_r4_f4+ttri_r6_f4+ttri_r8_f4,ttri_r9_f5 = ttri_r1_f5+ttri_r3_f5+ttri_r5_f5+ttri_r7_f5,ttri_r10_f5 = ttri_r2_f5+ttri_r4_f5+ttri_r6_f5+ttri_r8_f5,ttri_r9_f6 = ttri_r1_f6+ttri_r3_f6+ttri_r5_f6+ttri_r7_f6,ttri_r10_f6 = ttri_r2_f6+ttri_r4_f6+ttri_r6_f6+ttri_r8_f6 where fmonth = '$fmonth' and facode='$facode'";
		$result1=$this->db->query($query1);
		$query2="update fac_mvrf_db set cri_r25_f1 = cri_r1_f1+cri_r3_f1+cri_r5_f1+cri_r7_f1+cri_r9_f1+cri_r11_f1+cri_r13_f1+cri_r15_f1+cri_r17_f1+cri_r19_f1+cri_r21_f1+cri_r23_f1, cri_r26_f1 = cri_r2_f1+cri_r4_f1+cri_r6_f1+cri_r8_f1+cri_r10_f1+cri_r12_f1+cri_r14_f1+cri_r16_f1+cri_r18_f1+cri_r20_f1+cri_r22_f1+cri_r24_f1
			,cri_r25_f2 = cri_r1_f2+cri_r3_f2+cri_r5_f2+cri_r7_f2+cri_r9_f2+cri_r11_f2+cri_r13_f2+cri_r15_f2+cri_r17_f2+cri_r19_f2+cri_r21_f2+cri_r23_f2
			,cri_r26_f2 = cri_r2_f2+cri_r4_f2+cri_r6_f2+cri_r8_f2+cri_r10_f2+cri_r12_f2+cri_r14_f2+cri_r16_f2+cri_r18_f2+cri_r20_f2+cri_r22_f2+cri_r24_f2
			,cri_r25_f3 = cri_r1_f3+cri_r3_f3+cri_r5_f3+cri_r7_f3+cri_r9_f3+cri_r11_f3+cri_r13_f3+cri_r15_f3+cri_r17_f3+cri_r19_f3+cri_r21_f3+cri_r23_f3
			,cri_r26_f3 = cri_r2_f3+cri_r4_f3+cri_r6_f3+cri_r8_f3+cri_r10_f3+cri_r12_f3+cri_r14_f3+cri_r16_f3+cri_r18_f3+cri_r20_f3+cri_r22_f3+cri_r24_f3
			,cri_r25_f4 = cri_r1_f4+cri_r3_f4+cri_r5_f4+cri_r7_f4+cri_r9_f4+cri_r11_f4+cri_r13_f4+cri_r15_f4+cri_r17_f4+cri_r19_f4+cri_r21_f4+cri_r23_f4
			,cri_r26_f4 = cri_r2_f4+cri_r4_f4+cri_r6_f4+cri_r8_f4+cri_r10_f4+cri_r12_f4+cri_r14_f4+cri_r16_f4+cri_r18_f4+cri_r20_f4+cri_r22_f4+cri_r24_f4
			,cri_r25_f5 = cri_r1_f5+cri_r3_f5+cri_r5_f5+cri_r7_f5+cri_r9_f5+cri_r11_f5+cri_r13_f5+cri_r15_f5+cri_r17_f5+cri_r19_f5+cri_r21_f5+cri_r23_f5
			,cri_r26_f5 = cri_r2_f5+cri_r4_f5+cri_r6_f5+cri_r8_f5+cri_r10_f5+cri_r12_f5+cri_r14_f5+cri_r16_f5+cri_r18_f5+cri_r20_f5+cri_r22_f5+cri_r24_f5
			,cri_r25_f6 = cri_r1_f6+cri_r3_f6+cri_r5_f6+cri_r7_f6+cri_r9_f6+cri_r11_f6+cri_r13_f6+cri_r15_f6+cri_r17_f6+cri_r19_f6+cri_r21_f6+cri_r23_f6
			,cri_r26_f6 = cri_r2_f6+cri_r4_f6+cri_r6_f6+cri_r8_f6+cri_r10_f6+cri_r12_f6+cri_r14_f6+cri_r16_f6+cri_r18_f6+cri_r20_f6+cri_r22_f6+cri_r24_f6
			,cri_r25_f7 = cri_r1_f7+cri_r3_f7+cri_r5_f7+cri_r7_f7+cri_r9_f7+cri_r11_f7+cri_r13_f7+cri_r15_f7+cri_r17_f7+cri_r19_f7+cri_r21_f7+cri_r23_f7
			,cri_r26_f7 = cri_r2_f7+cri_r4_f7+cri_r6_f7+cri_r8_f7+cri_r10_f7+cri_r12_f7+cri_r14_f7+cri_r16_f7+cri_r18_f7+cri_r20_f7+cri_r22_f7+cri_r24_f7
			,cri_r25_f8 = cri_r1_f8+cri_r3_f8+cri_r5_f8+cri_r7_f8+cri_r9_f8+cri_r11_f8+cri_r13_f8+cri_r15_f8+cri_r17_f8+cri_r19_f8+cri_r21_f8+cri_r23_f8
			,cri_r26_f8 = cri_r2_f8+cri_r4_f8+cri_r6_f8+cri_r8_f8+cri_r10_f8+cri_r12_f8+cri_r14_f8+cri_r16_f8+cri_r18_f8+cri_r20_f8+cri_r22_f8+cri_r24_f8
			,cri_r25_f9 = cri_r1_f9+cri_r3_f9+cri_r5_f9+cri_r7_f9+cri_r9_f9+cri_r11_f9+cri_r13_f9+cri_r15_f9+cri_r17_f9+cri_r19_f9+cri_r21_f9+cri_r23_f9
			,cri_r26_f9 = cri_r2_f9+cri_r4_f9+cri_r6_f9+cri_r8_f9+cri_r10_f9+cri_r12_f9+cri_r14_f9+cri_r16_f9+cri_r18_f9+cri_r20_f9+cri_r22_f9+cri_r24_f9
			,cri_r25_f10 = cri_r1_f10+cri_r3_f10+cri_r5_f10+cri_r7_f10+cri_r9_f10+cri_r11_f10+cri_r13_f10+cri_r15_f10+cri_r17_f10+cri_r19_f10+cri_r21_f10+cri_r23_f10
			,cri_r26_f10 = cri_r2_f10+cri_r4_f10+cri_r6_f10+cri_r8_f10+cri_r10_f10+cri_r12_f10+cri_r14_f10+cri_r16_f10+cri_r18_f10+cri_r20_f10+cri_r22_f10+cri_r24_f10
			,cri_r25_f11 = cri_r1_f11+cri_r3_f11+cri_r5_f11+cri_r7_f11+cri_r9_f11+cri_r11_f11+cri_r13_f11+cri_r15_f11+cri_r17_f11+cri_r19_f11+cri_r21_f11+cri_r23_f11
			,cri_r26_f11 = cri_r2_f11+cri_r4_f11+cri_r6_f11+cri_r8_f11+cri_r10_f11+cri_r12_f11+cri_r14_f11+cri_r16_f11+cri_r18_f11+cri_r20_f11+cri_r22_f11+cri_r24_f11
			,cri_r25_f12 = cri_r1_f12+cri_r3_f12+cri_r5_f12+cri_r7_f12+cri_r9_f12+cri_r11_f12+cri_r13_f12+cri_r15_f12+cri_r17_f12+cri_r19_f12+cri_r21_f12+cri_r23_f12
			,cri_r26_f12 = cri_r2_f12+cri_r4_f12+cri_r6_f12+cri_r8_f12+cri_r10_f12+cri_r12_f12+cri_r14_f12+cri_r16_f12+cri_r18_f12+cri_r20_f12+cri_r22_f12+cri_r24_f12
			,cri_r25_f13 = cri_r1_f13+cri_r3_f13+cri_r5_f13+cri_r7_f13+cri_r9_f13+cri_r11_f13+cri_r13_f13+cri_r15_f13+cri_r17_f13+cri_r19_f13+cri_r21_f13+cri_r23_f13
			,cri_r26_f13 = cri_r2_f13+cri_r4_f13+cri_r6_f13+cri_r8_f13+cri_r10_f13+cri_r12_f13+cri_r14_f13+cri_r16_f13+cri_r18_f13+cri_r20_f13+cri_r22_f13+cri_r24_f13
			,cri_r25_f14 = cri_r1_f14+cri_r3_f14+cri_r5_f14+cri_r7_f14+cri_r9_f14+cri_r11_f14+cri_r13_f14+cri_r15_f14+cri_r17_f14+cri_r19_f14+cri_r21_f14+cri_r23_f14,
			cri_r26_f14 = cri_r2_f14+cri_r4_f14+cri_r6_f14+cri_r8_f14+cri_r10_f14+cri_r12_f14+cri_r14_f14+cri_r16_f14+cri_r18_f14+cri_r20_f14+cri_r22_f14+cri_r24_f14
			,cri_r25_f15 = cri_r1_f15+cri_r3_f15+cri_r5_f15+cri_r7_f15+cri_r9_f15+cri_r11_f15+cri_r13_f15+cri_r15_f15+cri_r17_f15+cri_r19_f15+cri_r21_f15+cri_r23_f15
			,cri_r26_f15 = cri_r2_f15+cri_r4_f15+cri_r6_f15+cri_r8_f15+cri_r10_f15+cri_r12_f15+cri_r14_f15+cri_r16_f15+cri_r18_f15+cri_r20_f15+cri_r22_f15+cri_r24_f15
			,cri_r25_f16 = cri_r1_f16+cri_r3_f16+cri_r5_f16+cri_r7_f16+cri_r9_f16+cri_r11_f16+cri_r13_f16+cri_r15_f16+cri_r17_f16+cri_r19_f16+cri_r21_f16+cri_r23_f16
			,cri_r26_f16 = cri_r2_f16+cri_r4_f16+cri_r6_f16+cri_r8_f16+cri_r10_f16+cri_r12_f16+cri_r14_f16+cri_r16_f16+cri_r18_f16+cri_r20_f16+cri_r22_f16+cri_r24_f16
			,cri_r25_f18 = cri_r1_f18+cri_r3_f18+cri_r5_f18+cri_r7_f18+cri_r9_f18+cri_r11_f18+cri_r13_f18+cri_r15_f18+cri_r17_f18+cri_r19_f18+cri_r21_f18+cri_r23_f18
			,cri_r26_f18 = cri_r2_f18+cri_r4_f18+cri_r6_f18+cri_r8_f18+cri_r10_f18+cri_r12_f18+cri_r14_f18+cri_r16_f18+cri_r18_f18+cri_r20_f18+cri_r22_f18+cri_r24_f18
			,cri_r25_f20 = cri_r1_f20+cri_r3_f20+cri_r5_f20+cri_r7_f20+cri_r9_f20+cri_r11_f20+cri_r13_f20+cri_r15_f20+cri_r17_f20+cri_r19_f20+cri_r21_f20+cri_r23_f20
			,cri_r26_f20 = cri_r2_f20+cri_r4_f20+cri_r6_f20+cri_r8_f20+cri_r10_f20+cri_r12_f20+cri_r14_f20+cri_r16_f20+cri_r18_f20+cri_r20_f20+cri_r22_f20+cri_r24_f20 
			,cri_r25_f21 = cri_r1_f21+cri_r3_f21+cri_r5_f21+cri_r7_f21+cri_r9_f21+cri_r11_f21+cri_r13_f21+cri_r15_f21+cri_r17_f21+cri_r19_f21+cri_r21_f21+cri_r23_f21
			,cri_r26_f21 = cri_r2_f21+cri_r4_f21+cri_r6_f21+cri_r8_f21+cri_r10_f21+cri_r12_f21+cri_r14_f21+cri_r16_f21+cri_r18_f21+cri_r20_f21+cri_r22_f21+cri_r24_f21 where fmonth = '$fmonth' and facode='$facode'";
		$result2=$this->db->query($query2);
		$query3="update fac_mvrf_db set oui_r25_f1 = oui_r1_f1+oui_r3_f1+oui_r5_f1+oui_r7_f1+oui_r9_f1+oui_r11_f1+oui_r13_f1+oui_r15_f1+oui_r17_f1+oui_r19_f1+oui_r21_f1+oui_r23_f1, oui_r26_f1 = oui_r2_f1+oui_r4_f1+oui_r6_f1+oui_r8_f1+oui_r10_f1+oui_r12_f1+oui_r14_f1+oui_r16_f1+oui_r18_f1+oui_r20_f1+oui_r22_f1+oui_r24_f1
			,oui_r25_f2 = oui_r1_f2+oui_r3_f2+oui_r5_f2+oui_r7_f2+oui_r9_f2+oui_r11_f2+oui_r13_f2+oui_r15_f2+oui_r17_f2+oui_r19_f2+oui_r21_f2+oui_r23_f2
			,oui_r26_f2 = oui_r2_f2+oui_r4_f2+oui_r6_f2+oui_r8_f2+oui_r10_f2+oui_r12_f2+oui_r14_f2+oui_r16_f2+oui_r18_f2+oui_r20_f2+oui_r22_f2+oui_r24_f2
			,oui_r25_f3 = oui_r1_f3+oui_r3_f3+oui_r5_f3+oui_r7_f3+oui_r9_f3+oui_r11_f3+oui_r13_f3+oui_r15_f3+oui_r17_f3+oui_r19_f3+oui_r21_f3+oui_r23_f3
			,oui_r26_f3 = oui_r2_f3+oui_r4_f3+oui_r6_f3+oui_r8_f3+oui_r10_f3+oui_r12_f3+oui_r14_f3+oui_r16_f3+oui_r18_f3+oui_r20_f3+oui_r22_f3+oui_r24_f3
			,oui_r25_f4 = oui_r1_f4+oui_r3_f4+oui_r5_f4+oui_r7_f4+oui_r9_f4+oui_r11_f4+oui_r13_f4+oui_r15_f4+oui_r17_f4+oui_r19_f4+oui_r21_f4+oui_r23_f4
			,oui_r26_f4 = oui_r2_f4+oui_r4_f4+oui_r6_f4+oui_r8_f4+oui_r10_f4+oui_r12_f4+oui_r14_f4+oui_r16_f4+oui_r18_f4+oui_r20_f4+oui_r22_f4+oui_r24_f4
			,oui_r25_f5 = oui_r1_f5+oui_r3_f5+oui_r5_f5+oui_r7_f5+oui_r9_f5+oui_r11_f5+oui_r13_f5+oui_r15_f5+oui_r17_f5+oui_r19_f5+oui_r21_f5+oui_r23_f5
			,oui_r26_f5 = oui_r2_f5+oui_r4_f5+oui_r6_f5+oui_r8_f5+oui_r10_f5+oui_r12_f5+oui_r14_f5+oui_r16_f5+oui_r18_f5+oui_r20_f5+oui_r22_f5+oui_r24_f5
			,oui_r25_f6 = oui_r1_f6+oui_r3_f6+oui_r5_f6+oui_r7_f6+oui_r9_f6+oui_r11_f6+oui_r13_f6+oui_r15_f6+oui_r17_f6+oui_r19_f6+oui_r21_f6+oui_r23_f6
			,oui_r26_f6 = oui_r2_f6+oui_r4_f6+oui_r6_f6+oui_r8_f6+oui_r10_f6+oui_r12_f6+oui_r14_f6+oui_r16_f6+oui_r18_f6+oui_r20_f6+oui_r22_f6+oui_r24_f6
			,oui_r25_f7 = oui_r1_f7+oui_r3_f7+oui_r5_f7+oui_r7_f7+oui_r9_f7+oui_r11_f7+oui_r13_f7+oui_r15_f7+oui_r17_f7+oui_r19_f7+oui_r21_f7+oui_r23_f7
			,oui_r26_f7 = oui_r2_f7+oui_r4_f7+oui_r6_f7+oui_r8_f7+oui_r10_f7+oui_r12_f7+oui_r14_f7+oui_r16_f7+oui_r18_f7+oui_r20_f7+oui_r22_f7+oui_r24_f7
			,oui_r25_f8 = oui_r1_f8+oui_r3_f8+oui_r5_f8+oui_r7_f8+oui_r9_f8+oui_r11_f8+oui_r13_f8+oui_r15_f8+oui_r17_f8+oui_r19_f8+oui_r21_f8+oui_r23_f8
			,oui_r26_f8 = oui_r2_f8+oui_r4_f8+oui_r6_f8+oui_r8_f8+oui_r10_f8+oui_r12_f8+oui_r14_f8+oui_r16_f8+oui_r18_f8+oui_r20_f8+oui_r22_f8+oui_r24_f8
			,oui_r25_f9 = oui_r1_f9+oui_r3_f9+oui_r5_f9+oui_r7_f9+oui_r9_f9+oui_r11_f9+oui_r13_f9+oui_r15_f9+oui_r17_f9+oui_r19_f9+oui_r21_f9+oui_r23_f9
			,oui_r26_f9 = oui_r2_f9+oui_r4_f9+oui_r6_f9+oui_r8_f9+oui_r10_f9+oui_r12_f9+oui_r14_f9+oui_r16_f9+oui_r18_f9+oui_r20_f9+oui_r22_f9+oui_r24_f9
			,oui_r25_f10 = oui_r1_f10+oui_r3_f10+oui_r5_f10+oui_r7_f10+oui_r9_f10+oui_r11_f10+oui_r13_f10+oui_r15_f10+oui_r17_f10+oui_r19_f10+oui_r21_f10+oui_r23_f10
			,oui_r26_f10 = oui_r2_f10+oui_r4_f10+oui_r6_f10+oui_r8_f10+oui_r10_f10+oui_r12_f10+oui_r14_f10+oui_r16_f10+oui_r18_f10+oui_r20_f10+oui_r22_f10+oui_r24_f10
			,oui_r25_f11 = oui_r1_f11+oui_r3_f11+oui_r5_f11+oui_r7_f11+oui_r9_f11+oui_r11_f11+oui_r13_f11+oui_r15_f11+oui_r17_f11+oui_r19_f11+oui_r21_f11+oui_r23_f11
			,oui_r26_f11 = oui_r2_f11+oui_r4_f11+oui_r6_f11+oui_r8_f11+oui_r10_f11+oui_r12_f11+oui_r14_f11+oui_r16_f11+oui_r18_f11+oui_r20_f11+oui_r22_f11+oui_r24_f11
			,oui_r25_f12 = oui_r1_f12+oui_r3_f12+oui_r5_f12+oui_r7_f12+oui_r9_f12+oui_r11_f12+oui_r13_f12+oui_r15_f12+oui_r17_f12+oui_r19_f12+oui_r21_f12+oui_r23_f12
			,oui_r26_f12 = oui_r2_f12+oui_r4_f12+oui_r6_f12+oui_r8_f12+oui_r10_f12+oui_r12_f12+oui_r14_f12+oui_r16_f12+oui_r18_f12+oui_r20_f12+oui_r22_f12+oui_r24_f12
			,oui_r25_f13 = oui_r1_f13+oui_r3_f13+oui_r5_f13+oui_r7_f13+oui_r9_f13+oui_r11_f13+oui_r13_f13+oui_r15_f13+oui_r17_f13+oui_r19_f13+oui_r21_f13+oui_r23_f13
			,oui_r26_f13 = oui_r2_f13+oui_r4_f13+oui_r6_f13+oui_r8_f13+oui_r10_f13+oui_r12_f13+oui_r14_f13+oui_r16_f13+oui_r18_f13+oui_r20_f13+oui_r22_f13+oui_r24_f13
			,oui_r25_f14 = oui_r1_f14+oui_r3_f14+oui_r5_f14+oui_r7_f14+oui_r9_f14+oui_r11_f14+oui_r13_f14+oui_r15_f14+oui_r17_f14+oui_r19_f14+oui_r21_f14+oui_r23_f14,
			oui_r26_f14 = oui_r2_f14+oui_r4_f14+oui_r6_f14+oui_r8_f14+oui_r10_f14+oui_r12_f14+oui_r14_f14+oui_r16_f14+oui_r18_f14+oui_r20_f14+oui_r22_f14+oui_r24_f14
			,oui_r25_f15 = oui_r1_f15+oui_r3_f15+oui_r5_f15+oui_r7_f15+oui_r9_f15+oui_r11_f15+oui_r13_f15+oui_r15_f15+oui_r17_f15+oui_r19_f15+oui_r21_f15+oui_r23_f15
			,oui_r26_f15 = oui_r2_f15+oui_r4_f15+oui_r6_f15+oui_r8_f15+oui_r10_f15+oui_r12_f15+oui_r14_f15+oui_r16_f15+oui_r18_f15+oui_r20_f15+oui_r22_f15+oui_r24_f15
			,oui_r25_f16 = oui_r1_f16+oui_r3_f16+oui_r5_f16+oui_r7_f16+oui_r9_f16+oui_r11_f16+oui_r13_f16+oui_r15_f16+oui_r17_f16+oui_r19_f16+oui_r21_f16+oui_r23_f16
			,oui_r26_f16 = oui_r2_f16+oui_r4_f16+oui_r6_f16+oui_r8_f16+oui_r10_f16+oui_r12_f16+oui_r14_f16+oui_r16_f16+oui_r18_f16+oui_r20_f16+oui_r22_f16+oui_r24_f16
			,oui_r25_f18 = oui_r1_f18+oui_r3_f18+oui_r5_f18+oui_r7_f18+oui_r9_f18+oui_r11_f18+oui_r13_f18+oui_r15_f18+oui_r17_f18+oui_r19_f18+oui_r21_f18+oui_r23_f18
			,oui_r26_f18 = oui_r2_f18+oui_r4_f18+oui_r6_f18+oui_r8_f18+oui_r10_f18+oui_r12_f18+oui_r14_f18+oui_r16_f18+oui_r18_f18+oui_r20_f18+oui_r22_f18+oui_r24_f18
			,oui_r25_f20 = oui_r1_f20+oui_r3_f20+oui_r5_f20+oui_r7_f20+oui_r9_f20+oui_r11_f20+oui_r13_f20+oui_r15_f20+oui_r17_f20+oui_r19_f20+oui_r21_f20+oui_r23_f20
			,oui_r26_f20 = oui_r2_f20+oui_r4_f20+oui_r6_f20+oui_r8_f20+oui_r10_f20+oui_r12_f20+oui_r14_f20+oui_r16_f20+oui_r18_f20+oui_r20_f20+oui_r22_f20+oui_r24_f20
			,oui_r25_f21 = oui_r1_f21+oui_r3_f21+oui_r5_f21+oui_r7_f21+oui_r9_f21+oui_r11_f21+oui_r13_f21+oui_r15_f21+oui_r17_f21+oui_r19_f21+oui_r21_f21+oui_r23_f21
			,oui_r26_f21 = oui_r2_f21+oui_r4_f21+oui_r6_f21+oui_r8_f21+oui_r10_f21+oui_r12_f21+oui_r14_f21+oui_r16_f21+oui_r18_f21+oui_r20_f21+oui_r22_f21+oui_r24_f21
			where fmonth = '$fmonth' and facode='$facode'";
		$result3=$this->db->query($query3);
		$query4="update fac_mvrf_db set ttoui_r9_f1 = ttoui_r1_f1+ttoui_r3_f1+ttoui_r5_f1+ttoui_r7_f1,ttoui_r10_f1 = ttoui_r2_f1+ttoui_r4_f1+ttoui_r6_f1+ttoui_r8_f1,ttoui_r9_f2 = ttoui_r1_f2+ttoui_r3_f2+ttoui_r5_f2+ttoui_r7_f2,ttoui_r10_f2 = ttoui_r2_f2+ttoui_r4_f2+ttoui_r6_f2+ttoui_r8_f2,ttoui_r9_f3 = ttoui_r1_f3+ttoui_r3_f3+ttoui_r5_f3+ttoui_r7_f3,ttoui_r10_f3 = ttoui_r2_f3+ttoui_r4_f3+ttoui_r6_f3+ttoui_r8_f3,ttoui_r9_f4 = ttoui_r1_f4+ttoui_r3_f4+ttoui_r5_f4+ttoui_r7_f4,ttoui_r10_f4 = ttoui_r2_f4+ttoui_r4_f4+ttoui_r6_f4+ttoui_r8_f4,ttoui_r9_f5 = ttoui_r1_f5+ttoui_r3_f5+ttoui_r5_f5+ttoui_r7_f5,ttoui_r10_f5 = ttoui_r2_f5+ttoui_r4_f5+ttoui_r6_f5+ttoui_r8_f5,ttoui_r9_f6 = ttoui_r1_f6+ttoui_r3_f6+ttoui_r5_f6+ttoui_r7_f6,ttoui_r10_f6 = ttoui_r2_f6+ttoui_r4_f6+ttoui_r6_f6+ttoui_r8_f6 where fmonth = '$fmonth' and facode='$facode'";
		$result4=$this->db->query($query4);
	}
	public function update_all_vaccinations_od($fmonth,$facode)
	{ 
		$query1="update fac_mvrf_od_db set od_r25_f1 = od_r1_f1+od_r3_f1+od_r5_f1+od_r7_f1+od_r9_f1+od_r11_f1+od_r13_f1+od_r15_f1+od_r17_f1+od_r19_f1+od_r21_f1+od_r23_f1, od_r26_f1 = od_r2_f1+od_r4_f1+od_r6_f1+od_r8_f1+od_r10_f1+od_r12_f1+od_r14_f1+od_r16_f1+od_r18_f1+od_r20_f1+od_r22_f1+od_r24_f1
			,od_r25_f2 = od_r1_f2+od_r3_f2+od_r5_f2+od_r7_f2+od_r9_f2+od_r11_f2+od_r13_f2+od_r15_f2+od_r17_f2+od_r19_f2+od_r21_f2+od_r23_f2
			,od_r26_f2 = od_r2_f2+od_r4_f2+od_r6_f2+od_r8_f2+od_r10_f2+od_r12_f2+od_r14_f2+od_r16_f2+od_r18_f2+od_r20_f2+od_r22_f2+od_r24_f2
			,od_r25_f3 = od_r1_f3+od_r3_f3+od_r5_f3+od_r7_f3+od_r9_f3+od_r11_f3+od_r13_f3+od_r15_f3+od_r17_f3+od_r19_f3+od_r21_f3+od_r23_f3
			,od_r26_f3 = od_r2_f3+od_r4_f3+od_r6_f3+od_r8_f3+od_r10_f3+od_r12_f3+od_r14_f3+od_r16_f3+od_r18_f3+od_r20_f3+od_r22_f3+od_r24_f3
			,od_r25_f4 = od_r1_f4+od_r3_f4+od_r5_f4+od_r7_f4+od_r9_f4+od_r11_f4+od_r13_f4+od_r15_f4+od_r17_f4+od_r19_f4+od_r21_f4+od_r23_f4
			,od_r26_f4 = od_r2_f4+od_r4_f4+od_r6_f4+od_r8_f4+od_r10_f4+od_r12_f4+od_r14_f4+od_r16_f4+od_r18_f4+od_r20_f4+od_r22_f4+od_r24_f4
			,od_r25_f5 = od_r1_f5+od_r3_f5+od_r5_f5+od_r7_f5+od_r9_f5+od_r11_f5+od_r13_f5+od_r15_f5+od_r17_f5+od_r19_f5+od_r21_f5+od_r23_f5
			,od_r26_f5 = od_r2_f5+od_r4_f5+od_r6_f5+od_r8_f5+od_r10_f5+od_r12_f5+od_r14_f5+od_r16_f5+od_r18_f5+od_r20_f5+od_r22_f5+od_r24_f5
			,od_r25_f6 = od_r1_f6+od_r3_f6+od_r5_f6+od_r7_f6+od_r9_f6+od_r11_f6+od_r13_f6+od_r15_f6+od_r17_f6+od_r19_f6+od_r21_f6+od_r23_f6
			,od_r26_f6 = od_r2_f6+od_r4_f6+od_r6_f6+od_r8_f6+od_r10_f6+od_r12_f6+od_r14_f6+od_r16_f6+od_r18_f6+od_r20_f6+od_r22_f6+od_r24_f6
			,od_r25_f7 = od_r1_f7+od_r3_f7+od_r5_f7+od_r7_f7+od_r9_f7+od_r11_f7+od_r13_f7+od_r15_f7+od_r17_f7+od_r19_f7+od_r21_f7+od_r23_f7
			,od_r26_f7 = od_r2_f7+od_r4_f7+od_r6_f7+od_r8_f7+od_r10_f7+od_r12_f7+od_r14_f7+od_r16_f7+od_r18_f7+od_r20_f7+od_r22_f7+od_r24_f7
			,od_r25_f8 = od_r1_f8+od_r3_f8+od_r5_f8+od_r7_f8+od_r9_f8+od_r11_f8+od_r13_f8+od_r15_f8+od_r17_f8+od_r19_f8+od_r21_f8+od_r23_f8
			,od_r26_f8 = od_r2_f8+od_r4_f8+od_r6_f8+od_r8_f8+od_r10_f8+od_r12_f8+od_r14_f8+od_r16_f8+od_r18_f8+od_r20_f8+od_r22_f8+od_r24_f8
			,od_r25_f9 = od_r1_f9+od_r3_f9+od_r5_f9+od_r7_f9+od_r9_f9+od_r11_f9+od_r13_f9+od_r15_f9+od_r17_f9+od_r19_f9+od_r21_f9+od_r23_f9
			,od_r26_f9 = od_r2_f9+od_r4_f9+od_r6_f9+od_r8_f9+od_r10_f9+od_r12_f9+od_r14_f9+od_r16_f9+od_r18_f9+od_r20_f9+od_r22_f9+od_r24_f9
			,od_r25_f10 = od_r1_f10+od_r3_f10+od_r5_f10+od_r7_f10+od_r9_f10+od_r11_f10+od_r13_f10+od_r15_f10+od_r17_f10+od_r19_f10+od_r21_f10+od_r23_f10
			,od_r26_f10 = od_r2_f10+od_r4_f10+od_r6_f10+od_r8_f10+od_r10_f10+od_r12_f10+od_r14_f10+od_r16_f10+od_r18_f10+od_r20_f10+od_r22_f10+od_r24_f10
			,od_r25_f11 = od_r1_f11+od_r3_f11+od_r5_f11+od_r7_f11+od_r9_f11+od_r11_f11+od_r13_f11+od_r15_f11+od_r17_f11+od_r19_f11+od_r21_f11+od_r23_f11
			,od_r26_f11 = od_r2_f11+od_r4_f11+od_r6_f11+od_r8_f11+od_r10_f11+od_r12_f11+od_r14_f11+od_r16_f11+od_r18_f11+od_r20_f11+od_r22_f11+od_r24_f11
			,od_r25_f12 = od_r1_f12+od_r3_f12+od_r5_f12+od_r7_f12+od_r9_f12+od_r11_f12+od_r13_f12+od_r15_f12+od_r17_f12+od_r19_f12+od_r21_f12+od_r23_f12
			,od_r26_f12 = od_r2_f12+od_r4_f12+od_r6_f12+od_r8_f12+od_r10_f12+od_r12_f12+od_r14_f12+od_r16_f12+od_r18_f12+od_r20_f12+od_r22_f12+od_r24_f12
			,od_r25_f13 = od_r1_f13+od_r3_f13+od_r5_f13+od_r7_f13+od_r9_f13+od_r11_f13+od_r13_f13+od_r15_f13+od_r17_f13+od_r19_f13+od_r21_f13+od_r23_f13
			,od_r26_f13 = od_r2_f13+od_r4_f13+od_r6_f13+od_r8_f13+od_r10_f13+od_r12_f13+od_r14_f13+od_r16_f13+od_r18_f13+od_r20_f13+od_r22_f13+od_r24_f13
			,od_r25_f14 = od_r1_f14+od_r3_f14+od_r5_f14+od_r7_f14+od_r9_f14+od_r11_f14+od_r13_f14+od_r15_f14+od_r17_f14+od_r19_f14+od_r21_f14+od_r23_f14,
			od_r26_f14 = od_r2_f14+od_r4_f14+od_r6_f14+od_r8_f14+od_r10_f14+od_r12_f14+od_r14_f14+od_r16_f14+od_r18_f14+od_r20_f14+od_r22_f14+od_r24_f14
			,od_r25_f15 = od_r1_f15+od_r3_f15+od_r5_f15+od_r7_f15+od_r9_f15+od_r11_f15+od_r13_f15+od_r15_f15+od_r17_f15+od_r19_f15+od_r21_f15+od_r23_f15
			,od_r26_f15 = od_r2_f15+od_r4_f15+od_r6_f15+od_r8_f15+od_r10_f15+od_r12_f15+od_r14_f15+od_r16_f15+od_r18_f15+od_r20_f15+od_r22_f15+od_r24_f15
			,od_r25_f16 = od_r1_f16+od_r3_f16+od_r5_f16+od_r7_f16+od_r9_f16+od_r11_f16+od_r13_f16+od_r15_f16+od_r17_f16+od_r19_f16+od_r21_f16+od_r23_f16
			,od_r26_f16 = od_r2_f16+od_r4_f16+od_r6_f16+od_r8_f16+od_r10_f16+od_r12_f16+od_r14_f16+od_r16_f16+od_r18_f16+od_r20_f16+od_r22_f16+od_r24_f16
			,od_r25_f18 = od_r1_f18+od_r3_f18+od_r5_f18+od_r7_f18+od_r9_f18+od_r11_f18+od_r13_f18+od_r15_f18+od_r17_f18+od_r19_f18+od_r21_f18+od_r23_f18
			,od_r26_f18 = od_r2_f18+od_r4_f18+od_r6_f18+od_r8_f18+od_r10_f18+od_r12_f18+od_r14_f18+od_r16_f18+od_r18_f18+od_r20_f18+od_r22_f18+od_r24_f18
			,od_r25_f20 = od_r1_f20+od_r3_f20+od_r5_f20+od_r7_f20+od_r9_f20+od_r11_f20+od_r13_f20+od_r15_f20+od_r17_f20+od_r19_f20+od_r21_f20+od_r23_f20
			,od_r26_f20 = od_r2_f20+od_r4_f20+od_r6_f20+od_r8_f20+od_r10_f20+od_r12_f20+od_r14_f20+od_r16_f20+od_r18_f20+od_r20_f20+od_r22_f20+od_r24_f20
			,od_r25_f21 = od_r1_f21+od_r3_f21+od_r5_f21+od_r7_f21+od_r9_f21+od_r11_f21+od_r13_f21+od_r15_f21+od_r17_f21+od_r19_f21+od_r21_f21+od_r23_f21
			,od_r26_f21 = od_r2_f21+od_r4_f21+od_r6_f21+od_r8_f21+od_r10_f21+od_r12_f21+od_r14_f21+od_r16_f21+od_r18_f21+od_r20_f21+od_r22_f21+od_r24_f21 where fmonth = '$fmonth' and facode='$facode'";
		$result1=$this->db->query($query1);
		$query2="update fac_mvrf_od_db set ttod_r9_f1 = ttod_r1_f1+ttod_r3_f1+ttod_r5_f1+ttod_r7_f1,ttod_r10_f1 = ttod_r2_f1+ttod_r4_f1+ttod_r6_f1+ttod_r8_f1,ttod_r9_f2 = ttod_r1_f2+ttod_r3_f2+ttod_r5_f2+ttod_r7_f2,ttod_r10_f2 = ttod_r2_f2+ttod_r4_f2+ttod_r6_f2+ttod_r8_f2,ttod_r9_f3 = ttod_r1_f3+ttod_r3_f3+ttod_r5_f3+ttod_r7_f3,ttod_r10_f3 = ttod_r2_f3+ttod_r4_f3+ttod_r6_f3+ttod_r8_f3,ttod_r9_f4 = ttod_r1_f4+ttod_r3_f4+ttod_r5_f4+ttod_r7_f4,ttod_r10_f4 = ttod_r2_f4+ttod_r4_f4+ttod_r6_f4+ttod_r8_f4,ttod_r9_f5 = ttod_r1_f5+ttod_r3_f5+ttod_r5_f5+ttod_r7_f5,ttod_r10_f5 = ttod_r2_f5+ttod_r4_f5+ttod_r6_f5+ttod_r8_f5,ttod_r9_f6 = ttod_r1_f6+ttod_r3_f6+ttod_r5_f6+ttod_r7_f6,ttod_r10_f6 = ttod_r2_f6+ttod_r4_f6+ttod_r6_f6+ttod_r8_f6 where fmonth = '$fmonth' and facode='$facode'";
		$result2=$this->db->query($query2);
	}
	public function getDataShareUcList($facode,$fmonth) {
		
		$query = "select DISTINCT countrycode,countryname(countrycode) as countryname,procode,provincename(procode) as provincename,distcode,districtname(distcode) as distname,tcode,tehsilname(tcode) as tehsilname,uncode, unname (uncode) as unname from monthly_outuc_coverage where from_facode='$facode' and fmonth = '$fmonth'";
		$result = $this -> db -> query($query);
		return $result -> result_array();
	}
	public function get_monthly_outuc_coverage($facode,$fmonth,$countrycode,$uncode) {
		if($uncode==0){ 
			$uncode=""; 
		}else{ 
			$uncode="and uncode='$uncode'"; 
		}
		$query = "select *,countryname(countrycode) as countryname,provincename(procode) as provincename,districtname(distcode) as distname,tehsilname(tcode) as tehsilname,unname (uncode) as unname from monthly_outuc_coverage where from_facode='$facode' and fmonth = '$fmonth' and countrycode='$countrycode' $uncode";
		//print_r($query); exit(); 
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//return json_encode($result);	
		return $result;
		
	}
	public function view_monthly_outuc_coverage($facode,$fmonth,$countrycode,$uncode) {
		if($uncode==0){ 
			$uncode=""; 
		}else{ 
			$uncode="and uncode='$uncode'"; 
		}
		$query = "select *,countryname(countrycode) as countryname,provincename(procode) as provincename,districtname(distcode) as distname,tehsilname(tcode) as tehsilname,unname (uncode) as unname from monthly_outuc_coverage where from_facode='$facode' and fmonth = '$fmonth' and countrycode='$countrycode' $uncode";
		$result = $this -> db -> query($query);
		$queryresult = $result -> result_array();
		foreach($queryresult as $key=>$row){
			$queryresult[$key]['distname'] = CrossProvince_DistrictName($row['distcode'],true);
			$queryresult[$key]['tehsilname'] = CrossProvince_TehsilName($row['tcode'],true);
			$queryresult[$key]['unname']   = CrossProvince_UCName($row['uncode'],true);
		}
		return $queryresult;
	}
	public function delete_monthly_outuc($fmonth,$facode,$countrycode,$uncode) {
		if($uncode==0){ 
			$uncode=""; 
		}else{ 
			$uncode="and uncode='$uncode'"; 
		}
		$query="Delete from monthly_outuc_coverage where fmonth='$fmonth' and from_facode='$facode' and countrycode='$countrycode' $uncode";
		//print_r($query); exit();
		$result = $this-> db-> query($query);	 
		return $result; 
	}
	public function total_get_monthly_outuc_coverage($facode,$fmonth,$distcode,$item_id,$antigen) {

		$sessiondist=$this -> session -> District;
		if($sessiondist==$distcode){
			$distcode="and distcode='$sessiondist'"; 
		}else{
			$distcode="and distcode!='$sessiondist'"; 
		}
		$query = "select sum(fm1) as fm1,sum(ff1) as ff1,sum(om1) as om1,sum(of1) as of1,sum(mm1) as mm1,
		sum(mf1) as mf1,sum(hm1) as hm1,sum(hf1) as hf1,sum(fm2) as fm2,sum(ff2) as ff2,sum(om2) as om2,
		sum(of2) as of2,sum(mm2) as mm2,sum(mf2) as mf2,sum(hm2) as hm2,sum(hf2) as hf2,sum(fm3) as fm3,
		sum(ff3) as ff3,sum(om3) as om3,sum(of3) as of3,sum(mm3) as mm3,sum(mf3) as mf3,sum(hm3) as hm3,
		sum(hf3) as hf3,sum(fp) as fp,sum(fnp) as fnp,sum(op) as op,sum(onp) as onp,sum(mp) as mp,
		sum(mnp) as mnp,sum(hp) as hp,sum(hnp) as hnp from monthly_outuc_coverage 
		where from_facode='$facode' and fmonth='$fmonth' and item_id='$item_id' 
		and antigen='$antigen' $distcode";
		$result = $this -> db -> query($query);
		$result = $result -> result_array();
		//return json_encode($result);	
		return $result;
	}
}