<!--start of page content or body-->
<div class="container bodycontainer">
<div class="row">
    <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
     <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading">List of Federal To Province (EPI Stock Issue & Receipt Voucher) 
      </div>
      <div class="panel-body">
 		   	<form method="post" id="filter-form">
   		   	<div class="row">   
            <div class="form-group">
              <label class="col-xs-1 control-label lbl-setting"  for="facode" >Search:</label>
              <div class="col-xs-2">
                <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
              </div>            
              <label class="col-xs-2 control-label lbl-setting">From Issue Date:</label>
              <div class="col-xs-2">
                <input name="datefrom" id="datefrom" class="datefilter form-control dp" type="text">
              </div>
              <label class="col-xs-2 control-label lbl-setting" >To Issue Date:</label>
              <div class="col-xs-2">
                <input name="dateto" id="dateto" class="datefilter form-control dp" type="text">
              </div> 
            </div>  
          </div>
	      </form>

      <br>
      <br>
      <br>

      <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
                  <thead>
                    <tr>
                      <th class="text-center Heading">S#</th>
                      <th class="text-center Heading">From</th>
                      <th class="text-center Heading">To</th>
                      <th class="text-center Heading">Issued Date</th>
                       <th class="text-center Heading">
                        <a href="<?php echo base_url(); ?>Federal-Issue-Receipt/Add" data-toggle="tooltip" title="Add New Federal Form ">
                                            <button class="submit btn-success btn-sm">
                                            <i class="fa fa-plus"></i>Add New</button>
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

                                    <td class="text-center">Federal</td>
                                    
                     				       <td class="text-center">Provincial</td>

                                    <td class="text-center"><?php echo date("d-M-Y",strtotime($row['form_date'])); ?></td>

                                    <td class="text-center">

                                         <a href="<?php echo base_url(); ?>Federal-Issue-Receipt/View/<?php echo $row['id']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>

                                         <a href="<?php echo base_url(); ?>Federal-Issue-Receipt/Edit/<?php echo $row['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                    

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
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
    <script type="text/javascript">

      $(function () {

        $('.footable').footable();

      });
	$(document).ready(function() {
	
	$(document).on('blur', '.datefilter', function (){
			
          var datefrom = document.getElementById("datefrom").value;
       	  var dateto = document.getElementById("dateto").value;
	      //alert(dateto);
            $('#tbody').html('');  
            $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
            //var page = $(this).attr("id"); //get page number from link
             $.ajax({
		         type: "POST",
		         data: "datefrom="+datefrom+"&dateto="+dateto,
		         dataType:"json",
		         url: "<?php echo base_url(); ?>Ajax_calls/form_a1_fed_filter",
		        success:function(result){
		        	$('#tbody').html(result.tbody);
		            $('#paging').html(result.paging);
	            }
          	});
      
    });
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
          url: "<?php echo base_url(); ?>Ajax_calls/form_a1_fed_filter?page="+page,
          success: function(result){
            
            //console.log(result);
            
           var mb = $('#tbody').html(result.tbody);
           alert(mb);
            $('#paging').html(result.paging);

          }

        });
        
      });
  });
</script>