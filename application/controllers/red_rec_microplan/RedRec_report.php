<?php 
	class RedRec_report extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		
		$this -> load -> model('Compliances_model');
		$this -> load -> model('red_microplan/Redrec_reportmodel');
		$this -> load -> helper('epi_functions_helper');
		date_default_timezone_set("Asia/Karachi");
		$this -> load -> model('Common_model');
		$this -> load -> model('Filter_model');
		$this->load->helper('my_functions_helper');
		$this -> load -> helper('epi_reports_helper');
	}
	public function redrec_Filters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (3);
		$functionName = str_replace("_Filters", "_Report", $functionName);
		$reportPath = base_url()."red_rec_microplan/RedRec_report/".$functionName;
		$reportTitle = $this->reportTitle($functionName);
		$array =array(
					array(
						'0' => 'Quarter',// Custom Drop Down Name Should be in this format
						'1' => 'Quarter 1',
						'2' => 'Quarter 2',
						'3' => 'Quarter 3',
						'4' => 'Quarter 4'
					)
				);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		if($this -> session -> UserLevel==4){
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,false,false,$reportsperiod=array("yearly"),false,NULL,NULL,'No','No',NULL,$array);
		}else{
			$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportsperiod=array("yearly"),false,NULL,NULL,'No','No',NULL,$array);
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
//		$data['fileToLoad'] = 'reports/reports_filters';
		$data['fileToLoad'] = 'Add_red_microplanning/reports/Reports_filter';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	function redrec_Report(){
		$data = $this -> getPostedData();
		if(isset($data['distcode']))
			$dist = $data['distcode'];
		else 
		$dist = '';
		$quarter = $data['quarter'];
		$year = $data['year'];
		$data['data'] = $this ->Redrec_reportmodel->redrec_Report($data);
		$data['distcode'] = $dist;
		$data['quarter'] = $quarter;
		$data['year'] = $year;
		$data['data']['TopInfo'] = reportsTopInfo("Red Rec Compilation", $data);
		$data['data']['exportIcons']=exportIcons($_REQUEST);
		$data['fileToLoad'] = 'Add_red_microplanning/reports/Reports_views';
		$data['pageTitle']='Red Rec Compilation Report';
		$this -> load -> view('template/reports_template',$data);
		/* 
		$data = $this -> getPostedData();
		$data['data'] = $this ->Redrec_reportmodel->redrec_Report($data);
		if($data != 0){
		$this->load->view('Add_red_microplanning/reports/Reports_view',$data);
		}else{
		$data['message']="You must have rights to access this page.";
		$this->load->view("message",$data);
		} */
	}
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "redrec_Report":
			case "redrec_Report ":
			$title = "Red Rec Compilation Report";
			break;
		}
		return $title;
	}
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value){
			$data[$key] = (($value=='')?NULL:$value);
			foreach ($formats as $format){
				$date = DateTime::createFromFormat($format, $data[$key]);
				if ($date == false || !(date_format($date,$format) == $data[$key]) ) 
				{}else{
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