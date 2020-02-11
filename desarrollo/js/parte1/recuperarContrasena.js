//cuando se hace click al boton CONTINUAR (Login)
function accionEnviarEnlace() 
{
    var email = document.getElementById("email").value;

    if (email=="") 
    {
        mensajeAmarillo("Ingresa tu correo");
    }
    else
    {

        //var email = "christian.paredes.valdivia@gmail.com";
        //var pwd = "123456"


        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() 
        {
            if (this.readyState == 4 && this.status == 200) 
            {
                var responseJsonObj = this.responseText;
                
                if (responseJsonObj=="error") 
                {
                    mensajeAmarillo("Correo no registrado");
                }
                else
                {
                    location.replace(responseJsonObj);
                }
                
            }
        };
        
        xmlhttp.open("GET", base_del_url+"desarrollo/phps/parte1/enviarEnlace.php?email="+email, true); 
        xmlhttp.send();
    }
    
}
