<script src="<?php echo base_url(); ?>includes/js/hfcr.js"></script>
<?php 

date_default_timezone_set('Asia/Karachi'); // CDT
$current_date = date('d-m-Y');
?>
<!--start of page content or body-->
<div class="container bodycontainer">  
	<div class="row">
		<div class="panel panel-primary">
			<?php if($this -> session -> flashdata('message')){  ?><div class="alert alert-success text-center " role="alert"><strong><?php echo $this -> session -> flashdata('message'); ?></strong></div> <?php } ?>
			<div class="panel-heading"><?php if(isset($formB_Result)){?> HF Consumption and Requisition Form <?php }else{ ?> HF Consumption and Requisition Form  <?php } ?></div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="<?php echo base_url(); ?>data_entry/form_B_Save">
					<?php if(isset($formB_Result)){ ?>
						<input type="hidden" name="edit" id="edit" value="edit" />
						<input type="hidden" name="id" id="id" value="<?php echo $formB_Result->id; ?>" />
					<?php } ?>
					<table class="table table-bordered   table-striped table-hover  mytable">
						<tr>
							<td><label style="margin-top: 7px;">Province</label></td>
							<td><input class="form-control" name="procode"  readonly="readonly" id="procode" placeholder="Khyber Pakhtunkhwa" type="text"></td>
							<td><label style="margin-top: 7px;">District</label></td>
							<td>
								<select id="distcode" name="distcode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
										<option value="<?php echo $formB_Result -> distcode; ?>"><?php echo get_District_Name($formB_Result -> distcode); ?></option>
									<?php }else{ getDistricts(false,$this -> session -> District); } ?>
								</select>
							</td>
							<td><label style="margin-top: 7px;">Date (MM/YY)</label></td>
							<td>
								<table style="width: 100%;">
									<tr>
										<td>
											<select name="month" id="month" class="form-control">
											<?php if(isset($formB_Result)){ ?> <option value="<?php echo $month; ?>"><?php echo monthname($month); ?></option> <?php }else{ getAllMonthsOptions(false); } ?>
											</select>
										</td>
										<td>
											<select name="year" id="year" class="form-control">
											<?php if(isset($formB_Result)){ ?> <option value="<?php echo $year; ?>"><?php echo $year; ?></option> <?php }else{ /* getAllYearsOptions(false) */ getAllYearsOptionsIncludingCurrent(false); } ?>
											</select>
										</td>
									</tr>
								</table>             	
							</td>
						</tr>
						<tr>
							<td><label style="margin-top: 7px;">Tehsil</label></td>
							<td>
								<select id="tcode" name="tcode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
										<option value="<?php echo $formB_Result -> tcode; ?>"><?php echo get_Tehsil_Name($formB_Result -> tcode); ?></option>
									<?php }else{ ?> 
									<?php getTehsils_options(false); } ?>
								</select>
							</td>
							<td><label style="margin-top: 7px;">UC</label></td>
							<td>
								<select id="uncode" name="uncode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
									<option value="<?php echo $formB_Result -> uncode; ?>"><?php echo get_UC_Name($formB_Result -> uncode); ?></option>
									<?php }else{ ?> 
									<?php getUCs_options(false); } ?>
								</select>
							</td>
							<!--start of page content or body-->
							<td><label style="margin-top: 7px;">Health Facility/Store</label></td>
							<td>
								<select id="facode" name="facode" class="form-control">
									<?php if(isset($formB_Result)){ ?>
									<option value="<?php echo $formB_Result -> facode; ?>"><?php echo get_Facility_Name($formB_Result -> facode); ?></option>
									<?php }else{ ?>
									<?php getFacilities_options(false); } ?>
								</select>
							</td>
							<!--start of page content or body-->
						</tr> 
					</table>
					<table class="table table-bordered table-condensed table-striped table-hover mytable">
						<thead>
							<tr>
								<th  rowspan="2">Products</th>
								<th  rowspan="2">Doses per Vial</th>
								<th>Opening Balance</th>
								<th>Received</th>
								<th>Children Vaccinated/<br>Doses Administered</th>
								<th>Vials<br>Used</th>
								<th>Unusable<br>Vials</th>
								<th>Closing<br>Balance</th>
							</tr>
							<tr>
								<th>Doses/Nos.</th>
								<th>Doses/Nos.</th>
								<th>Doses/Nos.</th>
								<th>Vials/Nos.</th>
								<th>Vials/Nos.</th>
								<th>Vials/Nos.</th>
							</tr>
							<tr style="background: white none repeat scroll 0% 0%; color: black;">
								<th></th>
								<th>A</th>
								<th>B</th>
								<th>C</th>
								<th>D</th>
								<th>E</th>
								<th>F</th>
								<th>G</th>
								<!--<th>H</th>
								<th>I</th>
								<th>J</th>-->
							</tr>
						</thead>
						<tbody id="myTable">
							<?php 
							$VaccineArray = array(
								'BCG'=> '20',
								'DIL BCG'=> '',
								'bOPV' => '20',
								'Pentavalent' => '01',
								'Pneumococcal (PCV10)' => '02',
								'Measles' => '10',
								'DIL Measles' => '',
								'TT ' => '10',
								'TT' => '20',
								'HBV (Birth dose)' => '10',
								'IPV' => '10',
								'IPV ' => '05',
								'Rota' => '',
								'AD Syringes 0.5 ml' => '',
								'AD Syringes 0.05 ml' => '',
								'Recon. Syringes (2 ml)' => '',
								'Recon. Syringes (5 ml)' => '',
								'Safety Boxes' => '',
								'Other' => ''
							); 
							$i=1;
							foreach($VaccineArray as $key=>$value){
								if($i==12){
									$i=19;
								}
								if($key=="Rota"){
									$i=18;
								}
								if($key=="AD Syringes 0.5 ml"){
									$i=12;
								}
							?>
								<tr class="vialused">
									<td style="padding-top:11px;"><?php echo $key; ?></td>
									<td value="<?php echo $value; ?>" class="ob" style="padding-top:11px;<?php if($value==''){echo "background-color:#eee;";} ?>"> <?php echo $value; ?></td>

									<td class="ob">
										<input readonly  class=" form-control numberclass" name="cr_r<?php echo $i; ?>_f1" id="cr_r<?php echo $i; ?>_f1" value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f1";  echo $formB_Result->$name; }else{ echo set_value("cr_r".$i."_f1");} ?>" type="text"><?php echo form_error("cr_r".$i."_f1"); ?>
									</td>

									<td class="ob">
										<input class=" form-control numberclass" name="cr_r<?php echo $i; ?>_f2" id="cr_r<?php echo $i; ?>_f2" value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f2"; if($formB_Result->$name != '0'){ echo $formB_Result->$name; }}else{ echo set_value("cr_r".$i."_f2");} ?>" type="text"><?php echo form_error("cr_r".$i."_f2"); ?>
									</td>

									<td class="ob">
										<input readonly class="form-control numberclass" name="cr_r<?php echo $i; ?>_f3" id="cr_r<?php echo $i; ?>_f3" type="text" <?php if($value=='' && $key!='DIL BCG' && $key!='DIL Measles'){echo 'readonly="readonly"';}else{ ?>value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f3"; if($formB_Result->$name != '0'){ echo $formB_Result->$name; }}else{ echo set_value("cr_r".$i."_f3");} ?>"<?php } ?>><?php echo form_error("cr_r".$i."_f3"); ?>
									</td>

									<td class="ob test">
										<input class=" form-control numberclass" name="cr_r<?php echo $i; ?>_f4" id="cr_r<?php echo $i; ?>_f4" value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f4"; if($formB_Result->$name != '0'){ echo $formB_Result->$name; }}else{ echo set_value("cr_r".$i."_f4");} ?>" type="text"><?php echo form_error("cr_r".$i."_f4"); ?>
									</td>

									<td class="ob">
										<input class=" form-control numberclass" name="cr_r<?php echo $i; ?>_f5" id="cr_r<?php echo $i; ?>_f5" value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f5"; if($formB_Result->$name != '0'){ echo $formB_Result->$name; }}else{ echo set_value("cr_r".$i."_f5");} ?>" type="text"><?php echo form_error("cr_r".$i."_f5"); ?>
									</td>
									<td>
										<input class=" form-control numberclass" name="cr_r<?php echo $i; ?>_f6" id="cr_r<?php echo $i; ?>_f6" readonly  value="<?php if(isset($formB_Result)){ $name="cr_r".$i."_f6"; if($formB_Result->$name != '0'){ echo $formB_Result->$name; }}else{ echo set_value("cr_r".$i."_f6");} ?>" type="text" ><?php echo form_error("cr_r".$i."_f6"); ?>
									</td>
								</tr>
							<?php 
								$i++; 
							} 
						?>
						</tbody>
					</table>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-bordered table-striped">
								<tr>
									<td><label style="margin-top: 7px;">Prepared by</label></td>
									<td><input class="form-control" name="prepare_by" id="prepare_by"  value="<?php if(isset($formB_Result)){ echo $formB_Result->prepare_by; } ?>" type="text"></td>
								   
									<td><label style="margin-top: 7px;">Medical Officer / In-charge Name</label></td>
									<td><input class="form-control" name="incharge" id="incharge" value="<?php if(isset($formB_Result)){ echo $formB_Result->incharge; } ?>" type="text"></td>
								  
									<td><label style="margin-top: 7px;">Date</label></td>
									<td><input class="form-control" readonly="readonly" name="date_submitted" id="date_submitted" value="<?php if(isset($formB_Result)){ if($formB_Result->date_submitted!= '1969-12-31'){ echo date('d-m-Y',strtotime($formB_Result->date_submitted)); }else{ echo $current_date; } } else{ echo $current_date; }?>" type="text"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="row">
						<hr>
						<div style="text-align: right;" class="col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6 col-xs-6 col-xs-offset-6">
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" id="save"  name="is_temp_saved" value="1" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Save Form  </button>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" type="submit" name="is_temp_saved" value="0" class="btn btn-primary btn-md" role="button"><i class="fa fa-floppy-o "></i> Submit Form  </button>
							<button style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md" type="reset"><i class="fa fa-repeat"></i> Reset Form </button>
							<a onclick="history.go(-1);" style="background: rgb(22, 108, 29) none repeat scroll 0% 0%;" class="btn btn-primary btn-md"><i class="fa fa-times"></i> Cancel </a>
						</div>
					</div>
				</form>
			</div> <!--end of panel body-->
		</div> <!--end of panel panel-primary-->
	</div><!--end of row-->
</div><!--End of page content or body-->
<script type="text/javascript">
$(document).ready(function(){
	$(document).on("keyup","#cr_r1_f4",function(e) {
		var row = $(this).val();
		$("#"+"cr_r14_f4").val(row);
	});
	$('.gp').on("keyup", function(){
		var row = $(this).parent().parent().index();
		var colC = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(3) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(3) input').val());
		var colB = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(2) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(2) input').val());
		var colE = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(5) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(5) input').val());
		var colF = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(6) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(6) input').val());
		//alert(row);
		var a1 = colB + colC;
		if(row == 0 || row == 2 || row == 8){
			a1 = a1/20;
		}else if(row == 4){
			a1 = a1/2;
		}else if(row == 11){
			a1 = a1/5;
		}else if(row == 5 || row == 7 || row == 9 || row == 10){
			a1 = a1/10;
		}else{}
		var a2 = colE + colF;
		var closing_balance = Math.round(a1 - a2);
		//alert(closing_balance);
		if(closing_balance < 0 ){
			$('#myTable tr:eq('+row+') td:eq(7) input').css("background-color","#F54F4F");
			$('#myTable tr:eq('+row+') td:eq(7) input').css("color","#FFF");
			$('#myTable tr:eq('+row+') td:eq(7) input').val(closing_balance);
			//alert("Used/Unused Vials must equal or less then opening + receive quantity");
		}
		else{
			$('#myTable tr:eq('+row+') td:eq(7) input').css("background-color","#FFF");
			$('#myTable tr:eq('+row+') td:eq(7) input').css("color","#000");
			$('#myTable tr:eq('+row+') td:eq(7) input').val(closing_balance);
			
		}
		var colG = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(7) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(7) input').val());
		var colH = isNaN(parseInt($('#myTable tr:eq('+row+') td:eq(8) input').val())) ? 0 : parseInt($('#myTable tr:eq('+row+') td:eq(8) input').val());
		if(colH > colG && colG >= 0){
			var v = colH - colG;
				$('#myTable tr:eq('+row+') td:eq(9) input').val(v);
		}
	});
	/* 	 */
	function set_children_vacc(){
		var month = $('#month').val();
		var year = $('#year').val();
		var facode = $('#facode').val();
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {month:month,year:year,facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getEPIVaccinationBalance",
				success: function(result){
					var resultarray = JSON.parse(result);
					
					var BCG = parseInt(resultarray['cri_r1_f1']) + parseInt(resultarray['cri_r2_f1']) + parseInt(resultarray['cri_r3_f1']) + parseInt(resultarray['cri_r4_f1']) + parseInt(resultarray['cri_r5_f1']) + parseInt(resultarray['cri_r6_f1']) + parseInt(resultarray['cri_r7_f1']) + parseInt(resultarray['cri_r8_f1']) + parseInt(resultarray['cri_r9_f1']) + parseInt(resultarray['cri_r10_f1']) + parseInt(resultarray['cri_r11_f1']) + parseInt(resultarray['cri_r12_f1']) + parseInt(resultarray['cri_r13_f1']) + parseInt(resultarray['cri_r14_f1']) + parseInt(resultarray['cri_r15_f1']) + parseInt(resultarray['cri_r16_f1']) + parseInt(resultarray['cri_r17_f1']) + parseInt(resultarray['cri_r18_f1']) + parseInt(resultarray['cri_r19_f1']) + parseInt(resultarray['cri_r20_f1']) + parseInt(resultarray['cri_r21_f1']) + parseInt(resultarray['cri_r22_f1']) + parseInt(resultarray['cri_r23_f1']) + parseInt(resultarray['cri_r24_f1']) + parseInt(resultarray['oui_r1_f1']) + parseInt(resultarray['oui_r2_f1']) + parseInt(resultarray['oui_r3_f1']) + parseInt(resultarray['oui_r4_f1']) + parseInt(resultarray['oui_r5_f1']) + parseInt(resultarray['oui_r6_f1']) + parseInt(resultarray['oui_r7_f1']) + parseInt(resultarray['oui_r8_f1']) + parseInt(resultarray['oui_r9_f1']) + parseInt(resultarray['oui_r10_f1']) + parseInt(resultarray['oui_r11_f1']) + parseInt(resultarray['oui_r12_f1']) + parseInt(resultarray['oui_r13_f1']) + parseInt(resultarray['oui_r14_f1']) + parseInt(resultarray['oui_r15_f1']) + parseInt(resultarray['oui_r16_f1']) + parseInt(resultarray['oui_r17_f1']) + parseInt(resultarray['oui_r18_f1']) + parseInt(resultarray['oui_r19_f1']) + parseInt(resultarray['oui_r20_f1']) + parseInt(resultarray['oui_r21_f1']) + parseInt(resultarray['oui_r22_f1']) + parseInt(resultarray['oui_r23_f1']) + parseInt(resultarray['oui_r24_f1']) + parseInt(resultarray['od_r1_f1']) + parseInt(resultarray['od_r2_f1']) + parseInt(resultarray['od_r3_f1']) + parseInt(resultarray['od_r4_f1']) + parseInt(resultarray['od_r5_f1']) + parseInt(resultarray['od_r6_f1']) + parseInt(resultarray['od_r7_f1']) + parseInt(resultarray['od_r8_f1']) + parseInt(resultarray['od_r9_f1']) + parseInt(resultarray['od_r10_f1']) + parseInt(resultarray['od_r11_f1']) + parseInt(resultarray['od_r12_f1']) + parseInt(resultarray['od_r13_f1']) + parseInt(resultarray['od_r14_f1']) + parseInt(resultarray['od_r15_f1']) + parseInt(resultarray['od_r16_f1']) + parseInt(resultarray['od_r17_f1']) + parseInt(resultarray['od_r18_f1']) + parseInt(resultarray['od_r19_f1']) + parseInt(resultarray['od_r20_f1']) + parseInt(resultarray['od_r21_f1']) + parseInt(resultarray['od_r22_f1']) + parseInt(resultarray['od_r23_f1']) + parseInt(resultarray['od_r24_f1']);
					alert(parseInt(resultarray['oui_r1_f1']) + parseInt(resultarray['oui_r2_f1']) + parseInt(resultarray['oui_r3_f1']) + parseInt(resultarray['oui_r4_f1']) + parseInt(resultarray['oui_r5_f1']) + parseInt(resultarray['oui_r6_f1']) + parseInt(resultarray['oui_r7_f1']) + parseInt(resultarray['oui_r8_f1']) + parseInt(resultarray['oui_r9_f1']) + parseInt(resultarray['oui_r10_f1']) + parseInt(resultarray['oui_r11_f1']) + parseInt(resultarray['oui_r12_f1']) + parseInt(resultarray['oui_r13_f1']) + parseInt(resultarray['oui_r14_f1']) + parseInt(resultarray['oui_r15_f1']) + parseInt(resultarray['oui_r16_f1']) + parseInt(resultarray['oui_r17_f1']) + parseInt(resultarray['oui_r18_f1']) + parseInt(resultarray['oui_r19_f1']) + parseInt(resultarray['oui_r20_f1']) + parseInt(resultarray['oui_r21_f1']) + parseInt(resultarray['oui_r22_f1']) + parseInt(resultarray['oui_r23_f1']) + parseInt(resultarray['oui_r24_f1']) + parseInt(resultarray['od_r1_f1']) + parseInt(resultarray['od_r2_f1']) + parseInt(resultarray['od_r3_f1']) + parseInt(resultarray['od_r4_f1']) + parseInt(resultarray['od_r5_f1']) + parseInt(resultarray['od_r6_f1']) + parseInt(resultarray['od_r7_f1']) + parseInt(resultarray['od_r8_f1']) + parseInt(resultarray['od_r9_f1']) + parseInt(resultarray['od_r10_f1']) + parseInt(resultarray['od_r11_f1']) + parseInt(resultarray['od_r12_f1']) + parseInt(resultarray['od_r13_f1']) + parseInt(resultarray['od_r14_f1']) + parseInt(resultarray['od_r15_f1']) + parseInt(resultarray['od_r16_f1']) + parseInt(resultarray['od_r17_f1']) + parseInt(resultarray['od_r18_f1']) + parseInt(resultarray['od_r19_f1']) + parseInt(resultarray['od_r20_f1']) + parseInt(resultarray['od_r21_f1']) + parseInt(resultarray['od_r22_f1']) + parseInt(resultarray['od_r23_f1']) + parseInt(resultarray['od_r24_f1']));
					var bOPV = parseInt(resultarray['cri_r1_f3']) + parseInt(resultarray['cri_r2_f3']) + parseInt(resultarray['cri_r3_f3']) + parseInt(resultarray['cri_r4_f3']) + parseInt(resultarray['cri_r5_f3']) + parseInt(resultarray['cri_r6_f3']) + parseInt(resultarray['cri_r7_f3']) + parseInt(resultarray['cri_r8_f3']) + parseInt(resultarray['cri_r9_f3']) + parseInt(resultarray['cri_r10_f3']) + parseInt(resultarray['cri_r11_f3']) + parseInt(resultarray['cri_r12_f3']) + parseInt(resultarray['cri_r13_f3']) + parseInt(resultarray['cri_r14_f3']) + parseInt(resultarray['cri_r15_f3']) + parseInt(resultarray['cri_r16_f3']) + parseInt(resultarray['cri_r17_f3']) + parseInt(resultarray['cri_r18_f3']) + parseInt(resultarray['cri_r19_f3']) + parseInt(resultarray['cri_r20_f3']) + parseInt(resultarray['cri_r21_f3']) + parseInt(resultarray['cri_r22_f3']) + parseInt(resultarray['cri_r23_f3']) + parseInt(resultarray['cri_r24_f3']) + parseInt(resultarray['cri_r1_f4']) + parseInt(resultarray['cri_r2_f4']) + parseInt(resultarray['cri_r3_f4']) + parseInt(resultarray['cri_r4_f4']) + parseInt(resultarray['cri_r5_f4']) + parseInt(resultarray['cri_r6_f4']) + parseInt(resultarray['cri_r7_f4']) + parseInt(resultarray['cri_r8_f4']) + parseInt(resultarray['cri_r9_f4']) + parseInt(resultarray['cri_r10_f4']) + parseInt(resultarray['cri_r11_f4']) + parseInt(resultarray['cri_r12_f4']) + parseInt(resultarray['cri_r13_f4']) + parseInt(resultarray['cri_r14_f4']) + parseInt(resultarray['cri_r15_f4']) + parseInt(resultarray['cri_r16_f4']) + parseInt(resultarray['cri_r17_f4']) + parseInt(resultarray['cri_r18_f4']) + parseInt(resultarray['cri_r19_f4']) + parseInt(resultarray['cri_r20_f4']) + parseInt(resultarray['cri_r21_f4']) + parseInt(resultarray['cri_r22_f4']) + parseInt(resultarray['cri_r23_f4']) + parseInt(resultarray['cri_r24_f4']) + parseInt(resultarray['cri_r1_f5']) + parseInt(resultarray['cri_r2_f5']) + parseInt(resultarray['cri_r3_f5']) + parseInt(resultarray['cri_r4_f5']) + parseInt(resultarray['cri_r5_f5']) + parseInt(resultarray['cri_r6_f5']) + parseInt(resultarray['cri_r7_f5']) + parseInt(resultarray['cri_r8_f5']) + parseInt(resultarray['cri_r9_f5']) + parseInt(resultarray['cri_r10_f5']) + parseInt(resultarray['cri_r11_f5']) + parseInt(resultarray['cri_r12_f5']) + parseInt(resultarray['cri_r13_f5']) + parseInt(resultarray['cri_r14_f5']) + parseInt(resultarray['cri_r15_f5']) + parseInt(resultarray['cri_r16_f5']) + parseInt(resultarray['cri_r17_f5']) + parseInt(resultarray['cri_r18_f5']) + parseInt(resultarray['cri_r19_f5']) + parseInt(resultarray['cri_r20_f5']) + parseInt(resultarray['cri_r21_f5']) + parseInt(resultarray['cri_r22_f5']) + parseInt(resultarray['cri_r23_f5']) + parseInt(resultarray['cri_r24_f5']) + parseInt(resultarray['cri_r1_f6']) + parseInt(resultarray['cri_r2_f6']) + parseInt(resultarray['cri_r3_f6']) + parseInt(resultarray['cri_r4_f6']) + parseInt(resultarray['cri_r5_f6']) + parseInt(resultarray['cri_r6_f6']) + parseInt(resultarray['cri_r7_f6']) + parseInt(resultarray['cri_r8_f6']) + parseInt(resultarray['cri_r9_f6']) + parseInt(resultarray['cri_r10_f6']) + parseInt(resultarray['cri_r11_f6']) + parseInt(resultarray['cri_r12_f6']) + parseInt(resultarray['cri_r13_f6']) + parseInt(resultarray['cri_r14_f6']) + parseInt(resultarray['cri_r15_f6']) + parseInt(resultarray['cri_r16_f6']) + parseInt(resultarray['cri_r17_f6']) + parseInt(resultarray['cri_r18_f6']) + parseInt(resultarray['cri_r19_f6']) + parseInt(resultarray['cri_r20_f6']) + parseInt(resultarray['cri_r21_f6']) + parseInt(resultarray['cri_r22_f6']) + parseInt(resultarray['cri_r23_f6']) + parseInt(resultarray['cri_r24_f6']) + parseInt(resultarray['oui_r1_f3']) + parseInt(resultarray['oui_r2_f3']) + parseInt(resultarray['oui_r3_f3']) + parseInt(resultarray['oui_r4_f3']) + parseInt(resultarray['oui_r5_f3']) + parseInt(resultarray['oui_r6_f3']) + parseInt(resultarray['oui_r7_f3']) + parseInt(resultarray['oui_r8_f3']) + parseInt(resultarray['oui_r9_f3']) + parseInt(resultarray['oui_r10_f3']) + parseInt(resultarray['oui_r11_f3']) + parseInt(resultarray['oui_r12_f3']) + parseInt(resultarray['oui_r13_f3']) + parseInt(resultarray['oui_r14_f3']) + parseInt(resultarray['oui_r15_f3']) + parseInt(resultarray['oui_r16_f3']) + parseInt(resultarray['oui_r17_f3']) + parseInt(resultarray['oui_r18_f3']) + parseInt(resultarray['oui_r19_f3']) + parseInt(resultarray['oui_r20_f3']) + parseInt(resultarray['oui_r21_f3']) + parseInt(resultarray['oui_r22_f3']) + parseInt(resultarray['oui_r23_f3']) + parseInt(resultarray['oui_r24_f3']) + parseInt(resultarray['oui_r1_f4']) + parseInt(resultarray['oui_r2_f4']) + parseInt(resultarray['oui_r3_f4']) + parseInt(resultarray['oui_r4_f4']) + parseInt(resultarray['oui_r5_f4']) + parseInt(resultarray['oui_r6_f4']) + parseInt(resultarray['oui_r7_f4']) + parseInt(resultarray['oui_r8_f4']) + parseInt(resultarray['oui_r9_f4']) + parseInt(resultarray['oui_r10_f4']) + parseInt(resultarray['oui_r11_f4']) + parseInt(resultarray['oui_r12_f4']) + parseInt(resultarray['oui_r13_f4']) + parseInt(resultarray['oui_r14_f4']) + parseInt(resultarray['oui_r15_f4']) + parseInt(resultarray['oui_r16_f4']) + parseInt(resultarray['oui_r17_f4']) + parseInt(resultarray['oui_r18_f4']) + parseInt(resultarray['oui_r19_f4']) + parseInt(resultarray['oui_r20_f4']) + parseInt(resultarray['oui_r21_f4']) + parseInt(resultarray['oui_r22_f4']) + parseInt(resultarray['oui_r23_f4']) + parseInt(resultarray['oui_r24_f4']) + parseInt(resultarray['oui_r1_f5']) + parseInt(resultarray['oui_r2_f5']) + parseInt(resultarray['oui_r3_f5']) + parseInt(resultarray['oui_r4_f5']) + parseInt(resultarray['oui_r5_f5']) + parseInt(resultarray['oui_r6_f5']) + parseInt(resultarray['oui_r7_f5']) + parseInt(resultarray['oui_r8_f5']) + parseInt(resultarray['oui_r9_f5']) + parseInt(resultarray['oui_r10_f5']) + parseInt(resultarray['oui_r11_f5']) + parseInt(resultarray['oui_r12_f5']) + parseInt(resultarray['oui_r13_f5']) + parseInt(resultarray['oui_r14_f5']) + parseInt(resultarray['oui_r15_f5']) + parseInt(resultarray['oui_r16_f5']) + parseInt(resultarray['oui_r17_f5']) + parseInt(resultarray['oui_r18_f5']) + parseInt(resultarray['oui_r19_f5']) + parseInt(resultarray['oui_r20_f5']) + parseInt(resultarray['oui_r21_f5']) + parseInt(resultarray['oui_r22_f5']) + parseInt(resultarray['oui_r23_f5']) + parseInt(resultarray['oui_r24_f5']) + parseInt(resultarray['oui_r1_f6']) + parseInt(resultarray['oui_r2_f6']) + parseInt(resultarray['oui_r3_f6']) + parseInt(resultarray['oui_r4_f6']) + parseInt(resultarray['oui_r5_f6']) + parseInt(resultarray['oui_r6_f6']) + parseInt(resultarray['oui_r7_f6']) + parseInt(resultarray['oui_r8_f6']) + parseInt(resultarray['oui_r9_f6']) + parseInt(resultarray['oui_r10_f6']) + parseInt(resultarray['oui_r11_f6']) + parseInt(resultarray['oui_r12_f6']) + parseInt(resultarray['oui_r13_f6']) + parseInt(resultarray['oui_r14_f6']) + parseInt(resultarray['oui_r15_f6']) + parseInt(resultarray['oui_r16_f6']) + parseInt(resultarray['oui_r17_f6']) + parseInt(resultarray['oui_r18_f6']) + parseInt(resultarray['oui_r19_f6']) + parseInt(resultarray['oui_r20_f6']) + parseInt(resultarray['oui_r21_f6']) + parseInt(resultarray['oui_r22_f6']) + parseInt(resultarray['oui_r23_f6']) + parseInt(resultarray['oui_r24_f6']) + parseInt(resultarray['od_r1_f3']) + parseInt(resultarray['od_r2_f3']) + parseInt(resultarray['od_r3_f3']) + parseInt(resultarray['od_r4_f3']) + parseInt(resultarray['od_r5_f3']) + parseInt(resultarray['od_r6_f3']) + parseInt(resultarray['od_r7_f3']) + parseInt(resultarray['od_r8_f3']) + parseInt(resultarray['od_r9_f3']) + parseInt(resultarray['od_r10_f3']) + parseInt(resultarray['od_r11_f3']) + parseInt(resultarray['od_r12_f3']) + parseInt(resultarray['od_r13_f3']) + parseInt(resultarray['od_r14_f3']) + parseInt(resultarray['od_r15_f3']) + parseInt(resultarray['od_r16_f3']) + parseInt(resultarray['od_r17_f3']) + parseInt(resultarray['od_r18_f3']) + parseInt(resultarray['od_r19_f3']) + parseInt(resultarray['od_r20_f3']) + parseInt(resultarray['od_r21_f3']) + parseInt(resultarray['od_r22_f3']) + parseInt(resultarray['od_r23_f3']) + parseInt(resultarray['od_r24_f3']) + parseInt(resultarray['od_r1_f4']) + parseInt(resultarray['od_r2_f4']) + parseInt(resultarray['od_r3_f4']) + parseInt(resultarray['od_r4_f4']) + parseInt(resultarray['od_r5_f4']) + parseInt(resultarray['od_r6_f4']) + parseInt(resultarray['od_r7_f4']) + parseInt(resultarray['od_r8_f4']) + parseInt(resultarray['od_r9_f4']) + parseInt(resultarray['od_r10_f4']) + parseInt(resultarray['od_r11_f4']) + parseInt(resultarray['od_r12_f4']) + parseInt(resultarray['od_r13_f4']) + parseInt(resultarray['od_r14_f4']) + parseInt(resultarray['od_r15_f4']) + parseInt(resultarray['od_r16_f4']) + parseInt(resultarray['od_r17_f4']) + parseInt(resultarray['od_r18_f4']) + parseInt(resultarray['od_r19_f4']) + parseInt(resultarray['od_r20_f4']) + parseInt(resultarray['od_r21_f4']) + parseInt(resultarray['od_r22_f4']) + parseInt(resultarray['od_r23_f4']) + parseInt(resultarray['od_r24_f4']) + parseInt(resultarray['od_r1_f5']) + parseInt(resultarray['od_r2_f5']) + parseInt(resultarray['od_r3_f5']) + parseInt(resultarray['od_r4_f5']) + parseInt(resultarray['od_r5_f5']) + parseInt(resultarray['od_r6_f5']) + parseInt(resultarray['od_r7_f5']) + parseInt(resultarray['od_r8_f5']) + parseInt(resultarray['od_r9_f5']) + parseInt(resultarray['od_r10_f5']) + parseInt(resultarray['od_r11_f5']) + parseInt(resultarray['od_r12_f5']) + parseInt(resultarray['od_r13_f5']) + parseInt(resultarray['od_r14_f5']) + parseInt(resultarray['od_r15_f5']) + parseInt(resultarray['od_r16_f5']) + parseInt(resultarray['od_r17_f5']) + parseInt(resultarray['od_r18_f5']) + parseInt(resultarray['od_r19_f5']) + parseInt(resultarray['od_r20_f5']) + parseInt(resultarray['od_r21_f5']) + parseInt(resultarray['od_r22_f5']) + parseInt(resultarray['od_r23_f5']) + parseInt(resultarray['od_r24_f5']) + parseInt(resultarray['od_r1_f6']) + parseInt(resultarray['od_r2_f6']) + parseInt(resultarray['od_r3_f6']) + parseInt(resultarray['od_r4_f6']) + parseInt(resultarray['od_r5_f6']) + parseInt(resultarray['od_r6_f6']) + parseInt(resultarray['od_r7_f6']) + parseInt(resultarray['od_r8_f6']) + parseInt(resultarray['od_r9_f6']) + parseInt(resultarray['od_r10_f6']) + parseInt(resultarray['od_r11_f6']) + parseInt(resultarray['od_r12_f6']) + parseInt(resultarray['od_r13_f6']) + parseInt(resultarray['od_r14_f6']) + parseInt(resultarray['od_r15_f6']) + parseInt(resultarray['od_r16_f6']) + parseInt(resultarray['od_r17_f6']) + parseInt(resultarray['od_r18_f6']) + parseInt(resultarray['od_r19_f6']) + parseInt(resultarray['od_r20_f6']) + parseInt(resultarray['od_r21_f6']) + parseInt(resultarray['od_r22_f6']) + parseInt(resultarray['od_r23_f6']) + parseInt(resultarray['od_r24_f6']);
					var Pentavalent = parseInt(resultarray['cri_r1_f7']) + parseInt(resultarray['cri_r2_f7']) + parseInt(resultarray['cri_r3_f7']) + parseInt(resultarray['cri_r4_f7']) + parseInt(resultarray['cri_r5_f7']) + parseInt(resultarray['cri_r6_f7']) + parseInt(resultarray['cri_r7_f7']) + parseInt(resultarray['cri_r8_f7']) + parseInt(resultarray['cri_r9_f7']) + parseInt(resultarray['cri_r10_f7']) + parseInt(resultarray['cri_r11_f7']) + parseInt(resultarray['cri_r12_f7']) + parseInt(resultarray['cri_r13_f7']) + parseInt(resultarray['cri_r14_f7']) + parseInt(resultarray['cri_r15_f7']) + parseInt(resultarray['cri_r16_f7']) + parseInt(resultarray['cri_r17_f7']) + parseInt(resultarray['cri_r18_f7']) + parseInt(resultarray['cri_r19_f7']) + parseInt(resultarray['cri_r20_f7']) + parseInt(resultarray['cri_r21_f7']) + parseInt(resultarray['cri_r22_f7']) + parseInt(resultarray['cri_r23_f7']) + parseInt(resultarray['cri_r24_f7']) + parseInt(resultarray['cri_r1_f8']) + parseInt(resultarray['cri_r2_f8']) + parseInt(resultarray['cri_r3_f8']) + parseInt(resultarray['cri_r4_f8']) + parseInt(resultarray['cri_r5_f8']) + parseInt(resultarray['cri_r6_f8']) + parseInt(resultarray['cri_r7_f8']) + parseInt(resultarray['cri_r8_f8']) + parseInt(resultarray['cri_r9_f8']) + parseInt(resultarray['cri_r10_f8']) + parseInt(resultarray['cri_r11_f8']) + parseInt(resultarray['cri_r12_f8']) + parseInt(resultarray['cri_r13_f8']) + parseInt(resultarray['cri_r14_f8']) + parseInt(resultarray['cri_r15_f8']) + parseInt(resultarray['cri_r16_f8']) + parseInt(resultarray['cri_r17_f8']) + parseInt(resultarray['cri_r18_f8']) + parseInt(resultarray['cri_r19_f8']) + parseInt(resultarray['cri_r20_f8']) + parseInt(resultarray['cri_r21_f8']) + parseInt(resultarray['cri_r22_f8']) + parseInt(resultarray['cri_r23_f8']) + parseInt(resultarray['cri_r24_f8']) + parseInt(resultarray['cri_r1_f9']) + parseInt(resultarray['cri_r2_f9']) + parseInt(resultarray['cri_r3_f9']) + parseInt(resultarray['cri_r4_f9']) + parseInt(resultarray['cri_r5_f9']) + parseInt(resultarray['cri_r6_f9']) + parseInt(resultarray['cri_r7_f9']) + parseInt(resultarray['cri_r8_f9']) + parseInt(resultarray['cri_r9_f9']) + parseInt(resultarray['cri_r10_f9']) + parseInt(resultarray['cri_r11_f9']) + parseInt(resultarray['cri_r12_f9']) + parseInt(resultarray['cri_r13_f9']) + parseInt(resultarray['cri_r14_f9']) + parseInt(resultarray['cri_r15_f9']) + parseInt(resultarray['cri_r16_f9']) + parseInt(resultarray['cri_r17_f9']) + parseInt(resultarray['cri_r18_f9']) + parseInt(resultarray['cri_r19_f9']) + parseInt(resultarray['cri_r20_f9']) + parseInt(resultarray['cri_r21_f9']) + parseInt(resultarray['cri_r22_f9']) + parseInt(resultarray['cri_r23_f9']) + parseInt(resultarray['cri_r24_f9']) + parseInt(resultarray['oui_r1_f7']) + parseInt(resultarray['oui_r2_f7']) + parseInt(resultarray['oui_r3_f7']) + parseInt(resultarray['oui_r4_f7']) + parseInt(resultarray['oui_r5_f7']) + parseInt(resultarray['oui_r6_f7']) + parseInt(resultarray['oui_r7_f7']) + parseInt(resultarray['oui_r8_f7']) + parseInt(resultarray['oui_r9_f7']) + parseInt(resultarray['oui_r10_f7']) + parseInt(resultarray['oui_r11_f7']) + parseInt(resultarray['oui_r12_f7']) + parseInt(resultarray['oui_r13_f7']) + parseInt(resultarray['oui_r14_f7']) + parseInt(resultarray['oui_r15_f7']) + parseInt(resultarray['oui_r16_f7']) + parseInt(resultarray['oui_r17_f7']) + parseInt(resultarray['oui_r18_f7']) + parseInt(resultarray['oui_r19_f7']) + parseInt(resultarray['oui_r20_f7']) + parseInt(resultarray['oui_r21_f7']) + parseInt(resultarray['oui_r22_f7']) + parseInt(resultarray['oui_r23_f7']) + parseInt(resultarray['oui_r24_f7']) + parseInt(resultarray['oui_r1_f8']) + parseInt(resultarray['oui_r2_f8']) + parseInt(resultarray['oui_r3_f8']) + parseInt(resultarray['oui_r4_f8']) + parseInt(resultarray['oui_r5_f8']) + parseInt(resultarray['oui_r6_f8']) + parseInt(resultarray['oui_r7_f8']) + parseInt(resultarray['oui_r8_f8']) + parseInt(resultarray['oui_r9_f8']) + parseInt(resultarray['oui_r10_f8']) + parseInt(resultarray['oui_r11_f8']) + parseInt(resultarray['oui_r12_f8']) + parseInt(resultarray['oui_r13_f8']) + parseInt(resultarray['oui_r14_f8']) + parseInt(resultarray['oui_r15_f8']) + parseInt(resultarray['oui_r16_f8']) + parseInt(resultarray['oui_r17_f8']) + parseInt(resultarray['oui_r18_f8']) + parseInt(resultarray['oui_r19_f8']) + parseInt(resultarray['oui_r20_f8']) + parseInt(resultarray['oui_r21_f8']) + parseInt(resultarray['oui_r22_f8']) + parseInt(resultarray['oui_r23_f8']) + parseInt(resultarray['oui_r24_f8']) + parseInt(resultarray['oui_r1_f9']) + parseInt(resultarray['oui_r2_f9']) + parseInt(resultarray['oui_r3_f9']) + parseInt(resultarray['oui_r4_f9']) + parseInt(resultarray['oui_r5_f9']) + parseInt(resultarray['oui_r6_f9']) + parseInt(resultarray['oui_r7_f9']) + parseInt(resultarray['oui_r8_f9']) + parseInt(resultarray['oui_r9_f9']) + parseInt(resultarray['oui_r10_f9']) + parseInt(resultarray['oui_r11_f9']) + parseInt(resultarray['oui_r12_f9']) + parseInt(resultarray['oui_r13_f9']) + parseInt(resultarray['oui_r14_f9']) + parseInt(resultarray['oui_r15_f9']) + parseInt(resultarray['oui_r16_f9']) + parseInt(resultarray['oui_r17_f9']) + parseInt(resultarray['oui_r18_f9']) + parseInt(resultarray['oui_r19_f9']) + parseInt(resultarray['oui_r20_f9']) + parseInt(resultarray['oui_r21_f9']) + parseInt(resultarray['oui_r22_f9']) + parseInt(resultarray['oui_r23_f9']) + parseInt(resultarray['oui_r24_f9']) + parseInt(resultarray['od_r1_f7']) + parseInt(resultarray['od_r2_f7']) + parseInt(resultarray['od_r3_f7']) + parseInt(resultarray['od_r4_f7']) + parseInt(resultarray['od_r5_f7']) + parseInt(resultarray['od_r6_f7']) + parseInt(resultarray['od_r7_f7']) + parseInt(resultarray['od_r8_f7']) + parseInt(resultarray['od_r9_f7']) + parseInt(resultarray['od_r10_f7']) + parseInt(resultarray['od_r11_f7']) + parseInt(resultarray['od_r12_f7']) + parseInt(resultarray['od_r13_f7']) + parseInt(resultarray['od_r14_f7']) + parseInt(resultarray['od_r15_f7']) + parseInt(resultarray['od_r16_f7']) + parseInt(resultarray['od_r17_f7']) + parseInt(resultarray['od_r18_f7']) + parseInt(resultarray['od_r19_f7']) + parseInt(resultarray['od_r20_f7']) + parseInt(resultarray['od_r21_f7']) + parseInt(resultarray['od_r22_f7']) + parseInt(resultarray['od_r23_f7']) + parseInt(resultarray['od_r24_f7']) + parseInt(resultarray['od_r1_f8']) + parseInt(resultarray['od_r2_f8']) + parseInt(resultarray['od_r3_f8']) + parseInt(resultarray['od_r4_f8']) + parseInt(resultarray['od_r5_f8']) + parseInt(resultarray['od_r6_f8']) + parseInt(resultarray['od_r7_f8']) + parseInt(resultarray['od_r8_f8']) + parseInt(resultarray['od_r9_f8']) + parseInt(resultarray['od_r10_f8']) + parseInt(resultarray['od_r11_f8']) + parseInt(resultarray['od_r12_f8']) + parseInt(resultarray['od_r13_f8']) + parseInt(resultarray['od_r14_f8']) + parseInt(resultarray['od_r15_f8']) + parseInt(resultarray['od_r16_f8']) + parseInt(resultarray['od_r17_f8']) + parseInt(resultarray['od_r18_f8']) + parseInt(resultarray['od_r19_f8']) + parseInt(resultarray['od_r20_f8']) + parseInt(resultarray['od_r21_f8']) + parseInt(resultarray['od_r22_f8']) + parseInt(resultarray['od_r23_f8']) + parseInt(resultarray['od_r24_f8']) + parseInt(resultarray['od_r1_f9']) + parseInt(resultarray['od_r2_f9']) + parseInt(resultarray['od_r3_f9']) + parseInt(resultarray['od_r4_f9']) + parseInt(resultarray['od_r5_f9']) + parseInt(resultarray['od_r6_f9']) + parseInt(resultarray['od_r7_f9']) + parseInt(resultarray['od_r8_f9']) + parseInt(resultarray['od_r9_f9']) + parseInt(resultarray['od_r10_f9']) + parseInt(resultarray['od_r11_f9']) + parseInt(resultarray['od_r12_f9']) + parseInt(resultarray['od_r13_f9']) + parseInt(resultarray['od_r14_f9']) + parseInt(resultarray['od_r15_f9']) + parseInt(resultarray['od_r16_f9']) + parseInt(resultarray['od_r17_f9']) + parseInt(resultarray['od_r18_f9']) + parseInt(resultarray['od_r19_f9']) + parseInt(resultarray['od_r20_f9']) + parseInt(resultarray['od_r21_f9']) + parseInt(resultarray['od_r22_f9']) + parseInt(resultarray['od_r23_f9']) + parseInt(resultarray['od_r24_f9']);
					var Pneumococcal = parseInt(resultarray['cri_r1_f10']) + parseInt(resultarray['cri_r2_f10']) + parseInt(resultarray['cri_r3_f10']) + parseInt(resultarray['cri_r4_f10']) + parseInt(resultarray['cri_r5_f10']) + parseInt(resultarray['cri_r6_f10']) + parseInt(resultarray['cri_r7_f10']) + parseInt(resultarray['cri_r8_f10']) + parseInt(resultarray['cri_r9_f10']) + parseInt(resultarray['cri_r10_f10']) + parseInt(resultarray['cri_r11_f10']) + parseInt(resultarray['cri_r12_f10']) + parseInt(resultarray['cri_r13_f10']) + parseInt(resultarray['cri_r14_f10']) + parseInt(resultarray['cri_r15_f10']) + parseInt(resultarray['cri_r16_f10']) + parseInt(resultarray['cri_r17_f10']) + parseInt(resultarray['cri_r18_f10']) + parseInt(resultarray['cri_r19_f10']) + parseInt(resultarray['cri_r20_f10']) + parseInt(resultarray['cri_r21_f10']) + parseInt(resultarray['cri_r22_f10']) + parseInt(resultarray['cri_r23_f10']) + parseInt(resultarray['cri_r24_f10']) + parseInt(resultarray['cri_r1_f11']) + parseInt(resultarray['cri_r2_f11']) + parseInt(resultarray['cri_r3_f11']) + parseInt(resultarray['cri_r4_f11']) + parseInt(resultarray['cri_r5_f11']) + parseInt(resultarray['cri_r6_f11']) + parseInt(resultarray['cri_r7_f11']) + parseInt(resultarray['cri_r8_f11']) + parseInt(resultarray['cri_r9_f11']) + parseInt(resultarray['cri_r10_f11']) + parseInt(resultarray['cri_r11_f11']) + parseInt(resultarray['cri_r12_f11']) + parseInt(resultarray['cri_r13_f11']) + parseInt(resultarray['cri_r14_f11']) + parseInt(resultarray['cri_r15_f11']) + parseInt(resultarray['cri_r16_f11']) + parseInt(resultarray['cri_r17_f11']) + parseInt(resultarray['cri_r18_f11']) + parseInt(resultarray['cri_r19_f11']) + parseInt(resultarray['cri_r20_f11']) + parseInt(resultarray['cri_r21_f11']) + parseInt(resultarray['cri_r22_f11']) + parseInt(resultarray['cri_r23_f11']) + parseInt(resultarray['cri_r24_f11']) + parseInt(resultarray['cri_r1_f12']) + parseInt(resultarray['cri_r2_f12']) + parseInt(resultarray['cri_r3_f12']) + parseInt(resultarray['cri_r4_f12']) + parseInt(resultarray['cri_r5_f12']) + parseInt(resultarray['cri_r6_f12']) + parseInt(resultarray['cri_r7_f12']) + parseInt(resultarray['cri_r8_f12']) + parseInt(resultarray['cri_r9_f12']) + parseInt(resultarray['cri_r10_f12']) + parseInt(resultarray['cri_r11_f12']) + parseInt(resultarray['cri_r12_f12']) + parseInt(resultarray['cri_r13_f12']) + parseInt(resultarray['cri_r14_f12']) + parseInt(resultarray['cri_r15_f12']) + parseInt(resultarray['cri_r16_f12']) + parseInt(resultarray['cri_r17_f12']) + parseInt(resultarray['cri_r18_f12']) + parseInt(resultarray['cri_r19_f12']) + parseInt(resultarray['cri_r20_f12']) + parseInt(resultarray['cri_r21_f12']) + parseInt(resultarray['cri_r22_f12']) + parseInt(resultarray['cri_r23_f12']) + parseInt(resultarray['cri_r24_f12']) + parseInt(resultarray['oui_r1_f10']) + parseInt(resultarray['oui_r2_f10']) + parseInt(resultarray['oui_r3_f10']) + parseInt(resultarray['oui_r4_f10']) + parseInt(resultarray['oui_r5_f10']) + parseInt(resultarray['oui_r6_f10']) + parseInt(resultarray['oui_r7_f10']) + parseInt(resultarray['oui_r8_f10']) + parseInt(resultarray['oui_r9_f10']) + parseInt(resultarray['oui_r10_f10']) + parseInt(resultarray['oui_r11_f10']) + parseInt(resultarray['oui_r12_f10']) + parseInt(resultarray['oui_r13_f10']) + parseInt(resultarray['oui_r14_f10']) + parseInt(resultarray['oui_r15_f10']) + parseInt(resultarray['oui_r16_f10']) + parseInt(resultarray['oui_r17_f10']) + parseInt(resultarray['oui_r18_f10']) + parseInt(resultarray['oui_r19_f10']) + parseInt(resultarray['oui_r20_f10']) + parseInt(resultarray['oui_r21_f10']) + parseInt(resultarray['oui_r22_f10']) + parseInt(resultarray['oui_r23_f10']) + parseInt(resultarray['oui_r24_f10']) + parseInt(resultarray['oui_r1_f11']) + parseInt(resultarray['oui_r2_f11']) + parseInt(resultarray['oui_r3_f11']) + parseInt(resultarray['oui_r4_f11']) + parseInt(resultarray['oui_r5_f11']) + parseInt(resultarray['oui_r6_f11']) + parseInt(resultarray['oui_r7_f11']) + parseInt(resultarray['oui_r8_f11']) + parseInt(resultarray['oui_r9_f11']) + parseInt(resultarray['oui_r10_f11']) + parseInt(resultarray['oui_r11_f11']) + parseInt(resultarray['oui_r12_f11']) + parseInt(resultarray['oui_r13_f11']) + parseInt(resultarray['oui_r14_f11']) + parseInt(resultarray['oui_r15_f11']) + parseInt(resultarray['oui_r16_f11']) + parseInt(resultarray['oui_r17_f11']) + parseInt(resultarray['oui_r18_f11']) + parseInt(resultarray['oui_r19_f11']) + parseInt(resultarray['oui_r20_f11']) + parseInt(resultarray['oui_r21_f11']) + parseInt(resultarray['oui_r22_f11']) + parseInt(resultarray['oui_r23_f11']) + parseInt(resultarray['oui_r24_f11']) + parseInt(resultarray['oui_r1_f12']) + parseInt(resultarray['oui_r2_f12']) + parseInt(resultarray['oui_r3_f12']) + parseInt(resultarray['oui_r4_f12']) + parseInt(resultarray['oui_r5_f12']) + parseInt(resultarray['oui_r6_f12']) + parseInt(resultarray['oui_r7_f12']) + parseInt(resultarray['oui_r8_f12']) + parseInt(resultarray['oui_r9_f12']) + parseInt(resultarray['oui_r10_f12']) + parseInt(resultarray['oui_r11_f12']) + parseInt(resultarray['oui_r12_f12']) + parseInt(resultarray['oui_r13_f12']) + parseInt(resultarray['oui_r14_f12']) + parseInt(resultarray['oui_r15_f12']) + parseInt(resultarray['oui_r16_f12']) + parseInt(resultarray['oui_r17_f12']) + parseInt(resultarray['oui_r18_f12']) + parseInt(resultarray['oui_r19_f12']) + parseInt(resultarray['oui_r20_f12']) + parseInt(resultarray['oui_r21_f12']) + parseInt(resultarray['oui_r22_f12']) + parseInt(resultarray['oui_r23_f12']) + parseInt(resultarray['oui_r24_f12']) + parseInt(resultarray['od_r1_f10']) + parseInt(resultarray['od_r2_f10']) + parseInt(resultarray['od_r3_f10']) + parseInt(resultarray['od_r4_f10']) + parseInt(resultarray['od_r5_f10']) + parseInt(resultarray['od_r6_f10']) + parseInt(resultarray['od_r7_f10']) + parseInt(resultarray['od_r8_f10']) + parseInt(resultarray['od_r9_f10']) + parseInt(resultarray['od_r10_f10']) + parseInt(resultarray['od_r11_f10']) + parseInt(resultarray['od_r12_f10']) + parseInt(resultarray['od_r13_f10']) + parseInt(resultarray['od_r14_f10']) + parseInt(resultarray['od_r15_f10']) + parseInt(resultarray['od_r16_f10']) + parseInt(resultarray['od_r17_f10']) + parseInt(resultarray['od_r18_f10']) + parseInt(resultarray['od_r19_f10']) + parseInt(resultarray['od_r20_f10']) + parseInt(resultarray['od_r21_f10']) + parseInt(resultarray['od_r22_f10']) + parseInt(resultarray['od_r23_f10']) + parseInt(resultarray['od_r24_f10']) + parseInt(resultarray['od_r1_f11']) + parseInt(resultarray['od_r2_f11']) + parseInt(resultarray['od_r3_f11']) + parseInt(resultarray['od_r4_f11']) + parseInt(resultarray['od_r5_f11']) + parseInt(resultarray['od_r6_f11']) + parseInt(resultarray['od_r7_f11']) + parseInt(resultarray['od_r8_f11']) + parseInt(resultarray['od_r9_f11']) + parseInt(resultarray['od_r10_f11']) + parseInt(resultarray['od_r11_f11']) + parseInt(resultarray['od_r12_f11']) + parseInt(resultarray['od_r13_f11']) + parseInt(resultarray['od_r14_f11']) + parseInt(resultarray['od_r15_f11']) + parseInt(resultarray['od_r16_f11']) + parseInt(resultarray['od_r17_f11']) + parseInt(resultarray['od_r18_f11']) + parseInt(resultarray['od_r19_f11']) + parseInt(resultarray['od_r20_f11']) + parseInt(resultarray['od_r21_f11']) + parseInt(resultarray['od_r22_f11']) + parseInt(resultarray['od_r23_f11']) + parseInt(resultarray['od_r24_f11']) + parseInt(resultarray['od_r1_f12']) + parseInt(resultarray['od_r2_f12']) + parseInt(resultarray['od_r3_f12']) + parseInt(resultarray['od_r4_f12']) + parseInt(resultarray['od_r5_f12']) + parseInt(resultarray['od_r6_f12']) + parseInt(resultarray['od_r7_f12']) + parseInt(resultarray['od_r8_f12']) + parseInt(resultarray['od_r9_f12']) + parseInt(resultarray['od_r10_f12']) + parseInt(resultarray['od_r11_f12']) + parseInt(resultarray['od_r12_f12']) + parseInt(resultarray['od_r13_f12']) + parseInt(resultarray['od_r14_f12']) + parseInt(resultarray['od_r15_f12']) + parseInt(resultarray['od_r16_f12']) + parseInt(resultarray['od_r17_f12']) + parseInt(resultarray['od_r18_f12']) + parseInt(resultarray['od_r19_f12']) + parseInt(resultarray['od_r20_f12']) + parseInt(resultarray['od_r21_f12']) + parseInt(resultarray['od_r22_f12']) + parseInt(resultarray['od_r23_f12']) + parseInt(resultarray['od_r24_f12']);
					var Measles = parseInt(resultarray['cri_r1_f16']) + parseInt(resultarray['cri_r2_f16']) + parseInt(resultarray['cri_r3_f16']) + parseInt(resultarray['cri_r4_f16']) + parseInt(resultarray['cri_r5_f16']) + parseInt(resultarray['cri_r6_f16']) + parseInt(resultarray['cri_r7_f16']) + parseInt(resultarray['cri_r8_f16']) + parseInt(resultarray['cri_r9_f16']) + parseInt(resultarray['cri_r10_f16']) + parseInt(resultarray['cri_r11_f16']) + parseInt(resultarray['cri_r12_f16']) + parseInt(resultarray['cri_r13_f16']) + parseInt(resultarray['cri_r14_f16']) + parseInt(resultarray['cri_r15_f16']) + parseInt(resultarray['cri_r16_f16']) + parseInt(resultarray['cri_r17_f16']) + parseInt(resultarray['cri_r18_f16']) + parseInt(resultarray['cri_r19_f16']) + parseInt(resultarray['cri_r20_f16']) + parseInt(resultarray['cri_r21_f16']) + parseInt(resultarray['cri_r22_f16']) + parseInt(resultarray['cri_r23_f16']) + parseInt(resultarray['cri_r24_f16']) + parseInt(resultarray['cri_r1_f18']) + parseInt(resultarray['cri_r2_f18']) + parseInt(resultarray['cri_r3_f18']) + parseInt(resultarray['cri_r4_f18']) + parseInt(resultarray['cri_r5_f18']) + parseInt(resultarray['cri_r6_f18']) + parseInt(resultarray['cri_r7_f18']) + parseInt(resultarray['cri_r8_f18']) + parseInt(resultarray['cri_r9_f18']) + parseInt(resultarray['cri_r10_f18']) + parseInt(resultarray['cri_r11_f18']) + parseInt(resultarray['cri_r12_f18']) + parseInt(resultarray['cri_r13_f18']) + parseInt(resultarray['cri_r14_f18']) + parseInt(resultarray['cri_r15_f18']) + parseInt(resultarray['cri_r16_f18']) + parseInt(resultarray['cri_r17_f18']) + parseInt(resultarray['cri_r18_f18']) + parseInt(resultarray['cri_r19_f18']) + parseInt(resultarray['cri_r20_f18']) + parseInt(resultarray['cri_r21_f18']) + parseInt(resultarray['cri_r22_f18']) + parseInt(resultarray['cri_r23_f18']) + parseInt(resultarray['cri_r24_f18']) + parseInt(resultarray['oui_r1_f16']) + parseInt(resultarray['oui_r2_f16']) + parseInt(resultarray['oui_r3_f16']) + parseInt(resultarray['oui_r4_f16']) + parseInt(resultarray['oui_r5_f16']) + parseInt(resultarray['oui_r6_f16']) + parseInt(resultarray['oui_r7_f16']) + parseInt(resultarray['oui_r8_f16']) + parseInt(resultarray['oui_r9_f16']) + parseInt(resultarray['oui_r10_f16']) + parseInt(resultarray['oui_r11_f16']) + parseInt(resultarray['oui_r12_f16']) + parseInt(resultarray['oui_r13_f16']) + parseInt(resultarray['oui_r14_f16']) + parseInt(resultarray['oui_r15_f16']) + parseInt(resultarray['oui_r16_f16']) + parseInt(resultarray['oui_r17_f16']) + parseInt(resultarray['oui_r18_f16']) + parseInt(resultarray['oui_r19_f16']) + parseInt(resultarray['oui_r20_f16']) + parseInt(resultarray['oui_r21_f16']) + parseInt(resultarray['oui_r22_f16']) + parseInt(resultarray['oui_r23_f16']) + parseInt(resultarray['oui_r24_f16']) + parseInt(resultarray['oui_r1_f18']) + parseInt(resultarray['oui_r2_f18']) + parseInt(resultarray['oui_r3_f18']) + parseInt(resultarray['oui_r4_f18']) + parseInt(resultarray['oui_r5_f18']) + parseInt(resultarray['oui_r6_f18']) + parseInt(resultarray['oui_r7_f18']) + parseInt(resultarray['oui_r8_f18']) + parseInt(resultarray['oui_r9_f18']) + parseInt(resultarray['oui_r10_f18']) + parseInt(resultarray['oui_r11_f18']) + parseInt(resultarray['oui_r12_f18']) + parseInt(resultarray['oui_r13_f18']) + parseInt(resultarray['oui_r14_f18']) + parseInt(resultarray['oui_r15_f18']) + parseInt(resultarray['oui_r16_f18']) + parseInt(resultarray['oui_r17_f18']) + parseInt(resultarray['oui_r18_f18']) + parseInt(resultarray['oui_r19_f18']) + parseInt(resultarray['oui_r20_f18']) + parseInt(resultarray['oui_r21_f18']) + parseInt(resultarray['oui_r22_f18']) + parseInt(resultarray['oui_r23_f18']) + parseInt(resultarray['oui_r24_f18']) + parseInt(resultarray['od_r1_f16']) + parseInt(resultarray['od_r2_f16']) + parseInt(resultarray['od_r3_f16']) + parseInt(resultarray['od_r4_f16']) + parseInt(resultarray['od_r5_f16']) + parseInt(resultarray['od_r6_f16']) + parseInt(resultarray['od_r7_f16']) + parseInt(resultarray['od_r8_f16']) + parseInt(resultarray['od_r9_f16']) + parseInt(resultarray['od_r10_f16']) + parseInt(resultarray['od_r11_f16']) + parseInt(resultarray['od_r12_f16']) + parseInt(resultarray['od_r13_f16']) + parseInt(resultarray['od_r14_f16']) + parseInt(resultarray['od_r15_f16']) + parseInt(resultarray['od_r16_f16']) + parseInt(resultarray['od_r17_f16']) + parseInt(resultarray['od_r18_f16']) + parseInt(resultarray['od_r19_f16']) + parseInt(resultarray['od_r20_f16']) + parseInt(resultarray['od_r21_f16']) + parseInt(resultarray['od_r22_f16']) + parseInt(resultarray['od_r23_f16']) + parseInt(resultarray['od_r24_f16']) + parseInt(resultarray['od_r1_f18']) + parseInt(resultarray['od_r2_f18']) + parseInt(resultarray['od_r3_f18']) + parseInt(resultarray['od_r4_f18']) + parseInt(resultarray['od_r5_f18']) + parseInt(resultarray['od_r6_f18']) + parseInt(resultarray['od_r7_f18']) + parseInt(resultarray['od_r8_f18']) + parseInt(resultarray['od_r9_f18']) + parseInt(resultarray['od_r10_f18']) + parseInt(resultarray['od_r11_f18']) + parseInt(resultarray['od_r12_f18']) + parseInt(resultarray['od_r13_f18']) + parseInt(resultarray['od_r14_f18']) + parseInt(resultarray['od_r15_f18']) + parseInt(resultarray['od_r16_f18']) + parseInt(resultarray['od_r17_f18']) + parseInt(resultarray['od_r18_f18']) + parseInt(resultarray['od_r19_f18']) + parseInt(resultarray['od_r20_f18']) + parseInt(resultarray['od_r21_f18']) + parseInt(resultarray['od_r22_f18']) + parseInt(resultarray['od_r23_f18']) + parseInt(resultarray['od_r24_f18']);
					var IPV = parseInt(resultarray['cri_r1_f13']) + parseInt(resultarray['cri_r2_f13']) + parseInt(resultarray['cri_r3_f13']) + parseInt(resultarray['cri_r4_f13']) + parseInt(resultarray['cri_r5_f13']) + parseInt(resultarray['cri_r6_f13']) + parseInt(resultarray['cri_r7_f13']) + parseInt(resultarray['cri_r8_f13']) + parseInt(resultarray['cri_r9_f13']) + parseInt(resultarray['cri_r10_f13']) + parseInt(resultarray['cri_r11_f13']) + parseInt(resultarray['cri_r12_f13']) + parseInt(resultarray['cri_r13_f13']) + parseInt(resultarray['cri_r14_f13']) + parseInt(resultarray['cri_r15_f13']) + parseInt(resultarray['cri_r16_f13']) + parseInt(resultarray['cri_r17_f13']) + parseInt(resultarray['cri_r18_f13']) + parseInt(resultarray['cri_r19_f13']) + parseInt(resultarray['cri_r20_f13']) + parseInt(resultarray['cri_r21_f13']) + parseInt(resultarray['cri_r22_f13']) + parseInt(resultarray['cri_r23_f13']) + parseInt(resultarray['cri_r24_f13']) + parseInt(resultarray['oui_r1_f13']) + parseInt(resultarray['oui_r2_f13']) + parseInt(resultarray['oui_r3_f13']) + parseInt(resultarray['oui_r4_f13']) + parseInt(resultarray['oui_r5_f13']) + parseInt(resultarray['oui_r6_f13']) + parseInt(resultarray['oui_r7_f13']) + parseInt(resultarray['oui_r8_f13']) + parseInt(resultarray['oui_r9_f13']) + parseInt(resultarray['oui_r10_f13']) + parseInt(resultarray['oui_r11_f13']) + parseInt(resultarray['oui_r12_f13']) + parseInt(resultarray['oui_r13_f13']) + parseInt(resultarray['oui_r14_f13']) + parseInt(resultarray['oui_r15_f13']) + parseInt(resultarray['oui_r16_f13']) + parseInt(resultarray['oui_r17_f13']) + parseInt(resultarray['oui_r18_f13']) + parseInt(resultarray['oui_r19_f13']) + parseInt(resultarray['oui_r20_f13']) + parseInt(resultarray['oui_r21_f13']) + parseInt(resultarray['oui_r22_f13']) + parseInt(resultarray['oui_r23_f13']) + parseInt(resultarray['oui_r24_f13']) + parseInt(resultarray['od_r1_f13']) + parseInt(resultarray['od_r2_f13']) + parseInt(resultarray['od_r3_f13']) + parseInt(resultarray['od_r4_f13']) + parseInt(resultarray['od_r5_f13']) + parseInt(resultarray['od_r6_f13']) + parseInt(resultarray['od_r7_f13']) + parseInt(resultarray['od_r8_f13']) + parseInt(resultarray['od_r9_f13']) + parseInt(resultarray['od_r10_f13']) + parseInt(resultarray['od_r11_f13']) + parseInt(resultarray['od_r12_f13']) + parseInt(resultarray['od_r13_f13']) + parseInt(resultarray['od_r14_f13']) + parseInt(resultarray['od_r15_f13']) + parseInt(resultarray['od_r16_f13']) + parseInt(resultarray['od_r17_f13']) + parseInt(resultarray['od_r18_f13']) + parseInt(resultarray['od_r19_f13']) + parseInt(resultarray['od_r20_f13']) + parseInt(resultarray['od_r21_f13']) + parseInt(resultarray['od_r22_f13']) + parseInt(resultarray['od_r23_f13']) + parseInt(resultarray['od_r24_f13']);
					var TT1 = parseInt(resultarray['ttri_r1_f1']) + parseInt(resultarray['ttri_r2_f1']) + parseInt(resultarray['ttri_r3_f1']) + parseInt(resultarray['ttri_r4_f1']) + parseInt(resultarray['ttri_r5_f1']) + parseInt(resultarray['ttri_r6_f1']) + parseInt(resultarray['ttri_r7_f1']) + parseInt(resultarray['ttri_r8_f1']) + parseInt(resultarray['ttoui_r1_f1']) + parseInt(resultarray['ttoui_r2_f1']) + parseInt(resultarray['ttoui_r3_f1']) + parseInt(resultarray['ttoui_r4_f1']) + parseInt(resultarray['ttoui_r5_f1']) + parseInt(resultarray['ttoui_r6_f1']) + parseInt(resultarray['ttoui_r7_f1']) + parseInt(resultarray['ttoui_r8_f1']) + parseInt(resultarray['ttod_r1_f1']) + parseInt(resultarray['ttod_r2_f1']) + parseInt(resultarray['ttod_r3_f1']) + parseInt(resultarray['ttod_r4_f1']) + parseInt(resultarray['ttod_r5_f1']) + parseInt(resultarray['ttod_r6_f1']) + parseInt(resultarray['ttod_r7_f1']) + parseInt(resultarray['ttod_r8_f1']);
					var TT2 = parseInt(resultarray['ttri_r1_f2']) + parseInt(resultarray['ttri_r2_f2']) + parseInt(resultarray['ttri_r3_f2']) + parseInt(resultarray['ttri_r4_f2']) + parseInt(resultarray['ttri_r5_f2']) + parseInt(resultarray['ttri_r6_f2']) + parseInt(resultarray['ttri_r7_f2']) + parseInt(resultarray['ttri_r8_f2']) + parseInt(resultarray['ttoui_r1_f2']) + parseInt(resultarray['ttoui_r2_f2']) + parseInt(resultarray['ttoui_r3_f2']) + parseInt(resultarray['ttoui_r4_f2']) + parseInt(resultarray['ttoui_r5_f2']) + parseInt(resultarray['ttoui_r6_f2']) + parseInt(resultarray['ttoui_r7_f2']) + parseInt(resultarray['ttoui_r8_f2']) + parseInt(resultarray['ttod_r1_f2']) + parseInt(resultarray['ttod_r2_f2']) + parseInt(resultarray['ttod_r3_f2']) + parseInt(resultarray['ttod_r4_f2']) + parseInt(resultarray['ttod_r5_f2']) + parseInt(resultarray['ttod_r6_f2']) + parseInt(resultarray['ttod_r7_f2']) + parseInt(resultarray['ttod_r8_f2']);
					var TT3 = parseInt(resultarray['ttri_r1_f3']) + parseInt(resultarray['ttri_r2_f3']) + parseInt(resultarray['ttri_r3_f3']) + parseInt(resultarray['ttri_r4_f3']) + parseInt(resultarray['ttri_r5_f3']) + parseInt(resultarray['ttri_r6_f3']) + parseInt(resultarray['ttri_r7_f3']) + parseInt(resultarray['ttri_r8_f3']) + parseInt(resultarray['ttoui_r1_f3']) + parseInt(resultarray['ttoui_r2_f3']) + parseInt(resultarray['ttoui_r3_f3']) + parseInt(resultarray['ttoui_r4_f3']) + parseInt(resultarray['ttoui_r5_f3']) + parseInt(resultarray['ttoui_r6_f3']) + parseInt(resultarray['ttoui_r7_f3']) + parseInt(resultarray['ttoui_r8_f3']) + parseInt(resultarray['ttod_r1_f3']) + parseInt(resultarray['ttod_r2_f3']) + parseInt(resultarray['ttod_r3_f3']) + parseInt(resultarray['ttod_r4_f3']) + parseInt(resultarray['ttod_r5_f3']) + parseInt(resultarray['ttod_r6_f3']) + parseInt(resultarray['ttod_r7_f3']) + parseInt(resultarray['ttod_r8_f3']);
					var TT4 = parseInt(resultarray['ttri_r1_f4']) + parseInt(resultarray['ttri_r2_f4']) + parseInt(resultarray['ttri_r3_f4']) + parseInt(resultarray['ttri_r4_f4']) + parseInt(resultarray['ttri_r5_f4']) + parseInt(resultarray['ttri_r6_f4']) + parseInt(resultarray['ttri_r7_f4']) + parseInt(resultarray['ttri_r8_f4']) + parseInt(resultarray['ttoui_r1_f4']) + parseInt(resultarray['ttoui_r2_f4']) + parseInt(resultarray['ttoui_r3_f4']) + parseInt(resultarray['ttoui_r4_f4']) + parseInt(resultarray['ttoui_r5_f4']) + parseInt(resultarray['ttoui_r6_f4']) + parseInt(resultarray['ttoui_r7_f4']) + parseInt(resultarray['ttoui_r8_f4']) + parseInt(resultarray['ttod_r1_f4']) + parseInt(resultarray['ttod_r2_f4']) + parseInt(resultarray['ttod_r3_f4']) + parseInt(resultarray['ttod_r4_f4']) + parseInt(resultarray['ttod_r5_f4']) + parseInt(resultarray['ttod_r6_f4']) + parseInt(resultarray['ttod_r7_f4']) + parseInt(resultarray['ttod_r8_f4']);
					var TT5 = parseInt(resultarray['ttri_r1_f5']) + parseInt(resultarray['ttri_r2_f5']) + parseInt(resultarray['ttri_r3_f5']) + parseInt(resultarray['ttri_r4_f5']) + parseInt(resultarray['ttri_r5_f5']) + parseInt(resultarray['ttri_r6_f5']) + parseInt(resultarray['ttri_r7_f5']) + parseInt(resultarray['ttri_r8_f5']) + parseInt(resultarray['ttoui_r1_f5']) + parseInt(resultarray['ttoui_r2_f5']) + parseInt(resultarray['ttoui_r3_f5']) + parseInt(resultarray['ttoui_r4_f5']) + parseInt(resultarray['ttoui_r5_f5']) + parseInt(resultarray['ttoui_r6_f5']) + parseInt(resultarray['ttoui_r7_f5']) + parseInt(resultarray['ttoui_r8_f5']) + parseInt(resultarray['ttod_r1_f5']) + parseInt(resultarray['ttod_r2_f5']) + parseInt(resultarray['ttod_r3_f5']) + parseInt(resultarray['ttod_r4_f5']) + parseInt(resultarray['ttod_r5_f5']) + parseInt(resultarray['ttod_r6_f5']) + parseInt(resultarray['ttod_r7_f5']) + parseInt(resultarray['ttod_r8_f5']);
					var TT = TT1 + TT2 + TT3 + TT4 + TT5;
					var rota = parseInt(resultarray['cri_r1_f14']) + parseInt(resultarray['cri_r2_f14']) + parseInt(resultarray['cri_r3_f14']) + parseInt(resultarray['cri_r4_f14']) + parseInt(resultarray['cri_r5_f14']) + parseInt(resultarray['cri_r6_f14']) + parseInt(resultarray['cri_r7_f14']) + parseInt(resultarray['cri_r8_f14']) + parseInt(resultarray['cri_r9_f14']) + parseInt(resultarray['cri_r10_f14']) + parseInt(resultarray['cri_r11_f14']) + parseInt(resultarray['cri_r12_f14']) + parseInt(resultarray['cri_r13_f14']) + parseInt(resultarray['cri_r14_f14']) + parseInt(resultarray['cri_r15_f14']) + parseInt(resultarray['cri_r16_f14']) + parseInt(resultarray['cri_r17_f14']) + parseInt(resultarray['cri_r18_f14']) + parseInt(resultarray['cri_r19_f14']) + parseInt(resultarray['cri_r20_f14']) + parseInt(resultarray['cri_r21_f14']) + parseInt(resultarray['cri_r22_f14']) + parseInt(resultarray['cri_r23_f14']) + parseInt(resultarray['cri_r24_f14']) + parseInt(resultarray['cri_r1_f15']) + parseInt(resultarray['cri_r2_f15']) + parseInt(resultarray['cri_r3_f15']) + parseInt(resultarray['cri_r4_f15']) + parseInt(resultarray['cri_r5_f15']) + parseInt(resultarray['cri_r6_f15']) + parseInt(resultarray['cri_r7_f15']) + parseInt(resultarray['cri_r8_f15']) + parseInt(resultarray['cri_r9_f15']) + parseInt(resultarray['cri_r10_f15']) + parseInt(resultarray['cri_r11_f15']) + parseInt(resultarray['cri_r12_f15']) + parseInt(resultarray['cri_r13_f15']) + parseInt(resultarray['cri_r14_f15']) + parseInt(resultarray['cri_r15_f15']) + parseInt(resultarray['cri_r16_f15']) + parseInt(resultarray['cri_r17_f15']) + parseInt(resultarray['cri_r18_f15']) + parseInt(resultarray['cri_r19_f15']) + parseInt(resultarray['cri_r20_f15']) + parseInt(resultarray['cri_r21_f15']) + parseInt(resultarray['cri_r22_f15']) + parseInt(resultarray['cri_r23_f15']) + parseInt(resultarray['cri_r24_f15']) + parseInt(resultarray['oui_r1_f14']) + parseInt(resultarray['oui_r2_f14']) + parseInt(resultarray['oui_r3_f14']) + parseInt(resultarray['oui_r4_f14']) + parseInt(resultarray['oui_r5_f14']) + parseInt(resultarray['oui_r6_f14']) + parseInt(resultarray['oui_r7_f14']) + parseInt(resultarray['oui_r8_f14']) + parseInt(resultarray['oui_r9_f14']) + parseInt(resultarray['oui_r10_f14']) + parseInt(resultarray['oui_r11_f14']) + parseInt(resultarray['oui_r12_f14']) + parseInt(resultarray['oui_r13_f14']) + parseInt(resultarray['oui_r14_f14']) + parseInt(resultarray['oui_r15_f14']) + parseInt(resultarray['oui_r16_f14']) + parseInt(resultarray['oui_r17_f14']) + parseInt(resultarray['oui_r18_f14']) + parseInt(resultarray['oui_r19_f14']) + parseInt(resultarray['oui_r20_f14']) + parseInt(resultarray['oui_r21_f14']) + parseInt(resultarray['oui_r22_f14']) + parseInt(resultarray['oui_r23_f14']) + parseInt(resultarray['oui_r24_f14']) + parseInt(resultarray['oui_r1_f15']) + parseInt(resultarray['oui_r2_f15']) + parseInt(resultarray['oui_r3_f15']) + parseInt(resultarray['oui_r4_f15']) + parseInt(resultarray['oui_r5_f15']) + parseInt(resultarray['oui_r6_f15']) + parseInt(resultarray['oui_r7_f15']) + parseInt(resultarray['oui_r8_f15']) + parseInt(resultarray['oui_r9_f15']) + parseInt(resultarray['oui_r10_f15']) + parseInt(resultarray['oui_r11_f15']) + parseInt(resultarray['oui_r12_f15']) + parseInt(resultarray['oui_r13_f15']) + parseInt(resultarray['oui_r14_f15']) + parseInt(resultarray['oui_r15_f15']) + parseInt(resultarray['oui_r16_f15']) + parseInt(resultarray['oui_r17_f15']) + parseInt(resultarray['oui_r18_f15']) + parseInt(resultarray['oui_r19_f15']) + parseInt(resultarray['oui_r20_f15']) + parseInt(resultarray['oui_r21_f15']) + parseInt(resultarray['oui_r22_f15']) + parseInt(resultarray['oui_r23_f15']) + parseInt(resultarray['oui_r24_f15']) + parseInt(resultarray['od_r1_f14']) + parseInt(resultarray['od_r2_f14']) + parseInt(resultarray['od_r3_f14']) + parseInt(resultarray['od_r4_f14']) + parseInt(resultarray['od_r5_f14']) + parseInt(resultarray['od_r6_f14']) + parseInt(resultarray['od_r7_f14']) + parseInt(resultarray['od_r8_f14']) + parseInt(resultarray['od_r9_f14']) + parseInt(resultarray['od_r10_f14']) + parseInt(resultarray['od_r11_f14']) + parseInt(resultarray['od_r12_f14']) + parseInt(resultarray['od_r13_f14']) + parseInt(resultarray['od_r14_f14']) + parseInt(resultarray['od_r15_f14']) + parseInt(resultarray['od_r16_f14']) + parseInt(resultarray['od_r17_f14']) + parseInt(resultarray['od_r18_f14']) + parseInt(resultarray['od_r19_f14']) + parseInt(resultarray['od_r20_f14']) + parseInt(resultarray['od_r21_f14']) + parseInt(resultarray['od_r22_f14']) + parseInt(resultarray['od_r23_f14']) + parseInt(resultarray['od_r24_f14']) + parseInt(resultarray['od_r1_f15']) + parseInt(resultarray['od_r2_f15']) + parseInt(resultarray['od_r3_f15']) + parseInt(resultarray['od_r4_f15']) + parseInt(resultarray['od_r5_f15']) + parseInt(resultarray['od_r6_f15']) + parseInt(resultarray['od_r7_f15']) + parseInt(resultarray['od_r8_f15']) + parseInt(resultarray['od_r9_f15']) + parseInt(resultarray['od_r10_f15']) + parseInt(resultarray['od_r11_f15']) + parseInt(resultarray['od_r12_f15']) + parseInt(resultarray['od_r13_f15']) + parseInt(resultarray['od_r14_f15']) + parseInt(resultarray['od_r15_f15']) + parseInt(resultarray['od_r16_f15']) + parseInt(resultarray['od_r17_f15']) + parseInt(resultarray['od_r18_f15']) + parseInt(resultarray['od_r19_f15']) + parseInt(resultarray['od_r20_f15']) + parseInt(resultarray['od_r21_f15']) + parseInt(resultarray['od_r22_f15']) + parseInt(resultarray['od_r23_f15']) + parseInt(resultarray['od_r24_f15']);

					if(isNaN(BCG)){ $("#"+"cr_r1_f3").val(0);}
					else{ $("#"+"cr_r1_f3").val(BCG); /*$("#"+"cr_r13_f4").val(BCG);*/}
					
					if(isNaN(bOPV)){ $("#"+"cr_r3_f3").val(0); }
					else{ $("#"+"cr_r3_f3").val(bOPV); }
					
					if(isNaN(Pentavalent)){ $("#"+"cr_r4_f3").val(0); }
					else{ $("#"+"cr_r4_f3").val(Pentavalent); }
					
					if(isNaN(Pneumococcal)){ $("#"+"cr_r5_f3").val(0); }
					else{ $("#"+"cr_r5_f3").val(Pneumococcal); }
					
					if(isNaN(Measles)){ $("#"+"cr_r6_f3").val(0);}
					else{ $("#"+"cr_r6_f3").val(Measles); }
					
					if(isNaN(IPV)){ $("#"+"cr_r11_f3").val(0); }
					else{ $("#"+"cr_r11_f3").val(IPV); }
					
					if(isNaN(TT)){ $("#"+"cr_r9_f3").val(0); }
					else{ $("#"+"cr_r9_f3").val(TT); }
					
					if(isNaN(rota)){ $("#"+"cr_r18_f3").val(0); }
					else{ $("#"+"cr_r18_f3").val(rota); }
				}
			});
		}
	}
	/* Function to get Opening Balance for the selected month and year */
	function set_opening_bal(){
		var month = $('#month').val();
		var year = $('#year').val();
		var facode = $('#facode').val();
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {month:month,year:year,facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getHFOpeningBal",
				success: function(result){
					var resultarray = JSON.parse(result);
					for(var i=1;i<=19;i++)
					{
						var name = "cr_r"+i+"_f6";
						if(resultarray[name] > 0 && resultarray[name]!="")
						{
							if(i == 1 || i == 3 || i == 9){
								$("#"+"cr_r"+i+"_f1").val(parseInt(resultarray[name])*20);
							}else if(i == 5){
								$("#"+"cr_r"+i+"_f1").val(parseInt(resultarray[name])*2);
							}else if(i == 19){
								$("#"+"cr_r"+i+"_f1").val(parseInt(resultarray[name])*5);
							}else if(i == 6 || i == 8 || i == 10 || i == 11){
								$("#"+"cr_r"+i+"_f1").val(parseInt(resultarray[name])*10);
							}else{
								$("#"+"cr_r"+i+"_f1").val(resultarray[name]);
							}
							$("#"+"cr_r"+i+"_f6").val(resultarray[name]);
						}else{
							$("#"+"cr_r"+i+"_f1").val(0);
							$("#"+"cr_r"+i+"_f6").val(0);
						}
					}
				}
			});
		}
	}
	/*  */
	function set_Rep_bal(){
		var month = $('#month').val();
		var year = $('#year').val();
		var facode = $('#facode').val();
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {month:month,year:year,facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getHFRepOpeningBal",
				success: function(result){
					var resultarray = JSON.parse(result);
					var replanishmentBalance = 0;
					for(var i=1;i<=19;i++)
					{
						var name = "cr_r"+i+"_f9";
						if(resultarray[name] > 0 && resultarray[name]!="")
						{	
							if(i == 1 || i == 3 || i == 9){
								$("#"+"cr_r"+i+"_f2").val(parseInt(resultarray[name])*20);
								replanishmentBalance = parseInt(parseInt($("#"+"cr_r"+i+"_f2").val())/20);
							}else if(i == 5){
								$("#"+"cr_r"+i+"_f2").val(parseInt(resultarray[name])*2);
								replanishmentBalance = parseInt(parseInt($("#"+"cr_r"+i+"_f2").val())/2);
							}else if(i == 19){
								$("#"+"cr_r"+i+"_f2").val(parseInt(resultarray[name])*5);
								replanishmentBalance = parseInt(parseInt($("#"+"cr_r"+i+"_f2").val())/2);
							}else if(i == 6 || i == 8 || i == 10 || i == 11){
								$("#"+"cr_r"+i+"_f2").val(parseInt(resultarray[name])*10);
								replanishmentBalance = parseInt(parseInt($("#"+"cr_r"+i+"_f2").val())/10);
							}else{
								$("#"+"cr_r"+i+"_f2").val(resultarray[name]);
							}
							$("#"+"cr_r"+i+"_f6").val(parseInt($("#"+"cr_r"+i+"_f6").val()) + replanishmentBalance);
						}else{
							$("#"+"cr_r"+i+"_f2").val(0);
						}
					}
				}
			});
		}
	}
	/* Function to set maximun stock level for the select month and year */
	function set_max_stock_level(){
		var year = $('#year').val();
		var facode = $('#facode').val();
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {year:year,facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getmonthlynewborn_target",
				success: function(result){
					
					var resultarray = JSON.parse(result);
					var getmonthlynewborn_targetpopulation =  resultarray['getmonthlynewborn_targetpopulation'];
					var getmonthly_survivinginfants =  resultarray['getmonthly_survivinginfants'];
					var getmonthly_plwomen_target =  resultarray['getmonthly_plwomen_target'];
					var getmonthly_HBV_IPV_target =  resultarray['getmonthly_survivinginfants'];
					
					var bcg = getmonthlynewborn_targetpopulation * 2;
					var bcgTotal = bcg + bcg/2;
					$("#cr_r1_f7").val(Math.round(bcgTotal/20));
					$("#cr_r2_f7").val(Math.round(bcgTotal/20));
					if(parseInt($("#cr_r1_f7").val()) > parseInt($("#cr_r1_f6").val())){
						$("#cr_r1_f8").val(parseInt($("#cr_r1_f7").val()) - parseInt($("#cr_r1_f6").val()));
					}
					if(parseInt($("#cr_r2_f7").val()) > parseInt($("#cr_r2_f6").val())){
						$("#cr_r2_f8").val(parseInt($("#cr_r2_f7").val()) - parseInt($("#cr_r2_f6").val()));
					}
					
					var bopv = getmonthlynewborn_targetpopulation * 1.25 ;
					var bopvTotal = bopv + bopv/2;
					$("#cr_r3_f7").val(Math.round(bopvTotal/20));
					if(parseInt($("#cr_r3_f7").val()) > parseInt($("#cr_r3_f6").val())){
						$("#cr_r3_f8").val(parseInt($("#cr_r3_f7").val()) - parseInt($("#cr_r3_f6").val()));
					}
					
					var Pentavalent = getmonthly_survivinginfants * 1.05 ;
					var PentavalentTotal = Pentavalent + Pentavalent/2;
					$("#cr_r4_f7").val(Math.round(PentavalentTotal/1));
					if(parseInt($("#cr_r4_f7").val()) > parseInt($("#cr_r4_f6").val())){
						$("#cr_r4_f8").val(parseInt($("#cr_r4_f7").val()) - parseInt($("#cr_r4_f6").val()));
					}
					
					var Pneumococcal = getmonthly_survivinginfants * 1.11 ;
					var PneumococcalTotal = Pneumococcal + Pneumococcal/2;
					$("#cr_r5_f7").val(Math.round(PneumococcalTotal/2));
					if(parseInt($("#cr_r5_f7").val()) > parseInt($("#cr_r5_f6").val())){
						$("#cr_r5_f8").val(parseInt($("#cr_r5_f7").val()) - parseInt($("#cr_r5_f6").val()));
					}
					
					var Measles = getmonthly_survivinginfants * 1.25 ;
					var MeaslesTotal = Measles + Measles/2;
					$("#cr_r6_f7").val(Math.round(MeaslesTotal/10));
					if(parseInt($("#cr_r6_f7").val()) > parseInt($("#cr_r6_f6").val())){
						$("#cr_r6_f8").val(parseInt($("#cr_r6_f7").val()) - parseInt($("#cr_r6_f6").val()));
					}
					
					var DILMeasles = getmonthly_survivinginfants * 1.25 ;
					var DILMeaslesTotal = DILMeasles + DILMeasles/2;
					$("#cr_r7_f7").val(Math.round(DILMeaslesTotal/10));
					if(parseInt($("#cr_r7_f7").val()) > parseInt($("#cr_r7_f6").val())){
						$("#cr_r7_f8").val(parseInt($("#cr_r7_f7").val()) - parseInt($("#cr_r7_f6").val()));
					}
					
					var TT = getmonthly_plwomen_target * 1.25 ;
					var TTTotal = TT + TT/2;
					$("#cr_r8_f7").val(Math.round(TTTotal/10));
					if(parseInt($("#cr_r8_f7").val()) > parseInt($("#cr_r8_f6").val())){
						$("#cr_r8_f8").val(parseInt($("#cr_r8_f7").val()) - parseInt($("#cr_r8_f6").val()));
					}
					
					var TT2 = getmonthly_plwomen_target * 1.25 ;
					var TT2Total = TT2 + TT2/2;
					$("#cr_r9_f7").val(Math.round(TT2Total/20));
					if(parseInt($("#cr_r9_f7").val()) > parseInt($("#cr_r9_f6").val())){
						$("#cr_r9_f8").val(parseInt($("#cr_r9_f7").val()) - parseInt($("#cr_r9_f6").val()));
					}
					
					var HBV = getmonthly_survivinginfants * 1.11 ;
					var HBVTotal = HBV + HBV/2;
					$("#cr_r10_f7").val(Math.round(HBVTotal/10));
					if(parseInt($("#cr_r10_f7").val()) > parseInt($("#cr_r10_f6").val())){
						$("#cr_r10_f8").val(parseInt($("#cr_r10_f7").val()) - parseInt($("#cr_r10_f6").val()));
					}
					
					var IPV = getmonthly_survivinginfants * 1.11 ;
					var IPVTotal = IPV + IPV/2;
					$("#cr_r11_f7").val(Math.round(IPVTotal/10));
					if(parseInt($("#cr_r11_f7").val()) > parseInt($("#cr_r11_f6").val())){
						$("#cr_r11_f8").val(parseInt($("#cr_r11_f7").val()) - parseInt($("#cr_r11_f6").val()));
					}
					
					var IPV2 = getmonthly_survivinginfants * 1.11 ;
					var IPVTotal2 = IPV2 + IPV2/2;
					$("#cr_r19_f7").val(Math.round(IPVTotal2/5));
					if(parseInt($("#cr_r19_f7").val()) > parseInt($("#cr_r19_f6").val())){
						$("#cr_r19_f8").val(parseInt($("#cr_r19_f7").val()) - parseInt($("#cr_r19_f6").val()));
					}
				}
			});
		}
	}
	/* Function to get selected facility incharge */
	function getIncharge(){
		var facode = $('#facode').val();
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: {facode:facode},
				url: "<?php echo base_url(); ?>Ajax_calls/getIncharge",
				success: function(result){
					var resultarray = JSON.parse(result);
					$("#incharge").val(resultarray['incharge']);
					
				}
			});
		}			
	}
	/*  */
	function check_status(){
		var facode = document.getElementById("facode").value;
		var month = document.getElementById("month").value;
		var year = document.getElementById("year").value;
		if(facode!=0){
			$.ajax({
				type: "POST",
				data: "year=" + year + "&month=" + month + "&facode=" + facode,
				url: "<?php echo base_url(); ?>Ajax_calls/check_status",
				success: function(result){
					var r = result.trim();
					if(r == "no"){
					}
				}
			});
		}
	}
	/*  */
	/* $('#facode,#month').on('change' , function (){
		var facode = document.getElementById("facode").value;
		var month = document.getElementById("month").value;
		mon = month - 1;
		var year = document.getElementById("year").value;
		var table = 'form_b_cr';
		var edit = 0;
		if(facode!=0){
		$.ajax({
			type: "POST",
			data: "year=" + year + "&month=" + mon + "&facode=" + facode,
			url: "<?php echo base_url(); ?>Ajax_calls/getHFOpeningBal",
			success: function(result){
				var r = result.trim();
				if(r == "no"){
				  //alert('You need to Enter Monthly Vaccination Report For Selected Month First ');
				   
				  set_opening_bal();
				  set_Rep_bal();
				  set_children_vacc();
				  set_max_stock_level();
				  getIncharge();
				 // check_status();
				}
				else{
					set_opening_bal();
					set_Rep_bal();
					set_children_vacc();
					set_max_stock_level();
					getIncharge();
					//check_status();
				}
			}
		  });
		  $.ajax({
				type: 'POST',
				data: "facode="+facode+"&year="+year+"&month="+month+"&edit="+edit+"&table="+table,
				url: "<?php echo base_url(); ?>Ajax_calls/validateExistRecord",
				success: function(result){
					var result = result.trim()
					if(result == 'Yes'){
						//$('#facode').val([]);
						//window.confirm("Report Freezed! You can not Add/Edit");
						if (confirm("Report Freezed! You can not Add/Edit")==true) {
							window.location.href = "<?php echo base_url(); ?>Data_entry/form_B_list";
						} else {
							window.location.reload();
						} 
					}			 
			}
		  });
		}
	}); */
	/*  */
	$(document).on('keydown', function(e){
		if(e.ctrlKey && e.which === 83){ // Check for the Ctrl key being pressed, and if the key = [S] (83)
			$("#save").click();
			e.preventDefault();
			return false;
		}
	});
});
	
</script>