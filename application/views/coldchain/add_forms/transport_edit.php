	<?php //print_r($data);?>

	<div class="panel panel-primary">

	  <div class="panel-heading">Edit Transport Asset</div>

		<div class="panel-body">

			<form method="post" action="<?php echo base_url() ?>Coldchain/transportUpdate" onsubmit="return checkRequired();" enctype="multipart/form-data">

				<div class="row add_refrigerator inside-page">

					<div class="col-md-12">

					

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

		<!--END --> <!--

						<div class="row">

							<div class="col-md-4">

								<div class="form-group">

									<label for="Transport Type"> 	Transport Type 	<span style="color:red;">*</span></label>

									<select  class="form-control" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id" >

										<option value="">--Select--</option>

										<?php

											foreach($assets_sub_types as $values){ ?>

												<option  value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>

										<?php } ?>

									</select>

								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">

									<label for="Registration">Registration No. <span style="color:red;">*</span></label>

									<input type="text" id="registration_no" name="registration_no" class="form-control">

								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">

									<label for="Make">Make<span style="color:red;">*</span></label>

									<select class="form-control" name="make_name" id="make_name" required>

											<option value="">--select--</option>

										<?php  foreach($makedata as $values){ ?>

											<option value="<?php echo $values['pk_id']; ?>"><?php echo $values['make_name']; ?></option>

										<?php }

										?>

									</select>

								</div>

							</div>

							

						</div>--><!--- row --->

					<!-- 	<div class="row">

						<div class="col-md-4">

								<div class="form-group">

									<label for="Model">Model<span style="color:red;">*</span></label>

									<select class="form-control" name="modelID" id="model_name" required>

										<option>Select Make First</option>

									</select>

								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">

									<label for="year">Manufacture Year <span style="color:red;">*</span></label>

									<input type="date" id="manufacturer_year" name="manufacturer_year" class="form-control">

								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group">

									<label for="Fuel Type">Fuel Type<span style="color:red;">*</span></label>

									<select  class="form-control" name="fuel_type_id">

										<?php echo getPowerSource(); ?>

									</select>

								</div>

							</div>

							<div class="col-md-4">

								<div class="form-group" style="display:none" id="visibility">

									<label for="Capacity">Capacity<span style="color:red;">*</span></label>

									<input type="text" class="form-control" id="used_for_epi" name="used_for_epi">

								</div>

							</div>

						</div> --><!--- row --->

						<!--- row --->

						<div class="row">

								<div class="col-md-4">

								<div class="form-group">

									<label for="id_code">Equipment Code <span style="color:red;">*</span></label>

									<input type="text" id="id_code" name="ccm_user_asset_id" class="form-control" value="<?php echo $data['asset_id'];?>" required>

									<input type="hidden" id="asset_id" name="asset_id" class="form-control" value="<?php echo $assetid;?>" required>

								</div>

							</div>

							<div class="col-md-4">

							<div class="form-group">

								<label for="SourceOfSupply">Source of Supply <span style="color:red;">*</span></label>

								<select class="form-control" name="source_id" required>

									<?php echo getSourceSupply($data['source_id']); ?>

								</select>

							</div>

							</div>

						

						</div>

						<div class="row">

		 <div class="col-md-4">

							<div class="form-group">

								<label for="Working Since (Year)">Supply Year <span style="color:red;">*</span></label>

								<input type="text" value="<?php echo $data['working_since'];?>" name="working_since" class="dpcct form-control date readonly" required />

							</div>

						</div>

			 <div class="col-md-4">

							<div class="form-group">

								<label for="System">Registration No.</label> 

								<input type="text" id="registration_no" name="registration_no" class="form-control" value="<?php echo $data['registration_no'];?>" required>

							</div>

						</div>		

              <div class="col-md-4">

							<div class="form-group">

								<label for="System">Engine No. </label> 

								<input type="text" id="engine_no" name="engine_no" class="form-control" value="<?php echo $data['engine_no'];?>" required>

							</div>

						</div>							

		</div>

		<div  class="row" style="margin-bottom:10px;">

					<div class="col-md-4">

								<div class="form-group">

										<label for="Transport Type">Transport Type <span style="color:red;">*</span></label>

									

									<select class="form-control" onchange="myFunction(this)" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id">

										<option value="">--Select--</option>

										<?php

											foreach($assets_sub_types as $values){ ?>

												<option value="<?php echo $values['pk_id'] ?>" <?php echo ($values['pk_id']== $data['ccm_sub_asset_type_id']) ? 'selected' : ''; ?>><?php echo $values['asset_type_name'] ?></option>

										<?php } ?>

									</select>

								</div>

						</div>

					  <div class="col-md-4">

						 <div class="row">

							<div class="col-sm-10">

								<div class="form-group">

									<label for="Make">Make <span style="color:red;">*</span></label>

										<select class="form-control" onchange="myFunctionmake(this)" name="make_name" id="make_name" required >

											<?php if(isset($dataModel) && $dataModel!='') {

											foreach($dataModel as $value){ ?>

											<option value="<?php echo $value['ccm_make_id']; ?>"  <?php echo ($value['ccm_make_id']== $data['ccm_make_id']) ? 'selected' : ''; ?>><?php echo $value['make_name']; ?></option>

											 

										<?php } 

										}?>

										

									</select>

								</div>

							</div>

							<!--<div class="col-sm-2">

							<button type="button" style="margin-top:23px; position:relative; right:10px;" id='modalid' class="btn btn-success btn-md" title="Add Make and Modal"> <i class="fa fa-plus"></i> </button>

							</div>-->

						 </div>

						</div>

						

							<div class="col-md-4">

						 <div class="row">

							<div class="col-sm-10">

								<div class="form-group">

									<label for="Model">Model <span style="color:red;">*</span></label>

										<select class="form-control" name="ccm_model_id" id="model_name" required >

										<?php if(isset($dataModel) && $dataModel!='') {

											foreach($dataModel as $value){ ?>

											<option value="<?php echo $value['pk_id']; ?>" <?php echo ($value['pk_id']== $data['ccm_model_id']) ? 'selected' : ''; ?>><?php echo $value['model_name']; ?></option>

										<?php } 

										}?>

									</select>

								</div>

							</div>

							<!--<div class="col-sm-2">

							<button type="button" style="margin-top:23px; position:relative; right:10px;" id='modalid1' class="btn btn-success btn-md" title="Add Modal"> <i class="fa fa-plus"></i> </button>

							</div>-->

						 </div> 

						</div>			

		</div>

		<div class="row">

		      <div class="col-md-4">

							<div class="form-group">

								<label for="Chases No. ">Chases No. r <span style="color:red;">*</span></label>

								<input type="text" value="<?php echo $data['chases_no'];?>" name="chases_no" class="form-control" required>

							</div>

						</div>

						<div class="col-md-4">

							<div class="form-group">

								<label for="Fuel Type">Fuel Type</label> 

								<select  class="form-control" name="fuel_type_id">

								 <?php echo getPowerSource($data['fuel_type_id'],FALSE,25); ?>

									</select>	

							</div>

						</div>	

						<div class="col-md-4">

							<div class="form-group">

								<label for="Comments">Comments</label> 

								<input type="text" id="comments" name="comments" class="form-control" value="<?php echo $data['comments'];?>" required>

							</div>

						</div>	

		

		</div>

		<div class="row">

		<div class="col-md-4">

							<div class="form-group" style="display:none" id="visibility">

								<label for="Capacity">Capacity</label> 

								<input type="text" class="form-control numberclass"  value="<?php echo $data['used_for_epi'];?>" id="used_for_epi" name="used_for_epi" />

							</div>

						</div>	

		</div>

		

		

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

		</div>

		

		<!-- Modal-->

		

	<div class="modal fade in" id="myModal" role="dialog" style="display: none;">

		<div class="modal-dialog">

			<!-- Modal content-->

			<form class="modalForm" id="tag-form-make" action="" method="post" enctype="multipart/form-data">

					<div class="modal-content cst-modal">

						<div class="modal-header">

							<h4 class="modal-title-transfer">Suggest new Make And Model</h4>

						</div>

						<div class="modal-body">

						    <div class="row">

                               <div class="col-md-3">

							   <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $assets_sub_types[0]['parent_id']; ?>" />

		                        <label for="Store">Asset Type<span style="color:red;">*</span></label>

		                       </div>

		                        <div class="col-md-3">

		                          <span>Transport</span>

		                        </div>

		 

	                          <div class="col-md-3">

							  <input type="hidden" id="subid" name="subid" value="<?php echo $data['ccm_sub_asset_type_id']; ?>"/>

		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>

		                      </div>

		                      <div class="col-md-3">

		                        <span id="val" ><?php echo $data['asset_name']; ?></span>

		                      </div>

	                        </div>

							<div class="row" style="margin-top:15px;">

								<div class="col-md-2">

								  <label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>

								</div>

		                        <div class="col-md-10">

								 <input name="make_name" id="makename" value="" class="form-control" type="text" required="">                                

							    </div>

							</div>

							<div class="row" style="margin-top:10px;">	

							     <div class="col-md-2">

									<label class="control-label" for="catalogueid">Model <span style="color:red;">*</span></label>

								</div>

		                        <div class="col-md-10">

									   <input name="model_name" id="ccm_model_popup" value="" class="form-control" type="text" required="">                                

								</div>

							</div>

									

						</div>

								<hr />

								<div class="row text-right" style="margin-right:0px; margin-left:0px;">

									<div class="col-md-12">

										<button id="btn-makeForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>

											<button type="Button" class="btn-background box1" id="cancel1" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>

									</div>

								</div>

							</div>

				</form>

		</div>

	</div>

<!-- Modal-->

<!-- Modal-->

		

	<div class="modal fade in" id="myModal1" role="dialog" style="display: none;">

		<div class="modal-dialog">

			<!-- Modal content-->

			<form class="modalForm" id="tag-form-model" action="" method="post" enctype="multipart/form-data">

					<div class="modal-content cst-modal">

						<div class="modal-header">

							<h4 class="modal-title-transfer">Suggest new Model</h4>

						</div>

						<div class="modal-body">

						    <div class="row">

                               <div class="col-md-3">

							   <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $assets_sub_types[0]['parent_id']; ?>" />

		                        <label for="Store">Asset Type<span style="color:red;">*</span></label>

		                       </div>

		                        <div class="col-md-3">

		                          <span>Transport</span>

		                        </div>

		 

	                          <div class="col-md-3">

							  <input type="hidden" id="subid1" name="subid1" value="<?php echo $data['ccm_sub_asset_type_id']; ?>"/>

		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>

		                      </div>

		                      <div class="col-md-3">

		                        <span id="val1"><?php echo $data['asset_name']; ?></span>

		                      </div>

	                        </div>

							<div class="row">

								<div class="col-md-3">

								<input type="hidden" id="make" name="make" value="<?php echo $data['ccm_make_id']; ?>"/>

								  <label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>

								</div>

		                        <div class="col-md-3">

								    <span id="makeval"><?php echo $data['make_name']; ?></span>                            

							    </div>

							    <div class="col-md-3">

									<label class="control-label" for="catalogueid">Model <span style="color:red;">*</span></label>

								</div>

		                        <div class="col-md-3">

									   <input name="model_name" id="ccm_model_popup" value="" class="form-control" type="text" required="">                                

								</div>

							</div>

									

						</div>

								<hr />

								<div class="row text-right" style="margin-right:14px; margin-left:0px;">

									<div class="row text-right" style="margin-right:0px; margin-left:0px;">

										<button id="btn-modalForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>

											<button type="Button" class="btn-background box1" id="cancel2" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>

									</div>

								</div>

							</div>

				</form>

		</div>

	</div>

<!-- Modal-->

		

		

	</div>

<script type="text/javascript">



flag=0;

fac_code='<?php echo isset($data['facode'])?$data['facode']:"null";?>';

un_code='<?php echo isset($data['uncode'])?$data['uncode']:"null";?>';



$(document).on('change','#ccm_sub_asset_type_id',function(){

	var id=$(this).val();

	if(id==30){

		$("#visibility").show();

		$('#used_for_epi').attr('required',true);

	}else{

		$("#visibility").hide();

		$('#used_for_epi').attr('required',false);

	}

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

$(document).on('click','#makemodel',function(){

	var url="<?php echo base_url() ?>Coldchain-MakeModel";

	window.open(url,'name');

});

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

	var url="<?php echo base_url();?>Coldchain/Add-assets/25";

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



//new code//

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

				$("#model_name").val($("#model_name option:last").val());

			}

		});

	}else{

		 $("#model_name").html('<option value="">--select--</option>'); //Select First Make

	}

							

});

$(document).on('change','#ccm_sub_asset_type_id', function(){

	var id = $(this).val();

	if(id !='') {

	  $.ajax({

			type: "POST",

			data: "id="+id,

			url: "<?php echo base_url(); ?>Ajax_calls/getTransportColdroom",

			success: function(result){

				var result= JSON.parse(result);

				$('#make_name').html(result);

				$("#make_name").val($("#make_name option:last").val());

				$('#make_name').trigger('change');

				//alert();

				//$("#model_name").val($("#model_name option:last").val());

			}

		});

	}else{

		 $("#make_name").html('<option value="">--select--</option>');//Select First Transport Type

	}

							

});

/* $(document).on('change','#ccm_sub_asset_type_id', function(){

	var id = $(this).val();

	//alert(id);

	

							

}); */



function myFunction(selectObject) {

        var x = selectObject.value;

		$("#subid").val(x);

		$("#subid1").val(x);

		var val=$("#ccm_sub_asset_type_id option:selected").text();

        document.getElementById("val").innerHTML = "" + val;

        document.getElementById("val1").innerHTML = "" + val;

		

}



$('#btn-makeForm-submit').on('click', function(e) {

	e.preventDefault();

	var x = document.forms["tag-form-make"]["make_name"].value;

	if (x !='') {

		$.ajax({

			type: "POST",

			async:false,

			url: "<?php echo base_url();?>Coldchain/addmake",

			data: $('#tag-form-make').serialize(),

			success: function(response) {

				//$('#make_name').html(response);

				$('#ccm_sub_asset_type_id').trigger('change');

				alert('Successfully Add Make and Modal');

				/* $("#make_name").val($("#make_name option:last").val());

				$('#make_name').trigger('change');

				//alert();

				$("#model_name").val($("#model_name option:last").val()); */

				$( "#cancel1" ).click();

				//$('#myModal').modal('hide');

			}

		});

  }else{

	  alert("Make and Model must be filled out");

  }

});



function myFunctionmake(selectObject) {

        var a = selectObject.value;

		$("#make").val(a);

		var make=$("#make_name option:selected").text();

        document.getElementById("makeval").innerHTML = "" + make;

		

}

$('#btn-modalForm-submit').on('click', function(e) {

	e.preventDefault();

	var x = document.forms["tag-form-model"]["model_name"].value;

	if (x !='') {

		$.ajax({

			type: "POST",

			async:false,

			url: "<?php echo base_url();?>Coldchain/addmodal",

			data: $('#tag-form-model').serialize(),

			success: function(response) {

				$('#model_name').html(response);

				alert('Successfully Add Modal');

				$( "#cancel2" ).click();

				$('#model_name option:last-child').attr('selected', 'selected');

			}

		});

		  }else{

	  alert("Model must be filled out");

  }

});

$(document).on('click','#makemodel',function(){

	var url="<?php echo base_url() ?>Coldchain-MakeModel";

	window.open(url,'name');

});

$('#cancel').on('click', function(e) {

	var url="<?php echo base_url();?>Coldchain/transport_list/25";

	window.location.href=url;

});



$('#modalid').click(function() {

	var a = $('#ccm_sub_asset_type_id option:selected').val();

	//alert(a); 

	if(a !="" || a > 0){

		//alert(a);

		$("#myModal").show();

	}

	else{

		//alert(a);

		alert("Select First Transport Type");

		//$('#myModal').modal().hide();

	}

   

});

  $('#cancel1').on('click', function(e) {

	$("#myModal").modal('toggle');

});	 

 $('#cancel2').on('click', function(e) {

	$("#myModal1").modal('toggle');

});

$('#modalid1').click(function() {

	var b = $('#make_name option:selected').val();

	//alert(a); 

	if(b !="" || b > 0){

		//alert(b);

		$("#myModal1").show();

	}

	else{

		//alert(b);

		alert("Select First Make Type");

		//$('#myModal1').modal().hide();

	}

   

});

$( window ).on("load", function() {

      	var x = $("#make_name").val();

		//alert(x);

		//alert(y); exit();

		$.ajax({

			type: "GET",

			async:false,

			url: "<?php echo base_url();?>Coldchain/getmodelname",

			//data: $('#make_name').serialize(),

			data: $('#make_name').serialize(),

			success: function(response) {

				$('#model_name').html(response);

				$('#model_name').val(<?php echo $data['ccm_model_id'];?>);

				//$('#model_name').append(response);

				//alert('Successfully Add Modal');

				//$( "#cancel2" ).click();

				//$("#model_name").val($("#model_name option:last").val());

				//$('#model_name option:last-child').attr('selected', 'selected');

			}

		});

}); 

$( window ).on("load", function() {

      	var y = $("#ccm_sub_asset_type_id").val();

		//alert(x);

		//alert(y); exit();

		$.ajax({

			type: "GET",

			async:false,

			url: "<?php echo base_url();?>Coldchain/getmakename",

			data: $('#ccm_sub_asset_type_id').serialize(),

			success: function(response) {

				//alert(response); exit();

				$('#make_name').html(response);

				$('#make_name').val(<?php echo $data['ccm_make_id'];?>); 

				//$('#model_name').text(<?php echo $data['ccm_model_id'];?>);

				//$('#model_name').append(response);

				//alert('Successfully Add Modal');

				//$( "#cancel2" ).click();

				//$("#model_name").val($("#model_name option:last").val());

				//$('#model_name option:last-child').attr('selected', 'selected');

			}

		});

}); 

$(".readonly").keydown(function(e){
	e.preventDefault();
});

</script>