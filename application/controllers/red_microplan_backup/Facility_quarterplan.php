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
		   $data['fileToLoad'] = 'red_microplanning/hf_quarterplan_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function hf_quarterplan_add(){
			$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/hf_quarterplan_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function hf_quarterplan_save(){
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
		}
	}
?>