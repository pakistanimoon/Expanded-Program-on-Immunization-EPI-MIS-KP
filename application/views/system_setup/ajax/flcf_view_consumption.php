<!-- loaded through ajax in flcf view-->
<style>
table.equal-heading tr th{
	width:20% !important;
}
</style>
<div class="panel-heading" style="color:white;">Inventory(Stock)- From Closing Balance Consumption Report(<?php echo $flcf_consumption[0]['fmonth']; ?>)
</div>
<div style="margin-top:1px;">
	<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing equal-heading" data-filter="#filter" data-filter-text-only="true">
		  <thead>
				  <tr>
					<th class="text-center Heading">Item</th>
					<th class="text-center Heading">No. of doses in vial</th> 
					<th class="text-center Heading">No. of available batches</th>				
					<th class="text-center Heading">Available Quantity in Vials</th>
					<th class="text-center Heading">Available Quantity in Doses</th>       
				  </tr>
				</thead>
		<tbody id="ajax_data" style="text-align:center;"> 
	<?php                                
		foreach($flcf_consumption as $key=>$singlerec){
	 ?>
			<tr class="DrilledDown">
			<td class="text-left">
				<span><?php echo $singlerec["item"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["batch_doses"] ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["batch_number"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["closing_vials"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["closing_doses"]; ?></span>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
