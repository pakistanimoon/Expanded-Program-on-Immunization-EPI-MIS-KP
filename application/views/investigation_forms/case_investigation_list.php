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

	if($this -> uri -> segment(4) != ''){
		$caseType = $this -> uri -> segment(4);
	}
	else{
		$caseType = '';
	}
	//echo $cnweek; exit();
?>
<div class="container bodycontainer">
<div class="row">
   	<div class="panel panel-primary">
		<?php if($this -> session -> flashdata('message')){ ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
    	<ol class="breadcrumb">
        	<?php echo $this->breadcrumbs->show(); ?>
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
							<!-- <label class="col-xs-2 control-label lbl-setting" for = "facode">Cross Notified Districts:</label>
							<div class="col-xs-3">
								<select id="cross_notified_from_distcode" name="cross_notified_from_distcode" class="filter-status form-control">
									<option value="0" ></option>
									<?php //foreach($resultDist as $row){ ?>
										<option value="<?php //echo $row['cross_notified_from_distcode'];?>" ><?php //echo $row['cross_notified_from_distname']; ?></option>
									<?php //} ?>
								</select>
							</div> -->
							<label class="col-xs-2 control-label lbl-setting"  for = "facode" >Category of Cases:</label>
							<div class="col-xs-3">
								<select id="distcode" name="distcode" class="filter-status form-control">
									<option value="0"> All Cases</option>
									<?php $distcode = $this -> session -> District; { ?>
									<option value="<?php echo $distcode;?>">Suspected Cases (within <?php echo get_District_Name($distcode); ?>)</option>
									<option style="background: #8FEBAD;" value="<?php echo 'by_dist'; ?>">Cases Cross Notifed by <?php echo get_District_Name($distcode);?></option>
									<option style="background: #EBD38F;" value="<?php echo 'from_dist'; ?>">Cases Cross Notified to <?php echo get_District_Name($distcode);?></option>
									<option style="background: rgba(219, 37, 37, 0.5);" value="<?php echo 'pending_dist'; ?>">Pending Cross Notified Cases</option>
									<option style="background: #33ACFF;" value="<?php echo 'other_prov_dist'; ?>">Cases Cross Notified to other Provinces</option>
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
						<th class="text-center Heading">Case Type</th>
						<th class="text-center Heading">Date Patient Visited Hospital</th>
						<!-- <th class="text-center Heading">Form Status</th> -->
						<th class="text-center Heading">
							<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
								<a href="<?php echo base_url(); ?>Case_investigation/case_investigation" data-toggle="tooltip" title="Add New">
									<button class="submit btn-success btn-sm">
									<i class="fa fa-plus"></i> Add New</button>
								</a>
							<?php } else{?>
								Action
							<?php }?>
						</th>
					</tr>
				</thead>        

				<tbody id="tbody">
					<?php
						$diseaseArray = array('AWD/Chol<5', 'HepB<5', 'CL', 'Anth', 'VL', 'SARI', 'DF', 'DHF', 'CCHF', 'ChTB', 'Diph', 'Men', 'Pert', 'Mal', 'Pneu', 'DogBite', 'B Diar', 'AIDS', 'Typh', 'Scab', 'AWD/Chol>5', 'AVHep', 'Other', 'Msl', 'Polio', 'Covid');
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
<tr class="row_id" style="<?php echo $color; ?>">
	<td class="text-center">
		<input type="hidden" class="id" name="id" value="<?php echo $row['id']; ?>">
		<input type="hidden" class="year" name="year" value="<?php echo $row['year']; ?>">
		<input type="hidden" class="case_type" name="case_type" value="<?php echo $row['case_type']; ?>">
		<?php echo $i; ?>
	</td>
	<td class="text-center"><?php echo $row['patient_name']; ?></td>
	<td class="text-left"><?php echo isset($row['facode']) && $row['facode']!= NULL && $row['facode']!= ''?CrossProvince_FacilityName($row['facode']): ''; ?></td>                              
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
	<td class="text-center"><?php echo isset($row['case_type']) && $row['case_type']!= NULL && $row['case_type']!= ''?get_CaseType_Name($row['case_type']): ''; ?></td>
	<td class="text-center"><?php if(($row['pvh_date'])!=''){ echo date("d-M-Y",strtotime($row['pvh_date']));} ?></td>							  
	<!-- <td class="text-center"><?php //echo $row['is_temp_saved'] == '0' ? 'Submitted' : ''; ?></td> -->
	<td class="text-center">
		<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_view/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
		<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
		<?php if($row['year'] >= "2018") { ?>
			<?php if(($row['cross_notified'] == 1 && $row['approval_status'] == "Approved" && $row['cross_notified_from_distcode'] != $this -> session -> District) || ($row['cross_notified'] == 1 && $row['approval_status'] == "Pending" && $row['cross_notified_from_distcode'] == $this -> session -> District) || $row['cross_notified'] != 1){ ?>
			<a href="<?php echo base_url(); ?>Case_investigation/case_investigation_edit/<?php echo $row['id']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		<?php } } ?>
		<?php } ?>
		<?php 
			if($max_id1[0]['max_id'] == $row['id']) {
				//$diseaseArray = array('AWD/Chol<5', 'HepB<5', 'CL', 'Anth', 'VL', 'SARI', 'DF', 'DHF', 'CCHF', 'ChTB', 'Diph', 'Men', 'Pert', 'Mal', 'Pneu', 'DogBite', 'B Diar', 'AIDS', 'Typh', 'Scab', 'AWD/Chol>5', 'AVHep', 'Other', 'Msl', 'Polio', 'Covid');

				// echo sizeof($diseaseArray); exit();
				//unset($diseaseArray[$i]);
				if (in_array($row['case_type'], $diseaseArray)) {
					echo '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
					// for($i=0; $i<sizeof($diseaseArray); $i++){
					// 	if($diseaseArray[$i]==$row['case_type']){
					// 		unset($diseaseArray[$i]);
					// 	}
					// }
				}
				// for($i=0; $i<sizeof($diseaseArray); $i++){
				// 	if($diseaseArray[$i]==$row['case_type']){
				// 		//echo $diseaseArray[$i]; echo " / ";
				// 		unset($diseaseArray[$i]);
				// 		echo '<a onclick="delete_report(this)" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-default"><i class="fa fa-times"></i></a>';
				// 		//unset($diseaseArray[$i]);
				// 	}
				// }
			} 
		?>
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

	<?php if($this -> uri -> segment(4) != '') { ?>
		function crossNotifiedfweek(){
			var year = '<?php echo $cnyear; ?>';
			var week = '<?php echo $cnweek; ?>';
			$("#year option[value="+year+"]").prop("selected",true);
			$("#week option[value="+week+"]").prop("selected",true);		
			$("#distcode option[value=pending_dist]").prop("selected",true);
			
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				url: "<?php echo base_url(); ?>Ajax_red_rec/cross_notified_diphtheria_investigation_filter",
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
	<?php } else { ?>
		function crossNotifiedfweek(){
			var year = '<?php echo $cnyear; ?>';
			var week = '<?php echo $cnweek; ?>';
			$("#year option[value="+year+"]").prop("selected",true);
			$("#week option[value="+week+"]").prop("selected",true);		
			$("#distcode option[value=pending_dist]").prop("selected",true);
			
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				url: "<?php echo base_url(); ?>Ajax_red_rec/cross_notified_case_investigation_filter",
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
	<?php } ?>

	// $(document).ready(function() {
	// 	var case_type = $(this).closest('tr').find('.case_type').val();
	// 	alert(case_type);
	// });

	function delete_report(rpt){
        var id = $(rpt).closest('tr').find('.id').val();
        var year = $(rpt).closest('tr').find('.year').val();
        var case_type = $(rpt).closest('tr').find('.case_type').val();
        //var year = $(rpt).closest('tr').find('.year').text();
        alert(id);
        alert(year);
        alert(case_type);
        
        var response=confirm("Are you sure you want to delete this case?");
        if(response==true && id!="" && year!="")
        {
            //window.location.href="<?php echo base_url(); ?>Case_investigation/case_investigation_delete/"+id+"/"+year+"/"+case_type+"";
        }
        else
        {
            //do nothing
        }    
    };

	// $(".row_id").find("td").each(function() {
	// 	var test = $(this).text();
	// 	alert(test);
	// }
</script>