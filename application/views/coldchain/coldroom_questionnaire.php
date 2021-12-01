<?php 
	date_default_timezone_set('Asia/Karachi');
	$current_date = date('d-m-Y');
?>
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"> Cold Room Questionnaire</div>
				<div class="panel-body">
					<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Coldchain/coldroom_questionnaire_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
						<?php if(isset($rdata)){ ?>
							<input type="hidden" name="edit" id="edit" value="edit" />
							<input type="hidden" name="id" id="id" value="<?php echo $rdata['id']; ?>" />
						<?php } ?>
						<table class="table table-striped table-hover mytable2">
							<tbody>
								<tr>
									<td><label>EQUIPMENT RECORD </label></td>
									<td><input class="form-control" name="equip_rec" value="<?php if(isset($rdata)){ echo $rdata['equip_rec']; } ?>" id="equip_rec" type="text"></td>
									<td><label>OF</label></td>
									<td><input class="form-control" name="rec_of" value="<?php if(isset($rdata)){ echo $rdata['rec_of']; } ?>" id="rec_of" type="text"></td>
									<td><p>(Fill in a separate form for each separate cold room and number all forms)</p></td>
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
						<td>
						<select id="distcode" name="distcode" class="form-control text-center">
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
						<td>
						<select id="tcode" name="tcode" class="form-control text-center">
						<?php if(!isset($rdata)){?>
							<option value="0">Select</option>
						<?php } ?>                 
						<?php 
							foreach($resultTeh as $row){?>
							<option <?php if(isset($rdata) && $rdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
						<?php } ?>
						</select>
						</td>
						<td><label>4. Union Council</label></td>
						<td>
						<select id="uncode" name="uncode" class="form-control text-center">
						<?php if(!isset($rdata)){?>
							<option value="0">Select</option>
						<?php } ?>
						<?php
						    foreach($resultUnC as $row){ ?>
							<option <?php if(isset($rdata) && $rdata['uncode'] == $row['uncode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['uncode']; ?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?></option>
						<?php }?>
						</select>
						</td>
				</tr>
				<tr>
				  <td><label>5. Name of (Health/EPI) Facility</label></td>
				  <td>
					<select id="facode" name="facode" class="form-control text-center">
					  <?php if(!isset($rdata)){?>
						<option value="0">Select</option>
					  <?php } ?>
					  <?php
						foreach($resultFac as $row){ ?>
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
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Cold Room Information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>7a. Type</label></td>
              <td>
                <table style="width: 100%; margin-top: 9px;">
                  <tbody>
                    <tr>
                      <td><input value="1" name="type_room" <?php if(isset($rdata)){ if($rdata['type_room']  == "1"){ echo 'checked="checked"';} } ?> id="type_room" type="radio"> +4&#176;C cold room  </td>
                      <td><input value="2" name="type_room" <?php if(isset($rdata)){ if($rdata['type_room']  == "2"){ echo 'checked="checked"';} } ?> id="type_room" type="radio"> -20&#176;C freezer room</td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td><label>7b. Model</label></td>
              <td><input class="form-control" name="model" value="<?php if(isset($rdata)){ echo $rdata['model']; } ?>" id="model" type="text"></td>
            </tr>
            <tr>
              <td><label>8. Manufacturer</label></td>
              <td><input class="form-control" name="manufacturer" value="<?php if(isset($rdata)){ echo $rdata['manufacturer']; } ?>" id="manufacturer" type="text"></td>
              <td><label>9. Year of supply</label></td>
              <td><input class="form-control" name="year_supply" value="<?php if(isset($rdata)){ echo $rdata['year_supply']; } ?>" id="year_supply" type="text"></td>
            </tr>
            <tr>
              <td><label>10. Working status</label></td>
              <td>
                <input value="1" name="working_status" <?php if(isset($rdata)){ if($rdata['working_status']  == "1"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Working well<br>
                <input value="2" name="working_status" <?php if(isset($rdata)){ if($rdata['working_status']  == "2"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Working but needs maintenance<br>
                <input value="3" name="working_status" <?php if(isset($rdata)){ if($rdata['working_status']  == "3"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Not working
              </td>
              <td><label>11. Number of phases</label></td>
              <td style="padding-top: 17px;">
                  <input value="1" name="no_phases" <?php if(isset($rdata)){ if($rdata['no_phases']  == "1"){ echo 'checked="checked"';} } ?> id="no_phases" type="radio"> One  <br>
                  <input value="2" name="no_phases" <?php if(isset($rdata)){ if($rdata['no_phases']  == "2"){ echo 'checked="checked"';} } ?> id="no_phases" type="radio"> Three
              </td>
            </tr>
            <tr>
              <td><label>12. Has voltage stabiliser?</label></td>
              <td style="padding-top: 17px;">
                <input value="1" name="voltage_stabilizer" <?php if(isset($rdata)){ if($rdata['voltage_stabilizer']  == "1"){ echo 'checked="checked"';} } ?> id="voltage_stabilizer" type="radio"> Yes <br>
                <input value="2" name="voltage_stabilizer" <?php if(isset($rdata)){ if($rdata['voltage_stabilizer']  == "2"){ echo 'checked="checked"';} } ?> id="voltage_stabilizer" type="radio"> No
              </td>
              <td><label>13. Temperature recording system:</label></td>
              <td style="padding-top: 17px;">
                <input value="1" name="temp_record_system" <?php if(isset($rdata)){ if($rdata['temp_record_system']  == "1"){ echo 'checked="checked"';} } ?> id="temp_record_system" type="radio"> Not provided  <br>
                <input value="2" name="temp_record_system" <?php if(isset($rdata)){ if($rdata['temp_record_system']  == "2"){ echo 'checked="checked"';} } ?> id="temp_record_system" type="radio"> Provided, operating<br>
                <input value="3" name="temp_record_system" <?php if(isset($rdata)){ if($rdata['temp_record_system']  == "3"){ echo 'checked="checked"';} } ?> id="temp_record_system" type="radio"> Provided, not operating  <br>
                <input value="4" name="temp_record_system" <?php if(isset($rdata)){ if($rdata['temp_record_system']  == "4"){ echo 'checked="checked"';} } ?> id="temp_record_system" type="radio"> Unknown
              </td>
            </tr>
            <tr>
            <?php 
              if(isset($rdata)){ 
              $type_record_system=array();
              $type_record_system= explode(',', $rdata['type_record_system']);
              }
            ?>
              <td><label>14. Type of recording system</label><br>Mark ALL boxes that apply</td>
              <td style="padding-top: 17px;" colspan="3">
                <input value="1" name="type_record_system[]" <?php if(isset($rdata) && in_array("1",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Thermometer(s) only  
                <input value="2" name="type_record_system[]" <?php if(isset($rdata) && in_array("2",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Chart recorder (clockwork)
                <input value="3" name="type_record_system[]" <?php if(isset($rdata) && in_array("3",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Chart recorder (electric) 
                <input value="4" name="type_record_system[]" <?php if(isset($rdata) && in_array("4",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Electronic data logger   
                <input value="5" name="type_record_system[]" <?php if(isset($rdata) && in_array("5",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Computer based recorder <br>
                <input value="6" name="type_record_system[]" <?php if(isset($rdata) && in_array("6",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> FridgeTag<span style="vertical-align: top; font-size: 11px;">TM</span>
                <input value="7" name="type_record_system[]" <?php if(isset($rdata) && in_array("7",$type_record_system)){echo 'checked="checked"';} ?> id="type_record_system" type="checkbox"> Not available <br>
              </td>
            </tr>                    
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2" style="margin-top: -21px;">
          <tr>
            <td style="width: 40%;"><label>15. Internal storage dimensions</label>(Measure in metres)
                <table class="table table-bordered   table-striped table-hover    mytable2" style="width: 100%;">
                          <tr>
                            <td style="text-align: center;" colspan="3"><label>+4   &#176;C</label></td>
                            <td style="text-align: center;" colspan="3"><label>-20    &#176;C</label></td>
                          </tr>
                          <tr>
                            <td><input class="form-control numberclass" name="plus_length" value="<?php if(isset($rdata)){ echo $rdata['plus_length']; } ?>" id="plus_length" type="text" placeholder="L"></td>
                            <td><input class="form-control numberclass" name="plus_width" value="<?php if(isset($rdata)){ echo $rdata['plus_width']; } ?>" id="plus_width" type="text" placeholder="W"></td>
                            <td><input class="form-control numberclass" name="plus_height" value="<?php if(isset($rdata)){ echo $rdata['plus_height']; } ?>" id="plus_height" type="text" placeholder="H"></td>
                            <td><input class="form-control numberclass" name="minus_length" value="<?php if(isset($rdata)){ echo $rdata['minus_length']; } ?>" id="minus_length" type="text" placeholder="L"></td>
                            <td><input class="form-control numberclass" name="minus_width" value="<?php if(isset($rdata)){ echo $rdata['minus_width']; } ?>" id="minus_width" type="text" placeholder="W"></td>
                            <td><input class="form-control numberclass" name="minus_height" value="<?php if(isset($rdata)){ echo $rdata['minus_height']; } ?>" id="minus_height" type="text" placeholder="H"></td>
                          </tr>
                        </table>
              </td>
              <td>
                <label>16. Internal gross storage volume</label>(m<span style="vertical-align: top;">3</span>)
                <table class="table table-bordered   table-striped table-hover    mytable2" style="width: 100%;">
                          <tr>
                            <td style="text-align: center;">
                              <label>+4   &#176;C</label>
                            </td>
                            <td style="text-align: center;">
                              <label>-20    &#176;C</label>
                            </td>
                          </tr>
                          <tr>
                            <td><input class="form-control numberclass" value="<?php if(isset($rdata)){ echo $rdata['plus_gross_volume']; } ?>" name="plus_gross_volume" id="plus_gross_volume" type="text"  ></td>
                            <td><input class="form-control numberclass" value="<?php if(isset($rdata)){ echo $rdata['minus_gross_volume']; } ?>" name="minus_gross_volume" id="minus_gross_volume" type="text"  ></td>
                          </tr>
                        </table>
              </td>
              <td>
                <label>17. Net storage volume for vaccine or ice packs</label>(m<span style="vertical-align: top;">3</span>)
                <table class="table table-bordered   table-striped table-hover    mytable2" style="width: 100%;">
                    <tr>
                       <td style="text-align: center;">
                         <label>+4   &#176;C</label>
                        </td>
                        <td style="text-align: center;">
                          <label>-20    &#176;C</label>
                        </td>
                    </tr>
                    <tr>
                      <td><input class="form-control numberclass" name="plus_net_volume" value="<?php if(isset($rdata)){ echo $rdata['plus_net_volume']; } ?>" id="plus_net_volume" type="text"  ></td>
                      <td><input class="form-control numberclass" name="minus_net_volume" value="<?php if(isset($rdata)){ echo $rdata['minus_net_volume']; } ?>" id="minus_net_volume" type="text"  ></td>
                    </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table style="width: 100%;">
                  <tr>
                    <td><label>18. Number of cooling systems</label>
                    </td>
                    <td><input class="form-control numberclass" name="no_cooling_systems" value="<?php if(isset($rdata)){ echo $rdata['no_cooling_systems']; } ?>" id="no_cooling_systems" type="text"  ></td>
                  </tr>
                </table>
              </td>
              <td><label>19. Refrigerant gas type</label><br>
                  <input value="1" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "1"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> Helium (non-CFC)<br>
                  <input value="2" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "2"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> NH<span style="vertical-align: text-top;">3</span> absorption (non-CFC)<br>
                  <input value="3" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "3"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> R12 compression refrigerant gas<br>
                  <input value="4" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "4"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> R134a compression refrigerant gas (non-CFC)<br>
                  <input value="5" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "5"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> R22 compression refrigerant gas<br>
                  <input value="6" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "6"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> R404a compression refrigerant gas (non-CFC)<br>
                  <input value="7" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "7"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> R600 (non-CFC) <br>
                  <input value="8" name="refrigerant_gas_type" <?php if(isset($rdata)){ if($rdata['refrigerant_gas_type']  == "8"){ echo 'checked="checked"';} } ?> id="refrigerant_gas_type" type="radio"> Unknown gas type
              </td>
              <td><label>20. Has working backup generator?</label><br>
                  <input value="1" name="backup_generator" <?php if(isset($rdata)){ if($rdata['backup_generator']  == "1"){ echo 'checked="checked"';} } ?> id="backup_generator" type="radio"> Yes &#8212; automatic start up<br>
                  <input value="2" name="backup_generator" <?php if(isset($rdata)){ if($rdata['backup_generator']  == "2"){ echo 'checked="checked"';} } ?> id="backup_generator" type="radio"> Yes &#8212; manual start up<br>
                  <input value="3" name="backup_generator" <?php if(isset($rdata)){ if($rdata['backup_generator']  == "3"){ echo 'checked="checked"';} } ?> id="backup_generator" type="radio"> No<br>
              </td>
            </tr>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="cctl_name" value="<?php if(isset($rdata)){ echo $rdata['cctl_name']; } ?>"  id="cctl_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="cctl_desg" value="<?php if(isset($rdata)){ echo $rdata['cctl_desg']; } ?>"  id="cctl_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cctl_mob" value="<?php if(isset($rdata)){ echo $rdata['cctl_mob']; } ?>"  id="cctl_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="cctl_email" value="<?php if(isset($rdata)){ echo $rdata['cctl_email']; } ?>"  id="cctl_email" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="cctl_date" value="<?php if(isset($rdata)){ echo $rdata['cctl_date']; } ?>"  id="cctl_date" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data collector's information</th>
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
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="dc_mob" value="<?php if(isset($rdata)){ echo $rdata['dc_mob']; } ?>" id="dc_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="dc_email" value="<?php if(isset($rdata)){ echo $rdata['dc_email']; } ?>" id="dc_email" type="text"></td>
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
              <a href="<?php echo base_url();?>Coldroom-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
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
<footer>
    <div class="footer-bottom">
        <div class="container">
             <p class="navbar-text">Online Lady Health Worker-Management Information System (Khyber Pakhtunkhwa Pakistan)&copy;
             <a class="link-trf" href="#" target="_blank">TRF</a>
             </p>
        </div>
    </div>
</footer>
<!--end of footer-->
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
        } 
		else 
		{
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