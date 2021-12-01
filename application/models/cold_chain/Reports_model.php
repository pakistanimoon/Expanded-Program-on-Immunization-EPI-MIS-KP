<?php
class Reports_model extends CI_Model {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	public function asset_availability($data){
		//print_r($data['tcode']); exit;
		  if($this->session->Tehsil){
			$wc[] = " ccm.tcode ='".$this->session->Tehsil ."' ";
		}     
        $join ='';		
		if(isset($data['distcode']) > 0){
			$wc[] = " storecode::text like '".$data['distcode']."%' ";
		} 
		 if(isset($data['tcode']) > 0){
			if(isset($data['store_level']) && $data['store_level']==5){
				$wc[] = " storecode::text like '".$data['tcode']."' ";
			}else{
			$join = 'JOIN facilities fac ON fac.facode = ccm.storecode::text';
			$wc[] = " fac.tcode = '".$data['tcode']."' ";
			}
		} 
		if(isset($data['year']) > 0){
		    $wc[] = "to_char(ccm.working_since,'YYYY') like '".$data['year']."%' ";
		}
		if(isset($data['store_level']) > 0){
		   if($data['store_level']=="unallocated"){
			$data['store_level']='0';
		   }
	        $wc[] = " ccm.warehouse_type_id = '".$data['store_level']."' ";	
		}
		if(isset($data['working_status']) > 0){
		    $wc[] = "ccm.status = '".$data['working_status']."' ";
		}
		if(isset($data['asset_type'])){
		   if($data['asset_type']== 1 || $data['asset_type'] == 21 || $data['asset_type'] == 25){
			$wc[]="types.parent_id='".$data['asset_type']."'";
		   }
		   else{
			$wc[]="ccm.ccm_sub_asset_type_id='".$data['asset_type']."'";
		   }
		}
		//print_r($wc); exit;
		$query="select districtname(ccm.distcode) as district,tehsilname(ccm.tcode) as tehsil,unname(ccm.uncode) as ucname,facilityname(ccm.facode) as facname,tehsilname(ccm.storecode :: text) as tehsilstroename,districtname(ccm.storecode :: text) as districtstroename,ccm.distcode,warehousetypename(ccm.warehouse_type_id) as warehouse_type_id,ccm.storecode,
		       (select count(ccm.asset_id) as TotalAsset) as b,get_store_name(ccm.warehouse_type_id,CAST(storecode AS VARCHAR(9))) as storename
		       FROM epi_cc_coldchain_main ccm JOIN epi_cc_asset_types types ON types.pk_id = ccm.ccm_sub_asset_type_id 
               {$join}
			   ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
			   GROUP BY ccm.distcode,ccm.tcode,ccm.uncode,ccm.facode,ccm.warehouse_type_id,ccm.storecode 
			   ORDER BY ccm.distcode,ccm.tcode,ccm.uncode,ccm.facode,ccm.warehouse_type_id,ccm.storecode";
			//echo $query; exit;
		$result = $this -> db -> query($query);
		$data['Assetresult'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		$subTitle = "Asset(s) Availability Report";
		if(isset($data['asset_type'])){
			$data['asset_type']=$data['asset_type'];
		}
		if(isset($data['store_level'])){
			$data['store_level']=$data['store_level'];
		}
		if(isset($data['working_status'])){
			$data['working_status']=$data['working_status'];
		}
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//print_r($data); exit;
		$total = 'sum(CAST ("b" AS INTEGER)) as totalvalue';
		$queryTotal =' Select '.$total.'  FROM ('.$query.') as a';
		$result = $this -> db -> query($queryTotal);
		$data['result'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit; 
		$data['subtitle'] = $subTitle;
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		$data['exportIcons'] = exportIcons($_REQUEST);
		return $data; 
		
	}
	public function asset_availability_report($data){
		//print_r($data['tcode']); exit;
		$wd="";
		if($this->session->Province){
			if(isset($data['distcode'])){
				$wd = " procode ='".$this->session->Province ."' AND distcode='".$data['distcode']."'";
			}else{
				$wd = " procode ='".$this->session->Province ."' ";
			}
		} 
		if($this->session->District){
			$wd= " distcode ='".$this->session->District ."' ";
		} 
		if($this->session->Tehsil){
			$wc[] = " ccm.tcode ='".$this->session->Tehsil ."' ";
			$wd = " tcode ='".$this->session->Tehsil ."' ";
		}     		
		if(isset($data['distcode']) > 0){
			$wc[] = " storecode::text like '".$data['distcode']."%' ";
		} 
		if(isset($data['tcode']) > 0){
			if(isset($data['store_level']) && $data['store_level']==5){
				$wc[] = " storecode::text like '".$data['tcode']."' ";
			}else{
			$wc[] = " tcode = '".$data['tcode']."' ";
			}
		} 
		/* if(isset($data['year']) > 0){
		    $wc[] = "to_char(ccm.working_since,'YYYY') like '".$data['year']."%' ";
		} */
		if(isset($data['store_level']) > 0){
		   if($data['store_level']=="unallocated"){
			$data['store_level']='0';
		   }
	        $wc[] = " ccm.warehouse_type_id = '".$data['store_level']."' ";	
		}
		if(isset($data['working_status']) > 0){
		    $wc[] = "ccm.status = '".$data['working_status']."' ";
		}
		if(isset($data['asset_type'])){
		   if($data['asset_type']== 1 || $data['asset_type'] == 21 || $data['asset_type'] == 25){
			$wc[]="types.parent_id='".$data['asset_type']."'";
		   }
		   else{
			$wc[]="ccm.ccm_sub_asset_type_id='".$data['asset_type']."'";
		   }
		}
		//print_r($wc); exit;
			 if(isset($data['asset_type']) && $data['store_level']=='2'){ 
				$query="select procode,province,(select count(*)as assets  from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  and ccm.asset_status ='Active' and procode=provinces.procode)
				from provinces
				where ".$wd."";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['provincialAssetresult'] = $result -> result_array();
			 }else if($data['store_level']=='2'){
				 //echo 'a'; exit;
				$query="select procode,province,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and procode=provinces.procode) 
				from provinces where ".$wd."";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['AllprovincialAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;	
			 }
			 if(isset($data['asset_type']) && $data['store_level']=='4'){ 
				//echo '4'; exit;
				$query="select distcode,district,(select count(*) as assets from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and ccm.asset_status ='Active' and distcode=districts.distcode) 
				from districts
				where ".$wd."
			    order by district";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['districtAssetresult'] = $result -> result_array();
			 }else if($data['store_level']=='4'){
				//echo 'a'; exit;
				$query="select distcode,district,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and distcode=districts.distcode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and distcode=districts.distcode) 
				from districts where ".$wd." order by district";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['AlldistrictAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;	
			 }
			 if(isset($data['asset_type']) && $data['store_level']=='5'){ 
				//echo '5'; exit();
				$query="select tcode,tehsil,(select count(*) as assets from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and ccm.asset_status ='Active' and tcode=tehsil.tcode) 
				from tehsil
				where ".$wd."
			    order by tehsil";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['tehsilAssetresult'] = $result -> result_array();
			 }else if($data['store_level']=='5'){
				//echo 'a'; exit;
				$query="select tcode,tehsil,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and tcode=tehsil.tcode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and tcode=tehsil.tcode) 
				from tehsil where ".$wd." order by tehsil";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['AlltehsilAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;	
			 }
			 if(isset($data['asset_type']) && $data['store_level']=='6'){ 
			    $query="select uncode,unname(uncode),facode,fac_name,(select count(*) as assets from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and ccm.asset_status ='Active' and facode=facilities.facode) 
				from facilities
				where ".$wd."  and hf_type='e'
			    order by unname,fac_name";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['unionAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;	
			 }else if($data['store_level']=='6'){
				$query="select uncode,unname(uncode),facode,fac_name,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and facode=facilities.facode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and facode=facilities.facode) 
				from facilities where ".$wd." and hf_type='e' order by unname,fac_name";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['AllunionAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;	
			 }
			 if(isset($data['asset_type']) && $data['store_level']=='0'){ 
			    $query=" select ccm.storecode,get_store_name(ccm.warehouse_type_id,CAST(storecode AS VARCHAR(9))) as storename,
				count(*)as assets  from epi_cc_coldchain_main ccm
				join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id 
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and ccm.asset_status ='Active'
				Group by ccm.storecode,ccm.warehouse_type_id
				ORDER BY ccm.warehouse_type_id,ccm.storecode";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['unallocatedAssetresult'] = $result -> result_array();
			 }else if(isset($data['distcode']) && $data['store_level']=='0'){ //echo 'a'; exit();
				$query="select procode,distcode,district,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and procode=districts.procode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and procode=districts.procode) 
				from districts where ".$wd."";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['AllunallocatedAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit;
			 }else if($data['store_level']=='0'){
				$query="select procode,province,(select count(*) as refrigerator 
				from epi_cc_coldchain_main ccm join epi_cc_asset_types types on types.pk_id=ccm.ccm_sub_asset_type_id
				".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."  AND types.parent_id='1' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as coldroom from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='21' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as voltageregulator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='23' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as generator from epi_cc_coldchain_main ccm join epi_cc_asset_types
				types on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='24' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as transport from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND types.parent_id='25' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as vaccinecarriers from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='26' and ccm.asset_status ='Active' and procode=provinces.procode),
				(select count(*) as coldbox from epi_cc_coldchain_main ccm join epi_cc_asset_types types
				on types.pk_id=ccm.ccm_sub_asset_type_id ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )."
				AND ccm.ccm_sub_asset_type_id='33' and ccm.asset_status ='Active' and procode=provinces.procode) 
				from provinces where ".$wd."";
				//echo $query; exit;
				$result = $this -> db -> query($query);
				$data['emptunallocatedAssetresult'] = $result -> result_array();
				//$str = $this->db->last_query();
				//print_r($str); exit; 
			 }	
		$subTitle = "Asset(s) Availability Report";
		if(isset($data['asset_type'])){
			$data['asset_type']=$data['asset_type'];
		}
		if(isset($data['store_level'])){
			$data['store_level']=$data['store_level'];
		}
		if(isset($data['working_status'])){
			$data['working_status']=$data['working_status'];
		}
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//print_r($data); exit;
		//$total = 'sum(CAST ("b" AS INTEGER)) as totalvalue';
		//$queryTotal =' Select '.$total.'  FROM ('.$query.') as a';
		//$result = $this -> db -> query($queryTotal);
		//$data['result'] = $result -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit; 
		$data['subtitle'] = $subTitle;
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		$data['exportIcons'] = exportIcons($_REQUEST);
		return $data; 
	}
	public function asset_availability_report_view($data){
		//echo 'aa'; exit();
		$wd="";
		if($this->session->Province){
			if(isset($data['distcode'])){
				$wd = " procode ='".$this->session->Province ."' AND distcode='".$data['code']."'";
			}else{
				$wd = " procode ='".$this->session->Province ."' ";
			}
		} 
		if($this->session->District){
			$wd= " distcode ='".$this->session->District ."' ";
		} 
		if($this->session->Tehsil){
			$wc[] = " ccm.tcode ='".$this->session->Tehsil ."' ";
			$wd = " tcode ='".$this->session->Tehsil ."' ";
		}     		
		if(isset($data['code']) > 0){
			if($data['store_level']==5 || $data['store_level']==6){
				$wc[] = " storecode = '".$data['code']."' ";
			}else{
				$wc[] = " storecode::text like '".$data['code']."%' ";
			}
		} 
		/* if(isset($data['tcode']) > 0){
			if(isset($data['store_level']) && $data['store_level']==5){
				$wc[] = " storecode::text like '".$data['tcode']."' ";
			}else{
			$wc[] = " tcode = '".$data['tcode']."' ";
			}
		}  */
		/* if(isset($data['year']) > 0){
		    $wc[] = "to_char(ccm.working_since,'YYYY') like '".$data['year']."%' ";
		} */
		if(isset($data['store_level']) > 0){
		   if($data['store_level']=="unallocated"){
			$data['store_level']='0';
		   }
	        $wc[] = " ccm.warehouse_type_id = '".$data['store_level']."' ";	
		}
		if(isset($data['working_status']) > 0){
		    $wc[] = "ccm.status = '".$data['working_status']."' ";
		}
		if(isset($data['asset_type']) && $data['asset_type']){
		   if($data['asset_type']== 1 || $data['asset_type'] == 21 || $data['asset_type'] == 25){
			$wc[]="types.parent_id='".$data['asset_type']."'";
		   }
		   else{
			$wc[]="ccm.ccm_sub_asset_type_id='".$data['asset_type']."'";
		   }
		}
		 //print_r($wc); exit;
		 $query=" SELECT asset_id as id,warehousetypename(ccm.warehouse_type_id) as stroe_level,
		 ccm.storecode,ccm.ccm_user_asset_id, get_store_name(ccm.warehouse_type_id,
		 CAST(storecode AS VARCHAR(9))) as storename,ccm.source_id,ccm.warehouse_type_id,
		 ccm.procode,ccm.distcode,districtname(ccm.distcode) as district, ccm.tcode, ccm.facode, 
		 tehsilname(ccm.tcode),facilityname(ccm.facode), makername(md.ccm_make_id) as make_name,
		 md.model_name, ccm.quantity,ccm.status as status, ccm.created_date::date, 
		 md.gross_capacity_20 as capacity,ccm.short_name,types.asset_type_name FROM epi_cc_coldchain_main ccm 
		 JOIN epi_cc_models md ON md.pk_id = ccm.ccm_model_id LEFT JOIN epi_cc_asset_status_history history
		 ON history.pk_id = ccm.ccm_status_history_id JOIN epi_cc_asset_types types ON 
		 types.pk_id = ccm.ccm_sub_asset_type_id 
		 ".((!empty($wc)) ? ' where ' . implode(' AND ', $wc) : '' )." and ccm.asset_status ='Active' 
		 order by warehouse_type_id desc";
		 //echo $query; exit;
		 $result = $this -> db -> query($query);
		 $data['Assetresults'] = $result -> result_array();
		 $subTitle = "Asset(s) Availability Report";
		 if(isset($data['asset_type'])){
			 if($data['asset_type']==0){
				unset($data['asset_type']);
			 }else{
				$data['asset_type']=$data['asset_type'];
			 }
		 }
		 if(isset($data['store_level'])){
			$data['store_level']=$data['store_level'];
		 }
		 if(isset($data['working_status'])){
			$data['working_status']=$data['working_status'];
		 }
		 if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['subtitle'] = $subTitle;
		//print_r($data); exit();
		$data['TopInfo'] = reportsTopInfo($subTitle, $data);
		$data['exportIcons'] = exportIcons($_REQUEST);
		return $data;
	}
	public function allassets_Views($recordID)///for refrigerator and vaccine carrie
	{
		$this->db->select("ccm.ccm_model_id,ccm_user_asset_id as asset_id,source_id,ccm.short_name,ccm.quantity,ccm.status,catalogue_id,makername(md.ccm_make_id) as make_name,md.model_name,assetname(md.ccm_sub_asset_type_id),md.asset_type_id,cfc_free,asset_dimension_length as length,asset_dimension_width as width,asset_dimension_height as height,gross_capacity_20,gross_capacity_4,net_capacity_20,net_capacity_4,serial_no,ccm.working_since::date ,warehouse_type_id,ccm.procode,distcode,tcode,facode,uncode,storecode",FALSE);
		$this->db->from("epi_cc_coldchain_main ccm");
		$this->db->join("epi_cc_models md","md.pk_id = ccm.ccm_model_id");
		$this->db->where($recordID);	
		return $this->db->get()->row_array(); //echo $this->db->last_query();
	}
}
?>	