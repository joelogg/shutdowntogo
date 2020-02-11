//---------- Inicio Funciones para accionar el menu Lateral--------------
var togleBtnMenuLateral = true;
var anchoMenuLateral = "250px";
var anchoDelAccionar = 576; //ancho del accionar a modo tipo cel 

$("#btnToggleMenuLateral, #btnFlechaToggleMenuLateral, #fondoOscuro").click(function(e)
{
    if(window.innerWidth>anchoDelAccionar)
    {
        if(togleBtnMenuLateral)
        {
            ocultarMenuLateralPC();
            togleBtnMenuLateral = false;
        }
        else
        {
            mostrarMenuLateralPC();
            togleBtnMenuLateral = true;
        }
    }
    else
    {
        if(togleBtnMenuLateral)
        {
            ocultarMenuLateralMovil();
            togleBtnMenuLateral = false;
        }
        else
        {
            mostrarMenuLateralMovil();
            togleBtnMenuLateral = true;
        }
    }
})


$(window).resize(function() 
{
    accionResize() ;
});

function accionResize() 
{
    if(window.innerWidth> anchoDelAccionar )
    {
        if(!togleBtnMenuLateral)
        {
            ocultarMenuLateralPC();
        }
        else
        {
            mostrarMenuLateralPC();
        }
    }
    else
    {
        if(!togleBtnMenuLateral)
        {
            ocultarMenuLateralMovil();
        }
        else
        {
            mostrarMenuLateralMovil()
        }
    }
}

function verificarMostrarMenuLateral()
{
    if(window.innerWidth<anchoDelAccionar )
    {
        togleBtnMenuLateral = false;
    }
    accionResize()
}


if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) 
{
    togleBtnMenuLateral = false;

    if(togleBtnMenuLateral)
    {
        ocultarMenuLateralMovil();
    }
    else
    {
        mostrarMenuLateralMovil();
    }
}

function ocultarMenuLateralPC()
{
    document.getElementById("menuLateral").style.marginLeft = "-"+anchoMenuLateral;
    document.getElementById("contenidoVentana").style.marginLeft = "0";
    document.getElementById("contenidoVentana").style.width = "100%"; 
    document.getElementById("fondoOscuro").style.display = "none";
    document.getElementById("btnFlechaToggleMenuLateral").style.display = "none";

    document.getElementById("divListaOT").style.width = "100%"; 
    document.getElementById("divDetalleOT").style.width = "100%"; 
    document.getElementById("divDetalleOperaciones").style.width = "100%"; 
}

function mostrarMenuLateralPC()
{
    document.getElementById("menuLateral").style.marginLeft = 0;
    document.getElementById("contenidoVentana").style.marginLeft = anchoMenuLateral;
    document.getElementById("contenidoVentana").style.width = "calc(100% - "+anchoMenuLateral+")";
    document.getElementById("fondoOscuro").style.display = "none";
    document.getElementById("btnFlechaToggleMenuLateral").style.display = "none";

    document.getElementById("divListaOT").style.width = "calc( 100% - 250px)"; 
    document.getElementById("divDetalleOT").style.width = "calc( 100% - 250px)"; 
    document.getElementById("divDetalleOperaciones").style.width = "calc( 100% - 250px)"; 
}

function ocultarMenuLateralMovil()
{
    document.getElementById("menuLateral").style.marginLeft = "-"+anchoMenuLateral;
    document.getElementById("contenidoVentana").style.marginLeft = "0";
    document.getElementById("contenidoVentana").style.width = "100%";
    document.getElementById("fondoOscuro").style.display = "none";
    document.getElementById("btnFlechaToggleMenuLateral").style.display = "none";

    document.getElementById("divListaOT").style.width = "100%"; 
    document.getElementById("divDetalleOT").style.width = "100%"; 
    document.getElementById("divDetalleOperaciones").style.width = "100%";
}

function mostrarMenuLateralMovil()
{
    document.getElementById("menuLateral").style.marginLeft = 0;
    document.getElementById("contenidoVentana").style.marginLeft = "0";
    document.getElementById("contenidoVentana").style.width = "100%";
    document.getElementById("fondoOscuro").style.display = "block";
    document.getElementById("btnFlechaToggleMenuLateral").style.display = "block";

    document.getElementById("divListaOT").style.width = "100%"; 
    document.getElementById("divDetalleOT").style.width = "100%"; 
    document.getElementById("divDetalleOperaciones").style.width = "100%";
}

//---------- Fin Funciones para accionar el menu Lateral--------------