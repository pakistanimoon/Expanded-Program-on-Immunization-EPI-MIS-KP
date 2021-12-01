<?php //print_r($training);?>
<style>
input[type=checkbox], input[type=radio] {
    margin: 10px 0 0;
    margin-top: 1px\9;
    line-height: normal;
}
</style>
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
		<div class="panel-heading">  New HR Form </div>
			<div class="panel-body">
				<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Hr_management/hr_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered dataform" onSubmit="">			
					<div class="form-group">
						<div class="row">
							<label class="col-xs-12 col-xs-offset-1 control-label" style="font-size: 15px;">Note: <i>Fields marked with </i><span style="color:red;">*</span> <i>(asterisk) are mandatory.</i></label>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "level" > Level </label>
								<div id="hr_level" class="col-xs-3">
									<select id="level" name="level" class="form-control" size="1" required>
									<option value="">Select Level</option>
										<?php general_config(array("table_name"=>"hr_levels","value_col"=>"code","active"=>"1"),array("selected"=>isset($selectlevel)? $selectlevel : ""))
										//general_config('hr_levels','code','name','1'); selectlevel?>
									</select>
									<?php echo set_select('level'); ?><?php echo form_error('level');  ?>
								</div>
							<div class="showDistrict" id="showDistrict" style="display: none;">
								<label class="col-xs-2 control-label"  for = "distcode" > District <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="distcode"  name="distcode" class="form-control" size="1" ><option value="">Select District</option>
										<?php 
											foreach($result as $row){
										?>
										<option value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode',$row['distcode']); ?>  /><?php echo $row['district'];?>
										<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="showTehsil" id="showTehsil" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1  control-label"  for = "tcode" > Tehsil <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="tehcode" name="tcode" class="form-control" size="1"> <option value="">Select Tehsil</option>
										<?php 
											foreach($resultTeh as $row){
										?>
										<option value="<?php echo $row['tcode'];?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="showCouncil" id="showCouncil" style="display: none;">	
								<label class="col-xs-2 control-label"  for = "uncode" > Union council <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="uncode"  name="uncode" class="form-control" size="1" ><option value="">Select Union Council</option>
										<?php 
											foreach($resultun as $row){
										?>
										<option value="<?php echo $row['uncode'];?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?>
										<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="showFacility" id="showFacility" style="display: none;">	
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "facode" > EPI Center Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="facode"  name="facode" class="form-control" size="1" ><option value="">Select EPI Center</option>
										<?php 
											foreach($resultFac as $row){
										?>
										<option value="<?php echo $row['facode'];?>" <?php echo set_select('facode',$row['facode']); ?> /><?php echo $row['fac_name'];?>
										<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Type </label>
							<div class="col-xs-3">
								<select id="type" name="type" class="form-control" size="1" required>
								<option value="">Select Type</option>
									<?php general_config(array("table_name"=>"hr_types"),array("selected"=>isset($selecttype)? $selecttype : "")); //selecttype ?>
								</select>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" required> Sub Type </label>
								<div class="col-xs-3">
									<select id="sub_type" name="sub_type" class="form-control" size="1" required>
									<option value="">Select Subtype</option>
										<?php //general_config(array("table_name"=>"hr_sub_types","value_col"=>"type_id","label_col"=>"title","active"=>NULL,"select_only"=>NULL),array("selected"=>isset($select_subtype)? $select_subtype : "","createoption"=>TRUE)); //select_subtype?><?php echo form_error('sub_type'); ?>
									</select>
								</div>
							<!--<input type="hidden" name="code" id="code" required value="<?php echo set_value('code'); ?>" > -->
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhsname" >HR Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="name" id="name" placeholder="HR Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('name'); }else{ } ?>"/><?php echo form_error('name'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "father_name" > Father Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text" name="father_name" id="father_name" placeholder="Father Name"  class="form-control " value="<?php echo set_value('father_name'); ?>"/><?php echo form_error('father_name'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "guardian_name" > Guardian's Name</label>
								<div class="col-xs-3">
									<input type="text"  name="guardian_name" id="guardian_name" placeholder="Guardian's Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('guardian_name'); }else{ } ?>"/><?php echo form_error('guardian_name'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "father_name" > Gender <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="gender" name="gender" class="form-control" size="1" required>
										<?php general_lookups(array("lookup_name"=>"gender","active"=>"1"),array("create"=>"options","selected"=>isset($select_gender)?$select_gender:$select_gender=NULL)); ?>
									</select>
								</div>	
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" > CNIC # <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<input required name="nic" id="nic" placeholder="Enter Your CNIC #"  class="form-control " value="<?php echo set_value('nic'); ?>"/><?php echo form_error('nic'); ?><span id="site_response"></span>
							</div>
							<label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<input required type="text"  name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  class="form-control " value="<?php echo set_value('date_of_birth'); ?>"/><?php echo form_error('date_of_birth'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Marital Status </label>
								<div class="col-xs-3">
									<select id="marital_status" name="marital_status" class="form-control" size="1" required>
										<?php general_lookups(array("lookup_name"=>"marital_status","active"=>"1"),array("create"=>"options","selected"=>isset($select_marital)?$select_marital:$select_marital=NULL)); ?>
									</select>
								</div>
						<label class="col-xs-2 control-label"  for = "phone" > Phone Number </label>
								<div class="col-xs-3">
									<input name="phone" id="phone" placeholder="Phone Number "  class="form-control numberclass" value="<?php echo set_value('phone'); ?>"/><?php echo form_error('phone'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "eme" > Emergency No. </label>
								<div class="col-xs-3">
									<input name="emergency_no" id="emergency_no" placeholder="Emergency Number "  class="form-control numberclass" value="<?php echo set_value('emergency_no'); ?>"/><?php echo form_error('emergency_no'); ?>
								</div>
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="permanent_address" id="permanent_address" placeholder="Permanent Address"  class="form-control " value="<?php echo set_value('permanent_address'); ?>"/><?php echo form_error('permanent_address'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
								<div class="col-xs-3">
									<input type="text" name="present_address" id="present_address" placeholder="Present Address"  class="form-control " value="<?php echo set_value('present_address'); ?>"/><?php echo form_error('present_address'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label> 
								<div class="col-xs-3">
									<select name="lastqualification" id="lastqualification" class="form-control">
										<?php general_lookups(array("lookup_name"=>"lastqualification"),array("create"=>"options","selected"=>isset($select_qualify)?$select_qualify:$select_qualify=NULL)); ?>
									</select>
								</div>
						<label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
							<div class="col-xs-3">
								<input type="text" name="passingyear" id="passingyear" placeholder="Passing Out Year"  class="form-control " value="<?php echo set_value('passingyear'); ?>"/><?php echo form_error('passingyear'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
							<div class="col-xs-3">
								<input type="text"  name="institutename" id="institutename" placeholder="Institute Name"  class="form-control " value="<?php echo set_value('institutename'); ?>"/><?php echo form_error('institutename'); ?>
							</div>
						</div>
					</div>
					<div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
						<div class="form-group">    
							<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date of Joining </label>
									<div class="col-xs-3">
										<input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php echo set_value('date_joining'); ?>"/><?php echo form_error('date_joining'); ?>
									</div>
								<label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
									<div class="col-xs-3">
										<input type="text"  name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value="<?php echo set_value('place_of_joining'); ?>"/><?php echo form_error('place_of_joining'); ?>
									</div>
							</div>
							<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "area_type" > Area Type </label>
									<div class="col-xs-3">
										<select id="area_type" name="area_type" class="form-control" size="1" >
											<?php general_lookups(array("lookup_name"=>"area_type"),array("create"=>"options","selected"=>isset($select_area_type)?$select_area_type:$select_area_type=NULL)); ?>
									    </select>
									</div>
								<label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
									<div class="col-xs-3">
										<select id="employee_type" name="employee_type" class="form-control" size="1" >
												<?php general_lookups(array("lookup_name"=>"employee_type"),array("create"=>"options","selected"=>isset($select_employee)?$select_employee:$select_employee=NULL)); ?>
										</select>
									</div>
							</div>
							<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
									<div class="col-xs-3">
									<select id="status" name="status" class="form-control" size="1" >
										<?php general_lookups(array("lookup_name"=>"status"),array("create"=>"options","selected"=>isset($select_status)?$select_status:$select_status=NULL,"select_only"=>"Active")); ?>
									</select>
									</div>
								<label class="col-xs-2 control-label"> Date of Status </label>
									<div class="col-xs-3">
										<input type="text"  name="status_date" id="status_date" placeholder="Date Of Status"  class="form-control " value="<?php echo set_value('status_date'); ?>"/><?php echo form_error('status_date'); ?>
									</div>
							</div>
							<!--<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status_reason" > Status Reason </label>
									<div class="col-xs-3">
										<input type="text"  name="status_reason" id="status_reason" placeholder="Status Reason"  class="form-control " value="<?php echo set_value('status_reason'); ?>"/><?php echo form_error('status_reason'); ?>
									</div>
							</div> -->
						</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>
						<div class="form-group">
							<div class="row">
							<?php 
								$a= "";
								foreach ( $training_types as $key => $training ) {
									$a .= 	'<label class="col-xs-2 col-xs-offset-1 control-label" for="training' . $key . '">' . $training['name'] . '</label>
											<input class="col-xs-1" type="checkbox" name="training[]" id="training' . $key . '" value="' . $training['id'] . '" />';
								}
								echo $a;?>
								
							</div>
						</div>					
						<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
							<div class="form-group">
							   <!--yea change kia ha 25-->
							   <div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										  <select id="bankid"  name="bankid" class="form-control" size="1" required>
												<option value="">Select Bank</option>
												<?php general_lookups(array("lookup_name"=>"bankid"),array("create"=>"option","selected"=>isset($select_bank)?$select_bank:$select_bank=NULL)) ?>
										  </select>
									</div>
									<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php echo set_value('branchcode'); ?>"/><?php echo form_error('branchcode'); ?>
									</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php echo set_value('branchname'); ?>"/><?php echo form_error('branchname'); ?>
									</div>
									<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php echo set_value('bankaccountno'); ?>"/><?php echo form_error('bankaccountno'); ?>
									</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<select id="payscale"  name="payscale" class="form-control" size="1" required>
												<option value="">Select Pay Scale</option>
												<?php general_lookups(array("lookup_name"=>"payscale"),array("create"=>"options","selected"=>isset($select_pay)?$select_pay:$select_pay=NULL)); ?>
											</select>
										</div>
									<label class="col-xs-2 control-label"  for = "basicpay" > Basic Pay <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											 <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
										</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "allowances" > Allowances <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<input type="text"  name="allowances" id="allowances" placeholder="Allowances"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
										</div>
									<label class="col-xs-2 control-label"  for = "deductions" > Deductions <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<input type="text"  name="deductions" id="deductions" placeholder="Deductions"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
										</div>
								</div>
							</div>
							<div class="row">
							<hr>
								<div class="col-xs-7" style="margin-left:69%;">
									<button type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save  </button>
									<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
									<a href="<?php echo base_url();?>Hr_management/hr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
								</div>
							</div>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script src="jquery-3.4.1.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">
$(document).ready(function() {    
	var user_level = "<?php echo $_SESSION['UserLevel']; ?>";
	if(user_level == "3"){
		$("#level option[value='2']").remove();
	}else if(user_level == "2"){
		$("#level option[value!='2']").remove();
	}else if(user_level == "4"){
		$("#level option[value='2'], #level option[value='4']").remove();
	}
	$("#level option[value='6']").remove();
	$("#level").bind('change', function(){
		var selected = $(this).val();
		if (selected == '4') { 
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#tehcode').removeAttr('required','required');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
		}else if(selected == '5') {  
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'block');
				$('#tehcode').prop('required',true);
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
		}else if (selected == '7') {  
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'block');
				$('#tehcode').prop('required',true);
				$('#showCouncil').css('display', 'block');
				$('#uncode').prop('required',true);
				$('#showFacility').css('display', 'block');
				$('#facode').prop('required',true);
		}else{ 
				$('#showDistrict').css('display', 'none');
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#distcode').removeAttr('required','required');
				$('#tehcode').removeAttr('required','required');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
		}
		//etc ...
	});
	function checkNICNumber(num) {
		var regexp = /[0-9]{5}\-[0-9]{7}\-[0-9]{1}/; 
		var valid = regexp.test(num);
		return valid;
	}
	function checkDate(num) {
		var regexp = /[0-9]{4}\-[0-9]{2}\-[0-9]{2}/; 
		var valid = regexp.test(num);
		return valid;
	}
	function checkCode(num) {
		var regexp = /[0-9]{2}/; 
		var valid = regexp.test(num);
		return valid;
	}
	$('#dataform').on('submit', function(e){
		var code = $('#supervisorcodel').val();
		//if(checkCode(code)){
		  if($('#nic').val().length == 15 )
		{
			var nic = $('#nic').val();
			if(!checkNICNumber(nic))
			{
				e.preventDefault();
				alert('CNIC number must be complete in correct format');
			}
			else
			{
				this.submit();
			}
		}
	});
	/* $('#nic').blur(function (){
	}); */
	/* $('#supervisorcodel').keyup(function ()
	{
		var supervisorcodel = $('#supervisorcodel').val();
		var supervisorcodef = +$('#supervisorcodef').val();
		var facode = "";
		if(/^\d+$/.test(supervisorcodel) )
		{
		  if($('#supervisorcodef').val().length == 3 && $('#supervisorcodel').val().length == 4 )
		  {
			//alert('asdkjhsdja');
			$('#supervisorcodel').css('border-color','#dbe1e8');
			 <?php if($this -> session -> UserLevel=='3'){ ?>  
				var distcode = $('#distcode').val();
			 <?php } ?>
			  <?php if($this -> session -> UserLevel=='3'){ ?>  
			var distcode = '<?php echo $this -> session -> District; ?>';
			 <?php } ?>
			var supervisorcodel  = $('#supervisorcodel').val();
			var newVal = distcode+""+supervisorcodel;
			//alert(newVal);
			$('#supervisorcode').val(newVal);
			//alert($('#lhscode').val());
			$.ajax({
			  type: "GET",
			  data: "supervisorcode="+newVal,
			  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
			  success: function(result){
				console.log(result);

				if(result.trim() == "0"){
				  $('#supervisorcode').val(newVal);
				}else{
				  alert('The Code '+newVal+' already exists, please try some other code');
				  $('#supervisorcodel').val('');
				  $('#supervisorcodel').css('border-color','red');
				}
			  }
			});
		  }else
		  {
			$('#supervisorcodel').css('border-color','red');
		  }
		}
		else
		{
		  $('#supervisorcodel').css('border-color','red');
		}
		//alert($('#lhscode').val());
	});   */
	$('#distcode').on('change' , function(){
	var dists=this.value;
		$.ajax({
			type: "POST",
			data: "distcode="+dists,
			url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
					success: function(result){
						$('#tehcode').html(result);
						<?php if(validation_errors() != false) { ?>
							$('#tehcode').val('<?php echo $tcode;?>');
						<?php }else {}?>
					}
		});
	});
	$('#tehcode').on('change' , function ()
	{
		var tehcode = this.value;
		var uncode = "";
		$.ajax(
{
			type: "POST",
			data: "tcode="+tehcode,
			url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
			success: function(result){
			  $('#uncode').html(result);
			  <?php if(validation_errors() != false) { ?>
					$('#uncode').val('<?php echo $uncode;?>');
			  <?php }else {}?>
			}
		});
	});
	$('#uncode').on('change' , function (){
	  var uncode = this.value;
	  var facode = "";
	  $.ajax({
		type: "POST",
		data: "uncode="+uncode, 
		//async: false,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
		success: function(result){
		  $('#facode').html(result);
		    <?php if(validation_errors() != false) { ?>
					//$("#facode option[value='<?php echo $facode;?>']").attr('selected', 'selected');
					//$("#facode option[value='<?php echo set_value('facode');?>']").prop('selected',true);
					$('#facode').val('<?php echo $facode;?>');  
		    <?php }else {}?>
		}
	  });
	 
	});
	$('#tehcode').on('change' , function (){
		var tehcode = this.value;
	//	alert (tehcode);
		var facode = "";
			if (tehcode!='')
			{
					document.getElementById("distcode").required = false;
			} 
	}); 
	$(function ()
	{
		var options = {
			format : "dd-mm-yyyy",
			startDate : "01-01-1925",
			endDate: "12-12-2000"
		};
		$('#date_of_birth').datepicker(options);
		var options = {
		  format : "dd-mm-yyyy"
		};
		$('#status_date').datepicker(options);
		var options = {
		  format : "dd-mm-yyyy"
		};
		$('#date_joining').datepicker(options);
		//$('#date_termination').datepicker(options);
		//$('#date_transfer').datepicker(options);
		//$('#date_retired').datepicker(options);
		//$('#date_died').datepicker(options);
		$('#basic_training_start_date').datepicker(options);
		$('#basic_training_end_date').datepicker(options);
		$('#routine_epi_start_date').datepicker(options);
		$('#routine_epi_end_date').datepicker(options);
		$('#survilance_training_start_date').datepicker(options);
		$('#survilance_training_end_date').datepicker(options);
		$('#cold_chain_training_start_date').datepicker(options);
		$('#cold_chain_training_end_date').datepicker(options);
		$('#vlmis_training_start_date').datepicker(options);
		$('#vlmis_training_end_date').datepicker(options);
		$('#epimis_training_start_date').datepicker(options);
		$('#epimis_training_end_date').datepicker(options);
		//$('#status_date').datepicker(options);
		//$('#tenmonth_training_end_date').datepicker(options);
	});
		$('#bankaccountno').numeric({allow:"-"});
		$('#branchcode').numeric({allow:"-"});
		$('#basicpay').numeric();
		$('#allowances').numeric();
		$('#deductions').numeric();
		$(":input").inputmask();
		$("#date_of_birth").inputmask("99-99-9999");
		$("#supervisorcodel").inputmask("9999");
		$("#date_joining").inputmask("99-99-9999");
	   // $("#date_termination").inputmask("99-99-9999");
		//$("#date_transfer").inputmask("99-99-9999");
		//$("#date_retired").inputmask("99-99-9999");
		//$("#date_died").inputmask("99-99-9999");
		$("#basic_training_end_date").inputmask("99-99-9999");
		$("#basic_training_start_date").inputmask("99-99-9999");
		$("#routine_epi_start_date").inputmask("99-99-9999");
		$("#routine_epi_end_date").inputmask("99-99-9999");
		$("#survilance_training_start_date").inputmask("99-99-9999");
		$("#survilance_training_end_date").inputmask("99-99-9999");
		$("#cold_chain_training_start_date").inputmask("99-99-9999");
		$("#cold_chain_training_end_date").inputmask("99-99-9999");
		$("#vlmis_training_start_date").inputmask("99-99-9999");
		$("#vlmis_training_end_date").inputmask("99-99-9999");
		$("#epimis_training_start_date").inputmask("99-99-9999");
		$("#epimis_training_end_date").inputmask("99-99-9999");
		$("#nic").inputmask("99999-9999999-9");
		$("#passingyear").inputmask("9999");
		$("#phone").inputmask("99999999999");
    // $("#branchcode").inputmask("99999");
    // $("#bankaccountno").inputmask("9999999999999999");
//////////////////////////////////Checking CNIC//////////////////////////////////
 /*  $(document).on('blur','#nic', function(){
    var nic = $(this).val();
	if(nic!=''){
		 $.ajax({ 
		  type: 'POST',
		  data: "nic="+nic,
		  url: '<?php echo base_url();?>Ajax_calls/checkNICNumber',
		  //dataType: "json",
		  success: function(data){
		   if(data!=''){
				if(data=='yes'){
					$('#site_response').css('display','block');
					$('#site_response').css('color','red');
					$("#site_response").html('CNIC Already Exist For Another Supervisor.');
					$('#nic').css('border-color','red');
					$("#nic").val('');
				}
				else{
					$('#nic').css('border-color','#66AFE9');
					$("#site_response").html('');
					$('#site_response').css('display','block');
				}
		  }
		 }
		 });
	}
}); */
    $('#name, #guardian_name, #permanent_address, #present_address, #branchname').on('keyup', function(event) 
	{
        var $this = $(this),
            val = $this.val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        $this.val(val);
    });
	$(function () {
    get_subtypes(); //this calls it on load
    $("#type").change(get_subtypes);
	});
	function get_subtypes()
	{
			var type_val = $("#type").val(); 
			if(type_val){
				$.ajax({ 
					type: 'POST',
					data: "type_val="+type_val,
					url: '<?php echo base_url();?>Ajax_hr_management/sub_type_options',
					//dataType: "json",
					success: function(data)
					{
						if(data!='')
						{
							$('#sub_type').children('option:not(:first)').remove();
							$("#sub_type").append(data);
							$('#sub_type [value="<?php echo $this->input->post("sub_type"); ?>"]').attr('selected', 'true');
						}else{
							$('#sub_type').children('option:not(:first)').remove();
						}
					}
				});
			}
			else
			{
				$('#sub_type').children('option:not(:first)').remove();
			}
		};
	<?php if(validation_errors() != false) { ?>
		function func1() {
			var level =$("#level").val();
			if(level == "4"){
				//alert('a');
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#tehcode').removeAttr('required','required');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
			}else if(level == "5"){
				//alert('b'); 
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'block');
				$('#tehcode').prop('required',true);
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
			}else if(level == "7"){
				//alert('c');
				$('#showDistrict').css('display', 'block');
				$('#distcode').prop('required',true);
				$('#showTehsil').css('display', 'block');
				$('#tehcode').prop('required',true);
				$('#showCouncil').css('display', 'block');
				$('#uncode').prop('required',true);
				$('#showFacility').css('display', 'block');
				$('#facode').prop('required',true);
			}else{ 
				$('#showDistrict').css('display', 'none');
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none');
				$('#showCouncil').css('display', 'none');
				$('#distcode').removeAttr('required','required');
				$('#tehcode').removeAttr('required','required');
				$('#facode').removeAttr('required','required');
				$('#uncode').removeAttr('required','required');
			}
			/* if('<?php foreach($training as $key => $training)?>'){
				//$( "input[type='checkbox']").prop( "checked", true );
				//$( "#training" ).html( $( "input:checked" ).val() + " is checked!" );
				$("input:checkbox:checked").prop( "checked", true );
			} */
			
			//var ar = <?php echo json_encode($training) ?>;
			//checkboxes =json_encode(out);
		    /* var checked=false;
			var checkboxes = '<?php echo json_encode($training); ?>';
			console.log(checkboxes);
			for (var i = 0; i < checkboxes.length; i++) {
			  if(checkboxes[i].checked) {
					checked = true;
				}
			}  */
			/* var training = '<?php echo $training; ?>';
			if(foreach(training as key => value)){
				alert('aa');
				if(is_array($_POST['training']) && in_array($value,$_POST['training']))
					echo " checked "; 
					echo "value"; }  */
		}	    
		window.onload=func1;
	<?php }	else {}?>  
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
});
//////////////////////////////////////////////////////////////////////////////////
</script>