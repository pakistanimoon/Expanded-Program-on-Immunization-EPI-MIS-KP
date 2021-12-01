<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
    <?php if(!$this->uri->segment(4)){ ?>
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
        <?php }?> 
      <div class="panel-heading"> Driver Details
        </div>
         <div class="panel-body">
    
 <form  class="form-horizontal form-bordered" action="<?php echo base_url(); ?>System_setup/driverdb_edit">
            
              <div class="form-group">
                     <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > District </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['districtname'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" >  Driver Code </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['drivercode'];?> </span>
                </div>
                </div>
                     <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Driver Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['drivername'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Father Name</label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['fathername'];?> </span>
                </div>
                </div>


               
              </div>
 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
         <div class="form-group">
               
                     <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Marital Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['marital_status'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Phone Number </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['phone'];?> </span>
                </div>
                </div>
               <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > NIC # </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['nic'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Date of Birth</label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo isset($driverdata['date_of_birth'])? date('d-m-Y', strtotime($driverdata['date_of_birth'])) : '';?> </span>
                </div>



                </div>



            <!-- <div class="row">
               

                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Attached Supervisor</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['supervisorname'];?> </span>
                </div>

                </div> -->
                 
          </div>


         <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
              
            
              <div class="form-group">
                <div class="row">
                                 <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "permanent_address" > Permanent Address </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['permanent_address'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1 ">
                <label class="control-label"  for = "present_address" > Present Address </label>
                </div>
                <div class="col-xs-2 cmargin5">
                <span> <?php echo $driverdata['present_address'];?> </span>
                </div>
                </div>

                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "lastqualification" > Last Qualification </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['lastqualification'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "passingyear" > Passing Year </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['passingyear'];?> </span>
                </div>
                </div>

                <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "institutename" > Institute Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['institutename'];?> </span>
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
                  <span> <?php echo isset($driverdata['date_joining']) ? date('d-m-Y', strtotime($driverdata['date_joining'])) : '';?> </span>

                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Place of Joining </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['place_of_joining'];?> </span>
                </div>
                </div>

              <div class="row">                
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" > Status </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['status'];?> </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Date Termination </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo isset($driverdata['date_termination']) ? date('d-m-Y', strtotime($driverdata['date_termination'])) : '' ;?> </span>
                </div>
                </div>
              </div>
          
         
            <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
          <div class="form-group">
		  
		   <div class="row">
                      <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "basicpayscale" > Bank Information</label>
                      </div>
                      <div class="col-xs-2 col-xs-offset-1">
                        <span> <?php echo $driverdata['bank'];?> </span>
                      </div>
                     <div class="col-xs-2 col-xs-offset-1">
                        <label class="control-label"  for = "totalmonthlysalary" >Branch Code</label>
                      </div>
                      <div class="col-xs-2">
                        <span> <?php echo $driverdata['branchcode'];?> </span>
                      </div>
                    </div>
		  
		  
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" >  Bank Name </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span>  <?php echo $driverdata['branchname'];?> </span>

                </div>
                 
				<div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > Bank Account Number </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span>  <?php echo $driverdata['bankaccount'];?>  </span>
                </div>
               <!--  <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Branch Code </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['bcode'];?> </span>
                </div> -->
                </div>

              <div class="row">
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" > Basic Pay Scale </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1  cmargin5">
                  <span>  <?php echo $driverdata['payscale'];?> </span>

                </div>
                 <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Basic Pay </label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span> <?php echo $driverdata['basicpay'];?> </span>
                </div>
                <!-- <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" > Branch Name </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['branchname'];?> </span>
                </div> -->
                </div>
              </div>
          
          <!--  <div class="row bgrow"></div> -->
          

            <!--  <div class="form-group">
                <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_joining" > Basic Pay Scale </label>
                </div>
                <div class="col-xs-2  cmargin5">
                  <span>  <?php echo $driverdata['basicpayscale'];?> </span>

                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class=" control-label"  for = "place_of_joining" > Basic Pay </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['totalmonthlysalary'];?> </span>
                </div>
                </div> -->

              <!--   <div class="row">
                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" > House Rent Allowance</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span>  <?php echo $driverdata['house_rent_allowance'];?>  </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" >Convence Allowance </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php echo $driverdata['convence_allowance'];?> </span>
                </div>
                </div> -->

                    <!--  <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Medical Allowance</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                  <span>  <?php echo $driverdata['medical_allowance'];?>  </span>
                </div>
                <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "status" >Other Allowances </label>
                </div>
                <div class="col-xs-2 cmargin5">
                  <span> <?php $allowance='';
                       if(!empty($driverdata['allowances'])){
                      $allowances=explode(",",$driverdata['allowances']);
                     
                      
                      foreach($allowances as $row){

                        $query="select title, fordriver from arallowances where ar_id='$row'";
                        $re=$this->db->query($query);
                        $names=$re->row_array();
                        $allowance.= $names['title'].",";



                      }
                      echo rtrim($allowance,",");
                    }

                  ?> </span>
                </div>
                </div>
 -->
                 <!-- <div class="row">
                                  <div class="col-xs-2 col-xs-offset-1">
                <label class="control-label"  for = "date_termination" >Other Deductions</label>
                </div>
                <div class="col-xs-2 col-xs-offset-1 cmargin5">
                   <span> <?php 
				   $deduction='';
                        if(!empty($driverdata['deductions'])){
                      $deductions=explode(",",$driverdata['deductions']);
                      
                      foreach($deductions as $row){

                        $query="select title, fordriver from ardeductions where d_id='$row'";
                        $re=$this->db->query($query);
                        $names=$re->row_array();
                        $deduction.= $names['title'].",";



                      }
                      echo rtrim($deduction,",");
                    }
                  ?> </span>
                </div>
               
                </div> -->
              </div>
          



                         
                                    <hr>
              <div class="form-group">
                <div class="row">
                 
               
               <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
                  <div class="row">
                             <div class="col-xs-4 col-xs-offset-8">
                           
                               <a href=" <?php echo base_url(); ?>System_setup/driverdb_edit/<?php echo $driverdata['drivercode']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
                            
                                <a href="<?php echo base_url(); ?>System_setup/driverdb_list" type="reset" class="btn btn-md btn-success "><i class="fa fa-arrow-left"></i> Back </a>
                           
              
                </div>  <input type="hidden" name="drivercode" value="<?php echo  $driverdata['drivercode']?>" />
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