
<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Monthly Vaccination Reporting Form (Health Facility)</div>
     <div class="panel-body">
		<form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <tbody>
          <tr>
            <td><label>Year</label></td>
            <td><?php if(isset($fmvrf_info)){
      				$fmonthArr = explode("-",$fmvrf_info["fmonth"]);
      				echo '<p>'.$fmonthArr[0].'</p>';
      			}?></td>
            <td><label>Month</label></td>
            <td>
              <?php if(isset($fmvrf_info)){
      				echo '<p>'.$fmonthArr[1].'</p>';
      			} ?>
            </td>
            <td><label>District</label></td>
            <td>
              <p>
        			<?php 
        				if(isset($fmvrf_info)){
        					echo get_District_Name($fmvrf_info["distcode"]);
        				}
        			?>
            </p>
            </td>
          </tr>
          <tr>
            <td><label>Tehsil</label></td>
            <td><p>
      			<?php 
      				if(isset($fmvrf_info)){
      					echo get_Tehsil_Name($fmvrf_info["tcode"]);
      				}
      			?> 
      			</p></td>
            <td><label>UC</label></td>
            <td>
              <p>
	          <?php 
	            if(isset($fmvrf_info)){
	              echo get_UC_Name($fmvrf_info["uncode"]);
	            }
	          ?>
            </p>
            </td>
            <td><label>Health Facility Name</label></td>
            <td>
              <p>
			<?php	
				if(isset($fmvrf_info)){
					echo get_Facility_Name($fmvrf_info["facode"]);
				}
			?> 
			</p>
            </td>
          </tr>
          <tr>
            <td><label>Health Facility Code</label></td>
            <td><p>
			<?php	
				if(isset($fmvrf_info)){
					echo $fmvrf_info["facode"];
				}
			?>
			</p> </td>
            <td colspan="2"><label>Monthly Target For Children 0-11</label></td>
            <td>
              <p><?php echo isset($fmvrf_info)?$fmvrf_info["tc_male"]:0; ?></p>
            </td>
            <td>
              <p><?php echo isset($fmvrf_info)?$fmvrf_info["tc_female"]:0; ?></p>
            </td>
          </tr>
          <tr>
            <td><label>Monthly Target for Pregnant Women</label></td>
            <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["pw_monthly_target"]:0; ?></p></td>
            <td><label>Total LHWs Attached</label></td>
            <td>
              <p><?php echo isset($fmvrf_info)?$fmvrf_info["tot_lhw_attached"]:0; ?></p>
            </td>
            <td><label>Total LHWs Involved in Vaccination</label></td>
            <td>
              <p><?php echo isset($fmvrf_info)?$fmvrf_info["tot_lhw_involved_vacc"]:0; ?></p>
            </td>
          </tr>
      </tbody>
    </table>
    
    <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="6" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">EPI Services</th>
            </tr>
            <tr>
              <th></th>
              <th>Fixed EPI Centers</th>
              <th colspan="2">Outreach Vaccination Session by Vaccinator/s</th>
              <th colspan="2">HH Vaccination Session by LHWs</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>Total</p></label>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["tot_fixed_centers"]:0; ?></p></td>
              <td style="text-align: center;"><label>Planned</label></td>
              <td style="text-align: center;"><label>Actually Held</label></td>
              <td style="text-align: center;"><label>Planned</label></td>
              <td style="text-align: center;"><label>Actually Held</label></td>
            </tr>
            <tr>
              <td><label>Functioning</label><br>
                  <label>Reporting</label>
              </td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["functioning_centers"]:0; ?></p>
                <p><p><?php echo isset($fmvrf_info)?$fmvrf_info["reporting"]:0; ?></p> 
              </td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["or_vacc_planned"]:0; ?></p></td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["or_vacc_held"]:0; ?></p></td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["hh_vacc_planned"]:0; ?></p></td>
              <td><p><?php echo isset($fmvrf_info)?$fmvrf_info["hh_vacc_held"]:0; ?></p></td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
             <tr>
                <th colspan="15" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">A. Childhood Routine Immunization</th>
              </tr> 
              <tr>
                <th rowspan="4">Vaccines</th>
                <th colspan="6">Vaccination by Vaccinator</th>
                <th colspan="6">House Hold (LHW)</th>
                <th rowspan="3" colspan="2">Total Children<br> Vaccinated</th>
              </tr>
              <tr>
                <th colspan="6">Vaccination Given to Children</th>
                <th colspan="6">Vaccination Given to Children</th>
              </tr>
              <tr>
                <th colspan="2">0-11 Months</th>
                <th colspan="2">12-23 Months</th>
                <th colspan="2">2 Years and Above</th>
                <th colspan="2">0-11 Months</th>
                <th colspan="2">12-23 Months</th>
                <th colspan="2">2 Years and Above</th>
              </tr> 
            <tr>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th>
              <th>F</th>
              <th>M</th><p style="background-color: #F5F5F5" >
              <th>F</th>
            </tr>
          </thead>
          <tbody>
          	<?php $names = array("BCG","Hep B","OPV-0","OPV-1","OPV-2","OPV-3","PENTA-1","PENTA-2","PENTA-3","PCV10-1","PCV10-2","PCV10-3","IPV","ROTA-1","ROTA-2","MEASLES-1","MEASLES-2","Fully Immunized"); 
		for($i=1; $i<=count($names); $i++){?>
             <tr>
              <td><label><?php echo $names[$i-1]; ?></label></td> 
              <td <?php echo $var='cri_r'.$i.'_f1'; ?> <?php if($var== 'cri_r17_f1'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?> </p></td>
              <td <?php echo $var='cri_r'.$i.'_f2'; ?> <?php if($var== 'cri_r17_f2'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f3'; ?> <?php if($var== 'cri_r1_f3' || $var =='cri_r2_f3' || $var =='cri_r3_f3' || $var =='cri_r13_f3'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f4'; ?> <?php if($var== 'cri_r1_f4' || $var =='cri_r2_f4' || $var =='cri_r3_f4' || $var =='cri_r13_f4'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p> <?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p> </td>
         	    <td <?php echo $var='cri_r'.$i.'_f5'; ?> <?php if($var== 'cri_r1_f5' || $var =='cri_r2_f5' || $var =='cri_r3_f5' || $var =='cri_r10_f5' || $var =='cri_r11_f5' || $var =='cri_r12_f5' || $var =='cri_r13_f5'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f6'; ?> <?php if($var== 'cri_r1_f6' || $var =='cri_r2_f6' || $var =='cri_r3_f6' || $var =='cri_r10_f6' || $var =='cri_r11_f6' || $var =='cri_r12_f6' || $var =='cri_r13_f6'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f7'; ?> <?php if($var== 'cri_r16_f7' || $var== 'cri_r17_f7'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f8'; ?> <?php if($var== 'cri_r16_f8' || $var== 'cri_r17_f8'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f9'; ?> <?php if($var== 'cri_r1_f9' || $var =='cri_r2_f9' || $var =='cri_r3_f9' || $var =='cri_r13_f9' || $var =='cri_r16_f9' || $var =='cri_r17_f9'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f10'; ?> <?php if($var== 'cri_r1_f10' || $var =='cri_r2_f10' || $var =='cri_r3_f10' || $var =='cri_r13_f10' || $var =='cri_r16_f10' || $var =='cri_r17_f10'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f11'; ?> <?php if($var== 'cri_r1_f11' || $var =='cri_r2_f11' || $var =='cri_r3_f11' || $var =='cri_r10_f11' || $var =='cri_r11_f11' || $var =='cri_r12_f11' || $var =='cri_r13_f11' || $var =='cri_r16_f11' || $var =='cri_r17_f11'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f12'; ?> <?php if($var== 'cri_r1_f12' || $var =='cri_r2_f12' || $var =='cri_r3_f12' || $var =='cri_r10_f12' || $var =='cri_r11_f12' || $var =='cri_r12_f12' || $var =='cri_r13_f12' || $var =='cri_r16_f12' || $var =='cri_r17_f12'){ echo 'style="background-color: #EEEEEE"'; } ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f13'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='cri_r'.$i.'_f14'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
             </tr>
             <?php } ?>
             
        <table class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
              <tr>
                <th colspan="9" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">B. TT Routine Immunization</th>
              </tr>
              <tr>
                <th rowspan="2">Vaccination</th>
                <th colspan="2">Fixed Centers</th>
                <th colspan="2">House Hold(LHW)</th>
                <th colspan="2">Total Vaccinated</th>
              </tr>
              <tr>
              <th>Pregnant Women</th>
              <th>Non-Pregnant Women (15-49 Years)</th>
              <th>Pregnant Women</th>
              <th>Non-Pregnant Women (15-49 Years)</th>
              <th>PL</th>
              <th>Non-PL</th>
            </tr>
          </thead>
          <tbody>
          	<?php $labels = array("TT-1","TT-2","TT-3","TT-4","TT-5","Children Protected at Birth"); 
		foreach($labels as $key => $value){?>
            <tr>
              <td><label><?php echo $value; ?></label></td>
              <td <?php echo $var='ttri_r'.($key+1).'_f1'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
              <td <?php echo $var='ttri_r'.($key+1).'_f2'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td> 
              <td <?php echo $var='ttri_r'.($key+1).'_f3'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td> 
              <td <?php echo $var='ttri_r'.($key+1).'_f4'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td> 
              <td <?php echo $var='ttri_r'.($key+1).'_f5'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td> 
              <td <?php echo $var='ttri_r'.($key+1).'_f6'; ?> ><p><?php echo (isset($fmvrf_info))? $fmvrf_info[$var]:'0'; ?></p></td>
            </tr>
            <?php } ?>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <tbody>
            <tr>
              <td><label>Name of Vaccinator</label></td>
              <td style="text-align:center;"><p><?php echo isset($fmvrf_info)?$fmvrf_info["vacc_name"]:"";?></p></td>
              <td><label>Name of LHS</label></td> 
              <td style="text-align:center;"><p><?php echo isset($fmvrf_info)?$fmvrf_info["lhsname"]:"";?></p></td>
              <td><label>Name of Facility Incharge</label></td>
              <td style="text-align:center;"><p><?php echo isset($fmvrf_info)?$fmvrf_info["incharge_name"]:"";?></p></td>
            </tr>
          </tbody>
        </table>
        <?php if (($this -> session -> UserLevel =='3') && ($this -> session -> utype=='DEO') ){ ?>
        <div class="row">
         <hr>
			      <div class="col-md-3 col-md-offset-9 col-sm-3">
                
                <a href="<?php echo base_url()."data_entry/fmvrf_edit/".$fmvrf_info["facode"]."/".$fmvrf_info["fmonth"]; ?>" class="btn btn-md btn-success" type="reset"><i class="fa fa-pencil-square-o"></i> Update </a>
                <a class="btn btn-md btn-success" href="<?php echo base_url()."HFMVRF/List"; ?>"  onclick="history.go(-1);" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
         <?php } ?>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>