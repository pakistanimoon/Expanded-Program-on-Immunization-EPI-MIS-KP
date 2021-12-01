
	<table id="tblreport" class="table table-bordered table-hover">
		<tr style="background: #008d4c;">
			<th style="text-align:center;"><label>Sr No.</label></th>
			<th style="text-align:center;"><label>Product</label></th>
			<th style="text-align:center;"><label>Batch No</label></th>
			<th style="text-align:center;"><label>Manufacturer</label></th>
			<th style="text-align:center;"><label>Vials/Pcs</label></th>
			<th style="text-align:center;"><label>Doses per Vial</label></th>
			<th style="text-align:center;"><label>Total Doses</label></th>
			<th style="text-align:center;"><label>Actions</label></th>
		</tr>
		<?php
		foreach($output as $key=>$value){?>
			<tr>
				<td style="text-align:center;"><?php echo $key+1; ?>
				<input id='master_id' type="hidden" value="<?php echo $value['master_id']; ?>" name="master_id" />
				<input id='batch_id' type="hidden" value="<?php echo $value['batch_id']; ?>" name="batch_id" />
				<input id='detail_id' type="hidden" value="<?php echo $value['detail_id']; ?>" name="detail_id" />
				</td>
				<td><?php echo $value['itemname'];?></td>
				<td><?php echo $value['number']; ?></td>
				<td><?php echo $value['manufacturer']; ?></td>
				<td><?php echo $value['quantity']; ?></td>
				<td><?php echo $value['doses']; ?></td>
				<td><?php echo ($value['quantity']* $value['doses']); ?></td>
				<td>
				 <span class="tbl-td-icon delete" data-dismiss="modal" data-attr="<?php echo $value['transaction_number']?>"><i class="fa fa-trash-o text-danger"></i></span>
				</td>
			</tr><?php
		}?>
	</table>	
	
<script type="text/javascript">
//voucher Delete Product
$('.delete').click("#tblreport .delete",function(){
	 if (confirm("Do you want to delete this Product?")) {
		var row = $(this).closest("tr");
		var voucher_number = $(this).attr('data-attr');
		var master_id = $('#master_id').val();
		var batch_id = $('#batch_id').val();
		var detail_id = $('#detail_id').val();
		  $.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>inventory/Federal/delete_product',
				dataType: "json",
				//data:'voucher_number='+voucher_number,
				data:'voucher_number='+voucher_number+'&batch_id='+batch_id+'&detail_id='+detail_id+'&master_id='+master_id,
				success: function(response){
				//console.log(response);
				row.remove();
				window.location.reload(); 
			}
		}); 
	}
});	
</script>