<?php 
  //Excel file code is here*******************
if($this->input->post('export_excel'))
{
  //if request is from excel
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=Summary_Listing.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  //Excel Ending here
}
//Excel file code ENDS*******************
?>


    	   	   <?php if($TopInfo){echo $TopInfo;}

                     echo $report_table; ?>

<?php  if(!$this->input->post('export_excel')){ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(1)").text();
        var distcode = code.substr(0,3);
		var year= "<?php echo $_REQUEST['year']; ?>" ;
		//alert(year);
        var status = "<?php echo $_REQUEST['status']; ?>" ;
		var sup_type= "<?php echo $_REQUEST['sup_type']; ?>" ;
        var listing_name='<?php echo str_replace(" ","_",$_REQUEST["listing"]); ?>';
		if(listing_name=='Health_Facility')
          listing_name='EPI_Centers';  
		//alert(listing_name);	  
        var url = '';
        url = "<?php echo base_url();?>setup_listing/"+listing_name+"_listing?distcode="+distcode+"&status="+status+"&year="+year+"&sup_type="+sup_type;       
//alert(url);exit;       
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
<?php } ?>