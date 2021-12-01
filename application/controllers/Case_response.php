<?php
class Case_response extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Case_response_model','case_model');
		$this -> load -> helper('epi_functions_helper'); 
		authentication();
	}	
	public function add_case_response()
	{   
		$distcode=$this -> session -> District;
		$data = $this -> case_model -> add_case($distcode);
		//print_r($data); exit;
		$data['data'] = "";
		$data['fileToLoad'] = 'case_response/add_case_response';
		$data['pageTitle']	= 'Add Case Response | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function save_case_response()
	{	
			$date_of_activity = $this->input->post('date_of_activity');
			$uncode = $this->input->post('uncode');
			$vcode = $this->input->post('vcode');
			$data = $this -> case_model -> response($date_of_activity,$uncode,$vcode);
			//print_r($data['add']);
			
			if (!empty($data['add'])) {
			 	# code...
			 
				$location = "add_case_response";
		echo '<script language="javascript" type="text/javascript"> alert("Case Already Added..");	</script>';

			}else{
		
		foreach($this->input->post('vaccines') as $key => $value){
		$save_case_response= array(
				"tcode"=>(($this->input->post('tcode') != '')?$this->input->post('tcode'):NULL),			
				"uncode"=>(($this->input->post('uncode') != '')?$this->input->post('uncode'):NULL),			
				"vcode"=>(($this->input->post('vcode') != '')?$this->input->post('vcode'):NULL),			
				"disease"=>(($this->input->post('disease') != '')?$this->input->post('disease'):NULL),			
				"date_of_activity"=>(($this->input->post('date_of_activity') != '')?$this->input->post('date_of_activity'):NULL),
				"age_group_from"=>(($this->input->post('age_group_from') != '')?$this->input->post('age_group_from'):NULL),
				"age_group_to"=>(($this->input->post('age_group_to') != '')?$this->input->post('age_group_to'):NULL),			
				"vaccines"=>(($this->input->post('vaccines')[$key] != '')?$this->input->post('vaccines')[$key]:NULL),			
				"0_11_m_m"=>(($this->input->post('0_11_m_m')[$key] != '')?$this->input->post('0_11_m_m')[$key]:NULL),			
				"0_11_m_f"=>(($this->input->post('0_11_m_f')[$key] != '')?$this->input->post('0_11_m_f')[$key]:NULL),			
				"12_23_m_m"=>(($this->input->post('12_23_m_m')[$key] != '')?$this->input->post('12_23_m_m')[$key]:NULL),		
				"12_23_m_f"=>(($this->input->post('12_23_m_f')[$key] != '')?$this->input->post('12_23_m_f')[$key]:NULL),		
				"years_m"=>(($this->input->post('years_m')[$key] != '')?$this->input->post('years_m')[$key]:NULL),			
				"years_f"=>(($this->input->post('years_f')[$key] != '')?$this->input->post('years_f')[$key]:NULL),			
				"total_m"=>(($this->input->post('total_m')[$key] != '')?$this->input->post('total_m')[$key]:NULL),			
				"total_f"=>(($this->input->post('total_f')[$key] != '')?$this->input->post('total_f')[$key]:NULL),			
				"total_m_f"=>(($this->input->post('total_m_f')[$key] != '')?$this->input->post('total_m_f')[$key]:NULL),
				"total_one_to_m"=>(($this->input->post('total_one_to_m') != '')?$this->input->post('total_one_to_m'):NULL),
				"total_one_to_f"=>(($this->input->post('total_one_to_f') != '')?$this->input->post('total_one_to_f'):NULL),
				"total_twelve_to_m"=>(($this->input->post('total_twelve_to_m') != '')?$this->input->post('total_twelve_to_m'):NULL),
				"total_twelve_to_f"=>(($this->input->post('total_twelve_to_f') != '')?$this->input->post('total_twelve_to_f'):NULL),
				"total_year_m"=>(($this->input->post('total_year_m') != '')?$this->input->post('total_year_m'):NULL),
				"total_year_f"=>(($this->input->post('total_year_f') != '')?$this->input->post('total_year_f'):NULL),
				"total_mm"=>(($this->input->post('total_mm')!= '')?$this->input->post('total_mm'):NULL),
				"total_ff"=>(($this->input->post('total_ff') != '')?$this->input->post('total_ff'):NULL),
				"t_m_f"=>(($this->input->post('t_m_f') != '')?$this->input->post('t_m_f'):NULL),
				"blood_speciment_collected"=>(($this->input->post('blood_speciment_collected') != '')?$this->input->post('blood_speciment_collected'):NULL),
				"oral_swabs_collected"=>(($this->input->post('oral_swabs_collected') != '')?$this->input->post('oral_swabs_collected'):NULL),
				"follow_up_visit"=>(($this->input->post('follow_up_visit') != '')?$this->input->post('follow_up_visit'):NULL),
				"reported_case_base_surveillance"=>(($this->input->post('reported_case_base_surveillance') != '')?$this->input->post('reported_case_base_surveillance'):NULL),
				"active_search_case"=>(($this->input->post('active_search_case') != '')?$this->input->post('active_search_case'):NULL),
				"epi_linked_case"=>(($this->input->post('epi_linked_case') != '')?$this->input->post('epi_linked_case'):NULL),
				"submitdate"=>date("Y-m-d"),
				"distcode"=>$this -> session -> District
			 );
		//print_r($save_case_response);//exit;
				$data = $this -> case_model -> save_case_response($save_case_response);

		}
	}
		
		redirect(base_url("Case-List"));	
		//print_r($save_case_response);
		
	}
	public function list_case_response()
	{   
		/*$distcode=$this -> session -> District;
		$data = $this -> case_model -> list_measles_case_response($distcode);*/
		//print_r($data); exit;
		$data['data'] = "";
		$data['fileToLoad'] = 'case_response/list_case_response';
		$data['pageTitle']	= 'List Case Response | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	}
	public function case_list()
	{
		/* $draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$order = $this->input->get("order");
		$distcode=$this -> session -> District;
		$col = 0;
		$dir = "asc";
		if(!empty($order)) {
			foreach($order as $o) {
				$col = $o['column'];
				$dir= $o['dir'];
			}
		}
		//print_r($col);
		//print_r($dir);exit;
		if($dir != "asc" && $dir != "desc")
		{
			$dir = "asc";
		}
		if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
		{
			$columns_valid = array(
				//"id",
				"vcode",
				"tehsil",		
				"unioncouncil",
				"disease",
				"date_of_activity"
				"health_education_sessions",
			);
		}
		else
		{
			$columns_valid = array(
				//"id",
				"vcode",
				"district",
				"tehsil",		
				"unioncouncil",
				"disease",
				"date_of_activity"
				"health_education_sessions",
			);
		}			
		if(!isset($columns_valid[$col]))
		{
			$order = null;
		} else {
			$order = $columns_valid[$col];
		}  */
		//print_r($columns_valid[$col]);exit;
		$requestData= $_REQUEST;
		/*$cardno1=null;
		$nic1=null;
		$mobile=null;*/
		/*if( !empty($requestData['columns'][1]['search']['value']))
		{
			$cardno1=$requestData['columns'][1]['search']['value'];
		}*/
		/*if( !empty($requestData['columns'][5]['search']['value']))
		{
			$nic1=$requestData['columns'][5]['search']['value'];
		}*/
		/*if( !empty($requestData['columns'][6]['search']['value']))
		{
			$mobile=$requestData['columns'][6]['search']['value'];
		}*/
		 /*$string = preg_replace("/[\s-]+/", "", $nic1);*/
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
					$distcode="";
      				$column = str_replace('district', 'distcode', $column);
      			}
      			elseif ($_SESSION['UserLevel']=='3') 
      			{
					$distcode=$this -> session -> District;
      				$column = str_replace('tehsil', 'tcode', $column);
      			}
      			if( ! empty($search_value))
      			{
      				$multiple_search .= " AND ";
      				$multiple_search .= "$column='$search_value'";
      			}
      		}
      	}
		$col = 0;
        $dir = "";
		//print_r($multiple_search);exit;
        if(!empty($order))
        {
            foreach($order as $o) 
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }
//echo $dir;exit;
        if($dir != "asc" && $dir != "desc") {
            $dir = "asc";
        }
		if($this->session->UserLevel=='3' && $this->session->utype=='DEO')
		{
			$columns_valid = array(
				"serial",
				"vcode",
				"tehsil",		
				"unioncouncil",
				"disease",
				"date_of_activity"
			);
		}
		else if($this->session->UserLevel=='4' && $this->session->utype=='DEO')
		{
			$columns_valid = array(
				"serial",
				"vcode",
				"tehsil",		
				"unioncouncil",
				"disease",
				"date_of_activity"
			);
		}
		else
		{
			$columns_valid = array(
				"serial",
				"vcode",
				"district",
				"tehsil",		
				"unioncouncil",
				"disease",
				"date_of_activity"
			);
		}	
		/* if(!isset($columns[$col]))
		{
			$order = null;
		} else {
			$order = $columns_valid[$col];
		} */
		
		
		 if(!isset($columns_valid[$col])) {
            $order = '';
        } elseif($draw == 5) {
            $order = " order by date_of_activity ";// "order by ".$columns_valid[$col].' '.$dir;
        }
        else{
        	$order = "order by ".$columns_valid[$col].' '.$dir;
        }
		
		$datalist = $this -> case_model -> case_list($start,$length,$order,$dir,$multiple_search);
		//print_r($datalist);
		$data=array();
		$i=$start+1;
		foreach($datalist->result() as $r)
		{
			/*$value=$r->firstactivitytype;
            if($value==1 )
            	$latestvalue="ANC1";
           if($value==2)
            	$latestvalue="ANC2";
            if($value==3)
            	$latestvalue="ANC3";
            if($value==4)
            	$latestvalue="ANC4";
            if($value==5)
            	$latestvalue="Delivery";
              if($value==6)
            	$latestvalue="PNC";*/
            
			 if($this->session->UserLevel=='3' && $this->session->utype=='DEO'){
				$data[] = array(
					"serial" => $i,
					"vcode" =>$r->vcode,
					"tehsil" => $r->tehsil,				
					"unioncouncil" =>$r->unioncouncil,
					"disease" =>$r->disease,
					"date_of_activity" => $r->date_of_activity
				);
			}
			else
			{
				$data[] = array(
					"serial" => $i,
					"vcode" =>$r->vcode,
					"district" => $r->district,
					"tehsil" => $r->tehsil,				
					"unioncouncil" =>$r->unioncouncil,
					"disease" =>$r->disease,
					"date_of_activity" => $r->date_of_activity
				);
			}
			$i++;
		} //print_r($data);exit;
		$patient_total = $this->case_model->case_get_total($multiple_search);   
		$output = array(
			"draw" => $draw,
			"recordsTotal" =>$patient_total,
			"recordsFiltered" => $patient_total,
			"data" => $data
		);
		echo json_encode($output);
	}
	public function case_view()
	{
		$vcode =$this->uri->segment(2);
		$activitydate =$this->uri->segment(3);
		/*echo $uncode; 
		echo '<br>';
		 echo  $activitydate;*/
	
		$data = $this -> case_model -> case_view($vcode,$activitydate);
		//print_r($data);
		$data['data'] = "";
		$data['fileToLoad'] = 'case_response/view_case_response';
		$data['pageTitle']='View Case Response | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	
	}	
	public function case_edit()
	{
		$vcode =$this->uri->segment(2);
		$activitydate =$this->uri->segment(3);
	
		$data = $this -> case_model -> case_edit($vcode,$activitydate);
		//print_r($data);
		$data['data'] = "";
		//$data['un'] = $uncode;
		//$data['ac'] = $activitydate;
		$data['fileToLoad'] = 'case_response/edit_case_response';
		$data['pageTitle']='Edit Case Response | EPI-MIS';
		$this->load->view('template/epi_template',$data);
	
	}
	public function save_edit_response()
	{	$date_of_activity = $this->input->post('date_of_activity');
		$uncode = $this->input->post('uncode');
		$distcode = $this -> session -> District;
		foreach($this->input->post('vaccines') as $key => $value){
			//print_r($key);
		$edit_case_response[]= array(
				"tcode"=>(($this->input->post('tcode') != '')?$this->input->post('tcode'):NULL),			
				"uncode"=>(($this->input->post('uncode') != '')?$this->input->post('uncode'):NULL),			
				"vcode"=>(($this->input->post('vcode') != '')?$this->input->post('vcode'):NULL),			
				"disease"=>(($this->input->post('disease') != '')?$this->input->post('disease'):NULL),			
				"date_of_activity"=>(($this->input->post('date_of_activity') != '')?$this->input->post('date_of_activity'):NULL),
				"age_group_from"=>(($this->input->post('age_group_from') != '')?$this->input->post('age_group_from'):NULL),
				"age_group_to"=>(($this->input->post('age_group_to') != '')?$this->input->post('age_group_to'):NULL),			
				"vaccines"=>(($this->input->post('vaccines')[$key] != '')?$this->input->post('vaccines')[$key]:NULL),			
				"0_11_m_m"=>(($this->input->post('0_11_m_m')[$key] != '')?$this->input->post('0_11_m_m')[$key]:NULL),			
				"0_11_m_f"=>(($this->input->post('0_11_m_f')[$key] != '')?$this->input->post('0_11_m_f')[$key]:NULL),			
				"12_23_m_m"=>(($this->input->post('12_23_m_m')[$key] != '')?$this->input->post('12_23_m_m')[$key]:NULL),		
				"12_23_m_f"=>(($this->input->post('12_23_m_f')[$key] != '')?$this->input->post('12_23_m_f')[$key]:NULL),	
				"years_m"=>(($this->input->post('years_m')[$key] != '')?$this->input->post('years_m')[$key]:NULL),			
				"years_f"=>(($this->input->post('years_f')[$key] != '')?$this->input->post('years_f')[$key]:NULL),			
				"total_m"=>(($this->input->post('total_m')[$key] != '')?$this->input->post('total_m')[$key]:NULL),			
				"total_f"=>(($this->input->post('total_f')[$key] != '')?$this->input->post('total_f')[$key]:NULL),			
				"total_m_f"=>(($this->input->post('total_m_f')[$key] != '')?$this->input->post('total_m_f')[$key]:NULL),
				"total_one_to_m"=>(($this->input->post('total_one_to_m') != '')?$this->input->post('total_one_to_m'):NULL),
				"total_one_to_f"=>(($this->input->post('total_one_to_f') != '')?$this->input->post('total_one_to_f'):NULL),
				"total_twelve_to_m"=>(($this->input->post('total_twelve_to_m') != '')?$this->input->post('total_twelve_to_m'):NULL),
				"total_twelve_to_f"=>(($this->input->post('total_twelve_to_f') != '')?$this->input->post('total_twelve_to_f'):NULL),
				"total_year_m"=>(($this->input->post('total_year_m') != '')?$this->input->post('total_year_m'):NULL),
				"total_year_f"=>(($this->input->post('total_year_f') != '')?$this->input->post('total_year_f'):NULL),
				"total_mm"=>(($this->input->post('total_mm')!= '')?$this->input->post('total_mm'):NULL),
				"total_ff"=>(($this->input->post('total_ff') != '')?$this->input->post('total_ff'):NULL),
				"t_m_f"=>(($this->input->post('t_m_f') != '')?$this->input->post('t_m_f'):NULL),
				"blood_speciment_collected"=>(($this->input->post('blood_speciment_collected') != '')?$this->input->post('blood_speciment_collected'):NULL),
				"oral_swabs_collected"=>(($this->input->post('oral_swabs_collected') != '')?$this->input->post('oral_swabs_collected'):NULL),
				"follow_up_visit"=>(($this->input->post('follow_up_visit') != '')?$this->input->post('follow_up_visit'):NULL),
				"reported_case_base_surveillance"=>(($this->input->post('reported_case_base_surveillance') != '')?$this->input->post('reported_case_base_surveillance'):NULL),
				"active_search_case"=>(($this->input->post('active_search_case') != '')?$this->input->post('active_search_case'):NULL),
				"epi_linked_case"=>(($this->input->post('epi_linked_case') != '')?$this->input->post('epi_linked_case'):NULL),
				"updatdate"=>date("Y-m-d"),
				"distcode"=>$distcode
			 );		
				
		}
		
		$this -> case_model -> edit_case_response($date_of_activity,$uncode,$distcode,$edit_case_response);
		//print_r($save_case_response);//exit;
		redirect(base_url("Case-List"));	
		//print_r($save_case_response);
		
	}


}
?>