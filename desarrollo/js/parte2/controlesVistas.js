//------ menu izquierdo -------
function v_seleccionarDashBoard()
{
    document.getElementById("btnPanelIzqDashBoard").classList.add('btnMenuIzquirdoActivo');
    document.getElementById("btnPanelIzqOrdTrabajo").classList.remove('btnMenuIzquirdoActivo');

    document.getElementById("divDashBoard").style.display  = 'block';
    document.getElementById("divOrdenesTrabajo").style.display  = 'none';

    mostrarGraficaDashBoard();
}

function v_seleccionarOrdenesTrabajo()
{
    document.getElementById("btnPanelIzqDashBoard").classList.remove('btnMenuIzquirdoActivo');
    document.getElementById("btnPanelIzqOrdTrabajo").classList.add('btnMenuIzquirdoActivo');

    document.getElementById("divDashBoard").style.display  = 'none';
    document.getElementById("divOrdenesTrabajo").style.display  = 'block';

    v_seleccionarListaOT();
    cargarListaOrdenTrabajo();
    //setTimeout(function(){ v_seleccionarUnaOT(4); }, 500);
    //v_seleccionarUnaOT(2);
    //v_seleccionarUnOperacion(1);
    //cargarComentarios(1);
}



//----------- ListaOT, DetalleOT, Operaciones --------
function v_seleccionarListaOT()
{
    document.getElementById("divDetalleOT").style.transform = "translate(0)";
    document.getElementById("divListaOT").style.transform = "translate(0%)";

}

function v_seleccionarUnaOT(idOT)
{
    document.getElementById("divListaOT").style.transform = "translate(-100%)";
    document.getElementById("divDetalleOT").style.transform = "translate(0)";
    colocarDatosOTDetalle(idOT);
}

function v_seleccionarUnOperacion(idOp)
{
    document.getElementById("divListaOT").style.transform = "translate(-100%)";
    document.getElementById("divDetalleOT").style.transform = "translate(-100%)";
    colocarDatosOperacionesDetalle(idOp);
}


//----------- Nav Opciones OT --------

function selectNavOpcGeneral()
{
    document.getElementById("idNavOpcGeneral").classList.add('activeNavOpciones');
    document.getElementById("idNavOpcOperaciones").classList.remove('activeNavOpciones');
}

function selectNavOpcOperaciones()
{
    document.getElementById("idNavOpcGeneral").classList.remove('activeNavOpciones');
    document.getElementById("idNavOpcOperaciones").classList.add('activeNavOpciones');
}

//----------- Nav Opciones Operaciones --------

function selectNavOpcCementatios()
{
    document.getElementById("idNavOpcComentarios").classList.add('activeNavOpciones');
}

