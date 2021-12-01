<script type="text/javascript">
var $chartId = '<?php echo 'widgetname'.$pk_id; ?>';
Highcharts.chart($chartId, {
        chart: {
            type: 'bar',
			height:'100%'
        },
        title: {
            text: 'Thematic Map',
			style : { "fontSize": "14px" }
        },
		subtitle: {
			text: 'Dummy'
		},
		legend: {
			enabled: false
		},
        /* subtitle: {
            text: ''
        }, */
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: {
                step: 1,
                reserveSpace : true,
				style: { 
				"color":"#000",
				"fontSize":"10px"
				}
            }
        },
        yAxis: {
            min: 0,
            title: {
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true,
                    allowOverlap: false,
                    color: "black",
                    crop: false,	
                    overflow: "justify"
                }
            },
			series: {
				cursor: 'pointer',
				events: {
					click: function (event) {
						/* alert(
							'Alt: ' + event.altKey + '\n' +
							'Control: ' + event.ctrlKey + '\n' +
							'Meta: ' + event.metaKey + '\n' +
							'Shift: ' + event.shiftKey
						); */
					}
					/* click: function (e) {
                        	//getDistrictWiseData(e, fmonth);
						} */
				}
			}
        },
        /* legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'bottom',
            x: 10,
            y: -40,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        }, */
        credits: {
            enabled: true,
			href: 'http://pacetec.net/',
			text: 'Pace Technologies'
        },
        series: [{
        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

    }, {
        data: [129.9, 271.5, 306.4, 29.2, 544.0, 376.0, 435.6, 348.5, 216.4, 294.1, 35.6, 354.4]
    }],
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
</script>