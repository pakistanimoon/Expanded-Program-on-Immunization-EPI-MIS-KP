<?php //$utype = $_SESSION['utype']; 
?>
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
      <?php if($this->session->flashdata('message')){  
         ?>
         <div class="alert alert-success text-center" role="alert">
         <strong><?php echo $this->session->flashdata('message'); ?></strong></div> 
         <?php } ?>
      <div class="panel panel-primary">
         <ol class="breadcrumb">
            <?php echo $this->breadcrumbs->show();?>
         </ol> 
         <div class="panel-heading"> Menu List </div>
         <div class="panel-body">
         <form method="post" id="filter-form">           
               <div class="row">   
                  <div class="form-group">
                  <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting" for="search">Search:</label>
                     <div class="col-xs-3">
                        <input id="search_table" name="searchParam" class="form-control" type="text"/>
                     </div> 
                     <label class="col-xs-2 control-label lbl-setting"  for="level">User Level:</label>
                     <div class="col-xs-3">
                        <select id="level" required name="level" class="filter-status form-control" size="1" >
                        <option value="0">--- Select User Level ---</option>
                        <?php foreach($resultLevel as $row){ ?>
                        <option value="<?php echo $row['userlevel'];?>" ><?php echo $row['userlevel_description'];?></option>
                        <?php } ?>
                     </select>
                        </select>
                     </div> 
                  </div>
               </div>
               <div class="row" style="margin-top:5px;">             
                  <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting" for="utype">User Type:</label>
                  <div class="col-xs-3">
                     <select id="utype" name="utype" class="filter-status form-control">
                        <option value="0">--- Select User Type ---</option>
                        <?php foreach($resultTypes as $row){ ?>
                        <option value="<?php echo $row['id'];?>" ><?php echo $row['usertype'];?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>           
            </form> 
            <br>
            <div id="result"></div>
            <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="menuList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">Menu Item</th>
                     <th class="text-center Heading">Menu Url</th>
                     <th class="text-center Heading">Menu Parent</th>
                     <th class="text-center Heading">User Level</th>
                     <th class="text-center Heading">User Type</th>
                     <th class="text-center Heading">
						<button id="add_button" class="submit custom-add-btn btn-sm" onclick="location.href='<?php echo base_url(); ?>User_menu/menu'">
                           <i class="fa fa-plus"></i> Add 
						</button>
                     </th>
                  </tr>
               </thead>
               <tbody id="tbody"> 
                  <?php
                    $i=$startpoint; 
                    foreach($menu_data as $row){
                    $i++;
                  ?> 
                  <tr id="row_<?php echo $row['id'];?>" class="DrilledDown">                  
                    <td class="text-center"><?php echo $i; ?></td>
                    <td class="text-left"><?php echo $row['menu_item']; ?></td>
                    <td class="text-left"><?php echo $row['menu_url']; ?></td>
                    <td class="text-left"><?php echo $row['parent']; ?></td>
                    <td class="text-left"><?php echo $row['userlevel_description']; ?></td> 
                    <td class="text-left"><?php echo $row['usertype']; ?></td> 
                    <td class="text-center">
                        <a data-original-title="Edit" href="<?php echo base_url(); ?>User_menu/menu?menu=<?php echo $row['id']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                        <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('<?php echo $row['id']; ?>', '<?php echo $row['rol_id']; ?>');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
                    </td>
                  </tr>
                  <?php
                  } ?>                       
               </tbody>
            </table>
            <!-- <div class="row">
               <div class="col-sm-6 col-sm-offset-6" align="center">
                  <div id="paging"> -->
                  <?php //displaying pagination.
                        //echo $pagination;
                     ?> 
                  <!-- </div>
               </div>
            </div> -->
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
   $(function () {
      $('.footable').footable();
   });

   function del_user(obj, object_2){	  
      //alert(obj); exit;
		var myurl = '<?php echo base_url(); ?>User_menu/delete_by_role/'+obj+'/'+object_2;		
		var is_confirm = confirm("Are you sure you want to delete this role?");
      if(is_confirm){
         $.get(myurl, function (show) {
            $("#row_"+obj).fadeOut();
         });
		}
	}

   $(document).ready(function() {
	   //Datatable stast
	   var columns = [
			{ data: "serial" ,
			orderable: false,
			},
			//{ data: "rol_id" },
			{ data: "menu_item" },
			{ data: "menu_url" },
            { data: "parent" },
            { data: "userlevel_description" },
            { data: "usertype" },
			{ data: "id" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="Edit" href="<?php echo base_url(); ?>User_menu/menu?menu='+row.id+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('+row.id+', '+row.rol_id+')" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>'
					}
			},
		]; 
		var table = $('#menuList').DataTable(
		{
			"pageLength" : 30,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "desc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>system_set/hr_management/Ajax_hr_management/menu_list_search",
				type : 'GET'
			},
			"columns": columns,
			dom: 'lrtips'
		 
		});
		$('#level').on('change', function () {
         table.columns(4).search( this.value ).draw();
		});
		$('#utype').on('change', function () {
         table.columns(5).search( this.value ).draw();
		});
		$('#search_table').on('keyup change', function () {
         table.search( this.value ).draw();
		});
	   
      $(document).on("click",".paginateMe",  function (e){
         e.preventDefault();
         $('#paging').html('')
         $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
         $(".loading-div").show();
         var page = $(this).attr("id");
         $.ajax({
            type: "GET",
            data: $('#filter-form').serialize(),
            dataType:"json",
            url: "<?php echo base_url(); ?>Ajax_control_panel/menu_list_filter?page="+page,
            success: function(result){
               $("#filter").val('');
               $('#tbody').html(result.tbody);
               $('#paging').html(result.paging);
            }
         });      

      }); 
   });     
	
   /* $('.filter-status').on('change', function (){
      $('#tbody').html('');
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
      $.ajax({
         type: "GET",
         data: $('#filter-form').serialize(),
         url: "<?php echo base_url(); ?>Ajax_control_panel/menu_list_filter",
         dataType: "json",
         success: function(result){
            $('#tbody').html('');
            if(result != null){
               $('#tbody').html(result.tbody);
			   console.log(result.paging);
               $('#paging').html(result.paging);
            }
         }
      });
   }); */
</script>