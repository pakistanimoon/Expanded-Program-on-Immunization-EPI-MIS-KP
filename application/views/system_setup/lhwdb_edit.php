<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update EPI Technician Form
        </div>
         <div class="panel-body">
   <form action="<?php echo base_url(); ?>System_setup/lhwdb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
        
              
   <div class="form-group">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-1">
                  
                <div class="row">
                <div class="col-xs-3">
                        <label class="control-label"  for = "facode" > Facility Name </label>
                      </div>
                      <div class="col-xs-6">
                         <input type="text" disabled="disbaled" class="form-control" value="<?php echo $lhwdata['facilityname']?>" />
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "Techniciancode" > Technician Code </label>
                      </div>
                      <div class="col-xs-6 cmargin5">
                        <span> <?php echo $lhwdata['lhwcode'];?> </span>
                        <input type="hidden" required name="  lhwcode" id="lhwcode" placeholder="LHW Code"  value="<?php echo $lhwdata['lhwcode'];?>"  class="form-control "/>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "lhwname" > LHW Name </label>
                      </div>
                      <div class="col-xs-6">
                       <input type="text" required name="  lhwname" id="lhwname" placeholder="LHW Name"  value="<?php echo $lhwdata['lhwname'];?>"  class="form-control "/>

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "husbandname" > Husband Name </label>
                      </div>
                      <div class="col-xs-6">
                         <input type="text"  name="  husbandname" id="husbandname" placeholder="Husband Name"  value="<?php echo $lhwdata['husbandname']; ?>"  class="form-control "/>
                      </div>

                    </div>
                    <div class="row">
                      <div class="col-xs-3">
                        <label class="control-label"  for = "fathername" > Father Name </label>
                      </div>
                      <div class="col-xs-6">
                         <input type="text"  name="  fathername" id="fathername" placeholder="Father Name"  value="<?php echo $lhwdata['fathername']; ?>"  class="form-control "/>
                      </div>
                    </div>

                  </div>



                  <div class="col-xs-2 col-xs-offset-2">
                   <img width="150" height="200" src="<?php if(file_exists(base_url().'includes/lhwpictures/lhw_$'.$lhwdata['lhwcode'].'.jpg')) {echo base_url().'includes/lhwpictures/lhw_$'.$lhwdata['lhwcode'].'.jpg';}else{echo base_url().'includes/lhwpictures/lhw_default_image.png';}?>">    
                   <input type="file" name="lhwpicture" accept="image/*" id="image_file" onchange="fileSelectHandler()" />
     
                    
                    <div class="error"></div>

                  
                  </div>

                </div>
              </div>



                  <div class="row bgrow"></div>




        

              <div class="form-group">
<div class="row">
                <label class="col-xs-2 control-label"  for = "bankbranch" > Bank Branch </label>
                  <div class="col-xs-3">
                    <input required name="bankbranch" id="bankbranch" placeholder="Full Branch Name"  class="form-control " value="<?php echo $lhwdata['bankbranch']; ?>"/>
    </div>

                  <label class="col-xs-2 control-label"  for = "nic" >Bank Account Number</label>

                <div class="col-xs-3">

                  <input name="bankaccount" id="bankaccount" placeholder="Account No."  class="form-control " value="<?php echo $lhwdata['bankaccount'];?>"/>

                </div>
            
                  </div>

                  <div class="row">
                   <label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth </label>

                <div class="col-xs-3">

                  <input type="text" name="  date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  value="<?php echo isset($lhwdata['date_of_birth']) ? date('d-m-Y', strtotime($lhwdata['date_of_birth'])) : '' ;?>"  class="form-control "/>

                </div>
                  <label class="col-xs-2 control-label"  for = "nic" > NIC # </label>

                <div class="col-xs-3">

                  <input required name="  nic" id="nic" placeholder="NIC #"  value="<?php echo $lhwdata['nic'];?>"  class="form-control "/>

                </div>

                  </div>


  <div class="row">
                  <label class="col-xs-2 control-label"  for = "distcode" > District </label>
                  <div class="col-xs-3">
                   <select id="distcode" name="distcode" class="form-control" size="1" >



                    <?php 

                    foreach($result as $row){

                      ?>

                      <option value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option>

                      <?php

                    }



                    ?>



                  </select>

                    </div>
                    </div>
                  </div>
                <div class="row bgrow"></div>



             

         

           

                <div class="form-group">

                 <div class="row">

                           <label class="col-xs-2 control-label"  for = "lhscode" > LHS Name </label>

                  <div class="col-xs-3">

                    <select id="lhscode" required name="lhscode" class="form-control" size="1" >

                      <?php 

                      foreach($resultLhs as $row){

                        ?>

                        <option <?php if($lhwdata['lhscode'] == $row['lhscode'] ){ echo 'selected="selected"'; } else  { echo ''; } ?> value="<?php echo $row['lhscode']; ?>" /><?php echo $row['lhsname']; ?></option>

                        <?php

                      }



                      ?>

                    </select>

                  </div>
                      <label class="col-xs-2 control-label"  for = "tcode" > Tehsil </label>

                  <div class="col-xs-3">

                    <select id="tcode" required name="tcode" class="form-control" size="1" >

                      <?php 

                      foreach ($resultTeh as $row){

                        ?>

                        <option <?php if($lhwdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode'];?>" /><?php echo $row['tehsil']; ?></option>

                        <?php

                      }



                      ?>

                    </select>

                  </div>
                      </div>




<div class="row">
                       <label class="col-xs-2 control-label"  for = "uncode" > Union Council </label>

                  <div class="col-xs-3">

                    <select id="uncode" required name="uncode" class="form-control" size="1" >

                      <?php 

                      foreach($resultUnC as $row){

                        ?>

                        <option <?php if($lhwdata['uncode'] == $row['uncode']) { echo 'selected="selected"'; } else{ echo ''; } ?> value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name'];?></option>

                        <?php

                      }



                      ?>

                    </select>

                  </div>

                      <label class="col-xs-2 control-label"  for = "catch_area_pop" > Catchment Area Population </label>

                  <div class="col-xs-3">

                  <input type="number" required name="  catch_area_pop" id="catch_area_pop" placeholder="Catchment Area Population"  value="<?php echo $lhwdata['catch_area_pop'];?>"  class="form-control "/>

                  </div>
                      </div>

<div class="row">
                      <label class="col-xs-2 control-label"  for = "catch_area_name" > Catchment Area Name </label>

                  <div class="col-xs-3">

                    <input type="text" required name="  catch_area_name" id="catch_area_name" placeholder="Catchment Area Name"  value="<?php echo $lhwdata['catch_area_name'];?>"  class="form-control "/>

                  </div>
                    </div>

                  

                 </div>
    <div class="row bgrow"></div>


             
 <div class="form-group">    
              <div class="row">
                  <label class="col-xs-2 control-label"  for = "permanent_address" > Permanent Address </label>

                  <div class="col-xs-3">

                    <input type="text" required name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  value="<?php echo $lhwdata['permanent_address'];?>"  class="form-control "/>

                  </div>

            <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>

                  <div class="col-xs-3">

                    <input type="text" required name="  present_address" id="present_address" placeholder="Present Address"  value="<?php echo $lhwdata['present_address'];?>"  class="form-control "/>

                  </div>
                      </div>


                      <div class="row">
                       <label class="col-xs-2 control-label"  for = "lastqualification" > Last Qualification </label>

                  <div class="col-xs-3">

                    <select name="lastqualification" id="lastqualification" class="form-control">

                      <option  <?php if($lhwdata['lastqualification'] == 'middle') { echo 'selected="selected"'; } else { echo ''; } ?> value="middle">Middle</option>

                      <option <?php if($lhwdata['lastqualification'] == 'matric') { echo 'selected="selected"'; } else { echo ''; } ?> value="matric">Matric</option>

                      <option <?php if($lhwdata['lastqualification'] == 'fa') { echo 'selected="selected"'; } else { echo ''; } ?> value="fa">F.A/F.Sc</option>

                      <option <?php if($lhwdata['lastqualification'] == 'ba') { echo 'selected="selected"'; } else { echo ''; } ?> value="ba">B.A/B.Sc/B.Ed</option>

                      <option <?php if($lhwdata['lastqualification'] == 'ma') { echo 'selected="selected"'; } else { echo ''; } ?> value="ma">M.A/M.Sc/M.Ed</option>



                    </select>

                  </div>
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Year </label>

                  <div class="col-xs-3">

                    <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Year"  value="<?php echo $lhwdata['passingyear'];?>"  class="form-control "/>

                  </div>
                     </div>
</div>
                  <div class="row bgrow"></div>


  <div class="row">
                <label class="col-xs-2 control-label"  for = "institutename" > Institute Name </label>

                  <div class="col-xs-3">

                    <input type="text" name="  institutename" id="institutename" placeholder="Institute Name"  value="<?php echo $lhwdata['institutename'];?>"  class="form-control "/>

                  </div>
                      <label class="col-xs-2 control-label"  for = "date_joining" > Date Of Joining </label>

                  <div class="col-xs-3">

                    <input type="text" required name="  date_joining" id="date_joining" placeholder="Date Of Joining"  value="<?php echo isset($lhwdata['date_joining']) ? date('d-m-Y', strtotime($lhwdata['date_joining'])) : '' ;?>"  class="form-control "/>

                  </div>
                      </div>


  <div class="row">
                      <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>

                  <div class="col-xs-3">

                    <input type="text" name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  value="<?php echo $lhwdata['place_of_joining'];?>"  class="form-control "/>

                  </div>
                       <label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>

                  <div class="col-xs-3">

                    <input type="text" name="  date_termination" id="date_termination" placeholder="Date Termination"  value="<?php echo isset($lhwdata['date_termination']) ? date('d-m-Y', strtotime($lhwdata['date_termination'])) : '' ;?>"  class="form-control "/>

                  </div>

                    </div>

 <div class="row">
                             <label class="col-xs-2 control-label"  for = "status" > Status </label>

                  <div class="col-xs-3">

                    <select id="status" name="status" class="form-control" size="1" >

                      <option <?php if($lhwdata['status'] == 'Active') { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>

                        <option <?php if($lhwdata['status'] == 'Terminated') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Terminated">Terminated</option>

                        <option <?php if($lhwdata['status'] == 'Died') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Died">Died</option>

                        <option <?php if($lhwdata['status'] == 'Retired') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Retired">Retired</option>
                        
                        <option <?php if($lhwdata['status'] == 'Transfered') { echo 'selected="selected"'; } else { echo ''; } ?>  value="Transfered">Transfered</option>

                      </select>

                    </div>
 <label class="col-xs-2 control-label"  for = "areatype" > Area Type </label>

                    <div class="col-xs-3">

                      <div class="radio-group">

                        <label class="radio-inline">

                          <input <?php if($lhwdata['areatype'] == 'rural') { echo 'checked="checked"'; } else { echo ''; } ?>  type="radio" value="rural" name="areatype">Rural

                        </label>

                        <label class="radio-inline">

                          <input <?php if($lhwdata['areatype'] == 'urban') { echo 'checked="checked"'; } else { echo ''; } ?>   type="radio" value="urban" name="areatype">Urban

                        </label>

                      </div>

                    </div>

                      
                    </div>
<div class="row">
                     <label class="col-xs-2 control-label"  for = "basic_training_start_date" > Basic Training Start Date </label>

                      <div class="col-xs-3">

                        <input type="text" name="  basic_training_start_date" id="basic_training_start_date" placeholder="Basic Training Start Date"  value="<?php echo isset($lhwdata['basic_training_start_date']) ? date('d-m-Y', strtotime($lhwdata['basic_training_start_date'])) : '' ;?>"  class="form-control "/>

                      </div>
                       <label class="col-xs-2 control-label"  for = "basic_training_end_date" > Basic Training End Date </label>

                      <div class="col-xs-3">

                        <input type="text" name="  basic_training_end_date" id="basic_training_end_date" placeholder="Basic Training End Date"  value="<?php echo isset($lhwdata['basic_training_end_date']) ? date('d-m-Y', strtotime($lhwdata['basic_training_end_date'])) : '' ;?>"  class="form-control "/>

                      </div>

                    </div>

                    <div class="row">
                    <label class="col-xs-2 control-label"  for = "tenmonth_training_start_date" > Ten Month Training Start Date </label>

                      <div class="col-xs-3">

                        <input type="text" name="  tenmonth_training_start_date" id="tenmonth_training_start_date" placeholder="Ten Month Training Start Date"  value="<?php echo isset($lhwdata['tenmonth_training_start_date']) ? date('d-m-Y', strtotime($lhwdata['tenmonth_training_start_date'])) : '' ;?>"  class="form-control "/>

                      </div>
                        <label class="col-xs-2 control-label"  for = "tenmonth_training_end_date" > Ten Month Training End Date </label>

                      <div class="col-xs-3">

                        <input type="text" name="  tenmonth_training_end_date" id="tenmonth_training_end_date" placeholder="Ten Month Training End Date"  value="<?php echo isset($lhwdata['tenmonth_training_end_date']) ? date('d-m-Y', strtotime($lhwdata['tenmonth_training_end_date'])) :'' ;?>"  class="form-control "/>

                      </div>

                    </div>
                    <hr>
                 <input type="hidden" name="edit" value="edit />
                                          
                      <div class="row">
                            <div class="col-xs-7 cmargin21" >

                            <button type="submit" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>

                          <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>

                          <a href="<?php echo base_url();?>System_setup/lhwdb_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
                       
                      
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

            $('#basic_training_end_date').datepicker(options);

            $('#tenmonth_training_start_date').datepicker(options);

            $('#tenmonth_training_end_date').datepicker(options);

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

            $('#date_termination').datepicker(options);

            $('#basic_training_start_date').datepicker(options);

            $('#basic_training_end_date').datepicker(options);

            $('#tenmonth_training_start_date').datepicker(options);

            $('#tenmonth_training_end_date').datepicker(options);

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
     $(document).on('change','#tenmonth_training_end_date', function(){
      
      var end_date = $(this).val().split('-');
      var endDate = new Date(end_date[2],end_date[1]-1,end_date[0]);
      var start_date = $('#tenmonth_training_start_date').val();
      start_date = start_date.split('-');
      var startDate = new Date(start_date[2],start_date[1]-1,start_date[0]);
    
    
      if(startDate > endDate){
        alert('End Date Must be Greater or Equal than start date.');
        $('#tenmonth_training_end_date').val('__-__-____');
        $('#tenmonth_training_end_date').css('border-color','red');
      }
      else if(startDate <= endDate){
        $('#tenmonth_training_end_date').css('border-color','#66AFE9');
        //alert('No Error'+end_date);
      }

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

            $("#basic_training_end_date").inputmask("99-99-9999");

            $("#basic_training_start_date").inputmask("99-99-9999");

            $("#tenmonth_training_start_date").inputmask("99-99-9999");

            $("#tenmonth_training_end_date").inputmask("99-99-9999");



            $("#passingyear").inputmask("9999");

   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only

});

        </script>
