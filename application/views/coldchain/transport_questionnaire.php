<!--start of page content or body-->
<?php 
  date_default_timezone_set('Asia/Karachi');
  $current_date = date('d-m-Y');
?>
<div class="container bodycontainer">  
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Transport Questionnaire</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Coldchain/transport_questionnaire_save">
		<?php if(isset($gdata)){ ?>
			<input type="hidden" name="id" value="<?php echo $gdata->id; ?>">
			<input type="hidden" name="edit" value="edit">
			<input type="hidden" name="distcode" value="<?php echo $gdata->distcode; ?>">
			<input type="hidden" name="tcode" value="<?php echo $gdata->tcode; ?>">
			<input type="hidden" name="uncode" value="<?php echo $gdata->uncode; ?>">
			<input type="hidden" name="facode" value="<?php echo $gdata->facode; ?>">
		<?php } ?>
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Information</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
              <td><?php
			  if(isset($gdata)){ ?>
					  <label><?php echo "Khyber Pakhtunkhwa"; ?></label>
				  <?php }else{ ?>
			  <input class="form-control" name="procode" readonly="readonly" id="procode" placeholder="Khyber Pakhtunkhwa" type="text">
				  <?php } ?>
			  </td>
              <td><label>2. District</label></td>
              <td>
			  <?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_District_Name($gdata->distcode); ?></label>
				  <?php }else{ ?>
                <select id="distcode" name="distcode" class="form-control text-center">
				  <?php getDistricts_options(false,$this -> session -> District); ?>
                </select>
				<?php } ?>
              </td>       
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
               <td>
			   <?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_Tehsil_Name($gdata->tcode); ?></label>
				  <?php }else{ ?>
                <select id="tcode" name="tcode" class="form-control text-center">
                 
                </select>
				<?php } ?>
              </td>
              <td><label>4. Union Council</label></td>
              <td>
			  <?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_UC_Name($gdata->uncode); ?></label>
				  <?php }else{ ?>
                <select id="uncode" name="uncode" class="form-control text-center">
                 
                </select>
				<?php } ?>
              </td>
            </tr>
            <tr>
              <td><label>5. Name of (Health) Facility</label></td>
               <td>
			   <?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_Facility_Name($gdata->facode); ?></label>
				  <?php }else{ ?>
                <select id="facode" name="facode" class="form-control text-center">
                  
                </select>
				  <?php } ?>
              </td>               
            </tr> 
<tr>
			  <td><label>7. Year </label></td>
			  <td><select id="year" name="year" class="form-control text-center">
				<?php echo $optionsY; ?>
			  </select>
			  </td>
			  <td><label>8. Quarter </label></td>
			  <td><select id="quarter" name="quarter" class="form-control text-center">
				<?php if(isset($optionsQ)){
					 echo $optionsQ; 
				} ?>
			  </select>
			  </td>
            </tr>			
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover   mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Key for &quot;Transport&quot; and &quot;Reasons for not working&quot; columns</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <label>&quot;Transport Type&quot;</label> 
              </td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td>1. Motorcycle </td>
                  </tr>
                  <tr>  
                    <td>2. Vehicle </td>
                  </tr>
                  <tr>  
                    <td>3. Truck </td>
                  </tr>
                  <tr>  
                    <td>4. Boat </td>
                  </tr>
                  <tr>
                    <td>5. Bicycle </td>
                  </tr>
                </table>
              </td>
              <td><label>&quot;Reason for not working&quot;</label></td>
              <td>
                <table style="width: 100%; margin-top: 8px;">
                  <tr>
                    <td>A. Waiting repair technician or at garage </td>
                  </tr>
                  <tr>  
                    <td>B. Waiting spare parts </td>
                  </tr>
                  <tr>  
                    <td>C. Awaiting finances </td>
                  </tr>
                  <tr>  
                    <td>D. Awaiting boarding off </td>
                  </tr>
                  <tr>
                    <td>E. Unknown </td>
                  </tr>
                </table>
              </td>
            </tr>
                                
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center;">Key for "Transport" and "Reasons for not working" columns</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable" style="margin-top: -21px;" id="myTable">
          <thead>
            <tr>
              <th>Transport type(1-5)</th>
              <th>Model</th>
              <th>Make</th>
              <th>Year of manufacture</th>
              <th>Total number</th>
              <th>Number not working</th> 
              <th>Reasons for not working (A-E)</th>
              <th>% used for EPI</th>
              <th>Type of fuel</th>
              <th>Action</th>            
            </tr>                     
          </thead>
          <tbody>
			<?php
			if(isset($gdataDetail)){
				foreach($gdataDetail as $key => $val){
			?>
            <tr>
              <td class="transport_type">
				<select name="transport_type[]" class="form-control text-left">
                    <option value="0" <?php echo ($val['transport_type']==0)?'selected="selected"':''; ?> >-- Select --</option>
                    <option value="1" <?php echo ($val['transport_type']==1)?'selected="selected"':''; ?> >1. Motorcycle</option>
                    <option value="2" <?php echo ($val['transport_type']==2)?'selected="selected"':''; ?> >2. Vehicle</option> 
                    <option value="3" <?php echo ($val['transport_type']==3)?'selected="selected"':''; ?> >3. Truck</option> 
                    <option value="4" <?php echo ($val['transport_type']==4)?'selected="selected"':''; ?> >4. Boat</option> 
                    <option value="5" <?php echo ($val['transport_type']==5)?'selected="selected"':''; ?> >5. Bicycle</option>                     
                </select></td>
              <td><input class="form-control <?php echo ($val['transport_type']==5)?'hide':''; ?>" name="model[]" value="<?php echo $val['model']; ?>" type="text"></td>
              <td><input class="form-control <?php echo ($val['transport_type']==5)?'hide':''; ?>" name="make[]" value="<?php echo $val['make']; ?>" type="text"></td>
              <td><input class="form-control <?php echo ($val['transport_type']==5)?'hide':''; ?>" name="year_manufacture[]" value="<?php echo $val['year_manufacture']; ?>" type="text"></td>
              <td><input class="form-control numberclass" name="tot_number[]" value="<?php echo $val['tot_number']; ?>" type="text"></td>
              <td><input class="form-control numberclass" name="not_working[]" value="<?php echo $val['not_working']; ?>" type="text"></td> 
              <td><select name="reasons_not_working[]" class="form-control text-left">
                    <option value="0" <?php echo ($val['reasons_not_working']==0)?'selected="selected"':''; ?> >-- Select --</option>
                    <option value="1" <?php echo ($val['reasons_not_working']==1)?'selected="selected"':''; ?> >A. Waiting repair technician or at garage</option>
                    <option value="2" <?php echo ($val['reasons_not_working']==2)?'selected="selected"':''; ?> >B. Waiting spare parts</option> 
                    <option value="3" <?php echo ($val['reasons_not_working']==3)?'selected="selected"':''; ?> >C. Awaiting finances</option> 
                    <option value="4" <?php echo ($val['reasons_not_working']==4)?'selected="selected"':''; ?> >D. Awaiting boarding off</option> 
                    <option value="5" <?php echo ($val['reasons_not_working']==5)?'selected="selected"':''; ?> >E. Unknown</option>                     
                  </select></td>
              <td><input class="form-control numberclass <?php echo ($val['transport_type']==5)?'hide':''; ?>" name="percentage_used[]" value="<?php echo $val['percentage_used']; ?>" type="text"></td>
              <td><input class="form-control <?php echo ($val['transport_type']==5)?'hide':''; ?>" name="fuel_type[]" value="<?php echo $val['fuel_type']; ?>" type="text"></td>
              <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>            
            </tr>
				<?php } ?>
			<?php }else{ ?> 
				<tr>
              <td class="transport_type"><select name="transport_type[]" class="form-control text-left">
                    <option value="0">-- Select --</option>
                    <option value="1">1. Motorcycle</option>
                    <option value="2">2. Vehicle</option> 
                    <option value="3">3. Truck</option> 
                    <option value="4">4. Boat</option> 
                    <option value="5">5. Bicycle</option>                     
                  </select></td>
              <td><input class="form-control" name="model[]" type="text"></td>
              <td><input class="form-control" name="make[]" type="text"></td>
              <td><input class="form-control" name="year_manufacture[]" type="text"></td>
              <td><input class="form-control numberclass" name="tot_number[]" type="text"></td>
              <td><input class="form-control numberclass" name="not_working[]" type="text"></td> 
              <td><select name="reasons_not_working[]" class="form-control text-left">
                    <option value="0">-- Select --</option>
                    <option value="1">A. Waiting repair technician or at garage</option>
                    <option value="2">B. Waiting spare parts</option> 
                    <option value="3">C. Awaiting finances</option> 
                    <option value="4">D. Awaiting boarding off</option> 
                    <option value="5">E. Unknown</option>                     
                  </select></td>
              <td><input class="form-control numberclass" name="percentage_used[]" type="text"></td>
              <td><input class="form-control" name="fuel_type[]" type="text"></td>
              <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>            
            </tr>
			<?php } ?>
            <tr>
              <td colspan="10" style="text-align:center; padding-top: 15px; padding-bottom: 10px;"><input class="form-control" name="comments" id="comments" value="<?php if(isset($gdata)){ echo $gdata->comments; } ?>" type="text" placeholder="Comments"></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Person responsible for cold chain at the facility</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="pr_name" value="<?php if(isset($gdata)){ echo $gdata->pr_name; } ?>" id="pr_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="pr_desg" value="<?php if(isset($gdata)){ echo $gdata->pr_desg; } ?>" id="pr_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="pr_mob" value="<?php if(isset($gdata)){ echo $gdata->pr_mob; } ?>" id="pr_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="pr_email" value="<?php if(isset($gdata)){ echo $gdata->pr_email; } ?>" id="pr_email" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="cctl_name" value="<?php if(isset($gdata)){ echo $gdata->cctl_name; } ?>"  id="cctl_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="cctl_desg" value="<?php if(isset($gdata)){ echo $gdata->cctl_desg; } ?>"  id="cctl_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cctl_mob" value="<?php if(isset($gdata)){ echo $gdata->cctl_mob; } ?>"  id="cctl_mob" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="cctl_email" value="<?php if(isset($gdata)){ echo $gdata->cctl_email; } ?>"  id="cctl_email" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="4" style="text-align:center;">Data Collector's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="dc_name" value="<?php if(isset($gdata)){ echo $gdata->dc_name; } ?>" id="dc_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="dc_desg" value="<?php if(isset($gdata)){ echo $gdata->dc_desg; } ?>" id="dc_desg" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="dc_email" value="<?php if(isset($gdata)){ echo $gdata->dc_email; } ?>" id="dc_email" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="dc_mob" value="<?php if(isset($gdata)){ echo $gdata->dc_mob; } ?>" id="dc_mob" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Date</label></td>
                      <td><input class="dp form-control" name="dc_date" value="<?php if(isset($gdata)){ echo date('d-m-Y',strtotime($gdata->dc_date)); } ?>" id="dc_date" type="text"></td>
                      <td><label>Date Submitted</label></td>
                      <td><p><?php echo (isset($gdata))?date('d-m-Y',strtotime($gdata->date_submitted)):date('d-m-Y'); ?></p></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url();?>Transport-Questionnaire/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>    
                 
</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
  

</div><!--End of page content or body-->

<!--JS -->

<script type="text/javascript">
$(document).ready(function(){
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
	});
	$(document).on('change','#uncode',function(){
		$.ajax({
			type: "POST",
			data: "uncode="+$(this).val(),
			url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
			success: function(result){
				$('#facode').html(result);
				if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
				{
					$('#facode option[value="' + selectedfacode + '"]').prop('selected', true);
				}
			}
		});
	});
	$(document).on("change","td.transport_type",function(e) {
	  	var row = $(this).parent().parent().children().index($(this).parent());
		//alert($(this).children().val());
		if($(this).children().val() == "5"){
			$('#myTable tbody tr:eq('+row+') td:eq(1) input').addClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(2) input').addClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(3) input').addClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(7) input').addClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(8) input').addClass('hide');
		}else{
			$('#myTable tbody tr:eq('+row+') td:eq(1) input').removeClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(2) input').removeClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(3) input').removeClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(7) input').removeClass('hide');
			$('#myTable tbody tr:eq('+row+') td:eq(8) input').removeClass('hide');
		}
	    
	});
}); 
</script>