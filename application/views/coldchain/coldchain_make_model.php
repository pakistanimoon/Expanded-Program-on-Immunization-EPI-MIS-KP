<?php if($this -> session -> flashdata('message')){  ?>
	<div class="row mb3">
		<div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
			<div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
		</div>
	</div>
<?php } ?>
	<div class="container heading-line top-margin">
		<h3 class="heading-1">Cold Chain Make & Model</h3>
		<button type="button" id = "addNew" style="margin-left:41%;" class="btn btn-primary add-new-1 box" ><i class="fa fa-plus" aria-hidden="true"></i> Add new</button>
		<div id="demo-1" class="collapse">
			<div class="row" style="width:100%; margin:0 auto;">
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
						<label for="Make" style="margin:10px 0px 0xp 10px">Make : </label>
						<input type="hidden" name="idd" id="idd">
						<select name="make_id" id="make_id" required class="form-control">
							<option value="">--Select--</option>
							<?php foreach($all_cc_makes as $key=>$val) { ?>
								<option value="<?php echo $val['pk_id']; ?>"><?php echo $val['make_name']; ?></option>
							<?php } ?>
							<option value="0">--Add New--</option>
						</select>
					</div>
				</div>
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
						<label for="Model"  style="margin:10px 0px 0xp 10px">Model : </label>
						<input id="model" name="model" class="form-control" type="text">
					</div>
				</div>
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px;width:100%;">
						<label for="Make"  style="margin:10px 0px 0xp 10px">Asset Type : </label>
						<select name="asset_type_id" id="asset_type_id" required class="form-control">
							<option value="">--Select--</option>
							<?php foreach($all_assets_types as $key=>$val) { ?>
								<option value="<?php echo $val['pk_id']; ?>"><?php echo $val['asset_type_name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row hide hiddendiv" style="width:100%; margin:0 auto;">
				<div class="col-md-4" style="margin-top:6px;">
					<div class="form-group" style="box-shadow: 0px 0px 4px 0px #dde1d8;padding: 5px; width:100%;">
						<label for="Make" style="margin:10px 0px 0xp 10px">Make Name : </label>
						<input type="text" class="form-control" name="make_name" id="make_name" >
					</div>
				</div>
			</div>
			<div class="row" style="margin-top:10px;">
				<div class="col-md-3 col-md-offset-9">
				<button type="Button" class="btn-background box1" id="save"> <span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
				<button type="Button" class="btn-background box1" id="cancel"><span class="save-1" style="border:none;top:0px; padding:4px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:10px;">
			<table style="position:relative; top:-45px; margin-bottom:20px; text-align:center;" id="example" class="table table-striped table-bordered res-1 table-responsive" cellspacing="0" width="97%" style="border: 1px solid #ccc4c4 !important; position:relative; top:-30px;">
				<thead>
					<tr>
						<th style="background-color:#008d4c; color:white; text-align:center">S.No</th>
						<th style="width:60%;background-color:#008d4c; color:white; text-align:center">Make</th>
						<th style="width:75%;background-color:#008d4c; color:white; text-align:center">Model</th>
						<th style="width:75%;background-color:#008d4c; color:white; text-align:center">Asset Type</th>
						<th style="background:#008d4c; color:white; text-align:center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php foreach($all_make_models as $key=>$val) { ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td class="text-left"><?php echo $val['make']; ?></td>
						<td><?php echo $val['model_name']; ?></td>
						<td class="text-left"><?php echo $val['asset_type']; ?></td>
						<td>
							<a style="color:#008d4c" href = "<?php echo base_url(); ?>Coldchain/epi_cc_make_mode_delete/<?php echo $val['pk_id']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a>
							<a data-id="<?php echo $val['pk_id']; ?>" style="color:#008d4c" id = "edit" href = "#"  ><i class="fa fa-pencil-square" aria-hidden="true"></i></a>
						</td>
					</tr>
					<?php $i++; }	?>
				</tbody>
			</table>
		</div>		
	</div>
	<script src="<?php echo base_url(); ?>includes/js/custome.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable();  
			$("#search-word").keyup(function(){
				search_table($(this).val());
			});
		});
		$(document).on('change','#make_id',function(){
			if(parseInt($(this).val()) == 0){
				$('.hiddendiv').removeClass('hide');
			}else{
				$('.hiddendiv').addClass('hide');
			}
		});
		$(document).on('click','#save',function(){
			var makeId = $('#make_id').val();
			var model = $('#model').val();
			var assetTypeId = $('#asset_type_id').val();
			var makeName = $('#make_name').val();
			var updateId = $('#idd').val();
			if(parseInt(makeId) == 0 && makeName != ''){
				$.ajax({
					type:"POST",
					data:"make_name="+makeName,
					url:"<?php echo base_url(); ?>Coldchain/check_for_unique_make_name",
					success: function(result){
						if(result > 0){
							alert('Please Suggest a Unique Make name! Name already Exists');
						}else{
							$.ajax({
								type:"POST",
								data:"make_name="+makeName,
								url:"<?php echo base_url(); ?>Coldchain/add_new_cc_make",
								success: function(makeresult){
									if(makeresult > 0){
										makeId = parseInt(makeresult);
										$.ajax({
											type:"POST",
											data:"make_id="+makeId+"&model="+model+"&asset_type_id="+assetTypeId+"&update="+updateId,
											url:"<?php echo base_url(); ?>Coldchain/add_new_cc_model",
											success: function(result){
												if(result>0){
													window.location.href = '<?php echo base_url(); ?>Coldchain-MakeModel';
												}else{
													alert('Something went wrong! Please Refresh your page to continue!');
												}
											}
										});
									}else{
										alert('Something went wrong! Please Refresh your page to continue!');
									}
								}
							});
						}
					}
				});
			}else if(parseInt(makeId) > 0 && model != '' && parseInt(assetTypeId) > 0){
				$.ajax({
					type:"POST",
					data:"model="+model+"&make_id="+makeId,
					url:"<?php echo base_url(); ?>Coldchain/check_for_unique_model_name_for_the_make",
					success: function(result){
						if(result > 0){
							alert('Please Suggest a Unique Model name for this make! Name already Exists');
						}else{
							$.ajax({
								type:"POST",
								data:"make_id="+makeId+"&model="+model+"&asset_type_id="+assetTypeId+"&update="+updateId,
								url:"<?php echo base_url(); ?>Coldchain/add_new_cc_model",
								success: function(result){
									if(result>0){
										window.location.href = '<?php echo base_url(); ?>Coldchain-MakeModel';
									}else{
										alert('Something went wrong! Please Refresh your page to continue!');
									}
								}
							});
						}
					}
				});
			}
		});
		$(document).on('click','#edit',function(){
			var id = $(this).data("id");
			$.ajax({
				type: "POST",
				data:"id="+id,
				async:false,
				dataType : 'json',
				url: "<?php echo base_url(); ?>Coldchain/fetch_cc_model_by_id",
				success: function(result){
					$('#idd').val(result.pk_id);
					$('#make_id').val(result.ccm_make_id);
					$('#model').val(result.model_name);
					$('#asset_type_id').val(result.ccm_asset_type_id);
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