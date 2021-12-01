<?php //print_r($data);exit; ?>
<?php if($this -> session -> flashdata('message')){  ?>
    <div class="row mb3">
        <div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
            <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong>
			</div> 
        </div>
    </div>
<?php } ?>
	<div class="container heading-line top-margin">
        <h3 class="heading-1">Location</h3>
		<button type="button" id = "addNew" style="background: #008d4c; margin-left:41%;" class="btn btn-primary add-new-1 box" >Add new</button>
		<div id="demo-1" class="collapse" >
			<div class="row" style="position:relative; ">
				
				<div class="col-md-3 coll-1" style="border: 1px solid lightgray; margin-left: 14px;height: 45px;padding: 6px 0px; width:18%;">
					<span class="bps">Asset ID : </span>
					<input name="asset_id" id="asset_id" placeholder="Asset ID" style="display: inline-block; width: 41%; position: relative; border: none; left: -6px; top: 4px;" type="text">			
				</div>
				
				<div style="border: 1px solid lightgray; height: 45px;padding:6px 0px ;margin: 0px; width:18%;" class="col-md-3 coll-2">
					<span class="bps">Asset Name:</span>
					<input name="purpose" id="purpose" placeholder="Enter Name" style="display: inline-block; width: 41%; position: relative; border: none; left: -6px; top: 4px;" type="text">			
				</div>
				
				<div class="col-md-3 coll-3" style="border:1px solid lightgray;height:45px;padding:5px 0px ;width: 17%; display: inline;">
					<span class="bps">Serial No : </span> 
					<input id="sr" name="sr" placeholder="Sr.no." style="display: inline-block;width: 40%; position: relative; border: none; left: -6px; top: 4px;" type="text">
				</div>
				
				<div class="col-md-3 coll-2" style="height:45px;padding:5px 0px; width:45%;">
						<span class="bps" style="position: relative;top: 0px;padding: 10px !important;">Location : </span>
						<select id="warehouses" name="warehouses" style="padding: 6px;border: 1px solid lighgray;border: 1px solid lightgray;">
						   <?php foreach ($options as $key=>$value) {?>
							<option value = <?php echo $value['pk_id']; ?>><?php echo $value['warehouse_name']; ?></option>
							<?php } ?>
						</select>
				</div>
			</div>
			<div class="row" style="position:relative;top: 4px;">
				<div class="col-md-3 offset-md-9" style="float:right;  height:45px; padding-top:6px; width: 26%;">
					<button type="Button" class="btn-background box1" style="margin-left: 66px;" id="save"> <span class="save-1" style="border:none; top:0px;"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</span></button>
					<button type="Button" class="btn-background box1" id="cancel">  <span class="save-1" style="border:none; top:0px;"><i class="fa fa-times" aria-hidden="true"></i> Cancel</span></button>
				</div>
			</div>
		</div>
		
		
		<div class="row" style="margin-top:40px;">
			<table style="margin-top:30px;" id="example" class="table table-striped table-bordered res-1 table-responsive" cellspacing="0" width="97%" style="border: 1px solid #ccc4c4 !important; position:relative; top:-30px;">	
				<thead>
					<tr>
						<th style="width:6%;background-color:#008d4c; color:white; text-align:center">S.No</th>
						<th style="width:6%;background-color:#008d4c; color:white; text-align:center">Asset Name</th>
						<th style="width:6%;background:#008d4c; color:white; text-align:center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; ?>
					<?php foreach($data as $key=>$val) { ?>
					<tr>
						<td style="text-align:center;"><?php echo $i; ?></td>
						<td style="text-align:center;"><?php echo $val['asset_type_name']; ?></td>
						<td style="text-align:center;"><a style="color:#008d4c" href = "#" ><i class="fa fa-times" aria-hidden="true"></i></a></td>
					</tr>
					<?php $i++; }	?>
				</tbody>
			</table>
		</div>		
	</div>
<!-- JavaScript Code Starts Here -->	
<script src="<?php echo base_url(); ?>includes/js/custome.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
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
		var warehouses = $('#warehouses').val();
		var serial = $('#sr').val();
		var asset_id = $('#asset_id').val();
		alert(asset_id);
		var name = "warehouse";
		if(purpose=="" || serial=="" || asset_id=="")
			alert('You are entering Invalid Asset name!');
		else{
			$.ajax({
				type:"POST",
				data:"purpose= "+ purpose+"&name= "+name+"&warehouses="+warehouses+"&serial="+serial+"&asset_id="+asset_id,
				url:"<?php echo base_url(); ?>Admin_Configuration/location_save",
				success: function(result){
								if(result==1){
									window.location.href = '<?php echo base_url(); ?>Admin_Configuration/location';
								}else{
									alert('Something went wrong! Please Refresh your page to continue!');
								}
							}
			});
		}
	});
	$(document).on('click','#cancel',function(){
		$('#demo-1').hide();
	});
	$(document).on('click','#addNew',function(){
		$('#demo-1').show();
	});
</script>