<!--start of page content or body-->
<?php
$i=$startpoint;
$tbodydata = '';
foreach($tabledata as $row){
	$i++;
	$edit_del='';
	if($row['data_source']=='web'){
		$edit_del='<a href="'.base_url().'vaccination/edit/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a><a  data-toggle="tooltip" title="Delete" onclick ="consumptiondelcst(this)" class="btn btn-xs btn-default"><i class="fa fa-close"></i></a>';	
	}
	$res=freezeReport('epi_consumption_master',$row['facode'],$row['fmonth'],Null,TRUE);
	if($res==1){
		$edit_del='';
	}
	$tbodydata .= '<tr>
		<td class="text-center">'.$i.'</td>
		<td class="text-center facode">'.$row['facode'].'</td>
		<td class="text-left">'.$row['fac_name'].'</td>
		<td class="text-left">'.$row['uc'].'</td>
		<td class="text-left">'.$row['tehsil'].'</td>
		<td class="text-center fmonth">'.$row['fmonth'].'</td>							  
		<td class="text-center">'.$row['created_date'].'</td>
		<td class="text-center">'.$row['data_source'].'</td>
		<td class="text-center">
			<a href="'.base_url().'vaccination/view/'.$row['fmonth'].'/'.$row['facode'].'" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
			'.$edit_del.'			
		</td>
	</tr>';

}?>
<div class="container bodycontainer"> 
	<div class="row">
		<div class="panel panel-primary"><?php 
			if($this -> session -> flashdata('message')){  ?>
				<div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div><?php 
			}?>
			<div class="panel-heading">Health Facility Monthly Consumption & Vaccination list</div>
			<div class="panel-body">
				<form method="post" id="filter-form">
					<div class="row">   
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
							<div class="col-xs-3">
								<input id="filter" name="searchParam" class="form-control form-control" type="text"/>
							</div>
							<label class="col-xs-2 control-label lbl-setting" for="facode">Facilities:</label>
							<div class="col-xs-3">
								<select id="facode" name="facode" class="filter-status form-control">
									<?php 
										getFacilities_options(false,NULL,NULL,'vaccine');
									?>
								</select>
							</div>
						</div>
					</div>
					<br>  
					<div class="row">   
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for = "year" >Year:</label>
							<div class="col-xs-3" >
								<select id="year" name="year" class="filter-status form-control">
								   <?php getYearsOptions(); ?>
								</select>
							</div> 
							<label class="col-xs-2 control-label lbl-setting"  for = "month" >Month:</label>
							<div class="col-xs-3">
								<select id="month" name="month" class="filter-status form-control"></select>
							</div>
						</div>
					</div>      
				</form>
				<br>
				<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
							<th class="text-center Heading">S#</th>
							<th class="text-center Heading">Health Facility Code</th>
							<th class="text-center Heading">Health Facility Name</th>
							<th class="text-center Heading">Union Council</th>
							<th class="text-center Heading">Tehsil</th>
							<th class="text-center Heading">Year-Month</th>
							<th class="text-center Heading">Record Date</th>
							<th class="text-center Heading">Date Source</th>
							<th class="text-center Heading">
								<a href="<?php echo base_url(); ?>vaccination/add" class="submit btn-default btn-sm" style="padding:3px 10px;"><i class="fa fa-plus"></i>Add New</a>
							</th>
						</tr>
					</thead>
					<tbody id="tbody"><?php echo $tbodydata; ?></tbody>
				</table>
				<br>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div id="paging"><?php echo $pagination;?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on("click",".paginateMe",  function (e){
			e.preventDefault();
			$('#paging').html('')
			$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
			$(".loading-div").show();
			var page = $(this).attr("id");
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				dataType:"json",
				url: "<?php echo base_url(); ?>Ajax_calls/consumption_vaccination_filter?page="+page,
				success: function(result){
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
			url: "<?php echo base_url(); ?>Ajax_calls/consumption_vaccination_filter",
			dataType: "json",
			success: function(result){
				$('#tbody').html('');
				if(result != null){
					//console.log(result.tbody);
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			}
		});
	});
	//delete vaccination & consumption report 
	function consumptiondelcst(ab){		
		var facode=$(ab).closest('tr').find('.facode').text();
		var fmonth=$(ab).closest('tr').find('.fmonth').text();
		var res=confirm("Are You Sure to Delete that Report ?");
		if(res==true && facode!="" && fmonth!="")
		{
			window.location.href="<?php echo base_url(); ?>vaccination/delete/"+fmonth+"/"+facode+"";
		}
		else
		{
			//nothing
		}	
	
	};
</script>