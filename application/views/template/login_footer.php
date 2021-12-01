<script src="<?php echo base_url();?>includes/js/bootstrap-tooltip.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
});	
</script>
<!-- Global site tag (gtag.js) - Google Analytics --
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-100961453-2"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'UA-100961453-2', { 'optimize_id': 'GTM-NWKGRLT'});
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