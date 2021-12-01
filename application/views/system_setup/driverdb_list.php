<!--start of page content or body-->
 <div class="container bodycontainer">

<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of Drivers
        </div>
         <div class="panel-body">
    <?php $utype= $_SESSION['utype'];?>
       <form method="post" id="filter-form">
        <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') || ($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
        <div class="row">

          <div class="col-md-2  col-sm-3 lbl-setting cmargin27">

            <label>Search:</label>

          </div>

          <div class="col-md-2 col-sm-2">

              <a class="input-group demo-input-group">

            <input id="cnicSearch" name="cnicSearch" placeholder="Code/Name/CNIC/Phone" class="form-control" type="text">

             <span class="input-group-btn">

               <!-- <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button> -->

             </span>

          </a>

        </div>
        
         <div class="">
		 <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
        <div class="col-xs-2  lbl-setting">

          <label>District:</label>

        </div>

        <div class="col-xs-2">

         <select id="distcode" onchange="getdistcodeValue()" name="distcode" class="filter-status  form-control">
               <option value="0">ALL</option>
               <?php
               foreach($resultDist as $row){
                ?>
                <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
                <?php } ?>
              </select>

        </div>
		 <?php } ?>

        <div class="col-xs-2  lbl-setting">

            <label>Status:</label>

          </div>          

          <div class="col-xs-2">

              <select onchange="getStatusValue()" id="status" name="status" class="filter-status form-control" size="1" >
                <option value="0">ALL</option>
                <option value="Active">Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
				<option value="On Leave">On Leave</option>
                <option value="Transfered">Transfered</option>
				<option value="Post Back">Post Back</option> 
              </select>

        </div>

      </div>
      </div>
        <br>

     


          <!-- <div class="row cmargin28">

         

        <div class="col-xs-2 lbl-setting">

          <label>Supervisor Name:</label>

        </div>

        <div class="col-xs-2">

          
              <select onchange="getSupervisorValue()" id="supervisorcode" name="supervisorcode" class="filter-status form-control">
                <option value="0"></option>


                <?php
                foreach($resultSupervisor as $row){
                  ?>
                  <option value="<?php echo $row['supervisorcode'];?>" ><?php echo $row['supervisorname'];?></option>
                  <?php
                }

                ?>
              </select>
        </div>

               
		
		

         </div> -->

         <br>

         



         <!-- <div class="row cmargin29">

           <div class="col-xs-3 col-xs-offset-9">

            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">

           </div>

          </div>  --> 
<?php } else{  ?>

<div class="row">

          <div class="col-md-2 col-sm-3 lbl-setting cmargin27">

            <label>Search by CNIC:</label>

          </div>

          <div class="col-md-3 col-sm-4">

              <a class="input-group demo-input-group">

            <input id="cnicSearch" name="cnicSearch" class="form-control" type="text">

             <span class="input-group-btn">

               <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button>

             </span>

          </a>

        </div>

      </div><br>

      <div class="row cmargin28">                

       

          <div class="col-xs-2  lbl-setting">

            <label>Tehsil:</label>

          </div>

          <div class="col-xs-3">

             <select id="tcode" name="tcode" onchange="getTehValue()" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultTeh as $row){
                 ?>
                 <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
                 <?php }?>
               </select>
        </div>
         <label class="col-xs-2 control-label lbl-setting"  for = "uncode" >Union Council:</label>
           <div class="col-xs-3">
              <select id="uncode" name="uncode" onchange="getUnValue()" class="filter-status  form-control">
	               <option value="0"></option>
	               <?php
	              foreach($resultUnC as $row){ ?>
	                <option value="<?php echo $row['uncode'];?>" ><?php echo $row['un_name'];?></option>
	                <?php  } ?>
	            </select>
           </div>
          </div>

        <div class="row cmargin28">  

        <div class="col-xs-2 lbl-setting">

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
				<option value="On Leave">On Leave</option>
                <option value="Transfered">Transfered</option>
				<option value="Post Back">Post Back</option> 
              </select>

        </div>
        

         </div>



          <div class="row cmargin28">

         

        <!--<div class="col-xs-2 lbl-setting">

          <label>Supervisor Name:</label>

        </div>

        <div class="col-xs-3">

          <select onchange="getSupervisorValue()" id="supervisorcode" name="supervisorcode" class="filter-status form-control">
                <option value="0"></option>


                <?php
                foreach($resultSupervisor as $row){
                  ?>
                  <option value="<?php echo $row['supervisorcode'];?>" ><?php echo $row['supervisorname'];?></option>
                  <?php
                }

                ?>
              </select>

        </div>-->

                 

         </div>

         <br>

         



         <div class="row cmargin29">

           <div class="col-xs-3 col-xs-offset-9">

            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">

           </div>

          </div>  

<?php }?>

  </form>
 

<table id="drdb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>                
                <th class="text-center Heading">Name</th>
                <th class="text-center Heading">Code</th>
                <th class="text-center Heading">CNIC</th> 
                <th class="text-center Heading">Phone</th>               
            <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
					<th class="text-center Heading">Tehsil</th> 
			<?php } else { ?>
					<th class="text-center Heading">District</th> 
			<?php } ?>
                 <th class="text-center Heading">Status</th>               
                <th class="text-center Heading">Form Status</th>
				
                
               
                 <?php if (($_SESSION['UserLevel']=='3') && ($utype=='DEO' )){ ?>

                <th class="text-center Heading" style="width:100px;">
<a href="<?php echo base_url(); ?>Driver/Add" class="red-tooltip" data-toggle="tooltip" title="Add New Driver">
                    <button class="submit btn-success btn-sm">
                    <i class="fa fa-plus"></i> Add New</button>
                  </a>
               </th>
               <?php }?>
			   <?php if ($_SESSION['utype']=='Manager'){?>
        <th class="text-center Heading">Action</th>
      <?php }?>
              </tr>
            </thead>
          




            <tbody style="text-align:center;"> 


 
              </tbody>
          </table>
        <div class="row">

            <div class="col-sm-6 col-sm-offset-6" align="center">
              <div id="paging">
             <?php // displaying paginaiton.
             /*echo $pagination;*/
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
</script>
<script type="text/javascript">
 $(document).ready(function() { 
  //alert("danish");
  var page=0;
  var distcode=0;
  <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
//alert("danish");
    var columns = [
          { data: "serial",
          orderable: false,
 },
          { data: "drivername" },
          { data: "drivercode" },
          { data: "nic" },
          { data: "phone" },
          { data: "tehsilname" },
           { data: "status" },
          { data: "is_temp_saved" },
         {  data: "drivercode" ,
		 orderable: false ,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>Driver/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>Driver/Edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
            }  
          }
        ]; 
  <?php } elseif ($_SESSION['utype']=='Manager'){ ?>
//alert("danish");
    var columns = [
          { data: "serial",
          orderable: false,
 },
          { data: "drivername" },
          { data: "drivercode" },
          { data: "nic" },
          { data: "phone" },
          { data: "districtname"  },
           { data: "status" },
          { data: "is_temp_saved" },
		  
         {    data: "drivercode" ,
			 orderable: false ,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>Driver/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
            }  
          }
        ]; 
  <?php } ?>
  var table = $('#drdb-tbl').DataTable({

        "pageLength" : 16,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Ajax_calls/dr_dataTables",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });
	  // //default load active 
	  table.columns(6).search("Active").draw();	 

  $('#distcode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });

  $('#tcode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });

  $('#drivercode').on('change', function () {
    table.columns(2).search( this.value ).draw();
  });

  $('#status').on('change', function () {
    table.columns(6).search( this.value ).draw();
  });

  $('#cnicSearch').on('keyup change', function () {
    table.search( this.value ).draw();
  });


});
/*<?php if ($_SESSION['UserLevel']=='3'){?>
$(document).ready(function() { 
$('.DrilledDown').css('cursor','pointer');
    $(document).on('click',".DrilledDown", function(){
       var supervisorcode = $(this).find("td:nth-child(2)").text();
        var url = '';
        url = "<?php echo base_url();?>Supervisor/View/"+supervisorcode;
        var win = window.open(url,'_blank');
        if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
  });
<?php }?>*/
</script>