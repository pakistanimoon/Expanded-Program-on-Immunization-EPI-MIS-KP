<!--start of page content or body-->
<?php $utype=$_SESSION['utype']; 
//print_r($results); exit();?>
<style>
.table>tbody>tr.info>td, .table>tbody>tr.info>th, .table>tbody>tr>td.info, .table>tbody>tr>th.info, .table>tfoot>tr.info>td, .table>tfoot>tr.info>th, .table>tfoot>tr>td.info, .table>tfoot>tr>th.info, .table>thead>tr.info>td, .table>thead>tr.info>th, .table>thead>tr>td.info, .table>thead>tr>th.info {
    background-color: #008d4c;
    color: #ffffff;
    font-weight: 800;
}
.add_button{
  background: #008d4c;
  border: 1px solid;
  font-weight: 800;
}
.custom-add-btn{
background-color: #3c8dbc;
border: 1px solid #ffffff42;
border-radius: 2px;
width: 100%;
transition: all 0.3s;
}
.custom-add-btn:hover{
background: #367fa9;
}
</style>
<div class="container bodycontainer">
   <div class="row">
      <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
      <div class="panel panel-primary">
         <ol class="breadcrumb">
            <?php echo $this->breadcrumbs->show();?>
         </ol> 
         <div class="panel-heading"> List of Suppliers </div>
         <div class="panel-body">
            <form method="post" id="filter-form">           
               <div class="row">   
                  <div class="form-group">
                     <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting" for="search">Search:</label>
                     <div class="col-xs-3">
                        <input id="search_table" name="searchParam" class="form-control" type="text"/>
                     </div> 
                  </div>
               </div>          
            </form> 
            <br>
            <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="suppliersList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">Stakeholder Name</th>
                    <th class="text-center Heading">Stakeholder Type</th>
                     <th class="text-center Heading">Stakeholder Sector</th>
                     <th class="text-center Heading">Stakeholder Activity</th>
                     <th class="text-center Heading">
						<button id="add_button" class="submit custom-add-btn btn-sm" onclick="location.href='<?php echo base_url(); ?>Suppliers_management/suppliers_add'">
                           <i class="fa fa-plus"></i> Add 
						</button>
                     </th>
                  </tr>
               </thead>
               <tbody id="tbody"> 
                  <?php
                     $i=$startpoint;  
                     foreach($results as $row){
                     $i++;
                  ?>
                  <tr id="row" class="DrilledDown">
                     <td class="text-center"><?php echo $i; ?></td>
                     <td class="text-left"><?php echo $row['stakeholder_name']; ?></td>
                      <td class="text-left"><?php echo $row['get_stakeholder_type']; ?></td>
                     <td class="text-left"><?php echo $row['get_stakeholder_sectors']; ?></td>
                     <td class="text-left"><?php echo $row['get_activity_name']; ?></td>
                     <td class="text-center">
                        <a data-original-title="Edit" href="<?php echo base_url(); ?>Suppliers_management/suppliers_edit/<?php echo $row['pk_id']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                        <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_item('<?php echo $row['pk_id']; ?>');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
                     </td>
                  </tr>
                  <?php
                  } ?>                       
               </tbody>
            </table>          
            <!--<div class="row">
               <div class="col-sm-6 col-sm-offset-6" align="center">
                  <div id="paging">
                     <?php //displaying pagination.
                        echo $pagination;
                     ?> 
                  </div>
               </div>
            </div>-->
         </div> <!--end of panel body-->
      </div> <!--end of panel panel-primary-->
   </div><!--end of row-->
</div><!--End of page content or body-->

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
   $(function () {
      $('.footable').footable();
   });
	function del_item(obj){
		//alert(obj); exit();
		var myurl = '<?php echo base_url(); ?>Suppliers_management/suppliers_del/'+obj;		
		var is_confirm = confirm("Are you sure you want to delete?");
      if(is_confirm){
         //window.location.href = "<?php //echo base_url(); ?>User_management/user_list";
         $.get(myurl, function (show) {
            $("#row_"+obj).fadeOut();
			location.reload();
         });
		}
	}

   $(document).ready(function() {
	   //Datatable stast
	   var columns = [
			{ data: "serial" ,
			orderable: false,
			},
			{ data: "stakeholder_name" },
			{ data: "get_stakeholder_type" },
			{ data: "get_stakeholder_sectors" },
			{ data: "get_activity_name" },
			{ data: "pk_id",
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="Edit" href="<?php echo base_url(); ?>Suppliers_management/suppliers_edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_item(\''+data+'\')" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>'
					}
			},
		]; 
		var table = $('#suppliersList').DataTable(
		{
			"pageLength" : 30,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "desc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>Ajax_hr_management/suppliers_list_search",
				type : 'GET'
			},
			"columns": columns,
			dom: 'lrtips',
				"fnDrawCallback": function(oSettings) {
					if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
						$(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
					}
				}
		 
		});
		$('#search_table').on('keyup change', function () {
			table.search( this.value ).draw();
		});
	   
	   //End
   });     
</script>
