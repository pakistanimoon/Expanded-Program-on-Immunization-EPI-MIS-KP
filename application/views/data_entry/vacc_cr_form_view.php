<div class="container containermax bodycontainer">

	<div class="panel panel-primary">
		
		<div class="panel-heading">
			Vaccine Consumption Requisition Form Routine Immunization
		</div>
		<div class="panel-body">
			
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Month:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						
						<p><?php echo $vaccConsumption->month; ?></p>
					
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>Year:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $vaccConsumption->year; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Province:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo "Kyber Pakhtunkhwa"; ?></p>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>District:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $district; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Tehsil/Taluka:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $tehsil; ?></p>
						</select>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>UC:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $unioncouncil; ?></p>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3 col-sm-3 cmargin27">
						<label>Health Facility/Store:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $facility; ?></p>
					</div>
					<div class="col-md-2 col-md-offset-1 col-sm-2 cmargin27">
						<label>Date:</label>
					</div>
					<div class="col-md-3 col-sm-3">
						<p><?php echo $vaccConsumption->date_f; ?></p>
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
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['opening_balance_batch']; }else{ echo '';  } ?></p>
									</div>
									<div class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['opening_balance_expiry']; }else{ echo '';  } ?></p>
									</div>
									<div class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['opening_balance_doses']; }else{ echo '';  } ?></p>
									</div>
								</div>
							</div>
							<div class="col-xs-3 ">
								<div class="row">
									<div class="col-xs-4 zp">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['received_dur_month_batch']; }else{ echo '';  } ?></p>
									</div>
									<div class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['received_dur_months_expiry']; }else{ echo '';  } ?></p>
									</div>
									<div class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['received_dur_month_doses']; }else{ echo '';  } ?></p>
									</div>
								</div>
							</div>
							<div class="col-xs-1 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['childs_vaccinated']; }else{ echo '';  } ?></p>
							</div>
							<div class="col-xs-1 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['vials_used']; }else{ echo '';  } ?></p>
							</div>
							<div class="col-xs-1 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['un_usesable_vials']; }else{ echo '';  } ?></p>
							</div>
							<div class="col-xs-3">
								<div class="row">
									<div class="col-xs-4 zp">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['closing_balance_batch']; }else{ echo '';  } ?></p>
										</div>
									<div  class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['closing_balance_expiry']; }else{ echo '';  } ?></p>
									</div>
									<div  class="col-xs-4 zp text-center">
										<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['closing_balance_doses']; }else{ echo '';  } ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-3">
						<div class="row">
							<div class="col-xs-4 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['stock_level']; }else{ echo '';  } ?></p>
							</div>
							<div class="col-xs-4 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['request_vials']; }else{ echo '';  } ?></p>
							</div>
							<div class="col-xs-4 zp text-center">
								<p><?php if(isset($titles[$matchingTitle][$i])){ echo $titles[$matchingTitle][$i]['replenishment_vials']; }else{ echo '';  } ?></p>
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
						<p><?php echo $vaccConsumption->prepared_by; ?></p>
					</div>
					<div class="col-md-2 col-sm-4">
						<label class="lbl-setting4">Medical Officer/In-charge</label>
					</div>
					<div class="col-md-2 col-sm-6">
						<p><?php echo $vaccConsumption->facility_incharge; ?></p>
					</div>
					<div class="col-md-2 col-sm-4">
						<label class="lbl-setting4">Submitted Date</label>
					</div>
					<div class="col-md-2 col-sm-6">
						<p><?php echo $vaccConsumption->submitted_date; ?></p>
					</div>
				</div>
				<div class="row" >
					<hr>
					<?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
					<div class="col-xs-4" style="margin-left: 74%;">
						<a onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
					<?php } ?>
				</div>
		</div>
		<!--end of panel body-->
	</div>
	<!--end of panel panel-primary-->

</div><!--End of page content or body-->

<!--start of footer-->
<br>
<br>
