<div class="container">
	<div class="row">
		<div class="panel panel-primary">
			<ol class="breadcrumb">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
					<li class="active"></li>
				</ul>
			</ol> 
			<div class="panel-heading">Facility Status</div>
			<div class="panel-body">
				<!--it is use for show message-->
				<?php if($this->session->flashdata('message')):?>
				<div class="alert alert-success">      
					<?php echo $this->session->flashdata('message')?>
				</div>
				<?php endif; ?>
				<!--it is use for show message-->
				<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Status/Save/<?php echo $facode; ?>" method="POST" class="form-horizontal form-bordered">     
					<input type="hidden" value="<?php echo (isset($facode)?$facode : '') ?>" name="facode">
					<table class="table table-bordered table-striped table-hover mytable2 mytable3">
						<thead>
							<tr>
								<th style="border-right:0px;width: 40%;">
									<ul class="nav nav-tabs tabs-left">
										<li class="active">
											<a class="tabpanea" href="#tab-1" data-toggle="tab" aria-expanded="true">Vaccine Status</a>
										</li>
										<li>
											<a class="tabpanea" href="#tab-2" data-toggle="tab" aria-expanded="false">Disease Surveillance Status</a>
										</li>                                               
									</ul>
								</th>
								<th style="text-align: left;padding-top: 10px;padding-bottom: 10px;border-left: 0;border-right: 0px;">Change Facility Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="9">
									<div class="tab-content">                  
										<div class="tab-pane active" id="tab-1">
											<table style="width: 100%;">
												<tbody>
													<tr>
														<td><label style="padding-top: 7px;">Facility Status</label></td>
														<td style="padding-top: 3px;"> <?php echo (isset($fac_name) ? $fac_name : ""); ?> </td>
														<td style="text-align: center;"><label style="padding-top: 7px;">Facility Status</label></td>
														<td>
															<select id="status_vacc" name="status_vacc" class="form-control text-center" required="required">
																<option value="F">Functional</option>
																<option value="N">Not Functional</option>
																<option value="C">Closed</option>	 					
															</select>
														</td>
														<td style="text-align: center;"><label style="padding-top: 7px;">Since Month</label></td>
														<td>
															<input name="m_y_from" id="m_y_from" required placeholder="yyyy-mm" class="month_year form-control" type="text">
														</td>
													</tr>
													<tr>
														<td><label style="padding-top: 7px;">Reason</label></td>
														<td>
															<input name="reason_vacc" id="reason_vacc" class="form-control" type="text">
														</td>
													</tr>
												</tbody>
											</table>
											<div class="row" style="margin-top: 6px;">
												<div class="col-lg-12 text-center">
													<button disabled="disabled" type="submit" name="vacc_save" value="1" id="vaccsave" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save</button>
													<a href="<?php echo base_url(); ?>System_setup/flcf_list" style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"> Back To List  </a>
												</div>
											</div>
											<br>
											<br>
											<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
												<thead>
													<tr>
														<th colspan="7" class="text-center Heading">Facility Status Change History</th>
													</tr>
													<tr>
														<th class="text-center Heading">Status</th>
														<th class="text-center Heading">Start Month</th>
														<th class="text-center Heading">End Month</th>
														<th class="text-center Heading">Reason</th>
														<th class="text-center Heading">Action</th>
													</tr>
												</thead>
												<tbody id="tbody">	
													<?php 
													if(isset($status_data)){
														$count = count($status_data);
														$first_row = $count;
														$cnt = $count;
														foreach($status_data as $data){
															if($first_row === $cnt)
															{
																$start_month = $data['m_y_from'];
																if( ! empty($start_month))
																{
																	$start_month = date('Y-m', strtotime($data['m_y_from'].' first day of next month'));
																	$first_row = 0;
																	$cnt = 1;
																}
															}
															if($data['m_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data['status']; ?></td>
																	<td class="text-center"><?php echo $data['m_y_from']; ?></td>
																	<td class="text-center"><?php echo $data['m_y_to'];?></td>
																	<td class="text-center"><?php if(isset($data['reason_vacc'])) { echo $data['reason_vacc']; }?></td>
																	<?php
																	if( ! ($count > 1)){ ?>
																		<td class="text-center"></td>
																	<?php 
																	}else{
																		$count = 0; ?>
																		<td class="text-center">
																			<a href="<?php echo base_url(); ?>Status/Delete/<?php echo $data['id'];?>/<?php echo $data['facode'];?>/vacc" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
																		</td> 
																	<?php
																	} ?>
																</tr>
															<?php 
															}else{
																$count--;
															}
														}
													} ?> 
												</tbody>
											</table>
										</div>
										<div class="tab-pane" id="tab-2">
											<table style="width: 100%;">
												<tbody>
													<tr>
														<td><label style="padding-top: 7px;">Facility Status</label></td>
														<td style="padding-top: 3px;"> <?php echo (isset($fac_name) ? $fac_name : ""); ?> </td>
														<td style="text-align: center;"><label style="padding-top: 7px;">Facility Status</label></td>
														<td>
															<select id="status_ds" name="status_ds" class="form-control text-center" required="required">
																<option value="F">Functional</option>
																<option value="N">Not Functional</option>
																<option value="C">Closed</option>	 					
															</select>
														</td>
														<td style="text-align: center;"><label style="padding-top: 7px;">Since EPI Year</label></td>
														<td>
															<select id="epi_year" name="epi_year" class="form-control text-center">
																<?php echo (isset($epi_w_y_filter['html_year'])?$epi_w_y_filter['html_year']:'');?>
															</select>
														</td>
														<td style="text-align: center;"><label style="padding-top: 7px;">Since EPI Week</label></td>
														<td>
															<select id="epi_week" name="epi_week" class="form-control text-center">
																<?php echo (isset($epi_w_y_filter['html_week_2016'])?$epi_w_y_filter['html_week_2016']:'');?>
															</select>
														</td>
													</tr>
													<tr>
														<td><label style="padding-top: 7px;">Reason</label></td>
														<td>
															<input name="reason_ds" id="reason_ds" class="form-control" type="text" >
														</td>
													</tr>
												</tbody>
											</table>
											<div class="row" style="margin-top: 6px;">
												<div class="col-lg-12 text-center">
													<button disabled="disabled" type="submit" id="dssave" name="ds_save" value="1" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o "></i> Save</button>
													<a href="<?php echo base_url(); ?>System_setup/flcf_list" style="background:#008d4c none repeat scroll 0% 0%;" type="submit" class="btn btn-primary btn-md" role="button"> Back To List  </a>
												</div>
											</div>
											<br>
											<br>
											<table class="table table-bordered table-hover table-striped footable table-vcenter tbl-listing" data-filter="#filter" data-filter-text-only="true">
												<thead>
													<tr>
														<th colspan="7" class="text-center Heading">Facility Status Change History</th>
													</tr>
													<tr>
														<th class="text-center Heading">Status</th>
														<th class="text-center Heading">Start Week</th>
														<th class="text-center Heading">End Week</th>
														<th class="text-center Heading">Reason</th>
														<th class="text-center Heading">Action</th>
													</tr>
												</thead>
												<tbody id="tbody">	
													<?php 
													if(isset($status_data)){
														$count = count($status_data);
														foreach($status_data as $data){
															if($data['w_y_from'] != ''){ ?>
																<tr>
																	<td class="text-center"><?php echo $data['status']; ?></td>
																	<td class="text-center"><?php echo $data['w_y_from'];?></td>
																	<td class="text-center"><?php echo $data['w_y_to'];?></td>
																	<td class="text-center"><?php echo $data['reason_ds'];?></td>
																	<?php
																	if( ! ($count > 1)){ ?>
																		<td class="text-center"></td>
																	<?php 
																	}else{
																		$count = 0; ?>
																		<td class="text-center">
																			<a href="<?php echo base_url(); ?>Status/Delete/<?php echo $data['id'];?>/<?php echo $data['facode'];?>/ds" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
																		</td> 
																	<?php
																	} ?>
																</tr>
															<?php 
															}else{
																$count--;
															} ?>
														<?php 
														} 
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<br>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->	
<script type="text/javascript">
	$(document).ready(function(){
		var data = <?php echo $epi_w_y_filter; ?>;
		$('#epi_year').append(data.html_year);
		if(data.year !== undefined){
			$('#epi_week').append(data['html_week_'+data.year[0]]);
		}
		$(document).on('change', '#epi_year', function(){
			var year = $('#epi_year').val();
			if(data.year !== undefined){
				var year_index = (data.year).indexOf(year);
				var year_key = data.year[year_index];
				$('#epi_week').html('');
				$('#epi_week').append(data['html_week_'+year_key]);
			}
		});
		$(document).on('click','.tabpanea',function(){
			if($('#tab-2').hasClass('active') == true){
				$('#m_y_from').removeAttr('required','required');
			}else{
				$('#m_y_from').attr('required','required');
			}
		});
		$(document).on('change','#epi_week',function(){
			if(parseInt($('#epi_week').val()) > 0){
				$('#dssave').removeAttr('disabled','disabled');
			}else{
				$('#dssave').attr('disabled','disabled');
			}
		});
		$(document).on('change','#m_y_from',function(){
			if($('#m_y_from').val() != ''){
				$('#vaccsave').removeAttr('disabled','disabled');
			}else{
				$('#vaccsave').attr('disabled','disabled');
			}
		});
	});
	$(document).on('blur', '#m_y_from', function(){
		var fmonth = $('#m_y_from').val();
		if(fmonth.toString().length == 7)
		{
			fmonth = fmonth.substring(0,4) + fmonth.substring(5,7);
			var data = <?php print_r (isset($last_fmonth)? $last_fmonth : 0) ?>;
			data = data[0].fmonth;
			last_fmonth = data.substring(0,4) + data.substring(5,7);
			if(fmonth <= last_fmonth)
			{
				$('#m_y_from').val("");
				alert("This Facility has a Report submitted for " + data + "\n Please select Fmonth greater than " + data);
			}
		}
	});
	$(document).on('change', '#epi_week', function(){
		var week = $('#epi_week').val();
		week = ('0' + week).slice(-2);
		var fweek = $('#epi_year').val() + '-' + week;
		console.log(fweek);
		if(fweek.toString().length == 6 || fweek.toString().length == 7)
		{
			fweek = fweek.substring(0,4) + fweek.substring(5,7);
			var data = <?php print_r (isset($last_fweek)? $last_fweek : 0) ?>;
			data = data[0].fweek;
			last_fweek = data.substring(0,4) + data.substring(5,7);
			if(fweek <= last_fweek)
			{
				$('#epi_week').val("");
				//$('#epi_year').val("");
				alert("This Facility has a Report submitted for " + data + "\n Please select Fweek greater than " + data);
			}
		}
	});
	$(function() {
		var start = '<?php echo (isset($start_month)?$start_month:'2016-01');?>';
		var end   = '+0d';
		$("#m_y_from").datepicker( {
			format: "yyyy-mm", 
			minViewMode: "months",
			startDate: start,
			endDate: end,
			orientation: 'top auto',
			clearBtn: true,
		});
	});
	$("#m_y_from").keydown(function (event) {
		event.preventDefault();
	});
	$(document).on('change','#year',function(){
		var year = $(this).val();
		$.ajax({
			type: 'POST',
			url:'http://pacetec.net/kphealth/epimis/Ajax_calls/getEpiWeeks',
			data:'year='+year,
			success: function(response)
			{
				$('#week').html(response.trim());
				var week = $('#week').val();
				var year = $('#year').val();
			}
		});
	});
</script>