/*!
* Pantalla graficos Dashboard Tickets Cl�nica D�vila
* Copyright 2013 Cl�nica D�vila.
* Developed by NsClick
* Legenda containers:       f1: Graficos fijos 1
*/


$(function () {
        $('#sw-cr-anual').highcharts({

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
                categories: [{{MESESANIO}}]
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
                data: [{{CANTRECLFINANIO}}],
                color:'#b4cc6a'
            }, {
                name: 'SOL',
                data: [{{CANTRECLSOLANIO}}],
                color:'#8ba353'
            }]
        });
    });

$(function () {
        $('#sw-tr-anual').highcharts({

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
                categories: [{{MESESANIO}}]
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
                name: '0-30',
                data: [{{GRUPO1ANIO}}],
                color:'#8ba353'
            }, {
                name: '31-60',
                data: [{{GRUPO2ANIO}}],
                color:'#fdf001'
            }, {
                name: '61- mas de 61',
                data: [{{GRUPO3ANIO}}],
                color:'#ff0000'
            }]
        });
    });



$(function () {
        $('#sw-sc-anual').highcharts({

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
                categories: [{{MESESANIO}}]
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
                data: [{{CANTRECLRCEANIO}}],
                color:'#e46c0b'
            }, {
                name: 'Medisyn',
                data: [{{CANTRECLMSANIO}}],
                color:'#ff9c00'
            }]
        });
    });

$(function () {
        $('#sw-mt-anual').highcharts({

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
                categories: [{{MESESANIO}}]
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
                data: [{{MOTIVOERRANIO}}],
                color:'#e46c0b'
            }, {
                name: 'Asesoria',
                data: [{{MOTIVOASEANIO}}],
                color:'#30869d'
            }]
        });
    });