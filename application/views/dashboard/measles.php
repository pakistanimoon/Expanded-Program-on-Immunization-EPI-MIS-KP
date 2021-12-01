<div class="container">
	<form class="form-inline" method="post" action="<?php echo base_url(); ?>dashboard/ConsumptionAndRequistion">
		<div class="form-group" id="yearDiv">
		<label>Year: </label>
		<select name="year" class="form-control" required="required">
			<?php getEpiWeekYearsOptions(false); ?>
		</select>
		</div>
		<div class="form-group" id="monthDiv">
		<label>Month: </label>
		<select name="month" class="form-control" required="required">
			<?php getAllMonthsOptionsIncludingCurrent(false); ?>
		</select>
		</div>
		<button type="submit">Preview</button>
	</form>
	<div id="container" style="min-width: 310px; height:550px; margin: 0 auto"></div>
</div>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
var chartGlobal = 0;
$(function () {
    // Create the chartdrilldownSeries
	var result = <?php echo $result; ?>;
	var categoriess = <?php echo $category; ?>;
	var drilldownSeries = <?php echo (!$this -> session -> District)?$drilldownSeries:'null'; ?>;
	
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
                enabled: false
            }
        },
		colors:['rgb(124, 181, 236)','rgb(144, 237, 125)'],
        title: {
            text: 'HF Consumption & Requisition Compliance'
        },
        subtitle: {
            text: 'Due  Vs. Submitted'
        },
        xAxis: {
            type : 'category',
			labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			}
        },
        yAxis: {
            min: 0,
            title: {
                text: 'No of Due vs. Submitted Reports'
            },
			allowDecimals : false
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.1,
                borderWidth: 0,
				colorByPoint: false,
				dataLabels: {
                    enabled: true,
					align: "center",
					allowOverlap: false,
					style: {
                        fontWeight: 'bold',
						color: 'white'
                    }
                },
                enableMouseTracking: true
            },
			/* series:{
				stacking:'normal'
			} */
        },
        series: result<?php if(!$this->session->District){ ?>,
		drilldown: {
			allowPointDrilldown: true,
			series: drilldownSeries[0]
		}
		<?php } ?>
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
	
	//$(window).resize();
});
</script>