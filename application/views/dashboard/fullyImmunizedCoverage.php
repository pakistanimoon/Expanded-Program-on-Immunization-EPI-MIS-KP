<div class="container">
	<form class="form-inline" method="post" action="<?php echo base_url(); ?>dashboard/FullyImmunizedCoverage">
		<?php
		//$vaccineId = 1;
		if(isset($data)){
			$reportType = $data['reportType'];
			$gender = $data['gender'];
			$month = (isset($data['month']))?$data['month']:'';
			$vaccineBy = $data['vaccineBy'];
		}
		?>
		<input type="radio" value="yearly" <?php echo (isset($reportType) && $reportType=="yearly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Commulative
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
		<div class="form-group">
			<label>Gender: </label>
			<select name="gender_wise" id="gender_wise" class="form-control" required="required">
				<option <?php echo (isset($gender) && $gender == "Male")?'selected="selected"':''; ?> value="Male">Male</option>
				<option <?php echo (isset($gender) && $gender == "Female")?'selected="selected"':''; ?> value="Female">Female</option>
				<option <?php echo (isset($gender) && $gender == "Both")?'selected="selected"':''; ?> <?php echo (!isset($gender))?'selected="selected':''; ?> value="Both">Both</option>
			</select>
		</div>
		<div class="form-group">
			<label>Vaccination by: </label>
			<select name="session_type" id="session_type" class="form-control" required="required">
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Fixed")?'selected="selected"':''; ?> value="Fixed">Fixed</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Outreach")?'selected="selected"':''; ?> value="Outreach">Outreach</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "Mobile")?'selected="selected"':''; ?> value="Mobile">Mobile</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "LHW")?'selected="selected"':''; ?> value="LHW">Health House</option>
				<option <?php echo (isset($vaccineBy) && $vaccineBy == "All")?'selected="selected"':''; ?> <?php echo (!isset($vaccineBy))?'selected="selected':''; ?> value="All">All</option>
			</select>
		</div>
		<button type="submit">Preview</button>
	</form>
	<div id="container" style="min-width: 310px;width:96%; height:350px; margin: 0 auto"></div>
	<div id="containerfac" style="min-width: 310px;width:96%; height:350px; margin: 0 auto"></div>
	<div id="containerfacmon" style="min-width: 310px;width:96%; height:350px; margin: 0 auto"></div>
</div>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
var chartGlobal = 0;
$(function () {
	var serieses = <?php echo $serieses; ?>;
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
                enabled: true/* ,
                alpha: 5,
                beta: 25,
                depth: 110 */
            }
        },

        title: {
            text: 'Fully Immunized Coverage'
        },

        xAxis: {
			type : 'category',
			labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			}
            //categories: [categoriess]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            tickInterval: 10,
            title: {
                text: 'Fully Immunized Coverage'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> '+'Fully Immunized Coverage'+': {point.y}%'
        },

        plotOptions: {
            column: {
				allowPointSelect: true,
                depth: 40,
				colorByPoint: true,
				dataLabels: {
                    enabled: true,
					format: '{y}%', // your label's value plus the percentage sign
                },
                enableMouseTracking: true
				//stacking: 'normal',
            },
			series: {
			  //pointWidth: 5,
			 // color: '#FF0000',
			 //stacking: 'normal',      
			  events:{
				   click: function (e) {
					//console.log(e.point.code);
					draw_new_graph_fac(e.point.code);
				   
				  }
			  }
      }
			
        },

        series: serieses
    });
	function draw_new_graph_fac(code){
		var report_type = '<?php echo $reportType; ?>'; 
		var gender_wise = '<?php echo $gender; ?>';		
		var month = '<?php echo	$month; ?>';		
		var session_type = '<?php echo $vaccineBy; ?>'; 
		var year = '<?php echo $year; ?>';
		//alert(code);
		$.ajax({
			type:"POST",
			data:{report_type:report_type,gender_wise:gender_wise,month:month,session_type:session_type,year:year,distcode:code},
			url:"<?php echo base_url(); ?>dashboard/FullyImmunizedCoverage",
			dataType: "json",
			success: function(result){
				//console.log(result);
				//console.log(result.category);
				shownewGraph(result.serieses,result.category);
			}
		});
	}
	function shownewGraph(currserieses,category){
		//console.log(currserieses);
		//alert("dani");
		$("html, body").delay(500).animate({
        scrollTop: $('#containerfac').offset().top 
    }, 500);
		    $('#containerfac').highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true/* ,
                alpha: 5,
                beta: 25,
                depth: 110 */
            }
        },

        title: {
            text: 'Facility Wise Fully Immunized Coverage'
        },

        xAxis: {
			type : 'category',
			labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			}
            //categories: [categoriess]
            //categories: category
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            tickInterval: 10,
            title: {
                text: 'Fully Immunized Coverage'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> '+'Fully Immunized Coverage'+': {point.y}%'
        },

        plotOptions: {
            column: {
				allowPointSelect: true,
                depth: 40,
				colorByPoint: true,
				dataLabels: {
                    enabled: true,
					format: '{y}%', // your label's value plus the percentage sign
                },
                enableMouseTracking: true
				//stacking: 'normal',
            },
			series: {
			  //pointWidth: 5,
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

        series: currserieses
    });
  }
function draw_new_graph_month(codee){
		var report_type = '<?php echo $reportType; ?>'; 
		var gender_wise = '<?php echo $gender; ?>';				
		var session_type = '<?php echo $vaccineBy; ?>'; 
		var year = '<?php echo $year; ?>';
		if(report_type == 'yearly'){
			$.ajax({
					type:"POST",
					data:{report_type:report_type,gender_wise:gender_wise,session_type:session_type,year:year,distcode:codee},
					url:"<?php echo base_url(); ?>dashboard/FullyImmunizedCoverage/monthData",
					dataType: "json",
					success: function(result){
						//console.log(result.serieses);
						shownewGraphMonth(result.serieses,result.category);
				}
			});
		}
}
function shownewGraphMonth(ser,category){
		//console.log(currserieses);
		//alert("dani");
		$("html, body").delay(500).animate({
        scrollTop: $('#containerfacmon').offset().top 
    }, 500);
		    $('#containerfacmon').highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true/* ,
                alpha: 5,
                beta: 25,
                depth: 110 */
            }
        },

        title: {
            text: 'Month Wise Fully Immunized Coverage'
        },

        xAxis: {
			type : 'category',
			/*labels: {
				step: 1,
				rotation : 90,
				reserveSpace : true
			},*/
            //categories: [categoriess]
            categories: category
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
           // max: 200,
            tickInterval: 10,
            title: {
                text: 'Fully Immunized Coverage'
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> '+'Fully Immunized Coverage'+': {point.y}%'
        },

        plotOptions: {
            column: {
				allowPointSelect: true,
                depth: 40,
				colorByPoint: true,
				dataLabels: {
                    enabled: true,
					format: '{y}%', // your label's value plus the percentage sign
                },
                enableMouseTracking: true
				//stacking: 'normal',
            },
			series: {
			  //pointWidth: 5,
			 // color: '#FF0000',
			 //stacking: 'normal',      
			  events:{
				   click: function (e) {
					//console.log(e.point.code);
					//draw_new_graph_month(e.point.code);
				   
				  }
			  }
      }
			
        },

        series: [ser]
    });
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
});
$(document).ready(function(){
	if($('input[name=report_type]:checked').val() == "yearly"){
		$('#monthDiv').hide();
		$('#month').val('');
		$('#month').removeAttr('required','required');
		
	}else if($('input[name=report_type]:checked').val() == "monthly"){
		$('#monthDiv').show();
		$('#month').attr('required','required');
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