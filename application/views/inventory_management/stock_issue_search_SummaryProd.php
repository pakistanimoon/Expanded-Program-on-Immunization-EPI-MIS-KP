
<center><label style="padding:5px"><?php echo $summaryType."	Wise Stock Issue Summary";?></label><label style="padding:5px">Date From  : </label><label style="padding:5px"><?php echo $date_from;?></label><label style="padding:5px">Date To  : </label><label style="padding:5px"><?php echo $date_to;?></label></center>
<center>
<?php	
	/** Unique product contaion itemname/Location on base of parameter send by User  **/
	foreach($uniqueProd as $k=>$val)
	{
		$i=1;$total_vials=$total_doses=$total_doses_per_vials=0;     
		echo $val;
		echo '<table  class="table table-bordered table-condensed"  >';
		echo '<tr>';
		echo '<th rowspan="2">Sr No.</th>';
		echo '<th rowspan="2">Issue/Dispatch Date</th>';
		echo '<th rowspan="2">Store Location</th>';
		// Product Wise Table Th
		if($summaryType=="Product")
		{
			echo '<th rowspan="2">Issue To</th>';
		}
		// Location Wise Table Th	
		else
		{
			echo '<th rowspan="2">Product</th>';
		}		
		echo '<th style="text-align:center" colspan="3">Quantity</th>';
		echo '</tr>';
		echo '<tr>';
		echo '<th>Vials/Pcs</th>';
		echo '<th>Doses Per Vials</th>';
		echo '<th>Total Doses</th>';
		echo '</tr>';
		
		foreach($searchResult as $key=>$value)
		{
				echo '<tr>';
			  //Product Wise Summary 	
			   if($summaryType=="Product")
			   {
					if($val==$value['itemname'])
					{
						echo '<td>';echo $i++;echo '</td>';
						echo '<td>';echo $value['transaction_date'];echo '</td>';
						echo '<td>';echo $value['storelocation'];echo '</td>';
						echo '<td>';get_store_name(false,$value['to_warehouse_type_id'],$value['to_warehouse_code']);echo '</td>';
						echo '<td>';$total_vials=$total_vials+$value['quantity'];echo $value['quantity'];echo '</td>';
						echo '<td>';$total_doses_per_vials=$total_doses_per_vials+$value['doses'];echo $value['doses'];echo '</td>';
						echo '<td>';$total_doses=$total_doses+($value['doses']* $value['quantity']);echo ($value['doses']* $value['quantity'] );echo '</td>';
					}
				}
				// Location Wise Summary	
				else
				{
					if($val==get_store_name(true,$value['to_warehouse_type_id'],$value['to_warehouse_code']) )
					{
		  
						echo '<td>';echo $i++;echo '</td>';
						echo '<td>';echo $value['transaction_date'];echo '</td>';
						echo '<td>';echo $value['storelocation'];echo '</td>';
						echo '<td>';echo $value['itemname'];echo '</td>';
						echo '<td>';$total_vials=$total_vials+$value['quantity'];echo $value['quantity'];echo '</td>';
						echo '<td>';$total_doses_per_vials=$total_doses_per_vials+$value['doses'];echo $value['doses'];echo '</td>';
						echo '<td>';$total_doses=$total_doses+($value['doses']* $value['quantity']);echo ($value['doses']* $value['quantity'] );echo '</td>';
					
			 
					}
				}
		
		}
		  echo '</tr>';
	echo '<tr>';
			echo '<th style="text-align:center" colspan="4">';echo 'Total';echo '</th>';
			echo '<td>';echo $total_vials;echo '</td>';echo '<td></td>';echo '<td>';echo $total_doses;echo '</td>';
	echo '</tr>';
		echo '</table>';	
		   
		  
	}?>
</center>
<br></br>
<label style="padding:15px">Prepared By : </label><?php echo $this->session->username;?>
<label style="padding:15px">Print Date : </label><?php echo date('Y-m-d');?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$(function() {
	window.print();
});
</script>
									
