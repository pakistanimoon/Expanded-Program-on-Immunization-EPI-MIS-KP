
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
		<div class="panel-heading">  Edit HR Form </div>
			<div class="panel-body">
				<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Hr_management/hr_edit" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered dataform" onSubmit="">			
					<div class="form-group">
						<div class="row">
							<label class="col-xs-12 col-xs-offset-1 control-label" style="font-size: 15px;">Note: <i>Fields marked with </i><span style="color:red;">*</span> <i>(asterisk) are mandatory.</i></label>
						</div>
						<input type="hidden" name="id" id="id" value="<?php echo $data['id']; ?>" >
						<input type="hidden" name="id" id="id" value="<?php echo $data['id']; ?>" >
						<input type="hidden" name="code" id="code" value="<?php echo $data['code']; ?>" >
						<input type="hidden" name="distcode" id="hidden_distcode" value="<?php echo $data['distcode']; ?>" >
						<input type="hidden" name="tcode" id="hidden_tcode" value="<?php echo $data['tcode']; ?>" >
						<input type="hidden" name="facode" id="hidden_facode" value="<?php echo $data['facode']; ?>" >
						<div class="row" style="margin-bottom:10px;">
							<label class="col-xs-1 col-xs-offset-1  control-label" > HR Code :</label>
							<div class="col-xs-3">
								<label class="control-label"  for = "supervisorcode" ><?php echo $data['code']; ?></label>
								<input type="hidden" name="hr_code" id="hr_code" value="<?php echo $data['code']; ?>" >
								<input type="hidden" name="level" id="level" value="<?php echo $data['level']; ?>" >
								<input type="hidden" name="procode" id="procode" value="<?php echo $data['procode']; ?>" >
								<input type="hidden" name="distcode" id="distcode" value="<?php echo $data['distcode']; ?>" >
								<input type="hidden" name="tcode" id="tcode" value="<?php echo $data['tcode']; ?>" >
								<input type="hidden" name="uncode" id="uncode" value="<?php echo $data['uncode']; ?>" >
								<input type="hidden" name="facode" id="facode" value="<?php echo $data['facode']; ?>" >
								<input type="hidden" name="type" id="type" value="<?php echo $data['hr_type_id']; ?>" >
								<input type="hidden" name="sub_type" id="sub_type" value="<?php echo $data['hr_sub_type_id']; ?>" >
								<input type="hidden" name="previous_code" id="previous_code" value="<?php echo ($data['previous_code'])? $data['previous_code']:NULL ?>" >
							</div>
							<label class="col-xs-1 control-label" > HR Type :</label>
							<label class="control-label col-xs-2"  for = "type" ><?php echo get_type_name($data["hr_type_id"]); ?></label>
							<label class="col-xs-2 control-label" > HR Sub-Type :</label>
							<label class="control-label col-xs-2"  for = "type" ><?php echo get_subtype_name($data["hr_sub_type_id"]); ?>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhsname" >HR Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="name" id="name" placeholder="HR Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('name'); } else { echo $data['name']; } ?>"/><?php echo form_error('name'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "father_name" > Father Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text" name="father_name" id="father_name" placeholder="Father Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('father_name'); } else { echo $data['fathername']; } ?>"/><?php echo form_error('father_name'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "guardian_name" > Guardian's Name</label>
								<div class="col-xs-3">
									<input type="text"  name="guardian_name" id="guardian_name" placeholder="Guardian's Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('guardian_name'); } else { echo $data['guardian_name']; } ?>"/><?php echo form_error('guardian_name'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "bankbranch" > Gender</label>
								<div class="col-xs-3">
									<select id="gender" name="gender" class="form-control" size="1" required>
										<?php general_lookups(array("lookup_name"=>"gender","active"=>"1"),array("create"=>"options","selected"=>$select_gender)); ?>
									</select>
								</div>	
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" > CNIC # <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<input required name="nic" id="nic" placeholder="Enter Your CNIC #"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('nic'); } else { echo $data['nic']; } ?>"/><?php echo form_error('nic'); ?><span id="site_response"></span>
							</div>
							<label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<input required type="text"  name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo date('d-m-Y', strtotime($data['date_of_birth'])); } ?>"/><?php echo form_error('date_of_birth'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Marital Status </label>
								<div class="col-xs-3">
									<select id="marital_status" name="marital_status" class="form-control" size="1" required>
										<?php general_lookups(array("lookup_name"=>"marital_status","active"=>"1"),array("create"=>"options","selected"=>$select_marital)); ?>
									</select>
								</div>
						<label class="col-xs-2 control-label"  for = "phone" > Phone Number </label>
								<div class="col-xs-3">
									<input name="phone" id="phone" placeholder="Phone Number "  class="form-control numberclass" value="<?php if(validation_errors() != false) { echo set_value('phone'); } else { echo $data['phone']; } ?>"/><?php echo form_error('phone'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "emergency_no" > Emergency No. </label>
								<div class="col-xs-3">
									<input name="emergency_no" id="emergency_no" placeholder="Emergency Number "  class="form-control numberclass" value="<?php if(validation_errors() != false) { echo set_value('emergency_no'); } else { echo $data['emergency_no']; } ?>"/><?php echo form_error('emergency_no'); ?>
								</div>
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="permanent_address" id="permanent_address" placeholder="Permanent Address"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('permanent_address'); } else { echo $data['permanent_address']; } ?>"/><?php echo form_error('permanent_address'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
								<div class="col-xs-3">
									<input type="text" name="present_address" id="present_address" placeholder="Present Address"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('present_address'); } else { echo $data['present_address']; } ?>"/><?php echo form_error('present_address'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label> 
								<div class="col-xs-3">
									<select name="lastqualification" id="lastqualification" class="form-control">
										<?php general_lookups(array("lookup_name"=>"lastqualification"),array("create"=>"options","selected"=>$select_qualify)); ?>
									</select>
								</div>
						<label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
							<div class="col-xs-3">
								<input type="text" name="passingyear" id="passingyear" placeholder="Passing Out Year"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $data['passingyear']; } ?>"/><?php echo form_error('passingyear'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
							<div class="col-xs-3">
								<input type="text"  name="institutename" id="institutename" placeholder="Institute Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('institutename'); } else { echo $data['institutename']; } ?>"/><?php echo form_error('institutename'); ?>
							</div>
						</div>
					</div>
					<div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
					<div class="form-group">    
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date of Joining </label>
								<div class="col-xs-3">
									<input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_joining'); } else { echo date('d-m-Y', strtotime($data['date_joining'])); } ?>"/><?php echo form_error('date_joining'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
								<div class="col-xs-3">
									<input type="text"  name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('place_of_joining'); } else { echo $data['place_of_joining']; } ?>"/><?php echo form_error('place_of_joining'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "area_type" > Area Type </label>
								<div class="col-xs-3">
									<select id="area_type" name="area_type" class="form-control" size="1" >
											<?php general_lookups(array("lookup_name"=>"area_type"),array("create"=>"options","selected"=>$select_area_type)); ?>
									</select>
								</div>
							<label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
								<div class="col-xs-3">
									<select id="employee_type" name="employee_type" class="form-control" size="1" >
											<?php general_lookups(array("lookup_name"=>"employee_type"),array("create"=>"options","selected"=>$select_employee)); ?>
									</select>
								</div>
						</div>
						<!--<div class="row">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
							<div class="col-xs-3">
								<select id="new_status" name="new_status" class="form-control" size="1" >
									<?php general_lookups(array("lookup_name"=>"status"),array("create"=>"options","selected"=>$data['status'])); ?>
								</select>
							</div>
							<div class="showTerminated" id="showTerminated" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
								<div class="col-xs-3">
									<input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value=" <?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($supervisordata['date_termination']) ? date('d-m-Y', strtotime($supervisordata['date_termination'])) : ''; } ?>"  class="form-control "/>
								</div>
							</div>
							<div class="showDied" id="showDied" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_died" > Date Died </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($supervisordata['date_died']) ? date('d-m-Y', strtotime($supervisordata['date_died'])) : ''; } ?>"/>
								</div>
							</div>
							<div class="showResigned" id="showResigned" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_termination" > Date Resigned </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_resigned" id="date_resigned" placeholder="Date Resigned"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_resigned'); } else { echo isset($supervisordata['date_resigned']) ? date('d-m-Y', strtotime($supervisordata['date_resigned'])) : ''; } ?>"/>
								</div>
							</div>
							<div class="showRetired" id="showRetired" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($supervisordata['date_retired']) ? date('d-m-Y', strtotime($supervisordata['date_retired'])) : ''; } ?>"/>
								</div>
							</div>
							<div class="show_leave" id="show_leave" style="display: none;">
								<label class="col-xs-2 control-label"  for = "leave_reason" > Reason </label>
								<div class="col-xs-3">
									<input type="text"  name="leave_reason" id="leave_reason" placeholder=" Reason"  value="<?php echo set_value('reason'); ?>"  class="form-control "/>
								</div>
							</div>
							<div class="show_level" id="show_level" style="display: none;">
								<label class="col-xs-2 control-label"  for = "new_level" > Level <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="new_level" onchange="getLevelValue()" name="new_level" class="form-control" size="1">
									<option value="">Select Level</option>
										<?php general_config(array("table_name"=>"hr_levels","value_col"=>"code","active"=>"1"),array("selected"=>isset($selectlevel)? $selectlevel : ""))
										//general_config('hr_levels','code','name','1'); selectlevel?>
									</select>
								</div>
							</div>
							<input type="hidden" name="hidden_date" id="hidden_date" value="<?php echo date('d-m-Y', strtotime($data['status_date'])) ?>">
							<input type="hidden" name="old_date" id="old_date" value="<?php echo date('d-m-Y', strtotime($data['status_date'])) ?>">
							<div class="show_post" id="show_post" style="display: none;">
							<label class="col-xs-2  control-label"  for = "status" > Posted As (Type) <span style="color:red;">*</span></label>
								<div class="col-xs-3">
										<select id="temp_post" name="temp_post" class="form-control" size="1">
										<option value="">Select Type</option>
											<?php general_config(array("table_name"=>"hr_types"),array("selected"=>isset($selecttype)? $selecttype : "")); //selecttype ?>
										</select>
									<!-- <select id="temp_post" name="temp_post" class="form-control" size="1" >
										<option value="">Select Post </option>
										<?php general_config(array("table_name"=>"hr_sub_types","value_col"=>"type_id","label_col"=>"title","active"=>NULL,"select_only"=>NULL),array("selected"=>isset($data['hr_sub_type_id'])? $data['hr_sub_type_id'] : "","createoption"=>TRUE)); //select_subtype?><?php echo form_error('post_status'); ?>
									</select> -->
									<!--<input type="hidden" name="post_type" id="post_type" value="" > -->
								<!--</div>
							</div>
						</div>-->
						<!--<div class="row">
							<div class="show_new_District" id="show_new_District" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "new_distcode" > District <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="new_distcode"  name="new_distcode" class="form-control" size="1" ><option value="">Select District</option>
										<?php 
											foreach($districts as $row){
										?>
										<option value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode',$row['distcode']); ?>  /><?php echo $row['district'];?>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="show_new_Tehsil" id="show_new_Tehsil" style="display: none;">
								<label class="col-xs-2 control-label"  for = "new_tcode" > Tehsil <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="new_tehcode" name="new_tehcode" class="form-control" size="1" > <option value="">Select Tehsil</option>
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
							<div class="show_new_council" id="show_new_council" style="display: none;">	
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "uncode" > Union council <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="new_uncode"  name="new_uncode" class="form-control" size="1" ><option value="">Select Union Council</option>
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
							<div class="show_new_facility" id="show_new_facility" style="display: none;">	
								<label class="col-xs-2 control-label"  for = "new_facode" > EPI Center Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="new_facode"  name="new_facode" class="form-control" size="1" ><option value="">Select EPI Center</option>
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
						</div>-->
						<!--<div class="row">
							<!--<div class="newFac" id="newFac" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1 control-label"   for = "new_lhwcode"> New HR Code </label>
								<input type="hidden" name="new_lhwcode" id="new_lhwcode" value="" >
								<div class="col-xs-3">
									<div class="row">
											<input type="hidden" disabled="disabled"  class="form-control  right" style="text-align: -webkit-right;" id="new_distcode" value="D.Code" />
											<input type="hidden" disabled="disabled" name="subtype_code" class="form-control  right" style="text-align: -webkit-right;" id="subtype_code" value="type Code" />
										<div class="col-xs-5">
											<input type="text" disabled="disabled" style="text-align: -webkit-left;" name="new_lhwcodel" id="ajax_code" placeholder=" code"  class="form-control "/>
										</div>
									</div>
								</div>
							</div>
							<div class="show_sub_post" id="show_sub_post" style="display: none;">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Posted As (Subtype) <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="temp_sub_post" name="temp_sub_post" class="form-control" size="1" >
										<option value="">Select Subtype </option>
									</select>
									<!--<input type="hidden" name="post_type" id="post_type" value="" >
								</div>
							</div>
							<div class="showTransfer" id="showTransfer" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date Transfered </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($supervisordata['date_transfer']) ? date('d-m-Y', strtotime($supervisordata['date_transfer'])) : ''; } ?>"/>
								</div>
							</div>
								<div class="showLeave" id="showLeavefrom" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_from" > Date From </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_from" id="date_from" placeholder="Date From"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_from'); } else { echo isset($supervisordata['date_from']) ? date('d-m-Y', strtotime($supervisordata['date_from'])) : ''; } ?>"/>
								</div>
							</div>
							<div class="showLeave" id="showLeaveto" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_to"> Date To </label>
								<div class="col-xs-3">
									<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_to'); } else { echo isset($supervisordata['date_to']) ? date('d-m-Y', strtotime($supervisordata['date_to'])) : ''; } ?>"/>
								</div>
							</div>
							<div class="show_remarks" id="show_remarks" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1  control-label"  for = "remarks" > Remarks </label>
								<div class="col-xs-3">
									<input type="text"  name="remarks" id="remarks" placeholder=" Remarks"  value=""  class="form-control "/>
								</div>
							</div>
							<div class="show_approved" id="show_approved" style="display: none;">
								<label class="col-xs-2 control-label"  for = "approved" > Approved By </label>
								<div class="col-xs-3">
									<input type="text"  name="approved" id="approved" placeholder=" Approved By"  value=""  class="form-control "/>
								</div>
							</div>
							<div class="showReason" id="showReason" style="display: none;">
								<label class="col-xs-2 col-xs-offset-1  control-label"  for = "reason" > Reason </label>
								<div class="col-xs-3">
									<input type="text"  name="reason" id="reason" placeholder=" Reason"  value="<?php echo set_value('reason'); ?>"  class="form-control "/>
								</div>
							</div>
						</div>-->
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>
					<div class="form-group">
						<div class="row">
						<?php 
							$a= "";
							foreach ( $training_types as $key => $training ) {
								$a .= 	'<label class="col-xs-2 col-xs-offset-1 control-label" for="training' . $key . '">' . $training['name'] . '</label>
										<input class="col-xs-1" type="checkbox" name="training[]" id="training' . $key . '" value="' . $training['id'] . '"/>';
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
										<?php general_lookups(array("lookup_name"=>"bankid"),array("create"=>"option","selected"=>$select_bank)); ?>
								  </select>
							</div>
							<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $data['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $data['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
							</div>
							<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $data['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<select id="payscale"  name="payscale" class="form-control" size="1" >
										<option value="">Select Pay Scale</option> -->
										<?php general_lookups(array("lookup_name"=>"payscale"),array("create"=>"options","selected"=>$select_pay)); ?>
									</select>
								</div>
							<label class="col-xs-2 control-label"  for = "nic" > Basic Pay <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									 <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $data['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "allowances" > Allowances <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="allowances" id="allowances" placeholder="Allowances"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('allowances'); } else { echo $data['allowances']; } ?>"/><?php echo form_error('allowances'); ?>
								</div>
							<label class="col-xs-2 control-label"  for = "deductions" > Deductions <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<input type="text"  name="deductions" id="deductions" placeholder="Deductions"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('deductions'); } else { echo $data['deductions']; } ?>"/><?php echo form_error('deductions'); ?>
								</div>
						</div>
					</div>
					<div class="row">
					<hr>
						<div class="col-xs-7" style="margin-left:53.5%;">
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
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">
/* 		function getLevelValue(){
		level=document.getElementById("new_level").value;
		//alert(level);
	} 
	function confirmAction(e) {
		var x = document.forms["dataform"]["new_distcode"].value;
		var y = document.forms["dataform"]["new_tehcode"].value;
		var z = document.forms["dataform"]["new_facode"].value;
		var distcode = document.getElementById("hidden_distcode").value;
		var tcode = document.getElementById("hidden_tcode").value;
		var facode = document.getElementById("hidden_facode").value;
		//alert(level);
		if(level == "4"){
			if (x == distcode) {
				alert("Do not Transferred in same District");
				e.preventDefault();
				return false;
			}
		}
		if(level == "5"){
			if(y==tcode){
				alert("Do not Transferred in same Tehsil");
				e.preventDefault();
				return false;
			}
		}	
		if(level == "7"){
			if(z==facode){
				alert("Do not Transferred in same Facility");
				e.preventDefault();
				return false;
		 }
		} 
	} */
/* 	var user_level = "<?php echo $_SESSION['UserLevel']; ?>";
	if(user_level == "3"){
		$("#new_level option[value='2']").remove();
	}else if(user_level == "2"){
		$("#new_level option[value!='2']").remove();
		$("#new_status option[value='Transferred']").remove();
	}else if(user_level == "4"){
		$("#new_level option[value='2'], #new_level option[value='4']").remove();
	}
	$("#new_level option[value='6']").remove();
	$("#new_level").bind('change', function(){
    var selected = $(this).val();
    if (selected == '4') { 
    		$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'none');
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_tehcode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}else if(selected == '5') {  
			$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'block');
			$('#new_tehcode').prop('required',true);
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}else if (selected == '7') {  
			$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'block');
			$('#new_tehcode').prop('required',true);
			$('#show_new_council').css('display', 'block');
			$('#new_uncode').prop('required',true);
			$('#show_new_facility').css('display', 'block');
			$('#new_facode').prop('required',true);
	}else{ 
			$('#show_new_District').css('display', 'none');
			$('#show_new_Tehsil').css('display', 'none');
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tehcode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}
    //etc ...
	}); */
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
	$('#dataform').on('submit', function(e)
	{
		var code = $('#supervisorcodel').val();
		//if(checkCode(code)){
		  if($('#nic').val().length == 15 ){
		  var nic = $('#nic').val();
		  if(!checkNICNumber(nic)){
				e.preventDefault();
			alert('CNIC number must be complete in correct format');
		  }
		  else{
			this.submit();
		  }
		}
	});
	$('#nic').blur(function (){
	}); 
 <?php if($this -> session -> UserLevel=='3' || $this -> session -> UserLevel=='2' || $this -> session -> UserLevel=='4'){ ?>  
	$(document).ready(function()
	{
		var hr_code = "<?php echo $data['code']; ?>";
		$.ajax(
			{
				url : "<?php echo base_url(); ?>Hr_management/get_training/"+hr_code,
				type : 'GET',
				dataType:'JSON',
				success : function(data) 
						{
							$.each(data, function(i, val)
							{
								$("input[value='" + val + "']").prop('checked', true);
							});
						},
				error : function(request,error)
				{
					alert("Request: "+JSON.stringify(request));
				}
			});
	});
 <?php } ?>
/* 	$('#new_distcode').on('change' , function(){
	var dists=this.value;
		$.ajax({
			type: "POST",
			data: "distcode="+dists,
			url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
					success: function(result){
						$('#new_tehcode').html(result);
					}
		});
	});
	$('#new_tehcode').on('change' , function (){
	  var tehcode = this.value;
	  var uncode = "";
	  $.ajax({
		type: "POST",
		data: "tcode="+tehcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
		success: function(result){
		  $('#new_uncode').html(result);
		}
	  });
	});
	$('#new_uncode').on('change' , function (){
	  var uncode = this.value;
	  var facode = "";
	  $.ajax({
		type: "POST",
		data: "uncode="+uncode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
		success: function(result){
		  $('#new_facode').html(result);
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
	}); */
	$(function () {
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
    $('#date_termination').datepicker(options);
	$('#date_transfer').datepicker(options);
	$('#date_retired').datepicker(options);
	$('#date_died').datepicker(options);
    $('#basic_training_start_date').datepicker(options);
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
	$('#date_from').datepicker(options);
	$('#date_to').datepicker(options);
	$('#date_resigned').datepicker(options);
  });
    $(document).ready(function()
	{
		$('#bankaccountno').numeric({allow:"-"});
		$('#branchcode').numeric({allow:"-"});
		$('#basicpay').numeric();
		$('#allowances').numeric();
		$('#deductions').numeric();
		$(":input").inputmask();
		$("#date_of_birth").inputmask("99-99-9999");
		$("#supervisorcodel").inputmask("9999");
		$("#date_joining").inputmask("99-99-9999");
		$("#date_termination").inputmask("99-99-9999");
		$("#date_transfer").inputmask("99-99-9999");
		$("#date_retired").inputmask("99-99-9999");
		$("#date_died").inputmask("99-99-9999");
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
		$('#date_from').inputmask("99-99-9999");
		$('#date_to').inputmask("99-99-9999");
		$("#date_resigned").inputmask("99-99-9999");
	});
    $(document).on('change','#date_termination', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#date_termination').val('__-__-____');
  			$('#date_termination').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_termination').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function()
  {
	var nic = $(this).val();
		if(nic!='')
		{
			$.ajax({ 
			type: 'POST',
			data: "nic="+nic,
			url: '<?php echo base_url();?>Ajax_calls/checkNICNumber',
			//dataType: "json",
			success: function(data)
			{
			   if(data!='')
				{
					if(data=='yes'){
						$('#site_response').css('display','block');
						$('#site_response').css('color','red');
						$("#site_response").html('CNIC Already Exist For Another Supervisor.');
						$('#nic').css('border-color','red');
						$("#nic").val('');
					}
					else
					{
						$('#nic').css('border-color','#66AFE9');
						$("#site_response").html('');
						$('#site_response').css('display','block');
					}
				}
			}
			 });
		}
	});

$(document).ready(function() {    
    $('#name, #guardian_name, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
        var $this = $(this),
            val = $this.val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        $this.val(val);
    });
	$('#temp_post').on('change', function (){
		var type_val = $(this).val();
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
						$('#temp_sub_post').children('option:not(:first)').remove();
						$("#temp_sub_post").append(data);
					}else{
						$('#temp_sub_post').children('option:not(:first)').remove();
					}
				}
			});
		}
		else
		{
			$('#temp_sub_post').children('option:not(:first)').remove();
		}
		});
	//post-back mechanism based on comparison of distcode
	/* var previous_code = "<?php echo $data['status']; ?>";
	if(previous_code == "Posted")
	{
		$("#new_status option[value='Posted']").remove();
		$("#new_status option[value='Transferred']").remove();
		$("#new_status").append('<option value="Post_Back">Post-Back</option>');
	} */
});
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
	// On Status Change
	$("#new_status").bind('change', function()
	{
		var selected = $(this).val();
		if(selected == 'Terminated')
		{
			$('#show_post').css('display', 'none');
			$('#showTerminated').css('display', 'block');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Transferred')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'block');
			$('#newFac').css('display', 'block');
			$('#showTransfer').css('display', 'block');
			$('#new_level').attr('required','required');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Died')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#show_new_District').css('display', 'none');
			$('#showDied').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'On Leave')
		{
			$('#show_post').css('display', 'none');
			$('#showLeavefrom').css('display', 'block');			
			$('#showLeaveto').css('display', 'block');
			$('#show_leave').css('display', 'block');
			$('#show_remarks').css('display', 'block');
			$('#show_approved').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Resigned')
		{
			$('#show_post').css('display', 'none');
			$('#showReason').css('display', 'block');
			$('#showResigned').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Retired')
		{
			$('#show_post').css('display', 'none');
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Posted')
		{
			$('#show_post').css('display', 'block');
			$('#show_sub_post').css('display', 'block');
			$('#show_post').attr('required','required');
			$('#show_sub_post').attr('required','required');
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#new_level').removeAttr('required','required');
		}
		else if(selected == 'Active')
		{
			$('#show_post').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
	});
	// Date Validations
	$(document).on('change','#date_termination', function(){
		var enddate = $(this).val();
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Termination Date Must be Greater or Equal than Joining Date.');
  			$('#date_termination').val('__-__-____');
  			$('#date_termination').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_termination').css('border-color','#66AFE9');
			$('#hidden_date').val(enddate);
  			//alert('No Error'+end_date);
  		}
	});
	$(document).on('change','#date_died', function(){
		var enddate = $(this).val();
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Date of Death Must be Greater or Equal than Joining Date.');
  			$('#date_died').val('__-__-____');
  			$('#date_died').css('border-color','red');
			$('#hidden_date').val(enddate);
  		}
  		else if(startDate <= endDate){
  			$('#date_died').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
	});
	/* $(document).on('change','#date_died', function(){
		var enddate = $(this).val();
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Date of Death Must be Greater or Equal than start date.');
  			$('#date_died').val('__-__-____');
  			$('#date_died').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_died').css('border-color','#66AFE9');
			$('#hidden_date').val(enddate);
  			//alert('No Error'+end_date);
  		}
	}); */
	$(document).on('change','#date_resigned', function(){
		var enddate = $(this).val();
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Resigned Date Must be Greater or Equal than Joining Date.');
  			$('#date_resigned').val('__-__-____');
  			$('#date_resigned').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_resigned').css('border-color','#66AFE9');
			$('#hidden_date').val(enddate);
  			//alert('No Error'+end_date);
  		}
	});
	$(document).on('change','#date_retired', function(){
  		var enddate = $(this).val();
		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Retired Date Must be Greater or Equal than Joining Date.');
  			$('#date_retired').val('__-__-____');
  			$('#date_retired').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_retired').css('border-color','#66AFE9');
			$('#hidden_date').val(enddate);
  			//alert('No Error'+end_date);
  		}
	});
	$(document).on('change','#date_transfer', function(){
		var enddate = $(this).val();
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_joining').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Transferring Date Must be Greater or Equal than Joining Date.');
  			$('#date_transfer').val('__-__-____');
  			$('#date_transfer').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_transfer').css('border-color','#66AFE9');
			$('#hidden_date').val(enddate);
  			//alert('No Error'+end_date);
  		}
	});
	$(document).on('change','#date_to', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#date_from').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('Leave Date Must be Greater or Equal than Joining Date.');
  			$('#date_to').val('__-__-____');
  			$('#date_to').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#date_to').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
	});
</script>