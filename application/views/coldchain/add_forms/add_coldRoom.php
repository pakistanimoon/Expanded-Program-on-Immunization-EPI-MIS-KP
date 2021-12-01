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
	  <div class="panel-heading">Add Cold Room</div>
		<div class="panel-body">
			<form action="<?php echo base_url()?>Coldchain/coldroomSave" method="post" enctype="multipart/form-data">
				<div class="add_refrigerator inside-page">
					<?php echo ((isset($commonSections))?$commonSections:""); ?>
						<input type="hidden" name="increment" value="<?php echo $varMax; ?>" class="form-control" />
						<!--- row --->	
				<div class="row" style="margin-bottom:10px">
					<div class="col-md-4">
								<div class="row">
										<div class="col-md-4">
											<label for="Catalogue">Catalog ID <span style="color:red;">*</span></label>
										</div>
										<div class="col-md-8">
												<select class="form-control" name="ccm_model_id" id="catalogue_id_main" required>
											<option value="" >Select</option>
											<?php if(isset($dataModel) && $dataModel!='') {
														foreach($dataModel as $value){ ?>
															<option value="<?php echo $value['pk_id']; ?>"><?php echo $value['catalogue_id']; ?></option>
													<?php } 
													}?>
											</select>
									</div>
									<!--<div class="col-md-2">
										<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" title="Add Make and Modal" data-target="#myModal" style="position:relative"> <i class="fa fa-plus"></i></button>
										</div>-->
								</div>
						</div>
					</div>
					<!--Row end -->
					<!-- Show Catalogue -->
					<div id="modelHide" style="display: none;">
					<div class="row" style="margin-bottom:10px">
							<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Make">Make <span style="color:red;">*</span></label>
											</div>
											<div class="col-md-8">
											<select readonly class="form-control" id="ccm_make_main">
											</select>
											</div>
										</div>
								</div>
								<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Model">Model <span style="color:red;">*</span></label>
											</div>
											<div class="col-md-8">
											<select readonly class="form-control" id="ccm_model_main">
											</select>
											</div>
										</div>
								</div>
								<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="AssetSubType">Asset Sub Type <span style="color:red;">*</span></label>
											</div>
											<div class="col-md-8">
											<select readonly class="form-control" name="ccm_sub_asset_type_id" id="ccm_asset_type_id_main">
											</select>
											</div>
										</div>
								</div>
						</div> <!-- row end -->	
				<div class="row" style="margin-bottom:10px">	
							<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="InternalDimensions">Dimensions (Feet)<span style="color:red;">*</span> <small class="text-success"> (Length x Width x Height)</small></label>
											</div>
											<div class="col-md-8">
													<div class="row">
													<div class="col-md-4">
														<input type="text" class="form-control" id=	"asset_dimension_length_main" name="Capacity" readonly placeholder="Length" title="Length" style="cursor:pointer">
													</div>
													<div class="col-md-4">
														<input type="text" class="form-control" id="asset_dimension_width_main" name="Capacity" readonly placeholder="Width" title="Width" style="cursor:pointer">
													</div>
													<div class="col-md-4">
														<input type="text" class="form-control" id="asset_dimension_height_main" name="Capacity" readonly placeholder="Height" title="Height" style="cursor:pointer">
													</div>
												</div>
											</div>
										</div>
							</div>
							<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Capacity">Internal gross volume (m3)</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="gross_capacity"; id="gross_capacity_20_main" readonly class="form-control">
											</div>
										</div>
							</div>
							<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Capacity">Net storage volume for vaccine/packs (m3)</label>
											</div>
											<div class="col-md-8">
											<input type="text" name="net_capacity"; id="net_capacity_20_main" readonly class="form-control">
											</div>
										</div>
							</div>
					</div>
					<!-- row end-->
				</div> <!-- modal view end-->	
				<div class="row">
						<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Year">Year of Supply </label>
											</div>
											<div class="col-md-8">
												<input type="text" id="working_since" name="working_since" class="dpcct form-control" readonly="true"/>
											</div>
										</div>
						</div>
						<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="System">Number of cooling system</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="cooling_system" class="form-control" onkeypress="return isNumberKey(event);">
											</div>
										</div>
						</div>
						<div class="col-md-4">
										<div class="row">
											<div class="col-md-4">
												<label for="Backup">Has working backup generator <span style="color:red">*</span></label>
											</div>
											<div class="col-md-8">
													<select class="form-control" name="backup_generator" required>
												<?php echo getBackupGenerator(); ?>
													</select>
											</div>
										</div>
						</div>
						
				</div><!-- row -->
				<div class="row">
						<div class="col-md-4">
									<div class="row">
											<div class="col-md-4">
												<label>Temperature recording system </label>
											</div>
											<div class="col-md-8">
												<select class="form-control" name="temperature_recording_system" required>
												<?php echo getTemperatureRecordingSystem();?>
												</select>
											</div>
									</div>
						</div>
						<div class="col-md-4">
									<div class="row">
											<div class="col-md-4">
											<label for="Serial Number">Serial Number</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="serial_no" class="form-control">
											</div>
									</div>
						</div>
				</div><!--- row --->
				<!-- Store Section -->
					<?php $this -> load -> view('coldchain/add_forms/storesSection') ;?>
						<div class="row" style="margin-bottom:10px">	
						<div class="col-md-4">
								<div class="row">
											<div class="col-md-4">
												<label for="Stabilizer">Has Voltage Stabilizer</label>
											</div>
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-2">
													<label class="radio-inline">
														<input type="radio" value="1" name="has_voltage">Yes 
													</label>
												</div>
												<div class="col-md-2">
													<label class="radio-inline">
														<input type="radio" value="0" name="has_voltage" checked="checked">No 
													</label>
												</div>
											</div>
										</div>
									</div>
						</div>	
					</div><!-- row end-->
						<!--<div class="row" style="margin-bottom:10px">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary btn-md" style="background:#008d4c none repeat scroll 0% 0%; float: right;"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
						</div>
					</div>-->
					<div class="text-right">	
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div><!--- row --->
					</div>
					<!--- row --->						
					</div><!-- inside-page end-->
		</form>
	</div> <!-- panel body-->
</div><!-- panel primary-->
			<!-- Modal-->
		
			<div class="modal fade" id="myModal" role="dialog" style="display: none;">
				<div class="modal-dialog">
					<!-- Modal content-->
					<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
							<div class="modal-content">
								<div class="modal-header" height="35px" style="border-left: 30px solid #035003;">
									<h4 class="modal-title-transfer">Suggest new make and model</h4>
								</div>
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
									<div class="col-md-4"><input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass internaldimension" placeholder="Length"  type="text">      </div>                              
									<div class="col-md-4"><input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass internaldimension" placeholder="Width"  type="text">   </div>                                 
									<div class="col-md-4"><input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass internaldimension" placeholder="Height"  type="text"></div>                                
								</div>	
			
								<div class="row">			
											<div class="col-md-6">
												
													<label for="Model">Internal gross volume (m3)<span style="color:red;">*</span></label>
													<input type="text" id="gross_capacity" name="gross_capacity" class="form-control" placeholder="Gross Capacity" readonly>
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
													<input type="text" id="net_capacity" class="form-control" name="net_capacity" placeholder="Net Capacity" readonly>
													
												
											</div>
											<div class="col-md-6">
												<label class="control-label" for="product_price">Product Price <span class="hide1"="hide2" style="color:red; visibility:hidden;">*</span></label>
													<div class="controls ">     
														<input name="product_price" id="product_price" value="" class="form-control" type="text">                                
													</div>
											</div>	
										</div>
								
									<hr />
								<div class="row text-right">
									<div class="col-md-5 col-md-offset-7">
										<button id="btn-modalForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
											<button type="Button" class="btn-background box1" id="cancel" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
									</div>
								</div>
						
										</div>
									</div>
								
						</form>
				</div>
			</div>
		<!-- Modal-->
		  <!-------- Demo -------->	
		
<script type="text/javascript">
 var res=null;
$(document).on('change','#status_w',function(){
	var id=$(this).val();
	if(id==3){
		$("#res_hid").show();
		$('#reasons').attr('required',true);
	}else{
		$("#res_hid").hide();
		$('#reasons').attr('required',false);
	}
});
$(document).on('change','#make_name', function(){
	var id = $(this).val();
	if(id !='') {
	  $.ajax({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Ajax_calls/getModelsColdroom",
			success: function(result){
				var result= JSON.parse(result);
				$('#model_name').html(result);
			}
		});
	}else{
		 $("#model_name").html('<option value="">Select First Make</option>');
	}
							
});
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
/* function checkCatalogue_id(catalogue_id)
{
	var asset_type_id=$('#asset_type_id').val();
	 $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/checkCatalogue_id",
        data:{"catalogue_id":catalogue_id,"assetid":asset_type_id},
        success: function(response) {
        //  alert(response);
			res=response;
        },
        error: function() {
            alert('Error');
        }
		
    });
	
} */
$('#btn-modalForm-submit').on('click', function(e) {
	e.preventDefault();
	var catalogue_id=$('#catalogue_id_popup').val();
	var ccm_make=$('#ccm_make_popup').val();
	var ccm_model=$('#ccm_model_popup').val();
	var catalogue_id_main="";
	catalogue_id_main=catalogue_id+"-"+ccm_make+"-"+ccm_model;
	//checkCatalogue_id(catalogue_id_main);
	  $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/coldroomModalSave",
        data: $('form.modalForm').serialize(),
        success: function(response) {
            if(response=='required'){
				alert("Please Fill Required Fields!");
			}else{
				$('#catalogue_id_main').html(response);
				$( "#cancel" ).click();
			}
        },
        error: function() {
            alert('Error');
        }
    });  
});
$(document).on('change','#catalogue_id_main', function(){
	var id=$(this).val();
	var mainId=$('#assets').val();
	if(id!=""){
		//$("#modelHide").toggle('slow');
		$.ajax({
			type: "POST",
			data: "id="+id+"&mainId="+mainId,
			url: "<?php echo base_url(); ?>Ajax_calls/getmodelData",
			success: function(result){
				var result= JSON.parse(result);
				$("#ccm_model_main").html("<option>"+result.allData.model_name+"</option>");
				$("#ccm_make_main").html("<option>"+result.allData.make_name+"</option>");
				$("#ccm_asset_type_id_main").html("<option value="+result.allData.ccm_sub_asset_type_id+">"+result.allData.asset_sub_type_name+"</option>");
				$(".radiopop").html(result.cfc_free);
				$('#asset_dimension_length_main').val(result.allData.internal_dimension_length);
				$('#asset_dimension_width_main').val(result.allData.internal_dimension_width);
				$('#asset_dimension_height_main').val(result.allData.internal_dimension_height);
				
				$('#gross_capacity_20_main').val(result.allData.gross_capacity_20);
				$('#net_capacity_20_main').val(result.allData.net_capacity_20);
				$("#modelHide").slideDown(600);
			}
		});
		
	}else{
		$("#modelHide").slideUp(600);
		//$("#modelHide").toggle('slow');
	}
});
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/coldroom_list/21";
	window.location.href=url;
});	
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}
/* $(document).on('click','#makemodel',function(){
	var url="<?php echo base_url() ?>Coldchain-MakeModel";
	window.open(url,'name');
}); */
</script>