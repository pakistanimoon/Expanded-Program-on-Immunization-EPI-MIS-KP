<!--start of page content or body-->
<?php 
//print_r($optionsQ);exit;
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Refrigerator / FRreezer / ILR Questionnaire</div>
     <div class="panel-body">
      <form name="dataform" id="dataform" action="<?php echo base_url(); ?>Coldchain/refrigerator_questionnaire_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
	  <?php if(isset($rdata)){ ?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="id" id="id" value="<?php echo $rdata['id']; ?>" />
       	<?php } ?>
        <table class="table table-striped table-hover    mytable2">
          <tbody>
            <tr>
              <td><label>EQUIPMENT RECORD </label></td>
              <td><input class="form-control" name="equip_rec" value="<?php if(isset($rdata)){ echo $rdata['equip_rec']; } ?>" id="equip_rec" type="text"></td>
              <td><label>OF</label></td>
              <td><input class="form-control" name="rec_of" value="<?php if(isset($rdata)){ echo $rdata['rec_of']; } ?>" id="rec_of" type="text"></td>
              <td><p>(Fill in a separate form for each piece of equipment at health facility and number all forms) </p></td>
            </tr>           
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Identification</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td><input class="form-control" name="procode" readonly="readonly" id="procode" placeholder="Khyber Pakhtunkhwa" type="text"></td>
              <td><label>2. District</label></td>
              <td><select id="distcode" name="distcode" class="form-control text-center">
      			  <?php if(!isset($rdata)){?>
      					 <option value="0">Select</option>
      			  <?php } ?>
                   <?php foreach($resultDist as $row){ ?>
    					<option <?php if(isset($rdata) && $rdata['distcode'] == $row['distcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['distcode']; ?>" <?php echo set_select('distcode',$row['distcode']); ?> /><?php echo $row['district'];?></option>
    				  <?php }  ?>
    				</select>
    			   </td>    
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td><select id="tcode" name="tcode" class="form-control text-center">
        					 <?php if(!isset($rdata)){?>
        						<option value="0">Select</option>
        					<?php } ?>                 
        					<?php 
                      foreach($resultTeh as $row){
                        ?>
                        <option <?php if(isset($rdata) && $rdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
                        <?php
                      }
                      ?>
                  </select>
                 </td>
              <td><label>4. Union Council</label></td>
              <td>
			   <option value="0"></option>
			  <select id="uncode" name="uncode" class="form-control text-center">
			   <?php if(!isset($rdata)){?>
      					 <option value="0">Select</option>
      			  <?php } ?>
                            <?php
      					   foreach($resultUnC as $row){  ?>
      						<option <?php if(isset($rdata) && $rdata['uncode'] == $row['uncode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['uncode']; ?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?></option>
      				   <?php }?>
                        </select>
                      </td>
                  </tr>
                  <tr>
              <td><label>5. Name of (Health/EPI) Facility</label></td>
              <td><select id="facode" name="facode" class="form-control text-center">
                    <?php if(!isset($rdata)){?>
					 <option value="0">Select</option>
					<?php } ?>
					<?php
                   foreach($resultFac as $row){
				   ?>
					<option <?php if(isset($rdata) && $rdata['facode'] == $row['facode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['facode']; ?>"  /><?php echo $row['fac_name'];?></option>
				   <?php }?>
                  </select>
                </td>
				              <td><label>6. Equipment Code</label></td>
              <td style="width: 33%;">
			    <?php 
				  if(isset($rdata)){ 
					$equip_code=array();
					$equip_code= explode('-', $rdata['equip_code']);
				  } 
          ?>
               
                <table style="width:100%">
                  <tr>
                    <td><input class="form-control" value="3" readonly="readonly" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_1" value="<?php if(isset($rdata)){ echo $equip_code[0]; } ?>" id="equip_1" type="text"></td>
                    <td><input class="form-control" name="equip_2" value="<?php if(isset($rdata)){ echo $equip_code[1]; } ?>" id="equip_2" type="text"></td>
                    <td><input class="form-control" name="equip_3" value="<?php if(isset($rdata)){ echo $equip_code[2]; } ?>" id="equip_3" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_4" value="<?php if(isset($rdata)){ echo $equip_code[3]; } ?>" id="equip_4" type="text"></td>
                  </tr>
                </table>
              </td>
			 </tr>
			 <tr>
			  <td><label>7. Year </label></td>
			  <td><select id="year" name="year" class="form-control text-center">
				<?php echo $optionsY; ?>
			  </select>
			  </td>
			  <td><label>8. Quarter </label></td>
			  <td><select id="quarter" name="quarter" class="form-control text-center">
				<?php if(isset($optionsQ)){
					 echo $optionsQ; 
				} ?>
			  </select>
			  </td>
            </tr>            
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Refrigerator or Freezer Information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="3"><label>7. Catalogue ID</label> (Catalogue ID is found in the Equipment Identification Booklet and starts with the letter E for PQS prequalified equipment. If equipment is not identified, in the Equipment Identification Booklet, also fill in questions #15-19.)</td>
              <td><label>E</label><input class="form-control" name="catalogue_id" value="<?php if(isset($rdata)){ echo $rdata['catalogue_id']; } ?>" id="catalogue_id" type="text" style="float: right; width: 90%;"></td>
             </tr>
            <tr>
              <td><label>8. Serial number</label> (located on equipment or assigned serial number)</td>
              <td><input class="form-control" value="<?php if(isset($rdata)){ echo $rdata['serial_number']; } ?>" name="serial_number" id="serial_number" type="text"></td>
              <td><label>9. Year of first use</label> (estimate if information is not available)</td>
              <td><input class="form-control" value="<?php if(isset($rdata)){ echo $rdata['year_first_use']; } ?>" name="year_first_use" id="year_first_use" type="text"></td>
            </tr>
            <tr>
              <td colspan="2"><label>10. Working status</label> 
                <table>
                  <tr>
                    <td>
                      <input value="1" <?php if(isset($rdata)){ if($rdata['working_status']  == "1"){ echo 'checked="checked"';} } ?> name="working_status" id="working_status" type="radio"> Working well<br>
                      <input value="2" <?php if(isset($rdata)){ if($rdata['working_status']  == "2"){ echo 'checked="checked"';} } ?> name="working_status" id="working_status" type="radio"> Working but needs maintenance <br>
                      <input value="3" <?php if(isset($rdata)){ if($rdata['working_status']  == "3"){ echo 'checked="checked"';} } ?> name="working_status" id="working_status" type="radio"> Not working
                    </td>
                  </tr>
                </table>
              </td>
              <td colspan="2"><label>11. Reason Equipment not Working:</label> (Check ALL boxes that apply, leave blank if equipment is working ) 
                <table>
				 <?php 
					  if(isset($rdata)){ 
						$equip_not_working_reason=array();
						$equip_not_working_reason= explode(',', $rdata['equip_not_working_reason']);
					  }
					?>
                  <tr>
                    <td>
                      <input value="1" name="equip_not_working_reason[]" <?php if(isset($rdata) && in_array("1",$equip_not_working_reason)){echo 'checked="checked"';} ?> id="equip_not_working_reason" type="checkbox"> Spare parts are not available for repair/maintenance<br> 
                      <input value="2" name="equip_not_working_reason[]" <?php if(isset($rdata) && in_array("2",$equip_not_working_reason)){echo 'checked="checked"';} ?> id="equip_not_working_reason" type="checkbox"> Finance is not available for repair/maintenance<br> 
                      <input value="3" name="equip_not_working_reason[]" <?php if(isset($rdata) && in_array("3",$equip_not_working_reason)){echo 'checked="checked"';} ?> id="equip_not_working_reason" type="checkbox"> Not in use because electricity or fuel is not available<br>
                      <input value="4" name="equip_not_working_reason[]" <?php if(isset($rdata) && in_array("4",$equip_not_working_reason)){echo 'checked="checked"';} ?> id="equip_not_working_reason" type="checkbox"> Equipment needs to be boarded off

                    </td>
                  </tr>
                </table>
              </td>
            </tr>  
            <tr>
              <td colspan="2"><label>12. Equipment Utilisation</label>  
                <table>
                  <tr>
                    <td>
                      <input value="1" <?php if(isset($rdata)){ if($rdata['equip_utilisation']  == "1"){ echo 'checked="checked"';} } ?> name="equip_utilisation" id="equip_utilisation" type="radio"> In use <br>
                      <input value="2" <?php if(isset($rdata)){ if($rdata['equip_utilisation']  == "2"){ echo 'checked="checked"';} } ?> name="equip_utilisation" id="equip_utilisation" type="radio"> Not in use and available for re-allocation   <br>
                      <input value="3" <?php if(isset($rdata)){ if($rdata['equip_utilisation']  == "3"){ echo 'checked="checked"';} } ?> name="equip_utilisation" id="equip_utilisation" type="radio"> Not in use and not available for re-allocation<br>
                      Verify directly with health facility representative this equipment is available for re-allocation
                    </td>
                  </tr>
                </table>
              </td>
              <td colspan="2"><label>13. How is Temperature Monitored?</label> (Check ALL boxes that apply) 
                <table>
				 <?php 
					  if(isset($rdata)){ 
						$temp_monitored=array();
						$temp_monitored= explode(',', $rdata['temp_monitored']);
					  }
					?>
                  <tr>
                    <td>
                      <input value="1" <?php if(isset($rdata) && in_array("1",$temp_monitored)){echo 'checked="checked"';} ?> name="temp_monitored[]" id="temp_monitored" type="checkbox"> No Monitoring Device  <br> 
                      <input value="2" <?php if(isset($rdata) && in_array("2",$temp_monitored)){echo 'checked="checked"';} ?> name="temp_monitored[]" id="temp_monitored" type="checkbox"> Stem Thermometer  <br> 
                      <input value="3" <?php if(isset($rdata) && in_array("3",$temp_monitored)){echo 'checked="checked"';} ?> name="temp_monitored[]" id="temp_monitored" type="checkbox"> FridgeTag<span style="vertical-align: top; font-size: 11px;">TM</span> <br>
                      <input value="4" <?php if(isset($rdata) && in_array("4",$temp_monitored)){echo 'checked="checked"';} ?> name="temp_monitored[]" id="temp_monitored" type="checkbox"> Dial Thermometer

                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="4"><label>14. No. of temperature alarms in past 30 days:</label> (Enter number of days on the temperature monitoring form when temperature is above +8C or below +2C:) 
                <table>
                  <tr>
                    <td>Above +8C:</td><td><input style="width: 90%; padding-right: 10px; margin-left: 10px;" value="<?php if(isset($rdata)){ echo $rdata['no_temp_alarms_above']; } ?>" class="form-control numberclass" name="no_temp_alarms_above" id="no_temp_alarms_above" type="text"></td><td>days</td>
                    <td style="width:100px;"></td>
                    <td>Below +2C: </td><td><input style="width: 90%; padding-right: 10px; margin-left: 10px;" value="<?php if(isset($rdata)){ echo $rdata['no_temp_alarms_below']; } ?>" class="form-control numberclass" name="no_temp_alarms_below" id="no_temp_alarms_below" type="text"></td><td>days</td>
                  </tr>
                </table>
                </td>
              </tr>              
              <tr>
                <td colspan="2"><label>Fill in questions #15-19 when equipment ID is not found in the Equipment Identification Booklet.</label>
                </td>
                <td><label>Equipment ID not found</label> <input value="No" name="equip_found" id="equip_notfound" type="radio" data-toggle="collapse" data-target="#15to19" > 
                </td>
                <td><label>Equipment ID found</label><input value="Yes" name="equip_found" id="equip_found" type="radio"  >  
                </td>
              </tr>
              <tr>
              <td colspan="4">
                <div id="15to19" class="collapse">
                  <table class="table table-bordered   table-striped table-hover    mytable2">
                    <tr>
                      <td><label>15. Model name</label></td>
                      <td><input class="form-control" name="model_name" value="<?php if(isset($rdata)){ echo $rdata['model_name']; } ?>" id="model_name" type="text"></td>
                      <td><label>16. Manufacturer / Make</label></td>
                      <td><input class="form-control" name="manufacturer" value="<?php if(isset($rdata)){ echo $rdata['manufacturer']; } ?>" id="manufacturer" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>17. Is there a CFC-free sticker on the equipment?</label>                         
                      </td>
                      <td>
                        <table style="width: 100%; margin-top: 8px;">
                          <tr>
                          <td><input value="1" <?php if(isset($rdata)){ if($rdata['cfc_sticker']  == "1"){ echo 'checked="checked"';} } ?> name="cfc_sticker" id="cfc_sticker" type="radio"> Yes</td>
                          <td><input value="2" <?php if(isset($rdata)){ if($rdata['cfc_sticker']  == "2"){ echo 'checked="checked"';} } ?> name="cfc_sticker" id="cfc_sticker" type="radio"> No</td>
                          </tr>
                        </table>
                      </td>
                      <td colspan="2"><label>18. Refrigerator/Freezer Type</label>
                        <table  style="width: 100%;">
                          <tr>
                            <td><input value="1" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "1"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest freezer, AC electricity </td>
                            <td><input value="2"  <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "2"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest freezer, electricity & gas</td>
                          </tr>
                          <tr>
                            <td><input value="3" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "3"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest freezer, electricity & kerosene </td>
                            <td><input value="4" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "4"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest refrigerator, AC electricity</td>
                          </tr>
                          <tr>
                            <td><input value="5" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "5"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest refrigerator, DC electricity </td>
                            <td><input value="6" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "6"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest refrigerator, electricity & gas</td>
                          </tr>
                          <tr>
                            <td><input value="7" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "7"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Chest refrigerator, electricity & kerosene </td>
                            <td><input value="8" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "8"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Icepack freezer, AC electricity</td>
                          </tr>
                          <tr>
                            <td><input value="9" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "9"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Icepack freezer, electricity & gas </td>
                            <td><input value="10" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "10"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Icepack freezer, electricity & kerosene </td>
                          </tr>
                          <tr>
                            <td><input value="11" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "11"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Icelined refrigerator </td>
                            <td><input value="12" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "12"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Solar photovoltaic refrigerator</td>
                          </tr>
                          <tr>
                            <td><input value="13" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "13"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Upright refrigerator, AC electricity </td>
                            <td><input value="14" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "14"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Upright refrigerator, DC electricity</td>
                          </tr>
                          <tr>
                            <td><input value="15" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "15"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Upright refrigerator, electricity & gas </td>
                            <td><input value="16" <?php if(isset($rdata)){ if($rdata['refrigerator_type']  == "16"){ echo 'checked="checked"';} } ?> name="refrigerator_type" id="refrigerator_type" type="radio"> Upright  refrigerator, electricity & kerosene</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label>19. Internal storage dimensions</label><br>(Measure with provided tape in cm.)</td>
                      <td colspan="3">
                        <table class="table table-bordered   table-striped table-hover    mytable2" style="width: 100%;">
                          <tr>
                            <td style="text-align: center;" colspan="3"><label>+4   &#176;C</label></td>
                            <td style="text-align: center;" colspan="3"><label>-20    &#176;C</label></td>
                          </tr>
                          <tr>
                            <td><input class="form-control numberclass" name="plus_length" value="<?php if(isset($rdata)){ echo $rdata['plus_length']; } ?>" id="plus_length" type="text" placeholder="L(cm)"></td>
                            <td><input class="form-control numberclass" name="plus_width" value="<?php if(isset($rdata)){ echo $rdata['plus_width']; } ?>" id="plus_width" type="text" placeholder="W(cm)"></td>
                            <td><input class="form-control numberclass" name="plus_height" value="<?php if(isset($rdata)){ echo $rdata['plus_height']; } ?>" id="plus_height" type="text" placeholder="H(cm)"></td>
                            <td><input class="form-control numberclass" name="minus_length" value="<?php if(isset($rdata)){ echo $rdata['minus_length']; } ?>" id="minus_length" type="text" placeholder="L(cm)"></td>
                            <td><input class="form-control numberclass" name="minus_width" value="<?php if(isset($rdata)){ echo $rdata['minus_width']; } ?>" id="minus_width" type="text" placeholder="W(cm)"></td>
                            <td><input class="form-control numberclass" name="minus_height" value="<?php if(isset($rdata)){ echo $rdata['minus_height']; } ?>" id="minus_height" type="text" placeholder="H(cm)"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>              
                  </table>
                </div>
              </td>
            </tr>
            <tr>
              <td>
                <label>20. Calculated internal storage volume</label>
                (litres)       <br>LEAVE BLANK -  FOR USE BY NATIONAL TEAM ONLY
              </td>
              <td colspan="3">
                        <table class="table table-bordered   table-striped table-hover    mytable2" style="width: 100%;">
                          <tr>
                            <td style="text-align: center;" colspan="2"><label>+4   &#176;C</label></td>
                            <td style="text-align: center;" colspan="2"><label>-20    &#176;C</label></td>
                          </tr>
                          <tr>
                            <td><input class="form-control numberclass" name="plus_gross" value="<?php if(isset($rdata)){ echo $rdata['plus_gross']; } ?>" id="plus_gross" type="text" placeholder="Gross"></td>
                            <td><input class="form-control numberclass" name="plus_net" value="<?php if(isset($rdata)){ echo $rdata['plus_net']; } ?>" id="plus_net" type="text" placeholder="Net"></td>
                            <td><input class="form-control numberclass" name="minus_gross" value="<?php if(isset($rdata)){ echo $rdata['minus_gross']; } ?>" id="minus_gross" type="text" placeholder="Gross"></td>
                            <td><input class="form-control numberclass" name="minus_net" value="<?php if(isset($rdata)){ echo $rdata['minus_net']; } ?>" id="minus_net" type="text" placeholder="Net"></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person Responsible for Cold Chain at the Facility</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="pr_name" value="<?php if(isset($rdata)){ echo $rdata['pr_name']; } ?>" id="pr_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="pr_desg" value="<?php if(isset($rdata)){ echo $rdata['pr_desg']; } ?>" id="pr_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="pr_mob" value="<?php if(isset($rdata)){ echo $rdata['pr_mob']; } ?>" id="pr_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="pr_email" value="<?php if(isset($rdata)){ echo $rdata['pr_email']; } ?>" id="pr_email" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="6" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="cctl_name" value="<?php if(isset($rdata)){ echo $rdata['cctl_name']; } ?>" id="cctl_name" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cctl_mob" value="<?php if(isset($rdata)){ echo $rdata['cctl_mob']; } ?>" id="cctl_mob" type="text"></td>  
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="cctl_date" value="<?php if(isset($rdata)){ echo $rdata['cctl_date']; } ?>" id="cctl_date" type="text"></td>   
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="dc_name" value="<?php if(isset($rdata)){ echo $rdata['dc_name']; } ?>" id="dc_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="dc_desg" value="<?php if(isset($rdata)){ echo $rdata['dc_desg']; } ?>" id="dc_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="dc_email" value="<?php if(isset($rdata)){ echo $rdata['dc_email']; } ?>" id="dc_email" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="dc_mob" value="<?php if(isset($rdata)){ echo $rdata['dc_mob']; } ?>" id="dc_mob" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="dc_date" value="<?php if(isset($rdata)){ echo $rdata['dc_date']; } ?>" id="dc_date" type="text"></td>
					            <td><label>Date Submitted</label></td>
                      <td><input class="dp form-control" name="date_submitted" value="<?php  echo $current_date;  ?>" id="date_submitted" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url();?>Refrigerator-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
         
                 
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->

<!--JS -->
<script src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
 <!--fortooltip-->
 <script type="text/javascript">
  
$("#show").change(function(){
   if($(this).val()=="1")
   {    
       $(".hideshowtd").show();
   }
    else
    {
        $(".hideshowtd").hide();
    }
});
</script>
  



<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<!--for navbar fixed at top-->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

var pos = $('#nav').offset().top;
var nav = $('#nav');
$(window).scroll(function () {
        if ($(this).scrollTop() > pos) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
</script>
<script type="text/javascript">
  $(function () {
    var options = {
      format : "dd-mm-yyyy",
      startDate : "01-01-1925",
      endDate: "12-12-2000"
    };   
    $('#date_of_birth').datepicker(options);
    var options = {
      format : "dd-mm-yyyy"

    };
    $('.dp').datepicker(options);    
  });
</script>
</body>
</html>