<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>includes/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>includes/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>includes/dist/js/app.js"></script>

<script src="<?php echo base_url(); ?>includes/js/moment.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>includes/js/tableHeadFixer.js"></script>
<script src="<?php echo base_url(); ?>includes/js/dropzone.js"></script>
<!--<script src="<?php echo base_url(); ?>includes/js/bootstrap-tooltip.js"></script>-->
<script type="text/javascript">
	/*      		--------- Code by Uzair Khalid ----------      */
	$(document).bind("ajaxSend", function() {
		$('.loading').removeClass('hide');
	}).bind("ajaxComplete", function() {
		$('.loading').addClass('hide');
	});
	/*      		--------- Code by Uzair Khalid ----------      */
	/* 
					--------- Code by Uzair Khalid ---------- 
		***( -- generic code for menu bar. Just add two classes -- )***
		anchor-uk --> for all anchor tags which have href attribute other that # or empty
		parent-uk --> for all parent li's which are involved in multi-level menu.
		then paste the code below in a script file which runs/execute in whole system
	*/
	$(function () {
		$('.dpwt').datetimepicker({
			format : 'yyyy-mm-dd hh:ii:ss',
			startView : 3,
			viewDate: new Date(),
			endDate : new Date(),
			todayHighlight : true,
			todayBtn : true
		});
	});
	$(function() {
		var pgurl = window.location.href.substr(window.location.href);
		$(".anchor-uk").each(function(i){
			var url = $(this).attr("href").substr($(this).attr("href"));
			if(url == pgurl){
				$(this).parents('li[class^="parent-uk"]').addClass('active');
			}
		});
	});
	/*      		--------- Code by Uzair Khalid ----------      */
	function blinker() {
		$('.blinking').fadeOut(500);
		$('.blinking').fadeIn(500);
	}
	setInterval(blinker, 1000);
	
	//$.widget.bridge('uibutton', $.ui.button);
	$(document).ready(function(){
		$(document).ready(function() {
		  $('.managehr').addClass('active');
		});
		
		$("#fixTable").tableHeadFixer(); 
		$(".numberclass").keydown(function(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || // Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
				$(this).val('0');
				$(this).select();
			}
		});
		$(document).on("click",".dp",function(e) {
			var options = {
			  format : "dd-mm-yyyy",
			  color: "green"
			};
			$('.dp').datepicker(options);
		});
		$(document).on("keydown",".numberclass",function(e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || // Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
				$(this).val('0');
				$(this).select();
			}
		});
		<?php if(!isset($edit)){ ?>
		if($("#distcode").length == 0) {
		  //it doesn't exist
		}else{
			$('#distcode').trigger("change");
		}
		if($("#tcode").length == 0) {
		  //it doesn't exist
		}else{
			$('#tcode').trigger("change");
		}
		set_hfcode();
		<?php } ?>
	});
	function set_hfcode()
	{
		//check if hfcode field exist or not if exist show selected facility code there
		if($("#hfcode").length == 0) {
		  //it doesn't exist
		}else{
			$("#hfcode").val($("#facode").val());
		}
		//
		if( typeof selectedfacode !== 'undefined' && selectedfacode>0)
		{
			$('#facode option[value="' + selectedfacode + '"]').prop('selected', true);
			selectedfacode = 0;
		}
	}
	$(window).scroll(function () {  
	  
	if ($(window).scrollTop() > 280) {
	  $('#nav_bar').addClass('navbar-fixed');
	}
	if ($(window).scrollTop() < 281) {
	  $('#nav_bar').removeClass('navbar-fixed');
	}
  });
	/*$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});*/
	$(document).ready(function(){
	  $('#changePass-trigger').click(function(){
		$(this).next('#changePass-content').slideToggle();
		$(this).toggleClass('active');          
		
		if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
		  else $(this).find('span').html('&#x25BC;')
		})
	});
	function updatePassword(){
		var opassword=document.getElementById("oldpassword").value;
		var newpassword=document.getElementById("newpassword").value;
		var confirmpassword=document.getElementById("repeatnewpassword").value;
		var username=document.getElementById("username").value;
		if(newpassword==confirmpassword){
			if(newpassword.toString().length >= 6 && newpassword.toString().length < 25){
				if (opassword.toString().length >= 6 && opassword.toString().length < 25) 
				{
					$.ajax({
						type: 'GET',
						url:'<?php echo base_url(); ?>Ajax_calls/change_password',
						data:'username='+username+'&oldpassword='+opassword+'&newpassword='+newpassword+'&repeatnewpassword='+confirmpassword,
						success: function(response){
							if (response=="Password Updated!") {	
								document.getElementById('oldpassword').value="";
								document.getElementById('newpassword').value="";
								document.getElementById('repeatnewpassword').value="";
								document.getElementById('txtCpwd').innerHTML="";
								$('#txtHint').html(response);
								$('#error').html("");
							}else
							{
								document.getElementById('txtCpwd').innerHTML="";
								$('#txtHint').html(response);
								$('#error').html("");
							}
						}
					});	
				} else
				{
					$('#txtHint').html("Enter correct password!");
				}
			}
			else{
				$('#error').html("Please Enter between 6-25 characters/numbers!");
				$('#txtHint').html("");
			}
		}else{
			$('#error').html("New Password and Confirm Password Doesn't Match!");
			$('#txtHint').html("");
		}
	}
	function validateConfirmPassword()
	{
		var pwd=document.getElementById("newpassword").value;
		var cpwd=document.getElementById("repeatnewpassword").value;
		if(pwd==cpwd)
		{
			$('#error').html("");
			document.getElementById('txtHint').innerHTML="Password Match!";
		}
		else
		{
			document.getElementById('txtHint').innerHTML="";
		}
	}
	/*$('#facode').on('change', function(){
		var facode = $('#facode').val();
			$.ajax({
				type: "POST",
				data: "facode="+facode,
				url: "<?php echo base_url(); ?>Ajax_calls/getIncharge",
				success: function(result){
					 var data = jQuery.parseJSON(result);
					$('#facility_incharge').val(data.incharge);
				}
			});
	}); */
	$(document).on('change','#distcode', function(){
		var distcode = $('#distcode').val();
		//to get tehsils of selected distcrict
		if($("#tcode").length == 0) {
		  //it doesn't exist
		}else{
			$.ajax({
				type: "POST",
				data: "distcode="+distcode,
				url: "<?php echo base_url(); ?>Ajax_calls/getTehsils",
				success: function(result){
					$('#tcode').html(result);
					$('#tcode').trigger('change');
				}
			});
		}
							
	});
	$(document).on('change','#tcode', function(){
		var tcode = this.value;
		$('#facode').html('');
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getUnC/"+tcode,
				success: function(result){
					$('#uncode').html(result);							
					//
					if( typeof selecteduncode !== 'undefined' && selecteduncode>0)
					{
						$('#uncode option[value="' + selecteduncode + '"]').prop('selected', true);
					}
					$('#uncode').trigger('change');
				}
			});
		}else{
			$('#uncode').html('');
			$('#facode').html('');
			//it doesn't exist
		}
						
	});
	$(document).on('change','#uncode', function(){
		var uncode = this.value;
		var module = $('#module').val();
		if (typeof module === "undefined"){
				//to get facilities of selected UC
			if(uncode =="") {
				$('#facode').html('');
				//it doesn't exist
			}else{
				$.ajax({
					type: "POST",
					data: "uncode="+uncode,
					url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
					success: function(result){
						$('#facode').html(result);
						set_hfcode();
					}
				});
				
			} 
			
		}else{
				//to get facilities of selected UC
			if(uncode =="") {
				  $('#facode').html('');
				  //it doesn't exist
			}else{
					$.ajax({
						type: "POST",
						data: "uncode="+uncode+"&module="+module,
						url: "<?php echo base_url(); ?>Ajax_calls/getFacilities",
						success: function(result){
							$('#facode').html(result);
							set_hfcode();
						}
					});
					$("#patient_address_uncode option[value="+uncode+"]").prop("selected",true);
				}
		}
	
	});
	$(document).on('change','#facode', function(){
		set_hfcode();
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
		<?php if($this->uri->segment(3)=="Coverage-and-Consumption"){ ?>
			$.ajax({
				type: 'POST',
				data: $data1+"&year="+year,
				url: "<?php echo base_url(); ?>Ajax_calls/<?php echo (isset($includeCurrentMonth))?"getMonthswithCurrent":"getMonths_aug2020"; ?>",
				success: function(response){
					$('#month').html(response);
				}
			});
		<?php }else{?>
		$.ajax({
			type: "POST",
			data: $data1,
			url: "<?php echo base_url(); ?>Ajax_calls/<?php echo (isset($includeCurrentMonth))?"getMonthswithCurrent":"getMonths"; ?>",
			success: function(result){
				$('#month').html(result);
			}
		});
		<?php }?>
	});
	$(function () {
		var options = {
		  format : "dd-mm-yyyy",
		  startDate : "01-01-1925",
		  endDate: "12-12-2000"

		};
	   
		$('#date_of_birth').datepicker(options);
		var options = {
		  format : "dd-mm-yyyy",
			color: "green"
		};
		$('.dp').datepicker(options);
		
	});

</script>
<!--
<script data-jsd-embedded data-key="0715c6e8-19d4-4067-a43e-773616d48962" data-base-url="https://jsd-widget.atlassian.com" src="https://jsd-widget.atlassian.com/assets/embed.js"></script>-->
<!-- Javascript Ends -->