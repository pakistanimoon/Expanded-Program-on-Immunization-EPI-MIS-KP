<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Measles Outbreak Investigation Line List of Suspected Cases</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Linelists/measles_linelist_save" >
        <?php if(isset($measlesLineListResult)){ ?>
        	<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="groupId" id="groupId" value="<?php echo $measlesLineListResult[0]['linelist_group']; ?>" />
        <?php } ?>
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
          	<td><label style="margin-top: 7px;">Province/Area</label></td>
            <td><input id="province" class="form-control" value="Khyber Pakhtunkhwa" readonly="readonly" /></td>
            <td><label style="margin-top: 7px;">District</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
            	<?php getDistricts_options(false,$this -> session -> District); ?>
            </select></td>
            <td><label style="margin-top: 7px;">Tehsil/Taluka</label></td>
            <td><select id="tcode" name="tcode" class="form-control">
            	<?php if(isset($measlesLineListResult)){ 
            		getTehsils_options(false,$measlesLineListResult[0]['tcode']);
            	}else{ ?>
            	<?php getTehsils_options(false); } ?>
            </select></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">Union Council</label></td>
            <td><select id="uncode" name="uncode" class="form-control">
            	<?php if(isset($measlesLineListResult)){
            		getUCs_options(false,$measlesLineListResult[0]['uncode']);
            	}else{ ?>
            	<?php getUCs_options(false); } ?>
            </select></td>
           	<td><label style="margin-top: 7px;">Village/Mahalla</label></td>
            <td><input id="village_mahalla" name="village_mahalla" class="form-control" value="<?php if(isset($measlesLineListResult)){ echo $measlesLineListResult[0]['village_mahalla']; } ?>" /></td>
            <td><label style="margin-top: 7px;">Investigation done by</label></td>
            <td><input class="form-control" name="investigation_by" id="investigation_by" value="<?php if(isset($measlesLineListResult)){ echo $measlesLineListResult[0]['investigation_by']; } ?>" type="text"></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">Date of Investigation</label></td>
            <td><input class="dp form-control" name="date_investigation" id="date_investigation" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($measlesLineListResult[0]['date_investigation'])); } ?>" type="text"></td>
          </tr>
      </table>
      <table id="myTable" class="table table-bordered table-condensed table-striped table-hover mytable">
          <thead>
            <tr>
              <th rowspan="2">S #</th>
              <th rowspan="2">Name of case & Father's name</th>
              <th rowspan="2">Case EPID # (to be filled in district)</th>
              <th rowspan="2">Age<br>in<br>Months</th>
              <th rowspan="2">Sex</th>
              <th rowspan="2">Address of the child House#/Street# etc</th>
              <th rowspan="2"># of measles<br>vaccine doses received</th>
              <th rowspan="2">Date<br>of last<br> measles dose</th>
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
          	<?php if(isset($measlesLineListResult)){ 
            	foreach($measlesLineListResult as $key => $row){ ?>
            		<tr>
		              <td><label><input type="hidden" name="idofeachrow[<?php echo $key; ?>]" id="idofeachrow" value="<?php echo $row['id']; ?>" /><input class="expand form-control" name="ser[]" id="ser" value="<?php echo $key+1; ?>" type="text"></label></td>
		              <td><input class="form-control expand" name="fname_father[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['fname_father']; } ?>" type="text"></td>
		              <td><input class="form-control expand epidnumber" name="case_epi_no[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['case_epi_no']; } ?>" id="case_epi_no" onkeyup="appendNewRow(this.id);" type="text"></td>
		              <td><input class="form-control expand numberclass" name="age_in_months[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['age_in_months']; } ?>" type="text"></td>
		              <td><select name="gender[<?php echo $key; ?>]" class="form-control">
					  <option value="">Select</option>
		              <option <?php if(isset($measlesLineListResult) && ($row['gender'] == 'Male')){ echo 'selected="selected"'; } ?> value="Male">Male</option>
		              <option <?php if(isset($measlesLineListResult) && ($row['gender'] == 'Female')){ echo 'selected="selected"'; } ?> value="Female">Female</option>
		              </select></td>
		              <td><input class="form-control expand" name="child_address[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['child_address']; } ?>" type="text"></td>
		              <td><input class="form-control expand numberclass" name="vacc_dose_no[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['vacc_dose_no']; } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_last_dose[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_last_dose'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_rash_onset[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_rash_onset'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_collection_blood[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_collection_blood'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_collection_throat[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_collection_throat'])); } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_follow_up[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_follow_up'])); } ?>" type="text"></td>
		              <td><input class="form-control" name="complication[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo $row['complication']; } ?>" type="text"></td>
		              <td><input class="dp form-control" name="date_death[<?php echo $key; ?>]" value="<?php if(isset($measlesLineListResult)){ echo date('d-m-Y',strtotime($row['date_death'])); } ?>" type="text"></td>
		            </tr>
            	<?php } }else{ ?>
            <tr>
              <td><input class="form-control expand numberclass" id="ser_no" type="text"></td>
              <td><input class="form-control expand" name="fname_father[]" type="text"></td>
              <td><input class="form-control expand epidnumber" name="case_epi_no[]" id="case_epi_no" onkeyup="appendNewRow(this.id);" type="text"></td>
              <td><input class="form-control expand numberclass" name="age_in_months[]" type="text"></td>
              <td><select name="gender[]" class="form-control">
			  <option value="">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              </select></td>
              <td><input class="form-control expand" name="child_address[]" type="text"></td>
              <td><input class="form-control expand numberclass" name="vacc_dose_no[]" type="text"></td>
              <td><input class="dp form-control" name="date_last_dose[]" type="text"></td>
              <td><input class="dp form-control" name="date_rash_onset[]" type="text"></td>
              <td><input class="dp form-control" name="date_collection_blood[]" type="text"></td>
              <td><input class="dp form-control" name="date_collection_throat[]" type="text"></td>
              <td><input class="dp form-control" name="date_follow_up[]" type="text"></td>
              <td><input class="form-control" name="complication[]" type="text"></td>
              <td><input class="dp form-control" name="date_death[]" type="text"></td>
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
<?php if(!isset($measlesLineListResult)){ ?>
<script type="text/javascript">
	function appendNewRow(id){
		var row = $('#myTable').find(' tbody tr:last').find('.epidnumber').val();
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