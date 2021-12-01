<!--start of page content or body-->
<?php $utype= $_SESSION['utype'];?>
 <div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
      <ol class="breadcrumb">
        <?php  echo $this->breadcrumbs->show();?>
      </ol> 
      <div class="panel-heading"> List of Cold Chain Operator
        </div>
         <div class="panel-body">
       <form method="post" id="filter-form">
        <?php if (($_SESSION['UserLevel']=='2') || ($_SESSION['UserLevel']=='3') || ($_SESSION['utype']=='CCManager') || ($_SESSION['utype']=='CCDEO') ){?>
        <div class="row">
          <div class="col-md-2 col-sm-3 lbl-setting cmargin27">
            <label>Search:</label>
          </div>
          <div class="col-md-3 col-sm-4">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Enter Code/CNIC" class="form-control" type="text">
             <span class="input-group-btn">
               <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button>
             </span>
          </a>
        </div>
      </div><br>
      <div class="row cmargin28">                
        <div class="col-xs-2 lbl-setting">
          <label>District:</label>
        </div>
        <div class="col-xs-3">
         <select id="distcode" onchange="getdistcodeValue()" name="distcode" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultDist as $row){
                ?>
                <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
                <?php } ?>
              </select>
        </div>
                 <div class="col-xs-2 lbl-setting">
            <label>Status:</label>
          </div>          
          <div class="col-xs-3">
              <select onchange="getStatusValue()" id="status" name="status" class="filter-status form-control" size="1" >
                <option value="0"></option>
                <option value="Active">Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
                <option value="Transfered">Transfered</option>
              </select>
        </div>
         </div>
         <br>
         <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div>  
      <?php } else{  ?>
      <div class="row">
          <div class="col-md-2 col-sm-3 lbl-setting cmargin27">
            <label>Search:</label>
          </div>
          <div class="col-md-3 col-sm-4">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Enter Code/Name/CNIC" class="form-control" type="text">
             <span class="input-group-btn">
               <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button>
             </span>
          </a>
        </div>
      </div><br>
      <div class="row cmargin28">
       <div class="col-xs-2 lbl-setting">
            <label>Status:</label>
          </div>          
          <div class="col-xs-2">
              <select onchange="getStatusValue()" id="status" name="status" class="filter-status form-control" size="1" >
                <option value="0"></option>
                <option value="Active">Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
                <option value="Transfered">Transfered</option>
              </select>
        </div>
         </div>
         <br>
         <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div>  
        <?php }?>
          </form>
        <table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>
                
                <th class="text-center Heading">Name</th>
                <th class="Heading text-center">CNIC</th>
                <th class="Heading text-center">Employee Type</th>                                
                <th class="text-center Heading">Status</th>
                <th class="Heading text-center">District</th>
                <?php if ((($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='CCManager')) || (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO'))){?>
                <th class="text-center Heading">
                <a href="<?php echo base_url(); ?>CC-Operator/Add" data-toggle="tooltip" title="Add New CC Operator">
                    <button class="submit btn-success btn-sm">
                    <i class="fa fa-plus"></i>Add New</button>
                  </a>
               </th>
               <?php }?>
              </tr>
            </thead>
            <tbody id="tbody"> 
    <?php
      $i=$startpoint;
      foreach($results as $row){
        $i++;
        ?>
        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>         
          <td class="text-center"><?php echo $row['ccoperatorname']; ?></td>
          <td class="text-center"><?php echo $row['nic']; ?></td>
          <td class="text-center"><?php echo $row['employee_type']; ?></td>         
          <td class="text-center"><?php echo $row['status']; ?></td>
          <td class="text-left"><?php echo $row['district']; ?></td>
        <?php if ((($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='CCManager')) || (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO'))){?>
          <td class="text-center">
            <a data-original-title="View" href="<?php echo base_url(); ?>CC-Operator/View/<?php echo $row['c_id']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
            <a data-original-title="Edit" href="<?php echo base_url(); ?>CC-Operator/Edit/<?php echo $row['c_id']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
            <!-- <a data-original-title="Delete" href="<?php //echo base_url(); ?>System_setup/driverdb_delete/<?php //echo $row['drivercode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a> -->
          </td>
      <?php }?>
        </tr>
        <?php
      }
      ?>
              </tbody>
          </table>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6" align="center">
              <div id="paging">
             <?php // displaying paginaiton.
             if(isset($pagination)){
             	//echo $pagination;
             }
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
  var status=0;
   var distcode=0;
  //var page=0;
  function getStatusValue(){
    status=document.getElementById("status").value;
  }
  function getdistcodeValue(){
    distcode=document.getElementById("distcode").value;
  }
  function checkNICNumber(num) {
            var regexp = new RegExp(/\d{5}-\d{7}-\d/);; 
            var valid = regexp.test(num);
            return valid;
          }
  function checkNumber(num) {
            isNumeric = /^[-+]?(\d+|\d+\.\d*|\d*\.\d+)$/;
            var valid = isNumeric.test(num);
            return valid;
  }
  $(document).ready(function() {
  var page=0;
    //executes code below when user click on pagination links
    $(document).on("click",".paginateMe",  function (e){
      e.preventDefault();
      $('#paging').html('')
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        $(".loading-div").show(); //show loading element
        page = $(this).attr("id"); //get page number from link
        $.ajax({
          type: "GET",
          //data: $('#filter-form').serialize(),
          dataType:"json",
          url: "<?php echo base_url(); ?>Ajax_calls/ccoperatordb_filter/"+page+"/"+status+"/"+distcode,
          success: function(result){
            $('#tbody').html(result.tbody);
            $('#paging').html(result.paging);
             $('.DrilledDown').css('cursor','pointer');
          }
        });
      });
  $('.filter-status').on('change' , function (){
    <?php if($_SESSION['UserLevel']=='3'){?>
       distcode= document.getElementById("distcode").value;
    <?php }?>
    $('#tbody').html('');
    $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        page = 0; //get page number from link
        $.ajax({
          type: "GET",
          //data: $('#filter-form').serialize(),
          url: "<?php echo base_url(); ?>Ajax_calls/ccoperatordb_filter/"+page+"/"+status+"/"+distcode,
          dataType: "json",
          success: function(result){
            $('#tbody').html('');
            if(result != null){
              $('#tbody').html(result.tbody);
                $('#paging').html(result.paging);
                 $('.DrilledDown').css('cursor','pointer');
            }
            else{
               $('#tbody').html('No Record Found'.tbody);
            }
          }
        });
      });
 $('#cnicbtn').on('click' , function (e){
      e.preventDefault();
      if($("#cnicSearch").val()!="")
      {
       var cnic= document.getElementById("cnicSearch").value;
            $('#tbody').html('');
            $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
            //var page = $(this).attr("id"); //get page number from link
            $.ajax({
              type: "GET",
              //data: $('#filter-form').serialize(),
              url: "<?php echo base_url(); ?>Ajax_calls/ccoperatordb_filter_cnic/"+cnic,
              dataType: "json",
              success: function(result){
                //console.log(result);
                $('#tbody').html('');
                if(result != null){
                  $('#tbody').html(result.tbody);
                  $('#paging').html(result.paging);
                 $('.DrilledDown').css('cursor','pointer');
                }
              }
            });
      }
     else
      {
        history.go(0);
      }
    });
  });
  /*  <?php if ($_SESSION['UserLevel']=='3'){ ?>
$('.DrilledDown').css('cursor','pointer');
    $(document).on('click',".DrilledDown", function(){
       var code = $(this).find("td:nth-child(2)").text();
        var url = '';
        url = "<?php echo base_url();?>System_setup/ccoperatordb_view/"+code;  
        var win = window.open(url,'_blank');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
<?php }?> */
</script> 