<div class="panel panel-primary cst-label">
  <div class="panel-heading">New/Add Transport Catalogues</div>
	  <div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/Catalogue_transportSave" method="post" onsubmit="return checkRequired();" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" id="asset_type_id" name="asset_type_id" value="25" class="form-control" />
					<div class="row">
						<div class="col-md-6">
								<div class="row">
									<div class="col-md-4">
										<label for="Transport Type">Asset Typ <span style="color:red;">*</span></label>
									</div>
									<div class="col-md-8">
										<span>Transport</span>					
									</div>
								</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-4">
									<label for="Transport Type">Asset Sub Type <span style="color:red;">*</span></label>
								</div>
								<div class="col-md-8">
								<select class="form-control" id="ccm_sub_asset_type_id" name="ccm_sub_asset_type_id" required>
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
	var url="<?php echo base_url();?>Coldchain/Catalogue_Transport_List/25";
	window.location.href=url;
});
</script>