<?php    
	foreach($issuedvouchers as $key=>$singlerec){
	$recid = $singlerec["pk_id"];
	$vouchernum = $singlerec["transaction_number"]; ?>
		<tr>
			<td>
				<span><?php echo $singlerec["transaction_date"]; ?></span>
			</td>
			<td>
				<span><?php echo $vouchernum; ?></span>
			</td>
			<td>
				<span class="pull-left"><?php echo $singlerec["store"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["activity"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["transaction_counter"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["created_by"]; ?></span>
			</td>
			<td>
				<span><?php echo $singlerec["created_date"]; ?></span>
			</td>
			<td>
				<span><?php echo $stat = $singlerec["voucherstat"]; ?></span>
			</td>
			<td>
			<?php if($stat != 'In Process'){ ?>
				<a href="<?php echo base_url("voucher/".$vouchernum); ?>" target="_blank"><span class="fa fa-print cursor-hand pull-left" style="cursor:pointer"></span></a>
			<?php }?>	
				<?php if($stat != 'Received' && $stat != 'In Process'){ ?>
					<span data-id="<?php echo $singlerec["pk_id"]; ?>" class="fa fa-pencil cursor-hand actionedit pull-right" style="cursor:pointer"></span>
				<?php } ?>														
			</td>
	</tr>
	<?php } ?>
