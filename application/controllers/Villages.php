<?php 
	class Villages extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('Villages_model');
			authentication();
			$this-> load-> helper('epi_functions_helper');
            $this -> load -> model('Common_model');			
		}
		public function hf_quarterplan_list(){
			$data['data'] = $this-> Facility_quarterplan_model-> hf_quarterplan_list();
		   $data['fileToLoad'] = 'red_microplanning/hf_quarterplan_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function village_add(){
			$data['data'] =	"";
			//$data['village_get_record'] = $this -> Villages_model -> village_get_record();
			$data['fileToLoad'] = 'villages/village_add';
			$data['pageTitle'] = 'EPI-MIS | Village Add';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function village_get_record(){
			$uncode = $this -> input -> post('uncode');
			$data= $this -> Villages_model -> village_get_record($uncode);
			echo $data;
		}
		public function village_save(){
			$edit = $this-> input-> post('edit');
			
			if($edit != ''){
				//print_r($_POST); exit();
				$village = $this-> input-> post('village');	
				$postal_address = $this-> input-> post('postal_address');	
				foreach($this->input->post('village') as $key=>$val){
					$vcode = $this-> input-> post('vcode')[$key];
					$uncode = $this-> input-> post('uncode');
					$data_ar=array(
						'updated_date'=>date("Y-m-d"),						
						'village' => (isset($village[$key]) AND $village[$key] !="")?$village[$key]:NULL,
						'postal_address' => (isset($postal_address[$key]) AND $postal_address[$key] !="")?$postal_address[$key]:NULL,
					);
					$data_merge=array(					
						'mergername' => (isset($village[$key]) AND $village[$key] !="")?$village[$key]:NULL,
					);
					$this-> Common_model-> update_record('villages',$data_ar, array("vcode"=>$vcode));
					$this-> Common_model-> update_record('village_merger',$data_merge, array("uncode"=>$uncode));
				}
				$this-> session-> set_flashdata('message','You have successfully Update your record!'); 
				$location = base_url()."Village-List/";
				redirect($location);
			}else{
				//print_r($_POST); exit();
				$procode = $this -> session -> Province;
				$distcode = $this -> session -> District;
				$tcode = $this-> input-> post('tcode');	
				$uncode = $this-> input-> post('uncode');	
				$village = $this-> input-> post('village');	
				$population = $this-> input-> post('population');
				$added_date = date("Y-m-d");
				$facode = $this-> input-> post('facode');
				$postal_address = $this-> input-> post('postal_address');
				foreach($this->input->post('village') as $key=>$val){
						$vcode = $this -> Villages_model -> getNewVcodeForUc($uncode);
						$merger_group_id_merge = $merger_group_id_population= getMaxMergerGroupId()+1;
						$add_array=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'tcode' => $tcode,
							'uncode'=> $uncode,
							'added_date'=> $added_date,
							'vcode' => $vcode,
							'year' => date("Y"),
							'facode' => (isset($facode[$key]) AND $facode[$key] !="")?$facode[$key]:NULL,
							'village' => (isset($village[$key]) AND $village[$key] !="")?$village[$key]:NULL,
							'population' => (isset($population[$key]) AND $population[$key] !="")?$population[$key]:NULL,
							'postal_address' => (isset($postal_address[$key]) AND $postal_address[$key] !="")?$postal_address[$key]:NULL,
						);
						$dataPopulation=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'tcode' => $tcode,
							'uncode'=> $uncode,
							'vcode' => $vcode,
							'year' => date("Y"),
							'created_date'=> $added_date,
							'update_by'=> $this -> session -> username,
							'merger_group_id'=> $merger_group_id_population,
							'facode' => (isset($facode[$key]) AND $facode[$key] !="")?$facode[$key]:NULL,
							'population' => (isset($population[$key]) AND $population[$key] !="")?$population[$key]:NULL,
						);
						$dataMerger=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'tcode' => $tcode,
							'uncode'=> $uncode,
							'year' => date("Y"),
							'merger_group_id'=> $merger_group_id_merge,
							'facode' => (isset($facode[$key]) AND $facode[$key] !="")?$facode[$key]:NULL,
							'mergername' => (isset($village[$key]) AND $village[$key] !="")?$village[$key]:NULL,
							'totalpopulation' => (isset($population[$key]) AND $population[$key] !="")?$population[$key]:NULL,
						);
						$this -> Common_model -> insert_record('villages',$add_array);
						$this -> Common_model -> insert_record('villages_population',$dataPopulation);
			            $this -> Common_model -> insert_record('village_merger',$dataMerger);
				}
				$this-> session-> set_flashdata('message','You have successfully added your new village!'); 
				$location = base_url()."Village-List/";
				redirect($location);
			}
		}
		public function village_list(){			
			$data = $this -> Villages_model -> village_list();
			$data['UserLevel'] = $this -> session -> UserLevel;
			if ($data != 0) {
				$data['data'] = $data;
				//$data['checkresult'] = $data;
				$data['fileToLoad'] = 'villages/village_list';
				$data['pageTitle'] = 'Villages | EPI-MIS';
				$this-> load-> view('template/epi_template',$data);
			}
		}
		public function village_edit() {
			$uncode = $this -> uri -> segment(2);
			//print_r($uncode);exit;
			$data['data'] = $this -> Villages_model -> village_edit($uncode);
			$data['fileToLoad'] = 'villages/village_edit';
			$data['pageTitle'] = 'EPI-MIS | Update Village Form';
			$this -> load -> view('template/epi_template', $data);
	    }
		public function village_view() {
			$uncode = $this -> uri -> segment(2);
			//print_r($uncode);exit;
			$data['data'] = $this -> Villages_model -> village_view($uncode);
			$data['fileToLoad'] = 'villages/village_view';
			$data['pageTitle'] = 'EPI-MIS | Update Village Form';
			$this -> load -> view('template/epi_template', $data);
		}
		public function village_delete(){
			$uncode = $this -> uri -> segment(2);
			$data['data'] = $this -> Villages_model -> village_view($uncode);
			$data['fileToLoad'] = 'villages/village_delete';
			$data['pageTitle'] = 'EPI-MIS | Delete Village Form';
			$this -> load -> view('template/epi_template', $data);
		}
		public function deleted_villages(){
			$vcode = $this -> uri -> segment(3);
			$data = $this -> Villages_model -> deleted_villages($vcode);
			$data='';
			$this-> session-> set_flashdata('message','You have successfully Delete your record!'); 
			$location = base_url()."Village-List/";
			redirect($location);
		}
		public function merge_villages(){
			$data['data'] =	"";
			$data['fileToLoad'] = 'villages/village_merge';
			$data['pageTitle'] = 'EPI-MIS | Village Merge ';
			$this-> load-> view('template/epi_template',$data);
		}
		/* public function hf_quarterplan_save(){
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
				//print_r($_POST); exit();
				$procode = $_SESSION["Province"];
			   $distcode = $this -> session -> District;
			   $tcode = $this-> input-> post('tcode');				   
			   $uncode = $this-> input-> post('uncode');
			   $facode = $this-> input-> post('facode');
			   $year = $this-> input-> post('year');
			   $quarter = $this-> input-> post('quarter');			   
			   $submitted_date = $this-> input-> post('submitted_date');
			   $updated_date = $this-> input-> post('updated_date');

			   for($i=1; $i<=3; $i++){
			   	${'area'.$i.'_name'} = $this-> input-> post('area'.$i.'_name');			   	
					${'area'.$i.'_num_sessions'} = $this-> input-> post('area'.$i.'_num_sessions');
					${'area'.$i.'_dateschedule_m1'} = $this-> input-> post('area'.$i.'_dateschedule_m1');
					${'area'.$i.'_dateheld_m1'} = $this-> input-> post('area'.$i.'_dateheld_m1');					
					${'area'.$i.'_transport_m1'} = $this-> input-> post('area'.$i.'_transport_m1');
					${'area'.$i.'_resperson_m1'} = $this-> input-> post('area'.$i.'_resperson_m1');
					${'area'.$i.'_distsupport_m1'} = $this-> input-> post('area'.$i.'_distsupport_m1');
					${'area'.$i.'_dateschedule_m2'} = $this-> input-> post('area'.$i.'_dateschedule_m2');
					${'area'.$i.'_dateheld_m2'} = $this-> input-> post('area'.$i.'_dateheld_m2');
					${'area'.$i.'_transport_m2'} = $this-> input-> post('area'.$i.'_transport_m2');
					${'area'.$i.'_resperson_m2'} = $this-> input-> post('area'.$i.'_resperson_m2');
					${'area'.$i.'_distsupport_m2'} = $this-> input-> post('area'.$i.'_distsupport_m2');
					${'area'.$i.'_dateschedule_m3'} = $this-> input-> post('area'.$i.'_dateschedule_m3');
					${'area'.$i.'_dateheld_m3'} = $this-> input-> post('area'.$i.'_dateheld_m3');
					${'area'.$i.'_transport_m3'} = $this-> input-> post('area'.$i.'_transport_m3');
					${'area'.$i.'_resperson_m3'} = $this-> input-> post('area'.$i.'_resperson_m3');
					${'area'.$i.'_distsupport_m3'} = $this-> input-> post('area'.$i.'_distsupport_m3');
					${'ahtr_activities_m'.$i} = $this-> input-> post('ahtr_activities_m'.$i);
					${'ahtr_resperson_m'.$i} = $this-> input-> post('ahtr_resperson_m'.$i);
					${'ra_activities_m'.$i} = $this-> input-> post('ra_activities_m'.$i);
					${'ra_resperson_m'.$i} = $this-> input-> post('ra_resperson_m'.$i);
					${'msi_numheld_m'.$i} = $this-> input-> post('msi_numheld_m'.$i);
					${'msi_numplan_m'.$i} = $this-> input-> post('msi_numplan_m'.$i);
			   }				

				$this-> Common_model-> delete_record_multiple_colum('hf_quarterplan_db',array('facode'=>$facode,'year'=>$year,'quarter'=>$quarter));
				
				$edit_array=array(
					'distcode' => $distcode,
					'tcode' => $tcode,		   
				   'uncode' => $uncode,
				   'facode' => $facode,
				   'year' => $year,
				   'quarter' => $quarter,
				   'submitted_date' => $submitted_date,
				   'updated_date' => $updated_date
				);
				for($i=1; $i < 4; $i++){					
					$edit_array['area'.$i.'_name'] = (isset(${'area'.$i.'_name'}) AND ${'area'.$i.'_name'} != '')?${'area'.$i.'_name'}:NULL;
					$edit_array['area'.$i.'_num_sessions'] = (isset(${'area'.$i.'_num_sessions'}) AND ${'area'.$i.'_num_sessions'} > 0)?${'area'.$i.'_num_sessions'}:0;
					$edit_array['area'.$i.'_dateschedule_m1'] = (isset(${'area'.$i.'_dateschedule_m1'}) AND ${'area'.$i.'_dateschedule_m1'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m1'})):NULL;
					$edit_array['area'.$i.'_dateheld_m1'] = (isset(${'area'.$i.'_dateheld_m1'}) AND ${'area'.$i.'_dateheld_m1'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m1'})):NULL;
					$edit_array['area'.$i.'_transport_m1'] = (isset(${'area'.$i.'_transport_m1'}) AND ${'area'.$i.'_transport_m1'} != '')?${'area'.$i.'_transport_m1'}:NULL;
					$edit_array['area'.$i.'_resperson_m1'] = (isset(${'area'.$i.'_resperson_m1'}) AND ${'area'.$i.'_resperson_m1'} != '')?${'area'.$i.'_resperson_m1'}:NULL;
					$edit_array['area'.$i.'_distsupport_m1'] = (isset(${'area'.$i.'_distsupport_m1'}) AND ${'area'.$i.'_distsupport_m1'} != '')?${'area'.$i.'_distsupport_m1'}:NULL;
					$edit_array['area'.$i.'_dateschedule_m2'] = (isset(${'area'.$i.'_dateschedule_m2'}) AND ${'area'.$i.'_dateschedule_m2'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m2'})):NULL;
					$edit_array['area'.$i.'_dateheld_m2'] = (isset(${'area'.$i.'_dateheld_m2'}) AND ${'area'.$i.'_dateheld_m2'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m2'})):NULL;
					$edit_array['area'.$i.'_transport_m2'] = (isset(${'area'.$i.'_transport_m2'}) AND ${'area'.$i.'_transport_m2'} != '')?${'area'.$i.'_transport_m2'}:NULL;
					$edit_array['area'.$i.'_resperson_m2'] = (isset(${'area'.$i.'_resperson_m2'}) AND ${'area'.$i.'_resperson_m2'} != '')?${'area'.$i.'_resperson_m2'}:NULL;
					$edit_array['area'.$i.'_distsupport_m2'] = (isset(${'area'.$i.'_distsupport_m2'}) AND ${'area'.$i.'_distsupport_m2'} != '')?${'area'.$i.'_distsupport_m2'}:NULL;
					$edit_array['area'.$i.'_dateschedule_m3'] = (isset(${'area'.$i.'_dateschedule_m3'}) AND ${'area'.$i.'_dateschedule_m3'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m3'})):NULL;
					$edit_array['area'.$i.'_dateheld_m3'] = (isset(${'area'.$i.'_dateheld_m3'}) AND ${'area'.$i.'_dateheld_m3'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m3'})):NULL;
					$edit_array['area'.$i.'_transport_m3'] = (isset(${'area'.$i.'_transport_m3'}) AND ${'area'.$i.'_transport_m3'} != '')?${'area'.$i.'_transport_m3'}:NULL;
					$edit_array['area'.$i.'_resperson_m3'] = (isset(${'area'.$i.'_resperson_m3'}) AND ${'area'.$i.'_resperson_m3'} != '')?${'area'.$i.'_resperson_m3'}:NULL;
					$edit_array['area'.$i.'_distsupport_m3'] = (isset(${'area'.$i.'_distsupport_m3'}) AND ${'area'.$i.'_distsupport_m3'} != '')?${'area'.$i.'_distsupport_m3'}:NULL;
					$edit_array['ahtr_activities_m'.$i] = (isset(${'ahtr_activities_m'.$i}) AND ${'ahtr_activities_m'.$i} != '')?${'ahtr_activities_m'.$i}:NULL;
					$edit_array['ahtr_resperson_m'.$i] = (isset(${'ahtr_resperson_m'.$i}) AND ${'ahtr_resperson_m'.$i} != '')?${'ahtr_resperson_m'.$i}:NULL;
					$edit_array['ra_activities_m'.$i] = (isset(${'ra_activities_m'.$i}) AND ${'ra_activities_m'.$i} != '')?${'ra_activities_m'.$i}:NULL;
					$edit_array['ra_resperson_m'.$i] = (isset(${'ra_resperson_m'.$i}) AND ${'ra_resperson_m'.$i} != '')?${'ra_resperson_m'.$i}:NULL;
					$edit_array['msi_numheld_m'.$i] = (isset(${'msi_numheld_m'.$i}) AND ${'msi_numheld_m'.$i} > 0)?${'msi_numheld_m'.$i}:0;
					$edit_array['msi_numplan_m'.$i] = (isset(${'msi_numplan_m'.$i}) AND ${'msi_numplan_m'.$i} > 0)?${'msi_numplan_m'.$i}:0;
				}

			   //print_r($edit_array);exit();
				$this-> Common_model-> insert_record('hf_quarterplan_db',$edit_array);	
		      $this-> session-> set_flashdata('message','You have successfully updated your record!'); 
				$location = base_url()."red_microplan/Facility_quarterplan/hf_quarterplan_list";
				redirect($location);
			}
			else{
				//print_r($_POST); exit();
				$distcode = $this -> session -> District;
			   $tcode = $this-> input-> post('tcode');				   
			   $uncode = $this-> input-> post('uncode');
			   $facode = $this-> input-> post('facode');
			   $year = $this-> input-> post('year');
			   $quarter = $this-> input-> post('quarter');			   
			   $submitted_date = $this-> input-> post('submitted_date');
			   
			   for($i=1; $i<=3; $i++){
			   	${'area'.$i.'_name'} = $this-> input-> post('area'.$i.'_name');			   	
					${'area'.$i.'_num_sessions'} = $this-> input-> post('area'.$i.'_num_sessions');
					${'area'.$i.'_dateschedule_m1'} = $this-> input-> post('area'.$i.'_dateschedule_m1');
					${'area'.$i.'_dateheld_m1'} = $this-> input-> post('area'.$i.'_dateheld_m1');					
					${'area'.$i.'_transport_m1'} = $this-> input-> post('area'.$i.'_transport_m1');
					${'area'.$i.'_resperson_m1'} = $this-> input-> post('area'.$i.'_resperson_m1');
					${'area'.$i.'_distsupport_m1'} = $this-> input-> post('area'.$i.'_distsupport_m1');
					${'area'.$i.'_dateschedule_m2'} = $this-> input-> post('area'.$i.'_dateschedule_m2');
					${'area'.$i.'_dateheld_m2'} = $this-> input-> post('area'.$i.'_dateheld_m2');
					${'area'.$i.'_transport_m2'} = $this-> input-> post('area'.$i.'_transport_m2');
					${'area'.$i.'_resperson_m2'} = $this-> input-> post('area'.$i.'_resperson_m2');
					${'area'.$i.'_distsupport_m2'} = $this-> input-> post('area'.$i.'_distsupport_m2');
					${'area'.$i.'_dateschedule_m3'} = $this-> input-> post('area'.$i.'_dateschedule_m3');
					${'area'.$i.'_dateheld_m3'} = $this-> input-> post('area'.$i.'_dateheld_m3');
					${'area'.$i.'_transport_m3'} = $this-> input-> post('area'.$i.'_transport_m3');
					${'area'.$i.'_resperson_m3'} = $this-> input-> post('area'.$i.'_resperson_m3');
					${'area'.$i.'_distsupport_m3'} = $this-> input-> post('area'.$i.'_distsupport_m3');
					${'ahtr_activities_m'.$i} = $this-> input-> post('ahtr_activities_m'.$i);
					${'ahtr_resperson_m'.$i} = $this-> input-> post('ahtr_resperson_m'.$i);
					${'ra_activities_m'.$i} = $this-> input-> post('ra_activities_m'.$i);
					${'ra_resperson_m'.$i} = $this-> input-> post('ra_resperson_m'.$i);
					${'msi_numheld_m'.$i} = $this-> input-> post('msi_numheld_m'.$i);
					${'msi_numplan_m'.$i} = $this-> input-> post('msi_numplan_m'.$i);
			   }
			   
				$checkquery = "SELECT count(*) as recordnum from hf_quarterplan_db where year='$year' and facode='$facode' and quarter='$quarter'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					$location = base_url().'red_microplan/Facility_quarterplan/hf_quarterplan_list';
					$script  = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Cannot save data because data already exists for this Facility, Year and Quarter!");';
					$script .= 'window.location="'. $location . '"';
					$script .= '</script>';
					echo $script;		
					exit();
				}
				
				$addDataArray=array(
					'distcode' => $distcode,
					'tcode' => $tcode,		   
				   'uncode' => $uncode,
				   'facode' => $facode,
				   'year' => $year,
				   'quarter' => $quarter,
				   'submitted_date' => $submitted_date
				);
				for($i=1; $i<=3; $i++){					
					$addDataArray['area'.$i.'_name'] = (isset(${'area'.$i.'_name'}) AND ${'area'.$i.'_name'} != '')?${'area'.$i.'_name'}:NULL;
					$addDataArray['area'.$i.'_num_sessions'] = (isset(${'area'.$i.'_num_sessions'}) AND ${'area'.$i.'_num_sessions'} > 0)?${'area'.$i.'_num_sessions'}:0;
					$addDataArray['area'.$i.'_dateschedule_m1'] = (isset(${'area'.$i.'_dateschedule_m1'}) AND ${'area'.$i.'_dateschedule_m1'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m1'})):NULL;
					$addDataArray['area'.$i.'_dateheld_m1'] = (isset(${'area'.$i.'_dateheld_m1'}) AND ${'area'.$i.'_dateheld_m1'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m1'})):NULL;
					$addDataArray['area'.$i.'_transport_m1'] = (isset(${'area'.$i.'_transport_m1'}) AND ${'area'.$i.'_transport_m1'} != '')?${'area'.$i.'_transport_m1'}:NULL;
					$addDataArray['area'.$i.'_resperson_m1'] = (isset(${'area'.$i.'_resperson_m1'}) AND ${'area'.$i.'_resperson_m1'} != '')?${'area'.$i.'_resperson_m1'}:NULL;
					$addDataArray['area'.$i.'_distsupport_m1'] = (isset(${'area'.$i.'_distsupport_m1'}) AND ${'area'.$i.'_distsupport_m1'} != '')?${'area'.$i.'_distsupport_m1'}:NULL;
					$addDataArray['area'.$i.'_dateschedule_m2'] = (isset(${'area'.$i.'_dateschedule_m2'}) AND ${'area'.$i.'_dateschedule_m2'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m2'})):NULL;
					$addDataArray['area'.$i.'_dateheld_m2'] = (isset(${'area'.$i.'_dateheld_m2'}) AND ${'area'.$i.'_dateheld_m2'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m2'})):NULL;
					$addDataArray['area'.$i.'_transport_m2'] = (isset(${'area'.$i.'_transport_m2'}) AND ${'area'.$i.'_transport_m2'} != '')?${'area'.$i.'_transport_m2'}:NULL;
					$addDataArray['area'.$i.'_resperson_m2'] = (isset(${'area'.$i.'_resperson_m2'}) AND ${'area'.$i.'_resperson_m2'} != '')?${'area'.$i.'_resperson_m2'}:NULL;
					$addDataArray['area'.$i.'_distsupport_m2'] = (isset(${'area'.$i.'_distsupport_m2'}) AND ${'area'.$i.'_distsupport_m2'} != '')?${'area'.$i.'_distsupport_m2'}:NULL;
					$addDataArray['area'.$i.'_dateschedule_m3'] = (isset(${'area'.$i.'_dateschedule_m3'}) AND ${'area'.$i.'_dateschedule_m3'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateschedule_m3'})):NULL;
					$addDataArray['area'.$i.'_dateheld_m3'] = (isset(${'area'.$i.'_dateheld_m3'}) AND ${'area'.$i.'_dateheld_m3'} != '')?date('Y-m-d', strtotime(${'area'.$i.'_dateheld_m3'})):NULL;
					$addDataArray['area'.$i.'_transport_m3'] = (isset(${'area'.$i.'_transport_m3'}) AND ${'area'.$i.'_transport_m3'} != '')?${'area'.$i.'_transport_m3'}:NULL;
					$addDataArray['area'.$i.'_resperson_m3'] = (isset(${'area'.$i.'_resperson_m3'}) AND ${'area'.$i.'_resperson_m3'} != '')?${'area'.$i.'_resperson_m3'}:NULL;
					$addDataArray['area'.$i.'_distsupport_m3'] = (isset(${'area'.$i.'_distsupport_m3'}) AND ${'area'.$i.'_distsupport_m3'} != '')?${'area'.$i.'_distsupport_m3'}:NULL;
					$addDataArray['ahtr_activities_m'.$i] = (isset(${'ahtr_activities_m'.$i}) AND ${'ahtr_activities_m'.$i} != '')?${'ahtr_activities_m'.$i}:NULL;
					$addDataArray['ahtr_resperson_m'.$i] = (isset(${'ahtr_resperson_m'.$i}) AND ${'ahtr_resperson_m'.$i} != '')?${'ahtr_resperson_m'.$i}:NULL;
					$addDataArray['ra_activities_m'.$i] = (isset(${'ra_activities_m'.$i}) AND ${'ra_activities_m'.$i} != '')?${'ra_activities_m'.$i}:NULL;
					$addDataArray['ra_resperson_m'.$i] = (isset(${'ra_resperson_m'.$i}) AND ${'ra_resperson_m'.$i} != '')?${'ra_resperson_m'.$i}:NULL;
					$addDataArray['msi_numheld_m'.$i] = (isset(${'msi_numheld_m'.$i}) AND ${'msi_numheld_m'.$i} > 0)?${'msi_numheld_m'.$i}:0;
					$addDataArray['msi_numplan_m'.$i] = (isset(${'msi_numplan_m'.$i}) AND ${'msi_numplan_m'.$i} > 0)?${'msi_numplan_m'.$i}:0;
				}

				$this-> Common_model-> insert_record('hf_quarterplan_db',$addDataArray);
			   $this-> session-> set_flashdata('message','You have successfully saved your record!'); 
				$location = base_url()."red_microplan/Facility_quarterplan/hf_quarterplan_list";
				redirect($location);
			}
		}		
		public function hf_quarterplan_edit(){
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
		   $quarter = $this-> uri -> segment(6);
			$data['data'] = $this-> Facility_quarterplan_model-> hf_quarterplan_edit($facode,$year,$quarter);
			//print_r($data['data']);exit();
			$data['fileToLoad'] = 'red_microplanning/hf_quarterplan_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}		
		public function hf_quarterplan_view(){			
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
		   $quarter = $this-> uri -> segment(6);
			$data['data'] = $this-> Facility_quarterplan_model-> hf_quarterplan_view($facode,$year,$quarter);
		   $data['fileToLoad'] = 'red_microplanning/hf_quarterplan_view';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		} */
		public function ajax_village_save()
		{   
			$tcode = $this-> input-> post('tcode');				   
			$uncode = $this-> input-> post('uncode');
			$vcode =$this-> input-> post('vcode');
			$village = $this-> input-> post('village');
			$distcode = $this -> session -> District;
			$imei = $this-> input-> post('imei');
			$year = $this-> input-> post('year');
			$ajax_village_save = array(
				"procode"=>$this -> session -> Province,
			   "distcode" => $distcode,
			   "tcode" => $tcode,				   
			   "uncode" => $uncode,
			   "year" => $year,
			   "vcode" => $vcode,
			   "village" => $village,
			   "population" => $this-> input-> post('population'),
			   "population_less_year" => $this-> input-> post('population_less_year'),
			   "postal_address" => $this-> input-> post('postal_address'),
			   'imei' => (isset($imei) AND $imei > 0)? $imei:"NULL",
			   "added_date"=>date("Y-m-d")
			);
			$ajax_village_populatin_save = array(
				"procode"=>$this -> session -> Province,
			   "distcode" => $distcode,
			   "uncode" => $uncode,
			   "year" => $year,
			   "vcode" => $vcode,
			   "population" => $this-> input-> post('population'),
			);
			//print_r($ajax_village_save);exit;
			$data = $this -> Villages_model -> ajax_village_save($ajax_village_save,$ajax_village_populatin_save,$tcode,$uncode,$distcode,$vcode,$year);

			  print_r($data);
			  
		}
	public function village_table(){
		$wc = getWC();
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$search = $this->input->get("search");
		$columns = $this->input->get("columns");
		$multiple_search = "";
	if(isset($columns) AND is_array($columns))
		{
			foreach ($columns as $key => $value) 
			{
				$search_value = $value['search']['value'];
				$search_value = str_replace('_', ' ', $search_value);
				$column = $value['data'];
				 if($_SESSION['UserLevel']=='2')
					{
						$column = str_replace('districtname', 'distcode', $column);
					}
				elseif ($_SESSION['UserLevel']=='3') 
				{
					$column = str_replace('unname', 'uncode', $column);
					$column = str_replace('tehsilname', 'tcode', $column);
				}
				if( ! empty($search_value))
				{
					$multiple_search .= " AND ";
					$multiple_search .= "$column='$search_value'";
				}
			}
		}      	
		if(isset($search))
		{
			$keyword = $search['value'];
			$keyword = str_replace('_', ' ', $keyword);
			$keyword = strtolower($keyword);
			$search = " AND (lower(unname(villages.uncode)) LIKE '$keyword%' OR
						 lower(tehsilname(villages.tcode)) LIKE '$keyword%')" ;     		
		}else {
			$search = "";
		}
		$col = 0;
		$dir = "";
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
				"tehsilname",
				"unname",
				"villages_counts",
				"uncode",
			);
		if(!isset($columns_valid[$col])) {
			$order = '';
		} elseif($draw == 0) {
			$order = " order by added_date ";
		}
		else{
			$order = "order by ".$columns_valid[$col].' '.$dir;
		}
		$query = "select  count(villages.uncode) as villages_counts,unname(villages.uncode) as unname,tehsilname (villages.tcode)as tehsilname,uncode from villages where $wc $search $multiple_search group by villages.uncode,villages.tcode $order LIMIT {$length} OFFSET {$start}  ";
		$villages = $this->db->query($query);
		$data = array();
		$i=$start+1;
		foreach($villages->result() as $r) 
		{	
				//$checkresult= 
				$data[] = array(
					"serial" => $i,
					"tehsilname" => $r->tehsilname,
					"unname" => $r->unname,
					"villages_counts" => $r->villages_counts,                
					"uncode" => $r->uncode,	                
					//"checkresult" => $this -> Villages_model ->  VillageExistinMicroplan($r->vcode), 
					
				); 
				
			$i++;
			
		}
		$query = "SELECT  count(*)  AS num FROM villages WHERE $wc $search $multiple_search";
		$total_village = $this->db->query($query)->row();
		$output = array(
			"draw" => $draw,
			"recordsTotal" => $total_village->num,
			"recordsFiltered" => $total_village->num,
			"data" => $data
		);
		echo json_encode($output);
		exit();
	}
}
?>