<!--start of page content or body-->
 <div class="container" style="width:1346px!important;">

  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Line List for NNT cases</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Linelists/nnt_linelist_save" style="margin-left: -15px;margin-right: -15px;">
       	
       	<?php if(isset($nntLineListResult)){ ?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="groupId" id="groupId" value="<?php echo $nntLineListResult[0]['linelist_group']; ?>" />
       	<?php } ?>
       	
        <table class="table table-bordered table-condensed table-striped table-hover mytable" id="myTable">
          <thead>
            <tr>
              <th>S#</th>
              <th>Reported From</th>
              <th>Case EPID NO</th>
              <th>Name & Father's Name</th>
              <th>Age In Days</th>
              <th>Sex</th>
              <th>Contact #</th>
              <th>Village</th>
              <th>District</th>
              <th>Tehsil</th>
              <th>Union Council</th>
              <th>TT Doses to Mother</th>
              <th>Signs & Symptoms</th>
              <th>Date of Onset</th>
              <th>Date of Notification</th>
              <th>Date of<br>Field<br>Investigation</th>
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
            			
		              <td><label><input type="hidden" name="idofeachrow[<?php echo $key; ?>]" id="idofeachrow" value="<?php echo $row['id']; ?>" /><input class="expand form-control" name="ser[]" id="ser" value="<?php echo $key+1; ?>" type="text"></label></td>
		              <td><input class="expand form-control" name="reported_from[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['reported_from']; } ?>" type="text"></td>
		              <td><input class="expand form-control" required="required" name="case_epi_no[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['case_epi_no']; } ?>" onkeyup="appendNewRow(this.id);" type="text"></td>
		              <td><input class="expand form-control" name="fname_father[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['fname_father']; } ?>" type="text"></td>
		              <td><input class="expand form-control numberclass" name="age_in_days[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['age_in_days']; } ?>" type="text"></td>
		              <td><select name="gender[<?php echo $key; ?>]" class="form-control">
		              <option value="">--Select--</option>
		              <option <?php if(isset($nntLineListResult) && ($row['gender'] == 'Male')){ echo 'selected="selected"'; } ?> value="Male">Male</option>
		              <option <?php if(isset($nntLineListResult) && ($row['gender'] == 'Female')){ echo 'selected="selected"'; } ?> value="Female">Female</option>
		            </select></td>
		              <td><input class="expand form-control" name="contact_no[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['id']; } ?>" type="text"></td>
		              <td><input class="expand form-control" name="village[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['id']; } ?>" type="text"></td>
		              <td><select name="distcode[<?php echo $key; ?>]" class="form-control">
		              	
		              <?php getDistricts_options(false,$this -> session -> District); ?>
		            </select></td>
		              <td><select name="tcode[<?php echo $key; ?>]" class="form-control">
		              <?php getTehsils_options(false,$row['tcode']); ?>
		            </select></td>
		              <td><select name="uncode[<?php echo $key; ?>]" class="form-control">
		              <?php getUCs_options(false,$row['uncode']); ?>
		            </select></td>
		              <td><input class="expand form-control numberclass" name="tt_doses_mother[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['tt_doses_mother']; } ?>" type="text"></td>
		              <td><input class="expand form-control" name="signs_symptoms[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['signs_symptoms']; } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_onset[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo date('d-m-Y',strtotime($row['date_onset'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_notification[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo date('d-m-Y',strtotime($row['date_notification'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_investigation[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo date('d-m-Y',strtotime($row['date_investigation'])); } ?>" type="text"></td>
		              <td><input class="expand form-control" name="diagnosed_by[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['diagnosed_by']; } ?>" type="text"></td>
		              <td><input class="expand form-control" name="out_come[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['out_come']; } ?>" type="text"></td>
		              <td><input class="expand form-control numberclass" name="antenatal_visits[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['antenatal_visits']; } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_delivery[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo date('d-m-Y',strtotime($row['date_delivery'])); } ?>" type="text"></td>
		              <td><input class="expand form-control" name="delivery_by[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['delivery_by']; } ?>" type="text"></td>
		              <td><input class="expand form-control" name="place_of_delivery[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['place_of_delivery']; } ?>" type="text"></td>
		              <td><input class="expand form-control" name="instrument_cord[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['instrument_cord']; } ?>" type="text"></td>
		              <td><input class="expand2 form-control" name="cord_clamping_material[<?php echo $key; ?>]" value="<?php if(isset($nntLineListResult)){ echo $row['cord_clamping_material']; } ?>" type="text"></td>
		            </tr>
            	<?php } }else{ ?>
            <tr>
              <td><label>1</label></td>
              <td><input class="expand form-control" name="reported_from[]" type="text"></td>
              <td><input class="expand form-control epidnumber" name="case_epi_no[]" id="case_epi_no" onkeyup="appendNewRow(this.id);" type="text"></td> <!-- -->
              <td><input class="expand form-control" name="fname_father[]" type="text"></td>
              <td><input class="expand form-control numberclass" name="age_in_days[]" type="text"></td>
              <td><select name="gender[]" class="form-control">
              <option value="">--Select--</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select></td>
              <td><input class="expand form-control" name="contact_no[]" type="text"></td>
              <td><input class="expand form-control" name="village[]" type="text"></td>
              <td><select name="distcode[]" class="form-control">
              <?php getDistricts_options(false,$this -> session -> District); ?>
            </select></td>
              <td><select name="tcode[]" class="form-control">
              <?php getTehsils_options(false); ?>
            </select></td>
              <td><select name="uncode[]" class="form-control">
              <?php getUCs_options(false); ?>
            </select></td>
              <td><input class="expand form-control numberclass" name="tt_doses_mother[]" type="text"></td>
              <td><input class="expand form-control" name="signs_symptoms[]" type="text"></td>
              <td><input class="dp form-control" name="date_onset[]" type="text"></td>
              <td><input class="dp form-control" name="date_notification[]" type="text"></td>
              <td><input class="dp form-control" name="date_investigation[]" type="text"></td>
              <td><input class="expand form-control" name="diagnosed_by[]" type="text"></td>
              <td><input class="expand form-control" name="out_come[]" type="text"></td>
              <td><input class="expand form-control numberclass" name="antenatal_visits[]" type="text"></td>
              <td><input class="dp form-control" name="date_delivery[]" type="text"></td>
              <td><input class="expand form-control" name="delivery_by[]" type="text"></td>
              <td><input class="expand form-control" name="place_of_delivery[]" type="text"></td>
              <td><input class="expand form-control" name="instrument_cord[]" type="text"></td>
              <td><input class="expand2 form-control" name="cord_clamping_material[]" type="text"></td>
            </tr> 
            <?php } ?>         
          </tbody>
        </table>

         
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>      
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->
<?php if(!isset($nntLineListResult)){ ?>
<script type="text/javascript">
	function appendNewRow(id){
		var row = $('#myTable').find(' tbody tr:last').find('#case_epi_no').val();
		if($('#'+id).val().length > 2 && row != ''){
			var html = $('#myTable tbody tr:first').html();
			$('#myTable tr:last').after('<tr>'+html+'</tr>');
			var options = {
			  format : "dd-mm-yyyy"
			};
			$('.dp').datepicker(options);
		}
	}
</script>
<?php } ?>