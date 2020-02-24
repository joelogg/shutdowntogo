$(function() 
{
    $('#calendarioFiltroGraficas').daterangepicker(
    {
        //autoApply: true,
        autoUpdateInput: false,
        locale: 
        {
            cancelLabel: 'Clear',
            format: "DD-MM-YYYY",
            applyLabel: "Aplicar",
            cancelLabel: "Cancelar",
            fromLabel: "De",
            toLabel: "Hasta",
            customRangeLabel: "Custom",
            weekLabel: "S",
            daysOfWeek: [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            monthNames: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
        },
    });

    $('#calendarioFiltroGraficas').on('apply.daterangepicker', function(ev, picker) 
    {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        document.getElementById('selectSemanaGrafios').value = "0";
    });
  
    $('#calendarioFiltroGraficas').on('cancel.daterangepicker', function(ev, picker) 
    {
        $(this).val('');
    });
 });




 function cambiarSemanaGrafico()
{
    document.getElementById('calendarioFiltroGraficas').value = "";
}

function filtrarDatosGrafico()
{
    fechaDesdeHasta = document.getElementById('calendarioFiltroGraficas').value;
    selectSemana = document.getElementById('selectSemanaGrafios').value;

    var fechaIni = ""
    var fechaFin = ""
    var semanaRevision = "";

    if(fechaDesdeHasta!="")
    {
        var fechas = fechaDesdeHasta.split(" ");
        fechaIni = fechas[0];
        fechaFin = fechas[2];
    }
    else if(selectSemana!="0")
    {
        if(selectSemana=="1")//hoy
        {
            var hoy = new Date();
            var dd = hoy.getDate();
            var mm = hoy.getMonth()+1;
            var yyyy = hoy.getFullYear();
            fechaIni = dd + "-" + mm + "-" + yyyy;
            fechaFin = dd + "-" + mm + "-" + yyyy;
        }
    }
    else
    {
        console.log("Filtrar por semana actual");
    }


    mostrarGraficaDashBoard(fechaIni, fechaFin, selectSemana);
}

function mostrarGraficaDashBoard(fechaIni, fechaFin, selectSemana)
{
    var dataEnviar = {"fechaIni":fechaIni , "fechaFin": fechaFin, "selectSemana":selectSemana};
    dataEnviar = JSON.stringify(dataEnviar);

    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/datosGrafica",
        data: {
            "token": token,
            "json": dataEnviar,
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                var data = rpta["data"]
                crearGraficoCompletado(data);
                crearGraficoEstatus(data);
                crearGraficoPrioridad(data);
                crearGraficoAreas(data);

            }
            else if(rpta.status == "error")
            {
                if(rpta.message == "token inválido")
                {
                    mensajeAmarillo("Su cuenta ha sido iniciada en otro dispositivo");
                    setTimeout(function() { location.replace(base_del_url); },4000);
                }
                else
                {
                    mensajeAmarillo("Error en carga gráficos");
                }
            }
        },
        error: function(rpta)
        {
            mensajeAmarillo("Error de conexión");
        }
    });

}

function crearGraficoCompletado(data)
{
    var numFinalziados  = 0;
    for (let i = 0; i < data.length; i++) 
    {
        if(data[i].estadoOT_id==3)
        {
            numFinalziados++;
        }
    }

    var porcentaje = numFinalziados/data.length*100;
    porcentaje = Math.round(porcentaje);
    
    c3.generate(
    {
        bindto: '#gauge_g1',
        data: 
        {
            columns: 
            [
                ['Finalizdo/Total  ('+numFinalziados + "/" + data.length+")", porcentaje]
            ],
            type: 'gauge'
        },
        tooltip: {
            format: {
                //title: function (d) { return 'Data ' + d; },
                value: function (value, ratio, id) 
                {
                    return value + "%";
                }
            }
        },
        color: 
        {
            //pattern: ['#2222AA']
        }
    });
}

function crearGraficoEstatus(data)
{
    var numFinalizados  = 0;
    var numAbiertas  = 0;
    var numEnProgreso  = 0;
    var numAtrasadas  = 0;
    var numReprogramadas  = 0;
    for (let i = 0; i < data.length; i++) 
    {
        if(data[i].atrasado==1)//atrasadas
        {
            numAtrasadas++;
        }
        else if(data[i].estadoOT_id==1)//abiertas
        {
            numAbiertas++;
        }
        else if(data[i].estadoOT_id==2)//en progreso
        {
            numEnProgreso++;
        }
        else if(data[i].estadoOT_id==3)//finalizadas
        {
            numFinalizados++;
        }
        else if(data[i].estadoOT_id==4)//reprogramadas
        {
            numReprogramadas++;
        }
    }


    c3.generate(
    {
        bindto: '#donut_g2',
        data: 
        {
            columns: 
            [
                [ 'Finalizadas', numFinalizados ],
                [ 'Abiertas', numAbiertas ],
                [ 'En progreso', numEnProgreso ],
                [ 'Atrasadas', numAtrasadas ],
                [ 'Reprogramadas', numReprogramadas ]
            ],
            type : 'donut',
            onclick: function (d, i) { console.log("onclick", d.index); },
            //onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            //onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        donut: { title: data.length+' OT' },
        tooltip: {
            format: {
                value: function (x, value, ratio, id) 
                {
                    return Math.round(value*100) + "% (" + x + "/" + data.length + ")";
                }
            }
        },
    });
}

function crearGraficoPrioridad(data)
{
    var finalizados  = ['Finalizadas', 0, 0, 0, 0];
    var abiertas  = ['Abiertas', 0, 0, 0, 0];
    var enProgreso  = ['En progreso', 0, 0, 0, 0];
    var atrasadas  = ['Atrasadas', 0, 0, 0, 0];
    var reprogramadas  = ['Reprogramadas', 0, 0, 0, 0];

    for (let i = 0; i < data.length; i++) 
    {
        if(data[i].atrasado==1)//atrasadas
        {
            atrasadas[data[i].prioridad_id]++;
        }
        else if(data[i].estadoOT_id==1)//abiertas
        {
            abiertas[data[i].prioridad_id]++;
        }
        else if(data[i].estadoOT_id==2)//en progreso
        {
            enProgreso[data[i].prioridad_id]++;
        }
        else if(data[i].estadoOT_id==3)//finalizadas
        {
            finalizados[data[i].prioridad_id]++;
        }
        else if(data[i].estadoOT_id==4)//reprogramadas
        {
            reprogramadas[data[i].prioridad_id]++;
        }
    }


    c3.generate(
    {
        bindto: '#bar_g3',
        data: 
        {
            x : 'x',
            columns: 
            [
                ['x', 'Muy alta', 'Alta', 'Media', 'Baja'],
                finalizados,
                abiertas,
                enProgreso,
                atrasadas,
                reprogramadas
            ],
            type: 'bar',
            groups: 
            [
                ['Abiertas','En progreso', 'Finalizadas', 'Atrasadas', 'Reprogramadas']
            ],
        },
        bar: 
        {
            //width: { ratio: 0.5 },
        },
        axis: 
        {
            rotated: true,
            x: 
            {
                type: 'category',
                tick: 
                {
                    multiline: true
                }
            },
        }
    });
}

function crearGraficoAreas(data)
{
    var areas = new Array();
    var j = 1;
    for (let i = 0; i < data.length; i++) 
    {
        if(areas[data[i].codigoArea]==null)
        {
            areas[data[i].codigoArea] = j;
            j++;
        }
    }


    var finalizados  = ['Finalizadas'];
    var abiertas  = ['Abiertas'];
    var enProgreso  = ['En progreso'];
    var atrasadas  = ['Atrasadas'];
    var reprogramadas  = ['Reprogramadas'];

    var ejeX = ['x']
    for(var clave in areas) 
    {
        ejeX.push(clave);
        finalizados.push(0);
        abiertas.push(0);
        enProgreso.push(0);
        atrasadas.push(0);
        reprogramadas.push(0);
    }


    

    for (let i = 0; i < data.length; i++) 
    {
        if(data[i].atrasado==1)//atrasadas
        {
            atrasadas[ areas[data[i].codigoArea] ]++;
        }
        else if(data[i].estadoOT_id==1)//abiertas
        {
            //abiertas[data[i].prioridad_id]++;
            abiertas[ areas[data[i].codigoArea] ]++;
        }
        else if(data[i].estadoOT_id==2)//en progreso
        {
            //enProgreso[data[i].prioridad_id]++;
            enProgreso[ areas[data[i].codigoArea] ]++;
        }
        else if(data[i].estadoOT_id==3)//finalizadas
        {
            //finalizados[data[i].prioridad_id]++;
            finalizados[ areas[data[i].codigoArea] ]++;
        }
        else if(data[i].estadoOT_id==4)//reprogramadas
        {
            //reprogramadas[data[i].prioridad_id]++;
            reprogramadas[ areas[data[i].codigoArea] ]++;
        }
    }


    c3.generate(
        {
            bindto: '#bar_g4',
            data: 
            {
                x : 'x',
                columns: 
                [
                    ejeX,
                    finalizados,
                    abiertas,
                    enProgreso,
                    atrasadas,
                    reprogramadas
                ],
                type: 'bar',
                groups: 
                [
                    ['Abiertas','En progreso', 'Finalizadas', 'Atrasadas', 'Reprogramadas']
                ],
            },
            bar: 
            {
                //width: { ratio: 0.2 },
            },
            axis: 
            {
                x: 
                {
                    type: 'category',
                    tick: 
                    {
                        multiline: true
                    }
                },
            }
        });

    
}



/*
chart.load({
        columns: [
            ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
            ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
            ["virginica", 2.5, 1.9, 2.1, 1.8, 2.2, 2.1, 1.7, 1.8, 1.8, 2.5, 2.0, 1.9, 2.1, 2.0, 2.4, 2.3, 1.8, 2.2, 2.3, 1.5, 2.3, 2.0, 2.0, 1.8, 2.1, 1.8, 1.8, 1.8, 2.1, 1.6, 1.9, 2.0, 2.2, 1.5, 1.4, 2.3, 2.4, 1.8, 1.8, 2.1, 2.4, 2.3, 1.9, 2.3, 2.5, 2.3, 1.9, 2.0, 2.3, 1.8],
        ]
    });


chart.unload({
        ids: 'data1'
    });
*/


