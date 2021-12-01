<div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of Purpose
        </div>
         <div class="panel-body">
 		   	 <form method="post" id="filter-form">
 		   	 	<div class="row">   
        <div class="form-group">
           <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
           <div class="col-xs-3">
            <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
            </div>
          
                 
      </div>
    </div>  
      
	</form>
<br>
   <br>
<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>
                <th class="text-center Heading">Type</th>
                <th class="text-center Heading">
                  <a href="<?php echo base_url(); ?>Admin_Configuration/type_save" data-toggle="tooltip" title="Add New AEFI Investigation Form">
                <button class="submit btn-success btn-sm">
                  <i class="fa fa-plus"></i> Add New</button>
                                    </a>
                </th>
                </tr>
            </thead>          
          </table>
          <br>
          <div class="row">
            <div class="col-sm-12" align="center">
      <div id="paging">
       <?php 
       // displaying paginaiton.
       echo $pagination;
       ?> 
      </div>
            </div>
          </div>
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
     $(document).ready(function() {
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
          url: "<?php echo base_url(); ?>Ajax_calls/form_b_filter?page="+page,
          success: function(result){
            
            console.log(result);
			$("#filter").val('');
            $('#tbody').html(result.tbody);
            $('#paging').html(result.paging);
          }
        });
        
      });
  });
  $('.filter-status').on('change' , function (){
    $('#tbody').html('');
    $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        //var page = $(this).attr("id"); //get page number from link
        $.ajax({
          type: "GET",
          data: $('#filter-form').serialize(),
          url: "<?php echo base_url(); ?>Ajax_calls/form_b_filter",
          dataType: "json",
          success: function(result){
            console.log(result);
            $('#tbody').html('');
            if(result != null){
              $('#tbody').html(result.tbody);
                $('#paging').html(result.paging);
            }
            
          }
        });
      });
  
   </script>