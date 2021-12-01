<?php
	class Session_plan extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Session_plan_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
		}
		public function session_plan_list(){
			$data['data'] = $this-> Session_plan_model-> session_plan_list();
		   $data['fileToLoad'] = 'red_microplanning/session_plan_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function session_plan_add(){
			$facode = $this-> uri -> segment(4);
		    $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Session_plan_model-> session_plan_add($facode,$year);
			//print_r($data['data']);exit();
			//$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/session_plan_add';
			$data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function session_plan_save(){
			
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
				
			//	$procode = $_SESSION["Province"];
			 // 	$distcode = $this -> session -> District;
			//   $tcode = $this-> input-> post('tcode');				   
			 //  $uncode = $this-> input-> post('uncode');
				$techniciancode = $this-> input-> post('techniciancode');
		 		$year = $this-> input-> post('year');
			 //  $submitted_date = $this-> input-> post('submitted_date');
			  // $updated_date = $this-> input-> post('updated_date');				   
			//	$area_name = $this-> input-> post('area_name');
			//	$fk= $this-> input-> post('fk');
				$total_population = $this-> input-> post('total_population');
				$target_population = $this-> input-> post('target_population');
				$session_type = $this-> input-> post('session_type');
				$injections_per_year = $this-> input-> post('injections_per_year');
				$injections_per_month = $this-> input-> post('injections_per_month');
				$estimated_sessions = $this-> input-> post('estimated_sessions');
				$sessions_per_month= $this-> input-> post('sessions_per_month');					
				$actual_sessions_plan = $this-> input-> post('actual_sessions_plan');
				$child_survival_interventions = $this-> input-> post('child_survival_interventions');
				$hard_to_reach = $this-> input-> post('hard_to_reach');
				$hard_to_reach_population = $this-> input-> post('hard_to_reach_population');

				//foreach($this-> input-> post('area_name') as $key=>$val){
				//	$hard_to_reach_population[$key] =(isset($this->input->post('hard_to_reach_population')[$key]) && ($this->input->post('hard_to_reach_population')[$key] != '')?$this->input->post('hard_to_reach_population')[$key]:0);
				//	if(($target_population[$key] > $total_population[$key]) && ($hard_to_reach_population[$key] > $total_population[$key])){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Target Population and Hard to Reach Population are greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;		 */
				//		echo "HTR>TP";		
				//	    exit();
				//	}

				//	if($target_population[$key] > $total_population[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Target Population is greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;	 */	
				//		echo "TP>TP";		
					//	exit();
					//}

					//if($hard_to_reach_population[$key] > $total_population[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Hard to Reach Population is greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;	 */	
				//		echo "HRP>TP";		
				//		exit();
				//	}

				//	if($actual_sessions_plan[$key] > $sessions_per_month[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Actual sessions planned is greater than Actual sessions planned!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;		 */
				//		echo "ASP>SPM";		
					//	exit();
				//	}
				//} 

				//s$this-> Common_model-> delete_record_multiple_colum('session_plan_db',array('techniciancode'=>$techniciancode,'year'=>$year));
			   
				foreach($this-> input-> post('area_name') as $key=>$val){
					$recid = $this-> input-> post('recid')[$key];
					$edit_array=array(
				//		'procode' => $procode,
				//		'distcode' => $distcode,
				///		'tcode' => $tcode,		   
				//	   'uncode' => $uncode,
					//   'facode' => $facode,
				//	   'year' => $year,
					//   'submitted_date' => $submitted_date,
					///   'updated_date' => $updated_date,
					//	'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						//'foreign_key' => (isset($fk[$key]) AND $fk[$key] != '')?$fk[$key]:NULL,
						'f3_total_population' => (isset($total_population[$key]) AND $total_population[$key] > 0)?$total_population[$key]:0,
						'f3_target_population' => (isset($target_population[$key]) AND $target_population[$key] > 0)?$target_population[$key]:0,
						'f3_session_type' => (isset($session_type[$key]) AND $session_type[$key] != '')?$session_type[$key]:NULL,
						'f3_injections_per_year' => (isset($injections_per_year[$key]) AND $injections_per_year[$key] > 0)?$injections_per_year[$key]:0,
						'f3_injections_per_month' => (isset($injections_per_month[$key]) AND $injections_per_month[$key] > 0)?$injections_per_month[$key]:0,
						'f3_estimated_sessions' => (isset($estimated_sessions[$key]) AND $estimated_sessions[$key] > 0)?$estimated_sessions[$key]:0,
						'f3_sessions_per_month' => (isset($sessions_per_month[$key]) AND $sessions_per_month[$key] > 0)?$sessions_per_month[$key]:0,
						'f3_actual_sessions_plan' => (isset($actual_sessions_plan[$key]) AND $actual_sessions_plan[$key] > 0)?$actual_sessions_plan[$key]:0,
						'f3_child_survival_interventions' => (isset($child_survival_interventions[$key]) AND $child_survival_interventions[$key] != '')?$child_survival_interventions[$key]:NULL,
						'f3_hard_to_reach' => (isset($hard_to_reach[$key]) AND $hard_to_reach[$key] != '')?$hard_to_reach[$key]:NULL,
						'f3_hard_to_reach_population' => (isset($hard_to_reach_population[$key]) AND $hard_to_reach_population[$key] > 0)?$hard_to_reach_population[$key]:0,	
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
				
				//print_r($_POST); exit();
				//$distcode = $this -> session -> District;
			   //$tcode = $this-> input-> post('tcode');				   
			   //$uncode = $this-> input-> post('uncode');
			 //$facode = $this-> input-> post('facode');
			 $techniciancode = $this-> input-> post('techniciancode');
			   $year = $this-> input-> post('year');
			  
			  // $submitted_date = $this-> input-> post('submitted_date');				   
				//$area_name = $this-> input-> post('area_name');
				//$fk= $this-> input-> post('fk');
				$f3_total_population = $this-> input-> post('total_population');
				$f3_target_population = $this-> input-> post('target_population');
				$f3_session_type = $this-> input-> post('session_type');
				$f3_injections_per_year = $this-> input-> post('injections_per_year');
				$f3_injections_per_month = $this-> input-> post('injections_per_month');
				$f3_estimated_sessions = $this-> input-> post('estimated_sessions');
				$f3_sessions_per_month= $this-> input-> post('sessions_per_month');					
				$f3_actual_sessions_plan = $this-> input-> post('actual_sessions_plan');
				$f3_child_survival_interventions = $this-> input-> post('child_survival_interventions');
				$f3_hard_to_reach = $this-> input-> post('hard_to_reach');
				$f3_hard_to_reach_population = $this-> input-> post('hard_to_reach_population');
				/* $checkquery = "SELECT count(*) as recordnum from situation_analysis_db where year='$year' and techniciancode='$techniciancode'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
					$script  = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Cannot save data because data already exists for this Facility and Year!");';
					$script .= 'window.location="'. $location . '"';
					$script .= '</script>'; 
					echo "yes";		
					exit();
				} */

				//foreach($this-> input-> post('area_name') as $key=>$val){
					//$f3_hard_to_reach_population[$key] =(isset($this->input->post('hard_to_reach_population')[$key]) && ($this->input->post('hard_to_reach_population')[$key] != '')?$this->input->post('hard_to_reach_population')[$key]:0);
					//if(($f3_target_population[$key] > $f3_total_population[$key]) && ($f3_hard_to_reach_population[$key] > $f3_total_population[$key])){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Target Population and Hard to Reach Population are greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;		 */
					//	echo "HTR>TP";		
					//    exit();
					//}

					//if($f3_target_population[$key] > $f3_total_population[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Target Population is greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;	 */	
					//	echo "TP>TP";		
					//	exit();
				//	}

				//	if($f3_hard_to_reach_population[$key] > $f3_total_population[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Hard to Reach Population is greater than Total Population!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;	 */	
				//		echo "HRP>TP";		
					//	exit();
			//		}

				//	if($f3_actual_sessions_plan[$key] > $f3_sessions_per_month[$key]){
						/* $location = base_url().'red_microplan/Session_plan/session_plan_add/'.$facode.'/'.$year;
						$script  = '<script language="javascript" type="text/javascript">';
						$script .= 'alert("Cannot save data because Actual sessions planned is greater than Actual sessions planned!");';
						$script .= 'window.location="'. $location . '"';
						$script .= '</script>';
						echo $script;		 */
				//		echo "ASP>SPM";		
				///		exit();
				//	}
			//	}

				foreach($this->input->post('area_name') as $key=>$val){
					$recid = $this-> input-> post('recid')[$key];
					$addDataArray=array(
					 
						//'distcode' => $distcode,
						//'tcode' => $tcode,		   
					  // 'uncode' => $uncode,
					   //'facode' => $facode,
					   'techniciancode' => $techniciancode,
					   'year' => $year,
					  // 'submitted_date' => $submitted_date,
					//	'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						//'foreign_key' => (isset($fk[$key]) AND $fk[$key] != '')?$fk[$key]:NULL,
						'f3_total_population' => (isset($f3_total_population[$key]) AND $f3_total_population[$key] > 0)?$f3_total_population[$key]:0,
						'f3_target_population' => (isset($f3_target_population[$key]) AND $f3_target_population[$key] > 0)?$f3_target_population[$key]:0,
						'f3_session_type' => (isset($f3_session_type[$key]) AND $f3_session_type[$key] != '')?$f3_session_type[$key]:NULL,
						'f3_injections_per_year' => (isset($f3_injections_per_year[$key]) AND $f3_injections_per_year[$key] > 0)?$f3_injections_per_year[$key]:0,
						'f3_injections_per_month' => (isset($f3_injections_per_month[$key]) AND $f3_injections_per_month[$key] > 0)?$f3_injections_per_month[$key]:0,
						'f3_estimated_sessions' => (isset($f3_estimated_sessions[$key]) AND $f3_estimated_sessions[$key] > 0)?$f3_estimated_sessions[$key]:0,
						'f3_sessions_per_month' => (isset($f3_sessions_per_month[$key]) AND $f3_sessions_per_month[$key] > 0)?$f3_sessions_per_month[$key]:0,
						'f3_actual_sessions_plan' => (isset($f3_actual_sessions_plan[$key]) AND $f3_actual_sessions_plan[$key] > 0)?$f3_actual_sessions_plan[$key]:0,
						'f3_child_survival_interventions' => (isset($f3_child_survival_interventions[$key]) AND $f3_child_survival_interventions[$key] != '')?$f3_child_survival_interventions[$key]:NULL,
						'f3_hard_to_reach' => (isset($f3_hard_to_reach[$key]) AND $f3_hard_to_reach[$key] != '')?$f3_hard_to_reach[$key]:NULL,
						'f3_hard_to_reach_population' => (isset($f3_hard_to_reach_population[$key]) AND $f3_hard_to_reach_population[$key] > 0)?$f3_hard_to_reach_population[$key]:0,						
					);
//print_r($addDataArray); 
				$this-> Common_model-> update_record('situation_analysis_db',$addDataArray,array('techniciancode'=>$techniciancode,'year'=>$year,'recid'=>$recid));
			   }   //exit();
			  // $this-> session-> set_flashdata('message','You have successfully saved your record!'); 
			//	$location = base_url()."red_microplan/Situation_analysis/situation_analysis_list";
				//$location = base_url()."red_microplan/Red_strategy/red_strategy_add/".$facode."/".$year;
				//redirect($location);
				 $query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility, year from situation_analysis_db where techniciancode='$techniciancode' and year='$year' order by priority asc";
		            $result = $this-> db-> query($query);	
		            $data =	$result-> result_array();
		           
                     $myJSON = json_encode($data);
                  
                    echo $myJSON; 
			        //print_r($addDataArray);
			}
		}		
		public function session_plan_edit(){
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Session_plan_model-> session_plan_edit($facode,$year);
			$data['fileToLoad'] = 'red_microplanning/session_plan_edit';
			$data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}		
		public function session_plan_view(){			
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Session_plan_model-> session_plan_view($facode,$year);
		   $data['fileToLoad'] = 'red_microplanning/session_plan_view';
		   $data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
	}
?>