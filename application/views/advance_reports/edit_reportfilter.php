<?php
	foreach ($detail as $key=>$data) { ?>
	    <input type="hidden" id="report_fields_id" name="report_fields_id" value="<?php echo $data['report_fields_id'];?>">
        <div class="row"  id="<?php echo $data['sec_id'];?>-<?php echo $data['field_id'];?>"> 
		 <div class="col-md-8 col-md-offset-1 col-sm-8">
			<?php echo $data['field_id'];?>
		 </div>
		    <div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1"> 
				<a style="color: black;" href="#" class="del_selected_field" data-id="<?php echo $data['sec_id'];?>-<?php echo $data['field_id'];?>">
					<i class="fa fa-trash-o"> Delete</i>
				</a>
			</div>
		</div>	
			
		
<?php
	} ?> 
	<input type="hidden" id="reportid" name="reportid" value="<?php echo (isset($detail[0]['report_id']))?$detail[0]['report_id']:'';?>">