<!--start of page content or body-->
<?php //print_r($results);exit;
 $utype=$this -> session -> utype; 
$UserLevel=$_SESSION['UserLevel'];
?>
<div class="container bodycontainer">
<div class="row">
<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    <div class="panel panel-primary">
      <ol class="breadcrumb">
           <?php  echo $this->breadcrumbs->show();?>
        </ol> 
      <div class="panel-heading"> List of EPI Center
      </div>
      <div class="panel-body">
        <div class="row">   
          <div class="form-group">
            <label class="col-xs-1 lbl-setting" >Search:</label>
            <div class="col-xs-2">
              <input id="flcf_search" name="flcf_search" placeholder="Search" class="form-control " type="text" />
            </div>
             <?php if($UserLevel == 2){ ?>
        <div>
          <label onchange="getDistcode()" class="col-xs-1 control-label lbl-setting">District:</label>
        </div>
        <div class="col-xs-2">
          <select id="distcode" name="distcode" class="filter-status  form-control">
            <option value="" >--Select--</option>
             <?php
             foreach($resultDist as $row){
              ?>
              <option value="<?php echo $row['distcode']; ?>" ><?php echo $row['district']; ?></option>
              <?php } ?>
          </select>  
        </div>
<?php }?>
     <?php if($UserLevel == 3){ ?>
          <div>
            <label class="col-xs-2 control-label lbl-setting">Tehsil:</label>
          </div>
          <div class="col-xs-3">
            <select onclick="getTehValue()" id="tcode" name="tcode" class="filter-status  form-control">
            <option value="0">--Select--</option>
               <?php
                   foreach($resultTeh as $row){
               ?>
              <option value="<?php echo $row['tcode']; ?>" ><?php echo $row['tehsil']; ?></option>
               <?php }?>
            </select>
        </div>
     <?php } ?> 
            <label class="col-xs-2 control-label lbl-setting"   for = "facode" >Center Type:</label>
            <div class="col-xs-2">
              <select  id="fatype" onchange="getFacType()" name="fatype" class="filter-status form-control">
                <option value="0"></option>
                  <?php foreach($resultFac as $row){ ?>
                <option value="<?php echo $row['fatype'];?>" ><?php echo $row['fatype'];?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
		<br>
        <?php if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){ ?>
        
		<div class="row" style="margin-top:5px;">   
          <div class="form-group">
            <div class="col-xs-5" style="margin-left: 72% !important;">  
             <!-- <a href="<php echo base_url(); ?>EPICenters/Add">
                <button class="submit btn-success btn-sm"><i class="fa fa-plus"></i>   Add EPI Center </button> 
              </a> --->
              <a href="<?php echo base_url(); ?>EPICenters/Mark">
                <button class="submit btn-success btn-sm"><i class="fa fa-check-square-o"></i>   Mark EPI Center for EPI-MIS</button>
              </a>
          </div>
        </div>
    </div>
    <?php } ?>
<table id="flcf-tbl" class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
            <thead>
              <tr>
                <th class="text-center Heading">S#</th>
                <th class="text-center Heading">EPI Center Name</th>
                <th class="text-center Heading">Type</th> 
                <th class="text-center Heading">Code</th>
                <th class="text-center Heading">Area Type</th> 
                <th class="text-center Heading">Union Council</th>
                <th class="text-center Heading">Tehsil</th>
                <th class="text-center Heading">Disease Surveillance Facility Status</th>
                <th class="text-center Heading">Vaccination Facility Status</th>
                <th class="text-center Heading">Disease Surveillance Facility</th>
                <th class="text-center Heading">Vaccination Facility</th>
                <th class="text-center Heading">EPI Technicians</th>               
                <?php if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){ ?>
                  <th class="text-center Heading">Action</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody id="tbody">
  <?php
      $i=$startpoint;
      $tick = '<span style="color: green;"><strong>&#10004</strong></span>';
      $cross = '<span style="color: red;"><strong>&#10006</strong></span>';
//echo  $query="select sum(catch_area_pop) as catch_area_pop from lhwdb where facode='$row['facode']'";exit();
      foreach($results as $row){
         $facode= $row['facode'];
             $query="select sum(catch_area_pop) as catch_area_pop from techniciandb where facode='$facode'";
                      $catch=$this->db->query($query);
                      $catch_pop=$catch->row_array();
        $i++;
        ?>
        <tr>
          <td class="text-center"><span class="footable-toggle"></span><?php echo $i; ?></td>
          <td class="text-left" ><?php echo $row['fac_name']; ?></td>
          <td class="text-left" ><?php echo $row['fatype']; ?></td> 
          <td class="text-center" ><?php echo $row['facode']; ?></td>
          <td class="text-left" ><?php echo ucwords($row['areatype']); ?></td> 
          <td class="text-left" ><?php echo $row['unioncouncil']; ?></td>
          <td class="text-left" ><?php echo $row['tehsil']; ?></td>
		  <?php if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){ ?>
		  <td class="text-center" ><?php echo $row['ds_status']; ?>
		  <a href="<?php echo base_url(); ?>Status/View/<?php echo $row['facode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
          </td>  
		  <?php  } else { ?>
		  <td class="text-center" ><?php echo $row['ds_status']; ?>
          <?php } ?>  
		 </td>
		 <?php if (($_SESSION['UserLevel']=='3') && ($this -> session -> utype=='DEO') ){ ?>
		 <td class="text-center" ><?php echo $row['vacc_status']; ?>
		  <a href="<?php echo base_url(); ?>Status/View/<?php echo $row['facode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
		 
           </td>
		  <?php  } else{ ?>
          
		  <td class="text-center" ><?php echo $row['vacc_status']; ?>
		  
          <?php } ?>  
		  </td> 
		  
          <td class="text-center" ><?php echo ($row['is_ds_fac']? $tick: $cross); ?></td> 
          <td class="text-center" ><?php echo ($row['is_vacc_fac']? $tick: $cross); ?></td> 
          <td class="text-center" ><?php echo $row['total_technicians'];?></td>          
          <?php if (($_SESSION['UserLevel']=='2') && ($this -> session -> utype=='DEO') ){ ?>
    		  <td class="text-center"><a data-original-title="Edit" href="<?php echo base_url(); ?>System_setup/flcf_add?facode=<?php echo $row['facode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
          <a data-original-title="View" href="<?php echo base_url(); ?>System_setup/flcf_view?facode=<?php echo $row['facode']; ?>" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a></td>
    		  <?php } ?>
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
            // echo $pagination;
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

$(document).ready(function() {
 <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){?>
    var columns = [ 

				{ data: "serial",orderable: false,},
				{ data: "fac_name" },
				{ data: "fatype" },
				{ data: "facode" },
				{ data: "areatype" },
				{ data: "unioncouncil" },
				{ data: "tehsil"},
				{ data: "ds_status",orderable: false,
					render : function(data,type,row) {
					return row['ds_status']+'<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>'
			
					}
				},
				{ data: "vacc_status",orderable: false,
					render : function(data,type,row) {
						return row['vacc_status']+'<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>'
					}
				},
				{ data: "is_ds_fac",orderable: false,
					render : function(data,type,row) {
						if(row['is_ds_fac']=='1'){
							return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_ds_fac']+'"? $tick: $cross); ?> </a>'
						}else{
							return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_ds_fac']+'"? $cross: $tick); ?> </a>'
						}
					}
				},
				{ data: "is_vacc_fac",orderable: false,
					render : function(data,type,row) {
					if(row['is_vacc_fac']=='1'){
						return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_vacc_fac']+'"? $tick: $cross);?> </a>'
					}else{
						return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'"<?php echo ("'+row['is_vacc_fac']+'"? $cross: $tick);?> </a>'
					} 
					}
				},
				{ data: "total_technicians"},
				{ data: "facode",orderable: false,
					render : function(data,type,row) {
					
						return '<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a data-original-title="View" href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
					}
				}  
		]; 
  <?php } elseif (($_SESSION['utype']=='Manager')||($_SESSION['UserLevel']=='2')){?>
  

    var columns = [
			{ data: "serial",orderable: false,},
			{ data: "fac_name" },
			{ data: "fatype" },
			{ data: "facode" },
			{ data: "areatype" },
			{ data: "unioncouncil" },
			{ data: "tehsil"},
			{ data: "ds_status",orderable: false,
				render : function(data,type,row) {
					return row['ds_status']+'<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>'
			
				}
			},
			{ data: "vacc_status",orderable: false,
				render : function(data,type,row) {
					return row['vacc_status']+'<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>'
				}
			},
			{ data: "is_ds_fac",orderable: false,
				render : function(data,type,row) {
					if(row['is_ds_fac']=='1'){
						return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_ds_fac']+'"? $tick: $cross); ?> </a>'
					}else{
						return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_ds_fac']+'"? $cross: $tick); ?> </a>'
					}
				}
			},
			{ data: "is_vacc_fac",orderable: false,
				render : function(data,type,row) {
					if(row['is_vacc_fac']=='1'){
						return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'" <?php echo ("'+row['is_vacc_fac']+'"? $tick: $cross);?> </a>'
					}else{
					return '<a href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'"'+row['facode']+'"<?php echo ("'+row['is_vacc_fac']+'"? $cross: $tick);?> </a>'
					} 
				}
			},
			{ data: "total_technicians"},
			{ data: "facode",orderable: false,
				render : function(data,type,row) {
					return '<a href="<?php echo base_url(); ?>Status/View/'+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a><a data-original-title="View" href="<?php echo base_url(); ?>System_setup/flcf_view?facode='+row['facode']+'" data-toggle="tooltip" title="" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>'
				}
			}  
		]; 
		<?php } ?> 
	var table = $('#flcf-tbl').DataTable({
			"pageLength" : 15,  
			"serverSide": true,
			"order":[
				[1, "asc" ]
			],
			"ajax": {
				url : "<?php echo base_url(); ?>Ajax_calls/flcf_dataTables",
				type : 'GET'
			},
			"columns": columns,
			dom: 'lrtips'
	});
	
		table.columns(13).search("Active").draw();	 
		
		$('#fac_name').on('change', function () {
		table.columns(2).search( this.value ).draw();
		});
		$('#fatype').on('change', function () {
		table.columns(3).search( this.value ).draw();
		});
		$('#facode').on('change', function () {
		table.columns(4).search( this.value ).draw();
		});
		

		$('#flcf_search').on('keyup change', function () {
		table.search( this.value ).draw();
		});
});
/*var tcode=0;
  var fatype=0;
  var distcode=0;
  function getTehValue(){
    tcode=document.getElementById("tcode").value;
  }
  function getFacType(){
    fatype=document.getElementById("fatype").value;
  }
  function getDistcode(){
    distcode=document.getElementById("distcode").value;
  }
    $(document).ready(function() {
		var page=0;
    //executes code below when user click on pagination links
    $(document).on("click",".paginateMe",  function (e){
      e.preventDefault();
      $('#paging').html('')
      $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("id"); //get page number from link
        $.ajax({
          type: "GET",
         // data: $('#filter-form').serialize(),
          dataType:"json",
           url: "<?php echo base_url(); ?>Ajax_calls/facility_filter/"+page+"/"+tcode+"/"+fatype+"/"+distcode,
          success: function(result){
            $('#tbody').html(result.tbody);
            $('#paging').html(result.paging);
          }
        });
      });
  $('.filter-status').on('change' , function (){
     <?php if($UserLevel == 2){ ?>
				var distcode=document.getElementById("distcode").value;
	 <?php } ?>
	 <?php if($UserLevel == 3){ ?>
				var tcode=document.getElementById("tcode").value;
	 <?php } ?>
    $('#tbody').html('');
    $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
         page = 0; //get page number from link
        $.ajax({
          type: "GET",
          //data: $('#filter-form').serialize(),
           url: "<?php echo base_url(); ?>Ajax_calls/facility_filter/"+page+"/"+tcode+"/"+fatype+"/"+distcode,
          dataType: "json",
          success: function(result){
            $('#tbody').html('');
            if(result != null){
				if(result.tbody.trim() != ''){
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}else{
					$('#tbody').html('<p><strong>No facilities have been marked yet!</strong></p>');
				}
            }
          }
        });
      });
      }); */
    </script> 