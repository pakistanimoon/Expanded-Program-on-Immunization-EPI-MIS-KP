<!--start of page content or body-->
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Generators Questionnaire</div>
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
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
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
              <td><label>5. Name of (Health) Facility</label></td>
              <td><?php if(isset($a)){ echo $a['facilityname'];} ?></td>
              <td><label>6. Equipment code</label></td>
              <td style="width: 33%;">
                <table style="width:100%">
                	<tbody>
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
                	</tbody>
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
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Generator Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>7. Model name</label> (Mandatory data)</td>
              <td><?php if(isset($a)){ echo $a['model'];} ?></td>
              <td><label>8. Manufacturer</label> (Mandatory data)</td>
              <td><?php if(isset($a)){ echo $a['manufacturer'];} ?></td>
            </tr>
            <tr>
              <td><label>9. Serial number</label> (Mandatory data)</td>
              <td><?php if(isset($a)){ echo $a['serial_number'];} ?></td>
              <td><label>10. Number of phases</label></td>
              <td>
                <table style="width: 100%;">
                  <tr>
                    <td><?php if(isset($a) && ($a['no_phases'] == '1')){ echo "One";} ?></td>
                    <td><?php if(isset($a) && ($a['no_phases'] == '2')){ echo "Three";} ?></td>  
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>11. Power rating</label> (kW)</td>
              <td><?php if(isset($a)){ echo $a['power_rating'];} ?></td>
              <td><label>12. Power source</label></td>
              <td>
                <table style="width: 100%;">
                  <tr>
                    <td><?php if(isset($a) && ($a['power_source'] == '1')){ echo "Diesel";} ?></td>
                    <td><?php if(isset($a) && ($a['power_source'] == '2')){ echo "Petrol";} ?></td> 
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>13. Automatic start mechanism?</label></td>
              <td>
                <table style="width: 100%;  ">
                  <tr>
                    <td><?php if(isset($a) && ($a['auto_start_mechanism'] == '1')){ echo "Yes";} ?></td>
                    <td><?php if(isset($a) && ($a['auto_start_mechanism'] == '2')){ echo "No";} ?></td>
                  </tr>
                </table>
              </td>
              <td><label>14. Used for</label> (Mark ALL boxes that apply)</td>
              <td>
              	<?php 
                  if(isset($a)){ 
                    $used_for=array();
                    $used_for= explode(',', $a['used_for']);
                  }
                  if(in_array("1",$used_for)){echo '&#10004; Refrigerators or freezers <br>';} 
                  if(in_array("2",$used_for)){echo '&#10004; Cold rooms <br>';} 
                  if(in_array("3",$used_for)){echo '&#10004; Lighting <br>';} 
                  if(in_array("4",$used_for)){echo '&#10004; Other <br>';}                   
                ?>
              </td>
            </tr>
            <tr>
              <td><label>15. Year of supply</label></td>
              <td><?php if(isset($a)){ echo $a['year_supply'];} ?></td>
              <td><label>16. Source of supply</label></td>
              <td>
                <table style="width: 100%;  ">
                  <tr>
                    <td><?php if(isset($a) && ($a['source_supply'] == '1')){ echo "MOH";} ?></td>
                    <td><?php if(isset($a) && ($a['source_supply'] == '2')){ echo "Facility's budget";} ?></td>
                    <td><?php if(isset($a) && ($a['source_supply'] == '3')){ echo "Donation";} ?></td>
                    <td><?php if(isset($a) && ($a['source_supply'] == '4')){ echo "NGO";} ?></td> 
                    <td><?php if(isset($a) && ($a['source_supply'] == '5')){ echo "Unknown";} ?></td> 
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td><label>17. Working status</label></td>
              <td>
                <table style="width: 100%; ">
                  <tr>
                    <td><?php if(isset($a) && ($a['working_status'] == '1')){ echo "Working well & fuel available";} ?></td>
                    <td><?php if(isset($a) && ($a['working_status'] == '2')){ echo "Working well but fuel not available";} ?></td>
                    <td><?php if(isset($a) && ($a['working_status'] == '3')){ echo "Working but needs maintenance";} ?></td>
                    <td><?php if(isset($a) && ($a['working_status'] == '4')){ echo "Not working";} ?></td>                     
                  </tr>
                </table>
              </td>
              <td><label>18. Equipment utilization</label><br>If not in use, clarify with cold <br>chain representative if available for allocation.</td>
              <td>
                <table style="width: 100%; ">
                  <tr>
                    <td><?php if(isset($a) && ($a['equip_utilization'] == '1')){ echo "In use";} ?></td>
                    <td><?php if(isset($a) && ($a['equip_utilization'] == '2')){ echo "In storage";} ?></td>
                    <td><?php if(isset($a) && ($a['equip_utilization'] == '3')){ echo "Not used & available for allocation";} ?></td>
                    <td><?php if(isset($a) && ($a['equip_utilization'] == '4')){ echo "Not used & not available for allocation";} ?></td>  
                  </tr>                  
                </table>
              </td>
            </tr>                      
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person Responsible for Cold Chain at the Facility</th>
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
                <table class="table table-bordered   table-striped table-hover    2">
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
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    2">
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
              <a href="<?php echo base_url(); ?>Generator-Questionnaire/Edit/<?php echo $a['id']?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="#"><i class="fa fa-pencil-square-o"></i> Update </a>
              <a href="<?php echo base_url(); ?>Generator-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
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