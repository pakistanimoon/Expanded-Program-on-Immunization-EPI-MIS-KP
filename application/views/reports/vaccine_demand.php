

<!--start of page content or body kp-->
 <div class="container bodycontainer">
	<div class="row">
		<?php 
			echo $TopInfo;
			echo $htmlData;
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
		$('.DrillDownRow').css('cursor','pointer');
	});
	<?php if(!$this->input->post('export_excel'))
    {?>
	$(document).on('click','.DrillDownRow', function(){
        var code = $(this).find("td:first-child").text();
		var codeLength=code.toString().length;
		var vaccine= "<?php echo $data['product']; ?>";
		var demand_type= "<?php echo $data['indicator']; ?>";
		var monthfrom= "<?php echo $data['monthfrom']; ?>";
		var monthto= "<?php echo $data['monthto']; ?>";
		var typewise= "facility";
        if(codeLength == 3)
        {
			url = "<?php echo base_url();?>Reports/vaccine_demand/"+code+"/"+vaccine+"/"+demand_type+"/"+monthfrom+"/"+monthto+"/"+typewise;
        }

        var win = window.open(url,'_self');
        if(win)
        {
			//Browser has allowed it to be opened
			win.focus();
		}
		else
		{
			//Broswer has blocked it
			alert('Please allow popups for this site');
		}
    });

<?php } ?>


</script>

