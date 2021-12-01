										<?php
										$key = array_search($indicatorkey, array_column($leftCardsMainArray, 'id'),true);
										if($key === false){
											$key = array_search($indicatorkey, array_column($rightCardsMainArray, 'id'),true);
											if($key > -1)
												$arrayToSearch = $rightCardsMainArray;
										}else
											$arrayToSearch = $leftCardsMainArray;
										
										if($subindicatorkey !== false){
											$loopArray = $arrayToSearch[$indicatorkey]['carouselarray'][$subindicatorkey];
										}else{
											$loopArray = $arrayToSearch[$indicatorkey];
										}
										if(isset($loopArray) && ! empty($loopArray)){
											foreach($loopArray['topcards'] as $cardkey => $card){
											?>
											<div class="col p-1">
												<div class="cst-card bg-<?php echo $cardkey+1; ?> text-white <?php echo (isset($card['rightinfo']))?'value-2':''; ?>">
													<div class="row p-0 m-0">
														<div class="col-lg-6 p-0">
															<h6><?php echo (isset($card['leftinfo']))?$card['leftinfo']:''; ?></h6>
															<h3>
																<?php echo (isset($card['leftvalue']))?number_format($card['leftvalue']):''; ?>
																<?php echo (isset($card['leftvaluetype']) && $card['leftvaluetype'] == 'percentage')?' %':''; ?>
															</h3>
														</div>
														<?php
														if(isset($card['rightinfo'])){
														?>
														<div class="col-lg-6 p-0 text-right">
															<h6><?php echo (isset($card['rightinfo']))?$card['rightinfo']:''; ?></h6>
															<h3>
																<?php echo (isset($card['rightvalue']))?$card['rightvalue']:''; ?>
																<?php echo (isset($card['rightvaluetype']) && $card['rightvaluetype'] == 'percentage')?' %':''; ?>
															</h3>
														</div>
														<?php
														}
														?>
													</div>
													<img src="<?php echo base_url(); ?>review_dashboard/img/icons/<?php echo ($card['cardicon'])?$card['cardicon']:''; ?>" alt="" class="icon-img">
												</div>
											</div>
											<?php
											}
										}
										?>