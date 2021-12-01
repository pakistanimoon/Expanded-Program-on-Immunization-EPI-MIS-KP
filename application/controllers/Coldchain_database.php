<?php
class Coldchain_database extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	
	public function filters(){
		$this -> load -> library('reportfilters');
		$functionName = "ColdChainDatabase";
		$reportPath = base_url()."Coldchain_database/".$functionName;
		$reportTitle = "Cold Chain Assert Database Listing";
		$dataHtml  = $this->reportfilters->filtersHeader($reportPath,$reportTitle);
		$dataHtml .= $this->reportfilters->createReportFilters(true);
		$dataHtml .= $this->reportfilters->filtersFooter();
		$data['listing_filters'] = $dataHtml;
		$data['data']=$data;
		$data['fileToLoad'] = 'reports/reports_filters';
		$data['pageTitle']='EPI-MIS Cold Chain Database Listing Filters';
		$this -> load -> view('template/epi_template',$data);
	}
	public function ColdChainDatabase(){
		$data = $this -> getPostedData();
		$dataCCMDB['pageTitle'] = 'Cold Chain Database Listing';
		$query = "
			SELECT 
				ccald_c1 as \"District Code\",ccald_c2 as \"District\",ccald_c3 as \"Tehsil\",ccald_c4 as \"UC\",
				ccald_c5 as \"Facility\",ccald_c6 as \"Facility Type\",ccald_c7 as \"# of ILRs\",
				ccald_c8 as \"# Of Cold Box\",
				ccald_c9 as \"# of SVC\",
				ccald_c10 as \"# RVC\",
				ccald_c11 as \"# Ice Paks\",
				ccald_c12 as \"Type\",
				ccald_c13 as \"Library ID\",
				ccald_c14 as \"Model\",
				ccald_c15 as \"Manuracturer\",
				ccald_c16 as \"Serial Number\",
				ccald_c17 as \"Power Source\",
				ccald_c18 as \"Temperature Recording System\",
				ccald_c19 as \"Date of Supply(M.Y)\",
				ccald_c20 as \"Year of planned replacement\",
				ccald_c21 as \"Date of last assessment\",
				ccald_c22 as \"Working well\",
				ccald_c23 as \"Not Working\",
				ccald_c24 as \"Need Repair\",
				ccald_c25 as \"Functional\",
				ccald_c26 as \"Not Functional\",
				ccald_c27 as \"Reason an equipment is not in use\",
				ccald_c28 as \"Maintenance (include nessessity of generator / stabilizer)\",
				ccald_c29 as \"Estimated Cost\",
				ccald_c30 as \"Source of the Fund\",
				ccald_c31 as \"Priority\",
				ccald_c32 as \"Standby Generator\",
				ccald_c33 as \"Standby Regulator\",
				ccald_c34 as \"Standby Stabilizer\",
				ccald_c35 as \"0 hrs\",
				ccald_c36 as \"<8 hrs\",
				ccald_c37 as \"8-16 hrs\",
				ccald_c38 as \">16 hrs\"
			FROM
				ccald_db
		";
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Cold_Chain_Database_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if(isset($data['distcode']) && strlen($data['distcode']) == 3)
			$query .= "WHERE ccald_c1 = '{$data['distcode']}'";
		else
			$query .= " order by districtname(ccald_c1) ASC";
		$result = $this -> db -> query($query);
		$data['allData'] = $result -> result_array();
		$result1 = showListingReport($data['allData']);
		$viewData["tableData"]=$result1;
		$viewData['pageTitle'] = $title ='Cold Chain Assert Database Listing';
		$viewData['TopInfo'] = reportsTopInfo($title, $data);
		$viewData['exportIcons']=exportIcons($_REQUEST);
		$dataCCMDB['data'] = $viewData;
		$dataCCMDB['pageTitle']='Cold Chain Assert Database Listing';
		$dataCCMDB['fileToLoad'] = 'ccmdb_listing';
		$this -> load -> view('template/reports_template',$dataCCMDB);
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