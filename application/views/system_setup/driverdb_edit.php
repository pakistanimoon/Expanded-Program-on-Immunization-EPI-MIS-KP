<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update Driver Form
        </div>
         <div class="panel-body">
  <form id="dataform" action="<?php echo base_url(); ?>System_setup/driverdb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
  <input type="hidden" name="previous_code" id="previous_code" value="<?php echo $driverdata['previous_code']; ?>" />
           <input type="hidden" name="facode" id="facode" value="<?php echo $driverdata['facode']; ?>" />
              
  <div class="form-group">
                <div class="row">
                <div class="col-xs-6 col-xs-offset-1">
                  
                <div class="row">
                  <label class="col-xs-3  control-label"  for = "distcode" > District </label>
                  <div class="col-xs-6">
                    <label class="control-label"  for = "distcode" ><?php echo $driverdata['districtname']; ?></label> 
                    <input type="hidden" name="distcode" id="distcode"  value="<?php echo $driverdata['distcode']; ?>"  class="form-control "/>

                  </div>
                </div>


                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "drivercode" > Driver Code </label>
                      </div>
                      <div class="col-xs-6 cmargin5">
                        <span> <?php echo $driverdata['drivercode'];?> </span>
                        <input type="hidden" required name="drivercode" id="drivercode" placeholder="Driver Code"  value="<?php echo $driverdata['drivercode'];?>"  class="form-control "/>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "drivername" > Driver Name </label>
                      </div>
                      <div class="col-xs-6">
                       <input type="text" required name="drivername" id="drivername" placeholder="Driver Name"  value="<?php echo $driverdata['drivername'];?>"  class="form-control "/>

                      </div>
					  
                    </div>
                  
                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "fathername" > Father Name </label>
                      </div>
                      <div class="col-xs-6">
                         <input type="text"  name="  fathername" id="fathername" placeholder="Father Name"  value="<?php echo $driverdata['fathername']; ?>"  class="form-control "/>
                      </div>
                    </div>

                  </div>



                </div>
              </div>



                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>


              <div class="form-group">

              
                <div class="row">
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" >  Marital Status  </label>
           <div class="col-xs-3">
             <select id="marital_status" name="marital_status" class="form-control" size="1" >
                        <option <?php if($driverdata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($driverdata['marital_status'] == 'Un Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Un Married">Un Married</option>
                        <option <?php if($driverdata['marital_status'] == 'Widow') { echo 'selected="selected"'; } else { echo ''; } ?> value="Widow">Widow</option>
                        <option <?php if($driverdata['marital_status'] == 'Divorced') { echo 'selected="selected"'; } else { echo ''; } ?> value="Divorced">Divorced</option>
                        <option <?php if($driverdata['marital_status'] == 'Other') { echo 'selected="selected"'; } else { echo ''; } ?> value="Other">Other</option>
                    </select>


            </div>

              <label class="col-xs-2 control-label"  for = "place_of_joining" >Phone Number </label>


                <div class="col-xs-3">

                  <input type="text"  name="phone" id="phone" placeholder="Phone Number"  class="form-control numberclass" value="<?php echo $driverdata['phone'];?>"/>

                </div>
               
              </div>



                  <div class="row">
                   <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_of_birth" > Date of Birth </label>

                <div class="col-xs-3">

                  <input type="text" name="  date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  value="<?php echo isset($driverdata['date_of_birth']) ? date('d-m-Y', strtotime($driverdata['date_of_birth'])) : '' ;?>"  class="form-control "/>

                </div>
                  <label class="col-xs-2 control-label"  for = "nic" > NIC # </label>

                <div class="col-xs-3">

                  <input required name="nic" id="nic" placeholder="NIC #"  value="<?php echo $driverdata['nic'];?>"  class="form-control "/><span id="site_response"></span>

                </div>

                  </div>



                  </div>
              
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>



                <div class="form-group"> 
                  <!-- <div class="row">                


                 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhscode" > Attached Supervisor</label>

                  <div class="col-xs-3">

                    <select id="supervisorcode" required name="supervisorcode" class="form-control" size="1" >


                      <?php 

                      foreach($resultSupervisor as $row){


                        ?>

                        <option <?php if($driverdata['supervisorcode'] == $row['supervisorcode'] ){ echo 'selected="selected"'; } else  { echo ''; } ?> value="<?php echo $row['supervisorcode']; ?>" /><?php echo $row['supervisorname']; ?></option>


                        <?php

                      }



                      ?>

                    </select>

                  </div>

                  

                      </div>    -->
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address </label>

                  <div class="col-xs-3">

                    <input type="text"  name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  value="<?php echo $driverdata['permanent_address'];?>"  class="form-control "/>

                  </div>
                    <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>



                  <div class="col-xs-3">

                    <input type="text"  name="  present_address" id="present_address" placeholder="Present Address"  value="<?php echo $driverdata['present_address'];?>"  class="form-control "/>

                  </div>
                      </div>


                      <div class="row">
                       <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label>

                  <div class="col-xs-3">

                    <select name="lastqualification" id="lastqualification" class="form-control">

                      <option  <?php if($driverdata['lastqualification'] == 'middle') { echo 'selected="selected"'; } else { echo ''; } ?> value="middle">Middle</option>

                      <option <?php if($driverdata['lastqualification'] == 'matric') { echo 'selected="selected"'; } else { echo ''; } ?> value="matric">Matric</option>

                      <option <?php if($driverdata['lastqualification'] == 'fa') { echo 'selected="selected"'; } else { echo ''; } ?> value="fa">F.A/F.Sc</option>

                      <option <?php if($driverdata['lastqualification'] == 'ba') { echo 'selected="selected"'; } else { echo ''; } ?> value="ba">B.A/B.Sc/B.Ed</option>

                      <option <?php if($driverdata['lastqualification'] == 'ma') { echo 'selected="selected"'; } else { echo ''; } ?> value="ma">M.A/M.Sc/M.Ed</option>
					  
					   <option <?php if($driverdata['lastqualification'] == 'SE') { echo 'selected="selected"'; } else { echo ''; } ?> value="SE">Software Engineering</option>



                    </select>

                  </div>
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Year </label>

                  <div class="col-xs-3">

                    <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Year"  value="<?php echo $driverdata['passingyear'];?>"  class="form-control "/>

                  </div>
                     </div>
                     <div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" >Institute Name </label>

                  <div class="col-xs-3">

                    <input type="text" name="  institutename" id="institutename" placeholder="Institute Name"  value="<?php echo $driverdata['institutename'];?>"  class="form-control "/>

                  </div>
                  </div>
</div>
                  <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>


  <div class="row">
               
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" >Date Of Joining </label>

                  <div class="col-xs-3">

                    <input type="text" name="  date_joining" id="date_joining" placeholder="Date Of Joining"  value="<?php echo isset($driverdata['date_joining']) ? date('d-m-Y', strtotime($driverdata['date_joining'])) : '' ;?>"  class="form-control "/>

                  </div>
                   <label class="col-xs-2  control-label"  for = "place_of_joining" >Place of Joining </label>

                  <div class="col-xs-3">

                    <input type="text" name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php echo $driverdata['place_of_joining'];?>"  class="form-control "/>

                  </div>
			</div>


  <div class="row">
  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" >Status </label>

                  <div class="col-xs-3">

                    <select id="status" name="status" class="form-control" size="1" >

                      <option <?php if($driverdata['status'] == 'Active') { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>

                        <option <?php if($driverdata['status'] == 'Terminated') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Terminated">Terminated</option>

                        <option <?php if($driverdata['status'] == 'Died') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Died">Died</option>

                        <option <?php if($driverdata['status'] == 'Retired') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Retired">Retired</option>
                        <option <?php if($driverdata['status'] == 'On Leave') { echo 'selected="selected"'; } else { echo ''; } ?>  value="On Leave">On Leave</option>
						
                        
                        <option <?php if($driverdata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Transfered">Transfered</option>
						
						<option <?php if($driverdata['status'] == 'Temporary-Post') { echo 'selected="selected"'; }else echo ''; ?>  value="post">Temporary-Post</option>
						

                      </select>

                    </div>
                  
	<div class="row">
				   	<div class="showTerminated" id="showTerminated" style="display: none;">
                      <label class="col-xs-2  control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                          <input type="text"  name="date_termination" id="date_termination" placeholder="Date Of Termination"  value="<?php if(validation_errors() != false) { echo set_value('date_termination'); } else { echo isset($driverdata['date_termination']) ? date('d-m-Y', strtotime($driverdata['date_termination'])) : ''; } ?>"  class="form-control "/>
					</div>
					</div>
					<div class="showRetired" id="showRetired" style="display: none;">
					<label class="col-xs-2  control-label"  for = "date_retired" > Date Retired </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_retired'); } else { echo isset($driverdata['date_retired']) ? date('d-m-Y', strtotime($driverdata['date_retired'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showDied" id="showDied" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_died" > Date Died </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_died'); } else { echo isset($driverdata['date_died']) ? date('d-m-Y', strtotime($driverdata['date_died'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showTransfer" id="showTransfer" style="display: none;">
					<label class="col-xs-2  control-label"  for = "date_transfer" > Date Transfered </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_transfer'); } else { echo isset($driverdata['date_transfer']) ? date('d-m-Y', strtotime($driverdata['date_transfer'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showpostoption" id="showpostoption" style="display: none;">
                   <label class="col-xs-2 control-label"  for = "showpostoption" > Posted As</label>
                    <div class="col-xs-3">
							<select id="post_type" name="post_type" class=  "form-control" size="1" onchange="suptype(this.value)" >
					<!--- All post-Back Function and Names --->
		 <?php if($driverdata['previous_table']==NULL):?>	
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
					<option value="cco_db">Cold Chain Operator</option>						
					<option value="go_db">Generator Operator</option>	 					 
					<option value="cc_mechanic">Cold Chain Mechanic </option>
					<!---<option value="deodb">Data entry operator</option>	--->
		   <?php else:?>
					<?php if($driverdata['previous_table']=='dsodb'){?>
					<option value="dsodb">District Surveillance Officer</option> 
					<?php } ?>		
					<?php if($driverdata['previous_table']=='codb'){?>				 					 
					<option value="codb">Computer Operator</option>  
					<?php } ?>			
					<?php if($driverdata['previous_table']=='mfpdb'){?>			 
					<option value="mfpdb">Measles Focal Person</option>	
					<?php } ?>
					<?php if($driverdata['previous_table']=='med_techniciandb'){?>						 			 
					<option value="med_techniciandb">HF Incharges</option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='skdb'){?>					 
					<option value="skdb">Storekeeper</option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='techniciandb'){?>					 
					<option value="techniciandb">EPI Technician</option>	
					<?php } ?>	
					<?php if($driverdata['previous_table']=='cc_techniciandb'){?>					 	 
					<option value="cc_techniciandb">Cold Chain Technician </option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='cco_db'){?>					 	
					<option value="cco_db">Cold Chain Operator</option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='go_db'){?>					 						
					<option value="go_db">Generator Operator</option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='cc_mechanic'){?>					  					 
					<option value="cc_mechanic">Cold Chain Mechanic </option>
					<?php } ?>	
					<?php if($driverdata['previous_table']=='driverdb'){?>					 
					<option value="driverdb">Driver</option> 
					<?php } ?>
			<?php endif;?>	
                    </select>
					</div>
					</div>
					 <div class="showTehsil" id="showTehsil" style="display: none;">
                      <label class="col-xs-2 control-label" style="margin-left:110px" for = "showTehsil" >  Tehsil</label>
                      <div class="col-xs-3">
                          <select id="newtcode" name="newtcode" class="form-control" size="1">
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
                          <select id="newuncode" name="newuncode" class="form-control" size="1">
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
					<div class="showResigned" id="showResigned" style="display: none;">
					<label class="col-xs-2   control-label"  for = "date_resigned" > Date Resigned </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_resigned" id="date_resigned" placeholder="Date Resigned"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_resigned'); } else { echo isset($driverdata['date_resigned']) ? date('d-m-Y', strtotime($driverdata['date_resigned'])) : ''; } ?>"/>
					</div>
					</div>
				
					<div class="showLeave" id="showLeavefrom" style="display: none;">
					<label class="col-xs-2 control-label"  for = "date_from" > Date From </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_from" id="date_from" placeholder="Date From"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_from'); } else { echo isset($driverdata['date_from']) ? date('d-m-Y', strtotime($driverdata['date_from'])) : ''; } ?>"/>
					</div>
					</div>
					<div class="showLeave" id="showLeaveto" style="display: none;">
					<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_to" > Date To </label>
					<div class="col-xs-3">
						<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('date_to'); } else { echo isset($driverdata['date_to']) ? date('d-m-Y', strtotime($driverdata['date_to'])) : ''; } ?>"/>
					</div>
					</div>
				  

        </div><br>
 
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px; margin-left: 0px;"> Banking Details</div>


 <div class="form-group">
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information</label>
		<div class="col-xs-3">
			  <select id="bankid"  name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>"  <?php if($driverdata['bid'] == $row['bankid'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchcode'); } else { echo $driverdata['branchcode']; } ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('branchname'); } else { echo $driverdata['branchname']; } ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('bankaccountno'); } else { echo $driverdata['bankaccountno']; } ?>"/><?php echo form_error('bankaccountno'); ?>
		</div> 
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
		<div class="col-xs-3">
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option <?php if($driverdata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
																			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			<input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php if(validation_errors() != false) { echo set_value('basicpay'); } else { echo $driverdata['basicpay']; } ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
</div>
                    <hr>
                 <input type="hidden" name="edit" value="edit" >
                                          
                      <div class="row">
					  <div class="col-xs-11" style="padding:0px; text-align:right;">
                           <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save </button>
							<!--- <button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit </button>-->


                          <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>

                          <a href="<?php echo base_url();?>System_setup/driverdb_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
                       
                      
                    </div>
                  
                

            </form>




    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->

</div><!--End of page content or body-->



  <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>       
 
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
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'block');
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
     
	}
	if (selected == 'Retired') { 
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'block');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');
			$('#showLeaveto').css('display', 'none');
			}
	if (selected == 'Transfered') { 
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'block');			
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
 //alert(1);
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'block');
			$('#showLeaveto').css('display', 'block'); 
	}
    //etc ...
});

</script>
        <script type="text/javascript">

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
           var code = $('#drivercodel').val();
           

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

            $('#basic_training_start_date').datepicker(options);

           
            $('#tenmonth_training_start_date').datepicker(options);

            

          });

        </script>



        <script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>

        <script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>

        <script type="text/javascript">

 /*          $(function () {

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
			$('#basic_training_start_date').datepicker(options);
			$('#tenmonth_training_start_date').datepicker(options);
			$('#date_transfer').datepicker(options);
			$('#date_retired').datepicker(options);
			$('#date_died').datepicker(options);
			$('#date_from').datepicker(options);
			$('#date_to').datepicker(options);


           

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

  $(document).on('change','#basic_training_start_date', function(){
      
    var x = 12; 
    var CurrentDate = $(this).val().split('-');
    var endDate = new Date(CurrentDate[2],CurrentDate[1]-1,CurrentDate[0]);
    var result = new Date(new Date(endDate).setMonth(endDate.getMonth()+3));
    var finaldate= result.getDate() + '-' + (result.getMonth()+1) +'-'+ result.getFullYear(); 
    $('#basic_training_end_date').val(finaldate);
});
$(document).on('change','#tenmonth_training_start_date', function(){
      
    var x = 12; 
    var CurrentDate = $(this).val().split('-');
    var endDate = new Date(CurrentDate[2],CurrentDate[1]-1,CurrentDate[0]);
    var result = new Date(new Date(endDate).setMonth(endDate.getMonth()+12));
    var finaldate= result.getDate() + '-' + (result.getMonth()+1) +'-'+ result.getFullYear(); 
    $('#tenmonth_training_end_date').val(finaldate);
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




          $(document).ready(function(){
			$('#bankaccount').numeric({allow:"-"});
			$(":input").inputmask();
			$("#date_of_birth").inputmask("99-99-9999");
			$("#date_joining").inputmask("99-99-9999");
			$("#date_termination").inputmask("99-99-9999");
			$("#basic_training_start_date").inputmask("99-99-9999");
			$("#tenmonth_training_start_date").inputmask("99-99-9999");
			$("#date_transfer").inputmask("99-99-9999");
			$("#date_retired").inputmask("99-99-9999");
			$("#date_died").inputmask("99-99-9999");
			$("#date_from").inputmask("99-99-9999");
			$("#date_to").inputmask("99-99-9999");
			$("#passingyear").inputmask("9999");
			$("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only

});

//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){
    
   var nic = $(this).val();
   var code = $(lhwcode).val();

   $.ajax({ 
    type: 'POST',
    data: 'nic='+nic+'&code='+code,
    url: '<?php echo base_url();?>Ajax_calls/checkLhwNIC',
    
    
    success: function(data){
     if(data!=''){
      if(data=='yes'){
        $('#site_response').css('display','block');
        $('#site_response').css('color','red');
        $('#site_response').html('CNIC Already Exist For Another LHW.');
        $('#nic').css('border-color','red');
      }
      else{
        $('#nic').css('border-color','#66AFE9');
        $('#site_response').html('');
        $('#site_response').css('display','block');
      }
    }
   }
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
		  	$('#showTehsil').css('display', 'block'); 
		    $('#showFacility').css('display', 'block'); 
			$('#showUnc').css('display', 'block');  
	   }
	   if(val=="cco_db"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="go_db"){
		  	$('#showTehsil').css('display', 'none'); 
		    $('#showFacility').css('display', 'none'); 
			$('#showUnc').css('display', 'none');  
	   }
	   if(val=="cc_mechanic"){
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
