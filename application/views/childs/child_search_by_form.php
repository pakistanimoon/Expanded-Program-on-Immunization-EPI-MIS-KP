<?php 
	//print_r($_GET);exit(); //echo "<pre>";print_r($startpoint);exit; //kp local
	//$asdd = $_GET['uncode']; working
	/*  echo $_GET['uncode']; 
	echo "<br>"; */
	//print_r($paginationss);
	if($this->input->get('givename')){
		$vaccinesArray = array();
		$vaccinesArray = $vaccinesString = $this->input->get('givename');		
		$vaccinesArray = array_flip($vaccinesArray);
		$vaccinesString = implode(',', $vaccinesString);
		// echo "abccccccccccccccccccccccccccccc   ";
		// print_r($vaccinesArray); exit();
	}
?>
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
			<div class="panel-heading"> List of Vaccinated Child </div><br>
			<div class="row" style="width:100%; padding:4px 17px">
				<form method="get" id="filter-form" multiple action="<?php echo base_url('childs/Reports_list/child_search_by_form'); ?>">					
					<?php
					//echo $_GET['tcode']; exit;
					?>
					<div class="col-md-2">
						<label>Tehsil:</label>
					</div>
					<div class="col-md-2">
						<select class="form-control filter-status tcode" name="tcode" id="tcodeQ">
						<?php echo getTehsils_options(false,$_GET['tcode'],$this->session->District); ?>
						
						</select>
					</div>
					
					<div class="col-md-2">
						<label>Union Council:</label>
					</div>
					<div class="col-md-2">
						<select class="form-control filter-status" name="uncode" id="uncode">
							<?php echo getUCs_options(false,$_GET['uncode'],$_GET['tcode']); ?>
							<!-- <option select id='asdd' value='2'><php echo 'aaaa'; ?></option> -->
						</select>
					</div>						
					<div class="col-md-2">
						<label>Facilities</label>
					</div>						
					<div class="col-md-2">
						<select class="form-control filter-status" name="abc_facode" id="facode">
							<?php echo getFacilities_options(false, $_GET['abc_facode'], $_GET['uncode']); ?>
						</select>							
		  			</div>		
					<div class="col-md-2">
						<label>Village/Mohallah:</label>
					</div>
					<div class="col-md-2">
						<select class="form-control filter-status" name="villagemohallah" id="village">
							<?php echo getVillage_options(false, $_GET['villagemohallah'], $_GET['uncode']); ?>
						</select>							
					</div>					
					<div class="col-md-2">
						<label>Technician</label>
					</div>						
					<div class="col-md-2">
						<select class="form-control filter-status" name="techniciancode" id="techniciancode">
							<?php echo get_Technician_options(false,$_GET['techniciancode'],$_GET['abc_facode']); ?>
						</select>
					</div>					
					<div class="col-md-2">
						<label>Child Name</label>
					</div>
					<div class="col-md-2">
						<input class="form-control" placeholder = "Child Name" name="child_name" id="child_name" value = "<?php echo $_GET['child_name']; ?>">
					</div>
					<div class="col-md-2">
						<label>Child Card Number</label>
					</div>
					<div class="col-md-2">
						<input type="number" class="form-control" placeholder = "Child Card Number" name="childcardnbr" id="childcardnbr" value = "<?php echo $_GET['childcardnbr']; ?>">
					</div>
					<div class="col-md-2">
						<label>Father Name</label>
					</div>
					<div class="col-md-2">
						<input class="form-control" placeholder = "Father Name" name="fathername" id="fathername" value="<?php echo (isset($_GET['fathername']))?$_GET['fathername']:''; ?>">
					</div>
					<div class="col-md-2">
						<label>Date Of Birth from</label>
					</div>
					<div class="col-md-2">
						<input class="form-control"placeholder="yyyy-mm-dd" class="month_year form-control " type="text" data-date-format="yyy-mm-dd" name="dateofbirth" id="dateofbirth" readonly = "" value = "<?php echo $_GET['dateofbirth']; ?>">
					</div>
					<div class="col-md-2">
						<label>Date Of Birth to</label>
					</div>
					<div class="col-md-2">
						<input class="form-control"placeholder="yyyy-mm-dd" class="month_year form-control " type="text" data-date-format="yyy-mm-dd" name="dateofbirthto" id="dateofbirthto" readonly= "" value = "<?php echo (isset($_GET['dateofbirthto']))?$_GET['dateofbirthto']:''; ?>">
						 <?php //echo (isset($_GET['dateofbirthto']))?$_GET['dateofbirthto']:'';?>
					</div>
					<div class="col-md-2">
						<label>Mobile Number</label>
					</div>
					<div class="col-md-2">
						<input class="form-control" placeholder = "Mobile Number" name="contactno" id="contactno" value = "<?php echo $_GET['contactno']; ?>">
					</div> 
					<div class="col-md-2">
						<label>CNIC</label>
					</div>
					<div class="col-md-2">
						<input class="form-control" placeholder = "CNIC Number" name="fathercnic" id="fathercnic" value = "<?php echo $_GET['fathercnic']; ?>">
					</div>
					<div class="col-md-2">
						<label>Gender</label>
					</div>
					<div class="col-md-2 asd">
						<select class="form-control gender" name="gender" id="gender">
							<?php 
								if($_GET['gender'] == 'm'){
									?>
									<option value="m"> Male </option>
									<option value="f"> Female </option>
									<option value=""> -- Select Gender -- </option>
								<?php } else if($_GET['gender'] == 'f'){ ?>
									<option value="f"> Female </option>
									<option value="m"> Male </option>
									<option value=""> -- Select Gender -- </option>
								<?php } else { ?>
									<option value=""> -- Select Gender -- </option>
									<option value="m"> Male </option>
									<option value="f"> Female </option>						  
							<?php } ?>
						</select>
					</div>
					<div class="col-md-2">
						<label>Select Vaccine</label>
			  		</div>
	  				<div class="col-md-2">
						<select name="givename[]" id="givename" class="form-control multiselect" >
							<option value="">--None Selected--</option>  
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("bcg", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="bcg">bcg</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("hepb", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="hepb">hepb</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("opv0", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="opv0">opv0</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("opv1", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="opv1">opv1</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("opv2", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="opv2">opv2</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("opv3", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="opv3">opv3</option>

							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("penta1", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="penta1">penta1</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("penta2", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="penta2">penta2</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("penta3", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="penta3">penta3</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("pcv1", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="pcv1">pcv1</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("pcv2", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="pcv2">pcv2</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("pcv3", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="pcv3">pcv3</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("ipv", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="ipv">ipv</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("rota1", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="rota1">rota1</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("rota2", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="rota2">rota2</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("measles1", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="measles1">measles1</option>
							<option <?php if(isset($vaccinesArray)){ if(array_key_exists("measles2", $vaccinesArray)){ echo 'selected="selected" class="active"'; } } ?> value="measles2">measles2</option>
						</select>
					</div>
					<div class="col-md-2" style="float: right;margin-top: 23px;">
						<label><button class="btn btn-success px-4 py-3 mt-3"><a  style="color:white" href="<?php echo base_url('Reports/ChildRegistrationList'); ?>">Back</a></button></label>
						<label><button id="submit2" class="btn btn-success px-4 py-3 mt-3">Search</button></label>
					</div>
				</form>
			</div>
		</div>
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
						<th class="text-center Heading">Card No</th>
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
				<tbody>
					<label for="pets">Choose your pets:</label>
						<select id="pets" multiple="multiple">
						<option value="dog">Dog</option>
						<option value="cat">Cat</option>
						<option value="rabbit">Rabbit</option>
						<option value="parrot">Parrot</option>
					</select>
					<button id="submit">Get Selected Values</button>
					<?php
						/* echo '<br>';
						print_r($data);		 
						echo '<br>';
						//if ($data[] == '' ) {
							echo 'if';
						*/
						if(! empty($data)){				
							$i=$startpoint+1;
							foreach($data as $key => $value){
								echo "<tr><td>". $i ."</td>";
								echo "<td>". $value['cardno'] ."</td>";
								echo "<td>". $value['nameofchild'] ."</td>";
								echo "<td>". $value['dateofbirth'] ."</td>";
								echo "<td>". $value['fathername'] ."</td>";
								//echo "<td>". $value['distcode'] ."</td>";
								echo "<td>". get_Tehsil_Name($value['tcode']) ."</td>";
								echo "<td>". get_UC_Name($value['uncode']) ."</td>";
								echo "<td>". $value['address'] ."</td>";
							?>
							<td>
								<a data-original-title='Edit' href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/<?php echo $value['recno']; ?>"data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a>
								
								<a data-original-title='View' href="<?php echo base_url(); ?>Reports/ChildRegistrationView/<?php echo $value['recno']; ?>"data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>
							</td>
						<?php $i++; echo "</tr>";
						}  
						} else {
							echo "<tr><td colspan='9'> Sorry, No Record Found </td></tr>"; 
					} ?>
				</tbody>
			</table>
			<?php echo "<h6>". $paginationss ."</h6>"; ?>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link   href="<?php echo base_url(); ?>includes/css/bootstrap-multiselect.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">

// document.getElementById('submit2').onclick = function() {
//   var selected = [];
//   for (var option of document.getElementById('givename').options) {
//     if (option.selected) {
//       selected.push(option.value);
//     }
//   }
//   var asd = [];
//   //alert(selected);
//  // $( ".kkk" ).load(function() {
//   asd = selected;
//   var aaa = $('#givename').val();
//   alert(aaa);
//   alert(asd);
// //});
// }



$(document).ready(function() { 
 	$.fn.dataTable.ext.errMode = 'none';
	
	var DOBT = $("#dateofbirthto").val();
		if(DOBT !=""){
			$("#dateofbirthto").val();
		}else{
			//document.getElementById("dateofbirthto").disabled = true;
		}
			
	//if($("#dateofbirthto") > 0){
		
	//}
		//$("#dateofbirthto").val();
	//document.getElementById("dateofbirthto").disabled = true;
	$('#dateofbirth').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e) {
		var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#dateofbirthto').datepicker('setStartDate', minDate);
		//document.getElementById("dateofbirthto").disabled = false;
		$("#dateofbirthto").val('');
	})
	
	var asdd = $('#asdd').find('select').trigger('change');
	//alert(asdd);

	$('#dateofbirthto').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	}).on('changeDate', function(e){
		
		var dateofbirthf = $('#dateofbirth').val();
		var dateofbirths = $('#dateofbirthto').val();
		//alert(dateofbirthf);
		if(dateofbirthf == ""){
			alert('Kindly select Date Of Birth from first');
			$("#dateofbirthto").val('');
		}
		
		if( dateofbirthf > dateofbirths ){
			alert('Date Of Birth to, must be greater than, Date Of Birth from');
			$("#dateofbirthto").val('');
		}else{
			//alert('else');
		}
		/* var dp = $(e.currentTarget).data('datepicker');
		var minDate = new Date(e.date.valueOf());
		$('#dateofbirth').datepicker('setStartDate', minDate);
		document.getElementById("dateofbirthto").disabled = false;
		alert('a');  */
		
	})
	
	
	$('#bcg').datepicker({
		"format": "yyyy-mm-dd",
		'startView': 2,
		'autoclose': true,
		'endDate' : Date(),
	})
	
	
/*	
	////
	
	function isreply(letterid){
			var req_res = false;
			$.ajax({
				type: "GET",
				data: {id:letterid},
				async: false,
				url: "<?php echo base_url(); ?>admin/SupportPlan_Config/checkForLetterReply",
				success: function(result){
					req_res = result;
				}
			});
			return req_res;
		}
		
		function hasreply(letterid){
			var req_response = false;
			$.ajax({
				type: "GET",
				data: {ajax_request:1},
				async: false,
				url: "<?php echo base_url(); ?>admin/SupportPlan_Config/checkIfLetterHasResponse/"+letterid,
				success: function(result){
					console.log(result)
					req_response = result;
				}
			});
			return req_response;
		}
		
	////
		var childsearchtable = [
			{ data: "serial" ,"sClass":"center",
				orderable: false,
			},
			{ data: "cardno"},
			{ data: "nameofchild"},
			{ data: "dateofbirth"},
			{ data: "fathername"},
			{ data: "tcode"},
			{ data: "uncode"},
			{ data: "address" },
			{ data: "recno" ,"sClass":"custom-space",
				orderable: false,
				render : function(data, type, row) 
					{
						return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/ChildRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'

					}
			},
		]; 
		var table = $('#cerv_child_registration').DataTable(
		{	
			"pageLength" : 10,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "asc" ] 
			],
			"ajax": {
				url : "<?php echo base_url(); ?>childs/Reports_list/child_vaccinated_search",
				type : 'GET'
			},
			"columns": childsearchtable,
			dom: 'lrtips',
				"fnDrawCallback": function(oSettings) {
					if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
						$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
					}
				}
		});
		/* $('#child_name,#fathername').on('keyup change', function () {

			table.search( this.value ).draw();  

		});*/
		$("#fathercnic").inputmask({"mask": "99999-9999999-9"});
		$("#contactno").inputmask({"mask": "9999-9999999"});
		

		//$("#childcardnbr").inputmask({"mask": "99999999999"});
	}); 
	/*
	$('#child_name,#childcardnbr,#fathername,#mobilenbr,#cnicnbr,#bcg,#dateofbirth,#gender').on('change', function () {
		
		var childname    = $("#child_name").val();
		var childcardnbr = $("#childcardnbr").val();
		var fathername   = $("#fathername").val();
		var mobilenbr    = $('#mobilenbr').val();
		var cnicnbr      = $('#cnicnbr').val();
		var bcg  		 = $('#bcg').val();
		var dateofbirth  = $('#dateofbirth').val();
		var gender       = $('#gender').val();
		var tcode        = $('#tcode').val();
		var uncode		= $('#uncode').val();
		var facode		= $('#facode').val();
		var village		= $('#village').val();
		var techniciancode = $('#techniciancode').val();
		$.ajax({
			type: "POST", 
			data: {"nameofchild":childname, "fathername":fathername, "mobilenbr":mobilenbr, "cnicnbr":cnicnbr, "childcardnbr":childcardnbr, "bcg":bcg, "dateofbirth":dateofbirth, "gender":gender, "tcode":tcode, "uncode":uncode, "facode":facode, "village":village, "techniciancode":techniciancode},
			//data: "nameofchild="+childname,
			url: "<?php echo base_url(); ?>childs/Reports_list/child_search",
			success: function(result){
				//console.log(result);
				var result = JSON.parse(result);
				var number = 1;
			row = "";
			$.each(result, function(i, obj){
				row +='<tr><td><span>'+number+'</span></td>';
				row +="<td><span>"+obj.cardno+"</span></td>";
				row +="<td><span>"+obj.nameofchild+"</span></td>";
				row +="<td><span>"+obj.dateofbirth+"</span></td>";
				row +="<td><span>"+obj.fathername+"</span></td>";
				row +="<td><span>"+obj.tcode+"</span></td>";
				row +="<td><span>"+obj.uncode+"</span></td>";
				row +="<td><span>"+obj.address+"</span></td>";
				row +="<td><span><a id='edit_button' data-original-title='Edit'  data-toggle='tooltip' class='btn btn-xs btn-default editData edit' href=<?php echo base_url(); ?>Reports/ChildRegistrationEdit/"+obj.recno+"><i class='fas fa-edit text-white'></i></span></a><span><a  id='edit_button' data-original-title='View'  data-toggle='tooltip' class='btn btn-xs btn-default view' href=<?php echo base_url(); ?>Reports/ChildRegistrationView/"+obj.recno+"><i class='fa fa-eye text-white'></i></span></a></td></tr>";
				number++;
				
				//row +="<td><span>"+obj.address+"</span></td>";
				
				
				//console.log(number);
				$('#tbody').html(row);
			});
		}
	});
});

		$(function () {
			$('.footable').DataTable({
			"paging":   false
		});
	});
		 
	$('.filter-status').on('change' , function (){
		$('#tbody').html('');
		$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
		var page = $(this).attr("id"); //get page number from link
		//alert(serialize());
		$.ajax({
			type: "GET",
			data: $('#filter-form').serialize(),
			dataType: "json",
			url: "<?php echo base_url(); ?>Ajax_calls/child_list_filter",
			success: function(result){
				console.log(result);
				$('#tbody').html('');
				if(result != null){
					$("#filter").val('');
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			}
		});
	});
	 */
	 $(document).on('change','#tcodeQ', function(){
		var tcode = this.value;
		$('#facode').html('');
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
					$('#uncode').trigger('change');
				}
			});
		}
		else{
			$('#uncode').html('');
			$('#facode').html('');
			//it doesn't exist
		}
						
	});
	$('#facode').on('change' , function (){
			var facode = this.value;
		if(facode !=""){
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getcerv_villages",
				success: function(result){
					//console.log(result)
				$('#village').html(result);
				}
			});
		}
	}); 
		
	$('#facode').on('change' , function (){
			var facode = this.value;
		if(facode !=""){
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getFacilityTechnicians",
				success: function(result){
					//console.log(result)
				$('#techniciancode').html(result);
				}
			});
		}
	});
	//selectedOptions = '<?php //echo $measles_Result->type_specimen; ?>';
	$("#givename").multiselect('destroy');
	document.getElementById("givename").setAttribute("multiple", "multiple");
	
	$('#givename').multiselect({
		includeSelectAllOption: true,
		buttonClass: 'form-control vaccinesButton',
		buttonWidth: '177px'// here you need to specify width value
	});
	
	$('.vaccinesButton').on('click', function() {
        $('#givename').multiselect('rebuild');
    });
	// $('#submit2').on('click', function (){
	// 	//$('#submit2').text(selectedOptions);
	// 	//alert("abc");
	// 	var selectedOptions    = $("#givename").val();
	// 	//var selectedOptions = selectedOptions.split(',');
	// 	//alert(selectedOptions);
	// 	//console.log(selectedOptions);		
	// 	for(var i in selectedOptions) {
	// 	    var optionVal = selectedOptions[i];	
	// 	    //alert(optionVal);
	// 	    $("#givename option[value='"+optionVal+"']").prop('selected', true);
	// 	}
	// });
	<?php if($this->input->get('givename')) { ?>
		//$('#submit2').text(selectedOptions);
		//alert("abc");
		selectedOptions = '<?php echo $vaccinesString; ?>';
		$('.vaccinesButton').text(selectedOptions);
		var selectedOptions = selectedOptions.split(",");

		for(var i in selectedOptions) {
		    var optionVal = selectedOptions[i];	
		    //alert(optionVal);
		    $("#givename option[value='"+optionVal+"']").prop('selected', true);
		}	
	<?php } else { ?>
		$('#givename').multiselect("deselectAll", false).multiselect("refresh");
	<?php }?>
	$('#givename').change(function(){
		selectedOptions = $(this).val();
		$('.vaccinesButton').text(selectedOptions);
	});
	// $('.vaccinesButton').text(selectedOptions);
	// var selectedOptions = selectedOptions.split(",");
	// //alert(selectedOptions);
	
	// for(var i in selectedOptions) {
	//     var optionVal = selectedOptions[i];	
	//     //alert(optionVal);
	//     $("#givename option[value='"+optionVal+"']").prop('selected', true);
	// }
	/* 
	$('#givename').change(function(){
		//alert($(this).val());
		var bcg = $("#givename").val();
				alert(bcg);
	}) */ // 

	/*  $(function(){

		//change to two ? how?

		$('.gender').change(function(){
			var data= $(this).val();
			//alert(data);            
		});

		$('.gender')
		.val('f')
		.trigger('change');
	});  */


/* $('.givename').change(function () {       
         switch ($('[name=bcg]').val()) {
             case "1":
                 $('[name=hepb]').val(["Multiple"]);
                 break;
             case "2":
                 $('[name=multiple]').val(["Multiple2"]);
                 break;
             case "3":
                 $('[name=multiple]').val(["Multiple3"]);
                 break;
         }
		  */
		/*  function getComboA(selectObject) {
		  var value = selectObject.value;  
		  console.log(value);
		} */
</script>