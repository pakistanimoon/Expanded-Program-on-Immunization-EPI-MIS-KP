<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	 <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
   <div class="panel-heading"> Add New Monthly Reports By FLCF</div>
     <div class="panel-body">
       <form class="form-horizontal" action="<?php echo base_url(); ?>data_entry/dmr_save" method="post">
        <div class="row bgrow1">
        1. Basic Information
        </div>
       <div class="row rowmr-filters">
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >District</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
          <select id="distcode" name="distcode" class="form-control" >
            <?php foreach($result1 as $row){	?>
					<option selected value="<?=$row['distcode'];?>" /><?=$row['district'];?>
			<?php }	?>
          </select>
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Total Number of UC</label>
        <div class="col-md-2  col-sm-3 col-xs-4">
          <input  value="<?php echo $tot_uc['tot_uc']; ?>" id="total_uc" name="total_uc" placeholder="Number" type="number" class="form-control" >
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Total Number of EPI Centers</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
        <input name="tot_epi_centers" id="tot_epi_centers" value="<?php echo $tot_epi_center['tot_epi_center']; ?>" placeholder="Number" type="number" class="form-control"  >
         </div>
       </div>
       <div class="row rowmr-filters">
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Month</label>
        <div class="col-md-2 col-sm-3 col-xs-4">
          <select  id="month" name="month" class="form-control" >
            <?php
              $monthName = array("January", "February", "March", "April", "May", "June", "July", "August", "September","October", "November", "December");
              for ($i=0; $i < count($monthName); $i++){                          
                  $mn = 1 + $i;
                  $mn = sprintf("%02d", $mn);
                  $lastmonth = strtotime("last month");
                  $lastmonth = date("m",$lastmonth);
                  if($mn == $lastmonth){                             
                    echo "<option selected value=" . $mn . ">" . $monthName[$i] . "</option> \n";
                    break;
                  }                          
                  else{                             
                    echo "<option value=" . $mn . ">" . $monthName[$i] . "</option> \n";
                  }                       
			  }
            ?>
          </select>
         
        </div>
        <label class="col-md-2 col-sm-3 col-xs-2 control-label" >Year</label>
        <div class="col-md-2  col-sm-3 col-xs-4">
           <select  id="year" name="year" class="form-control" >
	    	   <option value="2015" >2015</option>                                    
			   <option value="2014" >2014</option>
			   <option value="2013" >2013</option>
           </select>
        </div>
       </div>

         <div class="row rowbi rowmr-filters">
         <label class="col-xs-2 col-sm-2 control-label" >Type of Session</label>
         <label class="col-md-2 col-sm-2 control-label"  for="distcode">Sessions Planned</label>
         <label class="col-md-2 col-sm-2 control-label"  for="distcode">Sessions Conducted</label>
         <label class="col-md-4 col-sm-4 control-label"  for="distcode">a. District Total Population</label>
         <div class="col-md-2  col-sm-2">
           <input class=" form-control" name="tot_population" id="tot_population" value="<?php echo $dist_population['dist_population']; ?>" placeholder="Number" type="number"  >
        </div>
       </div>
        <div class="row rowmr-filters">
         <label class="col-md-2 col-sm-2 control-label" >Fixed</label>
         <div class="col-md-2 col-sm-2">
         <input class=" form-control" name="fixed_planned" id="fixed_planned" value="0" placeholder="Number" type="number" >
         </div>

        <div class="col-md-2 col-sm-2">
         <input class=" form-control" name="fixed_conducted" id="fixed_conducted" value="0" placeholder="Number" type="number" >
         </div>
         <label class="col-md-4 col-sm-4 control-label" for="distcode">b. Total Annual Target Children (3.5 % of a)</label>
         <div class="col-md-2  col-sm-2">
          <input class=" form-control" name="tot_target_children" id="tot_target_children" value="<?php echo $target_children; ?>" placeholder="Number" type="number" >
        </div>
       </div>
       <div class="row rowmr-filters">
         <label class="col-md-2 col-sm-2 control-label" for="mobile_planned">Mobile</label>
         <div class="col-md-2 col-sm-2">
         <input class=" form-control" name="mobile_planned" id="mobile_planned" value="0" placeholder="Number" type="number" >
         </div>

        <div class="col-md-2 col-sm-2">
         <input class=" form-control" name="mobile_conducted" id="mobile_conducted" value="0" placeholder="Number" type="number" >
         </div>
         <label class="col-md-4 col-sm-4 control-label"  for="monthly_birth_target">c. Monthly Target (Births)(b/12)</label>
         <div class="col-md-2  col-sm-2">
           <input class=" form-control" name="monthly_birth_target" id="monthly_birth_target" value="<?php echo $monthly_births; ?>" placeholder="Number" type="number" >
         </div>
       </div>
       <div class="row rowmr-filters">
          <label class="col-md-2 col-sm-2 control-label" for="outreach_planned">Out reach</label>
         <div class="col-md-2 col-sm-2">
          <input class=" form-control" name="outreach_planned" id="outreach_planned" value="0" placeholder="Number" type="number" >
         </div>
         <div class="col-md-2 col-sm-2">
         <input class=" form-control" name="outreach_conducted" id="outreach_conducted" value="0" placeholder="Number" type="number" >
         </div>
         <label class="col-md-4 col-sm-4 control-label" for="monthly_surviving_target">d. Surviving Infants Monthly Target (92.2% of c)</label>
         <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="monthly_surviving_target" id="monthly_surviving_target" value="<?php echo $surviving_infants; ?>" placeholder="Number" type="number" >
         </div>
       </div>
       <div class="row rowmr-filters">
           <label class="col-md-2 col-sm-2 control-label" for="health_houses_planned">Health Houses</label>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control" name="health_houses_planned" id="health_houses_planned" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control" name="health_houses_conducted" id="health_houses_conducted" value="0" placeholder="Number" type="number" >
           </div>
           <label class="col-md-4 col-sm-4 control-label" for="monthly_pregnant_target">e. Pregnant Ladies Monthly target (3.57% of a)</label>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="monthly_pregnant_target" id="monthly_pregnant_target" value="<?php echo $pregnent_ladies; ?>" placeholder="Number" type="number" />
           </div>
        </div>
        
    
        <div class="row bgrow1">
        2. Children Vaccinated
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2">
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
            <div class="col-md-2 col-sm-2">
               <input type="number" class=" form-control _first1" onblur="inputOne(this.value,this.id)"  name="cv_r1_f1" id="cv_r1_f1" value="0" placeholder="Number" />
            </div>
           <div class="col-md-2 col-sm-2">
            <input type="number" class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r1_f2" id="cv_r1_f2" value="0" placeholder="Number" />
           </div>
           <div class="col-md-2  col-sm-2">
            <input type="number" class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r1_f3" id="cv_r1_f3" value="0" placeholder="Number" />
           </div>
           <div class="col-md-2  col-sm-2">
            <input type="number" class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r1_f4" id="cv_r1_f4" value="0" placeholder="Number" />
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="bcg_total" id="bcg_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r2_f1">Polio-0</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r2_f1" id="cv_r2_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r2_f2" id="cv_r2_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r2_f3" id="cv_r2_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r2_f4" id="cv_r2_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="polio_0_total" id="polio_total" value="0" placeholder="Number" readonly="readonly">
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r3_f1">Birth Hep-B</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r3_f1" id="cv_r3_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r3_f2" id="cv_r3_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r3_f3" id="cv_r3_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r3_f4" id="cv_r3_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="birth_hepB_total"  id="birth_hepB_total" value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r4_f1">Polio 1</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r4_f1" id="cv_r4_f1" value="0" placeholder="Number"  type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r4_f2" id="cv_r4_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r4_f3" id="cv_r4_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r4_f4" id="cv_r4_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="polio_1_total" id="polio_1_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r5_f1">Polio 2</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r5_f1" id="cv_r5_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)"  name="cv_r5_f2" id="cv_r5_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r5_f3" id="cv_r5_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r5_f4" id="cv_r5_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="polio_2_total" id="polio_2_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r6_f1">Polio 3</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r6_f1" id="cv_r6_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)"  name="cv_r6_f2" id="cv_r6_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r6_f3" id="cv_r6_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r6_f4" id="cv_r6_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="polio_3_total" id="polio_3_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r7_f1">Penta 1</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r7_f1" id="cv_r7_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r7_f2" id="cv_r7_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r7_f3" id="cv_r7_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r7_f4" id="cv_r7_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="penta_1_total" id="penta_1_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r8_f1">Penta 2</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r8_f1" id="cv_r8_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" id="cv_r8_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r8_f3" id="cv_r8_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r8_f4" id="cv_r8_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="penta_2_total" id="penta_2_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r9_f1">Penta 3</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r9_f1" id="cv_r9_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r9_f2" id="cv_r9_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r9_f3" id="cv_r9_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r9_f4" id="cv_r9_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="penta_3_total" id="penta_3_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" >PCV 1</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r10_f1" id="cv_r10_f1"  value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r10_f2" id="cv_r10_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r10_f3" id="cv_r10_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r10_f4" id="cv_r10_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="pcv_1_total" id="pcv_1_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" >PCV 2</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r11_f1" id="cv_r11_f1"  value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r11_f2" id="cv_r11_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)" name="cv_r11_f3" id="cv_r11_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r11_f4" id="cv_r11_f4"  value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="pcv_2_total" id="pcv_2_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r12_f1">PCV 3</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)" name="cv_r12_f1" id="cv_r12_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r12_f2" id="cv_r12_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)"  name="cv_r12_f3" id="cv_r12_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r12_f4" id="cv_r12_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="pcv_3_total" id="pcv_3_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
        <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r13_f1">Measles 1</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)"  name="cv_r13_f1" id="cv_r13_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r13_f2" id="cv_r13_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)"  name="cv_r13_f3" id="cv_r13_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r13_f4" id="cv_r13_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="measles_1_total" id="measles_1_total"  value="0" placeholder="Number" readonly="readonly" >
           </div>
        </div>
            <div class="row">
            <label class="col-md-2 col-sm-2 control-label lbl-setting5" for="cv_r14_f1">Measles 2</label>
            <div class="col-md-2 col-sm-2">
               <input class=" form-control _first1" onblur="inputOne(this.value,this.id)"  name="cv_r14_f1" id="cv_r14_f1" value="0" placeholder="Number" type="number" >
            </div>
           <div class="col-md-2 col-sm-2">
            <input class=" form-control _second2" onblur="inputTwo(this.value,this.id)" name="cv_r14_f2" id="cv_r14_f2" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _third3" onblur="inputThree(this.value,this.id)"  name="cv_r14_f3" id="cv_r14_f3" value="0" placeholder="Number" type="number" >
           </div>
           <div class="col-md-2  col-sm-2">
            <input class=" form-control _fourth4" onblur="inputFour(this.value,this.id)" name="cv_r14_f4" id="cv_r14_f4" value="0" placeholder="Number" type="number" >
           </div>
            <div class="col-md-2  col-sm-2">
            <input class=" form-control" name="measles_2_total" id="measles_2_total"  value="0" placeholder="Number" readonly="readonly" >
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
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r1_f1" id="wv_r1_f1"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r2_f1" id="wv_r2_f1"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt1_fixed_total" id="tt1_fixed_total"  value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r1_f2" id="wv_r1_f2"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r2_f2" id="wv_r2_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt1_outreach_total" id="tt1_outreach_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r1_f3" id="wv_r1_f3"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r2_f3" id="wv_r2_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt1_mobile_total" id="tt1_mobile_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r1_f4" id="wv_r1_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r2_f4" id="wv_r2_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt1_healthhouse_total" id="tt1_healthhouse_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first_total" name="tt1_pl_total" id="tt1_pl_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second_total" name="tt1_cba_total" id="tt1_cba_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _all_total" name="tt1_all_total" id="tt1_all_total" value="0" placeholder="Number" readonly="readonly" >
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
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r3_f1" id="wv_r3_f1"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r4_f1" id="wv_r4_f1"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt2_fixed_total" id="tt2_fixed_total"  value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r3_f2" id="wv_r3_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r4_f2" id="wv_r4_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt2_outreach_total" id="tt2_outreach_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r3_f3" id="wv_r3_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r4_f3" id="wv_r4_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt2_mobile_total" id="tt2_mobile_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r3_f4" id="wv_r3_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r4_f4" id="wv_r4_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt2_healthhouse_total" id="tt2_healthhouse_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first_total" name="tt2_pl_total" id="tt2_pl_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second_total" name="tt2_cba_total" id="tt2_cba_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _all_total" name="tt2_all_total" id="tt2_all_total" value="0" placeholder="Number" readonly="readonly" >
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
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r5_f1" id="wv_r5_f1"  value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r6_f1" id="wv_r6_f1" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt3_fixed_total" id="tt3_fixed_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r5_f2" id="wv_r5_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r6_f2" id="wv_r6_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt3_outreach_total" id="tt3_outreach_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r5_f3" id="wv_r5_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r6_f3" id="wv_r6_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt3_mobile_total" id="tt3_mobile_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r5_f4" id="wv_r5_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r6_f4" id="wv_r6_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt3_healthhouse_total" id="tt3_healthhouse_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first_total" name="tt3_pl_total" id="tt3_pl_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second_total" name="tt3_cba_total" id="tt3_cba_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _all_total" name="tt3_all_total" id="tt3_all_total" value="0" placeholder="Number" readonly="readonly" >
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
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r7_f1" id="wv_r7_f1" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r8_f1" id="wv_r8_f1" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt4_fixed_total" id="tt4_fixed_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r7_f2" id="wv_r7_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r8_f2" id="wv_r8_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt4_outreach_total" id="tt4_outreach_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r7_f3" id="wv_r7_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r8_f3" id="wv_r8_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt4_mobile_total" id="tt4_mobile_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r7_f4" id="wv_r7_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r8_f4" id="wv_r8_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt4_healthhouse_total" id="tt4_healthhouse_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first_total" name="tt4_pl_total" id="tt4_pl_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second_total" name="tt4_cba_total" id="tt4_cba_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _all_total" name="tt4_all_total" id="tt4_all_total" value="0" placeholder="Number" readonly="readonly" >
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
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r9_f1" id="wv_r9_f1" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r10_f1" id="wv_r10_f1" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt5_fixed_total" id="tt5_fixed_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r9_f2" id="wv_r9_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r10_f2" id="wv_r10_f2" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt5_outreach_total" id="tt5_outreach_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r9_f3" id="wv_r9_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r10_f3" id="wv_r10_f3" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt5_mobile_total" id="tt5_mobile_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first" onblur="addWomenVacinated(this.id)" name="wv_r9_f4" id="wv_r9_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second" onblur="addWomenVacinated(this.id)" name="wv_r10_f4" id="wv_r10_f4" value="0" placeholder="Number" type="number" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _third" name="tt5_healthhouse_total" id="tt5_healthhouse_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _first_total" name="tt5_pl_total" id="tt5_pl_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _second_total" name="tt5_cba_total" id="tt5_cba_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
                 <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <input class=" form-control _all_total" name="tt5_all_total" id="tt5_all_total" value="0" placeholder="Number" readonly="readonly" >
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-signatures">
            <div class="col-md-2 col-sm-4">
                <label class="lbl-setting4">EPI DSV Name</label>
            </div>
            <div class="col-md-2 col-sm-6">
                <input class="form-control" name="dsv_name" id="dsv_name" placeholder="EPI DSV Name" type="text" >
            </div>
             <div class="col-md-2 col-sm-4">
                <label class="lbl-setting4">EPI Coordinator Name</label>
            </div>
            <div class="col-md-2 col-sm-6">
                <input class="form-control" name="cord_name" id="cord_name" placeholder="EPI Coordinator Name" type="text" >
            </div>
             <div class="col-md-2 col-sm-4">
                <label class="lbl-setting4">Name of DHO</label>
            </div>
            <div class="col-md-2 col-sm-6">
               <input class="form-control" name="dho_name" id="dho_name" placeholder="Name of DHO" type="text" >
            </div>
        </div>


        <div class="row">
         <hr>
            <div class="col-xs-7 cmargin21">
                <button type="submit" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save </button>
                <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset</button>
                <a href="<?php echo base_url(); ?>Data_entry/dmr_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->

<script src="<?php echo base_url(); ?>includes/dmr.js"></script>
