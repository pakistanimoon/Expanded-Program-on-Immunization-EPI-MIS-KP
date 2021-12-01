<!--start of page content or body--><?php if ($this->session->flashdata('message')) {  ?> <div class="row mb3">
        <div class="col-sm-12 filters-selection" style="Background-color:#00F418;">
            <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>
        </div>
    </div><?php } ?> <div class="container bodycontainer">
    <div class="row">
        <div class="panel panel-primary">
            <ol class="breadcrumb"> <?php echo $this->breadcrumbs->show(); ?> </ol>
            <div class="panel-heading"> Add Child Registeration Form </div>
            <div class="panel-body">
                <!-- <form  action="<?php echo base_url(); ?>Reports_list/child_save" method="post" class="form-horizontal form-bordered" >-->
                <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url(); ?>Reports/ChildRegistrationSaveAdd">
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
                        <div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Child Basic info</div> <br>
						 <div class="row">
                            <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="CardNO"> Card No: </label>
                            <div class="col-xs-3"> <input type="text" name="cardno" maxlength="5" id="cardno" placeholder="Card No" value="" class="form-control decimalclass numberclass" required> <span id="site_response_cardno"></span> </div> 
							
							<label class="col-xs-2  control-label" for="CardNO">Date of Birth </label>
                            <div class="col-xs-3"> <input name="dateofbirth" id="dateofbirth" required="" placeholder="yyyy-mm-dd" class="month_year form-control " readonly required type="text" value="" data-date-format="yyyy-mm-dd"> 
						    </div>
                        </div>
						<label class="col-xs-2 col-xs-offset-1 control-label" for="name">Name</label>
                            <div class="col-xs-3"> <input type="text" name="nameofchild" id="nameofchild" placeholder="Name of Child" value="" class="form-control "> </div>
						<label class="col-xs-2  control-label" for="Gender">Gender</label>
                            <div class="col-xs-3"> <input type="radio" required name="gender" value="m"> Male <input type="radio" required name="gender" value="f"> Female </div>
						 
                        </div>
                        <!--<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Parents info</div> <br>-->
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="fathername"> Father Name</label>
                            <div class="col-xs-3"> <input type="text" name="fathername" id="fathername" placeholder="Father Name" value="" class="form-control "> </div> <label class="col-xs-2 control-label" for="cnic">Father CNIC</label>
                            <div class="col-xs-3"> <input type="text" name="fathercnic" id="fathercnic" placeholder="Father Cnic" value="" class="form-control "><span id="site_response"></span> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1  control-label" for="mothername">Mother name</label>
                            <div class="col-xs-3"> <input type="text" name="mothername" id="mothername" placeholder="Mother name" value="" class="form-control "> </div> <label class="col-xs-2 control-label" for="cnic">Mother CNIC</label>
                            <div class="col-xs-3"> <input type="text" name="mothercnic" id="mothercnic" placeholder="Mother Cnic" value="" class="form-control "><span id="site_responsem"></span> </div>
                        </div>
                        <div class="row">
							<label class="col-xs-2 col-xs-offset-1  control-label" for="Contact"> Contact Number</label>
                            <div class="col-xs-3"> <input type="text" name="contactno" id="contactno" placeholder="Enter Contact Number" value="" class="form-control "> </div>
                        </div> 
						 <div class="row">
						 
                        </div>
                        <div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Child Address</div> <br>
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
                        <div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Doses Administered</div> <br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">BCG </label>
                            <div class="col-xs-3"> <input type="text" name="bcg" id="bcg" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1" > </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-0 </label>
                            <div class="col-xs-3"> <input type="text" name="opv0" id="opv0" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">HEP-B </label>
                            <div class="col-xs-3"> <input type="text" name="hepb" id="hepb" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div> <br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Penta-1 </label>
                            <div class="col-xs-3"> <input type="text" name="penta1" id="penta1" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
					</div>
						<div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-1 </label>
							<div class="col-xs-3"> 
								<input type="text" name="rota1" id="rota1" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1">
							</div>
							<label class="col-xs-2 control-label" for="">Is Child Dead </label>
							<div class="col-xs-1">
								<input type="checkbox" id="childdeath" name="vehicle1" dir="rtl" value="0">
							</div>
							<label class="col-xs-2  control-label" for="cnic">Is Refusal </label>
							<div class="col-xs-1"> 
								<input type="checkbox" id="childrefusal" name="vehicle2" dir="rtl" value="1">
							</div>
						</div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-1 </label>
                            <div class="col-xs-3"> <input type="text" name="opv1" id="opv1" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
							 <div id="deathrow" style="display: none;">
							 <label class="col-xs-2  control-label" for="cnic">Date of death </label>
								<div class="col-xs-3"> <input type="text" name="dateofdeath" id="dateofdeath" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
							</div>
							<div id="refusalrow" style="display: none;">
							 <label class="col-xs-2  control-label" for="cnic">Date of refusal </label>
								<div class="col-xs-3"> <input type="text" name="dateofrefusal" id="dateofrefusal" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
							</div>
						</div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-1 </label>
                            <div class="col-xs-3"> <input type="text" name="pcv1" id="pcv1" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div> <br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Penta-2 </label>
                            <div class="col-xs-3"> <input type="text" name="penta2" id="penta2" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-2 </label>
                            <div class="col-xs-3"> <input type="text" name="rota2" id="rota2" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-2 </label>
                            <div class="col-xs-3"> <input type="text" name="opv2" id="opv2" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"><label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-2 </label>
								<div class="col-xs-3"> <input type="text" name="pcv2" id="pcv2" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div> 
						<br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">penta-3 </label>
                            <div class="col-xs-3"> <input type="text" name="penta3" id="penta3" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-3 </label>
                            <div class="col-xs-3"> <input type="text" name="opv3" id="opv3" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-3 </label>
                            <div class="col-xs-3"> <input type="text" name="pcv3" id="pcv3" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">IPV</label>
                            <div class="col-xs-3"> <input type="text" name="ipv" id="ipv" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div> <br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Measles-1</label>
                            <div class="col-xs-3"> <input type="text" name="measles1" id="measles1" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div> <br>
                        <div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Measles-2</label>
                            <div class="col-xs-3"> <input type="text" name="measles2" id="measles2" placeholder="yyyy-mm-dd" value="" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
                        </div>
                    </div> <br>
                    <div class="row">
                        <div class="col-xs-7" style="margin-left:53.5%;"> <button type="submit" class="btn btn-md btn-success" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit </button> <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button> <a href="<?php echo base_url(); ?>Reports/ChildRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a> </div>
                    </div>
            </div>
            </form>
        </div>
        <!--end of panel body-->
    </div>
    <!--end of panel panel-primary-->
</div>
<!--end of row-->
</div>
<!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">
	
	 /* function incrementDated(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			
			var bcg = $("#bcg").val();
			var dateofbirth = $("#dateofbirth").val();
			
			if(bcg > dateofbirth ){
				//alert('if');
				addDays('bcg' , 'penta1', 28); 
				addDays('bcg' , 'rota1', 28); 
				addDays('bcg' , 'pcv1', 28); 
			} else {
				//alert('else');
				addDays('dateofbirth' , 'penta1', 42); 
				addDays('dateofbirth' , 'rota1', 42); 
				addDays('dateofbirth' , 'pcv1', 42); 
			}
			 return increasedDate;
		} */
		
	 function incrementDateopv(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			
			var opv0 = $("#opv0").val();
			var dateofbirth = $("#dateofbirth").val();
			
			if(opv0 > dateofbirth ){
				//alert('if');
				addDays('opv0' , 'opv1', 28);
			} else {
				//alert('else');
				addDays('dateofbirth' , 'opv1', 42); 
			}
			 return increasedDate;
		}
		
		/*  function incrementDate(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate ){
				document.getElementById("penta1").disabled = false;
				document.getElementById("rota1").disabled = false;
				document.getElementById("pcv1").disabled = false;
				addDays('bcg', 'penta1', 42);  
				addDays('bcg', 'rota1', 42);
				//addDays('dateofbirth', 'opv1', 42); 
				addDays('bcg' , 'pcv1', 42); 
			} else {
				document.getElementById("penta1").disabled = true;
				document.getElementById("rota1").disabled = true;
				document.getElementById("pcv1").disabled = true;
			}
			 return increasedDate;
		}  */
		
		function incrementDateipv(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate ){
				document.getElementById("ipv").disabled = false;
				addDays('dateofbirth' , 'ipv', 98); 
			} else {	
				document.getElementById("ipv").disabled = true;
			}
			 return increasedDate;
		}
		
		function incrementDatemeasles1(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate){
				document.getElementById("measles1").disabled = false;
				addDays('dateofbirth' , 'measles1', 270); 
			} else {
				document.getElementById("measles1").disabled = true;
			}
			 return increasedDate;
		}

	$(document).ready(function () {
		// disable all if not selected date of birth
		document.getElementById("bcg").disabled = true;
		document.getElementById("opv0").disabled = true;
		document.getElementById("hepb").disabled = true;
		document.getElementById("penta1").disabled = true;
		document.getElementById("rota1").disabled = true;
		document.getElementById("opv1").disabled = true;
		document.getElementById("pcv1").disabled = true;
		document.getElementById("penta2").disabled = true;
		document.getElementById("rota2").disabled = true;
		document.getElementById("opv2").disabled = true;
		document.getElementById("pcv2").disabled = true;
		document.getElementById("penta3").disabled = true;
		document.getElementById("opv3").disabled = true;
		document.getElementById("pcv3").disabled = true;
		document.getElementById("ipv").disabled = true;
		document.getElementById("measles1").disabled = true;
		document.getElementById("measles2").disabled = true;
		document.getElementById("dateofdeath").disabled = true;
		document.getElementById("dateofrefusal").disabled = true;
				
		$('#childdeath,#childrefusal').on('change', function() {
			var checkedprop = $(this).prop('checked');
			var checkedValue = $(this).val();
			if(checkedValue == 0){
				$( "#childrefusal" ).prop( "checked", false );
				$('#deathrow').css('display', 'block');
				$('#refusalrow').css('display', 'none');
				$('#dateofrefusal').val('');
			}else{
				$( "#childdeath" ).prop( "checked", false );
				$('#refusalrow').css('display', 'block');
				$('#deathrow').css('display', 'none');
				$('#dateofdeath').val('');
			}
			if(checkedprop == false){
				$('#refusalrow').css('display', 'none');
				$('#deathrow').css('display', 'none');
				$('#dateofdeath').val('');
				$('#dateofrefusal').val('');
			}
		});

//for date of birth
	$('#dateofbirth').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		//'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#bcg').datepicker('setStartDate', minDate);
		$('#opv0').datepicker('setStartDate', minDate);
		$('#hepb').datepicker('setStartDate', minDate);
		$('#dateofdeath').datepicker('setStartDate', minDate);
		$('#dateofrefusal').datepicker('setStartDate', minDate);
		
		document.getElementById("bcg").disabled = false;
		document.getElementById("opv0").disabled = false;
		document.getElementById("hepb").disabled = false;
		document.getElementById("penta1").disabled = false;
		document.getElementById("rota1").disabled = false; 
		//document.getElementById("opv1").disabled = false; 
		document.getElementById("pcv1").disabled = false;
		document.getElementById("dateofdeath").disabled = false;
		document.getElementById("dateofrefusal").disabled = false;
		var dateofbirth  = new Date($('#dateofbirth').val());
		//var amountToIncreaseWith = 42; //Edit this number to required input
		var amountToIncreaseWithipv = 98; //Edit this number to required input
		var amountToIncreaseWithmeasles1 = 270; //Edit this number to required input
		//console.log(incrementDate(dateofbirth,amountToIncreaseWith));
		console.log(incrementDateipv(dateofbirth,amountToIncreaseWithipv));
		console.log(incrementDatemeasles1(dateofbirth,amountToIncreaseWithmeasles1));
		
		addDays('dateofbirth' , 'penta1', 42); 
		addDays('dateofbirth' , 'rota1', 42); 
		addDays('dateofbirth' , 'pcv1', 42); 
				
		$("#bcg").val('');
		$("#opv0").val('');
		$("#hepb").val('');
		$("#penta1").val('');
		$("#rota1").val('');
		$("#opv1").val('');
		$("#pcv1").val('');
		$("#penta2").val('');
		$("#rota2").val('');
		$("#opv2").val('');
		$("#pcv2").val('');
		$("#penta3").val('');
		$("#opv3").val('');
		$("#pcv3").val('');
		$("#ipv").val('');
		$("#measles1").val('');
		$("#measles2").val(''); 
		$("#dateofdeath").val(''); 
		$("#dateofrefusal").val(''); 
		dp.date = e.date;
		dp.setValue();
	});
	
	//for date of vaccin
	$('#bcg').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		
		 var dateofbirth  = new Date($('#dateofbirth').val());
		/*var amountToIncreaseWith = 42; //Edit this number to required input
		console.log(incrementDate(bcg,amountToIncreaseWith)); */
		//var amountToIncreaseWithdateofbirthh = 42; //Edit this number to required input
		//incrementDated(dateofbirth,amountToIncreaseWithdateofbirthh); 
		/* $("#penta1").val('');
		$("#rota1").val('');
		$("#pcv1").val(''); */
	}).on('clearDate', function(){
		/* $("#penta1").val('');
		$("#rota1").val('');
		$("#pcv1").val(''); */
	}); 
	 
	$('#opv0').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		$("#opv1").val('');
		addDays('opv0', 'opv1', 42); 
		document.getElementById("opv1").disabled = false;
		
		var dateofbirth  = new Date($('#dateofbirth').val());
		var amountToIncreaseWithdateofbirthhh = 42; //Edit this number to required input
		incrementDateopv(dateofbirth,amountToIncreaseWithdateofbirthhh); 
		
	});
	
	$('#hepb').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) { 

	}); 
	
	$('#penta1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
		addDays('penta1' , 'penta2', 28); 
		document.getElementById("penta2").disabled = false;
		$("#penta2").val('');
	});   
	
	$('#rota1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(), 
	}).on('changeDate', function(e) {
		addDays('rota1', 'rota2', 28);  
		document.getElementById("rota2").disabled = false;	
		$("#rota2").val('');
	}); 
	$('#opv1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),

	}).on('changeDate', function(e) {
		addDays('opv1', 'opv2', 28);	  
		document.getElementById("opv2").disabled = false;		
		$("#opv2").val('');
	});

	$('#pcv1').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('pcv1', 'pcv2', 28);
		document.getElementById("pcv2").disabled = false;  
		$("#pcv2").val('');  
	}); 
	
	$('#penta2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('penta2', 'penta3', 28);  
		document.getElementById("penta3").disabled = false;	
	$("#penta3").val('');
	}); 
	
	$('#rota2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
	
	});
	
	$('#opv2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('opv2', 'opv3', 28);
		document.getElementById("opv3").disabled = false;	
		$("#opv3").val('');
	});
	
	$('#pcv2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('pcv2', 'pcv3', 28);  
		document.getElementById("pcv3").disabled = false;	
		$("#pcv3").val('');	
	}); 
	
	$('#penta3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#opv3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#pcv3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#ipv').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#measles1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('measles1', 'measles2', 28);
		document.getElementById("measles2").disabled = false;	  
		$("#measles2").val('');
	}); 
	
	$('#measles2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
		});
		
	$('#dateofdeath').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2, 
		'autoclose': true,
		'endDate' : Date(),	  
	}).on('changeDate', function(e) {
		var dateofdeath = this.value;
		var bcg = $("#bcg").val();
		var opv0 = $("#opv0").val();
		var hepb = $("#hepb").val();
		var penta1 = $("#penta1").val();
		var rota1 = $("#rota1").val();
		var opv1 = $("#opv1").val();
		var pcv1 = $("#pcv1").val();
		var penta2 = $("#penta2").val();
		var rota2 = $("#rota2").val();
		var opv2 = $("#opv2").val();
		var pcv2 = $("#pcv2").val();
		var penta3 = $("#penta3").val();
		var opv3 = $("#opv3").val();
		var pcv3 = $("#pcv3").val();
		var ipv = $("#ipv").val();
		var measles1 = $("#measles1").val();
		var measles2 = $("#measles2").val();

	if(dateofdeath < bcg){
		$('#bcg').val('');
		document.getElementById("bcg").disabled = true;
	} else {
		$("#bcg").val();
		document.getElementById("bcg").disabled = false;
	}  
	if(dateofdeath < opv0){
		$('#opv0').val('');
		document.getElementById("opv0").disabled = true;
	} else {
		$("#opv0").val();
		document.getElementById("opv0").disabled = false;
	} 
	if(dateofdeath < hepb){
		$("#hepb").val('');
		document.getElementById("hepb").disabled = true;
	} else {
		$("#hepb").val();
		document.getElementById("hepb").disabled = false;
	}
	if(dateofdeath < penta1){
		$("#penta1").val('');
		document.getElementById("penta1").disabled = true;
	} else {
		$("#penta1").val();
		document.getElementById("penta1").disabled = false;
	}
	if(dateofdeath < rota1){
		$("#rota1").val('');
		document.getElementById("rota1").disabled = true;
	} else {
		$("#rota1").val();
		document.getElementById("rota1").disabled = false;
	}
	if(dateofdeath < opv1){
		$("#opv1").val('');
		document.getElementById("opv1").disabled = true;
	} else {
		$("#opv1").val();
		document.getElementById("opv1").disabled = false;
	}
	if(dateofdeath < pcv1){
		$("#pcv1").val('');
		document.getElementById("pcv1").disabled = true;
	} else {
		$("#pcv1").val();
		document.getElementById("pcv1").disabled = false;
	}
	if(dateofdeath < penta2){
		$("#penta2").val('');
		document.getElementById("penta2").disabled = true;
	} else {
		$("#penta2").val();
		document.getElementById("penta2").disabled = false;
	}
	if(dateofdeath < rota2){
		$("#rota2").val('');
		document.getElementById("rota2").disabled = true;
	} else {
		$("#rota2").val();
		document.getElementById("rota2").disabled = false;
	}
	if(dateofdeath < opv2){
		$("#opv2").val('');
		document.getElementById("opv2").disabled = true;
	} else {
		$("#opv2").val();
		document.getElementById("opv2").disabled = false;
	}
	if(dateofdeath < pcv2){
		$("#pcv2").val('');
		document.getElementById("pcv2").disabled = true;
	} else {
		$("#pcv2").val();
		document.getElementById("pcv2").disabled = false;
	}
	if(dateofdeath < penta3){
		$("#penta3").val('');
		document.getElementById("penta3").disabled = true;
	} else {
		$("#penta3").val();
		document.getElementById("penta3").disabled = false;
	}
	if(dateofdeath < opv3){
		$("#opv3").val('');
		document.getElementById("opv3").disabled = true;
	} else {
		$("#opv3").val();
		document.getElementById("opv3").disabled = false;
	}
	if(dateofdeath < pcv3){
		$("#pcv3").val('');
		document.getElementById("pcv3").disabled = true;
	} else {
		$("#pcv3").val();
		document.getElementById("pcv3").disabled = false;
	}
	if(dateofdeath < ipv){
		$("#ipv").val('');
		document.getElementById("ipv").disabled = true;
	} else {
		$("#ipv").val();
		document.getElementById("ipv").disabled = false;
	}
	if(dateofdeath < measles1){
		$("#measles1").val('');
		document.getElementById("measles1").disabled = true;
	} else {
		$("#measles1").val();
		document.getElementById("measles1").disabled = false;
	}
	if(dateofdeath < measles2){
		$("#measles2").val('');
		document.getElementById("measles2").disabled = true;
	} else {
		$("#measles2").val();
		document.getElementById("measles2").disabled = false;
	}
	
	});
	
	$('#dateofrefusal').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dateofrefusal = this.value;
		var bcg = $("#bcg").val();
		var opv0 = $("#opv0").val();
		var hepb = $("#hepb").val();
		var penta1 = $("#penta1").val();
		var rota1 = $("#rota1").val();
		var opv1 = $("#opv1").val();
		var pcv1 = $("#pcv1").val();
		var penta2 = $("#penta2").val();
		var rota2 = $("#rota2").val();
		var opv2 = $("#opv2").val();
		var pcv2 = $("#pcv2").val();
		var penta3 = $("#penta3").val();
		var opv3 = $("#opv3").val();
		var pcv3 = $("#pcv3").val();
		var ipv = $("#ipv").val();
		var measles1 = $("#measles1").val();
		var measles2 = $("#measles2").val();

	if(dateofrefusal < bcg){
		$('#bcg').val('');
		document.getElementById("bcg").disabled = true;
	} else {
		$("#bcg").val();
		document.getElementById("bcg").disabled = false;
	}  
	if(dateofrefusal < opv0){
		$('#opv0').val('');
		document.getElementById("opv0").disabled = true;
	} else {
		$("#opv0").val();
		document.getElementById("opv0").disabled = false;
	} 
	if(dateofrefusal < hepb){
		$("#hepb").val('');
		document.getElementById("hepb").disabled = true;
	} else {
		$("#hepb").val();
		document.getElementById("hepb").disabled = false;
	}
	if(dateofrefusal < penta1){
		$("#penta1").val('');
		document.getElementById("penta1").disabled = true;
	} else {
		$("#penta1").val();
		document.getElementById("penta1").disabled = false;
	}
	if(dateofrefusal < rota1){
		$("#rota1").val('');
		document.getElementById("rota1").disabled = true;
	} else {
		$("#rota1").val();
		document.getElementById("rota1").disabled = false;
	}
	if(dateofrefusal < opv1){
		$("#opv1").val('');
		document.getElementById("opv1").disabled = true;
	} else {
		$("#opv1").val();
		document.getElementById("opv1").disabled = false;
	}
	if(dateofrefusal < pcv1){
		$("#pcv1").val('');
		document.getElementById("pcv1").disabled = true;
	} else {
		$("#pcv1").val();
		document.getElementById("pcv1").disabled = false;
	}
	if(dateofrefusal < penta2){
		$("#penta2").val('');
		document.getElementById("penta2").disabled = true;
	} else {
		$("#penta2").val();
		document.getElementById("penta2").disabled = false;
	}
	if(dateofrefusal < rota2){
		$("#rota2").val('');
		document.getElementById("rota2").disabled = true;
	} else {
		$("#rota2").val();
		document.getElementById("rota2").disabled = false;
	}
	if(dateofrefusal < opv2){
		$("#opv2").val('');
		document.getElementById("opv2").disabled = true;
	} else {
		$("#opv2").val();
		document.getElementById("opv2").disabled = false;
	}
	if(dateofrefusal < pcv2){
		$("#pcv2").val('');
		document.getElementById("pcv2").disabled = true;
	} else {
		$("#pcv2").val();
		document.getElementById("pcv2").disabled = false;
	}
	if(dateofrefusal < penta3){
		$("#penta3").val('');
		document.getElementById("penta3").disabled = true;
	} else {
		$("#penta3").val();
		document.getElementById("penta3").disabled = false;
	}
	if(dateofrefusal < opv3){
		$("#opv3").val('');
		document.getElementById("opv3").disabled = true;
	} else {
		$("#opv3").val();
		document.getElementById("opv3").disabled = false;
	}
	if(dateofrefusal < pcv3){
		$("#pcv3").val('');
		document.getElementById("pcv3").disabled = true;
	} else {
		$("#pcv3").val();
		document.getElementById("pcv3").disabled = false;
	}
	if(dateofrefusal < ipv){
		$("#ipv").val('');
		document.getElementById("ipv").disabled = true;
	} else {
		$("#ipv").val();
		document.getElementById("ipv").disabled = false;
	}
	if(dateofrefusal < measles1){
		$("#measles1").val('');
		document.getElementById("measles1").disabled = true;
	} else {
		$("#measles1").val();
		document.getElementById("measles1").disabled = false;
	}
	if(dateofrefusal < measles2){
		$("#measles2").val('');
		document.getElementById("measles2").disabled = true;
	} else {
		$("#measles2").val();
		document.getElementById("measles2").disabled = false;
	}
	
	
	}); 
	
////////////});//get district by provnice
    $('#newprocode').on('change', function () {
        var newprocode = this.value;
        var newtcode = "";
        $.ajax({
            type: "POST",
            data: "procode=" + newprocode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
            success: function (result) {
                $('#newdistcode').html(result);
            }
        });
    }); //get tehsil by district
    $('#newdistcode').on('change', function () {
        var newdistcode = this.value;
        var newtcode = "";
        $.ajax({
            type: "POST",
            data: "distcode=" + newdistcode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
            success: function (result) {
                $('#newtcode').html(result);
            }
        });
    }); //get unioncl by tehsil 
    $('#newtcode').on('change', function () {
        var newtcode = this.value;
        var newuncode = "";
        $.ajax({
            type: "POST",
            data: "tcode=" + newtcode,
            url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
            success: function (result) {
                $('#newuncode').html(result);
            }
        });
    });
    $('#newuncode,#uncode').on('change' , function (){
			var uncode = this.value;
				  
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
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
	
    $('#dateofbirth,#cardno').on('blur', function () {
        var newfacode = $("#newfacode").val();
        var dateofbirth = $("#dateofbirth").val();
		var year = dateofbirth.split("-", 1);
        var cardno = $("#cardno").val();
        var reg_no = newfacode + '-' + year + '-' + cardno;
        var newtechniciancode = "";
        $.ajax({
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
                        //$('#newfacode').val('');
                        //$('#techniciancode').val('');
						var result = confirm('This Card No: Already Exist. \n If want to Edit this Card No Click Ok!');
						if(result == true ){
							window.location.href = '<?php echo base_url() ?>/Reports/ChildRegistrationEdit/'+data.recno+'';
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
		if (e.keyCode == 190 || e.keyCode == 110){
			e.preventDefault();
			$(this).val('0');
			$(this).select();
		}
	});
	$('#dateofdeath ,#dateofrefusal').on('blur', function () {
		var selecteddate = $(this).val();
		var minDate = new Date(selecteddate);
		$('#bcg').datepicker('setEndDate', minDate);
		$('#opv0').datepicker('setEndDate', minDate);
		$('#hepb').datepicker('setEndDate', minDate);
		$('#penta1').datepicker('setEndDate', minDate);
		$('#rota1').datepicker('setEndDate', minDate);
		$('#opv1').datepicker('setEndDate', minDate);
		$('#pcv1').datepicker('setEndDate', minDate);
		$('#penta2').datepicker('setEndDate', minDate);
		$('#rota2').datepicker('setEndDate', minDate);
		$('#opv2').datepicker('setEndDate', minDate);
		$('#pcv2').datepicker('setEndDate', minDate);
		$('#penta3').datepicker('setEndDate', minDate);
		$('#opv3').datepicker('setEndDate', minDate);
		$('#pcv3').datepicker('setEndDate', minDate);
		$('#ipv').datepicker('setEndDate', minDate);
		$('#measles1').datepicker('setEndDate', minDate);
		$('#measles2').datepicker('setEndDate', minDate); 
	});
	
		$("#fathercnic").inputmask({"mask": "99999-9999999-9"});
		$("#mothercnic").inputmask({"mask": "99999-9999999-9"});
		$("#contactno").inputmask({"mask": "9999-9999999"});
	
	});

	function toDate(start_date_id, end_date_id)	{
		$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	
	function addDays(start_date_id, end_date_id, numberOfDays=30)	{
		var from_date = $('#'+start_date_id).datepicker().val();
		from_date = from_date.substring(0,4) + '-' + from_date.substring(5,7) + '-' + from_date.substring(8,10);
		from_date = new Date(from_date.toString());
		from_date.setDate(from_date.getDate() + numberOfDays);
		
		var dd = from_date.getDate();
		var mm = from_date.getMonth() + 1;
		var y = from_date.getFullYear();
		var formattedDate = y + '-'+ mm + '-'+ dd;
		$("#"+end_date_id).datepicker('setStartDate', from_date);
	} 
	
</script>