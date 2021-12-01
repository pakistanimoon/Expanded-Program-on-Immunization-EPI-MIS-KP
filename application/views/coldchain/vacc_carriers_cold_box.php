<!--start of page content or body-->
<?php 
  date_default_timezone_set('Asia/Karachi');
  $current_date = date('d-m-Y');
?>
<div class="container bodycontainer">
<div class="row">
 <div class="panel panel-primary">
   <div class="panel-heading"> Vaccine Carriers, Cold Boxes & Ice Packs</div>
     <div class="panel-body">
       <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Coldchain/vacc_carriers_save">
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
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Administrative Levels and EPI Facility Identification</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label>1. Province</label></td>
               <td><?php
			  if(isset($gdata)){ ?>
					  <label><?php echo get_Province_Name($this->session->Province); ?></label>
				  <?php }else{ ?>
			  <input class="form-control" name="procode" readonly="readonly" id="procode" placeholder="<?php echo get_Province_Name($this->session->Province); ?>" type="text">
				  <?php } ?>
			  </td>
              <td><label>2. District</label></td>
               <td><?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_District_Name($gdata->distcode); ?></label>
				  <?php }else{ ?>
                <select id="distcode" name="distcode" class="form-control text-center">
				  <?php getDistricts_options(false,$this -> session -> District); ?>
                </select>
				<?php } ?></td>
            </tr>
            <tr>
              <td><label>3. Tehsil</label></td>
              <td><?php
				  if(isset($gdata)){ ?>
					  <label><?php echo get_Tehsil_Name($gdata->tcode); ?></label>
				  <?php }else{ ?>
                <select id="tcode" name="tcode" class="form-control text-center">
                 
                </select>
				<?php } ?></td>
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
              <td><label>5. Name of (health) facility</label></td>
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
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Vaccine cold box and carrier information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                <label>6. Quantities of vaccine cold boxes and carriers</label><br>Fill in a separate line for each model of cold box and vaccine carrier found at health facility, using the Catalogue ID referenced for each model in the Equipment Identification Booklet and always starts with the letter E.
              </td>
            </tr>                           
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable" style="margin-top: -21px;" id="myTable">
          <thead>
            <tr>

              <th rowspan="2">Catalogue ID</th>
              <th rowspan="2">Cold Box / Vaccine Carrie</th>
              <th rowspan="2">Total available for vaccination activities</th>
              <th rowspan="2">Quantity not working</th>
              <th colspan="3">Internal Dimensions Leave blank if found in Catalogue and ID written in Column 1</th>
              <th rowspan="2" colspan="7">Equipment Code Code is needed on all Cold Boxes and Standard Vaccine Carriers NOT for Rotary Vaccine Carriers</th> 
              <th rowspan="2">Action</th>            
            </tr>
            <tr>
              <th>Length (cm)</th>
              <th>Width (cm)</th>
              <th>Height (cm)</th>
            </tr>             
          </thead>
          <tbody>
          	<?php
			if(isset($gdataDetail)){
				foreach($gdataDetail as $key => $val){
			?>
            <tr>
              <td><input class="form-control" name="catalogue_id[]" value="<?php echo $val['catalogue_id']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="cb_vc[]" value="<?php echo $val['cb_vc']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="tot_vacc[]" value="<?php echo $val['tot_vacc']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="quntt_not_working[]" value="<?php echo $val['quntt_not_working']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_length[]" value="<?php echo $val['dimension_length']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_width[]" value="<?php echo $val['dimension_width']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_height[]" value="<?php echo $val['dimension_height']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f1[]" value="<?php echo $val['eq_code_r1_f1']; ?>" id="dsv_name" type="text"></td>
              <td><p style="padding-top: 4px;">&#8212;</p></td>
              <td><input class="form-control" name="eq_code_r1_f2[]" value="<?php echo $val['eq_code_r1_f2']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f3[]" value="<?php echo $val['eq_code_r1_f3']; ?>" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f4[]" value="<?php echo $val['eq_code_r1_f4']; ?>" id="dsv_name" type="text"></td>
              <td><p style="padding-top: 4px;">&#8212;</p></td>
              <td><input class="form-control" name="eq_code_r1_f5[]" value="<?php echo $val['eq_code_r1_f5']; ?>" id="dsv_name" type="text"></td>
              <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>
            </tr>
            <?php } ?>
			<?php }else{ ?>  
            <tr>
              <td><input class="form-control" name="catalogue_id[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="cb_vc[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="tot_vacc[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="quntt_not_working[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_length[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_width[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="dimension_height[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f1[]" id="dsv_name" type="text"></td>
              <td><p style="padding-top: 4px;">&#8212;</p></td>
              <td><input class="form-control" name="eq_code_r1_f2[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f3[]" id="dsv_name" type="text"></td>
              <td><input class="form-control" name="eq_code_r1_f4[]" id="dsv_name" type="text"></td>
              <td><p style="padding-top: 4px;">&#8212;</p></td>
              <td><input class="form-control" name="eq_code_r1_f5[]" id="dsv_name" type="text"></td>
              <td class="addNewButton"><a style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-plus-square"></i></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <table class="table table-bordered   table-striped table-hover  mytable2 mytable3">
          <thead>
            <tr>
              <th colspan="4" style="text-align:center; padding-top: 10px; padding-bottom: 10px;">Ice pack information </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                <label>7. Quantity of standard ice packs in good condition
                </label>
              </td>
            </tr>                           
          </tbody>
        </table>
        <table class="table table-bordered table-condensed table-striped table-hover mytable" style="margin-top: -21px;">
          <tbody>
          	<?php $labels = array(

							'Ice pack size in Litters',
							'Quantity'
						);

						for($i=1; $i<=count($labels); $i++){ ?> 
            <tr>
              <td> <label><?php echo $labels[$i-1]; ?> </label></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f1'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f2'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f3'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f4'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f5'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f6'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f7'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f8'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f9'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f10'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
              <td><input class="form-control numberclass" value="<?php $var ='ii_r'.$i.'_f11'; echo isset($gdata)?$gdata->$var:''; ?>" name="<?php echo $var; ?>" type="text"></td>
            </tr>
            <?php }?>
            <!--
            <tr>
                          <td><label>Quantity</label></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td>
                          <td><input class="form-control" name="dsv_name" id="dsv_name" type="text"></td> 
                        </tr>-->
            
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
                      <td><input class="form-control" name="pr_name" value="<?php if(isset($gdata)){ echo $gdata->pr_name; } ?>"  id="dsv_name" type="text"></td>
                      <td><label>Designation</label></td>
                      <td><input class="form-control" name="pr_desg" value="<?php if(isset($gdata)){ echo $gdata->pr_desg; } ?>" id="dsv_name" type="text"></td>
                    </tr>
                    <tr>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="pr_mob" value="<?php if(isset($gdata)){ echo $gdata->pr_mob; } ?>" id="dsv_name" type="text"></td>
                      <td><label>Email</label></td>
                      <td><input class="form-control" name="pr_email" value="<?php if(isset($gdata)){ echo $gdata->pr_email; } ?>" id="dsv_name" type="text"></td>
                    </tr>
                  </tbody>
                </table>
                <table class="table table-bordered   table-striped table-hover    mytable2">
                  <thead>
                    <tr>
                      <th colspan="6" style="text-align:center;">Cold Chain Inventory team leader's information</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><label>Name</label></td>
                      <td><input class="form-control" name="cc_name" value="<?php if(isset($gdata)){ echo $gdata->cc_name; } ?>" id="dsv_name" type="text"></td>
                      <td><label>Mobile number</label></td>
                      <td><input class="form-control" name="cc_mob" value="<?php if(isset($gdata)){ echo $gdata->cc_mob; } ?>" id="dsv_name" type="text"></td>  
                      <td><label>Date Submitted</label></td>
                      <td><p><?php echo (isset($gdata))?date('d-m-Y',strtotime($gdata->date_submitted)):date('d-m-Y'); ?></p></td>
                    </tr>
                  </tbody>
                </table>
                <div class="row">
         <hr>
            <div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
                <button style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
                
              <button type="reset" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md">
                <i class="fa fa-repeat"></i> Reset Form </button>
             
              <a href="<?php echo base_url(); ?>Vaccine-Carriers/List" style="background:#008d4c none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
            </div>
        </div>                 
		</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
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
	}); 
</script> 