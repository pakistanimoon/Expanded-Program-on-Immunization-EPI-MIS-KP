<?php 
   //Excel file code is here*******************
   if($this->input->post('export_excel'))
   {
      //if request is from excel
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=Pending_Cross_Notified_Cases_Report.xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      //Excel Ending here
   }
   //Excel file code ENDS*******************
?>
<?php 
   //print_r($data);exit();
   if($TopInfo){
      echo $TopInfo;
   }
   echo $report_table; 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 2});
      $('.clickedReport').css('cursor','pointer');
	});
   $('.clickedReport').on('click', function(){
      //var code = $(this).find("td:nth-child(1)").text();
      var code = $(this).data('value');
      var year = <?php echo $data['year']; ?>;
      //alert(year);     
      
      if(code.toString().length == 3){
         url = "<?php echo base_url();?>Cross_notified_cases/Cross_notified_cases_list/"+code+"/"+year;
      }
      var win = window.open(url,'_blank');
      if(win){
         win.focus();
      }
      else{
         //Broswer has blocked it
         alert('Please allow popups for this site');
      }
   });
</script>


