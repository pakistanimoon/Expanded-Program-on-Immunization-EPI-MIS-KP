
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

  <div class="panel-heading">New/Add Refrigerator/Freezer/ILR Asset</div>
	<div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/main_refrigeratorSave" onsubmit="return checkRequired();" method="post" enctype="multipart/form-data">
			<!--<div class="add_refrigerator inside-page"> -->
			<?php $this -> load -> view('coldchain/add_forms/storesSection') ;?>
			<?php   echo ((isset($commonSections))?$commonSections:""); ?>
			<div class="row" style="margin-bottom:10px">
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-4">
									<label for="Temperature">Temperature Monitor <span style="color:red;">*</span> </label>
								</div>
								<div class="col-md-8">
								<select class="form-control" name="ccm_temperature">
								<?php echo getTemperatureMonitor(); ?>
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
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-4">
									<label for="Working Since (Year)">Has Voltage Regulator</label>
								</div>
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-2">
											<label class="radio-inline">
												<input type="radio" value="1" name="ccm_voltage">Yes 
											</label>
										</div>
										<div class="col-md-2">
											<label class="radio-inline">
												<input type="radio" value="0" name="ccm_voltage" checked>No 
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<!--<div class="col-md-4">
							<div class="row">
								<div class="col-md-4">
									<label for="Working Since (Year)">Working Since (Year)</label>
								</div>
								<div class="col-md-8">
									<input type="text" id="working_since" name="working_since" class="dpcct form-control" readonly="true" >
								</div>
							</div>
						</div>-->
				</div>
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
						<!--<div class="col-md-4">
							<div class="row">
								<div class="col-md-4">
									<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" style="position:relative"> <i class="fa fa-plus"></i> Add</button>
								</div>
									
							</div>
						</div>-->
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
										<label for="CFC">CFC Free Sticker<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<div class="row radiopop" style="position:relative; top:6px;">
										</div>
									</div>
								</div>
							</div>
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
										<label for="Capacity">Capacity (Liters)</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-3">
												<input type="text" id="gross_capacity_4_main" readonly class="form-control">
											</div>
											<div class="col-md-3">
												<input type="text" id="gross_capacity_20_main" readonly class="form-control">
											</div>
											<div class="col-md-3">
												<input type="text" id="net_capacity_4_main" readonly class="form-control">
											</div>
											<div class="col-md-3">
												<input type="text" id="net_capacity_20_main" readonly class="form-control">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<!-- row end-->
					</div> <!-- modal view end-->	
					<!-- Store Section -->
					
					<!--<div class="row" style="margin-bottom:10px">	
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-4">
									<label for="Working Since (Year)">Has Voltage Regulator</label>
								</div>
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-2">
											<label class="radio-inline">
												<input type="radio" value="1" name="ccm_voltage">Yes 
											</label>
										</div>
										<div class="col-md-2">
											<label class="radio-inline">
												<input type="radio" value="0" name="ccm_voltage" checked>No 
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>--->
					<!-- row end-->
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
				<!--</div>--><!-- inside-page end-->
		</form>
	</div> <!-- panel body-->
<!--</div><!-- panel primary-->
		
<!-- Modal-->
		
	<div class="modal fade in" id="myModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content cst-modal">
						<div class="modal-header">
							<h4 class="modal-title-transfer">Suggest new make and model</h4>
						</div>
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
										<label class="control-label" for="dimensions">Dimensions Inches<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
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
													<?php echo getPowerSource(NULL,FALSE,1); ?>
											</select>                                
										</div>
									</div>
								</div>
								<!------------------------>
								<!-- <div class="row" style="margin-top:10px;">
								<div class="col-md-6 col-md-offset-6">
									<button id="btn-modalForm-submit" type="Button" class="btn-background box1 pull-right" > <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
									<button type="Button" class="btn-background box1 pull-right" id="cancel" data-dismiss="modal" style="margin-right:10px;"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
								</div>
								</div> -->
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
</div>
<!-- panel primary-->
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
				$('#asset_dimension_length_main').val(result.allData.asset_dimension_length);
				$('#asset_dimension_width_main').val(result.allData.asset_dimension_width);
				$('#asset_dimension_height_main').val(result.allData.asset_dimension_height);
				
				$('#gross_capacity_4_main').val(result.allData.gross_capacity_4);
				$('#gross_capacity_20_main').val(result.allData.gross_capacity_20);
				$('#net_capacity_4_main').val(result.allData.net_capacity_4);
				$('#net_capacity_20_main').val(result.allData.net_capacity_20);
				$("#modelHide").slideDown(600);
			}
		});
		
	}else{
		$("#modelHide").slideUp(600);
		//$("#modelHide").toggle('slow');
	}
});
///////////js for modal///////
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
	return res;
	
} */
$('#btn-modalForm-submit').on('click', function(e) {
	e.preventDefault();
	//check catalogue_id
	var catalogue_id=$('#catalogue_id_popup').val();
	var ccm_make=$('#ccm_make_popup').val();
	var ccm_model=$('#ccm_model_popup').val();
	var catalogue_id_main="";
	catalogue_id_main=catalogue_id+"-"+ccm_make+"-"+ccm_model;
	//checkCatalogue_id(catalogue_id_main);
//	if(res=="0"){
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/refrigeratorModalSave",
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
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
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
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Capacity must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	}
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/refrigerator_list/1";
	window.location.href=url;
});	
</script>