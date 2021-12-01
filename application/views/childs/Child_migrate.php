<!--start of page content or body--><?php if ($this->session->flashdata('message')) {  ?> <div class="row mb3">
        <div class="col-sm-12 filters-selection" style="Background-color:#00F418;">
            <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this->session->flashdata('message'); ?></strong></div>
        </div>
    </div><?php } ?> <div class="container bodycontainer">
    <div class="row">
        <div class="panel panel-primary">
            <ol class="breadcrumb"> <?php echo $this->breadcrumbs->show(); ?> </ol>

            <div class="panel-heading"> Migrate Child Registeration Form </div>
         <div id="searchmig" class="panel-body">
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
			<div class="row"> <label class="col-xs-2 col-xs-offset-1 control-label" for="CardNO"> Card No: </label>
                            <div class="col-xs-3"> <input type="text" name="cardno" maxlength="5" id="cardno" placeholder="Card No" value="" class="form-control numberclass decimalclass" required> <span id="site_response_cardno"></span> </div> 
						 
            
			<label class="col-xs-2 control-label" for="CardNO">Date of Birth </label>
                            <div class="col-xs-3"> <input name="dateofbirth" id="dateofbirth" required="" placeholder="yyyy-mm-dd" class="month_year form-control " required type="text"> 
			</div>
			</div>

			
                        
            </div>
            </form>
        </div>
		
		<br>
			<div id="migraform">
			
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
					$("#searchmig").html('');
					$("#migraform").html(result);
					
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