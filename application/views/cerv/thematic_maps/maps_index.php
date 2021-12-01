<?php

	$month = (isset($data['month']))?$data['month']:''; 

	$year = (isset($data['year']))?$data['year']:'';

	$fmonth = $year.'-'.$month;

?>

<div class="container bodycontainer">

	<div class="row">

		<div class="col-md-12">

			<div id="pop1" class="simplePopup" style="position: absolute; top: 400px; left: 143px;height: 500px;scroll-y: auto;overflow-y:  auto;overflow-x: hidden;"><div class="simplePopupClose">X</div>

				<div class="header" style="background-color:#057140 !important;">

					<span>Facilities Wise Data for Year-Month (<?php echo $fmonth; ?>)</span>

				</div>

				<div id="loadView"></div>

			</div>

		</div>

	</div>

	<div class="loading hide">Loading&#8230;</div>

</div>

<div class="container">

	<form class="form-inline" method="post" action="<?php echo base_url(); ?>thematic_maps/Maps_Main">

		<div class="form-group" id="yearDiv">

		<label>Year: </label>

		<select name="year" class="form-control" required="required">

			<?php getEpiWeekYearsOptions(false); ?>

		</select>

		</div>

		<div class="form-group" id="monthDiv">

		<label>Month: </label>		

		<select name="month" class="form-control" required="required">

			<?php getAllMonthsOptionsNew(false,$month); ?>

		</select>

		</div>

		<button type="submit">Preview</button>

	</form>

	<div id="container" style="min-width: 310px;width:1100px; height:750px; margin: 0 auto"></div>

	<div id="container1" class="hide" style="min-width: 310px;width:1100px; height:750px; margin: 0 auto"></div>	

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

            text: 'District Wise Compliance'

        },

		subtitle: {

            text: 'KPK Province',

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

				return 'District: <b>' + this.point.name + ' (' + this.point.id + ')' + '</b><br>Year-Month: <b>' + this.point.fmonth  + '</b><br> Total Due: <b>' + this.point.due  + '</b><br> Total Submitted: <b>' + this.point.sub + '</b><br> Percentage: <b>' + this.point.value + ' %</b>';

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

							draw_a_new_map(e.point.id);

							$('.loading').removeClass('hide');

						}

					}

				}

		},

		series: dataSeries

    });

});

function draw_a_new_map(id){

	var dataId = id;

	var fmonth = '<?php echo $fmonth; ?>';

	$.ajax({

		type: "POST",

		data: {id:dataId,fmonth:fmonth},

		url: "<?php echo base_url(); ?>maps/Maps_Main/UcWiseMapData",

		dataType: "json",

		success: function(result){

			draw_a_new_UC_map(result);

		}

	});	

}

function draw_a_new_UC_map(seriesNew){

	$('#container1').removeClass('hide');

	$("html, body").delay(500).animate({

        scrollTop: $('#container1').offset().top 

    }, 500);

	$('#container1').highcharts('Map', {

        title: {

            text: 'UC Wise Compliance'

        },

		subtitle: {

            text: 'UC Wise Map',

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

			x: -100,

			y: 70,

			floating: true,

			layout: 'vertical',

			valueDecimals: 0,

			backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255, 255, 255, 0.85)'

		},

		tooltip: {

			formatter: function () {

				return 'UnionCounci: <b>' + this.point.name + ' (' + this.point.id + ')' + '</b><br>Year-Month: <b>' + this.point.fmonth  + '</b><br> Total Due: <b>' + this.point.due  + '</b><br> Total Submitted: <b>' + this.point.sub + '</b><br> Percentage: <b>' + this.point.value + ' %</b>';

			}

		},

		colorAxis: {

			dataClasses: [{

				from: 0,

				to: 40,

				color: '#DD1E2F',

				name: '0 to 40'

			}, {

				from: 41,

				to: 60,

				color: '#EBB035',

				name: '41 to 60'

			}, {

				from: 61,

				to: 80,

				color: '#06A2CB',

				name: '61 to 80'

			}, {

				from: 81,

				to: 100,

				color: '#0B7546',

				name: '81 and above'

			}]

		},

		plotOptions: {

                series: {

                    events: {

                        click: function (e) {

							getUcDetails(e.point.id,e.point.name);

							if(e.point.id != 0)

								$('.loading').removeClass('hide');

						}

					}

				}

		} ,

		series: seriesNew

    });

	$('.loading').addClass('hide');

}

function getUcDetails(id,name){

	if(id == 0){

		alert("Unioncouncil ''" + name + "'' is not related to EPI!");

	}else{		

		var dataId = id;

		var fmonth = '<?php echo $fmonth; ?>';

		$.ajax({

			type: "POST",

			data: 'id='+dataId+'&fmonth='+fmonth,

			url: "<?php echo base_url(); ?>maps/Maps_Main/getUcDetails",

			success: function(result){

				$('#loadView').html(result);

				$('.loading').addClass('hide');

				$('#pop1').simplePopup();

			}

		});	

	}

	

}

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