<?php
if( ! function_exists('getStockoutVaccines')){ 
	function getStockoutVaccines($vacc_ind=NULL,$createoptions=true,$fetchonlyselected=false){
		$CI = & get_instance();
		$CI -> db -> select('epi_items.pk_id as id,epi_items.description as name');
		$CI -> db -> from('epi_items');
		$CI -> db -> join('epi_item_pack_sizes',"epi_item_pack_sizes.item_id = epi_items.pk_id");
		$CI -> db -> where(array('activity_type_id' => 1,'status' => 1,'cr_table_row_numb !='=>NULL));
		if($fetchonlyselected){
			$CI -> db -> where('epi_items.pk_id',$vacc_ind);
		}
		$CI -> db -> group_by('epi_items.pk_id,epi_items.description,epi_item_pack_sizes.item_id');
		$result = $CI -> db -> get() -> result_array();
		if($createoptions){
			$option = '';
			foreach($result as $opt){
				$selected = (isset($vacc_ind) && $vacc_ind=="{$opt['id']}")?'selected="selected"':'';
				$option .= "
					<option {$selected} value=\"{$opt['id']}\">{$opt['name']}</option> ";
			}
			return $option;
		}
		return $result;
	}
}
if(!function_exists('sessionPlannedHeld')){
	function sessionPlannedHeld($rangeCondition,$uncode=NULL,$facode=NULL,$distcode=NULL,$procode=NULL){
		$CI = & get_instance();		
		if($procode){
			$rangeCondition .= " AND procode = '{$procode}'";
		}
		if($distcode)
		{			
			$rangeCondition .= " AND distcode = '{$distcode}'";		
		}		
		if($uncode)
		{			
			$rangeCondition .= " AND uncode = '{$uncode}'";		
		}		
		if($facode)
		{			
			$rangeCondition .= " AND facode = '{$facode}'"; 		
		}
		$query = "
				SELECT NULLIF(COALESCE(SUM(fixed_vacc_planned),0),0) AS fixedplanned,NULLIF(COALESCE(SUM(fixed_vacc_held),0),0) AS fixedheld,NULLIF(COALESCE(SUM(or_vacc_planned),0),0) AS outreachplanned,
						NULLIF(COALESCE(SUM(or_vacc_held),0),0) AS outreachheld,NULLIF(COALESCE(SUM(hh_vacc_planned),0),0) AS healthhouseplanned,NULLIF(COALESCE(SUM(hh_vacc_held),0),0) AS healthhouseheld
				FROM fac_mvrf_db
				WHERE {$rangeCondition}";
		$result = $CI -> db -> query($query) -> row();
		$result -> fixedConductedPerc = ($result -> fixedheld > 0 && $result -> fixedplanned>0)?round(($result -> fixedheld * 100)/$result -> fixedplanned):0;
		$result -> outreachConductedPerc = ($result -> outreachheld > 0 && $result -> outreachplanned>0)?round(($result -> outreachheld * 100)/$result -> outreachplanned):0;
		$result -> healthhouseConductedPerc = ($result -> healthhouseheld > 0 && $result -> healthhouseplanned>0)?round(($result -> healthhouseheld * 100)/$result -> healthhouseplanned):0;
		$result -> fixedSessionDropout = ($result -> fixedheld > 0 && $result -> fixedplanned>0)?round(($result -> fixedplanned - $result -> fixedheld) * 100/$result -> fixedplanned):0;
		$result -> outreachSessionDropout = ($result -> outreachheld > 0 && $result -> outreachplanned>0)?round(($result -> outreachplanned - $result -> outreachheld) * 100/$result -> outreachplanned):0;
		$result -> healthhouseSessionDropout = ($result -> healthhouseheld > 0 && $result -> healthhouseplanned>0)?round(($result -> healthhouseplanned - $result -> healthhouseheld) * 100/$result -> healthhouseplanned):0;
		return $result;
	}
}
if(!function_exists('vaccinationInNumbers')){
	function vaccinationInNumbers($rangeCondition,$uncode=NULL,$facode=NULL,$vaccineId=NULL,$vaccineBy=NULL,$distcode=NULL,$tcode=NULL,$arrayOrObjectResult = 'obj',$procode=NULL){
		$CI = & get_instance();
		$row = 1;
		$productsArray = array('bcg','hepb','opv0','opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv1','rota1','rota2','measles1','fullyimmunized','measles2','dtp','tcv','ipv2');
		$vaccinationByArray = array('f'=>'fixed','o'=>'outreach','m'=>'mobile','h'=>'healthhouse');
		if($vaccineBy && $vaccineBy!=''){
			$vaccinationByArray['f'] = $vaccinationByArray[$vaccineBy];
			$row=($vaccineBy == 'f')?1:$row;
			$row=($vaccineBy == 'o')?7:$row;
			$row=($vaccineBy == 'm')?13:$row;
			$row=($vaccineBy == 'h')?19:$row;
		}
		$ageArray = array('0to11m','12to23m','2yearsabove');
		$genderArray = array('male','female');
		$query = "SELECT ";
		if($vaccineId && $vaccineId>0)
			$productsArray[0] = $productsArray[$vaccineId-1];
		$col = (($vaccineId) && $vaccineId>0)?$vaccineId:1;
		foreach($productsArray as $pkey => $product){
			foreach($vaccinationByArray as $vbkey => $vaccinationBy){
				foreach($ageArray as $akey => $age){
					foreach($genderArray as $gkey => $gender){
						$query .= "SUM(cri_r{$row}_f{$col}) as {$product}_{$vaccinationBy}_{$age}_{$gender}, ";
						$row++;
					}
				}
				if($vaccineBy && $vaccineBy!='')
					break;
			}
			if($vaccineId>0)
				break;
			$col++;$row=1;
		}
		$query = rtrim($query,', ');
		$query .= " FROM fac_mvrf_db WHERE {$rangeCondition}";
		if($procode){
			$query .= " AND procode = '{$procode}'";
		}
		if($distcode){
			$query .= " AND distcode = '{$distcode}'";
		}
		if($tcode){
			$query .= " AND tcode = '{$tcode}'";
		}
		if($uncode){
			$query .= " AND uncode = '{$uncode}'";
		}
		if($facode){
			$query .= " AND facode = '{$facode}'";
		}
		if($arrayOrObjectResult == 'arr')
			$result = $CI -> db -> query($query) -> row_array();
		else
			$result = $CI -> db -> query($query) -> row();
		return $result;
	}
}
if(!function_exists('ttVaccinationInNumbers')){
	function ttVaccinationInNumbers($rangeCondition,$uncode=NULL,$facode=NULL,$vaccineId=NULL,$vaccineBy=NULL,$distcode=NULL,$tcode=NULL,$arrayOrObjectResult = 'obj',$procode = NULL){
		$CI = & get_instance();
		$row = 1;
		$productsArray = array('tt1','tt2','tt3','tt4','tt5');
		$vaccinationByArray = array('f'=>'fixed','o'=>'outreach','m'=>'mobile','h'=>'healthhouse');
		if($vaccineBy && $vaccineBy!=''){
			$vaccinationByArray['f'] = $vaccinationByArray[$vaccineBy];
			$row=($vaccineBy == 'f')?1:$row;
			$row=($vaccineBy == 'o')?3:$row;
			$row=($vaccineBy == 'm')?5:$row;
			$row=($vaccineBy == 'h')?7:$row;
		}
		$ageArray = array('pragnentwomen','nonpregnentwomen');
		$query = "SELECT ";
		if($vaccineId && $vaccineId>0)
			$productsArray[0] = $productsArray[$vaccineId-1];
		$col = (($vaccineId) && $vaccineId>0)?$vaccineId:1;
		foreach($productsArray as $pkey => $product){
			foreach($vaccinationByArray as $vbkey => $vaccinationBy){
				foreach($ageArray as $akey => $age){
					$query .= "SUM(ttri_r{$row}_f{$col}) as {$product}_{$vaccinationBy}_{$age}, ";
					$row++;
				}
				if($vaccineBy && $vaccineBy!='')
					break;
			}
			if($vaccineId>0)
				break;
			$col++;$row=1;
		}
		$query = rtrim($query,', ');
		$query .= " FROM fac_mvrf_db WHERE {$rangeCondition}";
		if($procode){
			$query .= " AND procode = '{$procode}'";
		}
		if($distcode){
			$query .= " AND distcode = '{$distcode}'";
		}
		if($tcode){
			$query .= " AND tcode = '{$tcode}'";
		}
		if($uncode){
			$query .= " AND uncode = '{$uncode}'";
		}
		if($facode){
			$query .= " AND facode = '{$facode}'";
		}
		if($arrayOrObjectResult == 'arr')
			$result = $CI -> db -> query($query) -> row_array();
		else
			$result = $CI -> db -> query($query) -> row();
		return $result;
	}
}
if(!function_exists('totalVaccinationInNumbers')){
	function totalVaccinationInNumbers($rangeCondition,$gender='both',$distcode=NULL,$tcode=NULL,$uncode=NULL,$facode=NULL,$vaccineId=NULL,$vaccineBy=NULL,$procode=NULL){
		$CI = & get_instance();
		$vaccinationByArray = array('f'=>'fixed','o'=>'outreach','m'=>'mobile','h'=>'healthhouse','t'=>'total');
		$productsArray = array(1=>'bcg',2=>'hepb',3=>'opv0',4=>'opv1',5=>'opv2',6=>'opv3',7=>'penta1',8=>'penta2',9=>'penta3',10=>'pcv1',11=>'pcv2',12=>'pcv3',13=>'ipv1',14=>'rota1',15=>'rota2',16=>'measles1',17=>'fullyimmunized',18=>'measles2',19=>'dtp',20=>'tcv',21=>'ipv2');
		if($vaccineId && $vaccineId>0){
			$productsArray[0] = $productsArray[$vaccineId];
			ksort($productsArray);
		}
		if($vaccineBy && $vaccineBy!='')
			$vaccinationByArray['f'] = $vaccinationByArray[$vaccineBy];
		$q = "select ";
		foreach($productsArray as $pkey => $product){
			if($vaccineId && $vaccineId>0)
				$pkey = $vaccineId;
			$m=$i=1;
			if($vaccineBy && $vaccineBy == 'f')
				$m=$i=1;
			else if($vaccineBy && $vaccineBy == 'o')
				$m=$i=7;
			else if($vaccineBy && $vaccineBy == 'm')
				$m=$i=13;
			else if($vaccineBy && $vaccineBy == 'h')
				$m=$i=19;
			foreach($vaccinationByArray as $key => $val){
				if($val=='total'){
					for($i;$i<=24;$i++){
						if($gender == "male" && $i%2 != 0)
							$q .= "sum(cri_r{$i}_f{$pkey})+";
						else if($gender == "female" && $i%2 == 0)
							$q .= "sum(cri_r{$i}_f{$pkey})+";
						else if($gender == 'both')
							$q .= "sum(cri_r{$i}_f{$pkey})+";
					}
				}else{
					for($m;$m<=24;$m++){
						if($gender == "male" && $m%2 != 0)
							$q .= "sum(cri_r{$m}_f{$pkey})+";
						else if($gender == "female" && $m%2 == 0)
							$q .= "sum(cri_r{$m}_f{$pkey})+";
						else if($gender == 'both')
							$q .= "sum(cri_r{$m}_f{$pkey})+";
						if($m%6==0){ break; }
					}
				}				
				$q = rtrim($q,'+');
				$q .= " as {$product}_{$val}_{$gender}, ";
				$m++;
				if($vaccineBy && $vaccineBy!='')
					break;
			}
			if($vaccineId>0)
				break;
		}
		$q = rtrim($q,', ');
		$q .= " FROM fac_mvrf_db WHERE {$rangeCondition}";
		if($procode){
			$q .= " AND procode = '{$procode}'";
		}
		if($distcode){
			$q .= " AND distcode = '{$distcode}'";
		}
		if($tcode){
			$q .= " AND tcode = '{$tcode}'";
		}
		if($uncode){
			$q .= " AND uncode = '{$uncode}'";
		}
		if($facode){
			$q .= " AND facode = '{$facode}'";
		}
		//print_r($q);exit;
		$result = $CI -> db -> query($q) -> row();
		return $result;
	}
}
if(!function_exists('monthlyVaccinationAndCoverageTrendfor_a_Vaccine')){
	function monthlyVaccinationAndCoverageTrendfor_a_Vaccine($year,$vaccineId=NULL,$distcode=NULL,$tcode=NULL,$uncode=NULL,$facode=NULL,$procode=NULL){
		$CI = & get_instance();
		$query = "SELECT fmonth,";
		$code = 3;
		$type = "Province";
		if($procode){
			$code = $procode;
			$type = 'province';
		}
		if($distcode){
			$code = $distcode;
			$type = 'district';
		}
		if($tcode){
			$code = $tcode;
			$type = 'tehsil';
		}
		if($uncode){
			$code = $uncode;
			$type = 'unioncouncil';
		}
		if($facode){
			$code = $facode;
			$type = 'facility';
		}
		if($vaccineId == NULL){
			for($u=1;$u<=21;$u++){
				//---------- for All vaccine
				//if($u==14 || $u==15 || $u==17){ continue;}
				//if($u==17){ $u=18;}
				if(in_array($u,array(1,2,3))){
					$query .= "getmonthlynewborn_targetpopulationpop('{$code}','{$year}')::double precision";
				}
				else if(in_array($u,array(4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21))){
					//$query .= "getmonthly_survivinginfantspop('{$code}','{$type}','{$year}')::double precision";
					$query .= "getmonthly_survivinginfantspop('{$code}','{$type}','{$year}')::double precision";
				}
				$query .= " as a{$u}_target,";
				for($i=1;$i<=24;$i++){
					$query .= "SUM(cri_r{$i}_f{$u})+"; 
				}
				$query = rtrim($query,'+');
				$query .= " as a{$u}_vaccine,";
			}
			$query = rtrim($query,',');
			$query .= " 
					FROM fac_mvrf_db WHERE fmonth LIKE '{$year}-%' ";
		}
		else{
			if($vaccineId=="TT1-TT2"){ 
				////------- for fullyimmunized vaccine
				for($u=1;$u<=5;$u++){
					$query .= "getyearly_plwomen_targetpop('{$code}','{$year}')::double precision";
					$query .= " as TT{$u}_target,";
					for($i=1;$i<=8;$i++){
						$query .= "SUM(ttri_r{$i}_f{$u})+";
					}
					$query = rtrim($query,'+');
					$query .= " as TT{$u}_vaccine,";
				}
				$query = rtrim($query,',');
				$query .= "
						FROM fac_mvrf_db WHERE fmonth LIKE '{$year}-%' ";
			}else{
				// -------for one vaccine at a time 
				if(in_array($vaccineId,array(1,2,3))){
					$query .= "getmonthlynewborn_targetpopulationpop('{$code}','{$year}')::double precision as target,";
				}else if(in_array($vaccineId,array(4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21))){
					$query .= "getmonthly_survivinginfantspop('{$code}','{$type}','{$year}')::double precision as target,";
				}
				for($i=1;$i<=24;$i++){
					$query .= "SUM(cri_r{$i}_f{$vaccineId})+";
				}
				$query = rtrim($query,'+');
				$query .= "AS monthlyvacc 
						FROM fac_mvrf_db WHERE fmonth LIKE '{$year}-%' ";
			}
		}
		/* if(in_array($vaccineId,array(1,2,3,13))){
			$query .= "getmonthlynewborn_targetpopulationpop('{$code}','{$year}')::double precision as target,";
		}else if(in_array($vaccineId,array(4,5,6,7,8,9,10,11,12,14,15,16,18))){
			$query .= "getmonthly_survivinginfantspop('{$code}','{$type}','{$year}')::double precision as target,";
		}
		for($i=1;$i<=24;$i++){
			$query .= "SUM(cri_r{$i}_f{$vaccineId})+";
		} */
		
		if($procode){
			$query .= " AND procode = '{$procode}'";
		}
		if($distcode){
			$query .= " AND distcode = '{$distcode}'";
		}
		if($tcode){
			$query .= " AND tcode = '{$tcode}'";
		}
		if($uncode){
			$query .= " AND uncode = '{$uncode}'";
		}
		if($facode){
			$query .= " AND facode = '{$facode}'";
		}
		$query .= " GROUP BY fmonth ORDER BY fmonth ASC";
		//print_r($query);exit;
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
//consumptionID now according to new consumption table
 if(!function_exists('getConsumptionVaccineId_bySendingEPI_VaccinationID'))
{
	function getConsumptionVaccineId_bySendingEPI_VaccinationID($id)
	{
		if($id == 1){
			return '5-20';
		}else if($id == 2){
			return '1-10';
		}else if(in_array($id,array(13,21))){
			return '4-10';
		}else if(in_array($id,array(3,4,5,6))){
			return '2-20';
		}else if(in_array($id,array(7,8,9))){
			return '7-1';
		}else if(in_array($id,array(10,11,12))){
			return '8-2';
		}else if(in_array($id,array(14,15))){
			return '12-1';
		}else if(in_array($id,array(16,17,18))){
			return '9-10';
		}else if($id == 20){
			return '92-1';
		}else{
			return '0-0';
		}
	}
}
/*  if(!function_exists('getConsumptionVaccineId_bySendingEPI_VaccinationID'))
{
	function getConsumptionVaccineId_bySendingEPI_VaccinationID($id)
	{
		if($id == 1){
			return '1-20';
		}else if($id == 2){
			return '10-10';
		}else if($id == 13){
			return '11-10';
		}else if(in_array($id,array(3,4,5,6))){
			return '3-20';
		}else if(in_array($id,array(7,8,9))){
			return '4-1';
		}else if(in_array($id,array(10,11,12))){
			return '5-2';
		}else if(in_array($id,array(14,15))){
			return '18-1';
		}else if(in_array($id,array(16,17,18))){
			return '6-10';
		}else{
			return '0-0';
		}
	}
} */
/* if(!function_exists('monthlyOpenVial_wastageRateTrend'))
{
	function monthlyOpenVial_wastageRateTrend($vaccineId,$doses,$distcode=null,$uncode=null,$year,$procode=NULL)
	{
		$CI = & get_instance();		
		$code = "procode";		
		$wc = "";		
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}		
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(openvial_wastagerate(cr.fmonth,cr.$code,{$vaccineId},{$doses})::numeric) as wastage
					FROM 
						form_b_cr cr 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc and  character_length(cr.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
} */
//for new consumption table 
if(!function_exists('monthlyOpenVial_wastageRateTrend'))
{
	function monthlyOpenVial_wastageRateTrend($consumptionId,$vaccineId,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();		
		$code = "procode";		
		$wc = "";		
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}		
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(openvial_wastagerate(master.fmonth,master.$code,{$consumptionId},{$vaccineId})::numeric) as wastage
					 FROM 
						epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id 
					WHERE item_id=$consumptionId and fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc and  character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
}
/* if(!function_exists('monthlyClosedVial_wastageRateTrend'))
{
	function monthlyClosedVial_wastageRateTrend($vaccineId,$doses,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();
		$code = "procode";
		$wc = "";
		if($procode){
			$code = "procode";
			$wc = " and procode='{$procode}'";
		}
		if($distcode){
			$code = "distcode";
			$wc = " and distcode='{$distcode}'";
		}
		if($uncode){
			$code = "uncode";
			$wc = " and uncode='{$uncode}'";
		}
		$query = "
				SELECT fmonth,
						ROUND(closedvials_wastagerate(cr.fmonth,cr.$code,{$vaccineId},{$doses})::numeric) as wastage
					FROM 
						form_b_cr cr 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(cr.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
} */
//for consumption master new consumption format :change here 
if(!function_exists('monthlyClosedVial_wastageRateTrend'))
{
	function monthlyClosedVial_wastageRateTrend($consumptionId,$dosespervial,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();
		$code = "procode";
		$wc = "";
		if($procode){
			$code = "procode";
			$wc = " and procode='{$procode}'";
		}
		if($distcode){
			$code = "distcode";
			$wc = " and distcode='{$distcode}'";
		}
		if($uncode){
			$code = "uncode";
			$wc = " and uncode='{$uncode}'";
		}
		$query = "SELECT fmonth,
						ROUND(closedvials_wastagerate(master.fmonth,master.$code,{$consumptionId},{$dosespervial})::numeric) as wastage
					    FROM 
						epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id 
					WHERE item_id=$consumptionId  and fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc and  character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
}
if(!function_exists('monthlyVaccineWastageRateTrend'))
{
	function monthlyVaccineWastageRateTrend($consumptionId,$vaccineId,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();				
		$code = "procode";
		$wc = "";
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}		
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(vaccine_wastagerate(master.fmonth,master.$code,{$consumptionId},{$vaccineId})::numeric) as wastage
					FROM 
						epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id  
					WHERE item_id=$consumptionId and fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
}
/* if(!function_exists('monthlyVaccineWastageRateTrend'))
{
	function monthlyVaccineWastageRateTrend($vaccineId,$doses,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();				
		$code = "procode";		
		$wc = "";
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}		
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(vaccine_wastagerate(cr.fmonth,cr.$code,{$vaccineId},{$doses})::numeric) as wastage
					FROM 
						form_b_cr cr 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(cr.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
} */
/* if(!function_exists('monthlyVaccineUsageRateTrend'))
{
	function monthlyVaccineUsageRateTrend($vaccineId,$doses,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();
		$code = "procode";
		$wc = "";
		if($procode){
			$code = "procode";
			$wc = " and procode='{$procode}'";
		}
		if($distcode){
			$code = "distcode";
			$wc = " and distcode='{$distcode}'";
		}
		if($uncode){
			$code = "uncode";
			$wc = " and uncode='{$uncode}'";
		}
		$query = "
				SELECT fmonth,
						ROUND(vaccine_usagerate(cr.fmonth,cr.$code,{$vaccineId},{$doses})::numeric) as usage
					FROM 
						form_b_cr cr 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(cr.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
} */
//set it according to new consumption form format :omer
//test query as well.
if(!function_exists('monthlyVaccineUsageRateTrend'))
{
	function monthlyVaccineUsageRateTrend($consumptionId,$dosespervial,$distcode=NULL,$uncode=NULL,$year,$procode=NULL)
	{
		$CI = & get_instance();
		$code = "procode";
		$wc = "";
		if($procode){
			$code = "procode";
			$wc = " and procode='{$procode}'";
		}
		if($distcode){
			$code = "distcode";
			$wc = " and distcode='{$distcode}'";
		}
		if($uncode){
			$code = "uncode";
			$wc = " and uncode='{$uncode}'";
		}
		$query = "
				SELECT fmonth,
						ROUND(vaccine_usagerate(master.fmonth,master.$code,{$consumptionId},{$dosespervial})::numeric) as usage
					FROM 
						epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id 
					WHERE  item_id =$consumptionId and fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
if(!function_exists('getMonthlyVaccineTarget'))
{
	function getMonthlyVaccineTarget($code,$type,$year,$vaccine)
	{
		$CI = & get_instance();
		if(in_array($vaccine,array(1,2,3))){
			$query = "SELECT getmonthly_newbornpop('{$code}','{$type}','{$year}') as target";
		}else{
			$query = "SELECT getmonthly_survivinginfantspop('{$code}','{$type}','{$year}') as target";
		}
		//print_r($query);exit;
		$result = $CI -> db -> query($query) -> row();
		return $result;
	}	
}
if(!function_exists('dropoutRateTrend'))
{
	function dropoutRateTrend($year,$distcode=NULL,$uncode=NULL,$dropoutType,$procode=NULL)
	{
		$CI = & get_instance();				
		$code = "procode";
		$wc = "";
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}		
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(monthly_dropout_rate(master.fmonth,master.$code,'{$dropoutType}')::numeric) as dropout
					FROM 
						fac_mvrf_db  master 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth"; 
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
}
//change it here as well form_b_cr to consumption
if(!function_exists('sessionDropoutRateTrend'))
{
	function sessionDropoutRateTrend($year,$distcode=NULL,$uncode=NULL,$sessionType,$procode=NULL)
	{
		$CI = & get_instance();				
		$code = "procode";		
		$wc = "";		
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(sessions_dropout_rate(master.fmonth,master.$code,'{$sessionType}')::numeric) as dropout
					 FROM 
						fac_mvrf_db  master 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(master.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
}

/* if(!function_exists('sessionDropoutRateTrend'))
{
	function sessionDropoutRateTrend($year,$distcode=NULL,$uncode=NULL,$sessionType,$procode=NULL)
	{
		$CI = & get_instance();				
		$code = "procode";		
		$wc = "";		
		if($procode){			
			$code = "procode";			
			$wc = " and procode='{$procode}'";		
		}
		if($distcode){			
			$code = "distcode";			
			$wc = " and distcode='{$distcode}'";		
		}
		if($uncode){			
			$code = "uncode";			
			$wc = " and uncode='{$uncode}'";		
		}
		$query = "
				SELECT fmonth,
						ROUND(sessions_dropout_rate(cr.fmonth,cr.$code,'{$sessionType}')::numeric) as dropout
					FROM 
						form_b_cr cr 
					WHERE fmonth BETWEEN '{$year}-01' and '{$year}-12' $wc AND character_length(cr.fmonth) = 7 
					GROUP BY fmonth,$code 
					ORDER BY fmonth";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}	
} */
if(!function_exists('weeklyTrendforZeroReports')){
	function weeklyTrendforZeroReports($year,$distcode=NULL,$tcode=NULL,$uncode=NULL,$facode=NULL,$procode=NULL){
		$CI = & get_instance();
		$wc = ""; 
		if($distcode){
			$query = "
					SELECT fweek,zero_report_submitted_rate(fweek,distcode) as completed_prct,zero_report_timely_submitted_rate(fweek,distcode) as timely_prct
					from
						zero_report where ";
			$query .= " distcode='$distcode' and ";
			$query .= 
				" fweek like '$year-%' 
					group by fweek,distcode order by fweek";
		}
		if($uncode){			
			$query = "
					SELECT fweek,zero_report_submitted_rate(fweek,unioncouncil.uncode) as completed_prct,zero_report_timely_submitted_rate(fweek,unioncouncil.uncode) as timely_prct
						from 
							zero_report 
					join unioncouncil on zero_report.distcode=unioncouncil.distcode 
					where unioncouncil.uncode='$uncode' and fweek like '$year-%' 
					group by fweek,unioncouncil.uncode order by fweek";
		}
		if($procode){
			$query = "
					SELECT fweek,zero_report_submitted_rate(fweek,procode) as completed_prct,zero_report_timely_submitted_rate(fweek,procode) as timely_prct
					from
						zero_report where ";
			$query .= " procode='$procode' and ";
			$query .= 
				" fweek like '$year-%' 
					group by fweek,procode order by fweek";
		}
		//echo $query;exit;
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
if(!function_exists('vaccineName')){
	function vaccineName($int){
		switch($int){
			case "1":
				$var = "'seriesname':'BCG','color':'#0000FF'";
				break;
			case "2":
				$var = "'seriesname':'Hep B-Birth','color':'#FF0000'";
				break;
			case "3":
				$var = "'seriesname':'OPV-0','color':'#FFFF00'";
				break;
			case "4":
				$var = "'seriesname':'OPV-1','color':'#FFFF00'";
				break;
			case "5":
				$var = "'seriesname':'OPV-2','color':'#0000FF'";
				break;
			case "6":
				$var = "'seriesname':'OPV-3','color':'#008000'";
				break;
			case "7":
				$var = "'seriesname':'PENTA-1','color':'#0000FF'";
				break;
			case "8":
				$var = "'seriesname':'PENTA-2','color':'#FFFF00'";
				break;
			case "9":
				$var = "'seriesname':'PENTA-3','color':'#FF0000'";
				break;
			case "10":
				$var = "'seriesname':'PCV10-1','color':'#FF0000'";
				break;
			case "11":
				$var = "'seriesname':'PCV10-2','color':'#008000'";
				break;
			case "12":
				$var = "'seriesname':'PCV10-3','color':'#FFFF00'";
				break;
			case "13":
				$var = "'seriesname':'IPV-1','color':'#0000FF'";
				break;
			case "14":
				$var = "'seriesname':'Rota-1','color':'#008000'";
				break;
			case "15":
				$var = "'seriesname':'Rota-2','color':'#FF0000'"; 
				break;
			case "16":
				$var = "'seriesname':'MR-I','color':'#FFFF0'";
				break;
			case "17":
				$var = "'seriesname':'Fully Immunized','color':''";
				break;
			case "18":
				$var = "'seriesname':'MR-II','color':'#008000'";
				break;
			case "tt1_vaccine":
				$var = "'seriesname':'TT-1','color':'#0000FF'";
				break;
			case "tt2_vaccine":
				$var = "'seriesname':'TT-2','color':'#FF0000'";
				break;
			case "tt3_vaccine":
				$var = "'seriesname':'TT-3','color':'#FFFF00'";
				break;
			case "tt4_vaccine":
				$var = "'seriesname':'TT-4','color':'#008000'";
				break;
			case "tt5_vaccine":
				$var = "'seriesname':'TT-5','color':'0000CD'";
				break;
			case "19":
				$var = "'seriesname':'DTP','color':'#008000'";
				break;
			case "20":
				$var = "'seriesname':'TCV','color':'#FFFF0'";
				break;
			case "21":
				$var = "'seriesname':'IPV-2','color':'#19191a'";
				break;
		}
	return $var;
	}
}

if(!function_exists('RankingWiseColour')){
	function RankingWiseColour($vaccId=NULL){  // colors scheme green 0B7546 yellow EBB035 red DD1E2F
		//for KP/CRES new item id convert to old item id to get rankwise color.
			$vacc_id=getVaccines_id($vaccId);
			$vacc_id="cr_r".$vacc_id."_f6";
		switch($vacc_id){
			
			case "cr_r1_f6": case "cr_r2_f6":
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '30'; 
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-30%';

					$dataClasses['dataClasses'][1]['from'] = '31';
					$dataClasses['dataClasses'][1]['to'] = '40';
					$dataClasses['dataClasses'][1]['color'] = '#3366ff';
					$dataClasses['dataClasses'][1]['name'] = '31-40%';
					
					$dataClasses['dataClasses'][2]['from'] = '41';
					$dataClasses['dataClasses'][2]['to'] = '50';
					$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
					$dataClasses['dataClasses'][2]['name'] = '41-50%';

					$dataClasses['dataClasses'][3]['from'] = '51';
					//$dataClasses['dataClasses'][2]['to'] = '';
					$dataClasses['dataClasses'][3]['color'] = '#e3330d';
					$dataClasses['dataClasses'][3]['name'] = '>50%';
				break;
			case "cr_r3_f6": case "cr_r9_f6": 
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '10.99';
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-10%';

					$dataClasses['dataClasses'][1]['from'] = '11';
					$dataClasses['dataClasses'][1]['to'] = '20.99';
					$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
					$dataClasses['dataClasses'][1]['name'] = '11-20%';

					$dataClasses['dataClasses'][2]['from'] = '20';
					$dataClasses['dataClasses'][2]['to'] = '1000';
					$dataClasses['dataClasses'][2]['color'] = '#e3330d';
					$dataClasses['dataClasses'][2]['name'] = '>20%';
				break;
			case "cr_r6_f6": case "cr_r7_f6":
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '5.99';
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-5%';

					$dataClasses['dataClasses'][1]['from'] = '6';
					$dataClasses['dataClasses'][1]['to'] = '10.99';
					$dataClasses['dataClasses'][1]['color'] = '#3366ff';
					$dataClasses['dataClasses'][1]['name'] = '6-10%';

					$dataClasses['dataClasses'][2]['from'] = '11';
					$dataClasses['dataClasses'][2]['to'] = '20.99';
					$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
					$dataClasses['dataClasses'][2]['name'] = '11-20%';
					
					$dataClasses['dataClasses'][3]['from'] = '20';
					$dataClasses['dataClasses'][3]['to'] = '1000';
					$dataClasses['dataClasses'][3]['color'] = '#e3330d';
					$dataClasses['dataClasses'][3]['name'] = '>20%';
				break;
			case "cr_r4_f6":
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '5.99';
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-5%';

					$dataClasses['dataClasses'][1]['from'] = '6';
					$dataClasses['dataClasses'][1]['to'] = '1000';
					$dataClasses['dataClasses'][1]['color'] = '#e3330d';
					$dataClasses['dataClasses'][1]['name'] = '>5%';
				break;
			case "cr_r5_f6": case "cr_r8_f6": case "cr_r11_f6":  case "cr_r10_f6": case "cr_r12_f6": case "cr_r13_f6": case "cr_r14_f6": case "cr_r15_f6": 
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '5.99';
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-5%';

					$dataClasses['dataClasses'][1]['from'] = '6';
					$dataClasses['dataClasses'][1]['to'] = '10.99';
					$dataClasses['dataClasses'][1]['color'] = '#f3e83a';
					$dataClasses['dataClasses'][1]['name'] = '6-10%';

					$dataClasses['dataClasses'][2]['from'] = '11';
					$dataClasses['dataClasses'][2]['to'] = '1000';
					$dataClasses['dataClasses'][2]['color'] = '#e3330d';
					$dataClasses['dataClasses'][2]['name'] = '>20%';
				break;
			default:
					$dataClasses['dataClasses'][0]["from"] = '0';
					$dataClasses['dataClasses'][0]["to"] = '10.99';
					$dataClasses['dataClasses'][0]["color"] = '#248E5F';
					$dataClasses['dataClasses'][0]["name"] = '0-10%';

					$dataClasses['dataClasses'][1]['from'] = '11';
					$dataClasses['dataClasses'][1]['to'] = '20.99';
					$dataClasses['dataClasses'][1]['color'] = '#31f8dd';
					$dataClasses['dataClasses'][1]['name'] = '11 to 20%';

					$dataClasses['dataClasses'][2]['from'] = '21';
					$dataClasses['dataClasses'][2]['to'] = '30.99';
					$dataClasses['dataClasses'][2]['color'] = '#f3e83a';
					$dataClasses['dataClasses'][2]['name'] = '21 to 30%';

					$dataClasses['dataClasses'][3]['from'] = '31';
					$dataClasses['dataClasses'][3]['to'] = '1000';
					$dataClasses['dataClasses'][3]['color'] = '#e3330d';
					$dataClasses['dataClasses'][3]['name'] = '30 and above';
				break;
		}
		return $dataClasses;
	}
}
if(!function_exists('getmonthlyTotalTarget')){
	function getmonthlyTotalTarget($code,$year,$month=NULL,$vaccineName=NULL){
		$CI = & get_instance();
		$newbornArrray = array('bcg','hepb','opv0');
		$surviningArrray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv1','rota1','rota2','measles1','fullyimmunized','measles2','dtp','tcv','ipv2');
		//$distcode = ($distcode!="")?$distcode:$this->session->District;
		$wc = "";
		$codee = "";
		$namee = "";
		$ss="s";
		if(strlen($code)=="1")
		{
			$wc .= "where procode = '{$code}'";
			$codee="procode";
			$namee = "province";
		}
		else if(strlen($code)=="3")
		{
			$wc .= "where distcode = '{$code}'";
			$codee="distcode";
			$namee = "district";
		}
		else
		{
			$wc .= "where uncode = '{$code}'";
			$codee="uncode";
			$namee = "unioncouncil";
			$ss = "";
		}
		if($month)
		{
			$monthfrom = $month;
			$monthto = $month;
		}
		else{
			$monthfrom = "01";
			$monthto = "12";
		}
		$query="
			select {$codee},
				round((getmonthlytarget_specificyearr({$codee}::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*51)/100) as \"New_Borns_Male\", 
				round((getmonthlytarget_specificyearr({$codee}::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*49)/100) as \"New_Borns_FeMale\",
				round((getmonthlytarget_specificyearr({$codee}::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*51)/100)+round((getmonthlytarget_specificyearr({$codee}::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*49)/100) as \"New_Borns_Total\",
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*51)/100) as \"Targeted_Male_Children\", 
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*49)/100) as \"Targeted_Female_Children\",
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*51)/100) + round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*49)/100) as \"Total_Target_childern\" ,
				round((getmonthly_plwomen_target_specificyears({$codee}::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)) as \"Targeted_Women\" 
				from {$namee}{$ss} tble $wc
			";
		$result = $CI -> db -> query($query) -> row_array();
		if (in_array($vaccineName, $surviningArrray))
		{
			$return['totalTarget'] = ($result['Total_Target_childern']!="")?$result['Total_Target_childern']:"0";
			$return['totalMaleTarget'] = ($result['Targeted_Male_Children']!="")?$result['Targeted_Male_Children']:"0";
			$return['totalFemaleTarget'] = ($result['Targeted_Female_Children']!="")?$result['Targeted_Female_Children']:"0";
		}elseif (in_array($vaccineName, $newbornArrray))
		{
			$return['totalTarget'] = ($result['New_Borns_Total']!="")?$result['New_Borns_Total']:"0";
			$return['totalMaleTarget']  = ($result['New_Borns_Male']!="")?$result['New_Borns_Male']:"0";
			$return['totalFemaleTarget'] = ($result['New_Borns_FeMale']!="")?$result['New_Borns_FeMale']:"0";
		}
		else
		{
			$return['totalTarget'] = ($result['Targeted_Women']!="")?$result['Targeted_Women']:"0";
			$return['totalMaleTarget'] = "0";
			$return['totalFemaleTarget'] = "0";print_r('Sorry Under Implementation');exit();
		}
		return $return;
	}
}
if(!function_exists('getmonthlyTotalTargetFromTo')){
	function getmonthlyTotalTargetFromTo($code,$fmonthfrom=NULL,$fmonthto=NULL,$vaccineName=NULL){
		$CI = & get_instance();
		$newbornArrray = array('bcg','hepb','opv0');
		$surviningArrray = array('opv1','opv2','opv3','penta1','penta2','penta3','pcv1','pcv2','pcv3','ipv1','rota1','rota2','measles1','fullyimmunized','measles2','dtp','tcv','ipv2');
		//$distcode = ($distcode!="")?$distcode:$this->session->District;
		$wc = "";
		$codee = "";
		$namee = "";
		$ss="s";
		if(strlen($code)=="1")
		{
			$wc .= "where procode = '{$code}'";
			$codee="procode";
			$namee = "province";
		}
		else if(strlen($code)=="3")
		{
			$wc .= "where distcode = '{$code}'";
			$codee="distcode";
			$namee = "district";
		}
		else
		{
			$wc .= "where uncode = '{$code}'";
			$codee="uncode";
			$namee = "unioncouncil";
			$ss = "";
		}
		$partsFrom = explode('-', $fmonthfrom);
		$yearfrom = $partsFrom[0];
		$monthfrom = $partsFrom[1];

		$partsTo = explode('-', $fmonthto);
		$yearto = $partsTo[0];
		$monthto = $partsTo[1];

		// if($month)
		// {
		// 	$monthfrom = $month;
		// 	$monthto = $month;
		// }
		// else{
		// 	$monthfrom = "01";
		// 	$monthto = "12";
		// }
		$query="
			SELECT {$codee},
				round((getmonthlytarget_specificyearr({$codee}::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric*51)/100) as \"New_Borns_Male\", 
				round((getmonthlytarget_specificyearr({$codee}::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric*49)/100) as \"New_Borns_FeMale\",
				round((getmonthlytarget_specificyearr({$codee}::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric*51)/100)+round((getmonthlytarget_specificyearr({$codee}::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric*49)/100) as \"New_Borns_Total\",
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric)*51)/100) as \"Targeted_Male_Children\", 
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric)*49)/100) as \"Targeted_Female_Children\",
				round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric)*51)/100) + round(((getmonthlytarget_specificyearrsurvivinginfants({$codee}::text,'{$namee}'::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric)*49)/100) as \"Total_Target_childern\" ,
				round((getmonthly_plwomen_target_specificyears({$codee}::text,{$yearfrom},{$monthfrom},{$yearto},{$monthto})::numeric)) as \"Targeted_Women\" 
				from {$namee}{$ss} tble $wc
			";
		$result = $CI -> db -> query($query) -> row_array();
		if (in_array($vaccineName, $surviningArrray))
		{
			$return['totalTarget'] = ($result['Total_Target_childern']!="")?$result['Total_Target_childern']:"0";
			$return['totalMaleTarget'] = ($result['Targeted_Male_Children']!="")?$result['Targeted_Male_Children']:"0";
			$return['totalFemaleTarget'] = ($result['Targeted_Female_Children']!="")?$result['Targeted_Female_Children']:"0";
		}elseif (in_array($vaccineName, $newbornArrray))
		{
			$return['totalTarget'] = ($result['New_Borns_Total']!="")?$result['New_Borns_Total']:"0";
			$return['totalMaleTarget']  = ($result['New_Borns_Male']!="")?$result['New_Borns_Male']:"0";
			$return['totalFemaleTarget'] = ($result['New_Borns_FeMale']!="")?$result['New_Borns_FeMale']:"0";
		}
		else
		{
			$return['totalTarget'] = ($result['Targeted_Women']!="")?$result['Targeted_Women']:"0";
			$return['totalMaleTarget'] = "0";
			$return['totalFemaleTarget'] = "0";print_r('Sorry Under Implementation');exit;
		}
		return $return;
	}
}
if(!function_exists('getmonthlyTotalTarget1')){
	function getmonthlyTotalTarget1($distcode,$year,$month,$procode=NULL){
		$CI = & get_instance();
		//$distcode = ($distcode!="")?$distcode:$this->session->District;
		$wc = "";
		if($procode){			
			$wc .= "where procode = '{$procode}'";		
		}
		if($distcode){			
			$wc .= "where distcode = '{$distcode}'";		
		}		
		/* if($uncode){			
			$wc .= " AND uncode = '{$uncode}'";		
		}	 */
		if($month==""){
			$monthfrom = "01";
			$monthto = "12";
		}else{
			$monthfrom = "01";
			$monthto = "01";
		}
		$query="
			select distcode, districtname(distcode), 
				round((getmonthlytarget_specificyearr(distcode::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*51)/100) as \"New_Borns_Male\", 
				round((getmonthlytarget_specificyearr(distcode::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*49)/100) as \"New_Borns_FeMale\",
				round((getmonthlytarget_specificyearr(distcode::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*51)/100)+round((getmonthlytarget_specificyearr(distcode::text,{$year},{$monthfrom},{$year},{$monthto})::numeric*49)/100) as \"New_Borns_Total\",
				round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*51)/100) as \"Targeted_Male_Children\", 
				round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*49)/100) as \"Targeted_Female_Children\",
				round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*51)/100) + round(((getmonthlytarget_specificyearrsurvivinginfants(distcode::text,'district'::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)*49)/100) as \"Total_Target_childern\" ,
				round((getmonthly_plwomen_target_specificyears(distcode::text,{$year},{$monthfrom},{$year},{$monthto})::numeric)) as \"Targeted_Women\" 
				from districts dist $wc
			";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
if(!function_exists('getPLW_CBAs')){
	function getPLW_CBAs(){
		$CI = & get_instance();
		
		$query="
			";
		$result = $CI -> db -> query($query) -> result_array();
		return $result;
	}
}
if( ! function_exists('getActiveVaccinesOptions')){
	function getActiveVaccinesOptions($vacc_ind=NULL,$indicatorID=NULL){
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('epi_item_pack_sizes');
		$CI -> db -> where(array('activity_type_id' => 1,'status' => 1));
		if($indicatorID == '54' || $indicatorID == '55')
			$CI -> db -> where('item_category_id',1);
		$CI -> db -> order_by('list_rank','ASC');
		$result = $CI -> db -> get() -> result_array();
		$option = '';
		foreach($result as $opt){
			$selected = (isset($vacc_ind) && $vacc_ind=="cr_r{$opt['cr_table_row_numb']}_f6")?'selected="selected"':'';
			$option .= "
				<option {$selected} value=\"cr_r{$opt['cr_table_row_numb']}_f6\">{$opt['item_name']}</option> ";
		}
		return $option;
	}
}
if(!function_exists('getDiseaseName')){
	function getDiseaseName($id){
		$CI = & get_instance();
		if($id == 'all'){
			return ' for All Diseases';exit;
		}
		$query = "select * from idsrs_cases_types where id='$id' ";
		$resultt = $CI->db->query($query);
		return $resultt->row()->type_case_name;
	}
}
if( ! function_exists('getAllDiseasesOptions')){
	function getAllDiseasesOptions($diseaseId=NULL){
		$CI = & get_instance();
		$CI -> db -> select('*');
		$CI -> db -> from('surveillance_cases_types');
		$result = $CI -> db -> get() -> result_array();
		$option = '';
		foreach($result as $opt){
			$selected = (isset($diseaseId) && $diseaseId==$opt['short_name'])?'selected="selected"':'';
			$option .= "
				<option {$selected} value=\"{$opt['short_name']}\">{$opt['type_case_name']}</option> ";
		}
		return $option;
	}
} 
/* if( ! function_exists('getAllSpecimenResults')){
	function getAllSpecimenResults($diseaseId=NULL,$investigationResult=NULL){
		$option = "<option value='0'>--Select--</option>";
		if($diseaseId == 'Msl'){
			$option .= "
				<option value=\"Positive Measles\" ".(($investigationResult=='Positive Measles')?'selected="selected"':'').">Positive Measles</option>
				<option value=\"Negative Measles\" ".(($investigationResult=='Negative Measles')?'selected="selected"':'').">Negative Measles</option>
				<option value=\"Positive Rubella\" ".(($investigationResult=='Positive Rubella')?'selected="selected"':'').">Positive Rubella</option>
				<option value=\"Awaiting Result\" ".(($investigationResult=='Awaiting Result')?'selected="selected"':'').">Awaiting Result</option>
				<option value=\"Other\" ".(($investigationResult=='Other')?'selected="selected"':'').">Other</option>					
			";
			//<option value=\"Negative Rubella\">Negative Rubella</option>
		}else{
			$option .= "
				<option value=\"Positive\" ".(($investigationResult=='Positive')?'selected="selected"':'').">Positive</option>
				<option value=\"Negative\" ".(($investigationResult=='Negative')?'selected="selected"':'').">Negative</option>
				<option value=\"Other\" ".(($investigationResult=='Other')?'selected="selected"':'').">Other</option>					
			";
		}
		return <option value=\"Awaiting Result\" ".(($investigationResult=='Awaiting Result')?'selected="selected"':'').">Awaiting Result</option>
				$option;
	}
} */
if( ! function_exists('getAllSpecimenResults')){
	function getAllSpecimenResults($diseaseId=NULL,$investigationResult=NULL){
		$option = "<option value='0'>--Select--</option>";
		if($diseaseId == 'Msl'){
			$option .= "
				<option value=\"Positive Measles\" ".(($investigationResult=='Positive Measles')?'selected="selected"':'').">Positive Measles</option>
				<option value=\"Negative Measles\" ".(($investigationResult=='Negative Measles')?'selected="selected"':'').">Negative Measles</option>
				<option value=\"Positive Rubella\" ".(($investigationResult=='Positive Rubella')?'selected="selected"':'').">Positive Rubella</option>
				<option value=\"Awaiting Result\" ".(($investigationResult=='Awaiting Result')?'selected="selected"':'').">Awaiting Result</option>
				<option value=\"Other\" ".(($investigationResult=='Other')?'selected="selected"':'').">Other</option>					
			";
			//<option value=\"Negative Rubella\">Negative Rubella</option>
		}else{
			$option .= "
				<option value=\"Positive\" ".(($investigationResult=='Positive')?'selected="selected"':'').">Positive</option>
				<option value=\"Negative\" ".(($investigationResult=='Negative')?'selected="selected"':'').">Negative</option>
				<option value=\"Other\" ".(($investigationResult=='Other')?'selected="selected"':'').">Other</option>					
			";
		}
		return $option;
	}
}
if( ! function_exists('getstockoutRankColor')){
	function getstockoutRankColor($value){
		$value = (int)$value;
		$colorcode = "#808080";
		switch($value){
			case 0:
				$colorcode = "#248e5f";
				break;
			case ($value>0 && $value<=10):
				$colorcode = "#248e5f";
				break;
			case ($value>10 && $value<=20):
				$colorcode = "#31f8dd";
				break;
			case ($value>20 && $value<=30):
				$colorcode = "#f3e83a";
				break;
			case ($value>30 && $value<=100):
				$colorcode = "#e3330d";
				break;
			default:
				$colorcode = "#808080";
				break;
		}
		return $colorcode;
	}
}
?>