 
<?php if(!isset($_REQUEST['export_excel'])){
/* $nonccloctypeshtml = isset($nonccloctypes)?get_options_html($nonccloctypes,true):false;
$ccloctypeshtml = isset($ccloctypes)?get_options_html($ccloctypes,true):false;
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true):false; */
?>
<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Transfer - Search </div>
				<div class="panel-body">
					<?php echo form_open(base_url().'stockTransferSearch',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed mytable3">
							<thead>
								<tr>
									<th colspan="4" style="padding-top: 10px; padding-bottom: 10px;">Filters</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding-left:10px;">
										<label>Product</label>
										<select id="product" name="product" class="form-control">
											<option value=""> All </option>
										<?php if(isset($product)){ ?>
												<?php echo get_products_by_activity(NULL,NULL,$product); ?>
											<?php }else{ ?>
												<?php echo get_products_by_activity(); ?>
											<?php } ?>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label> Date From </label>
										<input id="date_from" name="date_from" class="form-control dpinvn" value="<?php echo (isset($date_from))?$date_from:date('Y-m-d',strtotime('first day of this month',time()));?>" data-date-end-date="0d" />
									</td>
									<td style="padding-left:10px;">
										<label> Date To </label>
										<input id="date_to" name="date_to" class="form-control dpinvn" value="<?php echo (isset($date_to))?$date_to:date('Y-m-d'); ?>" data-date-end-date="0d" />
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
					<div class="right" style="float:right;">
                            <button style="margin-left:10px" id="stock_transfer_report" type="button" class="btn btn-warning">Print</button>
                    </div>
					<?php if(!isset($_REQUEST['export_excel'])){?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">	
	$(document).ready(function()
	{

	//add data to tables using datatables:stockTransSearch
		 $('#table').DataTable({
			"sDom": 'lf<"centered"B>rtip',
			  buttons: [
					'copy','excel'
						]
		});
	});
	$(document).ready(function(){
		var options = {
			format : "yyyy-mm-dd",
			color: "green",
			autoclose: true
		};
		$('.dpinvn').datepicker(options);
	});
	    $(document).on('click','#stock_transfer_report',function(){
	
	var product=$('#product').val();
	var date_from=$('#date_from').val();
	var date_to=$('#date_to').val();
	var url="<?php echo base_url();?>StockTransferReport?date_from="+date_from+"&date_to="+date_to+"&product="+product+"";
	window.open(url,"_blank");
	});
</script>
					<?php }?>