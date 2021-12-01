				<div class="col-lg-6">
					<section id="rev_aside">
						<div class="container-fluid p-0">
							<?php
							if(isset($ucwise) && $ucwise=='wise'){
									$controller='ReviewDashboardUcWise';
							}else{
									$controller='ReviewDashboard';
							}
							$i=1;
							foreach($leftCardsMainArray as $key => $indicator){
								//print_r($indicator['id']);
								////////by usama for % sing and also for tab setting
								if($indicator['id']=='diseaseoutbreak') {
										$sing='';					
								}else{
										$sing='&#37;';
								}
								if($indicator['id']=='compliances') {
										$col_size='6';					
								}
								elseif($indicator['id']=='sessoinsplan'){
										$col_size='4';
								}else{
								//if($indicator['id']!='compliances' || $indicator['id']=='sessoinsplan'){
									$col_size='3';
								}
								////////END/
								$ind_str = '&indicatorid='.$indicator['id'];
								unset($_GET['subindicatorid']);
								unset($_GET['indicatorid']);
								$queryString = http_build_query($_GET);
							?>
							<div class="row card-1 m-0">
								<a href="<?php echo base_url('dashboard/'.$controller.'?').$queryString.$ind_str; ?>" class="hover-tag">
									<div class="col-lg-12 p-0">
										<table class="table m-0">
											<tbody>
												<tr>
													<td class="main-box bg-<?php echo $i; ?> p-2">
														<?php 
														if($indicator['isactive'] === true){
														?>
														<i class="far fa-eye" style="position: absolute;left: 7px;font-size: 24px;top: 31px;text-shadow: 0px 0px 3px white;"></i>
														<?php
														}
														?>
														<h6><?php echo $indicator['topheading']; ?></h6>
														<span class="fig"><?php echo $indicator['value']; ?><?php echo $sing ;?></span>
														<span class="title"><?php echo $indicator['bottomheading']; ?></span>
														<span class="cst-circle"></span>
														<img src="<?php echo base_url(); ?>review_dashboard/img/icons/immunized.svg" alt="">
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</a>
								<?php 
								if($indicator['carousel'] === true){
								?>
								<div class="div-ul card-1-ul" style="width:100vh;">
									<div class="top-content">
										<div class="container-fluid">
											<div id="carousel-example<?php echo $i; ?>" class="carousel slide carousel-example multi-item-carousel" data-ride="carousel" data-wrap="false"  data-interval="false">
												<table class="table m-0">
													<tbody>
														<tr>
															<td class="p-0">
																<ul class="verticle-align nav nav-pills carousel-inner row w-100 mx-auto">
																	<?php
																	$j=0;
																	foreach($indicator['carouselarray'] as $carouselkey => $carousel){
																		$subind_str = '&subindicatorid='.$carousel['id'];
																		unset($_GET['subindicatorid']);
																		$queryString = http_build_query($_GET);
																	?>
																	<li class="nav-item bg-<?php echo $i; ?> carousel-item col-12 col-sm-6 col-md-4 col-lg-<?php echo $col_size; ?> <?php echo ($j == 0)?'active':''; ?>">
																		
																			<a class="nav-link <?php echo ($j == 0)?'active':''; ?>"  href="<?php echo base_url('dashboard/'.$controller.'?').$queryString.$ind_str.$subind_str; ?>"><span><?php echo $carousel['value']; ?>&#37;</span> <?php echo $carousel['name']; ?></a>
																	</li>
																	<?php
																	$j++;
																	}
																	?>
																</ul>
															</td>
														</tr>
													</tbody>
												</table>
												<a class="carousel-control-prev" href="#carousel-example<?php echo $i; ?>" role="button" data-slide="prev">
													<span class="carousel-control-prev-icon" aria-hidden="true"></span>
													<span class="sr-only">Previous</span>
												</a>
												<a class="carousel-control-next" href="#carousel-example<?php echo $i; ?>" role="button" data-slide="next">
													<span class="carousel-control-next-icon" aria-hidden="true"></span>
													<span class="sr-only">Next</span>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>
							</div>
							<?php
								$i++;
							}
							?>
						</div>
					</section>
				</div>