	<!--start of page content or body-->
	<?php 
		date_default_timezone_set('Asia/Karachi');
		$current_date = date('d-m-Y');
	?>
	<div class="container bodycontainer">  
		<div class="row">
			<!-- <?php if($this-> session-> flashdata('message')) { ?>
				<div class="alert alert-success text-center" role="alert">
					<strong><?php echo $this-> session-> flashdata('message'); ?></strong>
				</div>
			<?php } ?> -->
			<div class="panel panel-primary">
				<div class="panel-heading"> Please give us your valuable feedback</div>
				<div class="panel-body">
					<form id="dataform" action="<?php echo base_url(); ?>Feedback/sendFeedback" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
						<div class="form-group">
							<div class="row">
								<label class="col-xs-3 col-xs-offset-1 control-label">Do you have any difficulty in data entry?</label>
								<div class="col-xs-3">
									<label class="radio-inline"><input value="Yes" name="have_any_difficulty" type="radio">Yes</label>
									<label class="radio-inline"><input value="No" name="have_any_difficulty" checked="checked" type="radio">No</label>
								</div>
								<label class="col-xs-2 control-label">Do you use any report?</label>
								<div class="col-xs-3">
									<label class="radio-inline"><input value="Yes" name="use_any_report" type="radio">Yes</label>
									<label class="radio-inline"><input value="No" name="use_any_report" checked="checked" type="radio">No</label>
								</div>
							</div>
						</div>
						<br>
						<div class="form-group">
							<div class="row">
								<label class="col-xs-3 col-xs-offset-1 control-label">Any Comment / Improvements / Problems </label>
								<div class="col-xs-5">
									<textarea type="text" name="comments" class="form-control" value="" rows="5" cols="50" required></textarea>
								</div>
							</div>
						</div>
						<hr>
						<!-- <input type="hidden" name="edit" value="edit"/> -->
						<div class="row">
							<div class="col-xs-7" style="margin-left:60.5%;" >
								<button type="submit" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-paper-plane"></i> Send </button>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url(); ?>" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->