<!--start of page content or body-->
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<ol class="breadcrumb">
				<?php  echo $this->breadcrumbs->show();?>
			</ol> 
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading"> List Health Facility Monthly Vaccination Reports</div>
			<div class="panel-body">
				<form method="post" id="filter-form">
					<div class="row">   
						<div class="form-group">
							<label class="col-xs-1 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
							<div class="col-xs-2">
								<input  id="filter" name="findParam" class="form-control form-control" type="text"/>
							</div>
							<label class="col-xs-1 control-label lbl-setting"  for = "year" >Year:</label>
							<div class="col-xs-2" >
							  <select id="year" name="year" class="filter-status  form-control">
								<?php echo getYearsOptions(); ?>
							  </select>
							</div> 
							<label class="col-xs-1 control-label lbl-setting"  for = "month" >Month:</label>
							<div class="col-xs-2">
							  <select id="month" name="month" class="filter-status  form-control">
							 </select>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:5px;">   
						<div class="form-group">
							<label class="col-xs-1 col-xs-offset-1 control-label lbl-setting"  for = "facode" >UC:</label>
								<div class="col-xs-2">
									<select id="uncodefilter" name="uncode" class="filter-status  form-control">
										<option value="0"></option>
										<?php
										foreach($resultUcs as $row){?>
											<option value="<?php echo $row['uncode'];?>" ><?php echo $row['unname'];?></option><?php
										}?>
									</select>
								</div>
							<?php if($UserLevel == 2 || $UserLevel == 3 ){  ?>
								<label class="col-xs-1 control-label lbl-setting"  for = "facode" >HF:</label>
								<div class="col-xs-2">
									<select id="facode" name="facode" class="filter-status form-control">
										<option value="0"></option>
										<?php foreach($resultFac as $row){?>
											<option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option>
										<?php  } ?>
									</select>
								</div> 
							<?php } ?>							          
						
					<label class="col-xs-1 control-label lbl-setting"  for = "facode" >Technicians:</label>
						<div class="col-xs-2">
							<select id="vacc_name" name="vacc_name" class="filter-status  form-control">
								<!-- <option value="0"></option> -->
								<?php
								foreach($resultveccname as $row){?>
									<option value="<?php echo $row['vacc_name'];?>" ><?php echo $row['vacc_name'];?></option><?php
								}?>
							</select>
						</div>
					
						</div>
					</div>	
					<?php if($UserLevel == 2){  ?>
						<div class="row">   
							<div class="form-group">
								<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >District:</label>
								<div class="col-xs-3">
									<select id="distcode" name="distcode" class="filter-status  form-control">
										<option value="0"></option>
										<?php
										foreach($resultDist as $row){ ?>
											<option value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option>
										<?php  } ?>
									</select>
								</div>
							</div>
						</div>
					<?php } ?> 
				</form>
				<br>
				<br>
				<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
							<th class="text-center Heading">S#</th>
							<th class="text-center Heading">Health Facility Name</th>
							<th class="text-center Heading">Health Facility Type</th>
							<th class="text-center Heading">Health Facility Code</th>
							<th class="text-center Heading">Attached Technician</th>
							<th class="text-center Heading">Union Council Name</th>
							<th class="text-center Heading">Year-Month</th>
							<th class="text-center Heading">
								<a href="<?php echo base_url(); ?>FLCF-MVRF/Add" data-toggle="tooltip" title="Add New Facility Monthly Vaccination Report">
                                    <button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button>
                                </a>
							</th>
						</tr>
					</thead>
					<tbody id="tbody"><?php
						$i=$startpoint;
						foreach($result as $row){
							$i++;?>
							<tr>
								<td class="text-center"><?php echo $i; ?></td>		
								<td class="text-left"><?php echo $row['facilityname']; ?></td>
								<td class="text-center"><?php echo $row['facilitytype']; ?></td>
								<td class="text-center"><?php echo $row['facode']; ?></td>
								<td class="text-left"><?php echo $row['vacc_name']; ?></td>
								<td class="text-left"><?php echo $row['unioncouncil']; ?></td>
								<td class="text-center"><?php echo $row['fmonth']; ?></td>
								<td class="text-center">
									<a href="<?php echo base_url(); ?>FLCF-MVRF/View/<?php echo $row['facode']; ?>/<?php echo $row['fmonth']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="<?php echo base_url(); ?>FLCF-MVRF/Edit/<?php echo $row['facode']; ?>/<?php echo $row['fmonth']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
									<!--<a href="<?php echo base_url(); ?>Data_entry/fmvrf_delete/<?php echo $row['facode']; ?>/<?php echo $row['fmonth']; ?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>-->
								</td>
							</tr><?php
						}?>
                    </tbody>
				</table>
				<br>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div id="paging"><?php 
						   // displaying paginaiton.
						   echo $pagination; ?> 
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
/*$('#yearHF').on('change', function(){
    var year = this.value;
   
    
    $.ajax({
      type: "POST",
     data: "year="+year,
      url: "<?php echo base_url(); ?>Ajax_calls/getMonthsHF",
      success: function(result){
        $('#month').html(result);
      }
    });
  });*/

 function search(term){

      var findParam = term;
     
       $('#tbody').html('');
       $('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        //var page = $(this).attr("id"); //get page number from link
        $.ajax({
          type: "GET",
          data: "findParam="+findParam,
          url: "<?php echo base_url(); ?>Ajax_calls/fastSearch",
          dataType: "json",
          success: function(result){
            //console.log(result);
            $('#tbody').html('');
            if(result != null){
              $('#tbody').html(result.tbody);
                $('#paging').html(result.paging);
            }
            


          }

        });

    }

    
    $(document).ready(function() {
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
				url: "<?php echo base_url(); ?>Ajax_calls/fac_mvrf_filter?page="+page,
				success: function(result){
					console.log(result);
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			});        
		});
	});
	$('.filter-status').on('change' , function (){
		$('#tbody').html('');
		$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        //var page = $(this).attr("id"); //get page number from link
        $.ajax({
			type: "GET",
			data: $('#filter-form').serialize(),
			url: "<?php echo base_url(); ?>Ajax_calls/fac_mvrf_filter",
			dataType: "json",
			success: function(result){
				console.log(result);
				$('#tbody').html('');
				if(result != null){
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
            }
        });
    });
	
</script>