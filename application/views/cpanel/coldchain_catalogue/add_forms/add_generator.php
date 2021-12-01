<div class="panel panel-primary cst-label">
  <div class="panel-heading">New/Add Generator Catalogues</div>
	  <div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/Catalogue_generatorSave" method="post" onsubmit="return checkRequired();" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" id="asset_type_id" name="asset_type_id" value="24" class="form-control" />
					<div class="row">
					   <div class="col-md-3">
					   <input type="hidden" id="parent_id" name="parent_id" value="24">
						<label for="Store">Asset Type<span style="color:red;">*</span></label>
					   </div>
						<div class="col-md-3">
						  <span>Generator</span>
						</div>
 
					  <div class="col-md-3">
					   <input type="hidden" id="subid" name="subid" value="24">
						 <label for="Store">Asset Sub Type<span style="color:red;">*</span></label>
					  </div>
					  <div class="col-md-3">
						<span>Generator</span>
					  </div>
	                </div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Make <span style="color:red;">*</span></label>
								<input type="text" id="ccm_make_popup" name="make_name" class="form-control" required />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Model<span style="color:red;">*</span></label>
								<input type="text" id="ccm_model_popup" name="model_name" class="form-control" required />
							</div>
						</div>
					</div> <!--- row --->
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
	</div>
</div>
<script type="text/javascript">

$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Generator_List/24";
	window.location.href=url;
});	

</script>