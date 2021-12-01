<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Filters Class
 *
 * This class manages the reports filters object
 *
 * @package		Report Filters
 * @version		1.2
 * @author 		Uzair <uzair.bsse942@gmail.com>
 * @Updation	Imran <rajaimranqamer@gmail.com>
 * @copyright 	Copyright (c) 2016, Pace-Tech
 * @link		
 */
class Reportfilters {
	
	/**
	 * ReportFilters stack
	 *
     */
	private $options = array();
	private $result = array();
	private $ulevel = "";
	private $utype = "";
	private $otherAttributes = "";
	private $outputHtml = "";
	 /**
	  * Constructor
	  *
	  * @access	public
	  *
	  */
	public function __construct()
	{	//initialize codeigniter instance
		$this->ci =& get_instance();
		//Get Session Library loaded
		$this->ci->load->library('session');
		//Get database Library loaded
		$this->db = $this->ci->load->database('default',TRUE);
		// Get html helper loaded
		$this->ci->load->helper('html');
		// Get Form Helper Loaded
		$this->ci->load->helper('form');
		// set variables
		$this->ulevel = $this->ci->session->UserLevel;
		$this->utype = $this->ci->session->utype;
		
		log_message('debug', "Report Filters Class Initialized");
	}
	
	// --------------------------------------------------------------------

	/**
	 * Main function to dynamically create filters based on desired filters
	 *
	 * @access	public
	 * @param	boolen 					$district
	 * @param	boolen 					$tehsil
	 * @param	boolen 					$uc
	 * @param	boolen 					$hf
	 * @param	array  					$reportPeriod
	 * @param	multidimenttional_array $extraNeededFilters
	 * @param	string 					$reportPath
	 * @param	string 					$reportFiltersTitle
	 * @return	void
	 */		
	function createReportFilters($district=false, $tehsil=false, $uc=false, $hf=false, $reportPeriod=NULL, $reportType=false, $indicators=NULL, $extraNeededFilters=NULL, $advanceReport="No", $summaryReport="No", $typeWiseReport=NULL, $customDropdown=NULL, $retiredHRreport="No")
	{
		if($district == true)
			$this->districtFilter();
		if($tehsil == true)
			$this->tehsilFilter();
		if($uc == true)
			$this->ucFilter();
		if($hf == true)
			$this->hfFilter();
		if($reportPeriod)
			$this->reportPeriod($reportPeriod);
		if($reportType == true)
			$this->reportType();
		if(!(is_null($extraNeededFilters)))
			$this->extraNeededFilters($extraNeededFilters);
		if(!(is_null($indicators)))
			$this->indicators($indicators);
		if($advanceReport && $advanceReport != "No")
			$this->advanceReport($advanceReport);
		if($summaryReport == "Yes")
			$this->summaryReport();
		if(!(is_null($typeWiseReport)))
			$this->typeWiseReport();
		if(!(is_null($customDropdown)))
			$this->customDropdown($customDropdown);
		if($retiredHRreport == "Yes")
			$this->retiredHRreport();
		return $this->outputHtml;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Create ExtraNeededFilters Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function extraNeededFilters($extraNeededFilters){
		if(in_array("caseType",$extraNeededFilters)){
			$this->db->select('*');
			if($this->ci->session->District){}else{
				$this->db->where('pro','1');
			}
			$this->result = $this->db->get('surveillance_cases_types')->result_array();
			foreach($this->result as $key => $val){
				$this->options[$val['short_name']] = $val['type_case_name'];
			}
			$this->otherAttributes = 'id="case_type" class="form-control"';
			$this->filterRowCreation("Case Type", "case_type",$this->otherAttributes, $this->options, "dropdown");
		}
		//edite by raja imran 2018-09-18
		if(in_array("invnRepType",$extraNeededFilters)){
			$this->filterRowCreation("Report Type", NULL,NULL, $extraNeededFilters, "radio");
		}
	}
	// --------------------------------------------------------------------

	/**
	 * Create District Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function districtFilter()
	{
		$this->db->select('distcode,districtname(distcode) as district ');
		if($this->ulevel=='99')
		{
			$this->options[0] = "--Select District--";
			$this->db->where('procode',$this->ci->session->Province);
		}
		if($this->ulevel=='2')
		{
			$this->options[0] = "--Select District--";
			$this->db->where('procode',$this->ci->session->Province);
		}
		if($this->ulevel=='3')
			$this->db->where('distcode',$this->ci->session->District);
		$this->db->order_by('district asc');
		$this->result = $this->db->get('districts')->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['distcode']] = $val['district'];
		}
		$this->otherAttributes = 'id="distcode" class="form-control"';
		$this->filterRowCreation("District", "distcode",$this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	

	/**
	 * Create Tehsil Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function tehsilFilter()
	{
		$this->options[0] = "";
		if($this->ulevel=='2'){
		}else{
			$this->options[0] = "--Select Tehsil--";
			$this->db->select('tcode,tehsilname(tcode) as tehsil');
			if($this->ulevel=='3')
				$this->db->where('distcode',$this->ci->session->District);
			$this->db->order_by('tehsil asc');
			$this->result = $this->db->get('tehsil')->result_array();
			foreach($this->result as $key => $val){
				$this->options[$val['tcode']] = $val['tehsil'];
			}
		}
		$this->otherAttributes = 'id="tcode" class="form-control"';
		$this->filterRowCreation("Tehsil", "tcode", $this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create Union Council Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function ucFilter()
	{
		$this->options[0] = "";
		if($this->ulevel=='2'){
		}else{
			$this->options[0] = "--Select Union Council--";
			$this->db->select('uncode,unname(uncode) as unname');
			if($this->ulevel=='3')
				$this->db->where('distcode',$this->ci->session->District);
			$this->db->order_by('unname asc');
			$this->result = $this->db->get('unioncouncil')->result_array();
			foreach($this->result as $key => $val){
				$this->options[$val['uncode']] = $val['unname'];
			}
		}
		$this->otherAttributes = 'id="uncode" class="form-control"';
		$this->filterRowCreation("Union Council", "uncode", $this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create Health Facility Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function hfFilter()
	{
		$this->options[0] = "";
		if($this->ulevel=='2'){
		}else{
			$this->options[0] = "--Select Facility--";
			$this->db->select('facode,facilityname(facode) as facility');
			if($this->ulevel=='3')
				$this->db->where(array('distcode' => $this->ci->session->District, 'hf_type' => 'e' , 'is_ds_fac'=>'1'));
			$this->db->order_by('facility asc');
			$this->result = $this->db->get('facilities')->result_array();
			foreach($this->result as $key => $val){
				$this->options[$val['facode']] = $val['facility'];
			}
		}
		$this->otherAttributes = 'id="facode" class="form-control"';
		$this->filterRowCreation("Facility", "facode", $this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create a dropdowns for yearly, monthly, weekly and dates inputs in Filters for Reports
	 *
	 * @param	array 	$reportPeriod //array should contain monthly,yearly,weekly,dates filters names to create one of thoes
	 * @access	public
	 * @updated by moon (2018-02-07), Added date-from-to-current
	 * @return	void
	 */	
	function reportPeriod($reportPeriod){
		
		if(in_array("yearly",$reportPeriod)){
			//$this->options[0] = "--Select Year--";
			$years = $this->getYearsOptions();
			$this->otherAttributes = 'id="year" class="form-control"';
			$this->filterRowCreation("Year", "year", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("cryearly",$reportPeriod)){
			//$this->options[0] = "--Select Year--";
			$years = $this->getCRYearsOptions();
			$this->otherAttributes = 'id="year" class="form-control"';
			$this->filterRowCreation("Year", "year", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("yearlyAefi",$reportPeriod)){
			//$this->options[0] = "--Select Year--";
			$years = $this->getCRYearsOptions();//getYearsOptionsAefi();
			$this->otherAttributes = 'id="year" class="form-control"';
			$this->filterRowCreation("Year", "year", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("quarterly",$reportPeriod)){
			$this->options[0] = "--Select Quarter--";
			$months = $this->getQuarterOptions();
			$this->otherAttributes = 'id="quarter" class="form-control"';
			$this->filterRowCreation("Quarter", "quarter", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("monthly",$reportPeriod)){
			if(in_array("yearly",$reportPeriod))
				$this->options[0] = "--Select Month--";
			$months = $this->getMonthsOptions();
			$this->otherAttributes = 'id="month" class="form-control"';
			$this->filterRowCreation("Month", "month", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("monthly_last",$reportPeriod)){
			if(in_array("yearly",$reportPeriod))
				$this->options[0] = "--Select Month--";
			$months = $this->getMonthsOptionstillLast();
			$this->otherAttributes = 'id="month" class="form-control"';
			$this->filterRowCreation("Month", "month", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("monthly_current",$reportPeriod)){
			if(in_array("yearly",$reportPeriod))
				$this->options[0] = "--Select Month--";
			$months = $this->getMonthsOptionstillCurrent();
			$this->otherAttributes = 'id="month" class="form-control"';
			$this->filterRowCreation("Month", "month", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("weekly",$reportPeriod)){
			$this->options[0] = "--Select Week--";
			$weeks = $this->getWeeksOptions();
			$this->otherAttributes = 'id="week" class="form-control"';
			$this->filterRowCreation("Week", "week", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("dates",$reportPeriod)){
			$this->options = array('name' => 'datefrom', 'id' => 'datefrom', 'class' => 'form-control dp', 'required' => 'required');
			$this->filterRowCreation("Date From", "datefrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'dateto', 'id' => 'dateto', 'class' => 'form-control dp', 'required' => 'required');
			$this->filterRowCreation("Date To", "dateto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("date-from-to-date",$reportPeriod)){
			
			$this->options = array('name' => 'monthfrom', 'id' => 'monthfrom', 'class' => 'form-control mydate', 'required' => 'required','data-date-end-date' => "-1d");//+0m
			$this->filterRowCreation("Period From", "monthfrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'monthto', 'id' => 'monthto', 'class' => 'form-control mydate', 'required' => 'required','data-date-end-date' => "-1d");//+0m
			$this->filterRowCreation("Period To", "monthto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("date-from-to-current",$reportPeriod)){
			
			$this->options = array('name' => 'datefrom', 'id' => 'monthfrom', 'class' => 'form-control dpcurr', 'required' => 'required','data-date-end-date' => "+0d",'data-date-format' => "yyyy-mm-dd");
			$this->filterRowCreation("Date From", "datefrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'dateto', 'id' => 'monthto', 'class' => 'form-control dpcurr', 'required' => 'required','data-date-end-date' => "+0d",'data-date-format' => "yyyy-mm-dd");
			$this->filterRowCreation("Date To", "dateto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("date-from-date-to",$reportPeriod)){
			
			$this->options = array('name' => 'datefrom', 'id' => 'datefrom', 'class' => 'form-control ', 'readonly' => 'readonly');
			$this->filterRowCreation("Date From", "datefrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'dateto', 'id' => 'dateto', 'class' => 'form-control ', 'readonly' => 'readonly',);
			$this->filterRowCreation("Date To", "dateto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("specific_date",$reportPeriod)){
			$this->options = array('name' => 'datefrom', 'id' => 'datefrom', 'class' => 'form-control dp', 'required' => 'required');
			$this->filterRowCreation("Date", "datefrom", $this->otherAttributes, $this->options, "input");
			//$this->options = array('name' => 'dateto', 'id' => 'dateto', 'class' => 'form-control dp', 'required' => 'required');
			//$this->filterRowCreation("Date To", "dateto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("specific_month",$reportPeriod)){
			$this->options = array('name' => 'monthfrom', 'id' => 'monthfrom', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "-1m");//+0m
			$this->filterRowCreation("Month", "monthfrom", $this->otherAttributes, $this->options, "input");
			//$this->options = array('name' => 'monthto', 'id' => 'monthto', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "-1m");//+0m
			//$this->filterRowCreation("Period To", "monthto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("month-from-to",$reportPeriod)){
			$this->options = array('name' => 'monthfrom', 'id' => 'monthfrom', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "+0m");//-1m
			$this->filterRowCreation("Period From", "monthfrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'monthto', 'id' => 'monthto', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "+0m");//-1m
			$this->filterRowCreation("Period To", "monthto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("month-from-to-current",$reportPeriod)){
			
			$this->options = array('name' => 'monthfrom', 'id' => 'monthfrom', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "+0m");//+0m
			$this->filterRowCreation("Period From", "monthfrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'monthto', 'id' => 'monthto', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "+0m");//+0m
			$this->filterRowCreation("Period To", "monthto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("month-from-to-previous",$reportPeriod)){
			
			$this->options = array('name' => 'monthfrom', 'id' => 'monthfrom', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "-1m");//+0m
			$this->filterRowCreation("Period From", "monthfrom", $this->otherAttributes, $this->options, "input");
			$this->options = array('name' => 'monthto', 'id' => 'monthto', 'class' => 'form-control dp-my', 'required' => 'required','data-date-end-date' => "-1m");//+0m
			$this->filterRowCreation("Period To", "monthto", $this->otherAttributes, $this->options, "input");
		}
		if(in_array("year",$reportPeriod)){
			//$this->options[0] = "--Select Year--";
			$years = $this->getCRYearsOptions();//getidsrsYearsOptions();
			$this->otherAttributes = 'id="year" class="form-control"';
			$this->filterRowCreation("Year", "year", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("from_week",$reportPeriod)){
			$this->options[0] = "--Select Week--";
			$weeks = $this->getWeeksOptions();
			$this->otherAttributes = 'id="from_week" class="form-control"';
			$this->filterRowCreation("From Week", "from_week", $this->otherAttributes, $this->options, "dropdown");
		}
		if(in_array("to_week",$reportPeriod)){
			$this->options[0] = "--Select Week--";
			$this->otherAttributes = 'id="to_week" class="form-control"';
			$this->filterRowCreation("To Week", "to_week", $this->otherAttributes, $this->options, "dropdown");
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create Report Type Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function reportType()
	{
		$this->options[0] = "--Select--";
		$this->options["flcf"] = "Facility Wise";
		$this->options["uc"] = "Union Council Wise";
		$this->otherAttributes = 'id="reportType" class="form-control"';
		$this->filterRowCreation("Report Type", "reportType", $this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create indicators Filter for indicator Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function indicators($where=NULL)
	{
		//$this->options[0] = "--Select--";
		$this->db->select('*');
		if($where=='HFMVRF')
			$this->result = $this->db->order_by('indmain', 'ASC')->get_where('indicator_main',array('module_id' => '1'))->result_array();
		if($where=='Vaccine')
			$this->result = $this->db->order_by('indmain', 'ASC')->get_where('indicator_main',array('module_id' => '2','status' => '1'))->result_array();
			//$this->result = $this->db->order_by('indid', 'ASC')->get_where('indcat',array('rel_report' => '2'))->result_array();
		if($where=='Disease')
			$this->result = $this->db->order_by('indid', 'ASC')->get_where('indcat',array('rel_report' => '3'))->result_array();		
		foreach($this->result as $key => $val){
			if(isset($val['indid'])){
				$this->options[$val['indid']] = $val['ind_name'];
			}else{
				$this->options[$val['indmain']] = $val['ind_name'];
			}
		}
		$this->otherAttributes = 'id="indicator" class="form-control"';
		$this->filterRowCreation("Indicator", "indicator", $this->otherAttributes, $this->options, "dropdown");
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create Summary Filter for Summary Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function summaryReport()
	{
		$this->options["supervisor"] = "Supervisor";
		$this->options["dso"] = "District Surveillance Officer";
		$this->options["co"] = "Computer Operator";
		$this->options["med_technician"] = "HF Incharge";
		$this->options["technician"] = "EPI Technician";
		$this->options["driver"] = "Driver";
		$this->options["deo"] = "DataEntry Operator";
		$this->options["sk"] = "Store Keeper";
		$this->otherAttributes = 'id="employee_desg" class="form-control"';
		$this->filterRowCreation("Employee", "employee_desg", $this->otherAttributes, $this->options, "dropdown");
	}

	function retiredHRreport()
	{
		$this->options["supervisor"] = "Supervisor";
		$this->options["dso"] = "District Surveillance Officer";
		$this->options["co"] = "Computer Operator";
		$this->options["med_technician"] = "HF Incharge";
		$this->options["technician"] = "EPI Technician";
		$this->options["driver"] = "Driver";
		$this->options["deo"] = "Data Entry Operator";
		$this->options["sk"] = "Store Keeper";
		$this->otherAttributes = 'id="hr_type" class="form-control"';
		$this->filterRowCreation("HR Type", "hr_type", $this->otherAttributes, $this->options, "dropdown");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create facility/union council/tehsil/district wise filter different Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function typeWiseReport()
	{
		$this->options["district"] = "District wise";
		$this->options["tehsil"] = "Tehsil wise";
		$this->options["uc"] = "Union Council wise";
		$this->options["fac"] = "Facility wise";
		
		$this->otherAttributes = 'id="reportPeriodnew" class="form-control"';
		$this->filterRowCreation("Report Type", "reportPeriodnew", $this->otherAttributes, $this->options, "dropdown");		
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create a row for different Filters for Reports
	 *
	 * @param	string 		$title
	 * @param	string 		$for
	 * @param	string 		$attr
	 * @param	array 		$opt
	 * @param	string 		$type
	 * @access	public
	 * @return	void
	 */		
	function filterRowCreation($title=NULL, $for=NULL, $attr=NULL, $opt=NULL, $type=NULL, $classes=NULL,$modId=Null){
		$this->outputHtml .=	'<div class="row '.$classes.'">
									<div class="form-group">';
		$attributes = array(
			'class' => 'col-xs-3 control-label',
			'id' => $for."-label"
		);
		$this->outputHtml .= form_label($title, $for, $attributes);
		if($title=="From Week" || $title=="To Week" ){
		$this->outputHtml .= '<div class="col-xs-4">';		
		}else{
			$this->outputHtml .= '<div class="col-xs-7">';	
		}
		if($type == "dropdown"){
			$this->outputHtml .= form_dropdown($for, $opt, '', $attr);
		}
		if($type == "input"){
			$this->outputHtml .= form_input($opt);
		}
		if($type == "radio"){
			//edite by raja imran 2018-09-18
			if(isset($opt["groupoptions"])){
				foreach($opt["groupoptions"] as $key=>$oneopt){
					$labell = ($oneopt['label'])?$oneopt['label']:'';
					unset($oneopt['label']);
					$this->outputHtml .= form_radio($oneopt);
					$this->outputHtml .= ' '.form_label($labell).' ';
				}
			}else{
				$this->outputHtml .= form_radio($opt);
			}
		}
		if($type == "checkbox"){
			//form_checkbox
		}
		$this->outputHtml .='  					
						
					</div>';
		if($title=="Report"){
			$this->outputHtml .='<div class="col-xs-1"><button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#popup"><span><i class="fa fa-pencil text-primary"></i></span> 
		 <span> <i class="fa fa-trash-o text-danger"></i></span></button></div>';	
		}
		if($title=="From Week"){
			
			$this->outputHtml .='<div class="col-xs-3">
										<input type="text" name="datefrom" id="datefrom" class="form-control" readonly="readonly">
									</div>';	
		}
		if($title=="To Week"){
			
			$this->outputHtml .='<div class="col-xs-3">
										<input type="text" name="toweek" id="toweek" class="form-control" readonly="readonly">
									</div>';	
		}
		 
        $this->outputHtml .='</div></div>';
	
		$this->options=NULL;
		$this->otherAttributes=NULL;
		$this->result=NULL;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create Advance Report Filter for Advance Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function advanceReport($modId)
	{
		//$this->options[0] = "--Select--";
		$this->db->select('*');
		$this->db->where('module_id',$modId);
		$this->db->where('username',$this->ci->session->username);
		$result = $this->db->get('adv_reports')->result_array();
		//print_r($result);exit;
		//echo "here";print_r($this->db->get('adv_reports')->result_array());
		foreach($result as $key => $val){
			//echo $val;
			
			$this->options[$val['report_id']] = $val['report_title'];
		}
		//echo "d";exit;
		$this->otherAttributes = 'id="report_id" class="form-control"';
		$this->filterRowCreation("Report", "report_id", $this->otherAttributes, $this->options, "dropdown");
		
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create Filters Top info and sets its title and path for Reports
	 *
	 * @param	string 		$path
	 * @param	string 		$title
	 * @access	public
	 * @return	void
	 */	
	function filtersHeader($path,$title){
		return '<div class="row">
					<div class="col-xs-6 col-xs-offset-3">
						<div class="panel panel-primary">
							<div class="panel-heading text-center">'.$title.'</div>
								<div class="panel-body">
									<form method="post" name="theForm" target="_blank" id="filter-form" class="form-horizontal form-bordered" action="'.$path.'">';
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create Filters Footer info and add a submit button
	 *
	 * @param	string 		$advanceReport
	 * @access	public
	 * @return	void
	 */	
	function filtersFooter($advanceReport="No"){
						$toReturn = '<hr>
								<div class="row">
									<div class="col-xs-3" style="margin-left: 71%;">
										<button type="submit" name="submit1" id="pre-btn" class="task task__content btn btn-md btn-success"><i class="fa fa-search"></i> Preview </button>';
										
										if($advanceReport == "Yes"){
											$toReturn = '<hr>
														<div class="row">
															<div class="col-xs-6" style="margin-left: 52%;">
																<button type="submit" name="submit1" id="pre-btn" class="task task__content btn btn-md btn-success"><i class="fa fa-search"></i> Preview </button>
																<button type="button" id="new-btn" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New Report</button>
																	';
										}
											$toReturn .='
														<div class="col-xs-6" style="margin-left: 73%;">
															<nav id="context-menu" class="context-menu">
															  <ul class="context-menu__items">
																<li class="context-menu__item">
																  <button type="submit" name="submit2" class="context-menu__link" data-action="View" value="1">Open in New Tab</button>
																  <button type="submit" name="submit3" class="context-menu__link" data-action="Edit" value="2">Open in Same Tab</button>
																</li>
															  </ul>
															</nav>
														  </div>
														';
										
									$toReturn .= '</div>
								</div><br>
							</form>
					</div>
				</div>
			</div>
		</div>';
		return $toReturn;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Create Custom Dropdowns Filter for Reports
	 *
	 * @access	public
	 * @return	void
	 */		
	function customDropdown($customDropdown)
	{  
		foreach($customDropdown as $dropdown){
			$nameforDropDown = $dropdown[0];
			$classforHidding = (isset($dropdown['class']))?$dropdown['class']:'';
			$id = str_replace(' ', '', $nameforDropDown);
			unset($dropdown[0]);unset($dropdown['class']);
			foreach($dropdown as $key => $val){
				$this->options[$key] = $val;
			}
			$this->otherAttributes = 'id="'.strtolower($id).'" class="form-control"';
			$this->filterRowCreation($nameforDropDown, str_replace(" ","_",strtolower($nameforDropDown)),$this->otherAttributes, $this->options, "dropdown",$classforHidding);
		}
	}
	
	// --------------------------------------------------------------------
	

	/**
	 * Create Years Option for year Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getYearsOptions(){
		$this->db->distinct();
		$this->db->select('year');
		$this->db->from('epi_weeks');
		$this->db->where('year <=',date('Y',strtotime("-1 month")));//date('Y')
		$this->db->order_by('year desc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['year']] = $val['year'];
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create Years Option for Current year Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getCRYearsOptions(){
		$this->db->distinct();
		$this->db->select('year');
		$this->db->from('epi_weeks');
		//$this->db->where('year <=',date('Y'));//date('Y')
		//$epimonth = date('m');
		$WeekNumber = date('W');
		//echo 'Week number:' . $currentWeekNumber;
		if($WeekNumber > 01){
			$this->db->where('year <=',date('Y'));//date('Y')
		}
		else{
			$this->db->where('year <',date('Y'));//date('Y')
		}
		$this->db->order_by('year asc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['year']] = $val['year'];
		}
	}
	
	// --------------------------------------------------------------------
	// --------------------------------------------------------------------
	/**
	 * Create YearsAEFI Option for year Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getYearsOptionsAefi(){
		$this->db->distinct();
		$this->db->select('year');
		$this->db->from('epi_weeks');
		/* $year= date('Y'); */
		$year= date('Y',strtotime("-1 month"));
		$this->db->where('year <=', $year);
		$this->db->order_by('year asc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['year']] = $val['year'];
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create months Option for months Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getQuarterOptions(){		
		$quarters = array(1 => 'First', 2 => 'Second', 3 => 'Third', 4 => 'Fourth');
		foreach ($quarters as $num => $quarteritem) {
			$quarter = sprintf("%02d", $num);
			$this->options[$quarter] = $quarteritem;
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create months Option for months Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getMonthsOptions(){		
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		foreach ($months as $num => $monthitem) {
			$month = sprintf("%02d", $num);
			$this->options[$month] = $monthitem;
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create months Option for months Filter, If year is current or advance year then previous month will be last month
	 *
	 * @access	public
	 * @return	void
	 */	
	function getMonthsOptionstillLast(){		
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		//$currmnth = date('m');
		$currmnth = date('m',strtotime("-1 month"));
		foreach ($months as $num => $monthitem) {
			/* if($num > ($currmnth-1)) */
			if($num > $currmnth)
			{}else{
				$month = sprintf("%02d", $num);
				$this->options[$month] = $monthitem;
			}
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create months Option for months Filter, If year is current or advance year then current month will be last month
	 *
	 * @access	public
	 * @return	void
	 */	
	function getMonthsOptionstillCurrent(){		
		$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
		$currmnth = date('m');
		foreach ($months as $num => $monthitem) {
			if($num > ($currmnth))
			{}else{
				$month = sprintf("%02d", $num);
				$this->options[$month] = $monthitem;
			}
		}
	}
	
	// --------------------------------------------------------------------
	/**
	 * Create Weeks Option for week Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getWeeksOptions(){		
		$this->db->select('epi_week_numb');
		$this->db->from('epi_weeks');
		$this->db->order_by('epi_week_numb asc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['epi_week_numb']] = "Week ".sprintf("%02d",$val['epi_week_numb']);
		}
	}
	
		// --------------------------------------------------------------------
	/**
	 * Create Years Option for year Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getidsrsYearsOptions(){
		/* $year= date('Y'); */
		$year= date('Y',strtotime("-1 month"));
		$this->db->distinct();
		$this->db->select('year');
		$this->db->from('epi_weeks');
		$this->db->where('year <=',$year);
		$this->db->order_by('year asc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['year']] = $val['year'];
		}
	}
	
	// --------------------------------------------------------------------
	// --------------------------------------------------------------------
	/**
	 * Create Weeks Option for week Filter
	 *
	 * @access	public
	 * @return	void
	 */	
	function getIdsrsWeeksOptions(){		
		$this->db->select('epi_week_numb');
		$this->db->from('epi_weeks');
		$this->db->order_by('epi_week_numb asc');
		$this->result = $this->db->get()->result_array();
		foreach($this->result as $key => $val){
			$this->options[$val['epi_week_numb']] = "Week ".sprintf("%02d",$val['epi_week_numb']);
		}
	}
	// --------------------------------------------------------------------
}
// END Reportfilters Class

/* End of file Reportfilters.php */
/* Location: ./application/libraries/Reportfilters.php */
