<!-- handle none parameter for Detail Report -->
	<?php 
 if($groupBy=="none"){
	 if(!isset($_REQUEST['export_excel'])){
	echo '<center><label style="padding:5px">Stock Issue List</label></center>';
	 }
 ?>
	<table class="table table-bordered table-condensed mytable3" border ="1" id="table">
						<thead>
						<tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Issue/Dispatch Date</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Issue No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Store Location</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Issue To</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Ref No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Batch No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>
								<th rowspan="2" style="text-align:center;"><label>Unit</label></th>
								<th rowspan="2" style="text-align:center;"><label>Expiry Date</label></th>
								<th rowspan="2" style="text-align:center;"><label>Created On</label></th>
								<th  colspan="3" style="text-align:center;"><label>Quantity</label></th>
						</tr>
						<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th style="text-align:center;"><label>Doses per Vial</label></th>
								<th style="text-align:center;"><label>Total Doses</label></th>
						</tr>
					  </thead>
					 <tbody>
							<?php $totaolDoses=$totalVials=0;
							if(empty($searchResult))
							{ ?>
								<tr>
									<td colspan="14" style="text-align:center;">
										No data available
									</td>
								</tr>
							<?php 
							}else
							{
								foreach($searchResult as $key => $value)
								{ ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $value['transaction_date']; ?></td>
										<td><?php echo $value['transaction_number']; ?></td>
										<td><?php echo $value['storelocation']; ?></td>
										<td><?php get_store_name(false,$value['to_warehouse_type_id'],$value['to_warehouse_code']); ?></td>
										<td><?php echo $value['transaction_reference']; ?></td>
										<td><?php echo $value['itemname']; ?></td>
										<td><?php echo $value['number']; ?></td>
										<td><?php echo $value['manufacturer']; ?></td>
										<td><?php echo $value['unit']; ?></td>
										<td><?php echo $value['expiry_date']; ?></td>
										<td><?php echo $value['created_date']; ?></td>
										<td><?php $totalVials=$totalVials+$value['quantity'];echo $value['quantity']; ?></td>
										<td><?php echo $value['doses']; ?></td>
										<td><?php $totaolDoses=$totaolDoses+($value['doses']* $value['quantity']);echo ($value['quantity'].$value['doses']); ?></td>
										
									</tr>
								<?php 
								}
							} ?>
							<tr>
									<th style="text-align:center" colspan="12">Total</th><td><?php echo $totalVials;?></td><td></td><td><?php echo $totaolDoses;?></td>
							</tr>
						</tbody>	
					</table>
<?php }else {?>
<?php if(!isset($_REQUEST['export_excel'])){ ?>
<center><label style="padding:5px"><?php echo $groupBy."	Wise Stock Issue Detail";?></label></center>
<center>
<?php	
	/** Unique product contaion itemname/Location on base of parameter send by User  **/
	if(!empty($uniqueProd)){
	foreach($uniqueProd as $k=>$val)
	{
		$i=1;$total_vials=$totaol_doses=$total_doses_per_vials=0;   
		echo $val;
		echo '<table class="table table-bordered table-condensed" >';
		echo '<tr>';
		echo '<th rowspan="2">Sr No.</th>';
		echo '<th rowspan="2">Issue/Dispatch Date</th>';
		echo '<th rowspan="2">Store Location</th>';
		// Product Wise Table Th
		if($groupBy=="Product")
		{
			echo '<th rowspan="2">Issue To</th>';
		}
		// Location Wise Table Th	
		else
		{
			echo '<th rowspan="2">Product</th>';
		}
		echo '<th rowspan="2">Issue No</th>';
		echo '<th rowspan="2">Manufacturer</th>';
		echo '<th rowspan="2">Unit</th>';
		echo '<th rowspan="2">Expiray Date</th>';
		echo '<th rowspan="2">Created Date</th>';
		echo '<th rowspan="2">Batch No.</th>';
		echo '<th style="text-align:center" colspan="3">Quantity</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<th>Vials/Pcs</th>';
		echo '<th>Doses Per Vials</th>';
		echo '<th>Total Doses</th>';
		echo '</tr>';
			if(!empty($searchResult)){
			foreach($searchResult as $key=>$value)
			{
				echo '<tr>';
			  //Product Wise Detail 	
			   if($groupBy=="Product")
			   {
					if($val==$value['itemname'])
					{
						echo '<td>';echo $i++;echo '</td>';
						echo '<td>';echo $value['transaction_date'];echo '</td>';
						echo '<td>';echo $value['storelocation'];echo '</td>';
						echo '<td>';get_store_name(false,$value['to_warehouse_type_id'],$value['to_warehouse_code']);echo '</td>';
						echo '<td>';echo $value['transaction_number'];echo '</td>';
						echo '<td>';echo $value['manufacturer'];echo '</td>';
						echo '<td>';echo $value['unit'];echo '</td>';
						echo '<td>';echo $value['expiry_date'];echo '</td>';
						echo '<td>';echo $value['created_date'];echo '</td>';
						echo '<td>';echo $value['number'];echo '</td>';
					    echo '<td>';$total_vials=$total_vials+$value['quantity'];echo $value['quantity'];echo '</td>';
						echo '<td>';$total_doses_per_vials=$total_doses_per_vials+$value['doses'];echo $value['doses'];echo '</td>';
						echo '<td>';$totaol_doses=$totaol_doses+($value['doses']* $value['quantity']);echo ($value['doses']* $value['quantity'] );echo '</td>';
		               
					}
				}
				// Location Wise Detail 	
				else if($groupBy=="Location")
				{
					if($val==get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']) )
					{
		  
						echo '<td>';echo $i++;echo '</td>';
						echo '<td>';echo $value['transaction_date'];echo '</td>';
						echo '<td>';echo $value['storelocation'];echo '</td>';
						echo '<td>';echo $value['itemname'];echo '</td>';
						echo '<td>';echo $value['transaction_number'];echo '</td>';
						echo '<td>';echo $value['manufacturer'];echo '</td>';
						echo '<td>';echo $value['unit'];echo '</td>';
						echo '<td>';echo $value['expiry_date'];echo '</td>';
						echo '<td>';echo $value['created_date'];echo '</td>';
						echo '<td>';echo $value['number'];echo '</td>';
						echo '<td>';$total_vials=$total_vials+$value['quantity'];echo $value['quantity'];echo '</td>';
						echo '<td>';$total_doses_per_vials=$total_doses_per_vials+$value['doses'];echo $value['doses'];echo '</td>';
						echo '<td>';$totaol_doses=$totaol_doses+($value['doses']* $value['quantity']);echo ($value['doses']* $value['quantity'] );echo '</td>';
			 
					}
				}
				//Detail radio button:none will be separate above: as current report 
				else{}
		
		}
			}	
		  echo '</tr>';
	echo '<tr>';
			echo '<th style="text-align:center" colspan="10">';echo 'Total';echo '</th>';
		echo '<td>';echo $total_vials;echo '</td>';echo '<td></td>';echo '<td>';echo $totaol_doses;echo '</td>';
	echo '</tr>';
		echo '</table>';	
		   
		  
	}
	}
       }
	}?>
<?php if(!isset($_REQUEST['export_excel'])){?>	
</center>
<br></br>
<label>Prepared By : </label><?php echo $this->session->username;?>
<label>Print Date : </label><?php echo date('Y-m-d');?>
<?php }?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$(function() {
	window.print();
});
</script>
												
