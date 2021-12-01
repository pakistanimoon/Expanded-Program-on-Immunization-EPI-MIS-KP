<!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
    <?php if(!$this->uri->segment(4)){ ?>
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
        <?php }?> 
      <div class="panel-heading"> Data Entry Operator Details
        </div>
         <div class="panel-body">
 <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/dataentry_operator_edit">
                <div class="form-group">
                  <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "basicpayscale" > District </label>
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $deodata['districtname'];?> </span>
                      </div>
                      <!--<div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Computer Operator Code </label>
                     </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $deodata['deocode'];?> </span>
                      </div>-->
                    </div>
                    <div class="row">
                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Computer Operator Name </label>
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $deodata['deoname'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankaccount" > Father Name</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $deodata['fathername'];?> </span>
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
                        <span>  <?php echo isset($deodata['date_of_birth'])? date('d-m-Y', strtotime($deodata['date_of_birth'])) : '';?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" >CNIC # </label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $deodata['nic'];?> </span>
                      </div>
                    </div>
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "distcode" > Permanent Address </label>
                  </div>
                    <div class="col-xs-2 col-xs-offset-2 cmargin5">
                    <span> <?php echo $deodata['permanent_address'];?> </span>
                    </div>
                      <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Present Address </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['present_address'];?> </span>
                </div>
              </div>
              <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Postal Code </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['postalcode'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > City </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['city'];?> </span>
                </div>
               </div>
            <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Marital Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['marital_status'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Area Type </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['area_type'];?> </span>
                </div>
               </div>
                <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Last Qualification </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['lastqualification'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Status </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['status'];?> </span>
                </div>
               </div>
                   <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Institute Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['institutename'];?> </span>
                </div>
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Passing Year </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['passingyear'];?> </span>
                </div>
               </div>
                <div class="row">
                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Employee Type </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['employee_type'];?> </span>
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
                  <span><?php echo isset($deodata['date_joining']) ? date('d-m-Y', strtotime($deodata['date_joining'])) : '';?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1 ">
                <label class="control-label"  for = "present_address" >Place of Joining </label>
                </div>
                <div class="col-xs-2 cmargin5">
                <span> <?php echo $deodata['place_of_joining'];?> </span>
                </div>
                </div>
                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Place Of Posting</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $deodata['place_of_posting'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Designation </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $deodata['designation'];?> </span>
                </div>
                </div>
            </div>
              <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
             <div class="form-group">
                      <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $deodata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $deodata['branchcode'];?> </span>
                      </div>
                    </div>
                    <div class="row">
					 <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "branchname" >  Branch Name </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $deodata['branchname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankbranch" >  Bank Account Number</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $deodata['bankaccountno'];?> </span>
                      </div>
                    </div>
                          <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" >Basic Pay Scale </label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $deodata['payscale'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Basic Pay </label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $deodata['basicpay'];?> </span>
                      </div>
                    </div>
                  </div>
         
           
              <div class="form-group">
                <div class="row">
                                    <hr>
               <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
                  <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                          
                               <a href=" <?php echo base_url(); ?>DataEntry-Operator/Edit/<?php echo $deodata['deocode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
                                <a href="<?php echo base_url(); ?>DataEntry-Operator-List" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                            
                </div>  <input type="hidden" name="cocode" value="<?php echo  $deodata['deocode']?>" />
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