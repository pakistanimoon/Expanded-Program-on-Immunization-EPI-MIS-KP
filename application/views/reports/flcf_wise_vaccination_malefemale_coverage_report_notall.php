<!--start of page content or body-->
<div class="container bodycontainer">
	<?php
	//print_r($data);exit;
	echo $data['TopInfo'];
	?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width: 56px;" rowspan="3">S No.</th>
					<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Distcode</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">District</th>
					<?php } else if(isset($data[0]['tcode'])) {?>
   	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Tehsil Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black; min-width:170px;" rowspan="3">Tehsil Name</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
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
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="4">Fully Immunized</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="4">DTP</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="4">TCV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">IPV</th>
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
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">II</th>
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
				</tr>
			</thead>
			<tbody>  
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$percentage   = array(
					"percmbcg","percfbcg","percmhep",
					"percfhep","percmopv_o","percfopv_o",
					"percmopv_on","percfopv_on","percmopv_tw",
					"percfopv_tw","percmopv_th","percfopv_th",
					"percmpen_o","percfpen_o","percmpen_tw",
					"percfpen_tw","percmpen_th","percfpen_th",
					"percmpc_o","percfpc_o","percmpc_tw","percfpc_tw","percmpc_th","percfpc_th",
					"percmip_o","percfip_o","percmmea_o","percfmea_o","percmmea_tw","percfmea_tw",
					"percmtcv_o","percftcv_o","percmip_tw","percfip_tw"
				);
				$total = array();
				foreach($data as $value)
				{
					foreach($value as $key => $totalv)
					{
						if($key != "distcode" && $key != "districtname" && $key != "facode" && $key != "facilityname" && $key != "uncode" && $key != "unname" && $key != "tcode" && $key != "tehsilname"){
							if(key_exists($key,$total))
							{
								$total[$key] += $totalv;
							}
							else
								$total[$key] = $totalv;
						}
					}
				}
				if( ! (($total['New Borns Male'] == 0) AND ($total['New Borns FeMale'] == 0) AND ($total['Targeted_Male_Children'] == 0) AND ($total['Targeted_Female_Children'] == 0) ))
				{
					$BCGMtarget=$total['New Borns Male'];
					$BCGFtarget=$total['New Borns FeMale'];
					$Mchildren=$total['Targeted_Male_Children'];
					$Fchildren=$total['Targeted_Female_Children'];
					$women=$total['Targeted_Women'];
					$i=1;
					$maleTargetArray=array(7,11,15,19,23,27,31,35,39,43,47,51,55,59,63,67,71,75);
					$femaleTargetArray=array(9,13,17,21,25,29,33,37,41,45,49,53,57,61,65,69,73,77);
					foreach($total as $key=>$value){				
						if(strstr($key,"perc") && in_array($i,$maleTargetArray))
						{
							if($i<=17){
								if($BCGMtarget == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$BCGMtarget),0);
								}								
							}
							if($i<=75 && $i>17){
								if($Mchildren == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$Mchildren),0);
								}								
							}
							/* if($i==67 || $i==69)
								$total[$key] = round(($total[$pervKey]*100/$women),0); */
						}
						else if(strstr($key,"perc") && in_array($i,$femaleTargetArray))
						{
							if($i<=17){
								if($BCGFtarget == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$BCGFtarget),0);
								}								
							}
							if($i<=77 && $i>17){
								if($Fchildren == 0){
									$total[$key] = 0;
								}
								else{
									$total[$key] = round(($total[$pervKey]*100/$Fchildren),0);
								}								
							}
						}
						else{}
						
						$pervKey = $key;
						$i++;
					}
					foreach($data as $val)
					{
						echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;'>".$count."</td><td style='text-align:center; border: 1px solid black;'>";
						echo implode("</td><td style='text-align:center; border: 1px solid black;' class=\"text-red\">",array_map(function($v){
				            if($v != '')
				                return $v;
							return 0;
				        },array_values($val)));
						
						echo "</td></tr>";
						$count++;
					}
					echo "<tr><td></td><td></td><td  class='text-center'><strong> Total: </strong></td><td>";
					echo implode("</td><td class=\"text-red\">",$total);
					echo "</td></tr>";
				}
				else{
					echo "<tr><td></td><td></td><td colspan='32' class='text-center'><strong> No Record Found </strong></td><td>";
				}
				?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 8});
		$('.DrillDownRow').css('cursor','pointer');
		$('.text-red').each(function(){
			var abc = [9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49,51,53,55,57,59,61,63,65,67,69,71,73,75,77,79,81];
			if(inArray($(this).index(),abc)){
				$(this).addClass('text-center');
				if(parseInt($(this).text()) < 80){
					$(this).css('background-color','red');
				}
			}
		});
	});
	function inArray(needle, haystack) {
		var length = haystack.length;
		for(var i = 0; i < length; i++) {
			if(haystack[i] == needle) return true;
		}
		return false;
	}
	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(2)").text();
		var datefrom = "<?php echo $monthfrom; ?>";
		var dateto = "<?php echo $monthto; ?>";
        var typeWise="uc";
		var vaccinetype="<?php echo $vaccination_type; ?>";
		var vacc_to="<?php echo $vacc_to; ?>";
		var age_wise="<?php echo $age_wise;?>";
		var in_out_coverage="<?php echo $in_out_coverage;?>";
		var distdrilldown="<?php echo "dist_to_uc";?>";
		var distcode = 0;
	    var facode = 0;
	    var url = '';	     
	   <?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';				
		<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
		<?php } ?>
	    if(code.toString().length == 3 && in_out_coverage == 'in_district'){
	    	url = "<?php echo base_url();?>Reports/flcf_wise_vaccination_malefemale_coverage?distcode="+code+"&typeWise="+typeWise+"&monthfrom="+datefrom+"&monthto="+dateto+"&vaccination_type="+vaccinetype+"&vacc_to="+vacc_to+"&age_wise="+age_wise+"&distdrilldown="+distdrilldown+"&in_out_coverage="+in_out_coverage;
		}
		var win = window.open(url,'_self');
	    if(win){
	        win.focus();
	    }else{
	        //Broswer has blocked it
	        alert('Please allow popups for this site');
	    }
	});
</script>