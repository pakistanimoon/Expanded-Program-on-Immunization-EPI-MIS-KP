<?php //$availableOption = range(1,20);
									//	array_push($availableOption, 7); print_r($availableOption); exit; ?>
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
.dataTables_wrapper{
margin-top:-30px;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper no-footer{
top:6px;
}
</style>  
<div class="container bodycontainer">
	<div class="row">
        <div class="panel panel-primary">
			<div class="panel-heading"> List of HR </div>
			<div class="panel-body">
				<form method="post" id="filter-form">           
				<div class="row">   
					<div class="form-group">
						 <label class="col-xs-1 control-label lbl-setting" for="search">Search:</label>
						 <div class="col-xs-3">
							<input id="search_table" name="searchParam" class="form-control" type="text" placeholder="Enter Name/CNIC/Phone"/>
						 </div>
						 
						 <label class="col-xs-1 control-label lbl-setting" for="utype">Type&nbsp;:</label>
						<div class="col-xs-3">
							<select id="utype" name="utype" class="filter-status form-control">
								<option value="0">--- Select User Type ---</option>
								<?php general_config(array("table_name"=>"hr_sub_types","value_col"=>"type_id","label_col"=>"title")); ?>
							</select>
						</div>
						<label class="col-xs-1 control-label lbl-setting" for="utype">Status&nbsp;:</label>
						<div class="col-xs-3">
							<select id="status" name="status" class="filter-status form-control">
								<!--<option value="0">--- Select Status ---</option>-->
								<?php general_lookups(array("lookup_name"=>"status"),array("create"=>"options")); ?>
							</select>
						</div>
						 
					</div>
				</div>
				<div id="search_box" class="row" style="margin-top:5px;">             
					<label class="col-xs-1 control-label lbl-setting" for="level">Level&nbsp;:</label>
					<div class="col-xs-3">
						<select id="level" name="level" class="filter-status form-control">
							<option id="level" value="0">--- Select Level ---</option>
							<?php general_config(array("table_name"=>"hr_levels","value_col"=>"code","active"=>"1")); ?>
						</select>
					</div>
					<div id="showdistrict" style="display:none;">
						<label class="col-xs-1 control-label lbl-setting" for="utype">District&nbsp;:</label>
						<div class="col-xs-3">
							<select id="new_distcode" name="district" class="filter-status form-control">
								<option value="">Select District</option>
									<?php foreach($districts as $row){?>  
										<option value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode',$row['distcode']); ?>  ><?php echo $row['district'];?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div id="showtehsil" style="display:none;">
						<label class="col-xs-1 control-label lbl-setting" for="utype">Tehsil&nbsp;:</label>
						<div class="col-xs-3">
							<select id="new_tehcode" name="tehsil" class="filter-status form-control">
								<option value="">Select Tehsil</option>
									<?php foreach($resultTeh as $row){?>
										<option value="<?php echo $row['tcode'];?>" <?php echo set_select('tcode',$row['tcode']); ?> ><?php echo $row['tehsil'];?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div  id="showuc" style="display:none;">
						<label class="col-xs-1 control-label lbl-setting" for="utype">UC&nbsp;:</label>
						<div class="col-xs-3">
							<select id="new_uncode" name="uc" class="filter-status form-control">
								<option value="">Select Union Council</option>
								
							</select>
						</div>
					</div>
					<div id="showfacility" style="display:none;">
						<label class="col-xs-1 control-label lbl-setting" for="utype">Facility&nbsp;:</label>
						<div class="col-xs-3">
							<select id="new_facode" name="facility" class="filter-status form-control">
								<option value="">Select EPI Center</option>
									
							</select>
						</div>
					</div>
				</div>
					
				</form> 
				<br>
				<table style="width: 100% !important;" id="hr_tbl" class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="userList">
				   <thead id="theadbody">
					  
				   </thead>
				   <tbody id="tbody">
				   </tbody>
				</table>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {
    $('.footable').footable();
  });
</script>
<script type="text/javascript">
 $(document).ready(function() { 
    <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
	    var columns = [
			{ data: "serial" ,
			  orderable: false,
			},
			{ data: "pre_distcode", "visible": false},
			{ data: "post_distcode", "visible": false},
			{ data: "name" },
			{ data: "pre_level","visible": false},
			{ data: "post_level" },
			{ data: "pre_hr_sub_type_id","visible": false},
			{ data: "post_hr_sub_type_id" },
			{ data: "pre_facode", "visible": false },
			{ data: "post_facode" },
			{ data: "pre_uncode", "visible": false},
			{ data: "post_uncode" },
			{ data: "pre_tcode", "visible": false },
			{ data: "post_tcode" },
			{ data: "phone" },
			{ data: "nic" },
			{ data: "pre_status", "visible": false},
			{ data: "post_status","visible": false },
			{ data: "status_date"},
			{ data: "code" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="Status Edit" href="<?php echo base_url(); ?>Hr_management/hr_status_edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
					}
			}, 
			{ data: "code" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 //return '<a data-original-title="View" href="<?php echo base_url(); ?>Hr_management/hr_view/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Hr_management/hr_edit_get/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData" ><i class="fa fa-pencil"></i></a><a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('+data+');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>'
					 return '<a data-original-title="View" href="<?php echo base_url(); ?>Hr_management/hr_view/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Hr_management/hr_edit_get/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData" ><i class="fa fa-pencil"></i></a>'
					}
			},
		]; 
	<?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
	    var columns = [
			{ data: "serial" ,
			  orderable: false,
			},
			{ data: "pre_distcode", "visible": false},
			{ data: "post_distcode"},
			{ data: "name" },
			{ data: "pre_level", "visible": false},
			{ data: "post_level" },
			{ data: "pre_hr_sub_type_id", "visible": false},
			{ data: "post_hr_sub_type_id"},
			{ data: "pre_facode", "visible": false},
			{ data: "post_facode" },
			{ data: "pre_uncode", "visible": false},
			{ data: "post_uncode" },
			{ data: "pre_tcode", "visible": false},
			{ data: "post_tcode" },
			{ data: "phone" },
			{ data: "nic" },
			{ data: "pre_status", "visible": false},
			{ data: "post_status","visible": false},
			{ data: "status_date"},
			{ data: "code" ,
				orderable: false,
				"visible": false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="Status Edit" href="<?php echo base_url(); ?>Hr_management/hr_status_edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
					}
			}, 
			
			{ data: "code" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="View" href="<?php echo base_url(); ?>Hr_management/hr_view/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
					}
			},
		];     
	 <?php } ?>
		var table = $('#hr_tbl').DataTable(
		{
			"pageLength" : 30,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "desc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>Ajax_hr_management/hr_list_search",
				type : 'GET'
			},
			"columns": columns,
			dom: 'lrtips'
		});
		table.columns(17).search("Active").draw();	
		$('#utype').on('change', function () {
			//table.columns(7).search( this.value ).draw();
			var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				table.columns(7).search( this.value ).draw();
			}else{
				table.columns(6).search( this.value ).draw();
			}
		});
		
		$('#new_distcode').on('change', function () {
			//table.columns(2).search( this.value ).draw();
			 var dists=this.value;
				$.ajax({
					type: "POST",
					data: "distcode="+dists,
					url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
							success: function(result){
								$('#new_tehcode').html(result);
							}
				});
			var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				table.columns(2).search( this.value ).draw();
			}else{
				table.columns(1).search( this.value ).draw();
			}
		});
		$('#new_tehcode').on('change', function () {
			//table.columns(18).search( this.value ).draw();
			var tehcode = this.value;
			  var uncode = "";
			  $.ajax({
				type: "POST",
				data: "tcode="+tehcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
				success: function(result){
				  $('#new_uncode').html(result);
				}
			  });
			var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				table.columns(13).search( this.value ).draw();
			}else{
				table.columns(12).search( this.value ).draw();
			}	
		}); 
		$('#new_uncode').on('change', function () {
			//table.columns(16).search( this.value ).draw();
			var uncode = this.value;
			  var facode = "";
			  $.ajax({
				type: "POST",
				data: "uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
				success: function(result){
				  $('#new_facode').html(result);
				}
			  });
			var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				table.columns(11).search( this.value ).draw();
			}else{
				table.columns(10).search( this.value ).draw();
			}
		});
		$('#new_facode').on('change', function () {
			//table.columns(14).search( this.value ).draw();
			var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				table.columns(9).search( this.value ).draw();
			}else{
				table.columns(8).search( this.value ).draw();
			}
		});
		/* $('#search_table').on('keyup change', function () {
			table.search( this.value ).draw();
		}); */
		$('#search_table').on('keyup', function () {
			table.search( this.value ).draw();
		});
		$("#search_box").css( { "margin-bottom" : "20px"} );
		<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
			$('#trbody').remove();
			$('#trbody1').remove();
			var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" >S#</th><th class="text-center Heading" >Name</th><th class="text-center Heading" >Level</th><th class="text-center Heading">Type</th><th class="text-center Heading">HF</th><th class="text-center Heading">UC</th><th class="text-center Heading">Tehsil</th><th class="text-center Heading">Phone</th><th class="text-center Heading">CNIC</th><th class="text-center Heading">Status Date</th><th class="text-center Heading">Update Status</th><th class="text-center Heading" style="width: 80px;"><a href="<?php echo base_url(); ?>Hr_management/hr_add" data-toggle="tooltip" title="Add New HR"><button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button></a></th></tr>';
			$("#theadbody").append(markup);
		<?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
			$('#trbody').remove();
			$('#trbody1').remove();
			var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" >S#</th><th class="text-center Heading" >District</th><th class="text-center Heading" >Name</th><th class="text-center Heading" >Level</th><th class="text-center Heading">Type</th><th class="text-center Heading" rowspan="1">HF</th><th class="text-center Heading">UC</th><th class="text-center Heading">Tehsil</th><th class="text-center Heading">Phone</th><th class="text-center Heading">CNIC</th><th class="text-center Heading">Status Date</th><th class="text-center Heading" style="width: 80px;">Action</th></tr>';
			$("#theadbody").append(markup);
		<?php } ?>
		$('#status').on('change' , function (){
			var status = this.value;
			table.columns().search('').draw();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){

				<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
					$('#trbody').remove();
					$('#trbody1').remove();
					//var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" >S#</th><th class="text-center Heading" >Name</th><th class="text-center Heading" >Level</th><th class="text-center Heading">Type</th><th class="text-center Heading" rowspan="1">HF</th><th class="text-center Heading">UC</th><th class="text-center Heading">Tehsil</th><th class="text-center Heading">Phone</th><th class="text-center Heading">CNIC</th><th class="text-center Heading">Status</th><th class="text-center Heading">Status Updat</th><th class="text-center Heading" style="width: 80px;"><button id="add_button" class="submit custom-add-btn btn-sm" onclick="location.href=<?php echo base_url(); ?>Hr_management/hr_add" ><i class="fa fa-plus"></i> Add </button></th></tr>';
					var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" >S#</th><th class="text-center Heading" >Name</th><th class="text-center Heading" >Level</th><th class="text-center Heading">Type</th><th class="text-center Heading">HF</th><th class="text-center Heading">UC</th><th class="text-center Heading">Tehsil</th><th class="text-center Heading">Phone</th><th class="text-center Heading">CNIC</th><th class="text-center Heading">Status Date</th><th class="text-center Heading">Update Status</th><th class="text-center Heading" style="width: 80px;"><a href="<?php echo base_url(); ?>Hr_management/hr_add" data-toggle="tooltip" title="Add New HR"><button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button></a></th></tr>';
					$("#theadbody").append(markup);
				<?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
					$('#trbody').remove();
					$('#trbody1').remove();
					var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" >S#</th><th class="text-center Heading" >District</th><th class="text-center Heading" >Name</th><th class="text-center Heading" >Level</th><th class="text-center Heading">Type</th><th class="text-center Heading" rowspan="1">HF</th><th class="text-center Heading">UC</th><th class="text-center Heading">Tehsil</th><th class="text-center Heading">Phone</th><th class="text-center Heading">CNIC</th><th class="text-center Heading">Status Date</th><th class="text-center Heading" style="width: 80px;">Action</th></tr>';
					$("#theadbody").append(markup);
				<?php } ?>
				table.columns(17).search(status).draw();
				var post_distcode = $("#new_distcode").val();
				var post_level = $("#level").val();
				var post_hrtype = $("#utype").val();
				var post_facode = $("#new_facode").val();
				var post_uncode = $("#new_uncode").val();
				var post_tehcode =$("#new_tehcode").val();
				if(post_level!=0){
					table.columns(5).search(post_level).draw();
					if(post_facode!=0 ){ 
						table.columns(9).search(post_facode).draw();
					}else if(post_uncode!=0){ 
						table.columns(11).search(post_uncode).draw();
					}else if(post_tehcode!=0){ 
						table.columns(13).search(post_tehcode).draw();
					}else if(post_distcode!=0){ 
						table.columns(2).search(post_distcode).draw(); 
					}
				}
				if(post_hrtype!=0){
					table.columns(7).search(post_hrtype).draw();
				}	
				table.columns(1).visible(false);
				table.columns(4).visible(false);
				table.columns(6).visible(false);
				table.columns(16).visible(false);
				table.columns(8).visible(false);
				table.columns(10).visible(false);
				table.columns(12).visible(false);
				table.columns(17).visible(false);
				//phone and cnic
				table.columns(14).visible(true);
				table.columns(15).visible(true);
				table.columns(18).visible(true);
			}else{
				<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
					$('#trbody').remove();
					$('#trbody1').remove();
					var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" colspan="1" rowspan="2">S#</th><th class="text-center Heading" colspan="1" rowspan="2" >Name</th><th class="text-center Heading" rowspan="1" colspan="2" >Level</th><th class="text-center Heading" rowspan="1" colspan="2">Type</th><th class="text-center Heading" rowspan="1" colspan="2" >HF</th><th class="text-center Heading" rowspan="1" colspan="2" >UC</th><th class="text-center Heading" rowspan="1" colspan="2" >Tehsil</th><th class="text-center Heading" rowspan="1" colspan="2" >Status</th><th class="text-center Heading" colspan="1" rowspan="2">Update Status</th><th class="text-center Heading" colspan="1"  rowspan="2" style="width: 80px;"><a href="<?php echo base_url(); ?>Hr_management/hr_add" data-toggle="tooltip" title="Add New HR"><button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button></a></th></tr><tr role="row" id="trbody1" class="info"><th>From</th><th >To</th><th >From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th></tr>';
					$("#theadbody").append(markup);
				<?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
					$('#trbody').remove();
					$('#trbody1').remove(); 
					var markup = '<tr role="row" id="trbody" class="info"><th class="text-center Heading" colspan="1" rowspan="2">S#</th><th class="text-center Heading" rowspan="1" colspan="2" >District</th><th class="text-center Heading" colspan="1" rowspan="2" >Name</th><th class="text-center Heading" rowspan="1" colspan="2" >Level</th><th class="text-center Heading" rowspan="1" colspan="2">Type</th><th class="text-center Heading" rowspan="1" colspan="2" >HF</th><th class="text-center Heading" rowspan="1" colspan="2" >UC</th><th class="text-center Heading" rowspan="1" colspan="2" >Tehsil</th><th class="text-center Heading" rowspan="1" colspan="2" >Status</th><th class="text-center Heading" colspan="1"  rowspan="2" style="width: 80px;">Action</th></tr><tr role="row" id="trbody1" class="info"><th>From</th><th >To</th><th>From</th><th >To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th><th>From</th><th>To</th></tr>';
					$("#theadbody").append(markup);
				<?php } ?>
				<?php if (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
					table.columns(1).visible(true);
				 <?php } ?>
				table.columns(16).search(status).draw();
				var pre_level = $("#level").val();
				var pre_hrtype = $("#utype").val();
				var pre_distcode = $("#new_distcode").val();
				var pre_facode = $("#new_facode").val();
				var pre_uncode = $("#new_uncode").val();
				var pre_tehcode =$("#new_tehcode").val();
				if(pre_level!=0){
					table.columns(4).search(pre_level).draw();
					if(pre_facode!=0 ){ 
						table.columns(8).search(pre_facode).draw();
					}else if(pre_uncode!=0){ 
						table.columns(10).search(pre_uncode).draw();
					}else if(pre_tehcode!=0){ 
						table.columns(12).search(pre_tehcode).draw();
					}else if(pre_distcode!=0){ 
						table.columns(1).search(pre_distcode).draw();
					}
				} 
				if(pre_hrtype!=0){
					table.columns(6).search(pre_hrtype).draw();
				}
				table.columns(4).visible(true);
				table.columns(6).visible(true);
				table.columns(16).visible(true);
				table.columns(8).visible(true);
				table.columns(10).visible(true);
				table.columns(12).visible(true);
				table.columns(17).visible(true);
				//phone and cnic
				table.columns(18).visible(false);
				table.columns(14).visible(false);
				table.columns(15).visible(false);
			}
		}); 
	<?php if (($_SESSION['UserLevel']=='3') || ($_SESSION['UserLevel']=='4')){?>		
		$("#level option[value='2']").remove();
	<?php } ?>	 
	
	$(document).on('change','#level', function(e){
		$("#new_distcode").val('');
		$("#new_tehcode").val('');
		$("#new_uncode").val('');
		$("#new_facode").val('');
		/* table.columns(1).search('').draw();
		table.columns(2).search('').draw();
		table.columns(8).search('').draw();
		table.columns(9).search('').draw();
		table.columns(10).search('').draw();
		table.columns(11).search('').draw();
		table.columns(12).search('').draw();
		table.columns(13).search('').draw(); */ 
		var status = $("#status").val();
			if(status=='Active' || status=='Died' || status=='On Leave' || status=='Resigned' || status=='Retired' || status=='Terminated' || status=='Contract Expired' || status=='Shifted'){
				var selectedval = $(this).val();
				table.columns(5).search(selectedval).draw();
			}else{
				var selectedval = $(this).val();
				table.columns(4).search(selectedval).draw();
			}
		<?php if ($_SESSION['UserLevel']=='2'){?>	
			if(selectedval== 4 || selectedval== 5 || selectedval== 6 || selectedval== 7){			
				$('#showdistrict').show();
			}
		<?php } ?>		
		if(selectedval== 5){			
			$('#showtehsil').show();
		}
		if(selectedval== 6){
			$('#showtehsil').show();			
			$('#showuc').show();
		}
		if(selectedval== 7){	
			$('#showtehsil').show();			
			$('#showuc').show();		
			$('#showfacility').show();
		}
		if(selectedval== 0 || selectedval== 4){			
			$('#showtehsil').hide();
			$('#showuc').hide();
			$('#showfacility').hide();
		}
		if(selectedval== 0 || selectedval== 5){	
			$('#showuc').hide();
			$('#showfacility').hide();
		}
		if(selectedval== 0 || selectedval== 6){	
			$('#showfacility').hide();
		}
		if(selectedval== 0 || selectedval== 2){
			$('#showdistrict').hide();
			$('#showtehsil').hide();
			$('#showuc').hide();			
			$('#showfacility').hide();
		}
	});
	});
	/* function del_user(obj)
	{
		var myurl = '<?php echo base_url(); ?>Hr_management/hr_del/'+obj;		
		var is_confirm = confirm("Are you sure you want to delete?");
		if(is_confirm)
		{
			$.get(myurl, function (show) {
				window.location.replace("<?php echo base_url(); ?>Hr_management/hr_list");
			});
		}
	} */
	/* $('#new_distcode').on('change' , function(){
	 var dists=this.value;
		$.ajax({
			type: "POST",
			data: "distcode="+dists,
			url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
					success: function(result){
						$('#new_tehcode').html(result);
					}
		});
	});
	$('#new_tehcode').on('change' , function (){
	  var tehcode = this.value;
	  var uncode = "";
	  $.ajax({
		type: "POST",
		data: "tcode="+tehcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
		success: function(result){
		  $('#new_uncode').html(result);
		}
	  });
	});
	$('#new_uncode').on('change' , function (){
	  var uncode = this.value;
	  var facode = "";
	  $.ajax({
		type: "POST",
		data: "uncode="+uncode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
		success: function(result){
		  $('#new_facode').html(result);
		}
	  });
	}); */
	</script>