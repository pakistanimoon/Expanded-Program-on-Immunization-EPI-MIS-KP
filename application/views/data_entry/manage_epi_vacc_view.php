<!--start of page content or body-->
 
 <div class="container bodycontainer">
  
<div class="row">
	
 <div class="panel panel-primary">
   <div class="panel-heading"> Management Of EPI Vaccines In Routine Immunization</div>
     <div class="panel-body">
      
        <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Month:</label>
          </div>
          <div class="col-md-2 col-sm-2">
          	
            <p><?php echo $vaccManagment->month; ?></p>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Year:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
            <p><?php echo $vaccManagment->year; ?></p>
          </div>
        </div>
          <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Union Council:</label>
          </div>
          <div class="col-md-2 col-sm-2">

           <p><?php echo $unioncouncil; ?></p>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Total Population:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
         	<p> <?php echo $vaccManagment->uc_tot_pop; ?></p>
          </div>
        </div>
          <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>District:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
            <p><?php echo $vaccManagment->distcode; ?></p>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Annual Target Population (Children &lt;1 Year):</label>
          </div>
          <div class="col-md-2 col-sm-2">
           
          	<p><?php echo $vaccManagment->uc_annual_pop_less_1year; ?></p>
          </div>
        </div>

            <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>Names of Vaccinators:</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
          <P><?php echo $vaccManagment->vaccinators_names; ?></P>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Monthly Target Population(Children &lt;1 Year):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
          	<p><?php echo $vaccManagment->uc_monthly_pop_less_1year; ?></p>
          </div>
        </div>
            <div class="row">
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Annual Target Population (Pregnant Women):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
          	<p> <?php echo $vaccManagment->uc_annual_target_pop_women; ?></p>
          </div>
          <div class="col-md-4 col-sm-4 cmargin27">
            <label>UC Monthly Target Population(Pregnant Women):</label>
          </div>
          <div class="col-md-2 col-sm-2">
            
          	<p><?php echo $vaccManagment->uc_monthly_target_pop_women; ?></p>
          </div>
        </div>

<div class="row bgrow1">
         
        </div>
        <div class="row">
          <div class="col-md-1 col-sm-1 btb flcfvr-c1 text-center" >
            <label>Item</label>
          </div>
          <div class="col-md-2 col-sm-2 ball">
            <div class="row">
              <div class="col-md-12 col-sm-12 bb">
                <label>Opening balance on 1st day of the month</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12 flcfvr-c2-r2 text-center">
                <label>Qty in doses/units</label>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-5 btrb">
            <div class="row">
              <div class="col-md-12 col-sm-12 text-center">
                <label>Vaccines, Syringes &amp; Safety Boxes Received From The District/Agency Store during the month</label>
              </div>              
            </div>
            <div class="row bt">
              <div class="col-md-3 col-sm-3 flcfvr-c3-r2-c1 text-center">
                <label>Date</label>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <label>Qty in Doses/Units</label>
              </div>
              <div class="col-md-3 col-sm-3 br flcfvr-c3-r2-c3 text-center">
                <label>Batch No.</label>
              </div>
              <div class="col-md-3 col-sm-3 flcfvr-c3-r2-c4 text-center">
                <label>Expiry Date</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 btb flcfvr-c4">
            <label class="lbl-flcfvr-qty-doses">Qty Utilized During the Month in Doses/Units</label>
          </div>
          <div class="col md-2 col-sm-2 ball">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <label>End balance on last day of the month 2+4-7</label>
              </div>
            </div>
            <div class="row bt">
              <div class="col-md-6 col-sm-6">
                <label class="lbl-flcfvr-qty-doses">Qty in Doses/Units</label>
              </div>
              <div class="col-md-6 col-sm-6 bl text-center">
                <label>Expiry Date</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 btb flcfvr-c6">
            <label>Remarks (If any)</label>
          </div>
        </div>


        <div class="row">
          <div class="col-md-1 col-sm-1 bb text-center">
            <label>1</label>
          </div>
          <div class="col-md-2 col-sm-2 brbl text-center">
           <label>2</label>
          </div>
          <div class="col-md-5 col-sm-5 brb">
         
            <div class="row">
              <div class="col-md-3 col-sm-3 text-center">
                <label>3</label>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <label>4</label>
              </div>
              <div class="col-md-3 col-sm-3 br text-center">
                <label>5</label>
              </div>
              <div class="col-md-3 col-sm-3 text-center">
                <label>6</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 bb text-center">
            <label>7</label>
          </div>
          <div class="col md-2 col-sm-2 brlb text-center">
            <div class="row">
              <div class="col-md-6 col-sm-6 bbl text-center">
                <label>8</label>
              </div>
              <div class="col-md-6 col-sm-6 brbl text-center">
                <label>9</label>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 bb text-center">
            <label>10</label>
          </div>
        </div>
        <?php
        $vaccTitles = array("BCG","BCG_diluent","tOPV","Pentavalent","Pneumococcal","Measles","Measles_diluent","Tetanus_Toxoid","AD_Syringes_005_ml","AD_Syringes_05_ml","Disposable_Reconstitution_Syringes_2ml","Disposable_Reconstitution_Syringes_5ml","Safety_Boxes"); 
        $i=0;
   		foreach($vaccTitles as $title){
        	$toMatch = str_replace('_', ' ', $title);
			$matchingTitle = str_insert($toMatch,'0','.');
        ?>
        <div class="row">
          <div class="col-md-1 col-sm-1 bb text-center flcfvr-r9-c1-v">
            <label class="lbl-flcfvr-pnemo"><?php echo $vaccTitelsArray[$i]['vacc_name']; ?></label>
          </div>
          <div class="col-md-2 col-sm-2 brbl text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['opening_balance_quantity']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['opening_balance_quantity']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['opening_balance_quantity']; }else{ echo '0'; } ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-5 col-sm-5 brb">
            <div class="row">
              <div class="col-md-3 col-sm-3 text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['recived_dur_month_date'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['recived_dur_month_date'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['recived_dur_month_date'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 brl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['recived_dur_month_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['recived_dur_month_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['recived_dur_month_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 br text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['recived_dur_month_batch']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                   
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['recived_dur_month_batch']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['recived_dur_month_batch']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-3 text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['recived_dur_month_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['recived_dur_month_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['recived_dur_month_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-2 bb text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
               
              <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['utilized_during_month']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['utilized_during_month']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
               
              <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['utilized_during_month']; }else{ echo '0'; } ?></p>
              </div>
            </div>
          </div>
          <div class="col md-2 col-sm-2 brlb text-center">
            <div class="row">
              <div class="col-md-6 col-sm-6 bbl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['end_balance_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['end_balance_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['end_balance_quantity']; }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-6 brbl text-center">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][0])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][0]['end_balance_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                   
                  <p><?php if(isset($titles[$matchingTitle][1])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][1]['end_balance_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    
                  <p><?php if(isset($titles[$matchingTitle][2])){ echo date("d-m-Y",strtotime($titles[$matchingTitle][2]['end_balance_expiry'])); }else{ echo '0'; } ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-sm-1 bb text-center">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][0])){ echo $titles[$matchingTitle][0]['remarks']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][1])){ echo $titles[$matchingTitle][1]['remarks']; }else{ echo '0'; } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                
              <p><?php if(isset($titles[$matchingTitle][2])){ echo $titles[$matchingTitle][2]['remarks']; }else{ echo '0'; } ?></p>
              </div>
            </div>
          </div>
        </div>
       <?php $i++; } ?>
        <div class="row rowmsr-filters row-signatures form-group">
          <label class="col-md-2  col-sm-3 cmargin29">Name of Vaccinator:</label>
          <div class="col-md-3 col-sm-3">
            
          <p><?php if(isset($vaccManagment)){ echo $vaccManagment->vacc_code; }else{ echo '0'; } ?></p>
          </div>
          <label class="col-md-1  col-sm-2">Date:</label>
          <div class="col-md-3 col-sm-3">
          	<?php $date=date('Y-m-d'); ?>
            
            <p><?php echo date('d-m-Y',strtotime($date)); ?></p>
          </div>
        </div>

         
        
        <div class="row">
         <hr>
         <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
            <div class="col-md-7 col-sm-7  cmargin21">
                
                <a href="#" onclick="history.go(-1);" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
          <?php } ?>
        </div>
      
  
        
         
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->