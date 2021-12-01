<div class="container bodycontainer">
	<?php echo $data['TopInfo']; ?>
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

					<th colspan="2">BCG</th>
					<th colspan="2">HEP B</th>
					<th colspan="8">OPV</th>
					<th colspan="6">Pentavalent</th>
					<th colspan="6">PCV 10</th>
					<th colspan="2">IPV</th>
					<th colspan="4">Rota</th>
					<th colspan="2">Measles</th>
					<th colspan="2">Fully Immunized</th>
					<th colspan="2">Measles</th>
				</tr>
				<tr>
					<th rowspan="2">M</th>
					<th rowspan="2">F</th>
					<th rowspan="2">M</th>
					<th rowspan="2">F</th>
					<th colspan="2">0</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">III</th>
					<th rowspan="2">M</th>
					<th rowspan="2">F</th>
					<th colspan="2">I</th>
					<th colspan="2">II</th>
					<th colspan="2">I</th>
					<th colspan="2">Total</th>
					<th colspan="2">II</th>
				</tr>
				<tr>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
					<th>M</th>
					<th>F</th>
				</tr>
			</thead>
			<tbody>  

				<?php
				$count = 1;

				unset($data['TopInfo']);
				unset($data['exportIcons']);

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
				echo "<tr><td></td><td></td><td class='text-center' style='background-color: grey'><strong> Total: </strong></td><td style='background-color: grey'>";
				echo implode("</td><td style='background-color: grey'>",$total);
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
