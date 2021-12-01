<!--start of page content or body-->

<div class="container bodycontainer">

<div class="row">

 <div class="panel panel-primary">
 	<?php if(!$this -> uri -> segment(5)){?>
 <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
<?php }?>
   <div class="panel-heading"> Monthly Report by FLCF</div>

     <div class="panel-body">

     

  	   <div class="row ">

	  	 <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Month</label>

		 <div class="col-md-2 col-sm-3 col-xs-4">

	<p><?php echo $monthname; ?></p>

		 </div>

		 <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Year</label>

		 <div class="col-md-2  col-sm-3 col-xs-4">

		   <p><?php echo substr($fmonth,0,4);?></p>

		  </div>

		  <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Health Facility</label>

		  <div class="col-md-2 col-sm-3 col-xs-4">

		   <p><?php

									echo $resultFac['fac_name'];

									?></p>

		</div>

	</div>

		<div class="row bgrow1"></div>



	<div class="row ">

	    <label class="col-md-4 col-sm-2 col-xs-2  control-label" for="example-text-input">Tehsil</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		<p><?php

									$tcode=$rowmr['tcode'];

									$query="Select tcode, tehsil from tehsil where tcode='$tcode'";

									echo $resultTeh['tehsil'];

									?></p>

		</div>

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Union Council</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		<p><?php

									echo $resultUnc['un_name'];

								?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Catchment Population of FLCF</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		<p><?php echo $rowmr['flcf_pop'];?></p>

		</div>

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Population Registered by LHWs</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		<p> <?php echo $rowmr['lhw_covered_pop'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Working LHWs</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

			<p> <?php echo $rowmr['no_reporting_lhws'];?></p>

		</div>

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of LHWs submitted Report</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['no_submitted_reports'];?></p>  

  		</div>

	</div>

	<div class="row ">

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Drop out/ Terminated LHWs during this Month</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		    <p> <?php echo $rowmr['no_dropout_thismonth'];?> </p>

		</div>

		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Working LHS</label>

		<div class="col-md-2 col-sm-4 col-xs-4">

		    <p> <?php echo $rowmr['no_lhs'];?> </p>

		</div>

	</div>

	<div class="row bgrow1">

	    1. Basic Information

    </div>

    <div class="row ">

		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">No of Formulated Health Commettees</label>

		<div class="col-md-4 col-xs-6">

		    <p> <?php echo $rowmr['bi_r1_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">No of Formulated Women Support Groups</label>

		<div class="col-md-4 col-xs-6">

		    <p> <?php echo $rowmr['bi_r2_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">Household Registered by LHWs</label>

		<div class="col-md-4 col-xs-6">

		    <p><?php echo $rowmr['bi_r3_f1'];?></p>

		</div>

	</div>

	<div>

		<br>

	<div class="panel panel-primary">

		<div class="panel-headingc1">Household with Source of Drinking Water</div>

		  <div class="panel-body">



	<div class="row ">

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Tap (Public Health Engineering)</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

			<p><?php echo $rowmr['bi_r4_f1'];?></p>

		</div>

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Hand Pump / Motor Pump</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

			<p><?php echo $rowmr['bi_r5_f1'];?></p>

		</div>

	</div>

    <div class="row ">

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Spring / Canal</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

		    <p><?php echo $rowmr['bi_r6_f1'];?></p>

		</div>

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Well</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

			<p><?php echo $rowmr['no_lhs'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Other</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

		   <p><?php echo $rowmr['bi_r8_f1'];?></p>

		</div>

		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Total</label>

		<div class="col-md-2 col-sm-2 col-xs-2">

		    <p><?php echo $rowmr['bi_r9_f1'];?></p>

		</div>

	</div>

  </div>

</div><!--end of pannel-->



	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Household having Flush System with Sewerage / Septic Tank</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

	    	<p><?php echo $rowmr['bi_r10_f1'];?></p>

		</div>

	</div>







	<div class="row bgrow1">

	    2. Social Contacts

    </div>

    <div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Health Committee Meetings</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['sc_r1_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Women Support Group Meetings</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

	   	    <p><?php echo $rowmr['sc_r2_f1'];?></p>

	    </div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Health Education Sessions Held in School</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['sc_r3_f1'];?></p>

		</div>

	</div>

    <div class="row bgrow1">

        3. Child Health

    </div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Borns Weighted (With in One Week After Birth)</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r1_f1'];?></p>

	    </div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Low Birth Weight Babies</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

	 	    <p><?php echo $rowmr['ch_r2_f1'];?></p>

	    </div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Born Started Breast Feeding within 24 Hours</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r3_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Infants whose Immunization has started this Month</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r4_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 12-23 Months old children</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r5_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 12-23 Months old children Fully immunized</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r6_f1'];?></p>

		</div>

	</div>

	<div class="row ">

	    <label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 

		&lt;3 Years children </label>

	    <div class="col-md-4 col-sm-4 col-xs-4">

		    <p><?php echo $rowmr['ch_r7_f1'];?></p>

	    </div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of &lt;3 Years Children whose GM done & Recorded</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r8_f1'];?></p>

		</div>

	</div>

	<div class="row ">

		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of &lt;3 Years Children malnourished</label>

		<div class="col-md-4 col-sm-4 col-xs-4">

			<p><?php echo $rowmr['ch_r9_f1'];?></p>

		</div>

	</div>

	

							<div class="row bgrow1">

								4. Mother Health

							</div>

							

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of newly registered pregnant Women</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r1_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total Pregnant Women (New+ Follow up)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r2_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total Pregnant Women visited (New + Followup)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r3_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Pregnant women supplied Iron tablets</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r4_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Abortions (pregnancy less Than 7 Months)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r5_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Women Delivered having 4 or >4 ANC Visits by SBAs (Dr, Nurse, LHV, Midwife/CMW)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r6_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Women Delivered With TT completed Before Delivery</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r7_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Deliveries by Skilled Birth Attendants (Dr, Nurse, LHV, Midwife/CMW)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r8_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Post-natal Cases Visited within 24 Hours</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['mh_r9_f1'];?></p>

									</div>

								</div>



						

						

							<div class="row bgrow1">

								5. Family Planning

							</div>

							

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Eligible Couples (Age of Wife between 15-49 Years)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r1_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Client of Family Planning (Modern + Traditional)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r2_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Follow-up Cases for Family Planning (Modern + Traditional)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r3_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total No of Modern Contraceptive Method Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r4_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Condom Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r5_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Oral Pills Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r6_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Injectable Contraceptive Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r7_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of IUCD Client</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r8_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Surgical Clients</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r9_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Other Modern Contraceptive Method Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r10_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total No of Traditional Method Users</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r11_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Family Planning Clients referred</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r12_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients Supplied condoms</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r13_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients Supplied Oral pills</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r14_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients administered Injectable Contraceptives</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['fp_r15_f1'];?></p>

									</div>

								</div>



						

									<div class="row bgrow1">

										6. Common Ailments

									</div>

									

										<div class="row common-ailments-rheading">

										<div class="col-xs-4 c-diseases">

											Diseases

										</div>

										<div class="col-xs-4 c-patients-less-5">

											<div class="row r1-patients-less-5">

												Patients &lt;5 years

											</div>

											

											<div class="row">

												<div class="col-xs-6 subc1-patients-less-5">

													Total Patients

												</div>

												<div class="col-xs-6 subc2-patients-less-5" style="">

													Drugs provided

												</div>

											</div>

										</div>

											<div class="col-xs-4 c-patients-greater-5">

											<div class="row r2-patients-greater-5">

												Patients &gt;5 years

											</div>

											

											<div class="row">

												<div class="col-xs-6 subc1-patients-greater-5" style="">

													Total Patients

												</div>

												<div class="col-xs-6 subc2-patients-greater-5">

													Drugs provided

												</div>

											</div>

										</div>

									</div>

								

								





										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Diarrhoea</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r1_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r1_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r1_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r1_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of ARI</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r2_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r2_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r2_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r2_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Fever</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r3_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r3_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r3_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r3_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Injuries/burns</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r4_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r4_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r4_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r4_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Anaemia</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r5_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r5_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r5_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r5_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Scabies</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r6_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r6_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r6_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r6_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Eye Infections</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r7_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r7_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r7_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r7_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-6 control-label" for="example-text-input">No of Female Cases of reproductive tract infections</label>

											<div class="col-xs-6">

												<p><?php echo $rowmr['ca_r8_f1'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Worm Infestation</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r9_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r9_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r9_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r9_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Malaria</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r10_f1'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r10_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r10_f3'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r10_f4'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-4 control-label" for="example-text-input">No of Referral Cases</label>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r11_f1'];?></p>

											</div>

											<div class="col-xs-2"> </div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['ca_r11_f2'];?></p>

											</div>

											<div class="col-xs-2"> </div>

										</div>

										<div class="row ">

											<label class="col-xs-6 control-label" for="example-text-input">No of of Suspected Cases of TB Referred</label>

											<div class="col-xs-6">

												<p><?php echo $rowmr['ca_r12_f1'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-6 control-label" for="example-text-input">No of Diagnosed Cases of TB</label>

											<div class="col-xs-6">

												<p><?php echo $rowmr['ca_r13_f1'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-6 control-label" for="example-text-input">No of TB Patients followed by LHW (as T/M Support)</label>

											<div class="col-xs-6">

												<p><?php echo $rowmr['ca_r14_f1'];?></p>

											</div>

										</div>

									</div>





						

								<div class="row bgrow1">

                                   7. Births / Deaths

								</div>

							

							

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Live Births</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r1_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Still Births (Pregnancy More than 07 Months)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r2_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of All Deaths</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r3_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of neo-natal Deaths (Within 1 Week of Birth)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r4_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Infant Deaths (Age More than 1 Week but Less than 1 Year)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r5_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Children Deaths (Age More than 1 Year but Less than 05 Years)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r6_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Maternal Deaths</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['bd_r7_f1'];?></p>

									</div>

								</div>



						<div class="row bgrow1">

							8. Logistic (LHW Kit)

						</div>

						<div class="row logistic-rheadig">

						    <div class="col-xs-3 c-drugs">

						    	Drugs / Contraceptives

						    </div>

						    <div class="col-xs-1 c-opening-b">

						    	Opening Balance of FLCP

						    </div>

						    <div class="col-xs-3 c-dpiu">

						    	Received from DPIU

						    	<div class="row r-stock-rec">

						    		<div class="col-xs-6 c-stock-rec">

						    			Stock Received

						    		</div>

						    		<div class="col-xs-6 c-date-rec">

						    			Date Received

						    		</div>

						    	</div>

						    </div>

						    <div class="col-xs-1 c-totalstock">

						    	Total Stock (Opening + Received)

						    </div>

						    <div class="col-xs-1 c-issued-lhw" style="">

						    	 &nbsp;Issued to LHWs

						    </div>

						    <div class="col-xs-1 c-avail-flcf">

						    	Available Balance at FLCF

						    </div>

						    <div class="col-xs-1 c-sufficiency">

						    	Sufficiency in No of Months

						    </div>

						    <div class="col-xs-1 c-days-outstock">

						    	Days out of stock at FLCF

						    </div>

						</div><!--end of main row-->

							<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Tab. Paracetamol</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r1_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r1_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r1_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r1_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r1_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r1_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r1_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r1_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Syp. Paracetamol</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r2_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r2_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r2_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r2_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r2_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r2_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r2_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r2_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Tab. Choloroquin</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r3_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r3_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r3_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r3_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r3_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r3_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r3_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r3_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Syp. Choloroquin</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r4_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r4_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r4_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r4_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r4_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r4_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r4_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r4_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Tab. Mebendazole</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r5_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r5_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r5_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r5_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r5_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r5_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r5_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r5_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Syp. Pipearzine</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r6_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r6_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r6_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r6_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r6_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r6_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r6_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r6_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">ORS</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r7_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r7_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r7_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r7_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r7_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r7_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r7_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r7_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Eye Ontiment</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r8_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r8_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r8_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r8_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r8_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r8_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r8_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r8_f8'];?></p>

											</div>

										</div>

										

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Syp.  Contrimexazole</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r9_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r9_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r9_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r9_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r9_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r9_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r9_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r9_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Iron Tab.</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r10_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r10_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r10_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r10_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r10_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r10_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r10_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r10_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Antiseptic Lotion</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r11_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r11_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r11_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r11_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r11_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r11_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r11_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r11_f8'];?></p>

											</div>

										</div>

										

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Benzyle Benzoate Lotion</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r12_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r12_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r12_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r12_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r12_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r12_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r12_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r12_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Sticking Plaster</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r13_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r13_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r13_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r13_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r13_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r13_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r13_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r13_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">B. Complex Syp</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r14_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r14_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r14_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r14_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r14_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r14_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r14_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r14_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Cotton Bandages</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r15_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r15_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r15_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r15_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r15_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r15_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r15_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r15_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Cotton Wool</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r16_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r16_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r16_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r16_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r16_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r16_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r16_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r16_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Condoms</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r17_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r17_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r17_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r17_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r17_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r17_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r17_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r17_f8'];?></p>

											</div>

										</div>

									

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Oral Pills</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r18_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r18_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r18_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r18_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r18_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r18_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r18_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r18_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Contraceptive Inj.</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r19_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r19_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r19_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r19_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r19_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r19_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r19_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r19_f8'];?></p>

											</div>

										</div>

										<div class="row ">

											<label class="col-xs-2 control-label" for="example-text-input">Others</label>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r20_f1'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r20_f2'];?></p>

											</div>

											<div class="col-xs-2">

												<p><?php echo $rowmr['lg_r20_f3'];?></p>

											</div>

											<div class="col-xs-1 cmargin13">

												<p><?php echo $rowmr['lg_r20_f4'];?></p>

											</div>

											<div class="col-xs-1 cmargin14">

												<p><?php echo $rowmr['lg_r20_f5'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r20_f6'];?></p>

											</div>

											<div class="col-xs-1">

												<p><?php echo $rowmr['lg_r20_f7'];?></p>

											</div>

											<div class="col-xs-1 cmargin15">

												<p><?php echo $rowmr['lg_r20_f8'];?></p>

											</div>

										</div>





















						<div class="row bgrow1">

							9. Miscellanous

									</div>

									 <div class="row r-miscellanous-heading">

										<div class="col-xs-6 c1-name-item">Name of Items</div>

										<div class="col-xs-3 c2-avil-no-lhw">Available with No of LHWs</div>

										<div class="col-xs-3 c3-fun-lhw">Functional with No of LHWs</div>

                                     </div>



                                        <div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">LHW Kit Bag</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r1_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r1_f2'];?></p>

										</div>

										</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Weighing Machine</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r2_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r2_f2'];?></p>

										</div>

										</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Thermometer</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r3_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r3_f2'];?></p>

										</div>

									</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Torch with Cell</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r4_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r4_f2'];?></p>

										</div>

									</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Scissors</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r5_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r5_f2'];?></p>

										</div>

									</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Syringe Cuttur</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r6_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r6_f2'];?></p>

										</div>

									</div>

										<div class="row ">

										<label class="col-xs-6 control-label" for="example-text-input">Others</label>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r7_f1'];?></p>

										</div>

										<div class="col-xs-3">

											<p><?php echo $rowmr['ms_r7_f2'];?></p>

										</div>

									</div>

							

						<div class="row bgrow1">

								10. Supervision

						</div>

							

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of visits by LHS</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['sp_r1_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by DCO (NP)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['sp_r2_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by ADC (NP)</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['sp_r3_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by FPO</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['sp_r4_f1'];?></p>

									</div>

								</div>

								<div class="row ">

									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No # of Visit by PPIU</label>

									<div class="col-md-4 col-sm-4 col-xs-4">

										<p><?php echo $rowmr['sp_r5_f1'];?></p>

									</div>

								</div>



					<div class="row bgrow1">

					    11. Comments

					</div>

					<div class="row">

						<div class="col-md-12">

							<textarea id="comments" name="comments" rows="5" class="form-control" placeholder="Comments">

								<?php echo $rowmr['comments'];?>

							</textarea>

						</div>

					</div>

					<div class="row  r-date-sub">

						<label class="col-xs-3 control-label" for="example-text-input">Date (Report Submitted)</label>

						<div class="col-xs-3 col-xs-offset-5 cwidth">

							<p><?php echo $rowmr['datareportsubmitted'];?></p>

						</div>

					</div>
<?php if(!$this -> uri -> segment(5)){?>
					<div class="row">
					<?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
						<div class="col-md-5 col-md-offset-10">
							
  							<a href=" <?php echo base_url(); ?>Data_entry/flcfmr_edit/<?php echo $rowmr['facode']; ?>/<?php echo $rowmr['fmonth']; ?>" class="btn btn-md btn-success "><i class="fa fa-pencil"></i>UPDATE </a>
 
							<a href="<?php echo base_url();?>Data_entry/flcfmr_list"><button  class="btn btn-md btn-success"><i class="fa fa-arrow-left"></i> Back </button></a>

						</div>
					<?php } ?>

					</div>

	<?php }?>											

						

					

					

					

	

				









  	</div> <!--end of panel body-->

 </div> <!--end of panel panel-primary-->

</div><!--end of row-->















	



</div><!--End of page content or body-->

