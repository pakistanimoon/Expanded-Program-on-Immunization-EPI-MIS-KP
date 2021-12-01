<?php $utype=$this -> session -> utype;
 ?>
<section class="content">
<br>
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading text-center">Outbreak Response List Report</div>
				<div class="panel-body">
					<form method="post" name="theForm" target="_blank" id="filter-form" class="form-horizontal form-bordered" action="<?php echo base_url(); ?>Outbreak-Report">
					<div class="row ">
						<div class="form-group">
							<label for="distcode" class="col-xs-3 col-xs-offset-1 control-label" id="distcode-label">District
							</label>
							<div class="col-xs-7">
								<?php //if($this -> session -> UserLevel == '2' && $utype == 'Manager'){?>
								<select name="distcode" id="distcode" class="form-control">

									<?php
									if($this -> session -> UserLevel == '2' && $utype == 'Manager'){
										echo '<option value="0">--ALL--</option>';
										echo getDistricts();
									}else{
										echo getDistricts($distcode=$this -> session -> District);		
									}									
									?>
								</select>
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="tcode" class="col-xs-3 col-xs-offset-1 control-label" id="tcode-label">Tehsil</label>
							<div class="col-xs-7">
							<select name="tcode" id="tcode" class="form-control">								
							</select>
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="uncode" class="col-xs-3 col-xs-offset-1 control-label" id="uncode-label">Union Council</label>
							<div class="col-xs-7">
								<select name="uncode" id="uncode" class="form-control">
									<option value="0">--Select Union Council--</option>		
								</select>
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="facode" class="col-xs-3 col-xs-offset-1 control-label" id="facode-label">Village</label>
							<div class="col-xs-7">
								<select name="vcode" id="vcode" class="form-control">									
								</select>
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group">
							<label for="monthfrom" class="col-xs-3 col-xs-offset-1 control-label" id="monthfrom-label">Date of Activity From</label>
							<div class="col-xs-7"><input type="text" name="date_of_activity" value="" id="date_of_activity_from" class="form-control dp"  data-date-end-date="-1m">
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Date of Activity To</label>
							<div class="col-xs-7"><input type="text" name="date_of_activity_to" value="" id="date_of_activity_to" class="form-control dp" data-date-end-date="-1m">
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Age Froup From</label>
							<div class="col-xs-7"><input type="number" min="1" name="age_group_from" value="" id="age_group_from" class="form-control dp-my"  data-date-end-date="-1m">
							</div>  					
						</div>
					</div>
					<div class="row ">
						<div class="form-group"><label for="monthto" class="col-xs-3 col-xs-offset-1 control-label" id="monthto-label">Age Group To</label>
							<div class="col-xs-7"><input type="number" name="age_group_to" min="1" value="" id="age_group_to" class="form-control dp-my"  data-date-end-date="-1m">
							</div>  					
						</div>
					</div><hr>
					<div class="row">
						<div class="col-xs-3" style="margin-left: 71%;">
						<button type="submit" name="submit" id="pre-btnn" class="task task__content btn btn-md btn-success" ><i class="fa fa-search"></i> Preview </button>
						<!-- 	<div class="col-xs-6" style="margin-left: 73%;">
								<nav id="context-menu" class="context-menu">
									<ul class="context-menu__items">
										<li class="context-menu__item">
											<button type="submit" name="submit2" class="context-menu__link" data-action="View" value="1">Open in New Tab</button>
											<button type="submit" name="submit3" class="context-menu__link" data-action="Edit" value="2">Open in Same Tab</button>
										</li>
									</ul>
								</nav>
							</div> -->
						</div>
					</div><br>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

		$(document).ready(function(){
			var options = {
	    	format : "yyyy-mm-dd",
	    	todayHighlight: true,
	    	autoclose: true
   	};
   	$('.dp').datepicker(options);
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
function fromDate(start_date_id, end_date_id){
  	var from_date = $('#'+start_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
    var to_date = $("#"+end_date_id).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
    $("#"+end_date_id).datepicker('setStartDate', from_date);
    $("#"+end_date_id).datepicker('setEndDate', '+2y');
    if(to_date < from_date){
      $("#"+end_date_id).val('');
    }
  }
function toDate(start_date_id, end_date_id){
    $('#'+start_date_id).datepicker('setStartDate', "1925-01-01");
    $('#'+start_date_id).datepicker('setEndDate', '+0d');
  }
  function setNewDate(start_date_id){
	  $('#'+start_date_id).datepicker('setEndDate', '+0d');
  }
  $("#date_of_activity_from").on( "click", function() {
        setNewDate('date_of_activity_from');
      });
     $("#date_of_activity_from").on( "change", function() {
        fromDate('date_of_activity_from', 'date_of_activity_to');
      });
    $("#date_of_activity_to").on( "change", function() {
        toDate('date_of_activity_from', 'date_of_activity_to');
      });
    //=================================================


    	$(document).on('change','#uncode', function(){
		var uncode = this.value;
		//to get ucs of selected distcrict
		if(uncode != 0) {
		  $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Ajax_calls/getVillages/"+uncode,
				success: function(result){
					$('#vcode').html(result);							
					//
					if( typeof selectedvcode !== 'undefined' && selectedvcode>0)
					{
						$('#vcode option[value="' + selectedvcode + '"]').prop('selected', true);
					}
					$('#vcode').trigger('change');
				}
			});
		}else{
			$('#vcode').html('');
			//it doesn't exist
		}
						
	});
});
      </script>