<!--start of page content or body-->
<div class="container bodycontainer">
	<?php
//print_r($data);exit;
	echo $data['TopInfo'];
	 ?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<t1head>
				<tr>
					<th class="Heading text-center" rowspan="3" style="min-width: 56px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">S No.</th>
					<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Distcode</th>
					<th class="Heading text-center" rowspan="3" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">District</th>
					<?php } else if(isset($data[0]['tcode'])) {?>
   	   				<th class="Heading text-center" rowspan="3" style="min-width:170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Code</th>
					<th class="Heading text-center" rowspan="3" style="min-width: 170px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil Name</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
					<th class="Heading text-center" rowspan="3" style="min-width:100px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">Uncode</th>
					<th class="Heading text-center" rowspan="3" style="min-width: 207px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">UnionCouncil</th>
					<?php } else { ?>
					<th class="Heading text-center" rowspan="3" style="min-width:100px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center Code</th>
					<th class="Heading text-center" rowspan="3" style="min-width: 207px; background: #008d4c; color: white; width: 200px; border: 1px solid black;">EPI Center</th>
					<?php } ?>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="5">Target</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">BCG</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">HEP B</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="8">OPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="6">Pentavalent</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="6">PCV 10</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">IPV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="4">Rota</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="2">Fully Immunized</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">MR</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="2">DTP</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2" colspan="2">TCV</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">IPV</th>
				</tr>
				<tr>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2" style="min-width: 78px;">Newborns</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Surviving Infants</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="women" style="width: 74px;height: 38px;" > &nbsp;</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">0</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">III</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">I</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">II</th>
				</tr>
				<tr>				
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" id="women3"> &nbsp;PLW</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">M</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">F</th>
					<!-- <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">%</th> -->
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
					"percmtcv_tw","percftcv_tw","percmtcv_o","percftcv_o"
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
				if( /*! (($total['New Borns Male'] == 0) AND ($total['New Borns FeMale'] == 0) AND ($total['Targeted_Male_Children'] == 0) AND ($total['Targeted_Female_Children'] == 0) )*/1)
				{
					
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
					echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td style='background-color: grey'>";
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
		// 	var abc = [9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45,47,49,51,53,55,57,59,61,63,65,67,69,71,73,75,77,79,81];
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