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
        $tcode=$this->session->Tehsil;
		$levels=$this->session->UserLevel;
         //Tehsil Stock comment.
	    if($levels=='3') 
		{
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5','".$distcode."',pk_id,'tehsil') as tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$distcode."','distcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	 
		}  
	    else if($levels=='4')
        {
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5','".$tcode."',pk_id,'tehsil') as tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$tcode."','tcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	
		}  
        else{	
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5',pk_id) as tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id) as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));
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
			    if($levels=='3') {

				$data["district"][]=array("value"	=> (int)$value['district_stock']);
				$data["tehsil"][]=array("value"	    => (int)$value['tehsil_stock'],"link"	=>"JavaScript:getTehsilFacility({$value["id"]},'{$name}','{$itemCategory}','Facility',{$itemid},{$distcode})");
				$data["facility"][]=array("value"	=> (int)$value['facility'],"link"	=>"JavaScript:getDistrictFacility({$value["id"]},'{$name}','{$itemCategory}','Tehsil',{$itemid},{$distcode})");
				} 
			    else if($levels=='4'){
				$data["district"][]=array("value"	=> (int)$value['district_stock']);	
				$data["tehsil"][]=array("value"	=> (int)$value['tehsil_stock']);
				$data["facility"][]=array("value"	=> (int)$value['facility'],"link"	=>"JavaScript:getTehsilFacilityWise({$value["id"]},'{$name}','{$itemCategory}','Tehsil',{$itemid},{$tcode})");
				}  

				else{   
				$data["district"][]=array("value"	=> (int)$value['district_stock'],"link"	=>"JavaScript:getDistrictWise({$value["id"]},'{$name}','{$itemCategory}','column2d','true')");
				$data["tehsil"][]=array("value"	    => (int)$value['tehsil_stock'],"link"	=>"JavaScript:getTehsilWise({$value["id"]},'{$name}','{$itemCategory}','column2d','true')");
				$data["facility"][]=array("value"	=> (int)$value['facility'],"link"	=>"JavaScript:getDistrictWiseFacility({$value["id"]},'{$name}','{$itemCategory}','Districts',{$itemid},'column2d','true')");
				//print_r('sdf');

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
	public function get_stock_in_hand_tehsils() 
	{
		 $whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'5';
		 $enddate = date("Y-m-d H:i:s");
		 $itemid=$_REQUEST['itemid'];
		 $tehsil = $this->common->fetchall("tehsil",NULL,"tid,tcode,tehsil as name ,get_curr_stock_quantity('".$enddate."','".$whtype."',tcode,$itemid) as stock");
		 //echo $this->db->last_query(); exit();
		//$data["error"] = false;
		//$data["data"] = $districts;
		$data = NULL;
		$i=0;
		foreach($tehsil as $key=>$value)
		{
			if($value['stock']>0){
			//print_r($value);
			$data[$i] = array(
					"label"	=> $value['name'],
					"value"	=> (int)$value['stock'],
				);
				$i++;
			}	
		}
		//print_r($data); exit();
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
	//Facility Level stock of parameter tehsil 
	function get_stock_in_hand_tehsils_facilities()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$itemCategory=$_REQUEST['type'];
		$itemname=$_REQUEST['itemname'];
		$tcode=$_REQUEST['tcode'];
		$tehsil = $this->common->fetchall("facilities",NULL,"facode,fac_name as name ,get_pro_level_all_fac_closing_bal($itemid,facode,'facode') as stock",array('tcode'=>$tcode));
		$i=0;
		foreach($tehsil as $key=>$value)
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
		//Facility Level stock of parameter district
    //district user for tehsil		
	function get_stock_in_hand_tehs_facilities()
	{
		$itemseqid=$_REQUEST['itemseqid'];
		$itemid=$_REQUEST['itemid'];
		$itemCategory=$_REQUEST['type'];
		$itemname=$_REQUEST['itemname'];
		$distcode=$_REQUEST['distcode'];
		$whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'5';
		$enddate = date("Y-m-d H:i:s");
		$itemid=$_REQUEST['itemid'];
		//print_r($distcode); exit(); 
		//$tehsils = $this->common->fetchall("facilities",NULL,"facode,fac_name as name ,get_pro_level_all_fac_closing_bal($itemid,facode,'facode') as stock",array('tcode'=>$tcode));
		$tehsils = $this->common->fetchall("tehsil",NULL,"tid,tcode,tehsil as name ,get_curr_stock_quantity('".$enddate."','".$whtype."',tcode,$itemid) as stock",array('distcode'=>$distcode));
		//echo $this->db->last_query(); exit();
		$i=0;
		$data = NULL;  
		foreach($tehsils as $key=>$value)
		{
			//print_r($value);
			//$facode=$value['facode'];
			$tcode=$value['tcode'];
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
		$tcode=$this->session->Tehsil;
		$levels=$this->session->UserLevel;
		if($levels=='3') 
		{
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5','".$distcode."',pk_id,'tehsil') as Tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$distcode."','distcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	
		}
		else if($levels=='4')

		{
			$items = $this->common->fetchall("epi_item_pack_sizes",NULL,"pk_id as id,item_name as name,coalesce(cr_table_row_numb,0) as itemid,activity_type_id as activityid,get_stackholder_activity_name(activity_type_id) as activity,get_curr_stock_quantity('".$enddate."','".$whtype."','".$distcode."',pk_id) as province_stock,get_curr_stock_quantity('".$enddate."','4','".$distcode."',pk_id) as district_stock,get_curr_stock_quantity('".$enddate."','5','".$tcode."',pk_id,'tehsil') as tehsil_stock,get_pro_level_all_fac_closing_bal(pk_id,'".$tcode."','tcode') as Facility",array("item_category_id"=>$itemCategory,"cr_table_row_numb !="=>NULL),NULL,array("by"=>"activity_type_id || 'moon' || pk_id","type"=>"asc"));	
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
	/***************stock out Required Requisition  ****************/
	/** get HF stock Rate / Required Stock Requisiton**/
	public function get_HF_stockOut_Rate_Requisition()
	{
		 $distcode=$this->session->District;
		 $login=$this->session->loginfrom;
		 $itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
		 $reportingmonth = date('Y-m', strtotime('-1 month', time()));
		 $dataItems=$this->rcvr_mdl->get_HF_stockOut_Rate_Requisition($reportingmonth,$itemCategory);
		 $data[] ="";
		 foreach($dataItems as $key=>$value)
		{
			$agg_items_id=$value['agg_items_id'];
			$itemname=$value['name'];
			$itemid=$value['id'];
			$data["category"][]=array(
						"label"	=> $value['name']
						);
			if($distcode){
				$stockoutgreater=number_format(((int)$value['stockoutgreater']/(int)$value['submitted'])*100,2);		
				$data["stockoutgreater"][]=array("value" => $stockoutgreater,"link"	=>"JavaScript:getFacilityWiseHFStockoutRate_Requisition({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true','greater','{$distcode}','{$login}')");
				$stockoutless=number_format(((int)$value['stockoutless']/(int)$value['submitted'])*100,2);		
				$data["stockoutless"][]=array("value" => $stockoutless,"link"	=>"JavaScript:getFacilityWiseHFStockoutRate_Requisition({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true','less','{$distcode}','{$login}')");
			}
			else
			{
				$stockoutgreater=number_format(((int)$value['stockoutgreater']/(int)$value['submitted'])*100,2);		
				$data["stockoutgreater"][]=array("value" => $stockoutgreater,"link"	=>"JavaScript:getDistrictWiseHFStockoutRate_Requisition({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true','greater')");
				$stockoutless=number_format(((int)$value['stockoutless']/(int)$value['submitted'])*100,2);		
				$data["stockoutless"][]=array("value" => $stockoutless,"link"	=>"JavaScript:getDistrictWiseHFStockoutRate_Requisition({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true','less')");
			}	
		}
		//print_r($data["stockoutless"]);exit;
		$login=$this->session->loginfrom;
		$datasource=array('chart'=>array(
				'subCaption' => 'Click on column/line/slice to drill down to sub level information of respective level',
				'caption' =>"Comparison of Stock requisition ($login)",
			   "yaxisname"=> "Vials/Pcs",
						"linethickness"=> "2",
						"formatnumberscale"=> "1",
						"baseFont"=> "lato-regular",
						"divLineAlpha"=> "40",
						"anchoralpha"=> "0",
						"animation"=> "1",
						"labelDisplay"=> "rotate",
						"slantLabels"=> "1",
						"numbersuffix"=>'%',
						//'numberPrefix' => '%',
						"legendborderalpha"=> "20",
						"drawCrossLine"=> "1",
						"crossLineColor"=> "#0d0d0d",
						"crossLineAlpha"=> "100",
						"tooltipGrayOutColor"=> "#80bfff",
						"theme"=> "zune",
						//"showValues" => "1",
						"valueFontColor"=> "#000000",
						"labelFontColor"=> "#000000",
						"valueBgColor"=> "#FFFFFF",
						"valueBgAlpha"=> "50",
						"thousandSeparatorPosition"=> "3,3,3",
						"useDataPlotColorForLabels"=> "1",                    
						"exportenabled"=> "1",
						"showBorder"=> "1"
			  ), 'categories' => 
			  array (
				0 => 
				array (
				  'category' =>$data["category"])),'dataset'=>array(0=> array (
				  'seriesname' => 'Stock Greater Requisition',
				  'data' => 
				 $data["stockoutgreater"]
				), 1 => 
				array (
				  'seriesname' => 'Stock Less Requisition',
				  'data' => 
				 $data["stockoutless"],
				),));
		echo  json_encode($datasource);
	
		//current issue stock and required stock are get for specific HF.
		//now merge it and check it for all facilities of current login district and compare whether issued stock is > required  Then count facilities for that.
	}
	//function for districts wise stock out requisition drill down 
	 function get_stockout_Rate_Requisition_districts()
	 {
		$agg_items_id=$_REQUEST['agg_items_id'];
		$itemList = substr($agg_items_id, 1, -1);;
		$itemList=explode(',',$itemList);
		$itemname=$_REQUEST['itemname'];
		$itemid=$_REQUEST['itemid'];
		$itemCategory=$_REQUEST['category_id'];
		$requisition=$_REQUEST['requisiton'];
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$year = date('Y');
		$itemwhere="(";	
		$itemwhere.=implode(" OR ",$itemList);
		$itemwhere.=')';
		//For requistion set operator
		$op=($requisition=="greater"?'>':'<');
		$districts = $this->common->fetchall("districts",NULL,"distid,distcode ,district as name ,hf_total_submitted_count('$reportingmonth','distcode',distcode) as submitted,
		(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					join epi_item_pack_sizes  on epi_consumption_detail.item_id= epi_item_pack_sizes.pk_id  where main_id>0 and epi_item_pack_sizes.cr_table_row_numb is not NULL   and  $itemwhere
					and fmonth = '$reportingmonth'
					and distcode=districts.distcode	
					group by fmonth,main_id,facode,epi_item_pack_sizes.item_id,epi_item_pack_sizes.item_id,epi_item_pack_sizes.multiplier,epi_item_pack_sizes.wastage_rate_allowed   having sum(received_doses) $op ( case when epi_item_pack_sizes.item_id IN (2,8,9,20) then getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (15) then ( (getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*1*epi_item_pack_sizes.wastage_rate_allowed*1.5) + (getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*(epi_item_pack_sizes.multiplier-1)*epi_item_pack_sizes.wastage_rate_allowed*1.5) ) when epi_item_pack_sizes.item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (6) then getmonthly_plwomen_targetpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 else 0 end ) ) as innerq ) as stockout
			");
		//print_r($districts);exit;
		$data[] ="";
		foreach($districts as $key=>$value)
				{		
					$distcode=$value['distcode'];
					$distname=$value['name'];
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
							"value"	=>$stockout,
							"link" =>"JavaScript:getFacilityWiseHFStockoutRate_Requisition({$itemid},'{$agg_items_id}','{$itemname}','{$itemCategory}','true','{$requisition}','{$distcode}','{$distname}')"
							 
						);
				}
		//exit; 
		echo  json_encode($data);
	 }
	 //function to get stock out Requisition facility wise drilldown /
	 function get_stockout_Rate_Requisition_facility()
	 {
		$agg_items_id=$_REQUEST['agg_items_id'];
		$itemList = substr($agg_items_id, 1, -1);;
		$itemList=explode(',',$itemList);
		$itemname=$_REQUEST['itemname'];
		$requisition=$_REQUEST['requisition'];
		$itemid=$_REQUEST['itemid'];
		$distcode=$_REQUEST['distcode'];
		$reportingmonth = date('Y-m', strtotime('-1 month', time()));
		$year = date('Y');
		$itemwhere="(";	
		$itemwhere.=implode(" OR ",$itemList);
		$itemwhere.=')';
		//For requistion set operator
		$op=($requisition=="greater"?'>':'<');
		$facilities = $this->common->fetchall("facilities",NULL,"facid,facode ,fac_name as name ,hf_total_submitted_count('$reportingmonth','facode',facode) as submitted,
		(
				select count(*) from(
					select main_id as balance from epi_consumption_detail join epi_consumption_master on 
					epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					join epi_item_pack_sizes  on epi_consumption_detail.item_id= epi_item_pack_sizes.pk_id  where main_id>0 and epi_item_pack_sizes.cr_table_row_numb is not NULL
					 and  $itemwhere
					and fmonth = '$reportingmonth'
					and facilities.facode=facode group by fmonth,main_id,facode,epi_item_pack_sizes.item_id,epi_item_pack_sizes.item_id,epi_item_pack_sizes.multiplier,epi_item_pack_sizes.wastage_rate_allowed   having sum(received_doses) $op ( case when epi_item_pack_sizes.item_id IN (2,8,9,20) then getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (15) then ( (getmonthlynewborn_targetpopulationpop(facode,'$year')::double precision*1*epi_item_pack_sizes.wastage_rate_allowed*1.5) + (getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*(epi_item_pack_sizes.multiplier-1)*epi_item_pack_sizes.wastage_rate_allowed*1.5) ) when epi_item_pack_sizes.item_id IN (3,4,5,7,17,19,21,22,23,24,26) then getmonthly_survivinginfantspop(facode,'facility','$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 when epi_item_pack_sizes.item_id IN (6) then getmonthly_plwomen_targetpop(facode,'$year')::double precision*epi_item_pack_sizes.multiplier*epi_item_pack_sizes.wastage_rate_allowed*1.5 else 0 end ) ) as innerq ) as stockout",array('distcode'=>$distcode));
		$data[] ="";
		foreach($facilities as $key=>$value)
				{		
					if($value['submitted'] > 0)
					{
						$stockout=number_format(((int)$value['stockout']/(int)$value['submitted'])*100,2);
						$data[] = array(
							"label"	=> $value['name'],
							"value"	=>$stockout,
							);
					}
				}
		//exit; 
		echo  json_encode($data);
	 }
	 //function for tabular form of hf stock our requisition
	 	function get_str_stock_out_requisition_data_tabular()
		{
			$whtype = ($this -> input -> post('level'))?$this -> input -> post('level'):'2';
			$itemCategory = $this->getItemCategoryId(($this -> input -> post('typeofitems'))?$this -> input -> post('typeofitems'):'1');
			$reportingmonth = date('Y-m', strtotime('-1 month', time()));
			$items = $this->rcvr_mdl->get_HF_stockOut_Rate_Requisition($reportingmonth,$itemCategory);
			$data['data']=$items;
			echo json_encode($data);
		}
		/***************stock out Required Requisition end ****************/
}
?>	