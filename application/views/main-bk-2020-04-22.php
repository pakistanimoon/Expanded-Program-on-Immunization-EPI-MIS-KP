	<?php $utype=$this -> session -> utype;?>
	<!--start of page content or body-->
	<!-- /.content-wrapper-->
	<!-- Main content -->

	<style>
		.vouchers a:hover {
			text-decoration: underline;
		}
	</style>
		<div class="container">
			<?php
			if($utype == 'DEO' || $utype == 'Store'){
				if(isset($vouchers)){ ?>
					<div class="vouchers" style="color:red">
						<?php $totvouchers = count($vouchers);
						if($totvouchers){?>
							Pending Vouchers for : 
							<?php foreach($vouchers as $key=>$onevoucher){
								$val = $onevoucher["transaction_number"];
								echo '<a href="'.base_url().'StockReceivefromStore/'.$val.'" style="color:red">'.$val.'</a>';
								if(($key+1)!=$totvouchers){
									echo ', ';
								}
							}
						}?>
					</div>
				<?php }
			}?>
			<div class="heading">
				<h1>Vision:</h1>
				<h3>Solving Information Integration Challenges by Recording Health data and events and transferring them into useful information for management and performance.</h3><br>
			</div>
			<div class="container"> <!--small slider-->
				<div class="row">
					<div id="carousel-example" class="carousel slide" data-ride="carousel">
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item">
								<div class="row">
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/1.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/2.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/3.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/4.jpg" class="img-responsive">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="item active">
								<div class="row">
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/5.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/6.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/7.jpg" class="img-responsive">
											</div>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="col-item">
											<div class="photo">
												<img src="<?php echo base_url(); ?>includes/images/smallslider/8.jpg" class="img-responsive">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--end of small slider-->
			<div class="container">
				<h3 class="blinking" style="color:red;"><strong>Alerts</strong></h3>
				<div class="col-sm-6" style="margin-top: -10px;">
					<h4 style="color:red;"><strong>Submission of Reports</strong></h4>
						<ul>
							<li><p style="color:red;">Monthly Reports submitted up to 10th of every month will be considered on Time.</p></li>
							<li><p style="color:red;">Weekly Zero Reports submitted on Monday of every week will be considered on Time.</p></li>
						</ul>
				</div>
					<?php
						if(($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')){ 
							$distcode = $_SESSION['District'];
							//echo $distcode;
							$msl_and_mainquery = "SELECT count(*) AS recordnum FROM case_investigation_db WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
							$result = $this-> db -> query($msl_and_mainquery);
							$record = $result -> row_array();
							$num_of_cases = $record['recordnum'];

							$afpquery = "SELECT count(*) AS recordnum FROM afp_case_investigation WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
							$result = $this-> db -> query($afpquery);
							$record = $result -> row_array();
							$afpcases = $record['recordnum'];

							$nntquery = "SELECT count(*) AS recordnum FROM nnt_investigation_form WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode')";
							$result = $this-> db -> query($nntquery);
							$record = $result -> row_array();
							$nntcases = $record['recordnum'];

							$fweekquery = "SELECT distcode, fweek, case_type, count(*) as cases FROM case_investigation_db WHERE approval_status='Pending' AND distcode = '$distcode' AND (cross_notified_from_distcode != '$distcode' OR rb_distcode != '$distcode') GROUP BY distcode, fweek, case_type ORDER BY distcode, fweek ASC";
							$result = $this-> db -> query($fweekquery);
							$fweeks = $result -> result_array();
							//$fweeks = $record['fweek'];
							//print_r($fweeks);exit();
						}

					?>
				<div class="col-sm-6" style="margin-top: -10px;">
					<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO')) { 
					 	if ($num_of_cases > 0 || $afpcases > 0 || $nntcases > 0) { ?>
						<h4 style="color:red;"><strong>Cross Notified Cases</strong></h4>
						<ul>
							<li>
								<p style="color:red;">You have pending Cross Notified case(s) from other district(s). To Approve the case(s), 
								<?php
									echo '<a href="'.base_url().'Cross_notified_cases/Cross_notified_cases_list" style="color:red" target="_blank" class="blinking"><strong> CLICK HERE </strong></a>';
								?>	to continue.								
								</p>
							</li>								
						</ul>
					<?php } } ?>
				</div>

				<?php
					if(($_SESSION['UserLevel']=='2') && isset($_SESSION['utype']) && ($_SESSION['utype']!='DEO')){ 
						$procode = $_SESSION['Province'];
						//echo $procode;

						//echo
						$msl_and_mainquery = "SELECT count(*) AS recordnum FROM case_investigation_db WHERE approval_status='Pending' AND substring(distcode,1,1) = '$procode' AND cross_notified_from_distcode != distcode AND (substring(cross_notified_from_distcode,1,1) = '$procode' OR substring(cross_notified_from_distcode,1,1) != '$procode') AND ((substring(rb_distcode,1,1) = '$procode' OR substring(rb_distcode,1,1) != '$procode'))";
						//exit();
						$result = $this-> db -> query($msl_and_mainquery);
						$record = $result -> row_array();
						$num_of_cases = $record['recordnum'];
						//echo $num_of_cases;
						
						//echo 
						$afpquery = "SELECT count(*) AS recordnum FROM afp_case_investigation WHERE approval_status='Pending' AND substring(distcode,1,1) = '$procode' AND cross_notified_from_distcode != distcode AND (substring(cross_notified_from_distcode,1,1) = '$procode' OR substring(cross_notified_from_distcode,1,1) != '$procode') AND ((substring(rb_distcode,1,1) = '$procode' OR substring(rb_distcode,1,1) != '$procode'))";
						//exit();
						$result = $this-> db -> query($afpquery);
						$record = $result -> row_array();
						$afpcases = $record['recordnum'];
						//echo $afpcases;
						
						//echo
						$nntquery = "SELECT count(*) AS recordnum FROM nnt_investigation_form WHERE approval_status='Pending' AND substring(distcode,1,1) = '$procode' AND cross_notified_from_distcode != distcode AND (substring(cross_notified_from_distcode,1,1) = '$procode' OR substring(cross_notified_from_distcode,1,1) != '$procode') AND ((substring(rb_distcode,1,1) = '$procode' OR substring(rb_distcode,1,1) != '$procode'))";
						//exit();
						$result = $this-> db -> query($nntquery);
						$record = $result -> row_array();
						$nntcases = $record['recordnum'];
						//echo $nntcases;
						$total_cases = $num_of_cases+$afpcases+$nntcases;
						
					}
				?>	
				<div class="col-sm-6" style="margin-top: -10px;">
					<?php if (($_SESSION['UserLevel']=='2') && isset($_SESSION['utype']) && ($_SESSION['utype']!='DEO')) { 
					 	if ($num_of_cases > 0 || $afpcases > 0 || $nntcases > 0) { ?>
						<h4 style="color:red;"><strong>Cross Notified Cases</strong></h4>
						<ul>
							<li>
								<!-- <p style="color:red;"> <?php echo $total_cases; ?> Some districts have Cross Notified cases pending approval. To view those districts, --> 
								<p style="color:red;"> There are <span class="blinking"><?php echo $total_cases; ?></span> total Cross Notified cases pending approval from different districts. To view those cases district-wise,
								<?php
									echo '<a href="'.base_url().'CrossNotifiedCases/Filters/PendingCases" style="color:red" target="_blank" class="blinking"><strong> CLICK HERE </strong></a>';
								?>	to continue.								
								</p>
							</li>								
						</ul>
					<?php } } ?>
				</div>
			</div>
		</div><!--end of body container-->

		
		