	<?php //print_r($assets_sub_types); exit;?>
	<div class="panel panel-primary cst-label">
	  <div class="panel-heading">New/Add Transport Asset</div>
		<div class="panel-body">
			<form method="post" action="<?php echo base_url() ?>Coldchain/transportSave" onsubmit="return checkRequired();" enctype="multipart/form-data">
				<?php $this -> load -> view('coldchain/add_forms/storesSection') ;?>
				<div class="row add_refrigerator inside-page">
					<div class="col-md-12">
						<?php echo ((isset($commonSections))?$commonSections:""); ?>
						<input type="hidden" id="asset_type_id" name="asset_type_id" value="<?php echo $asset_type_id; ?>" class="form-control" />
						<input type="hidden" name="increment" value="<?php echo $varMax; ?>" class="form-control" />
						
					<div  class="row" style="margin-bottom:10px;">
					<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Transport Type">Transport Type <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select class="form-control" onchange="myFunction(this)" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id">
										<option value="">--Select--</option>
										<?php
											foreach($assets_sub_types as $values){ ?>
												<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
										<?php } ?>
									</select>							
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Make">Make <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select class="form-control" onchange="myFunctionmake(this)" name="make_name" id="make_name" required >
											<option value="">--select--</option>
										
									</select>							
									</div>
									<div class="col-md-2">
									<!--<button type="button" id='modalid' class="btn btn-success btn-md" title="Add Make and Modal" style="position:relative"> <i class="fa fa-plus"></i> </button>-->
									</div>
									
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
									<div class="col-md-2">
									<!--<button type="button" id='modalid1' class="btn btn-success btn-md" title="Add Modal" style="position:relative"> <i class="fa fa-plus"></i> </button>-->
									</div>
								</div>
						</div>
					
					</div>
                  
				<!--- row --->	
						<!--<div class="row" style="margin-bottom:10px">
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Transport Type">Transport Type <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select class="form-control" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id">
										<option value="">--Select--</option>
										<?php
											foreach($assets_sub_types as $values){ ?>
												<option value="<?php echo $values['pk_id'] ?>"><?php echo $values['asset_type_name'] ?></option>
										<?php } ?>
									</select>							
									</div>
								</div>
						</div>
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="Make">Make<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<select class="form-control" name="make_name" id="make_name" required>
												<option value="">--select--</option>
											<?php  foreach($makedata as $values){ ?>
												<option value="<?php echo $values['pk_id']; ?>"><?php echo $values['make_name']; ?></option>
											<?php }
											?>
										</select>						
									</div>
								</div>
						</div>
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Model">Model<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<select class="form-control" name="modelID" id="model_name" required>
										<option>Select Make First</option>
										</select>						
									</div>
								</div>
						</div>
					</div>-->
					<!--- row --->
					<div class="row" style="margin-bottom:10px">
					<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Registration">Registration No.<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" id="registration_no" name="registration_no" class="form-control">						
									</div>
								</div>
						</div>
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Registration">Engine No. <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" id="engine_no" name="engine_no" class="form-control">						
									</div>
								</div>
						</div>
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
										<label for="Registration">Chases No. <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" id="chases_no" name="chases_no" class="form-control">						
									</div>
								</div>
						</div>
					</div><!--- row --->
					
					<div class="row" style="margin-bottom:10px">
						<!--<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="year">Manufacture Year <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" id="manufacturer_year" name="manufacturer_year" class="dpcct form-control" readonly="true">						
									</div>
								</div>
						</div>-->
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="Fuel Type">Fuel Type<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<select  class="form-control" name="fuel_type_id" required>
										<?php echo getPowerSource(NULL,FALSE,25); ?>
									</select>						
									</div>
								</div>
						</div>
						
						<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="Comments">Comments<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="comments" name="comments">
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
							  <div class="row" style="display:none" id="visibility">
								<div class="col-md-4">
									<label for="Capacity">Capacity<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
									<input type="text" class="form-control numberclass" id="used_for_epi" name="used_for_epi" />
								</div>
							</div>
							</div> 
					</div><!--- row --->
						<!--<div class="row" style="margin-bottom:10px">
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">
									<label for="Comments">Comments<span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="text" class="form-control" id="comments" name="comments">
									</div>
								</div>
							</div>
						</div><!--- row --->
					<!--<div class="row">
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
							   <input type="hidden" id="parent_id" name="parent_id" value="<?php echo $assets_sub_types[0]['parent_id']; ?>" />
		                        <label for="Store">Asset Type<span style="color:red;">*</span></label>
		                       </div>
		                        <div class="col-md-3">
		                          <span>Transport</span>
		                        </div>
		 
	                          <div class="col-md-3">
							  <input type="hidden" id="subid" name="subid" value=""/>
		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>
		                      </div>
		                      <div class="col-md-3">
		                        <span id="val"></span>
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
							  <input type="hidden" id="subid1" name="subid1" value=""/>
		                         <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>
		                      </div>
		                      <div class="col-md-3">
		                        <span id="val1"></span>
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


</script>