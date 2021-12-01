
<div class="" style="font-size:12px;">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> AFP Investigation Line List of Suspected Cases</div>
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
            <td><label>Epi Week From</label></td>
            <td><?php echo (isset($week_from))?$year.'-'.sprintf('%02d',$week_from):''; ?>
			</td>
			<td><label>Epi Week To</label></td>
            <td><?php echo (isset($week_to))?$year.'-'.sprintf('%02d',$week_to):''; ?>
			</td>
            
          </tr>
		  <tr>
		
      </table>


	<div  id="parent">
    	<table id="fixTable" class="table table-bordered table-hover mytable">
          <thead>
            <tr>
              <th rowspan="3">Epid. No.</th>
			  <th rowspan="3">Week#</th>
              <th rowspan="3" style="min-width:200px;">Name</th>
              <th rowspan="3" style="min-width:200px;">Father's Name</th>
              <th colspan="4">Address of case</th>
              <th rowspan="3" style="min-width:68px;">Gender</th>
              <th rowspan="3" style="min-width:68px;">Age(M)</th>
              <th colspan="3">Date of</th>
              <th rowspan="3" style="min-width:56px;">Fever at onset</th>
              <th rowspan="3" style="min-width:200px;">Rapid progression</th>
              <th rowspan="3" style="min-width:72px;">Asymm paralysis</th>
              <th colspan="2">OPV Doses</th>
              <th colspan="4">Stoo Samples</th>
              <th colspan="4">Lab Results (&condition)</th>
              <th colspan="4">Follow Up</th>
            </tr>
            <tr>
              <th rowspan="2" style="min-width:200px;">Village / Muhalla</th>
              <th rowspan="2" style="min-width:200px;">UC</th>
              <th rowspan="2" style="min-width:200px;">Tehsil</th>
              <th rowspan="2" style="min-width:200px;">District</th>
              <th rowspan="2" style="min-width:94px;">Onset of Paralysis</th>
              <th rowspan="2" style="min-width:94px;">Notification</th>
              <th rowspan="2" style="min-width:100px;">Investigation</th>
              <th rowspan="2" style="min-width:64px;">Routine</th>
              <th rowspan="2">SIA</th>
              <th colspan="2">S1</th>
              <th colspan="2">S2</th>
              <th colspan="2">S1</th>
              <th colspan="2">S2</th>
              <th colspan="2">60 day follow up</th>
              <th rowspan="2" style="min-width:104px;">Classification</th>
              <th rowspan="2" style="min-width:300px;">Final diagnosis</th>
            </tr> 
            <tr>
              <th style="min-width:94px;">Date of Collection</th>
              <th style="min-width:94px;">Date sent to Lab</th>
              <th style="min-width:94px;">Date of Collection</th>
              <th style="min-width:94px;">Date sent to Lab</th>
              <th style="min-width:200px;">Condition</th>
              <th style="min-width:200px;">Final Result</th>
              <th style="min-width:200px;">Condition</th>
              <th style="min-width:200px;">Final Result</th>
              <th style="min-width:94px;">Date</th>
              <th style="min-width:84px;">Residual paralysis weakness</th>
            </tr>
          </thead>
          <tbody>
		   <?php 
		   $previousWeekNumber = 0;
		   foreach($afp as $key => $row){ 
            if($row['gender']=='1')
              $gender= 'Male';
            else if($row['gender']=='0')
              $gender= 'Female';
            else
              $gender= '';

        ?>
		<?php /* if($key == 0 || $row['week'] != $previousWeekNumber ){ */ ?>
			<!--<tr class="text-center">
				<td class="text-center success" style="font-size: 15px;font-weight: bold;text-align: left;" colspan="2">
				Week <?php /* echo sprintf('%02d',$row['week']); */ ?>
				</td>
			</tr>-->
		<?php 
			/* $previousWeekNumber = $row['week'];
		} */ ?>
            <tr class="DrillDownRow">
              	<td data-id="<?php echo $row['id']; ?>" data-facode="<?php echo $row['facode']; ?>"><?php echo $row['case_epi_no']; ?></td>
				<td><?php echo sprintf('%02d',$row['week']); ?></td>
				<td><?php echo $row['patient_name']; ?></td>
              	<td><?php echo $row['patient_fathername']; ?></td>
              	<td><?php echo $row['patient_address']; ?></td>
              	<td><?php echo $row['unname']; ?></td>
              	<td><?php echo $row['tehsilname']; ?></td>
              	<td><?php echo $row['districtname']; ?></td>
              	<td style="text-align:center;"><?php echo $gender; ?></td>
              	<td style="text-align:center;"><?php echo $row['age_months']; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['case_date_onset']) ? date('d-M-Y',strtotime($row['case_date_onset'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['case_date_notification']) ? date('d-M-Y',strtotime($row['case_date_notification'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['case_date_investigation']) ? date('d-M-Y',strtotime($row['case_date_investigation'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo $row['fever_onset']=='1' ? 'Yes' : 'No'; ?></td>
              	<td style="text-align:center;"><?php echo $row['rapid_progression']=='1' ? 'Yes' : 'No'; ?></td>
              	<td style="text-align:center;"><?php echo $row['asymm_paralysis']=='1' ? 'Yes' : 'No'; ?></td>
              	<td style="text-align:center;"><?php echo $row['doses_received']; ?></td>
              	<td style="text-align:center;"><?php echo $row['sia']; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['date_collection_s1']) ? date('d-M-Y',strtotime($row['date_collection_s1'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['date_sent_lab_s1']) ? date('d-M-Y',strtotime($row['date_sent_lab_s1'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['date_collection_s2']) ? date('d-M-Y',strtotime($row['date_collection_s2'])) : ''; ?></td>
              	<td style="text-align:center;"><?php echo isset($row['date_sent_lab_s2']) ? date('d-M-Y',strtotime($row['date_sent_lab_s2'])) : ''; ?></td>
              	<td><?php echo $row['condition_s1']; ?></td>
              	<td><?php echo $row['final_result_s1']; ?></td>
              	<td><?php echo $row['condition_s2']; ?></td>
              	<td><?php echo $row['final_result_s2']; ?></td>
              	<td style="text-align:center;"><?php echo $row['date_follow_up']; ?></td>
              	<td style="text-align:center;"><?php echo $row['residual_paralysis']; ?></td>
              	<td><?php echo $row['classification']; ?></td>
              	<td><?php echo $row['final_diagnosis']; ?></td>
            </tr>
			<?php } ?> 
             

             
          </tbody>
        </table>
    </div>
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
              <td>*Reporting For district level Reporting unit will be respective reporting health facility.for Provincial level compitition Reporting unit will be respective reporting district </td>
            </tr>
            <tr>
              <td>**Type of case means AFP, Measles, NNT, Pertusis, Diptheria & Childhood TB etc </td>
            </tr>
            <tr>
              <td>***Case epid number only applicable for AFP and measics cases to be filled at district level </td>
            </tr>
            <tr>
              <td>****Date of investigation Only applicable for AFP, Measles and NNT cases To be filled at district level from CIF </td>
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
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
/*document.getElementById("th").style.border = "thick solid #0000FF";*/
	 $(document).ready(function() {
				$("#fixTable").tableHeadFixer({"left" : 2}); 
			});
	 $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var id = $(this).find("td:first-child").data('id');
		var code = $(this).find("td:first-child").data('facode');
		var url = '';
		 url = "<?php echo base_url();?>AFP-CIF/View/"+code+"/"+id;      
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
