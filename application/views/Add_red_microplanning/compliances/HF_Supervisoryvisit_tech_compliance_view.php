<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th rowspan="2">supervisor code</th>
					<th rowspan="2">supervisor name</th>
					<!--<th rowspan="2">NO of <br> Supervisor </th>-->
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
						echo "<tr class='DrillDownRow'><td class='text-center mrClicked' >";
					    echo $val->supervisorname;
						 echo "</td><td class='text-center text-nowrap'>";
						/*echo $val->supervisor_type; 
						 echo "</td><td class='text-center'>";*/
						echo get_supervisor_Name( $val->supervisorname);
						for ($month = 1; $month <= $currentmonth; $month++) {
							 if($month < 10){
								   $month='0'.$month;
								}
							echo "</td><td class='text-center mrClicked' data-month=".$month." data-code=".$val->supervisorname .">";
							echo $val->{'plan'.$month};                              
							echo "</td><td class='text-center mrClicked' data-month=".$month." data-code=".$val->supervisorname .">";
							echo $val->{'conduct'.$month};                           
							echo "</td><td class='text-center mrClicked' data-month=".$month." data-code=".$val->supervisorname .">";
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
					//echo"<td class='text-center' style='background-color: rgb(17, 17, 17); position: relative; left: 0px; color: white;' > ";
					//echo $val->totalprosupervisor;  
				//	echo ".";
					//echo "</td>";
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
					 //echo ".";  
					echo "</td> ";
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer();
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click','.mrClicked', function(){
		var year = $('#year').val();
		//var code = $(this).find("td:nth-child(1)").text();
		var code = $(this).data('code');
		var month = $(this).data('month');
		if(code.toString().length == 7){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_supervisoryvisit_view?supervisorcode="+code+"&year="+year+"&month="+month;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}	
	}); 
	
</script>