<!--start of page content or body-->
<?php 
  date_default_timezone_set('Asia/Karachi');
  $current_date = date('d-m-Y');
?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Voltage Regulators/Stabilizers Questionnaire</div>
     <div class="panel-body">
      <form name="dataform" id="dataform" action="<?php echo base_url(); ?>Coldchain/voltage_questionnaire_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
        <?php if(isset($vdata)){ ?>
          <input type="hidden" name="edit" id="edit" value="edit" />
          <input type="hidden" name="id" id="id" value="<?php echo $vdata['id']; ?>" />
        <?php } ?>
        <table class="table table-striped table-hover mytable2">
          <tbody>
            <tr>
              <td><label>EQUIPMENT RECORD </label></td>
              <td><input class="form-control" name="equip_rec" value="<?php if(isset($vdata)){ echo $vdata['equip_rec']; } ?>" id="equip_rec" type="text"></td>
              <td><label>OF</label></td>
              <td><input class="form-control" name="rec_of" value="<?php if(isset($vdata)){ echo $vdata['rec_of']; } ?>" id="rec_of" type="text"></td>
              <td><p>(Fill in a separate form for each separate cold room and number all forms)</p></td>
            </tr>           
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover   mytable2 mytable3">
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
                  <?php if(!isset($vdata)){?>
                     <option value="0">Select</option>
                  <?php } ?>
                    <?php foreach($resultDist as $row){ ?>
                    <option <?php if(isset($vdata) && $vdata['distcode'] == $row['distcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['distcode']; ?>" <?php echo set_select('distcode',$row['distcode']); ?> /><?php echo $row['district'];?></option>
                  <?php }  ?>
                </select>
              </td>      
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td>
                <select id="tcode" name="tcode" class="form-control text-center">
                  <?php if(!isset($vdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>                 
                  <?php 
                    foreach($resultTeh as $row){?>
                    <option <?php if(isset($vdata) && $vdata['tcode'] == $row['tcode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['tcode']; ?>" <?php echo set_select('tcode',$row['tcode']); ?> /><?php echo $row['tehsil'];?></option>
                  <?php } ?>
                </select>
              </td>
              <td><label>4. Union Council</label></td>
              <td>
                <select id="uncode" name="uncode" class="form-control text-center">
                  <?php if(!isset($vdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>
                  <?php
                    foreach($resultUnC as $row){ ?>
                    <option <?php if(isset($vdata) && $vdata['uncode'] == $row['uncode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['uncode']; ?>" <?php echo set_select('uncode',$row['uncode']); ?> /><?php echo $row['un_name'];?></option>
                  <?php }?>
                </select>
              </td>
            </tr>
            <tr>
              <td><label>5. Name of (Health/EPI) Facility</label></td>
              <td>
                <select id="facode" name="facode" class="form-control text-center">
                  <?php if(!isset($vdata)){?>
                    <option value="0">Select</option>
                  <?php } ?>
                  <?php
                    foreach($resultFac as $row){ ?>
                    <option <?php if(isset($vdata) && $vdata['facode'] == $row['facode']){ echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row['facode']; ?>"  /><?php echo $row['fac_name'];?></option>
                  <?php }?>
                </select>
              </td>
              <td><label>6. Equipment code</label></td>
              <td style="width: 33%;">
               <?php 
                  if(isset($vdata)){ 
                  $equip_code=array();
                  $equip_code= explode('-', $vdata['equip_code']);
                  } 
                ?>
                <table style="width:100%">
                  <tr>
                    <td><input class="form-control" value="3" readonly="readonly" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_1" value="<?php if(isset($vdata)){ echo $equip_code[0]; } ?>" id="equip_1" type="text"></td>
                    <td><input class="form-control" name="equip_2" value="<?php if(isset($vdata)){ echo $equip_code[1]; } ?>" id="equip_2" type="text"></td>
                    <td><input class="form-control" name="equip_3" value="<?php if(isset($vdata)){ echo $equip_code[2]; } ?>" id="equip_3" type="text"></td>
                    <td style="padding-left: 5px; padding-right: 5px;"> &#8212; </td>
                    <td><input class="form-control" name="equip_4" value="<?php if(isset($vdata)){ echo $equip_code[3]; } ?>" id="equip_4" type="text"></td>
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
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Voltage Regulator Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="3">
                <label>7. Catalogue ID</label> (When item is found in the Equipment Identification Booklet, enter the ID number and complete questions 10 and 11.)
              </td>
              <td><input class="form-control" name="catalogue_id" value="<?php if(isset($vdata)){ echo $vdata['catalogue_id']; } ?>" id="catalogue_id" type="text"></td>
            </tr>
            <tr>
              <td><label>8. Manufacturer</label><br> (Mandatory data if catalogue ID is NOT provided)</td>
              <td><input class="form-control" name="manufacturer" value="<?php if(isset($vdata)){ echo $vdata['manufacturer']; } ?>" id="manufacturer" type="text"></td>
              <td><label>9. Model</label> <br>(Mandatory data if catalogue ID is NOT provided)</td>
              <td><input class="form-control" name="model" value="<?php if(isset($vdata)){ echo $vdata['model']; } ?>" id="model" type="text"></td>
            </tr>
            <tr>
              <td><label>10. Quantity present</label></td>
              <td><input class="form-control numberclass" name="quantity_present" value="<?php if(isset($vdata)){ echo $vdata['quantity_present']; } ?>" id="quantity_present" type="text"></td>
              <td><label>11. Quantity not working</label></td>
              <td><input class="form-control numberclass" name="quantity_not_working" value="<?php if(isset($vdata)){ echo $vdata['quantity_not_working']; } ?>" id="quantity_not_working" type="text"></td>
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
                      <td><input class="form-control" name="pr_name" value="<?php if(isset($vdata)){ echo $vdata['pr_name']; } ?>" id="pr_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="pr_desg" value="<?php if(isset($vdata)){ echo $vdata['pr_desg']; } ?>" id="pr_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="pr_mob" value="<?php if(isset($vdata)){ echo $vdata['pr_mob']; } ?>" id="pr_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="pr_email" value="<?php if(isset($vdata)){ echo $vdata['pr_email']; } ?>" id="pr_email" type="text"></td>
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
                      <td><input class="form-control" name="cctl_name" value="<?php if(isset($vdata)){ echo $vdata['cctl_name']; } ?>"  id="cctl_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="cctl_desg" value="<?php if(isset($vdata)){ echo $vdata['cctl_desg']; } ?>"  id="cctl_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cctl_mob" value="<?php if(isset($vdata)){ echo $vdata['cctl_mob']; } ?>"  id="cctl_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="cctl_email" value="<?php if(isset($vdata)){ echo $vdata['cctl_email']; } ?>"  id="cctl_email" type="text"></td>
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
                      <td><input class="form-control" name="dc_name" value="<?php if(isset($vdata)){ echo $vdata['dc_name']; } ?>" id="dc_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="dc_desg" value="<?php if(isset($vdata)){ echo $vdata['dc_desg']; } ?>" id="dc_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="dc_email" value="<?php if(isset($vdata)){ echo $vdata['dc_email']; } ?>" id="dc_email" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="dc_mob" value="<?php if(isset($vdata)){ echo $vdata['dc_mob']; } ?>" id="dc_mob" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="dc_date" value="<?php if(isset($vdata)){ echo $vdata['dc_date']; } ?>" id="dc_date" type="text"></td>
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
             
              <a href="<?php echo base_url();?>Voltage-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
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