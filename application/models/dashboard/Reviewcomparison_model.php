<?php
class Reviewcomparison_model extends CI_Model {

	public function coverage_data($year,$monthly,$quaterly){
		if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Coverage for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		if($monthly){
			$procode=$this->session->Province;
			$fmonth=explode('-',$val);
			$month=$fmonth[1];
			 $query = "
						SELECT 
							ROUND(sumvaccinevacination(1,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value,
							ROUND(sumvaccinevacination(7,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value2,
							ROUND(sumvaccinevacination(9,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value3,
							ROUND(sumvaccinevacination(15,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value4,
							ROUND(sumvaccinevacination(16,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value5
						FROM 
							provinces 
						WHERE procode ='$procode' 
						
					"; 
			$data['dataseries'][$i]['seriesname']=$val;	
		}else{
			$yearmonth=explode('/',$val);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$years=$fmonth[0];
			$procode=$this->session->Province;
			$query = "
					SELECT 
						ROUND(sumvaccinevacination(1,procode,'{$yearmonthfrom}','{$yearmonthto}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$years},{$monthfrom},{$years},{$monthto})::numeric) as value,
						ROUND(sumvaccinevacination(7,procode,'{$yearmonthfrom}','{$yearmonthto}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$years},{$monthfrom},{$years},{$monthto})::numeric) as value2,
						ROUND(sumvaccinevacination(9,procode,'{$yearmonthfrom}','{$yearmonthto}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$years},{$monthfrom},{$years},{$monthto})::numeric) as value3,
						ROUND(sumvaccinevacination(15,procode,'{$yearmonthfrom}','{$yearmonthto}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$years},{$monthfrom},{$years},{$monthto})::numeric) as value4,
						ROUND(sumvaccinevacination(16,procode,'{$yearmonthfrom}','{$yearmonthto}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$years},{$monthfrom},{$years},{$monthto})::numeric) as value5
					FROM 
						provinces 
					WHERE procode ='$procode' 
					
				";
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$data['dataseries'][$i]['seriesname']=$quarter;
				
			}else{
				$data['dataseries'][$i]['seriesname']=$years;
			}
		}
		$res=$this -> db -> query($query) -> result_array();
		foreach($res as $key1 => $value1){
			
			$resdata[0]['value'] = $value1['value'];
			$resdata[1]['value'] = $value1['value2'];
			$resdata[2]['value'] = $value1['value3'];
			$resdata[3]['value'] = $value1['value4'];
			$resdata[4]['value'] = $value1['value5'];
			
			
		}
		$data['dataseries'][$i]['data'] = json_encode($resdata);
		
		$i++;
		}
		return $data;
		
	}
	public function dropout_data($year,$monthly,$quaterly){
		if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Coverage for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		if($monthly){	
		$procode=$this->session->Province;
		$query = "
					SELECT 
						ROUND((sumvaccinevacination(7,procode,'{$val}','{$val}}')-sumvaccinevacination(9,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$val}','{$val}'),0)) as penta1to3,
						ROUND((sumvaccinevacination(16,procode,'{$val}','{$val}')-sumvaccinevacination(18,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(16,procode,'{$val}','{$val}'),0)) as measle1to2,
						ROUND((sumvaccinevacination(7,procode,'{$val}','{$val}')-sumvaccinevacination(16,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$val}','{$val}'),0)) as penta1tomeasle1,
						ROUND(monthly_dropout_rate('{$val}',procode,'tt1-tt2','{$val}')) as tt1to3
					FROM 
						provinces 
					WHERE  procode ='$procode' 
					
				";
		$data['dataseries'][$i]['seriesname']=$val;
		}else{
			$yearmonth=explode('/',$val);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
		
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$years=$fmonth[0];
			$procode=$this->session->Province;
		
				$query = "
					SELECT 
						ROUND((sumvaccinevacination(7,procode,'{$yearmonthfrom}','{$yearmonthto}}')-sumvaccinevacination(9,procode,'{$yearmonthfrom}','{$yearmonthto}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$yearmonthfrom}','{$yearmonthto}'),0)) as penta1to3,
						ROUND((sumvaccinevacination(16,procode,'{$yearmonthfrom}','{$yearmonthto}')-sumvaccinevacination(18,procode,'{$yearmonthfrom}','{$yearmonthto}'))*100/NULLIF(sumvaccinevacination(16,procode,'{$yearmonthfrom}','{$yearmonthto}'),0)) as measle1to2,
						ROUND((sumvaccinevacination(7,procode,'{$yearmonthfrom}','{$yearmonthto}')-sumvaccinevacination(16,procode,'{$yearmonthfrom}','{$yearmonthto}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$yearmonthfrom}','{$yearmonthto}'),0)) as penta1tomeasle1,
						ROUND(monthly_dropout_rate('{$yearmonthfrom}',procode,'tt1-tt2','{$yearmonthto}')) as tt1to3
					FROM 
						provinces 
					WHERE  procode ='$procode' 
					
				";
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$data['dataseries'][$i]['seriesname']=$quarter;
				
			}else{
				$data['dataseries'][$i]['seriesname']=$years;
			}
		}
		
		$res=$this -> db -> query($query) -> result_array();
		
		foreach($res as $key1 => $value1){
			
			$resdata[0]['value'] = ($value1['penta1to3'] > 0?$value1['penta1to3']:0);
			$resdata[1]['value'] = ($value1['penta1tomeasle1'] > 0?$value1['penta1tomeasle1']:0);
			$resdata[2]['value'] = ($value1['measle1to2'] > 0?$value1['measle1to2']:0);
			$resdata[3]['value'] = ($value1['tt1to3'] > 0?$value1['tt1to3']:0);
			
			
		}
		$data['dataseries'][$i]['data'] = json_encode($resdata);
		
		$i++;
		}
		return $data;
		
	}
	public function fullyimmunized_data($year,$monthly,$quaterly){
		if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Coverage for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		//print_r($data['ym']);exit;
		foreach($data['ym'] as $key=>$val){
		if($monthly){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[1];
		$label=$val;
		 $query = "select (
							sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 + cri_r7_f17 + cri_r9_f17 + cri_r11_f17 + cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r1_f17 + oui_r3_f17 + oui_r5_f17 + oui_r7_f17 + oui_r9_f17 + oui_r11_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17)
							+(select sum(od_r1_f17 + od_r3_f17 + od_r5_f17 + od_r7_f17 + od_r9_f17 + od_r11_f17 + od_r13_f17 + od_r15_f17 + od_r17_f17 + od_r19_f17 + od_r21_f17 + od_r23_f17) from fac_mvrf_od_db where fmonth = '$val')
							+ (sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 + cri_r8_f17 + cri_r10_f17 + cri_r12_f17 + cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r2_f17 + oui_r4_f17 + oui_r6_f17 + oui_r8_f17 + oui_r10_f17 + oui_r12_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17)
							+(select sum(od_r2_f17 + od_r4_f17 + od_r6_f17 + od_r8_f17 + od_r10_f17 + od_r12_f17 + od_r14_f17 + od_r16_f17 + od_r18_f17 + od_r20_f17 + od_r22_f17 + od_r24_f17) from fac_mvrf_od_db where fmonth = '$val'))) as fullyimmunized, 
							round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$year},{$month},{$year},{$month})::numeric,0) as target 
							from fac_mvrf_db where fac_mvrf_db.fmonth = '$val' 
			";
		}else{
			$yearmonth=explode('/',$val);
			//print_r($yearmonth);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
		
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$years=$fmonth[0];
			$procode=$this->session->Province;
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$label=$quarter;
				
			}else{
				$label=$years;
			}
				$query = "select (
							sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 + cri_r7_f17 + cri_r9_f17 + cri_r11_f17 + cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r1_f17 + oui_r3_f17 + oui_r5_f17 + oui_r7_f17 + oui_r9_f17 + oui_r11_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17)
							+(select sum(od_r1_f17 + od_r3_f17 + od_r5_f17 + od_r7_f17 + od_r9_f17 + od_r11_f17 + od_r13_f17 + od_r15_f17 + od_r17_f17 + od_r19_f17 + od_r21_f17 + od_r23_f17) from fac_mvrf_od_db where fmonth between '$yearmonthfrom' and '$yearmonthto')
							+ (sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 + cri_r8_f17 + cri_r10_f17 + cri_r12_f17 + cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r2_f17 + oui_r4_f17 + oui_r6_f17 + oui_r8_f17 + oui_r10_f17 + oui_r12_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17)
							+(select sum(od_r2_f17 + od_r4_f17 + od_r6_f17 + od_r8_f17 + od_r10_f17 + od_r12_f17 + od_r14_f17 + od_r16_f17 + od_r18_f17 + od_r20_f17 + od_r22_f17 + od_r24_f17) from fac_mvrf_od_db where fmonth between '$yearmonthfrom' and '$yearmonthto'))) as fullyimmunized, 
							round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$years},{$monthfrom},{$years},{$monthto})::numeric,0) as target 
							from fac_mvrf_db where fac_mvrf_db.fmonth between '$yearmonthfrom' and '$yearmonthto'
					";
			
		}
		$res=$this -> db -> query($query) -> result_array();
		//print_r($res);
		foreach($res as $key=>$value)
		{
			if($value['fullyimmunized']>=0){
			//print_r($value);
			$res=(double)($value['fullyimmunized']*100)/(($value['target']*51/100)+($value['target']*49/100));
			$datares[] = array(
					"label"	=> $label,
					"value"	=>round($res)
				);
				
			}	
		}
		//print_r($datares);exit;
		$data['dataseries']= json_encode($datares);
		
		$i++;
		}//exit;
		return $data;
	}
	
	public function childprotectedbirth_data($year,$monthly,$quaterly){
	if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Coverage for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		//$datares[]=null;
		foreach($data['ym'] as $key=>$val){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[1];
		if($monthly)
		{
			$label=$val;
			$query = "select (SUM(ttri_r1_f6)+SUM(ttri_r2_f6)+SUM(ttri_r3_f6)+SUM(ttri_r4_f6)+SUM(ttri_r5_f6)+SUM(ttri_r6_f6)+SUM(ttri_r7_f6)+SUM(ttri_r8_f6)+SUM(ttoui_r1_f6)+SUM(ttoui_r2_f6)+SUM(ttoui_r3_f6)+SUM(ttoui_r4_f6)+SUM(ttoui_r5_f6)+SUM(ttoui_r6_f6)+SUM(ttoui_r7_f6)+SUM(ttoui_r8_f6)) as cpb, round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$year},{$month},{$year},{$month})::numeric,0) as target from fac_mvrf_db where fac_mvrf_db.fmonth = '$val' 
			";
		}
		else
		{
			$yearmonth=explode('/',$val);
			//print_r($yearmonth);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
		
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$years=$fmonth[0];
			$procode=$this->session->Province;
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$label=$quarter;
				
			}else{
				$label=$years;
			}
			
			$query = "select (SUM(ttri_r1_f6)+SUM(ttri_r2_f6)+SUM(ttri_r3_f6)+SUM(ttri_r4_f6)+SUM(ttri_r5_f6)+SUM(ttri_r6_f6)+SUM(ttri_r7_f6)+SUM(ttri_r8_f6)+SUM(ttoui_r1_f6)+SUM(ttoui_r2_f6)+SUM(ttoui_r3_f6)+SUM(ttoui_r4_f6)+SUM(ttoui_r5_f6)+SUM(ttoui_r6_f6)+SUM(ttoui_r7_f6)+SUM(ttoui_r8_f6)) as cpb, round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$years},{$monthfrom},{$years},{$monthto})::numeric,0) as target from fac_mvrf_db where fac_mvrf_db.fmonth  between '$yearmonthfrom' and '$yearmonthto'";
		}
		$res=$this -> db -> query($query) -> result_array();
		//print_r($label);
		foreach($res as $key=>$value)
		{
			
			if($value['cpb']>0){
			//print_r($value);
			$res=(double)($value['cpb']*100)/($value['target']);
			$datares[] = array(
					"label"	=> $label,
					"value"	=>round($res)
				);
				
			}
			else
			{
				$datares[] = array(
					"label"	=> $label,
					"value"	=>0
				);
			}
				
		}
		$data['dataseries']= json_encode($datares);
		
		//$i++;
		}
		return $data;
	}
	public function compliances_data($year,$monthly,$quaterly){
		if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Compliance for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Compliance for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Compliance for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		//print_r($data['ym']);exit;
		foreach($data['ym'] as $key=>$val){
		if($monthly){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[1];
		$month=trim($month,'0');
		$label=$val;
		 $query = "select round((sum(subm$month)::float//sum(duem$month))::numeric*100,1) as compliance from vaccinationcompliance  where  year='$year'";
		}else{

			
			$yearmonth=explode('/',$val);
			//print_r($yearmonth);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
		
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			$monthfrom=trim($monthfrom,'0');
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$monthto=trim($monthto,'0');
			$years=$fmonth[0];
			$due="";$sub="";$timely="";
			for($i=$monthfrom;$i<=$monthto;$i++){
				$due.='COALESCE(duem'.$i.',0) +';
				$sub.='COALESCE(subm'.$i.',0) +';
				$timely.='COALESCE(tsubm'.$i.',0) +';
			}
			$due=rtrim($due,'+');
			$sub=rtrim($sub,'+');
			$timely=rtrim($timely,'+');
			$procode=$this->session->Province;
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$label=$quarter;
				
			}else{
				$label=$years;
			}
				$query = "select round((sum($sub)::float//sum($due))::numeric*100,1) as compliance from vaccinationcompliance  where year='$years'";
			
		}
		$res=$this -> db -> query($query) -> result_array();
		//print_r($res);
		foreach($res as $key=>$value)
		{
			if($value['compliance']>=0){
			//print_r($value);
			$res=$value['compliance'];
			$datares[] = array(
					"label"	=> $label,
					"value"	=>round($res)
				);
				
			}	
		}
		//print_r($datares);exit;
		$data['dataseries']= json_encode($datares);
		
		$i++;
		}//exit;
		return $data;
	}
		/* Access Utilization/ Category */
		public function categorywise_data($year,$monthly,$quaterly){
		if($monthly)
		{
			$endMonth=date("m", strtotime("first day of previous month"));
			$startMonth=$endMonth-2;
			$startMonth = sprintf("%02d", $startMonth);
			$data['caption'] = "Coverage for ".monthname($startMonth)." to ".monthname($endMonth)." of $year";
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon= sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}elseif($quaterly){
			$startquarter=1;
			$endquarter=3;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Quarter $startquarter to Quarter $endquarter of $year";
			for($j=$startquarter;$j<=$endquarter;$j++)
			{	
				if($j==1){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}elseif($j==2){
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}else{
					$quatermonth=getQuaterMonths($j);
					$from="2019-".$quatermonth['monthfrom']."";
					$to="2019-".$quatermonth['monthto']."";
				}
				$data['ym'][]=$from.'/'.$to;
			}
		}else{
			$startYear=2017;
			$endYear=2019;
			$startMonth=01;
			$endMonth=12;
			$data['caption'] = "Coverage for Year $startYear to Year $endYear ";
			for($j=$startYear;$j<=$endYear;$j++)
			{	
				$from="{$j}-01";
				$to="{$j}-12";
				if($j==date('Y'))
					$to="{$j}-".date("m", strtotime("first day of previous month"));
				$data['ym'][]=$from.'/'.$to;
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		if($monthly){
			$procode=$this->session->Province;
			$fmonth=explode('-',$val);
			$month=$fmonth[1];
			 $query = "SELECT *
			from (select 
					sum(case when (Access >= 80) and (utilization < 10) then 1 else 0 end) as cat1,
					sum(case when (Access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2,
					sum(case when (Access < 80) and (utilization < 10) then 1 else 0 end) as cat3,
					sum(case when (Access < 80) and (utilization >= 10) then 1 else 0 end) as cat4
					from(select 
						round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$val}','{$val}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,'{$year}','{$month}','{$year}','{$month}') :: float,0))*100):: numeric,0) as Access,
						round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$val}','{$val}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.procode,'{$val}','{$val}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.procode,'{$val}','{$val}'):: float,0) :: numeric)*100 ,1) as utilization
					from fac_mvrf_db where procode='$procode'
					group by procode order by procode) as a ) as a order by cat4 desc,cat3 desc,cat2 desc,cat1 asc"; 
			$data['dataseries'][$i]['seriesname']=$val;	
		}else{
			$yearmonth=explode('/',$val);
			$yearmonthfrom=$yearmonth[0];
			$yearmonthto=$yearmonth[1];
			$fmonth=explode('-',$yearmonthfrom);
			$monthfrom=$fmonth[1];
			$fmonth=explode('-',$yearmonthto);
			$monthto=$fmonth[1];
			$years=$fmonth[0];
			$procode=$this->session->Province;
			$query = "SELECT *
			from (select 
					sum(case when (Access >= 80) and (utilization < 10) then 1 else 0 end) as cat1,
					sum(case when (Access >= 80) and (utilization >= 10) then 1 else 0 end) as cat2,
					sum(case when (Access < 80) and (utilization < 10) then 1 else 0 end) as cat3,
					sum(case when (Access < 80) and (utilization >= 10) then 1 else 0 end) as cat4
					from(select 
						round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$yearmonthfrom}','{$yearmonthto}')::numeric/NULLIF(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,'{$years}','{$monthfrom}','{$years}','{$monthto}') :: float,0))*100):: numeric,0) as Access,
						round(((sumvaccinevacination(7,fac_mvrf_db.procode,'{$yearmonthfrom}','{$yearmonthto}') :: numeric - sumvaccinevacination(9,fac_mvrf_db.procode,'{$yearmonthfrom}','{$yearmonthto}'):: numeric)/NULLIF(sumvaccinevacination(7,fac_mvrf_db.procode,'{$yearmonthfrom}','{$yearmonthto}'):: float,0) :: numeric)*100 ,1) as utilization
					from fac_mvrf_db where procode='$procode'
					group by procode order by procode) as a) as a order by cat4 desc,cat3 desc,cat2 desc,cat1 asc";
			if($quaterly){
				if($monthfrom > 0 && $monthto < 4){
					$quarter='Quarter 1';
				}elseif($monthfrom > 3 && $monthto < 7){
					$quarter='Quarter 2';
				}elseif($monthfrom > 6 && $monthto < 10){
					$quarter='Quarter 3';
				}else{
					$quarter='Quarter 4';
				}
				$data['dataseries'][$i]['seriesname']=$quarter;
				
			}else{
				$data['dataseries'][$i]['seriesname']=$years;
			}
		}
		//print_r($query);
		$res=$this -> db -> query($query) -> result_array();
		foreach($res as $key1 => $value1){
			
			$resdata[0]['value'] = $value1['cat1'];
			$resdata[1]['value'] = $value1['cat2'];
			$resdata[2]['value'] = $value1['cat3'];
			$resdata[3]['value'] = $value1['cat4'];
			}
		$data['dataseries'][$i]['data'] = json_encode($resdata);
		
		$i++;
		}
		return $data;
		
	}
}
?>