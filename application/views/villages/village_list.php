	<style>
		#village_table_wrapper{
			
			margin-top: -40px;
		}
	</style>
	<div class="container">
		<div class="row">
			<!--<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>-->
			<div class="panel panel-primary">
				<ol class="breadcrumb">
		 			<ul class="breadcrumb">
		 				<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
						<li class="active"></li>
					</ul>
				</ol> 
				<div class="panel-heading" style="font-size:17px; border-color:white !important;">Villages/Mohalla </div>
				<?php if($this -> session -> flashdata('message')){  ?>
					<div class="row mb3">
						<div class="col-sm-12 filters-selection" style="Background-color:#32CD32;">
							<div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
						</div>
					</div>
				<?php } ?>
				<div class="panel-body">
					<form method="post" id="filter-form">
						<div class="row" style="width:100%; padding:10px 17px">
							<div class="col-md-2 col-md-offset-1">
								<label>Tehsil:</label>
							</div>
							<div class="col-md-3">
								
								<select class="form-control filter-status" name="tcode" id="tcode">
									<option value="">-- Select --</option>
								    <?php
                                        foreach($resultTehsil as $row){
                                    ?>
										<option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
                                    <?php }?>
								</select>
							</div>
							<div class="col-md-2 ">
								<label>Union Council:</label>
							</div>
							<div class="col-md-3">
								
								<select class="form-control filter-status" name="uncode" id="uncode">
									<option value="">-- Select --</option>
								    <?php
                                        foreach($resultUnC as $row){
                                    ?>
										<option value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name']; ?></option>
                                    <?php }?>
								</select>
							</div>
						</div>
						<div class="row" style="width:100%; padding:10px 17px">
							<div class="col-md-2 col-md-offset-1">
								<label class="col-md-2 col-md-offset-1 lbl-setting" style="margin-left: -15px;">Search:</label>
							</div>
							<div class="col-md-3">              
								<input id="cnicSearch" name="cnicSearch" placeholder="UcName,Tehsil" class="form-control filter-status" type="text">           
							</div>
						</div>
						<div class="row" style="margin-left: 925px;">
							<button class="submit btn-success btn-sm"  style="position: relative; z-index: 999;"><a style="color: white;"  href="<?php echo base_url(); ?>Villages/merge_villages" title="Merge Villages">Merge Villages</a></button>
						</div>
					</form>
				</div>	
					<table id="village_table" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Tehsil</th>						
								<th>Union Council</th>
								<th>No.of Villages Attach</th>
								<th class="text-center Heading">
									<a href="<?php echo base_url(); ?>Add-village" data-toggle="tooltip" title="Add New Village">
									<button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button>
									</a>
								</th>
							</tr>
						</thead>
						<tbody id="tbody"></tbody>
					</table>	
					<br>
				
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
		//=========================
		$(document).ready(function() {
			//alert('xxx');
			var page=0;
			var distcode=0;
			var columns = [
			{ 
				data: "serial",
				orderable: false,
			},
			{ data: "tehsilname" },
			{ data: "unname" },
			{ data: "villages_counts" },
			{ data: "uncode" ,
				orderable: false,
				render : function(data, type, row) {
					
				//if(row['checkresult']==1){
					return '<a data-original-title="View" href="<?php echo base_url(); ?>View-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>Edit-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a data-original-title="Delete" href="<?php echo base_url(); ?>Delete-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>'
				//}else{
				 	//return '<a data-original-title="View" href="<?php echo base_url(); ?>View-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>Edit-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a data-original-title="Delete" href="<?php echo base_url(); ?>Delete-village/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>'
				
				//}
				}
					
			}];
			var table = $('#village_table').DataTable({
				"pageLength" : 15,
				"serverSide": true,
				"order": [
				  [1, "desc" ]
				],
				"ajax": {
					url : "<?php echo base_url(); ?>Villages/village_table",
					type : 'GET'
				},
				"columns": columns,
				dom: 'lrtips'
			});
			//alert('xxx');
			$('#uncode').on('change', function () {
				table.columns(2).search( this.value ).draw();
			});
			$('#vcode').on('change', function () {
				table.columns(5).search( this.value ).draw();
			});
			 $('#cnicSearch').on('keyup change', function () {
   			 table.search( this.value ).draw();
 		 });
		});			
	</script>