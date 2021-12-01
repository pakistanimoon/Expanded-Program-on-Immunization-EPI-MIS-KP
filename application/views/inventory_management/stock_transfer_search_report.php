<Center>
<label><b>Date From :</b></label><label ><?php echo $date_from;?></label><label style="padding-left:15px"><b>Date TO :</b></label><label><?php echo $date_to;?></label>
</center>
<table class="table table-bordered table-condensed mytable3" border="1" id="table">
						<thead>
						<?php if(!isset($_REQUEST['export_excel'])){?>
							<tr>
								<th colspan="8" style="padding-top: 10px; padding-bottom: 10px;"><label>Stock Transfer History</label></th>
							</tr>
						<?php }?>
						
							<tr>
								<td style="text-align:center;"><label>Sr No.</label></th>
								<td style="text-align:center;"><label>Date</label></th>
								<td style="text-align:center;"><label>Adjustment No.</label></th>
								<td style="text-align:center;"><label>Transfer From</label></th>
								<td style="text-align:center;"><label>Transfer To</label></th>
								<td style="text-align:center;"><label>Batch No.</label></th>
								<td style="text-align:center;"><label>Quantity</label></th>
								<td style="text-align:center;"><label>Adjustment Type</label></th>
							</tr>
							</thead>
						<tbody>
							<?php 
							if(empty($searchResult))
							{ ?>
								<tr>
									<td colspan="13" style="text-align:center;">
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
										<td><?php get_transfer_from(false,$value['transaction_type_id'],$value['stock_batch_id']); ?></td>
										<td><?php get_transfer_to(false,$value['transaction_type_id'],$value['stock_batch_id']); ?></td>
										<td><?php echo $value['number']; ?></td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $value['adjustment_type']; ?></td>
										
									</tr>
								<?php 
								}
							} ?>
						</tbody>
					</table>