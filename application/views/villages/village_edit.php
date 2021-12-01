<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	//print_r($data); exit();
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
    	<div class="panel-heading">Update Village/Mohalla</div>
  	  	<div class="panel-body">
    	   <form name="dataform" id="dataform" action="<?php echo base_url();?>Villages/village_save" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onSubmit="">
				<div class="row">
	    		   <div class="form-group">
	    		   	<input type="hidden" name="added_date" id="added_date" value="<?php echo $current_date; ?>" class="form-control">
					  	<label class="col-xs-2 col-xs-offset-1 control-label">District:</label>
						<div class="col-xs-3">
							 <?php 
								$distcode = $this-> session-> District;
								echo get_District_Name($distcode); 
							?> 
							<input type="hidden" name="distcode" value="<?php echo $distcode; ?>">							
						</div>
						<label class="col-xs-2 control-label">Tehsil:</label>
						<div class="col-xs-3">
							<?php
								$distcode = $this-> session-> District; 
								$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
								$result = $this->db->query($query)->result_array();
							?>
							<select class="form-control" name="tcode" id="ticode" required="required">
								
								<option value="<?php echo $data[0]['tcode']; ?>"><?php echo $data[0]['tehsil']; ?></option>
							
							<!--<?php foreach ($result as $key => $value) { ?>
								<option value="<?php echo $value['tcode'] ?>"><?php echo $value['tehsil'] ?></option>
								<?php } ?>-->
							</select>							
						</div>
  					  
				   </div>
				</div>
				<div class="row">
					<div class="form-group">
							<label class="col-xs-2 col-xs-offset-1 control-label">Union Council:</label>
							<div class="col-xs-3">
								<select name="uncode" id="unicode" required="required" class="form-control">
									<option value="<?php echo $data[0]['uncode']; ?>"><?php echo $data[0]['unioncouncil']; ?></option>
								</select>
							</div>
							<!--<label class="col-xs-2 control-label">Facility:</label>
							<div class="col-xs-3">
								<select name="facode" id="facode" required="required" class="form-control">
									<option value="<?php echo $data[0]['facode']; ?>"><?php echo $data[0]['facility']; ?></option>
								</select>
							</div>-->		
					</div>
				</div>
				<!--<div class="row">
	    		   <div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label">Village/Mohalla Name:</label>
						  	<div class="col-xs-3">
							 	<input required="required" name="village_name" id="village_name" placeholder="Village Name" class="form-control" class="form-control" value="<?php echo $data[0]['village']; ?>">
						  	</div>	
						<label class="col-xs-2  control-label">Village/Mohalla Code:</label>
					  	<div class="col-xs-3">
							<input name="vcode" id="vcode" placeholder="Village Code" class="form-control text-center" readonly="readonly" required="required" value="<?php echo $data[0]['vcode']; ?>" >
					  	</div>
				   </div>
				</div>				
				<div class="row">
					<div class="form-group">
						<label class="col-xs-2 col-xs-offset-1 control-label">Postal Office:</label>
					  	<div class="col-xs-3">
							<input name="postal_address" id="postal_address" placeholder="Postal Address" class="form-control" class="form-control"  value="<?php echo $data[0]['postal_address']; ?>">
					  	</div>
						
					</div>
				</div>-->
				<table id="village_table" class="table footable table-bordered table-hover table-sessiontype" data-filter="#filter" data-filter-text-only="true">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Facility</th>
							<th>Vcode</th>
							<th>Village/Mohalla Name</th>
							<th>Postal Address</th>
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
							<td><input required="required" name="village[]" id="village_name" placeholder="Village Name" class="form-control" class="form-control" value="<?php echo $row['village']; ?>"></td>
							<td><input name="postal_address[]" id="postal_address" placeholder="Postal Address" class="form-control" class="form-control"  value="<?php echo $row['postal_address']; ?>"></td>
						</tr> 	
						 <?php }?>
					</tbody> 
				</table>	
				<input type="hidden" name="edit" value="edit">
				<hr>
				<div class="row">
					<div class="col-xs-7" style="margin-left:78.5%;" >
						<button type="submit" value="1" name="submit" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Save Form </button>
						<a href="<?php echo base_url();?>Village-List" class="btn btn-md btn-success"><i class="fa fa-times"></i> Cancel </a>
					</div>
				</div>
			</form>			
  		</div> <!--end of panel body-->
 	</div> <!--end of panel panel-primary-->
</div><!--end of row-->	
</div><!--End of page content or body contaier-->

<script  type="text/javascript">
	$(window).on('load', function() {
		if($('#tcode :selected').val() == '0'){
			$('#tcode :selected').val('');
		}
	});
	$(document).on('keyup','#population', function(){
		var population = $('#population').val();		
		var population1 =(0.0353*population);
		population1 =Math.ceil(0.942*population1);
		$("#population_less_year").val(population1);
	}); 
	

</script>