<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
    <?php if(!$this->uri->segment(4)){ ?>
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
        <?php }?> 
      <div class="panel-heading"> Account Supervisor Details
        </div>
         <div class="panel-body">
     
     
 <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/asdb_edit">


        
      
            
            

                <div class="form-group">
               
                 
                  <div class="row">
                      
                       
                        <label class="col-xs-2 control-label"  for = "basicpayscale" > District </label>
                     
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $asdata['districtname'];?> </span>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Account Supervisor Code </label>
                     </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $asdata['ascode'];?> </span>
                      </div>
                    </div>
                    
                    <div class="row">
                     
                        <label class="col-xs-2 control-label"  for = "bankbranch" > Account Supervisor Name </label>
                     
                      <div class="col-xs-2 col-xs-offset-2 cmargin5">
                        <span> <?php echo $asdata['asname'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "bankaccount" > Father Name</label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $asdata['fathername'];?> </span>
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
                        <span>  <?php echo isset($asdata['date_of_birth'])? date('d-m-Y', strtotime($asdata['date_of_birth'])) : '';?> </span>
                      </div>
                    
                    
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "date_of_birth" >NIC # </label>
                      </div>
                      <div class="col-xs-2 cmargin5">
                        <span> <?php echo $asdata['nic'];?> </span>
                      </div>
                    </div>

                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "distcode" > Permanent Address </label>
                  </div>
                    <div class="col-xs-2 col-xs-offset-2 cmargin5">
                    <span> <?php echo $asdata['permanent_address'];?> </span>
                    </div>
                      <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Present Address </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['present_address'];?> </span>
                </div>
              </div>
             
              <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Postal Code </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $asdata['postalcode'];?> </span>
                </div>

                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > City </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['city'];?> </span>
                </div>
                
               </div>

            <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Marital Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $asdata['marital_status'];?> </span>
                </div>

                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Area Type </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['area_type'];?> </span>
                </div>
                
               </div>

                <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Last Qualification </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $asdata['lastqualification'];?> </span>
                </div>

                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Status </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['status'];?> </span>
                </div>
                
               </div>

                   <div class="row">
              <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "uncode" > Institute Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $asdata['institutename'];?> </span>
                </div>

                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lhscode" > Passing Year </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['passingyear'];?> </span>
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
                  <span><?php echo isset($asdata['date_joining']) ? date('d-m-Y', strtotime($asdata['date_joining'])) : '';?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1 ">
                <label class="control-label"  for = "present_address" >Place of Joining </label>
                </div>
                <div class="col-xs-2 cmargin5">
                <span> <?php echo $asdata['place_of_joining'];?> </span>
                </div>
                </div>

                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Place Of Posting</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span> <?php echo $asdata['place_of_posting'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Designation </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['designation'];?> </span>
                </div>
                </div>

            
            </div>
              <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
          
            
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" >  Bank Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span>  <?php echo $asdata['bank'];?> </span>

                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Branch Code </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['bcode'];?> </span>
                </div>
                </div>

                                <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Bank Account Number </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span>  <?php echo $asdata['bankaccountno'];?>  </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" > Branch Name </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['branchname'];?> </span>
                </div>
                </div>
              </div>
          
           <div class="row bgrow"></div>
          
            
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" > Basic Pay Scale </label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span>  <?php echo $asdata['payscale'];?> </span>

                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Basic Pay </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['basicpay'];?> </span>
                </div>
                </div>

                                <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > House Rent Allowance</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span>  <?php echo $asdata['house_rent_allowance'];?>  </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" >Convence Allowance </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $asdata['convence_allowance'];?> </span>
                </div>
                </div>

                     <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Medical Allowance</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                  <span>  <?php echo $asdata['medical_allowance'];?>  </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" >Other Allowances </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php 
                       if(!empty($asdata['allowances'])){
                      $allowances=explode(",",$asdata['allowances']);
                      
                      foreach($allowances as $row){

                        $query="select title, foras from arallowances where ar_id='$row'";
                        $re=$this->db->query($query);
                        $names=$re->row_array();
                        $allowance.= $names['title'].",";



                      }
                      echo rtrim($allowance,",");
                    }
                  ?> </span>
                </div>
                </div>

                  <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Other Deductions</label>
                </div>
                <div class="col-xs-2 col-xs-offset-2 cmargin5">
                   <span> <?php 
                        if(!empty($asdata['deductions'])){
                      $deductions=explode(",",$asdata['deductions']);
                      
                      foreach($deductions as $row){

                        $query="select title, foras from ardeductions where d_id='$row'";
                        $re=$this->db->query($query);
                        $names=$re->row_array();
                        $deduction.= $names['title'].",";



                      }
                      echo rtrim($deduction,",");
                    }
                  ?> </span>
                </div>
               
                </div>
              </div>
          
         
            <div class="row bgrow"></div>

              <div class="form-group">
                <div class="row">
                 
               


                         
                                    <hr>
               <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
                  <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                            <?php if(!$this->uri->segment(4)){ ?>
                               <a href=" <?php echo base_url(); ?>System_setup/asdb_edit/<?php echo $asdata['ascode']; ?>" class="btn btn-md btn-primary "><i class="fa fa-pencil-square-o"></i> Update </a>
                            
                                <a href="<?php echo base_url(); ?>System_setup/asdb_list" type="reset" class="btn btn-md btn-primary "><i class="fa fa-arrow-left"></i> Back </a>
                            <?php }?>
              
                </div>  <input type="hidden" name="ascode" value="<?php echo  $driverdata['ascode']?>" />
              </div>
              <?php }?>
            </div>

      </form>


    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->

</div><!--End of page content or body-->
<br>

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