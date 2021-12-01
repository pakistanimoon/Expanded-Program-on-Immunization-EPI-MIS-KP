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
            <td><?php if(isset($code)){ echo get_District_Name($code); } ?></td>
            <td><label>Province/Area</label></td>
            <td>Khyber Pakhtunkhwa</td>
            
            <td><label># of Reporting Unit</label></td>
            <td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
          </tr>
          <tr>
            <td><label># of Report Received</label></td>
            <td><?php if(isset($reportingFLCF)){ echo $reportingFLCF; } ?></td>
            <td><label>Epi Week No</label></td>
            <td>Week <?php if(isset($epiWeek)){ echo sprintf('%02d',$epiWeek); } ?></td>
            <td><label>Year</label></td>
            <td><?php if(isset($year)){ echo $year; } ?></td>
          </tr>
          <tr>
            <td><label>AFP</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['afp']; } ?></td>
            <td><label>Measles</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['measles']; } ?></td>
            <td><label>NT</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['nnt']; } ?></td>
          </tr>
          <tr>
            <td><label>Diphtheria</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['diptheria']; } ?></td>
            <td><label>Pertusis</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['pertusis']; } ?></td>
            <td><label>Childhood TB</label></td>
            <td><?php if(isset($upperPortion)){ echo $upperPortion['ch_tb']; } ?></td>
          </tr>
           
      </table>
         




      <table class="table table-bordered table-condensed table-striped table-hover mytable">
        <thead>
          <tr>
            <th rowspan="2">S #</th>
            <th rowspan="2">Name of Reporting Unit*</th>
            <th rowspan="2">Type of Case**</th>
            <th rowspan="2">Case EPID Number***</th>
            <th colspan="6">Name and Address of the case</th>
            <th rowspan="2">Age <br>in months</th>
            <th rowspan="2">Sex</th>
            <th rowspan="2">Date of Onset</th>
            <th rowspan="2">Date of Investigation<br>****</th>
            <th rowspan="2">Total No <br>of vaccine doses received</th>
            <th rowspan="2">Date of last dose received</th>
            <th rowspan="2">Date of<br>specimen <br>collection<br>*****</th>
            <th rowspan="2">Clinical<br>Presentation<br>of the case</th>
          </tr>
          <tr>
            <th>Name of case</th>
            <th>Father's name</th>
            <th>Address</th>
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
        	<?php foreach($tableResult as $key => $row){ ?>
          <tr>
              <td><?php echo $key+1; ?></td>
              <td><?php echo get_Facility_Name($row['facode']); ?></td>
              <td><?php echo $row['case_type']; ?></td>
              <td>*EPID Number</td>
              <td><?php echo $row['case_name']; ?></td>
              <td><?php echo $row['case_father_name']; ?></td>
              <td><?php echo $row['case_address']; ?></td>
              <td><?php echo $row['un_name']; ?></td>
              <td><?php echo $row['t_name']; ?></td>
              <td><?php echo get_District_Name($row['distcode']); ?></td>
              <td><?php echo $row['case_age']; ?></td>
              <td><?php if($row['case_sex']=='01'){ echo "Male"; }if($row['case_sex']=='02'){ echo "Female"; } ?></td>
              <td><?php echo date('d-M-Y',strtotime($row['case_date_onset'])); ?></td>
              <td>*Date Investigation</td>
              <td><?php echo $row['case_tot_vacc_received']; ?></td>
              <td><?php echo date('d-m-Y',strtotime($row['case_last_dose_received'])); ?></td>
              <td>*Date Speciemen</td>
              <td><?php echo $row['case_presentation']; ?></td>
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
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td colspan="2"><label>District/Province surveillance focal person</label></td>
                
              </tr>
              <tr>
                <td><label>Name</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion['facility_incharge']; }?></td>
                
              </tr>
              <tr>
                <td><label>Designation</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion['facility_incharge_designation']; }?></td>
                
              </tr>
            </tbody></table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td colspan="2"><label>EDO (Health)/ Provincial Manager -EPI</label></td>
                
              </tr>
              <tr>
                <td><label>Name</label></td>
                
              </tr>
              <tr>
                <td><label>Designation</label></td>
                
              </tr>
            </tbody></table>
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