<div class="container bodycontainer">
<div class="row">
  <div class="panel panel-primary">
    <div class="panel-heading"> Change Password Form</div>
  	   <div class="panel-body">
	    		<div class="row">
									    	<div class="col-xs-10 col-xs-offset-1">
											 <div class="form-group">
													<label>Your IP Address:</label>											 
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
													echo $agent;
													echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)  ?>
			                                    </div>
										        <div class="form-group">  
			                                    	<input style="width: 50%;" type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old Password" required>
			                                    </div>
			                                    <div class="form-group">
			                                    	<input style="width: 50%;" type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" required>
			                                    </div>
			                                    <div class="form-group">
			                                    	<input style="width: 50%;" type="password" class="form-control" id="repeatnewpassword" name="repeatnewpassword" onkeyup="validateConfirmPassword()" placeholder="Conform New Password" required>
			                                    </div>
		                                    	<input type="hidden" id="username" name="username" value="<?php echo $this -> session -> User_Name; ?>" />
		                                  		<span id="txtCpwd" style="color:green;"> </span>
		                                  		<span class="st" id="error" style="color:Black;"></span>
									       		<span class="st" id="txtHint" style="color:Black;"></span> 
		                                    	<div class="form-group">
		                                       		<button type="button" onclick="updatePassword()" class="btn btn-success">Update Password</button>
		                                    	</div>
		                                    </div>
		                                    <div class="col-xs-1"></div>
		                                </div> 
<hr>
  	</div> <!--end of panel body-->
 </div> <!--end of panel panel-primary-->
</div><!--end of row-->	
</div><!--End of page content or body contaier-->