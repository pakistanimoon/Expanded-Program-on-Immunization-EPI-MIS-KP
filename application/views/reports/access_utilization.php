<div class="container bodycontainer">
	<?php
		//kp	
		//echo "<pre>"; print_r($result);exit;
		echo $data['TopInfo'];		
	?>
	<!--table for mentioning colour meaning-->
	<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 5px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
		<thead>
			<tr style="background: white;color: black;">
				<th style="background:lightgreen;" class="">Category 1</th>
				<th style="width: 20%;" class="">Penta1 Coverage > 80% and Dropout < 10%</th>
				<th style="background: #33ACFF;" class="">Category 2</th>
				<th style="width: 20%;" class="">Penta1 Coverage > 80% and Dropout > 10%</th>
				<th style="background:  #EBD38F; " class="">Category 3</th>
				<th style="width: 20%;" class="">Penta1 Coverage < 80% and Dropout < 10%</th>
				<th style="background: lightcoral;" class="">Category 4</th>	
				<th style="width: 20%;" class="">Penta1 Coverage < 80% and > Dropout 10%</th>
			</tr>
			<?php if ($data['acces_type'] == 'ucwise' && $data['distcode'] > 0 ) { ?>			
				<tr style="background: white;color: black;">
					<th colspan="8"><p style=" color:red;"><strong>Note: </strong>Union Council Categorization with more Priority need more attention from Districts and Province Manager</p></th>
				</tr>
			<?php }	else if ($data['acces_type'] == 'facilitywise' && $data['distcode'] > 0 ) { ?>
				<tr style="background: white;color: black;">
					<th colspan="8"><p style=" color:red;"><strong>Note: </strong>Facilities Categorization with more Priority need more attention from Districts and Province Manager</p></th>
				</tr>
			<?php } else { ?>
				<tr style="background: white;color: black;">
					<th colspan="8"><p style=" color:red;"><strong>Note: </strong>Districts with more Priority need more attention from Districts and Province Manager</p></th>
				</tr>
			<?php } ?>	
			<?php if($data['distcode'] > 0) { ?>	
					<?php 
						if(isset($result[0]['coverage']) && isset($result[0]['dropout'])){
							$categoryNUmber = getCategory($result[0]['coverage'],$result[0]['dropout']);
							if($categoryNUmber == 'Category 1'){
								$backgroundColour = 'style="background:lightgreen;"';
							}
							if($categoryNUmber == 'Category 2'){
								$backgroundColour = 'style="background:#33ACFF;"';
							}
							if($categoryNUmber == 'Category 3'){
								$backgroundColour = 'style="background:#EBD38F;"';
							}
							if($categoryNUmber == 'Category 4'){
								$backgroundColour = 'style="background:lightcoral;"';
							}
						}
						else{
							$backgroundColour = '';
						} 
					?>
				<tr style="background: white;color: black;">					
					<th colspan="8" style="font-size: 17px;"><strong>District Category: </strong><span <?php echo $backgroundColour; ?>><?php echo getCategory($result[0]['coverage'],$result[0]['dropout']); ?></span>
					</th>
				</tr>
			<?php } ?>		
			<!--<tr style="background: white;color: black;">
			<th colspan="8"><p style=" color:red;"><strong>Note:</strong>Districts with more Priority need more attention form Districts and Province Manager</p></th>-->	
			<!--<tr>
			<th style="width: 20%; color:red;" class="">Note:</th>
			<th style=" color:red;" class="">Districts with more Priority need more attention form Districts and Province Manager </th>
			</tr>-->
		</thead>
	</table>	
	<!--table for mention colour mening-->	
	<div>
		<td>						
		</td>
	</div>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Priority</th>
				    <?php 
					if(isset($type_wise) AND $type_wise == 'Unioncouncil'){
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Unioncouncil</th>";
					}else if(isset($type_wise) AND $type_wise == 'facility'){
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Facilities</th>";
					}else{
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Districts</th>";

						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Total UC`s</th>";
					} ?>
					
					<!-- <th>Due</th>
					<th>Sub</th> -->
					<?php if(isset($type_wise) AND ($type_wise=='Unioncouncil' OR $type_wise='facility')) { ?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 1</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 2</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 3</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 4</th>
					<?php } else { ?>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category</th>
						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Category 1</th>

						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Category 2</th>

						<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Category 3</th>

						<th class="Heading text-center" style="background: 	#008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Category 4</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody id="tbody">  
				<?php
				$count =1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
					//print_r($result);
					$priority=1;
				 	foreach($result as $val)
					{	
						if(isset($val->coverage) && isset($val->dropout)){
							$categoryNUmber = getCategory($val->coverage,$val->dropout);
							if($categoryNUmber == 'Category 1'){
								$backgroundColour = 'style="background:lightgreen;"';
							}
							if($categoryNUmber == 'Category 2'){
								$backgroundColour = 'style="background:#33ACFF;"';
							}
							if($categoryNUmber == 'Category 3'){
								$backgroundColour = 'style="background:#EBD38F;"';
							}
							if($categoryNUmber == 'Category 4'){
								$backgroundColour = 'style="background:lightcoral;"';
							}
						}
						else{
							$backgroundColour = '';
						}
						if(isset($type_wise) AND $type_wise=='Unioncouncil'){
							echo "<tr class='DrillDownRow'></td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$priority."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo get_UC_Name($val['uncode']);
							echo "<input type='hidden'  value='". $val['uncode'] ."' class='.code' id='code'>";
							// echo "<td class='text-center'>".$priority."</td>";
							// echo "<td class='text-center'>".$val['due']."</td>";
							// echo "<td class='text-center'>".$val['sub']."</td>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							if($val['cat1'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat2'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat3'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat4'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td></tr>";
						}
						else if(isset($type_wise) AND $type_wise=='facility'){
							echo "<tr class='DrillDownRow'>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$priority."</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val['facilityname'];
							echo "<input type='hidden'  value='". $val['facode'] ."' class='.code' id='code'>";
							// echo "</td><td class='text-center'>".$priority."</td>";
							// echo "<td class='text-center'>".$val['due']."</td>";
							// echo "<td class='text-center'>".$val['sub']."</td>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							if($val['cat1'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat2'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat3'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
								if($val['cat4'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td></tr>";
						}
						else{
							echo "<tr class='DrillDownRow'>";
							echo "<td  style='text-align:center; border: 1px solid black;' class='text-center'>".$priority."</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo get_District_Name($val->distcode);
							echo "<input type='hidden' value='". $val->distcode ."' id='code'>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->totaluc;
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center' $backgroundColour>".getCategory($val->coverage,$val->dropout)."</td>";
							// echo "<td class='text-center'>".$val->due ."</td>";
							// echo "<td class='text-center'>".$val->sub ."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat1;
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo ($val->totaluc > 0)?round($val->cat1/$val->totaluc*100):0; echo "%";
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat2;
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo ($val->totaluc > 0)?round($val->cat2/$val->totaluc*100):0; echo "%";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat3;
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo ($val->totaluc > 0)?round($val->cat3/$val->totaluc*100):0; echo "%";
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat4;
							echo "</td><td  style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo ($val->totaluc > 0)?round($val->cat4/$val->totaluc*100):0; echo "%";
							echo "</td></tr>";
						}
						$priority++;
						$count++;
						
					}
					if(isset($total_query))
					{
						foreach ($total_query as $val) 
						{
							echo "<tr class='DrillDownRow' style='background: black;'><td colspan='2' class='text-center' style='color: white;'>";
							echo "Total:";
							echo "</td><td class='text-center' style='color: white;'>";
							// echo $val['totdue'];
							// echo "</td><td class='text-center' style='color: white;'>";
							// echo $val['totsub'];
							// echo "</td><td class='text-center' style='color: white;'>";
							echo $val['cat1'];
							echo "</td><td class='text-center' style='color: white;'>";
							echo $val['cat2'];
							echo "</td><td class='text-center' style='color: white;'>";
							echo $val['cat3'];
							echo "</td><td class='text-center' style='color: white;'>";
							echo $val['cat4'];
							echo "</td></tr>";
						}
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
		var code = $(this).find("td:nth-child(2)").find('input[type=hidden]').val();
		var monthfrom = "<?php echo $monthfrom ?>";
		var monthto = "<?php echo $monthto?>";
		var type_wise = 'Unioncouncil';
		if(code.toString().length == 3){
			url = "<?php echo base_url();?>reports/access_utilization/"+code+"/"+monthfrom+"/"+monthto+"/"+type_wise;
			var win = window.open(url);
			if(win){
				win.focus();
			}else{
				alert('Please allow popups for this site');
			}
		}		
	});
</script>