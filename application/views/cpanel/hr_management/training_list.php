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
        <div class="panel-heading"> List of Training Types </div>
         <div class="panel-body">
            <br>
            <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="userList">
               <thead>
					<tr class="info">
						<th class="text-center Heading">S#</th>
						<th class="text-center Heading">Name</th>
						<th class="text-center Heading">Description</th>
						<th class="text-center Heading">Start Date</th>
						<th class="text-center Heading">Deadline</th>
						<th class="text-center Heading">Venue</th>
						<th class="text-center Heading">Status</th>
						<th class="text-center Heading">Created On</th>
						<th class="text-center Heading">Created By</th>
						<th class="text-center Heading">
							<!--<a id="add_button" class="add_button" role="button" data-toggle="modal" data-target="#AddTrainModal" rel="tooltip" title="Add New Training">
								<button class="submit btn-success btn-sm">
								<i class="fa fa-plus"></i> Add</button>
							</a>-->
						<button id="add_button" class="submit custom-add-btn btn-sm" data-toggle="modal" data-target="#AddTrainModal" rel="tooltip" title="Add New Training">
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
						<td class="text-center"><?php echo $value['name']; ?></td>
						<td class="text-center"><?php echo $value['description']; ?></td>
						<td class="text-center"><?php echo $value['start_date']; ?></td>  
						<td class="text-center"><?php echo $value['end_date']; ?></td>
						<td class="text-center"><?php echo $value['venue']; ?></td>
						<td class="text-center"><?php echo ($value['is_active'] == '1') ? 'Active' : 'Not Active'; ?></td>  
						<td class="text-center"><?php echo $value['created_date']; ?></td>  
						<td class="text-center"><?php echo $value['created_by']; ?></td>  
						<td class="text-center">
							<a data-original-title="Edit"  id="edit_button" data-original-title="Edit" data-id="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#EditTrainModal" title="Edit" class="btn btn-xs btn-default editData"><i class="fa fa-pencil"></i></a>
							<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('<?php echo $value['id']; ?>');"  data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php } ?>
               </tbody>
            </table>          
         </div> <!--end of panel body-->
      </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
</div><!--End of page content or body-->
<!-- Add Training Modal -->
<div class="modal fade" id="AddTrainModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status" action="<?php echo base_url(); ?>Hr_management/training_add" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">User Training</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
						<div class="row">
							<label for="name" class="col-sm-3 control-label">Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" placeholder="Title"/>
									<?php echo form_error('name');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="desc" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="desc" id="desc"  style="min-width: 100%"><?php echo isset($_POST["desc"]) ? $_POST["desc"] : ''; ?></textarea>
								<?php echo form_error('desc');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="start_date" class="col-sm-3 control-label">Start Date</label>
							<div class="col-sm-8">
								<input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="YYYY-MM-DD"/>
								<?php echo form_error('start_date');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="end_date" class="col-sm-3 control-label">End Date</label>
							<div class="col-sm-8">
								<input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="YYYY-MM-DD"/>
								<?php echo form_error('end_date');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="venue" class="col-sm-3 control-label">Venue</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="venue" id="venue" value="<?php echo isset($_POST["venue"]) ? $_POST["venue"] : ''; ?>" placeholder="Venue"/>
									<?php echo form_error('venue');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Active" class="col-sm-3 control-label">Active</label>
								<div class="col-sm-8">
									<label class="radio-inline">
										<input type="radio" name="active" id="yes" value="1" checked="checked" <?php echo set_radio('active', '1', TRUE); ?>> Yes<br>
									</label>
									<label class="radio-inline">
										<input type="radio" name="active" id="no" value="0" <?php echo set_radio('active', '0'); ?>> No<br>
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
<!-- Add Training Modal End -->
<!-- Edit Training Modal Starts -->
<div class="modal fade" id="EditTrainModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status1" action="<?php echo base_url(); ?>Hr_management/training_edit" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">User Training</h4>
				</div>
				<div class="modal-body">
						<input type="hidden" class="form-control" name="hidden" id="hidden">
						<div class="row">
							<label for="name1" class="col-sm-3 control-label">Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="name1" id="name1" placeholder="Title"/>
									<?php echo form_error('name1');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="desc1" class="col-sm-3 control-label">Description</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="desc1" id="desc1"  style="min-width: 100%"></textarea>
								<?php echo form_error('desc1');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="start_date1" class="col-sm-3 control-label">Start Date</label>
							<div class="col-sm-8">
								<input class="form-control datepicker" name="start_date1" id="start_date1" placeholder="YYYY-MM-DD"/>
								<?php echo form_error('start_date1');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="end_date1" class="col-sm-3 control-label">End Date</label>
							<div class="col-sm-8">
								<input class="form-control datepicker" name="end_date1" id="end_date1" placeholder="YYYY-MM-DD"/>
								<?php echo form_error('end_date1');  ?>
							</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="venue1" class="col-sm-3 control-label">Venue</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="venue1" id="venue1"  placeholder="Venue"/>
									<?php echo form_error('venue1');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Active1" class="col-sm-3 control-label">Active</label>
								<div class="col-sm-8">
									<label class="radio-inline">
										<input type="radio" name="active1" id="editYes" value="1" checked="checked"> Yes<br>
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
							<button id="btn-modalForm-submit-status1" type="submit" class="btn-background box1"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button type="button" class="btn-background box1" id="cancelmodal1" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Edit Training Modal End -->
<script type="text/javascript">
	function del_user(obj)
	{	  
		var myurl = '<?php echo base_url(); ?>Hr_management/training_del/'+obj;
		var is_confirm = confirm("Are you sure you want to delete?");
		if(is_confirm)
		{
			$.get(myurl, function (show) {
				window.location.replace("<?php echo base_url(); ?>Hr_management/training_list");
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
			url: "<?php echo base_url(); ?>Hr_management/training_edit_get",
			success: function(result)
			{
				//alert(result);
				var obj = JSON.parse(result);
				$('input[name=hidden]').val(obj[0].id);
				$('input[name=name1]').val(obj[0].name);
				$('input[name=start_date1]').val(obj[0].start_date);
				$('input[name=end_date1]').val(obj[0].end_date);
				$('input[name=venue1]').val(obj[0].venue);
				$('textarea[name=desc1]').val(obj[0].description);
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
	 	$(document).ready(function(){
			var dateToday = new Date(); 
			var options = {
				format : "yyyy-mm-dd",
				minDate: 0
			};
			$('.datepicker').datepicker(options);	
		});
	<?php
	if(form_error('name') || form_error('desc') || form_error('start_date') || form_error('end_date') || form_error('venue') || form_error('active')){ ?>
		$("#add_button").trigger("click");
	<?php } ?>
	<?php
	if(form_error('name1') || form_error('desc1') || form_error('start_date1') || form_error('end_date1') || form_error('venue1') || form_error('active1')){ ?>
		$('#edit_button[data-id="<?php echo $editid; ?>"]').trigger('click');
	<?php } ?>
	$('#AddTrainModal').on('hidden.bs.modal', function ()
	{
		$( "div" ).remove( ".error" );
		$('#name').val("");
		$('#desc').val("");
		$('#start_date').val("");
		$('#venue').val("");
		$('#end_date').val("");
	});
	$('#EditTrainModal').on('hidden.bs.modal', function () {
		$( "div" ).remove( ".error" );
	});
	function fromDate(start_date_id, end_date_id){	
		var from_date = $('#'+start_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
		var to_date = $("#"+end_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
		$("#"+end_date_id).datepicker('setStartDate', from_date);
		$("#"+end_date_id).datepicker('setEndDate', '+2y');
		if(to_date < from_date){
			$("#"+end_date_id).val('');
    	}
 	}
	function toDate(start_date_id, end_date_id){
		$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
	}
	function setNewDate(start_date_id){
		$('#'+start_date_id).datepicker('setEndDate', '+0d');
  	}
    $("#start_date").on( "change", function() {
    	fromDate('start_date', 'end_date');
    });
	$("#start_date1").on( "change", function() {
    	fromDate('start_date1', 'end_date1');
    });
</script>