<div class="container bodycontainer">
	<?php echo $data['TopInfo']; 
	$vaccinationType = ucfirst($data['vaccinationtype']);
	?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="3" style="min-width: 56px;">S No.</th>
					<?php if(!isset($data[0]['uncode']) && isset($data[0]['distcode'])) {?>
   	   				<th rowspan="3" style="min-width:170px;">Distcode</th>
					<th rowspan="3" style="min-width: 170px;">District</th>
					<?php } else if(isset($data[0]['tcode'])) {?>
   	   				<th rowspan="3" style="min-width:170px;">Tehsil Code</th>
					<th rowspan="3" style="min-width: 170px;">Tehsil Name</th>
   	   				<?php } else if(isset($data[0]['uncode'])) {?>
					<th rowspan="3" style="min-width:100px;">Uncode</th>
					<th rowspan="3" style="min-width: 207px;">UnionCouncil</th>
					<?php } else { ?>
					<th rowspan="3" style="min-width:100px;">EPI Center Code</th>
					<th rowspan="3" style="min-width: 207px;">EPI Center</th>
					<?php } ?>

					<th colspan="3">BCG</th>
					<th colspan="3">HEP B</th>
					<th colspan="12">OPV</th>
					<th colspan="9">Pentavalent</th>
					<th colspan="9">PCV 10</th>
					<th colspan="3">IPV</th>
					<th colspan="6">Rota</th>
					<th colspan="3">Measles</th>
					<th colspan="3">Fully Immunized</th>
					<th colspan="3">Measles</th>
					<th colspan="5">TT Pregnant Women</th>
					<th colspan="5">TT Non-Pregnant Women (15-49 Years)</th>
				</tr>
				<tr>
					<th rowspan="2">Total Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> %</th>
					<th rowspan="2">Total Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> %</th>
					<th colspan="3">0</th>
					<th colspan="3">I</th>
					<th colspan="3">II</th>
					<th colspan="3">III</th>
					<th colspan="3">I</th>
					<th colspan="3">II</th>
					<th colspan="3">III</th>
					<th colspan="3">I</th>
					<th colspan="3">II</th>
					<th colspan="3">III</th>
					<th rowspan="2">Total Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> %</th>
					<th colspan="3">I</th>
					<th colspan="3">II</th>
					<th colspan="3">I</th>
					<th rowspan="2">Total Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> Vaccination</th>
					<th rowspan="2"><?php echo $vaccinationType; ?> %</th>
					<th colspan="3">II</th>
					<th rowspan="2">I</th>
					<th rowspan="2">II</th>
					<th rowspan="2">III</th>
					<th rowspan="2">IV</th>
					<th rowspan="2">V</th>
					<th rowspan="2">I</th>
					<th rowspan="2">II</th>
					<th rowspan="2">III</th>
					<th rowspan="2">IV</th>
					<th rowspan="2">V</th>
				</tr>
				<tr>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
					<th>Total Vaccination</th>
					<th><?php echo $vaccinationType; ?> Vaccination</th>
					<th><?php echo $vaccinationType; ?> %</th>
				</tr>
			</thead>
			<tbody>  

				<?php
				$count = 1;

				unset($data['TopInfo']);
				unset($data['exportIcons']);
				unset($data['vaccinationtype']);

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
				foreach($data as $val)
				{
					echo "<tr class=\"Coverage\"><td>".$count."</td><td>";
					echo implode("</td><td>",array_map(function($v){
				            if($v != '')
				                return $v;
							return 0;
				        },array_values($val)));
					echo "</td></tr>";
					$count++;
				}
				echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td class='perc' style='background-color: grey'>";
				echo implode("</td><td class='perc' style='background-color: grey'>",$total);
				echo "</td></tr>";
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
		$('.Coverage').css('cursor','pointer');
		$('.perc').each(function(){
			var curr = $(this);
			var tdIndex = parseInt($(this).index())+1;
			if(tdIndex%3==0 && tdIndex < 58){
				var num = $('.perc:nth-child('+parseInt(tdIndex-1)+')').text();
				var den = $('.perc:nth-child('+parseInt(tdIndex-2)+')').text();
				var result = parseFloat(num/den*100).toFixed(1);
				if(isNaN(result) == true){
					result = 0;
				}
				curr.text(result);
			} 
		});
	});
	$('.Coverage').on('click', function(){
		var code = $(this).find("td:nth-child(2)").text();
		//alert(code);
		var datefrom = "<?php echo $monthfrom; ?>";
		var dateto = "<?php echo $monthto; ?>";
        var typeWise="uc";
		var vaccinetype="<?php echo $vaccination_type; ?>";
		//alert(vaccinetype);
		var vacc_to="<?php echo $vacc_to; ?>";
		var age_wise="<?php echo $age_wise;?>";
		var in_out_coverage="<?php echo $in_out_coverage;?>";
		var distdrilldown="<?php echo "dist_to_uc";?>";
		//alert(age_wise);
		var distcode = 0;
	    var facode = 0;
	    var url = '';	     
	   <?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';				
		<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
		<?php } ?>
	   /* if(code.toString().length == 6){
	    	facode = code;
	    	url = "<?php echo base_url();?>System_setup/flcf_view?facode="+facode;
	    }	   */  
	    if(code.toString().length == 3 && in_out_coverage == 'in_district'){
	    	url = "<?php echo base_url();?>Reports/flcf_wise_vaccination_malefemale_coverage?distcode="+code+"&typeWise="+typeWise+"&monthfrom="+datefrom+"&monthto="+dateto+"&vaccination_type="+vaccinetype+"&vacc_to="+vacc_to+"&age_wise="+age_wise+"&distdrilldown="+distdrilldown+"&in_out_coverage="+in_out_coverage;
			//url = "<?php echo base_url();?>Reports/flcf_wise_vaccination_malefemale_coverage/"+code+"/"+typeWise+"/"+datefrom+"/"+dateto+"/"+vaccinetype+"/"+vacc_to+"/"+age_wise;
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
