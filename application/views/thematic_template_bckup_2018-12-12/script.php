    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
    <script src="<?php echo base_url();?>includes/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url();?>includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>includes/js/kitUtils.js"></script>
    <script src="<?php echo base_url();?>includes/js/jquery.flypanels.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.3/fastclick.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/maps/modules/map.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="<?php echo base_url(); ?>includes/js/jquery.simplePopup.js"></script>
	
<!--     <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/maps/modules/map.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/heatmap.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="<?php echo base_url(); ?>includes/js/jquery.simplePopup.js"></script> -->
    
    
    
<script type="text/javascript">
	$(document).ready(function(){
		$('.flypanels-container').flyPanels({
			treeMenu: {
				init: true
			},
		});
		FastClick.attach(document.body);
	});
    


  
    $(function () {
        /* START OF DEMO JS - NOT NEEDED */
        if (window.location == window.parent.location) {
            $('#fullscreen').html('<span class="glyphicon glyphicon-resize-small"></span>');
            $('#fullscreen').attr('href', 'http://bootsnipp.com/mouse0270/snippets/PbDb5');
            $('#fullscreen').attr('title', 'Back To Bootsnipp');
        }    
        $('#fullscreen').on('click', function(event) {
            event.preventDefault();
            window.parent.location =  $('#fullscreen').attr('href');
        });
        $('#fullscreen').tooltip();
        /* END DEMO OF JS */
        
        $('.navbar-toggler').on('click', function(event) {
        event.preventDefault();
        $(this).closest('.navbar-minimal').toggleClass('open');
        })
    });
  
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }

    function openNavR() {
        document.getElementById("mySidenavR").style.width = "250px";
    }

    function closeNavR() {
        document.getElementById("mySidenavR").style.width = "0";
    } 
  
  
    $(function () {
        if (window.location == window.parent.location) {
            $('#fullscreen').html('<span class="glyphicon glyphicon-resize-small"></span>');
            $('#fullscreen').attr('href', 'http://bootsnipp.com/mouse0270/snippets/PbDb5');
            $('#fullscreen').attr('title', 'Back To Bootsnipp');
        }    
        $('#fullscreen').on('click', function(event) {
            event.preventDefault();
            window.parent.location =  $('#fullscreen').attr('href');
        });
        $('#fullscreen').tooltip();
        $("#questionmark_id").click(function() { 
            $("#text_div").slideToggle(); 
            $(".notificationmessage").removeClass('hide'); 
        });

        $(".notificationmessage").click(function() { 
            $(".notificationmessage").addClass('fade'); 
        });
    });
  
    $(document).on('change','#year', function(){
        var year = this.value;
        var curryear = (new Date).getFullYear();
        if(year < curryear)
        {
            $data1 = "month=13";
        }else{
            $data1 = "";
        }
        $.ajax({
            type: "POST",
            data: $data1,
            url: "<?php echo base_url();?>Ajax_calls/getMonths",
            success: function(result){
                $('#month').html(result);
            }
        });
    });
  
  </script>