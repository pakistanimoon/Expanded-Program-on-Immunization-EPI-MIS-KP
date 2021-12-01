<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
		<br/>
			<div class="panel-heading">Sanctioned Posts</div>
			<div class="panel-body">
				<form name="dataform" id="dataform" action="<?php echo base_url(); ?>Sanctioned_posts/save_sanctionedPosts" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
					<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
						<thead>
							<tr>
								<th class="text-center Heading" colspan="2">EPI Coordinator</th>
								<th class="text-center Heading" colspan="2">District Serveillance Officer</th>
								<th class="text-center Heading" colspan="2">District Superintendent Vaccination</th>
							</tr>
							<tr>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									<input name="epi_coordinator" value="<?php echo (isset($districtsdata) AND $districtsdata->epi_coordinator > 0)?$districtsdata->epi_coordinator:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="epi_coordinator_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->epi_coordinator_fill > 0)?$districtsdata->epi_coordinator_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="dso" value="<?php echo (isset($districtsdata) AND $districtsdata->dso > 0)?$districtsdata->dso:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="dso_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->dso_fill > 0)?$districtsdata->dso_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="dsv" value="<?php echo (isset($districtsdata) AND $districtsdata->dsv > 0)?$districtsdata->dsv:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="dsv_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->dsv_fill > 0)?$districtsdata->dsv_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
						<thead>
							<tr>
								<th class="text-center Heading" colspan="2">Tehsil Superintendent Vaccination</th>
								<th class="text-center Heading" colspan="2">Assistant Superintendent Vaccination</th>
								<th class="text-center Heading" colspan="2">Computer Operator</th>
							</tr>
							<tr>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									<input name="tsv" value="<?php echo (isset($districtsdata) AND $districtsdata->tsv > 0)?$districtsdata->tsv:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="tsv_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->tsv_fill > 0)?$districtsdata->tsv_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="asv" value="<?php echo (isset($districtsdata) AND $districtsdata->asv > 0)?$districtsdata->asv:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="asv_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->asv_fill > 0)?$districtsdata->asv_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="computer_operator" value="<?php echo (isset($districtsdata) AND $districtsdata->computer_operator > 0)?$districtsdata->computer_operator:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="computer_operator_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->computer_operator_fill > 0)?$districtsdata->computer_operator_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
						<thead>
							<tr>
								<th class="text-center Heading" colspan="2">HF Incharge</th>
								<th class="text-center Heading" colspan="2">EPI Technician</th>
								<th class="text-center Heading" colspan="2">Cold Chain Technician</th>
							</tr>
							<tr>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									<input name="hf_incharge" value="<?php echo (isset($districtsdata) AND $districtsdata->hf_incharge > 0)?$districtsdata->hf_incharge:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="hf_incharge_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->hf_incharge_fill > 0)?$districtsdata->hf_incharge_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="epi_tech" value="<?php echo (isset($districtsdata) AND $districtsdata->epi_tech > 0)?$districtsdata->epi_tech:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="epi_tech_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->epi_tech_fill > 0)?$districtsdata->epi_tech_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_technician" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_technician > 0)?$districtsdata->cc_technician:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_technician_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_technician_fill > 0)?$districtsdata->cc_technician_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
						<thead>
							<tr>
								<th class="text-center Heading" colspan="2">Cold Chain Operator</th>
								<th class="text-center Heading" colspan="2">Cold Chain Mechanic</th>
								<th class="text-center Heading" colspan="2">Generator Operator</th>
							</tr>
							<tr>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									<input name="cc_operator" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_operator > 0)?$districtsdata->cc_operator:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_operator_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_operator_fill > 0)?$districtsdata->cc_operator_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_mechanic" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_mechanic > 0)?$districtsdata->cc_mechanic:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_mechanic_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_mechanic_fill > 0)?$districtsdata->cc_mechanic_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_generator" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_generator > 0)?$districtsdata->cc_generator:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="cc_generator_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->cc_generator_fill > 0)?$districtsdata->epi_coordinator:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered table-hover table-striped table-vcenter tbl-listing">
						<thead>
							<tr>
								<th class="text-center Heading" colspan="2">Store Keeper</th>
								<th class="text-center Heading" colspan="2">Driver</th>
							</tr>
							<tr>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
								<th class="text-center Heading">Sanctioned</th>
								<th class="text-center Heading">Filled</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">
									<input name="store_keeper" value="<?php echo (isset($districtsdata) AND $districtsdata->store_keeper > 0)?$districtsdata->store_keeper:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="store_keeper_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->store_keeper_fill > 0)?$districtsdata->store_keeper_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="driver" value="<?php echo (isset($districtsdata) AND $districtsdata->driver > 0)?$districtsdata->driver:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
								<td class="text-center">
									<input name="driver_fill" value="<?php echo (isset($districtsdata) AND $districtsdata->driver_fill > 0)?$districtsdata->driver_fill:0; ?>" placeholder="0" class="form-control numberclass text-center" type="text">
								</td>
							</tr>
						</tbody>
					</table>
					<br />
					<hr>
					<div class="row">
						<div class="col-md-7" style="margin-left: 65%;">							
							<button type="submit" class="btn btn-md btn-success bc1"><i class="fa fa-floppy-o"></i>Save Form</button>
							<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i>Reset Form</button>
							<a href="<?php echo base_url(); ?>" class="btn btn-md btn-success"><i class="fa fa-times"></i>Cancel Form</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!--end of panel body-->
	</div><!--end of row-->
</div><!--End of page content or body-->

