<?php
class Advance_Reports extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Advance_reports_model');
		$this -> load -> helper('epi_functions_helper');
		$this -> load -> helper('inventory_helper');
		authentication();
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function reportFilters(){
        $username=$this -> session -> username;		
	    //dataEntryValidator(0);
		$this -> load -> library('reportfilters');
		$reportPeriod = array('month-from-to-previous');
		$functionName = $this -> uri -> segment (3);
		$moduleID = ($functionName == "HFMVRF-Advance-Report")?"3":(($functionName == "HFCR-Advance-Report")?"7":(($functionName == "HFMVRF-Advance-Report2")?"4":(($functionName == "HR-Advance-Report")?"1":(($functionName == "Disease-Surveillance-Advance-Report")?"5":""))));
		$reportPath = base_url()."Advance-Report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$options = array(0=>'TypeWise','uc'=>'Uc Wise','fac'=>'Facility Wise');
		$customDropdown = array($options);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
        /* if($functionName=="HR-Advance-Report"){
			if($this -> session -> UserLevel == '4'){	
			$options = array(0=>'HR Type','sl'=>'Supervisors','co'=>'Computer Operator ','hf'=>'HF Incharges','sk'=>'Store Keeper ','epit'=>'EPI Technician ','cct'=>'Cold Chain Technician ','cco'=>'Cold Chain Operator ','go'=>'Generator Operator ','ccm'=>'Cold Chain Mechanic','dd'=>'Drivers');
			}else{
			$options = array(0=>'HR Type','sl'=>'Supervisors','dso'=>'District Surveillance Officer ','co'=>'Computer Operator ','hf'=>'HF Incharges','sk'=>'Store Keeper ','epit'=>'EPI Technician ','cct'=>'Cold Chain Technician ','cco'=>'Cold Chain Operator ','go'=>'Generator Operator ','ccm'=>'Cold Chain Mechanic','dd'=>'Drivers');	
			}
			$customDropdown = array($options);
			if($this -> session -> UserLevel == '4'){
				$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,false,false,NULL,NULL,$moduleID,'NO',NULL,$customDropdown);

			}else{
				$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,false,false,NULL,NULL,$moduleID,'NO',NULL,$customDropdown);
			}
	    } */
		if($functionName=="HR-Advance-Report"){
		//$options = array(0=>'HR Type','sl'=>'Supervisors','dso'=>'District Surveillance Officer ','co'=>'Computer Operator ','hf'=>'HF Incharges','sk'=>'Store Keeper ','epit'=>'EPI Technician ','cct'=>'Cold Chain Technician ','cco'=>'Cold Chain Operator ','go'=>'Generator Operator ','ccm'=>'Cold Chain Mechanic','dd'=>'Drivers');
		//$customDropdown = array($options);
		
			//$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,false,false,NULL,NULL,$moduleID,'NO',NULL,$customDropdown);
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,false,false,NULL,NULL,$moduleID,'NO',NULL,NULL,"No",NULL,$hrtype=array("allhrtype"));
		}
		else if($functionName=="Disease-Surveillance-Advance-Report"){
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportsperiod=array("year","from_week","to_week"),false,NULL,NULL,$moduleID,'NO',NULL,NULL);
		}
		else if($functionName=="HFCR-Advance-Report"){
			$reportlevelarr = array("0"=>"Product")+array_column ( get_products_by_activity(1,TRUE,NULL,FALSE), "name","id");
			$typewise = array(0=>'TypeWise','uc'=>'Uc Wise','fac'=>'Facility Wise');
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,NULL,NULL,$moduleID,'NO',NULL,array($typewise,$reportlevelarr));
		}
		else{
		$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,true,$reportPeriod,false,NULL,NULL,$moduleID,'NO',NULL,$customDropdown);
		}
		$dataHtml .= $this->reportfilters->filtersFooter("Yes");
		//print_r($moduleID);
		//print_r($dataHtml);exit;
		$data['listing_filters'] = $dataHtml;
		//$data['consumption_advance_filters'] = $indicators;
		//HFMAdvancereport
		if($reportTitle == "Health Facility Monthly Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('module_id', '3');
		$this -> db -> order_by('description');
		$data['allSections'] = $this -> db -> get('epi_sections') -> result_array();
		}
		if($reportTitle == "Health Facility Monthly Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('username',$username);
		$this -> db -> where('module_id', '3');
		$this -> db -> order_by('report_title');
		$data['allReports'] = $this -> db -> get('adv_reports') -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		}
		//end HFMAdvancereport
		//HFCRAdvancereport
		if($reportTitle == "HF Consumption and Requisition Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('module_id', '7');
		$this -> db -> order_by('description');
		$data['allSections'] = $this -> db -> get('epi_sections') -> result_array();
		} 
		if($reportTitle == "HF Consumption and Requisition Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('username',$username);
		$this -> db -> where('module_id', '7');
		$this -> db -> order_by('report_title');
		$data['allReports'] = $this -> db -> get('adv_reports') -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		}
		//end HFCRAdvancereport
		//HRAdvancereport
		if($reportTitle == "HR Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('module_id', '1');
		$this -> db -> order_by('description');
		$data['allSections'] = $this -> db -> get('epi_sections') -> result_array();
		} 
		
		if($reportTitle == "HR Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('username',$username);
		$this -> db -> where('module_id', '1');
		$this -> db -> order_by('report_title');
		$data['allReports'] = $this -> db -> get('adv_reports') -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		}
		//end HRAdvancereport
		//DSAdvancereport
		if($reportTitle == "Disease Surveillance Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('module_id', '5');
		$this -> db -> order_by('description');
		$data['allSections'] = $this -> db -> get('epi_sections') -> result_array();
		} 
		
		if($reportTitle == "Disease Surveillance Advance Report"){
		$this -> db -> select('*');
		$this -> db -> where('username',$username);
		$this -> db -> where('module_id', '5');
		$this -> db -> order_by('report_title');
		$data['allReports'] = $this -> db -> get('adv_reports') -> result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		}
		//end DSAdvancereport
		$data['data']=$data;
		$data['edit'] = "Yes";
	    $data['fileToLoad'] = 'advance_reports/reports_filters';
		$data['pageTitle']='EPI-MIS Advance Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "HFMVRF-Advance-Report":
				$title = "Health Facility Monthly Advance Report";
				break;
			case "HFCR-Advance-Report":
				$title = "HF Consumption and Requisition Advance Report";
				break;
				//HRAdvancereport
			case "HR-Advance-Report":
				$title = "HR Advance Report";
				break;
				//end HRAdvancereport
				//DSAdvancereport
			case "Disease-Surveillance-Advance-Report":
				$title = "Disease Surveillance Advance Report";
				break;
				//end DSAdvancereport	
		}
		return $title;
	}
	function HFMVRF_Advance_Report(){	
		//echo "danish";exit;
		$dataHFMVRF['pageTitle']='Advance Report';
		$data = $this -> getPostedData();
		$dataHFMVRF['data'] = $this -> Advance_reports_model -> HFMVRF_Advance_Report($data,$dataHFMVRF['pageTitle']);
		// print_r($dataHFMVRF['data']);exit;
		$dataHFMVRF['fileToLoad'] = 'advance_reports/advance_report_view';
		$dataHFMVRF['pageTitle']='EPI-MIS | Advance report';
		$this->load->view('template/reports_template',$dataHFMVRF);
	}
	function HFCR_Advance_Report(){    
        //print_r($_POST);exit;      
	    //dataEntryValidator(0);	
		$dataHFCR['pageTitle']='Advance Report';
		$data = $this -> getPostedData();
		$dataHFCR['data'] = $this -> Advance_reports_model -> HFCR_Advance_Report($data,$dataHFCR['pageTitle']);
		$dataHFCR['fileToLoad'] = 'advance_reports/advance_report_view';
		$dataHFCR['pageTitle']='EPI-MIS | Advance report';
		$this->load->view('template/reports_template',$dataHFCR);
	}
	//HRAdvancereport
	function HR_Advance_Report(){        
	   	//dataEntryValidator(0);		
		$dataHR['pageTitle']='Advance Report';
		$data = $this -> getPostedData();
		//print_r($data);exit;
		$dataHR['data'] = $this -> Advance_reports_model -> HR_Advance_Report($data,$dataHR['pageTitle']);
		$dataHR['fileToLoad'] = 'advance_reports/advance_report_view';
		$dataHR['pageTitle']='EPI-MIS | Advance report';
		$this->load->view('template/reports_template',$dataHR);
	}
	//end HRAdvancereport
	//DSAdvancereport
	function Disease_Surveillance_Advance_Report(){        
	    //dataEntryValidator(0);	
		$dataDS['pageTitle']='Advance Report';
		$data = $this -> getPostedData();
		//print_r($data);exit;
		$dataDS['data'] = $this -> Advance_reports_model -> Disease_Surveillance_Advance_Report($data,$dataDS['pageTitle']);
		
		$dataDS['fileToLoad'] = 'advance_reports/advance_report_view';
		$dataDS['pageTitle']='EPI-MIS | Advance report';
		$this->load->view('template/reports_template',$dataDS);
	}
	//end DSAdvancereport
	
	//HRAdvancereportDelete
	public function delete_report(){
		$report_id = $this->input->post("report_id"); 
		$data['file'] = $this->Advance_reports_model->report_delete($report_id);
		$data['field'] = $this->Advance_reports_model->reportdata_delete($report_id);
		echo json_encode($data,true);
	}
	//end HRAdvancereportDelete
	
	//HRAdvancereportEdit
	public function edit_report(){
		$report_id = $this->input->post("report_id"); 
		$data['title'] = $this->Advance_reports_model->get_report_title($report_id);
		//$data['detail'] = $this->Advance_reports_model->get_report_data($report_id);
		 echo json_encode($data['title'],true);
		//$result=$this->load->view('advance_reports/edit_reportfilter',$data,true);
		//echo $result;
	}
	 public function edit_report_data(){
		$report_id = $this->input->post("report_id"); 
		$data['detail'] = $this->Advance_reports_model->get_report_data($report_id);
		$result=$this->load->view('advance_reports/edit_reportfilter',$data,true);
		echo $result;
	} 
	//end HRAdvancereportEdit
	public function get_dataelement(){
		$value = $this->input->post("value"); 
		$data['value'] = $this->Advance_reports_model->get_fields_elements($value);
		 echo json_encode($data['value'],true);
	}
	
	
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		//print_r($dataPosted); exit;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y","mm-yyyy","yyyy-mm");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format)
			{
				$date = DateTime::createFromFormat($format,$data[$key]);
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