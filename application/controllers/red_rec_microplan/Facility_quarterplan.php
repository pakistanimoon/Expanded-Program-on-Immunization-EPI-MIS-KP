<?php
	class Facility_quarterplan extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Facility_quarterplan_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
		}
		public function hf_quarterplan_list(){
			$data['data'] = $this-> Facility_quarterplan_model-> hf_quarterplan_list();
		   $data['fileToLoad'] = 'Add_red_microplanning/hf_quarterplan_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function hf_quarterplan_add(){
			$data['data'] =	"";
			$data['fileToLoad'] = 'Add_red_microplanning/hf_quarterplan_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function hf_quarterplan_save(){
			//print_r($_POST);exit;
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
			    //post value for edit_array 1 
				$procode =$this -> session -> Province;
				$distcode = $this -> session -> District;
				$tcode = $this-> input-> post('tcode');			   
				$uncode = $this-> input-> post('uncode');
				$facode = $this-> input-> post('facode');
				$year = $this-> input-> post('year');
				$quarter = $this-> input-> post('quarter');			   
				$techniciancode = $this-> input-> post('techniciancode');					
				$recid = $this-> input-> post('recid');			   
				$submitted_date = $this-> input-> post('submitted_date');
				$updated_date = $this-> input-> post('updated_date');
				$numarea = $this-> input-> post('numarea');
			    for($k=1; $k<=3; $k++){
						${'ahtr_activities_m'.$k} = $this-> input-> post('ahtr_activities_m'.$k);
						${'ahtr_resperson_m'.$k} = $this-> input-> post('ahtr_resperson_m'.$k);
						${'ra_activities_m'.$k} = $this-> input-> post('ra_activities_m'.$k);
						${'ra_resperson_m'.$k} = $this-> input-> post('ra_resperson_m'.$k);
						//${'msi_numheld_m'.$k} = $this-> input-> post('msi_numheld_m'.$k);
						//${'msi_numplan_m'.$k} = $this-> input-> post('msi_numplan_m'.$k); 
						${'sh_Fixed_m'.$k} = $this-> input-> post('sh_Fixed_m'.$k);
						${'sh_Outreach_m'.$k} = $this-> input-> post('sh_Outreach_m'.$k);
						${'sh_Mobile_m'.$k} = $this-> input-> post('sh_Mobile_m'.$k);
						${'sp_Fixed_m'.$k} = $this-> input-> post('sp_Fixed_m'.$k);
						${'sp_Outreach_m'.$k} = $this-> input-> post('sp_Outreach_m'.$k);
						${'sp_Mobile_m'.$k} = $this-> input-> post('sp_Mobile_m'.$k);
			   	}
				//post value for edit_array 2
			    //$area_name = $this-> input-> post('area_name');	   	
				$area_num_sessions = $this-> input-> post('area_num_sessions');
				$area_code = $this-> input-> post('area_code');	 
				$session_type_nm = $this-> input-> post('session_type_nm');
				$area_transport_m1 = $this-> input-> post('area_transport_m1');
				$area_resperson_m1 = $this-> input-> post('area_resperson_m1');
				$area_distsupport_m1 = $this-> input-> post('area_distsupport_m1');
				$area_transport_m2= $this-> input-> post('area_transport_m2');
				$area_resperson_m2= $this-> input-> post('area_resperson_m2');
				$area_distsupport_m2 = $this-> input-> post('area_distsupport_m2');
				$area_transport_m3 = $this-> input-> post('area_transport_m3');
				$area_resperson_m3 = $this-> input-> post('area_resperson_m3');
				$area_distsupport_m3 = $this-> input-> post('area_distsupport_m3');
			    //post value for edit_array 3
				$sitename_s = $this-> input-> post('sitecode_s');
				$sitename_h = $this-> input-> post('sitecode_h');
				$area_dateschedule_m1 = $this-> input-> post('area_dateschedule_m1');
				$area_dateheld_m1 = $this-> input-> post('area_dateheld_m1');
				$area_dateschedule_m2 = $this-> input-> post('area_dateschedule_m2');
				$area_dateheld_m2  = $this-> input-> post('area_dateheld_m2');
				$area_dateschedule_m3= $this-> input-> post('area_dateschedule_m3');
				$area_dateheld_m3  = $this-> input-> post('area_dateheld_m3');
                $session_type = $this-> input-> post('session_type');				
                $area_code_dt = $this-> input-> post('area_code_dt');				
	            //delete_record_multiple_colum from 3 table 
				$this-> Common_model-> delete_record_multiple_colum('hf_quarterplan_db',array('facode'=>$facode,'year'=>$year,'quarter'=>$quarter,'pk_id'=>$recid));
				$this-> Common_model-> delete_record_multiple_colum('hf_quarterplan_nm_db',array('ms_id'=>$recid));
				$this-> Common_model-> delete_record_multiple_colum('hf_quarterplan_dates_db',array('ms_id'=>$recid));
				//creat edit_array1 and insert_record
				$edit_array1=array(
					/* 'distcode' => $distcode,
					'tcode' => $tcode,		   
				   'uncode' => $uncode,
				   'facode' => $facode,
				   'year' => $year,
				   'quarter' => $quarter,
				   'submitted_date' => $submitted_date,
				   'updated_date' => $updated_date */
				   ////////////////////////////
				   'procode' => $procode,
					'distcode' => $distcode,
					'tcode' => $tcode,		   
					'uncode' => $uncode,
					'facode' => $facode,
					'techniciancode' => $techniciancode,
					'year' => $year,
					'quarter' => $quarter,
					'submitted_date' => $submitted_date,
					'updated_date' => $updated_date 
				
				);
				for($k=1; $k<=3; $k++){	
					$edit_array1['ahtr_activities_m'.$k] = (isset(${'ahtr_activities_m'.$k}) AND ${'ahtr_activities_m'.$k} != '')?${'ahtr_activities_m'.$k}:NULL;
					$edit_array1['ahtr_resperson_m'.$k] = (isset(${'ahtr_resperson_m'.$k}) AND ${'ahtr_resperson_m'.$k} != '')?${'ahtr_resperson_m'.$k}:NULL;
					$edit_array1['ra_activities_m'.$k] = (isset(${'ra_activities_m'.$k}) AND ${'ra_activities_m'.$k} != '')?${'ra_activities_m'.$k}:NULL;
					$edit_array1['ra_resperson_m'.$k] = (isset(${'ra_resperson_m'.$k}) AND ${'ra_resperson_m'.$k} != '')?${'ra_resperson_m'.$k}:NULL;
					//$edit_array1['msi_numheld_m'.$k] = (isset(${'msi_numheld_m'.$k}) AND ${'msi_numheld_m'.$k} > 0)?${'msi_numheld_m'.$k}:0;
					//$edit_array1['msi_numplan_m'.$k] = (isset(${'msi_numplan_m'.$k}) AND ${'msi_numplan_m'.$k} > 0)?${'msi_numplan_m'.$k}:0;
					$edit_array1['sh_fixed_m'.$k] = (isset(${'sh_Fixed_m'.$k}) AND ${'sh_Fixed_m'.$k} > 0)?${'sh_Fixed_m'.$k}:0;
					$edit_array1['sh_outreach_m'.$k] = (isset(${'sh_Outreach_m'.$k}) AND ${'sh_Outreach_m'.$k} > 0)?${'sh_Outreach_m'.$k}:0;
					$edit_array1['sh_mobile_m'.$k] = (isset(${'sh_Mobile_m'.$k}) AND ${'sh_Mobile_m'.$k} > 0)?${'sh_Mobile_m'.$k}:0;					
					$edit_array1['sp_fixed_m'.$k] = (isset(${'sp_Fixed_m'.$k}) AND ${'sp_Fixed_m'.$k} > 0)?${'sp_Fixed_m'.$k}:0;
					$edit_array1['sp_outreach_m'.$k] = (isset(${'sp_Outreach_m'.$k}) AND ${'sp_Outreach_m'.$k} > 0)?${'sp_Outreach_m'.$k}:0;
					$edit_array1['sp_mobile_m'.$k] = (isset(${'sp_Mobile_m'.$k}) AND ${'sp_Mobile_m'.$k} > 0)?${'sp_Mobile_m'.$k}:0;
			}//print_r($edit_array1);
				$id =$this-> Common_model-> insert_record('hf_quarterplan_db',$edit_array1);
				//creat edit_array2 and insert on single loop itreation insert edit_array3 			   
				foreach($this->input->post('area_code') as $key=>$val){
						$edit_array2=array(
						   'ms_id'=> $id,
						    'procode' => $procode,
							'distcode' => $distcode,
							'tcode' => $tcode,		   
							'uncode' => $uncode,
							'facode' => $facode,
							'techniciancode' => $techniciancode,
							'year' => $year,
							'quarter' => $quarter,
							//'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
							'area_code' => (isset($area_code[$key]) AND $area_code[$key] != '')?$area_code[$key]:NULL,
							'area_num_sessions' => (isset($area_num_sessions[$key]) AND $area_num_sessions[$key] > 0)?$area_num_sessions[$key]:0,
							'session_type' => (isset($session_type_nm[$key]) AND $session_type_nm[$key] != '')?$session_type_nm[$key]:NULL,
							'area_transport_m1' => (isset($area_transport_m1[$key]) AND $area_transport_m1[$key] != '')?$area_transport_m1[$key]:NULL,
							'area_resperson_m1' => (isset($area_resperson_m1[$key]) AND $area_resperson_m1[$key] != '')?$area_resperson_m1[$key]:NULL,
							'area_distsupport_m1' => (isset($area_distsupport_m1[$key]) AND $area_distsupport_m1[$key] != '')?$area_distsupport_m1[$key]:NULL,
							'area_transport_m2' => (isset($area_transport_m2[$key]) AND $area_transport_m2[$key] != '')?$area_transport_m2[$key]:NULL,
							'area_resperson_m2' => (isset($area_resperson_m2[$key]) AND $area_resperson_m2[$key] != '')?$area_resperson_m2[$key]:NULL,
							'area_distsupport_m2' => (isset($area_distsupport_m2[$key]) AND $area_distsupport_m2[$key] != '')?$area_distsupport_m2[$key]:NULL,
							'area_transport_m3' => (isset($area_transport_m3[$key]) AND $area_transport_m3[$key] != '')?$area_transport_m3[$key]:NULL,
							'area_resperson_m3' => (isset($area_resperson_m3[$key]) AND $area_resperson_m3[$key] != '')?$area_resperson_m3[$key]:NULL,
							'area_distsupport_m3' => (isset($area_distsupport_m3[$key]) AND $area_distsupport_m3[$key] != '')?$area_distsupport_m3[$key]:NULL,
						);
						//print_r($edit_array2);
						$link_id =  $this-> Common_model-> insert_record('hf_quarterplan_nm_db',$edit_array2);
						if($link_id > 0){
							foreach($this->input->post('area_dateschedule_m1')[$key] as $key3=>$val3){
								//creat edit_array2 and insert 
								$edit_array3=array(
									/* 'ms_id'=> $id,
									'link_id'=> $link_id[$key], */
									'ms_id'=> $id,
									'link_id'=> $link_id,
									'procode' => $procode,
									'distcode' => $distcode,
									'tcode' => $tcode,		   
									'uncode' => $uncode,
									'facode' => $facode,
									'techniciancode' => $techniciancode,
									'year' => $year,
									'quarter' => $quarter,
									'sitename_s' => (isset($sitename_s[$key][$key3]) AND $sitename_s[$key][$key3] != '')?$sitename_s[$key][$key3]:NULL,
									'sitename_h' => (isset($sitename_h[$key][$key3]) AND $sitename_h[$key][$key3] != '')?$sitename_h[$key][$key3]:NULL,
									'session_type' => (isset($session_type[$key][$key3]) AND $session_type[$key][$key3] != '')?$session_type[$key][$key3]:NULL,
									'area_code' => (isset($area_code_dt[$key][$key3]) AND $area_code_dt[$key][$key3] != '')?$area_code_dt[$key][$key3]:NULL,
									'area_dateschedule_m1' => (isset($area_dateschedule_m1[$key][$key3]) AND $area_dateschedule_m1[$key][$key3] != '')?$area_dateschedule_m1[$key][$key3]:NULL,
									'area_dateschedule_m2' => (isset($area_dateschedule_m2[$key][$key3]) AND $area_dateschedule_m2[$key][$key3] > 0)?$area_dateschedule_m2[$key][$key3]:NULL,
									'area_dateschedule_m3' => (isset($area_dateschedule_m3[$key][$key3]) AND $area_dateschedule_m3[$key][$key3] > 0)?$area_dateschedule_m3[$key][$key3]:NULL,
									'area_dateheld_m1' => (isset($area_dateheld_m1[$key][$key3]) AND $area_dateheld_m1[$key][$key3] > 0)?$area_dateheld_m1[$key][$key3]:NULL,
									'area_dateheld_m2' => (isset($area_dateheld_m2[$key][$key3]) AND $area_dateheld_m2[$key][$key3] != '')?$area_dateheld_m2[$key][$key3]:NULL,
									'area_dateheld_m3' => (isset($area_dateheld_m3[$key][$key3]) AND $area_dateheld_m3[$key][$key3] > 0)?$area_dateheld_m3[$key][$key3]:NULL,
								);
								$this-> Common_model-> insert_record('hf_quarterplan_dates_db',$edit_array3);
							}
						}//print_r($edit_array3);
				}//exit;
					$this-> session-> set_flashdata('message','You have successfully updated your record!'); 
					$location = base_url()."red_rec_microplan/Facility_quarterplan/hf_quarterplan_list";
					redirect($location);
			}
			else{
				////check data exist////

				$techniciancode = $this-> input-> post('techniciancode');
				$year = $this-> input-> post('year');
				$quarter = $this-> input-> post('quarter');	
				$recordexist="select  EXISTS(select * from hf_quarterplan_db where techniciancode='$techniciancode' and year='$year' and quarter='$quarter')";
				$result = $this-> db-> query($recordexist);	
				$exist =	$result-> result_array();
				if($exist[0]['exists'] == 't'){
					
					$location = base_url()."red_rec_microplan/Facility_quarterplan/hf_quarterplan_add";
					redirect($location);
				}else{
					//post value for add_array 1 
					$procode = $this -> session -> Province;
					$distcode = $this -> session -> District;
					$tcode = $this-> input-> post('tcode');			   
					$uncode = $this-> input-> post('uncode');
					$facode = $this-> input-> post('facode');
					$techniciancode = $this-> input-> post('techniciancode');
					$year = $this-> input-> post('year');
					$quarter = $this-> input-> post('quarter');			   
					$submitted_date = $this-> input-> post('submitted_date');
					$numarea = $this-> input-> post('numarea');	   
					for($k=1; $k<=3; $k++){
							${'ahtr_activities_m'.$k} = $this-> input-> post('ahtr_activities_m'.$k);
							${'ahtr_resperson_m'.$k} = $this-> input-> post('ahtr_resperson_m'.$k);
							${'ra_activities_m'.$k} = $this-> input-> post('ra_activities_m'.$k);
							${'ra_resperson_m'.$k} = $this-> input-> post('ra_resperson_m'.$k);
							${'sh_Fixed_m'.$k} = $this-> input-> post('sh_Fixed_m'.$k);
							${'sh_Outreach_m'.$k} = $this-> input-> post('sh_Outreach_m'.$k);
							${'sh_Mobile_m'.$k} = $this-> input-> post('sh_Mobile_m'.$k);
							${'sp_Fixed_m'.$k} = $this-> input-> post('sp_Fixed_m'.$k);
							${'sp_Outreach_m'.$k} = $this-> input-> post('sp_Outreach_m'.$k);
							${'sp_Mobile_m'.$k} = $this-> input-> post('sp_Mobile_m'.$k);
					}
					//post value for add_array 2
					// $area_name = $this-> input-> post('area_name');	   	
					$area_code = $this-> input-> post('area_code');	   	
					$area_num_sessions = $this-> input-> post('area_num_sessions');
					$session_type_nm = $this-> input-> post('session_type_nm');
					$area_transport_m1 = $this-> input-> post('area_transport_m1');
					$area_resperson_m1 = $this-> input-> post('area_resperson_m1');
					$area_distsupport_m1 = $this-> input-> post('area_distsupport_m1');
					$area_transport_m2= $this-> input-> post('area_transport_m2');
					$area_resperson_m2= $this-> input-> post('area_resperson_m2');
					$area_distsupport_m2 = $this-> input-> post('area_distsupport_m2');
					$area_transport_m3 = $this-> input-> post('area_transport_m3');
					$area_resperson_m3 = $this-> input-> post('area_resperson_m3');
					$area_distsupport_m3 = $this-> input-> post('area_distsupport_m3');  
					$sitename_s = $this-> input-> post('sitecode_s');
					$sitename_h = $this-> input-> post('sitecode_h');
					$area_dateschedule_m1 = $this-> input-> post('area_dateschedule_m1');
					$area_dateheld_m1 = $this-> input-> post('area_dateheld_m1');
					$area_dateschedule_m2 = $this-> input-> post('area_dateschedule_m2');
					$area_dateheld_m2  = $this-> input-> post('area_dateheld_m2');
					$area_dateschedule_m3= $this-> input-> post('area_dateschedule_m3');
					$area_dateheld_m3  = $this-> input-> post('area_dateheld_m3');	
					$session_type = $this-> input-> post('session_type');				
					$area_code_dt = $this-> input-> post('area_code_dt');				
					//creat addDataArray1 and insert_record
					$addDataArray1=array(
						'procode' => $procode,
						'distcode' => $distcode,
						'tcode' => $tcode,		   
						'uncode' => $uncode,
						'facode' => $facode,
						'techniciancode' => $techniciancode,
						'year' => $year,
						'quarter' => $quarter,
						'submitted_date' => $submitted_date
					);//print_r($addDataArray3);exit;
					for($k=1; $k<=3; $k++){	
						$addDataArray1['ahtr_activities_m'.$k] = (isset(${'ahtr_activities_m'.$k}) AND ${'ahtr_activities_m'.$k} != '')?${'ahtr_activities_m'.$k}:NULL;
						$addDataArray1['ahtr_resperson_m'.$k] = (isset(${'ahtr_resperson_m'.$k}) AND ${'ahtr_resperson_m'.$k} != '')?${'ahtr_resperson_m'.$k}:NULL;
						$addDataArray1['ra_activities_m'.$k] = (isset(${'ra_activities_m'.$k}) AND ${'ra_activities_m'.$k} != '')?${'ra_activities_m'.$k}:NULL;
						$addDataArray1['ra_resperson_m'.$k] = (isset(${'ra_resperson_m'.$k}) AND ${'ra_resperson_m'.$k} != '')?${'ra_resperson_m'.$k}:NULL;
						$addDataArray1['sh_fixed_m'.$k] = (isset(${'sh_Fixed_m'.$k}) AND ${'sh_Fixed_m'.$k} > 0)?${'sh_Fixed_m'.$k}:0;
						$addDataArray1['sh_outreach_m'.$k] = (isset(${'sh_Outreach_m'.$k}) AND ${'sh_Outreach_m'.$k} > 0)?${'sh_Outreach_m'.$k}:0;
						$addDataArray1['sh_mobile_m'.$k] = (isset(${'sh_Mobile_m'.$k}) AND ${'sh_Mobile_m'.$k} > 0)?${'sh_Mobile_m'.$k}:0;					
						$addDataArray1['sp_fixed_m'.$k] = (isset(${'sp_Fixed_m'.$k}) AND ${'sp_Fixed_m'.$k} > 0)?${'sp_Fixed_m'.$k}:0;
						$addDataArray1['sp_outreach_m'.$k] = (isset(${'sp_Outreach_m'.$k}) AND ${'sp_Outreach_m'.$k} > 0)?${'sp_Outreach_m'.$k}:0;
						$addDataArray1['sp_mobile_m'.$k] = (isset(${'sp_Mobile_m'.$k}) AND ${'sp_Mobile_m'.$k} > 0)?${'sp_Mobile_m'.$k}:0;
					}//print_r($addDataArray1);
					$id =$this-> Common_model-> insert_record('hf_quarterplan_db',$addDataArray1);
					/* echo "<br>";
					echo 'test1////////////////'; */
					//echo $this->db->last_query();exit;
					//creat addDataArray2 and insert on single loop itreation insert addDataArray3    
					foreach($this->input->post('area_code') as $key=>$val){
					$addDataArray2=array(
							'ms_id'=> $id,
							'procode' => $procode,
							'distcode' => $distcode,
							'tcode' => $tcode,		   
							'uncode' => $uncode,
							'facode' => $facode,
							'techniciancode' => $techniciancode,
							'year' => $year,
							'quarter' => $quarter,
							//'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
							'area_code' => (isset($area_code[$key]) AND $area_code[$key] != '')?$area_code[$key]:NULL,
							'area_num_sessions' => (isset($area_num_sessions[$key]) AND $area_num_sessions[$key] > 0)?$area_num_sessions[$key]:0,
							'session_type' => (isset($session_type_nm[$key]) AND $session_type_nm[$key] != '')?$session_type_nm[$key]:NULL,
							'area_transport_m1' => (isset($area_transport_m1[$key]) AND $area_transport_m1[$key] != '')?$area_transport_m1[$key]:NULL,
							'area_resperson_m1' => (isset($area_resperson_m1[$key]) AND $area_resperson_m1[$key] != '')?$area_resperson_m1[$key]:NULL,
							'area_distsupport_m1' => (isset($area_distsupport_m1[$key]) AND $area_distsupport_m1[$key] != '')?$area_distsupport_m1[$key]:NULL,
							'area_transport_m2' => (isset($area_transport_m2[$key]) AND $area_transport_m2[$key] != '')?$area_transport_m2[$key]:NULL,
							'area_resperson_m2' => (isset($area_resperson_m2[$key]) AND $area_resperson_m2[$key] != '')?$area_resperson_m2[$key]:NULL,
							'area_distsupport_m2' => (isset($area_distsupport_m2[$key]) AND $area_distsupport_m2[$key] != '')?$area_distsupport_m2[$key]:NULL,
							'area_transport_m3' => (isset($area_transport_m3[$key]) AND $area_transport_m3[$key] != '')?$area_transport_m3[$key]:NULL,
							'area_resperson_m3' => (isset($area_resperson_m3[$key]) AND $area_resperson_m3[$key] != '')?$area_resperson_m3[$key]:NULL,
							'area_distsupport_m3' => (isset($area_distsupport_m3[$key]) AND $area_distsupport_m3[$key] != '')?$area_distsupport_m3[$key]:NULL,
						);
						//print_r($addDataArray2);
						$link_id = $this-> Common_model-> insert_record('hf_quarterplan_nm_db',$addDataArray2);
						/* echo "<br>";
						//echo 'test2////////////////'; */
						if($link_id > 0){
							//creat addDataArray3 and insert
							foreach($this->input->post('area_dateschedule_m1')[$key] as $key3=>$val3){
							$addDataArray3=array(
								'ms_id'=> $id,
								'link_id'=> $link_id,
								'procode' => $procode,
								'distcode' => $distcode,
								'tcode' => $tcode,		   
								'uncode' => $uncode,
								'facode' => $facode,
								'techniciancode' => $techniciancode,
								'year' => $year,
								'quarter' => $quarter,
								'sitename_s' => (isset($sitename_s[$key][$key3]) AND $sitename_s[$key][$key3] != '')?$sitename_s[$key][$key3]:NULL,
								'sitename_h' => (isset($sitename_h[$key][$key3]) AND $sitename_h[$key][$key3] != '')?$sitename_h[$key][$key3]:NULL,
								'session_type' => (isset($session_type[$key][$key3]) AND $session_type[$key][$key3] != '')?$session_type[$key][$key3]:NULL,
								'area_code' => (isset($area_code_dt[$key][$key3]) AND $area_code_dt[$key][$key3] != '')?$area_code_dt[$key][$key3]:NULL,
								'area_dateschedule_m1' => (isset($area_dateschedule_m1[$key][$key3]) AND $area_dateschedule_m1[$key][$key3] != '')?$area_dateschedule_m1[$key][$key3]:NULL,
								'area_dateschedule_m2' => (isset($area_dateschedule_m2[$key][$key3]) AND $area_dateschedule_m2[$key][$key3] > 0)?$area_dateschedule_m2[$key][$key3]:NULL,
								'area_dateschedule_m3' => (isset($area_dateschedule_m3[$key][$key3]) AND $area_dateschedule_m3[$key][$key3] > 0)?$area_dateschedule_m3[$key][$key3]:NULL,
								'area_dateheld_m1' => (isset($area_dateheld_m1[$key][$key3]) AND $area_dateheld_m1[$key][$key3] > 0)?$area_dateheld_m1[$key][$key3]:NULL,
								'area_dateheld_m2' => (isset($area_dateheld_m2[$key][$key3]) AND $area_dateheld_m2[$key][$key3] != '')?$area_dateheld_m2[$key][$key3]:NULL,
								'area_dateheld_m3' => (isset($area_dateheld_m3[$key][$key3]) AND $area_dateheld_m3[$key][$key3] > 0)?$area_dateheld_m3[$key][$key3]:NULL,
								);
								$this-> Common_model-> insert_record('hf_quarterplan_dates_db',$addDataArray3);	
							/* echo "<br>";
							echo 'test3////////////////'; */
							}
						}//print_r($addDataArray3);
					}//exit;
					$this-> session-> set_flashdata('message','You have successfully saved your record!'); 
					$location = base_url()."red_rec_microplan/Facility_quarterplan/hf_quarterplan_list";
					redirect($location);
				}
			}
		}		
		public function hf_quarterplan_edit(){
			$facode = $this-> uri -> segment(4);
		    $year = $this-> uri -> segment(5);
		    $quarter = $this-> uri -> segment(6);
		    $techniciancode = $this-> uri -> segment(7);
			$currentyear = date('Y');
			$current_month = date('m');
			$currentquarter = getQuater($current_month);
			
			if($quarter >= $currentquarter AND $year == $currentyear){
				$data = $this-> Facility_quarterplan_model-> hf_quarterplan_edit($facode,$year,$quarter,$techniciancode);
				$data['fileToLoad'] = 'Add_red_microplanning/hf_quarterplan_edit';
				$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
				$this-> load-> view('template/epi_template',$data);
			}else{
				$location = base_url(). "red_rec_microplan/Facility_quarterplan/hf_quarterplan_list";
				echo '<script language="javascript" type="text/javascript"> alert("You just edit current quarter work plan !");	window.location="'.$location.'"</script>'; 
			}
			/* $data = $this-> Facility_quarterplan_model-> hf_quarterplan_edit($facode,$year,$quarter,$techniciancode);
			//print_r($data['data']);exit();
			$data['fileToLoad'] = 'Add_red_microplanning/hf_quarterplan_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data); */
		}		
		public function hf_quarterplan_view(){		
			
			$facode = $this-> uri -> segment(4);
		    $year = $this-> uri -> segment(5);
		    $quarter = $this-> uri -> segment(6);
		    $techniciancode = $this-> uri -> segment(7);
		    $excel = $this-> uri -> segment(8);
			$data = $this-> Facility_quarterplan_model-> hf_quarterplan_view($facode,$year,$quarter,$techniciancode);
			if($excel=='excel'){
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=HF_Quarterplan.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				$data['export_excel'] = True;
			}
			$data['filter_view']=$this-> uri -> segment(8);
			$data['fileToLoad'] = 'Add_red_microplanning/hf_quarterplan_view';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
	}
?>