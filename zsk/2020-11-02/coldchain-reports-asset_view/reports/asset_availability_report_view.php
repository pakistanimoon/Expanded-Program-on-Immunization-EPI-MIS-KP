<?php //print_r($Assetresult); exit;?>

<div class="container bodycontainer">
<?php 
if($TopInfo!=''){
     echo $TopInfo;
  }
   //echo $htmlData; 
  ?>
  <div id="parent" style="overflow:auto">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Serial No.</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Code</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="3">Store Name</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3" style="text-align:center">Geo Location
					</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">No of Assets</th>
				</tr>
				<tr>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">UC</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Tehsil</th>
					<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">District</th>
				</tr>
				
			</thead>
			<tbody>
			<?php if(!$Assetresult==0){?>
			<?php foreach($Assetresult as $key => $val){ ?>
				<tr class="DrillDownRow" style="cursor: pointer;">
				    <td style="text-align:center; border: 1px solid black;" class="text-center">
						<?php echo $key+1; ?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storecode']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['storename']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['ucname']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['tehsil']; ?></td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($val['warehouse_type_id']=="Unallocated"){ ?>
					<?php echo $val['districtstroename']; ?>
					<?php  }else {?>
					<?php echo $val['district']; ?>
					<?php }?>
					</td>
					<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $val['b']; ?></td>
				</tr>
			<?php } ?>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'></td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'>Total:</td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'></td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'></td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'></td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'></td>
			<td class='text-center' style='font-weight:bold; background-color: #111;color: #FFF;'><?php echo $result[0]['totalvalue']; ?></td>
			
			<?php } else {?>
					<tr><td style="text-align:center; border: 1px solid black;" class="text-center"></td><td style="text-align:center; border: 1px solid black;" class="text-center" colspan='32' class='text-center'><strong> No Record Found </strong></td>
				<?php }?>
			</tbody>
			
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://epibeta.pacemis.com/includes/js/tableHeadFixer.js"></script>
<script src="http://epibeta.pacemis.com/includes/bootstrap/js/bootstrap.min.js"></script>
<script>
		  $(document).ready(function() {
				$("#fixTable").tableHeadFixer(); 
			}); 
	</script>