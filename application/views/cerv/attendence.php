					<div class="container bodycontainer">
						<div class="row cst-heading-row">
							<div class="col-lg-12 heading-cst-col monthly-wise-attendence">
								<h3 class="heading-cst">Monthly Technician Attendence</h3>
							</div>
						</div>
						<div class="row cst-search-row">
							<div class="col-md-4 col-md-offset-4">
								<input type="text" id="attendence-fmonth" class="form-control dp-my" data-date-format="yyyy-mm" placeholder="Select Year-Month">
							</div>
							<div class="col-md-4">
								<button type="button" id="get-attendence" onclick="getAttendence();" class="btn btn-succes cst-tech-btn">Submit</button>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row row-attendence-border">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-md-2"><div class="cst-green-box" data-toggle="tooltip" title="">&nbsp;</div></div>
									<div class="col-md-10 p-0"><span class="text-gray-dark">Present</span></div>
								</div>
							</div>
							<!--<div class="col-lg-3">
								<div class="row">
									<div class="col-md-2"><div class="cst-yellow-box" data-toggle="tooltip" title="">&nbsp;</div></div>
									<div class="col-md-10 p-0"><span class="text-gray-dark">Checked-in && No Vaccination</span></div>
								</div>
							</div>-->
							<div class="col-lg-4">
								<div class="row">
									<div class="col-md-2"><div class="cst-red-box" data-toggle="tooltip" title="">&nbsp;</div></div>
									<div class="col-md-10 p-0"><span class="text-gray-dark">Absent</span></div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="row">
									<div class="col-md-2"><div class="cst-gray-box" data-toggle="tooltip" title="">&nbsp;</div></div>
									<div class="col-md-10 p-0"><span class="text-gray-dark">Not a Working Day</span></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-striped table-hovered table-tech-reporting">
									<thead>
										<tr>
											<th>Technician Name</th>
											<th>UC</th>
											<?php
											$i = 1;
											$newFirstDate = $firstDate;
											$newLastDate = $lastDate;
											while($firstDate <= $lastDate){
											?>
											<th class="rotate-nowrap">Day<br><?php echo $i; ?></th>
											<?php
												$firstDate = strtotime("+1 day",$firstDate);
												$i++;
											}
											?>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($attendence as $key => $val){
										?>
										<tr>
											<td><?php echo $val['technician']; ?></td>
											<td><?php echo $val['uc']; ?></td>
											<?php
											$i = 1;
											$loopFirstDate = $newFirstDate;
											$loopLastDate = $newLastDate;
											while($loopFirstDate <= $loopLastDate){
												if(date('l',$loopFirstDate) == 'Sunday'){
												?>
													<td><div class="cst-gray-box" data-toggle="tooltip" title="Not a Working Day">&nbsp;</div></td>
												<?php
												}else if($val["day{$i}"] < 1){
												?>
													<td><div class="cst-red-box" data-toggle="tooltip" title="Absent">&nbsp;</div></td>
												<?php
												}
												else if($val["day{$i}"] > 0){
												?>
													<td><div class="cst-green-box" data-toggle="tooltip" title="Checked-in">&nbsp;</div></td>
												<?php
												}
												$loopFirstDate = strtotime("+1 day",$loopFirstDate);
												$i++;
											}
											?>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<script>
						var base_url = '<?php echo base_url(); ?>';
						function getAttendence(){
							var $attendenceMonth = $('#attendence-fmonth').val();
							if($attendenceMonth != ''){
								window.location.href = base_url+'Cerv/Dashboard/attendence?fmonth='+$attendenceMonth;
							}else{
								alert('Please select a date to proceed!');
							}
						}
						$(document).ready(function(){
							$(".dp-my").datepicker({
								autoclose: true,
								format: "yyyy-mm",
								viewMode: "months", 
								minViewMode: "months",
								orientation: "top"
							});
						});
					</script>