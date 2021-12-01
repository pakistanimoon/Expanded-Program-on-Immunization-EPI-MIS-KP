<?php //print_r($assets_sub_types_generator); exit;?>
<div class="panel panel-primary cst-label">
  <div class="panel-heading">Add Generator</div>
	<div class="panel-body">
			<form method="post" action="<?php echo base_url() ?>/Coldchain/generatorsSave" onsubmit="return checkRequired();" enctype="multipart/form-data">
				<?php $this -> load -> view('coldchain/add_forms/storesSection') ;?>
				<div class="add_refrigerator inside-page">
					<?php echo ((isset($commonSections))?$commonSections:""); ?>
					
						<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
						<input type="hidden" name="increment" value="<?php echo $varMax; ?>" class="form-control" />
						
					<div  class="row" style="margin-bottom:10px;">
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Make">Make <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select class="form-control" onchange="myFunctionmake(this)" name="make_name" id="make_name" required >
											<option value="">--select--</option>
										<?php  foreach($makedata as $key=>$values){ ?>
											<option value="<?php echo $values['pk_id']; ?>" <?php echo ($key==0)?'selected="selected"':''; ?>><?php echo $values['make_name']; ?></option>
										<?php }
										?>
									</select>							
									</div>
									<!--<div class="col-md-2">
										<button type="button" id='modalid' class="btn btn-success btn-md" data-toggle="modal" title="Add Make" data-target="#myModal" style="position:relative"> <i class="fa fa-plus"></i></button>
									</div>-->
									
								</div>
								 
						</div>
		
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Model">Model <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select class="form-control" name="ccm_model_id" id="model_name" required >
										<option>--select--</option>
									</select>
									</div>
									<!--<div class="col-md-2">
										   <button type="button" id='modalid1' class="btn btn-success btn-md" title="Add Model" style="position:relative"> <i class="fa fa-plus"></i></button>
									</div>-->
								</div>
						</div>
						
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Serial Number<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" name="serial_no" class="form-control" required />
									</div>
								</div>
						</div>
						
					</div>
				<!--- row --->	
				<div class="row" style="margin-bottom:10px">
				        <div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="UseFor">Use For<span style="color:red;">*</span> </label>
									</div>
									<div class="col-md-8">
									<select class="form-control" name="use_for" required>
									<?php echo getUseFor(); ?>
									</select>
									</div>
								</div>
						</div>
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="PowerSource">Power Source<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select  class="form-control" name="power_source" required>
										<?php echo getPowerSource(NULL,FALSE,24); ?>
									</select>						
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="PowerRating">Power Rating<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" id="power_rating" name="power_rating" class="form-control" required>
									</div>
								</div>
						</div>
						<!--<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="AssetSubType">Year of Supply<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" id="working_since" name="working_since" class="dpcct form-control" required readonly="true">
									</div>
								</div>
						</div>-->
				</div>
				<!--- row --->	
				<!--- row --->	
				<div class="row" style="margin-bottom:10px">
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="CFC">No. of Phases<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<div class="row">
												<div class="col-md-3">
													<label class="radio-inline">
														<input type="radio" checked="checked" value="1" name="no_of_phases">One
													</label>
												</div>
												<div class="col-md-3">
													<label class="radio-inline">
														<input type="radio" value="3" name="no_of_phases">Three 
													</label>
												</div>						
										</div>
									</div>
							</div>
						</div>	
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="ASM">Automatic Start Mechanism <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<div class="row">
												<div class="col-md-3">
													<label class="radio-inline">
														<input type="radio" value="1" name="automatic_start">Yes
													</label>
												</div>
												<div class="col-md-3">
													<label class="radio-inline">
														<input type="radio" value="0" checked="checked" name="automatic_start">No 
													</label>
												</div>					
										</div>
									</div>
							</div>
						</div>
				</div>
				<!--- row --->		
				<!---<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn-sv"> <i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
							</div>
						</div>-->
						<div class="text-right">
						<div class="row">
							<div class="col-md-5 col-md-offset-7">
							<button type="submit" style="background-color:#00a65a;color:white" class="btn-background box1"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
								<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
							</div>
						</div>
						</div>
						<!--- row --->
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
							   <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $asset_type_id; ?>" />
		                        <label for="Store">Asset Type<span style="color:red;">*</span></label>
		                       </div>
		                        <div class="col-md-3">
		                          <span>Generator</span>
		                        </div>
		 
	                          <div class="col-md-3">
							   <input type="hidden" id="subid" name="subid" value="<?php echo $asset_type_id; ?>"/>
		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>
		                      </div>
		                      <div class="col-md-3">
		                        <span>Generator</span>
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
							   <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $asset_type_id; ?>" />
		                        <label for="Store">Asset Type<span style="color:red;">*</span></label>
		                       </div>
		                        <div class="col-md-3">
		                          <span>Generator</span>
		                        </div>
		 
	                          <div class="col-md-3">
							  <input type="hidden" id="subid1" name="subid1" value="<?php echo $asset_type_id; ?>"/>
		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>
		                      </div>
		                      <div class="col-md-3">
		                        <span>Generator</span>
		                      </div>
	                        </div>
							<div class="row">
								<div class="col-md-3">
								<input type="hidden" id="make" name="make" value=""/>
								  <label class="control-label" for="catalogueid">Make <span style="color:red;">*</span></label>
								</div>
		                        <div class="col-md-3">
								    <span id="makeval"></span>                           
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
								<div class="row text-right" style="margin-right:12px; margin-left:0px;">
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
	//document.getElementById("makeval").innerHTML = "" + id;
	//alert(id);
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
$('#make_name').trigger('change');
$(document).on('click','#makemodel',function(){
	var url="<?php echo base_url() ?>Coldchain-MakeModel";
	window.open(url,'name');
});
$('#cancel').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/generator_list/24";
	window.location.href=url;
});	

 function myFunctionmake(selectObject) {
        var a = selectObject.value;
		$("#make").val(a);
		var make=$("#make_name option:selected").text();
        document.getElementById("makeval").innerHTML = "" + make;
		
} 
$('#btn-makeForm-submit').on('click', function(e) {
	e.preventDefault();
	var x = document.forms["tag-form-make"]["make_name"].value;
	if (x !='') {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>Coldchain/addmake",
			data: $('#tag-form-make').serialize(),
			success: function(response) {
				$('#make_name').html(response);
				$("#make_name").val($("#make_name option:last").val());
				$('#make_name').trigger('change');
				alert('Successfully Add Make and Modal');
				//$('#make_name').trigger('change');
				//$("#model_name").val($("#model_name option:last").val());
				$( "#cancel1" ).click();
				//$('#make_name option:last-child').attr('selected', 'selected');
				//$('#model_name option:last-child').attr('selected', 'selected');
			}
		});
  }else{
	  alert("Make and Model must be filled out");
  }
});
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
				//$("#model_name").val($("#model_name option:last").val());
				$('#model_name option:last-child').attr('selected', 'selected');
			}
		});
		  }else{
	  alert("Model must be filled out");
  }
});
	 
$('#cancel2').on('click', function(e) {
	$("#myModal1").modal('toggle');
});
$('#modalid1').click(function() {
	var b = $('#make_name option:selected').val();
	//alert(b); 
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
</script>