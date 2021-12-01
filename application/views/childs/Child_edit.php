<!--start of page content or body-->

<?php //print_r($data); exit; ?>
<!--<?php print_r($data['childData']);?>-->
 <div class="container bodycontainer">
  <div class="row"> 
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> Update Child Registeration Form
        </div>
         <div class="panel-body">
     <!-- <form  action="<?php echo base_url();?>Reports_list/child_save" method="post" class="form-horizontal form-bordered" >-->
      <form class="form-horizontal form-bordered" method="post" action="<?php echo base_url();?>Reports/ChildRegistrationSave">        
		<input type="hidden" name="recno" id="recno"  value="<?php echo $childData[0]['recno']; ?>"  class="form-control "/>         
		<div class="form-group">
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">EPI Center Info</div>
			<br>
			<div class="row">
		       <div class="showProvnice" id="showProvnice">
                 <label class="col-xs-2 col-xs-offset-1  control-label" for = "showProvnice" > Provnice</label>
                 <div class="col-xs-3">
                      <select id="newprocode" required="required" name="procode" class="form-control" size="1">
					         <!-- <?php //echo getProvinces_options(false,$childData[0]['procode']); ?>-->
							 <option value="<?php echo $this-> session-> Province;?>" >
								<?php echo get_Province_Name($this->session->Province);  ?>
							</option>
					  </select>
				</div>
				<label class="col-xs-2  control-label" for = "showDistrict" >  District</label>
				<div class="col-xs-3">
					<select id="newdistcode" required="required" name="distcode" class="form-control" size="1">
							<option value="<?php echo $childData[0]['distcode']; ?>" selected > <?php echo get_District_Name($childData[0]['distcode']); ?> </option>
						  <?php //echo getallDistrict_options(false,$childData[0]['distcode'],$childData[0]['procode']); ?>
					</select>
				</div>
				</div>
			</div>
			<div class="row">
		            <div class="showDistrict" id="showDistrict"></div>
			        <div class="showTehsil" id="showTehsil">
						<label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >  Tehsil</label>
						<div class="col-xs-3">
							<select  id="newtcode" required="required" name="tcode" class="form-control" size="1" >
								<option value="<?php echo $childData[0]['tcode']; ?>" selected > <?php echo get_Tehsil_Name($childData[0]['tcode']); ?> </option>
									<?php //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
							</select>
						</div>
						<label class="col-xs-2  control-label"  for = "showUnc" >  Union Council</label>
						<div class="col-xs-3">
							<select id="newuncode" required="required" name="uncode" class="form-control" size="1">
								<option value="<?php echo $childData[0]['uncode']; ?>" selected > <?php echo get_UC_Name($childData[0]['uncode']); ?> </option>
						          <?php	//echo getallunioncouncil_options(false,$childData[0]['uncode'],$childData[0]['tcode']); ?>
							</select>
						</div>
					</div>
			</div>		
			
			<!--<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Registered Info</div>
			<br>-->
			<div class="row">
				<div class="showTehsil" id="showTehsil">
                     <label class="col-xs-2 col-xs-offset-1 control-label" for = "showTehsil" >Facility</label>
					<div class="col-xs-3">
						<select  id="newfacode" required="required" name="facode" class="form-control" size="1" >
							<option value="<?php echo $childData[0]['reg_facode']; ?>" selected > <?php echo get_Facility_Name($childData[0]['reg_facode']); ?> </option>
								<?php	//echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
						</select>
					</div>
					<label class="col-xs-2 control-label" for = "showTehsil" >Technician</label>
					<div class="col-xs-3">
						<select  id="techniciancode" required="required" name="techniciancode" class="form-control" size="1" >
						    <option value="<?php echo $childData[0]['techniciancode']; ?>" selected > <?php echo get_Hr_Name($childData[0]['techniciancode'],'01'); ?> </option>
								<?php //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
						</select>
					</div>
				</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" >Address</label>
                <div class="col-xs-3">
						<select  id="address" required="required" name="address" class="form-control" size="1" >
						    <option value="<?php echo $childData[0]['villagemohallah']; ?>" >
								<?php echo get_Village_Name($childData[0]['villagemohallah']); ?> 
							</option>
								<?php //echo getallTehsil_options(false,$childData[0]['tcode'],$childData[0]['distcode']); ?>
						</select>
					</div>
		   </div>
			</div>
			<br>
		<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Child Basic info</div>
			<br>
			<div class="row">
			    
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "CardNO" > Card No: </label>
                <div class="col-xs-3">
					<input type="text"  name="cardno" id="cardno" readonly placeholder="Card No"  value="<?php if(validation_errors() != false) { echo set_value('cardno'); } else { echo $childData[0]['cardno']; } ?>"  class="form-control "/><?php echo form_error('cardno'); ?>
				</div>
				
				<label class="col-xs-2 control-label"  for = "CardNO" >Date of Birth </label>
                <div class="col-xs-3">
					<input name="dateofbirth" id="dateofbirth"  required="" placeholder="yyyy-mm-dd"  class="month_year form-control"  required type="text" readonly value="<?php echo $childData[0]['dateofbirth'];?>" data-date-format="yyyy-mm-dd"> 
				</div>
			</div>
			<div class="row">
				
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "name" >Name</label>
                <div class="col-xs-3">
                    <input type="text"  name="nameofchild" id="nameofchild" placeholder="Name of Child"  value="<?php if(validation_errors() != false) { echo set_value('nameofchild'); } else { echo $childData[0]['nameofchild']; } ?>"  class="form-control "/><?php echo form_error('nameofchild'); ?>
				</div>
				<label class="col-xs-2  control-label"  for = "Gender" >Gender</label>
				<div class="col-xs-3">
                    <input type="radio" required name="gender" <?php  if(isset($childData[0]['gender']) AND $childData[0]['gender'] == 'm'){echo 'checked';}else{echo '';}?> value="m"> Male
					<input type="radio" required name="gender" <?php  if(isset($childData[0]['gender']) AND $childData[0]['gender'] == 'f'){echo 'checked';}else{echo '';}?> value="f"> Female
				</div>
			</div>
			
			<!--<br>
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Parents info</div>
			<br>-->
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "fathername" > Father Name</label>
                <div class="col-xs-3">
					<input type="text"  name="fathername" id="fathername" placeholder="Father Name"  value="<?php if(validation_errors() != false) { echo set_value('fathername'); } else { echo $childData[0]['fathername']; } ?>"  class="form-control "/><?php echo form_error('fathername'); ?>
				</div>
				<label class="col-xs-2 control-label"  for = "cnic" >Father CNIC</label>
                <div class="col-xs-3">
					<input type="text"  name="fathercnic" id="fathercnic" placeholder="Father Cnic"  value="<?php echo isset($childData[0]['fathercnic'])?$childData[0]['fathercnic']:'';?>"  class="form-control ">
				</div>
				
               
		   </div>
		    <div class="row">
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "mothername" >Mother name</label>
                <div class="col-xs-3">
                    <input type="text"  name="mothername" id="mothername" placeholder="Mother name"  value="<?php echo isset($childData[0]['mothername'])?$childData[0]['mothername']:'';?>"  class="form-control ">
				</div>
				<label class="col-xs-2  control-label"  for = "mothernic" >Mother Cnic</label>
                <div class="col-xs-3">
                    <input type="text"  name="mothercnic" id="mothercnic" placeholder="Mother Cnic"  value="<?php echo isset($childData[0]['mothercnic'])?$childData[0]['mothercnic']:'';?>" class="form-control ">
				</div>
		   </div>
		   <div class="row">
				
				<label class="col-xs-2 col-xs-offset-1  control-label"  for = "Contact" >Enter Contact Number</label>
                <div class="col-xs-3">
                    <input type="text"  name="contactno" id="contactno" placeholder="Enter Contact Number"  value="<?php echo isset($childData[0]['contactno'])?$childData[0]['contactno']:'';?>" class="form-control ">
				</div>
		   </div>
		   <br>
			
			<div class="panel-heading" style="height: 26px;font-size: 14px;padding: 4px;color: white;">Doses Administered</div>
			<br>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >BCG </label>
                <div class="col-xs-3">
					<input type="text"  name="bcg" id="bcg" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['bcg'])?$childData[0]['bcg']:'';?>"  data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-0 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv0" id="opv0" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['opv0'])?$childData[0]['opv0']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >HEP-B </label>
                <div class="col-xs-3">
					<input type="text"  name="hepb" id="hepb" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['hepb'])?$childData[0]['hepb']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Penta-1 </label>
                <div class="col-xs-3">
					<input type="text"  name="penta1" id="penta1" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['penta1'])?$childData[0]['penta1']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row"> 
				<label class="col-xs-2 col-xs-offset-1 control-label" for="cnic">Rota-1 </label>
				<div class="col-xs-3"> 
					<input type="text" name="rota1" id="rota1" placeholder="yyyy-mm-dd" value="<?php echo isset($childData[0]['rota1'])?$childData[0]['rota1']:''; ?>" data-date-format="yyyy-mm-dd" class="form-control calender1">
				</div>
				<label class="col-xs-2 control-label" for="">Is Child Dead </label>
				<div class="col-xs-1">
					<input type="checkbox" id="childdeath" name="vehicle1" dir="rtl" value="<?php echo isset($childData[0]['dateofdeath'])?$childData[0]['dateofdeath']:'0'; ?>">
				</div>
				<label class="col-xs-2  control-label" for="cnic">Is Refusal </label>
				<div class="col-xs-1"> 
					<input type="checkbox" id="childrefusal" name="vehicle2" dir="rtl" value="<?php echo isset($childData[0]['dateofrefusal'])?$childData[0]['dateofrefusal']:'1'; ?>">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-1 </label>
				<div class="col-xs-3">
					<input type="text"  name="opv1" id="opv1" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['opv1'])?$childData[0]['opv1']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
					</div>
					<div id="deathrow" style="display: none;">
					 <label class="col-xs-2  control-label" for="cnic">Date of death </label>
						<div class="col-xs-3"> <input type="text" name="dateofdeath" id="dateofdeath" placeholder="yyyy-mm-dd" value="<?php echo isset($childData[0]['dateofdeath'])?$childData[0]['dateofdeath']:''; ?>" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
					</div>
					<div id="refusalrow" style="display: none;">
						<label class="col-xs-2  control-label" for="cnic">Date of refusal </label>
						<div class="col-xs-3"> <input type="text" name="dateofrefusal" id="dateofrefusal" placeholder="yyyy-mm-dd" value="<?php echo isset($childData[0]['dateofrefusal'])?$childData[0]['dateofrefusal']:''; ?>" data-date-format="yyyy-mm-dd" class="form-control calender1"> </div>
					</div>
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-1 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv1" id="pcv1" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['pcv1'])?$childData[0]['pcv1']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Penta-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="penta2" id="penta2" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['penta2'])?$childData[0]['penta2']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Rota-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="rota2" id="rota2" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['rota2'])?$childData[0]['rota2']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv2" id="opv2" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['opv2'])?$childData[0]['opv2']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-2 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv2" id="pcv2" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['pcv2'])?$childData[0]['pcv2']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >penta-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="penta3" id="penta3" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['penta3'])?$childData[0]['penta3']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >OPV-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="opv3" id="opv3" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['opv3'])?$childData[0]['opv3']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >PCV-3 </label>
                <div class="col-xs-3">
					<input type="text"  name="pcv3" id="pcv3" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['pcv3'])?$childData[0]['pcv3']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >IPV</label>
                <div class="col-xs-3">
					<input type="text"  name="ipv" id="ipv" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['ipv'])?$childData[0]['ipv']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-1</label>
                <div class="col-xs-3">
					<input type="text"  name="measles1" id="measles1" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['measles1'])?$childData[0]['measles1']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			<br>
			<div class="row">
				<label class="col-xs-2 col-xs-offset-1 control-label"  for = "cnic" >Measles-2</label>
                <div class="col-xs-3">
					<input type="text"  name="measles2" id="measles2" placeholder="yyyy-mm-dd"  value="<?php echo isset($childData[0]['measles2'])?$childData[0]['measles2']:'';?>" data-date-format="yyyy-mm-dd" class="form-control calender">
				</div>
			</div>
			
				
			</div>
				<br>
		<br>
		<div class="row">
                             <div class="col-xs-7" style="margin-left:53.5%;">
                       
						<button type="submit" class="btn btn-md btn-success" style="margin-left: 0.12%;"><i class="fa fa-floppy-o "></i> Submit  </button>
                        <button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset </button>
                        <a href="<?php echo base_url();?>Reports/ChildRegistrationList" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
</div>
                    </div>
		
    </div>
      </form>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script type="text/javascript">

 function incrementDated(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			
			var bcg = $("#bcg").val();
			var dateofbirth = $("#dateofbirth").val();
			
			if(bcg > dateofbirth ){
				//alert('if');
				addDays('bcg' , 'penta1', 28); 
				addDays('bcg' , 'rota1', 28); 
				addDays('bcg' , 'pcv1', 28); 
			} else {
				//alert('else');
				addDays('dateofbirth' , 'penta1', 42); 
				addDays('dateofbirth' , 'rota1', 42); 
				addDays('dateofbirth' , 'pcv1', 42); 
			}
			 return increasedDate;
		}
		
		
	 function incrementDateopv(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			
			var opv0 = $("#opv0").val();
			var dateofbirth = $("#dateofbirth").val();
			
			if(opv0 > dateofbirth ){
				//alert('if');
				addDays('opv0' , 'opv1', 28);
			} else {
				//alert('else');
				addDays('dateofbirth' , 'opv1', 42); 
			}
			 return increasedDate;
		}
		
	function toDate(start_date_id, end_date_id)	{
			$('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
			$('#'+start_date_id).datepicker('setEndDate', '+0d');
		}
	
	function addDays(start_date_id, end_date_id, numberOfDays=30)	{
		var from_date = $('#'+start_date_id).datepicker().val();
		from_date = from_date.substring(0,4) + '-' + from_date.substring(5,7) + '-' + from_date.substring(8,10);
		from_date = new Date(from_date.toString());
		from_date.setDate(from_date.getDate() + numberOfDays);
		
		var dd = from_date.getDate();
		var mm = from_date.getMonth() + 1;
		var y = from_date.getFullYear();
		var formattedDate = y + '-'+ mm + '-'+ dd;
		$("#"+end_date_id).datepicker('setStartDate', from_date);
	} 
	//Empty all column by clicking on date of birth
	function bcgclick(){
			//$("#penta1").val('');
			$("#rota1").val('');
			$("#pcv1").val('');
		}
	
		function incrementDate(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate ){
				document.getElementById("penta1").disabled = false;
				document.getElementById("rota1").disabled = false;
				document.getElementById("pcv1").disabled = false;
				addDays('bcg', 'penta1', 42);  
				addDays('bcg', 'rota1', 42);
				//addDays('dateofbirth', 'opv1', 42); 
				addDays('bcg' , 'pcv1', 42); 
			} else {
				document.getElementById("penta1").disabled = true;
				document.getElementById("rota1").disabled = true;
				document.getElementById("pcv1").disabled = true;
			}
			 return increasedDate;
		} 
		
		function incrementDateipv(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate ){
				document.getElementById("ipv").disabled = false;
				addDays('dateofbirth' , 'ipv', 98); 
			} else {	
				document.getElementById("ipv").disabled = true;
			}
			 return increasedDate;
		}
		
		function incrementDatemeasles1(dateInput,increment) {
			var dateFormatTotime = new Date(dateInput);
			var increasedDate = new Date(dateFormatTotime.getTime() +(increment *86400000));
			let todaydate = new Date();
			if(todaydate > increasedDate){
				document.getElementById("measles1").disabled = false;
				addDays('dateofbirth' , 'measles1', 270); 
			} else {
				document.getElementById("measles1").disabled = true;
			}
			 return increasedDate;
		}

	$(document).ready(function () {
		// disable all if not selected date of birth
		/* document.getElementById("bcg").disabled = true;
		document.getElementById("opv0").disabled = true;
		document.getElementById("hepb").disabled = true; */
		document.getElementById("penta1").disabled = true;
		document.getElementById("rota1").disabled = true;
		document.getElementById("opv1").disabled = true;
		document.getElementById("pcv1").disabled = true;
		document.getElementById("penta2").disabled = true;
		document.getElementById("rota2").disabled = true;
		document.getElementById("opv2").disabled = true;
		document.getElementById("pcv2").disabled = true;
		document.getElementById("penta3").disabled = true;
		document.getElementById("opv3").disabled = true;
		document.getElementById("pcv3").disabled = true;
		document.getElementById("ipv").disabled = true;
		document.getElementById("measles1").disabled = true;
		document.getElementById("measles2").disabled = true;
		document.getElementById("dateofdeath").disabled = true;
		document.getElementById("dateofrefusal").disabled = true;
				
$('#childdeath,#childrefusal').on('change', function() {
		var checkedprop = $(this).prop('checked');
		var checkedValue = $(this).val();
		if(checkedValue == 0){
			$("#childrefusal" ).prop( "checked", false );
			$('#deathrow').css('display', 'block');
			$('#refusalrow').css('display', 'none');
			$('#dateofrefusal').val('');
		}else{
			$( "#childdeath" ).prop( "checked", false );
			$('#refusalrow').css('display', 'block');
			$('#deathrow').css('display', 'none');
			$('#dateofdeath').val('');
		}
		if(checkedprop == false){
			$('#refusalrow').css('display', 'none');
			$('#deathrow').css('display', 'none');
			$('#dateofdeath').val('');
			$('#dateofrefusal').val('');
		}
	});

//for date of birth
	$('#dateofbirth').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#bcg').datepicker('setStartDate', minDate);
		$('#opv0').datepicker('setStartDate', minDate);
		$('#hepb').datepicker('setStartDate', minDate);
		$('#dateofdeath').datepicker('setStartDate', minDate);
		$('#dateofrefusal').datepicker('setStartDate', minDate);
		
		document.getElementById("bcg").disabled = false; 
		document.getElementById("opv0").disabled = false;
		document.getElementById("hepb").disabled = false;
		document.getElementById("penta1").disabled = false;
		document.getElementById("rota1").disabled = false;
		document.getElementById("opv1").disabled = false;
		document.getElementById("pcv1").disabled = false;
		document.getElementById("dateofdeath").disabled = false;
		document.getElementById("dateofrefusal").disabled = false;
		var dateofbirth  = new Date($('#dateofbirth').val());
		//var amountToIncreaseWith = 42; //Edit this number to required input
		var amountToIncreaseWithipv = 98; //Edit this number to required input
		var amountToIncreaseWithmeasles1 = 270; //Edit this number to required input
		//console.log(incrementDate(dateofbirth,amountToIncreaseWith));
		console.log(incrementDateipv(dateofbirth,amountToIncreaseWithipv));
		console.log(incrementDatemeasles1(dateofbirth,amountToIncreaseWithmeasles1));

		addDays('dateofbirth' , 'penta1', 42); 
		addDays('dateofbirth' , 'rota1', 42); 
		addDays('dateofbirth' , 'pcv1', 42); 
				
		$("#bcg").val('');
		$("#opv0").val('');
		$("#hepb").val('');
		$("#penta1").val('');
		$("#rota1").val('');
		$("#opv1").val('');
		$("#pcv1").val('');
		$("#penta2").val('');
		$("#rota2").val('');
		$("#opv2").val('');
		$("#pcv2").val('');
		$("#penta3").val('');
		$("#opv3").val('');
		$("#pcv3").val('');
		$("#ipv").val('');
		$("#measles1").val('');
		$("#measles2").val(''); 
		$("#dateofdeath").val(''); 
		$("#dateofrefusal").val(''); 
		dp.date = e.date;
		dp.setValue();
	});
	
	//for date of vaccin
	$('#bcg').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		
		var bcg  = new Date($('#bcg').val());
		var amountToIncreaseWith = 42; //Edit this number to required input
		console.log(incrementDate(bcg,amountToIncreaseWith));
				
		/* $("#penta1").val('');
		$("#rota1").val('');
		$("#pcv1").val(''); */
	}).on('clearDate', function(){
		/* $("#penta1").val('');
		$("#rota1").val('');
		$("#pcv1").val(''); */
	}); 
	
	$('#opv0').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		
		//$("#opv1").val('');
		//addDays('opv0', 'opv1', 42); 
		document.getElementById("opv1").disabled = false;
		
		var dateofbirth  = new Date($('#dateofbirth').val());
		var amountToIncreaseWithdateofbirthhh = 42; //Edit this number to required input
		incrementDateopv(dateofbirth,amountToIncreaseWithdateofbirthhh); 
		
	});
	
	$('#hepb').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) { 

	}); 
	
	$('#penta1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
		  
	}).on('changeDate', function(e) {
		addDays('penta1' , 'penta2', 28); 
		document.getElementById("penta2").disabled = false;
		$("#penta2").val('');
	});   
	
	$('#rota1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(), 
	}).on('changeDate', function(e) {
		addDays('rota1', 'rota2', 28);  
		document.getElementById("rota2").disabled = false;	
		$("#rota2").val('');
	}); 
	$('#opv1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),

	}).on('changeDate', function(e) {
		addDays('opv1', 'opv2', 28);	  
		document.getElementById("opv2").disabled = false;		
		$("#opv2").val('');
	});

	$('#pcv1').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('pcv1', 'pcv2', 28);
		document.getElementById("pcv2").disabled = false;  
		$("#pcv2").val('');  
	}); 
	
	$('#penta2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('penta2', 'penta3', 28);  
		document.getElementById("penta3").disabled = false;	
	$("#penta3").val('');
	}); 
	
	$('#rota2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
	
	});
	
	$('#opv2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('opv2', 'opv3', 28);
		document.getElementById("opv3").disabled = false;	
		$("#opv3").val('');
	});
	
	$('#pcv2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('pcv2', 'pcv3', 28);  
		document.getElementById("pcv3").disabled = false;	
		$("#pcv3").val('');	
	}); 
	
	$('#penta3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#opv3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#pcv3').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#ipv').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
	}); 
	
	$('#measles1').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		addDays('measles1', 'measles2', 28);
		document.getElementById("measles2").disabled = false;	  
		$("#measles2").val('');
	}); 
	
	$('#measles2').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		dp.date = e.date;
		dp.setValue();
		});
		
	$('#dateofdeath').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2, 
		'autoclose': true,
		'endDate' : Date(),	  
	}).on('changeDate', function(e) {
		var dateofdeath = this.value;
		var bcg = $("#bcg").val();
		var opv0 = $("#opv0").val();
		var hepb = $("#hepb").val();
		var penta1 = $("#penta1").val();
		var rota1 = $("#rota1").val();
		var opv1 = $("#opv1").val();
		var pcv1 = $("#pcv1").val();
		var penta2 = $("#penta2").val();
		var rota2 = $("#rota2").val();
		var opv2 = $("#opv2").val();
		var pcv2 = $("#pcv2").val();
		var penta3 = $("#penta3").val();
		var opv3 = $("#opv3").val();
		var pcv3 = $("#pcv3").val();
		var ipv = $("#ipv").val();
		var measles1 = $("#measles1").val();
		var measles2 = $("#measles2").val();

	if(dateofdeath < bcg){
		$('#bcg').val('');
		document.getElementById("bcg").disabled = true;
	} else {
		$("#bcg").val();
		document.getElementById("bcg").disabled = false;
	}  
	if(dateofdeath < opv0){
		$('#opv0').val('');
		document.getElementById("opv0").disabled = true;
	} else {
		$("#opv0").val();
		document.getElementById("opv0").disabled = false;
	} 
	if(dateofdeath < hepb){
		$("#hepb").val('');
		document.getElementById("hepb").disabled = true;
	} else {
		$("#hepb").val();
		document.getElementById("hepb").disabled = false;
	}
	if(dateofdeath < penta1){
		$("#penta1").val('');
		document.getElementById("penta1").disabled = true;
	} else {
		$("#penta1").val();
		document.getElementById("penta1").disabled = false;
	}
	if(dateofdeath < rota1){
		$("#rota1").val('');
		document.getElementById("rota1").disabled = true;
	} else {
		$("#rota1").val();
		document.getElementById("rota1").disabled = false;
	}
	if(dateofdeath < opv1){
		$("#opv1").val('');
		document.getElementById("opv1").disabled = true;
	} else {
		$("#opv1").val();
		document.getElementById("opv1").disabled = false;
	}
	if(dateofdeath < pcv1){
		$("#pcv1").val('');
		document.getElementById("pcv1").disabled = true;
	} else {
		$("#pcv1").val();
		document.getElementById("pcv1").disabled = false;
	}
	if(dateofdeath < penta2){
		$("#penta2").val('');
		document.getElementById("penta2").disabled = true;
	} else {
		$("#penta2").val();
		document.getElementById("penta2").disabled = false;
	}
	if(dateofdeath < rota2){
		$("#rota2").val('');
		document.getElementById("rota2").disabled = true;
	} else {
		$("#rota2").val();
		document.getElementById("rota2").disabled = false;
	}
	if(dateofdeath < opv2){
		$("#opv2").val('');
		document.getElementById("opv2").disabled = true;
	} else {
		$("#opv2").val();
		document.getElementById("opv2").disabled = false;
	}
	if(dateofdeath < pcv2){
		$("#pcv2").val('');
		document.getElementById("pcv2").disabled = true;
	} else {
		$("#pcv2").val();
		document.getElementById("pcv2").disabled = false;
	}
	if(dateofdeath < penta3){
		$("#penta3").val('');
		document.getElementById("penta3").disabled = true;
	} else {
		$("#penta3").val();
		document.getElementById("penta3").disabled = false;
	}
	if(dateofdeath < opv3){
		$("#opv3").val('');
		document.getElementById("opv3").disabled = true;
	} else {
		$("#opv3").val();
		document.getElementById("opv3").disabled = false;
	}
	if(dateofdeath < pcv3){
		$("#pcv3").val('');
		document.getElementById("pcv3").disabled = true;
	} else {
		$("#pcv3").val();
		document.getElementById("pcv3").disabled = false;
	}
	if(dateofdeath < ipv){
		$("#ipv").val('');
		document.getElementById("ipv").disabled = true;
	} else {
		$("#ipv").val();
		document.getElementById("ipv").disabled = false;
	}
	if(dateofdeath < measles1){
		$("#measles1").val('');
		document.getElementById("measles1").disabled = true;
	} else {
		$("#measles1").val();
		document.getElementById("measles1").disabled = false;
	}
	if(dateofdeath < measles2){
		$("#measles2").val('');
		document.getElementById("measles2").disabled = true;
	} else {
		$("#measles2").val();
		document.getElementById("measles2").disabled = false;
	}
	
	});
	
	$('#dateofrefusal').datepicker({	
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dateofrefusal = this.value;
		var bcg = $("#bcg").val();
		var opv0 = $("#opv0").val();
		var hepb = $("#hepb").val();
		var penta1 = $("#penta1").val();
		var rota1 = $("#rota1").val();
		var opv1 = $("#opv1").val();
		var pcv1 = $("#pcv1").val();
		var penta2 = $("#penta2").val();
		var rota2 = $("#rota2").val();
		var opv2 = $("#opv2").val();
		var pcv2 = $("#pcv2").val();
		var penta3 = $("#penta3").val();
		var opv3 = $("#opv3").val();
		var pcv3 = $("#pcv3").val();
		var ipv = $("#ipv").val();
		var measles1 = $("#measles1").val();
		var measles2 = $("#measles2").val();

	if(dateofrefusal < bcg){
		$('#bcg').val('');
		document.getElementById("bcg").disabled = true;
	} else {
		$("#bcg").val();
		document.getElementById("bcg").disabled = false;
	}  
	if(dateofrefusal < opv0){
		$('#opv0').val('');
		document.getElementById("opv0").disabled = true;
	} else {
		$("#opv0").val();
		document.getElementById("opv0").disabled = false;
	} 
	if(dateofrefusal < hepb){
		$("#hepb").val('');
		document.getElementById("hepb").disabled = true;
	} else {
		$("#hepb").val();
		document.getElementById("hepb").disabled = false;
	}
	if(dateofrefusal < penta1){
		$("#penta1").val('');
		document.getElementById("penta1").disabled = true;
	} else {
		$("#penta1").val();
		document.getElementById("penta1").disabled = false;
	}
	if(dateofrefusal < rota1){
		$("#rota1").val('');
		document.getElementById("rota1").disabled = true;
	} else {
		$("#rota1").val();
		document.getElementById("rota1").disabled = false;
	}
	if(dateofrefusal < opv1){
		$("#opv1").val('');
		document.getElementById("opv1").disabled = true;
	} else {
		$("#opv1").val();
		document.getElementById("opv1").disabled = false;
	}
	if(dateofrefusal < pcv1){
		$("#pcv1").val('');
		document.getElementById("pcv1").disabled = true;
	} else {
		$("#pcv1").val();
		document.getElementById("pcv1").disabled = false;
	}
	if(dateofrefusal < penta2){
		$("#penta2").val('');
		document.getElementById("penta2").disabled = true;
	} else {
		$("#penta2").val();
		document.getElementById("penta2").disabled = false;
	}
	if(dateofrefusal < rota2){
		$("#rota2").val('');
		document.getElementById("rota2").disabled = true;
	} else {
		$("#rota2").val();
		document.getElementById("rota2").disabled = false;
	}
	if(dateofrefusal < opv2){
		$("#opv2").val('');
		document.getElementById("opv2").disabled = true;
	} else {
		$("#opv2").val();
		document.getElementById("opv2").disabled = false;
	}
	if(dateofrefusal < pcv2){
		$("#pcv2").val('');
		document.getElementById("pcv2").disabled = true;
	} else {
		$("#pcv2").val();
		document.getElementById("pcv2").disabled = false;
	}
	if(dateofrefusal < penta3){
		$("#penta3").val('');
		document.getElementById("penta3").disabled = true;
	} else {
		$("#penta3").val();
		document.getElementById("penta3").disabled = false;
	}
	if(dateofrefusal < opv3){
		$("#opv3").val('');
		document.getElementById("opv3").disabled = true;
	} else {
		$("#opv3").val();
		document.getElementById("opv3").disabled = false;
	}
	if(dateofrefusal < pcv3){
		$("#pcv3").val('');
		document.getElementById("pcv3").disabled = true;
	} else {
		$("#pcv3").val();
		document.getElementById("pcv3").disabled = false;
	}
	if(dateofrefusal < ipv){
		$("#ipv").val('');
		document.getElementById("ipv").disabled = true;
	} else {
		$("#ipv").val();
		document.getElementById("ipv").disabled = false;
	}
	if(dateofrefusal < measles1){
		$("#measles1").val('');
		document.getElementById("measles1").disabled = true;
	} else {
		$("#measles1").val();
		document.getElementById("measles1").disabled = false;
	}
	if(dateofrefusal < measles2){
		$("#measles2").val('');
		document.getElementById("measles2").disabled = true;
	} else {
		$("#measles2").val();
		document.getElementById("measles2").disabled = false;
	}
	
	
	}); 
	
//get district by provnice
$('#newprocode').on('change' , function (){
	var newprocode = this.value;
	var newtcode = "";
	$.ajax({
	type: "POST",
	data: "procode="+newprocode,
	url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceDistricts",
	success: function(result){
		$('#newdistcode').html(result);
	}
	});
});
//get tehsil by district
$('#newdistcode').on('change' , function (){
	var newdistcode = this.value;
	var newtcode = "";
	$.ajax({
    type: "POST",
    data: "distcode="+newdistcode,
    url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceTehsils",
	success: function(result){
      $('#newtcode').html(result);
    }
	});
});
//get unioncl by tehsil
 $('#newtcode').on('change' , function (){
	var newtcode = this.value;
	var newuncode = "";
	$.ajax({
    type: "POST",
    data: "tcode="+newtcode,
	url: "<?php echo base_url(); ?>Ajax_cross_notified/getOtherProvinceUCs",
    success: function(result){
      $('#newuncode').html(result);
    }
});
});
//get facility by uc
$('#newuncode').on('change' , function (){
	var newuncode = this.value;
	var newfacode = "";
	$.ajax({
	type: "POST",
	data: "uncode="+newuncode,
	url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
	success: function(result){
		$('#newfacode').html(result);
	}
	});
	//$('#newfacode').empty();
});
//get technician by HF
$('#newfacode').on('change' , function (){
	var newfacode = this.value;
	var dateofbirth = $("#dateofbirth").val();
	var year = dateofbirth.split("-", 1);
	var cardno = $("#cardno").val();
	var reg_no=newfacode+'-'+year+'-'+cardno;
	//alert(reg_no);
	var newtechniciancode = "";
	$.ajax({
		type: "POST",
		data: "facode="+newfacode,
		url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
		success: function(result){
			console.log(result);
			$('#techniciancode').html(result);
		}
	});
	$.ajax({
		type: "POST",
		data: "child_registration_no="+reg_no,
		url: "<?php echo base_url(); ?>Ajax_calls/CheckRegistrationNo",
		success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.child_registration_no!=''){
                 $("#cardno").html(data.child_registration_no);  
                 $('#site_response_cardno').css('display','block');
                 $('#site_response_cardno').css('color','red');
                 $("#site_response_cardno").html('Child Registration of this Card No and Facility Already Exist.');
                 $('#cardno').css('border-color','red');
                 $('#cardno').val('');
				 $('#newfacode').val('');
				 $('#techniciancode').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_response").html('');
            $('#site_response').css('display','block');
          }
        }
	});
	
});
//check father cnic already enter mothercnic
$(document).on('blur','#fathercnic', function(){
    var fathercnic = $(this).val();
	if(fathercnic!=''){
       $.ajax({ 
        type: 'POST',
        data: "fathercnic="+fathercnic,
        url: '<?php echo base_url();?>Ajax_calls/checkfatherNIC',
        //dataType: "json",
        success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.fathercnic!=''){
                 $("#fathercnic").html(data.fathercnic);  
                 $('#site_response').css('display','block');
                 $('#site_response').css('color','red');
                 $("#site_response").html('CNIC Already Exist For Father.');
                 $('#fathercnic').css('border-color','red');
                 $('#fathercnic').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_response").html('');
            $('#site_response').css('display','block');
          }
          }
       });
    } 
});
//check father cnic already enter mothercnic
$(document).on('blur','#mothercnic', function(){
    var mothercnic = $(this).val();
	if(mothercnic!=''){
       $.ajax({ 
        type: 'POST',
        data: "mothercnic="+mothercnic,
        url: '<?php echo base_url();?>Ajax_calls/checkmotherNIC',
        //dataType: "json",
        success: function(data){
          if(data != 0){
              var data = JSON.parse(data);
              console.log(data); 
              if(data.mothercnic!=''){
                 $("#mothercnic").html(data.mothercnic);  
                 $('#site_responsem').css('display','block');
                 $('#site_responsem').css('color','red');
                 $("#site_responsem").html('CNIC Already Exist For Mother.');
                 $('#mothercnic').css('border-color','red');
                 $('#mothercnic').val('');
              }
          }else{
            $('#nic').css('border-color','#66AFE9');
            $("#site_responsem").html('');
            $('#site_responsem').css('display','block');
          }
          }
       });
    } 
});	
//////////////////////////////////////////////////////////////////////////////////
///Code For Save Form With Control+S Event//////////////
	$(document).on('keydown', function(e){
		 if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
/////
	
	$("#fathercnic").inputmask({"mask": "99999-9999999-9"});
	$("#mothercnic").inputmask({"mask": "99999-9999999-9"});
	$("#contactno").inputmask({"mask": "9999-9999999"});
	
	
/* $(document).ready(function () {
		$("#fathercnic").inputmask({"mask": "99999-9999999-9"});
		$("#mothercnic").inputmask({"mask": "99999-9999999-9"});
		$("#contactno").inputmask({"mask": "9999-9999999"});
}); */
	});
	

</script>
		