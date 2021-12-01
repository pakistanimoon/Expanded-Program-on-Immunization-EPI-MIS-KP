<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
	 ?>
	<div id="parent">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>S No.</th>
					<?php if($distcode > 0) { ?>
					<th>EPI Center Code</th>
					<th>EPI Facility Center</th>
					<?php } else if($tcode > 0) { ?>
					<th>EPI Center Code</th>
					<th>EPI Facility Center</th>
					<?php } else { ?>
					<th>Distcode</th>
					<th>District</th>
					<?php } ?>
					<th>Planned</th>
					<th>Conducted</th>
					<th>% Conducted</th>
				</tr>
			</thead>
			<tbody id="tbody">  
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
					foreach($data as $value)
					{
						foreach($value as $key => $totalv)
						{
							if($key!="code"){
								if(is_numeric($totalv)){
									if(key_exists($key,$total))
									{
										$total[$key] += $totalv;
									}
									else
										$total[$key] = $totalv;
								}
							}
						}
					}
					foreach($data as $val)
					{
						echo "<tr class='DrillDownRow'><td class='text-center'>".$count."</td><td class='text-center'>";
					    echo $val->code;
						echo "</td><td class='text-center'>";
						echo $val->name;
						echo "</td><td class='text-center'>";
						echo $val->planned;
						echo "</td><td class='text-center'>";
						echo $val->conducted;
						echo "</td><td class='text-center'>";
						echo $val->perc;
						echo "</td></tr>";
						$count++;
					}
					if(!key_exists('perc',$total)){
						$total['perc']=0;
					}
					echo "<tr><td></td><td></td><td class='text-center'><strong> Total: </strong></td><td class='text-center'>";
					echo implode("</td><td class='text-center'>",$total);
					echo "</td></tr>";
				}else{
					echo "<div><td colspan='6'>SORRY! Record Not Exist</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 1});
		$('.DrillDownRow').css('cursor','pointer');
	});
	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(2)").text();
		var reportType = '<?php echo $reportType; ?>';
		var session_type = '<?php echo $session_type; ?>';
		var year = '<?php echo $year; ?>';
		var quarter = '<?php echo $quarter; ?>';
		var month = '<?php echo $month; ?>';
		var url = '';
		if(code.toString().length == 3){
			if(reportType=="yearly"){
				url = "<?php echo base_url();?>Reports/sessionInfoReport?distcode="+code+"&report_type="+reportType+"&year="+year+"&session_type="+session_type;
			}else if(reportType=="quarterly"){
				url = "<?php echo base_url();?>Reports/sessionInfoReport?distcode="+code+"&report_type="+reportType+"&year="+year+"&session_type="+session_type+"&quarter="+quarter;
			}else if(reportType=="monthly"){
				url = "<?php echo base_url();?>Reports/sessionInfoReport?distcode="+code+"&report_type="+reportType+"&year="+year+"&session_type="+session_type+"&month="+month;
			}
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		}		
	});
	jQuery(window).load(function () {	   
		setTimeout(function () {
			<?php if(!empty($data)){ ?>
			$('#tbody tr:last').find('td:last').text('');
			$lastTdIndex = $('#tbody tr:last').find('td:last').index();
			$conductedTdIndex = parseInt($('#tbody tr:last').find('td:nth('+($lastTdIndex-1)+')').text());			
			$plannedTdIndex = parseInt($('#tbody tr:last').find('td:nth('+($lastTdIndex-2)+')').text());
			if($conductedTdIndex==0 && $plannedTdIndex==0){
				$('#tbody tr:last').find('td:last').text(0);
			}else{
				$('#tbody tr:last').find('td:last').text(Math.round($conductedTdIndex*100/$plannedTdIndex));
			}
		<?php } ?>
			
		}, 2000); 
		
	});
</script>