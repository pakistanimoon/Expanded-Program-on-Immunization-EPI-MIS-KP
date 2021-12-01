<!--start of page content or body-->
<div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
 <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol>
   <div class="panel-heading"> Add New Monthly Reports By FLCF</div>
     <div class="panel-body">
       <form action="<?php echo base_url(); ?>Data_entry/flcfmredit_save" method="post" enctype="multipart/form-data" onSubmit="">

  	   <div class="row">
	  	 <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Month</label>
		 <div class="col-md-2 col-sm-3 col-xs-4">
		   <p><?php echo $monthname; ?></p>
		   <input type="hidden" id="month" name="month" value="<?php echo substr($fmonth,5);?>" />
		 </div>
		 <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Year</label>
		 <div class="col-md-2  col-sm-3 col-xs-4">
		  <p><?php echo substr($fmonth,0,4);?></p>
		  <input type="hidden" id="year" name="year" value="<?php echo substr($fmonth,0,4);?>" />
		  </div>
		  <label class="col-md-2 col-sm-1 col-xs-2 control-label" for="example-text-input">Health Facility</label>
		  <div class="col-md-2 col-sm-3 col-xs-4">
		          <select id="facode" name="facode" class="form-control" size="1" >

								<?php

						foreach($resultFac as $row){ 

							?>

										<option value="<?php echo $row['facode'];?>" <?php if($row['facode']==$rowmr['facode']){ echo "selected='selected'"; } ?>/><?php echo $row['fac_name'];?>

									<?php } ?>

                                 </select>
		</div>
	</div>
		<div class="row bgrow1"></div>

	<div class="row rowmr-fields">
	    <label class="col-md-4 col-sm-2 col-xs-2  control-label" for="example-text-input">Tehsil</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
		 <select id="tcode" name="tcode" class="form-control" size="1" >

								<?php

									

									foreach($resultTeh as $row){

									?>

										<option value="<?php echo $row['tcode'];?>" <?php if($row['tcode']==$rowmr['tcode']){ echo "selected='selected'"; } ?> /><?php echo $row['tehsil'];?>

									<?php

									}

								?>

                                 </select>
		</div>
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Union Council</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
		 <select id="uncode" name="uncode" class="form-control" size="1" >

								<?php

									foreach($resultUnc as $row){

									?>

										<option value="<?php echo $row['uncode'];?>" <?php if($row['uncode']==$rowmr['uncode']){ echo "selected='selected'"; } ?>/><?php echo $row['un_name'];?>

									<?php

									}

								?>

                                 </select>

		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Catchment Population of FLCF</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
			 <input type="text" id="flcf_pop" name="flcf_pop" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['flcf_pop'];?>"/>
		
		</div>
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">Population Registered by LHWs</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
		 <input type="text" id="lhw_covered_pop" name="lhw_covered_pop" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lhw_covered_pop'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Working LHWs</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
			<input type="text" id="no_reporting_lhws" name="no_reporting_lhws" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['no_reporting_lhws'];?>"/>
		</div>
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of LHWs submitted Report</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
			<input type="text" id="no_submitted_reports" name="no_submitted_reports" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['no_submitted_reports'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Drop out/ Terminated LHWs during this Month</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
		     <input type="text" id="no_dropout_thismonth" name="no_dropout_thismonth" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['no_dropout_thismonth'];?>" />
		</div>
		<label class="col-md-4 col-sm-2 col-xs-2 control-label" for="example-text-input">No of Working LHS</label>
		<div class="col-md-2 col-sm-4 col-xs-4">
		     <input type="text" id="no_lhs" name="no_lhs" class="form-control numberclass" placeholder="Number" value="<?php echo $rowmr['no_lhs'];?>" />
		</div>
	</div>
	<div class="row bgrow1">
	    1. Basic Information
    </div>
    <div class="row rowmr-fields">
		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">No of Formulated Health Commettees</label>
		<div class="col-md-4 col-xs-6">
		   <input type="text" id="bi_r1_f1" name="bi_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r1_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">No of Formulated Women Support Groups</label>
		<div class="col-md-4 col-xs-6">
		     <input type="text" id="bi_r2_f1" name="bi_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r2_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-xs-6 control-label" for="example-text-input">Household Registered by LHWs</label>
		<div class="col-md-4 col-xs-6">
		   <input type="text" id="bi_r3_f1" name="bi_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r3_f1'];?>"/>
		</div>
	</div>
	<div>
		<br>
	<div class="panel panel-primary">
		<div class="panel-headingc1">Household with Source of Drinking Water</div>
		  <div class="panel-body">

	<div class="row rowmr-fields">
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Tap (Public Health Engineering)</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
			<input type="text" id="bi_r4_f1" name="bi_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r4_f1'];?>"/>
		</div>
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Hand Pump / Motor Pump</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
			<input type="text" id="bi_r5_f1" name="bi_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r5_f1'];?>"/>
		</div>
	</div>
    <div class="row rowmr-fields">
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Spring / Canal</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
		    <input type="text" id="bi_r6_f1" name="bi_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r6_f1'];?>"/>
		</div>
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Well</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
			<input type="text" id="bi_r7_f1" name="bi_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r7_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Other</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
		    <input type="text" id="bi_r8_f1" name="bi_r8_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r8_f1'];?>"/>
		</div>
		<label class="col-md-4 col-sm-4 col-xs-4 control-label" for="example-text-input">Total</label>
		<div class="col-md-2 col-sm-2 col-xs-2">
		    <input type="text" id="bi_r9_f1" name="bi_r9_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bi_r9_f1'];?>"/>
		</div>
	</div>
  </div>
</div><!--end of pannel-->

	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Household having Flush System with Sewerage / Septic Tank</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
	    	<input type="text" id="bi_r10_f1" name="bi_r10_f1" class="form-control numberclass" placeholder="Number" value="<?php echo $rowmr['bi_r10_f1'];?>"/>
		</div>
	</div>



	<div class="row bgrow1">
	    2. Social Contacts
    </div>
    <div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Health Committee Meetings</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<input type="text" id="sc_r1_f1" name="sc_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sc_r1_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Women Support Group Meetings</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
	   	     <input type="text" id="sc_r2_f1" name="sc_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sc_r2_f1'];?>"/>
	    </div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Health Education Sessions Held in School</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			 <input type="text" id="sc_r3_f1" name="sc_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sc_r3_f1'];?>"/>
		</div>
	</div>
    <div class="row bgrow1">
        3. Child Health
    </div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Borns Weighted (With in One Week After Birth)</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			 <input type="text" id="ch_r1_f1" name="ch_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r1_f1'];?>"/>
	    </div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Low Birth Weight Babies</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
	 	   <input type="text" id="ch_r2_f1" name="ch_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r2_f1'];?>"/>
	    </div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Born Started Breast Feeding within 24 Hours</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<input type="text" id="ch_r3_f1" name="ch_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r3_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Infants whose Immunization has started this Month</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<input type="text" id="ch_r4_f1" name="ch_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r4_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 12-23 Months old children</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			 <input type="text" id="ch_r5_f1" name="ch_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r5_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 12-23 Months old children Fully immunized</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			<input type="text" id="ch_r6_f1" name="ch_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r6_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
	    <label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of 
		&lt;3 Years children </label>
	    <div class="col-md-4 col-sm-4 col-xs-4">
		   <input type="text" id="ch_r7_f1" name="ch_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r7_f1'];?>"/>
	    </div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of &lt;3 Years Children whose GM done & Recorded</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			 <input type="text" id="ch_r8_f1" name="ch_r8_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r8_f1'];?>"/>
		</div>
	</div>
	<div class="row rowmr-fields">
		<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of &lt;3 Years Children malnourished</label>
		<div class="col-md-4 col-sm-4 col-xs-4">
			 <input type="text" id="ch_r9_f1" name="ch_r9_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ch_r9_f1'];?>"/>
		</div>
	</div>
	
							<div class="row bgrow1">
								4. Mother Health
							</div>
							
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of newly registered pregnant Women</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r1_f1" name="mh_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r1_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total Pregnant Women (New+ Follow up)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r2_f1" name="mh_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r2_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total Pregnant Women visited (New + Followup)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r3_f1" name="mh_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r3_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Pregnant women supplied Iron tablets</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r4_f1" name="mh_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r4_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Abortions (pregnancy less Than 7 Months)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r5_f1" name="mh_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r5_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Women Delivered having 4 or >4 ANC Visits by SBAs (Dr, Nurse, LHV, Midwife/CMW)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r6_f1" name="mh_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r6_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Women Delivered With TT completed Before Delivery</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="mh_r7_f1" name="mh_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r7_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No Of Deliveries by Skilled Birth Attendants (Dr, Nurse, LHV, Midwife/CMW)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="mh_r8_f1" name="mh_r8_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r8_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No. of Post-natal Cases Visited within 24 Hours</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="mh_r9_f1" name="mh_r9_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['mh_r9_f1'];?>"/>
									</div>
								</div>

						
						
							<div class="row bgrow1">
								5. Family Planning
							</div>
							
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Eligible Couples (Age of Wife between 15-49 Years)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r1_f1" name="fp_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r1_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of New Client of Family Planning (Modern + Traditional)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="fp_r2_f1" name="fp_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r2_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Follow-up Cases for Family Planning (Modern + Traditional)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r3_f1" name="fp_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r3_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total No of Modern Contraceptive Method Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r4_f1" name="fp_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r4_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Condom Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r5_f1" name="fp_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r5_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Oral Pills Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="fp_r6_f1" name="fp_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r6_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Injectable Contraceptive Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="fp_r7_f1" name="fp_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r7_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of IUCD Client</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r8_f1" name="fp_r8_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r8_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Surgical Clients</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r9_f1" name="fp_r9_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r9_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Other Modern Contraceptive Method Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="fp_r10_f1" name="fp_r10_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r10_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">Total No of Traditional Method Users</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										  <input type="text" id="fp_r11_f1" name="fp_r11_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r11_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Family Planning Clients referred</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r12_f1" name="fp_r12_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r12_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients Supplied condoms</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r13_f1" name="fp_r13_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r13_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients Supplied Oral pills</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="fp_r14_f1" name="fp_r14_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r14_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Clients administered Injectable Contraceptives</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="fp_r15_f1" name="fp_r15_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['fp_r15_f1'];?>"/>
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
								
								


										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Diarrhoea</label>
											<div class="col-xs-2">
											 <input type="text" id="ca_r1_f1" name="ca_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r1_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r1_f2" name="ca_r1_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r1_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r1_f3" name="ca_r1_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r1_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r1_f4" name="ca_r1_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r1_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of ARI</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r2_f1" name="ca_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r2_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r2_f2" name="ca_r2_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r2_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r2_f3" name="ca_r2_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r2_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r2_f4" name="ca_r2_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r2_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Fever</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r3_f1" name="ca_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r3_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r3_f2" name="ca_r3_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r3_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r3_f3" name="ca_r3_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r3_f3'];?>"/>

											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r3_f4" name="ca_r3_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r3_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Injuries/burns</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r4_f1" name="ca_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r4_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												  <input type="text" id="ca_r4_f2" name="ca_r4_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r4_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r4_f3" name="ca_r4_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r4_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r4_f4" name="ca_r4_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r4_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Anaemia</label>
											<div class="col-xs-2">
												<input type="text" id="ca_r5_f1" name="ca_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r5_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												  <input type="text" id="ca_r5_f2" name="ca_r5_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r5_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r5_f3" name="ca_r5_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r5_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r5_f4" name="ca_r5_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r5_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Scabies</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r6_f1" name="ca_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r6_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r6_f2" name="ca_r6_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r6_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												<input id="ca_r6_f3" name="ca_r6_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r6_f3'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="ca_r6_f4" name="ca_r6_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r6_f4'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Eye Infections</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r7_f1" name="ca_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r7_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r7_f2" name="ca_r7_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r7_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r7_f3" name="ca_r7_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r7_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r7_f4" name="ca_r7_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r7_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-6 control-label" for="example-text-input">No of Female Cases of reproductive tract infections</label>
											<div class="col-xs-6">
												 <input type="text" id="ca_r8_f1" name="ca_r8_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r8_f1'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Worm Infestation</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r9_f1" name="ca_r9_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r9_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r9_f2" name="ca_r9_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r9_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r9_f3" name="ca_r9_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r9_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r9_f4" name="ca_r9_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r9_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Cases of Malaria</label>
											<div class="col-xs-2">
												<input type="text" id="ca_r10_f1" name="ca_r10_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r10_f1'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="ca_r10_f2" name="ca_r10_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r10_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r10_f3" name="ca_r10_f3" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r10_f3'];?>"/>
											</div>
											<div class="col-xs-2">
												<input type="text" id="ca_r10_f4" name="ca_r10_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r10_f4'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-4 control-label" for="example-text-input">No of Referral Cases</label>
											<div class="col-xs-2">
												 <input type="text" id="ca_r11_f1" name="ca_r11_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r11_f1'];?>"/>
											</div>
											<div class="col-xs-2"> </div>
											<div class="col-xs-2">
												<input type="text" id="ca_r11_f2" name="ca_r11_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r11_f2'];?>"/>
											</div>
											<div class="col-xs-2"> </div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-6 control-label" for="example-text-input">No of of Suspected Cases of TB Referred</label>
											<div class="col-xs-6">
												 <input type="text" id="ca_r12_f1" name="ca_r12_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r12_f1'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-6 control-label" for="example-text-input">No of Diagnosed Cases of TB</label>
											<div class="col-xs-6">
												 <input type="text" id="ca_r13_f1" name="ca_r13_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r13_f1'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-6 control-label" for="example-text-input">No of TB Patients followed by LHW (as T/M Support)</label>
											<div class="col-xs-6">
												<input type="text" id="ca_r14_f1" name="ca_r14_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ca_r14_f1'];?>"/>
											</div>
										</div>
									</div>


						
								<div class="row bgrow1">
                                   7. Births / Deaths
								</div>
							
							
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Live Births</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="bd_r1_f1" name="bd_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r1_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Still Births (Pregnancy More than 07 Months)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="bd_r2_f1" name="bd_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r2_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of All Deaths</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="bd_r3_f1" name="bd_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r3_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of neo-natal Deaths (Within 1 Week of Birth)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="bd_r4_f1" name="bd_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r4_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Infant Deaths (Age More than 1 Week but Less than 1 Year)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="bd_r5_f1" name="bd_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r5_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Children Deaths (Age More than 1 Year but Less than 05 Years)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="bd_r6_f1" name="bd_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r6_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Maternal Deaths</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="bd_r7_f1" name="bd_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['bd_r7_f1'];?>"/>
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
							<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Tab. Paracetamol</label>
											<div class="col-xs-1">
												<input type="text" id="lg_r1_f1" name="lg_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f1'];?>"/>
											</div>
											<div class="col-xs-1">
												 <input type="text" id="lg_r1_f2" name="lg_r1_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f2'];?>"/>
											</div>
											<div class="col-xs-2">
												 <input type="text" id="lg_r1_f3" name="lg_r1_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" value="<?php echo $rowmr['lg_r1_f3'];?>" readonly />
											</div>
											<div class="col-xs-1 cmargin13">
												  <input type="text" id="lg_r1_f4" name="lg_r1_f4" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f4'];?>"/>
											</div>
											<div class="col-xs-1 cmargin14">
												 <input type="text" id="lg_r1_f5" name="lg_r1_f5" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f5'];?>"/>
											</div>
											<div class="col-xs-1">
												 <input type="text" id="lg_r1_f6" name="lg_r1_f6" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f6'];?>"/>
											</div>
											<div class="col-xs-1">
												<input type="text" id="lg_r1_f7" name="lg_r1_f7" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f7'];?>"/>
											</div>
											<div class="col-xs-1 cmargin15">
												<input type="text" id="lg_r1_f8" name="lg_r1_f8" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['lg_r1_f8'];?>"/>
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Syp. Paracetamol</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r2_f1" name="lg_r2_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r2_f2" name="lg_r2_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f1'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r2_f3" name="lg_r2_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r2_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r2_f4" name="lg_r2_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r2_f5" name="lg_r2_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r2_f6" name="lg_r2_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r2_f7" name="lg_r2_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r2_f8" name="lg_r2_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r2_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Tab. Choloroquin</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r3_f1" name="lg_r3_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r3_f2" name="lg_r3_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r3_f3" name="lg_r3_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r3_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r3_f4" name="lg_r3_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r3_f5" name="lg_r3_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r3_f6" name="lg_r3_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r3_f7" name="lg_r3_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r3_f8" name="lg_r3_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r3_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Syp. Choloroquin</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r4_f1" name="lg_r4_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r4_f2" name="lg_r4_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r4_f3" name="lg_r4_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r4_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r4_f4" name="lg_r4_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r4_f5" name="lg_r4_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r4_f6" name="lg_r4_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r4_f7" name="lg_r4_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r4_f8" name="lg_r4_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r4_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Tab. Mebendazole</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r5_f1" name="lg_r5_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r5_f2" name="lg_r5_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r5_f3" name="lg_r5_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r5_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r5_f4" name="lg_r5_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r5_f5" name="lg_r5_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r5_f6" name="lg_r5_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r5_f7" name="lg_r5_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r5_f8" name="lg_r5_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r5_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Syp. Pipearzine</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r6_f1" name="lg_r6_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r6_f2" name="lg_r6_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r6_f3" name="lg_r6_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r6_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r6_f4" name="lg_r6_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r6_f5" name="lg_r6_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r6_f6" name="lg_r6_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r6_f7" name="lg_r6_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r6_f8" name="lg_r6_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r6_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">ORS</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r7_f1" name="lg_r7_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r7_f2" name="lg_r7_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r7_f3" name="lg_r7_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r7_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r7_f4" name="lg_r7_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r7_f5" name="lg_r7_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r7_f6" name="lg_r7_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r7_f7" name="lg_r7_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r7_f8" name="lg_r7_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r7_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Eye Ontiment</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r8_f1" name="lg_r8_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r8_f2" name="lg_r8_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f2'];?>"value="0" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r8_f3" name="lg_r8_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r8_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r8_f4" name="lg_r8_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r8_f5" name="lg_r8_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r8_f6" name="lg_r8_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r8_f7" name="lg_r8_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r8_f8" name="lg_r8_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r8_f8'];?>" type="text">
											</div>
										</div>
										
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Syp.  Contrimexazole</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r9_f1" name="lg_r9_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r9_f2" name="lg_r9_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r9_f3" name="lg_r9_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r9_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r9_f4" name="lg_r9_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f4'];?>" value="0" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r9_f5" name="lg_r9_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r9_f6" name="lg_r9_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r9_f7" name="lg_r9_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r9_f8" name="lg_r9_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r9_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Iron Tab.</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r10_f1" name="lg_r10_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r10_f2" name="lg_r10_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r10_f3" name="lg_r10_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r10_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r10_f4" name="lg_r10_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r10_f5" name="lg_r10_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r10_f6" name="lg_r10_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r10_f7" name="lg_r10_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r10_f8" name="lg_r10_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r10_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Antiseptic Lotion</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r11_f1" name="lg_r11_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f1'];?>"  type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r11_f2" name="lg_r11_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f2'];?>"  type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r11_f3" name="lg_r11_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r11_f3'];?>" >
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r11_f4" name="lg_r11_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f4'];?>"  type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r11_f5" name="lg_r11_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f5'];?>"  type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r11_f6" name="lg_r11_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f6'];?>"  type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r11_f7" name="lg_r11_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f7'];?>"  type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r11_f8" name="lg_r11_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r11_f8'];?>"  type="text">
											</div>
										</div>
										
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Benzyle Benzoate Lotion</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r12_f1" name="lg_r12_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r12_f2" name="lg_r12_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r12_f3" name="lg_r12_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r12_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r12_f4" name="lg_r12_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r12_f5" name="lg_r12_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r12_f6" name="lg_r12_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r12_f7" name="lg_r12_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r12_f8" name="lg_r12_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r12_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Sticking Plaster</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r13_f1" name="lg_r13_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r13_f2" name="lg_r13_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r13_f3" name="lg_r13_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r13_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r13_f4" name="lg_r13_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r13_f5" name="lg_r13_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r13_f6" name="lg_r13_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r13_f7" name="lg_r13_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r13_f8" name="lg_r13_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r13_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">B. Complex Syp</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r14_f1" name="lg_r14_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r14_f2" name="lg_r14_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r14_f3" name="lg_r14_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r14_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r14_f4" name="lg_r14_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r14_f5" name="lg_r14_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r14_f6" name="lg_r14_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r14_f7" name="lg_r14_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r14_f8" name="lg_r14_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r14_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Cotton Bandages</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r15_f1" name="lg_r15_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r15_f2" name="lg_r15_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r15_f3" name="lg_r15_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r15_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r15_f4" name="lg_r15_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r15_f5" name="lg_r15_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r15_f6" name="lg_r15_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r15_f7" name="lg_r15_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r15_f8" name="lg_r15_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r15_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Cotton Wool</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r16_f1" name="lg_r16_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r16_f2" name="lg_r16_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r16_f3" name="lg_r16_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r16_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r16_f4" name="lg_r16_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r16_f5" name="lg_r16_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r16_f6" name="lg_r16_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r16_f7" name="lg_r16_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r16_f8" name="lg_r16_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r16_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Condoms</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r17_f1" name="lg_r17_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r17_f2" name="lg_r17_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r17_f3" name="lg_r17_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r17_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r17_f4" name="lg_r17_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r17_f5" name="lg_r17_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r17_f6" name="lg_r17_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r17_f7" name="lg_r17_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r17_f8" name="lg_r17_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r17_f8'];?>" type="text">
											</div>
										</div>
									
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Oral Pills</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r18_f1" name="lg_r18_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r18_f2" name="lg_r18_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r18_f3" name="lg_r18_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r18_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r18_f4" name="lg_r18_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r18_f5" name="lg_r18_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r18_f6" name="lg_r18_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r18_f7" name="lg_r18_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r18_f8" name="lg_r18_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r18_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Contraceptive Inj.</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r19_f1" name="lg_r19_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r19_f2" name="lg_r19_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r19_f3" name="lg_r19_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r19_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r19_f4" name="lg_r19_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r19_f5" name="lg_r19_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r19_f6" name="lg_r19_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r19_f7" name="lg_r19_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r19_f8" name="lg_r19_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r19_f8'];?>" type="text">
											</div>
										</div>
										<div class="row rowmr-fields">
											<label class="col-xs-2 control-label" for="example-text-input">Others</label>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r20_f1" name="lg_r20_f1" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f1'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input id="lg_r20_f2" name="lg_r20_f2" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f2'];?>" type="text">
											</div>
											<div class="col-xs-2">
												<input id="lg_r20_f3" name="lg_r20_f3" class="form-control receiveclass" placeholder="YYYY-MM-DD" readonly="readonly" type="text" value="<?php echo $rowmr['lg_r20_f3'];?>">
											</div>
											<div class="col-xs-1 cmargin13">
												<input readonly="readonly" id="lg_r20_f4" name="lg_r20_f4" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f4'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin14">
												<input id="lg_r20_f5" name="lg_r20_f5" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f5'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r20_f6" name="lg_r20_f6" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f6'];?>" type="text">
											</div>
											<div class="col-xs-1">
												<input readonly="readonly" id="lg_r20_f7" name="lg_r20_f7" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f7'];?>" type="text">
											</div>
											<div class="col-xs-1 cmargin15">
												<input id="lg_r20_f8" name="lg_r20_f8" class="form-control numberclass lgcalc" placeholder="Number" value="<?php echo $rowmr['lg_r20_f8'];?>" type="text">
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

                                        <div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">LHW Kit Bag</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r1_f1" name="ms_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r1_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											<input type="text" id="ms_r1_f2" name="ms_r1_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r1_f2'];?>"/>
										</div>
										</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Weighing Machine</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r2_f1" name="ms_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r2_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											<input type="text" id="ms_r2_f2" name="ms_r2_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r2_f2'];?>"/>
										</div>
										</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Thermometer</label>
										<div class="col-xs-3">
											 <input type="text" id="ms_r3_f1" name="ms_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r3_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											<input type="text" id="ms_r3_f2" name="ms_r3_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r3_f2'];?>"/>
										</div>
									</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Torch with Cell</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r4_f1" name="ms_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r4_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											<input type="text" id="ms_r4_f2" name="ms_r4_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r4_f2'];?>"/>
										</div>
									</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Scissors</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r5_f1" name="ms_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r5_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											<input type="text" id="ms_r5_f2" name="ms_r5_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r5_f2'];?>"/>
										</div>
									</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Syringe Cuttur</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r6_f1" name="ms_r6_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r6_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											 <input type="text" id="ms_r6_f2" name="ms_r6_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r6_f2'];?>"/>
										</div>
									</div>
										<div class="row rowmr-fields">
										<label class="col-xs-6 control-label" for="example-text-input">Others</label>
										<div class="col-xs-3">
											<input type="text" id="ms_r7_f1" name="ms_r7_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r7_f1'];?>"/>
										</div>
										<div class="col-xs-3">
											 <input type="text" id="ms_r7_f2" name="ms_r7_f2" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['ms_r7_f2'];?>"/>
										</div>
									</div>
							
						<div class="row bgrow1">
								10. Supervision
						</div>
							
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of visits by LHS</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="sp_r1_f1" name="sp_r1_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sp_r1_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by DCO (NP)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="sp_r2_f1" name="sp_r2_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sp_r2_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by ADC (NP)</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="sp_r3_f1" name="sp_r3_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sp_r3_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No of Visit by FPO</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										 <input type="text" id="sp_r4_f1" name="sp_r4_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sp_r4_f1'];?>"/>
									</div>
								</div>
								<div class="row rowmr-fields">
									<label class="col-md-8 col-sm-8 col-xs-8 control-label" for="example-text-input">No # of Visit by PPIU</label>
									<div class="col-md-4 col-sm-4 col-xs-4">
										<input type="text" id="sp_r5_f1" name="sp_r5_f1" class="form-control numberclass" placeholder="Number"  value="<?php echo $rowmr['sp_r5_f1'];?>"/>
									</div>
								</div>

					<div class="row bgrow1">
					    11. Comments
					</div>
					<div class="row">
						<div class="col-md-12">
							<textarea id="comments" name="comments" rows="5" class="form-control" value="<?php echo $rowmr['comments'];?>" placeholder="Comments"><?php echo $rowmr['comments'];?></textarea>
						</div>
					</div>
					<div class="row rowmr-fields r-date-sub">
						<label class="col-xs-3 control-label" for="example-text-input">Date (Report Submitted)</label>
						<div class="col-xs-3 col-xs-offset-5 cwidth">
							<input type="text" id="datareportsubmitted" name="datareportsubmitted" class="form-control dateclass" placeholder="YYYY-MM-DD" value="<?php echo $rowmr['datareportsubmitted'];?>" readonly />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-8">
						<button type="submit" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Save Form </button>
						<button type="reset" class="btn btn-md  btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
						<a href="<?php echo base_url();?>Data_entry/flcfmr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					    </div>
					</div>
												
						
					</form>
					
					
	
				




  	</div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->







	

</div><!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/vendor/jquery-1.11.0.min.js"></script>

      <script src="<?php echo base_url(); ?>includes/js/vendor/bootstrap.min.js"></script>

      <script src="<?php echo base_url(); ?>includes/js/plugins.js"></script>

      <script src="<?php echo base_url(); ?>includes/js/app.js"></script>       

      <script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js"></script>       

      <script src="<?php echo base_url(); ?>includes/js/vendor/modernizr-2.7.1-respond-1.4.2.min.js"></script>

        <script src="<?php echo base_url(); ?>includes/js/jquery-migrate-1.2.1.min.js"></script>

		<script src="<?php echo base_url(); ?>includes/js/mr.js"></script>

      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	  <script  language="javascript">

		$(document).ready(function(){


	     $("#no_submitted_reports, #no_reporting_lhws").blur(function(e){

	      comparelessequal("no_reporting_lhws", "no_submitted_reports", "No of Submitted Reports cannot be greater then No of Working LHWs");

	    });



	     $("#no_dropout_thismonth, #no_reporting_lhws").blur(function(e){

	      comparelessequal("no_reporting_lhws", "no_dropout_thismonth", "No of Terminal/Dropout LHW should be less then No of Working LHWs");

	    });



	     $("#ms_r1_f2").blur(function(e){

	      comparelessequal("ms_r1_f1", "ms_r1_f2", "Available Kit Bags with No of LHWs should be greater than Functional Kit Bags with No of LHWs");

	    });



	     $("#ms_r2_f2").blur(function(e){

	      comparelessequal("ms_r2_f1", "ms_r2_f2", "Available Weighing Machines with No of LHWs should be greater than Functional Weighing Machines with No of LHWs");

	    });



	     $("#ms_r3_f2").blur(function(e){

	      comparelessequal("ms_r3_f1", "ms_r3_f2", "Available Thermometers with No of LHWs should be greater than Functional Thermometers with No of LHWs");

	    });



	     $("#ms_r4_f2").blur(function(e){

	      comparelessequal("ms_r4_f1", "ms_r4_f2", "Available Torch with Cell with No of LHWs should be greater than Functional Torch with Cell with No of LHWs");

	    });



	     $("#ms_r5_f2").blur(function(e){

	      comparelessequal("ms_r5_f1", "ms_r5_f2", "Available Scissors with No of LHWs should be greater than Functional Scissors with No of LHWs");

	    });



	     $("#ms_r6_f2").blur(function(e){

	      comparelessequal("ms_r6_f1", "ms_r6_f2", "Available Syringe Cuttur with No of LHWs should be greater than Functional Syringe Cuttur with No of LHWs");

	    });



	     $("#ms_r7_f2").blur(function(e){

	      comparelessequal("ms_r7_f1", "ms_r7_f2", "Available Others with No of LHWs should be greater than Functional Others with No of LHWs");

	    });



	   









			$(".numberclass").keydown(function(e){

				//alert(e.target.id);

				//alert(e.keyCode);

				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

							 // Allow: Ctrl+A, Command+A

							(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 

							 // Allow: home, end, left, right, down, up

							(e.keyCode >= 35 && e.keyCode <= 40)) {

								 // let it happen, don't do anything

								 return;

						}

						// Ensure that it is a number and stop the keypress

						if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

							e.preventDefault();

							$(this).val('0');

							$(this).select();

						}			

			});

			

			

			$(".numberclass").focus(function(e){

				$(this).select();

			});

			

			$('input,select, textarea').keypress(function(event) { return event.keyCode != 13; });



			$('.dateclass').datepicker({

				format: "yyyy-mm-dd",

				startDate: "2015-05-01",

				todayHighlight: true,

				beforeShowMonth: function (date){

								switch (date.getMonth()){

								  case 8:

									return false;

								}

							},

				toggleActive: true,

			});



			

			$('.receiveclass').datepicker({

				format: "yyyy-mm-dd",

				startDate: "2015-04-01",

				endDate: "2015-04-30",

				todayHighlight: true,

				beforeShowMonth: function (date){

								switch (date.getMonth()){

								  case 8:

									return false;

								}

							},

				toggleActive: true,

			});



		});

	  </script>
