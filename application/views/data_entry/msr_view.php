<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> View Monthly Serveillance Report (Form A)</div>
     <div class="panel-body">
        <div class="row  form-group">
          <label class="col-md-2 col-sm-2 cmargin23">Functional Centre</label>
          <div class="col-md-3  col-sm-3">
            <p><?php echo $resultFac['fac_name']; ?></p>
          </div>
          <label class="col-md-1 col-md-offset-2 col-sm-2">Month</label>
          <div class="col-md-3 col-sm-3">
            <p><?php echo $monthname; ?></p>
          </div>
        </div>
        <div class="row  form-group">
          <label class="col-md-2 col-sm-2 cmargin23">District</label>
          <div class="col-md-3 col-sm-3">
            <p><?php echo $districtname['district']; ?></p>
          </div>
          <label class="col-md-1 col-md-offset-2 col-sm-2">Year</label>
          <div class="col-md-3 col-sm-3">
            <p><?php echo $year; ?></p>
          </div>
        </div>


        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left col-mr-deases">
            <label>Diseases</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid colmsrmid2">
            <label>Fully Vaccinated</label>
              <div class="row rcmr-cmid2">
                <div class="col-md-3 col-sm-3">
                  <label>0-11 Months</label>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2">
                  <label>1-4 Years</label>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b">
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
                <div class="col-md-2 col-sm-2 sub-c52">
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
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>AFP</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row  rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r1_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r1_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r1_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r1_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rcmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r1_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                 <p><?php echo $resultData['sr_r1_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r1_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r1_f8']; ?></p>
                </div>
                <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r1_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>

        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Measles</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r2_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r2_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r2_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r2_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r2_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r2_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r2_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r2_f8']; ?></p>
                </div>
               <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r2_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Neonatal Tetnaus</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r3_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r3_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r3_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r3_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r3_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r3_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r3_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r3_f8']; ?></p>
                </div>
                 <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r3_f9']; ?></p>
                </div>
              </div>
              <div class="col-md-1 col-sm-1"></div>
          </div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Hepititus-B</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r4_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r4_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r4_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r4_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r4_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r4_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r4_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r4_f8']; ?></p>
                </div>
               <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r4_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Purtussis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r5_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r5_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r5_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r5_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r5_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r5_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r5_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r5_f8']; ?></p>
                </div>
                <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r5_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Diphtheria</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r6_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r6_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r6_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r6_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r6_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r6_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r6_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r6_f8']; ?></p>
                </div>
               <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r6_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Tuberclossis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                 <p><?php echo $resultData['sr_r7_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r7_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r7_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r7_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r7_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r7_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r7_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r7_f8']; ?></p>
                </div>
                <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r7_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr2">
            <label>Meningitis</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r8_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r8_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r8_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r8_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r8_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r8_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r8_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r8_f8']; ?></p>
                </div>
               <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r8_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>
        <div class="row rowmsr-set">
          <div class="col-md-2 col-sm-2 text-left cmsr3">
            <label>Pneumonia</label>
          </div>
          <div class="col-md-4 col-sm-4 text-center colmsrmid">
            
              <div class="row rmr-left rmr-left1">
                <div class="col-md-3 col-sm-3 cmargin26">
                  <p><?php echo $resultData['sr_r9_f1']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c2 cmargin26">
                  <p><?php echo $resultData['sr_r9_f2']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3 sub-c3b cmargin26">
                  <p><?php echo $resultData['sr_r9_f3']; ?></p>
                </div>
                <div class="col-md-3 col-sm-3  cmargin26">
                  <p><?php echo $resultData['sr_r9_f4']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-5 col-sm-5 text-center">
            
              <div class="row rmr-right rmr-right1">
                <div class="col-md-2 col-sm-2 sub-c52 cmargin26">
                  <p><?php echo $resultData['sr_r9_f5']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 cmargin26">
                  <p><?php echo $resultData['sr_r9_f6']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c7 cmargin26">
                  <p><?php echo $resultData['sr_r9_f7']; ?></p>
                </div>
                <div class="col-md-2 col-sm-2 sub-c8 cmargin26">
                  <p><?php echo $resultData['sr_r9_f8']; ?></p>
                </div>
                <div class="col-md-4 col-sm-4 sub-c9 cmargin26">
                  <p><?php echo $resultData['sr_r9_f9']; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-1 col-sm-1"></div>
        </div>

          <div class="row rowmsr-filters row-signatures form-group">
          <label class="col-md-2  col-sm-3 cmargin23">EPI Coordinator Name</label>
          <div class="col-md-3 col-sm-3 cmargin5">
            <p><?php echo $resultData['epi_cord_name']; ?></p>
          </div>
          <label class="col-md-2 col-sm-2">Epidemiologist</label>
          <div class="col-md-3 col-sm-3 cmargin5">
            <p><?php echo $resultData['epi_demiologist_name']; ?></p>
          </div>
        </div>
        
        <div class="row">
         <hr>
         <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div class="col-md-7 col-sm-7  cmargin21">
                <a href="<?php echo base_url(); ?>Data_entry/msr_edit/<?php echo $resultData['facode']; ?>/<?php echo $resultData['fmonth']; ?>" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update </a>
                <a href="<?php echo base_url(); ?>Data_entry/msr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
          <?php } ?>  
        </div>

    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>