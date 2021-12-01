<!--start of page content or body-->
<div class="container">
<div class="row">
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of HF Incharges
        </div>
         <div class="panel-body">
       <form method="post" id="filter-form">
	   <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
        <div class="row">
          <!-- <div class="col-md-2 col-sm-3 lbl-setting cmargin27">
            <label>Search:</label>
          </div> -->
          <!-- <div class="col-md-3 col-sm-4">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Enter Name/CNIC" class="form-control" type="text">
             <span class="input-group-btn">
               <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button>
             </span>
          </a>
        </div> -->
      </div><!-- <br> -->
      <div class="row cmargin28">
<div class="col-md-2 col-sm-2 lbl-setting cmargin27" style="text-align: center;">
            <label>Search:</label>
          </div>
          <div class="col-md-2 col-sm-2">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Name/CNIC" class="form-control" type="text">
             <span class="input-group-btn">
               <!-- <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button> -->
             </span>
          </a>
        </div>

        <div class="col-xs-2 lbl-setting">
          <label>District:</label>
        </div>
        <div class="col-xs-2">
         <select id="distcode" name="distcode" onchange="getDistrictValue()" class="filter-status  form-control">
               <option value="0">ALL</option>
               <?php
               foreach($resultDist as $row){
                ?>
                <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
                <?php } ?>
              </select>
        </div>
          <!-- <div class="col-xs-2  lbl-setting">
            <label>Tehsil:</label>
          </div>
          <div class="col-xs-2">
             <select id="tcode" name="tcode" onchange="getTehValue()" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultTeh as $row){
                 ?>
                 <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
                 <?php }?>
               </select>
        </div>
		
		 <div class="col-xs-2  lbl-setting">
            <label>Union Council:</label>
          </div>
          <div class="col-xs-2">
             <select id="uncode" name="uncode" onchange="getUnValue()" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultUnC as $row){
                 ?>
                 <option value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name']; ?></option>
                 <?php }?>
               </select>
        </div> -->
		

       <!--  <div class="col-xs-2 lbl-setting">
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
         </div>
          <div class="row cmargin28">
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
        </div> -->
                 <div class="col-xs-2 lbl-setting">
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
		       <!-- <div class="col-xs-2 lbl-setting">
            <label>Health Facility Type:</label>
          </div> -->          
         <!--  <div class="col-xs-2">
              <select  id="fatype" onchange="getFacType()" name="fatype" class="filter-status form-control">
              
               <?php foreach($resultFac_type as $row){ ?>
                <option value="<?php echo $row['fatype'];?>" ><?php echo $row['fatype'];?></option>
               <?php } ?>
             </select>
        </div> -->
         </div>
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> -->  
<?php } else{  ?>
<div class="row">
          <div class="col-md-2 col-sm-2 col-sm-offset-1 lbl-setting cmargin27">
            <label>Search:</label>
          </div>
          <div class="col-md-2 col-sm-2">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Enter Code/Name/CNIC" class="form-control" type="text">
             <span class="input-group-btn">
               <!-- <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button> -->
             </span>
          </a>
        </div>
      
      <!-- <div class="row cmargin28">                
          <div class="col-xs-2  lbl-setting">
            <label>Tehsil:</label>
          </div>
          <div class="col-xs-2">
             <select id="tcode" name="tcode" onchange="getTehValue()" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultTeh as $row){
                 ?>
                 <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
                 <?php }?>
               </select>
        </div>
		
		 <div class="col-xs-2  lbl-setting">
            <label>Union Council:</label>
          </div>
          <div class="col-xs-2">
             <select id="uncode" name="uncode" onchange="getUnValue()" class="filter-status  form-control">
               <option value="0"></option>
               <?php
               foreach($resultUnC as $row){
                 ?>
                 <option value="<?php echo $row['uncode']; ?>" ><?php echo $row['un_name']; ?></option>
                 <?php }?>
               </select>
        </div>
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
         </div> -->
          <div class=" cmargin28">
        <!-- <div class="col-xs-2 lbl-setting">
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
        </div> -->
                 <div class="col-xs-2 lbl-setting">
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
		<!--  <div class="col-xs-2 lbl-setting">
            <label>Health Facility Type:</label>
          </div>          
          <div class="col-xs-2">
             <select  id="fatype" onchange="getFacType()" name="fatype" class="filter-status form-control">
              <option value="0"></option>
               <?php foreach($resultFac_type as $row){ ?>
                <option value="<?php echo $row['fatype'];?>" ><?php echo $row['fatype'];?></option>
               <?php } ?>
             </select>
        </div> -->
         </div>
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> -->  
<?php }?>
  </form>
<table id="meddb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>                
                <th class="text-center Heading">Incharge Name</th>
                <th class="text-center Heading">Father Name</th>
				<th class="text-center Heading">CNIC</th>
        <th class="text-center Heading">Phone</th>
				<th class="text-center Heading">Supervisor Name</th>
				<th class="text-center Heading">Union Council</th> 				
                <th class="text-center Heading">Health Facility Name</th>
                <th class="text-center Heading">Health Facility Type</th>
				<?php if (($_SESSION['utype']=='Manager') ){?>
					<th class="text-center Heading">District</th>
				<?php } ?>
                <th class="text-center Heading">Catchment Population</th>                
                <th class="text-center Heading">Status</th>
				<th class="text-center Heading">Form Status</th>
			  <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
					<th class="text-center Heading" style="width:100px;">
						<a href="<?php echo base_url(); ?>HF-Incharge/Add"  class="red-tooltip" data-toggle="tooltip" title="Add New HF-Incharge">
						<button class="submit btn-success btn-sm">
						<i class="fa fa-plus"></i> Add New</button>
					  </a>
				   </th>
                <?php } ?>
				<?php if (($_SESSION['utype']=='Manager')){?>
        <th class="text-center Heading">Action</th>
      <?php }?>
              </tr>
            </thead>
            <tbody id="tbody" style="text-align:center;"> <!--
  <?php
      $i=$startpoint;
      foreach($results as $row){
        $i++;
        ?>

        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>          
          <td class="text-center" ><?php echo $row['technicianname']; ?></td>
          <td class="text-center" ><?php echo $row['']; ?></td>
          <td class="text-center" ><?php echo $row['']; ?></td>
		  <td class="text-center" ><?php echo $row['supervisorname']; ?></td>
		  <td class="text-center" ><?php echo $row['unioncouncil']; ?></td>
          <td class="text-center" ><?php echo $row['facilityname']; ?></td>
		  <td class="text-center" ><?php echo $row['e']; ?></td>
		<?php if (($_SESSION['utype']=='Manager') ){?>			  
          <td class="text-center" ><?php echo $row['district']; ?></td>
		<?php }?>
          <td class="text-center" ><?php echo $row['catch_area_pop']; ?></td>
          <td class="text-center" ><?php echo $row['status']; ?></td>
		  <td class="text-center" ><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted'; ?></td>
		 <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>  
		 <td class="text-center" ><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted'; ?></td>
       
          <td class="text-center">
                      <a data-original-title="View" href="<?php echo base_url(); ?>Medical-Technician/View/<?php echo $row['techniciancode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                      <a data-original-title="Edit" href="<?php echo base_url(); ?>Medical-Technician/Edit/<?php echo $row['techniciancode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                  </td>
		<?php } ?>
        </tr>
        <?php
      }
      ?>
             --> </tbody> 
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
<!--<script src="<?php //echo base_url(); ?>includes/js/ajaxLoader.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>  
<script type="text/javascript">
    $(function () {
    $('.footable').footable();
  });
</script>
<script type="text/javascript">

 $(document).ready(function() { 
  var page=0;
  var distcode=0;

  <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
    var columns = [
          { data: "serial" ,
		   orderable: false,
		  },
          { data: "technicianname" },
          { data: "fathername" },
          { data: "nic" },
          { data: "phone" },
           { data: "supervisorname" },
          { data: "unioncouncil" },
          { data: "facilityname" },
          { data: "facilitytype" },
          { data: "catch_area_pop" },
          { data: "status" },
          { data: "is_temp_saved" },
         { data: "techniciancode" ,
          
          
           orderable: false,
            render : function(data, type, row) {
				
                return '<a data-original-title="View" href="<?php echo base_url(); ?>HF-Incharge/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>HF-Incharge/Edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
            }  
          }
        ]; 
  <?php } elseif ( ($_SESSION['utype']=='Manager')){?>
    var columns = [
          { data: "serial" ,
		   orderable: false,
		  },
          { data: "technicianname" },
          { data: "fathername" },
          { data: "nic" },
          { data: "phone" },
           { data: "supervisorname" },
          { data: "unioncouncil" },
          { data: "facilityname" },
          { data: "facilitytype" },
		  { data: "districtname" },
          { data: "catch_area_pop" },
          { data: "status" },
          { data: "is_temp_saved" },
         { data: "techniciancode" ,
          
          
           orderable: false,
            render : function(data, type, row) {
				
                return '<a data-original-title="View" href="<?php echo base_url(); ?>HF-Incharge/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
            }  
          }
        ]; 
  <?php }?>
  var table = $('#meddb-tbl').DataTable({
        "pageLength" : 16,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Ajax_calls/med_dataTables",
            
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });
	  // //default load active 
	  table.columns(10).search("Active").draw();	 

  $('#distcode').on('change', function () {
    table.columns(9).search( this.value ).draw();
  });

  $('#supervisorcode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });

  $('#fatype').on('change', function () {
    table.columns(8).search( this.value ).draw();
  });

  $('#status').on('change', function () {
    table.columns(11).search( this.value ).draw();
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