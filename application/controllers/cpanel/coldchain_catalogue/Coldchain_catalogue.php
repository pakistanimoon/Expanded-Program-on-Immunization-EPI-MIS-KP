<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coldchain_catalogue extends CI_Controller {
	
	//================ Constructor Function Starts ==================//
	public function __construct()
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
		$this->load->helper(array('form', 'url'));
		$this -> load -> model('cpanel/coldchain_catalogue/Coldchain_catalogue_model','catalogue_model');
		authentication();
	}
	//============================ Constructor Function Ends ============================//	

	//---------------------Catalogue Functions Starts-----------------------------	
	public function catalogue_refrigerator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"1"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_refrigerator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_coldroom_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"21"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_coldroom';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_voltageregulator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"23"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_voltageregulator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_generator_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"24"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_gnerator';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_transport_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"25"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_transport';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_vaccinecarriers_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"26"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_vaccinecarriers';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_coldbox_list(){
		$data['uri'] = $this -> uri -> segment(3);
		$data['assetTypesActiveContainers'] = $this-> Common_model -> fetchall('epi_cc_asset_types',NULL,'pk_id,asset_type_name',array("pk_id"=>"33"),NULL,array('by'=>'pk_id','type'=>'ASC'));
		$page = (int)(!($this -> input -> get('page')) ? 1 : $this -> input -> get('page'));
		if ($page <= 0){
			$page = 1;
		}
		$per_page = 30;
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "epi_cc_models";
		$multiple_search = "";
		$multiple_search .="epi_cc_models.asset_type_id = ".$data['uri']."";
		$data['refrigerator_data'] = $this -> catalogue_model -> allassets_list($per_page,$startpoint,$multiple_search);
		$data['pagination'] = $this -> Common_model -> pagination($statement, $per_page, $page, $url = '?');
		$data['data'] = $data;
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_assets_coldbox';
			$data['pageTitle']='Add Assets | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogue_coldchain_list()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$search = $this->input->get("search");
		$columns = $this->input->get("columns");
		$multiple_search = "";
		if(!empty($search['value'])){
			$assets = explode('-',$search['value']);
			$assetsID = $assets[0];
			if($assetsID=="23")
			{
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}else if($assetsID=="24")
			{
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}else if($assetsID=="25")
			{
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}
			else if($assetsID=="26")
			{
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}
			else if($assetsID=="33")
			{
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}
			else if($assetsID=="1"){
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}
			else if($assetsID=="21"){
				$multiple_search .="epi_cc_models.asset_type_id = '{$assetsID}'";
			}
		}else{
			$assetsID = "1";
			$multiple_search .="epi_cc_models.asset_type_id = '1'";
		}
		$col = 0;
        $dir = "";
		//print_r($multiple_search);exit;
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		$columns_valid = array(
			"serial",
			"catalogue_id",
			"assetname",
			"make_name",
			"model_name",
			//"created_date"
		);
	
		 if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 5) {
            $order = " order by pk_id ASC";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }
		//print_r($multiple_search);exit;
		$datalist = $this -> catalogue_model -> coldchainlist($start,$length,$order,$dir,$multiple_search,$assetsID);
		$formeditlink="Catalogue_refrigeratorEdit";
		if(!empty($search['value'])){
			if($assetsID=="1"){
				$formeditlink = "Catalogue_refrigeratorEdit";
			}else if($assetsID=="21"){
				$formeditlink = "Catalogue_coldroomEdit";
			}else if($assetsID=="23"){
				$formeditlink = "Catalogue_voltageRegulatorEdit";
			}else if($assetsID=="24"){
				$formeditlink = "Catalogue_generatorEdit";
			}else if($assetsID=="25"){
				$formeditlink = "Catalogue_transportEdit";
			}else if($assetsID=="26"){
				$formeditlink = "Catalogue_vaccineCarriersEdit";
			}else if($assetsID=="33"){
				$formeditlink = "Catalogue_coldBoxEdit";
			}else{
				$formeditlink = "Catalogue_refrigeratorEdit";
				
			}
		} 
		//print_r($formlink);exit;
		$data=array();
		$i=$start+1;
		foreach($datalist['data'] as $r)
		{
			$data[] = array(
				"serial" => $i,
				"pk_id" => $r['pk_id'],
				"catalogue_id" => $r['catalogue_id'],
				"assetname" =>$r['assetname'],
				"make_name" => $r['make_name'],	
				"model_name" =>$r['model_name'],
				"is_active" =>$r['is_active'],
				"formeditlink"=>$formeditlink
			);
			$i++;
		}
		//print_r($data);exit;
		$patient_total = $this->catalogue_model->coldchaintotal($multiple_search,$assetsID);   
		$output = array(
			"draw" => $draw,
			"recordsTotal" =>$patient_total,
			"recordsFiltered" => $patient_total,
			"data" => $data
		);
		echo json_encode($output);
	}
	public function catalogue_refrigerator_add(){
		$data['offset']="No";
		$assetsID = 1;
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_refrigerator';
			$data['pageTitle']='Add Catalogue Refrigerator| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function catalogues_refrigeratorsave()
	{
		$makesData=array();//set data and insert to epi_cc_makes table 
		$modelData=array();//set data and insert to epi_cc_models table
		if($this->input->post('catalogue_id') !="" || $this->input->post('make_name') !="" || $this->input->post('model_name') !="" || $this->input->post('ccm_sub_asset_type_id') !="")
		{
			foreach($_POST as $key => $value)
			{
				$modelData[$key] = ($value=='')?NULL:$value;
			}
			if($modelData['is_pqs']==0){
				unset($modelData['asset_dimension_length'],$modelData['asset_dimension_width'],$modelData['asset_dimension_height'],$modelData['gross_capacity_4'],$modelData['gross_capacity_20'],$modelData['net_capacity_4'],$modelData['net_capacity_20']);
			}
			$makesData['make_name'] = $modelData['make_name'];
			$makesData['created_by'] = $modelData['created_by'] = $this->session->username;
			$this->db->trans_start();
			$makeid=$this-> Common_model -> insert_record('epi_cc_makes',$makesData);
			$modelData['ccm_make_id'] = $makeid;
			$modelData['asset_type_id'] = 1;
			$modelData['is_active'] = 1;
			$modelData['procode'] = $this->session->Province;
			unset($modelData['make_name'],$modelData['asset_id']);
			//print_r($modelData);exit;
			$this-> Common_model ->insert_record('epi_cc_models',$modelData);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Refrigerator_List/1');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Refrigerator_List/1');
	}
	/*Refrigerator Edit */
	//function for edit coldchain-regrigerator form
	function catalogue_refrigerator_edit()
	{
		$assetsID = 1;
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/refrigerator_edit';
		$data['pageTitle']='Catalogue Refrigerator Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	/*Refrigerator Update Function */
	public function catalogues_refrigeratorUpdate()
	{
		$makesData=array();//set data and insert to epi_cc_makes table 
		$modelData=array();//set data and insert to epi_cc_models table
		$catalogueData=array();//set data and insert to epi_cc_models table
		if($this->input->post('catalogue_id') !="" || $this->input->post('make_name') !="" || $this->input->post('model_name') !="" || $this->input->post('ccm_sub_asset_type_id') !="")
		{
			foreach($_POST as $key => $value)
			{
				$modelData[$key] = ($value=='')?NULL:$value;
			}
			if($modelData['is_pqs']==0){
				unset($modelData['asset_dimension_length'],$modelData['asset_dimension_width'],$modelData['asset_dimension_height'],$modelData['gross_capacity_4'],$modelData['gross_capacity_20'],$modelData['net_capacity_4'],$modelData['net_capacity_20']);
			}
			$makesData['make_name'] = $modelData['make_name'];
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$makesData,array('pk_id'=>$modelData['ccm_make_id']));
			unset($modelData['make_name'],$modelData['asset_id']);
			$result=$this->db->update("epi_cc_models",$modelData,array('pk_id'=>$modelData['pk_id']));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Refrigerator_List/1";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Refrigerator_List/1');
		}
		redirect('Coldchain/Catalogue_Refrigerator_List/1');		
	}
	public function catalogue_coldroom_add(){
		$data['offset']="No";
		$assetsID = 21;
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_coldRoom';
			$data['pageTitle']='Add Catalogue Coldroom| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function catalogues_coldroomsave()
	{
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('net_capacity')!='' && $this->input->post('gross_capacity')!='')
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$catalogue_id = $this->input->post('catalogue_id');
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $makeID,
				'internal_dimension_length' => (! is_null($this->input->post('asset_dimension_length')))?$this->input->post('asset_dimension_length'):0,
				'internal_dimension_width' 	=> (! is_null($this->input->post('asset_dimension_width')))?$this->input->post('asset_dimension_width'):0,
				'internal_dimension_height' => (! is_null($this->input->post('asset_dimension_height')))?$this->input->post('asset_dimension_height'):0,
				'gross_capacity_20' 		=> $this->input->post('gross_capacity'),
				'net_capacity_20' 			=> $this->input->post('net_capacity'),
				'gas_type' 					=> (! is_null($this->input->post('gas_type')))?$this->input->post('gas_type'):'R12',
				'product_price' 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):0,
				'catalogue_id' 				=> $catalogue_id,
				'ccm_sub_asset_type_id'		=> (! is_null($this->input->post('ccm_sub_asset_type_id')))?$this->input->post('ccm_sub_asset_type_id'):9,
				'asset_type_id'				=> '21',
				'is_active'					=> '1',
				'procode' 					=> $procode,
				'created_by' 				=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Coldroom_List/21');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Coldroom_List/21');
	}
	/*Refrigerator Edit */
	//function for edit coldchain-regrigerator form
	function catalogue_coldroom_edit()
	{
		$assetsID = 21;
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/coldroom_edit';
		$data['pageTitle']='Catalogue Coldroom Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_coldroomUpdate()
	{
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('net_capacity')!='' && $this->input->post('gross_capacity')!='')
		{
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL
			);
			$this->db->trans_start();
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$catalogue_id = $this->input->post('catalogue_id');
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $ccm_make_id,
				'internal_dimension_length' => (! is_null($this->input->post('asset_dimension_length')))?$this->input->post('asset_dimension_length'):0,
				'internal_dimension_width' 	=> (! is_null($this->input->post('asset_dimension_width')))?$this->input->post('asset_dimension_width'):0,
				'internal_dimension_height' => (! is_null($this->input->post('asset_dimension_height')))?$this->input->post('asset_dimension_height'):0,
				'gross_capacity_20' 		=> $this->input->post('gross_capacity'),
				'net_capacity_20' 			=> $this->input->post('net_capacity'),
				'gas_type' 					=> (! is_null($this->input->post('gas_type')))?$this->input->post('gas_type'):'R12',
				'product_price' 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):0,
				'catalogue_id' 				=> $catalogue_id,
				'ccm_sub_asset_type_id'		=> (! is_null($this->input->post('ccm_sub_asset_type_id')))?$this->input->post('ccm_sub_asset_type_id'):9,
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Coldroom_List/21";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Coldroom_List/21');		
		}
		redirect('Coldchain/Catalogue_Coldroom_List/21');		
	}
	public function catalogue_voltageregulator_add(){
		$data['offset']="No";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_voltageRegulator';
			$data['pageTitle']='Add Catalogue VoltageRegulator| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function catalogues_voltageregulatorsave(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('nominal_voltage')!='')
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$catalogue_id = $this->input->post('catalogue_id');
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $makeID,
				'nominal_voltage' => (! is_null($this->input->post('nominal_voltage')))?$this->input->post('nominal_voltage'):0,
				'continous_power' => (! is_null($this->input->post('continous_power')))?$this->input->post('continous_power'):0,
				'frequency' => (! is_null($this->input->post('frequency')))?$this->input->post('frequency'):NULL,
				'input_voltage_range' => (! is_null($this->input->post('input_voltage_range')))?$this->input->post('input_voltage_range'):NULL,
				'output_voltage_range' => (! is_null($this->input->post('output_voltage_range')))?$this->input->post('output_voltage_range'):NULL,
				'product_price' => (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'no_of_phases' => (! is_null($this->input->post('no_of_phases')))?$this->input->post('no_of_phases'):NULL,
				'catalogue_id' 	=> $catalogue_id,
				'ccm_sub_asset_type_id'	=> $assetTypeId, // same as asset type id becaues no sub time exist at valtage
				'asset_type_id'	=> $assetTypeId,
				'is_active'		=> '1',
				'procode'		=> $procode,
				'created_by' 	=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Voltageregulator_List/23');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Voltageregulator_List/23');
	}
	function catalogue_voltageregulator_edit()
	{
		$assetsID = 23;
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/voltageRegulator_Edit';
		$data['pageTitle']='Catalogue VoltageRegulator Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_voltageregulatorUpdate(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='' && $this->input->post('nominal_voltage')!='')
		{
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL
			);
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$catalogue_id = $this->input->post('catalogue_id');
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $ccm_make_id,
				'nominal_voltage' => (! is_null($this->input->post('nominal_voltage')))?$this->input->post('nominal_voltage'):0,
				'continous_power' => (! is_null($this->input->post('continous_power')))?$this->input->post('continous_power'):0,
				'frequency' => (! is_null($this->input->post('frequency')))?$this->input->post('frequency'):NULL,
				'input_voltage_range' => (! is_null($this->input->post('input_voltage_range')))?$this->input->post('input_voltage_range'):NULL,
				'output_voltage_range' => (! is_null($this->input->post('output_voltage_range')))?$this->input->post('output_voltage_range'):NULL,
				'product_price' => (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'no_of_phases' => (! is_null($this->input->post('no_of_phases')))?$this->input->post('no_of_phases'):NULL,
				'catalogue_id' 	=> $catalogue_id,
				'ccm_sub_asset_type_id'	=> $assetTypeId, // same as asset type id becaues no sub time exist at valtage
				'asset_type_id'	=> $assetTypeId
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Voltageregulator_List/21";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Voltageregulator_List/23');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Voltageregulator_List/23');
	}
	public function catalogue_generator_add(){
		$data['offset']="No";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_generator';
			$data['pageTitle']='Add Catalogue Generator| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogues_generatorsave(){
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $makeID,
				'ccm_sub_asset_type_id'	=> $assetTypeId, // same as asset type id becaues no sub time exist at valtage
				'asset_type_id'	=> $assetTypeId,
				'is_active'		=> '1',
				'procode'		=> $procode,
				'created_by' 	=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Generator_List/24');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Generator_List/24');
	}
	function Catalogue_generator_edit()
	{
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/generator_Edit';
		$data['pageTitle']='Catalogue Generator Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_generatorUpdate(){
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL
			);
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $ccm_make_id,
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Generator_List/24";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Generator_List/24');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Generator_List/24');
	}
	public function catalogue_transport_add(){
		$data['offset']="No";
		if ($data != 0) {
			$assetsID = 25;
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_transport';
			$data['pageTitle']='Add Catalogue Transport| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	public function catalogues_transportsave(){
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL,
				'created_by' 	=> $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $makeID,
				'ccm_sub_asset_type_id'	=> $ccm_sub_asset_type_id, // same as asset type id becaues no sub time exist at valtage
				'asset_type_id'	=> $assetTypeId,
				'is_active'		=> '1',
				'procode'		=> $procode,
				'created_by' 	=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Transport_List/25');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Transport_List/25');
	}
	function Catalogue_transport_edit()
	{
		$assetsID = 25;
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['assets_sub_types'] = $this->catalogue_model -> get_all_coldchain_assets_types($assetsID);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/transport_edit';
		$data['pageTitle']='Catalogue Transport Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_transportUpdate(){
		if($this->input->post('make_name') !="" || $this->input->post('model_name') !="")
		{
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$dataMake = array( 						///data for make table
				'make_name'		=> (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL
			);
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$assetTypeId = $this->input->post('asset_type_id');
			$ccm_sub_asset_type_id = $this->input->post('ccm_sub_asset_type_id');
			$dataModel = array( 						///data for model table
				'model_name' 	=> $model_name,
				'ccm_make_id' 	=> $ccm_make_id,
				'is_active'		=> '1',
				'ccm_sub_asset_type_id' 	=> $ccm_sub_asset_type_id,
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Transport_List/25";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Transport_List/25');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Transport_List/25');
	}
	public function catalogue_vaccineCarriers_add(){
		$data['offset']="No";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_vaccineCarriers';
			$data['pageTitle']='Add Catalogue VaccineCarriers| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function catalogues_vaccinecarrierssave(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='')
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataMake = array(
				'make_name'	 => $make_name,
				'created_by' => $username
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$asset_type_id = $this->input->post('asset_type_id');
			$catalogueId = $catalogue_id;
			$dataModel = array(
				'catalogue_id'	 			=> $catalogueId,
				'model_name'	 			=> $model_name,
				'ccm_sub_asset_type_id'		=> $asset_type_id,
				'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length_popup')))?$this->input->post('asset_dimension_length_popup'):NULL,
				'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width_popup')))?$this->input->post('asset_dimension_width_popup'):NULL,
				'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height_popup')))?$this->input->post('asset_dimension_height_popup'):NULL,
				'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length_popup')))?$this->input->post('internal_dimension_length_popup'):NULL,
				'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width_popup')))?$this->input->post('internal_dimension_width_popup'):NULL,
				'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height_popup')))?$this->input->post('internal_dimension_height_popup'):NULL,
				'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length_popup')))?$this->input->post('storage_dimension_length_popup'):NULL,
				'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width_popup')))?$this->input->post('storage_dimension_width_popup'):NULL,
				'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height_popup')))?$this->input->post('storage_dimension_height_popup'):NULL,
				'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'net_capacity_4'	 		=> (! is_null($this->input->post('net_capacity_4')))?$this->input->post('net_capacity_4'):NULL,
				'cold_life'	 				=> (! is_null($this->input->post('text')))?$this->input->post('text'):NULL,
				'asset_type_id'				=> $asset_type_id,
				'ccm_make_id'	 			=> $makeID,
				'is_active'					=> '1',
				'procode'					=> $procode,
				'created_by'	 			=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Vaccinecarriers_List/26');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Vaccinecarriers_List/26');
	}
	function Catalogue_vaccineCarriers_edit()
	{
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/vaccineCarriers_Edit';
		$data['pageTitle']='Catalogue VoltageRegulator Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_vaccinecarriersUpdate(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='')
		{
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataMake = array(
				'make_name'	 => $make_name,
				'created_by' => $username
			);
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$asset_type_id = $this->input->post('asset_type_id');
			$catalogueId = $catalogue_id;
			$dataModel = array(
				'catalogue_id'	 			=> $catalogueId,
				'model_name'	 			=> $model_name,
				'ccm_sub_asset_type_id'		=> $asset_type_id,
				'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length_popup')))?$this->input->post('asset_dimension_length_popup'):NULL,
				'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width_popup')))?$this->input->post('asset_dimension_width_popup'):NULL,
				'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height_popup')))?$this->input->post('asset_dimension_height_popup'):NULL,
				'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length_popup')))?$this->input->post('internal_dimension_length_popup'):NULL,
				'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width_popup')))?$this->input->post('internal_dimension_width_popup'):NULL,
				'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height_popup')))?$this->input->post('internal_dimension_height_popup'):NULL,
				'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length_popup')))?$this->input->post('storage_dimension_length_popup'):NULL,
				'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width_popup')))?$this->input->post('storage_dimension_width_popup'):NULL,
				'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height_popup')))?$this->input->post('storage_dimension_height_popup'):NULL,
				'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'net_capacity_4'	 		=> (! is_null($this->input->post('net_capacity_4')))?$this->input->post('net_capacity_4'):NULL,
				'cold_life'	 				=> (! is_null($this->input->post('text')))?$this->input->post('text'):NULL,
				'asset_type_id'				=> $asset_type_id,
				'ccm_make_id'	 			=> $ccm_make_id
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Vaccinecarriers_List/26";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Vaccinecarriers_List/26');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Vaccinecarriers_List/26');
	}
	public function catalogue_coldbox_add(){
		$data['offset']="No";
		if ($data != 0) {
			$data['data'] = $data;
			$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/add_coldBox';
			$data['pageTitle']='Add Catalogue ColdBox| EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
		
	}
	public function catalogues_coldboxsave(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='')
		{
			$username = $this->session->User_Name;
			$procode = $this->session->Province;
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataMake = array(
				'make_name'	 => $make_name
			);
			$this->db->trans_start();
			$makeID = $this-> Common_model -> insert_record('epi_cc_makes',$dataMake);
			$asset_type_id = $this->input->post('asset_type_id');
			$catalogueId = $catalogue_id;
			$dataModel = array(
				'catalogue_id'	 			=> $catalogueId,
				'model_name'	 			=> $model_name,
				'ccm_sub_asset_type_id'		=> $asset_type_id,
				'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length')))?$this->input->post('asset_dimension_length'):NULL,
				'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width')))?$this->input->post('asset_dimension_width'):NULL,
				'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height')))?$this->input->post('asset_dimension_height'):NULL,
				'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length')))?$this->input->post('internal_dimension_length'):NULL,
				'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width')))?$this->input->post('internal_dimension_width'):NULL,
				'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height')))?$this->input->post('internal_dimension_height'):NULL,
				'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length')))?$this->input->post('storage_dimension_length'):NULL,
				'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width')))?$this->input->post('storage_dimension_width'):NULL,
				'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height')))?$this->input->post('storage_dimension_height'):NULL,
				'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'asset_type_id'				=> $asset_type_id,
				'ccm_make_id'	 			=> $makeID,
				'is_active'					=> '1',
				'procode'					=> $procode,
				'created_by'	 			=> $username
			);
			$modelID = $this-> Common_model -> insert_record('epi_cc_models',$dataModel);
			$this->db->trans_complete();
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Coldbox_List/33');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Coldbox_List/33');
	}
	function Catalogue_coldBox_edit()
	{
		$rcode['epi_cc_models.pk_id']=$asset_id= $this -> uri -> segment(3);
		$data['data'] = $this -> catalogue_model -> getRrefVaccData($rcode);
		$data['data'] =$data;
		//print_r($data['data']); exit();
		$data['fileToLoad'] = 'cpanel/coldchain_catalogue/add_forms/coldBox_Edit';
		$data['pageTitle']='Catalogue VoltageRegulator Edit | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function catalogues_coldboxUpdate(){
		if($this->input->post('catalogue_id')!='' && $this->input->post('make_name')!='' && $this->input->post('model_name')!='')
		{
			$ccm_make_id = $this->input->post('ccm_make_id');
			$pk_id = $this->input->post('pk_id');
			$catalogue_id = (! is_null($this->input->post('catalogue_id')))?$this->input->post('catalogue_id'):NULL;
			$make_name = (! is_null($this->input->post('make_name')))?$this->input->post('make_name'):NULL;
			$model_name = (! is_null($this->input->post('model_name')))?$this->input->post('model_name'):NULL;
			$dataMake = array(
				'make_name'	 => $make_name
			);
			$this->db->trans_start();
			$results=$this->db->update("epi_cc_makes",$dataMake,array('pk_id'=>$ccm_make_id));
			$asset_type_id = $this->input->post('asset_type_id');
			$catalogueId = $catalogue_id;
			$dataModel = array(
				'catalogue_id'	 			=> $catalogueId,
				'model_name'	 			=> $model_name,
				'ccm_sub_asset_type_id'		=> $asset_type_id,
				'asset_dimension_length'	=> (! is_null($this->input->post('asset_dimension_length')))?$this->input->post('asset_dimension_length'):NULL,
				'asset_dimension_width'		=> (! is_null($this->input->post('asset_dimension_width')))?$this->input->post('asset_dimension_width'):NULL,
				'asset_dimension_height'	=> (! is_null($this->input->post('asset_dimension_height')))?$this->input->post('asset_dimension_height'):NULL,
				'internal_dimension_length'	=> (! is_null($this->input->post('internal_dimension_length')))?$this->input->post('internal_dimension_length'):NULL,
				'internal_dimension_width'	=> (! is_null($this->input->post('internal_dimension_width')))?$this->input->post('internal_dimension_width'):NULL,
				'internal_dimension_height'	=> (! is_null($this->input->post('internal_dimension_height')))?$this->input->post('internal_dimension_height'):NULL,
				'storage_dimension_length'	=> (! is_null($this->input->post('storage_dimension_length')))?$this->input->post('storage_dimension_length'):NULL,
				'storage_dimension_width'	=> (! is_null($this->input->post('storage_dimension_width')))?$this->input->post('storage_dimension_width'):NULL,
				'storage_dimension_height'	=> (! is_null($this->input->post('storage_dimension_height')))?$this->input->post('storage_dimension_height'):NULL,
				'product_price'	 			=> (! is_null($this->input->post('product_price')))?$this->input->post('product_price'):NULL,
				'asset_type_id'				=> $asset_type_id,
				'ccm_make_id'	 			=> $ccm_make_id
			);
			$result=$this->db->update("epi_cc_models",$dataModel,array('pk_id'=>$pk_id));
			$this->db->trans_complete();
			if($result > 0)
			{
				$this -> session -> set_flashdata('message','Record Update Successfully. !');
				$location = base_url(). "Coldchain/Catalogue_Coldbox_List/33";
				redirect($location);
			}
		}
		else
		{
			$this -> session -> set_flashdata('message','SORRY! First Enter Required Field.');
			redirect('Coldchain/Catalogue_Coldbox_List/33');
		}
		$this -> session -> set_flashdata('message','Record Saved Successfully. !');
		redirect('Coldchain/Catalogue_Coldbox_List/33');
	}
	public function status_update(){
		$id=$this->input->post('id');
		$status=$this->input->post('status');
		$data = $this -> catalogue_model -> status_update($id,$status);
		echo json_encode($data,true); 
	}
	//---------------------Catalogue Functions End-----------------------------
}
