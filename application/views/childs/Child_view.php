<!--start of page content or body-->

<?php //print_r($data); exit; ?>
<!--<?php //print_r($data['data']);?>-->
 <div class="container bodycontainer">
  <div class="row"> 
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update Child Registeration Form
        </div>
         <div class="panel-body">
      <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url();?>Reports/ChildRegistrationSave">        
		<input type="hidden" name="recno" id="recno"  value="<?php echo $data['recno']; ?>"  class="form-control "/>         
		<div class="form-group">
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">EPI Center Info</div>
			<br>
			<div class="row">
		       <div class="showProvnice" id="showProvnice">
                 <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                 
                 <div class="col-xs-3">
							<?php echo $data['procode']; ?>
				</div>
				<label class="col-xs-2  control-label" for = "showDistrict" >  District</label>
				<div class="col-xs-3">
					<?php echo get_District_Name($data['distcode']); ?>
				</div>
				</div>
			</div>
			<div class="row">
		            <div class="showDistrict" id="showDistrict"></div>
			        <div class="showTehsil" id="showTehsil">
						<label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<?php echo get_Tehsil_Name($data['tcode']); ?>
						</div>
						<label class="col-xs-2  control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
								<?php echo get_UC_Name($data['uncode']); ?> 
						</div>
					</div>
			</div>		
			
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
							<?php echo get_Facility_Name($data['reg_facode']); ?>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
						    <?php echo get_Hr_Name($data['techniciancode'],'01'); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" >Address</label>
				<div class="col-xs-3">
						<?php echo get_Village_Name($data['villagemohallah']); ?>
				</div>
			</div>
		</div>
	<br>
	
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Child Basic info</div>
			<br>
			<div class="row">
			    
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "CardNO" > Card No: </label>
                <div class="col-xs-3">
					<?php echo $data['cardno']; ?>
				</div>
				
				<label class="col-xs-2 control-label"  for = "CardNO" >Date of Birth </label>
                <div class="col-xs-3">
					<?php echo $data['dateofbirth'];?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "name" >Name</label>
                <div class="col-xs-3">
                    <?php echo $data['nameofchild']; ?>
				</div>
				<label class="col-xs-2  control-label"  for = "Gender" >Gender</label>
				<div class="col-xs-3">
                    <?php echo $data['gender']; ?>
				</div>
			</div>
			
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Father Name</label>
				<div class="col-xs-3">
                <?php echo $data['fathername'];?>
				</div>
				<label class="col-xs-2 control-label"  for = "cnic" >Father CNIC</label>
                <div class="col-xs-3">
					<?php echo $data['fathercnic'] ?>
				</div>
		   </div>
		    <div class="row">
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "mothername" >Mother name</label>
                <div class="col-xs-3">
                    <?php echo $data['mothername']; ?> 
				</div>
				<label class="col-xs-2  control-label"  for = "mothernic" >Mother Cnic</label>
                <div class="col-xs-3">
                    <?php echo $data['mothercnic']; ?>
				</div>
		   </div>
		   <div class="row">
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "Contact" >Enter Contact Number</label>
                <div class="col-xs-3">
                    <?php echo $data['contactno']; ?>
				</div>
		   </div>
		   <br>
			
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Doses Administered</div>
			<br>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >BCG </label>
                <div class="col-xs-3">
					<?php echo $data['bcg']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-0 </label>
                <div class="col-xs-3">
					<?php echo $data['opv0']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >HEP-B </label>
                <div class="col-xs-3">
					<?php echo $data['hepb']; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Penta-1 </label>
                <div class="col-xs-3">
					<?php echo $data['penta1']; ?>
				</div>
			</div>
			<div class="row"> 
				<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-1 </label>
				<div class="col-xs-3"> 
					<?php echo $data['rota1']; ?>
				</div>
				<label class="col-xs-2 control-label" for="">Is Child Dead </label>
				<div class="col-xs-1">
					<?php echo $data['dateofdeath']; ?>
				</div>
				<label class="col-xs-2  control-label" for="cnic">Is Refusal </label>
				<div class="col-xs-1"> 
					<?php echo $data['dateofrefusal']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-1 </label>
				<div class="col-xs-3">
					<?php $data['opv1']; ?>
					</div>
					<div id="deathrow" style="display: none;">
					 <label class="col-xs-2  control-label" for="cnic">Date of death </label>
						<?php echo $data['dateofdeath']; ?>
					</div>
					</div>
			<div class="row">
					<div id="refusalrow" style="display: none;">
						<?php echo $data['dateofrefusal']; ?>
						</div>
					</div>
			<div class="row">
				<?php echo $data['pcv1']; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Penta-2 </label>
                <div class="col-xs-3">
					<?php echo $data['penta2']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Rota-2 </label>
                <div class="col-xs-3">
					<?php echo $data['rota2']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-2 </label>
                <div class="col-xs-3">
					<?php echo $data['opv2'];?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-2 </label>
                <div class="col-xs-3">
					<?php echo $data['pcv2']; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >penta-3 </label>
                <div class="col-xs-3">
					<?php echo $data['penta3']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-3 </label>
                <div class="col-xs-3">
					<?php echo $data['opv3']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-3 </label>
                <div class="col-xs-3">
					<?php echo $data['pcv3']; ?>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >IPV</label>
                <div class="col-xs-3">
					<?php echo $data['ipv']; ?>
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-1</label>
                <div class="col-xs-3">
					<?php echo $data['measles1'];?>
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-2</label>
                <div class="col-xs-3">
					<?php echo $data['measles2']; ?>
				</div>
			</div>
				<br>
			<br>
			<div class="row">
				<div class="col-xs-7" style="margin-left:53.5%;">

				<a href="<?php echo base_url();?>Reports/ChildRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Back </a>
				</div>
			</div>
		</div>
	</div>
</form>