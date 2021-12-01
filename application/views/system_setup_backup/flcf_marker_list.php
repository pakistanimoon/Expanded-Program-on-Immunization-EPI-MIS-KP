<!--start of page content or body-->
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
		<div class="panel panel-primary">
			<ol class="breadcrumb">
				<?php  echo $this->breadcrumbs->show();?>
			</ol>
			<div class="panel-heading"> Mark Health Facility Centers for EPI-MIS</div>
			<div class="panel-body">
				<p class="blinking" style="color:red;">Note: <span>Facilities with at-least one record submitted for their respective report could not be unmarked from system</span></p>
				<form action="<?php echo base_url(); ?>System_setup/mark_flcf" method="post">
					<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
						<thead>
							<tr>
								<th rowspan="2" class="Heading text-center">S#</th>
								<th rowspan="2" class="Heading text-center">Code</th>
								<th rowspan="2" class="Heading text-center">Health Facility Name</th>
								<th rowspan="2" class="Heading text-center">District</th>
								<th rowspan="2" class="Heading text-center">Tehsil</th>
								<th rowspan="2" class="Heading text-center">Type</th>
								<th rowspan="2" class="Heading text-center">Total Population</th>
								<th rowspan="2" class="Heading text-center">EPI Technician Attached</th>
								<th colspan="2" class="Heading text-center"><a><button type="submit" class="submit btn-success btn-sm"><i class="fa fa-check-square-o"></i> Mark Health Facility</button></a></th>
							</tr>
							<tr>
								<th class="Heading text-center">Vaccination</th>
								<th class="Heading text-center">Surveillance</th>
							</tr>
						</thead>
						<tbody id="tbody"> 
							<?php
							$i=0;
							foreach($results as $row){  
								$i++;
							?>
							<tr>
								<td class="text-center"><?php echo $i; ?></td>
								<td class="text-center"><?php echo $row['facode']?></td>
								<td class="text-center"><?php echo $row['fac_name']?></td>
								<td class="text-center"><?php echo $row['district']?></td>
								<td class="text-center"><?php echo $row['tehsil']?></td>
								<td class="text-center"><?php echo $row['fatype']?></td>
								<td class="text-center"><?php echo $row['catchment_area_pop']?></td>
								<td class="text-center"></td>
								<td class="text-center">
									<?php if(getVaccinationReportsCountofFacility($row['facode'],TRUE) > 0){ ?>
										<p class="disabledp" style="color:red;" data-toggle="tooltip" title="Report Submitted">&#x2611;</p>
									<?php }else{ ?>
										<input type="checkbox" name="vacc_flcf_list[]" value="<?php echo $row['facode']; ?>" <?php echo ($row['hf_type'] == 'e' && $row['is_vacc_fac'] == '1') ? 'checked="checked"' : '' ?> />
									<?php } ?>
								</td>
								<td class="text-center">
									<?php if(getSurveillanceReportsCountofFacility($row['facode'],TRUE) > 0){ ?>
										<p class="disabledp" style="color:red;" data-toggle="tooltip" title="Report Submitted">&#x2611;</p>
									<?php }else{ ?>
										<input type="checkbox" name="ds_flcf_list[]" value="<?php echo $row['facode']; ?>" <?php echo ($row['hf_type'] == 'e' && $row['is_ds_fac'] == '1') ? 'checked="checked"' : '' ?> />
									<?php } ?>
								</td>
							</tr>
							<?php
							}
							?>                       
						</tbody>
					</table>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script type="text/javascript">
	var tcode=0;
	var fatype=0;
	function getFacType(){
		fatype=document.getElementById("fatype").value;
	}
    $(document).ready(function() {
		$('.filter-status').on('change' , function (){
			tcode=document.getElementById("tcode").value;
			$('#tbody').html('');
			$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
			page = 0; //get page number from link
			$.ajax({
				type: "GET",
				url: "<?php echo base_url(); ?>Ajax_calls/mark_facility_filter/"+tcode+"/"+fatype,
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
    });
	$('.disabledp').css('cursor','not-allowed');
</script>