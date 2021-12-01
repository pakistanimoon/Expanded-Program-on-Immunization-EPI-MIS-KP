<div class="container bodycontainer">
<div class="row">
   <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    	<ol class="breadcrumb">
         <?php  echo $this->breadcrumbs->show();?>
      </ol> 
      <div class="panel-heading"> List of Case Investigation Form</div>
      <div class="panel-body">
			<form method="post" id="filter-form"> 		   	
				<div class="row">   
					<div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
						<div class="col-xs-3">
							<input id="filter" name="searchParam" class="form-control form-control" type="text"/>
						</div>            
						<label class="col-xs-1 control-label lbl-setting"  for = "facode" >Facilities:</label>
						<div class="col-xs-3">
							<select id="facode" name="facode" class="filter-status  form-control">
								<option value="0" ></option>
								<?php foreach($resultFac as $row){ ?>
								<option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option>
								<?php } ?>
							</select>
						</div> 
					</div>
				</div>
				<div class="row" style="margin-top:5px;">   
					<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for = "facode" >Year-Week:</label>
					<div class="col-xs-1" style="width: 13.79%;">
						<select id="year" name="year" class="filter-status  form-control">
							<option value="0">All Years</option>
							<?php
							foreach($resultYear as $row){
							?>
							<option value="<?php echo $row['year'];?>" ><?php echo $row['year'];?></option>
							<?php } ?>
						</select>
					</div> 
					<div class="col-xs-1" style="width: 13.79%;">
						<select id="week" name="week" style="margin-left: -28px;" class="filter-status  form-control">
							<option value="0">All Weeks</option>
							<?php
							foreach($resultWeek as $row){
							?>
							<option value="<?php echo $row['week'];?>" ><?php echo $row['week'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>	     
			</form>
			<br>
			<br>
			<table data-filter="#filter" data-filter-text-only="true" style="margin-bottom: 0px;" class="table  table-hover table-striped footable table-vcenter tbl-listing footable-loaded">
				<thead>
					<tr style="background: white;color: black;">
						<th style="width: 20%;" class="">Cross Notified By <?php echo get_District_Name($this -> session -> District); ?></th>
						<th style="background: #8FEBAD;" class=""></th>
						<th style="width: 20%;" class="">Cross Notified To <?php echo get_District_Name($this -> session -> District); ?></th>
						<th style="background: #EBD38F;" class=""></th>
						<th style="width: 20%;" class="">Pending Cases</th>
						<th style="background: rgba(219, 37, 37, 0.5);" class=""></th>					
					</tr>
					<tr style="background: white;color: black;">
						<th style="width: 20%;" class="">District of Another Province</th>
						<th style="background: white;" class="">*</th>
						<!-- <th><?php //echo "*** District of Another Province"; ?></th> -->
					</tr>
					<!-- <tr style="background: white;color: black;">
						<th style="width: 20%;" class="">Cross Notified By <?php echo get_District_Name($this -> session -> District); ?> to District of Another Province</th>
						<th style="background: #4682B4;" class=""></th>
					</tr> -->
				</thead>
			</table>
			<br>
			<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
				<thead>
					<tr>
						<th class="text-center Heading">S#</th>
						<th class="text-center Heading">Case Name</th>
						<th class="text-center Heading">Health Facility Name</th>
						<th class="text-center Heading">Tehsil</th>
						<th class="text-center Heading">EPID Number</th>
						<th class="text-center Heading">Year-Week</th>				
						<th class="text-center Heading">Cross Notified(District)</th>
						<th class="text-center Heading">Date Patient Visited Hospital</th>
						<th class="text-center Heading">Form Status</th>
						<th class="text-center Heading">
							<a href="<?php echo base_url(); ?>Case_investigation/case_investigation" data-toggle="tooltip" title="Add New Case Investigation Form">
								<button class="submit btn-success btn-sm">
								<i class="fa fa-plus"></i> Add New</button>
							</a>
						</th>
					</tr>
				</thead>        

				<tbody id="tbody">
					<?php
						$i=$startpoint;
						foreach($result as $row){
						$i++;
						if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
							$color = "background-color:#8FEBAD;";
						}
						else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
							$color = "background-color:#EBD38F;";
						}
						else if($row['approval_status'] == "Pending"){
							$color = "background-color:rgba(219, 37, 37, 0.5);";
						}
						else{
							$color = "";
						}
					?>
<tr style="<?php echo $color; ?>">
	<td class="text-center"><?php echo $i; ?></td>
	<td class="text-center"><?php echo $row['patient_name']; ?></td>
	<td class="text-left"><?php echo $row['fac_name']; ?></td>                              
	<td class="text-left"><?php echo $row['tehsil']; ?></td>
	<td class="text-center"><?php echo $row['case_epi_no']; ?></td>							  
	<td class="text-center"><?php echo $row['fweek']; ?></td>
	<?php if(isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0 && $row['cross_notified']==1 && $row['cross_notified_from_distcode'] == $this->session->District && $row['distcode'] != ''){ ?>
	<td class="text-center"><?php echo get_District_Name($row['distcode']); ?></td>
	<?php } else if(/*isset($row['distcode']) && */$row['distcode'] == '') { ?>
		<td class="text-center"><?php echo $row['other_pro_district']; echo "*"; ?></td>
	<?php }else{ ?>
	<td class="text-center"><?php echo (isset($row['cross_notified_from_distcode']) && $row['cross_notified_from_distcode']>0)?get_District_Name($row['cross_notified_from_distcode']):''; ?></td>
	<?php } ?>
	<td class="text-center"><?php if(($row['pvh_date'])!=''){ echo date("d-M-Y",strtotime($row['pvh_date']));} ?></td>							  
	<td class="text-center"><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : ''; ?></td>
	<td class="text-center">
	<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_view/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
	<?php if($row['year'] >= "2018") { ?>
	<?php if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1){ ?>
		<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	<?php } } ?>
	</td>
</tr>
					<?php } ?>
				</tbody>
         </table>
         <br>
			<div class="row">
				<div class="col-sm-12" align="center">
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
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
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
				url: "<?php echo base_url(); ?>Ajax_red_rec/case_investigation_filter?page="+page,
				success: function(result){
					$("#filter").val('');
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			});        
		}); 
    });
	$('.filter-status').on('change' , function (){
		$('#tbody').html('');
		$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        $.ajax({
			type: "GET",
			data: $('#filter-form').serialize(),
			url: "<?php echo base_url(); ?>Ajax_red_rec/case_investigation_filter",
			dataType: "json",
			success: function(result){
				$('#tbody').html('');
				if(result != null){
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			}
        });
    });  
</script>