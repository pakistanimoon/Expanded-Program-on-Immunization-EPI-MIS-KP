<?php //echo "<pre>";	print_r($data);exit;  ?><center>

<label>Product Batch Number wise usable NON Vaccine stock summary</label>

</center>

<center>


<table class="table table-bordered table-condensed" >

		<tr>

			<th rowspan="2" ><label>Sr No.</label></th>

			<th rowspan="2" ><label>Product</label></th>																
			<th rowspan="2" ><label>Batch Number</label></th>																
			<th rowspan="2" ><label>Manufacturer</label></th>																
			<th rowspan="2" ><label>VVM Name</label></th>																
			<th rowspan="2" ><label>Expire Date</label></th>																
			<th rowspan="2" ><label>Quantity</label></th>																
			<th rowspan="2" ><label>VVM Type Id</label></th>																
			<th rowspan="2" ><label>Placment</label></th>																
			<th rowspan="2" ><label>Priority</label></th>

			<th colspan="3" style="text-align:center;"><label>Quantity</label></th>

		</tr>

		<tr>

		<th ><label>Vials/Pcs</label></th>

		<th ><label>Doses Per Vials</label></th>

		<th><label>Total Doses</label></th>

		</tr>

	<?php 

	if(isset($searchResult) AND count($searchResult)>0){

			foreach($searchResult as $key=>$onerow){?>

				<tr>

					<td style="text-align:center;"><?php echo ($key+1); ?></td>
					<td><?php echo $onerow["itemname"]; ?></td>								
					<td><?php echo $onerow["batch"]; ?></td>									
					<td><?php echo $onerow["manufacturer"]; ?></td>	
					<td><?php echo $onerow["vvm_name"]; ?></td>		
					<td><?php echo $onerow["exp_date"]; ?></td>		
					<td><?php echo $onerow["quantity"]; ?></td>		
					<td><?php echo $onerow["vvm_type"]; ?></td>		
					<td><?php echo $onerow["placment"]; ?></td>		
					<td><?php echo $onerow["priority"]; ?></td>
					
					<td style="text-align:center;"><?php echo $onerow["quantity"]; ?></td>

					<td style="text-align:center;"><?php echo $onerow["doses"]; ?></td>

					<td style="text-align:center;"><?php echo ($onerow["doses"]*$onerow["quantity"]); ?></td>
				</tr>
			<?php
					}
						}
						?>						

</table>

</center>
