<!--start of page content or body-->
<?php 
  date_default_timezone_set('Asia/Karachi');
  $current_date = date('d-m-Y');
?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Generators Questionnaire</div>
     <div class="panel-body">
      <form name="dataform" id="dataform" action="<?php echo base_url(); ?>Coldchain/generator_questionnaire_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
        <?php if(isset($gdata)){ ?>
          <input type="hidden" name="edit" id="edit" value="edit" />
          <input type="hidden" name="id" id="id" value="<?php echo $gdata['id']; ?>" />
        <?php } ?>
        <table class="table table-striped table-hover mytable2">
          <tbody>
            <tr>
              <td><label>EQUIPMENT RECORD </label></td>
              <td><input class="form-control" name="equip_rec" value="<?php if(isset($gdata)){ echo $gdata['equip_rec']; } ?>" id="equip_rec" type="text"></td>
              <td><label>OF</label></td>
              <td><input class="form-control" name="rec_of" value="<?php if(isset($gdata)){ echo $gdata['rec_of']; } ?>" id="rec_of" type="text"></td>
              <td><p>(Fill in a separate form for each piece of equipment and number all forms)</p></td>
            </tr>           
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
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
                  <?php if(!isset($gdata)){?>
                     <option value="0">Select</option>
                  <?php } ?>
                    <?php foreach($resultDist as $row){ ?>
                    <option <?php if(isset($gdata) && $gdata['distcode'] == $row['distcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['distcode']; ?>" <?php echo set_select('distcode',$row['distcode']); ?> /><?php echo $row['district'];?></option>
                  <?php }  ?>
                </select>
              </td>    
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td>
                <select id="tcode" name="tcode" class="form-control text-center">
                  <?php if(!isset($gdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>                 
                  <?php 
                    foreach($resultTeh as $row){?>
                    <option <?php if(isset($gdata) && $gdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
                  <?php } ?>
                </select>
              </td>
              <td><label>4. Union Council</label></td>
              <td>
                <select id="uncode" name="uncode" class="form-control text-center">
                  <?php if(!isset($gdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>
                  <?php
                    foreach($resultUnC as $row){ ?>
                    <option <?php if(isset($gdata) && $gdata['uncode'] == $row['uncode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['uncode']; ?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?></option>
                  <?php }?>
                </select>
              </td>
            </tr>
            <tr>
              <td><label>5. Name of (Health/EPI) Facility</label></td>
              <td>
                <select id="facode" name="facode" class="form-control text-center">
                  <?php if(!isset($gdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>
                  <?php
                    foreach($resultFac as $row){ ?>
                    <option <?php if(isset($gdata) && $gdata['facode'] == $row['facode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['facode']; ?>"  /><?php echo $row['fac_name'];?></option>
                  <?php }?>
                </select>
              </td>
              <td><label>6. Equipment code</label></td>
              <td style="width: 33%;">
                <?php 
                  if(isset($gdata)){ 
                  $equip_code=array();
                  $equip_code= explode('-', $gdata['equip_code']);
                  } 
                ?>
                <table style="width:100%">
                  <tr>
                    <td><input class="form-control" value="3" readonly="readonly" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_1" value="<?php if(isset($gdata)){ echo $equip_code[0]; } ?>" id="equip_1" type="text"></td>
                    <td><input class="form-control" name="equip_2" value="<?php if(isset($gdata)){ echo $equip_code[1]; } ?>" id="equip_2" type="text"></td>
                    <td><input class="form-control" name="equip_3" value="<?php if(isset($gdata)){ echo $equip_code[2]; } ?>" id="equip_3" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_4" value="<?php if(isset($gdata)){ echo $equip_code[3]; } ?>" id="equip_4" type="text"></td>
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
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Generator Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <label>7. Model name</label> (Mandatory data)
              </td>
              <td><input class="form-control" name="model" value="<?php if(isset($gdata)){ echo $gdata['model']; } ?>" id="model" type="text"></td>
              <td><label>8. Manufacturer</label> (Mandatory data)</td>
              <td><input class="form-control" name="manufacturer" value="<?php if(isset($gdata)){ echo $gdata['manufacturer']; } ?>" id="manufacturer" type="text"></td>
            </tr>
            <tr>
              <td><label>9. Serial number</label> (Mandatory data)</td>
              <td><input class="form-control" name="serial_number" value="<?php if(isset($gdata)){ echo $gdata['serial_number']; } ?>" id="serial_number" type="text"></td>
              <td><label>10. Number of phases</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="no_phases" <?php if(isset($gdata)){ if($gdata['no_phases']  == "1"){ echo 'checked="checked"';} } ?> id="no_phases" type="radio"> One </td>
                    <td><input value="2" name="no_phases" <?php if(isset($gdata)){ if($gdata['no_phases']  == "2"){ echo 'checked="checked"';} } ?> id="no_phases" type="radio"> Three</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>11. Power rating</label> (kW)</td>
              <td><input class="form-control" name="power_rating" value="<?php if(isset($gdata)){ echo $gdata['power_rating']; } ?>" id="power_rating" type="text"></td>
              <td><label>12. Power source</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="power_source" <?php if(isset($gdata)){ if($gdata['power_source']  == "1"){ echo 'checked="checked"';} } ?> id="power_source" type="radio"> Diesel</td>
                    <td><input value="2" name="power_source" <?php if(isset($gdata)){ if($gdata['power_source']  == "2"){ echo 'checked="checked"';} } ?> id="power_source" type="radio"> Petrol</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>13. Automatic start mechanism?</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="auto_start_mechanism" <?php if(isset($gdata)){ if($gdata['auto_start_mechanism']  == "1"){ echo 'checked="checked"';} } ?> id="auto_start_mechanism" type="radio"> Yes</td>
                    <td><input value="2" name="auto_start_mechanism" <?php if(isset($gdata)){ if($gdata['auto_start_mechanism']  == "2"){ echo 'checked="checked"';} } ?> id="auto_start_mechanism" type="radio"> No</td>
                  </tr>
                </table>
              </td>
              <?php 
                if(isset($gdata)){ 
                $used_for=array();
                $used_for= explode(',', $gdata['used_for']);
                }
              ?>
              <td><label>14. Used for</label> (Mark ALL boxes that apply)</td>
              <td style="padding-top: 13px;">
                <input value="1" name="used_for[]" <?php if(isset($gdata) && in_array("1",$used_for)){echo 'checked="checked"';} ?> id="used_for" type="checkbox"> Refrigerators or freezers 
                <input value="2" name="used_for[]" <?php if(isset($gdata) && in_array("2",$used_for)){echo 'checked="checked"';} ?> id="used_for" type="checkbox"> Cold rooms
                <input value="3" name="used_for[]" <?php if(isset($gdata) && in_array("3",$used_for)){echo 'checked="checked"';} ?> id="used_for" type="checkbox"> Lighting
                <input value="4" name="used_for[]" <?php if(isset($gdata) && in_array("4",$used_for)){echo 'checked="checked"';} ?> id="used_for" type="checkbox"> Other
              </td>
            </tr>
            <tr>
              <td><label>15. Year of supply</label></td>
              <td><input class="form-control" name="year_supply" value="<?php if(isset($gdata)){ echo $gdata['year_supply']; } ?>" id="year_supply" type="text"></td>
              <td><label>16. Source of supply</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="source_supply" <?php if(isset($gdata)){ if($gdata['source_supply']  == "1"){ echo 'checked="checked"';} } ?> id="source_supply" type="radio"> MOH</td>
                    <td><input value="2" name="source_supply" <?php if(isset($gdata)){ if($gdata['source_supply']  == "2"){ echo 'checked="checked"';} } ?> id="source_supply" type="radio"> Facility's budget</td>
                    <td><input value="3" name="source_supply" <?php if(isset($gdata)){ if($gdata['source_supply']  == "3"){ echo 'checked="checked"';} } ?> id="source_supply" type="radio"> Donation</td>
                    <td><input value="4" name="source_supply" <?php if(isset($gdata)){ if($gdata['source_supply']  == "4"){ echo 'checked="checked"';} } ?> id="source_supply" type="radio"> NGO</td>
                    <td><input value="5" name="source_supply" <?php if(isset($gdata)){ if($gdata['source_supply']  == "5"){ echo 'checked="checked"';} } ?> id="source_supply" type="radio"> Unknown</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>17. Working status</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="working_status" <?php if(isset($gdata)){ if($gdata['working_status']  == "1"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Working well & fuel available</td>
                  </tr>
                  <tr>
                    <td><input value="2" name="working_status" <?php if(isset($gdata)){ if($gdata['working_status']  == "2"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Working well but fuel not available</td>
                  </tr>
                  <tr>
                    <td><input value="3" name="working_status" <?php if(isset($gdata)){ if($gdata['working_status']  == "3"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Working but needs maintenance</td>
                  </tr><tr>
                    <td><input value="4" name="working_status" <?php if(isset($gdata)){ if($gdata['working_status']  == "4"){ echo 'checked="checked"';} } ?> id="working_status" type="radio"> Not working</td>
                  </tr>
                </table>
              </td>
              <td><label>18. Equipment utilization</label><br>If not in use, clarify with cold <br>chain representative if available for allocation.</td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td><input value="1" name="equip_utilization" <?php if(isset($gdata)){ if($gdata['equip_utilization']  == "1"){ echo 'checked="checked"';} } ?> id="equip_utilization" type="radio"> In use</td>
                  </tr>
                  <tr>
                    <td><input value="2" name="equip_utilization" <?php if(isset($gdata)){ if($gdata['equip_utilization']  == "2"){ echo 'checked="checked"';} } ?> id="equip_utilization" type="radio"> In storage </td>
                  </tr>
                  <tr>
                    <td><input value="3" name="equip_utilization" <?php if(isset($gdata)){ if($gdata['equip_utilization']  == "3"){ echo 'checked="checked"';} } ?> id="equip_utilization" type="radio"> Not used & available for allocation</td>
                  </tr><tr>
                    <td><input value="4" name="equip_utilization" <?php if(isset($gdata)){ if($gdata['equip_utilization']  == "4"){ echo 'checked="checked"';} } ?> id="equip_utilization" type="radio"> Not used & not available for allocation</td>
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
                      <td><input class="form-control" name="pr_name" value="<?php if(isset($gdata)){ echo $gdata['pr_name']; } ?>" id="pr_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="pr_desg" value="<?php if(isset($gdata)){ echo $gdata['pr_desg']; } ?>" id="pr_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="pr_mob" value="<?php if(isset($gdata)){ echo $gdata['pr_mob']; } ?>" id="pr_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="pr_email" value="<?php if(isset($gdata)){ echo $gdata['pr_email']; } ?>" id="pr_email" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Cold Chain Inventory Team Leader's Information</th>
                    </tr>
                  </thead>
                  <tbody>
                   <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="cctl_name" value="<?php if(isset($gdata)){ echo $gdata['cctl_name']; } ?>"  id="cctl_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="cctl_desg" value="<?php if(isset($gdata)){ echo $gdata['cctl_desg']; } ?>"  id="cctl_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cctl_mob" value="<?php if(isset($gdata)){ echo $gdata['cctl_mob']; } ?>"  id="cctl_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="cctl_email" value="<?php if(isset($gdata)){ echo $gdata['cctl_email']; } ?>"  id="cctl_email" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's Information</th>
                    </tr>
                  </thead>
                  <tbody>
                   <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="dc_name" value="<?php if(isset($gdata)){ echo $gdata['dc_name']; } ?>" id="dc_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="dc_desg" value="<?php if(isset($gdata)){ echo $gdata['dc_desg']; } ?>" id="dc_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="dc_email" value="<?php if(isset($gdata)){ echo $gdata['dc_email']; } ?>" id="dc_email" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="dc_mob" value="<?php if(isset($gdata)){ echo $gdata['dc_mob']; } ?>" id="dc_mob" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="dc_date" value="<?php if(isset($gdata)){ echo $gdata['dc_date']; } ?>" id="dc_date" type="text"></td>
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
             
              <a href="<?php echo base_url();?>Generator-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
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