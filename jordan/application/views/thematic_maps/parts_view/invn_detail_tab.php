<div class="row">
	<div class="col-md-12">
		<div class="panel with-nav-tabs tabs-left">
			<div class="panel-heading zp">
				<ul class="nav nav-tabs nav-justified" style="margin-left: 16px;padding-right: 37px;">
					<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass=='summary')?'active':'';?>"><a data-toggle="tab" id="summarytab" href="#summary">Summary</a></li>
					<?php foreach($tabs as $onetab){
						$lowername = strtolower($onetab);?>
						<li role="presentation" class="tabs-lis <?php echo (isset($activeClass) && $activeClass==$lowername)?'active':'';?>"><a data-toggle="tab" href="#<?php echo $lowername; ?>"><?php echo $onetab; ?></a></li><?php
					}?>
				</ul>
			</div>
			<div class="panel-body zp">
				<div class="tab-content" style="padding-top: 10px;">
					<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass=='summary')?'active in':'';?>" id="summary">
						<div class="row">
							<div class="col-md-12">
								<?php $this -> load -> view('thematic_maps/parts_view/invn_summary_tab',$summary); ?>
							</div>
						</div>
					</div>
					<?php foreach($tabs as $onetab){
						$lowername = strtolower($onetab);?>
						<div class="tab-pane fade <?php echo (isset($activeClass) && $activeClass==$lowername)?'active in':'';?>" id="<?php echo $lowername; ?>">
							<div class="row">
								<div class="col-md-12">
									<?php echo (isset(${$lowername}))?${$lowername}:''; ?>
								</div>
							</div>
						</div><?php
					}?>
				</div>
			</div>
		</div>
	</div>
</div>