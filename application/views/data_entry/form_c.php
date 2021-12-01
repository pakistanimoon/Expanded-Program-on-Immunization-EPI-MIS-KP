<!--start of page content or body-->
<?php
date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');?>
<div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"><?php if(isset($formC_Result)){?> Update UC Demand, Consumption & Receipt Form <?php }else{ ?> Add UC Demand, Consumption & Receipt Form <?php } ?></div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" id="form" action="<?php echo base_url(); ?>data_entry/form_C_save">
       	<?php if(isset($formC_Result)){ ?>
          <input type="hidden" name="edit" id="edit" value="edit" />
          <input type="hidden" name="id" id="id" value="<?php echo $formC_Result->id; ?>" />
        <?php } ?>
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label style="margin-top: 7px;">Campaigns Type</label></td>
            <td><select required id="campaign_type" name="campaign_type" class="form-control">
            <?php if(isset($formC_Result)){ ?>
            	<option value="<?php echo $formC_Result->campaign_type;  ?>"><?php echo $formC_Result->campaign_type;  ?></option>
            <?php }else{ ?>
              <option value="">-- Select --</option>              
              <option value="NID">NID</option>
              <option value="SNID">SNID</option>
              <option value="SIAD">SIAD</option>
              <option value="CR">CR</option>
              <option value="CCPV">CCPV</option>
              <?php } ?>
            </select></td>
            <td><label style="margin-top: 7px;">From</label></td>
            <td><input class="dp form-control" name="start_date" id="start_date" value="<?php if(isset($formC_Result)){ if($formC_Result->start_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($formC_Result->start_date)); }else{ echo ''; } } ?>" required="required" type="text"></td>
            
            <td><label style="margin-top: 7px;">To</label></td>
            <td><input class="dp form-control" name="end_date" id="end_date" value="<?php if(isset($formC_Result)){ if($formC_Result->end_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($formC_Result->end_date)); }else{ echo ''; } } ?>" required="required" type="text"></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">Province</label></td>
            <td><input readonly="readonly" class="form-control" name="province" id="province" value="Khyber Pakhtunkhwa"  type="text"></td>
            <td><label style="margin-top: 7px;">District</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
            	<?php if(isset($formC_Result)){ ?>
                <option value="<?php echo $formC_Result -> distcode; ?>"><?php echo get_District_Name($formC_Result -> distcode); ?></option>
                <?php }else{ getDistricts(false,$this -> session -> District); } ?>
              </select></td>
            <td><label style="margin-top: 7px;">Tehsil/Taluka</label></td>
            <td><select id="tcode" name="tcode" class="form-control">
              <?php if(isset($formC_Result)){ ?>
                <option value="<?php echo $formC_Result -> tcode; ?>"><?php echo get_Tehsil_Name($formC_Result -> tcode); ?></option>
                <?php }else{ ?> 
                <?php getTehsils_options(false); } ?>
              </select></td>
          </tr>
          <tr>
             
            <td><label style="margin-top: 7px;">UC</label></td>
            <td><select required id="uncode" name="uncode" class="form-control">
              <?php if(isset($formC_Result)){ ?>
                <option value="<?php echo $formC_Result -> uncode; ?>"><?php echo get_UC_Name($formC_Result -> uncode); ?></option>
                <?php }else{ ?> 
                <?php getUCs_options(false); } ?>
              </select></td>
             
          </tr>
      </table>
     
        <table class="table table-bordered table-condensed table-striped table-hover mytable" id="myTable">
          <thead>
            <tr>
              <th rowspan="3">Product</th>
              <th colspan="8">DEMAND</th>
              <th colspan="4">CONSUMPTION</th>
            </tr>
            <tr>               
              
              <th rowspan="2">Doses per<br>Vial</th>
              <th rowspan="2">Target #</th>
              <th rowspan="2">Wastage factor</th>
              <th colspan="2">Required</th>
              <th>Opening Balance</th>
              <th>Request<br>G=E-F</th>
              <th>Received</th>
              <th rowspan="2">Children Vaccinated/<br>Doses Administered </th>
              <th>Vials Used</th>
              <th>Unusable Vials</th>
              <th>Closing Balance</th>
            </tr>

            <tr>
              <th>Doses D=BxC</th>
              <th>Vials/Nos. E=D/A</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
              <th>Vials/Nos.</th>
            </tr>
            <tr style="background: white none repeat scroll 0% 0%; color: black;">
              <th></th>
              <th>A</th>
              <th>B</th>
              <th>C</th>
              <th>D</th>
              <th>E</th>
              <th>F</th>
              <th>G</th>
              <th>H</th>
              <th>I</th>
              <th>J</th>
              <th>K</th>
              <th>L</th>
            </tr>
          </thead>
          <tbody >
          	<?php
          	$VaccineArray = array(
				'mOPV1'=> '20',
				'bOPV'=> '20',
				//'tOPV'=> '20',
				'Measles'=> '10',
				'DIL Measles'=> '',
				'TT'=> '20',
				'AD Syringes 0.5 ml'=> '',
				'Recon. Syringes (5 ml)'=> '',
				'Safety Boxes'=> '',
				'Other'=> ''	
			);
          	?>
            <?php 
            $i=1;
            foreach($VaccineArray as $key=>$value){
              ?>
            <tr>
              <td style="padding-top:11px;"><?php echo $key; ?></td>
              <?php if($key == 'Other'){ ?>
              	<td><input type="text" class="form-control" name="othername" id="othername" value="<?php if(isset($formC_Result)){ echo $formC_Result -> othername;} ?>" /></td>
              <?php }else{ ?>
              <td style="padding-top:11px;<?php if($value=='' && $key != 'Other'){echo "background-color:#eee;";} ?>"><?php echo $value; ?></td>
              <?php	} ?>
              <td class="t-detail-row"><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f1" id="dcr_r<?php echo $i; ?>_f1" <?php if($value == '' && $key != 'Other'){ echo 'readonly="readonly"'; }else{ ?> value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f1"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" <?php } ?> type="text"></td>
              <td class="t-detail-row"><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f2" id="dcr_r<?php echo $i; ?>_f2" <?php if($value == '' && $key != 'Other'){ echo 'readonly="readonly"'; }else{ ?> value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f2"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" <?php } ?> type="text"></td>
              <td class="t-detail-row"><input class="form-control numberclass" readonly="readonly" name="dcr_r<?php echo $i; ?>_f3" id="dcr_r<?php echo $i; ?>_f3" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f3"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td class="t-detail-row"><input class="form-control numberclass" readonly="readonly" name="dcr_r<?php echo $i; ?>_f4" id="dcr_r<?php echo $i; ?>_f4" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f4"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td class="t-row" ><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f5" id="dcr_r<?php echo $i; ?>_f5" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f5"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" readonly="readonly" name="dcr_r<?php echo $i; ?>_f6" id="dcr_r<?php echo $i; ?>_f6" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f6"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f7" id="dcr_r<?php echo $i; ?>_f7" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f7"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f8" id="dcr_r<?php echo $i; ?>_f8" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f8"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f9" id="dcr_r<?php echo $i; ?>_f9" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f9"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f10" id="dcr_r<?php echo $i; ?>_f10" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f10"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
              <td><input class="form-control numberclass" name="dcr_r<?php echo $i; ?>_f11" id="dcr_r<?php echo $i; ?>_f11" value="<?php if(isset($formC_Result)){ $name="dcr_r".$i."_f11"; if($formC_Result->$name != '0'){ echo $formC_Result->$name; }} ?>" type="text"></td>
            </tr>
            <?php $i++; } ?>
          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Requested by</label></td>
                <td><input class="form-control" name="requested_by_name" id="requested_by_name" value="<?php if(isset($formC_Result)){ echo $formC_Result->requested_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="requested_by_desg" id="requested_by_desg" value="<?php if(isset($formC_Result)){ echo $formC_Result->requested_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="requested_by_store" id="requested_by_store" value="<?php if(isset($formC_Result)){ echo $formC_Result->requested_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="requested_on" id="requested_on" value="<?php if(isset($formC_Result)){ if($formC_Result->requested_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($formC_Result->requested_on)); }else{ echo ''; } } ?>" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Received by</label></td>
                <td><input class="form-control" name="received_by_name" id="received_by_name" value="<?php if(isset($formC_Result)){ echo $formC_Result->received_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="received_by_desg" id="received_by_desg" value="<?php if(isset($formC_Result)){ echo $formC_Result->received_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="received_by_store" id="received_by_store" value="<?php if(isset($formC_Result)){ echo $formC_Result->received_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="received_on" id="received_on" value="<?php if(isset($formC_Result)){ if($formC_Result->received_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($formC_Result->received_on)); }else{ echo ''; } } ?>" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Data Entered by</label></td>
                <td><input class="form-control" name="reported_by_name" id="reported_by_name" value="<?php if(isset($formC_Result)){ echo $formC_Result->reported_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="reported_by_desg" id="reported_by_desg" value="<?php if(isset($formC_Result)){ echo $formC_Result->reported_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="reported_by_store" id="reported_by_store" value="<?php if(isset($formC_Result)){ echo $formC_Result->reported_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="reported_on" id="reported_on" value="<?php if(isset($formC_Result)){ if($formC_Result->reported_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($formC_Result->reported_on)); }else{ echo ''; } } ?>" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
           
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
				
				 <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0"  class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
                
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
<script src="<?php echo base_url(); ?>includes/js/moment.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(document).on("change","td.t-detail-row",function(e) {
    var row = $(this).parent().parent().children().index($(this).parent());     
      var a1 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(2) input').val());
      var a2 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(3) input').val());
      var a3 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(1)').html());
      //alert(a3);
      if(isNaN(a1)){
          a1=0;
      }
      if(isNaN(a2)){
          a2=0;
      }
      var result = a1*a2;
      result = result.toFixed(0);
      if(!isNaN(a1)){
      $('#myTable tbody tr:eq('+row+') td:eq(4)').children().val(result);


      if(isNaN(a3)){
          a3=1;
      }
      var result1 = result/a3;
      result1 = Math.ceil(result1);
      //alert(result1);
      if(!isNaN(a3)){
      $('#myTable tbody tr:eq('+row+') td:eq(5)').children().val(result1);
 	  }
 	}
  });
 
  $(document).on("change","td.t-row",function(e) {
  	  var row = $(this).parent().parent().children().index($(this).parent());
   	  var a1 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(5) input').val());
      var a2 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(6) input').val());
      var a3 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(1)').html());
     // alert(a3);

      if(isNaN(a1)){
          a1=0;
      }
      if(!isNaN(a3)){
          
      
      var result =a1-a2;
      result = result.toFixed(0);
      //alert();
      if(!isNaN(a1)){
      $('#myTable tbody tr:eq('+row+') td:eq(7)').children().val(result);
  	  }
	}
  });
  
});
$(document).ready(function(){
 $("#start_date").datepicker({
	        todayBtn:  1,
	        autoclose: true,
	        format: 'dd-mm-yyyy',
	    }).on('changeDate', function (selected) {
	        var minDate = new Date(selected.date.valueOf());
	        $('#end_date').datepicker('setStartDate', minDate);
	    });

	    $("#end_date").datepicker({ format: 'dd-mm-yyyy' })
	        .on('changeDate', function (selected) {
	            var minDate = new Date(selected.date.valueOf());
	            $('#start_date').datepicker('setEndDate', minDate);
	        });
});
////Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
</script> 