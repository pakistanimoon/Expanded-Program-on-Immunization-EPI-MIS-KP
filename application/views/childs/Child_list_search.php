<?php //print_r($data);exit; ?>

<style>
.sorting_1 {
    text-align: center;
}
.center {
    text-align: center;
}
div.dataTables_paginate {
    margin: 0;
    white-space: nowrap;
    text-align: right;
}
.listing-table a.edit {
    background: #1c841c; 
}
.listing-table a.view {
    background: #3453c5; 
}
.listing-table a.delete {
    background: #c51a1a; 
}
.listing-table table a {
    border: 1px solid #d6d6d6;
    width: 23px;
    text-align: center;
    color: #fff;
    padding: 2px;
    border-radius: 3px;
    cursor: pointer;
}
#cerv_child_registration{
	border: none;
}
</style>
<div class="content-wraper p-2 borderd-rounded">
	<div class="row m-0">
		<div class="col-lg-12">
			<div class="panel-heading"> List of Vaccinated Child </div>
			<br>
		<div class="row" style="width:100%; padding:4px 17px">
		
				<!---	<div class="form-group col-md-6">
						 <label class="col-xs-1 control-label lbl-setting" for="search">Child Name:</label>
						 <div class="col-xs-11">
							<input id="child_name" name="searchParam" class="form-control" type="text" placeholder="Search"/>
						 </div>
					</div>
						 
					<div class="form-group col-md-6">
						 <label class="col-xs-1 control-label lbl-setting" for="search">Father Name:</label>
						 <div class="col-xs-11">
							<input id="father_name" name="searchParam" class="form-control" type="text" placeholder="Search"/>
						 </div>
					</div>
					----->
					
						 
					<!---- Srat code -------->
					
							<div class="col-md-2 col-md-offset-1">
								<label>Child Name:</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Child Name" name="child_name" id="child_name">
								
							</div>
							
							<div class="col-md-2 col-md-offset-1">
								<label>Father Name</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Father Name" name="father_name" id="father_name">
								
							</div>		
					
							<div class="col-md-2 col-md-offset-1">
								<label>Child Card Number</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Child Card Number" name="childcardnbr" id="childcardnbr">
								
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Child Name</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Child Name" name="childname" id="childname">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Father Name</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Father Name" name="fathername" id="fathername">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Date Of Birth</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status"placeholder="yyyy-mm-dd" class="month_year form-control " type="text" value="" data-date-format="yyy-mm-dd" name="dateofbirth" id="dateofbirth">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Mobile Number</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Mobile Number" name="mobilenbr" id="mobilenbr">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>CNIC</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "CNIC Number" name="cnicnbr" id="cnicnbr">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Gender</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Gender" name="gender" id="gender">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Child Address</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Child Address" name="childaddress" id="childaddress">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Un-Synced Records</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Un-Synced Records"  name="syncedrecords" id="syncedrecords">
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Due Vaccine</label>
							</div>
							<div class="col-md-3">
								<input class="form-control filter-status" placeholder = "Due Vaccine"  name="duevaccine" id="duevaccine">
							</div> 
							
						
						
						<!---- End code --->
			<!---<form method="post" id="filter-form">--->
					
						<!---	<div class="col-md-2 col-md-offset-1">
								<label>Tehsil:</label>
							</div>
							<div class="col-md-3">
								
								<select class="form-control filter-status" name="tcode" id="tcode">
									<php echo getTehsils_options(false,NULL,$this->session->District); ?>
								</select>
							</div>
							<div class="col-md-2 col-md-offset-1">
								<label>Union Council:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control filter-status" name="uncode" id="uncode">
								<>
								</select>
							</div>
							
						<div class="row" style="width:100%; padding:4px 17px">					
							<div class="col-md-2 col-md-offset-1">
								<label>Village/Mohallah:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control filter-status" name="village" id="village">
									
								</select>
							</div>				
						</div> ---->
					</div>
				</div>
					
						<!---------------------- End ------------>
			
			<!---	</form>	--->
			
				<div class="row" style="margin-top:5px;">   
					<div class="form-group">
						<div class="col-xs-5" style="margin-left: 72% !important;">
							<a href="<?php echo base_url(); ?>childs/Reports_list/child_migrate">
								<button class="submit btn-success btn-sm"><i class="fa fa-share"></i> Child Migrate In</button>
							</a>
						</div>
					</div>
				</div>
				
		<div class="col-lg-12 listing-table">
			<?php
			if($this -> session -> msg){ ?>
				<div class="error_prefix"><?php echo $this -> session -> msg; ?></div>
			<?php } ?>
			<table id="cerv_child_registration" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
				<thead>
					<tr>
						<th class="text-center Heading">S#</th>                
						<th class="text-center Heading">Card NO</th>
						<th class="text-center Heading">Child Name</th>  
						<th class="text-center Heading">Date of Birth</th>
						<th class="text-center Heading">Father Name</th>   
						<th class="text-center Heading">Tehsil</th>
						<th class="text-center Heading">UC</th>
						<th class="text-center Heading">Address</th>
						<th class="text-center Heading">
						<a href="<?php echo base_url();?>childs/Reports_list/child_add" data-toggle="tooltip" title="Add Child Registeration ">
							<button class="submit btn-success btn-sm">
							<i class="fa fa-plus"></i> Add New</button>
						
						
			  </th>
					</tr>
				</thead>
				<tbody id="tbody">
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
 	
	$('#child_name').on('change', function () {
		var childname = this.value;
		//alert(childname);
		// var dateofbirth = $("#dateofbirth").val();
		//var year = dateofbirth.split("-", 1);
		// var cardno = $("#cardno").val();
		// var reg_no = newfacode + '-' + year + '-' + cardno;
		//  var newtechniciancode = "";
			$.ajax({
			type: "POST",
			data: "nameofchild=" + childname,
			//url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
			url: "<?php echo base_url(); ?>childs/Reports_list/child_search",
				success: function (result) {
				console.log(result);
				$('#techniciancode').html(result);
				}
			});
	});
	
		
		
		
</script>