<?php 
	$cnfweek = $this -> uri -> segment(3);
	$cnyear = substr($cnfweek, 0, 4);
	$cnwk = substr($cnfweek, 5, 7);
	if($cnwk < 10){
		$cnweek = substr($cnwk, 1, 1);
	}
	else{
		$cnweek = $cnwk;
	}
	//echo $cnyear; exit();
?>
<div class="container bodycontainer">
<div class="row">
   <div class="panel panel-primary">
    	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    	<ol class="breadcrumb">
         <?php  echo $this->breadcrumbs->show();?>
      </ol> 
      <div class="panel-heading"> List of Coronavirus Investigation Cases</div>
      <div class="panel-body">
			<form method="post" id="filter-form"> 		   	
				<div class="row">   
					<div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
						<div class="col-xs-3">
							<input id="filter" name="searchParam" class="form-control form-control" type="text"/>
						</div>            
						
						<label class="col-xs-2 control-label lbl-setting"  for = "facode" >Category of Cases:</label>
						<div class="col-xs-3">
							<select id="distcode" name="distcode" class="filter-status form-control">
								<option value="0" > All Cases</option>
								<?php $distcode = $this -> session -> District; { ?>
									<option value="<?php echo $distcode;?>" >Suspected Cases (within <?php echo get_District_Name($distcode); ?>)</option>
									<option style="background: #8FEBAD;" value="<?php echo 'by_dist'; ?>" >Cases Cross Notifed by <?php echo get_District_Name($distcode);?></option>
									<option style="background: #EBD38F;" value="<?php echo 'from_dist'; ?>" >Cases Cross Notified to <?php echo get_District_Name($distcode);?></option>
									<option style="background: rgba(219, 37, 37, 0.5);" value="<?php echo 'pending_dist'; ?>" >Pending Cross Notified Cases</option>
									<option style="background: #33ACFF;" value="<?php echo 'other_prov_dist'; ?>" >Cases Cross Notified to other Provinces</option>								
								<?php } ?>
							</select>
						</div> 
					</div>
				</div>
				<div class="row" style="margin-top:5px;">					
					<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for = "facode" >Facilities:</label>
					<div class="col-xs-3">
						<select id="facode" name="facode" class="filter-status  form-control">
							<option value="0" ></option>
							<?php foreach($resultFac as $row){ ?>
							<option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option>
							<?php } ?>
						</select>
					</div>
				<!-- </div>
				<div class="row" style="margin-top:5px;">	 -->				  
					<label class="col-xs-2 control-label lbl-setting"  for = "facode" >Year-Week:</label>
					<div class="col-xs-1" style="width: 13.79%;">
						<select id="year" name="year" class="filter-status  form-control">
							<option value="0">All Years</option>
							<?php
							foreach($resultYear as $row){
							?>
							<option value="<?php echo $row['year']; ?>" ><?php echo $row['year']; ?></option>
							<?php } ?>
						</select>
					</div> 
					<div class="col-xs-1" style="width: 13.79%;">
						<select id="week" name="week" style="margin-left: -28px;" class="filter-status  form-control">
							<option value="0">All Weeks</option>
							<?php
							foreach($resultWeek as $row){
							?>
							<option value="<?php echo $row['week']; ?>" ><?php echo $row['week']; ?></option>
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
						<th style="width: 20%;" class="">Cross Notified to Another Province</th>
						<th style="background: #33ACFF;" class=""></th>
					</tr>
				</thead>
			</table>			
			<br>
			<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
				<thead>
					<tr>
						<th class="text-center Heading">S#</th>
						<th class="text-center Heading">Patient Name</th>
						<th class="text-center Heading">Age in Years</th>
						<th class="text-center Heading">Health Facility Name</th>
						<th class="text-center Heading">Union Council</th>
						<th class="text-center Heading">Tehsil</th>
						<th class="text-center Heading">EPID Number</th>
						<th class="text-center Heading">Year-Week</th>				
						<th class="text-center Heading">Cross Notified(District)</th>
						<th class="text-center Heading">Date Patient Visited Hospital</th>
						<!-- <th class="text-center Heading">Form Status</th> -->
						<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ ?>
						<th class="text-center Heading">
							<a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation" data-toggle="tooltip" title="Add New">
								<button class="submit btn-success btn-sm">
								<i class="fa fa-plus"></i> Add New</button>
							</a>
						</th>
						<?php }?>
						<?php if (($_SESSION['UserLevel']=='99') || ($_SESSION['UserLevel']=='4')){?>
							<th class="text-center Heading">Action</th>
						<?php }?>
					</tr>
				</thead>        

				<tbody id="tbody">
					<?php
					// $sessionProcode = $_SESSION["Province"];
					// echo $sessionProcode;exit();
					// print_r($result);exit();
						$i=$startpoint;
						foreach($result as $row){
						$i++;
						if($row['cross_notified_from_distcode'] == $this  -> session -> District && $row['approval_status'] == "Approved"){
							$color = "background-color:#8FEBAD;";
						}
						else if($row['cross_notified_from_distcode'] != $this  -> session -> District && $row['approval_status'] == "Approved"){
							$color = "background-color:#EBD38F;";
						}
						else if($row['approval_status'] == "Pending" && $row['procode'] != $_SESSION["Province"]){
							$color = "background-color:#33ACFF;";
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
	<td class="text-center"><?php echo $row['name']; ?></td>
	<td class="text-center"><?php echo $row['age_in_year']; ?></td>
	<td class="text-left"><?php echo isset($row['facode']) && $row['facode']!= NULL && $row['facode']!= ''?CrossProvince_FacilityName($row['facode']): ''; ?></td> 
	<td class="text-left"><?php echo isset($row['uncode']) && $row['uncode']!= NULL && $row['uncode']!= ''?CrossProvince_UCName($row['uncode']): ''; ?></td>                             
	<td class="text-left"><?php echo isset($row['tcode']) && $row['tcode']!= NULL && $row['tcode']!= ''?CrossProvince_TehsilName($row['tcode']): ''; ?></td>
	<td class="text-center"><?php echo $row['case_epi_no']; ?></td>							  
	<td class="text-center"><?php echo $row['fweek']; ?></td>

	<?php if($row['cross_notified'] == '0') { ?>

		<td class="text-center"><?php echo ''; ?></td>

	<?php } else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] == $this-> session-> District){ ?>	

		<td class="text-center"><?php echo CrossProvince_DistrictName($row['distcode']); ?></td>

	<?php } else if(isset($row['cross_notified']) && $row['cross_notified'] == 1 && $row['cross_notified_from_distcode'] != $this-> session-> District){ ?>	

		<td class="text-center"><?php echo CrossProvince_DistrictName($row['cross_notified_from_distcode']); ?></td>

	<?php } else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) == $_SESSION["Province"]){ ?>
		<td class="text-center">
			<?php
				echo CrossProvince_DistrictName($row['cross_notified_from_distcode']);
			?>	
		</td>
	<?php } else if($row['cross_notified'] == 1 && substr($row['cross_notified_from_distcode'],0,1) != $_SESSION["Province"]) { ?>

		<td class="text-center">
			<?php 
				echo CrossProvince_DistrictName($row['distcode']); 
			?>
				
		</td>

	<?php } else { ?>
		<td class="text-center"><?php echo ''; ?></td>
	<?php } ?>

	<td class="text-center"><?php if(($row['pvh_date'])!=''){ echo date("d-M-Y",strtotime($row['pvh_date']));} ?></td>							  
	<!-- <td class="text-center"><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : ''; ?></td> -->
	<td class="text-center">
		<a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_view/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
		<?php if($row['year'] >= "2018") { ?>
			<?php if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1){ ?>
		<a href="<?php echo base_url(); ?>Coronavirus_investigation/coronavirus_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
	<?php } } ?>
	<?php } ?>
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
<body onload="crossNotifiedfweek()">

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
				url: "<?php echo base_url(); ?>Ajax_red_rec/coronavirus_investigation_filter?page="+page,
				success: function(result){
					//var decodedresult = $.parseJson(result);
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
			url: "<?php echo base_url(); ?>Ajax_red_rec/coronavirus_investigation_filter",
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

	function crossNotifiedfweek(){
		var year = '<?php echo $cnyear; ?>';
		var week = '<?php echo $cnweek; ?>';
		$("#year option[value="+year+"]").prop("selected",true);
		$("#week option[value="+week+"]").prop("selected",true);		
		$("#distcode option[value=pending_dist]").prop("selected",true);
		
		$.ajax({
			type: "GET",
			data: $('#filter-form').serialize(),
			url: "<?php echo base_url(); ?>Ajax_red_rec/cross_notified_measles_investigation_filter",
			dataType: "json",
			success: function(result){
				$('#tbody').html('');
				if(result != null){
					$('#tbody').html(result.tbody);
					$('#paging').html(result.paging);
				}
			}
   		});
	}
	<?php //if(isset($cnfweek) && ($cnfweek > 0 || $cnfweek != '')) { ?>
		// $(document).on('change','#year,#week',function(){
		// 	var year = $("#year").val();
		// 	var week = $("#week").val();		
		// 	url = "<?php //echo base_url(); ?>Ajax_red_rec/cross_notified_measles_investigation_filter/"+year+"-"+week,
		// });
	<?php //} ?>
</script>