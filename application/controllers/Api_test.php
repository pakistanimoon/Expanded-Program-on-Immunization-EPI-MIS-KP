<?php
class Api_test extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		//print_r($_POST);
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
		dataEntryValidator(0);
		$this -> load -> model ('consumption/Crud_model',"crud");
		$this -> load -> model ('Common_model',"common");
	}
	public function index()
	{
	  syncComplianceDataWithFederalEPIMIS('vaccinationcompliance');
	  //syncDataWithFederalEPIMIS('form_b_cr','2019-01');
	}
	//from consumption_master,consumption_detail to form_b_cr form then upload to federal DB
	//done. need testing
	public function import_newData()
	{
		
		$distcode=$this->session->District;
		$this -> db -> select("epi_item_pack_sizes.pk_id as itemid,
		epi_item_pack_sizes.number_of_doses as doses,
		cr_table_row_numb");
		$this->db->from("epi_item_pack_sizes");
		$this->db->join("epi_items","epi_items.pk_id = epi_item_pack_sizes.item_id");
        $this -> db -> where('cr_table_row_numb Is Not Null');
        $this -> db -> where('activity_type_id',1);
        $allitems = $this -> db -> get() -> result_array();
		$this -> db -> select("item_id,get_cr_table_row_numb_id(item_id)");
		$this -> db -> select("concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(opening_doses),0)) as f1,concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(received_doses),0))   as f2 ,concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(vaccinated),0))  as f3,concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(used_vials),0))  as f4,concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(unused_vials),0))  as f5,concat(get_cr_table_row_numb_id(item_id),'-',COALESCE(SUM(closing_vials),0))  as f6");
		$this -> db -> from('epi_consumption_master master');
		$this -> db -> join('epi_consumption_detail detail','master.pk_id = detail.main_id','left');
		$this -> db -> where("fmonth",'2019-01');
		$this -> db -> where("distcode",$distcode);
		$this -> db -> group_by("item_id");
		$yearData = $this -> db -> get() -> result_array();
		$import_array=array();
		foreach($yearData as $val)
		{
			$v1 = explode("-",$val['f1']);
			$v2 = explode("-",$val['f2']);
			$v3 = explode("-",$val['f3']);
			$v4 = explode("-",$val['f4']);
			$v5 = explode("-",$val['f5']);
			$v6 = explode("-",$val['f6']);
			$index='cr_r'.$v1[0].'_f1';echo '<pre>';
			$import_array[0][$index]=$v1[1];
			$index='cr_r'.$v2[0].'_f2';echo '<pre>';
			$import_array[0][$index]=$v2[1];
			$index='cr_r'.$v3[0].'_f3';echo '<pre>';
			$import_array[0][$index]=$v3[1];
			$index='cr_r'.$v4[0].'_f4';echo '<pre>';
			$import_array[0][$index]=$v4[1];
			$index='cr_r'.$v5[0].'_f5';echo '<pre>';
			$import_array[0][$index]=$v5[1];
			$index='cr_r'.$v6[0].'_f6';echo '<pre>';
			$import_array[0][$index]=$v6[1];
			
		}
		return $import_array;
	}
	public function getColumnNames($tableName='form_b_cr',$tableSchema='public',$dataType='double precision'){
			$CI = & get_instance();
			$CI -> db -> select('column_name');
			$CI -> db -> from('information_schema.columns');
			$CI -> db -> where(
								array(
									'table_schema' => $tableSchema,
									'table_name' => $tableName,
									'data_type' => $dataType,
									'ordinal_position <>' => 1 
								)
			);
			$ar=$tableColumns = $CI -> db -> get() -> result_array();
			print_r($ar);
		}
}	

?>