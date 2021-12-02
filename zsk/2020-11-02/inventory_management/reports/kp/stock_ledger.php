<!--start of page content or body-->
<?php //echo '<pre>';print_r($openingbalance);echo '<pre>';print_r($closingbalance);?>

<?php //print_r($openingbalance); exit; ?>

<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Stock Ledger at <?php if(isset($wh_code)){echo $store = get_store_name(TRUE,$wh_type,$wh_code); } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>
			<div class="panel-body">
				<form class="form-horizontal">
				<table class="table table-bordered   table-striped table-hover  mytable">
						<tr colspan="3">
							<td><label>Product</label></td> 
							<td><?php echo get_product_name(FALSE,$product); ?></td>
							<td><label>purpose</label></td> 
							<td><?php echo get_purpose_name(FALSE,$purpose); ?></td>
						</tr>
						<tr>
							<td rowspan="3"><label>Month From</label></td>
							<td><?php  if(isset($monthfrom)){ echo $monthfrom; } ?></td>
							<td  rowspan="3"><label>Month To</label></td>
							<td><?php  if(isset($monthto)){ echo $monthto; } ?></td>
						</tr>
					</table>   
					<table class="table table-bordered table-condensed table-striped table-hover mytable" border="1">
						<thead style="background-color:#008d4c !important;">
							<tr>
							<th rowspan="2">Sr. No</th>
							<th rowspan="2">Voucher Date</th>
							<th rowspan="2">Voucher Number</th>
							<th rowspan="2">Type</th>
							<th rowspan="2">Store</th>
							<th rowspan="2">Batch No.</th>
							
							<th rowspan="2">Expiry</th>
							<th colspan="3">Quantity</th>
							<th colspan="2">Batch Balance</th>
							
							<th colspan="2">Product Balance</th>
							
							<th rowspan="2">Created Date</th>
							<th rowspan="2">Created By</th>
							</tr>   
							<tr>
							<th rowspan="2">Vials Receive</th>
							<th rowspan="2">Vials Issue</th>
							<th rowspan="2">Vials Adjusted</th>
							<th rowspan="2">Doses</th>
							<th rowspan="2">Vials</th>
							<th rowspan="2">Doses</th>
							<th rowspan="2">Vials</th>
							</tr>
					
						</thead>
						<tbody>		
								<?php
								$serial_number = 1;
								$serial = 'A';
								$balancearray = array();
								$openingsum = 0;
								
								foreach($openingbalance as $key=>$row)
								{
									
									echo '<tr>';
										echo '<td>'.$serial_number++.'</td>';
										echo '<td><b>'.date("Y-m-d", strtotime($startdate)).'</b></td>';
										echo '<td></td>';
										echo '<td></td>';
										echo '<td><b>Opening Balance ('.$row['number'].')</b></td>';
										echo '<td><b></b></td>';
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';

										$balancearray[$row['number']] = $row['stock'];
										$openingsum += $row['stock'];
										
										echo '<td><b>'.$row['stock'].'</b></td>';
										echo '<td></td>';										
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
										
									echo '</tr>'; 
									$serial = 'B';
								}
								
								$totplusquan = $openingsum;
								$newbalance = 0;
								
								foreach($tabledata as $key=>$row)
								{	
									$transaction_date=$row['transaction_date'];
									$transaction_number=$row['transaction_number'];
									$transaction_type_name=$row['transaction_type_name'];
									$nature=$row['nature'];
									$Particulars=$row['case'];  $Opening = 'Opening Balance'; $Closing = 'Closing Balance';
									$number=$row['number'];
									$expiry_date=$row['expiry_date'];
									$QVials=$row['quantity'];
									$QVialsR='';
									$QVialsI='';
									$QVialsA='';
									$BDoses='';
									$PDoses='';
									$PVials='';
									$created_date=$row['created_date'];
									$created_by=$row['created_by'];
									
									echo '<tr>';
										echo '<td>'.$serial_number++.'</td>';
										echo '<td>'.$transaction_date.'</td>';
										echo '<td>'.$transaction_number.'</td>';
										echo '<td>'.$transaction_type_name.'</td>';
										echo '<td>'.$Particulars.'</td>';
										echo '<td>'.$number.'</td>';
										echo '<td>'.$expiry_date.'</td>';
										if($transaction_type_name == 'Issue')
										{
											echo '<td></td>';
											echo '<td>'.$QVials.'</td>';
											echo '<td></td>';
										}
										else if($transaction_type_name == 'Receive')
										{
											echo '<td>'.$QVials.'</td>';
											echo '<td></td>';
											echo '<td></td>';
										}
										else
										{
											echo '<td></td>';
											echo '<td></td>';
											echo '<td>'.$QVials.'</td>';
										}
										/* //Fo Total product vials/doses
										if($nature == '1')
										{
											$totplusquan = $totplusquan + $QVials;
										}
										else
										{
											//if($totplusquan > $QVials)
											$totplusquan = $totplusquan- $QVials  ;  
											if($totplusquan < $QVials)
												$totplusquan = $QVials - $totplusquan;
											
										}
										 */
										if (array_key_exists($number, $balancearray))
										{
											
											if($nature == '1')
											{
												$batchbalance = $balancearray[$number] + $QVials;
												$BVials = 0 + ($balancearray[$number] + $QVials);
											}
											else
											{
												$batchbalance = ($balancearray[$number] - $QVials);
												$BVials = ($balancearray[$number] - $QVials) - 0 ; 
											}
										}
										else
										{
											$batchbalance = $QVials;
											if($nature == '1')
											{
												$BVials = 0 + $QVials;//
												//$BVials = $batchbalance+ $QVials;
												
											}
											else
											{
												$BVials =$QVials -0 ;
												
											}
										}
										$balancearray[$number] = $batchbalance;
										echo '<td>'.($BVials*$doses[0]['number_of_doses']).'</td>';
										echo '<td>'.$BVials.'</td>';
										if($nature == '1')
										{
											$totplusquan = $totplusquan + $QVials;
										}
										else
										{
											$totplusquan =  $totplusquan -  $QVials;
											
										}
										
										//echo '<td>bdose</td>';
										//echo '<td>bvials</td>';
										echo '<td>'.(($totplusquan)*($doses[0]['number_of_doses'])).'</td>';
										echo '<td>'.$totplusquan.'</td>'; 
										echo '<td>'.$created_date.'</td>';
										echo '<td>'.$created_by.'</td>';
									echo '</tr>';
									$serial = 'B';
								}
								
								foreach($closingbalance as $key=>$row)
								{
								if($row['stock'] >0){									
									echo '<tr>';
										echo '<td>'.$serial_number++.'</td>';
										echo '<td><b>'.date("Y-m-d", strtotime($enddate)).'</b></td>';
										echo '<td></td>';   
										echo '<td></td>';
										echo '<td><b>Closing Balance ('.$row['number'].')</b></td>';
										echo '<td><b></b></td>';
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';	
										echo '<td></td>';
									   /* if($row['balance']=='0')
										{
											echo '<td>0</td>';
										}
										else
										{ */
											echo '<td></td>'; 
										//} 
										echo '<td><b>'.$row['stock'].'</b></td>';
										echo '<td></td>';										
										echo '<td></td>';
										echo '<td></td>';
										echo '<td></td>';
										
									echo '</tr>'; 
								}
							$serial = 'B';
								} 
								if ($serial=='A')
								{
									echo '<td colspan="16" style="text-align:center;">No data found.</td>';
								} 
								?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-sm-4">
							<table class="table table-bordered table-striped">
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div style="text-align: right;" class="col-md-4 col-md-offset-8">
						</div>
					</div>    
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->