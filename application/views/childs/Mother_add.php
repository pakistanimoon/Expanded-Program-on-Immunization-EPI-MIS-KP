<!--start of page content or body-->

<?php 
//live
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
      <div class="panel-heading"> Add Mother Registeration Form
        </div>
         <div class="panel-body">
     <!-- <form  action="<php echo base_url();?>Reports_list/child_save" method="post" class="form-horizontal form-bordered" >-->
      <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url();?>Reports/MotherRegistrationSaveAdd"> 


<div class="form-group">
						<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">EPI Center Info</div>
			<br>
			<div class="row">
				<div class="showDistrict" id="showDistrict">
                    <label class="col-xs-2  col-xs-offset-1 control-label" for = "showDistrict" >  District</label>
					<div class="col-xs-3">
						<select id="distcode" required="required" class="form-control" size="1">
							  <?php
								echo getDistricts(false,$this->session->District); 
								//echo getDistricts_options(false,$this->session->District,'Yes');
							   ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="showTehsil" id="showTehsil">
                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<select  id="tcode" required="required" class="form-control" size="1" >
									<?php
									    //echo getTehsils_options(false,NULL,$this->session->District);
										//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
									?>
							</select>
						</div>
					</div>
					<div class="showUnc" id="showUnc">
                      <label class="col-xs-2 control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
                          <select id="uncode" required="required"  class="form-control" size="1">
									<?php
									// echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']); 
								   ?>
						  </select>
						</div>
					</div>
			</div>
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
						<select  id="newfacode" required="required" name="facode" class="form-control" size="1" >
								<?php
									//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
								?>
						</select>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
						<select  id="techniciancode" required="required" name="techniciancode" class="form-control" size="1" >
								<?php
									//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
								?>
						</select>
					</div>
				</div>
			</div>
			<br>
					<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Mother info</div> <br>
						<div class="row">
						<label class="col-xs-2 col-xs-offset-1 control-label"  for = "age" >Age(in Year) </label>
					<div class="col-xs-3"> <input type="text"  name="mother_age" id="mother_age"  placeholder="Age(in Year)"  value=""  class="form-control numberclass"> </div>
						
					<label class="col-xs-2 control-label" for="CardNO"> Card No: </label>
					  <div class="col-xs-3"> <input type="text" name="cardno" maxlength="5" id="cardno" placeholder="Card No" value="" class="form-control numberclass decimalclass" > 
						</div>
					<label class="col-xs-2 col-xs-offset-1 control-label"  for = "name" >Mother Name</label>
						<div class="col-xs-3">
					<input type="text"  name="mother_name" id="mother_name" placeholder="Name of Mother"  value=""  class="form-control " required>
						</div>
					<label class="col-xs-2 control-label"  for = "husband_name" > Husband Name</label>
						<div class="col-xs-3">
							<input type="text"  name="husband_name" id="husband_name" placeholder="Husband Name"  value=""  class="form-control ">
						</div>
						<label class="col-xs-2 col-xs-offset-1  control-label"  for = "cnic" >Mother CNIC</label>
						<div class="col-xs-3">
							<input type="text"  name="mother_cnic" id="mother_cnic" placeholder="Mother Cnic"  value=""  class="form-control numberclass"><span id="site_response"></span>
						</div>
						<label class="col-xs-2 control-label"  for = "Contact" >Enter Contact Number</label>
						<div class="col-xs-3">
							<input type="text"  name="contactno" id="contactno" placeholder="Enter Contact Number"  value=""  class="form-control numberclass">
						</div>
						</div>
						<div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label" for="CardNO">Date of Birth </label>
                            <div class="col-xs-3"> <input name="dateofbirth" id="dateofbirth" placeholder="yyyy-mm-dd" class="month_year form-control " type="text"> 
						    </div>
                        </div> 
						<br>
						 <div class="row">
						 
                        </div>
                        <div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Mother Address</div> <br>
                        <div class="row">
                            <div class="showProvnice" id="showProvnice"> <label class="col-xs-2 col-xs-offset-1  control-label" for="showProvnice"> Provnice</label>
                                <div class="col-xs-3">
									<select id="newprocode" required="required" name="procode" class="form-control" size="1">
									<option value="<?php echo $this->session->Province;  ?>">
									<?php echo get_Province_Name($this->session->Province);  ?>
									</option>
										<?php //echo getProvinces_options(false, $childData[0]['procode']);?> 
									</select> 
								</div>
                            </div>
                            <div class="showDistrict" id="showDistrict"> <label class="col-xs-2   control-label" for="showDistrict"> District</label>
                                <div class="col-xs-3">
									<select id="newdistcode" required="required" name="distcode" class="form-control" size="1"> 
									<?php 
										//echo get_District_Name($this->session->District);  
										echo getDistricts_options(false,$this->session->District,'Yes');
										?>
									</option>
									<?php  ?>
									<?php
										//echo getDistricts(false,$this->session->District); 
									    //echo getallDistrict_options(false,$this->session->District);
									?> </select> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="showTehsil" id="showTehsil"> <label class="col-xs-2 col-xs-offset-1 control-label" for="showTehsil"> Tehsil</label>
                            <div class="col-xs-3">
								<select id="newtcode" required="required" name="tcode" class="form-control" size="1">  
									<?php
										echo getTehsils_options(false); 
									    //echo getTehsils_options(false,NULL,$this->session->District);
										//echo getTehsils_options(false,NULL,$this->session->District); 
									?>
								</select> 
							</div>
                            </div>
                            <div class="showUnc" id="showUnc"> <label class="col-xs-2 control-label" for="showUnc"> Union Council</label>
                                <div class="col-xs-3"> 
									<select id="newuncode" required="required" name="uncode" class="form-control" size="1"> 
									
										<?php 
									 	    echo getUCs_options(false);
											// echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']);
										?> 
									</select> 
								</div>
                            </div>
                        </div>
                        <!--<div class="row">					<div class="showfacility" id="showfacility">                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showfacility" >Facility</label>						<div class="col-xs-3">							<select  id="newfacode" required="required" name="facode" class="form-control" size="1" >									<option value="701049">Social Security Hospital</option>									<?php                                        //echo getallfacility_options(false,$childData[0]['facode'],$childData[0]['distcode']); 									
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>							</select>						</div>					</div>			</div>-->
                        <div class="row"> 
						    
							
							
							<label class="col-xs-2 col-xs-offset-1 control-label" for="fathername">Village / Mohalla</label>
                            <div class="col-xs-3"> 
							<!--	<input type="text" name="address" id="address" placeholder="Village/Mohalla" value="" class="form-control "> -->
							<select  id="address" required="required" name="address" class="form-control" size="1" >
								<?php
									//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
								?>
						    </select>
							</div>
							
							<label class="col-xs-2  control-label"  for = "name" >House/Street</label>
							<div class="col-xs-3"> <input type="text"  name="housestreet" id="housestreet" placeholder="House/Street"  value=""  class="form-control ">				
							</div>
                        </div> <br>
                       <!-- <div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Registered Info</div> <br>
                        <div class="row">
                            <div class="showTehsil" id="showTehsil"> <label class="col-xs-2 col-xs-offset-1 control-label" for="showTehsil">Facility</label>
                                <div class="col-xs-3"> <select id="newfacode" required="required" name="facode" class="form-control" size="1"> <?php                                    //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 								
                                                                                                                                                ?> </select> </div> <label class="col-xs-2 control-label" for="showTehsil">Technician</label>
                                <div class="col-xs-3"> <select id="techniciancode" required="required" name="techniciancode" class="form-control" size="1"> <?php                                    //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 								
                                                                                                                                                            ?> </select> </div>
                            </div>
                        </div> --><br>
					

<!---

			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Current Address</div>
			<br>
			<div class="row">
				<div class="showProvnice" id="showProvnice">
                    <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                    <div class="col-xs-3">
                        <select id="newprocode" required="required" name="procode" class="form-control" size="1">
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
							  <?php
								//echo getallDistrict_options(false,$childData[0]['distcode'],$childData[0]['procode']); 
							   ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="showTehsil" id="showTehsil">
                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<select  id="newtcode" required="required" name="tcode" class="form-control" size="1" >
									<?php
										//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
									?>
							</select>
						</div>
					</div>
					<div class="showUnc" id="showUnc">
                      <label class="col-xs-2 control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
                          <select id="newuncode" required="required" name="uncode" class="form-control" size="1">
									<?php
									// echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']); 
								   ?>
						  </select>
						</div>
					</div>
			</div>	
			 <div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" >Address</label>
                <div class="col-xs-3">
					<input type="text"  name="address" id="address" placeholder="Address"  value=""  class="form-control ">
				</div>
				
		   </div>
			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Registered Info</div>
			<br>
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
						<select  id="newfacode" required="required" name="facode" class="form-control" size="1" >
								<?php
									//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
								?>
						</select>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
						<select  id="techniciancode" required="required" name="techniciancode" class="form-control" size="1" >
								<?php
									//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
								?>
						</select>
					</div>
				</div>
			</div>
			<br> --->
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Vaccine list</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT1 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt1" id="tt1" required placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="month_year form-control calender">
										
				</div> 
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT2 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt2" id="tt2" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT3</label>
                <div class="col-xs-3">
					<input type="text"  name="tt3" id="tt3" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT4 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt4" id="tt4" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT5 </label>
                <div class="col-xs-3">
					<input type="text"  name="tt5" id="tt5" placeholder="yyyy-mm-dd"  value="" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div> -
				
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

/* 
$(document).ready(function(){
	$(function() {
		$(".dateofbirth").datepicker( {
			format: "yyyy-mm-dd", 
			orientation: 'top auto',
			clearBtn: true,
		});
	});
	$(".dateofbirth").keydown(function (event) {
		event.preventDefault();
	});
	
///////vaccine check ////////	
	$(".calender").on('click',function(){
		var mother_age=$("#mother_age").val();
		var minDate = new Date(mother_age);
		$('.calender').each(function(){
			$(this).datepicker('setStartDate', minDate,'clearBtn',true);
		}); 	
	});	
	$('.calender').each(function(){
		$(this).datepicker();
	}); 		
////////////
});

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
  $('#newfacode').on('change', function () {
        var newfacode = this.value;
        var dateofbirth = $("#dateofbirth").val();
        var year = dateofbirth.split("-", 1);
        var cardno = $("#cardno").val();
        var reg_no = newfacode + '-' + year + '-' + cardno;
        var newtechniciancode = "";
        $.ajax({
            type: "POST",
            data: "facode=" + newfacode,
            url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
            success: function (result) {
                console.log(result);
                $('#techniciancode').html(result);
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
});  */
 /* $.ajax({
            type: "POST",
            data: "child_registration_no=" + reg_no,
            url: "<?php echo base_url(); ?>Ajax_calls/CheckChlidRegistrationNo",
            success: function (data) {
                if (data != 0) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if (data.child_registration_no != '') {
                        $("#cardno").html(data.child_registration_no);
                        $('#site_response_cardno').css('display', 'block');
                        $('#site_response_cardno').css('color', 'red');
                        $("#site_response_cardno").html('Child Registration of this Card No and Facility Already Exist.');
                        $('#cardno').css('border-color', 'red');
                        $('#cardno').val('');
                        $('#newfacode').val('');
                        $('#techniciancode').val('');
                    }
                } else {
                    $('#nic').css('border-color', '#66AFE9');
                    $("#site_response").html('');
                    $('#site_response').css('display', 'block');
                }
            }
        }); */

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
	
	
//for date of birth
	 $('#dateofbirth').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#tt1').datepicker('setStartDate', minDate);
		$('#tt2').datepicker('setStartDate', minDate);
		$('#tt3').datepicker('setStartDate', minDate);
		$('#tt4').datepicker('setStartDate', minDate);
		$('#tt5').datepicker('setStartDate', minDate);
		dp.date = e.date;
		dp.setValue();
	}); 

    $('#newuncode,#uncode').on('change' , function (){
			var uncode = this.value;
				  
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
				//console.log(result)
			  $('#address').html(result);
			}
		});
	});
	
//get facility by uc
    $('#uncode').on('change', function () {
        var newuncode = this.value;
        var newfacode = "";
        $.ajax({
            type: "POST",
            data: "uncode=" + newuncode,
            url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
            success: function (result) {
                $('#newfacode').html(result);
            }
        }); //
        $('#newfacode').empty();
    }); //get technician by HF
    $('#newfacode').on('change', function () {
        var newfacode = this.value;
		
		
		
        //var dateofbirth = $("#dateofbirth").val();
        //var year = dateofbirth.split("-", 1);
		
			
	  var d = new Date();
	  var year = d.getFullYear();
		
		
        var cardno = $("#cardno").val();
		var reg_no = newfacode + '-' + year + '-' + cardno;
        var newtechniciancode = "";
        $.ajax({
            type: "POST",
            data: "facode=" + newfacode,
            url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
            success: function (result) {
                console.log(result);
                $('#techniciancode').html(result);
            }
        });

        
    });
	
	$('#tt1').on('blur', function () {
		//alert('youyou');
        var newfacode = $("#newfacode").val();
		
		
       // var dateofbirth = $("#dateofbirth").val();
		//var year = dateofbirth.split("-", 1);
		
		//var d = new Date();
	    //var year = d.getFullYear();
		var tt1 = $('#tt1').val();
		var year = tt1.split("-", 1);
		
        var cardno = $("#cardno").val();
        var reg_no = newfacode + '-' + year + '-' + cardno;
        var newtechniciancode = "";
        $.ajax({
            type: "POST", 
            data: "mother_registration_no=" + reg_no,
            url: "<?php echo base_url(); ?>Ajax_calls/CheckmotherRegistrationNo",
            success: function (data) {
				//alert(data);
                if (data != 0) {
                    var data = JSON.parse(data);
                    console.log(data);
                    if (data.mother_registration_no != '') { 
                        $("#cardno").html(data.mother_registration_no);
                        $('#site_response_cardno').css('display', 'block');
                        $('#site_response_cardno').css('color', 'red');
                        $("#site_response_cardno").html('Mother Registration of this Card No and Facility Already Exist.');
                        $('#cardno').css('border-color', 'red');
                        $('#cardno').val('');
                        //$('#newfacode').val('');
                        //$('#techniciancode').val('');
						var result = confirm('This Card No: Already Exist. \n If want to Edit this Card No Click Ok!');
						if(result == true ){
							window.location.href = '<?php echo base_url() ?>Reports/MotherRegistrationEdit/'+data.recno+'';
						}
                    }
                } else {
                    $('#nic').css('border-color', '#66AFE9');
                    $("#site_response").html('');
                    $('#site_response').css('display', 'block');
					$("#site_response_cardno").html('');
					$('#cardno').css('border-color', '#d2d6de');
                        
                }
            }
        });
    });
	
	$('#tcode').on('change', function() {
		var tcode = $("#tcode").val();
		$("#newtcode option[value="+tcode+"]").prop("selected",true);		
	});
	$('#uncode').on('change', function() {
		var uncode = $("#uncode").val();
		if(uncode > 0)
		$("#newuncode option[value="+uncode+"]").prop("selected",true);
	});
	$(document).on("keydown",".decimalclass",function(e) {
			// Ensure that it is a number and stop the keypress
			if (e.keyCode == 190 || e.keyCode == 110){
				e.preventDefault();
				$(this).val('0');
				$(this).select();
			}
	});

	//for date of vaccin
	$('#tt1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		//'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		document.getElementById('tt2').disabled = false;
		addDays('tt1', 'tt2', 30); 
		$('#tt2').val('');
		$('#tt3').val('');
		$('#tt4').val('');
		$('#tt5').val(''); 
		dp.date = e.date;
		dp.setValue();
	}).on('clearDate', function(){
		document.getElementById('tt2').disabled = true;
		document.getElementById('tt3').disabled = true;
		document.getElementById('tt4').disabled = true;
		document.getElementById('tt5').disabled = true;
		$('#tt2').val('');
		$('#tt3').val('');
		$('#tt4').val('');
		$('#tt5').val('');
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

	 $("#mother_cnic").inputmask({"mask": "99999-9999999-9"});
	 $("#contactno").inputmask({"mask": "9999-9999999"});
});
</script>
		