<?php //echo $in_out_coverage; exit(); ?>
<table class="table" style="margin-bottom: 0px;float: right;display: block;">
	<input type="hidden" name="code" id="code" value="">
	<tbody>
	<?php if(!isset($services))
		{ 
			$services = "outreach";
		}
		?>
		<tr>
			<td style="vertical-align: middle;font-weight: bold;text-align: right;">EPI Services:
			</td>
			<td>
				<select name="services" id="services" class="form-control" required="required">
					<option <?php echo (isset($services) && $services=='fixed')?'selected="selected"':''; ?> value="fixed">Fixed</option>
					<option <?php echo (isset($services) && $services=='outreach')?'selected="selected"':''; ?> value="outreach">Outreach</option>
					<option <?php echo (isset($services) && $services=='healthhouse')?'selected="selected"':''; ?> value="healthhouse">Health House</option>
				</select>
			</td>
		<!-- <td style="vertical-align: middle;font-weight: bold;text-align: right;">Year: </td>
		<td>
			<select name="year" id="year1" class="form-control" required="required">
				<?php getAllYearsOptions(false,$yearto); ?>
			</select>
		</td>
		<td style="vertical-align: middle;font-weight: bold;text-align: right;">Month: </td>
		<td>
			<select name="month" id="month1" class="form-control" required="required">
				<?php getAllMonthsOptionsNew(false,$yearto,$monthto); ?>
			</select>
		</td> -->
		<td style="vertical-align: middle;font-weight: bold;text-align: right;">From: </td>
		<td class="form-group monthfromto">		 
			<input type="text" name="fmonthfrom" value="<?php echo (isset($fmonthfrom)?$fmonthfrom:'') ?>" id="monthfrom" class="form-control filter-status dp-my fYearMonth" placeholder="Period From" required="required" data-date-end-date='-1d' >
		</td>
		<td style="vertical-align: middle;font-weight: bold;text-align: right;">To: </td>
		<td class="form-group monthfromto">		 
			<input type="text" name="fmonthto" value="<?php echo (isset($fmonthto)?$fmonthto:'') ?>" id="monthto" class="form-control filter-status dp-my fYearMonth" placeholder="Period To" required="required" data-date-end-date='-1d' >
		</td>
		<td style="vertical-align: middle;font-weight: bold;text-align: right;">Vaccine: </td>
		<td>
			<select name="vaccineId" id="vaccineId" class="form-control" required="required">
				<option value="1" <?php echo (isset($vaccineId) && $vaccineId=='1')?'selected="selected"':''; ?>>BCG</option>
				<option value="2" <?php echo (isset($vaccineId) && $vaccineId=='2')?'selected="selected"':''; ?>>Hep B-Birth</option>
				<option value="3" <?php echo (isset($vaccineId) && $vaccineId=='3')?'selected="selected"':''; ?>>OPV-0</option>
				<option value="4" <?php echo (isset($vaccineId) && $vaccineId=='4')?'selected="selected"':''; ?>>OPV-1</option>
				<option value="5" <?php echo (isset($vaccineId) && $vaccineId=='5')?'selected="selected"':''; ?>>OPV-2</option>
				<option value="6" <?php echo (isset($vaccineId) && $vaccineId=='6')?'selected="selected"':''; ?>>OPV-3</option>
				<option value="7" <?php echo (isset($vaccineId) && $vaccineId=='7')?'selected="selected"':''; ?>>PENTA-1</option>
				<option value="8" <?php echo (isset($vaccineId) && $vaccineId=='8')?'selected="selected"':''; ?>>PENTA-2</option>
				<option value="9" <?php echo (isset($vaccineId) && $vaccineId=='9')?'selected="selected"':''; ?>>PENTA-3</option>
				<option value="10" <?php echo (isset($vaccineId) && $vaccineId=='10')?'selected="selected"':''; ?>>PCV10-1</option>
				<option value="11" <?php echo (isset($vaccineId) && $vaccineId=='11')?'selected="selected"':''; ?>>PCV10-2</option>
				<option value="12" <?php echo (isset($vaccineId) && $vaccineId=='12')?'selected="selected"':''; ?>>PCV10-3</option>
				<option value="13" <?php echo (isset($vaccineId) && $vaccineId=='13')?'selected="selected"':''; ?>>IPV-1</option>
				<option value="14" <?php echo (isset($vaccineId) && $vaccineId=='14')?'selected="selected"':''; ?>>Rota-1</option>
				<option value="15" <?php echo (isset($vaccineId) && $vaccineId=='15')?'selected="selected"':''; ?>>Rota-2</option>
				<option value="16" <?php echo (isset($vaccineId) && $vaccineId=='16')?'selected="selected"':''; ?>>MR-I</option>
				<!--<option value="17" <?php echo (isset($vaccineId) && $vaccineId=='17')?'selected="selected"':''; ?>>Fully Immunized</option>-->
				<option value="18" <?php echo (isset($vaccineId) && $vaccineId=='18')?'selected="selected"':''; ?>>MR-II</option>
				<!--<option value="19" <?php echo (isset($vaccineId) && $vaccineId=='19')?'selected="selected"':''; ?>>DTP </option>-->
				<option value="20" <?php echo (isset($vaccineId) && $vaccineId=='20')?'selected="selected"':''; ?>>TCV</option>
				<option value="21" <?php echo (isset($vaccineId) && $vaccineId=='21')?'selected="selected"':''; ?>>IPV-2</option>
			</select>		
		</td>
		<!--<td style="vertical-align: middle;font-weight: bold;"><button type="submit" class="btnclick" style="/*! vertical-align: middle; *//*! font-weight: bold; */padding: 4px;"> Preview </button>-->
		<td style="vertical-align: middle;font-weight: bold;"><button type="submit" class="btnclick"> Preview </button>
		
		</td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
	$(document).ready(function(){
		$(".dp-my").datepicker({
			autoclose: true,
			format: "yyyy-mm",
			startDate: '2016-01',
			viewMode: "months", 
			minViewMode: "months",
			endDate: new Date()
		});
		$("#monthfrom").datepicker({
		}).on('changeDate', function (selected) {		
			var fromDate = new Date(selected.date.valueOf());
			$('#monthto').datepicker('setStartDate', fromDate);
		});
	});
	$(document).on('click', '.btnclick', function (){
		var targetFlow='<?php echo $filterowbtn; ?>';
		var services=$('#services').val();
		var fmonthfrom=$('#monthfrom').val();
		var fmonthto=$('#monthto').val();
		var vaccineId=$('#vaccineId').val();
		var code=$('#code').val();
		var reportType="yearly";
		var fmonth="";
		if(monthfrom!=''){
			reportType="monthly";
			//fmonth =month+"-"+year;
		}
		if(code.length=="3"){
			var data = {distcode:code,vaccineId:vaccineId,reportType:reportType,services:services,fmonthfrom:fmonthfrom,fmonthto:fmonthto,fmonth:fmonth};
		}else{
			var data = {uncode:code,vaccineId:vaccineId,reportType:reportType,services:services,fmonthfrom:fmonthfrom,fmonthto:fmonthto,fmonth:fmonth};
		}
		$.ajax({
			type: "POST",
			data: data,
			async:false,
			url: "<?php echo base_url(); ?>thematic_maps/"+targetFlow+"/getUC_detailData",
			success: function(result){
				$('.ucdetailsdata').html('');
				$('.ucdetailsdata').html(result);
				$('#code').val(code);
				scrolltodiv('filterRow');
			}
		});
	});
	$(document).on('change','#year1', function(){
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
			url: "<?php echo base_url(); ?>Ajax_calls/<?php echo (isset($includeCurrentMonth))?"getMonthswithCurrent":"getMonths"; ?>",
			success: function(result){
				$('#month1').html(result);
			}
		});
	});
</script>