<?php
	class Red_strategy extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Red_strategy_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
		}
		public function red_strategy_list(){
			$data['data'] = $this-> Red_strategy_model-> red_strategy_list();
		   $data['fileToLoad'] = 'red_microplanning/red_strategy_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
		public function red_strategy_add(){
			//$facode = $this-> uri -> segment(4);
		    //$year = $this-> uri -> segment(5);
			//$data['data'] = $this-> Red_strategy_model-> red_strategy_add($facode,$year);
			//print_r($data['data']);exit();
			$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/red_strategy_add';
			$data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function red_strategy_save(){
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
				//print_r($_POST); exit();
				$procode = $_SESSION["Province"];
				$distcode = $this -> session -> District;
			   $tcode = $this-> input-> post('tcode');				   
			   $uncode = $this-> input-> post('uncode');
			   $facode = $this-> input-> post('facode');
			   $year = $this-> input-> post('year');
			   $submitted_date = $this-> input-> post('submitted_date');
			   $updated_date = $this-> input-> post('updated_date');	
			   //for r1
				$problems_r1_c1 = $this-> input-> post('problems_r1_c1');
				$actlimitres_r1_c2 = $this-> input-> post('actlimitres_r1_c2');
				$actneedresources_r1_c3 = $this-> input-> post('actneedresources_r1_c3');
				$date_r1_c4 = $this-> input-> post('date_r1_c4');
				$area_r1_c5 = $this-> input-> post('area_r1_c5');
				$person_r1_c6 = $this-> input-> post('person_r1_c6');
				//for r2
				$problems_r2_c1 = $this-> input-> post('problems_r2_c1');
				$actlimitres_r2_c2 = $this-> input-> post('actlimitres_r2_c2');
				$actneedresources_r2_c3 = $this-> input-> post('actneedresources_r2_c3');
				$date_r2_c4 = $this-> input-> post('date_r2_c4');
				$area_r2_c5 = $this-> input-> post('area_r2_c5');
				$person_r2_c6 = $this-> input-> post('person_r2_c6');
				//for r3
				$problems_r3_c1 = $this-> input-> post('problems_r3_c1');
				$actlimitres_r3_c2 = $this-> input-> post('actlimitres_r3_c2');
				$actneedresources_r3_c3 = $this-> input-> post('actneedresources_r3_c3');
				$date_r3_c4 = $this-> input-> post('date_r3_c4');
				$area_r3_c5 = $this-> input-> post('area_r3_c5');
				$person_r3_c6 = $this-> input-> post('person_r3_c6');
				//for r4
				$problems_r4_c1 = $this-> input-> post('problems_r4_c1');
				$actlimitres_r4_c2 = $this-> input-> post('actlimitres_r4_c2');
				$actneedresources_r4_c3 = $this-> input-> post('actneedresources_r4_c3');
				$date_r4_c4 = $this-> input-> post('date_r4_c4');
				$area_r4_c5 = $this-> input-> post('area_r4_c5');
				$person_r4_c6 = $this-> input-> post('person_r4_c6');
				//for r5
				$problems_r5_c1 = $this-> input-> post('problems_r5_c1');
				$actlimitres_r5_c2 = $this-> input-> post('actlimitres_r5_c2');
				$actneedresources_r5_c3 = $this-> input-> post('actneedresources_r5_c3');
				$date_r5_c4 = $this-> input-> post('date_r5_c4');
				$area_r5_c5 = $this-> input-> post('area_r5_c5');
				$person_r5_c6 = $this-> input-> post('person_r5_c6');			 

				$this-> Common_model-> delete_record_multiple_colum('red_strategy_db',array('facode'=>$facode,'year'=>$year));
			   
				$edit_array=array(
					'distcode' => $distcode,
					'tcode' => $tcode,		   
				   'uncode' => $uncode,
				   'facode' => $facode,
				   'year' => $year,
				   'submitted_date' => $submitted_date,
				   'updated_date' => $updated_date
				);
				for($i=1; $i<=5; $i++){					
					$edit_array['problems_r'.$i.'_c1'] = (isset(${'problems_r'.$i.'_c1'}) AND ${'problems_r'.$i.'_c1'} != '')?${'problems_r'.$i.'_c1'}:NULL;
					$edit_array['actlimitres_r'.$i.'_c2'] = (isset(${'actlimitres_r'.$i.'_c2'}) AND ${'actlimitres_r'.$i.'_c2'} != '')?${'actlimitres_r'.$i.'_c2'}:NULL;
					$edit_array['actneedresources_r'.$i.'_c3'] = (isset(${'actneedresources_r'.$i.'_c3'}) AND ${'actneedresources_r'.$i.'_c3'} != '')?${'actneedresources_r'.$i.'_c3'}:NULL;
					$edit_array['date_r'.$i.'_c4'] = (isset(${'date_r'.$i.'_c4'}) AND ${'date_r'.$i.'_c4'} != '')?date('Y-m-d', strtotime(${'date_r'.$i.'_c4'})):NULL;
					$edit_array['area_r'.$i.'_c5'] = (isset(${'area_r'.$i.'_c5'}) AND ${'area_r'.$i.'_c5'} != '')?${'area_r'.$i.'_c5'}:NULL;
					$edit_array['person_r'.$i.'_c6'] = (isset(${'person_r'.$i.'_c6'}) AND ${'person_r'.$i.'_c6'} != '')?${'person_r'.$i.'_c6'}:NULL;
				}
				
				//print_r($edit_array);exit();
				$this-> Common_model-> insert_record('red_strategy_db',$edit_array);
		      $this-> session-> set_flashdata('message','You have successfully updated your record!'); 
				$location = base_url()."red_microplan/Red_strategy/red_strategy_list";
			//$location = base_url()."red_microplan/Facility_quarterplan/hf_quarterplan_edit/".$facode."/".$year;
				redirect($location);
			}
			else{
				//print_r($_POST); exit();
				$distcode = $this -> session -> District;
			   $tcode = $this-> input-> post('tcode');				   
			   $uncode = $this-> input-> post('uncode');
			   $facode = $this-> input-> post('facode');
			   $year = $this-> input-> post('year');
			   $submitted_date = $this-> input-> post('submitted_date');
			   //for r1
				$problems_r1_c1 = $this-> input-> post('problems_r1_c1');
				$actlimitres_r1_c2 = $this-> input-> post('actlimitres_r1_c2');
				$actneedresources_r1_c3 = $this-> input-> post('actneedresources_r1_c3');
				$date_r1_c4 = $this-> input-> post('date_r1_c4');
				$area_r1_c5 = $this-> input-> post('area_r1_c5');
				$person_r1_c6 = $this-> input-> post('person_r1_c6');
				//for r2
				$problems_r2_c1 = $this-> input-> post('problems_r2_c1');
				$actlimitres_r2_c2 = $this-> input-> post('actlimitres_r2_c2');
				$actneedresources_r2_c3 = $this-> input-> post('actneedresources_r2_c3');
				$date_r2_c4 = $this-> input-> post('date_r2_c4');
				$area_r2_c5 = $this-> input-> post('area_r2_c5');
				$person_r2_c6 = $this-> input-> post('person_r2_c6');
				//for r3
				$problems_r3_c1 = $this-> input-> post('problems_r3_c1');
				$actlimitres_r3_c2 = $this-> input-> post('actlimitres_r3_c2');
				$actneedresources_r3_c3 = $this-> input-> post('actneedresources_r3_c3');
				$date_r3_c4 = $this-> input-> post('date_r3_c4');
				$area_r3_c5 = $this-> input-> post('area_r3_c5');
				$person_r3_c6 = $this-> input-> post('person_r3_c6');
				//for r4
				$problems_r4_c1 = $this-> input-> post('problems_r4_c1');
				$actlimitres_r4_c2 = $this-> input-> post('actlimitres_r4_c2');
				$actneedresources_r4_c3 = $this-> input-> post('actneedresources_r4_c3');
				$date_r4_c4 = $this-> input-> post('date_r4_c4');
				$area_r4_c5 = $this-> input-> post('area_r4_c5');
				$person_r4_c6 = $this-> input-> post('person_r4_c6');
				//for r5
				$problems_r5_c1 = $this-> input-> post('problems_r5_c1');
				$actlimitres_r5_c2 = $this-> input-> post('actlimitres_r5_c2');
				$actneedresources_r5_c3 = $this-> input-> post('actneedresources_r5_c3');
				$date_r5_c4 = $this-> input-> post('date_r5_c4');
				$area_r5_c5 = $this-> input-> post('area_r5_c5');
				$person_r5_c6 = $this-> input-> post('person_r5_c6');				

				$checkquery = "SELECT count(*) as recordnum from red_strategy_db where year='$year' and facode='$facode'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					$location = base_url().'red_microplan/Red_strategy/red_strategy_list';
					$script  = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Cannot save data because data already exists for this Facility and Year!");';
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
				   'submitted_date' => $submitted_date
				);
				for($i=1; $i<=5; $i++){					
					$addDataArray['problems_r'.$i.'_c1'] = (isset(${'problems_r'.$i.'_c1'}) AND ${'problems_r'.$i.'_c1'} != '')?${'problems_r'.$i.'_c1'}:NULL;
					$addDataArray['actlimitres_r'.$i.'_c2'] = (isset(${'actlimitres_r'.$i.'_c2'}) AND ${'actlimitres_r'.$i.'_c2'} != '')?${'actlimitres_r'.$i.'_c2'}:NULL;
					$addDataArray['actneedresources_r'.$i.'_c3'] = (isset(${'actneedresources_r'.$i.'_c3'}) AND ${'actneedresources_r'.$i.'_c3'} != '')?${'actneedresources_r'.$i.'_c3'}:NULL;
					$addDataArray['date_r'.$i.'_c4'] = (isset(${'date_r'.$i.'_c4'}) AND ${'date_r'.$i.'_c4'} != '')?date('Y-m-d', strtotime(${'date_r'.$i.'_c4'})):NULL;
					$addDataArray['area_r'.$i.'_c5'] = (isset(${'area_r'.$i.'_c5'}) AND ${'area_r'.$i.'_c5'} != '')?${'area_r'.$i.'_c5'}:NULL;
					$addDataArray['person_r'.$i.'_c6'] = (isset(${'person_r'.$i.'_c6'}) AND ${'person_r'.$i.'_c6'} != '')?${'person_r'.$i.'_c6'}:NULL;
				}
			 $this-> Common_model-> insert_record('red_strategy_db',$addDataArray);
			   $this-> session-> set_flashdata('message','You have successfully saved your record!'); 
				$location = base_url()."red_microplan/Red_strategy/red_strategy_list";
				//$location = base_url()."red_microplan/Facility_quarterplan/hf_quarterplan_add/".$facode."/".$year;
				redirect($location);
			}
		}		
		public function red_strategy_edit(){
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Red_strategy_model-> red_strategy_edit($facode,$year);
			$data['fileToLoad'] = 'red_microplanning/red_strategy_edit';
			$data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}		
		public function red_strategy_view(){			
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Red_strategy_model-> red_strategy_view($facode,$year);
		   $data['fileToLoad'] = 'red_microplanning/red_strategy_view';
		   $data['pageTitle']='RED/REC Micro Plannning | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		}
	}
?>