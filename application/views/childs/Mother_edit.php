<!--start of page content or body-->

<?php 
//print_r($motherdData);exit;
if($this -> session -> flashdata('message')){  ?>
			  <div class="row mb3">
				<div class="col-sm-12 filters-selection" style="Background-color:#00F418;">
				  <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
				</div>
			  </div>
<?php } ?>
 <div class="container bodycontainer">
  <div class="row">
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Edit Mother Registeration Form
        </div>
         <div class="panel-body">
     <!-- <form  action="<?php echo base_url();?>Reports_list/child_save" method="post" class="form-horizontal form-bordered" >-->
      <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url();?>Reports/MotherRegistrationSave">        
		 <input type="hidden" name="recno" id="recno"  value="<?php echo $childData[0]['recno']; ?>"  class="form-control "/> 
		


<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------Start-Codding------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


<div class="form-group">
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">EPI Center Info</div>
			<br>
			<div class="row">
		       <div class="showProvnice" id="showProvnice">
                 <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                 <div class="col-xs-3">
                      <select id="newprocode" required="required" name="procode" class="form-control" size="1">
					         <!-- <?php //echo getProvinces_options(false,$childData[0]['procode']); ?>-->
							 <option value="<?php echo $this-> session-> Province;?>" >
								<?php echo get_Province_Name($this->session->Province);  ?>
							</option>
					  </select>
				</div>
				<label class="col-xs-2  control-label" for = "showDistrict" >  District</label>
				<div class="col-xs-3">
					<select id="newdistcode" required="required" name="distcode" class="form-control" size="1">
							<option value="<?php echo $childData[0]['distcode']; ?>" selected > <?php echo get_District_Name($childData[0]['distcode']); ?> </option>
						  <?php //echo getallDistrict_options(false,$childData[0]['distcode'],$childData[0]['procode']); ?>
					</select>
				</div>
				</div>
			</div>
			<div class="row">
		            <div class="showDistrict" id="showDistrict"></div>
			        <div class="showTehsil" id="showTehsil">
						<label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<select  id="newtcode" required="required" name="tcode" class="form-control" size="1" >
								<option value="<?php echo $childData[0]['tcode']; ?>" selected > <?php echo get_Tehsil_Name($childData[0]['tcode']); ?> </option>
									<?php //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
							</select>
						</div>
						<label class="col-xs-2  control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
							<select id="newuncode" required="required" name="uncode" class="form-control" size="1">
								<option value="<?php echo $childData[0]['uncode']; ?>" selected > <?php echo get_UC_Name($childData[0]['uncode']); ?> </option>
						          <?php	//echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']); ?>
							</select>
						</div>
					</div>
			</div>		
			
			<!--<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Registered Info</div>
			<br>-->
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
						<select  id="newfacode" required="required" name="facode" class="form-control" size="1" >
							<option value="<?php echo $childData[0]['reg_facode']; ?>" selected > <?php echo get_Facility_Name($childData[0]['reg_facode']); ?> </option>
								<?php	//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
						</select>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
						<select  id="techniciancode" required="required" name="techniciancode" class="form-control" size="1" >
						    <option value="<?php echo $childData[0]['techniciancode']; ?>" selected > <?php echo get_Hr_Name($childData[0]['techniciancode'],'01'); ?> </option>
								<?php //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
						</select>
					</div>
				</div>
			</div>
			<br>
		
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Mother Basic info</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "age" >Age(in Year) </label>
                <div class="col-xs-3">
					<input type="text"  name="mother_age" id="mother_age"  placeholder="Age(in Year)"  value="<?php echo $childData[0]['mother_age'];?>" class="form-control numberclass">
				</div>
				<label class="col-xs-2 control-label"  for = "CardNO" > Card No: </label>
                <div class="col-xs-3">
					<input type="text"  name="cardno" id="cardno" readonly placeholder="Card No"  value="<?php if(validation_errors() != false) { echo set_value('cardno'); } else { echo $childData[0]['cardno']; } ?>"  class="form-control "/><?php echo form_error('cardno'); ?>
				</div>
                
			</div>
			<div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "name" >Mother Name</label>
				<div class="col-xs-3">
                    <input type="text"  name="mother_name" id="mother_name" placeholder="Name of Mother"  value="<?php echo $childData[0]['mother_name'];?>"   class="form-control " required>
				</div>
				<label class="col-xs-2 control-label"  for = "husband_name" > Husband Name</label>
                <div class="col-xs-3">
					<input type="text"  name="husband_name" id="husband_name" placeholder="Husband Name"  value="<?php echo $childData[0]['husband_name'];?>"   class="form-control ">
				</div>
				
			</div>
			<div class="row">
				
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "cnic" >Mother CNIC</label>
                <div class="col-xs-3">
					<input type="text"  name="mother_cnic" id="mother_cnic" placeholder="Mother Cnic"  value="<?php echo $childData[0]['mother_cnic'];?>"   class="form-control numberclass"><span id="site_response"></span>
				</div>
				<label class="col-xs-2 control-label"  for = "Contact" >Enter Contact Number</label>
				<div class="col-xs-3">
					<input type="text"  name="contactno" id="contactno" placeholder="Enter Contact Number"  value="<?php echo $childData[0]['contactno'];?>"   class="form-control numberclass">
				</div>
			</div>



			

<!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------End-Codding------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

		<div class="form-group">
			
			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Current Address</div>
			<br>
			<div class="row">
				<div class="showProvnice" id="showProvnice">
                    <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                    <div class="col-xs-3">
                        <select id="newprocode" required="required" name="procode" class="form-control" size="1">
							<option value="<?php echo $childData[0]['procode']; ?>" selected > <?php echo get_Province_Name($childData[0]['procode']); ?> </option>
						   <?php
								//echo getProvinces_options(false,$childData[0]['procode']); 
							?>
						</select>
					</div>
				</div>
				<div class="showDistrict" id="showDistrict">
                    <label class="col-xs-2   control-label" for = "showDistrict" >  District</label>
					<div class="col-xs-3">
						<select id="newdistcode" required="required" name="distcode" class="form-control" size="1">
						<option value="<?php echo $childData[0]['distcode']; ?>" selected > <?php echo get_District_Name($childData[0]['distcode']); ?> </option>
							  <?php//echo getallDistrict_options(false,$childData[0]['distcode'],$childData[0]['procode']); ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="showTehsil" id="showTehsil">
                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<select  id="newtcode" required="required" name="tcode" class="form-control" size="1" >
							<option value="<?php echo $childData[0]['tcode']; ?>" selected > <?php echo get_Tehsil_Name($childData[0]['tcode']); ?> </option>
									<?php//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
							</select>
						</div>
					</div>
					<div class="showUnc" id="showUnc">
                      <label class="col-xs-2 control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
                          <select id="newuncode" required="required" name="uncode" class="form-control" size="1">
						  <option value="<?php echo $childData[0]['uncode']; ?>" selected > <?php echo get_UC_Name($childData[0]['uncode']); ?> </option>
						        
									<?php // echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']); ?>
						  </select>
						</div>
					</div>
			</div>	
			 <div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" >Address</label>
                <div class="col-xs-3">
					<input type="text"  name="address" id="address" placeholder="Address"  value="<?php echo $childData[0]['village'];?>"  class="form-control ">
				</div>
		   </div>
			</div>
			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Vaccine list</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT1 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt1" id="tt1" placeholder="yyyy-mm-dd"  value="<?php echo $childData[0]['tt1'];?>" data-date-format="yyyy-mm-dd" class="month_year form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT2 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt2" id="tt2" placeholder="yyyy-mm-dd"  value="<?php echo $childData[0]['tt2'];?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT3</label>
                <div class="col-xs-3">
					<input type="text"  name="tt3" id="tt3" placeholder="yyyy-mm-dd"  value="<?php echo $childData[0]['tt3'];?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT4 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt4" id="tt4" placeholder="yyyy-mm-dd"  value="<?php echo $childData[0]['tt4'];?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT5 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt5" id="tt5" placeholder="yyyy-mm-dd"  value="<?php echo $childData[0]['tt5'];?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<!--<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-1 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv1" id="opv1" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-1 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv1" id="pcv1" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Penta-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="penta2" id="penta2" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Rota-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="rota2" id="rota2" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv2" id="opv2" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv2" id="pcv2" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >penta-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="penta3" id="penta3" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv3" id="opv3" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv3" id="pcv3" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >IPV</label>
                <div class="col-xs-3">
					<input type="text"  name="ipv" id="ipv" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-1</label>
                <div class="col-xs-3">
					<input type="text"  name="measles1" id="measles1" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-2</label>
                <div class="col-xs-3">
					<input type="text"  name="measles2" id="measles2"  placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>-->
			
				
			</div>
				<br>
				<div class="row">
                    <div class="col-xs-7" style="margin-left:53.5%;">
						<button type="submit" class="btn btn-md btn-success"  style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit  </button>
                        <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
                        <a href="<?php echo base_url();?>Reports/motherRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
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

// new code

 function toDate(start_date_id, end_date_id){
		$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
	 	$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	
	function addDays(start_date_id, end_date_id, numberOfDays=30)
		{
			var from_date = $('#'+start_date_id).datepicker().val();
			//alert(from_date);
			from_date = from_date.substring(0,4) + '-' + from_date.substring(5,7) + '-' + from_date.substring(8,10);
			//alert(from_date);
			from_date = new Date(from_date.toString());
			from_date.setDate(from_date.getDate() + numberOfDays);
			
			var dd = from_date.getDate();
			var mm = from_date.getMonth() + 1;
			var y = from_date.getFullYear();
			var formattedDate = y + '-'+ mm + '-'+ dd;
			//alert(formattedDate);
			$("#"+end_date_id).datepicker('setStartDate', from_date);
		}
		
$(document).ready(function(){
	document.getElementById('tt2').disabled = true;
	document.getElementById('tt3').disabled = true;
	document.getElementById('tt4').disabled = true;
	document.getElementById('tt5').disabled = true;
	
	//for date of vaccin
	$('#tt1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		document.getElementById('tt2').disabled = false;
		addDays('tt1', 'tt2', 30); 
		dp.date = e.date;
		dp.setValue();
	}).on('clearDate', function(){
		$('#tt2').val('');
		$('#tt3').val('');
		$('#tt4').val('');
		$('#tt5').val('');
		document.getElementById('tt2').disabled = true;
		document.getElementById('tt3').disabled = true;
		document.getElementById('tt4').disabled = true;
		document.getElementById('tt5').disabled = true;
	});
	
	$('#tt2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		document.getElementById('tt3').disabled = false;
		addDays('tt2', 'tt3', 180);
	});
	
	$('#tt3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		document.getElementById('tt4').disabled = false;
		addDays('tt3', 'tt4', 360);
	}); 
	
	$('#tt4').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		document.getElementById('tt5').disabled = false;
		addDays('tt4', 'tt5', 360);
	}); 
	
	$('#tt5').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
		  
	}).on('changeDate', function(e) {

	}); 

// end code
	
	
	///////vaccine check ////////	creat date problem of tt1 and tt2 so on tt5
/* 	$(".calender").on('click',function(){
		var mother_age=$("#mother_age").val();
		var minDate = new Date(mother_age);
		$('.calender').each(function(){
			$(this).datepicker('setStartDate', minDate,'clearBtn',true);
		}); 	
	});	
	$('.calender').each(function(){
		$(this).datepicker();
	});  */		
////////////

//get district by provnice
$('#newprocode').on('change' , function (){
	var newprocode = this.value;
	var newtcode = "";
	$.ajax({
	type: "POST",
	data: "procode="+newprocode,
	url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
	success: function(result){
		$('#newdistcode').html(result);
	}
	});
});	
//get tehsil by district
$('#newdistcode').on('change' , function (){
	var newdistcode = this.value;
	var newtcode = "";
	$.ajax({
    type: "POST",
    data: "distcode="+newdistcode,
    url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
	success: function(result){
      $('#newtcode').html(result);
    }
	});
});
//get unioncl by tehsil
 $('#newtcode').on('change' , function (){
	var newtcode = this.value;
	var newuncode = "";
	$.ajax({
    type: "POST",
    data: "tcode="+newtcode,
	url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
    success: function(result){
      $('#newuncode').html(result);
    }
}); 
});
//get facility by uc
$('#newuncode').on('change' , function (){
	var newuncode = this.value;
	var newfacode = "";
	$.ajax({
	type: "POST",
	data: "uncode="+newuncode,
	url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
	success: function(result){
		$('#newfacode').html(result);
	}
	});
	//$('#newfacode').empty();
});


//get technician by HF
$('#newfacode').on('change' , function (){
	var newfacode = this.value;
	 var mother_age = $("#mother_age").val();
	var cardno = $("#cardno").val();
	var reg_no=newfacode+'-'+mother_age+'-'+cardno;
	alert(reg_no); 
	var newtechniciancode = "";
	$.ajax({
		type: "POST",
		data: "facode="+newfacode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
		success: function(result){
			console.log(result);
			$('#techniciancode').html(result);
		}
	});
	 $.ajax({
		type: "POST",
		data: "mother_registration_no="+reg_no,
		url: "<?php echo base_url(); ?>Ajax_calls/CheckmotherRegistrationNo",
		success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.child_registration_no!=''){
                 $("#cardno").html(data.child_registration_no);  
                 $('#site_response_cardno').css('display','block');
                 $('#site_response_cardno').css('color','red');
                 $("#site_response_cardno").html('Mother Registration of this Card No and Facility Already Exist.');
                 $('#cardno').css('border-color','red');
                 $('#cardno').val('');
				 $('#newfacode').val('');
				 $('#techniciancode').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_response").html('');
            $('#site_response').css('display','block');
          }
        }
	}); 
});

//check Mother cnic already enter mothercnic
$(document).on('blur','#mother_cnic', function(){
    var mother_cnic = $(this).val();
	if(mother_cnic!=''){
       $.ajax({ 
        type: 'POST',
        data: "mother_cnic="+mother_cnic,
        url: '<?php echo base_url();?>Ajax_calls/checkmotherNIC',
        //dataType: "json",
        success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.mother_cnic!=''){
                 $("#mother_cnic").html(data.mother_cnic);  
                 $('#site_response').css('display','block');
                 $('#site_response').css('color','red');
                 $("#site_response").html('CNIC Already Exist For Mother.');
                 $('#mother_cnic').css('border-color','red');
                 $('#mother_cnic').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_response").html('');
            $('#site_response').css('display','block');
          }
          }
       });
    } 
	
});

});

	$("#mother_cnic").inputmask({"mask": "99999-9999999-9"});
	 $("#contactno").inputmask({"mask": "9999-9999999"});
</script>
		