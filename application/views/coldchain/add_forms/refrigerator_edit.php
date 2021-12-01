
<?php //print_r($data);exit;?>		
<div class="panel panel-primary">
  <div class="panel-heading">Refrigerator/Freezer/ILR Asset Edit Form</div>
	<div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/refrigeratorUpdate" onsubmit="return checkRequired();" method="post" enctype="multipart/form-data">
			<div class="row add_refrigerator inside-page">
				<div class="col-md-12">
					<?php //echo $data['catalogue_id'];?>
		<div class="row">
			
			<div class="col-md-4">
				<div class="form-group">
					<label for="id_code">Equipment Code<span style="color:red;">*</span></label>
					<input type="text" id="id_code" name="ccm_user_asset_id" class="form-control" value="<?php echo $data['asset_id'];?>" required>
					<input type="hidden" id="asset_id" name="asset_id" class="form-control" value="<?php echo $assetid;?>" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="SourceOfSupply">Source of Supply<span style="color:red;">*</span></label>
					<select class="form-control" name="source_id" required>
						<?php echo getSourceSupply($data['source_id']); ?>
					</select>
				</div>
			</div>
			
		</div>
		<!--Store Section -->
		<?php 
$style='';
$offset_transfer = '';
$lableDistrict = "District";
if(isset($offset) && $offset=='Yes'){
	$offset_transfer = 'col-xs-offset-1';
	$lableDistrict = "Districts";
}
if(isset($transfer)){ }else{ 
if(isset($offset) && $offset=='Yes'){ 
$style = "";
?>
<br>
<?php }else{ ?>

<div class="row">
	<div class="col-md-4 <?php echo $offset_transfer; ?>">
		<div class="form-group">
			<label for="Placed">Placed At <span style="color:red;">*</span></label>
		</div>
	</div>
</div>
<?php
		
		if(isset($search)){
			$checked2 = "checked='checked'";
			$checked ="";
			
		}
		else
		{
			$style = "display:none;";
			$checked = "checked='checked'";
			$checked2 ="";
		}
		$var = '<label class="radio-inline">
					<input type="radio" value="0" name="placed_at-0" class="placed_at-0" '.$checked.'>Unallocated 
				</label>';
		$var2 = '<label class="radio-inline">
					<input type="radio" value="1" name="placed_at-0" class="placed_at-0" '.$checked2.'>Select Store
				</label>'; ?>
<div class="row" style="position:relative;top:-20px;">
	<div class="col-md-3 <?php echo $offset_transfer; ?>">
		<div class="form-group">
			<?php 	if(isset($search))
						echo $var2.$var;
					else
						echo $var.$var2;?>
		</div>
	</div>
</div>
<?php } } ?>
<div class="row" id="store_hid" style="position:relative;top:-25px; <?php echo $style; ?>"  >
	<div class="col-md-4 <?php echo $offset_transfer; ?>">
		<div class="form-group">
			<label for="Store">Store <span style="color:red;">*</span></label>
			<select class="form-control" name="warehouse_type_id" id="store_id" required>
			<?php if(isset($offset) && $offset=='Yes'){ ?>
										<option value="0">Select</option>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<option value="2">Provincial</option>
									<?php }else{ ?>
										<option value="0">Select</option>
										<?php
										if($this -> session -> Tehsil){ ?>

										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php
										}else if($this -> session -> District){ ?>
										<option value="4">District</option>
										<option value="5">Tehsil-Taluka</option>
										<option value="6">Union Council</option>
										<?php } else { ?>
										  <option value="2">Provincial</option>
										<?php }?>
									<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group" style="display:none" id="dist_hid">
			<label for="District"><?php echo $lableDistrict; ?></label>
			<select class="form-control" name="distcode" id="distcodeREF">
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group" style="display:none" id="tcode_hid">
			<label for="Tehsil">Tehsil</label>
			<select class="form-control" name="tcode" id="tcodeREF" >
			</select>
		</div>
	</div>
	<div class="col-md-4 <?php echo $offset_transfer; ?>">
		<div class="form-group" style="display:none" id="uncode_hid">
			<label for="UNcouncil">UCs</label>
			<select class="form-control" name="uncode" id="uncodeREF" >
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group" style="display:none" id="facode_hid">
			<label for="UNcouncil">Facilities</label>
			<select class="form-control" name="facode" id="facode_th">
			</select>
		</div>
	</div>
</div>
		<!--END -->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="Catalogue">Catalog ID <span style="color:red;">*</span></label>
								<select class="form-control" name="ccm_model_id" id="catalogue_id_main" required>
								<option value="" >Select</option>
								<?php if(isset($dataModel) && $dataModel!='') {
											foreach($dataModel as $value){ ?>
												<option value="<?php echo $value['pk_id']; ?>"><?php echo $value['catalogue_id']; ?></option>
										<?php } 
										}?>
								</select>
							</div>
						</div>
						
						<div class="col-md-2">
							<!--<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" style="margin-top: 23px;margin-left:10px;position:relative"> <i class="fa fa-plus"></i></button>-->
						</div>
							
						</div>
					</div>
					</div>
					<div id="modelHide" style="display: none;">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Make">Make <span style="color:red;">*</span></label>
									<select readonly class="form-control" id="ccm_make_main">
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Model">Model <span style="color:red;">*</span></label>
									<select readonly class="form-control" id="ccm_model_main">
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="AssetSubType">Asset Sub Type <span style="color:red;">*</span></label>
									<select readonly class="form-control" name="ccm_sub_asset_type_id" id="ccm_asset_type_id_main">
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="CFC">CFC Free Sticker<span style="color:red;">*</span></label>
									<div class="row radiopop" style="position:relative; top:6px;">
										
									</div>
								</div>
							</div>
							<div class="col-md-4">
									<div class="form-group">
												<label for="InternalDimensions">Dimensions (Feet)<span style="color:red;">*</span> <small class="text-success"> (Length x Width x Height)</small></label>
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
							<div class="col-md-4">
								<div class="form-group">
									<label for="Capacity">Capacity (Liters)</label>
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
						</div><!--- row --->
					</div>
					<div class="row" style="margin-left:-5px;">
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="Serial Number">Serial Number</label>
								<input type="text" name="serial_no" value="<?php echo $data['serial_no'];?>"class="form-control">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="Working Since (Year)">Working Since (Year)</label>
								<input type="text" value="<?php echo $data['working_since'];?>" name="working_since" class="dpcct form-control date readonly" required />
							</div>
						</div>
						
					</div><!--- row --->
				<div class="row">	
					<div class="col-md-4">
							<!--<div class="form-group">
								
								<div class="row" style="position:relative; top:30px; margin-right:0px; margin-left:0px;">
									<div class="col-md-8">
										<label for="Working Since (Year)">Has Voltage Regulator</label>
									</div>
									<div class="col-md-2" style="position:relative;left:-18px;">
										<label class="radio-inline">
											<input type="radio" value="1" name="ccm_voltage">Yes 
										</label>
									</div>
									<div class="col-md-2" style="position:relative;left:-18px;">
										<label class="radio-inline">
											<input type="radio" value="0" name="ccm_voltage" >No 
										</label>
									</div>
								</div>
							</div>-->
							<!-- <div class="form-group">
								<label for="Working Since (Year)">Has Voltage Regulator</label>
								<div class="row">
									<div class="col-md-6">
										<label class="radio-inline">
											<input type="radio" value="1" name="ccm_voltage">Yes 
										</label>
									</div>
									<div class="col-md-6">
										<label class="radio-inline">
											<input type="radio" value="0" name="ccm_voltage" checked>No 
										</label>
									</div>
								</div>
							</div> -->
						</div>
					</div><!--- row --->	
					<div class="text-right">	
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:green;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div><!--- row --->
					</div><!--- row --->
				</div><!-- col-md-12 -->
			</div><!--- row --->
		</form>
<!-- Modal-->
		
	<div class="modal fade" id="myModal" role="dialog" style="display: none;">
		<div class="modal-dialog">
			<!-- Modal content-->
			<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header" height="35px">
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
								<div class="col-md-12 margin-bottom">
									<div class="col-md-3">
										<label class="control-label" for="dimensions">Dimensions Feet<span class="hide1" style="color:red; visibility:hidden;">*</span></label>
										<div class="form-group">
											<input name="asset_dimension_length" id="asset_dimension_length_popup" value="" class="form-control numberclass dimension" placeholder="Length" readonly="" type="text">                                    
											<input name="asset_dimension_width" id="asset_dimension_width_popup" value="" class="form-control numberclass dimension" placeholder="Width" readonly="" type="text">                                    
											<input name="asset_dimension_height" id="asset_dimension_height_popup" value="" class="form-control numberclass dimension" placeholder="Height" readonly="" type="text">                                
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label" for="capacity">Capacity Liters<span class="hide1" style="color:red; visibility:hidden;">*</span></label>
										<div class="form-group">
											<input name="gross_capacity_4" id="gross_capacity_4_popup" value="" class="form-control numberclass capacity" placeholder="Gross +2 to +8" readonly="" type="text">                                    
											<input name="gross_capacity_20" id="gross_capacity_20_popup" value="" class="form-control numberclass capacity" placeholder="Gross 15 to 20" readonly="" type="text">                                    
											<input name="net_capacity_4" id="net_capacity_4_popup" value="" class="form-control numberclass capacity" placeholder="Net +2 to +8" readonly="" type="text">                                    
											<input name="net_capacity_20" id="net_capacity_20_popup" value="" class="form-control numberclass capacity" placeholder="Net 15 to 20" readonly="" type="text">                                
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label" for="cfcfree">CFC Free Sticker </label>
										<div class="controls cfc_radio">
											<label><input name="cfc_free" id="cfc_free-2" value="2" type="radio">NA</label><label><input name="cfc_free" id="cfc_free-1" value="1" type="radio">Yes</label><label><input name="cfc_free" id="cfc_free-0" value="0" checked="checked" type="radio">No</label>                                
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label" for="cfcfree">Is PIS/PQS </label>
										<div class="controls cfc_radio">
											<label><input name="is_pqs" id="is_pis_pqs-1" value="1" type="radio">Yes</label><label><input name="is_pqs" id="is_pis_pqs-0" value="0" checked="checked" type="radio">No</label>                                
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-3">
										<label class="control-label" style="margin-top:-18px" for="refrigerator_gas_type">Refrigerator Gas Type <span class="hide1" style="color:red; visibility:hidden;">*</span></label>
										<div class="controls">
											<select name="gas_type" id="refrigerator_gas_type" class="form-control">
												<option value="" selected="selected">Select</option>
												<option value="R12">R12</option>
												<option value="R134A">R134A</option>
												<option value="R22">R22</option>
												<option value="R404a">R404a</option>
												<option value="Unknown">Unknown</option>
											</select>                                
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label" for="product_price">Product Price <span class="hide1"="hide2" style="color:red; visibility:hidden;">*</span></label>
										<div class="controls ">     
											<input name="product_price" id="product_price" value="" class="form-control numberclass" type="text">                                
										</div>
									</div>
									<div class="col-md-3">
										<label class="control-label" for="power_source">Power Source <span class="hide1"="hide3" style="color:red; visibility:hidden;">*</span></label>
										<div class="controls">
											<select name="power_source" id="power_source" class="form-control">
												<option value="" selected="selected">Select</option>
												<option value="Electricity">Electricity</option>
												<option value="Solar">Solar</option>
											</select>                                
										</div>
									</div>
								</div>
								</br>
								<div class="col-md-6" style="margin-left: 65%;">
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
</div>
<script type="text/javascript">
flag=0;
fac_code='<?php echo isset($data['facode'])?$data['facode']:"null";?>';
un_code='<?php echo isset($data['uncode'])?$data['uncode']:"null";?>';

$(window).ready(function(){
	ccm_model="<?php echo $data['ccm_model_id'];?>";
	$("#catalogue_id_main option[value="+ccm_model+"]").attr('selected', true);
	$('#catalogue_id_main').trigger("change");
});
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
$('#btn-modalForm-submit').on('click', function(e) {
	e.preventDefault();
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
    return false;
});
/** For Dimensions Greater Than Zero **/
$('.dimension').on('keyup change', checkdimension);
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
$('.capacity').on('keyup change', checkcapacity);
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

<!-- Store Section JS/JQuery -->
$(window).ready(function(){
	warehouse=<?php echo $data['warehouse_type_id'];?>;
	//tcode=<?php echo $data['tcode'];?>;
	//$("#catalogue_id_main option:contains("+text+")").attr('selected', true);
	//$('#catalogue_id_main').trigger("change");
	
	if(warehouse > 0)
	{
		//$("input[name=placed_at-0]").attr('selected', true);
		$("input[name=placed_at-0][value='1']").prop("checked",true);
		$('input[name=placed_at-0]').trigger("change");
		$('#store_id').val(warehouse);
		$('#store_id').trigger("change");
		
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
$(document).on('change','#store_id',function(){
	flag=flag+1;
	var distcode = "";
	tcode=<?php echo isset($data['tcode'])?$data['tcode']:"null";?>;
	<?php if(isset($offset) && $offset == 'Yes'){ ?>
			distcode = 0;
	<?php }else{ ?>
			distcode = '<?php echo $this->session->District; ?>';
	<?php } ?>
	var id = $(this).val();
	var storeID = $(this).val();
	if(id==4){
		$("#dist_hid").hide();
		$("#tcode_hid").hide();
		$("#uncode_hid").hide();
		$("#facode_hid").hide();
		$("#tcodeREF").text('');
		$("#uncodeREF").text('');
		$("#facode_th").text('');
	}
	if(id!=0 && id!= 2){
		//alert(distcode);
		$.ajax({
			type: "POST",
			data: { distcode: distcode },
			async:true,
			//dataType : 'json',
			url: "<?php echo base_url(); ?>Ajax_calls/getDistricts_options",
			success: function(result){
				//alert(result);
				$('#distcodeREF').html(result);
				$("#dist_hid").show();
				$('#distcodeREF').attr('required',true);
				if(id==5){
					$("#tcodeREF").text('');
					$("#uncodeREF").text('');
					$("#facode_th").text('');
					$("#tcode_hid").show();
					$("#uncode_hid").hide();
					$("#facode_hid").hide();
				}
				if(id!=4){
					$('option:selected', '#distcodeREF').removeAttr("selected");
				}else{
					$("#distcodeREF option[value='']").remove();
				}
				if(id==6){
					$("#tcodeREF").text('');
					$("#tcode_hid").show();
					$("#uncodeREF").text('');
					$("#uncode_hid").show();
					$('#tcodeREF').attr('required',true);
					$('#uncodeREF').attr('required',true);
				}else{
					$('#tcodeREF').attr('required',false);
					$('#uncodeREF').attr('required',false);
				}
				
			}
		});
		if(id==5 || id==6){
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcodeREF').html(result);
					if(storeID==5){
						$("#tcode_hid").show();
						if(flag==1){$('#tcodeREF').val(tcode);};
					}
					if(storeID==6){
						$("#tcode_hid").show();
						if(flag==1){$('#tcodeREF').val(tcode);$('#tcodeREF').trigger("change");};
						$("#uncodeREF").val('');
						$("#uncode_hid").show();
						if(flag==1){$('#uncodeREF').val(un_code);};
						
					}
				}
			});
		} 
	}else{
		$("#dist_hid").hide();
		$("#tcode_hid").hide();
		$("#uncode_hid").hide();
		$("#facode_hid").hide();
	}
	//var distcode = $('#distcodeREF').val();
	<?php if(isset($form) && $form=='AICP'){  ?>
	var i=0;
	$.ajax({
		type: "POST",
		data: { storeId: id, distcode: distcode },
		url: "<?php echo base_url(); ?>Coldchain/getICePacks",
		success: function(result){
			if(result){
			var result1 = JSON.parse(result);
			
				var j=2;
				for(var i=0;i<=result1.length; i++){
					$("#"+j+"quantity").val(result1[i]);
					$("#"+j+"quantity").attr('disabled',true);
					j++;
				}
				$('.button').hide();
			}else{
				$(".quantity").val('');
				$(".quantity").attr('disabled',false);
				$('.button').show();
			}
		}
	});
	<?php } ?>
});
$(document).on('change','#distcodeREF', function(){
	var storeID = $("#store_id").val();
	var distcode = $('#distcodeREF').val();
	$("#tcodeREF").val('');
	if(storeID==5 || storeID==6){
		if(distcode == 0) {
		  $("#tcode_hid").hide();
		  $("#uncode_hid").hide();
		  $("#facode_hid").hide();
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcodeREF').html(result);
					
					if(storeID==5){
						$("#tcode_hid").show();
						
					}
					if(storeID==6){
						$("#tcode_hid").show();
						$("#uncodeREF").val('');
						$("#uncode_hid").show();
						
						
					}
				}
			});
			<?php if(isset($form) && $form=='AICP'){  ?>
			var i=0;
			$.ajax({
				type: "POST",
				data: { storeId: storeID, distcode: distcode },
				url: "<?php echo base_url(); ?>Coldchain/getICePacks",
				success: function(result){
					if(result){
					var result1 = JSON.parse(result);
					
						var j=2;
						for(var i=0;i<=result1.length; i++){
							$("#"+j+"quantity").val(result1[i]);
							$("#"+j+"quantity").attr('disabled',true);
							j++;
						}
						$('.button').hide();
					}else{
						$(".quantity").val('');
						$(".quantity").attr('disabled',false);
						$('.button').show();
					}
				}
			});
			<?php } ?>
		}
	}							
});
$(document).on('change','#tcodeREF', function(){
	var storeID = $("#store_id").val();
	var distcode = $('#distcodeREF').val();
	var tcode = $('#tcodeREF').val();
	if(storeID==6){
		$("#facode_hid").hide();
		if(tcode!=0) {
			$.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
				success: function(result){
					$('#uncodeREF').html(result);
					if(storeID==6){
						$("#uncode_hid").show();
						if(flag==1){$('#uncodeREF').val(un_code);$('#uncodeREF').trigger("change");};
					}
				}
			});
		}else{
			$("#uncode_hid").hide();
			$("#facode_hid").hide();
		}
	}
	<?php if(isset($form) && $form=='AICP'){  ?>
	var i=0;
	$.ajax({
		type: "POST",
		data: { storeId: storeID, distcode: distcode,tcode: tcode },
		url: "<?php echo base_url(); ?>Coldchain/getICePacks",
		success: function(result){
			if(result){
				var result1 = JSON.parse(result);
				var j=2;
				for(var i=0;i<=result1.length; i++){
					$("#"+j+"quantity").val(result1[i]);
					$("#"+j+"quantity").attr('disabled',true);
					j++;
				}
				$('.button').hide();
			}else{
				$(".quantity").val('');
				$(".quantity").attr('disabled',false);
				$('.button').show();
			}
		}
	});
	<?php } ?>
});
$(document).on('change','#uncodeREF', function(){
	var storeID = $("#store_id").val();
	var uncode = $('#uncodeREF').val();
	var tcode = $('#tcodeREF').val();
	var distcode = $('#distcodeREF').val();
	if(uncode == 0) {
	  $("#facode_hid").hide();
	}else{
		$.ajax({
				type: "POST",
				data: "uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#facode_th').html(result);
					$("#facode_hid").show();
					if(flag==1){$('#facode_th').val(fac_code);};

				}
			});
		/* if($('#facode_th').val()==0){
			$("#facode_th option:first").val('');
			$('#facode_th').attr('required',true);
		}else{
			$('#facode_th').attr('required',false);
		} */
		<?php if(isset($form) && $form=='AICP'){  ?>
		var i=0;
		$.ajax({
			type: "POST",
			data: { storeId: storeID, distcode: distcode,tcode: tcode,uncode: uncode },
			url: "<?php echo base_url(); ?>Coldchain/getICePacks",
			success: function(result){
				if(result){
					var result1 = JSON.parse(result);
					var j=2;
					for(var i=0;i<=result1.length; i++){
						$("#"+j+"quantity").val(result1[i]);
						$("#"+j+"quantity").attr('disabled',true);
						j++;
					}
					$('.button').hide();
				}else{
					$(".quantity").val('');
					$(".quantity").attr('disabled',false);
					$('.button').show();
				}
			}
		});
		<?php } ?>
	}
							
});
<?php if(isset($form) && $form=='AICP'){  ?>
$(document).on('change','#facode_th', function(){
	var facode = $("#facode_th").val();
	var storeID = $("#store_id").val();
	var uncode = $('#uncodeREF').val();
	var tcode = $('#tcodeREF').val();
	var distcode = $('#distcodeREF').val();
	if(facode!=0){
		var i=0;
		$.ajax({
			type: "POST",
			data: { storeId: storeID, distcode: distcode,tcode: tcode,uncode: uncode,facode: facode},
			url: "<?php echo base_url(); ?>Coldchain/getICePacks",
			success: function(result){
				if(result){
					var result1 = JSON.parse(result);
					var j=2;
					for(var i=0;i<=result1.length; i++){
						$("#"+j+"quantity").val(result1[i]);
						$("#"+j+"quantity").attr('disabled',true);
						j++;
					}
					$('.button').hide();
				}else{
					$(".quantity").val('');
					$(".quantity").attr('disabled',false);
					$('.button').show();
				}
			}
		});
	}		
});
<?php } ?>
function checkRequired(id=false){
	var located = (id===false) ? $('input[name=placed_at-0]:checked').val() :id;
	var store_id = $('#store_id').val();
	var distcode = $('#distcodeREF').val();
	var tcode = $('#tcodeREF').val();
	var uncode = $('#uncodeREF').val();
	var facode = $('#facode_th').val();
	if(store_id !=0 && located==1)
	{
		if((store_id=='4' || store_id=='5' || store_id=='6') && distcode==''){
			alert('SORRY: Select the District!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode=="0"){
			alert('SORRY: Select the Tehsil!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode!="0" && uncode==""){
			alert('SORRY: Select the Uc!');
			return false;
		}else if((store_id=='5' || store_id=='6') && distcode!='' && tcode!="0" && uncode!="" && facode=="0"){
			alert('SORRY: Select the Facility!');
			return false;
		}else{
			return true;
		}
	}
	else
	{
		if(located == "1" && store_id ==0){
			alert('SORRY: Select the Store!');
			return false;
		}else{
			return true;
		}
	}
}
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/refrigerator_list/1";
	window.location.href=url;
});
$(function () {
	$('.dpcct').datetimepicker({
		format : 'yyyy-mm-dd',
		color: "green",
		startView : 2,
		viewDate: new Date(),
		endDate : new Date(),
		todayHighlight : true,
		todayBtn : true
	});
});
$(".readonly").keydown(function(e){
   e.preventDefault();
});
</script>