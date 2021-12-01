<style>
	/*                        */
 /*                      */
  /*Custom Css for Model*/
   /*                  */
    /*                */

.cst-modal .modal-header{
	background: #0a7745;
    color: #f1f1f1;
    font-weight: 600;
    border-left: 15px solid #086138;
	padding: 5px 15px;
}
.cst-modal h4.modal-title-transfer{
	font-weight:600;
}	
.cst-modal .form-control{
	height:30px;
	border-radius:2px;
	padding:4px 1px;
	color:#383838;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control{
	padding-left:15px;
	background-color:#f7f7f7;
}
.cst-modal span.radio-opt{
	position: relative;
    top: -2px;
}

.radio-row{
	background: #10b578;
    color: white;
    padding-top: 5px;
	 padding-bottom: 5px;
    border-radius: 3px;
    border: 1px solid #0ea361;
    margin-right: 0px;
    margin-left: 0px;
    padding-left: 4px;
}
</style>
	
<div class="panel panel-primary">
	  <div class="panel-heading">Catalogues Cold Room Edit Form </div>
		<div class="panel-body">
			<form action="<?php echo base_url()?>Coldchain/Catalogue_coldroomUpdate" method="post" enctype="multipart/form-data">
				<div class="add_refrigerator inside-page">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 margin-bottom">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Catalogue ID <span style="color:red;">*</span></label>
										<input name="catalogue_id" id="catalogue_id_popup" value="<?php echo $data['catalogue_id'];?>" class="form-control" type="text" required>
										<input type="hidden" id="pk_id" name="pk_id" class="form-control" value="<?php echo $data['pk_id'];?>">								
										<input type="hidden" id="ccm_make_id" name="ccm_make_id" class="form-control" value="<?php echo $data['ccm_make_id'];?>">	
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>
										<input name="make_name" id="ccm_make_popup" value="<?php echo $data['make_name'];?>" class="form-control" type="text" required>                                
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Model <span style="color:red;">*</span></label>
										<input name="model_name" id="ccm_model_popup" value="<?php echo $data['model_name'];?>" class="form-control" type="text" required>                                
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="ccmassettypeid">Asset Sub Type <span style="color:red;">*</span></label>
										<select name="ccm_sub_asset_type_id" id="ccm_asset_type_id_popup" class="form-control" required>
											<option value="">--Select--</option>
											<?php foreach($assets_sub_types as $values){ ?>
												<option value="<?php echo $values['pk_id'];?>"  <?php if($data['assetname'] == $values['asset_type_name'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $values['asset_type_name'] ?>
											<?php } ?>
										</select>                       
									</div>
								</div>
							</div>
						</div>		
						<div class="row radio-row">
						
							<div class="col-md-12">
								<label class="control-label" for="dimensions">Dimensions Feet<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
							</div>	
						</div>
						<br>
						<div class="form-group row">
							<div class="col-md-4"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="<?php echo $data['internal_dimension_length'];?>" class="form-control numberclass internaldimension" placeholder="Length"  type="text" required>      </div>                              
							<div class="col-md-4"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="<?php echo $data['internal_dimension_width'];?>" class="form-control numberclass internaldimension" placeholder="Width"  type="text" required>   </div>                                 
							<div class="col-md-4"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="<?php echo $data['internal_dimension_height'];?>" class="form-control numberclass internaldimension" placeholder="Height"  type="text" required></div>                                
						</div>	

						<div class="row">			
							<div class="col-md-6">
								
									<label for="Model">Internal gross volume (m3)<span style="color:red;">*</span></label>
									<input type="text" id="gross_capacity" name="gross_capacity" class="form-control" placeholder="Gross Capacity" value="<?php echo $data['gross_capacity_20'];?>" required>
							</div>	
							<div class="col-md-6">
								<label class="control-label"  for="refrigerator_gas_type">Refrigerator Gas Type <span class="hide1" style="color:red; visibility:hidden;">*</span></label>
								<div class="controls">
									<select name="gas_type" id="refrigerator_gas_type" class="form-control">
									<option value="" selected="selected">Select</option>
									<option <?php if($data['gas_type'] == 'R12') { echo 'selected="selected"'; }else echo ''; ?> value="R12">R12</option>
									<option <?php if($data['gas_type'] == 'R134A') { echo 'selected="selected"'; }else echo ''; ?> value="R134A">R134A</option>
									<option <?php if($data['gas_type'] == 'R22') { echo 'selected="selected"'; }else echo ''; ?> value="R22">R22</option>
									<option <?php if($data['gas_type'] == 'R404a') { echo 'selected="selected"'; }else echo ''; ?> value="R404a">R404a</option>
									<option <?php if($data['gas_type'] == 'R600A') { echo 'selected="selected"'; }else echo ''; ?> value="R600A">R600A</option>
									<option <?php if($data['gas_type'] == 'Unknown') { echo 'selected="selected"'; }else echo ''; ?> value="Unknown">Unknown</option>
								</select>                            
								</div>
								</div>

							<div class="col-md-6">
								
									<label for="Storage">Net storage volume for vaccine/packs (m3)<span style="color:red;">*</span></label>
									<input type="text" id="net_capacity" class="form-control" name="net_capacity" value="<?php echo $data['net_capacity_20'];?>" placeholder="Net Capacity" required>
									
								
							</div>
							<div class="col-md-6">
								<label class="control-label" for="product_price">Product Price <span class="hide1"="hide2" style="color:red; visibility:hidden;">*</span></label>
									<div class="controls ">     
										<input name="product_price" id="product_price" value="<?php echo $data['product_price'];?>" class="form-control" type="text" required>                                
									</div>
							</div>	
						</div>
						<hr/>
						<div class="text-right">	
							<div class="row">
								<div class="col-md-5 col-md-offset-7">
								<button id="submit" type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
									<button type="Button" class="btn-background box1" id="cancel1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
								</div>
							</div><!--- row --->
						</div>
					</div>
					<!--- row --->						
				</div><!-- inside-page end-->
	
			</form>
			<!-- Modal-->
<script type="text/javascript">
 /** For Internal Dimensions Greater Than Zero **/
$('.internaldimension').on('keyup change', checkinternaldimension);
function checkinternaldimension()
{
	
		var value=$(this).val();
		if(value > 0)
		{
			$(this).css("border","");
			//$("#btn-modalForm-submit").attr("disabled", false);
			 //event.preventDefault();
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Internal Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
} 
$("#asset_dimension_length_popup, #asset_dimension_width_popup, #asset_dimension_height_popup").change(function() {
	
	var gross_capacity = (parseInt($('#asset_dimension_length_popup').val()) || 0) * (parseInt($('#asset_dimension_width_popup').val()) || 0) * (parseInt($('#asset_dimension_height_popup').val()) || 0);
	var percent = (100/65);
	var net_capacity = gross_capacity/percent;
	if(net_capacity > 0)
	{
		
		$('#gross_capacity').val(gross_capacity);
		$('#net_capacity').val(net_capacity.toFixed(2));
	}else
	{
		$('#gross_capacity').val('');
		$('#net_capacity').val('');
	}
});

$(document).on("change", "input[name=placed_at-0]", function () {
    var id = $(this).val();
	if(id==1){
		$("#store_hid").slideDown(500);
	}else{
		$("#store_hid").slideUp(500);
		$('#distcodeREF').removeAttr("required");
		$('#tcodeREF').removeAttr("required");
		$('#uncodeREF').removeAttr("required");
		$('#facode_th').removeAttr("required");
		$("#distcodeREF").val('');
		$("#tcodeREF").val('');
		$("#uncodeREF").val('');
		$("#facode_th").val('');
		$('#store_id').val('0');
	}
});
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Coldroom_List/21";
	window.location.href=url;
});
</script>