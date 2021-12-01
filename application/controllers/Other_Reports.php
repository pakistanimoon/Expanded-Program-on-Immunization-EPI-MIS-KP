<?php
class Other_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('other_reports_model');
		$this -> load -> helper('epi_functions_helper');
		$code = md5(date("Y-n-d"));
		if((isset($_REQUEST['code']) && $_REQUEST['code'] == $code) || (($this-> uri-> segment(8) != '' && $this-> uri-> segment(8) == $code) || ($this-> uri-> segment(9) != '' &&  $this-> uri-> segment(9) == $code))){
			$provinceCode = (isset($_REQUEST['procode']))?$_REQUEST['procode']:$this->uri->segment(3); // procode during drilldown from Federal EPI
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
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('yearly','monthly');
		$functionName = $this -> uri -> segment (3);
		$reportPath = base_url()."Surveillance/".$functionName; 

		$reportTitle = $this->reportTitle($functionName);
		$indicators = $functionName;
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($functionName == 'EPID'){
			$customDropDown = array(
				array(
					'0' => 'Disease', // Custom Drop Down Name Should be in this format
					//'all' => 'All Diseases',
					'measles' => 'Measles',
					'afp' => 'Acute Flacid Pralysis',
					//'nnt' => 'NNT',
					'diphtheria' => 'Diphtheria',
					'pertussis' => 'Pertussis',
					'pneumonia' => 'Pneumonia',
					'childhood tb' => 'Childhood TB',
					'meningitis' => 'Meningitis',
					'hepatitis' => 'Hepatitis'
				),
				array(
					'0' => 'Report Type', // Custom Drop Down Name Should be in this format
					'gender_wise' => 'Gender Wise',
					'age_wise' => 'Age Wise'
					// 'wgender' => 'Weekly Gender Wise',
					// 'mgender' => 'Monthly Gender Wise',
					// 'wage' => 'Weekly Age Wise',
					// 'mage' => 'Monthly Age Wise'
				)
			);
			//$reportPeriod = array('month-from-to');
			$reportPeriod = array('year','from_week','to_week');
			$dataHtml .= $this->reportfilters->createReportFilters(false,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}elseif($functionName == 'OUTBREAK'){
			$customDropDown = array(
				array(
					'0' => 'Disease', // Custom Drop Down Name Should be in this format
					'measles' => 'Measles',
					'afp' => 'Acute Flacid Pralysis',
					//'nnt' => 'NNT',
					'diphtheria' => 'Diphtheria',
					'pertussis' => 'Pertussis',
					'pneumonia' => 'Pneumonia',
					'childhood tb' => 'Childhood TB',
					'meningitis' => 'Meningitis',
					'hepatitis' => 'Hepatitis'
				)
			);
			$reportPeriod = array('year','from_week','to_week');
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}
		else if($functionName == 'VPD'){
			$customDropDown = array(
				array(
					'0' => 'Report Type', // Custom Drop Down Name Should be in this format
					'wwise' => 'Week Wise',
					//'mwise' => 'Month Wise',
					'dwise' => 'District Wise',
					'fwise' => 'Facility Wise'
				)
			);
			//$reportPeriod = array('cryearly','weekly','dates');
			$reportPeriod = array('year','from_week','to_week');
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}elseif($functionName == 'Outbreak_Response'){
			$customDropDown = array(
				array(
					'0' => 'Indicator', // Custom Drop Down Name Should be in this format
					
					'district wise' => 'District Wise',
					'vaccine wise' => 'Vaccine Wise'
				), array(
					'0' => 'Disease', // Custom Drop Down Name Should be in this format
					'Measles' => 'Measles',
					'afp' => 'Acute Flacid Pralysis',
					//'nnt' => 'NNT',
					'Diphtheria' => 'Diphtheria',
					'Pertussis' => 'Pertussis',
					'Pneumonia' => 'Pneumonia',
					'Childhood TB' => 'Childhood TB',
					'Meningitis' => 'Meningitis',
					'Hepatitis' => 'Hepatitis',
					'Typhoid' => 'Typhoid'
				) 
			);
			$reportPeriod = array('date-from-to-date');
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,$customDropDown);
		}else
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'other_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Monthly Surveillance Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "MSR":
				$title = "Monthly Surveillance Report";
				break;
			case "EPID":
				$title = "Age/Gender Wise Count of EPID";
				break;
			case "VPD":
				$title = "Weekly/Monthly/District Wise VPD";
				break;
			case "OUTBREAK":
				$title = "Disease Outbreak Report";
				break;
			case "Outbreak_Response":
				$title = "Outbreak Responses";
				break;
		}
		return $title;
	}
	function disease_outbreak($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL, $disease=NULL)
	{
		//kp
	//	exit;
		
		if($distcode AND $year AND $from_week AND $to_week AND $disease)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'from_week' => $from_week ,'to_week' => $to_week , 'disease' => $disease);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}
		//print_r($data);
		$dataMSR['data'] = $this-> other_reports_model->disease_outbreak($data);
		//echo $this -> db -> last_query();exit();
		$dataMSR['fileToLoad'] = 'other_reports/outbreak_report';
		$dataMSR['pageTitle']='EPI-MIS | Age/Gender Wise Count of EPID';
		$this->load->view('template/reports_template',$dataMSR);
	}

	function EPID_Count($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL, $disease=NULL, $case_type=NULL, $report_type=NULL){
		// $distcode = ($this -> session -> District)?$this -> session -> District:0;
		// $data = $this -> getPostedData();
		if($distcode AND $year AND $report_type)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'from_week' => $from_week ,'to_week' => $to_week , 'disease' => $disease, 'report_type' => $report_type);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}

		if($this-> uri-> segment(6) != ''){
			$data['procode'] = $procode = $this-> uri-> segment(3);
			$data['year'] = $year = $this-> uri-> segment(4);
			$data['from_week'] = $from_week = $this-> uri-> segment(5);
			$data['to_week'] = $to_week = $this-> uri-> segment(6);
			$data['disease'] = $disease = $this-> uri-> segment(7);
			$data['case_type'] = $case_type = $this-> uri-> segment(7);
			$data['report_type'] = $report_type = $this-> uri-> segment(8);
			unset($data['distcode']);
			//print_r($data); exit();
		}
		$dataMSR['data'] = $this -> other_reports_model -> EPID($data);
		$dataMSR['fileToLoad'] = 'other_reports/epid_count_report_view';
		$dataMSR['pageTitle']='EPI-MIS | Age/Gender Wise VPD';
		$this->load->view('template/reports_template',$dataMSR);
	}

	function VPD_Count($distcode=NULL, $year=NULL, $from_week=NULL, $to_week=NULL, $report_type=NULL)
	{ 
		//print_r($_POST);exit();
		if($distcode AND $year AND $report_type)
		{
			$data = array('distcode' => $distcode, 'year' => $year, 'from_week' => $from_week ,'to_week' => $to_week , 'report_type' => $report_type);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}
		if($this-> uri-> segment(6) != ''){
			$data['procode'] = $procode = $this-> uri-> segment(3);
			$data['year'] = $year = $this-> uri-> segment(4);
			$data['from_week'] = $from_week = $this-> uri-> segment(5);
			$data['to_week'] = $to_week = $this-> uri-> segment(6);
			//unset($data['distcode']);
			//print_r($data); exit();
		}
		$dataMSR['data'] = $this-> other_reports_model-> VPD($data);
		//echo '<pre>'; print_r($dataMSR); exit;
		$dataMSR['fileToLoad'] = 'other_reports/vpd_count_report_view';
		$dataMSR['pageTitle'] = 'EPI-MIS | Weekly/District/Facility Wise VPD';
		$this->load->view('template/reports_template',$dataMSR);
		//template_loader('other_reports/vpd_count_report_view', $dataMSR, array($this->_module), 'reports');
	}

	function disease_outbreak_villages()
	{
		//print_r($_POST);exit();
		$code = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$disease = $this -> uri -> segment(5);
		if(strlen($code) == 9){
			$uncode = $code;
			$data = array('uncode' => $uncode, 'year' => $year, 'disease' => $disease);
		}
		else
		{
			$distcode = ($this -> session -> District)?$this -> session -> District:0;
			$data = $this -> getPostedData();
		}
		//print_r($data);exit();
		$dataMSR['data'] = $this-> other_reports_model->disease_outbreak($data);
		$dataMSR['fileToLoad'] = 'other_reports/outbreak_report';
		$dataMSR['pageTitle']='EPI-MIS | Age/Gender Wise Count of EPID';
		$this->load->view('template/reports_template',$dataMSR);
	}
	function MSR(){
		$distcode = ($this -> session -> District)?$this -> session -> District:0;
		$data = $this -> getPostedData();
		$dataMSR['data'] = $this -> other_reports_model -> MSR($data);
		$dataMSR['fileToLoad'] = 'other_reports/surveillance_report_view';
		$dataMSR['pageTitle']='EPI-MIS | Monthly Surveillance Report';
		$this->load->view('template/reports_template',$dataMSR);
	}	
	
	function Outbreak_Response($distcode=NULL, $disease=NULL, $Indicator=NULL, $date_of_activity_from=NULL, $date_of_activity_to=NULL){		
		//echo jjj; exit;
		//echo $Indicator; exit;
		/* $data = array( 'indicator' => $Indicator );
		$date_of_activity_from = $data['monthfrom'];
				$date_of_activity_to = $data['monthto'];
		echo $data['indicator']; exit; */
		if($distcode && $disease){
			$data = array("distcode"=>$distcode, 'disease' => $disease, 'indicator' => $Indicator, 'date_of_activity_from' =>$date_of_activity_from, 'date_of_activity_to'=>$date_of_activity_to);
		}else{
			$data = $this -> getPostedData();
		}	
		//echo $data['indicator']; exit;
		if($data['indicator'] == "district wise")
		{
			if($this->input->post('distcode')){
				$this->outbreak_report(); exit;
			}
			if( $data['disease'] == "Diphtheria")
			{
				$dataDeptheria['pageTitle'] = 'Diphtheria Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);
				//print_r($dataDeptheria['data']); exit; 				
				$dataDeptheria['fileToLoad'] = 'other_reports/deptheria_outbreak_response';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}
			else if( $data['disease'] == "Measles")
			{
				$dataDeptheria['pageTitle'] = 'Measles Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);
				
				//print_r($dataDeptheria['data']); exit; 
				
				$dataDeptheria['fileToLoad'] = 'other_reports/msl_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}
			else if( $data['disease'] == "Acute Flacid Paralysis")
			{
				$dataDeptheria['pageTitle'] = 'Acute Flacid Paralysis Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/acute_flacid_paralysis_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}
			else if( $data['disease'] == "Pertussis")
			{
				$dataDeptheria['pageTitle'] = 'Pertussis Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/pertussis_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}
			else if( $data['disease'] == "Pneumonia")
			{
				$dataDeptheria['pageTitle'] = 'Pneumonia Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/pneumonia_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}												
			else if( $data['disease'] == "Meningitis")
			{
				$dataDeptheria['pageTitle'] = 'Meningitis Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/meningitis_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}													  
			else if( $data['disease'] == "Hepatitis")
			{
				$dataDeptheria['pageTitle'] = 'Hepatitis Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/hepatitis_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}else if( $data['disease'] == "Typhoid")
			{
				$dataDeptheria['pageTitle'] = 'Typhoid Outbreak Response';
				$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponse($data,$dataDeptheria['pageTitle']);			
				//print_r($dataDeptheria['data']); exit(); 			
				$dataDeptheria['fileToLoad'] = 'other_reports/typhoid_response_compliance';
				$this -> load -> view('template/reports_template',$dataDeptheria);
			}
		}
		else if (($data['indicator'] == "vaccine wise")){
			//echo abc; 
			//print_r($data); exit;
			if(isset($data['distcode']) > 0){
				$distcode = $data['distcode'];
			}else{
				$distcode = NULL;
			}

			$date_of_activity_from = $data['monthfrom'];
			$date_of_activity_to = $data['monthto'];
			$data = $this -> other_reports_model -> outbreak_report_list($distcode,$date_of_activity_from,$date_of_activity_to);
			$data['argu'] = array($distcode,$date_of_activity_from,$date_of_activity_to);
			//print_r($data); exit;
			$this->load->view('other_reports/outbreak_report_vaccine',$data);	
		}
		
	}
	function outbreak_report(){
		//echo "yyy"; print_r($_POST);
		$distcode = ($this -> input -> post('distcode'))?$this -> input -> post('distcode'):$this -> uri -> segment(3);
		
		//$year = $this -> uri -> segment(4);
		 $disease = ($this -> input -> post('disease'))?$this -> input -> post('disease'):$this -> uri -> segment(4);
		 $monthfrom = ($this -> input -> post('monthfrom'))?$this -> input -> post('monthfrom'):$this -> uri -> segment(5);
		 $monthto = ($this -> input -> post('monthto'))?$this -> input -> post('monthto'):$this -> uri -> segment(6); 
		if($distcode && $disease){
			$data = array("distcode"=>$distcode, 'disease' => $disease, 'monthfrom' =>$monthfrom, 'monthto' =>$monthto);
		}else{
			$data = $this -> getPostedData();
		}	
		if( $disease == "Diphtheria")
		{
			$dataDeptheria['pageTitle'] = 'Diphtheria Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);
			
			
			//print_r($dataDeptheria['data']); exit; 
			
			$dataDeptheria['fileToLoad'] = 'other_reports/deptheria_outbreak_response_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
		else if( $disease == "Measles")
		{
			$dataDeptheria['pageTitle'] = 'Measles Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);
			
			//print_r($dataDeptheria['data']); exit; 
			
			$dataDeptheria['fileToLoad'] = 'other_reports/msl_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
		else if( $disease == "Acute Flacid Paralysis")
		{
			$dataDeptheria['pageTitle'] = 'Acute Flacid Paralysis Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/acute_flacid_paralysis_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
		else if( $disease == "Pertussis")
		{
			$dataDeptheria['pageTitle'] = 'Pertussis Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/pertussis_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
		else if( $disease == "Pneumonia")
		{
			$dataDeptheria['pageTitle'] = 'Pneumonia Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/pneumonia_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}												
		else if( $disease == "Meningitis")
		{
			$dataDeptheria['pageTitle'] = 'Meningitis Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/meningitis_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}													  
		else if( $disease == "Hepatitis")
		{
			$dataDeptheria['pageTitle'] = 'Hepatitis Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/hepatitis_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
		else if( $disease == "Typhoid")
		{
			$dataDeptheria['pageTitle'] = 'Typhoid Outbreak Response';
			$dataDeptheria['data'] = $this -> other_reports_model -> OutbreakResponseMeasles($data,$dataDeptheria['pageTitle']);			
			//print_r($dataDeptheria['data']); exit(); 			
			$dataDeptheria['fileToLoad'] = 'other_reports/typhoid_response_compliance_report';
			$this -> load -> view('template/reports_template',$dataDeptheria);
		}
	}
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
}
?>