<?php $utype=$_SESSION['utype']; 
//print_r($pack_size_results); exit();?>
<?php //print_r($userInfo); exit(); ?>
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
  			<div class="panel panel-primary">
    			<ol class="breadcrumb">
          		<?php  echo $this->breadcrumbs->show();?>
       		</ol>
    			<div class="panel-heading">EPI-MIS | Product Edit Form</div>
  	   		<div class="panel-body">
    	   		<form name="dataform" id="dataform" action="<?php echo base_url();?>cpanel/item_management/Item_management/item_update" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<input type="hidden" value="<?php echo $epi_items_results[0]["pk_id"]; ?>" name="item_pk_id" >
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Product Name</label>
							   <div class="col-xs-3">
									<input  required name="description" id="description" placeholder="Product Name"  class="form-control " value="<?php echo $epi_items_results[0]["description"]; ?>"/>
							  	</div>
							   <label class="col-xs-2 control-label" for = "uname" >Product Categories</label>
								<div class="col-xs-3">
									<select id="item_category_id" required name="item_category_id" class="form-control" size="1" >
										<option value="">--- Select Categories ---</option>
									<?php foreach($epi_item_categories as $values){ ?>
									  <option value="<?php echo $values['pk_id'];?>"  <?php if($epi_items_results[0]['item_category_id'] == $values['pk_id'] ){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $values['item_category_name'] ?>
									<?php } ?>

									
									</select>
								</div>
						   </div>
						</div>
						<div class="row"> 
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "uname" >Active</label>
							  	<div class="col-xs-3">
									<input type="radio" name="is_active" value= '1' <?php echo ($epi_items_results[0]["is_active"]== '1') ?  "checked" : "" ;  ?>>YES
									<input type="radio" name="is_active" value= '0' <?php echo ($epi_items_results[0]["is_active"]== '0') ?  "checked" : "" ;  ?>> NO
							  	</div>
						   </div>
						</div>
						<hr>
						<!------------------->
						<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
							<thead>
								<tr>
									<th id="m1"  colspan="8" class="qtr">Pack Sizes</th>
								</tr>
								<tr>
									<th>S.No.</th>
									<th>Name</th>
									<th>Pack Size</th>
									<th>Unit</th>
									<th>Activity</th>
									<th>Vvm Stage Type</th>
									<th>Row Number</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="trRow" >
								<?php 
								$i=1;
								$array=count($pack_size_results);
								foreach($pack_size_results as $key=>$val) {?>
									<tr>
										<td>
											<input type="hidden" class="pk_id" value="<?php echo $val['pk_id']; ?>" name="pk_id[]" />
							
											<label class="srno-lbl" name="lb[]"><?php echo$i; ?></label>

										</td>
										<td>
											<input type="text" class="form-control" id="item_name" placeholder="Name" value="<?php echo $val['item_name']; ?>" name="item_name[]" >
										</td>
										<td>
											<input type="text" class="form-control" id="number_of_doses" placeholder="Pack Size" value="<?php echo $val['number_of_doses']; ?>" name="number_of_doses[]" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"/>	
										</td>
										<td>
											<select id="item_unit_id" name="item_unit_id[]" class="form-control" size="1" >
											<option value="">--- Select Unit ---</option>
												<?php
													foreach($epi_item_units as $values){ ?><option value="<?php echo $values['pk_id'];?>"  <?php if($val['item_unit_id'] == $values['pk_id']){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $values['item_unit_name'] ?>
												<?php } ?>										
											</select>
										</td>
										<td>
											<select id="activity_type_id" name="activity_type_id[]" class="form-control" size="1" >
											<option value="">--- Select Activity ---</option>
												<?php
													foreach($epi_stakeholder_activities as $values){ ?><option value="<?php echo $values['pk_id'];?>"  <?php if($val['activity_type_id'] == $values['pk_id']){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $values['activity'] ?>
												<?php } ?>										
											</select>	
										</td>
										<td>
											<select id="vvm_stage_type" name="vvm_stage_type[]" class="form-control" size="1" >
												<option value="">--Select Vvm_stage--</option>
												<option <?php if($val['vvm_stage_type'] == '1') { echo 'selected="selected"'; }else echo ''; ?> value="1">1</option>
												<option <?php if($val['vvm_stage_type'] == '2') { echo 'selected="selected"'; }else echo ''; ?>  value="2">2</option>
											</select>	
										</td>
										<td>
											<select id="cr_table_row_numb" class="cr_table_row_numb"  name="cr_table_row_numb[]" class="form-control" size="1">
											<option value="">--Select Row--</option>
												<?php 
													$availableOption = range(1,250);
													$selectedOrInDb  = $selected; // Selected OR from DB
													$remaining = array_diff($availableOption, $selectedOrInDb);
													$values = array_push($remaining,$val['cr_table_row_numb']); 
													foreach($remaining as $values){ ?>
													<option value="<?php echo $values;?>"<?php if($val['cr_table_row_numb'] == $values){ echo 'selected="selected"'; } else  { echo ''; } ?>  /><?php echo $values; ?>
												<?php } ?>													
											</select>
										</td>
										<td>
											<?php if($array > $i) { ?>
												
											<?php } else { ?>
												<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
											<?php } ?>
										</td>
									</tr>
								<?php $i++; } 	?> 
							</tbody>
						</table>
						<!------------------->
						<hr>
						<div class="row">
						   <div class="col-xs-7 cmargin22" >
								<button type="submit" id="AddUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update Porduct </button>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url();?>Item_management/item_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body container-->

<script type="text/javascript">
	
	function addRow(obj){
		var row = $(obj).closest("tr").clone();
		row.find('input').val('');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('input').val('');
		row.find("td:nth-child(3)").find('input').val('');
		row.find("td:nth-child(4)").find('select').val('0');
		row.find("td:nth-child(5)").find('select').val('0');
		row.find("td:nth-child(6)").find('select').val('0');
		row.find("td:nth-child(7)").find('select').val('0');
		$(obj).closest("#trRow").append(row);
		//$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted();
	}
	function deleteRow(obj) {
		var index = $('#trRow').find('tr:last').index();
		$(obj).closest("tr").remove();
		var pk_id = row.find('.pk_id').val();
		if(pk_id=''){
			var row = $(obj).closest("tr").clone();
		}
		if(index=='1'){
			$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		reindex_serialnumber_and_trainingCompleted();
	}	
	function reindex_serialnumber_and_trainingCompleted(){
		$('#trRow > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('input').attr('name','item_name['+i+']');
			$(this).find("td:nth-child(3)").find('input').attr('name','number_of_doses['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','item_unit_id['+i+']');
			$(this).find("td:nth-child(5)").find('select').attr('name','activity_type_id['+i+']');
			$(this).find("td:nth-child(6)").find('select').attr('name','vvm_stage_type['+i+']');
			$(this).find("td:nth-child(7)").find('select').attr('name','cr_table_row_numb['+i+']');
		});
	}
	/* var id = $('#item_pk_id').val();
	$.ajax
	({
		type: "POST",
		data: "id="+id,
		url: "<?php echo base_url(); ?>cpanel/item_management/Item_management/add_edit",
		success: function(result)
		{
			//alert(result);
			var obj = JSON.parse(result);
			$.each(obj, function(i, item) {
				//alert(obj[i].cr_table_row_numb);
				if(obj[i].cr_table_row_numb!=null){
					$(".cr_table_row_numb").children().first().remove();   
					$(".cr_table_row_numb").prepend('<option value="' + obj[i].cr_table_row_numb + '">' + obj[i].cr_table_row_numb + '</option>');
					$('.cr_table_row_numb option[value="' +obj[i].cr_table_row_numb + '"]').prop('selected', true);
				}
			}); 
		}
	}); */
</script>





