<?php

class Monthly_reports_model extends CI_Model {



	public function __construct() {

		parent::__construct();

		$this -> load -> model('Common_model');

		$this -> load -> model('Filter_model');

  		$this->load->helper('my_functions_helper');

		

	

	}

///////////////////////////Tehsil Listing Start//////////////////////////////////////////

public function reports($report_name) {


//setcookie(District,$_SESSION['District'],time()*24*3600);

//$distcode=$_SESSION['District'];
$year 		= $this->input->post('report_year') ? $this->input->post('report_year'):date('Y');
$month 		= $this->input->post('report_month') ? $this->input->post('report_month'):date('m');
$procode  	= $this->input->post('procode') ? $this->input->post('procode'):$_SESSION['Province'];
$distcode  	= $this->input->post('distcode') ? $this->input->post('distcode'):$_SESSION['District'];
$tcode 		= $this->input->post('tcode') ? $this->input->post('tcode'):$_SESSION['tcode'];
$facode		= $this->input->post('facode') ? $this->input->post('facode'):$_SESSION['facode'];
$username	= $_SESSION['User'];
$district	= $_SESSION['District'];
$lhscode 	= $this->input->post('lhscode') ? $this->input->post('lhscode'):"";
$lhwcode 	= $this->input->post('lhwcode') ? $this->input->post('lhwcode'):"";
$fmonth 	= $this->input->post('fmonth') ? $this->input->post('fmonth'):"";


$wc = "";
$level		= "district"; // mean if user is province level then it will be district shown otherwise facility shown
switch ($_SESSION['UserLevel']) {
	case '1':
    # code...
	break;
	case '2':
		$UserLevel = 2;	
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
		}else if($procode > 0){
			$wc[] = "procode = '".$procode."'";
		}
	break;

	case '3':
		$UserLevel = 3;
		$distcode = $_SESSION['District'];
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";			
		}
		$level="facility";
	break;
	case '4':
		$UserLevel = 4;
		$distcode = $_SESSION['District'];
		$facode = $_SESSION['facode'];
		if(($procode > 0) && ($distcode > 0) && ($facode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
			$wc[] = "facode = '".$facode."'";
		}
		$level="facility";
	break;
}
//Workaround for Cloumn name difference in districts table. i.e procode is prvince.


$neWc = $wc;$neWc1 = $wc;
$replacements = array(0 => "province");
$neWc[0] = str_replace("procode","province",$neWc[0]);
$neWc1[0] = str_replace("procode","province",$neWc1[0]);
if($this->input->post('distcode')){
	unset($neWc1[1]);
}
$Caption = "Report";
$datArray = NULL;

$query="Select distcode, district from districts ".((!empty($neWc1))?' where '.implode(" AND ",$neWc1):'')." order by distcode";
$resultDist=$this->db->query($query);
$datArray['districts'] = $resultDist->result_array();
//for indicators

$datArray['years'] = "";

if($report_name == 'lhwmr'){
	$Caption = "LHW Monthly Report Compliance";
}
if($report_name == 'flcfmr'){
	$datArray['comp_report_type'] = "";
	$Caption = "FLCF Monthly Report Compliance";
}

$query="Select facode, fac_name from facilities where  hf_type='l' ".(!empty($wc) ? ' AND '.implode(" AND ", $wc) : '')." order by facode";
$resultFac=$this->db->query($query);
$datArray['flcf'] = $resultFac->result_array();

$subTitle = "Indicator Report";
if($report_name == 'lhwsummary'){
	unset($datArray['years']);
	unset($datArray['comp_report_type']);
	unset($datArray['flcf']);
	$Caption = "LHW Summary Report";
}
if($report_name == 'dmr'){
	$datArray['dist_comp_report_type'] = "";
	unset($datArray['flcf']);
	$Caption = "District Monthly Report Compliance";
}
$datArray['listing_filters'] = $this->Filter_model->createListingFilter($datArray, $datArray, base_url().'Monthly_reports/'.str_replace(" ","_",$report_name).'_compliance',$UserLevel,$Caption); 



return $datArray;





}












public function lhwmr_compliance() {








$wc = ""; 


/*$year 		= $this->input->post('report_year') ? $this->input->post('report_year'):date('Y');
$month 		= $this->input->post('report_month') ? $this->input->post('report_month'):date('m');
$procode  	= $this->input->post('procode') ? $this->input->post('procode'):$_SESSION['Province'];
$distcode  	= $this->input->post('distcode') ? $this->input->post('distcode'):$_SESSION['District'];
$facode		= $this->input->post('facode') ? $this->input->post('facode'):$_SESSION['facode'];*/

$year 		= isset($_REQUEST['report_year'])?$_REQUEST['report_year']:date('Y');
$month  	= isset($_REQUEST['report_month'])?$_REQUEST['report_month']:date('m');
$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$_SESSION['District'];
$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
$facode  	= isset($_REQUEST['facode'])?$_REQUEST['facode']:$_SESSION['facode'];
$tcode = '';


/* $facode ;
print_r($_REQUEST);exit();*/
switch ($_SESSION['UserLevel']) {
	case '1':
    # code...
	break;
	case '2':
	$UserLevel = 2;	
	if(($procode > 0) && ($distcode > 0)){
		$wc[] = "procode = '".$procode."'";
		$wc[] = "distcode = '".$distcode."'";
	}else if($procode > 0){
		$wc[] = "procode = '".$procode."'";
	}
	break;

	case '3':
	$UserLevel = 3;
	$distcode = $_SESSION['District'];
	if(($procode > 0) && ($distcode > 0)){
		$wc[] = "procode = '".$procode."'";
		$wc[] = "distcode = '".$distcode."'";			
	}
	break;
	case '4':
	$UserLevel = 4;
	$distcode = $_SESSION['District'];
	$facode = $_SESSION['facode'];
	if(($procode > 0) && ($distcode > 0) && ($facode > 0)){
		$wc[] = "procode = '".$procode."'";
		$wc[] = "distcode = '".$distcode."'";
		$wc[] = "facode = '".$facode."'";
	}
	break;
}
if($facode > 0){
		$wc[] = "facode = '".$facode."'";
	}

if($this->input->post('export_excel'))
{
	//if request is from excel
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=LHW_Compliance.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	//Excel Ending here
}
//Excel file code ENDS*******************

//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
$neWc = $wc;$neWc1 = $wc;
$replacements = array(0 => "province");
$neWc[0] = str_replace("procode","province",$neWc[0]);
$neWc1[0] = str_replace("procode","province",$neWc1[0]);
if(isset($_REQUEST['distcode'])){
	unset($neWc1[2]);
}

$query="Select distcode, district from districts ".((!empty($neWc1))?' where '.implode(" AND ",$neWc1):'')." order by distcode";
$resultDist=$this->db->query($query);




//Main Filters Data queries ENDS*******************
//Lhw wise district report portion*******************
$monthlyPortion = "";$outerPortion = "";$subTitle = "Compliance Report";

if($distcode == 0 && $facode == 0){
//echo "here in without facode and distcode";exit();
	
	$topHead = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
	for($ind = 1; $ind<13; $ind++)
	{
		$ind = sprintf("%02d",$ind);
		$monthlyPortion .= "(select count(l1.lhwcode)  from lhwdb l1 where l1.distcode = districts.distcode ) AS  due$ind,
		(select count(lhwmr.lhwcode)  from lhwmr join lhwdb l2 on l2.lhwcode = lhwmr.lhwcode where lhwmr.fmonth = '$year-$ind' and lhwmr.distcode = districts.distcode ) AS  sub$ind,";
		$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
		$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
	}
		//round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,0)
		//horizontal sum of each district 
	$monthlyPortion .= "(Select CASE WHEN  count(l1.lhwcode) IS NULL THEN 0 ELSE round((count(l1.lhwcode))::numeric*12,0) END from lhwdb l1 where l1.distcode = districts.distcode ) as totaldue,
	(Select count(lhwmr.lhwcode)  from lhwmr join lhwdb l2 on l2.lhwcode = lhwmr.lhwcode where lhwmr.distcode = districts.distcode and lhwmr.fmonth like '$year-%' ) as totalsub";
	$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";

	$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
		//month wise end
		//  round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,0)
		//main query for flcf wise reporting
		$query = 'select distcode  , district,  '.$monthlyPortion.'  from districts '.((!empty($neWc))?' where '.implode(" AND ",$neWc):'');//distcode =\''.$distcode.'\'
		$query = 'select distcode, district, '.$outerPortion.' from ('.$query.') as a';
		
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();	
		
		//for vertical total of all rows.
		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();

		$subTitle ="District Wise LHW Monthly Compliance";
		$data['htmlData'] = getComplianceReportTable($data['allData'],$data['allDataTotal']);
		//echo '<pre>';print_r($data['htmlData']);exit();
		$data['subtitle']=$subTitle;
		$data['exportIcons']=$this->Filter_model->exportIcons();
		//$data['getReportHead']=$this->getReportHead($subTitle);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		//echo '<pre>';print_r($data['TopInfo']);exit();
		$data['year']=$year;
		

	}
	if($distcode > 0 && $facode == 0){

		//echo "here in without facode";exit();
		//echo $facode."WWWWWWWW".$distcode;
		for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= "coalesce((Select count(l.lhwcode) from lhwdb l where l.facode = f2.facode ),0) as due$ind,
			coalesce((Select count(l1.lhwcode)  from lhwmr l1 where l1.facode=f2.facode and fmonth = '$year-$ind'),0) as sub$ind,";
			$outerPortion .= "due$ind,sub$ind, coalesce(round((sub$ind::float//due$ind)::numeric*100,0),0) as \"%$ind\",";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= "(Select CASE WHEN  count(l.lhwcode) IS NULL THEN 0 ELSE round((count(l.lhwcode))::numeric*12,0) END from lhwdb l WHERE l.facode = f2.facode ) as totaldue,
		(Select CASE WHEN  count(l1.lhwcode) IS NULL THEN 0 ELSE count(l1.lhwcode) END from lhwmr l1 where l1.facode=f2.facode and l1.fmonth like '$year-%') as totalsub";
		$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
		$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind";
		//month wise end

		//main query for lhw wise reporting //procode is ambiguous
		$query = 'select distinct f2.facode  , f2.tcode, '.$monthlyPortion.' from facilities f2 where f2.hf_type = \'l\' '.((!empty($wc))?' AND '.implode(" AND ",$wc):'').' order by f2.facode';
		$query = 'select facode  , facilityname(facode) as "FLCF Name", '.$outerPortion.' from ('.$query.') as a';
		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';

		$result=$this->db->query($query);

		$data['allData']=$result->result_array();

		$subTitle ="LHW Wise Monthly Compliance";

	//for vertical total of all rows.
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();


		$data['htmlData'] = getComplianceReportTable($data['allData'],$data['allDataTotal']);
		
		$data['subtitle']=$subTitle;
		$data['exportIcons']=$this->Filter_model->exportIcons();
		//$data['ReportHead']=$this->getReportHead($subTitle);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		
		

		$data['year']=$year;
		
	}
	if($distcode > 0 && $facode > 0){


		

		
		$topHead = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
		{
			for($ind = 1; $ind<13; $ind++)
			{
				$ind = sprintf("%02d",$ind);
				$monthlyPortion .= " CASE WHEN CAST((select lhwcode  from lhwmr where lhwmr.fmonth = '$year-$ind' and lhwcode = lhwdb.lhwcode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS ".$topHead[$ind-1].",";
				$allTotalPortion .= "sum(".$topHead[$ind-1].") as total$ind,";
			}
		
			$monthlyPortion .= " (select CASE WHEN CAST(count(lhwcode) AS INTEGER) > 0 THEN round((count(lhwcode))::numeric,0) ELSE 0 END  from lhwmr where  lhwcode = lhwdb.lhwcode  and lhwmr.fmonth like '$year-%' ) AS total";
			$allTotalPortion .= "sum(total) as total$ind";
			
			$query = 'select lhwdb.lhwcode, lhwdb.lhwname as "LHW Name", '.$monthlyPortion.'  from lhwdb '.((!empty($wc))?' where '.implode(" AND ",$wc):'');
			$result=$this->db->query($query);
			$data['allDataTotalDue'] = $result->num_rows();
			$data['allData']=$result->result_array();	

			$queryForTotal = 'select '.$allTotalPortion.' from ('.$query.') as b';
			$resultTotal=$this->db->query($queryForTotal);
			$data['allDataTotal']=$resultTotal->result_array();

			$subTitle ="Month Wise LHW Monthly Compliance";
		
			$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		
			$data['htmlData'] = getComplianceFLCFReportTable($data['allData'],$data['allDataTotal'],$data['allDataTotalDue']);
	
			$data['subtitle']=$subTitle;
			$data['exportIcons']=$this->Filter_model->exportIcons();



			
		

			
		}



			
	}
	
	return $data;
	
}



public function flcfmr_compliance(){



$wc = ""; 


/*$year 		= $this->input->post('report_year') ? $this->input->post('report_year'):date('Y');
$month 		= $this->input->post('report_month') ? $this->input->post('report_month'):date('m');
$procode  	= $this->input->post('procode') ? $this->input->post('procode'):$_SESSION['Province'];
$distcode  	= $this->input->post('distcode') ? $this->input->post('distcode'):$_SESSION['District'];
$facode		= $this->input->post('facode') ? $this->input->post('facode'):$_SESSION['facode'];*/

$year 		= isset($_REQUEST['report_year'])?$_REQUEST['report_year']:date('Y');
$month  	= isset($_REQUEST['report_month'])?$_REQUEST['report_month']:date('m');
$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$_SESSION['District'];
$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
$facode  	= isset($_REQUEST['facode'])?$_REQUEST['facode']:$_SESSION['facode'];
$tcode = '';


switch ($_SESSION['UserLevel']) {
	case '1':
    # code...
	break;
	case '2':
		$UserLevel = 2;	
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
		}else if($procode > 0){
			$wc[] = "procode = '".$procode."'";
		}
	break;

	case '3':
		$UserLevel = 3;
		$distcode = $_SESSION['District'];
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";			
		}
	break;
	case '4':
		$UserLevel = 4;
		$distcode = $_SESSION['District'];
		$facode = $_SESSION['facode'];
		if(($procode > 0) && ($distcode > 0) && ($facode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
			$wc[] = "facode = '".$facode."'";
		}
	break;
}
if($facode > 0){
		$wc[] = "facode = '".$facode."'";
}
/*if(isset($_REQUEST['tcode']) && ($_REQUEST['tcode']  > 0))
{
	$wc[] = "tcode = '".$_REQUEST['tcode']."'";
}*/

if($this->input->post('export_excel'))
{
	//if request is from excel
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=LHW_Compliance.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	//Excel Ending here
}
//Excel file code ENDS*******************

//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
$neWc = $wc;$neWc1 = $wc;
$replacements = array(0 => "province");
$neWc[0] = str_replace("procode","province",$neWc[0]);
$neWc1[0] = str_replace("procode","province",$neWc1[0]);
if($this->input->post('distcode')){
	unset($neWc1[2]);
}


$query="Select distcode, district from districts ".((!empty($neWc1))?' where '.implode(" AND ",$neWc1):'')." order by distcode";
$resultDist=$this->db->query($query);

//Main Filters Data queries ENDS*******************
//Lhw wise district report portion*******************
$monthlyPortion = "";$outerPortion = "";$subTitle = "Compliance Report";
if($this->input->post('report_type')=='lhw')
{
	if($_SESSION['UserLevel'] =='2')
	{		
		for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= "(Select CASE WHEN  sum(flc1.no_reporting_lhws) IS NULL THEN 0 ELSE sum(flc1.no_reporting_lhws) END from flcfmr flc1 join facilities f2 on f2.facode = flc1.facode where flc1.distcode=districts.distcode and flc1.fmonth = '$year-$ind' and f2.hf_type = 'l') as due$ind,
			(Select CASE WHEN  sum(flc1.no_submitted_reports) IS NULL THEN 0 ELSE sum(flc1.no_submitted_reports) END from flcfmr flc1 join facilities f2 on f2.facode = flc1.facode where flc1.distcode=districts.distcode and flc1.fmonth = '$year-$ind' and f2.hf_type = 'l') as sub$ind,";
			$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= "(Select CASE WHEN  sum(flc1.no_reporting_lhws) IS NULL THEN 0 ELSE round((sum(flc1.no_reporting_lhws))::numeric,0)  END from flcfmr flc1 join facilities f2 on f2.facode = flc1.facode where flc1.distcode=districts.distcode and flc1.fmonth like '$year-%' and f2.hf_type = 'l') as totaldue,
			(Select CASE WHEN  sum(flc1.no_submitted_reports) IS NULL THEN 0 ELSE sum(flc1.no_submitted_reports) END from flcfmr flc1 join facilities f2 on f2.facode = flc1.facode where flc1.distcode=districts.distcode and flc1.fmonth like '$year-%' and f2.hf_type = 'l') as totalsub";
		$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
		$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind";
		//month wise end
//round((totalSub$ind::float//totalDue$ind)::numeric*100,0)
		//main query for district wise lhws reporting
		$query = 'select distcode  , district,  '.$monthlyPortion.' from districts '.((!empty($neWc))?' where '.implode(" AND ",$neWc):'');
		$query = "select distcode  , district, ".$outerPortion." from ($query) as a";
		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';
	}else
	{
		for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= "coalesce((Select flc1.no_reporting_lhws from flcfmr flc1 where flc1.facode=flcfmr.facode and fmonth = '$year-$ind'),0) as due$ind,
			coalesce((Select flc1.no_submitted_reports  from flcfmr flc1 where flc1.facode=flcfmr.facode and fmonth = '$year-$ind'),0) as sub$ind,";
			$outerPortion .= "due$ind,sub$ind, coalesce(round((sub$ind::float//due$ind)::numeric*100,0),0) as \"%$ind\",";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= "(Select CASE WHEN  sum(flc1.no_reporting_lhws) IS NULL THEN 0 ELSE round((sum(flc1.no_reporting_lhws))::numeric*12,0) END from flcfmr flc1 where flc1.facode=flcfmr.facode and flc1.fmonth like '$year-%') as totaldue,
			(Select CASE WHEN  sum(flc1.no_submitted_reports) IS NULL THEN 0 ELSE sum(flc1.no_submitted_reports) END from flcfmr flc1 where flc1.facode=flcfmr.facode and flc1.fmonth like '$year-%') as totalsub";
		$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
		$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,1) as TotalPerc$ind";
		//month wise end

		//main query for lhw wise reporting //procode is ambiguous
		/*$neWc[0] = str_replace("province","flcfmr.procode",$neWc[0]);
		$neWc[1] = str_replace("distcode","flcfmr.distcode",$neWc[1]);
		if($facode!=''){
		$neWc[2] = str_replace("facode","flcfmr.facode",$neWc[2]);
		}
		$query = 'select distinct flcfmr.facode  , flcfmr.tcode, '.$monthlyPortion.' from flcfmr join facilities f2 on f2.facode = flcfmr.facode where f2.hf_type = \'l\' '.((!empty($neWc))?' AND '.implode(" AND ",$neWc):'').' order by flcfmr.facode';
		$query = 'select facode  , facilityname(facode) as "FLCF Name", '.$outerPortion.' from ('.$query.') as a';
		
		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';*/

		$neWc[0] = str_replace("province","flcfmr.procode",$neWc[0]);
		$neWc[1] = str_replace("distcode","flcfmr.distcode",$neWc[1]);
		
		if(!empty($facode) && $facode != '0' && $facode != 0) {
			$neWc[2] = str_replace("facode","flcfmr.facode",$neWc[2]);
		}
		
		$query = 'select distinct flcfmr.facode, 
								flcfmr.tcode, 
								'.$monthlyPortion.' 
					from flcfmr 
					right join facilities f2 on f2.facode = flcfmr.facode 
					where f2.hf_type = \'l\' '.((!empty($neWc))?' AND '.implode(" AND ",$neWc):'').' order by flcfmr.facode';

		$query = 'select facode  , facilityname(facode) as "FLCF Name", '.$outerPortion.' from ('.$query.') as a';

		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';
	}
	$result=$this->db->query($query);

	$data['allData']=$result->result_array();
//print_r($data['allData']);exit();
	$subTitle ="LHW Wise Monthly Compliance";
	
	//for vertical total of all rows.
	$resultTotal=$this->db->query($queryForTotal);
	$data['allDataTotal']=$resultTotal->result_array();
	
	$data['htmlData'] = getComplianceReportTable($data['allData'],$data['allDataTotal']);

	$data['subtitle']=$subTitle;
	$data['lhw']='lhw';
	$data['exportIcons']=$this->Filter_model->exportIcons($_REQUEST);
	//print_r($_REQUEST);exit;
//echo $facode."".$_REQUEST['report_year'];exit;
	$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$_REQUEST['report_year']);
	//print_r($data['TopInfo']);exit();
	//$data['ReportHead']=$this->getReportHead($subTitle);
	$data['year']=$year;

return $data;

}
//Lhw wise district report portion END*******************
//flcf wise district report portion start*******************
//if($_REQUEST['report_type']=='flcf')
else
{ 
	$topHead = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
	if($_SESSION['UserLevel'] =='2')
	{
		if($distcode > 0 && $facode == 0){
			for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= " CASE WHEN CAST((select facode  from flcfmr where flcfmr.fmonth = '$year-$ind' and facode = facilities.facode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS ".$topHead[$ind-1].",";
			$allTotalPortion .= "sum(".$topHead[$ind-1].") as total$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= " (select CASE WHEN CAST(count(facode) AS INTEGER) > 0 THEN round((count(facode))::numeric,0) ELSE 0 END  from flcfmr where facode = facilities.facode) AS total";
		$allTotalPortion .= "sum(total) as total$ind";
		//month wise end

		//main query for flcf wise reporting		
		$query = 'select facilities.facode, facilities.fac_name as "FLCF Name", '.$monthlyPortion.'  from facilities where facilities.hf_type=\'l\' '.((!empty($wc))?' AND '.implode(" AND ",$wc):'');
		

		$result=$this->db->query($query);
		$data['allDataTotalDue'] = $result->num_rows();
		$data['allData']=$result->result_array();	
		
		//for vertical total of all rows.
		$queryForTotal = 'select '.$allTotalPortion.' from ('.$query.') as b';
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		
		$subTitle ="Facility Wise Monthly Compliance";
		$data['htmlData'] = getComplianceFLCFReportTable($data['allData'],$data['allDataTotal'],$data['allDataTotalDue']);
		$data['subtitle']=$subTitle;
		$data['exportIcons']=$this->Filter_model->exportIcons($_REQUEST);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		//$data['ReportHead']=$this->getReportHead($subTitle);
		$data['year']=$year;
		//print_r($data);exit();
		}
		else{

			for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= "(select count(f1.facode)  from facilities f1 where f1.distcode = districts.distcode and f1.hf_type='l' ) AS  due$ind,
			(select count(flcfmr.facode)  from flcfmr join facilities f2 on f2.facode = flcfmr.facode where flcfmr.fmonth = '$year-$ind' and flcfmr.distcode = districts.distcode and f2.hf_type = 'l' ) AS  sub$ind,";
			$outerPortion .= "due$ind,sub$ind, round((sub$ind::float//due$ind)::numeric*100,0) as \"%$ind\",";
			$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind,";
		}

		//round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,0)
		//horizontal sum of each district 
		$monthlyPortion .= "(Select CASE WHEN  count(f1.facode) IS NULL THEN 0 ELSE round((count(f1.facode))::numeric*12,0) END from facilities f1 where f1.distcode = districts.distcode and f1.hf_type='l') as totaldue,
			(Select count(flcfmr.facode)  from flcfmr join facilities f2 on f2.facode = flcfmr.facode where flcfmr.distcode = districts.distcode and flcfmr.fmonth like '$year-%' and f2.hf_type = 'l') as totalsub";
		$outerPortion .= "totaldue as due$ind,totalsub as sub$ind, round((totalsub::float//totaldue)::numeric*100,1) as \"%$ind\"";
		
		$allouterPortion .= "sum(due$ind) as totalDue$ind,sum(sub$ind) as totalSub$ind, round((sum(sub$ind)::float//sum(due$ind))::numeric*100,1) as TotalPerc$ind";
		//month wise end
		//  round((sum(\"%$ind\")::float//sum(CASE WHEN \"%$ind\" > 0 then 1 ELSE 0 END))::numeric,0)
		//main query for flcf wise reporting
		$query = 'select distcode  , district,  '.$monthlyPortion.'  from districts '.((!empty($neWc))?' where '.implode(" AND ",$neWc):'');//distcode =\''.$distcode.'\'
		$query = 'select distcode, district, '.$outerPortion.' from ('.$query.') as a';
		
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();	
		
		//for vertical total of all rows.
		$queryForTotal = 'select '.$allouterPortion.' from ('.$query.') as b';
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();
	
		$subTitle ="District Wise Facilities Monthly Compliance";
		$data['htmlData'] = getComplianceReportTable($data['allData'],$data['allDataTotal']);
		$data['subtitle']=$subTitle;
		$data['exportIcons']=$this->Filter_model->exportIcons($_REQUEST);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		//$data['ReportHead']=$this->getReportHead($subTitle);
		$data['year']=$year;

	}
	}else{



		
		for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= " CASE WHEN CAST((select facode  from flcfmr where flcfmr.fmonth = '$year-$ind' and facode = facilities.facode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS ".$topHead[$ind-1].",";
			$allTotalPortion .= "sum(".$topHead[$ind-1].") as total$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= " (select CASE WHEN CAST(count(facode) AS INTEGER) > 0 THEN round((count(facode))::numeric,0) ELSE 0 END  from flcfmr where facode = facilities.facode) AS total";
		$allTotalPortion .= "sum(total) as total$ind";
		//month wise end

		//main query for flcf wise reporting		
		$query = 'select facilities.facode, facilities.fac_name as "FLCF Name", '.$monthlyPortion.'  from facilities where facilities.hf_type=\'l\' '.((!empty($wc))?' AND '.implode(" AND ",$wc):'');
		$result=$this->db->query($query);
        
		$data['allData']=$result->result_array();	
		
		//for vertical total of all rows.
		$queryForTotal = 'select '.$allTotalPortion.' from ('.$query.') as b';
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		
		$subTitle ="Facility Wise Monthly Compliance";
		$data['htmlData'] = getComplianceFLCFReportTable($data['allData'],$data['allDataTotal']);
		$data['subtitle']=$subTitle;
		$data['exportIcons']=$this->Filter_model->exportIcons($_REQUEST);
		//$data['ReportHead']=$this->getReportHead($subTitle); 
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,$facode,$year);
		$data['year']=$year;
		
		

	}	
}

return $data;


}

public function dmr_compliance(){



$wc = ""; 
$year 		= isset($_REQUEST['report_year'])?$_REQUEST['report_year']:date('Y');
$procode  	= isset($_REQUEST['procode'])?$_REQUEST['procode']:$_SESSION['Province'];
$distcode  	= isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$_SESSION['District'];
$tcode = '';


switch ($_SESSION['UserLevel']) {
	case '1':
    # code...
	break;
	case '2':
		$UserLevel = 2;	
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
		}else if($procode > 0){
			$wc[] = "procode = '".$procode."'";
		}
	break;

	case '3':
		$UserLevel = 3;
		$distcode = $_SESSION['District'];
		if(($procode > 0) && ($distcode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";			
		}
	break;
	case '4':
		$UserLevel = 4;
		$distcode = $_SESSION['District'];
		$facode = $_SESSION['facode'];
		if(($procode > 0) && ($distcode > 0) && ($facode > 0)){
			$wc[] = "procode = '".$procode."'";
			$wc[] = "distcode = '".$distcode."'";
			$wc[] = "facode = '".$facode."'";
		}
	break;
}
if(isset($_REQUEST['tcode']) && ($_REQUEST['tcode']  > 0))
{
	$wc[] = "tcode = '".$_REQUEST['tcode']."'";
}
$subTitle ="District Wise Monthly Compliance";
if(isset($_REQUEST['export_excel']))
{
	//if request is from excel
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$subTitle."_".$year.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	//Excel Ending here
}

//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
$neWc = $wc;$neWc1 = $wc;
$replacements = array(0 => "province");
$neWc[0] = str_replace("procode","province",$neWc[0]);
$neWc1[0] = str_replace("procode","province",$neWc1[0]);
if(isset($_REQUEST['distcode'])){
	unset($neWc1[1]);
}
$query="Select distcode, district from districts ".((!empty($neWc1))?' where '.implode(" AND ",$neWc1):'')." order by distcode";
$resultDist=$this->db->query($query);

//Main Filters Data queries ENDS*******************
//Lhw wise district report portion*******************
$monthlyPortion = "";$outerPortion = "";$subTitle = "Compliance Report";


	$topHead = array('jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec');
	if($_SESSION['UserLevel'] =='2' || $_SESSION['UserLevel'] =='3')
	{
			
		for($ind = 1; $ind<13; $ind++)
		{
			$ind = sprintf("%02d",$ind);
			$monthlyPortion .= " CASE WHEN CAST((select distcode from dmr where dmr.fmonth = '$year-$ind' and distcode = districts.distcode) AS INTEGER) > 0 THEN 1 ELSE 0 END AS ".$topHead[$ind-1].",";
			$allTotalPortion .= "sum(".$topHead[$ind-1].") as total$ind,";
		}
		//horizontal sum of each district
		$monthlyPortion .= " (select CASE WHEN CAST(count(distcode) AS INTEGER) > 0 THEN round((count(distcode))::numeric,0) ELSE 0 END  from dmr where distcode = districts.distcode) AS total";
		$allTotalPortion .= "sum(total) as total$ind";
		//month wise end

		//main query for district wise reporting		
		$query = 'select districts.distcode, districts.district as "District Name", '.$monthlyPortion.'  from districts '.((!empty($neWc))?' where '.implode(" AND ",$neWc):'');
		//echo $query;exit();
		$result=$this->db->query($query);
		$allDataTotalDue = $result->num_rows;
		$data['allData']=$result->result_array();	
		
		//for vertical total of all rows.
		$queryForTotal = 'select '.$allTotalPortion.' from ('.$query.') as b';
		$resultTotal=$this->db->query($queryForTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		
		$data['subtitle'] ="District Wise Monthly Compliance";
		
		$data['TopInfo']=$this->tableTopInfo($subTitle,$distcode,"",$facode,$_REQUEST['report_type'],"",$year);
		//print_r($data['TopInfo']);echo '<hr>';
		$data['htmlData'] = getComplianceFLCFReportTable($data['allData'],$data['allDataTotal'],$allDataTotalDue);
		$data['exportIcons']=$this->Filter_model->exportIcons();

		
		
	}
	

//district wise district report portion Ends*******************
//Excel file code is here*******************


return $data;
//Excel file code ENDS******************
}












function getReportHead($subTitle=NULL){

	$title="LHW - MIS System";

	echo 

	'<table width="100%" border="0" align="center" cellpadding="1" cellspacing="5" class="reports_head">

	<tr>

		<td colspan="3" align="center"><strong>'.$title.'</strong></td>

	</tr>

	<tr>

		<td colspan="3" align="center"><small>'.$subTitle.'</small></td>

	</tr>

	<tr>

		<td>&nbsp;</td>

		<td>&nbsp;</td>

		<td>&nbsp;</td>

	</tr>

</table>';

}

function getYearsOptions($isreturn=false){
	$years=date('Y');$output = '';
	$preyears=2010;
	for($x=$years;$x>=$preyears;$x--){
		$isSelected = (isset($_REQUEST["report_year"]) && $_REQUEST["report_year"]==$x)?'selected="selected"':'';
		$output .= '<option value="'.$x.'" '.$isSelected.' >'.$x.'</option>';
	}
	if($isreturn)
		return $output;
	echo $output;
}
function getMonthsOptions($isreturn=false){
	$months = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
	$mnth = isset($_REQUEST["report_month"])?$_REQUEST["report_month"]:date('m');
	$output='';
	foreach ($months as $num => $monthitem) { 
		$isSelected = ($mnth==$num)?'selected="selected"':'';
		if($num<10){$month='0'.$num;}else{$month=$num;}
		$output .= '<option value="'.$month.'" '.$isSelected.' >'.$monthitem.'</option>';								
	}
	if($isreturn)
		return $output;
	echo $output;
}
}?>