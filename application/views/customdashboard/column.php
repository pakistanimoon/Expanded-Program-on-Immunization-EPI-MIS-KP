<?php
	$i=0;
	$seriesName = getSubIndicatorName(true,$sub_indicator_id). ' ' .getIndicatorName(true,$indicator_id);
	foreach($result as $key => $value){
		$categories[] = $value['name'];
		$series['name'] = $seriesName;
		$series['data'][$i]['name'] = $value['name'];
		$series['data'][$i]['code'] = $value['code'];
		$series['data'][$i++]['y'] = (isset($value['value']))?$value['value']:'';
	}
	$categories = json_encode($categories);
	$series = json_encode($series,JSON_NUMERIC_CHECK);
?>
<script type="text/javascript">
	var $chartId = '<?php echo 'widgetname'.$pk_id; ?>';
	var $categories = <?php echo $categories; ?>;
	var $series = <?php echo $series; ?>;
	Highcharts.chart($chartId, {
        chart: {
            type: 'column',
			height:'100%'
        },
        title: {
            text: '<?php echo getIndicatorName(false,$indicator_id); ?>',
			style : { "fontSize": "14px" }
        },
		subtitle: {
			text: '<?php echo getSubIndicatorName(false,$sub_indicator_id); ?>'
		},
		legend: {
			enabled: false
		},
		tooltip: {
			valueDecimals: 2
		},
        xAxis: {
            categories: $categories,
            labels: {
                step: 1,
                reserveSpace : true,
				style: { 
					"color":"#000",
					"fontSize":"10px"
				},
				rotation: 90
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
            column: {
                dataLabels: {
                    enabled: true,
                    allowOverlap: false,
                    color: "black",
                    crop: false,	
                    overflow: "justify"
                }
            },
			series: {
				dataLabels: {
					enabled: true,
					formatter: function () {
						return Highcharts.numberFormat(Math.round(this.y),0);
					}
				},
				cursor: 'pointer',
				events: {
					click: function (event) {
						// code...
					}
				}
			}
        },
        credits: {
            enabled: true,
			href: 'http://pacetec.net/',
			text: 'Pace Technologies'
        },
        series: [$series],
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