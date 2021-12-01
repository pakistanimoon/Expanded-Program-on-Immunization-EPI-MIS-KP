<center>
<label>Batch Wise Stock Summary </label>
</center>
<center>
<table class="table table-bordered table-condensed" >
							<tr>
								<th rowspan="2" ><label>Sr No.</label></th>
								<th rowspan="2" ><label>Product</label></th>
								<th rowspan="2" ><label>Batch No.</label></th>
								<th rowspan="2" ><label>Expiry Date</label></th>
								<th colspan="3" style="text-align:center;"><label>Quantity</label></th>
								<th rowspan="2" ><label>Status</label></th>
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
										<td style="text-align:center;"><?php echo $onerow["batch"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["expiry_date"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["quantity"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["doses"]; ?></td>
										<td style="text-align:center;"><?php echo ($onerow["doses"]*$onerow["quantity"]); ?></td>
										<td style="text-align:center;"><?php echo $onerow["priority"]; ?></td>
										
								</tr><?php
								}
							}?>
								
						
</table>
</center>

<label style="padding:15px">Prepared By : </label><?php echo $this->session->username;?>
<label style="padding:15px">Print Date : </label><?php echo date('Y-m-d');?>