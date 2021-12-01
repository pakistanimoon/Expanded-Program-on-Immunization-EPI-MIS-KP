<?php
/*
	@ Author: 				Omer Butt
	@ Email:  				omerbutt2521@gmail.com
	@ Class: 				Provincial
	@ Description:  		This class will be used to receive incoming API calls, verify them, and return needed information depending upon provided parameters.
	@						It will be used for receiving agent for Provincial epimis System
*/
class Provincial extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this -> load -> helper('epi_functions_helper');
				$code = md5(date("Y-n-d"));
		if(isset($_GET['code']) && $_GET['code'] == $code){
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'provincename' => 'Khyber Pakhtunkhwa',
				'Province' => $_GET['procode'],
				'loginfrom' => "Khyber Pakhtunkhwa"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		$this -> load -> model('Common_model','common');
		$this -> load -> model('API/Receiver_model','rcvr_mdl');
	}

/*
	@ Author: 				Omer Butt
	@ Email:  				omerbutt2521@gmail.com
	@ Function : 			get_stock_in_hand
	@ Description:  		This function will be used to receive information of 	current stock at all levels(Provincial,Districts,Tehsil,Facility) 
*/	
	public function get_stock_in_hand()
	{
		$whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
		$enddate = date("Y-m-d H:i:s");
		$result = ($this -> input -> post('result'))?$this -> input -> post('result'):'true';
		$itemCategory = ($this -> input -> post('itemCategory'))?$this -> input -> post('itemCategory'):'1';
		$distcode=$this->session->District;
		//Tehsil Stock comment.
		if(isset($distcode))
		{
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$distcode."','distcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	
		}
		else{	
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4',pk_id) as district_stock,get_pro_level_all_fac_closing_bal(pk_id) as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
			//echo $this->db->last_query();exit;
		}
		$data[] ="";
		foreach($items as $key=>$value) 
		{		
				$name=$value['name'];
				$itemid=$value['itemid'];
				$data["category"][]=array(
					"label"	=> $value['name']
					);
				$data["provincial"][]=array("value"	=> (int)$value['province_stock']);
				if(isset($distcode)){
				$data["district"][]=array("value"	=> (int)$value['district_stock']);
				$data["facility"][]=array("value"	=> (int)$value['facility'],"link"	=>"JavaScript:getDistrictFacility({$value["id"]},'{$name}','{$itemCategory}','Facility',{$itemid},{$distcode})");
				}
				else{  
				$data["district"][]=array("value"	=> (int)$value['district_stock'],"link"	=>"JavaScript:getDistrictWise({$value["id"]},'{$name}','{$itemCategory}','column2d','true')");
				$data["facility"][]=array("value"	=> (int)$value['facility'],"link"	=>"JavaScript:getDistrictWiseFacility({$value["id"]},'{$name}','{$itemCategory}','Districts',{$itemid},'column2d','true')");
				
				}
		}
			
		$viewData['data'] =$data;
		if($result=='true'){
		$viewData['fileToLoad'] = 'dashboard/provincial_stock';
		$viewData['pageTitle']='EPI-MIS Dashboard | Inventory Stock ';
		//send response to client.
		$this->load->view('thematic_template/thematic_template',$viewData);
		}
		else
		{
			echo json_encode($viewData);
		}
	}
	public function get_stock_in_hand_districts()
	{
		 $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'4';
		 $enddate = date("Y-m-d H:i:s");
		 $itemid=$_REQUEST['itemid'];
		$districts = $this->common->fetchall("districts",NULL,"distid,distcode,district as name ,get_curr_stock_quantity('".$enddate."','".$whtype."',distcode,$itemid) as stock");
		//$data["error"] = false;
		//$data["data"] = $districts;
		$i=0;
		foreach($districts as $key=>$value)
		{
			//print_r($value);
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock'],
				);
				$i++;
		}
		echo  json_encode($data);
	}

	//Facility Stock District Wise 
	function get_stock_in_hand_facilities()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$itemCategory=$_REQUEST['type'];
		$itemname=$_REQUEST['itemname'];
		$districts = $this->common->fetchall("districts",NULL,"distid,distcode,district as name ,get_pro_level_all_fac_closing_bal($itemid,distcode,'distcode') as stock");
		//$data["error"] = false;
		//$data["data"] = $districts;
		$i=0;$data[] ="";
		foreach($districts as $key=>$value)
		{
			//print_r($value);
			$distcode=$value['distcode'];
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock']
					);
				$i++;
		}
		//exit;
		echo  json_encode($data);
	}
	//Facility Level stock of parameter district 
	function get_stock_in_hand_dist_facilities()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$itemCategory=$_REQUEST['type'];
		$itemname=$_REQUEST['itemname'];
		$distcode=$_REQUEST['distcode'];
		$districts = $this->common->fetchall("facilities",NULL,"facode,fac_name as name ,get_pro_level_all_fac_closing_bal($itemid,facode,'facode') as stock",array('distcode'=>$distcode));
		$i=0;
		foreach($districts as $key=>$value)
		{
			//print_r($value);
			$facode=$value['facode'];
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock']
				);
				$i++;
		}
		
		echo  json_encode($data);
	}
	//Facility Stock Tehsil Wise;//
	function get_stock_in_hand_Tehsil_facilities()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$distcode=$_REQUEST['distcode'];
		$itemCategory=$_REQUEST['itemCategory'];
		$itemname=$_REQUEST['name'];
		$tehsils = $this->common->fetchall("tehsil",NULL,"tid,tcode,tehsil as name ,get_pro_level_all_fac_closing_bal($itemid,tcode,'tcode') as stock",array('distcode'=>$distcode));
		$i=0;
		foreach($tehsils as $key=>$value)
		{
			//print_r($value);
			$tcode=$value['tcode'];
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock'],
		"link"	=>"JavaScript:getFacilityWiseStock({$itemid},{$itemseqid},'Facility','{$itemname}',$tcode,$itemCategory)"
					
				);
				$i++;
		}
		//exit;
		echo  json_encode($data);
	}
	//Facilitie wise stock in hand 
	function get_stock_in_hand_facilities_wise()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$tcode=$_REQUEST['tcode'];
	//	$itemCategory=$_REQUEST['itemCategory'];
		$itemname=$_REQUEST['name'];
		$tehsils = $this->common->fetchall("facilities",NULL,"facode,fac_name as name ,coalesce(get_pro_level_all_fac_closing_bal($itemid,facode,'facode'),0) as stock",array('tcode'=>$tcode));
		//$data["error"] = false;
		//$data["data"] = $districts;
		$i=0;
		foreach($tehsils as $key=>$value)
		{
			
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock']
				);
				$i++;
		}
		//exit;
		echo  json_encode($data);
	}
	function get_stock_in_hand_tabular()
	{

		$whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
		$enddate = date("Y-m-d H:i:s");
		$result = ($this -> input -> post('result'))?$this -> input -> post('result'):'true';
		$itemCategory = ($this -> input -> post('itemCategory'))?$this -> input -> post('itemCategory'):'1';
		$distcode=$this->session->District;
		if(isset($distcode))
		{
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5','".$distcode."',pk_id) as Tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$distcode."','distcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	
		}
		else{	
		$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5',pk_id) as Tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id) as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
		}
		$data['data']=$items;
		echo json_encode($data);

	}
	/***-------------For HF stock out rate at province level-------------***/
		public function get_str_stock_out_data()
	{
        $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth,$itemCategory);
		$data[] ="";
		$distcode=$this->session->District;
		
				foreach($items as $key=>$value)
		{
			
			//aggregatic items id as where condition.
			$agg_items_id=$value['agg_items_id'];
			$itemname=$value['name'];
			$itemid=$value['id'];
			if($distcode){
			$link="JavaScript:getFacilityWiseHFStockoutRate({$itemid},'{$agg_items_id}','{$itemname}','{$distcode}')";
			}
			else
			{
				$link="JavaScript:getDistrictWiseHFStockoutRate({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true')";
			}
			if($value['submitted'] > 0)
					{
						$stockout=number_format(((int)$value['stockout']/(int)$value['submitted'])*100,2);
					}
					else
					{
						$stockout=0;
					}
			$data[] = array(
					"label"	=> $value['name'],
					"value"	=> $stockout, 
					"link"	=>$link
					
				);
			
		}
		echo  json_encode($data);
	}
	public function getItemCategoryId($type){
		switch($type){
			case "vaccines":
				return "1";
				break;
			case "diluents":
				return "3";
				break;
			case "nonvaccines":
				return "2";
				break;
			default:
				return "1";
				break;
		}
	}
	public function get_stockout_Rate_districts()
	{
		$agg_items_id=$_REQUEST['agg_items_id'];
		$itemList = substr($agg_items_id, 1, -1);;
		$itemList=explode(',',$itemList);
		$itemname=$_REQUEST['itemname'];
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		//$districts = $this->common->fetchall("districts",NULL,"distid,distcode ,district as name //,hf_total_submitted_count('$reportingmonth',distcode) as submitted,
		//get_pro_level_all_fac_stock_out_new('$cr_table_row','$reportingmonth','distcode',distcode) as stockout");
		//seeting where here for item ids
		$itemwhere="(";	
		$itemwhere.=implode(" OR ",$itemList);
		$itemwhere.=')';
		$districts = $this->common->fetchall("districts",NULL,"distid,distcode ,district as name ,hf_total_submitted_count('$reportingmonth',distcode) as submitted,
		(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where main_id>0 and  $itemwhere
					and fmonth = '$reportingmonth'
					and distcode=districts.distcode	
					group by fmonth,main_id having sum(closing_doses) < 1
				) as innerq
			) as stockout		
		");
		$data[] ="";
		
				foreach($districts as $key=>$value)
				{		
					if($value['submitted'] > 0)
					{
						$stockout=number_format(((int)$value['stockout']/(int)$value['submitted'])*100,2);
					}
					else
					{
						$stockout=0;
					}						
				$data[] = array(
					"label"	=> $value['name'],
					"value"	=>$stockout
					 
				);
			
		}
		//exit; 
		echo  json_encode($data);
	
	}
	//
	function get_stockout_Rate_facility()
	{
		$agg_items_id=$_REQUEST['agg_items_id'];
		$itemList = substr($agg_items_id, 1, -1);;
		$itemList=explode(',',$itemList);
		$itemname=$_REQUEST['itemname'];
		$itemid=$_REQUEST['itemid'];
		$distcode=$_REQUEST['distcode'];
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$itemwhere="(";	
		$itemwhere.=implode(" OR ",$itemList);
		$itemwhere.=')';
		$facilities = $this->common->fetchall("facilities",NULL,"facid,facode ,fac_name as name ,hf_total_submitted_count('$reportingmonth','facode',facode) as submitted,
		(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where main_id>0 and  $itemwhere
					and fmonth = '$reportingmonth'
					and facode=facilities.facode	
					group by fmonth,main_id having sum(closing_doses) < 1
				) as innerq
			) as stockout",array('distcode'=>$distcode));
		$data[] ="";
				foreach($facilities as $key=>$value)
				{		
					if($value['submitted'] > 0)
					{
						$stockout=number_format(((int)$value['stockout']/(int)$value['submitted'])*100,2);
					}
					else
					{
						$stockout=0;
					}						
				$data[] = array(
					"label"	=> $value['name'],
					"value"	=>$stockout
					 
				);
			
		}
		//exit; 
		echo  json_encode($data);
	}
	//stock out rate tabular form data
	function get_str_stock_out_data_tabular()
	{
		$whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
        $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$items = $this->rcvr_mdl->get_str_stock_out_data_new($reportingmonth,$itemCategory);
		$data['data']=$items;
		echo json_encode($data);
	}
}
?>	