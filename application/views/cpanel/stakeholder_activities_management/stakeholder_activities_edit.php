<?php $utype=$_SESSION['utype']; 
//print_r($pack_size_results); exit();?>
<?php //print_r($userInfo); exit(); ?>
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
  			<div class="panel panel-primary">
    			<ol class="breadcrumb">
          		<?php  echo $this->breadcrumbs->show();?>
       		</ol>
    			<div class="panel-heading">EPI-MIS | Activity Edit Form</div>
  	   		<div class="panel-body">
    	   		<form name="dataform" id="dataform" action="<?php echo base_url();?>cpanel/stakeholder_activities_management/Stakeholder_activities_management/stakeholder_activities_update" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<input type="hidden" value="<?php echo $epi_stakeholder_activities[0]["pk_id"]; ?>" name="pk_id" >
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Activity Name</label>
							   <div class="col-xs-3">
									<input  required name="activity" id="name" placeholder="Activity Name"  class="form-control " value="<?php echo $epi_stakeholder_activities[0]["activity"]; ?>"/>
							  	</div>
								<label class="col-xs-2 control-label" for = "uname" >Status</label>
								<div class="col-xs-3">
									<input type="radio" name="status" value= '1' <?php echo ($epi_stakeholder_activities[0]["status"]== '1') ?  "checked" : "" ;  ?>>YES
									<input type="radio" name="status" value= '0' <?php echo ($epi_stakeholder_activities[0]["status"]== '0') ?  "checked" : "" ;  ?>> NO
							  	</div>
						   </div>
						<hr>
						<div class="row">
						   <div class="col-xs-7 cmargin22" >
								<button type="submit" id="AddUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update Activity </button>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url();?>Stakeholder_activities_management/stakeholder_activities_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body container-->