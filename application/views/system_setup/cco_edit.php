<!--start of page content or body-->
<div class="container bodycontainer">
  <div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
       <?php  echo $this->breadcrumbs->show();?>
     </ol> 
     <div class="panel-heading"> Update Cold Chain Operator Form
     </div>
     <div class="panel-body">
       <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/cco_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit=""> 
<input type="hidden" name="previous_code" id="previous_code" value="<?php echo $codata['previous_code']; ?>" />	   
<input type="hidden" name="distcode" id="distcode" value="<?php echo $codata['distcode']; ?>" />
   <div class="form-group">
                <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "facode" > District </label>
                      <div class="col-xs-3 cmargin5">
                        <span> <?php echo $codata['districtname'];?> </span>
                      </div>
                        <label type="hidden" hidden class="control-label"  for = "ccocode" >Cold Chain Operator Code  </label>
                      <div class="col-xs-3 cmargin5">
                       <label type="hidden" hidden class="col-xs-2 control-label"   for = "ccocode" ><?php echo $codata['cco_code'];?>  </label>
                        <!--<span> <?php echo $codata['go_code'];?> </span>-->
                        <input type="hidden" required name="cco_code" id="cco_code" placeholder="AS Code"  value="<?php echo $codata['cco_code'];?>"  class="form-control "/>
                      </div>
                    </div>
                    <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "asname" > Cold Chain Operator Name </label>
                      <div class="col-xs-3">
                       <input type="text" required name="cco_name" id="cco_name" placeholder="Cold Chain Operator Name"  value="<?php if(validation_errors() != false) { echo set_value('cco_name'); } else { echo $codata['cco_name']; } ?>"  class="form-control "/><?php echo form_error('cco_name'); ?>
                      </div>
                        <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                      <div class="col-xs-3">
                         <input type="text"  name="  fathername" id="fathername" placeholder="Father Name"  value="<?php if(validation_errors() != false) { echo set_value('fathername'); } else { echo $codata['fathername']; } ?>"  class="form-control "/><?php echo form_error('fathername'); ?>
                      </div>
                    </div>
              </div>
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
 <div class="form-group">
                <div class="row">
             <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Date Of Birth</label>
                <div class="col-xs-3">
                  <input type="text"  name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy" value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo isset($codata['date_of_birth']) ? date('d-m-Y', strtotime($codata['date_of_birth'])) : ''; } ?>"  class="form-control "/>
                </div>
                  <label class="col-xs-2 control-label"  for = "facode" > CNIC # </label>
                  <div class="col-xs-3">
                    <input type="text"  name="nic" id="nic" placeholder="Enter Your CNIC #"  value="<?php if(validation_errors() != false) { echo set_value('nic'); } else { echo $codata['nic']; } ?>"  class="form-control "/><?php echo form_error('nic'); ?>
                  </div>
                </div>
                
                <div class="row">
                    <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Phone</label>
                  <div class="col-xs-3">
                    <input type="text"  name="phone" id="phone" placeholder="Phone"  value="<?php if(validation_errors() != false) { echo set_value('phone'); } else { echo $codata['phone']; } ?>"  class="form-control numberclass"/><?php echo form_error('phone'); ?>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Marital Status </label>
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                        <option <?php if($codata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($codata['marital_status'] == 'Un Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Un Married">Un Married</option>
                        <option <?php if($codata['marital_status'] == 'Widow') { echo 'selected="selected"'; } else { echo ''; } ?> value="Widow">Widow</option>
                        <option <?php if($codata['marital_status'] == 'Divorced') { echo 'selected="selected"'; } else { echo ''; } ?> value="Divorced">Divorced</option>
                        <option <?php if($codata['marital_status'] == 'Other') { echo 'selected="selected"'; } else { echo ''; } ?> value="Other">Other</option>
                    </select>
                  </div>
                </div>
               
             
            </div>
			
			<div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; ">Address and Qualification</div>
 <div class="form-group">
 
 <div class="row">
                   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "drivercode" >Permanent Address  </label>
                  <div class="col-xs-3">
                    <input type="text"  name="permanent_address" id="permanent_address" placeholder="Permanent Address "  value="<?php if(validation_errors() != false) { echo set_value('permanent_address'); } else { echo $codata['permanent_address']; } ?>"  class="form-control "/>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Present Address </label>
                  <div class="col-xs-3">
                    <input type="text"  name="present_address" id="present_address" placeholder=" Present Address"  value="<?php if(validation_errors() != false) { echo set_value('present_address'); } else { echo $codata['present_address']; } ?>"  class="form-control "/>
                  </div>
                </div>
                <div class="row">
                 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Postal Code</label>
                  <div class="col-xs-3">
                    <input type="text"  name="postalcode" id="postalcode" placeholder="Postal Code"  value="<?php if(validation_errors() != false) { echo set_value('postalcode'); } else { echo $codata['postalcode']; } ?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "asname" > City </label>
                  <div class="col-xs-3">
                    <input type="text"  name="city" id="city" placeholder="City"  value="<?php if(validation_errors() != false) { echo set_value('city'); } else { echo $codata['city']; } ?>"  class="form-control "/>
                  </div>
                </div>
				
				 <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Area Type</label>
                  <div class="col-xs-3">
                    <select id="area_type" name="area_type" class="form-control" size="1" >
                          <option <?php if($codata['area_type'] == 'Urban') { echo 'selected="selected"'; } else { echo ''; } ?> value="Urban">Urban</option>
                          <option <?php if($codata['area_type'] == 'Rural') { echo 'selected="selected"'; } else { echo ''; } ?> value="Rural">Rural</option> 
                    </select>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Last Qualification </label>
                  <div class="col-xs-3">
                    <select name="lastqualification" id="lastqualification" class="form-control"> 
                         <option <?php if($codata['lastqualification'] == 'Matric') { echo 'selected="selected"'; }else echo ''; ?> value="Matric">Matric</option>
                      <option <?php if($codata['lastqualification'] == 'FA') { echo 'selected="selected"'; }else echo ''; ?> value="FA">F.A/F.Sc</option>
                      <option <?php if($codata['lastqualification'] == 'BA') { echo 'selected="selected"'; }else echo ''; ?> value="BA">B.A/BCS/B.Sc/B.Ed</option>
                      <option <?php if($codata['lastqualification'] == 'MA') { echo 'selected="selected"'; }else echo ''; ?> value="MA">M.A/MCS/M.Sc/M.Ed</option>
					  <option <?php if($codata['lastqualification'] == 'BBA/MBA') { echo 'selected="selected"'; }else echo ''; ?> value="BBA/MBA">BBA/MBA</option>
                      <option <?php if($codata['lastqualification'] == 'Diploma') { echo 'selected="selected"'; }else echo ''; ?> value="Diploma">Diploma</option>
                       <option <?php if($codata['lastqualification'] == 'MBBS') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS">MBBS</option>
					  <option <?php if($codata['lastqualification'] == 'MBBS,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS,MPH">MBBS,MPH</option>
					  <option <?php if($codata['lastqualification'] == 'MD') { echo 'selected="selected"'; }else echo ''; ?> value="MD">MD</option>
					  <option <?php if($codata['lastqualification'] == 'MD,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MD,MPH">MD,MPH</option>
					   <option <?php if($codata['lastqualification'] == 'SE') { echo 'selected="selected"'; } else { echo ''; } ?> value="SE">Software Engineering</option>
                    </select>
                  </div>
              </div>
              <div class="row">
			   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "asname" > Institute Name </label>
                <div class="col-xs-3">
                  <input type="text"  name="institutename" id="institutename" placeholder="Institute Name"  value="<?php if(validation_errors() != false) { echo set_value('institutename'); } else { echo $codata['institutename']; } ?>"  class="form-control "/>
                </div>
                   <label class="col-xs-2 control-label"  for = "fathername" > Passing Year</label>
                <div class="col-xs-3">
                  <input type="text"  name="passingyear" id="passingyear" placeholder="Phone"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $codata['passingyear']; } ?>"  class="form-control "/><?php echo form_error('passingyear'); ?>
                </div>    
              </div>
 
 </div>
     <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
              <div class="form-group">
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "facode" > Date Of Joining </label>
                  <div class="col-xs-3">
                    <input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo isset($codata['date_of_birth']) ? date('d-m-Y', strtotime($codata['date_of_birth'])) : ''; } ?>"/>
                  </div>
                  <label class=" col-xs-2 control-label"  for = "drivercode" >Place of Joining </label>
                  <div class="col-xs-3">
                    <input type="text" name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $codata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                </div>
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "asname" >Place Of Posting</label>
                  <div class="col-xs-3">
                    <input type="text"  name="place_of_posting" id="place_of_posting" placeholder="Place Of Posting"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $codata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Designation </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  designation" id="designation" placeholder="Designation"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $codata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                </div>
				 <div class="row">
				 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Status</label>
                  <div class="col-xs-3">
                    <select id="status" name="status" class="form-control" size="1" >
                            <option <?php if($codata['status'] == 'Active') { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>
                           <!-- <option <?php if($codata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?> value="Transfered">Transfered</option>-->
                            <option <?php if($codata['status'] == 'Terminated') { echo 'selected="selected"'; } else { echo ''; } ?> value="Terminated">Terminated</option>
                            <option <?php if($codata['status'] == 'Died') { echo 'selected="selected"'; } else { echo ''; } ?> value="Died">Died</option>
                            <option <?php if($codata['status'] == 'Retired') { echo 'selected="selected"'; } else { echo ''; } ?> value="Retired">Retired</option>
                            <option <?php if($codata['status'] == 'On Leave') { echo 'selected="selected"'; } else { echo ''; } ?> value="On Leave">On Leave</option>
							<!--- <option ?php if($codata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>	-->
							<?php if($codata['previous_table']==NULL){?>
							<option <?php if($codata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>	
							<?php }else{} ?> 
							<?php if($codata['previous_table']!=NULL){?>
							<option value="Post Back">Post-Back</option>
							<?php }else{} ?>
                    </select>
                  </div>
				   	<div class="showTerminated" id="showTerminated" style="display: none;">
                      <label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                          <input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value="<?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($codata['date_termination']) ? date('d-m-Y', strtotime($codata['date_termination'])) : ''; } ?>"  class="form-control "/>
					</div>
					</div>
					<div class="showRetired" id="showRetired" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($codata['date_retired']) ? date('d-m-Y', strtotime($codata['date_retired'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showDied" id="showDied" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Died </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($codata['date_died']) ? date('d-m-Y', strtotime($codata['date_died'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showTransfer" id="showTransfer" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Transfered </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($codata['date_transfer']) ? date('d-m-Y', strtotime($codata['date_transfer'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showpostoption" id="showpostoption" style="display: none;">
                   <label class="col-xs-2 control-label"  for = "showpostoption" > Posted As</label>
                    <div class="col-xs-3">
							<select id="post_type" name="post_type" class=  "form-control" size="1" onchange="suptype(this.value)" >
					<!--- All post-Back Function and Names --->
		 <?php if($codata['previous_table']==NULL):?>	
					<option value="Tehsil Superintendent Vaccinator">TSV</option>
					<option value="Field Superintendent Vaccinator">FSV</option>
					<option value="District Superintendent Vaccinator">DSV</option>	 					 
					<option value="dsodb">District Surveillance Officer</option> 					 
					<option value="codb">Computer Operator</option>  
					<option value="mfpdb">Measles Focal Person</option>				 
					<option value="med_techniciandb">HF Incharges</option>
					<option value="skdb">Storekeeper</option>
					<option value="techniciandb">EPI Technician</option>		 
					<option value="cc_techniciandb">Cold Chain Technician </option>
					<!---<option value="deodb">Data entry operator</option>	--->
		   <?php else:?>
					<?php if($codata['previous_table']=='dsodb'){?>
					<option value="dsodb">District Surveillance Officer</option> 
					<?php } ?>		
					<?php if($codata['previous_table']=='codb'){?>				 					 
					<option value="codb">Computer Operator</option>  
					<?php } ?>			
					<?php if($codata['previous_table']=='mfpdb'){?>			 
					<option value="mfpdb">Measles Focal Person</option>	
					<?php } ?>
					<?php if($codata['previous_table']=='med_techniciandb'){?>						 			 
					<option value="med_techniciandb">HF Incharges</option>
					<?php } ?>	
					<?php if($codata['previous_table']=='skdb'){?>					 
					<option value="skdb">Storekeeper</option>
					<?php } ?>	
					<?php if($codata['previous_table']=='techniciandb'){?>					 
					<option value="techniciandb">EPI Technician</option>	
					<?php } ?>	
					<?php if($codata['previous_table']=='cc_techniciandb'){?>					 	 
					<option value="cc_techniciandb">Cold Chain Technician </option>
					<?php } ?>	
					<?php if($codata['previous_table']=='cco_db'){?>					 	
					<option value="cco_db">Cold Chain Operator</option>
					<?php } ?>	
					<?php if($codata['previous_table']=='go_db'){?>					 						
					<option value="go_db">Generator Operator</option>
					<?php } ?>	
					<?php if($codata['previous_table']=='cc_mechanic'){?>					  					 
					<option value="cc_mechanic">Cold Chain Mechanic </option>
					<?php } ?>	
					<?php if($codata['previous_table']=='driverdb'){?>					 
					<option value="driverdb">Driver</option> 
					<?php } ?>
			<?php endif;?>	
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
                          <select id="new_facode" name="new_facode" class="form-control" size="1">
						          <option value="select">Select HF Facility</option>
						          
						  </select>
					</div>
					</div>
					<div class="showLeave" id="showLeavefrom" style="display: none;">
					<label class="col-xs-2   control-label"  for = "date_termination" > Date From </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_from" id="date_from" placeholder="Date From"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_from'); } else { echo isset($codata['date_from']) ? date('d-m-Y', strtotime($codata['date_from'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showLeave" id="showLeaveto" style="display: none;">
					<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date To </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_to'); } else { echo isset($codata['date_to']) ? date('d-m-Y', strtotime($codata['date_to'])) : ''; } ?>"/>
					</div>
					</div>
				  
              </div>
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Employee Type</label>
                  <div class="col-xs-3">
                    <select id="employee_type" name="employee_type" class="form-control" size="1" >
                          <option <?php if($codata['employee_type'] == 'Contract') { echo 'selected="selected"'; } else { echo ''; } ?> value="Contract">Contract</option>
                          <option <?php if($codata['employee_type'] == 'Permanent') { echo 'selected="selected"'; } else { echo ''; } ?> value="Permanent">Permanent</option> 
                    </select>
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
				  <option value="<?php echo $row['bankid'];?>"  <?php if($codata['bid'] == $row['bankid'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $codata['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $codata['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $codata['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
		<div class="col-xs-3">
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option <?php if($codata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
																			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			<input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $codata['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
</div>
            <hr>
<input type="hidden" name="edit" value="edit">
            <div class="row">
             <div class="col-xs-11" style="padding:0px; text-align:right;">
               <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save </button>
			  <!---<button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit </button>--->
               <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset</button>
               <a href="<?php echo base_url();?>Cold-Chain-Operator/List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
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
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none'); 			
	}
    if (selected == 'Terminated') {  
			$('#showTerminated').css('display', 'block');
			$('#showRetired').css('display', 'none'); 
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 	
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
			}
	if (selected == 'Died') { 
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'block'); 			
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
	if (selected == 'Retired') { 
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 			
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
	if (selected == 'Transfered') { 
			$('#showTransfer').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 			
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
	if (selected == 'post') { 
 //alert(1);
			$('#post_type').css('display', 'block');
			$('#showTransfer').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 
			$('#showpostoption').css('display', 'block');
            $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none');   
             //
            $('#newFac').css('display', 'none');
			$('#showUnc').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tcode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#date_transfer').removeAttr('required','required'); 
     		$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
		if (selected == 'On Leave') { 
			$('#showTransfer').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 			
			$('#showLeavefrom').css('display', 'block');
			$('#showLeaveto').css('display', 'block');
	}
	
	if (selected == 'Post Back') { 
		   $('#post_type').css('display', 'block');
		   $('#showTransfer').css('display', 'none');
		   $('#showResigned').css('display', 'none');
		   $('#showReason').css('display', 'none');
		   $('#showLeavefrom').css('display', 'none');			
		   $('#showLeaveto').css('display', 'none');
		   $('#showTerminated').css('display', 'none');
		   $('#showRetired').css('display', 'none');
		   $('#showDied').css('display', 'none'); 
		   $('#showpostoption').css('display', 'block');
		   $('#showFacility').css('display', 'none'); 
		   $('#showTehsil').css('display', 'none');
		   $('#showUnc').css('display', 'none');   
		   $('#newFac').css('display', 'none');
		   $('#showUnc').css('display', 'none');
		   $('#new_distcode').removeAttr('required','required');
		   $('#new_tcode').removeAttr('required','required');
		   $('#new_uncode').removeAttr('required','required');
		   $('#new_facode').removeAttr('required','required');
		   $('#new_facode').removeAttr('required','required');
		   $('#date_transfer').removeAttr('required','required');   	
			
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
            var options = {
              format : "dd-mm-yyyy"
            };
            $('#date_joining').datepicker(options);
            });
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
            $('#date_joining').datepicker(options);
			 $('#date_termination').datepicker(options);
			$('#date_transfer').datepicker(options);
			$('#date_retired').datepicker(options);
			$('#date_died').datepicker(options);
			$('#date_from').datepicker(options);
			$('#date_to').datepicker(options);
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
			$("#date_from").inputmask("99-99-9999");
			$("#date_to").inputmask("99-99-9999");
});
$(document).ready(function() {    
    $('#coname, #fathername, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
        var $this = $(this),
            val = $this.val();
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
		url: '<?php echo base_url();?>Ajax_calls/checkccoNIC',
		success: function(data){
		 if(data!=''){
		  if(data=='yes'){
			$('#site_response').css('display','block');
			$('#site_response').css('color','red');
			$('#site_response').html('CNIC Already Exist For Another Account Supervisor.');
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
//////////////////////////////////////////////////////////////////////////////////
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
	
	
// For Post As dropdown
function suptype(val){
	   
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
	   if(val=="dsodb"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="codb"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="mfpdb"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="med_techniciandb"){
		  	$('#showTehsil').css('display', 'block'); 
		    $('#showFacility').css('display', 'block'); 
			$('#showUnc').css('display', 'block');  
	   }
	   if(val=="skdb"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="techniciandb"){
		  	$('#showTehsil').css('display', 'block'); 
		    $('#showFacility').css('display', 'block'); 
			$('#showUnc').css('display', 'block');  
	   }
	   if(val=="cc_techniciandb"){
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
// End 
		
        </script>