/*!
* Pantalla graficos Dashboard Tickets Cl�nica D�vila
* Copyright 2013 Cl�nica D�vila.
* Developed by NsClick
* Legenda containers:       f1: Graficos fijos 1
*/


$(function () {
        $('#sw-cr-mes').highcharts({

            <!--- configuraciones generales de Grafico, como tipo , colores de fondo, posicion, etc.. //-->
            chart: {
            type: 'column',
           
            borderWidth: 2,
            borderRadius: 0,
            borderColor: '#e5e3e3',
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',               
            plotBorderWidth: 1,
            marginRight: 30,
            marginBottom: 70,
            marginLeft: 50
            },

            title: {
                text: 'Cantidad de Solicitudes'
            },

            <!--- configuraciones del eje x (con cariables php)//-->
            xAxis: {
                categories: [{{MESESSEMESTRE}}]
            },

            <!--- configuracion del eje y //-->
            yAxis: {
                min: 0,
                title: {
                    text: ' '
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },

            <!--- configuracion de la leyenda //-->
            legend: {           
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
                align: 'center'

            },

            <!--- muestra delalle al posicionar mouse sobre la barra a detallar //-->

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            credits: {
            enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            <!--- nombre de la serie y valores  (va con variables PHP)//-->
            series: [{
                name: 'FIN',
                data: [{{CANTRECLFINSEMESTRE}}],
                color:'#b4cc6a'
            }, {
                name: 'SOL',
                data: [{{CANTRECLSOLSEMESTRE}}],
                color:'#8ba353'
            }]
        });
    });

$(function () {
        $('#sw-tr-mes').highcharts({

            <!--- configuraciones generales de Grafico, como tipo , colores de fondo, posicion, etc.. //-->
            chart: {
            type: 'column',
           
            borderWidth: 2,
            borderRadius: 0,
            borderColor: '#e5e3e3',
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',               
            plotBorderWidth: 1,
            marginRight: 30,
            marginBottom: 70,
            marginLeft: 50
            },

            title: {
                text: 'Tiempo de Respuesta'
            },

            <!--- configuraciones del eje x (con cariables php)//-->
            xAxis: {
                categories: [{{MESESSEMESTRE}}]
            },

            <!--- configuracion del eje y //-->
            yAxis: {
                min: 0,
                title: {
                    text: ' '
                },
                stackLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },

            <!--- configuracion de la leyenda //-->
            legend: {           
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
                align: 'center'

            },

            <!--- muestra delalle al posicionar mouse sobre la barra a detallar //-->

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            credits: {
            enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            <!--- nombre de la serie y valores  (va con variables PHP)//-->
            series: [{
                name: '0-2',
                data: [{{CANTENTRE0Y30SEME}}],
                color:'#8ba353'
            }, {
                name: '3-5',
                data: [{{CANTENTRE30Y60SEME}}],
                color:'#fdf001'
            }, {
                name: 'Mayor a 5',
                data: [{{CANTMASDE60SEME}}],
                color:'#ff0000'
            }]
        });
    });



$(function () {
        $('#sw-sc-mes').highcharts({

            <!--- configuraciones generales de Grafico, como tipo , colores de fondo, posicion, etc.. //-->
            chart: {
            type: 'column',
           
            borderWidth: 2,
            borderRadius: 0,
            borderColor: '#e5e3e3',
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',               
            plotBorderWidth: 1,
            marginRight: 30,
            marginBottom: 70,
            marginLeft: 50
            },

            title: {
                text: 'Sub-Clasificacion'
            },

            <!--- configuraciones del eje x (con cariables php)//-->
            xAxis: {
                categories: [{{MESESSEMESTRE}}]
            },

            <!--- configuracion del eje y //-->
            yAxis: {
                min: 0,
                title: {
                    text: ' '
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },

            <!--- configuracion de la leyenda //-->
            legend: {           
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
                align: 'center'

            },

            <!--- muestra delalle al posicionar mouse sobre la barra a detallar //-->

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            credits: {
            enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            <!--- nombre de la serie y valores  (va con variables PHP)//-->
            series: [{
                name: 'RCE',
                data: [{{CANTRECLRCESEMESTRE}}],
                color:'#e46c0b'
            }, {
                name: 'Medisyn',
                data: [{{CANTRECLMSSEMESTRE}}],
                color:'#ff9c00'
            }]
        });
    });

$(function () {
        $('#sw-mt-mes').highcharts({

            <!--- configuraciones generales de Grafico, como tipo , colores de fondo, posicion, etc.. //-->
            chart: {
            type: 'column',
           
            borderWidth: 2,
            borderRadius: 0,
            borderColor: '#e5e3e3',
            plotBackgroundColor: 'rgba(255, 255, 255, .9)',               
            plotBorderWidth: 1,
            marginRight: 30,
            marginBottom: 70,
            marginLeft: 50
            },

            title: {
                text: 'Motivo - Tipo'
            },

            <!--- configuraciones del eje x (con cariables php)//-->
            xAxis: {
                categories: [{{MESESSEMESTRE}}]
            },

            <!--- configuracion del eje y //-->
            yAxis: {
                min: 0,
                title: {
                    text: ' '
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },

            <!--- configuracion de la leyenda //-->
            legend: {           
                floating: false,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false,
                align: 'center'

            },

            <!--- muestra delalle al posicionar mouse sobre la barra a detallar //-->

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                        'Total: '+ this.point.stackTotal;
                }
            },
            credits: {
            enabled: false
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: false,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
                }
            },
            <!--- nombre de la serie y valores  (va con variables PHP)//-->
            series: [{
                name: 'Error',
                data: [{{CANTRECLERRSEMESTRE}}],
                color:'#e46c0b'
            }, {
                name: 'Asesoria',
                data: [{{CANTRECLASESEMESTRE}}],
                color:'#30869d'
            }]
        });
    });