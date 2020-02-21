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
    idOTGeneral = idOT;
    for(var i=0; i<ordenesTrabajoLista.length; i++)
    {
        if(ordenesTrabajoLista[i].id==idOT)
        {
            posOTGeneral = i;
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
            
            for(var j=0; j<responsables.length; j++)
            {
                txtResponsables += responsables[j].nombre + " " + responsables[j].apellido + '<br>';
                responsablesIds += responsables[j].id + ",";
            }

            if(txtResponsables=="")
            {
                txtResponsables = "Sin asignar"
            }
            
            //document.getElementById('txtResponsableOT').innerHTML = '<span ondblclick="editarResponsableOT('+idOT+',`'+responsablesIds+'`)">'+txtResponsables+'</span>';
            editarResponsableOT(idOT, responsablesIds);
            document.getElementById('txtFechaInicioOT').innerHTML = ordenesTrabajoLista[i].fechainicio;
            document.getElementById('txtFechaVencimientoOT').innerHTML = ordenesTrabajoLista[i].fechafin;
            document.getElementById('txtAreaOT').innerHTML = ordenesTrabajoLista[i].descripcionArea;
            document.getElementById('txtEquipoOT').innerHTML = "(" + ordenesTrabajoLista[i].codigoEquipo + ") " + ordenesTrabajoLista[i].descripcionEquipo;
            
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
            finalizada = operacionesLista[i].finalizada;
            console.log(operacionesLista[i]);
            checkFinalizada = '';
            if(finalizada==1)
            {
                checkFinalizada = '<i class="fas fa-check"></i>';
            }

            bodyTablaOp += '\
                    <tr>\
                        <td onclick="v_seleccionarUnOperacion('+idO+')"><a href="#">('+numerooperacion+') '+descripcion+'</a></td>\
                        <td>'+especialidad+'</td>\
                        <td>'+work+' HH</td>\
                        <td>'+fechafin+'</td>\
                        <td>'+checkFinalizada+'</td>\
                        <td class="text-right"><button class="btn" onclick="v_seleccionarUnOperacion('+idO+')"><i class="ion ion-ios-arrow-forward" ></i></button></td>\
                    </tr>';
        }
    }


    document.getElementById('tablaOperaciones').innerHTML = bodyTablaOp;
}

function editarResponsableOT(idOT, responsablesIds)
{
    //pasando los ids a array
    responsablesIds = responsablesIds.split(",");
    if(responsablesIds[responsablesIds.length-1]=="")//para eliminar el ulltimo elemento
    {
        responsablesIds.splice(responsablesIds.length-1,1);
    }

    //creando el select con los datos de los usuarios
    var txt = "";
    for (let i = 0; i < usuariosLista.length; i++) 
    {
        txt += '<option value="'+usuariosLista[i].id+'">'+usuariosLista[i].nombre+' '+usuariosLista[i].apellido+'</option> '
    }    
    document.getElementById('txtResponsableOT').innerHTML = '<select id="selectResponsable" class="select2-demo form-control" multiple style="width: 100%">'+txt+'</select>';

    //accionando el select de los usarios ya asisgnados
    for (let i = 0; i < responsablesIds.length; i++) 
    {
        $("#selectResponsable option[value='"+responsablesIds[i]+"']").prop("selected",true);
    }

    //activando el select
    //$('#selectResponsable').select2();
    $('#selectResponsable').each(function() {
        $(this)
          //.wrap('<div id="divSelectResponsable" ondblclick="salirEdicionResponsables('+idOT+')" class="position-relative"></div>')
          .wrap('<div id="divSelectResponsable" class="position-relative"></div>')
          .select2({
            placeholder: 'Seleccione',
            dropdownParent: $(this).parent()
          });
    })

    
    //funcion de change del select
    $("#selectResponsable").on("change", cambiarResponsablesBD);
      
}
    
function salirEdicionResponsables(idOT)
{
    //var values = $('#selectResponsable').val();
    //console.log(values);
    var select  = document.getElementById("selectResponsable");
    var responsablesIds = "";
    var txtResponsables = "";

    var options = select && select.options;
    var opt;

    for (var i=0, iLen=options.length; i<iLen; i++) 
    {
        opt = options[i];
        if (opt.selected) 
        {
            responsablesIds += opt.value + ",";
            txtResponsables += opt.text + "<br>";
        }
    }

    document.getElementById('txtResponsableOT').innerHTML = '<span ondblclick="editarResponsableOT('+idOT+',`'+responsablesIds+'`)">'+txtResponsables+'</span>';
}
    
    
/*    
$(".select2-demo").on("select2:open", function (e) { console.log("open"); });
$(".select2-demo").on("select2:close", function (e) { console.log("close"); });
$(".select2-demo").on("select2:select", function (e) { console.log("select"); });
$(".select2-demo").on("select2:unselect", function (e) { console.log("unselec"); });
*/

function cambiarResponsablesBD()
{
    var valuesId = $('#selectResponsable').val();

    var valuesIdTxt = "";
    if(valuesId==null || valuesId=="") 
    {
        valuesId = [];
    }
    else
    {
        valuesIdTxt = valuesId.join(",");
    }
    
    var tarea = {"id":idOTGeneral, "responsable":valuesIdTxt};
    tarea = JSON.stringify(tarea);

    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/ordenTrabajoEditar",
        data: {
            "token": token,
            "json": tarea
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                nuevosResponsables = [];
                for (let i = 0; i < valuesId.length; i++) 
                {
                    for (let j = 0; j < usuariosLista.length; j++) 
                    {
                        if(usuariosLista[j].id == valuesId[i])
                        {
                            nuevosResponsables.push(usuariosLista[j]);
                        }
                    }
                }
                ordenesTrabajoLista[posOTGeneral].responsable = nuevosResponsables;
                cargarListaOrdenTrabajo();
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
                    mensajeAmarillo("Error cambiando responsables");
                }
            }
        },
        error: function(rpta)
        {
            mensajeAmarillo("Error de conexión");
        }
    });
}