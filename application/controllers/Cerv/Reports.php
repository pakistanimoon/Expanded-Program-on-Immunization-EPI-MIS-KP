<?php
//local
class Reports extends CI_Controller 
{
	
	public function __construct() 
	{
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
		$this -> load -> helper('epi_functions_helper');
		authentication();
		$this -> load -> model('cerv/Cerv_reports_model','cerv');
	}
	
	function reportTitle($functionName){
		$title = "";
		switch($functionName){
			case "zero_dose":
				$title = "CERV Zero Dose Children Report";
				break;
			case "dropouts":
				$title = "CERV Dropout Report";
				break;
			case "cervMonthlyReport":
				$title = "Cerv Monthly Report";
				break;
		}
		return $title;
	}
	
	public function zero_dose_children_filters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		$reportPeriod = NULL;
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Cerv/Reports/".$functionName;
		$reportTitle = $this -> reportTitle($functionName);
		$dataHtml = $this -> reportfilters -> filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this -> reportfilters -> createReportFilters(true,true,true,false,$reportPeriod,false);
		$dataHtml .= $this -> reportfilters -> filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'cervReports/reports_filters';
		$data['pageTitle'] = 'EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	
	public function dropout_filters(){
		$this -> load -> library('reportfilters');
		$functionName = $this -> uri -> segment (2);
		$functionName = str_replace("-", "_", $functionName);
		$reportPath = base_url()."Cerv/Reports/".$functionName;
		$reportTitle = $this -> reportTitle($functionName);
		$customDropdown = array(
			array(
				0 => 'Dropout Type',
				'bcg-penta1' => 'BCG - PENTA1',
				'penta1-penta3' => 'PENTA1 - PENTA3',
				'penta1-measles1' => 'PENTA1 - MEASLES1',
				'measles1-measles2' => 'MEASLES1 - MEASLES2'
			)
		);
		$dataHtml = $this -> reportfilters -> filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this -> reportfilters -> createReportFilters(true, true, true, false, NULL, false, NULL, NULL, "No", "No", NULL, $customDropdown);
		$dataHtml .= $this -> reportfilters -> filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['edit'] = "Yes";
		$data['fileToLoad'] = 'cervReports/reports_filters';
		$data['pageTitle']='EPI-MIS Report Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	
	public function zero_dose(){
		$topInfoData['distcode'] = $distcode = $this -> session -> District;
		$tcode = $uncode = false;
		if($this -> input -> post('tcode'))
			$topInfoData['tcode'] = $tcode = $this -> input -> post('tcode');
		if($this -> input -> post('uncode'))
			$topInfoData['uncode'] = $uncode = $this -> input -> post('uncode');
		
		$data['zeroDose'] = $this -> cerv -> zero_dose($distcode,$tcode,$uncode);
		$innerQuery = $this -> db -> last_query();
		$data['totalZeroDose'] = $this -> cerv -> getTotalZeroDoseChildren($innerQuery);
		$data['pageTitle']='Zero Dose Children Report';
		$data['tableData'] = getListingReportTable($data['zeroDose'], 'Zero Dose Children', $data['totalZeroDose']);
		$data['TopInfo'] = reportsTopInfo($data['pageTitle'], $topInfoData);
		$data['exportIcons']=exportIcons($_REQUEST);
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=ZeroDoseChildrenReport.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data'] = $data;
		$data['fileToLoad'] = 'cervReports/showReport';
		$this -> load -> view('template/reports_template',$data);
	}
	
	public function dropouts(){
		$topInfoData['distcode'] = $distcode = $this -> session -> District;
		$topInfoData['dropout_type'] = $dropout_type = $this -> input -> post('dropout_type');
		$tcode = $uncode = false;
		if($this -> input -> post('tcode'))
			$topInfoData['tcode'] = $tcode = $this -> input -> post('tcode');
		if($this -> input -> post('uncode'))
			$topInfoData['uncode'] = $uncode = $this -> input -> post('uncode');
		
		$innerQueryResult = $this -> cerv -> dropouts_inner_query($distcode,$tcode,$uncode,$dropout_type);
		$innerQuery = $this -> db -> last_query();
		$data['dropout'] = $this -> cerv -> dropout_outer_query($innerQuery, $dropout_type);
		//echo $outerQuery = $this -> db -> last_query();exit;
		$data['totalDropout'] = $this -> cerv -> dropout_total_query($outerQuery, $dropout_type);
		$data['pageTitle']='Dropout Report';
		$data['tableData'] = getListingReportTable($data['dropout'], 'Dropout Report', $data['totalDropout'], 'Yes', 'Yes');
		$data['TopInfo'] = reportsTopInfo($data['pageTitle'], $topInfoData);
		$data['exportIcons'] = exportIcons($_REQUEST);
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=CervDropoutReport.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['data'] = $data;
		$data['fileToLoad'] = 'cervReports/showReport';
		$this -> load -> view('template/reports_template',$data);
	}
	
		public function cervMonthlyReport()
		{
			$this -> load -> library('reportfilters');
			$functionName = $this -> uri -> segment (3); 
			$functionName = str_replace("-", "_", $functionName);
			$reportPath = base_url()."Cerv/Reports/MVRFV/".$functionName;
			$reportTitle = $this -> reportTitle($functionName);
			$reportPeriod = array("month-from"); 
			
			$dataHtml = $this -> reportfilters -> filtersHeader($reportPath,$reportTitle);
			$dataHtml .= $this->reportfilters->createReportFilters(true,true,true,false,$reportPeriod,false,NULL,NULL,"No","No",NULL);
			$dataHtml .= $this -> reportfilters -> filtersFooter();
			
			$data['listing_filters'] = $dataHtml;
			$data['data']=$data;
			$data['edit'] = "Yes";
			$data['fileToLoad'] = 'cervReports/reports_filters';
			$data['pageTitle']='EPI-MIS Report Filters';
			$this -> load -> view('template/epi_template',$data);
		}
	
		public function MVRFV(){
			$data = $this -> getPostedData();
			$data['data'] = $data;//getvaccinereport($data);
			$data['fileToLoad'] = 'cerv/cervMonthlyVaccinationReportview';
			$data['pageTitle']='EPI-MIS | View Facility Monthly Vaccination Report';
			$this->load->view('template/epi_template',$data); 
			return $data;
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