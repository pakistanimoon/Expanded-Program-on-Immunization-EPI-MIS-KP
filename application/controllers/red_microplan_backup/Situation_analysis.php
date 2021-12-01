<?php
	class Situation_analysis extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Situation_analysis_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
		}
		public function situation_analysis_list(){
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_list();
		   $data['fileToLoad'] = 'red_microplanning/situation_analysis_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
			
			print_r($data);exit;
			$this-> load-> view('template/epi_template',$data);
		}
		public function situation_analysis_add(){
			
			$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/situation_analysis_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function situation_analysis_save(){
			$edit = $this-> input-> post('edit');
			if ($edit != ''){
				$procode = $_SESSION["Province"];
				$distcode = $this -> session -> District;
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$facode = $this-> input-> post('facode');
				$year = $this-> input-> post('year');
				$submitted_date = $this-> input-> post('submitted_date');
				$updated_date = $this-> input-> post('updated_date');				   
				$area_name = $this-> input-> post('area_name');
				$less_one_year = $this-> input-> post('less_one_year');
				$penta1 = $this-> input-> post('penta1');
				$penta3= $this-> input-> post('penta3');					
				$measles = $this-> input-> post('measles');
				$tt2 = $this-> input-> post('tt2');
				$penta1_percent = $this-> input-> post('penta1_percent');
				$penta3_percent = $this-> input-> post('penta3_percent');
				$measles_percent = $this-> input-> post('measles_percent');
				$tt2_percent = $this-> input-> post('tt2_percent');
				$penta3_not = $this-> input-> post('penta3_not');
				$measles_not = $this-> input-> post('measles_not');
				$penta1penta3 = $this-> input-> post('penta1penta3');
				$penta1measles = $this-> input-> post('penta1measles');
				$access = $this-> input-> post('access');
				$utilization = $this-> input-> post('utilization');
				$category = $this-> input-> post('category');
				$priority = $this-> input-> post('priority');
				$recid = $this-> input-> post('recid');
				$recid_d = implode(",", $recid = $this-> input-> post('recid'));
				$query = "delete from situation_analysis_db where facode='$facode' and year='$year' and recid not in ($recid_d)";
				$result = $this-> db-> query($query);
				foreach($this-> input-> post('recid') as $key=>$val){
					$recid = (isset($val) AND $val > 0)?$val:0;
					$edit_array=array(
						'procode' => $procode,
						'distcode' => $distcode,
						'tcode' => $tcode,		   
					   'uncode' => $uncode,
					   'facode' => $facode,
					   'year' => $year,
					   'submitted_date' => $submitted_date,
					   'updated_date' => $updated_date,
						'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						'less_one_year' => (isset($less_one_year[$key]) AND $less_one_year[$key] > 0)?$less_one_year[$key]:0,
						'penta1' => (isset($penta1[$key]) AND $penta1[$key] > 0)?$penta1[$key]:0,
						'penta3' => (isset($penta3[$key]) AND $penta3[$key] > 0)?$penta3[$key]:0,
						'measles' => (isset($measles[$key]) AND $measles[$key] > 0)?$measles[$key]:0,
						'tt2' => (isset($tt2[$key]) AND $tt2[$key] > 0)?$tt2[$key]:0,
						'penta1_percent' => (isset($penta1_percent[$key]) AND $penta1_percent[$key] > 0)?$penta1_percent[$key]:0,
						'penta3_percent' => (isset($penta3_percent[$key]) AND $penta3_percent[$key] > 0)?$penta3_percent[$key]:0,
						'measles_percent' => (isset($measles_percent[$key]) AND $measles_percent[$key] >0)?$measles_percent[$key]:0,
						'tt2_percent' => (isset($tt2_percent[$key]) AND $tt2_percent[$key] > 0)?$tt2_percent[$key]:0,
						'penta3_not' => (isset($penta3_not[$key]) AND $penta3_not[$key] > 0)?$penta3_not[$key]:0,
						'measles_not' => (isset($measles_not[$key]) AND $measles_not[$key] > 0)?$measles_not[$key]:0,
						'penta1penta3' => (isset($penta1penta3[$key]) AND $penta1penta3[$key] > 0)?$penta1penta3[$key]:0,
						'penta1measles' => (isset($penta1measles[$key]) AND $penta1measles[$key] > 0)?$penta1measles[$key]:0,
						'access' => (isset($access[$key]) AND $access[$key] != '')?$access[$key]:NULL,
						'utilization' => (isset($utilization[$key]) AND $utilization[$key] != '')?$utilization[$key]:NULL,
						'category' => (isset($category[$key]) AND $category[$key] > 0)?$category[$key]:0,
						'priority' => (isset($priority[$key]) AND $priority[$key] > 0)?$priority[$key]:0,   
					);
					if ($recid > 0){
					
						$this-> Common_model-> update_record('situation_analysis_db',$edit_array,array('facode'=>$facode,'year'=>$year,'recid'=>$recid));
						
					}
					elseif($recid == 0 ) {
						
						$this-> Common_model-> insert_record('situation_analysis_db',$edit_array);
					}
				    
				}
		      $this-> session-> set_flashdata('message','You have successfully updated your record!'); 
				$location = base_url()."red_microplan/Special_activities/special_activities_edit/".$facode."/".$year;
				redirect($location);
			}////////////edit if end /////////////
			else{
				$distcode = $this -> session -> District;
			    $tcode = $this-> input-> post('tcode');				   
			    $uncode = $this-> input-> post('uncode');
			    $facode = $this-> input-> post('facode');
			    $year = $this-> input-> post('year');
			    $submitted_date = $this-> input-> post('submitted_date');				   
				$area_name = $this-> input-> post('area_name');
				$less_one_year = $this-> input-> post('less_one_year');
				$penta1 = $this-> input-> post('penta1');
				$penta3= $this-> input-> post('penta3');					
				$measles = $this-> input-> post('measles');
				$tt2 = $this-> input-> post('tt2');
				$penta1_percent = $this-> input-> post('penta1_percent');
				$penta3_percent = $this-> input-> post('penta3_percent');
				$measles_percent = $this-> input-> post('measles_percent');
				$tt2_percent = $this-> input-> post('tt2_percent');
				$penta3_not = $this-> input-> post('penta3_not');
				$measles_not = $this-> input-> post('measles_not');
				$penta1penta3 = $this-> input-> post('penta1penta3');
				$penta1measles = $this-> input-> post('penta1measles');
				$access = $this-> input-> post('access');
				$utilization = $this-> input-> post('utilization');
				$category = $this-> input-> post('category');
				$priority = $this-> input-> post('priority');
				$checkquery = "SELECT count(*) as recordnum from situation_analysis_db where year='$year' and facode='$facode'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					$location = base_url().'red_microplan/Situation_analysis/situation_analysis_list';
					$script  = '<script language="javascript" type="text/javascript">';
					$script .= 'alert("Cannot save data because data already exists for this Facility and Year!");';
					$script .= 'window.location="'. $location . '"';
					$script .= '</script>';
					echo $script;		
					exit();
				}
				
				foreach($this->input->post('area_name') as $key=>$val){
					$addDataArray=array(
						'distcode' => $distcode,
						'tcode' => $tcode,		   
					   'uncode' => $uncode,
					   'facode' => $facode,
					   'year' => $year,
					   'submitted_date' => $submitted_date,
						'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						'less_one_year' => (isset($less_one_year[$key]) AND $less_one_year[$key] > 0)?$less_one_year[$key]:0,
						'penta1' => (isset($penta1[$key]) AND $penta1[$key] > 0)?$penta1[$key]:0,
						'penta3' => (isset($penta3[$key]) AND $penta3[$key] > 0)?$penta3[$key]:0,
						'measles' => (isset($measles[$key]) AND $measles[$key] > 0)?$measles[$key]:0,
						'tt2' => (isset($tt2[$key]) AND $tt2[$key] > 0)?$tt2[$key]:0,
						'penta1_percent' => (isset($penta1_percent[$key]) AND $penta1_percent[$key] > 0)?$penta1_percent[$key]:0,
						'penta3_percent' => (isset($penta3_percent[$key]) AND $penta3_percent[$key] > 0)?$penta3_percent[$key]:0,
						'measles_percent' => (isset($measles_percent[$key]) AND $measles_percent[$key] >0)?$measles_percent[$key]:0,
						'tt2_percent' => (isset($tt2_percent[$key]) AND $tt2_percent[$key] > 0)?$tt2_percent[$key]:0,
						'penta3_not' => (isset($penta3_not[$key]) AND $penta3_not[$key] > 0)?$penta3_not[$key]:0,
						'measles_not' => (isset($measles_not[$key]) AND $measles_not[$key] > 0)?$measles_not[$key]:0,
						'penta1penta3' => (isset($penta1penta3[$key]) AND $penta1penta3[$key] > 0)?$penta1penta3[$key]:0,
						'penta1measles' => (isset($penta1measles[$key]) AND $penta1measles[$key] > 0)?$penta1measles[$key]:0,
						'access' => (isset($access[$key]) AND $access[$key] != '')?$access[$key]:NULL,
						'utilization' => (isset($utilization[$key]) AND $utilization[$key] != '')?$utilization[$key]:NULL,
						'category' => (isset($category[$key]) AND $category[$key] > 0)?$category[$key]:0,
						'priority' => (isset($priority[$key]) AND $priority[$key] > 0)?$priority[$key]:0,  
					);
	
					$this-> Common_model-> insert_record('situation_analysis_db',$addDataArray);
			   }   
			   $this-> session-> set_flashdata('message','You have successfully saved your record!'); 
				//$location = base_url()."red_microplan/Situation_analysis/situation_analysis_list";
				$location = base_url()."red_microplan/Special_activities/special_activities_add/".$facode."/".$year;
				redirect($location);
			}
		}		
		public function situation_analysis_edit(){
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_edit($facode,$year);
			$data['fileToLoad'] = 'red_microplanning/situation_analysis_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}		
		public function situation_analysis_view(){			
			$facode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_view($facode,$year);
		   $data['fileToLoad'] = 'red_microplanning/situation_analysis_view';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}
			public function situation_main(){
				
			//print('test');exit;
			$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/situation_main';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}

	}
?>
