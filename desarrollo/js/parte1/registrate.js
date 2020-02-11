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


function uneteAlEquipo() 
{
    var inputNombres = document.getElementById("inputNombres").value;
    var inputApellidos = document.getElementById("inputApellidos").value;
    var pwd = document.getElementById("pwd").value;

    if (inputNombres=="" || inputApellidos=="" || pwd=="") 
    {
        mensajeAmarillo("Completa tus datos");
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
                    mensajeAmarillo("error");
                }
                else
                {
                    var dir = base_del_url+"index.php/home/bienvenido?nombres="+inputNombres+"&apellidos="+inputApellidos+"&pwd="+pwd+"&email="+email;
                    location.replace(dir);
                    
                }
                
            }
        };
        
        xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/editarYenviarLogin.php?nombres="+inputNombres+"&apellidos="+inputApellidos+"&pwd="+pwd+"&email="+email, true); 
        xmlhttp.send();
        
        
    }
}

