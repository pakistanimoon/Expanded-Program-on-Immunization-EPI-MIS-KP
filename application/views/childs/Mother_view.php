<!--start of page content or body-->

<?php 
//print_r($motherdData);exit;
if($this -> session -> flashdata('message')){  ?>
			  <div class="row mb3">
				<div class="col-sm-12 filters-selection" style="Background-color:#00F418;">
				  <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
				</div>
			  </div>
<?php } ?>
 <div class="container bodycontainer">
  <div class="row">
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> View Mother Registeration Form
        </div>
         <div class="panel-body">
     <!-- <form  action="<?php echo base_url();?>Reports_list/child_save" method="post" class="form-horizontal form-bordered" >-->
      <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url();?>Reports/MotherRegistrationSave">    
		
	<div class="form-group">
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">EPI Center Info</div>
			<br>
			<div class="row">
		       <div class="showProvnice" id="showProvnice">
                 <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                 <div class="col-xs-3">
							<?php echo $data['province']; ?>
				</div>
				<label class="col-xs-2  control-label" for = "showDistrict" >  District</label>
				<div class="col-xs-3">
							<?php echo $data['district']; ?>
				</div>
				</div>
			</div>
			<div class="row">
		            <div class="showDistrict" id="showDistrict"></div>
			        <div class="showTehsil" id="showTehsil">
						<label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<?php echo $data['tehsil']; ?>
						</div>
						<label class="col-xs-2  control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
							<?php echo $data['uc']; ?>
						</div>
					</div>
			</div>		
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
							<?php echo $data['facility']; ?>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
							<?php echo $data['technician']; ?>
					</div>
				</div>
			</div> 
			<br>
		
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Mother Basic info</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "age" >Age(in Year) </label>
                <div class="col-xs-3">
							<?php echo $data['mother_age']; ?>
				</div>
				<label class="col-xs-2 control-label"  for = "CardNO" > Card No: </label>
                <div class="col-xs-3">
							<?php echo $data['cardno']; ?>
				</div>
                
			</div>
			<div class="row">
                <label class="col-xs-2 col-xs-offset-1 control-label"  for = "name" >Mother Name</label>
				<div class="col-xs-3">
							<?php echo $data['mother_name']; ?>
				</div>
				<label class="col-xs-2 control-label"  for = "husband_name" > Husband Name</label>
                <div class="col-xs-3">
							<?php echo $data['husband_name']; ?>
				</div>
				
			</div>
			<div class="row">
				
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "cnic" >Mother CNIC</label>
                <div class="col-xs-3">
							<?php echo $data['mother_cnic']; ?>
				</div>
				<label class="col-xs-2 control-label"  for = "Contact" >Enter Contact Number</label>
				<div class="col-xs-3">
							<?php echo $data['contactno']; ?>
				</div>
			</div>

	<div class="form-group">
			
			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Current Address</div>
			<br>
			<div class="row">
				<div class="showProvnice" id="showProvnice">
                    <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                    <div class="col-xs-3">
							<?php echo $data['province']; ?>
					</div>
				</div>
				<div class="showDistrict" id="showDistrict">
                    <label class="col-xs-2   control-label" for = "showDistrict" >  District</label>
					<div class="col-xs-3">
							<?php echo $data['district']; ?>
					</div>
				</div>
			</div>
			<div class="row">
					<div class="showTehsil" id="showTehsil">
                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<?php echo $data['tehsil']; ?>
					</div>
					<div class="showUnc" id="showUnc">
                      <label class="col-xs-2 control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
							<?php echo $data['uc']; ?>
						</div>
					</div>
			</div>	
			</div>
			<div class="row">
                      <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Address</label>
						<div class="col-xs-3">
							<?php echo $data['village']; ?>
					</div>
                      <label class="col-xs-2 control-label"  for = "showUnc" >  House/Street</label>
						<div class="col-xs-3">
							<?php echo $data['house']; ?>
						</div>
			</div>
			</div>
			<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Vaccine list</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT1 </label>
                <div class="col-xs-3">
							<?php echo $data['tt1']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT2 </label>
                <div class="col-xs-3">
							<?php echo $data['tt2']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT3</label>
                <div class="col-xs-3">
							<?php echo $data['tt3']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT4 </label>
                <div class="col-xs-3">
							<?php echo $data['tt4']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >TT5 </label>
                <div class="col-xs-3">
							<?php echo $data['tt5']; ?>
				</div>
			</div>
				
			</div>
				<br>
				<div class="row">
                    <div class="col-xs-7" style="margin-left:53.5%;">
                        <a href="<?php echo base_url();?>Reports/motherRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Back </a>
					</div>
                </div>
		
    </div>
    </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->