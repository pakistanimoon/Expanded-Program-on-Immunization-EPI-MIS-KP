<?php
class Indicator_reports_model extends CI_Model {
	//================ Constructor function Starts Here ==================//
	public function __construct() {
		parent::__construct();
		$this -> load -> helper('epi_reports_helper');
	}
	//====================== Constructor Function Ends Here ==========================//
	//--------------------------------------------------------------------------------//
	//======= Function to Create Filters for Sepecific Reports Starts Here ===========//
	function HFMVRF($data,$wc){
		$whereCondition = WC_replacement($wc);
		//print_r($whereCondition);exit;
		$newWc = $whereCondition[0];
		$newWc1 = $whereCondition[1];
		//print_r($newWc);exit;
		//print_r($newWc1);exit;
		if($this -> input -> post('distcode')){
			unset($newWc1[1]);
		}
		$yearr = "";
		$monthh = "";
		if(isset($data['year'])){
			$yearr = "_".$data['year'];
		}
		if(isset($data['month'])){
			$monthh = "-".$data['month'];
		}
		//print_r($data['year']);exit;
		//print_r($_POST);exit();
		$subTitle = "Indicator Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle).$yearr.$monthh.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$query = 'SELECT * from indcat';
		if($this -> input -> post('indicator'))
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$this -> input -> post('indicator'));
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}
	
		//print_r($arrayData);exit;
		$ind_name = $arrayData[0]["ind_name"];
		$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year'].$monthh:$data['year']):"";
		$level = ($this -> input -> post('distcode'))?"facility":"district";
		$level = ($this -> input -> post('facode'))?"facility":$level;
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);
		$report_table = "fac_mvrf_db";
		//echo $yearMonth;exit;
		$bothquery = explode('-::-',extract_indicator_query($arrayData,"$yearMonth", $level, $distcode, $report_table,$data));
		//print_r($bothquery);exit;
		$query = $bothquery[0];
		//print_r($bothquery[0]);exit;
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		$query = $bothquery[1];
		//print_r($query);exit;
		$result=$this->db->query($query);
		$data['allDataTotal']=$result->result_array();
		//print_r($data);exit;
		$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'','YES');
		//print_r($dataReturned['htmlData']);exit;
		$dataReturned['report_source_table'] = $report_table;
		$dataReturned['subtitle'] = $title = $subTitle;
		$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['year']	= (isset($data['year']))?$data['year']:date('Y');
		$dataReturned['month']	= (isset($data['month']))?$data['month']:"";
		return $dataReturned;
	} 
	
	//--------------------------------------------------------------------------------//
	//======= Function to Create EPI Vaccination Indicator Reports Starts Here ===========//
	function consumptionIndicator($data){
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);
		$vacc_ind = (isset($data['vacc_ind'])) ? $data['vacc_ind'] : FALSE;
		$resultData = array();
		if(isset($data['indicator']) && $vacc_ind)
		{
			$indid = $data['indicator'];
			$this -> db -> select("
				ind_name,
				numenator,
				denominator,
				result_text,
				mt,
				(select string_agg(formula_column||' as \"'||column_name||'\"',',') from indicator_column where indmain = $indid group by indmain) as allcolumns"
			);
			$this -> db -> where('indmain',$indid);
			$indicatorData = $this -> db -> get ('indicator_main') -> row();
			$name = $indicatorData->ind_name;
			$numenator = $indicatorData->numenator;
			$denominator = $indicatorData->denominator;
			$mt = $indicatorData->mt;
			$result_text = $indicatorData->result_text;
			if(is_array($vacc_ind) && count($vacc_ind)>1){
				$allcolumns = '';
				$result_text = 'value';
			}else{
				$allcolumns = $indicatorData->allcolumns;
			}
			//check if district login or district selected then show facility level
			$usercolumns = "distcode as code,districtname(distcode) as name";
			$group = "distcode";
			$moonwc = array();
			if($distcode){
				$usercolumns = "facode as code,facilityname(facode) as name";
				$group = "facode";
				$moonwc["distcode"] = $distcode;
			}
			/////////Code by usama for Review dashbord map
			if(isset($data['code'])){
				$usercolumns = "distcode as code,districtname(distcode) as name";
				$group = "distcode";
				$moonwc["distcode"] = $data['code'];
			}
			if(isset($data['map']) && $data['map']=='map'){
			$vaccind=$vacc_ind[0];
			if(isset($data['code']) && $data['code'] > 1){
				$usercolumns = "uncode as uccode,unname(uncode) as ucname";
				$group = "uncode";
				$query="select uncode as code,unname(uncode) as name,highchart_coordinates as path, (case when (a.\"$result_text\" > 0) then a.\"$result_text\" else 0 end) as \"$result_text\" from unioncouncil left join (
					SELECT $usercolumns,item_id,$allcolumns,
					       round(($numenator::numeric/NULLIF($denominator::numeric,0))*$mt,1) as \"$result_text\"
						FROM epi_consumption_detail JOIN epi_consumption_master 
							ON epi_consumption_master.pk_id = epi_consumption_detail.main_id 
						WHERE item_id IN('$vaccind') AND 
							fmonth BETWEEN '$data[monthfrom]' AND '$data[monthto]' AND distcode='$data[code]' 
						GROUP BY $group, item_id ORDER BY $group, item_id) as a 
							on unioncouncil.uncode=a.uccode where distcode='$data[code]' order by distcode";
			
				}else{
				$query="select distcode,distcode as code,districtname(distcode) as name,(case when (a.\"$result_text\" > 0) then a.\"$result_text\" else 0 end) as \"$result_text\" from districts left join (
					SELECT $usercolumns,item_id,$allcolumns,
					       round(($numenator::numeric/NULLIF($denominator::numeric,0))*$mt,1) as \"$result_text\"
						FROM epi_consumption_detail JOIN epi_consumption_master 
							ON epi_consumption_master.pk_id = epi_consumption_detail.main_id 
						WHERE item_id IN('$vaccind') AND 
							fmonth BETWEEN '$data[monthfrom]' AND '$data[monthto]' 
						GROUP BY $group, item_id ORDER BY $group, item_id) as a 
							on districts.distcode=a.code order by distcode";
			}
			$result=$this->db->query($query);
			$resultData=$result->result_array();
			//echo $this->db->last_query();exit;
			return $resultData;exit;
			}else{
			////////END/////
				$this -> db -> select($usercolumns.',item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"');
				$this -> db -> from("epi_consumption_master");
				$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
				$this -> db -> where($moonwc);
				$this -> db -> where_in("item_id",$vacc_ind);
				where_between('fmonth', "'".$data["monthfrom"]."'", "'".$data["monthto"]."'");  
				$this -> db -> group_by($group.",item_id");
				$this -> db -> order_by($group.",item_id");
				$resultData = $this -> db -> get () -> result_array();
				/* Total Query */
				$this -> db -> select('procode as code,provincename(procode) as name,item_id,'.$allcolumns.',round(('.$numenator.'::numeric/NULLIF('.$denominator.'::numeric,0))*'.$mt.',1) as "'.$result_text.'"');
				$this -> db -> from("epi_consumption_master");
				$this -> db -> join("epi_consumption_detail","epi_consumption_detail.main_id = epi_consumption_master.pk_id");
				//$this -> db -> where($moonwc);
				$this -> db -> where_in("item_id",$vacc_ind);
				where_between('fmonth', "'".$data["monthfrom"]."'", "'".$data["monthto"]."'");  
				$this -> db -> group_by("procode,item_id");
				$this -> db -> order_by("procode,item_id");
				$resultTotalData = $this -> db -> get () -> result_array();
			}
		}
		$resultData = array_merge($resultData,$resultTotalData);
		//for($i=1;$i<101;++$i){echo(($a=($i%3?"":'Fizz').($i%5?"":'Buzz'))?$a:$i).PHP_EOL;}
		//print_r($this->db->last_query());exit;
		//$ind_name = $arrayData[0]["ind_name"];
		//$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		//$level = (isset($data['distcode']))?"facility":"district";
		//$level = (isset($data['facode']))?"facility":$level;
		//$report_table = "form_b_cr";
		//echo '<pre>';print_r($arrayData);exit;
		//$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		//unset($data['monthfrom']);
		//unset($data['monthto']);
		//$bothquery = explode('-::-',extract_indicator_query($arrayData,$whereFmonth, $level, $distcode, $report_table,$data));
		//$query = $bothquery[0];		
		//$result=$this->db->query($query);
		//$data['allData']=$resultData;//$result->result_array();
		//print_r($query);exit;
		//$query = $bothquery[1];
		//print_r($query);exit;
		//$dataReturned['subtitle'] = $title = "Indicator Report";;
		/* if( ! ($this->input->post('vacc_ind') == 'all_vacc'))
		{
			$result=$this->db->query($query);
			$data['allDataTotal']=$result->result_array();
			$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'','YES');
			$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		}
		else
		{
			$data['waste_rate'] = $bothquery[2];
			$result=$this->db->query($query);
			$data['allDataTotal']=$result->result_array();
			//echo "<pre>";print_r($data['allDataTotal']);exit;

			$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'','YES');
			$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		} */
		//////$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',NULL/* $data['allDataTotal'] */,'','YES');
		
		//$dataReturned['year']	= (isset($data['year']))?$data['year']:date('Y');
		//$dataReturned['month']	= (isset($data['month']))?$data['month']:"";
		//$dataReturned['data'] = $data_to_return;
		return $resultData;//$dataReturned;
	}
	//backup function, must be removed if above start working fine.	
	function Vaccine($data,$wc){
		$data_to_return = $data;
		$whereCondition = WC_replacement($wc);
		$newWc = $whereCondition[0];
		$newWc1 = $whereCondition[1];
		if(isset($data['distcode'])){
			unset($newWc1[1]);
		}
		$subTitle = "Indicator Report";
		if($this -> input -> post('export_excel'))
		{
			//if request is from excel
			header("Content-type: application/octet-stream");
			header("Content-Disposition: attachment; filename=EPI_Vaccine_Indicator_Report.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$query = 'SELECT * from indcat';
		if(isset($data['indicator']) /*$this -> input -> post('indicator')*/)
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$data['indicator']);
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}
		//print_r($arrayData);exit;
		$ind_name = $arrayData[0]["ind_name"];
		//$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		$level = (isset($data['distcode']))?"facility":"district";
		$level = (isset($data['facode']))?"facility":$level;
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);
		$report_table = "form_b_cr";
		//echo '<pre>';print_r($arrayData);exit;
		$whereFmonth = " fmonth BETWEEN '" . $data['monthfrom'] . "' AND '" . $data['monthto'] . "'";
		unset($data['monthfrom']);
		unset($data['monthto']);
		$bothquery = explode('-::-',extract_indicator_query($arrayData,$whereFmonth, $level, $distcode, $report_table,$data));
		$query = $bothquery[0];		
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		//print_r($query);exit;
		$query = $bothquery[1];
		//print_r($query);exit;
		$dataReturned['subtitle'] = $title = $subTitle;
		if( ! ($this->input->post('vacc_ind') == 'all_vacc'))
		{
			$result=$this->db->query($query);
			$data['allDataTotal']=$result->result_array();
			$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'','YES');
			$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		}
		else
		{
			$data['waste_rate'] = $bothquery[2];
			$result=$this->db->query($query);
			$data['allDataTotal']=$result->result_array();
			//echo "<pre>";print_r($data['allDataTotal']);exit;

			$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'','YES');
			$dataReturned['TopInfo'] = reportsTopInfo($title, $data);
		}
		$dataReturned['report_source_table'] = $report_table;

		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['year']	= (isset($data['year']))?$data['year']:date('Y');
		$dataReturned['month']	= (isset($data['month']))?$data['month']:"";
		$dataReturned['data'] = $data_to_return;
		return $dataReturned;
	}  
	//--------------------------------------------------------------------------------//
	//======= Function to Create Disease Surveillance Indicator report Starts Here ===========//
	function Disease($data,$wc){
		//print_r($data);exit();		
		$returned_data = $data;
		$whereCondition = WC_replacement($wc);
		$newWc = $whereCondition[0];
		$newWc1 = $whereCondition[1];
		if($this -> input -> post('distcode')){
			unset($newWc1[1]);
		}
		$subTitle = "Indicator Report";
		unset($wc['_ga']);
		unset($wc['_gat']);
		unset($wc['_ga']);
		unset($wc['_gid']);
		unset($wc['ci_session']);
		unset($wc['export_excel']);
		unset($data['_ga']);		
		unset($data['_gat']);
		unset($data['_ga']); 
		unset($data['_gid']);
		unset($data['ci_session']);
		unset($data['export_excel']);
		//print_r($_POST);exit();	 	 
		
		//$query = 'SELECT * from indcat';
		//echo $data['indicator'];exit();
		if($data['indicator'])
		{
			$this -> db -> select('*');
			$this -> db -> where('indid',$data['indicator']);
			$arrayData = $this -> db -> get ('indcat') -> result_array();
		}
		$ind_name = $arrayData[0]["ind_name"];
		$yearMonth = (isset($data['year']))?(isset($data['month'])?$data['year']."-".$data['month']:$data['year']):"";
		// $level = (isset($data['distcode']))?"facility":"district";
		// $level = (isset($data['facode']))?"facility":$level;
		$level = (isset($data['distcode']))?"unioncouncil":"district";
		$level = (isset($data['unioncouncil']))?"unioncouncil":$level;
		$distcode = (isset($data['distcode']))?$data['distcode']:(($this -> session -> District)?$this -> session -> District:NULL);

		if($data['indicator']==31 OR ($data['indicator'] >= 35 AND $data['indicator'] <= 40)){
			$report_table = "case_investigation_db";
			if($this -> session -> District > 0 || $this->input->post("distcode") != 0 || $this -> uri -> segment(3) != ''){
				$arrayData[0]["denominator"] = "Total # of HF in the union council";
			}			
		}
		if($data['indicator']==32){
			$report_table = "aefi_rep";
			if($this -> session -> District > 0 || $this->input->post("distcode") != 0 || $this -> uri -> segment(3) != ''){
				$arrayData[0]["denominator"] = "Total # of HF in the union council";
			}
		}
		if($data['indicator']==33){
			$report_table = "nnt_investigation_form";
			if($this -> session -> District > 0 || $this->input->post("distcode") != 0 || $this -> uri -> segment(3) != ''){
				$arrayData[0]["denominator"] = "Total # of HF in the union council";
			}
		}
		if($data['indicator']==34){
			$report_table = "afp_case_investigation";
			if($this -> session -> District > 0 || $this->input->post("distcode") != 0 || $this -> uri -> segment(3) != ''){
				$arrayData[0]["denominator"] = "Total # of HF in the union council";
			}
		}
		//$report_table = "aefi_rep";
		
		$bothquery = explode('-::-',extract_indicator_query($arrayData,"$yearMonth", $level, $distcode, $report_table,$data));
		if($data['indicator'] >= 31 || $data['indicator'] <= 40){
			$bothquery = str_replace('fmonth = ','datefrom::text LIKE ',$bothquery);
			$bothquery = str_replace('fmonth like ','datefrom::text LIKE ',$bothquery);
		}
		else{
			$bothquery = str_replace('fmonth = ','submitted_date::text LIKE ',$bothquery);
			$bothquery = str_replace('fmonth like ','submitted_date::text LIKE ',$bothquery);
		}
		$query = $bothquery[0]; 
		//print_r($query);exit();
		//echo $query = str_replace('submitted_date =','submitted_date::text LIKE',$query);
		$result=$this->db->query($query);
		$data['allData']=$result->result_array();
		//print_r($query);exit;
		$query = $bothquery[1];
		$result=$this->db->query($query);
		$data['allDataTotal']=$result->result_array();
		$dataReturned['htmlData'] = getListingReportTable($data['allData'],'',$data['allDataTotal'],'No','Yes');
		//print_r($data['htmlData']);exit;
		$dataReturned['report_source_table'] = $report_table;
		$dataReturned['subtitle'] = $title = $subTitle;
		
		//print_r($_POST);exit();
		if(isset($data['month']) && $data['month'] > 0){
			$y = $data['year'];
			$m = $data['month'];
			$fm = $y."-".$m;
		}
		else{
			$y = $data['year'];
			$fm = $y;
		}
		if ($this -> input -> post('export_excel')) {
			//if request is from excel
			header("Content-type: application/octet-stream");
			//header("Content-Disposition: attachment; filename=".str_replace(" ","_",$subTitle)."_".($data['year'])?$data['year']:""."-".($data['month'])?$data['month']:"".".xls");
			header("Content-Disposition: attachment; filename=Indicator_Report_".$fm.".xls");
			header("Pragma: no-cache");
			header("Expires: 0");
			//Excel Ending here
		}
		$data['suveillance_indicator'] = $data['indicator'];
		$topinfoData = $data;
		unset($topinfoData['indicator']);
		$dataReturned['TopInfo'] = reportsTopInfo($title, $topinfoData);
		$dataReturned['exportIcons'] = exportIcons($_REQUEST);
		$dataReturned['year']	= (isset($data['year']))?$data['year']:date('Y');
		$dataReturned['month']	= (isset($data['month']))?$data['month']:"";
		$dataReturned['data']	= $returned_data;
		return $dataReturned;
	}  
	
	public function idsrsReportFilters(){
		$wc = getWC();
		$query="SELECT distinct fmonth from epidmr where $wc order by fmonth";
		$resultYM=$this -> db -> query($query);
		$data['resultYM'] = $resultYM -> result_array();
		//Workaround for Column name difference in districts table. i.e procode is prvince.
		$neWc = str_replace("procode", "province", $wc);
		$query="SELECT distcode, district from districts where $neWc order by distcode";
		$resultDist=$this -> db -> query ($query);
		$data['resultDist'] = $resultDist -> result_array();
		
		$query="SELECT facode, fac_name from facilities where $wc order by facode";
		$resultDist=$this -> db -> query ($query);
		$data['resultFac'] = $resultDist -> result_array();
		
		$year= date('Y');
		$query="SELECT DISTINCT year from epi_weeks where year <= '$year' order by year asc";
		$resultYear=$this -> db -> query ($query);
		$data['year'] = $resultYear -> result_array();
		
		$query="SELECT DISTINCT epi_week_numb from epi_weeks order by epi_week_numb asc";
		$resultWeek=$this -> db -> query ($query);
		$data['epi_week_numb'] = $resultWeek -> result_array();
	
		
		return $data;
	}
	public function Priority_diseases($data){
		
		$wc =$data;
//print_r($data); exit;
		$newc='';
		unset($_REQUEST['__atuvc']);
		unset($wc['__atuvc']);
		unset($data['__atuvc']);
		unset($data['ci_session']);
		unset($_REQUEST['ci_session']);
		unset($wc['ci_session']);
		unset($data['export_excel']);
		unset($_REQUEST['export_excel']);
		unset($wc['export_excel']);
		unset($wc['indicator_type']);
		
		
		
		if(!isset($data['distcode']) && isset($data['id']) && isset($data['year'])){
			unset($wc['from_week']);
			unset($wc['to_week']);
			unset($wc['id']);
			if(isset($data['from_week']) && isset($data['to_week'])){
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$id = $data['id'];
			$query = "SELECT * from idsrs_cases_types where id='$id' ";
			$result = $this->db->query($query);
			$arr = $result->row();
			
			$query = "SELECT distcode from districts where province='".$_SESSION["Province"]."'";
			$result = $this->db->query($query);
			$dist = $result->result_array();
			//print_r($dist);exit;
		
			foreach($dist as $row){
				$distcode = $row['distcode'];$id = $row['distcode'];$deaths = $arr->deaths;$cases = $arr->cases;
				$wc['distcode']=$distcode;
				$query = "'".$id."' as id,'".districtname($distcode)."' as \"Districts\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$distlist[]= $this-> db -> get("zero_report")->row_array();
				//echo $this-> db-> last_query();
			}
			if(isset($distlist))
			{
				usort($distlist,function ($a,$b) {
				return $b["Cases"]-$a["Cases"];
			});
			}else{
				$distlist = array();
			}
			$case_name = $arr->type_case_name;
			$data['distlist'] = $distlist;
			$data['getListingTable']=getListingReportTable($data['distlist'],'',0);
			$subTitle ="Diseases with High Rate of Morbidity";
			$data['subtitle']=$subTitle; 
			$data['case_name']=$case_name; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			return $data;
			
			
			
		}else if(isset($data['id']) && isset($data['distcode'])){
			unset($wc['from_week']);
			unset($wc['to_week']);
			unset($wc['id']);
			if(isset($data['from_week']) && isset($data['to_week'])){
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$id = $data['id'];
			$query = "SELECT * from idsrs_cases_types where id='$id' ";
			$result = $this->db->query($query);
			$arr = $result->row();
			
			$distcode = $data['distcode'];
		   $query = "SELECT facode from facilities where distcode='$distcode' and hf_type='e' and is_ds_fac='1'";
			$result = $this->db->query($query);
			$fac = $result->result_array();
			//print_r($fac);exit;
		
			foreach($fac as $row){
				$facode = $row['facode'];$deaths = $arr->deaths;$cases = $arr->cases;
				$wc['facode']=$facode;
				$query = "'".facilityname($facode)."' as \"Health Facilities\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$newres[]= $this-> db -> get("zero_report")->row_array();
				
			}
			if(isset($newres))
			{
				usort($newres,function ($a,$b) {
				return $b["Cases"]-$a["Cases"];
				});
			}else{
				$newres = array();
			}
			$case_name = $arr->type_case_name;
			$data['newres'] = $newres;
			$data['getListingTable']=getListingReportTable($data['newres'],'',0);
			$subTitle ="Diseases with High Rate of Morbidity";
			$data['subtitle']=$subTitle; 
			$data['case_name']=$case_name; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			return $data;
			
			
		}else{
		
			unset($wc['from_week']);
			unset($wc['to_week']);
			if(isset($data['from_week']) && isset($data['to_week'])){
			$wc['datefrom'] = $fromdate = date("Y-m-d",strtotime($data['datefrom']));
			$wc['dateto'] = $dateto = date("Y-m-d",strtotime($data['toweek']));
				
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$wc = "fweek >= '$from' and fweek <= '$to' ";								 
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$query = 'SELECT * from idsrs_cases_types ';
			$result = $this->db->query($query);
			$arr = $result->result_array();
			
			foreach($arr as $row){
				$cases = $row['cases'];$deaths = $row['deaths'];$disease = $row['type_case_name'] ;$id = $row['id'];
				$query = "'".$id."' as id,'".$disease."' as \"Disease\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$newresult[]= $this-> db -> get("zero_report")->row_array();
				//echo $this->db-> last_query(); 
			}
			if(isset($newresult))
			{
				usort($newresult,function ($a,$b) {
				  return $b["Cases"]-$a["Cases"];
				});
			}else{
				$newresult = array();
			}
			if( $this ->input -> post('export_excel'))
			{
				
				//if request is from excel
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=Priority-Diseases.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				//Excel Ending here
			}
			$data['newresult'] = $newresult;
			
			$data['getListingTable']=getListingReportTable($data['newresult'],'',0);
			$subTitle ="Diseases with High Rate of Morbidity";
			$data['subtitle']=$subTitle; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			return $data;
		}
	}
	
	/////////////////////////////
	public function highest_morbidity($data){
		$wc =$data;
		$newc='';
		unset($_REQUEST['__atuvc']);
		unset($wc['__atuvc']);
		unset($data['__atuvc']);
		unset($data['ci_session']);
		unset($_REQUEST['ci_session']);
		unset($wc['ci_session']);
		unset($data['export_excel']);
		unset($_REQUEST['export_excel']);
		unset($wc['export_excel']);
		unset($wc['indicator_type']);
		
		
		
		if(!isset($data['distcode']) && isset($data['id']) && isset($data['year'])){
			unset($wc['from_week']);
			unset($wc['to_week']);
			unset($wc['id']);
			if(isset($data['from_week']) && isset($data['to_week'])){
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$id = $data['id'];
			$query = "SELECT * from idsrs_cases_types where id='$id' ";
			$result = $this->db->query($query);
			$arr = $result->row();
			
			$query = "SELECT distcode from districts where province='".$_SESSION["Province"]."'";
			$result = $this->db->query($query);
			$dist = $result->result_array();
			//print_r($dist);exit;
		
			foreach($dist as $row){
				$distcode = $row['distcode'];$id = $row['distcode'];$deaths = $arr->deaths;$cases = $arr->cases;
				$wc['distcode']=$distcode;
				$query = "'".$id."' as id,'".districtname($distcode)."' as \"Districts\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$distlist[]= $this-> db -> get("zero_report")->row_array();
				
			}
			if(isset($distlist))
			{
				usort($distlist,function ($a,$b) {
				return $b["Deaths"]-$a["Deaths"];
			});
			}else{
				$distlist = array();
			}
			
			$case_name = $arr->type_case_name;
			$data['distlist'] = $distlist;
			$data['getListingTable']=getListingReportTable($data['distlist'],'',0);
			$subTitle ="Diseases with High Rate of Mortality";
			$data['subtitle']=$subTitle; 
			$data['case_name']=$case_name; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			return $data;
			
			
			
		}else if(isset($data['id']) && isset($data['distcode'])){
			unset($wc['from_week']);
			unset($wc['to_week']);
			unset($wc['id']);
			if(isset($data['from_week']) && isset($data['to_week'])){
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$id = $data['id'];
			$query = "SELECT * from idsrs_cases_types where id='$id' ";
			$result = $this->db->query($query);
			$arr = $result->row();
			
			$distcode = $data['distcode'];
			$query = "SELECT facode from facilities where distcode='$distcode' and hf_type='e' and is_ds_fac='1'";
			$result = $this->db->query($query);
			$fac = $result->result_array();
			//print_r($fac);exit;
		
			foreach($fac as $row){
				$facode = $row['facode'];$deaths = $arr->deaths;$cases = $arr->cases;
				$wc['facode']=$facode;
				$query = "'".facilityname($facode)."' as \"Health Facilities\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$newres[]= $this-> db -> get("zero_report")->row_array();
				
			}
			if(isset($newres))
			{
			usort($newres,function ($a,$b) {
				return $b["Deaths"]-$a["Deaths"];
			});
			}else{
				$newres = array();
			}
			$case_name = $arr->type_case_name;
			$data['newres'] = $newres;
			$data['getListingTable']=getListingReportTable($data['newres'],'',0);
			$subTitle ="Diseases with High Rate of Mortality";
			$data['subtitle']=$subTitle; 
			$data['case_name']=$case_name; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			return $data;
			
			
		}else{
		
			unset($wc['from_week']);
			unset($wc['to_week']);
			if(isset($data['from_week']) && isset($data['to_week'])){
				$year = $data['year'];
				$from = $year."-".sprintf("%02d",$data['from_week']);
				$to = $year."-".sprintf("%02d",$data['to_week']);
				$newc = "fweek >= '$from' and fweek <= '$to' ";
			} 
			$query = 'SELECT * from idsrs_cases_types ';
			$result = $this->db->query($query);
			$arr = $result->result_array();
			
			foreach($arr as $row){
				$cases = $row['cases'];$deaths = $row['deaths'];$disease = $row['type_case_name'] ;$id = $row['id'];
				$query = "'".$id."' as id,'".$disease."' as \"Disease\", sum($cases) as \"Cases\", sum($deaths) as \"Deaths\" ";
				$this -> db -> select ($query);
				$this -> db -> where ($wc);
				if($newc!=''){
					$this -> db -> where ($newc);
				}
				$newresult[]= $this-> db -> get("zero_report")->row_array();
				
			}
			if(isset($newresult))
			{
			usort($newresult,function ($a,$b) {
				return $b["Deaths"]-$a["Deaths"];
			});
			}
			else
			{
				$newresult = array();
			}
			if( $this ->input -> post('export_excel'))
			{
				
				//if request is from excel
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=Priority-Diseases.xls");
				header("Pragma: no-cache");
				header("Expires: 0");
				//Excel Ending here
			}
			$data['newresult'] = $newresult;
			$data['getListingTable']=getListingReportTable($data['newresult'],'',0);
			$subTitle ="Diseases with High Rate of Mortality";
			$data['subtitle']=$subTitle; 
			$data['TopInfo'] = reportsTopInfo($subTitle, $data);
			$data['exportIcons']=exportIcons($_REQUEST);
			//print_r($data['getListingTable']);exit;
			//echo $query; exit;
			return $data;
		}
		
	}
	
}
?>