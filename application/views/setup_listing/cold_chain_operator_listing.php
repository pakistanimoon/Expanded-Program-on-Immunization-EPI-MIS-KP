<?php if($TopInfo){echo $TopInfo;}

                     echo $report_table; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript">

    $('.DrillDownRow').css('cursor','pointer');
        $(document).on('click',".DrillDownRow", function(){
          var code = $(this).find("td:eq(1)").text();
          var distcode = code.substr(0,3);
          //var tcode = code.substr(0,6);
          var url = '';
          if(code.toString().length == 5){
            url = "<?php echo base_url();?>system_setup/cco_view/"+code+"/view";    
            var win = window.open(url,'_self');
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

