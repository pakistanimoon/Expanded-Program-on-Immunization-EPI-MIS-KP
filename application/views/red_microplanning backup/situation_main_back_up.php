<?php 
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
?>
<!-- <div class="content-wrapper"> -->
<section class="content">			
	<div class="container">
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-heading" style="font-size:15px;">
					RED/REC Microplanning <span class="urdu" style="font-size:12px; font-weight:400;"></span>
				</div>
				<!-- <div class="container"><h1>Hadding </h1></div> -->

				<div id="exTab1" class="container">	
					<ul  class="nav nav-pills" id="#createNotTab li">
						<li class="active">
			        	<a  href="#1a" id="a" data-toggle="tab" >Situation Analysis</a>
						</li>
						<li id="" class=""><a href="#2a" id="b" data-toggle="tab" >Planning Problem Areas</a>
						</li>
						<li><a href="#3a" id="c" data-toggle="tab" >Session Plan Template</a>
						</li>
						<li><a href="#4a" id="d" data-toggle="tab">Facility Workplan</a>
						</li>
			  			<!--<li><a href="#5a" id="e" data-toggle="tab">Supervisory Micro Plan</a>
						</li>-->
					</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
         $(document).ready(function() {
    /*disable non active tabs*/
    $('.nav li').not('.active').addClass('disabled');
    /*to actually disable clicking the bootstrap tab, as noticed in comments by user3067524*/
    $('.nav li').not('.active').find('a').removeAttr("data-toggle");

    $('ko').click(function(){
        /*enable next tab*/
        $('.nav li.active').next('li').removeClass('disabled');
        $('.nav li.active').next('li').find('a').attr("data-toggle","tab")
    });
});

	$('#a').on('click', function () {
		$.ajax({
			url: "<?php echo base_url(); ?>Ajax_red_rec/situation_analysis_add",
			success: function(result){
				$('#1a').html(result);				
			}
			
		});		
	});
	$('#a').trigger( "click" );
	$('#b').on('click', function (e, x) {
		var obj = JSON.parse(x,true);
	    var facode =obj[0]['facode'];     
		var year =obj[0]['year'];
        var recid = obj[0]['recid'];
      alert(recid);		
		 if (recid > 0)
		{
            $('.nav li.active').next('li').removeClass('disabled');
            $('.nav li.active').next('li').find('a').attr("data-toggle","tab")



                $.ajax({
				url: "<?php echo base_url(); ?>Ajax_red_rec/special_activities_add/"+facode+"/"+year,  
				success: function(result){
                 alert('result');
					$('#2a').html(result);
				}
			});				
		} 
		
	});
	$('#c').on('click', function (e, x) {
		var obj = JSON.parse(x,true);
	    var facode =obj[0]['facode'];     
		var year =obj[0]['year']; 
		var recid = obj[0]['recid'];
        alert(recid);		
		if (recid > 0)
			{
				$('.nav li.active').next('li').removeClass('disabled');
				$('.nav li.active').next('li').find('a').attr("data-toggle","tab");
		
			console.log();
			$.ajax({
				url: "<?php echo base_url(); ?>Ajax_red_rec/session_plan_add/"+facode+"/"+year,
				success: function(result){
					$('#3a').html(result);
				}
			});	
        }	
	});
	$('#d').on('click', function (e, x) {
		var obj = JSON.parse(x,true);
        var recid = obj[0]['recid'];
		if (recid > 0){
				$('.nav li.active').next('li').removeClass('disabled');
				$('.nav li.active').next('li').find('a').attr("data-toggle","tab");
					$.ajax({
						url: "<?php echo base_url(); ?>Ajax_red_rec/red_strategy_add",
						success: function(result){
							$('#4a').html(result);
						}
					});	
		}
	});
	$('#e').on('click', function () {
		$.ajax({
			url: "<?php echo base_url(); ?>Ajax_red_rec/hf_quarterplan_add",
			success: function(result){
				$('#5a').html(result);
			}
		});		
	});

</script>

					<div class="tab-content clearfix">
						<form>
						<div class="row" style="width:100%; padding:4px 17px">
							<input type="hidden" name="submitted_date" id="submitted_date" value="<?php echo $current_date; ?>" class="form-control">					
							<div class="col-md-2 col-md-offset-1">
								<label>Tehsil:</label>
							</div>
							<div class="col-md-3">
								<?php
									$distcode = $this-> session-> District; 
									$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
									$result = $this->db->query($query)->result_array();
								?>
								<select class="form-control" name="tcode" id="ticode" required="required">
									<option value="">-- Select --</option>
								<?php foreach ($result as $key => $value) { ?>
									<option value="<?php echo $value['tcode'] ?>"><?php echo $value['tehsil'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>Union Council:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control" name="uncode" id="unicode">
									<option value="">-- Select --</option>
								</select>
							</div>
						</div>
						<div class="row" style="width:100%; padding:4px 17px">					
							<div class="col-md-2 col-md-offset-1">
								<label>Health Facility:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control" name="facode" id="faicode" required="required">
									<option value="">-- Select --</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Technician:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control" name="techniciancode" id="technician">
								        <option value="">-- Select --</option>
								</select>
							</div>				
						</div>
						<div class="row" style="width:100%; padding:4px 17px">					
							<div class="col-md-2 col-md-offset-1">
								<label>Year:</label>
							</div>
							<div class="col-md-3">
								<select class="form-control" name="year" id="year">
									<?php echo getAllYearsOptionsIncludingCurrent(); ?>
								</select>
							</div>				
						</div>
					</form>
				  		<div class="tab-pane active" id="1a"></div>
						<div class="tab-pane" id="2a"></div>
	        			<div class="tab-pane" id="3a"></div>
	          			<div class="tab-pane" id="4a"></div>
						<div class="tab-pane" id="5a"></div>
					</div>
	 			</div>
	  		</div>
	  	</div>
	</div>
</section>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

			