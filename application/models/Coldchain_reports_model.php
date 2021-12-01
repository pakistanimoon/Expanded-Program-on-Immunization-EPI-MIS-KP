<?php
class Coldchain_reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function Refrigerator_Report($data){
		//echo "bhatti";exit;
		//$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		//$indicator = $this -> input -> post('indicator')?$this -> input -> post('indicator'):$data['indicator'];
		$quarter=$this->input->post('quarter');
		$year=$data['year'];
		$fquarter= $year."-".$quarter;
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
		//$query="select result.distcode,result.abc as \"Functioning\",result.xyz as \"Total\",round((CAST(result.abc as decimal)/result.xyz),2)*100 as \"Total Functioning ILRs (%)\" from (select distcode,count(working_status) as \"abc\",(select count(facode) from facilities where facilities.distcode=erq.distcode) as \"xyz\" from epi_refrigerator_questionnaire erq where working_status='1' and distcode is not null group by distcode) as \"result\"";
		$query="select districts.distcode,districtname(districts.distcode),COALESCE(result.abc,0) as \"Functioning\",COALESCE(result.xyz,0) as \"Total\",COALESCE(round((CAST(result.abc as decimal)/result.xyz),2)*100,0) as \"Total Functioning ILRs (%)\" from (select distcode,count(working_status) as \"abc\",(select count(id) from epi_refrigerator_questionnaire where epi_refrigerator_questionnaire.distcode=erq.distcode and fquarter='$fquarter') as \"xyz\" from epi_refrigerator_questionnaire erq where $whereCondition fquarter='$fquarter' and working_status='1' and distcode is not null group by distcode) as \"result\" full outer join districts on districts.distcode=result.distcode";
		//$query="select distcode,districtname(distcode),count(working_status) as \"Functioning ILR\"  from epi_refrigerator_questionnaire erq where working_status='1' and $whereCondition distcode is not NULL group by distcode";
		//echo $query;exit;
		$arrayData=$this->db->query($query)->result_array();
		//$functioning=$arrayData['Functioning ILR'];
		//echo $functioning;exit;
		//unset($arrayData["Facilities"]);
		
		//print_r($arrayData);exit;
		//$endresult=$data['allData'];//array_merge($data['allData'],$data['allDataTotal']);
		$subTitle = "Indicator Report";
		$dataReturned['htmlData'] = getListingReportTable($arrayData,'','','');
		//print_r($dataReturned['htmlData']);exit;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//$dataReturned['monthfrom'] = (isset($data['monthfrom']))?$data['monthfrom']:date('Y-m');
		//$dataReturned['monthto'] = (isset($data['monthto']))?$data['monthto']:date('Y-m');
		//$dataReturned['indicatorTitle'] = $indicatorTitle;
		//print_r($dataReturned);exit;
		return $dataReturned;
	}
	//--------------------------------------------------------------------------------//	
		function Coldroom_Report($data){
		//echo "bhatti";exit;
		//$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		//$indicator = $this -> input -> post('indicator')?$this -> input -> post('indicator'):$data['indicator'];
		$quarter=$this->input->post('quarter');
		$year=$data['year'];
		$fquarter= $year."-".$quarter;
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
		//$query="select result.distcode,result.abc as \"Functioning\",result.xyz as \"Total\",round((CAST(result.abc as decimal)/result.xyz),2)*100 as \"Total Functioning ILRs (%)\" from (select distcode,count(working_status) as \"abc\",(select count(facode) from facilities where facilities.distcode=erq.distcode) as \"xyz\" from epi_coldroom_questionnaire erq where working_status='1' and distcode is not null group by distcode) as \"result\"";
		$query="select districts.distcode,districtname(districts.distcode),COALESCE(result.abc,0) as \"Functioning\",COALESCE(result.xyz,0) as \"Total\",COALESCE(round((CAST(result.abc as decimal)/result.xyz),2)*100,0) as \"Total Functioning ILRs (%)\" from (select distcode,count(working_status) as \"abc\",(select count(id) from epi_coldroom_questionnaire where epi_coldroom_questionnaire.distcode=erq.distcode and fquarter='$fquarter') as \"xyz\" from epi_coldroom_questionnaire erq where $whereCondition  fquarter='$fquarter' and working_status='1' and distcode is not null group by distcode) as \"result\" full outer join districts on districts.distcode=result.distcode";
		//$query="select distcode,districtname(distcode),count(working_status) as \"Functioning ILR\"  from epi_refrigerator_questionnaire erq where working_status='1' and $whereCondition distcode is not NULL group by distcode";
		//echo $query;exit;
		$arrayData=$this->db->query($query)->result_array();
		//$functioning=$arrayData['Functioning ILR'];
		//echo $functioning;exit;
		//unset($arrayData["Facilities"]);
		
		//print_r($arrayData);exit;
		//$endresult=$data['allData'];//array_merge($data['allData'],$data['allDataTotal']);
		$subTitle = "Indicator Report";
		$dataReturned['htmlData'] = getListingReportTable($arrayData,'','','');
		//print_r($dataReturned['htmlData']);exit;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//$dataReturned['monthfrom'] = (isset($data['monthfrom']))?$data['monthfrom']:date('Y-m');
		//$dataReturned['monthto'] = (isset($data['monthto']))?$data['monthto']:date('Y-m');
		//$dataReturned['indicatorTitle'] = $indicatorTitle;
		//print_r($dataReturned);exit;
		return $dataReturned;
	}
	function Generator_Report($data){
		//echo "bhatti";exit;
		//$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		//$indicator = $this -> input -> post('indicator')?$this -> input -> post('indicator'):$data['indicator'];
		$quarter=$this->input->post('quarter');
		$year=$data['year'];
		$fquarter= $year."-".$quarter;
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
		//$query="select districts.distcode,COALESCE(round((CAST(result.abc as decimal)/result.xyz),2)*100,0) as "Ind" from (select distcode,count(working_status) as "abc",(select count(facode) from facilities where facilities.distcode=erq.distcode) as "xyz" from epi_refrigerator_questionnaire erq where working_status='1' and distcode is not null group by distcode) as "result" full outer join districts on districts.distcode=result.distcode"
		$query="select districts.distcode,districtname(districts.distcode),COALESCE(result.abc,0) as \"Functioning\",COALESCE(result.xyz,0) as \"Total\",COALESCE(round((CAST(result.abc as decimal)/result.xyz),2)*100,0) as \"Total Functioning ILRs (%)\" from (select distcode,count(working_status) as \"abc\",(select count(id) from epi_generator_questionnaire where epi_generator_questionnaire.distcode=erq.distcode and fquarter='$fquarter') as \"xyz\" from epi_generator_questionnaire erq where $whereCondition  fquarter='$fquarter' and working_status='1' and distcode is not null group by distcode) as \"result\" full outer join districts on districts.distcode=result.distcode";
		//$query="select distcode,districtname(distcode),count(working_status) as \"Functioning ILR\"  from epi_refrigerator_questionnaire erq where working_status='1' and $whereCondition distcode is not NULL group by distcode";
		//echo $query;exit;
		$arrayData=$this->db->query($query)->result_array();
		//$functioning=$arrayData['Functioning ILR'];
		//echo $functioning;exit;
		//unset($arrayData["Facilities"]);
		
		//print_r($arrayData);exit;
		//$endresult=$data['allData'];//array_merge($data['allData'],$data['allDataTotal']);
		$subTitle = "Indicator Report";
		$dataReturned['htmlData'] = getListingReportTable($arrayData,'','','');
		//print_r($dataReturned['htmlData']);exit;
		$dataReturned['subtitle'] = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($subTitle, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		//$dataReturned['monthfrom'] = (isset($data['monthfrom']))?$data['monthfrom']:date('Y-m');
		//$dataReturned['monthto'] = (isset($data['monthto']))?$data['monthto']:date('Y-m');
		//$dataReturned['indicatorTitle'] = $indicatorTitle;
		//print_r($dataReturned);exit;
		return $dataReturned;
	}
}