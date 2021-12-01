<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	?>
<div class="container bodycontainer">
	<div class="row">
	<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
	  <div class="panel panel-primary">
	    <ol class="breadcrumb">
	    	<ul class="breadcrumb">
				<li><a href="<?php echo base_url(); ?>">Home</a><span class="divider"></span></li>
				<li class="active"></li>
			</ul>
	    </ol> 
    	<div class="panel-heading">Village/Mohalla Delete</div>
  	  	<div class="panel-body">
    	  		<div class="row">
	    		   <div class="form-group">
	    		   	<input type="hidden" name="added_date" id="added_date" value="<?php echo $current_date; ?>" class="form-control">
					  	<label class="col-xs-2 col-xs-offset-1 control-label">District:</label>
						<div class="col-xs-3">
							 <?php 
								$distcode = $this-> session-> District;
								echo get_District_Name($distcode); 
							?> 
														
						</div>
						<label class="col-xs-2 control-label">Tehsil:</label>
						<div class="col-xs-3">
							<?php
								$distcode = $this-> session-> District; 
								$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
								$result = $this->db->query($query)->result_array();
							?>
							<?php echo $data[0]['tehsil']; ?>										
						</div>  					  
				   </div>
				</div>
				<div class="row">
					<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label">Union Council:</label>
							<div class="col-xs-3">
								<?php echo $data[0]['unioncouncil']; ?>
							</div>				
					</div>
				</div>
				<table id="village_table" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Facility</th>
							<th>Vcode</th>
							<th>Village/Mohalla Name</th>
							<th>Postal Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=0;
							foreach($data as $row){ 
							$i++;?>
						<tr> 
							<input type="hidden" name="vcode[]" value="<?php echo $row['vcode']; ?>" >
							<td><?php echo $i; ?></td>
							<td><?php echo $row['facility'];?></td>
							<td><?php echo $row['vcode'];?></td>
							<td><?php echo $row['village'];?></td>
							<td><?php echo $row['postal_address'];?></td>
							<td><a  href="<?php echo base_url(); ?>Villages/deleted_villages/<?php echo $row['vcode']?>" data-toggle="tooltip""  title="Village Delete" class="btn btn-xs btn-default" onclick="return confirm('Are you sure?')"><i class="fa fa-times"></i></a></td>
						</tr> 	
						 <?php }?>
					</tbody> 
				</table>
				<hr>
				<div class="row">
					<div class="col-xs-7 " style="margin-left:88.5%;" >
						<a href=" <?php echo base_url();?>Village-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
				</div>					
  		</div> <!--end of panel body-->
 	</div> <!--end of panel panel-primary-->
</div><!--end of row-->	
</div><!--End of page content or body contaier-->

