
			<footer class="main-footer">
					<!-- To the right -->
					<div class="pull-right hidden-xs">
					  <!-- Anything you want -->
					</div>
					<!-- Default to the left -->
					<strong>Copyright &copy; all rights reserved. Department of Health, <?php echo $this -> session -> provincename; ?>.</strong>
			</footer>
			<!--end of footer-->
			<?php if($this -> session -> utype != "Manager"){ ?>
			<aside class="control-sidebar control-sidebar-dark" style="margin-top:100px;">
				<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
					<li class="active"><a href="<?php echo base_url();?>login/Change_password" data-toggle="tab"><i class="fa fa-unlock-alt"></i>Change Password</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="control-sidebar-home-tab">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group">  
									<input  class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" required="" type="password">
								</div>
								<div class="form-group">
									<input  class="form-control" id="newpassword" name="newpassword" placeholder="New Password" required="" type="password">
								</div>
								<div class="form-group">
									<input  class="form-control" id="repeatnewpassword" name="repeatnewpassword" onkeyup="validateConfirmPassword()" placeholder="Confirm New Password" required="" type="password">
								</div>
								<input type="hidden" id="username" name="username" value="<?php echo $this -> session -> User_Name; ?>" />
								<span id="txtCpwd" style="color:green;"> </span>
								<span class="st" id="error" style="color:Black;"></span>
								<span class="st" id="txtHint" style="color:Black;"></span> 
								<button type="button" onclick="updatePassword()" class="btn btn-success" style="width:100%;">Update Password</button>
								<br>
								<div class="form-group">
									<label>Your IP Address:</label><br>
									<?php $ip = $this->input->ip_address();
									echo $ip; ?>                                         
								</div>
								<div class="form-group">
									<label>Your Browser Info:</label>
									<?php $this->load->library('user_agent');
									if ($this->agent->is_browser())
									{
									$agent = $this->agent->browser().' '.$this->agent->version();
									}
									elseif ($this->agent->is_robot())
									{
									$agent = $this->agent->robot();
									}
									elseif ($this->agent->is_mobile())
									{
									$agent = $this->agent->mobile();
									}
									else
									{
									$agent = 'Unidentified User Agent';
									}
									echo $agent.'<br>';
									echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)  ?>                                          
								</div>
							</div>
						</div>
						<div class="col-xs-1"></div>
					</div>
				</div>
			</aside>
			<?php } ?>
			<div class="control-sidebar-bg" style="margin-top: 90px;"></div>
 
