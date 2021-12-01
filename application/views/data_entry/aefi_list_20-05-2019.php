<!--start of page content or body-->
<div class="container bodycontainer">
	<div class="row">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
		<div class="panel panel-primary">
			<ol class="breadcrumb">
				<?php  echo $this->breadcrumbs->show();?>
			</ol> 
			<div class="panel-heading"> List of Adverse Events Following Immunization(AEFI) Reports</div>
			<div class="panel-body">
				<form method="post" id="filter-form">
					<div class="row">   
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for="facode" >Search:</label>
							<div class="col-xs-3">
								<input id="filter" onkeyup="search();" name="searchParam" class="form-control form-control" type="text"/>
							</div>
							
						
						<label class="col-xs-2 control-label lbl-setting"  for = "facode" >Year-Week:</label>
						<div class="col-xs-1" style="width: 13.79%;">
							<select id="year" name="year" onchange="search();" class="filter-status  form-control">
								<option value="0">All Years</option>
								<?php
								foreach($resultYear as $row){
								?>
								<option value="<?php echo $row['year'];?>" ><?php echo $row['year'];?></option>
								<?php } ?>
							</select>
						</div> 
						<div class="col-xs-1" style="width: 13.79%;">
							<select id="week" name="week" onchange="search();" style="margin-left: -28px;" class="filter-status  form-control">
								<option value="0">All Weeks</option>
								<?php
								foreach($resultWeek as $row){
								?>
								<option value="<?php echo $row['week'];?>" ><?php echo $row['week'];?></option>
								<?php } ?>
							</select>
						</div>
						</div>
					</div>
					<div class="row" style="margin-top:5px;">   
						<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for = "complaints" >Major Complaints:</label>
							<div class="col-xs-3">
								<select id="complaints" name="complaints" onchange="search();" class="filter-status  form-control">
									<option value="">-- Select a complaint --</option>
									<option value="mc_bcg">BCG Lymphadenitis</option>
									<option value="mc_convulsion">Convulsion</option>
									<option value="mc_severe">Severe Local Reaction</option>
									<option value="mc_unconscious">Unconsciousness</option>
									<option value="mc_abscess">Injection site abscess</option>
									<option value="mc_respiratory">Respiratory Distress</option>
									<option value="mc_fever">Fever</option>
									<option value="mc_swelling">Swelling of body or face</option>
									<option value="mc_rash">Rash</option>
								</select>
							</div> 
							<label class="col-xs-2 control-label lbl-setting"  for = "tcode" >Tehsil:</label>
							<div class="col-xs-3">
								<select id="tcode" name="tcode" onchange="search();" class="filter-status  form-control">
									<option value="0"></option><?php
									foreach($resulttehsil as $row){?>
										<option value="<?php echo $row['tcode'];?>" ><?php echo $row['tehsil'];?></option><?php
									}?>
								</select> 
							</div>							
						</div>
					</div>
					<div class="row" style="margin-top:5px;">   
						<div class="form-group">							
							<?php if($UserLevel == 2 || $UserLevel == 3 ){  ?>
								<label class="col-xs-2 col-xs-offset-1 control-label lbl-setting"  for = "uncode" >Union Council:</label>
								<div class="col-xs-3">
									<select id="uncode" name="uncode" onchange="search();" class="filter-status form-control">
										<option value="0"></option>
										<?php foreach($resultUc as $row){?>
											<option value="<?php echo $row['uncode'];?>" ><?php echo $row['un_name'];?></option>
										<?php  } ?>
									</select>
								</div> 
							<?php } ?> 
							<?php if($UserLevel == 2 || $UserLevel == 3 ){  ?>
								<label class="col-xs-2 control-label lbl-setting"  for = "facode" >Health Facility:</label>
								<div class="col-xs-3">
									<select id="facode" name="facode" onchange="search();" class="filter-status form-control">
										<option value="0"></option>
										<?php foreach($resultFac as $row){?>
											<option value="<?php echo $row['facode'];?>" ><?php echo $row['fac_name'];?></option>
										<?php  } ?>
									</select>
								</div> 
							<?php } ?>           
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
							<th class="text-center Heading">Case name</th>
							<th class="text-center Heading">Age <small>(in years)</small></th>
							<th class="text-center Heading">Health Facility</th>
							<th class="text-center Heading">Union Council</th>
							<th class="text-center Heading">Tehsil</th>
							<th class="text-center Heading">Major Complaints</th>
							<th class="text-center Heading">Vaccine</th>
							<th class="text-center Heading">Vaccinator</th>
							<th class="text-center Heading">Year-Week</th>
							<th class="text-center Heading">Date</th>
							<th class="text-center Heading">Form Status</th>
							<th class="text-center Heading">
								<a href="<?php echo base_url(); ?>AEFI-CIF/Add" data-toggle="tooltip" title="Adverse Events Following Immunisation (AEFI) Report">
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
								<td class="text-left"><?php echo $row['casename']; ?></td>
								<td class="text-center"><?php echo $row['age']; ?></td>
								<td class="text-left"><?php echo $row['facilityname']; ?></td>
								<td class="text-left"><?php echo $row['unioncouncil']; ?></td>
								<td class="text-left"><?php echo $row['tehsilname']; ?></td>
								<td class="text-center"><?php echo $row['complaints']; ?></td>
								<td class="text-left"><?php echo $row['vacc_name']; ?></td>
								<td class="text-left"><?php echo $row['vacc_vaccinator']; ?></td>
								<td class="text-left"><?php echo $row['fweek']; ?></td>
								<td class="text-center"><?php echo date("d-M-Y",strtotime($row['rep_date'])); ?></td>
								<td class="text-left"><?php echo $row['is_temp_saved'] == '0' ? 'Submitted' : ''; ?></td>
								<td class="text-center">
									<a href="<?php echo base_url(); ?>AEFI-CIF/View/<?php echo $row['id']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
									<a href="<?php echo base_url(); ?>AEFI-CIF/Edit/<?php echo $row['id']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
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




<script type="text/javascript">
 
	function search(){
		// var searchParam = term;
     
		$('#tbody').html('');
		$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
        //var page = $(this).attr("id"); //get page number from link
        $.ajax({
			type: "POST",
			data: $("#filter-form").serialize(),//"searchParam="+searchParam,
			url: "<?php echo base_url(); ?>Ajax_calls/aefiSearch", 
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

    /*
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
				url: "<?php echo base_url(); ?>Ajax_calls/aefi_filter?page="+page,
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
			url: "<?php echo base_url(); ?>Ajax_calls/aefi_filter",
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
    }); */
	
</script>