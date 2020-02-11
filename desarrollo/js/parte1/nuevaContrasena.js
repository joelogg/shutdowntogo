function verificarContrasena(pwd)
{
    var numero = false;
    var letra = false;

    if (pwd.length==0)
    {
        return true;
    }
    if (pwd.length<6)
    {
        return false;
    }

    for(i=0; i<pwd.length; i++)
    {
        caracter = pwd.charAt(i);
        ascii = caracter.toUpperCase().charCodeAt(0);

        if (ascii > 47 && ascii < 58)
        {
            numero = true;
        }
        if (ascii > 64 && ascii < 91)
        {
            letra = true;
        }
    }

    return (numero && letra);
}

//cuando se hace click al boton CONTINUAR (Login)
function crearContrasena() 
{
    var pwd = document.getElementById("pwd").value;
    var pwdConfirma = document.getElementById("pwdConfirma").value;
    

    if (pwd=="" || pwdConfirma =="") 
    {
        mensajeAmarillo("Completa los datos");
    }
    else if(pwd!=pwdConfirma)
    {
        mensajeAmarillo("Las contraseñas no coinciden");
    }
    else if (!verificarContrasena(pwd))
    {
        mensajeAmarillo("La contraseña debe 6 caracteres y de tener almenos una letra y un número");
    }
    else
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                var responseJsonObj = this.responseText;

                if (responseJsonObj=="error") 
                {
                    mensajeAmarillo("La url ya fué utilizada o ha caducado");
                }
                else
                {
                    location.replace(responseJsonObj);
                }
                
            }
        };
        
        xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/nuevaContrasena.php?pwd="+pwd+"&cod="+cod, true); 
        xmlhttp.send();
    }
    
}
