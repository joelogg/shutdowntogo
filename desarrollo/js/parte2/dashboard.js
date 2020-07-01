$(function() 
{
    $('#calendarioFiltroGraficas').daterangepicker(
    {
        autoApply: true,
        autoUpdateInput: false,
        locale: 
        {
            cancelLabel: 'Clear',
            format: "YYYY-MM-DD",
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
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
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

    if(fechaDesdeHasta!="")
    {
        var fechas = fechaDesdeHasta.split(" ");
        fechaIni = fechas[0] + " 00:00:00";
        fechaFin = fechas[2] + " 23:59:59";
    }
    else if(selectSemana!="0")
    {
        if(selectSemana=="1")//hoy
        {
            var hoy = new Date();
            var dd = hoy.getDate();
            var mm = hoy.getMonth()+1;
            var yyyy = hoy.getFullYear();
            fechaIni = yyyy + "-" + mm + "-" + dd + " 00:00:00";
            fechaFin = yyyy + "-" + mm + "-" + dd + " 23:59:59";
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
    listOTsFinalizadas = [];
    listOTsAbiertas = [];
    listOTsEnProgreso = [];
    listOTsAtrasadas = [];
    listOTsReprogramadas = [];

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
                separarOTGrafica(data);

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

    datosGraficaActual.g1 = {"numFinalziados": numFinalziados, "total": data.length, "porcentaje":porcentaje  } ;

    c3.generate(
    {
        bindto: '#gauge_g1',
        data: 
        {
            columns: 
            [
                ['Finalizado/Total  ('+numFinalziados + "/" + data.length+")", porcentaje]
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

var grafica2;
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

    datosGraficaActual.g2 = {'Finalizadas':numFinalizados, 'Abiertas': numAbiertas, 'En progreso': numEnProgreso, 'Atrasadas': numAtrasadas, 'Reprogramadas': numReprogramadas  } ;
    
    grafica2 = c3.generate(
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
            onclick: function (d, i) { mostrarOTGraficosSelect(d.index, data); realacionarGraficas(d.name, data); },
            //onmouseover: function (d, i) { resaltarGraficosSelect(d.index, data); },
            //onmouseout: function (d, i) { restarurarGraficosSelect(d.index, data); }
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

var grafica3;
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

    var nomDatosPrioridad = ['x', 'Muy alta', 'Alta', 'Media', 'Baja'];
    var contadorDatosPrioridad = [0, 0, 0, 0, 0]; 
    var listDatos = [atrasadas, abiertas, enProgreso, finalizados, reprogramadas];
    //obtener el maximo Y
    var maxY = "";
    var auxSuma = 0;
    for (let j = 1; j < atrasadas.length; j++)
    {
        auxSuma = 0;
        for (let i = 0; i < listDatos.length; i++) 
        {
            auxSuma += listDatos[i][j];
            contadorDatosPrioridad[j] += listDatos[i][j];
        }
        if(auxSuma>0 && auxSuma>maxY)
        {
            maxY = auxSuma;
        }
    }


    datosGraficaActual.g3 = {'datos':{'Finalizados':finalizados, 'Abiertas': abiertas, 'En progreso': enProgreso, 'Atrasadas': atrasadas, 'Reprogramadas': reprogramadas}, 'maxY':maxY  } ;
    
    grafica3 = c3.generate(
    {
        bindto: '#bar_g3',
        data: 
        {
            x : 'x',
            columns: 
            [
                nomDatosPrioridad,
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
        tooltip: {
            format: 
            {
                title: function (d) { return nomDatosPrioridad[d+1] + " (" + contadorDatosPrioridad[d+1] + ")"; },
            }
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
            y: 
            {
                max: maxY,
            }
        },
        legend: 
        {
            show: false
        }
    });
}

var grafica4;
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
    var contadorDatosAreas = [0]; 
    for(var clave in areas) 
    {
        if(clave=="null")
        {
            ejeX.push("Sin área");
        }
        else
        {
            ejeX.push(clave);
        }
        contadorDatosAreas.push(0);

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


    var listDatos = [atrasadas, abiertas, enProgreso, finalizados, reprogramadas];
    //obtener el maximo Y
    var maxY = "";
    var auxSuma = 0;
    for (let j = 1; j < atrasadas.length; j++)
    {
        auxSuma = 0;
        for (let i = 0; i < listDatos.length; i++) 
        {
            auxSuma += listDatos[i][j];
            contadorDatosAreas[j] += listDatos[i][j];
        }
        if(auxSuma>0 && auxSuma>maxY)
        {
            maxY = auxSuma;
        }
    }

    datosGraficaActual.g4 = {'datos':{'Finalizados':finalizados, 'Abiertas': abiertas, 'En progreso': enProgreso, 'Atrasadas': atrasadas, 'Reprogramadas': reprogramadas}, 'maxY':maxY  } ;
    console.log(datosGraficaActual.g4.datos);

    grafica4 = c3.generate(
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
                y: 
                {
                    max: maxY,
                }
            },
            tooltip: {
                format: 
                {
                    title: function (d) { return ejeX[d+1] + " (" + contadorDatosAreas[d+1] + ")"; },
                }
            },
            legend: 
            {
                show: false
            }
        });

    
}

function separarOTGrafica(data)
{
    listOTsFinalizadas = [];
    listOTsAbiertas = [];
    listOTsEnProgreso = [];
    listOTsAtrasadas = [];
    listOTsReprogramadas = [];

    for (let i = 0; i < data.length; i++) 
    {
        if(data[i].atrasado==1)//atrasadas
        {
            listOTsAtrasadas.push( [data[i].idOT, "(" + data[i].ordentrabajo + ") " + data[i].descripcionOT] );
        }
        else if(data[i].estadoOT_id==1)//abiertas
        {
            listOTsAbiertas.push( [data[i].idOT, "(" + data[i].ordentrabajo + ") " + data[i].descripcionOT] );
        }
        else if(data[i].estadoOT_id==2)//en progreso
        {
            listOTsEnProgreso.push( [data[i].idOT, "(" + data[i].ordentrabajo + ") " + data[i].descripcionOT] );
        }
        else if(data[i].estadoOT_id==3)//finalizadas
        {
            listOTsFinalizadas.push(  [data[i].idOT, "(" + data[i].ordentrabajo + ") " + data[i].descripcionOT] );
        }
        else if(data[i].estadoOT_id==4)//reprogramadas
        {
            listOTsReprogramadas.push( [data[i].idOT, "(" + data[i].ordentrabajo + ") " + data[i].descripcionOT] );
        }
    }
    mostrarOTGraficosSelect(3);
}


function mostrarOTGraficosSelect(index)
{
    var ordenesActual = [];
    if(index==0)//Finalizadas
    {
        document.getElementById('titOTsGraficasDashBoard').innerHTML = "ORDENES DE TRABAJO FINALIZADAS";
        ordenesActual = listOTsFinalizadas;
    }
    else if(index==1)//Abiertas
    {
        document.getElementById('titOTsGraficasDashBoard').innerHTML = "ORDENES DE TRABAJO ABIERTAS";
        ordenesActual = listOTsAbiertas;
    }
    else if(index==2)//En progreso
    {
        document.getElementById('titOTsGraficasDashBoard').innerHTML = "ORDENES DE TRABAJO EN PROGRESO";
        ordenesActual = listOTsEnProgreso;
    }
    else if(index==3)//Atrasadas
    {
        document.getElementById('titOTsGraficasDashBoard').innerHTML = "ORDENES DE TRABAJO ATRASADAS";
        ordenesActual = listOTsAtrasadas;
    }
    else if(index==4)//Reprogramadas
    {
        document.getElementById('titOTsGraficasDashBoard').innerHTML = "ORDENES DE TRABAJO REPROGRAMADAS";
        ordenesActual = listOTsReprogramadas;
    }
    

    var txt = "";
    for (let i = 0; i < ordenesActual.length; i++) 
    {
        txt += '<div class="divOTCritica" >\
                    <div class="titTareaCriticaDashboard" title="'+ordenesActual[i][1]+'" onclick="selectOTdesdeGraficas('+ordenesActual[i][0]+')">'+ordenesActual[i][1]+'</div>\
                    <div></div>\
                </div>';
    }

    document.getElementById('divOTsDashboard').innerHTML = txt;
}

var clickIdDona = "";
function realacionarGraficas(name, data)
{
    restarurarGraficosSelect(data);
    if(clickIdDona!=name)
    {
        resaltarGraficosSelect(name);
        clickIdDona = name;
    }
    else
    {
        clickIdDona = "";
    }

}



function selectOTdesdeGraficas(idOT)
{
    v_seleccionarOrdenesTrabajo();
    v_seleccionarUnaOT(idOT);
}

function resaltarGraficosSelect(name)
{
    if(name=="Finalizadas")//Finalizadas
    {
        grafica3.unload({ids: ['Abiertas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
        grafica4.unload({ids: ['Abiertas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
    }
    else if(name=="Abiertas")//Abiertas
    {
        grafica3.unload({ids: ['Finalizadas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
        grafica4.unload({ids: ['Finalizadas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
    }
    else if(name=="En progreso")//En progreso
    {
        grafica3.unload({ids: ['Finalizadas', 'Abiertas', 'Atrasadas', 'Reprogramadas'] });
        grafica4.unload({ids: ['Finalizadas', 'Abiertas', 'Atrasadas', 'Reprogramadas'] });
    }
    else if(name=="Atrasadas")//Atrasadas
    {
        grafica3.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Reprogramadas'] });
        grafica4.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Reprogramadas'] });
    }
    else if(name=="Reprogramadas")//Reprogramadas
    {
        grafica3.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Atrasadas'] });
        grafica4.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Atrasadas'] });
    }
    else
    {
        grafica3.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
        grafica4.unload({ids: ['Finalizadas', 'Abiertas', 'En progreso', 'Atrasadas', 'Reprogramadas'] });
    }

}

function restarurarGraficosSelect(data)
{
    crearGraficoPrioridad(data);
    crearGraficoAreas(data);
}









function exportarKPIs()
{
    datosGraficaActualEnviar = JSON.stringify(datosGraficaActual);
    
    
    var mapForm = document.createElement("form");
    mapForm.target = "Map";//
    mapForm.enctype = "multipart/form-data";//
    mapForm.method = "POST"; // or "post" if appropriate
    mapForm.action = base_del_url_miApi+"home/descargarKPIs_PDF";
    
    var tokenInput = document.createElement("input");
    tokenInput.type = "hidden";
    tokenInput.name = "token";
    tokenInput.value = token;
    mapForm.appendChild(tokenInput);

    var img1Input = document.createElement("textarea");
    img1Input.name = "imgKPIs";
    img1Input.innerHTML = datosGraficaActualEnviar;
    mapForm.appendChild(img1Input);

    document.body.appendChild(mapForm);    
    //map = window.open('', "Map", 'width=1100 height=800, left=0, top=0');
    map = window.open('', "Map");
    if (map) 
    {
        mapForm.submit();
    } 
    else 
    {
        alert('You must allow popups for this map to work.');
    }

}

