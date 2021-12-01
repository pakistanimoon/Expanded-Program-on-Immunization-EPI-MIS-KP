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
       <form class="form-horizontal" method="post" id="form" name="form" action="<?php echo base_url(); ?>data_entry/form_C_new_save">
       	<?php if(isset($formC_Result)){ ?>
          <input type="hidden" name="edit" id="edit" value="edit" />
          <input type="hidden" name="group_id" id="group_id" value="<?php echo $formC_Result[0]['group_id']; ?>" />
        <?php } ?>
        <table class="table table-bordered   table-striped table-hover  mytable">
          <tr>
            <td><label style="margin-top: 7px;">Campaigns Type</label></td>
            <td><select required id="campaign_type" name="campaign_type" class="form-control">
            <?php if(isset($formC_Result)){ ?>
            	<option value="<?php echo $formC_Result[0]['campaign_type'];  ?>"><?php echo $formC_Result[0]['campaign_type'];  ?></option>
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
            <td><input class="dp form-control" name="start_date" id="start_date" value="<?php if(isset($formC_Result)){ if($start_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($start_date)); }else{ echo ''; } } ?>" required="required" type="text" data-date-end-date="0d"></td>
            
            <td><label style="margin-top: 7px;">To</label></td>
            <td><input class="dp form-control" name="end_date" id="end_date" value="<?php if(isset($formC_Result)){ if($end_date!= '1969-12-31'){ echo date('d-m-Y',strtotime($end_date)); }else{ echo ''; } } ?>" required="required" type="text" data-date-end-date="0d"></td>
          </tr>
          <tr>
            <td><label style="margin-top: 7px;">Province</label></td>
            <td><input readonly="readonly" class="form-control" name="province" id="province" value=" <?php echo $this -> session -> provincename ?>"  type="text"></td>
            <td><label style="margin-top: 7px;">District</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
            	<?php if(isset($formC_Result)){ ?>
               <option value="<?php echo $formC_Result[0]['distcode']; ?>"><?php echo $district; ?></option>
                <?php }else{ getDistricts(false,$this -> session -> District); } ?>
              </select></td>
            <td><label style="margin-top: 7px;">Vaccine Type</label></td>
            <td><select id="vaccine_type" name="vaccine_type" class="form-control">
              <?php if(isset($formC_Result)){ ?>
                <option value="<?php echo $formC_Result[0]['vaccine_type']; ?>"><?php echo $vaccine_name->vaccine_name; ?></option>
                <?php }else{ ?> 
                <?php getVaccines_titles(false,'c'); } ?>
              </select></td>
          </tr>
          <tr>
             
           
             
          </tr>
      </table>
     
         <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th rowspan="3">Union Councils</th>
			  <th rowspan="3" colspan="2">Report Submitted</th>
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
			  <th style="font-weight:500;">Yes</th>
			  <th style="font-weight:500;">No</th>
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
         <tbody id="myTable">
          		<?php if(isset($formC_Result)){ 
					foreach($formC_Result as $key => $row){ 
				?>
				 <tr>
				  <td style="padding-top:11px;"><input value="<?php echo $row['uncode']; ?>" name="uncode[<?php echo $key; ?>]" type="hidden"><?php echo get_UC_Name($row['uncode']); ?></td>
				  <td style="padding-top: 10px;"><input class="gp" name="report_submitted[<?php echo $key; ?>]" value="1" type="radio"></td>
				  <td style="padding-top: 10px;"><input class="gp" name="report_submitted[<?php echo $key; ?>]" checked="checked" value="0" type="radio"></td>
				  <td class="doses" style="padding-top:11px;"></td> 
				   <td class="ifyes en" style="display: none;"><input type="text" class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['othername'] ; }else { } ?>" name="othername[<?php echo $key; ?>]" /></td> 
				  
				  <input class="doses_per_vial" value="<?php if(isset($formC_Result)){ echo $row['doses_per_vial'] ; }else { } ?>" name="doses_per_vial[<?php echo $key; ?>]" type="hidden">
				 
				  <td class="t-detail-row en"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['target'] ; }else { } ?>" name="target[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="t-detail-row en"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['wastage_facter'] ; }else { } ?>" name="wastage_facter[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="t-detail-row "><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['required_doses'] ; }else { } ?>" name="required_doses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="t-detail-row"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['required_vials'] ; }else { } ?>" name="required_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="t-row en ab" ><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['opening_bal_vials'] ; }else { } ?>" name="opening_bal_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['requested_vials'] ; }else { } ?>" name="requested_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en ab"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['recieved_vials'] ; }else { } ?>" name="recieved_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en ab"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['child_vacc_dose'] ; }else { } ?>" name="child_vacc_dose[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en ab"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['vials_used'] ; }else { } ?>" name="vials_used[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en ab"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['vials_unused'] ; }else { } ?>" name="vials_unused[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en ab"><input class="form-control zp numberclass" value="<?php if(isset($formC_Result)){ echo $row['closing_bal'] ; }else { } ?>" name="closing_bal[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				</tr>
          
           
			
         <?php    
				} 
				} else{
		 
		 foreach($resultUnC as $key => $row){ 
              ?>
            <tr>
              <td style="padding-top:11px;"><input value="<?php echo $row['uncode']; ?>" name="uncode[<?php echo $key; ?>]" type="hidden"><?php echo $row['un_name']; ?></td>
			  <td style="padding-top: 10px;"><input class="gp one" name="report_submitted[<?php echo $key; ?>]" value="1" type="radio"></td>
			  <td style="padding-top: 10px;"><input class="gp zero" name="report_submitted[<?php echo $key; ?>]" checked="checked" value="0" type="radio"></td>
              <td class="doses" style="padding-top:11px;"></td> 
			  <td class="ifyes en" style="display: none;"><input type="text" class="form-control zp numberclass" name="othername[<?php echo $key; ?>]" /></td> 
			 <input class="doses_per_vial" name="doses_per_vial[<?php echo $key; ?>]" type="hidden">
			
			 
              <td class="t-detail-row en"><input class="form-control zp numberclass" name="target[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="t-detail-row en"><input class="form-control zp numberclass" name="wastage_facter[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="t-detail-row "><input class="form-control zp numberclass" name="required_doses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="t-detail-row"><input class="form-control zp numberclass" name="required_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="t-row en ab" ><input class="form-control zp numberclass" name="opening_bal_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td><input class="form-control zp numberclass" name="requested_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en ab"><input class="form-control zp numberclass" name="recieved_vials[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en ab"><input class="form-control zp numberclass" name="child_vacc_dose[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en ab"><input class="form-control zp numberclass" name="vials_used[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en ab"><input class="form-control zp numberclass" name="vials_unused[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en ab"><input class="form-control zp numberclass" name="closing_bal[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
            </tr>
			<?php  } }?>
          </tbody>
        </table>
	</div>
        <div class="row">
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
			  
                <td><label style="margin-top: 7px;">Requested by</label></td>
                <td><input class="form-control" name="requested_by_name" id="requested_by_name" value="<?php if(isset($formC_Result)){ echo $requested_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="requested_by_desg" id="requested_by_desg" value="<?php if(isset($formC_Result)){ echo $requested_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="requested_by_store" id="requested_by_store" value="<?php if(isset($formC_Result)){ echo $requested_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="requested_on" id="requested_on" value="<?php if(isset($formC_Result)){ if($requested_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($requested_on)); }else{ echo ''; } } ?>" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Received by</label></td>
                <td><input class="form-control" name="received_by_name" id="received_by_name" value="<?php if(isset($formC_Result)){ echo $received_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="received_by_desg" id="received_by_desg" value="<?php if(isset($formC_Result)){ echo $received_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="received_by_store" id="received_by_store" value="<?php if(isset($formC_Result)){ echo $received_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="received_on" id="received_on" value="<?php if(isset($formC_Result)){ if($received_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($received_on)); }else{ echo ''; } } ?>" type="text"></td>
              </tr>
            </tbody>
          </table>
          </div>
          <div class="col-sm-4">
            <table class="table table-bordered table-striped">
              <tbody><tr>
                <td><label style="margin-top: 7px;">Data Entered by</label></td>
                <td><input class="form-control" name="reported_by_name" id="reported_by_name" value="<?php if(isset($formC_Result)){ echo $reported_by_name; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="reported_by_desg" id="reported_by_desg" value="<?php if(isset($formC_Result)){ echo $reported_by_desg; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="reported_by_store" id="reported_by_store" value="<?php if(isset($formC_Result)){ echo $reported_by_store; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="reported_on" id="reported_on" value="<?php if(isset($formC_Result)){ if($reported_on!= '1969-12-31'){ echo date('d-m-Y',strtotime($reported_on)); }else{ echo ''; } } ?>" type="text"></td>
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
	<?php if(!isset($formC_Result)) { ?>
	var vaccine_type = $("#vaccine_type :selected").val();
	$.ajax({
		type: 'POST',
		url:'<?php echo base_url(); ?>Ajax_calls/getdoses_per_vial', 
		data:'vaccine_type='+vaccine_type,
			success: function(data){
				var obj = JSON.parse(data);
				$('.doses').html(obj.doses_per_vial);
				$('.doses_per_vial').val(obj.doses_per_vial);
			}
	});
	<?php } ?>
 $(document).on("change","#vaccine_type",function(e){
	 $('#myTable tr td').find('input').attr("readonly", "readonly");
	// $('#myTable tr td').find('input').val('');
	 $('.zero').prop('checked', true);
	 $('.one').prop('checked', false);
	$('#myTable tr td.ifyes').hide();
	$('#myTable tr td.doses').show();
	 var vaccine_type = $("#vaccine_type :selected").val();
		$.ajax({
			type: 'POST',
			url:'<?php echo base_url(); ?>Ajax_calls/getdoses_per_vial', 
			data:'vaccine_type='+vaccine_type,
				success: function(data){
					var obj = JSON.parse(data);
					$('.doses').html(obj.doses_per_vial);
				}
		});
	
 });
 
 $('.gp').on("click",function(){
	 
		var row = $(this).parent().parent().index();
		var v = $(this).val();
		var doses = $('.doses').html();
		var vaccine_type = $("#vaccine_type :selected").val();
		if(v == 1 && doses!=''){
			$('#myTable tr:eq('+row+') td.en').find('input').removeAttr("readonly", "readonly");
			
		}else if(v == 1 && doses=='' && vaccine_type !='40'){
			$('#myTable tr:eq('+row+') td.ab').find('input').removeAttr("readonly", "readonly");
		}
		else if(v == 1 && vaccine_type =='40'){
			$('#myTable tr:eq('+row+') td.ifyes').show();
			$('#myTable tr:eq('+row+') td.doses').hide();
			$('#myTable tr:eq('+row+') td.en').find('input').removeAttr("readonly", "readonly");
			$('.doses').html('');
			
		}
		else{
			$('#myTable tr:eq('+row+') td.en').find('input').attr("readonly", "readonly");
			$('#myTable tr:eq('+row+') td.ifyes').hide();
			$('#myTable tr:eq('+row+') td.doses').show();
			
		}
	});
 
  $(document).on("change","td.t-detail-row",function(e) {
	  
    var row = $(this).parent().parent().children().index($(this).parent());     
	
      var a1 = parseFloat($('#myTable tr:eq('+row+') td:eq(5) input').val());
      var a2 = parseFloat($('#myTable tr:eq('+row+') td:eq(6) input').val());
      var a3 = parseFloat($('#myTable tr:eq('+row+') td:eq(3)').html());
	  var vaccine_type = $("#vaccine_type :selected").val();
	 if(vaccine_type == '40'){
		   var a3 = parseFloat($('#myTable tr:eq('+row+') td:eq(4) input').val());
	  }
	 
     if(isNaN(a1)){
          a1=0;
      }
      if(isNaN(a2)){
          a2=0;
      }
      var result = a1*a2;
      result = result.toFixed(0);
      if(!isNaN(a1)){
      $('#myTable tr:eq('+row+') td:eq(7)').children().val(result);


      if(isNaN(a3)){
          a3=1;
      }
      var result1 = result/a3;
      result1 = Math.ceil(result1);
      //alert(result1);
      if(!isNaN(a3)){
      $('#myTable tr:eq('+row+') td:eq(8)').children().val(result1);
 	  }
 	}
  });
 
  $(document).on("change","td.t-row",function(e) {
	  //alert('here');
  	  var row = $(this).parent().parent().children().index($(this).parent());
   	  var a1 = parseFloat($('#myTable tr:eq('+row+') td:eq(8) input').val());
      var a2 = parseFloat($('#myTable tr:eq('+row+') td:eq(9) input').val());
      var a3 = parseFloat($('#myTable tr:eq('+row+') td:eq(3)').html());
	  var vaccine_type = $("#vaccine_type :selected").val();
      if(vaccine_type == '40'){
		   var a3 = parseFloat($('#myTable tr:eq('+row+') td:eq(4) input').val());
	  }

      if(isNaN(a1)){
          a1=0;
      }
      if(!isNaN(a3)){
		  var result =a1-a2;
		  result = result.toFixed(0);
		  //alert();
		  if(!isNaN(a1)){
		  $('#myTable tr:eq('+row+') td:eq(10)').children().val(result);
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