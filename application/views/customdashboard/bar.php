<?php
	$i=0;
	foreach($result as $key => $value){
		$categories[] = $value['name'];
		for($j=0;$j<$noofseries;$j++){
			$num = $j+1;
			$series[$j]['name'] = (isset($seriesNames[$j]['series_name']))?$seriesNames[$j]['series_name']:'';
			if(isset($seriesNames[$j]['extra_value_divider']) && $seriesNames[$j]['extra_value_divider'] > 0){
				$series[$j]['data'][] = (isset($value["value{$num}"]))?$value["value{$num}"]/$seriesNames[$j]['extra_value_divider']:'';
			}
			else{
				$series[$j]['data'][] = (isset($value["value{$num}"]))?$value["value{$num}"]:'';
			}
		}
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
            type: 'bar',
			height:'220%'
        },
        title: {
            text: '<?php echo getIndicatorName(false,$indicator_id); ?>',
			style : { "fontSize": "14px" }
        },
		subtitle: {
			text: '<?php echo getSubIndicatorName(false,$sub_indicator_id); ?>'
		},
		legend: {
			enabled: true
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
            },
			rotation: 180
        },
        plotOptions: {
            /* bar: {
                dataLabels: {
                    enabled: true,
                    allowOverlap: false,
                    color: "black",
                    crop: false,	
                    overflow: "justify"
                }
            }, */
			series: {
				cursor: 'pointer',
				dataLabels: {
					enabled: true,
					formatter: function () {
						return Highcharts.numberFormat(Math.round(this.y),0);
					}
				},
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
        series: $series,
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