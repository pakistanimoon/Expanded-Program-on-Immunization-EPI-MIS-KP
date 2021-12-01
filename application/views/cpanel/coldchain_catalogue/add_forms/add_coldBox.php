<style>
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
<div class="panel panel-primary">
  <div class="panel-heading">Add Cold Box Catalogues</div>
	<div class="panel-body">
		<!-- main form start-->
		<div class="add_refrigerator inside-page">
			<form method="post" action="<?php echo base_url() ?>Coldchain/Catalogue_coldBoxSave" onsubmit="return checkRequired();" enctype="multipart/form-data">
				<div class="modal-content cst-modal">
					<div class="modal-body">
						<div class="row">
						<div class="col-md-12">
							<div class="col-md-3">
								<div class="form-group">
									<label>Catalogue ID <span style="color:red;">*</span></label>
									<input type="text" name="catalogue_id" id="catalogue_id_popup" class="form-control" required="" />
									<input type="hidden" id="asset_type_id" name="asset_type_id" value="33" class="form-control" />
									<input type="hidden" id="sub_asset_type_id" name="ccm_sub_asset_type_id" value="33" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Make <span style="color:red;">*</span></label>
									<input type="text" name="make_name" id="ccm_make_popup" class="form-control" required=""/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Model<span style="color:red;">*</span></label>
									<input type="text" name="model_name" id="ccm_model_popup" class="form-control" required=""/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Cost (US$)<span style="color:red;">*</span></label>
									<input type="text" id="product_price" name="product_price" class="form-control numberclass" />
								</div>
							</div>
						</div><!--- row --->
					</div>	
						<!-- -->
							<div class="row radio-row">
								<div class="col-md-12">
									<label class="control-label" for="dimensions">Dimensions<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
								</div>	
							</div>	
							<br>				
							<div class="form-group row">
								<div class="col-md-4"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass dimension" placeholder="Length"  type="text">      </div>                              
								<div class="col-md-4"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass dimension" placeholder="Width"  type="text">   </div>                                 
								<div class="col-md-4"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass dimension" placeholder="Height"  type="text"></div>                                
							</div>
								
							<div class="row radio-row">
								<div class="col-md-12">
									<label class="control-label" for="Dimensions">Dimensions(Internal)<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
								</div>
							</div>	
							<br>
							<div class="form-group row">
								<div class="col-md-4 ">	<input name="internal_dimension_length" id="internal_dimension_length" value="" class="form-control numberclass internaldimension" placeholder="Length"  type="text">          </div>                          
								<div class="col-md-4">	<input name="internal_dimension_width" id="internal_dimension_width" value="" class="form-control numberclass internaldimension" placeholder="Width"  type="text">  </div>                                  
								<div class="col-md-4">	<input name="internal_dimension_height" id="internal_dimension_height" value="" class="form-control numberclass internaldimension" placeholder="Height"  type="text">    </div>                              
							</div>
							
							
							<div class="row radio-row">
								<div class="col-md-12">
									<label class="control-label" for="Dimensions">Dimensions(Storage)<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
								</div>
							</div>	
							<br>
							<div class="form-group row">
								<div class="col-md-4">	<input name="storage_dimension_length" id="storage_dimension_length" value="" class="form-control numberclass storagedimension" placeholder="Length"  type="text">          </div>                          
								<div class="col-md-4">	<input name="storage_dimension_width" id="storage_dimension_width" value="" class="form-control numberclass storagedimension" placeholder="Width"  type="text">  </div>                                  
								<div class="col-md-4">	<input name="storage_dimension_height" id="storage_dimension_height" value="" class="form-control numberclass storagedimension" placeholder="Height"  type="text">    </div>                              
							</div>			
						<div class="text-right">
							<div class="row">
								<div class="col-md-5 col-md-offset-7">
								<button id="submit" type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
									<button type="Button" class="btn-background box1" id="cancel1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
								</div>
							</div>
						</div>
					</div>
				</div>	
				<!--- row --->
				</form>	
		</div>
	</div>
</div>
			
		
<script type="text/javascript">
/** For Dimension Liters Greater Than Zero **/
$('.dimension').on('keyup change', checkdimension);
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
			alert("Dimension must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
		}
	
}
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
/** For Storage Dimension Liters Greater Than Zero **/
$('.storagedimension').on('keyup change', checkstoragedimension);
function checkstoragedimension()
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
			alert("Storage Dimension must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
		}
	}
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Coldbox_List/33";
	window.location.href=url;
});	
</script>