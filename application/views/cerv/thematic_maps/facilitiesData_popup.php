<?php

foreach($result as $row){ ?>

	<div class="row" style="margin-bottom: 8px;">

		<div class="col-md-12" style="background: #3c8dbc;margin-left: 15px;width: 97%;">

			<h3 style="color: white;font-weight: bold;text-decoration: underline;"><?php echo $row->name." (".$row->code.")"; ?></h3>

			<div class="row" style="color: white;">

				<div class="col-md-3">

					<label class="form-label text-center">Report Submitted</label>

				</div><div class="col-md-3">

					<label class="form-label text-center"><?php if($row->report_submitted=='t'){ ?><a href="<?php echo base_url(); ?>FLCF-MVRF/View/<?php echo $row->code; ?>/<?php echo $fmonth; ?>" target="_blank" style="color:green;">Yes</a><?php }else{ echo "No"; } ?></label>

				</div>

				<div class="col-md-3">

					<label class="form-label text-center">Population</label>

				</div><div class="col-md-3">

					<label class="form-label text-center"><?php echo $row->pop; ?></label>

				</div>

			</div>

		</div>

	</div>

<?php } ?>