<script type="text/javascript">
var chartGlobal = 0;
$(function () {
// Initiate the chart
	var form='<?php echo (isset($filter))?$filter:''; ?>';
	var dataSeries = <?php echo $serieses; ?>;
	var ucwisemap = '<?php echo (isset($ucwisemap))?$ucwisemap:'false'; ?>';
	var id = '<?php echo $id; ?>';
	var fmonth = '<?php echo (isset($fmonth))?$fmonth:''; ?>';
	var dataClasses = <?php echo (isset($colorAxis))?$colorAxis:'[]'; ?>;
	var titleText = '<?php echo $heading["mapName"]; ?>';
	var subtitle = '<?php if(isset($heading["subtittle"])){ echo $heading["subtittle"];}?>';
	var run = '<?php echo $heading["run"]; ?>';
	var casetype = '<?php echo (isset($casetype))?$casetype:""; ?>';
    $('#'+id).highcharts('Map', {
        title: {
            text: titleText
        },
		subtitle: {
			text: subtitle
		},
		credits: {
            enabled: true,
			href: 'http://pacetec.net/',
			text: 'Pace Technologies'
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
				return formatter(this,ucwisemap);
			}
		},
		colorAxis: dataClasses,
		plotOptions: {
                series: {
                    events: {
                        click: function (e) {
                        	eventHandler(e, run, fmonth, casetype);
						}
					},
					dataLabels:{
						align: 'center',
						enabled: true,
						allowOverlap : false,
						style:{
							fontSize : '8px',
							color : 'contrast'
						},
						formatter: function () {
							
							if(form=="populationcoverageratio"){
								return this.point.name;
							}else{
								return this.point.name+':'+this.point.value;
							}
						},
						backgroundColor: undefined,
						crop : false,
						overflow : "justify",
					}
				}
		},
		series: dataSeries,
		exporting: {
            buttons: {
                contextButton: {
					menuItems: [{
						textKey: 'downloadPNG',
						onclick: function () {
							this.exportChart({
								type : 'image/png'
							});
						}
					}, {
						textKey: 'downloadJPEG',
						onclick: function () {
							this.exportChart({
								type: 'image/jpeg'
							});
						}
					},{
						textKey: 'downloadPDF',
						onclick: function () {
							this.exportChart({
								type : 'application/pdf'
							});
						}
					}]
                }
            }
        }
    });
});
</script>