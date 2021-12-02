<?php
class ColdchainEquipments extends CI_Controller 
{
	//================ Constructor function starts==================//
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
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		$this -> load -> model('dashboard/Coldchain_equipment_model','ccm_model');
		$this -> load -> model ('Common_model',"common");
	}
	/*public function ccm_Main($var=null)
	{
		$data = (!$this -> input -> get('code'))?$this -> getUriSegmentData():$this -> getPostedData();
		$assetsArray = array('refrigerator','cold_room','voltage_regulator','generator','transport','vaccine_carrier','ice_pack','cold_box');
		//print_r($data);exit;
		if($this -> session -> District || $data['id'] ){
			//$data['id']  = $distcode = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
			$distcode = $data['id'];
			$data['districtName'] = $districtName = get_District_Name($distcode);
			$data['heading']['title'] = "UC Wise Cold Chain Equipments Information ".$districtName;
		}else{
			$distcode = "";
			$data['heading']['title'] = "District Wise Cold Chain Equipments Information";
		}
		$result = $this->ccm_model->get_cc_equipments_count('Active',$distcode);
		 $distcode=0;
		$i=0;
		$dataSeries = array();$dataSeries1 = array();$serieses1 = array();
		foreach($result as $row){
			//$serieses1[$i] = $row -> name;
			if($distcode!=$row['code']){
				$serieses['categories']['category'][$i]['label'] = $row['name'];
				$serieses1['data'][$i]['id'] = $row['code'];
				$serieses1['data'][$i]['value'] = $row['refrigerator'];
				$i++;
			}
			$distcode = $row['code'];
			
		}
		array_push($dataSeries,$serieses);
		array_push($dataSeries1,$serieses1);
		$stackbar['stackbar'] = json_encode($dataSeries);
		 print_r($stackbar);exit; 
		$viewData['seriesesdata'] = $result;
		$viewData['data'] = $data;
		$viewData['activeClass'] = $assetsArray[$data['asset_type_id']-1];//print_r($viewData);exit;
		$viewData['fileToLoad'] = 'dashboard/ccm_equipments/ccmMain';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}*/
	public function ccm_Main($var=null)
	{
		$data = (!$this -> input -> get('code'))?$this -> getUriSegmentData():$this -> getPostedData();
		$assetsArray = array('refrigerator','cold_room','voltage_regulator','generator','transport','vaccine_carrier','ice_pack','cold_box');
		$procode = $this->session->Province;
		if(($this -> session -> District) || ($data['id']) )
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:$data['id'];
			$data['districtName'] = $districtName = get_District_Name($distcode);
			$data['heading']['title'] = "UC Wise Cold Chain Equipments Information District, ".$districtName;
		}
		else
		{
			$distcode = "";
			$data['districtName'] = NULL;
			$data['heading']['title'] = "District Wise Cold Chain Equipments Information";
		}
		$result = $this->ccm_model->get_cc_equipments_count_provincial('Active',$distcode);
		//print_r($distcode);exit;
		for($i=0; $i<count($assetsArray); $i++)
		{
			
			$returnResult = $this-> getSeriesData($result,$assetsArray[$i],$i);
			$returnResult['districtName'] = $data['districtName'];
			$returnResult['id'] = $distcode;
			$returnResult['asset_type_id'] = $data['asset_type_id'];
			$returnResult[$assetsArray[$i]] = $this->getProvincialData($procode,'Active',$assetsArray[$i]);
			$data[$assetsArray[$i]]= $this->load->view('dashboard/ccm_equipments/'.$assetsArray[$i],$returnResult,true);//print_r($data);exit;
		}
		//print_r($returnResult);exit;
		$viewData['data'] = $data;
		$viewData['activeClass'] = $assetsArray[$data['asset_type_id']];
		$viewData['fileToLoad'] = 'dashboard/ccm_equipments/ccmMain';
		$viewData['pageTitle']='EPI-MIS Dashboard | Access to Health Services ';
		$this->load->view('thematic_template/thematic_template',$viewData);
	}
	public function getSeriesData($result,$assetTypes,$assetid)
	{
		$distcode=0;
		$i=0;
		$serieses = array();
		$dataSeries = array();
		$dataSeries1 = array();
		$AssetTypewisedata = array(
			"0"=> 0, //"Unallocated",
			"4"=> 0, //"District",
			"5"=> 0, //"Tehsil",
			"6"=> 0 //"Union Council"
		);
		$moonseries = array(
			"0"=>array("seriesname"=>'Unallocated',"data"=>array()),
			"4"=>array("seriesname"=>'District',"data"=>array()),
			"5"=>array("seriesname"=>'Tehsil',"data"=>array()),
			"6"=>array("seriesname"=>'Union Council',"data"=>array())
		);
		foreach($result as $row){
			
				if($distcode!=0 && $distcode != $row['code']){
					foreach($moonseries as $key=>$oneseries){
						if(isset($oneseries["data"][$i]) && $oneseries["data"][$i]>0){}else{
							$moonseries[$key]["data"][$i] = array('id'=>$distcode,'value'=>"");
						}
					}
					$i++;
				}
			$distcode = $row['code'];
			$wh_type_code=($row['wh_type_code']!="")?$row['wh_type_code']:0;
			$serieses['category'][$i]['label'] = $row['name'];
			$moonseries[$wh_type_code]["data"][$i] = array('id'=>$row['code'],'value'=>(int)(($row[$assetTypes]>0)?$row[$assetTypes]:""),'link'=>(strlen($row['code'])==3)?"JavaScript:drilldownfun({$distcode},{$assetid})":'');
			$AssetTypewisedata[$wh_type_code] += $row[$assetTypes];
		}
		$i=0;
		foreach($AssetTypewisedata as $key => $val){
			$wh_type_wise[$i] = array("label"=>$this->whTypesNames($key),"value"=>(int)$val);
			$i++;
		}
		
		array_push($dataSeries,$serieses);
		foreach($moonseries as $key => $oneseries){
			//$table[$oneseries['seriesname']] = 
			/* foreach($oneseries as $key1 => $val){ 
				//$table[$val] = 
				if($key1=="data"){
					print_r(array_values($val));exit;
				}
				
			} */
			//print_r($oneseries);exit;
			array_push($dataSeries1,$oneseries);
		}
		//print_r($table);exit;
		$data['wh_type_wise'] = json_encode($wh_type_wise);
		$data['category'] = json_encode($dataSeries);
		$data['seriesdata'] = json_encode($dataSeries1);
		return $data;
	}
	public function mapsSeriesdata()
	{
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$typeId = $this -> getCCTypeId($type);
		$result="";
		if($this->session->District || ($this -> uri -> segment(4) && strlen($this -> uri -> segment(4)) == 3))
		{
			$result="";
		}
		else
		{
			$result = $this->ccm_model->mapsData();
		}
		
		$i=0;
		$dataSeries = array();
		$serieses['name'] = "province Wise Coverage";
		$serieses['type'] = "map";
		$serieses['animation'] = true;
		foreach($result as $row){
			$serieses['data'][$i]['name'] = $row -> name;
			$serieses['data'][$i]['id'] = $row -> code;
			$serieses['data'][$i]['path'] = $row -> path;
			$serieses['data'][$i]['value'] = ($row -> sum != "" && $row -> sum > 0)?$row -> sum:0.1;
			$i++;
		}
		array_push($dataSeries,$serieses);
		$output['colorAxis'] = $this -> colorAxis('dist');
		$output['dataSeries'] = $dataSeries;
		
		echo json_encode($output,JSON_NUMERIC_CHECK);
		
	}
	public function getProvincialData($code,$status,$assetTypes)
	{
		$result = $this->ccm_model->get_cc_equipments_provincial_store($code,$status);
		$innerloopseries = array(
			"0"=>array("seriesname"=>'Unallocated',"data"=>array()),
			"2"=>array("seriesname"=>'Allocated',"data"=>array())
		);
		$dataSeries = array();
		$dataSeries1 = array();
		$code=0;
		$i=0;
		foreach($result as $row){
			
			if($code!=0 && $code != $row['code']){
				foreach($innerloopseries as $key=>$oneseries){
					if(isset($oneseries["data"][$i]) && $oneseries["data"][$i]>0){}else{
						$innerloopseries[$key]["data"][$i] = array('id'=>$code,'value'=>"");
					}
				}
				$i++;
			}
			$code = $row['code'];
			$serieses['category'][$i]['label'] = 'Provincial Store';
			$innerloopseries[$row['wh_type_code']]["data"][$i] = array('id'=>$this->whTypesNames($row['wh_type_code']),'value'=>($row[$assetTypes]>0)?$row[$assetTypes]:"");
		}
		array_push($dataSeries,$serieses);
		foreach($innerloopseries as $oneseriesVal){
			array_push($dataSeries1,$oneseriesVal);
		}
		$data['categorypro'] = json_encode($dataSeries);
		$data['seriespro'] = json_encode($dataSeries1);//print_r($data);exit;
		return $data;
	}
	public function getUriSegmentData()
	{
		if( ! $this -> input -> get('code'))
			$data['id'] = $this -> uri -> segment(4);
		$data['asset_type_id']  = ($this -> uri -> segment(5))?$this -> uri -> segment(5):'0';
		//print_r($data);exit;
		return $data;
	}
	public function getPostedData()
	{
		$data['id'] = ($this -> input -> post('id'))?$this -> input -> post('id'):$this -> session -> District;
		$data['asset_type_id'] = ($this -> input -> get('asset_type_id'))?$this -> input -> get('asset_type_id'):'0';
		$data['scroll'] = ($this->input->get('divID'))?$this->input->get('divID'):FALSE;
		return $data;
	}
	public function get_cc_wsWise_counts($type=null){////////////////////////////////
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//var_dump($distcode);exit;
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$typeId = $this -> getCCTypeId($type);
		$result = $this->ccm_model->get_cc_wsWise_counts($typeId,$distcode);
		$HTMLid=$this->gethtmlID($type);
		$DataSet= array();
		if(!empty($result)){
			foreach($result as $key =>$row){
				$lable=getWorkingstatus($row["workingstatus"],true);
				$DataSet[$key]= array(
					"label"	=> $lable,
					"value"	=> (int)$row['available'],
					"link"	=> "JavaScript:wsCountgetData({$typeId},{$row["workingstatus"]},'{$type}','{$lable}','{$HTMLid}')",
				);
			}
			echo json_encode($DataSet);exit;
		}
		echo json_encode(array('label'=>null,'value'=>null,"link"=>null));exit;
	}
	public function get_cc_storewsWise_counts($type=null){
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//var_dump($distcode);exit;
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$assetstatus = ($this -> input -> post('assetstatus'))?$this -> input -> post('assetstatus'):'1';
		$typeId = $this -> getCCTypeId($type);
		$result = $this->ccm_model->get_cc_wsWise_counts($typeId,$distcode,TRUE,$assetstatus,$type);
		$statusName = getWorkingstatus($assetstatus,true);
		$HTMLid = $this->gethtmlID($type,'district-ws');
		$i=0;
		$datasets=array();
		$AssetTypewisedata = array(
			"0"=> 0, //"Unallocated",
			"4"=> 0, //"District",
			"5"=> 0, //"Tehsil",
			"6"=> 0 //"Union Council"
		);
		foreach($result as $kyz => $row){
			$AssetTypewisedata[$row['wh_type_code']] += $row[$type];	
		}
		$link="";
		foreach($AssetTypewisedata as $key => $val){
			if($key==0){
				$color='#0075C2';
			} if($key==4){
				$color='#09B769';
			} if($key==5){
				$color='#FFCC00';
			} if($key==6){
				$color='#F45B00';
			}
			if($val == null ){
				$val=0;
			}
			//var_dump($distcode);exit;
			if($distcode !=""){
				if($key=="5" || $key=="6"){
					$link = "JavaScript:wsDrildwondistricts('{$key}','{$assetstatus}','{$typeId}','{$statusName}','{$HTMLid}')";
				}else{
					$link="";
				} 
			}else{
				$link = "JavaScript:wsDrildwondistricts('{$key}','{$assetstatus}','{$typeId}','{$statusName}','{$HTMLid}')";
			}
			//$link = "JavaScript:wsDrildwondistricts('{$key}','{$assetstatus}','{$typeId}','{$statusName}','{$HTMLid}')";
			$wh_type_wise[$i] = array(
					"label"	=> $this->whTypesNames($key),
					"value"	=> (int)$val,
					"color" => $color,
					"link"	=> $link,
					
				);
			$parameter[$i] = "{$key}-{$assetstatus}-'{$typeId}'";
			$i++;
		}
		//print_r(json_encode($wh_type_wise));exit;
		echo json_encode($wh_type_wise);exit;
	}
	public function districtsWisewsCount()
	{
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		$wh_type_code = ($this -> input -> post('typecode'))?$this -> input -> post('typecode'):'0';
		$w_status = ($this -> input -> post('w_status'))?$this -> input -> post('w_status'):'1';
		$typeId = ($this -> input -> post('typeIdws'))?$this -> input -> post('typeIdws'):'1';
		$w_statusName = getWorkingstatus($w_status,true);
		
		//print_r($typeId);exit;
		if($wh_type_code==0){
			$color='#0075C2';
		} if($wh_type_code==4){
			$color='#09B769';
		} if($wh_type_code==5){
			$color='#FFCC00';
		} if($wh_type_code==6){
			$color='#F45B00';
		}
		$result = $this->ccm_model->getdistrictWisewsData($typeId,$wh_type_code,$w_status,$distcode);
		$i=0;
		$dataSet = array();
		foreach($result as $row)
		{
			$dataSet[$i]=array("label" => $row['name'],"value" => (int)$row['count'],"color"=>$color);
			$i++;
		}
		echo json_encode($dataSet);exit;
	}
	
	///================================asset type wise counts ============================///
	public function get_cc_assetType_counts($type=null){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$typeId = $this -> getCCTypeId($type);
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//var_dump($distcode);exit;
		$result = $this->ccm_model->get_cc_assetType_counts($typeId,FALSE,'',$distcode);
		$HTMLid=$this->gethtmlID($type,'store-atw');
		$DataSet= array();
		if(!empty($result)){
			foreach($result as $key =>$row){
				$DataSet[$key]= array(
					"label"	=> $row['asset_type_name'],
					"value"	=> (int)$row['available'],
					"link"	=> "JavaScript:atwCountgetData('{$row['assetid']}','{$type}','{$row['asset_type_name']}','{$HTMLid}')",
				);
			}
			echo json_encode($DataSet);exit;
		}
		echo json_encode(array('label'=>null,'value'=>null,"link"=>null));exit;
	}
	///get data as store wise for asset types
	public function get_cc_storeatw_counts($type=null){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$asset_typeID = ($this -> input -> post('asset_typeID'))?$this -> input -> post('asset_typeID'):'13';
		$asset_typeName = ($this -> input -> post('subtypeName'))?$this -> input -> post('subtypeName'):'NULL';
		$typeId = $this -> getCCTypeId($type);//print_r($type);exit;
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		$result = $this->ccm_model->get_cc_assetType_counts($typeId,TRUE,$asset_typeID,$distcode);
		//$statusName = getWorkingstatus($assetstatus,true);
		$HTMLid=$this->gethtmlID($type,'district-atw');
		$i=0;
		$datasets=array();
		$AssetTypewisedata = array(
			"0"=> 0, //"Unallocated",
			"4"=> 0, //"District",
			"5"=> 0, //"Tehsil",
			"6"=> 0 //"Union Council"
		);
		foreach($result as $kyz => $row){
			$AssetTypewisedata[$row['wh_type_code']] += $row['count'];	
		}
		$link="";
		foreach($AssetTypewisedata as $key => $val){
			if($distcode !=""){
				if($key=="5" || $key=="6"){
					$link = "JavaScript:atwDrildwondistricts('{$key}','{$type}','{$asset_typeID}','{$asset_typeName}','{$HTMLid}')";
				}else{
					$link="";
				} 
			}else{
				$link = "JavaScript:atwDrildwondistricts('{$key}','{$type}','{$asset_typeID}','{$asset_typeName}','{$HTMLid}')";
			}
			if($key==0){
				$color='#0075C2';
			} if($key==4){
				$color='#09B769';
			} if($key==5){
				$color='#FFCC00';
			} if($key==6){
				$color='#F45B00';
			}
			$wh_type_wise[$i] = array(
					"label"	=> $this->whTypesNames($key),
					"value"	=> (int)$val,
					"color" => $color,
					"link"	=> $link
					
				);
			$parameter[$i] = "{$key}-'{$typeId}'";
			$i++;
		}
		//print_r(json_encode($wh_type_wise));exit;
		echo json_encode($wh_type_wise);exit;
	}
	///get data as Districts wise for asset types
	public function districtsATWCount()
	{
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$asset_typeID = ($this -> input -> post('subTypeid'))?$this -> input -> post('subTypeid'):'13';
		$typeId = $this -> getCCTypeId($type);
		$wh_type_code = ($this -> input -> post('wh_typecode'))?$this -> input -> post('wh_typecode'):'0';
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//print_r($typeId);exit;
		if($wh_type_code==0){
			$color='#0075C2';
		} if($wh_type_code==4){
			$color='#09B769';
		} if($wh_type_code==5){
			$color='#FFCC00';
		} if($wh_type_code==6){
			$color='#F45B00';
		}
		$result = $this->ccm_model->getdistrictATWdata($distcode,$typeId,$wh_type_code,$asset_typeID);
		$i=0;
		foreach($result as $row)
		{
			$dataSet[$i]=array("label" => $row['name'],"value" => (int)$row['count'],"color"=>$color);
			$i++;
		}
		//print_r($sum);exit;
		echo json_encode($dataSet);exit;
	}
	///================================asset year wise counts ============================///
	public function get_cc_ysWise_counts($type=null){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$typeId = $this -> getCCTypeId($type);
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//print_r($type);exit;
		$result = $this->ccm_model->get_cc_ysWise_counts($typeId,false,'',$distcode);
		$HTMLid=$this->gethtmlID($type,'store-yw');
		$DataSet= array();
		if(!empty($result)){
			foreach($result as $key =>$row){
				$DataSet[$key]= array(
					"label"	=>$row['yearsupply'],
					"value"	=>(int)$row['available'],
					"link"	=> "JavaScript:ywCountgetData('{$row['yearsupply']}','{$type}','{$HTMLid}')"
				);
			}
			echo json_encode($DataSet);exit;
		}
		echo json_encode(array('label'=>null,'value'=>null,"link"=>null));exit;
	}
	public function get_cc_storeYW_counts($type=null){
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$year = ($this -> input -> post('year'))?$this -> input -> post('year'):'';
		$typeId = $this -> getCCTypeId($type);//print_r($type);exit;
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		$result = $this->ccm_model->get_cc_ysWise_counts($typeId,TRUE,$year,$distcode);
		//$statusName = getWorkingstatus($assetstatus,true);
		$HTMLid=$this->gethtmlID($type,'district-yw');
		$i=0;
		$datasets=array();
		$AssetTypewisedata = array(
			"0"=> 0, //"Unallocated",
			"4"=> 0, //"District",
			"5"=> 0, //"Tehsil",
			"6"=> 0 //"Union Council"
		);
		foreach($result as $kyz => $row){
			$AssetTypewisedata[$row['wh_type_code']] += $row['count'];	
		}
		$link="";
		foreach($AssetTypewisedata as $key => $val){
			if($distcode !=""){
				if($key=="5" || $key=="6"){
					$link = "JavaScript:ywDrildwondistricts('{$key}','{$type}','{$year}','{$HTMLid}')";
				}else{
					$link="";
				} 
			}else{
				$link = "JavaScript:ywDrildwondistricts('{$key}','{$type}','{$year}','{$HTMLid}')";
			}
			if($key==0){
				$color='#0075C2';
			} if($key==4){
				$color='#09B769';
			} if($key==5){
				$color='#FFCC00';
			} if($key==6){
				$color='#F45B00';
			}
			$wh_type_wise[$i] = array(
				"label"	=> $this->whTypesNames($key),
				"value"	=> (int)$val,
				"color" => $color,
				"link"	=> $link
				
			);
			$parameter[$i] = "{$key}-'{$typeId}'";
			$i++;
		}
		//print_r(json_encode($wh_type_wise));exit; 
		echo json_encode($wh_type_wise);exit;
	}
	public function districtsywCount()
	{
		$type = ($this -> input -> post('type'))?$this -> input -> post('type'):'refrigerator';
		$year = ($this -> input -> post('year'))?$this -> input -> post('year'):'';
		$typeId = $this -> getCCTypeId($type);
		$wh_type_code = ($this -> input -> post('wh_typecode'))?$this -> input -> post('wh_typecode'):'0';
		if($this->session->District){
			$distcode = $this->session->District;
		}
		else{
			$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):null;
		}
		//print_r($typeId);exit;
		if($wh_type_code==0){
			$color='#0075C2';
		} if($wh_type_code==4){
			$color='#09B769';
		} if($wh_type_code==5){
			$color='#FFCC00';
		} if($wh_type_code==6){
			$color='#F45B00';
		}
		$result = $this->ccm_model->getdistrictYWdata($distcode,$typeId,$wh_type_code,$year);
		$i=0;
		foreach($result as $row)
		{
			$dataSet[$i]=array("label" => $row['name'],"value" => (int)$row['count'],"color"=>$color);
			$i++;
		}
		//print_r($sum);exit;
		echo json_encode($dataSet);exit;
	}
	public function whTypesNames($key)
	{
		switch($key){
			case "0":
				return "Unallocated";
				break;
			case "2":
				return "Provincial";
				break;
			case "4":
				return "District";
				break;
			case "5":
				return "Tehsil";
				break;
			case "6":
				return "Union Council";
				break;
		}
	}
	public function getCCTypeId($type){
		switch($type){
			case "refrigerator":
				return "1";
				break;
			case "coldroom":
				return "21";
				break;
			case "voltageregulator":
				return "23";
				break;
			case "generator":
				return "24";
				break;
			case "transport":
				return "25";
				break;
			case "vaccinecarrier":
				return "26";
				break;
			case "icepack":
				return "27";
				break;
			case "coldbox":
				return "33";
				break;
			default:
				return "1";
				break;
		}
	}
	public function gethtmlID($type,$level='store-ws'){
		switch($type){
			case "refrigerator":
				return "{$level}-refg-trend"; //ws
				break;
			case "coldroom":
				return "{$level}-cr-trend";
				break;
			case "voltageregulator":
				return "{$level}-vr-trend";
				break;
			case "generator":
				return "{$level}-genn-trend";
				break;
			case "transport":
				return "{$level}-transp-trend";
				break;
			case "vaccinecarrier":
				return "{$level}-vc-trend";
				break;
			case "icepack":
				return "{$level}-icep-trend";
				break;
			case "coldbox":
				return "{$level}-cb-trend";
				break;
			default:
				return "{$level}-refg-trend";
				break;
		}
	}
	public function colorAxis($map='dist'){
		if($this -> input -> post('ajax') && $this -> input -> post('ajax')==true){
			$dataClasses['min'] = 1;
			$dataClasses['minColor'] = '#DD1E2F';
			$dataClasses['maxColor'] = '#0B7546';
			$dataClasses['max'] = ($map=='dist')?10000:1000;
			$dataClasses['type'] = 'logarithmic';
		}else{
			$dataClasses['dataClasses'][0]['from'] = '95';
			$dataClasses['dataClasses'][0]['to'] = '1000';
			$dataClasses['dataClasses'][0]['color'] = '#50eb35 ';
			$dataClasses['dataClasses'][0]['name'] = '>=95%';

			$dataClasses['dataClasses'][1]['from'] = '90';
			$dataClasses['dataClasses'][1]['to'] = '94.99';
			$dataClasses['dataClasses'][1]['color'] = '#3366ff';
			$dataClasses['dataClasses'][1]['name'] = '90-94%';

			$dataClasses['dataClasses'][2]['from'] = '80';
			$dataClasses['dataClasses'][2]['to'] = '89.99';
			$dataClasses['dataClasses'][2]['color'] = '#FFFF00';
			$dataClasses['dataClasses'][2]['name'] = '80-89%';

			$dataClasses['dataClasses'][3]['from'] = '50';
			$dataClasses['dataClasses'][3]['to'] = '79.99';
			$dataClasses['dataClasses'][3]['color'] = '#FF8C00';
			$dataClasses['dataClasses'][3]['name'] = '50-79%';
			
			$dataClasses['dataClasses'][4]["from"] = '0';
			$dataClasses['dataClasses'][4]["to"] = '49.99';
			$dataClasses['dataClasses'][4]["color"] = '#e3330d';
			$dataClasses['dataClasses'][4]["name"] = '< 50%';
		}
		$data['colorAxis'] = json_encode($dataClasses, JSON_NUMERIC_CHECK);
		return $data['colorAxis'];
	}
}

 ?>