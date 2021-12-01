<section class="content">
	<div class="container bodycontainer">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading"> Stock Transfer By Purpose (Campaign/Routine/PTP/IHR) </div>
				<div class="panel-body">
					<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-info text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
					<?php echo form_open(base_url().'stockTransferSave',array("class"=>"form-horizontal"));
						if(validation_errors()){  ?>
							<div class="alert alert-warning alert-dismissible alert-xs" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<strong>Message! </strong><?php echo validation_errors(); ?>
							</div> <?php 
						} ?>
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
										<select id="product" name="product" class="form-control" required="required">
											<option value=""> All </option>
											<?php echo get_products_by_activity(); ?>
										</select>										
									</td>
									<td style="padding-left:10px;">
										<label> Manufacturer | Batch | Quantity | Priority <span style="color:red">*</span></label>
										<select id="batch" name="batch" required="required" class="form-control">
										</select>
									</td>
									<td style="padding-left:10px;">
										<label> Transfer Date </label>
										<input id="transfer_date" name="transfer_date" class="form-control dpinvn" value="<?php echo date('Y-m-d'); ?>" data-date-end-date="0d" readonly="readonly" required="required"/>
									</td>
									<td style="padding-left:10px;">
										<label>&nbsp;</label><br>
										<button style="background:#008d4c;" type="button" class="btn btn-primary btn-md" id="gobtn" role="button"><i class="fa fa-search "></i> Go </button>
									</td>
								</tr>
							</tbody>
						</table>					
						<div id="changepurposeform">
							
						</div>
					<?php echo form_close(); ?>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--end of body container-->
</section><!-- /.content -->
<script type="text/javascript">	
	$(document).ready(function(){
		var options = {
			format : "yyyy-mm-dd",
			color: "green",
			autoclose:true
		};
		$('.dpinvn').datepicker(options);
		$(document).on('change','#product',function(){
			var productId = $(this).val();
			transdate = $("input[name=transfer_date]").val();
			$("select[name=batch]").html('');			
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {product: productId,transdate: transdate,createoptions:true},
				url: "<?php echo base_url("priorityDetailsByProduct"); ?>",
				success: function(result){
					result = JSON.parse(result);
					$("select[name=batch]").html(result.mnfctrhtml);
				}
			});
		});
		$(document).on('change','#transfer_date',function(){
			$('#product').trigger("change");
		});
		function get_transfer_to_products(){
			var activity = $("#activity").find("option:selected").val();
			var product = $("#product").find("option:selected").val();
			$.ajax({
				type: "POST",
				datatype: "JSON",
				data: {product: product,activity: activity,createoptions:true},
				url: "<?php echo base_url("relatedProductsByActivity"); ?>",
				success: function(result){
					result = JSON.parse(result);
					$("select[name=toproduct]").html(result.optionshtml);
				}
			});
		}
		$(document).on('change','#activity',function(){
			get_transfer_to_products();
		});
		$(document).on('click','#gobtn',function(){
			//extract location
			var purposelist = '<?php get_purposes(); ?>';
			var activity = $("select[name=batch]").find("option:selected").data("activity").trim();
			var locationtext = $("select[name=batch]").find("option:selected").data("location").trim();
			var locparts = locationtext.split('|');
			//extract quantity and show in readonly field
			var selectedtext = $("select[name=batch]").find("option:selected").text().trim();
			var parts = selectedtext.split('|');
			var tableformhtml = '<table class="table table-bordered table-condensed tbl-im" style="width: 100%;"><thead><tr><th>S.No</th><th>Location</th><th>Placed Qty (Vials/Pieces)</th><th>VVM Stage</th><th>Current Purpose</th><th>New Purpose</th><th>Transfer To Product</th><th>New Transfer Qty (Vials/Pieces)</th></tr></thead><tbody><tr><td>1</td><td>'+locparts[0]+'</td><td>'+parts[2]+'</td><td>'+locparts[1]+'</td><td>'+activity+'</td><td><select id="activity" name="activity" required="required" class="form-control">'+purposelist+'</select></td><td><select id="toproduct" name="toproduct" required="required" class="form-control"></select></td><td><input type="text" class="form-control numberclass" required="required" name="quantity" /></td></tr><tr><td colspan="8"><b>Comments</b><textarea name="comments" id="comments" class="form-control" rows="3" maxlength="300" cols="80"></textarea></td></tr><tr><td colspan="8"><label>&nbsp;</label><br><button type="submit" class="btn btn-success btn-md pull-right mt0" id="updatepurposebtn" role="button">Update Purpose</button></td></tr></tbody></table>';
			$("#changepurposeform").html(tableformhtml);
			$("select[name=activity]").find("option:contains('"+activity.trim()+"')").remove();
			get_transfer_to_products();
		});
	});
</script>