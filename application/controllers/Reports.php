<?php
class Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Reports_model');
		$this -> load -> model('Vaccine_coverage_model');
		$this -> load -> helper('epi_functions_helper');

		$code = md5(date("Y-n-d"));
		if(isset($_REQUEST['code']) && $_REQUEST['code'] == $code){
			$provinceCode = $_REQUEST['procode']; // procode during drilldown from Federal EPI
			$provinceName = get_Province_Name($provinceCode); // province name based on procode
			$sessionData = array(
				'username'  => "EPI Manager",
				'User_Name' => "EPI Manager",
				'federaluser' => true,
				'UserAuth'  => "Yes",
				'UserLevel' => '2',
				'UserType' => 'Manager',
				'utype' => 'Manager',
				'provincename' => $provinceName,
				'Province' => $provinceCode,
				'loginfrom' => "Pakistan EPI"
			);
			$this -> session -> set_userdata($sessionData);
		}else{
			if($this -> session -> UserAuth == 'Yes'){}else{
				authentication();
			}
		}
		//authentication();
		$this -> load -> model('Common_model');
	}
	
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	public function hf_cr(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('month-from-to-previous');
		$functionName = "hf_consumption_requisition";
		$reportPath = base_url()."Reports/".$functionName;
		$reportTitle = "Consolidated Consumption and Requisition";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	public function Reports_Filters($reportName){
		$data['data'] = $this -> Reports_model -> Create_Reporting_Filters($reportName);
		//$data['data']=$data;
		if($data != 0){
            $data['fileToLoad'] = 'reports/reports_filters';
			$data['pageTitle']='Report Filters';
			$this -> load -> view('template/epi_template',$data);
		}
		else{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}
	public function measle_coverage_dropout()
	{
		if($this->input->post('distcode') OR null !== $this->uri->segment(3))
		{
			$data['distcode'] = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('distcode');
			$data['type_wise'] = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('typeWise');
		}
		$data['year'] = (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('year');
		$data['period_wise']   = (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('period_wise');
		if($this-> uri-> segment(4)){
			$segmentYear = $this-> uri-> segment(4);
			$currentYear = date('Y');
			if($segmentYear == $currentYear){
				$highestMonth = date('m')-1;
				$highestMonth = sprintf("%02d", $highestMonth);

			}
			else{
				$highestMonth = 12;
			}
		}
		else{
			$postedYear = $this->input->post('year');
			$currentYear = date('Y');
			if($postedYear == $currentYear){
				$highestMonth = date('m')-1;
				$highestMonth = sprintf("%02d", $highestMonth);
			}
			else{
				$highestMonth = 12;
			}
		}
		$data['monthfrom']   = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : '01';
		$data['monthto']   = (null !== $this->uri->segment(7)) ? $this->uri->segment(7) : $highestMonth ; 
		// print_r($data) ; exit(); 
		$data['data'] = $this-> Reports_model-> measle_coverage_dropout($data);
			
		if($data != 0)
		{
            $data['fileToLoad'] = 'reports/measle_coverage_dropout';
			$data['pageTitle']='Measle Coverage Vs. Measles Cases';
			$this -> load -> view('template/reports_template',$data);
		}
		else
		{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}
	public function all_dropout()
	{
		//echo "hello";exit;
		if($this->input->post('distcode') OR null !== $this->uri->segment(3))
		{
			$data['distcode'] = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('distcode');
			$data['type_wise'] = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('typeWise');
		}
		$data['monthfrom'] = (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('monthfrom');
		$data['monthto']   = (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthto');
		/* if($this->input->post('monthfrom') AND $this->input->post('monthto'))
		{
			$data['monthfrom'] = substr($data['monthfrom'],3).'-'.substr($data['monthfrom'],0,2);
			$data['monthto'] = substr($data['monthto'],3).'-'.substr($data['monthto'],0,2);
		} */
		$data['data'] = $this->Reports_model->all_dropout($data);
			
		if($data != 0)
		{
            $data['fileToLoad'] = 'reports/all_dropout';
			$data['pageTitle']='Report Filters';
			$this->load->view('template/reports_template',$data);
		}
		else
		{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	} 
	public function access_utilization()
	{
		//print_r($_POST);exit();
		if($this->input->post('distcode') OR null !== $this->uri->segment(3))
		{
			$data['distcode'] = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('distcode');
			
			if($this->input->post('acces_type')=="facilitywise"){			
				$data['type_wise']= 'facility';
			}
			else{
				$data['type_wise']= 'Unioncouncil';
			}
		}
		if($this -> session -> UserLevel==4){
			$data['tcode'] = $this->input->post('tcode');
			if($this->input->post('acces_type')=="facilitywise"){			
				$data['type_wise']= 'facility';
			}
			else{
				$data['type_wise']= 'Unioncouncil';
			}
		}
		$data['monthfrom'] = (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('monthfrom');
		$data['monthto']   = (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthto');
		/* if($this->input->post('monthfrom') AND $this->input->post('monthto'))
		{
			$data['monthfrom'] = substr($data['monthfrom'],3).'-'.substr($data['monthfrom'],0,2);
			$data['monthto'] = substr($data['monthto'],3).'-'.substr($data['monthto'],0,2);
		} */
		$data['data']  = $this->Reports_model->access_utilization($data);
		if($data  != 0)
		{			
			if(isset($data['type_wise']) && $data['type_wise'] == 'Unioncouncil'){
				
				$data['data']['TopInfo'] = reportsTopInfo("Union Council Categorization", $data);
			}			
			else if(isset($data['type_wise']) && $data['type_wise'] == 'facility'){
				$data['data']['TopInfo'] = reportsTopInfo("Facility Categorization", $data);
			}		
			else{
				$data['data']['TopInfo'] = reportsTopInfo("District Wise Categorization of UnionCouncil", $data);
			}
			if ($this -> input -> post('export_excel')) {
				//if request is from excel
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=Access_and_Utilization_Report.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				//Excel Ending here
			}
			$data['data']['exportIcons']=exportIcons($_REQUEST);
            $data['fileToLoad'] = 'reports/access_utilization';
			$data['pageTitle']='Access and Utilization Report';
			$data['data']['distcode'] = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->get_post('distcode');
			$data['data']['acces_type'] = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->get_post('acces_type');
			$data['monthfrom']=$data['monthfrom'];
			$this -> load -> view('template/reports_template',$data);
		}
		else
		{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	}
	
	public function vaccine_demand()
	{   //print_r($_POST); exit();
		$managerDrillDown = $this->uri->segment(7);
		if($managerDrillDown=="drillDown")
		{
			$data['monthfrom'] = (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('monthfrom');
			$data['monthto']   = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthto');
			$data['indicator'] = (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('indicator');
			$data['product']   = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('product');
		}
		else
		{
			if($this->input->post('distcode') OR null !== $this->uri->segment(3))
			{
				$data['distcode'] = (null !== $this->uri->segment(3)) ? $this->uri->segment(3) : $this->input->post('distcode');
	            $data['typewise'] = (null !== $this->uri->segment(8)) ? $this->uri->segment(8) : $this->input->post('typewise');
			}
			//print_r($data['type_wise']);exit;
			$data['monthfrom'] = (null !== $this->uri->segment(6)) ? $this->uri->segment(6) : $this->input->post('monthfrom');
			$data['monthto']   = (null !== $this->uri->segment(7)) ? $this->uri->segment(7) : $this->input->post('monthto');
			$data['indicator'] = (null !== $this->uri->segment(5)) ? $this->uri->segment(5) : $this->input->post('indicator');
			$data['product']   = (null !== $this->uri->segment(4)) ? $this->uri->segment(4) : $this->input->post('product');
			//$data['typewise'] = $_POST['typewise']; 
			/* if($this->input->post('monthfrom') AND $this->input->post('monthto'))
			{
				$data['monthfrom'] = substr($data['monthfrom'],3).'-'.substr($data['monthfrom'],0,2);
				$data['monthto'] = substr($data['monthto'],3).'-'.substr($data['monthto'],0,2);
			} */
		}
		
		$data['data'] = $this->Reports_model->vaccine_demand($data);
			
		if($data != 0)
		{
            $data['fileToLoad'] = 'reports/vaccine_demand';
			$data['pageTitle']='Report Filters';
			//print_r($data);exit; 
			$this -> load -> view('template/reports_template',$data);
		}
		else
		{
			$data['message']="You must have rights to access this page.";
			$this -> load -> view("message",$data);
		}
	} 
	//================ Function to Create Filters for Sepecific Reports Ends Here ===================//
	//-----------------------------------------------------------------------------------------------//
	//======= FLCF wise Vaccination for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination($code=NULL,$year=NULL){		
		if($this -> input -> post('vaccination_type') != 'all'){
			$data['data'] = $this -> Reports_model -> typeWiseVaccination($code,$year);
		}else{
			$data['data'] = $this -> Reports_model -> flcf_wise_vaccination_malefemale_coverage($code,$year);
		}
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==6)
			{
				$data["facode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}
		if($this -> input -> post('vaccination_type') != 'all'){
			$data['fileToLoad'] = 'reports/vaccination_type_report';
		}
		else{
			$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report';
		}
		$data['pageTitle']='Facility-wise Vaccination of Children and Women(with Percentage)';
		//print_r($data);exit();
		$this -> load -> view('template/reports_template',$data);
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function drillDownCoverage($code=NULL,$year=NULL)
	{
		$data['distcode'] = $this->input->get('distcode');
		$data['typeWise'] = $this->input->get('typeWise');
		$data['monthfrom'] = $this->input->get('monthfrom');
		$data['monthto'] = $this->input->get('monthto');
		$data['vaccination_type'] = $this->input->get('vaccination_type');
		$data['monthfrom'] = substr($data['monthfrom'],3).'-'.substr($data['monthfrom'],0,2);
		$data['monthto'] = substr($data['monthto'],3).'-'.substr($data['monthto'],0,2);		//echo "<pre>";print_r($data);exit;	
		//echo $year;exit;
		//echo $code;
		//print_r($data);exit;
		if($this -> input -> get('vaccination_type') != 'all'){
			//echo "<pre>";print_r($data);exit;	
			$data['data'] = $this -> Reports_model -> typeWiseVaccination($code,$year,$data);
		}else{
			$data['data'] = $this -> Reports_model -> flcf_wise_vaccination_malefemale_coverage($code,$year,$data);
		}
		$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report';
		$data['pageTitle']='Facility wise Vaccination of Children and Women(Male Female wise)';
		//print_r($data);exit();
		$this -> load -> view('template/reports_template',$data);
	}
	
	//======= (Male Female wise)FLCF wise Vaccination for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination_malefemale_coverage($code=NULL,$year=NULL)
	{
		//print_r($_REQUEST); exit();	
		if($this->input->get_post('distcode') && $this->input->get_post('monthfrom') && $this->input->get_post('monthto'))
		{
			//print_r($_REQUEST); exit();	
			$data['distcode'] = $this->input->get_post('distcode');		   
			$data['typeWise'] = $this->input->get_post('typeWise');
			$data['monthfrom'] = $this->input->get_post('monthfrom');
			$data['monthto'] = $this->input->get_post('monthto');
			$data['vaccination_type'] = $this->input->get_post('vaccination_type');
			$data['vacc_to']=$this->input->get_post('vacc_to');
			$data['age_wise']=$this->input->get_post('age_wise');
			$data['in_out_coverage'] = $this->input->get_post('in_out_coverage');
			$data['distdrilldown'] = $drilldown = $this->input->get_post('distdrilldown');
		}
		else if ($this -> input -> server('REQUEST_METHOD') == 'POST')
		{
			$data = $this -> getPostedData();
		}
		else
		{
			$data['distcode'] = $this->input->get_post('distcode');			
			$data['age_wise'] = $this->input->get_post('age_wise');
			$data['monthfrom'] = $this->input->get_post('monthfrom');
			$data['monthto'] = $this->input->get_post('monthto');
			$data['vaccination_type'] = $this->input->get_post('vaccination_type');
			$data['vacc_to'] = $this->input->get_post('vacc_to');
			$data['typeWise'] = $this->input->get_post('typeWise');
			$data['in_out_coverage'] = $this->input->get_post('in_out_coverage');
			$data['distdrilldown'] = $drilldown = $this->input->get_post('distdrilldown');
		}
	  	if ($this -> input -> server('REQUEST_METHOD') == 'POST')
	   	{
			$data['typeWise'] = $this->input->get_post('typeWise');
			$data['in_out_coverage'] = $this->input->get_post('in_out_coverage');
			$data['distdrilldown'] = $drilldown = $this->input->get_post('distdrilldown');
		}
		if($this -> input -> get_post('vaccination_type') != 'all' && $this -> input -> get_post('in_out_coverage') != 'total_districts')
		{
			$data['data'] = $this -> Reports_model -> typeWiseVaccination($code,$year,$data);
		}
		elseif($this -> input -> get_post('vaccination_type') == 'all' && $this -> input -> get_post('in_out_coverage') != 'total_districts')
		{
			$data['data'] = $this -> Reports_model -> flcf_wise_vaccination_malefemale_coverage($code,$year,$data);
		}
		else{
			$data['data'] = $this -> Vaccine_coverage_model -> in_plus_out_districts($code,$year,$data);
		}
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==6)
			{
				$data["facode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}
		$vacc_to = $this->input->get_post('vacc_to');
		$age_wise = $this->input->get_post('age_wise'); 
		if($this -> input -> get_post('vaccination_type') != 'all' && $this -> input -> get_post('in_out_coverage') != 'total_districts') 
		{ 
			if($vacc_to != 'total_children' AND $age_wise == 'all')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report';
			}
			if($vacc_to == 'total_children' AND $age_wise == 'all')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report_total';
			}
			/* elseif($age_wise == '0to11' AND $vacc_to != 'total_children')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report_0to11';
			}
			elseif($age_wise == '0to11' AND $vacc_to == 'total_children')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report_0to11_total';
			} */
			elseif($vacc_to == 'total_children' AND $age_wise != 'all')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report_notall_total';
			}
			elseif($vacc_to != 'total_children' AND $age_wise != 'all')
			{
				$data['fileToLoad'] = 'reports/vaccination_type_report_notall';
			}
		}
		else
		{
			if($this -> input -> get_post('in_out_coverage') == 'out_uc' || $this -> input -> get_post('in_out_coverage') == 'total_ucs' || $this -> input -> get_post('in_out_coverage') == 'out_district'){
				if($vacc_to != 'total_children' AND $age_wise == 'all')
				{
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_out';
					}
					
				}
				if($vacc_to == 'total_children' AND $age_wise == 'all')
				{
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_total_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_total_out';
					}					
				}
				elseif($age_wise == '0to11' AND $vacc_to != 'total_children')
				{
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_out';
					}	
					
				}
				elseif($age_wise == '0to11' AND $vacc_to == 'total_children')
				{
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_total_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_total_out';
					}	
					
				}
				elseif($vacc_to == 'total_children' AND $age_wise != 'all')
				{	
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_total_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_total_out';
					}					
				}
				elseif($vacc_to != 'total_children' AND $age_wise != 'all')
				{
					if($this -> input -> get_post('in_out_coverage') == 'out_district'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_out_district';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_out';
					}
				}				
			}
			elseif($this -> input -> get_post('in_out_coverage') == 'total_districts'){
				if($vacc_to == 'total_children'){
					if($age_wise == 'all'){
						$data['fileToLoad'] = 'reports/district_total_in_plus_out_total_all';
					}
					else{
						$data['fileToLoad'] = 'reports/district_total_in_plus_out_total_age_wise';
					}
				}				
				if($vacc_to == 'gender'){
					if($age_wise == 'all'){
						$data['fileToLoad'] = 'reports/district_total_in_plus_out_gender_wise_all';
					}
					else{
						$data['fileToLoad'] = 'reports/district_total_in_plus_out_gender_wise_age_wise';
					}
				}
			}
			else{
				if($vacc_to != 'total_children' AND $age_wise == 'all')
				{
					if($drilldown == 'dist_to_uc'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report';
					}
				}
				if($vacc_to == 'total_children' AND $age_wise == 'all')
				{
				
					if($drilldown == 'dist_to_uc'){
						
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_total_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_total';
					}
				}
				elseif($age_wise == '0to11' AND $vacc_to != 'total_children')
				{
					if($drilldown == 'dist_to_uc'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11';
					}
					
				}
				elseif($age_wise == '0to11' AND $vacc_to == 'total_children')
				{
					if($drilldown == 'dist_to_uc'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_total_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_0to11_total';
					}
				}
				elseif($vacc_to == 'total_children' AND $age_wise != 'all')
				{
					if($drilldown == 'dist_to_uc'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_total_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_total';
					}
					
				}
				elseif($vacc_to != 'total_children' AND $age_wise != 'all')
				{	
					if($drilldown == 'dist_to_uc'){
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall_out';
					}
					else{
						$data['fileToLoad'] = 'reports/flcf_wise_vaccination_malefemale_coverage_report_notall';
					}
				}
			}
		}
		$data['pageTitle']='Vaccination Report of Children and Women (Male Female wise)';
		$this -> load -> view('template/reports_template',$data);
	}
	public function sessionInfoReport(){
		if($this->input->get_post('distcode'))
			$dist = $this->input->get_post('distcode');
		else 
			$dist = '';
		$year = $this->input->get_post('year');
		$month = $this->input->get_post('month');
		$reportType = $this->input->get_post('report_type');
		$session_type = $this->input->get_post('session_type');
		$quarter = $this->input->get_post('quarter');
		$this -> load -> model('dashboard/dashboard_model','dashboard');
		if($dist == 0)
			$data['data'] = $this->dashboard->sessionInfo($year,$month,$reportType,$session_type,$quarter);
		else
			$data['data'] = $this->dashboard->sessionInfoFac($year,$dist,$month,$reportType,$session_type,$quarter);
		$data['distcode'] = $dist;
		$data['year'] = $year;
		$data['reportType'] = $reportType;
		$data['session_type'] = $session_type; 
		$data['quarter'] = $quarter;
		$data['month'] = $month;
		//$data['data']['TopInfo'] = tableTopInfo('', $dist, '', $year,$session_type,'',$month,'','','','','','','',$quarter);
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Session_Planned_Conducted_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data']['TopInfo'] = reportsTopInfo("Sessions Planned/Conducted", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'reports/session_info';
		$data['pageTitle']='Sessions Planned/Conducted';
		$this -> load -> view('template/reports_template',$data);
	}
	//-----------------------------------------------------------------------------------------------//
	//======= Monthly Surveillance Compliance Report Function Starts Here =======//
	public function aefi_compliance($code=NULL,$year=NULL){
		$data['data'] = $this -> Reports_model -> aefi_compliance($code,$year);
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}		
		$data['fileToLoad'] = 'reports/aefi_compliance';
		$data['pageTitle']='Adverse Event Following Immunization Report Compliance';
		$this -> load -> view('template/reports_template',$data);
	}
	//-----------------------------------------------------------------------------------------------//
	
	//======= New Report function starts here =======//
	public function hf_consumption_requisition(){
		//echo "danish";exit; 
		if($this->input->get('distcode') && $this->input->get('monthfrom') && $this->input->get('monthto')){
			$data['distcode'] = $this->input->get('distcode');
			$data['tcode'] = $this->input->get('tcode');
			$data['uncode'] = $this->input->get('uncode');
			$data['facode'] = $this->input->get('facode');
			$data['monthfrom'] = $this->input->get('monthfrom');
			$data['monthto'] = $this->input->get('monthto');
		}else{
			$data = $this -> getPostedData();
		}		
		$data['data']=$this->Reports_model->hf_consumption_requisition($data);
		
		$data['fileToLoad'] = 'reports/consolidated_consumption_requisition_report'; // old view for district and health facility wise// --hf_consumption_requisition_report
		$data['pageTitle']='Consolidated Consumption and Requisition Report';
		$this -> load -> view('template/reports_template',$data);
	}
	//------------------------------------------------------------------------------------------------//
	
	//======= OLD (Health Facility and District Wise) Report function starts here =======//
	/* public function hf_consumption_requisition(){
		if($this->input->get('distcode') && $this->input->get('monthfrom') && $this->input->get('monthto')){
			$data['distcode'] = $this->input->get('distcode');
			$data['monthfrom'] = $this->input->get('monthfrom');
			$data['monthto'] = $this->input->get('monthto');
		}else{
			$data = $this -> getPostedData();
		}		
		$data['data']=$this->Reports_model->hf_consumption_requisition($data);
		$data['fileToLoad'] = 'reports/hf_consumption_requisition_report';
		$data['pageTitle']='Health Facility Consumption and Requisition Report';
		$this -> load -> view('template/reports_template',$data);
	} */
	//------------------------------------------------------------------------------------------------//
	
	//======= UC/FLCF wise Vaccination Coverage compliance Function Starts Here =======//
	public function flcf_vacc_coverage_compliance(){
		$data['data'] = $this -> Reports_model -> flcf_vacc_coverage_compliance();
		$data['fileToLoad'] = 'reports/flcf_vacc_coverage_compliance';
		$data['pageTitle']='Facility Wise Vaccination Coverage Monthly Report Compliance';
		$this -> load -> view('template/reports_template',$data);
	}
	public function Weekly_VPD_Compilation(){
		$postedVariables = posted_Values();//posted values from last page
		if($postedVariables['epiWeek']){
			$fweek = $postedVariables['year']."-".sprintf('%02d',$postedVariables['epiWeek']); 
		}else{
			$fweek = $postedVariables['year']."-%"; 
		}
		$wc	  = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> Weekly_VPD_Compilation($wc,$fweek);
		if($this -> session -> District > 0){
			$data['code'] = $this -> session -> District;	
		}
		$data['epiWeek'] = $postedVariables['epiWeek'];
		$data['year'] = $postedVariables['year'];
		$data['fileToLoad'] = 'reports/weeklyVpdCompilation';
		$data['pageTitle']='Weekly VPD Surveillance Compilation Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function formA1Compliance(){
		$postedVariables = posted_Values();//posted values from last page
		$dateFrom = date('Y-m-d',strtotime($postedVariables['datefrom']));
		$dateTo = date('Y-m-d',strtotime($postedVariables['dateto']));
		$data['data'] = $this -> Reports_model -> formA1Compliance($dateFrom,$dateTo,$postedVariables['distcode']);
		$data['fileToLoad'] = 'reports/formA1Compliance';
		$data['pageTitle']='Form A-I Compliance Report';
		$this -> load -> view('template/reports_template',$data);
		//print_r($data);exit();
	}
	public function formA2Compliance(){
		$postedVariables = posted_Values();//posted values from last page
		$dateFrom = date('Y-m-d',strtotime($postedVariables['datefrom']));
		$dateTo = date('Y-m-d',strtotime($postedVariables['dateto']));
		$data['data'] = $this -> Reports_model -> formA2Compliance($dateFrom,$dateTo,$postedVariables['distcode']);
		$data['fileToLoad'] = 'reports/formA2Compliance';
		$data['pageTitle']='Form A-II Compliance Report';
		$this -> load -> view('template/reports_template',$data);
		//print_r($data);exit();
	}
	public function formBCompliance(){
		$data['data'] = $this -> Reports_model -> formBCompliance();
		$data['fileToLoad'] = 'reports/formBCompliance';
		$data['pageTitle']='Form B(EPI) Compliance Report';
		$this -> load -> view('template/reports_template',$data);
		//print_r($data);exit();
	}
	public function formCCompliance(){
		$postedVariables = posted_Values();//posted values from last page
		$dateFrom = date('Y-m-d',strtotime($postedVariables['datefrom']));
		$dateTo = date('Y-m-d',strtotime($postedVariables['dateto']));
		$data['data'] = $this -> Reports_model -> formCCompliance($dateFrom,$dateTo,$postedVariables['distcode']);
		$data['fileToLoad'] = 'reports/formCCompliance';
		$data['pageTitle']='Form C (EPI) Compliance Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function Weekly_AEFI_Compilation(){
		$postedVariables = posted_Values();//posted values from last page
		//print_r($postedVariables);exit();
		$dateFrom = date('Y-m-d',strtotime($postedVariables['datefrom']));
		$dateTo = date('Y-m-d',strtotime($postedVariables['dateto']));
		$wc	  = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		//print_r($wc);exit;
		$data['data'] = $this -> Reports_model -> Weekly_AEFI_Compilation($wc,$dateFrom,$dateTo);
		if($this -> session -> District > 0){
			$data['code'] = $this -> session -> District;	
		}
		$data['epiWeek'] = $postedVariables['epiWeek'];
		$data['year'] = $postedVariables['year'];
		$data['fileToLoad'] = 'reports/WeeklyAefiCompilation';
		$data['pageTitle']='Weekly AEFI Compilation Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function MeaslesInvestigationCompliance($code=NULL,$year=NULL){
		$data['data'] = $this -> Reports_model -> MeaslesInvestigationCompliance($code,$year);
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}		
		$data['fileToLoad'] = 'reports/MeaslesInvestigationCompliance';
		$data['pageTitle']='Measles Case Investigation Report Compliance';
		$this -> load -> view('template/reports_template',$data);
	}
	public function NNTInvestigationCompliance($code=NULL,$year=NULL){
		$data['data'] = $this -> Reports_model -> NNTInvestigationCompliance($code,$year);
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==9)
			{
				$data["uncode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}		
		$data['fileToLoad'] = 'reports/NNTInvestigationCompliance';
		$data['pageTitle']='NNT Case Investigation Report Compliance';
		$this -> load -> view('template/reports_template',$data);
	}
	public function measlesLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> measlesLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['datefrom'],$postedVariables['dateto']);
		$data['fileToLoad'] = 'reports/measlesLineList';
		$data['pageTitle']='Measle Outbreak Investigation Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function nntLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> nntLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['datefrom'],$postedVariables['dateto']);
		$data['fileToLoad'] = 'reports/nntLineList';
		$data['pageTitle']='NNT Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function diptheriaLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> diptheriaLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['year'],$postedVariables['month']);
		$data['fileToLoad'] = 'reports/diptheriaLineList';
		$data['pageTitle']='Diptheria Outbreak Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function pneumoniaLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> pneumoniaLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['year'],$postedVariables['month']);
		$data['fileToLoad'] = 'reports/pneumoniaLineList';
		$data['pageTitle']='Pneumonia Outbreak Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function pertussisLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> pertussisLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['year'],$postedVariables['month']);
		$data['fileToLoad'] = 'reports/pertussisLineList';
		$data['pageTitle']='Pertussis Outbreak Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function afpLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> afpLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['year'],$postedVariables['month']);
		$data['fileToLoad'] = 'reports/afpLineList';
		$data['pageTitle']='AFP Outbreak Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function childhoodTBLineList(){
		$postedVariables = posted_Values();//posted values from last page
		$wc = getWC_Array($postedVariables['procode'],$postedVariables['distcode']); // function to get wc array
		$data['data'] = $this -> Reports_model -> childhoodTBLineList($wc,$postedVariables['tcode'],$postedVariables['uncode'],$postedVariables['year'],$postedVariables['month']);
		$data['fileToLoad'] = 'reports/childhoodTBLineList';
		$data['pageTitle']='Childhood TB Outbreak Line List Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function Surveillance(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		$data['data'] = $this -> Reports_model -> Surveillance($data);
		//print_r($data['data']);exit;
		$data['fileToLoad'] = 'reports/surveillance_linelist_report';
		$data['pageTitle']='Weekly VPD Surveillance Compilation Report';
		$this -> load -> view('template/reports_template',$data);
	}
	public function testingLibrary(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','weekly');
		$reportPath = base_url()."Reports/Surveillance";
		$reportTitle = "Disease Surveillance Compilation Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}

	public function summaryReports(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (3);
		//echo $functionName;exit;		
		//$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Reports/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,NULL,false,NULL,NULL,"No","Yes");
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'summary_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		//print_r($functionName);exit();
		switch($functionName){
			case "HR-Summary-Report":
				$title = "HR Summary Report";
				break;
		}
		
		return $title;
	}
	function HR_Summary_Report($distcode=NULL, $employee_desg=NULL){		
		// $distcode = $this -> input ->post('distcode');
		// $employee_desg = $this -> input ->post('employee_desg');
		//echo $employee_desg; exit();
		if($distcode && $employee_desg){
			$data = array("distcode"=>$distcode, "employee_desg"=>$employee_desg);
		}else{			
			$data = $this -> getPostedData();
		}
		//$data = $this -> getPostedData();
		//print_r($data = $this -> getPostedData());exit();
		$dataHRSReport['pageTitle']='EPI-MIS | HR Summary Report';
		$dataHRSReport['data'] = $this -> Reports_model -> HR_Summary_Report($data,$dataHRSReport['pageTitle']);
		$dataHRSReport['fileToLoad'] = 'summary_reports/hr_summary_report';
		$this -> load -> view('template/reports_template',$dataHRSReport);
	}
	//=============== Retired HR Report starts here ====================//
	public function retiredHRreport(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		//echo $functionName;exit;		
		//$functionName = str_replace("-", "_", $functionName);
		//$reportPath = base_url()."Reports/".$functionName;
		$reportPath = base_url()."Reports/Retired_HR_Report";
		$reportTitle = "Retired HR Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,NULL,false,NULL,NULL,"No","No",NULL,NULL,"Yes");
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'summary_reports/reports_filters';
		$data['pageTitle']='EPI-MIS | Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}

	function Retired_HR_Report($distcode=NULL, $hr_type=NULL){
		if($distcode && $hr_type){
			$data = array("distcode"=>$distcode, "hr_type"=>$hr_type, "procode"=>$_SESSION["Province"]);
		}
		else{			
			$data = $this -> getPostedData();
		}
		//$data = $this -> getPostedData();
		//print_r($data = $this -> getPostedData());exit();
		$dataRetiredHRReport['pageTitle']='EPI-MIS | Retired HR Report';
		$dataRetiredHRReport['data'] = $this -> Reports_model -> Retired_HR_Report($data,$dataRetiredHRReport['pageTitle']);
		$dataRetiredHRReport['fileToLoad'] = 'summary_reports/retired_hr_report';
		$this -> load -> view('template/reports_template',$dataRetiredHRReport);
	}
	//=============== Retired HR Report ends here ====================//
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}
				else
				{
					$data[$key] = date("Y-m-d",strtotime($data[$key]));
				}
			}
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
	}
	//======= FLCF wise Vaccination Coverage for Children and Women Report Function Starts Here =======//
	public function flcf_wise_vaccination_coverage($code=NULL,$year=NULL){			
		$data['data'] = $this -> Reports_model -> flcf_wise_vaccination_coverage($code,$year);
		$posted = posted_Values();
		foreach($posted as $key => $val)
		{
			$data[$key] = $val;
		}
		if($code)
		{
			if(strlen($code)==3)
			{
				$data["distcode"] = $code;
			}
			if(strlen($code)==6)
			{
				$data["facode"] = $code;
			}			
		}
		if($year)
		{
			$data["report_year"] = $year;
		}
		$data['fileToLoad'] = 'reports/flcf_wise_vaccination_coverage_report';
		$data['pageTitle']='Consolidated Facility Wise Vaccination Coverage of Children and Women';
		//print_r($data);exit();
		$this -> load -> view('template/reports_template',$data);
	}
	//-----------------------------------------------------------------------------------------------//
	
}
?>