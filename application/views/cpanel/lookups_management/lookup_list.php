<?php //$availableOption = range(1,20);
									//	array_push($availableOption, 7); print_r($availableOption); exit; 
									//print_r($data); exit;?>
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

span.add-row, span.add-row-edit{
background: #14925f;
border-radius: 2px;
border: 0px;
color: white;
box-shadow: 0px 0px 2px 1px #b5b2b2;
padding: 4px 8px;
margin-left: 2px;
}
i.add, i.add-edit{
position: relative;
top: -1px;
font-size: 13px;
}

span.del-row, span.del-row-edit{
background: #dd4b39;
border-radius: 2px;
border: 0px;
color: white;
box-shadow: 0px 0px 2px 1px #b5b2b2;
padding: 4px 8px;
}
i.del, i.del-edit{
position: relative;
top: 0px;
font-size: 14px;
}

form {
display: block;
margin-top: 0em;
}

form .modal-content .modal-header {
background-color:#008d4c;


}

form button{
border:0px;
}
form .add-row{
background-color:#008d4c;
cursor: pointer;
}
form .del-row{
background-color:#dd4b39;
cursor: pointer;
margin-left:2px;
}
.del-row-edit{
	margin-left:5px;
	cursor: pointer;
}
.add-row-edit{
	cursor: pointer;
}
form .del-row .fa-times{
color:#fff;
}
form table td{
padding:5px 0px;

}
#my_table tbody tr, #my_table tbody td, #myData tbody tr, #myData tbody td{
  border:0px;
}
#my_table tbody tr td{
	padding:9px 0px;
	margin:0px;
}
#my_table tbody tr td input{
	width:100%;
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
.modal-dialog{
	width:650px;
}

</style>
<div class="container bodycontainer">
   <div class="row">
        <div class="panel panel-primary">
        <div class="panel-heading"> List of General Lookups </div>
        <div class="panel-body">
			<div class="row">   
				<div class="form-group">
					<label class="col-xs-1 control-label lbl-setting" for="search">Search:</label>
						<div class="col-xs-4">
						<input id="search_table" name="searchParam" class="form-control" type="text" placeholder="Name/Label"/>
						</div>
				</div>
			</div>
            <br>
            <table id="gl_tbl" class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="userList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">Name</th>
                     <th class="text-center Heading">Label</th>
                     <th class="text-center Heading">Created On</th>
                     <th class="text-center Heading">Created By</th>
                     <th class="text-center Heading">
                        <!-- <a id="add_button" class="add_button" role="button" data-toggle="modal" data-target="#AddLevelModal" rel="tooltip" title="Add Lookup">
                           <button class="submit btn-success btn-sm">
                           <i class="fa fa-plus"></i> Add</button>
                        </a>
						-->
						<button id="add_button" class="submit custom-add-btn btn-sm" data-toggle="modal" title="Add Lookup" data-target="#AddLevelModal">
                           <i class="fa fa-plus"></i> Add
						</button>
                     </th>
                  </tr>
               </thead>
               <tbody id="tbody">

               </tbody>
            </table>          
         </div> <!--end of panel body-->
      </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
</div><!--End of page content or body-->
<!-- Add Level Modal -->
<div class="modal fade" id="AddLevelModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status" action="<?php echo base_url(); ?>Lookups_management/lookups_add" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">Add Lookup</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>--> 
						<input type="hidden" class="form-control" name="hidden1" id="hidden1" value="1">
						<div class="row">
							<label for="Name" class="col-sm-3 control-label">Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="name" id="Name" placeholder=" Name" value="<?php echo set_value('name'); ?>" />
									<?php echo form_error('name');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Code" class="col-sm-3 control-label">Code</label>
								<div class="col-sm-8">
									<select class="form-control text-center" name="code" id="Code">
										<option value="">Select Code</option>
									<?php
										$availableOption = range(1,100);
										$selectedOrInDb  = $selected; // Selected OR from DB
										$remaining = array_diff($availableOption, $selectedOrInDb);
											foreach($remaining as $key => $value){
												//<option value=" echo $value; "> echo $value; </option>
												echo "<option value='$value' " . set_select('code', $value) . " >".$value."</option>";
											} ?>
									</select>
									<?php echo form_error('code');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Name" class="col-sm-3 control-label">Label</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="label" id="label" placeholder=" Label" value="<?php echo set_value('label'); ?>" />
									<?php echo form_error('label');  ?>
								</div>
						</div>
					<hr>
					<div>
					<table id="my_table" style="width:100%" >
					  <tr>
						<th style="text-align:center">Value</th>
						<th style="text-align:center">Caption</th> 
						<th style="text-align:center">is Active</th> 
						<th style="text-align:center">Action</th>
					  </tr>
					  <tr>
						<td><input type="text" name="value1" /></td>
						<td><input type="text" name="caption1"/></td>
						<td><input type="checkbox" class="check" name="is_active1" value="1" id="is_active" checked="checked"/></td>
						<td style="width:100px;"><span class="add-row"><i class="fas fa-plus add"></i></span>
							<span class="del-row"><i class="fas fa-times del"></i></span>
						</td>
					  </tr>
					</table>
					</div>
					<div class="row">
						<div class="col-md-6" style="margin-left: 65%;">
							<button id="btn-modalForm-submit-status" type="submit" class="btn-background box1 num_row"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
							<button type="button" class="btn-background box1" id="cancelmodal" data-dismiss="modal"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- Add Level Modal End -->
<!-- Edit Level Modal Starts -->
<div class="modal fade" id="EditLevelModal" role="dialog" style="display: none;">
	<div class="modal-dialog">
		<!-- Modal content-->
		<form name="data" class="modalForm" id="modalForm-status1" action="<?php echo base_url(); ?>Lookups_management/lookups_edit" method="post" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header" height="35px">
					<h4 class="modal-title-status">Edit Lookup</h4>
				</div>
				<div class="modal-body">
						<!--<input type="hidden" id="asset_id" name="asset_id" value=""/>-->
						<input type="hidden" class="form-control" name="hidden" id="hidden">
						<input type="hidden" class="form-control" name="hidden2" id="hidden2">
						<div class="row">
							<label for="Name" class="col-sm-3 control-label">Name</label>
								<div class="col-sm-8">
								  <input type="text" class="form-control" name="name1" id="Name1" placeholder="Name">
								  <?php echo form_error('name1');  ?>
								</div>
						</div>
						<div class="row" style="margin-top:10px;">
							<label for="Name" class="col-sm-3 control-label">Label</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="label1" id="label1" placeholder=" Label" value="<?php echo set_value('label'); ?>" />
									<?php echo form_error('label1');  ?>
								</div>
						</div>
					<hr>
					<table id="myData" style="width:100%"></table>
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
<!--Edit Level Modal end-->
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
    	$('.footable').footable();
   	});
		//DataTable start
	 $(document).ready(function() { 
	   var columns = [
			{ data: "serial" ,
			orderable: false,
			},
			{ data: "name" },
			{ data: "label" },
			{ data: "created_date" },
			{ data: "created_by" },
			{ data: "id" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a id="edit_button" data-original-title="Edit" href="" data-id="'+data+'" data-toggle="modal" data-target="#EditLevelModal" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData" ><i class="fa fa-pencil"></i></a><a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('+data+')"  data-toggle="tooltip"  class="btn btn-xs btn-danger btn-remov" ><i class="fa fa-times"></i></a>'
					}
			},
		]; 
		var table = $('#gl_tbl').DataTable(
		{
			"pageLength" : 50,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "desc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>Ajax_hr_management/gl_list_search",
				type : 'GET'
			},
			"columns": columns,
			dom: 'lrtips',
				"fnDrawCallback": function(oSettings) {
					if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
						$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
					}
				}
		 
		});
		$('#search_table').on('keyup change', function () {
			table.search( this.value ).draw();
		});
	});
	//End
	function del_user(obj)
	{	  
		var myurl = '<?php echo base_url(); ?>Lookups_management/lookups_del/'+obj;
		var is_confirm = confirm("Are you sure you want to delete?");
		if(is_confirm)
		{
			$.get(myurl, function (show) {
				window.location.replace("<?php echo base_url(); ?>Lookups_management/lookups_list");
			});
		}
	}
	
	$(document).on("click",".editData",  function (e){
		var id = $(this).data("id");
		$.ajax
		({
			type: "POST",
			data: "id="+id,
			url: "<?php echo base_url(); ?>Lookups_management/lookups_edit_get",
			success: function(result)
			{
				//alert(result);
				var obj = JSON.parse(result);
				$('input[name=hidden]').val(obj[0].id);
				$('input[name=name1]').val(obj[0].name);
				//$('option[name=code]').val(obj[0].code);
				$('input[name=label1]').val(obj[0].label);
				if(obj[0].value != null)
				{
					var row = $("<tbody><tr><th style='text-align:center'>Value</th><th style='text-align:center'>Caption</th><th style='text-align:center'>is Active</th><th style='text-align:center'>Action</th></tr></tbody>");
				    $("#myData").append(row);
				}else
				{ 
					var row = $("<tbody>"+
					"<tr>"+
						"<th style='text-align:center'>Value</th>"+
						"<th style='text-align:center'>Caption</th>"+
						"<th style='text-align:center'>is active</th>"+
						"<th style='text-align:center; width:100px;'>Action</th>"+
					  "</tr>"+
					  "<tr>"+
						"<td><input type='text' name='value1' size='30'/></td>"+
						"<td><input type='text' name='caption1' size='30'/></td>"+
						"<td><input type='checkbox' class='check' name='is_active1' value='1' id='is_active' checked='checked'/></td>"+
						"<td><span class='add-row-edit'><i class='fas fa-plus add'></i></span>"+
						"<span class='del-row-edit'><i class='fas fa-times del'></i></span>"+
						"</td>"+
					  "</tr>"+
					  "</tbody>");
					 $("#myData").append(row);
					 $("#hidden2").val(1);
				}
				let num = 1;
				$.each(obj, function( index, value ) {
							if(value.value != null || value.caption != null)
							{
                               var row = "<tr><td><input type='text' name='value"+num+"' size='30' value='"+value.value+"'/></td>";
							   row += "<td><input type='text' name='caption"+num+"' size='30' value='"+value.caption+"'/></td>";
							   if(value.active == 1){
							   row += "<td><input type='checkbox' class='check' name='is_active"+num+"' value='1' id='is_active' checked='checked'/></td>";
							   }else{
								row +="<td><input type='checkbox' class='uncheck' name='is_active"+num+"' value='1' id='is_active'/></td>";
							   };
							   row +="<td><span class='add-row-edit'><i class='fas fa-plus add-edit'></i></span><span class='del-row-edit'><i class='fas fa-times del-edit'></i></span></td></tr>";
                               $("#myData").append(row);
							   num = num + 1;
							}
							$("#hidden2").val(num);
                            });
			}
		});
	});

	<?php
	if(form_error('name') || form_error('code') || form_error('label') ){ ?>
	$("#add_button").trigger("click");
	<?php } ?>
	
/* 	 $("#cancelmodal").click(function(){
		$( "div" ).remove( ".error" );
	}); */
	<?php if(form_error('name1') || form_error('code1') || form_error('label1')){ ?>
		$('#edit_button[data-id="<?php echo $editid; ?>"]').trigger('click');
	<?php } ?>
	$('#AddLevelModal').on('hidden.bs.modal', function ()
	{
		$( "div" ).remove( ".error" );
		$('#Name').val("");
		$('#Code').val("");
		$('#label').val("");
		$("#my_table").find("tr:gt(1)").remove();
	});
	$('#EditLevelModal').on('hidden.bs.modal', function () {
		$( "div" ).remove( ".error" );
		$('#myData :nth-child(n+1)').remove();
	});
	
	let val = 1;
	$(document).on('click', '.add-row', function(){ 
		val = val + 1;
		var markup = "<tr><td><input type='text' name='value"+val+"' size='30'/></td><td><input type='text' name='caption"+val+"' size='30'/><td><input type='checkbox' class='check' name='is_active"+val+"' value='1' id='is_active"+val+"' checked='checked'/></td><td><span class='add-row'><i class='fas fa-plus add'></i></span><span class='del-row'><i class='fas fa-times del'></i></span></td></tr>";
        $("#my_table tbody").append(markup);
		$("#hidden1").val(val);
    });
	
	$(document).on("click", ".del-row", function() {
		if(val > 1){
		//alert(val);
		val = val - 1
		$(this).closest("tr").remove();
		$("#hidden1").val(val)
		}else{
			alert("This Row cannot be deleted");
		}	
	});
	let val1 = 0;
	$(document).on('click', '.add-row-edit', function(){ 
		val1 = parseInt($("#hidden2").val());
		val1 = val1 + 1;
		var markup = "<tr><td><input type='text' name='value"+val1+"' size='30'></td><td><input type='text' name='caption"+val1+"' size='30'></td><td><input type='checkbox' class='check' name='is_active"+val1+"' value='1' id='is_active"+val1+"' checked='checked'/></td><td><span class='add-row-edit'><i class='fas fa-plus add-edit'></i></span><span class='del-row-edit'><i class='fas fa-times del-edit'></i></td></tr>";
        $("#myData tbody").append(markup);
		$("#hidden2").val(val1);
    });
	
	$(document).on("click", ".del-row-edit", function() {
		//alert(val);
		val1 = parseInt($("#hidden2").val());
		val1 = val1 - 1
		if(val1 != 1 && val1 != 0)
		{
			$(this).closest("tr").remove();
			$("#hidden2").val(val1);
		}else{
			$("#myData").empty();
		}
	});
	$('#EditLevelModal,#AddLevelModal').on("hide.bs.modal", function (e) {
	   if(confirm("If you leave before saving, your changes will be lost.")) return true;
	   else return false;
	});
	//$("[id^='is_active']").on('change', function(){
		//this.value = this.checked ? 1 : 0;
		//alert(this.value);
//}	//).change();
	$('body').on('click', 'input.check', function() {
		$(this).val(this.checked ? 1 : 0);
	});
</script>