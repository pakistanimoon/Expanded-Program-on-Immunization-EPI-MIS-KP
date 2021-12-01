
<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th>Technician Code</th>
					<th>Technician Name</th>
					<th>Submitted</th>
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
					    echo $val->techniciancode;
						echo "</td><td class='text-center'>";
						echo $val->technicianname;
						echo "</td><td class='text-center'>";
							if($val->submit > 0){
								echo'<p class="text-center mrClicked" data-submitted="submitted"  data-code="'. $val->techniciancode .'" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
							}else{
								echo'<p class="text-center mrClicked" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
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
<script type="text/javascript">		
	$(document).ready(function(){
		$('.DrillDownRow').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
	});			
	$('.DrillDownRow').on('click', function(){
		var year = $('#year').val();
		var filter_view=01;
		var code = $(this).find("td:nth-child(1)").text();	
		if(code.toString().length == 9){		
			url = "<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_view/"+code+"/"+year+"/"+filter_view;
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