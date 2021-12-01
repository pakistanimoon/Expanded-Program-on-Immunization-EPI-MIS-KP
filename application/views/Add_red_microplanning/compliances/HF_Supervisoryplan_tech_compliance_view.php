
<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th>Supervisor Name</th>
					<th>Supervisor Designation</th>
					<?php
							$current_year = date('yy');
							if($year == $current_year)
							{
								$currentmonth = date('m');
							}else{
								$currentmonth='12';
							}
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
						echo "<tr class='DrillDownRow'><td class='text-center mrClicked' >";
						$val->supervisorname;
						
						echo $val->supervisorname;
						echo "</td><td class='text-center'>";
						echo $val->supervisor_type;
						for ($month = 1; $month <= $currentmonth; $month++) {
							 if($month < 10){
								   $month='0'.$month;
								}
							echo "</td><td class='text-center   '>"; 
							if( $val->{'plan'.$month} != NULL ){
						
							echo'<p class="text-center mrClicked "  data-quarter= "' .getQuater($month).'"  data-code="'.$val->supervisorname .'" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
						 
							}else{
								echo'<p class="text-center mrClicked "  data-quarter= ""style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								
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
	$('.DrillDownRow').on('click','.mrClicked', function(){
		var code = $(this).data('code');
		var report =01;
		var month = $(this).data('quarter');
		 if(code.toString().length == 7){
			url = "<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan_view/"+code+"/"+0+month+"/"+report;
			var win = window.open(url,'_self');
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}	 
	}); 
	
</script>
