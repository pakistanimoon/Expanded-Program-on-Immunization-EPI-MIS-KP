<?php
class Reports extends CI_Controller {
	//================ Constructor Function Starts ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_functions_helper'); 
		$this -> load -> helper('epi_reports_helper');
		authentication();
        $this -> load -> model('cold_chain/Reports_model','coldchain');		
	}
	public function reportFilters(){
		$this -> load -> library('reportfilters');
		$reportPath = base_url()."Reports/AssetAvailability";
		//$reportTitle = $this->reportTitle($functionName);
		$reportTitle = "Asset(s) Availability Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$assettype = array(0=>'Asset Type',''=>'--Select Type--','1'=>'Refrigerator','21'=>'Cold Room','23'=>'Voltage Regulator','24'=>'Generator','25'=>'Transport','26'=>'Vaccine Carriers','33'=>'Cold Box');
		if($this -> session -> UserLevel == '4'){
		$stroelevel = array(0=>'Store Level',''=>'--Select Level--','5'=>'Tehsil','6'=>'Union Council'); 
		}else if($this -> session -> UserLevel == '3'){
			$stroelevel = array(0=>'Store Level',''=>'--Select Level--','4'=>'District','5'=>'Tehsil','6'=>'Union Council','unallocated'=>'Unallocated'); 
		}else{
			$stroelevel = array(0=>'Store Level',''=>'--Select Level--','2'=>'Provincial Store','4'=>'District','5'=>'Tehsil','6'=>'Union Council','unallocated'=>'Unallocated'); 
		}
		$status = array(0=>'Working Status',''=>'--Select Status--','1'=>'Working well','2'=>'Working but needs maintenance','3'=>'Not working','4'=>'Working well & fuel available','5'=>'Working well but fuel not available');
		$reportPeriod=array("specific_year"=>array("title"=>"Year Of Supply"));
		if($this -> session -> UserLevel == '4'){
		$dataHtml .= $this->reportfilters->createReportFilters(false,true,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,array($assettype,$stroelevel,$status));
		}else{
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,$reportPeriod,false,NULL,NULL,'No','No',NULL,array($assettype,$stroelevel,$status));	
		}
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml; 
		$data['data']=$data;
		$data['fileToLoad'] = 'coldchain/reports/reports_filters';
		$data['pageTitle']='EPI-MIS Asset Availability Report Filters';
		$this -> load -> view('template/epi_template',$data);
    }
	public function asset_availability(){
		$data = $this -> getPostedData();
		//print_r($data); exit;
        $dataPVR['data'] = $this -> coldchain -> asset_availability($data);
		//print_r($dataPVR['data']); exit;
		$dataPVR['fileToLoad'] 	= 'coldchain/reports/asset_availability_report_view';
		$dataPVR['pageTitle']	='EPI-MIS | Asset Availability Report';
		$this->load->view('template/reports_template',$dataPVR);		
		
	}
	public function assetreportFilters(){
		$this -> load -> library('reportfilters');
		$reportPath = base_url()."Reports/AssetAvailabilityReport";
		//$reportTitle = $this->reportTitle($functionName);
		$reportTitle = "Asset(s) Availability Report";
		$dataHtml = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$assettype = array(0=>'Asset Type',''=>'--Select Type--','1'=>'Refrigerator','21'=>'Cold Room','23'=>'Voltage Regulator','24'=>'Generator','25'=>'Transport','26'=>'Vaccine Carriers','33'=>'Cold Box');
	    if($this -> session -> UserLevel == '3'){
			//$stroelevel = array(0=>'Store Level',''=>'--Select Level--','4'=>'District','5'=>'Tehsil','6'=>'Union Council','unallocated'=>'Unallocated'); 
			$stroelevel = array(0=>'Store Level','4'=>'District','5'=>'Tehsil','unallocated'=>'Unallocated'); 
		}else{
			$stroelevel = array(0=>'Store Level','2'=>'Provincial Store','5'=>'Tehsil','6'=>'Union Council','unallocated'=>'Unallocated'); 
		}
		$status = array(0=>'Working Status',''=>'--Select Status--','1'=>'Working well','2'=>'Working but needs maintenance','3'=>'Not working','4'=>'Working well & fuel available','5'=>'Working well but fuel not available');
		//$reportPeriod=array("specific_year"=>array("title"=>"Year Of Supply"));
		$dataHtml .= $this->reportfilters->createReportFilters(true,false,false,false,false,false,NULL,NULL,'No','No',NULL,array($assettype,$stroelevel,$status));	
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['fileToLoad'] = 'coldchain/reports/reports_filters';
		$data['pageTitle']='EPI-MIS Asset Availability Report Filters';
		$this -> load -> view('template/epi_template',$data);
    }
	public function asset_availability_report(){
		$data = $this -> getPostedData();
		//print_r($data); exit; 
		$dataPVR['data'] = $this -> coldchain -> asset_availability_report($data);
		//print_r($dataPVR['data']); exit;
		$dataPVR['fileToLoad'] 	= 'coldchain/reports/asset_report_view';
		$dataPVR['pageTitle']	='EPI-MIS | Asset Availability Report';
		$this->load->view('template/reports_template',$dataPVR);
	}
	public function asset_availability_report_view(){
		$data['code'] =  $this -> uri -> segment(4);
		$data['store_level'] =  $this -> uri -> segment(5);
		$data['asset_type'] =  $this -> uri -> segment(6);
		$data['working_status'] =  $this -> uri -> segment(7);
		//print_r($data); exit();
		$dataPVR['data'] = $this -> coldchain -> asset_availability_report_view($data);
		//print_r($dataPVR['data']); exit;
		$dataPVR['fileToLoad'] 	= 'coldchain/reports/assets_view';
		$dataPVR['pageTitle']	='EPI-MIS | Asset Availability Report';
		$this->load->view('template/reports_template',$dataPVR);
	}
	public function allassets_Views()
	{
		$CI = & get_instance();	//print_r($CI);exit;
		$rcode['ccm.asset_id'] =$assetid=$this -> uri -> segment(3);
		$data = $this -> coldchain -> allassets_Views($rcode);
		$data['storename']= "Unallocated";
		if($data['warehouse_type_id']!=0)
		{
			$data['storename'] = get_store_name(TRUE,$data['warehouse_type_id'],$data[get_warehouse_code_column($data['warehouse_type_id'])]);
		}
		if ($data != 0) {
			$data['assetid']=$assetid;
			$data['data'] = $data;//print_r($LoadData);exit;
			$data['fileToLoad'] = 'coldchain/reports/allassets_Views';
			$data['pageTitle']='Asset View | EPI-MIS';
			$this->load->view('template/epi_template',$data);
		} else {
			$data['message'] = "You must have rights to access this page.";
			$this -> load -> view("message", $data);
		}
	}
	function getPostedData(){
		$data=array();$dataPosted=array();
		$dataPosted = $_POST;
		foreach($dataPosted as $key => $value)
		{
			$data[$key] = (($value=='')?NULL:$value);
			if($data[$key] == NULL || $data[$key]=="0")
				unset($data[$key]);
		}
		return $data;
	}

}
?>	