function colocarDatosOperacionesDetalle(idOp)
{

    for(i=0; i<operacionesLista.length; i++)
    {
        if(operacionesLista[i].id==idOp)
        {
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
            
            
            cargarComentarios(idOp);
            return;
        }
    }
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
                        adjuntoNombre = '<img src="'+base_del_url+'adjuntos/comentarios/'+idOp+'/'+adjuntoNombre+adjuntoExtension+'" alt class="imgAdjuComentarios">';
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