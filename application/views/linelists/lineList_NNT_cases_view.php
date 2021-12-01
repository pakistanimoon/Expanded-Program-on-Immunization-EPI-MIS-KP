<!--start of page content or body-->
 <div class="container" style="width:1346px!important;">

  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Line List for NNT Cases View</div>
     <div class="panel-body">
       <form class="form-horizontal" style="margin-left: -15px;margin-right: -15px;">
        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
              <th>S#</th>
              <th>Reported From</th>
              <th>Case EPI DNO</th>
              <th>Name &amp; Father's Name</th>
              <th>Age In Days</th>
              <th>Sex</th>
              <th>Contact #</th>
              <th>Village</th>
              <th>District</th>
              <th>Tehsil</th>
              <th>Union Council</th>
              <th>TT Doses to Mother</th>
              <th>Signs &amp; Symptoms</th>
              <th>Date of Onset</th>
              <th>Date of Notification</th>
              <th>Date of Field Investigation</th>
              <th>Diagnosed by</th>
              <th>Outcome</th>
              <th>Antenata Visits by Mother</th>
              <th>Date of Delivery</th>
              <th>Delivery Conducted by</th>
              <th>Place of Delivery</th>
              <th>Instrument used for cord cutting</th>
              <th>Cord Clamping Material</th>
            </tr>
          </thead>
          <tbody>
          	<?php if(isset($nntLineListResult)){ 
            	foreach($nntLineListResult as $key => $row){ ?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo $row['reported_from']; ?></td>
              <td><?php echo $row['case_epi_no']; ?></td>
              <td><?php echo $row['fname_father']; ?></td>
              <td><?php echo $row['age_in_days']; ?></td>
              <td><?php echo $row['gender']; ?></td>
              <td><?php echo $row['contact_no']; ?></td>
              <td><?php echo $row['village']; ?></td>
              <td><?php echo get_District_Name($row['distcode']); ?></td>
              <td><?php echo get_Tehsil_Name($row['tcode']); ?></td>
              <td><?php echo get_UC_Name($row['uncode']); ?></td>
              <td><?php echo $row['tt_doses_mother']; ?></td>
              <td><?php echo $row['signs_symptoms']; ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_onset'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_notification'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_investigation'])); ?></td>
              <td><?php echo $row['diagnosed_by']; ?></td>
              <td><?php echo $row['out_come']; ?></td>
              <td><?php echo $row['antenatal_visits']; ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_delivery'])); ?></td>
              <td><?php echo $row['delivery_by']; ?></td>
              <td><?php echo $row['place_of_delivery']; ?></td>
              <td><?php echo $row['instrument_cord']; ?></td>
              <td><?php echo $row['cord_clamping_material']; ?></td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>

         
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a href="<?php echo base_url(); ?>Linelists/nnt_linelist_edit/<?php echo $nntLineListResult[0]['distcode']; ?>/<?php echo $nntLineListResult[0]['linelist_group']; ?>" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md">
              	<i class="fa fa-pencil-square-o"></i> Update 
              </a>
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->