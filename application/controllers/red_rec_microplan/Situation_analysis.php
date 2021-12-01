<?php
	class Situation_analysis extends CI_Controller{
		//================ Constructor function starts==================//
		public function __construct(){
			parent::__construct();
			$this-> load-> model('red_microplan/Situation_analysis_model');
			authentication();
			$this-> load-> helper('epi_functions_helper'); 
			$this-> load-> helper('epi_reports_helper'); 
		}
		public function situation_analysis_list(){
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_list();
		   $data['fileToLoad'] = 'Add_red_microplanning/situation_analysis_list';
		   $data['pageTitle'] = 'Red Micro Plannning | EPI-MIS';
		//print_r($data);exit;
			$this-> load-> view('template/epi_template',$data);
			
		}
	/*	public function situation_analysis_add(){
			$data['data'] =	"";
			$data['fileToLoad'] = 'red_microplanning/situation_analysis_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}*/
		public function situation_analysis_save(){
			//print_r($_POST);exit;
			
			$edit = $this-> input-> post('edit');
			//$recid = $this-> input-> post('recid');
			$add_edit = $this-> input-> post('add_edit');
			//print_r($add_edit);exit;
			if ($edit != '' || $add_edit != '' ){
				if ($edit != '' ){
					
				$tcode = $this-> input-> post('ticode');				   
				$uncode = $this-> input-> post('unicode');
				$facode = $this-> input-> post('facode');
				$techniciancode = $this-> input-> post('techniciancode');
				}
				elseif($add_edit  != '' ){
					
				$tcode = $this-> input-> post('tcode');				   
				$uncode = $this-> input-> post('uncode');
				$facode = $this-> input-> post('facode');
				$techniciancode = $this-> input-> post('techniciancode');
				}
			
				
				$procode = $_SESSION["Province"];
				$distcode = $this -> session -> District;
				$year = $this-> input-> post('year');
				$submitted_date = $this-> input-> post('submitted_date');
				$updated_date = $this-> input-> post('updated_date');				   
				$area_name = $this-> input-> post('area_name');
				$less_one_year = $this-> input-> post('less_one_year');
				$f3_total_population = $this-> input-> post('f3_total_population');
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
				$query = "delete from situation_analysis_db where facode='$facode' and techniciancode='$techniciancode' and year='$year' and recid not in ($recid_d)";
				//print($query);exit;
				$result = $this-> db-> query($query);
				foreach($this-> input-> post('recid') as $key=>$val){
					$recid = (isset($val) AND $val > 0)?$val:0;
					$edit_array=array(
						'procode' => $procode,
						'distcode' => $distcode,
					  'tcode' => $tcode,		   
					  'uncode' => $uncode,
					  'facode' => $facode,
					   'techniciancode' => $techniciancode,
					   'year' => $year,
					   'submitted_date' => $submitted_date,
					   'updated_date'=>date("Y-m-d"),
						'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						'less_one_year' => (isset($less_one_year[$key]) AND $less_one_year[$key] > 0)?$less_one_year[$key]:0,
						'f3_total_population' => (isset($f3_total_population[$key]) AND $f3_total_population[$key] > 0)?$f3_total_population[$key]:0,
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
					//print_r($edit_array);
				 if ($recid > 0){
					// print_r($edit_array);
					  //print('exit1');//exit;
						$this-> Common_model-> update_record('situation_analysis_db',$edit_array,array('techniciancode'=>$techniciancode,'year'=>$year,'recid'=>$recid));
						
					}
					elseif($recid == 0 ) {
						//print_r($edit_array);
						//print('exit0');//exit;
						$this-> Common_model-> insert_record('situation_analysis_db',$edit_array);
					
					} 
				 //print_r($edit_array);
				}
				$query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility, year from situation_analysis_db where facode='$facode' and techniciancode='$techniciancode' and year='$year' order by priority asc";
		            $result = $this-> db-> query($query);	
		            $data =	$result-> result_array();
		           
                     $myJSON = json_encode($data);
                  
                    echo $myJSON; 
		      
			}////////////edit if end /////////////
			else{
				
				$distcode = $this -> session -> District;
			    $tcode = $this-> input-> post('ticode');				   
			    $uncode = $this-> input-> post('unicode');
			    $facode = $this-> input-> post('facode');
				$techniciancode = $this-> input-> post('techniciancode');
			    $year = $this-> input-> post('year');
			    $submitted_date = $this-> input-> post('submitted_date');				   
				$area_name = $this-> input-> post('area_name');
				$less_one_year = $this-> input-> post('less_one_year');
				$f3_total_population = $this-> input-> post('f3_total_population');
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
				$checkquery = "SELECT count(*) as recordnum from situation_analysis_db where facode='$facode' and facode='$facode' and  year='$year' and techniciancode='$techniciancode'";
				$result = $this-> db->query($checkquery);
				$record = $result-> row_array();
				$num_of_records = $record['recordnum'];
				if($num_of_records > 0){
					
					echo "yes";		
					exit();
				}
				
				foreach($this->input->post('area_name') as $key=>$val){
					$addDataArray=array(
						'distcode' => $distcode,
						'tcode' => $tcode,		   
					   'uncode' => $uncode,
					   'facode' => $facode,
					   'techniciancode' => $techniciancode,
					   'year' => $year,
					   'submitted_date' => $submitted_date,
						'area_name' => (isset($area_name[$key]) AND $area_name[$key] != '')?$area_name[$key]:NULL,
						'less_one_year' => (isset($less_one_year[$key]) AND $less_one_year[$key] > 0)?$less_one_year[$key]:0,
						'f3_total_population' => (isset($f3_total_population[$key]) AND $f3_total_population[$key] > 0)?$f3_total_population[$key]:0,
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
			        $query = "SELECT *, tehsilname(tcode) as tehsil, unname(uncode) as uc_name, facilityname(facode) as facility, year from situation_analysis_db where facode='$facode' and techniciancode='$techniciancode' and year='$year' order by priority asc";
		            $result = $this-> db-> query($query);	
		            $data =	$result-> result_array();
		           
                     $myJSON = json_encode($data);
                  
                    echo $myJSON; 
				
			}
		}		
		public function situation_analysis_edit(){
		   $techniciancode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
		   $recid = $this-> uri -> segment(6);
		   $current_month = date('m');
			$quarter = getQuater($current_month);
			
			$checkqurterplan="select * from hf_quarterplan_db where techniciancode='$techniciancode' and year='$year' and quarter='$quarter'";
			$result = $this-> db-> query($checkqurterplan);	
		    $datacheck =	$result-> result_array();
			if($datacheck != NULL){
				$location = base_url(). "red_rec_microplan/Situation_analysis/Situation_analysis_list";
				echo '<script language="javascript" type="text/javascript"> alert("First delete Quarter Work Plan of this Technician !");	window.location="'.$location.'"</script>';
			}
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_edit($techniciancode,$year,$recid);
			$data['fileToLoad'] = 'Add_red_microplanning/situation_main_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);
		}		
		public function situation_analysis_view(){
        
			$techniciancode = $this-> uri -> segment(4);
			$year = $this-> uri -> segment(5);
			//$submitted= $this-> uri -> segment(6);
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_view($techniciancode,$year);
			$data['fileToLoad'] = 'Add_red_microplanning/situation_main_view';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$data['filter_view'] = $this-> uri -> segment(6);
			$this-> load-> view('template/epi_template',$data);
		}
		public function Red_map_view(){
            		
			$techniciancode = $this-> uri -> segment(4);
		   $year = $this-> uri -> segment(5);
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_view($techniciancode,$year);
		   $data['fileToLoad'] = 'Add_red_microplanning/situation_main_view';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			//print_r($data);
			$this-> load-> view('template/epi_template',$data);
		}
			public function situation_main(){
			$distcode = $this-> session-> District; 
			$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
			$data['data'] = $this->db->query($query)->result_array();
			//$data['data'] =	"";
			$data['fileToLoad'] = 'Add_red_microplanning/situation_main';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function situation_main_edit(){
			$data['data'] =	"";
			$data['fileToLoad'] = 'Add_red_microplanning/situation_main_edit';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			$this-> load-> view('template/epi_template',$data);	
		}
		public function red_map_add(){
            		
			
			/* $techniciancode = $this-> uri -> segment(4);
			$year = $this-> uri -> segment(5);
			$data['data'] = $this-> Situation_analysis_model-> situation_analysis_view($techniciancode,$year); */
			$data="";
			$data['fileToLoad'] = 'Add_red_microplanning/red_map_add';
			$data['pageTitle'] = 'RED/REC Micro Plannning | EPI-MIS';
			//print_r($data);
			$this-> load-> view('template/epi_template',$data);
		}
	public function red_map_upload(){
		
		$techniciancode = $this-> input-> post('techniciancode');
		$year = $this-> input-> post('year');
		if(!empty($_FILES)){
			$fileName = $_FILES['file']['name'];
			$fileArray = explode('.', $fileName);
			$fileExt = end($fileArray);
			$date = date('Y-m-d H:i:s');
			$fileName = $date."-".$techniciancode.".".$fileExt;
			$temp = $_FILES['file']['tmp_name'];
			$dir_separator = DIRECTORY_SEPARATOR;
			$folder = "uploads";
			$destination_path = FCPATH.$dir_separator.$folder.$dir_separator;
			$target_path = $destination_path.$fileName;
			move_uploaded_file($temp, $target_path);
			//$imagePath = $_FILES['file']['name'];
			$date1 = date('Y-m-d');
		 	$red_map = array(
		 		'red_map' => $fileName,		   
				'date_red_map' => $date1,
			 );
		 	$this-> Situation_analysis_model-> red_map_upload($red_map,$techniciancode,$year);
		}
	}
}
?>
