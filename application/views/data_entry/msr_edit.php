
<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Update Monthly Surveillance Report (Form A)</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>data_entry/msr_save">
       		<input type="hidden" id="edit" name="edit" value="edit" />
			<input type="hidden" id="recid" name="recid" value="<?= $resultData['id']; ?>" />
			<input type="hidden" id="facode" name="facode" value="<?= $resultFac['facode']; ?>" />
			<input type="hidden" id="year" name="year" value="<?php echo $year; ?>" />
			<input type="hidden" id="month" name="month" value="<?php echo $month; ?>" />
        <div class="row rowmsr-filters form-group">
          <label class="col-md-2 col-sm-2 cmargin23">Functional Centre</label>
          <div class="col-md-3  col-sm-3">
            <p class="cmargin20"><?php echo $resultFac['fac_name'];?></p>
          </div>
          <label class="col-md-1 col-md-offset-2 col-sm-2">Month</label>
          <div class="col-md-3 col-sm-3">
            <p class="cmargin20"><?php echo $monthname;?></p>
          </div>
        </div>
        <div class="row rowmsr-filters form-group">
          <label class="col-md-2 col-sm-2 cmargin23">District</label>
          <div class="col-md-3 col-sm-3">
           <p class="cmargin20"><?php echo $districtname['district'];?></p>
          </div>
          <label class="col-md-1 col-md-offset-2 col-sm-2">Year</label>
          <div class="col-md-3 col-sm-3">
            <p class="cmargin20"><?php echo $year;?></p>
          </div>
        </div>


        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left col-mr-deases">
            <label>Diseases</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid colmsrmid2">
            <label>Fully Vaccinated</label>
              <div class="row rcmr-cmid">
                <div class="col-md-3 col-sm-3">
                  <label>0-11 Months</label>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <label>1-4 Years</label>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <label>5-9 Years+</label>
                </div>
                <div class="col-md-3 col-sm-3">
                  <label>10-14 Years</label>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center col-mr-right">
            <label>Un Vaccinated</label>
              <div class="row rcmr-right">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <label>0-11 Months</label>
                </div>
                <div class="col-md-2 col-sm-2">
                  <label>1-4 Years</label>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <label>5-10 Years</label>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <label>10-14 Years</label>
                </div>
                <div class="col-md-4 col-sm-4">
                  <label class="lbl-padding">>14 Years</label>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>


         <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>AFP</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rcmr-cmid">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r1_f1" name="sr_r1_f1" value="<?php echo $resultData['sr_r1_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r1_f2" name="sr_r1_f2" value="<?php echo $resultData['sr_r1_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r1_f3" name="sr_r1_f3" value="<?php echo $resultData['sr_r1_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r1_f4" name="sr_r1_f4" value="<?php echo $resultData['sr_r1_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rcmr-right">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r1_f5" name="sr_r1_f5" value="<?php echo $resultData['sr_r1_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r1_f6" name="sr_r1_f6" value="<?php echo $resultData['sr_r1_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r1_f7" name="sr_r1_f7" value="<?php echo $resultData['sr_r1_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r1_f8" name="sr_r1_f8" value="<?php echo $resultData['sr_r1_f8']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r1_f9" name="sr_r1_f9" value="<?php echo $resultData['sr_r1_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>

        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Measles</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r2_f1" name="sr_r2_f1" value="<?php echo $resultData['sr_r2_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r2_f2" name="sr_r2_f2" value="<?php echo $resultData['sr_r2_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r2_f3" name="sr_r2_f3" value="<?php echo $resultData['sr_r2_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r2_f4" name="sr_r2_f4" value="<?php echo $resultData['sr_r2_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r2_f5" name="sr_r2_f5" value="<?php echo $resultData['sr_r2_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r2_f6" name="sr_r2_f6" value="<?php echo $resultData['sr_r2_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r2_f7" name="sr_r2_f7" value="<?php echo $resultData['sr_r2_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r2_f8" name="sr_r2_f8" value="<?php echo $resultData['sr_r2_f8']; ?>" placeholder="Number" type="number">
                </div>
               <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r2_f9" name="sr_r2_f9" value="<?php echo $resultData['sr_r2_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Neonatal Tetnaus</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r3_f1" name="sr_r3_f1" value="<?php echo $resultData['sr_r3_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r3_f2" name="sr_r3_f2" value="<?php echo $resultData['sr_r3_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r3_f3" name="sr_r3_f3" value="<?php echo $resultData['sr_r3_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r3_f4" name="sr_r3_f4" value="<?php echo $resultData['sr_r3_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r3_f5" name="sr_r3_f5" value="<?php echo $resultData['sr_r3_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r3_f6" name="sr_r3_f6" value="<?php echo $resultData['sr_r3_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r3_f7" name="sr_r3_f7" value="<?php echo $resultData['sr_r3_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r3_f8" name="sr_r3_f8" value="<?php echo $resultData['sr_r3_f8']; ?>" placeholder="Number" type="number">
                </div>
                 <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r3_f9" name="sr_r3_f9" value="<?php echo $resultData['sr_r3_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
              <div class="col-md-1 col-sm-1"></div>
          </div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Hepititus-B</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r4_f1" name="sr_r4_f1" value="<?php echo $resultData['sr_r4_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r4_f2" name="sr_r4_f2" value="<?php echo $resultData['sr_r4_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r4_f3" name="sr_r4_f3" value="<?php echo $resultData['sr_r4_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r4_f4" name="sr_r4_f4" value="<?php echo $resultData['sr_r4_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r4_f5" name="sr_r4_f5" value="<?php echo $resultData['sr_r4_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r4_f6" name="sr_r4_f6" value="<?php echo $resultData['sr_r4_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r4_f7" name="sr_r4_f7" value="<?php echo $resultData['sr_r4_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r4_f8" name="sr_r4_f8" value="<?php echo $resultData['sr_r4_f8']; ?>" placeholder="Number" type="number">
                </div>
               <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r4_f9" name="sr_r4_f9" value="<?php echo $resultData['sr_r4_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Purtussis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r5_f1" name="sr_r5_f1" value="<?php echo $resultData['sr_r5_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r5_f2" name="sr_r5_f2" value="<?php echo $resultData['sr_r5_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r5_f3" name="sr_r5_f3" value="<?php echo $resultData['sr_r5_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r5_f4" name="sr_r5_f4" value="<?php echo $resultData['sr_r5_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r5_f5" name="sr_r5_f5" value="<?php echo $resultData['sr_r5_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r5_f6" name="sr_r5_f6" value="<?php echo $resultData['sr_r5_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r5_f7" name="sr_r5_f7" value="<?php echo $resultData['sr_r5_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r5_f8" name="sr_r5_f8" value="<?php echo $resultData['sr_r5_f8']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r5_f9" name="sr_r5_f9" value="<?php echo $resultData['sr_r5_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Diphtheria</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r6_f1" name="sr_r6_f1" value="<?php echo $resultData['sr_r6_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r6_f2" name="sr_r6_f2" value="<?php echo $resultData['sr_r6_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r6_f3" name="sr_r6_f3" value="<?php echo $resultData['sr_r6_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r6_f4" name="sr_r6_f4" value="<?php echo $resultData['sr_r6_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r6_f5" name="sr_r6_f5" value="<?php echo $resultData['sr_r6_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r6_f6" name="sr_r6_f6" value="<?php echo $resultData['sr_r6_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r6_f7" name="sr_r6_f7" value="<?php echo $resultData['sr_r6_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r6_f8" name="sr_r6_f8" value="<?php echo $resultData['sr_r6_f8']; ?>" placeholder="Number" type="number">
                </div>
               <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r6_f9" name="sr_r6_f9" value="<?php echo $resultData['sr_r6_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Tuberclossis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r7_f1" name="sr_r7_f1" value="<?php echo $resultData['sr_r7_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r7_f2" name="sr_r7_f2" value="<?php echo $resultData['sr_r7_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r7_f3" name="sr_r7_f3" value="<?php echo $resultData['sr_r7_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r7_f4" name="sr_r7_f4" value="<?php echo $resultData['sr_r7_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r7_f5" name="sr_r7_f5" value="<?php echo $resultData['sr_r7_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r7_f6" name="sr_r7_f6" value="<?php echo $resultData['sr_r7_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r7_f7" name="sr_r7_f7" value="<?php echo $resultData['sr_r7_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r7_f8" name="sr_r7_f8" value="<?php echo $resultData['sr_r7_f8']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r7_f9" name="sr_r7_f9" value="<?php echo $resultData['sr_r7_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1">
            <label>Meningitis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r8_f1" name="sr_r8_f1" value="<?php echo $resultData['sr_r8_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r8_f2" name="sr_r8_f2" value="<?php echo $resultData['sr_r8_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r8_f3" name="sr_r8_f3" value="<?php echo $resultData['sr_r8_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r8_f4" name="sr_r8_f4" value="<?php echo $resultData['sr_r8_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r8_f5" name="sr_r8_f5" value="<?php echo $resultData['sr_r8_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r8_f6" name="sr_r8_f6" value="<?php echo $resultData['sr_r8_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r8_f7" name="sr_r8_f7" value="<?php echo $resultData['sr_r8_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r8_f8" name="sr_r8_f8" value="<?php echo $resultData['sr_r8_f8']; ?>" placeholder="Number" type="number">
                </div>
               <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r8_f9" name="sr_r8_f9" value="<?php echo $resultData['sr_r8_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr1b">
            <label>Pneumonia</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row">
                <div class="col-md-3 col-sm-3">
                  <input class="form-controlc" id="sr_r9_f1" name="sr_r9_f1" value="<?php echo $resultData['sr_r9_f1']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <input class="form-controlc" id="sr_r9_f2" name="sr_r9_f2" value="<?php echo $resultData['sr_r9_f2']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c3">
                  <input class="form-controlc" id="sr_r9_f3" name="sr_r9_f3" value="<?php echo $resultData['sr_r9_f3']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-3 col-sm-3 sub-c-4">
                  <input class="form-controlc" id="sr_r9_f4" name="sr_r9_f4" value="<?php echo $resultData['sr_r9_f4']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row">
                <div class="col-md-2 col-sm-2 sub-c5">
                  <input class="form-controlc" id="sr_r9_f5" name="sr_r9_f5" value="<?php echo $resultData['sr_r9_f5']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2">
                  <input class="form-controlc" id="sr_r9_f6" name="sr_r9_f6" value="<?php echo $resultData['sr_r9_f6']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c7">
                  <input class="form-controlc" id="sr_r9_f7" name="sr_r9_f7" value="<?php echo $resultData['sr_r9_f7']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-2 col-sm-2 sub-c8">
                  <input class="form-controlc" id="sr_r9_f8" name="sr_r9_f8" value="<?php echo $resultData['sr_r9_f8']; ?>" placeholder="Number" type="number">
                </div>
                <div class="col-md-4 col-sm-4 sub-c9">
                  <input class="form-controlc2" id="sr_r9_f9" name="sr_r9_f9" value="<?php echo $resultData['sr_r9_f9']; ?>" placeholder="Number" type="number">
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>

          <div class="row rowmsr-filters row-signatures form-group">
          <label class="col-md-2  col-sm-3 cmargin23">EPI Coordinator Name</label>
          <div class="col-md-3 col-sm-3">
            <input class="form-control" name="epi_cord_name" id="epi_cord_name" value="<?php echo $resultData['epi_cord_name']; ?>" placeholder="EPI Coordinator Name" type="text">
          </div>
          <label class="col-md-2 col-sm-2">Epidemiologist</label>
          <div class="col-md-3 col-sm-3">
            <input class="form-control" name="epi_demiologist_name" id="epi_demiologist_name" value="<?php echo $resultData['epi_demiologist_name']; ?>" placeholder="Epidemiologist Name" type="text">
          </div>
        </div>
        
        <div class="row">
         <hr>
            <div class="col-md-7 col-sm-7  cmargin21">
                <button type="submit" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save Form  </button>
                <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
                <a href="<?php echo base_url(); ?>data_entry/msr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

