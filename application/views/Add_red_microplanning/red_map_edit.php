<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:15px;padding:3px;border-color:white !important;">RED MAP View</div>
					
				<div class="panel-body" style="padding-top:1px; padding-left: 14%;">
					<!-- <td> <?php echo base_url();?><?php echo $data[0]['red_map']; ?> </td> -->
					<?php

						//$fileName = $_FILES['file']['name'];
						$fileArray = explode('.', $data[0]['red_map']);
						$fileExt = end($fileArray);
						//print_r($fileExt);
						if ($fileExt=='pdf' || $fileExt=='PDF') { ?>
							<a href="<?php echo base_url();?>uploads/<?php echo $data[0]['red_map']; ?>"><i aria-hidden="true"></i><b> Download RED MAP</b></a>
						<?php }else{ ?>
							<img src="<?php echo base_url();?>uploads/<?php echo $data[0]['red_map']; ?>" height="400" width="800">
					<?php } ?>
						<form class="dropzone">
						<input type="hidden" value="<?php echo $data[0]['techniciancode']; ?>" name="techniciancode" id="techniciancodeh" class="form-control text-center category">
						<input type="hidden" value="<?php echo $data[0]['year']; ?>" name="year" id="yearh" class="form-control text-center category">
						<div class="dz-default dz-message" style="color: red:">New Upload File</div>
						</form>											
					<div class="row">
						<div class="col-md-10">
							<div style="padding-right: 18px;padding-top: 10px;"><a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a></div>
							<a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_list"><button type="button" class="form-btn"> Update</button></a>						
						</div>
					</div>				
				</div> <!--end of panel body-->	
			</div> <!--end of panel panel-primary-->
		</div><!--end of row--> 
	</div><!--End of page content or body-->

	<script type="text/javascript">
	Dropzone.autoDiscover = false;
   $(".dropzone").dropzone({
	   
	  // var techniciancode =('#techniciancodeh');
	   //alert(techniciancode);
   	url: "<?php echo base_url();?>red_rec_microplan/Situation_analysis/red_map_upload",
   	addRemoveLinks: true,
   // dictRemoveFile: 'Remove',
    maxFiles: 1,
   	//acceptedFiles: ".png, .jpeg,.jpg, .pdf, .JPEG",
        accept: function(file, done) {
            console.log(file);
            if (file.type != "image/jpeg" && file.type != "image/png" && file.type != "application/pdf" && file.type != "image/JPEG") {
                done("Error! Files of this type are not accepted");
            }
            else { done(); }
        }
    });
 </script>