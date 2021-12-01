<?php
class Communication_model extends CI_Model
{
	public function getConsumption($fmonth,$distcode,$productId,$item_pack_size_id=NULL){
		$this -> load -> helper('dashboard_functions_helper');
		$this -> db -> select("
			facode as hf_code,{$productId} as item_code,sum(opening_doses) as opening,sum(received_doses) as received,
			0 as issue,sum(closing_doses) as closing,fmonth as data_entry_month,created_date as last_update")
			-> from('epi_consumption_master')
			-> join('epi_consumption_detail',"epi_consumption_detail.main_id = epi_consumption_master.pk_id")
			-> where(array('distcode' => $distcode,'fmonth' => $fmonth,'item_id' => $item_pack_size_id))
			-> group_by("distcode,facode,fmonth,created_date");
		$consumptionResult = $this -> db -> get() -> result_array();
		foreach($consumptionResult as $key => $value){
			$facode = $value['hf_code'];
			$this -> db -> select('vacc_dose_id');
			$this -> db -> where('cr_product_id',$productId);
			/* Get all doses for a product that are mapped in products_doses_details table */
			$allDoses = $this -> db -> get('products_doses_details') -> result_array();
			if($allDoses){
				$consumptionResult[$key]['issue'] = array();
				$doseno = 1;
				foreach($allDoses as $adkey => $advalue){
					$vaccineId = $advalue['vacc_dose_id'];
					/* if product id is for TT then its column name are different so we have a different function for TT */
					if($productId == 8){
						$consumptionResult[$key]['issue'][] = ttVaccinationInNumbers("fmonth = '{$fmonth}'",NULL,$facode,$vaccineId,NULL,$distcode,NULL,'arr');
						$consumptionResult[$key]['issue'][$adkey]['dose_no'] = $doseno;
					}else{
						$consumptionResult[$key]['issue'][$adkey] = vaccinationInNumbers("fmonth = '{$fmonth}'",NULL,$facode,$vaccineId,NULL,$distcode,NULL,'arr');
						$consumptionResult[$key]['issue'][$adkey]['dose_no'] = ($productId == 3)?$doseno-1:$doseno;
					}
					$doseno++;
				}
			}
		}
		return $consumptionResult;
	}
	public function getAllProducts(){
		$this -> db -> select('*');
		return $this -> db -> get('products_details') -> result_array();
	}
	public function getIssuance($date){
		return $this -> db -> query("
								SELECT 
									'".date("Ymd")."'||batch.pk_id as transaction_id,
									main.transaction_date as transactionDate,
									main.transaction_number,
									stakeholder_activity_id as purpose,
									main.transaction_type_id,
									main.from_warehouse_code as from_facility_id,
									get_store_name(main.from_warehouse_type_id,main.from_warehouse_code) as from_facility,
									main.to_warehouse_code as to_facility_id,
									get_store_name(main.to_warehouse_type_id,main.to_warehouse_code) as to_facility,
									batch.quantity as quantity,
									detail.vvm_stage as vvm_stage,
									'Issuance' as transaction_type_name,
									batch.number as batch_number,
									batch.expiry_date as batch_expiry,
									'' as batch_unit_price,
									batch.production_date as batch_production,
									get_product_name(batch.item_pack_size_id) as product,
									batch.item_pack_size_id as product_id,
									'' as transaction_reference,
									batch.created_date as created_date,
									batch.last_update as modified_date
								FROM 
									epi_stock_master_history main 
								join 
									epi_stock_batch_history batch on batch.batch_master_id = main.master_id 
								JOIN 
									epi_stock_detail_history detail on detail.stock_batch_id = batch.batch_id 
								WHERE 
									(Date(main.created_date)='{$date}' OR Date(main.updated_date)='{$date}') 
									AND main.transaction_type_id='2'
									AND main.to_warehouse_type_id='4' 
								ORDER BY main.transaction_number;
		") -> result_array();
	}
	public function getReceiving($date){
		return $this -> db -> query("
								SELECT 
									'".date("Ymd")."'||batch.pk_id as transaction_id,
									main.transaction_date as transactionDate,
									main.transaction_number,
									main.transaction_type_id,
									main.from_warehouse_code as from_facility_id,
									get_store_name(main.from_warehouse_type_id,main.from_warehouse_code) as from_facility,
									main.to_warehouse_code as to_facility_id,
									get_store_name(main.to_warehouse_type_id,main.to_warehouse_code) as to_facility,
									batch.quantity as quantity,
									detail.vvm_stage as vvm_stage,
									'Receive' as transaction_type_name,
									batch.number as batch_number,
									batch.expiry_date as batch_expiry,
									'' as batch_unit_price,
									batch.production_date as batch_production,
									get_product_name(batch.item_pack_size_id) as product,
									batch.item_pack_size_id as product_id,
									'' as transaction_reference,
									batch.created_date as created_date,
									batch.last_update as modified_date,
									'province' as facility_level
								FROM 
									epi_stock_master_history main 
								join 
									epi_stock_batch_history batch on batch.batch_master_id = main.master_id 
								JOIN 
									epi_stock_detail_history detail on detail.stock_batch_id = batch.batch_id 
								WHERE 
									(Date(main.created_date)='{$date}' OR Date(main.updated_date)='{$date}')
									AND main.transaction_type_id='1'
									AND main.to_warehouse_type_id='4' 
								ORDER BY main.transaction_number;
		") -> result_array();
	}
	public function getProReceiving($date){
		return $this -> db -> query("
								SELECT 
									'".date("Ymd")."'||batch.pk_id as transaction_id,
									main.transaction_date as transactionDate,
									main.transaction_number,
									main.transaction_type_id,
									main.from_warehouse_code as from_facility_id,
									get_store_name(main.from_warehouse_type_id,main.from_warehouse_code) as from_facility,
									main.to_warehouse_code as to_facility_id,
									get_store_name(main.to_warehouse_type_id,main.to_warehouse_code) as to_facility,
									batch.quantity as quantity,
									detail.vvm_stage as vvm_stage,
									'Receive' as transaction_type_name,
									batch.number as batch_number,
									batch.expiry_date as batch_expiry,
									'' as batch_unit_price,
									batch.production_date as batch_production,
									get_product_name(batch.item_pack_size_id) as product,
									batch.item_pack_size_id as product_id,
									'' as transaction_reference,
									batch.created_date as created_date,
									batch.last_update as modified_date,
									'province' as facility_level,
									main.stakeholder_activity_id as purpose,
									trim(trailing '-fed' from (select transaction_number from epi_stock_master where pk_id = (select batch_master_id from epi_stock_batch where pk_id = batch.parent_pk_id))) as \"vLMISReference\"
								FROM 
									epi_stock_master_history main 
								join 
									epi_stock_batch_history batch on batch.batch_master_id = main.master_id 
								JOIN 
									epi_stock_detail_history detail on detail.stock_batch_id = batch.batch_id 
								WHERE 
									(Date(main.created_date)='{$date}' OR Date(main.updated_date)='{$date}')									
									AND main.transaction_type_id='1'  
									AND main.to_warehouse_type_id='2' 
								ORDER BY main.transaction_number;
		") -> result_array();
	}
	public function getAdjustment($date){
		return $this -> db -> query("
								SELECT 
									'".date("Ymd")."'||batch.pk_id as transaction_id,
									main.transaction_date as transactionDate,
									main.transaction_number,
									main.transaction_type_id,
									main.from_warehouse_code as from_facility_id,
									get_store_name(main.from_warehouse_type_id,main.from_warehouse_code) as from_facility,
									main.to_warehouse_code as to_facility_id,
									get_store_name(main.to_warehouse_type_id,main.to_warehouse_code) as to_facility,
									batch.quantity as quantity,
									detail.vvm_stage as vvm_stage,
									'Adjustment' as transaction_type_name,
									batch.number as batch_number,
									batch.expiry_date as batch_expiry,
									'' as batch_unit_price,
									batch.production_date as batch_production,
									get_product_name(batch.item_pack_size_id) as product,
									batch.item_pack_size_id as product_id,
									'' as transaction_reference,
									batch.created_date as created_date,
									batch.last_update as modified_date,
									'province' as facility_level
								FROM 
									epi_stock_master_history main 
								join 
									epi_stock_batch_history batch on batch.batch_master_id = main.master_id 
								JOIN 
									epi_stock_detail_history detail on detail.stock_batch_id = batch.batch_id 
								JOIN 
									epi_transaction_types ttypes on ttypes.pk_id = main.transaction_type_id
								WHERE 
									(Date(main.created_date)='{$date}' OR Date(main.updated_date)='{$date}')
									AND ttypes.is_adjustment='1' 
									AND ttypes.status='1'
									AND main.to_warehouse_type_id='4' 
								ORDER BY main.transaction_number;
		") -> result_array();
	}
	public function getProAdjustment($date){
		return $this -> db -> query("
								SELECT 
									'".date("Ymd")."'||batch.pk_id as transaction_id,
									main.transaction_date as transactionDate,
									main.transaction_number,
									main.transaction_type_id,
									main.from_warehouse_code as from_facility_id,
									get_store_name(main.from_warehouse_type_id,main.from_warehouse_code) as from_facility,
									main.to_warehouse_code as to_facility_id,
									get_store_name(main.to_warehouse_type_id,main.to_warehouse_code) as to_facility,
									batch.quantity as quantity,
									detail.vvm_stage as vvm_stage,
									'Receive' as transaction_type_name,
									batch.number as batch_number,
									batch.expiry_date as batch_expiry,
									'' as batch_unit_price,
									batch.production_date as batch_production,
									get_product_name(batch.item_pack_size_id) as product,
									batch.item_pack_size_id as product_id,
									'' as transaction_reference,
									batch.created_date as created_date,
									batch.last_update as modified_date,
									'province' as facility_level,
									trim(trailing '-fed' from (select transaction_number from epi_stock_master where pk_id = (select batch_master_id from epi_stock_batch where pk_id = batch.parent_pk_id))) as vlmisvoucher
								FROM 
									epi_stock_master_history main 
								join 
									epi_stock_batch_history batch on batch.batch_master_id = main.master_id 
								JOIN 
									epi_stock_detail_history detail on detail.stock_batch_id = batch.batch_id 
								JOIN 
									epi_transaction_types ttypes on ttypes.pk_id = main.transaction_type_id
								WHERE 
									(Date(main.created_date)='{$date}' OR Date(main.updated_date)='{$date}')
									AND ttypes.is_adjustment='1' 
									AND ttypes.status='1'
									AND main.to_warehouse_type_id='2' 
								ORDER BY main.transaction_number;
		") -> result_array();
	}
	public function getFacilities(){
		$this -> db -> select("
			'null' as facility_code,
			fac.fac_name as facility_name,  
			districtname(fac.distcode) as district,
			tehsilname(fac.tcode) as tehsil_name,
			unname(fac.uncode) as uc_name, 
			'epi_centers' as epi_centers,
			'null' as warehouse_type_name,
			fac.facode as dhis_code, 
			facilities_population.population as population,
			getfstatus_vacc('".date('Y-m')."', fac.facode) as status,
			'null' as target
		");
		$this -> db -> from('facilities fac');
		$this -> db -> join('facilities_population','facilities_population.facode=fac.facode and facilities_population.year = \''.date('Y').'\'','LEFT');
		$this -> db -> where('fac.hf_type','e');
		$this -> db -> order_by('fac.tcode');
		$this -> db -> order_by('fac.fac_name');
		return $this -> db -> get() -> result_array();
	}
	public function getTypes(){
		$this -> db -> select("
			pk_id,
			transaction_type_name,
			case when nature='1' then '+' else '-' end as nature
		");
		$this -> db -> from('epi_transaction_types');
		$this -> db -> order_by('transaction_type_name');
		return $this -> db -> get() -> result_array();
	}
	public function getUcsPopulations(){
		/* $this -> db -> select('uncode as UC_CODE,unname(uncode) as UC_NAME,population as UC_POPULATION');
		$this -> db -> where('year',date('Y'));
		$this -> db -> order_by('uncode','ASC');
		return $this -> db -> get('unioncouncil_population') -> result_array(); */
	}
	public function getEpiCentersPopulations($distcode){
		/* $this -> db -> select('facode as EPI_CENTER_CODE,facilityname(facode) as EPI_CENTER_NAME,population as EPI_CENTER_POPULATION');
		$this -> db -> where(array('distcode'=>$distcode));
		$this -> db -> where('year',date('Y'));
		$this -> db -> order_by('facode','ASC');
		return $this -> db -> get('facilities_population') -> result_array(); */
	}
}
?>