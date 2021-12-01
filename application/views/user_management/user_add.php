<?php $utype=$_SESSION['utype']; ?>
<?php //print_r($userInfo); exit(); ?>
<div class="container bodycontainer">
	<div class="row">
		<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
  			<div class="panel panel-primary">
    			<ol class="breadcrumb">
          		<?php  echo $this->breadcrumbs->show();?>
       		</ol>
    			<div class="panel-heading">EPI-MIS | User Account Form</div>
  	   		<div class="panel-body">
    	   		<form name="dataform" id="dataform" action="<?php echo base_url();?>User_management/user_add" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
			    		<div class="row">
			    		   <div class="form-group">
								<label class="col-xs-2 control-label col-md-offset-1" for = "procode" > Province</label>
								<div class="col-xs-3">
									<select id="procode" required name="procode" class="form-control" size="1" >
										<option value="<?php echo $this -> session -> Province; ?>" ><?php echo $this -> session -> provincename; ?></option>
									</select>
								</div>
		  					  	<label class="col-xs-2 control-label" for = "utype" >User Type</label>
							  	<div class="col-xs-3">
									<select id="utype" required name="utype" class="form-control" size="1" >
										<option value="">--- Select User Type ---</option>
										<?php foreach($resultTypes as $row){ ?>
											<option <?php if(isset($userInfo) && ($userInfo[0]['utype']==$row['usertype'])) { echo "selected='selected'"; } else{} ?> value="<?php echo $row['usertype'];?>" ><?php echo $row['usertype'];?></option>
											<?php							
										} ?>										
									</select>
							 	</div>
						   </div>
						</div>
						<div class="row">
						   <div class="form-group">
						   	<label class="col-xs-2 control-label col-md-offset-1" for = "uname" >User Level</label>
							  	<div class="col-xs-3">
									<select id="level" required name="level" class="form-control" size="1" >
										<option value="">--- Select Level ---</option>
										<?php foreach($resultLevel as $row){ ?>
											<option <?php if(isset($userInfo) && ($userInfo[0]['level']==$row['userlevel'])) { echo "selected='selected'"; } else{} ?> value="<?php echo $row['userlevel'];?>" ><?php echo $row['userlevel_description'];?></option>
											<?php							
										} ?>										
									</select>
							  	</div>
							  	<label class="col-xs-2 control-label distUM" for = "distcode" >District</label>
								<div class="col-xs-3 distUM">
									<select id="distcodeUM" name="distcode" class="form-control" size="1" >
										<option value="">--- Select District ---</option>
										<?php foreach($resultDist as $row){ ?>
											<option <?php if(isset($userInfo) && ($userInfo[0]['distcode']==$row['distcode'])) { echo "selected='selected'"; } else{} ?> value="<?php echo $row['distcode'];?>" ><?php echo $row['district'];?></option>
											<?php							
										} ?>
									</select>
								</div>
								<label class="col-xs-2 control-label unameFedPro" for = "uname" >User Name</label>
							  	<div class="col-xs-3 unameFedPro">
									<input name="username" id="unameFedPro" placeholder="User Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>"/>
									<input name="oldusername" id="oldusernameFedPro" value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>" type="hidden" />
							  	</div> 
						   </div>
						</div>
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1 tehUM" for = "tcode" >Tehsil Name</label>
							   <div class="col-xs-3 tehUM">
									<select id="tcodeUM" required name="tcode" class="form-control" size="1" >
									<?php if(isset($userInfo) && $userInfo[0]['tcode'] > '0'){ ?>
										<?php getTehsils_options(false,$userInfo[0]['tcode'],$userInfo[0]['distcode']); ?>
									<?php } else { ?>	
										<option value="0">--- Select Tehsil ---</option>
									<?php } ?>									
									</select>
							  	</div>
							  	<label class="col-xs-2 control-label ucUM" for = "uncode" >Union Council Name</label>
							   <div class="col-xs-3 ucUM">
									<select id="uncodeUM" required name="uncode" class="form-control" size="1" >
									<?php if(isset($userInfo) && $userInfo[0]['uncode'] > '0'){ ?>
										<?php getUCs(false,$userInfo[0]['uncode'],$userInfo[0]['tcode']); ?>
									<?php } else { ?>	
										<option value="0">--- Select Union Council ---</option>
									<?php } ?>									
									</select>
							  	</div>
							  	<label class="col-xs-2 control-label unameTehsil" for = "uname" >User Name</label>
							  	<div class="col-xs-3 unameTehsil">
									<input name="username" id="unameTehsil" placeholder="User Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>"/>
									<input name="oldusername" id="oldusernameTehsil" value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>" type="hidden" />
							  	</div>							  					   
						   </div>
						</div>
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label flcfUM col-md-offset-1" for = "facode" >Facility Name</label>
							   <div class="col-xs-3 flcfUM">
									<select id="facodeUM" required name="facode" class="form-control" size="1" >
										<?php if(isset($userInfo) && $userInfo[0]['facode'] > '0'){ ?>
										<?php getFacilities_options(false,$userInfo[0]['facode'],$userInfo[0]['uncode']); ?>
										<?php } else { ?>	
											<option value="0">--- Select Facility ---</option>
										<?php } ?>								
									</select>
							  	</div>							  	
							  	<label class="col-xs-2 control-label unameFLCF" for = "uname" >User Name</label>
							  	<div class="col-xs-3 unameFLCF">
									<input name="username" id="unameFLCF" placeholder="User Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>"/>
									<input name="oldusername" id="oldusernameFLCF" value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>" type="hidden" />
							  	</div> 
							  	<label class="col-xs-2 control-label unameUC col-md-offset-1" for = "uname" >User Name</label>
							  	<div class="col-xs-3 unameUC">
									<input name="username" id="unameUC" placeholder="User Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>"/>
									<input name="oldusername" id="oldusernameUC" value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>" type="hidden" />
							  	</div> 
							  	<label class="col-xs-2 control-label unameDist col-md-offset-1" for = "uname" >User Name</label>
							  	<div class="col-xs-3 unameDist">
									<input name="username" id="unameDist" placeholder="User Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>"/>
									<input name="oldusername" id="oldusernameDist" value="<?php echo isset($userInfo)?$userInfo[0]["username"]:""; ?>" type="hidden" />
							  	</div>					   
						   </div>
						</div>
						<div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Password</label>
							   <div class="col-xs-3">
									<input type="password" name="password" id="password" placeholder="Password"  class="form-control " value=""/>
									<?php echo isset($userInfo)?"<p>leave empty to keep old password.</p>":""; ?>
							  	</div>
							   <label class="col-xs-2 control-label" for = "uname" >Full Name</label>
								<div class="col-xs-3">
									<input required name="fullname" id="fullname" placeholder="Full Name"  class="form-control " value="<?php echo isset($userInfo)?$userInfo[0]["fullname"]:""; ?>"/>
								</div>
						   </div>
						</div>
                       <div class="row">
						  	<div class="form-group">
						  		<label class="col-xs-2 control-label col-md-offset-1" for = "facode" >Active</label>
							   <div class="col-xs-3">
									<input type="radio" name="active" value= '1' checked>YES
									<input type="radio" name="active" value= '0'> NO
							  	</div>
						   </div>
						</div>
						<hr>
		            <div class="row">
		               <div class="col-xs-7 cmargin22" >
								<?php if(isset($userInfo)){?>
									<button type="submit" id="UpdateUser" name="UpdateUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Update User </button>
								<?php }else{?>
									<button type="submit" id="AddUser" name="AddUser" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Add User </button>
								<?php }?>
									<button type="reset" class="btn btn-md btn-success"><i class="fa fa-repeat"></i> Reset Form </button>
									<a href="<?php echo base_url();?>User_management/user_list" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
							</div>
						</div>
					</form>
				</div> <!--end of panel body-->
			</div> <!--end of panel panel-primary-->
		</div><!--end of row-->
	</div><!--End of page content or body container-->

	<script type="text/javascript">
		<?php if(isset($userInfo)) { ?>
			<?php if($userInfo[0]["level"]=="1" || $userInfo[0]["level"]=="2") {?>
				$(document).ready(function(){
					$('.distUM').addClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').removeClass('hide');
					$('#unameFedPro').removeAttr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#distcodeUM').removeAttr('required','required');
					$('#tcodeUM').removeAttr('required','required');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					//$('#oldusernameFedPro').
					$('#oldusernameDist').attr('disabled','disabled');
					$('#oldusernameTehsil').attr('disabled','disabled');
					$('#oldusernameUC').attr('disabled','disabled');
					$('#oldusernameFLCF').attr('disabled','disabled');
				});
			<?php } ?>

			<?php if($userInfo[0]["level"]=="3") {?>
				$('.distUM').removeClass('hide');
				$('.tehUM').addClass('hide');
				$('.ucUM').addClass('hide');
				$('.flcfUM').addClass('hide');
				$('.unameFedPro').addClass('hide');
				$('#unameFedPro').attr('disabled','disabled');
				$('.unameDist').removeClass('hide');
				$('#unameDist').removeAttr('disabled','disabled');
				$('.unameTehsil').addClass('hide');
				$('#unameTehsil').attr('disabled','disabled');
				$('.unameUC').addClass('hide');
				$('#unameUC').attr('disabled','disabled');
				$('.unameFLCF').addClass('hide');
				$('#unameFLCF').attr('disabled','disabled');				
				$('#tcodeUM').removeAttr('required','required');
				$('#uncodeUM').removeAttr('required','required');
				$('#facodeUM').removeAttr('required','required');
				$('#oldusernameFedPro').attr('disabled','disabled');
				$('#oldusernameTehsil').attr('disabled','disabled');
				$('#oldusernameUC').attr('disabled','disabled');
				$('#oldusernameFLCF').attr('disabled','disabled');
			<?php } ?>

			<?php if($userInfo[0]["level"]=="4") {?>
				$('.distUM').removeClass('hide');
				$('.tehUM').removeClass('hide');
				$('.ucUM').addClass('hide');
				$('.flcfUM').addClass('hide');
				$('.unameFedPro').addClass('hide');
				$('#unameFedPro').attr('disabled','disabled');
				$('.unameDist').addClass('hide');
				$('#unameDist').attr('disabled','disabled');
				$('.unameTehsil').removeClass('hide');
				$('#unameTehsil').removeAttr('disabled','disabled');
				$('.unameUC').addClass('hide');
				$('#unameUC').attr('disabled','disabled');
				$('.unameFLCF').addClass('hide');
				$('#unameFLCF').attr('disabled','disabled');
				$('#uncodeUM').removeAttr('required','required');
				$('#facodeUM').removeAttr('required','required');
				$('#uncodeUM').html('');
				$('#facodeUM').html('');
				$('#oldusernameFedPro').attr('disabled','disabled');
				$('#oldusernameDist').attr('disabled','disabled');
				$('#oldusernameUC').attr('disabled','disabled');
				$('#oldusernameFLCF').attr('disabled','disabled');
			<?php } ?>
			<?php if($userInfo[0]["level"]=="5") {?>
				$('.distUM').removeClass('hide');
				$('.tehUM').removeClass('hide');
				$('.ucUM').removeClass('hide');
				$('.flcfUM').addClass('hide');
				$('.unameFedPro').addClass('hide');
				$('#unameFedPro').attr('disabled','disabled');
				$('.unameDist').addClass('hide');
				$('#unameDist').attr('disabled','disabled');
				$('.unameTehsil').addClass('hide');
				$('#unameTehsil').attr('disabled','disabled');
				$('.unameUC').removeClass('hide');
				$('#unameUC').removeAttr('disabled','disabled');
				$('.unameFLCF').addClass('hide');
				$('#unameFLCF').attr('disabled','disabled');
				$('#facodeUM').removeAttr('required','required');
				$('#facodeUM').html('');
				$('#oldusernameFedPro').attr('disabled','disabled');
				$('#oldusernameDist').attr('disabled','disabled');
				$('#oldusernameTehsil').attr('disabled','disabled');
				$('#oldusernameFLCF').attr('disabled','disabled');
			<?php } ?>
			<?php if($userInfo[0]["level"] == "6") {?>
				$('.distUM').removeClass('hide');
				$('.tehUM').removeClass('hide');
				$('.ucUM').removeClass('hide');
				$('.flcfUM').removeClass('hide');
				$('.unameFedPro').addClass('hide');
				$('#unameFedPro').attr('disabled','disabled');
				$('.unameDist').addClass('hide');
				$('#unameDist').attr('disabled','disabled');
				$('.unameTehsil').addClass('hide');
				$('#unameTehsil').attr('disabled','disabled');
				$('.unameUC').addClass('hide');
				$('#unameUC').attr('disabled','disabled');
				$('.unameFLCF').removeClass('hide');
				$('#unameFLCF').removeAttr('disabled','disabled');
				$('#oldusernameFedPro').attr('disabled','disabled');
				$('#oldusernameDist').attr('disabled','disabled');
				$('#oldusernameTehsil').attr('disabled','disabled');
				$('#oldusernameUC').attr('disabled','disabled');
			<?php } ?>
			$(document).on('change','#level',function(){
				// val = $(this).val();
				// alert(val);
				if($(this).val() == 1 || $(this).val() == 2){ //Federal and Provincial Level
					//$('#withdays').removeClass('hide');
					$('.distUM').addClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').removeClass('hide');
					$('#unameFedPro').removeAttr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#distcodeUM').removeAttr('required','required');
					$('#tcodeUM').removeAttr('required','required');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#distcodeUM').html('');
					$('#tcodeUM').html('');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 3){ //District Level
					$('.distUM').removeClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').removeClass('hide');
					$('#unameDist').removeAttr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');				
					$('#tcodeUM').removeAttr('required','required');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#tcodeUM').html('');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
					$.ajax({ 
						type: 'POST',
						data: '',
						url: '<?php echo base_url();?>Ajax_control_panel/getDistricts_options',
						success: function(data){		
							$('#distcodeUM').html(data);
						}
					});
				}
				else if($(this).val() == 4){ //Tehsil Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').removeClass('hide');
					$('#unameTehsil').removeAttr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 5){ //Union Council Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').removeClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').removeClass('hide');
					$('#unameUC').removeAttr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#facodeUM').removeAttr('required','required');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 6){ //Facility Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').removeClass('hide');
					$('.flcfUM').removeClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').removeClass('hide');
					$('#unameFLCF').removeAttr('disabled','disabled');
				}
				else if($(this).val() == ''){
					$('.distUM').addClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').removeClass('hide');
					$('#unameFedPro').removeAttr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#unameDist').removeAttr('required','required');
					$('#unameTehsil').removeAttr('required','required');
					$('#unameUC').removeAttr('required','required');
					$('#unameFLCF').removeAttr('required','required');
				}
			});
		<?php } else { ?>
			$(document).ready(function(){
				$('.distUM').addClass('hide');
				$('.tehUM').addClass('hide');
				$('.ucUM').addClass('hide');
				$('.flcfUM').addClass('hide');
				$('.unameFedPro').removeClass('hide');
				$('#unameFedPro').removeAttr('disabled','disabled');
				$('.unameDist').addClass('hide');
				$('#unameDist').attr('disabled','disabled');
				$('.unameTehsil').addClass('hide');
				$('#unameTehsil').attr('disabled','disabled');
				$('.unameUC').addClass('hide');
				$('#unameUC').attr('disabled','disabled');
				$('.unameFLCF').addClass('hide');
				$('#unameFLCF').attr('disabled','disabled');
				$('#distcodeUM').removeAttr('required','required');
				$('#tcodeUM').removeAttr('required','required');
				$('#uncodeUM').removeAttr('required','required');
				$('#facodeUM').removeAttr('required','required');
			});
			$(document).on('change','#level',function(){
				// val = $(this).val();
				// alert(val);
				if($(this).val() == 1 || $(this).val() == 2){ //Federal and Provincial Level
					//$('#withdays').removeClass('hide');
					$('.distUM').addClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').removeClass('hide');
					$('#unameFedPro').removeAttr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#distcodeUM').removeAttr('required','required');
					$('#tcodeUM').removeAttr('required','required');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#distcodeUM').html('');
					$('#tcodeUM').html('');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 3){ //District Level
					$('.distUM').removeClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').removeClass('hide');
					$('#unameDist').removeAttr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');				
					$('#tcodeUM').removeAttr('required','required');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#tcodeUM').html('');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
					$.ajax({ 
						type: 'POST',
						data: '',
						url: '<?php echo base_url();?>Ajax_control_panel/getDistricts_options',
						success: function(data){		
							$('#distcodeUM').html(data);
						}
					});
				}
				else if($(this).val() == 4){ //Tehsil Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').removeClass('hide');
					$('#unameTehsil').removeAttr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#uncodeUM').removeAttr('required','required');
					$('#facodeUM').removeAttr('required','required');
					$('#uncodeUM').html('');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 5){ //Union Council Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').removeClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').removeClass('hide');
					$('#unameUC').removeAttr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#facodeUM').removeAttr('required','required');
					$('#facodeUM').html('');
				}
				else if($(this).val() == 6){ //Facility Level
					$('.distUM').removeClass('hide');
					$('.tehUM').removeClass('hide');
					$('.ucUM').removeClass('hide');
					$('.flcfUM').removeClass('hide');
					$('.unameFedPro').addClass('hide');
					$('#unameFedPro').attr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').removeClass('hide');
					$('#unameFLCF').removeAttr('disabled','disabled');
				}
				else if($(this).val() == ''){
					$('.distUM').addClass('hide');
					$('.tehUM').addClass('hide');
					$('.ucUM').addClass('hide');
					$('.flcfUM').addClass('hide');
					$('.unameFedPro').removeClass('hide');
					$('#unameFedPro').removeAttr('disabled','disabled');
					$('.unameDist').addClass('hide');
					$('#unameDist').attr('disabled','disabled');
					$('.unameTehsil').addClass('hide');
					$('#unameTehsil').attr('disabled','disabled');
					$('.unameUC').addClass('hide');
					$('#unameUC').attr('disabled','disabled');
					$('.unameFLCF').addClass('hide');
					$('#unameFLCF').attr('disabled','disabled');
					$('#unameDist').removeAttr('required','required');
					$('#unameTehsil').removeAttr('required','required');
					$('#unameUC').removeAttr('required','required');
					$('#unameFLCF').removeAttr('required','required');
				}
			});
		<?php } ?>

		$(document).on('change','#distcodeUM', function(){
			var distcode = $('#distcodeUM').val();
			//to get tehsils of selected distcrict
			if($("#tcodeUM").length == 0) {
			  //it doesn't exist
			}
			else{
				$.ajax({
					type: "POST",
					data: "distcode="+distcode,
					url: "<?php echo base_url(); ?>Ajax_control_panel/getTehsils",
					success: function(result){
						$('#tcodeUM').html(result);
						$('#uncodeUM').html('');
						$('#facodeUM').html('');
					}
				});
			}							
		});
		$(document).on('change','#tcodeUM', function(){
			var tcode = $('#tcodeUM').val();
			//to get tehsils of selected distcrict
			if($("#tcodeUM").length == 0) {
			  //it doesn't exist
			}
			else{
				$.ajax({
					type: "POST",
					data: "tcode="+tcode,
					url: "<?php echo base_url(); ?>Ajax_control_panel/getUnC",
					success: function(result){
						$('#uncodeUM').html(result);
						$('#facodeUM').html('');
					}
				});
			}							
		});
		$(document).on('change','#uncodeUM', function(){
			var uncode = $('#uncodeUM').val();
			//to get tehsils of selected distcrict
			if($("#uncodeUM").length == 0) {
			  //it doesn't exist
			}
			else{
				$.ajax({
					type: "POST",
					data: "uncode="+uncode,
					url: "<?php echo base_url(); ?>Ajax_control_panel/getFacilities",
					success: function(result){
						$('#facodeUM').html(result);
					}
				});
			}							
		});
	</script>





