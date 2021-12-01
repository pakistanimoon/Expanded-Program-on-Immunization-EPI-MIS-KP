<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
<form class="form-inline" method="POST" action="<?php echo base_url();?>Data_entry/stock_management_save">
	<section class="content">
		<h3 class="h3-rv">EPI Stock Issue and Receipt Voucher</h3>
			<div class="row bg-gray">
				<div class="col-md-3 form-group rv-group">
					<label for="ref">Ref No.  &nbsp;&nbsp; </label>
					<input class="form-control form-v" required id="ref" name="ref_no" type="text">
					<input type="hidden" id="form_id" name="form_id">
				</div>
				<div class="col-md-3 form-group rv-group">
					<label for="supply">Supply from(Federal)  &nbsp; </label>
					<select class="form-control form-v" required id="supply" name="supply_from">
						<?php get_warehouse_option(1); ?>
					</select>
				</div>
				<div class="col-md-3 form-group rv-group">
					<label for="issue">Issued to(Province)  &nbsp; </label>
					<select class="form-control form-v" required id="issue" name="issue_to">
						<?php get_warehouse_option(2); ?>
					</select>
				</div>
				<div class="col-md-3 form-group rv-group">
					<label for="issued">Issue Date &nbsp;</label>
					<input class="form-control dp" required readonly id="issued" name="issue_date">
				</div>
   
			</div>
			<div class="row" style=" margin:0px;">
			 <table class="datatable table-striped  th-th" style="border:1px solid #fdfafa;" border="1"> 
					<thead>
				<tr>
					<th rowspan="2">Products Doses<br> Per Vial</th>
					<th rowspan="2">Purpose</th>
					<th rowspan="2">Received Date</th>
					<th rowspan="2">Funding Source</th>
					<th rowspan="2">Manufactures</th>
					<th rowspan="2">Batch#</th>
					<th rowspan="2">Expiry Date</th>
					<th rowspan="2">Unit Cost (PKR)</th>
					<th colspan="2">Issued Quantity</th> 
					<th colspan="2">Received Quantity</th> 
					<th rowspan="2">Location</th>
					<!--<th rowspan="2">Add Adjusment</th>-->
					<th rowspan="2">Action</th>
				</tr>
				<tr>
					<th rowspan="2">Vials/no.</th>
					<th rowspan="2">VVM Stage</th>
					<th rowspan="2">Vials/No.</th>
					<th rowspan="2">VVM Stage</th>
				</tr>
			</thead>
	<tbody style="" border="none">
		<tr class="second-heading-tr">
			<td>A</td>
			<td>B</td>
			<td>C</td>
			<td>D</td>
			<td>E</td>
			<td>F</td>
			<td>G</td>
			<td>H</td>
			<td>I</td>
			<td>J</td>
			<td>K</td>
			<td>L</td>
			<td>M</td>
			<td></td>
		</tr>
<!-- loop over products on row to create rows -->
		<?php foreach($products as $key=>$val) { ?>
		<tr class="tr_entry" >
			<td>
				<label style="padding-top: 4px;"><?php echo $val['vacc_id']; ?></label>
				<input type="hidden" readonly name="product_id[<?php echo $key; ?>]" id="product_id" value="<?php echo $val['vacc_id']; ?>" style="border:none;">
			</td>
			<td>
			<select id="purpose_id" name="purpose_id[<?php echo $key; ?>]" style="width:60%;">
			<?php foreach($purpose as $key4=>$val4) { ?>
					<option value ="<?php echo $val4['id']; ?>"><?php echo $val4['type']; ?></option>
					<?php } ?>
			</select>
			</td>
			<td><input id="recive_date" required readonly name="recive_date[<?php echo $key; ?>]" class="dp form-control" style="width: 100%; border:none;padding: 0px;"></td>
			<td>
				<select id="funding_source_id" name="funding_source_id[<?php echo $key; ?>]" style="width:50%;">
				    <?php foreach($source as $key3=>$val3) { ?>
					<option value ="<?php echo $val3['id']; ?>"><?php echo $val3['name']; ?></option>
					<?php } ?>
				</select>
			</td>
			<td>
				<select id="manufacturer_id" name = "manufacturer_id[<?php echo $key; ?>]" style="width:50%;">
				    <?php foreach($manufacturer as $key2=>$val2) { ?>
					<option value ="<?php echo $val2['id']; ?>"><?php echo $val2['name']; ?></option>
					<?php } ?>
				</select>
			</td>
			<td><input class="input_entry" required id="batch_no" name="batch_no[<?php echo $key; ?>]" type="text"></td>
			<td><input id="expiry_date" required readonly name="expiry_date[<?php echo $key; ?>]" class="dp form-control" style="width: 100%; border:none;padding: 0px;"></td>
			<td><input id="unit_cost" required name="unit_cost[<?php echo $key; ?>]" class="input_entry" type="text"></td>
			<td><input id="issue_vials" required name="issue_vials[<?php echo $key; ?>]" class="input_entry" type="text"></td>
			<!--<td></td>-->
			<td>
				<select id = "vvm_stage_issue" name="vvm_stage_issue[<?php echo $key; ?>]">
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
				</select>
			</td>
			<td><input id="receive_vials"  name="receive_vials[<?php echo $key; ?>]" class="input_entry" type="text"></td>
  
			<td>
			<select id = "vvm_stage_receive" name="vvm_stage_receive[<?php echo $key; ?>]">
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
				</select>
			</td>
			<td>
				<select id="location_id" name="location_id[<?php echo $key; ?>]">
					<?php foreach($location as $key1=>$val1) { ?>
					<option value ="<?php echo $val1['pk_id']; ?>"><?php echo $val1['asset_type_name']; ?></option>
					<?php } ?>
				</select>
			</td>
			<td class="text-center"><button data-toggle="collapse" href="#collapseExample<?php echo $key; ?>"  type="button" class=" btn btn-primary add_button" aria-expanded="false"><i class="fa fa-plus-square" aria-hidden="true"></i> </button></td>
		</tr>
		<tr class="collapse" id="collapseExample<?php echo $key; ?>">
			<td colspan="15">
				<table style="width:100%;">
					<thead>
						<th>Product</th>
						<th>Adjustment Type</th>
						<th>Adjustment Quantity</th>
						<th>Quantity in doses</th>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;"><?php echo $val['vacc_id']; ?></td>
							<td style="text-align:center;">
								<select class="form-control" name="adjustmenttype[<?php echo $key; ?>]">
									<?php foreach($adjustment as $k=>$v) { ?>
									<option value="<?php echo $v['type']; ?>"><?php echo $v['type']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td style="text-align:center;"><input name="adjustmentQty[<?php echo $key; ?>]" class="form-control"></td>
							<td style="text-align:center;">0</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<?php } ?>
	</tbody>
			</table>
		</div>
        <div class="row row_by">
			<div class="col-md-4">
				<span class="bold-text">Received By : </span><input name="received_by" id="received_by" class="footer-by" type="text">
			</div>
			<div class="col-md-4">
				<span class="bold-text">Designation : </span><input name="designation" id="designation" class="footer-by" type="text">
			</div>
			<div class="col-md-4">
				<span class="bold-text">Store : </span> 
				<select class="form-control form-v" required id="received_by_store" name="received_by_store">
					<?php get_warehouse_option(2); ?>
				</select>
			</div>
	   </div>
	   <div class="row row_by">
			<div class="col-md-4" style="float:right;">
				<button class="green-btn box1"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Form </button>
				<button class="green-btn box1"><i class="fa fa-refresh" aria-hidden="true"></i> Reset Form </button>
				<button class="green-btn box1" style="padding:6px 16px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel </button>
			</div>
	   </div>
	</section>
</form>
<script type="text/javascript">
$(document).ready(function(){
	var id=0;
	$.ajax({
		type:"POST",
		data:"id="+id,
		url:'<?php echo base_url(); ?>Ajax_calls/getformId',
		success:function(result){
			$('#form_id').val(result);
		}
	});
});
$(function () {
	var dtToday = new Date();
	var options = {
		  format : "dd-mm-yyyy",
		  startDate : "01-01-2016",
		  endDate: dtToday

		};
		var optionExpiry = {
		  format : "dd-mm-yyyy",
		  startDate : "01-01-2016",
		  endDate: "31-12-2025"

		};
	   
		$('#recive_date,#issued').datepicker(options);
		$('#expiry_date, #date_by').datepicker(optionExpiry);
		var options = {
		  format : "dd-mm-yyyy",
			color: "green"
		};
		$('.dp').datepicker(options);
});
$(document).on('click','#open_modal',function(){
    var vacc = $(this).parents('tr').find('td:first-child input').val();
    $('#vaccine_id').val(vacc);
});
$(document).on('click','#add_adjustment',function(){
	var adjustment_type = $('#adjustment_type').val();
   var adjustment_quantity = $('#adj-2').val();
   var adj_prod = $('#adj-3').val();
   var vacc_id = $('#vaccine_id').val();
   var date = '<?php echo date('Y-m-d'); ?>';
   $.ajax({
	   type:"POST",
	   data: "adjustment_type="+adjustment_type+"&adjustment_quantity="+adjustment_quantity+"&vacc_id="+vacc_id+"&date="+date,
	   url: "<?php echo base_url(); ?>Ajax_calls/tempAdjustmentSave",
	   success:function(response){
		   if(response == 1)
			   alert("Adjustment Added"); 
		}
   });
   
});
</script>