<?php //print_r($measles);exit; ?>
<div class="" style="font-size:12px;">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Line List of Suspected Measles Cases</div>
     <div class="panel-body">
       <form class="form-horizontal">
               <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>District</label></td> 
            <td><?php echo $districtName; ?></td>
            <td><label>Province/Area</label></td>
            <td>Khyber Pakhtunkhwa</td>
            
            <td><label># of Reporting Unit</label></td>
            <td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
          </tr>
          <tr>
            <td><label># of Reported Cases</label></td>
            <td><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>
            <td><label>Epi Week No</label></td>
            <td><?php echo ($this->input->post('week'))?sprintf('%02d',$this->input->post('week')):''; ?></td>
            <td><label>Year</label></td>
            <td><?php echo ($this->input->post('year'))?$this->input->post('year'):''; ?></td>
          </tr>
		  <tr>
		
      </table>




        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
				<th rowspan="2">S #</th>
				<th rowspan="2">Name of Reporting Unit*</th>
				<th rowspan="2">Type of Case**</th>
				<th rowspan="2">Week#</th>
				<th rowspan="2">Case EPID Number***</th>
				<th rowspan="2">Name of Case*</th>
				<th rowspan="2">Father Name</th>
				<th rowspan="2">Address of the child House#/Street# etc</th>
				<th colspan="2">UC</th>
				<th colspan="2">Tehsil</th>
				<th colspan="2">District</th>
				<th rowspan="2">Age in Months</th>
				<th rowspan="2">Gender</th>
				<th rowspan="2">Date of Onset</th>
        <th rowspan="2">Date of Investigation***</th>
				<th rowspan="2">Date of Notification</th>
				<th rowspan="2"># of Measles vaccine doses received</th>
				<th rowspan="2">Date of last measles dose</th>
				<th rowspan="2">Date of specimen collection (if any)</th> 
				<th rowspan="2">Clinical Presentation of the case</th>
				<th rowspan="2">Specimen Result</th>
            </tr>
            <tr>
              <th>Referred By</th>
              <th>Referred To</th>
              <th>Referred By</th>
              <th>Referred To</th>
              <th>Referred By</th>
              <th>Referred To</th>
            </tr>
                        
          </thead>
          <tbody>
          <?php 
		  $previousWeekNumber = 0;
		  foreach($measles as $key => $row){ 

            if($row['patient_gender']=='1')
              $patient_gender= 'Male';
            else if($row['patient_gender']=='0')
              $patient_gender= 'Female';
            else
              $patient_gender= '';
		 ?>
		 <?php /* if($key == 0 || $row['week'] != $previousWeekNumber ){ */ ?>
			<!--<tr class="text-center">
				<td class="text-center success" style="font-size: 15px;font-weight: bold;text-align: center;" colspan="23">
				Week <?php /* echo sprintf('%02d',$row['week']); */ ?>
				</td>
			</tr>-->
		<?php 
		/* $previousWeekNumber = $row['week'];
		} */ ?>
          <tr class="DrillDownRow">
              <td data-id="<?php echo $row['id']; ?>" data-facode="<?php echo $row['facode']; ?>"><?php echo $key+1; ?></td>
			  <td><?php echo $row['facility']; ?></td>
              <td><?php echo 'Measles'; ?></td>
			  <td><?php echo sprintf('%02d',$row['week']); ?></td>
              <td><?php echo $row['case_epi_no']; ?></td>
              <td><?php echo $row['patient_name']; ?></td>
              <td><?php echo $row['patient_fathername']; ?></td>
              <td><?php echo $row['patient_address']; ?></td>
              <td><?php echo $row['rb_unname']; ?></td>
              <td><?php echo $row['patient_unname']; ?></td>
              <td><?php echo $row['rb_tehsil']; ?></td>
              <td><?php echo $row['patient_tehsil']; ?></td>
              <td><?php echo $row['rb_district']; ?></td>
              <td><?php echo $row['patient_district']; ?></td>
              <td><?php echo $row['age_months']; ?></td>
              <td><?php echo $patient_gender; ?></td>
              <td><?php echo isset($row['date_rash_onset']) ? date('d-M-Y',strtotime($row['date_rash_onset'])) :'-'; ?></td> 	
              <td><?php echo isset($row['pvh_date']) ? date('d-M-Y',strtotime($row['pvh_date'])) :'-'; ?></td>  
              <td><?php echo isset($row['notification_date']) ? date('d-M-Y',strtotime($row['notification_date'])) :'-'; ?></td> 	
              <td><?php echo $row['doses_received']; ?></td>
              <td><?php echo isset($row['last_dose_date']) ? date('d-m-Y',strtotime($row['last_dose_date'])) : '-'; ?></td>
              <td><?php echo isset($row['date_collection']) ? date('d-M-Y',strtotime($row['date_collection'])) : '-';?></td>
              <td><?php echo $row['clinical_representation']; ?></td>
			  <td><?php if($row['date_collection'] == ''){ ?> Sample Not Collected <?php } elseif($row['specimen_result']=='0') { ?> Result Awaited <?php } else { echo $row['specimen_result']; } ?></td>
            </tr>
            <?php } ?> 
          </tbody>
        </table>
  <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody>
				<tr>
                <td><label>Compiled by</label></td>
              </tr>
              <tr>
                <td><label>Name</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion[0]['name']; }?></td>
              </tr>
              <tr>
                <td><label>Designation</label></td>
				 <td><?php if(isset($downPortion)){ echo $downPortion[0]['designation']; }?></td>
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
<?php  if(!$this->input->post('export_excel')){ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:first-child").data('id');
		var facode = $(this).find("td:first-child").data('facode');
        var url = '';
		 url = "<?php echo base_url();?>Measles-CIF/View/"+facode+"/"+code;       
        var win = window.open(url,'_self');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      
      });
  </script>
<?php } exit; ?> 