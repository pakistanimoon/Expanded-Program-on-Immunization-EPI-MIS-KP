<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=http%3A%2F%2F<?php echo "epimis.cres.pk//StockReceivefromStore/$vouchernum";?>%2F&choe=UTF-8" style="background: red;
position: absolute; right: 20px;"/>
<center>
	<label style="padding-left:15px">Date : </label>
	<span style="positon:center"><?php echo $output[0]['transaction_date'];?></span>
	<label style="padding-left:15px">Voucher #: </label>
	<span style="positon:center"><?php echo $vouchernum?></span>
	<label style="padding-left:15px">From Warehouse: </label>
	<span style="positon:center;padding-left:15px">
		<?php echo get_store_name(false,$output[0]['from_warehouse_type_id'],$output[0]['from_warehouse_code']);?>
	</span>
	<label style="padding-left:15px">To Warehouse: </label>
	<span style="positon:center;padding-left:15px">
		<?php echo get_store_name(false,$output[0]['to_warehouse_type_id'],$output[0]['to_warehouse_code']);?>
	</span>
</center>
<center>
	<table class="" width="70%" cellpadding="0" border="0">
		<tr>
			<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
			<th rowspan="2" style="text-align:center;"><label>Product</label></th>
			<th rowspan="2" style="text-align:center;"><label>Store Location</label></th>
			<th rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>
			<th rowspan="2" style="text-align:center;"><label>Batch No.</label></th>
			<th colspan="3" style="text-align:center;"><label>Quantity</label></th>
			<th rowspan="2" style="text-align:center;"><label>Expiry Date</label></th>
		</tr>
		<tr>
			<th style="text-align:center;"><label>Vials/Pcs</label></th>
			<th style="text-align:center;"><label>Doses per Vial</label></th>
			<th style="text-align:center;"><label>Total Doses</label></th>
		</tr><?php
		foreach($output as $key=>$value){?>
			<tr>
				<td style="text-align:center;"><?php echo $key+1; ?></td>
				<td><?php echo $value['itemname'];
					if(in_array($value['itemname'],$uniqueProd))
					{
						$sum[$value['itemname']] = (isset($sum[$value['itemname']])?$sum[$value['itemname']]:0)+$value['quantity'];
						$total[$value['itemname']] = (isset($total[$value['itemname']])?$total[$value['itemname']]:0)+($value['quantity']*$value['doses']);
					}?>
				</td>
				<td><?php echo $value['storelocation']; ?></td>
				<td><?php echo $value['manufacturer']; ?></td>
				<td><?php echo $value['number']; ?></td>
				<td style="text-align:center;"><?php echo $value['quantity']; ?></td>
				<td style="text-align:center;"><?php echo $value['doses']; ?></td>
				<td style="text-align:center;"><?php echo ($value['quantity']* $value['doses']); ?></td>
				<td><?php echo $value['expiry_date']; ?></td>
			</tr><?php
		}?>
	</table>
	<br><br>
</center>	
<center><label>Summary</label></center>	
<center>
	<table class="" width="70%" cellpadding="0" border="0">
		<tr>
			<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
			<th rowspan="2" style="text-align:center;"><label>Product</label></th>
			<th colspan="2" style="text-align:center;"><label>Net. Rec Quantity</label></th>
		</tr>
		<tr>
			<th style="text-align:center;"><label>Vials/Pcs</label></th>
			<th style="text-align:center;"><label>Total Doses</label></th>
		</tr><?php 
		$i=1;$j=0;
		foreach($uniqueProd as $key=>$prod){?>
			<tr>
				<td style="text-align:center;"><?php echo $i++; ?></td>
				<td><?php echo $prod; ?></td>
				<td style="text-align:center;"><?php echo $sum[$prod]; ?></td>
				<td style="text-align:center;"><?php echo $total[$prod]; ?></td>
			</tr><?php 
		}?>	
	</table>
</center>
<br></br>
<center>
	<table class="" width="70%" cellpadding="0" border="0">
		<tr>
			<td>
				<label>Issued by:</label>	.........................................................
			</td>
			<td>
				<label>Received by:</label>	.........................................................
			</td>
		</tr>
		<tr>
			<td>
				Name:	.........................................................
			</td>
			<td>
				Name:	.........................................................
			</td>
		</tr>
		<tr>
			<td>
				Designation:	.........................................................
			</td>
			<td>
				Designation:	.........................................................
			</td>
		</tr>
		<tr>
			<td>
				Date:	.........................................................
			</td>
			<td>
				Date:	.........................................................
			</td>
		</tr>
		<tr>
			<td>
				<label>Prepared By</label> : <?php echo $this->session->username;?>
			</td>
			<td>
				<label>Print Date</label> : <?php echo date('Y-m-d');?>
			</td>
		</tr>
	</table>
</center>
<br><br>