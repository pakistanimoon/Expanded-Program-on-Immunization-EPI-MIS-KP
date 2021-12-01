<script type="text/javascript">
{
				"chart": {
					"caption": "Monthly Vaccination Coverage<?php //echo $distYear1; ?>",
					"subcaption": "Fully Immuinzed",
					"yaxisname": "Percentage",
					"xaxisname": "Year-Month",
					"yaxismaxvalue": "100",
					"numberPostfix": "%",
					"baseFont": "lato-regular",
					"rotatevalues": "0",
					"placevaluesinside": "0",
					//"valuefontcolor": "074868",
					"plotgradientcolor": "",
					"showcanvasborder": "1",
					"numdivlines": "5",
					"showyaxisvalues": "0",
					//"palettecolors": "#1790E1",
					"canvasborderthickness": "1",
					"canvasbordercolor": "#074868",
					"canvasborderalpha": "30",
					"basefontcolor": "#074868",
					"divlinecolor": "#074868",
					"divlinealpha": "10",
					"divlinedashed": "0",
					"theme": "zune",
					"valueFontColor": "#000000",
					"valueBgColor": "#FFFFFF",
					"valueBgAlpha": "50",
					"thousandSeparatorPosition": "3,3,3",
					//"paletteColors": "#008ee4,#9b59b6,#6baa01,#e44a00",
					"useDataPlotColorForLabels": "1",                    
					"exportenabled": "1",
					"exportatclient": "1",
					"exporthandler": "http://export.api3.fusioncharts.com",
					"html5exporthandler": "http://export.api3.fusioncharts.com" 
				},
				"data": [
						<?php foreach($monthlyVaccinationTrendForfullyimmunized as $key => $value){ ?>
							{
								"label": "<?php echo $value['fmonth']; ?>",
								"value": "<?php echo (isset($value['target']) && $value['target']!='0')?round(($value['monthlyvacc']*100)/$value['target']):''; ?>"
							}, 
						<?php } ?>
				],
				"trendlines": [
					{
						"line": [
							{
								"startvalue": "40",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "DD1E2F",
								"displayvalue": "0-40 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "60",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "EBB035",
								"displayvalue": "41-60 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "80",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "0B7546",
								"displayvalue": "61-80 %",
								"showontop": "1",
								"thickness": "2"
							},
							{
								"startvalue": "100",
								"endvalue": "",
								"istrendzone": "",
								"valueonright": "1",
								"color": "0B7546",
								"displayvalue": "100 %",
								"showontop": "1",
								"thickness": "2"
							}
						]
					}
				]
			}
</script>