<?php if(!isset($_REQUEST['export_excel'])){?>
<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Batch Management </div>
				<div class="panel-body">
					<?php echo form_open(base_url().'stockBatchSearch',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed mytable3">
							<thead>
								<tr>
									<th colspan="4" style="padding-top: 10px; padding-bottom: 10px;">Search Filters (In current stock)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="padding-left:10px;">
										<label>By Product</label>
										<select id="product" name="product" class="form-control">
											<!--<option value=""> All </option>-->
											<?php if(isset($product)){ ?>
												<?php echo get_products_by_activity($activity,NULL,$product); ?>
											<?php }else{ ?>
												<?php echo get_products_by_activity(); ?>
											<?php } ?>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label>Search by </label>
										<select name="search_type" class="form-control">
											<option value="">Select</option>
											<option <?php echo (isset($search_type) && $search_type == 'batchnumber')?'selected="selected"':''; ?> value="batchnumber">Batch No.</option>
											<option <?php echo (isset($search_type) && $search_type == 'exponbefore')?'selected="selected"':''; ?> value="exponbefore">Expired on or before.</option>
											<option <?php echo (isset($search_type) && $search_type == 'exponafter')?'selected="selected"':''; ?> value="exponafter">Expired on or after.</option>
										</select>
									</td>
									<td style="padding-left:10px;">
										<label>Value</label>
										<input name="search_key" class="form-control" value="<?php echo (isset($search_key))?$search_key:''; ?>" type="text" />
									</td>
								</tr>
								<tr>
									<td style="padding-left:10px;padding-top: 10px;padding-bottom: 5px;" colspan="3">
										<style>
											.radio-v-inline{display: inline-block;float: left;}
											.labelinline{display: inline-block;float: left;padding: 0px 5px !important;margin-right: 10px;}
										</style>
										<input name="priority" class="radio-v-inline" value="0" type="radio" <?php echo (isset($priority))?(($priority === "0")?'checked="checked"':''):'checked="checked"'; ?>>
										<label class="labelinline">All Priorities</label>
										<input name="priority" class="radio-v-inline" value="1" type="radio" <?php echo (isset($priority) && $priority === "1")?'checked="checked"':''; ?>>
										<label class="labelinline">Priority 1</label>
										<input name="priority" class="radio-v-inline" value="2" type="radio" <?php echo (isset($priority) && $priority === "2")?'checked="checked"':''; ?>>
										<label class="labelinline">Priority 2</label>
										<input name="priority" class="radio-v-inline" value="3" type="radio" <?php echo (isset($priority) && $priority === "3")?'checked="checked"':''; ?>>
										<label class="labelinline">Priority 3</label>
										<input name="priority" class="radio-v-inline" value="4" type="radio" <?php echo (isset($priority) && $priority === "4")?'checked="checked"':''; ?>>
										<label class="labelinline">Finished</label>
										<input name="priority" class="radio-v-inline" value="5" type="radio" <?php echo (isset($priority) && $priority === "5")?'checked="checked"':''; ?>>
										<label class="labelinline">Expired stock (Date)</label>
										<input name="priority" class="radio-v-inline" value="6" type="radio" <?php echo (isset($priority) && $priority === "6")?'checked="checked"':''; ?>>
										<label class="labelinline">Expired stock (VVM)</label>
									</td>
								</tr>
								 <tr>
								<!--<td style="padding-left:10px;">
										<label>Vaccine:</label><br>
										<button id="btn_vaccine_summary" type="button" class="btn btn-success btn-md" role="button"> Product wise summary </button>										
										<button id="btn_batchwise_summary" type="button" class="btn btn-success btn-md" role="button"> batch wise summary </button>
										<button  id="btn_vaccine_priority" type="button" class="btn btn-success btn-md" role="button"> Priority Distribution</button>
									</td>
									<td style="padding-left:10px;">
										<label>Non Vaccine:</label><br>
										<button id="btn_nonVaccine_summary"  type="button" class="btn btn-success btn-md" role="button"> Product wise summary</button>
										<button id="btn_batchwisenon_summary" type="button" class="btn btn-success btn-md" role="button"> batch wise summary </button>
										<button id="btn_nonvaccine_priority" type="button" class="btn btn-success btn-md" role="button"> Priority Distribution</button>
									</td>-->
									<td style="padding-left:10px;">
									
										<!--<button   id="btn_stock_manufacturer" type="button" class="btn btn-success btn-md" role="button"> Manufacturers</button> -->
										<button type="submit" class="btn btn-success btn-md pull-right" role="button"><i class="fa fa-search "></i> Search</button>
									</td>
								</tr>
							</tbody>
						</table>
					<?php echo form_close(); ?>
<?php //echo $exportIcons;
	} ?>
					<table class="table table-bordered table-condensed mytable3" id="table" border="1" >
						<thead>
							<?php if(!isset($_REQUEST['export_excel'])){?>
							<tr>
								<th colspan="11" style="padding-top: 10px; padding-bottom: 10px;">Batch List (Based on filters)</th>
							</tr>
							<?php }?>
							<tr>
								<th style="text-align:center;"><label>Sr No.</label></th>
								<th style="text-align:center;"><label>Product</label></th>
								<th style="text-align:center;"><label>Batch No.</label></th>
								<th style="text-align:center;"><label>Manufacturer</label></th>
								<th style="text-align:center;"><label>VVM Stage</label></th>
								<th style="text-align:center;"><label>Expiry Date</label></th>
								<th style="text-align:center;"><label>Quantity</label></th>
								<th style="text-align:center;"><label>Doses</label></th>
								<th style="text-align:center;"><label>Status</label></th>
								<th style="text-align:center;"><label>Placement</label></th>
								<?php if(!isset($_REQUEST['export_excel'])){?><th style="text-align:center;"><label>Action</label></th><?php }?>
							</tr>
							</thead>
						<tbody>
							<?php
							
							$totquantity = $totdoses = 0;
							if(isset($searchResult) AND count($searchResult)>0){
								foreach($searchResult as $key=>$onerow){?>
									<tr>
										<td style="text-align:center;"><?php echo ($key+1); ?></td>
										<td><?php echo $onerow["itemname"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["batch"]; ?></td>
										<td><?php echo $onerow["manufacturer"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["vvmstage"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["expiry_date"]; ?></td>
										<td style="text-align:center;"><?php $totquantity += $onerow["quantity"]; echo $onerow["quantity"]; ?></td>
										<td style="text-align:center;"><?php $totdoses += $onerow["doses"]; echo $onerow["doses"]; ?></td>
										<td style="text-align:center;"><?php echo $onerow["priority"]; ?></td>
										<td style="text-align:center;"><?php echo (isset($onerow["ccm_id"])?get_ccm_name(false,$onerow["ccm_id"]):get_non_ccm_name(false,$onerow["non_ccm_id"])); ?></td>
										<td style="text-align:center;"><?php //echo $onerow["batch"]; ?></td>
									</tr><?php
								}
							}else {?>
								<tr><td colspan="11" style="text-align:center;">No data available</td></tr><?php
							}?>
							
						</tbody>
						<tfoot>
                             <tr><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th class="right" rowspan="1" colspan="1"><label>Page Total:</label></th><th class="right" rowspan="1" colspan="1"><label><?php echo $totquantity;?></label></th><th class="right" rowspan="1" colspan="1"><label><?php echo $totdoses;?></label></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th></tr>
                        </tfoot>
					</table>
					<div class="right" style="float:right;">
                                       <button style="margin-right:25px;" id="batch_detail" type="button" class="btn btn-success">Print</button>
                    </div>
<?php if(!isset($_REQUEST['export_excel'])){?>					
					<table class="table table-bordered table-condensed mytable3">
						<thead>
							<tr>
								<th style="padding-top: 10px; padding-bottom: 10px;width:10%">Batch status</th>
								<th style="padding-top: 10px; padding-bottom: 10px;">Description</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="padding-left:10px;"><label>Priority 1</label></th>
								<td style="padding-left:10px;">If VVM stage is 2 or expiry is less than 3 months.</td>
							</tr>
							<tr>
								<th style="padding-left:10px;"><label>Priority 2</label></th>
								<td style="padding-left:10px;">If VVM stage is 1 and expiry is more than 3 months and less than 12 months.</td>
							</tr>
							<tr>
								<th style="padding-left:10px;"><label>Priority 3</label></th>
								<td style="padding-left:10px;">If VVM stage is 1 and expiry is more than 12 months.</td>
							</tr>
							<tr>
								<td colspan="2" style="color:red;padding-left:10px;">Note: Non vaccine priority list quantities and placed quantities may be different due to incomplete placements of the dry store products in vLMIS.</td>
							</tr>
						</tbody>
					</table>
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
	$(document).ready(function(){		
		var options = {
			format : "yyyy-mm-dd",
			color: "green",
			autoclose: true
		};
		$("select[name^=search_type]").change(function(){
			var selectedval = $(this).find("option:selected").val();
			$("input[name^=search_key]").val("");
			if(selectedval==='exponbefore' || selectedval === 'exponafter'){
				//$("input[name^=search_key]").addClass("dpinvn");
				$("input[name^=search_key]").datepicker(options);
			}else{
				$('input[name^=search_key]').data('datepicker').remove();
				//$("input[name^=search_key]").datepicker("destroy");
				//$("input[name^=search_key]").removeClass("dpinvn");
			}			
		});
	});
	$(document).on('click','#batch_detail',function(){
			var product=$('#product').val();
			var priority=$('input[name=priority]:checked').val();
			var search_key=$('#search_key').val();
			var search_type=$('#search_type').val();
			var url="<?php echo base_url();?>batchDetailReport?product="+product+"&priority="+priority+"&search_key="+search_key+"&search_type="+search_type+"";
			window.open(url,"_blank");
			
				
	});	
		$(document).on('click','#btn_vaccine_summary',function(){
			
			var url="<?php echo base_url();?>batchVaccineSummary";
			window.open(url,"_blank");
	});			
		$(document).on('click','#btn_batchwise_summary',function(){	
				var url="<?php echo base_url();?>batchwisesummary";			
				window.open(url,"_blank");   
	});	

		$(document).on('click','#btn_batchwisenon_summary',function(){	
				var url="<?php echo base_url();?>batch_nonwisesummary";			
				window.open(url,"_blank");    
	});	

				
	$(document).on('click','#btn_nonVaccine_summary',function(){
			
			var url="<?php echo base_url();?>batchNonVaccineSummary";
			window.open(url,"_blank");
	});
	$(document).on('click','#btn_vaccine_priority',function(){
			
			var url="<?php echo base_url();?>batchVaccinePriority";
			window.open(url,"_blank");
	});
	$(document).on('click','#btn_nonvaccine_priority',function(){
			
			var url="<?php echo base_url();?>batchNonVaccinePriority";
			window.open(url,"_blank");
	});
	$(document).on('click','#btn_stock_manufacturer',function(){
			
			var url="<?php echo base_url();?>batchManufacturer";
			window.open(url,"_blank");
	});
	
	
</script>
<?php }?>