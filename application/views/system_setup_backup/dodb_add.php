<!--start of page content or body-->
<div class="container bodycontainer">

  <div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
       <?php  echo $this->breadcrumbs->show();?>
     </ol> 
     <div class="panel-heading"> New Data Entry Operator Form
     </div>
          <div class="panel-body">
       <form name="dataform" id="dataform" action="<?php echo base_url(); ?>System_setup/deodb_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">     

         <div class="form-group">
          <div class="row">
          <?php //if ((($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager')) || (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') && ($_SESSION['distcode'] > 0))) {?>

           <label class="col-xs-2 col-xs-offset-1 control-label"  for = "distcode" > District </label>
           <div class="col-xs-3">
            <select id="distcode" name="distcode" class="form-control" size="1" >
                             <!-- <option value=""></option> -->
                              <?php 
                              foreach($result as $row){
                                ?>

                                <option value="<?php echo $row['distcode'];?>" /><?php echo $row['district'];?></option>
                                  <?php
                                }
                                ?>
                                </select>


 <!-- <div class="panel-body">
       
             <select id="distcode" required name="distcode" class="form-control" size="1" >
              <option value="">Select District</option>
              <?php 
              foreach($result as $row){
                ?>
                <option value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode',$row['distcode']); ?> /><?php echo $row['district'];?>
                  <?php
                }

                ?>
              </select> -->


              <?php //} ?>

            </div>
     <!--<label class="col-xs-2 control-label"   for = "deocode" > Data Entry  Operator Code </label>-->
              <input type="hidden" name="deocode" id="deocode" required value="<?php echo set_value('deocode'); ?>" >
              <div class="col-xs-1 cmargin18">
                <input type="hidden" disabled="disabled"  class="form-control  right" style="text-align: -webkit-right;" id="cocodef" value="CO.Code" />
              </div>
                <div class="col-xs-2 cmargin19">
               <input type="hidden" style=" text-align: -webkit-left;" required name="deocodel" id="deocodel" placeholder="code"  class="form-control " value="<?php echo set_value('deocodel'); ?>"/>
               </div>


            </div>
          


            <div class="row">


            
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "deoname" > Data Entry Operator Name </label>
               <div class="col-xs-3">
                 <input type="text" required name="deoname" id="deoname" placeholder="Data Entry Operator Name"  class="form-control " value="<?php echo set_value('deoname'); ?>" /> <?php echo form_error('deoname'); ?>   </div>

                 <label class="col-xs-2 control-label"  for = "fathername" > Father Name </label>
                 <div class="col-xs-3">
                   <input type="text" required name="  fathername" id="fathername" placeholder="Father Name"  class="form-control " value="<?php echo set_value('fathername'); ?>"/> <?php echo form_error('fathername'); ?>

                 </div>
               </div>
         
             </div>
             <div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
               <div class="form-group">
              <div class="row">

               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_of_birth" >Date Of Birth </label>
                <div class="col-xs-3">
                  <input type="text"  name="date_of_birth" id="date_of_birth" placeholder="Date Of Birth"  class="form-control " onchange ="dop()" value="<?php echo set_value('date_of_birth');  ?>"/>
                </div>
               
               <label class="col-xs-2 control-label"  for = "nic" > CNIC # </label>
                  <div class="col-xs-3">
                     <input  name="nic" id="nic" placeholder="Enter Your CNIC #"  class="form-control " value="<?php echo set_value('nic'); ?>"/><span id="site_response"></span>
                  </div>

              

               
              </div>

               <div class="row">  
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address </label>
                <div class="col-xs-3">
                  <input type="text"  name="  permanent_address" id="permanent_address" placeholder="Permanent Address"  class="form-control " value="<?php echo set_value('permanent_address'); ?>"/>
                </div>
                 <label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
                <div class="col-xs-3">
                  <input type="text"  name="  present_address" id="present_address" placeholder="Present Address"  class="form-control " value="<?php echo set_value('present_address'); ?>"/>
                </div>
               
                
              </div>

               <div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Postal Code </label>
                <div class="col-xs-3">
                  <input type="text"  name="postalcode" id="postalcode" placeholder="Postal Code"  class="form-control " value="<?php echo set_value('postalcode'); ?>"/>
                </div>
                <label class="col-xs-2 control-label"  for = "present_address" > City </label>
                  <div class="col-xs-3">
                    <input type="text"  name="city" id="city" placeholder="City"  class="form-control " value="<?php echo set_value('city'); ?>"/>
                  </div>
               
               
              </div>

               <div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Phone </label>
                <div class="col-xs-3">
                  <input type="text"  name="phone" id="phone" placeholder="Phone"  class="form-control numberclass" value="<?php echo set_value('phone'); ?>"/><?php echo form_error('phone'); ?>
                </div>
                <label class="col-xs-2 control-label"  for = "permanent_address" > Marital Status </label> 
                <div class="col-xs-3">
        					<select id="marital_status" name="marital_status" class="form-control" size="1" >
        						<option value="Married" <?php echo set_select('marital_status', 'Married', TRUE); ?>>Married</option>
        						<option value="Un Married" <?php echo set_select('marital_status', 'Single'); ?>>Single</option>
        						 <option value="Widow" <?php echo set_select('marital_status', 'Widowed'); ?>>Widowed</option>
        						<option value="Divorced" <?php echo set_select('marital_status', 'Divorced'); ?>>Divorced</option>
        						 <option value="Other" <?php echo set_select('marital_status', 'Other'); ?>>Other</option>
        					</select>
                </div>
               
              </div>

              <div class="row">
              <label class="col-xs-2 col-xs-offset-1 control-label"  for = "present_address" > Area Type </label>
                <div class="col-xs-3">
                  <select id="area_type" name="area_type" class="form-control" size="1" >
                    <option value="Urban">Urban</option>
                    <option value="Rural">Rural</option>
                  </select>
                </div>
                <label class="col-xs-2 control-label"  for = "lastqualification" > Last Qualification </label>
                <div class="col-xs-3">
                  <select name="lastqualification" id="lastqualification" class="form-control">
					<option value="Matric" <?php echo set_select('lastqualification', 'Matric'); ?>>Matric</option>
													<option value="FA" <?php echo set_select('lastqualification', 'FA'); ?>>F.A/F.Sc</option>
													<option value="BA" <?php echo set_select('lastqualification', 'BA'); ?>>B.A/BCS/B.Sc/B.Ed</option>
													<option value="MA" <?php echo set_select('lastqualification', 'MA'); ?>>M.A/MCS/M.Sc/M.Ed</option> 
													<option value="BBA/MBA" <?php echo set_select('lastqualification', 'BBA/MBA'); ?>>BBA/MBA</option>
													<option value="Diploma" <?php echo set_select('lastqualification', 'Diploma'); ?>>Diploma</option>
													<option value="MBBS" <?php echo set_select('lastqualification', 'MBBS'); ?>>MBBS</option>
													<option value="MBBS,MPH" <?php echo set_select('lastqualification', 'MBBS,MPH'); ?>>MBBS,MPH</option>
													<option value="MD" <?php echo set_select('lastqualification', 'MD'); ?>>MD</option>
													<option value="MD,MPH" <?php echo set_select('lastqualification', 'MD,MPH'); ?>>MD,MPH</option>
				</select>

                </div>
                 
              </div>
              <div class="row">
              
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
                <div class="col-xs-3">
                  <input type="text"  name="  institutename" id="institutename" placeholder="Institute Name"  class="form-control " value="<?php echo set_value('institutename'); ?>"/>
                </div>
  <label class="col-xs-2 control-label"  for = "passingyear" > Passing Year </label>
                <div class="col-xs-3">
                  <input type="text" name="  passingyear" id="passingyear" placeholder="Passing Year"  class="form-control " value="<?php echo set_value('passingyear'); ?>"/>
                </div> 
               

              </div>

            
            </div>
            <div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>


            <div class="form-group"> 

              
              <div class="row">
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "place_of_joining" > Designation </label>
                <div class="col-xs-3">
                  <input type="text"  name="designation" id="designation" placeholder="Designation"  class="form-control " value="<?php echo set_value('designation'); ?>"/>
                </div>
                <label class="col-xs-2 control-label"  for = "date_joining" > Date Of Joining </label>
                <div class="col-xs-3">
                  <input type="text"  name="date_joining" id="date_joining" placeholder="Date Of Joining"  class="form-control " value="<?php echo set_value('date_joining'); ?>"/>
                </div>
               
              </div>

               <div class="row"> 
               <label class="col-xs-2 col-xs-offset-1 control-label"  for = "place_of_joining" > Place of Joining </label>
                <div class="col-xs-3">
                  <input type="text"  name="place_of_joining" id="place_of_joining" placeholder="Place of Joining"  class="form-control " value="<?php echo set_value('place_of_joining'); ?>"/>
                </div>
                <label class="col-xs-2 control-label"  for = "date_joining" >Place Of Posting </label>
                <div class="col-xs-3">
                  <input type="text"  name="place_of_posting" id="place_of_posting" placeholder="Place Of Posting"  class="form-control " value="<?php echo set_value('place_of_posting'); ?>"/>
                </div>
                
              </div>
			  <div class="row"> 
			  <label class="col-xs-2 col-xs-offset-1 control-label"  for = "present_address" > Status </label>
                <div class="col-xs-3">
                  <select id="status" name="status" class="form-control" size="1" >
					<option value="Active" <?php echo set_select('status', 'Active', TRUE); ?>>Active</option>
					<option value="Terminated" <?php echo set_select('status', 'Terminated'); ?>>Terminated</option>
					<option value="Transfered" <?php echo set_select('status', 'Transfered'); ?>>Transfered</option>
					<option value="Died" <?php echo set_select('status', 'Died'); ?>>Died</option>
					<option value="Retired" <?php echo set_select('status', 'Retired'); ?>>Retired</option>
				</select>
                </div>
					<label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
											<div class="col-xs-3">
												<select id="employee_type" name="employee_type" class="form-control" size="1" >
													<option value="Contract" <?php echo set_select('employee_type', 'Contract', TRUE); ?>>Contract</option>
													<option value="Permanent" <?php echo set_select('employee_type', 'Permanent'); ?>>Permanent </option>
													
												</select>
												</div>
							 </div>
			  <div class="row"> 					
				<div class="showTerminated" id="showTerminated" style="display: none;">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date Termination </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_termination" id="date_termination" placeholder="Date Termination"  class="form-control " value="<?php echo set_value('date_termination'); ?>"/>
						</div>
						</div>
						<div class="showRetired" id="showRetired" style="display: none;">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date Retired </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_retired" id="date_retired" placeholder="Date Retired"  class="form-control " value="<?php echo set_value('date_retired'); ?>"/>
						</div>
						</div>
						<div class="showDied" id="showDied" style="display: none;">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date Died </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_died" id="date_died" placeholder="Date Died"  class="form-control " value="<?php echo set_value('date_died'); ?>"/>
						</div>
						</div>
						<div class="showTransfer" id="showTransfer" style="display: none;">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_termination" > Date Transfered </label>
						<div class="col-xs-3">
							<input  type="text"  name="date_transfer" id="date_transfer" placeholder="Date Transfered"  class="form-control " value="<?php echo set_value('date_transfer'); ?>"/>
						</div>
						</div>
				</div>





            </div>


            <div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>

              
           <div class="form-group">
	   <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "payscale" > Bank Information</label>
		<div class="col-xs-3">
			  <select id="bankid"  name="bankid" class="form-control" size="1" >
				<option value="">Select Bank</option>
				<?php 
				foreach($resultbank as $row){
				  ?>
				  <option value="<?php echo $row['bankid'];?>" <?php echo set_select('bankid',$row['bankcode']."-".$row['bankname']); ?>  /><?php echo $row['bankcode']."-".$row['bankname'];?>
					<?php
				  }
												?>
			  </select>
		</div>
		<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code  </label>
		<div class="col-xs-3">
			 <input name="branchcode" id="branchcode" placeholder="Branch Code"  class="form-control " value="<?php echo set_value('branchcode'); ?>"/><?php echo form_error('branchcode'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name </label>
		<div class="col-xs-3">
			 <input name="branchname" id="branchname" placeholder="Branch Name"  class="form-control " value="<?php echo set_value('branchname'); ?>"/><?php echo form_error('branchname'); ?>
		</div>
		<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number  </label>
		<div class="col-xs-3">
			 <input name="bankaccountno" id="bankaccountno" placeholder="Bank Account Number"  class="form-control " value="<?php echo set_value('bankaccountno'); ?>"/><?php echo form_error('bankaccountno'); ?>
		</div>
		</div>
		<div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale </label>
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
		<label class="col-xs-2 control-label"  for = "nic" > Basic Pay </label>
		<div class="col-xs-3">
			 <input type="text"  name="basicpay" id="basicpay" placeholder="Basic Pay"  class="form-control " value="<?php echo set_value('basicpay'); ?>"/><?php echo form_error('basicpay'); ?>
		</div>
		</div>
													</div>
               





            <hr>

            <div class="row">
             <div class="col-xs-7" style="margin-left:53.5%;" >

               <button type="submit" name="is_temp_saved" value="1" id="save" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>
			   <button type="submit" name="is_temp_saved" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit Form  </button>

               <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>

               <a href="<?php echo base_url();?>DataEntry-Operator-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>

             </div>

           </div>



         </form>



       </div> <!--end of panel body-->
     </div> <!--end of panel panel-primary-->
   </div><!--end of row-->

 </div><!--End of page content or body-->

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
    var regexp = /[0-9]{4}/; 
    var valid = regexp.test(num);
    return valid;
  }

  $('#dataform').on('submit', function(e){
    
    var code = $('#deocodel').val();
	
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
      alert('Please Enter Correct Code');
      $('#deocodel').focus();
    }

  });

  $('#nic').blur(function (){


  });

  /*$('#cocodel').keyup(function (){

    var cocodel = $('#cocodel').val();
    var cocodef = +$('#cocodef').val();
    var facode = "";
    var distcode="";




    if(/^\d+$/.test(cocodel) )
    {
      if($('#cocodef').val().length == 3 && $('#cocodel').val().length == 2 )
      {

                //alert('asdkjhsdja');
                $('#cocodel').css('border-color','#dbe1e8');
                distcode = '<?php echo $this -> session -> District?>';
                var cocodel  = $('#cocodel').val();
                var newVal = distcode+""+cocodel;
                //alert(newVal);
                $('#cocodel').val(newVal);
                //alert($('#lhscode').val());
                $.ajax({
                  type: "GET",
                  data: "distcodeco="+newVal,
                  url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
                  success: function(result){
                    console.log(result);
                    if(result == "0"){
                      $('#cocode').val(newVal);

                    }else{
                      alert('The Code '+newVal+' already exists, please try some other code');
                      $('#cocodel').val('');
                      $('#cocodel').css('border-color','red');
                    }
                  }

                });


              }else
              {
                $('#cocodel').css('border-color','red');
              }
              
            }
            else
            {
              $('#cocodel').css('border-color','red');
            }
            
            //alert($('#lhscode').val());
            
          }); */
/*$('#distcode').on('change' , function (){
  var distcode = this.value;
  
});
*/

function dop(){
	var dob=($('#date_of_birth').val());
      
    var year =dob.substr(6,10);
   var number = parseInt(year);
   number=number+15;
  var options = {
      format : "dd-mm-yyyy",
      startDate :"01-01-"+number
    
    };

	  $('#date_joining').datepicker(options);
	
}

$(document).ready(function () {
//$('#distcode').on('change' , function (){
  var distcode = $('#distcode').val();
 // alert(distcode);
   
  $('#deocodel').val('');
 
  $('#deocodef').val(distcode);
  
  $.ajax({
    type: "GET",
    data: "distcodedeo="+distcode,
    async: false,
    url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
    success: function(result){
	
      var resCode=result.trim();
	
      $('#deocodel').val(resCode);
      var cocodel  = $('#deocodel').val();
	  
      var newVal = distcode+""+cocodel;
	
   (($('#deocode').val(newVal)));
var cocode  = $('#deocode').val();
	  
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
  
	 $('#date_termination').datepicker(options);
	$('#date_transfer').datepicker(options);
	$('#date_retired').datepicker(options);
	$('#date_died').datepicker(options);
	//start date of joining is 10 year diff of dob
	//getting date of birth;
	
		
	
  });



  $(document).ready(function(){
    $('#bankaccountno').numeric({allow:"-"});
	$('#branchcode').numeric({allow:"-"});
	$('#basicpay').numeric();
    $(":input").inputmask();
    $("#date_of_birth").inputmask("99-99-9999");
    $("#ascodel").inputmask("99");
    $("#date_joining").inputmask("99-99-9999");
	$('#date_termination').inputmask("99-99-9999");
	$('#date_transfer').inputmask("99-99-9999");
	$('#date_retired').inputmask("99-99-9999");
	$('#date_died').inputmask("99-99-9999");
  $("#passingyear").inputmask("9999");
  // $("#bankaccountno").inputmask("9999999999999999");
  $("#phone").inputmask("99999999999");
  $("#postalcode").inputmask("99999");
   // $("#basicpay").inputmask("999999");

  
    // $("#branchcode").inputmask("99999999");
   $("#nic").inputmask({"mask": "99999-9999999-9"}); //specifying options only
 });

  //////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function(){

    var nic = $(this).val();
	if(nic!=''){
    $.ajax({ 
      type: 'POST',
      data: "nic="+nic,
      url: '<?php echo base_url();?>Ajax_calls/checkdeoNIC',

    //dataType: "json",
    success: function(data){
     if(data!=''){
      if(data=='yes'){
        $('#site_response').css('display','block');
        $('#site_response').css('color','red');
        $("#site_response").html('CNIC Already Exist For Another Data Entry Operator.');
        $('#nic').css('border-color','red');
		$('#nic').val('');
      }
      else{
        $('#nic').css('border-color','#66AFE9');
        $("#site_response").html('');
        $('#site_response').css('display','block');
      }
    }
  }
});
	}
  });
	$(document).ready(function() {    
    $('#deoname, #fathername, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
        var $this = $(this),
            val = $this.val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        console.log(val);
        $this.val(val);
    });
});	
$("#status").bind('change', function(){
    var selected = $(this).val();
    if (selected == 'Active') { 
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showTransfer').css('display', 'none');			
			$('#showDied').css('display', 'none'); 			
	}
    if (selected == 'Terminated') {  
			$('#showTerminated').css('display', 'block');
			$('#showRetired').css('display', 'none'); 
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 	
            
			}
	if (selected == 'Died') { 
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'block'); 			
	}
	if (selected == 'Retired') { 
			$('#showRetired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showTransfer').css('display', 'none');	
			$('#showDied').css('display', 'none'); 			
	}
	if (selected == 'Transfered') { 
			$('#showTransfer').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDied').css('display', 'none'); 			
	}
   
    //etc ...
});
//////////////////////////////////////////////////////////////////////////////////
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
</script>
