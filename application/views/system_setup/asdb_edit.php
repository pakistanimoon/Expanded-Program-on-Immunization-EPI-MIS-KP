<!--start of page content or body-->
<div class="container bodycontainer">

  <div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
       <?php  echo $this->breadcrumbs->show();?>
     </ol> 
     <div class="panel-heading"> Update Account Supervisor Form
     </div>
     <div class="panel-body">
       <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/asdb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     




             
   <div class="form-group">
            
                  
                <div class="row">
               
                        <label class="col-xs-2 control-label"  for = "facode" > District </label>
                     
                      <div class="col-xs-3 cmargin5">
                        <span> <?php echo $asdata['districtname'];?> </span>
                         
                      </div>
                  
                        <label class="col-xs-2 control-label"   for = "drivercode" >Account Supervisor Code  </label>
                    
                      <div class="col-xs-3 cmargin5">
                        <span> <?php echo $asdata['ascode'];?> </span>
                        <input type="hidden" required name="ascode" id="ascode" placeholder="AS Code"  value="<?php echo $asdata['ascode'];?>"  class="form-control "/>

                      </div>
                    </div>
                    <div class="row">
                    
                        <label class="col-xs-2 control-label"  for = "asname" > Account Supervisor Name </label>
                     
                      <div class="col-xs-3">
                       <input type="text" required name="asname" id="asname" placeholder="Account Supervisor Name"  value="<?php echo $asdata['asname'];?>"  class="form-control "/>

                      </div>
                   
                        <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                   
                      <div class="col-xs-3">
                         <input type="text"  name="  fathername" id="fathername" placeholder="Father Name"  value="<?php echo $asdata['fathername']; ?>"  class="form-control "/>
                      </div>
                    </div>

                
              </div>

 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>


 <div class="form-group">
               
                  
                <div class="row">
             <label class="col-xs-2 control-label"  for = "fathername" > Date Of Birth</label>
                <div class="col-xs-3">
                  <input type="text"  name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy" value="<?php echo isset($asdata['date_of_birth']) ? date('d-m-Y', strtotime($asdata['date_of_birth'])) : '' ;?>"  class="form-control "/>
                </div>
                  <label class="col-xs-2 control-label"  for = "facode" > NIC # </label>
                  <div class="col-xs-3">
                    <input type="text"  name="nic" id="nic" placeholder="CNIC"  value="<?php echo $asdata['nic']; ?>"  class="form-control "/>
                  </div>
                 
                </div>
                <div class="row">
                   <label class="col-xs-2  control-label"  for = "drivercode" >Permanent Address  </label>
                  <div class="col-xs-3">
                    <input type="text"  name="permanent_address" id="permanent_address" placeholder="Permanent Address "  value="<?php echo $asdata['permanent_address']; ?>"  class="form-control "/>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Present Address </label>
                    
                  <div class="col-xs-3">
                    <input type="text" required name="present_address" id="present_address" placeholder=" Present Address"  value="<?php echo $asdata['present_address'];?>"  class="form-control "/>

                  </div>
                   
                 
                </div>

                 

                <div class="row">
                 <label class="col-xs-2 control-label"  for = "fathername" > Postal Code</label>
                     
                  <div class="col-xs-3">
                    <input type="text"  name="postalcode" id="postalcode" placeholder="Father Name"  value="<?php echo $asdata['postalcode']; ?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "asname" > City </label>
                  <div class="col-xs-3">
                    <input type="text" required name="city" id="city" placeholder="City"  value="<?php echo $asdata['city'];?>"  class="form-control "/>
                  </div>
                
                </div>


                <div class="row">
                    <label class="col-xs-2 control-label"  for = "fathername" > Phone</label>
                  <div class="col-xs-3">
                    <input type="text"  name="phone" id="phone" placeholder="Phone"  value="<?php echo $asdata['phone']; ?>"  class="form-control "/>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Marital Status </label>
                     
                  <div class="col-xs-3">
                    <select id="marital_status" name="marital_status" class="form-control" size="1" >
                        <option <?php if($asdata['marital_status'] == 'Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Married">Married</option>
                        <option  <?php if($asdata['marital_status'] == 'Un Married') { echo 'selected="selected"'; } else { echo ''; } ?> value="Un Married">Un Married</option>
                        <option <?php if($asdata['marital_status'] == 'Widow') { echo 'selected="selected"'; } else { echo ''; } ?> value="Widow">Widow</option>
                        <option <?php if($asdata['marital_status'] == 'Divorced') { echo 'selected="selected"'; } else { echo ''; } ?> value="Divorced">Divorced</option>
                        <option <?php if($asdata['marital_status'] == 'Other') { echo 'selected="selected"'; } else { echo ''; } ?> value="Other">Other</option>
                    </select>
                  </div>
                   
                  
                </div>

                <div class="row">
                  <label class="col-xs-2 control-label"  for = "fathername" > Area Type</label>
                   
                  <div class="col-xs-3">
                    <select id="area_type" name="area_type" class="form-control" size="1" >
                          <option <?php if($asdata['area_type'] == 'Urban') { echo 'selected="selected"'; } else { echo ''; } ?> value="Urban">Urban</option>
                          <option <?php if($asdata['area_type'] == 'Rural') { echo 'selected="selected"'; } else { echo ''; } ?> value="Rural">Rural</option>
                    </select>
                  </div>    
                  <label class="col-xs-2 control-label"  for = "asname" > Last Qualification </label>
                      
                  <div class="col-xs-3">
                    <select name="lastqualification" id="lastqualification" class="form-control">
                        <option <?php if($asdata['lastqualification'] == 'middle') { echo 'selected="selected"'; } else { echo ''; } ?> value="middle">Middle</option>
                        <option <?php if($asdata['lastqualification'] == 'matric') { echo 'selected="selected"'; } else { echo ''; } ?> value="matric">Matric</option>
                        <option <?php if($asdata['lastqualification'] == 'fa') { echo 'selected="selected"'; } else { echo ''; } ?> value="fa">F.A/F.Sc</option>
                        <option <?php if($asdata['lastqualification'] == 'ba') { echo 'selected="selected"'; } else { echo ''; } ?> value="ba">B.A/B.Sc/B.Ed</option>
                        <option <?php if($asdata['lastqualification'] == 'ma') { echo 'selected="selected"'; } else { echo ''; } ?> value="ma">M.A/M.Sc/M.Ed</option>

                    </select>
                  </div>
                  
                 
              </div>

              <div class="row">
                 <label class="col-xs-2 control-label"  for = "fathername" > Status</label>
                     
                  <div class="col-xs-3">
                    <select id="status" name="status" class="form-control" size="1" >
                            <option <?php if($asdata['status'] == 'Active') { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>
                            <option <?php if($asdata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?> value="Transfered">Transfered</option>
                            <option <?php if($asdata['status'] == 'Terminated') { echo 'selected="selected"'; } else { echo ''; } ?> value="Terminated">Terminated</option>
                            <option <?php if($asdata['status'] == 'Died') { echo 'selected="selected"'; } else { echo ''; } ?> value="Died">Died</option>
                            <option <?php if($asdata['status'] == 'Retired') { echo 'selected="selected"'; } else { echo ''; } ?> value="Retired">Retired</option>
                    </select>
                  </div>      
                <label class="col-xs-2 control-label"  for = "asname" > Institute Name </label>
                <div class="col-xs-3">
                  <input type="text" required name="institutename" id="institutename" placeholder="Institute Name"  value="<?php echo $asdata['institutename'];?>"  class="form-control "/>
                </div>
                    
                
              </div>

              <div class="row">
                 <label class="col-xs-2 control-label"  for = "fathername" > Passing Year</label>
                <div class="col-xs-3">
                  <input type="text"  name="passingyear" id="passingyear" placeholder="Phone"  value="<?php echo $asdata['passingyear']; ?>"  class="form-control "/>
                </div>
               
              </div>






            </div>


    <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>

              <div class="form-group">
              
                  
                <div class="row">
                  <label class="col-xs-2  control-label"  for = "facode" > Date Of Joining </label>
                  <div class="col-xs-3">
                    <input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php echo isset($asdata['date_joining']) ? date('d-m-Y', strtotime($asdata['date_joining'])) : '' ;?>"/>
                  </div>
                  <label class=" col-xs-2 control-label"  for = "drivercode" >Place of Joining </label>
                  <div class="col-xs-3">
                    <input type="text" name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php echo $asdata['place_of_joining'];?>"  class="form-control "/>
                  </div>
                </div>

                <div class="row">
                  <label class="col-xs-2 control-label"  for = "asname" >Place Of Posting</label>
                  <div class="col-xs-3">
                    <input type="text"  name="place_of_posting" id="place_of_posting" placeholder="Place Of Posting"  value="<?php echo $asdata['place_of_posting'];?>"  class="form-control "/>
                  </div>
                  <label class="col-xs-2 control-label"  for = "fathername" > Designation </label>
                  <div class="col-xs-3">
                    <input type="text"  name="  designation" id="designation" placeholder="Designation"  value="<?php echo $asdata['designation']; ?>"  class="form-control "/>
                  </div>
                </div>

            </div>



 <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>

  <div class="form-group">
               
            <div class="row">
             <label class="col-xs-2 control-label"  for = "facode" >  Bank Information </label>
                <div class="col-xs-3">
                    <select id="bankcode" required name="bankcode" class="form-control" size="1" >
              <option value="">Select Bank</option>
              
                <?php 

                      foreach($resultbank as $row){

                        ?>

                        <option <?php if($asdata['bid'] == $row['branchcode'] ){ echo 'selected="selected"'; } else  { echo ''; } ?> value="<?php echo $row['branchcode']; ?>" /><?php echo $row['branchcode']."-".$row['bankname']."-".$row['branchname'];?></option>

                        <?php

                      }



                      ?>
              </select>
                </div>
                 <label class="col-xs-2 control-label"  for = "drivercode" >Bank Account Number </label>
                <div class="col-xs-3">
                  <input type="text" required name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  value="<?php echo $asdata['bankaccountno'];?>"  class="form-control "/>
                </div>
              
          </div>

          <div class="row">
                  <label class="col-xs-2 control-label"  for = "facode" >  Basic Pay Scale  </label>
                <div class="col-xs-3">
                    <select id="payscale" required name="payscale" class="form-control" size="1" >
                      <?php 
                                  
                        for($i=1;$i<23;$i++)
                        {  
                         
?>                      <option <?php if($asdata['payscale'] == 'BPS-'.$i) { echo "selected='selected'"; }else{} ?> value="<?php echo "BPS-".$i; ?>" /><?php echo "BPS-".$i ;?></option>

                      <?php }
                                ?>
                              
                              </select> 
                </div>
                <label class="col-xs-2 control-label"  for = "drivercode" >Basic Pay </label>
                <div class="col-xs-3">
                  <input type="text" required name="basicpay" id="basicpay" placeholder="Basic Pay"  value="<?php echo $asdata['basicpay'];?>"  class="form-control "/>
                </div>
             
            
          </div>
          <div class="row">
           <label class="col-xs-2 control-label"  for = "asname" >House Rent Allowance</label>
              <div class="col-xs-3">
                  <input type="text" required name="house_rent_allowance" id="house_rent_allowance" placeholder="House Rent Allowance"  value="<?php echo $asdata['house_rent_allowance'];?>"  class="form-control "/>
              </div>
                 <label class="col-xs-2 control-label"  for = "fathername" > Convence Allowance </label>
              <div class="col-xs-3">
                  <input type="text"  name="  convence_allowance" id="convence_allowance" placeholder="Convence Allowance"  value="<?php echo $asdata['convence_allowance']; ?>"  class="form-control "/>
              </div>       
             
                  
         </div>
         <div class="row">
             <label class="col-xs-2 control-label"  for = "fathername" > Medical Allowance </label>
              <div class="col-xs-3">
                  <input type="text"  name="  medical_allowance" id="medical_allowance" placeholder="Medical Allowance"  value="<?php echo $asdata['medical_allowance']; ?>"  class="form-control "/>
              </div>  
                  
         </div>
            <div class="row">
                      
                  
              <label class="col-xs-2 col-xs-2 control-label"  for = "date_joining" >Other Allowances</label>
              <?php
               $chklist=array();
               $chklist= explode(',', $asdata['allowances']);

                foreach($resultAR as $row){ ?>

                      <label class="col-xs-1 control-label"  for = "date_joining" ><?php echo $row['title']?></label>

                         <div class="col-xs-1" style="margin-top: 4px;">

                           <input type="checkbox" class="checkbox-class" <?php if(in_array($row['ar_id'],$chklist)){echo 'checked="checked"';} ?> name="aslist[]" value="<?php echo $row['ar_id']; ?>"  />

                         </div>
               <?php     }

                ?>
               
               
          </div>

          <div class="row">
                      
                  
              <label class="col-xs-2 col-xs-2 control-label"  for = "date_joining" >Other Deductions</label>
              <?php
               $chklist=array();
               $chklist= explode(',', $asdata['deductions']);

                foreach($resultARD as $row){ ?>

                      <label class="col-xs-1 control-label"  for = "date_joining" ><?php echo $row['title']?></label>

                         <div class="col-xs-1" style="margin-top: 4px;">

                           <input type="checkbox" class="checkbox-class" <?php if(in_array($row['d_id'],$chklist)){echo 'checked="checked"';} ?> name="deductionslist[]" value="<?php echo $row['d_id']; ?>"  />

                         </div>
               <?php     }

                ?>
               
               
          </div>

      </div>

 







            <hr>
<input type="hidden" name="edit" value="edit />
            <div class="row">
             <div class="col-xs-7 cmargin21" >

               <button type="submit" class="btn btn-md btn-primary bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>

               <button type="reset" class="btn btn-md btn-primary"><i class="fa fa-repeat"></i> Reset Form </button>

               <a href="<?php echo base_url();?>System_setup/asdb_list" class="btn btn-md btn-primary"><i class="fa fa-times"></i> Cancel </a>

             </div>

           </div>



         </form>



       </div> <!--end of panel body-->
     </div> <!--end of panel panel-primary-->
   </div><!--end of row-->

 </div><!--End of page content or body-->


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
            e.preventDefault();
            var code = $('#ascodel').val();
           

              if($('#nic').val().length == 15 ){
              var nic = $('#nic').val();
              if(!checkNICNumber(nic)){
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

         

          });





          $(document).ready(function(){

            $('#bankaccount').numeric({allow:"-"});

            $(":input").inputmask();

            $("#date_of_birth").inputmask("99-99-9999");

            $("#date_joining").inputmask("99-99-9999");

            $("#passingyear").inputmask("9999");

   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only

});

//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){
    
   var nic = $(this).val();
   var code = $(ascode).val();

   $.ajax({ 
    type: 'POST',
    data: 'nic='+nic+'&code='+code,
    url: '<?php echo base_url();?>Ajax_calls/checkasNIC',
    
    
    success: function(data){
     if(data!=''){
      if(data=='yes'){
        $('#site_response').css('display','block');
        $('#site_response').css('color','red');
        $('#site_response').html('CNIC Already Exist For Another Account Supervisor.');
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

//////////////////////////////////////////////////////////////////////////////////

        </script>
