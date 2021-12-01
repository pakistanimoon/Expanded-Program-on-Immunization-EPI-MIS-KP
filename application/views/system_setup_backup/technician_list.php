<!--start of page content or body-->
<?php //print_r($results);exit; ?>
<div class="container">
<div class="row">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>

    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of EPI Technician
        </div>
         <div class="panel-body">
       <form method="post" id="filter-form">
	   <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
        <!-- <div class="row">
          
      </div> -->
     <table class="table table-bordered  mytable3" style="width: 97%;margin-left: 10px;">
          <tbody>
			
			<tr><td style="width: 8%;">
			  <label>Search</label>
			</td>
            <td style="width: 12%;">
              <input class="form-control" id="ref" name="ref_no" placeholder="Nic/Name" type="text">
            </td>
			
			<td style="width: 9%;text-align: right;">
			  <label>District</label>
			</td>
            <td style="width: 12%;">
              <select id="distcode" name="distcode" onchange="getDistrictValue()" class="filter-status  form-control">
				<option value="0">All</option>
			  <?php getDistricts_options(false); ?>
			  </select>
            </td>
		
			<td style="width: 9%;text-align: right;">
			  <label>Status</label>
			</td>
            <td style="width: 12%;">
              <select id="status" name="status" class="filter-status form-control" size="1">
			    <option value="0" selected="">All</option>
                <option value="Active" >Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
				<option value="On Leave">On Leave</option>
                <option value="Transfered">Transfered</option>
				<option value="Post">Posted</option>
				<option value="Post Back">Post Back</option> 
              </select>
            </td>
			
			<td style="width: 11%;text-align: right;">
			  <label style="">Facility Type</label>
			</td>
            <td style="width: 12%;">
              <select id="type" name="type" class="filter-status form-control" size="1">
			    <option value="0" selected="">All</option>
                <option value="CD">CD</option>
                <option value="RHC">RHC</option>
                <option value="BHU">BHU</option>
                <option value="THosp">THosp</option>
                <option value="THQ">THQ</option>
				<option value="DHQ">DHQ</option>
              </select>
            </td>
		  </tr></tbody>
		</table>

	
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div>  --> 
<?php } else{  ?>
			<table class="table table-bordered  mytable3" style="width: 97%;margin-left: 10px;">
          <tbody>
			
			<tr><td style="width: 8%;">
			  <label>Search</label>
			</td>
            <td style="width: 12%;">
             
			  <input id="cnicSearch" name="cnicSearch" placeholder="Name/CNIC/Phone" class="form-control" type="text">
            </td>
			
			<td style="width: 9%;text-align: right;">
			  <label>Status</label>
			</td>
            <td style="width: 12%;">
              <select id="status" name="status" class="filter-status form-control" size="1">
			    <option value="0" selected="">All</option>
                <option value="Active" >Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
				<option value="On Leave">On Leave</option>
                <option value="Transfered">Transfered</option>
				<option value="Post">Posted</option>
				<option value="Post Back">Post Back</option> 
              </select>
            </td>
			
			<td style="width: 11%;text-align: right;">
			  <label style="">Facility Type</label>
			</td>
            <td style="width: 12%;">
              <select id="type" name="type" class="filter-status form-control" size="1">
			    <option value="0" selected="">All</option>
                <option value="CD">CD</option>
                <option value="RHC">RHC</option>
                <option value="BHU">BHU</option>
                <option value="THosp">THosp</option>
                <option value="THQ">THQ</option>
				<option value="DHQ">DHQ</option>
              </select>
            </td>
		  </tr></tbody>
		</table>

         </div>
          <div class="row cmargin28">
        <!--<div class="col-xs-2 lbl-setting">
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
        </div>-->
                
         </div>
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> -->  
<?php }?>
  </form>
<table id="techdb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="top:-40px">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>                
                <th class="text-center Heading">Name</th>
                <th class="text-center Heading">Father Name</th>
				<th class="text-center Heading">CNIC</th>
                <th class="text-center Heading">Phone</th>
                <th class="text-center Heading">Health Facility Name</th>
                <th class="text-center Heading">Health Facility Type</th> 
				<?php if (($_SESSION['utype']=='Manager') || ($_SESSION['utype']=='DEO') ){?>
					<th class="text-center Heading">District</th>
				<?php } ?>
                <th class="text-center Heading">Catchment Population</th>                
                <th class="text-center Heading">Status</th>
				<th class="text-center Heading">Form Status</th>
			 <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>	
               <!-- <th class="text-center Heading">Technician Code</th> -->
				<th class="text-center Heading" style="width:100px;">
					<a href="<?php echo base_url(); ?>Technician/Add" class="red-tooltip" data-toggle="tooltip" title="Add New Technician">
                    <button class="submit btn-success btn-sm">
                    <i class="fa fa-plus"></i> Add New</button>
                  </a>
               </th>
               <?php } ?>
			   <?php if ($_SESSION['utype']=='Manager'){?>
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
          <td class="text-left" ><?php echo $row['technicianname']; ?></td>
          <td class="text-left" ><?php echo $row['fathername']; ?></td>
          <td class="text-center" ><?php echo $row['nic']; ?></td>         
          <td class="text-left" ><?php echo $row['facilityname']; ?></td>
		   <td class="text-center" ><?php echo $row['facilitytype']; ?></td>  
		<?php if ( ($_SESSION['utype']=='Manager') ){?>			  
          <td class="text-center" ><?php echo $row['district']; ?></td>
		<?php }?>
          <td class="text-center" ><?php echo $row['catch_area_pop']; ?></td>
          <td class="text-left" ><?php echo $row['status']; ?></td>
		  		 <td class="text-left" ><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ; ?></td>

		 <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>  
       
          <td class="text-center">
                      <a data-original-title="View" href="<?php echo base_url(); ?>Technician/View/<?php echo $row['techniciancode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
					<?php if($results[0]['status']=='Active') { ?>	
					<a data-original-title="Edit"  href="<?php echo base_url(); ?>Technician/Edit/<?php echo $row['techniciancode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					<?php } ?>
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
            /* echo $pagination;*/
            ?> 
            </div>
            </div>
          </div>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
 <!--<script src="<?php// echo base_url(); ?>includes/js/ajaxLoader.js" type="text/javascript"></script>-->
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
 
  <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>

    var columns = [
          { data: "serial" },
          { data: "technicianname" },
          { data: "fathername" },
          { data: "nic" },
          { data: "phone" },
           { data: "facilityname" },
           { data: "facilitytype" },
		   { data: "districtname" },
           { data: "catch_area_pop" },
           { data: "status" },
          { data: "is_temp_saved" },
          /*{ data: "districtname" },*/
			  
		   
          
          { 
		    data: "techniciancode",
			//data: "status",
            orderable: false,
            render : function(data,type, row) {
				//console.log(row['techniciancode']);
				if(row['status']=="Post" || row['status']=="Transfered" || row['status']=="Retired" || row['status']=="Died")
				{					
				 return '<a data-original-title="View" href="<?php echo base_url(); ?>Technician/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
          
				}else{
                return '<a data-original-title="View" href="<?php echo base_url(); ?>Technician/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" id="edit"  href="<?php echo base_url(); ?>Technician/Edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
				}
			}  
          }]; 
  <?php } elseif ($_SESSION['utype']=='Manager'){?>
    var columns = [
          { data: "serial" },
          { data: "technicianname" },
          { data: "fathername" },
          { data: "nic" },
          { data: "phone" },
           { data: "facilityname" },
           { data: "facilitytype" },
		   { data: "districtname" },
           { data: "catch_area_pop" },
           { data: "status" },
          { data: "is_temp_saved" },
          
          /*{ data: "districtname" },*/
          
          
           { data: "techniciancode" ,
            orderable: false,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>Technician/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
            }  
          }
        ]; 
  <?php } ?>
  var table = $('#techdb-tbl').DataTable({
        "pageLength" : 16,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Ajax_calls/tech_dataTables",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });
	  // //default load active 
	  table.columns(9).search("Active").draw();	 

  $('#distcode').on('change', function () {
    table.columns(7).search( this.value ).draw();
  });

  $('#tcode').on('change', function () {
    table.columns(6).search( this.value ).draw();
  });

  $('#facode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });
	$('#type').on('change', function (){
		table.columns(6).search(this.value).draw();
	});
  $('#status').on('change', function () {
	  <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
			table.columns(9).search( this.value ).draw();
	  <?php } else { ?>
			table.columns(9).search( this.value ).draw();
	  <?php } ?>
  });
   $('#status').on('change', function() {
      if ( this.value == "Transfered")
      //.....................^.......
      {
        $("#edit").hide();
      }
      else
      {
        $("#edit").show();
      }
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