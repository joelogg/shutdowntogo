//cuando se hace click al boton CONTINUAR (Login)
function accionLogin() 
{
    var email = document.getElementById("email").value;
    var pwd = document.getElementById("pwd").value;

    if (email=="" || pwd =="") 
    {
        mensajeAmarillo("Completa tus datos");
    }
    else
    {


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                var responseJsonObj = this.responseText;
                var responseJsonObj = JSON.parse(responseJsonObj);
                
                
                if(responseJsonObj.status == "success")
                {
                    location.replace(base_del_url+"index.php/home/plataforma");
                }
                else if (responseJsonObj.status=="error") 
                {
                    if(responseJsonObj.message=="correo no existe")
                    {
                        mensajeAmarillo("Usuario incorrecto. Verifique su usuario");
                    }
                    else if(responseJsonObj.message=="contraseña incorrecta")
                    {
                        mensajeAmarillo("Contraseña incorrecto. Intenta nuevamente o recupera tu contraseña");
                    }
                    else
                    {
                        mensajeAmarillo("Error de conexión");
                    }
                }
            }
        };
        
        xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/enviarLogin.php?email="+email+"&pwd="+pwd, true); 
        xmlhttp.send();
    }
    
}


function recuperarContrasena() 
{
    location.replace(base_del_url+"index.php/home/recuperarContrasena")
}
