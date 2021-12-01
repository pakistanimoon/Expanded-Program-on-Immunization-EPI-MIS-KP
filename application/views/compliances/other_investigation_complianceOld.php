

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
<script src="<?php echo base_url(); ?>includes/bootstrap/js/bootstrap.min.js"></script>
 <!--fortooltip-->
<script type="text/javascript">
	$(document).ready(function(){
	<?php if(!$this->session->District){ ?>
		$("#fixTable").tableHeadFixer({"left" : 2});
	<?php }else{ ?>
		$("#fixTable").tableHeadFixer({"left" : 3});
	<?php } ?>
		$('.clickedReport').css('cursor','pointer');
		$('.mrClicked').css('cursor','pointer');
		$('.Compliance').css('cursor','pointer');
	});
	<?php if(!$this->input->post('export_excel')){ ?>
		$(document).on('click','.mrClicked', function(){
			var week = $(this).data('month');
			var code = $(this).data('value');
			var year = '<?php echo $year; ?>';
			var url = '';
			if(code.toString().length == 6){
				url = "<?php echo base_url();?>Linelists/Surveillance/"+code+"/"+year+"/"+week;
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
		$(document).on('click','.Compliance', function(){
			var code = $(this).data('value');
			if(code.toString().length == 6){
				url = "<?php echo base_url();?>System_setup/flcf_view?facode="+code;
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
		$(document).on('click','.clickedReport', function(){
			var code = $(this).data('value');
			
			<?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';
			<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
			<?php } ?>	
				
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>Compliances/Other_Compliance/"+code+"/"+year;
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
	<?php } ?>
</script>