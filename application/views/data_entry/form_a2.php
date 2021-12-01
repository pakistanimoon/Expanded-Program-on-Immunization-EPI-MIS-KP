<!--start of page content or body-->
 <div class="container bodycontainer">
  
<div class="row">
 <div class="panel panel-primary">
 	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
   <div class="panel-heading"><?php if(isset($formB_Result)){?> Update District Stock Issue and Receipt Voucher Form<?php }else{ ?>Add District Stock Issue and Receipt Voucher Form<?php } ?></div>
     <div class="panel-body">
        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/form_A2_Save">
       	<?php if(isset($formB_Result)){ 
		?>
       		<input type="hidden" name="edit" id="edit" value="edit" />
       		<input type="hidden" name="id" id="id" value="<?php echo $formB_Result['0']['id']; ?>" />
       	<?php } ?>
        <table class="table table-bordered   table-striped table-hover  "> 
          <tr>
            <td style="text-align: center;"><label style="margin-top: 7px;">Supply from(Distirct)</label></td>
            <td><select id="distcode" name="distcode" class="form-control">
            	<?php if(isset($formB_Result)){ ?>
            	<option value="<?php echo $formB_Result['0']['distcode']; ?>"><?php echo $district; ?></option>
            	
            <?php }else{ ?>	
              <?php getDistricts_options(false,$this -> session -> District); ?>
             <?php } ?>
            </select></td>
            <td style="text-align: center;"><label style="margin-top: 7px;">Issued To(Facility)</label></td>
            <td><select id="facode" name="facode" class="form-control">
        	<?php if(isset($formB_Result)){ ?>
        	<option value="<?php echo $formB_Result['0']['facode']; ?>"><?php echo $facility; ?></option>
            <?php }else{ ?>
             <?php getFacilities_options(false); ?>
             <?php } ?>
            </select></td>
          </tr>
          <tr>
            <td style="text-align: center;"><label style="margin-top: 7px;">Campaign Type</label></td>
            <td>
              <select id="campaign_type" name="campaign_type" class="form-control">
                <?php if(isset($formB_Result)){ ?>
                  <option value="<?php echo $formB_Result['0']['campaign_type'];  ?>"><?php echo $formB_Result['0']['campaign_type'];  ?></option>
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
            <!--<input class="form-control" name="campaign_type" id="campaign_type" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['campaign_type']; } ?>" type="text">-->
            
            <td style="text-align: center;"><label style="margin-top: 7px;">Issued Date</label></td>
            <td><input class="dp form-control" required="required" name="form_date" value="<?php if(isset($formB_Result)){ echo  date('d-m-Y',strtotime($formB_Result['0']['form_date'])); } ?>" id="form_date" placeholder="Select Date" type="text"></td>
          </tr>
      </table>
         




         <table class="table table-bordered table-condensed table-striped table-hover mytable" id="myTable">
          <thead>
            <tr>
              <th rowspan="2">Products</th>
              <th colspan="1" rowspan="2">Doses per vial</th>
              <th colspan="1" rowspan="2">Manufacturer</th>
              <th colspan="1" rowspan="2">Batch#</th>
              <th colspan="1" rowspan="2">Expiry Date</th>
              <th colspan="3">Issue Quantity</th>
              <th colspan="3">Receive Quantity</th>
			  <th colspan="1" rowspan="2">Add Row</th>
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
              <td></td>
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
            </tr>            
          </thead>
          <tbody>
          	<?php $i=1; 
			//echo '<pre>';print_r($vaccine_titles);exit;
			//echo '<pre>';print_r($properOrderedArray);exit;
		if(isset($properOrderedArray)){ 
		$temp_val='';
		$i='0';$k=0;
		//echo '<pre>';print_r($sorted_array);exit;
			foreach($properOrderedArray  as $key => $vacc) {
				$m=0;
				if(count($vacc) > 0){
					for($m ;$m < count($vacc); $m++){
					?> 
					<tr>
					   <td style="text-align: center;padding-top: 11px;"><?php if(isset($key)){ echo $key; }  ?></td>
					  <?php if($key == 'Other' && $sorted_array[$k]['doses_per_vial'] == ''){ ?>
					  <td><input class="form-control" name="other_name[]" id="other_name" value="<?php if(isset($key)){ echo $key; }   ?>" type="text"></td>
					  <?php } ?>
					  <?php if($key != 'Other' && $sorted_array[$k]['doses_per_vial'] == ''){ ?>
					  <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>	
					  <?php }if($sorted_array[$k]['doses_per_vial'] != ''){ ?>
					  <td style="text-align: center;padding-top: 11px;"><?php echo $sorted_array[$k]['doses_per_vial']; ?></td>
					  <?php } 
					  ?>
					 <input class="form-control numberclass" name="column_id[]" value="<?php  if(isset($vacc[$m]['id'])){ echo $vacc[$m]['id']; } ?>" type="hidden">
					  <input class="form-control numberclass" name="vaccine_id[]" value="<?php  if(isset($vacc[$m]['vaccine_id'])){ echo $vacc[$m]['vaccine_id']; } ?>" type="hidden">
					  <td><input class="form-control" name="manufacturer[]" value="<?php if(isset($vacc[$m]['manufacturer'])){ echo $vacc[$m]['manufacturer']; } ?>" type="text">
					  </td>
					  <td><input class="form-control " name="batch[]" value="<?php if(isset($vacc[$m]['batch_no'])){ echo $vacc[$m]['batch_no']; } ?>" type="text"></td>
					  <td><input class="dp-my form-control" name="expirydate[]" value="<?php if(isset($vacc[$m]['expirydate'])){ echo $vacc[$m]['expirydate']; } ?>" type="text"></td>
					  <td class="t-detail-row"><input class="form-control numberclass" name="iq_vialsno[]" value="<?php if(isset($vacc[$m]['iq_vialsno'])){ echo $vacc[$m]['iq_vialsno']; } ?>" type="text"></td>
					  <?php if($sorted_array[$k] == ''){ ?>
					  <td><input class="form-control numberclass" readonly="readonly" name="iq_totaldoses[]" value="<?php if(isset($vacc[$m]['iq_totaldoses'])){ echo $vacc[$m]['iq_totaldoses']; } ?>" type="text" readonly="readonly"></td>
					  <td>
					  <input class="form-control numberclass" readonly="readonly" name="iq_totaldoses[]" value="<?php if(isset($vacc[$m]['iq_vvmstage'])){ echo $vacc[$m]['iq_vvmstage']; } ?>" type="text"  readonly="readonly">
					  </td>
					  <?php }else{ ?>
					  <td><input class="form-control numberclass" readonly="readonly"  name="iq_totaldoses[]" value="<?php if(isset($vacc[$m]['iq_totaldoses'])){ echo $vacc[$m]['iq_totaldoses']; } ?>" type="text"></td>
					  <td>
					   <select class="form-control" name="iq_vvmstage[]">
						  <option value="1"<?php if(isset($vacc[$m]['iq_vvmstage']) && $vacc[$m]['iq_vvmstage']== '1' ){ echo 'selected="selected"'; } ?>>1</option>
						  <option value="2"<?php if(isset($vacc[$m]['iq_vvmstage']) && $vacc[$m]['iq_vvmstage']== '2' ){ echo 'selected="selected"'; } ?>>2</option>
						  <option value="3"<?php if(isset($vacc[$m]['iq_vvmstage']) && $vacc[$m]['iq_vvmstage']== '3' ){ echo 'selected="selected"'; } ?>>3</option>
						  <option value="4"<?php if(isset($vacc[$m]['iq_vvmstage']) && $vacc[$m]['iq_vvmstage']== '4' ){ echo 'selected="selected"'; } ?>>4</option>
						</select> 
					  </td>	
					  <?php } ?>
					  <td class="t-row"><input class="form-control numberclass" name="rq_vialsno[]" value="<?php if(isset($vacc[$m]['rq_vialsno'])){ echo $vacc[$m]['rq_vialsno']; } ?>" type="text"></td>
					  <?php if($sorted_array[$k] == ''){ ?>
					  <td><input class="form-control numberclass" readonly="readonly" name="rq_totaldoses[]"  value="<?php if(isset($vacc[$m]['rq_totaldoses'])){ echo $vacc[$m]['rq_totaldoses']; } ?>" type="text"  readonly="readonly"></td>
					  <td><input class="form-control numberclass" name="rq_vvmstage[]" value="<?php if(isset($vacc[$m]['rq_vvmstage'])){ echo $vacc[$m]['rq_vvmstage']; } ?>" type="text"  readonly="readonly"></td>
					  <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>
					  <?php }else{ ?>
					  <td><input class="form-control numberclass" readonly="readonly" name="rq_totaldoses[]" value="<?php if(isset($vacc[$m]['rq_totaldoses'])){ echo $vacc[$m]['rq_totaldoses']; } ?>" type="text"></td>
					  <td><select class="form-control" name="rq_vvmstage[]">
						  <option value="1"<?php if(isset($vacc[$m]['rq_vvmstage']) && $vacc[$m]['rq_vvmstage']== '1' ){ echo 'selected="selected"'; } ?>>1</option>
						  <option value="2"<?php if(isset($vacc[$m]['rq_vvmstage']) && $vacc[$m]['rq_vvmstage']== '2' ){ echo 'selected="selected"'; } ?>>2</option>
						  <option value="3"<?php if(isset($vacc[$m]['rq_vvmstage']) && $vacc[$m]['rq_vvmstage']== '3' ){ echo 'selected="selected"'; } ?>>3</option>
						  <option value="4"<?php if(isset($vacc[$m]['rq_vvmstage']) && $vacc[$m]['rq_vvmstage']== '4' ){ echo 'selected="selected"'; } ?>>4</option>
						</select>
					</td>
					 <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></td> 
					  <?php 
					  } ?>  
					</tr>
				<?php $i++;; 
				}
			}else{ ?>
				<tr>
              <td style="text-align: center;padding-top: 11px;"><?php echo $key; ?></td>
              <?php if($key == 'Other' &&  $sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td><input class="form-control" name="other_name[]" id="other_name" value="" type="text"></td>
              <?php } ?>
              <?php if($key != 'Other' &&  $sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>	
              <?php }if( $sorted_array[$k]['doses_per_vial'] != ''){ ?>
              <td style="text-align: center;padding-top: 11px;"><?php echo $sorted_array[$k]['doses_per_vial']; ?></td>
              <?php } 
			  ?>
			  <input class="form-control numberclass" name="vaccine_id[]" value="<?php echo $sorted_array[$k]['id']; ?>" type="hidden">
			   <input class="form-control numberclass" name="column_id[]" value="" type="hidden">
              <td><input class="form-control" name="manufacturer[]" value="" type="text">
			  </td>
              <td><input class="form-control" name="batch[]" value="" type="text"></td>
              <td><input class="dp-my form-control" name="expirydate[]" value="" type="text"></td>
              <td class="t-detail-row"><input class="form-control numberclass" name="iq_vialsno[]" value="" type="text"></td>
              <?php if($sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td><input class="form-control numberclass" readonly="readonly"  name="iq_totaldoses[]" value="" type="text"  readonly="readonly"></td>
              <td>
			  <input class="form-control numberclass" name="iq_vvmstage[]" value="" type="text"  readonly="readonly">
			  </td>
              <?php }else{ ?>
              <td><input class="form-control numberclass" readonly="readonly"  name="iq_totaldoses[]" value="" type="text"></td>
              <td>
			   <select class="form-control" name="iq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select> 
			  </td>	
              <?php } ?>
              <td class="t-row"><input class="form-control numberclass" name="rq_vialsno[]" value="" type="text"></td>
              <?php if($sorted_array[$k]['doses_per_vial'] == ''){ ?>
              <td><input class="form-control numberclass" readonly="readonly" name="rq_totaldoses[]"  value="" type="text"  readonly="readonly"></td>
              <td><input class="form-control numberclass" name="rq_vvmstage[]" value="" type="text"  readonly="readonly"></td>
			  <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>
              <?php }else{ ?>
              <td><input class="form-control numberclass" readonly="readonly"  name="rq_totaldoses[]" value="" type="text"></td>
              <td><select class="form-control" name="rq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select>
			</td>
			 <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></td> 
              <?php } ?>  
            </tr>
			<?php 
			}
			$k++;
			}
		}
		else{
			foreach($vaccine_titles  as $vacc) {?>
            <tr>
              <td style="text-align: center;padding-top: 11px;"><?php echo $vacc['vaccine_name']; ?></td>
              <?php if($vacc['vaccine_name'] == 'Other' && $vacc['doses_per_vial'] == ''){ ?>
              <td><input class="form-control" name="other_name[]" id="other_name" value="" type="text"></td>
              <?php } ?>
              <?php if($vacc['vaccine_name'] != 'Other' && $vacc['doses_per_vial'] == ''){ ?>
              <td style="text-align: center; padding-top:11px;background-color:#eee;"></td>	
              <?php }if($vacc['doses_per_vial'] != ''){ ?>
              <td style="text-align: center;padding-top: 11px;"><?php echo $vacc['doses_per_vial']; ?></td>
              <?php } 
			  ?>
			  <input class="form-control numberclass" name="vaccine_id[]" value="<?php echo $vacc['id']; ?>" type="hidden">
              <td><input class="form-control" name="manufacturer[]" value="" type="text">
			  </td>
              <td><input class="form-control" name="batch[]" value="" type="text"></td>
              <td><input class="dp-my form-control" name="expirydate[]" value="" type="text"></td>
              <td class="t-detail-row"><input class="form-control numberclass" name="iq_vialsno[]" value="" type="text"></td>
              <?php if($vacc['doses_per_vial'] == ''){ ?>
              <td><input class="form-control numberclass" readonly="readonly" name="iq_totaldoses[]" value="" type="text"  readonly="readonly"></td>
              <td>
			  <input class="form-control numberclass" name="iq_vvmstage[]" value="" type="text"  readonly="readonly">
			  </td>
              <?php }else{ ?>
              <td><input class="form-control numberclass" readonly="readonly" name="iq_totaldoses[]" value="" type="text"></td>
              <td>
			   <select class="form-control" name="iq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option> 
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select> 
			  </td>	
              <?php } ?>
              <td class="t-row"><input class="form-control numberclass" name="rq_vialsno[]" value="" type="text"></td>
              <?php if($vacc['doses_per_vial'] == ''){ ?>
              <td><input class="form-control numberclass" readonly="readonly" name="rq_totaldoses[]"  value="" type="text"  readonly="readonly"></td>
              <td><input class="form-control numberclass" name="rq_vvmstage[]" value="" type="text"  readonly="readonly"></td>
			  <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>
              <?php }else{ ?>
              <td><input class="form-control numberclass" readonly="readonly" name="rq_totaldoses[]" value="" type="text"></td>
              <td><select class="form-control" name="rq_vvmstage[]">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				</select>
			</td>
			 <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></td> 
              <?php } ?>  
            </tr>
            <?php $i++; }
		}			?>
          </tbody>
        </table>

        <div class="row">
          <div class="col-sm-6">
            <table class="table table-bordered table-striped">
              <tr>
                <td colspan="2"><label style="margin-top: 7px;">Issued by</label></td>
                
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Name</label></td>
                <td><input class="form-control" name="issued_by_name" id="issued_by_name" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_name']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="issued_by_desg" id="issued_by_desg" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_desg']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="issued_by_store" id="issued_by_store" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['issued_by_store']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="issued_on" id="issued_on" value="<?php if(isset($formB_Result)){ echo  date('d-m-Y',strtotime($formB_Result['0']['issued_on'])); } ?>" type="text"></td>
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
                <td><input class="form-control" name="received_by_name" id="received_by_name" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['receive_by']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Designation</label></td>
                <td><input class="form-control" name="received_by_desg" id="received_by_desg" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['received_by_desg']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Store Name</label></td>
                <td><input class="form-control" name="received_by_store" id="received_by_store" value="<?php if(isset($formB_Result)){ echo $formB_Result['0']['received_by_store']; } ?>" type="text"></td>
              </tr>
              <tr>
                <td><label style="margin-top: 7px;">Date</label></td>
                <td><input class="dp form-control" name="received_on" id="received_on" value="<?php if(isset($formB_Result)){ echo  date('d-m-Y',strtotime($formB_Result['0']['received_on'])); } ?>" type="text"></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
				
				 <button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
                
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
 $(document).on("change","td.t-detail-row",function(e) {
	var row = $(this).parent().parent().children().index($(this).parent());    
    var a1 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(1)').html());
	if(!isNaN(a1)){
		$('#myTable tbody tr:eq('+row+') td:eq(6)').children().val(a1*parseFloat($(this).children().val()));
	}
 });
  $(document).on("change","td.t-row",function(e) {
	var row = $(this).parent().parent().children().index($(this).parent());    
    var a1 = parseFloat($('#myTable tbody tr:eq('+row+') td:eq(1)').html());
	if(!isNaN(a1)){
		$('#myTable tbody tr:eq('+row+') td:eq(9)').children().val(a1*parseFloat($(this).children().val()));
	}
 });
	$(document).on("click","td.addNewButton",function(e) {
		var row = $(this).parent().parent().children().index($(this).parent());
		var html = $('#myTable tbody tr:eq('+row+')').html();
		$('#myTable tbody tr:eq('+row+')').after('<tr>'+html+'</tr>');
		row=row+1;
		$('#myTable tbody tr:eq('+row+') input[type=text]').val('');
		var options = {
			format : "dd-mm-yyyy"
		};
		$('.dp').datepicker(options);
		$(".dp-my").datepicker({
			format: "mm-yyyy",
			viewMode: "months", 
			minViewMode: "months"
		});
	});
	$(".dp-my").datepicker({
		format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months"
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