

	<form class="form-inline" method="post" action="<?php echo base_url(); ?>maps/AccessToHealthServices">

		<?php

		if(isset($data)){

			$reportType = $data['reportType'];

			$vaccineId = $data['vaccineId'];

			$quarter = $data['quarter'];

			$gender = $data['gender'];

			$vaccineBy = $data['vaccineBy'];

			if($reportType == 'monthly')

				$fmonth = $data['year']."-".$data['month'];

			else if($reportType == 'quarterly')

				$fmonth = $quarter." Quarter";

			else if($reportType == 'yearly')

				$fmonth = $data['year']." (Yearly)";

		}

		$vaccinesArray = array('BCG','Hep B-Birth','OPV-0','OPV-1','OPV-2','OPV-3','PENTA-1','PENTA-2','PENTA-3','PCV10-1','PCV10-2','PCV10-3','IPV-1','Rota-1','Rota-2','MR-I','Fully Immunized','MR-II','DTP','TCV','IPV-2');

		?>

		<input type="radio" value="yearly" <?php echo (isset($reportType) && $reportType=="yearly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Yearly

		<input type="radio" value="quarterly" <?php echo (isset($reportType) && $reportType=="quarterly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Quarterly

		<input type="radio" value="monthly" <?php echo (isset($reportType) && $reportType=="monthly")?'checked="checked"':''; ?> <?php echo (!isset($reportType))?'checked="checked"':''; ?> name="report_type" id="report_type" /> Monthly

		<br>

		<div class="form-group" id="yearDiv">

			<label>Year: </label>

			<select name="year" id="year" class="form-control" required="required">

				<?php getEpiWeekYearsOptions(false); ?>

			</select>

		</div>

		<div class="form-group" id="monthDiv">

			<label>Month: </label>

			<select name="month" id="month" class="form-control" required="required">

				<?php getAllMonthsOptionsNew(false,$month); ?>

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

				<option <?php echo (isset($vaccineId) && $vaccineId == "13")?'selected="selected"':''; ?> value="13">IPV-1</option>

				<option <?php echo (isset($vaccineId) && $vaccineId == "14")?'selected="selected"':''; ?> value="14">Rota-1</option>

				<option <?php echo (isset($vaccineId) && $vaccineId == "15")?'selected="selected"':''; ?> value="15">Rota-2</option>

				<option <?php echo (isset($vaccineId) && $vaccineId == "16")?'selected="selected"':''; ?> value="16">MR-I</option>

				<!--<option <?php echo (isset($vaccineId) && $vaccineId == "17")?'selected="selected"':''; ?> value="17">Fully Immunized</option>-->

				<option <?php echo (isset($vaccineId) && $vaccineId == "18")?'selected="selected"':''; ?> value="18">MR-II</option>
				
				<!--<option <?php echo (isset($vaccineId) && $vaccineId == "19")?'selected="selected"':''; ?> value="19">DTP</option>-->
				<option <?php echo (isset($vaccineId) && $vaccineId == "20")?'selected="selected"':''; ?> value="20">TCV</option>
				<option <?php echo (isset($vaccineId) && $vaccineId == "21")?'selected="selected"':''; ?> value="21">IPV-2</option>
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

	<div id="container" style="min-width: 310px;width:100%; height:850px; margin: 0 auto"></div>

</div>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>

<script src="https://code.highcharts.com/maps/modules/heatmap.js"></script>

<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script src="<?php echo base_url(); ?>includes/js/jquery.simplePopup.js"></script>

<script type="text/javascript">

var chartGlobal = 0;

$(function () {

// Initiate the chart

	var dataSeries = <?php echo $serieses; ?>;

    $('#container').highcharts('Map', {

        title: {

            text: '<?php echo $vaccinesArray[$vaccineId-1]; ?>'+' Coverage'

        },

		subtitle: {

            text: 'Union Council Wise Coverage',

            floating: false,

            align: 'center',

            y: 50,

            style: {

                fontSize: '18px'

            }

        },

		mapNavigation: {

            enabled: true,

            buttonOptions: {

                verticalAlign: 'bottom'

            }

        },

		legend: {

			align: 'left',

			verticalAlign: 'top',

			x: 0,

			y: 70,

			floating: true,

			layout: 'vertical',

			valueDecimals: 0,

			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)'

		},

		tooltip: {

			formatter: function () {

				return 'Union Council: <b>' + this.point.name + ' (' + this.point.id + ')' + '</b><br> Year-Month: <b>' + '<?php echo $fmonth; ?>' + '</b><br> ' + '<?php echo $vaccinesArray[$vaccineId-1]; ?> Coverage: <b>' + this.point.value + ' %</b>';

			}

		},

		colorAxis: {

			dataClasses: [{

				from: 0,

				to: 40,

				color: '#DD1E2F',

				name: '0 to 40'

			}, {

				from: 40.01,

				to: 60,

				color: '#EBB035',

				name: '41 to 60'

			}, {

				from: 60.01,

				to: 80,

				color: '#06A2CB',

				name: '61 to 80'

			}, {

				from: 80.01,

				to: 1000,

				color: '#0B7546',

				name: '81 and above'

			}]

		},

		plotOptions: {

                series: {

                    events: {

                        click: function (e) {

							//draw_a_new_map(e.point.id);

							//$('.loading').removeClass('hide');

						}

					}

				}

		},

		series: dataSeries

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

});

</script>