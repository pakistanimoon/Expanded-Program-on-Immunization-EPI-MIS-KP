<!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
    <?php if(!$this->uri->segment(4)){ ?>
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
        <?php }?> 
      <div class="panel-heading"> Measles Focal Person Details
        </div>
         <div class="panel-body">
 <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/mfpdb_edit">

                <div class="form-group">
                  <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "basicpayscale" > District </label>
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $mfpdata['districtname'];?> </span>
                      </div>
                      <!--<div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Computer Operator Code </label>
                     </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $mfpdata['mfpcode'];?> </span>
                      </div>-->
                    </div>
                    <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Measles Focal Person Name </label>
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $mfpdata['mfpname'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankaccount" > Father Name</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $mfpdata['fathername'];?> </span>
                      </div>
                    </div>
                </div>
                    <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
              <div class="form-group">
                    <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" > Date Of Birth </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span>  <?php echo isset($mfpdata['date_of_birth'])? date('d-m-Y', strtotime($mfpdata['date_of_birth'])) : '';?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" >CNIC # </label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $mfpdata['nic'];?> </span>
                      </div>
                    </div>
                
            <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Marital Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['marital_status'];?> </span>
                </div>
                 <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" >Phone Number</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $mfpdata['phone'];?> </span>
                      </div>
				 
               </div>
              
               
        </div>
		
		 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Address and Qualification</div>
              <div class="form-group">
			  <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "distcode" > Permanent Address </label>
                  </div>
                    <div class="col-xs-2 col-xs-offset-2 cmargin5">
                    <span> <?php echo $mfpdata['permanent_address'];?> </span>
                    </div>
                      <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Present Address </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $mfpdata['present_address'];?> </span>
                </div>
              </div>
              <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Postal Code </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['postalcode'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > City </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $mfpdata['city'];?> </span>
                </div>
               </div>
			     <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Last Qualification </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['lastqualification'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Area Type </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $mfpdata['area_type'];?> </span>
                </div>
               </div>
                   <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Institute Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['institutename'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Passing Year </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $mfpdata['passingyear'];?> </span>
                </div>
               </div>
			  </div>
          <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
              <div class="form-group">
                <div class="row">
                                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "permanent_address" > Date Of Joining </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span><?php echo isset($mfpdata['date_joining']) ? date('d-m-Y', strtotime($mfpdata['date_joining'])) : '';?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1 ">
                <label class="control-label"  for = "present_address" >Place of Joining </label>
                </div>
                <div class="col-xs-2 cmargin5">
                <span> <?php echo $mfpdata['place_of_joining'];?> </span>
                </div>
                </div>
                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Place Of Posting</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['place_of_posting'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Designation </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $mfpdata['designation'];?> </span>
                </div>
                </div>
				 <div class="row">
				  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $mfpdata['status'];?> </span>
                </div>
				 
                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Employee Type </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span> <?php echo $mfpdata['employee_type'];?> </span>
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
             <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['basic_training_start_date'])? date('d-m-Y', strtotime($mfpdata['basic_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['basic_training_end_date'])? date('d-m-Y', strtotime($mfpdata['basic_training_end_date'])) : '';?></p>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['routine_epi_start_date'])? date('d-m-Y', strtotime($mfpdata['routine_epi_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['routine_epi_end_date'])? date('d-m-Y', strtotime($mfpdata['routine_epi_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance"> Surveillance </label> 
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['survilance_training_start_date'])? date('d-m-Y', strtotime($mfpdata['survilance_training_start_date'])) : '';?></p>         </div>
           <div class="col-xs-3">
             <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['survilance_training_end_date'])? date('d-m-Y', strtotime($mfpdata['survilance_training_end_date'])) : '';?></p>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain"> Cold Chain </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['cold_chain_training_start_date'])? date('d-m-Y', strtotime($mfpdata['cold_chain_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['cold_chain_training_end_date'])? date('d-m-Y', strtotime($mfpdata['cold_chain_training_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['vlmis_training_start_date'])? date('d-m-Y', strtotime($mfpdata['vlmis_training_start_date'])) : '';?></p>       </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['vlmis_training_end_date'])? date('d-m-Y', strtotime($mfpdata['vlmis_training_end_date'])) : '';?></p>       </div>
        </div>
		  <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis"> EPI-MIS </label>
           <div class="col-xs-3">
           <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($mfpdata['epimis_training_start_date'])? date('d-m-Y', strtotime($mfpdata['epimis_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($mfpdata['epimis_training_end_date'])? date('d-m-Y', strtotime($mfpdata['epimis_training_end_date'])) : '';?></p>      </div>
          </div>-->
				</div>	
			
               <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
             <div class="form-group">
                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $mfpdata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $mfpdata['branchcode'];?> </span>
                      </div>
                    </div>
                    <div class="row">
					 <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "branchname" >  Branch Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $mfpdata['branchname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" >  Bank Account Number</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $mfpdata['bankaccountno'];?> </span>
                      </div>
                    </div>
                          <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >Basic Pay Scale </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $mfpdata['payscale'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Basic Pay </label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $mfpdata['basicpay'];?> </span>
                      </div>
                    </div>
                  </div>
         
           
              <div class="form-group">
                <div class="row">
                                    <hr>
               <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
                  <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                          
                               <a href=" <?php echo base_url(); ?>Measles-Focal-Person/Edit/<?php echo $mfpdata['mfpcode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
                                <a href="<?php echo base_url(); ?>Measles-Focal-Person-List" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                            
                </div>  <input type="hidden" name="mfpcode" value="<?php echo  $mfpdata['mfpcode']?>" />
              </div>
              <?php }?>
			  <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
                 <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                                <a href="<?php echo base_url(); ?>DSOList" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                          </div>
                    </div>
                    <?php }?>
                <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='Manager') ){?>
                 <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                                <a href="<?php echo base_url(); ?>DSOList" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                          </div>
                    </div>
                    <?php }?>					
            </div>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
<br>