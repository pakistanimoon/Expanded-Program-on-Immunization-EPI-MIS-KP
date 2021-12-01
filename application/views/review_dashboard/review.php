<!doctype html>
<html lang="en">
	<head>
		<?php $this -> load -> view('review_dashboard/style'); ?>
	</head>
	<body>
		<section id="rev_header">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h4>EPI - MIS | Review Dashboard</h4>
					</div>
				</div>
			</div>
		</section>
		<?php $this -> load -> view('review_dashboard/filters'); ?>
		<div class="container-fluid p-0 z-99">
			<div class="row">
				<?php $this -> load -> view('review_dashboard/left_cards'); ?>
				<?php $this -> load -> view('review_dashboard/right_cards'); ?>
			</div>
		</div>
		<div class="container-fluid" id="rev_content-div">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 p-0">
					<div class="row p-0">
						<div class="col-lg-12 p-0">
							<div class="tab-content">
								<div class="tab-pane container active" id="content-immunized-all">
									<div class="row">
										<div class="col-lg-12 pl-1 pr-1 pt-1">
											<h5 class="heading-content">
												<?php echo $heading; ?>
											</h5>
										</div>
									</div>
									<div class="row mb--1">
										<?php $this -> load -> view('review_dashboard/center_upper_cards'); ?>
									</div>
									<div class="row">
										<div class="col-lg-8 p-1 map-charts">
											<div class="div-img" id="thematic-map" style="height: 100%;"></div>
										</div>
										<div class="col-lg-4 p-1 ranking">
											<div class="">
												<div id="ranking-bar" style="height: auto; margin-bottom: 10px;"></div>
											</div> 	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this -> load -> view('review_dashboard/script'); ?>
	</body>
</html>