
 <div class="container bodycontainer">
<div class="row">
       <div class="panel-heading" style="color: #ffffff;"> List Outbreak Response
        </div>
         <div class="panel-body">
	   <?php if($this->session->utype=='Manager'){ ?>
	   <form method="post" id="filter-form">
        <!-- <div class="row">
          
      </div> -->
     <table class="table table-bordered  mytable3" style="width: 97%;margin-left: 10px;">
          <tbody>
			
			<tr>
				<td style="width: 2%;">
				  <label>District</label>
				</td>
				<td style="width: 12%;">
				  <select id="distcode" name="distcode" style="width: 150px;" class="filter-status  form-control">
					<option value="0">All</option>
				  <?php getDistricts_options(false); ?>
				  </select>
				</td>
		  </tr></tbody>
		</table>
		</form>
<?php } ?>
<table id="myTable" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true" style="padding-top:2%;">
  <thead>
    <tr>
      <th class="text-center Heading">S#</th> 
      <th class="text-center Heading">Vcode</th>
	  <?php $count=6;
	  if($this->session->utype=='Manager'){ $count=7;?>
		<th class="text-center Heading">District</th>      
	  <?php } ?>
      <th class="text-center Heading">Tehsil</th>                     
      <th class="text-center Heading">Union Council</th>
      <th class="text-center Heading">Disease</th>
      <th class="text-center Heading">Date of Activity</th>    
      	 
        <th class="text-center Heading">
			<?php if($this->session->UserLevel=='3' && $this->session->utype=='DEO'){ ?>
           <a href="<?php echo base_url(); ?>Add-case" data-toggle="tooltip" title="Add New Case">
            <button class="submit btn-success btn-sm">
            <i class="fa fa-plus"></i> Add New</button>
          </a>
			<?php }else{  echo "Action";} ?>
        </th>     
    </tr>
  </thead>
  <tbody id="tbody" style="text-align:center;">
 <!--  <?php
      //foreach ($measles_case_response as $key ) { ?>
      <tr>
        <td><?php// echo $key['id']?></td>
        <td><?php //echo $key['distcode']?></td>
        <td><?php //echo $key['uncode']?></td>
        <td><?php //echo $key['date_of_activity']?></td>
        <td><?php// echo $key['health_education_sessions']?></td>
      </tr>
    <?php  //} ?> -->                  
  </tbody>
    </table>
    </div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
	<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
  
    var columns = [
          { data: "serial",
		  orderable: false,
		  },
          { data: "vcode" },
          { data: "tehsil" },
          { data: "unioncouncil" },
          { data: "disease" },
          { data: "date_of_activity" },
          { orderable: false,
            render : function(data, type, full) {
                return '   <a href="<?php echo base_url(); ?>Case-View/'+full.vcode+'/'+full.date_of_activity+'" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true"></i></a><a href="<?php echo base_url(); ?>Case-Edit/'+full.vcode+'/'+full.date_of_activity+'" class="btn edit-btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }  
          }
		   
        ]; 
  <?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
	var columns = [
          { data: "serial",
		  orderable: false,
		  },
          { data: "vcode" },
		  { data: "district" },
          { data: "tehsil" },
          { data: "unioncouncil" },
          { data: "disease" },
          { data: "date_of_activity" },
		  { orderable: false,
            render : function(data, type, full ) {
                return '   <a href="<?php echo base_url(); ?>Case-View/'+full.vcode+'/'+full.date_of_activity+'" class="btn view-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>';
            }
          }
        ];
  <?php } ?>
 
  var table = $('#myTable').DataTable({
		"pageLength" : 15,
        "serverSide": true,
        "order": [
          [1, "desc" ]
        ],
        "ajax": {
            url : "<?php echo base_url(); ?>Case_response/case_list",
            type : 'GET'
        },
        "columns": columns,
        dom: 'lrtips'
      });

$('#distcode').on('change', function () {
    table.columns(2).search( this.value ).draw();
  });
  
});

</script>