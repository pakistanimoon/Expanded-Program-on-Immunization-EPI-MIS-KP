<?php
$nonccloctypeshtml = get_options_html($nonccloctypes,true);
$ccloctypeshtml = get_options_html($ccloctypes,true);
$adjsttypeshtml = isset($adjsttypes)?get_options_html($adjsttypes,true,array("nature"=>"nature"),(validation_errors()?set_value('type'):NULL)):false;
?>
<section class="content">
    <div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading">Add Adjustment </div>
				<div class="panel-body">
					<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
					<?php if(validation_errors() != false){?><div class="alert alert-warning text-center " role="alert"><?php echo validation_errors(); ?></div> <?php } ?>
					<?php echo form_open(base_url().'invnStockAdjustSave',array("class"=>"form-horizontal")); ?>
						<table class="table table-bordered table-condensed tbl-im">
							<tbody>
								<tr>
									<td>
										<label> Adjustment Date <span style="color:red">*</span></label>
										<input id="adjust_date" name="adjust_date" class="form-control dpinvn" value="<?php echo (validation_errors())?set_value('adjust_date'):date('Y-m-d'); ?>" readonly="readonly" type="text">
									</td>
									<td>
										<label>Adjustment Type <span style="color:red">*</span></label>
										<select name="type" id="type" required="required" class="form-control">
											<option value=""> Select </option>
											<?php echo $adjsttypeshtml; ?>
										</select>
									</td>
									<td>
										<label>Ref. No.</label>
										<input name="ref" type="text" class="form-control" value="<?php echo set_value('ref'); ?>" />
									</td>
								</tr>
								<tr>
									<td>
										<label>Purpose <span style="color:red">*</span></label>
										<select id="activity_purpose" name="activity_purpose" required="required" class="form-control" >
											<?php get_purposes(false); ?>
										</select>
									</td>
									<td>
										<label>Product <span style="color:red">*</span></label>
										<select id="product" name="product" required="required" class="form-control">
											<option value=""> Select </option>
											<?php echo get_products_by_activity(NULL,FALSE,set_value('product')); ?>
										</select>
									</td>
									<td id="batchtd">
										<label> Manufacturer | Batch | Quantity  <span style="color:red">*</span></label>
										<select id="batch" name="batch" required="required" class="form-control">
										</select>
									</td>
									
								</tr>
								
								<tr>
									<td>
										<label class="locationlabel"> Location | VVM Stage <span style="color:red">*</span></label>
										<select id="vvm_loc" name="vvm_loc" class="form-control">
											
										</select>
										<select id="location" name="location" class="form-control hide">
											<option value="">-- Select --</option>
											<option value="">-- D1 --</option>
											<option value="">-- D2 --</option>
										</select>
										<input type="hidden" name="location_type" id="location_type" value="ccm_id" >
									</td>
									<td class="hide vvmstagetd">
										<label> VVM Stage <span style="color:red">*</span></label>
										<select id="vvm_stage" name="vvm_stage" class="form-control">
											<option value="">-- Select --</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</td>
									<td>
										<label>Available Quantity<span style="color:red">*</span></label>
										<input class="form-control" id="available_quantity" name="available_quantity" value="<?php echo set_value('available_quantity'); ?>" readonly="readonly" type="text">
									</td>
									
								</tr>
								<tr>
								<td>
										<label> Quantity to Adjust <span style="color:red">*</span><small>(<span  id="unittext">Vials</span>)</small></label>
										<input class="form-control numberclass" name="quantity" id="quantity" value="<?php echo set_value('quantity'); ?>" required="required" type="text" style="width: 86%;">
										
										<input type="hidden" id="activity" name="activity" value="" >
										<input type="hidden" id="masterid" name="masterid" value="<?php echo set_value('masterid'); ?>" >
										<input type="hidden" id="item_unit_id" name="item_unit_id" value="" >
										<input type="hidden" id="transactionnature" name="transactionnature" value="" >
									</td>
									
								</tr>
								<tr>
									<td colspan="3">
										<label>Comments</label>
										<textarea class="form-control" name="comments"></textarea>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="row">      
							<div style="text-align: right;" class="col-md-6 col-md-offset-6 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
								<button style="background:#008d4c;" type="submit" id="adjustbtn" class="btn btn-primary btn-md" role="button"><i class="fa fa-plus "></i> Add Adjustment </button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
	<div class="modal fade" id="AddBatchModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<?php echo form_open(base_url().'invnAddAdjustBatch',array("class"=>"form-horizontal")); ?>
				<div class="modal-content">
					<div class="modal-header" height="35px">
						<h4 class="modal-title">Add Batch</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Product <span style="color:red;">*</span></label>
										<select id="batchproduct" name="product" required="required" class="form-control">
											<option value=""> Select </option>
											<?php echo get_products_by_activity(NULL,FALSE); ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label">Batch No.<span style="color:red;">*</span></label>
										<input name="batch_numb" id="batch_numb" value="" class="form-control" required="" type="text">                           
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Production Date<span class="hide1" style="color:red;">*</span></label>
									<div class="form-group">
										<input class="form-control production" name="production_date" id="production_date" type="text" data-date-end-date="0d">
									</div>
								</div>
								<div class="col-md-6">
									<label class="control-label">Expiry Date<span style="color:red;">*</span></label>
									<div class="form-group">
										<input class="form-control expiry" name="expiry_date" id="expiry_date" required="required" type="text">
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Manufacturer<span style="color:red;">*</span></label>
									<div class="form-group">
										<select id="manufacturer" name="manufacturer" required="required" class="form-control">
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<label class="control-label">VVM Type<span style="color:red;">*</span></label>
									<div class="form-group">     
										<select id="vvm_type" name="vvm_type" required="required" class="form-control">
											<?php echo $data["vvmshtml"]; ?>
										</select>                                
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label">Unit Price (PKR)<span style="color:red;">*</span></label>
									<div class="form-group">
										<input class="form-control numberclass" name="unit_price" required="required" id="unit_price" type="text">
									</div>
								</div>
							</div>
							<br>
							<div class="col-md-6" style="margin-left: 65%;">
								<input type="hidden" id="modaltranstypeid" name="transtype" value="" >
								<button id="btn-modalForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>                             
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section><!-- /.content -->
<script type="text/javascript">	
	var ccloctypeshtml = '<?php echo $ccloctypeshtml; ?>';
	var nonccloctypeshtml = '<?php echo $nonccloctypeshtml; ?>';
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
		 $(document).on('change','#activity_purpose',function(){
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
		$('#activity_purpose').trigger("change");
		$(document).on('change','#product',function(){
			var productId = $(this).val();
			unittitle = $("#product").find("option:selected").data("unittitle");
			itemunitid = $("#product").find("option:selected").data("unitid");
			activity = $("#activity_purpose").find("option:selected").val();
			transdate = $("input[name=adjust_date]").val();
			var adjustment_type=$("#type").find("option:selected").val();
			if(adjustment_type==''){
				var nature=0;
			}else{
				var nature=$("#type option:selected").attr('data-nature');
			}
			$("select[name=batch]").html('');			
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {product: productId,transdate:transdate,nature:nature},
				url: "<?php echo base_url("DetailsByProduct"); ?>",
				success: function(result){
					result = JSON.parse(result);
					$("select[name=batch]").html(result.mnfctrhtml);
					$('select[name=batch]').trigger("change");
				}
			});
			$("#unittext").text(unittitle);
			$("#activity").val(activity);
			$("#item_unit_id").val(itemunitid);
			get_vvmstages_by_product(productId);
		});
		$(document).on('change',"input[name=adjust_date]",function(){
			$("#product").trigger("change");
		});
		$(document).on('change','#batch',function(){
			//if nature id 1 then placement location
			var nature = $("select[name=type]").find("option:selected").data("nature");
			if(nature=="1"){
				itemcatid = $("#product").find("option:selected").data("categoryid");
				if(itemcatid=="1"){
					$("#location").html(ccloctypeshtml);
					$("#location_type").val("ccm_id");
				}else{
					$("#location").html(nonccloctypeshtml);
					$("#location_type").val("non_ccm_id");
				}
				//show location field
				$("#location").removeClass("hide");
				$(".vvmstagetd").removeClass("hide");
				$(".locationlabel").text("Location");
				$("#vvm_loc").addClass("hide");
			}else{
				var selectedindex = $(this).find("option:selected").index();
				if($(this).find("option:selected").data("location")){
					var lochtml = '<option value="" >'+$(this).find("option:selected").data("location")+'</option>';
				}else{
					var lochtml = '';
				}
				$("select[name=vvm_loc]").html(lochtml);
				//show vvm_loc field
				$("#location").addClass("hide");
				$(".vvmstagetd").addClass("hide");
				$(".locationlabel").text("Location | VVM Stage");
				$("#vvm_loc").removeClass("hide");
			}			
			var selectedtext = $(this).find("option:selected").text().trim();
			var parts = selectedtext.split(' | ');
			var avlquantity = parts[2];
			$("#available_quantity").val(avlquantity);
			$("#masterid").val($(this).find("option:selected").data("masterid"));
			
			//locationlabel
		});
		$(document).on('change','select[name=type]',function(){
			var nature = $(this).find("option:selected").data("nature");
			$("#addbatchbtn").remove();
			if(nature=="1"){
				$("#batch").css("width","85%");
				$("#batch").css("display","inline-block");
				$("#batchtd").append('<button type="button" id="addbatchbtn" class="btn btn-success btn-md" data-toggle="modal" data-target="#AddBatchModal">New</button>');
				$("#addbatchbtn").css('float', 'right');
				$("#addbatchbtn").css('margin-right', '10px');
			}else{
				$("#batch").css("width","100%");
			}
			$("#modaltranstypeid").val($(this).find("option:selected").val());
			//unset everything
			$("#product option:selected").prop("selected", false);
			$("#product").trigger("change");
			$("#transactionnature").val(nature);
		});
		$("#product").trigger("change");
		$(document).on('click','#adjustbtn',function(){
			$(this).attr("disabled","disabled");
			var res=confirm("Are You Sure To Add Adjustment ?");
			if(res)
				{
					masterid = $("#batch").find("option:selected").data("masterid");
					$("#masterid").val(masterid);
					$("#quantity").trigger("change");
					if($('#type').val()=="")
					{
						alert("Please select Adjustment Type.");
						$(this).removeAttr("disabled");
						return false;
					}
					else
					{
						$(this).prop('disabled', true);
						$(this.form).submit();
					}
				}
				else
				{
					$(this).removeAttr("disabled");
					return false;
				}
			});
		var options = {
			format : "yyyy-mm-dd",
			color: "green",
			autoclose:true
		};
		$('.dpinvn').datepicker(options);
		
		//production date
		var options = {
				format : "yyyy-mm-dd",
				color: "green",
				autoclose: true
			};
		$('.production').datepicker(options);
		$(document).on('change','#production_date',function(){
			var production_date = $(this).val();
			var adjust_date=  $("#adjust_date").val();
			if(adjust_date > production_date){
				var options = {
					format : "yyyy-mm-dd",
					color: "green",
					autoclose: true
				};
				$('.production').datepicker(options);
			}else{
				alert('Production Date does not greater than Adjustment Date');
				$('#production_date').val("");
				return false;
			}
		});
		//expiry date
		var options = {
				format : "yyyy-mm-dd",
				color: "green",
				autoclose: true
			};
		$('.expiry').datepicker(options);
		$(document).on('change','#expiry_date',function(){
			var expiry_date = $(this).val();
			var production_date=  $("#production_date").val();
			if(expiry_date > production_date){
				var options = {
					format : "yyyy-mm-dd",
					color: "green",
					autoclose: true
				};
				$('.expiry').datepicker(options);
			}else{
				alert('Expiry Date does not less than Production Date');
				$('#expiry_date').val("");
				return false;
			}
		});
		//to save new modal
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
		$(document).on('change','#batchproduct',function(){
			var productId = $(this).val();
			//itemcatid = $("#batchproduct").find("option:selected").data("categoryid");
			//itemunitid = $("#batchproduct").find("option:selected").data("unitid");
			//unittitle = $("#batchproduct").find("option:selected").data("unittitle");
			//activity = $("#batchproduct").find("option:selected").data("activity");
			get_manufacturer_of_product(productId);
			/* get_vvmstages_by_product(productId); */
			/* if(itemcatid=="1"){
				$("#location").html(ccloctypeshtml);
				$("#location_type").val("ccm_id");
			}else{
				$("#location").html(nonccloctypeshtml);
				$("#location_type").val("non_ccm_id");
			} */
			//$("#item_unit_id").val(itemunitid);
			//$("#unittext").text(unittitle);
			//$("#activity").val(activity);
		});
		//('#batchproduct').trigger("change");
		$(document).on('click','#addbatchbtn',function(){
		$('#batchproduct').trigger("change");
		});
		$(document).on('click','#btn-modalForm-submit',function(){
			
			$.ajax({
				type: $(this).closest("form").attr("method"),
				data: $(this).closest("form").serialize(),
				url: $(this).closest("form").attr("action"),
				success: function(result){
					try {
						var output = jQuery.parseJSON(result);
						if(output.result==="false"){
							alert(output.msg);
						}else{
							alert("New Batch Added Successfully!!!!");
							$("#cancelmodal").trigger("click");
							$("select[name=type]").trigger("change");
								$('#product').val(output.product);
							$('#product').trigger("change");
							//getBatchDetail(output.batch_id,output.product);
						}	
					} catch(error) {						
						
					}				
				}
			});
		});
$(document).on('change','#quantity',function(){
	var avial_qty=parseInt($('#available_quantity').val());
	var qty=parseInt($(this).val());
	var nature=parseInt($('#transactionnature').val());
	if(nature==0)
{
		if(qty > avial_qty)
		{
			alert("Quantity to adjust must be less than Avialable Qty.");
			return false;
		}
		else
		{
			return true;
		}
	}
});
		
	});
</script>