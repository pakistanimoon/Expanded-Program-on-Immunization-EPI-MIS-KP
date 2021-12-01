<!--start of page content or body-->
<div class="container">
<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> New EPI Technician Form
        </div>
         <div class="panel-body">
 <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/technician_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     
              <div class="form-group">
              <div class="row">
                <label class="col-xs-12 col-xs-offset-1 control-label" style="font-size: 15px;">Note: <i>Fields marked with </i><span style="color:red;">*</span> <i>(asterisk) are mandatory.</i></label>
              </div>
                <div class="row">
				 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                     <select id="distcode" name="distcode" class="form-control" size="1" >
                              <?php 
                              foreach($result as $row){
                                ?>
                                <option value="<?php echo $row['distcode'];?>" /><?php echo $row['district'];?>
                                  <?php
                                }
                                ?>
                                </select>
                    </div>
                <label class="col-xs-2 control-label lbl-search"  for = "tcode" > Tehsil <span style="color:red;">*</span></label>
                    <div class="col-xs-3">
                      <select id="tcode" name="tcode" class="form-control" size="1" required >
                          <option value="">Select Tehsil</option>
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
                  <div class="row">
				     <label class="col-xs-2 col-xs-offset-1 control-label lbl-search"  for = "facode" >EPI Center Name <span style="color:red;">*</span></label>
                <div class="col-xs-3">
                  <select id="facode" required name="facode" class="form-control" size="1" >
                    <option value="">Select EPI Centers</option> 
                    <?php 
                    foreach($resultFac as $row){
                      ?>
                      <option value="<?php echo $row['facode'];?>" <?php echo set_select('facode',$row['facode']); ?>  /><?php echo $row['fac_name'];?>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                 <!-- <label class="col-xs-2 control-label"   for = "lhwcode" > Technician Code </label>-->
                   <input type="hidden" name="techniciancode" id="techniciancode" required value="<?php echo set_value('techniciancode'); ?>" >
                  <div class="col-xs-1 cmargin18">
                   <input type="hidden"  class="form-control  right" style="text-align: -webkit-right;" id="techniciancodef" value="Health Facility.Code" />
                  </div>
                  <div class="col-xs-2 cmargin19">
                    <input type="hidden" required="required" name="techniciancodel" id="techniciancodel" class="form-control " <?php echo 'value="'.set_value('techniciancodel').'"'; ?> ></div>
				   </div>
                  <div class="row">
				    <label class="col-xs-2 col-xs-offset-1 control-label"  for = "technicianname" >  Technician Name <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                   <input type="text" required name="technicianname" id="technicianname" placeholder="Technician Name"  class="form-control " value="<?php echo set_value('technicianname'); ?>"/> 
				   <?php echo form_error('technicianname'); ?>
				   </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Father Name <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                   <input type="text" name="  fathername" id="fathername" placeholder="Father Name"  class="form-control " value="<?php echo set_value('fathername'); ?>"/>   <?php echo form_error('fathername'); ?> </div>
                  </div>
                    <div class="row">

					 
                                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "husbandname" > Picture </label>
                                  <div class="col-xs-3 climg">
                    <input  name="technian_picture" accept="image/*" id="image_file" onchange="fileSelectHandler()" type="file">
                    <div class="error"></div>
                  </div>
                </div>
                  </div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
             <div class="form-group">
                 <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Marital Status</label>
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                    <option value="Married" <?php echo set_select('marital_status', 'Married', TRUE); ?>>Married</option>
                    <option value="Single" <?php echo set_select('marital_status', 'Single'); ?>>Single</option>
                    
                  </select>
                  </div>
                  <label class="col-xs-2 control-label"  for = "nic" >Phone Number </label>
                  <div class="col-xs-3">
                 <input type="text"  name="phone" id="phone" placeholder="Phone Number"  class="form-control numberclass" value="<?php echo set_value('phone'); ?>"/> <?php echo form_error('phone'); ?>
                </div>
                  </div>
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" > CNIC # <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                     <input required name="nic" id="nic" placeholder="CNIC #"  class="form-control " value="<?php echo set_value('nic'); ?>"/> <?php echo form_error('nic'); ?><span id="site_response"></span>
                  </div>
                  <label class="col-xs-2 control-label" > Date of Birth <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                     <input type="text" name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  class="form-control " value="<?php echo set_value('date_of_birth'); ?>"/><?php echo form_error('date_of_birth'); ?></div>
                  </div>
                  <div class="row">
                 <!--  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "uncode" > Union Council </label>
                      <div class="col-xs-3">
                        <select id="uncode" required name="uncode" class="form-control" size="1" >
                          <?php 
                          foreach ($resultUnC as $row){
                            ?>
                            <option value="<?php echo $row['uncode'];?>" <?php echo set_select('uncode', $row['uncode']); ?> /><?php echo $row['un_name'];?>
                              <?php
                            }
                            ?>
                          </select>
                        </div> -->
                    <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhscode" > Supervisor Name <span style="color:red;">*</span></label>
                    <div class="col-xs-3">
                       <select id="supervisorcode"  name="supervisorcode" class="form-control" size="1" >
                        <?php 
                        foreach($resultSupervisor as $row){
                          ?>
                          <option value="<?php echo $row['supervisorcode'];?>" <?php echo set_select('supervisorcode', $row['supervisorcode']); ?> /><?php echo $row['supervisorname'];?>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "catch_area_pop" > Catchment Area Population <span style="color:red;">*</span></label>
                        <div class="col-xs-3">
                          <input type="text"  name="catch_area_pop" id="catch_area_pop" placeholder="Catchment Area Population"  class="form-control numberclass" value="<?php echo set_value('catch_area_pop'); ?>"/><?php echo form_error('catch_area_pop'); ?>
                        </div>
						<label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
						<div class="col-xs-3">
							<select id="employee_type" name="employee_type" class="form-control" size="1" >
								<option value="Contract" <?php echo set_select('employee_type', 'Contract', TRUE); ?>>Contract</option>
								<option value="Regular" <?php echo set_select('employee_type', 'Regular'); ?>>Regular </option>
								<option value="Contingent" <?php echo set_select('employee_type', 'Contingent'); ?>>Contingent </option>
							</select>
							</div>
                  </div>
                  </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
                <div class="form-group">
                                       <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"   for = "permanent_address" > Permanent Address </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  permanent_address" maxlength="120" id="permanent_address" placeholder="Permanent Address"  class="form-control " value="<?php echo set_value('permanent_address'); ?>"/><?php echo form_error('permanent_address'); ?>
                      </div>
                      <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                      <div class="col-xs-3">
                        <input type="text"  name=" maxlength="120"  present_address" id="present_address" placeholder="Present Address"  class="form-control " value="<?php echo set_value('present_address'); ?>"/><?php echo form_error('present_address'); ?>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label>
                      <div class="col-xs-3">
                        <select name="lastqualification" id="lastqualification" maxlength="30" class="form-control">
                          <option value="Middle" <?php echo set_select('lastqualification', 'Middle', TRUE); ?>>Middle</option>
                          <option value="Matric" <?php echo set_select('lastqualification', 'Matric'); ?>>Matric</option>
                          <option value="FA" <?php echo set_select('lastqualification', 'FA'); ?>>F.A/F.Sc</option>
                          <option value="BA" <?php echo set_select('lastqualification', 'BA'); ?>>B.A/B.Sc/B.Ed</option>
                          <option value="MA" <?php echo set_select('lastqualification', 'MA'); ?>>M.A/M.Sc/M.Ed</option> 
                          <option value="SE" <?php echo set_select('lastqualification', 'SE'); ?>>Software Engineering</option> 
                        </select>
                      </div>
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
                      <div class="col-xs-3">
                        <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Out Year"  class="form-control " value="<?php echo set_value('passingyear'); ?>"/><?php echo form_error('passingyear'); ?>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"   for = "institutename" > Institute Name </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  institutename" maxlength="120" id="institutename" placeholder="Institute Name"  class="form-control " value="<?php echo set_value('institutename'); ?>"/><?php echo form_error('institutename'); ?>
                      </div>
                      <label class="col-xs-2 control-label"  for = "catch_area_name" > Catchment Area Name </label>
                        <div class="col-xs-3">
                          <input type="text"  name="catch_area_name" id="catch_area_name" placeholder="Catchment Area Name"  class="form-control" value="<?php echo set_value('catch_area_name'); ?>"/><?php echo form_error('catch_area_name'); ?>
                        </div>
                    </div>
                  </div>
              <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
                           <div class="form-group">    
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date Of Joining </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php echo set_value('date_joining'); ?>"/><?php echo form_error('date_joining'); ?>
                      </div>
                      <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
                      <div class="col-xs-3">
                        <input type="text" maxlength="50"  name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value="<?php echo set_value('place_of_joining'); ?>"/><?php echo form_error('place_of_joining'); ?>
                      </div>
                      </div>
                      <div class="row">
					   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
                      <div class="col-xs-3">
                        <select id="status" name="status" class="form-control" size="1" >
                          <option value="Active" <?php echo set_select('status', 'Active', TRUE); ?>>Active</option>
                          <!--<option value="Transfered" <?php echo set_select('status', 'Transfered'); ?>>Transfered</option>
                          <option value="Terminated" <?php echo set_select('status', 'Terminated'); ?>>Terminated</option>
                          <option value="Died" <?php echo set_select('status', 'Died'); ?>>Died</option>
                          <option value="Retired" <?php echo set_select('status', 'Retired'); ?>>Retired</option>-->
					<!--	  <option value="Retired" <?php echo set_select('status', 'Transfer(Other Program)'); ?>>Transfer(Other Program)</option>-->
					  </select>
                      </div>
                       <label class="col-xs-2 control-label"  for = "status" > Reason</label>
                      <div class="col-xs-3">
                       <input type="text"  name="reason" id="reason" placeholder="If Transfer/Terminated than Give Reason"  class="form-control " value="<?php echo set_value('reason'); ?>"/><?php echo form_error('reason'); ?>
                      </div>
                     </div>
                      <div class="row">
                       <label class="col-xs-2 col-xs-offset-1 control-label"  for = "areatype" > Area Type </label>
                        <div class="col-xs-3">
                          <div class="radio-group">
                            <label class="radio-inline">
                              <input type="radio" checked="checked" <?php echo  set_radio('areatype', 'rural'); ?> value="rural" name="areatype">Rural
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="urban" <?php echo  set_radio('areatype', 'urban'); ?> name="areatype">Urban
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="slum" <?php echo  set_radio('areatype', 'slum'); ?> name="areatype">Slum
                            </label>
                            <label class="radio-inline">
                              <input type="radio" value="semi_urban" <?php echo  set_radio('areatype', 'semi_urban'); ?> name="areatype">Semi Urban
                            </label>
                          </div>
                          </div>
					 	<!--<div class="showTerminated" id="showTerminated" style="display: none;">
						<label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_termination" id="date_termination" placeholder="Date Termination"  class="form-control " value="<?php echo set_value('date_termination'); ?>"/>
						</div>
						</div>
						<div class="showRetired" id="showRetired" style="display: none;">
						<label class="col-xs-2 control-label"  for = "date_termination" > Date Retired </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php echo set_value('date_retired'); ?>"/>
						</div>
						</div>
						<div class="showDied" id="showDied" style="display: none;">
						<label class="col-xs-2 control-label"  for = "date_termination" > Date Died </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php echo set_value('date_died'); ?>"/>
						</div>
						</div>
						<div class="showTransfer" id="showTransfer" style="display: none;">
						<label class="col-xs-2 control-label"  for = "date_termination" > Date Transfered </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php echo set_value('date_transfer'); ?>"/>
						</div>
						</div>-->
                        </div>
                    </div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>
         	<div class="form-group">
							 <div class="row">
								<div class="col-xs-3  col-xs-offset-1 control-label">
								  <label>Training</label>
								</div>
								<div class="col-xs-3 text-center">
								  <label style="padding-top: 8px;">Start Date</label>
								</div>
								<div class="col-xs-3 text-center">
								  <label style="padding-top: 8px;">End Date</label>
								</div>
							  </div>
							  <hr>
							  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="tenmonth_training_start_date"> Basic Training </label>
           <div class="col-xs-3">
            <input name="  basic_training_start_date" id="basic_training_start_date" placeholder="Basic Training Start Date" class="form-control" value="<?php echo set_value('basic_training_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input name="  basic_training_end_date" id="basic_training_end_date" placeholder="Basic Training End Date" class="form-control " value="<?php echo set_value('basic_training_end_date'); ?>" type="text">           </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
            <input name="  routine_epi_start_date" id="routine_epi_start_date" placeholder="Routine EPI Training Start Date" class="form-control" value="<?php echo set_value('routine_epi_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input name="  routine_epi_end_date" id="routine_epi_end_date" placeholder="Routine EPI Training End Date" class="form-control " value="<?php echo set_value('routine_epi_end_date'); ?>" type="text">           </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance_training_start_date"> Surveillance </label>
           <div class="col-xs-3">
            <input name="  survilance_training_start_date" id="survilance_training_start_date" placeholder="Survilance Training Start Date" class="form-control" value="<?php echo set_value('survilance_training_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input name="  survilance_training_end_date" id="survilance_training_end_date" placeholder="Survilance Training End Date" class="form-control " value="<?php echo set_value('survilance_training_end_date'); ?>" type="text">           </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain_training_start_date"> Cold Chain </label>
           <div class="col-xs-3">
            <input name="  cold_chain_training_start_date" id="cold_chain_training_start_date" placeholder="Cold Chain Training Start Date" class="form-control" value="<?php echo set_value('cold_chain_training_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input  name="  cold_chain_training_end_date" id="cold_chain_training_end_date" placeholder="Cold Chain Training End Date" class="form-control " value="<?php echo set_value('cold_chain_training_end_date'); ?>" type="text">           </div>
          </div>
		 <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis_training_start_date"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <input name="  vlmis_training_start_date" id="vlmis_training_start_date" placeholder="vLMIS/EPI-MIS Training Start Date" class="form-control" value="<?php echo set_value('vlmis_training_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input  name="  vlmis_training_end_date" id="vlmis_training_end_date" placeholder="vLMIS/EPI-MIS Training End Date" class="form-control " value="<?php echo set_value('vlmis_training_end_date'); ?>" type="text">           </div>
          </div>
		   <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis_training_start_date"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <input name="  epimis_training_start_date" id="epimis_training_start_date" placeholder="vLMIS/EPI-MIS Training Start Date" class="form-control" value="<?php echo set_value('epimis_training_start_date'); ?>" type="text">           </div>
           <div class="col-xs-3">
            <input name="  epimis_training_end_date" id="epimis_training_end_date" placeholder="vLMIS/EPI-MIS Training End Date" class="form-control " value="<?php echo set_value('epimis_training_end_date'); ?>" type="text">           </div>
          </div>-->
				</div>	
   <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
    <div class="form-group">
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			  <select id="bankid"  name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>" <?php echo set_select('bankid',$row['bankid']); ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
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
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
																			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
													</div>        
                    <hr>                      
                      <div class="row">
                             <div class="col-xs-11" style="padding:0px; text-align:right;">
                             <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save  </button>
							 <!---<button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit  </button>--->
                             <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
                             <a href="<?php echo base_url();?>System_setup/technician_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
                      </div>
                    </div>
            </form>
       <!--      <a href="remoteContent.html" data-remote="false" data-toggle="modal" data-target="#myModal" class="btn btn-default">
    Launch Modal
</a> -->


<!-- ============Start Modal================== -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Technician Already Exists</h4>
      </div>
      <div class="modal-body">
         <div class="row">
          <div class="form-group">              
              <label class="col-xs-2 control-label">District:</label>
                <div class="col-xs-3">                
                <span  name="distcode" id="distcode1"  ></span>     
                </div>
                 <label class="col-xs-2 col-xs-offset-1 control-label">Tehsil:</label>
                 <div class="col-xs-3">
                <span name="tcode" id="tcode1"></span>
              </div>  
          </div>
        </div>
        <div class="row">
          <div class="form-group">              
              <label class="col-xs-2 control-label">Technician Name:</label>
                <div class="col-xs-3">
               <span name="technicianname" id="technicianname1" ></span>
                </div>
                <label class="col-xs-2 col-xs-offset-1 control-label">NIC:</label>

              <div class="col-xs-3">
                 <span  name="nic" id="nic1" ></span>
              </div>                
                        
          </div>
        </div>
        <div class="row">
          <div class="form-group">              
              <label class="col-xs-2 control-label">Union Council:</label>
                <div class="col-xs-3">
                  <span name="uncode" id="uncode1" ></span>
                  </div>
                <label class="col-xs-2 col-xs-offset-1 control-label">Facility:</label>
              <div class="col-xs-3">
                <span name="facode" id="facode1" ></span>
              </div>         
        </div>
      </div>
       <div class="row">
          <div class="form-group">              
              <label class="col-xs-2 control-label">Status:</label>
                <div class="col-xs-3">
                  <span name="status" id="status1"></span>
                  </div>
                <label class="col-xs-2 col-xs-offset-1 control-label">Phone:</label>
              <div class="col-xs-3">
                <span name="phone" id="phone1"></span>
              </div>         
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ============END Modal================== -->


    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
  <script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
  <script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


  <script type="text/javascript">
/* $("#status").bind('change', function(){
    var selected = $(this).val();
    if (selected == 'Active') { 
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'none'); 			
	}
    if (selected == 'Terminated') {  
			$('#showTerminated').css('display', 'block');
			$('#showRetired').css('display', 'none'); 
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 	
			}
	if (selected == 'Died') { 
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'block'); 			
	}
	if (selected == 'Retired') { 
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 			
	}
	if (selected == 'Transfered') { 
			$('#showTransfer').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 			
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
            var regexp = /[0-9]{3}/; 
            var valid = regexp.test(num);
            return valid;
          }
          $('#dataform').on('submit', function(e){
            var code = $('#techniciancodel').val();
            if(checkCode(code)){
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
            }else{
              alert('Please Enter Correct Technician Code');
              $('techniciancodel').focus();
            }
          });
          $('#nic').blur(function (){
          });
          /* $('#techniciancodel').keyup(function (){
            var techniciancodel = $('#techniciancodel').val();
            var techniciancodef = +$('#techniciancodef').val();
            var facode = "";
            if(/^\d+$/.test(techniciancodel) )
            {
              if($('#techniciancodef').val().length == 6 && $('#techniciancodef').val().length == 2 )
              {
                //alert('asdkjhsdja');
                $('#techniciancodel').css('border-color','#dbe1e8');
                facode = $('#facode').val();
                var techniciancodel  = $('#techniciancodel').val();
                var newVal = facode+""+techniciancodel;
                //alert(newVal);
                $('#techniciancode').val(newVal);
                //alert($('#lhscode').val());
                $.ajax({
                  type: "GET",
                  data: "techniciancode="+newVal,
                  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
                  success: function(result){
                    console.log(result);
                    if(result == "0"){
                      $('#techniciancode').val(newVal);
                    }else{
                      alert('The Code '+newVal+' already exists, please try some other code');
                      $('#techniciancodel').val('');
                      $('#techniciancodel').css('border-color','red');
                    }
                  }
                });
              }else
              {
                $('#techniciancodel').css('border-color','red');
              }
            }
            else
            {
              $('#techniciancodel').css('border-color','red');
            }
            //alert($('#lhscode').val());
          }); */     
$(document).on('change', '#facode' , function (){
var facode = $(this).val();
  //$('#techniciancodel').val('');
  $('#techniciancodef').val(facode);
  $.ajax({
    type: "GET",
    data: "facodew="+facode,
    async: false,
    url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
    success: function(result){
		var valcode=result.trim();
		$('#techniciancodel').val(valcode);
		var techniciancodel  = $('#techniciancodel').val();
		var newVal = facode+""+techniciancodel;
		//alert(newVal);
		$('#techniciancode').val(newVal);
    }
  });
});
$('#tcode').on('change' , function (){
  var tcode = this.value;
  var facode = "";
  $.ajax({
    type: "GET",
    data: "tcode="+tcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
    success: function(result){
      $('#facode').html(result);
    }
  });
 /* $.ajax({
    type: "GET",
    //data: "tcode="+tcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
    success: function(result){
      $('#uncode').html(result);
    }
  });*/
});
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
    //$('#date_termination').datepicker(options);
	//$('#date_transfer').datepicker(options);
	//$('#date_retired').datepicker(options);
	//$('#date_died').datepicker(options);
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
  });
        
  $(document).ready(function(){
    $('#bankaccountno').numeric({allow:"-"});
	$('#branchcode').numeric({allow:"-"});
	$('#basicpay').numeric();
    $(":input").inputmask();
    $("#date_of_birth").inputmask("99-99-9999");
    $("#techniciancodel").inputmask("999");
    $("#date_joining").inputmask("99-99-9999");
    //$("#date_termination").inputmask("99-99-9999");
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
    $("#passingyear").inputmask("9999");
    $("#phone").inputmask("99999999999");
    // $("#branchcode").inputmask("99999999");
    // $("#bankaccountno").inputmask("9999999999999999");
    // $("#basicpay").inputmask("999999");
   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
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
   if(nic!=''){
       $.ajax({ 
        type: 'POST',
        data: "nic="+nic,
        url: '<?php echo base_url();?>Ajax_calls/checktechNIC',
        //dataType: "json",
        success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.nic!=''){
                  
                  /*console.log(data);
                  var obj = JSON.parse(data,true);
                  console.log(obj);*/
                 /*  $("#nic1").html(data);
                  $("#technicianname1").html(data);
                  $("#distcode1").html(data);
                  $("#tcode1").html(data);
                  $("#uncode1").html(data);
                  $("#facode1").html(data); */
                  
                 /* for(var tech in obj){
                  $("#"+tech).text(obj[tech]);
                }*/
    // $(".modal-body").html(data);
                 $("#nic1").html(data.nic);  
                 $("#distcode1").html(data.district);
                 $("#tcode1").html(data.tcode);
                 $("#uncode1").html(data.uncode);
                 $("#facode1").html(data.facode);
                 $("#technicianname1").html(data.technicianname);
                 $("#status1").html(data.status);
                 $("#phone1").html(data.phone);  
                 $("#myModal").modal('show');
                 $('#site_response').css('display','block');
                 $('#site_response').css('color','red');
                 $("#site_response").html('CNIC Already Exist For Another Technician.');
                 $('#nic').css('border-color','red');
                 $('#nic').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_response").html('');
            $('#site_response').css('display','block');
          }
          }
       });
    }
  });
$(document).ready(function() {    
    $('#technicianname, #husbandname, #fathername, #permanent_address, #present_address, #branchname').on('keypress', function(event) {
        var $this = $(this),
            val = $this.val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        console.log(val);
        $this.val(val);
    });
});

////Code For Save Form With Control+S Event//////////////
$(document).on('keydown', function(e){
	 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
		$("#save").click();
		e.preventDefault();
		return false;
	}
});
//////////////////////////////////////////////////////////////////////////////////
</script>