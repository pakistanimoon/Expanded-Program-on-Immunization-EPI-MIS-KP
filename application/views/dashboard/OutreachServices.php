<!--<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/zingcharts/zingchart.min.js"></script>
<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/"; ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script></head>
<div class="container">
	<form class="form-inline" method="post" action="<?php echo base_url(); ?>dashboard/OutreachServices">
		<?php $month = (isset($data['month']))?$data['month']:''; ?>
		<input type="radio" value="yearly" <?php echo (isset($reportType) && $reportType=="yearly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Yearly 
		<input type="radio" value="quarterly" <?php echo (isset($reportType) && $reportType=="quarterly")?'checked="checked"':''; ?> name="report_type" id="report_type" /> Quarterly 
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
		<div class="form-group" id="quarterDiv">
			<label>Quarter: </label>
			<select name="quarter" id="quarter" class="form-control">
				<option value="">Select</option>
				<option <?php echo (isset($quarter) && ($quarter == "01" || $quarter == "1"))?'selected="selected"':''; ?> value="01">First</option>
				<option <?php echo (isset($quarter) && ($quarter == "02" || $quarter == "2"))?'selected="selected"':''; ?> value="02">Second</option>
				<option <?php echo (isset($quarter) && ($quarter == "03" || $quarter == "3"))?'selected="selected"':''; ?> value="03">Third</option>
				<option <?php echo (isset($quarter) && ($quarter == "04" || $quarter == "4"))?'selected="selected"':''; ?> value="04">Fourth</option>
			</select>
		</div>
		<button type="submit">Preview</button>
	</form>
	<div id='myChart'></div>
</div>    	
<script type="text/javascript">
	
	var serieses = <?php echo $serieses; ?>;
	var condRate = <?php echo $condRate; ?>;
	var dropRate = <?php echo $dropRate; ?>;
	var total = <?php echo $totalPlanned; ?>;
	var conducted = <?php echo $totalConducted; ?>;
	var conductedRate = <?php echo round(($totalConducted/$totalPlanned)*100,2); ?>;
	var dropped = <?php echo $totalDropped; ?>;
	var droppedRate = <?php echo round(($totalDropped/$totalPlanned)*100,2); ?>;
	var categoriess = <?php echo $category; ?>;
    zingchart.THEME="classic";
    var myConfig = {
    "background-color":"#3F5666",
    "globals": {
      "font-family":"Arial",
      "font-weight":"normal"
    },
    "graphset":[
        {
            "type":"null",
            "x":"2.25%",
            "y":"1%",
            "background-color":"none",
            "title":{
                "text":"Outreach Services",
                "text-align":"left",
                "font-size":"18px",
                "font-color":"#ffffff",
                "background-color":"none"
            }
        },
        {
            "type":"pie",
            "height":"22%",
            "width":"30%",
            "x":"3%",
            "y":"4%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                "text":"<strong>Total Planned Sessions</strong>",
                "text-align":"left",
                "background-color":"none",
                "font-color":"#000000",
                "font-size":"13px",
                "offset-y":"10%",
                "offset-x":"10%"
            },
            "value-box":{
                "visible":true
            },
            "plotarea":{
                "margin":"20% 0% 0% 0%"
            },
            "plot":{
                "slice":50,
                "ref-angle":270,
                "detach":false,
                "hover-state":{
                    "visible":false
                },
                "value-box":{
                    "visible":true,
                    "type":"first",
                    "connected":false,
                    "placement":"center",
                    "text":"%v",
                    "rules":[
                        {
                            "visible":false
                        }
                    ],
                    "font-color":"#000000",
                    "font-size":"20px"
                },
                "tooltip":{
                    "rules":[
                        {
                            "rule":"%i == 0",
                            "text":"%v %t Planned",
                            "shadow":false,
                            "border-radius":4
                        }/* ,
                        {
                            //"rule":"%i == 1",
                            "text":"%v Remaining",
                            "shadow":false,
                            "border-radius":4
                        } */
                    ]
                },
                "animation":{
                    "delay":0,
                    "effect":2,
                    "speed":"600",
                    "method":"0",
                    "sequence":"1"
                }
            },
            "series":[
                {
                    "values":[total],
                    "text":"Sessions",
                    "background-color":"#00baf0",
                    "border-width":"0px",
                    "shadow":0
                }/* ,
                {
                    "values":[1148],
                    "background-color":"#dadada",
                    "alpha":"0.5",
                    "border-color":"#dadada",
                    "border-width":"1px",
                    "shadow":0
                } */
            ]
        },
        {
            "type":"pie",
            "height":"22%",
            "width":"30%",
            "x":"35%",
            "y":"4%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                //"text":"<strong>Distance</strong> / Miles",
                "text":"Sessions Conducted Rate",
				"text-align":"left",
                "background-color":"none",
                "font-color":"#000000",
                "font-size":"13px",
                "offset-y":"10%",
                "offset-x":"10%"
            },
            "value-box":{
                "visible":true
            },
            "plotarea":{
                "margin":"20% 0% 0% 0%"
            },
            "plot":{
                "slice":50,
                "ref-angle":270,
                "detach":false,
                "hover-state":{
                    "visible":false
                },
                "value-box":{
                    "visible":true,
                    "type":"first",
                    "connected":false,
                    "placement":"center",
                    "text":conductedRate+"%",
                    
                    "font-color":"#000000",
                    "font-size":"20px"
                },
                "tooltip":{
                    "rules":[
                        {
                            "rule":"%v == "+conducted,
                            "text":"%v %t Conducted",
                            "shadow":false,
                            "border-radius":4
                        },
                        {
                            "rule":"%v == "+dropped,
                            "text":"%v %t Dropped",
                            "shadow":false,
                            "border-radius":4
                        }
                    ]
                },
                "animation":{
                    "delay":0,
                    "effect":2,
                    "speed":"600",
                    "method":"0",
                    "sequence":"1"
                }
            },
            "series":[
                {
                    "values":[conducted],
                    "text":"Sessions",
                    "background-color":"#8AB839",
                    "border-width":"0px",
                    "shadow":0
                },
                {
                    "values":[dropped],
					"text":"Sessions",
                    "background-color":"#dadada",
                    "alpha":"0.5",
                    "border-color":"#dadada",
                    "border-width":"1px",
                    "shadow":0
                }
            ]
        },
        {
            "type":"pie",
            "height":"22%",
            "width":"30%",
            "x":"67%",
            "y":"4%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                "text":"Sessions Dropout Rate",
                "text-align":"left",
                "background-color":"none",
                "font-color":"#000000",
                "font-size":"13px",
                "offset-y":"10%",
                "offset-x":"10%"
            },
            "value-box":{
                "visible":true
            },
            "plotarea":{
                "margin":"20% 0% 0% 0%"
            },
            "plot":{
                "slice":50,
                "ref-angle":270,
                "detach":false,
                "hover-state":{
                    "visible":false
                },
                "value-box":{
                    "visible":true,
                    "type":"first",
                    "connected":false,
                    "placement":"center",
                    "text":droppedRate+"%",
                    /* "rules":[
                        {
							"rule":"%v < "+dropped,
                            "visible":false
                        }
                    ], */
                    "font-color":"#000000",
                    "font-size":"20px"
                },
                "tooltip":{
                    "rules":[
                        {
                            "rule":"%v == "+dropped,
                            "text":"%v %t Dropped",
                            "shadow":false,
                            "border-radius":4
                        },
                        {
                            "rule":"%v == "+conducted,
                            "text":"%v %t Conducted",
                            "shadow":false,
                            "border-radius":4
                        }
                    ]
                },
                "animation":{
                    "delay":0,
                    "effect":2,
                    "speed":"600",
                    "method":"0",
                    "sequence":"1"
                }
            },
            "series":[
                {
                    "values":[dropped],
                    "text":"Sessions",
                    "background-color":"#FF8A00",
                    "border-width":"0px",
                    "shadow":0
                },
                {
                    "values":[conducted],
					 "text":"Sessions",
                    "background-color":"#dadada",
                    "alpha":"0.5",
                    "border-color":"#dadada",
                    "border-width":"1px",
                    "shadow":0
                }
            ]
        },
        {
            "type":"bar",
            "height":"23%",
            "width":"94%",
            "x":"3%",
            "y":"27%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                "text":"Outreach Sessions",
                "text-align":"left",
                "font-size":"13px",
                "font-color":"#000000",
                "background-color":"none",
                "offset-x":"10%",
                "offset-y":"10%"
            },
            "legend":{
                "toggle-action":"remove",
                "layout":"x3",
                "x":"52.5%",
                "shadow":false,
                "border-color":"none",
                "background-color":"none",
                "item":{
                    "font-color":"#000000"
                },
                "marker":{
                    "type":"circle",
                    "border-width":0
                },
                "tooltip":{
                    "text":"%plot-description"
                    }
            },
            "tooltip":{
                "text":"%t<br><strong>%v</strong>",
                "font-size":"12px",
                "border-radius":4,
                "shadow":false,
                "callout":true,
                "padding":"5 10"
            },
            "plot":{
                "background-color":"#000000",
                "animation":{
                    "effect":"4"
                }
            },
            "plotarea":{
                "margin":"35% 3.5% 20% 7.5%"
            },
            "scale-x":{				
				// "values":["12AM","2AM","4AM","6AM","8AM","10AM","<strong>NOON</strong>","2PM","4PM","6PM","8PM","10PM","12AM"],
			    "values":categoriess,
                "line-color":"#adadad",
                "line-width":"1px",
                "item":{
					"font-angle":90,
                    "font-size":"10px",
                    "offset-y":"-2%"				
                },
                "guide":{
                    "visible":false
                },
                "tick":{
                    "visible":false
                }				
            },
            "scale-y":{
                "line-color":"none",
                "item":{
                    "font-size":"10px",
                    "offset-x":"2%"
                },
                "guide":{
                    "line-style":"solid",
                    "line-color":"#adadad"
                },
                "tick":{
                    "visible":false
                }
            },
			"series": serieses
        },
        {
            "type":"bar",
            "height":"23%",
            "width":"94%",
            "x":"3%",
            "y":"51%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                "text":"Sessions Conducted Rates",
                "text-align":"left",
                "font-size":"13px",
                "font-color":"#000000",
                "background-color":"none",
                "offset-x":"10%",
                "offset-y":"10%"
            },
            "legend":{
                "toggle-action":"remove",
                "layout":"x3",
                "x":"52.5%",
                "shadow":false,
                "border-color":"none",
                "background-color":"none",
                "item":{
                    "font-color":"#000000"
                },
                "marker":{
                    "type":"circle",
                    "border-width":0
                },
                "tooltip":{
                    "text":"%plot-description"
                    }
            },
            "tooltip":{
                "text":"%t<br><strong>%v</strong>",
                "font-size":"12px",
                "border-radius":4,
                "shadow":false,
                "callout":true,
                "padding":"5 10"
            },
            "plot":{
                "background-color":"#000000",
                "animation":{
                    "effect":"4"
                }
            },
            "plotarea":{
                "margin":"35% 3.5% 20% 7.5%"
            },
            "scale-x":{				
				// "values":["12AM","2AM","4AM","6AM","8AM","10AM","<strong>NOON</strong>","2PM","4PM","6PM","8PM","10PM","12AM"],
			    "values":categoriess,
                "line-color":"#adadad",
                "line-width":"1px",
                "item":{
					"font-angle":90,
                    "font-size":"10px",
                    "offset-y":"-2%"				
                },
                "guide":{
                    "visible":false
                },
                "tick":{
                    "visible":false
                }				
            },
            "scale-y":{
               "values":"0:100",
				"format":"%v"
                
            },
			"series": condRate
        },
        {
            "type":"bar",
            "height":"23%",
            "width":"94%",
            "x":"3%",
            "y":"75%",
            "background-color":"#ffffff",
            "border-radius":4,
            "title":{
                "text":"Sessions Dropout Rates",
                "text-align":"left",
                "font-size":"13px",
                "font-color":"#000000",
                "background-color":"none",
                "offset-x":"10%",
                "offset-y":"10%"
            },
            "legend":{
                "toggle-action":"remove",
                "layout":"x3",
                "x":"52.5%",
                "shadow":false,
                "border-color":"none",
                "background-color":"none",
                "item":{
                    "font-color":"#000000"
                },
                "marker":{
                    "type":"circle",
                    "border-width":0
                },
                "tooltip":{
                    "text":"%plot-description"
                    }
            },
            "tooltip":{
                "text":"%t<br><strong>%v</strong>",
                "font-size":"12px",
                "border-radius":4,
                "shadow":false,
                "callout":true,
                "padding":"5 10"
            },
            "plot":{
                "background-color":"#000000",
                "animation":{
                    "effect":"4"
                }
            },
            "plotarea":{
                "margin":"35% 3.5% 20% 7.5%"
            },
            "scale-x":{				
				// "values":["12AM","2AM","4AM","6AM","8AM","10AM","<strong>NOON</strong>","2PM","4PM","6PM","8PM","10PM","12AM"],
			    "values":categoriess,
                "line-color":"#adadad",
                "line-width":"1px",
                "item":{
					"font-angle":90,
                    "font-size":"10px",
                    "offset-y":"-2%"				
                },
                "guide":{
                    "visible":false
                },
                "tick":{
                    "visible":false
                }				
            },
            "scale-y":{
                
				"line-color":"none",
                "item":{
                    "font-size":"10px",
                    "offset-x":"2%"
                },
                "guide":{
                    "line-style":"solid",
                    "line-color":"#adadad"
                },
                "tick":{
                    "visible":false
                },
				"labels": ["0","20","40","60","80","100"]
            },
			"series": dropRate
        }
    ]
    };
     
    zingchart.render({ 
    	id : 'myChart', 
    	data : myConfig,
		height: 1600
    });
	$(document).on('click','#report_type',function(){
		if($(this).val() == "yearly"){
			$('#monthDiv').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else if($(this).val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
		}else if($(this).val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else{}
	});
	$(document).ready(function(){
		if($('input[name=report_type]:checked').val() == "yearly"){
			$('#monthDiv').hide();
			$('#month').val('');
			$('#month').removeAttr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else if($('input[name=report_type]:checked').val() == "quarterly"){
			$('#monthDiv').hide();
			$('#month').removeAttr('required','required');
			$('#quarterDiv').show();
			$('#quarter').attr('required','required');
		}else if($('input[name=report_type]:checked').val() == "monthly"){
			$('#monthDiv').show();
			$('#month').attr('required','required');
			$('#quarterDiv').hide();
			$('#quarter').removeAttr('required','required');
		}else{}	
	});
</script>