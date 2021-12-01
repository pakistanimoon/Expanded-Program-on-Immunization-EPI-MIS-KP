<?php
$trendlines=false;

 //print_r($data);?>
{
    "chart": {
        "caption": "<?php echo $caption; ?>",
        "xAxisname": "<?php echo $xAxisname; ?>",
        "yAxisName": "<?php echo $yAxisName; ?>",
        "numberPrefix": "<?php echo $numberPrefix; ?>",
        "plotFillAlpha": "80",
        "paletteColors": "<?php echo (isset($paletteColors)?$paletteColors:null); ?>",
        "baseFontColor": "#333333",
        "baseFont": "Helvetica Neue,Arial",
        "captionFontSize": "14",
        "subcaptionFontSize": "14",
        "subcaptionFontBold": "0",
        "showBorder": "0",
        "bgColor": "#ffffff",
        "showShadow": "0",
        "canvasBgColor": "#ffffff",
        "canvasBorderAlpha": "0",
        "divlineAlpha": "100",
        "divlineColor": "#999999",
        "divlineThickness": "1",
        "divLineDashed": "1",
        "divLineDashLen": "1",
        "usePlotGradientColor": "0",
        "showplotborder": "0",
        "valueFontColor": "#ffffff",
        "placeValuesInside": "1",
        "showHoverEffect": "1",
        "rotateValues": "1",
        "showXAxisLine": "1",
        "xAxisLineThickness": "1",
        "xAxisLineColor": "#999999",
        "showAlternateHGridColor": "0",
        "legendBgAlpha": "0",
        "legendBorderAlpha": "0",
        "legendShadow": "0",
        "legendItemFontSize": "10",
        "legendItemFontColor": "#666666"
    },
    "categories": [
        {
            "category": <?php echo $categories; ?>
        }
    ],
    "dataset": [
	<?php 
	$count = count($serieses);
	foreach($serieses as $key => $series){ ?>
        {
            "seriesname": "<?php echo $series['seriesname']; ?>",
            "data": <?php echo $series['data']; ?>
        }<?php echo ($count == $key+1)?'':','; ?>
	<?php } ?>
    ]
	
	<?php if($trendlines == true){ ?>
	,
    "trendlines": [
        {
            "line": [
                {
                    "startvalue": "80",
                    "color": "#0075c2",
                    "displayvalue": "<?php echo $trendlines_displayvalue; ?>",
                    "valueOnRight": "1",
                    "thickness": "1",
                    "showBelow": "1",
                    "tooltext": "<?php echo $trendlines_tooltext; ?>"
                }
            ]
        }
    ]
	<?php } ?>
}