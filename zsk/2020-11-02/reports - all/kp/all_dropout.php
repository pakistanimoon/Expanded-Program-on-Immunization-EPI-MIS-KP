
	<?php
	// beta
	//print_r($result_total);exit;
	echo $TopInfo;
	 ?>
		<table id="all_dropout" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing">
			<thead>
				<tr>
					<?php if(isset($data['type_wise']) AND $data['type_wise'] == 'uc') {?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">UC code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">UnionCouncil</th>
					<?php } elseif(isset($data['type_wise']) AND $data['type_wise'] == 'facility') { ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">Facility Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">Facility Name</th>
					<?php } else { ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">District Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" rowspan="2">District Name</th>
					<?php } ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" colspan="3">Penta1-Measle1 Dropout (%)</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" colspan="3">Penta1-Penta3 Dropout (%)</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" colspan="3">Measle1-Measle2 Dropout (%)</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center" colspan="3">TT1-TT2 Dropout (%)</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Male</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Female</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Total</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Male</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Female</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Total</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Male</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Female</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Total</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">PLW</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">CBAs</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" class="text-center">Total</th>
				</tr>

			<tbody>
				<?php
					$str = "";
					if(isset($result))
					{
						foreach ($result as $key => $value) 
						{
						 	$str .= "<tr class='DrillDownRow' style='cursor: pointer;'><td style='text-align:center; border: 1px solid black;' class=\"text-center\">";
						 	$str .= implode("</td><td style='text-align:center; border: 1px solid black;' class=\"text-center\">", $value);
						 	$str .= "</td></tr>";
						} 
					}
					if(isset($result_total))
					{
						foreach ($result_total as $key => $value) 
						{
						 	$str .= "<tr><td style='font-weight:bold; background-color: #111;color: #FFF;' class='text-center' colspan='2'>Total:</td><td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>";
						 	$str .= implode("</td><td style='font-weight:bold; background-color: #111;color: #FFF;' class='text-center'>", $value);
						 	$str .= "</td></tr>";
						}
					}
					echo $str;
				?>
			</tbody>
		</table>
</div><!--End of page content or body-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		$('#all_dropout').find('td').each (function() {
		  	if(this.textContent > 10 && this.cellIndex > 1)
		  	{
		  		this.bgColor = "red";
		  	}
		}); 
	});

	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(1)").text();
		var monthfrom = "<?php echo $data['monthfrom']?>";
		var monthto = "<?php echo $data['monthto']?>";
	    var type_wise = 'facility';
	    var url = '';

	    if(code.toString().length == 3){
	    	url = "<?php echo base_url();?>Reports/all_dropout/"+code+"/"+monthfrom+"/"+monthto+"/"+type_wise;
	    }
	    if(url)
	    {
			var win = window.open(url,'_blank');
		    if(win){
		        win.focus();
		    }else{
		        //Broswer has blocked it
		        alert('Please allow popups for this site');
		    }
		}
	});
</script>