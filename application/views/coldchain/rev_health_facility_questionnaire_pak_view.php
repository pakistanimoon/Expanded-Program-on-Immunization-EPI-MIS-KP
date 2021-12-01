<!--start of page content or body-->
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Health Facility Questionnaire</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Information</th>
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
            </tr>
            <tr>
              <td colspan="4"><label>6. Type of Health Facility: (Mark only ONE box)</label>
                <table style="width:100%;" class="table table-bordered   table-striped table-hover">           
                  <tr>
                    <td>&#10004; Rural Health Centre</td>
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Health Facility Immunisation Activities</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <label>7. Total Population in Area Served by Facility</label>
              </td>
              <td><?php if(isset($a)){ echo $a['tot_pop'] ;} ?></td>
              <tr><td>
                <label>8. Live Births Per Year in Area Served by Facility</label>
              </td>
              <td><?php if(isset($a)){ echo $a['live_births'] ;} ?></td>
            </tr>             
            <tr>
              <td>
                <label>9. Pregnant Women Per Year in Area Served by Facility</label>
              </td>
              <td><?php if(isset($a)){ echo $a['no_preg_women'] ;} ?></td>
              <td>
                <label>10. Women of Child Bearing Age in Area Served by Facility</label>
              </td>
              <td><?php if(isset($a)){ echo $a['no_child_bearing_age'] ;} ?></td>
            </tr>
            <tr>
              <td colspan="2">
                <label>11a. Vaccine Storage</label><p  style="display: inline;"> Check box below ONLY if the facility has a refrigerator or freezer, even if broken. Otherwise leave blank.</p>
                <table>
                  <tr> <?php   $vaccine_storage=array();
							$vaccine_storage= explode(',', $a['vaccine_storage']); ?>
                    <td><?php if(in_array("1",$vaccine_storage)){echo '&#10004;';} ?></td>
                  </tr>
                </table>
              </td>
              <td colspan="2"><label>11b. Type of Services Provided </label><p  style="display: inline;"> Mark ALL boxes that apply</p>
                <table>
                  <tr>
				  <?php   $type_of_services=array();
							$type_of_services= explode(',', $a['type_of_services']); ?>
                    <td>
                      <?php if(in_array("1",$type_of_services)){echo '&#10004; Outreach immunisation services';} ?><br>
                      <?php if(in_array("2",$type_of_services)){echo '&#10004; Static immunisation services';} ?>
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
                <table class="table table-bordered   table-striped table-hover" style="width:100%;">
                  <tr>
                    <td><p>Vaccinator/EPITech</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_vaccinators'] ;} ?></td>
                    <td><p>LHVs</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_lhvs'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>Disp/Health Tech</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_dispensers'] ;} ?></td>
                    <td><p>LHSs</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_lhss'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>Store Keeper</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_store_keepers'] ;} ?></td>
                    <td><p>LHWs</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_lhws'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>DSV</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_dsv'] ;} ?></td>
                    <td><p>Cold Chain Technician</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_technicians_cc'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>ASV</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_asv'] ;} ?></td>
                    <td><p>Others</p></td>
                    <td><?php if(isset($a)){ echo $a['epi_others'] ;} ?></td>
                  </tr>
                  
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <label>13.  Training During Last One Year: (number of staff trained in CC/VM)</label>
              </td>
              <td colspan="3">
                <table class="table table-bordered   table-striped table-hover" style="width:100%;">
                  <tr>
                    <td><p>Vaccinator/EPITech</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_vaccinators'] ;} ?></td>
                    <td><p>LHVs</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_lhvs'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>Disp/Health Tech</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_dispensers'] ;} ?></td>
                    <td><p>LHSs</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_lhss'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>Store Keeper</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_store_keepers'] ;} ?></td>
                    <td><p>LHWs</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_lhws'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>DSV</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_dsv'] ;} ?></td>
                    <td><p>Cold chain technician</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_technician_cc'] ;} ?></td>
                  </tr>
                  <tr>
                    <td><p>ASV</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_asv'] ;} ?></td>
                    <td><p>Others</p></td>
                    <td><?php if(isset($a)){ echo $a['trained_others'] ;} ?></td>
                  </tr>
                  
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <label>14. Resupply Interval of Vaccines (in weeks)</label></td>
              <td><?php if(isset($a)){ echo $a['resupply_interval'] ;} ?></td> 
            </tr>
            <tr><td><label>15.  Reserve Stock for all Antigens: (in weeks)</label></td>
              <td><?php if(isset($a)){ echo $a['reserve_stock'];} ?></td> 
            </tr>
            <tr>
              <td colspan="3">
                <label>16. Routine Immunisation Ice Pack Requirements</label>(litres/week) Enter 0 if no static or outreach services provided
              </td>
              <td><?php if(isset($a)){ echo $a['routine_immune_req'] ;} ?></td>  
            </tr>
            <tr>
              <td><label>17. SNID / NID Ice Pack Requirements</label>(litres/day)</td>
              <td><?php if(isset($a)){ echo $a['snid_req'] ;} ?></td> 
            <tr>
              <td>
                <label>18. Distance to Vaccine Supply Source: (in kilometres)</label> 
              </td>
              <td><?php if(isset($a)){ echo $a['distance_vss'] ;} ?></td>
              <td colspan="2">
                <table style="width:100%;">
                  <tr>
                    <td colspan="2">
                      <label>19. Mode of Vaccine Supply: Mark only ONE box</label></td>
                      </tr>
                  <tr>
                    <td>&#10004; Delivered</td>
                     
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
                  <?php   $waste_disposal=array();
        					$waste_disposal= explode(',', $a['waste_disposal']); ?>
          				<tr>
          					<td><?php if(in_array("1",$waste_disposal)){echo '&#10004; Burn & Bury';} ?></td>
          					<td><?php if(in_array("2",$waste_disposal)){echo '&#10004; High Temperature Incineration';} ?></td>
          					<td><?php if(in_array("3",$waste_disposal)){echo '&#10004; Pit';} ?></td>
          					<td><?php if(in_array("4",$waste_disposal)){echo '&#10004; Collected and Transported to Higher Facility';} ?></td>
          					<td><?php if(in_array("5",$waste_disposal)){echo '&#10004; None';} ?></td>
                      
                  </tr>
                </table>
              </td>
              <td>
                <table style="width:100%;">
                  <tr>
                    <td colspan="4"><label>21. Stock Outs in Past 3 Months: Mark only ONE box</label></td>
                  </tr>  <?php   $stock_out_3_months=array();
							       $stock_out_3_months= explode(',', $a['stock_out_3_months']); ?>
                  
				         <tr>
                    <td><?php if(in_array("1",$stock_out_3_months)){echo 'Yes';} ?></td>
				          	<td><?php if(in_array("2",$stock_out_3_months)){echo 'No';} ?></td>
                     
                  </tr>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover mytable3">
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
				        <?php   $grid_elec_available=array();
						    	$grid_elec_available= explode(',', $a['grid_elec_available']); ?>
                  <tr>
					          <td><?php if(in_array("1",$stock_out_3_months)){echo '&#10004; None';} ?></td>
                    <td><?php if(in_array("2",$stock_out_3_months)){echo '&#10004; Less than 8 hours per day';} ?></td>
          					<td><?php if(in_array("3",$stock_out_3_months)){echo '&#10004; 8 to 16 Hours Per Day';} ?></td>
          					<td><?php if(in_array("4",$stock_out_3_months)){echo '&#10004; More Than 16 Hours Per Day';} ?></td>
                    </tr>
                    <tr>
                     
                </table>
              </td>
              <td colspan="2">
                <table style="width:100%">
                  <tr>
                    <td><label>23. Solar Energy: Mark ALL boxes that apply</label>
                    </td>
                  </tr>
				        <?php  $solar_energy=array();
							   $solar_energy= explode(',', $a['solar_energy']); ?>
                  <tr>
                    <td><?php if(in_array("1",$solar_energy)){echo '&#10004; Facility grounds shaded from sun more than 1 hr/day';} ?></td>
                  </tr>
                  <tr>
                    <td><?php if(in_array("2",$solar_energy)){echo '&#10004; Heavy clouds for longer than 2 weeks at a time';} ?></td>
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
              <td><?php if(isset($a)){ echo $a['pr_name']; } ?></td>
              <td><label>Name:</label></td>
              <td><?php if(isset($a)){ echo $a['cctl_name']; } ?></td>
            </tr>
            <tr>
              <td><label>Designation:</label></td>
              <td><?php if(isset($a)){ echo $a['pr_desg']; } ?></td>
              <td><label>Designation:</label></td>
              <td><?php if(isset($a)){ echo $a['cctl_desg']; } ?></td>
            </tr>
            <tr>
              <td><label>Mobile number:</label></td>
              <td><?php if(isset($a)){ echo $a['pr_mob']; } ?></td>
              <td><label>Mobile number:</label></td>
              <td><?php if(isset($a)){ echo $a['cctl_mob']; } ?></td>
            </tr>
            <tr>
              <td><label>Email:</label></td>
              <td><?php if(isset($a)){ echo $a['pr_email']; } ?></td>
              <td><label>Email:</label></td>
              <td><?php if(isset($a)){ echo $a['cctl_email']; } ?></td>
            </tr>
            <tr>
              <td><label>Date:</label></td>
              <td><?php if(isset($a)){ if($a['pr_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['pr_date'])); } } ?></td>
              <td><label>Date:</label></td>
              <td><?php if(isset($a)){ if($a['cctl_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['cctl_date'])); } } ?></td>
            </tr>
            <tr>
              <td colspan="4">
                <label>Data Collector's Information</label>
              </td>
            </tr>
            <tr>
              <td><label>Name:</label></td>
              <td><?php if(isset($a)){ echo $a['dc_name']; } ?></td>
              <td><label>Designation:</label></td>
              <td><?php if(isset($a)){ echo $a['dc_desg']; } ?></td>
            </tr>
            <tr>
              <td><label>Email:</label></td>
              <td><?php if(isset($a)){ echo $a['dc_email']; } ?></td>
              <td><label>Mobile No:</label></td>
              <td><?php if(isset($a)){ echo $a['dc_mob']; } ?></td>
            </tr>
            <tr>
              <td><label>Date:</label></td>
              <td><?php if(isset($a)){ if($a['dc_date'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['dc_date'])); } } ?></td>
			  <td><label>Date Submitted:</label></td>
              <td><?php if(isset($a)){ if($a['date_submitted'] != '1969-12-31') {echo date('d-m-Y',strtotime($a['date_submitted'])); } } ?></td>
            </tr>
          </table>
          <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
              <a style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="<?php echo base_url(); ?>HF-Questionnaire/Edit/<?php echo $a['id']?>"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a href="<?php echo base_url(); ?>HF-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
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