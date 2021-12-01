<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th>Distcode</th>
					<th>Distname</th>
					<th>Due</th>
					<?php
					$current_year = date('yy');
							//print_r($current_year);exit;
							if($year == $current_year)
							{
								$month = date('m');
							}else{
								$month='11';
							}
						 	if($month >=1 && $month <=2){
								$quarter='1';
							}elseif($month >=3 && $month <=5 ){
								$quarter='2';
							}elseif($month >=6 && $month <=8 ){
								$quarter='3';
							}elseif($month >=9 && $month <=11 ){
								$quarter='4';
							}else{
								$quarter='1';
							}   
							for ($qurt = 1; $qurt <= $quarter; $qurt++) {
								echo '<th>Quarter '.$qurt.' </th>';
							}
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
					    echo $val->distcode;
						echo "</td><td class='text-center'>";
						echo $val->district;
						echo "</td><td class='text-center'>";
						echo $val->due;
						for ($qurt = 1; $qurt <= $quarter; $qurt++) {
							echo "</td><td class='text-center'>";
							//echo $val->{'submit'.$qurt};
							echo (isset($val->{'submit'.$qurt}))?$val->{'submit'.$qurt}:'0';
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
<script type="text/javascript">
	$(document).ready(function(){
		//$("#fixTable").tableHeadFixer({"left" : 1});
		$('.DrillDownRow').css('cursor','pointer');
	});
  	$('.DrillDownRow').on('click', function(){
		var year = $('#year').val();
		var code = $(this).find("td:nth-child(1)").text();
		if(code.toString().length == 3){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_quarter_tech_compliance?distcode="+code+"&year="+year;
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