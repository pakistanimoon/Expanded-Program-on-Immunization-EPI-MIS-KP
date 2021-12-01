
<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
	//	print_r($data);exit;
		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th>Supervisor Name</th>
					<th>Supervisor Designation</th>
					<?php
							$currentmonth = date('m');
							for ($month = 1; $month <= $currentmonth; $month++) {
								if($month < 10){
								   $month='0'.$month;
								}
								echo '<th>'.monthname($month).'<br> Supervisor Plan </th>';
								
							}
					?>
				</tr>
			</thead>
			<tbody id="tbody">  
				<?php
				$count = 1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
				 	foreach($data as $val)
					{
						echo "<tr class='DrillDownRow'><td class='text-center'>";
					    echo get_supervisor_Name( $val->supervisorname);
						echo "</td><td class='text-center'>";
						echo $val->supervisor_type;
						for ($month = 1; $month <= $currentmonth; $month++) {
							 if($month < 10){
								   $month='0'.$month;
								}
							echo "</td><td class='text-center'>";
							 
							if( $val->{'plan'.$month} != NULL ){
								echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
							}
							else{
								echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
							}
						}
						echo "</td></tr>";
						$count++;
					}
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
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click', function(){
		var code = $(this).find("td:nth-child(1)").text();
		if(code.toString().length == 3){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_quarter_tech_compliance?distcode="+code;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}		
	});
</script>
