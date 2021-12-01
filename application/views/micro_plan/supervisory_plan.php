 			<?php
			//Local
if($this -> session -> flashdata('message')){  ?>
                          <div class="row mb3">
                            <div class="col-sm-12 filters-selection" style="Background-color:#008d4c;">
                              <div class="text-center pt5 pb5" role="alert" style="color:white;"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> 
                            </div>
                          </div>
                        <?php } ?>
<div class="container">
	<div class="row">
	<div class="panel panel-primary">
		<ol class="breadcrumb">
		<!-- <ul class="breadcrumb"><li><a href="http://epimis.kphealth.pk/">Home</a> <span class="divider"></span></li><li class="active">Facility Monthly Vaccination Reports</li></ul>
 -->		
 			<ul class="breadcrumb">
 				<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
				<li class="active"></li>
			</ul>
		</ol> 
		<div class="panel-heading">Supervisory Micro Plan
		</div>
		<div class="panel-body">
						<!--it is use for show message-->
			<form method="post" id="filter-form" class="form-inline table-supervisor" >
				 <div class="row">
         
        <div class="col-xs-2 col-sm-offset-1 control-label lbl-setting">
          <label>Supervisor Type:</label>
        </div>
        <div class="col-xs-3">
          <select  onchange="getSuperType()" id="supervisor_type" name="supervisor_type" class="filter-status  form-control">
                     <option value="">All</option>
                     <?php
                     foreach($resultSuper_type as $row){
                      ?>
                      <option value="<?php echo str_replace(' ', ' ',$row['designation']);?>" ><?php echo $row['designation'];?></option>
                      <?php
                    }
                    ?>
                </select> 
        </div> 
		<div class="col-md-2">
								<label>Quarter:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT distinct quarter,CASE WHEN quarter='01' then 'Quarter 1' WHEN quarter ='02' then 'Quarter 2' WHEN  quarter='03' then 'Quarter 3' WHEN  quarter='04' then 'Quarter 4' ELSE '' END from supervisory_plan where distcode='{$distcode}' order by quarter DESC";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control filter-status" name="quarter" id="quarter">
									<option value=""></option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['quarter']; ?>"><?php echo $value['case']; ?></option>
								<?php } ?>
								</select>
							</div>			
      </div>
      </div>
      </div>
      </div>
				</form>
				<table id="micro-tbl" class="table table-bordered table-hover table-sessiontype">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Supervisor Name</th>
							<th>Designation</th>
							<th>Quarter</th>
							<!--<th>Area name</th>-->
							<th class="text-center Heading">
								<?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
									<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_add" data-toggle="tooltip" title="Add New Supervisor">
									 <button class="submit btn-success btn-sm"><i class="fa fa-plus"></i> Add New</button>
									</a>
								<?php } else{?>
									Action
								<?php }?>
                            </th>
						</tr>
					</thead>
					<tbody id="tbody">            
	<?php
							$i=0;
							foreach($data as $row){
							$i++;
						   ?>
                          <tr>
                              <td class="text-center"><?php echo $i; ?></td>
                              <td class="text-left"><?php
							  
							  $str = $row['supervisorcode'];
							  if (strlen($str) <= 7) {
								  if(isset($row)){
									 echo get_supervisor_Name($row['supervisorcode']); 
									}
								} else{
									if(isset($row)){
									 echo get_supervisor_Name_hr_db($row['supervisorcode']); 
									}
							  }
				?></td>
						<td class="text-center">
				<?php	
						$str = $row['supervisorcode'];
						if (strlen($str) <= 7) { 
								echo $row['designation']; 
						} else { 
							echo $row['designation']; 
							}  ?> 
											</td>
	                                                      
                              <td class="text-center"><?php echo $row['case']; echo ' - ('; echo $row['year']; echo ')'; ?></td>
                              <!--<td class="text-center"><?php echo get_Village_Name($row['area_name']); ?></td>-->
							  
							   
                              <td class="text-center">                                
                                   <?php if($row['status'] == 1) {?>
										<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_view/<?php echo $row['supervisorcode']; ?>/<?php echo $row['quarter']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a> 
                                   <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
										<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_conducted/<?php echo $row['supervisorcode']; ?>/<?php echo $row['quarter']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Conducted" class="btn btn-xs btn-default"><i class="fa fa-calendar-check-o" aria-hidden="true" style="background:#057140; font-size:20px; color:white;"></i></a>
								    <?php }?>
								   <?php }else{?>
										<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_view/<?php echo $row['supervisorcode']; ?>/<?php echo $row['quarter']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="View" class="btn btn-xs btn-default"><i class="fa fa-search"></i></a>
                                   <?php if (($_SESSION['UserLevel']=='3') && ($_SESSION['utype']=='DEO') ){?>
										<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_edit/<?php echo $row['supervisorcode']; ?>/<?php echo $row['quarter']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
										<a href="<?php echo base_url(); ?>micro_plan/Micro_plan_controller/supervisory_plan_conducted/<?php echo $row['supervisorcode']; ?>/<?php echo $row['quarter']; ?>/<?php echo $row['year']; ?>" data-toggle="tooltip" title="Conducted" class="btn btn-xs btn-default"><i class="fa fa-calendar-check-o" aria-hidden="true" style="background:#057140; font-size:20px; color:white;"></i></a>
								   <?php }?>
								   <?php }?>
                              </td>
                           </tr>
<?php
}
?>
                        </tbody>
				</table>
				<br>
					<div class="row">
						<div class="col-sm-12" align="center">
							<div id="paging">
							</div>
						</div>
					</div>
				<form class="form-inline table-supervisor">
				<div class="form-group ">
					<label for="Date">
								Date :
					</label>
				</div>
				
				<div class="form-group">
					<label for="Date" class="form-control">
								<script> document.write(new Date().toLocaleDateString()); </script>
					</label>
				</div>
				</form>
		</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/fooTable/footable.filter.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready( function () {
          $('#micro-tbl').DataTable();
        });
		$('.filter-status').on('change' , function (){
			$('#tbody').html('');
			$('#tbody').html('<h1><td colspan="10" class="text-center" ><img src="<?php echo base_url(); ?>includes/images/ajax-loader_blue.gif"> loading...</td></h1>');
			var page = $(this).attr("id"); //get page number from link
			$.ajax({
				type: "GET",
				data: $('#filter-form').serialize(),
				dataType: "json",					
				url: "<?php echo base_url(); ?>Ajax_red_rec/superviosry_plan_filter",
				success: function(result){
					console.log(result);
					$('#tbody').html('');
					if(result != null){
						$("#filter").val('');
						$('#tbody').html(result.tbody);
						$('#paging').html(result.paging);
					}
				}
			});
		}); 
</script>
		</body>
</html>