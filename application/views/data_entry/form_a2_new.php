<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"><?php if(isset($formA2_Result)){?> Update District Stock Issue and Receipt Voucher Form<?php }else{ ?>Add District Stock Issue and Receipt Voucher Form<?php } ?></div>
     <div class="panel-body">
        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/form_A2_new_Save">
       	<?php if(isset($formA2_Result)){ 
		?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="group_id" id="group_id" value="<?php echo $formA2_Result['0']['group_id']; ?>" />
       	<?php } ?>
        <table class="table table-bordered   table-striped table-hover  "> 
          <tr>
            <td style="text-align: center;"><label style="margin-top: 7px;">Supply from(Distirct)</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
            	<?php if(isset($formA2_Result)){ ?>
            	<option value="<?php echo $formA2_Result['0']['distcode']; ?>"><?php echo $district; ?></option>
            	
            <?php }else{ ?>	
              <?php getDistricts_options(false,$this -> session -> District); ?>
             <?php } ?>
            </select></td>
			
			<td style="text-align: center;"><label style="margin-top: 7px;">Campaign Type</label></td>
            <td>
              <select id="campaign_type" name="campaign_type" class="form-control">
                <?php if(isset($formA2_Result)){ ?>
                  <option value="<?php echo $formA2_Result['0']['campaign_type'];  ?>"><?php echo $formA2_Result['0']['campaign_type'];  ?></option>
                <?php }else{ ?>
                  <option value="">-- Select --</option>
                  <option value="NID">NID</option>
                  <option value="SNID">SNID</option>
                  <option value="SIAD">SIAD</option>
                  <option value="CR">CR</option>
                  <option value="CCPV">CCPV</option>              
                <?php } ?>
              </select>
            </td>
			
			
			  
            
          </tr>
          <tr>
            <td style="text-align: center;"><label style="margin-top: 7px;">Vaccine Type</label></td>
            <td><select id="vaccine_type" name="vaccine_type" class="form-control">
              <?php if(isset($formA2_Result)){ ?>
                <option value="<?php echo $formA2_Result[0]['vaccine_type']; ?>"><?php echo $vaccine_name->vaccine_name; ?></option>
                <?php }else{ ?> 
                <?php getVaccines_titles(false,'a2'); } ?>
              </select></td>
            <!--<input class="form-control" name="campaign_type" id="campaign_type" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['campaign_type']; } ?>" type="text">-->
            
            <td style="text-align: center;"><label style="margin-top: 7px;">Issued Date</label></td>
            <td><input class="dp form-control" required="required" name="form_date" value="<?php if(isset($formA2_Result)){ echo  date('d-m-Y',strtotime($formA2_Result['0']['form_date'])); } ?>" id="form_date" placeholder="Select Date" type="text" data-date-end-date="0d"></td>
          </tr>
      </table>
         




        <div id="parent">
        <table id="fixTable"   class="table table-bordered table-condensed table-striped table-hover mytable3">
          <thead>
            <tr>
              <th rowspan="2" colspan="1">Union Councils</th>
			  <th rowspan="2" colspan="2">Report Submitted</th>
              <th colspan="1" rowspan="2">Doses<br>per<br>vial</th>
              <th colspan="1" rowspan="2">Manufacturer</th>
              <th colspan="1" rowspan="2">Batch#</th>
              <th colspan="1" rowspan="2">Expiry Date</th>
              <th colspan="3">Issue Quantity</th>
              <th colspan="3">Receive Quantity</th>
			 
            </tr>
            <tr>              
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (F=AxE)</th>
              <th colspan="1">VVM Stage</th>
              <th colspan="1">Vials/Nos.</th>
              <th colspan="1">Total Doses (I=AxH)</th>
              <th colspan="1">VVM Stage</th>
            </tr>
            <tr style="background:white;color:black">
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
             
            </tr>            
          </thead>
         <tbody id="myTable">
          		<?php if(isset($formA2_Result)){ 
					foreach($formA2_Result as $key => $row){ 
				?>
				 <tr>
				  <td style="padding-top:11px;"><input value="<?php echo $row['uncode']; ?>" name="uncode[<?php echo $key; ?>]" type="hidden"><?php echo get_UC_Name($row['uncode']); ?></td>
				  <td style="padding-top: 10px;"><input class="gp" name="report_submitted[<?php echo $key; ?>]" value="1" type="radio" <?php if(isset($row['report_submitted']) AND $row['report_submitted'] == '1') { echo 'checked="checked"'; } ?> ></td>
				  <td style="padding-top: 10px;"><input class="gp" name="report_submitted[<?php echo $key; ?>]"  <?php if(isset($row['report_submitted']) AND $row['report_submitted'] == '0') { echo 'checked="checked"'; } ?> value="0" type="radio"></td>
				  <td class="doses" style="padding-top:11px;"></td> 
				   <td class="ifyes en" style="display: none;"><input type="text" class="form-control zp numberclass" value="<?php if(isset($formA2_Result)){ echo $row['othername'] ; }else { } ?>" name="othername[<?php echo $key; ?>]" ><input class="doses_per_vial" value="<?php if(isset($formA2_Result)){ echo $row['doses_per_vial'] ; }else { } ?>" name="doses_per_vial[<?php echo $key; ?>]" type="hidden"></td> 


				 
				  <td class="en"><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['manufacturer'] ; }else { } ?>" name="manufacturer[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
				  <td class="en"><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['batch_no'] ; }else { } ?>" name="batch_no[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="en"><input class="dp-exp form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['expirydate'] ; }else { } ?>" name="expirydate[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="t-detail-row en"><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['iq_vialsno'] ; }else { } ?>" name="iq_vialsno[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="ab" ><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['iq_totaldoses'] ; }else { } ?>" name="iq_totaldoses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				   <td class="ab">
					<select class="form-control" name="iq_vvmstage[]">
						<option value="1" <?php if(isset($formA2_Result) && $row['iq_vvmstage']== '1' ){ echo 'selected="selected"'; } ?>>1</option>
						<option value="2" <?php if(isset($formA2_Result) && $row['iq_vvmstage']== '2' ){ echo 'selected="selected"'; } ?>>2</option>
						<option value="3" <?php if(isset($formA2_Result) && $row['iq_vvmstage']== '3' ){ echo 'selected="selected"'; } ?>>3</option>
						<option value="4" <?php if(isset($formA2_Result) && $row['iq_vvmstage']== '4' ){ echo 'selected="selected"'; } ?>>4</option>
					</select> 
				  </td>
				   <td class="t-row en ab"><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['rq_vialsno'] ; }else { } ?>" name="rq_vialsno[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
				  <td class="ab"><input class="form-control zp" value="<?php if(isset($formA2_Result)){ echo $row['rq_totaldoses'] ; }else { } ?>" name="rq_totaldoses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
				  
				  <td class="ab">
					<select class="form-control" name="rq_vvmstage[]">
						<option value="1" <?php if(isset($formA2_Result) && $row['rq_vvmstage']== '1' ){ echo 'selected="selected"'; } ?>>1</option>
						<option value="2" <?php if(isset($formA2_Result) && $row['rq_vvmstage']== '2' ){ echo 'selected="selected"'; } ?>>2</option>
						<option value="3" <?php if(isset($formA2_Result) && $row['rq_vvmstage']== '3' ){ echo 'selected="selected"'; } ?>>3</option>
						<option value="4" <?php if(isset($formA2_Result) && $row['rq_vvmstage']== '4' ){ echo 'selected="selected"'; } ?>>4</option>
					</select> 
				  
				  </td>
				 
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
			  <td class="ifyes en" style="display: none;"><input type="text" class="form-control zp numberclass" name="othername[<?php echo $key; ?>]" ><input class="doses_per_vial" name="doses_per_vial[<?php echo $key; ?>]" type="hidden"></td> 
			 

			
			 
              <td class="en"><input class="form-control zp" name="manufacturer[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en"><input class="form-control zp" name="batch_no[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="en"><input class="dp-exp form-control zp" name="expirydate[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="t-detail-row en"><input class="form-control zp" name="iq_vialsno[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="ab" ><input class="form-control zp" name="iq_totaldoses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
               <td class="ab">
				<select class="form-control" name="iq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select> 
			  </td>
			  
              <td class="t-row en ab"><input class="form-control zp" name="rq_vialsno[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="ab"><input class="form-control zp" name="rq_totaldoses[<?php echo $key; ?>]" type="text" readonly="readonly"></td>
			  
              <td class="ab">
				<select class="form-control" name="rq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select> 
			  
			  </td>
			  
              
            </tr>
			<?php  } }?>
          </tbody>
        </table>
	</div>
        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tr>
                <td colspan="2"><label style="margin-top: 7px;">Issued by</label></td>
                
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><input class="form-control" name="issued_by_name" id="issued_by_name" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['issued_by_name']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="issued_by_desg" id="issued_by_desg" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['issued_by_desg']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="issued_by_store" id="issued_by_store" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['issued_by_store']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="issued_on" id="issued_on" value="<?php if(isset($formA2_Result)){ echo  date('d-m-Y',strtotime($formA2_Result['0']['issued_on'])); } ?>" type="text" data-date-end-date="0d"></td>
              </tr>
            </table>
          </div>
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tr>
                <td colspan="2"><label style="margin-top: 7px;">Received by</label></td>
                
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><input class="form-control" name="received_by_name" id="received_by_name" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['receive_by']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="received_by_desg" id="received_by_desg" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['received_by_desg']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="received_by_store" id="received_by_store" value="<?php if(isset($formA2_Result)){ echo $formA2_Result['0']['received_by_store']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="received_on" id="received_on" value="<?php if(isset($formA2_Result)){ echo  date('d-m-Y',strtotime($formA2_Result['0']['received_on'])); } ?>" type="text" data-date-end-date="0d"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" ><i class="fa fa-floppy-o "></i> Save Form  </button>
				
				 <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" ><i class="fa fa-floppy-o "></i> Submit Form  </button>
                
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
	 $('#myTable tr td').find('select').attr("readonly", "readonly");
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
			$('#myTable tr:eq('+row+') td.ab').find('select').removeAttr("readonly", "readonly");
			
		}else if(v == 1 && doses=='' && vaccine_type !='31'){
			$('#myTable tr:eq('+row+') td.en').find('input').removeAttr("readonly", "readonly");
			
			
		}
		else if(v == 1 && vaccine_type =='31'){
			alert('here');
			$('#myTable tr:eq('+row+') td.ifyes').show();
			$('#myTable tr:eq('+row+') td.doses').hide();
			$('#myTable tr:eq('+row+') td.en').find('input').removeAttr("readonly", "readonly");
			$('.doses').html('');
		}
		else{
			$('#myTable tr:eq('+row+') td.en').find('input').attr("readonly", "readonly");
			$('#myTable tr:eq('+row+') td.ab').find('select').attr("readonly", "readonly");
			
			$('#myTable tr:eq('+row+') td.ifyes').hide();
			$('#myTable tr:eq('+row+') td.doses').show();
			
		}
});
	
	
	
 $(document).on("change","td.t-detail-row",function(e) {
	var row = $(this).parent().parent().children().index($(this).parent());    

    var a1 = parseFloat($('#myTable tr:eq('+row+') td:eq(3)').html());
	var a7 = parseFloat($('#myTable tr:eq('+row+') td:eq(8) input').val());
	if(!isNaN(a1)){
		$('#myTable tr:eq('+row+') td:eq(9)').children().val(a1*a7);
	}
 });
  $(document).on("change","td.t-row",function(e) {
	var row = $(this).parent().parent().children().index($(this).parent()); 

    var a1 = parseFloat($('#myTable tr:eq('+row+') td:eq(3)').html());
	var a10 = parseFloat($('#myTable tr:eq('+row+') td:eq(11) input').val());
	if(!isNaN(a1)){
		$('#myTable tr:eq('+row+') td:eq(12)').children().val(a1*a10);
	}
 });

	$(".dp-exp").datepicker({
		format: "yyyy-mm",
		viewMode: "months", 
		minViewMode: "months"
	});
  $(".dp").datepicker({
    format: "dd-mm-yyyy",
    viewMode: "months", 
    minViewMode: "days"
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