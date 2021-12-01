	<?php if($this -> session -> flashdata('message')){  ?>
                          <div class="row mb3">
                            <div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
                              <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
                            </div>
                          </div>
                        <?php } ?>
	<div class="container heading-line top-margin">
	
         <h3 class="heading-1">Cold Chain Asset Types</h3>
			<button type="button" id = "addNew" style="margin-left:41%;" class="btn btn-primary add-new-1 box" ><i class="fa fa-plus" aria-hidden="true"></i> Add new</button>
		    <div id="demo-1" class="collapse">
			<div class="row" style="position:relative;">
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
					<label for="Make" style="margin:10px 0px 0xp 10px">Asset Name : </label>
					<input name="idd" id="idd" type="hidden" value="">
					<input id="purpose" name="purpose" class="form-control" type="text" >
					</div>
				</div>
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
					<label for="Make" style="margin:10px 0px 0xp 10px">Short Name : </label>
					<input id="shortname" name="shortname" class="form-control" type="text">
					</div>
				</div>
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
					<label for="Make" style="margin:10px 0px 0xp 10px">Equipment Type : </label>
					<select name="equipment_type_id" id="equipment_type_id" required class="form-control">
							<option value="">--Select--</option>
							<?php foreach($equipment_types as $key=>$val) { ?>
								<option value="<?php echo $val['pk_id']; ?>"><?php echo $val['equipment_type_name']; ?></option>
							<?php } ?>
					</select>
					</div>
				</div>
			</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4" style="margin-top:6px;">
						<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
							<label for="Make" style="margin:10px 0px 0xp 10px">Parent : </label>
							<select name="parent_id" id="parent_id" required class="form-control">
									<option value="0">--Select--</option>
									<?php
										 foreach($data as $key=>$val){
										 ?>
										<option value="<?php echo $val['pk_id']; ?>" ><?php echo $val['asset_type_name']; ?></option>
                                    <?php } ?>
							</select>
						</div>
				    </div>
					<div class="col-md-4" style="margin-top:6px;">
				    </div>
					<div class="col-md-4" style="margin-top: 51px;">
						<Button type = "Button" class="btn-background box1" style="margin-left:95px;" id = "save"> <span class="save-1" style="border:none; top:0px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
						<Button type="Button" class="btn-background box1" id = "cancel">  <span class="save-1" style="border:none; top:0px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
					</div>
				</div>
			
			
		  </div>
		<div class="row" style="margin-top:10px;">
						<table style="position:relative; top:-45px; margin-bottom:20px; text-align:center;" id="example" class="table table-striped table-bordered res-1 table-responsive" cellspacing="0" width="97%" style="border: 1px solid #ccc4c4 !important; position:relative; top:-30px;">
				
        <thead>
            <tr>
                <th style="background-color:#008d4c; color:white; text-align:center">S.No</th>
                <th style="width:60%;background-color:#008d4c; color:white; text-align:center">Asset Type</th>
                <th style="width:60%;background-color:#008d4c; color:white; text-align:center">Parent</th>
				<th style="width:75%;background-color:#008d4c; color:white; text-align:center">Short Name</th>
				<th style="width:103px;background-color:#008d4c; color:white; text-align:center">Asset Equipment Type</th>
                <th style="background:#008d4c; color:white; text-align:center">Action</th>
                
            </tr>
        </thead>
        <tbody>
		<?php $i=1; ?>
			<?php foreach($data as $key=>$val) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td class="text-left"><?php echo $val['asset_type_name']; ?></td>
                <td class="text-left"><?php echo get_asset_parent_name($val['parent_id']); ?></td>
				<td><?php echo $val['short_name']; ?></td>
				<td class="text-left"><?php echo $val['equipment_type']; ?></td>
                <td><a style="color:#008d4c" href = "<?php echo base_url(); ?>Admin_Configuration/cc_asset_delete/<?php echo $val['pk_id']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a>
				<a data-id="<?php echo $val['pk_id']; ?>" style="color:#008d4c" id = "edit" href = "#"  ><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>

            </tr>
			<?php $i++; }	?>
        </tbody>
		
    </table>  
</div>		
			</div>
<!--<script src="<?php echo base_url(); ?>includes/studentTest/js/jquery-3.1.1.min.js"></script>-->
<script src="<?php echo base_url(); ?>includes/js/custome.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!--<script src="<?php echo base_url(); ?>includes/studentTest/js/bootstrap.min.js"></script>-->
<script>
$(document).ready(function() {

     $('#example').DataTable( 
	 /* {
        "pagingType": "full_numbers"
    } */);  
 $("#search-word").keyup(function(){
 search_table($(this).val());
 });

});
</script>
<script type="text/javascript">
 $(document).on('click','#save',function(){
		var purpose = $('#purpose').val();
		var shortname = $('#shortname').val();
		var equipment_type_id = $('#equipment_type_id').val();
		var parent_id = $('#parent_id').val();
		var update_id = $('#idd').val();
		//alert(update_id);
		var name = "manufacturer";
		if(purpose=="")
			alert('You are entering Invalid Purpose Type!');
		else{
			$.ajax({
				type:"POST",
				data:"purpose="+purpose+"&shortname="+shortname+"&name="+name+"&equipment_type_id="+equipment_type_id+"&parent_id="+parent_id+"&update_id="+update_id,
				url:"<?php echo base_url(); ?>Admin_Configuration/cc_asset_save",
				success: function(result){
								if(result==1){
									window.location.href = '<?php echo base_url(); ?>Admin_Configuration/cc_asset';
								}else{
									alert('Something went wrong! Please Refresh your page to continue!');
								}
							}
			});
		}
	});
	$(document).on('click','#edit',function(){
    var id = $(this).data("id");
	//alert(id);
    $.ajax({ 
     type: "POST",
     data:"id="+id,
     async:false,
	 dataType : 'json',
     url: "<?php echo base_url(); ?>Admin_Configuration/edit_cc_asset",
     success: function(result){
		//var result1 = jQuery.parseJSON(result);
		
		$('#idd').val(result.pk_id);
		$('#purpose').val(result.asset_type_name);
		$('#shortname').val(result.short_name);
		$('#equipment_type_id').val(result.ccm_equipment_type_id);
		$('#parent_id').val(result.parent_id);
		//alert(result);
     }
    }); 
   });
	
	$(document).on('click','#cancel',function(){
		$('#demo-1').hide();
	});
	$(document).on('click','#addNew',function(){
		$('#demo-1').show();
	});
	$(document).on('click','#edit',function(){
		$('#demo-1').show();
	});
</script>