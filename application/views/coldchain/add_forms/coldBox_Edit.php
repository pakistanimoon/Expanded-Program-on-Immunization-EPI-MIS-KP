<style>
	<!--                       */
 /*                      */
  /*Custom Css for Model*/
   /*                  */
    /*                */
-->

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
  <div class="panel-heading">Edit Cold Box</div>
	<div class="panel-body">
				<!-- main form start-->
				<div class="row add_refrigerator inside-page">
					<div class="col-md-12">
						<form method="post" action="<?php echo base_url() ?>Coldchain/coldBoxUpdate" onsubmit="return checkRequired();" enctype="multipart/form-data">
						
						<input type="hidden" name="asset_id" value="<?php echo $assetid; ?>" class="form-control" />
						<!--<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="Date"> Date <span style="color:red;">*</span></label>
									<input type="date" id="date" class="form-control" />
								</div>
							</div>
						</div>-->
						<?php //$this -> load -> view('coldchain/add_forms/storesSection') ?>
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
									<label for="CatalogueID">Catalog ID<span style="color:red;">*</span></label>
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
							<!--<div class="col-md-1"> 
								<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" style="margin-top: 23px;float:right"> <i class="fa fa-plus"></i> </button>
							</div>-->
							<div class="col-md-4">
								<div class="form-group">
									<label for="total"><span>Total Available For Vaccination Activities</span><span style="color:red;">*</span></label>
									<input type="text" id="quantity" name="quantity" value="<?php echo $data['quantity'];?>" class="form-control numberclass" required>
								</div>
							</div>
							<div class="col-md-4">
							<div class="form-group">
								<label for="Working Since (Year)">Working Since (Year)</label>
								<!--<input type="text" id="working_since" name="working_since" class="dpcct form-control">-->
								<input type="text" value="<?php echo $data['working_since'];?>" name="working_since" class="dpcct form-control date readonly" required />
							</div>
							</div>
						</div>
						<div class="row visibility" style="display: none;">
							<div class="col-md-4">
								<div class="form-group">
									<label for="make">Make<span style="color:red;">*</span></label>
									<select id="ccm_make_main" class="form-control" readonly>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="Model">Model<span style="color:red;">*</span></label>
									<select id="ccm_model_main" class="form-control" readonly>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="InternalDimensions">Internal Dimensions<span style="color:red;">*</span> <small class="text-success"> (Length x Width x Height)</small></label>
									<div class="row">
										<div class="col-md-4">
											<input type="text" class="form-control" id="internal_dimension_length_main" name="Capacity" readonly placeholder="Length" title="Length" style="cursor:pointer">
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="internal_dimension_width_main" name="Capacity" readonly placeholder="Width" title="Width" style="cursor:pointer">
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="internal_dimension_height_main" name="Capacity" readonly placeholder="Height" title="Height" style="cursor:pointer">
										</div>
									</div>
									
								</div>
							</div>
						</div><!--- row --->
					<div class="text-right">	
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:green;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div><!--- row --->
					</div>	
						</form>	
					</div><!-- col-md-12 -->
				</div><!--- row --->
				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog" style="display: none;">
					<div class="modal-dialog">
					<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content cst-modal">
						<div class="modal-header" height="35px">
							<h4 class="modal-title-transfer">Suggest new make and model</h4>
						</div>
						<div class="modal-body">
							<div class="row">
							<div class="col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Catalogue ID <span style="color:red;">*</span></label>
										<input type="text" name="catalogue_id" id="catalogue_id_popup" class="form-control" />
										<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
										<input type="hidden" id="sub_asset_type_id" name="ccm_sub_asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Make <span style="color:red;">*</span></label>
										<input type="text" name="make_name" id="ccm_make_popup" class="form-control" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Model<span style="color:red;">*</span></label>
										<input type="text" name="model_name" id="ccm_model_popup" class="form-control" />
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
									<div class="col-md-4 ">	<input name="internal_dimension_length_popup" id="internal_dimension_length" value="" class="form-control numberclass internaldimension" placeholder="Length"  type="text">          </div>                          
									<div class="col-md-4">	<input name="internal_dimension_width_popup" id="internal_dimension_width" value="" class="form-control numberclass internaldimension" placeholder="Width"  type="text">  </div>                                  
									<div class="col-md-4">	<input name="internal_dimension_height_popup" id="internal_dimension_height" value="" class="form-control numberclass internaldimension" placeholder="Height"  type="text">    </div>                              
								</div>
								
								
								<div class="row radio-row">
									<div class="col-md-12">
										<label class="control-label" for="Dimensions">Dimensions(Storage)<span class="hide1" style="color:red; visibility:hidden;">*</span><small class="text-success"> (Length x Width x Height)</small></label>
									</div>
								</div>	
								<br>
								<div class="form-group row">
									<div class="col-md-4">	<input name="storage_dimension_length_popup" id="storage_dimension_length" value="" class="form-control numberclass storagedimension" placeholder="Length"  type="text">          </div>                          
									<div class="col-md-4">	<input name="storage_dimension_width_popup" id="storage_dimension_width" value="" class="form-control numberclass storagedimension" placeholder="Width"  type="text">  </div>                                  
									<div class="col-md-4">	<input name="storage_dimension_height_popup" id="storage_dimension_height" value="" class="form-control numberclass storagedimension" placeholder="Height"  type="text">    </div>                              
								</div>			
								
								
							<!-- -->	
							
						<hr/>
								<div class="row">
								<div class="col-md-6 col-md-offset-6 text-right">
									<button id="btn-modalForm-submit" type="Button" class="btn-background box1" > <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
									<button type="Button" class="btn-background box1" id="cancel" data-dismiss="modal" style="margin-right:10px;"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
								</div>
								</div>
						</div>
					</div>
				   </div>
				</form>
				</div>
			</div>
				<!-- Modal end-->
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
				$('#internal_dimension_length_main').val(result.allData.internal_dimension_length);
				$('#internal_dimension_width_main').val(result.allData.internal_dimension_width);
				$('#internal_dimension_height_main').val(result.allData.internal_dimension_height);
				$(".visibility").slideDown(600);
			}
		});
		
	}else{
		$(".visibility").slideUp(600);
	}
});
$('#btn-modalForm-submit').on('click', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/coldboxSave/TRUE",
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
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Dimension must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
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
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Internal Dimension Must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
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
           $("#btn-modalForm-submit").prop('disabled', false);
		}
		else
		{
			alert("Storage Dimension must be greater than zero.");
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
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/coldbox_list/33";
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