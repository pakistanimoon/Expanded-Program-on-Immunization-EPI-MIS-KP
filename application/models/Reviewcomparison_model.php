<?php
class Reviewcomparison_model extends CI_Model {

	public function coverage_data($year,$monthly,$quaterly)
	{
		if($monthly)
		{
			$startMonth=1;
			$endMonth=3;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}
		if($year && $monthly=false)
		{
			$startMonth=01;
			$endMonth=12;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[0];
		//$year=explode('-',$val);
		$query = "
					SELECT 
						ROUND(sumvaccinevacination(1,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value,ROUND(sumvaccinevacination(15,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value2,
						ROUND(sumvaccinevacination(9,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value3,
						ROUND(sumvaccinevacination(16,procode,'{$val}','{$val}')*100/getmonthlytarget_specificyearrsurvivinginfants(procode,'province',{$year},{$month},{$year},{$month})::numeric) as value4
					FROM 
						provinces 
					WHERE procode ='$procode' 
					
				";
		$dataseries[$i]['seriesname']=$val;
		$res=$this -> db -> query($query) -> result_array();
		
		foreach($res as $key1 => $value1){
			
			$resdata[0]['value'] = $value1['value'];
			$resdata[1]['value'] = $value1['value2'];
			$resdata[2]['value'] = $value1['value3'];
			$resdata[3]['value'] = $value1['value4'];
			
			
		}
		$dataseries[$i]['data'] = json_encode($resdata);
		
		$i++;
		}
		return $dataseries;
		
	}
	public function dropout_data($year,$monthly,$quaterly)
	{
		if($monthly)
		{
			$startMonth=1;
			$endMonth=3;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}
		if($year && $monthly=false)
		{
			$startMonth=01;
			$endMonth=12;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		$procode=$this->session->Province;
	$query = "
					SELECT 
						ROUND((sumvaccinevacination(7,procode,'{$val}','{$val}}')-sumvaccinevacination(9,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$val}','{$val}'),0)) as penta1to3,
						ROUND((sumvaccinevacination(16,procode,'{$val}','{$val}')-sumvaccinevacination(18,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(16,procode,'{$val}','{$val}'),0)) as measle1to2,
						ROUND((sumvaccinevacination(7,procode,'{$val}','{$val}')-sumvaccinevacination(16,procode,'{$val}','{$val}'))*100/NULLIF(sumvaccinevacination(7,procode,'{$val}','{$val}'),0)) as penta1tomeasle1,
						ROUND(monthly_dropout_rate('{$val}',procode,'tt1-tt3','{$val}')) as tt1to3
					FROM 
						provinces 
					WHERE  procode ='$procode' 
					
				";
		$dataseries[$i]['seriesname']=$val;
		$res=$this -> db -> query($query) -> result_array();
		
		foreach($res as $key1 => $value1){
			
			$resdata[0]['value'] = ($value1['penta1to3'] > 0?$value1['penta1to3']:0);
			$resdata[1]['value'] = ($value1['penta1tomeasle1'] > 0?$value1['penta1tomeasle1']:0);
			$resdata[2]['value'] = ($value1['measle1to2'] > 0?$value1['measle1to2']:0);
			$resdata[3]['value'] = ($value1['tt1to3'] > 0?$value1['tt1to3']:0);
			
			
		}
		$dataseries[$i]['data'] = json_encode($resdata);
		
		$i++;
		}
		return $dataseries;
		
	}
	public function fullyimmunized_data($year,$monthly,$quaterly)
	{
		if($monthly)
		{
			$startMonth=1;
			$endMonth=3;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}
		if($year && $monthly=false)
		{
			$startMonth=01;
			$endMonth=12;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}	
		$i=0;	
		foreach($data['ym'] as $key=>$val){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[0];
	$query = "select (sum(cri_r1_f17 + cri_r3_f17 + cri_r5_f17 + cri_r7_f17 + cri_r9_f17 + cri_r11_f17 + cri_r13_f17 + cri_r15_f17 + cri_r17_f17 + cri_r19_f17 + cri_r21_f17 + cri_r23_f17 + oui_r1_f17 + oui_r3_f17 + oui_r5_f17 + oui_r7_f17 + oui_r9_f17 + oui_r11_f17 + oui_r13_f17 + oui_r15_f17 + oui_r17_f17 + oui_r19_f17 + oui_r21_f17 + oui_r23_f17)+(select sum(od_r1_f17 + od_r3_f17 + od_r5_f17 + od_r7_f17 + od_r9_f17 + od_r11_f17 + od_r13_f17 + od_r15_f17 + od_r17_f17 + od_r19_f17 + od_r21_f17 + od_r23_f17) from fac_mvrf_od_db where fmonth = '$val')+ (sum(cri_r2_f17 + cri_r4_f17 + cri_r6_f17 + cri_r8_f17 + cri_r10_f17 + cri_r12_f17 + cri_r14_f17 + cri_r16_f17 + cri_r18_f17 + cri_r20_f17 + cri_r22_f17 + cri_r24_f17 + oui_r2_f17 + oui_r4_f17 + oui_r6_f17 + oui_r8_f17 + oui_r10_f17 + oui_r12_f17 + oui_r14_f17 + oui_r16_f17 + oui_r18_f17 + oui_r20_f17 + oui_r22_f17 + oui_r24_f17)+(select sum(od_r2_f17 + od_r4_f17 + od_r6_f17 + od_r8_f17 + od_r10_f17 + od_r12_f17 + od_r14_f17 + od_r16_f17 + od_r18_f17 + od_r20_f17 + od_r22_f17 + od_r24_f17) from fac_mvrf_od_db where fmonth = '$val'))) as fullyimmunized, round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$year},{$month},{$year},{$month})::numeric,0) as target from fac_mvrf_db where fac_mvrf_db.fmonth = '$val' 
			";
		$res=$this -> db -> query($query) -> result_array();
		
		foreach($res as $key=>$value)
		{
			if($value['fullyimmunized']>0){
			//print_r($value);
			$res=(double)($value['fullyimmunized']*100)/(($value['target']*51/100)+($value['target']*49/100));
			$datares[] = array(
					"label"	=> $val,
					"value"	=>round($res)
				);
				;
			}	
		}
		$dataseries= json_encode($datares);
		
		$i++;
		}
		return $dataseries;
	}
		public function childprotectedbirth_data($year,$monthly,$quaterly)
	{
		if($monthly)
		{
			$startMonth=1;
			$endMonth=3;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}
		if($year && $monthly=false)
		{
			$startMonth=01;
			$endMonth=12;
			for($i=$startMonth;$i<=$endMonth;$i++)
			{
				$mon = sprintf("%02d", $i);
				$data['ym'][]="{$year}-{$mon}";
			}
		}	
		$i=0;	
		//$datares[]=null;
		foreach($data['ym'] as $key=>$val){
		$procode=$this->session->Province;
		$fmonth=explode('-',$val);
		$month=$fmonth[0];
		$query = "select (SUM(ttri_r1_f6)+SUM(ttri_r2_f6)+SUM(ttri_r3_f6)+SUM(ttri_r4_f6)+SUM(ttri_r5_f6)+SUM(ttri_r6_f6)+SUM(ttri_r7_f6)+SUM(ttri_r8_f6)+SUM(ttoui_r1_f6)+SUM(ttoui_r2_f6)+SUM(ttoui_r3_f6)+SUM(ttoui_r4_f6)+SUM(ttoui_r5_f6)+SUM(ttoui_r6_f6)+SUM(ttoui_r7_f6)+SUM(ttoui_r8_f6)) as cpb, round(getmonthlytarget_specificyearrsurvivinginfants('$procode'::text,'province'::text,{$year},{$month},{$year},{$month})::numeric,0) as target from fac_mvrf_db where fac_mvrf_db.fmonth = '$val' 
			";
		$res=$this -> db -> query($query) -> result_array();
		//print_r($res);
		foreach($res as $key=>$value)
		{
			
			if($value['cpb']>0){
			//print_r($value);
			$res=(double)($value['cpb']*100)/($value['target']);
			$datares[] = array(
					"label"	=> $val,
					"value"	=>round($res)
				);
				
			}
			else
			{
				$datares[] = array(
					"label"	=> $val,
					"value"	=>0
				);
			}
				
		}
		$dataseries= json_encode($datares);
		
		//$i++;
		}
		return $dataseries;
	}
}
?>