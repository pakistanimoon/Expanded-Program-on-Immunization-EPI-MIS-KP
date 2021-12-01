<!--start of page content or body-->
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Refrigerator / FRreezer/ILR Questionanaire</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-striped table-hover    ">
          <tbody>
            <tr>
              <td style="width: 20%;"><label>EQUIPMENT RECORD </label></td>
              <td style="width: 4%;"><?php if(isset($a)){ echo $a['equip_rec'];} ?></td>
              <td style="width: 4%;"><label>OF</label></td>
              <td><?php if(isset($a)){ echo $a['rec_of'];} ?></td>
              
            </tr>           
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Identification</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td>Khyber Pakhtunkhwa</td>
              <td><label>2. District</label></td>
               <td><?php if(isset($a)){ echo $a['districtname'];} ?></td> 
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td><?php if(isset($a)){ echo $a['tehsilname'];} ?></td>
              <td><label>4. Union Council</label></td>
              <td><?php if(isset($a)){ echo $a['unioncouncil'];} ?></td>
            </tr>
            <tr>
              <td><label>5. Name of (Health/EPI) Facility</label></td>
              <td><?php if(isset($a)){ echo $a['facilityname'];} ?></td>
              <td><label>6. Equipment code</label></td>
              <td style="width: 33%;">
                <table style="width:100%">
				 <?php 
				  if(isset($a)){ 
					$equip_code=array();
					$equip_code= explode('-', $a['equip_code']);
				  }
			?>
                  <tr>
                    <td><?php if(isset($a)){ echo $equip_code[0]; } ?></td>
                    <td> &#8212; </td>
                    <td><?php if(isset($a)){ echo $equip_code[1]; } ?></td>
                    <td><?php if(isset($a)){ echo $equip_code[2]; } ?></td>
                    <td><?php if(isset($a)){ echo $equip_code[3]; } ?></td>
                    <td> &#8212; </td>
                    <td><?php if(isset($a)){ echo $equip_code[4]; } ?></td>
                  </tr>
                </table>
              </td>
            </tr>   
			<tr>
					<td><label>7. Year</label></td>
              <td><?php if(isset($a)){ echo $a['year'];} ?></td>
              <td><label>8. Quarter</label></td>
              <td><?php if(isset($a)){ echo $a['quarter'];} ?></td>
				</tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Refrigerator or freezer information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="3"><label>7. Catalogue ID</label> (Catalogue ID is found in the Equipment Identification Booklet and starts with the letter E for PQS prequalified equipment. If equipment is not identified, in the Equipment Identification Booklet, also fill in questions #15-19.)</td>
              <td><label>E</label><span style="padding-left: 10px;"><?php if(isset($a)){ echo $a['catalogue_id'];} ?></span></td>
              
            </tr>
            <tr>
              <td><label>8. Serial number</label> (located on equipment or assigned serial number)</td>
              <td><?php if(isset($a)){ echo $a['serial_number'];} ?></td>
              <td><label>9. Year of first use</label> (estimate if information is not available)</td>
              <td><?php if(isset($a)){ echo $a['year_first_use'];} ?></td>
            </tr>
            <tr>
              <td><label>10. Working status</label></td> 
              <td>Working well</td>
              <td><label>11. Reason equipment not working:</label><br>(Check ALL boxes that apply, leave blank if equipment is working ) 
              <td>
			   <?php 
					 if(isset($a)){ 
						$equip_not_working_reason=array();
						$equip_not_working_reason= explode(',', $a['equip_not_working_reason']);
					  }
					 if(in_array("1",$equip_not_working_reason)){echo '&#10004; Spare parts are not available for repair/maintenance <br>';} 
					 if(in_array("2",$equip_not_working_reason)){echo '&#10004; Finance is not available for repair/maintenance <br>';} 
					 if(in_array("3",$equip_not_working_reason)){echo '&#10004; Not in use because electricity or fuel is not available <br>';} 
					 if(in_array("4",$equip_not_working_reason)){echo '&#10004; Equipment needs to be boarded off';} ?>
				
              </td>
               
            </tr>  
            <tr>
              <td><label>12. Equipment utilisation</label></td> 
              <td>Not in use and not available for re-allocation</td>
              <td><label>13. How is temperature monitored?</label><br>(Check ALL boxes that apply)
              </td>
              <td>
				 <?php 
					  if(isset($a)){ 
						$temp_monitored=array();
						$temp_monitored= explode(',', $a['temp_monitored']);
					  }
					
					 if(in_array("1",$temp_monitored)){echo '&#10004; No monitoring device <br>';} 
					 if(in_array("2",$temp_monitored)){echo '&#10004; Stem Thermometer <br>';} 
					 if(in_array("3",$temp_monitored)){echo '&#10004; FridgeTag<span style="vertical-align: top; font-size: 11px;">TM</span> <br>';} 
					 if(in_array("4",$temp_monitored)){echo '&#10004; Equipment needs to be boarded off';} ?>
			  
              </td>
            </tr>
            <tr>
              <td colspan="2"><label>14. No. of temperature alarms in past 30 days:</label> (Enter number of days on the temperature monitoring form when temperature is above +8C or below +2C:)
              </td>
              <td colspan="2">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: center;">Above +8C:</td>
                    <td style=""><?php if(isset($a)){ echo $a['no_temp_alarms_above'];} ?></td><td>days</td>
                    <td style="width:100px;"></td>
                    <td style="text-align: center;">Below +2C: </td>
                    <td style=""><?php if(isset($a)){ echo $a['no_temp_alarms_below'];} ?></td>
                    <td>days</td>
                  </tr>
                </table>
              </td>
              
            </tr>              
            <tr>
                <td colspan="2"><label>Fill in questions #15-19 when equipment ID is not found in the Equipment Identification Booklet.</label>
                </td>

                <td><label>Equipment ID not found</label> <?php if(isset($a)){ if($a['equip_found']  == "No"){ echo '&#10004';} } ?>
                </td>
                <td><label>Equipment ID found</label>  <?php if(isset($a)){ if($a['equip_found']  == "Yes"){ echo '&#10004';} } ?>
                </td>
              </tr>
			  <?php if(isset($a['equip_found']) && $a['equip_found']=='No'){ ?>
              <tr>
              <td colspan="4">
                <div id="15to19">
                  <table class="table table-bordered   table-striped table-hover    ">
                    <tr>
                      <td><label>15. Model name</label></td>
                      <td><?php if(isset($a)){ echo $a['model_name'];} ?></td>
                      <td><label>16. Manufacturer / Make</label></td>
                      <td><?php if(isset($a)){ echo $a['manufacturer'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>17. Is there a CFC-free sticker on the equipment?</label>                         
                      </td>
                      <td>
                        <table>
                          <tr>
                          <td>Yes</td>
                           
                          </tr>
                        </table>
                      </td>
                      <td><label>18. Refrigerator/Freezer Type</label></td>
                      <td>Chest freezer, AC electricity </td>
                    </tr>
                    <tr>
                      <td>
                        <label>19. Internal storage dimensions</label><br>(Measure with provided tape in cm.)</td>
                      <td colspan="3">
                        <table class="table table-bordered   table-striped table-hover    " style="width: 100%;">
                          <tr>
                            <td style="text-align: center;" colspan="3"><label>+4   &#176;C</label></td>
                            <td style="text-align: center;" colspan="3"><label>-20    &#176;C</label></td>
                          </tr>
                          <tr>
                            <td><?php if(isset($a)){ echo $a['plus_length'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['plus_width'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['plus_height'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['minus_length'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['minus_width'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['minus_height'];} ?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>              
                  </table>
                </div>
              </td>
            </tr>
			  <?php } ?> 
            <tr>
              <td>
                <label>20. Calculated internal storage volume</label>
                (litres)       <br>LEAVE BLANK -  FOR USE BY NATIONAL TEAM ONLY
              </td>
              <td colspan="3">
                        <table class="table table-bordered   table-striped table-hover    " style="width: 100%;">
                          <tr>
                            <td style="text-align: center;" colspan="2"><label>+4   &#176;C</label></td>
                            <td style="text-align: center;" colspan="2"><label>-20    &#176;C</label></td>
                          </tr>
                          <tr>
                            <td><?php if(isset($a)){ echo $a['plus_gross'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['plus_net'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['minus_gross'];} ?></td>
                            <td><?php if(isset($a)){ echo $a['minus_net'];} ?></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    ">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person responsible for cold chain at the facility</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php if(isset($a)){ echo $a['pr_name'];} ?></td>
                      <td><label>Designation</label></td>
                      <td><?php if(isset($a)){ echo $a['pr_desg'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><?php if(isset($a)){ echo $a['pr_mob'];} ?></td>
                      <td><label>Email</label></td>
                      <td><?php if(isset($a)){ echo $a['pr_email'];} ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    ">
                  <thead>
                    <tr>
                      <th colspan="6" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_name'];} ?></td>
                      <td><label>Mobile number</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_mob'];} ?></td>  
                      <td><label>Date</label></td>
                      <td><?php if(isset($a)){ if($a['cctl_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['cctl_date'])); } } ?></td>   
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    ">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_name'];} ?></td>
                      <td><label>Designation</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_desg'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_email'];} ?></td>
                      <td><label>Mobile number</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_mob'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><?php if(isset($a)){ if($a['dc_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['dc_date'])); } } ?></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
                  <hr>
                  <div style="text-align: right;" class="col-md-4 col-md-offset-8">
				<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>                   
				    <a href="<?php echo base_url(); ?>Refrigerator-Questionnaire/Edit/<?php echo $a['id']?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" ><i class="fa fa-pencil-square-o"></i> Update </a>
                <?php } ?> 
					<a href="<?php echo base_url(); ?>Refrigerator-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
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