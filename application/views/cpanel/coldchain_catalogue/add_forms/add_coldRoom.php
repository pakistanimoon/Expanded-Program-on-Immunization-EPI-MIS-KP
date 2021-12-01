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
	
<div class="panel panel-primary cst-label">
	  <div class="panel-heading">Add Cold Room Catalogues</div>
		<div class="panel-body">
			<form action="<?php echo base_url()?>Coldchain/Catalogue_coldroomSave" method="post" enctype="multipart/form-data">
				<div class="add_refrigerator inside-page">
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12 margin-bottom">
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Catalogue ID <span style="color:red;">*</span></label>
										<input name="catalogue_id" id="catalogue_id_popup" value="" class="form-control" type="text" required>                                
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>
										<input name="make_name" id="ccm_make_popup" value="" class="form-control" type="text" required>                                
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="catalogueid">Model <span style="color:red;">*</span></label>
										<input name="model_name" id="ccm_model_popup" value="" class="form-control" type="text" required>                                
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label class="control-label" for="ccmassettypeid">Asset Sub Type <span style="color:red;">*</span></label>
										<select name="ccm_sub_asset_type_id" id="ccm_asset_type_id_popup" class="form-control" required>
											<option value="">--Select--</option>
											<?php
												foreach($assets_sub_types as $values){ ?>
													<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
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
							<div class="col-md-4"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass internaldimension" placeholder="Length"  type="text" required>      </div>                              
							<div class="col-md-4"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass internaldimension" placeholder="Width"  type="text" required>   </div>                                 
							<div class="col-md-4"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass internaldimension" placeholder="Height"  type="text" required></div>                                
						</div>	

						<div class="row">			
							<div class="col-md-6">
								
									<label for="Model">Internal gross volume (m3)<span style="color:red;">*</span></label>
									<input type="text" id="gross_capacity" name="gross_capacity" class="form-control" placeholder="Gross Capacity" required>
							</div>	
							<div class="col-md-6">
								<label class="control-label"  for="refrigerator_gas_type">Refrigerator Gas Type <span class="hide1" style="color:red; visibility:hidden;">*</span></label>
								<div class="controls">
									<select name="gas_type" id="refrigerator_gas_type" class="form-control">
										<option value="" selected="selected">Select</option>
										<option value="R12">R12</option>
										<option value="R134A">R134A</option>
										<option value="R22">R22</option>
										<option value="R404a">R404a</option>
										<option value="R600A">R600A</option>
										<option value="Unknown">Unknown</option>
									</select>                                
								</div>
								</div>

							<div class="col-md-6">
								
									<label for="Storage">Net storage volume for vaccine/packs (m3)<span style="color:red;">*</span></label>
									<input type="text" id="net_capacity" class="form-control" name="net_capacity" placeholder="Net Capacity" required>
									
								
							</div>
							<div class="col-md-6">
								<label class="control-label" for="product_price">Product Price <span class="hide1"="hide2" style="color:red; visibility:hidden;">*</span></label>
									<div class="controls ">     
										<input name="product_price" id="product_price" value="" class="form-control" type="text" required>                                
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
		</div> <!-- panel body-->
</div><!-- panel primary-->
		
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
           $("#submit").prop('disabled', false);
		}
		else
		{
			alert("Internal Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
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
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Coldroom_List/21";
	window.location.href=url;
});	
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
} 
</script>