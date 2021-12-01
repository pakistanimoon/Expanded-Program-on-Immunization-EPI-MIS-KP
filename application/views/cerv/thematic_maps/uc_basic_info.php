<?php

	$month = (isset($data['month']))?$data['month']:''; 

	$year = (isset($data['year']))?$data['year']:'';

	$basicInfo = (isset($data['basicInfo']))?$data['basicInfo']:'VTPR';

	$fmonth = $year.'-'.$month;

	$title = array(

		'VTPR' => 'Vaccinatior to Population Ratio',

		'HFTVR' => 'Health Facilities to Vaccinatior Ratio',

		'LHWSIIV' => 'LHWs Involved in Vaccination'

	);

?>

<div class="container">

	<form class="form-inline" method="post" action="<?php echo base_url(); ?>maps/BasicInfo">

		

		<div class="form-group hide" id="yearDiv">

			<label>Year: </label>

			<select name="year" class="form-control" required="required">

				<?php getEpiWeekYearsOptions(false); ?>

			</select>

		</div>

		<div class="form-group hide" id="monthDiv">

			<label>Month: </label>		

			<select name="month" class="form-control" required="required">

				<?php getAllMonthsOptionsNew(false,$month); ?>

			</select>

		</div>

		<div class="form-group" id="hrDiv">

			<label>Human Resource: </label>

			<select name="basicInfo" class="form-control" required="required">

				<option <?php echo ($basicInfo == "VTPR")?'selected="selected"':''; ?>  value='VTPR'>Vaccinatior to Population Ratio</option>

				<option <?php echo ($basicInfo == "HFTVR")?'selected="selected"':''; ?>  value='HFTVR'>Health Facilities to Vaccinatior Ratio</option>

				<option <?php echo ($basicInfo == "LHWSIIV")?'selected="selected"':''; ?>  value='LHWSIIV'>LHWs Involved in Vaccination</option>

			</select>

		</div>

		<button type="submit">Preview</button>

	</form>

	<div id="container" style="min-width: 310px;width:1100px; height:750px; margin: 0 auto"></div>

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

            text: '<?php echo $title[$basicInfo]; ?>'

        },

		subtitle: {

            text: 'Union Council Wise Map',

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

				return 'Union Council: <b>' + this.point.name + ' (' + this.point.id + ')' + '</b><br> ' + '<?php echo $title[$basicInfo]; ?> : <b>' + this.point.value + ' %</b>';

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

		series: dataSeries

    });

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