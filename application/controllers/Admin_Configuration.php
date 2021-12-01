<?php
class Admin_Configuration extends CI_Controller {
	//================ Constructor function starts==================//
	public function __construct() {
		parent::__construct();
		$this->load->model('Inventory_types_model','campaign');
		authentication();
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('error_helper'); 
	}
	/*Functions for purpose type of vaccines started*/
	public function type_purpose() {
		$query = "select id,type from campaign_purpose order by type asc";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$data['fileToLoad'] = 'inventory_management/inventory_types_view';
		$data['pageTitle']='Purpose Types | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function type_save(){
		$type = $this->input->post('purpose');
		$name = $this->input->post('name');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		$this->campaign->campaign_save($type,$name,$id);
		echo 1;exit;
		}
	
	public function delete_type(){
		$id = $this->uri->segment(3);
		$query = "delete from campaign_purpose where id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/type_purpose";
		redirect($location);
	}
     public function edit_type(){
		$id= $this->input->post('id');
		$data =$this->campaign->campaign_edit($id);
		print_r($data[0]['type']);
	}	
	
	/*Function for purpose type of vaccines ended Here*/
	
	public function manufacturer(){
		$query = "select id,name from epi_manufacturer";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$data['fileToLoad'] = 'inventory_management/epi_manufacturer';
		$data['pageTitle']='Manufacturers | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function manufacturer_save(){
		$type = $this->input->post('purpose');
		$name = $this->input->post('name');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		$this->campaign->manufacturer_save($type,$name,$id);
		echo 1;exit;
	}
	public function edit_manufacturer(){
		$id= $this->input->post('id');
		$data =$this->campaign->manufacturer_edit($id);
		print_r($data[0]['name']);
	}	
	public function delete_manufacturer(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_manufacturer where id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/manufacturer";
		redirect($location);
	}
	public function warehouse(){
		$query = "select pk_id,warehouse_name from epi_cc_warehouse";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$query = "Select distcode, district from districts order by district ASC";
		$Dist_result = $this -> db -> query($query);
		$data['resultDist'] = $Dist_result -> result_array();
		$data['fileToLoad'] = 'inventory_management/epi_warehouse';
		$data['pageTitle']='Warehouse Information | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function warehouse_save(){
		$type = $this->input->post('purpose');
		$name = $this->input->post('name');
		$distcode = $this->input->post('distcode');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		$this->campaign->warehouse_save($type,$name,$distcode,$id);
		echo 1;exit;
	}
		public function edit_warehouse(){
		$id= $this->input->post('id');
		$data =$this->campaign->warehouse_edit($id);
		print_r($data[0]['warehouse_name']);
	}
	public function delete_warehouse(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_cc_warehouse where pk_id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/warehouse";
		redirect($location);
	}
	public function adjustment(){
		$query = "select id,type from adjustment_type";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$data['fileToLoad'] = 'inventory_management/adjustment_type';
		$data['pageTitle']='Adjustment Vaccines | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function adjustment_save(){
		$type = $this->input->post('purpose');
		$name = $this->input->post('name');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		$this->campaign->adjustment_save($type,$name,$id);
		echo 1;exit;
	}
	public function delete_adjustment(){
		$id = $this->uri->segment(3);
		$query = "delete from adjustment_type where id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/adjustment";
		redirect($location);
	}
	 public function edit_adjustment(){
		$id= $this->input->post('id');
		$data =$this->campaign->adjustment_edit($id);
		print_r($data[0]['type']);
	}	
	public function location(){
		$query = "select pk_id,asset_type_name from epi_cc_asset_types";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();  
		//print_r($data);exit;
		$locQuery = "select pk_id,warehouse_name from epi_cc_warehouse";
		$res = $this->db->query($locQuery);
		$data['options'] = $res->result_array();
		//print_r($data);exit;
		$data['fileToLoad'] = 'inventory_management/location_type';
		$data['pageTitle']='Vaccines Location | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function location_save(){
		$type = $this->input->post('purpose');
		$name = $this->input->post('name');
		$warehouse = $this->input->post('warehouses');
		$asset_id = $this->input->post('asset_id');
		$serial = $this->input->post('serial');
		$this->campaign->location_save($type,$name,$warehouse,$serial,$asset_id);
		echo 1;exit;
	}
	public function delete_location(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_cc_asset_types where pk_id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/location";
		redirect($location);
	}
	public function cc_asset() {
		$query = "select pk_id,asset_type_name,parent_id,short_name,equipmenttypename(ccm_equipment_type_id) as equipment_type from epi_cc_asset_types order by asset_type_name asc";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$this -> db -> select('pk_id,equipment_type_name');
		$data['equipment_types'] = $this -> db -> get('epi_cc_equipment_types') -> result_array();
		$data['fileToLoad'] = 'inventory_management/epi_cc_asset_type';
		$data['pageTitle']='Cold Chain Asset Types | EPI-MIS';
		$this->load->view('template/epi_template',$data);	
	}
	public function cc_asset_save(){
		$type = $this->input->post('purpose');
		$shortname = $this->input->post('shortname');
		$equipment_type_id = $this->input->post('equipment_type_id');
		$parent_id = $this->input->post('parent_id');
		$name = $this->input->post('name');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		//print_r($id);
		$this->campaign->save_cc_asset($type,$shortname,$name,$id,$equipment_type_id,$parent_id);
		echo 1;exit;
		}
	public function cc_asset_delete(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_cc_asset_types where pk_id= {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/cc_asset";
		redirect($location);
	}
	public function edit_cc_asset(){
		$id= $this->input->post('id');
		$data =$this->campaign->cc_asset_edit($id);
		echo json_encode($data);
	}
    public function status_history() {
		$data['warehouseTypeId'] = $warehouseTypeId = $this -> uri -> segment(2);
		//print_r($data);exit;
		$coldChainQuery = "";
		switch($warehouseTypeId){
			case 1:
				show_404();
				exit;
			case 2:
				$coldChainQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, pk_id, assets_type_id,warehouse_type_id, warehousetypename(warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, status, reasons, utilizations, freeze_alarm, heat_alarm FROM epi_cc_asset_status_history WHERE warehouse_type_id={$warehouseTypeId} AND procode='".$_SESSION["Province"]."' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=1) and ccm_id is not null ORDER BY ccm_id,pk_id DESC";
				$passiveContainerQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, total_quantity,modelname(ccmain.ccm_model_id) as model_name, working_quantity, pk_id, assets_type_id,ccstatushistory.warehouse_type_id, warehousetypename(ccstatushistory.warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, ccstatushistory.status, reasons, utilizations, freeze_alarm, heat_alarm, comments FROM epi_cc_asset_status_history ccstatushistory join epi_cc_coldchain_main ccmain on ccstatushistory.ccm_id=ccmain.asset_id WHERE ccstatushistory.warehouse_type_id={$warehouseTypeId} AND ccstatushistory.procode='".$_SESSION["Province"]."' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=2) ORDER BY ccm_id,pk_id DESC";
				break;
			case 3:
				show_404();
				exit;
			case 4:
				if( ! $this -> session -> District)
					redirect(base_url().'Update-status/2');
				$data['districtCode'] = $districtCode = $this -> uri -> segment(3);
				if($districtCode != $this -> session -> District)
					$districtCode = $this -> session -> District;
				$coldChainQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, pk_id, assets_type_id,warehouse_type_id, distcode, warehousetypename(warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, status, reasons, utilizations, freeze_alarm, heat_alarm FROM epi_cc_asset_status_history WHERE warehouse_type_id={$warehouseTypeId} AND procode='".$_SESSION["Province"]."' AND distcode='{$districtCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=1) ORDER BY ccm_id,pk_id DESC";
				$passiveContainerQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, total_quantity,modelname(ccmain.ccm_model_id) as model_name, working_quantity, pk_id, assets_type_id,ccstatushistory.warehouse_type_id, ccstatushistory.distcode, warehousetypename(ccstatushistory.warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, ccstatushistory.status, reasons, utilizations, freeze_alarm, heat_alarm, comments FROM epi_cc_asset_status_history ccstatushistory join epi_cc_coldchain_main ccmain on ccstatushistory.ccm_id=ccmain.asset_id  WHERE ccstatushistory.warehouse_type_id={$warehouseTypeId} AND ccstatushistory.procode='".$_SESSION["Province"]."' AND ccstatushistory.distcode='{$districtCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=2) ORDER BY ccm_id,pk_id DESC";;
				break;
			case 5:
				if( ! $this -> session -> District)
					redirect(base_url().'Update-status/2');
				$data['districtCode'] = $districtCode = $this -> uri -> segment(3);
				if($districtCode != $this -> session -> District)
					$districtCode = $this -> session -> District;
				$data['tehsilCode'] = $tehsilCode = $this -> uri -> segment(4);
				if(substr($tehsilCode,0,3) != $districtCode){
					$this -> session -> set_flashdata('message','Wrong Information Provided! Please select correct warehouse information!');
					redirect(base_url().'Update-status');
				}
				$coldChainQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, pk_id, assets_type_id,warehouse_type_id, distcode, tcode, warehousetypename(warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, status, reasons, utilizations, freeze_alarm, heat_alarm FROM epi_cc_asset_status_history WHERE warehouse_type_id={$warehouseTypeId} AND procode='".$_SESSION["Province"]."' AND distcode='{$districtCode}' AND tcode='{$tehsilCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=1) ORDER BY ccm_id,pk_id DESC";
				$passiveContainerQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, total_quantity,modelname(ccmain.ccm_model_id) as model_name, working_quantity, pk_id, assets_type_id,ccstatushistory.warehouse_type_id, ccstatushistory.distcode, ccstatushistory.tcode, warehousetypename(ccstatushistory.warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, ccstatushistory.status, reasons, utilizations, freeze_alarm, heat_alarm,comments FROM epi_cc_asset_status_history ccstatushistory join epi_cc_coldchain_main ccmain on ccstatushistory.ccm_id=ccmain.asset_id WHERE ccstatushistory.warehouse_type_id={$warehouseTypeId} AND ccstatushistory.procode='".$_SESSION["Province"]."' AND ccstatushistory.distcode='{$districtCode}' AND ccstatushistory.tcode='{$tehsilCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=2) ORDER BY ccm_id,pk_id DESC";
				break;
			case 6:
				if( ! $this -> session -> District)
					redirect(base_url().'Update-status/2');
				$data['districtCode'] = $districtCode = $this -> uri -> segment(3);
				if($districtCode != $this -> session -> District)
					$districtCode = $this -> session -> District;
				$data['tehsilCode'] = $tehsilCode = $this -> uri -> segment(4);
				if(substr($tehsilCode,0,3) != $districtCode){
					$this -> session -> set_flashdata('message','Wrong Information Provided! Please select correct warehouse information!');
					redirect(base_url().'Update-status');
				}
				$data['unioncouncilCode'] = $unioncouncilCode = $this -> uri -> segment(5);
				if(substr($unioncouncilCode,0,6) != $tehsilCode){
					$this -> session -> set_flashdata('message','Wrong Information Provided! Please select correct warehouse information!');
					redirect(base_url().'Update-status');
				}
				$data['facilityCode'] = $facilityCode = $this -> uri -> segment(6);
				if(substr($facilityCode,0,3) != $districtCode){
					$this -> session -> set_flashdata('message','Wrong Information Provided! Please select correct warehouse information!');
					redirect(base_url().'Update-status');
				}
				$coldChainQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, pk_id, assets_type_id,warehouse_type_id, distcode, tcode, uncode, facode, warehousetypename(warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, status, reasons, utilizations, freeze_alarm, heat_alarm FROM epi_cc_asset_status_history WHERE warehouse_type_id={$warehouseTypeId} AND procode='".$_SESSION["Province"]."' AND distcode='{$districtCode}' AND tcode='{$tehsilCode}' AND uncode='{$unioncouncilCode}' AND facode = '{$facilityCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=1) ORDER BY ccm_id,pk_id DESC";
				$passiveContainerQuery = "SELECT DISTINCT ON (ccm_id) ccm_id, getccmshortname(ccm_id) as shortname, total_quantity,modelname(ccmain.ccm_model_id) as model_name, working_quantity, pk_id, assets_type_id,ccstatushistory.warehouse_type_id, ccstatushistory.distcode, ccstatushistory.tcode, ccstatushistory.uncode, ccstatushistory.facode, warehousetypename(ccstatushistory.warehouse_type_id) || ' Warehouse' as warehousename, parentassettype(assets_type_id) as asset, assetname(assets_type_id) AS assetsubtype, ccstatushistory.status, reasons, utilizations, freeze_alarm, heat_alarm, comments FROM epi_cc_asset_status_history ccstatushistory join epi_cc_coldchain_main ccmain on ccstatushistory.ccm_id=ccmain.asset_id WHERE ccstatushistory.warehouse_type_id={$warehouseTypeId} AND ccstatushistory.procode='".$_SESSION["Province"]."' AND ccstatushistory.distcode='{$districtCode}' AND ccstatushistory.tcode='{$tehsilCode}' AND ccstatushistory.uncode='{$unioncouncilCode}' AND ccstatushistory.facode = '{$facilityCode}' AND assets_type_id IN (SELECT pk_id FROM epi_cc_asset_types WHERE ccm_equipment_type_id=2) ORDER BY ccm_id,pk_id DESC";
				break;
			default:
				break;
		}
		//print_r($passiveContainerQuery);exit;
		if($coldChainQuery != ""){
			$coldChainResult = $this -> db -> query($coldChainQuery);
			$data['coldChainData'] =	$coldChainResult -> result_array();
			$passiveContainerResult = $this -> db -> query($passiveContainerQuery);
			$data['passiveContainerData'] =	$passiveContainerResult -> result_array();
			//echo $this -> db -> last_query();exit;
		}
		$data['fileToLoad'] = 'coldchain/status_history';
		$data['pageTitle']='Asset Status History | EPI-MIS';
		$data['data'] = $data;
		$this->load->view('template/epi_template',$data);	
	}
    public function status_history_update()
	{
		//echo '<pre>';print_r($_POST);exit;
		$update_array = array();	
		foreach($_POST['warehouse_type_id'] as $key => $val){
			switch($val){
				case 2:
					$update_array['procode'] = $this -> session -> Province;
					$location = base_url()."Update-status/2";
					break;
				case 4:
					$update_array['procode'] = $this -> session -> Province;
					$update_array['distcode'] = $this -> session -> District;
					$location = base_url()."Update-status/4/".$this -> session -> District;
					break;
				case 5:
					$update_array['procode'] = $this -> session -> Province;
					$update_array['distcode'] = $this -> session -> District;
					$update_array['tcode'] = $_POST['tcode'][$key];
					$location = base_url()."Update-status/5/".$this -> session -> District.'/'.$update_array['tcode'];
					break;
				case 6:
					$update_array['procode'] = $this -> session -> Province;
					$update_array['distcode'] = $this -> session -> District;
					$update_array['tcode'] = $_POST['tcode'][$key];
					$update_array['uncode'] = $_POST['uncode'][$key];
					$update_array['facode'] = $_POST['facode'][$key];
					$location = base_url()."Update-status/6/".$this -> session -> District.'/'.$update_array['tcode'].'/'.$update_array['uncode'].'/'.$update_array['facode'];
					break;
			}
			$update_array['assets_type_id']=(isset($_POST['assets_type_id'][$key])) ? (int)$_POST['assets_type_id'][$key] :0;
			$update_array['ccm_id']=(isset($_POST['ccm_id'][$key])) ? (int)$_POST['ccm_id'][$key] : 0;
			$update_array['warehouse_type_id']=(isset($_POST['warehouse_type_id'][$key])) ? (int)$_POST['warehouse_type_id'][$key] :0;
			$update_array['status']=(isset($_POST['working_status'][$key])) ? (int)$_POST['working_status'][$key] : 0;
			$update_array['reasons']=(isset($_POST['reason'][$key]) && $_POST['reason'][$key]>0) ? (int)$_POST['reason'][$key] : 0;
			$update_array['utilizations']=(isset($_POST['utilization'][$key]) && $_POST['utilization'][$key]>0) ? (int)$_POST['utilization'][$key] : 0;
			$update_array['freeze_alarm']=(isset($_POST['freeze_alarm'][$key]) &&  $_POST['freeze_alarm'][$key]!='') ? (int)$_POST['freeze_alarm'][$key] : 0;
			$update_array['heat_alarm']=(isset($_POST['heat_alarm'][$key]) &&  $_POST['heat_alarm'][$key]!='') ? (int)$_POST['heat_alarm'][$key] :0;
			//print_r($update_array);exit;
			$history_id=$this -> Common_model -> insert_record('epi_cc_asset_status_history',$update_array);
			$coldChainData['status']=(isset($_POST['working_status'][$key])) ? (int)$_POST['working_status'][$key] : 0;
			$coldChainData['ccm_id']=(isset($_POST['ccm_id'][$key])) ? (int)$_POST['ccm_id'][$key] :0;
			//print_r($history_id);exit;
			//unset();
		//	Update coldchian main table
			$this -> Common_model -> update_record('epi_cc_coldchain_main',array('status'=>$coldChainData['status'],'ccm_status_history_id'=>$history_id),array('asset_id'=>$coldChainData['ccm_id']));
		}
	//	print_r($d);exit;
		$update_passive_array = array();	
		foreach($_POST['warehouseIdPassive'] as $key => $val){
			switch($val){
				case 2:
					$update_passive_array['procode'] = $this -> session -> Province;
					$location = base_url()."Update-status/2";
					break;
				case 4:
					$update_passive_array['procode'] = $this -> session -> Province;
					$update_passive_array['distcode'] = $this -> session -> District;
					$location = base_url()."Update-status/4/".$this -> session -> District;
					break;
				case 5:
					$update_passive_array['procode'] = $this -> session -> Province;
					$update_passive_array['distcode'] = $this -> session -> District;
					$update_passive_array['tcode'] = $_POST['tcode'][$key];
					$location = base_url()."Update-status/5/".$this -> session -> District.'/'.$update_passive_array['tcode'];
					break;
				case 6:
					$update_passive_array['procode'] = $this -> session -> Province;
					$update_passive_array['distcode'] = $this -> session -> District;
					$update_passive_array['tcode'] = $_POST['tcode'][$key];
					$update_passive_array['uncode'] = $_POST['uncode'][$key];
					$update_passive_array['facode'] = $_POST['facode'][$key];
					$location = base_url()."Update-status/6/".$this -> session -> District.'/'.$update_passive_array['tcode'].'/'.$update_passive_array['uncode'].'/'.$update_passive_array['facode'];
					break;
			}
			$passiveWhere = $update_passive_array;
			$passiveWhere['pk_id'] =(isset($_POST['pkId'][$key])) ? $_POST['pkId'][$key] : "0";
			$passiveWhere['warehouse_type_id'] =(isset($_POST['warehouseIdPassive'][$key])) ? $_POST['warehouseIdPassive'][$key] : "0";
			$update_passive_array['working_quantity'] = (isset($_POST['quantity'][$key])) ? $_POST['quantity'][$key] : "0";
			$update_passive_array['comments'] = (isset($_POST['comment'][$key])) ? $_POST['comment'][$key] : NULL;
			unset($passiveWhere['working_quantity'],$passiveWhere['comments']);
			$this -> Common_model -> update_record('epi_cc_asset_status_history',$update_passive_array,$passiveWhere);
			
		}
		$this -> session -> set_flashdata('message','You have successfully Updated your record!');
		redirect($location);	
	}
	public function manage_warehouse(){
		$query = "select pk_id,warehouse_type_name,CASE WHEN status='0' THEN 'Deactive' ELSE 'Active' END as status from epi_cc_warehouse_types";
		$result = $this->db->query($query);
		$data['data'] =	$result->result_array();
		$data['fileToLoad'] = 'inventory_management/manage_warehouse';
		$data['pageTitle']='Manage Warehouse Type | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function manage_warehouse_save(){
		$type = $this->input->post('type');
		$name = $this->input->post('name');
		$status = $this->input->post('status');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		
		$this->campaign->manage_warehouse_save($type,$name,$status,$id);
		echo 1;exit;
	}
	public function edit_manage_warehouse(){
		$id= $this->input->post('id');
		$data =$this->campaign->manage_warehouse_edit($id);
		echo json_encode($data);
	}
	public function delete_manage_warehouse(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_cc_warehouse_types where pk_id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/manage_warehouse";
		redirect($location);
	}public function stakeholder(){
		
		 /* $distcode="332";
		$query = 'Select * from(
					(select count(*)from facilities where distcode="$distcode" and hf_type="e" and catchment_area_pop::numeric <=1 ) as "FZP",

					(select count(*)from tehsil where distcode="$distcode" and population::numeric <=1 ) as "TZP",

					(select count(*)from unioncouncil where distcode="$distcode" and population::numeric <=1 )as "UZP",

					(select count(*)from facilities where facode NOT IN ( SELECT DISTINCT facode FROM techniciandb WHERE status="Active") and distcode="$distcode" and hf_type = "e") as "FZT",

					(select count(*)from unioncouncil  where uncode not in (select uncode from facilities where hf_type="e") and distcode="$distcode") as "UCNAF",

					(select count(*)from techniciandb where nic in (SELECT nic FROM techniciandb where status in("Active","Retired","Died") GROUP BY nic HAVING COUNT(nic) > 1 ) and distcode="$distcode") as "DTR"
		       ) as Errors  > 1';  */
		$query = "select pk_id,stakeholder_name from epi_stakeholder";
		$result = $this->db->query($query);
		//print_r($result);exit;
		$data['data'] =	$result->result_array();
		$data['fileToLoad'] = 'inventory_management/stakeholder';
		$data['pageTitle']='Stake Holder | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function stakeholder_save(){
		$stakeholder = $this->input->post('stakeholder');
		$name = $this->input->post('name');
		$parent_id = $this->input->post('parent_id');
		$id = $this->input->post('update_id')?$this->input->post('update_id'):0;
		
		$this->campaign->stakeholder_save($stakeholder,$name,$parent_id,$id);
		echo 1;exit;
	}
	public function edit_stakeholder(){
		$id= $this->input->post('id');
		$data =$this->campaign->stakeholder_edit($id);
		echo json_encode($data);
	}
	public function delete_stakeholder(){
		$id = $this->uri->segment(3);
		$query = "delete from epi_stakeholder where pk_id = {$id}";
		$res = $this->db->query($query);
		$this -> session -> set_flashdata('message','You have successfully Deleted your record!');
		$location = base_url()."Admin_Configuration/stakeholder";
		redirect($location);
	}
}
?>