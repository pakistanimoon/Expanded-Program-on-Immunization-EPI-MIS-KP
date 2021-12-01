
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
		//alert(code);
      <?php if(isset($data['hr_type'])) { ?>
			var hr_type='<?php echo $data['hr_type']; ?>';
			//alert(hr_type);
		<?php } ?>
        //alert(code);
		// if(code.toString().length > 6){
		// 	url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
		// }
		if(code.toString().length == 3){
			url =  "<?php echo base_url();?>Reports/Retired_HR_Report/"+code+"/"+hr_type;
		}
		if(code.toString().length > 3 && hr_type == 'supervisor'){
			url =  "<?php echo base_url();?>System_setup/supervisor_view/"+code+"/view";
		}
		if(code.toString().length > 3 && hr_type == 'dso'){
			url =  "<?php echo base_url();?>DSO/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'co'){
			url =  "<?php echo base_url();?>Computer-Operator/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'med_technician'){
			//url =  "<?php echo base_url();?>Medical-Technician/View/"+code;
			url =  "<?php echo base_url();?>HF-Incharge/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'technician'){
			url =  "<?php echo base_url();?>Technician/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'driver'){
			url =  "<?php echo base_url();?>Driver/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'deo'){
			url =  "<?php echo base_url();?>DataEntry-Operator/View/"+code;
		}
		if(code.toString().length > 3 && hr_type == 'sk'){
			url =  "<?php echo base_url();?>system_setup/skdb_view/"+code;
		}
		// if(code.toString().length == 3 && hr_type == 'supervisor'){
		// 	url =  "<?php echo base_url();?>setup_listing/supervisor_listing?distcode="+code+"&status=&sup_type=";
		// }
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