	<?php
    if ($this->session->flashdata('message')) {
    ?>
    
    <?php
    }
?>
	<section id="section-search">
		<div class="container">
			<div class="row" style="font-size:13px;padding:0px; ">
				<div class="col-md-12" style="padding:0px;">
				<form action="<?php echo base_url(); ?>Measles_Case/search_epid_nb" method="post">
					<div class="form-group" >
						<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
									
					</div>
					<table class="table table-bordered epid-search-table">
						<thead>
							<tr><th style="color:white;text-align: center;text-transform: uppercase;margin-top: 11px;" colspan="11">Search a case by EPID number</th></tr>
						</thead>
						
					
						<tbody>
							<tr>
								<td>
									<div class="form-group">
										<label>Search&nbsp;by&nbsp;EPID: </label>
									</div>
								</td>
								<td  style="width:8%;">
									<div class="form-group" >
										<input type="text" required name="epid" class="form-control" value="PAK/KP" readonly="">
									</div>
								</td>	
								<td>
									<div class="form-group">
										<label>District:</label>
									</div>
								</td>
								<td style="width:15%">
									<div class="form-group">
										<select class="form-control" name="district" required style="padding:0px;">
											<option value="">--Select--</option>
											<?php foreach ($districts as $dis){?>
											<option style="padding:0px;"  value="<?php echo $dis['epid_code'];?>"> <?php echo $dis['district'];?></option>
											<?php }?>
										</select>
									</div>
								</td>
								<td>
									<div class="form-group">
										<label>Year:</label>
									</div>
								</td>
								<td style="width:6%;">
									<div class="form-group">
										<input type="text" required name="year" readonly="" class="form-control" value="<?php echo date('Y'); ?>" >
									</div>
								</td>
								<td>
									<div class="form-group">
										<label>Case&nbsp;Type:</label>
									</div>
								</td>
								<td>
									<div class="form-group">
										<select class="form-control" name="case" required style="padding:0px;">
											<option value="" style="padding:0px;">--Select--</option>
												<?php foreach ($surveillance_cases_types as $case){?>
											<option value="<?php echo $case['short_name'];?>"> <?php echo $case['type_case_name'];?>									
											</option>
											<?php }?>
										</select>
									</div>
								</td>
								<td>
									<div class="form-group">
										<label>Case&nbsp;Number:</label>
									</div>
								</td>
								<td style="width:6%;">
									<div class="form-group">
										<input type="text" name="measlenumber" placeholder="----" class="form-control numberclass" maxlength="4" minlength="4" required>
									</div>
								</td>
								<td>
									<button type="submit" class="btn btn-primary"> Search</button>
								</td>
							</tr>

						</tbody>
					</table>
				</form>
				</div>
				

				 

				
			</div>
			
		</div>
	</section>
	<?php	
	 if(!empty($case_epi_no[0]['case_epi_no']) && $case_epi_no[0]['report_submit_status']==0) {?>
	<section id="form-section">
	<?php  } else{ ?>
	<section id="form-section" hidden>
	<?php } ?>			
		<div class="container">
			<div class="row background-row">
				<div class="col-md-6 offset-md-3">
					<h4 style="color:white;margin:3px;">For use by receiving laboratory</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding:0px;">
					<table class="table table-bordered patient-info">
						<thead>
							<tr>
								<th><label><span class="font-weight-bold">EPID</span> Number : </label></th>
								<th><label> <?php echo $case_epi_no[0]['case_epi_no'];?> </label></th>
								<th><label>Patient's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_name'];?> </label></th>
								<th><label>Father's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_fathername'];?> </label></th>
								<th><label>Case Type</label></th>
								<th><label><?php echo get_CaseType_Name($case_epi_no[0]['case_type'])?></label></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<form class="form-horizontal" action="<?php echo base_url(); ?>Measles_Case/epid_data_save" method="post">
				<div class="row">
					<div class="col-md-12" style="padding:0px;margin-top:-20px;">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<span hidden="hidden"><input type="" name="case_epi_no" value="<?php echo $case_epi_no[0]['case_epi_no'];?>"></span>
									<td><label>Date specimens received at lab&nbsp;<span class="red-color">*</span></label></td>
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
								<tr>
									<td><label>Name &nbsp;<span class="red-color">*</span> </label></td>
									<td><input type="text" class="form-control testpossibleno" name="specimen_received_by" placeholder="Name" required maxlength="30"></td>
									<td><label>Designation &nbsp;<span class="red-color">*</span> </label></td>
									<td colspan="3"><input type="text" name=" received_by_designation" class="form-control testpossibleno" placeholder="Designation" required maxlength="20"></td>
								</tr>
								<tr>
									<td><label>Lab ID Number &nbsp;<span class="red-color">*</span> </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Lab ID Number" name="  lab_id_number" required maxlength="25"></td>
									<td><label>Date of lab  test done &nbsp;<span class="red-color">*</span> </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp testpossibleno" name="lab_testdone_date" placeholder="YYYY-DD-MM" required></td>
								</tr>
								<tr id="d">
									<td><label>Type of Specimen &nbsp;<span class="red-color">*</span> </label></td>
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
											if ($case_epi_no[0]['case_type']=='Msl') { ?>
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
								
								<tr>
									<td><label>Comment : </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Comment" name="comments" required maxlength="100"></td>
									<td><label>Date of lab report sent &nbsp;<span class="red-color">*</span> </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp  testpossibleno" name="lab_report_sent_date" placeholder="YYYY-DD-MM" required></td>
								</tr>
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Result Submitted by </label></td>
								</tr>
								<tr>
									<td><label>Name &nbsp;<span class="red-color">*</span> </label></td>
									<td><input type="text" class="form-control" placeholder="Name" name="report_sent_by" required maxlength="30"></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><input type="text" name=" sent_by_designation" class="form-control" placeholder="Designation" required maxlength="20"></td>
								</tr>
								<!-- <tr>
									<td><label>Signature : </label></td>
									<td><input type="text" class="form-control" placeholder="__________________________"></td>
									<td><label>Date : </label></td>
									<td colspan="3"><input type="date" class="form-control" name="result_saved_date	"></td>
								</tr> -->
								<tr>
									<td colspan="7" style="padding:10px;text-align:right;">
										<!-- <a href="#"><i class="fa fa-times"></i> Cancel</a>
										<a href="#"><i class="fa fa-recycle"></i> Reset</a> -->
										<!-- <a href=""><i class="fa fa-save"></i> Submit</a> -->
										<button class="form-button" type="Cancel"><i class="fa fa-times"></i> | Cancel</button>
										<button class="form-button" type="Reset"><i class="fa fa-recycle"></i> | Reset</button>
										<button class="form-button"><i class="fa fa-save"></i> | Submit</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		
	</section>
	<div id="view">
	<?php 
	
	 if(!empty($case_epi_no[0]['case_epi_no']) && $case_epi_no[0]['report_submit_status']==1) {?>
	<section id="form-section">

	<?php  } else{ ?>
	<section id="form-section" hidden>
	<?php } ?>
			
		<div class="container">
			<div class="row background-row">
				<div class="col-md-6 offset-md-3">
					<h4 style="color:white;margin:3px;">For use by receiving laboratory</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding:0px;">
					<table class="table table-bordered patient-info">
						<thead>
							<tr>
								<th><label><span class="font-weight-bold">EPID</span> Number : </label></th>
								<th><label> <?php echo $case_epi_no[0]['case_epi_no'];?> </label></th>
								<th><label>Patient's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_name'];?> </label></th>
								<th><label>Father's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_fathername'];?> </label></th>
								<th><label>Case Type</label></th>
								<th><label><?php echo get_CaseType_Name($case_epi_no[0]['case_type'])?></label></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<form class="form-horizontal" action="<?php echo base_url(); ?>Measles_Case/epid_data_save" method="post">
				<div class="row">
					<div class="col-md-12" style="padding:0px;margin-top:-20px;">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<span hidden="hidden"><input type="" name="case_epi_no" value="<?php echo $case_epi_no[0]['case_epi_no'];?>"></span>
									<td><label>Date specimens received at lab:</label></td>
									<td colspan="6"><?php echo $case_epi_no[0]['specimen_received_date'];?></td>
								</tr>
								<tr>
									<td><label>Condition of specimen:</label></td>
									<!-- <td><select class="form-control" name="specimen_condition"><option>Option1</option><option>Option1</option><option>Option1</option></select></td> -->
									<td><label>Quantity adequate:</label></td>
									<td>
										<div class="row">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-primary active">
													
													<?php 
													if ($case_epi_no[0]['quantity_adequate']==1) {
													?>
														<!-- <input type="radio" class="radio" name="quantity_adequate" checked="checked" value="1" required > Yes -->
														<input type="radio" name="quantity_adequate" checked="checked" value="1" required> Yes				
												
													<?php } elseif ($case_epi_no[0]['quantity_adequate']==2) { ?>
														<input type="radio" class="radio" name="quantity_adequate" value="2" checked="checked"> No
														
													<?php }?>	
												
												<!-- <label class="btn btn-primary  ">
													<input type="radio" class="radio"  name="quantity_adequate" value="2"> No
												</label> --> 
											</div>
										</div>
									</td>
									<td><label>Cold chain OK:</label></td>
									<td>
										<div class="row">
											<div class="col-md-12">
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-primary active">
													<?php 
													if ($case_epi_no[0]['cold_chain_ok']==1) {
													?>
													<input type="radio" name="cold_chain_ok" checked="checked" value="1" required> Yes			
													
													<?php }
													elseif ($case_epi_no[0]['cold_chain_ok']==2) {
													?>
														<input type="radio" class="radio" name="cold_chain_ok" checked="checked" value="2" required > No 
														<?php } ?>
														</label>	
											</div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Specimen Received by </label></td>
								</tr>
								<tr>
									<td><label>Name : </label></td>
									<td><?php echo $case_epi_no[0]['specimen_received_by'];?></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['received_by_designation'];?></td>
								</tr>
								<tr>
									<td><label>Lab ID Number : </label></td>
									<td><?php echo $case_epi_no[0]['lab_id_number'];?></td>
									<td><label>Date of lab  test done : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['lab_testdone_date'];?></td>
								</tr>
								<tr>
									<td><label>Type of Test done : </label></td>
									<td><?php echo $case_epi_no[0]['type_of_test'];?></td>
									<td><label>Other Specimen : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['other_specimen_lab'];?></td>
								</tr>
								<!-- <tr>
									<td><label>Type of Test done : </label></td>
									<td><?php echo $case_epi_no[0]['type_of_test'];?></td>
									<td><label>Test result : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['specimen_result'];?></td>
								</tr> -->
								<tr>
									<td><label>Test result:</label></td>
									<td><?php echo $case_epi_no[0]['specimen_result'];?></td>
									<td><label>Other Result:</label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['other_specimen_result'];?></td>
								</tr>
								<tr>
									<td><label>Comment : </label></td>
									<td><?php echo $case_epi_no[0]['comments'];?></td>
									<td><label>Date of lab report sent : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['lab_report_sent_date'];?></td>
								</tr>
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Result Submitted by </label></td>
								</tr>
								<tr>
									<td><label>Name : </label></td>
									<td><?php echo $case_epi_no[0]['report_sent_by'];?></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><?php echo $case_epi_no[0]['sent_by_designation'];?></td>
								</tr>
								<tr>
									<!-- <td><label>Signature : </label></td>
									<td><input type="text" class="form-control" placeholder="__________________________"></td> -->
									<td><label>Date : </label></td>
									<td colspan="6"><?php echo $case_epi_no[0]['result_saved_date'];?></td>
								</tr>
								<!-- <tr>
									<td colspan="7" style="padding:10px;">
										<a href="#"><i class="fa fa-times"></i> Cancel</a>
										<a href="#"><i class="fa fa-recycle"></i> Reset</a>
										<button class="b"><i class="fa fa-save"></i> | Submit</button>
									</td>
								</tr> -->
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		
	</section>
</div>
	<!-- ============================================================= -->
	<!-- =============================================================== -->
	<!-- =============================================================== -->
	<div id="edit" class="hide">
	<?php 
	
	 if(!empty($case_epi_no[0]['case_epi_no']) && $case_epi_no[0]['report_submit_status']==1) {?>
	
	<section id="form-section">
		
	<?php  } else{ ?>
	<section id="form-section" hidden>
	<?php } ?>
			
		<div class="container">
			<div class="row background-row">
				<div class="col-md-6 offset-md-3">
					<h4 style="color:white;margin:3px;">For use by receiving laboratory</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12" style="padding:0px;">
					<table class="table table-bordered patient-info">
						<thead>
							<tr>
								<th><label><span class="font-weight-bold">EPID</span> Number : </label></th>
								<th><label> <?php echo $case_epi_no[0]['case_epi_no'];?> </label></th>
								<th><label>Patient's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_name'];?> </label></th>
								<th><label>Father's Name</label></th>
								<th><label> <?php echo $case_epi_no[0]['patient_fathername'];?> </label></th>
								<th><label>Case Type</label></th>
								<th><label><?php echo get_CaseType_Name($case_epi_no[0]['case_type'])?></label></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<form class="form-horizontal" action="<?php echo base_url(); ?>Measles_Case/epid_data_save" method="post">
				<div class="row">
					<div class="col-md-12" style="padding:0px;margin-top:-20px;">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<span hidden="hidden"><input type="" name="case_epi_no" value="<?php echo $case_epi_no[0]['case_epi_no'];?>"></span>
									<td><label>Date specimens received at lab:</label></td>
									<td colspan="6"><input data-provide="datepicker" name="specimen_received_date" class="form-control dp" placeholder="YYYY-DD-MM" required value="<?php echo $case_epi_no[0]['specimen_received_date'];?>"></td>
								</tr>
								<tr>
									<td><label>Condition of specimen:</label></td>
									
									<!-- <td><select class="form-control" name="specimen_condition"><option>Option1</option><option>Option1</option><option>Option1</option></select></td> -->
									<td><label>Quantity adequate:</label></td>
									<td>
										<div class="row">
											<div class="btn-group">
												<label class="btn btn-primary active">
													
													<input type="radio" class="fancyradio " name="quantity_adequate" checked="checked" value="1"  required="required" /> Yes
												</label>
												<label class="btn btn-primary">
													<input type="radio" class="fancyradio "  name="quantity_adequate" value="2" /> No
												</label>
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
								
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Specimen Received by </label></td>
								</tr>
								<tr>
									<td><label>Name : </label></td>
									<td><input type="text" class="form-control testpossibleno" name="specimen_received_by" placeholder="Name" required maxlength="30" value="<?php echo $case_epi_no[0]['specimen_received_by'];?>"></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><input type="text" name=" received_by_designation" class="form-control testpossibleno" placeholder="Designation" required maxlength="20" value="<?php echo $case_epi_no[0]['received_by_designation'];?>"></td>
								</tr>
								<tr>
									<td><label>Lab ID Number : </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Lab ID Number" name="  lab_id_number" required maxlength="20" value="<?php echo $case_epi_no[0]['lab_id_number'];?>"></td>
									<td><label>Date of lab  test done : </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp testpossibleno" name="lab_testdone_date" placeholder="YYYY-DD-MM" required value="<?php echo $case_epi_no[0]['lab_testdone_date'];?>"></td>
								</tr>
									<tr id="d">
									<td><label>Type of Specimen : </label></td>
									<td ><!-- <input type="text" class="form-control" placeholder="Type of Test done" name="type_of_test" required maxlength="30"> -->
									<select colspan="3" name="type_of_test" required class="form-control testpossibleno other" id="other">
											
											<option <?php echo ($case_epi_no[0]['type_of_test'] == 'Blood')?'selected="selected"':''; ?> value='Blood'>Blood</option>
										<option <?php echo ($case_epi_no[0]['type_of_test'] == 'Serum')?'selected="selected"':''; ?> value='Serum'>Serum</option>
										<option <?php echo ($case_epi_no[0]['type_of_test'] == 'Urine')?'selected="selected"':''; ?> value='Urine'>Urine</option>
										<option <?php echo ($case_epi_no[0]['type_of_test'] == 'Oral Fluid')?'selected="selected"':''; ?> value='Oral Fluid'>Oral Fluid</option>
										<option value="Other">Other</option>
										
										<!-- <option value="">--Select--</option>
										<option value="Blood">Blood</option>
										<option value="Serum">Serum</option>
										<option value="Urine">Urine</option>
										<option value="Oral Fluid">Oral Fluid</option>
										<option value="Other">Other</option> -->
									</select>
									</td>
									<td><label>Other Specimen : </label></td>
									<td colspan="3" >
										<input type="text" id="otr-spe" class="form-control testpossibleno otr-spe" placeholder="Other Specimen" name="other_specimen_lab" readonly="" maxlength="30"> 
									</td>
								</tr>
								<tr id="e">
									<td><label>Test result : </label></td>
									<td ><!-- <input type="text" class="form-control" placeholder="Test result" name="specimen_result" required maxlength="20"> -->

										<select colspan="3" name="specimen_result" required class="form-control te-reslt testpossibleno te-reslt" id="te-reslt">
											<option value="">--Select--</option>
											<?php
											if ($case_epi_no[0]['case_type']=='Msl') { ?>
											<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive Measles')?'selected="selected"':''; ?> value='Positive Measles'>Positive Measles</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative Measles')?'selected="selected"':''; ?> value='Negative Measles'>Negative Measles</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive Rubella')?'selected="selected"':''; ?> value='Positive Rubella'>Positive Rubella</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative Rubella')?'selected="selected"':''; ?> value='Negative Rubella'>Negative Rubella</option>
										<option value="Other">Other</option>
										<?php }else { ?>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive')?'selected="selected"':''; ?> value='Positive'>Positive</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative')?'selected="selected"':''; ?> value='Negative'>Negative</option>
										<option value="Other">Other</option>
										<?php } ?>
											
										</select>
									</td>
									<td><label>Other Result: </label></td>
									<td colspan="3"><input id="oth-test" type="text" class="form-control testpossibleno oth-test" placeholder="Test result" name="other_specimen_result" readonly=""  maxlength="20">
									</td>
								</tr>
								<!-- <tr> -->
									<!-- <td><label>Type of Test done : </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Type of Test done" name="type_of_test" required maxlength="30" value="<?php echo $case_epi_no[0]['type_of_test'];?>"></td> -->

									<!-- <td><label>Test result : </label></td>
									<td colspan="3"> --><!-- <input type="text" class="form-control" placeholder="Test result" name="specimen_result" required maxlength="20" value="<?php echo $case_epi_no[0]['specimen_result'];?>"> -->

										<!-- <select name="specimen_result" required class="form-control testpossibleno">
											<?php
											if ($case_epi_no[0]['case_type']=='Msl') { ?>
											<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive Measles')?'selected="selected"':''; ?> value='Positive Measles'>Positive Measles</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative Measles')?'selected="selected"':''; ?> value='Negative Measles'>Negative Measles</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive Rubella')?'selected="selected"':''; ?> value='Positive Rubella'>Positive Rubella</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative Rubella')?'selected="selected"':''; ?> value='Negative Rubella'>Negative Rubella</option>
										<?php }else { ?>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Positive')?'selected="selected"':''; ?> value='Positive'>Positive</option>
										<option <?php echo ($case_epi_no[0]['specimen_result'] == 'Negative')?'selected="selected"':''; ?> value='Negative'>Negative</option>
										<?php } ?>
										</select>
 -->
									<!-- </td>
								</tr> -->
								<tr>
									<td><label>Comment : </label></td>
									<td><input type="text" class="form-control testpossibleno" placeholder="Comment" name="comments" required maxlength="100" value="<?php echo $case_epi_no[0]['comments'];?>"></td>
									<td><label>Date of lab report sent : </label></td>
									<td colspan="3"><input data-provide="datepicker" class="form-control dp testpossibleno" name="lab_report_sent_date" placeholder="YYYY-DD-MM" required value="<?php echo $case_epi_no[0]['lab_report_sent_date'];?>"></td>
								</tr>
								<tr>
									<td colspan="7" class="td-secondary-heading"><label>Result Submitted by </label></td>
								</tr>
								<tr>
									<td><label>Name : </label></td>
									<td><input type="text" class="form-control" placeholder="Name" name="report_sent_by" required maxlength="30" value="<?php echo $case_epi_no[0]['report_sent_by'];?>"></td>
									<td><label>Designation : </label></td>
									<td colspan="3"><input type="text" name=" sent_by_designation" class="form-control" placeholder="Designation" required maxlength="20" value="<?php echo $case_epi_no[0]['sent_by_designation'];?>"></td>
								</tr>
								<tr>
									<!-- <td><label>Signature : </label></td>
									<td><input type="text" class="form-control" placeholder="__________________________"></td>
 -->									<td><label>Date : </label></td>
									<td colspan="6"><?php echo $case_epi_no[0]['result_saved_date'];?></td>
								</tr>
								<tr>
									<td colspan="7" style="padding:10px;text-align:right;">
										<!-- <a href="#"><i class="fa fa-times"></i> Cancel</a>
										<a href="#"><i class="fa fa-recycle"></i> Reset</a> -->
										<!-- <a href=""><i class="fa fa-save"></i> Submit</a> -->
										<!-- <button class="form-button" type="Cancel"><i class="fa fa-times"></i> | Cancel</button> -->
										<a href="<?php echo base_url(); ?>Measles_Case/search_by_epid"><i class="fa fa-times"></i> Cancel</a>
										<button class="form-button"><i class="fa fa-save"></i> | Submit</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
		
	</section>
	</div>
	<!-- <section id="footer">
		<div class="main-footer">
			<strong style="position:relative; bottom:0px; margin-left:10px;">Copyright © all rights reserved. Department of Health, Khyber Pakhtunkhwa.</strong>
		</div>
	</section> -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$(document).on("click","#btn",function() {
    
    var x=1;
    //alert(x);
    if (x==1) {
    	$('#edit').removeClass('hide');
     	$('#view').addClass('hide');
    	$('#msg-epd').hide();
    	$('#v').removeClass('hide');
     	$('#e').addClass('hide');
    }
     	
   
});
		$(document).on("click","#btn1",function() {
    
    var x=1;
    //alert(x);
    if (x==1) {
    	$('#view').removeClass('hide');
     	$('#edit').addClass('hide');
    	$('#msg-epd').hide();
    	$('#e').removeClass('hide');
     	$('#v').addClass('hide');
    }
     	
   
});

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
	});
</script>

	