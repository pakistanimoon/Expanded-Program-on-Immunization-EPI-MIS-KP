<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">RED MAP View</div>
					
				<div class="panel-body" style="padding-top:1px;padding-left: 14%; ">
					<!-- <td> <?php echo base_url();?><?php echo $data[0]['red_map']; ?> </td> -->
					<?php

						//$fileName = $_FILES['file']['name'];
						$fileArray = explode('.', $data[0]['red_map']);
						$fileExt = end($fileArray);
						//print_r($fileExt);
						if ($fileExt=='pdf' || $fileExt=='PDF') { ?>
							<a href="<?php echo base_url();?>uploads/<?php echo $data[0]['red_map']; ?>"><i aria-hidden="true"></i><b> Download RED MAP</b></a>
						<?php }else{ ?>
							<img src="<?php echo base_url();?>uploads/<?php echo $data[0]['red_map']; ?>"height="400" width="800">
					<?php } ?>								
				</div> <!--end of panel body-->
					<div class="row">
						<div class="col-md-10">
							<?php if($this -> session -> UserLevel == '3' ){ ?>
								<a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/Situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
							<?php } else {?>
								<a href="<?php echo base_url();?>Compliance-Filter/HF-Microplan"><button type="button" class="form-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
							<?php } ?>
						</div>
					</div>	
			</div> <!--end of panel panel-primary-->
		</div><!--end of row--> 
	</div><!--End of page content or body-->