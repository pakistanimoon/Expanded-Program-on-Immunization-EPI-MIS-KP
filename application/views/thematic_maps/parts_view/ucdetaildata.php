<div class="row">
	<div class="col-md-12">
		<div class="panel with-nav-tabs tabs-left">
			<div class="panel-heading zp hide-tabs">
				<ul class="nav nav-tabs nav-justified" style="margin-left: 16px;padding-right: 37px;">
					<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='summary')?'active':'';?>"><a data-toggle="tab" href="#summary">Summary</a></li>
					<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='coverage')?'active':'';?>"><a data-toggle="tab" href="#coverage">Coverage</a></li>
					<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='consumption')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="1" href="#consumption">Consumption</a></li>
					<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='dropout')?'active':'';?>"><a data-toggle="tab" class="q-tab" data-id="2" href="#dropout">Dropout</a></li>
					<li role="presentation" class="tabs-lis"><a data-toggle="tab" class="q-tab" data-id="3" href="#surveillance">Surveillance</a></li>
					<li role="presentation" class="tabs-lis"><a data-toggle="tab" class="q-tab" data-id="5" href="#covid">COVID-19</a></li>
					<li role="presentation" style="display:none" class="tabs-lis"><a data-toggle="tab" class="q-tab" data-id="4" href="#attendence">Attendence</a></li><!-- Currently hide. when complete show it-->
				</ul>
			</div>
			<div class="panel-body zp">
				<div class="tab-content" style="padding-top: 10px;">
					<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='summary')?'active in':'';?>" id="summary">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($summary))?$summary:''; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='coverage')?'active in':'';?>" id="coverage">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($coverage))?$coverage:''; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='consumption')?'active in':'';?>" id="consumption">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($consumption))?$consumption:''; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='dropout')?'active in':'';?>" id="dropout">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($dropout))?$dropout:''; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="surveillance">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($surveillance))?$surveillance:''; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="covid">
						<div class="row">
							<div class="col-md-12">
								<?php //echo (isset($covid))?$covid:''; ?>
								<iframe style="width:100%;height:700px;border:none;" src="<?php echo base_url('thematic_maps/Covid19'); ?>"></iframe>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="attendence">
						<div class="row">
							<div class="col-md-12">
								<?php echo (isset($attendence))?$attendence:''; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>