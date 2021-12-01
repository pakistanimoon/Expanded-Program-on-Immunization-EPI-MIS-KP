<!-- <div id="zone">
	<form action="<?php echo base_url();?>red_rec_microplan/Situation_analysis/red_map_upload" class="dropzone"></form>
	
</div> -->
<div class="row" style=" margin-left: 7%;">
<form class="dropzone">
<input type="hidden" value="<?php echo $data['data'][0]['techniciancode']; ?>" name="techniciancode" id="techniciancodeh" class="form-control text-center category">
<input type="hidden" value="<?php echo $data['data'][0]['year']; ?>" name="year" id="yearh" class="form-control text-center category">
<div class="dz-default dz-message">Drag and Drop Here for upload</div>
</form>
</div>
<div class="row">
    <div style="padding-right: 138px;padding-top: 10px;">
      <!-- <a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_list">
      <button type="button" class="form-btn"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button></a> -->
      <a href="<?php echo base_url();?>red_rec_microplan/Situation_analysis/situation_analysis_list">
      <button type="button" class="form-btn"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i> Save</button></a>
      
  </div>
</div>


<!-- <script type='text/javascript'>
Dropzone.autoDiscover = false;
$(".dropzone").dropzone({
	
url: "<?php echo base_url();?>red_rec_microplan/Situation_analysis/red_map_upload",
addRemoveLinks: true,
success: function (file, response) {
var imgName = response;
file.previewElement.classList.add("dz-success");
},
error: function (file, response) {
file.previewElement.classList.add("dz-error");
}
});

</script> -->
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
	


