<?php 
if($TopInfo!=''){
    echo $TopInfo;
}
echo $htmlData; 

if(!$this->input->post('export_excel'))
{
?>
	<script type="text/javascript">
		$('.DrillDownRow').css('cursor','pointer');//do it later and ll change as clickedReport
		$(document).on('click',".DrillDownRow", function(){	
			var code = $(this).find("td:first-child").text();
			var distcode = code.substr(0,3);
			var month = '<?php echo $month;?>';
			var url = '';
			var report_source_table='<?php echo $report_source_table; ?>';
			if(code.toString().length == 3){
				url = "<?php echo base_url();?>Analytical_reports/indicator_report?distcode="+distcode+"&facode="+code+"&report_year="+<?php echo $year; ?>+"&report_month="+month+"&report_source="+report_source_table+"&indicator="+<?php echo $_REQUEST['indicator']; ?>+"&level="+<?php echo "'"."facility"."'"; ?>;    
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}
			if(code.toString().length == 6 && report_source_table == 'flcfmr'){
				url = "<?php echo base_url();?>analytical_reports/print_report_view?distcode="+distcode+"&facode="+code+"&fromyear="+<?php echo $year ;?>+"&frommonth="+month+"&toyear="+<?php echo $year ;?>+"&tomonth="+month+"&report_source="+report_source_table;
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}
			if(code.toString().length == 6 && report_source_table == 'lhwmr'){
				url = "<?php echo base_url();?>Analytical_reports/indicator_report?distcode="+distcode+"&facode="+code+"&report_year="+<?php echo $year; ?>+"&report_month="+month+"&report_source="+report_source_table+"&indicator="+<?php echo $_REQUEST['indicator']; ?>+"&level="+<?php echo "'"."lhw"."'"; ?>;    
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}
			if(code.toString().length == 9 && report_source_table == 'lhwmr'){
				var facode = code.substr(0,6);
				url = "<?php echo base_url();?>Analytical_reports/print_report_view?distcode="+distcode+"&facode="+facode+"&lhwcode="+code+"&fromyear="+month+"&toyear="+<?php echo $year; ?>+"&tomonth="+month+"&report_source="+report_source_table+"&report_page=print_report";
				var win = window.open(url,'_blank');
				if(win){
					//Browser has allowed it to be opened
					win.focus();
				}else{
					//Broswer has blocked it
					alert('Please allow popups for this site');
				}
			}
			else{
				url = "";
			}
		});
	</script>
<?php } ?>