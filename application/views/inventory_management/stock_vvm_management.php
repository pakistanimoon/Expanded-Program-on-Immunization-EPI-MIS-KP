<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> VVM Stage Management </div>
				<div class="panel-body">
					<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
					<?php if(validation_errors() != false){?><div class="alert alert-warning text-center " role="alert"><?php echo validation_errors(); ?></div> <?php } ?>
					<?php echo form_open(base_url().'updatevvmstage',array("class"=>"form-horizontal")); ?>
						<table class="table table-condensed tbl-im" style="width: 60%;">
							<tbody>
								<tr>
									<td>
										<label>Product <span style="color:red">*</span></label>
										<select id="product" name="product" required="required" class="form-control">
											<?php echo get_products_by_activity(); ?>
										</select>										
									</td>
									<td>
										<label> Manufacturer | Batch | Quantity | Priority <span style="color:red">*</span></label>
										<select id="batch" name="batch" required="required" class="form-control">
										</select>
									</td>
									<td>
										<label>&nbsp;</label><br>
										<button style="background:#008d4c;" type="button" class="btn btn-primary btn-md" id="gobtn" role="button"><i class="fa fa-search "></i> Go  </button>
									</td>
								</tr>
							</tbody>
						</table>					
						<div id="changestageform">
							
						</div>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">
function get_vvmstages_by_product(productId,optiontoremove){
	$("select[name=vvm_stage]").html('');
	$.ajax({
		type: "POST",
		datatype: "JSON",
		data: {product: productId,createoptions:true},
		url: "<?php echo base_url("vvmStageByProduct"); ?>",
		success: function(result){
			result = JSON.parse(result);
			$("select[name=vvm_stage]").html(result.optionshtml);
			//alert(optiontoremove);
			$("select[name=vvm_stage]").find("option:contains('"+optiontoremove.trim()+"')").remove();
			//$("select[name=vvm_stage]").find("option[value="+optiontoremove+"]").remove();
		}
	});
}
$(document).ready(function(){
	$(document).on('change','#product',function(){
		var productId = $(this).val();
		$("select[name=batch]").html('');			
		$.ajax({
			type: "POST",
			datatype: "JSON",
			data: {product: productId,createoptions:true},
			url: "<?php echo base_url("priorityDetailsByProduct"); ?>",
			success: function(result){
				result = JSON.parse(result);
				$("select[name=batch]").html(result.mnfctrhtml);
				$('select[name=batch]').trigger("change");
			}
		});
	});
	$(document).on('click','#gobtn',function(){
		//extract location
		var locationtext = $("select[name=batch]").find("option:selected").data("location").trim();
		var locparts = locationtext.split('|');
		//extract quantity and show in readonly field
		var selectedtext = $("select[name=batch]").find("option:selected").text().trim();
		var parts = selectedtext.split('|');
		var tableformhtml = '<table class="table table-bordered table-condensed tbl-im" style="width: 100%;"><thead><tr><th>Location</th><th>Quantity (Vials/Pieces)</th><th>Current VVM Stage</th><th>New VVM Stage</th><th>New VVM Quantity</th></tr></thead><tbody><tr><td>'+locparts[0]+'</td><td>'+parts[2]+'</td><td>'+locparts[1]+'</td><td><select id="vvm_stage" name="vvm_stage" required="required" class="form-control"></select></td><td><input type="text" class="form-control numberclass" required="required" name="quantity" /></td></tr><tr><td colspan="5"><label>&nbsp;</label><br><button type="submit" class="btn btn-success btn-md pull-right mt0" id="updatevvmbtn" role="button">Update VVm Stage</button></td></tr></tbody></table>';
		$("#changestageform").html(tableformhtml);
		var productId = $('#product').val();
		get_vvmstages_by_product(productId,locparts[1]);
	});
});
</script>