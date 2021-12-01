<?php
	class Special_activities extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Special_activities_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
		}
		public function special_activities_list(){
			$data['data'] = $this-> Special_activities_model-> special_activities_list();
		   $data['fileToLoad'] = 'red_microplanning/special_activities_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function special_activities_add(){
			$facode = $this-> uri -> segment(3);
		   $year = $this-> uri -> segment(5);

			$data['data'] = $this-> Special_activities_model-> special_activities_add($facode,$year);
			//$data['data'] =	"";
			//print_r($data['data']);exit();
		/*	$this-> load-> view('Add_red_microplanning/special_activities_add',$data);*/
			$data['fileToLoad'] = 'Add_red_microplanning/special_activities_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function special_activities_save(){
		
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
				//print_r($_POST); exit();
				//$procode = $_SESSION["Province"];
			   //$distcode = $this -> session -> District;
			   //$tcode = $this-> input-> post('tcode');				   
			   //$uncode = $this-> input-> post('uncode');
			   //$facode = $this-> input-> post('facode');
			   $techniciancode = $this-> input-> post('techniciancode');
			   $year = $this-> input-> post('year');
			   //$submitted_date = $this-> input-> post('submitted_date');
			   //$updated_date = $this-> input-> post('updated_date');				   
				//$area_name = $this-> input-> post('area_name');
				//$category = $this-> input-> post('category');
				//$fk= $this-> input-> post('fk');
				$hard_to_reach = $this-> input-> post('hard_to_reach');
				$reached_last_year = $this-> input-> post('reached_last_year');
				$activities_improve_hf= $this-> input-> post('activities_improve_hf');					
				$activities_need_support = $this-> input-> post('activities_need_support');
				$interventions_delivered = $this-> input-> post('interventions_delivered');

				//$this-> Common_model-> delete_record_multiple_colum('special_activities_db',array('facode'=>$facode,'year'=>$year));
			   
				foreach($this-> input-> post('area_name') as $key=>$val){
					$recid = $this-> input-> post('recid')[$key];
					$edit_array=array(
						//'procode' => $procode,
						//'distcode' => $distcode,
						//'tcode' => $tcode,		   
					   //'uncode' => $uncode,
					   //'facode' => $facode,
					   //'year' => $year,
					   //'submitted_date' => $submitted_date,
					   //'updated_date' => $updated_date,
					   //'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
					//	'category' => (isset($category[$key]) AND $category[$key] > 0)?$category[$key]:0,
						//'foreign_key' => (isset($fk[$key]) AND $fk[$key] != '')?$fk[$key]:NULL,
						'f2_hard_to_reach' => (isset($hard_to_reach[$key]) AND $hard_to_reach[$key] != '')?$hard_to_reach[$key]:NULL,
						'f2_reached_last_year' => (isset($reached_last_year[$key]) AND $reached_last_year[$key] > 0)?$reached_last_year[$key]:0,
						'f2_activities_improve_hf' => (isset($activities_improve_hf[$key]) AND $activities_improve_hf[$key] != '')?$activities_improve_hf[$key]:NULL,
						'f2_activities_need_support' => (isset($activities_need_support[$key]) AND $activities_need_support[$key] != '')?$activities_need_support[$key]:NULL,
						'f2_interventions_delivered' => (isset($interventions_delivered[$key]) AND $interventions_delivered[$key] != '')?$interventions_delivered[$key]:NULL,	
					);
				   //print_r($edit_array);exit();
					$this-> Common_model-> update_record('situation_analysis_db',$edit_array,array('techniciancode'=>$techniciancode,'year'=>$year,'recid'=>$recid));		         
				}
		      $query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility, year from situation_analysis_db where techniciancode='$techniciancode' and year='$year' order by priority asc";
		            $result = $this-> db-> query($query);	
		            $data =	$result-> result_array();
		           
                     $myJSON = json_encode($data);
                  
                    echo $myJSON; 
			}
			else{
				
				///print_r($_POST); exit();
				//$distcode = $this -> session -> District;
			   //$tcode = $this-> input-> post('tcode');				   
			   //$uncode = $this-> input-> post('uncode');
			   $facode = $this-> input-> post('facode');
			   $techniciancode = $this-> input-> post('techniciancode');
			   $year = $this-> input-> post('year');
			   
			   //$submitted_date = $this-> input-> post('submitted_date');				   
				//$area_name = $this-> input-> post('area_name');
				//$category = $this-> input-> post('category');
				//$fk= $this-> input-> post('fk');
				$f2_hard_to_reach = $this-> input-> post('hard_to_reach');
				$f2_reached_last_year = $this-> input-> post('reached_last_year');
				$f2_activities_improve_hf= $this-> input-> post('activities_improve_hf');					
				$f2_activities_need_support = $this-> input-> post('activities_need_support');
				$f2_interventions_delivered = $this-> input-> post('interventions_delivered');

				/* $checkquery = "SELECT count(*) as recordnum from special_activities_db where year='$year' and facode='$facode'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					/* $location = base_url().'red_microplan/Situation_analysis/situation_analysis_list';
					$script  = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Cannot save data because data already exists for this Facility and Year!");';
					$script .= 'window.location="'. $location . '"';
					$script .= '</script>';
					echo $script;
					echo "yes";
					exit();
				} */
				
				foreach($this->input->post('area_name') as $key=>$val){
					$recid = $this-> input-> post('recid')[$key];
					$addDataArray=array(
						//'distcode' => $distcode,
						//'tcode' => $tcode,		   
					   //'uncode' => $uncode,
					   //'facode' => $facode,
					   //'year' => $year,
					   //'submitted_date' => $submitted_date,
						//'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						//'category' => (isset($category[$key]) AND $category[$key] > 0)?$category[$key]:0,
						//'foreign_key' => (isset($fk[$key]) AND $fk[$key] != '')?$fk[$key]:NULL,
						'f2_hard_to_reach' => (isset($f2_hard_to_reach[$key]) AND $f2_hard_to_reach[$key] != '')?$f2_hard_to_reach[$key]:NULL,
						'f2_reached_last_year' => (isset($f2_reached_last_year[$key]) AND $f2_reached_last_year[$key] > 0)?$f2_reached_last_year[$key]:0,
						'f2_activities_improve_hf' => (isset($f2_activities_improve_hf[$key]) AND $f2_activities_improve_hf[$key] != '')?$f2_activities_improve_hf[$key]:NULL,
						'f2_activities_need_support' => (isset($f2_activities_need_support[$key]) AND $f2_activities_need_support[$key] != '')?$f2_activities_need_support[$key]:NULL,
						'f2_interventions_delivered' => (isset($f2_interventions_delivered[$key]) AND $f2_interventions_delivered[$key] != '')?$f2_interventions_delivered[$key]:NULL,						
					);
					//print_r($addDataArray); exit();
					$this-> Common_model-> update_record('situation_analysis_db',$addDataArray,array('techniciancode'=>$techniciancode,'year'=>$year,'recid'=>$recid));
			   }   
			        $query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility, year from situation_analysis_db where techniciancode='$techniciancode' and year='$year' order by priority asc";
		            $result = $this-> db-> query($query);	
		            $data =	$result-> result_array();
		           
                     $myJSON = json_encode($data);
                  
                    echo $myJSON;  
			   // print_r($addDataArray);
			    //$this-> session-> set_flashdata('message','You have successfully saved your record!'); 
				//$location = base_url()."red_microplan/Session_plan/session_plan_add/".$facode."/".$year;
				//$location = base_url()."red_microplan/Special_activities/special_activities_list";
				//redirect($location);
			}
		}		
		public function special_activities_edit(){
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Special_activities_model-> special_activities_edit($facode,$year);
			//print_r($data);exit;
			$data['fileToLoad'] = 'red_microplanning/special_activities_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}		
		public function special_activities_view(){			
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Special_activities_model-> special_activities_view($facode,$year);
		   //print_r($data);exit;
		   $data['fileToLoad'] = 'red_microplanning/special_activities_view';
		   $data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
	}
?>