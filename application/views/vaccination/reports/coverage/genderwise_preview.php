<?php 
if($TopInfo!=''){
    echo $TopInfo;
}
//echo getReportTable($result);
//$this->load->view("vaccination/reports/coverage/tabledata",["tabledata"=>$result]);  
?>
<div id="parent" style="overflow:auto">
	<table id="fixTable" class="table table-bordered table-hover table-striped">
		<thead>				
			<tr>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width: 56px;" rowspan="3">S No.</th>
				<?php if(!isset($inucresult[0]['uncode']) && isset($inucresult[0]['distcode'])) {
					$codecolumn = "distcode"; ?>
	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Distcode</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">District</th>
				<?php } else if(isset($inucresult[0]['tcode'])) {?>
	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Tehsil Code</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Tehsil Name</th>
	   				<?php } else if(isset($inucresult[0]['uncode'])) {
	   					$codecolumn = "uncode"; ?>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:100px;" rowspan="3">Uncode</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width: 207px;" rowspan="3">UnionCouncil</th>
				<?php } else { ?>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:100px;" rowspan="3">EPI Center Code</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width: 207px;" rowspan="3">EPI Center</th>
				<?php } ?>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">Target</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">BCG</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">HEP B</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="16">OPV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="12">Pentavalent</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="12">PCV 10</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">IPV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="8">Rota</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">Measles</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="4">Fully Immunized</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">Measles</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="7">TT Pregnant Women</th>							
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">TT Non-Pregnant Women (15-49 Years)</th>
			</tr>
			<tr>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2" style="min-width: 78px;">Newborns</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Surviving Infants</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="women" style="width: 74px;height: 38px;" > &nbsp;</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">0</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">V</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">I</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">II</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">III</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">IV</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">V</th>
			</tr>
			<tr>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" id="women3"> &nbsp;PLW</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Doses</th>
				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th>
			</tr>
		</thead>
		<tbody>  
			<?php
				//print_r($inucresult);
				unset($inucresult['TopInfo']);
				unset($inucresult['exportIcons']);
				$outuctotalcounts = array_column($outucresult,'total','uniquecol');
				$outucmaletotalcounts = array_column($outucresult,'maletotal','uniquecol');
				$outucfemaletotalcounts = array_column($outucresult,'femaletotal','uniquecol');
				$outucpregcounts = array_column($outucresult,'totalpregnant','uniquecol');
				$outucnonpregcounts = array_column($outucresult,'totalnonpregnant','uniquecol');
				//male keys
				$malekeys = array("mbcg","mhep","mopv_o","mopv_on","mopv_tw","mopv_th","mpen_o","mpen_tw","mpen_th","mpc_o","mpc_tw","mpc_th","mip_o","mrota_on","mrota_tw","mmea_o","mfully_immunized","mmea_tw");
				//female keys
				$femalekeys = array("fbcg","fhep","fopv_o","fopv_on","fopv_tw","fopv_th","fpen_o","fpen_tw","fpen_th","fpc_o","fpc_tw","fpc_th","fip_o","frota_on","frota_tw","fmea_o","ffully_immunized","fmea_tw");
				//TT Preg keys
				$ttpregkeys = array("pwtotal_ttpl1"=>"tt_o","pwtotal_ttpl2"=>"tt_tw","total_ttpl3"=>"tt_th","total_ttpl4"=>"tt_fo","total_ttpl5"=>"tt_fi");
				//TT Non Preg keys
				$ttnonpregkeys = array("total_ttnonpl1"=>"tt_o","total_ttnonpl2"=>"tt_on","total_ttnonpl3"=>"tt_th","total_ttnonpl4"=>"tt_fo","total_ttnonpl5"=>"tt_fi");
				//percentage new born male keys
				$percentagenewbornm = array("percmbcg","percmhep","percmopv_o");
				//percentage new born female keys
				$percentagenewbornf = array("percfbcg","percfhep","percfopv_o");
				//percentage surviving male keys
				$percentagesurvivingm = array("percmopv_on","percmopv_tw","percmopv_th","percmpen_o","percmpen_tw","percmpen_th","percmpc_o","percmpc_tw","percmpc_th","percmip_o","percmrota_on","percmrota_tw","percmmea_o","percmmea_tw","percmfully_immunized");
				//percentage surviving female keys
				$percentagesurvivingf = array("percfopv_on","percfopv_tw","percfopv_th","percfpen_o","percfpen_tw","percfpen_th","percfpc_o","percfpc_tw","percfpc_th","percfip_o","percfrota_on","percfrota_tw","percfmea_o","percfmea_tw","percffully_immunized");
				//percentage women keys
				$percentagewomen = array("pwperctotal_ttpl1","pwperctotal_ttpl2");
				$count = 1;$pervKey=0;$codecolumn="";$total=array();
				foreach($inucresult as $val)
				{
					$fullrow = $val;
					$inlinetdstyle = "style='text-align:center; border: 1px solid black;' class='text-center'";
					echo "<tr class='DrillDownRow'>
						<td $inlinetdstyle>".$count."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo implode("</td><td style='text-align:center; border: 1px solid black;' class=\"text-red\">",array_map(function($v,$k) use(&$pervKey,&$codecolumn,$outucmaletotalcounts,$outucfemaletotalcounts,$malekeys,$femalekeys,$ttpregkeys,$ttnonpregkeys,$percentagenewbornm,$percentagenewbornf,$percentagesurvivingm,$percentagesurvivingf,$percentagewomen,&$fullrow,&$total){
							if($k == "distcode" || $k == "facode" || $k == "uncode" || $k == "tcode"){
								$codecolumn = $k;
							}else if($k == "districtname" || $k == "facilityname" || $k == "unname" || $k == "tehsilname"){
								
							}else{
								//to create/update total row
								if(key_exists($k,$total))
								{
									//if(is_numeric($total[$k])){
										$total[$k] += is_numeric($v)?$v:0;
									//}
									//$total[$k] = $total[$k];
								}
								else
									$total[$k] = is_numeric($v)?$v:0;
								//add male columns value from data shared by other ucs
								if(in_array($k,$malekeys)){
									if(isset($outucmaletotalcounts[$fullrow[$codecolumn].ltrim($k,'m')])){
										$v = $v+$outucmaletotalcounts[$fullrow[$codecolumn].ltrim($k,'m')];
									}
								}
								//add female columns value from data shared by other ucs
								if(in_array($k,$femalekeys)){
									if(isset($outucfemaletotalcounts[$fullrow[$codecolumn].ltrim($k,'f')])){
										$v = $v+$outucfemaletotalcounts[$fullrow[$codecolumn].ltrim($k,'f')];
									}							
								}
								//add TT Preg columns value from data shared by other ucs
								if(key_exists($k,$ttpregkeys)){
									if(isset($outucpregcounts[$fullrow[$codecolumn].$ttpregkeys[$k]])){
										$v = $v+$outucfemaletotalcounts[$fullrow[$codecolumn].$ttpregkeys[$k]];
									}							
								}
								//add TT Non Preg columns value from data shared by other ucs
								if(key_exists($k,$ttnonpregkeys)){
									if(isset($outucnonpregcounts[$fullrow[$codecolumn].$ttnonpregkeys[$k]])){
										$v = $v+$outucfemaletotalcounts[$fullrow[$codecolumn].$ttnonpregkeys[$k]];
									}							
								}
								//calculate percentage of male newborns
								if(in_array($k,$percentagenewbornm)){
									if($fullrow["New Borns Male"]>0){
										$v = round(($fullrow[$pervKey]*100/$fullrow["New Borns Male"]),0);
									}
									if($total["New Borns Male"]>0){
										$total[$k] = round(($total[$pervKey]*100/$total["New Borns Male"]),0);
									}
								}
								//calculate percentage of female newborns
								if(in_array($k,$percentagenewbornf)){
									if($fullrow["New Borns FeMale"]>0){
										$v = round(($fullrow[$pervKey]*100/$fullrow["New Borns FeMale"]),0);
									}
									if($total["New Borns FeMale"]>0){
										$total[$k] = round(($total[$pervKey]*100/$total["New Borns FeMale"]),0);
									}								
								}
								//calculate percentage of male newborns
								if(in_array($k,$percentagesurvivingm)){
									if($fullrow["Targeted_Male_Children"]>0){
										$v = round(($fullrow[$pervKey]*100/$fullrow["Targeted_Male_Children"]),0);
									}
									if($total["Targeted_Male_Children"]>0){
										$total[$k] = round(($total[$pervKey]*100/$total["Targeted_Male_Children"]),0);
									}								
								}
								//calculate percentage of female newborns
								if(in_array($k,$percentagesurvivingf)){
									if($fullrow["Targeted_Female_Children"]>0){
										$v = round(($fullrow[$pervKey]*100/$fullrow["Targeted_Female_Children"]),0);
									}
									if($total["Targeted_Female_Children"]>0){
										$total[$k] = round(($total[$pervKey]*100/$total["Targeted_Female_Children"]),0);
									}
								}
								//calculate percentage of female newborns
								if(in_array($k,$percentagewomen)){
									if($fullrow["Targeted_Women"]>0){
										$v = round(($fullrow[$pervKey]*100/$fullrow["Targeted_Women"]),0);
									}
									if($total["Targeted_Women"]>0){
										$total[$k] = round(($total[$pervKey]*100/$total["Targeted_Women"]),0);
									}
								}
								//to keep previous key
								$pervKey = $k;
								//to update values in original array
								$fullrow[$k] = $v;
							}
							if($v != '')
								return $v;
							return 0;
						},array_values($val), array_keys($val)));
						echo "</td></tr>";
					$count++;
				}
				echo "<tr style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td class='text-center' style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><strong> Total: </strong></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black; font-weight: bold;'>";
				echo implode("</td><td style='min-width:80px; background: #D3D3D3; width: 200; border: 1px solid black; font-weight: bold;' class=\"text-red\">",$total);
					echo "</td></tr>";
				/* $count = 1;
				unset($inucresult['TopInfo']);
				unset($inucresult['exportIcons']);
				$percentage   = array(
					"percmbcg","percfbcg","percmhep",
					"percfhep","percmopv_o","percfopv_o",
					"percmopv_on","percfopv_on","percmopv_tw",
					"percfopv_tw","percmopv_th","percfopv_th",
					"percmpen_o","percfpen_o","percmpen_tw",
					"percfpen_tw","percmpen_th","percfpen_th",			"percmpc_o","percfpc_o","percmpc_tw","percfpc_tw",
					"percmpc_th","percfpc_th","percmip_o","percfip_o",
					"percmmea_o","percfmea_o","percmmea_tw","percfmea_tw"
				);
				$total = array();
				$outuctotalcounts = array_column($outucresult,'total','uniquecol');
				$outucmaletotalcounts = array_column($outucresult,'maletotal','uniquecol');
				$outucfemaletotalcounts = array_column($outucresult,'femaletotal','uniquecol');
				$outucpregcounts = array_column($outucresult,'totalpregnant','uniquecol');
				$outucnonpregcounts = array_column($outucresult,'totalnonpregnant','uniquecol');
				$pregkeys = array("pwtotal_ttpl1"=>"tt_o","pwtotal_ttpl2"=>"tt_tw","total_ttpl3"=>"tt_th","total_ttpl4"=>"tt_fo","total_ttpl5"=>"tt_fi");
				$nonpregkeys = array("total_ttnonpl1"=>"tt_o","total_ttnonpl2"=>"tt_tw","total_ttnonpl3"=>"tt_th","total_ttnonpl4"=>"tt_fo","total_ttnonpl5"=>"tt_fi");
				//print_r($outucresult);exit;
				foreach($inucresult as $arraykey => $value)
				{
					$BCGMtarget=$arraykey['New Borns Male'];
					$BCGFtarget=$arraykey['New Borns FeMale'];
					$Mchildren=$arraykey['Targeted_Male_Children'];
					$Fchildren=$arraykey['Targeted_Female_Children'];
					$women=$arraykey['Targeted_Women'];
					$i=0;
					foreach($value as $key => $totalv)
					{
						if($key != "distcode" && $key != "districtname" && $key != "facode" && $key != "facilityname" && $key != "uncode" && $key != "unname" && $key != "tcode" && $key != "tehsilname"){
							if(!strstr($key,"perc")){
								//work to add data covered by other ucs
								if(key_exists($key,$pregkeys)){
									$arraytouse = $outucpregcounts;
									$uniquekey = $value[$codecolumn].$pregkeys[$key];
								}else if(key_exists($key,$nonpregkeys)){
									//$arraytouse = $outucnonpregcounts;
									$uniquekey = $value[$codecolumn].$nonpregkeys[$key];
								}else if($key[0]=='m'){
									$arraytouse = $outucmaletotalcounts;
									$uniquekey = $value[$codecolumn].ltrim($key,"m");
								}else if($key[0]=='f'){
									$arraytouse = $outucfemaletotalcounts;
									$uniquekey = $value[$codecolumn].ltrim($key,"f");
								}else{
									$arraytouse = $outuctotalcounts;
									$uniquekey = $value[$codecolumn].ltrim($key,"t");//mbcg
								}
								if(key_exists($uniquekey,$arraytouse)){
									//add values in array
									$inucresult[$arraykey][$key] = $inucresult[$arraykey][$key]+$arraytouse[$uniquekey];
									$totalv = $totalv+$arraytouse[$uniquekey];
								}
							}
							else{
								if($i==0 || $i==2 || $i==4){
									if($BCGMtarget == 0){
										$inucresult[$arraykey][$key] = 0;
									}
									else{
										$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$BCGMtarget),0);
									}
								}else if($i==1 || $i==3 || $i==5){
									if($BCGFtarget == 0){
										$inucresult[$arraykey][$key] = 0;
									}
									else{
										$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$BCGFtarget),0);
									}
								}else if($i<36){
									//echo $key;
									$targettodivide = 0;
									if($key[0]=='m'){
										$targettodivide = $Mchildren;
									}else if($key[0]=='f'){
										$targettodivide = $Fchildren;
									}
									
									if($targettodivide == 0){
										$inucresult[$arraykey][$key] = 0;
									}
									else{
										$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$targettodivide),0);
									}
								}else{
									if($women == 0){
										$inucresult[$arraykey][$key] = 0;
									}
									else{
										$inucresult[$arraykey][$key] = round(($inucresult[$arraykey][$pervKey]*100/$women),0);
									}	
								}
								$i++;
							}
							$pervKey = $key;
							if(key_exists($key,$total))
							{
								$total[$key] += $totalv;
							}
							else
								$total[$key] = $totalv;
						}
					}
				}
				//if( isset($total['Total New Borns']) && (! (($total['Total New Borns'] == 0) AND ($total['Total_Targeted_Children'] == 0) )))
				if( ! (($total['New Borns Male'] == 0) AND ($total['New Borns FeMale'] == 0) AND ($total['Targeted_Male_Children'] == 0) AND ($total['Targeted_Female_Children'] == 0) ))
				{
					$BCGMtarget=$total['New Borns Male'];
					$BCGFtarget=$total['New Borns FeMale'];
					$Mchildren=$total['Targeted_Male_Children'];
					$Fchildren=$total['Targeted_Female_Children'];
					$women=$total['Targeted_Women'];
					$i=1;
					$perccolumns=array(7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49,51,53,55,57,59,61,63,65,67,69,71,73,75,77,79,81);
					foreach($total as $key=>$value){
						if(strstr($key,"perc") && in_array($i,$perccolumns))
						{
							if($i==7 || $i==11 || $i==15){
								if($BCGMtarget == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$BCGMtarget),0);
								}								
							}
							if($i==9 || $i==13 || $i==17){
								if($BCGFtarget == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$BCGFtarget),0);
								}								
							}
							if($i<=77 && $i>=17){							
								$targettodivide = 0;
								if($key[0]=='m'){
									$targettodivide = $Mchildren;
								}else if($key[0]=='f'){
									$targettodivide = $Fchildren;
								}
								
								if($targettodivide == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$targettodivide),0);
								}
							}								
							if($i==79 || $i==81){
								if($women == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$women),0);
								}								
							}
						}					
						$pervKey = $key;
						$i++;
					}
					foreach($inucresult as $val)
					{
						if(array_key_exists('Total New Borns',$val))
						{
							$val['Total New Borns'] = round($val['Total New Borns'],0);
						}
						if(array_key_exists('Total_Targeted_Children',$val))
						{
							$val['Total_Targeted_Children'] = round($val['Total_Targeted_Children'],0);
						}
						echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>".$count."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						echo implode("</td><td style='text-align:center; border: 1px solid black;' class=\"text-red\">",array_map(function($v){
							if($v != '')
								return $v;
							return 0;
						},array_values($val)));
						
						echo "</td></tr>";
						$count++;
					}
					if(isset($inucresult[0][$codecolumn])){
						if(array_key_exists('Total New Borns',$total))
							{
								$total['Total New Borns'] = ceil($total['Total New Borns']);
							}
							
						if(array_key_exists('Total_Targeted_Children',$total))
							{
								$total['Total_Targeted_Children'] = ceil($total['Total_Targeted_Children']);
							}
					}
					echo "<tr style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'></td><td class='text-center' style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black;'><strong> Total: </strong></td><td style='min-width:80px; background: #D3D3D3; width: 200px; border: 1px solid black; font-weight: bold;'>";
					echo implode("</td><td style='min-width:80px; background: #D3D3D3; width: 200; border: 1px solid black; font-weight: bold;' class=\"text-red\">",$total);
					echo "</td></tr>";
				}
				else{
					echo "<tr style='background-color: D3D3D3'><td></td><td></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td><td>";
				} */
			?>
		</tbody>
	</table>
</div>
<?php if(!$this->input->post('export_excel'))
	{ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script type="text/javascript">
	var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
	var report_type= "<?php echo (isset($data['report_type']))?$data['report_type']:''; ?>";
	$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
		$("#stockouttable tbody tr td").each(function(i){
			var datainsidecell = $(this).text();
			if(datainsidecell=="0"){
				if(report_type==1 && report_indicator==1 ){
					$(this).css("background","Green");
				}else{
					$(this).css("background","Red");
				}
			}
			if(datainsidecell==""){
				if(report_type==1 && report_indicator==1 ){
					$(this).css("background","Grey");
				}else{
					$(this).css("background","Grey");
				}
			}
		});
		if(report_indicator==1){
			//to compare required and available stock
			$("#stockouttable tbody tr").each(function(row){
				var prevcellval = "";
				$(this).find("td").each(function(cell){
					if(cell !=0 && cell!=1){
						var datainsidecell = parseInt($(this).text());
						if(cell%2 == 1 && prevcellval!==0){
							if(datainsidecell!=""){
								if(report_type==1 && report_indicator==1 ){
									//$(this).css("background","Green");
								}else{
									if(prevcellval < datainsidecell ){
										$("#stockouttable tbody tr:nth-child("+(row+1)+") td:nth-child("+(cell)+")").css("background","Orange");
										//$(this).css("background","Blue");
									}
								}
							}else{
								prevcellval = "";
							}
						}
						prevcellval = datainsidecell;
					}
				});
			});
		}
	});
	$(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		//var report_indicator= "<?php echo (isset($data['report_indicator']))?$data['report_indicator']:''; ?>";
		var fmonth= "<?php echo (isset($data['fmonth']))?$data['fmonth']:NULL; ?>";
		if(codeLength == 3)
        {
			url = "<?php echo base_url();?>vaccination/reports/coverage/preview";
        }
		if(codeLength == 6)
        {
			url = "<?php echo base_url();?>vaccination/view/"+fmonth+"/"+code;
        }
		$(
			'<form method="post" action="'+url+'" target="_blank">'+
				'<input type="hidden" name="moon" value="formposted">'+
				'<input type="hidden" name="distcode" value="'+code+'">'+
				'<input type="hidden" name="fmonth" value="'+fmonth+'">'+
				'<input type="hidden" name="report_indicator" value="'+report_indicator+'">'+
				'<input type="hidden" name="report_type" value="2">'+
				'<input type="hidden" name="vaccines" value="<?php echo (isset($data['vaccines']) && $data['vaccines']!="")?implode(',',$data['vaccines']):''; ?>">'+
			'</form>'
		).appendTo('body').submit().remove();
    });
 </script>
     <?php } ?>