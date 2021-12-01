<style>
.table>tbody>tr.info>td, .table>tbody>tr.info>th, .table>tbody>tr>td.info, .table>tbody>tr>th.info, .table>tfoot>tr.info>td, .table>tfoot>tr.info>th, .table>tfoot>tr>td.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>thead>tr.info>th, .table>thead>tr>td.info, .table>thead>tr>th.info {
    background-color: #008d4c;
    color: #ffffff;
    font-weight: 800;
}
.add_button{
  background: #008d4c;
  border: 1px solid;
  font-weight: 800;
}
.custom-add-btn{
background-color: #3c8dbc;
border: 1px solid #ffffff42;
border-radius: 2px;
width: 100%;
transition: all 0.3s;
}
.custom-add-btn:hover{
background: #367fa9;
}
</style>
<div class="container bodycontainer">
   <div class="row">
        <div class="panel panel-primary">
        <div class="panel-heading"> List of Subtypes </div>
         <div class="panel-body">
            <br>
            <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="userList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">Type ID</th>
                     <th class="text-center Heading">Title</th>
                     <th class="text-center Heading">Description</th>
                     <th class="text-center Heading">Type</th>
                     <th class="text-center Heading">Supervision</th>
                     <th class="text-center Heading">Status</th>
                     <th class="text-center Heading">Created On</th>
                     <th class="text-center Heading">Created By</th>
                     <th class="text-center Heading">
                        <!--<a id="add_button" class="add_button" role="button" data-toggle="modal" data-target="#AddSubModal" data-toggle="tooltip" title="Add ">
                           <button class="submit btn-success btn-sm">
                           <i class="fa fa-plus"></i> Add</button>
                        </a>-->
						<button id="add_button" class="submit custom-add-btn btn-sm" data-toggle="modal" data-target="#AddSubModal" data-toggle="tooltip" title="Add ">
                           <i class="fa fa-plus"></i> Add 
						</button>
                     </th>
                  </tr>
               </thead>
               <tbody id="tbody"> 
			    <?php	$i = 1;
						foreach ($data as $key => $value){ ?>
					<tr class="DrilledDown">
						 <td class="text-center"><?php echo $i++; ?></td>
						 <td class="text-center"><?php echo $value['type_id']; ?></td>
						 <td class="text-center"><?php echo $value['title']; ?></td>
						 <td class="text-center"><?php echo $value['description']; ?></td>
						 <td class="text-center"><?php echo get_type_name($value["hr_type_id"]); ?></td>
						 <td class="text-center"><?php echo ($value['supportive_supervision'] == '1') ? 'Yes' : 'No'; ?></td>    
						 <td class="text-center"><?php echo ($value['is_active'] == '1') ? 'Active' : 'Not Active'; ?></td>    
						 <td class="text-center"><?php echo $value['created_date']; ?></td>    
						 <td class="text-center"><?php echo $value['created_by']; ?></td>    
						 <td class="text-center">
							<a id="edit_button"  data-original-title="Edit" href="" data-id="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#EditSubModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData"><i class="fa fa-pencil"></i></a>
							<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('<?php echo $value['id']; ?>');"  data-toggle="tooltip"  class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
						 </td>
					</tr>
				<?php } ?>  
               </tbody>
            </table>          
         </div> <!--end of panel body-->
      </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
</div><!--End of page content or body-->
<!-- Add Subtype Modal -->
<div class="modal fade" id="AddSubModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status" action="<?php echo base_url(); ?>Hr_management/subtype_add" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">User Subtype</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
						<div class="row">
							<label for="title" class="col-sm-3 control-label">Title</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="title" id="title" value="<?php echo isset($_POST["title"]) ? $_POST["title"] : ''; ?>" placeholder="Title"/>
									<?php echo form_error('title');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Code" class="col-sm-3 control-label">Type ID</label>
							<div class="col-sm-8">
								<select class="form-control text-center" name="code" id="Code">
									<option value="">Select Type ID</option>
								<?php
									$availableOption = range(01,99);
									foreach($availableOption as $key => $value)
									{
										$value = sprintf("%02d", $value);
										$array[] = $value;
									}
									$selectedOrInDb  = $selected; // Selected OR from DB
									$remaining = array_diff($array, $selectedOrInDb);
									foreach($remaining as $key => $value)
									{
										$value = sprintf("%02d", $value);
										echo "<option value='$value' " . set_select('code', $value) . " >".$value."</option>";
									} ?>
								</select>
								<?php echo form_error('code');  ?>
								<?php// print_r($availableOption); exit; ?>
							</div>
						</div>
						
						<div class="row" style="margin-top:10px;">
							<label for="desc" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="desc"  style="min-width: 100%"><?php echo isset($_POST["desc"]) ? $_POST["desc"] : ''; ?></textarea>
								<?php echo form_error('desc');  ?>
							</div>
						</div>
						
						<div class="row" style="margin-top:10px;">
							<label for="type" class="col-sm-3 control-label">Type</label>
							<div class="col-sm-8">
								<select class="form-control text-center" name="type" id="type">
									<option value="">Select Type</option>
								<?php foreach($type as $key => $value){
									$id = $value['id'];
									echo "<option value='$id' " . set_select('type', $value['id']) . " >".$value['name']."</option>";
								 } ?>
								</select>
								<?php echo form_error('type');  ?>
							</div>
						</div>
						
						<div class="row" style="margin-top:10px;">
							<label for="sup" class="col-sm-3 control-label">Supervision</label>
							<div class="col-sm-8">
								<label class="radio-inline">
									<input type="radio" name="sup" id="yes" value="1" checked="checked" <?php echo set_radio('sup', '1', TRUE); ?>> Yes<br>
								</label>
								<label class="radio-inline">
									<input type="radio" name="sup" id="no" value="0" <?php echo set_radio('sup', '0'); ?>> No<br>
								</label>
								<?php echo form_error('sup');  ?>
							</div>
						</div>
						
						<div class="row" style="margin-top:10px;">
							<label for="Active" class="col-sm-3 control-label">Active</label>
							<div class="col-sm-8">
								<label class="radio-inline">
									<input type="radio" name="active" id="Yes" value="1" checked="checked" <?php echo set_radio('active', '1', TRUE); ?>> Yes<br>
								</label>
								<label class="radio-inline">
									<input type="radio" name="active" id="No" value="0" <?php echo set_radio('active', '0'); ?>> No<br>
								</label>
								<?php echo form_error('active');  ?>
							</div>
						</div>
					<br>
					<div class="row">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="btn-modalForm-submit-status" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Add Subtype Modal End -->
<!-- Edit Subtype Modal Starts -->
<div class="modal fade" id="EditSubModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status1" action="<?php echo base_url(); ?>Hr_management/subtype_edit" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">User Subtype</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="hidden" id="hidden">
					<div class="row">
						<label for="title1" class="col-sm-3 control-label">Title</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="title1" id="title1" placeholder="Title"/>
								<?php echo form_error('title1');  ?>
							</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<label for="code1" class="col-sm-3 control-label">Type ID</label>
						<div class="col-sm-8">
							<select class="form-control text-center" name="code1" id="code1">
								<option value="">Select Type ID</option>
							<?php
									$availableOption1 = range(01,99);
									foreach($availableOption1 as $key => $value)
									{
										$value = sprintf("%02d", $value);
										$array1[] = $value;
									}
									$selectedOrInDb  = $selected; // Selected OR from DB
									$remaining = array_diff($array1, $selectedOrInDb);
									foreach($remaining as $key => $value)
									{
										$value = sprintf("%02d", $value);
										echo "<option value='$value' " . set_select('code', $value) . " >".$value."</option>";
									} ?>
							</select>
							<?php echo form_error('code1');  ?>
						</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<label for="desc1" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="desc1" style="min-width: 100%"></textarea>
							<?php echo form_error('desc1');  ?>
						</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<label for="type1" class="col-sm-3 control-label">Type</label>
						<div class="col-sm-8">
							<select class="form-control text-center" name="type1" id="type1">
								<option value="">Select Type</option>
							<?php foreach($type as $key => $value){ ?>
								<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
							<?php } ?>
							</select>
							<?php echo form_error('type1');  ?>
						</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<label for="sup1" class="col-sm-3 control-label">Supervision</label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="radio" name="sup1" id="edit_Yes" value="1"> Yes<br>
							</label>
							<label class="radio-inline">
								<input type="radio" name="sup1" id="edit_No" value="0"> No<br>
							</label>
							<?php echo form_error('sup1');  ?>
						</div>
					</div>
					<div class="row" style="margin-top:10px;">
						<label for="Active1" class="col-sm-3 control-label">Active</label>
						<div class="col-sm-8">
							<label class="radio-inline">
								<input type="radio" name="active1" id="editYes" value="1"> Yes<br>
							</label>
							<label class="radio-inline">
								<input type="radio" name="active1" id="editNo" value="0"> No<br>
							</label>
							<?php echo form_error('active1');  ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="btn-modalForm-edit-status" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button type="button" class="btn-background box1" id="cancelmodal1" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Add Subtype Modal End -->
<script type="text/javascript">
	function del_user(obj)
	{	  
		var myurl = '<?php echo base_url(); ?>Hr_management/subtype_del/'+obj;
		var is_confirm = confirm("Are you sure you want to delete?");
		if(is_confirm)
		{
			$.get(myurl, function (show) {
				window.location.replace("<?php echo base_url(); ?>Hr_management/subtype_list");
			});
		}
	}
	$('.editData').on('click', function()
	{
		var id = $(this).data("id");
		$.ajax
		({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Hr_management/subtype_edit_get",
			success: function(result)
			{
				//alert(result);
				var obj = JSON.parse(result);
				$('input[name=hidden]').val(obj[0].id);
				$('input[name=title1]').val(obj[0].title);
				$('textarea[name=desc1]').val(obj[0].description);
				//$('option[name=code]').val(obj[0].code);
				$('#type1 option[value="' + obj[0].hr_type_id + '"]').prop('selected', true);
				$("#code1").children().first().remove();   
				$("#code1").prepend('<option value="' + obj[0].type_id + '">' + obj[0].type_id + '</option>');
				$('#code1 option[value="' + obj[0].type_id + '"]').prop('selected', true);
				if(obj[0].supportive_supervision == 1){
					$('#edit_Yes').prop('checked',true);
					$('#edit_No').prop('checked',false);
				}
				else
				{
					$('#edit_Yes').prop('checked',false);
					$('#edit_No').prop('checked',true);
				}
				
				if(obj[0].is_active == 1){
					$('#editYes').prop('checked',true);
					$('#editNo').prop('checked',false);
				}
				else
				{
					$('#editYes').prop('checked',false);
					$('#editNo').prop('checked',true);
				}
			}
		});
	});
	<?php
	if(form_error('title') || form_error('code') || form_error('active') || form_error('sup') || form_error('type') || form_error('desc')){ ?>
	$("#add_button").trigger("click");
	<?php } ?>
	
	<?php if(form_error('title1') || form_error('code1') || form_error('active1') || form_error('desc1') || form_error('type1') || form_error('sup1')){ ?>
		$('#edit_button[data-id="<?php echo $editid; ?>"]').trigger('click');
	<?php } ?>
	
	$('#AddSubModal').on('hidden.bs.modal', function ()
	{
		$( "div" ).remove( ".error" );
		$('#title').val("");
		$('#Code').val("");
		$('#active').val("");
		$('#desc').val("");
		$('#type').val("");
	});
	$('#EditSubModal').on('hidden.bs.modal', function () {
		$( "div" ).remove( ".error" );
	});
</script>