<div class="container">
	<form class="form-inline" method="post" action="<?php echo base_url(); ?>dashboard/AccessToHealthServices">
		<?php
		//$vaccineId = 1;
		if(isset($data)){
			$reportType = $data['reportType'];
			$vaccineId = $data['vaccineId'];
			$quarter = $data['quarter'];
			$gender = $data['gender'];
			$vaccineBy = $data['vaccineBy'];
		}
		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV','Rota-1','Rota-2','Measles-I','Fully Immunized','Measles-II');
		?>
		<input type="radio" value="yearly" <?php echo (isset($reportType) && $reportType=="yearly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Yearly
		<input type="radio" value="quarterly" <?php echo (isset($reportType) && $reportType=="quarterly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Quarterly
		<input type="radio" value="monthly" <?php echo (isset($reportType) && $reportType=="monthly")?'checked="checked"':''; ?> <?php echo (!isset($reportType))?'checked="checked"':''; ?> name="report_type" id="report_type" /> Monthly
		<br>
		<div class="form-group" id="yearDiv">
			<label>Year: </label>
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(); ?>
			</select>
		</div>
		<div class="form-group" id="monthDiv">
			<label>Month: </label>
			<select name="month" id="month" class="form-control" required="required">
				<?php getAllMonthsOptions(); ?>
			</select>
		</div>
		<div class="form-group" id="quarterDiv">
			<label>Quarter: </label>
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="01">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="02">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="03">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="04">Fourth</option>
			</select>
		</div>
		<div class="form-group" id="vaccineDiv">
			<label>Vaccine: </label>
			<select name="vaccine" id="vaccine" class="form-control" required="required">
				<option <?php echo (isset($vaccineId) && $vaccineId == "1")?'selected="selected"':''; ?> value="1">BCG</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "2")?'selected="selected"':''; ?> value="2">Hep B-Birth</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "3")?'selected="selected"':''; ?> value="3">OPV-0</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "4")?'selected="selected"':''; ?> value="4">OPV-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "5")?'selected="selected"':''; ?> value="5">OPV-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "6")?'selected="selected"':''; ?> value="6">OPV-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "7")?'selected="selected"':''; ?> value="7">PENTA-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "8")?'selected="selected"':''; ?> value="8">PENTA-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "9")?'selected="selected"':''; ?> value="9">PENTA-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "10")?'selected="selected"':''; ?> value="10">PCV10-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "11")?'selected="selected"':''; ?> value="11">PCV10-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "12")?'selected="selected"':''; ?> value="12">PCV10-3</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "13")?'selected="selected"':''; ?> value="13">IPV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "14")?'selected="selected"':''; ?> value="14">Rota-1</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "15")?'selected="selected"':''; ?> value="15">Rota-2</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">Measles-I</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "17")?'selected="selected"':''; ?> value="17">Fully Immunized</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "18")?'selected="selected"':''; ?> value="18">Measles-II</option>
			</select>
		</div>
		<div class="form-group">
			<label>Gender: </label>
			<select name="gender_wise" id="gender_wise" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "Male")?'selected="selected"':''; ?> value="Male">Male</option>
				<option <?php echo (isset($gender) && $gender == "Female")?'selected="selected"':''; ?> value="Female">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<div class="form-group">
			<label>Vaccination by: </label>
			<select name="session_type" id="session_type" class="form-control" required="required">
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Fixed")?'selected="selected"':''; ?> value="Fixed">Fixed</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Outreach")?'selected="selected"':''; ?> value="Outreach">Outreach</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Mobile")?'selected="selected"':''; ?> value="Mobile">Mobile</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "LHW")?'selected="selected"':''; ?> value="LHW">Health House</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "All")?'selected="selected"':''; ?> <?php echo (!isset($vaccineBy))?'selected="selected':''; ?> value="All">All</option>
			</select>
		</div>
		<button type="submit">Preview</button>
	</form>
	<div id="container" style="min-width: 310px;width:100%; height:550px; margin: 0 auto"></div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
var chartGlobal = 0;
$(function () {
	var serieses = <?php echo $serieses; ?>;
	var categoriess = <?php echo $category; ?>;
	//alert(serieses);
	Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
	
    $('#container').highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true/* ,
                alpha: 5,
                beta: 25,
                depth: 110 */
            }
        },

        title: {
            text: '<?php echo $vaccinesArray[$vaccineId-1]; ?>'+' Coverage'
        },

        xAxis: {
			type : 'category',
			labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			}
            //categories: [categoriess]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            tickInterval: 10,
            title: {
                text: '<?php echo $vaccinesArray[$vaccineId-1]; ?>'+' Coverage'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> '+'<?php echo $vaccinesArray[$vaccineId-1]; ?>'+' Coverage'+': {point.y}%'
        },

        plotOptions: {
            column: {
				allowPointSelect: true,
                depth: 40,
				colorByPoint: true,
				dataLabels: {
                    enabled: true,
					format: '{y}%', // your label's value plus the percentage sign
                },
                enableMouseTracking: true
				//stacking: 'normal',
            },
			
        },

        series: serieses
    });
	$(document).on('click','#report_type',function(){
		if($(this).val() == "yearly"){
			$('#monthDiv').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else{}
	});
});
$(document).ready(function(){
	if($('input[name=report_type]:checked').val() == "yearly"){
		$('#monthDiv').hide();
		$('#month').val('');
		$('#month').removeAttr('required','required');
		$('#quarterDiv').hide();
		$('#quarter').removeAttr('required','required');
	}else if($('input[name=report_type]:checked').val() == "quarterly"){
		$('#monthDiv').hide();
		$('#month').removeAttr('required','required');
		$('#quarterDiv').show();
		$('#quarter').attr('required','required');
	}else if($('input[name=report_type]:checked').val() == "monthly"){
		$('#monthDiv').show();
		$('#month').attr('required','required');
		$('#quarterDiv').hide();
		$('#quarter').removeAttr('required','required');
	}else{}	
});
$(document).on("click","#resizeId-uk",function(){
 	var $container = $('#container');
	chart = $container.highcharts();
	if(chartGlobal != 1){
		chartGlobal = 1;
		chart.setSize(1270,550,doAnimation = true);
	}else{
		chartGlobal = 0;
		chart.setSize(1100,550,doAnimation = true);
	}
	
	//$(window).resize();
});
</script>