/*
    All Hightcharts 
*/

Highcharts.chart('container-week', {
    chart: {
        type: 'column'
    },
    title: {
        text: null
    },
//    subtitle: {
//        text: 'Source: WorldClimate.com'
//    },
    xAxis: {
        categories: [
            'Week-1',
            'Week-2',
            'Week-3'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Patient'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} Patient</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Confirmed',
        data: [20,14,3]

    }, {
        name: 'Negative',
        data: [3,2,4]

    }, {
        name: 'Awaited',
        data: [21,30,5]

    }, {
        name: 'Inconclusive',
        data: [8,3,9]

    }, {
        name: 'Death',
        data: [5,9,13]

    }]
});

/*
-----------------------------------------------------------
                    Pie Chart - 1
-----------------------------------------------------------
*/
Highcharts.chart('container-pie1', {
    chart: {
        type: 'pie',
        backgroundColor: '#f5f5f5',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Travel History of Confirm Cases',
         style: {
            fontWeight: 'bold',
            fontSize: '10px'
        }
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
     plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            fontSize: '9px'
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
            ['Quetta', 1.5],
            ['UAE', 2.2],
            ['NA', 16.7]
        ],
          dataLabels: {
                distance: -20,
                style: {
                    fontSize: 9,
                    fontWeight: 'normal'
                }
            },
    }],
 
});

/*
-----------------------------------------------------------
                    Pie Chart - 2
-----------------------------------------------------------
*/
Highcharts.chart('container-pie2', {
    chart: {
        type: 'pie',
        backgroundColor: '#f5f5f5',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
     colors: ['#74af46','#cd5a5d','#8e2326'],
    title: {
        text: 'Male Female Ratio',
         style: {
            fontWeight: 'bold',
            fontSize: '10px'
        }
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
     plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            fontSize: '9px'
        }
    },
    series: [{  
        type: 'pie',
        name: 'Browser share',
        data: [
            ['Male', 1.5],
            ['Female', 2.2]
        ],
         dataLabels: {
                distance: -30,
                style: {
                    fontSize: 9,
                    fontWeight: 'normal'
                }
            },
    }],
 
});

/*
-----------------------------------------------------------
                    Pie Chart - 3
-----------------------------------------------------------
*/
Highcharts.chart('container-pie3', {
    chart: {
        type: 'pie',
        backgroundColor: '#f5f5f5',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: 'Age Wise',
         style: {
            fontWeight: 'bold',
            fontSize: '10px'
        }
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
     plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            showInLegend: true,
            fontSize: '9px',
            Backgroundcolor: 'red'
        }
    },
    colors: ['#7090c5','#7d8383','#db934b','#74af46','#cd5a5d','#8e2326'],
    series: [{
        type: 'pie',
        name: 'Browser share',
        color:['red','green'],
        data: [
            ['1-18', 1.5],
            ['19-40', 2.2],
            ['41-70', 16.7],
            ['Above 70',50]
        ],
         dataLabels: {
             distance: -30,
                style: {
                    fontSize: 9,
                    fontWeight: 'normal'
                }
            },
    }],
 
});

