<div class="panel panel-primary">
  <div class="panel-heading">Voltage Regulator Edit</div>
	  <div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<form action="<?php echo base_url()?>/Coldchain/voltageRegulatorUpdate" method="post" onsubmit="return checkRequired();" enctype="multipart/form-data">
				<input type="hidden" id="asset_id" name="asset_id" class="form-control" value="<?php echo $assetid;?>" required>
				<input type="hidden" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id" value="23" class="form-control">
				<!--<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Date"> Date <span style="color:red;">*</span></label>
							<input type="date" id="date" name="date" class="form-control" />
						</div>
					</div>
				</div><!-- row -->
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
							<label for="Catelogue_id"> Catalog ID <span style="color:red;">*</span></label>
							<select class="form-control" id="catalogue_id_main" name="ccm_model_id" required>
								<option value="0" >--Select Asset--</option>
								<?php if(isset($dataModel) && $dataModel!='')
										{
											foreach($dataModel as $value)
											{ ?>
												<option value="<?php echo $value['pk_id']; ?>"><?php echo $value['catalogue_id']; ?></option>
									<?php	} 
										} ?>
							</select>
						</div>
					</div>
					
					<div class="col-md-1">
						<!--<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal" style="margin-top: 23px;"> <i class="fa fa-plus"></i></button>-->
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Quantity">Quantity<span style="color:red;">*</span></label>
							<input type="text" name="quantity" value="<?php echo $data['quantity'];?>" class="form-control numberclass" placeholder="" required>
						</div>
					</div>
					
				</div><!-- row -->
				<div id="modelHide" class="row" style="display: none;">
					<div class="col-md-4">
						<div class="form-group">
							<label for="Make">Make <span style="color:red;">*</span></label>
							<select class="form-control" id="ccm_make_main" readonly>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Model">Model <span style="color:red;">*</span></label>
							<select class="form-control" id="ccm_model_main" readonly>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="Working Since (Year)">Supply Year<span style="color:red;">*</span></label>
							<!--<input type="text" id="working_since" name="working_since" class="dpcct form-control">-->
							<input type="text" value="<?php echo $data['working_since'];?>" name="working_since" class="dpcct form-control date readonly" required />
						</div>
					</div>
				</div><!-- row -->
				
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
		
		<!-- Modal content-->
		<div class="modal fade" id="myModal" role="dialog" style="display: none;">
			<div class="modal-dialog">
				<form class="modalForm" id="tag-form" action="" method="post" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header" height="35px">
							<h4 class="modal-title-transfer">Suggest new make and model</h4>
						</div>
						<div class="modal-body">
							<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Catalogue ID <span style="color:red;">*</span></label>
										<input type="text" id="catalogue_id_popup" name="catalogue_id" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Make <span style="color:red;">*</span></label>
										<input type="text" id="ccm_make_popup" name="make_name" class="form-control" />
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Model<span style="color:red;">*</span></label>
										<input type="text" id="ccm_model_popup" name="model_name" class="form-control" />
									</div>
								</div>
							</div> <!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Nominal Voltage (vAC)<span style="color:red">*</span></label>
										<input type="text" id="nominal_voltage" name="nominal_voltage" class="form-control numberclass nominal" placeholder="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Continous Power(watts) </label>
										<input type="text" id="continous_power" name="continous_power" class="form-control numberclass continous">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Frequency(Hz)</label>
										<input type="text" id="frequency" name="frequency" class="form-control frequency">
									</div>
								</div>
							</div><!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Cost(US$)<span style="color:red">*</span></label>
										<input type="text" id="product_price" name="product_price" class="form-control numberclass" placeholder="">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label> Input&nbsp;Voltage&nbsp;Range&nbsp;(vAC) </label>
										<input type="text" id="input_voltage_range" name="input_voltage_range" class="form-control">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Output&nbsp;Voltage&nbsp;Range&nbsp;(vAC)</label>
										<input type="text" id="output_voltage_range" name="output_voltage_range" class="form-control">
									</div>
								</div>
							</div><!--- row --->
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Phases </label>
										<div class="row" style="position:relative; top:6px;">
											<div class="col-md-6">
												<label class="radio-inline">
													<input type="radio" value="1" id="no_of_phases-1" name="no_of_phases" checked="checked">One
												</label>
											</div>
											<div class="col-md-6">
												<label class="radio-inline">
													<input type="radio" value="3" id="no_of_phases-3" name="no_of_phases">Three
												</label>
											</div>
										</div><!-- row -->
									</div>
								</div>
							</div><!--- row --->
						  <div class="modal-footer">
								<button id="btn-modalForm-submit" type="Button" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						  </div>
						</div>
					</div>
				</form>
		</div>
	</div>
			<!-- Modal end-->
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
$(document).on('change','#catalogue_id_main', function(){
	var id=$(this).val();
	var mainId=$('#assets').val();
	if(id!='0'){
		$.ajax({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Ajax_calls/getmodelData",
			success: function(result){
				var result= JSON.parse(result);
				$("#ccm_make_main").html("<option>"+result.allData.make_name+"</option>");
				$("#ccm_model_main").html("<option>"+result.allData.model_name+"</option>");
				$("#modelHide").slideDown(600);
			}
		});
		
	}else{
		$("#modelHide").slideUp(600);
	}
});
$('#btn-modalForm-submit').on('click', function(e) {
	e.preventDefault();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Coldchain/voltageRegulatorModalSave",
        data: $('form.modalForm').serialize(),
        success: function(response) {
            if(response=='required'){
				alert("Please Fill Required Fields!");
			}else{
				$('#catalogue_id_main').html(response);
				$( "#cancel" ).click();
			}
        }
    });
    return false;
});
/** For Nominal Voltage vAC Greater Than Zero **/
$('.nominal').on('keyup change', checknominal);
function checknominal()
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
			alert("Nominal Voltage vAC must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Continous Power  Watts Greater Than Zero **/
$('.continous').on('keyup change', checkcontinous);
function checkcontinous()
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
			alert("Continous Power Watts must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#btn-modalForm-submit").prop('disabled', true);
			
		}
	
}
/** For Frequency Hz Greater Than Zero **/
$('.frequency').on('keyup change', checkfrequency);
function checkfrequency()
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
			alert("Frequency Hz must be greater than zero.");
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
	var url="<?php echo base_url();?>Coldchain/voltageregulator_list/23";
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