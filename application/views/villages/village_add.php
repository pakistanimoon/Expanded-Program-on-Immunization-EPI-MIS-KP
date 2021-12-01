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
    	<div class="panel-heading">Add New Village/Mohalla</div>
  	  	<div class="panel-body">
    	   <form name="dataform" id="dataform" action="<?php echo base_url();?>Villages/village_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<div class="row">
	    		   <div class="form-group">
	    		   	<input type="hidden" name="added_date" id="added_date" value="<?php echo $current_date; ?>" class="form-control">
					  	<label class="col-xs-2 col-xs-offset-1 control-label">District:</label>
						<div class="col-xs-3">
							 <?php 
								$distcode = $this-> session-> District;
								echo get_District_Name($distcode); 
							?> 
							<input type="hidden" name="distcode" value="<?php echo $distcode; ?>">							
							<input type="hidden" id="setSelect" name="setSelect" value="No">							
						</div>
						<label class="col-xs-2 control-label">Tehsil:</label>
						<div class="col-xs-3">
							<select class="form-control" name="tcode" id="tcode" required="required">
								<option value="">--Select-- </option>
								<?php echo getTehsils($distcode); ?>
							</select>							
						</div>
  					  
				   </div>
				</div>
				<div class="row">
					<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label">Union Council:</label>
							<div class="col-xs-3">
								<select name="uncode" id="uncode" required="required" class="form-control">
									<option></option>
								</select>
							</div>
							<!--<label class="col-xs-2 control-label">Facility Name:</label>
						  	<div class="col-xs-3">
							 	<select name="facode" id="facode"  class="form-control">
									<option></option>
								</select>
						  	</div>-->				
					</div>
				</div>
				<!--<div class="row">
					<div class="form-group">-->
							<!--<label class="col-xs-2 col-xs-offset-1 control-label">Year:</label>
							<div class="col-xs-3">
								<select name="year" id="year" required="required" class="form-control">
									<?php // echo getAllYearsOptionsIncludingCurrent(); ?>
								</select>
							</div>-->
							<!--<label class="col-xs-2 col-xs-offset-1 control-label">Village/Mohalla Name:</label>
						  	<div class="col-xs-3">
							 	<input required="required" name="village_name" id="village_name" placeholder="Village/Mohalla Name" class="form-control" class="form-control">
						  	</div>
								<label class="col-xs-2  control-label">Village/Mohalla Code:</label>
							<div class="col-xs-3">
								<input name="vcode" id="vcode" placeholder="Village/Mohalla Code" class="form-control text-center" readonly="readonly" required="required" >
							</div>
					</div>
				</div>
				<div class="row">
	    		   <div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label">Postal Address::</label>
					  	<div class="col-xs-3">
							<input  name="postal_address" id="postal_address" placeholder="Postal Office" class="form-control" class="form-control">
					  	</div>
				   </div>
				</div>-->		
			<!--	<div class="row">
	    		   <div class="form-group">
	    		   	<label class="col-xs-2 col-xs-offset-1 control-label">Postal Address:</label>
					  	<div class="col-xs-3">
							<input  name="postal_address" id="postal_address" placeholder="Postal Office" class="form-control" class="form-control">
					  	</div>
				   </div>
				</div>	-->				
				<hr>
				<table style="display:none;" id="records_table" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
						
						<thead>
							<tr>
								<th colspan="4">Existing Villages</th>
							</tr>
							<tr>
								<th>Village Name</th>
								<th>Facility Name</th>
								<th>Current Year Population </th>
								<th>Postal Office</th>
							</tr>
						</thead>
						<tbody id="tbody"></tbody>
				</table>
				<table id="newtradd" class="table table-bordered table-hover table-sessiontype">
					<tr class="procceed" id="procceed-1"  style="position:absolute;width:80.5%;background:#b2b9c8b3 !important;color:white;">
						<td colspan="20" style="display:inherit;text-align:center;height:50px;"><span class="showviilage" style="position: relative;top: -5px;font-size:35px;">Select Above Dropdown To Proceed</span></td>
					</tr>
					<thead>
						<tr>
							<th colspan="6">Add Villages</th>
						</tr>
						<tr>
							<th>S.No.</th>
							<th>Village Name</th>
							<th>Facility Name</th>
							<th>Current Year Population</th>
							<th>Postal Office</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="trRow" >
						<tr>
							<td>
								<label class="srno-lbl" name="lb[]">1</label>
							</td>
							<td>
								<input type="text" required class="form-control text-center" name="village[]" id="village[]" placeholder="Village Name">
							</td>
							<td>
								<select name="facode[]" id="facode"  class="form-control" required>
									<option></option>
								</select>
							</td>
							<td>
								<input type="text" required class="form-control text-center population" id="population" name="population[]" id="population[]" placeholder="Population">
							</td>
							<td>
								<input required type="text" class="form-control" id="postal_address" placeholder="Postal Office" name="postal_address[]">
							</td>
							<td>
								<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="row">
					<div class="col-xs-7" style="margin-left:78.5%;" >
						<button id="submit" type="submit" value="1" name="submit" class="btn btn-md btn-success" disabled="disabled"><i class="fa fa-floppy-o"></i> Save Form </button>
						<a href="<?php echo base_url();?>Village-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
				</div>
			</form>			
  		</div> <!--end of panel body-->
 	</div> <!--end of panel panel-primary-->
</div><!--end of row-->	
</div><!--End of page content or body contaier-->

<script  type="text/javascript">
	$(window).on('load', function() {
		if($('#tcode :selected').val() == '0'){
			$('#tcode :selected').val('');
		}
	});
	$(document).on('keyup','#population', function(){
		var population = $('#population').val();		
		var population1 =(0.0353*population);
		population1 =Math.ceil(0.942*population1);
		$("#population_less_year").val(population1);
	}); 
	function checkCode(num) {
		var regexp = /[0-9]{2}/;
		var valid = regexp.test(num);
		return valid;
	}
	/* $('#village_name').on('blur' , function (){
		var uncode = $('#uncode').val();
		
			$.ajax({
			type: "GET",
			data: "uncode="+uncode,
			
			url: "<?php echo base_url();?>Ajax_red_rec/generateCode",
			success: function(result){
				$('#vcode').val(result);
				
			}
			
		});
	}); */
	$(document).on('change', '#uncode', function(){
		var uncode = this.value;
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			
			url: "<?php echo base_url();?>Villages/village_get_record",
			success: function(response){
				response = $.parseJSON(response);
				console.log(response);
				if(uncode==""){
					$("#submit").attr('disabled','disabled');
				}else{
					if(response.length==""){
						$("#records_table").hide();
					}else{ 
						$("#records_table").show();
						$("#tbody").empty();
						var trHTML = '';
						$.each(response, function (i, item) {
							if(item.facode==null){
								item.facode='';
							}else{
								item.facode=item.facode;
							}
							if(item.current_population==null){
								item.current_population='';
							}else{
								item.current_population=item.current_population;
							}
							trHTML += '<tr><td>' + item.village + '</td><td>' + item.facode + '</td><td>' + item.current_population+ '</td><td>' + item.postal_address + '</td></tr>';
							});
						$('#records_table').append(trHTML);
						$("#submit").removeAttr('disabled');
						$(".procceed").removeAttr("style");
						$(".showviilage").hide();
					}
				}	
			}
		});
	});
	$(document).on('change', '#uncode', function(){
		var uncode = this.value;
		
			
	});
	$(document).on('change', '#uncode', function(){
		var uncode = this.value;
		if(uncode != ""){
			$('#vcode').val('');
			$('#village_name').val('');
		}		
	});
function addRow(obj){
	var row = $(obj).closest("tr").clone();
	row.find('input').val('');
		//var lastRowIndex = $('#trRow').find('tr:last').index();
		row.find("td:nth-child(1)").find('label').val('');
		row.find("td:nth-child(2)").find('input').val('');
		row.find("td:nth-child(3)").find('select').val('0');
		row.find("td:nth-child(4)").find('input').val('');
		row.find("td:nth-child(5)").find('input').val('');
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
function reindex_serialnumber_and_trainingCompleted(){
	$('#trRow > tr').each(function(i,k){
		$(this).find("td:nth-child(1)").find('label').text(''+(i+1)+'');
		$(this).find("td:nth-child(2)").find('input').attr('name','village['+i+']');
		$(this).find("td:nth-child(3)").find('select').attr('name','facode['+i+']');
		$(this).find("td:nth-child(4)").find('input').attr('name','population['+i+']');
		$(this).find("td:nth-child(5)").find('input').attr('name','postal_address['+i+']');
	});
}
</script>