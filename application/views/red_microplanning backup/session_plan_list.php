	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<ol class="breadcrumb">
		 			<ul class="breadcrumb">
		 				<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
						<li class="active"></li>
					</ul>
				</ol> 
				<div class="panel-heading" style="font-size:17px; border-color:white !important;">Session Plan Template List</div>
				<?php if($this -> session -> flashdata('message')){  ?>
					<div class="row mb3">
						<div class="col-sm-12 filters-selection" style="Background-color:#32CD32;">
							<div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
						</div>
					</div>
				<?php } ?>
				<div class="panel-body">
					<form method="post" id="filter-form">
						<div class="row" style="width:100%; padding:4px 17px">
							<div class="col-md-2 col-md-offset-1">
								<label>Tehsil:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct tcode, tehsilname(tcode) as tehsil from session_plan_db where distcode='{$distcode}' order by tehsil ASC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="tcode" id="ticode">
									<option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['tcode']; ?>"><?php echo $value['tehsil']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>Health Facility:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct facode, facilityname(facode) as facility from session_plan_db where distcode='{$distcode}' order by facility ASC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="facode" id="facode">
									<option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['facode']; ?>"><?php echo $value['facility']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row" style="width:100%; padding:4px 17px">					
							<div class="col-md-2 col-md-offset-1">
								<label>Area Name:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct area_name from session_plan_db where distcode='{$distcode}' order by area_name ASC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="area_name" id="area_name">
									<option value=""></option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['area_name']; ?>"><?php echo $value['area_name']; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>Year:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct year from session_plan_db where distcode='{$distcode}' order by year DESC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="year" id="year">
									<option value=""></option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['year']; ?>"><?php echo $value['year']; ?></option>
								<?php } ?>
								</select>
							</div>				
						</div>
					</form>
					<table class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Area Name</th>						
								<th>Total Population</th>
								<th>Target Population</th>
								<th>Session Type</th>
								<th>Hard to Reach</th>
								<th>Hard to Reach Population</th>
								<th>Year</th>
								<th>Tehsil</th>
								<th>Facility Name</th>
								<th class="text-center Heading">
									<a href="<?php echo base_url(); ?>red_microplan/Session_plan/session_plan_add" data-toggle="tooltip" title="Add New Supervisor">
									<button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button>
									</a>
								</th>
							</tr>
						</thead>
						<tbody id="tbody"> 
							<?php
								$i=0;
								foreach($data as $row){
								$i++;
							?>
							<tr>
								<td class="text-center"><?php echo $i; ?></td>
								<td><?php echo $row['area_name']; ?></td>
						      <td class="text-center"><?php echo $row['total_population']; ?></td>
						      <td class="text-center"><?php echo $row['target_population']; ?></td>
						      <td class="text-left"><?php echo $row['session_type']; ?></td>
						      <td class="text-center"><?php echo $row['hard_to_reach']; ?></td>
						      <td class="text-center"><?php echo $row['hard_to_reach_population']; ?></td>
						      <td class="text-center"><?php echo $row['year']; ?></td>
						      <td><?php echo $row['tehsil']; ?></td>
						      <td><?php echo $row['facility']; ?></td>
						      <td class="text-center">
							      <a href="<?php echo base_url(); ?>red_microplan/Session_plan/session_plan_view/<?php echo $row['facode']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
							      <a href="<?php echo base_url(); ?>red_microplan/Session_plan/session_plan_edit/<?php echo $row['facode']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
						      </td>
					 		</tr>
							<?php } ?>
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
		$('.filter-status').on('change' , function (){
			$('#tbody').html('');
			$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
			var page = $(this).attr("id"); //get page number from link
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				dataType: "json",					
				url: "<?php echo base_url(); ?>Ajax_red_rec/session_plan_filter",
				success: function(result){
					console.log(result);
					$('#tbody').html('');
					if(result != null){
						$("#filter").val('');
						$('#tbody').html(result.tbody);
						$('#paging').html(result.paging);
					}
				}
			});
		}); 
		//------------------------------------------------------------------------//			
	</script>