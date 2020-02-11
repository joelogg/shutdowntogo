function mensajeAmarillo(mensaje) 
{

	document.getElementById("pMensaje").innerHTML = mensaje;        
    $("#divMensaje").fadeIn(500);       
                 
    setTimeout(function() 
    {
        $("#divMensaje").fadeOut(500);
        document.getElementById("pMensaje").innerHTML = ""; 
    },3500);
}