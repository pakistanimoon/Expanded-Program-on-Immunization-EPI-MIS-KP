<div class="container containermax bodycontainer">

	<div class="panel panel-primary">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
		<div class="panel-heading">
			Vaccine Consumption Requisition Form Routine Immunization
		</div>
		<div class="panel-body">
			<form class="form-horizontal"  method="post" action="<?php echo base_url(); ?>data_entry/vacc_cons_req_save">
				<?php if(isset($vaccConsumption)){ ?>
				<input type="hidden" name="recid" id="recid" value="<?php echo $vaccConsumption->recid; ?>"  />
				<?php } ?>
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Month:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="month" id="month">
							<?php if(isset($vaccConsumption)){
				          		?><option value="<?php echo $vaccConsumption->month; ?>"><?php echo monthname($vaccConsumption->month); ?></option><?php
				          	}else{ ?>
				            <?php echo $months; 
				            } ?>
						</select>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>Year:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="year" id="year">
							<?php if(isset($vaccConsumption)){
				            ?><option value="<?php echo $vaccConsumption->year; ?>"><?php echo $vaccConsumption->year; ?></option><?php
				          	}else{ ?>
				            <?php echo $years; 
				            } ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Province:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" disabled="disabled" name="procode" id="procode">
							<option selected="selected" value="3">Khyber Pakhtunkhwa</option>
						</select>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>District:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="distcode" id="distcode">
						<?php if(isset($vaccConsumption)){
			            ?><option value="<?php echo $vaccConsumption->distcode; ?>"><?php echo $district; ?></option><?php
			          	}else{ ?>
			              <?php echo getDistricts_options(true); 
						} ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Tehsil/Taluka:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="tcode" id="tcode">
						<?php if(isset($vaccConsumption)){
			            ?><option value="<?php echo $vaccConsumption->tcode; ?>"><?php echo $tehsil; ?></option><?php
			          	}else{ 
			              
						} ?>
						</select>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>UC:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="uncode" id="uncode">
						<?php if(isset($vaccConsumption)){
			            ?><option value="<?php echo $vaccConsumption->uncode; ?>"><?php echo $unioncouncil; ?></option><?php
			          	}else{ 
			              
						} ?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Health Facility/Store:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<select  class="form-control text-center" name="facode" id="facode">
						<?php if(isset($vaccConsumption)){
			            ?><option value="<?php echo $vaccConsumption->facode; ?>"><?php echo $facility; ?></option><?php
			          	}else{ 
			              
						} ?>
						</select>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>Date:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<input class="dp form-control" value="<?php if(isset($vaccConsumption)){ echo date("d-m-Y",strtotime($vaccConsumption->date_f)); }else { if(validation_errors() != false) { echo set_value('date_f'); } else{ echo '';} } ?>" name="date_f" id="date_f"  placeholder=" " type="text">
					</div>
				</div>
				<br>

				<div class="row">
					<div class="col-xs-2 btb">
						<div class="row">
							<div style="padding-top: 56px;" class="col-xs-7 pb18 text-center">
								<p class="psize">
									Product
								</p>
							</div>
							<div class="col-xs-5 bl">
								<div class="row bb">
									<div class="col-xs-12 text-center">
										<p class="psize">
											Dose per Vial
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt34 pb15 text-center">
										<p>
											A
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-7   ball">
						<div class="row">
							<div class="col-xs-3 br">
								<div class="row bb">
									<div class="col-xs-12 pt17 text-center">
										<p class="psize">
											Opening Balance
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 pt34">
										<p class="psize">
											Batch #
										</p>
									</div>
									<div class="col-xs-4 pt34 pb18 bl">
										<p class="psize">
											Expiry
										</p>
									</div>
									<div class="col-xs-4">
										<div class="row bbl">
											<div class="col-xs-12 text-center zp">
												<p class="psize">
													Doses / Nos.
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 pt4 bl">
												<p>
													B
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row bb">
									<div class="col-xs-12 pt17 zp text-center">
										<p class="psize">
											Received during the Month
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 pt34">
										<p class="psize">
											Batch #
										</p>
									</div>
									<div class="col-xs-4 pt34 pb18 bl">
										<p class="psize">
											Expiry
										</p>
									</div>
									<div class="col-xs-4">
										<div class="row bbl">
											<div class="col-xs-12 text-center zp">
												<p class="psize">
													Doses / Nos.
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 pt4 bl">
												<p>
													C
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-1 brl zp">
								<div class="row">
									<div style="margin-bottom: -6px;" class="col-xs-12 text-center">
										<p class="psize">
											Children Vaccinated
											/Doses
											Administer -ed
										</p>
									</div>
								</div>
								<div class="row ">
									<div class="col-xs-12">
										<p class="psize btb">
											Doses/Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div style="margin-bottom: -12px; margin-top: -12px;" class="col-xs-12 text-center">
										<p style="">
											D
										</p>
									</div>
								</div>
							</div>
							<div class="col-xs-1">
								<div class="row">
									<div class="col-xs-12">
										<p class="psize">
											Vials Used
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 btb text-left">
										<p class="psize">
											Vials / Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt4">
										<p>
											E
										</p>
									</div>
								</div>
							</div>
							<div class="col-xs-1 brl">
								<div class="row">
									<div class="col-xs-12 text-center zp">
										<p class="psize">
											Unusable Vials
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12    btb text-center">
										<p class="psize">
											Vials / Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt4">
										<p>
											F
										</p>
									</div>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<div class="col-xs-12 pt17 bb text-center">
										<p class="psize">
											Closing Balance
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 pt34">
										<p class="psize">
											Batch #
										</p>
									</div>
									<div  class="col-xs-4 pt34 pb18 bl">
										<p class="psize">
											Expiry
										</p>
									</div>
									<div class="col-xs-4 bl">
										<div class="row">
											<div class="col-xs-12 text-center bb">
												<p class="psize">
													Vials / Nos.
												</p>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 pt4">
												<p>
													G
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-3 bb">
						<div class="row">
							<div class="col-xs-4">
								<div class="row">
									<div class="col-xs-12 bt text-center">
										<p class="psize">
											Max. Stock Level
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt17 btb text-center">
										<p class="psize">
											Vials/Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt4 text-center">
										<p>
											H
										</p>
									</div>
								</div>
							</div>
							<div class="col-xs-4 brl">
								<div class="row">
									<div class="col-xs-12 bt text-center">
										<p class="psize">
											Request (I = H - G)
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt17 btb">
										<p class="psize">
											Vials/Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt4 text-center">
										<p>
											I
										</p>
									</div>
								</div>
							</div>
							<div class="col-xs-4">
								<div class="row">
									<div class="col-xs-12 pt17 bt">
										<p class="psize">
											Replenishment
										</p>
									</div>
								</div>
								<div class="row">
									<div  class="col-xs-12 pt17 btb">
										<p class="psize">
											Vials/Nos.
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 pt4 text-center">
										<p>
											J
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $vaccTitle = array('BCG'=>'20','DIL BCG'=>'0','tOPV'=>'20','Pentavalent'=>'1','Pneumococcal'=>'2','Measles'=>'10','DIL Measles'=>'0','TT 10'=>'10','TT 20'=>'20','HBV(Birth Dose)'=>'10','IPV'=>'10','AD Syringes 0.5 ml'=>'0','AD Syringes 0.05 ml'=>'0','Recon. Syringes 2ml'=>'0','Recon. Syringes 5ml'=>'0','Safety Boxes'=>'0'); ?>
				<?php foreach($vaccTitle as $vacc => $dosePerVial){ ?>
					<?php for($i=0;$i<3;$i++){ 
						$toMatch = str_replace('_', ' ', $vacc);
						$matchingTitle = str_insert($toMatch,'0','.'); ?>
				<div class="row">
					<div class="col-xs-2">
						<div class="row">
							<div class="col-xs-7 cmargin27">
							<?php if($i==1){ ?>
								<label><?php echo $vacc; ?></label>
							<?php } ?>
							</div>
							
							<?php if($i==1){
									if($dosePerVial=='0'){ ?>
									<div class="col-xs-5 zp text-center">
										<input readonly="readonly" class="form-control" placeholder="" type="text">
									</div>
							<?php  }else{ ?>
								<div class="col-xs-5 cmargin27 text-center">
									<label><small><?php echo $dosePerVial; ?></small></label>
								</div>
							<?php } } ?>
							
						</div>
					</div>
					<div class="col-xs-7">
						<div class="row">
							<div class="col-xs-3 ">
								<div class="row">
									<div class="col-xs-4 zp">
										<select class="form-control text-center" id="opening_balance_batch" name="opening_balance_batch[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]">
											<option value="00"></option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['opening_balance_batch']=='01'){ echo 'selected="selected"'; }else{  } } ?> value="01"> 01 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['opening_balance_batch']=='02'){ echo 'selected="selected"'; }else{  } } ?> value="02"> 02 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['opening_balance_batch']=='03'){ echo 'selected="selected"'; }else{  } } ?> value="03"> 03 </option>
										</select>
									</div>
									<div class="col-xs-4 zp text-center">
										<input class="dp form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][$i]['opening_balance_expiry'])); }else{ echo '';  } ?>" id="opening_balance_expiry" name="opening_balance_expiry[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
									<div class="col-xs-4 zp text-center">
										<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['opening_balance_doses']; }else{ echo '';  } ?>" id="opening_balance_doses" name="opening_balance_doses[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
								</div>
							</div>
							<div class="col-xs-3 ">
								<div class="row">
									<div class="col-xs-4 zp">
										<select class="form-control text-center" id="received_dur_month_batch" name="received_dur_month_batch[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]">
											<option value="00"></option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['received_dur_month_batch']=='01'){ echo 'selected="selected"'; }else{  } } ?> value="01"> 01 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['received_dur_month_batch']=='02'){ echo 'selected="selected"'; }else{  } } ?> value="02"> 02 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['received_dur_month_batch']=='03'){ echo 'selected="selected"'; }else{  } } ?> value="03"> 03 </option>
										</select>
									</div>
									<div class="col-xs-4 zp text-center">
										<input class="dp form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][$i]['received_dur_months_expiry'])); }else{ echo '';  } ?>" id="received_dur_months_expiry" name="received_dur_months_expiry[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
									<div class="col-xs-4 zp text-center">
										<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['received_dur_month_doses']; }else{ echo '';  } ?>" id="received_dur_month_doses" name="received_dur_month_doses[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
								</div>
							</div>
							<div class="col-xs-1 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['childs_vaccinated']; }else{ echo '';  } ?>" id="childs_vaccinated" name="childs_vaccinated[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
							<div class="col-xs-1 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['vials_used']; }else{ echo '';  } ?>" id="vials_used" name="vials_used[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
							<div class="col-xs-1 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['un_usesable_vials']; }else{ echo '';  } ?>" id="un_usesable_vials" name="un_usesable_vials[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
							<div class="col-xs-3">
								<div class="row">
									<div class="col-xs-4 zp">
										<select class="form-control text-center" id="closing_balance_batch" name="closing_balance_batch[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]">
											<option value="00"></option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['closing_balance_batch']=='01'){ echo 'selected="selected"'; }else{  } } ?> value="01"> 01 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['closing_balance_batch']=='02'){ echo 'selected="selected"'; }else{  } } ?> value="02"> 02 </option>
											<option <?php if(isset($titles[$matchingTitle][$i])){ if($titles[$matchingTitle][$i]['closing_balance_batch']=='03'){ echo 'selected="selected"'; }else{  } } ?> value="03"> 03 </option>
										</select>
									</div>
									<div  class="col-xs-4 zp text-center">
										<input class="dp form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][$i]['closing_balance_expiry'])); }else{ echo '';  } ?>" id="closing_balance_expiry" name="closing_balance_expiry[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
									<div  class="col-xs-4 zp text-center">
										<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['closing_balance_doses']; }else{ echo '';  } ?>" id="closing_balance_doses" name="closing_balance_doses[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="row">
							<div class="col-xs-4 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['stock_level']; }else{ echo '';  } ?>" id="stock_level" name="stock_level[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
							<div class="col-xs-4 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['request_vials']; }else{ echo '';  } ?>" id="request_vials" name="request_vials[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
							<div class="col-xs-4 zp text-center">
								<input class="form-control" value="<?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['replenishment_vials']; }else{ echo '';  } ?>" id="replenishment_vials" name="replenishment_vials[<?php echo $i; ?>][<?php $title=str_replace('.','',$vacc); echo str_replace(' ', '_', $title); ?>]" placeholder=" " type="text">
							</div>
						</div>
					</div>
				</div>
					<?php } ?>
				<?php } ?>
				<div class="row row-signatures">
					<div class="col-md-2 col-sm-4">
						<label class="lbl-setting4">Prepared By</label>
					</div>
					<div class="col-md-2 col-sm-6">
						<input class="form-control" value="<?php if(isset($vaccConsumption)){ echo $vaccConsumption->prepared_by; } else { if(validation_errors() != false) { echo set_value('prepared_by'); } else{ } } ?>" name="prepared_by" id="prepared_by" placeholder="" type="text">
						<?php echo form_error('prepared_by'); ?>
					</div>
					<div class="col-md-2 col-sm-4">
						<label class="lbl-setting4">Medical Officer/In-charge</label>
					</div>
					<div class="col-md-2 col-sm-6">
						<input class="form-control" value="<?php if(isset($vaccConsumption)){ echo $vaccConsumption->facility_incharge; } else { if(validation_errors() != false) { echo set_value('facility_incharge'); } else{ } } ?>" name="facility_incharge" id="facility_incharge" placeholder="" type="text">
					</div>
					<div class="col-md-2 col-sm-4">
						<label class="lbl-setting4">Submitted Date</label>
					</div>
					<div class="col-md-2 col-sm-6">
						<input class="dp form-control" value="<?php if(isset($vaccConsumption)){ echo date("d-m-Y",strtotime($vaccConsumption->submitted_date)); }else { if(validation_errors() != false) { echo set_value('submitted_date'); } else{ } } ?>" name="submitted_date" id="submitted_date" placeholder="" type="text">
					</div>
				</div>
				<div class="row" >
					<hr>
					<div class="col-xs-4" style="margin-left: 74%;">
						<button type="submit" class="btn btn-md btn-success bc1">
							<i class="fa fa-floppy-o "></i> Save Form
						</button>
						<button type="reset" class="btn btn-md btn-success" type="reset">
							<i class="fa fa-repeat"></i> Reset Form
						</button>
						<a onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
				</div>

			</form>
		</div>
		<!--end of panel body-->
	</div>
	<!--end of panel panel-primary-->

</div><!--End of page content or body-->

<!--start of footer-->
<br>
<br>
