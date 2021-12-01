<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Weekly VPD Surveillance Province/District Compilation Report</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>District</label></td> 
            <td><?php echo $data['surveillance'][0]['district'] ?></td>
            <td><label>Province/Area</label></td>
            <td>Khyber Pakhtunkhwa</td>
            
            <td><label># of Reporting Unit</label></td>
            <td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
          </tr>
          <tr>
            <td><label># of Report Received</label></td>
            <td><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>
            <td><label>Epi Week No</label></td>
            <td>Week <?php if(isset($epiWeek)){ echo sprintf('%02d',$epiWeek); } ?></td>
            <td><label>Year</label></td>
            <td><?php if(isset($year)){ echo $year; } ?></td>
          </tr>
          <tr>
		<?php $i=1; foreach($upperPortion as $key => $val){ ?>
				<?php if($val['case'] != ''){ ?>
				<td><label><?php echo $val['case']; ?></label></td>
				<td><?php echo $val['no_of_cases']; ?></td>
				<?php } ?>
			<?php if (($i % 3) == 0){ ?>
			</tr><tr>
			<?php } ?>
		<?php $i++;  } ?>
           
      </table>
         




      <table class="table table-bordered table-condensed table-striped table-hover mytable">
        <thead>
          <tr>
            <th rowspan="2">S #</th>
			<th rowspan="2">District</th>
            <th rowspan="2">Name of Reporting Unit*</th>
            <th rowspan="2">Type of Case**</th>
            <th rowspan="2">Case EPID Number***</th>
            <th colspan="6">Name and Address of the case</th>
            <th rowspan="2">Age <br>in months(#)</th>
            <th rowspan="2">Sex <br>M/F</th>
            <th rowspan="2">Date of Onset</th>
            <th rowspan="2">Date of Investigation<br>****</th>
            <th rowspan="2">Total No <br>of vaccine doses received</th>
            <th rowspan="2">Date of last dose received</th>
            <th rowspan="2">Date of<br>specimen <br>collection<br>*****</th>
            <th rowspan="2">Clinical<br>Presentation<br>of the case</th>
          </tr>
          <tr>
            <th>Name</th>
            <th>Father's name</th>
            <th>Village/muhalla</th>
            <th>UC</th>
            <th>Tehsil</th>
            <th>District</th>
          </tr>
          <tr style="background:white;color:black">
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>13</th>
            <th>14</th>
            <th>15</th>
            <th>16</th>
            <th>17</th>
            <th>18</th>           
          </tr>           
        </thead>
        <tbody>
        	<?php foreach($surveillance as $key => $row){ ?>
          <tr>
              <td><?php echo $key+1; ?></td>
			  <td><?php echo $row['district']; ?></td>
              <td><?php echo $row['facility']; ?></td>
              <td><?php echo $row['case_type']; ?></td>
              <td><?php echo $row['epid_no']; ?></td>
              <td><?php echo $row['name_case']; ?></td>
              <td><?php echo $row['case_father_name']; ?></td>
              <td><?php echo $row['case_address']; ?></td>
              <td><?php echo $row['case_unname']; ?></td>
              <td><?php echo $row['case_tehsil']; ?></td>
              <td><?php echo $row['case_district']; ?></td>
              <td><?php echo $row['case_age']; ?></td>
              <td><?php echo ucwords($row['gender']); ?></td>
              <td><?php echo date('d-M-Y',strtotime($row['case_date_onset'])); ?></td> 	
              <td><?php echo date('d-M-Y',strtotime($row['case_date_investigation'])); ?></td>
              <td><?php echo $row['case_tot_vacc_received']; ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['case_date_last_dose_received'])); ?></td>
              <td><?php echo date('d-M-Y',strtotime($row['case_date_specieman'])); ?></td>
              <td><?php echo (isset($row['case_representation']) && $row['case_representation']!='')?get_CaseRepresentation_Value($row['case_representation']):''; ?></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
      <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label>Compiled by</label></lable></td>
                <!--
                <td>
                                  <table style="width:100%;">
                                    <tr>
                                      <td> Date </td>
                                      <td><?php echo date('d-m-Y'); ?></td>
                                    </tr>
                                  </table>
                                </td>-->
                
              </tr>
              <tr>
                <td><label>Name</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion['prepared_by']; }?></td>
				
				
              </tr>
              <tr>
                <td><label>Designation</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion['prepared_by_designation']; }?></td>
                
              </tr>
            </tbody></table>
          </div>
          <div class="col-sm-4">
            
          </div>
          <div class="col-sm-4">
            
          </div>
        </div>

        
        <div class="row">
                 <hr>
                    <div style="text-align: right;" class="col-md-4 col-md-offset-8">
                        
                        
                      <!--<a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" href="#"><i class="fa fa-pencil-square-o"></i> Update </a>-->
                     <label class="text-right">Compiled Date: <?php echo date('d/m/Y'); ?></label>
                      <!--<a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-arrow-left"></i> Back </a>-->
                    </div>
                </div>
        
        
          <table class="table table-bordered table-striped" style="margin-top: 10px;">
          <tbody>
            <tr>
              <td>*Reporting For districtlevel Reporting unit will be respective reporting health facility.for Provincial level compitition Reporting unit wilbe respective reporting district </td>
            </tr>
            <tr>
              <td>**Type of case means AFP Measlics.NT Pertusis Deptheria Childhood TB etc </td>
            </tr>
            <tr>
              <td>***Case epid number only applicable for AFP and measics cases to be filled at district level </td>
            </tr>
            <tr>
              <td>****Date of investigation Only applicable for AFP Measies and NT cases To be filled at district level from CIF </td>
            </tr>
            <tr>
              <td>*****Date of specimen collection Only applicable for AFP and measles cases To  be filled at district level from CIF</td>
            </tr>
           
        </tbody>
      </table>
           
         
        


        

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->