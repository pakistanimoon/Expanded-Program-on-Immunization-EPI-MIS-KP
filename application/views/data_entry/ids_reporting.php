<div class="container bodycontainer">
<div class="row">
<div class="panel panel-primary">
   <div class="panel-heading">IDSRS Weekly Reporting Form</div>
     <div class="panel-body">
     <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Data_entry/ids_reporting_save" id="whereEntry">
	 <?php 
		//echo '<pre>';print_r($idsReport);exit;
	 if(isset($idsReport)){
	       	  ?>  <input type="hidden" name="id" id="id" value="<?php if(isset($idsReport)){ echo $idsReport->id; }else {  } ?>">
			  <?php } ?>
	   <table class="table table-bordered   table-striped table-hover  mytable3">
          <tbody>
          <tr>
            <td><label>Province</label></td>
            <td><input readonly="readonly" class="form-control" value="Khyber Pakhtunkhwa" placeholder="Khyber Pakhtunkhwa" type="text"></td>
            <td><label>District</label></td>
            <td><select class="form-control" id="distcode" name="distcode">
          	<?php if(isset($idsReport)){ ?>
          		<option value="<?php echo $idsReport->distcode; ?>"><?php echo $district; ?></option>
            <?php }else{ ?>
             <?php echo getDistricts_options(); ?>
             <?php } ?>
            </select></td>
            <td><label>Tehsil</label></td>
            <td><?php if(isset($idsReport)){ ?>
          <select class="form-control" name="tcode" id="tcode">
              <option value="<?php echo $idsReport->tcode; ?>"><?php echo $tehsil; ?></option>
            </select>
          <?php }else{ ?>
            <select class="form-control" name="tcode" id="tcode">
            </select>
            <?php } ?></td>
          </tr>
          <tr>
            <td><label>Union Council</label></td>
            <td><?php if(isset($idsReport)){ ?>
          <select class="form-control" name="uncode" id="uncode">
              <option value="<?php echo $idsReport->uncode; ?>"><?php echo $unioncouncil; ?></option>
            </select>
            <?php }else{ ?>
            <select class="form-control" name="uncode" id="uncode">
            </select>
             <?php } ?></td>
            <td><label>Health Facility</label></td>
            <td><?php if(isset($idsReport)){ ?>
          	<select class="form-control" name="facode" id="facode">
              <option value="<?php echo $idsReport->facode; ?>"><?php echo $facility; ?></option>
            </select>
             <?php }else{ ?>
            <select class="form-control" name="facode" id="facode"></select>
             <?php } ?></td>
            <td><label>Year</label></td>
            <td> <select class="form-control text-center" name="year" id="year">
            	<?php if(isset($idsReport)){ ?>
            		<option value="<?php echo $idsReport->year; ?>"><?php echo $idsReport->year; ?></option>
            	<?php }else{ ?>
             	<?php echo $years; 
						}?>
            </select></td>
          </tr>
          <tr>
            <td><label>Epid. Week No</label></td>
            <td><?php //echo getEpiWeek(); ?>
            <select class="form-control" name="epi_week" id="epi_week">
            	<?php 
				if(isset($idsReport)){
				?>
            		<option value="<?php echo sprintf("%02d",$idsReport->epi_week); ?>">Week <?php echo sprintf("%02d",$idsReport->epi_week); ?></option>
            	<?php }else{ ?>
					<option>--Select Week No--</option>
					<?php } ?>
            </select></td>
            <td><label>Date From</label></td>
			<?php// echo '<pre>';print_r($idsReport); ?>
            <td><input class="dp form-control text-center datefrom" name="date_from" id="date_from" value="<?php if(isset($idsReport)){ echo date('d-m-Y',strtotime($idsReport->date_from)); }else{ } ?>"  placeholder="From" type="date"></td>
            <td><label>Date To</label></td>
            <td><input class="dp form-control text-center dateto" name="date_to" id="date_to" value="<?php if(isset($idsReport)){ echo date('d-m-Y',strtotime($idsReport->date_to)); }else { } ?>" placeholder="To" type="date"></td>
          </tr>
		    <tr>
            <td><label>Catchment Population</label></td>
            <td>
              <input value="<?php if(isset($idsReport)){ echo $idsReport->flcf_pop; }else { if(validation_errors() != false ) { echo set_value('flcf_pop');} else { } } ?>" class="form-control text-center" name="flcf_pop" id="flcf_pop"   type="text">
            </td>
			<td></td>
            <td></td>
           <td></td>
            <td>
             </td>
            </td>
          </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th style="padding-top: 10px; padding-bottom: 10px;">Diseases Under Surveillance</th>
              <th>Cases</th>
              <th>Deaths</th>
            </tr>
          </thead>
          <tbody>
				<?php foreach($resultsec as $val){
						$k=$val['id'];
						$query_sec="select * from ids_diseases where sec_id='$k'";
						$result=$this->db->query($query_sec);
						$sec=$result->result_array();  ?>
								<tr>
								<td colspan="3" style="background: rgba(120, 120, 120, 0.16) none repeat scroll 0% 0%;color: black;"><label><?php echo $val['respiratory_diseases'] ;?></label>
							</td>
							</tr>
					<?php foreach($sec as $row){ 
						$val1= $row['disease_short_name']."_cases";
						$val2= $row['disease_short_name']."_deaths";
					?>
							<tr>
							  <td><label><?php echo $row['disease_name'];?></label></td>
							  <td><input class="cases form-control" name="<?php echo $row['disease_short_name']; ?>_cases" id="<?php echo $row['disease_short_name']; ?>_cases" value="<?php if(isset($idsReport)){ echo $idsReport->$val1; }else { if(validation_errors() != false ) { echo set_value('disease_short_name');} else { } } ?>" type="text"></td>
							  <td><input class="form-control" name="<?php echo $row['disease_short_name']; ?>_deaths" id="<?php echo $row['disease_short_name']; ?>_deaths" value="<?php if(isset($idsReport)){ echo $idsReport->$val2; }else { if(validation_errors() != false ) { echo set_value('disease_short_name');} else { } } ?>" type="text"></td>
							</tr>
					<?php 	}
						} ?>
				<tr>
				<td><label>Others</label></td>
				<td><input class="form-control" name="other" id="other" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->other; }else { } ?>" readonly></td>
				<td><input class="abc form-control" type="text" disabled></td>
				</tr>	
		  </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="10" style="padding-top:10px;padding-bottom:10px;">Total Consultations from OPD Register (Sex and Age Category)</th>
            </tr>
            <tr>
              <th colspan="5">MALE</th>
              <th colspan="5">FEMALE</th>
            </tr>
            <tr>
              <th>< 1 year</th>
              <th>1-4</th>
              <th>5-14</th>
              <th>15-49</th>
              <th>50+</th>
              <th>< 1 year</th>
              <th>1-4</th>
              <th>5-14</th>
              <th>15-49</th>
              <th>50+</th>
            </tr>
          </thead>
          <tbody>
            <tr id="myTable">
              <td class="t-row1"><input class="abc form-control" name="tm_less_one" id="tm_less_one" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tm_less_one; }else { } ?>"></td>
              <td class="t-row2"><input class="abc form-control" name="tm_oneto_four" id="tm_oneto_four" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tm_oneto_four; }else { } ?>"></td>
              <td class="t-row3"><input class="abc form-control" name="tm_five_fourteen" id="tm_five_fourteen" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tm_five_fourteen; }else { } ?>"></td>
              <td class="t-row4"><input class="abc form-control" name="tm_fifteen_fourtynine" id="tm_fifteen_fourtynine" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tm_fifteen_fourtynine; }else { } ?>"></td>
              <td class="t-row5"><input class="abc form-control" name="tm_fifty_plus" id="tm_fifty_plus" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tm_fifty_plus; }else { } ?>"></td>
              <td class="t-row6"><input class="abc form-control" name="tf_less_one" id="tf_less_one" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tf_less_one; }else { } ?>"></td>
              <td class="t-row7"><input class="abc form-control" name="tf_oneto_four" id="tf_oneto_four" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tf_oneto_four; }else { } ?>"></td>
              <td class="t-row8"><input class="abc form-control" name="tf_five_fourteen" id="tf_five_fourteen" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tf_five_fourteen; }else { } ?>"></td>
              <td class="t-row9"><input class="abc form-control" name="tf_fifteen_fourtynine" id="tf_fifteen_fourtynine" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tf_fifteen_fourtynine; }else { } ?>"></td>
              <td class="t-row10"><input class="abc form-control"  name="tf_fifty_plus" id="tf_fifty_plus" type="text" value="<?php if(isset($idsReport)){ echo $idsReport->tf_fifty_plus; }else { } ?>"></td>
            </tr>
            <tr>
              <td colspan="6" style="text-align:right;"><label>Total OPD Attendance</label>
              </td>
              <td colspan="6"><input class="form-control" name="tot_opd_attendance" id="tot_opd_attendance" type="text" readonly="readonly" value="<?php if(isset($idsReport)){ echo $idsReport->tot_opd_attendance; }else { } ?>">
				<input type="hidden" id="tot_cases" value="" />
			  </td>
            </tr>
          </tbody>
        </table>
        <div class="row">
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c;" type="submit" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
				<button style="background:#008d4c;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
              <button style="background: #008d4c;" class="btn btn-primary btn-md">
                <i class="fa fa-repeat"></i> Reset Form </button>
              <a href="<?php echo base_url(); ?>Data_entry/weekly_vpd_list" style="background: #008d4c" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>      
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
 </div>
</div><!--end of container-->
   
<script>		
		$("#urti_deaths").blur(function(e){
	      comparelessequal("urti_cases", "urti_deaths", "Acute (upper) respiratory infections Cases should be greater than Acute (upper) respiratory infections Deaths");
	    });
		$("#pneu_less_five_deaths").blur(function(e){
	      comparelessequal("pneu_less_five_cases", "pneu_less_five_deaths", "Pneumonia < 5 years Cases should be greater than Pneumonia < 5 years Deaths");
	    });
		$("#pneu_great_five_deaths").blur(function(e){
	      comparelessequal("pneu_great_five_cases", "pneu_great_five_deaths", "Pneumonia > 5 years Cases should be greater than Pneumonia > 5 years Deaths");
	    });
		$("#sari_deaths").blur(function(e){
	      comparelessequal("sari_cases", "sari_deaths", "Severe Acute Respiratory Infection (Susp. H1N1, H5N1, H7N9,MERS-CoV) Cases should be greater than Severe Acute Respiratory Infection (Susp. H1N1, H5N1, H7N9,MERS-CoV) Deaths");
	    });
		$("#awd_less_five_deaths").blur(function(e){
	      comparelessequal("awd_less_five_cases", "awd_less_five_deaths", "Acute Watery Diarrhea/ Suspected Cholera > 5 year Cases should be greater than Acute Watery Diarrhea/ Suspected Cholera > 5 year Deaths");
	    });
		$("#awd_great_five_deaths").blur(function(e){
	      comparelessequal("awd_great_five_cases", "awd_great_five_deaths", "Acute Watery Diarrhea/ Suspected Cholera > 5 year Cases should be greater than Acute Watery Diarrhea/ Suspected Cholera > 5 year Deaths");
	    });
		$("#bd_deaths").blur(function(e){
	      comparelessequal("bd_cases", "bd_deaths", "Bloody Diarrhea Cases should be greater than Bloody Diarrhea Deaths");
	    });
		$("#ad_deaths").blur(function(e){
	      comparelessequal("ad_cases", "ad_deaths", "Acute Diarrhea (Other than Cholera) Cases should be greater than Acute Diarrhea (Other than Cholera) Deaths");
	    });
		$("#tf_deaths").blur(function(e){
	      comparelessequal("tf_cases", "tf_deaths", "Suspected Enteric/Typhoid Fever Cases should be greater than Suspected Enteric/Typhoid Fever Deaths");
	    });
		$("#avh_deaths").blur(function(e){
	      comparelessequal("avh_cases", "avh_deaths", "Suspected Acute Viral Hepatitis (Hep. A & E) Cases should be greater than Suspected Acute Viral Hepatitis (Hep. A & E) Deaths");
	    });
		$("#dhf_deaths").blur(function(e){
	      comparelessequal("dhf_cases", "dhf_deaths", "Suspected Dengue Hemorrhagic Fever Cases should be greater than Suspected Dengue Hemorrhagic Fever Deaths");
	    });
		$("#df_deaths").blur(function(e){
	      comparelessequal("df_cases", "df_deaths", "Suspected Dengue Fever Cases should be greater than Suspected Dengue Fever Deaths");
	    });
		$("#cchf_deaths").blur(function(e){
	      comparelessequal("cchf_cases", "cchf_deaths", "Suspected Crimean Congo Hemorrhagic Fever Cases should be greater than Suspected Crimean Congo Hemorrhagic Fever Deaths");
	    });
		$("#cl_deaths").blur(function(e){
	      comparelessequal("cl_cases", "cl_deaths", "Cutaneous Leishmaniasis Cases should be greater than Cutaneous Leishmaniasis Deaths");
	    });
		$("#vl_deaths").blur(function(e){
	      comparelessequal("vl_cases", "vl_deaths", "Visceral Leishmaniasis Cases should be greater than Visceral Leishmaniasis Deaths");
	    });
		$("#mal_deaths").blur(function(e){
	      comparelessequal("mal_cases", "mal_deaths", "Suspected Malaria Cases should be greater than Suspected Malaria Deaths");
	    });
		$("#nnt_deaths").blur(function(e){
	      comparelessequal("nnt_cases", "nnt_deaths", "Neonatal Tetanus Cases should be greater than Neonatal Tetanus Deaths");
	    });
		$("#afp_deaths").blur(function(e){
	      comparelessequal("afp_cases", "afp_deaths", "Acute Flaccid Paralysis Cases should be greater than Acute Flaccid Paralysis Deaths");
	    });
		$("#chtb_deaths").blur(function(e){
	      comparelessequal("chtb_cases", "chtb_deaths", "Childhood Tuberculosis Cases should be greater than Childhood Tuberculosis Deaths");
	    });
		$("#pert_deaths").blur(function(e){
	      comparelessequal("pert_cases", "pert_deaths", "Suspected Pertussis Cases should be greater than Suspected Pertussis Deaths");
	    });
		$("#diph_deaths").blur(function(e){
	      comparelessequal("diph_cases", "diph_deaths", "Suspected Diphtheria Cases should be greater than Suspected Diphtheria Deaths");
	    });
		$("#msl_deaths").blur(function(e){
	      comparelessequal("msl_cases", "msl_deaths", "Suspected Measles Cases should be greater than Suspected Measles Deaths");
	    });
		$("#puo_deaths").blur(function(e){
	      comparelessequal("puo_cases", "puo_deaths", "Pyrexia Of Unknown Origin Cases should be greater than Pyrexia Of Unknown Origin Deaths");
	    });
		$("#psy_deaths").blur(function(e){
	      comparelessequal("psy_cases", "psy_deaths", "Chronic Viral Hepatitis (B &C) Cases should be greater than Chronic Viral Hepatitis (B &C) Deaths");
	    });
		$("#undis_deaths").blur(function(e){
	      comparelessequal("undis_cases", "undis_deaths", "Other unusual diseases (Specify) Cases should be greater than Other unusual diseases (Specify) Deaths");
	    });
		$("#meng_deaths").blur(function(e){
	      comparelessequal("meng_cases", "meng_deaths", "Suspected Meningitis Cases should be greater than Suspected Meningitis Deaths");
	    });
	function comparelessequal(f1, f2, mesg){
		if($("#"+f1).val() == ""){
			$("#"+f1).val("");
			$("#"+f2).val("");
			$("#"+f2).css("background-color","#FFF");
			$("#"+f2).css("color","#000");
		}else{
			if(parseInt($("#"+f1).val()) < parseInt($("#"+f2).val())){
				alert(mesg);
				$("#"+f2).css("background-color","#F54F4F");
				$("#"+f2).css("color","#FFF");
			}else{
				$("#"+f2).css("background-color","#FFF");
				$("#"+f2).css("color","#000");
			} // end if/else
		}
	}	// end function compareequal
	$(document).ready(function(){
	<?php if(!isset($idsReport)){ ?>
		var year = $("#year").val();
			$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
					data:'year='+year,
					success: function(response){
						$('#epi_week').html(response);
							document.getElementById("year").style.borderColor = "";
							$('#epi_week').trigger("change");
					}
				});
	<?php } ?>
		//sum multiple values function start
		var $form = $('#whereEntry'),
		$summands = $form.find('.abc'),
		$sumDisplay = $('#other');
		$sumOPDattendance = $('#tot_opd_attendance');
		$form.delegate('.abc', 'keyup', function ()
		{
		var sumOPD = 0;
		$summands.each(function ()
		{
			var value = Number($(this).val());
			if (!isNaN(value)) sumOPD += value;
		});
			$sumOPDattendance.val(sumOPD);
		var tot = sumOPD - $('#tot_cases').val();
		if(isNaN(tot) || tot < 0 ){
			$sumDisplay.val(0);
		}else{
			$sumDisplay.val(tot);
		}
		});
		var $formA = $('#whereEntry'),
		$summandsA = $form.find('.cases'),
		$sumDisplayA = $('#tot_cases');
		$formA.delegate('.cases', 'change', function ()
		{
		var sumOPDA = 0;
		$summandsA.each(function ()
		{
			var value = Number($(this).val());
			if (!isNaN(value)) sumOPDA += value;
		});
		$sumDisplayA.val(sumOPDA);
		});
});
	/* $(document).on('change','#year',function(){
		var year = $('#year').val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response){
				$('#epi_week').html(response);
				var week = $('#epi_week').val();
				alert(week);
				var year = $('#year').val();
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getEpiWeeksDates',
					data:'epiweek='+week+'&year='+year,
					success: function(response){
						var obj = JSON.parse(response);
						$('#date_from').val(obj.startDate);
						$('#date_to').val(obj.EndDate);
					}
				});
			}
		});
	}); */
	$(document).on('change','#year',function(){
			var year = $("#year").val();
			var week = $("#epi_week").val();
			if(year == ""){
				$("#epi_week").html("");
				$('#date_from').val("");
				$('#date_to').val("");
			}else{
				$.ajax({
					type: 'POST',
					url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks',
					data:'year='+year,
					success: function(response){
						if(response == 1){
							var curr_year = new Date().getFullYear(); //Exchange year with current year.
							document.getElementById("year").style.borderColor = "red";
							alert("Year is restricted to current and previouse!");
							$.ajax({
								type: 'POST',
								url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeks', 
								data:'year='+curr_year,
								success: function(response){
									$('#epi_week').html(response);
									$('#year').val(curr_year);
									document.getElementById("year").style.borderColor = "";
										$.ajax({
										type: 'POST',
										url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
										data:'epiweek='+week+'&year='+year,
										success: function(response){
											var obj = JSON.parse(response);
												$('#date_from').val(obj.startDate);
												$('#date_to').val(obj.EndDate);
										}
									});
								}
							});
						}else{
							$('#epi_week').html(response);
							document.getElementById("year").style.borderColor = "";
							week = $('#epi_week').val();
							$.ajax({
										type: 'POST',
										url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
										data:'epiweek='+week+'&year='+year,
										success: function(response){
											var obj = JSON.parse(response);
												$('#date_from').val(obj.startDate);
												$('#date_to').val(obj.EndDate);
										}
									});
						}
					}
				});
			}
		});
	
	$(document).on('change','#epi_week',function(){
		var week = $("#epi_week").val();
		var year = $('#year').val();
		if(week == 0 && year !=""){
			$('#date_from').val("");
			$('#date_to').val("");
		}else{
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getcase_investWeeksDates', 
				data:'epiweek='+week+'&year='+year,
				success: function(response){
					var obj = JSON.parse(response);
						$('#date_from').val(obj.startDate);
						$('#date_to').val(obj.EndDate);
				}
			});
		}
	});
	$(document).on('change','.datefrom',function(){
		var week = $("#epi_week").val();
		var date_from = $('.datefrom').val();
		var year = date_from.split("-");
		// if years options are empty
		var yearCheck = $("#year").val();
		if(yearCheck == ""){
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getYears', 
				data:'year='+year[2],
				success: function(response){
					$('#year').html(response);
				}
			});
		}
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
			data:'date_from='+date_from+'&year='+year[2],
			success: function(response){
				$('#epi_week').html(response);
				$('#epi_week').trigger("change");
			}
		});
	});
	$(document).on('change','.dateto',function(){
		var week = $("#epi_week").val();
		var date_to = $('.dateto').val();
		var year = date_to.split("-");
		// if years options are empty
		var yearCheck = $("#year").val();
		if(yearCheck == ""){
			$.ajax({
				type: 'POST',
				url:'<?php echo base_url(); ?>Ajax_calls/getYears', 
				data:'year='+year[2],
				success: function(response){
					$('#year').html(response);
				}
			});
		}
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/get_idsWeeks', 
			data:'date_to='+date_to+'&year='+year[2],
			success: function(response){
				$('#epi_week').html(response);
				$('#epi_week').trigger("change");
			}
		});
	});
</script>