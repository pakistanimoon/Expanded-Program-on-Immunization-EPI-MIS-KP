<?php 
   //Excel file code is here*******************
   if($this->input->post('export_excel'))
   {
      //if request is from excel
      header("Content-type: application/octet-stream");
      header("Content-Disposition: attachment; filename=Sanctioned_Posts_Report.xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      //Excel Ending here
   }
   //Excel file code ENDS*******************
?>
<?php 
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
	});
</script>


