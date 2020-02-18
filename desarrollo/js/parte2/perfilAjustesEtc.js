$(function() 
{
    new PerfectScrollbar(document.getElementById('divTablaListusuarios'));
});

function cargarRoles()
{
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/perfilesListarTodo",
        data: {
            "token": token
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                data = rpta.data;
                perfiles = data;
                txt = "";

                for (var i = 0; i < data.length; i++) 
                {
                    id = data[i].id;
                    descripcion = data[i].descripcion;
                    if(id!=4)
                    {
                        txt += '<option value="' + id + '">' + descripcion + '</option>'
                    }
                }
                
                
                document.getElementById("selectPerfilesUsuarios").innerHTML = txt;
                
                
               
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
                    mensajeAmarillo("Error al cargar los roles");
                }
            }
        },
        error: function(rpta)
        {
            //console.log(rpta);
            mensajeAmarillo("Error de conexión roles");
        }
    });
}


function cerrarSesion()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            window.location = base_del_url;          
            
            token = "";
        }
    };
    
    xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/cerrarSesion.php", true); 
    xmlhttp.send();
}



//---------importar archivo de usuarios------
function clickSubirArchivoUsuarios() 
{
    var el = document.getElementById("fileCsvUsuarios");
    if (el) 
    {
        el.click();
    }
}

function parseCSVtoArray(text) 
{
    // Obtenemos las lineas del texto
    let lines = text.replace(/\r/g, '').split('\n');
    return lines.map(line => {
      // Por cada linea obtenemos los valores
      let values = line.split(';');
      return values;
    });
}

//despues q se selecciona un archivo
function handleFilesCsvUsuarios(files) 
{
    var d = document.getElementById("fileList");

    if (!files.length) 
    {
    }
    else
    {

        for (var i=0; i < files.length; i++) 
        {
            archico = files[i];      
        }

        
        document.getElementById("btnImportarUsuariosPre").style.display = "none";
        
        var file = $('#fileCsvUsuarios')[0].files[0];

        let reader = new FileReader();
        reader.onload = (e) => {
            document.getElementById("idTxtVistaPrevia").innerHTML = "Vista previa";
            // Cuando el archivo se terminó de cargar
            let linesArray = parseCSVtoArray(e.target.result);
            
            var tabla   = document.getElementById("listUsuariosPre");
            var tblBody = document.createElement("tbody");
            
            for (var i = 0; i < linesArray.length; i++) 
            {
                var hilera = document.createElement("tr");

                if( i==0)
                {
                    for (var j = 0; j < linesArray[i].length; j++) 
                    {
                        var celda = document.createElement("th");
                        var textoCelda = document.createTextNode(linesArray[i][j]);
                        celda.appendChild(textoCelda);
                        hilera.appendChild(celda);
                    }
                }
                else
                {
                    for (var j = 0; j < linesArray[i].length; j++) 
                    {
                        var celda = document.createElement("td");
                        var textoCelda = document.createTextNode(linesArray[i][j]);
                        celda.appendChild(textoCelda);
                        hilera.appendChild(celda);
                    }
                }
            
            
                tblBody.appendChild(hilera);
            }
            
            tabla.appendChild(tblBody);
        };
        // Leemos el contenido del archivo seleccionado
        reader.readAsBinaryString(file);



    }
}

function subirArchivoUsuarios()
{
    var formData = new FormData();
    if( $('#fileCsvUsuarios')[0].files.length >0)
    {

        var files = $('#fileCsvUsuarios')[0].files[0];
        formData.append('archivo',files);

        document.getElementById("fileCsvUsuarios").value = "";
        document.getElementById("btnImportarUsuariosPre").style.display = "inline";
        document.getElementById("listUsuariosPre").innerHTML = "";
        document.getElementById("idTxtVistaPrevia").innerHTML = "";


        $.ajax({
            async: true,
            crossDomain: true,
            type:'POST',
            url: base_del_url_miApi+"api/subirArchivoUsuarios",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            headers: {
                "token": token
            },
            success:function(data)
            {
                rpta = JSON.parse(data);
                if(rpta.status == "success")
                {
                    mensajeAmarillo("Usuarios importados correctamente");
                    selectUsuarios();
                }
                else if(rpta.status == "error")
                {
                    mensajeAmarillo("Error al importar los usuarios");
                }
            },
            error: function(data)
            {
                mensajeAmarillo("Error al importar los usuarios");
            }
            
        });
    }
}

//----------Usuarios usuarios--------

function selectUsuarios()
{
    $.ajax(
    {
        async: true,
        crossDomain: true,
        type:'POST',
        url: base_del_url_miApi+"api/usuariosListarTodo",
        data: {
            "token": token
          },
        success:function(rpta)
        {
            rpta = JSON.parse(rpta);
            
            if(rpta.status == "success")
            {
                data = rpta.data;
                usuariosLista = rpta.data;
                var tabla   = document.getElementById("tablaListusuarios");
                
                var txtTabla = "";

                for (var i = 0; i < data.length; i++) 
                {
                    imagen = data[i].imagen;
                    nombre = data[i].nombre;
                    apellido = data[i].apellido;
                    correo = data[i].correo;
                    descripcionPerfil = data[i].descripcionPerfil;
                    activo = data[i].activo;
                    

                    if(imagen == null || imagen == "")
                    {
                        if(nombre==null || nombre=="" || apellido==null || apellido=="")
                        {
                            imagen = '<div class="txtFotoPerfil">'+ correo.substr(0, 2) +'</div>';
                        }
                        else
                        {
                            imagen = '<div class="txtFotoPerfil">'+ nombre.substr(0, 1) + apellido.substr(0, 1) +'</div>';
                        }
                    }
                    else
                    {
                        imagen = '<img src="'+base_del_url+'adjuntos/usuarios/' + imagen + '" height="40" width="40" class="ui-w-40 rounded-circle" alt="">';
                    }

                    txtTabla += '<tr>';

                    txtTabla += '<td>';
                    txtTabla += imagen;
                    txtTabla += '</td>';

                    txtTabla += '<td>';
                    txtTabla += nombre + " " + apellido;
                    txtTabla += '</td>';

                    txtTabla += '<td>';
                    txtTabla += correo;
                    txtTabla += '</td>';

                    txtTabla += '<td>';
                    txtTabla += descripcionPerfil;
                    txtTabla += '</td>';

                    txtTabla += '<td>';
                    console.log(activo);
                    if(activo)
                    {
                        txtTabla += '<label class="switcher "> \
                                            <input type="checkbox" class="switcher-input" checked> \
                                            <span class="switcher-indicator"> \
                                                <span class="switcher-yes"></span> \
                                                <span class="switcher-no"></span> \
                                            </span> \
                                            <span class="switcher-label">Deshabilitar</span> \
                                        </label>';
                    }
                    else
                    {
                        txtTabla += '<label class="switcher "> \
                                            <input type="checkbox" class="switcher-input"> \
                                            <span class="switcher-indicator"> \
                                                <span class="switcher-yes"></span> \
                                                <span class="switcher-no"></span> \
                                            </span> \
                                            <span class="switcher-label">Habilitar</span> \
                                        </label>';
                    }
                    txtTabla += '</td>';

                    txtTabla += '<td>';
                    txtTabla += '<button class="btn"><i class="far fa-trash-alt"></i></button>';
                    txtTabla += '</td>';
                   

                    txtTabla += '</tr>';
                }
                
                tabla.innerHTML = txtTabla;

                cargarRoles();
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


function validarEmail(valor) 
{
    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    //Se muestra un texto a modo de ejemplo, luego va a ser un icono
    if (emailRegex.test(valor)) 
    {
        return true;
    } 
    else 
    {
        return false
    }
}

function inviatarUsuario()
{
    idPerfil = document.getElementById("selectPerfilesUsuarios").value;
    correo = document.getElementById("inputEmail").value;

    if(idPerfil=="" || correo=="")
    {
        mensajeAmarillo("Ingrese correo"); 
    }
    else if( !validarEmail(correo) )
    {
        mensajeAmarillo("Correo inválido");
    }
    else
    {
        var dataJsonEnviar = {"idPerfil":idPerfil , "correo": correo};
        dataJsonEnviar = JSON.stringify(dataJsonEnviar);

        $.ajax(
        {
            async: true,
            crossDomain: true,
            type:'POST',
            url: base_del_url_miApi+"api/enviarInvitacion",
            data: {
                "token": token,
                "json": dataJsonEnviar
            },
            success:function(rpta)
            {
                rpta = JSON.parse(rpta);
                
                if(rpta.status == "success")
                {
                    data = rpta.data;
                    mensajeAmarillo("Usuario creado");
                    selectUsuarios();
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
                        mensajeAmarillo("Error al cargar los roles");
                    }
                }
            },
            error: function(rpta)
            {
                //console.log(rpta);
                mensajeAmarillo("Error de conexión roles");
            }
        });
    }
    
}