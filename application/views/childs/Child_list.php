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
					<form method="post" id="filter-form">
						<!---<div class="col-md-2 col-md-offset-1">
								<label>Province:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="province" id="province">
								<option><?php //echo get_Province_Name($this->session->Province); ?></option>
							</select>
						</div>
						<div class="col-md-2 col-md-offset-1">
							<label>District:</label>
						</div>
						<div class="col-md-3">
							<select class="form-control" name="district" id="district">
								<?php //echo getDistricts_options($this->session->district); ?>
							</select>
						</div> ----->
						<div class="col-md-2">
							<label>Tehsil:</label>
						</div>
						<div class="col-md-2">
							<select class="form-control filter-status" name="tcode" id="tcode">
								<?php echo getTehsils_options(false,NULL,$this->session->District); ?>
							</select>
						</div>
						<div class="col-md-2">
							<label>Union Council:</label>
						</div>
						<div class="col-md-2">
							<select class="form-control filter-status" name="uncode" id="uncode">
							<>
							</select>
						</div>	
						<div class="col-md-2">
							<label>Facilities</label>
						</div>
						<div class="col-md-2">
							<select class="form-control filter-status" name="facode" id="facode">
							<>
							</select>
						</div>					
						<div class="col-md-2">
							<label>Village/Mohallah:</label>
						</div>
						<div class="col-md-2">
							<select class="form-control filter-status" name="village" id="village">
							</select>
						</div>					
						<div class="col-md-2">
							<label>Technician</label>
						</div>
						<div class="col-md-2">
							<select class="form-control filter-status" name="techniciancode" id="techniciancode">
							</select>
						</div>	
					</form>
					
				<div class="col-md-2">
					<label>Child Name</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder = "Child Name" name="child_name" id="child_name">
				</div>
				<div class="col-md-2">
					<label>Child Card Number</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder = "Child Card Number" name="childcardnbr" id="childcardnbr">
				</div>
				<div class="col-md-2">
					<label>Father Name</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder = "Father Name" name="fathername" id="fathername">
				</div>
				<div class="col-md-2">
					<label>Date Of Birth</label>
				</div>
				<div class="col-md-2">
					<input class="form-control"placeholder="yyyy-mm-dd" class="month_year form-control " type="text" value="" data-date-format="yyy-mm-dd" name="dateofbirth" id="dateofbirth">
				</div>
				<div class="col-md-2">
					<label>Mobile Number</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder = "Mobile Number" name="mobilenbr" id="mobilenbr">
				</div>
				<!--<div class="col-md-2">
					<label>Vaccination</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder="yyyy-mm-dd" class="month_year form-control " type="text" value="" data-date-format="yyy-mm-dd" name="bcg" id="bcg">
				</div> --->
				<div class="col-md-2">
					<label>CNIC</label>
				</div>
				<div class="col-md-2">
					<input class="form-control" placeholder = "CNIC Number" name="cnicnbr" id="cnicnbr">
				</div>
				<div class="col-md-2">
					<label>Gender</label>
				</div>
				<div class="col-md-2">
					<select class="form-control" name="gender" id="gender">
						<option value=""> -- Select Gender -- </option>
						<option value="m"> Male </option>
						<option value="f"> Female </option>
					</select>
			</div>
		</div>
	</div> 
		<!---<div class="row" style="margin-top:5px;">   
			<div class="form-group">
				<div class="col-xs-5" style="margin-left: 72% !important;">
					<a href="<?php //echo base_url(); ?>childs/Reports_list/child_migrate">
						<button class="submit btn-success btn-sm"><i class="fa fa-share"></i> Child Migrate In</button>
					</a>
				</div>
			</div>
		</div> --->
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
							<i class="fa fa-plus"></i> Add New</button></th>
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
<script src="<?php echo base_url(); ?>includes/js/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/jquery.alphanumeric.js"></script>

<script type="text/javascript">

$(document).ready(function() { 
	$.fn.dataTable.ext.errMode = 'none';
	$('#dateofbirth').datepicker({
	"format": "yyyy-mm-dd",
	'startView': 2,
	'autoclose': true,
	'endDate' : Date(),
	})
	
	$('#bcg').datepicker({
	"format": "yyyy-mm-dd",
	'startView': 2,
	'autoclose': true,
	'endDate' : Date(),
	})
	
	
	
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
						/* if(isreply(data) == true){
								return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/ChildRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'
							}else{
								//console.log(hasreply(data));
								if(hasreply(data) == true){
									return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/ChildRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'
								}else{
									return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/ChildRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'
								}
							} */
						
						return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/ChildRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/ChildRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'

					}
			},
		]; 
		
		//$('#tcode').on('change' , function (){
			/* var tcode    = $("#tcode").val();
			//var tcode = this.value;
			alert(tcode);
		if(tcode < 1){
			alert('if'); */
			
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
		
			//}
		//});
		
		$("#cnicnbr").inputmask({"mask": "99999-9999999-9"});
		$("#mobilenbr").inputmask({"mask": "9999-9999999"});
	}); 
	
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
				var result = JSON.parse(result);
				var number = 1;
			row = "";
			$.each(result, function(i, obj){
				row +='<tr><td><span>'+number+'</span></td>';
				row +="<td><span>"+obj.cardno+"</span></td>";
				row +="<td><span>"+obj.nameofchild+"</span></td>";
				row +="<td><span>"+obj.dateofbirth+"</span></td>";
				row +="<td><span>"+obj.fathername+"</span></td>";
				row +="<td><span>"+obj.tehsilname+"</span></td>";
				row +="<td><span>"+obj.unname+"</span></td>";
				row +="<td><span>"+obj.address+"</span></td>";
				row +="<td><span><a id='edit_button' data-original-title='Edit'  data-toggle='tooltip' class='btn btn-xs btn-default editData edit' href=<?php echo base_url(); ?>Reports/ChildRegistrationEdit/"+obj.recno+"><i class='fas fa-edit text-white'></i></span></a><span><a  id='edit_button' data-original-title='View'  data-toggle='tooltip' class='btn btn-xs btn-default view' href=<?php echo base_url(); ?>Reports/ChildRegistrationView/"+obj.recno+"><i class='fa fa-eye text-white'></i></span></a></td></tr>";
				number++;
				
				console.log(number);
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
	
</script>