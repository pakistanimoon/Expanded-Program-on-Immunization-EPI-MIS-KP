<!-- <tr>
					<td><label>Districts:</label></td>
					<td >
						<select colspan="2" name="districts" required class="form-control testpossibleno other" id="districts">
								<option value="">--Select--</option>
								<?php foreach($districts as $dist) {?>
								<option value="<?php echo $dist['distcode'];?>"><?php echo $dist['district'];?>		
								</option>										
								<?php }?>
						</select>									
					</td>									
				</tr> -->
				<section id="section-search">
		<div class="container">
			<div class="row">
				<form action="<?php echo base_url(); ?>Measles_Case/add_data" method="post">
									
					<div class="form-group">
						<div class="col-md-1" style="text-align:right;">
							<label style="margin-top:6px;">District:</label>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2">
							
					<select class="form-control" name="distcode" >
						<option value="">--Select--</option>
								<?php foreach($districts as $dist) {?>
								<option <?php if(isset($selected_distcode) && $selected_distcode == $dist['distcode'] ){ echo 'selected="selected"';}?>  value="<?php echo $dist['distcode'];?>"><?php echo $dist['district'];?> </option>		
																		
								<?php }?>
						</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2" style="text-align:right;">
							<label style="margin-top:6px;">Case Type:</label>
						</div>

					</div>
					<div class="form-group">
						<div class="col-md-2">
							<select class="form-control" name="case"  >
								<option value="">--Select--</option>
								<?php foreach ($surveillance_cases_types as $case){?>
								<option <?php if(isset($selected_case) && $selected_case == $case['short_name'] ){ echo 'selected="selected"';}?> value="<?php echo $case['short_name'];?>"> <?php echo $case['type_case_name'];?>									
								</option>
									<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-1" style="text-align:right;">
							<label style="margin-top:6px;">Year:</label>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2">					
                      <select class="form-control" name="year">								
								<?php foreach ($year as $yer){?>
								<option <?php if(isset($selected_year) && $selected_year == $yer['year'] ){ echo 'selected="selected"';}?> value="<?php echo $yer['year'];?>"> <?php echo $yer['year'];?>								
								</option>
									<?php }?>
							</select>
						</div>
					</div>

					<div class="col-md-1">
							<button type="submit" class="btn btn-primary"> Search</button>
						</div>

				</form>
				
			</div>
			
		</div>
	</section>
<section id="form-section">
	<?php foreach ($lab_report as $value) {
		# code...
		//$value['id'];
		//$value['report_submit_status'];
		//if ($value['report_submit_status']==1) { ?>
			<!--<div class="container" hidden="hidden">-->
		<?php //} else { ?>
		<div class="container">
			<?php // } ?>	 
				
			<div class="row background-row">
				<div class="col-md-12">
					<h4 style="color:white;text-align: center;text-transform: uppercase;margin-top: 11px;">For use by receiving laboratory</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding:0px;">
					<table class="table table-bordered patient-info">
						<thead>
							<tr>
								<th><label><span class="font-weight-bold">EPID</span> Number : </label></th>
								<td><span id="case_epi_no"><?php echo $value['case_epi_no'];?></span></td>
								<th><label>Patient's Name</label></th>
								<td><span id="patient_name"><?php echo $value['patient_name'];?></span></td>
								<th><label>Father's Name</label></th>
								<td><span id="patient_fathername"><?php echo $value['patient_fathername'];?></span></td>
								<th><label>Case Type</label></th>
								<td><span id="case_type"><?php echo get_CaseType_Name($value['case_type'])?></span></td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<form class="form-horizontal" action="<?php echo base_url(); ?>Measles_Case/dataentry_save" method="post">
				<div class="row">
					<div class="col-md-12" style="padding:0px;margin-top:-20px;">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<span hidden="hidden"><input name="id" value="<?php echo $value['id'];?>"></span>
									<td><label>Date specimens received at lab &nbsp;<span class="red-color">*</span></label></td>
									<td colspan="6"><input data-provide="datepicker" name="specimen_received_date" class="form-control dp" placeholder="YYYY-DD-MM" required></td>
								</tr>
								<tr>
									<td id="hi"><label>Condition of specimen:</label></td>
									<td id="vi" class="hide" rowspan="2"><label>Condition of specimen:</label></td>
									<!-- <td><select class="form-control" name="specimen_condition"><option>Option1</option><option>Option1</option><option>Option1</option></select></td> -->
									<td><label>Quantity adequate:</label></td>
									<td>
										<div class="row">
											<div class="col-md-12">
											<div class="btn-group" data-toggle="buttons">
												<input type="hidden" id="quantity_adequate" name="quantity_adequate" value="">
												<label class="btn btn-primary active qtyadequate" data-qtyadequate="1">Yes</label>
												<label class="btn btn-primary qtyadequate" data-qtyadequate="2">No</label>
											</div>
											</div>
										</div>
									</td>
									<td><label>Cold chain OK:</label></td>
									<td>
										<div class="row">
											<div class="col-md-12">
												<div class="btn-group" data-toggle="buttons">
													<label class="btn btn-primary active">
														<input type="radio" name="cold_chain_ok" checked="checked" value="1" required> Yes
													</label>
													<label class="btn btn-primary">
														<input type="radio" name="cold_chain_ok" value="2"> No
													</label>
												</div>
											</div>
										</div>
									</td>

								</tr>
								<tr id="show" hidden="">
									
									<td><label>Leakage/Broken Container:</label></td>
								
									<td>
										<div class="row">
											<div class="col-md-12">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-primary active">
													<input type="radio" name="leakage_broken" checked="checked" value="1" required> Yes
												</label>
												<label class="btn btn-primary">
													<input type="radio" name="leakage_broken" value="2"> No
												</label>
											</div>
											</div>
										</div>
									</td>
									<td><label>Test Possible:</label></td>
									<td>
										<div class="row">
											<div class="col-md-12">
											<div class="btn-group" data-toggle="buttons">
												<input type="hidden" id="test_possible" name="test_possible" value="">
												<label class="btn btn-primary testpossible active" data-test-possible="1">Yes</label>
												<label class="btn btn-primary testpossible" data-test-possible="2">No</label>
											</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Specimen Received by </label></td>
								</tr>
								<!-- <div id="b" class="hide"> </div> -->
								<div  class="row ajax">
								<tr id="a">
									<td><label>Name&nbsp;<span class="red-color">*</span></label></td>
									<td><input type="text" class="form-control testpossibleno" name="specimen_received_by" placeholder="Name" required maxlength="30"></td>
									<td><label>Designation&nbsp;<span class="red-color">*</span></label></td>
									<td colspan="3"><input type="text" name=" received_by_designation" class="form-control testpossibleno" placeholder="Designation" required maxlength="20"></td>
								</tr>								
								<tr id="c">
									<td><label>Lab ID Number &nbsp;<span class="red-color">*</span></label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Lab ID Number" name="lab_id_number" required maxlength="20"></td>
									<td><label>Date of lab  test done &nbsp;<span class="red-color">*</span> </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp testpossibleno" name="lab_testdone_date" placeholder="YYYY-DD-MM" required></td>
								</tr>
								<tr id="d">
									<td><label>Type of Specimen &nbsp;<span class="red-color">*</span></label></td>
									<td ><!-- <input type="text" class="form-control" placeholder="Type of Test done" name="type_of_test" required maxlength="30"> -->
									<select colspan="3" name="type_of_test" required class="form-control testpossibleno other" id="other">
										<option value="">--Select--</option>
										<option value="Blood">Blood</option>
										<option value="Serum">Serum</option>
										<option value="Urine">Urine</option>
										<option value="Oral Fluid">Oral Fluid</option>
										<option value="Other">Other</option>
									</select>
									</td>
									<td><label>Other Specimen : </label></td>
									<td colspan="3" >
										<input type="text" id="otr-spe" class="form-control testpossibleno otr-spe" placeholder="Other Specimen" name="other_specimen_lab" readonly="" maxlength="30"> 
									</td>
								</tr>
								<tr id="e">
									<td><label>Test result &nbsp;<span class="red-color">*</span> </label></td>
									<td ><!-- <input type="text" class="form-control" placeholder="Test result" name="specimen_result" required maxlength="20"> -->

										<select colspan="3" name="specimen_result" required class="form-control te-reslt testpossibleno te-reslt" id="te-reslt">
											<option value="">--Select--</option>
											<?php
											if ($value['case_type']=='Msl') { ?>
												<option value="Positive Measles">Positive Measles</option>
												<option value="Negative Measles">Negative Measles</option>
												<option value="Positive Rubella">Positive Rubella</option>
												<option value="Negative Rubella">Negative Rubella</option>
												<option value="Other">Other</option>
											<?php }else { ?>											
											<option value="Positive">Positive</option>
											<option value="Negative">Negative</option>
											<option value="Other">Other</option>
											<?php } ?>
										</select>
									</td>
									<td><label>Other Result: </label></td>
									<td colspan="3"><input id="oth-test" type="text" class="form-control testpossibleno oth-test" placeholder="Test result" name="other_specimen_result" readonly=""  maxlength="20">
									</td>
								</tr>
								<tr id="f">
									<td><label>Comment : </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Comment" name="comments"  maxlength="100"></td>
									<td><label>Date of lab report sent &nbsp;<span class="red-color">*</span> </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp testpossibleno" name="lab_report_sent_date" placeholder="YYYY-DD-MM" required></td>
								</tr>
								<tr id="g">
									<td colspan="7" class="td-secondary-heading"><label>Result Submitted by </label></td>
								</tr>
								<tr id="h">
									<td><label>Name &nbsp;<span class="red-color">*</span> </label></td>
									<td><input type="text" class="form-control" placeholder="Name" name="report_sent_by" required maxlength="30"></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><input type="text" name=" sent_by_designation" class="form-control" placeholder="Designation"  maxlength="20"></td>
								</tr>
								<tr >					
									<td colspan="7" style="padding:10px;text-align:right;">
									<button class="form-button"><i class="fa fa-save "></i>&nbsp;Submit</button>		
										<button class="form-button" type="Reset"><i class="fa fa-save"></i>&nbsp;Reset</button>
										<!-- <a href="<?php echo base_url(); ?>Measles_Case/search_by_epid"><i class="fa fa-times"></i> Cancel</a> -->										
										
									</td>
								</tr>
								<tr>
									<td colspan="7" style="background-color: #3c8dbc;"><label></label></td>
								</tr>
							</div>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		<?php } ?>
	</section>
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.min.js"></script>
<script type="text/javascript">	
	$(document).ready(function(){ 
	$(".other").change(function () {
  var x = $(this).val();
 // alert(x);
  if (x == 'Other') 
  {
  	//alert("Xxxx");
  	$(this).closest('tbody').find(".otr-spe").prop('readonly', false);
  }
  else{
  	$(this).closest('tbody').find(".otr-spe").prop('readonly', true);
  }
});
    $(".te-reslt").change(function () { 
  var x = $(this).val();
  //alert(x);
  if (x == 'Other' ) 
  {
  	//alert("Xxxx");
  	$(this).closest('tbody').find(".oth-test").prop('readonly', false);
  }
  else{
  	$(this).closest('tbody').find(".oth-test").prop('readonly', true);
  }
});     //show
     $(document).on('click','.qtyadequate',function() {
    	if (parseInt($(this).data('qtyadequate')) == 2) {
			$('#quantity_adequate').val(2);
    		$(this).closest('tbody').find('#show').show();
    		$(this).closest('tbody').find('#vi').removeClass('hide');
     		$(this).closest('tbody').find('#hi').addClass('hide');
    	}
    	else{
			$('#quantity_adequate').val(1);
    		$(this).closest('tbody').find('#show').hide();
    		$(this).closest('tbody').find('#hi').removeClass('hide');
     		$(this).closest('tbody').find('#vi').addClass('hide');
			$(this).closest('tbody').find('.testpossibleno').removeAttr('disabled','disabled');
			//$('.testpossibleno').val('');
    	}
    	
   });
     $(document).on('click','.testpossible',function() {
    	if (parseInt($(this).data('test-possible'))==2) {
			$('#test_possible').val(2);
    		$(this).closest('tbody').find('.testpossibleno').attr('disabled','disabled');
    		$('.testpossibleno').val('');
    	}
    	else{
			$('#test_possible').val(1);
    		$(this).closest('tbody').find('.testpossibleno').removeAttr('disabled','disabled');
    	}
    	
   });
    $('#district').change(function () {
     var distcode=$(this).val();
     alert(distcode);    
    $.ajax({
			type: "GET",
			data: "distcode="+distcode,
			url: "<?php echo base_url(); ?>Ajax_calls/getMeasles_Case",
			success: function(result){
				//console.log(result);
				$('#case_epi_no').html(result); 
				$('#patient_name').html(result);
				$('#patient_fathername').html(result);
				$('#case_type').html(result);
				           
			}
	});
});
	});
</script>
