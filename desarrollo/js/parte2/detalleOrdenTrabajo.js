//Scrollbar
$(function() 
{
    new PerfectScrollbar(document.getElementById('divListaOT'));
    new PerfectScrollbar(document.getElementById('divDetalleOT'));
    new PerfectScrollbar(document.getElementById('divDetalleOperaciones'));
    
    new PerfectScrollbar(document.getElementById('divOpcionesDetalleOT'));
    new PerfectScrollbar(document.getElementById('divOpcionesDetalleOpe'));

});
  

function colocarDatosOTDetalle(idOT)
{
    for(var i=0; i<ordenesTrabajoLista.length; i++)
    {
        if(ordenesTrabajoLista[i].id==idOT)
        {
            document.getElementById('descripcionOT').innerHTML = ordenesTrabajoLista[i].descripcion + "(" + ordenesTrabajoLista[i].ordentrabajo + ")";
            document.getElementById('tipoOT').innerHTML = ordenesTrabajoLista[i].descripcionTipo;

            //Estado
            estado = "";
            if(ordenesTrabajoLista[i].estadoOT_id==4)
            {
                estado = '<span class="badge badge-danger badge-miIndicador">'+ordenesTrabajoLista[i].estado+'</span>'
            }
            else
            {
                estado = '<span class="badge badge-secondary badge-miIndicador">'+ordenesTrabajoLista[i].estado+'</span>'
            }
            document.getElementById('estadoOT').innerHTML = estado;

            //Prioridad
            document.getElementById('prioridadOT').innerHTML = '\
                    <span class="badge badge-miIndicador" style="background-color: #'+ordenesTrabajoLista[i].colorPrioridad+'; color: white">'+ordenesTrabajoLista[i].descripcionPrioridad+'</span>';

            //datos generales
            

            var responsables = ordenesTrabajoLista[i].responsable;
            txtResponsables = "";
            for(i=0; i<responsables.length; i++)
            {
                txtResponsables += responsables[i].nombre + " " + responsables[i].apellido + '<br>';
            }

            document.getElementById('tablaDatosGenerales').innerHTML = '\
                            <tr>\
                                <td>Responsable(s):</td>\
                                <td>'+txtResponsables+'</td>\
                            </tr>\
                            <tr>\
                                <td>Fecha Inicio:</td>\
                                <td>'+ordenesTrabajoLista[i].fechainicio+'</td>\
                            </tr>\
                            <tr>\
                                <td>Fecha Vencimiento:</td>\
                                <td>'+ordenesTrabajoLista[i].fechafin+'</td>\
                            </tr>';
            colocarOperacionesListaIdOT(idOT)
            return;
        }
    }
}

function colocarOperacionesListaIdOT(idOT)
{
    bodyTablaOp = "";

    for(i=0; i<operacionesLista.length; i++)
    {
        if(operacionesLista[i].ordenestrabajo_id==idOT)
        {
            idO = operacionesLista[i].id;
            descripcion = operacionesLista[i].descripcion;
            numerooperacion = operacionesLista[i].numerooperacion;
            especialidad = operacionesLista[i].descripcionEspecialidad;
            work = operacionesLista[i].work;
            fechafin = operacionesLista[i].fechafin;

            bodyTablaOp += '\
                    <tr>\
                        <td onclick="v_seleccionarUnOperacion('+idO+')"><a href="#">('+numerooperacion+') '+descripcion+'</a></td>\
                        <td>'+especialidad+'</td>\
                        <td>'+work+' HH</td>\
                        <td>'+fechafin+'</td>\
                        <td class="text-right"><button class="btn" onclick="v_seleccionarUnOperacion('+idO+')"><i class="ion ion-ios-arrow-forward" ></i></button></td>\
                    </tr>';
        }
    }


    document.getElementById('tablaOperaciones').innerHTML = bodyTablaOp;
}






