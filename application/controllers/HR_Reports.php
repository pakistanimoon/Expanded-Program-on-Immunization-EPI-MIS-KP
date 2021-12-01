<?php
//beta
class HR_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Hr_reports_model');
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
	
	// HR Management summary report
	public function summaryreport(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (3);
		//echo $functionName;exit;		
		//$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."HR_Reports/".$functionName;
		$reportTitle = "HR Summary Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'summary_reports/hr_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function HR_Summary_Report($distcode=NULL, $type_id=NULL){
		//echo 'aa'; exit();
		if($distcode && $type_id){
			$data = array("distcode"=>$distcode, "type_id"=>$type_id);
		}else{			
			$data = $this -> getPostedData();
		}
	    //print_r($data); exit();
		$dataHRSReport['data'] = $this -> Hr_reports_model -> HR_Summary_Report($data);
		//print_r($dataHRSReport); exit();
		$UserLevel = $this -> session -> UserLevel;
		if($UserLevel==2){
			if(isset($data['distcode'])){
				$dataHRSReport['fileToLoad'] = 'summary_reports/hr_reports/hr_summary_report_detail';
				$dataHRSReport['pageTitle']='EPI-MIS | HR Listing';
				$this -> load -> view('template/reports_template',$dataHRSReport);
			}else{
				$dataHRSReport['fileToLoad'] = 'summary_reports/hr_reports/hr_summary_report';
				$dataHRSReport['pageTitle']='EPI-MIS | HR Summary Report';
				$this -> load -> view('template/reports_template',$dataHRSReport);
			}
			
		}else{
			$dataHRSReport['fileToLoad'] = 'summary_reports/hr_reports/hr_summary_report_detail';
			$dataHRSReport['pageTitle']='EPI-MIS | HR Listing';
			$this -> load -> view('template/reports_template',$dataHRSReport);
		}
	}
	function HR_Summary_Report_Detail(){
		//echo 'aaa'; exit();
		$data['code'] =  $this -> uri -> segment(3);
		$data['type_id'] =  $this -> uri -> segment(4);
		$data['status'] =  $this -> uri -> segment(5);
		$data['tcode'] =  $this -> uri -> segment(6);
		$data['uncode'] =  $this -> uri -> segment(7);
		$data['facode'] =  $this -> uri -> segment(8);
		//print_r($data); exit();
		$dataHRSReport['data'] = $this -> Hr_reports_model -> HR_Summary_Report_Detail($data);
		$dataHRSReport['fileToLoad'] = 'summary_reports/hr_reports/hr_summary_report_detail';
		$dataHRSReport['pageTitle']='EPI-MIS | HR Listing';
		$this -> load -> view('template/reports_template',$dataHRSReport);
	}
	//=============== Retired HR Report starts here ====================//
	public function retiredHRreport(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		//echo $functionName;exit;		
		//$functionName = str_replace("-", "_", $functionName);
		//$reportPath = base_url()."Reports/".$functionName;
		$reportPath = base_url()."HR_Reports/Retired_HR_Report";
		$reportTitle = "Retired HR Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($this->session->UserLevel==4){
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,NULL,false,NULL,NULL,"No","No",NULL,NULL,"No",NULL,$hrtype=array("hrtype"));	
		}else{
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,NULL,false,NULL,NULL,"No","No",NULL,NULL,"No",NULL,$hrtype=array("hrtype"));	
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'summary_reports/hr_reports/reports_filters';
		$data['pageTitle']='EPI-MIS | Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}

	function Retired_HR_Report($distcode=NULL, $type_id=NULL){
		if($distcode && $type_id){
			$data = array("distcode"=>$distcode, "type_id"=>$type_id, "procode"=>$_SESSION["Province"]);
		}
		else{			
			$data = $this -> getPostedData();
		}
		//$data = $this -> getPostedData();
		//print_r($data = $this -> getPostedData());exit();
		$dataRetiredHRReport['pageTitle']='EPI-MIS | Retired HR Report';
		$dataRetiredHRReport['data'] = $this -> Hr_reports_model -> Retired_HR_Report($data,$dataRetiredHRReport['pageTitle']);
		$dataRetiredHRReport['fileToLoad'] = 'summary_reports/hr_reports/retired_hr_report';
		$this -> load -> view('template/reports_template',$dataRetiredHRReport);
	}
	function Trainings_HR_Report(){
		//$data = $this -> getPostedData();
		//print_r($data = $this -> getPostedData());exit();
		$dataTrainingsHRReport['pageTitle']='EPI-MIS | Trainings HR Report';
		$dataTrainingsHRReport['data'] = $this -> Hr_reports_model -> Trainings_HR_Report($dataTrainingsHRReport['pageTitle']);
		$dataTrainingsHRReport['fileToLoad'] = 'summary_reports/hr_reports/trainings_hr_report';
		$this -> load -> view('template/reports_template',$dataTrainingsHRReport);
	}
	function Trainings_HR_Report_Detail(){
		//echo 'aaa'; exit();
		$data['code'] =  $this -> uri -> segment(3);
		$data['trainingtypes'] =  $this -> uri -> segment(4);
		//print_r($data); exit();
		$dataHRTrainingsReport['data'] = $this -> Hr_reports_model -> Trainings_HR_Report_Detail($data);
		$dataHRTrainingsReport['fileToLoad'] = 'summary_reports/hr_reports/hr_trainings_report_detail';
		$dataHRTrainingsReport['pageTitle']='EPI-MIS | Trainings HR Report';
		//print_r($dataHRTrainingsReport);exit();
		$this -> load -> view('template/reports_template',$dataHRTrainingsReport);
	}
		public function hr_view_status()
	{
		$id = $this->uri->segment(3); 
		//echo $id; exit;
		$data['$data'] = null;
		$data['data'] = $this -> Hr_reports_model ->hr_view_status($id);

		//$data['htmlData'] = $this -> hr_model -> hr_status_edit($id);
		//print_r($data['htmlData']);exit();
		//print_r($data['htmlData']['htmlData']); exit();
		$data['fileToLoad'] = 'summary_reports/hr_reports/hr_view_status';
		$data['pageTitle'] = 'EPI-MIS | View HR Form';
		$this -> load -> view('template/epi_template', $data);
	}
	function getPostedData(){
		$data=array();
		//$dataPosted=array();
		//$dataPosted = $_POST;
		$dataPosted = $this->input->post();
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			if(strpos("date",$key)!==FALSE){
				foreach ($formats as $format)
				{
					$date = DateTime::createFromFormat($format, $data[$key]);
					if ($date == false || !(date_format($date,$format) == $data[$key]) ){}else{
						$data[$key] = date("Y-m-d",strtotime($data[$key]));
					}
				}
			}
			if($data[$key] == NULL || $data[$key]=="0"){
				unset($data[$key]);
			}
		}
		return $data;
	}
}
?>	