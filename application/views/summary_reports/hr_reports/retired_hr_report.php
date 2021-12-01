
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
        var code = $(this).find("td:eq(0)").text();
		<?php if(isset($data['type_id'])) { ?>
			var type_id='<?php echo $data['type_id']; ?>';
		<?php } ?>	
		//alert(code); exit();
		var url = ''; 
		if(code.toString().length == 3 ){
			url =  "<?php echo base_url();?>HR_Reports/Retired_HR_Report/"+code+"/"+type_id;
		}
        if(code.toString().length == 9){
			url = "<?php echo base_url();?>Hr_management/hr_view/"+code+"";   
		}      
        var win = window.open(url,'_self');
       if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
  </script>