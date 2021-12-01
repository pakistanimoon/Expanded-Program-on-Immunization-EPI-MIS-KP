
<?php if($this -> session -> flashdata('message')){  ?>
	<div class="row mb3">
		<div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
			<div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
		</div>
	</div>
<?php } ?>
<div class="container">
	<div class="row">
		<div class="panel panel-primary">
			<ol class="breadcrumb">
		<!-- <ul class="breadcrumb"><li><a href="http://epimis.kphealth.pk/">Home</a> <span class="divider"></span></li><li class="active">Facility Monthly Vaccination Reports</li></ul>
		-->		
		<ul class="breadcrumb">
			<li><a href="http://pace-tech.com/dev/epimis/">Home</a><span class="divider"></span></li>
			<li class="active"></li>
		</ul>
	</ol> 
	<div class="panel-heading">Supervisory Micro Plan
	</div>
	<div class="panel-body">
		<!--it is use for show message-->
		<form class="form-inline table-supervisor" method="post" action="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan_save"  >
			<div class="row">
				<div class="col-md-3">
					<label for="Supervisor_designation">Supervisor Designation</label>
				</div>
				<div class="col-md-3">
							<!--<select required class="form-control" id="supervisor_type" name="supervisor_type">
								<option value="">Select Supervisor Designation</option>
								<option value="EPI Coordinator">EPI Coordinator</option>
								<option value="District Superintendent Vaccinator" >District Superintendent Vaccinator</option>
								<option value="Assistant Superintendent Vaccinator">Assistant Superintendent Vaccinator</option>
								<option value="Tehsil Superintendent Vaccinator">Tehsil Superintendent Vaccinator</option>
								<option value="Field Superintendent Vaccinator">Field Superintendent Vaccinator</option>
							</select>-->
							<select required class="form-control" id="supervisor_type" name="supervisor_type">
								<option value="" >Select Supervisor Designation</option>
								<?php if(isset($result)) { ?> 
									<option value="" ></option>                       
								<?php }else{ echo get_Hr_Sub_type(true,2); } ?>
							</select>
						</div>
						<div class="col-md-3">

							<label for="Supervisor_Name">Supervisor Name</label>
							
						</div>
						<div class="col-md-3">

							<select required class="form-control" id="supervisor_name" name="supervisor_name">
								<option value="" >-Select-</option>
							</select>

						</div>
					</div>
					<div class="row">
						<div class="col-md-3">

							<label for="ReportYear">year</label>
						</div>

						<div class="col-md-3">

							<select required class="form-control" id="year_id" name="date_year">
								<?php if(isset($result)) { ?> 
									<option value="" ></option>                       
								<?php }else{ getAllYearsOptionsIncludingNext(); } ?>
							</select>

						</div>
					<!--<div class="col-md-3">
						
							<label for="MonthList">Month</label>
							
					</div>
					<div class="col-md-3">
						
							<select required class="form-control" id="month_id" name="date_month">
								<?php if(isset($result)) { ?> 
									<option value="" ></option>                       
								<?php }else{ getAllMonthsOptionsIncludingCurrent(); } ?>
							</select>
						
						</div>-->
						<div class="col-md-3">

							<label for="MonthList">Quarter</label>
							
						</div>
						<div class="col-md-3">
							<select class="form-control" name="quarter" id="quarter" required="required">
								<!--<option value="">-- Select --</option>-->
								<option value="01">Quarter 1</option>
								<option value="02">Quarter 2</option>
								<option value="03">Quarter 3</option>
								<option value="04">Quarter 4</option>
							</select>

						</div>

					</div>
					<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
						<thead>
							<tr>
								<th id="m1"  colspan="7" class="qtr">January</th>
								<input type="hidden" id="month1" name="monthm1"  value="" >
							</tr>
							<tr>
								<th>S.No.</th>
								<th>Union Council</th>
								<th>Session Type</th>
								<th>Village/HF name</th>
								<th>Date Visit Planned</th>
								<th>Remarks</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="trRow" >
							<tr>
								<td>
									<label class="srno-lbl" name="lb[]">1</label>

								</td>
								<td>
								<!-- <?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct uncode ,un_name,unname(uncode) as unioncouncil from unioncouncil where distcode='{$distcode}' order by un_name ASC";
									$result = $this->db->query($query)->result_array();
									?> -->
									<select class="form-control filter-status uncode" name="uncodem1[]" id="uncode">
										<?php echo getUCs_options();?>
									<!-- <option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['uncode']; ?>"><?php echo $value['unioncouncil']; ?></option>
									<?php } ?> -->
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm1[]">
									<option value ="" selected="selected">--Select--</option>
									<option value ="Fixed">Fixed</option>
									<option value="Outreach" >Outreach</option>
									<option value="Mobile" >Mobile</option>	
								</select>
							</td>
							<td class="tds">
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem1[]" >                      
									
								</select>
							</td>
							<td>
								<!-- <!	<input type="date" required class="form-control" id="visit_date" name="datedm1[]" > -->
								<input type="text" required class="form-control text-center calendar1" name="datedm1[]" id="visit_date[]" readonly>
							</td>
							<td>
								<input required type="text" class="form-control" id="remarks_id" placeholder="Remarks" name="remarksm1[]">
							</td>
							<td>
								<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
				<table id="newtradd1" class="table table-bordered table-hover table-sessiontype">
					<thead>
						<tr>
							<th colspan="7" class="qtr" id="m2">February</th>
							<input type="hidden" id="month2" name="monthm2"  value="" >
						</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Date Visit Planned</th>
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow1" >
						<tr>
							<td>
								<label class="srno-lbl" name="lb[]">1</label>
							</td>
							<td>
								<?php
								$distcode = $this-> session-> District; 
								$query="SELECT distinct uncode ,un_name,unname(uncode) as unioncouncil from unioncouncil where distcode='{$distcode}' order by un_name ASC";
								$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status uncode" name="uncodem2[]" id="uncode">
									<option value="">-- Select --</option>
									<?php foreach ($result as $key => $value) { ?>
										<option value="<?php echo $value['uncode']; ?>"><?php echo $value['unioncouncil']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm2[]">
									<option value ="" selected="selected">--Select--</option>
									<option value ="Fixed">Fixed</option>
									<option value="Outreach" >Outreach</option>
									<option value="Mobile" >Mobile</option>	
								</select>
							</td>
							<td class="tds">
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem2[]" >                      
									
								</select>
							</td>
							<td>
								<!-- <input type="date" required class="form-control" id="visit_date" name="datedm2[]" > -->
								<input type="text" required class="form-control text-center calendar2" name="datedm2[]" id="visit_date" readonly>
							</td>
							<td>
								<input required type="text" class="form-control" id="remarks_id" placeholder="Remarks" name="remarksm2[]">
							</td>
							<td>
								<button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							</td>
						</tr>
					</tbody>
				</table>	
				<table id="newtradd2" class="table table-bordered table-hover table-sessiontype">
					<thead>
						<tr>
							<th colspan="7" class="qtr" id="m3" style="border-right-color:black;">March</th>
							<input type="hidden" id="month3" name="monthm3"  value="" >
						</tr>
						<tr>
							<th>S.No.</th>
							<th>Union Council</th>
							<th>Session Type</th>
							<th>Village/HF name</th>
							<th>Date Visit Planned</th>
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow2" >
						<tr>
							<td>
								<label class="srno-lbl" name="lb[]">1</label>
							</td>
							<td>
								<?php
								$distcode = $this-> session-> District; 
								$query="SELECT distinct uncode ,un_name,unname(uncode) as unioncouncil from unioncouncil where distcode='{$distcode}' order by un_name ASC";
								$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status uncode" name="uncodem3[]" id="uncode">
									<option value="">-- Select --</option>
									<?php foreach ($result as $key => $value) { ?>
										<option value="<?php echo $value['uncode']; ?>"><?php echo $value['unioncouncil']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="sessionm3[]">
									<option value ="" selected="selected">--Select--</option>
									<option value ="Fixed">Fixed</option>
									<option value="Outreach" >Outreach</option>
									<option value="Mobile" >Mobile</option>	
								</select>
							</td>
							<td class="tds">
								<select class="form-control vilage_hf_name " required id="hf_id" name="vilage_hf_namem3[]" >                      
									
								</select>
							</td>
							<td>
								<!-- <input type="date" required class="form-control" id="visit_date" name="datedm3[]" > -->
								<input type="text" required class="form-control text-center calendar3" name="datedm3[]" id="visit_date" readonly>
							</td>
							<td>
								<input required type="text" class="form-control" id="remarks_id" placeholder="Remarks" name="remarksm3[]">
							</td>
							<td>
								<button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							</td>
						</tr>
					</tbody>
				</table>		
				<!--	<tbody id="">
						<tr class="hidden">
						
							<td><label class="srno-lbl" name="lb[]">1</label></td>
							<td>
								<select class="form-control session_type" required  id="session_type" name="session[]">
									
									<option value ="1">Fixed</option>
									<option value="2" >Out</option>
									
								</select>
							</td>
							<td class="tdv" style="display:none;">
								<input  type="text" class="form-control "  name="vilage_hf[]" id="vilage_name_id" placeholder="illage/HF Name" >
							</td >
								<td class="tds">
								<select class="form-control " id="hf_id" name="vilage_hf_name[]" >
									<?php if(isset($result)) { ?> 
										<option value="" ></option>                       
									<?php }else{ getFacilities_options(false); } ?>
								</select>
		                       </td>
                    		<td>
								<input type="date" required class="form-control" id="visit_date" name="dated[]" >
							</td>
							<td>
								<select required class="form-control conducted" name="conducted[]" >
									<option value="">--Select--</option>
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</td>
							
							<td>
								<input type="text" class="form-control" id="remarks_id" placeholder="Remarks" name="Remarks[]">
							</td>
							<td>
							<button onclick="addRow(this)" id="addButton1" type="button" class="plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							
								
							</td>
						</tr>
					</tbody> -->
					
					<!--</table>-->
				<!--<div class="form-group" style="display:block;">
					<label for="Percentage">
								Percentage supervisory visits conducted: (Number Conducted x 100 / Number Planned) = ________%
					</label>
				</div>-->
				
				<div class="form-group">
					<label for="Date">
						Date :
					</label>
				</div>
				<div class="form-group">
					<label for="Date" class="form-control">
						<script> document.write(new Date().toLocaleDateString()); </script>
					</label>
				</div>
				<div class="row">
					<div class="col-md-11">
						<div class="save_cancel">
							<button role="button" type="submit" id="save_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Save Form</button>
							<button role="button" type="submit" id="submit_form"><i class="fa fa-floppy-o" aria-hidden="true"></i>  Submit Form</button>
							<button type="reset" id="reset_form"><i class="fa fa-repeat" aria-hidden="true"></i>  Reset Form</button>
							<a href="<?php echo base_url();?>micro_plan/Micro_plan_controller/supervisory_plan">	<button type="button" id="form_cancel"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a>
						</div>
					</div>
				</div>
			</form>
			
		</div> <!--end of panel body-->
	</div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->
<script type="text/javascript">	
	$(document).ready(function(){
		$(document).on('change','#supervisor_type',function(){
			var $supervisor_type = $(this).val();
			if($supervisor_type=="")
				alert('You are entering Invalid Supervisor Type!');
			else{
				$.ajax({
					type:"POST",
					data:"hr_sub_type_id="+$supervisor_type,
					url:"<?php echo base_url(); ?>Ajax_calls/get_Hr_sub_type_option",
					success: function(result){
						var data = jQuery.parseJSON(result.trim());
						$('#supervisor_name').html(data);
					}
				});
			}
		});
	});

	$(document).on('change','#quarter', function(){	
		// All selected value is empty
		$('.calendar1').datepicker();  
		$('.calendar1').val("");
		$('.calendar2').datepicker();  
		$('.calendar2').val("");
		$('.calendar3').datepicker();  
		$('.calendar3').val("");
		///////////////////////////
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var quarter = this.value;
		var year = $('#year_id').val();
		if(quarter == 01){
			var month1 = '01';
			var month2 = '02';
			var month3 = '03';
		}if(quarter == 02){
			var month1 = '04';
			var month2 = '05';
			var month3 = '06';
		}if(quarter == 03){
			var month1 = '07';
			var month2 = '08';
			var month3 = '09';
		}if(quarter == 04){
			var month1 = '10';
			var month2 = '11';
			var month3 = '12';
		} 
		
		if(month1 != 0 ){
			var minDate =  new Date(year, month1-1, 1);
			var maxDate =  new Date(year, month1, 0);
			$('.calendar1').each(function(){	 
				$(this).datepicker('setStartDate', minDate); 
			});
			$('.calendar1').each(function(){
				$(this).datepicker('setEndDate', maxDate);
			});  		 
		}
		if(month2 != 0 ){
			var minDate =  new Date(year, month2-1, 1);
			var maxDate =  new Date(year, month2, 0);
			$('.calendar2').each(function(){ 
				$(this).datepicker('setStartDate', minDate);
			});	  
			$('.calendar2').each(function(){
				$(this).datepicker('setEndDate', maxDate);
			});
		}
		if(month3 != 0 ){
			var minDate =  new Date(year, month3-1, 1);
			var maxDate =  new Date(year, month3, 0);
			$('.calendar3').each(function(){
				$(this).datepicker('setStartDate', minDate);
			});	  
			$('.calendar3').each(function(){
				$(this).datepicker('setEndDate', maxDate);
			}); 
		} 	
	});  
////////////END//////////////////
////////////////this Ready function for 1st time page load datepicker/////////////////////////			

function dateBasedonQuarter(){	
		//alert('Test');
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var qua = $("#quarter").find("option:selected").val();
		var year = $("#year_id").find("option:selected").val();
		if(qua == 01){
			var month1 = '01';
			var month2 = '02';
			var month3 = '03';
		}else if(qua == 02){
			var month1 = '04';
			var month2 = '05';
			var month3 = '06';
		}else if(qua == 03){
			var month1 = '07';
			var month2 = '08';
			var month3 = '09';
		}else if(qua == 04){
			var month1 = '10';
			var month2 = '11';
			var month3 = '12';
		}
		console.log(qua);
		console.log(month1);
		console.log(month2);
		console.log(month3);
		if(month1 != 0 ){
			var minDate = new Date(year, month1-1, 1);
			var maxDate = new Date(year, month1, 0);
			$('.calendar1').each(function(){
				$('.calendar1').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate,
					autoclose:true
				});
			});
		}
		if(month2 != 0 ){

			var minDate = new Date(year, month2-1, 1);
			var maxDate = new Date(year, month2, 0);
			$('.calendar2').each(function(){
				$('.calendar2').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate
				});
			});
		}
		if(month3 != 0 ){

			var minDate = new Date(year, month3-1, 1);
			var maxDate = new Date(year, month3, 0);
			$('.calendar3').each(function(){
				$('.calendar3').datepicker({
					format : "yyyy-mm-dd",
					startDate: minDate,
					endDate: maxDate
				});
			});
		}				
	}
///////////////END////////////////////
///////////////Call on page load ////////////////////
$( function(){
	dateBasedonQuarter();
}); 
////////////finel//////////////////

function addRow(obj){
	var row = $(obj).closest("tr").clone();
	row.find('input').val('');
		//var lastRowIndex = $('#trRow').find('tr:last').index();
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('select').val('0');
		row.find("td:nth-child(3)").find('select').val('0');
		row.find("td:nth-child(4)").find('select').val('0');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').val('');
		$(obj).closest("#trRow").append(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted();
		
	}
	function deleteRow(obj) {
		var index = $('#trRow').find('tr:last').index();
		$(obj).closest("tr").remove();
		if(index=='1'){
			$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		reindex_serialnumber_and_trainingCompleted();
	}
	function addRow1(obj){
		var row = $(obj).closest("tr").clone();
		row.find('input').val('');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('select').val('0');
		row.find("td:nth-child(3)").find('select').val('0');
		row.find("td:nth-child(4)").find('select').val('0');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').val('');
		$(obj).closest("#trRow1").append(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow1').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted1();
		
	}
	function deleteRow1(obj) {
		var index = $('#trRow1').find('tr:last').index();
		$(obj).closest("tr").remove();
		if(index=='1'){
			$('#trRow1').find('tr:last').find('td:last').html('<button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow1').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow1(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow1(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		reindex_serialnumber_and_trainingCompleted1();
	}
	
	function addRow2(obj){
		var row = $(obj).closest("tr").clone();
		row.find('input').val('');
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('select').val('0');
		row.find("td:nth-child(3)").find('select').val('0');
		row.find("td:nth-child(4)").find('select').val('0');
		row.find("td:nth-child(5)").find('input').val('');
		row.find("td:nth-child(6)").find('input').val('');
		$(obj).closest("tr").after(row);
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></</button>');
		$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindex_serialnumber_and_trainingCompleted2();
	}
	
	function deleteRow2(obj) {
		var index = $('#trRow2').find('tr:last').index();
		$(obj).closest("tr").remove();
		if(index=='1'){
			$('#trRow2').find('tr:last').find('td:last').html('<button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow2').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow2(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow2(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		reindex_serialnumber_and_trainingCompleted2();
	} 
	//sessiontypem1
	function reindex_serialnumber_and_trainingCompleted(){
		$('#trRow > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem1['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm1['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem1['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm1['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm1['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('id','remarks_id'+i);
		});
		dateBasedonQuarter();
	}
	function reindex_serialnumber_and_trainingCompleted1(){
		$('#trRow1 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem2['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm2['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem2['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm2['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('id','visit_date2'+i);
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm2['+i+']');
		});
		dateBasedonQuarter();
	}
	function reindex_serialnumber_and_trainingCompleted2(){
		$('#trRow2 > tr').each(function(i,k){
			$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
			$(this).find("td:nth-child(2)").find('select').attr('name','uncodem3['+i+']');
			$(this).find("td:nth-child(3)").find('select').attr('name','sessionm3['+i+']');
			//$(this).find("td:nth-child(3)").find('select').attr('name','facodem3['+i+']');
			$(this).find("td:nth-child(4)").find('select').attr('name','vilage_hf_namem3['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','datedm3['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('id','visit_date3'+i);
			$(this).find("td:nth-child(6)").find('input').attr('name','remarksm3['+i+']');
		});
		dateBasedonQuarter();
	}
	$(document).on('change','.session_type',function(){
			// alert('abs');
			var sessiontype = this.value;
			var uncode= $(this).closest('tr').find('.uncode').val();
			var selectedobj = $(this);
			// alert(sessiontype);
			//alert(uncode);
			$.ajax({
				type: "POST",
				data: "sessiontype="+sessiontype+"&uncode="+uncode,
				url: "<?php echo base_url(); ?>Ajax_calls/getred_rec_village",
				success: function(result){
					$(selectedobj).closest("tr").find("td:nth-child(4)").find('select').html(result);					
				}
			});
		});
//28-3-2019
$(document).ready(function(){
	var quarter = this.value;
	$('#m1').text('January').attr('month','01');
	$('#m2').text('February').attr('month','02');
	$('#m3').text('March').attr('month','03');
	$('#month1').val('01');
	$('#month2').val('02');
	$('#month3').val('03');
});      
$(document).on('change','#quarter', function(){
	var quarter = this.value;
		//alert(quarter);
		if(quarter == 1){
			$('#m1').text('January').attr('month','01');
			$('#m2').text('February').attr('month','02');
			$('#m3').text('March').attr('month','03');
			$('#month1').val('01');
			$('#month2').val('02');
			$('#month3').val('03');
		}else if(quarter == 2){
			$('#m1').text('April').attr('month','04');
			$('#m2').text('May').attr('month','05');
			$('#m3').text('June').attr('month','06');
			$('#month1').val('04');
			$('#month2').val('05');
			$('#month3').val('06');
		}else if(quarter == 3){
			$('#m1').text('July').attr('month','07');
			$('#m2').text('August').attr('month','08');
			$('#m3').text('September').attr('month','09');
			$('#month1').val('07');
			$('#month2').val('08');
			$('#month3').val('09');
		}else if(quarter == 4){
			$('#m1').text('October').attr('month','10');
			$('#m2').text('November').attr('month','11');
			$('#m3').text('December').attr('month','12');
			$('#month1').val('10');
			$('#month2').val('11');
			$('#month3').val('12');
		}else{				
			if(qua == 1){
				$('#m1').text('January').attr('month','01');
				$('#m2').text('February').attr('month','02');
				$('#m3').text('March').attr('month','03');
				$('#month1').val('01');
				$('#month2').val('02');
				$('#month3').val('03');

			}else if(qua == 2){
				$('#m1').text('April').attr('month','04');
				$('#m2').text('May').attr('month','05');
				$('#m3').text('June').attr('month','06');
				$('#month1').val('04');
				$('#month2').val('05');
				$('#month3').val('06');
			}else if(qua == 3){
				$('#m1').text('July').attr('month','07');
				$('#m2').text('August').attr('month','08');
				$('#m3').text('September').attr('month','09');
				$('#month1').val('07');
				$('#month2').val('08');
				$('#month3').val('09');
			}else if(qua == 4){
				$('#m1').text('October').attr('month','10');
				$('#m2').text('November').attr('month','11');
				$('#m3').text('December').attr('month','12');
				$('#month1').val('10');
				$('#month2').val('11');
				$('#month3').val('12');
			}
		}
	});		
</script>



</body>
</html>