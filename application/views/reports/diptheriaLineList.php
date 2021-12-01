  <!--start of page content or body-->
 <div class="container bodycontainer">
<div class="row">
		<?php echo $TopInfo; 
		//echo '<pre>';print_r($data);echo '</pre>';
		if (isset($tableData[0]) && $tableData[0] !='') {
			?> 
        <table class="table table-bordered   table-striped table-hover  mytable">
           <tr>
			<td><label>Province/Area</label></td>
            <td>Khyber Pakhtunkhwa</td>
            <td><label>District</label></td>
            <td><?php echo $tableData[0]['District']; ?></td>
            <td><label>Tehsil/Taluka</label></td>
            <td><?php echo $tableData[0]['tehsilname']; ?></td>
          </tr>
		  <tr>
            <?php if(sizeof($tableData) == '1'){ ?>
			<td><label>Union Council</label></td>
            <td><?php echo $tableData[0]['unname'] ; ?></td>
			<?php } ?>
			 <td><label>Village/Mahalla</label></td>
            <td><?php echo $tableData[0]['village_mahalla']; ?></td>
             <td><label>Date Submitted</label></td>
            <td><?php echo date('d-m-Y',strtotime($tableData[0]['date_submitted'])); ?></td>
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
              <th rowspan="2"># of diphtheria<br>vaccine doses received</th>
              <th rowspan="2">Date<br>of last<br> diphtheria dose</th>
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
          	<?php if(isset($tableData)){ 
            	foreach($tableData as $key => $row){ ?>
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
		<?php } else{ ?>
					 <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>No Record Found</label></td>
          </tr>
				</table>
		 <?php } ?>
</div><!--end of row-->
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>