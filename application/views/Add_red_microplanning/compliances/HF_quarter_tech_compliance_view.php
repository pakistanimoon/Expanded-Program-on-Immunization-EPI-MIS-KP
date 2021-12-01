<div class="container bodycontainer">
	<?php
		echo $data['TopInfo'];
		
	 ?>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    
					<th>Tecnician Code</th>
					<th>Tecnician Name</th>
					<?php
						    $month = date('m');
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
						for ($qurt = 1; $qurt <= $quarter; $qurt++){
							echo "</td><td id='".$qurt."' class='text-center'>";
							if(isset($val->{'q'.$qurt}) AND $val->{'q'.$qurt} > 0){
							//	echo'<p class="text-center mrClicked" id="'.$qurt.'"  data-code="'.$val->techniciancode .'" data-quarter="'.$qurt.'" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
							echo '<span class="badge mrClicked" data-code="'.$val->techniciancode .'" data-quarter="'.$qurt.'" style="background: green; width: 100px;">Totel site '.$val->{'totalsite'.$qurt}.'</span><br>';
							echo '<span class="badge mrClicked" data-code="'.$val->techniciancode .'" data-quarter="'.$qurt.'" style="background: blue; width: 100px;">Scheduled '.$val->{'schedule'.$qurt}.'</span><br>';
							echo '<span class="badge mrClicked" data-code="'.$val->techniciancode .'" data-quarter="'.$qurt.'" style="background: orange; width: 100px;">Held &nbsp;  '.$val->{'held'.$qurt}.'</span>';
							}else{
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
<script type="text/javascript">
	$(document).ready(function(){
		$('.DrillDownRow').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
	});
		$(document).on('click','.mrClicked', function(){
			var quarter = $(this).data('quarter');
			//alert(quarter);
			var code = $(this).data('code');
			if(code.toString().length == 9){
			url = "<?php echo base_url();?>red_rec_microplan/RedRec_compliances/RedRec_HF_tech_compilation_compliance?techniciancode="+code+"&quarter="+quarter;
			var win = window.open(url,'_blank');
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		} 
		});
</script>