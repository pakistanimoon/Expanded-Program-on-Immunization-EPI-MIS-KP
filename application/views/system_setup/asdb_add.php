<!--start of page content or body-->
<div class="container bodycontainer">

  <div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
       <?php  echo $this->breadcrumbs->show();?>
     </ol> 
     <div class="panel-heading"> New Account Supervisor Form
     </div>
     <div class="panel-body">
       <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/asdb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     

         <div class="form-group">
          <div class="row">

           <label class="col-xs-2 control-label"  for = "distcode" > District </label>
           <div class="col-xs-3">
             <select id="distcode" required name="distcode" class="form-control" size="1" >
              <option value="">Select District</option>
              <?php 
              foreach($result as $row){
                ?>
                <option value="<?php echo $row['distcode'];?>" /><?php echo $row['district'];?>
                  <?php
                }

                ?>
              </select>


            </div>
     <label class="col-xs-2 control-label"   for = "ascode" > Account Supervisor Code </label>
              <input type="hidden" name="ascode" id="ascode" required >
              <div class="col-xs-1 cmargin18">
                <input type="text" disabled="disabled"  class="form-control  right" style="text-align: -webkit-right;" id="ascodef" value="AS.Code" />
              </div>
                <div class="col-xs-2 cmargin19">
               <input type="text" style=" text-align: -webkit-left;" required name="ascodel" id="ascodel" placeholder="code"  class="form-control " value=""/></div>


            </div>
          






            <div class="row">


            
               <label class="col-xs-2 control-label"  for = "lhwname" > Account Supervisor Name </label>
               <div class="col-xs-3">
                 <input type="text" required name="asname" id="asname" placeholder="Account Supervisor Name"  class="form-control " value=""/>  </div>

                 <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                 <div class="col-xs-3">
                   <input type="text" name="  fathername" id="fathername" placeholder="Father Name"  class="form-control " value=""/> 

                 </div>
               </div>
               




             </div>
             <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
               <div class="form-group">
              <div class="row">

               <label class="col-xs-2 control-label"  for = "date_of_birth" >Date Of Birth </label>
                <div class="col-xs-3">
                  <input type="text"  name="date_of_birth" id="date_of_birth" placeholder="Date Of Birth"  class="form-control " value=""/>
                </div>
               
               <label class="col-xs-2 control-label"  for = "nic" > NIC # </label>
                  <div class="col-xs-3">
                     <input required name="nic" id="nic" placeholder="NIC #"  class="form-control " value=""/><span id="site_response"></span>
                  </div>

              

               
              </div>

               <div class="row">  
               <label class="col-xs-2 control-label"  for = "permanent_address" > Permanent Address </label>
                <div class="col-xs-3">
                  <input type="text" required name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  class="form-control " value=""/>
                </div>
                 <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                <div class="col-xs-3">
                  <input type="text" required name="  present_address" id="present_address" placeholder="Present Address"  class="form-control " value=""/>
                </div>
               
                
              </div>

               <div class="row">
                <label class="col-xs-2 control-label"  for = "permanent_address" > Postal Code </label>
                <div class="col-xs-3">
                  <input type="text" required name="postalcode" id="postalcode" placeholder="Postal Code"  class="form-control " value=""/>
                </div>
                <label class="col-xs-2 control-label"  for = "present_address" > City </label>
                  <div class="col-xs-3">
                    <input type="text" required name="city" id="city" placeholder="City"  class="form-control " value=""/>
                  </div>
               
               
              </div>

               <div class="row">
                <label class="col-xs-2 control-label"  for = "permanent_address" > Phone </label>
                <div class="col-xs-3">
                  <input type="text" required name="phone" id="phone" placeholder="Phone"  class="form-control " value=""/>
                </div>
                <label class="col-xs-2 control-label"  for = "permanent_address" > Marital Status </label>
                <div class="col-xs-3">
                  <select id="marital_status" name="marital_status" class="form-control" size="1" >
                    <option value="Married">Married</option>
                    <option value="Un Married">Un Married</option>
                     <option value="Widow">Widow</option>
                    <option value="Divorced">Divorced</option>
                     <option value="Other">Other</option>
                  </select>
                </div>
               
              </div>

              <div class="row">
              <label class="col-xs-2 control-label"  for = "present_address" > Area Type </label>
                <div class="col-xs-3">
                  <select id="area_type" name="area_type" class="form-control" size="1" >
                    <option value="Urban">Urban</option>
                    <option value="Rural">Rural</option>
                  </select>
                </div>
                <label class="col-xs-2 control-label"  for = "lastqualification" > Last Qualification </label>
                <div class="col-xs-3">
                  <select name="lastqualification" id="lastqualification" class="form-control">
                    <option value="middle">Middle</option>
                    <option value="matric">Matric</option>
                    <option value="fa">F.A/F.Sc</option>
                    <option value="ba">B.A/B.Sc/B.Ed</option>
                    <option value="ma">M.A/M.Sc/M.Ed</option>

                  </select>

                </div>
                 
              </div>
              <div class="row">
               <label class="col-xs-2 control-label"  for = "present_address" > Status </label>
                <div class="col-xs-3">
                  <select id="status" name="status" class="form-control" size="1" >
                    <option value="Active">Active</option>
                    <option value="Transfered">Transfered</option>
                    <option value="Terminated">Terminated</option>
                    <option value="Died">Died</option>
                    <option value="Retired">Retired</option>
                  </select>
                </div>
                <label class="col-xs-2 control-label"  for = "institutename" > Institute Name </label>
                <div class="col-xs-3">
                  <input type="text"  name="  institutename" id="institutename" placeholder="Institute Name"  class="form-control " value=""/>
                </div>

               

              </div>

              <div class="row">
               <label class="col-xs-2 control-label"  for = "passingyear" > Passing Year </label>
                <div class="col-xs-3">
                  <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Year"  class="form-control " value=""/>
                </div> 
              
               
              </div>
            </div>
            <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>


            <div class="form-group"> 

              
              <div class="row">
               <label class="col-xs-2 control-label"  for = "place_of_joining" > Designation </label>
                <div class="col-xs-3">
                  <input type="text"  name="designation" id="designation" placeholder="Designation"  class="form-control " value=""/>
                </div>
                <label class="col-xs-2 control-label"  for = "date_joining" > Date Of Joining </label>
                <div class="col-xs-3">
                  <input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value=""/>
                </div>
               
              </div>

               <div class="row"> 
               <label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
                <div class="col-xs-3">
                  <input type="text"  name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value=""/>
                </div>
                <label class="col-xs-2 control-label"  for = "date_joining" >Place Of Posting </label>
                <div class="col-xs-3">
                  <input type="text"  name="place_of_posting" id="place_of_posting" placeholder="Place Of Posting"  class="form-control " value=""/>
                </div>
                
              </div>






            </div>


           <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>

                <div class="form-group">    
              <div class="row">
               <label class="col-xs-2 control-label"  for = "distcode" > Bank Information </label>
           <div class="col-xs-3">
             <select id="bankcode" required name="bankcode" class="form-control" size="1" >
              <option value="">Select Bank</option>
              <?php 
              foreach($resultbank as $row){
                ?>
                <option value="<?php echo $row['branchcode'];?>" /><?php echo $row['branchcode']."-".$row['bankname']."-".$row['branchname'];?>
                  <?php
                }

                ?>
              </select>


            </div>
              <label class="col-xs-2 control-label"  for = "place_of_joining" >Bank Account Number </label>
                <div class="col-xs-3">
                  <input type="text"  name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value=""/>
                </div>
               
              </div>

               <div class="row"> 
                 <label class="col-xs-2 control-label"  for = "date_joining" > Basic Pay Scale </label>
                <div class="col-xs-3">
                  <select id="payscale" required name="payscale" class="form-control" size="1" >
                                <option value="">Select Pay Scale</option>
                                <?php 
                                  
                        for($i=1;$i<23;$i++)
                        {?>
                          
                          <option value="<?php echo "BPS-".$i ;?>" /><?php echo "BPS-".$i ;?>
                      <?php }
                                ?>
                              
                              </select>
                </div>
                <label class="col-xs-2 control-label"  for = "place_of_joining" >Basic Pay </label>
                <div class="col-xs-3">
                  <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value=""/>
                </div>
               
               
              </div>

                <div class="row"> 
                 <label class="col-xs-2 control-label"  for = "date_joining" >House Rent Allowance </label>
                <div class="col-xs-3">
                  <input type="text"  name="house_rent_allowance" id="house_rent_allowance" placeholder="House Rent Allowance"  class="form-control " value=""/>
                </div>
                <label class="col-xs-2 control-label"  for = "place_of_joining" >Convence Allowance </label>
                <div class="col-xs-3">
                  <input type="text"  name="convence_allowance" id="convence_allowance" placeholder="Convence Allowance"  class="form-control " value=""/>
                </div>
                

               
              </div>
               <div class="row"> 
             
               <label class="col-xs-2 control-label"  for = "date_joining" > Medical Allowance </label>
                <div class="col-xs-3">
                  <input type="text"  name="medical_allowance" id="medical_allowance" placeholder="Medical Allowance"  class="form-control " value=""/>
                </div>
              </div>
               <div class="row">
                <label class="col-xs-2 control-label"  for = "date_joining" >Other Allowances</label>
                <?php foreach($resultAR as $row){ ?>

                      <label class="col-xs-1 control-label"  for = "date_joining" ><?php echo $row['title']?></label>

                         <div class="col-xs-1" style="margin-top: 4px;">

                           <input type="checkbox" class="checkbox-class" name="aslist[]" value="<?php echo $row['ar_id']; ?>"  />

                         </div>
               <?php     }

                ?>
               
               
              </div>

              <div class="row">
                <label class="col-xs-2 control-label"  for = "date_joining" >Other Deductions</label>
                <?php foreach($resultARD as $row){ ?>

                      <label class="col-xs-1 control-label"  for = "date_joining" ><?php echo $row['title']?></label>

                         <div class="col-xs-1" style="margin-top: 4px;">

                           <input type="checkbox" class="checkbox-class" name="deductionslist[]" value="<?php echo $row['d_id']; ?>"  />

                         </div>
               <?php     }

                ?>
               
               
              </div>




            </div>





            <hr>

            <div class="row">
             <div class="col-xs-7 cmargin21" >

               <button type="submit" class="btn btn-md btn-primary bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>

               <button type="reset" class="btn btn-md btn-primary"><i class="fa fa-repeat"></i> Reset Form </button>

               <a href="<?php echo base_url();?>System_setup/lhwdb_list" class="btn btn-md btn-primary"><i class="fa fa-times"></i> Cancel </a>

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
 <script src="<?php echo base_url(); ?>includes/js/jquery.Jcrop.min.js"></script>
 <script type="text/javascript" src="<?php echo base_url(); ?>includes/js/scriptCrop.js"></script>








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
    if(checkCode(code)){

      if($('#nic').val().length == 15 ){
        var nic = $('#nic').val();
        if(!checkNICNumber(nic)){
          alert('CNIC number must be complete in correct format');


        }
        else{
          this.submit();
        }


      }

    }else{
      alert('Please Enter Correct Code');
      $('ascodel').focus();
    }

  });

  $('#nic').blur(function (){


  });

  $('#ascodel').keyup(function (){

    var ascodel = $('#ascodel').val();
    var ascodef = +$('#ascodef').val();
    var facode = "";
    var distcode="";




    if(/^\d+$/.test(ascodel) )
    {
      if($('#ascodef').val().length == 7 && $('#ascodef').val().length == 4 )
      {

                //alert('asdkjhsdja');
                $('#ascodel').css('border-color','#dbe1e8');
                distcode = '<?php echo $_SESSION[District];?>';
                var ascodel  = $('#ascodel').val();
                var newVal = distcode+""+ascodel;
                //alert(newVal);
                $('#ascodel').val(newVal);
                //alert($('#lhscode').val());
                $.ajax({
                  type: "GET",
                  data: "distcodeas="+newVal,
                  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
                  success: function(result){
                    console.log(result);
                    if(result == "0"){
                      $('#ascode').val(newVal);

                    }else{
                      alert('The Code '+newVal+' already exists, please try some other code');
                      $('#ascodel').val('');
                      $('#ascodel').css('border-color','red');
                    }
                  }

                });


              }else
              {
                $('#ascodel').css('border-color','red');
              }
              
            }
            else
            {
              $('#ascodel').css('border-color','red');
            }
            
            //alert($('#lhscode').val());
            
          }); 
/*$('#distcode').on('change' , function (){
  var distcode = this.value;
  
});
*/


$('#distcode').on('change' , function (){
  var distcode = this.value;

  $('#ascodel').val('');
  $('#ascodef').val(distcode);
  
  $.ajax({
    type: "GET",
    data: "distcodeas="+distcode,
    async: false,
    url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
    success: function(result){
      $('#ascodel').val(result);
      var ascodel  = $('#ascodel').val();
      var newVal = distcode+""+ascodel;
      $('#ascode').val(newVal);

    }

  });

    $.ajax({
    type: "POST",
    data: "distcode="+distcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getBranches",

    success: function(result){
      $('#bankcode').html(result);
    }

  });
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
   
  });



  $(document).ready(function(){
    $('#bankaccount').numeric({allow:"-"});
    $(":input").inputmask();
    $("#date_of_birth").inputmask("99-99-9999");
    $("#ascodel").inputmask("99");
    $("#date_joining").inputmask("99-99-9999");

  
    $("#passingyear").inputmask("9999");
   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
 });

  //////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){

    var nic = $(this).val();

    $.ajax({ 
      type: 'POST',
      data: "nic="+nic,
      url: '<?php echo base_url();?>Ajax_calls/checkasNIC',

    //dataType: "json",
    success: function(data){
     if(data!=''){
      if(data=='yes'){
        $('#site_response').css('display','block');
        $('#site_response').css('color','red');
        $("#site_response").html('CNIC Already Exist For Another Account Supervisor.');
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

//////////////////////////////////////////////////////////////////////////////////
</script>
