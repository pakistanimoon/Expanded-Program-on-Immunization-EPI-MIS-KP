<?php echo $TopInfo;
	  echo $report_table; 
	  
if(!$this->input->post('export_excel')){?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var username = $(this).find("td:first-child").text();
		//alert(username);
        var url = '';
       url = "<?php echo base_url();?>User_management/user_activities/"+username;         
        var win = window.open(url,'_blank');
       if(win){
          //Browser has allowed it to be opened
          win.focus();
        }else{
          //Broswer has blocked it
          alert('Please allow popups for this site');
        }
      });
	  $(".handland").attr("onclick","window.history.go(-1); return false;");
  </script>
<?php }?>