<center><label>Stock Issue/Dispatch Voucher</label></center>

<center><label>Dispatch Voucher : </label><label style="positon:center"><?php echo "#".$draftdata['master']->transaction_number;?></label></center>
<center>
<table class="table table-bordered table-condensed"  cellpadding="0" border="0" id="table">
						 <tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th rowspan="2" style="text-align:center;"><label>Manufacturer</label></th>
								<th rowspan="2" style="text-align:center;"><label>Batch No.</label></th>
								<th colspan="3" style="text-align:center;"><label>Quantity</label></th>
								<th rowspan="2" style="text-align:center;"><label>Expiry Date</label></th>
								<th rowspan="2" style="text-align:center;"><label>Picked from </label></th>
								<th rowspan="2" style="text-align:center;"><label>VM Stage</label></th>
						</tr>
						<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th style="text-align:center;"><label>Doses per Vial</label></th>
								<th style="text-align:center;"><label>Total Doses</label></th>
						</tr>
<?php 

$outputdata = '';
$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
$checksum = array();
if($batchexist){
	foreach($draftdata["batch"] as $key=>$onebatch){
		
		?>
						
						<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php  echo  get_product_name(false,$onebatch["item_pack_size_id"]);
										if(in_array($onebatch["item_pack_size_id"],$uniqueProd))
											{
											$sum[$onebatch["item_pack_size_id"]] = (isset($sum[$onebatch["item_pack_size_id"]])?$sum[$onebatch["item_pack_size_id"]]:0)+$onebatch["quantity"];
											$total[$onebatch["item_pack_size_id"]] = (isset($total[$onebatch["item_pack_size_id"]])?$total[$onebatch["item_pack_size_id"]]:0)+($onebatch["quantity"]*$onebatch["number_of_doses"]);
											}  ?></td>
										<td><?php   get_manufacturer_name(false,$onebatch["stakeholder_id"]); ?></td>
										<td><?php echo $onebatch["number"]; ?></td>
										<td><?php echo $onebatch["quantity"]; ?></td>
										<td><?php echo $onebatch["number_of_doses"]; ?></td>
										<td><?php echo ($onebatch["quantity"]* $onebatch["number_of_doses"]); ?></td>
									    <td><?php echo $onebatch["expiry_date"]; ?></td>
										<td><?php echo (isset($onebatch["ccm_id"])?get_ccm_name(false,$onebatch["ccm_id"]):get_non_ccm_name(false,$onebatch["non_ccm_id"])); ?></td>
										<td><?php echo $onebatch["vvm_type_id"]; ?></td>
					</tr>	
	
<?php }}?>
</table>
</center>
<center><label>Summary</label></center>	
<center>
<table class="table table-bordered table-condensed"  cellpadding="0" border="0" id="table">
						 <tr>
								<th rowspan="2" style="text-align:center;"><label>Sr No.</label></th>
								<th rowspan="2" style="text-align:center;"><label>Product</label></th>
								<th colspan="2" style="text-align:center;"><label>Net. Rec Quantity</label></th>
							</tr>
							<tr>
								<th style="text-align:center;"><label>Vials/Pcs</label></th>
								<th style="text-align:center;"><label>Total Doses</label></th>
							</tr>
							<?php $i=1;$j=0;
							foreach($uniqueProd as $key=>$prod)
							{?>
                           	<tr>
										<td><?php echo $i++; ?></td>
										<td><?php  get_product_name(false,$prod); ?></td>
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
<br>
<table>
<tr>
<td>
<label>IN-CHARGE STORE
</label>
</td></tr>
<Tr>
<td>
<label>
...............................................
</label>
</td>
</tr>
</table>
<br></br>
<label>Prepared By : </label><?php echo $this->session->username;?>
<label>Print Date : </label><?php echo date('Y-m-d');?>

									
