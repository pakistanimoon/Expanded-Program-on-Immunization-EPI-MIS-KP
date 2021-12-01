<!--start of page content or body kp-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading">Weekly VPD Surveillance Province/District Compilation Report</div>
     <div class="panel-body">
       <form class="form-horizontal">
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>District</label></td> 
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($code)){ echo get_District_Name($code); } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Province/Area</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center">Khyber Pakhtunkhwa</td>
            
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label># of Reporting Unit</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
          </tr>
          <tr>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label># of Report Received</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($reportingFLCF)){ echo $reportingFLCF; } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Epi Week No</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center">Week <?php if(isset($epiWeek)){ echo sprintf('%02d',$epiWeek); } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Year</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($year)){ echo $year; } ?></td>
          </tr>
          <tr>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>AFP</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['afp']; } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Measles</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['measles']; } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>NT</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['nnt']; } ?></td>
          </tr>
          <tr>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Diphtheria</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['diptheria']; } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Pertusis</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['pertusis']; } ?></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Childhood TB</label></td>
            <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($upperPortion)){ echo $upperPortion['ch_tb']; } ?></td>
          </tr>
           
      </table>
         




      <table class="table table-bordered table-condensed table-striped table-hover mytable">
        <thead>
          <tr>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">S #</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Name of Reporting Unit*</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Type of Case**</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Case EPID Number***</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" colspan="6">Name and Address of the case</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Age <br>in months</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Sex</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Onset</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of Investigation<br>****</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Total No <br>of vaccine doses received</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of last dose received</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Date of<br>specimen <br>collection<br>*****</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;" rowspan="2">Clinical<br>Presentation<br>of the case</th>
          </tr>
          <tr>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Name of case</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Father's name</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Address</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">UC</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">Tehsil</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">District</th>
          </tr>
          <tr style="background:white;color:black">
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">1</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">2</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">3</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">4</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">5</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">6</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">7</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">8</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">9</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">10</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">11</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">12</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">13</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">14</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">15</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">16</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">17</th>
            <th class="Heading text-center" style="background: #008d4c; color: white; width: 200px; border: 1px solid black;">18</th>           
          </tr>           
        </thead>
        <tbody>
        	<?php foreach($tableResult as $key => $row){ ?>
          <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $key+1; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_Facility_Name($row['facode']); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_type']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center">*EPID Number</td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_name']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_father_name']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_address']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['un_name']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['t_name']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo get_District_Name($row['distcode']); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_age']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if($row['case_sex']=='01'){ echo "Male"; }if($row['case_sex']=='02'){ echo "Female"; } ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-M-Y',strtotime($row['case_date_onset'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center">*Date Investigation</td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_tot_vacc_received']; ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y',strtotime($row['case_last_dose_received'])); ?></td>
              <td style="text-align:center; border: 1px solid black;" class="text-center">*Date Speciemen</td>
              <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo $row['case_presentation']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
      <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Compiled by</label></lable></td>
                <!--
                <td style="text-align:center; border: 1px solid black;" class="text-center">
                                  <table style="width:100%;">
                                    <tr>
                                      <td style="text-align:center; border: 1px solid black;" class="text-center"> Date </td>
                                      <td style="text-align:center; border: 1px solid black;" class="text-center"><?php echo date('d-m-Y'); ?></td>
                                    </tr>
                                  </table>
                                </td>-->
                
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Name</label></td>
				 <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion)){ echo $downPortion['prepared_by']; }?></td>
				
				
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Designation</label></td>
				 <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion)){ echo $downPortion['prepared_by_designation']; }?></td>
                
              </tr>
            </tbody></table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td colspan="2"><label>District/Province surveillance focal person</label></td>
                
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Name</label></td>
				 <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion)){ echo $downPortion['facility_incharge']; }?></td>
                
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Designation</label></td>
				 <td style="text-align:center; border: 1px solid black;" class="text-center"><?php if(isset($downPortion)){ echo $downPortion['facility_incharge_designation']; }?></td>
                
              </tr>
            </tbody></table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td colspan="2"><label>EDO (Health)/ Provincial Manager -EPI</label></td>
                
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Name</label></td>
                
              </tr>
              <tr>
                <td style="text-align:center; border: 1px solid black;" class="text-center"><label>Designation</label></td>
                
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
              <td style="text-align:center; border: 1px solid black;" class="text-center">*Reporting For districtlevel Reporting unit will be respective reporting health facility.for Provincial level compitition Reporting unit wilbe respective reporting district </td>
            </tr>
            <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center">**Type of case means AFP Measlics.NT Pertusis Deptheria Childhood TB etc </td>
            </tr>
            <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center">***Case epid number only applicable for AFP and measics cases to be filled at district level </td>
            </tr>
            <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center">****Date of investigation Only applicable for AFP Measies and NT cases To be filled at district level from CIF </td>
            </tr>
            <tr>
              <td style="text-align:center; border: 1px solid black;" class="text-center">*****Date of specimen collection Only applicable for AFP and measles cases To  be filled at district level from CIF</td>
            </tr>
           
        </tbody>
      </table>
           
         
        


        

    
        
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->