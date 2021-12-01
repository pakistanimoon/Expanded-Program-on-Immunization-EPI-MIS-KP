<!--start of page content or body-->
<?php $utype=$this -> session -> utype; 
$UserLevel=$_SESSION['UserLevel'];
?>
<div class="container bodycontainer">
 <div class="row">
   <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
      <ol class="breadcrumb"><?php  echo $this->breadcrumbs->show();?></ol> 
       <div class="panel-heading"> List of Cold Room Questionnaires</div>
        <div class="panel-body">
    <form method="post" id="filter-form">
  <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
    <div class="row">
        <div class="col-md-2 col-sm-3 lbl-setting cmargin27">
         <label>Search:</label>
           </div>
             <div class="col-md-3 col-sm-4">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Enter Code/Name" class="form-control" type="text">
             <span class="input-group-btn">
               <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button>
             </span>
          </a>
        </div>
    </div><br>
      <div class="row cmargin28">                
  <?php if($UserLevel == 2){ ?>
        <div class="col-xs-2 lbl-setting">
          <label>District:</label>
        </div>
        <div class="col-xs-2">
          <select id="distcode" name="distcode" class="filter-status  form-control">
             <option value="0"></option>
             <?php
             foreach($resultDist as $row){
              ?>
              <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
              <?php } ?>
          </select>  
        </div>
  <?php }?>
          <div class="col-xs-2  lbl-setting">
            <label>Tehsil:</label>
          </div>
          <div class="col-xs-2">
            <select onclick="getTehValue()" id="tcode" name="tcode" class="filter-status  form-control">
              <option value="0"></option>
               <?php
                   foreach($resultTeh as $row){
               ?>
              <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
               <?php }?>
            </select>
        </div>
  <?php if($UserLevel == 2 || $UserLevel == 3 ){  ?>
        <div class="col-xs-2 lbl-setting">
          <label>Health Facility Name:</label>
        </div>
        <div class="col-xs-2">
        <select onchange="getFacValue()" id="facode" name="facode" class="filter-status form-control">
              <option value="0"></option>
               <?php
                foreach($resultFac as $row){ ?>
                 <option  value="<?php echo $row['facode']; ?>" ><?php echo $row['fac_name']; ?></option>
              <?php } ?>
             </select>
        </div>
  <?php } ?>  
         </div>
      
         <br>
         <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
           <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> 
  <?php } else {?>
      <div class="row">
       <label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
          <div class="col-xs-3">
            <input id="filter" name="searchParam" class="form-control form-control" type="text"/>
          </div>
        <div class="col-xs-2  lbl-setting">
            <label>Tehsil:</label>
          </div>
          <div class="col-xs-3">
            <select id="tcode" name="tcode" class="filter-status  form-control">
              <option value="0"></option>
               <?php
                   foreach($resultTeh as $row){
               ?>
              <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
               <?php }?>
            </select>
        </div>
      </div>
      <div class="row cmargin28">                
  <?php if($UserLevel == 2 || $UserLevel == 3 ){  ?>
        <div class="col-xs-2 col-xs-offset-1 lbl-setting">
          <label>Health Facility Name:</label>
        </div>
        <div class="col-xs-3">
        <select onchange="getFacValue()" id="facode" name="facode" class="filter-status form-control">
              <option value="0"></option>
               <?php
                foreach($resultFac as $row){ ?>
                 <option  value="<?php echo $row['facode']; ?>" ><?php echo $row['fac_name']; ?></option>
              <?php } ?>
             </select>
        </div>
  <?php } ?> 
  <div class="col-xs-2 lbl-setting">
          <label>Health Facility Type:</label>
        </div>
        <div class="col-xs-3">
          <select  onchange="getFacType()" id="fatype" name="fatype" class="filter-status  form-control">
                     <option value="0"></option>
                     <?php
                     foreach($resultFac_type as $row){
                      ?>
                      <option value="<?php echo $row['fatype'];?>" ><?php echo $row['fatype'];?></option>
                      <?php
                    }
                    ?>
                </select> 
        </div> 
         </div>
         <br>
      <?php }?> 
    </form>
  <table  class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>
				        <th class="text-center Heading">Submitted Date </th>
                <th class="text-center Heading">Equipment Code </th>                
                <th class="text-center Heading">Tehsil</th>                
                <th class="text-center Heading">Health Facility Name</th>
                <th class="text-center Heading">Health Facility Type</th>
                <th class="text-center Heading">Health Facility Code</th>
                <?php if ($_SESSION['UserLevel']=='3' && $utype=='DEO' ){?>
                  <th class="text-center Heading">
                    <a href="<?php echo base_url(); ?>Coldroom-Questionnaire/Add" data-toggle="tooltip" title="Add New Cold Room Questionnaire">
                      <button class="submit btn-success btn-sm">
                      <i class="fa fa-plus"></i> Add New</button>
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
            <td class="text-center"><?php echo $i; ?></td>
      	    <td class="text-center"><?php echo date('d-m-Y',strtotime($row['date_submitted']));?></td>
            <td class="text-center"><?php echo $row['equip_code'];?></td>       
            <td class="text-left"><?php echo $row['tehsil'];?></td>      
            <td class="text-left"><?php echo $row['facilityname'];?></td>
            <td class="text-left"><?php echo $row['facilitytype'];?></td>
            <td class="text-center"><?php echo $row['facode'];?></td>
            <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
            <td class="text-center">
              <a data-original-title="View" href="<?php echo base_url(); ?>Coldroom-Questionnaire/View/<?php echo $row['id']?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
              <a data-original-title="Edit" href="<?php echo base_url(); ?>Coldroom-Questionnaire/Edit/<?php echo $row['id']?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
            </td>
            <?php } ?>
			 <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
            <td class="text-center">
              <a data-original-title="View" href="<?php echo base_url(); ?>Coldroom-Questionnaire/View/<?php echo $row['id']?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
            </td>
            <?php } ?>
          </tr>
        <?php } ?>                       
        </tbody>
        </table>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6" align="center">
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
  var tcode=0;
  var facode=0;
   var fatype=0;
  //var page=0;
  function getTehValue(){
    tcode=document.getElementById("tcode").value;
  }
  function getFacValue(){
    facode=document.getElementById("facode").value;
  }
  function getFacType(){
    fatype=document.getElementById("fatype").value;
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
  var distcode=0;
    //executes code below when user click on pagination links
    $(document).on("click",".paginateMe",  function (e){
      e.preventDefault();
      $('#paging').html('')
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        $(".loading-div").show(); //show loading element
        page = $(this).attr("id"); //get page number from link
        $.ajax({
          type: "GET",
         // data: $('#filter-form').serialize(),
          dataType:"json",
          url: "<?php echo base_url(); ?>Ajax_calls/coldroom_questionnaire_filter/"+page+"/"+tcode+"/"+facode+"/"+fatype+"/"+distcode,
          success: function(result){
            $('#tbody').html(result.tbody);
            $('#paging').html(result.paging);    
            $('.DrilledDown').css('cursor','pointer');
          }
        });
      });
  $('.filter-status').on('change' , function (){
    <?php if($_SESSION['UserLevel']=='2'){?>
    distcode= document.getElementById("distcode").value;
    <?php }?>
    tcode=document.getElementById("tcode").value;
    $('#tbody').html('');
    $('#paging').html('');
    $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        page = 0; //get page number from link
        $.ajax({
          type: "GET",
         // data: $('#filter-form'),alert()
          url: "<?php echo base_url(); ?>Ajax_calls/coldroom_questionnaire_filter/"+page+"/"+tcode+"/"+facode+"/"+fatype+"/"+distcode,
          dataType: "json",
          success: function(result){
            $('#tbody').html('');
            if(result != null){
              $('#tbody').html(result.tbody);
                $('#paging').html(result.paging); 
                $('.DrilledDown').css('cursor','pointer');
            }
          }
        });
      });
$('#distcode').on('change' , function (){
   var distcode= this.value;
   $.ajax({
    type: "POST",
    data: "distcode="+distcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
      success:function(result){
        $('#tcode').html(result);
      }
    });
    $.ajax({
    type: "POST",
    data: "distcode="+distcode,
    url: "<?php echo base_url(); ?>Ajax_calls/getFacilitiesTHS",
      success:function(result){
        $('#facode').html(result);
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
              url: "<?php echo base_url(); ?>Ajax_calls/supervisor_filter_cnic/"+cnic,
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
</script>