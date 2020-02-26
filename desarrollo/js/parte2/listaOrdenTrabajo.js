
var filtrosOT = {"responsablesId":-1, "prioridadId":-1, "estatusId":-1, "areaId":-1, "fechaCod":-1};


$(function() 
{
    filtrosOT = JSON.stringify(filtrosOT);
    $('#tablaOT').DataTable( {
        "ajax":
        {
            url: base_del_url_miApi+"api/ordenTrabajoListarTodoDataTable",
            data: function(d){
                d.token = token;
                d.filtros = filtrosOT;
            },
            type : "post",
            dataType : "json",
            error: function(e){
                console.log("No cargo table");	
            }
        },
        scrollY: 300,
        language: {
            processing:     "Traitement en cours...",
            search:         "Buscar",
            lengthMenu:    "Ver _MENU_ OT",
            info:           "Mostrar de _START_ a _END_ de _TOTAL_ elementos",
            infoEmpty:      "Sin elementos",
            infoFiltered:   "(filtrado de _MAX_ elementos en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando...",
            zeroRecords:    "Sin datos en la tabla",
            emptyTable:     "Sin datos en la tabla",
            paginate: {
                first:      "Primero",
                previous:   "Previo",
                next:       "Siguiente",
                last:       "Último"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        },
        "order": [[ 3, 'asc' ]],
    } );  

});



function cargarListaOrdenTrabajo()
{
    $('#tablaOT').DataTable().ajax.reload();
}

function reinicarFiltros()
{
    filtrosOT = {"responsablesId":-1, "prioridadId":-1, "estatusId":-1, "areaId":-1, "fechaCod":-1};
    filtrosOT = JSON.stringify(filtrosOT);
    
    document.getElementById("selectFiltroResponsables").value = -1;
    document.getElementById("selectFiltroPrioridad").value = -1;
    document.getElementById("selectFiltroEstado").value =  -1;
    document.getElementById("selectFiltroArea").value = -1;
    document.getElementById("selectFiltroFecha").value = -1

    cargarListaOrdenTrabajo();
}

function selectOT(id)
{
    console.log(id);
}



function onchangeResponsablesFiltro()
{
    filtrosOT = JSON.parse(filtrosOT);
    filtrosOT.responsablesId = document.getElementById("selectFiltroResponsables").value;
    filtrosOT = JSON.stringify(filtrosOT);
    cargarListaOrdenTrabajo();
}

function onchangePrioridadFiltro()
{
    filtrosOT = JSON.parse(filtrosOT);
    filtrosOT.prioridadId = document.getElementById("selectFiltroPrioridad").value;
    filtrosOT = JSON.stringify(filtrosOT);
    cargarListaOrdenTrabajo();
}

function onchangeEstadoFiltro()
{
    filtrosOT = JSON.parse(filtrosOT);
    filtrosOT.estatusId = document.getElementById("selectFiltroEstado").value;
    filtrosOT = JSON.stringify(filtrosOT);
    cargarListaOrdenTrabajo();
}

function onchangeAreaFiltro()
{
    filtrosOT = JSON.parse(filtrosOT);
    filtrosOT.areaId = document.getElementById("selectFiltroArea").value;
    filtrosOT = JSON.stringify(filtrosOT);
    cargarListaOrdenTrabajo();
}

function onchangeFechaFiltro()
{
    filtrosOT = JSON.parse(filtrosOT);
    filtrosOT.fechaCod = document.getElementById("selectFiltroFecha").value;
    filtrosOT = JSON.stringify(filtrosOT);
    cargarListaOrdenTrabajo();
}





  