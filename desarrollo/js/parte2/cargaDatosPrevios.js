$(function() 
{
    //Lista OT
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/ordenTrabajoListarTodo",
        data: {
            "token": token
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                data = rpta.data;
                ordenesTrabajoLista = rpta.data;
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
                    mensajeAmarillo("Error en carga ordenesTrabajo inicial");
                }
            }
        },
        error: function(rpta)
        {
            //console.log(rpta);
            mensajeAmarillo("Error de conexión");
        }
    });

    //Lista Operaciones
    $.ajax(
        {
            async: true,
            crossDomain: true,
            type:'POST',
            url: base_del_url_miApi+"api/operacionesListarTodo",
            data: {
                "token": token
              },
            success:function(rpta)
            {
                rpta = JSON.parse(rpta);
                
                if(rpta.status == "success")
                {
                    data = rpta.data;
                    operacionesLista = rpta.data;
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
                        mensajeAmarillo("Error en carga operaciones inicial");
                    }
                }
            },
            error: function(rpta)
            {
                //console.log(rpta);
                mensajeAmarillo("Error de conexión");
            }
        });
});