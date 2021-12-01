<!--start of page content or body-->
<div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of District Stock Issue & Receipt Voucher
        </div>
         <div class="panel-body">


 		   	 <form method="post" id="filter-form">
 		   	 	<div class="row">   
        <div class="form-group">
           <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
           <div class="col-xs-3">
            <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
            </div>

           <label class="col-xs-2 control-label lbl-setting"  for = "facode" >Facilities:</label>
           <div class="col-xs-3">
              <select id="facode" name="facode" class="filter-status  form-control">
                       <option value="0"></option>
                       <?php
                      foreach($resultFac as $row){ ?>
                        <option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option>
                        <?php  } ?>
                    </select>
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
                <th class="text-center Heading">From District</th>
                <th class="text-center Heading">To Facility</th>
                <th class="text-center Heading">Issued Date</th>
				<th class="text-center Heading">Status</th>
                 <th class="text-center Heading">
                  <a href="<?php echo base_url(); ?>District-Issue-Receipt/Add" data-toggle="tooltip" title="Add New District Stock Issue & Receipt Voucher">
                                      <button class="submit btn-success btn-sm">
                                      <i class="fa fa-plus"></i> Add New</button>
                                    </a>
                </th>

                </tr>
            </thead>

          

<tbody id="tbody">

            

<?php


$i=$startpoint;

foreach($result as $row){

$i++;

?>

                           <tr>

                              <td class="text-center"><?php echo $i; ?></td>

                              <td class="text-left"><?php echo $row['dist_name']; ?></td>

                              <td class="text-left"><?php echo $row['fac_name']; ?></td>

                              <td class="text-center"><?php echo date("d-M-Y",strtotime($row['form_date'])); ?></td>
							  
							  <td class="text-center"><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : '' ; ?></td>

                              <td class="text-center">

                                

                                   <a href="<?php echo base_url(); ?>District-Issue-Receipt/View/<?php echo $row['distcode']; ?>/<?php echo $row['id']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>

                                   <a href="<?php echo base_url(); ?>District-Issue-Receipt/Edit/<?php echo $row['distcode']; ?>/<?php echo $row['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                              

                              </td>

                           </tr>

<?php

}

?>

                        </tbody>
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
<script src="<?php echo base_url(); ?>includes/js/ajaxLoader.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>





    <script type="text/javascript">

      $(function () {

        $('.footable').footable();

      });

    </script>




<script type="text/javascript">

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
          url: "<?php echo base_url(); ?>Ajax_calls/form_a2_filter?page="+page,
          success: function(result){
            
            console.log(result);
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
          url: "<?php echo base_url(); ?>Ajax_calls/form_a2_filter",
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