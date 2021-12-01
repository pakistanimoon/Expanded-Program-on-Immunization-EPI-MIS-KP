<!--start of page content or body-->
<?php $utype=$this -> session -> utype; 
$UserLevel=$_SESSION['UserLevel'];
?>
 <div class="container bodycontainer">
<div class="row">
  <?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
   <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of District Surveillance Officer
        </div>
         <div class="panel-body">
 <form method="post" id="filter-form">
 
 
 


<div class="row" style="margin: 0 auto;width: 99%;">
          <div>
            <label class="col-xs-1  control-label lbl-setting">Search:</label>
          </div>
          <div class="col-xs-2">
              <a class="input-group demo-input-group">
            <input id="cnicSearch" name="cnicSearch" placeholder="Name/CNIC/Phone" class="form-control" type="text">
             <span class="input-group-btn">
               <!-- <button class="btn btn-success" name="cnicbtn" id="cnicbtn" type="button">Search!</button> -->
             </span>
          </a>
        </div>
                <?php if($UserLevel == 2){ ?>
        <div>
          <label class="col-xs-1 control-label lbl-setting">District:</label>
        </div>
        <div class="col-xs-2">
          <select id="distcode" name="distcode" class="filter-status  form-control">
            <option value="" >All</option>
             <?php
             foreach($resultDist as $row){
              ?>
              <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
              <?php } ?>
          </select>  
        </div>
<?php }?>
        
           
      <!-- </div> -->
      <!-- <div class="row cmargin28">                
      
         </div> -->
        
    <div>
            <label class="col-xs-1  control-label lbl-setting" style="width: 12%;">Employee Type:</label>
          </div>
          <div class="col-xs-2">
            <select onclick="getEmpValue()" id="employee_type" name="employee_type" class="filter-status  form-control" style="/*! width: 100%; */margin-left: -20px;">
              <option value="0">All</option>
                             <option value="Contract">Contract</option>
                             <option value="Regular">Regular</option>
                           </select>
        </div>
        <label class="col-xs-1 control-label lbl-setting" for="status" style="position: relative;margin-left: -10p;margin-left: -32px;">Status:</label>
           <div class="col-xs-2" style="margin-left: -19px;">
              <select id="status" name="status" onchange="getstatusValue()" class="filter-status  form-control" style="width: 100%;">
                <option value="0">All</option>
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
 


		
		
		
		
         <br>
        <!-- ##### 06-07-2017 ######-->
        <!--  <div class="row cmargin29">
           <div class="col-xs-3 col-xs-offset-9">
           <input type="text" id="filter" name="searchParam" class="form-control" placeholder="Search By Any Field" style="border-radius: 0px !important;">
           </div>
          </div> --> 
      
</form>
<table id="dsodb-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">




            <thead>
              <tr>
                <th class="text-center Heading">S#</th>                
                <th class="text-center Heading">Name</th>
                <th class="text-center Heading">CNIC</th>                
                <th class="text-center Heading">Landline Phone#</th>
                <th class="text-center Heading">Cell Phone#</th>
                <th class="text-center Heading">Employee Type</th>                
                <th class="text-center Heading">District</th>
                <th class="text-center Heading">Status</th>
                <th class="text-center Heading">Form Status</th>
                <?php if ($_SESSION['UserLevel']=='3' && $utype=='DEO' ){?>
                  <th class="text-center Heading" style="width:50px;">
                     <a href="<?php echo base_url(); ?>DSO/Add" class="red-tooltip" data-toggle="tooltip" title="Add New District Surveillance Officer">
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
             <tbody id="tbody" style="text-align:center;"> 
  <?php
  $i=$startpoint;
  foreach($results as $row){ 
//echo '<pre>';print_r($results);exit(); 
    $i++;
    ?>
    <tr class="DrilledDown"> 
      <td class="text-center"><?php echo $i; ?></td>      
      <td class="text-left"><?php echo $row['dsoname'];?></td>
      <td class="text-center"><?php echo $row['nic'];?></td>     
      <td class="text-center"><?php echo $row['telephone'];?></td>
      <td class="text-center"><?php echo $row['phone'];?></td>
      <td class="text-left"><?php echo $row['employee_type'];?></td>
      <td class="text-left"><?php echo $row['district'];?></td>
      <td class="text-center"><?php echo $row['status'];?></td> 
    <td class="text-center"><?php echo  $row['is_temp_saved'] == '0' ? 'Submitted' : 'Not Submitted' ;?></td>      
    
      <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
      <td class="text-center">
        <a data-original-title="View" href="<?php echo base_url(); ?>DSO/View/<?php echo $row['dsocode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
        <a data-original-title="Edit" href="<?php echo base_url(); ?>DSO/Edit/<?php echo $row['dsocode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
       <!--  <a data-original-title="Delete" href="<?php //echo base_url(); ?>System_setup/lhsdb_delete/<?php //echo $row['lhscode']?>" data-toggle="tooltip" title="" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a> -->
	 
	  
      <?php } ?>
	   
	   </td>
  <!-- </tr> -->
  <?php
}
?>                       
             <!--  </tbody> -->
          </table>
         <div class="row">
            <div class="col-sm-6 col-sm-offset-6" align="center">
              <div id="paging">
             <?php // displaying paginaiton.
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
          { data: "dsoname" },
          { data: "nic" },
          { data: "telephone" },
           { data: "phone" },
          { data: "employee_type" },
          { data: "districtname" },
          { data: "status" },
          { data: "is_temp_saved" },
          { data: "dsocode" ,
            orderable: false,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>DSO/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a><a data-original-title="Edit" href="<?php echo base_url(); ?>DSO/Edit/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>'
            }  
          }
  ]; <?php } elseif ($_SESSION['utype']=='Manager'){?>
    var columns = [
          { data: "serial" ,
		  orderable: false,
		  },
          { data: "dsoname" },
          { data: "nic" },
          { data: "telephone" },
           { data: "phone" },
          { data: "employee_type" },
          { data: "districtname" },
          { data: "status" },
          { data: "is_temp_saved" },
          { data: "dsocode" ,
            orderable: false,
            render : function(data, type, row) {
                return '<a data-original-title="View" href="<?php echo base_url(); ?>DSO/View/'+data+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
            }  
          }
        ]; 
  <?php } ?>
  var table = $('#dsodb-tbl').DataTable({
        "pageLength" : 16,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Ajax_calls/dso_dataTables",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });
	  // //default load active 
	  table.columns(7).search("Active").draw();	
	  
$('#employee_type').on('change', function () {
    table.columns(5).search( this.value ).draw();
  });
  $('#distcode').on('change', function () {
    table.columns(6).search( this.value ).draw();
  });
  $('#status').on('change', function () {
    table.columns(7).search( this.value ).draw();
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