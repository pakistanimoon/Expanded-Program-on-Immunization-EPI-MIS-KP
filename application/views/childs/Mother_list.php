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
#mother_vaccinated_tbl{
	border: none;
}
</style>
<div class="content-wraper p-2 borderd-rounded">
	<div class="row m-0">
		<div class="col-lg-12">
			<div class="panel-heading"> List of Vaccinated Mothers</div>
			<br>
			<div class="row">   
					<div class="form-group col-md-6">
						 <label class="col-xs-1 control-label lbl-setting" for="search"> Search:  </label>
						 <div class="col-xs-11">
							<input id="search" name="searchParam" class="form-control" type="text" placeholder="Vaccinated Mother Search By Title"/>
						 </div>
					</div>
			</div>
		</div>
		<div class="col-lg-12 listing-table">
			<?php
			if($this -> session -> msg){ ?>
				<div class="error_prefix"><?php echo $this -> session -> msg; ?></div>
			<?php } ?>
			<table id="mother_vaccinated_tbl" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
				<thead>
					<tr>
						<th class="text-center Heading">S#</th>
						<th class="text-center Heading">Card NO</th>
						<th class="text-center Heading">Mother Name</th>
						<th class="text-center Heading">Husband Name</th>
						<th class="text-center Heading">Provnice</th>
						<th class="text-center Heading">District</th>
						<th class="text-center Heading">Tehsil</th>
						<th class="text-center Heading">UC</th>
						<th class="text-center Heading">
						<a href="<?php echo base_url();?>childs/Reports_list/mother_add" data-toggle="tooltip" title="Add Mother Registeration ">
						<button class="submit btn-success btn-sm">
						<i class="fa fa-plus"></i> Add New</button></a>
			  </th>
					</tr>
				</thead>
				<tbody id="tbody">
					
				</tbody>
			</table>
		</div>
	</div>
</div>






<script type="text/javascript">




	$(document).ready(function() { 

		//Product Services Table Datatable

		var productservicesColumns = [

			{ data: "serial" ,"sClass":"center",

				orderable: false,

			},
			{ data: "card_no"},
			{ data: "mother_name"},
			{ data: "husband_name"},
			{ data: "procode"},
			{ data: "distcode"},
			{ data: "tcode"},
			{ data: "uncode"},
			{ data: "recno" ,"sClass":"custom-space",
			
					orderable: false,

					render : function(data, type, row) 

						{
						  return '<a id="edit_button" data-original-title="Edit" href="<?php echo base_url(); ?>Reports/MotherRegistrationEdit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default editData edit" ><i class="fas fa-edit text-white"></i></a><a  data-original-title="View" href="<?php echo base_url(); ?>Reports/MotherRegistrationView/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default view"><i class="fa fa-eye text-white"></i></a>'

						}

				},

		]; 

		var table = $('#mother_vaccinated_tbl').DataTable(

		{	

			"pageLength" : 15,

			"serverSide": true,

			"lengthChange": false,

			"order": [

			  [1, "asc" ] 

			],

			"ajax": {

				url : "<?php echo base_url(); ?>childs/Reports_list/mother_vaccinated_search",

				type : 'GET'

			},

			"columns": productservicesColumns,

			dom: 'lrtips',

				"fnDrawCallback": function(oSettings) {

					if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {

						$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();

					}

				}

		 

		});

		$('#search').on('keyup change', function () {

			table.search( this.value ).draw(); 

		});

	}); 
	
</script>