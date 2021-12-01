<?php if($TopInfo){echo $TopInfo;}

                     echo $report_table; ?>

<?php  if(!$this->input->post('export_excel')){ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>includes/js/bootstrap-3.1.1.min.js"></script>
<script type="text/javascript">
  $('.DrillDownRow').css('cursor','pointer');
    $(document).on('click',".DrillDownRow", function(){
        var code = $(this).find("td:eq(2)").text();
        var distcode = code.substr(0,3);
        var tcode = '<?php echo $_REQUEST["tcode"] ?>';
        var url = '';
        url = "<?php echo base_url();?>setup_listing/technician_listing?distcode="+distcode+"&tcode="+tcode+"&facode="+code;       
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
