<div class="container">
	<div id="container" style="min-width: 310px;width:1100px; height:550px; margin: 0 auto"></div>
	<div id="container1" class="hide" style="min-width: 310px;width:1100px; height:550px; margin: 0 auto">
		
	</div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
var chartGlobal = 0;
$(function () {
    // Create the chartdrilldownSeries
	var result = <?php echo $result; ?>;
	var categoriess = <?php echo $category; ?>;
	
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
            text: 'Districts Population'
        },
        subtitle: {
            text: 'Population'
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
                text: 'Districts Population'
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
                enableMouseTracking: true
            },
			series: {
				events: {
					click: function (e) {
						draw_a_new_map(e.point.id);
					}
				}
			}
		},
        series: result
    });
});
function draw_a_new_map(id){
	var dataId = id;
	$.ajax({
		type: "POST",
		data: {id:dataId},
		url: "<?php echo base_url(); ?>dashboard/Test/getFacilitiesPopulation",
		dataType: "json",
		success: function(result){
			draw_a_new_column(result[0]);
		}
	});
	$('#container1').removeClass('hide');
	$("html, body").delay(1000).animate({
        scrollTop: $('#container1').offset().top 
    }, 1000);
	
}
function draw_a_new_column(seriesNew){
	console.log(seriesNew);
	$('#container1').highcharts({
        chart: {
            type: 'column',
			options3d: {
                enabled: false
            }
        },
		colors:['rgb(124, 181, 236)','rgb(144, 237, 125)'],
        title: {
            text: 'Facilities Population'
        },
        subtitle: {
            text: 'Population'
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
                text: 'Facilities Population'
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
                enableMouseTracking: true
            },
			/* series: {
				events: {
					click: function (e) {
						draw_a_new_map(e.point.id);
					}
				}
			} */
		},
        series: [seriesNew]
    });
}
</script>