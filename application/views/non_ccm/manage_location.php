<!-- Main content -->
<?php if($this -> session -> flashdata('message')){  ?>
		<div class="row mb3">
			<div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
				<div class="text-center pt5 pb5" role="alert" style="color:white;">
					<strong><?php echo $this -> session -> flashdata('message'); ?></strong>
				</div> 
			</div>
		</div>
<?php } ?>
<section class="content">
	<!--start of page content or body-->
	<div class="container bodycontainer">
		<div class="border-div">
			<div class="row main-row">
				<div class="col-md-12">
					<h4>Manage Dry Store Location Bins<span><i class="fa fa-angle-down"></i></span></h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form  class="form-horizontal" method="post" action="<?php echo base_url();?>NonCCMLocations/save_location">
						<?php if($this -> session -> District){ ?>
							<input type="hidden" name="warehouse_type" value="4" >
							<input type="hidden" name="distcode" value="<?php echo $this -> session -> District; ?>" >
						<?php }else{ ?>
							<input type="hidden" name="warehouse_type" value="2" >
							<input type="hidden" name="distcode" value="" >
						<?php }	?>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Store <span>*</span></label>
									<select name="nonccm_stores" id="nonccm_stores" required="required" class="form-control">
										<?php echo getAllStores(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Row <span>*</span></label>
									<select name="nonccm_rows" id="nonccm_rows" required="required" class="form-control">
										<?php echo getAllRows(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Rack <span>*</span></label>
									<select name="nonccm_racks" id="nonccm_racks" required="required" class="form-control">
										<?php echo getAllRacks(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Shelf <span>*</span></label>
									<select name="nonccm_shelfs" id="nonccm_shelfs" required="required" class="form-control">
										<?php echo getAllShelfs(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Bin <span>*</span></label>
									<select name="nonccm_bins" id="nonccm_bins" required="required" class="form-control">
										<?php echo getAllBins(); ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<button>Add</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="border-div">
			<div class="row main-row">
				<div class="col-md-12">
					<h4>Dry Store Locations<span><i class="fa fa-angle-down"></i></span></h4>
				</div>
			</div>
			<div class="row form-row">
			</div>
			<table id="datatable-tbl" class="table table-striped table-location-bins">
				<thead>
					<tr>
						<th>S.No</th>
						<th style="width:80%;">Location(Bin)Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($allLocations as $key => $val){ ?>
					<tr>
						<td><?php echo $key+1; ?></td>
						<td><?php echo $val['location_name']; ?></td>
						<td><a onclick="return confirm('Do you Really want to delete this?');" href="<?php echo base_url(); ?>NonCCMLocations/delete_location/<?php echo $val['pk_id']; ?>"><i class="fa fa-times red-text"></i></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div><!--End of page content or body-->
</section>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#datatable-tbl').DataTable();
	});
</script>