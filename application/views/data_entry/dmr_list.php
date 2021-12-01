<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of District Monthly Reports
        </div>
         <div class="panel-body">
           <form method="post" id="filter-form">
          
           
        <div class="form-group">
          <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
           <div class="col-xs-3">
             <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
              
           </div>
   

      




            <?php if($UserLevel == 2){  ?>

              <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >District:</label>
                     <div class="col-xs-3">
                     <select id="distcode" name="distcode" class="filter-status  form-control">
                       <option value="0"></option>
                       <?php
                       foreach($resultDist as $row){ ?>
                        <option value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option>
                        <?php  } ?>
                    </select>
                    </div>
              <?php } ?> 

            
                    <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Year-Month:</label>
                     <div class="col-xs-3">
                     <select id="ym" name="ym" class="filter-status  form-control">
                       <option value="0"></option>
                       <?php
                       foreach($resultYM as $row){
                        ?>
                        <option value="<?php echo $row['fmonth'];?>" ><?php echo $row['fmonth'];?></option>
                        <?php
                      }

                      ?>
                    </select>
                   </div>





  </div>

</form><br>
   <br>


<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>
               <th class="text-center Heading">District Code</th>
               <th class="text-center Heading">District Name</th>
               <th class="text-center Heading">Year-Month</th>
               <th class="text-center Heading">
                   <a href="<?php echo base_url(); ?>Data_entry/dmr" data-toggle="tooltip" title="Add New LHS">
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
                              <td class="text-center"><?php echo $row['distcode']; ?></td>
                              <td class="text-center"><?php echo $row['districtname']; ?></td>
                              <td class="text-center"><?php echo $row['fmonth']; ?></td>
                              <td class="text-center">
                              <a href="<?php echo base_url(); ?>Data_entry/dmr_view/<?php echo $row['distcode']?>/<?php echo $row['fmonth']?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>   
                               <a href="<?php echo base_url(); ?>Data_entry/dmr_edit/<?php echo $row['distcode']; ?>/<?php echo $row['fmonth']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>

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

          url: "<?php echo base_url(); ?>Ajax_calls/dmr_filter?page="+page,

          success: function(result){

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

          url: "<?php echo base_url(); ?>Ajax_calls/dmr_filter",

          dataType: "json",

          success: function(result){

            //console.log(result);

            $('#tbody').html('');

            if(result != null){

              $('#tbody').html(result.tbody);

                $('#paging').html(result.paging);

            }

            





          }



        });

      });

   </script>