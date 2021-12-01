<!--start of page content or body-->

<div class="container bodycontainer">
	<?php
	//print_r($data);exit();
	//echo "abc";exit();
	echo $data['TopInfo']; ?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>				
				<tr>
   	   				<th rowspan="2" style="min-width:80px;">S No.</th>
   	   				<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th rowspan="2" style="min-width:170px;">Distcode</th>
					<th rowspan="2" style="min-width: 170px;">District</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
   	   				<th rowspan="2" style="min-width:170px;">Uncode</th>
					<th rowspan="2" style="min-width: 170px;">UnionCouncil</th>
					<?php } else { ?>
   	   				<th rowspan="2" style="min-width:170px;">EPI Center Code</th>
   	   				<th rowspan="2" style="min-width:170px;">EPI Center</th>
   	   				<?php } ?>
   	   				<!-- <th colspan="3">Target</th> -->
					<th rowspan="2">BCG</th>
					<th rowspan="2">HEP B</th>
					<th colspan="4">OPV</th>
					<th colspan="3">Pentavalent</th>
					<th colspan="3">PCV 10</th>
					<th rowspan="2">IPV</th>
					<th colspan="2">Rota</th>
					<th rowspan="1">MR</th>
					<th rowspan="2">Fully Immunized</th>
					<th rowspan="1">MR</th>
					<th rowspan="2">DTP</th>
					<th rowspan="2">TCV</th>
					<th rowspan="2">IPV</th>
					<th colspan="5">TT Pregnant Women</th>							
					<th colspan="5">TT Non-Pregnant Women (15-49 Years)</th>
   	   			</tr>
				<tr>
					<!-- <th rowspan="2">Newborns</th>
   	   				<th rowspan="2">Surviving Infants</th>
   	   				<th rowspan="2">PLW</th> -->
					<!-- <th rowspan="2">Total</th> -->
					<!-- <th rowspan="2">%</th> -->
					<!-- <th rowspan="2">Total</th> -->
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="1">0</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">III</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">III</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">III</th>
					<!-- <th rowspan="2">Total</th> -->
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="1">I</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">I</th>
					<!-- <th rowspan="2">Total</th> -->
					<!-- <th rowspan="2">%</th> -->
					<th rowspan="1">II</th>
					<th rowspan="1">II</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">III</th>
					<th rowspan="1">IV</th>
					<th rowspan="1">V</th>
					<th rowspan="1">I</th>
					<th rowspan="1">II</th>
					<th rowspan="1">III</th>
					<th rowspan="1">IV</th>
					<th rowspan="1">V</th>
				</tr>
				
			</thead>
			<tbody>  
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$percentage   = array(
					"perctbcg","percthep","perctopv_o",
					"perctopv_on","perctopv_tw","perctopv_th",
					"perctpen_o","perctpen_tw",
					"percfpen_tw","perctpen_th",
					"perctpc_o","perctpc_tw","perctpc_th",
					"perctip_o","perctrota_o","perctrota_tw","perctmea_o","perctmea_tw",
					"percttcv_o","perctip_tw",
					"pwperctotal_ttpl1","pwperctotal_ttpl2"
				);
				$total = array();
				foreach($data as $value)
				{
					foreach($value as $key => $totalv)
					{
						if($key != "distcode" && $key != "district" && $key != "districtname" && $key != "facode" && $key != "facilityname" && $key != "uncode" && $key != "unname"){
							if(key_exists($key,$total))
							{
								$total[$key] += $totalv;
							}
							else
								$total[$key] = $totalv;
						}
					}
				}
				if( /*isset($total['Total New Borns']) && (! (($total['Total New Borns'] == 0) AND ($total['Total_Targeted_Children'] == 0) ))*/1)
				{
					// $BCGTtarget=$total['Total New Borns'];
					// $Tchildren=$total['Total_Targeted_Children'];
					// $women=$total['Targeted_Women'];
					// $i=1;
					// $maleTargetArray=array(5,7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43);
					// foreach($total as $key=>$value){				
					// 	if(strstr($key,"perc") && in_array($i,$maleTargetArray))
					// 	{
					// 		if($i<=9){
					// 			if($BCGTtarget == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$BCGTtarget),0);
					// 			}								
					// 		}
					// 		if($i<=39 && $i>=11){
					// 			if($Tchildren == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$Tchildren),0);
					// 			}
					// 		}								
					// 		if($i==41 || $i==43){
					// 			if($women == 0){
					// 				$total[$key] = 0;
					// 			}
					// 			else{
					// 				$total[$key] = round(($total[$pervKey]*100/$women),0);
					// 			}								
					// 		}
					// 	}
					// 	else{}
						
					// 	$pervKey = $key;
					// 	$i++;
					// }
					foreach($data as $val)
					{
						if(array_key_exists('Total New Borns',$val))
						{
							$val['Total New Borns'] = round($val['Total New Borns'],0);
						}
						if(array_key_exists('Total_Targeted_Children',$val))
						{
							$val['Total_Targeted_Children'] = round($val['Total_Targeted_Children'],0);
						}
						echo "<tr class='DrillDownRow'><td>".$count."</td><td>";
						echo implode("</td><td class=\"text-red\">",$val);
						
						echo "</td></tr>";
						$count++;
					}
					if(isset($data[0]['uncode'])){
						if(array_key_exists('Total New Borns',$total))
						{
							$total['Total New Borns'] = ceil($total['Total New Borns']);
						}
							
						if(array_key_exists('Total_Targeted_Children',$total))
						{
							$total['Total_Targeted_Children'] = ceil($total['Total_Targeted_Children']);
						}
					}
					//print_r($total);exit();
					//unset($total['district']);
					echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td style='background-color: grey'>";
					//echo "<tr><td></td><td  class='text-center'><strong> Total: </strong></td><td>";
					echo implode("</td><td style='background-color: grey'>",$total);
					//echo implode("</td><td class=\"text-red\">",$total);
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
		$("#fixTable").tableHeadFixer({"left" : 3});
		$('.DrillDownRow').css('cursor','pointer');
		// $('.text-red').each(function(){
		// 	var abc = [7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45];
		// 	if(inArray($(this).index(),abc)){
		// 		$(this).addClass('text-center');
		// 		if(parseInt($(this).text()) < 80){
		// 			$(this).css('background-color','red');
		// 		}
		// 	}
		// });
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