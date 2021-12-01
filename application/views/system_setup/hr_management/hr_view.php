				<?php //$name = get_level_name('2'); echo $name;  exit; 
//print_r($training_types); exit();				?>
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
		<div class="panel-heading">  View HR Form </div>
			<div class="panel-body">
				<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Hr_management/hr_edit" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered dataform" onSubmit="">			
					<div class="form-group">
						<div class="row">
							<label class="col-xs-12 col-xs-offset-1 control-label" style="font-size: 15px;">Note: <i>Fields marked with </i><span style="color:red;">*</span> <i>(asterisk) are mandatory.</i></label>
						</div>
						<input type="hidden" name="id" id="id" value="<?php echo $edit['id']; ?>" >
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1  control-label" > HR Code </label>
						<div class="row">  
							<div class="col-xs-3">
								<label class="control-label"  for = "supervisorcode" ><?php echo $edit['code']; ?></label>
							</div>
						</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lhsname" >HR Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<label class="control-label"  for = "name" ><?php echo $edit['name']; ?></label>
								</div>
							<label class="col-xs-2 control-label"  for = "father_name" > Father Name <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<label class="control-label"  for = "father_name" ><?php echo $edit['fathername']; ?></label>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "guardian_name" > Guardian's Name</label>
								<div class="col-xs-3">
									<label class="control-label"  for = "guardian_name" ><?php echo $edit['guardian_name']; ?></label>
								</div>
							<label class="col-xs-2  control-label"  for = "gender" > Gender <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										<?php 
										$gender="";
										 if(isset($edit['gender'])){
											$sex = $edit['gender'];
											if ( $sex == 1 ){
												$gender .= 	'<label class="control-label" for="gender">Male</label>';
												
											}else if ( $sex == 2 ){
												$gender .= 	'<label class="control-label" for="gender">Female</label>';
												
											}else{
												$gender .= 	'<label class="control-label" for="gender">Cross Gender</label>';
											}
											echo $gender;
										 }	
										?>
									</div>	
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px; font-family: Arial;padding-top: 5px; "> Basic Information</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "nic" > CNIC # <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<label class="control-label"  for = "nic" ><?php echo $edit['nic']; ?></label>
							</div>
							<label class="col-xs-2 control-label"  for = "date_of_birth" > Date of Birth <span style="color:red;">*</span></label>
							<div class="col-xs-3">
								<label class="control-label"  for = "supervisorcode" ><?php echo $edit['date_of_birth']; ?></label>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "marital_status" > Marital Status </label>
								<div class="col-xs-3">
									<label class="control-label"  for = "marital_status" ><?php echo $edit['marital_status']; ?></label>
								</div>
						<label class="col-xs-2 control-label"  for = "phone" > Phone Number </label>
								<div class="col-xs-3">
									<label class="control-label"  for = "phone" ><?php echo $edit['phone']; ?></label>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "emergency" > Emergency No. </label>
								<div class="col-xs-3">
									<label class="control-label"  for = "emergency" ><?php echo $edit['emergency_no']; ?></label>
								</div>
						</div>
					</div>
					<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Address and Qualification</div>
					<div class="form-group">
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "permanent_address" > Permanent Address <span style="color:red;">*</span></label>
								<div class="col-xs-3">
									<label class="control-label"  for = "permanent_address" ><?php echo $edit['permanent_address']; ?></label>
								</div>
							<label class="col-xs-2 control-label"  for = "present_address" > Present Address </label>
								<div class="col-xs-3">
									<label class="control-label"  for = "present_address" ><?php echo $edit['present_address']; ?></label>
								</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "lastqualification" > Last Qualification </label> 
								<div class="col-xs-3">
									<label class="control-label"  for = "lastqualification" ><?php echo $edit['lastqualification']; ?></label>
								</div>
						<label class="col-xs-2 control-label"  for = "passingyear" > Passing Out Year </label>
							<div class="col-xs-3">
								<label class="control-label"  for = "passingyear" ><?php echo $edit['passingyear']; ?></label>
							</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label"  for = "institutename" > Institute Name </label>
							<div class="col-xs-3">
								<label class="control-label"  for = "institutename" ><?php echo $edit['institutename']; ?></label>
							</div>
						</div>
					</div>
					<div class="row bgrow " style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Joining Details</div>
						<div class="form-group">    
							<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "date_joining" > Date of Joining </label>
									<div class="col-xs-3">
										<label class="control-label"  for = "date_joining" ><?php echo $edit['date_joining']; ?></label>
									</div>
								<label class="col-xs-2 control-label"  for = "place_of_joining" > Place of Joining </label>
									<div class="col-xs-3">
										<label class="control-label"  for = "place_of_joining" ><?php echo $edit['place_of_joining']; ?></label>
									</div>
							</div>
							<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "area_type" > Area Type </label>
									<div class="col-xs-3">
										<label class="control-label"  for = "area_type" ><?php echo $edit['areatype']; ?></label>
									</div>
								<label class="col-xs-2 control-label"  for = "employee_type" > Employee Type </label>
									<div class="col-xs-3">
										<label class="control-label"  for = "employee_type" ><?php echo $edit['employee_type']; ?></label>
									</div>
							</div>
							<!--<div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label"  for = "status" > Status </label>
									<div class="col-xs-3">
										<label class="control-label"  for = "status" ><?php echo $edit['status']; ?></label>
									</div>
								<label class="col-xs-2 control-label"> Date of Status </label>
									<div class="col-xs-3">
										<label class="control-label" ><?php echo $edit['status_date']; ?></label>
									</div>
							</div>-->
						</div>
						<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Training Information</div>
							<div class="form-group">
								<div class="row">
								<?php 
									$a= "";
									foreach ($training_types as $key => $training ) {
										$a .= 	'<label class="col-xs-2 col-xs-offset-1 control-label" for="training' . $key . '">' . $training['name'] . '</label>
												<input class="col-xs-1" type="checkbox" name="training[]" id="training' . $key . '" value="' . $training['id'] . '" disabled/>';
									}
									echo $a;?>
								</div>
								<!--$a .= 	'<label class="col-xs-2 col-xs-offset-1 control-label" for="training' . $key . '">' . $training['name'] . '</label>
												<input class="col-xs-1" type="checkbox" name="training[]" id="training' . $key . '" value="' . $training['id'] . '" '. ($training['id']==in_array($training['id'],$trainings)? 'checked' : '').'/>'; -->
							</div>	
						<div class="row bgrow" style="text-align: center;color: white;font-size: 15px;font-family: Arial;padding-top: 5px;"> Banking Details</div>
							<div class="form-group">
							   <!--yea change kia ha 25-->
							   <div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bid" > Bank Information <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										<label class="control-label" ><?php echo $edit['bankinfo']['bankname']; ?></label>
									</div>
									<label class="col-xs-2 control-label"  for = "branchcode" > Branch Code <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										<label class="control-label"><?php echo $edit['branchcode']; ?></label>
									</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "branchname" > Branch Name <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										<label class="control-label" ><?php echo $edit['branchname']; ?></label>
									</div>
									<label class="col-xs-2 control-label"  for = "bankaccountno" > Bank Account Number <span style="color:red;">*</span></label>
									<div class="col-xs-3">
										<label class="control-label" ><?php echo $edit['bankaccountno']; ?></label>
									</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "bankbranch" > Basic Pay Scale <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<label class="control-label" ><?php echo $edit['payscale']; ?></label>
										</div>
									<label class="col-xs-2 control-label"  for = "nic" > Basic Pay <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<label class="control-label" ><?php echo $edit['basicpay']; ?></label>
										</div>
								</div>
								<div class="row">
									<label class="col-xs-2 col-xs-offset-1 control-label"  for = "allowances" > Allowances <span style="color:red;">*</span></label>
										<div class="col-xs-3">
											<label class="control-label" ><?php echo $edit['allowances']; ?></label>
										</div>
									<label class="col-xs-2 control-label"  for = "deductions" > Deductions <span style="color:red;">*</span></label>
										<div class="col-xs-3">
										<label class="control-label" ><?php echo $edit['deductions']; ?></label>
										</div>
								</div>
							</div>
							<div class="row">
							<hr>
								<div class="col-xs-7" style="margin-left:63.5%;">
								<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
									<a href=" <?php echo base_url(); ?>Hr_management/hr_edit_get/<?= $edit['code']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil-square-o"></i> Update </a>
								<?php }?>	
									<a href="<?php echo base_url();?>Hr_management/hr_list" class="btn btn-md btn-success"><i class="fa fa-arrow-left"></></i> Cancel </a>
								</div>
							</div>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">
	$("#level option[value='6']").remove();
	$("#level").bind('change', function()
	{
		var selected = $(this).val();
		if (selected == '4') { 
				$('#showDistrict').css('display', 'block');
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none');
										
		}
		if (selected == '5') {  
				$('#showDistrict').css('display', 'block');
				$('#showTehsil').css('display', 'block');
				$('#showFacility').css('display', 'none');			
		}
		if (selected == '7') {  
				$('#showDistrict').css('display', 'block');
				$('#showTehsil').css('display', 'block');
				$('#showCouncil').css('display', 'block');	
				$('#showFacility').css('display', 'block');	
		}
		if (selected == '') { 
				$('#showDistrict').css('display', 'none');
				$('#showTehsil').css('display', 'none');
				$('#showFacility').css('display', 'none'); 		
		}
    //etc ...
	});
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
	$('#dataform').on('submit', function(e)
	{
		var code = $('#supervisorcodel').val();
		//if(checkCode(code)){
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
		/* }else{
		  alert('Please Enter Correct Supervisor Code');
		  $('supervisorcodel').focus();
		} */
	});
	$('#nic').blur(function (){
	}); 
 <?php if($this -> session -> UserLevel=='3'){ ?>  
	$(document).ready(function()
	{
	/* $("#sub_type").on('change',function()
	{ */
	function newcode(){
		var sub_type = $("#sub_type");
		if(sub_type.val() != "")
		{
			var val = sub_type.val();
			$("#type_id").val(val);
			var distcode = '<?php echo $this -> session -> District; ?>';            
			var type_id  = $('#type_id').val();
			var type_id1  = $('#type_id1').val();
			$.ajax({
				type: "GET",
				data: "hrnewcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/checkCodes",
				success: function(result)
				{
				  $('#type_id1').val(result);
				  type_id  = $('#type_id').val();
				  type_id1  = $('#type_id1').val();
				  var newVal = distcode+""+type_id+""+type_id1;
				  $('#code').val(newVal);
				}
			});
		}
		else
		{
			$("#type_id").val("");
			$("#code1").val("");
			$("#type_id1").val("");
		}
	}
	newcode();
	$("#sub_type").on('change',function()
	{
		newcode();
	});
	/* }); */
	});
 <?php } ?>
/* $('#tehcode').on('change' , function (){
  var tehcode = this.value;
  var facode = "";
  $.ajax({
    type: "POST",
    data: "tcode="+tehcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
    success: function(result){
      $('#facode').html(result);
    }
  });
}); */
	$('#tehcode').on('change' , function (){
	  var tehcode = this.value;
	  var uncode = "";
	  $.ajax({
		type: "POST",
		data: "tcode="+tehcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
		success: function(result){
		  $('#uncode').html(result);
		}
	  });
	});
	$('#uncode').on('change' , function (){
	  var uncode = this.value;
	  var facode = "";
	  $.ajax({
		type: "POST",
		data: "tcode="+tehcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
		success: function(result){
		  $('#facode').html(result);
		}
	  });
	});
	$('#tehcode').on('change' , function (){
		var tehcode = this.value;
	//	alert (tehcode);
		var facode = "";
			if (tehcode!='')
			{
					document.getElementById("distcode").required = false;
			}
	});
/* <?php if(isset($selectlevel)){ ?>
	var select = <?php echo $selectlevel ?>;
	$("#level option[value="+select+"]").prop("selected", "selected");
<?php } ?> */
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
	$('#status_date').datepicker(options);
    var options = {
      format : "dd-mm-yyyy"
    };
    $('#date_joining').datepicker(options);
    //$('#date_termination').datepicker(options);
	//$('#date_transfer').datepicker(options);
	//$('#date_retired').datepicker(options);
	//$('#date_died').datepicker(options);
    $('#basic_training_start_date').datepicker(options);
	$('#routine_epi_start_date').datepicker(options);
	$('#routine_epi_end_date').datepicker(options);
	$('#survilance_training_start_date').datepicker(options);
	$('#survilance_training_end_date').datepicker(options);
	$('#cold_chain_training_start_date').datepicker(options);
	$('#cold_chain_training_end_date').datepicker(options);
	$('#vlmis_training_start_date').datepicker(options);
	$('#vlmis_training_end_date').datepicker(options);
	$('#epimis_training_start_date').datepicker(options);
	$('#epimis_training_end_date').datepicker(options);
	//$('#status_date').datepicker(options);
    //$('#tenmonth_training_end_date').datepicker(options);
  });
    $(document).ready(function()
	{
		$('#bankaccountno').numeric({allow:"-"});
		$('#branchcode').numeric({allow:"-"});
		$('#basicpay').numeric();
		$('#allowances').numeric();
		$('#deductions').numeric();
		$(":input").inputmask();
		$("#date_of_birth").inputmask("99-99-9999");
		$("#supervisorcodel").inputmask("9999");
		$("#date_joining").inputmask("99-99-9999");
	   // $("#date_termination").inputmask("99-99-9999");
		//$("#date_transfer").inputmask("99-99-9999");
		//$("#date_retired").inputmask("99-99-9999");
		//$("#date_died").inputmask("99-99-9999");
		$("#basic_training_end_date").inputmask("99-99-9999");
		$("#basic_training_start_date").inputmask("99-99-9999");
		$("#routine_epi_start_date").inputmask("99-99-9999");
		$("#routine_epi_end_date").inputmask("99-99-9999");
		$("#survilance_training_start_date").inputmask("99-99-9999");
		$("#survilance_training_end_date").inputmask("99-99-9999");
		$("#cold_chain_training_start_date").inputmask("99-99-9999");
		$("#cold_chain_training_end_date").inputmask("99-99-9999");
		$("#vlmis_training_start_date").inputmask("99-99-9999");
		$("#vlmis_training_end_date").inputmask("99-99-9999");
		$("#epimis_training_start_date").inputmask("99-99-9999");
		$("#epimis_training_end_date").inputmask("99-99-9999");
		$("#nic").inputmask("99999-9999999-9");
		$("#passingyear").inputmask("9999");
		$("#phone").inputmask("99999999999");
		// $("#branchcode").inputmask("99999");
		// $("#bankaccountno").inputmask("9999999999999999");
	   
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
//////////////////////////////////Checking CNIC//////////////////////////////////
  $(document).on('blur','#nic', function()
  {
	var nic = $(this).val();
		if(nic!=''){
			 $.ajax({ 
			  type: 'POST',
			  data: "nic="+nic,
			  url: '<?php echo base_url();?>Ajax_calls/checkNICNumber',
			  //dataType: "json",
			  success: function(data){
			   if(data!=''){
					if(data=='yes'){
						$('#site_response').css('display','block');
						$('#site_response').css('color','red');
						$("#site_response").html('CNIC Already Exist For Another Supervisor.');
						$('#nic').css('border-color','red');
						$("#nic").val('');
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
    $('#name, #guardian_name, #permanent_address, #present_address, #branchname').on('keyup', function(event) {
        var $this = $(this),
            val = $this.val();
        val = val.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        }); 
        $this.val(val);
    });
	var hr_code = "<?php echo $edit['code']; ?>";
	$.ajax(
		{
			url : "<?php echo base_url(); ?>Hr_management/get_training/"+hr_code,
			type : 'GET',
			dataType:'JSON',
			success : function(data) 
					{
						$.each(data, function(i, val)
						{
							$("input[value='" + val + "']").prop('checked', true);
						});
					},
			error : function(request,error)
			{
				alert("Request: "+JSON.stringify(request));
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