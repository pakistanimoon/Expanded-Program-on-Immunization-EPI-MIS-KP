<!--start of page content or body-->
<div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Cold Room Questionnaire</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-striped table-hover    ">
          <tbody>
            <tr>
              <td style="width: 20%;"><label>EQUIPMENT RECORD:</label></td>
              <td style="width: 4%;"><?php if(isset($a)){ echo $a['equip_rec'];} ?></td>
              <td style="width: 4%;"><label>OF:</label></td>
              <td><?php if(isset($a)){ echo $a['rec_of'];} ?></td>
              
            </tr>           
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover mytable3">
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
				<td><label>6. Year</label></td>
				<td> <?php if(isset($a['year'])) { echo $a['year'];} ?> </td>
				<td><label>7. Quarter</label></td>
				<td> <?php if(isset($a['quarter'])) { echo $a['quarter'];} ?> </td>
			
			</tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Cold Room Information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>7a. Type</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['type_room'] == '1')){ echo "+4&#176;C cold room";} ?></td>
                      <td><?php if(isset($a) && ($a['type_room'] == '2')){ echo "-20&#176;C freezer room";} ?></td>                                                          
                    </tr>
                  </tbody>
                </table>
              </td>
              <td><label>7b. Model</label></td>
              <td><?php if(isset($a)){ echo $a['model'];} ?></td>
            </tr>
            <tr>
              <td><label>8. Manufacturer</label></td>
              <td><?php if(isset($a)){ echo $a['manufacturer'];} ?></td>
              <td><label>9. Year of supply</label></td>
              <td><?php if(isset($a)){ echo $a['year_supply'];} ?></td>
            </tr>
            <tr><td><label>10. Working status</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['working_status'] == '1')){ echo "Working well";} ?></td>
                      <td><?php if(isset($a) && ($a['working_status'] == '2')){ echo "Working but needs maintenance";} ?></td> 
                      <td><?php if(isset($a) && ($a['working_status'] == '3')){ echo "Not working";} ?></td>                                                        
                    </tr>
                  </tbody>
                </table>
              </td>
              <td><label>11. Number of phases</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['no_phases'] == '1')){ echo "One";} ?></td>
                      <td><?php if(isset($a) && ($a['no_phases'] == '2')){ echo "Three";} ?></td>                                                           
                    </tr>
                  </tbody>
                </table>
              </td>       
            </tr>
            <tr><td><label>12. Has voltage stabiliser?</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['voltage_stabilizer'] == '1')){ echo "Yes";} ?></td>
                      <td><?php if(isset($a) && ($a['voltage_stabilizer'] == '2')){ echo "No";} ?></td>
                    </tr>
                  </tbody>
                </table>
              </td> 
              <td><label>13. Temperature recording system:</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['temp_record_system'] == '1')){ echo "Not provided";} ?></td>
                      <td><?php if(isset($a) && ($a['temp_record_system'] == '2')){ echo "Provided, operating";} ?></td>
                      <td><?php if(isset($a) && ($a['temp_record_system'] == '3')){ echo "Provided, not operating";} ?></td> 
                      <td><?php if(isset($a) && ($a['temp_record_system'] == '4')){ echo "Unknown";} ?></td>                                                            
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>14. Type of recording system</label><br>Mark ALL boxes that apply</td>
              <td   colspan="3">
                <?php 
                  if(isset($a)){ 
                    $type_record_system=array();
                    $type_record_system= explode(',', $a['type_record_system']);
                  }
                  if(in_array("1",$type_record_system)){echo '&#10004; Thermometer(s) only <br>';} 
                  if(in_array("2",$type_record_system)){echo '&#10004; Chart recorder (clockwork) <br>';} 
                  if(in_array("3",$type_record_system)){echo '&#10004; Chart recorder (electric) <br>';} 
                  if(in_array("4",$type_record_system)){echo '&#10004; Electronic data logger <br>';} 
                  if(in_array("5",$type_record_system)){echo '&#10004; Computer based recorder <br>';} 
                  if(in_array("6",$type_record_system)){echo '&#10004; FridgeTag<span style="vertical-align: top; font-size: 11px;">TM</span><br>';}
                  if(in_array("7",$type_record_system)){echo '&#10004; Not available';}  
                ?>                   
              </td>
            </tr>                    
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    " style="margin-top: -21px;">
          <tr>
            <td style="width: 40%;"><label>15. Internal storage dimensions</label>(Measure in metres)
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
            <td colspan="3"><label>16. Internal gross storage volume</label>(m<span style="vertical-align: top;">3</span>)
              <table class="table table-bordered   table-striped table-hover" style="width: 100%;">
                <tr>
                  <td style="text-align: center;"><label>+4   &#176;C</label></td>
                  <td style="text-align: center;"><label>-20    &#176;C</label></td>
                </tr>
                <tr>
                  <td><?php if(isset($a)){ echo $a['plus_gross_volume'];} ?></td>
                  <td><?php if(isset($a)){ echo $a['minus_gross_volume'];} ?></td>
                </tr>
              </table>
            </td>
            <td colspan="2"><label>17. Net storage volume for vaccine or ice packs</label>(m<span style="vertical-align: top;">3</span>)
              <table class="table table-bordered   table-striped table-hover" style="width: 100%;">
                <tr>
                  <td style="text-align: center;"><label>+4   &#176;C</label></td>
                  <td style="text-align: center;"><label>-20    &#176;C</label></td>
                </tr>
                <tr>
                  <td><?php if(isset($a)){ echo $a['plus_net_volume'];} ?></td>
                  <td><?php if(isset($a)){ echo $a['minus_net_volume'];} ?></td> 
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <table class="table table-bordered   table-striped table-hover    " style="margin-top: -21px;">
        <tr>
          <td><label>18. Number of cooling systems</label></td>
              <td>
                <table style="width: 50%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a)){ echo $a['no_cooling_systems'];} ?></td>
                    </tr>
                  </tbody>
                </table>
              </td> 
              <td><label>19. Refrigerant gas type</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '1')){ echo "Helium (non-CFC)";} ?></td>
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '2')){ echo "NH<span style=\"vertical-align: text-top;\">3</span> absorption (non-CFC)";} ?></td>                
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '3')){ echo "R12 compression refrigerant gas";} ?></td> 
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '4')){ echo "R134a compression refrigerant gas (non-CFC)";} ?></td> 
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '5')){ echo "R22 compression refrigerant gas";} ?></td>  
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '6')){ echo "R404a compression refrigerant gas (non-CFC)";} ?></td>  
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '7')){ echo "R600 (non-CFC)";} ?></td>  
                      <td><?php if(isset($a) && ($a['refrigerant_gas_type'] == '8')){ echo "Unknown gas type";} ?></td>                                                             
                    </tr>
                  </tbody>
                </table>
              </td>
               <td><label>20. Has working backup generator?</label></td>
              <td>
                <table style="width: 100%; ">
                  <tbody>
                    <tr>
                      <td><?php if(isset($a) && ($a['backup_generator'] == '1')){ echo "Yes &#8212; automatic start up";} ?></td>
                      <td><?php if(isset($a) && ($a['backup_generator'] == '2')){ echo "Yes &#8212; manual start up";} ?></td>
                      <td><?php if(isset($a) && ($a['backup_generator'] == '3')){ echo "No";} ?></td>                                                      
                    </tr>
                  </tbody>
                </table>
              </td>
        </tr>


        </table>
        <table class="table table-bordered   table-striped table-hover    ">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Cold Chain Inventory Team Leader's Information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_name'];} ?></td>
                      <td><label>Designation</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_desg'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_mob'];} ?></td>
                      <td><label>Email</label></td>
                      <td><?php if(isset($a)){ echo $a['cctl_email'];} ?></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><?php if(isset($a)){ if($a['cctl_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['cctl_date'])); } } ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    ">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's Information</th>
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
                      <td><label>Mobile number</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_mob'];} ?></td>
                      <td><label>Email</label></td>
                      <td><?php if(isset($a)){ echo $a['dc_email'];} ?></td>
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
			 <a href="<?php echo base_url(); ?>Coldroom-Questionnaire/Edit/<?php echo $a['id']?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
<?php } ?>             
			 <a href="<?php echo base_url(); ?>Coldroom-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
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