<!--start of page content or body-->
<?php 
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Health Facility Questionnaire</div>
     <div class="panel-body">
      <form name="dataform" id="dataform" action="<?php echo base_url(); ?>Coldchain/rev_health_facility_questionnaire_pak_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
	   	<?php if(isset($qdata)){ ?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="id" id="id" value="<?php echo $qdata['id']; ?>" />
       	<?php } ?>
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td><input class="form-control" name="procode"  readonly="readonly" id="procode" placeholder="Khyber Pakhtunkhwa" type="text"></td>
              <td><label>2. District</label></td>
              <td><select id="distcode" name="distcode" class="form-control">
			    <?php if(!isset($qdata)){?>
					 <option value="0">Select</option>
					<?php } ?>
			 <?php foreach($resultDist as $row){ ?>
				
				   <option <?php if(isset($qdata) && $qdata['distcode'] == $row['distcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['distcode']; ?>" <?php echo set_select('distcode',$row['distcode']); ?> /><?php echo $row['district'];?></option>
				  <?php }  ?>
				</select>
			  </td>
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td>
                <select id="tcode" name="tcode" class="form-control text-left">
				 <?php if(!isset($qdata)){?>
					 <option value="0">Select</option>
					<?php } ?>
                    <?php 
                      foreach($resultTeh as $row){
                        ?>
                        <option <?php if(isset($qdata) && $qdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
                        <?php
                      }
                      ?>
                  </select>
              </td>
              <td><label>4. Union Council</label></td>
              <td><select id="uncode" name="uncode" class="form-control text-left">
			   <?php if(!isset($qdata)){?>
					 <option value="0">Select</option>
					<?php } ?>
                   <?php
                   foreach($resultUnC as $row){
               ?>
           
			  <option <?php if(isset($qdata) && $qdata['uncode'] == $row['uncode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['uncode']; ?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?></option>
               <?php }?>
                  </select></td>
            </tr>
            <tr>
              <td><label>5. Name of (Health/EPI) Facility</label></td>
              <td>  <select id="facode" name="facode" class="form-control text-left">
                     <?php if(!isset($qdata)){?>
					 <option value="0">Select</option>
					<?php } ?>
                      <?php
                   foreach($resultFac as $row){
				   ?>
			
				  <option <?php if(isset($qdata) && $qdata['facode'] == $row['facode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['facode']; ?>" <?php echo set_select('facode',$row['facode']); ?> /><?php echo $row['fac_name'];?></option>
				   <?php }?>
                  </select>
              </td>
              <td> </td>
              <td> </td>
            </tr>
            <tr>
              <td colspan="4"><label>6. Type of Health Facility: (Mark only ONE box)</label>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover    mytable2">
                  <tr>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "1"){ echo 'checked="checked"';} } ?> value="1" name="fatype" id="fatype" type="radio">National Vaccine Store</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "2"){ echo 'checked="checked"';} } ?> value="2" name="fatype" id="fatype" type="radio">Basic Health Unit</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "3"){ echo 'checked="checked"';} } ?> value="3" name="fatype" id="fatype" type="radio">Provincial Vaccine Store</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "4"){ echo 'checked="checked"';} } ?> value="4" name="fatype" id="fatype" type="radio">Dispensary</td>
                  </tr>
                  <tr>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "5"){ echo 'checked="checked"';} } ?> value="5" name="fatype" id="fatype" type="radio">District Vaccine Store</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "6"){ echo 'checked="checked"';} } ?> value="6" name="fatype" id="fatype" type="radio">MCH Center</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "7"){ echo 'checked="checked"';} } ?> value="7" name="fatype" id="fatype" type="radio">Tehsil/Taluka Vaccine Store</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "8"){ echo 'checked="checked"';} } ?> value="8" name="fatype" id="fatype" type="radio">CHC Com. Health Center</td>
                  </tr>
                  <tr>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "9"){ echo 'checked="checked"';} } ?> value="9" name="fatype" id="fatype" type="radio">DHQ hospital</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "10"){ echo 'checked="checked"';} } ?> value="10" name="fatype" id="fatype" type="radio">UHC Urban Health Center</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "11"){ echo 'checked="checked"';} } ?> value="11" name="fatype" id="fatype" type="radio">Tehsil/Taluka Hospital</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "12"){ echo 'checked="checked"';} } ?> value="12" name="fatype" id="fatype" type="radio">Hospital   &#8211; Private</td>
                  </tr>
                  <tr>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "13"){ echo 'checked="checked"';} } ?> value="13" name="fatype" id="fatype" type="radio">Teaching Hospital</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype'] == "14"){ echo 'checked="checked"';} } ?> value="14" name="fatype" id="fatype" type="radio">Clinic &#8211; Private</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "15"){ echo 'checked="checked"';} } ?> value="15" name="fatype" id="fatype" type="radio">Civil Hospital</td>
                    <td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "16"){ echo 'checked="checked"';} } ?> value="16" name="fatype" id="fatype" type="radio">Rural Health Centre</td>                    
                  </tr>
                  <tr>
                  	<td><input <?php if(isset($qdata)){ if($qdata['fatype']  == "17"){ echo 'checked="checked"';} } ?> value="17" name="fatype" id="fatype" type="radio">Other (Specify)<input class="form-control" name="other_fatype" id="other_fatype" type="text" style="float: right;width: 70%;margin-top: -5px;"></td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Health facility Immunisation Activities</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <label>7. Total Population in Area Served by Facility</label>
              </td>
              <td>
                <input class="form-control numberclass" name="tot_pop" id="tot_pop" value="<?php if(isset($qdata)){ echo $qdata['tot_pop']; } ?>" type="text" placeholder="(number of)">
              </td>
              <td></td><td></td>
              <tr><td>
                <label>8. Live Births Per Year in Area Served by Facility</label>
              </td>
              <td>
                <input class="form-control numberclass" id="live_births"  name="live_births" value="<?php if(isset($qdata)){ echo $qdata['live_births']; } ?>" type="text" placeholder="Click to Fill" data-toggle="collapse" data-target="#q8" readonly="readonly">
              </td><td></td><td></td>
            </tr>
            <tr>
              <td colspan="4">
                <div id="q8" class="collapse">
                  <table id="myTable">
                    <tr>
                      <td colspan="6"><label>BCG Inj Given During Last 3 Months From Daily EPI Register</label></td>
                    </tr>
                    <tr>
                      <td style="width: 7%;">1. Static</td>
                      <td class="t-row"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;">X</td>
                      <td style="width: 10%; text-align: center;">4</td>
                      <td style="width: 10%; text-align: center;">=</td>
                      <td><input class="form-control" type="text" id="res" readonly="readonly"></td>
                    </tr>
                    <tr>
                      <td style="width: 7%;">2. Outreach</td>
                      <td class="t-row1"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;">X</td>
                      <td style="width: 10%; text-align: center;">4</td>
                      <td style="width: 10%; text-align: center;">=</td>
                      <td><input class="form-control" type="text" id="res1"readonly="readonly"></td>
                    </tr>
                    <tr>
                      <td style="width: 7%;">3. Outreach</td>
                      <td class="t-row2"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;">X</td>
                      <td style="width: 10%; text-align: center;">4</td>
                      <td style="width: 10%; text-align: center;">=</td>
                      <td><input class="form-control" type="text" readonly="readonly"></td>
                      <td style="width: 15%; text-align: center;"><label>Answer (1+2+3)</label></td>
                       
                      <td><input class="form-control" id="total" type="text" readonly="readonly"></td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <label>9. Pregnant Women Per Year in Area Served by Facility</label>
              </td>
              <td>
                <input class="form-control numberclass" name="no_preg_women" id="no_preg_women" value="<?php if(isset($qdata)){ echo $qdata['no_preg_women']; } ?>" type="text" placeholder="(number of) Leave this blank">
              </td>
              <td>
                <label>10. Women of Child Bearing Age in Area Served by Facility</label>
              </td>
              <td>
                <input class="form-control numberclass" name="no_child_bearing_age" id="no_child_bearing_age" value="<?php if(isset($qdata)){ echo $qdata['no_child_bearing_age']; } ?>" type="text" placeholder="(number of) Leave this blank">
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <label>11a. Vaccine Storage</label><p  style="display: inline;"> Check box below ONLY if the facility has a refrigerator or freezer, even if broken. Otherwise leave blank.</p>
                <table>
                  <tr>
                    <td><input value="1" name="vaccine_storage" <?php if(isset($qdata)){ if($qdata['vaccine_storage']  == "1"){ echo 'checked="checked"';} } ?> id="vaccine_storage" type="checkbox"></td>
                  </tr>
                </table>
              </td>
              <td colspan="2"><label>11b. Type of Services Provided </label><p  style="display: inline;"> Mark ALL boxes that apply</p>
                <table>
                  <tr>
                    <td>
					 <?php 
					 if(isset($qdata)){
						$type_of_services=array();
					 $type_of_services= explode(',', $qdata['type_of_services']); }
			 ?>
                      <input value="1" name="type_of_services[]" <?php if(isset($qdata) && in_array("1",$type_of_services)){echo 'checked="checked"';} ?>  id="type_of_services" type="checkbox"> Outreach Immunisation Services<br>
                      <input value="2" name="type_of_services[]" <?php if(isset($qdata) && in_array("2",$type_of_services)){echo 'checked="checked"';} ?> id="type_of_services" type="checkbox"> Static Immunisation Services
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <label>12. EPI/Vaccination Staff: (Write number)</label>
              </td>
              <td colspan="3">
                <table class="table table-bordered   table-striped table-hover    mytable2" style="width:100%;">
                  <tr>
                    <td><p>Vaccinator/EPITech</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_vaccinators']; } ?>" name="epi_vaccinators" id="epi_vaccinators" type="text">
                    </td>
                    <td><p>LHVs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_lhvs']; } ?>" name="epi_lhvs" id="epi_lhvs" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>Disp/Health Tech</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_dispensers']; } ?>" name="epi_dispensers" id="epi_dispensers" type="text">
                    </td>
                    <td><p>LHSs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_lhss']; } ?>" name="epi_lhss" id="epi_lhss" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>Store Keeper</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_store_keepers']; } ?>" name="epi_store_keepers" id="epi_store_keepers" type="text">
                    </td>
                    <td><p>LHWs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_lhws']; } ?>" name="epi_lhws" id="epi_lhws" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>DSV</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_dsv']; } ?>" name="epi_dsv" id="epi_dsv" type="text">
                    </td>
                    <td><p>Cold Chain Technician</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_technicians_cc']; } ?>" name="epi_technicians_cc" id="epi_technicians_cc" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>ASV</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_asv']; } ?>" name="epi_asv" id="epi_asv" type="text">
                    </td>
                    <td><p>Others</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['epi_others']; } ?>" name="epi_others" id="epi_others" type="text">
                    </td>
                  </tr>
                  
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <label>13.  Training During Last One Year: (number of staff trained in CC/VM)</label>
              </td>
              <td colspan="3">
                <table class="table table-bordered   table-striped table-hover    mytable2" style="width:100%;">
                  <tr>
                    <td><p>Vaccinator/EPITech</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_vaccinators']; } ?>" name="trained_vaccinators" id="trained_vaccinators" type="text">
                    </td>
                    <td><p>LHVs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_lhvs']; } ?>" name="trained_lhvs" id="trained_lhvs" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>Disp/Health Tech</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_dispensers']; } ?>" name="trained_dispensers" id="trained_dispensers" type="text">
                    </td>
                    <td><p>LHSs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_lhss']; } ?>" name="trained_lhss" id="trained_lhss" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>Store Keeper</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_store_keepers']; } ?>" name="trained_store_keepers" id="trained_store_keepers" type="text">
                    </td>
                    <td><p>LHWs</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_lhws']; } ?>" name="trained_lhws" id="trained_lhws" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>DSV</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_dsv']; } ?>" name="trained_dsv" id="trained_dsv" type="text">
                    </td>
                    <td><p>Cold Chain Technician</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_technician_cc']; } ?>" name="trained_technician_cc" id="trained_technician_cc" type="text">
                    </td>
                  </tr>
                  <tr>
                    <td><p>ASV</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_asv']; } ?>" name="trained_asv" id="trained_asv" type="text">
                    </td>
                    <td><p>Others</p></td>
                    <td><input class="form-control numberclass" value="<?php if(isset($qdata)){ echo $qdata['trained_others']; } ?>" name="trained_others" id="trained_others" type="text">
                    </td>
                  </tr>
                  
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <label>14. Resupply Interval of Vaccines (in weeks)</label>
              </td>
              <td>
                <input class="form-control numberclass" id="gt" type="text" value="<?php if(isset($qdata)){ echo $qdata['resupply_interval']; } ?>" name="resupply_interval" placeholder="Click to Fill" data-toggle="collapse" data-target="#q14" readonly="readonly">
              </td>
              <td></td><td></td>
            </tr>
            <tr>
              <td colspan="4">
                <div id="q14" class="collapse">
                  <table id="mySecTable">
                    <tr>
                      <td colspan="6"><label>In Stock Register Number of Times BCG Received During Last 6 Months</label></td>
                    </tr>
                    <tr>
                      <td style="width: 2%;">A</td>
                      <td class="row1"><input class="form-control numberclass" id="disable1" type="text"></td>
                      <td style="width: 10%; text-align: center;">X</td>
                      <td style="width: 10%; text-align: center;">2</td>
                      <td style="width: 2%; text-align: center;">=</td>
                      <td><input class="form-control" id="sec14" readonly="readonly" type="text"></td>
                      <td style="width: 10%; text-align: center;">B</td>
                      
                      <td class="fifty1" style="text-align: center;">52</td>
                      <td style="width: 10%; text-align: center;">&divide;</td>
                      <td class="divide1"><input class="form-control numberclass" type="text" id="sec14Tab1" readonly="readonly"></td>
                      <td style="text-align: center; width: 2%;">=</td>
                      <td><input class="form-control" id="sec14Tab2" readonly="readonly" type="text"></td>
                      <td><label>Answer</label></td>
                    </tr>
                    <tr>
                      <td colspan="12">if only 3 months record found then</td>
                    </tr>
                    <tr>
                      <td style="width: 2%;">A</td>
                      <td class="row2"><input class="form-control numberclass" id="enable2" type="text"></td>
                      <td style="width: 10%; text-align: center;">X</td>
                      <td style="width: 10%; text-align: center;">4</td>
                      <td style="width: 2%; text-align: center;">=</td>
                      <td><input class="form-control" id="sec14a" readonly="readonly" type="text"></td>
                      <td style="width: 10%; text-align: center;">B</td>
                      
                      <td class="fifty2" style="text-align: center;">52</td>
                      <td style="width: 10%; text-align: center;">&divide;</td>
                      <td class="divide2"><input class="form-control numberclass" id="sec14aTab1"  readonly="readonly" type="text"></td>
                      <td style="text-align: center; width: 2%;">=</td>
                      <td><input class="form-control" readonly="readonly" id="sec14aTab2"  type="text"></td>
                      <td><label>Answer</label></td>
                    </tr>                  
                  </table>
                </div>
              </td>
            </tr>
            <tr><td><label>15.  Reserve Stock for all Antigens: (in weeks)</label></td>
              <td><input class="form-control numberclass"  type="text" value="<?php if(isset($qdata)){ echo $qdata['reserve_stock']; } ?>" name="reserve_stock" id="reserve_stock" placeholder="Click to Fill" data-toggle="collapse" data-target="#q15" readonly="readonly">
              </td><td></td><td></td>
            </tr>
            <tr>
              <td colspan="4">
                <div id="q15" class="collapse">
                  <table class="table table-bordered   table-striped table-hover    mytable2" id="mytable2">
                    <tbody>
                     
                    <tr>
                      <td style="width: 15%;"></td>
                      <td style="width: 5%;"></td>
                      <td style="text-align: center;"><p>Balance BCG</p></td>
                      <td style="width: 10%; text-align: center;"> </td>
                      <td style="width: 10%; text-align: center;"> </td>
                      <td style="width: 2%; text-align: center;"> </td>
                      <td colspan="2" style="text-align: center;"><p>Doses</p></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"><label style="padding-top: 6px;">Step 1</label></td>
                      <td style="width: 5%;"><p>1</p></td>
                      <td class="t-rowtable1"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r1" readonly="readonly" type="text"></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"> </td>
                      <td style="width: 5%;"><p>2</p></td>
                      <td class="t-rowtable2"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r2" readonly="readonly" type="text"></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"> </td>
                      <td style="width: 5%;"><p>3</p></td>
                      <td class="t-rowtable3"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r3" readonly="readonly" type="text"></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"> </td>
                      <td style="width: 5%;"><p>4</p></td>
                      <td class="t-rowtable4"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r4" readonly="readonly" type="text"></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"> </td>
                      <td style="width: 5%;"><p>5</p></td>
                      <td class="t-rowtable5"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r5" readonly="readonly" type="text"></td>
                    </tr>
                    <tr>
                      <td style="width: 15%;"> </td>
                      <td style="width: 5%;"><p>6</p></td>
                      <td class="t-rowtable6"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 10%; text-align: center;"><p>X</p></td>
                      <td style="width: 10%; text-align: center;"><p id="twenti">20</p></td>
                      <td style="width: 2%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input class="form-control" id="r6" readonly="readonly" placeholder="5000" type="text"></td>
                    </tr>
                    <tr>
                      <td style="text-align: right; padding-right: 30px;" colspan="6"><p>Total Balance</p></td>
                      <td colspan="2"><input id="grand" class="form-control" readonly="readonly" type="text"></td>
                      <td style="width: 5%; text-align: center;"><p>&divide;</p></td>
                      <td style="width: 5%; text-align: center;"><p id="6">6</p></td>
                      <td style="width: 5%; text-align: center;"><p>=</p></td>
                      <td><input id="rtotal" name="reserve_stock" class="form-control" readonly="readonly" type="text"></td>
                      <td style="width: 5%; text-align: center;"><label>Balance</label></td>
                    </tr>
                    <tr>
                      <td><label>Step 2</label></td>
                      <td colspan="12" style=""><p>Annual BCG Target</p></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2" class="t-stepTwoTable1"><input class="form-control numberclass" type="text"></td>
                      <td style="width: 5%; text-align: center;"><p>&divide;</p></td>
                      <td style="width: 5%; text-align: center;"><p>52</p></td>
                      <td style="width: 5%; text-align: center;"><p>X</p></td>
                      <td colspan="2" style="text-align: center;"><p>2</p></td>
                      <td style="width: 5%; text-align: center;"><p>=</p></td>
                      <td colspan="2"><input id="grandTotal" class="form-control numberclass" readonly="readonly" type="text"></td>
                      <td style="text-align: center;" colspan="2"><p>Weekly BCG Requirement</p></td>
                    </tr>
                    <tr>
                      <td><label>Step3</label></td>
                      <td colspan="5"><p>Balance/Weekly Req.</p></td>                 
                      <td colspan="2" style="text-align: center;"><input id="nro" class="form-control numberclass" readonly="readonly" type="text"></td>
                      <td style="text-align: center;"><p>&divide;</p></td>
                      <td colspan="1" class="stepTwoTable3" style="text-align: center;"><input id="sec15step2tot" readonly="readonly" class="form-control numberclass" type="text"></td>
                      <td style="text-align: center; width: 1%;"><p>=</p></td>
                      <td><input id="rs1" class="form-control" readonly="readonly" type="text">
                      </td><td><p>Answer</p></td>
                    </tr>
                    </tbody>          
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <label>16. Routine Immunisation Ice Pack Requirements</label>(litres/week) Enter 0 if no static or outreach services provided
              </td>
              <td><input class="form-control numberclass" id="sec16Total3" value="<?php if(isset($qdata)){ echo $qdata['routine_immune_req']; } ?>" name="routine_immune_req" type="text" placeholder="Click to Fill" data-toggle="collapse" data-target="#q16" readonly="readonly"></td>  
            </tr>
            <tr>
              <td colspan="4">
                <div id="q16" class="collapse">
                  <table class="table table-bordered   table-striped table-hover    mytable2" id="sec16Table1">
                    <tbody>
                      <tr>
                        <td colspan="3"></td>
                        <td colspan="2" style="text-align: center;"><p>Number of Days per Week</p></td>
                        <td colspan="5" style="text-align: center;"><p>Number of Session per Day</p></td>
                      </tr>
                      <tr>
                        <td><p>A.Static</p></td>
                        <td><p>4</p></td>
                        <td><p>X</p></td>
                        <td><input class="form-control numberclass" type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec16Field2"><input class="form-control numberclass" type="text"></td>
                        <td><p>=</p></td>
                        <td><input id="StepA" class="form-control" type="text" readonly="readonly"></td> 
                      </tr>
                      <tr>
                        <td><p>B.Outreach</p></td>
                        <td><p>4</p></td>
                        <td><p>X</p></td>
                        <td><input class="form-control numberclass" type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec16partBField2"><input class="form-control numberclass" type="text"></td>
                        <td><p>=</p></td>
                        <td><input id="StepB" class="form-control" type="text" readonly="readonly"></td> 
                      </tr>
                      <tr>
                        <td><p>B.Outreach</p></td>
                        <td><p>4</p></td>
                        <td><p>X</p></td>
                        <td><input class="form-control numberclass" type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec16partBField3"><input class="form-control numberclass" type="text"></td>
                        <td><p>=</p></td>
                        <td><input id="StepC" class="form-control" type="text" readonly="readonly"></td> 
                      </tr>
                      <tr>
                        <td colspan="6">
                          <p>If vaccine is Collected by Health Facility Staff Add</p>
                        </td>
                        <td><p>=</p></td>
                        <td style="text-align: center;"><p>3.5</p></td>
                      </tr>
                      <tr>
                         
                        <td style="text-align: right;" colspan="6"><p>Total(A+B+C)</p></td>
                        <td><p>=</p></td>
                        <td><input id="sec16Total" class="form-control" readonly="readonly" type="text"></td>
                        <td><p>Answer</p></td>
                      </tr>                    
                    </tbody>          
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td><label>17. SNID / NID Ice Pack Requirements</label>(litres/day)</td>
              <td><input class="form-control numberclass"  name="snid_req" id="sec171a" value="<?php if(isset($qdata)){ echo $qdata['snid_req']; } ?>" type="text" placeholder="Click to Fill" data-toggle="collapse" data-target="#q17" readonly="readonly"></td></td> <td></td><td></td>
            </tr>
            <tr>
              <td colspan="4">
                <div id="q17" class="collapse">
                  <table class="table table-bordered   table-striped table-hover    mytable2" id="sec17Table1">
                    <tbody>
                        <tr>
                          <td><p>A</p></td>
                          <td colspan="11"><p>Number of House to House Polio Teams</p></td>
                          <td><p>=</p></td>
                          <td><input id="sec17A" class="form-control numberclass" type="text"></td>
                        </tr>
                        <tr>
                          <td style="text-align: center;" colspan="3"><p>AIC</p></td>
                          <td style="text-align: center;"><p>Transit Team</p></td>
                          <td style="text-align: center;" colspan="3"><p>Fixed Sites</p></td>
                          <td><p>Roaming Teams</p></td>
                        </tr>
                       <tr>
                        <td><p>B</p></td>
                        <td class="sec17Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>+</p></td>
                        <td class="sec17Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>+</p></td>
                        <td class="sec17Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>+</p></td>
                        <td class="sec17Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input id="sec17res" class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>X</p></td>
                        <td><p>4</p></td>
                        <td><p>=</p></td>
                        <td><input id="totB" class="form-control"  type="text" readonly="readonly"></td>
                      </tr>
                      <tr>
                        <td colspan="12" style="text-align:right;"><p>Total(A+B)</p></td>
                        <td><p>=</p></td>
                        <td><input id="totAB" class="form-control"  type="text" readonly="readonly"><p>Answer</p></td>
                      </tr>              
                    </tbody>          
                  </table>
                  <table class="table table-bordered   table-striped table-hover    mytable2" id="sec17Table2">
                    <tbody>
                      <tr>
                        <td colspan="2"><label>Measurments for Ice Packs</label></td>
                        <td colspan="11"><p>Take Measurement in cms (LxHxW)/1000=Size of Ice Packs in Liter</p></td>
                      </tr>
                      <tr>
                        <td style="text-align:center;"><p>Total Present</p></td>
                        <td style="text-align:center;"><p>Length</p></td>
                        <td colspan="2" style="text-align:center;"><p>Height</p></td>
                        <td colspan="2" style="text-align:center;"><p>Width</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field1"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field1"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field2"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field2"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field2"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field2"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field3"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field3"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field3"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field3"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field4"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field4"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field4"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field4"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field5"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field5"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field5"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field5"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field6"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field6"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field6"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field6"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                      <tr>
                        <td class="sec17tab2Field7"><input class="form-control numberclass"  type="text"></td>
                        <td class="sec17tab2Field7"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field7"><input class="form-control numberclass"  type="text"></td>
                        <td><p>X</p></td>
                        <td class="sec17tab2Field7"><input class="form-control numberclass"  type="text"></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>&divide;</p></td>
                        <td><p>1000</p></td>
                        <td><p>=</p></td>
                        <td><input class="form-control"  type="text" readonly="readonly"></td>
                        <td><p>Liters</p></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <label>18. Distance to Vaccine Supply Source: (in kilometres)</label> 
              </td>
              <td><input class="form-control numberclass" name="distance_vss" value="<?php if(isset($qdata)){ echo $qdata['distance_vss']; } ?>" id="distance_vss" type="text"></td>
              <td colspan="2">
                <table style="width:100%;">
                  <tr>
                    <td colspan="2">
                      <label>19. Mode of Vaccine Supply: Mark only ONE box</label></td>
                      </tr>
                  <tr>
                    <td><input value="1" <?php if(isset($qdata)){ if($qdata['mode_vacc_supply']  == "1"){ echo 'checked="checked"';} } ?> name="mode_vacc_supply" id="mode_vacc_supply" type="radio"> Delivered</td>
                    <td><input value="2" <?php if(isset($qdata)){ if($qdata['mode_vacc_supply']  == "2"){ echo 'checked="checked"';} } ?> name="mode_vacc_supply" id="mode_vacc_supply" type="radio"> Both (Delivered and Collected)</td>
                  </tr>
                  <tr>
                    <td><input value="3" <?php if(isset($qdata)){ if($qdata['mode_vacc_supply']  == "3"){ echo 'checked="checked"';} } ?> name="mode_vacc_supply" id="mode_vacc_supply" type="radio"> Collected</td>
                    <td><input value="4" <?php if(isset($qdata)){ if($qdata['mode_vacc_supply']  == "4"){ echo 'checked="checked"';} } ?> name="mode_vacc_supply" id="mode_vacc_supply" type="radio"> Unknown</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <table style="width:100%;">
                  <tr>
                    <td colspan="4"><label>20. Health Care Waste Disposal:  Mark ALL boxes that apply</label></td>
                  </tr>
				  <?php 
				  if(isset($qdata)){ 
					$chklist=array();
					$chklist= explode(',', $qdata['waste_disposal']);
				  }
			
                 ?>
                  <tr>
                    <td><input value="1" <?php if(isset($qdata) && in_array("1",$chklist)){echo 'checked="checked"';} ?> name="waste_disposal[]" id="waste_disposal" type="checkbox"> Burn & Bury</td>
                    <td><input value="2" <?php if(isset($qdata) && in_array("2",$chklist)){echo 'checked="checked"';} ?> name="waste_disposal[]" id="waste_disposal" type="checkbox"> High Temperature Incineration</td>
                    <td><input value="3" <?php if(isset($qdata) && in_array("3",$chklist)){echo 'checked="checked"';} ?> name="waste_disposal[]" id="waste_disposal" type="checkbox"> Pit</td>
                    <td><input value="4" <?php if(isset($qdata) && in_array("4",$chklist)){echo 'checked="checked"';} ?> name="waste_disposal[]" id="waste_disposal" type="checkbox"> Collected and Transported to Higher Facility</td>
                    <td><input value="5" <?php if(isset($qdata) && in_array("5",$chklist)){echo 'checked="checked"';} ?> name="waste_disposal[]" id="waste_disposal" type="checkbox"> None</td>
                  </tr>
                </table>
              </td>
              <td>
                <table style="width:100%;">
                  <tr>
                    <td colspan="4"><label>21. Stock Outs in Past 3 Months: Mark only ONE box</label></td>
                  </tr>
                  <tr>
                    <td><input value="1" <?php if(isset($qdata)){ if($qdata['stock_out_3_months']  == "1"){ echo 'checked="checked"';} } ?> name="stock_out_3_months" id="stock_out_3_months" type="radio"> Yes</td>
                    <td><input value="2" <?php if(isset($qdata)){ if($qdata['stock_out_3_months']  == "2"){ echo 'checked="checked"';} } ?> name="stock_out_3_months" id="stock_out_3_months" type="radio"> No</td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2  mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Health Facility Energy Sources Available to Power Cold Chain Equipment</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="2">
                <table style="width:100%;">
                  <tr>
                    <td colspan="2">
                      <label>22. Grid Electricity Availability: Mark only ONE box</label>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input value="1" name="grid_elec_available" <?php if(isset($qdata)){ if($qdata['grid_elec_available']  == "1"){ echo 'checked="checked"';} } ?> id="grid_elec_available" type="radio">None</td>
                      <td><input value="2" name="grid_elec_available" <?php if(isset($qdata)){ if($qdata['grid_elec_available']  == "2"){ echo 'checked="checked"';} } ?> id="grid_elec_available" type="radio">Less Than 8 Hours Per Day</td>
                    </tr>
                    <tr>
                    <td>
                      <input value="3" name="grid_elec_available" <?php if(isset($qdata)){ if($qdata['grid_elec_available']  == "3"){ echo 'checked="checked"';} } ?> id="grid_elec_available" type="radio"> 8 to 16 Hours Per Day</td>
                      <td><input value="4" name="grid_elec_available" <?php if(isset($qdata)){ if($qdata['grid_elec_available']  == "4"){ echo 'checked="checked"';} } ?> id="grid_elec_available" type="radio"> More Than 16 Hours Per Day</td>
                    </tr>
                </table>
              </td>
              <td colspan="2">
                <table style="width:100%">
                  <tr>
                    <td><label>23. Solar Energy: Mark ALL boxes that apply</label>
                    </td>
                  </tr>
                  <tr>
				   <?php 
				   if(isset($qdata)){
				   $solar_energy=array();
				   $solar_energy= explode(',', $qdata['solar_energy']);}
			 ?>
					  
                    <td><input value="1" name="solar_energy[]" <?php if(isset($qdata) && in_array("1",$solar_energy)){echo 'checked="checked"';} ?>  type="checkbox">Facility Grounds Shaded From Sun More Than 1 hr/day</td>
                  </tr>
                  <tr>
                    <td><input value="2" name="solar_energy[]" <?php if(isset($qdata) && in_array("2",$solar_energy)){echo 'checked="checked"';} ?> type="checkbox">Heavy Clouds for Longer Than 2 Weeks at a Time</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <label>Person Responsible for Cold Chain at the Facility</label>
              </td>
              <td colspan="2">
                <label>Cold Chain Inventory Team Leader's Information</label>
              </td>
            </tr>
            <tr>
              <td><label>Name:</label></td>
              <td><input class="form-control" name="pr_name" value="<?php if(isset($qdata)){ echo $qdata['pr_name']; } ?>" id="pr_name" type="text"></td>
              <td><label>Name:</label></td>
              <td><input class="form-control" name="cctl_name" value="<?php if(isset($qdata)){ echo $qdata['cctl_name']; } ?>" id="cctl_name" type="text"></td>
            </tr>
            <tr>
              <td><label>Designation:</label></td>
              <td><input class="form-control" name="pr_desg" value="<?php if(isset($qdata)){ echo $qdata['pr_desg']; } ?>" id="pr_desg" type="text"></td>
              <td><label>Designation:</label></td>
              <td><input class="form-control" name="cctl_desg" value="<?php if(isset($qdata)){ echo $qdata['cctl_desg']; } ?>" id="cctl_desg" type="text"></td>
            </tr>
            <tr>
              <td><label>Mobile Number:</label></td>
              <td><input class="form-control" name="pr_mob" value="<?php if(isset($qdata)){ echo $qdata['pr_mob']; } ?>" id="pr_mob" type="text"></td>
              <td><label>Mobile Number:</label></td>
              <td><input class="form-control" name="cctl_mob" value="<?php if(isset($qdata)){ echo $qdata['cctl_mob']; } ?>" id="cctl_mob" type="text"></td>
            </tr>
            <tr>
              <td><label>Email:</label></td>
              <td><input class="form-control" name="pr_email" value="<?php if(isset($qdata)){ echo $qdata['pr_email']; } ?>" id="pr_email" type="text"></td>
              <td><label>Email:</label></td>
              <td><input class="form-control" name="cctl_email" value="<?php if(isset($qdata)){ echo $qdata['cctl_email']; } ?>" id="cctl_email" type="text"></td>
            </tr>
            <tr>
              <td><label>Date:</label></td>
              <td><input class="form-control dp" name="pr_date" value="<?php if(isset($qdata)){ echo  date('d-m-Y',strtotime($qdata['pr_date'])); } ?>" id="pr_date" type="text"></td>
              <td><label>Date:</label></td>
              <td><input class="form-control dp" name="cctl_date" value="<?php if(isset($qdata)){ echo  date('d-m-Y',strtotime($qdata['cctl_date'])); } ?>" id="cctl_date" type="text"></td>
            </tr>
            <tr>
              <td colspan="4">
                <label >Data Collector's Information</label>
              </td>
            </tr>
            <tr>
              <td><label>Name:</label></td>
              <td><input class="form-control" name="dc_name" value="<?php if(isset($qdata)){ echo $qdata['dc_name']; } ?>" id="dc_name" type="text"></td>
              <td><label>Designation:</label></td>
              <td><input class="form-control" name="dc_desg" value="<?php if(isset($qdata)){ echo $qdata['dc_desg']; } ?>" id="dc_desg" type="text"></td>
            </tr>
            <tr>
              <td><label>Email:</label></td>
              <td><input class="form-control" name="dc_email" value="<?php if(isset($qdata)){ echo $qdata['dc_email']; } ?>" id="dc_email" type="text"></td>
              <td><label>Mobile No:</label></td>
              <td><input class="form-control" name="dc_mob" value="<?php if(isset($qdata)){ echo $qdata['dc_mob']; } ?>" id="dc_mob" type="text"></td>
            </tr>
            <tr>
              <td><label>Date</label></td>
              <td><input class="form-control dp" name="dc_date" value="<?php if(isset($qdata)){ echo  date('d-m-Y',strtotime($qdata['dc_date'])); } ?>" id="dc_date" type="text"></td>
			   <td><label>Date Submitted:</label></td>
              <td><input class="form-control" name="date_submitted" readonly="readonly"  value="<?php  echo $current_date;  ?>" id="date_submitted" type="text"></td>
            </tr>
          </table>
          <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url();?>HF-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
<!--JS -->

<script type="text/javascript" src="<?php echo base_url();?>includes/js/mycoldchainfunctions.js"></script>
 