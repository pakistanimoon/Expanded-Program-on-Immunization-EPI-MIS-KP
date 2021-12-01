<?php
class DB_configuration_quries extends CI_Controller {
	
	public function __construct() {
		parent::__construct(); 
		$this -> load -> model('Common_model');
	}
	
	public function compliance_count(){
		$tablename = $this -> input -> get('tablename');
		$dateColumn = ($tablename == 'form_b_cr')?'date_submitted':(($tablename == 'epi_consumption_master')?'created_date':'submitted_date');
		$compliancetable = $this -> input -> get('compliancetable');
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			// Years loop
			foreach(array('2020') as $yearkey => $year){
				// Months loop
				for($i=1;$i<=12;$i++){
					$month = sprintf('%02d',$i);
					$fmonth = $year . '-' . $month;
					// Total submitted reports
					$this -> db -> select('count(facode) as sub');
					$this -> db -> where(array('fmonth' => $fmonth,'distcode' => $distcode,"getfstatus_vacc('{$fmonth}',facode)" => 'F'));
					$submittedReports = $this -> db -> get($tablename) -> row();
					$submittedReports = $submittedReports -> sub;
					// Check if record already exist in compliance table for year and district
					$rowexist = $this -> db -> query("select exists(select * from {$compliancetable} where year='{$year}' and distcode='{$distcode}') as rowexist") -> row();
					// Total functional due reports
					$dueReports = $this -> db -> query("select get_monthly_fstatus_vacc('{$fmonth}','{$distcode}') as due") -> row();
					$dueReports = ($dueReports -> due > 0)?$dueReports -> due:0;
					// Total timely submitted reports
					$timelySubmitted = $this -> db -> query("select count(*) as tsub from {$tablename} where fmonth = '{$fmonth}' and distcode = '{$distcode}' and  getfstatus_vacc('{$fmonth}',facode) = 'F'  and extract(day from {$dateColumn}) <= 10 and extract(Month from {$dateColumn} - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer ") -> row();
					$timelySubmitted = (isset($timelySubmitted -> tsub))?$timelySubmitted -> tsub:0;
					// if row exists then update else insert record
					if($rowexist -> rowexist == 't' || $rowexist -> rowexist == 'TRUE' || $rowexist -> rowexist == 'true' || $rowexist -> rowexist == TRUE){
						$this -> db -> query("UPDATE {$compliancetable} set duem{$i} = {$dueReports}, subm{$i} = {$submittedReports}, tsubm{$i} = {$timelySubmitted} where year = '{$year}' and distcode = '{$distcode}' ");
					}else{
						$this -> db -> query("INSERT INTO {$compliancetable} (year, duem{$i}, subm{$i}, tsubm{$i}, distcode) VALUES ('{$year}', {$dueReports}, {$submittedReports}, {$timelySubmitted}, '{$distcode}') ");
					}
					echo $this -> db -> last_query();
					echo '<hr>';
				}
			}
		}
	}
	
	public function sendAllDistrictsAggregatedData(){
		$tableName = $this -> uri -> segment(3);
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			// Years loop
			foreach(array('2020') as $yearkey => $year){
				// Months loop
				$curr_year=date("Y");
				$month=date("m",strtotime("-1 month"));
				$j=12;
				if($year==$curr_year)
				$j=$month;
				for($i=1;$i<=$j;$i++){
					$month = sprintf('%02d',$i);
				$fmonth = $year . '-' . $month;
				syncDataWithFederalEPIMIS($tableName,$fmonth,'monthly',$distcode);
				}
			}
		}
		echo 'done';
	}

	public function zero_compliance_count(){
		$tablename = $this -> input -> get('tablename');
		$dateColumn = 'submitted_date';
		$compliancetable = $this -> input -> get('compliancetable');
		$yearr = $this -> input -> get('year');
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			// Years loop
			$query = "SELECT fweek from epi_weeks where year='{$yearr}' order by fweek";
			$result = $this-> db-> query($query);
			$data['epi_fweeks'] = $result-> result_array();

			foreach($data['epi_fweeks'] as $fweekkey => $fweek){
				$parts = explode("-", $fweek['fweek']);
				$year = $parts[0];
				$wk = $parts[1];
				$week = sprintf('%02d',$wk);
				$fweek = $year . '-' . $week;
				//echo $fweek;
				// Total submitted reports
				$this -> db -> select("zeroreport_sub('{$fweek}','{$distcode}') as sub");
				//$this -> db -> where(array('fweek' => $fweek,'distcode' => $distcode,"getfstatus_ds('{$fweek}',facode)"=>'F','report_submitted'=>1));
				$submittedReports = $this -> db -> get() -> row();
				$submittedReports = $submittedReports -> sub;
				// Check if record already exist in compliance table for year and district
				$rowexist = $this -> db -> query("select exists(select * from {$compliancetable} where year='{$year}' and distcode='{$distcode}') as rowexist") -> row();
				// Total functional due reports
				$dueReports = $this -> db -> query("select get_weekly_fstatus_ds('{$year}','{$week}','{$distcode}') as due") -> row();
				$dueReports = ($dueReports -> due > 0)?$dueReports -> due:0;
				// Total timely submitted reports
				//$timelySubmitted = $this -> db -> query("select count(*) as tsub from {$tablename} where fweek = '{$fweek}' and distcode = '{$distcode}' and getfstatus_ds('{$fweek}',facode)='F' and submitted_date IS NOT NULL AND report_submitted=1") -> row();
				$timelySubmitted = $this -> db -> query("select zeroreport_tsub('{$fweek}','{$distcode}') as tsub") -> row();
				$timelySubmitted = $timelySubmitted -> tsub;
				// if row exists then update else insert record
				if($rowexist -> rowexist == 't' || $rowexist -> rowexist == 'TRUE' || $rowexist -> rowexist == 'true' || $rowexist -> rowexist == TRUE){
					$this -> db -> query("UPDATE {$compliancetable} set duewk{$wk} = {$dueReports}, subwk{$wk} = {$submittedReports}, tsubwk{$wk} = {$timelySubmitted} where year = '{$year}' and distcode = '{$distcode}' ");
				}else{
					$this -> db -> query("INSERT INTO {$compliancetable} (year, duewk{$wk}, subwk{$wk}, tsubwk{$wk}, distcode) VALUES ('{$year}', {$dueReports}, {$submittedReports}, {$timelySubmitted}, '{$distcode}') ");
				}
				echo $this -> db -> last_query();
					echo '<hr>';
			}
		}
	}
	public function case_epid_count(){
		$procode=$this->session->Province;
		$yearr = $this -> input -> get('year');
		$dosecount = $this -> input -> get('dosecount');
		$gender = $this -> input -> get('gender');
		$case_type = $this -> input -> get('case_type');
		if($case_type=='Msl'){
			$specimen_result='Positive Measles';
		}else{
			$specimen_result='Positive';
		}
		
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			$query = "SELECT fweek from epi_weeks where year='{$yearr}' order by fweek";
			$result = $this-> db-> query($query);
			$data['epi_fweeks'] = $result-> result_array();
			foreach($data['epi_fweeks'] as $fweekkey => $fweek){
				$parts = explode("-", $fweek['fweek']);
				$year = $parts[0];
				$wk = $parts[1];
				$week = sprintf('%02d',$wk);
				$fweek = $year . '-' . $week;
				
				$query="SELECT 
							'$procode' as procode,distcode,case_type,'$dosecount' as dosenumber,
							sum(case when age_months >= 0 AND age_months < 9 then 1 else 0 end) as lessthan9months,
							sum(case when age_months >= 0 AND age_months < 9 AND type_specimen <> 'Not Collected' then 1 else 0 end) as lessthan9months_samplecollected,
							sum(case when age_months >= 0 AND age_months < 9 AND specimen_result='$specimen_result' then 1 else 0 end) as lessthan9months_result_positive,
					        sum(case when age_months >= 0 AND age_months < 9 AND specimen_result='Positive Rubella' then 1 else 0 end) as lessthan9months_result_positive_rubella,		
							
							sum(case when age_months >= 9 and age_months < 24  then 1 else 0 end) as age9to24months,
							sum(case when age_months >= 9 AND age_months < 24 AND type_specimen <> 'Not Collected' then 1 else 0 end) as age9to24months_samplecollected,
							sum(case when age_months >= 9 AND age_months < 24 AND specimen_result='$specimen_result' then 1 else 0 end) as age9to24months_result_positive,
							sum(case when age_months >= 9 AND age_months < 24 AND specimen_result='Positive Rubella' then 1 else 0 end) as age9to24months_result_positive_rubella,
							
							sum(case when age_months >= 24 and age_months < 60  then 1 else 0 end) as age24to60months,
							sum(case when age_months >= 24 AND age_months < 60 AND type_specimen <> 'Not Collected' then 1 else 0 end) as age24to60months_samplecollected,
							sum(case when age_months >= 24 AND age_months < 60 AND specimen_result='$specimen_result' then 1 else 0 end) as age24to60months_result_positive,
							sum(case when age_months >= 24 AND age_months < 60 AND specimen_result='Positive Rubella' then 1 else 0 end) as age24to60months_result_positive_rubella,
							
							sum(case when age_months >= 60 and age_months < 120  then 1 else 0 end) as age60to120months,
							sum(case when age_months >= 60 AND age_months < 120 AND type_specimen <> 'Not Collected' then 1 else 0 end) as age60to120months_samplecollected,
							sum(case when age_months >= 60 AND age_months < 120 AND specimen_result='$specimen_result' then 1 else 0 end) as age60to120months_result_positive,
							sum(case when age_months >= 60 AND age_months < 120 AND specimen_result='Positive Rubella' then 1 else 0 end) as age60to120months_result_positive_rubella,
							
							sum(case when age_months >= 120 and age_months < 180  then 1 else 0 end) as age120to180months,
							sum(case when age_months >= 120 AND age_months < 180 AND type_specimen <> 'Not Collected' then 1 else 0 end) as age120to180months_samplecollected,
							sum(case when age_months >= 120 AND age_months < 180 AND specimen_result='$specimen_result' then 1 else 0 end) as age120to180months_result_positive,
					        sum(case when age_months >= 120 AND age_months < 180 AND specimen_result='Positive Rubella' then 1 else 0 end) as age120to180months_result_positive_rubella,
							
							sum(case when age_months >= 180  then 1 else 0 end) as greaterthan180months,
							sum(case when age_months >= 180 AND type_specimen <> 'Not Collected' then 1 else 0 end) as greaterthan180months_samplecollected,
							sum(case when age_months >= 180 AND specimen_result='$specimen_result' then 1 else 0 end) as greaterthan180months_result_positive,
							sum(case when age_months >= 180 AND specimen_result='Positive Rubella' then 1 else 0 end) as greaterthan180months_result_positive_rubella,

							sum(case when age_months is NULL then 1 else 0 end) as unknown,
							sum(case when age_months is NULL AND type_specimen <> 'Not Collected' then 1 else 0 end) as unknown_samplecollected,
							sum(case when age_months is NULL AND specimen_result='specimen_result' then 1 else 0 end) as unknown_result_positive,
							sum(case when age_months is NULL AND specimen_result='Positive Rubella' then 1 else 0 end) as unknown_result_positive_rubella,

							patient_gender as gender ,year ,week as selected_week 
						FROM 
								case_investigation_db 
						WHERE 
							distcode='$distcode' and (cross_notified <> 1 OR approval_status='Approved') and week='$wk'  and case_type='$case_type' and doses_received='$dosecount' and year='$year' and patient_gender='$gender'
							group by case_investigation_db.patient_gender,case_type,year,week,distcode
				"; 
				$result = $this -> db -> query($query);
				$data = $result -> result_array();
				if(!empty($data[0])){
					$insertionData[] = $data[0];
				}
				//$insertionData[] = $data[0];	
				
			}
			if(!empty($insertionData)){
			//print_r($insertionData);
			$this->db->insert_batch('caseepidcount_master',$insertionData);
			}
			$insertionData=array();
			
		}
	}
	public function case_afp_count(){
		$procode=$this->session->Province;
		$yearr = $this -> input -> get('year');
		$dosecount = $this -> input -> get('dosecount');
		$gender = $this -> input -> get('gender');
		$case_type = $this -> input -> get('case_type');
		if($dosecount=='99'){
			$wheredosesrecive='doses_received > 2 ';
		}else{
			$wheredosesrecive='doses_received = '.$dosecount.' ';
		}
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			$query = "SELECT fweek from epi_weeks where year='{$yearr}' order by fweek";
			$result = $this-> db-> query($query);
			$data['epi_fweeks'] = $result-> result_array();
			foreach($data['epi_fweeks'] as $fweekkey => $fweek){
				$parts = explode("-", $fweek['fweek']);
				$year = $parts[0];
				$wk = $parts[1];
				$week = sprintf('%02d',$wk);
				$fweek = $year . '-' . $week;
				
				$query="SELECT 
							'$procode' as procode,distcode,'$case_type' as case_type,'$dosecount' as dosenumber,
							sum(case when age_months >= 0 AND age_months < 9 then 1 else 0 end) as lessthan9months,
							
							sum(case when age_months >= 9 and age_months < 24  then 1 else 0 end) as age9to24months,
							
							sum(case when age_months >= 24 and age_months < 60  then 1 else 0 end) as age24to60months,
							
							sum(case when age_months >= 60 and age_months < 120  then 1 else 0 end) as age60to120months,
							
							sum(case when age_months >= 120 and age_months < 180  then 1 else 0 end) as age120to180months,
							
							sum(case when age_months >= 180  then 1 else 0 end) as greaterthan180months,
							
							sum(case when age_months is NULL then 1 else 0 end) as unknown,
							

							patient_gender as gender ,year ,week as selected_week 
						FROM 
								afp_case_investigation 
						WHERE 
							distcode='$distcode' and week='$wk' and (cross_notified is null OR approval_status='Approved' OR cross_notified=0)and ". $wheredosesrecive ." and year='$year' and patient_gender='$gender'
							group by afp_case_investigation.patient_gender,year,week,distcode
				"; 
				$result = $this -> db -> query($query);
				$data = $result -> result_array();
				if(!empty($data[0])){
					$insertionData[] = $data[0];
					
				}
				
			}
			if(!empty($insertionData)){	
				$this->db->insert_batch('caseepidcount_master',$insertionData);
			}
			$insertionData=array();
			
		}
	}
	public function case_nnt_count(){
		$procode=$this->session->Province;
		$yearr = $this -> input -> get('year');
		$dosecount = $this -> input -> get('dosecount');
		$gender = $this -> input -> get('gender');
		$case_type = $this -> input -> get('case_type');
		if($dosecount=='99'){
			$wheredosesrecive='doses_received > 2 ';
		}else{
			$wheredosesrecive='doses_received = '.$dosecount.' ';
		}
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			$query = "SELECT fweek from epi_weeks where year='{$yearr}' order by fweek";
			$result = $this-> db-> query($query);
			$data['epi_fweeks'] = $result-> result_array();
			foreach($data['epi_fweeks'] as $fweekkey => $fweek){
				$parts = explode("-", $fweek['fweek']);
				$year = $parts[0];
				$wk = $parts[1];
				$week = sprintf('%02d',$wk);
				$fweek = $year . '-' . $week;
				
				 $query="SELECT 
							'$procode' as procode,distcode,'$case_type' as case_type,'$dosecount' as dosenumber,
							sum(case when age_months >= 0 AND age_months < 9 then 1 else 0 end) as lessthan9months,
							
							sum(case when age_months >= 9 and age_months < 24  then 1 else 0 end) as age9to24months,
							
							sum(case when age_months >= 24 and age_months < 60  then 1 else 0 end) as age24to60months,
							
							sum(case when age_months >= 60 and age_months < 120  then 1 else 0 end) as age60to120months,
							
							sum(case when age_months >= 120 and age_months < 180  then 1 else 0 end) as age120to180months,
							
							sum(case when age_months >= 180  then 1 else 0 end) as greaterthan180months,
							
							sum(case when age_months is NULL then 1 else 0 end) as unknown,
							

							(CASE WHEN gender='Male' THEN 1 ELSE 0  end )as gender ,year ,week as selected_week 
						FROM 
								nnt_investigation_form 
						WHERE 
							distcode='$distcode' and week='$wk' and (cross_notified is null OR approval_status='Approved' OR cross_notified=0)   and ". $wheredosesrecive ." and year='$year' and gender='$gender'
							group by nnt_investigation_form.gender,year,week,distcode
				"; 
				$result = $this -> db -> query($query);
				$data = $result -> result_array();
				if(!empty($data[0])){
					$insertionData[] = $data[0];
					
				}
			}
			if(!empty($insertionData)){	
				$this->db->insert_batch('caseepidcount_master',$insertionData);
			}
			$insertionData=array();
			
		}
	}
	public function sendZeroReportAllDistrictsAggregatedData(){
		$tableName = $this -> uri -> segment(3);
		$year = $this -> uri -> segment(4);
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		// All districts loop
		foreach($resultDistricts as $key => $district){
			$distcode = $district -> distcode;
			// Years loop
			$query = "SELECT fweek from epi_weeks where year='{$year}' order by fweek";
			$result = $this-> db-> query($query);
			$data['epi_fweeks'] = $result-> result_array();

			foreach($data['epi_fweeks'] as $fweekkey => $fweek){
				syncDataWithFederalEPIMIS($tableName,$fweek['fweek'],'weekly',$distcode);
			}
		}
		echo 'done';
	}
	
	public function countWeeklyCaseTypeEPIDCount(){
		$year = $this -> uri -> segment(3);
		$this -> db -> select('distinct(case_type) case_type');
		$this -> db -> from('case_investigation_db');
		$caseTypes = $this -> db -> get() -> result();
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		$i = 0;
		// All districts loop
		foreach($caseTypes as $casekey => $case){
			foreach($resultDistricts as $key => $district){
				$distcode = $district -> distcode;
				// Years loop
				$query = "SELECT fweek from epi_weeks where year='{$year}' order by fweek";
				$result = $this-> db-> query($query);
				$data['epi_fweeks'] = $result-> result_array();

				foreach($data['epi_fweeks'] as $fweekkey => $fweek){
					$parts = explode("-", $fweek['fweek']);
					$year = $parts[0];
					$wk = $parts[1];
					$week = sprintf('%02d',$wk);
					$fweek = $year . '-' . $week;
					// Total submitted reports
					$this -> db -> select("count(CASE WHEN patient_gender='0' THEN 1 END) as fcaseepidcount, count(CASE WHEN patient_gender='1' THEN 1 END) as mcaseepidcount");
					$this -> db -> where(array('fweek' => $fweek,'distcode' => $distcode,'case_type' => $case -> case_type));
					$epidcount = $this -> db -> get('case_investigation_db') -> row();
					$caseArray[$key]['mwk'.$week] = $epidcount -> mcaseepidcount;
					$caseArray[$key]['fwk'.$week] = $epidcount -> fcaseepidcount;
				}
				$caseArray[$key]['distcode'] = $distcode;
				$caseArray[$key]['procode'] = 3;
				$caseArray[$key]['year'] = $year;
				$caseArray[$key]['case_type'] = $case -> case_type;
			}
			//print_r($caseArray);exit;
			$this -> db -> insert_batch('epidcount_db',$caseArray);
			$caseArray = array();
		}
	}
	
	public function sendAllDistrictsEpidCountAggregatedData(){
		$year = $this -> uri -> segment(3);
		$this -> db -> select('distinct(case_type) case_type');
		$this -> db -> from('epidcount_db');
		$caseTypes = $this -> db -> get() -> result();
		$this -> db -> select('distcode');
		$this -> db -> from('districts');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		$i = 0;
		// All districts loop
		foreach($caseTypes as $casekey => $case){
			foreach($resultDistricts as $key => $district){
				$distcode = $district -> distcode;
				syncEpidCountDataWithFederalEPIMIS($year,$case -> case_type,$distcode);
			}
		}
	}
	public function sendAllDistrictsCaseEpidCountMasterAggregatedData(){
		$year = $this -> uri -> segment(3);
		$this -> db -> select('distinct(case_type) case_type');
		$this -> db -> from('caseepidcount_master');
		$this -> db -> where('year',$year);
		$this -> db -> where('case_type','Diph');
		$caseTypes = $this -> db -> get() -> result();
		$this -> db -> select('distinct(distcode) distcode');
		$this -> db -> from('caseepidcount_master');
		$this -> db -> order_by('distcode','asc');
		$resultDistricts = $this -> db -> get() -> result();
		$i = 0;
		$query = "SELECT distinct(selected_week) week from caseepidcount_master where year='{$year}' order by selected_week";
		$result = $this -> db -> query($query);
		$data['epi_fweeks'] = $result-> result_array();
		// All districts loop
		$dosesnumbers = array(0,1,2,99);
		foreach($dosesnumbers as $dosenumber){
			for($gender=0;$gender<=1;$gender++){
				foreach($caseTypes as $casekey => $case){
					foreach($resultDistricts as $key => $district){
						$distcode = $district -> distcode;
						foreach($data['epi_fweeks'] as $fweekkey => $fweek){
							$week = $fweek['week'];
							syncCaseEpidCountMasterDataWithFederalEPIMIS($year, $week, $case -> case_type,$distcode, $dosenumber, $gender);
						}
					}
				}
			}
		}
	}
	public function microplan_technician_config(){
	 	
		$Active = $this -> uri -> segment(3);
		$this -> db -> select('techniciancode,facode');
		$this -> db -> from('techniciandb');
		$this -> db -> where(array('status' => $Active));
		$this->db->order_by("facode","desc");
		$technician = $this -> db -> get()-> result_array();
		$previouscode='';
		foreach($technician as $key => $val){
			if($previouscode==$val['facode']){
				$plan_id=++$plan_id;
			}else{
				$plan_id=1;
			}
			$previouscode=$val['facode'];	
			$array = array(
				'facode'=>$val['facode'],
				'plan_id'=>$plan_id, 
				'techniciancode'=>$val['techniciancode'],
			);
			//$this -> Common_model -> insert_record('microplan_technician_config',$array); 
			//print_r($array);
		}
		//exit;
	}
	
}
?>