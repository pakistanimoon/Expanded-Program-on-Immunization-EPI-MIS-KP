<?php 
//Code by Raja Imran Qamer & Hamza Hashim to generate Main menu from database depending upon loggedin user
createMoonMenu(); 
if($this -> session -> flashdata('accessError')){  ?>
	<div class="alert alert-success text-center" role="alert"><strong><?php echo $this -> session -> flashdata('accessError'); ?></strong></div> <?php 
} ?>

<script type="text/javascript">
$( document ).ready(function() {
	<?php if($this -> session -> UserLevel == '2' || $this -> session -> District == '365'){ ?>
		$('#chid').closest("li").addClass('show');
	<?php }else{ ?>
		$('#chid').closest("li").addClass('hide');
	<?php } ?>
}); 
</script>