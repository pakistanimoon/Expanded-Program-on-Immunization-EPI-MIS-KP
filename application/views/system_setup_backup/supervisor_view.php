
 <div class="container bodycontainer">

<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>

    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
			
			<div class="panel-heading">Supervisor Details</div>
	<div class="panel-body">
     <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/supervisor_edit/<?php echo $supervisordata['supervisorcode']; ?>">    
            
            <div class="form-group">
              <div class="row">
			  <label class="col-xs-2 col-xs-offset-1"  for = "supervisor_type" > Supervisor Type </label>
                <div class="col-xs-2 col-xs-offset-1">
                  <p><?php echo $supervisordata['supervisor_type'];?>  </p>
                </div>
                <?php if(($supervisordata['supervisor_type'] != "Tehsil Superintendent Vaccinator") && ($supervisordata['supervisor_type'] != "Field Superintendent Vaccinator")) { ?>
                <label class="col-xs-2 col-xs-offset-1"  for = "distcode" > District </label>
                <div class="col-xs-2 col-xs-offset-1">
                  <p><?php echo $supervisordata['districtname'];?> </p>
                </div>
                <?Php }  elseif ($supervisordata['supervisor_type'] == "Field Superintendent Vaccinator") { ?>
                <label class="col-xs-2 col-xs-offset-1"  for = "tcode" > Tehsil </label>
                <div class="col-xs-2 col-xs-offset-1">
                  <p> <?php echo $supervisordata['tehsilname'];?></p>
                </div>  
                <label class="col-xs-2 col-xs-offset-1"  for = "facode" > EPI Center Name </label>
                <div class="col-xs-2 col-xs-offset-1">
                  <p><?php echo $supervisordata['facilityname'];?> </p> 
                </div>            
              </div>
              <div class="row">
               <?php } else { ?>	
               <label class="col-xs-2 col-xs-offset-1"  for = "tcode" > Tehsil </label>
                <div class="col-xs-2 col-xs-offset-1">
                  <p> <?php echo $supervisordata['tehsilname'];?></p>
                </div>
                
                <?php } ?>

              <label class="col-xs-2 col-xs-offset-1"  for = "supervisorname" >  Supervisor Code </label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $supervisordata['supervisorcode'];?></p>
                </div>
               

              
                  </div>
				  
				    <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "supervisorname" > Supervisor Name</label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $supervisordata['supervisorname'];?> </p>

                    </div>
                  <label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Father Name</label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p> <?php echo $supervisordata['fathername'];?></p>
                </div>

          </div>             
            </div>
                 
           
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>

          
                  <div class="form-group">
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "basicpayscale" >Marital Status </label>
                  <div class="col-xs-2 col-xs-offset-1">
                   <span> <?php echo $supervisordata['marital_status'];?> </span>
                  </div>
                  <label class="col-xs-2 col-xs-offset-1"  for = "totalmonthlysalary" > Phone Number </label>

                  <div class="col-xs-2">
                     <span> <?php echo $supervisordata['phone'];?> </span>
                  </div>
                  </div>
                 
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "cnic" > CNIC # </label>
                  <div class="col-xs-2 col-xs-offset-1">
                   <p><?php echo $supervisordata['nic'];?> </p>
                  </div>
                  <label class="col-xs-2 col-xs-offset-1"  for = "date_of_birth" > Date of Birth </label>
                  <div class="col-xs-2">
                    <p><?php echo isset($supervisordata['date_of_birth'])? date('d-m-Y', strtotime($supervisordata['date_of_birth'])) : '';?>  </p>
                  </div>
                  </div>
                 
                  </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>

              
                <div class="form-group">
                    <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "permanent_address" > Permanent Address </label>
                      <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo $supervisordata['permanent_address'];?> </p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "present_address" > Present Address </label>
                      <div class="col-xs-2">
                        <p><?php echo $supervisordata['present_address'];?> </p>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "lastqualification" > Last Qualification </label>
                      <div class="col-xs-2 col-xs-offset-1">
                        <p><?php echo $supervisordata['lastqualification'];?> </p>

                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "passingyear" >Passing Out Year </label>
                      <div class="col-xs-2">
                        <p><?php echo $supervisordata['passingyear'];?>  </p>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "institutename" > Institute Name </label>
                      <div class="col-xs-2 col-xs-offset-1">
                        <p><?php echo $supervisordata['institutename'];?></p>
                      </div>
                    </div>
                  </div>
    <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Joining Details</div>

              
          <div class="form-group">    
              <div class="row">
                <label class="col-xs-2 col-xs-offset-1"  for = "date_joining" > Date Of Joining </label>
                    <div class="col-xs-2 col-xs-offset-1">
                     <p><?php echo isset($supervisordata['date_joining']) ? date('d-m-Y', strtotime($supervisordata['date_joining'])) : '';?></p>
                    </div>
                    <label class="col-xs-2 col-xs-offset-1"  for = "place_of_joining" > Place of Joining </label>
                    <div class="col-xs-2">
                      <p><?php echo $supervisordata['place_of_joining'];?>  </p>
                    </div>
              </div>
					  
					   <div class="row">
						    <label class="col-xs-2 col-xs-offset-1"  for = "employee_type" > Employee Type </label>
                    <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo $supervisordata['employee_type'];?> </p>
                      </div>
                      
            </div>
					  
					  
					  
					  
					  
                      <div class="row">
                       <label class="col-xs-2 col-xs-offset-1"  for = "status" > Status </label>
                      <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo $supervisordata['status'];?> </p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-2">
                        <p><?php echo isset($supervisordata['date_termination'])? date('d-m-Y', strtotime($supervisordata['date_termination'])) : '';?> </p>
                      </div>                     
                     </div>                    
                   </div>
                 
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div> 

                  

	       <div class="form-group">
							 <div class="row">
								<div class="col-xs-3 col-xs-offset-1 control-label">
								  <label>Training</label>
								</div>
								<div class="col-xs-3 col-xs-offset-2 control-label">
								  <label>Start Date</label>
								</div>
								<div class="col-xs-3  control-label">
								  <label>End Date</label>
								</div>
							  </div>
							  <hr>
			<div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="basic"> Basic Training </label>
           <div class="col-xs-3">
             <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['basic_training_start_date'])? date('d-m-Y', strtotime($supervisordata['basic_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['basic_training_end_date'])? date('d-m-Y', strtotime($supervisordata['basic_training_end_date'])) : '';?></p>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['routine_epi_start_date'])? date('d-m-Y', strtotime($supervisordata['routine_epi_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['routine_epi_end_date'])? date('d-m-Y', strtotime($supervisordata['routine_epi_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance"> Surveillance </label> 
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['survilance_training_start_date'])? date('d-m-Y', strtotime($supervisordata['survilance_training_start_date'])) : '';?></p>         </div>
           <div class="col-xs-3">
             <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['survilance_training_end_date'])? date('d-m-Y', strtotime($supervisordata['survilance_training_end_date'])) : '';?></p>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain"> Cold Chain </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['cold_chain_training_start_date'])? date('d-m-Y', strtotime($supervisordata['cold_chain_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['cold_chain_training_end_date'])? date('d-m-Y', strtotime($supervisordata['cold_chain_training_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['vlmis_training_start_date'])? date('d-m-Y', strtotime($supervisordata['vlmis_training_start_date'])) : '';?></p>       </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['vlmis_training_end_date'])? date('d-m-Y', strtotime($supervisordata['vlmis_training_end_date'])) : '';?></p>       </div>
        </div>
		  <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis"> EPI-MIS </label>
           <div class="col-xs-3">
           <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($supervisordata['epimis_training_start_date'])? date('d-m-Y', strtotime($supervisordata['epimis_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($supervisordata['epimis_training_end_date'])? date('d-m-Y', strtotime($supervisordata['epimis_training_end_date'])) : '';?></p>      </div>
          </div>-->
				</div>	




<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
             
              
                <div class="form-group">

                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Information </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $supervisordata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $supervisordata['branchcode'];?> </span>
                      </div>
                    </div>
                    
                    <div class="row">
					        <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "branchname" >  Branch Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $supervisordata['branchname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" >  Bank Account Number</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $supervisordata['bankaccountno'];?> </span>
                      </div>
                    
                    </div>

                    <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >Basic Pay Scale </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $supervisordata['payscale'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Basic Pay </label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $supervisordata['basicpay'];?> </span>
                      </div>
                    </div>
			 
                
                  </div>
                
                           
              <input type="hidden" name="supervisorcode" value="<?php echo  $supervisordata['supervisorcode']?>" />
                    <hr>
                    <?php if ( ($_SESSION['UserLevel']=='3') || ($_SESSION['utype']=='DEO') ){?>                     
                      <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                            <?php if ( ($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){ ?>                         
							 
                              <a href=" <?php echo base_url(); ?>Supervisor/Edit/<?php echo $supervisordata['supervisorcode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
  
                              <a href="<?php echo base_url(); ?>SupervisorList" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>

                           <?php } ?>
						   <?php if ( ($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='manager') ){ ?>
						   
						   <a href="<?php echo base_url(); ?>SupervisorList" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
						   <?php }?>
				     		 </div>
						  </div>
                        <?php }  ?>
						<?php if (($_SESSION['UserLevel']=='4') && ($_SESSION['utype']=='Store') ){?>
                 <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                                <a href="<?php echo base_url(); ?>setup_listing/supervisor_listing" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                          </div>
                    </div>
                    <?php }?>
						<?php if ( ($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='manager') ){ ?>
						 <div class="col-xs-4 col-xs-offset-8">
							 <a href="<?php echo base_url(); ?>Setup/Listing/supervisor" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
					</div>
						<?php } ?>
						
						
      </form>


    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->

</div><!--End of page content or body-->
