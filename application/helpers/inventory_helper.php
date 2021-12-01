<?php
if( ! function_exists('get_warehouse_code_column')){
	function get_warehouse_code_column($warehouseTypeId){
		$output = "";
		switch($warehouseTypeId){
			case 2:
				$output = 'procode';
				break;
			case 3:
				$output = 'divcode';
				break;
			case 4:
				$output = 'distcode';
				break;
			case 5:
				$output = 'tcode';
				break;
			/* case 6:
				$output = 'uncode';
				break; */
			case 6:
				$output = 'facode';
				break;
		}
		return $output;
	}
}
if( ! function_exists('get_transfer_from')){
	function get_transfer_from($returnResult=FALSE,$transactionTypeId,$Id){
		$CI = & get_instance();
		if($transactionTypeId==14)
		{
		$whereCondition = array(
			'batch_id' => $Id
		);
		
		$CI -> db -> select('get_product_name(item_pack_size_id) as transfer_from');
		$CI -> db -> from('epi_stock_batch_history');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["transfer_from"];
		else
			echo $result["transfer_from"];
	
	}
	else if($transactionTypeId==13)
		{
		$whereCondition = array(
			'batch_id' => $Id
		);
		$result = $CI -> db ->query('select get_product_name(item_pack_size_id) as transfer_from from epi_stock_batch_history 
		where batch_id= (select parent_pk_id from epi_stock_batch_history where batch_id='.$Id.')') -> row_array();
		if($returnResult)
			return $result["transfer_from"];
		else
			echo $result["transfer_from"];
	
	}
	else{}
	}
}
if( ! function_exists('get_transfer_to')){
	function get_transfer_to($returnResult=FALSE,$transactionTypeId,$Id){
		
		$CI = & get_instance();
	if($transactionTypeId==14 )
		{
		$whereCondition = array(
			'parent_pk_id' => $Id
		);
		$CI -> db -> select('get_product_name(item_pack_size_id) as transfer_to');
		$CI -> db -> from('epi_stock_batch_history');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["transfer_to"];
		else
			echo $result["transfer_to"];
	}
	else if($transactionTypeId==13)
	{
		$whereCondition = array(
			'batch_id' => $Id
		);
		$CI -> db -> select('get_product_name(item_pack_size_id) as transfer_to');
		$CI -> db -> from('epi_stock_batch_history');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["transfer_to"];
		else
			echo $result["transfer_to"];
	}
	else{}
	
	
	}	
}	
if( ! function_exists('get_warehouse_option')){
	function get_warehouse_option($warehouseTypeId){
		$CI = & get_instance();
		$option = "<option>--Select Warehouse--</option>";
		$distcode = $CI -> session -> District;
		if($distcode){
			$whereCondition = array(
				'warehouse_type_id' => $warehouseTypeId,
				'distcode' => $distcode
			);
		}else{
			$whereCondition = array(
				'warehouse_type_id' => $warehouseTypeId
			);
		}
		$CI -> db -> select('pk_id,warehouse_name');
		$CI -> db -> from('epi_cc_warehouse');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row();
		if($result){
			$option = '<option selected="selected" value="'.$result -> pk_id.'">'.$result -> warehouse_name.'</option>';
		}
		echo $option;
	}
}
if( ! function_exists('get_warehouse_type_option')){
	function get_warehouse_type_option($returnResult=FALSE,$warehouseTypeId=NULL,$selected=NULL,$includefundsource=FALSE,$createoption=TRUE,$includefederal=TRUE){
		$CI = & get_instance();
		//$option = "<option>--Select Warehouse--</option>";
		$whereCondition = array();
		$whereCondition['status'] = 1;
		if($warehouseTypeId){
			$whereCondition['pk_id'] = $warehouseTypeId;
		}
		$CI -> db -> select('pk_id as id,warehouse_type_name as name');
		$CI -> db -> from('epi_cc_warehouse_types');
		$CI -> db -> where($whereCondition);
		//$distcode = $CI -> session -> District;
        $sessionwhtype = $CI -> session -> curr_wh_type;
		if($sessionwhtype == 4){
			$CI -> db -> where_in('pk_id',array(4,5,6));
		}else if($sessionwhtype==5){
			$CI -> db -> where_in('pk_id',array(4,5,6));
		}else{
			$idstoshow = array();
			if($includefederal){
				$idstoshow[] = 1;
			}
			$idstoshow[] = 2;
			$idstoshow[] = 4;
			if($includefundsource){
				$idstoshow[] = 7;
			}
			$CI -> db -> where_in('pk_id',$idstoshow);
		}
        $CI -> db -> order_by("pk_id","ASC");
		$result = $CI -> db -> get() -> result_array();
		/* update for selected dropdown */
		if($createoption){
			if($selected)
			{
				$option = get_options_html($result,FALSE,FALSE,$selected);
			}
			else
			{
				$option = get_options_html($result);
			}
		}else{
			$option = $result;
		}
		if($returnResult)
			return $option;
		else
			echo $option;
	}
}
if( ! function_exists('get_funding_sources')){
	function get_funding_sources($returnResult=FALSE,$selected=NULL){
		$CI = & get_instance();
		$option = "<option selected=\"selected\">--Select Funding Source--</option>";
		$whereCondition = array(
			'stakeholder_type_id' => 2
		);
		$CI -> db -> select('pk_id,stakeholder_name');
		$CI -> db -> from('epi_stakeholders');
		$CI -> db -> where($whereCondition);
		$CI -> db -> order_by('list_rank','ASC');
		$result = $CI -> db -> get() -> result_array();
		foreach($result as $key => $value){
			$selectedtext = ($selected and $selected==$value['pk_id'])?'selected="selected"':'';
			$option .= '<option value="' . $value['pk_id'] . '" '.$selectedtext.'>' . $value	['stakeholder_name'] .'</option>';
		}
		if($returnResult)
			return $option;
		else
			echo $option;
	}
}
if( ! function_exists('get_purposes')){
	function get_purposes($returnResult=FALSE,$selected=NULL,$createoption=TRUE){
		$CI = & get_instance();
		$option = "";
		$CI -> db -> select('pk_id,activity');
		$CI -> db -> from('epi_stakeholder_activities');
		$CI -> db -> where('status',1);
		$result = $CI -> db -> get() -> result_array();
		if($createoption){
		foreach($result as $key => $value){
			$selectedtext = ($selected and $selected==$value['pk_id'])?'selected="selected"':'';
			$option .= '<option value="' . $value['pk_id'] . '" '.$selectedtext.'>' . $value	['activity'] .'</option>';
		}
		}
		else
		{
			$option=$result;
		}
		if($returnResult)
			return $option;
		else
			echo $option;
	}
}
if( ! function_exists('get_products_by_activity')){
	function get_products_by_activity($activityID=NULL,$returnResult=FALSE,$selected=NULL,$createoption=TRUE){
		$CI = & get_instance();
		$option = "";
		$CI -> db -> select('pk_id as id,item_name as name,item_category_id,item_unit_id,itemunitname(item_unit_id) as unitname,activity_type_id');
		$CI -> db -> from('epi_item_pack_sizes');
		if($activityID){
			$CI -> db -> where('activity_type_id',$activityID);
			//$CI -> db -> or_where('activity_type_id',6);
		}
		$CI -> db -> where("item_category_id !=",4);
		$CI -> db -> order_by('list_rank','ASC');
		$result = $CI -> db -> get() -> result_array();
		if($createoption == true){
			$option = get_options_html($result,true,array("categoryid"=>"item_category_id","unitid"=>"item_unit_id","unittitle"=>"unitname","activity"=>"activity_type_id"),$selected);
		}else{
			$option = $result;
		}
		
		/* foreach($result as $key => $value){
			$option .= '<option value="' . $value['pk_id'] . '">' . $value	['item_name'] .'</option>';
		} */
		if($returnResult)
			return $option;
		else
			echo $option;
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_options_html
@ Description:   		Returns html of options depending upon data in parameter
@ Required Parameters:	id,name in data array
*/
if( ! function_exists('get_options_html')){
	function get_options_html($dataforoptions,$returnResult=FALSE,$dataAttr=FALSE,$selected=NULL){
		$option = "";
		foreach($dataforoptions as $key => $value){
			$dataattrstr = "";$selectedstr = "";
			if($dataAttr){
				foreach($dataAttr as $key1=>$val){
					//$val mean column name
					$dataattrstr .= 'data-'.$key1.'="'.$value[$val].'" ';
				}
			}
			if(isset($selected) && $selected===$value['id']){
				$selectedstr = 'selected="selected"';
			}
			$option .= '<option value="' . $value['id'] . '" '.$dataattrstr.' '.$selectedstr.'>' . $value	['name'] .'</option>';
		}
		if($returnResult)
			return $option;
		else
			echo $option;
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_funding_source_name
@ Description:   		Returns name of Funding Source depending upon id in parameter
*/
if( ! function_exists('get_funding_source_name')){
	function get_funding_source_name($returnResult=FALSE,$sourceid){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $sourceid
		);
		$CI -> db -> select('pk_id,stakeholder_name');
		$CI -> db -> from('epi_stakeholders');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["stakeholder_name"];
		else
			echo $result["stakeholder_name"];
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_product_name
@ Description:   		Returns name of Product depending upon id in parameter
*/
if( ! function_exists('get_product_name')){
	function get_product_name($returnResult=FALSE,$prodid){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $prodid
		);
		$CI -> db -> select('pk_id,item_name');
		$CI -> db -> from('epi_item_pack_sizes');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["item_name"];
		else
			echo $result["item_name"];
	}
}
/*
@ Author:        		Omer butt
@ Email:         		omerbutt2521@gmail.com
@ Function:      		get_purpose_name
@ Description:   		Returns name of purpose depending upon id in parameter
*/
if( ! function_exists('get_purpose_name')){
	function get_purpose_name($returnResult=FALSE,$prodid){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $prodid
		);
		$CI -> db -> select('pk_id,activity');
		$CI -> db -> from('epi_stakeholder_activities');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["activity"];
		else
			echo $result["activity"];
	}
}
/*
@ Author:        		Usama Hadi
@ Email:         		hadi.usama8@gmail.com
@ Function:      		get_category_name
@ Description:   		Returns name of category depending upon id in parameter
*/
if( ! function_exists('get_category_name')){
	function get_category_name($returnResult=FALSE,$catid){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $catid
		);
		$CI -> db -> select('pk_id,item_category_name');
		$CI -> db -> from('epi_item_categories');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["item_category_name"];
		else
			echo $result["item_category_name"];
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_manufacturer_name
@ Description:   		Returns name of Manufacturer depending upon id in parameter
*/
if( ! function_exists('get_manufacturer_name')){
	function get_manufacturer_name($returnResult=FALSE,$id){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $id
		);
		$CI -> db -> select('pk_id,stakeholder_name');
		$CI -> db -> from('epi_stakeholders');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["stakeholder_name"];
		else
			echo $result["stakeholder_name"];
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_ccm_name
@ Description:   		Returns name of Cold Chain Location depending upon id in parameter
*/
if( ! function_exists('get_ccm_name')){
	function get_ccm_name($returnResult=FALSE,$id){
		$CI = & get_instance();
		$whereCondition = array(
			'asset_id' => $id
		);
		$CI -> db -> select('asset_id,short_name as name');
		$CI -> db -> from('epi_cc_coldchain_main');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["name"];
		else
			echo $result["name"];
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_non_ccm_name
@ Description:   		Returns name of Non Cold Chain Location depending upon id in parameter
*/
if( ! function_exists('get_non_ccm_name')){
	function get_non_ccm_name($returnResult=FALSE,$id){
		$CI = & get_instance();
		$whereCondition = array(
			'pk_id' => $id
		);
		$CI -> db -> select('pk_id,location_name');
		$CI -> db -> from('epi_non_ccm_locations');
		$CI -> db -> where($whereCondition);
		$result = $CI -> db -> get() -> row_array();
		if($returnResult)
			return $result["location_name"];
		else
			echo $result["location_name"];
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_store_name
@ Description:   		Returns name of store depending upon type and code in parameter
*/
if( ! function_exists('get_store_name')){
	function get_store_name($returnResult=FALSE,$storetype,$storecode){
		$CI = & get_instance();	
               $CI -> load -> model ('Common_model',"common");
				
		switch($storetype){
			case 1:
				$name = 'Federal Vaccine Store';
				break;
			case 2:
				$dbdata = $CI->common->get_info("provinces",NULL,NULL,"province || ' EPI Store' as name",array("procode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 3:
				echo '';
				break; 
			case 4:
				$dbdata = $CI->common->get_info("districts",NULL,NULL,"'District ' || district || ' Store' as name",array("distcode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 5:
				$dbdata = $CI->common->get_info("tehsil",NULL,NULL,"'Tehsil ' || tehsil || ' Store' as name",array("tcode"=>$storecode));
				$name = $dbdata->name;
				break;
			case 6:
				//$dbdata = $CI->common->get_info("unioncouncil",NULL,NULL,"'UC ' || un_name || ' Store' as name",array("uncode"=>$storecode));
				$dbdata = $CI->common->get_info("facilities",NULL,NULL,"'Facility ' || fac_name || ' Store' as name",array("facode"=>$storecode));print_r($dbdata);exit;
				$name = $dbdata->name;
				break;
			case 7:
				$name = get_funding_source_name(true,$storecode);
				break;
			default:
				echo '';
				break;
		}
		if($returnResult)
			return $name;
		else
			echo $name;
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_warehouse_type_name
@ Description:   		Returns name of store level depending upon id in parameter
*/
if( ! function_exists('get_warehouse_type_name')){
	function get_warehouse_type_name($returnResult=FALSE,$warehouseTypeId=NULL){
		$CI = & get_instance();
		$whereCondition = array();
		$whereCondition['status'] = 1;
		if($warehouseTypeId){
			$whereCondition['pk_id'] = $warehouseTypeId;
		}
		$CI -> db -> select('pk_id as id,warehouse_type_name as name');
		$CI -> db -> from('epi_cc_warehouse_types');
		$CI -> db -> where($whereCondition);
		$distcode = $CI -> session -> District;
		if($distcode){
			$CI -> db -> where_in('pk_id',array(2,4,5,6));
		}else{
			$idstoshow = array(1,2,4);
			$CI -> db -> where_in('pk_id',$idstoshow);
		}
		$result = $CI -> db -> get() -> row();
		$name = $result->name;
		if($returnResult)
			return $name;
		else
			echo $name;
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		get_prod_vvmStage_options
@ Description:   		Returns vvm stages dropdown options for specific product depending upon code etc in parameter
*/
if( ! function_exists('get_prod_vvmStage_options')){
	function get_prod_vvmStage_options($productid,$selected=NULL){
		$CI = & get_instance();
		$CI->load->model('Common_model','common');		
		$resultarr = array();
		if($productid>0){
			/* $numbersforproducts = array(1,5,7,8,9,11,13,27,29,35);
			$usedforproducts = array(2,3,4,12,22,23,24,26,30,31,32,33,34);
			if(in_array($productid,$numbersforproducts)){
				$datafromdb = array(
					array("id"=>1,"name"=>1),
					array("id"=>2,"name"=>2),
					array("id"=>3,"name"=>3),
					array("id"=>4,"name"=>4)
				);
			}else if(in_array($productid,$usedforproducts)){
				$datafromdb = array(
					array("id"=>1,"name"=>"Usable"),
					array("id"=>3,"name"=>"Unusable")
				);
			} */
			$datafromdb = $CI->common->fetchall("vvm_stages",array("table"=>"epi_item_pack_sizes","tablecol"=>"vvm_stage_type","id"=>"type"),"vvm_stages.name as name,vvm_stages.value as id",array("epi_item_pack_sizes.pk_id"=>$productid),NULL,array("by"=>"list_rank","type"=>"ASC"));
			if(isset($datafromdb)){
				//function call to create options
				$resultarr = get_options_html($datafromdb,true,false,$selected);
			}else{
				$resultarr = '';
			}
		}
		echo $resultarr;
	}
}
/*
@ Author:        		Raja Imran Qamer
@ Email:         		rajaimranqamer@gmail.com
@ Function:      		isDate
@ Description:   		Check if the value is a valid date returns boolean true false
*/
function isDate($value) 
{
    if (!$value) {
        return false;
    }
    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}
//Function to check whether voucher no.in DB or not for sequence master tranNo check .
function check_Voucher_No($transNO)
{
	$CI = & get_instance();
	$CI -> db -> select('transaction_number');
	$CI -> db -> from('epi_stock_master');
	$CI -> db -> where("transaction_number",$transNO);
	$result = $CI -> db -> get() -> row();
	$t=false;
	if(isset($result->transaction_number) && $result->transaction_number )
	{
		$t=true;
	}
	
	return $t;
}
//function for cerv api
if( ! function_exists('validateToken')){
	function validateToken($username,$token, $appType='cerv')
	{
		$CI = & get_instance();
		$result = $CI -> db -> select('login_token') -> from('hr_app_users') -> where(array('fk_hr_code'=>$username,'app_type'=>$appType)) -> get() -> row_array();
		if($result['login_token'] == $token)
			return true;
		return false;
	}
	}
if( ! function_exists('authenticationbyusername')){
	function authenticationbyusername($username)
	{
		$CI = & get_instance();
		$CI -> db -> select('fk_hr_code');
		$CI -> db -> where(array('fk_hr_code' =>$username, 'app_type' => 'cerv'));
		$result = $CI -> db -> get('hr_app_users') -> row();
		$dbhrcode = (isset($result -> fk_hr_code))?$result -> fk_hr_code:'';
		return true;
		if($username == $dbhrcode){
			return true;
		}else{
			return false;

		}	
	}
}
//Function use to match record for vaccinedailycerv api
function vaccinedailyfillarray(&$originalarr,$arrtofills){
	foreach($arrtofills as $key=>$val){
		$tempkey = $val["rank"]."moon".$val["batch"]."moon".$val["doses"];
		if(isset($originalarr[$tempkey])){
			//$originalarr[$tempkey]["opening"]= $originalarr[$tempkey]["opening"]+isset($val["opening"])?$val["opening"]:0;
			//$originalarr[$tempkey]["recdoses"]= $originalarr[$tempkey]["recdoses"]+isset($val["recdoses"])?$val["recdoses"]:0;
			$originalarr[$tempkey]["used_vials"]= $originalarr[$tempkey]["used_vials"]+isset($val["used_vials"])?$val["used_vials"]:0;
			$originalarr[$tempkey]["used_doses"]= $originalarr[$tempkey]["used_doses"]+isset($val["used_doses"])?$val["used_doses"]:0;
			$originalarr[$tempkey]["unused_vials"]= $originalarr[$tempkey]["unused_vials"]+isset($val["unused_vials"])?$val["unused_vials"]:0;
			$originalarr[$tempkey]["unused_doses"]= $originalarr[$tempkey]["unused_doses"]+isset($val["unused_doses"])?$val["unused_doses"]:0;
			$originalarr[$tempkey]["vaccinated"]= $originalarr[$tempkey]["vaccinated"]+isset($val["vaccinated"])?$val["vaccinated"]:0;
		}else{
			$originalarr[$tempkey] = array(
				"itemid"=>isset($val["itemid"])?$val["itemid"]:0,
				"itemname"=>isset($val["itemname"])?$val["itemname"]:0,
				"item_name"=>isset($val["item_name"])?$val["item_name"]:0,
				"batch"=>isset($val["batch"])?$val["batch"]:0,
				"doses"=>isset($val["doses"])?$val["doses"]:0,
				"opening"=>isset($val["opening"])?$val["opening"]:0,
				"recdoses"=>isset($val["recdoses"])?$val["recdoses"]:0,
				"in_doses"=>isset($val["in_doses"])?$val["in_doses"]:0,
				"item_category_id"=>isset($val["item_category_id"])?$val["item_category_id"]:0,
				"used_vials"=>isset($val["used_vials"])?$val["used_vials"]:0,
				"used_doses"=>isset($val["used_doses"])?$val["used_doses"]:0,
				"unused_vials"=>isset($val["unused_vials"])?$val["unused_vials"]:0,
				"unused_doses"=>isset($val["unused_doses"])?$val["unused_doses"]:0,
				"vaccinated"=>isset($val["vaccinated"])?$val["vaccinated"]:0);
		}
	}
	return $originalarr;
}
?>