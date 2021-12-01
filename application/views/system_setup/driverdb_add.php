<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();
		   $district=$this -> session -> District;
		   
		   ?>
        </ol> 
      <div class="panel-heading"> New Driver Form
        </div>
         <div class="panel-body">
     <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/driverdb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     
            
             <div class="form-group">
                <div class="row">
                  <label class="col-xs-12 col-xs-offset-1 control-label" style="font-size: 15px;">Note: <i>Fields marked with </i><span style="color:red;">*</span> <i>(asterisk) are mandatory.</i></label>
                </div>
                <div class="row">
                 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District <span style="color:red;">*</span></label>
           <div class="col-xs-3">
             <select id="distcode" name="distcode" class="form-control" size="1" >
                             <!-- <option value=""></option> -->
                              <?php 
                              foreach($result as $row){
                                ?>
                                <option value="<?php echo $row['distcode'];?>" /><?php echo $row['district'];?>
                                  <?php
                                }
                                ?>
                                </select>
              <?php //} ?>

            </div>

                </div>

                <!-- <div class="row">                  

                <label class="col-xs-2  col-xs-offset-1 control-label lbl-search"  for = "tcode" > Tehsil </label>
                    <div class="col-xs-3">
                      <select id="tcode" name="tcode" class="form-control" size="1" >
                          <option value="">Select Tehsil</option>
                        <?php 
                        foreach($resultTeh as $row){
                          ?>
                          <option value="<?php echo $row['tcode'];?>" /><?php echo $row['tehsil'];?>
                            <?php
                          }

                          ?>
                        </select>
                      </div>

                 <label class="col-xs-2 control-label lbl-search"  for = "facode" > Facility Name </label>
                <div class="col-xs-3">
                  <select id="facode" required name="facode" class="form-control" size="1" >
                    <option value="">Select Facility</option>
                    <?php 
                    foreach($resultFac as $row){
                      ?>
                      <option value="<?php echo $row['facode'];?>" /><?php echo $row['fac_name'];?>
                        <?php
                      }

                      ?>
                    </select>
                  </div>
                 
                  </div>-->
                  






                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"   for = "drivercode" > Driver Code <span style="color:red;">*</span></label>
                   <input type="hidden" name="drivercode" id="drivercode" required >
                  <div class="col-xs-1 cmargin18">
                  <input type="text" disabled="disabled"  class="form-control  right" style="text-align: -webkit-right;" id="drivercodef" value="D.Code" />
                  </div>
                  
				  
                  <div class="col-xs-2 cmargin19">
                     <input type="text" disabled="disabled" style=" text-align: -webkit-left;" required name="drivercodel" id="drivercodel" placeholder="code"  class="form-control " value=""/></div>
                  
                  <label class="col-xs-2 control-label"  for = "lhwname" > Driver Name <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                   <input type="text" required name="drivername" id="drivername" placeholder="Driver Name"  class="form-control " value="<?php echo set_value('drivername'); ?>"/><?php echo form_error('drivername'); ?> </div>
                  </div>
                  <div class="row">
                    <label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Father Name <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                   <input type="text" name="fathername" id="fathername" placeholder="Father Name"  class="form-control " value="<?php echo set_value('fathername'); ?>"/><?php echo form_error('fathername'); ?>

                   </div>

                   <!-- <label class="col-xs-2 control-label"  for = "officer_type" > Attached Officer</label>
                    <div class="col-xs-3">
                      <select id="officer_type" required name="officer_type" class="form-control" size="1" >
                        <option value="Supervisor">Supervisor</option>
                        <option value="ADC">ADC</option>
                        <option value="DC">DC</option>
                        <option value="FPO">FPO</option>
                        </select>
                      </div> -->

                        <!-- <label class="col-xs-2 control-label"  for = "lhscode" > Attached Supervisor</label>
                    <div class="col-xs-3">
                      <select id="supervisorcode" required name="supervisorcode" class="form-control" size="1" >
                      <option value="">Select</option>
                        <?php 

                        foreach($resultSupervisor as $row){
                          ?>
                          <option value="<?php echo $row['supervisorcode'];?>" /><?php echo $row['supervisorname'];?>
                            <?php
                          }

                          ?>
                        </select>
                      </div> -->
                
                        
                  </div>


                  <!--   <div class="row">

                        <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhscode" > Attached Supervisor</label>
                    <div class="col-xs-3">
                      <select id="supervisorcode" required name="supervisorcode" class="form-control" size="1" >
                      <option value="">Select</option>
                        <?php 

                        foreach($resultSupervisor as $row){
                          ?>
                          <option value="<?php echo $row['supervisorcode'];?>" /><?php echo $row['supervisorname'];?>
                            <?php
                          }

                          ?>
                        </select>
                      </div>
                  </div> -->
                    
             
                  </div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>       
            

          
             <div class="form-group">
               <div class="row">
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" >  Marital Status  </label>
           <div class="col-xs-3">
              <select id="marital_status" name="marital_status" class="form-control" size="1" >
                    <option value="Married">Married</option>
                    <option value="Un Married">Un Married</option>
                     <option value="Widow">Widow</option>
                    <option value="Divorced">Divorced</option>
                     <option value="Other">Other</option>
                  </select>







            </div>
              <label class="col-xs-2 control-label"  for = "place_of_joining" >Phone Number </label>
                <div class="col-xs-3">
                  <input type="text"  name="phone" id="phone" placeholder="Phone Number"  class="form-control numberclass" value=""/>
                </div>
               
              </div>


                 <div class="row">






                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" > NIC # <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                     <input required name="nic" id="nic" placeholder="NIC #"  class="form-control " value=""/><span id="site_response"></span>
                  </div>
                  <label class="col-xs-2 control-label" > Date of Birth <span style="color:red;">*</span></label>
                  <div class="col-xs-3">
                     <input type="text" name="date_of_birth" id="date_of_birth" placeholder="dd-mm-yyyy"  class="form-control " value=""/></div>
                  </div>
                  <!--<div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District </label>
                  <div class="col-xs-3">
                     <select id="distcode" name="distcode" class="form-control" size="1" >

                              <?php 
                              foreach($result as $row){
                                ?>
                                <option value="<?php echo $row['distcode'];?>" /><?php echo $row['district'];?>
                                  <?php
                                }

                                ?>
                                </select>


                    </div>
                    <label class="col-xs-2 control-label"  for = "uncode" > Union Council </label>
                      <div class="col-xs-3">
                        <select id="uncode" required name="uncode" class="form-control" size="1" >
                          <?php 
                          foreach ($resultUnC as $row){
                            ?>
                            <option value="<?php echo $row['uncode'];?>" /><?php echo $row['un_name'];?>
                              <?php
                            }

                            ?>
                          </select>
                        </div>
                    


                    </div>-->


                  </div>
                  <br>

                <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>

              
                <div class="form-group">
                                       <div class="row">

                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  class="form-control " value=""/>
                      </div>
                      <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  present_address" id="present_address" placeholder="Present Address"  class="form-control " value=""/>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label>
                      <div class="col-xs-3">
                        <select name="lastqualification" id="lastqualification" class="form-control">
                          <option value="Middle">Middle</option>
                          <option value="Matric">Matric</option>
                          <option value="F.A">F.A/F.Sc</option>
                          <option value="B.A">B.A/B.Sc/B.Ed</option>
                          <option value="M.A">M.A/M.Sc/M.Ed</option>
						  <option value="SE">Software Engineering</option>

                        </select>

                      </div>
                      <label class="col-xs-2 control-label"  for = "passingyear" > Passing Year </label>
                      <div class="col-xs-3">
                        <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Year"  class="form-control " value=""/>
                      </div>
                      </div>
                      <div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  institutename" id="institutename" placeholder="Institute Name"  class="form-control " value=""/>
                      </div>

                    
                    </div>
                  </div>
            <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>

              
                           <div class="form-group">    
                  <div class="row">
                  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date Of Joining </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value=""/>
                      </div>
                      <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value=""/>
                      </div>
                      </div>
                      <div class="row">
                      
                      <label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
                      <div class="col-xs-3">
                        <select id="status" name="status" class="form-control" size="1" >
                          <option value="Active">Active</option>
                          <!--<option value="Transfered">Transfered</option>
                          <option value="Terminated">Terminated</option>
                          <option value="Died">Died</option>
                          <option value="Retired">Retired</option>-->
                        </select>
                      </div>

                      <!--<label class="col-xs-2 control-label"  for = "date_termination" > Date Termination </label>
                      <div class="col-xs-3">
                        <input type="text"  name="  date_termination" id="date_termination" placeholder="Date Termination"  class="form-control " value=""/>
                      </div>-->
                     </div>

                    </div>
                  <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
                       
       <!---         <div class="form-group">    
              <div class="row">
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > Bank Information <span style="color:red;">*</span></label>
           <div class="col-xs-3">
             <select id="bankcode"  name="bankcode" class="form-control" size="1" >
              <option value="">Select Bank</option>
              ?php 
              foreach($resultbank as $row){
                ?>
                <option value="?php echo $row['bankid'];?>" >?php echo $row['bankcode']."-".$row['bankname'];?></option>
                  ?php
                }

                ?>
              </select>


            </div>
			<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="?php echo set_value('branchcode'); ?>"/>?php echo form_error('branchcode'); ?>
		</div>
			</div>
			
               
              <div class="row">
			  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name <span style="color:red;">*</span></label>
		     <div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="?php echo set_value('branchname'); ?>"/>?php echo form_error('branchname'); ?>
		    </div>
			  
              <label class="col-xs-2 control-label"  for = "place_of_joining" >Bank Account Number <span style="color:red;">*</span></label>
                <div class="col-xs-3">
                  <input type="text"  name="bankaccount" id="bankaccount" placeholder="Bank Account Number"  class="form-control " value=""/>
                </div>
			  
			  
			  </div>

               <div class="row"> 
                 <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Basic Pay Scale <span style="color:red;">*</span></label>
                <div class="col-xs-3">
                  <select id="basicpayscale"  name="basicpayscale" class="form-control" size="1" >
                                <option value="">Select Pay Scale</option>
                                ?php 
                                  
                        for($i=1;$i<23;$i++)
                        {?>
                          
                          <option value="?php echo "BPS-".$i ;?>" />?php echo "BPS-".$i ;?>
                      ?php }
                                ?>
                              
                              </select>
                </div>
                <label class="col-xs-2 control-label"  for = "place_of_joining" >Basic Pay <span style="color:red;">*</span></label>
                <div class="col-xs-3">
                  <input type="text"  name="totalmonthlysalary" id="totalmonthlysalary" placeholder="Basic Pay"  class="form-control " value=""/>
                </div>
               
               
              </div>

              




            </div> ----->
			 <div class="form-group">
	   <!--yea change kia ha 25-->
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			  <select id="bankid"  name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>" <?php echo set_select('bankid',$row['bankid']); ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php echo set_value('branchcode'); ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php echo set_value('branchname'); ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php echo set_value('bankaccountno'); ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			  <select id="payscale"  name="payscale" class="form-control" size="1" >
						<option value="">Select Pay Scale</option>
						<?php 
						for($i=1;$i<23;$i++){?>
		  <option value="<?php echo "BPS-".$i ;?>" <?php echo set_select('payscale',"BPS-".$i); ?> /><?php echo "BPS-".$i ;?>
			  <?php }
						?>
																			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay <span style="color:red;">*</span></label>
		<div class="col-xs-3">
			 <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
													</div>





            <hr>
                     
                

                    <hr>
                                            
                      <div class="row">
					  <div class="col-xs-11" style="padding:0px; text-align:right;">
                             <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save </button>
							<!--- <button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit </button>-->

                             <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>

                             <a href="<?php echo base_url();?>System_setup/driverdb_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>

                      </div>
                      
                    </div>
                  
                

            </form>


    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->

</div><!--End of page content or body-->


    
  <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>       
 
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
             var code = $('#drivercodel').val();
            if(checkCode(code)){

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

            }else{
              alert('Please Enter Correct Driver Code');
              $('drivercodel').focus();
            }
             
          });
          
          $('#nic').blur(function (){
            

          });

          /*$('#drivercodel').keyup(function (){

            var drivercodel = $('#drivercodel').val();
            var drivercodef = +$('#drivercodef').val();
            var facode = "";
            var distcode="";
            

            

            if(/^\d+$/.test(drivercodel) )
            {
              //alert(drivercodef);
              if($('#drivercodel').val().length == 4)
              {

                //alert('asdkjhsdja');
                $('#drivercodel').css('border-color','#dbe1e8');
                distcode = $('#distcode').val();
                var drivercodel  = $('#drivercodel').val();
                var newVal = distcode+""+drivercodel;
                //alert(newVal);
                $('#drivercode').val(newVal);
                //alert($('#lhscode').val());
                $.ajax({
                  type: "GET",
                  data: "distcodedriver="+newVal,
                  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
                  success: function(result){
                    console.log(result);
                    if(result.trim() == "0"){
                      $('#drivercode').val(newVal);

                    }else{
                      alert('The Code '+newVal+' already exists, please try some other code');
                      $('#drivercodel').val('');
                      $('#drivercodel').css('border-color','red');
                    }
                  }

                });


              }else
              {
                $('#drivercodel').css('border-color','red');
              }
              
            }
            else
            {
              $('#drivercodel').css('border-color','red');
            }
            
            //alert($('#lhscode').val());
            
         }); */
  $(document).ready(function () {
//$('#distcode').on('change' , function (){
  var distcode = $('#distcode').val();
      $('#drivercodel').val('');
      $('#drivercodef').val(distcode);
  
  $.ajax({
    type: "GET",
    data: "distcodedriver="+distcode,
    async: false,
    url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
    success: function(result){
		
      $('#drivercodel').val(result);
      var drivercodel  = $('#drivercodel').val();
      var newVal = distcode+""+drivercodel;
      $('#drivercode').val(newVal);

    }

  });
  
     /* $.ajax({
    type: "POST",
    data: "distcode="+distcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getBranches",

    success: function(result){
      $('#bankcode').html(result);
    } */

  });
  


  $('#facode').on('change' , function (){           

var e = document.getElementById("officer_type");
var officerType = e.options[e.selectedIndex].text;

if(officerType=='LHS'){

var facode = this.value;

 $.ajax({
    type: "GET",
   
    url: "<?php echo base_url(); ?>Ajax_calls/getFacitityLhs/"+facode,
    success: function(result){
      $('#lhscode').html(result);
    }

  });
}
});


$('#tcode').on('change' , function (){
  var tcode = this.value;
  var facode = "";



  $.ajax({
    type: "POST",
    data: "tcode="+tcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
    success: function(result){
      $('#facode').html(result);
    }

  });
 /* $.ajax({
    type: "GET",
    //data: "tcode="+tcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
    success: function(result){
      $('#uncode').html(result);
    }

  });*/
});
</script> 
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
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
    //$('#date_termination').datepicker(options);
    $('#basic_training_start_date').datepicker(options);
   // $('#basic_training_end_date').datepicker(options);
    $('#tenmonth_training_start_date').datepicker(options);
    //$('#tenmonth_training_end_date').datepicker(options);
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
    $("#lhwcodel").inputmask("999");
    $("#date_joining").inputmask("99-99-9999");
    $("#date_termination").inputmask("99-99-9999");
   // $("#basic_training_end_date").inputmask("99-99-9999");
    $("#basic_training_start_date").inputmask("99-99-9999");
    $("#tenmonth_training_start_date").inputmask("99-99-9999");
    //$("#tenmonth_training_end_date").inputmask("99-99-9999");

    // $("#totalmonthlysalary").inputmask("999999");
    // $("#bankaccount").inputmask("9999999999999999");
    $("#phone").inputmask("99999999999");


    $("#passingyear").inputmask("9999");
   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
});

  //////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){
    
    var nic = $(this).val();
   
   $.ajax({ 
    type: 'POST',
    data: "nic="+nic,
    url: '<?php echo base_url();?>Ajax_calls/checkLhwNIC',
    
    //dataType: "json",
    success: function(data){
     if(data!=''){
      if(data=='yes'){
        $('#site_response').css('display','block');
        $('#site_response').css('color','red');
        $("#site_response").html('CNIC Already Exist For Another LHW.');
        $('#nic').css('border-color','red');
      }
      else{
        $('#nic').css('border-color','#66AFE9');
        $("#site_response").html('');
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
//////////////////////////////////////////////////////////////////////////////////
</script>
