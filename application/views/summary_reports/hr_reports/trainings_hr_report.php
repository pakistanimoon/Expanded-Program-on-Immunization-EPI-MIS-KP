
<!--start of page content or body-->
<div class="container bodycontainer">
	<?php 
		echo $TopInfo;
		echo $htmlData;
	?>			
</div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(1)").text();
        var trainingtypes = $(this).find("td:eq(0)").text();
		//alert(trainingtypes); exit();
		var url = ''; 
		if(code.toString().length == 3 ){
			url =  "<?php echo base_url();?>HR_Reports/Trainings_HR_Report_Detail/"+code+"/"+trainingtypes+"";
		}
		if(trainingtypes.toString().length == 3 ){
			url =  "<?php echo base_url();?>HR_Reports/Trainings_HR_Report_Detail/"+trainingtypes+"";
		}
        var win = window.open(url,'_blank');
       if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
  </script>