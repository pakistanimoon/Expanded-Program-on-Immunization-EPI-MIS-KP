<script src="<?php echo base_url();?>includes/js/bootstrap-tooltip.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
});	
</script>
<!-- Javascript -->
<footer class="main-footer">
	<!-- To the right -->
	<div class="pull-right hidden-xs">
	  <!-- Anything you want -->
	</div>
	<!-- Default to the left -->
	<strong>Copyright &copy; all rights reserved. Department of Health, <?php echo $this -> session -> provincename; ?>.</strong>
</footer>