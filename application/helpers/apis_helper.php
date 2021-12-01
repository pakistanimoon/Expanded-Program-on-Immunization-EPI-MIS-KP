<?php 
	if(!function_exists('syncDataWithFederalEPIMIS')){
		function syncDataWithFederalEPIMIS($tableName,$fmonth_week,$reportFrequency = 'monthly',$districtCode=NULL){
			$CI = & get_instance();
			$districtCode = ($districtCode)?$districtCode:$CI -> session -> District;
			$aggregatedDataResult=null;
			/* 
				Get all numeric/integer column of a specific table. 
				You can also change the schema and dataType of columns you want to fetch 
			*/
			if($tableName != 'fac_mvrf_od_db')
				getComplianceTableData($tableName,$fmonth_week,$districtCode);
			if($tableName=="form_b_cr")
			{
				$aggregatedDataResult=import_newData($fmonth_week,$districtCode);
			}
			else
			{
				$tableColumns = getColumnNames($tableName);
				$aggregatedDataResult = getAggregatedData($tableName,$fmonth_week,$reportFrequency,$tableColumns,$districtCode);
			}
			$dataSenttoFedralEPIMIS = sendDatatoFedralEPIMIS($tableName,$fmonth_week,$reportFrequency,$districtCode,$aggregatedDataResult);
		}
	}
	/*
		function use to reverse eng of data from epi_consumption_master,epi_consumption_detail to "form_b_cr" table format .
		for sending data to Federal DB	
	*/
		if(!function_exists('import_newData')){
		function import_newData($fmonth,$districtCode){
		$CI = & get_instance();
		$CI -> db -> select("concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(opening_doses),0))) as f1,concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(received_doses),0)))   as f2 ,concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(vaccinated),0)))  as f3,concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(used_vials),0)))  as f4,concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(unused_vials),0)))  as f5,concat(get_cr_table_row_numb_id(item_id),'-',ROUND(COALESCE(SUM(closing_vials),0)))  as f6");
		$CI -> db -> from('epi_consumption_master master');
		$CI -> db -> join('epi_consumption_detail detail','master.pk_id = detail.main_id','left');
		$CI -> db -> where("fmonth",$fmonth);
		$CI -> db -> where("distcode",$districtCode);
		$CI -> db -> where("item_id is NOT NULL");
		$CI -> db -> group_by("item_id");
		$yearData = $CI -> db -> get() -> result_array();
		$import_array=array();
		foreach($yearData as $val)
		{
			$v1 = explode("-",$val['f1']);
			$v2 = explode("-",$val['f2']);
			$v3 = explode("-",$val['f3']);
			$v4 = explode("-",$val['f4']);
			$v5 = explode("-",$val['f5']);
			$v6 = explode("-",$val['f6']);
			$index='cr_r'.$v1[0].'_f1';echo '<pre>';
			$import_array[0][$index]=$v1[1];
			$index='cr_r'.$v2[0].'_f2';echo '<pre>';
			$import_array[0][$index]=$v2[1];
			$index='cr_r'.$v3[0].'_f3';echo '<pre>';
			$import_array[0][$index]=$v3[1];
			$index='cr_r'.$v4[0].'_f4';echo '<pre>';
			$import_array[0][$index]=$v4[1];
			$index='cr_r'.$v5[0].'_f5';echo '<pre>';
			$import_array[0][$index]=$v5[1];
			$index='cr_r'.$v6[0].'_f6';echo '<pre>';
			$import_array[0][$index]=$v6[1];
			
		}
		return $import_array;
		}
	}
	if(!function_exists('getComplianceTableData')){
		function getComplianceTableData($tableName,$fmonth_week,$districtCode){
			switch($tableName){
				case 'fac_mvrf_db':
					$complianceTable = 'vaccinationcompliance';
					break;
				case 'form_b_cr':
					$complianceTable = 'consumptioncompliance';
					break;
				case 'zero_report':
					$complianceTable = 'zeroreportcompliance';
					break;
			}
			
			$year = explode('-',$fmonth_week);
			$year = $year[0];
			
			$CI = & get_instance();
			$CI -> db -> select('*');
			$CI -> db -> where(array('distcode'=>$districtCode, 'year' => $year));
			$complianceTablesData = $CI -> db -> get($complianceTable) -> result_array();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			if($baseUrl == $liveUrl){
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/receiveAndSaveComplianceData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/receiveAndSaveComplianceData/';
			}
			else{
				$url = '';
			}
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			
			$aray = http_build_query(
										array
										(
											'procode' => 3,
											'distcode' => $districtCode,
											'year' => $year,
											'complianceTable' => $complianceTable,
											'complianceTablesData' => $complianceTablesData
										)
									);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $server_output;
		}
	}
	
	if(!function_exists('getColumnNames')){
		function getColumnNames($tableName,$tableSchema='public',$dataType='integer'){
			$CI = & get_instance();
			$CI -> db -> select('column_name');
			$CI -> db -> from('information_schema.columns');
			$CI -> db -> where(
								array(
									'table_schema' => $tableSchema,
									'table_name' => $tableName,
									'data_type' => $dataType,
									'ordinal_position <>' => 1 
								)
			);
			return $tableColumns = $CI -> db -> get() -> result_array();
		}
	}
	
	if(!function_exists('getAggregatedData')){
		function getAggregatedData($tableName,$fmonth_week,$reportFrequency,$tableColumns,$districtCode){
			$CI = & get_instance();
			$querySelectPart = "SELECT ";
			foreach($tableColumns as $key => $column){
				$querySelectPart .= "COALESCE(SUM({$column['column_name']}),0) AS {$column['column_name']}, ";
			}
			$querySelectPart = rtrim($querySelectPart,', ');
			$querySelectPart .= " FROM {$tableName} ";
			if($reportFrequency == 'monthly')
				$querySelectPart .= " WHERE fmonth = '{$fmonth_week}' ";
			else
				$querySelectPart .= " WHERE fweek = '{$fmonth_week}' ";
			$querySelectPart .= " AND distcode = '{$districtCode}' ";
			return $result = $CI -> db -> query($querySelectPart) -> result_array();
		}
	}
	
	if(!function_exists('sendDatatoFedralEPIMIS')){
		function sendDatatoFedralEPIMIS($tableName,$fmonth_week,$reportFrequency,$districtCode,$aggregatedDataResult){
			$CI = & get_instance();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			if($baseUrl == $liveUrl){
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/receiveAndSaveData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/receiveAndSaveData/';
			}
			else{
				$url = '';
			}
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			$aray = http_build_query(
										array
										(
											'tableName' => $tableName,
											'fmonth_week' => $fmonth_week,
											'reportFrequency' => $reportFrequency,
											'districtCode' => $districtCode,
											'aggregatedDataResult' => $aggregatedDataResult
										)
									);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $server_output;
		}
	}
	
	if(!function_exists('sendPopulationUpdatesToFederalDashboard')){
		function sendPopulationUpdatesToFederalDashboard($year){
			$districtsPopulation = selectDistrictsPopulationData($year);
			$provincePopulation = selectProvincePopulationData($year);
			$CI = & get_instance();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			if($baseUrl == $liveUrl){
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/savePopulationData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/savePopulationData/';
			}
			else{
				$url = '';
			}
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			
			$aray = http_build_query(
										array
										(
											'year' => $year,
											'districtsPopulation' => $districtsPopulation,
											'provincePopulation' => $provincePopulation
										)
									);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $server_output;
		}
	}
	
	if(!function_exists('selectDistrictsPopulationData')){
		function selectDistrictsPopulationData($year){
			$CI = & get_instance();
			$CI -> db -> select('*');
			$CI -> db -> where('year',$year);
			return $districtsPopulation = $CI -> db -> get('districts_population') -> result_array();
		}
	}
	
	if(!function_exists('selectProvincePopulationData')){
		function selectProvincePopulationData($year){
			$CI = & get_instance();
			$CI -> db -> select('*');
			$CI -> db -> where('year',$year);
			return $provincePopulation = $CI -> db -> get('province_population') -> result_array();
		}
	}
	
	if(!function_exists('syncEpidCountDataWithFederalEPIMIS')){
		function syncEpidCountDataWithFederalEPIMIS($year,$caseType,$districtCode=NULL){
			$CI = & get_instance();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			$districtCode = ($districtCode)?$districtCode:$CI -> session -> District;
			$CI -> db -> select('*');
			$CI -> db -> from('epidcount_db');
			$CI -> db -> where(array('year' => $year, 'case_type' => $caseType, 'distcode' => $districtCode));
			$epidCountArray = $CI -> db -> get() -> row_array();
			unset($epidCountArray['pk_id']);
			$whereArray = array(
				'year' => $year,
				'case_type' => $caseType,
				'distcode' => $districtCode
			);
			if($baseUrl == $liveUrl){
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/saveEpidCountData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/saveEpidCountData/';
			}
			else{
				$url = '';
			}
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			
			$aray = http_build_query(
										array
										(
											'whereArray' => $whereArray,
											'epidCountArray' => $epidCountArray
										)
									);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $server_output;
		}
	}

	if(!function_exists('syncCaseEpidCountMasterDataWithFederalEPIMIS')){
		function syncCaseEpidCountMasterDataWithFederalEPIMIS($year, $week, $caseType, $districtCode, $doseNumber, $gender){
			//echo $year;exit;
			$CI = & get_instance();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			$districtCode = ($districtCode)?$districtCode:$CI -> session -> District;
			$CI -> db -> select('*');
			$CI -> db -> from('caseepidcount_master');
			$CI -> db -> where(array('year' => $year, 'selected_week' => '2', 'case_type' => $caseType, 'distcode' => $districtCode, 'dosenumber' => $doseNumber, 'gender' => (string)$gender));
			$epidCountArray = $CI -> db -> get() -> row_array();
			//print_r($year);exit;
			//echo($epidCountArray);exit;
			//echo $CI -> db -> last_query();exit;	
			unset($epidCountArray['pk_id']);
			$whereArray = array(
				'year' => $year, 
				'selected_week' => $week, 
				'case_type' => $caseType,
				'distcode' => $districtCode, 
				'dosenumber' => $doseNumber, 
				'gender' => $gender
			);
			//print_r($liveUrl);exit;
			if($baseUrl == $liveUrl){
				//echo'here';exit;
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/saveCaseEpidCountMasterData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/saveCaseEpidCountMasterData/';
			}
			else{
				$url = '';
			}
			
			$ch = curl_init();
			//print_r($url);exit;
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			
			$aray = http_build_query(
										array
										(
											'whereArray' => $whereArray,
											'epidCountMasterArray' => $epidCountArray
										)
									);
			//print_r($aray);exit;
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			echo $server_output;
		}
	}
		/** data that change on trigger which is not sync to federal using flag .sync it **/
	if(!function_exists('synccomplianceDataWithFederalEPIMIS')){
		function syncComplianceDataWithFederalEPIMIS($tablename){
			$CI = & get_instance();
			$liveUrl = $CI -> session -> liveURL;
			$localUrl = $CI -> session -> localURL;
			$baseUrl = base_url();
			$CI -> db -> select('*');
			$CI -> db -> from($tablename);
			//getting data that not sync to federal DB
			$CI -> db -> where(array('flag' =>1));
			$complianceArray = $CI -> db -> get() -> result_array();
			if(!empty($complianceArray)){		
			if($baseUrl == $liveUrl){
				$url = 'http://federal.epimis.pk/Receive_data_from_regions/receiveAndSaveFlagComplianceData/';
			}
			elseif($baseUrl == $localUrl){
				$url = 'http://epifederal.pacemis.com/Receive_data_from_regions/receiveAndSaveFlagComplianceData/';
			}
			else{
				$url = '';
			}
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			
			$aray = http_build_query(
										array
										(
											'complianceTable' => $tablename,
											'complianceTablesData' => $complianceArray
										)
									);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $aray);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);
			// receive server response ...
			$server_output = curl_exec ($ch);
			$http_status  = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
			curl_close ($ch);
			echo $server_output;
			echo $http_status;
			///setting flag to 0 after sync success.
			if($http_status==200 )
			{
				
				foreach($complianceArray as $key=>$row)
				{
					$CI->db->where('id',$row['id']);
					$CI->db->update($tablename,array('flag'=>0));
				}
			}
		}
		else
		{
			echo 'No rows to sync.';
		}	
	}
}
?>