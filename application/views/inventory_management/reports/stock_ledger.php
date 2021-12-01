<!--start of page content or body-->
<?php //echo '<pre>';print_r($openingbalance);echo '<pre>';print_r($closingbalance);?>

<?php //print_r($data); exit; ?>

<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Stock Ledger at <?php if(isset($wh_code)){echo $store = get_store_name(TRUE,$wh_type,$wh_code); } ?> for (<?php if(isset($monthfrom)){ echo $monthfrom; } ?>) to (<?php if(isset($monthto)){ echo $monthto; } ?>) - Vials</div>
			<div class="panel-body">
				<form class="form-horizontal">
				<table class="table table-bordered   table-striped table-hover  mytable" border="1">
						<tr colspan="3">
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Product</label></td> 
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_product_name(FALSE,$product); ?></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Purpose</label></td> 
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_purpose_name(FALSE,$purpose); ?></td>
						</tr>
						<tr>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Month From</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php  if(isset($monthfrom)){ echo $monthfrom; } ?></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Month To</label></td>
							<td style="text-align:center; border: 1px solid black;" class="text-center"><?php  if(isset($monthto)){ echo $monthto; } ?></td>
						</tr>
					</table>   
					<table class="table table-bordered table-condensed table-striped table-hover mytable" border="1">
						<thead style="background-color:#008d4c !important;">
							<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Sr. No</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Voucher Date</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Voucher Number</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Type</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Store</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Batch No.</th>
							
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Expiry</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">Quantity</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Batch Balance</th>
							
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Product Balance</th>
							
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Created Date</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Created By</th>
							</tr>   
							<tr>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Vials Receive</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Vials Issue</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Vials Adjusted</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Doses</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Vials</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Doses</th>
							<th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Vials</th>
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
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$serial_number++.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b>'.date("Y-m-d", strtotime($startdate)).'</b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b>Opening Balance ('.$row['number'].')</b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b></b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';

										$balancearray[$row['number']] = $row['stock'];
										$openingsum += $row['stock'];
										
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b>'.$row['stock'].'</b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';										
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										
									echo '</tr>'; 
									$serial = 'B';
								}
								
								$totplusquan = $openingsum;
								$totplusquan_cal = $openingsum;
								$newbalance = 0;
								
								foreach($tabledata as $key=>$row)
								{	
									//echo $key;exit;
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
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$serial_number++.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$transaction_date.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$transaction_number.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$transaction_type_name.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$Particulars.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$number.'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$expiry_date.'</td>';
										if($transaction_type_name == 'Issue')
										{
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$QVials.'</td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										}
										else if($transaction_type_name == 'Receive')
										{
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$QVials.'</td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										}
										else
										{
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$QVials.'</td>';
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
												$BVials =($balancearray[$number] - $QVials) -0 ;  
											}
										}
										else
										{
											$batchbalance = $QVials;
											if($nature == '1')
											{
												$BVials = 0 + $QVials;
											}
											else
											{
												$BVials =0-$QVials ;
												$batchbalance = -$QVials;
											}
										}
										//echo $QVials;;
										$balancearray[$number] = $batchbalance;
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.($BVials*$doses[0]['number_of_doses']).'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$BVials.'</td>';
										if($nature == '1')
										{
											$totplusquan = $totplusquan + $QVials;
										}
										else
										{
											$totplusquan =  $totplusquan -  $QVials;
											
										}
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.(($totplusquan)*($doses[0]['number_of_doses'])).'</td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$totplusquan.'</td>'; 
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center">'.$created_date.'</td>';
										echo '<td  style="text-align:center; border: 1px solid black;" class="text-center">'.$created_by.'</td>';
									echo '</tr>';
									$serial = 'B';
								}
								
								foreach($closingbalance as $key=>$row)
								{
								if($row['stock'] >0){									
									echo '<tr>';
										echo '<td  style="text-align:center; border: 1px solid black;" class="text-center">'.$serial_number++.'</td>';
										echo '<td  style="text-align:center; border: 1px solid black;" class="text-center"><b>'.date("Y-m-d", strtotime($enddate)).'</b></td>';
										echo '<td  style="text-align:center; border: 1px solid black;" class="text-center"></td>';   
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b>Closing Balance ('.$row['number'].')</b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b></b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';	
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
									   /* if($row['balance']=='0')
										{
											echo '<td>0</td>';
										}
										else
										{ */
											echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>'; 
										//} 
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"><b>'.$row['stock'].'</b></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';										
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										echo '<td style="text-align:center; border: 1px solid black;" class="text-center"></td>';
										
									echo '</tr>';   
								}
							$serial = 'B';
								} 
								if ($serial=='A')
								{
									echo '<td style="text-align:center; border: 1px solid black;" class="text-center" colspan="16" style="text-align:center;">No data found.</td>';
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