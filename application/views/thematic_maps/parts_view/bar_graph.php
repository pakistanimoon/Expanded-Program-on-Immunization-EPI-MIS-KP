<script type="text/javascript">
function scrolltodiv(paramClass){
	$('html,body').animate({
		scrollTop: ($("."+paramClass).offset().top)-70},
        'slow');
}
$(function () {
	var code = '<?php echo (isset($code))?$code:NULL ?>';
	var form='<?php echo (isset($filter))?$filter:NULL; ?>';
	var plotLinesscolor = <?php echo (isset($plotYaxis))?$plotYaxis:0; ?>;
    var rankingDataSeries = <?php echo $serieses_ranking; ?>;
	var ucwisemap = '<?php echo (isset($ucwisemap))?$ucwisemap:'false'; ?>';
    var rankingCategories = <?php echo $serieses_ranking_cat; ?>;
    var titleText = '<?php echo $heading["barName"]; ?>';
	var subtitle = '<?php if(isset($heading["subtittle"])){ echo $heading["subtittle"];}?>';
    var in_out_coverage = '<?php echo (isset($in_out_coverage))?$in_out_coverage:""; ?>';
    var id = '<?php echo $id; ?>';//console.log(plotLinesscolor);
	var bartooltip = '<?php echo (isset($bartooltip))?$bartooltip:FALSE; ?>';
	var fmonth = '<?php (isset($fmonth))?$fmonth:''; ?>';
   Highcharts.chart(id, {
        chart: {
            type: 'bar',
			height:'200%'
        },
        title: {
            text: titleText,
			style : { "fontSize": "14px" }
        },
		subtitle: {
			text: subtitle
		},
		legend: {
			enabled: false
		},
        <?php if(isset($bartooltip) && $bartooltip){ ?>
		tooltip: {
			formatter: function () {
				return formatter(this,ucwisemap);
			}
		},
		<?php } ?>
        xAxis: {
            categories: rankingCategories[0],
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
                //text: 'Kyber Pakhtunkhaw',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            },
				plotLines : plotLinesscolor
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
					/* click: function (event) {
						alert(
							this.name + ' clicked\n' +
							'Alt: ' + event.altKey + '\n' +
							'Control: ' + event.ctrlKey + '\n' +
							'Meta: ' + event.metaKey + '\n' +
							'Shift: ' + event.shiftKey
						);
					} */
					<?php if (!$this->agent->is_mobile()){ ?>
					click: function (e) {
							getDistrictWiseData(e, fmonth);
						}
					<?php } ?>
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
        series: rankingDataSeries,
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
