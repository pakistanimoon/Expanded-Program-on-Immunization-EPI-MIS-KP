
<center><label style="padding:5px">Store :</label><label style="padding:5px"><?php get_store_name(false,$searchResult[0]['to_warehouse_type_id'],$searchResult[0]['to_warehouse_code']); ?></label></center>
<br>
<center><label style="padding:5px">Stock Adjustment</label></center>

<table class="table table-bordered table-condensed mytable3" border="1" id="table">
						<thead>
							<?php if(!isset($_REQUEST['export_excel'])) {?><tr>
								<th colspan="12" style="padding-top: 10px; padding-bottom: 10px;"> <label>Search Adjustments</label></th>
							</tr>
							<?php }?>
							<tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Date</label></th>
								<th rowspan="2" style="text-align:center;"><label>Adjustment No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Ref No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th rowspan="2" style="text-align:center;"><label>Batch No.</label></th>
								<th colspan="3" style="text-align:center;"><label>Quantity</label></th>
								<th rowspan="2" style="text-align:center;"><label>Location</label></th>
								<th rowspan="2" style="text-align:center;"><label>Adjustment Type</label></th>
								<th rowspan="2" style="text-align:center;"><label>Comments</label></th>
								
								
							</tr>
							<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th style="text-align:center;"><label>Doses per Vial</label></th>
								<th style="text-align:center;"><label>Total Doses</label></th>
						</tr>
							</thead>
						<tbody>
							<?php 
							if(empty($searchResult))
							{ ?>
								<tr>
									<td colspan="10" style="text-align:center;">
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
										<td><?php echo $value['transaction_reference']; ?></td>
										<td><?php echo $value['itemname']; ?></td>
										<td><?php echo $value['number']; ?></td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $value['doses']; ?></td>
										<td><?php echo ($value['quantity']* $value['doses'] ); ?></td>
										<td><?php if($value['ccm_id']!=NULL){get_ccm_name(false,$value['ccm_id']);}else if($value['non_ccm_id']!=NULL){get_non_ccm_name(false,$value['non_ccm_id']);}else{echo "";} ?></td>
										<td><?php echo $value['transaction_type_id']; ?></td>
										<td><?php echo $value['comments']; ?></td>
										
										
									</tr>
								<?php 
								}
							} ?>
						</tbody>
					</table>
<br></br>					
<table style="float:left">
<tr>
<td>
<label>Adjustments by - Name:</label>	.........................................................
</td>
</tr>

<tr>
<td>
Designation:	.........................................................
</td>
</tr>
<tr>
<td>
Signature::	.........................................................
</td>
</tr>
</table>					
<br>