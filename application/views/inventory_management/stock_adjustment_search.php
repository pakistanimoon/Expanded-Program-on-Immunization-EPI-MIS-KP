
<?php 
	$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature"),(validation_errors()?set_value('type'):NULL)):false;
if(!isset($_REQUEST['export_excel'])){
	?>
<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Search Adjustments </div>
				<div class="panel-body">
					<?php echo form_open(base_url().'adjustmentSearch',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed mytable3">
							<thead>
								<tr>
									<th colspan="4" style="padding-top: 10px; padding-bottom: 10px;">Filters</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding-left:10px;">
										<label>Adjustment No.</label>
										<input name="adjustment_number" id="adjustment_number" class="form-control" type="text" />
									</td>
									<td style="padding-left:10px;">
										<label>Adjustment Type</label>
										<select name="adjustment_type" id="adjustment_type" class="form-control">
											<option value=""> All </option>
											<?php echo $adjsttypeshtml; ?>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label>Product</label>
										<select id="product" name="product" class="form-control">
											<option value=""> All </option>
											<?php echo get_products_by_activity(); ?>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label> Batch</label>
										<select id="batch" name="batch" class="form-control">
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-left:10px;">
										<label> Date From </label>
										<input id="date_from" name="date_from" class="form-control dpinvn" value="<?php echo (isset($date_from))?$date_from:date('Y-m-d',strtotime('first day of previous month',time())); ?>" data-date-end-date="0d" />
									</td>
									<td style="padding-left:10px;">
										<label> Date To </label>
										<input id="date_to" name="date_to" class="form-control dpinvn" value="<?php echo (isset($date_to))?$date_to:date('Y-m-d'); ?>" data-date-end-date="0d" />
									</td>
									<td style="padding-left:10px;">
										<label> Expiry Date </label>
										<input name="expiry" class="form-control dpinvn" value="" type="text" onkeydown="return false"/>
									</td>
									<td style="padding-left:10px;">
										<label>&nbsp;</label><br>
										<button style="background:#008d4c;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-search "></i> Search </button>
										<button type="reset" class="btn btn-info btn-md" role="button"><i class="fa fa-repeat"></i> Reset </button>
									</td>
								</tr>
							</tbody>
						</table>
						
					<?php echo form_close(); ?>
					<?php //echo $exportIcons;
					}?>
					<table class="table table-bordered table-condensed mytable3" border="1" id="table">
						<thead>
							<?php if(!isset($_REQUEST['export_excel'])) {?><tr>
								<th colspan="11" style="padding-top: 10px; padding-bottom: 10px;"> <label>Search Adjustments</label></th>
							</tr>
							<?php }?>
							<tr>
								<th style="text-align:center;"><label>Sr No.</label></th>
								<th style="text-align:center;"><label>Date</label></th>
								<th style="text-align:center;"><label>Adjustment No.</label></th>
								<th style="text-align:center;"><label>Ref No.</label></th>
								<th style="text-align:center;"><label>Product</label></th>
								<th style="text-align:center;"><label>Batch No.</label></th>
								<th style="text-align:center;"><label>Quantity</label></th>
								<th style="text-align:center;"><label>Adjustment Type</label></th>
								<th style="text-align:center;"><label>Comments</label></th>
								<th style="text-align:center;"><label>Expiry</label></th>
								<th style="text-align:center;"><label>Action</label></th>
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
										<td><?php echo $value['transaction_type_id']; ?></td>
										<td><?php echo $value['comments']; ?></td>
										<td><?php echo $value['expiry_date']; ?></td><?php
										if($value["nature"]==0 OR $value["status"]!='Finished'){?>
											<td><span data-id="<?php echo $value['batch_id']; ?>" data-masterid="<?php echo $value['batch_master_id']; ?>" class="fa fa-times cursor-hand actiondel" style="cursor:pointer"></span></td><?php 
										}?>
									</tr>
								<?php 
								}
							} ?>
						</tbody>
					</table>
					<div  style="float:right;">
                                        <button style="margin-right:30px" id="stock_adjustment_detail" type="button" class="btn btn-warning">Print</button>
						</div>
					<?php if(!isset($_REQUEST['export_excel'])) {?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->

<script type="text/javascript">	
	$(document).ready(function()
	{
		 $('#table').DataTable({
			
			"sDom": 'lf<"centered"B>rtip',
			  buttons: [
					'copy','excel'
						],
			"columnDefs": [ { "targets": [ 10 ], "orderable": false } ]
			
		});
	});
	$('.buttons-excel').css('Backgrouncolor','green');
	$(document).ready(function(){
		var options = {
			format : "yyyy-mm-dd",
			color: "green",
			autoclose: true
		};
		$('.dpinvn').datepicker(options);
	});
	$(document).on('change','#product',function(){
		var productId = $(this).val();
		$("select[name=batch]").html('');			
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {product: productId,createoptions:true,withzeroquantity:true},
			url: "<?php echo base_url("priorityDetailsByProduct"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name=batch]").html(result.mnfctrhtml);
			}
		});
	});
	 $(document).on('click','#stock_adjustment_detail',function(){
	
	var date_from=$('#date_from').val();
	var date_to=$('#date_to').val();	
	var expiry=$('#expiry').val();
	var adjustment_type=$('#adjustment_type').val();
	var adjustment_number=$('#adjustment_number').val();
	var batch=$('#batch').val();
	var product=$('#product').val();
	
	var url="<?php echo base_url();?>StockAdjustmentDetail?&date_from="+date_from+"&date_to="+date_to+"&expiry="+expiry+"&adjustment_number="+adjustment_number+"&adjustment_type="+adjustment_type+"&batch="+batch+"&product="+product+"";
	window.open(url,"_blank");
	});
	$(document).on('click','.actiondel',function(){
		if(confirm("Do You realy want to delete this?")){
			var batchId = $(this).data("id");
			var masterId = $(this).data("masterid");
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {batch: batchId,master: masterId},
				url: "<?php echo base_url("delinvnAdjustment"); ?>",
				success: function(result){
					var output = JSON.parse(result);
					if(output.result==="false"){
						alert(output.msg);
					}else if(output.result==="true"){
						alert(output.msg);
						location.reload();
					}
				}
			});
		}
	});	

	
</script>
					<?php }?>