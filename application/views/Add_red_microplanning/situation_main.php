<?php 
//live
	date_default_timezone_set('Asia/Karachi'); // CDT
	$current_date = date('Y-m-d');
	//print_r($data);exit;
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
						<li id="" class=""><a href="#2a" value="check" id="b" data-toggle="tab" >Planning Problem Areas</a>
						</li>
						<li><a href="#3a" id="c" data-toggle="tab" >Session Plan</a>
						</li>
						<li><a href="#4a" id="d" data-toggle="tab">RED Strategy</a>
						</li>
			  			
						<li><a href="#6a" id="f" data-toggle="tab">RED MAP</a>
						</li>
						<!--<li><a href="#5a" id="e" data-toggle="tab"> HF Workplan for Quarter</a>
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

	$('#a').on('click', function () {
	var techniciancode = $('#techniciancodeh').val();
	var year = $('#yearh').val();
	//var filter_view=$('#filterh').val();
	if (techniciancode > 0)
		{
		$('#ticode').prop("disabled", true); 
		$('#unicode').prop("disabled", true); 
		$('#faicode').prop("disabled", true); 
		$('#technician').prop("disabled", true); 
		$('#year').prop("disabled", true); 
		
		$('#myBtn').show(); 
		}else{
		$('#ticode').attr("disabled", false); 
         $('#unicode').attr("disabled", false); 
         $('#faicode').attr("disabled", false); 
         $('#technician').attr("disabled", false); 
         $('#year').attr("disabled", false); 
         $('#myBtn').show();
		}
        /* $("ul li:last-child").removeClass('disabled');
            $("ul li:last-child").find('a').attr("data-toggle","tab");	 */	 
		$.ajax({
			url: "<?php echo base_url(); ?>Ajax_red_rec/situation_analysis_add/"+techniciancode+"/"+year,  
			 
			success: function(result){
				$('#1a').html(result);				
			}
			
		});		
	});
	$('#a').trigger( "click" );
	$('#b').on('click', function (e, x) {
		var check     = "snext";
		if(check == "snext"){
			
         $('#ticode').attr("disabled", true); 
         $('#unicode').attr("disabled", true); 
         $('#faicode').attr("disabled", true); 
         $('#technician').attr("disabled", true); 
         $('#year').attr("disabled", true); 
         $('#myBtn').hide(); 
		} 
		var obj = JSON.parse(x,true);
	    var techniciancode =obj[0]['techniciancode'];     
		var year =obj[0]['year'];
        var recid = obj[0]['recid'];
     // alert(techniciancode);		
		 if (recid > 0)
		{
            $('.nav li.active').next('li').removeClass('disabled');
            $('.nav li.active').next('li').find('a').attr("data-toggle","tab");
			//$("ul li:last-child").removeClass('disabled');
            //$("ul li:last-child").find('a').attr("data-toggle","tab");
           // $("ul li:last-child").addClass("last-item");


                $.ajax({
				url: "<?php echo base_url(); ?>Ajax_red_rec/special_activities_add/"+techniciancode+"/"+year,  
				success: function(result){
                 //alert('result');
					$('#2a').html(result);
				}
			});				
		} 
		
	});
	$('#c').on('click', function (e, x) {
	 	var check     = "snext";
		if(check == "snext"){
         $('#ticode').prop("disabled", true); 
         $('#unicode').prop("disabled", true); 
         $('#faicode').prop("disabled", true); 
         $('#technician').prop("disabled", true); 
         $('#year').prop("disabled", true); 
         $('#myBtn').hide(); 
		} 
		var obj = JSON.parse(x,true);
	    var techniciancode =obj[0]['techniciancode'];     
		var year =obj[0]['year']; 
		var recid = obj[0]['recid'];
        //alert(recid);		
		if (recid > 0)
			{
				$('.nav li.active').next('li').removeClass('disabled');
				$('.nav li.active').next('li').find('a').attr("data-toggle","tab");
		
			console.log();
			$.ajax({
				url: "<?php echo base_url(); ?>Ajax_red_rec/session_plan_add/"+techniciancode+"/"+year,
				success: function(result){
					$('#3a').html(result);
				}
			});	
        }	
	});
	$('#d').on('click', function (e, x) {
		var check     = "snext";
		if(check == "snext"){
         $('#ticode').prop("disabled", true); 
         $('#unicode').prop("disabled", true); 
         $('#faicode').prop("disabled", true); 
         $('#technician').prop("disabled", true); 
         $('#year').prop("disabled", true); 
         $('#myBtn').hide(); 
		}
		
		var obj = JSON.parse(x,true);
		var techniciancode =obj[0]['techniciancode'];     
		var year =obj[0]['year']; 
        var recid = obj[0]['recid'];
		if (recid > 0){
				$('.nav li.active').next('li').removeClass('disabled');
				$('.nav li.active').next('li').find('a').attr("data-toggle","tab");
					$.ajax({
						url: "<?php echo base_url(); ?>Ajax_red_rec/red_strategy_add/"+techniciancode+"/"+year,
						success: function(result){
							$('#4a').html(result);
						}
					});	
		}
	});
	$('#e').on('click', function (e, x) {
		var check     = "snext";
		if(check == "snext"){
         $('#ticode').prop("disabled", true); 
         $('#unicode').prop("disabled", true); 
         $('#faicode').prop("disabled", true); 
         $('#technician').prop("disabled", true); 
         $('#year').prop("disabled", true); 
         $('#myBtn').hide(); 
		}
		
		var obj = JSON.parse(x,true);
		var techniciancode =obj[0]['techniciancode'];     
		var year =obj[0]['year']; 
        var recid = obj[0]['recid'];
		if (recid > 0){
				$('.nav li.active').next('li').removeClass('disabled');
				$('.nav li.active').next('li').find('a').attr("data-toggle","tab");
				$.ajax({
					url: "<?php echo base_url(); ?>Ajax_red_rec/hf_quarterplan_add/"+techniciancode+"/"+year,
					success: function(result){
						$('#5a').html(result);
					}
				});		
		}
		
	});
	$('#f').on('click', function (e, x) {
		
		var check     = "snext";
		if(check == "snext"){
         $('#ticode').prop("disabled", true); 
         $('#unicode').prop("disabled", true); 
         $('#faicode').prop("disabled", true); 
         $('#technician').prop("disabled", true); 
         $('#year').prop("disabled", true); 
         $('#myBtn').hide(); 
		}
		
		var obj = JSON.parse(x,true);
		var techniciancode =obj[0]['techniciancode'];     
		var year =obj[0]['year']; 
        var recid = obj[0]['recid'];
		//alert(techniciancode);
		if (recid > 0){
			$("ul li:last-child").removeClass('disabled');
            $("ul li:last-child").find('a').attr("data-toggle","tab");			
			$.ajax({
				url: "<?php echo base_url(); ?>Ajax_red_rec/red_map_add/"+techniciancode+"/"+year,
				success: function(result){
					//alert("result");
					
					$('#6a').html(result);
				}
			});	
		}
	});
});
</script>

					<div class="tab-content clearfix">
						<form>
						<div class="row" style="width:100%; padding:4px 17px">
							<input type="hidden" name="submitted_date" id="submitted_date" value="<?php echo $current_date; ?>" class="form-control">					
							
							<div class="col-md-2 col-md-offset-1">
								<label>Tehsil: <span style="color:red;">*</span></label>
							</div>
							<div class="col-md-3">
								<?php
									/* $distcode = $this-> session-> District; 
									$query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
									$result = $this->db->query($query)->result_array(); */
								?>
								<select class="form-control" name="ticode" id="ticode" required="required">
									<option value="">-- Select --</option>
								<?php foreach ($data as $key => $value) { ?>
									<option value="<?php echo $value['tcode'] ?>"><?php echo $value['tehsil'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>Union Council: <span style="color:red;">*</span></label>
							</div>
							<div class="col-md-3">
								<select hidden class="form-control" name="unicode" id="unicode">
									<option value="">-- Select --</option>
								</select>
							</div>
							<div class="col-md-3" hidden>
								<select hidden class="form-control" name="uncode" id="unicode">
									<option value="">-- Select --</option>
								</select>
							</div>
						</div>
						<div class="row" style="width:100%; padding:4px 17px">					
							<div class="col-md-2 col-md-offset-1">
								<label>Health Facility: <span style="color:red;">*</span></label>
							</div>
							<div class="col-md-3">
								<select class="form-control" name="facode" id="faicode" required="required">
									<option value="">-- Select --</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>Technician: <span style="color:red;">*</span></label>
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
									<?php echo getAllYearsOptionsIncludingNext(); ?>
								</select>
							</div>	
							<div class="col-md-2">
								
							</div>
						<!--	<div class="col-md-3">
								 <button id="myBtn"  style="background: #008d4c;" type="button" class="btn btn-md btn-primary"> Add Village</button>
							</div>	-->
						</div>
					</form>
				  		<div class="tab-pane active" id="1a"></div>
						<div class="tab-pane" id="2a"></div>
	        			<div class="tab-pane" id="3a"></div>
	          			<div class="tab-pane" id="4a"></div>
						<div class="tab-pane" id="5a"></div>
						<div class="tab-pane" id="6a"></div>
					
					 <!-- ============Start Modal================== -->
   <div id="myModal" class="modalx  "> 

    <div class="modal-contentx">
    <span class="closex">&times;</span>
     <div class="panel-body">

        <form id="form">
    <div class="row">
     <div class="panel-headingxx">Add Village</div><br><br>
          <div class="form-group">
         
        <label class="col-xs-2 col-xs-offset-1 control-label">District:</label>
      <div class="col-xs-3">
        <?php 
        $distcode = $this-> session-> District;
        echo get_District_Name($distcode); 
       ?> 
       <input type="hidden" name="distcode" value="<?php echo $distcode; ?>">       
      </div>
      <label class="col-xs-2 control-label">Tehsil:</label>
      <div class="col-xs-3">
      	<input type="hidden" name="tcode" id="ttcode" class="form-control" >
		<input  id="ttext" class="form-control" type="text" readonly="">
       <?php
        $distcode = $this-> session-> District; 
        $query="SELECT tcode, tehsilname(tcode) as tehsil from tehsil where distcode='{$distcode}'";
        $result = $this->db->query($query)->result_array();
       ?>
       <select class="form-control x" name="tcode" id="tmcode" required="required">
        <option value="">-- Select --</option>
       <?php foreach ($result as $key => $value) { ?>
        <option value="<?php echo $value['tcode'] ?>"><?php echo $value['tehsil'] ?></option>
        <?php } ?>
       </select>       
      </div>
         
       </div>
    </div>
    <div class="row">
     <div class="form-group">
       <label class="col-xs-2 col-xs-offset-1 control-label">Union Council:</label>
       <div class="col-xs-3">
       	<input type="hidden" name="uncode" id="uuncode" class="form-control">
		<input type="hidden" name="facode" id="ffncode" class="form-control">
		<input  id="utext" class="form-control" type="text" readonly="">
        <select name="uncode" id="unmcode" required="required" class="form-control x">
         <option></option>
        </select>
       </div>
       <label class="col-xs-2 control-label">Village Name:</label>
         <div class="col-xs-3">
         <input required="required" name="village" id="village_name" placeholder="Village Name" class="form-control x" class="form-control">
         <!-- <input type="hidden" required name="facode" id="facode" readonly="readonly" placeholder="Health Facility Code" class="form-control"> -->
         </div>    
     </div>
    </div>
    <div class="row">
          <div class="form-group">
           <label class="col-xs-2 col-xs-offset-1 control-label">Village Code:</label>
        <div class="col-xs-3">
       <input name="vcode" id="vcode" placeholder="Village Code" class="form-control text-center xx x" readonly="readonly" required="required" >
        </div>
          <label class="col-xs-2 control-label">Total Population:</label>
        <div class="col-xs-3">
       <input required="required" name="population" id="population" placeholder="Total Population" class="form-control numberclass xx x" class="form-control ">
        </div>
       </div>
    </div>    
    <div class="row">
      <label class="col-xs-2 col-xs-offset-1 control-label">Target Population:</label>
        <div class="col-xs-3">
			<input readonly="" required="required" name="population_less_year" id="population_less_year" placeholder="Target  Population" class="form-control numberclass x">
        </div>
		
		<label class="col-xs-2  control-label">Year:</label>
		<div class="col-xs-3">
		<input  id="myear" class="form-control" type="text" readonly="">
			
        </div>
    
	</div>
	 <div class="row">
		<label class="col-xs-2 col-xs-offset-1 control-label">Postal Office:</label>
		<div class="col-xs-3">
			<input  name="postal_address" id="postal_address" placeholder="Postal Office" class="form-control x">
		</div>
	<div>
	 
    <hr>
    <div class="row">
     <div class="col-xs-7" style="margin-left:67.5%;" >
      <button type="submit" name="submit" value="Submit" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Save Form </button>
      
     </div>
    </div>
   </form>   
    </div>
    </div>
   </div>
    <!-- ===============End Modal============== -->
					
					</div>
	 			</div>
	  		</div>
	  	</div>
	</div>
</section>
<script  type="text/javascript">
	$( document ).ready(function() {
    $("#ttext").hide();
    $("#utext").hide();
	//var year=$("#year").val();
	var year = $("#year option:selected").text();
	//alert(year);
	$("#myear").val(year);
});
	$(document).on('change','#ticode', function()
		{
			var tcode = $("#ticode option:selected").val();
			var text = $("#ticode option:selected").text();
			//alert(tcode);
			if (tcode >0)
				{ 
					$("#tmcode").hide(); 
					$("#ttext").show();
					$("#ttcode").val(tcode);
					$("#ttext").val(text);
					$( "#tmcode" ).remove();
					$( "#unmcode" ).remove();
					/*$('#tmcode').removeAttr('required','required');
            		$('#unmcode').removeAttr('required','required');*/
				}
				else{
					$("#tmcode").show();
					$("#ttext").hide();
				}
									
		});
	$(document).on('change','#unicode', function()
		{
			var uncode = $("#unicode option:selected").val();
			var utext = $("#unicode option:selected").text();
			//alert(uncode);
			if (uncode >0)
				{ 
					$("#unmcode").hide();
					$("#utext").show();
					$("#uuncode").val(uncode);
					$("#utext").val(utext);
					$( "#tmcode" ).remove();
					$( "#unmcode" ).remove();
					/*$('#tmcode').removeAttr('required','required');
            		$('#unmcode').removeAttr('required','required');*/
				}
				else{
					$("#unmcode").show();
					$("#utext").hide();
				}
						
		});
		$(document).on('change','#faicode', function()
		{
			var facode = $("#faicode option:selected").val();
			
				$("#ffncode").val(facode);
		});
	$(window).on('load', function() {
		if($('#tcode :selected').val() == '0'){
			$('#tcode :selected').val('');
		}
	});
	function checkCode(num) {
		var regexp = /[0-9]{2}/;
		var valid = regexp.test(num);
		return valid;
	}
	$(document).on('change','#tmcode', function(){
		var tcode = this.value;
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getUnC/",
				success: function(result){
					$('#unmcode').html(result);
				}
			});
		}
		else{
			$('#unmcode').html('');
			//it doesn't exist
		}						
	});	
	// <?php if(!$this->input->get('facode')){ ?>
	//$(document).on('change','#ticode', function(){
	$('#village_name').on('blur' , function (){
		var uncode = $('#unmcode').val();
		var uncode1 = $('#uuncode').val();
			if (uncode>0)
		{
				$.ajax({
			type: "GET",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_red_rec/generateCode",
			success: function(result){
				$('#vcode').val(result);
			}
		});				
		}
		else if (uncode1>0)
		{
				$.ajax({
			type: "GET",
			data: "uncode="+uncode1,
			url: "<?php echo base_url(); ?>Ajax_red_rec/generateCode",
			success: function(result){
				$('#vcode').val(result);
			}
		});
		}
	});

	$(document).on('change', '#unmcode', function(){
		var unicode = this.value;
		if(unicode != ""){
			$('#vcode').val('');
			$('#village_name').val('');
			// $('#population').val('');
			// $('#postal_address').val('');
		}		
	});
	$(document).on('change', '#technician', function(){
		 var faicode = $("#faicode").val();
		 //alert(faicode);
		 var techniciancode = this.value;
		 //alert(techniciancode);
		 var selectedyear = $("#year").find("option:selected").val();
		 $.ajax({
				type: 'post',
				data: {"faicode":faicode,"techniciancode":techniciancode,"selectedyear":selectedyear},
				url: "<?php echo base_url(); ?>Ajax_red_rec/checkTechnician_avalible",
				success: function (data) {
					 var check = JSON.parse(data);
					if( check == "yes" ){ 
						alert("Cannot save data because data already exists for this Technician!");
						$("#technician").css("background-color","#FF0000");
					}else if(check == "no" ){
						$("#technician").css("background-color","#FFF");
					}
				}
		}); 
	});
	$(document).on('change', '#year', function(){
		 var year = this.value;
		 var faicode = $('#faicode :selected').val();
		 var techniciancode = $('#technician :selected').val();
		 
		 $.ajax({
				type: 'post',
				data: "techniciancode="+techniciancode+"&faicode"+faicode+"&year="+year,
				url: "<?php echo base_url(); ?>Ajax_red_rec/checkTechnician_avalible",
				success: function (data) {
					 var check = JSON.parse(data);
					//alert(check);
							if( check == "yes" ){ 
							   alert("Cannot save data because data already exists for this Technician!");
							   $("#technician").css("background-color","#FF0000");
							}else if(check == "no" ){
								$("#technician").css("background-color","#FFF");
							}
				}
		}); 
	});
	$(document).on('change', '#year', function(){
		$("#technician").trigger("change");
	});
  $(document).on('keyup','#population', function(){
		var population = $('#population').val();
		var population1 =(0.0353*population);
			population1 =Math.ceil(0.942*population1);
			$("#population_less_year").val(population1);		
	});
$(function () {			
        $('#form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'post',
             url: "<?php echo base_url();?>Villages/ajax_village_save",
            data: $('form').serialize(),
            success: function (data) {
            		$("#village").html(data);
            		//$('#unicode').trigger('change');
					uncodevi();
            		$('#myModal').addClass('hide');            		
            		//$('#myModal').addClass('modal');                     
            }
          });
        });
      });
  	 var modal = document.getElementById('myModal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closex")[0];

// When the user clicks the button, open the modal 
/* btn.onclick = function() {
	
	$('#myModal').removeClass('hide');
	$('.x').val('');
	$('#myModal').trigger(':reset');
    modal.style.display = "block";
} */

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
// <?php } ?>
</script>

<!-- The Modal -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

			