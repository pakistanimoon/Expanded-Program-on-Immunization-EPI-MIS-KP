

<div class="container">
<div class="row">
 <div class="col-xs-6 col-xs-offset-3">	
  <div class="panel panel-primary">
    <div class="panel-heading text-center">LHW-MIS | <?php echo "Payroll Report Filter"; ?></div>
  	   <div class="panel-body">
    	   	<form name="dataform" target="_self" id="dataform" action="<?php echo base_url();?>setup_listing/payroll_report_view" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
    	   	  <div class="row">
			    <div class="form-group">
			 	  <label class="col-xs-3 control-label" for = "tcode" >District:</label>
				  <div class="col-xs-7">
			    	<select id="distcode" name="distcode" class="filter-status  form-control" >
					<?php
						if($level=='2'){
					?>
						<option value="" selected='selected' />Select ..
					<?php
						}
					foreach($district as $row){                         
					?>
						<option  value="<?=$row['distcode'];?>" <?php if($level=='3') echo "selected='selected'";?>/><?=$row['district'];?>
                    <?php  }                       ?>
																</select>
				  </div>  					
				</div>
			  </div>
			   <div class="row">
			    <div class="form-group">
			 	  <label class="col-xs-3 control-label paddingzero" for = "reportType" >Report For:</label>
				  <div class="col-xs-7 paddingzero">
			    		<select id="reportType" name="reportType" class="filter-status  form-control">
							<option value="lhw">Lady Health Worker</option>
							<option value="lhs">Lady Health Supervisor</option>
							<option value="driver">Driver</option>
							<option value="as">Account Supervisor</option>
						</select>
				  </div>  					
				</div>
			  </div>
			   <div class="row">
			    <div class="form-group">
			 	  <label class="col-xs-3 control-label paddingzero" for = "year" >Year:</label>
				  <div class="col-xs-7 paddingzero">
			    		<select id="year" name="year" class="filter-status  form-control">
					<?php
						for($i=(int)date("Y");$i>=2010;$i--){
						?>
						<option value="<?=$i?>"  <?php 
						if($i==(int)date("Y")){ echo "selected='selected'";}
						?> ><?=$i?></option>
						<?php
						}
						$i=(int)date("m")-1;
						?>
					</select>
				  </div>  					
				</div>
			  </div>
			
			 
			  <hr>
			  <div class="row">
			  	<div class="col-xs-3 cmargin8">
			     <button type="submit" class="btn btn-md btn-primary"><i class="fa fa-search"></i> Preview 
			     </button>
			    </div>
			  </div>
	      </form>





  	</div> <!--end of panel panel-body-->
 </div> <!--end of panel panel-primary-->
 </div><!--end of column-->	
</div><!--end of row main-->

</div><!--End of page content or body contaier-->


<!--start of footer-->
<br>
<br>
	<script type="text/javascript">
								$('#distcode').on('change' , function (){
									var distcode = $('#distcode').val();
									$.ajax({
										type: "GET",
										data: "distcode="+distcode,
										url: "<?php echo base_url();?>/Ajax_calls/getFacilities",
										success: function(result){
											$('#facode').html(result);
										}
	
									});
								});								
						</script>


	