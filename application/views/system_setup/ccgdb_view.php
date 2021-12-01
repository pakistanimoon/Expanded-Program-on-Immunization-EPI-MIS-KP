<!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Cold Chain Generator Operator Details
        </div>
         <div class="panel-body">
     <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/ccgdb_edit/<?php echo $ccgdata['ccgcode']; ?>">    
                             <div class="form-group">
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "distcode" > District </label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $ccgdata['districtname'];?> </p>
                    </div>
              <label class="col-xs-2 col-xs-offset-1"  for = "tcode" > Tehsil </label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $ccgdata['tehsilname'];?></p>
                      </div>
                  </div>
				     <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "facode" > EPI Center Name </label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $ccgdata['facilityname'];?> </p>
                  </div>  
              <label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Cold Chain Generator Operator Code </label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $ccgdata['ccgcode'];?></p>
                      </div>
                  </div>
				    <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "supervisorname" > Cold Chain Generator Operator Name</label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $ccgdata['ccgname'];?> </p>
                    </div>
              <label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Father Name</label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $ccgdata['fathername'];?></p>
                      </div>
                  </div>
                  </div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
                       <div class="form-group">
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "basicpayscale" >Marital Status </label>
                  <div class="col-xs-2 col-xs-offset-1">
                   <span> <?php echo $ccgdata['marital_status'];?> </span>
                  </div>
                  <label class="col-xs-2 col-xs-offset-1"  for = "totalmonthlysalary" > Phone Number </label>
                  <div class="col-xs-2">
                     <span> <?php echo $ccgdata['phone'];?> </span>
                  </div>
                  </div>
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "cnic" > CNIC # </label>
                  <div class="col-xs-2 col-xs-offset-1">
                   <p><?php echo $ccgdata['nic'];?> </p>
                  </div>
                  <label class="col-xs-2 col-xs-offset-1"  for = "date_of_birth" > Date of Birth </label>
                  <div class="col-xs-2">
                    <p><?php echo isset($ccgdata['date_of_birth'])? date('d-m-Y', strtotime($ccgdata['date_of_birth'])) : '';?>  </p>
                  </div>
                  </div>
                  </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
                <div class="form-group">
                                       <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "permanent_address" > Permanent Address </label>
                      <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo $ccgdata['permanent_address'];?> </p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "present_address" > Present Address </label>
                      <div class="col-xs-2">
                        <p><?php echo $ccgdata['present_address'];?> </p>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "lastqualification" > Last Qualification </label>
                      <div class="col-xs-2 col-xs-offset-1">
                        <p><?php echo $ccgdata['lastqualification'];?> </p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "passingyear" > Passing Year </label>
                      <div class="col-xs-2">
                        <p><?php echo $ccgdata['passingyear'];?>  </p>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "institutename" > Institute Name </label>
                      <div class="col-xs-2 col-xs-offset-1">
                        <p><?php echo $ccgdata['institutename'];?></p>
                      </div>
                    </div>
                  </div>
   <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
          <div class="form-group">    
              <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "date_joining" > Date Of Joining </label>
                      <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo isset($ccgdata['date_joining']) ? date('d-m-Y', strtotime($ccgdata['date_joining'])) : '';?></p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "place_of_joining" > Place of Joining </label>
                      <div class="col-xs-2">
                        <p><?php echo $ccgdata['place_of_joining'];?>  </p>
                      </div>
                      </div>
					   <div class="row">
						<label class="col-xs-2 col-xs-offset-1"  for = "employee_type" > Employee Type </label>
                      <div class="col-xs-2 col-xs-offset-1">
                       <p><?php echo $ccgdata['employee_type'];?> </p>
                      </div>
						</div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-2 col-xs-offset-1">
                        <p><?php echo isset($ccgdata['date_termination'])? date('d-m-Y', strtotime($ccgdata['date_termination'])) : '';?> </p>
                      </div>
                      <label class="col-xs-2 col-xs-offset-1"  for = "status" > Status </label>
                      <div class="col-xs-2">
                       <p><?php echo $ccgdata['status'];?> </p>
                      </div>
                     </div>
                   </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>   
	<div class="form-group">
							 <div class="row">
								<div class="col-xs-3 control-label">
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
           <label class="col-xs-3 control-label" for="basic"> Basic Training </label>
           <div class="col-xs-3">
             <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['basic_training_start_date'])? date('d-m-Y', strtotime($ccgdata['basic_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['basic_training_end_date'])? date('d-m-Y', strtotime($ccgdata['basic_training_end_date'])) : '';?></p>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['routine_epi_start_date'])? date('d-m-Y', strtotime($ccgdata['routine_epi_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['routine_epi_end_date'])? date('d-m-Y', strtotime($ccgdata['routine_epi_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 control-label" for="survilance"> Surveillance </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['survilance_training_start_date'])? date('d-m-Y', strtotime($ccgdata['survilance_training_start_date'])) : '';?></p>         </div>
           <div class="col-xs-3">
             <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['survilance_training_end_date'])? date('d-m-Y', strtotime($ccgdata['survilance_training_end_date'])) : '';?></p>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 control-label" for="cold_chain"> Cold Chain </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['cold_chain_training_start_date'])? date('d-m-Y', strtotime($ccgdata['cold_chain_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['cold_chain_training_end_date'])? date('d-m-Y', strtotime($ccgdata['cold_chain_training_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 control-label" for="vlmis"> vLMIS </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['vlmis_training_start_date'])? date('d-m-Y', strtotime($ccgdata['vlmis_training_start_date'])) : '';?></p>       </div>
           <div class="col-xs-3">
          <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['vlmis_training_end_date'])? date('d-m-Y', strtotime($ccgdata['vlmis_training_end_date'])) : '';?></p>       </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 control-label" for="epimis"> EPI-MIS </label>
           <div class="col-xs-3">
           <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($ccgdata['epimis_training_start_date'])? date('d-m-Y', strtotime($ccgdata['epimis_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($ccgdata['epimis_training_end_date'])? date('d-m-Y', strtotime($ccgdata['epimis_training_end_date'])) : '';?></p>      </div>
          </div>
				</div>	
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
                <div class="form-group">
                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $ccgdata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $ccgdata['branchcode'];?> </span>
                      </div>
                    </div>
                    <div class="row">
					 <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "branchname" >  Branch Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $ccgdata['branchname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" >  Bank Account Number</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $ccgdata['bankaccountno'];?> </span>
                      </div>
                    </div>
                          <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >Basic Pay Scale </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $ccgdata['payscale'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Basic Pay </label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $ccgdata['basicpay'];?> </span>
                      </div>
                    </div>
                  </div>
<input type="hidden" name="ccgcode" value="<?php echo  $ccgdata['ccgcode']?>" />
                    <hr>
                        <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>                     
                      <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                            <a href=" <?php echo base_url(); ?>CCG/Edit/<?php echo $ccgdata['ccgcode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
                                <a href="<?php echo base_url(); ?>CCGList" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                          </div>
                    </div>
                    <?php }?>
            </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->