<style>
	.bg1-row{
		background:#e1eae6;
	}
	.m-0{
		margin:0px !important;
	}
	.p-0{
		padding:0px !important;
	}
	.p-1{
		padding:5PX !important;
	}
	input[type="date"]{
	line-height: 1.42857143;	 
	}
	.custom-border-status{
	border: 1px solid
	#e1e1e1;
	border-radius: 3px;
	padding: 10px;
	box-shadow: 0px 0px 4px 0px	#eae8e8;
	}
	.cst-table-status thead th{
		background: transparent linear-gradient(to bottom, #79D4F8 0%, #5089FF 51%, #5551ED 100%) repeat scroll 0% 0%;
		color: #fff;
	}
	.cst-table-status thead th, .cst-table-status tbody td{
		padding:3px;
	}
	.cst-close{
		padding: 7px 10px;
		border-radius: 2px;
		cursor: pointer;
	}
	.cst-pencil{
		border: 2px dotted #5277f9;
		padding: 1px 5px;
		font-size: 17px;
		color:#5277f9;
		border-radius: 2px;
		cursor: pointer;
		transition: all 0.3s;
	}
	.cst-pencil:hover{
		border-color:transparent;
		background:#5277f9;
		color:#fff;
	}
</style>
<?php
//print_r($districts); //exit(); 
$utype=$_SESSION['utype']; 
$status_typee=$hrdata1[0]['post_status'];
$pre_typee=$hrdata1[0]['pre_status'];
?>
<html lang="en">
<body>
    <div>
        <!--BEGIN TOPBAR-->
        <!--END TOPBAR-->
        <div id="wrapper">
            <!--BEGIN SIDEBAR MENU-->
  
            <!--END SIDEBAR MENU-->
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
				<!--BEGIN TITLE & BREADCRUMB PAGE-->
                 <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull">
                        <div class="page-heading" style="background-color: #008D4C;color: #FFF; text-align: center;font-size: 25px;">EPI-MIS | Update HR Status Form</div>
                    </div>                   
                    <div class="clearfix">
                    </div>
                </div>
                <!--END TITLE & BREADCRUMB PAGE-->


                <!--BEGIN CONTENT-->
<div class="page-content container-fluid">					 
					
	<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Hr_management/hr_status_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" >
		<input type="hidden" name="code" value="<?php echo $hrdata[0]['code'];?>" />
		<input type="hidden" name="id" id="id" value="<?php echo $hrdata[0]['id']; ?>" >
		<input type="hidden" name="pre_level" id="level" value="<?php echo $hrdata[0]['level']; ?>" >
		<input type="hidden" name="procode" id="hidden_procode" value="<?php echo $hrdata[0]['procode']; ?>" >
		<input type="hidden" name="distcode" id="hidden_distcode" value="<?php echo $hrdata[0]['distcode']; ?>" >
		<input type="hidden" name="tcode" id="hidden_tcode" value="<?php echo $hrdata[0]['tcode']; ?>" >
		<input type="hidden" name="uncode" id="hidden_uncode" value="<?php echo $hrdata[0]['uncode']; ?>" > 
		<input type="hidden" name="facode" id="hidden_facode" value="<?php echo $hrdata[0]['facode']; ?>" >
		<input type="hidden" name="type" id="type" value="<?php echo $hrdata[0]['hr_type_id']; ?>" >
		<input type="hidden" name="sub_type" id="sub_type" value="<?php echo $hrdata[0]['hr_sub_type_id']; ?>" >
			<div class="row">
				<div class="col-xs-12">
					<div class="block">
						<div class="block-title"></div>
	 					<div class="form-group">
							<div class="row view-row bg1-row p-1 m-0">
							    <div class="col-xs-3">
		       					 	<label class="control-label p-0" for="name">Name</label>
		 						</div>
							    <div class="col-xs-3">
								    <span><?php echo $hrdata[0]['name'];?></span>
							    </div>
							    <div class="col-xs-3 ">
							        <label class="control-label p-0" for="code">HR Code</label>
							    </div>
							    <div class="col-xs-3">
									<span><?php echo $hrdata[0]['code'];?></span>
							    </div>
							</div>
							<div class="row view-row p-1  m-0">
							    <div class="col-xs-3">
									<label class=" control-label p-0" for="district">HR Type</label> 
								</div>
								<div class="col-xs-3">
									<span><?php echo get_subtype_name($hrdata[0]['hr_sub_type_id']);?></span>
								</div>
								<div class="col-xs-3">
									<label class="control-label p-0" for="facilit">District</label>
								</div>
								<div class="col-xs-3">
									<span><?php echo $hrdata[0]['district'];?></span>
								</div>
							</div>
							<div class="row view-row p-1  m-0">
							    <div class="col-xs-3">
									<label class=" control-label p-0" for="district">Union Council</label> 
								</div>
								<div class="col-xs-3">
									<span><?php echo $hrdata[0]['unioncouncil'];?></span>
								</div>
								<div class="col-xs-3">
									<label class="control-label p-0" for="facilit">Facility</label>
								</div>
								<div class="col-xs-3">
									<span><?php echo $hrdata[0]['facilityname'];?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php if($status_typee == 'Active' || $status_typee == 'On Leave'){?>		
     <div class="form-group">
		<label class="col-xs-2 control-label" for="date_joining">Status</label>
		 <div class="col-xs-2"> 
			<select id="status" onchange="getStatusValue()" name="status_type" class="form-control" size="1" required=""> 
				<option value="">Select Status</option>
				<?php  get_status_options($status_typee);?>	 						
			</select>
		 </div>
		<div class="show_date" id="date">
		  <label class="col-xs-2 control-label"  for="place_of_joining">Since</label>
			<div class="col-xs-2">
				<input type="text" name="date_termination" id="date_termination" placeholder="yyyy-mm-dd" class="dpcct form-control" value=""  required="">
			</div>
		</div>	 
		<div class="show_level" id="show_level" style="display: none;">
			<label class="col-xs-2 control-label"  for = "new_level" > Level <span style="color:red;">*</span></label>
				<div class="col-xs-2">
					<select id="new_level" onchange="getLevelValue()" name="new_level" class="form-control" size="1">
						<option value="">Select Level</option>
							<?php general_config(array("table_name"=>"hr_levels","value_col"=>"code","active"=>"1"),array("selected"=>isset($selectlevel)? $selectlevel : ""))
										//general_config('hr_levels','code','name','1'); selectlevel?>
					</select>
			   </div>
		</div>
		<div class="show_post" id="show_post" style="display: none;">
		 <label class="col-xs-2  control-label"  for = "status" > Posted As (Type) <span style="color:red;">*</span></label>
								<div class="col-xs-2">
										<select id="temp_post" name="temp_post" class="form-control" size="1">
										<option value="">Select Type</option>
											<?php general_config(array("table_name"=>"hr_types"),array("selected"=>isset($selecttype)? $selecttype : "")); //selecttype ?>
										</select>
									<!-- <select id="temp_post" name="temp_post" class="form-control" size="1" >
										<option value="">Select Post </option>
										<?php general_config(array("table_name"=>"hr_sub_types","value_col"=>"type_id","label_col"=>"title","active"=>NULL,"select_only"=>NULL),array("selected"=>isset($data['hr_sub_type_id'])? $data['hr_sub_type_id'] : "","createoption"=>TRUE)); //select_subtype?><?php echo form_error('post_status'); ?>
									</select> -->
									<!--<input type="hidden" name="post_type" id="post_type" value="" > -->
								</div>
		</div>
		<div class="show_sub_post" id="show_sub_post" style="display: none;">
							<label class="col-xs-2 control-label"  for = "status" > Posted As (Subtype) <span style="color:red;">*</span></label>
								<div class="col-xs-2">
									<select id="temp_sub_post" name="temp_sub_post" class="form-control" size="1" >
										<option value="">Select Subtype </option>
									</select>
									<!--<input type="hidden" name="post_type" id="post_type" value="" > -->
								</div>
		</div>
		
							<div class="show_new_District" id="show_new_District" style="display: none;">
								<label class="col-xs-2  control-label"  for = "new_distcode" > District <span style="color:red;">*</span></label>
								<div class="col-xs-2">
									<select id="new_distcode"  name="new_distcode" class="form-control" size="1" ><option value="">Select District</option>
										<?php 
											foreach($districts as $row){
												
										?>  
										<option value="<?php echo $row['distcode'];?>" <?php echo set_select('distcode',$row['distcode']); ?>  ><?php echo $row['district'];?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="show_new_Tehsil" id="show_new_Tehsil" style="display: none;">
								<label class="col-xs-2 control-label"  for = "new_tcode" > Tehsil <span style="color:red;">*</span></label>
								<div class="col-xs-2">
									<select id="new_tehcode" name="new_tehcode" class="form-control" size="1" > <option value="">Select Tehsil</option>
										<?php 
											foreach($resultTeh as $row){
										?>
										<option value="<?php echo $row['tcode'];?>" <?php echo set_select('tcode',$row['tcode']); ?> ><?php echo $row['tehsil'];?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="show_new_council" id="show_new_council" style="display: none;">	
								<label class="col-xs-2 control-label"  for = "uncode" > Union council <span style="color:red;">*</span></label>
								<div class="col-xs-2">
									<select id="new_uncode"  name="new_uncode" class="form-control" size="1" ><option value="">Select Union Council</option>
										<?php 
											foreach($resultun as $row){
										?>
										<option value="<?php echo $row['uncode'];?>" <?php echo set_select('uncode',$row['uncode']); ?> ><?php echo $row['un_name'];?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="show_new_facility" id="show_new_facility" style="display: none;">	
								<label class="col-xs-2 control-label"  for = "new_facode" > EPI Center Name <span style="color:red;">*</span></label>
								<div class="col-xs-2">
									<select id="new_facode"  name="new_facode" class="form-control" size="1" ><option value="">Select EPI Center</option>
										<?php 
											foreach($resultFac as $row){
										?>
										<option value="<?php echo $row['facode'];?>" <?php echo set_select('facode',$row['facode']); ?> ><?php echo $row['fac_name'];?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="showLeave" id="showLeavefrom" style="display: none;">
								<label class="col-xs-2  control-label"  for = "date_from" > Date From </label>
								<div class="col-xs-2">
									<input type="text" name="date_from" id="date_from" placeholder="Date From" class="form-control" value="" />
								</div>
							</div>
							<div class="showLeave" id="showLeaveto" style="display: none;">
								<label class="col-xs-2 control-label"  for = "date_to"> Date To </label>
								<div class="col-xs-2">
									<input  type="text"  name="date_to" id="date_to" placeholder="Date To"  class="form-control " value="" />
								</div>
							</div>
		
	 </div>
		<div class="col-xs-1 pull-right">
			<a href="<?php echo base_url();?>Hr_management/hr_list" style="margin: 1px 10px 10px 0px"" type="reset" class="btn btn-sm btn-warning col-md-12"><i class="fa fa-repeat"></i>Cancel</a>
		</div>
		<div class="col-xs-2 pull-right" style="margin: 1px 10px 10px 10px"> 
			<button type="submit" id="save" onclick="confirmAction(event);" class="btn btn-sm btn-primary col-md-12" name="is_temp_saved"  value="1"  style="margin: 1px 10px 10px 0px" ><i class="fa fa-angle-right "></i>Update Status</button>
		</div>
		<?php } ?>	
	</form>
    <?php $status = $status_typee;  
	if($status == 'Retired' || $status == 'Resigned' || $status == 'Terminated' || $status == 'Died' || $status == 'Contract Expired' || $status == 'Shifted'){?>	
     <label class="col-xs-10  control-label">You do not have to change the Status. It can only Delete the Status.</label>
	 <div class="col-xs-1 pull-right"> 
	   <a href="<?php echo base_url();?>Hr_management/hr_list" style="margin: 1px 10px 10px 0px"" type="reset" class="btn btn-sm btn-warning col-md-12"><i class="fa fa-repeat"></i>Cancel</a>
	 </div>
	<?php }?>
	 <?php echo $htmlData; ?> 
	<label class="col-xs-10  control-label" for="place_of_joining">Delete the current status if it is set mistakenly.</label>
		<!-- The Modal -->
               </div>
                <!--END CONTENT-->
                <!--BEGIN FOOTER-->
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
	
	<script src="<?php echo base_url(); ?>js/plugins.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/app.js" type="text/javascript"></script> 
	<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.inputmask.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.Jcrop.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/scriptCrop.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.alphanumeric.js"></script>
	<script type="text/javascript">
	function getLevelValue(){
		level=document.getElementById("new_level").value;
		//alert(level);
	} 
	function getStatusValue(){
		status=document.getElementById("status").value;
		//alert(status);
	} 
	function confirmAction(e) {
		var x = document.forms["dataform"]["new_distcode"].value;
		var y = document.forms["dataform"]["new_tehcode"].value;
		var z = document.forms["dataform"]["new_facode"].value;
		var distcode = document.getElementById("hidden_distcode").value;
		var tcode = document.getElementById("hidden_tcode").value;
		var facode = document.getElementById("hidden_facode").value;
		var pre_level = document.getElementById("level").value;
		//alert(level); //exit();
		/* if(status == "Transferred"){
			if(level != pre_level){ 
				alert("Do not Transferred other Level.Only Transferred Same Level");
				//alert('aa'); exit();
				e.preventDefault();
				return false;
				
			}
		} */
		if(status == "Transferred"){
			if(level == "4"){ 
				if (x == distcode) {
					alert("Do not Transferred in same District");
					//alert('aa'); exit();
					e.preventDefault();
					return false;
				}
			}
		}
		if(status == "Transferred"){
			if(level == "5"){
				if(y==tcode){
					alert("Do not Transferred in same Tehsil");
					a//lert('bb'); exit();
					e.preventDefault();
					return false;
			   }
			}
		}
		if(status == "Transferred"){
			if(level == "7"){
				if(z==facode){
					alert("Do not Transferred in same Facility");
					//alert('cc'); exit();
					e.preventDefault();
					return false;
			    }
			}
		} 
	} 
	var user_level = "<?php echo $_SESSION['UserLevel']; ?>";
	if(user_level == "3"){
		$("#new_level option[value='2']").remove();
	}else if(user_level == "2"){
		$("#new_level option[value!='2']").remove();
		$("#new_status option[value='Transferred']").remove();
	}else if(user_level == "4"){
		$("#new_level option[value='2'], #new_level option[value='4']").remove();
	}
	$("#new_level option[value='6']").remove();
	$("#new_level").bind('change', function(){
    var selected = $(this).val();
    if (selected == '4') { 
    		$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'none');
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_tehcode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}else if(selected == '5') {  
			$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'block');
			$('#new_tehcode').prop('required',true);
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}else if (selected == '7') {  
			$('#show_new_District').css('display', 'block');
			$('#new_distcode').prop('required',true);
			$('#show_new_Tehsil').css('display', 'block');
			$('#new_tehcode').prop('required',true);
			$('#show_new_council').css('display', 'block');
			$('#new_uncode').prop('required',true);
			$('#show_new_facility').css('display', 'block');
			$('#new_facode').prop('required',true);
	}else{ 
			$('#show_new_District').css('display', 'none');
			$('#show_new_Tehsil').css('display', 'none');
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tehcode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
	}
    //etc ...
	});
	$("#status").bind('change', function()
	{
		var selected = $(this).val();
		if(selected == '')
		{
			$('#show_post').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#date').css('display', 'block');
			$('#showDied').css('display', 'none');
			$('#show_new_District').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#show_post').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
			$('#show_new_District').css('display', 'none');
			$('#show_new_Tehsil').css('display', 'none');
			$('#show_new_facility').css('display', 'none');
			$('#show_new_council').css('display', 'none');
			$('#new_distcode').removeAttr('required','required');
			$('#new_tehcode').removeAttr('required','required');
			$('#new_facode').removeAttr('required','required');
			$('#new_uncode').removeAttr('required','required');
		}
		if(selected == 'Terminated')
		{
			$('#show_post').css('display', 'none');
			$('#showTerminated').css('display', 'block');
			$('#date').css('display', 'block');
			$('#showDied').css('display', 'none');
			$('#show_new_District').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#show_post').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Transferred')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'block');
			$('#date').css('display', 'block');
			$('#newFac').css('display', 'block');
			$('#showTransfer').css('display', 'block');
			$('#new_level').attr('required','required');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Died')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#date').css('display', 'block');
			$('#show_new_District').css('display', 'none');
			$('#showDied').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');	
			$('#showContract Expired').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Shifted')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#date').css('display', 'block');
			$('#show_new_District').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showShifted').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');	
			$('#showContract Expired').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Contract Expired')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#date').css('display', 'block');
			$('#show_new_District').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showContract Expired').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'On Leave')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#date').css('display', 'none');
			$('#showLeavefrom').css('display', 'block');			
			$('#showLeaveto').css('display', 'block');
			$('#show_leave').css('display', 'block');
			$('#show_remarks').css('display', 'block');
			$('#showContract Expired').css('display', 'none');
			$('#show_approved').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
			$('#date_termination').removeAttr('required','required');
		}
		else if(selected == 'Resigned')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#date').css('display', 'block');
			$('#showReason').css('display', 'block');
			$('#showResigned').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Retired')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#showRetired').css('display', 'block');
			$('#date').css('display', 'block');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Posted')
		{
			$('#show_level').css('display', 'block');
			$('#show_post').css('display', 'block');
			$('#date').css('display', 'block');
			$('#show_sub_post').css('display', 'block');
			$('#show_post').attr('required','required');
			$('#show_sub_post').attr('required','required');
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#new_level').removeAttr('required','required');
		}
		else if(selected == 'Active')
		{
			$('#show_post').css('display', 'none');
			$('#show_level').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#date').css('display', 'block');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showRetired').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#show_sub_post').css('display', 'none');
			$('#new_level').removeAttr('required','required');
			$('#show_post').removeAttr('required','required');
			$('#show_sub_post').removeAttr('required','required');
		}
		else if(selected == 'Post_Back') 
		{
			$('#show_level').css('display', 'block');
			$('#show_post').css('display', 'block');
			$('#date').css('display', 'block');
			$('#show_sub_post').css('display', 'block');
			$('#show_post').attr('required','required');
			$('#show_sub_post').attr('required','required');
			$('#showRetired').css('display', 'none');
			$('#showTerminated').css('display', 'none');
			$('#showDied').css('display', 'none');
			$('#showLeavefrom').css('display', 'none');			
			$('#showLeaveto').css('display', 'none');
			$('#showContract Expired').css('display', 'none');
			$('#showReason').css('display', 'none');
			$('#showResigned').css('display', 'none');
			$('#showDistrict').css('display', 'none');
			$('#newFac').css('display', 'none');
			$('#showTransfer').css('display', 'none');
			$('#show_leave').css('display', 'none');
			$('#show_remarks').css('display', 'none');
			$('#show_approved').css('display', 'none');
			$('#new_level').removeAttr('required','required');
		}
	});
	$('#new_distcode').on('change' , function(){
	 var dists=this.value;
		$.ajax({
			type: "POST",
			data: "distcode="+dists,
			url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
					success: function(result){
						$('#new_tehcode').html(result);
					}
		});
	});
	$('#new_tehcode').on('change' , function (){
	  var tehcode = this.value;
	  var uncode = "";
	  $.ajax({
		type: "POST",
		data: "tcode="+tehcode,
		url: "<?php echo base_url(); ?>Ajax_calls/getUnC/tcode",
		success: function(result){
		  $('#new_uncode').html(result);
		}
	  });
	});
	$('#new_uncode').on('change' , function (){
	  var uncode = this.value;
	  var facode = "";
	  $.ajax({
		type: "POST",
		data: "uncode="+uncode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
		success: function(result){
		  $('#new_facode').html(result);
		}
	  });
	});
	$('#tehcode').on('change' , function (){
		var tehcode = this.value;
	//	alert (tehcode);
		var facode = "";
			if (tehcode!='')
			{
					document.getElementById("distcode").required = false;
			}
	});
		$('#temp_post').on('change', function (){
		var type_val = $(this).val();
		if(type_val){
			$.ajax({ 
				type: 'POST',
				data: "type_val="+type_val,
				url: '<?php echo base_url();?>Ajax_hr_management/sub_type_options',
				//dataType: "json",
				success: function(data)
				{
					if(data!='')
					{
						$('#temp_sub_post').children('option:not(:first)').remove();
						$("#temp_sub_post").append(data);
					}else{
						$('#temp_sub_post').children('option:not(:first)').remove();
					}
				}
			});
		}
		else
		{
			$('#temp_sub_post').children('option:not(:first)').remove();
		}
		});
	//post-back mechanism based on comparison of distcode
	var previous_code = "<?php echo $hrdata1[0]['pre_status']; ?>";
	if(previous_code == "Posted")
	{
		$("#status option[value='Posted']").remove();
		$("#status option[value='Transferred']").remove(); 
		$("#status").append('<option value="Post_Back">Post-Back</option>');
	}
	$(function () {
		var options = {
			format : "yyyy-mm-dd",
			viewDate: new Date(),
			endDate : new Date(),
			autoclose: true
		};	
		 $('#date_termination').datepicker(options);
		 //$('#date_from').datepicker(options);
		// $('#date_to').datepicker(options);
	}); 
	$(function () {
        var options = {
		 format : "yyyy-mm-dd",
         startDate : "01-01-1925",
         endDate: "12-12-2000"
        };
        var options = {
           format : "yyyy-mm-dd"
        };
		$('#date_from').datepicker(options);
		$('#date_to').datepicker(options);
    });
	////Code For Save Form With Control+S Event//////////////
   /*  $(document).on('keydown', function(e){
	    if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
		    //alert('a');
			e.preventDefault();
			return false;
		}
	}); */				
  /* $('#save').on('click' , function (){
	  alert('a');
	  $(this).submit();
	}); */				
	</script> 
</body>
</html>