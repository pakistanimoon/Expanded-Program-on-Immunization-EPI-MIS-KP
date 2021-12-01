 <!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
    <?php if(!$this->uri->segment(4)){ ?>
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
        <?php }?> 
      <div class="panel-heading"> Technician Details
        </div>
         <div class="panel-body">
 <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/technician_edit">
         <form  class="form-horizontal form-bordered" action="technician_edit.php">
			 <div class="form-group">
                <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "distcode" > District </label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $techniciandata['districtname'];?> </p>
                    </div>
              <label class="col-xs-2 col-xs-offset-1"  for = "tcode" > Tehsil </label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $techniciandata['tehsilname'];?></p>
                      </div>
                  </div>
				     <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "facode" > EPI Center Name </label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $techniciandata['facilityname'];?> </p> 
                    </div>
              <!--<label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Technician Code </label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $techniciandata['techniciancode'];?></p>
                      </div>-->
                  </div>
				    <div class="row">
                  <label class="col-xs-2 col-xs-offset-1"  for = "supervisorname" > Technician Name</label>
                  <div class="col-xs-2 col-xs-offset-1">
                    <p><?php echo $techniciandata['technicianname'];?> </p>
                    </div>
              <label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Father Name</label>
                <div class="col-xs-2 col-xs-offset-1">
                 <p> <?php echo $techniciandata['fathername'];?></p>
                      </div>
                  </div>
				  <div class="row">
				    
						    <label class="col-xs-2 col-xs-offset-1"  for = "tcode" >  Employee Type</label>
					<div class="col-xs-2 col-xs-offset-1">
					 <p> <?php echo $techniciandata['employee_type'];?></p>
						  </div>
				  </div>
                  </div>
                      <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;padding-top: 5px; font-family: Arial; "> Basic Information</div>
                <div class="form-group">
                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >  Marital Status </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1 cmargin5">
                        <span> <?php echo $techniciandata['marital_status'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Phone Number</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $techniciandata['phone'];?> </span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "nic" > CNIC # </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1 cmargin5">
                        <span> <?php echo $techniciandata['nic'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" > Date of Birth </label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo isset($techniciandata['date_of_birth'])? date('d-m-Y', strtotime($techniciandata['date_of_birth'])) : '';?> </span>
                      </div>
                    </div>
                <div class="row">
                    <!--  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Union Council </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['unioncouncil'];?> </span>
                </div> -->
                      <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label "  for = "supervisorcode" > Supervisor Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['supervisorname'];?> </span>
                </div>
              </div>
                <div class="row">
                </div>
                                <div class="row">
                                   <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "catch_area_name" > Catchment Area Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span><?php echo $techniciandata['catch_area_name'];?> </span>
                </div>
                <div class="col-xs-3 col-xs-offset-1 col-custom">
                <label class="control-label"  for = "catch_area_pop" > Catchment Area Population </label>
                </div>
                <div class="col-xs-1 cmargin5">
                  <span> <?php echo $techniciandata['catch_area_pop'];?> </span>
                </div>
                           </div>
                          
                        </div>
                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
              <div class="form-group">
                <div class="row">
                                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "permanent_address" > Permanent Address </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['permanent_address'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1 ">
                <label class="control-label"  for = "present_address" > Present Address </label>
                </div>
                <div class="col-xs-2 cmargin5">
                <span> <?php echo $techniciandata['present_address'];?> </span>
                </div>
                </div>
                <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Last Qualification </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['lastqualification'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Passing Out Year </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $techniciandata['passingyear'];?> </span>
                </div>
                </div>
                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "institutename" > Institute Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['institutename'];?> </span>
                </div>
              </div>
            </div>
              <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>


              <div class="form-group">
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" > Date Of Joining </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo isset($techniciandata['date_joining']) ? date('d-m-Y', strtotime($techniciandata['date_joining'])) : '';?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Place of Joining </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $techniciandata['place_of_joining'];?> </span>
                </div>
                </div>
                <div class="row">                 
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" > Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['status'];?> </span>
                </div>                
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" > Post AS </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['previouse_code'];?> </span>
                </div>
                 <?php if(isset($techniciandata['date_termination']) && $techniciandata['date_termination']!=''){?>
 				         <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Date Termination </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span> <?php echo isset($techniciandata['date_termination']) ? date('d-m-Y', strtotime($techniciandata['date_termination'])) : '' ;?> </span>
                </div>
				 <?php } ?>
				 <?php if(isset($techniciandata['date_transfer']) && $techniciandata['date_transfer']!=''){?>
 				 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Date Transfer </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span> <?php echo isset($techniciandata['date_transfer']) ? date('d-m-Y', strtotime($techniciandata['date_transfer'])) : '' ;?> </span>
                </div>
				 <?php } ?>
				 <?php if(isset($techniciandata['date_died']) && $techniciandata['date_died']!=''){?>
 				 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Date Died </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span> <?php echo isset($techniciandata['date_died']) ? date('d-m-Y', strtotime($techniciandata['date_died'])) : '' ;?> </span>
                </div>
				 <?php } ?>
				 <?php if(isset($techniciandata['date_retired']) && $techniciandata['date_died']!=''){?>
 				 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Date date_retired </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span> <?php echo isset($techniciandata['date_retired']) ? date('d-m-Y', strtotime($techniciandata['date_retired'])) : '' ;?> </span>
                </div>
				 <?php } ?>
                </div>
          <div class="row">
		  <?php if(isset($techniciandata['reason']) && $techniciandata['reason']!=''){ ?>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Reason</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $techniciandata['reason'];?> </span>
                </div>
		  <?php } ?>
                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "areatype" > Area Type </label>
                </div>
                <div class="col-xs-1 cmargin5">
                  <span> <?php echo $techniciandata['areatype'];?> </span>
                </div>
              </div>

<!-- ==================start============================ -->
   <?php
         if ($techniciandata['status']=='Transfered') { ?>
            <div class="row">
     
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Active in District</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo get_District_Name($nic['distcode']);?> </span>
                </div>
      
                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "areatype" >Active in Tehsil</label>
                </div>
                <div class="col-xs-1 cmargin5">
                  <span> <?php echo get_Tehsil_Name($nic['tcode']);?> </span>
                </div>
              </div>

            <div class="row">
     
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Active in Union Council</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo get_UC_Name($nic['uncode']);?> </span>
                </div>
      
                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "areatype" >Active in Facility</label>
                </div>
                <div class="col-xs-1 cmargin5">
                  <span> <?php echo get_Facility_Name($nic['facode']);?> </span>
                </div>
              </div>

        <?php } ?>
                
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
								<div class="col-xs-3 control-label">
								  <label>End Date</label>
								</div>
							  </div>
							  <hr>
							  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="basic"> Basic Training </label>
           <div class="col-xs-3">
             <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['basic_training_start_date'])? date('d-m-Y', strtotime($techniciandata['basic_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['basic_training_end_date'])? date('d-m-Y', strtotime($techniciandata['basic_training_end_date'])) : '';?></p>        </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="routine_epi"> Routine EPI </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['routine_epi_start_date'])? date('d-m-Y', strtotime($techniciandata['routine_epi_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['routine_epi_end_date'])? date('d-m-Y', strtotime($techniciandata['routine_epi_end_date'])) : '';?></p>          </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="survilance"> Surveillance </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['survilance_training_start_date'])? date('d-m-Y', strtotime($techniciandata['survilance_training_start_date'])) : '';?></p>         </div>
           <div class="col-xs-3">
             <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['survilance_training_end_date'])? date('d-m-Y', strtotime($techniciandata['survilance_training_end_date'])) : '';?></p>         </div>
          </div>
		  <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="cold_chain"> Cold Chain </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['cold_chain_training_start_date'])? date('d-m-Y', strtotime($techniciandata['cold_chain_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
           <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['cold_chain_training_end_date'])? date('d-m-Y', strtotime($techniciandata['cold_chain_training_end_date'])) : '';?></p>          </div>
          </div>
		 <div class="row">
           <label class="col-xs-3 col-xs-offset-1 control-label" for="vlmis"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
            <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['vlmis_training_start_date'])? date('d-m-Y', strtotime($techniciandata['vlmis_training_start_date'])) : '';?></p>       </div>
           <div class="col-xs-3">
          <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['vlmis_training_end_date'])? date('d-m-Y', strtotime($techniciandata['vlmis_training_end_date'])) : '';?></p>       </div>
          </div>
		   <!--<div class="row">
           <label class="col-xs-3 control-label" for="epimis"> vLMIS/EPI-MIS </label>
           <div class="col-xs-3">
           <p style="padding-left: 197px; padding-top: 8px;"><?php echo isset($techniciandata['epimis_training_start_date'])? date('d-m-Y', strtotime($techniciandata['epimis_training_start_date'])) : '';?></p>          </div>
           <div class="col-xs-3">
            <p style="padding-left: 202px; padding-top: 8px;"><?php echo isset($techniciandata['epimis_training_end_date'])? date('d-m-Y', strtotime($techniciandata['epimis_training_end_date'])) : '';?></p>      </div>
          </div>-->
				</div>	

                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
                <div class="form-group">

                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $techniciandata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $techniciandata['branchcode'];?> </span>
                      </div>
                    </div>
                    
                    <div class="row">
					 <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "branchname" >  Branch Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $techniciandata['branchname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" >  Bank Account Number</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $techniciandata['bankaccountno'];?> </span>
                      </div>
                    
                    </div>

                          <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >Basic Pay Scale </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $techniciandata['payscale'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Basic Pay </label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $techniciandata['basicpay'];?> </span>
                      </div>
                    </div>               
                  </div>
                                    <hr>
               <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
                  <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                           <?php
                           if ($techniciandata['status']=='Transfered') {
                             # code...
                           }else{ ?>
                              <a href=" <?php echo base_url(); ?>System_setup/technician_edit/<?php echo $techniciandata['techniciancode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
                          <?php } ?>
                               
                                <a href="<?php echo base_url(); ?>System_setup/technician_list" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                            
                </div>  <input type="hidden" name="techniciancode" value="<?php echo  $techniciandata['techniciancode']?>" />
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