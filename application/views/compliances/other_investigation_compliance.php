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
			var win = window.open(url,'_self');
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
			var win = window.open(url,'_self');
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
			var case_type = '<?php echo $data['case_type']; ?>';
		
			<?php if(isset($data['year'])) { ?>
				var year='<?php echo $data['year']; ?>';
			<?php }else{ ?>
				var year='<?php echo date('Y'); ?>';
			<?php } ?>	
				
			<?php if(isset($data['from_week'])) { ?>
				var from_week='<?php echo $data['from_week']; ?>';
			<?php } ?>
			<?php if(isset($data['to_week'])) { ?>
				var to_week='<?php echo $data['to_week']; ?>';
			<?php } ?>
			
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>Compliances/Other_Compliance/"+code+"/"+year+"/"+case_type+"/"+from_week+"/"+to_week;
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
	<?php } ?>
</script>