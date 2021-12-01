<!--start of page content or body-->
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> EPI 10 AEFI Weekly Compilation Form For District /Province</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/aefiWeeklyCompilationSave">
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label style="margin-top: 7px;">Province / Area</label></td>
            <td><input class="form-control" type="text" value="<?php echo $this -> session -> provincename ?>" readonly="readonly" /></td>
            <td><label style="margin-top: 7px;">District</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
              <?php getDistricts_options(false,$this -> session -> distcode); ?>
            </select></td>
            
            <td><label style="margin-top: 7px;">Reporting Epidemiologic Week No</label></td>
            <td><select id="epi_week_no" name="epi_week_no" class="form-control">
              	<?php if(isset($weeklyVPD)){ ?>
            		<option value="<?php echo sprintf("%02d",$weeklyVPD->epi_week); ?>">Week <?php echo sprintf("%02d",$weeklyVPD->epi_week); ?></option>
            	<?php }else{ ?>
            	<?php for($i=1;$i<54;$i++){ ?>
            	<option <?php if(isset($weeklyVPD) && $weeklyVPD->epi_week == sprintf("%02d", $i) ){ echo 'selected="selected"'; }else {  } ?> value="<?php echo sprintf("%02d", $i); ?>">Week <?php echo sprintf("%02d", $i); ?></option>
            	<?php } } ?>
            </select></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">Date from (Sunday)</label></td>
            <td><input class="dp form-control" name="date_from" id="date_from" type="text"></td>
            <td><label style="margin-top: 7px;">To (Saturday)</label></td>
            <td><input class="dp form-control" name="date_to" id="date_to" type="text"></td>
            <td><label style="margin-top: 7px;">No. of reporting sites/unit</label></td>
            <td><input class="numberclass form-control" name="no_reporting_units" id="no_reporting_units" readonly="readonly" value="<?php echo $flcf['cnt']; ?>" type="text"></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">No. reported</label></td>
            <td><input class="numberclass form-control" name="no_reported" id="no_reported" type="text"></td>
            <td><label style="margin-top: 7px;">No. reported on time</label></td>
            <td><input class="numberclass form-control" name="no_reported_ontime" id="no_reported_ontime" type="text"></td>
            <td><label style="margin-top: 7px;">No. of AEFI cases (if no, write "0")</label></td>
            <td><input class="numberclass form-control" name="no_aefi_cases" id="no_aefi_cases" type="text"></td>
          </tr>
      </table>
         




        <table class="table table-bordered table-condensed table-striped table-hover mytable" id="myTable">
          <thead>
            <tr>
              <th>S No.</th>
              <th>Tehsil/Taluka</th>
              <th>UnionCouncil</th>
              <th>Sex</th>
              <th>Date of<br>birth/age</th>
              <th>Date vaccine given</th>
              <th>Date of AEFI onset</th>
              <th>Suspected Vaccine</th>
              <th>AEFI*</th>
              <th>Hospitalization</th>
              <th>Death</th>
            </tr>
             
          </thead>
          <tbody>
            <tr>
              <td><input class="numberclass form-control" id="sno" type="text"></td>
              <td><select name="tcode[]" onchange="appendNewRow();" class="form-control">
              <?php getTehsils_options(false); ?>
            </select></td>
            <td><select name="uncode[]" class="form-control">
                <?php getUCs_options(false); ?>
              </select></td>
              <td><select name="gender[]" class="form-control">
              <option value="0">-- Select --</option>
              <option value="01">Male</option>
              <option value="02">Female</option>
            </select></td>
              <td><input class="dp form-control" name="dob[]" type="text"></td>
              <td><input class="dp form-control" name="vacc_date[]" type="text"></td>
              <td><input class="dp form-control" name="date_aefi_onset[]" type="text"></td>
              <td><input class="form-control" name="vacc_name[]" type="text"></td>
              <td><input class="form-control" name="aefi_cases[]" type="text"></td>
              <td><select name="mc_hospitalized[]" class="form-control">
              <option value="">-- Select --</option>
              <option value="0">Yes</option>
              <option value="1">No</option>
            </select></td>
              <td><select name="death[]" class="form-control">
              <option value="0">-- Select --</option>
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select></td>
            </tr>           
          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Prepared by</label></td>
                <td><input class="form-control" name="rep_person" id="rep_person" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="rep_desg" id="rep_desg" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="rep_date" id="rep_date" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Submitted by</label></td>
                <td><input class="form-control" name="submitted_by" id="submitted_by" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="submitted_desg" id="submitted_desg" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="submitted_date" id="submitted_date" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
           
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>
        <table class="table table-bordered table-striped" style="margin-top: 10px;">
          <tr>
            <td>*Write any of the following severe local reactionabscess BCG lymphadenitis encephalitis/encephalopathy, loss of consciousness, anaphyiaxis, high fever, convulsion, toxic-shock, syndrome, AFP, other(describe) </td>
          </tr>
        </table>    
         
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
<?php if(!isset($measlesLineListResult)){ ?>
<script type="text/javascript">
	function appendNewRow(){
		var html = $('#myTable tbody tr:first').html();
		$('#myTable tr:last').after('<tr>'+html+'</tr>');
		var options = {
		  format : "dd-mm-yyyy"
		};
		$('.dp').datepicker(options);
	}
</script>
<?php } ?>