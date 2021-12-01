<!--start of page content or body-->
 <div class="container bodycontainer">
	<div class="row">
		<?php 
			//print_r($htmlData);exit();
			echo $TopInfo;
			echo $htmlData;
		?>			
  </div><!--end of row-->
  </div><!--End of page content or body-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 3});
		// $('.DrillDownRow').css('cursor','pointer');
		// $('.text-red').each(function(){
		// 	var abc = [7,9,11,13,15,17,19,21,23,25,27,29,31,33,35,37,39,41,43,45];
		// 	if(inArray($(this).index(),abc)){
		// 		$(this).addClass('text-center');
		// 		if(parseInt($(this).text()) < 80){
		// 			$(this).css('background-color','red');
		// 		}
		// 	}
		// });
	});
</script>