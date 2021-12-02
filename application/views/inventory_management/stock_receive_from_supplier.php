<?php 
$nonccloctypeshtml = get_options_html($nonccloctypes,true);
$ccloctypeshtml = get_options_html($ccloctypes,true);
$batchexist = (isset($draftdata) and count($draftdata["batch"]))?true:false;
?>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Receive (Supplier)</div>
				<div class="panel-body">
					<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
					<?php echo form_open(base_url().'invnSuppReceive',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed tbl-im">
							<tbody>
								<tr>
									<td>
										<label>Receipt No.</label>
										<input readonly="readonly" id="trans_numb" class="form-control" type="text" value="<?php echo ($batchexist)?'TEMP':''; ?>">
									</td>
									<td>
										<label>Ref No</label>
										<input class="form-control" name="trans_ref" id="trans_ref" type="text" <?php echo ($batchexist)?'readonly="readonly" value="'.$draftdata["master"]->transaction_reference.'"':''; ?>>
									</td>
									<td>
										<label>Received From (Funding Source) <span style="color:red">*</span></label>
										<select id="from_warehouse" name="from_warehouse" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
											<?php get_funding_sources(FALSE,(($batchexist)?$draftdata["master"]->from_warehouse_code:NULL)); ?>
										</select>
									</td>
									<td style="position:relative;">
										<label>Received Time</label>
										<input class="form-control dpwt" name="trans_date_time" id="trans_date_time" type="text" <?php echo ($batchexist)?'disabled="disabled" value="'.$draftdata["master"]->transaction_date.'"':''; ?>>
									</td>
								</tr>
								<tr>
									<td>
										<label>Purpose <span style="color:red">*</span></label>
										<select id="activity" name="activity" required="required" class="form-control" <?php echo ($batchexist)?'disabled="disabled"':''; ?>>
											<?php get_purposes(FALSE,(($batchexist)?$draftdata["master"]->stakeholder_activity_id:NULL)); ?>
										</select>
									</td>
									<td>
										<label>Product <span style="color:red">*</span></label>
										<select id="product" name="product" required="required" class="form-control">
										</select>
									</td>
									<td>
										<label> Manufacturer <span style="color:red">*</span></label>
										<select id="manufacturer" name="manufacturer" required="required" class="form-control">
										</select>
									</td>
								</tr>
								<tr>
									<td>
										<label> Batch No. <span style="color:red">*</span></label>
										<input class="form-control" name="batch_numb" id="batch_numb" type="text">
									</td>
									<td>
										<label> Production Date</label>
										<input class="form-control invndp" name="production_date" id="production_date" type="text" data-date-end-date="0d">
									</td>
									<td>
										<label> Expiry Date <span style="color:red">*</span></label>
										<input class="form-control invndp" name="expiry_date" id="expiry_date" required="required" type="text">
									</td>
									<td>
										<label>  Unit Price (PKR) <span style="color:red">*</span></label>
										<input class="form-control" name="unit_price" required="required" id="unit_price" type="text">
									</td>
								</tr>
								<tr>
									<td>
										<label> Quantity <span style="color:red">*</span></label>
										<input class="form-control" name="quantity" id="quantity" required="required" type="text" style="width: 88%;"><span style="float: right;margin-top: -27px;">Vials</span>
									</td>
									<td>
										<label> VVM Type <span style="color:red">*</span></label>
										<select id="vvm_type" name="vvm_type" required="required" class="form-control">
											<?php echo $data["vvmshtml"]; ?>
										</select>
									</td>
									<td>
										<label> VVM Stage <span style="color:red">*</span></label>
										<select id="vvm_stage" name="vvm_stage" required="required" class="form-control">
											<option value="">-- Select --</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</td>
									<td>
										<label> Placement Location <span style="color:red">*</span></label>
										<select id="location" name="location" required="required" class="form-control">
											<option value="">-- Select --</option>
											<option value="">-- D1 --</option>
											<option value="">-- D2 --</option>
										</select>
										<input type="hidden" name="location_type" id="location_type" value="ccm_id" >
									</td>
								</tr>
							</tbody>
						</table>
						<div class="row">      
							<div style="text-align: left;margin-top:-15px;" class="col-md-1">
								<span id="unittext"></span>
								<input type="hidden" id="item_unit_id" name="item_unit_id" value="" >
							</div>      
							<div style="text-align: right;" class="col-md-5 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
								<button style="background:#008d4c;" type="button" id="submitbtn" class="btn btn-primary btn-md" role="button"><i class="fa fa-plus "></i> Add Stock Receive  </button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
				<div class="panel-body <?php echo ($batchexist)?'':'hide'; ?>" id="receive_panel">
					<div class="panel-heading">Receive List</div>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-condensed tbl-im">
								<thead>
									<tr>
										<th>Date</th>
										<th>Rcv. From</th>
										<th>Product</th>
										<th>Batch</th>
										<th>Received</th>
										<th>Unit</th>
										<th>Manufacturer</th>
										<th>Location</th>
										<th>Expiry Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="receive_list"><?php 
									$this->load->view("inventory_management/ajax/stock_receive_from_supplier_list.php");?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">
	var ccloctypeshtml = '<?php echo $ccloctypeshtml; ?>';
	var nonccloctypeshtml = '<?php echo $nonccloctypeshtml; ?>';
	function get_manufacturer_of_product(productId){
		$("select[name=manufacturer]").html('');
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {product: productId,createoptions:true},
			url: "<?php echo base_url("manufacturerByProduct"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name=manufacturer]").html(result.optionshtml);
			}
		});
	}
	function get_vvmstages_by_product(productId){
		$("select[name=vvm_stage]").html('');
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {product: productId,createoptions:true},
			url: "<?php echo base_url("vvmStageByProduct"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name=vvm_stage]").html(result.optionshtml);
			}
		});
	}
	$(document).ready(function(){
		$(document).on('click','.actiondel',function(){
			if(confirm("Do You realy want to delete this?")){
				var batchId = $(this).data("id");
				var masterId = $(this).data("masterid");
				$.ajax({
					type: "POST",
					datatype: "JSON",
					data: {batch: batchId,master: masterId},
					url: "<?php echo base_url("delinvnSupp"); ?>",
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
					$('#product').trigger("change");
				}
			});
		});
		$(document).on('change','#product',function(){
			var productId = $(this).val();
			itemcatid = $("#product").find("option:selected").data("categoryid");
			itemunitid = $("#product").find("option:selected").data("unitid");
			unittitle = $("#product").find("option:selected").data("unittitle");
			get_manufacturer_of_product(productId)
			get_vvmstages_by_product(productId);
			if(itemcatid=="1"){
				$("#location").html(ccloctypeshtml);
				$("#location_type").val("ccm_id");
			}else{
				$("#location").html(nonccloctypeshtml);
				$("#location_type").val("non_ccm_id");
			}
			$("#item_unit_id").val(itemunitid);
			$("#unittext").text(unittitle);
		});
		$('#activity').trigger("change");
		$(document).on('click','#submitbtn',function(){
			$.ajax({
				type: $(this).closest("form").attr("method"),
				data: $(this).closest("form").serialize(),
				url: $(this).closest("form").attr("action"),
				success: function(result){
					try {
						var output = jQuery.parseJSON(result);
						if(output.result==="false"){
							//error
							alert(output.msg);
						}else{
							alert("New Record Added Successfully!!!!");
							var totrows = $("#receive_list").find("tr").length;
							if(totrows>0){}else{$("#receive_panel").show();}
							$("#receive_list").html(result);
							$("#receive_panel").removeClass("hide");
							location.reload();
						}	
					} catch(error) {						
						alert("New Record Added Successfully!!!!");
						var totrows = $("#receive_list").find("tr").length;
						if(totrows>0){}else{$("#receive_panel").show();}
						$("#receive_list").html(result);
						$("#receive_panel").removeClass("hide");
						location.reload();
					}				
				}
			});
		});		
		var options = {
		  format : "yyyy-mm-dd",
			color: "green"
		};
		$('.invndp').datepicker(options);
	});
	$(document).on('click','#stock_recieveFrom_supplier_list',function(){
	
		
		var url="<?php echo base_url();?>StockRecieveFromSupplier";
		window.open(url); 
 	});
		$(document).on('click','#savebtn',function(){
			$(this).attr("disabled","disabled");
			$(this).prop('disabled', true);
	    var res=confirm('Are you sure you want to save the list');
		if(res){
		var url="<?php echo base_url();?>saveInvnSuppReceive";
		window.location.href=url;
		}
		else
		{
			$(this).removeAttr("disabled");
			return false;
		}
	});
</script>