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
    			<div class="panel-heading">EPI-MIS | Donors Edit Form</div>
  	   		<div class="panel-body">
    	   		<form name="dataform" id="dataform" action="<?php echo base_url();?>cpanel/donors_management/Donors_management/donors_update" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<input type="hidden" value="<?php echo $epi_funding_source[0]["id"]; ?>" name="id" >
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Donors Name</label>
							   <div class="col-xs-3">
									<input  required name="name" id="name" placeholder="Donors Name"  class="form-control " value="<?php echo $epi_funding_source[0]["name"]; ?>"/>
							  	</div>
						   </div>
						<hr>
						<div class="row">
						   <div class="col-xs-7 cmargin22" >
								<button type="submit" id="AddUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update Donors </button>
								<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
								<a href="<?php echo base_url();?>Donors_management/donors_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body container-->