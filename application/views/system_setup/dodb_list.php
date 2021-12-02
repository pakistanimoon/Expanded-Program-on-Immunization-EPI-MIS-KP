<!--start of page content or body-->
 <?php $utype= $_SESSION['utype'];?>
 <div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of Data Entry Operator
        </div>
         <div class="panel-body">
       <form method="post" id="filter-form">
        <?php if (($_SESSION['UserLevel']=='2') || ($_SESSION['UserLevel']=='3') || ($_SESSION['utype']=='Manager') || ($_SESSION['utype']=='DEO') ){?>
        <div class="row">
          <div class="col-md-1  col-xs-offset-1 col-sm-3 lbl-setting cmargin27">
            <label>Search:</label>
          </div>
          <div class="col-md-2 col-sm-3">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Name/CNIC/Phone" class="form-control" type="text">
             <span class="input-group-btn">
              <!--  <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button> -->
             </span>
          </a>
        </div>
      <!-- </div> -->
      <div class=" cmargin28">
		 <?php if (($_SESSION['UserLevel']=='2') && ($_SESSION['utype']=='Manager') ){?>
         <div class="col-xs-1  col-xs-offset-1 lbl-setting">
          <label>District:</label>
        </div>
        <div class="col-xs-2">
         <select id="distcode" onchange="getdistcodeValue()" name="distcode" class="filter-status  form-control">
              
               <?php
               foreach($resultDist as $row){
                ?>
                <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
                <?php } ?>
              </select>
        </div>
		 <?php } ?>
          <div class="col-xs-1  lbl-setting">
            <label>Status:</label>
          </div>          
          <div class="col-xs-2">
              <select onchange="getStatusValue()" id="status" name="status" class="filter-status form-control" size="1" >
                <option value="0">All</option>
                <option value="Active">Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
                <option value="Transfered">Transfered</option>
				<option value="Active-Temp">Temporary-Post</option>
              </select>
        </div>
         </div>
         </div>
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> -->  
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
                <option value="0">All</option>
                <option value="Active">Active</option>
                <option value="Terminated">Terminated</option>
                <option value="Died">Died</option>
                <option value="Retired">Retired</option>
                <option value="Transfered">Transfered</option>
				<option value="Active-Temp">Temporary-Post</option>
              </select>
        </div>
         </div>
         <br>
         <!-- <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
            <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> -->  
<?php }?>
  </form>
<table id="dodb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>                
                <th class="text-center Heading">Name</th>
                <th class="Heading text-center">CNIC</th>
                <th class="Heading text-center">Phone</th>
                <th class="Heading text-center">Employee Type</th>
                <th class="Heading text-center">District</th>
                <th class="text-center Heading">Status</th>
				<th class="text-center Heading">Form Status</th>

  <?php if ($_SESSION['UserLevel']=='3' && $utype=='DEO' ){?> 
                <th class="text-center Heading">
<a href="<?php echo base_url(); ?>DataEntry-Operator/Add" data-toggle="tooltip" title="Add New Data Entry-Operator">
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
             <tbody id="tbody" style="text-align:center;"> <!--
  <?php
      $i=$startpoint;
      foreach($results as $row){
        $i++;
        ?>
        <tr class="DrilledDown">
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>
         
          <td class="text-left" ><?php echo $row['deoname']; ?></td>
          <td class="text-center" ><?php echo $row['nic']; ?></td>
          <td class="text-center" ><?php echo $row['phone']; ?></td>
          <td class="text-left" ><?php echo $row['employee_type']; ?></td> 
          <td class="text-left" ><?php echo $row['district']; ?></td>
          <td class="text-center" ><?php echo $row['status']; ?></td>
		  <td class="text-center" ><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ; ?></td>
        <?php if ($_SESSION['UserLevel']=='3'  || $_SESSION['utype']=='DEO'){?>
          <td class="text-center">
                      <a data-original-title="View" href="<?php echo base_url(); ?>DataEntry-Operator/View/<?php echo $row['deocode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                      <a data-original-title="Edit" href="<?php echo base_url(); ?>DataEntry-Operator/Edit/<?php echo $row['deocode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                      
                  </td>
      <?php }?>
        </tr>
        <?php
      }
      ?>
              --></tbody> 
          </table>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6" align="center">
              <div id="paging">
             <?php // displaying paginaiton.
             /*if(isset($pagination)){
             	echo $pagination;
             }*/
            ?> 
            </div>
            </div>
          </div>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
</div><!--End of page content or body-->

<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<!--<script src="<?php echo base_url(); ?>includes/js/ajaxLoader.js" type="text/javascript"></script>-->
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
          { data: "serial",
           orderable: false,
		  },
          { data: "deoname" },
          { data: "nic" },
          { data: "phone" },
		  
          { data: "employee_type" },
          { data: "districtname" },
          { data: "status" },
          { data: "is_temp_saved" },
          { data: "deocode" ,
            orderable: false,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>DataEntry-Operator/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>DataEntry-Operator/Edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
            }  
          }
        ]; 
  <?php } elseif ($_SESSION['utype']=='Manager'){?>
    var columns = [
          { data: "serial",
           orderable: false,
		  },
          { data: "deoname" },
          { data: "nic" },
          { data: "phone" },
		  
          { data: "employee_type" },
          { data: "districtname" },
          { data: "status" },
          { data: "is_temp_saved" },
          { data: "deocode" ,
            orderable: false,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>DataEntry-Operator/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
            }  
          }
        ];  
  <?php } ?>
  var table = $('#dodb-tbl').DataTable({
        "pageLength" : 16,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Ajax_calls/do_dataTables",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });

  $('#distcode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });

  $('#tcode').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });

  $('#employee_type').on('change', function () {
    table.columns(4).search( this.value ).draw();
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