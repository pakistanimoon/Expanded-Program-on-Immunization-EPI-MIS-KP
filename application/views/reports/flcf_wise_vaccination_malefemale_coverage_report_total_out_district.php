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
   	   				<th class="Heading text-center" rowspan="2" style="min-width:80px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">S No.</th>
   	   				<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th class="Heading text-center" rowspan="2" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Distcode</th>
					<th class="Heading text-center" rowspan="2" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">District</th>
					<?php } else if(isset($data[0]['tcode'])) {?>
   	   				<th class="Heading text-center" rowspan="2" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Code</th>
					<th class="Heading text-center" rowspan="2" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Name</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
   	   				<th class="Heading text-center" rowspan="2" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Uncode</th>
					<th class="Heading text-center" rowspan="2" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">UnionCouncil</th>
					<?php } else { ?>
   	   				<th class="Heading text-center" rowspan="2" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center Code</th>
   	   				<th class="Heading text-center" rowspan="2" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center</th>
   	   				<?php } ?>
   	   				<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Target</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">BCG</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">HEP B</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">OPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Pentavalent</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">PCV 10</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">IPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Rota</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Fully Immunized</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">DTP</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">TCV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">IPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">TT Pregnant Women</th>							
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">TT Non-Pregnant Women (15-49 Years)</th>
   	   			</tr>
				<tr>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Newborns</th>
   	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Surviving Infants</th>
   	   				<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">PLW</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">0</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total</th> -->
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">IV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">V</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">IV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="1">V</th>
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
						// if($i=1; $i<=18;$i++){

						// }
						//print_r($val);
						echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>".$count."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						// if($val == NULL){
						// 	$val = 0;
						// }						
						//print_r($val);exit();
						echo implode("</td><td style='text-align:center; border: 1px solid black;' class='text-center'>",array_map(function($v){
				            if($v != '')
				                return $v;
							return 0;
				        },array_values($val)));
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
					echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td style='background-color: grey'>";
					//echo implode("</td><td>",$total);
					echo implode("</td><td style='background-color: grey'>",$total);
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
		content = $('.valcheck').html();
		//alert(content);
		if(content == '' || content == NULL)
		{
		  $('.valcheck').html('7');
		}
		
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