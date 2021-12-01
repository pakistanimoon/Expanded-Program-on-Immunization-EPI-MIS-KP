
<div class="" style="font-size: 12px;">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> NNT Investigation Line List of Suspected Cases</div>
     <div class="panel-body">
       <form class="form-horizontal">
               <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label>District</label></td> 
            <td><?php echo $districtName; ?></td>
            <td><label>Province/Area</label></td>
            <td><?php echo $this -> session -> provincename ?></td>
            
            <td><label># of Reporting Unit</label></td>
            <td><?php if(isset($allReportingFLCF)){ echo $allReportingFLCF; } ?></td>
          </tr>
          <tr>
            <td><label># of Report Received</label></td>
            <td><?php if(isset($ReportingFLCF)){ echo $ReportingFLCF; } ?></td>
            <!--<td><label>Epi Week No</label></td>
            <td><?php //echo ($this->input->post('week'))?sprintf('%02d',$this->input->post('week')):''; ?></td>
            <td><label>Year</label></td>
            <td><?php //echo ($this->input->post('year'))?$this->input->post('year'):''; ?></td> -->
			<td><label>Epi Week From</label></td>
            <td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
			</td>
			<td><label>Epi Week To</label></td>
            <td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
			</td>
          </tr>
		  <tr>
		
      </table>




        <table class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
				<th rowspan="2">S #</th>
				<th rowspan="2">Week#</th>
				<th rowspan="2">Name of Reporting Unit*</th>
				<th rowspan="2">Mothers Full name*</th>
				<th rowspan="2">Head of household full name</th>
				<th rowspan="2">Age<br>in<br>Days</th>
				<th rowspan="2">Gender</th>
				<th rowspan="2">Address of the child House#/Street# etc</th>
				<th rowspan="2">UC</th>
				<th rowspan="2">Tehsil</th>
				<th rowspan="2">District</th>
				<th rowspan="2">TT Doses to Mother</th>
				<th rowspan="2">Signs & Symptoms </th>
				<th rowspan="2">Date<br>of Onset<br>dd/mm/yy</th>
				<th rowspan="2">Date<br>of Notification***<br>dd/mm/yy</th>
				<th rowspan="2">Date<br>of Field Investigation***<br>dd/mm/yy</th>
				<th rowspan="2">Diagnosed By </th>
				<th rowspan="2">Outcomes</th>
				<th rowspan="2">Antenatal Visits by Mother</th>
				<th rowspan="2">Date<br>of Delivery***<br>dd/mm/yy</th>
				<th rowspan="2">Delivery Conducted by </th>
				<th rowspan="2">Place Of Delivery</th>
				<th rowspan="2">Instrument  used for  cord cutting </th>
				<th rowspan="2">Cord Clamping Material</th>
            </tr>
              <tr></tr>          
          </thead>
          <tbody>
          <?php 
		  $previousWeekNumber = 0;
		  foreach($nnt as $key => $row){ 
		  
		  if($row['bs_cry'] == 'Yes' && $row['bs_cry'] == 'Yes' && $row['bs_cry'] == 'Yes' && $row['bs_cry'] == 'Yes'){
			  $Signs_symtoms='Yes';
		  }
		  else{$Signs_symtoms='';}
		  
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
           <tr class="nntDrillDownRow">
            <td data-id="<?php echo $row['id']; ?>"><?php echo $key+1; ?></td>
			     <td><?php echo sprintf('%02d',$row['week']); ?></td>
			     <td><?php echo $row['facility']; ?></td>
            <td><?php echo $row['full_mother_name']; ?></td>
            <td><?php echo $row['head_full_name']; ?></td>
            <td><?php echo $row['bs_days']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['house_hold_address']; ?></td>
            <td><?php echo $row['patient_unname']; ?></td>
            <td><?php echo $row['patient_tehsil']; ?></td>
            <td><?php echo $row['patient_district']; ?></td>
            <td><?php echo $row['doses_received']; ?></td>
			      <td><?php echo $Signs_symtoms; ?></td>
            <td><?php echo isset($row['date_onset']) ? date('d-M-Y',strtotime($row['date_onset'])) : ''; ?></td> 
      			<td><?php echo isset($row['date_notification']) ? date('d-M-Y',strtotime($row['date_notification'])) : ''; ?></td> 
      			<td><?php echo isset($row['date_investigation']) ? date('d-M-Y',strtotime($row['date_investigation'])) : ''; ?></td> 			  
            <td><?php echo $row['diagnosed_by']; ?></td>
			      <td></td>
            <td><?php echo $row['pregnancy_visits']; ?></td>
            <td><?php echo isset($row['date_delivery']) ? date('d-m-Y',strtotime($row['date_delivery'])) : ''; ?></td>
      			<td><?php echo $row['where_baby_delivered']; ?></td>
      			<td><?php echo $row['instrument_used']; ?></td>
      			<td><?php echo $row['cord_treated']; ?></td>
            <td></td>
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
  $('.nntDrillDownRow').css('cursor','pointer');
    $(document).on('click',".nntDrillDownRow", function(){
        var code = $(this).find("td:first-child").data('id');
		var url = '';
		 url = "<?php echo base_url();?>NNT-CIF/View/"+code;       
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
<?php } ?> <?php exit;?> 