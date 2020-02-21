function colocarDatosOperacionesDetalle(idOp)
{
    idOpGeneral = idOp;
    for(i=0; i<operacionesLista.length; i++)
    {
        if(operacionesLista[i].id==idOp)
        {
            posOpGeneral = i;
            descripcion = operacionesLista[i].descripcion;
            numerooperacion = operacionesLista[i].numerooperacion;
            especialidad = operacionesLista[i].descripcionEspecialidad;
            work = operacionesLista[i].work;
            resources = operacionesLista[i].resources;
            duracion = operacionesLista[i].duracion;
            fechainicio = operacionesLista[i].fechainicio;
            fechafin = operacionesLista[i].fechafin;

            document.getElementById('nombreOperacion').innerHTML = descripcion + "(" + numerooperacion + ")";
            document.getElementById('fechaIniOperacion').innerHTML = fechainicio;
            document.getElementById('fechaFinOperacion').innerHTML = fechafin;

            document.getElementById('trabajoOperacion').innerHTML = work;
            document.getElementById('trabajoRecursos').innerHTML = resources;
            document.getElementById('trabajoDuracion').innerHTML = duracion;

            document.getElementById('EspecialdiadOperacion').innerHTML = especialidad;
            
            //participantes
            var participantes = operacionesLista[i].participantes;
            participantesIds = "" ;
            txtParticipantes = "";
            
            for(var j=0; j<participantes.length; j++)
            {
                txtParticipantes += participantes[j].nombre + " " + participantes[j].apellido + '<br>';
                participantesIds += participantes[j].id + ",";
            }

            if(txtParticipantes=="")
            {
                txtParticipantes = "Sin asignar"
            }
            editarParticipantesOp(participantesIds);

            cargarComentarios(idOp);
            return;
        }
    }
}

function editarParticipantesOp( participantesIds)
{
    
    //pasando los ids a array
    participantesIds = participantesIds.split(",");
    if(participantesIds[participantesIds.length-1]=="")//para eliminar el ulltimo elemento
    {
        participantesIds.splice(participantesIds.length-1,1);
    }

    //creando el select con los datos de los usuarios
    var txt = "";
    for (let i = 0; i < usuariosLista.length; i++) 
    {
        txt += '<option value="'+usuariosLista[i].id+'">'+usuariosLista[i].nombre+' '+usuariosLista[i].apellido+'</option> '
    }    
    document.getElementById('txtParticipantesOp').innerHTML = '<select id="selectParticipantes" class="select2-demo form-control" multiple style="width: 100%">'+txt+'</select>';

    //accionando el select de los usarios ya asisgnados
    for (let i = 0; i < participantesIds.length; i++) 
    {
        $("#selectParticipantes option[value='"+participantesIds[i]+"']").prop("selected",true);
    }

    //activando el select
    $('#selectParticipantes').each(function() {
        $(this)
          .wrap('<div id="divSelectParticipantes" class="position-relative" style"background-color:red;"></div>')
          .select2({
            placeholder: 'Seleccione',
            dropdownParent: $(this).parent()
          });
    })

    
    //funcion de change del select
    $("#selectParticipantes").on("change", cambiarParticipantesBD);
    
}

function cambiarParticipantesBD()
{
    var valuesId = $('#selectParticipantes').val();

    var valuesIdTxt = "";
    if(valuesId==null || valuesId=="") 
    {
        valuesId = [];
    }
    else
    {
        valuesIdTxt = valuesId.join(",");
    }
    
    var tarea = {"id":idOpGeneral, "participantes":valuesIdTxt};
    tarea = JSON.stringify(tarea);

    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/operacionEditar",
        data: {
            "token": token,
            "json": tarea
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                nuevosParticipantes = [];
                for (let i = 0; i < valuesId.length; i++) 
                {
                    for (let j = 0; j < usuariosLista.length; j++) 
                    {
                        if(usuariosLista[j].id == valuesId[i])
                        {
                            nuevosParticipantes.push(usuariosLista[j]);
                        }
                    }
                }
                operacionesLista[posOpGeneral].participantes = nuevosParticipantes;
                
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
                    mensajeAmarillo("Error cambiando participantes");
                }
            }
        },
        error: function(rpta)
        {
            mensajeAmarillo("Error de conexión");
        }
    });
}

// ----------- comentarios --------------
function fechaBDToWeb(fecha)
{
    fecha = fecha.split(" ");
    hora = fecha[1].split(":");
    fecha = fecha[0].split("-");
    return fecha[2]+"-"+fecha[1]+"-"+fecha[0]+" &nbsp;"+hora[0]+":"+hora[1];
}

function cargarComentarios(idOp)
{
    document.getElementById('sectionComentariosOpe').innerHTML = "";
    
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/comentariosPorIdOpe",
        data: {
            "idOp": idOp,
            "token": token
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                data = rpta.data

                var txt = '';
                for(i=0; i<data.length; i++)
                {
                    var nombre = data[i]["nombreUsu"].split(" ")[0];
                    var apellido = data[i]["apellidoUsu"].split(" ")[0];
                    var imagen = data[i]["imagenUsu"];
                    var fecha = data[i]["fechacreacion"];
                    var mensaje = data[i]["mensaje"];
                    var adjuntoNombre = data[i]["adjuntoNombre"];
                    var adjuntoExtension = data[i]["adjuntoExtension"];

                    if(imagen=="" || imagen==null)
                    {
                        imagen = '<button class="btn btnAvatarUsuario">'+nombre[0]+apellido[0]+'</button>';
                    }
                    else
                    {
                        imagen = '<img src="'+base_del_url+'adjuntos/usuarios/'+imagen+'" alt class="d-block ui-w-40 rounded-circle">';
                    }

                    fecha = fechaBDToWeb(fecha);

                    if(adjuntoNombre=="" || adjuntoNombre==null)
                    {
                        adjuntoNombre = '';
                    }
                    else
                    {
                        adjuntoNombre = '<img src="'+base_del_url+adjuntoNombre+'" alt class="imgAdjuComentarios">';
                    }

                    txt += '\
                            <div class="card car-chat">\
                            <div class="card-body">\
                                <div class="media">\
                                '+imagen+'\
                                    <div class="media-body ml-4">\
                                        <a href="javascript:void(0)">'+nombre+' '+apellido+'</a>\
                                        <div class="text-muted small">'+fecha+'</div>\
                                        <div class="mt-2">\
                                            '+mensaje+'\
                                        </div>\
                                        <div class="mt-2">\
                                            '+adjuntoNombre+'\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>';
                }
                document.getElementById('sectionComentariosOpe').innerHTML = txt;
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
                    mensajeAmarillo("Error de creación de tarea");
                }
            }
        },
        error: function(rpta)
        {
            //console.log(rpta);
            mensajeAmarillo("Error de conexión");
        }
    });
    
}