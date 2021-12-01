
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
    border-radius: 3px;
    border: 1px solid #0ea361;
    margin-right: 0px;
    margin-left: 0px;
    padding-left: 4px;
}
</style>

<div class="panel panel-primary cst-label">
  <div class="panel-heading">New/Add Refrigerator/Freezer/ILR Catalogues</div>
	<div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/Catalogue_refrigeratorSave" onsubmit="return checkRequired();" method="post" enctype="multipart/form-data">
			<div class="row" style="margin-bottom:10px">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="catalogueid">Catalogue ID <span style="color:red;">*</span></label>
								<input name="catalogue_id" id="catalogue_id_popup" value="" class="form-control" type="text" required="">                                
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>
								<input name="make_name" id="ccm_make_popup" value="" class="form-control" type="text" required="">                                
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="catalogueid">Model <span style="color:red;">*</span></label>
								<input name="model_name" id="ccm_model_popup" value="" class="form-control" type="text" required="">                                
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="ccmassettypeid">Asset Sub Type <span style="color:red;">*</span></label>
								<select name="ccm_sub_asset_type_id" id="ccm_asset_type_id_popup" class="form-control" required="">
									<option value="">--Select--</option>
									<?php
										foreach($assets_sub_types as $values){ ?>
											<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
									<?php } ?>
								</select>                       
							</div>
						</div>
					</div>
					<div class="row radio-row">
						<div class="col-md-6 ">
							<label class="control-label" for="dimensions">Dimensions Feet<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
						</div>
						<div class="col-md-6">
							<div class="row">	
								<div class="col-md-6"><label class="control-label" for="cfcfree">Is PIS/PQS </label></div>
								<div class="col-md-6">	
									<div class="controls cfc_radio">
										<label><input name="is_pqs" id="is_pis_pqs-1" value="1" type="radio"><span class="radio-opt">Yes</span></label><label><input name="is_pqs" id="is_pis_pqs-0" value="0" checked="checked" type="radio"><span class="radio-opt">No</span></label>                                
									</div>
								</div>	
							</div>	
						</div>	
					</div>
					<br>									
					<div class="form-group row">
						<div class="col-md-3"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass dimension" placeholder="Length" readonly="" type="text">      </div>                              
						<div class="col-md-3"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass dimension" placeholder="Width" readonly="" type="text">   </div>                                 
						<div class="col-md-3"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass dimension" placeholder="Height" readonly="" type="text"></div>                                
					</div>
					<div class="row radio-row">
						<div class="col-md-12">
							<label class="control-label" for="capacity">Capacity Liters<span class="hide1" style="color:red; visibility:hidden;">*</span></label>
						</div>
					</div>	
					<br>
					<div class="form-group row">
						<div class="col-md-3">	<input name="gross_capacity_4" id="gross_capacity_4_popup" value="" class="form-control numberclass capacity" placeholder="Gross +2 to +8" readonly="" type="text">          </div>                          
						<div class="col-md-3">	<input name="gross_capacity_20" id="gross_capacity_20_popup" value="" class="form-control numberclass capacity" placeholder="Gross 15 to 20" readonly="" type="text">  </div>                                  
						<div class="col-md-3">	<input name="net_capacity_4" id="net_capacity_4_popup" value="" class="form-control numberclass capacity" placeholder="Net +2 to +8" readonly="" type="text">    </div>                                
						<div class="col-md-3">	<input name="net_capacity_20" id="net_capacity_20_popup" value="" class="form-control numberclass capacity" placeholder="Net 15 to 20" readonly="" type="text">  </div>                              
					</div>
					
					<div class="row radio-row">		
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6"><label class="control-label" for="cfcfree">CFC&nbsp;Free&nbsp;Sticker </label></div>
								<div class="col-md-6">
									<div class="controls cfc_radio">
										<label><input name="cfc_free" id="cfc_free-2" value="2" type="radio"><span class="radio-opt">NA</span></label><label><input name="cfc_free" id="cfc_free-1" value="1" type="radio"><span class="radio-opt">Yes</span></label><label><input name="cfc_free" id="cfc_free-0" value="0" checked="checked" type="radio"><span class="radio-opt">No</span></label>                                
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<div class="col-md-4">
							<label class="control-label" style="margin-top:-18px" for="refrigerator_gas_type">Refrigerator Gas Type <span class="hide1" style="color:red; visibility:hidden;">*</span></label>
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
						<div class="col-md-4">
							<label class="control-label" for="product_price">Product Price <span class="hide1" ="hide2"="" style="color:red; visibility:hidden;">*</span></label>
							<div class="controls ">     
								<input name="product_price" id="product_price" value="" class="form-control numberclass" type="text">                                
							</div>
						</div>
						<div class="col-md-4">
							<label class="control-label" for="power_source">Power Source <span class="hide1" ="hide3"="" style="color:red; visibility:hidden;">*</span></label>
							<div class="controls">
								<select name="power_source" id="power_source" class="form-control">
										<?php echo getPowerSource($data['power_source'],FALSE,1); ?>
								</select>                                
							</div>
						</div>
					</div>
					<hr />
					<div class="text-right">	
						<div class="row">
						<div class="col-md-5 col-md-offset-7">
							<button id="submit" type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button type="Button" class="btn-background box1" id="cancel1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
						</div><!--- row --->
					</div>
				</div>		
			</div>
		</form>
	</div> <!-- panel body-->
<!--</div><!-- panel primary-->
</div>
<!-- panel primary-->
<script type="text/javascript">
$(document).on("change", "input[name=is_pqs]", function () {
    var id = $('input[name=is_pqs]:checked').val();
	if(id==1){
		$('#asset_dimension_length_popup').attr('readonly', false);
		$('#asset_dimension_length_popup').attr('placeholder','length');
		$('#asset_dimension_width_popup').attr('readonly', false);
		$('#asset_dimension_width_popup').attr('placeholder','width');
		$('#asset_dimension_height_popup').attr('readonly', false);
		$('#asset_dimension_height_popup').attr('placeholder','Height');
		$('#gross_capacity_4_popup').attr('readonly', false);
		$('#gross_capacity_4_popup').attr('placeholder','gross +2 to +8');
		$('#gross_capacity_20_popup').attr('readonly', false);
		$('#gross_capacity_20_popup').attr('placeholder','gross 15 to 20');
		$('#net_capacity_4_popup').attr('readonly', false);
		$('#net_capacity_4_popup').attr('placeholder','Net +2 to +8');
		$('#net_capacity_20_popup').attr('readonly', false);
		$('#net_capacity_20_popup').attr('placeholder','Net 15 to 20');
		$(".hide1").css("visibility", "visible");
	}else{
		$('#asset_dimension_length_popup').attr('readonly', true);
		$('#asset_dimension_length_popup').attr('placeholder','length');
		$('#asset_dimension_width_popup').attr('readonly', true);
		$('#asset_dimension_width_popup').attr('placeholder','width');
		$('#asset_dimension_height_popup').attr('readonly', true);
		$('#asset_dimension_height_popup').attr('placeholder','Height');
		$('#gross_capacity_4_popup').attr('readonly', true);
		$('#gross_capacity_4_popup').attr('placeholder','gross +2 to +8');
		$('#gross_capacity_20_popup').attr('readonly', true);
		$('#gross_capacity_20_popup').attr('placeholder','gross 15 to 20');
		$('#net_capacity_4_popup').attr('readonly', true);
		$('#net_capacity_4_popup').attr('placeholder','Net +2 to +8');
		$('#net_capacity_20_popup').attr('readonly', true);
		$('#net_capacity_20_popup').attr('placeholder','Net 15 to 20');
		$(".hide1").css('visibility','hidden');
	}
});
/** For Dimensions Greater Than Zero **/
$('.dimension').on('change', checkdimension);
function checkdimension()
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
			alert("Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
		}
	
}
/** For Capacity Liters Greater Than Zero **/
$('.capacity').on('change', checkcapacity);
function checkcapacity()
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
		alert("Capacity must be greater than zero.");
		$(this).css("border","2px solid red");
		$("#submit").prop('disabled', true);
		
	}	
}
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Refrigerator_List/1";
	window.location.href=url;
});	
</script>