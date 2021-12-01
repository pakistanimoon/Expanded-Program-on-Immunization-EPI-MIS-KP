<?php
class Coverage extends CI_Controller {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Reports_model');
		
		
		$this -> load -> model('Indicator_reports_model');
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
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function index(){
		$this -> load -> library('reportfilters');
		$reportPeriod = array('month-from-to-previous');
		$reportPath = base_url()."Commulative-Coverage/preview";
		$reportTitle = 'Commulative Vaccination Coverage Report';
		//$reporttypearr = array("0"=>"Vaccinated by","1"=>"Aggregated Counts",/*"2"=>"Facilities List" */,"class"=>NULL);
		//$reporttypeind = array("0"=>"Report Indicator","1"=>"Stockout Facilities", "2"=>"HF Closing Balance","class"=>NULL);
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,"No","No",NULL,NULL,"No",false,NULL,true,true,true);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['fileToLoad'] = 'vaccination/reports/coverage/filters';
		$data['pageTitle']='Commulative Vaccination Coverage Report';
		$this -> load -> view('template/epi_template',$data);
	}
	function preview()
	{
		$wc = array();
		if($this->input->post("moon") && $this->input->post("moon")=="formposted")
		{
			if($this->input->post("procode")){
				$data["procode"] = $this->input->post("procode");
			}
			if($this->input->post("distcode")){
				$data["distcode"] = $this->input->post("distcode");
			}
			if($this->input->post("tcode")){
				$data["tcode"] = $this->input->post("tcode");
			}
			if($this->input->post("uncode")){
				$data["uncode"] = $this->input->post("uncode");
			}
			if($this->input->post("facode")){
				$data["facode"] = $this->input->post("facode");
			}
			if($this->input->post("report_type")){
				$data["report_type"] = $this->input->post("report_type");
			}
		}
		else
		{
			$data 			= $this -> getPostedData();
			//$data["fmonth"] = (isset($data['fmonth']))?$data['fmonth']:((isset($data['year']) && isset($data['month']))?$data['year'].'-'.$data['month']:NULL);
			unset($data['export_excel']);
			unset($data['_ga']);
			unset($data['_gid']);
			unset($data['ci_session']);
			unset($data['_gat']);
		}
		if($this -> input -> post('export_excel'))
		{
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPI_HF_Current_Stock_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		}
		$title = "Commulative Vaccination Coverage Report";
		//$result = $this -> Indicator_reports_model -> getbatchwisehfclosing($data);
		$data["in_out_coverage"] = "in_uc";
		$data["typeWise"] = "uc";
		$result = $this -> Reports_model -> flcf_wise_vaccination_malefemale_coverage(NULL,NULL,$data);
		$dataToReturn['data'] = $data;
		$dataToReturn['data']['result'] = $result;
		$dataToReturn['data']['exportIcons'] = exportIcons($_REQUEST);
		$dataToReturn['data']['TopInfo'] = reportsslimTopInfo($title, $data);	
		$dataToReturn['data']['subtitle'] = $title;
		$dataToReturn['fileToLoad'] = 'vaccination/reports/stock/preview';
		$dataToReturn['pageTitle']='EPI-MIS | Commulative Vaccination Coverage';
		$this->load->view('template/reports_template',$dataToReturn);
	}
	//========Function to create Priority Diseases Under Surveillance Reports==========//
	function getPostedData(){
		$data=array();
		$distcode = ($this -> session -> District)?$this -> session -> District:(($this -> input -> post("distcode"))?$this -> input -> post("distcode"):0);	
		$dataPosted = $this->input->post();
		//$formats = array("d/m/Y","d-m-Y","Y-m-d","m-d-Y","d-M-y");
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			/* if(strpos("date",$key)!==FALSE){
				foreach ($formats as $format)
				{
					$date = DateTime::createFromFormat($format, $data[$key]);
					if ($date == false || !(date_format($date,$format) == $data[$key]) ){}else{
						$data[$key] = date("Y-m-d",strtotime($data[$key]));
					}
				}
			} */
			if($data[$key] == NULL || $data[$key]=="0"){
				unset($data[$key]);
			}
		}
		$data["distcode"] = $distcode;
		return $data;
	}
}
?>