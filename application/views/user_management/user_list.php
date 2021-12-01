<!--start of page content or body-->
<?php $utype=$_SESSION['utype']; ?>
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
         <div class="panel-heading"> List of Users </div>
         <div class="panel-body">
            <form method="post" id="filter-form">           
               <div class="row">   
                  <div class="form-group">
                     <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting" for="search">Search:</label>
                     <div class="col-xs-3">
                        <input id="search_table" name="searchParam" class="form-control" type="text"/>
                     </div> 
                     <label class="col-xs-2 control-label lbl-setting"  for="distcode">District:</label>
                     <div class="col-xs-3">
                        <select id="distcode1" name="distcode" class="filter-status form-control">
                           <option value="0">--- Select District ---</option>
                           <?php foreach($resultDist as $row){ ?>
                           <option value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option>
                           <?php } ?>
                        </select>
                     </div> 
                  </div>
               </div>
               <div class="row" style="margin-top:5px;">             
                  <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting" for="level">User Level:</label>
                  <div class="col-xs-3">
                     <select id="level" name="level" class="filter-status form-control">
                        <option value="0">--- Select Level ---</option>
                        <?php foreach($resultLevel as $row){ ?>
                        <option value="<?php echo $row['userlevel'];?>" ><?php echo $row['userlevel_description'];?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <label class="col-xs-2 control-label lbl-setting" for="utype">User Type:</label>
                  <div class="col-xs-3">
                     <select id="utype" name="utype" class="filter-status form-control">
                        <option value="0">--- Select User Type ---</option>
                        <?php foreach($resultTypes as $row){ ?>
                        <option value="<?php echo $row['usertype'];?>" ><?php echo $row['usertype'];?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>           
            </form> 
            <br>
            <table class="table table-bordered table-hover table-striped footable table-vcenter" data-filter="#filter" data-filter-text-only="true" id="userList">
               <thead>
                  <tr class="info">
                     <th class="text-center Heading">S#</th>
                     <th class="text-center Heading">User Name</th>
                     <th class="text-center Heading">User Type</th>
                     <th class="text-center Heading">District</th>
                     <th class="text-center Heading">Full Name</th>
                     <th class="text-center Heading">Level</th>
                     <th class="text-center Heading">
                        <!--<a class="add_button" href="<?php echo base_url(); ?>User_management/user_add" data-toggle="tooltip" title="Add New User">
                           <button class="submit btn-success btn-sm">
                           <i class="fa fa-plus"></i> Add</button>
                        </a>-->
						<button id="add_button" class="submit custom-add-btn btn-sm" onclick="location.href='<?php echo base_url(); ?>User_management/user_add'">
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
                  <tr id="row_<?php echo $row['username'];?>" class="DrilledDown">
                     <td class="text-center"><?php echo $i; ?></td>
                     <td class="text-left"><?php echo $row['username']; ?></td>
                     <td class="text-left"><?php echo $row['utype']; ?></td>
                     <td class="text-left"><?php echo $row['district']; ?></td>
                     <td class="text-left"><?php echo $row['fullname']; ?></td>
                     <td class="text-left"><?php echo get_UserLevel_Description($row['level']); ?></td>    
                     <td class="text-center">
                        <a data-original-title="Edit" href="<?php echo base_url(); ?>User_management/user_add?user=<?php echo $row['username']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                        <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('<?php echo $row['username']; ?>');" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>
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
	function del_user(obj){	  
		var myurl = '<?php echo base_url(); ?>User_management/delete_by_id/'+obj;		
		var is_confirm = confirm("Are you sure you want to delete?");
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
			{ data: "username" },
			{ data: "utype" },
			{ data: "district" },
			{ data: "fullname" },
			{ data: "level" },
			{ data: "username" ,
				orderable: false,
				render : function(data, type, row) 
					{				
					 return '<a data-original-title="Edit" href="<?php echo base_url(); ?>User_management/user_add?user='+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> <a data-original-title="Delete" href="javascript:void(0);" onclick="javascript:del_user('+data+')" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" ><i class="fa fa-times"></i></a>'
					}
			},
		]; 
		var table = $('#userList').DataTable(
		{
			"pageLength" : 30,
			"serverSide": true,
			"lengthChange": false,
			"order": [
			  [1, "desc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>Ajax_hr_management/user_list_search",
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
      //executes code below when user click on pagination links
      $(document).on("click",".paginateMe",  function (e){
         e.preventDefault();
         $('#paging').html('')
         $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
         $(".loading-div").show(); //show loading element
         var page = $(this).attr("id"); //get page number from link
         $.ajax({
            type: "GET",
            data: $('#filter-form').serialize(),
            dataType:"json",
            url: "<?php echo base_url(); ?>Ajax_control_panel/users_list_filter?page="+page,
            success: function(result){
               //var decodedresult = $.parseJson(result);
               $("#filter").val('');
               $('#tbody').html(result.tbody);
               $('#paging').html(result.paging);
            }
         });      

      }); 
   });     
	
   $('.filter-status').on('change', function (){
      $('#tbody').html('');
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
      $.ajax({
         type: "GET",
         data: $('#filter-form').serialize(),
         url: "<?php echo base_url(); ?>Ajax_control_panel/users_list_filter",
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
   });
 
</script>
