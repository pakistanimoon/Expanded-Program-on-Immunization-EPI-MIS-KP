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
	
        <div class="panel-heading"> List of Diseases </div>
         <div class="panel-body">
			<div class="form-group">
			<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
			<div class="col-xs-3">
				<input type="text" id="filter" autocomplete="new-password" name="searchParamas" class="form-control" placeholder="Disease Name/Code/Shortname"/>
			</div>
		</div>
        <br>
        <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="diseaseList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">TypeCase/Disease Name</th>
                     <th class="text-center Heading">Code</th>
                     <th class="text-center Heading">Status</th>
                     <th class="text-center Heading">Disease Code</th>
                     <th class="text-center Heading">
						<!--<a id="add_button" class="add_button" role="button" data-toggle="modal" data-target="#AddDiseaseModal" rel="tooltip" title="Add New Training">
								<button class="submit btn-success btn-sm">
								<i class="fa fa-plus"></i> Add</button>
						</a>-->
						<button id="add_button" class="submit custom-add-btn btn-sm" data-toggle="modal" data-target="#AddDiseaseModal" rel="tooltip" title="Add New Training">
                           <i class="fa fa-plus"></i> Add 
						</button>
					 </th>
                  </tr>
               </thead>
               <tbody id="tbody">
			    <?php 
					$i = 1;
					foreach($data as $key => $value){ ?>
					<tr id="row_<?php echo $value['id']; ?>" class="DrilledDown">
						<td class="text-center  order"><?php echo $i++; ?></td>
						<td class="text-center"><?php echo $value['type_case_name']; ?></td>
						<td class="text-center"><?php echo $value['type_short_code']; ?></td>
						<td id='status' class="text-center"><?php echo ($value['pro'] == '1') ? 'Active' : 'Not Active'; ?></td>
						<td class="text-center"><?php echo $value['short_name']; ?></td>
						
						<td class="text-center">
							<a id="edit_button" data-original-title="Edit" href="" data-id="<?php echo $value['id']; ?>" data-toggle="modal" data-target="#EditLevelModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData" ><i class="fa fa-pencil"></i></a>
							<a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_disease('<?php echo $value['id']; ?>','<?php echo $value['pro']; ?>');"  data-toggle="tooltip"  class="btn btn-xs btn-danger btn-remove" ><i class="fa fa-times"></i></a>
						</td>
					</tr>
				<?php }  ?>
               </tbody>
            </table>          
         </div> <!--end of panel body-->
      </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
</div><!--End of page content or body-->
<!-- Add Level Modal -->
<div class="modal fade" id="AddDiseaseModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status" action="<?php echo base_url(); ?>Disease_Surveillance/Disease_add" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">Disease</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
						<div class="row">
							<label for="Name" class="col-sm-3 control-label">Disease Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="name" id="Name" placeholder=" Name" value="<?php echo set_value('name'); ?>" />
									<?php echo form_error('name');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Name" class="col-sm-3 control-label">Code</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="case_code" id="case_code" placeholder=" Case Code">
								  <?php echo form_error('case_code');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Active" class="col-sm-3 control-label">Active</label>
								<div class="col-sm-8">
									<label class="radio-inline">
										<input type="radio" name="active" id="yes" value="1" checked="checked"  <?php echo set_radio('active', '1', TRUE); ?>> Yes<br>
									</label>
									<label class="radio-inline">
										<input type="radio" name="active" id="no" value="0"  <?php echo set_radio('active', '0'); ?>> No<br>
									</label>
									<?php echo form_error('active');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Name" class="col-sm-3 control-label">Disease Code </label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="short_name" id="short_name" placeholder=" Short name">
								  <?php echo form_error('short_name');  ?>
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
<!-- End Add Level Modal -->
<!-- Edit Level Modal -->
<div class="modal fade" id="EditLevelModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status1" action="<?php echo base_url(); ?>cpanel/disease_surveillance/Disease_surveillance/disease_edit" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">Edit Disease</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
						<input type="hidden" class="form-control" name="hidden" id="hidden">
						<div class="row">
							<label for="Name" class="col-sm-3 control-label">Disease Name</label>
								<div class="col-sm-8">
						  <input type="text" class="form-control" name="name1" id="Name1" placeholder="Name">
						  <?php echo form_error('name1');  ?>
						</div>
						</div>
						<div class="row">
							<label for="Name" class="col-sm-3 control-label">Code</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="case_code1" id="case_code1" placeholder=" Case Code">
								  <?php echo form_error('case_code1');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="pro" class="col-sm-3 control-label">Active</label>
								<div class="col-sm-8">
								<label class="radio-inline">
									<input type="radio" name="active1" id="editYes" value="1"<?php echo set_radio('pro','1') ?>> Yes<br>
								</label>
								<label class="radio-inline">
									<input type="radio" name="active1" id="editNo" value="0"<?php echo set_radio('pro','0') ?>> No<br>
								</label>
								</div>
								 <?php echo form_error('active1');  ?>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Name" class="col-sm-3 control-label">Disease Code  </label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="short_name1" id="short_name1"placeholder=" Short Name">
								  <?php echo form_error('short_name1');  ?>
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

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
    	$('.footable').footable();
   	});
	function del_disease(obj,pro){	          
		if(pro == 0){
			var myurl = '<?php echo base_url(); ?>cpanel/disease_surveillance/Disease_surveillance/disease_del/'+obj;
			var is_confirm = confirm("Are you sure you want to delete?");		 
			if(is_confirm)
			{
				$.get(myurl, function (show) {
					window.location.replace("<?php echo base_url(); ?>Disease_Surveillance/Diseases_List");
				});
			}
		}
	  	else{
		  	alert('Active Diseases are not Deletable');
		}
	}
	
	$('.editData').on('click', function()
	{
		var id = $(this).data("id");
		$.ajax
		({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>cpanel/disease_surveillance/Disease_surveillance/disease_edit_get",
			success: function(result)
			{
				//alert(result);
				var obj = JSON.parse(result);
				$('input[name=hidden]').val(obj[0].id);
				$('input[name=name1]').val(obj[0].type_case_name);
				$('input[name=case_code1]').val(obj[0].type_short_code);
				$('input[name=short_name1]').val(obj[0].short_name);
				if(obj[0].pro == 1){
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

	 /*<?php
	 //if(form_error('name') || form_error('code') || form_error('active') )//{// ?>
	 $("#add_button").trigger("click");
	 <?php //} ?>*/
	
 	$("#cancelmodal").click(function(){
		$( "div" ).remove( ".error" );
	}); 
	<?php
	if(form_error('name') || form_error('case_code') || form_error('active') || form_error('short_name') ){ ?>
	$("#add_button").trigger("click");
	<?php } ?>
	<?php if(form_error('name1') || form_error('case_code1') || form_error('active1')|| form_error('short_name1')) {?>
		$('#edit_button[data-id="<?php echo $editid; ?>"]').trigger('click');
	<?php } ?>
	$('#AddDiseaseModal').on('hidden.bs.modal', function () {
		$( "div" ).remove( ".error" );
	});
	$('#EditLevelModal').on('hidden.bs.modal', function () {
		$( "div" ).remove( ".error" );
	});
</script>