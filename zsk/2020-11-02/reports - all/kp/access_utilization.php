<div class="container bodycontainer">
	<?php
	//beta
	
	//echo "<pre>"; print_r($data);exit;
		echo $data['TopInfo'];
		//	echo "<pre>"; print_r($data);
	 ?>
	 <!--table for mention colour mening-->
				<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 5px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
					<thead>
						<tr style="background: white;color: black;">
							<th style="background:lightgreen ;" class="">Category 1</th>
							<th style="width: 20%;" class="">Penta1 > 80% Covrage and < 10% Dropout</th>
							<th style="background: #33ACFF;" class="">Category 2</th>
							<th style="width: 20%;" class="">Penta1 > 80% Covrage and > 10% Dropout</th>
							<th style="background:  #EBD38F; " class="">Category 3</th>
							<th style="width: 20%;" class="">Penta1 < 80% Covrage and < 10% Dropout</th>
							<th style="background: lightcoral ;" class="">Category 4</th>	
							<th style="width: 20%;" class="">Penta1 < 80% Covrage and > 10% Dropout</th>
								
															
						</tr>
						<?php if ($data['acces_type'] == 'ucwise' && $data['distcode'] > 0 ) { ?>			
						<tr style="background: white;color: black;">
						<th colspan="8"><p style=" color:red;"><strong>Note:</strong>UnionCouncil Categorization with more Periority need more attention form Districts and Province Manager</p></th>
						</tr>
						<?php }	else if ($data['acces_type'] == 'facilitywise' && $data['distcode'] > 0 ) { ?>
						<tr style="background: white;color: black;">
						<th colspan="8"><p style=" color:red;"><strong>Note:</strong>Facilities Categorization with more Periority need more attention form Districts and Province Manager</p></th>
						</tr>
						<?php }else{ ?>
						<tr style="background: white;color: black;">
						<th colspan="8"><p style=" color:red;"><strong>Note:</strong>Districts with more Periority need more attention form Districts and Province Manager</p></th>
						</tr>
						<?php } ?>
						
						<!----<tr style="background: white;color: black;">
						<th colspan="8"><p style=" color:red;"><strong>Note:</strong>Districts with more Periority need more attention form Districts and Province Manager</p></th>-->	
						<!--<tr>
						<th style="width: 20%; color:red;" class="">Note:</th>
						<th style=" color:red;" class="">Districts with more Periority need more attention form Districts and Province Manager </th>
						</tr>-->
					</thead>
				</table>	
				<!--table for mention colour mening-->	
				<div>
					<td >
						
					</td>
				</div>
	<div id="parent" style="overflow:auto">
		<table id="fixTable"  class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
				    <?php 
					if(isset($type_wise) AND $type_wise == 'Uniouncouncil'){
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Uniouncouncil</th>";
					}else if(isset($type_wise) AND $type_wise == 'facility'){
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Facilities</th>";
					}else{
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Districts</th>";
						echo "<th class='Heading text-center' style='background: #008d4c; color: white; width: 200px; border: 1px solid black;'>Total UC`s</th>";
					} ?>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Periority</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Due</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Sub</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 1</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 2</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 3</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Category 4</th>
				</tr>
			</thead>
			<tbody id="tbody">  
				<?php
				$count =1;
				unset($data['TopInfo']);
				unset($data['exportIcons']);
				$total = array();
				if(!empty($data)){
					$prioroty=1;
				 	foreach($result as $val)
					{
						if(isset($type_wise) AND $type_wise=='Uniouncouncil'){
							echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo get_UC_Name($val['uncode']);
							echo "<input type='hidden'  value='". $val['uncode'] ."' class='.code' id='code'>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>".$prioroty."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val['due']."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val['sub']."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>";
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
							echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val['facilityname'];
							echo "<input type='hidden'  value='". $val['facode'] ."' class='.code' id='code'>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>".$prioroty."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val['due']."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val['sub']."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>";
							if($val['cat1'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td class='text-center'>";
								if($val['cat2'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td class='text-center'>";
								if($val['cat3'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td><td class='text-center'>";
								if($val['cat4'] > 0){
									echo'<p class="text-center" style="color:green;font-weight: bold;font-size: 16px;">&#10004;</p>';
								}else{
									echo'<p class="text-center" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
								}
							echo "</td></tr>";
						}else{
							echo "<tr class='DrillDownRow'><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo get_District_Name($val->distcode);
							echo "<input type='hidden'  value='". $val->distcode ."' id='code'>";
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->totaluc;
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>".$prioroty."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val->due ."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>".$val->sub ."</td>";
							echo "<td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat1;
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat2;
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat3;
							echo "</td><td style='text-align:center; border: 1px solid black;' class='text-center'>";
							echo $val->cat4;
							echo "</td></tr>";
						}
						$prioroty++;
						$count++;
						
					}
					if(isset($total_query))
					{
						foreach ($total_query as $val) 
						{
							echo "<tr class='DrillDownRow'  style='background: black;'><td colspan='2' class='text-center' style='color: white; '>";
							echo "Total:";
							echo "</td><td class='text-center' style='color: white;'>";
							echo $val['totdue'];
							echo "</td><td class='text-center' style='color: white;'>";
							echo $val['totsub'];
							echo "</td><td class='text-center' style='color: white;'>";
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
		var code = $(this).find("td:nth-child(1)").find('input[type=hidden]').val();
		var monthfrom = "<?php echo $monthfrom ?>";
		var monthto = "<?php echo $monthto?>";
		var type_wise = 'Uniouncouncil';
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