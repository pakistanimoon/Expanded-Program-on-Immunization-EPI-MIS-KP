<?php
	//print_r($result_length);exit;
	echo $TopInfo;
	$result_length = ((count($result[0]) - 2) / 2) - 1;
	$period_wise = $data['period_wise'];
	//$period_wise = 'monthly';
	$year = $data['year'];
	$header_array = array(
		'monthly' => array(),
		'quarterly' => array()
		);
	$quarter_arr = array(1 => "1st", 2 => "2nd", 3 => "3rd", 4 => "4th");
	if($period_wise == 'monthly')
	{
		$month = 1;
		for($i=1; $i<=12; $i++)
		{
			if($month == 13)
			{
				$year++;
				$month = 1;
			}
			$month = $month % 13;
			$month = sprintf("%02d", $month);
			$fmonth = $year.'-'.$month;
			$header_array['monthly'][] = date('M Y', strtotime($fmonth.'now'));
			$month++;
		}
	}
	elseif($period_wise == 'quarterly')
	{
		$month = date('m');
		$quarter = 1;

		for ($i=1; $i <= 4; $i++) 
		{
			if($quarter == 5)
			{
				$quarter = 1;
				//$year++;
			}
			//echo $quarter_arr[$quarter];exit();
			$header_array['quarterly'][] = "{$quarter_arr[$quarter]} Quarter, $year";
			//print_r($header_array['quarterly']); exit();
			$quarter++;
		}
	}
	//print_r($header_array['quarterly']); exit();
	
	?>
		<table id="measle_coverge_dropout" class="table table-condensed table-bordered table-hover table-striped footable table-vcenter listing-report-table tbl-listing">
			<thead>
				<tr>
					<?php if(isset($data['type_wise']) AND $data['type_wise'] == 'uc') {?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">UC code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">UnionCouncil</th>
					<?php } elseif(isset($data['type_wise']) AND $data['type_wise'] == 'facility') { ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Facility Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Facility Name</th>
					<?php } else { ?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">District Code</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">District Name</th>
					<?php } ?>
					 
					<?php for($i=1; $i<=$result_length; $i++){?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2"><?php echo $header_array[$period_wise][$i-1]; ?></th>
					<?php } ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Total</th>
				</tr>
				<tr>
					<?php for($i=1; $i<=$result_length; $i++){?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Coverage</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Cases</th>
					<?php } ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Coverage</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Cases</th>
				</tr>

			<tbody>
				<?php
					$str = "";
					if(isset($result))
					{ 
						//echo print_r($result);exit;
						foreach ($result as $key => $value) 
						{
						 	$str .= "<tr class='DrillDownRow' style='cursor: pointer;'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
						 	$str .= implode("</td><td style='text-align:center; border: 1px solid black;' class='text-center'>", $value);
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
	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(1)").text();
		var year = "<?php echo $data['year']?>";
		var period_wise = "<?php echo $data['period_wise']?>";
	    var type_wise = 'facility';
	    var url = '';
	    if(code.toString().length == 3){
	    	url = "<?php echo base_url();?>Reports/measle_coverage_dropout/"+code+"/"+year+"/"+period_wise+"/"+type_wise;
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