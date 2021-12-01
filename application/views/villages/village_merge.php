<?php 
//beta
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<div class="container bodycontainer">
	<div class="row">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	  <div class="panel panel-primary">
	    <ol class="breadcrumb">
	    	<ul class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
				<li class="active"></li>
			</ul> 
	    </ol> 
    	<div class="panel-heading">Village Merge</div>
  	  	<div class="panel-body">
    	   <form name="dataform" id="dataform" action="" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<div class="row">
	    		   <div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label" >Tehsil:</label>
						<div class="col-xs-3">
							<select class="form-control" name="tcode" id="tcode" required="required">
								<option value="">--Select-- </option>
								<?php echo getTehsils($distcode); ?>
							</select>							
						</div>
						<label class="col-xs-2 control-label">Union Council:</label>
						<div class="col-xs-3">
							<select name="uncode" id="uncode" required="required" class="form-control">
								<option></option>
							</select>
						</div>	
				   </div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label">Year:</label>
						<div class="col-xs-3">
							<select class="form-control" name="year" id="year" required="required">
								<?php echo getAllYearsOptionsIncludingNext(); ?>
							</select>
						</div>
						<div class="col-md-3" style="margin-left: 190px;">
							<button id="myBtn"  title="Please do the basic selection first. Select Tehsil, Unioncouncil, Facility, Technician and year!" style="background: #008d4c;" type="button" class="btn btn-md btn-primary"> Merge Villages for Microplan</button>
						</div>
					</div>	
				</div>		
				<div class="row">
					<div class="col-xs-7" style="margin-left:67%;" >
						<a href="<?php echo base_url();?>Village-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
				</div>
			</form>			
  		</div> <!--end of panel body-->
 	</div> <!--end of panel panel-primary-->
</div><!--end of row-->	
</div><!--End of page content or body contaier-->
<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Villages Merger</h4>
			</div>
			<div class="modal-body">
				<div id="mergermodalbody"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script  type="text/javascript">
///////////////for merger village modula//////////////////
	var modal = document.getElementById('myModal');
	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");
	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		$('#myModal1').modal('show');
		var uncode = $('#uncode').val();
		var year = $('#year').val();
		$.ajax({
			type: "POST",
			data: {uncode:uncode,year:year},
			url: "<?php echo base_url(); ?>Ajax_red_rec/getUcVillages",
			success: function(result){
				$('#mergermodalbody').html('');
				$('#mergermodalbody').html(result);
			}
		});
	}
</script>