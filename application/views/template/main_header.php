	<?php
  $distcode=$this -> session -> District;  
  $UserLevel=$this -> session -> UserLevel; 
  
								 ?>		
			<header class="main-header">
				<a href="<?php echo base_url(); ?>" class="logo"><span class="logo-mini"><b>EPI</b></span><span class="logo-lg"><b>EPI</b>-MIS</span></a>
				<!-- Header Navbar -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" id="resizeId-uk" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="<?php echo base_url();?>user_management/usersContact"><i class="fa fa-info-circle"></i><span>Provide Contact Information</span></a>								
							</li>
							<li class="dropdown user user-menu">
								<a href="<?php echo base_url();?>Feedback/feedbackForm"><i class="fa fa-envelope"></i><span>Feedback</span></a>								
							</li>
								
							<li class="dropdown messages-menu">
								<a href="#"><i class="fa fa-map-marker"></i><span> <?php echo $this -> session -> loginfrom; ?></span></a>
							</li>
							<?php if($distcode > 0 AND $UserLevel==3){ ?>
							<li class="dropdown user user-menu" style="background: #920b0b;">
								<?php
                                $distcode=$this -> session -> District;  
								print_r(error_notif($distcode)); ?>
							</li>
							<?php }?>
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><span><?php echo $this -> session -> User_Name; ?></span></a>
								<ul class="dropdown-menu">
									<li class="user-footer">
										<div class="pull-right">
											<a href="<?php echo base_url();?>Logout" class="btn btn-default btn-flat">Sign out</a>
										</div>
									</li>
								</ul>
							</li>	
 							
							<?php if($this -> session -> username != 'kp_kphis'){ ?>
							<li>
								<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
							</li>
							<?php } ?>
							
						</ul>
					</div>
				</nav>
			</header>
			<!-- <div class="loading hide">Loading&#8230;</div> -->