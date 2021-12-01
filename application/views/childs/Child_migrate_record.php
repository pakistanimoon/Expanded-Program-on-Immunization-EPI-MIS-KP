      <?php //print_r($data);exit; ?>  
		 <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url(); ?>Reports/ChildMigrateSave">
               
						<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Migrate In EPI Center Info </div>
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
													echo getTehsils_options(false); 
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
							<div class="row">
									<input type="hidden" name="recno" id="recno" value="<?php echo $data['recno']; ?>"> 
									<input type="hidden" name="child_registration_no" id="child_registration_no" value="<?php echo $data['child_registration_no']; ?>"> 
									<label class="col-xs-2 col-xs-offset-1 control-label" for="CardNO"> Card No: </label>
								<div class="col-xs-3"> 
									<input type="text" name="cardno" maxlength="5" id="cardno" placeholder="Card No" value="" class="form-control numberclass decimalclass" required><span id="site_response_cardno"></span> 
								</div> 
							</div>
								<label class="col-xs-2 col-xs-offset-1 control-label" for="name">Name</label>
							<div class="col-xs-3"> 
								 <input type="text"  name="nameofchild" id="nameofchild" placeholder="Name of Child"  value="<?php echo $data['nameofchild']; ?>" readonly  class="form-control "/>
							</div>
							<label class="col-xs-2  control-label" for="Gender">Gender</label>
                            <div class="col-xs-3"> 
								<p><?php  
									if(isset($data['gender']) AND $data['gender'] == 'm'){echo 'Male' ;}else{echo 'Female';} 
								?></p>
								<!--<input type="radio"  required name="gender" <?php  if(isset($data['gender']) AND $data['gender'] == 'm'){echo 'checked value="m" ' ;}else{echo '';}?> > Male
								<input type="radio" required name="gender" <?php  if(isset($data['gender']) AND $data['gender'] == 'f'){echo 'checked value="f" ';}else{echo '';}?> > Female-->
							</div>
                        </div>
                        <!--<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Parents info</div> <br>-->
                        <div class="row"> 
								<label class="col-xs-2 col-xs-offset-1 control-label" for="fathername"> Father Name</label>
                            <div class="col-xs-3"> 
								<input type="text"  name="fathername" id="fathername" placeholder="Father Name"  value= "<?php echo $data['fathername'];  ?>" readonly class="form-control "/><?php echo form_error('fathername'); ?>
							</div> 
								<label class="col-xs-2 control-label" for="cnic">Father CNIC</label>
                            <div class="col-xs-3"> 
								<input type="text" name="fathercnic" id="fathercnic" placeholder="Father Cnic" value="<?php echo $data['fathercnic'];  ?>" readonly class="form-control "><span id="site_response"></span> 
							</div>
                        </div>
                        <div class="row"> 
								<label class="col-xs-2 col-xs-offset-1  control-label" for="mothername">Mother name</label>
                            <div class="col-xs-3"> 
								<input type="text" name="mothername" id="mothername" placeholder="Mother name" value="<?php echo $data['mothername'];  ?>" readonly class="form-control "> 
							</div>
								<label class="col-xs-2 control-label" for="cnic">Mother CNIC</label>
                            <div class="col-xs-3"> 
								<input type="text" name="mothercnic" id="mothercnic" placeholder="Mother Cnic" value="<?php echo $data['mothercnic'];  ?>" readonly class="form-control "><span id="site_responsem"></span> 
							</div>
                        </div>
                        <div class="row">
								<label class="col-xs-2 col-xs-offset-1 control-label" for="CardNO">Date of Birth </label>
                            <div class="col-xs-3">
								<input name="dateofbirth" id="dateofbirth" required="" value="<?php echo $data['dateofbirth'];  ?>" placeholder="yyyy-mm-dd" readonly class="month_year form-control " required type="text"> 
						    </div>
								<label class="col-xs-2  control-label" for="Contact"> Contact Number</label>
							<div class="col-xs-3">
								<input type="text" name="contactno" id="contactno" placeholder="Enter Contact Number" value="<?php echo $data['contactno'];  ?>" readonly class="form-control ">
							</div>
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
								<select  id="address" required="required" name="address" class="form-control" size="1" >
									<?php
										//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); 
									?>
								</select>
							</div>
							<label class="col-xs-2  control-label"  for = "name" >House/Street</label>
							<div class="col-xs-3">
								<input type="text"  name="housestreet" id="housestreet" placeholder="House/Street"  value=""  class="form-control ">				
							</div>
                        </div> <br>
                        
						<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Doses Administered</div> <br>
                        
						<div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">BCG </label>
                            <div class="col-xs-3"> 
								<input type="text" name="bcg" <?php echo isset($data['bcg'])?'readonly':'id="bcg"';  ?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['bcg'])?$data['bcg']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-0 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="opv0" <?php echo isset($data['opv0'])?'readonly':'id="opv0"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv0'])?$data['opv0']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">HEP-B </label>
                            <div class="col-xs-3"> 
								<input type="text" name="hepb" <?php echo isset($data['hepb'])?'readonly':'id="hepb"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['hepb'])?$data['hepb']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div> <br>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Penta-1 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="penta1" <?php echo isset($data['penta1'])?'readonly':'id="penta1"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['penta1'])?$data['penta1']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1">
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-1 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="rota1" <?php echo isset($data['rota1'])?'readonly':'id="rota1"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['rota1'])?$data['rota1']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
							<!--
								<label class="col-xs-2  control-label" for="">Is Child Dead </label>
								<div class="col-xs-1"> <input type="checkbox" id="childdeath" name="vehicle1" dir="rtl" value="0"></div>
								<label class="col-xs-2  control-label" for="cnic">Is Refusal </label>
								<div class="col-xs-1"> <input type="checkbox" id="childrefusal" name="vehicle2" dir="rtl" value="1"></div>
							-->
						</div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-1 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="opv1" <?php echo isset($data['opv1'])?'readonly':'id="opv1"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv1'])?$data['opv1']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
							<div id="deathrow" style="display: none;">
								<label class="col-xs-2  control-label" for="cnic">Date of death </label>
								<div class="col-xs-3"> <input type="text" name="dateofdeath" id="dateofdeath" placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv0'])?$data['opv0']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> </div>
							</div>
							<div id="refusalrow" style="display: none;">
								<label class="col-xs-2  control-label" for="cnic">Date of refusal </label>
								<div class="col-xs-3"> <input type="text" name="dateofrefusal" id="dateofrefusal" placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv0'])?$data['opv0']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> </div>
							</div>
						</div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-1 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="pcv1" <?php echo isset($data['pcv1'])?'readonly':'id="pcv1"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['pcv1'])?$data['pcv1']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div> <br>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Penta-2 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="penta2" <?php echo isset($data['penta2'])?'readonly':'id="penta2"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['penta2'])?$data['penta2']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-2 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="rota2" <?php echo isset($data['rota2'])?'readonly':'id="rota2"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['rota2'])?$data['rota2']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-2 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="opv2" <?php echo isset($data['opv2'])?'readonly':'id="opv2"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv2'])?$data['opv2']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-2 </label>
							<div class="col-xs-3"> 
								<input type="text" name="pcv2" <?php echo isset($data['pcv2'])?'readonly':'id="pcv2"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['pcv2'])?$data['pcv2']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div> 
						<br>
                        <div class="row">
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">penta-3 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="penta3" <?php echo isset($data['penta3'])?'readonly':'id="penta3"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['penta3'])?$data['penta3']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">OPV-3 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="opv3" <?php echo isset($data['opv3'])?'readonly':'id="opv3"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['opv3'])?$data['opv3']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">PCV-3 </label>
                            <div class="col-xs-3"> 
								<input type="text" name="pcv3" <?php echo isset($data['pcv3'])?'readonly':'id="pcv3"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['pcv3'])?$data['pcv3']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">IPV</label>
                            <div class="col-xs-3">
								<input type="text" name="ipv" <?php echo isset($data['ipv'])?'readonly':'id="ipv"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['ipv'])?$data['ipv']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div> <br>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Measles-1</label>
                            <div class="col-xs-3"> 
								<input type="text" name="measles1" <?php echo isset($data['measles1'])?'readonly':'id="measles1"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['measles1'])?$data['measles1']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div> <br>
                        <div class="row"> 
							<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Measles-2</label>
                            <div class="col-xs-3"> 
								<input type="text" name="measles2" <?php echo isset($data['measles2'])?'readonly':'id="measles2"';?> placeholder="yyyy-mm-dd" value="<?php echo isset($data['measles2'])?$data['measles2']:'';?>" data-date-format="yyyy-mm-dd"  class="form-control calender1"> 
							</div>
                        </div>
                    </div> <br>
                    <div class="row">
                        <div class="col-xs-7" style="margin-left:53.5%;"> 
							<button type="submit" class="btn btn-md btn-success" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit </button> 
							<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button> 
							<a href="<?php echo base_url(); ?>Reports/ChildRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a> 
						</div>
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
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">
$(document).ready(function () {
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
          'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#bcg').datepicker('setStartDate', minDate);
		$('#opv0').datepicker('setStartDate', minDate);
		$('#hepb').datepicker('setStartDate', minDate);
		
		/* for onedoses doses */
		var onedoses = minDate.getFullYear() + '-' + (minDate.getMonth()+1) + '-' + (minDate.getDate()+43);
		//alert(onedoses);
		$('#penta1').datepicker('setStartDate', onedoses);
		$('#rota1').datepicker('setStartDate', onedoses);
		$('#opv1').datepicker('setStartDate', onedoses);
		$('#pcv1').datepicker('setStartDate', onedoses);
		
		
		$('#penta2').datepicker('setStartDate', minDate);
		$('#rota2').datepicker('setStartDate', minDate);
		$('#opv2').datepicker('setStartDate', minDate);
		$('#pcv2').datepicker('setStartDate', minDate);
		$('#penta3').datepicker('setStartDate', minDate);
		$('#opv3').datepicker('setStartDate', minDate);
		$('#pcv3').datepicker('setStartDate', minDate);
		$('#ipv').datepicker('setStartDate', minDate);
		$('#measles1').datepicker('setStartDate', minDate);
		$('#measles2').datepicker('setStartDate', minDate);
		$('#dateofdeath').datepicker('setStartDate', minDate);
		$('#dateofrefusal').datepicker('setStartDate', minDate);
		dp.date = e.date;
		dp.setValue();
	});
	//for date of vaccin
	$('#bcg').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  var minDate = new Date(e.date.valueOf());
	  
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#opv0').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	});
	$('#hepb').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#penta1').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#rota1').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#opv1').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#pcv1').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#penta2').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#rota2').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#opv2').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#pcv2').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#penta3').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#opv3').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#pcv3').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#ipv').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#measles1').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	}); 
	$('#measles2').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	});
	$('#dateofdeath').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
	});
	$('#dateofrefusal').datepicker({	
		  "format": "yyyy-mm-dd",
		  'startView': 2,
		  'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
	  var dp = $(e.currentTarget).data('datepicker');
	  dp.date = e.date;
	  dp.setValue();
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
        $('#facode').empty();
    }); //get technician by HF
    $('#newfacode').on('change', function () {
		//alert('yo');
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
    });
    $('#dateofbirth').on('blur', function () {
		//alert('yo');
        var newfacode = $("#newfacode").val();
        var dateofbirth = $("#dateofbirth").val();
		var year = dateofbirth.split("-", 1);
        var cardno = $("#cardno").val();
        var reg_no = newfacode + '-' + year + '-' + cardno;
        var newtechniciancode = "";
		if(dateofbirth != ''){
			$.ajax({
				type: "POST",
				data: "child_registration_no=" + reg_no,
				url: "<?php echo base_url(); ?>Ajax_calls/CheckChlidRegistrationNo",
				success: function (result) {
					//console.log(result); 
					//$('#tcode').attr("id", ''); 
					//$('#uncode').attr("id", ''); 
					//$('#facode').attr("id", ''); 
					//$('#techniciancode').attr("id", ''); 
					//$("#searchmig").html('');
					//$("#migraform").html(result);
					
				}
			});
		}
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
	//check father cnic already enter mothercnic
    /* $(document).on('blur', '#fathercnic', function () {
        var fathercnic = $(this).val();
        if (fathercnic != '') {
            $.ajax({
                type: 'POST',
                data: "fathercnic=" + fathercnic,
                url: '<?php echo base_url(); ?>Ajax_calls/checkfatherNIC',
                dataType: "json",
                success: function (data) {
                    if (data != 0) {
                        var data = JSON.parse(data);
                        console.log(data);
                        if (data.fathercnic != '') {
                            $("#fathercnic").html(data.fathercnic);
                            $('#site_response').css('display', 'block');
                            $('#site_response').css('color', 'red');
                            $("#site_response").html('CNIC Already Exist For Father.');
                            $('#fathercnic').css('border-color', 'red');
                            $('#fathercnic').val('');
                        }
                    } else {
                        $('#nic').css('border-color', '#66AFE9');
                        $("#site_response").html('');
                        $('#site_response').css('display', 'block');
                    }
                }
            });
        }
    }); //check father cnic already enter mothercnic
    $(document).on('blur', '#mothercnic', function () {
        var mothercnic = $(this).val();
        if (mothercnic != '') {
            $.ajax({
                type: 'POST',
                data: "mothercnic=" + mothercnic,
                url: '<?php echo base_url(); ?>Ajax_calls/checkmotherNIC',
                dataType: "json",
                success: function (data) {
                    if (data != 0) {
                        var data = JSON.parse(data);
                        console.log(data);
                        if (data.mothercnic != '') {
                            $("#mothercnic").html(data.mothercnic);
                            $('#site_responsem').css('display', 'block');
                            $('#site_responsem').css('color', 'red');
                            $("#site_responsem").html('CNIC Already Exist For Mother.');
                            $('#mothercnic').css('border-color', 'red');
                            $('#mothercnic').val('');
                        }
                    } else {
                        $('#nic').css('border-color', '#66AFE9');
                        $("#site_responsem").html('');
                        $('#site_responsem').css('display', 'block');
                    }
                }
            });
        }
    }); */
});
</script>