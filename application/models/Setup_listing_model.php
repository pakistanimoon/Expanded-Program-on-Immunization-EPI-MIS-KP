<?php
class Setup_listing_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> load -> model('Common_model');
		$this -> load -> model('Filter_model');
		$this->load->helper('my_functions_helper');
		$this->load->helper('epi_functions_helper');
		$this -> load -> helper('epi_reports_helper');
		error_reporting(0);
	}
	//////////////////////////////////Constructor End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	////////////////////////////////// Listing Filters Start////////////////////////////////////////////////////////////
	public function listing($listing_name) {
		$post_data=posted_Values();
		if(!$post_data['distcode']>0)
			$post_data['distcode']= $this->session->District;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		//echo '<pre>';print_r($post_data);exit;
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		$neWc1 = $wc;
		$replacements = array(0 => "province");
		$neWc1[0] = str_replace("procode","province",$neWc1[0]);
		if($this ->input -> post('distcode')){
		   unset($neWc1[1]);
		}
		$datArray = NULL;
		$resultDist = NULL;
		if($listing_name=="district" || $listing_name=="tehsil" || $listing_name=="union_Council" || $listing_name=="EPI_Centers" || $listing_name=="VPD_Centers" || $listing_name=="supervisor" || $listing_name=="technician" || $listing_name=="Computer_Operator" || $listing_name=="Generator_Operator" || $listing_name=="Cold_Chain_Operator" || $listing_name=="Cold_Chain_Mechanic"  ||  $listing_name=="Cold_Chain_Technician" || $listing_name=="district_Surveillance_Officer"  || $listing_name=="cold_Chain_Generator_Operator" || $listing_name=="cold_Chain_Driver" || $listing_name=="med_technician" || $listing_name=="StoreKeeper" || $listing_name=="DataEntry_Operator" ){
			$query="Select distcode, district from districts ".((!empty($neWc1))?' where '.implode(" AND ",$neWc1):'')." order by district";
			$resultDist=$this->db->query($query);
			$datArray['districts'] = $resultDist->result_array();
			if($listing_name=="district" || $listing_name=="tehsil" || $listing_name=="union_Council" || $listing_name=="EPI_Centers" || $listing_name=="technician")
				$datArray['years'] = 'years';
		}
		if($listing_name=="union_Council" || $listing_name=="EPI_Centers"  || $listing_name=="VPD_Centers" ||  $listing_name=="supervisor" || $listing_name=="technician"  || $listing_name=="DataEntry_Operator" || $listing_name=="Computer_Operator" || $listing_name=="Generator_Operator" || $listing_name=="Cold_Chain_Operator" || $listing_name=="Cold_Chain_Mechanic" || $listing_name=="Cold_Chain_Technician" || $listing_name=="district_Surveillance_Officer" ||  $listing_name=="cold_Chain_Generator_Operator" || $listing_name=="med_technician"){
			$query="Select tehsil, tcode from tehsil ".(!empty($wc) ? ' WHERE '.implode(" AND ", $wc) : '')." order by tehsil";
			$resultTeh=$this->db->query($query);
			$datArray['tehsil'] = $resultTeh->result_array();
		}
		if($listing_name=="supervisor" || $listing_name=="technician" || $listing_name=="district_Surveillance_Officer" || $listing_name=="cold_Chain_Mechanic" || $listing_name=="cold_Chain_Generator_Operator" || $listing_name=="med_technician"){
			$fwc = $wc;
			if($this ->input -> post('facode')){
				if(($key = array_search("facode = '".$facode."'", $fwc)) !== false) {
					unset($fwc[$key]);
				}
			}
			$query="Select facode, fac_name from facilities where  hf_type='l' ".(!empty($fwc) ? ' AND '.implode(" AND ", $fwc) : '')." order by fac_name";
			$resultFac=$this->db->query($query);
			$datArray['flcf'] = $resultFac->result_array();
		}
		if($listing_name=="technician"){
			$query="Select uncode, un_name from unioncouncil ".(!empty($fwc) ? ' where '.implode(" AND ", $fwc) : '')." order by un_name asc";
			$resultUn=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUn->result_array();
		}
		if($listing_name=="med_technician"){
			$query="Select uncode, un_name from unioncouncil ".(!empty($fwc) ? ' where '.implode(" AND ", $fwc) : '')." order by un_name asc";
			$resultUn=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUn->result_array();
		}
		if($listing_name=="Health_Facility"){
			$datArray['flcf_type'] = '';
			$query="Select distinct fatype from facilities where  hf_type='e' order by fatype";
			$resultFatype=$this->db->query($query);
			$datArray['fatype'] = $resultFatype->result_array();
		}
		if($listing_name=="hr"){
			$query="Select type_id, title from hr_sub_types order by title asc";
			$result=$this->db->query($query);
			$datArray['hr_sub_type'] = $result->result_array();
		}
		if($listing_name=="supervisor" || $listing_name=="StoreKeeper" || $listing_name=="DataEntry_Operator" || $listing_name=="technician" || $listing_name=="Cold_Chain_Technician" || $listing_name=="Computer_Operator" || $listing_name=="Generator_Operator"  || $listing_name=="Cold_Chain_Operator" || $listing_name=="Cold_Chain_Mechanic" || $listing_name=="district_Surveillance_Officer" || $listing_name=="cold_Chain_Technician"  || $listing_name=="cold_Chain_Generator_Operator" || $listing_name=="cold_Chain_Driver" || $listing_name=="med_technician" || $listing_name=="DataEntry_operator" || $listing_name=="hr"){
			$query="select caption,value from lookup_detail where master_id='1'";
			$result=$this->db->query($query);
			$datArray['status'] = $result->result_array();
		}
		if($listing_name=="supervisor"){
			unset($datArray['flcf']);
			$datArray['supervisortype']="";
		}
		if($listing_name=="Computer_Operator"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="Generator_Operator"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="Cold_Chain_Operator"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="Cold_Chain_Technician"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="Cold_Chain_Mechanic"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="DataEntry_operator"){
			unset($datArray['tehsil']);
		}
        if($listing_name=="storekeeper"){
			unset($datArray['tehsil']);
		}
		if($listing_name=="district_Surveillance_Officer"){
			unset($datArray['tehsil']);unset($datArray['flcf']);
		}
		if($listing_name=="EPI_Centers"){

			$query="Select uncode, un_name from unioncouncil ".(!empty($fwc) ? ' where '.implode(" AND ", $fwc) : '')." order by un_name asc";
			$resultUn=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUn->result_array();
		}
		if($listing_name=="VPD_Centers"){

			$query="Select uncode, un_name from unioncouncil ".(!empty($fwc) ? ' where '.implode(" AND ", $fwc) : '')." order by un_name asc";
			$resultUn=$this->db->query($query);
			$datArray['unioncouncil'] = $resultUn->result_array();
		}
		$titlee = ( ($listing_name=='supervisor')?'Supervisor Listing':( ($listing_name=='technician')?'Technician Listing':( ucwords(str_replace("EPI_Centers","EPI Center",$listing_name)).' Listing') )  );
		$titlee = ($listing_name=='cold_Chain_Driver')?'Driver Listing':$titlee;
		$titlee = ($listing_name=='med_technician')?'HF Incharge Listing':$titlee;
		$titlee = ($listing_name=='hr')?'HR Listing':$titlee;
		$datArray['listing_filters'] = $this->Filter_model->createListingFilter($datArray, $datArray, base_url().'setup_listing/'.str_replace(" ","_",$listing_name).'_listing',$UserLevel,$titlee);
		$datArray['titlee']= $titlee;
		createTransactionLog("Listing", $titlee." Viewed");
		return $datArray;
	}
	//////////////////////////////////Listing Filters End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////District Listing Start////////////////////////////////////////////////////////////
	public function district_listing($year){
		////////getting Procode distcode///////////////
		$post_data=posted_Values();
	//	print_r($post_data);exit;
		$year = $post_data['year'];
		//echo $year;exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],'');
		//Excel file code is here*******************
		if( $this ->input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=District_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc1 = $wc;
		$replacements = array(0 => "province");
		$neWc1[0] = str_replace("procode","province",$neWc1[0]);
		//print_r($wc);exit();
		if( $this ->input -> post('distcode')){
			unset($neWc1[1]);
		}
				$query =' Select district as "District ", districts.distcode as  "District Code",
		(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \'Active\') as "Total HR",
		coalesce(districts_population.population,\'0\') as "population", getnewbornpop(districts.distcode::text,\'district\'::text,'.$year.'::text) as "New Borns", getsurvivinginfantspop(districts.distcode::text,\'district\'::text,'.$year.'::text) as "Surviving Infants",
		getplwpop(districts.distcode::text,\'district\'::text,'.$year.'::text) as "P&LW",
		round((getsurvivinginfantspop(districts.distcode::text,\'district\'::text,'.$year.'::text)*94.98)/100) as "12-23 M",
		getcbapop(districts.distcode::text,\'district\'::text,'.$year.'::text) as "CBAs" FROM districts full join districts_population on districts.distcode=districts_population.distcode and districts_population.year=\''.$year.'\' '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'').'  order by district';
	    
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		//print_r($data['allData']);exit;
		$subTitle ="District Listing";
		$data['subtitle']=$subTitle;
		$queryTotal = 'Select sum("EPI Center") as "total Health Facility",sum("Total HR") as "Total HR",
						sum(CAST (population AS INTEGER)) as totalpopulation from ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$data['allDataTotal']=$resultTotal->result_array();
		$data['getListingTable']=getListingReportTable($data['allData'],'',$data['allDataTotal'],'NO');
		$data['TopInfo'] = tableTopInfo($subTitle, $post_data['distcode'], '', $year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		//print_r($data['TopInfo']);exit;
		return $data;
	}
	//////////////////////////////////District Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Tehsil Listing Start////////////////////////////////////////////////////////////
	public function tehsil_listing($year) {
		$post_data=posted_Values();
		$year = $post_data['year'];
		$distcode = $post_data['distcode'];
		//print_r($post_data);exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		//Excel file code is here*******************
		if($this ->input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Tehsil_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc1 = $wc;
		$replacements = array(0 => "province");
		$neWc1[0] = str_replace("procode","province",$neWc1[0]);
        $distcodeWc = "";
		if($distcode>0){
			unset($neWc1[1]);
         $distcodeWc = "AND tehsil.distcode = '".$distcode."'";
		}
		$s="'Active'";
		$query =' Select tehsil as "Tehsil", tehsil.tcode as  "Tehsil Code", districtname(tehsil.distcode) AS insiderow,
		(select count(t.tcode) from tehsil t where t.distcode = tehsil.distcode) as total,
		(select count(facode) from facilities where facilities.tcode = tehsil.tcode and facilities.hf_type = \'e\' ) as "Total EPI Center",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_tcode = tehsil.tcode and post_status= '.$s.') as "Total HR",
		coalesce(tehsil_population.population,\'0\') as population,getnewbornpop(tehsil.tcode::text,\'tehsil\'::text,'.$year.'::text) as "New Borns", getsurvivinginfantspop(tehsil.tcode::text,\'tehsil\'::text,'.$year.'::text) as "Surviving Infants",
		getplwpop(tehsil.tcode::text,\'tehsil\'::text,'.$year.'::text) as "P&LW",
		round((getsurvivinginfantspop(tehsil.tcode::text,\'tehsil\'::text,'.$year.'::text)*94.98)/100) as "12-23 M",
		getcbapop(tehsil.tcode::text,\'tehsil\'::text,'.$year.'::text) as "CBAs" FROM tehsil full join tehsil_population on  tehsil_population.tcode=tehsil.tcode  and tehsil_population.year=\''.$year.'\' where procode = \''.$post_data['procode'].'\' '.$distcodeWc.' order by tehsil.distcode,tehsil.tcode';
		//print_r($query);exit;
		$result=$this -> db -> query($query);
		$data['allData'] = $result -> result_array();
		$queryTotal = 'Select sum("Total EPI Center") as "total Health Facility",sum("Total HR") as totalHr, sum(CAST (population AS INTEGER)) as totalpopulation from ('.$query.') as a';
		$resultTotal=$this -> db -> query($queryTotal);
		$data['allDataTotal'] = $resultTotal -> result_array();
		$subTitle ="Tehsil Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($data['allData'],"Tehsil",$data['allDataTotal'],'NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Tehsil Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Health Facility Listing Start////////////////////////////////////////////////////////////
	public function epi_centers_listing($year){
		$post_data=posted_Values();
		//$year = $post_data['year'];
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],"fac.");
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		if(!($post_data['distcode']>0)){
				redirect('setup_listing/summary_listing?listing=EPI_Centers&year='.$year);
				exit();
		}
			//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Health_Facility_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		if($post_data['tcode'] > 0){
			$wc[] = "fac.tcode = '".$post_data['tcode']."'";

		}
		if($post_data['uncode'] > 0){
			$wc[] = "fac.uncode = '".$post_data['uncode']."'";
		}

		$s="'Active'";
		$where = 'where fac.hf_type = \'e\' '.((!empty($wc))? ' AND '.implode(" AND ",$wc):'');
		$query =' Select  fac.fac_name as "EPI Center Name",  fac.facode as " EPI Center Code ", fac.fatype as " EPI Center Type", tehsilname(fac.tcode) AS insiderow ,
		(select count(f.facode) from facilities f where f.hf_type=\'e\' AND f.distcode = \''.$post_data['distcode'].'\' AND f.tcode = fac.tcode ) as total, tehsilname(fac.tcode) as "Tehsil",
		unname(fac.uncode) as "Union Council", initcap(fac.areatype) as "Area Type",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_facode = fac.facode and post_status= '.$s.' and post_hr_sub_type_id=\'01\') as "Technicians",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_facode = fac.facode and post_status= '.$s.' and post_hr_sub_type_id=\'09\') as "HF Incharge",
		coalesce(facilities_population.population,\'0\') as "Catchment Population", getnewbornpop(fac.facode::text,\'facility\'::text,'.$year.'::text) as "New Borns", getsurvivinginfantspop(fac.facode::text,\'facility\'::text,'.$year.'::text) as "Surviving Infants",
		getplwpop(fac.facode::text,\'facility\'::text,'.$year.'::text) as "P&LW",
		round((getsurvivinginfantspop(fac.facode::text,\'facility\'::text,'.$year.'::text)*94.98)/100) as "12-23 M",
		getcbapop(fac.facode::text,\'facility\'::text,'.$year.'::text) as "CBAs" from facilities fac full join facilities_population on facilities_population.facode=fac.facode and facilities_population.year=\''.$year.'\' '.$where.' order by fac.tcode,fac.uncode asc';
		//print_r($query);exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$fortotal = '\' \' as totaluc,
		\' \' as abc,
		\' \' as klm,
		\' \' as xyz,
		sum(CAST ("Technicians" AS INTEGER)) as totalTechnicians,
		sum(CAST ("HF Incharge" AS INTEGER)) as totalMedicalTechnicians,
		sum(CAST ("Catchment Population" AS INTEGER)) as totalcatch,
		\' \' as totaltype';
		$innerrowName = "EPI Center";
		$queryTotal =' Select '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		//print_r($allDataTotal);exit;
		$subTitle ="EPI Center Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal,'NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']= exportIcons($post_data);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Health Facility Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////VPD Center Listing Start////////////////////////////////////////////////////////////
	public function vpd_centers_listing($year){
		$post_data=posted_Values();
		//$year = $post_data['year'];
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],"fac.");
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		if(!($post_data['distcode']>0)){
				redirect('setup_listing/summary_listing?listing=VPD_Centers&year='.$year);
				exit();
		}
			//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Health_Facility_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		if($post_data['tcode'] > 0){
			$wc[] = "fac.tcode = '".$post_data['tcode']."'";

		}
		if($post_data['uncode'] > 0){
			$wc[] = "fac.uncode = '".$post_data['uncode']."'";
		}

		$s="'Active'";
		$where = 'where fac.hf_type=\'e\' AND fac.is_ds_fac  = \'1\' '.((!empty($wc))? ' AND '.implode(" AND ",$wc):'');
		$query =' Select fac.fac_name as "VPD Center Name",
		fac.facode as " VPD Center Code ",
		fac.fatype as " VPD Center Type",
		tehsilname(fac.tcode) AS insiderow ,
		(select count(f.facode) from facilities f where f.hf_type=\'e\' AND f.is_ds_fac =\'1\' AND f.distcode = \''.$post_data['distcode'].'\' AND f.tcode = fac.tcode ) as total, 
		tehsilname(fac.tcode) as "Tehsil",
		unname(fac.uncode) as "Union Council", 
        initcap(fac.areatype) as "Area Type",
		CASE WHEN fac.fatype=\'Private\' then \'Private\' ELSE \'Public\' END as "Type",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_facode = fac.facode and post_status= '.$s.' and post_hr_sub_type_id=\'01\') as "Technicians",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_facode = fac.facode and post_status= '.$s.' and post_hr_sub_type_id=\'09\') as "HF Incharge"
		from facilities fac  '.$where.'  order by fac.tcode,fac.fac_name asc';
		//print_r($query);exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		//print_r($allData); exit;
		$fortotal = '\' \' as totaluc,
		\' \' as abc,
		\' \' as klm,
		\' \' as xyz,
		sum(CAST ("Technicians" AS INTEGER)) as totalTechnicians,
		sum(CAST ("HF Incharge" AS INTEGER)) as totalMedicalTechnicians,
		\' \' as totaltype';
		$innerrowName = "VPD Center";
	    $queryTotal =' Select '.$fortotal.'  FROM ('.$query.') as a'; 
		$resultTotal=$this->db->query($queryTotal);
	    $allDataTotal=$resultTotal->result_array();
		//print_r($allDataTotal);exit;
		$subTitle ="VPD Center Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal,'NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']= exportIcons($post_data);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Health Facility Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Union Council Listing Start////////////////////////////////////////////////////////////
	public function union_council_listing($year){
		$post_data=posted_Values();
     //echo $year;exit;
	//	$year = $post_data['year'];
		$wc = getWC_Array($post_data['procode'],NULL,$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		/*if($tcode >0){
			$wc[] = "tcode = '".$tcode."'";
		} */
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=union_Council&year='.$year);
				exit();
        }else{
			$wc[] = "unioncouncil.distcode = '".$post_data['distcode']."'";
		}
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=UC_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		if($tcode >0){
			$wc[] = "unioncouncil.tcode = '".$post_data['tcode']."'";

		}
		//main query to view report
		$s="'Active'";
		$query =' Select un_name as "Union Council Name",
		unioncouncil.uncode as "Union Council Code",
		tehsilname(unioncouncil.tcode) AS insiderow,
		(select count(u.unid) from unioncouncil u where u.tcode = unioncouncil.tcode) as total,
		(select count(f.facode) from facilities f where f.uncode = unioncouncil.uncode and f.hf_type=\'e\') as "EPI Center",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_uncode = unioncouncil.uncode and post_status= '.$s.' and post_hr_sub_type_id=\'01\') as "Technicians",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_uncode = unioncouncil.uncode and post_status= '.$s.' and post_hr_sub_type_id=\'09\') as "HF Incharge",
		coalesce(unioncouncil_population.population,\'0\') as "Total Population", getnewbornpop(unioncouncil.uncode::text,\'unioncouncil\'::text,'.$year.'::text) as "New Borns", getsurvivinginfantspop(unioncouncil.uncode::text,\'unioncouncil\'::text,'.$year.'::text) as "Surviving Infants", getplwpop(unioncouncil.uncode::text,\'unioncouncil\'::text,'.$year.'::text) as "P&LW",
		round((getsurvivinginfantspop(unioncouncil.uncode::text,\'unioncouncil\'::text,'.$year.'::text)*94.98)/100) as "12-23 M",
		getcbapop(unioncouncil.uncode::text,\'unioncouncil\'::text,'.$year.'::text) as "CBAs" FROM unioncouncil full join unioncouncil_population on unioncouncil.uncode=unioncouncil_population.uncode and unioncouncil_population.year=\''.$year.'\' '.((!empty($wc))? 'where '.implode(" AND ",$wc):'').'  order by unioncouncil.tcode, unioncouncil.uncode';
		//print_r($query);exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$fortotal = 'sum(CAST ("EPI Center" AS INTEGER)) as totalflcf,
		sum(CAST ("Technicians" AS INTEGER)) as totalTechnicians,
		sum(CAST ("HF Incharge" AS INTEGER)) as totalmedicalTechnicians,
		sum(CAST ("Total Population"AS INTEGER)) as population';
		$innerrowName = "Union Councils";
		//query to get overall total
		$queryTotal =' Select '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Union Council Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal,'NO');

		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Union Council Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////DataEntry_Operator_listingStart////////////////////////////////////////////////////////////
	public function DataEntry_Operator_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		//print_r($wc);exit();
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=DataEntry_Operator_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
			if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=DataEntry_Operator&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'deodb.'.$value;
		  //  print_r($value);
		});
		//exit();
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
	//	print_r($where1);
		$query = 'select deodb.deoname as "Data Entry Operator Name",
			deodb.deocode as "DataEntry Operator Code",
			deodb.nic as "CNIC",
			districtname(deodb.distcode) as "District",
			deodb.status as Status,
			\'District: \' || districtname(deodb.distcode)  as insiderow,
			(select count(DataEntry_operator.deocode) from deodb dataentry_operator '.str_replace("deodb.","dataentry_operator.",$where1).') as total   from deodb
			 ' . $where1 . ' ';
			// print_r($query);
		$result=$this->db->query($query);
		$allData=$result->result_array();
		//print_r($allData);exit();
		$innerrowName = "DataEntry Operator";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Data Entry Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////DataEntry_Operator_listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************//////////
	///////////////////////////StoreKeeper_listing Start/////////////////////////////////
		public function StoreKeeper_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=StoreKeeper_listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
        if($post_data['tcode'] >0){
			$wc[] = "tcode = '".$post_data['tcode']."'";
		}
		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=StoreKeeper&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'skdb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		//print($where1);exit;
		$query = 'select skdb.skname as "Store Keeper Name",
			skdb.skcode as "Store Keeeper Code",
			skdb.nic as "CNIC",

			districtname(skdb.distcode) as "District",
			skdb.status as Status,
			\'District: \' || districtname(skdb.distcode)  as insiderow,
			(select count(storekeeper.skcode) from skdb storekeeper '.str_replace("skdb.","storekeeper.",$where1).') as total   from skdb
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "storekeeper";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,

			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Store Keeeper Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////StoreKeeper_listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************//////////
	//////////////////////////////////Technician Listing Start////////////////////////////////////////////////////////////
	public function technician_listing($year){
		$post_data=posted_Values();
		//$year = $post_data['year'];
		//echo $year;exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		//print_r($wc);exit;
		//echo '<pre>';print_r($post_data);exit;

		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');*/
		if($post_data['tcode'] >0){
			$wc[] = "tcode = '".$post_data['tcode']."'";
		}
		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		if($post_data['uncode'] !=''){
			$wc[] = "uncode = '".$post_data['uncode']."'";
		}
		if(isset($_REQUEST['supervisorcode']) >0){
			$wc[] = "supervisorcode = '".$_REQUEST['supervisorcode']."'";
		}else{
			if($post_data['facode'] >0){
				$wc[] = "facode = '".$post_data['facode']."'";
			}
		}
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=technician&status='.$status.'&year='.$year);
				exit();
		}
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPI_Technician_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		//Excel file code ENDS*******************
		if($this->input->post('addedColumn')){
			//echo $filteredColumns = implode(",",$_REQUEST['addedColumn']);
		}
		array_walk($wc, function(&$value, $key){
			$value = 'techniciandb.'.$value;
		});
		//main query to view report
	   $where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'');
 // print_r($where);exit;
		 $query = 'select techniciandb.technicianname as "Technician Name", techniciandb.techniciancode as "Technician Code",
		techniciandb.employee_type as "Employee Type", tehsilname(techniciandb.tcode) as "Tehsil",
		unname(techniciandb.uncode) as "Union Council",
		facilityname(techniciandb.facode) as "EPI Center", initcap(techniciandb.areatype) as "Area Type",
		tech_pop(techniciandb.techniciancode) as "Catchment Population",
		getnewbornpop(techniciandb.techniciancode::text,\'technician\'::text,'.$year.'::text) as "New Borns", getsurvivinginfantspop(techniciandb.techniciancode::text,\'technician\'::text,'.$year.'::text) as "Surviving Infants", getplwpop(techniciandb.techniciancode::text,\'technician\'::text,'.$year.'::text) as "P&LW", getcbapop(techniciandb.techniciancode,\'technician\'::text,'.$year.'::text) as "CBAs",
		techniciandb.status,
	    \'District: \' || districtname(techniciandb.distcode) || \', EPI Center: \' || facilityname(techniciandb.facode) as insiderow,
		(select count(technician.techniciancode) from techniciandb technician '.str_replace("techniciandb.","technician.",$where).' AND technician.facode = techniciandb.facode ) as total
		from techniciandb  '.$where.'  order by techniciandb.techniciancode,techniciandb.tcode,techniciandb.facode';
//print_r($query);exit;
	   $result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Technicians";
		$fortotal = '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalt,
			\' \' as totaluc';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		//print_r($allDataTotal);exit;
		$subTitle ="Technician Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);

		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Technician Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Technician Council Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Medical Technician Listing Start////////////////////////////////////////////////////////////
	public function med_technician_listing(){
		$post_data=posted_Values();
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		//print($wc);exit;
		//echo '<pre>';print_r($post_data);exit;
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		$status		= isset($post_data['status'])?$post_data['status']:$this->input->post('status');
		/*$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');*/
		if($post_data['tcode'] >0){
			$wc[] = "tcode = '".$post_data['tcode']."'";
		}
		if($status!=''){
			$wc[] = "status = '".$status."'";
		}
		if($post_data['uncode'] !=''){
			$wc[] = "uncode = '".$post_data['uncode']."'";
		}
		if(isset($_REQUEST['supervisorcode']) >0){
			$wc[] = "supervisorcode = '".$_REQUEST['supervisorcode']."'";
		}else{
			if($post_data['facode'] >0){
				$wc[] = "facode = '".$post_data['facode']."'";
			}
		}
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=med_technician&status='.$status);
				exit();
		}
		//print_r($wc);exit;
		//Excel file code is here*******************
		if($this->input->post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Medical_Technician_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		if($this->input->post('addedColumn')){
			//echo $filteredColumns = implode(",",$_REQUEST['addedColumn']);
		}
		array_walk($wc, function(&$value, $key){
			$value = 'med_techniciandb.'.$value;
		});
		//main query to view report
	   $where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'');
	   //print($where);exit;
		 $query = 'select med_techniciandb.technicianname as "HF Incharge Name", med_techniciandb.techniciancode as "HF Incharge Code",
		med_techniciandb.employee_type as "Employee Type", tehsilname(med_techniciandb.tcode) as "Tehsil",
		unname(med_techniciandb.uncode) as "Union Council",
		facilityname(med_techniciandb.facode) as "Health Facility", initcap(med_techniciandb.areatype) as "Area Type",
		med_techniciandb.status,
	    \'District: \' || districtname(med_techniciandb.distcode) || \', Health Facility: \' || facilityname(med_techniciandb.facode) as insiderow,
		(select count(technician.techniciancode) from med_techniciandb technician '.str_replace("med_techniciandb.","technician.",$where).' AND technician.facode = med_techniciandb.facode ) as total
		from med_techniciandb '.$where.'   order by med_techniciandb.techniciancode,med_techniciandb.tcode,med_techniciandb.facode';
//print_r($query);exit;
	   $result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Technicians";
		$fortotal = '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalt,
			\' \' as totaluc';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="HF Incharge Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Technician Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Medical Technician Council Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Supervisor Listing Start////////////////////////////////////////////////////////////
	public function supervisor_listing(){
		$post_data=posted_Values();
	    //echo '<pre>';print_r($post_data);exit();
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['tcode'],$post_data['facode']);
		$sup_type=$this->input->get_post('supervisor_type')?$this->input->post('supervisor_type'):NULL;
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		// $status			= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		// $supervisor_type	= isset($_REQUEST['supervisor_type'])?$_REQUEST['supervisor_type']:$this->input->post('supervisor_type');
		// $facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		// $tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if($this ->input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=supervisor_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if($tcode > 0){
			$wc[] = "tcode = '".$tcode."'";
		}

		if($post_data['supervisor_type'] != '0' && $post_data['supervisor_type'] != ''){
			$wc[] = "supervisor_type = '".$post_data['supervisor_type']."'";
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		// if($facode >0){
		// 	$wc[] = "facode = '".$facode."'";
		// }
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=supervisor&status='.$status.'&sup_type='.$sup_type);
				exit();
		}
		unset($wc[0]);
		if($tcode >0){
			$wc[] = "tcode = '".$post_data['tcode']."'";
		}
		if($this->input->get_post('sup_type'))
		{
			//echo "danis";exit;
			$sup_type=$this->input->get_post('sup_type');
			$wc[] = "supervisor_type = '".$sup_type."'";
		}
		array_walk($wc, function(&$value, $key){
			$value = 'supervisordb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where = ((!empty($wc))? ' AND '.implode(" AND ",$wc):'');
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select supervisordb.supervisorname as "Supervisor Name", supervisor_type as "Supervisor Type" ,
			supervisordb.supervisorcode as "Supervisor Code" ,
			supervisordb.fathername as "Father Name",
			supervisordb.employee_type as "Employee Type",
			districtname(supervisordb.distcode) as "District",
			supervisordb.status
			from supervisordb '.$where1.' order by supervisordb.supervisorname asc';
		//echo $query;exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Supervisor Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Supervisor Council Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Computer Operator Listing Start////////////////////////////////////////////////////////////
	public function computer_operator_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Computer_Operator_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=Computer_Operator&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'codb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select codb.coname as "Computer Operator Name",
			codb.cocode as "Computer Operator Code",
			codb.nic as "CNIC",
			districtname(codb.distcode) as "District",
			codb.status as Status,
			\'District: \' || districtname(codb.distcode)  as insiderow,
			(select count(computer_operator.cocode) from codb computer_operator '.str_replace("codb.","computer_operator.",$where1).') as total   from codb
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Computer Operator";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Computer Operator Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}

		//////////////////////////////////Computer Operator Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Generator Operator Listing Start////////////////////////////////////////////////////////////
	public function generator_operator_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Generator_Operator_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=Generator_Operator&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'go_db.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select go_db.go_name as "Generator Operator Name",
			go_db.go_code as "Generator Operator Code",
			go_db.nic as "CNIC",
			districtname(go_db.distcode) as "District",
			go_db.status as Status,
			\'District: \' || districtname(go_db.distcode)  as insiderow,
			(select count(generator_operator.go_code) from go_db generator_operator '.str_replace("go_db.","generator_operator.",$where1).') as total   from go_db
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Generator Operator";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Generator Operator Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Generator Operator Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Cold Chain Operator Listing Start////////////////////////////////////////////////////////////
	public function cold_chain_operator_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Cold_Chain_Operator_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=Cold_Chain_Operator&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'cco_db.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select cco_db.cco_name as "Cold Chain Operator Name",
			cco_db.cco_code as "Cold Chain Operator Code",
			cco_db.nic as "CNIC",
			districtname(cco_db.distcode) as "District",
			cco_db.status as Status,
			\'District: \' || districtname(cco_db.distcode)  as insiderow,
			(select count(cold_chain_operator.cco_code) from cco_db cold_chain_operator '.str_replace("cco_db.","cold_chain_operator.",$where1).') as total   from cco_db
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Cold Chain Operator";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Cold Chain Operator Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Cold_Chain_Operator Operator Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Cold_Chain_Mechanic Listing start////////////////////////////////////////////////////////////
	public function cold_chain_mechanic_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if($tcode >0){
			$wc[] = "tcode = '".$tcode."'";
		}

		if($facode >0){
			$wc[] = "facode = '".$facode."'";
		}
		if($status!=''){
			$wc[] = "status = '".$status."'";
		}
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=Cold_Chain_Mechanic&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'cc_mechanic.'.$value;
		});
		//main query to view report
		$where1 = ((!empty($wc))? 'where '.implode(" AND ",$wc):'');
		//print_r($where);exit;
		$query = 'select cc_mechanic.ccm_name as "Cold Chain Mechanic Name",
			cc_mechanic.ccm_code as "Cold Chain Mechanic Code",
			cc_mechanic.nic as "CNIC",
			districtname(cc_mechanic.distcode) as "District",
			cc_mechanic.status as Status,
			\'District: \' || districtname(cc_mechanic.distcode)  as insiderow,
			(select count(cold_chain_operator.ccm_code) from cc_mechanic cold_chain_operator '.str_replace("cc_mechanic.","cold_chain_operator.",$where1).') as total   from cc_mechanic
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		//echo $this-> db ->last_query(); exit;
		$allData=$result->result_array();
		$innerrowName = "Cold Chain Mechanic";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalds,
			\' \' as totals';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Cold Chain Mechanic Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Cold Chain Technician Listing End////////////////////////////////////////////////////////////
	
	//////////////////////////////////District Surveillance Officer Listing Start////////////////////////////////////////////////////////////
	public function district_surveillance_officer_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		//$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		//$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=District_Surveillance_Operator_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=district_Surveillance_Officer&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'dsodb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select dsodb.dsoname as "District Surveillance Officer Name",
			dsodb.dsocode as "District Surveillance Officer Code" ,
			dsodb.telephone as "Landline Phone#", dsodb.phone as "Cell Phone#", dsodb.employee_type as "Employee Type",
			districtname(dsodb.distcode) as "District",
			dsodb.status as Status,
			\'District: \' || districtname(dsodb.distcode)  as insiderow,
			(select count(ds_officer.dsocode) from dsodb ds_officer '.str_replace("dsodb.","ds_officer.",$where1).') as total   from dsodb
			 ' . $where1 . ' ';
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "District Surveillance Officer";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="District Surveillance Officer Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="District Surveillance Officer";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////District surveillance Officer Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Cold Chain Technician Listing Start////////////////////////////////////////////////////////////
	public function cold_chain_technician_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Cold_Chain_Technician_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=Cold_Chain_Technician&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'cc_techniciandb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select cc_techniciandb.cc_technicianname as "Cold Chain Technician Name",
			cc_techniciandb.cc_techniciancode as "Cold Chain Technician Code",
			cc_techniciandb.nic as "CNIC",
			districtname(cc_techniciandb.distcode) as "District",
			cc_techniciandb.status as Status,
			\'District: \' || districtname(cc_techniciandb.distcode)  as insiderow,
			(select count(cold_chain_technician.cc_techniciancode) from cc_techniciandb cold_chain_technician '.str_replace("cc_techniciandb.","cold_chain_technician.",$where1).') as total   from cc_techniciandb
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Cold Chain Technician";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Cold Chain Technician Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Cold Chain Technician Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************/////////////////////
	//////////////////////////////////Cold Chain Generator Operator Listing Start////////////////////////////////////////////////////////////
public function cold_chain_generator_operator_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');
		$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if($tcode >0){
			$wc[] = "tcode = '".$tcode."'";
		}

		if($facode >0){
			$wc[] = "facode = '".$facode."'";
		}
		if($status!=''){
			$wc[] = "status = '".$status."'";
		}
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=cold_Chain_Generator_Operator&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'ccgdb.'.$value;
		});
		//main query to view report
		$where = ((!empty($wc))? 'where '.implode(" AND ",$wc):'');
		$query = 'select ccgdb.ccgname as "Cold Chain Generator Operator Name",
		ccgdb.ccgcode as "Cold Chain Generator Operator Code" , ccgdb.nic as "CNIC",
		districtname(ccgdb.distcode) as "District",
		ccgdb.status as Status,
		\'District: \' || districtname(ccgdb.distcode) || \', Health Facility: \' || facilityname(ccgdb.facode) as insiderow,
		(select count(ccg.ccgcode) from ccgdb ccg '.str_replace("ccgdb.","ccg.",$where).' AND ccg.facode = ccgdb.facode ) as total   from ccgdb
		 ' . $where . ' order by ccgdb.ccgcode,ccgdb.tcode,ccgdb.facode';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Cold Chain Generator Operator";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalds,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Cold Chain Generator Operator Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		return $data;
	}
	//////////////////////////////////Cold Chain Technician Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Cold Chain Driver Listing Start////////////////////////////////////////////////////////////
	public function cold_chain_driver_listing(){
		$post_data=posted_Values();
		//echo '<pre>';print_r($this->input->post());exit;
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode'],$post_data['tcode']);
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		/*$status		= isset($_REQUEST['status'])?$_REQUEST['status']:$this->input->post('status');
		$facode		= isset($_REQUEST['facode'])?$_REQUEST['facode']:$this->input->post('facode');*/
		//$tcode		= isset($_REQUEST['tcode'])?$_REQUEST['tcode']:$this->input->post('tcode');
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Driver_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}

		if($post_data['status'] !=''){
			$wc[] = "status = '".$post_data['status']."'";
		}
		/*
		if($tcode >0){
					$wc[] = "tcode = '".$tcode."'";
				}*/
		if(!($post_data['distcode'] > 0)){
				redirect('setup_listing/summary_listing?listing=cold_Chain_Driver&status='.$status);
				exit();
		}
		unset($wc[0]);
		array_walk($wc, function(&$value, $key){
			$value = 'driverdb.'.$value;
		});
		//main query to view report
		$s="'Active'";
		$where1 = ((!empty($wc))? ' where '.implode(" AND ",$wc):'');
		$query = 'select driverdb.drivername as "Driver Name",
			driverdb.drivercode as "Driver Code" ,
			driverdb.nic as "CNIC",
			districtname(driverdb.distcode) as "District",
			driverdb.status as Status,
			\'District: \' || districtname(driverdb.distcode)  as insiderow,
			(select count(drv.drivercode) from driverdb drv '.str_replace("driverdb.","drv.",$where1).') as total from driverdb
			 ' . $where1 . ' ';
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$innerrowName = "Driver";
		$fortotal =  '\' \' as totalfc,
			\' \' as totalcnic,
			\' \' as totalstatus';
		//query to get overall total
		$queryTotal =' Select Distinct '.$fortotal.'  FROM ('.$query.') as a';
		$resultTotal=$this->db->query($queryTotal);
		$allDataTotal=$resultTotal->result_array();
		$subTitle ="Driver Listing";
		//$data['subtitle']=$this->getReportHead($subTitle);
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,$innerrowName,$allDataTotal);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],$post_data['facode'],$year);
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");
		/*$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="Computer Operator";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],"",$post_data['facode'],"","",$year);
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		createTransactionLog("Listing", $subTitle." Viewed");*/
		return $data;
	}
	//////////////////////////////////Cold Chain Driver Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Summary Listing Start////////////////////////////////////////////////////////////
	public function summary_listing($type,$sup_type,$year,$statustype){
		//print_r($type);exit;
	//	print_r($year);exit;
	//echo "danish";exit;
		$post_data=posted_Values();
		$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['facode']);
		$status		= isset($_REQUEST['status'])?$_REQUEST['status']:'Active';
		$year		= isset($_REQUEST['year'])?$_REQUEST['year']:'';
		$UserLevel=$_SESSION['UserLevel'];
		//echo '<pre>'.'mnmnmnmnmnmn';print_r($_REQUEST);exit;
		//Excel file code is here*******************
		if(isset($_REQUEST['export_excel']))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=Summary_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		//Excel file code ENDS*******************
		//Workaround for Cloumn name difference in districts table. i.e procode is prvince.
		$neWc1 = $wc;
		$replacements = array(0 => "province");
		$neWc1[0] = str_replace("procode","province",$neWc1[0]);
		$whereCondition=" and supervisor_type=$sup_type";
		if(isset($_REQUEST['distcode'])){
			unset($neWc1[1]);
		}
		//print_r($neWc1);exit;
		//print_r($neWc1);exit;
		$status="Active";
		//$year = 2016;
		$curYear = date('Y');
		//print_r($curYear); exit;
		if($type=='supervisor')
		{
			if($sup_type=='EPI Coordinator'){
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'EPI Coordinator\') as "EPI Coordinator"
				FROM districts';
			}
			else if($sup_type=='Assistant Superintendent Vaccinator'){
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Assistant Superintendent Vaccinator\') as "ASV"
				FROM districts';
			}
			else if($sup_type=='District Superintendent Vaccinator'){
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'District Superintendent Vaccinator\') as "DSV"
				FROM districts';
			}
			else if($sup_type=='Field Superintendent Vaccinator'){
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Field Superintendent Vaccinator\') as "FSV"
				FROM districts';
			}
			else if($sup_type=='Tehsil Superintendent Vaccinator')
			{
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Tehsil Superintendent Vaccinator\') as "TSV"
				FROM districts';
			}
			else{
		$query =' Select district as "District ", districts.distcode as  "District Code",
		(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
		(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'EPI Coordinator\') as "EPI Coordinator",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'District Superintendent Vaccinator\') as "DSV",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Tehsil Superintendent Vaccinator\') as "TSV",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Assistant Superintendent Vaccinator\') as "ASV",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\' and supervisor_type=\'Field Superintendent Vaccinator\') as "FSV",
		(select count(supervisorcode) from supervisordb where supervisordb.distcode = districts.distcode and supervisordb.status=\''.$status.'\') as "Total Supervisor",
		(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
		(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
		FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
			}
		}
		else if ($type=='district_Surveillance_Officer'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(dsocode) from dsodb where dsodb.distcode = districts.distcode and dsodb.status=\''.$status.'\') as "District Surveillance Officer",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='Computer_Operator'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(cocode) from codb where codb.distcode = districts.distcode and codb.status=\''.$status.'\') as "Computer Operator",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			from districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='Generator_Operator'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(go_code) from go_db where go_db.distcode = districts.distcode and go_db.status=\''.$status.'\') as "Generator Operator",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='Cold_Chain_Operator'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(cco_code) from cco_db where cco_db.distcode = districts.distcode and cco_db.status=\''.$status.'\') as "Cold Chain Operator",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='Cold_Chain_Technician'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(cc_techniciancode) from cc_techniciandb where cc_techniciandb.distcode = districts.distcode and cc_techniciandb.status=\''.$status.'\') as "Cold Chain Technician",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='Cold_Chain_Mechanic'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(ccm_code) from cc_mechanic where cc_mechanic.distcode = districts.distcode and cc_mechanic.status=\''.$status.'\') as "Cold Chain Mechanic",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='DataEntry_Operator'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(deocode) from deodb where deodb.distcode = districts.distcode and deodb.status=\''.$status.'\') as "DataEntry Operator",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if ($type=='StoreKeeper'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(skcode) from skdb where skdb.distcode = districts.distcode and skdb.status=\''.$status.'\') as "StoreKeeper",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if($type=='med_technician'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(techniciancode) from med_techniciandb where med_techniciandb.distcode = districts.distcode and med_techniciandb.status=\''.$status.'\') as "HF Incharge Listing",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if($type=='technician'){



			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(techniciancode) from techniciandb where techniciandb.distcode = districts.distcode and techniciandb.status=\''.$status.'\') as "EPI Technician Listing",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
		    (select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$year.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		//and techniciandb.status=\''.$status.'\' at 3rd last row
	//	print_r($query);exit;
		}
		else if($type=='cold_Chain_Driver'){
			$query =' Select district as "District ", districts.distcode as  "District Code",
			(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
			(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
			(select count(drivercode) from driverdb where driverdb.distcode = districts.distcode and driverdb.status=\''.$status.'\') as "Drivers",
			(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
			(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
			FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if($type=='VPD_Centers'){
			$query =' Select districts.district as "District", districts.distcode as  "District Code",
		(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
		(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
		(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' and facilities.is_ds_fac = \'1\' ) as "VPD Centers",
		(select count(CASE WHEN fatype=\'Private\' then \'Private\' ELSE \'Public\' END) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' and facilities.is_ds_fac = \'1\' and facilities.fatype =\'Private\') as "Total Private Facility",
		(select count(CASE WHEN fatype=\'Private\' then \'Private\' ELSE \'Public\' END) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' and facilities.is_ds_fac = \'1\' and facilities.fatype !=\'Private\') as "Total Public Facility",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'01\') as "Technicians",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'09\') as "HF Incharge"
		FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		}
		else if($type=='hr')
		{   
			if($statustype =="Transferred" || $statustype=="Posted"){
				$wc = " pre_status = '" . $statustype. "'  AND pre_hr_sub_type_id = '" . $sup_type. "'";
				$type="pre";
			}else{ 
				$wc = "post_status = '" . $statustype. "'  AND post_hr_sub_type_id = '" . $sup_type. "'";
				$type="post";
			}
			if($statustype !=''){
				if($statustype =="Transferred" || $statustype=="Posted"){
					$all=" pre_status = '" . $statustype. "'";
				}else{
					$all=" post_status = '" . $statustype. "'";
				}
			}
			$title = $this->db->query("select title from hr_sub_types where type_id='$sup_type'")->row()->title;
			if($sup_type !=''){ 
				$query='Select district as "District ", distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(*) from (SELECT DISTINCT ON (code) code,* FROM hr_db_history ORDER BY code DESC, id DESC) subquery where '.$type.'_distcode = districts.distcode AND '.$wc.') as "'.$title.'"
				FROM districts'; 
			}
			else{
				$query ='Select district as "District ", districts.distcode as  "District Code",
				(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
				(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
				(select count(*) from (SELECT DISTINCT ON (code) code,* FROM hr_db_history ORDER BY code DESC, id DESC) subquery where '.$type.'_distcode = districts.distcode AND '.$all.') as "Total HR",
				(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Center",
				(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$curYear.'\') as population
				FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):''); 
				//print_r($query); exit();
			}
		}
		else {

			$query =' Select districts.district as "District", districts.distcode as  "District Code",
		(select count(tcode) from tehsil where tehsil.distcode = districts.distcode ) as "tehsils",
		(select count(uncode) from unioncouncil where distcode = districts.distcode ) as "UCs",
		(select count(facode) from facilities where facilities.distcode = districts.distcode and facilities.hf_type = \'e\' ) as "EPI Centers",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'10\') as "District Surveillance Officer",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'17\') as "Computer Operator",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'09\') as "HF Incharge",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'01\') as "Technician",
		(SELECT COUNT(*) from (SELECT DISTINCT ON (code)code, * FROM hr_db_history ORDER BY code DESC, id DESC) subquery where post_distcode = districts.distcode and post_status= \''.$status.'\' and  post_hr_sub_type_id=\'14\') as "Driver",
		(select coalesce(districts_population.population,\'0\') from districts_population where districts.distcode=districts_population.distcode and districts_population.year=\''.$year.'\') as population
	    FROM districts '.((!empty($neWc1))? 'where '.implode(" AND ",$neWc1):'');
		//$query.='';
		$query.='order by districts.district asc';


		}
		
		$result=$this->db->query($query);
		$allData=$result->result_array();
		//$str = $this->db->last_query();
		//print_r($str); exit;
		//$queryTotal = 'Select sum(LHWs) as totalLhws,sum(LHS) as totalLHS,sum(facilities) as totalfacilities,sum(CAST (population AS INTEGER)) as totalpopulation from ('.$query.') as a';
		//$resultTotal=$dbf->queryDB("psql",$queryTotal,"Total");
		$allDataTotal="";//$dbf->getAllDataArray("psql",$resultTotal);
		if($_REQUEST["listing"]=="supervisor")$titlee="Supervisor";
		else if($_REQUEST["listing"]=="technician")$titlee="Technician";
		else if($_REQUEST["listing"]=="med_technician")$titlee="HF Incharge";
		else if($_REQUEST["listing"]=="coperator")$titlee="Computer Operator";
		else if($_REQUEST["listing"]=="Ds officer")$titlee="District Surveillance Officer";
		else if($_REQUEST["listing"]=="facility")$titlee="EPI Center";
	//	$year		= isset($_REQUEST['year'])?$_REQUEST['year']:'';
		else $titlee=ucfirst($_REQUEST["listing"]);
		$subTitle =$titlee." Listing Summary <br /><small>(Click on district to see the details)</small>";
		$data['report_table']=getListingReportTable($allData,'',$allDataTotal,'NO');
		//print_r($_REQUEST);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode'],'',$year);
		$data['subtitle']=$subTitle;
		createTransactionLog("Listing", $titlee." Listing Summary Viewed");
		return $data;
	}
	//////////////////////////////////Summary Council Listing End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Get Report Head Start////////////////////////////////////////////////////////////
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
	//////////////////////////////////Get Report Head End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Top Table Info Start////////////////////////////////////////////////////////////
	function tableTopInfo($subTitle = "", $distcode = "", $facode = "", $year = "", $type = "", $ind_name = "", $month = "", $advRepTitle = "", $fmonthFrom = "", $fmonthTo = "", $ailmentName = "", $logisticName = "" , $lhwcode="") {
		// echo  $subTitle.'<br>'.$distcode.'<br>'.$facode.'<br>'.$year;exit();
		$html = '
					<div class="row">
	    	   	  	<div class="col-xs-12 text-center">
	    	   	  		<h3 style="text-decoration: underline;">'. $subTitle .'</h3>
	    	   	  	</div>
           	 	 </div>
		';
		$html .= '
				<div class="row">
    	   	   	 <div class="col-xs-1" style="margin-top: -13px; margin-left: 39%;">
    	   	   		<h4>Province:</h4>
    	   	   	 </div>
    	   	   	 <div class="col-xs-4" style="margin-top:-12px;margin-left: 15px;">
    	   	   		<h5>'.$this -> session -> provincename.'</h5>
    	   	   	 </div>
    	   	   </div>';
		if ($distcode == "")
			$distcode = $_SESSION['District'];
		if ($distcode > 0)
			$html .= '
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>District:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . DistrictName($distcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($tcode == "")
			$tcode = $_SESSION['Tehsil'];
		if ($tcode > 0)
			$html .= '
									<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Tehsil:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . TehsilName($tcode) . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($facode == "")
			$facode = $_SESSION['Facility'];
		if ($facode > 0)
			$html .= '
						<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Facility:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . FacilityName($facode)  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($year > 0)
			$html .= ' <div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Year:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $year  . '</h5>
    	   	   	  </div>
    	   	   </div>';
		if ($type != ""){
			$html .= '
									<div class="row">
    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Report Source:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: -98px;">
    	   	   		<h5>' . $type . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
		if ($logisticName != ""){
			$html .= '
									<div class="row">
    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
    	   	   		<h4>Logistic:</h4>
    	   	   	  </div>
    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
    	   	   		<h5>' . $logisticName . '</h5>
    	   	   	  </div>
    	   	   </div>';
    	  }
			if ($ailmentName != ""){
						$html .= '
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
			    	   	   		<h4>Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>' . $ailmentName . '</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			if ($lhwcode != ""){
						$html .= '
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
			    	   	   		<h4>Ailment:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>'.TechnicianName($techniciancode).'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
				if ($fmonthFrom != ""){
						$html .= '
												<div class="row">
			    	   	   	  <div class="col-xs-2" style="margin-top:-14px; margin-left: 39%;">
			    	   	   		<h4>Month From:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style="margin-top: -11px; margin-left: -99px;">
			    	   	   		<h5>'.$fmonthFrom.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
			  	if ($fmonthTo != ""){
						$html .= '
												<div class="row">
			    	   	   	  <div class="col-xs-1" style="margin-top:-14px; margin-left: 39%;">
			    	   	   		<h4>Month To:</h4>
			    	   	   	  </div>
			    	   	      <div class="col-xs-4" style=" margin-top:-11px; margin-left: 15px;">
			    	   	   		<h5>'.$fmonthTo.'</h5>
			    	   	   	  </div>
			    	   	   </div>';
			    	  }
		return $html;
	}
	public function hr_listing(){
		//print_r($_POST); exit();
		$post_data=posted_Values();
		//print_r($post_data); exit();
		if(!$post_data['distcode']>0)
			$post_data['distcode']= $this->session->District;
	    //echo '<pre>';print_r($post_data);exit();
		//$wc = getWC_Array($post_data['procode'],$post_data['distcode'],$post_data['tcode'],$post_data['facode']);
		$hrsuptype=$this->input->get_post('sub_type')?$this->input->post('sub_type'):NULL;
		$status=$this->input->get_post('status')?$this->input->post('status'):NULL;
		$UserLevel=$_SESSION['UserLevel'];
		$datArray['UserLevel']= $UserLevel;
		if($post_data['status'] !=''){
			if($post_data['status']=="Transferred" ||$post_data['status']=="Posted"){
				$pre_status = "pre_status = '".$post_data['status']."'";
			}else{
				$post_status = "post_status = '".$post_data['status']."'";
			}
			
		}
		if($hrsuptype != '0' && $hrsuptype != ''){
			if($post_data['status']=="Transferred" ||$post_data['status']=="Posted"){
				$hrtype = "AND pre_hr_sub_type_id = '".$hrsuptype."'";
			}else{
				$hrtype = "AND post_hr_sub_type_id = '".$hrsuptype."'";
			}
		}
		if($post_data['status']=="Transferred" || $post_data['status']=="Posted"){
			if (($_SESSION['UserLevel']=='3' || $_SESSION['UserLevel']=='4') && $_SESSION['utype']=='DEO')
				{
					$wc="";
					$type="pre";
					$wc = "pre_distcode = '" . $this-> session -> District . "' AND   " . $pre_status. "  ".$hrtype." ";
				}
			elseif(($_SESSION['UserLevel']=='2' || $_SESSION['UserLevel']=='3') && $_SESSION['utype']=='Manager')
			    {
					$type="pre";
					$wc = "pre_distcode = '" . $post_data['distcode'] . "' AND " . $pre_status. "  ".$hrtype." ";
				}
		}else{ 
			if (($_SESSION['UserLevel']=='3' || $_SESSION['UserLevel']=='4') && $_SESSION['utype']=='DEO')
			{
				$type="post";
				$wc = "post_distcode = '" . $this-> session -> District . "' AND  " . $post_status. "  ".$hrtype." ";
		
			}
			elseif(($_SESSION['UserLevel']=='2' || $_SESSION['UserLevel']=='3') && $_SESSION['utype']=='Manager') 
			{
				$type="post";
				$wc = "post_distcode = '" . $post_data['distcode'] . "' AND   " . $post_status. "  ".$hrtype." ";
			}
		}
		if($this ->input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=HR_Listing.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		if(!($post_data['distcode'] > 0)){ 
				redirect('setup_listing/summary_listing?listing=hr&status='.$status.'&sup_type='.$hrsuptype);
				exit();
		}
		if($this->input->get_post('sup_type') && $this->input->get_post('distcode') && $this->input->get_post('status'))
		{ 
			//echo "aa";exit; 
			$sup_type=$this->input->get_post('sup_type');
			$status=$this->input->get_post('status');
			$distcode=$this->input->get_post('distcode');
			if($status =="Transferred" || $status =="Posted"){
				$type="pre";
				$wc = "pre_distcode = '" . $distcode . "' AND pre_status = '" . $status. "'  AND pre_hr_sub_type_id = '" . $sup_type. "'";
			}else{
				$type="post";
				$wc = "post_distcode = '" . $distcode . "' AND post_status = '" . $status. "'  AND post_hr_sub_type_id = '" . $sup_type. "'";
			}
		}else if($this->input->get_post('distcode') && $this->input->get_post('status')){
			//echo'bb'; exit();
			$status=$this->input->get_post('status');
			$distcode=$this->input->get_post('distcode');
			if($status =="Transferred" || $status =="Posted"){
				$type="pre";
				$wc = "pre_distcode = '" . $distcode . "' AND pre_status = '" . $status. "' ";
			}else{
				$type="post";
				$wc = "post_distcode = '" . $distcode . "' AND post_status = '" . $status. "' ";
			}
		}
	    /* array_walk($wc, function(&$value, $key){
			$value = 'hr_db_history.'.$value;
		});  */
		/* $query = 'select hr_db_history.name as "HR Name", getsubtypename(post_hr_sub_type_id) as "HR Type",
			hr_db_history.code as "HR Code",
			hr_db_history.fathername as "Father Name",
			hr_db_history.employee_type as "Employee Type",
			districtname(hr_db_history.'.$type.'_distcode) as "District",
			hr_db_history.'.$type.'_status as "Status"
			from hr_db_history where '.$wc.' order by hr_db_history.name asc'; */
		$query='SELECT name as "HR Name",getsubtypename(post_hr_sub_type_id) as "HR Type",
		codee as "HR Code",fathername as "Father Name",employee_type as "Employee Type",
		districtname('.$type.'_distcode) as district,'.$type.'_status as "Status" 
		from (SELECT DISTINCT ON (code) code as codee,* FROM hr_db_history ORDER BY code DESC, id DESC) 
		subquery where '.$wc.' ';	
		//echo $query;exit;
		$result=$this->db->query($query);
		$allData=$result->result_array();
		$subTitle ="HR Listing";
		$data['subtitle']=$subTitle;
		$data['report_table']=getListingReportTable($allData,'','','NO');
		$data['TopInfo']=$this->tableTopInfo($subTitle,$post_data['distcode']);
		//print_r($data['TopInfo']);exit();
		$data['exportIcons']=exportIcons($_REQUEST);
		return $data;
	}
	//////////////////////////////////Top Table Info  End////////////////////////////////////////////////////////////
	///////////********************************************************************************///////////////////////
	//////////////////////////////////Setup Listing Model End////////////////////////////////////////////////////////////
}
?>