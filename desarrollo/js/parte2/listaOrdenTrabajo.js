
$(function() 
{
    $('#tablaOT').DataTable( {
        "ajax":
        {
            url: base_del_url+"desarrollo/phps/parte2/dataTablaOT.php",
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
        "order": [[ 3, 'asc' ], [ 4, 'desc' ]],
    } );  

});



function cargarListaOrdenTrabajo()
{
    $('#tablaOT').DataTable().ajax.reload();
}



function selectOT(id)
{
    console.log(id);
}





  