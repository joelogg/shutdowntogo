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


    grafica3 = c3.generate(
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





function eliminarEtiquetaSVG(txt)
{
    txt = txt.trim();
    txt = txt.trim();
    posMayorMenor = txt.indexOf(">");
    txt = txt.substr(posMayorMenor+1)
    posMayorMenor = txt.lastIndexOf("<");
    txt = txt.substr(0, posMayorMenor)
    return txt;
}


//transform="translate(10.5,4.5)"
function moverGrafico(txt, mx, my)
{
    /*txt = cambiarPosCentro(txt, mx, 'x="', 0);
    txt = cambiarPosCentro(txt, my, 'y="', 0);
    
    txt = cambiarPosCentro(txt, mx, 'cx="', 0);
    txt = cambiarPosCentro(txt, my, 'cy="', 0);
    
    txt = cambiarPosCentro(txt, mx, 'x1="', 0);
    txt = cambiarPosCentro(txt, my, 'y1="', 0);
    
    txt = cambiarPosCentro(txt, mx, 'x2="', 0);
    txt = cambiarPosCentro(txt, my, 'y2="', 0);*/
    
    txt = '<g transform="translate('+mx+','+my+')">' + txt + '</g>'

    return txt;
}




function svgToImg(divSVG, divCanvas, div)
{
    var doc1 = document.querySelector('#'+divSVG+' svg');   
    var svgString = new XMLSerializer().serializeToString(doc1);
    svgString = eliminarEtiquetaSVG(svgString);
    svgString = '<svg xmlns="http://www.w3.org/2000/svg" width="500" height="400" style="overflow: hidden;">\
    <g style="font-size: 14px; fill:#222;color: blue;fill-opacity:0.9;" >' 
    + svgString + '</g></svg>';
    
    var canvas = document.getElementById(divCanvas);
    canvas.innerHTML = "";
    canvas.value = "";
    var ctx = canvas.getContext("2d");
    var DOMURL = self.URL || self.webkitURL || self;
    var img = new Image();
    var svg = new Blob([svgString], {type: "image/svg+xml"});
    var url = DOMURL.createObjectURL(svg);

    var pngReal = "";

    img.onload = function() 
    {
        ctx.drawImage(img, 0, 0);
        var png = canvas.toDataURL("image/png");
        pngReal = canvas.toDataURL("image/png");
        
        var image = document.createElement('img');
    image.src=pngReal;
    image.width=100;
    image.height=100;
    image.alt="here should be some image";
    document.body.appendChild(image);

        document.querySelector('#'+div).innerHTML = '<img src="'+png+'"/>';
        DOMURL.revokeObjectURL(png);
    };
    img.src = url;
    
    
    return svg;
}


//convierte SVG a imagen
function svgString2Image(nomDivSVG, width, height, format, callback) 
{
    var doc1 = document.querySelector('#'+nomDivSVG+' svg');   
    var svgString = new XMLSerializer().serializeToString(doc1);
    svgString = eliminarEtiquetaSVG(svgString);
    svgString = '<svg xmlns="http://www.w3.org/2000/svg" width="500" height="400" style="overflow: hidden;">\
    <g style="font-size: 14px; fill:#222;color: blue;fill-opacity:0.9;" >' 
    + svgString + '</g></svg>';


    // set default for format parameter
    format = format ? format : 'png';
    // SVG data URL from SVG string
    var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // set canvas size
    canvas.width = width;
    canvas.height = height;
    // create image in memory(not in DOM)
    var image = new Image();
    // later when image loads run this
    image.onload = function () 
    { // async (happens later)
        // clear canvas
        context.clearRect(0, 0, width, height);
        // draw image with SVG data to canvas
        context.drawImage(image, 0, 0, width, height);
        // snapshot canvas as png
        var pngData = canvas.toDataURL('image/' + format);
        // pass png data URL to callback
        callback(pngData);
    }; // end async
    // start loading SVG data into in memory image
    image.src = svgData;
    return image;
}



function exportarKPIs()
{
    img0 = svgString2Image2("bar_g4", 400, 300, 'png', function (pngData) { });
    img01 = svgString2Image2("bar_g4", 400, 300, 'png', function (pngData) { });
    img1 = svgString2Image("gauge_g1", 400, 300, 'png', function (pngData) { });
    img2 = svgString2Image("donut_g2", 400, 300, 'png', function (pngData) { });
    img3 = svgString2Image("bar_g3", 400, 300, 'png', function (pngData) { });
    img4 = svgString2Image("bar_g4", 400, 300, 'png', function (pngData) { });
    


    var f = document.getElementById('TheFormExportKPI');
    f.token.value = token;
    f.imgKPI0.value = img0.src;
    f.imgKPI01.value = img0.src;
    f.imgKPI1.value = img1.src;
    f.imgKPI2.value = img2.src;
    f.imgKPI3.value = img3.src;
    f.imgKPI4.value = img4.src;
    f.submit();

    /*
    divImgExportKipPrueba = document.getElementById("divImgExportKipPrueba");
    
    var image = document.createElement('img');
    image.src=img0.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);

    var image = document.createElement('img');
    image.src=img01.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);

    var image = document.createElement('img');
    image.src=img1.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);

    var image = document.createElement('img');
    image.src=img2.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);

    var image = document.createElement('img');
    image.src=img3.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);

    var image = document.createElement('img');
    image.src=img4.src;
    image.width=200;
    image.height=200;
    image.alt="here should be some image";
    divImgExportKipPrueba.appendChild(image);
    */
}




function svgString2Image2(nomDivSVG, width, height, format, callback) 
{
    var svgString = '\
    <svg width="400" height="200">\
        <g style="font-size: 14px; fill:#222;color: blue;fill-opacity:0.9;">\
            <circle cx="26" cy="26" r="25" stroke="green" stroke-width="4" fill="yellow" />\
        </g>\
        \
        <rect x="55" y="0" rx="0" ry="25" width="150" height="150"\
        style="fill:red;stroke:black;stroke-width:5;opacity:0.5" />\
        <text x="0" y="170" fill="red">I love SVG!</text>\
    </svg>';


    // set default for format parameter
    format = format ? format : 'png';
    // SVG data URL from SVG string
    var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
    // create canvas in memory(not in DOM)
    var canvas = document.createElement('canvas');
    // get canvas context for drawing on canvas
    var context = canvas.getContext('2d');
    // set canvas size
    canvas.width = width;
    canvas.height = height;
    // create image in memory(not in DOM)
    var image = new Image();
    // later when image loads run this
    image.onload = function () 
    { // async (happens later)
        // clear canvas
        context.clearRect(0, 0, width, height);
        // draw image with SVG data to canvas
        context.drawImage(image, 0, 0, width, height);
        // snapshot canvas as png
        var pngData = canvas.toDataURL('image/' + format);
        // pass png data URL to callback
        callback(pngData);
    }; // end async
    // start loading SVG data into in memory image
    image.src = svgData;
    return image;
}

