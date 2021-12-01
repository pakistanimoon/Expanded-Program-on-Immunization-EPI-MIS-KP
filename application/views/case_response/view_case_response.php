<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">View Outbreak Response</div>
			<div class="panel-body">				
					<table class="table table-bordered table-striped table-hover  mytable3">
						<tbody>
							<tr>
								<td><label>Tehsil</label></td>
								<td>									
									<span class="form-control"><?php echo get_Tehsil_Name($case_view[0]['tcode']);?></span>					
								</td>
								<td><label>Union Council</label></td>
								<td>
									<span class="form-control"><?php echo get_UC_Name($case_view[0]['uncode']);?></span>					
								</td>
								<td><label>Village</label></td>
								<td>
									<span class="form-control"><?php echo get_Village_Name($case_view[0]['vcode']);?></span>
								</td>
									<td><label>Disease</label></td>
								<td>
									<span class="form-control"><?php echo $case_view[0]['disease']?></span>					
								</td>
								
							</tr>
							<tr>
								<td><label>Date of Activity</label></td>
								<td>
									<span class="form-control"><?php echo $case_view[0]['date_of_activity']?></span>
								</td>
								<td><label>Age Group From</label></td>
								<td>
									<span class="form-control"><?php echo $case_view[0]['age_group_from']?></span>
								</td>
								<td><label>Age Group To</label></td>
								<td>
									<span class="form-control"><?php echo $case_view[0]['age_group_to']?></span>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered plan_table">						
						<thead>
							<tr>
								<th rowspan="2">All Vaccines List</th>
								<th colspan="2">0-11 M</th>
								<th colspan="2">12-23 M</th>
								<th colspan="2">&gt; Years</th>
								<th colspan="2">Total</th>
								<th colspan="1">T</th>								
							</tr>
							<tr>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M-F</th>
							</tr>							
						</thead>
						<tbody id="trRow">
							<?php foreach ($case_view as $view){?>
							<tr>
								<td><span class="form-control"><?php echo $view['vaccines']?></span></td>
								<td><span class="form-control"><?php echo $view['0_11_m_m']?></span></td>
								<td><span class="form-control"><?php echo $view['0_11_m_f']?></span></td>
								<td><span class="form-control"><?php echo $view['12_23_m_m']?></span></td>
								<td><span class="form-control"><?php echo $view['12_23_m_f']?></span></td>
								<td><span class="form-control"><?php echo $view['years_m']?></span></td>
								<td><span class="form-control"><?php echo $view['years_f']?></span></td>
								<td><span class="form-control"><?php echo $view['total_m']?></span></td>
								<td><span class="form-control"><?php echo $view['total_f']?></span></td>
								<td><span class="form-control"><?php echo $view['total_m_f']?></span></td>								 
							</tr>
							<?php } ?>
							</tbody>
							<tbody>
							<tr>
								<td>Total</td>
								<td><span class="form-control"><?php echo $case_view[0]['total_one_to_m']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_one_to_f']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_twelve_to_m']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_twelve_to_f']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_year_m']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_year_f']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_mm']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['total_ff']?></span></td>
								<td><span class="form-control"><?php echo $case_view[0]['t_m_f']?></span></td>
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="12">No Of Case</td>								
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="4">Reported through case based surveillance</td>
								<td colspan="4">Active search Cases</td>
								<td colspan="4">Epi linked Cases</td>
							</tr>
							<tr>
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['reported_case_base_surveillance']?></span></td> 
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['active_search_case']?></span></td> 
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['epi_linked_case']?></span></td> 
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="4">No of blood specimen collected</td>
								<td colspan="4">No of Throat / Oral sample collected</td>
								<td colspan="4">Follow Up Visit</td>
							</tr>
							<tr>
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['blood_speciment_collected']?></span></td> 
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['oral_swabs_collected']?></span></td>
								<td colspan="4"><span class="form-control"><?php echo $case_view[0]['follow_up_visit']?></span></td>
							</tr>
						</tbody>
					</table>
					 <div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">														
							<a href="<?php echo base_url(); ?>Case-List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>							
						</div>
					</div>			
			</div>
		</div>
	</div>
</div>
