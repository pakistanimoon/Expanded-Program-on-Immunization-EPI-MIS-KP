<div class="container">
	<form class="form-inline" method="post" action="<?php echo base_url(); ?>dashboard/SessionInformation/sessionInfo">
		
		<input type="radio" value="yearly" <?php echo (isset($reportType) && $reportType=="yearly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Yearly
		<!--<input type="radio" value="quarterly" <?php echo (isset($reportType) && $reportType=="quarterly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Quarterly-->
		<input type="radio" value="monthly" <?php echo (isset($reportType) && $reportType=="monthly")?'checked="checked"':''; ?> <?php echo (!isset($reportType))?'checked="checked"':''; ?> name="report_type" id="report_type" /> Monthly
		<br>
		<div class="form-group" id="yearDiv">
			<label>Year: </label>
			<select name="year" id="year" class="form-control" required="required">
				<?php getAllYearsOptions(); ?>
			</select>
		</div>
		<div class="form-group" id="monthDiv">
			<label>Month: </label>
			<select name="month" id="month" class="form-control" required="required">
				<?php getAllMonthsOptions(); ?>
			</select>
		</div>
		<!--<div class="form-group" id="quarterDiv">
			<label>Quarter: </label>
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="01">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="02">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="03">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="04">Fourth</option>
			</select>
		</div>-->
		<div class="form-group">
			<label>Vaccination by: </label>
			<select name="session_type" id="session_type" class="form-control" required="required">
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Fixed")?'selected="selected"':''; ?> value="Fixed">Fixed</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Outreach")?'selected="selected"':''; ?> value="Outreach">Outreach</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "LHW")?'selected="selected"':''; ?> value="LHW">Health House</option>
			</select>
		</div>
		<button type="submit">Preview</button>
	</form>
	<div id="container" style="min-width: 310px;width:100%; height:450px; margin: 0 auto"></div>
	<div id="containerfac" style="min-width: 310px;width:100%; height:1000px; margin: 0 auto"></div>
	<div id="containerfacmonth" style="min-width: 310px;width:100%; height:550px; margin: 0 auto"></div>
	</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
var chartGlobal = 0;
$(function () {
	var serieses = <?php echo $serieses; ?>;
	var categoriess = <?php echo $category; ?>;
	
	//alert("dan");
	//alert(serieses);
	//console.log(serieses);
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
            type: 'column'/*,
            options3d: {
                enabled: true/* ,
                alpha: 5,
                beta: 25,
                depth: 110 
            }*/
        },

        title: {
            text: 'Sessions Planned/Conducted'
        },

        xAxis: {
			type : 'category',
			/*labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			},*/
            categories: categoriess
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
           // tickInterval: 10,
            title: {
                text: ''
            }
        },

        tooltip: {
           // headerFormat: '<b>{point.key}</b><br>'
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y} </b></td></tr>',
			footerFormat: '</table>',
            shared: true,
            useHTML: true
        },

      /*  plotOptions: {
            column: {
				allowPointSelect: true,
                depth: 40,
				colorByPoint: true,
				dataLabels: {
                    enabled: true,
					format: '{y}', // your label's value plus the percentage sign
                },
                enableMouseTracking: true
				//stacking: 'normal',
            },
			
        },*/
		plotOptions: {
        column: {
            pointPadding: 0.5,
            borderWidth: 0,
			dataLabels: {
                    enabled: true,
					format: '{y}', // your label's value plus the percentage sign
                },
			groupPadding: 0.1
        },
		series: {
			  pointWidth: 13,
			 // color: '#FF0000',
			 //stacking: 'normal',      
			  events:{
				   click: function (e) {
					//console.log(e.point.distcode);
					draw_new_graph(e.point.distcode);
				   
				  }
			  }
      }
    },
		
        series: serieses
    });
});
function draw_new_graph(dist){
 var year = '<?php echo $year;?>';
 var month = '<?php echo $month;?>';
 var reportType = '<?php echo $reportType; ?>';
 var session_type = '<?php echo $vaccineBy; ?>';
 $.ajax({
  type: "POST",
  data: {year:year,dist:dist,month:month,reportType:reportType,session_type:session_type},
  url: "<?php echo base_url(); ?>dashboard/SessionInformation/sessionInfoFac",
  dataType: "json",
  success: function(result){
   //console.log(result);
   newG(result.serieses,result.category);
  }
 });
}
function newG(res,cat){
	//alert("danish");
 $("html, body").delay(500).animate({
        scrollTop: $('#containerfac').offset().top 
    }, 500);
	//console.log(cat);
	//console.log(res);
	$('#containerfac').highcharts({
        chart: {
            type: 'bar'/*,
            options3d: {
                enabled: true ,
                alpha: 5,
                beta: 25,
                depth: 110 
            }*/
        },

        title: {
            text: ''
        },

        xAxis: {
			type : 'category',
			/*labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			},*/
            categories: cat
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            //tickInterval: 10,
            title: {
                text: ''
            }
        },
		tooltip: {
           // headerFormat: '<b>{point.key}</b><br>'
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y} </b></td></tr>',
			footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
				column: {
				pointPadding: 0.25,
				//colorByPoint: true,
				borderWidth: 0
				},
		series: {
			  pointWidth: 5,
			 // color: '#FF0000',
			 //stacking: 'normal',      
			  events:{
				   click: function (e) {
					//console.log(e.point.code);
					draw_new_graph_month(e.point.code);
				   
				  }
			  }
      }
        },
        series: res
    });
}
function draw_new_graph_month(facode){
 var year = '<?php echo $year;?>';
 var reportType = '<?php echo $reportType; ?>';
 var session_type = '<?php echo $vaccineBy; ?>';
 if(reportType == 'yearly'){
		 $.ajax({
			  type: "POST",
			  data: {year:year,reportType:reportType,facode:facode,session_type:session_type},
			  url: "<?php echo base_url(); ?>dashboard/SessionInformation/sessionInfoFacMonth",
			  dataType: "json",
			  success: function(result){
			   //console.log(result);
					newGM(result.serieses,result.category);
			  }
		 });
    }
	else{}
}
function newGM(res,cat){
	//alert("danish");
	
 $("html, body").delay(500).animate({
        scrollTop: $('#containerfacmonth').offset().top 
    }, 500);
	//console.log(cat);
	//console.log(res);
	$('#containerfacmonth').highcharts({
        chart: {
            type: 'column'/*,
            options3d: {
                enabled: true ,
                alpha: 5,
                beta: 25,
                depth: 110 
            }*/
        },

        title: {
            text: ''
        },

        xAxis: {
			type : 'category',
			/*labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			},*/
            categories: cat
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            //tickInterval: 10,
            title: {
                text: ''
            }
        },
		tooltip: {
           // headerFormat: '<b>{point.key}</b><br>'
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y} </b></td></tr>',
			footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
				column: {
				pointPadding: 0.2,
				//colorByPoint: true,
				borderWidth: 0
				},
		series: {
			  pointWidth: 13,
			 // color: '#FF0000',
			 //stacking: 'normal',
			  events:{
				   click: function (e) {
					//console.log(e.point.code);
					report_level_view(e.point.category,e.point.code);
				 }
			  }
      }
        },
        series: res
    });
}
function report_level_view(mon,cod){
	//alert(mon);
	var month = '0';
	var year = '<?php echo $year; ?>';
	//console.log(code);
	if(mon == "JANUARY")
		month = '01';
		else if(mon == "FEBRUARY")
			month = '02';
			else if(mon == "MARCH")
				month = '03';
				else if(mon == "APRIL")
					month = '04';
					else if(mon == "MAY")
						month = '05';
						else if(mon == "JUNE")
							month = '06';
							else if(mon == "JULY")
								month = '07';
								else if(mon == "AUGUST")
									month = '08';
									else if(mon == "SEPTEMBER")
										month = '09';
										else if(mon == "OCTOBER")
											month = '10';
											else if(mon == "NOVEMBER")
												month = '11';
												else if(mon == "DECEMBER")
													month = '12';
	var fmonth = year + "-" + month;
	var loc = "http://epimis1.pacetec.net/FLCF-MVRF/View/"+cod+"/"+fmonth;
	//alert(loc);
	location.href = loc;
}
	$(document).on('click','#report_type',function(){
		if($(this).val() == "yearly"){
			$('#monthDiv').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
		
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			
		}else{}
	});
$(document).ready(function(){
	 $("html, body").delay(500).animate({
        scrollTop: $('#container').offset().top 
    }, 500); 
	if($('input[name=report_type]:checked').val() == "yearly"){
		$('#monthDiv').hide();
		$('#month').val('');
		$('#month').removeAttr('required','required');
		//$('#quarterDiv').hide();
		//$('#quarter').removeAttr('required','required');
	}/*else if($('input[name=report_type]:checked').val() == "quarterly"){
		$('#monthDiv').hide();
		$('#month').removeAttr('required','required');
		$('#quarterDiv').show();
		$('#quarter').attr('required','required');
	}*/else if($('input[name=report_type]:checked').val() == "monthly"){
		$('#monthDiv').show();
		$('#month').attr('required','required');
		//$('#quarterDiv').hide();
		//$('#quarter').removeAttr('required','required');
	}else{}	
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