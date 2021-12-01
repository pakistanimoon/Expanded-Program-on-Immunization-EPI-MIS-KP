
<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Outbreak Response</div>
			<div class="panel-body">
								
				<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Case_response/save_case_response">
					<table class="table table-bordered table-striped table-hover  mytable3">
						<tbody>
							<tr>
								<td><label>Tehsil</label></td>
								<td>
									<select class="form-control tcode" id="tcode" name="tcode" required="">
										<option value="" >&nbsp;&nbsp;&nbsp;&nbsp;- - - - - -Select- - - - - -</option>
										<?php 
										foreach ($tehsil as $row){ ?>
											<option value="<?php echo $row['tcode']; ?>"><?php echo $row['tehsil']; ?> </option>
									<?php } ?>									
								</select>										
								</td>
								<td><label>Union Council</label></td>
								<td>
									<select name="uncode" id="uncode" required="" class="form-control uncode">
									<option></option>
								</select>										
								</td>
								<td><label>Village</label></td>
								<td>									
									<select class="form-control" id="village" name="vcode" required="required">
										<option  &nbsp;&nbsp;>&nbsp;&nbsp;- - - - - - -Select- - - - - - -</option>
																			
								</select>
								</td>
								<!-- <td>
								<button id="myBtn"  style="background: #008d4c;" type="button" class="btn btn-md btn-primary"> Add Village</button>
								</td> -->
							</tr>
							<tr>
									<td><label>Disease</label></td>
								<td>
									<select class="form-control" id="disease" name="disease" required="">
										<option value="">&nbsp;&nbsp;&nbsp;&nbsp;- - - - - - -Select- - - - - - -</option>
										<option value="Diphtheria">Diphtheria</option>
										<option value="Measles">Measles</option>
										<option value="Acute Flacid Pralysis">Acute Flacid Pralysis</option>
										<option value="Meningitis">Meningitis</option>
										<option value="Pneumonia">Pneumonia</option>
										<option value="Neonetal Tetnus">Neonetal Tetnus</option>
										<option value="Pertusis">Pertusis</option>
										<option value="Hepatitis">Hepatitis</option>
										<option value="Influenza B">Influenza B</option>
										<option value="Rota Virus">Rota Virus</option>
										<option value="Typhoid">Typhoid</option>
									</select>										
								</td>
								<td><label>Date of Activity</label></td>
								<!-- <td>
									<input class="form-control dp" data-provide="datepicker" name="date_of_activity" placeholder="YYYY-MM-DD" data-date-end-date="0d" required="">
								</td> -->
								<td class="disabledclass"><input class="dp form-control" name="date_of_activity" id="date_of_activity" value="" type="text" placeholder="YYYY-MM-DD" required="required"></td>
								
								
							</tr>
							<tr>
								<td><label>Age Group From</label></td>
								<td><input class="form-control numberclass text-center"  placeholder="Month" name="age_group_from"  value="" type="text" required="required"></td>
								<td><label>Age Group To</label></td>
								<td><input class="form-control numberclass text-center" name="age_group_to" placeholder="Month"  value="" type="text" required="required"></td>
							</tr>

						</tbody>

					</table>

					<table   class="table table-bordered plan_table">
						<thead>
							<tr style="background-color: #057140;color: white">
								<td colspan="12" style="text-align: center;">No. of Cases</td>								
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="4" style="text-align: center;">Reported through case based surveillance</td>
								<td colspan="4" style="text-align: center;">Active search Cases</td>
								<td colspan="4" style="text-align: center;">Epi linked Cases</td>
							</tr>							
						</thead>
						<tbody>
							<tr>
								<td colspan="4"><input name="reported_case_base_surveillance" type="text" value="0"  class="form-control text-center numberclass" ></td> 
								<td colspan="4"><input name="active_search_case" type="text" value="0" class="form-control text-center numberclass" ></td>
								<td colspan="4"><input class="form-control  text-center numberclass" name="epi_linked_case"  value="0" type="text"></td>
							</tr>
						</tbody>
						<thead>
							<tr style="background-color: #057140;color: white">
								<td colspan="12" style="text-align: center;">No. of Children Vaccinated</td>								
							</tr>
							<tr>
								<th rowspan="2" style="width: 15%;">All Vaccines List</th>
								<th colspan="2">0-11 M</th>
								<th colspan="2">12-23 M</th>
								<th colspan="2">&gt; Years</th>
								<th colspan="2">Total</th>
								<th colspan="1">T</th>
								<!-- <th rowspan="2">Action</th> -->
							</tr>
							<tr>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M</th>
								<th>F</th>
								<th>M-F</th>
							</tr>						
						</thead>				
						<tbody id="trRow">
							<?php
							$vaccines = array(
								"BCG",
								"bOPV",
								"IPV",
								"Penta 1",
								"Penta 2",
								"Penta 3",
								"Penta Booster Dose",
								"PCV 10",
								"TT",
								"TD/DtaP/Dt",
								"Measles I",
								"Measles II",
								"Msl Booster Dose",
								"Hep-B",
								"Rotarix",
								"TCV"
							); 
							foreach ($vaccines as $key => $value) { ?>
								
							
							<tr>
								<!-- <td>

									<select name="vaccines[0]" id="vaccines" class="form-control vaccines" required="" >
										<option value="">Select</option>
										<option value="BCG">BCG</option>
										<option value="bOPV">bOPV</option>
										<option value="IPV">IPV</option>
										<option value="Penta 1">Penta 1</option>
										<option value="Penta 2">Penta 2</option>
										<option value="Penta 3">Penta 3</option>
										<option value="Penta Booster Dose">Penta Booster Dose</option>
										<option value="PCV 10">PCV 10</option>
										<option value="TT">TT</option>
										<option value="TD/DtaP/Dt">TD/DtaP/Dt</option>				
										<option value="Measles I">Measles I</option>
										<option value="Measles II">Measles II</option>
										<option value="Msl Booster Dose">Msl Booster Dose</option>
										<option value="Hep-B">Hep-B</option>
										<option value="Rotarix">Rotarix</option>								
									</select>
								</td> -->
								<td ><input readonly="" name="vaccines[<?php echo $key; ?>]" value="<?php echo $value; ?>"   class="form-control text-bold vaccines"></td>
								<td><input name="0_11_m_m[<?php echo $key; ?>]" type="text" value="0"  class="form-control text-center numberclass 0_11_m_m calculation " ></td>
								<td><input name="0_11_m_f[<?php echo $key; ?>]" type="text" value="0" class="form-control text-center numberclass calculation 0_11_m_f" ></td>
								<td><input name="12_23_m_m[<?php echo $key; ?>]" type="text" value="0"  class="form-control text-center numberclass calculation 12_23_m_m" ></td>
								<td><input name="12_23_m_f[<?php echo $key; ?>]" type="text" value="0" class="form-control text-center numberclass calculation 12_23_m_f" ></td>
								<td><input name="years_m[<?php echo $key; ?>]" type="text"  value="0" class="form-control text-center numberclass calculation years_m" ></td>
								<td><input name="years_f[<?php echo $key; ?>]" type="text" value="0" class="form-control text-center numberclass calculation years_f" ></td>
								<td><input name="total_m[<?php echo $key; ?>]" readonly="" type="text" value="0" id="total_m" class="form-control text-center numberclass calculation total_m" ></td>
								<td><input name="total_f[<?php echo $key; ?>]" readonly="" type="text" value="0" class="form-control text-center numberclass calculation total_f" ></td>
								<td><input name="total_m_f[<?php echo $key; ?>]" readonly="" type="text" value="0" class="form-control text-center numberclass calculation total_m_f" ></td>
								<!-- 	<td>
									<?php 
									//$village='1';
										if(isset($village)) {?>
											<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
										<?php } else { ?>

											<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
										<?php } ?>
									</td>  -->
							</tr>
							<?php }
							?>
							</tbody>
							<tbody>
							<tr>
								<td>Total</td>
								<td><input name="total_one_to_m" id="total_one_to_m" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_one_to_f" id="total_one_to_f" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_twelve_to_m" id="total_twelve_to_m" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_twelve_to_f" id="total_twelve_to_f" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_year_m" id="total_year_m" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_year_f" id="total_year_f" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_mm" id="total_mm" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_ff" id="total_ff" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="t_m_f" id="t_m_f" readonly="" class="form-control text-center numberclass calculation" ></td> 								
							</tr>
							
							<tr style="background-color: #057140;color: white">
								<td colspan="4">No of blood samples collected</td>
								<td colspan="4">No of Throat / Oral swabs collected</td>
								<td colspan="4">Follow Up Visits</td>
							</tr>
							<tr>
								<td colspan="4"><input name="blood_speciment_collected" type="text" value="0"  class="form-control text-center numberclass" ></td> 
								<td colspan="4"><input name="oral_swabs_collected" type="text" value="0" class="form-control text-center numberclass" ></td>
								<!-- <td colspan="4"><input name="follow_up_visit" class="form-control dp" data-date-start-date="+1d" data-provide="datepicker " value="" id="" placeholder="YYYY-MM-DD"></td> -->
								<td colspan="4" class="disabledclass"><input class="dp form-control" name="follow_up_visit" id="follow_up_visit" value="" type="text" placeholder="YYYY-MM-DD" required="required"></td>
							</tr>					
						</tbody>
					</table>
					 <div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<button style="background: #008d4c;" type="" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
							<button style="background: #008d4c;" type="reset" class="btn btn-md btn-primary"><i class="fa fa-repeat"></i> Reset Form </button>							
							<a href="<?php echo base_url(); ?>Case-List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>							
						</div>
						</div>
				</form>  
			</div>
		</div>
	</div>
</div>
	  <!-- ============Start Modal================== -->
			<!-- <div id="myModal" class="modalx  ">	

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
							<select class="form-control x mtcode" name="tcode" id="mtcode" required="required">
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
								<input  id="utext" class="form-control" type="text" readonly="">
								 <select name="uncode" id="muncode" required="required" class="form-control x">
								</select>
							</div>
							<label class="col-xs-2 control-label">Village Name:</label>
						  	<div class="col-xs-3">
							 	<input required="required" name="village" id="mvillage" placeholder="Village Name" class="form-control x" class="form-control">
							 	 <input type="hidden" required name="facode" id="facode" readonly="readonly" placeholder="Health Facility Code" class="form-control">
						  	</div>				
					</div>
				</div>
				<div class="row">
	    		   <div class="form-group">
	    		   	<label class="col-xs-2 col-xs-offset-1 control-label">Village Code:</label>
					  	<div class="col-xs-3">
							<input name="vcode" id="mvcode" placeholder="Village Code" class="form-control text-center x" readonly="readonly" required="required" >
					  	</div>
  					  	<label class="col-xs-2 control-label">Total Population:</label>
					  	<div class="col-xs-3">
							<input required="required" name="population" id="population" placeholder="Total  Population" class="form-control numberclass x" class="form-control ">
					  	</div>
				   </div>
				</div>				
				<div class="row">
						<label class="col-xs-2 col-xs-offset-1 control-label">Target  Population:</label>
					  	<div class="col-xs-3">
							<input readonly="" name="population_less_year" id="population_less_year" placeholder="Target  Population" class="form-control numberclass x">
					  	</div>
						<label class="col-xs-2  control-label">Postal Office:</label>
					  	<div class="col-xs-3">
							<input  name="postal_address" id="postal_address" placeholder="Postal Office" class="form-control x">
					  	</div>
						
					</div>
				<hr>
				<div class="row">
					<div class="col-xs-7" style="margin-left:67.5%;" >
						<button type="submit" name="submit" value="Submit" class="btn btn-md btn-success"><i class="fa fa-floppy-o"></i> Save Form </button>
						
					</div>

				</div>
			</form>			
  		</div>
				</div>
			</div> -->
				<!-- ===============End Modal============== -->
<script type="text/javascript">
	$( document ).ready(function() {
    $("#ttext").hide();
    $("#utext").hide();
});
	$(document).on('change','#tcode', function()
		{
			var tcode = $("#tcode option:selected").val();
			var text = $("#tcode option:selected").text();
			if (tcode >0)
				{ 
					$("#mtcode").hide();
					$("#ttext").show();
					$("#ttcode").val(tcode);
					$("#ttext").val(text);
					$( "#mtcode" ).remove();
					$( "#muncode" ).remove();
					/*$('#mtcode').removeAttr('required','required');
            		$('#muncode').removeAttr('required','required');*/
				}
				else{
					$("#mtcode").show();
					$("#ttext").hide();
				}
									
		});
	$(document).on('change','#uncode', function()
		{
			var uncode = $("#uncode option:selected").val();
			var utext = $("#uncode option:selected").text();
			if (uncode >0)
				{ 
					$("#muncode").hide();
					$("#utext").show();
					$("#uuncode").val(uncode);
					$("#utext").val(utext);
					$( "#mtcode" ).remove();
					$( "#muncode" ).remove();
					/*$('#mtcode').removeAttr('required','required');
            		$('#muncode').removeAttr('required','required');*/
				}
				else{
					$("#muncode").show();
					$("#utext").hide();
				}
						
		});	
	$(document).on('click','.minus', function()
   		{ 	
   		/*$(".vaccines").change(function() {
        var status = $(this).val();       
    });*/
		var currentRow=$(this).closest("tr");
		var text=currentRow.find("td:eq(0)").find('.vaccines option:selected' ).text();
		var value=currentRow.find("td:eq(0)").find('.vaccines option:selected' ).val();
		//alert(text);
		if (text=='Select'&& value==value) {}
			else{
				$(".vaccines").append('<option value=' + value + '>' + text + '</option>');
			}				
    });
//==================
		//TODO:1
		//var previous = '';
		$(".vaccines").on('click', function() {
        	previous = this.value;
	    });

		$(document).on('change','.vaccines', function() {
		var dropdownval = $(this).val();
		  $(".vaccines").each(function(){
		  //	debugger;
            var xx = $(this).val();
            
            if ( xx == dropdownval ) 
            { 
            	//alert('xxx');
            	//console.log(previous);
            	$('.vaccines').not(this).find('option[value="' + xx + '"]').remove();

				if(previous!==''){
					var ele = document.createElement('option');
	            	ele.setAttribute('value', previous);
	            	ele.innerText = previous;
	            	$('.vaccines').not(this).each((i,b)=> { 
	            	 	console.log(b);
	            	 	var tempEle = $(b);
	            	 	tempEle.append($(ele).clone());            		 	
	            	}); 
				}           		 
            }
        });

		});
//==================
/*	$(document).on('change','.vaccines', function()
	{
		$('option:selected', this).remove();
		$currentSelected = $(this);		
		$selectedValue = $(this).val();
		$(".vaccines").each(function(index,elm)
		{
			$(this).not($currentSelected).find("option[value='"+$selectedValue+"']").remove();
			$('.vaccines :selected').remove();
		});
	});*/
/*	$(document).on('click','.plus', function()
   { 	
		var bla = $('.vaccines :selected').text();
		alert(bla);	
    });*/
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
  $("#date_of_activity").on( "click", function() {
        setNewDate('date_of_activity');
      });
  /*$("#date_admission").on( "click", function() {
        setNewDate('date_admission');
      });*/
   $("#date_of_activity").on( "change", function() {
        fromDate('date_of_activity', 'follow_up_visit');
      });
    $("#follow_up_visit").on( "change", function() {
        toDate('date_of_activity', 'follow_up_visit');
      });
	  
	/* $("#follow_up_visit").on( "change", function() {
        fromDate('follow_up_visit', 'date_notification_level');
      });*/
    /*$("#date_notification_level").on( "change", function() {
        toDate('follow_up_visit', 'date_notification_level');
      });*/
      $(document).on('keyup','#population', function(){
     // $( "#population" ).keyup(function() {
		var population = $('#population').val();		
		var population1 =Math.ceil(0.0353*population);
		population1 =Math.ceil(0.942*population1);
		$("#population_less_year").val(population1);
				
	}); 

	});
	function addRow(obj){
		var row = $(obj).closest("tr").clone(true);

//TODO:1
		row.find('input').val('');
		row.find("td:nth-child(2)").find('input').val('0');
		row.find("td:nth-child(3)").find('input').val('0');
		row.find("td:nth-child(4)").find('input').val('0');
		row.find("td:nth-child(5)").find('input').val('0');
		row.find("td:nth-child(6)").find('input').val('0');
		row.find("td:nth-child(7)").find('input').val('0');
		row.find("td:nth-child(8)").find('input').val('0');
		row.find("td:nth-child(9)").find('input').val('0');
		row.find("td:nth-child(10)").find('input').val('0');
		var allSelects = $('.vaccines');
		allSelects.each((i,b)=>{
			var selectedValue = b.selectedOptions[0].value;
			if(selectedValue!==''){
				row.find('option[value="' + selectedValue + '"]').remove();
			}
		})
		$(obj).closest("tr").after(row);//alert(row.index());
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>');
		$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindexrows();
	}
	function reindexrows(){
		$('#trRow > tr').each(function(i,k){
			//debugger;
			$(this).find("td:nth-child(1)").find('select').attr('name','vaccines['+i+']');
			$(this).find("td:nth-child(2)").find('input').attr('name','0_11_m_m['+i+']');
			$(this).find("td:nth-child(3)").find('input').attr('name','0_11_m_f['+i+']');
			$(this).find("td:nth-child(4)").find('input').attr('name','12_23_m_m['+i+']');
			$(this).find("td:nth-child(5)").find('input').attr('name','12_23_m_f['+i+']');
			$(this).find("td:nth-child(6)").find('input').attr('name','years_m['+i+']');
			$(this).find("td:nth-child(7)").find('input').attr('name','years_f['+i+']');
			$(this).find("td:nth-child(8)").find('input').attr('name','total_m['+i+']');
			$(this).find("td:nth-child(9)").find('input').attr('name','total_f['+i+']');
			$(this).find("td:nth-child(10)").find('input').attr('name','total_m_f['+i+']');
		});
	}
	
	function deleteRow(obj)
	{ 
		//var s = $(".vaccines").text();
		/*var currentRow=obj.closest("tr");
		 var x =currentRow.find("td:eq(0)").html();
		alert(x);*/
		/*$(".vaccines").append('<option value='+s+'>'+s+'</option>');*/

		  //$("#breeds").attr('disabled', false);
               /* $.each(s,function(key, value)
                {
                    $("#vaccines").append('<option value=' + key + '>' + value + '</option>');
                });*/


   		var index = $('#trRow').find('tr:last').index();
		$(obj).closest("tr").remove();
		if(index=='1'){
			$('#trRow').find('tr:last').find('td:last').html('<button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}else{
			$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		}
		var sum = 0;
		var sumf = 0;
		var sumtm=0;
		var sumtf=0;
		var sumym=0;
		var sumyf=0;
		var sumtom=0;
		var sumtof=0;
		var sumtotal=0;
		$(".0_11_m_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sum += parseInt(value);
				$("#total_one_to_m").val(sum);
			}
		});
		$(".0_11_m_f").each(function()
		{
			var valuef = $(this).val();   
			if(!isNaN(valuef) && valuef.length != 0)
			{
				sumf += parseInt(valuef);
				$("#total_one_to_f").val(sumf);
			}
		});
		$(".12_23_m_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtm += parseInt(value);
				$("#total_twelve_to_m").val(sumtm);
			} 
		});
		$(".12_23_m_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtf += parseInt(value);
				$("#total_twelve_to_f").val(sumtf);
			} 
		});
		$(".years_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumym += parseInt(value);
				$("#total_year_m").val(sumym);
			}  
		});
		$(".years_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumyf += parseInt(value);
				$("#total_year_f").val(sumyf);
			}  
		});
		$(".total_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtom += parseInt(value);
				$("#total_mm").val(sumtom);
			}   
		});
		$(".total_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtof += parseInt(value);
				$("#total_ff").val(sumtof);
			}   
		});
		$(".total_m_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtotal += parseInt(value);
				$("#t_m_f").val(sumtotal);
			}    
		});
		reindexrows();
	}
  	$(document).ready(function()
   	{
		$('#uncode').on('change' , function (){
		var uncode = this.value;
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
				//console.log(result)
			  $('#village').html(result);
			}
		});
	});
		$('#muncode').on('change' , function (){
		var uncode = this.value;
		$.ajax({
			type: "POST",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_calls/getVillages",
			success: function(result){
				//console.log(result)
			  $('#mvillage').html(result);
			}
		});
	});
	$(document).on('keyup','.calculation',function(e)
	{      	
		var  xa =   parseInt($(this).closest('tr').find(".0_11_m_m").val());
		var  xb =   parseInt($(this).closest('tr').find(".12_23_m_m").val());
		var  xc =   parseInt($(this).closest('tr').find(".years_m").val());
		var xman= parseInt(xa +xb+xc);
		if( ! isNaN(xman))
		{
			$(this).closest('tr').find(".total_m").val(xman);
		}
		var  mf =   parseInt($(this).closest('tr').find(".0_11_m_f").val());
		var  fm =   parseInt($(this).closest('tr').find(".12_23_m_f").val());
		var  yf =   parseInt($(this).closest('tr').find(".years_f").val());
		var xf= parseInt(mf +fm+yf);
		if( ! isNaN(xf))
		{
			$(this).closest('tr').find(".total_f").val(xf);
		}
		var total= parseInt(xman+xf);
		if( ! isNaN(total))
		{
			$(this).closest('tr').find(".total_m_f").val(total);
		}
		var sum = 0;
		var sumf = 0;
		var sumtm=0;
		var sumtf=0;
		var sumym=0;
		var sumyf=0;
		var sumtom=0;
		var sumtof=0;
		var sumtotal=0;
		$(".0_11_m_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sum += parseInt(value);
				$("#total_one_to_m").val(sum);
			}
		});
		$(".0_11_m_f").each(function()
		{
			var valuef = $(this).val();   
			if(!isNaN(valuef) && valuef.length != 0)
			{
				sumf += parseInt(valuef);
				$("#total_one_to_f").val(sumf);
			}
		});
		$(".12_23_m_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtm += parseInt(value);
				$("#total_twelve_to_m").val(sumtm);
			} 
		});
		$(".12_23_m_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtf += parseInt(value);
				$("#total_twelve_to_f").val(sumtf);
			} 
		});
		$(".years_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumym += parseInt(value);
				$("#total_year_m").val(sumym);
			}  
		});
		$(".years_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumyf += parseInt(value);
				$("#total_year_f").val(sumyf);
			}  
		});
		$(".total_m").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtom += parseInt(value);
				$("#total_mm").val(sumtom);
			}   
		});
		$(".total_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtof += parseInt(value);
				$("#total_ff").val(sumtof);
			}   
		});
		$(".total_m_f").each(function()
		{
			var value = $(this).val();
			if(!isNaN(value) && value.length != 0)
			{
				sumtotal += parseInt(value);
				$("#t_m_f").val(sumtotal);
			}    
		});
	});
});


</script>
<script  type="text/javascript">
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
	$(document).on('change','#mtcode', function(){
		var tcode = this.value;
		//to get ucs of selected distcrict
		if(tcode != 0) {
		  $.ajax({
				type: "POST",
				data: "tcode="+tcode,
				url: "<?php echo base_url(); ?>Ajax_red_rec/getUnC/",
				success: function(result){
					$('#muncode').html(result);
				}
			});
		}
		else{
			$('#muncode').html('');
			//it doesn't exist
		}						
	});	
	// <?php if(!$this->input->get('facode')){ ?>
	//$(document).on('change','#ticode', function(){
	$('#mvillage').on('blur' , function (){
		var uncode = $('#muncode').val();
		var uncode1 = $('#uuncode').val();
		if (uncode>0) 
		{
				$.ajax({
			type: "GET",
			data: "uncode="+uncode,
			url: "<?php echo base_url(); ?>Ajax_red_rec/generateCode",
			success: function(result){
				$('#mvcode').val(result);
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
				$('#mvcode').val(result);
			}
		});
		}
		
	});
	$(document).on('change', '#uncode', function(){
		var uncode = this.value;
		if(uncode != ""){
			$('#vcode').val('');
			$('#village_name').val('');
			// $('#population').val('');
			// $('#postal_address').val('');
		}		
	});
// $(function () {
			
//         $('#form').on('submit', function (e) {
//           e.preventDefault();
//           $.ajax({
//             type: 'post',
//              url: "<?php echo base_url();?>Villages/ajax_village_save",
//             data: $('form').serialize(),
//             success: function (data) {
//             		$("#village").html(data);
//             		$('#myModal').addClass('hide');
            		
//             		//$('#myModal').addClass('modal');   
            		      
                     
//             }
//           });
//         });
//       });
  	 //var modal = document.getElementById('myModal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closex")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
	
	$('#myModal').removeClass('hide');
	$('.x').val('');
	$('#myModal').trigger(':reset');
    modal.style.display = "block";
}

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


