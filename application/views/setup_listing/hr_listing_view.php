<?php 
  //Excel file code is here*******************
if($this->input->post('export_excel'))
{
  //if request is from excel
  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=Supervisor_Listing.xls");
  header("Pragma: no-cache");
  header("Expires: 0");
  //Excel Ending here
}
//Excel file code ENDS*******************
?>
 <?php if($TopInfo){echo $TopInfo;}

                     echo $report_table; ?>

<?php  if(!$this->input->post('export_excel')){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(2)").text();
		//alert(code); exit();
        //var distcode = code.substr(0,3);
        //var facode = code.substr(0,6);
        var url = ''; 
        url = "<?php echo base_url();?>Hr_management/hr_view/"+code+"";         
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
<?php }?>