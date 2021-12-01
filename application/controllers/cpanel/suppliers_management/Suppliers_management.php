<?php
class Suppliers_management extends CI_Controller {

	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('cpanel/suppliers_management/Suppliers_management_model','suppliers_model');
		$this -> load -> model('Common_model');
	}
	//================ Constructor Function Ends Here ====================//
	//--------------------------------------------------------------------//
	//================ Item Listing Function Starts ================//
	public function suppliers_list(){
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
		
		$data = $this -> suppliers_model -> suppliers_list($per_page,$startpoint);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['UserLevel'] = $this -> session -> UserLevel;
		$data['startpoint'] = ($page * $per_page) - $per_page;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/suppliers_management/suppliers_list';
			$data['pageTitle'] = 'EPI-MIS | List of EPI-MIS Suppliers';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ item Listing Function Ends Here =============================//
	//-------------------------------------------------------- ---------------------------//
	//================ Function to Show Page for Adding New item Starts Here =======//	
	public function suppliers_add(){
		$data = $this -> suppliers_model ->suppliers_add();
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/suppliers_management/suppliers_add';
			$data['pageTitle'] = 'EPI-MIS| Add New Suppliers Form';
			$this -> load -> view('template/epi_template', $data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	//================ Function to Save Product Starts Here =======//	
	public function suppliers_save(){
		//print_r($_POST); exit;
		$data = $this -> suppliers_model ->get_listrank_suppliers();
		$list_rank=$data['get_listrank_suppliers'][0]['max']+1;
		$epi_stakeholders = array(
			'stakeholder_name' => ($this ->input -> post ('stakeholder_name')) ? $this ->input -> post ('stakeholder_name') : Null ,
			'stakeholder_type_id' => ($this ->input -> post ('stakeholder_type_id')) ? $this ->input -> post ('stakeholder_type_id') : Null ,
			'stakeholder_sector_id' => ($this ->input -> post ('stakeholder_sector_id')) ? $this ->input -> post ('stakeholder_sector_id') : Null,
			'geo_level_id' => ($this ->input -> post ('geo_level_id')) ? $this ->input -> post ('geo_level_id') : Null,
			'stakeholder_activity_id' => 1,
			'list_rank' => $list_rank
		);
		$stakeholder_id = $this -> Common_model -> insert_record('epi_stakeholders',$epi_stakeholders,'stakeholders_seq_id');
		$pack_size_description=$this->input->post('pack_size_description');
		$item_pack_size_id=$this->input->post('item_pack_size_id');
		$myInput=$this->input->post('myInput');
		//foreach for epi_stakeholder_item_pack_sizes
		if($myInput!='' || $myInput!=0){
			foreach($this->input->post('pack_size_description') as $key=>$val){
					$add_array=array(
						'pack_size_description' => (isset($pack_size_description[$key]) AND $pack_size_description[$key] !="")?$pack_size_description[$key]:NULL, 
						'item_pack_size_id' => (isset($item_pack_size_id[$key]) AND $item_pack_size_id[$key] !="")?$item_pack_size_id[$key]:NULL,  
						'stakeholder_id' => $stakeholder_id,  
						'status' => 1,  
					);
					$this -> Common_model -> insert_record('epi_stakeholder_item_pack_sizes',$add_array);	         
			}
		}
		$this -> session -> set_flashdata('message','You have successfully saved your record!'); 
		$location = base_url()."Suppliers_management/suppliers_list";
		redirect($location);
	}
	//================ Function to Save Product Ends Here =========================//
	public function suppliers_del($pk_id){
		$this-> suppliers_model-> delete_by_id($pk_id);
		redirect('Suppliers_management/suppliers_list');
	}
	public function suppliers_edit(){ 
		$pk_id = $this -> uri -> segment(3);
		$data['data'] =$this->suppliers_model ->suppliers_edit($pk_id);
		$data['fileToLoad'] = 'cpanel/suppliers_management/suppliers_edit';
		$data['pageTitle'] = 'EPI-MIS| Edit Suppliers Form';
		$this->load->view('template/epi_template',$data);
	}
	//================ Function to Update Product Starts Here =======//	
	public function suppliers_update(){
		//print_r($_POST); exit;
		$stackholder_pk_id=$this->input->post('stackholder_pk_id');
		$data =$this->suppliers_model ->suppliers_edit($stackholder_pk_id);
		$epi_stakeholders = array(
			'stakeholder_name' => ($this ->input -> post ('stakeholder_name')) ? $this ->input -> post ('stakeholder_name') : Null ,
			'stakeholder_type_id' => ($this ->input -> post ('stakeholder_type_id')) ? $this ->input -> post ('stakeholder_type_id') : Null,
			'stakeholder_sector_id' => ($this ->input -> post ('stakeholder_sector_id')) ? $this ->input -> post ('stakeholder_sector_id') : Null
		);
		$this-> Common_model-> update_record('epi_stakeholders',$epi_stakeholders,array('pk_id'=>$stackholder_pk_id));
		if(!empty($data['epi_stakeholder_item_pack_sizes'])){
			$pack_size_description=$this->input->post('pack_size_description');
			$item_pack_size_id=$this->input->post('item_pack_size_id');
			//foreach for pack size
			foreach($this->input->post('pack_size_description') as $key=>$val){
					$pk_id=$this->input->post('pk_id')[$key];
					$add_array=array(
						'pack_size_description' => (isset($pack_size_description[$key]) AND $pack_size_description[$key] !="")?$pack_size_description[$key]:NULL, 
						'item_pack_size_id' => (isset($item_pack_size_id[$key]) AND $item_pack_size_id[$key] !="")?$item_pack_size_id[$key]:NULL, 
						'stakeholder_id' => $stackholder_pk_id,  
						'status' => 1,  
					);
					if(empty($pk_id)){
						$q = $this -> Common_model -> insert_record('epi_stakeholder_item_pack_sizes',$add_array);			
					}else{
						$q =$this-> Common_model-> update_record('epi_stakeholder_item_pack_sizes',$add_array,array('pk_id'=>$pk_id));
					}
			}
		}	
		$this -> session -> set_flashdata('message','You have successfully Update your record!'); 
		$location = base_url()."Suppliers_management/suppliers_list";
		redirect($location);
	}
}
//End of Class