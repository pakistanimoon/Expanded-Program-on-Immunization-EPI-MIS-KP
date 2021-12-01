<?php if($TopInfo!=''){echo $TopInfo;}
		echo $htmlData; ?>

<?php if(!$this->input->post('export_excel'))
{?>
	<script type="text/javascript" >
		$(document).ready(function(){
			$('.clickedReport').css('cursor','pointer');
			$('.DrillDownRow').css('cursor','pointer');
		});
		$('.clickedReport').on('click', function(){

			var code = $(this).data('value');
			
			if(code.toString().length == 9){

				var lhwcode=code;
			
				var url = '';
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+lhwcode;
						var win = window.open(url,'_self');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}

			if(code.toString().length == 7){

				var driver=code;
				
				var url = '';
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+driver;
						var win = window.open(url,'_self');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}

			if(code.toString().length == 8){

				var lhs=code;
				
				var url = '';
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+lhs;
						var win = window.open(url,'_self');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}

				if(code.toString().length == 5){

				var as=code;
				
				var url = '';
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+as;
						var win = window.open(url,'_self');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}


		
			
	
		});

		$('.DrillDownRow').on('click', function(){

			var code = $(this).find("td:first-child").text();
			
			
				var distcode=code;
				var reportType= "<?php echo $_REQUEST['reportType'] ;?>";
				var fmonth= "<?php echo $_REQUEST['year']; ?>";
				var url = '';
				url = "<?php echo base_url();?>setup_listing/payroll_report_view?distcode="+distcode+"&reportType="+reportType+"&year="+fmonth;
						var win = window.open(url,'_self');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			

		
			
	
		});
		/* $('.tickClicked').on('click', function(){
			var code = $(this).data('value');
			var month = $(this).data('month');
			var fmonth = '<?php echo $year; ?>-'+month;
			var distCode = '<?php echo isset($_REQUEST['distcode'])?$_REQUEST['distcode']:$_SESSION['District']; ?>';
			var url = '';
			if(code.toString().length == 7){
				//driver payroll
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+distCode+"/"+code+"/"+fmonth;
			}
			if(code.toString().length == 8){
				//lhs payroll
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+distCode+"/"+code+"/"+fmonth;
			}
			if(code.toString().length == 9){
				//lhw payroll
				url = "<?php echo base_url();?>setup_listing/payroll_report_detail/"+distCode+"/"+code+"/"+fmonth;
			}
			var win = window.open(url,'_self');
			if(win){
				//Browser has allowed it to be opened
				win.focus();
			}else{
				//Broswer has blocked it
				alert('Please allow popups for this site');
			}
        }); */
    </script>
<?php } ?>