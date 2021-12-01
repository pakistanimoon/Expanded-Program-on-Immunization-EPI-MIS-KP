<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Transport Questionnaire</div>
     <div class="panel-body">
       <form class="form-horizontal">
       
        <table class="table table-bordered   table-striped table-hover 2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td>Kyber Pakhtunkhwa</td>
              <td><label>2. District</label></td>
              <td><?php echo get_District_Name($gdata->distcode); ?></td>    
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td><?php echo get_Tehsil_Name($gdata->tcode); ?></td>    
              <td><label>4. Union Council</label></td>
              <td><?php echo get_UC_Name($gdata->uncode); ?></td>    
            </tr>
            <tr>
              <td><label>5. Name of (health) facility</label></td>
              <td><?php echo get_Facility_Name($gdata->facode); ?></td>    
               
            </tr> 
<tr>
				<td><label>6. Year</label></td>
				<td> <?php if(isset($gdata->year)) { echo $gdata->year;} ?> </td>
				<td><label>7. Quarter</label></td>
				<td> <?php if(isset($gdata->quarter)) { echo $gdata->quarter;} ?> </td>
			
			</tr>			
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Key for &quot;Transport&quot; and &quot;Reasons for not working&quot; columns</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <label>&quot;Transport Type&quot;</label> 
              </td>
              <td>
                <table style="width: 100%; ">
                 <tr>
                    <td>1. Motorcycle </td>
                  </tr>
                  <tr>  
                    <td>2. Vehicle </td>
                  </tr>
                  <tr>  
                    <td>3. Truck </td>
                  </tr>
                  <tr>  
                    <td>4. Boat </td>
                  </tr>
                  <tr>
                    <td>5. Bicycle </td>
                  </tr>
                   
                </table>
              </td>
              <td><label>&quot;Reason for not working&quot;</label></td>
              <td>
                <table style="width: 100%;">
                  <tr>
                    <td>&#10004; Waiting repair technician or at garage </td>
                  </tr>
                  <tr>  
                    <td>&#10004; Waiting spare parts </td>
                  </tr>
                  <tr>  
                    <td>&#10004; Awaiting finances </td>
                  </tr>
                  <tr>  
                    <td>&#10004; Awaiting boarding off </td>
                  </tr>
                  <tr>
                    <td>&#10004; Unknown </td>
                  </tr>
                </table>
              </td>
            </tr>
                                
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Key for "Transport" and "Reasons for not working" columns</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable " style="margin-top: -21px;">
          <thead>
            <tr>
              <th>Transport type(1-5)</th>
              <th>Model</th>
              <th>Make</th>
              <th>Year of manufacture</th>
              <th>Total number</th>
              <th>Number not working</th> 
              <th>Reasons for not working (A-E)</th>
              <th>% used for EPI</th>
              <th>Type of fuel</th>
                          
            </tr>                       
          </thead>
          <tbody>
		  <?php
				foreach($gdataDetail as $key => $val){
			?>
            <tr>
              <td>
			  <?php echo ($val['transport_type']==1)?'Motorcycle':''; ?>
			  <?php echo ($val['transport_type']==2)?'Vehicle':''; ?>
			  <?php echo ($val['transport_type']==3)?'Truck':''; ?>
			  <?php echo ($val['transport_type']==4)?'Boat':''; ?>
			  <?php echo ($val['transport_type']==5)?'Bicycle':''; ?>
			  </td>
              <td><?php echo $val['model']; ?></td>
              <td><?php echo $val['make']; ?></td>
              <td><?php echo $val['year_manufacture']; ?></td>
              <td><?php echo $val['tot_number']; ?></td>
              <td><?php echo $val['not_working']; ?></td> 
              <td>
			  <?php echo ($val['reasons_not_working']==1)?'Waiting repair technician or at garage':''; ?>
			  <?php echo ($val['reasons_not_working']==2)?'Waiting spare parts':''; ?>
			  <?php echo ($val['reasons_not_working']==3)?'Awaiting finances':''; ?>
			  <?php echo ($val['reasons_not_working']==4)?'Awaiting boarding off':''; ?>
			  <?php echo ($val['reasons_not_working']==5)?'Unknown':''; ?>
			  </td>
              <td><?php echo $val['percentage_used']; ?></td>
              <td><?php echo $val['fuel_type']; ?></td>
                          
            </tr>
				<?php } ?>
            <tr>
              <td colspan="9" style="text-align:left;"><?php echo $gdata->comments; ?></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person responsible for cold chain at the facility</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php echo $gdata->pr_name; ?></td>
                      <td><label>Designation</label></td>
                      <td><?php echo $gdata->pr_desg; ?></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><?php echo $gdata->pr_mob; ?></td>
                      <td><label>Email</label></td>
                      <td><?php echo $gdata->pr_email; ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php echo $gdata->cctl_name; ?></td>
                      <td><label>Designation</label></td>
                      <td><?php echo $gdata->cctl_desg; ?></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><?php echo $gdata->cctl_mob; ?></td>
                      <td><label>Email</label></td>
                      <td><?php echo $gdata->cctl_email; ?></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><?php echo $gdata->dc_name; ?></td>
                      <td><label>Designation</label></td>
                      <td><?php echo $gdata->dc_desg; ?></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><?php echo $gdata->dc_email; ?></td>
                      <td><label>Mobile number</label></td>
                      <td><?php echo $gdata->dc_mob; ?></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><?php echo date('d-m-Y',strtotime($gdata->dc_date)); ?></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a href="<?php echo base_url(); ?>Transport-Questionnaire/Edit/<?php echo $gdata->id; ?>" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a href="<?php echo base_url();?>Transport-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>    
                 
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->