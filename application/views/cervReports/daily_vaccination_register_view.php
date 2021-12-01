<div class="container bodycontainer">
<?php 
	if($TopInfo!=''){
		echo $TopInfo;
	}
$total_bcg = $total_opv = $total_penta = $total_ipv= $total_pcv= $total_measles = 0;
	foreach($PVRresult as $key2 => $val2){ 			
			 $total_bcg = $total_bcg + count($val2['bcg']);
			 $total_opv = $total_opv + count($val2['opv0']) + count($val2['opv1']) + count($val2['opv2']) + count($val2['opv3']);
			 $total_penta = $total_penta + count($val2['penta1']) + count($val2['penta2']) + count($val2['penta3']);
			 $total_ipv = $total_ipv + count($val2['ipv']);
			 $total_pcv = $total_pcv + count($val2['pcv10_1']) + count($val2['pcv10_2']) + count($val2['pcv10_3']);
			 $total_measles = $total_measles + count($val2['measles1']) + count($val2['measles2']);

			 //$total_opv2 = $total_opv2 + count($val2['opv2']);
			 //$total_opv3 = $total_opv3 + count($val2['opv3']); 
	}
	
	?><div class="col-xs-3">
    	   			<table class="table rpt-tmp-table" >
    	   				<tbody>
			
						<tr>
    	   						<td><label>BCG</label></td>
    	   						<td><?php echo $total_bcg; ?></td>
    	   					</tr>
    	   					<tr>
    	   						<td><label>OPV</label></td>
    	   						<td><?php echo $total_opv; ?></td>
    	   					</tr>
    	   					<tr>
    	   						<td><label>Pentavalent</label></td>
    	   						<td><?php echo $total_penta?></td>
    	   					</tr>

    	   				</tbody>
    	   			</table>
    	   		</div>
				 <div class="col-xs-3" style="margin-left: 630px;">
    	   			<table class="table rpt-tmp-table">
    	   				<tbody>
    	   					<tr>
    	   						<td><label>IPV</label></td>
    	   						<td><?php echo $total_ipv; ?></td>
    	   					</tr>
    	   					<tr>
    	   						<td><label>PCV10</label></td>
    	   						<td><?php echo $total_pcv; ?></td>
    	   					</tr>
    	   					<tr>
    	   						<td><label>Meseales</label></td>
    	   						<td><?php echo $total_measles; ?></td>
    	   					</tr>
    	   					<!--<tr>
    	   						<td><label>TT</label></td>
    	   						<td>200</td>
    	   					</tr>-->
    	   				</tbody>
    	   			</table>
    	   		</div>
	<div id="parent" style="margin-top: 190px;">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th rowspan="3">Serial No.</th>
					<th rowspan="3">Card No.</th>
					<th rowspan="3">Name</th>
					<th rowspan="3">Paternity with Nationality</th>
					<th rowspan="3">Complete Address</th>
					<th rowspan="3">Date of Birth</th>
					<th colspan="15" style="text-align:center">Date of Vaccination</th>
				</tr>
				<tr>
					<th rowspan="2">BCG</th>
					<th colspan="4">OPV</th>
					<th colspan="3">Pentavalent</th>
					<th colspan="3">PCV10</th>
					<th colspan="">IPV</th>
					<th colspan="2">Measles</th>
				</tr>
				<tr>
					<th>0</th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th></th>
					<th>1</th>
					<th>2</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			foreach($PVRresult as $key => $val){ ?>
				<tr>
					<td><?php echo $key+1; ?></td>
					<td><?php echo $val['childcode']; ?></td>
					<td><?php echo $val['name_of_child']; ?></td>
					<td><?php echo $val['fname']; ?></td>
					<td><?php echo $val['address']; ?></td>
					<td><?php echo $val['date_of_birth']; ?></td>
					<td><?php /*echo  $val['bcg']; */ if($val['bcg'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';}else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['opv0']; */if($val['opv0'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';}else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['opv1']; */ if($val['opv1'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';}else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['opv2']; */ if($val['opv2'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					} ?></td> 
					<td><?php /* echo $val['opv3']; */ if($val['opv3'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['penta1']; */ if($val['penta1'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['penta2']; */ if($val['penta2'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['penta3']; */ if($val['penta3'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['pcv10_1']; */ if($val['pcv10_1'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['pcv10_2'];*/if($val['pcv10_2'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['pcv10_3']; */ if($val['pcv10_3'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['ipv']; */ if($val['ipv'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['measles1']; */ if($val['measles1'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
					<td><?php /* echo $val['measles2']; */ if($val['measles2'] != NULL){
					echo '<p class="text-center" title="Not Submitted" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>' ; }else{
						echo '<p class="text-center" title="Not Submitted" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';
					}?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
	});
</script>