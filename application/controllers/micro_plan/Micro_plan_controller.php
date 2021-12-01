<?php
//live
	class micro_plan_controller extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this->load->model('Micro_plan_model','micro');
			authentication();
			$this -> load -> helper('epi_functions_helper'); 
		}
		public function supervisory_plan_add(){
			//$query = "select id,type from campaign_purpose order by type asc";
			//$result = $this->db->query($query);
			$data['data'] =	"";//$result->result_array();
			$data['fileToLoad'] = 'micro_plan/supervisory_plan_add';
			$data['pageTitle']='Micro Plan | EPI-MIS';
			$this->load->view('template/epi_template',$data);	
		}
		public function supervisory_plan_save(){
			//print_r($_POST);exit;
			$idm1=$this->input->post('idm1');
			$idm2=$this->input->post('idm2');
			$idm3=$this->input->post('idm3');
			$conduct=$this->input->post('conduct');
			$edit=$this->input->post('edit');
			//print_r($edit); exit;
			if($conduct == "conduct"){
				$supervisorcode = $this->input->post('supervisor_name');
				$quarter= $this->input->post('quarter');
				//get data for m1
				$uncodem1= $this->input->post('uncodem1');
				$monthdate1= $this->input->post('monthm1');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm1=$year.'-'.$monthdate1;
				$conductedm1=$this->input->post('conductedm1');
				$conduct_datem1=$this->input->post('conduct_datem1');
				$conduct_remarksm1 = $this->input->post('conduct_remarksm1');
				$statusm1 = $this->input->post('statusm1');
				//get data for m2
				$uncodem2= $this->input->post('uncodem2');
				$monthdate2= $this->input->post('monthm2');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm2=$year.'-'.$monthdate2;
				$conductedm2=$this->input->post('conductedm2');
				$conduct_datem2=$this->input->post('conduct_datem2');
				$conduct_remarksm2 = $this->input->post('conduct_remarksm2');
				$statusm2 = $this->input->post('statusm2');
				//get data for m3
				$uncodem3= $this->input->post('uncodem3');
				$monthdate3= $this->input->post('monthm3');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm3=$year.'-'.$monthdate3;
				$conductedm3=$this->input->post('conductedm3');
				$conduct_datem3=$this->input->post('conduct_datem3');
				$conduct_remarksm3 = $this->input->post('conduct_remarksm3');
				$statusm3 = $this->input->post('statusm3');
				//foreach for m1
				foreach($this->input->post('conductedm1') as $key=>$val){
					//print_r($val); exit;
					$idm1=$this->input->post('idm1')[$key];
						$conduct_array=array(
						    'is_conducted' => (isset($conductedm1[$key]) AND $conductedm1[$key]>0)?$conductedm1[$key]:'0',
							'conduct_date' => (isset($conduct_datem1[$key]) AND $conduct_datem1[$key] > 0)?$conduct_datem1[$key]:NULL,
							'status' => (isset($statusm1[$key]) AND $statusm1[$key] > 0)?$statusm1[$key]:'0',
							'conduct_remarks' => (isset($conduct_remarksm1[$key]) AND $conduct_remarksm1[$key] !="")?$conduct_remarksm1[$key]:NULL,  
						);
                        //print_r($conduct_array); //exit;						
						$this-> Common_model-> update_record('supervisory_plan',$conduct_array,array('supervisorcode'=>$supervisorcode,'id'=>$idm1));		         
			    }
					//foreach for m2
				foreach($this->input->post('conductedm2') as $key=>$val){
					$idm2=$this->input->post('idm2')[$key];
						$conduct_array=array(
						    'is_conducted' => (isset($conductedm2[$key]) AND $conductedm2[$key]>0)?$conductedm2[$key]:'0',
							'conduct_date' => (isset($conduct_datem2[$key]) AND $conduct_datem2[$key] > 0)?$conduct_datem2[$key]:NULL,
							'status' => (isset($statusm2[$key]) AND $statusm2[$key] > 0)?$statusm2[$key]:'0',
							'conduct_remarks' => (isset($conduct_remarksm2[$key]) AND $conduct_remarksm2[$key] !="")?$conduct_remarksm2[$key]:NULL,  
						);
                        //print_r($conduct_array); //exit;						
						$this-> Common_model-> update_record('supervisory_plan',$conduct_array,array('supervisorcode'=>$supervisorcode,'id'=>$idm2));		         
			    }
					//foreach for m3
				foreach($this->input->post('conductedm3') as $key=>$val){
					$idm3=$this->input->post('idm3')[$key];
						$conduct_array=array(
						    'is_conducted' => (isset($conductedm3[$key]) AND $conductedm3[$key]>0)?$conductedm3[$key]:'0',
							'conduct_date' => (isset($conduct_datem3[$key]) AND $conduct_datem3[$key] > 0)?$conduct_datem3[$key]:NULL,
							'status' => (isset($statusm3[$key]) AND $statusm3[$key] > 0)?$statusm3[$key]:'0',
							'conduct_remarks' => (isset($conduct_remarksm3[$key]) AND $conduct_remarksm3[$key] !="")?$conduct_remarksm3[$key]:NULL,  
						);
                       // print_r($conduct_array);exit; 						
						$this-> Common_model-> update_record('supervisory_plan',$conduct_array,array('supervisorcode'=>$supervisorcode,'id'=>$idm3));		         
			    }
				         $this -> session -> set_flashdata('message','You have successfully Updated your record!'); 
						$location = base_url()."micro_plan/Micro_plan_controller/supervisory_plan";
						redirect($location);
			}elseif ($edit  == "edit"){
			//	echo("delet and insert");exit;
			    $procode = $this -> session -> Province;
			    $distcode = $this-> session-> District; 
				$supervisor_type = $this->input->post('supervisor_type');
				$supervisorcode = $this->input->post('supervisor_name');
				$quarter= $this->input->post('quarter');
				//get data for m1
		        $uncodem1= $this->input->post('uncodem1');
				$monthdate1= $this->input->post('monthm1');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm1=$year.'-'.$monthdate1;
				//print_r($fmonthm1);
				$sessionm1 = $this->input->post('sessionm1');
				$datem1 = $this->input->post('datedm1');
				//$conducted = $this->input->post('conducted');
				$remarksm1 = $this->input->post('remarksm1');
				$facodem1 = $this->input->post('vilage_hf_namem1');

			    //get data for m2
				$uncodem2= $this->input->post('uncodem2');
				$monthdate2= $this->input->post('monthm2');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm2=$year.'-'.$monthdate2;
				//print_r($fmonthm2);
				$sessionm2 = $this->input->post('sessionm2');
				$datem2 = $this->input->post('datedm2');
				$remarksm2 = $this->input->post('remarksm2');
				$facodem2 = $this->input->post('vilage_hf_namem2');
		
				//get data for m3
				$uncodem3= $this->input->post('uncodem3');
				$monthdate3= $this->input->post('monthm3');
				$year = $this->input->post('date_year');
				$month= $this->input->post('date_month');
				$fmonthm3=$year.'-'.$monthdate3;
				//print_r($fmonthm3); exit;
				$sessionm3 = $this->input->post('sessionm3');
				$datem3 = $this->input->post('datedm3');
				$remarksm3 = $this->input->post('remarksm3');
				$facodem3 = $this->input->post('vilage_hf_namem3');
				
				//delete for m1
			    $query1 = "delete from supervisory_plan where supervisorcode='$supervisorcode' AND fmonth='$fmonthm1'";
		        $resm1 = $this->db->query($query1);
				//delete for m2
				$query2 = "delete from supervisory_plan where supervisorcode='$supervisorcode' AND fmonth='$fmonthm2'";
		        $resm2 = $this->db->query($query2);
				//$str = $this->db->last_query();
		        //print_r($str); exit;
				//delete for m3
				$query3 = "delete from supervisory_plan where supervisorcode='$supervisorcode' AND fmonth='$fmonthm3'";
		        $resm3 = $this->db->query($query3);
				//foreach for m1
				foreach($this->input->post('sessionm1') as $key=>$val){
						$add_array=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'designation' => $supervisor_type,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem1[$key]) AND $uncodem1[$key] !="")?$uncodem1[$key]:NULL,
							//'monthdate' => $monthdate1,
							'fmonth' => $fmonthm1,
							'session_type' => (isset($sessionm1[$key]) AND $sessionm1[$key] !="")?$sessionm1[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem1[$key]) AND $facodem1[$key] !="")?$facodem1[$key]:NULL,
							'planned_date' => (isset($datem1[$key]) AND $datem1[$key] > 0)?$datem1[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key]>0)?$conducted[$key]:'0',
							'remarks' => (isset($remarksm1[$key]) AND $remarksm1[$key] !="")?$remarksm1[$key]:NULL,  
						);
					    
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
			            //print_r($add_array);//exit;
				}
				//foreach for m2
				foreach($this->input->post('sessionm2') as $key=>$val){
						$add_array=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'designation' => $supervisor_type,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem2[$key]) AND $uncodem2[$key] !="")?$uncodem2[$key]:NULL,
							//'monthdate' => $monthdate2,
							'fmonth' => $fmonthm2,
							'session_type' => (isset($sessionm2[$key]) AND $sessionm2[$key] !="")?$sessionm2[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem2[$key]) AND $facodem2[$key] !="")?$facodem2[$key]:NULL,
							'planned_date' => (isset($datem2[$key]) AND $datem2[$key] > 0)?$datem2[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key]>0)?$conducted[$key]:'0',
							'remarks' => (isset($remarksm2[$key]) AND $remarksm2[$key] !="")?$remarksm2[$key]:NULL,  
						);
					    
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
			            //print_r($add_array);//exit;
				}
				//foreach for m3
				foreach($this->input->post('sessionm3') as $key=>$val){
						$add_array=array(
						    'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'designation' => $supervisor_type,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem3[$key]) AND $uncodem3[$key] !="")?$uncodem3[$key]:NULL,
							//'monthdate' => $monthdate3,
							'fmonth' => $fmonthm3,
							'session_type' => (isset($sessionm3[$key]) AND $sessionm3[$key] !="")?$sessionm3[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem3[$key]) AND $facodem3[$key] !="")?$facodem3[$key]:NULL,
							'planned_date' => (isset($datem3[$key]) AND $datem3[$key] > 0)?$datem3[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key]>0)?$conducted[$key]:'0',
							'remarks' => (isset($remarksm3[$key]) AND $remarksm3[$key] !="")?$remarksm3[$key]:NULL,  
						);
					    
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
			           //print_r($add_array);//exit;
				}
				//exit;
				         $this -> session -> set_flashdata('message','You have successfully Updated your record!'); 
						$location = base_url()."micro_plan/Micro_plan_controller/supervisory_plan";
						redirect($location);
			}
		 else {
					$distcode = $this-> session->District;
					$supervisorcode = $this->input->post('supervisor_name');
					$quarter= $this->input->post('quarter');
				    $year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$monthdatem1= $this->input->post('monthm1');
					$fmonthm1=$year.'-'.$monthdatem1;
					$query1 = "select fmonth,quarter,supervisorcode from supervisory_plan where quarter='$quarter' and fmonth like '$year%'  AND distcode='$distcode' and supervisorcode='$supervisorcode'";
		            $result = $this->db->query($query1);
			        $data1['fmonth'] =	$result->result_array();
					//$str = $this->db->last_query();
		            //print_r($str); exit; 
					//get for m2
					/* $distcode = $this-> session->District;
					$supervisorcode = $this->input->post('supervisor_name');
					$quarter= $this->input->post('quarter');
				    $year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$monthdatem2= $this->input->post('monthm2');
					$fmonthm2=$year.'-'.$monthdatem2;
					$query2 = "select fmonth from supervisory_plan where quarter='$quarter' and fmonth like '$year%'  AND distcode='$distcode' and supervisorcode='$supervisorcode'";
		            $result = $this->db->query($query2);
			        $data2['fmonth'] =	$result->result_array();
					//get for m3
					$distcode = $this-> session->District;
					$supervisorcode = $this->input->post('supervisor_name');
					$quarter= $this->input->post('quarter');
				    $year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$monthdatem3= $this->input->post('monthm3');
					$fmonthm3=$year.'-'.$monthdatem3;
					$query3 = "select fmonth from supervisory_plan where quarter='$quarter' and fmonth like '$year%'  AND distcode='$distcode' and supervisorcode='$supervisorcode'";
		            $result = $this->db->query($query3);
			        $data3['fmonth'] =	$result->result_array(); */
					//$str = $this->db->last_query();
		           //print_r($str); exit; 
				if(!empty($data1['fmonth'])){
				    $this -> session -> set_flashdata('message','This date record is already inserted<br> You just Edit this date record!'); 
					$location = base_url()."micro_plan/Micro_plan_controller/supervisory_plan_add";
					redirect($location);
					
			    }
				else{
				    //get data for m1
					$procode = $this -> session -> Province;
					$distcode = $this-> session-> District; 
					$supervisor_type = $this->input->post('supervisor_type');
					$supervisorcode = $this->input->post('supervisor_name');
					$quarter= $this->input->post('quarter');
					$uncodem1= $this->input->post('uncodem1');
				    $monthdate1= $this->input->post('monthm1');
					$year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$fmonthm1=$year.'-'.$monthdate1;
					$sessionm1 = $this->input->post('sessionm1');
					$datem1 = $this->input->post('datedm1');
					$remarksm1 = $this->input->post('remarksm1');
					$facodem1 = $this->input->post('vilage_hf_namem1');
					//get data for m2
					$uncodem2= $this->input->post('uncodem2');
				    $monthdate2= $this->input->post('monthm2');
					$year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$fmonthm2=$year.'-'.$monthdate2;
					$sessionm2 = $this->input->post('sessionm2');
					$datem2 = $this->input->post('datedm2');
					$remarksm2 = $this->input->post('remarksm2');
					$facodem2 = $this->input->post('vilage_hf_namem2');
					//get data for m3
					$uncodem3= $this->input->post('uncodem3');
				    $monthdate3= $this->input->post('monthm3');
					$year = $this->input->post('date_year');
					$month= $this->input->post('date_month');
					$fmonthm3=$year.'-'.$monthdate3;
					$sessionm3 = $this->input->post('sessionm3');
					$datem3 = $this->input->post('datedm3');
					$remarksm3 = $this->input->post('remarksm3');
					$facodem3 = $this->input->post('vilage_hf_namem3');
					//foreach for m1
					foreach($this->input->post('sessionm1') as $key=>$val){
						$add_array=array(
							'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem1[$key]) AND $uncodem1[$key] !="")?$uncodem1[$key]:NULL,
							//'monthdate' => $monthdate1,
							'designation' => $supervisor_type,
							'fmonth' => $fmonthm1,
							'session_type' => (isset($sessionm1[$key]) AND $sessionm1[$key] !="")?$sessionm1[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem1[$key]) AND $facodem1[$key]  !="" )?$facodem1[$key]:NULL,
							'planned_date' => (isset($datem1[$key]) AND $datem1[$key] > 0)?$datem1[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key] > 0)?$conducted[$key]:NULL,
							'remarks' => (isset($remarksm1[$key]) AND $remarksm1[$key] !="")?$remarksm1[$key]:NULL,  
						);
						//print_r($add_array);
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
				    } 
					//foreach for m2
						foreach($this->input->post('sessionm2') as $key=>$val){
						$add_array=array(
							'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem2[$key]) AND $uncodem2[$key] !="")?$uncodem2[$key]:NULL,
							//'monthdate' => $monthdate2,
							'designation' => $supervisor_type,
							'fmonth' => $fmonthm2,
							'session_type' => (isset($sessionm2[$key]) AND $sessionm2[$key] !="")?$sessionm2[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem2[$key]) AND $facodem2[$key]  !="" )?$facodem2[$key]:NULL,
							'planned_date' => (isset($datem2[$key]) AND $datem2[$key] > 0)?$datem2[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key] > 0)?$conducted[$key]:NULL,
							'remarks' => (isset($remarksm2[$key]) AND $remarksm2[$key] !="")?$remarksm2[$key]:NULL,  
						);
						//print_r($add_array);
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
				    } 
					//foreach for m3
						foreach($this->input->post('sessionm3') as $key=>$val){
						$add_array=array(
							'procode' => $procode,
						    'distcode' => $distcode,
							'supervisorcode' => $supervisorcode,
							'quarter' => $quarter,
							'uncode'=>(isset($uncodem3[$key]) AND $uncodem3[$key] !="")?$uncodem3[$key]:NULL,
							//'monthdate' => $monthdate3,
							'designation' => $supervisor_type,
							'fmonth' => $fmonthm3,
							'session_type' => (isset($sessionm3[$key]) AND $sessionm3[$key] !="")?$sessionm3[$key]:NULL,
							//'site_name' => (isset($vilage_name[$key]) AND $vilage_name[$key] !="")?$vilage_name[$key]:NULL,
							'area_name' => (isset($facodem3[$key]) AND $facodem3[$key]  !="" )?$facodem3[$key]:NULL,
							'planned_date' => (isset($datem3[$key]) AND $datem3[$key] > 0)?$datem3[$key]:NULL,
							//'is_conducted' => (isset($conducted[$key]) AND $conducted[$key] > 0)?$conducted[$key]:NULL,
							'remarks' => (isset($remarksm3[$key]) AND $remarksm3[$key] !="")?$remarksm3[$key]:NULL,  
						);
					    //print_r($add_array);
						$this -> Common_model -> insert_record('supervisory_plan',$add_array);
				    } 

					//exit;
					    $this -> session -> set_flashdata('message','You have successfully saved your record!'); 
						$location = base_url()."micro_plan/Micro_plan_controller/supervisory_plan_add";
						redirect($location);
				}
			}
				
	}
		public function supervisory_plan_edit(){
			//$fmonth = $this->input->get_post('fmonth');
			$supervisorcode = $this -> uri -> segment(4);
			//echo($supervisorcode);exit;
		     
			 $quarter   = $this -> uri -> segment(5);
			 $fmonth   = $this -> uri -> segment(6);
            //  echo($facode);exit;
			 $data['data'] =$this->micro->supervisory_plan_edit($supervisorcode,$quarter,$fmonth);
			 $monthYear = explode("-", $fmonth);
		     $data['year'] = $monthYear[0];
		    // $data['month'] = $monthYear[1];  
			//print_r($data);exit;
		    $data['fileToLoad'] = 'micro_plan/supervisory_plan_edit';
		    $data['pageTitle']='Micro Plan | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		public function supervisory_plan_conducted(){
			//$fmonth = $this->input->get('fmonth');
			$supervisorcode = $this -> uri -> segment(4);
			//echo($supervisorcode);exit;
			$quarter   = $this -> uri -> segment(5);
			$fmonth   = $this -> uri -> segment(6);
            //  echo($facode);exit;
			 $data['data'] =$this->micro->supervisory_plan_conducted($supervisorcode,$quarter,$fmonth);
			 $monthYear = explode("-", $fmonth);
		     $data['year'] = $monthYear[0];
		     //$data['month'] = $monthYear[1];
			//print_r($data);exit;
		    $data['fileToLoad'] = 'micro_plan/supervisory_plan_conducted';
		    $data['pageTitle']='Micro Plan | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		public function supervisory_plan(){
			$data['data'] =$this->micro->supervisory_plan();
			//print_r($data);exit;
		    $data['fileToLoad'] = 'micro_plan/supervisory_plan';
		    $data['pageTitle']='Micro Plan | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		public function supervisory_plan_view(){
			
			$supervisorcode = $this -> uri -> segment(4);
			$quarter   = $this -> uri -> segment(5);
		    //$fmonth   = $this -> uri -> segment(6);
			$data['filter_view'] = $this -> uri -> segment(6);
            /* $monthYear = explode("-", $fmonth);
		    $data['month'] = $monthYear[0];
		    $data['year'] = $monthYear[1]; */
			$data['data'] =$this->micro->supervisory_plan_view($supervisorcode,$quarter);
			//$monthYear = explode("-", $fmonth);
		    //$data['year'] = $monthYear[0];
		    $data['fileToLoad'] = 'micro_plan/supervisory_plan_view';
		    $data['pageTitle']='Micro Plan | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
		
		
		
		
		
	}
?>