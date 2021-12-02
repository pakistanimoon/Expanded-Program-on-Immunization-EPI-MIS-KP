<?php //echo "<pre>";print_r($activity);exit;  ?>

<?php if(!isset($_REQUEST['export_excel'])){?>
<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Receive - Search </div>
				<div class="panel-body">
					<?php echo form_open(base_url().'stockReceiveSearch',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed mytable3">
							<thead>
								<tr>
									<th colspan="4" style="padding-top: 10px; padding-bottom: 10px;">Filters</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding-left:10px;">
										<label> Date From </label>
										<input id="date_from" required="required" name="date_from" class="form-control dpinvn" value="<?php echo (isset($date_from))?$date_from:date('Y-m-d',strtotime('first day of this month',time())); ?>" data-date-end-date="0d" />
										<!--<label>Store</label>
										<select id="from_warehouse_type_id" name="from_warehouse_type_id" class="form-control">
											<?php /* if(isset($from_warehouse_type_id)){ ?>
												<?php get_warehouse_type_option(FALSE,NULL,$from_warehouse_type_id,TRUE); ?>
											<?php }else{ ?>
												<?php get_warehouse_type_option(FALSE,NULL,NULL,TRUE); ?>
											<?php } */ ?>
										</select>-->
									</td>
									<td>
										<label> Date To </label>
										<input id="date_to" required="required" name="date_to" class="form-control dpinvn" value="<?php echo (isset($date_to))?$date_to:date('Y-m-d'); ?>" data-date-end-date="0d" />
										<!--<label>Purpose</label>
										<select id="activity" name="activity" class="form-control">
											<option value="">--Select--</option>
											<?php /* if(isset($activity)){ ?>
												<?php get_purposes(FALSE,$activity); ?>
											<?php }else{ ?>
												<?php get_purposes(FALSE,NULL); ?>
											<?php } */ ?>
										</select>-->
									</td>
									<td style="padding-left:10px;">
										<label>Product</label>
										<select id="product" name="product" class="form-control">
											<option value=""> All </option>
											<?php if(isset($product)){ ?>
												<?php echo get_products_by_activity($activity,NULL,$product); ?>
											<?php }else{ ?>
												<?php echo get_products_by_activity(); ?>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-left:10px;">
										<label>Search by </label>
										<select name="search_type" class="form-control">
											<option value="">Select</option>
											<option <?php echo (isset($search_type) && $search_type == 'receiptnumber')?'selected="selected"':''; ?> value="receiptnumber">Receive No.</option>
											<!--<option <?php //echo (isset($search_type) && $search_type == 'receivereference')?'selected="selected"':''; ?> value="receivereference">Receive Ref.</option>-->
											<option <?php echo (isset($search_type) && $search_type == 'batchnumber')?'selected="selected"':''; ?> value="batchnumber">Batch No.</option>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label>Value</label>
										<input name="search_key" class="form-control" value="<?php echo (isset($search_key))?$search_key:''; ?>" type="text" />
									</td>
									<td style="padding-left:10px;">
										<label>&nbsp;</label><br>
										<button type="submit" class="btn btnSubmit pull-right" role="button"><i class="fa fa-search "></i> Search </button>
										<!--<button type="reset" class="btn btnReset" role="button"><i class="fa fa-repeat"></i> Reset </button>-->
									</td>
								</tr>
								<!--<tr>
									<td style="padding-left:10px;">
										
									</td>
									<td style="padding-left:10px;">
										
									</td>
									<td style="padding-left:10px;">
										
									</td>
								</tr>-->
							</tbody>
						</table>
					<?php echo form_close(); ?>
   <?php //echo $exportIcons;
   }?>
					<table class="table table-bordered table-condensed mytable3" border ="1" id="table">
						<thead>
						<?php if(!isset($_REQUEST['export_excel'])){
							?>	
						<tr>
								<th colspan="15" style="padding-top: 10px; padding-bottom: 10px;"><label>Stock Receive Search</label></th>
							</tr>
						<?php }?>
							<tr>
								<th rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Sr No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Date</label></th>
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Receive No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Received From</label></th>
								<!--<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Ref No.</label></th>-->
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Product</label></th>
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Batch No.</label></th>
								<th  rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Manufacturer</label></th>
								<th  colspan="3" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Quantity</label></th>
								<th rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Unit</label></th>
								<th rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Expiry Date</label></th>
								<th rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Created On</label></th>
						<?php /* if(!isset($_REQUEST['export_excel'])){?><th rowspan="2" style="text-align:center;"><label style="padding:0px 15px 15px 5px">Action</label></th><?php } */?>
							</tr>
							<tr>
								<th style="text-align:center;"><label style="padding:0px 15px 15px 5px">Vials/Pcs</label></th>
								<th style="text-align:center;"><label style="padding:0px 15px 15px 5px">Doses per Vial</label></th>
								<th style="text-align:center;"><label style="padding:0px 15px 15px 5px">Total Doses</label></th>
							</tr>	
					  </thead>
					 <tbody>
							<?php 
							if(empty($searchResult))
							{ ?>
								<tr>
									<td colspan="14" style="text-align:center;">
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
										<td><?php get_store_name(false,$value['from_warehouse_type_id'],$value['from_warehouse_code']); ?></td>
										<!--<td><?php //echo $value['transaction_reference']; ?></td>-->
										<td><?php echo $value['itemname']; ?></td>
										<td><?php echo $value['number']; ?></td>
										<td><?php echo $value['manufacturer']; ?></td>
										<td><?php echo $value['quantity']; ?></td>
										<td><?php echo $value['doses']; ?></td>
										<td><?php echo ($value['doses']*$value['quantity']); ?></td>
										<td><?php echo $value['unit']; ?></td>
										<td><?php echo $value['expiry_date']; ?></td>
										<td><?php echo $value['created_date']; ?></td>
										<?php /* if(!isset($_REQUEST['export_excel'])){?><td></td><?php } */ ?>
									</tr>
								<?php 
								}
							} ?>
						</tbody>	
					</table>
					<?php if(!isset($_REQUEST['export_excel'])){?>
					<div class="left" style="float:left">
                                        <b>Summary: </b>
                                        <input type="radio"  style="margin-left:10px" name="summary" id="prod" value="Product" checked="checked"> Product Wise<input type="radio" name="summary" id="loc" value="Location"> Location wise<button style="margin-left:10px" id="stock_rec_summary" type="button" class="btn btnPrint">Print</button>
                    </div>
					<div class="right" style="float:right;">
                                        <b>Detail: </b>
                                        <input style="margin-left:10px" type="radio" name="groupBy" id="none" value="none" checked="checked"> None<input style="margin-left:10px" type="radio" name="groupBy" id="loc" value="Location"> Location wise<input type="radio" name="groupBy" id="prod" value="Product"> Product wise<button style="margin-left:10px" id="stock_rec_detail" type="button" class="btn btnPrint">Print</button>
                    </div>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">	
	
	$(document).ready(function()
	{
	var from_warehouse_type_id=$('#from_warehouse_type_id').val();	
	var activity=$('#activity').val();
	var search_type=$('#search_type').val();
	var search_key=$('#search_key').val();
	var product=$('#product').val();
	var date_to=$('#date_to').val();
	var date_from=$('#date_from').val();		
	//add data to tables using datatables:stockReceiveSearch
		 $('#table').DataTable({
			 "sDom": 'lf<"centered"B>rtip',
			  buttons: [
					'copy','excel'
						],
			 columnDefs: [ {
            targets: [ 2 ],
            "mRender": function ( data, type, full )
					{
						
						return '<a target="_blank" href="<?php echo base_url();?>stockReceiveSearchRecNo/'+full[2]+'?date_from='+date_from+'&date_to='+date_to+'&from_warehouse_type_id='+from_warehouse_type_id+'&activity='+activity+'&search_type='+search_type+'&search_key='+search_key+'&product='+product+'">'+full[2]+'</a>';
					}
        }  ]
		
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
	$(document).on('change','#activity',function(){
		var activityId = $(this).val();
		$("select[name=product]").html('');
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {activity: activityId,createoptions:true},
			url: "<?php echo base_url("productsByActivities"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name=product]").html(result.optionshtml);
			}
		});
	});
	$(document).on('click','#stock_rec_summary',function(){
	var summaryType=$('input[name=summary]:checked').val();
	var from_warehouse_type_id=$('#from_warehouse_type_id').val();	
	var activity=$('#activity').val();
	var search_type=$('#search_type').val();
	var search_key=$('#search_key').val();
	var product=$('#product').val();
	var date_from=$('#date_from').val();
	var date_to=$('#date_to').val();
	var url="<?php echo base_url();?>StockReceiveSearchSummaryProd?summaryType="+summaryType+"&date_from="+date_from+"&date_to="+date_to+"&from_warehouse_type_id="+from_warehouse_type_id+"&activity="+activity+"&search_type="+search_type+"&search_key="+search_key+"&product="+product+"";
	window.open(url,"_blank");
	});	
	//Stock Receive Detail
    $(document).on('click','#stock_rec_detail',function(){
	var groupBy=$('input[name=groupBy]:checked').val();
	var from_warehouse_type_id=$('#from_warehouse_type_id').val();	
	var activity=$('#activity').val();
	var search_type=$('#search_type').val();
	var search_key=$('#search_key').val();
	var product=$('#product').val();
	var date_from=$('#date_from').val();
	var date_to=$('#date_to').val();
	var url="<?php echo base_url();?>StockReceiveSearchDetailProd?groupBy="+groupBy+"&date_from="+date_from+"&date_to="+date_to+"&from_warehouse_type_id="+from_warehouse_type_id+"&activity="+activity+"&search_type="+search_type+"&search_key="+search_key+"&product="+product+"";
	window.open(url,"_blank");
	});	
	$(document).on('click','.actiondel',function(){
	var res=confirm("Are you Sure to Delete ? ");
	});
	
</script>
					<?php }?>