 <!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update EPI Technician Form
        </div>
         <div class="panel-body">
 <form id="dataform" action="<?php echo base_url(); ?>System_setup/technician_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
 <input type="hidden" name="previous_code" id="previous_code" value="<?php echo $techniciandata['previous_code']; ?>" />
         <input type="hidden" name="facode" id="facode" value="<?php echo $techniciandata['facode']; ?>" />
		  <div class="form-group">         
  <div class="row">
 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District </label>
                 <div class="col-xs-3">
          <p><?php echo $techniciandata['districtname']; ?></p>
          <input type="hidden" name="distcode" id="distcode"  value="<?php echo $techniciandata['distcode']; ?>"  class="form-control "/>
      </div>
              <label class="col-xs-2 control-label"  for = "tcode" > Tehsil </label>
                   <div class="col-xs-3">
                    <p><?php echo $techniciandata['tehsilname']; ?></p>
                    <input type="hidden" name="tcode" id="tcode"  value="<?php echo $techniciandata['tcode']; ?>"  class="form-control "/>
                    <!-- <input type="text" disabled="disabled" class="form-control" value="<?php echo $techniciandata['tehsilname']; ?>" />-->
                  </div>
          </div>
          <div class="row">
				<label class="col-xs-2  col-xs-offset-1 control-label" >  EPI Center Name</label>
                  <div class="col-xs-3">
                    <input type="text" disabled="disabled" class="form-control" value="<?php echo $techniciandata['facilityname']; ?>" />
                  </div>
                  <!--<label class="col-xs-2 control-label"  for = "lhscode" >  Technician Code </label>-->
                <div class="col-xs-3">
                  <label type="hidden" hidden class="control-label"  for = "techniciancode" ><?php echo $techniciandata['techniciancode']; ?></label>
                  <input type="hidden" required name="techniciancode" id="techniciancode" placeholder="Technician Code"  value="<?php echo $techniciandata['techniciancode']; ?>"  class="form-control "/>
                  <input type="hidden" required name="facode" id="facode" value="<?php echo $techniciandata['facode']; ?>" />
                </div>
          </div>
              <div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhsname" > Technician Name </label>
                <div class="col-xs-3">
                  <input type="text" required name="  technicianname" id="technicianname" placeholder="Technician Name"  value="<?php if(validation_errors() != false) { echo set_value('technicianname'); } else { echo $techniciandata['technicianname']; } ?>"  class="form-control "/><?php echo form_error('technicianname'); ?>
                </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                  <div class="col-xs-3">
                  <input type="text"  name="fathername" id="fathername" placeholder="Father Name"  value="<?php if(validation_errors() != false) { echo set_value('fathername'); } else { echo $techniciandata['fathername']; } ?>"  class="form-control "/><?php echo form_error('fathername'); ?>
</div>
                  </div>
				 
</div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
              <div class="form-group">
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Marital Status</label>
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                        <option <?php if($techniciandata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($techniciandata['marital_status'] == 'Single') { echo 'selected="selected"'; } else { echo ''; } ?> value="Single">Single</option>
                      
                    </select>
                  </div>
                  <label class="col-xs-2 control-label"  for = "nic" >Phone Number </label>
                  <div class="col-xs-3">
                     <input type="text" name="phone" id="phone" placeholder="Phone Number"  class="form-control numberclass" value="<?php if(validation_errors() != false) { echo set_value('phone'); } else { echo $techniciandata['phone']; } ?>"/><?php echo form_error('phone'); ?>
 </div>
                  </div>
                  <div class="row">
				   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" > CNIC # </label>
                <div class="col-xs-3">
                  <input required name="nic" id="nic" placeholder="Enter Your CNIC #"  value="<?php if(validation_errors() != false) { echo set_value('nic'); } else { echo $techniciandata['nic']; } ?>"  class="form-control "/><span id="site_response"></span>
                </div>
                   <label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth </label>
                <div class="col-xs-3">
                  <input type="text" name="  date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  value="<?php if(validation_errors() != false) { echo set_value('date_of_birth'); } else { echo isset($techniciandata['date_of_birth']) ? date('d-m-Y', strtotime($techniciandata['date_of_birth'])) : ''; } ?>"  class="form-control "/>
                </div>
                  </div>
                  </div>
                <div class="row bgrow"></div>
                <div class="form-group">
                 <div class="row">
                           <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhscode" > Supervisor Name</label>
                  <div class="col-xs-3">
                     <select id="supervisorcode" required name="supervisorcode" class="form-control" size="1" >
                      <?php 
                      foreach($resultSupervisor as $row){
                        ?>
                        <option <?php if($techniciandata['supervisorcode'] == $row['supervisorcode'] ){ echo 'selected="selected"'; } else  { echo ''; } ?> value="<?php echo $row['supervisorcode']; ?>" /><?php echo $row['supervisorname']; ?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                    <!-- <label class="col-xs-2 control-label"  for = "uncode" > Union Council </label>
                  <div class="col-xs-3">
                    <select id="uncode" name="uncode" class="form-control" size="1" >
                      <?php 
                      foreach($resultUnC as $row){
                        ?>
                        <option <?php if($techniciandata['uncode'] == $row['uncode']) { echo 'selected="selected"'; } else{ echo ''; } ?> value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name'];?></option>
                        <?php
                      }
                      ?>
                    </select>
                  </div> -->
                      </div>
<div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "catch_area_name" > Catchment Area Name </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  catch_area_name" id="catch_area_name" placeholder="Catchment Area Name"  value="<?php echo $techniciandata['catch_area_name'];?>"  class="form-control "/>
                  </div>
                      <label class="col-xs-2 control-label"  for = "catch_area_pop" > Catchment Area Population </label>
                  <div class="col-xs-3">
                  <input type="text" required name="catch_area_pop" id="catch_area_pop" placeholder="Catchment Area Population"  value="<?php echo $techniciandata['catch_area_pop'];?>"  class="form-control numberclass"/>
                  </div>
                      </div>

                 </div>
     <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
 <div class="form-group">    
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  value="<?php if(validation_errors() != false) { echo set_value('permanent_address'); } else { echo $techniciandata['permanent_address']; } ?>"  class="form-control "/>
                  </div>
            <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  present_address" id="present_address" placeholder="Present Address"  value="<?php if(validation_errors() != false) { echo set_value('present_address'); } else { echo $techniciandata['present_address']; } ?>"  class="form-control "/>
                  </div>
                      </div>
                      <div class="row">
                       <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label>
                  <div class="col-xs-3">
                    <select name="lastqualification" id="lastqualification" class="form-control">
                     
                      <option <?php if($techniciandata['lastqualification'] == 'Matric') { echo 'selected="selected"'; } else { echo ''; } ?> value="Matric">Matric</option>
                      <option <?php if($techniciandata['lastqualification'] == 'FA') { echo 'selected="selected"'; } else { echo ''; } ?> value="FA">F.A/F.Sc</option>
                      <option <?php if($techniciandata['lastqualification'] == 'BA') { echo 'selected="selected"'; } else { echo ''; } ?> value="BA">B.A/B.Sc/B.Ed</option>
                      <option <?php if($techniciandata['lastqualification'] == 'MA') { echo 'selected="selected"'; } else { echo ''; } ?> value="MA">M.A/M.Sc/M.Ed</option>
					  <option value="BBA/MBA" <?php echo set_select('lastqualification', 'BBA/MBA'); ?>>BBA/MBA</option>
					  <option <?php if($techniciandata['lastqualification'] == 'FA') { echo 'selected="selected"'; } else { echo ''; } ?> value="FA">F.A/F.Sc</option>
					   <option <?php if($techniciandata['lastqualification'] == 'SE') { echo 'selected="selected"'; } else { echo ''; } ?> value="SE">Software Engineering</option>
					  
					  
                    </select>
                  </div> 
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
                  <div class="col-xs-3">
                    <input type="text" name="  passingyear" id="passingyear" placeholder=" Passing Out Year "  value="<?php if(validation_errors() != false) { echo set_value('passingyear'); } else { echo $techniciandata['passingyear']; } ?>"  class="form-control "/>
                  </div>
                     </div>
					 <div class="row">
					  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
                  <div class="col-xs-3">
                    <input type="text" name="  institutename" id="institutename" placeholder="Institute Name"  value="<?php if(validation_errors() != false) { echo set_value('institutename'); } else { echo $techniciandata['institutename']; } ?>"  class="form-control "/>
                  </div>
				  <label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
				<div class="col-xs-3">
					<select id="employee_type" name="employee_type" class="form-control" size="1" >
						<option value="Contract" <?php if($techniciandata['employee_type'] == 'Contract') { echo 'selected="selected"'; }else echo ''; ?> <?php echo set_select('employee_type', 'Contract', TRUE); ?>>Contract</option>
						<option value="Regular" <?php if($techniciandata['employee_type'] == 'Regular') { echo 'selected="selected"'; }else echo ''; ?>  <?php echo set_select('employee_type', 'Regular'); ?>>Regular </option>
						<option value="Contingent" <?php if($techniciandata['employee_type'] == 'Contingent') { echo 'selected="selected"'; }else echo ''; ?>  <?php echo set_select('employee_type', 'Contingent'); ?>>Contingent </option>
					</select>
					</div>
					 </div>
</div>
                   <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
				  	<div class="form-group">
  <div class="row">
               
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date Of Joining </label>
                  <div class="col-xs-3">
                    <input type="text" name="  date_joining" id="date_joining" placeholder="Date Of Joining"  value="<?php if(validation_errors() != false) { echo set_value('date_joining'); } else { echo isset($techniciandata['date_joining']) ? date('d-m-Y', strtotime($techniciandata['date_joining'])) : ''; } ?>"  class="form-control "/>
                  </div>
				    <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
                  <div class="col-xs-3">
                    <input type="text" name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php if(validation_errors() != false) { echo set_value('place_of_joining'); } else { echo $techniciandata['place_of_joining']; } ?>"  class="form-control "/>
                  </div>
                      </div>
  <div class="row">
                      
				   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "areatype" > Area Type </label>
                    <div class="col-xs-3">
                      <div class="">
                        <label class="control-label">
                          &nbsp;<input <?php if($techniciandata['areatype'] == 'rural') { echo 'checked="checked"'; } else { echo ''; } ?>  type="radio" value="rural" name="areatype">Rural
                        </label>&nbsp;
                        <label class="">
                          &nbsp;<input <?php if($techniciandata['areatype'] == 'urban') { echo 'checked="checked"'; } else { echo ''; } ?>   type="radio" value="urban" name="areatype">Urban
                        </label>&nbsp;
                        <label class="">
                          &nbsp;<input <?php if($techniciandata['areatype'] == 'slum') { echo 'checked="checked"'; } else { echo ''; } ?>   type="radio" value="slum" name="areatype">Slum
                        </label>&nbsp;
                        <label class="">
                          &nbsp;<input <?php if($techniciandata['areatype'] == 'semi_urban') { echo 'checked="checked"'; } else { echo ''; } ?>   type="radio" value="semi_urban" name="areatype">Semi Urban
                        </label>
                      </div>
                    </div>
					<label class="col-xs-2 control-label"  for = "status" > Status </label>
                  <div class="col-xs-3">
                    <select id="status" name="status" class="form-control" size="1" >
                      <?php if($techniciandata['status']!='Transfered') {?>
                      <option <?php if($techniciandata['status'] == 'Active') { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>
                        <option <?php if($techniciandata['status'] == 'Terminated') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Terminated">Terminated</option>
                        <option <?php if($techniciandata['status'] == 'Died') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Died">Died</option>
                        <option <?php if($techniciandata['status'] == 'Retired') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Retired">Retired</option>
                        <option <?php if($techniciandata['status'] == 'On Leave') { echo 'selected="selected"'; } else { echo ''; } ?>  value="On Leave">On Leave</option>
                       
					   <option <?php if($techniciandata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Transfered">Transfered</option>
						<!-- <option <?php if($techniciandata['status'] == 'Transfer(Other)') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Transfer">Transfer(Other)</option>-->
						<?php if($techniciandata['previous_table']==NULL){?>
					<option <?php if($techniciandata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>	
					<?php }else{} ?> 
					<?php if($techniciandata['previous_table']!=NULL){?>
						<option value="Post Back">Post-Back</option>
						<?php }else{} ?>
				<!---	?php if($techniciandata['current_status']=='Temporary-Post'){?>
						<option value="post">Temporary-Post</option> 
						?php }else{} ?>  --->
					<?php } else {?>
						<option <?php if($techniciandata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Transfered">Transfered</option>
					<?php } ?>
					</select>
                    </div>
                </div>
				<div class="row">
					<div class="newFac" id="newFac" style="display: none;">
						<label class="col-xs-2 col-xs-offset-1 control-label lbl-search"  for = "facode" >District </label>
						 <div class="col-xs-3">
							<select id="new_distcode" name="new_distcode" required="required" class="form-control" size="1" >
									<option value="">District</option>
									<?php 
									foreach($dists as $row){?>
										<option value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option><?php
									}?>
								</select>
						 </div>
						 <label class="col-xs-2 control-label" for="status">Tehsil</label>
						 <div class="col-xs-3">
							<select id="new_tcode" name="new_tcode" required="required" class="form-control" size="1" >
									<option value="">Select Tehsil</option>
									<?php 
									foreach($resultTeh as $row){?>
										<option value="<?php echo $row['tcode'];?>" ><?php echo $row['tehsil'];?></option><?php
									}?>
								</select>
						 </div>
						 <label class="col-xs-2 col-xs-offset-1 control-label" for="status">Union Council</label>
						 <div class="col-xs-3">
							<select id="new_uncode" name="new_uncode" required="required" class="form-control" size="1" >
									<option value="">Select Uc</option>
									<?php 
									foreach($resultUnC as $row){?>
										<option value="<?php echo $row['uncode'];?>" ><?php echo $row['un_name'];?></option><?php
									}?>
								</select>
						 </div>
							<label class="col-xs-2 control-label" for="status">Facility</label>
							<div class="col-xs-3">
								<select id="new_facode" name="new_facode" required="required" class="form-control" size="1" >
									<option value="">Select Facility</option>
									<?php 
									foreach($resultFac as $row){?>
										<option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option><?php
									}?>
								</select>
							</div>
													 
						<label class="col-xs-2 col-xs-offset-1 control-label"   for = "new_lhwcode" > New Technician Code </label>
						<input type="hidden" name="new_lhwcode" id="new_lhwcode" value="<?php echo set_value('new_lhwcode'); ?>" >
						<div class="col-xs-1 cmargin18">
							<input type="text" disabled="disabled"  class="form-control  right" style="text-align: -webkit-right;" id="new_lhwcodef" value="F.Code" />
						</div>
						<div class="col-xs-2 cmargin19">
							<input type="text" style=" text-align: -webkit-left;" name="new_lhwcodel" id="new_lhwcodel" placeholder="code"  class="form-control " value="<?php echo set_value('new_lhwcodel'); ?>"/>
						</div>
					</div>
                </div>
 <div class="row">
                             
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Reason</label>
                      <div class="col-xs-3">
                       <input type="text"  name="reason" id="reason" placeholder="If Transfer/Terminated than Give Reason"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('reason'); } else { echo $techniciandata['reason']; } ?>"/>
                      </div>
					  <div class="showTerminated" id="showTerminated" style="display: none;">
                      <label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                          <input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value="<?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($techniciandata['date_termination']) ? date('d-m-Y', strtotime($techniciandata['date_termination'])) : ''; } ?>"  class="form-control "/>
					</div>
					</div>
					<div class="showRetired" id="showRetired" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($techniciandata['date_retired']) ? date('d-m-Y', strtotime($techniciandata['date_retired'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showDied" id="showDied" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Died </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($techniciandata['date_died']) ? date('d-m-Y', strtotime($techniciandata['date_died'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showTransfer" id="showTransfer" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_termination" > Date Transfered </label>
					<div class="col-xs-3">
						<input  type="text" required="required"  name="date_transfer"  id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($techniciandata['date_transfer']) ? date('d-m-Y', strtotime($techniciandata['date_transfer'])) : ''; } ?>"/>
					</div>
					</div>
					 <div class="showpostoption" id="showpostoption" style="display: none;">
                   <label class="col-xs-2 control-label"  for = "showpostoption" > Posted As</label>
                    <div class="col-xs-3">
					<select id="post_type" name="post_type" class=  "form-control" size="1" onchange="suptype(this.value)" >
                    <option value="select">Select Post</option>
					<!--- All post-Back Function and Names --->
		 <?php if($techniciandata['previous_table']==NULL):?>	
					<option value="Tehsil Superintendent Vaccinator">TSV</option>
					<option value="Field Superintendent Vaccinator">FSV</option>
					<option value="District Superintendent Vaccinator">DSV</option>	 					 
					<option value="dsodb">District Surveillance Officer</option> 					 
					<option value="codb">Computer Operator</option>  
					<option value="mfpdb">Measles Focal Person</option>				 
					<option value="med_techniciandb">HF Incharges</option>
					<option value="skdb">Storekeeper</option>
					<!---<option value="deodb">Data entry operator</option>	--->
		   <?php else:?>
					<?php if($techniciandata['previous_table']=='dsodb'){?>
					<option value="dsodb">District Surveillance Officer</option> 
					<?php } ?>		
					<?php if($techniciandata['previous_table']=='codb'){?>				 					 
					<option value="codb">Computer Operator</option>  
					<?php } ?>			
					<?php if($techniciandata['previous_table']=='mfpdb'){?>			 
					<option value="mfpdb">Measles Focal Person</option>	
					<?php } ?>
					<?php if($techniciandata['previous_table']=='med_techniciandb'){?>						 			 
					<option value="med_techniciandb">HF Incharges</option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='skdb'){?>					 
					<option value="skdb">Storekeeper</option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='techniciandb'){?>					 
					<option value="techniciandb">EPI Technician</option>	
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='cc_techniciandb'){?>					 	 
					<option value="cc_techniciandb">Cold Chain Technician </option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='cco_db'){?>					 	
					<option value="cco_db">Cold Chain Operator</option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='go_db'){?>					 						
					<option value="go_db">Generator Operator</option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='cc_mechanic'){?>					  					 
					<option value="cc_mechanic">Cold Chain Mechanic </option>
					<?php } ?>	
					<?php if($techniciandata['previous_table']=='driverdb'){?>					 
					<option value="driverdb">Driver</option> 
					<?php } ?>
			<?php endif;?>	
                    </select>
					</div>
					</div>
	                <div class="showTehsil" id="showTehsil" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:110px" for = "showTehsil" >  Tehsil</label>
                      <div class="col-xs-3">
                          <select id="new_tcode" name="new_tcode" class="form-control" size="1">
						          <option value="select">Select Tehsil</option>
						         <?php 
									foreach($resultTeh as $row){?>
										<option value="<?php echo $row['tcode'];?>" ><?php echo $row['tehsil'];?></option><?php
									}?>
						  </select>
					</div>
					</div>
					<div class="showUnc" id="showUnc" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:0px"   for = "showUnc" >  Union Council</label>
                      <div class="col-xs-3">
                          <select id="new_uncode" name="new_uncode" class="form-control" size="1">
						          <option value="select">Select Union Council</option>
						          
						  </select>
					</div>
					</div>
				
					
					 <div class="showFacility" id="showFacility" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:110px"   for = "showTehsil" >  Facility</label>
                      <div class="col-xs-3">
                          <select id="new_facode" name="new_facode" class="form-control" size="1">
						          <option value="select">Select HF Facility</option>
						          
						  </select>
					</div>
					</div>
	             	<div class="showLeave" id="showLeavefrom" style="display: none;">
					<label class="col-xs-2   control-label"  for = "date_termination" > Date From </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_from" id="date_from" placeholder="Date From"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_from'); } else { echo isset($techniciandata['date_from']) ? date('d-m-Y', strtotime($techniciandata['date_from'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showLeave" id="showLeaveto" style="display: none;">
					<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date To </label>
					
					<div class="col-xs-3">
						<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_to'); } else { echo isset($techniciandata['date_to']) ? date('d-m-Y', strtotime($techniciandata['date_to'])) : ''; } ?>"/>
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
		    <input type="text"  name="basic_training_start_date" id="basic_training_start_date" placeholder="Basic Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('basic_training_start_date'); } else { echo isset($techniciandata['basic_training_start_date']) ? date('d-m-Y', strtotime($techniciandata['basic_training_start_date'])) : ''; } ?>"  class="form-control "/>
            </div>
           <div class="col-xs-3">
            <input type="text"  name="basic_training_end_date" id="basic_training_end_date" placeholder="Basic Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('basic_training_end_date'); } else { echo isset($techniciandata['basic_training_end_date']) ? date('d-m-Y', strtotime($techniciandata['basic_training_end_date'])) : ''; } ?>"  class="form-control "/>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
         <input type="text"  name="routine_epi_start_date" id="routine_epi_start_date" placeholder="Routine EPI Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('routine_epi_start_date'); } else { echo isset($techniciandata['routine_epi_start_date']) ? date('d-m-Y', strtotime($techniciandata['routine_epi_start_date'])) : ''; } ?>"  class="form-control "/>        </div>
           <div class="col-xs-3">
           <input type="text"  name="routine_epi_end_date" id="routine_epi_end_date" placeholder="Routine EPI Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('routine_epi_end_date'); } else { echo isset($techniciandata['routine_epi_end_date']) ? date('d-m-Y', strtotime($techniciandata['routine_epi_end_date'])) : ''; } ?>"  class="form-control "/>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance_training_start_date"> Survilance </label>
           <div class="col-xs-3">
           <input type="text"  name="survilance_training_start_date" id="survilance_training_start_date" placeholder="Survilance Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('survilance_training_start_date'); } else { echo isset($techniciandata['survilance_training_start_date']) ? date('d-m-Y', strtotime($techniciandata['survilance_training_start_date'])) : ''; } ?>"  class="form-control "/>        </div>
           <div class="col-xs-3">
            <input type="text"  name="survilance_training_end_date" id="survilance_training_end_date" placeholder="Survilance Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('survilance_training_end_date'); } else { echo isset($techniciandata['survilance_training_end_date']) ? date('d-m-Y', strtotime($techniciandata['survilance_training_end_date'])) : ''; } ?>"  class="form-control "/>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain_training_start_date"> Cold Chain </label>
           <div class="col-xs-3">
          <input type="text"  name="cold_chain_training_start_date" id="cold_chain_training_start_date" placeholder="Cold Chain Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('cold_chain_training_start_date'); } else { echo isset($techniciandata['cold_chain_training_start_date']) ? date('d-m-Y', strtotime($techniciandata['cold_chain_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
            <input type="text"  name="cold_chain_training_end_date" id="cold_chain_training_end_date" placeholder="Cold Chain Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('cold_chain_training_end_date'); } else { echo isset($techniciandata['cold_chain_training_end_date']) ? date('d-m-Y', strtotime($techniciandata['cold_chain_training_end_date'])) : ''; } ?>"  class="form-control "/>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis_training_start_date"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
           <input type="text"  name="vlmis_training_start_date" id="vlmis_training_start_date" placeholder="vLMIS/EPI-MIS Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('vlmis_training_start_date'); } else { echo isset($techniciandata['vlmis_training_start_date']) ? date('d-m-Y', strtotime($techniciandata['vlmis_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
            <input type="text"  name="vlmis_training_end_date" id="vlmis_training_end_date" placeholder="vLMIS/EPI-MIS Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('vlmis_training_end_date'); } else { echo isset($techniciandata['vlmis_training_end_date']) ? date('d-m-Y', strtotime($techniciandata['vlmis_training_end_date'])) : ''; } ?>"  class="form-control "/>         </div>
          </div>
		  <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis_training_start_date"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <input type="text"  name="epimis_training_start_date" id="epimis_training_start_date" placeholder="vLMIS/EPI-MIS Training Start Date"  value=" <?php if(validation_errors() != false) { echo set_value('epimis_training_start_date'); } else { echo isset($techniciandata['epimis_training_start_date']) ? date('d-m-Y', strtotime($techniciandata['epimis_training_start_date'])) : ''; } ?>"  class="form-control "/>         </div>
           <div class="col-xs-3">
           <input type="text"  name="epimis_training_end_date" id="epimis_training_end_date" placeholder="vLMIS/EPI-MIS Training End Date"  value=" <?php if(validation_errors() != false) { echo set_value('epimis_training_end_date'); } else { echo isset($techniciandata['epimis_training_end_date']) ? date('d-m-Y', strtotime($techniciandata['epimis_training_end_date'])) : ''; } ?>"  class="form-control "/>          </div>
          </div>-->
				</div>	

 
      <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
 <div class="form-group">
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information</label>
		<div class="col-xs-3">
			  <select id="bankid" name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>"  <?php if($techniciandata['bid'] == $row['bankid'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $techniciandata['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $techniciandata['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $techniciandata['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
		<div class="col-xs-3">
			<select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option <?php if($techniciandata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
			 </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			<input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $techniciandata['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
													</div>
        
                    <hr>                      
                 <input type="hidden" name="edit" value="edit" />
                      <div class="row">
                            <div class="col-xs-11" style="padding:0px; text-align:right;">
                            <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md col-xs-offset-1 btn-success bc1"><i class="fa fa-floppy-o "></i> Save  </button>
							<!---<button type="submit" name="is_temp_saved" value="0" id="myCoolForm" class="btn btn-md col-xs-offset-1 btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit   </button>--->
                          <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
                          <a href="<?php echo base_url();?>System_setup/technician_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
                    </div>
            </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
<!--
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/ajaxLoader.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
 <script src="<?php echo base_url(); ?>includes/js/vendor/jquery-1.11.0.min.js"></script>
  <script src="<?php echo base_url(); ?>includes/js/vendor/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>includes/js/plugins.js"></script>
  <script src="<?php echo base_url(); ?>includes/js/app.js"></script>       
  <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>       
  <script src="<?php echo base_url(); ?>includes/js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>
  <script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
-->
        <script type="text/javascript">
          $("window").ready(function(){
          $("#status").trigger("change");
      });
$("#status").bind('change', function(){
    var selected = $(this).val();
    if (selected == 'Active'  ) { 
			  $('#showTerminated').css('display', 'none');
			  $('#showRetired').css('display', 'none');
			  $('#showTransfer').css('display', 'none');			
			  $('#showDied').css('display', 'none'); 
			  $('#newFac').css('display', 'none');
			  $('#new_distcode').removeAttr('required','required');
			  $('#new_tcode').removeAttr('required','required');
			  $('#new_uncode').removeAttr('required','required');
			  $('#new_facode').removeAttr('required','required');
			  $('#new_facode').removeAttr('required','required');
			  $('#date_transfer').removeAttr('required','required');
			  $('#showLeavefrom').css('display', 'none');
			  $('#showLeaveto').css('display', 'none');	  
	}
    if (selected == 'Terminated') {  
			$('#showTerminated').css('display', 'block');
			$('#showRetired').css('display', 'none'); 
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 
			$('#newFac').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tcode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#date_transfer').removeAttr('required','required');
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
			}
	if (selected == 'Died') { 
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'block'); 
			$('#newFac').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tcode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#date_transfer').removeAttr('required','required');
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
	if (selected == 'Retired') { 
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tcode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#date_transfer').removeAttr('required','required');
	  		$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
	}
	if (selected == 'Transfered') { 
			$('#showTransfer').css('display', 'block');
			$('#newFac').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#new_distcode').attr('required','required');
			$('#new_tcode').attr('required','required');
			$('#new_uncode').attr('required','required');
			$('#new_facode').attr('required','required');
			$('#new_facode').attr('required','required');
			$('#date_transfer').attr('required','required');
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
 //alert(1);
			$('#post_type').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 
			$('#showpostoption').css('display', 'none');
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
            var code = $('#lhwcodel').val();
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
$('#new_distcode').on('change' , function(){
	var dists=this.value;
	$.ajax({
		type: "POST",
		data: "distcode="+dists,
		url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#new_tcode').html(result);
					$('#new_lhwcodef').val('');
					$('#new_lhwcodel').val('');
	}
});
});
 $('#new_tcode').on('change' , function(){
	var tcode=this.value;
	$.ajax({
		type: "POST",
		data: "tcode="+tcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getUnC",
				success: function(result){
					$('#new_uncode').html(result);
					$('#new_lhwcodef').val('');
					$('#new_lhwcodel').val('');
	}
});
});
$('#new_uncode').on('change' , function(){
	var uncode=this.value;
	$.ajax({
		type: "POST",
		data: "uncode="+uncode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
					$('#new_facode').html(result);
					$('#new_lhwcodef').val('');
					$('#new_lhwcodel').val('');
	}
});
});		   
$('#new_facode').on('change' , function (){
var new_facode = this.value;
  $('#new_lhwcodel').val('');
  $('#new_lhwcodef').val(new_facode);
  $.ajax({
    type: "GET",
    data: "facodew="+new_facode,
    async: false,
    url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
    success: function(result){
      $('#new_lhwcodel').val(result);
      var new_lhwcodel  = $('#new_lhwcodel').val();
      var newVal = new_facode+""+new_lhwcodel;
	  //alert(newVal);
      $('#new_lhwcode').val(newVal);
    }
  });
    
});
$('#new_lhwcodel').keyup(function (){
            var new_lhwcodel = $('#new_lhwcodel').val();
            var new_lhwcodef = +$('#new_lhwcodef').val();
            var new_facode = "";
            if(/^\d+$/.test(new_lhwcodel) )
            {
              if($('#new_lhwcodef').val().length == 6 && $('#new_lhwcodel').val().length == 3 )
              {
                //alert('asdkjhsdja');
                $('#new_lhwcodel').css('border-color','#dbe1e8');
                new_facode = $('#new_facode').val();
                var new_lhwcodel  = $('#new_lhwcodel').val();
                var newVal = new_facode+""+new_lhwcodel;
                //alert(newVal);
                $('#new_lhwcode').val(newVal);
                //alert($('#lhscode').val());
                $.ajax({
                  type: "GET",
                  data: "new_lhwcode="+newVal,
                  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
                  success: function(result){
                    console.log(result);
                    if(result == "0"){
                      $('#new_lhwcode').val(newVal);
                    }else{
                      alert('The Code '+newVal+' already exists, please try some other code');
                      $('#new_lhwcodel').val('');
                      $('#new_lhwcodel').css('border-color','red');
                    }
                  }
                });
              }else
              {
                $('#new_lhwcodel').css('border-color','red');
              }
            }
            else
            {
              $('#new_lhwcodel').css('border-color','red');
            }
            //alert($('#lhscode').val());
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
            $("#passingyear").inputmask("9999");
            $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
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
//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){
   var nic = $(this).val();
   var code = $('#techniciancode').val();
   if(nic!=''){
	   $.ajax({ 
		type: 'POST',
		data: 'nic='+nic+'&code='+code,
		url: '<?php //echo base_url();?>Ajax_calls/checktechNIC', 
		success: function(data){
		 if(data!=''){
		  if(data=='yes'){
			$('#site_response').css('display','block');
			$('#site_response').css('color','red');
			$('#site_response').html('CNIC Already Exist For Another Technician.');
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
$(document).on('change','#status',function(){
var status= $('#status').val();
if(status=='Transfered')
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
$(document).on('change','#new_facode',function(){
    if (buttonsDisable($(this).val())) {
  $('#myCoolForm').prop('disabled', false);
        $('#save').prop('disabled', false);
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
//***************************************code to disable save ends here*********************************//
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
	   if(val=="select"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
   }
// End 
	
        </script>