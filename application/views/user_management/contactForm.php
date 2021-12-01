<!--start of page content or body-->
 <div class="container bodycontainer">
  <div class="row">
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Please update your contact information
        </div>
		<p style="color: #000cff; margin-left: 449px;"><?php if($this -> session -> message){ echo $this -> session -> message;} ?></p>
         <div class="panel-body">
    <form id="dataform" action="<?php echo base_url(); ?>user_management/usersContact" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
	<div class="form-group">
	  <div class="row">
		  <label class="col-xs-2 col-xs-offset-1 control-label" >Name</label>
			<div class="col-xs-3">
			  <input type="text"  class="form-control" name="name" value="<?php echo (isset($data))?$data['name']:''; ?>" />
			</div>
			<label class="col-xs-2 control-label" > Cell Number</label>
			<div class="col-xs-3">
			  <input type="text"  class="form-control" name="cell_no" value="<?php echo (isset($data))?$data['cell_no']:''; ?>" />
			</div>
		  </div>
		  </div>
		  <div class="form-group">
		  <div class="row">
		  <label class="col-xs-2 col-xs-offset-1 control-label" >Designation</label>
			<div class="col-xs-3">
			  <input type="text"  class="form-control" name="designation" value="<?php echo (isset($data))?$data['designation']:''; ?>" />
			</div>
			<label class="col-xs-2 control-label" >Department</label>
			<div class="col-xs-3">
			  <input type="text"  class="form-control" name="department" value="<?php echo (isset($data))?$data['department']:''; ?>" />
			</div>
		  </div>
		  </div>
	  <div class="form-group">
	  <div class="row">
		  <label class="col-xs-2 col-xs-offset-1 control-label" >Email</label>
			<div class="col-xs-3">
			  <input type="text"  class="form-control" name="email" value="<?php echo (isset($data))?$data['email']:''; ?>" />
			</div>
		  </div>
	  </div>
   </div>
 <hr>
	<input type="hidden" name="edit" value="edit" />
	<div class="row">
		 <div class="col-xs-7" style="margin-left:53.5%;" >
			<button type="submit" id="myCoolForm" name="myCoolForm" value="0" class="btn btn-md btn-success bc1" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Update </button>
			<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
			<a href="<?php echo base_url();?>Home" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
		</div>
	</div>
	</form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->