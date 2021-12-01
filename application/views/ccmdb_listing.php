<!--start of page content or body-->
 <div class="container bodycontainer">
		<?php 
			echo $TopInfo;
			echo $tableData;
		?>			
  </div><!--End of page content or body-->
<!--start of footer-->
<br>
<br>
<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){
		<?php if(!$this->session->District){ ?>
			$("#fixTable").tableHeadFixer({"left" : 2});
		<?php }else{ ?>
			$("#fixTable").tableHeadFixer({"left" : 3});
		<?php } ?>
	});
</script>