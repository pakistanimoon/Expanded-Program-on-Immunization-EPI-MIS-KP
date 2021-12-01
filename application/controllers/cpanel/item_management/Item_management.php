<?php
class Item_management extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('cpanel/item_management/Item_management_model','item_model');
		$this -> load -> model('User_management_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ Item Listing Function Starts ================//
	public function item_list(){
		//print_r($_REQUEST); exit();
		//Code for Pagination
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		// Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epiusers";
		
		$data = $this -> item_model -> item_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/item_management/item_list';
			$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Item';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ item Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New item Starts Here =======//	
	public function item_add(){
		$data = $this -> item_model ->item_add();
		foreach($data['epi_item_pack_sizes'] as $value) 
		$array[] = $value["cr_table_row_numb"];
		$data['selected'] = $array;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/item_management/item_add';
			$data['pageTitle'] = 'EPI-MIS| Add New Product Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Save Product Starts Here =======//	
	public function item_save(){
		//print_r($_POST); exit;
		$data = $this -> item_model ->get_listorder_items();
		$list_order=$data['get_listorder_items'][0]['max']+1;
		$epi_items_Data = array(
			'description' => ($this ->input -> post ('description')) ? $this ->input -> post ('description') : Null ,
			'item_category_id' => ($this ->input -> post ('item_category_id')) ? $this ->input -> post ('item_category_id') : Null ,
			'is_active' => ($this ->input -> post ('is_active')) ? $this ->input -> post ('is_active') : 0,
			'list_order' => $list_order,
			'created_by' => 'admin',
			'created_date' => date("Y-m-d H:i:s")
		);
		$item_id =$this -> Common_model -> insert_record('epi_items',$epi_items_Data,'item_seq_id');
		
		$item_name=$this->input->post('item_name');
		$number_of_doses=$this->input->post('number_of_doses');
		$item_category_id=$this->input->post('item_category_id');
		$item_unit_id = $this->input->post('item_unit_id');
		$activity_type_id = $this->input->post('activity_type_id');
		$vvm_stage_type = $this->input->post('vvm_stage_type');
		$cr_table_row_numb = $this->input->post('cr_table_row_numb');
		//foreach for pack size
		foreach($this->input->post('item_name') as $key=>$val){
			//print_r($val); exit;
				$add_array=array(
					'item_name' => (isset($item_name[$key]) AND $item_name[$key] !="")?$item_name[$key]:NULL, 
					'number_of_doses' => (isset($number_of_doses[$key]) AND $number_of_doses[$key] > 0)?$number_of_doses[$key]:NULL,
					'status' => '1',
					'list_rank' => '1',
					'multiplier' => '1',
					'item_category_id' => $item_category_id,
					'item_unit_id' => (isset($item_unit_id[$key]) AND $item_unit_id[$key] !="")?$item_unit_id[$key]:NULL,  
					'activity_type_id' => (isset($activity_type_id[$key]) AND $activity_type_id[$key] !="")?$activity_type_id[$key]:NULL,  
					'vvm_stage_type' => (isset($vvm_stage_type[$key]) AND $vvm_stage_type[$key] !="")?$vvm_stage_type[$key]:NULL, 
					'cr_table_row_numb' => (isset($cr_table_row_numb[$key]) AND $cr_table_row_numb[$key] !="")?$cr_table_row_numb[$key]:NULL,
					'item_id' => $item_id,  
				);
				$this -> Common_model -> insert_record('epi_item_pack_sizes',$add_array);	         
		}
		$this -> session -> set_flashdata('message','You have successfully saved your record!'); 
		$location = base_url()."Item_management/item_list";
		redirect($location);
	}
	//================ Function to Save Product Ends Here =========================//
	public function item_del($pk_id){
		$this-> item_model-> delete_by_id($pk_id);
		redirect('Item_management/item_list');
	}
	public function item_edit(){
		$pk_id = $this -> uri -> segment(3);
		$data['data'] =$this->item_model ->item_edit($pk_id);
		$item_add = $this -> item_model ->item_add();
		foreach($item_add['epi_item_pack_sizes'] as $value) 
		$array[] = $value["cr_table_row_numb"];
		$data['selected'] = $array;
		$data['fileToLoad'] = 'cpanel/item_management/item_edit';
		$data['pageTitle'] = 'EPI-MIS| Edit Product Form';
		$this->load->view('template/epi_template',$data);
	}
	/* public function add_edit()
	{
		$id = $this -> input -> post('id');
		$data['data'] =$this->item_model ->add_edit($id);
		echo json_encode($data['data']);
	} */				  
	//================ Function to Update Product Starts Here =======//	
	public function item_update(){
		//print_r($_POST); exit;
		$item_pk_id=$this->input->post('item_pk_id');
		$epi_items_Data = array(
			'description' => ($this ->input -> post ('description')) ? $this ->input -> post ('description') : Null ,
			'item_category_id' => ($this ->input -> post ('item_category_id')) ? $this ->input -> post ('item_category_id') : Null ,
			'is_active' => ($this ->input -> post ('is_active')) ? $this ->input -> post ('is_active') : 0,
			'created_by' => 'admin',
			'created_date' => date("Y-m-d H:i:s")
		);
		$this-> Common_model-> update_record('epi_items',$epi_items_Data,array('pk_id'=>$item_pk_id));
		
		$item_name=$this->input->post('item_name');
		$number_of_doses=$this->input->post('number_of_doses');
		$item_category_id=$this->input->post('item_category_id');
		$item_unit_id = $this->input->post('item_unit_id');
		$activity_type_id = $this->input->post('activity_type_id');
		$vvm_stage_type = $this->input->post('vvm_stage_type');
		$cr_table_row_numb = $this->input->post('cr_table_row_numb');
		//foreach for pack size
		foreach($this->input->post('item_name') as $key=>$val){
				$pk_id=$this->input->post('pk_id')[$key];
				$add_array=array(
					'item_name' => (isset($item_name[$key]) AND $item_name[$key] !="")?$item_name[$key]:NULL, 
					'number_of_doses' => (isset($number_of_doses[$key]) AND $number_of_doses[$key] > 0)?$number_of_doses[$key]:NULL,
					'status' => '1',
					'list_rank' => '1',
					'multiplier' => '1',
					'item_category_id' => $item_category_id,
					'item_unit_id' => (isset($item_unit_id[$key]) AND $item_unit_id[$key] !="")?$item_unit_id[$key]:NULL, 
					'activity_type_id' => (isset($activity_type_id[$key]) AND $activity_type_id[$key] !="")?$activity_type_id[$key]:NULL, 
					'vvm_stage_type' => (isset($vvm_stage_type[$key]) AND $vvm_stage_type[$key] !="")?$vvm_stage_type[$key]:NULL, 
					'cr_table_row_numb' => (isset($cr_table_row_numb[$key]) AND $cr_table_row_numb[$key] !="")?$cr_table_row_numb[$key]:NULL,
					'item_id' => $item_pk_id,  
				);
				if(empty($pk_id)){
					$q = $this -> Common_model -> insert_record('epi_item_pack_sizes',$add_array);			
				}else{
					$q = $this-> Common_model-> update_record('epi_item_pack_sizes',$add_array,array('pk_id'=>$pk_id));
				}
		}
		$this -> session -> set_flashdata('message','You have successfully Update your record!'); 
		$location = base_url()."Item_management/item_list";
		redirect($location);
	}
}
//End of Class