<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<ol class="breadcrumb">
				<?php  echo $this->breadcrumbs->show();?>
			</ol> 
			<div class="panel-heading"><?php if(validation_errors() != false && isset($dataFacility)){ ?>Update EPI Center<?php }else{ if($this->input->get('facode')){?>Update Health Facility<?php } else{?> ADD New Health Facility <?php } } ?></div>
			<div class="panel-body">
				<form name="dataform" id="dataform" action="<?php echo base_url();?>System_setup/flcf_add" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
					<?php
					if((validation_errors() != false && isset($dataFacility)) || $this->input->get('facode')){
						?>
						<input type="hidden" name="edit" value="2" />
						<?php
					}
					?>
					<div class="row">
					   <div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label" for = "facode" >EPI Center Name</label>
							<div class="col-xs-3">
								<input required="required" name="fac_name" id="fac_name" placeholder="EPI Center Name" class="form-control " value="<?php if(validation_errors() != false) { echo set_value('fac_name'); } else { echo (isset($dataFacility) ? $dataFacility['fac_name'] : ''); } ?>"  class="form-control "><?php echo form_error('fac_name'); ?>
								<input type="hidden" required name="facode" id="facode" readonly="readonly" placeholder="Health Facility Code"  class="form-control "  value="<?php echo (isset($dataFacility) ? $dataFacility['facode'] : '') ;?>"/>
							</div>
							<label class="col-xs-2 control-label" for = "facode" >Population</label>
							<div class="col-xs-3">
								<!--<input required="required" <?php //echo (isset($dataFacility))?'readonly':''; ?> name="population" id="population" placeholder="Population" class="form-control numberclass" value=" <?php //if(validation_errors() != false) { echo set_value('population'); } else { echo (isset($dataFacility) ? $dataFacility['catchment_area_pop'] : ''); } ?>"  class="form-control ">--><?php //echo form_error('population'); ?>
								<?php //if(isset($dataFacility)){ ?>
									<p style="color:red;">Facility Population should be managed from System Setup -> Population Management Menu.</p>
								<?php //} ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label" for = "tcode" >District</label>
							<div class="col-xs-3">
								<select id="distcode" <?php echo (isset($dataFacility))?'readonly':''; ?> required="required" name="distcode" class="form-control" size="1" >
								<?php 
								foreach($district as $row){
									?>
									<option  value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode', $row['distcode']); ?>  /><?php echo $row['district'];?>
									<?php
								}
								?>
								<?php echo form_error('distcode'); ?>
								</select>
								<?php if(isset($dataFacility)){ ?>
									<p style="color:red;">Contact your Administrator to change District of EPI Center.</p>
								<?php } ?>
							</div>
							<label class="col-xs-2 control-label" for = "tcode" >Tehsil</label>
							<div class="col-xs-3">
								<select <?php echo (isset($dataFacility))?'readonly':''; ?> id="tcode" required="required" name="tcode" class="form-control" size="1" >
									<option value="" >---- Select ---</option>
									<?php
									foreach($resultTeh as $row){
										?>
										<option <?php echo (isset($dataFacility) && $dataFacility['tcode'] == $row['tcode'] ? 'selected' : '')?> value="<?php echo $row['tcode'];?>" <?php echo set_select('tcode', $row['tcode']); ?> ><?php echo $row['tehsil'];?></option>
										<?php
									}
									?>
									<?php echo form_error('tcode'); ?>
								</select>
								<?php if(isset($dataFacility)){ ?>
									<p style="color:red;">Contact your Administrator to change Tehsil of EPI Center.</p>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label" for = "tcode" >Union Council</label>
							<div class="col-xs-3">
								<select <?php echo (isset($dataFacility))?'readonly':''; ?> id="uncode"  name="uncode" class="form-control" size="1" >
									<?php 
									foreach($resultun as $row){
										?>
										<option <?php echo (isset($dataFacility) && $dataFacility['uncode'] == $row['uncode'] ? 'selected' : '')?> value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name']; ?></option>
										<?php
									}
									?>
								</select>
								<?php if(isset($dataFacility)){ ?>
									<p style="color:red;">Contact your Administrator to change Union Council of EPI Center.</p>
								<?php } ?>
							</div>
							<label class="col-xs-2 control-label" for = "facode" >Area Type</label>
							<div class="col-xs-3">
								<select id="areatype" required="required" name="areatype" class="form-control" size="1" >
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Urban') ? 'selected = "selected"' : ''); ?> value="Urban">Urban</option>
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Rural') ? 'selected = "selected"' : ''); ?> value="Rural">Rural</option>
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Slum') ? 'selected = "selected"' : ''); ?> value="Slum">Slum</option>
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Semi Urban') ? 'selected = "selected"' : ''); ?> value="Semi Urban">Semi Urban</option>							
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Urban Slum') ? 'selected = "selected"' : ''); ?> value="Urban Slum">Urban Slum</option>														
									<option <?php echo ( (isset($dataFacility) && $dataFacility['areatype'] == 'Hard to Reach') ? 'selected = "selected"' : ''); ?> value="Hard to Reach">Hard To Reach</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label" for = "tcode" >EPI Center Type</label>
							<div class="col-xs-3">
								<select id="fatype" required="required" name="fatype" class="form-control" size="1" >
									<?php 
									foreach($resultFac_type as $row){
									?>
										<option <?php if(isset($dataFacility) && $dataFacility['fatype'] == $row['fatype'] ){ echo 'selected="selected"'; } else  { echo ''; } ?> value="<?php echo $row['fatype']; ?>" ><?php echo $row['fatype']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<label class="col-xs-2 control-label" for ="facode">EPI Center Address</label>
							<div class="col-xs-3">
								<input name="fac_address" id="fac_address" placeholder="Health Facility Address" class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('fac_address'); } else { echo (isset($dataFacility) ? $dataFacility['fac_address'] : ''); } ?>"  class="form-control "><?php echo form_error('fac_address'); ?>
							</div>
						</div>
					</div>
					<hr>
					<?php
					if( ! isset($dataFacility) && ! $this -> input -> get('facode')){
					?>
						<div class="row">
							<div class="row">
								<div class="col-1 col-md-1"></div>
								<div class="col-9 col-md-9">
									<p style="color:red;">If EPI Center is only for one purpose then un-check relevant box.</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-2 col-xs-offset-1 control-label">Is Vaccination Center?</label>
								<div class="col-xs-3">
									<input class="form-control" type="checkbox" value="1" name="is_vacc_fac" checked="checked">
								</div>
								<label class="col-xs-2 control-label">Is Surveillance Center?</label>
								<div class="col-xs-3">
									<input class="form-control" type="checkbox" value="1" name="is_ds_fac" checked="checked">
								</div>
							</div>
						</div>
						<hr>
					<?php } ?>
					<div class="row">
						<div class="col-xs-7" style="margin-left:67.5%;" >
							<button type="submit" value="1" name="submit" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Save Form </button>
							<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
							<a href="<?php echo base_url();?>System_setup/flcf_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
						</div>
					</div>
				</form>			
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->	
</div><!--End of page content or body contaier-->
<script  type="text/javascript">
	$(window).on('load', function() {
		if($('#tcode :selected').val() == '0'){
			$('#tcode :selected').val('');
		}
	});
	function checkCode(num) {
		var regexp = /[0-9]{2}/;
		var valid = regexp.test(num);
		return valid;
	}	
	<?php if(!$this->input->get('facode')){ ?>
	$('#fac_name').on('blur' , function (){
		var distcode = $('#distcode').val();
			$.ajax({
			type: "GET",
			data: "distcode="+distcode,
			url: "<?php echo base_url(); ?>Ajax_calls/generateCode",
			success: function(result){
				$('#facode').val(result);
			}
		});
	});
	<?php } ?>
</script> 