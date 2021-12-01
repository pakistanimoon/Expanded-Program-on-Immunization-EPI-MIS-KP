<div class="panel panel-primary cst-label">
  <div class="panel-heading">Catalogues Voltage Regulator Edit Form</div> 
	  <div class="panel-body">
		<form action="<?php echo base_url()?>Coldchain/Catalogue_voltageregulatorSave" method="post" onsubmit="return checkRequired();" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-body">
					<input type="hidden" id="asset_type_id" name="asset_type_id" value="23" class="form-control" />
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Catalogue ID <span style="color:red;">*</span></label>
								<input type="text" id="catalogue_id_popup" name="catalogue_id" class="form-control" value="<?php echo $data['catalogue_id'];?>" required />
								<input type="hidden" id="pk_id" name="pk_id" class="form-control" value="<?php echo $data['pk_id'];?>">								
								<input type="hidden" id="ccm_make_id" name="ccm_make_id" class="form-control" value="<?php echo $data['ccm_make_id'];?>">	
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Make <span style="color:red;">*</span></label>
								<input type="text" id="ccm_make_popup" name="make_name" value="<?php echo $data['make_name'];?>" class="form-control" required />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Model<span style="color:red;">*</span></label>
								<input type="text" id="ccm_model_popup" name="model_name" value="<?php echo $data['model_name'];?>" class="form-control" required />
							</div>
						</div>
					</div> <!--- row --->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Nominal Voltage (vAC)<span style="color:red">*</span></label>
								<input type="text" id="nominal_voltage" name="nominal_voltage" value="<?php echo $data['nominal_voltage'];?>" class="form-control numberclass nominal" placeholder="" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Continous Power(watts) </label>
								<input type="text" id="continous_power" name="continous_power" value="<?php echo $data['continous_power'];?>" class="form-control numberclass continous" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Frequency(Hz)</label>
								<input type="text" id="frequency" name="frequency"value="<?php echo $data['frequency'];?>" class="form-control frequency" required>
							</div>
						</div>
					</div><!--- row --->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Cost(US$)<span style="color:red">*</span></label>
								<input type="text" id="product_price" name="product_price" value="<?php echo $data['product_price'];?>" class="form-control numberclass" placeholder="" required>
							</div>
						</div>
	   
						<div class="col-md-4">
							<div class="form-group">
								<label> Input&nbsp;Voltage&nbsp;Range&nbsp;(vAC) </label>
								<input type="text" id="input_voltage_range" name="input_voltage_range" value="<?php echo $data['input_voltage_range'];?>" class="form-control" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Output&nbsp;Voltage&nbsp;Range&nbsp;(vAC)</label>
								<input type="text" id="output_voltage_range" name="output_voltage_range" value="<?php echo $data['output_voltage_range'];?>" class="form-control" required>
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
											<input type="radio" value="1" <?php echo ($data['no_of_phases']== 1) ?  "checked" : "" ;  ?> id="no_of_phases-1" name="no_of_phases">One
										</label>
									</div>
									<div class="col-md-6">
										<label class="radio-inline">
											<input type="radio" value="3" <?php echo ($data['no_of_phases']== 3) ?  "checked" : "" ;  ?> id="no_of_phases-3" name="no_of_phases">Three
										</label>
									</div>
								</div><!-- row -->
							</div>
						</div>
					</div><!--- row --->
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

$(".readonly").keydown(function(e){
        e.preventDefault();
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
           $("#submit").prop('disabled', false);
		}
		else
		{
			alert("Nominal Voltage vAC must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
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
           $("#submit").prop('disabled', false);
		}
		else
		{
			alert("Continous Power Watts must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
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
           $("#submit").prop('disabled', false);
		}
		else
		{
			alert("Frequency Hz must be greater than zero.");
			$(this).css("border","2px solid red");
			$("#submit").prop('disabled', true);
			
		}
	
}
$('#cancel1').on('click', function(e) {
	var url="<?php echo base_url();?>Coldchain/Catalogue_Voltageregulator_List/23";
	window.location.href=url;
});	
</script>