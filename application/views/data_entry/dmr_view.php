<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	 <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
   <div class="panel-heading"> Add New Monthly Reports By FLCF</div>
     <div class="panel-body">
      
        <div class="row bgrow1">
        1. Basic Information
        </div>
       <div class="row rowmr-filters">
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >District</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
         	<p><?php echo $districtname['district'];?></p>
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Total Number of UC</label>
        <div class="col-md-2  col-sm-3 col-xs-4">
          <p><?php echo $resultData['tot_uc']; ?></p>
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Total Number of EPI Centers</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
        <p><?php echo $resultData['tot_epi_center']; ?></p>
         </div>
       </div>
       <div class="row rowmr-filters">
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Month</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
          <p><?php echo $monthname;?></p>         
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Year</label>
        <div class="col-md-2  col-sm-3 col-xs-4">
           <p><?php echo $year;?></p>
        </div>
       </div>

         <div class="row rowbi rowmr-filters">
         <label class="col-xs-2 col-sm-2 control-label" >Type of Session</label>
         <label class="col-md-2 col-sm-2 control-label"  for="distcode">Sessions Planned</label>
         <label class="col-md-2 col-sm-2 control-label"  for="distcode">Sessions Conducted</label>
         <label class="col-md-4 col-sm-4 control-label"  for="distcode">a. District Total Population</label>
         <div class="col-md-2  col-sm-2 text-right">
           <p><?php echo $resultData['tot_population']; ?></p>
        </div>
       </div>
        <div class="row rowmr-filters">
         <label class="col-md-2 col-sm-2 control-label" >Fixed</label>
         <div class="col-md-2 col-sm-2 text-center">
         	<p><?php echo $resultData['fixed_planned']; ?></p>
         </div>

        <div class="col-md-2 col-sm-2 text-center">
        	<p><?php echo $resultData['fixed_conducted']; ?></p>
         </div>
         <label class="col-md-4 col-sm-4 control-label" for="distcode">b. Total Annual Target Children (3.5 % of a)</label>
         <div class="col-md-2  col-sm-2 text-right">
         	<p><?php echo $resultData['tot_target_children']; ?></p>
        </div>
       </div>
       <div class="row rowmr-filters">
         <label class="col-md-2 col-sm-2 control-label" for="mobile_planned">Mobile</label>
         <div class="col-md-2 col-sm-2 text-center">
         	<p><?php echo $resultData['mobile_planned']; ?></p>
         </div>

        <div class="col-md-2 col-sm-2 text-center">
        	<p><?php echo $resultData['mobile_conducted']; ?></p>
         </div>
         <label class="col-md-4 col-sm-4 control-label"  for="monthly_birth_target">c. Monthly Target (Births)(b/12)</label>
         <div class="col-md-2  col-sm-2 text-right">
         	<p><?php echo $resultData['monthly_birth_target']; ?></p>
         </div>
       </div>
       <div class="row rowmr-filters">
          <label class="col-md-2 col-sm-2 control-label" for="outreach_planned">Out reach</label>
         <div class="col-md-2 col-sm-2 text-center">
         	<p><?php echo $resultData['outreach_planned']; ?></p>
         </div>
         <div class="col-md-2 col-sm-2 text-center">
         	<p><?php echo $resultData['outreach_conducted']; ?></p>
         </div>
         <label class="col-md-4 col-sm-4 control-label" for="monthly_surviving_target">d. Surviving Infants Monthly Target (92.2% of c)</label>
         <div class="col-md-2  col-sm-2 text-right">
         	<p><?php echo $resultData['monthly_surviving_target']; ?></p>
         </div>
       </div>
       <div class="row rowmr-filters">
           <label class="col-md-2 col-sm-2 control-label" for="health_houses_planned">Health Houses</label>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['health_houses_planned']; ?></p>
           </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['health_houses_conducted']; ?></p>
           </div>
           <label class="col-md-4 col-sm-4 control-label" for="monthly_pregnant_target">e. Pregnant Ladies Monthly target (3.57% of a)</label>
           <div class="col-md-2  col-sm-2 text-right">
           	<p><?php echo $resultData['monthly_pregnant_target']; ?></p>
           </div>
        </div>
    
        <div class="row bgrow1">
        2. Children Vaccinated
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 text-center">
                <label>Type of Session</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Fixed</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Out reach</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Mobile</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Health House(LHW)</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Total</label>
            </div>
        </div>


 

           <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r1_f1">BCG</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r1_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r1_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r1_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r1_f4']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['bcg_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r2_f1">Polio-0</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r2_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           <p><?php echo $resultData['cv_r2_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r2_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r2_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['polio_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r3_f1">Birth Hep-B</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r3_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r3_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r3_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r3_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['birth_hepb_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r4_f1">Polio 1</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r4_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r4_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r4_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r4_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['polio_1_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r5_f1">Polio 2</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r5_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r5_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r5_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r5_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['polio_2_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r6_f1">Polio 3</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r6_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r6_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           <p><?php echo $resultData['cv_r6_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r6_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['polio_3_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r7_f1">Penta 1</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r7_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r7_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r7_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r7_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['penta_1_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r8_f1">Penta 2</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r8_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r8_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r8_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           <p><?php echo $resultData['cv_r8_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['penta_2_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r9_f1">Penta 3</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r9_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r9_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r9_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r9_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['penta_3_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" >PCV 1</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r10_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r10_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r10_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r10_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['pcv_1_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" >PCV 2</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r11_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r11_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r11_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           <p><?php echo $resultData['cv_r11_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['pcv_2_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r12_f1">PCV 3</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r12_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r12_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r12_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r12_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['pcv_3_total']; ?></p>
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r13_f1">Measles 1</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r13_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r13_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r13_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r13_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['measles_1_total']; ?></p>
           </div>
        </div>
            <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r14_f1">Measles 2</label>
            <div class="col-md-2 col-sm-2 text-center">
            	<p><?php echo $resultData['cv_r14_f1']; ?></p>
            </div>
           <div class="col-md-2 col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r14_f2']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r14_f3']; ?></p>
           </div>
           <div class="col-md-2  col-sm-2 text-center">
           	<p><?php echo $resultData['cv_r14_f4']; ?></p>
           </div>
            <div class="col-md-2  col-sm-2 text-center">
            	<p><?php echo $resultData['measles_2_total']; ?></p>
           </div>
        </div>
         <div class="row bgrow1">
        3. Women Vaccinated
        </div>
        <div class="row">
            <div class="col-md-1 col-sm-1">
                <label>Type of Session</label>
            </div>
            <div class="col-md-1 col-sm-1">

            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label >Fixed</label> 
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Out reach</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Mobile</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Health House(LHW)</label>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <label>Total</label>
            </div>
        </div>



        <div class="row">
            <div class="col-md-1 col-sm-1">
                <label class="lbl-fixed">TT-1</label>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">PL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">CBA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">Total</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    <p><?php echo $resultData['wv_r1_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r2_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt1_fixed_total']; ?></p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r1_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r2_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt1_outreach_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r1_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r2_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt1_mobile_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r1_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r2_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt1_healthhouse_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['tt1_pl_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['tt1_cba_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt1_all_total']; ?></p>
                    </div>
                </div>
            </div>
        </div> 




<div class="row row-wv">
            <div class="col-md-1 col-sm-1">
                <label class="lbl-fixed">TT-2</label>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">PL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">CBA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">Total</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r3_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r4_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt2_fixed_total']; ?></p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r3_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r4_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt2_outreach_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r3_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r4_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt2_mobile_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r3_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r4_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt2_healthhouse_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['tt2_pl_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['tt2_cba_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt2_all_total']; ?></p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row row-wv">
            <div class="col-md-1 col-sm-1">
                <label class="lbl-fixed">TT-3</label>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">PL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">CBA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">Total</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r5_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r6_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt3_fixed_total']; ?></p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r5_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r6_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt3_outreach_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r5_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r6_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt3_mobile_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r5_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r6_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt3_healthhouse_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['tt3_pl_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['tt3_cba_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt3_all_total']; ?></p>
                    </div>
                </div>
            </div>
        </div>



        <div class="row row-wv">
            <div class="col-md-1 col-sm-1">
                <label class="lbl-fixed">TT-4</label>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">PL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">CBA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">Total</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r7_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r8_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt4_fixed_total']; ?></p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r7_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r8_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt4_outreach_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r7_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r8_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt4_mobile_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r7_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r8_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt4_healthhouse_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['tt4_pl_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['tt4_cba_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt4_all_total']; ?></p>
                    </div>
                </div>
            </div>
        </div>



<div class="row row-wv">
            <div class="col-md-1 col-sm-1">
                <label class="lbl-fixed">TT-5</label>
            </div>
            <div class="col-md-1 col-sm-1">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">PL</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">CBA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                        <label class="lbl-setting4">Total</label>
                    </div>
                </div>
            </div> 
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r9_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r10_f1']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt5_fixed_total']; ?></p>
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r9_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r10_f2']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt5_outreach_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r9_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r10_f3']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt5_mobile_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['wv_r9_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['wv_r10_f4']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt5_healthhouse_total']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 text-center">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin5">
                    	<p><?php echo $resultData['tt5_pl_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin24">
                    	<p><?php echo $resultData['tt5_cba_total']; ?></p>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12 text-center cmargin25">
                    	<p><?php echo $resultData['tt5_all_total']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-signatures">
            <div class="col-md-2 col-sm-4" >
                <label class="lbl-setting4">EPI DSV Name</label>
            </div>
            <div class="col-md-2 col-sm-6 cmargin5">
            	<p><?php echo $resultData['dsv_name']; ?></p>
            </div>
             <div class="col-md-2 col-sm-4">
                <label class="lbl-setting4">EPI Coordinator Name</label>
            </div>
            <div class="col-md-2 col-sm-6 cmargin5">
            	<p><?php echo $resultData['cord_name']; ?></p>
            </div>
             <div class="col-md-2 col-sm-4">
                <label class="lbl-setting4">Name of DHO</label>
            </div>
            <div class="col-md-2 col-sm-6 cmargin5">
            	<p><?php echo $resultData['dho_name']; ?></p>
            </div>
        </div>


        <div class="row">
         <hr>
         <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div class="col-xs-7 cmargin21">
                <a href="<?php echo base_url(); ?>Data_entry/dmr_edit/<?php echo $resultData['distcode']; ?>/<?php echo $resultData['fmonth']; ?>" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update </a>
                <a href="<?php echo base_url(); ?>Data_entry/dmr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
         <?php } ?>
        </div>
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
