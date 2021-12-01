<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">View Pneumonia Outbreak Investigation Line List of Suspected Cases</div>
     <div class="panel-body">

        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>Village/Mahalla</label></td>
            <td><?php echo $pneumoniaLineListResult[0]['village_mahalla']; ?></td>
            <td><label>Union Council</label></td>
            <td><?php echo get_UC_Name($pneumoniaLineListResult[0]['uncode']); ?></td>
            
            <td><label>Tehsil/Taluka</label></td>
            <td><?php echo get_Tehsil_Name($pneumoniaLineListResult[0]['tcode']); ?></td>
          </tr>
          <tr>
            <td><label>District</label></td>
            <td><?php echo get_District_Name($pneumoniaLineListResult[0]['distcode']); ?></td>
            <td><label>Province/Area</label></td>
            <td>Khyber Pakhtunkhwa</td>
            <td><label>Date of Investigation</label></td>
            <td><?php echo date('d-m-Y',strtotime($pneumoniaLineListResult[0]['date_investigation'])); ?></td>
          </tr>
          <tr>
             
            <td><label>Investigation done by</label></td>
            <td><?php echo $pneumoniaLineListResult[0]['investigation_by']; ?></td>
             
          </tr>
      </table>
         




        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>

              <th rowspan="2">S #</th>
              <th rowspan="2">Name of case & Father's name</th>
              <th rowspan="2">Case EPID # (to be filled in district)</th>
              <th rowspan="2">Age<br>in<br>Months</th>
              <th rowspan="2">Sex</th>
              <th rowspan="2">Address of the child House#/Street# etc</th>
              <th rowspan="2"># of pneumonia<br>vaccine doses received</th>
              <th rowspan="2">Date<br>of last<br> pneumonia dose</th>
              <th rowspan="2">Date<br>of rash onset</th>
              <th colspan="2">Date of specimen collection (if any)</th>
              <th>Date of Follow up</th>
              <th>Complication<br>(Yes/No) if yes mention type</th>
              <th>Death (Yes/No) if yes mention date</th>
            </tr>
            <tr>
              <th>Blood</th>
              <th>Throat/Oral swab</th>
              <th colspan="3">To be filled up during follow up visit</th>
            </tr>             
          </thead>
          <tbody>
          	<?php if(isset($pneumoniaLineListResult)){ 
            	foreach($pneumoniaLineListResult as $key => $row){ ?>
            <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo $row['fname_father']; ?></td>
              <td><?php echo $row['case_epi_no']; ?></td>
              <td><?php echo $row['age_in_months']; ?></td>
              <td><?php echo $row['gender']; ?></td>
              <td><?php echo $row['child_address']; ?></td>
              <td><?php echo $row['vacc_dose_no']; ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_last_dose'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_rash_onset'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_collection_blood'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_collection_throat'])); ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['date_follow_up'])); ?></td>
              <td><?php echo $row['complication']; ?></td>
              <td>
                <table>
                  <tr>
                    <td><?php echo date('d-m-Y',strtotime($row['date_death'])); ?></td>
                </tr>
              </table>
              </td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>

        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                
                
              <a href="<?php echo base_url(); ?>Linelists/pneumonia_linelist_edit/<?php echo $pneumoniaLineListResult[0]['distcode']; ?>/<?php echo $pneumoniaLineListResult[0]['linelist_group']; ?>" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-pencil-square-o"></i> Update </a>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>
            </div>
        </div>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->