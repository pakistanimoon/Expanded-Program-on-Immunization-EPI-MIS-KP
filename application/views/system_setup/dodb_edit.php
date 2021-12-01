<!--start of page content or body-->
<div class="container bodycontainer">
  <div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
       <?php  echo $this->breadcrumbs->show();?>
     </ol> 
     <div class="panel-heading"> Update Data Entry Operator Form
     </div>
     <div class="panel-body">
       <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/deodb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     
<input type="hidden" name="distcode" id="distcode" value="<?php echo $deodata['distcode']; ?>" /><input type="hidden" name="previous_code" id="previous_code" value="<?php echo $deodata['previous_code']; ?>" />
   <div class="form-group">
                <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "facode" > District </label>
                      <div class="col-xs-3 cmargin5">
                        <span> <?php echo $deodata['districtname'];?> </span>
                      </div>
                        <label type="hidden" hidden class="control-label"  for = "cocode" >Data Entry Operator Code  </label>
                      <div class="col-xs-3 cmargin5">
                       <label type="hidden" hidden class="col-xs-2 control-label"   for = "cocode" ><?php echo $deodata['deocode'];?>  </label>
                        <!--<span> <?php echo $deodata['deocode'];?> </span>-->
                        <input type="hidden" required name="deocode" id="deocode" placeholder="AS Code"  value="<?php echo $deodata['deocode'];?>"  class="form-control "/>
                      </div>
                    </div>
                    <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "deoname" > Data Entry Operator Name </label>
                      <div class="col-xs-3">
                       <input type="text" required name="deoname" id="deoname" placeholder="Data Entry Operator Name"  value="<?php if(validation_errors() != false) { echo set_value('deoname'); } else { echo $deodata['deoname']; } ?>"  class="form-control "/><?php echo form_error('deoname'); ?>
                      </div>
                        <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                      <div class="col-xs-3">
                         <input type="text"  name="  fathername" id="fathername" placeholder="Father Name"  value="<?php if(validation_errors() != false) { echo set_value('fathername'); } else { echo $deodata['fathername']; } ?>"  class="form-control "/><?php echo form_error('fathername'); ?>
                      </div>
                    </div>
              </div>
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
 <div class="form-group">
                <div class="row">
             <label class="col-xs-2 col-xs-offset-1 control-label"  for = "dateofbirth" > Date Of Birth</label>
                <div class="col-xs-3">
                  <input type="text"  name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy" onchange="dop()" value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo isset($deodata['date_of_birth']) ? date('d-m-Y', strtotime($deodata['date_of_birth'])) : ''; } ?>"  class="form-control "/>
                </div>
                  <label class="col-xs-2 control-label"  for = "facode" > CNIC # </label>
                  <div class="col-xs-3">
                    <input type="text"  name="nic" id="nic" placeholder="Enter Your CNIC #"  value="<?php if(validation_errors() != false) { echo set_value('nic'); } else { echo $deodata['nic']; } ?>"  class="form-control "/><?php echo form_error('nic'); ?>
                  </div>
                </div>
                <div class="row">
                   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "drivercode" >Permanent Address  </label>
                  <div class="col-xs-3">
                    <input type="text"  name="permanent_address" id="permanent_address" placeholder="Permanent Address "  value="<?php if(validation_errors() != false) { echo set_value('permanent_address'); } else { echo $deodata['permanent_address']; } ?>"  class="form-control "/>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Present Address </label>
                  <div class="col-xs-3">
                    <input type="text"  name="present_address" id="present_address" placeholder=" Present Address"  value="<?php if(validation_errors() != false) { echo set_value('present_address'); } else { echo $deodata['present_address']; } ?>"  class="form-control "/>
                  </div>
                </div>
                <div class="row">
                 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Postal Code</label>
                  <div class="col-xs-3">
                    <input type="text"  name="postalcode" id="postalcode" placeholder="Postal Code"  value="<?php if(validation_errors() != false) { echo set_value('postalcode'); } else { echo $deodata['postalcode']; } ?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "asname" > City </label>
                  <div class="col-xs-3">
                    <input type="text"  name="city" id="city" placeholder="City"  value="<?php if(validation_errors() != false) { echo set_value('city'); } else { echo $deodata['city']; } ?>"  class="form-control "/>
                  </div>
                </div>
                <div class="row">
                    <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Phone</label>
                  <div class="col-xs-3">
                    <input type="text"  name="phone" id="phone" placeholder="Phone"  value="<?php if(validation_errors() != false) { echo set_value('phone'); } else { echo $deodata['phone']; } ?>"  class="form-control numberclass"/><?php echo form_error('phone'); ?>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Marital Status </label>
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                        <option <?php if($deodata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($deodata['marital_status'] == 'Single') { echo 'selected="selected"'; } else { echo ''; } ?> value="Single">Single</option>
                        <option <?php if($deodata['marital_status'] == 'Widowed') { echo 'selected="selected"'; } else { echo ''; } ?> value="Widowed">Widowed</option>
                        <option <?php if($deodata['marital_status'] == 'Divorced') { echo 'selected="selected"'; } else { echo ''; } ?> value="Divorced">Divorced</option>
                        <option <?php if($deodata['marital_status'] == 'Other') { echo 'selected="selected"'; } else { echo ''; } ?> value="Other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Area Type</label>
                  <div class="col-xs-3">
                    <select id="area_type" name="area_type" class="form-control" size="1" >
                          <option <?php if($deodata['area_type'] == 'Urban') { echo 'selected="selected"'; } else { echo ''; } ?> value="Urban">Urban</option>
                          <option <?php if($deodata['area_type'] == 'Rural') { echo 'selected="selected"'; } else { echo ''; } ?> value="Rural">Rural</option> 
                    </select>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Last Qualification </label>
                  <div class="col-xs-3">
                    <select name="lastqualification" id="lastqualification" class="form-control"> 
                         <option <?php if($deodata['lastqualification'] == 'Matric') { echo 'selected="selected"'; }else echo ''; ?> value="Matric">Matric</option>
                      <option <?php if($deodata['lastqualification'] == 'FA') { echo 'selected="selected"'; }else echo ''; ?> value="FA">F.A/F.Sc</option>
                      <option <?php if($deodata['lastqualification'] == 'BA') { echo 'selected="selected"'; }else echo ''; ?> value="BA">B.A/BCS/B.Sc/B.Ed</option>
                      <option <?php if($deodata['lastqualification'] == 'MA') { echo 'selected="selected"'; }else echo ''; ?> value="MA">M.A/MCS/M.Sc/M.Ed</option>
					  <option <?php if($deodata['lastqualification'] == 'BBA/MBA') { echo 'selected="selected"'; }else echo ''; ?> value="BBA/MBA">BBA/MBA</option>
                      <option <?php if($deodata['lastqualification'] == 'Diploma') { echo 'selected="selected"'; }else echo ''; ?> value="Diploma">Diploma</option>
                       <option <?php if($deodata['lastqualification'] == 'MBBS') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS">MBBS</option>
					  <option <?php if($deodata['lastqualification'] == 'MBBS,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS,MPH">MBBS,MPH</option>
					  <option <?php if($deodata['lastqualification'] == 'MD') { echo 'selected="selected"'; }else echo ''; ?> value="MD">MD</option>
					  <option <?php if($deodata['lastqualification'] == 'MD,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MD,MPH">MD,MPH</option>
                    </select>
                  </div>
              </div>
              <div class="row">
			   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "asname" > Institute Name </label>
                <div class="col-xs-3">
                  <input type="text"  name="institutename" id="institutename" placeholder="Institute Name"  value="<?php if(validation_errors() != false) { echo set_value('institutename'); } else { echo $deodata['institutename']; } ?>"  class="form-control "/>
                </div>
                   <label class="col-xs-2 control-label"  for = "fathername" > Passing Year</label>
                <div class="col-xs-3">
                  <input type="text"  name="passingyear" id="passingyear" placeholder="Phone"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $deodata['passingyear']; } ?>"  class="form-control "/><?php echo form_error('passingyear'); ?>
                </div>    
              </div>
              <div class="row">
				 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Status</label>
              <div class="col-xs-3">
                        <select id="status" name="status" class="form-control" size="1" >
					 
                      <option <?php if($deodata['status'] == 'Active') { echo 'selected="selected"'; }else echo ''; ?> value="Active">Active</option>
                        <option <?php if($deodata['status'] == 'Terminated') { echo 'selected="selected"'; }else echo ''; ?>  value="Terminated">Terminated</option>
                        <option <?php if($deodata['status'] == 'Died') { echo 'selected="selected"'; }else echo ''; ?>  value="Died">Died</option>
                        <option <?php if($deodata['status'] == 'Retired') { echo 'selected="selected"'; }else echo ''; ?>  value="Retired">Retired</option>
						<?php if($deodata['current_status']=='Temporary-Post'){?>
						<option value="post">Temporary-Post</option>
						<?php }else{} ?>
						
					 </select>
                      </div>
				   	<div class="showTerminated" id="showTerminated" style="display: none;">
                      <label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                          <input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value="<?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($deodata['date_termination']) ? date('d-m-Y', strtotime($deodata['date_termination'])) : ''; } ?>"  class="form-control "/>
					</div>
					</div>
					<div class="showRetired" id="showRetired" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($deodata['date_retired']) ? date('d-m-Y', strtotime($deodata['date_retired'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showDied" id="showDied" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Died </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($deodata['date_died']) ? date('d-m-Y', strtotime($deodata['date_died'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showTransfer" id="showTransfer" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Transfered </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($deodata['date_transfer']) ? date('d-m-Y', strtotime($deodata['date_transfer'])) : ''; } ?>"/>
					</div>
					</div>
					 <div class="showpostoption" id="showpostoption" style="display: none;">
					<label class="col-xs-2 control-label"  for = "showpostoption" > Posted As</label>
					<div class="col-xs-3">
                          <select id="post_type" name="post_type" class=  "form-control" size="1" onchange="suptype(this.value)" >
						  <option value="select">Select Post</option>
						  <option value="EpiTechnician">EpiTechnician</option>
						 <option value="District Superintendent Vaccinator">DSV</option>
						 <option value="Tehsil Superintendent Vaccinator">TSV</option>
						 <option value="Field Superintendent Vaccinator">FSV</option>
						 <option value="Storekeeper">Store Keeper</option>
					     
				         </select>
					</div>
					</div>
											 <div class="showTehsil" id="showTehsil" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:94px" for = "showTehsil" >  Tehsil</label>
                      <div class="col-xs-3">
                          <select id="newtcode" name="newtcode" class="form-control" size="1">
						          <option value="select">Select Tehsil</option>
						         <?php 
									foreach($resultTeh as $row){?>
										<option value="<?php echo $row['tcode'];?>" ><?php echo $row['tehsil'];?></option><?php
									}?>
						  </select>
					</div>
					<div class="showUnc" id="showUnc" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:0px"   for = "showUnc" >  Union Council</label>
                      <div class="col-xs-3">
                          <select id="newuncode" name="newuncode" class="form-control" size="1">
						          <option value="select">Select Union Council</option>
						          
						  </select>
					</div>
					</div>
				
					</div>
					 <div class="showFacility" id="showFacility" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:94px"   for = "showTehsil" >  Facility</label>
                      <div class="col-xs-3">
                          <select id="newfacode" name="newfacode" class="form-control" size="1">
						          <option value="select">Select HF Facility</option>
						          
						  </select>
					</div>
					</div>
              </div>
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Employee Type</label>
                  <div class="col-xs-3">
                    <select id="employee_type" name="employee_type" class="form-control" size="1" >
                          <option <?php if($deodata['employee_type'] == 'Contract') { echo 'selected="selected"'; } else { echo ''; } ?> value="Contract">Contract</option>
                          <option <?php if($deodata['employee_type'] == 'Permanent') { echo 'selected="selected"'; } else { echo ''; } ?> value="Permanent">Permanent</option> 
                    </select>
                  </div>    
                 
              </div>
            </div>
    <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
              <div class="form-group">
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "facode" > Date Of Joining </label>
                  <div class="col-xs-3">
                    <input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo isset($deodata['date_of_birth']) ? date('d-m-Y', strtotime($deodata['date_of_birth'])) : ''; } ?>"/>
                  </div>
                  <label class=" col-xs-2 control-label"  for = "drivercode" >Place of Joining </label>
                  <div class="col-xs-3">
                    <input type="text" name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $deodata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                </div>
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "asname" >Place Of Posting</label>
                  <div class="col-xs-3">
                    <input type="text"  name="place_of_posting" id="place_of_posting" placeholder="Place Of Posting"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $deodata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Designation </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  designation" id="designation" placeholder="Designation"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $deodata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                </div>
            </div>
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
 <div class="form-group">
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information</label>
		<div class="col-xs-3">
			  <select id="bankid"  name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>"  <?php if($deodata['bid'] == $row['bankid'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $deodata['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $deodata['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $deodata['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
		<div class="col-xs-3">
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option <?php if($deodata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
																			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			<input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $deodata['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
</div>
            <hr>
<input type="hidden" name="edit" value="edit">
            <div class="row">
             <div class="col-xs-7" style="margin-left:53.5%;" >
               <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>
			   <button type="submit" name="is_temp_saved" id="myCoolForm" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit Form  </button>
               <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
               <a href="<?php echo base_url();?>DataEntry-Operator-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
             </div>
           </div>
         </form>
       </div> <!--end of panel body-->
     </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
 </div><!--End of page content or body-->
  <script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
        <script type="text/javascript">
$("#status").bind('change', function(){
    var selected = $(this).val();
    if (selected == 'Active') { 
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'none'); 
              $('#showpostoption').css('display', 'none');
             $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 			  
	}
    if (selected == 'Terminated') {  
			$('#showTerminated').css('display', 'block');
			$('#showRetired').css('display', 'none'); 
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 	
			$('#showpostoption').css('display', 'none');
             $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 			  
			}
	if (selected == 'Died') { 
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'block'); 
              $('#showpostoption').css('display', 'none');
              $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 			  
	}
	if (selected == 'Retired') { 
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 
              $('#showpostoption').css('display', 'none');
             $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 			  
	}
	if (selected == 'Transfered') { 
			$('#showTransfer').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 	
            $('#showpostoption').css('display', 'none');	
             $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 			
	}
	if (selected == 'post') { 
			$('#showTransfer').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 
            $('#showpostoption').css('display', 'block');
            $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none');  			
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
            var code = $('#ascodel').val();
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
          $('#facode').on('change' , function (){
            var facode = this.value;
          });
          $('#tcode').on('change' , function (){
            var tcode = this.value;
            var facode = "";
          });
        </script> 
        <script type="text/javascript">
          $(function () {
            var options = {
              format : "dd-mm-yyyy",
              startDate : "01-01-1925",
              endDate: "12-12-2000"
            };
            $('#date_of_birth').datepicker(options);
		  });
            function dop(){
	var dob=($('#date_of_birth').val());
      
    var year =dob.substr(6,10);
   var number = parseInt(year);
   number=number+15;
  var options = {
      format : "dd-mm-yyyy",
      startDate :"01-01-"+number
    
    };

	  $('#date_joining').datepicker(options);
	
}
        </script>
        <script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
        <script type="text/javascript">
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
           
			 $('#date_termination').datepicker(options);
			$('#date_transfer').datepicker(options);
			$('#date_retired').datepicker(options);
			$('#date_died').datepicker(options);
          });
          $(document).ready(function(){
            $('#bankaccountno').numeric({allow:"-"});
			$('#branchcode').numeric({allow:"-"});
			$('#basicpay').numeric();
            $(":input").inputmask();
            $("#date_of_birth").inputmask("99-99-9999");
            $("#date_joining").inputmask("99-99-9999");
            $("#passingyear").inputmask("9999");
			$("#date_termination").inputmask("99-99-9999");
			$("#date_transfer").inputmask("99-99-9999");
			$("#date_retired").inputmask("99-99-9999");
			$("#date_died").inputmask("99-99-9999");
   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
});
 //get unioncl by tehsil
$('#newtcode').on('change' , function (){
  var newtcode = this.value;
  var newuncode = "";
  $.ajax({
    type: "POST",
    data: "tcode="+newtcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
    success: function(result){
      $('#newuncode').html(result);
    }
  });
   $('#newfacode').empty();
});
//getting facility by UNc
$('#newuncode').on('change' , function (){
  var newuccode = this.value;
  var newfacode = "";
  $.ajax({
    type: "POST",
    data: "uncode="+newuccode,
    url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
    success: function(result){
      $('#newfacode').html(result);
    }
  });
});
$(document).ready(function() {    
    $('#deoname, #fathername, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
        var $this = $(this),
            val = $(this).val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        console.log(val);
        $this.val(val);
    });
});
//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){
   var nic = $(this).val();
   var code = $(ascode).val();
	if(nic!=''){
	   $.ajax({ 
		type: 'POST',
		data: 'nic='+nic+'&code='+code,
		url: '<?php echo base_url();?>Ajax_calls/checkdeoNIC',
		success: function(data){
		 if(data!=''){
		  if(data=='yes'){
			$('#site_response').css('display','block');
			$('#site_response').css('color','red');
			$('#site_response').html('CNIC Already Exist For Another Date Entry Operator.');
			$('#nic').css('border-color','red');
			$('#nic').val('');
		  }
		  else{
			$('#nic').css('border-color','#66AFE9');
			$('#site_response').html('');
			$('#site_response').css('display','block');
		  }
		}
	   }
	   });
	}
});

/*FOr Sup type  */
	  //for techsil dropdown
   function suptype(val){
	   
	   if(val=="EpiTechnician"){
		  
		  $('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none');
            $('#showUnc').css('display', 'none'); 
		   		
	   }
	   if(val=="Field Superintendent Vaccinator"){
		  
		  $('#showTehsil').css('display', 'block'); 
		    $('#showFacility').css('display', 'block');
            $('#showUnc').css('display', 'block'); 
		   		
	   }
	   if(val=="Tehsil Superintendent Vaccinator"){
		  
		  $('#showTehsil').css('display', 'block'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none'); 
	   }
	   if(val=="District Superintendent Vaccinator"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="Storekeeper"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="Dataentry"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="select"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
   }
   //
    //
   /****************code to disable stRTS HERE***********/
$(document).on('change','#status',function(){
var status= $('#status').val();
if(status=='Transfered')
{
		$('#myCoolForm').prop('disabled', true);
		$('#save').prop('disabled', true);
}
else if(status=='post')
{
		$('#myCoolForm').prop('disabled', true);
		$('#save').prop('disabled', true);
}
else
{
	$('#myCoolForm').prop('disabled', false);
        $('#save').prop('disabled', false);
}
});
           /* * POST TYPE */
		$(document).on('change','#post_type',function(){
var post_type= $('#post_type').val();
if(post_type=='Storekeeper')
{
		$('#myCoolForm').prop('disabled', false);
		$('#save').prop('disabled', false);
			$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');
}
 else if(post_type=='DataEntry')
{
		$('#myCoolForm').prop('disabled', false);
		$('#save').prop('disabled', false);
			$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');
}
else  if(post_type=='EpiTechnician')
{
		$('#myCoolForm').prop('disabled', false);
		$('#save').prop('disabled', false);
}
else if(post_type=='District Superintendent Vaccinator')
{
        $('#myCoolForm').prop('disabled', false);
		$('#save').prop('disabled', false);	
			$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');
}
else if(post_type=='Tehsil Superintendent Vaccinator')
{
        $('#myCoolForm').prop('disabled', false);
		$('#save').prop('disabled', false);	
			$('#showTehsil').css('display', 'yes'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');
}
else{
	 $('#myCoolForm').prop('disabled', true);
		$('#save').prop('disabled', true);	
			$('#showTehsil').css('display', 'yes'); 
		    $('#showFacility').css('display', 'yes'); 
			$('#showUnc').css('display', 'yes');
}
});
   //
   
   $(document).on('change','#newfacode',function(){
    if (buttonsDisable($(this).val())) {
		/* if($(this).val().length===0){
		$('#myCoolForm').prop('disabled', true);
        $('#save').prop('disabled', true);
		}
		else
		{ */
		$('#myCoolForm').prop('disabled', false);
        $('#save').prop('disabled', false);
		//}
    } else {
		$('#myCoolForm').prop('disabled', true);
        $('#save').prop('disabled', true);
    }
});
function buttonsDisable(e) {
    if (e > 0) {
        return true;
    } else {
        return false
    }
}
//////////////////////////////////////////////////////////////////////////////////
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
        </script>