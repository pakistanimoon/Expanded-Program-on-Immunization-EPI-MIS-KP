<div class="container bodycontainer">
<div class="row">
		<?php echo $TopInfo; 
		//echo '<pre>';print_r($data);echo '</pre>';
		if (isset($tableData[0]) && $tableData[0] !='') {
			?> 
        <table class="table table-bordered   table-striped table-hover  mytable">
           <tr>
			      <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Province/Area</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center">Khyber Pakhtunkhwa</td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>District</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $tableData[0]['District']; ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Tehsil/Taluka</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $tableData[0]['tehsilname']; ?></td>
          </tr>
		  <tr>
            <?php if(sizeof($tableData) == '1'){ ?>
			<td style="text-align:center; border: 1px solid black;" class="text-center"><label>Union Council</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $tableData[0]['unname'] ; ?></td>
			<?php } ?>
			 <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Village/Mahalla</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $tableData[0]['village_mahalla']; ?></td>
             <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Date Submitted</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($tableData[0]['date_submitted'])); ?></td>
          </tr>
      </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">S #</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Name of case & Father's name</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Case EPID # (to be filled in district)</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Age<br>in<br>Months</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Sex</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Address of the child House#/Street# etc</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2"># of pneumonia<br>vaccine doses received</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date<br>of last<br> pneumonia dose</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date<br>of rash onset</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="2">Date of specimen collection (if any)</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Date of Follow up</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Complication<br>(Yes/No) if yes mention type</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Death (Yes/No) if yes mention date</th>
            </tr>
            <tr>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Blood</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Throat/Oral swab</th>
              <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="3">To be filled up during follow up visit</th>
            </tr>             
          </thead>
          <tbody>
          	<?php if(isset($tableData)){ 
            	foreach($tableData as $key => $row){ ?>
            <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $key+1; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['fname_father']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_epi_no']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['age_in_months']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['gender']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['child_address']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['vacc_dose_no']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_last_dose'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_rash_onset'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_collection_blood'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_collection_throat'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_follow_up'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['complication']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center">
                <table>
                  <tr>
                    <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['date_death'])); ?></td>
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
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>No Record Found</label></td>
          </tr>
				</table>
		 <?php } ?>
</div><!--end of row-->
</div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>