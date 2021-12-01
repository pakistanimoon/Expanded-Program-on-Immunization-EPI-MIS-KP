<?php
class Indicator_reports_new_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function HFMVRF($data){
		$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		$indicator = $this -> input -> post('indicator')?$this -> input -> post('indicator'):$data['indicator'];
		$returned_data = $data;
		
		$whereCondition = "";
		if(isset($data['distcode']) && $data['distcode'] > 0){
			$whereCondition.="distcode='".$data['distcode']."' and";
		}
		if(isset($data['tcode']) && $data['tcode'] > 0)
		{
			$whereCondition.=" tcode='".$data['tcode']."' and";
		}
		if(isset($data['uncode']) && $data['uncode'] > 0)
		{
			$whereCondition.=" uncode='".$data['uncode']."' and";
		}
		if(isset($data['facode']) && $data['facode'] > 0)
		{
			$whereCondition.=" facode='".$data['facode']."' and";
		}
		$indicator = $this -> input -> post('indicator')?$this -> input -> post('indicator'):$data['indicator'];
		if($indicator == '63')
			$indicator = '63';
		$query="select indm.* from indicator_main indm where indm.indmain=$indicator";
		//echo $query;exit;
		$arrayData=$this->db->query($query)->row_array();
		//print_r($arrayData);exit;
		$querycolumn="select indc.* from indicator_column indc where indc.indmain=$indicator order by indc.indcol";
		$arrayDataC=$this->db->query($querycolumn)->result_array();
		$table = "fac_mvrf_db";
		$indicatorTitle = $arrayData['result_text'];
		$fullquery=explode('-::-',extract_query($arrayData,$whereFmonth,$data,$whereCondition,$arrayDataC,$table));
		$query=$fullquery[0];
		//print_r($query);exit;
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		$all_data_total = array(0 => array());
		$total_temp = array();
		//echo "<pre>";print_r($data['allData']);exit;
		if($indicator == '63')
		{
			$totalquery=$fullquery[1];
			$all_data_total = $this->db->query($totalquery)->result_array();
			foreach ($data['allData'] as $index => $array) 
			{
				foreach ($array as $key => $value) 
				{
					if(substr($key, 0, -3) == 'Total Vaccination' OR substr($key, 0, -3) == 'target')
					{
						unset($data['allData'][$index][$key]);
					}
				}
			}
		}
		if(strpos($query,'100')!=false)
		{
			//$query=$fullquery[1];
			/* $result=$this->db->query($query);
			$data['allDataTotal']=$result->result_array();
			$indicatorReport="abc"; */
		}
		else
		{
			$data['allDataTotal']=array();
			//$indicatorReport="xyz";
		}
		/* if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$indicatorTitle).(isset($data['monthfrom']))?$data['monthfrom']:''."_to_".(isset($data['monthto']))?$data['monthto']:''.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		} */

		$endresult=$data['allData'];//array_merge($data['allData'],$data['allDataTotal']);
				//print_r($endresult);exit;
		$subTitle = "Indicator Report";
		$data['mini_title'] = $arrayData['ind_name'];
		//print_r($all_data_total);exit;
		if($indicator == '63')
		{
			$dataReturned['htmlData'] = getListingReportTable($endresult,'',$all_data_total,'','YES');
		}
		else
		{
			$dataReturned['htmlData'] = getListingReportTable($endresult,'','','');
		}
		//print_r($dataReturned['htmlData']);exit;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['monthfrom'] = (isset($data['monthfrom']))?$data['monthfrom']:date('Y-m');
		$dataReturned['monthto'] = (isset($data['monthto']))?$data['monthto']:date('Y-m');
		$dataReturned['indicatorTitle'] = $indicatorTitle;
$dataReturned['data'] = $returned_data;
		return $dataReturned;
	}
	//--------------------------------------------------------------------------------//	
}