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
            responsablesIds = "" ;
            txtResponsables = "";

            for(i=0; i<responsables.length; i++)
            {
                txtResponsables += responsables[i].nombre + " " + responsables[i].apellido + '<br>';
                responsablesIds += responsables[i].id + ",";
            }
            
            console.log(responsablesIds);
            //document.getElementById('txtResponsableOT').innerHTML = '<span ondblclick="editarResponsableOT('+idOT+',`'+responsablesIds+'`)" style="background-color: red">'+txtResponsables+'</span>';
            document.getElementById('txtResponsableOT').innerHTML = '<span ondblclick="editarResponsableOT('+idOT+',`'+responsablesIds+'`)">'+txtResponsables+'</span>';
            document.getElementById('txtFechaInicioOT').innerHTML = ordenesTrabajoLista[i].fechainicio;
            document.getElementById('txtFechaVencimientoOT').innerHTML = ordenesTrabajoLista[i].fechafin;
            
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

function editarResponsableOT(idOT, responsablesIds)
{
    responsablesIds = responsablesIds.split(",");
    if(responsablesIds[responsablesIds.length-1]=="")//para eliminar el ulltimo elemento
        responsablesIds.splice(responsablesIds.length-1,1)

    console.log(idOT);
    console.log(responsablesIds);

    document.getElementById('txtResponsableOT').innerHTML = "dfdjs dskjd hjdh s<br>ss<br>ds";
}






