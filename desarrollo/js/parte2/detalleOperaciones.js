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

function cargarComentarios(idOp)
{
    console.log(idOp,5);

    var tarea = {creadopor:idUsuActual.toString() , proyecto_id: idProyectoGeneral.toString(), descripcion:descripcionTarea, equipo_id:null, prioridad_id:null, tipotarea:null, disciplina:null};
    tarea = JSON.stringify(tarea);
    
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/tareaCrear",
        data: {
            "json": tarea
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                
                
                console.log(rpta)
                document.getElementById('sectionComentariosOpe').innerHTML = rpta;
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