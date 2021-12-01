

<!--start of page content or body-->
 <div class="container bodycontainer">
	<div class="row">
		<?php 
			echo $TopInfo;
			echo $tableData;
		?>			
  </div><!--end of row-->
  </div><!--End of page content or body-->


<!--start of footer-->
<br>
<br>

<!--JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
    $('.clickedReport').css('cursor','pointer');
    $('.mrClicked').css('cursor','pointer');
    $('.Compliance').css('cursor','pointer');
});
<?php   if(!$this->input->post('export_excel'))
          {?>

$(document).on('click','.mrClicked', function(){
 
		alert('here');
       // alert($(this).data('value'));
       

<?php } ?>


</script>
