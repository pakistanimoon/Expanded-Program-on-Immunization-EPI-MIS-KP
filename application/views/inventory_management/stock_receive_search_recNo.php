<center><label>Stock Receive Voucher</label></center>
<center><label style="padding-left:15px">Date : </label><span style="positon:center"><?php echo $searchResult[0]['transaction_date'];?></span><label style="padding-left:15px">#Receive Voucher : </label><span style="positon:center"><?php echo $recNo?></span><label style="positon:center;padding-left:15px">From (Issued By):</label><span style="positon:center;"><?PHP if($searchResult[0]['from_warehouse_type_id']==7){ echo "Funding Source-";}?><?php echo get_store_name(false,$searchResult[0]['from_warehouse_type_id'],$searchResult[0]['from_warehouse_code']);?></span><label style="positon:center;padding-left:15px">To (Received By):</label><span style="positon:center;"><?php echo get_store_name(false,$searchResult[0]['to_warehouse_type_id'],$searchResult[0]['to_warehouse_code']);?></span><label  style="padding-left:15px">Purpose:</label><span style="positon:center;"><?php echo $searchResult[0]['purpose'];?></span></center>
<center>
<table class="table-bordered table-custom" id="table">
					<thead>			
						<tr>
								<th rowspan="2" style="text-align:center;verticle-align:middle;"><label>Sr No.</label></th>
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
						</tr>
				</thead>			
                       <?php
							
					   foreach($searchResult as $key=>$value)
						{?>
								<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $value['itemname'];if(in_array($value['itemname'],$uniqueProd))
											{
											$sum[$value['itemname']] = (isset($sum[$value['itemname']])?$sum[$value['itemname']]:0)+$value['quantity'];
											$total[$value['itemname']] = (isset($total[$value['itemname']])?$total[$value['itemname']]:0)+($value['quantity']*$value['doses']);
											} ?></td>
											<td><?php echo $value['storelocation']; ?></td>
										<td><?php echo $value['manufacturer']; ?></td>
										<td><?php echo $value['number']; ?></td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $value['doses']; ?></td>
										<td><?php echo ($value['quantity']* $value['doses']); ?></td>
									    <td><?php echo $value['expiry_date']; ?></td>
								</tr>					
				<?php
				} ?>
</table>
<br><br>
</center>	
<center><label>Summary</label></center>	
<center>
<table class="table-bordered table-custom"  id="table">
						<thead>		
							<tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th colspan="2" style="text-align:center;"><label>Net. Rec Quantity</label></th>
							</tr>
							<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th style="text-align:center;"><label>Total Doses</label></th>
							</tr>
						</thead>	
							<?php $i=1;$j=0;
							foreach($uniqueProd as $key=>$prod)
							{?>
                           	<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $prod; ?></td>
										<td><?php echo $sum[$prod]; ?></td>
										<td><?php echo $total[$prod]; ?></td>
							</tr>
							<?php }?>	
</table>
</center>
<br></br>

<table style="float:left">
<tr>
<td>
<label>Issued by:</label>	.........................................................
</td>
</tr>
<tr>
<td>
Name:	.........................................................
</td>
</tr>
<tr>
<td>
Designation:	.........................................................
</td>
</tr>
<tr>
<td>
Date:	.........................................................
</td>
</tr>
</table>
<table style="float:left">
<tr>
<td>
<label>Received by:</label>	.........................................................
</td>
</tr>
<tr>
<td>
Name:	.........................................................
</td>
</tr>
<tr>
<td>
Designation:	.........................................................
</td>
</tr>
<tr>
<td>
Date:	.........................................................
</td>
</tr>
</table>
						
<br></br>
<label>Prepared By : </label><?php echo $this->session->username;?>
<label>Print Date : </label><?php echo date('Y-m-d');?>

									
