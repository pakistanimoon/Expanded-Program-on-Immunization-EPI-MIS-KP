<!--start of page content or body beta-->

 <div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update District Surveillance Officer Form
        </div>
         <div class="panel-body">
    <form id="dataform" action="<?php echo base_url(); ?>System_setup/dsodb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
	 <input type="hidden" name="previous_code" id="previous_code"  value="<?php echo $dsodata['previous_code']; ?>"  class="form-control "/> 
     <div class="form-group">         
  <div class="row">
 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District </label>
                  <div class="col-xs-3">
                 
					 <p><?php echo $dsodata['districtname']; ?></p>
                       <!-- <label class="control-label"  for = "distcode" >?php echo $dsodata['districtname']; ?></label> --->
                        <input type="hidden" name="distcode" id="distcode"  value="<?php echo $dsodata['distcode']; ?>"  class="form-control "/>
                    </div> 
                 
                <!--<label class="col-xs-2 control-label"  for = "tcode" > Tehsil </label>
                  <div class="col-xs-3">
                    <select id="tcode" name="tcode" class="form-control" size="1" >
                      <?php 
                      foreach($resultTeh as $row){
                        ?>
                        <option <?php ($dsodata['tcode'] == $row['tcode'] ? 'selected="selected"' : '') ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
          </div>
          <div class="row">
				<label class="col-xs-2 control-label" >  Health Facility Name</label>
                  <div class="col-xs-3">
                    <select id="facode" name="facode" class="form-control" size="1" >
						<option value="">Select Health Facility</option>
						<?php 
						 foreach($resultFac as $row){
						  ?>
						 
						   <option value="<?php echo $row['facode'];?>"  <?php if($dsodata['facode'] == $row['facode'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /> <?php echo $row['fac_name'];?>
							<?php
						  }
						  ?>
						</select>
                  </div>-->
                  <!--<label class="col-xs-2 control-label"  for = "dsocode" >  District Surveillance Officer Code </label>-->
                <div class="col-xs-3">
                <label  hidden class="control-label"  for = "dsocode" ><?php echo $dsodata['dsocode']; ?></label>
                  <input type="hidden" required name="dsocode" id="dsocode" placeholder="District Surveillance Officer Code"  value="<?php echo $dsodata['dsocode']; ?>"  class="form-control "/>
                  <input type="hidden" required name="facode" id="facode" value="<?php echo $dsodata['facode']; ?>" />
                </div>
          </div>
              <div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "dsoname" > Name </label>
                <div class="col-xs-3">
                  <input type="text" required name="  dsoname" id="dsoname" placeholder="District Surveillance Officer Name"  value="<?php if(validation_errors() != false) { echo set_value('dsoname'); } else { echo $dsodata['dsoname']; } ?>"  class="form-control "/><?php echo form_error('dsoname'); ?>
                </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                  <div class="col-xs-3">
                  <input type="text"  name="fathername" id="fathername" placeholder="Father Name"  value="<?php if(validation_errors() != false) { echo set_value('fathername'); } else { echo $dsodata['fathername']; } ?>"  class="form-control "/><?php echo form_error('fathername'); ?>
</div>
                  </div>
</div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
              <div class="form-group">
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Marital Status </label>
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                           <option <?php if($dsodata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($dsodata['marital_status'] == 'Single') { echo 'selected="selected"'; } else { echo ''; } ?> value="Single">Single</option>
                    </select>
                  </div>
                  <label class="col-xs-2 control-label"  for = "nic" >Cell Phone Number </label>
                  <div class="col-xs-3">
                     <input  name="phone" id="cellphone" placeholder="Cell Phone Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('phone'); } else { echo $dsodata['phone']; } ?>"/><?php echo form_error('phone'); ?>
                  </div>
                  </div>
                   <div class="form-group">
            
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" >Landline Phone Number </label>
                  <div class="col-xs-3">
                     <input  name="telephone" id="telephone" placeholder="Landline Phone Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('telephone'); } else { echo $dsodata['telephone']; } ?>"/><?php echo form_error('telephone'); ?>
                  </div>
                  </div>
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" > CNIC # </label>
                  <div class="col-xs-3">
                    <input required name="  nic" id="nic" placeholder="Enter Your CNIC #"  value="<?php if(validation_errors() != false) { echo set_value('nic'); } else { echo $dsodata['nic']; } ?>"  class="form-control "/><span id="site_response"></span><?php echo form_error('nic'); ?>
</div>
                  <label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  value="<?php echo isset($dsodata['date_of_birth']) ? date('d-m-Y', strtotime($dsodata['date_of_birth'])) : '';?>"  class="form-control "/><?php echo form_error('date_of_birth'); ?>
 </div>
                  </div>
                  </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
                <div class="form-group">
                 <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address </label>
                      <div class="col-xs-3">
                         <input type="text"  name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  value="<?php if(validation_errors() != false) { echo set_value('permanent_address'); } else { echo $dsodata['permanent_address']; } ?>"  class="form-control "/><?php echo form_error('permanent_address'); ?>
                </div>
                      <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  present_address" id="present_address" placeholder="Present Address"  value="<?php if(validation_errors() != false) { echo set_value('present_address'); } else { echo $dsodata['present_address']; } ?>"  class="form-control "/><?php echo form_error('present_address'); ?>
</div>
                      </div>
<div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label> 
                      <div class="col-xs-3">
                         <select name="lastqualification" id="lastqualification" class="form-control">
                     <option <?php if($dsodata['lastqualification'] == 'Matric') { echo 'selected="selected"'; }else echo ''; ?> value="Matric">Matric</option>
                      <option <?php if($dsodata['lastqualification'] == 'FA') { echo 'selected="selected"'; }else echo ''; ?> value="FA">F.A/F.Sc</option>
                      <option <?php if($dsodata['lastqualification'] == 'BA') { echo 'selected="selected"'; }else echo ''; ?> value="BA">B.A/B.Sc/B.Ed</option>
                      <option <?php if($dsodata['lastqualification'] == 'MA') { echo 'selected="selected"'; }else echo ''; ?> value="MA">M.A/M.Sc/M.Ed</option>
					  <option <?php if($dsodata['lastqualification'] == 'BBA/MBA') { echo 'selected="selected"'; }else echo ''; ?> value="BBA/MBA">BBA/MBA</option>
                      <option <?php if($dsodata['lastqualification'] == 'Diploma') { echo 'selected="selected"'; }else echo ''; ?> value="Diploma">Diploma</option>
                       <option <?php if($dsodata['lastqualification'] == 'MBBS') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS">MBBS</option>
					  <option <?php if($dsodata['lastqualification'] == 'MBBS,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MBBS,MPH">MBBS,MPH</option>
					  <option <?php if($dsodata['lastqualification'] == 'MD') { echo 'selected="selected"'; }else echo ''; ?> value="MD">MD</option>
					  <option <?php if($dsodata['lastqualification'] == 'MD,MPH') { echo 'selected="selected"'; }else echo ''; ?> value="MD,MPH">MD,MPH</option>
					   <option <?php if($dsodata['lastqualification'] == 'SE') { echo 'selected="selected"'; } else { echo ''; } ?> value="SE">Software Engineering</option>
                    </select>
                      </div>
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
                      <div class="col-xs-3">
                       <input type="text"  name="  passingyear" id="passingyear" placeholder="Passing Out Year"  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $dsodata['passingyear']; } ?>"  class="form-control "/><?php echo form_error('passingyear'); ?>
</div>
                      </div>
<div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
                      <div class="col-xs-3">
                          <input type="text"  name="  institutename" id="institutename" placeholder="Institute Name"  value="<?php if(validation_errors() != false) { echo set_value('institutename'); } else { echo $dsodata['institutename']; } ?>"  class="form-control "/>
  </div>
                    </div>
                 </div>
    <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
 <div class="form-group">    
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date Of Joining </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  date_joining" id="date_joining" placeholder="Date Of Joining"  value=" <?php if(validation_errors() != false) { echo set_value('date_joining'); } else { echo isset($dsodata['date_joining']) ? date('d-m-Y', strtotime($dsodata['date_joining'])) : ''; } ?>" class="form-control "/>
</div>
                      <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php if(validation_errors() != false) { echo set_value('place_of_joining'); } else { echo $dsodata['place_of_joining']; } ?>"  class="form-control "/>
</div>
                      </div>
	<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "employee_type" > Employee Type </label>
				<div class="col-xs-3">
					<select id="employee_type" name="employee_type" class="form-control" size="1" >
						<option value="Contract" <?php if($dsodata['employee_type'] == 'Contract') { echo 'selected="selected"'; }else echo ''; ?> <?php echo set_select('employee_type', 'Contract', TRUE); ?>>Contract</option>
						<option value="Regular" <?php if($dsodata['employee_type'] == 'Regular') { echo 'selected="selected"'; }else echo ''; ?>  <?php echo set_select('employee_type', 'Regular'); ?>>Regular </option>
						<option value="Contingent" <?php if($dsodata['employee_type'] == 'Contingent') { echo 'selected="selected"'; }else echo ''; ?>  <?php echo set_select('employee_type', 'Contingent'); ?>>Contingent </option>
					</select>
					</div>
				
				</div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
                      <div class="col-xs-3">
                        <select id="status" name="status" class="form-control" size="1" >
                      <option <?php if($dsodata['status'] == 'Active') { echo 'selected="selected"'; }else echo ''; ?> value="Active">Active</option>
                        <option <?php if($dsodata['status'] == 'Terminated') { echo 'selected="selected"'; }else echo ''; ?>  value="Terminated">Terminated</option>
                        <option <?php if($dsodata['status'] == 'Died') { echo 'selected="selected"'; }else echo ''; ?>  value="Died">Died</option>
                        <option <?php if($dsodata['status'] == 'Retired') { echo 'selected="selected"'; }else echo ''; ?>  value="Retired">Retired</option>
                        <option <?php if($dsodata['status'] == 'On Leave') { echo 'selected="selected"'; }else echo ''; ?>  value="On Leave">On Leave</option>
					<!---	<option ?php if($dsodata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>	--->
						<?php if($dsodata['previous_table']==NULL){?>
						<option <?php if($dsodata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>	
						<?php }else{} ?> 
						<?php if($dsodata['previous_table']!=NULL){?>
						<option value="Post Back">Post-Back</option>
						<?php }else{} ?>
					  </select>
                      </div>
					   <div class="showTerminated" id="showTerminated" style="display: none;">
                      <label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                          <input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value=" <?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($dsodata['date_termination']) ? date('d-m-Y', strtotime($dsodata['date_termination'])) : ''; } ?>"  class="form-control "/>
					</div>
					</div>
					<div class="showRetired" id="showRetired" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($dsodata['date_retired']) ? date('d-m-Y', strtotime($dsodata['date_retired'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showDied" id="showDied" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Died </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($dsodata['date_died']) ? date('d-m-Y', strtotime($dsodata['date_died'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showTransfer" id="showTransfer" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Transfered </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value=" <?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($dsodata['date_transfer']) ? date('d-m-Y', strtotime($dsodata['date_transfer'])) : ''; } ?>"/>
					</div>
					</div>
						 <div class="showpostoption" id="showpostoption" style="display: none;">
                   <label class="col-xs-2 control-label"  for = "showpostoption" > Posted As</label>
                    <div class="col-xs-3">
					<select id="post_type" name="post_type" class=  "form-control" size="1" onchange="suptype(this.value)" >
                    <option value="select">Select Post</option>
					<!--- All post-Back Function and Names --->
		 <?php if($dsodata['previous_table']==NULL):?>	
					<option value="Tehsil Superintendent Vaccinator">TSV</option>
					<option value="Field Superintendent Vaccinator">FSV</option>
					<option value="District Superintendent Vaccinator">DSV</option>	
					<!---<option value="deodb">Data entry operator</option>	--->
		   <?php else:?>
					<?php if($dsodata['previous_table']=='dsodb'){?>
					<option value="dsodb">District Surveillance Officer</option> 
					<?php } ?>		
					<?php if($dsodata['previous_table']=='codb'){?>				 					 
					<option value="codb">Computer Operator</option>  
					<?php } ?>			
					<?php if($dsodata['previous_table']=='mfpdb'){?>			 
					<option value="mfpdb">Measles Focal Person</option>	
					<?php } ?>
					<?php if($dsodata['previous_table']=='med_techniciandb'){?>						 			 
					<option value="med_techniciandb">HF Incharges</option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='skdb'){?>					 
					<option value="skdb">Storekeeper</option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='techniciandb'){?>					 
					<option value="techniciandb">EPI Technician</option>	
					<?php } ?>	
					<?php if($dsodata['previous_table']=='cc_techniciandb'){?>					 	 
					<option value="cc_techniciandb">Cold Chain Technician </option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='cco_db'){?>					 	
					<option value="cco_db">Cold Chain Operator</option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='go_db'){?>					 						
					<option value="go_db">Generator Operator</option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='cc_mechanic'){?>					  					 
					<option value="cc_mechanic">Cold Chain Mechanic </option>
					<?php } ?>	
					<?php if($dsodata['previous_table']=='driverdb'){?>					 
					<option value="driverdb">Driver</option> 
					<?php } ?>
			<?php endif;?>	
					</select>
					</div>
					</div>
					<div class="showLeave" id="showLeavefrom" style="display: none;">
					<label class="col-xs-2   control-label"  for = "date_termination" > Date From </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_from" id="date_from" placeholder="Date From"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_from'); } else { echo isset($dsodata['date_from']) ? date('d-m-Y', strtotime($dsodata['date_from'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showLeave" id="showLeaveto" style="display: none;">
					<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date To </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_to'); } else { echo isset($dsodata['date_to']) ? date('d-m-Y', strtotime($dsodata['date_to'])) : ''; } ?>"/>
					</div>
					</div>
        </div>
</div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>
	<div class="form-group">
							 <div class="row">
								<div class="col-xs-3 col-xs-offset-1 control-label">
								  <label>Training</label>
								</div>
								<div class="col-xs-3 control-label">
								  <label>Start Date</label>
								</div>
								<div class="col-xs-3 control-label">
								  <label>End Date</label>
								</div>
							  </div>
							  <hr>
							  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="tenmonth_training_start_date"> Basic Training </label>
           <div class="col-xs-3">
		    <input type="text"  name="basic_training_start_date" id="basic_training_start_date" placeholder="Basic Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('basic_training_start_date'); } else { echo isset($dsodata['basic_training_start_date']) ? date('d-m-Y', strtotime($dsodata['basic_training_start_date'])) : ''; } ?>"  class="form-control "/>
            </div>
           <div class="col-xs-3">
            <input type="text"  name="basic_training_end_date" id="basic_training_end_date" placeholder="Basic Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('basic_training_end_date'); } else { echo isset($dsodata['basic_training_end_date']) ? date('d-m-Y', strtotime($dsodata['basic_training_end_date'])) : ''; } ?>"  class="form-control "/>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
         <input type="text"  name="routine_epi_start_date" id="routine_epi_start_date" placeholder="Routine EPI Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('routine_epi_start_date'); } else { echo isset($dsodata['routine_epi_start_date']) ? date('d-m-Y', strtotime($dsodata['routine_epi_start_date'])) : ''; } ?>"  class="form-control "/>        </div>
           <div class="col-xs-3">
           <input type="text"  name="routine_epi_end_date" id="routine_epi_end_date" placeholder="Routine EPI Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('routine_epi_end_date'); } else { echo isset($dsodata['routine_epi_end_date']) ? date('d-m-Y', strtotime($dsodata['routine_epi_end_date'])) : ''; } ?>"  class="form-control "/>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance_training_start_date"> Surveillance </label>
           <div class="col-xs-3">
           <input type="text"  name="survilance_training_start_date" id="survilance_training_start_date" placeholder="Survilance Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('survilance_training_start_date'); } else { echo isset($dsodata['survilance_training_start_date']) ? date('d-m-Y', strtotime($dsodata['survilance_training_start_date'])) : ''; } ?>"  class="form-control "/>        </div>
           <div class="col-xs-3">
            <input type="text"  name="survilance_training_end_date" id="survilance_training_end_date" placeholder="Survilance Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('survilance_training_end_date'); } else { echo isset($dsodata['survilance_training_end_date']) ? date('d-m-Y', strtotime($dsodata['survilance_training_end_date'])) : ''; } ?>"  class="form-control "/>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain_training_start_date"> Cold Chain </label>
           <div class="col-xs-3">
          <input type="text"  name="cold_chain_training_start_date" id="cold_chain_training_start_date" placeholder="Cold Chain Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('cold_chain_training_start_date'); } else { echo isset($dsodata['cold_chain_training_start_date']) ? date('d-m-Y', strtotime($dsodata['cold_chain_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
            <input type="text"  name="cold_chain_training_end_date" id="cold_chain_training_end_date" placeholder="Cold Chain Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('cold_chain_training_end_date'); } else { echo isset($dsodata['cold_chain_training_end_date']) ? date('d-m-Y', strtotime($dsodata['cold_chain_training_end_date'])) : ''; } ?>"  class="form-control "/>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis_training_start_date"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
           <input type="text"  name="vlmis_training_start_date" id="vlmis_training_start_date" placeholder="vLMIS/EPI-MIS Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('vlmis_training_start_date'); } else { echo isset($dsodata['vlmis_training_start_date']) ? date('d-m-Y', strtotime($dsodata['vlmis_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
            <input type="text"  name="vlmis_training_end_date" id="vlmis_training_end_date" placeholder="vLMIS/EPI-MIS Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('vlmis_training_end_date'); } else { echo isset($dsodata['vlmis_training_end_date']) ? date('d-m-Y', strtotime($dsodata['vlmis_training_end_date'])) : ''; } ?>"  class="form-control "/>         </div>
          </div>
		  <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis_training_start_date"> EPI-MIS </label>
           <div class="col-xs-3">
            <input type="text"  name="epimis_training_start_date" id="epimis_training_start_date" placeholder="EPI-MIS Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('epimis_training_start_date'); } else { echo isset($dsodata['epimis_training_start_date']) ? date('d-m-Y', strtotime($dsodata['epimis_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
           <input type="text"  name="epimis_training_end_date" id="epimis_training_end_date" placeholder="EPI-MIS Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('epimis_training_end_date'); } else { echo isset($dsodata['epimis_training_end_date']) ? date('d-m-Y', strtotime($dsodata['epimis_training_end_date'])) : ''; } ?>"  class="form-control "/>          </div>
          </div>-->
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
				  <option value="<?php echo $row['bankid'];?>"  <?php if($dsodata['bid'] == $row['bankid'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $dsodata['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $dsodata['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $dsodata['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
		<div class="col-xs-3">
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option <?php if($dsodata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
						</select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			<input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $dsodata['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
			</div>
 
<input type="hidden" name="edit" value="edit "/>
                      <div class="row">
                       <div class="col-xs-11" style="padding:0px; text-align:right;">
                        <button type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save  </button>
						<!---<button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit  </button>--->
                        <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
                        <a href="<?php echo base_url();?>DSOList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
</div>
                    </div>
            </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
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
	
	if (selected == 'Temporary-Post') { 
			$('#showTransfer').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none');
            $('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');			
            $('#showpostoption').css('display', 'none');
            $('#showFacility').css('display', 'none'); 
			$('#showTehsil').css('display', 'none');
			$('#showUnc').css('display', 'none'); 
            $('#new_distcode').removeAttr('required','required'); 			
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
	   if(val=="codb"){
		  
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
         
            var code = $('#dsocodel').val();
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
			$('#basic_training_end_date').datepicker(options);
			$('#date_from').datepicker(options);
			$('#date_to').datepicker(options);
          });
          $(document).ready(function(){
				$('#bankaccountno').numeric({allow:"-"});
				$('#branchcode').numeric({allow:"-"});
				$('#basicpay').numeric();
				$(":input").inputmask();
				$("#date_of_birth").inputmask("99-99-9999");
				$("#dsocodel").inputmask("99");
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
				$("#date_from").inputmask("99-99-9999");
				$("#date_to").inputmask("99-99-9999");
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
  $(document).on('change','#basic_training_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#basic_training_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#basic_training_end_date').val('__-__-____');
  			$('#basic_training_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#basic_training_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
    $(document).on('change','#routine_epi_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#routine_epi_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#routine_epi_end_date').val('__-__-____');
  			$('#routine_epi_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#routine_epi_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
   $(document).on('change','#survilance_training_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#survilance_training_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#survilance_training_end_date').val('__-__-____');
  			$('#survilance_training_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#survilance_training_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
   $(document).on('change','#cold_chain_training_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#cold_chain_training_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#cold_chain_training_end_date').val('__-__-____');
  			$('#cold_chain_training_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#cold_chain_training_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
  $(document).on('change','#vlmis_training_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#vlmis_training_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#vlmis_training_end_date').val('__-__-____');
  			$('#vlmis_training_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#vlmis_training_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
   $(document).on('change','#epimis_training_end_date', function(){
  		var end_date = $(this).val().split('-');
  		var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
  		var start_date = $('#epimis_training_start_date').val();
  		start_date = start_date.split('-');
  		var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
  		if(startDate > endDate){
  			alert('End Date Must be Greater or Equal than start date.');
  			$('#epimis_training_end_date').val('__-__-____');
  			$('#epimis_training_end_date').css('border-color','red');
  		}
  		else if(startDate <= endDate){
  			$('#epimis_training_end_date').css('border-color','#66AFE9');
  			//alert('No Error'+end_date);
  		}
  });
  $(document).ready(function() {    
    $('#dsoname, #fathername, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
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
   var code = $(dsocode).val();
	if(nic!=''){
	   $.ajax({ 
		type: 'POST',
		data: 'nic='+nic+'&code='+code,
		url: '<?php echo base_url();?>Ajax_calls/checkDsoNic',
		success: function(data){
		 if(data!=''){
		  if(data=='yes'){
			$('#site_response').css('display','block');
			$('#site_response').css('color','red');
			$('#site_response').html('CNIC Already Exist For Another District Surveillance Officer.');
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
///Code For Save Form With Control+S Event//////////////
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
	   if(val=="select"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
   }
// End 
	
        </script>