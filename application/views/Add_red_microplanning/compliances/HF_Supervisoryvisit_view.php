<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    <?php if($this->session->Tehsil){ ?>
						<th rowspan="2">Tcode</th>
						<th rowspan="2">Tehsil</th>
					<?php } else{?>
						<th rowspan="2">Distcode</th>
						<th rowspan="2">Distname</th>
					<?php } ?>
					<th rowspan="2">NO of <br> Supervisor </th>
					<?php
							$currentmonth = date('m');
							for ($month = 1; $month <= $currentmonth; $month++) {
								if($month < 10){
								   $month='0'.$month;
								}
								echo '<th colspan="3">'.monthname($month).' </th>';
							}
					?>
					<th colspan="3">Total</th>
				</tr>
				<tr>
						<?php 
							$currentmonth = date('m');
						 								
							for ($month = 1; $month <= $currentmonth; $month++) {
								if($month < 10){
								   $month='0'.$month;
								}
								echo '<th>Planed Visit </th>';
								echo '<th>Conducted Visit </th>';
								echo '<th> Total % Conducted   </th>';
							}
								echo '<th>Planed Visit</th>';
								echo '<th>Conducted Visit</th>';
								echo '<th>Total % Conducted</th>';
						?>
				</tr>
			</thead>
			<tbody id="tbody">
				<input type='text' hidden value="<?php echo $year;  ?>" id='year'>
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
				 	foreach($data as $val)
					{
						echo "<tr class='DrillDownRow'><td class='text-center'>";
					   if($this->session->Tehsil){
							echo $val->tcode;
							echo "</td><td class='text-center'>";
							echo $val->tehsil;
						}else{
							echo $val->distcode;
							echo "</td><td class='text-center'>";
							echo $val->district;
						}
						echo "</td><td class='text-center'>";
						echo $val->totalsupervisor;
						for ($month = 1; $month <= $currentmonth; $month++) {
							 if($month < 10){
								   $month='0'.$month;
								}
							echo "</td><td class='text-center'>";
							echo $val->{'plan'.$month};
							echo "</td><td class='text-center'>";
							echo $val->{'conduct'.$month};
							echo "</td><td class='text-center'>";
							if($val->{'persent'.$month} > 0){
								echo $val->{'persent'.$month}.'%';
							}else{
								echo '0%';
							}
							
						}
						echo "</td><td class='text-center'>";
						echo $val->totalsupervisorsplan;
						echo "</td><td class='text-center'>";
						echo $val->totalsupervisorsconduct;
						echo "</td><td class='text-center'>";
						if($val->totalsupervisorspersent > 0){
								echo ($val->totalsupervisorspersent).'%';
							}else{
								echo '0%';
							}
						
						echo "</td></tr>";
						$count++;
					}
					echo "<tr class='DrillDownRow' style='background-color: #111;color: #FFF;'>";
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px;'> . </td>";
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > Total: </td>";
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > ";
					echo $val->totalprosupervisor;  
					echo "</td>";
					foreach($data as $val)
						{
						for ($month = 1; $month <= $currentmonth; $month++) {
								if($month < 10){
									$month='0'.$month;
									}
								echo "</td><td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' >";
								echo $val->{'totalsupervisorsplanh'.$month};
								echo "</td><td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' >";
								echo $val->{'totalsupervisorsconducth'.$month};
								echo "</td><td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' >";
								if($val->{'totalsupervisorspersenth'.$month} > 0){
									echo $val->{'totalsupervisorspersenth'.$month}.'%';
								}else{
									echo '0%';
								}
								
						} break;		
					}
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > ";
					echo $val->totalsupervisorsplanl;  
					echo "</td>";
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > ";
					echo $val->totalsupervisorsconductl;  
					echo "</td>";
					echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > ";
					echo ($val->totalsupervisorspersentl).'%';
					echo "</td>";
					echo "</tr>";

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
<style>
			#parent {
				height: 400px;
			}
			
			#fixTable {
				width: 1800px !important;
			}

		</style>

	<script>
		  $(document).ready(function() {
				$("#fixTable").tableHeadFixer(); 
			}); 
	</script>
<script type="text/javascript">

	$(document).ready(function(){
		//$("#fixTable").tableHeadFixer({"left" : 1});
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click', function(){
		var year = $('#year').val();
		var code = $(this).find("td:nth-child(1)").text();
		if(code.toString().length == 3){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_supervisoryvisit_tech_compliance?distcode="+code+"&year="+year;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		}else if(code.toString().length == 6){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_supervisoryvisit_tech_compliance?tcode="+code+"&year="+year;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
		}		
	});
	
</script>