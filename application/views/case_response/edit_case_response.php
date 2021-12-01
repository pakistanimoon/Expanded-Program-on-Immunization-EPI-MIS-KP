<div class="container bodycontainer">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading">Edit Outbreak Response</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>Case_response/save_edit_response">
					<table class="table table-bordered table-striped table-hover  mytable3">
						<tbody>
							<tr>
								<td><label>Tehsil</label></td>
								<td>
								<select name="tcode" class="form-control text-center" readonly >
										<option value="<?php echo $case_edit[0]['tcode'];?>"><?php echo get_Tehsil_Name($case_edit[0]['tcode']);?></option>
								</select> 											
								</td>
								<td><label>Union Council</label></td>
								<td>
								<select name="uncode" class="form-control text-center" readonly >
										<option value="<?php echo $case_edit[0]['uncode'];?>"><?php echo get_UC_Name($case_edit[0]['uncode']);?></option>
								</select>										
								</td>
								<td><label>Village</label></td>
								<td>
									<select name="vcode" class="form-control text-center" readonly >
										<option value="<?php echo $case_edit[0]['vcode'];?>"><?php echo get_Village_Name($case_edit[0]['vcode']);?></option>
								</select>
								</td>
									<td><label>Disease</label></td>
								<td>
									<input class="form-control text-center" readonly name="disease" maxlength="50" value="<?php echo $case_edit[0]['disease']?>" >												
								</td>
								
							</tr>
							<tr>
								<td><label>Date of Activity</label></td>
								<td>
									<input class="form-control text-center" readonly="" value="<?php echo $case_edit[0]['date_of_activity']?>"  name="date_of_activity">
								</td>
								<td><label>Age Group From</label></td>
								<td>
									<input class="form-control text-center" readonly="" value="<?php echo $case_edit[0]['age_group_from']?>"  name="age_group_from">
								</td>
								<td><label>Age Group To</label></td>
								<td>
									<input class="form-control text-center" readonly="" value="<?php echo $case_edit[0]['age_group_to']?>"  name="age_group_to">
								</td>
							</tr>
						</tbody>
					</table>
					<table   class="table table-bordered plan_table">
						<thead>
							<tr>
								<th rowspan="2" style="width: 15%;">All Vaccines List</th>
								<th colspan="2">0-11 M</th>
								<th colspan="2">12-23 M</th>
								<th colspan="2">&gt; Years</th>
								<th colspan="2">Total</th>
								<th colspan="1">T</th>								
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
							<?php $i=1;
									$rowcount=count($case_edit);
									foreach($case_edit as $case){ ?>
							<tr>								
								<td><input readonly="" name="vaccines[]" type="text" value="<?php echo $case['vaccines']?>"  class="form-control text-center numberclass vaccines calculation " ></td>
								<td><input name="0_11_m_m[]" type="text" value="<?php echo $case['0_11_m_m']?>"  class="form-control text-center numberclass 0_11_m_m calculation " ></td>
								<td><input name="0_11_m_f[]" type="text" value="<?php echo $case['0_11_m_f']?>" class="form-control text-center numberclass calculation 0_11_m_f" ></td>
								<td><input name="12_23_m_m[]" type="text" value="<?php echo $case['12_23_m_m']?>"  class="form-control text-center numberclass calculation 12_23_m_m" ></td>
								<td><input name="12_23_m_f[]" type="text" value="<?php echo $case['12_23_m_f']?>" class="form-control text-center numberclass calculation 12_23_m_f" ></td>
								<td><input name="years_m[]" type="text"  value="<?php echo $case['years_m']?>" class="form-control text-center numberclass calculation years_m" ></td>
								<td><input name="years_f[]" type="text" value="<?php echo $case['years_f']?>" class="form-control text-center numberclass calculation years_f" ></td>
								<td><input name="total_m[]" readonly="" type="text" value="<?php echo $case['total_m']?>" id="total_m" class="form-control text-center numberclass calculation total_m" ></td>
								<td><input name="total_f[]" readonly="" type="text" value="<?php echo $case['total_f']?>" class="form-control text-center numberclass calculation total_f" ></td>
								<td><input name="total_m_f[]" readonly="" type="text" value="<?php echo $case['total_m_f']?>" class="form-control text-center numberclass calculation total_m_f" ></td>						
								</tr>
								<?php $i++; } ?>
							</tbody>
							<tbody>
							<tr>
								<td>Total</td>
								<td><input name="total_one_to_m" id="total_one_to_m" value="<?php echo $case_edit[0]['total_one_to_m']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_one_to_f" id="total_one_to_f" value="<?php echo $case_edit[0]['total_one_to_f']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_twelve_to_m" id="total_twelve_to_m" value="<?php echo $case_edit[0]['total_twelve_to_m']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_twelve_to_f" id="total_twelve_to_f" value="<?php echo $case_edit[0]['total_twelve_to_f']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_year_m" id="total_year_m" value="<?php echo $case_edit[0]['total_year_m']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_year_f" id="total_year_f" value="<?php echo $case_edit[0]['total_year_f']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_mm" id="total_mm" value="<?php echo $case_edit[0]['total_mm']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="total_ff" id="total_ff" value="<?php echo $case_edit[0]['total_ff']?>" readonly="" class="form-control text-center numberclass calculation" ></td>
								<td><input name="t_m_f" id="t_m_f" value="<?php echo $case_edit[0]['t_m_f']?>" readonly="" class="form-control text-center numberclass calculation" ></td> 								
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="12">No Of Case</td>								
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="4">Reported through case based surveillance</td>
								<td colspan="4">Active search Cases</td>
								<td colspan="4">Epi linked Cases</td>
							</tr>
							<tr>
								<td colspan="4"><input name="reported_case_base_surveillance" type="text" value="<?php echo $case_edit[0]['reported_case_base_surveillance']?>"  class="form-control text-center numberclass" ></td>
								<td colspan="4"><input name="active_search_case" type="text" value="<?php echo $case_edit[0]['active_search_case']?>"  class="form-control text-center numberclass" ></td>
								<td colspan="4"><input name="epi_linked_case" type="text" value="<?php echo $case_edit[0]['epi_linked_case']?>"  class="form-control text-center numberclass" ></td>
							</tr>
							<tr style="background-color: #057140;color: white">
								<td colspan="4">No of blood speciment collected</td>
								<td colspan="4">No of Throat / Oral sample collected</td>
								<td colspan="4">Follow Up Visit</td>
							</tr>
							<tr>
								<td colspan="4"><input name="blood_speciment_collected" type="text" value="<?php echo $case_edit[0]['blood_speciment_collected']?>"  class="form-control text-center numberclass" ></td> 
								<td colspan="4"><input name="oral_swabs_collected" type="text" value="<?php echo $case_edit[0]['oral_swabs_collected']?>" class="form-control text-center numberclass" ></td>
								<td colspan="4"><input name="follow_up_visit" class="form-control dp" data-date-start-date="+1d" data-provide="datepicker" value="<?php echo $case_edit[0]['follow_up_visit']?>" id="" placeholder="YYYY-MM-DD"></td>
							</tr>					
						</tbody>
					</table>
					 <div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<button style="background: #008d4c;" type="submit" id="save" name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
														
							<a href="<?php echo base_url(); ?>Case-List" style="background:#008d4c;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>							
						</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
$(document).on('click','.minus', function()
{		
	$(".vaccines").change(function() {
        var status = $(this).val();
       // alert(status);
    });
		var currentRow=$(this).closest("tr");
		var text=currentRow.find("td:eq(0)").find('.vaccines option:selected' ).text();
		var value=currentRow.find("td:eq(0)").find('.vaccines option:selected' ).val();
		alert(text);
		if (text=='Select'&& status==value) {}
			else{
				$(".vaccines").append('<option value=' + value + '>' + text + '</option>');
			}
				//alert(xtext + ' ' + xvalue);
		//var optionValues = [];
		//$('#vaccines option').each(function() {
		/*	$( ".vaccines option:selected" ).val();
		var xx = $(this).val();
		alert(xx);
		console.log(xx);
		if (xx !== value) {
			$(".vaccines").append('<option value=' + value + '>' + text + '</option>');
		}
			else{
				
			}*/
		
		//});

		//$('#result').html(optionValues);				
    });
	$(document).on('change','.vaccines', function()
	{
		$currentSelected = $(this);		
		$selectedValue = $(this).val();
		$(".vaccines").each(function(index,elm)
		{
			$(this).not($currentSelected).find("option[value='"+$selectedValue+"']").remove();
		});
	});
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
	});
	function addRow(obj){
		var row = $(obj).closest("tr").clone(true);
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
		$(obj).closest("tr").after(row);//alert(row.index());
		$(obj).closest("tr").find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>');
		$('#trRow').find('tr:last').find('td:last').html('<button type="button" onclick="deleteRow(this)" class="minus"><i class="fa fa-minus-circle" aria-hidden="true"></i></button><button onclick="addRow(this)" id="addButton1" type="button" class="plus" style="background:#057140;"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>');
		reindexrows();
	}
	function reindexrows(){
		$('#trRow > tr').each(function(i,k){
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

